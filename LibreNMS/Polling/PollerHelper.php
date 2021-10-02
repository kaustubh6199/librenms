<?php
/*
 * PollerHelper.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2021 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Polling;

use App\Models\Device;
use App\Models\DeviceOutage;
use LibreNMS\Config;
use LibreNMS\Data\Source\Fping;
use LibreNMS\Data\Source\FpingResponse;
use LibreNMS\RRD\RrdDefinition;
use Log;
use Symfony\Component\Process\Process;

/**
 * @property string $family
 */
class PollerHelper
{
    /**
     * @var \App\Models\Device
     */
    private $device;
    /**
     * @var bool
     */
    private $savePingPerf = false;

    public function __construct(Device $device)
    {
        $this->device = $device;
        $this->target = $device->overwrite_ip ?: $device->hostname;
    }

    public function savePingPerf()
    {
        $this->savePingPerf = true;
    }

    public function isUp(): bool
    {
        $previous = $this->device->status;
        $ping_response = $this->isPingable();

        // check status: both disabled or up = up, one down = down
        $this->device->status = $ping_response->success();
        if ($this->device->status) {
            // if up (or ping disabled), check snmp too
            $this->device->status = $this->device->snmp_disable || $this->isSNMPable();
            $this->device->status_reason = $this->device->status ? '' : 'snmp';
        } else {
            $this->device->status_reason = 'ping';
        }

        $this->updateAvailability($previous, $this->device->status);

        if ($this->savePingPerf && $this->canPing()) {
            $this->savePingStats($ping_response);
        }
        $this->device->save(); // confirm device is saved

        return $this->device->status;
    }

    /**
     * Check if the device responds to ICMP echo requests ("pings").
     */
    public function isPingable(): FpingResponse
    {
        if (! $this->canPing()) {
            return FpingResponse::artificialUp();
        }

        $status = app()->make(Fping::class)->ping(
            $this->target,
            Config::get('fping_options.count', 3),
            Config::get('fping_options.interval', 500),
            Config::get('fping_options.timeout', 500),
            $this->ipFamily()
        );

        if ($status->duplicates > 0) {
            Log::event('Duplicate ICMP response detected! This could indicate a network issue.', $this->device, 'icmp', 4);
            $status->exit_code = 0;   // when duplicate is detected fping returns 1. The device is up, but there is another issue. Clue admins in with above event.
        }

        return $status;
    }

    public function isSNMPable()
    {
        $response = \NetSnmp::device($this->device)->get('SNMPv2-MIB::sysObjectID.0');

        return $response->getExitCode() === 0 && $response->isValid();
    }

    public function traceroute()
    {
        $command = [Config::get('traceroute', 'traceroute'), '-q', '1', '-w', '1', $this->target];
        if ($this->ipFamily() == 'ipv6') {
            $command[] = '-6';
        }

        $process = new Process($command);
        $process->run();
        return [
            'traceroute' => $process->getOutput(),
            'output' => $process->getErrorOutput(),
        ];
    }

    public function canPing()
    {
        return Config::get('icmp_check') && ! ($this->device->exists && $this->device->getAttrib('override_icmp_disable') === 'true');
    }

    public function ipFamily(): string
    {
        if ($this->family === null) {
            $this->family = preg_match('/6$/', $this->device->transport) ? 'ipv6' : 'ipv4';
        }

        return $this->family;
    }

    private function updateAvailability($previous, $status): void
    {
        if (Config::get('graphing.availability_consider_maintenance') && $this->device->isUnderMaintenance()) {
            return;
        }

        // check for open outage
        $open_outage = $this->device->outages()->whereNull('up_again')->orderBy('going_down', 'desc')->first();

        if ($status) {
            if ($open_outage) {
                $open_outage->up_again = time();
                $open_outage->save();
            }
        } elseif ($previous || $open_outage === null) {
            // status changed from up to down or there is no open outage
            // open new outage
            $this->device->outages()->save(new DeviceOutage(['going_down' => time()]));
        }
    }

    /**
     * @param  \LibreNMS\Data\Source\FpingResponse  $ping_response
     */
    private function savePingStats(FpingResponse $ping_response): void
    {
        $perf = $ping_response->toModel();
        if (! $ping_response->success() && Config::get('debug.run_trace', false)) {
            $perf->debug = $this->traceroute();
        }
        $this->device->perf()->save($perf);
        $this->device->last_ping_timetaken = $ping_response->avg_latency ?: $this->device->last_ping_timetaken;
        $this->device->save();

        app('Datastore')->put($this->device->toArray(), 'ping-perf', [
            'rrd_def' => RrdDefinition::make()->addDataset('ping', 'GAUGE', 0, 65535),
        ], [
            'ping' => $ping_response->avg_latency,
        ]);

//        $os->enableGraph('ping_perf'); // FIXME
    }
}

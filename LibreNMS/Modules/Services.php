<?php
/**
 * Services.php
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @link       https://www.librenms.org
 *
 * @copyright  2022 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Modules;

use App\Http\Controllers\ServiceTemplateController;
use App\Models\Service;
use App\Observers\ModuleModelObserver;
use LibreNMS\Config;
use LibreNMS\Interfaces\Module;
use LibreNMS\Interfaces\ServiceCheck;
use LibreNMS\OS;
use LibreNMS\RRD\RrdDefinition;
use LibreNMS\Services\ServiceCheckResponse;
use Symfony\Component\Process\Process;

class Services implements Module
{

    public function discover(OS $os)
    {
        if (Config::get('discover_services_templates')) {
            (new ServiceTemplateController())->applyAll(); // FIXME applyAll() should not be on a controller
        }

        if (Config::get('discover_services')) {
            // FIXME: use /etc/services?
            $known_services = [
                22 => 'ssh',
                25 => 'smtp',
                53 => 'dns',
                80 => 'http',
                110 => 'pop',
                143 => 'imap',
            ];

            ModuleModelObserver::observe(Service::class);
            // Services
            $services = \SnmpQuery::enumStrings()->walk('TCP-MIB::tcpConnState')->mapTable(function ($data, $localAddress, $localPort) use ($os) {
                if ($data['TCP-MIB::tcpConnState'] == 'listen' && $localAddress == '0.0.0.0') {
                    if (isset($known_services[$localPort])) {
                        $service = $known_services[$localPort];
                        $new_service = Service::firstOrNew([
                            'device_id' => $os->getDeviceId(),
                            'service_ip' => $os->getDevice()->overwrite_ip ?: $os->getDevice()->hostname,
                            'service_type' => $service,
                        ], [
                            'service_name' => "AUTO: $service",
                            'service_desc' => "$service Monitoring (Auto Discovered)",
                            'service_changed' => time(),
                            'service_param' => '',
                            'service_ignore' => 0,
                            'service_disabled' => 0,
                            'service_status' => 3,
                            'service_message' => 'Service not yet checked',
                            'service_ds' => '{}',
                            'service_template_id' => 0
                        ]);

                        if (! $new_service->exists && $new_service->save()) {
                            \Log::event("Autodiscovered service: type $service", $os->getDevice(), 'service');
                        }
                    }
                }
            });
        }
    }

    public function poll(OS $os)
    {
        $device = $os->getDevice();
        /** @var Service $service */
        foreach ($device->services()->where('service_disabled', 0)->get() as $service) {
            $service_type = $service->service_type;
            $check_class = '\LibreNMS\Services\\' . ucfirst(strtolower($service_type));
            if (class_exists($check_class) && ($check_instance = new $check_class) instanceof ServiceCheck) {
                $command = $check_instance->buildCommand($device, $service);
            } else {
                $command = [
                    Config::get('nagios_plugins') . '/check_' . $service_type,
                    '-H',
                    $service->service_ip ?: $device->overwrite_ip ?: $device->hostname,
                ];
                $command = array_merge($command, is_array($service->service_param) ? $service->service_param : $this->sanitizeLegacyParams($service->service_param));
            }

            \Log::info("Nagios Service $service_type ($service->service_id)");
            $response = $this->checkService($command);
            \Log::debug("Service Response: $response->message");

            // If we have performance data we will store it.
            if (! empty ($response->metrics)) {
                $service->service_ds = array_map(function ($metric) { return $metric['uom']; }, $response->metrics);
                \Log::debug('Service DS: ' . json_encode($service->service_ds));

                $rrd_def = new RrdDefinition();
                $fields = [];
                foreach ($response->metrics as $key => $data) {
                    // c = counter type (exclude uptime)
                    $ds_type = ($data['uom'] == 'c') && ! (preg_match('/[Uu]ptime/', $key)) ? 'COUNTER' : 'GAUGE';
                    $rrd_def->addDataset($key, $ds_type, 0);

                    // prep update data
                    $fields[$key] = $data['value'];
                }

                app('Datastore')->put($os->getDeviceArray(), 'services', [
                    'service_id' => $service->service_id,
                    'rrd_name' => ['services', $service->service_id],
                    'rrd_def' => $rrd_def,
                ], $fields);
            }

            $service->save(); // save if changed
        }
    }

    public function cleanup(OS $os)
    {
        $os->getDevice()->services()->delete();
    }

    private function sanitizeLegacyParams(?string $params): array
    {
        if (empty($params)) {
            return [];
        }

        $parts = preg_split('~(?:\'[^\']*\'|"[^"]*")(*SKIP)(*F)|\h+~', trim($params));
        return array_map(function ($part) {
            $trimmed = preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $part);

            return escapeshellarg($trimmed);
        }, $parts);
    }

    private function checkService(array $command): ServiceCheckResponse
    {
        $process = new Process($command, null, ['LC_NUMERIC' => 'C']);
        $process->run();

        return new ServiceCheckResponse($process->getOutput(), $process->getExitCode());
    }


}

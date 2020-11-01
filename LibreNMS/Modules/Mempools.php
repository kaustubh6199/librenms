<?php
/*
 * Mempools.php
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
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Modules;

use App\Models\Mempool;
use Illuminate\Support\Collection;
use LibreNMS\DB\SyncsModels;
use LibreNMS\Interfaces\Discovery\MempoolsDiscovery;
use LibreNMS\Interfaces\Module;
use LibreNMS\Interfaces\Polling\MempoolsPolling;
use LibreNMS\OS;
use LibreNMS\RRD\RrdDefinition;
use LibreNMS\Util\ModuleModelObserver;

class Mempools implements Module
{
    use SyncsModels;

    public function discover(OS $os)
    {
        if ($os instanceof MempoolsDiscovery) {
            $mempools = $os->discoverMempools()->filter(function (Mempool $mempool) {
                if ($mempool->isValid()) {
                    return true;
                }
                d_echo("Rejecting Mempool $mempool->mempool_index $mempool->mempool_descr: Invalid total value");

                return false;
            });
            $this->calculateAvailable($mempools);

            ModuleModelObserver::observe('\App\Models\Mempool');
            $this->syncModels($os->getDevice(), 'mempools', $mempools);

            echo PHP_EOL;
            $mempools->each(function ($mempool) {
                $this->printMempool($mempool);
            });
        }
    }

    public function poll(OS $os)
    {
        [$ucd, $other] = $os->getDevice()->mempools
            ->partition('mempool_type', 'ucd');

        // poll UCD if exists.
        if ($ucd->isNotEmpty() && method_exists($os, 'pollUcdMempools')) {
            $os->pollUcdMempools($ucd);
        }

        if ($other->isNotEmpty()) {
            $os instanceof MempoolsPolling
                ? $os->pollMempools($other)
                : $this->defaultPolling($os, $other);
        }

        $this->calculateAvailable($os->getDevice()->mempools)
            ->each(function (Mempool $mempool) use ($os) {
                $this->printMempool($mempool);

                $mempool->save();

                $rrd_name = ['mempool', $mempool->mempool_type, $mempool->mempool_index];
                $rrd_def = RrdDefinition::make()
                ->addDataset('used', 'GAUGE', 0)
                ->addDataset('free', 'GAUGE', 0);
                $fields = [
                'used' => $mempool->mempool_used,
                'free' => $mempool->mempool_free,
            ];

                $tags = compact('mempool_type', 'mempool_index', 'rrd_name', 'rrd_def');
                data_update($os->getDeviceArray(), 'mempool', $tags, $fields);
            });
    }

    /**
     * @param OS $os
     * @param \Illuminate\Support\Collection $mempools
     * @return \Illuminate\Support\Collection
     */
    private function defaultPolling($os, $mempools)
    {
        // fetch all data
        $oids = $mempools->map->only(['mempool_perc_oid', 'mempool_used_oid', 'mempool_free_oid', 'mempool_total_oid'])
            ->flatten()->filter()->unique()->values()->all();
        $data = snmp_get_multi_oid($os->getDeviceArray(), $oids);

        $mempools->each(function (Mempool $mempool) use ($data) {
            $mempool->fillUsage(
                $data[$mempool->mempool_used_oid] ?? null,
                $data[$mempool->mempool_total_oid] ?? null,
                $data[$mempool->mempool_free_oid] ?? null,
                $data[$mempool->mempool_perc_oid] ?? null
            );
        });

        return $mempools;
    }

    public function cleanup(OS $os)
    {
        $os->getDevice()->mempools()->delete();
    }

    /**
     * Calculate available memory.  This is free + buffers + cached.
     *
     * @param  \Illuminate\Support\Collection  $mempools
     * @return \Illuminate\Support\Collection|void
     */
    private function calculateAvailable(Collection $mempools)
    {
        if ($mempools->count() > 2) { // optimization
            $system = null;
            $buffers = null;
            $cached = null;

            foreach ($mempools as $mempool) {
                /** @var Mempool $mempool */
                if ($mempool->mempool_class == 'system') {
                    if ($system !== null) {
                        d_echo('Aborted available calculation, too many system class mempools');

                        return $mempools; // more than one system, abort
                    }
                    $system = $mempool;
                } elseif ($mempool->mempool_class == 'buffers') {
                    if ($buffers !== null) {
                        d_echo('Aborted available calculation, too many buffers class mempools');

                        return $mempools; // more than one buffer, abort
                    }
                    $buffers = $mempool->mempool_used;
                } elseif ($mempool->mempool_class == 'cached') {
                    if ($cached !== null) {
                        d_echo('Aborted available calculation, too many cached class mempools');

                        return $mempools; // more than one cache, abort
                    }
                    $cached = $mempool->mempool_used;
                }
            }

            if ($system !== null) {
                $old = format_bi($system->mempool_free);
                $system->fillUsage(($system->mempool_used - $buffers - $cached) / $system->mempool_precision, $system->mempool_total / $system->mempool_precision);
                $new = format_bi($system->mempool_free);
                d_echo("Free memory adjusted by availability calculation: {$old}iB -> {$new}iB\n");
            }
        }

        return $mempools;
    }

    private function printMempool(Mempool $mempool)
    {
        echo "$mempool->mempool_type [$mempool->mempool_class]: $mempool->mempool_descr: $mempool->mempool_perc%";
        if ($mempool->mempool_total != 100) {
            $used = format_bi($mempool->mempool_used);
            $total = format_bi($mempool->mempool_total);
            echo "  {$used}iB / {$total}iB";
        }
        echo PHP_EOL;
    }
}

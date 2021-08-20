<?php
/**
 * Isis.php
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
 * @link       http://librenms.org
 * @copyright  2021 Otto Reinikainen
 * @author     Otto Reinikainen <otto@ottorei.fi>
 */

namespace LibreNMS\Modules;

use App\Models\IsisAdjacency;
use App\Observers\MempoolObserver;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use LibreNMS\DB\SyncsModels;
use LibreNMS\Interfaces\Discovery\IsIsDiscovery;
use LibreNMS\Interfaces\Module;
use LibreNMS\Interfaces\Polling\IsIsPolling;
use LibreNMS\OS;
use LibreNMS\OS\Junos;
use LibreNMS\Util\IP;

class Isis implements Module
{
    use SyncsModels;

    protected $isis_codes = [
        'l1IntermediateSystem' => 'L1',
        'l2IntermediateSystem' => 'L2',
        'l1L2IntermediateSystem' => 'L1L2',
        'unknown' => 'unknown',
    ];

    /**
     * Discover this module. Heavier processes can be run here
     * Run infrequently (default 4 times a day)
     *
     * @param  OS  $os
     */
    public function discover(OS $os)
    {
        $adjacencies = $os instanceof IsIsDiscovery
            ? $os->discoverIsIs()
            : $this->discoverIsIsMib($os);

        MempoolObserver::observe('\App\Models\IsIsAdjacency');
        $this->syncModels($os->getDevice(), 'isisAdjacencies', $adjacencies);
    }

    /**
     * Poll data for this module and update the DB / RRD.
     * Try to keep this efficient and only run if discovery has indicated there is a reason to run.
     * Run frequently (default every 5 minutes)
     *
     * @param  OS  $os
     */
    public function poll(OS $os)
    {
        $adjacencies = $os->getDevice()->isisAdjacencies;

        if (empty($adjacencies)) {
            return; // no data to poll
        }

        $updated = $os instanceof IsIsPolling
            ? $os->pollIsIs($adjacencies)
            : $this->pollIsIsMib($adjacencies, $os);

        $updated->each->save();
    }

    /**
     * Remove all DB data for this module.
     * This will be run when the module is disabled.
     *
     * @param  OS  $os
     */
    public function cleanup(OS $os)
    {
        $os->getDevice()->isisAdjacencies()->delete();
    }

    public function discoverIsIsMib(OS $os): Collection
    {
        // Check if the device has any ISIS enabled interfaces
        $circuits = snmpwalk_cache_oid($os->getDeviceArray(), 'ISIS-MIB::isisCirc', []);
        $adjacencies = new Collection;

        if (! empty($circuits)) {
            $adjacencies_data = snmpwalk_cache_twopart_oid($os->getDeviceArray(), 'ISIS-MIB::isisISAdj', [], null, null, '-OQUstx');
            $ifIndex_port_id_map = $os->getDevice()->ports()->pluck('port_id', 'ifIndex');

            // No ISIS enabled interfaces -> delete the component
            foreach ($circuits as $circuit_id => $circuit_data) {
                if (! isset($circuit_data['isisCircIfIndex'])) {
                    continue;
                }

                if ($os instanceof Junos && $circuit_id == 16) {
                    continue; // Do not poll loopback interface
                }

                $adjacency_data = Arr::last($adjacencies_data[$circuit_id] ?? [[]]);

                $adjacencies->push(new IsisAdjacency([
                    'device_id' => $os->getDeviceId(),
                    'ifIndex' => $circuit_data['isisCircIfIndex'],
                    'port_id' => $ifIndex_port_id_map[$circuit_data['isisCircIfIndex']] ?? null,
                    'isisCircAdminState' => $circuit_data['isisCircAdminState'],
                    'isisISAdjState' => $adjacency_data['isisISAdjState'] ?? $circuit_data['isisCircAdminState'],
                    'isisISAdjNeighSysType' => Arr::get($this->isis_codes, $adjacency_data['isisISAdjNeighSysType'] ?? null, 'unknown'),
                    'isisISAdjNeighSysID' => str_replace(' ', '.', trim($adjacency_data['isisISAdjNeighSysID'] ?? '')),
                    'isisISAdjNeighPriority' => $adjacency_data['isisISAdjNeighPriority'],
                    'isisISAdjLastUpTime' => $this->parseAdjacencyTime($adjacency_data),
                    'isisISAdjAreaAddress' => str_replace(' ', '.', trim($adjacency_data['isisISAdjAreaAddress'] ?? '')),
                    'isisISAdjIPAddrType' => $adjacency_data['isisISAdjIPAddrType'] ?? null,
                    'isisISAdjIPAddrAddress' => (string) IP::fromHexstring($adjacency_data['isisISAdjIPAddrAddress'] ?? null, true),
                ]));
            }
        }

        return $adjacencies;
    }

    public function pollIsIsMib(Collection $adjacencies, OS $os): Collection
    {
        $data = snmpwalk_cache_twopart_oid($os->getDeviceArray(), 'isisISAdjState', [], 'ISIS-MIB');

        if (count($data) !== $adjacencies->count()) {
            echo 'New Adjacencies, running discovery';
            // don't enable, might be a bad heuristic
            return $this->fillNew($adjacencies, $this->discoverIsIsMib($os));
        }

        $data = snmpwalk_cache_twopart_oid($os->getDeviceArray(), 'isisISAdjLastUpTime', $data, 'ISIS-MIB', null, '-OQUst');

        $adjacencies->each(function (IsisAdjacency $adjacency) use (&$data) {
            $adjacency_data = Arr::last($data[$adjacency->ifIndex]);
            $adjacency->isisISAdjState = $adjacency_data['isisISAdjState'];
            $adjacency->isisISAdjLastUpTime = $this->parseAdjacencyTime($adjacency_data);
            $adjacency->save();
            unset($data[$adjacency->ifIndex]);
        });

        return $adjacencies;
    }

    protected function parseAdjacencyTime($data): int
    {
        return (int) max($data['isisISAdjLastUpTime'] ?? 100, 1) / 100;
    }
}

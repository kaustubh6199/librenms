<?php
/*
 * PortSecurity.php
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
 * @copyright  2023 Michael Adams
 * @author     Michael Adams <mradams@ilstu.edu>
 */

namespace LibreNMS\Modules;

use App\Models\Device;
use Illuminate\Support\Facades\DB;
use LibreNMS\Config;
use LibreNMS\DB\SyncsModels;
use LibreNMS\Enum\PortAssociationMode;
use LibreNMS\Interfaces\Module;
use LibreNMS\Interfaces\Data\DataStorageInterface;
use LibreNMS\OS;
use LibreNMS\Polling\ModuleStatus;

class PortSecurity implements Module
{
    use SyncsModels;

    /**
     * @inheritDoc
     */
    public function dependencies(): array
    {
        return [];
    }

    public function shouldDiscover(OS $os, ModuleStatus $status): bool
    {
        return $status->isEnabledAndDeviceUp($os->getDevice());
    }

    /**
     * @inheritDoc
     */
    public function discover(OS $os): void
    {
        $this->poll($os, app('Datastore'));
    }

    public function shouldPoll(OS $os, ModuleStatus $status): bool
    {
        return $status->isEnabledAndDeviceUp($os->getDevice());
    }

    /**
     * Poll data for this module and update the DB
     *
     * @param  \LibreNMS\OS  $os
     */
    public function poll(OS $os, DataStorageInterface $datastore): void
    {
        $table = 'port_security';
        $port_id_field = 'port_id';
        $device_id_field = 'device_id';
        $sticky_macs_field = 'cpsIfStickyEnable';
        $max_macs_field = 'cpsIfMaxSecureMacAddr';
        $device = $os->getDeviceArray();
        if ($device['os'] == 'ios' || $device['os'] == 'iosxe') {
            echo 'Port Stats';
            $port_stats = [];
            $port_stats = snmpwalk_cache_oid($device, 'cpsIfStickyEnable', $port_stats, 'CISCO-PORT-SECURITY-MIB');
            $port_stats = snmpwalk_cache_oid($device, 'cpsIfMaxSecureMacAddr', $port_stats, 'CISCO-PORT-SECURITY-MIB');
            // End Building SNMP Cache Array

            // By default libreNMS uses the ifIndex to associate ports on devices with ports discoverd/polled
            // before and stored in the database. On Linux boxes this is a problem as ifIndexes may be
            // unstable between reboots or (re)configuration of tunnel interfaces (think: GRE/OpenVPN/Tinc/...)
            // The port association configuration allows to choose between association via ifIndex, ifName,
            // or maybe other means in the future. The default port association mode still is ifIndex for
            // compatibility reasons.
            $port_association_mode = Config::get('default_port_association_mode');
            print_r($port_association_mode);
            if ($device['port_association_mode']) {
                $port_association_mode = PortAssociationMode::getName($device['port_association_mode']);
            }

            // Build array of ports in the database and an ifIndex/ifName -> port_id map
            $ports_mapped = get_ports_mapped($device['device_id']);
            $ports_db = $ports_mapped['ports'];

            $default_port_group = Config::get('default_port_group');

            // Looping through all of the ports
            echo 'Updating DB';
            foreach ($port_stats as $ifIndex => $snmp_data) {
                $snmp_data['ifIndex'] = $ifIndex; // Store ifIndex in port entry
                // Get port_id according to port_association_mode used for this device
                $port_id = get_port_id($ports_mapped, $snmp_data, $port_association_mode);
                $device_id = $device['device_id'];
                // Needs to be an existing port. Checking if it's in the ports table
                $where = [[$port_id_field, '=', $port_id], [$device_id_field, '=', $device_id]];
                $output = DB::table('ports')->where($where)->get();
                $port_info = json_decode(json_encode($output), true);
                // Only concerned with physical ports
                if ($port_info[0]['ifType'] == 'ethernetCsmacd') {
                    // Checking if port already exists in port_security table. Update if yes, insert if not.
                    $port_sec_info = DB::table($table)->select($port_id_field, $device_id_field)->get();
                    $max_macs_value = $snmp_data['cpsIfMaxSecureMacAddr'];
                    $sticky_macs_value = $snmp_data['cpsIfStickyEnable'];
                    if ($port_sec_info) {
                        $update = [$sticky_macs_field => $sticky_macs_value, $max_macs_field => $max_macs_value];
                        $output = DB::table($table)->where($port_id_field, $port_id)->update($update);
                    } else {
                        $insert_info = [$port_id_field => $port_id, $device_id_field => $device_id, $sticky_macs_field => $sticky_macs_value, $max_macs_field => $max_macs_value];
                        $output = DB::table($table)->insert($insert_info);
                    }
                }
            }//end foreach

            // Clear Variables Here
            unset(
                $ports_mapped,
                $port_stats,
                $ports_db
            );

            echo "\n";
        }
    }

    /**
     * @inheritDoc
     */
    public function cleanup(Device $device): void
    {
        $device->portSecurity()->delete();
    }

    /**
     * @inheritDoc
     */
    public function dump(Device $device)
    {
        return [
            'PortSecurity' => $device->portSecurity()->orderBy('port_id')
                ->get()->map->makeHidden(['id', 'device_id']),
        ];
    }
}

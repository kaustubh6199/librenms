<?php
/**
 * Apsoluteos.php
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
 * @copyright  2017 Simone Fini
 * @author     Simone Fini<tomfordfirst@gmail.com>
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\OS;

use LibreNMS\Interfaces\Discovery\OSDiscovery;
use LibreNMS\OS;

class Apsoluteos extends OS implements OSDiscovery
{
    public function discoverOS(): void
    {
        $oids = ['genGroupHWVersion.0', 'rndSerialNumber.0', 'rndApsoluteOSVersion.0', 'rdwrDevicePortsConfig.0'];
        $data = snmp_get_multi($this->getDevice(), $oids, '-OQs', 'RADWARE-MIB');

        $device = $this->getDeviceModel();
        $device->serial = $data[0]['rndSerialNumber'] ?? null;
        $device->version = $data[0]['rndApsoluteOSVersion'] ?? null;
        $device->hardware = $data[0]['genGroupHWVersion'] ?? null;
        if (isset($data[0]['rdwrDevicePortsConfig'])) {
            $device->features = 'Ver. '.$data[0]['rdwrDevicePortsConfig'];
        }
    }
}

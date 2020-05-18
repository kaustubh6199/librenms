<?php
/**
 * Aos.php
 *
 * Alcatel-Lucent AOS
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\OS;

use Illuminate\Support\Str;
use LibreNMS\Device\Processor;
use LibreNMS\Interfaces\Discovery\OSDiscovery;
use LibreNMS\Interfaces\Discovery\ProcessorDiscovery;
use LibreNMS\OS;

class Aos extends OS implements OSDiscovery, ProcessorDiscovery
{
    public function discoverOS(): void
    {
        $device = $this->getDeviceModel();
        if (Str::contains($device->sysDescr, 'Enterprise')) {
            [, , $device->hardware, $device->version] = explode(' ', $device->sysDescr);
        } elseif (Str::contains($device->sysObjectID, '1.3.6.1.4.1.6486.800.1.1.2.2.4')) {
            $device->hardware = snmp_get($this->getDevice(), '.1.3.6.1.4.1.89.53.4.1.6.1', '-Osqv', 'RADLAN-Physicaldescription-MIB'); //RADLAN-Physicaldescription-MIB::rlPhdStackProductID
            $device->version = snmp_get($this->getDevice(), '.1.3.6.1.4.1.89.53.14.1.2.1', '-Osqv', 'RADLAN-Physicaldescription-MIB'); //RADLAN-Physicaldescription-MIB::rlPhdUnitGenParamSoftwareVersion
        } elseif (Str::contains($device->sysObjectID, ".1.3.6.1.4.1.6486.800.1.1.2.1.10")) {
            $sys = snmp_translate($device->sysObjectID, 'ALCATEL-IND1-DEVICES', null, null, $this->getDevice());
            preg_match('/deviceOmniSwitch(....)(.+)/', $sys, $model); // deviceOmniSwitch6400P24
            $device->hardware = 'OS' . $model[1] . '-' . $model[2];
            $device->version = $device->sysDescr;
        } else {
            [, $device->hardware, $device->version] = explode(' ', $device->sysDescr);
        }
    }

    /**
     * Discover processors.
     * Returns an array of LibreNMS\Device\Processor objects that have been discovered
     *
     * @return array Processors
     */
    public function discoverProcessors()
    {
        $processor = Processor::discover(
            'aos-system',
            $this->getDeviceId(),
            '.1.3.6.1.4.1.6486.800.1.2.1.16.1.1.1.13.0', // ALCATEL-IND1-HEALTH-MIB::healthDeviceCpuLatest
            0,
            'Device CPU'
        );

        if (!$processor->isValid()) {
            // AOS7 devices use a different OID for CPU load. Not all Switches have
            // healthModuleCpuLatest so we use healthModuleCpu1MinAvg which makes no
            // difference for a 5 min. polling interval.
            // Note: This OID shows (a) the CPU load of a single switch or (b) the
            // average CPU load of all CPUs in a stack of switches.
            $processor = Processor::discover(
                'aos-system',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.6486.801.1.2.1.16.1.1.1.1.1.11.0',
                0,
                'Device CPU'
            );
        }

        return array($processor);
    }
}

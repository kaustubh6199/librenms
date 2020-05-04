<?php
/**
 * gwd.php
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
 * @copyright  2020 hartred
 * @author     hartred <tumanov@asarta.ru>
 */
namespace LibreNMS\OS;

use Illuminate\Support\Str;
use LibreNMS\Device\Processor;
use LibreNMS\Interfaces\Discovery\ProcessorDiscovery;
use LibreNMS\OS;

class gwd extends OS implements ProcessorDiscovery
{
    /**
     * Discover processors.
     * Returns an array of LibreNMS\Device\Processor objects that have been discovered
     *
     * @return array Processors
     */
    public function discoverProcessors()
    {
        $device = $this->getDevice();

        if (Str::startsWith($device['sysObjectID'], '.1.3.6.1.4.1.10072.2.20.')) { //GFA6900s
            $oid = '.1.3.6.1.4.1.10072.2.20.1.1.2.1.1.19.1.1';
        };

        if (isset($oid)) {
            return array(
                Processor::discover(
                    $this->getName(),
                    $this->getDeviceId(),
                    $oid,
                    0
                )
            );
        }

        return array();
    }
}

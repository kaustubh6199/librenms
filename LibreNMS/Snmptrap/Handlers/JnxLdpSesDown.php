<?php
/**
 * JnxLdpSesDown.php
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
 * @link       https://www.librenms.org
 * @copyright  2018 KanREN, Inc.
 * @author     Neil Kahle <nkahle@kanren.net>
 */

namespace LibreNMS\Snmptrap\Handlers;

use App\Models\Device;
use LibreNMS\Interfaces\SnmptrapHandler;
use LibreNMS\Snmptrap\Trap;
use Log;

class JnxLdpSesDown implements SnmptrapHandler
{
    /**
     * Handle snmptrap.
     * Data is pre-parsed and delivered as a Trap.
     *
     * @param Device $device
     * @param Trap $trap
     * @return void
     */
    public function handle(Device $device, Trap $trap)
    {
        $state = $trap->getOidData($trap->findOid('JUNIPER-MPLS-LDP-MIB::jnxMplsLdpSesState'));
        $reason = $trap->getOidData($trap->findOid('JUNIPER-LDP-MIB::jnxLdpSesDownReason'));
        $ifIndex = $trap->getOidData($trap->findOid('JUNIPER-LDP-MIB::jnxLdpSesDownIf'));
        $port = $device->ports()->where('ifIndex', $ifIndex)->first();

        if (! $port) {
            Log::warning("Snmptrap LdpSesDown: Could not find port at ifIndex $port->ifIndex for device: " . $device->hostname);

            return;
        }

        Log::event("LDP session on interface $port->ifDescr is $state due to $reason", $device->device_id, 'trap', 4);
    }
}

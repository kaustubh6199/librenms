<?php
/**
 * Aos7portViolation.php
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
 * Alcatel configuration change trap. Includes interface used to affect
 * the change, the user, and the system time when the change was made.
 * If a commit confirmed is rolled back the source is "other" and the
 * user is "root".
 *
 * @link       https://www.librenms.org
 *
 * @copyright  2021 paulierco
 * @author     Paul Iercosan <mail@paulierco.ro>
 */

namespace LibreNMS\Snmptrap\Handlers;

use App\Models\Device;
use LibreNMS\Enum\Severity;
use LibreNMS\Interfaces\SnmptrapHandler;
use LibreNMS\Snmptrap\Trap;

class Aos7portViolation implements SnmptrapHandler
{
    /**
     * Handle snmptrap.
     * Data is pre-parsed and delivered as a Trap.
     *
     * @param  Device  $device
     * @param  Trap  $trap
     * @return void
     */
    public function handle(Device $device, Trap $trap)
    {
        $reason = $trap->getOidData($trap->findOid('ALCATEL-IND1-PORT-MIB::portViolationSource.2.0'));
        $current = $trap->getOidData($trap->findOid('ALCATEL-IND1-PORT-MIB::portViolationReason.3.0'));
        $ifDescr = $trap->getOidData($trap->findOid('IF-MIB::ifDescr'));
        $ifIndex = $trap->getOidData($trap->findOid('IF-MIB::ifIndex'));
        $port = $device->ports()->where('ifIndex', $ifIndex)->first();
        $trap->log("There has been a loop detected on the port $port->ifDescr. The source code of the violation is: $reason and the current status code is: $current.", Severity::Error);
    }
}

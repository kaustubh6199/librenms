<?php
/**
 * zyxel.inc.php
 *
 * LibreNMS mempools discovery module for Zyxel devices
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
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

if ($device['group'] == 'zyxel') {
    echo 'Zyxel : ';
    $oid = '.1.3.6.1.4.1.890.1.15.3.2.5.0';
    $usage = snmp_get($device, $oid, '-Ovq');
    $descr = 'Memory';
    if (is_numeric($usage)) {
        discover_mempool($valid_mempool, $device, '0', 'zyxel', $descr, '1', null, null);
    }
}

unset(
    $oid,
    $usage,
    $descr
);

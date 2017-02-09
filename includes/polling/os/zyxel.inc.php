<?php
/**
 * zyxel.inc.php
 *
 * LibreNMS os poller module for Zyxel devices
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

$oids = array('.1.3.6.1.4.1.890.1.15.3.1.11.0', '.1.3.6.1.4.1.890.1.15.3.1.6.0', '.1.3.6.1.4.1.890.1.15.3.1.12.0');
$zyxel = snmp_get_multi_oid($device, $oids, '-OUQnt');

$hardware = $zyxel['.1.3.6.1.4.1.890.1.15.3.1.11.0'];
list($version,)  = explode(' | ', $zyxel['.1.3.6.1.4.1.890.1.15.3.1.6.0']);
$serial   = $zyxel['.1.3.6.1.4.1.890.1.15.3.1.12.0'];

unset(
    $zyxel
);

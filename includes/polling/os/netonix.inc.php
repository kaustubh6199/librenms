<?php
/**
 * netonix.inc.php
 *
 * LibreNMS os poller module for Netonix
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
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

//NETONIX-SWITCH-MIB::firmwareVersion.0
$version = snmp_get($device, '.1.3.6.1.4.1.46242.1.0', '-OQv');
$version = str_replace('.n.........', '', $version); // version display bug in 1.3.9
$hardware = $poll_device['sysDescr'];

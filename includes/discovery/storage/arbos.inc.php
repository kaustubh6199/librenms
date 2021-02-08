<?php
/**
 * arbos.inc.php
 *
 * LibreNMS storage module for ArbOS
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
 * @link       https://www.librenms.org
 * @copyright  2020 Adam Bishop
 * @author     Adam Bishop <adam@omega.org.uk>
 */

if ($device['os'] === 'arbos' && Str::contains($device['sysDescr'], 'TMS')) {
    discover_storage($valid_storage, $device, 0, 'arbos', 'arbos', 'Internal Storage', '100', '1');
}

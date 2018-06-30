<?php
/**
 * sessions.inc.php
 *
 * LibreNMS sessions overview for WebUI
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
 * @copyright  2018 Adam Bishop
 * @author     Adam Bishop <adam@omega.org.uk>
 */

$graph_type   = 'sensor_sessions';
$sensor_class = 'sessions';
$sensor_unit  = ' sessions';
$sensor_type  = 'Sessions';

require 'pages/device/overview/generic/sensor.inc.php';

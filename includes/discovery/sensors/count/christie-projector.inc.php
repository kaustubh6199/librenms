<?php
/*
 * LibreNMS
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage webui
 * @link       http://librenms.org
 * @copyright  2023 LibreNMS
 * @author     LibreNMS Contributors
*/

use Illuminate\Support\Str;

if (Str::startsWith($device['sysObjectID'], '.1.3.6.1.4.1.25766')) {
    discover_sensor(
        $valid['sensor'],
        'count',
        $device,
        '.1.3.6.1.4.1.25766.1.12.1.1.3.5.1.6.1',
        0,
        'christie-projector',
        'Lamp Hours',
        1,
        1,
        null,
        null,
        null,
        null,
        snmp_get($device, '.1.3.6.1.4.1.25766.1.12.1.1.3.5.1.6.1', '-Ovq')
    );
}

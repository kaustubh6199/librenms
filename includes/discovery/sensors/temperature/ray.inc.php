<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2020 Martin Kukal <martin@kukal.cz>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

d_echo('RAY');
$oid = ".1.3.6.1.4.1.33555.1.1.4.2";

$cmd = gen_snmpget_cmd($device, $oid, '-Oqv', 'RAY-MIB', 'ray');
$data = trim(external_exec($cmd), "\" \n\r");
if (!preg_match('/(No Such Instance)/i', $data)) {
    $oid='.1.3.6.1.4.1.33555.1.1.4.2';
} else {
    $oid='.1.3.6.1.4.1.33555.1.1.4.2.0';
}

$index = 0;
$sensor_type = ' temperatureRadio';
$descr = 'Internal Temp';
$divisor = 100;
$temperature = (snmp_get($device, $oid, '-Oqv', 'RAY-MIB') / $divisor);
if (is_numeric($temperature)) {
    discover_sensor($valid['sensor'], 'temperature', $device, $oid, $index, $sensor_type, $descr, $divisor, null, null, null, null, null, $temperature);
}

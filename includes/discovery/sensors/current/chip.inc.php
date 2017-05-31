<?php
$chip = snmp_get($device, '.1.3.6.1.2.1.1.1.0', '-Oqv');
if (strpos($chip, 'chip') !== false) {
    $sensor_type = "chip_currents";
    $oid = '.1.3.6.1.4.1.8072.1.3.2.4.1.2.10.112.111.119.101.114.45.115.116.97.116.';
    $lowlimit     = 0;
    $lowwarnlimit = null;
    $warnlimit    = null;
    $limit        = null;
    $descr = 'AC IN current';
    $current = '3';
    $value = snmp_get($device, $oid.$current, '-Oqv');
    discover_sensor($valid['sensor'], 'current', $device, $oid.$current, $current, $sensor_type, $descr, '1', '1', null, null, null, null, $value);
    $descr = 'VBUS current';
    $current = '5';
    $value = snmp_get($device, $oid.$current, '-Oqv');
    discover_sensor($valid['sensor'], 'current', $device, $oid.$current, $current, $sensor_type, $descr, '1', '1', $lowlimit, $lowwarnlimit, $warnlimit, $limit, $value);
    $descr = 'Battery current';
    $current = '7';
    $value = snmp_get($device, $oid.$current, '-Oqv');
    discover_sensor($valid['sensor'], 'current', $device, $oid.$current, $current, $sensor_type, $descr, '1', '1', $lowlimit, $lowwarnlimit, $warnlimit, $limit, $value);
}

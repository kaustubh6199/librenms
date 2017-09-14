<?php

echo 'RFC1628 ';

// UPS-MIB::upsSecondsOnBattery
$secs_on_battery_oid = '.1.3.6.1.2.1.33.1.2.2.0';
$secs_on_battery = snmp_get($device, $secs_on_battery_oid, '-Oqv');

if (is_numeric($secs_on_battery)) {
    discover_sensor(
        $valid['sensor'],
        'runtime',
        $device,
        $secs_on_battery_oid,
        100,
        'rfc1628',
        'Time on battery',
        60,
        1,
        0,
        0,
        1,
        2,
        $secs_on_battery
    );
}


// UPS-MIB::upsEstimatedMinutesRemaining
$est_battery_time_oid = ".1.3.6.1.2.1.33.1.2.3.0";
$est_battery_time = snmp_get($device, $est_battery_time_oid, '-Ovq');

if (is_numeric($est_battery_time)) {
    discover_sensor(
        $valid['sensor'],
        'runtime',
        $device,
        $est_battery_time_oid,
        200,
        'rfc1628',
        'Estimated battery time remaining',
        1,
        1,
        5,
        10,
        null,
        10000,
        $est_battery_time
    );
}

unset($secs_on_battery, $secs_on_battery_oid, $est_battery_time, $est_battery_time_oid);

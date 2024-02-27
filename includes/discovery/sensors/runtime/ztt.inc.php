<?php

/**
 *
 * For ZTT MSJ devices
 *
 */


// ZTT discovery start!

// calc for battery
$percent_on_battery = trim(snmp_get($device, '.1.3.6.1.4.1.49692.1.1.1.1.16.1', '-OsqnU'), '" ');

[$oidp, $bat_per] = explode(' ', $percent_on_battery);
$bat_per_int = intval($bat_per);
$bat_per_int = $bat_per_int / 1000;

// Get capa from system
$capa_on_battery = trim(snmp_get($device, '.1.3.6.1.4.1.49692.1.1.1.1.183.1', '-OsqnU'), '" ');
[$oidx, $bat_capa] = explode(' ', $capa_on_battery);
$bat_capa_int = intval($bat_capa);
$bat_capa_int = $bat_capa_int / 1000;


// Get battery current from system
// charing : positive  , discharing: negative
// hide if in charging
$oids_current = snmp_get($device, '.1.3.6.1.4.1.49692.1.1.1.1.15.1', '-OsqnU');
[$oidc, $bacurrent] = explode(' ', $oids_current);
$bacurrent_fl = floatval($bacurrent);


if ($bacurrent_fl < 0) {
    $battery_load_calc = abs($bacurrent_fl);
    $battery_load_calc = $battery_load_calc / 1000;

    $battery_left = ($bat_capa_int) * ($bat_per_int) * 60 / 100 / ($battery_load_calc);
    discover_sensor(
        $valid['sensor'],
        'runtime',
        $device,
        '.1.3.6.1.4.1.49692.1.1.1.1.117.1',
        0,
        'Battery',
        'Batterypackremainingminutes',
        1,
        1,
        null,
        null,
        null,
        null,
        $battery_left
    );

} elseif ($bacurrent_fl == 0) {

    $battery_left = 0;
    discover_sensor(
        $valid['sensor'],
        'runtime',
        $device,
        '.1.3.6.1.4.1.49692.1.1.1.1.117.1',
        0,
        'Battery',
        'Batterypackremainingminutes',
        1,
        1,
        null,
        null,
        null,
        null,
        $battery_left
    );

} else {

    $battery_left = 0;
    discover_sensor(
        $valid['sensor'],
        'runtime',
        $device,
        '.1.3.6.1.4.1.49692.1.1.1.1.117.1',
        0,
        'Battery',
        'Batterypackremainingminutes',
        1,
        1,
        null,
        null,
        null,
        null,
        $battery_left
    );
}
unset($battery_left, $percent_on_battery, $bat_per_int, $battery_load_calc, $oids_current);
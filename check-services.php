#!/usr/bin/env php
<?php

/*
 * LibreNMS module to poll Nagios Services
 *
 * Copyright (c) 2016 Aaron Daniels <aaron@daniels.id.au>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

$init_modules = array();
require __DIR__ . '/includes/init.php';

$options = getopt('d::h:f:;');
if (isset($options['d'])) {
    echo "DEBUG!\n";
    $debug = true;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_reporting', 1);
} else {
    $debug = false;
    // ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('log_errors', 0);
    // ini_set('error_reporting', 0);
}

if (isset($options['f'])) {
    $config['noinfluxdb'] = true;
}

if (isset($options['p'])) {
    $prometheus = false;
}

if ($config['noinfluxdb'] !== true && $config['influxdb']['enable'] === true) {
    $influxdb = influxdb_connect();
} else {
    $influxdb = false;
}

rrdtool_initialize();

$where = '';
if ($options['h']) {
    if (is_numeric($options['h'])) {
        $where = "AND `S`.`device_id` = ".$options['h'];
    } else {
        if (preg_match('/\*/', $options['h'])) {
            $where = "AND `hostname` LIKE '".str_replace('*', '%', mres($options['h']))."'";
        } else {
            $where = "AND `hostname` = '".mres($options['h'])."'";
        }
    }
}

$sql = 'SELECT * FROM `devices` AS D, `services` AS S WHERE S.device_id = D.device_id ' . $where . ' ORDER by D.device_id DESC';

foreach (dbFetchRows($sql) as $service) {
    // Run the polling function only if the associated device is up
    if ($service['status'] === "1" || ($service['status'] === '0' && $service['status_reason'] === 'snmp')) {
        poll_service($service);
    } else {
        d_echo("\nNagios Service - ".$service['service_id']."\nSkipping service check because device ".$service['device_id']." is down.\n");
    }
} //end foreach
rrdtool_close();

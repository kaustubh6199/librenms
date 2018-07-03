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

$init_modules = array('alerts');
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

$poller_start = microtime(true);

rrdtool_initialize();

echo "Starting service polling run:\n\n";
$polled_services = 0;

$where = '';
if ($options['h']) {
    if (is_numeric($options['h'])) {
        $where = "AND `device_id` = ".$options['h'];
    } else {
        if (preg_match('/\*/', $options['h'])) {
            $where = "AND `hostname` LIKE '".str_replace('*', '%', mres($options['h']))."'";
        } else {
            $where = "AND `hostname` = '".mres($options['h'])."'";
        }
    }
}

if (!isset($query)) {
    $query = "SELECT * FROM `devices` WHERE `disabled` = 0 $where ORDER BY `device_id` ASC";
}

foreach (dbFetch($query) as $device) {
    $sql = 'SELECT * FROM `devices` AS D
 INNER JOIN `services` AS S ON S.device_id = D.device_id AND D.device_id = '.$device['device_id'].'
 LEFT JOIN `devices_attribs` as A ON D.device_id = A.device_id AND A.attrib_type = "override_icmp_disable"
 ORDER by D.device_id DESC;';

    foreach (dbFetchRows($sql) as $service) {
    // Run the polling function if the associated device is up, "Disable ICMP Test" option is not enabled, 
    // or service hostname/ip is different from associated device
        if ($service['status'] === "1" || ($service['status'] === '0' && $service['status_reason'] === 'snmp') ||
        $service['attrib_value'] === 'true' || ($service['service_ip'] !== $service['hostname'] &&
        $service['service_ip'] !== $service['ip'] )) {
            // Mark service check as enabled if it was disabled previosly because device was down
            if ($service['service_disabled'] === "1"){
                dbUpdate(array('service_disabled' => '0'), 'services', '`service_id` = ?',
                         array($service['service_id']));
            }
            poll_service($service);
            $polled_services++;
        } else {
            d_echo("\nNagios Service - ".$service['service_id']."\nSkipping service check because device "
                   .$service['hostname']." is down due to icmp.\n");
            // Mark service check as disabled while device is down and log to eventlog that service check is skipped,
            // but only if it's not already marked as disabled
            if ($service['service_disabled'] === "0"){
                dbUpdate(array('service_disabled' => '1'), 'services', '`service_id` = ?',
                         array($service['service_id']));
                log_event("Nagios Service - {$service['service_desc']} ({$service['service_id']}) - 
                          Skipping service check because device {$service['hostname']} is down due to icmp",
                          $device, 'service', 4, $service['service_id']);
            }
        }
    } //end service foreach

    echo "#### Start Alerts ####\n";
    RunRules($device['device_id']);
    echo "#### End Alerts ####\r\n";
} //end device foreach

$poller_end  = microtime(true);
$poller_run  = ($poller_end - $poller_start);
$poller_time = substr($poller_run, 0, 5);


$string = $argv[0]." ".date($config['dateformat']['compact'])." - $polled_services services polled in $poller_time secs";
d_echo("$string\n");

rrdtool_close();

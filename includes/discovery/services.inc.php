<?php

use LibreNMS\Config;

if (Config::get('discover_services')) {
    // FIXME: use /etc/services?
    $known_services = [
        22  => 'ssh',
        25  => 'smtp',
        53  => 'dns',
        80  => 'http',
        110 => 'pop',
        143 => 'imap',
    ];

    // Services
    if ($device['type'] == 'server') {
        $oids = trim(snmp_walk($device, '.1.3.6.1.2.1.6.13.1.1.0.0.0.0', '-Osqn'));
        foreach (explode("\n", $oids) as $data) {
            $data = trim($data);
            if ($data) {
                [$oid, $tcpstatus] = explode(' ', $data);
                if (trim($tcpstatus) == 'listen') {
                    $split_oid = explode('.', $oid);
                    $tcp_port = $split_oid[(count($split_oid) - 6)];
                    if ($known_services[$tcp_port]) {
                        discover_service($device, $known_services[$tcp_port]);
                    }
                }
            }
        }
    }
    foreach (dbFetchRows('SELECT * FROM `device_groups` ORDER BY `name`') as $device_group) {
        foreach (dbFetchRows('SELECT * FROM `services_template` WHERE `device_group_id` = ?', [$device_group[device_group_id]]) as $service_template) {
            discover_service_template($device_group['device_group_id'], $service_template['service_template_id']);
        }
    }
    echo "\n";
}

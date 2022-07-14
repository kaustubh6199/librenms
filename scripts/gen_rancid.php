#!/usr/bin/env php
<?php
/*
* LibreNMS
*
* Copyright (c) 2017 Xavier Beaudouin <kiwi@oav.net>
* This program is free software: you can redistribute it and/or modify it
* under the terms of the GNU General Public License as published by the
* Free Software Foundation, either version 3 of the License, or (at your
* option) any later version.  Please see LICENSE.txt at the top level of
* the source code distribution for details.
*/

$init_modules = [];
require realpath(__DIR__ . '/..') . '/includes/init.php';

?>

# RANCID router.db autogenerated by LibreNMS
# Do not edit this file manualy

<?php

/*
 * Rancid real OS to rancid OS map.
 * Maybe we can add this somewhere?
 */
$rancid_map['arista_eos'] = 'arista';
$rancid_map['asa'] = 'cisco';
$rancid_map['avocent'] = 'avocent';
$rancid_map['edgeos'] = 'edgerouter';
$rancid_map['edgeswitch'] = 'edgemax';
$rancid_map['f5'] = 'f5';
$rancid_map['fortigate'] = 'fortigate';
$rancid_map['fortiswitch'] = 'fortigate';
$rancid_map['ftos'] = 'force10';
$rancid_map['ios'] = 'cisco';
$rancid_map['iosxe'] = 'cisco';
$rancid_map['iosxr'] = 'cisco-xr';
$rancid_map['ironware'] = 'foundry';
$rancid_map['junos'] = 'juniper';
$rancid_map['pfsense'] = 'pfsense';
$rancid_map['procurve'] = 'hp';
$rancid_map['nxos'] = 'cisco-nx';
$rancid_map['mikrotik'] = 'mikrotik';
$rancid_map['routeros'] = 'mikrotik';
$rancid_map['screenos'] = 'netscreen';
$rancid_map['xos'] = 'extreme';
$rancid_map['ciscosb'] = 'cisco-sb';
$rancid_map['allied'] = 'at';
$rancid_map['radlan'] = 'at';
$rancid_map['ciscowlc'] = 'cisco-wlc8';
$rancid_map['comware'] = 'h3c';
$rancid_map['panos'] = 'paloalto';
$rancid_map['fs-switch'] = 'cisco';
$rancid_map['vyos'] = 'vyos';
$rancid_map['mrv-od'] = 'mrv';

foreach (dbFetchRows("SELECT `hostname`,`os`,`disabled`,`status` FROM `devices` WHERE `ignore` = 0 AND `type` != '' GROUP BY `hostname`") as $devices) {
    if (isset($rancid_map[$devices['os']])) {
        $status = 'up';
        if ($devices['disabled']) {
            $status = 'down';
        }
        echo $devices['hostname'] . ';' . $rancid_map[$devices['os']] . ';' . $status . PHP_EOL;
    }
}
echo '# EOF ' . PHP_EOL;

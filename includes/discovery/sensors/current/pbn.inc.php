<?php
/*
 * LibreNMS
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if ($device['os'] == 'pbn' || $device['os_group'] == 'pbn') {
    echo 'PBN ';

    $multiplier = 1;
    $divisor    = 1000000;
    foreach ($pbn_oids as $index => $entry) {
        if (is_numeric($entry['curr']) && ($entry['curr'] !== '-65535')) {
            $oid = 'NMS-IF-MIB::curr.'.$index;
            $descr = dbFetchCell('SELECT `ifDescr` FROM `ports` WHERE `ifIndex`= ? AND `device_id` = ?', array($index, $device['device_id'])) . ' Current';
            $limit_low = 9000/$divisor;
            $warn_limit_low = 9500/$divisor;
            $limit = 15000/$divisor;
            $warn_limit = 14500/$divisor;
            $value = $entry['curr']/$divisor;
            $entPhysicalIndex = $index;
            $entPhysicalIndex_measured = 'ports';
            discover_sensor($valid['sensor'], 'current', $device, $oid, ''.$index, 'pbn', $descr, $divisor, $multiplier, $limit_low, $warn_limit_low, $warn_limit, $limit, $value, 'snmp', $entPhysicalIndex, $entPhysicalIndex_measured);
        }

    }

}

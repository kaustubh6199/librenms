<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2016 Søren Friis Rosiak <sorenrosiak@gmail.com> 
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if ($device['os'] == 'comware') {
    echo 'Comware ';
    
    $multiplier    = 1;
    $divisor       = 100000;
    $divisor_alarm = 1000000;
    foreach ($comware_oids as $index => $entry) {
        if (is_numeric($entry['hh3cTransceiverBiasCurrent']) && $entry['hh3cTransceiverBiasCurrent'] != 2147483647) {
            $oid                       = '.1.3.6.1.4.1.25506.2.70.1.1.1.17.15.' . $index;
            $dbquery                   = dbFetchRows("SELECT `ifDescr` FROM `ports` WHERE `ifIndex`= ? AND `device_id` = ? AND `ifAdminStatus` = 'up'", array(
                $index,
                $device['device_id']
            ));
            $limit_low                 = $entry['hh3cTransceiverBiasLoAlarm'] / $divisor_alarm;
            $warn_limit_low            = $entry['hh3cTransceiverBiasLoWarn'] / $divisor_alarm;
            $limit                     = $entry['hh3cTransceiverBiasHiAlarm'] / $divisor_alarm;
            $warn_limit                = $entry['hh3cTransceiverBiasHiWarn'] / $divisor_alarm;
            $current                   = $entry['hh3cTransceiverBiasCurrent'] / $divisor;
            $entPhysicalIndex          = $index;
            $entPhysicalIndex_measured = 'ports';
            foreach ($dbquery as $dbindex => $dbresult) {
                $descr = $dbresult['ifDescr'] . ' Bias Current';
                discover_sensor($valid['sensor'], 'current', $device, $oid, 'bias-' . $index, 'comware', $descr, $divisor, $multiplier, $limit_low, $warn_limit_low, $warn_limit, $limit, $current, 'snmp', $entPhysicalIndex, $entPhysicalIndex_measured);
            }
        }
    }
}

<?php
/*
 * LibreNMS entity-physical module for discovery of components in a Schleifenbauer SPDM databus ring
 *
 * Copyright (c) 2019 Martijn Schmidt <martijn.schmidt@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

// Let's gather some data about the databus ring..
$sdbMgmtStsDevices              = snmp_get($device, '.1.3.6.1.4.1.31034.12.1.1.1.1.1.0', '-Oqv', '');
$sdbMgmtDatabusRingDescr        = "Schleifenbauer databus ring ($sdbMgmtStsDevices units)";

// Let's gather some data about the units..
$sdbMgmtCtrlDevUnitAddressArray = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.1.2.4.1.2', 1));
$sdbDevIdNameArray              = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.1.1.1.10', 1));
$sdbDevIdLocationArray          = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.1.1.1.11', 1));
$sdbDevIdVanityTagArray         = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.1.1.1.12', 1));
$sdbDevIdSerialNumberArray      = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.1.1.1.6', 1));
$sdbDevIdFirmwareVersionArray   = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.1.1.1.2', 1));
$sdbDevIdProductIdArray         = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.1.1.1.5', 1));
$sdbDevIdSalesOrderNumberArray  = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.1.1.1.4', 1));
$sdbDevCfMaximumLoadArray       = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.2.1.1.6', 1));
$sdbDevCfOutletsTotalArray      = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.2.1.1.2', 1));
$sdbDevCfSensorsArray           = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.2.1.1.5', 1));

// And let's gather some data about the inputs, outputs, and sensors on those units..
$sdbDevInNameArray              = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.6.1.1.13', 2));
$sdbDevSnsTypeArray             = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.8.2.1.2', 2));
$sdbDevSnsNameArray             = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.8.2.1.4', 2));

// In a large databus ring, snmpwalking this OID may crash the discovery half way through.
// So, we only discover and enumerate outlets if this is a stand-alone, non-databus unit.
if ($sdbMgmtStsDevices == 1) {
    $sdbDevOutNameArray = current(snmpwalk_array_num($device, '.1.3.6.1.4.1.31034.12.1.1.2.7.1.1.2', 2));
}

// Only spawn databus ring entities when the device is not stand-alone.
if ($sdbMgmtStsDevices > 1) {
    $entPhysicalContainedIn = 1;
    discover_entity_physical($valid, $device, 1, $sdbMgmtDatabusRingDescr, 'stack', 'Schleifenbauer Databus', null, null, '0', 'Schleifenbauer Products B.V.', -1, null, null, null, null, 'false', null, null, null);
    discover_entity_physical($valid, $device, 2, 'Databus Ring State Sensor (0 = open, 1 = closed)', 'sensor', 'State Sensor', null, null, '1', 'Schleifenbauer Products B.V.', -1, null, null, null, null, 'false', null, null, null);
    discover_entity_physical($valid, $device, 3, 'Duplicate Device Address Sensor (#)', 'sensor', 'State Sensor', null, null, '1', 'Schleifenbauer Products B.V.', -1, null, null, null, null, 'false', null, null, null);
    discover_entity_physical($valid, $device, 4, 'New Device Detection Sensor (#)', 'sensor', 'State Sensor', null, null, '1', 'Schleifenbauer Products B.V.', -1, null, null, null, null, 'false', null, null, null);
} else {
    $entPhysicalContainedIn = 0;
}

foreach ($sdbMgmtCtrlDevUnitAddressArray as $sdbMgmtCtrlDevUnitAddress => $sdbDevIdIndex) {
    $entPhysicalDescr        = "Schleifenbauer ". count($sdbDevInNameArray[$sdbDevIdIndex]) ."-phase, ". $sdbDevCfOutletsTotalArray[$sdbDevIdIndex] ."-outlet PDU";
    $entPhysicalName         = "Schleifenbauer PDU - SPDM v". $sdbDevIdFirmwareVersionArray[$sdbDevIdIndex];
    $entPhysicalHardwareRev  = "SO# ". $sdbDevIdSalesOrderNumberArray[$sdbDevIdIndex];

    // We are determining the $entPhysicalAlias for this PDU based on a few optional user-customizable fields.
    $entPhysicalAlias = null;
    if ($sdbDevIdNameArray[$sdbDevIdIndex] != '') {
        $entPhysicalAlias = $sdbDevIdLocationArray[$sdbDevIdIndex] != '' ? $sdbDevIdNameArray[$sdbDevIdIndex] ." @ ". $sdbDevIdLocationArray[$sdbDevIdIndex] : $sdbDevIdNameArray[$sdbDevIdIndex];
    } // end of $entPhysicalAlias if-sequence

    discover_entity_physical($valid, $device, $sdbDevIdIndex * 10000, $entPhysicalDescr, 'chassis', $entPhysicalName, $sdbDevIdProductIdArray[$sdbDevIdIndex], $sdbDevIdSerialNumberArray[$sdbDevIdIndex], $entPhysicalContainedIn, 'Schleifenbauer Products B.V.', $sdbMgmtCtrlDevUnitAddress, null, $entPhysicalHardwareRev, null, $sdbDevIdFirmwareVersionArray[$sdbDevIdIndex], 'true', $entPhysicalAlias, $sdbDevIdVanityTagArray[$sdbDevIdIndex], null);

    // Since a fully numerical entPhysicalIndex is only available for the actual PDU, we are calculating a fake entPhysicalIndex to avoid namespace collision. We have an Integer32 of space per IETF RFC6933 anyway.
    // The maximum $sdbDevIdIndex is 65535, but multiplying by 10000 for namespace size. Add +1k for every top-level index below a PDU.
    foreach ($sdbDevInNameArray[$sdbDevIdIndex] as $sdbDevInIndex => $sdbDevInName) {
        $inputIndex          = $sdbDevIdIndex * 10000 + 1000 + $sdbDevInIndex * 10; // +1k for the first top-level namespace. Add 10 * sdbDevInIndex which goes up to 48. Leave 1 variable digit at the end.
        $entPhysicalDescr    = $sdbDevCfMaximumLoadArray[$sdbDevIdIndex] ."A input phase";
        $entPhysicalName     = "Input L". $sdbDevInIndex;

        discover_entity_physical($valid, $device, $inputIndex, $entPhysicalDescr, 'powerSupply', $entPhysicalName, null, null, $sdbDevIdIndex * 10000, 'Schleifenbauer Products B.V.', $sdbDevInIndex, null, null, null, null, 'false', $sdbDevInName, null, null);

        // Enumerate sensors under the Input
        discover_entity_physical($valid, $device, $inputIndex + 1, $entPhysicalName .' voltage sensor (V)', 'sensor', 'Voltage Sensor', null, null, $inputIndex, 'Schleifenbauer Products B.V.', 1, null, null, null, null, 'false', null, null, null);
        discover_entity_physical($valid, $device, $inputIndex + 2, $entPhysicalName .' RMS current sensor (A)', 'sensor', 'Current Sensor', null, null, $inputIndex, 'Schleifenbauer Products B.V.', 2, null, null, null, null, 'false', null, null, null);
        discover_entity_physical($valid, $device, $inputIndex + 3, $entPhysicalName .' apparent power sensor (W)', 'sensor', 'Power Sensor', null, null, $inputIndex, 'Schleifenbauer Products B.V.', 3, null, null, null, null, 'false', null, null, null);
        discover_entity_physical($valid, $device, $inputIndex + 4, $entPhysicalName .' lifetime power consumed sensor (kWh)', 'sensor', 'Power Consumed Sensor', null, null, $inputIndex, 'Schleifenbauer Products B.V.', 4, null, null, null, null, 'false', null, null, null);
        discover_entity_physical($valid, $device, $inputIndex + 5, $entPhysicalName .' power factor sensor (ratio)', 'sensor', 'Power Factor Sensor', null, null, $inputIndex, 'Schleifenbauer Products B.V.', 5, null, null, null, null, 'false', null, null, null);
    } // end Input discovery foreach sdbDevInNameArray

    // Only enumerate outlets if this is a stand-alone, non-databus unit.
    if ($sdbMgmtStsDevices == 1) {
        // Check if we can find any outlets on this PDU..
        if ($sdbDevOutNameArray[$sdbDevIdIndex] != '') {
            // We found outlets, so let's spawn an Outlet Backplane.
            $outletBackplaneIndex     = $sdbDevIdIndex * 10000 + 2000; // +2k for the second top-level index namespace.
            $entPhysicalDescr         = $sdbDevCfOutletsTotalArray[$sdbDevIdIndex] ." outlets";

            discover_entity_physical($valid, $device, $outletBackplaneIndex, $entPhysicalDescr, 'backplane', 'Outlets', null, null, $sdbDevIdIndex * 10000, 'Schleifenbauer Products B.V.', '-1', null, null, null, null, 'false', null, null, null);

            foreach ($sdbDevOutNameArray[$sdbDevIdIndex] as $sdbDevOutIndex => $sdbDevOutName) {
                $outletIndex      = $sdbDevIdIndex * 10000 + 2000 + $sdbDevOutIndex * 10; // +2k for the second top-level index namespace. Add 10 * sdbDevOutIndex which goes up to 48. Leave 1 variable digit at the end.
                $entPhysicalName  = "Outlet #". $sdbDevOutIndex;

                discover_entity_physical($valid, $device, $outletIndex, 'PDU outlet', 'powerSupply', $entPhysicalName, null, null, $outletBackplaneIndex, 'Schleifenbauer Products B.V.', $sdbDevOutIndex, null, null, null, null, 'false', $sdbDevOutName, null, null);
            } // end Outlet discovery foreach sdbDevOutNameArray
        } // end of Outlet Backplane detection
    }

    // Check if we can find any external sensor connections on this PDU..
    if ($sdbDevSnsTypeArray[$sdbDevIdIndex] != '') {
        // We found at least one sensor connection, so let's spawn a Sensor Container.
        $sensorContainerIndex = $sdbDevIdIndex * 10000 + 3000; // +3k for the third top-level index namespace.
        $entPhysicalDescr     = $sdbDevCfSensorsArray[$sdbDevIdIndex] == 1 ? "1 external sensor" : $sdbDevCfSensorsArray[$sdbDevIdIndex] ." external sensors";

        discover_entity_physical($valid, $device, $sensorContainerIndex, $entPhysicalDescr, 'container', 'Sensor Container', null, null, $sdbDevIdIndex * 10000, 'Schleifenbauer Products B.V.', '-1', null, null, null, null, 'false', null, null, null);

        foreach ($sdbDevSnsNameArray[$sdbDevIdIndex] as $sdbDevSnsIndex => $sdbDevSnsName) {
            $sensorIndex      = $sdbDevIdIndex * 10000 + 3000 + $sdbDevSnsIndex * 10; // +3k for the third top-level index namespace. Add 10 * sdbDevSnsIndex which goes up to 16. Leave 3 variable digits at the end.
            switch ($sdbDevSnsTypeArray[$sdbDevIdIndex][$sdbDevSnsIndex]) {
                case ('T'):
                    $class = 'temperature';
                    break;
                case ('H'):
                    $class = 'humidity';
                    break;
                case ('I'):
                    $class = 'state';
                    break;
            }
            $unit  = __('sensors.' . $class . '.unit');
            $short = __('sensors.' . $class . '.short');
            $entPhysicalName  = "External $short Sensor";
            $entPhysicalDescr = $class == 'state' ? "Dry switch contact (binary)" : "$short sensor ($unit)";

            discover_entity_physical($valid, $device, $sensorIndex, $entPhysicalDescr, 'sensor', $entPhysicalName, null, null, $sensorContainerIndex, 'Schleifenbauer Products B.V.', $sdbDevSnsIndex, null, null, null, null, 'true', $sdbDevSnsName, null, null);
        } // end external Sensor discovery foreach sdbDevSnsNameArray
    } // end of external Sensor Container detection
} // end PDU discovery foreach sdbDevIdNameArray

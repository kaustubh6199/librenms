<?php

if ($device['os'] == 'f5') {
    $f5_chassis = array();
    // Get the Chassis Temperature values
    //Pull the sysChassisTempTable table from the snmpwalk
    $f5_chassis = snmpwalk_cache_multi_oid($device, 'sysChassisTempTable', array(), 'F5-BIGIP-SYSTEM-MIB');

    if (is_array($f5_chassis)) {
        echo "sysChassisTempTable ";

        foreach (array_keys($f5_chassis) as $index) {
            $descr           = "sysChassisTempTemperature.".$f5_chassis[$index]['sysChassisTempIndex'];
            $current         = $f5_chassis[$index]['sysChassisTempTemperature'];
            $sensorType      = 'f5';
            $oid             = '.1.3.6.1.4.1.3375.2.1.3.2.3.2.1.2.'.$index;

            discover_sensor($valid['sensor'], 'temperature', $device, $oid, $index, $sensorType, $descr, '1', '1', null, null, null, null, $current);
        }
    }

    // Get the CPU Temperature values
    $f5cpu = array();
    $f5cpu = snmpwalk_cache_multi_oid($device, 'sysCpuSensorTemperature', array(), 'F5-BIGIP-SYSTEM-MIB');

    if (is_array($f5cpu)) {
        echo "sysCpuSensorTemperature ";
  
        foreach (array_keys($f5cpu) as $index) {
            $cpuname_oid     = ".1.3.6.1.4.1.3375.2.1.3.6.2.1.4.$index";
            $slot_oid        = ".1.3.6.1.4.1.3375.2.1.3.6.2.1.5.$index";
            $slotnum         = snmp_get($device, $slot_oid, '-Oqv', 'F5-BIGIP-SYSTEM-MIB');
            $cpuname         = snmp_get($device, $cpuname_oid, '-Oqv', 'F5-BIGIP-SYSTEM-MIB');

            $descr           = "Cpu Temperature slot".$slotnum."/".$cpuname;
            $current         = $f5cpu[$index]['sysCpuSensorTemperature'];
            $sensorType      = 'f5';
            $oid             = '.1.3.6.1.4.1.3375.2.1.3.6.2.1.2.'.$index;

            discover_sensor($valid['sensor'], 'temperature', $device, $oid, $index, $sensorType, $descr, '1', '1', null, null, null, null, $current);
        }
    }
}//end if

<?php

$chas_oid = '.1.3.6.1.4.1.6486.800.1.1.1.1.1.1.1.2.'; // chasEntPhysOperStatus
$stack_left = snmp_walk($device, 'chasFreeSlots', '-OQUse', 'ALCATEL-IND1-CHASSIS-MIB', 'nokia');
$stack_role = snmp_walk($device, 'alaStackMgrChasRole', '-OQUse', 'ALCATEL-IND1-STACK-MANAGER-MIB', 'nokia');
$stack_alone = substr($stack_role, strpos($stack_role, "=") + 1);
$stack_left = substr($stack_left, strpos($stack_left, "=") + 1);
$true_stacking = (7 - $stack_left);
$stacking = '7';
$stacking_non = '4';
$oids = snmp_walk($device, 'chasEntPhysOperStatus', '-OQUse', 'ALCATEL-IND1-CHASSIS-MIB', 'nokia');
foreach (explode("\n", $oids) as $chas_entry) {
    preg_match('/chasEntPhysOperStatus.(.) = (.+)/', $chas_entry, $data2); // entPhysicalName.284 = "5/PS-2"
    if (! empty($data2)) {
        $number = $data2[1];
        $value = $data2[2];
        $chas_oid_index = $chas_oid . $number;
        $chas_current = "chasEntPhysOperStatus.$number";
        $descr_oid = '.1.3.6.1.2.1.47.1.1.1.1.7.' . $number;
        $chas_descr = snmp_get($device, $descr_oid, '-Oqv');
        $chas_state_name = 'chasEntPhysOperStatus';
        $chas_states = [
            ['value' => 1, 'generic' => 0, 'graph' => 1, 'descr' => 'Up'],
            ['value' => 2, 'generic' => 2, 'graph' => 1, 'descr' => 'Down'],
            ['value' => 3, 'generic' => 3, 'graph' => 1, 'descr' => 'Testing'],
            ['value' => 4, 'generic' => 3, 'graph' => 1, 'descr' => 'Unknown'],
            ['value' => 5, 'generic' => 0, 'graph' => 1, 'descr' => 'Secondary'],
            ['value' => 6, 'generic' => 2, 'graph' => 1, 'descr' => 'NotPresent'],
            ['value' => 7, 'generic' => 2, 'graph' => 1, 'descr' => 'UnPowered'],
            ['value' => 8, 'generic' => 0, 'graph' => 1, 'descr' => 'Master'],
        ];
        create_state_index($chas_state_name, $chas_states);
        discover_sensor($valid['sensor'], 'state', $device, $chas_oid_index, $number, $chas_state_name, $chas_descr, 1, 1, null, null, null, null, $value);
        create_sensor_to_state_index($device, $chas_state_name, $number);
    }
}

unset(
    $index,
    $data,
    $descr
);

foreach ($pre_cache['aos6_fan_oids'] as $index => $data) {
    if (is_array($data)) {
        $oid = '.1.3.6.1.4.1.6486.800.1.1.1.3.1.1.11.1.2.' . $index;
        $state_name = 'alaChasEntPhysFanStatus';
        $current = $data['alaChasEntPhysFanStatus'];
        [$revindex, $revchass, $revdata,] = explode('.', strrev($oid), 4);
        $chassis = strrev($revchass);
        $indexName = strrev($revindex);
        $descr = 'Chassis-' . ($chassis - 568) . " Fan $indexName";
        $states = [
            ['value' => 0, 'generic' => 1, 'graph' => 1, 'descr' => 'noStatus'],
            ['value' => 1, 'generic' => 1, 'graph' => 1, 'descr' => 'notRunning'],
            ['value' => 2, 'generic' => 0, 'graph' => 1, 'descr' => 'running'],
        ];
        if (!empty($current)) {
            create_state_index($state_name, $states);
            discover_sensor($valid['sensor'], 'state', $device, $oid, $index, $state_name, $descr, 1, 1, null, null, null, null, $current);
            create_sensor_to_state_index($device, $state_name, $index);
       }
   }
};
unset(
    $index,
    $data,
    $descr
);

if (($stack_left < $stacking) && ($stack_alone < $stacking_non)) {
foreach ($pre_cache['aos6_stack_oids'] as $stackindexa => $stack_data_a) {
    if (is_array($stack_data_a)) {
        $oid_stackport_a = '.1.3.6.1.4.1.6486.800.1.2.1.24.1.1.1.1.4.' . $stackindexa;
	$current_stacka = $stack_data_a['alaStackMgrLocalLinkStateA'];
	echo "CURRENT_STACK_A $stackindexa \n";
	$stack_state_namea = 'alaStackMgrLocalLinkStateA';
        $descr_stacka = 'Stack Port A Chassis-' . "$stackindexa";
        $states_stacka = [
               ['value' => 1, 'generic' => 0, 'graph' => 1, 'descr' => 'Connected'],
               ['value' => 2, 'generic' => 2, 'graph' => 1, 'descr' => 'Disconnected'],
         ];
           create_state_index($stack_state_namea, $states_stacka);
           discover_sensor($valid['sensor'], 'state', $device, $oid_stackport_a, $stackindexa, $stack_state_namea, $descr_stacka, 1, 1, null, null, null, null, $current_stacka);
           create_sensor_to_state_index($device, $stack_state_namea, $stackindexa);
       }
 }
};


if (($stack_left < $stacking) && ($stack_alone < $stacking_non)) {
foreach ($pre_cache['aos6_stack_oids'] as $stackindexb => $stack_data_b) {
    if (is_array($stack_data_b)) {
        $oid_stackport_b = '.1.3.6.1.4.1.6486.800.1.2.1.24.1.1.1.1.7.' . $stackindexb;
        $current_stackb = $stack_data_b['alaStackMgrLocalLinkStateB'];
        echo "CURRENT_STACK_B $stackindexb \n";
        $stack_state_nameb= 'alaStackMgrLocalLinkStateB';
        $descr_stackb = 'Stack Port B Chassis-' . "$stackindexb";
        $states_stackb = [
               ['value' => 1, 'generic' => 0, 'graph' => 1, 'descr' => 'Connected'],
               ['value' => 2, 'generic' => 2, 'graph' => 1, 'descr' => 'Disconnected'],
         ];
           create_state_index($stack_state_nameb, $states_stackb);
           discover_sensor($valid['sensor'], 'state', $device, $oid_stackport_b, $stackindexb, $stack_state_nameb, $descr_stackb, 1, 1, null, null, null, null, $current_stackb);
           create_sensor_to_state_index($device, $stack_state_nameb, $stackindexb);
       }
   }

};

foreach ($pre_cache['aos6_sync_oids'] as $index => $data) {
    if (is_array($data)) {
        $sync_chas_oid = '.1.3.6.1.4.1.6486.800.1.1.1.3.1.1.1.1.5.65';
        $sync_state = 'chasControlCertifyStatus';
        $sync_value = "chasControlCertifyStatus.1";
        $descr_sync = 'Certify/Restore Status';
        $sync_chas_states = [
            ['value' => 1, 'generic' => 2, 'graph' => 1, 'descr' => 'Unknown'],
            ['value' => 2, 'generic' => 1, 'graph' => 1, 'descr' => 'Need Certify'],
            ['value' => 3, 'generic' => 0, 'graph' => 1, 'descr' => 'Certified'],
        ];
        create_state_index($sync_state, $sync_chas_states);
        discover_sensor($valid['sensor'], 'state', $device, $sync_chas_oid, 1, $sync_state, $descr_sync, 1, 1, null, null, null, null, $sync_value);
        create_sensor_to_state_index($device, $sync_state, 1);
    }
};

unset(
    $sync_chas_oid,
    $sync_state,
    $sync_value,
    $descr_sync,
    $sync_chas_states,
    $data,
    $index
);

foreach ($pre_cache['aos6_sync_oids'] as $index => $data) {
    if (is_array($data)) {
        $sync_chas_oid = '.1.3.6.1.4.1.6486.800.1.1.1.3.1.1.1.1.6.65';
        $sync_state = 'chasControlSynchronizationStatus';
        $sync_value = "chasControlSynchronizationStatus.1";
        $descr_sync = 'Flash Between CMMs';
        $sync_chas_states = [
            ['value' => 1, 'generic' => 2, 'graph' => 1, 'descr' => 'Unknown'],
            ['value' => 2, 'generic' => 1, 'graph' => 1, 'descr' => 'Mono Control Module'],
            ['value' => 3, 'generic' => 1, 'graph' => 1, 'descr' => 'Not Synchronized'],
            ['value' => 4, 'generic' => 0, 'graph' => 1, 'descr' => 'Synchronized'],
        ];
        create_state_index($sync_state, $sync_chas_states);
        discover_sensor($valid['sensor'], 'state', $device, $sync_chas_oid, 1, $sync_state, $descr_sync, 1, 1, null, null, null, null, $sync_value);
        create_sensor_to_state_index($device, $sync_state, 1);
    }
};

$type = 'alclnkaggAggNbrAttachedPorts';
foreach ($pre_cache['aos6_lag_oids'] as $index => $entry) {
    $oid_size = $entry['alclnkaggAggSize'];
    $oid_mem = $entry['alclnkaggAggNbrAttachedPorts'];
    $lag_state = '.1.3.6.1.4.1.6486.800.1.2.1.13.1.1.1.1.1.19.' . $index;
   // $oid_state = "alclnkaggAggNbrAttachedPorts.$index";
    $lag_number = $entry['alclnkaggAggNumber'];
    if (! empty($oid_mem)) {
            if ( $oid_size == $oid_mem) {
                    $current = 1;
            }
            if ($oid_size > $oid_mem) {
                    $current = 2;
            }

    }
echo "current $current \n";
         $descr_lag = 'LACP Number ' . $lag_number;
         $lag_states = [
            ['value' => 1, 'generic' => 0, 'graph' => 1, 'descr' => 'Redundant'],
            ['value' => 2, 'generic' => 1, 'graph' => 1, 'descr' => 'Not Redundant']
        ];
        if (! empty($oid_mem)) {
        create_state_index($type, $lag_states);
        discover_sensor($valid['sensor'], 'state', $device, $lag_state, $index, $type, $descr_lag, 1, 1, null, null, null, null, $current);
        create_sensor_to_state_index($device, $type, $index);
    }
}




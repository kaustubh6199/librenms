<?php

$oids = snmpwalk_cache_oid($device, 'af60StaTxMCS', [], 'UI-AF60-MIB', 'ubnt', '-OteQUsb'); //UBNT-AFLTU-MIB::afLTUStaTxRate
$oids = snmpwalk_cache_oid($device, 'af60StaRxMCS', $oids, 'UI-AF60-MIB', 'ubnt', '-OteQUsb'); //UBNT-AFLTU-MIB::afLTUStaRxRate

foreach ($oids as $index => $entry) {
    //Create State Index
    $txmcs_state_name = 'af60StaTxMCS';
    $rxmcs_state_name = 'af60StaRxMCS';

    $rate_states = [
        ['value' => 1, 'generic' => 2, 'graph' => 1, 'descr' => '1X'],
        ['value' => 2, 'generic' => 2, 'graph' => 1, 'descr' => '2X'],
        ['value' => 3, 'generic' => 1, 'graph' => 1, 'descr' => '3X'],
        ['value' => 4, 'generic' => 1, 'graph' => 1, 'descr' => '4X'],
        ['value' => 5, 'generic' => 0, 'graph' => 1, 'descr' => '5X'],
        ['value' => 6, 'generic' => 0, 'graph' => 1, 'descr' => '6X'],
        ['value' => 7, 'generic' => 0, 'graph' => 1, 'descr' => '7X'],
        ['value' => 8, 'generic' => 0, 'graph' => 1, 'descr' => '8X'],
        ['value' => 9, 'generic' => 0, 'graph' => 1, 'descr' => '9X'],
    ];

    create_state_index($txmcs_state_name, $rate_states);
    create_state_index($rxmcs_state_name, $rate_states);

    //Discover Sensors
    discover_sensor($valid['sensor'], 'state', $device, '.1.3.6.1.4.1.41112.1.11.1.3.1.5.' . $index, 1, $txmcs_state_name, 'TX MCS Rate', '1', '1', null, null, null, null, $entry['af60StaTxMCS']);
    discover_sensor($valid['sensor'], 'state', $device, '.1.3.6.1.4.1.41112.1.11.1.3.1.6.' . $index, 2, $rxmcs_state_name, 'RX MCS Rate', '1', '1', null, null, null, null, $entry['af60StaRxMCS']);

    //Create Sensor To State Index
    create_sensor_to_state_index($device, $txmcs_state_name, 1);
    create_sensor_to_state_index($device, $rxmcs_state_name, 2);

    break;
}

unset(
    $oids,
    $index,
    $entry,
    $rate_states,
    $txmcs_state_name,
    $rxmcs_state_name
);

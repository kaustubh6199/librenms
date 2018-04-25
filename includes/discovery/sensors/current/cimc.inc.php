<?php

$pwr_board = snmpwalk_array_num($device, '.1.3.6.1.4.1.9.9.719.1.9.14');

/*
* False == OID not found - this is not an error.
* null  == timeout or something else that caused an error.
*/
if (is_null($pwr_board)) {
    echo "Error\n";
} else {
    $index = 1;

    // Board Input Current
    $oid = '.1.3.6.1.4.1.9.9.719.1.9.14.1.8';
    $description = "MB Input Current";
    d_echo($oid." - ".$description." - ".$pwr_board[$oid][$index]."\n");
    discover_sensor($valid['sensor'], 'current', $device, $oid.".".$index, 'mb-input-current', 'cimc', $description, '1', '1', null, null, null, null, $temp_board[$oid][$index]);

}

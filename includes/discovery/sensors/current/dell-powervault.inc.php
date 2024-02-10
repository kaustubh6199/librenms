<?php
$cur_oid = '.1.3.6.1.3.94.1.8.1.6.';

# These sensors are not provided as tables. They are strings of the form:
#    Sensor Name: Value
#
# The list is also a mix of voltages, temperatures, and state, and uses both F and C for temperatures

if (is_array($pre_cache['dell-powervault'])) {
    foreach ($pre_cache['dell-powervault'] as $index => $entry) {
        if (str_contains($entry['connUnitSensorMessage'], 'Current')) {
            $connUnitSensorMessage = explode(':', $entry['connUnitSensorMessage']);
            preg_match('/^ ([0-9]+\.[0-9]+)A$/', array_pop($connUnitSensorMessage), $matches);
            $value = $matches[1];
            $descr = implode(':', $connUnitSensorMessage);

            discover_sensor($valid['sensor'], 'current', $device, $cur_oid . $index, $index, 'dell', $descr, '1', '1', null, null, null, null, $value, 'snmp', $index);
        }
    }
}
unset($cur_oid,
    $connUnitSensorMessage,
    $value,
    $descr
);
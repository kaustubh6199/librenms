<?php
/**
 * gw-eydfa.inc.php
 *
 * LibreNMS temperature discovery module for Glass Way WDM EYDFA Optical Amplifier
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2018 TheGreatDoc
 * @author     TheGreatDoc
 */

$oids = snmp_walk($device, 'oaPumpTable', '-Osq', 'NSCRTV-HFCEMS-OPTICALAMPLIFIER-MIB');
d_echo($oids."\n");

if ($oids) {
    echo 'GW EYDFA PUMP ';
}

foreach (explode("\n", $oids) as $data) {
    list($oid, $value) = explode(' ', $data);
    $split_oid = explode('.', $oid);
    $index = $split_oid[1];
    // Check for sensor type
    if ($split_oid[0] == "oaPumpBIAS") { // Current - mA
        $divisor = 1000;
        $descr = 'BIAS Pump - ' . $index;
        $num_oid = '.1.3.6.1.4.1.17409.1.11.4.1.2.' . $index;
        $low_limit = snmp_get($device, 'analogAlarmLOLO.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 1000;
        $low_warn = snmp_get($device, 'analogAlarmLO.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 1000;
        $high_warn = snmp_get($device, 'analogAlarmHI.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 1000;
        $high_limit = snmp_get($device, 'analogAlarmHIHI.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 1000;
        $sensor_index = str_replace(' ', '', $descr);
        discover_sensor($valid['sensor'], 'current', $device, $num_oid, $sensor_index, 'gw-eydfa', $descr, $divisor, null, $low_limit, $low_warn, $high_warn, $high_limit, $value);
    }
    if ($split_oid[0] == "oaPumpTEC" && $index = 1) { // Current - A
        $divisor = 100;
        $descr = 'TEC Pump - ' . $index;
        $num_oid = '.1.3.6.1.4.1.17409.1.11.4.1.3.' . $index;
        $low_limit = snmp_get($device, 'analogAlarmLOLO.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 100;
        $low_warn = snmp_get($device, 'analogAlarmLO.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 100;
        $high_warn = snmp_get($device, 'analogAlarmHI.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 100;
        $high_limit = snmp_get($device, 'analogAlarmHIHI.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 100;
        $sensor_index = str_replace(' ', '', $descr);
        discover_sensor($valid['sensor'], 'current', $device, $num_oid, $sensor_index, 'gw-eydfa', $descr, $divisor, null, $low_limit, $low_warn, $high_warn, $high_limit, $value);
    }
    if ($split_oid[0] == "oaPumpTemp" && $index = 1) { // Temperature - C
        $divisor = 10;
        $descr = 'Temperature Pump - ' . $index;
        $num_oid = '.1.3.6.1.4.1.17409.1.11.4.1.4.' . $index;
        $low_limit = snmp_get($device, 'analogAlarmLOLO.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
        $low_warn = snmp_get($device, 'analogAlarmLO.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
        $high_warn = snmp_get($device, 'analogAlarmHI.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
        $high_limit = snmp_get($device, 'analogAlarmHIHI.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
        $sensor_index = str_replace(' ', '', $descr);
        discover_sensor($valid['sensor'], 'temperature', $device, $num_oid, $sensor_index, 'gw-eydfa', $descr, $divisor, null, $low_limit, $low_warn, $high_warn, $high_limit, $value);
    }
    unset($oids, $split_oid, $index, $divisor, $descr, $low_limit, $low_warn, $high_warn, $sensor_index);
}



$oids = snmp_walk($device, 'oaDCPowerTable', '-Osq', 'NSCRTV-HFCEMS-OPTICALAMPLIFIER-MIB');
d_echo($oids."\n");

if ($oids) {
    echo 'GW EYDFA DC POWER ';
}

foreach (explode("\n", $oids) as $data) {
    list($oid, $value) = explode(' ', $data);
    $split_oid = explode('.', $oid);
    $index = $split_oid[1];
    // Check for sensor type
    if ($split_oid[0] == "oaDCPowerVoltage") { // Voltage - V
        $divisor = 10;
        $descr = 'DC +5V - ' . $index;
        $num_oid = '.1.3.6.1.4.1.17409.1.11.7.1.2.' . $index;
        $low_limit = snmp_get($device, 'analogAlarmLOLO.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
        $low_warn = snmp_get($device, 'analogAlarmLO.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
        $high_warn = snmp_get($device, 'analogAlarmHI.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
        $high_limit = snmp_get($device, 'analogAlarmHIHI.13' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
        $sensor_index = str_replace(' ', '', $descr);
        discover_sensor($valid['sensor'], 'voltage', $device, $num_oid, $sensor_index, 'gw-eydfa', $descr, $divisor, null, $low_limit, $low_warn, $high_warn, $high_limit, $value);
    }
}

unset($oids, $split_oid, $index, $divisor, $descr, $low_limit, $low_warn, $high_warn, $sensor_index);

// Internal Temperature
$num_oid = '.1.3.6.1.4.1.17409.1.3.3.2.2.1.12.1';
$value = snmp_get($device, 'commonDeviceInternalTemperature.1', '-Ovq', 'NSCRTV-HFCEMS-COMMON-MIB');
$descr = 'Internal Temp';
$low_limit = snmp_get($device, 'analogAlarmLOLO.12.1.3.6.1.4.1.17409.1.3.1.13.0', '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB');
$low_warn = snmp_get($device, 'analogAlarmLO.12.1.3.6.1.4.1.17409.1.3.1.13.0', '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB');
$high_warn = snmp_get($device, 'analogAlarmHI.12.1.3.6.1.4.1.17409.1.3.1.13.0', '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB');
$high_limit = snmp_get($device, 'analogAlarmHIHI.12.1.3.6.1.4.1.17409.1.3.1.13.0', '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB');
$sensor_index = str_replace(' ', '', $descr);
discover_sensor($valid['sensor'], 'temperature', $device, $num_oid, $sensor_index, 'gw-eydfa', $descr, null, null, $low_limit, $low_warn, $high_warn, $high_limit, $value);

unset($num_oid, $value, $descr, $low_limit, $low_warn, $high_warn, $sensor_index);

// Per Output Optical Power
$num_oid = '.1.3.6.1.4.1.17409.1.11.2.0';
$value = snmp_get($device, 'oaOutputOpticalPower.0', '-Ovq', 'NSCRTV-HFCEMS-OPTICALAMPLIFIER-MIB');
$divisor = 10;
$descr = 'Per Output Power';
$low_limit = snmp_get($device, 'analogAlarmLOLO.11' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
$low_warn = snmp_get($device, 'analogAlarmLO.11' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
$high_warn = snmp_get($device, 'analogAlarmHI.11' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
$high_limit = snmp_get($device, 'analogAlarmHIHI.11' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
$sensor_index = str_replace(' ', '', $descr);
discover_sensor($valid['sensor'], 'dbm', $device, $num_oid, $sensor_index, 'gw-eydfa', $descr, $divisor, null, $low_limit, $low_warn, $high_warn, $high_limit, $value);

unset($num_oid, $value, $divisor, $descr, $low_limit, $low_warn, $high_warn, $sensor_index);

// Input Optical Power
$num_oid = '.1.3.6.1.4.1.17409.1.11.3.0';
$value = snmp_get($device, 'oaInputOpticalPower.0', '-Ovq', 'NSCRTV-HFCEMS-OPTICALAMPLIFIER-MIB');
$divisor = 10;
$descr = 'Input Power';
$low_limit = snmp_get($device, 'analogAlarmLOLO.11' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
$low_warn = snmp_get($device, 'analogAlarmLO.11' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
$high_warn = snmp_get($device, 'analogAlarmHI.11' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
$high_limit = snmp_get($device, 'analogAlarmHIHI.11' . $num_oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB') / 10;
$sensor_index = str_replace(' ', '', $descr);
discover_sensor($valid['sensor'], 'dbm', $device, $num_oid, $sensor_index, 'gw-eydfa', $descr, $divisor, null, $low_limit, $low_warn, $high_warn, $high_limit, $value);

unset($num_oid, $value, $divisor, $descr, $low_limit, $low_warn, $high_warn, $sensor_index);

// Power Supply State

$oids = array('.1.3.6.1.4.1.17409.1.1.2.1.4.11.1.3.6.1.4.1.17409.1.11.100.0.2', '.1.3.6.1.4.1.17409.1.1.2.1.4.11.1.3.6.1.4.1.17409.1.11.101.0.2');

$state_name = 'PowerSupplyState';
$states = array(
    array('value' => 1, 'generic' => 0, 'graph' => 0, 'descr' => 'normal'),
    array('value' => 7, 'generic' => 1, 'graph' => 0, 'descr' => 'warning'),
    array('value' => 6, 'generic' => 2, 'graph' => 0, 'descr' => 'critical'),
);
create_state_index($state_name, $states);
$n = 1;
foreach ($oids as $oid) {
    $value = snmp_get($device, $oid, '-Ovq', 'NSCRTV-HFCEMS-PROPERTY-MIB');
    $descr = 'Power Supply ' . $n;
    $sensor_index = str_replace(' ', '', $descr);
    discover_sensor($valid['sensor'], 'state', $device, $oid, $sensor_index, $state_name, $descr, '1', '1', null, null, null, null, $value, 'snmp');
    create_sensor_to_state_index($device, $state_name, $sensor_index);
    $n++;
}

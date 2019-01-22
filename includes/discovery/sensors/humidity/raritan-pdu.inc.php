<?php
/**
 * raritan-pdu.inc.php
 *
 * LibreNMS temperature sensor discovery module for Raritan
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
 * @copyright  2017 Neil Lathwood
 * @author     Neil Lathwood <gh+n@laf.io>
 */

$descr = 'Processor Humidity';
$divisor = 1;
$multiplier = '1';
d_echo('Humidity for Raritan PDU2');
foreach ($pre_cache['raritan_extSensorConfig'] as $index => $data) {
    // sensor type 10 for temperature
    d_echo('value for sensor type '.$data['externalSensorType'].'\n');
    if ($data['externalSensorType'] == 'humidity') {
        $descr           = $data['externalSensorName'];
        $oid             = ".1.3.6.1.4.1.13742.6.5.5.3.1.4.$index";
        $low_limit       = $data['externalSensorLowerCriticalThreshold'];
        $low_warn_limit  = $data['externalSensorLowerWarningThreshold'];
        $high_limit      = $data['externalSensorUpperCriticalThreshold'];
        $high_warn_limit = $data['externalSensorUpperWarningThreshold'];

        $measure_data = $pre_cache['raritan_extSensorMeasure'][$index];
        $current      = ($measure_data['measurementsExternalSensorValue'] / $divisor);
        $sensor_available = $measure_data['measurementsExternalSensorIsAvailable'];
        d_echo("Raritan pdu stuff ".$current." ".$sensor_available." \n");
        d_echo("Raritan pdu stuff ".$oid."\n");
        $user_func = null;
        if (is_numeric($current) && $current >= 0 && sensor_available == true) {
            discover_sensor($valid['sensor'], 'humidity', $device, $oid, 'measurementsExternalSensorValue.'.$index, 'raritan', $descr, $divisor, $multiplier, $low_limit, $low_warn_limit, $high_warn_limit, $high_limit, $current, 'snmp', null, null, $user_func);
        }
    }
}

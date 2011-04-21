<?php

global $valid_sensor;

if ($device['os'] == "netvision")
{
  $freq_oid   = "1.3.6.1.4.1.4555.1.1.1.1.3.2.0";
  $descr      = "Input";
  $current    = snmp_get($device, $freq_oid, "-Oqv") / 10;
  $type       = "netvision";
  $divisor  = 10;
  $index      = '3.2.0';
  discover_sensor($valid_sensor, 'frequency', $device, $freq_oid, $index, $type, $descr, $divisor, '1', NULL, NULL, NULL, NULL, $current);

  $freq_oid   = "1.3.6.1.4.1.4555.1.1.1.1.4.2.0";
  $descr      = "Output";
  $current    = snmp_get($device, $freq_oid, "-Oqv") / 10;
  $type       = "netvision";
  $divisor  = 10;
  $index      = '4.2.0';
  discover_sensor($valid_sensor, 'frequency', $device, $freq_oid, $index, $type, $descr, $divisor, '1', NULL, NULL, NULL, NULL, $current);
}

?>
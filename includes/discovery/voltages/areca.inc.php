<?php

global $valid_sensor;

## Areca Voltages
if ($device['os'] == "areca") 
{
  $oids = snmp_walk($device, "1.3.6.1.4.1.18928.1.2.2.1.8.1.2", "-OsqnU", "");
  if ($debug) { echo($oids."\n"); }
  if ($oids) echo("Areca ");
  $divisor = 1000;
  $type = "areca";
  foreach(explode("\n", $oids) as $data) 
  {
    $data = trim($data);
    if ($data) 
    {
      list($oid,$descr) = explode(" ", $data,2);
      $split_oid = explode('.',$oid);
      $index = $split_oid[count($split_oid)-1];
      $oid  = "1.3.6.1.4.1.18928.1.2.2.1.8.1.3." . $index;
      $current = snmp_get($device, $oid, "-Oqv", "") / $divisor;
      if ($descr != '"Battery Status"' || $current != 0.255) # FIXME not sure if this is supposed to be a voltage, but without BBU it's 225, then ignore.
      {
        echo discover_sensor($valid_sensor, 'voltage', $device, $oid, $index, $type, trim($descr,'"'), $divisor, '1', NULL, NULL, NULL, NULL, $current);
      }
    }
  }
}
?>
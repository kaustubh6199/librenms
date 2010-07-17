<?php

global $valid_temp;
 
if ($device['os'] == "powerconnect") 
{
  $oids = snmp_get($device, ".1.3.6.1.4.1.674.10895.5000.2.6132.1.1.43.1.8.1.4.0", "-OsqnU", "");
  if ($debug) { echo($oids."\n"); }
  if ($oids)
  {
    echo("Powerconnect ");
    list($oid,$current) = explode(' ',$oids);
    $precision = 1;
    $type = "powerconnect";
    $index = 0;
    $descr = "Internal Temperature";
    discover_temperature($valid_temp, $device, $oid, $index, $type, $descr, $precision, NULL, NULL, $current);
  }
}

?>

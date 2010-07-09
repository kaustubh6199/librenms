<?php

global $valid_temp;
  
if (strstr($device['hardware'], "dell"))
{
  $oids = snmp_walk($device, ".1.3.6.1.4.1.674.10892.1.700.20.1.8", "-Osqn", "MIB-Dell-10892");
  $oids = trim($oids);
  if ($oids) echo("Dell OMSA ");
  foreach(explode("\n",$oids) as $oid)
  {
    $oid = substr(trim($oid), 36);
    list($oid) = explode(" ", $oid);
    if ($oid != "")
    {
      $descr_query = snmp_get($device, ".1.3.6.1.4.1.674.10892.1.700.20.1.8.$oid", "-Onvq", "MIB-Dell-10892");
      $descr = trim(str_replace("\"", "", shell_exec($descr_query)));
      $fulloid = ".1.3.6.1.4.1.674.10892.1.700.20.1.6.$oid";
      discover_temperature($valid_temp, $device, $fulloid, $oid, "dell", $descr, "10", NULL, NULL, NULL);
    }
  }
}


?>

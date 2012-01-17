<?php


echo(" NetScaler ");

echo(" Caching OIDs:");

if (!is_array($ns_sensor_array))
{
  $ns_sensor_array = array();
  echo(" sysHealthCounterValue ");
  $ns_sensor_array = snmpwalk_cache_multi_oid($device, "sysHealthCounterValue", $ns_sensor_array, "NS-ROOT-MIB");
}

foreach($ns_sensor_array as $descr => $data)
{

  $current = $data['sysHealthCounterValue'];

  $oid = ".1.3.6.1.4.1.5951.4.1.1.41.7.1.2.".strlen($descr);
  for($i = 0; $i != strlen($descr); $i++)
  {
     $oid .= ".".ord($descr[$i]);
  }

  if     (strpos($descr, "Temp") !== FALSE) { $divisor = 0; $multiplier = 0; $type = "temperature"; }
  elseif (strpos($descr, "Fan")  !== FALSE) { $divisor = 0; $multiplier = 0; $type = "fanspeed"; }
  elseif (strpos($descr, "Volt") !== FALSE) { $divisor = 1000; $multiplier = 0; $type = "voltage"; }
  elseif (strpos($descr, "Vtt")  !== FALSE) { $divisor = 1000; $multiplier = 0; $type = "voltage"; }

  if($divisor) { $current = $current / $divisor; };

  discover_sensor($valid['sensor'], $type, $device, $oid, $descr, 'netscaler-health', $descr, $divisor, $multiplier, NULL, NULL, NULL, NULL, $current);

}


unset($ns_sensor_array);

?>

<?php

global $valid_sensor;
global $entity_temperature;

if (mysql_result(mysql_query("SELECT COUNT(*) FROM `sensors` WHERE `device_id` = '".$device['device_id']."' AND `sensor_class` = 'temperature' AND (`sensor_type` = 'cisco-entity-sensor' OR `sensor_type` = 'entity-sensor')"),0) == "0" && ($device['os'] == "ios" || $device['os_group'] == "ios"))
{
  echo("Cisco ");
  $oids = snmp_walk($device, ".1.3.6.1.4.1.9.9.13.1.3.1.2", "-Osqn", "CISCO-ENVMON-MIB");
  $oids = str_replace('.1.3.6.1.4.1.9.9.13.1.3.1.2.','',$oids);
  $oids = trim($oids);
  foreach (explode("\n", $oids) as $data)
  {
    $data = trim($data);
    if ($data)
    {
      list($index) = explode(" ", $data);
      $oid  = ".1.3.6.1.4.1.9.9.13.1.3.1.3.$index";
      $descr_oid = ".1.3.6.1.4.1.9.9.13.1.3.1.2.$index";
      $descr = snmp_get($device, $descr_oid, "-Oqv", "CISCO-ENVMON-MIB");
      $temperature = snmp_get($device, $oid, "-Oqv", "CISCO-ENVMON-MIB");
      if (!strstr($descr, "No") && !strstr($temperature, "No") && $descr != "")
      {
        $descr = str_replace("\"", "", $descr);
        $descr = str_replace("temperature", "", $descr);
        $descr = str_replace("temperature", "", $descr);
        $descr = trim($descr);

        discover_sensor($valid_sensor, 'temperature', $device, $oid, $index, 'cisco', $descr, '1', '1', NULL, NULL, NULL, NULL, $temperature);
      }
    }
  }
}

?>
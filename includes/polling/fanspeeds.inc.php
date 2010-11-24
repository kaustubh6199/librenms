<?php

$query = "SELECT * FROM sensors WHERE sensor_class='fanspeed' AND device_id = '" . $device['device_id'] . "'";
$fan_data = mysql_query($query);
while ($fanspeed = mysql_fetch_array($fan_data)) {

  echo("Checking fan " . $fanspeed['sensor_descr'] . "... ");

  $fan = snmp_get($device, $fanspeed['sensor_oid'], "-OUqnv", "SNMPv2-MIB");

  if ($fanspeed['sensor_divisor'])    { $fan = $fan / $fanspeed['sensor_divisor']; }
  if ($fanspeed['sensor_multiplier']) { $fan = $fan * $fanspeed['sensor_multiplier']; }

  $fanrrd  = $config['rrd_dir'] . "/" . $device['hostname'] . "/" . safename("fan-" . $fanspeed['sensor_descr'] . ".rrd");

  if (!is_file($fanrrd)) {
     `rrdtool create $fanrrd \
     --step 300 \
     DS:fan:GAUGE:600:0:20000 \
     RRA:AVERAGE:0.5:1:1200 \
     RRA:MIN:0.5:12:2400 \
     RRA:MAX:0.5:12:2400 \
     RRA:AVERAGE:0.5:12:2400`;
  }

  echo($fan . " rpm\n");

  rrdtool_update($fanrrd,"N:$fan");

  if ($fanspeed['sensor_current'] > $fanspeed['sensor_limit_low'] && $fan <= $fanspeed['sensor_limit_low']) 
  {
    $msg  = "Fan Alarm: " . $device['hostname'] . " " . $fanspeed['sensor_descr'] . " is " . $fan . "rpm (Limit " . $fanspeed['sensor_limit_low'];
    $msg .= "rpm) at " . date($config['timestamp_format']);
    notify($device, "Fan Alarm: " . $device['hostname'] . " " . $fanspeed['sensor_descr'], $msg);
    echo("Alerting for " . $device['hostname'] . " " . $fanspeed['sensor_descr'] . "\n");
    log_event('Fan speed ' . $fanspeed['sensor_descr'] . " under threshold: " . $fanspeed['sensor_current'] . " rpm (<= " . $fanspeed['sensor_limit_low'] . " rpm)", $device['device_id'], 'fanspeed', $fanspeed['sensor_id']);
  } 
  else if ($fanspeed['sensor_current'] > $fanspeed['sensor_limit_warn'] && $fan <= $fanspeed['sensor_limit_low_warn']) 
  {
    $msg  = "Fan Warning: " . $device['hostname'] . " " . $fanspeed['sensor_descr'] . " is " . $fan . "rpm (Warning limit " . $fanspeed['sensor_limit_low_warn'];
    $msg .= "rpm) at " . date($config['timestamp_format']);
    notify($device, "Fan Warning: " . $device['hostname'] . " " . $fanspeed['sensor_descr'], $msg);
    echo("Alerting for " . $device['hostname'] . " " . $fanspeed['sensor_descr'] . "\n");
    log_event('Fan speed ' . $fanspeed['sensor_descr'] . " under warning threshold: " . $fanspeed['sensor_current'] . " rpm (<= " . $fanspeed['sensor_limit_low_warn'] . " rpm)", $device['device_id'], 'fanspeed', $fanspeed['sensor_id']);
  }

  mysql_query("UPDATE sensors SET sensor_current = '$fan' WHERE sensor_class='fanspeed' AND sensor_id = '" . $fanspeed['sensor_id'] . "'");
}

?>

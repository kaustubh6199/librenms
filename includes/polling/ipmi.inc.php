<?php

$query = "SELECT * FROM sensors WHERE device_id = '" . $device['device_id'] . "' AND poller_type='ipmi'";
$ipmi_data = mysql_query($query);

if ($ipmi['host'] = get_dev_attrib($device,'ipmi_hostname'))
{
  $ipmi['user'] = get_dev_attrib($device,'ipmi_username');
  $ipmi['password'] = get_dev_attrib($device,'ipmi_password');

  echo("Fetching IPMI sensor data...");
  $results = shell_exec($config['ipmitool'] . " -c -H " . $ipmi['host'] . " -U " . $ipmi['user'] . " -P " . $ipmi['password'] . " sdr");
  echo(" done.\n");

  foreach (explode("\n",$results) as $row)
  {
    list($desc,$value,$type,$status) = explode(',',$row);
    $ipmi_sensor[$desc][$ipmi_unit[$type]]['value'] = $value;
    $ipmi_sensor[$desc][$ipmi_unit[$type]]['unit'] = $type;
  }

  while ($ipmisensors = mysql_fetch_assoc($ipmi_data))
  {
    echo("Updating IPMI sensor " . $ipmisensors['sensor_descr'] . "... ");

    $sensor = $ipmi_sensor[$ipmisensors['sensor_descr']][$ipmisensors['sensor_class']]['value'];
    $unit   = $ipmi_sensor[$ipmisensors['sensor_descr']][$ipmisensors['sensor_class']]['unit'];

    $rrd_file = get_sensor_rrd($device, $ipmisensors);

    ## FIXME - sensor name format change 2011/04/26 - remove this in $amount_of_time. 
    ## We don't want to reduce performance forever because douchebags don't svn up!
    $old_rrd_file = $config['rrd_dir'] . "/" . $device['hostname'] . "/" . safename($ipmisensors['sensor_class'].'-'.$ipmisensors['sensor_type'].'-'.$ipmisensors['sensor_index'] . ".rrd");

    if (is_file($old_rrd_file))
    {
      rename($old_rrd_file, $rrd_file);
    }

    if (!is_file($rrd_file))
    {
      rrdtool_create($rrd_file,"--step 300 \
      DS:sensor:GAUGE:600:-20000:20000 \
      RRA:AVERAGE:0.5:1:600 \
      RRA:AVERAGE:0.5:6:700 \
      RRA:AVERAGE:0.5:24:775 \
      RRA:AVERAGE:0.5:288:797 \
      RRA:MAX:0.5:1:600 \
      RRA:MAX:0.5:6:700 \
      RRA:MAX:0.5:24:775 \
      RRA:MAX:0.5:288:797\
      RRA:MIN:0.5:1:600 \
      RRA:MIN:0.5:6:700 \
      RRA:MIN:0.5:24:775 \
      RRA:MIN:0.5:288:797");
    }

    echo($sensor . " $unit\n");

    rrdtool_update($rrd_file,"N:$sensor");

    ## FIXME warnings in event & mail not done here yet!

    mysql_query("UPDATE sensors SET sensor_current = '$sensor' WHERE poller_type='ipmi' AND sensor_class= AND sensor_id = '" . $ipmisensors['sensor_id'] . "'");
  }

  unset($ipmi_sensor);
}

?>
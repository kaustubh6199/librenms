<?php

$temp = mysql_result(mysql_query("select count(*) from temperature WHERE device_id = '" . $device['device_id'] . "'"), 0);
$storage = mysql_result(mysql_query("select count(*) from storage WHERE host_id = '" . $device['device_id'] . "'"), 0);
$cemp = mysql_result(mysql_query("select count(*) from cempMemPool WHERE device_id = '" . $device['device_id'] . "'"), 0);
$cmp = mysql_result(mysql_query("select count(*) from cmpMemPool WHERE device_id = '" . $device['device_id'] . "'"), 0);
$processor  = mysql_result(mysql_query("select count(*) from processors WHERE device_id = '" . $device['device_id'] . "'"), 0);
$fans = mysql_result(mysql_query("select count(*) from fanspeed WHERE device_id = '" . $device['device_id'] . "'"), 0);
$volts = mysql_result(mysql_query("select count(*) from voltage WHERE device_id = '" . $device['device_id'] . "'"), 0);

if ($temp) { $datas[] = 'temp'; }
if ($storage) { $datas[] = 'storage'; }
if ($cemp) { $datas[] = 'cemp'; }
if ($cmp) { $datas[] = 'cmp'; }
if ($processor) { $datas[] = 'processors'; }
if ($fans) { $datas[] = 'fanspeeds'; }
if ($volts) { $datas[] = 'voltages'; }

$type_text['temp'] = "Temperatures";
$type_text['cmp'] = "Memory Pools";
$type_text['cemp'] = "Memory Enh Pools";
$type_text['storage'] = "Disk Usage";
$type_text['processors'] = "Processor Usage";
$type_text['voltages'] = "Voltages";
$type_text['fanspeeds'] = "Fan Speeds";


print_optionbar_start();

unset ($sep);
foreach ($datas as $type) {
  if (!$_GET['opta']) { $_GET['opta'] = $type; }
  echo($sep);
  if ($_GET['opta'] == $type) { echo("<strong>"); }
  echo("<a href='".$config['base_url']."/device/" . $device['device_id'] . "/health/" . $type . "/'>" . $type_text[$type] ."</a>\n");
  if ($_GET['opta'] == $type) { echo("</strong>"); }
  $sep = ' | ';
}
unset ($sep);

print_optionbar_end();

if (is_file("pages/device/health/".mres($_GET['opta']).".inc.php")) { include("pages/device/health/".mres($_GET['opta']).".inc.php"); }


?>

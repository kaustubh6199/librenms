<?php

$overview = 1;

$ports['total']    = dbFetchCell("SELECT COUNT(*) FROM `ports` WHERE device_id = ?", array($device['device_id']));
$ports['up']       = dbFetchCell("SELECT COUNT(*) FROM `ports` WHERE device_id = ? AND `ifOperStatus` = 'up'", array($device['device_id']));
$ports['down']     = dbFetchCell("SELECT COUNT(*) FROM `ports` WHERE device_id = ? AND `ifOperStatus` = 'down' AND `ifAdminStatus` = 'up'", array($device['device_id']));
$ports['disabled'] = dbFetchCell("SELECT COUNT(*) FROM `ports` WHERE device_id = ? AND `ifAdminStatus` = 'down'", array($device['device_id']));

$services['total']    = dbFetchCell("SELECT COUNT(service_id) FROM `services` WHERE `device_id` = ?", array($device['device_id']));
$services['up']       = dbFetchCell("SELECT COUNT(service_id) FROM `services` WHERE `device_id` = ? AND `service_status` = '1' AND `service_ignore` ='0'", array($device['device_id']));
$services['down']     = dbFetchCell("SELECT COUNT(service_id) FROM `services` WHERE `device_id` = ? AND `service_status` = '0' AND `service_ignore` = '0'", array($device['device_id']));
$services['disabled'] = dbFetchCell("SELECT COUNT(service_id) FROM `services` WHERE `device_id` = ? AND `service_ignore` = '1'", array($device['device_id']));

if ($services['down']) { $services_colour = $warn_colour_a; } else { $services_colour = $list_colour_a; }
if ($ports['down']) { $ports_colour = $warn_colour_a; } else { $ports_colour = $list_colour_a; }

echo("<div style='width: 50%; float: left;'>");

#if (file_exists("includes/dev-data-" . strtolower($device[os]) . ".inc.php")) {
  echo("<div style='background-color: #eeeeee; margin: 5px; padding: 5px;'>");
#  echo("<p class=sectionhead>Device Data</p><div style='height: 5px;'></div>");
#  include("includes/dev-data-" . strtolower($device[os]) . ".inc.php");
  include("includes/dev-overview-data.inc.php");
  echo("</div>");
#}

include("overview/ports.inc.php");
#include("overview/current.inc.php");

if ($services['total'])
{
  echo("<div style='background-color: #eeeeee; margin: 5px; padding: 5px;'>");
  echo("<p style='padding: 0px 5px 5px;' class=sectionhead><img align='absmiddle' src='".$config['base_url']."/images/16/cog.png'> Services</p><div style='height: 5px;'></div>");

  echo("
<table class=tablehead cellpadding=2 cellspacing=0 width=100%>
<tr bgcolor=$services_colour align=center><td></td>
<td width=25%><img src='images/16/cog.png' align=absmiddle> $services[total]</td>
<td width=25% class=green><img src='images/16/cog_go.png' align=absmiddle> $services[up]</td>
<td width=25% class=red><img src='images/16/cog_error.png' align=absmiddle> $services[down]</td>
<td width=25% class=grey><img src='images/16/cog_disable.png' align=absmiddle> $services[disabled]</td></tr>
</table>");

  echo("<div style='padding: 8px; font-size: 11px; font-weight: bold;'>");

  foreach (dbFetchRows("SELECT * FROM services WHERE device_id = ? ORDER BY service_type", array($device['device_id'])) as $data)
  {
    if ($data[service_status] == "0" && $data[service_ignore] == "1") { $status = "grey"; }
    if ($data[service_status] == "1" && $data[service_ignore] == "1") { $status = "green"; }
    if ($data[service_status] == "0" && $data[service_ignore] == "0") { $status = "red"; }
    if ($data[service_status] == "1" && $data[service_ignore] == "0") { $status = "blue"; }
    echo("$break<a class=$status>" . strtolower($data[service_type]) . "</a>");
    $break = ", ";
  }

  echo("</div>");
  echo("</div>");
}


### FIXME - split this into overview/syslog.inc.php?
$syslog =  dbFetchRows("SELECT *, DATE_FORMAT(timestamp, '%d/%b/%y %T') AS date from syslog WHERE device_id = ? ORDER BY timestamp DESC LIMIT 20");
if (is_array($syslog))
{
  echo("<div style='background-color: #eeeeee; margin: 5px; padding: 5px;'>");
  echo("<p style='padding: 0px 5px 5px;' class=sectionhead><img align='absmiddle' src='".$device['base_url']."/images/16/printer.png'> Recent Syslog</p>");
  echo("<table cellspacing=0 cellpadding=2 width=100%>");
  foreach ($syslog as $entry) { include("includes/print-syslog.inc.php"); }
  echo("</table>");
  echo("</div>");
}

echo("</div>");

echo("<div style='float:right; width: 50%;'>");

### Right Pane
include("overview/processors.inc.php");
include("overview/mempools.inc.php");
include("overview/storage.inc.php");
include("overview/sensors/temperatures.inc.php");
include("overview/sensors/humidity.inc.php");
include("overview/sensors/fanspeeds.inc.php");
include("overview/sensors/voltages.inc.php");
include("overview/sensors/current.inc.php");
include("overview/sensors/power.inc.php");
include("overview/sensors/frequencies.inc.php");

echo("<div style='background-color: #eeeeee; margin: 5px; padding: 5px;'>");
echo("<p style='padding: 0px 5px 5px;' class=sectionhead>");
echo('<a class="sectionhead" href="device/'.$device['device_id'].'/events/">');
echo("<img align='absmiddle' src='".$config['base_url']."/images/16/report.png'> Recent Events</a></p>");

echo("<table cellspacing=0 cellpadding=2 width=100%>");

$eventlog = dbFetchRows("SELECT *,DATE_FORMAT(datetime, '%d/%b/%y %T') as humandate FROM `eventlog` WHERE `host` = ? ORDER BY `datetime` DESC LIMIT 0,10", array($device['device_id']));
foreach ($eventlog as $entry)
{
  include("includes/print-event-short.inc.php");
}

echo("</table>");
echo("</div>");

?>

<?php

echo("
<div style='background-color: ".$list_colour_b."; margin: auto; margin-bottom: 5px; text-align: left; padding: 7px; padding-left: 11px; clear: both; display:block; height:20px;'>
<a href='".$config['base_url']."/device/" . $device['device_id'] . "/vlans/'>Basic</a> | Graphs : 
<a href='".$config['base_url']."/device/" . $device['device_id'] . "/vlans/bits/'>Bits</a> |
<a href='".$config['base_url']."/device/" . $device['device_id'] . "/vlans/pkts/'>Packets</a> | 
<a href='".$config['base_url']."/device/" . $device['device_id'] . "/vlans/nupkts/'>NU Packets</a> | 
<a href='".$config['base_url']."/device/" . $device['device_id'] . "/vlans/errors/'>Errors</a> 
</div> ");

   echo("<div style='margin: 5px;'><table border=0 cellspacing=0 cellpadding=5 width=100%>");
   $i = "1";
   $vlan_query = mysql_query("select * from vlans WHERE device_id = '".$_GET['id']."' ORDER BY 'vlan_vlan'");
   while($vlan = mysql_fetch_array($vlan_query)) {
     include("includes/print-vlan.inc");
     $i++;
   }
   echo("</table></div>");

?>

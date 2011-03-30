<?php

#  This file prints a table row for each interface

$interface['device_id'] = $device['device_id'];
$interface['hostname'] = $device['hostname'];

$if_id = $interface['interface_id'];

$interface = ifLabel($interface);

if (!is_integer($i/2)) { $row_colour = $list_colour_a; } else { $row_colour = $list_colour_b; }

$port_adsl_query = mysql_query("SELECT * FROM `ports_adsl` WHERE `interface_id` = '".$interface['interface_id']."'");
$port_adsl = mysql_fetch_assoc($port_adsl_query);

if ($interface['ifInErrors_delta'] > 0 || $interface['ifOutErrors_delta'] > 0)
{
  $error_img = generate_port_link($interface, "<img src='images/16/chart_curve_error.png' alt='Interface Errors' border=0>", "port_errors");
} else { $error_img = ""; }

if (mysql_result(mysql_query("SELECT count(*) FROM mac_accounting WHERE interface_id = '".$interface['interface_id']."'"),0))
{
  $mac = "<a href='device/".$interface['device_id']."/interface/".$interface['interface_id']."/macaccounting/'><img src='/images/16/chart_curve.png' align='absmiddle'></a>";
} else { $mac = ""; }

echo("<tr style=\"background-color: $row_colour;\" valign=top onmouseover=\"this.style.backgroundColor='$list_highlight';\" onmouseout=\"this.style.backgroundColor='$row_colour';\" onclick=\"location.href='device/".$device['device_id']."/interface/".$interface['interface_id']."/'\" style='cursor: pointer;'>
         <td valign=top width=350>");
echo("        <span class=list-large>
              " . generate_port_link($interface, $interface['ifIndex'] . ". ".$interface['label']) . " $error_img $mac
           </span><br /><span class=interface-desc>".$interface['ifAlias']."</span>");

if ($interface['ifAlias']) { echo("<br />"); }

unset ($break);

if ($port_details)
{
  $ipdata = mysql_query("SELECT * FROM `ipv4_addresses` WHERE `interface_id` = '" . $interface['interface_id'] . "'");
  while ($ip = mysql_fetch_Array($ipdata)) {
    echo("$break <a class=interface-desc href=\"javascript:popUp('/netcmd.php?cmd=whois&amp;query=$ip[ipv4_address]')\">$ip[ipv4_address]/$ip[ipv4_prefixlen]</a>");
    $break = "<br />";
  }
  $ip6data = mysql_query("SELECT * FROM `ipv6_addresses` WHERE `interface_id` = '" . $interface['interface_id'] . "'");
  while ($ip6 = mysql_fetch_Array($ip6data)) {
    echo("$break <a class=interface-desc href=\"javascript:popUp('/netcmd.php?cmd=whois&amp;query=".$ip6['ipv6_address']."')\">".Net_IPv6::compress($ip6['ipv6_address'])."/".$ip6['ipv6_prefixlen']."</a>");
    $break = "<br />";
  }
}

echo("</span>");

echo("</td><td width=100>");

if ($port_details)
{
  $interface['graph_type'] = "port_bits";
  echo(generate_port_link($interface, "<img src='graph.php?type=port_bits&amp;id=".$interface['interface_id']."&amp;from=".$day."&amp;to=".$now."&amp;width=100&amp;height=20&amp;legend=no&amp;bg=".str_replace("#","", $row_colour)."'>"));
  $interface['graph_type'] = "port_upkts";
  echo(generate_port_link($interface, "<img src='graph.php?type=port_upkts&amp;id=".$interface['interface_id']."&amp;from=".$day."&amp;to=".$now."&amp;width=100&amp;height=20&amp;legend=no&amp;bg=".str_replace("#","", $row_colour)."'>"));
  $interface['graph_type'] = "port_errors";
  echo(generate_port_link($interface, "<img src='graph.php?type=port_errors&amp;id=".$interface['interface_id']."&amp;from=".$day."&amp;to=".$now."&amp;width=100&amp;height=20&amp;legend=no&amp;bg=".str_replace("#","", $row_colour)."'>"));
}

echo("</td><td width=120>");

if ($interface['ifOperStatus'] == "up")
{
  $interface['in_rate'] = $interface['ifInOctets_rate'] * 8;
  $interface['out_rate'] = $interface['ifOutOctets_rate'] * 8;
  $in_perc = @round($interface['in_rate']/$interface['ifSpeed']*100);
  $out_perc = @round($interface['in_rate']/$interface['ifSpeed']*100);
  echo("<img src='images/16/arrow_left.png' align=absmiddle> <span style='color: " . percent_colour($in_perc) . "'>".formatRates($interface['in_rate'])."<br />
        <img align=absmiddle src='images/16/arrow_out.png'> <span style='color: " . percent_colour($out_perc) . "'>".formatRates($interface['out_rate']) . "<br />
        <img src='images/icons/arrow_pps_in.png' align=absmiddle> ".format_bi($interface['ifInUcastPkts_rate'])."pps</span><br />
        <img src='images/icons/arrow_pps_out.png' align=absmiddle> ".format_bi($interface['ifOutUcastPkts_rate'])."pps</span>");
}

echo("</td><td width=75>");
if ($interface['ifSpeed']) { echo("<span class=box-desc>".humanspeed($interface['ifSpeed'])."</span>"); }
echo("<br />");

if ($interface[ifDuplex] != "unknown") { echo("<span class=box-desc>" . $interface['ifDuplex'] . "</span>"); } else { echo("-"); }

if ($device['os'] == "ios" || $device['os'] == "iosxe")
{
  if ($interface['ifTrunk']) {
    echo("<span class=box-desc><span class=red>" . $interface['ifTrunk'] . "</span></span>");
  } elseif ($interface['ifVlan']) {
    echo("<span class=box-desc><span class=blue>VLAN " . $interface['ifVlan'] . "</span></span>");
  } elseif ($interface['ifVrf']) {
    $vrf = mysql_fetch_array(mysql_query("SELECT * FROM vrfs WHERE vrf_id = '".$interface['ifVrf']."'"));
    echo("<span style='color: green;'>" . $vrf['vrf_name'] . "</span>");
  }
}

if ($port_adsl['adslLineCoding'])
{
  echo("</td><td width=150>");
  echo($port_adsl['adslLineCoding']."/" . rewrite_adslLineType($port_adsl['adslLineType']));
  echo("<br />");
  echo("Sync:".formatRates($port_adsl['adslAtucChanCurrTxRate']) . "/". formatRates($port_adsl['adslAturChanCurrTxRate']));
  echo("<br />");
  echo("Max:".formatRates($port_adsl['adslAtucCurrAttainableRate']) . "/". formatRates($port_adsl['adslAturCurrAttainableRate']));
  echo("</td><td width=150>");
  echo("Atten:".$port_adsl['adslAtucCurrAtn'] . "dB/". $port_adsl['adslAturCurrAtn'] . "dB");
  echo("<br />");
  echo("SNR:".$port_adsl['adslAtucCurrSnrMgn'] . "dB/". $port_adsl['adslAturCurrSnrMgn']. "dB");
} else {
  echo("</td><td width=150>");
  if ($interface['ifType'] && $interface['ifType'] != "") { echo("<span class=box-desc>" . fixiftype($interface['ifType']) . "</span>"); } else { echo("-"); }
  echo("<br />");
  if ($ifHardType && $ifHardType != "") { echo("<span class=box-desc>" . $ifHardType . "</span>"); } else { echo("-"); }
  echo("</td><td width=150>");
  if ($interface['ifPhysAddress'] && $interface['ifPhysAddress'] != "") { echo("<span class=box-desc>" . $interface['ifPhysAddress'] . "</span>"); } else { echo("-"); }
  echo("<br />");
  if ($interface['ifMtu'] && $interface['ifMtu'] != "") { echo("<span class=box-desc>MTU " . $interface['ifMtu'] . "</span>"); } else { echo("-"); }
}

echo("</td>");
echo("<td width=375 valign=top class=interface-desc>");
if (strpos($interface['label'], "oopback") === false && !$graph_type)
{
  $link_query = mysql_query("select * from links AS L, ports AS I, devices AS D WHERE L.local_interface_id = '$if_id' AND L.remote_interface_id = I.interface_id AND I.device_id = D.device_id");
  while ($link = mysql_fetch_array($link_query))
  {
#         echo("<img src='images/16/connect.png' align=absmiddle alt='Directly Connected' /> " . generate_port_link($link, makeshortif($link['label'])) . " on " . generate_device_link($link, shorthost($link['hostname'])) . "</a><br />");
#         $br = "<br />";
     $int_links[$link['interface_id']] = $link['interface_id'];
     $int_links_phys[$link['interface_id']] = 1;
  }

  unset($br);

  if ($port_details)
  { ## Show which other devices are on the same subnet as this interface
    $sql = "SELECT `ipv4_network_id` FROM `ipv4_addresses` WHERE `interface_id` = '".$interface['interface_id']."' AND `ipv4_address` NOT LIKE '127.%'";
    $nets_query = mysql_query($sql);
    while ($net = mysql_fetch_array($nets_query))
    {
      $ipv4_network_id = $net['ipv4_network_id'];
      $sql = "SELECT I.interface_id FROM ipv4_addresses AS A, ports AS I, devices AS D
           WHERE A.interface_id = I.interface_id
           AND A.ipv4_network_id = '".$net['ipv4_network_id']."' AND D.device_id = I.device_id
           AND D.device_id != '".$device['device_id']."'";
      $new_query = mysql_query($sql);
      while ($new = mysql_fetch_array($new_query))
      {
        echo($new['ipv4_network_id']);
        $this_ifid = $new['interface_id'];
        $this_hostid = $new['device_id'];
        $this_hostname = $new['hostname'];
        $this_ifname = fixifName($new['label']);
        $int_links[$this_ifid] = $this_ifid;
        $int_links_v4[$this_ifid] = 1;
      }
    }

    $sql = "SELECT ipv6_network_id FROM ipv6_addresses WHERE interface_id = '".$interface['interface_id']."'";
    $nets_query = mysql_query($sql);
    while ($net = mysql_fetch_array($nets_query))
    {
      $ipv6_network_id = $net['ipv6_network_id'];
      $sql = "SELECT I.interface_id FROM ipv6_addresses AS A, ports AS I, devices AS D
           WHERE A.interface_id = I.interface_id
           AND A.ipv6_network_id = '".$net['ipv6_network_id']."' AND D.device_id = I.device_id
           AND D.device_id != '".$device['device_id']."' AND A.ipv6_origin != 'linklayer' AND A.ipv6_origin != 'wellknown'";
      $new_query = mysql_query($sql);
      while ($new = mysql_fetch_array($new_query))
      {
        echo($new['ipv6_network_id']);
          $this_ifid = $new['interface_id'];
          $this_hostid = $new['device_id'];
          $this_hostname = $new['hostname'];
          $this_ifname = fixifName($new['label']);
          $int_links[$this_ifid] = $this_ifid;
          $int_links_v6[$this_ifid] = 1;
      }
    }
  }

  foreach ($int_links as $int_link)
  {
    $link_if = mysql_fetch_array(mysql_query("SELECT * from ports AS I, devices AS D WHERE I.device_id = D.device_id and I.interface_id = '".$int_link."'"));

    echo("$br");

    if ($int_links_phys[$int_link]) { echo("<img align=absmiddle src='images/16/connect.png'> "); } else {
                                      echo("<img align=absmiddle src='images/16/bullet_go.png'> "); }

    echo("<b>" . generate_port_link($link_if, makeshortif($link_if['label'])) . " on " . generate_device_link($link_if, shorthost($link_if['hostname'])));

    if ($int_links_v6[$int_link]) { echo(" <b style='color: #a10000;'>v6</b>"); }
    if ($int_links_v4[$int_link]) { echo(" <b style='color: #00a100'>v4</b>"); }
    $br = "<br />";
  }
#     unset($int_links, $int_links_v6, $int_links_v4, $int_links_phys, $br);
}

$pseudowires = mysql_query("SELECT * FROM `pseudowires` WHERE `interface_id` = '" . $interface['interface_id'] . "'");
while ($pseudowire = mysql_fetch_array($pseudowires))
{
#`interface_id`,`peer_device_id`,`peer_ldp_id`,`cpwVcID`,`cpwOid`
  $pw_peer_dev = mysql_fetch_array(mysql_query("SELECT * from `devices` WHERE `device_id` = '" . $pseudowire['peer_device_id'] . "'"));
  $pw_peer_int = mysql_fetch_array(mysql_query("SELECT * from `ports` AS I, pseudowires AS P WHERE I.device_id = '".$pseudowire['peer_device_id']."' AND
                                                                                                        P.cpwVcID = '".$pseudowire['cpwVcID']."' AND
                                                                                                        P.interface_id = I.interface_id"));
  $pw_peer_int = ifNameDescr($pw_peer_int);
  echo("$br<img src='images/16/arrow_switch.png' align=absmiddle><b> " . generate_port_link($pw_peer_int, makeshortif($pw_peer_int['label'])) ." on ". generate_device_link($pw_peer_dev, shorthost($pw_peer_dev['hostname'])) . "</b>");
  $br = "<br />";
}

$members = mysql_query("SELECT * FROM `ports` WHERE `pagpGroupIfIndex` = '".$interface['ifIndex']."' and `device_id` = '".$device['device_id']."'");
while ($member = mysql_fetch_array($members))
{
  echo("$br<img src='images/16/brick_link.png' align=absmiddle> <strong>" . generate_port_link($member) . " (PAgP)</strong>");
  $br = "<br />";
}

if ($interface['pagpGroupIfIndex'] && $interface['pagpGroupIfIndex'] != $interface['ifIndex'])
{
  $parent = mysql_fetch_array(mysql_query("SELECT * FROM `ports` WHERE `ifIndex` = '".$interface['pagpGroupIfIndex']."' and `device_id` = '".$device['device_id']."'"));
  echo("$br<img src='images/16/bricks.png' align=absmiddle> <strong>" . generate_port_link($parent) . " (PAgP)</strong>");
  $br = "<br />";
}

unset($int_links, $int_links_v6, $int_links_v4, $int_links_phys, $br);

echo("</td></tr>");

// If we're showing graphs, generate the graph and print the img tags

if ($graph_type == "etherlike")
{
  $graph_file = $config['rrd_dir'] . "/" . $device['hostname'] . "/port-". safename($interface['ifIndex']) . "-dot3.rrd";
} else {
  $graph_file = $config['rrd_dir'] . "/" . $device['hostname'] . "/port-". safename($interface['ifIndex']) . ".rrd";
}

if ($graph_type && is_file($graph_file))
{
  $type = $graph_type;

  $daily_traffic = "graph.php?id=$if_id&amp;type=" . $graph_type . "&amp;from=$day&amp;to=$now&amp;width=210&amp;height=100";
  $daily_url = "graph.php?id=$if_id&amp;type=" . $graph_type . "&amp;from=$day&amp;to=$now&amp;width=500&amp;height=150";

  $weekly_traffic = "graph.php?id=$if_id&amp;type=" . $graph_type . "&amp;from=$week&amp;to=$now&amp;width=210&amp;height=100";
  $weekly_url = "graph.php?id=$if_id&amp;type=" . $graph_type . "&amp;from=$week&amp;to=$now&amp;width=500&amp;height=150";

  $monthly_traffic = "graph.php?id=$if_id&amp;type=" . $graph_type . "&amp;from=$month&amp;to=$now&amp;width=210&amp;height=100";
  $monthly_url = "graph.php?id=$if_id&amp;type=" . $graph_type . "&amp;from=$month&amp;to=$now&amp;width=500&amp;height=150";

  $yearly_traffic = "graph.php?id=$if_id&amp;type=" . $graph_type . "&amp;from=$year&amp;to=$now&amp;width=210&amp;height=100";
  $yearly_url = "graph.php?id=$if_id&amp;type=" . $graph_type . "&amp;from=$year&amp;to=$now&amp;width=500&amp;height=150";

  echo("<tr style='background-color: $bg; padding: 5px;'><td colspan=7>");

  include("includes/print-interface-graphs.inc.php");

#  echo("<a href='device/" . $interface['device_id'] . "/interface/" . $interface['interface_id'] . "' onmouseover=\"return overlib('<img src=\'$daily_url\'>', LEFT".$config['overlib_defaults'].");\"
#        onmouseout=\"return nd();\"> <img src='$daily_traffic' border=0></a>");
#  echo("<a href='device/" . $interface['device_id'] . "/interface/" . $interface['interface_id'] . "' onmouseover=\"return overlib('<img src=\'$weekly_url\'>', LEFT".$config['overlib_defaults'].");\"
#        onmouseout=\"return nd();\"> <img src='$weekly_traffic' border=0></a>");
#  echo("<a href='device/" . $interface['device_id'] . "/interface/" . $interface['interface_id'] . "' onmouseover=\"return overlib('<img src=\'$monthly_url\'>', LEFT, WIDTH, 350".$config['overlib_defaults'].");\"
#        onmouseout=\"return nd();\"> <img src='$monthly_traffic' border=0></a>");
#  echo("<a href='device/" . $interface['device_id'] . "/interface/" . $interface['interface_id'] . "' onmouseover=\"return overlib('<img src=\'$yearly_url\'>', LEFT, WIDTH, 350".$config['overlib_defaults'].");\"
#        onmouseout=\"return nd();\"> <img src='$yearly_traffic' border=0></a>");

  echo("</td></tr>");
}

?>
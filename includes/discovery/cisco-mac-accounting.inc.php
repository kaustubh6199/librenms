<?php

if ($device['os_group'] == "ios")
{
  echo("Cisco MAC Accounting : ");

  $datas = shell_exec($config['snmpbulkwalk'] . " -M ".$config['mibdir']." -m CISCO-IP-STAT-MIB -Oqn -".$device['snmpver']." -c ".$device['community']." ".$device['hostname']." cipMacSwitchedBytes");
  #echo("$datas\n");
  #echo("done\n");
  foreach(explode("\n", $datas) as $data) {
    list($oid) = explode(" ", $data);
    $oid = str_replace(".1.3.6.1.4.1.9.9.84.1.2.1.1.4.", "", $oid);
    list($if, $direction, $a_a, $a_b, $a_c, $a_d, $a_e, $a_f) = explode(".", $oid);
    $oid = "$a_a.$a_b.$a_c.$a_d.$a_e.$a_f";
    unset($interface);
    $interface = mysql_fetch_array(mysql_query("SELECT * FROM ports WHERE device_id = '".$device['device_id']."' AND ifIndex = '".$if."'"));
    $ah_a = zeropad(dechex($a_a));
    $ah_b = zeropad(dechex($a_b));
    $ah_c = zeropad(dechex($a_c));
    $ah_d = zeropad(dechex($a_d));
    $ah_e = zeropad(dechex($a_e));
    $ah_f = zeropad(dechex($a_f));
    $mac = "$ah_a:$ah_b:$ah_c:$ah_d:$ah_e:$ah_f";
    $mac_cisco = "$ah_a$ah_b.$ah_c$ah_d.$ah_e$ah_f";
    $mac_cisco = $mac_table[$if][$mac]['ciscomac'];
    $clean_mac = $mac_table[$if][$mac]['cleanmac'];
    $ip = $mac_table[$if][$mac]['ip'];
    if($ip && $interface) {
      $new_mac = str_replace(":", "", $mac);
      #echo($interface['ifDescr'] . " ($if) -> $mac ($oid) -> $ip");
      if(mysql_result(mysql_query("SELECT COUNT(*) from mac_accounting WHERE interface_id = '".$interface['interface_id']."' AND mac = '$clean_mac'"),0)) {
        #$sql = "UPDATE `mac_accounting` SET `mac` = '$clean_mac' WHERE interface_id = '".$interface['interface_id']."' AND `mac` = '$clean_mac'";
        #mysql_query($sql);
        #if(mysql_affected_rows()) { echo("      UPDATED!"); }
        #echo($sql);
        echo(".");
      } else {
        #echo("      Not Exists!");
        mysql_query("INSERT INTO `mac_accounting` (interface_id,  mac) VALUES ('".$interface['interface_id']."','$clean_mac')");
        echo("+");
      }      
      #echo("\n");
    }
  }
  echo("\n");
} # os_group=ios

// FIXME - NEEDS TO REMOVE STALE ENTRIES?? :O
?>

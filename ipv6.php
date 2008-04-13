#!/usr/bin/php
<?php
include("config.php");
include("includes/functions.php");

$sql = "SELECT * FROM devices WHERE device_id LIKE '%$argv[1]' AND status = '1' AND os != 'Snom' order by device_id DESC";
$q = mysql_query($sql);
while ($device = mysql_fetch_array($q)) {

  echo("\n" . $device['hostname'] . " : ");

  $oids = shell_exec("snmpwalk -v2c -c ".$device['community']." ".$device['hostname']." ipAddressIfIndex.ipv6 -Osq");
  $oids = str_replace("ipAddressIfIndex.ipv6.", "", $oids);  $oids = str_replace("\"", "", $oids);  $oids = trim($oids);

  foreach(explode("\n", $oids) as $data) {
    $data = trim($data);
    list($ipv6addr,$ifIndex) = explode(" ", $data);

    $oid = "";
    $sep = ''; $adsep = '';
    unset($address);
    $do = '0';
    foreach(explode(":", $ipv6addr) as $part) {
      $n = hexdec($part);
      $oid = "$oid" . "$sep" . "$n";
      $sep = ".";               
      $address = $address . "$adsep" . $part;
      $do++;
      if($do == 2) { $adsep = ":"; $do = '0'; } else { $adsep = "";}      
    }

    $cidr = trim(shell_exec($config['snmpget']." -".$device['snmpver']." -c ".$device['community']." ".$device['hostname']." .1.3.6.1.2.1.4.34.1.5.2.16.$oid | sed 's/.*\.//'"));
    $origin = trim(shell_exec($config['snmpget']." -Ovq -".$device['snmpver']." -c ".$device['community']." ".$device['hostname']." .1.3.6.1.2.1.4.34.1.6.2.16.$oid"));

    $network = trim(shell_exec($config['sipcalc']." $address/$cidr | grep Subnet | cut -f 2 -d '-'"));
    $comp    = trim(shell_exec($config['sipcalc']." $address/$cidr | grep Compressed | cut -f 2 -d '-'"));

    $valid_ips[] = $address . " " . $ifIndex;

    if (mysql_result(mysql_query("SELECT count(*) FROM `interfaces` WHERE device_id = '".$device['device_id']."' AND `ifIndex` = '$ifIndex'"), 0) != '0' && $cidr > '0' && $cidr < '129' && $comp != '::1') {
      $i_query = "SELECT interface_id FROM `interfaces` WHERE device_id = '".$device['device_id']."' AND `ifIndex` = '$ifIndex'";
      $interface_id = mysql_result(mysql_query($i_query), 0);
      if (mysql_result(mysql_query("SELECT COUNT(*) FROM `ip6addr` WHERE `addr` = '$address' AND `cidr` = '$cidr' AND `interface_id` = '$interface_id'"), 0) == '0') {
       mysql_query("INSERT INTO `ip6addr` (`addr`, `comp_addr`, `cidr`, `origin`, `network`, `interface_id`) VALUES ('$address', '$comp', '$cidr', '$origin', '$network', '$interface_id')");
       echo("+");
      }
      if (mysql_result(mysql_query("SELECT COUNT(*) FROM `ip6networks` WHERE `cidr` = '$network'"), 0) < '1') {
        mysql_query("INSERT INTO `ip6networks` (`id`, `cidr`) VALUES ('', '$network')");
        echo("N");
      }
      $network_id = @mysql_result(mysql_query("SELECT id from `ip6networks` WHERE `cidr` = '$network'"), 0);
      if (match_network($nets, $address) && mysql_result(mysql_query("SELECT COUNT(*) FROM `ip6adjacencies` WHERE `network_id` = '$network_id' AND `interface_id` = '$interface_id'"), 0) < '1') {
        mysql_query("INSERT INTO `ip6adjacencies` (`network_id`, `interface_id`) VALUES ('$network_id', '$interface_id')");
        echo("A");
      }
    } else { echo("."); }   

  }

  $sql   = "SELECT * FROM ip6addr AS A, interfaces AS I WHERE A.interface_id = I.interface_id AND I.device_id = '".$device['device_id']."'";
  $data = mysql_query($sql);
  while($row = mysql_fetch_array($data)) {
    unset($valid);
    foreach($valid_ips as $valid_ip) {
      if($row['addr'] . " " . $row['ifIndex'] == $valid_ip) { $valid = 1; } 
    }
    if(!$valid) { echo("-"); mysql_query("DELETE FROM ip6addr WHERE ip6addr_id = '".$row['ip6addr_id']."'");}
  }

  unset($valid_ips);

  echo("\n");

}
?>

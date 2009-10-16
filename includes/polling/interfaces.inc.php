<?php

if($device['os'] == "CatOS" || $device['os'] == "IOS") { 
  $portifIndex = array();
  $cmd = $config['snmpwalk'] . " -CI -m CISCO-STACK-MIB -O q -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'] . " portIfIndex"; 
  echo("$cmd");
  $portifIndex_output = trim(shell_exec($cmd));
  foreach(explode("\n", $portifIndex_output) as $entry){
    $entry = str_replace("CISCO-STACK-MIB::portIfIndex.", "", $entry);
    list($slotport, $ifIndex) = explode(" ", $entry);
    $portifIndex[$ifIndex] = $slotport;
  }
#  print_r($portifIndex);
}

$interface_query = mysql_query("SELECT * FROM `interfaces` $where");
while ($interface = mysql_fetch_array($interface_query)) {

 if(!$device) { $device = mysql_fetch_array(mysql_query("SELECT * FROM `devices` WHERE `device_id` = '" . $interface['device_id'] . "'")); }

 unset($ifAdminStatus, $ifOperStatus, $ifAlias, $ifDescr);

 $interface['hostname'] = $device['hostname'];
 $interface['device_id'] = $device['device_id'];

 if($device['status'] == '1') {

   unset($update);
   unset($update_query);
   unset($seperator);

   echo("Looking at " . $interface['ifDescr'] . " on " . $device['hostname'] . "\n");

   $snmp_cmd  = $config['snmpget'] . " -m IF-MIB -O qv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'];
   $snmp_cmd .= " ifAdminStatus." . $interface['ifIndex'] . " ifOperStatus." . $interface['ifIndex'] . " ifAlias." . $interface['ifIndex'] . " ifName." . $interface['ifIndex'];
   $snmp_cmd .= " ifDescr." . $interface['ifIndex'];

   $snmp_output = trim(shell_exec($snmp_cmd));
   $snmp_output = str_replace("No Such Object available on this agent at this OID", "", $snmp_output);
   $snmp_output = str_replace("No Such Instance currently exists at this OID", "", $snmp_output);
   $snmp_output = str_replace("\"", "", $snmp_output);

   list($ifAdminStatus, $ifOperStatus, $ifAlias, $ifName, $ifDescr) = explode("\n", $snmp_output);

   $ifAdminStatus = translate_ifAdminStatus ($ifAdminStatus);
   $ifOperStatus = translate_ifOperStatus ($ifOperStatus);

   if ($ifAlias == " ") { $ifAlias = str_replace(" ", "", $ifAlias); }
   $ifAlias = trim(str_replace("\"", "", $ifAlias));
   $ifAlias = trim($ifAlias);
   $ifDescr = trim(str_replace("\"", "", $ifDescr));
   $ifDescr = trim($ifDescr);

   $ifIndex = $interface['ifIndex'];
   if($portifIndex[$ifIndex]) { 
     if($device['os'] == "CatOS") {
       $cmd = $config['snmpget'] . " -m CISCO-STACK-MIB -O qv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'] . " portName." . $portifIndex[$ifIndex];
       $ifAlias = trim(shell_exec($cmd));
     }
   }

   if($config[ifname][$device[os]]) { $ifDescr = $ifName; }

   $rrdfile = $host_rrd . "/" . $interface['ifIndex'] . ".rrd"; 

   if(!is_file($rrdfile)) {
     $woo = shell_exec($config['rrdtool'] . " create $rrdfile \
      DS:INOCTETS:COUNTER:600:0:12500000000 \
      DS:OUTOCTETS:COUNTER:600:0:12500000000 \
      DS:INERRORS:COUNTER:600:0:12500000000 \
      DS:OUTERRORS:COUNTER:600:0:12500000000 \
      DS:INUCASTPKTS:COUNTER:600:0:12500000000 \
      DS:OUTUCASTPKTS:COUNTER:600:0:12500000000 \
      DS:INNUCASTPKTS:COUNTER:600:0:12500000000 \
      DS:OUTNUCASTPKTS:COUNTER:600:0:12500000000 \
      RRA:AVERAGE:0.5:1:600 \
      RRA:AVERAGE:0.5:6:700 \
      RRA:AVERAGE:0.5:24:775 \
      RRA:AVERAGE:0.5:288:797 \
      RRA:MAX:0.5:1:600 \
      RRA:MAX:0.5:6:700 \
      RRA:MAX:0.5:24:775 \
      RRA:MAX:0.5:288:797");
   }

   if( file_exists("includes/polling/interface-" . $device['os'] . ".php") ) { include("includes/polling/interface-" . $device['os'] . ".php"); }

   if ( $interface['ifDescr'] != $ifDescr && $ifDescr != "" ) {
     $update .= $seperator . "`ifDescr` = '$ifDescr'";
     $seperator = ", ";
     mysql_query("INSERT INTO eventlog (`host`, `interface`, `datetime`, `message`) VALUES ('" . $interface['device_id'] . "', '" . $interface['interface_id'] . "', NOW(), 'ifDescr -> $ifDescr')");
   }

   if ( $interface['ifName'] != $ifName && $ifName != "" ) {
     $update .= $seperator . "`ifName` = '$ifName'";
     $seperator = ", ";
     mysql_query("INSERT INTO eventlog (`host`, `interface`, `datetime`, `message`) VALUES ('" . $interface['device_id'] . "', '" . $interface['interface_id'] . "', NOW(), 'ifName -> $ifName')");
   }
 
   if ( $interface['ifAlias'] != $ifAlias && $ifAlias != "" ) {
     $update .= $seperator . "`ifAlias` = '".mysql_real_escape_string($ifAlias)."'";
     $seperator = ", ";
     mysql_query("INSERT INTO eventlog (`host`, `interface`, `datetime`, `message`) VALUES ('" . $interface['device_id'] . "', '" . $interface['interface_id'] . "', NOW(), 'ifAlias -> $ifAlias')");
   }
   if ( $interface['ifOperStatus'] != $ifOperStatus && $ifOperStatus != "" ) {
     $update .= $seperator . "`ifOperStatus` = '$ifOperStatus'";
     $seperator = ", ";
     mysql_query("INSERT INTO eventlog (`host`, `interface`, `datetime`, `message`) VALUES ('" . $interface['device_id'] . "', '" . $interface['interface_id'] . "', NOW(), 'Interface went $ifOperStatus')");
   }
   if ( $interface['ifAdminStatus'] != $ifAdminStatus && $ifAdminStatus != "" ) {
     $update .= $seperator . "`ifAdminStatus` = '$ifAdminStatus'";
     $seperator = ", ";
     if($ifAdminStatus == "up") { $admin = "enabled"; } else { $admin = "disabled"; }
     mysql_query("INSERT INTO eventlog (`host`, `interface`, `datetime`, `message`) VALUES ('" . $interface['device_id'] . "', '" . $interface['interface_id'] . "', NOW(), 'Interface $admin')");
   }

   if ($update) {
     $update_query  = "UPDATE `interfaces` SET ";
     $update_query .= $update;
     $update_query .= " WHERE `interface_id` = '" . $interface['interface_id'] . "'";
     echo("Updating : " . $device['hostname'] . " $ifDescr\nSQL :$update_query\n\n");
     $update_result = mysql_query($update_query);
   } else {
#     echo("Not Updating : " . $device['hostname'] ." $ifDescr ( " . $interface['ifDescr'] . " )\n\n");
   }

   if($ifOperStatus == "up") {

    $snmp_data_cmd  = $config['snmpget'] . " -m IF-MIB -O qv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'];
    $snmp_data_cmd .= " ifHCInOctets." . $interface['ifIndex'] . " ifHCOutOctets." . $interface['ifIndex'] . " ifInErrors." . $interface['ifIndex'];
    $snmp_data_cmd .= " ifOutErrors." . $interface['ifIndex'] . " ifInUcastPkts." . $interface['ifIndex'] . " ifOutUcastPkts." . $interface['ifIndex'];
    $snmp_data_cmd .= " ifInNUcastPkts." . $interface['ifIndex'] . " ifOutNUcastPkts." . $interface['ifIndex'];

    $snmp_data = shell_exec($snmp_data_cmd);

    $snmp_data = str_replace("Wrong Type (should be Counter32): ","", $snmp_data);
    $snmp_data = str_replace("No Such Instance currently exists at this OID","", $snmp_data);
    list($ifHCInOctets, $ifHCOutOctets, $ifInErrors, $ifOutErrors, $ifInUcastPkts, $ifOutUcastPkts, $ifInNUcastPkts, $ifOutNUcastPkts) = explode("\n", $snmp_data);
    if($ifHCInOctets == "" || strpos($ifHCInOctets, "No") !== FALSE ) {

      $octets_cmd  = $config['snmpget'] . " -m IF-MIB -O qv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'];
      $octets_cmd .= " ifInOctets." . $interface['ifIndex'] . " ifOutOctets." . $interface['ifIndex'];
      $octets = shell_exec($octets_cmd);
      list ($ifHCInOctets, $ifHCOutOctets) = explode("\n", $octets);
    }
     $woo = "N:$ifHCInOctets:$ifHCOutOctets:$ifInErrors:$ifOutErrors:$ifInUcastPkts:$ifOutUcastPkts:$ifInNUcastPkts:$ifOutNUcastPkts";
     $ret = rrdtool_update("$rrdfile", $woo);

   } else {
     echo("Interface " . $device['hostname'] . " " . $interface['ifDescr'] . " is down\n");
  }
 }

  $rates = interface_rates ($rrdfile);
  mysql_query("UPDATE `interfaces` SET in_rate = '" . $rates['in'] . "', out_rate = '" . $rates['out'] . "' WHERE interface_id= '" . $interface['interface_id'] . "'");

}

unset($portifIndex);

?>


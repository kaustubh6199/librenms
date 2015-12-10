<?php

echo 'IPv4 Addresses : ';

$oids = trim(snmp_walk($device, 'ipAdEntIfIndex', '-Osq', 'IP-MIB'));
$oids = str_replace('ipAdEntIfIndex.', '', $oids);
$nmoids = trim(snmp_walk($device, 'ipAdEntNetMask', '-Osq', 'IP-MIB'));
$nmoids = str_replace('ipAdEntNetMask.', '', $nmoids);
$nmoids_map = array();
foreach (explode("\n", $nmoids) as $data) {
	$data		= trim($data);
	list($addr,$mask)	= explode(' ', $data);
	$nmoids_map[$addr] = $mask;
}
$port_db_ids = dbFetchRows('SELECT `ifIndex`,`port_id` FROM `ports` WHERE `device_id` = ?',array($device['device_id']));
$port_ids = array();
foreach ($port_db_ids as $entry) {
	$port_ids[$entry['ifIndex']] = $entry['port_id'];
}
foreach (explode("\n", $oids) as $data) {
    $data               = trim($data);
    list($oid,$ifIndex) = explode(' ', $data);
    //$mask               = trim(snmp_get($device, "ipAdEntNetMask.$oid", '-Oqv', 'IP-MIB'));
    $mask		= $nmoids_map[$oid];
    $addr               = Net_IPv4::parseAddress("$oid/$mask");
    $network            = $addr->network.'/'.$addr->bitmask;
    $cidr               = $addr->bitmask;

    //if (dbFetchCell('SELECT COUNT(*) FROM `ports` WHERE device_id = ? AND `ifIndex` = ?', array($device['device_id'], $ifIndex)) != '0' && $oid != '0.0.0.0' && $oid != 'ipAdEntIfIndex') {
    if ($port_ids[$ifIndex] > '0' && $oid != '0.0.0.0' && $oid != 'ipAdEntIfIndex') {
	$port_id = $port_ids[$ifIndex];
        //$port_id = dbFetchCell('SELECT `port_id` FROM `ports` WHERE `device_id` = ? AND `ifIndex` = ?', array($device['device_id'], $ifIndex));

        if (dbFetchCell('SELECT COUNT(*) FROM `ipv4_networks` WHERE `ipv4_network` = ?', array($network)) < '1') {
            dbInsert(array('ipv4_network' => $network), 'ipv4_networks');
            // echo("Create Subnet $network\n");
            echo 'S';
        }

        $ipv4_network_id = dbFetchCell('SELECT `ipv4_network_id` FROM `ipv4_networks` WHERE `ipv4_network` = ?', array($network));

        if (dbFetchCell('SELECT COUNT(*) FROM `ipv4_addresses` WHERE `ipv4_address` = ? AND `ipv4_prefixlen` = ? AND `port_id` = ?', array($oid, $cidr, $port_id)) == '0') {
            dbInsert(array('ipv4_address' => $oid, 'ipv4_prefixlen' => $cidr, 'ipv4_network_id' => $ipv4_network_id, 'port_id' => $port_id), 'ipv4_addresses');
            // echo("Added $oid/$cidr to $port_id ( $hostname $ifIndex )\n $i_query\n");
            echo '+';
        }
        else {
            echo '.';
        }

        $full_address            = "$oid/$cidr|$ifIndex";
        $valid_v4[$full_address] = 1;
    }
    else {
        echo '!';
    }//end if
}//end foreach

$sql = "SELECT * FROM ipv4_addresses AS A, ports AS I WHERE I.device_id = '".$device['device_id']."' AND  A.port_id = I.port_id";
foreach (dbFetchRows($sql) as $row) {
    $full_address = $row['ipv4_address'].'/'.$row['ipv4_prefixlen'].'|'.$row['ifIndex'];

    if (!$valid_v4[$full_address]) {
        echo '-';
        $query = dbDelete('ipv4_addresses', '`ipv4_address_id` = ?', array($row['ipv4_address_id']));
        if (!dbFetchCell('SELECT COUNT(*) FROM `ipv4_addresses` WHERE `ipv4_network_id` = ?', array($row['ipv4_network_id']))) {
            $query = dbDelete('ipv4_networks', '`ipv4_network_id` = ?', array($row['ipv4_network_id']));
        }
    }
}

echo "\n";

unset($valid_v4);

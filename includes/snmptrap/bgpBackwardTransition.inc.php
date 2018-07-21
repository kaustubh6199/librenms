<?php

$bgppeerip = strstr(strstr($entry['5'], " ", true), ".");
$bgppeerip = substr($bgppeerip, 1);
$bgpstatus = trim(strstr($entry['5'], " "));

$string = "bgpBack " . $bgppeerip . " - " . $bgpstatus . "\n";

$fp = fopen('/root/trap.txt', 'a');
fwrite($fp, $string);
fclose($fp);

$bgppeer = dbFetchRow("SELECT * FROM `bgpPeers` WHERE `device_id` = ? AND `bgpPeerIdentifier` = ?", array($device['device_id'],$bgppeerip));

if (!$bgppeer) {
    echo "Unknow peer ($bgppeerip)\n\n\n";
    exit;
}

log_event('SNMP Trap: BGP Down ' . $bgppeer['bgpPeerIdentifier'] . ' ' . $bgppeer['astext'] . ' is now ' . $bgpstatus, $device, 'bgpPeer', 5, $bgppeerip);

dbUpdate(array('bgpPeerState' => $bgpstatus), 'bgpPeers', 'bgpPeer_id=?', array($bgppeer['bgpPeer_id']));

unset($bgppeerip, $bgppeer, $bgpstatus);

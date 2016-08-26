<?php

// NET-SNMP-EXTEND-MIB::nsExtendOutputFull."mailscanner"
$oid = '.1.3.6.1.4.1.8072.1.3.2.3.1.2.11.109.97.105.108.115.99.97.110.110.101.114';
$mailscanner = snmp_get($device, $oid, '-Oqv');

echo ' mailscanner';

list ($msg_recv, $msg_rejected, $msg_relay, $msg_sent, $msg_waiting, $spam, $virus) = explode("\n", $mailscanner);

$name = 'mailscannerV2';
$app_id = $app['app_id'];
$rrd_name = array('app', $name, $app_id);
$rrd_def = array(
    'DS:msg_recv:COUNTER:600:0:125000000000',
    'DS:msg_rejected:COUNTER:600:0:12500000000',
    'DS:msg_relay:COUNTER:600:0:125000000000',
    'DS:msg_sent:COUNTER:600:0:125000000000',
    'DS:msg_waiting:COUNTER:600:0:125000000000',
    'DS:spam:COUNTER:600:0:125000000000',
    'DS:virus:COUNTER:600:0:125000000000'
);

$fields = array(
    'msg_recv'     => $msg_recv,
    'msg_rejected' => $msg_rejected,
    'msg_relay'    => $msg_relay,
    'msg_sent'     => $msg_sent,
    'msg_waiting'  => $msg_waiting,
    'spam'         => $spam,
    'virus'        => $virus,
);

$tags = compact('name', 'app_id', 'rrd_name', 'rrd_def');
data_update($device, 'app', $tags, $fields);


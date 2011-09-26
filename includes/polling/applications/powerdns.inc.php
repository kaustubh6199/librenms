<?php

## Polls powerdns statistics from script via SNMP

$powerdns_rrd  = $config['rrd_dir'] . "/" . $device['hostname'] . "/app-powerdns-".$app['app_id'].".rrd";
$powerdns_cmd  = $config['snmpget'] ." -m NET-SNMP-EXTEND-MIB -O qv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'];
$powerdns_cmd .= " nsExtendOutputFull.8.112.111.119.101.114.100.110.115";
$powerdns  = shell_exec($powerdns_cmd);
echo(" powerdns");
list ($corrupt, $def_cacheInserts, $def_cacheLookup, $latency, $pc_hit, $pc_miss, $pc_size, $qsize, $qc_hit,
      $qc_miss, $rec_answers, $rec_questions, $servfail, $tcp_answers, $tcp_queries, $timedout,
      $udp_answers, $udp_queries, $udp4_answers, $udp4_queries, $udp6_answers, $udp6_queries) = explode("\n", $powerdns);

if (!is_file($powerdns_rrd))
{
  rrdtool_create($powerdns_rrd, "--step 300 \
      DS:corruptPackets:DERIVE:600:0:125000000000 \
      DS:def_cacheInserts:DERIVE:600:0:125000000000 \
      DS:def_cacheLookup:DERIVE:600:0:125000000000 \
      DS:latency:DERIVE:600:0:125000000000 \
      DS:pc_hit:DERIVE:600:0:125000000000 \
      DS:pc_miss:DERIVE:600:0:125000000000 \
      DS:pc_size:DERIVE:600:0:125000000000 \
      DS:qsize:DERIVE:600:0:125000000000 \
      DS:qc_hit:DERIVE:600:0:125000000000 \
      DS:qc_miss:DERIVE:600:0:125000000000 \
      DS:rec_answers:DERIVE:600:0:125000000000 \
      DS:rec_questions:DERIVE:600:0:125000000000 \
      DS:servfailPackets:DERIVE:600:0:125000000000 \
      DS:q_tcpAnswers:DERIVE:600:0:125000000000 \
      DS:q_tcpQueries:DERIVE:600:0:125000000000 \
      DS:q_timedout:DERIVE:600:0:125000000000 \
      DS:q_udpAnswers:DERIVE:600:0:125000000000 \
      DS:q_udpQueries:DERIVE:600:0:125000000000 \
      DS:q_udp4Answers:DERIVE:600:0:125000000000 \
      DS:q_udp4Queries:DERIVE:600:0:125000000000 \
      DS:q_udp6Answers:DERIVE:600:0:125000000000 \
      DS:q_udp6Queries:DERIVE:600:0:125000000000 \
      RRA:AVERAGE:0.5:1:600 \
      RRA:AVERAGE:0.5:6:700 \
      RRA:AVERAGE:0.5:24:775 \
      RRA:AVERAGE:0.5:288:797 \
      RRA:MIN:0.5:1:600 \
      RRA:MIN:0.5:6:700 \
      RRA:MIN:0.5:24:775 \
      RRA:MIN:0.5:288:797 \
      RRA:MAX:0.5:1:600 \
      RRA:MAX:0.5:6:700 \
      RRA:MAX:0.5:24:775 \
      RRA:MAX:0.5:288:797");
}

rrdtool_update($powerdns_rrd,  "N:$corrupt:$def_cacheInserts:$def_cacheLookup:$latency:$pc_hit:$pc_miss:$pc_size:$qsize:$qc_hit:$qc_miss:$rec_answers:$rec_questions:$servfail:$tcp_answers:$tcp_queries:$timedout:$udp_answers:$udp_queries:$udp4_answers:$udp4_queries:$udp6_answers:$udp6_queries");

?>

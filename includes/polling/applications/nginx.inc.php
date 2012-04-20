<?php

#Polls nginx statistics from script via SNMP

$nginx_rrd  = $config['rrd_dir'] . "/" . $device['hostname'] . "/app-nginx-".$app['app_id'].".rrd";
$nginx_cmd  = $config['snmpget'] ." -m NET-SNMP-EXTEND-MIB -O qv -" . $device['snmpver'] . " -c " . $device['community'] . " " . $device['hostname'].":".$device['port'];
$nginx_cmd .= " nsExtendOutputFull.5.110.103.105.110.120";

$nginx  = shell_exec($nginx_cmd);

echo(" nginx statistics\n");

list($active, $reading, $writing, $waiting, $req) = explode("\n", $nginx);
if (!is_file($nginx_rrd)) {
    rrdtool_create ($nginx_rrd, "--step 300 \
        DS:Requests:DERIVE:600:0:125000000000 \
        DS:Active:GAUGE:600:0:125000000000 \
        DS:Reading:GAUGE:600:0:125000000000 \
        DS:Writing:GAUGE:600:0:125000000000 \
        DS:Waiting:GAUGE:600:0:125000000000 ".$config['rrd_rra']);
}
print "active: $active reading: $reading writing: $writing waiting: $waiting Requests: $req";
rrdtool_update($nginx_rrd, "N:$req:$active:$reading:$writing:$waiting");

?>

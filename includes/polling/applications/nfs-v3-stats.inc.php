<?php
$name = 'nfs-v3-stats';
$app_id = $app['app_id'];
$oid = '.1.3.6.1.4.1.8072.1.3.2.4.1.2.7.110.102.115.115.116.97.116';

echo ' ' . $name;

$nfsstats = snmp_walk($device, $oid, '-Oqv', 'NET-SNMP-EXTEND-MIB');

$rrd_name = array('app', 'nfs-stats', $app_id);
$rrd_def = array(
    'DS:rc_hits:GAUGE:600:0:U',
    'DS:rc_misses:GAUGE:600:0:U',
    'DS:rc_nocache:GAUGE:600:0:U',
    'DS:fh_lookup:GAUGE:600:0:U',
    'DS:fh_anon:GAUGE:600:0:U',
    'DS:fh_ncachedir:GAUGE:600:0:U',
    'DS:fh_ncachenondir:GAUGE:600:0:U',
    'DS:fh_stale:GAUGE:600:0:U',
    'DS:io_read:GAUGE:600:0:U',
    'DS:io_write:GAUGE:600:0:U',
    'DS:ra_size:GAUGE:600:0:U',
    'DS:ra_range01:GAUGE:600:0:U',
    'DS:ra_range02:GAUGE:600:0:U',
    'DS:ra_range03:GAUGE:600:0:U',
    'DS:ra_range04:GAUGE:600:0:U',
    'DS:ra_range05:GAUGE:600:0:U',
    'DS:ra_range06:GAUGE:600:0:U',
    'DS:ra_range07:GAUGE:600:0:U',
    'DS:ra_range08:GAUGE:600:0:U',
    'DS:ra_range09:GAUGE:600:0:U',
    'DS:ra_range10:GAUGE:600:0:U',
    'DS:ra_notfound:GAUGE:600:0:U',
    'DS:net_all:GAUGE:600:0:U',
    'DS:net_udp:GAUGE:600:0:U',
    'DS:net_tcp:GAUGE:600:0:U',
    'DS:net_tcpconn:GAUGE:600:0:U',
    'DS:rpc_calls:GAUGE:600:0:U',
    'DS:rpc_badcalls:GAUGE:600:0:U',
    'DS:rpc_badfmt:GAUGE:600:0:U',
    'DS:rpc_badauth:GAUGE:600:0:U',
    'DS:rpc_badclnt:GAUGE:600:0:U',
    'DS:proc3_null:GAUGE:600:0:U',
    'DS:proc3_getattr:GAUGE:600:0:U',
    'DS:proc3_setattr:GAUGE:600:0:U',
    'DS:proc3_lookup:GAUGE:600:0:U',
    'DS:proc3_access:GAUGE:600:0:U',
    'DS:proc3_readlink:GAUGE:600:0:U',
    'DS:proc3_read:GAUGE:600:0:U',
    'DS:proc3_write:GAUGE:600:0:U',
    'DS:proc3_create:GAUGE:600:0:U',
    'DS:proc3_mkdir:GAUGE:600:0:U',
    'DS:proc3_symlink:GAUGE:600:0:U',
    'DS:proc3_mknod:GAUGE:600:0:U',
    'DS:proc3_remove:GAUGE:600:0:U',
    'DS:proc3_rmdir:GAUGE:600:0:U',
    'DS:proc3_rename:GAUGE:600:0:U',
    'DS:proc3_link:GAUGE:600:0:U',
    'DS:proc3_readdir:GAUGE:600:0:U',
    'DS:proc3_readdirplus:GAUGE:600:0:U',
    'DS:proc3_fsstat:GAUGE:600:0:U',
    'DS:proc3_fsinfo:GAUGE:600:0:U',
    'DS:proc3_pathconf:GAUGE:600:0:U',
    'DS:proc3_commit:GAUGE:600:0:U',
);

$data = explode("\n", $nfsstats);
$fields = array(
    'rc_hits' => $data[1],
    'rc_misses' => $data[2],
    'rc_nocache' => $data[3],
    'fh_lookup' => $data[4],
    'fh_anon' => $data[5],
    'fh_ncachedir' => $data[6],
    'fh_ncachenondir' => $data[7],
    'fh_stale' => $data[8],
    'io_read' => $data[9],
    'io_write' => $data[10],
    'ra_size' => $data[0],
    'ra_range01' => $data[11],
    'ra_range02' => $data[12],
    'ra_range03' => $data[13],
    'ra_range04' => $data[14],
    'ra_range05' => $data[15],
    'ra_range06' => $data[16],
    'ra_range07' => $data[17],
    'ra_range08' => $data[18],
    'ra_range09' => $data[19],
    'ra_range10' => $data[20],
    'ra_notfound' => $data[21],
    'net_all' => $data[22],
    'net_udp' => $data[23],
    'net_tcp' => $data[24],
    'net_tcpconn' => $data[25],
    'rpc_calls' => $data[26],
    'rpc_badcalls' => $data[27],
    'rpc_badfmt' => $data[28],
    'rpc_badauth' => $data[29],
    'rpc_badclnt' => $data[30],
    'proc3_null' => $data[31],
    'proc3_getattr' => $data[32],
    'proc3_setattr' => $data[33],
    'proc3_lookup' => $data[34],
    'proc3_access' => $data[35],
    'proc3_readlink' => $data[36],
    'proc3_read' => $data[37],
    'proc3_write' => $data[38],
    'proc3_create' => $data[39],
    'proc3_mkdir' => $data[40],
    'proc3_symlink' => $data[41],
    'proc3_mknod' => $data[42],
    'proc3_remove' => $data[43],
    'proc3_rmdir' => $data[44],
    'proc3_rename' => $data[45],
    'proc3_link' => $data[46],
    'proc3_readdir' => $data[47],
    'proc3_readdirplus' => $data[48],
    'proc3_fsstat' => $data[49],
    'proc3_fsinfo' => $data[50],
    'proc3_pathconf' => $data[51],
    'proc3_commit' => $data[52],
);

$tags = compact('name', 'app_id', 'rrd_name', 'rrd_def');
data_update($device, 'app', $tags, $fields);

unset($nfsstats, $rrd_name, $rrd_def, $data, $fields, $tags);
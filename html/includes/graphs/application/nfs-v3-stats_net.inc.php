<?php
require 'includes/graphs/common.inc.php';
$scale_min     = 0;
$colours       = 'mixed';
$unit_text     = 'net stats';
$unitlen       = 15;
$bigdescrlen   = 15;
$smalldescrlen = 15;
$dostack       = 0;
$printtotal    = 0;
$addarea       = 1;
$transparency  = 33;
$rrd_filename  = get_rrd_dir($device['hostname']).'/app-nfs-stats-'.$app['app_id'].'.rrd';
$array = array(
    'net_all' => array('descr' => 'total','colour' => '000000',),
    'net_udp' => array('descr' => 'udp','colour' => 'AA3F39',),
    'net_tcp' => array('descr' => 'tcp','colour' => '2C8437',),
    'net_tcpconn' => array('descr' => 'tcp conn','colour' => '576996',),
);

$i = 0;

if (rrdtool_check_rrd_exists($rrd_filename)) {
    foreach ($array as $ds => $var) {
        $rrd_list[$i]['filename'] = $rrd_filename;
        $rrd_list[$i]['descr']    = $var['descr'];
        $rrd_list[$i]['ds']       = $ds;
        $rrd_list[$i]['colour']   = $var['colour'];
        $i++;
    }
} else {
    echo "file missing: $rrd_filename";
}

require 'includes/graphs/generic_v3_multiline.inc.php';

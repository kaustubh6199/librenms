<?php

require 'includes/html/graphs/common.inc.php';
$descr_len = 20;

$rrd_filename = rrd_name($device['hostname'], array('app', 'opensips', $app['app_id']));

$array = array(
          'total_memory' => array(
                     'descr'  => 'Total',
                     'colour' => '22FF22',
                    ),
          'used_memory' => array(
                     'descr'  => 'Used',
                     'colour' => '0022FF',
                    ),
         );

$i = 0;
if (rrdtool_check_rrd_exists($rrd_filename)) {
    foreach ($array as $ds => $var) {
        $rrd_list[$i]['filename'] = $rrd_filename;
        $rrd_list[$i]['descr']    = $var['descr'];
        $rrd_list[$i]['ds']       = $ds;
        // $rrd_list[$i]['colour'] = $var['colour'];
        $i++;
    }
} else {
    echo "file missing: $file";
}

$colours   = 'mixed';
$nototal   = 1;
$unit_text = 'bytes';

require 'includes/html/graphs/generic_multi_line.inc.php';

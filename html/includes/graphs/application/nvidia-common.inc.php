<?php
$name = 'nvidia';
$app_id = $app['app_id'];
$scale_min     = 0;
$colours       = 'manycolours';
$dostack       = 0;
$printtotal    = 0;
$addarea       = 1;
$transparency  = 15;
$name = 'nvidia';
$app_id = $app['app_id'];
$scale_min     = 0;

$int=0;
$rrd_list=array();
$rrd_filename=rrd_name($device['hostname'], array('app', $app['app_type'], $app['app_id'], $int));

if (!rrdtool_check_rrd_exists($rrd_filename)) {
    echo "file missing: $rrd_filename";
}

while (is_file($rrd_filename)) {
    $rrd_list[]=array(
        'filename' => $rrd_filename,
        'descr'    => 'GPU '.$int,
        'ds'       => $rrdVar,
    );

    $int++;
    $rrd_filename=rrd_name($device['hostname'], array('app', $app['app_type'], $app['app_id'], $int));
}

require 'includes/graphs/generic_multi_line_exact_numbers.inc.php';

<?php

$name = 'opensearch';
$app_id = $app['app_id'];
$unit_text = 'Shards';
$colours = 'greens';
$dostack = 0;
$printtotal = 0;
$addarea = 0;
$transparency = 15;

$rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app['app_id']]);

$rrd_list = [];
if (Rrd::checkRrdExists($rrd_filename)) {
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Active Primary',
        'ds'       => 'c_act_pri_shards',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Active',
        'ds'       => 'c_act_shards',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Relocating',
        'ds'       => 'c_rel_shards',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Initializing',
        'ds'       => 'c_init_shards',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Delayed Unass.',
        'ds'       => 'c_delayed_shards',
    ];
} else {
    d_echo('RRD "' . $rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_multi_line.inc.php';

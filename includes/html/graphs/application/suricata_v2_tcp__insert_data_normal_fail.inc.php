<?php

$name = 'suricata';
$unit_text = 'events/sec';
$colours = 'psychedelic';
$dostack = 0;
$printtotal = 1;
$addarea = 0;
$transparency = 15;
$descr_len = 21;

if (isset($vars['sinstance'])) {
    $tcp__insert_data_normal_fail_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'instance_' . $vars['sinstance'] . '___tcp__insert_data_normal_fail']);
} else {
    $tcp__insert_data_normal_fail_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'totals___tcp__insert_data_normal_fail']);
}

$rrd_list = [];
if (Rrd::checkRrdExists($tcp__insert_data_normal_fail_rrd_filename)) {
    $rrd_list[] = [
        'filename' => $tcp__insert_data_normal_fail_rrd_filename,
        'descr' => 'TCP Ins Data Norm Fail',
        'ds' => 'data',
    ];
} else {
    d_echo('RRD "' . $tcp__insert_data_normal_fail_rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_multi_line.inc.php';

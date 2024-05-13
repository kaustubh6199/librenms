<?php

$name = 'suricata';
$unit_text = '% Of Packets';
$colours = 'psychedelic';
$dostack = 0;
$printtotal = 0;
$addarea = 0;
$transparency = 15;

if (isset($vars['sinstance'])) {
    $rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, $vars['sinstance']]);
    $drop_percent_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'instance_' . $vars['sinstance'] .'___drop_percent' ]);
} else {
    $rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id]);
    $drop_percent_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'totals___drop_percent']);
}

$rrd_list = [];
if (Rrd::checkRrdExists($drop_percent_rrd_filename)) {
    $rrd_list[] = [
        'filename' => $drop_percent_rrd_filename,
        'descr' => 'Drop Prct',
        'ds' => 'data',
    ];
} elseif (Rrd::checkRrdExists($rrd_filename)) {
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr' => 'Dropped',
        'ds' => 'drop_percent',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr' => 'If Dropped',
        'ds' => 'ifdrop_percent',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr' => 'Error',
        'ds' => 'error_percent',
    ];
} else {
    d_echo('RRD "' . $rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_multi_line.inc.php';

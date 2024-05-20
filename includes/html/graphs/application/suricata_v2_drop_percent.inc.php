<?php

$name = 'suricata';
$unit_text = 'Packets';
$colours = 'psychedelic';
$dostack = 0;
$printtotal = 1;
$addarea = 0;
$transparency = 15;

if (isset($vars['sinstance'])) {
    $drop_percent_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'instance_' . $vars['sinstance'] . '___drop_percent']);
} else {
    $drop_percent_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'totals___drop_percent']);
}

$rrd_list = [];
if (Rrd::checkRrdExists($drop_percent_rrd_filename)) {
    $rrd_list[] = [
        'filename' => $drop_percent_rrd_filename,
        'descr' => 'Drop Prct',
        'ds' => 'data',
    ];
} else {
    d_echo('RRD "' . $drop_percent_rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_multi_line.inc.php';

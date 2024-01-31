<?php

$name = 'suricata';
$unit_text = 'packets/sec';
$colours = 'psychedelic';
$dostack = 0;
$printtotal = 1;
$addarea = 0;
$transparency = 15;

if (isset($vars['sinstance'])) {
    $tcp__syn_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'instance_' . $vars['sinstance'] . '___tcp__syn']);
} else {
    $tcp__syn_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'totals___tcp__syn']);
}

$rrd_list = [];
if (Rrd::checkRrdExists($tcp__syn_rrd_filename)) {
    $rrd_list[] = [
        'filename' => $tcp__syn_rrd_filename,
        'descr' => 'TCP Syn',
        'ds' => 'data',
    ];
} else {
    d_echo('RRD "' . $tcp__syn_rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_multi_line.inc.php';

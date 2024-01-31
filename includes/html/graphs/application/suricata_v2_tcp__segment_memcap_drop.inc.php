<?php

$name = 'suricata';
$unit_text = 'drops/sec';
$colours = 'psychedelic';
$dostack = 0;
$printtotal = 1;
$addarea = 0;
$transparency = 15;
$descr_len = 19;

if (isset($vars['sinstance'])) {
    $tcp__segment_memcap_drop_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'instance_' . $vars['sinstance'] . '___tcp__segment_memcap_drop']);
} else {
    $tcp__segment_memcap_drop_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'totals___tcp__segment_memcap_drop']);
}

$rrd_list = [];
if (Rrd::checkRrdExists($tcp__segment_memcap_drop_rrd_filename)) {
    $rrd_list[] = [
        'filename' => $tcp__segment_memcap_drop_rrd_filename,
        'descr' => 'TCP Seg Memcap Drop',
        'ds' => 'data',
    ];
} else {
    d_echo('RRD "' . $tcp__segment_memcap_drop_rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_multi_line.inc.php';

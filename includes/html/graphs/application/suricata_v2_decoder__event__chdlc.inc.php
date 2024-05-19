<?php

$munge = true;
$name = 'suricata';
$unit_text = 'packets/s';
$descr = 'CHDLC Pkg Too Small';
$descr_len = 20;
$ds = 'data';

if (isset($vars['sinstance'])) {
    $decoder__event__chdlc__pkt_too_small_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'instance_' . $vars['sinstance'] . '___decoder__event__chdlc__pkt_too_small']);
} else {
    $decoder__event__chdlc__pkt_too_small_rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, 'totals___decoder__event__chdlc__pkt_too_small']);
}

if (Rrd::checkRrdExists($decoder__event__chdlc__pkt_too_small_rrd_filename)) {
    $filename = $decoder__event__chdlc__pkt_too_small_rrd_filename;
} else {
    d_echo('RRD "' . $decoder__event__chdlc__pkt_too_small_rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_stats.inc.php';

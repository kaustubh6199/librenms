<?php

$unit_text = 'ver_1_0';
$descr = 'ver_1_0';
$ds = 'ver_1_0';

$filename = Rrd::name($device['hostname'], ['app', $app->app_type, $app->app_id]);

if (! Rrd::checkRrdExists($filename)) {
    d_echo('RRD "' . $filename . '" not found');
}

require 'includes/html/graphs/generic_stats.inc.php';

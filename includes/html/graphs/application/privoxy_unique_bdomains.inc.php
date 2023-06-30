<?php

$unit_text = 'unique_bdomains';
$descr = 'unique_bdomains';
$ds = 'unique_bdomains';

$filename = Rrd::name($device['hostname'], ['app', $app->app_type, $app->app_id]);

if (! Rrd::checkRrdExists($filename)) {
    d_echo('RRD "' . $filename . '" not found');
}

require 'includes/html/graphs/generic_stats.inc.php';

<?php

$unit_text = 'unique_domains_np';
$descr = 'unique_domains_np';
$ds = 'unique_domains_np';

$filename = Rrd::name($device['hostname'], ['app', $app->app_type, $app->app_id]);

if (! Rrd::checkRrdExists($filename)) {
    d_echo('RRD "' . $filename . '" not found');
}

require 'includes/html/graphs/generic_stats.inc.php';

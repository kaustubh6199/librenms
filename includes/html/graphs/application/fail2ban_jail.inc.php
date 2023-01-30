<?php

$unit_text = 'Banned IPs';
$colours = 'psychedelic';
$descr = 'Banbed';
$ds = 'banned';

$filename = Rrd::name($device['hostname'], ['app', $app->app_type, $app->app_id, $vars['jail']]);

if (! Rrd::checkRrdExists($filename)) {
    d_echo('RRD "' . $filename . '" not found');
}

require 'includes/html/graphs/generic_stats.inc.php';

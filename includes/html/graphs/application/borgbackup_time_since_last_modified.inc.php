<?php

$name = 'borgbackup';
$unit_text = 'Seconds';
$colours = 'psychedelic';
$descr = 'Since Mtime';
$ds = 'data';

$name_part = 'time_since_last_modified';

if (isset($vars['borgrepo'])) {
    $name_part = 'repos___' . $vars['borgrepo'] . '___' . $name_part;
} else {
    $name_part = 'totals___' . $name_part;
}

$filename = Rrd::name($device['hostname'], ['app', $name, $app->app_id, $name_part]);

if (! Rrd::checkRrdExists($filename)) {
    d_echo('RRD "' . $filename . '" not found');
}

require 'includes/html/graphs/generic_stats.inc.php';

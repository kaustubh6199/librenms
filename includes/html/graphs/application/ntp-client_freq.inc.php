<?php

require 'includes/html/graphs/common.inc.php';

$ds              = 'frequency';
$colour_area = \LibreNMS\Config::get('graph_colours.pinks.0') . '33';
$colour_line = \LibreNMS\Config::get('graph_colours.pinks.0');
$colour_area_max = 'FFEE99';
$graph_max       = 100;
$unit_text       = 'Frequency';
$ntpclient_rrd   = rrd_name($device['hostname'], array('app', 'ntp-client', $app['app_id']));

if (rrdtool_check_rrd_exists($ntpclient_rrd)) {
    $rrd_filename = $ntpclient_rrd;
}

require 'includes/html/graphs/generic_simplex.inc.php';

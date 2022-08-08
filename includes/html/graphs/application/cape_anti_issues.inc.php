<?php

$name = 'cape';
$app_id = $app['app_id'];
$unit_text = 'Anti Issues Per Run';
$colours = 'psychedelic';
$dostack = 0;
$printtotal = 1;
$addarea = 0;
$transparency = 15;

if (isset($vars['stddev'])) {
    if ($vars['stddev'] != 'on' and $vars['stddev'] != 'off') {
        $vars['stddev']='off';
    }
}else{
    $vars['stddev']='off';
}

if (isset($vars['package'])) {
    $rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app['app_id'],'pkg',$vars['package']]);
}else{
    $rrd_filename = Rrd::name($device['hostname'], ['app', $name, $app['app_id']]);
}

$rrd_list = [];
if (Rrd::checkRrdExists($rrd_filename)) {
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Min',
        'ds'       => 's0anti_issues',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Max',
        'ds'       => 's1anti_issues',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Mean',
        'ds'       => 's3anti_issues',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Median',
        'ds'       => 's4anti_issues',
    ];
    $rrd_list[] = [
        'filename' => $rrd_filename,
        'descr'    => 'Mode',
        'ds'       => 's5anti_issues',
    ];
    if ($vars['stddev'] == on) {
        $rrd_list[] = [
            'filename' => $rrd_filename,
            'descr'    => 'StdDev',
            'ds'       => 's7anti_issues',
        ];
        $rrd_list[] = [
            'filename' => $rrd_filename,
            'descr'    => 'StdDevP',
            'ds'       => 's9anti_issues',
    ];
    }
} else {
    d_echo('RRD "' . $rrd_filename . '" not found');
}

require 'includes/html/graphs/generic_multi_line.inc.php';

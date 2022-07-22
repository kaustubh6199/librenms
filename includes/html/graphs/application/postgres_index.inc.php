<?php

$name = 'postgres';
$scale_min = 0;
$colours = 'mixed';
$unit_text = 'Rows/Sec';
$unitlen = 10;
$bigdescrlen = 15;
$smalldescrlen = 15;
$dostack = 0;
$printtotal = 0;
$addarea = 1;
$transparency = 15;

if (isset($vars['database'])) {
    $rrd_name_array = ['app', $name, $app->app_id, $vars['database']];
} else {
    $rrd_name_array = ['app', $name, $app->app_id];
}

$rrd_filename = Rrd::name($device['hostname'], $rrd_name_array);

if (Rrd::checkRrdExists($rrd_filename)) {
    $rrd_list = [
        [
            'filename' => $rrd_filename,
            'descr'    => 'Scans',
            'ds'       => 'idxscan',
            'colour'   => '582A72',
        ],
        [
            'filename' => $rrd_filename,
            'descr'    => 'Tuples Read',
            'ds'       => 'idxtupread',
            'colour'   => 'AA6C39',
        ],
        [
            'filename' => $rrd_filename,
            'descr'    => 'Tuples Fetched',
            'ds'       => 'idxtupfetch',
            'colour'   => 'FFD1AA',
        ],
        [
            'filename' => $rrd_filename,
            'descr'    => 'Blocks Read',
            'ds'       => 'idxblksread',
            'colour'   => '88CC88',
        ],
        [
            'filename' => $rrd_filename,
            'descr'    => 'Buffer Hits',
            'ds'       => 'idxblkshit',
            'colour'   => '28536C',
        ],
    ];
} else {
    echo "file missing: $rrd_filename";
}

require 'includes/html/graphs/generic_v3_multiline.inc.php';

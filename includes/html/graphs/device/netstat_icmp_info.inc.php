<?php

$rrd_filename = rrd_name($device['hostname'], 'netstats-icmp');

$stats = [
    'icmpInSrcQuenchs'    => [],
    'icmpOutSrcQuenchs'   => [],
    'icmpInRedirects'     => [],
    'icmpOutRedirects'    => [],
    'icmpInAddrMasks'     => [],
    'icmpOutAddrMasks'    => [],
    'icmpInAddrMaskReps'  => [],
    'icmpOutAddrMaskReps' => [],
];

$i = 0;

foreach ($stats as $stat => $array) {
    $i++;
    $rrd_list[$i]['filename'] = $rrd_filename;
    $rrd_list[$i]['descr'] = str_replace('icmp', '', $stat);
    $rrd_list[$i]['ds'] = $stat;
    if (strpos($stat, 'Out') !== false) {
        $rrd_list[$i]['invert'] = true;
    }
}

$colours = 'mixed';

$scale_min = '0';
$nototal = 1;
$simple_rrd = true;

require 'includes/html/graphs/generic_multi_line.inc.php';

<?php

$unit_text = 'Percentage';
$descr = 'size diff%, -4d';
$ds = '4d_size_diffp';

require 'logsize-common.inc.php';

if (! Rrd::checkRrdExists($filename)) {
    d_echo('RRD "' . $filename . '" not found');
}

require 'includes/html/graphs/generic_stats.inc.php';

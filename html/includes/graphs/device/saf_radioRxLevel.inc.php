<?php

require 'includes/graphs/common.inc.php';

$rrdfilename = $config['rrd_dir'].'/'.$device['hostname'].'/saf.rrd';

if (file_exists($rrdfilename)) {
    $rrd_options .= " COMMENT:'                                                Now         Min          Max\\n'";
    $rrd_options .= ' DEF:radioRxLevel='.$rrdfilename.':radioRxLevel:AVERAGE ';
    $rrd_options .= " LINE1:radioRxLevel#CC0000:'RX Level                             ' ";
    $rrd_options .= ' GPRINT:radioRxLevel:LAST:"%3.2lf dBm"';
    $rrd_options .= ' GPRINT:radioRxLevel:MIN:"%3.2lf dBm"';
    $rrd_options .= ' GPRINT:radioRxLevel:MAX:"%3.2lf dBm\\\l" ';
}

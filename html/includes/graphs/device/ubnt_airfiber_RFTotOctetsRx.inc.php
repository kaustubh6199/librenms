<?php

require 'includes/graphs/common.inc.php';

// $rrd_options .= " -l 0 -E ";
$rrdfilename = $config['rrd_dir'].'/'.$device['hostname'].'/ubnt-airfiber-mib.rrd';

if (file_exists($rrdfilename)) {
    $rrd_options .= " COMMENT:'Octets                 Now      Min     Max\\n'";
    $rrd_options .= ' DEF:rxoctetsAll='.$rrdfilename.':rxoctetsAll:AVERAGE ';
    $rrd_options .= " LINE1:rxoctetsAll#00CC00:'Rx Octets      ' ";
    $rrd_options .= ' GPRINT:rxoctetsAll:LAST:%0.2lf%s ';
    $rrd_options .= ' GPRINT:rxoctetsAll:MIN:%0.2lf%s ';
    $rrd_options .= ' GPRINT:rxoctetsAll:MAX:%0.2lf%s\\\l ';
}

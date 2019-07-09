<?php
/*
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage nfs-server
 * @link       http://librenms.org
 * @copyright  2017 LibreNMS
 * @author     SvennD <svennd@svennd.be>
*/

require 'includes/html/graphs/common.inc.php';
$scale_min     = 0;
$colours       = 'mixed';
$unit_text     = 'cache depth';
$unitlen       = 15;
$bigdescrlen   = 15;
$smalldescrlen = 15;
$dostack       = 0;
$printtotal    = 0;
$addarea       = 1;
$transparency  = 33;

$rrd_filename  = rrd_name($device['hostname'], array('app', 'nfs-server-default', $app['app_id']));

$array = array(
    'ra_range01' => array('descr' => '0%-10%'),
    'ra_range02' => array('descr' => '10%-20%'),
    'ra_range03' => array('descr' => '20%-30%'),
    'ra_range04' => array('descr' => '30%-40%'),
    'ra_range05' => array('descr' => '40%-50%'),
    'ra_range06' => array('descr' => '50%-60%'),
    'ra_range07' => array('descr' => '60%-70%'),
    'ra_range08' => array('descr' => '70%-80%'),
    'ra_range09' => array('descr' => '80%-90%'),
    'ra_range10' => array('descr' => '90%-100%'),
    'ra_notfound' => array('descr' => 'not found'),
);

$i = 0;

if (rrdtool_check_rrd_exists($rrd_filename)) {
    foreach ($array as $ds => $var) {
        $rrd_list[$i]['filename'] = $rrd_filename;
        $rrd_list[$i]['descr']    = $var['descr'];
        $rrd_list[$i]['ds']       = $ds;
        $rrd_list[$i]['colour'] = \LibreNMS\Config::get("graph_colours.$colours.$i");
        $i++;
    }
} else {
    echo "file missing: $rrd_filename";
}

require 'includes/html/graphs/generic_v3_multiline.inc.php';

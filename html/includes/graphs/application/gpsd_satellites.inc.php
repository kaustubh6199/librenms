<?php
/*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    LibreNMS
* @link       http://librenms.org
* @copyright  2016 Karl Shea, LibreNMS
* @author     Karl Shea <karl@karlshea.com>
*
*/

require 'includes/graphs/common.inc.php';

$scale_min = 0;
$colours      = 'mixed';
$nototal      = (($width < 224) ? 1 : 0);
$unit_text    = 'Satellites';
$rrd_filename = rrd_name($device['hostname'], array('app', 'gpsd', $app['app_id']));
$array        = array(
  'satellites' => array('descr' => 'Total'),
  'satellites_used' => array('descr' => 'Used'),
);

$i = 0;

if (rrdtool_check_rrd_exists($rrd_filename)) {
  foreach ($array as $ds => $vars) {
    $rrd_list[$i]['filename']   = $rrd_filename;
    $rrd_list[$i]['descr']  = $vars['descr'];
    $rrd_list[$i]['ds']     = $ds;
    $rrd_list[$i]['colour'] = $config['graph_colours'][$colours][$i];
    $i++;
  }
} else {
  echo "file missing: $file";
}

require 'includes/graphs/generic_multi_line.inc.php';
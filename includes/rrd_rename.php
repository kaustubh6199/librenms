<?php
/**
 * rrd_rename.php
 *
 * Renames rrd files in a similar way to schema updates
 * -d debug
 * -f force
 *
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
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

include 'includes/defaults.inc.php';
include 'config.php';
include 'includes/definitions.inc.php';
include 'includes/functions.php';

// get current rrd revision
$insert = false;
$rrd_rev = @dbFetchCell("SELECT `version` FROM `versions` WHERE `component`='rrd' ORDER BY `version` DESC LIMIT 1");
$options = getopt('df');
$debug = isset($options['d']);
if (!$rrd_rev || isset($options['f'])) {
    $rrd_rev = 0;
}
$new_rrd_rev = $rrd_rev;

// get list of rrd rename operations
$dir = $config['install_dir'] . '/schema/rrd/';
$files = array_diff(scandir($dir), array('..', '.'));

try {
    foreach ($files as $file) {
        $file_rev = substr($file, 0, strpos($file, '.'));

        if (intval($file_rev) > intval($rrd_rev)) {
            require "$dir/$file";  // include the operation file, should define $renamer
            echo "Rename operation $file_rev: " . $renamer->getDesc() . PHP_EOL;
            $renamer->run();
            $new_rrd_rev = $file_rev;
        }
    }

    if ($new_rrd_rev > $rrd_rev) {  // insert/update the rrd rename version, if needed
        if ($rrd_rev === 0) {
            dbInsert(array('component' => 'rrd', 'version' => $new_rrd_rev), 'versions');
        } else {
            dbUpdate(array('component' => 'rrd', 'version' => $new_rrd_rev), 'versions');
        }
    }
} catch (Exception $e) {
    c_echo('%rRename failed%n: ' . $e->getMessage() . PHP_EOL);
}

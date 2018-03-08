<?php
/* Copyright (C) 2014 Daniel Preussker <f0o@devilcode.org>
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. */


/**
 * Custom Frontpage
 * @author f0o <f0o@devilcode.org>
 * @copyright 2014 f0o, LibreNMS
 * @license GPL
 * @package LibreNMS
 * @subpackage Frontpage
 */

/**
 * Fullscreen variant
 * I have mostly axed a lot of stuff and added a tiny bit of CSS
 * To make use of this, your config.php needs to contain
 * something like this:

$config['front_page'] = "pages/front/fullscreenmap.php";
$config['map']['engine'] = 'leaflet';
$config['leaflet']['default_zoom'] = 5;
$config['leaflet']['default_lat'] = 65.3258792;
$config['leaflet']['default_lng'] = 14.1115485;

  Dag B <dag@bakke.com>

 */

if ($config['map']['engine'] == 'leaflet') {
    require_once 'includes/common/worldmap.inc.php';
    echo implode('', $common_output);
}
/* Yes, this code requires the leaflet map engine  */
?>

<link href="css/fullscreenmap.css" rel="stylesheet" type="text/css" />
<script src='js/jquery.mousewheel.min.js'></script>
<?php
$x=0;
foreach (dbFetchRows("SELECT `hostname`,`devices`.`location`,`status`, COUNT(`status`) AS `total`,`lat`,`lng` FROM `devices` LEFT JOIN `locations` ON `devices`.`location`=`locations`.`location` WHERE `disabled`=0 AND `ignore`=0 AND `lat` != '' AND `lng` != '' GROUP BY `status`,`lat`,`lng` ORDER BY `status` ASC, `hostname`") as $map_devices) {
    $color = "#29FF3B";
    $size = 15;
    $status = 'Up';
    if ($map_devices['status'] == 0) {
        $color = "#FF0000";
        $size = 30;
        $status = 'Down';
    }
    $data .= "\"$x\": {
                        value: \"" . $map_devices['total'] . "\",
                        latitude: ". $map_devices['lat'] . ",
                        longitude: " . $map_devices['lng'] . ",
                        size: " . $size . ",
                        attrs: {
                            fill: \"" . $color . "\",
                            opacity: 0.8
                        },
                        tooltip: {
                            content: \"Devices " . $status . ": " . $map_devices['total']  . "\"
                        }
                    },\n";
    $x++;
}
?>

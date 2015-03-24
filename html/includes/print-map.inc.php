<?php

/*
 * LibreNMS
 *
 * Copyright (c) 2014 Neil Lathwood <https://github.com/laf/ http://www.lathwood.co.uk/fa>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

$tmp_devices = array();
$tmp_id = 0;
if (!empty($device['hostname'])) {
    $sql = ' WHERE `devices`.`hostname`=?';
    $sql_array = array($device['hostname']);
}
foreach (dbFetchRows("SELECT DISTINCT least(`devices`.`hostname`, `remote_hostname`) AS `remote_hostname`, GREATEST(`remote_hostname`,`devices`.`hostname`) AS `hostname` FROM `links` LEFT JOIN `ports` ON `local_port_id`=`ports`.`port_id` LEFT JOIN `devices` ON `ports`.`device_id`=`devices`.`device_id` $sql", $sql_array) as $link_devices) {
    $link_dev = dbFetchRow("SELECT `location` FROM `devices` WHERE `hostname`=?",array($link_devices['hostname']));
    $tmp_devices[] = array('id'=>$link_devices['hostname'],'label'=>$link_devices['hostname'],'title'=>$link_devices['hostname'],'group'=>$link_dev['location']);
    $tmp_id++;
    $link_dev = dbFetchRow("SELECT `location` FROM `devices` WHERE `hostname`=?",array($link_devices['remote_hostname']));
    $tmp_devices[] = array('id'=>$link_devices['remote_hostname'],'label'=>$link_devices['remote_hostname'],'title'=>$link_devices['remote_hostname'],'group'=>$link_dev['location']);
    $tmp_id++;
}
 
$nodes = json_encode($tmp_devices);
 
if (is_array($tmp_devices[0])) {
    $tmp_links = array();
    foreach (dbFetchRows("SELECT `devices`.`hostname` AS `hostname`, `remote_hostname`,`ports`.`ifName` AS `local_port`, `remote_port`,`ports`.`ifSpeed` AS ifSpeed FROM `links` LEFT JOIN `ports` ON `local_port_id`=`ports`.`port_id` LEFT JOIN `devices` ON `ports`.`device_id`=`devices`.`device_id`") as $link_devices) {
        foreach ($tmp_devices as $k=>$v) {
            if ($v['label'] == $link_devices['hostname']) {
                $from = $v['id'];
                $port = $link_devices['local_port'];
            }
            if ($v['label'] == $link_devices['remote_hostname']) {
                $to = $v['id'];
                $port .= ' > ' .$link_devices['remote_port'];
            }
        }
        $speed = $link_devices['ifSpeed']/1000/1000;
        if ($speed == 100) {
            $width = 3;
        } elseif ($speed == 1000) {
            $width = 5;
        } elseif ($speed == 10000) {
            $width = 10;
        } elseif ($speed == 40000) {
            $width = 15;
        } elseif ($speed == 100000) {
            $width = 20;
        } else {
            $width = 1;
        }
        $tmp_links[] = array('from'=>$from,'to'=>$to,'label'=>$port,'title'=>$port,'width'=>$width);
    }
 
    $edges = json_encode($tmp_links);
 
?>
 
<div id="visualization"></div>
<script type="text/javascript">

    // create an array with nodes
    var nodes =
<?php
echo $nodes;
?>
    ;
 
    // create an array with edges
    var edges =
<?php
echo $edges;
?>
    ;
 
    // create a network
    var container = document.getElementById('visualization');
    var data = {
            nodes: nodes,
        edges: edges,
        stabilize: true
    };
    var options = {physics: {barnesHut: {gravitationalConstant: -11900, centralGravity: 1.4, springLength: 203, springConstant: 0.05, damping: 0.3}}, smoothCurves: false};
    var network = new vis.Network(container, data, options);
    //network.on('click', function (properties) {
    //    window.location.href = "/device/device="
    //});
</script>

<?php

}

$pagetitle[] = "Map";
?>

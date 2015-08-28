<?php

/*
 * Copyright (C) 2015 Mark Schouten <mark@tuxis.nl>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; version 2 dated June,
 * 1991.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * See http://www.gnu.org/licenses/gpl.txt for the full license
 */

include('includes/application/proxmox.inc.php');

global $config;

$graphs = array(
    'proxmox_traffic'       => 'Traffic',
);

foreach (proxmox_node_vms(var_get('device')) as $nvm) {
    $vm = proxmox_vm_info($nvm['vmid'], $nvm['cluster']);

    foreach ($vm['ports'] as $port) {
        foreach ($graphs as $key => $text) {
	        $graph_type = 'proxmox_traffic';
	
	        $graph_array['height']    = '100';
	        $graph_array['width']     = '215';
	        $graph_array['to']        = $config['time']['now'];
	        $graph_array['id']        = $vm['app_id'];
	        $graph_array['device_id'] = $vm['device_id'];
	        $graph_array['type']      = 'application_'.$key;
	        $graph_array['port']      = $port['port'];
	        $graph_array['vmid']      = $vm['vmid'];
	        $graph_array['cluster']   = $vm['cluster'];
	        $graph_array['hostname']  = $vm['description'];
	
	        echo '<h3>'.$text.' '.$port['port'].'@'.$vm['description'].'</h3>';
	
	        echo "<tr bgcolor='$row_colour'><td colspan=5>";

            include 'includes/print-graphrow.inc.php';

            echo '</td></tr>';
        }
    }
}

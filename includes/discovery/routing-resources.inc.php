<?php
use LibreNMS\Config;

d_echo("discovering hw-cap\n");

if (true) {
    if ($device['os'] == 'arista_eos') {
        include "includes/discovery/routing-resources/arista_eos.inc.php";
    }
} else {
    d_echo("no hardware-utilization supported");
}

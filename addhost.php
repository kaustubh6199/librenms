#!/usr/bin/env php
<?php

/* Observium Network Management and Monitoring System
 * Copyright (C) 2006-2011, Observium Developers - http://www.observium.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See COPYING for more details.
 */

include("includes/defaults.inc.php");
include("config.php");
include("includes/functions.php");

if (isset($argv[1]) && $argv[1])
{
  $host    = strtolower($argv[1]);
  $community = $argv[2];
  $snmpver   = strtolower($argv[3]);

  if (is_numeric($argv[4]))
  {
    $port = $argv[4];
  }
  else
  {
    $port = 161;
  }

  if (@!$argv[5])
  {
    $transport = 'udp';
  }
  else
  {
    $transport = $argv[5];
  }

  if (!$snmpver) $snmpver = "v2c";

  if ($community)
  {
    unset($config['snmp']['community']);
    $config['snmp']['community'][] = $community;
  }

  addHost($host, $community, $snmpver, $port = '161', $transport = 'udp');

} else { 

print Console_Color::convert("
Observium v".$config['version']." Add Host Tool

Usage: ./addhost.php <%Whostname%n> [community] [v1|v2c] [port] [" . join("|",$config['snmp']['transports']) . "]

%rRemeber to discover the host afterwards.%n

");
}

?>

<?php
$data = snmp_get_multi_oid($device, '.1.3.6.1.2.1.1.5.0 .1.3.6.1.2.1.47.1.1.1.1.10.10 .1.3.6.1.4.1.3715.99.2.1.2.1.7.10');
$hardware = $data['.1.3.6.1.2.1.1.5.0'];
$version = $data['.1.3.6.1.2.1.47.1.1.1.1.10.10'];
$serial = $data['.1.3.6.1.4.1.3715.99.2.1.2.1.7.10'];

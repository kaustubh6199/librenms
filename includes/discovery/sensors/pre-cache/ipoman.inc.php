<?php

$pre_cache['ipoman']['out'] = $pre_cache['ipoman']['out'] ?? [];
$pre_cache['ipoman']['in'] = $pre_cache['ipoman']['in'] ?? [];
echo 'outletConfigDesc ';
$pre_cache['ipoman']['out'] = snmpwalk_cache_multi_oid($device, 'outletConfigDesc', [], 'IPOMANII-MIB');

echo 'outletConfigLocation ';
$pre_cache['ipoman']['out'] = snmpwalk_cache_multi_oid($device, 'outletConfigLocation', $pre_cache['ipoman']['out'], 'IPOMANII-MIB');

echo 'inletConfigDesc ';
$pre_cache['ipoman']['in'] = snmpwalk_cache_multi_oid($device, 'inletConfigDesc', $pre_cache['ipoman']['in'], 'IPOMANII-MIB');

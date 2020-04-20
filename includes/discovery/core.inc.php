<?php

use LibreNMS\Config;
use LibreNMS\OS;

$snmpdata = snmp_get_multi_oid($device, ['sysName.0', 'sysObjectID.0', 'sysDescr.0'], '-OUQn', 'SNMPv2-MIB');

$deviceModel = DeviceCache::getPrimary();
$deviceModel->fill([
    'sysObjectID' => $snmpdata['.1.3.6.1.2.1.1.2.0'],
    'sysName' => strtolower(trim($snmpdata['.1.3.6.1.2.1.1.5.0'])),
    'sysDescr' => $snmpdata['.1.3.6.1.2.1.1.1.0'],
]);

foreach ($deviceModel->getDirty() as $attribute) {
    Log::event($attribute . ' -> ' . $deviceModel->$attribute, $deviceModel, 'system', 3);
    $device[$attribute] = $deviceModel->$attribute; // update device array
}

// detect OS
$deviceModel->os = getHostOS($device, false);

if ($deviceModel->isDirty('os')) {
    Log::event('Device OS changed: ' . $deviceModel->getOriginal('os') . ' -> ' . $deviceModel->os , $deviceModel, 'system', 3);
    $device['os'] = $deviceModel->os;

    echo "Changed ";
}

$deviceModel->save();
load_os($device);
load_discovery($device);
$os = OS::make($device);

echo "OS: " . Config::getOsSetting($device['os'], 'text') . " ({$device['os']})\n\n";

register_mibs($device, Config::getOsSetting($device['os'], 'register_mibs', []), 'includes/discovery/os/' . $device['os'] . '.inc.php');

unset($snmpdata, $attribute, $deviceModel);

<?php

use LibreNMS\RRD\RrdDefinition;

$name = 'fail2ban';
$app_id = $app['app_id'];

echo $name;

try {
    $f2b=json_app_get($device, 'fail2ban', 0);
} catch (JsonAppPollingFailedException $e) {
    echo $e->getMessage();
    return;
}

$metrics = array();
$bannedStuff = explode("\n", $f2b);

$total_banned=$f2b{'total'};

$rrd_name = array('app', $name, $app_id);
$rrd_def = RrdDefinition::make()
    ->addDataset('banned', 'GAUGE', 0)
    ->addDataset('firewalled', 'GAUGE', 0);


$fields = array(
    'banned' =>$total_banned,
    'firewalled'=>'U',
);
$metrics['total'] = $fields;

$tags = array('name' => $name, 'app_id' => $app_id, 'rrd_def' => $rrd_def, 'rrd_name' => $rrd_name);
data_update($device, 'app', $tags, $fields);

$int=0;
$jails=array_keys($f2b{'jails'});

while (isset($jails[$int])) {
    $jail=$jails{$int};
    $banned=$f2b{'jails'}{$jail};

    if (isset($jail) && isset($banned)) {
        $rrd_name = array('app', $name, $app_id, $jail);
        $rrd_def = RrdDefinition::make()->addDataset('banned', 'GAUGE', 0);
        $fields = array('banned' => $banned);

        $metrics["jail_$jail"] = $fields;
        $tags = array('name' => $name, 'app_id' => $app_id, 'rrd_def' => $rrd_def, 'rrd_name' => $rrd_name);
        data_update($device, 'app', $tags, $fields);
    }

    $int++;
}

update_application($app, $f2b, $metrics);

//
// component processing for fail2ban
//
$device_id=$device['device_id'];

$options=array(
    'filter' => array(
        'type' => array('=', 'fail2ban'),
    ),
);

$component = new LibreNMS\Component();
$f2b_components = $component->getComponents($device_id, $options);

// if no jails, delete fail2ban components
if (empty($jails)) {
    if (isset($f2b_components[$device_id])) {
        foreach ($f2b_components[$device_id] as $component_id => $_unused) {
            $component->deleteComponent($component_id);
        }
    }
} else {
    if (isset($f2b_components[$device_id])) {
        $f2bc = $f2b_components[$device_id];
    } else {
        $f2bc = $component->createComponent($device_id, 'fail2ban');
    }

    $id = $component->getFirstComponentID($f2bc);
    $f2bc[$id]['label'] = 'Fail2ban Jails';
    $f2bc[$id]['jails'] = json_encode($jails);

    $component->setComponentPrefs($device_id, $f2bc);
}

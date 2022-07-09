<?php

use App\Models\Application;
use LibreNMS\Exceptions\JsonAppException;
use LibreNMS\Exceptions\JsonAppParsingFailedException;
use LibreNMS\RRD\RrdDefinition;

$name = 'fail2ban';
$app_id = $app['app_id'];

$app = Application::where(['app_id' => $app_id])->first();
$app_data = $app->get_data();

if (! is_array($app_data['jails'])) {
    $app_data['jails'] = [];
}

try {
    $f2b = json_app_get($device, $name);
} catch (JsonAppParsingFailedException $e) {
    // Legacy script, build compatible array
    $legacy = explode("\n", $e->getOutput());
    $f2b = [
        'data' => [
            'total' => array_shift($legacy), // total was first line in legacy app
            'jails' => [],
        ],
    ];

    foreach ($legacy as $jail_data) {
        [$jail, $banned] = explode(' ', $jail_data);
        if (isset($jail) && isset($banned)) {
            $f2b['data']['jails'][$jail] = $banned;
        }
    }
} catch (JsonAppException $e) {
    echo PHP_EOL . $name . ':' . $e->getCode() . ':' . $e->getMessage() . PHP_EOL;
    update_application($app, $e->getCode() . ':' . $e->getMessage(), []); // Set empty metrics and error message

    return;
}

$f2b = $f2b['data'];

$metrics = [];

$rrd_name = ['app', $name, $app_id];
$rrd_def = RrdDefinition::make()
    ->addDataset('banned', 'GAUGE', 0)
    ->addDataset('firewalled', 'GAUGE', 0);

$fields = ['banned' => $f2b['total']];
$metrics['total'] = $fields; // don't include legacy ds in db
$fields['firewalled'] = 'U'; // legacy ds

$tags = ['name' => $name, 'app_id' => $app_id, 'rrd_def' => $rrd_def, 'rrd_name' => $rrd_name];
data_update($device, 'app', $tags, $fields);

$jails = [];
foreach ($f2b['jails'] as $jail => $banned) {
    $rrd_name = ['app', $name, $app_id, $jail];
    $rrd_def = RrdDefinition::make()->addDataset('banned', 'GAUGE', 0);
    $fields = ['banned' => $banned];

    $metrics["jail_$jail"] = $fields;
    $tags = ['name' => $name, 'app_id' => $app_id, 'rrd_def' => $rrd_def, 'rrd_name' => $rrd_name];
    data_update($device, 'app', $tags, $fields);

    $jails[] = $jail;
}
$old_jails = $app_data['jails'];

// save thge found jails
$app_data['jails'] = $jails;
$app->save_data($app_data);

//check for added jails
$added_jails = array_values(array_diff($jails, $old_jails));

//check for removed jails
$removed_jails = array_values(array_diff($old_jails, $jails));

// if we have any jail changes, log it
if (sizeof($added_jails) > 0 or sizeof($removed_jails) > 0) {
    $log_message = 'Fail2ban Jail Change:';
    $log_message .= count($added_jails) > 0 ? ' Added ' . json_encode($added_jails) : '';
    $log_message .= count($removed_jails) > 0 ? ' Removed ' . json_encode($added_jails) : '';
    log_event($log_message, $device, 'application');
}

update_application($app, 'ok', $metrics);

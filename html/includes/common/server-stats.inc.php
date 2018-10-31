<?php

use LibreNMS\Authentication\LegacyAuth;

$device_id = $widget_settings['device'];
$column = $widget_settings['columnsize'];

if (defined('SHOW_SETTINGS') || empty($widget_settings)) {
    $cur_col_size = isset($widget_settings['columnsize']) ? $widget_settings['columnsize'] : '';
    $cur_dev = isset($widget_settings['device']) ? $widget_settings['device'] : '';
    $cur_title = isset($widget_settings['title']) ? $widget_settings['title'] : '';
    $common_output[] = '
    <form class="form" onsubmit="widget_settings(this); return false;">
        <div class="form-group">
            <div class="col-sm-4">
                <label for="title" class="control-label availability-map-widget-header">Widget title</label>
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="title" placeholder="Custom title for widget" value="'.htmlspecialchars($cur_title).'">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <label for="device" class="control-label availability-map-widget-header">Server</label>
            </div>
            <div class="col-sm-6">
                <select id="device" name="device" class="form-control">';
    if (LegacyAuth::user()->hasGlobalRead()) {
        $sql = "SELECT `devices`.`device_id`, `hostname` FROM `devices` WHERE disabled = 0 AND `type` = 'server' ORDER BY `hostname` ASC";
        $param = array();
    } else {
        $sql = "SELECT `devices`.`device_id`, `hostname` FROM `devices` LEFT JOIN `devices_perms` AS `DP` ON `devices`.`device_id` = `DP`.`device_id` WHERE disabled = 0 AND `type` = 'server' AND `DP`.`user_id`=? ORDER BY `hostname` ASC";
        $param = array(LegacyAuth::id());
    }
    foreach (dbFetchRows($sql, $param) as $dev) {
        if ($dev['device_id'] == $cur_dev) {
            $selected = 'selected';
        } else {
            $selected = '';
        }

        $common_output[] = '<option value="'.$dev['device_id'].'" '.$selected.'>'.$dev['hostname'].'</option>';
    }
    $common_output[] ='</select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <label for="columnsize" class="control-label availability-map-widget-header">Column Size</label>
            </div>
            <div class="col-sm-6">
                <select name="columnsize" class="form-control">
                    <option value="2"'.($cur_col_size == 2 ? ' selected' : ' ').'>2</option>
                    <option value="3"'.($cur_col_size == 3 ? ' selected' : ' ').'>3</option>
                    <option value="4"'.($cur_col_size == 4 ? ' selected' : ' ').'>4</option>
                    <option value="6"'.($cur_col_size == 6 ? ' selected' : ' ').'>6</option>
                    <option value="12"'.($cur_col_size == 12 ? ' selected' : ' ').'>12</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-default">Set</button>
            </div>
        </div>
    </form>';
} else {
    if (device_permitted($device_id)) {
        $cpu = dbFetchCell("SELECT AVG(processor_usage) from processors WHERE device_id = ?", array($device_id));
        $mem = dbFetchRows("SELECT mempool_descr,
                                mempool_used as used,
                                mempool_total as total
                                FROM mempools WHERE device_id = ?", array($device_id));
        $disk = dbFetchRows("SELECT storage_descr,
                                storage_used as used,
                                storage_size as total
                                FROM storage WHERE device_id = ?", array($device_id));
        $colno = 12 / $column;
        if (!$cpu) {
            $cpu = 0;
        }

        $common_output[] = '
    <div class="col-sm-' . $colno . '">
            <div id="cpu-' . $unique_id . '" ></div>
    </div>';

        $i = 0;
        foreach ($mem as $m) {
            $mem_used = $m['used'];
            $mem_total = $m['total'];
            $mem_label = "";

            $mc=0;
            while ($mem_total > 1024) {
                $mem_used = round($mem_used / 1024, 2);
                $mem_total = round($mem_total / 1024, 2);

                $mc++;
            }

            switch ($mc) {
                case 0:
                    $mem_label = "B";
                    break;
                case 1:
                    $mem_label = "KB";
                    break;
                case 2:
                    $mem_label = "MB";
                    break;
                case 3:
                    $mem_label = "GB";
                    break;
                case 4:
                    $mem_label = "TB";
                    break;
            }

            $common_output[] = '<div class="col-sm-' . $colno . '">
                <div id="mem-' . $i . '-' . $unique_id . '" ></div>
        </div>';
            $mem_js_output .= "var memgauge" . $i . " = new JustGage({
            id: 'mem-" . $i . "-" . $unique_id . "',
            value: " . $mem_used . ",
            min: 0,
            max: " . $mem_total . ",
            label: '" . $mem_used . "',
            valueFontSize: '2px',
            title: '" . $m['mempool_descr'] . "',
            symbol: '" . $mem_label . "'
        });\n";
            $i++;
        }

        $i = 0;
        foreach ($disk as $d) {
            $disk_used = $d['used'];
            $disk_total = $d['total'];
            $disk_label = "";

            $dc=0;
            while ($disk_total > 1024) {
                $disk_used = round($disk_used / 1024, 2);
                $disk_total = round($disk_total / 1024, 2);

                $dc++;
            }

            switch ($dc) {
                case 0:
                    $disk_label = "B";
                    break;
                case 1:
                    $disk_label = "KB";
                    break;
                case 2:
                    $disk_label = "MB";
                    break;
                case 3:
                    $disk_label = "GB";
                    break;
                case 4:
                    $disk_label = "TB";
                    break;
            }

            $common_output[] = '<div class="col-sm-' . $colno . '">
                <div id="disk-' . $i . '-' . $unique_id . '" ></div>
        </div>';
            $disk_js_output .= "var diskgauge" . $i . " = new JustGage({
            id: 'disk-" . $i . "-" . $unique_id . "',
            value: " . $disk_used . ",
            min: 0,
            max: " . $disk_total . ",
            label: '" . $disk_used . "',
            valueFontSize: '2px',
            title: '" . substr($d['storage_descr'], 0, 20) . "',
            symbol: '" . $disk_label . "'
        });\n";
            $i++;
        }

        $common_output[] = '<script src="js/raphael-min.js"></script>';
        $common_output[] = '<script src="js/justgage.js"></script>';
        $common_output[] = "<script>
    var cpugauge = new JustGage({
        id: 'cpu-" . $unique_id . "',
        value: " . $cpu . ",
        min: 0,
        max: 100,
        title: 'CPU Usage',
        symbol: '%'
    });\n";
        $common_output[] = $mem_js_output;
        $common_output[] = $disk_js_output;
        $common_output[] = '</script>';
    } else {
        $common_output[] = 'You do not have permission to view this device';
    }
}

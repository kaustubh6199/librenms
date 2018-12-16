<?php

$row = 1;

foreach (dbFetchRows('SELECT * FROM `sensors` WHERE `sensor_class` = ? AND `device_id` = ? ORDER BY `sensor_descr`', array($class, $device['device_id'])) as $sensor) {
    $state_translation = array();
    if (($graph_type == 'sensor_state')) {
        $state_translation = dbFetchRows('SELECT * FROM state_translations as ST, sensors_to_state_indexes as SSI WHERE ST.state_index_id=SSI.state_index_id AND SSI.sensor_id = ? AND ST.state_value = ? ', array($sensor['sensor_id'], $sensor['sensor_current']));
    }
    if (!is_integer($row / 2)) {
        $row_colour = $config['list_colour']['even'];
    } else {
        $row_colour = $config['list_colour']['odd'];
    }

    if ($sensor['poller_type'] == "ipmi") {
        $sensor_descr = ipmiSensorName($device['hardware'], $sensor['sensor_descr']);
    } else {
        $sensor_descr = $sensor['sensor_descr'];
    }

    $current_label = "label-success";
    if (!is_null($sensor['sensor_limit_warn']) && $sensor['sensor_current'] > $sensor['sensor_limit_warn']) {
        $current_label = "label-warning";
    }
    if (!is_null($sensor['sensor_limit_low_warn']) && $sensor['sensor_current'] < $sensor['sensor_limit_low_warn']) {
        $current_label = "label-warning";
    }
    if (!is_null($sensor['sensor_limit']) && $sensor['sensor_current'] > $sensor['sensor_limit']) {
        $current_label = "label-danger";
    }
    if (!is_null($sensor['sensor_limit_low']) && $sensor['sensor_current'] < $sensor['sensor_limit_low']) {
        $current_label = "label-danger";
    }

    $sensor_current = "<span class='label $current_label'>".format_si($sensor['sensor_current']).$unit."</span>";

    if (($graph_type == 'sensor_state') && !empty($state_translation['0']['state_descr'])) {
        $sensor_current = get_state_label($sensor['state_generic_value'], $state_translation[0]['state_descr'] . " (".$sensor['sensor_current'].")");
    }

    $sensor_limit = format_si($sensor['sensor_limit']).$unit;
    $sensor_limit_low = format_si($sensor['sensor_limit_low']).$unit;
    $sensor_limit_warn = format_si($sensor['sensor_limit_warn']).$unit;
    $sensor_limit_low_warn = format_si($sensor['sensor_limit_low_warn']).$unit;

    echo "<div class='panel panel-default'>
        <div class='panel-heading'>
        <h3 class='panel-title'>$sensor_descr <div class='pull-right'>$sensor_current";

    //Display low and high limit if they are not null (format_si() is changing null to '0')
    if (!is_null($sensor['sensor_limit_low'])) {
        echo " <span class='label label-default'>low: $sensor_limit_low</span>";
    }
    if (!is_null($sensor['sensor_limit_low_warn'])) {
        echo " <span class='label label-default'>low_warn: $sensor_limit_low_warn</span>";
    }
    if (!is_null($sensor['sensor_limit_warn'])) {
        echo " <span class='label label-default'>high_warn: $sensor_limit_warn</span>";
    }
    if (!is_null($sensor['sensor_limit'])) {
        echo " <span class='label label-default'>high: $sensor_limit</span>";
    }

    echo "</div></h3>
        </div>";
    echo "<div class='panel-body'>";

    $graph_array['id']   = $sensor['sensor_id'];
    $graph_array['type'] = $graph_type;

    include 'includes/print-graphrow.inc.php';

    echo '</div></div>';

    $row++;
}

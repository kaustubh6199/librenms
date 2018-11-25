<?php

// Graphs are printed in the order they exist in $config['graph_types']
$link_array = array(
    'page'   => 'device',
    'device' => $device['device_id'],
    'tab'    => 'graphs',
);

$bg = '#ffffff';

echo '<div style="clear: both;">';

print_optionbar_start();

echo "<span style='font-weight: bold;'>Graphs</span> &#187; ";

$customoid_section = false;
foreach (dbFetchRows('SELECT * FROM device_graphs WHERE device_id = ? ORDER BY graph', array($device['device_id'])) as $graph) {
    $section = $config['graph_types']['device'][$graph['graph']]['section'];
    if ($section != '') {
        if ($section == 'customoid') {
            $customoid_section = true;
        } else {
            $graph_enable[$section][$graph['graph']] = $graph['graph'];
        }
    }
}
if ($customoid_section) {
    $section = $config['graph_types']['device']['customoid']['section'];
    foreach (dbFetchRows('SELECT * FROM `customoids` WHERE `device_id` = ? ORDER BY `customoid_descr`', array($device['device_id'])) as $graph) {
        $graph_enable[$section]['customoid'][$graph['customoid_descr']]['name'] = $graph['customoid_descr'];
        if (!empty($graph['customoid_unit'])) {
            $graph_enable[$section]['customoid'][$graph['customoid_descr']]['unit'] = $graph['customoid_unit'];
        } else {
            $graph_enable[$section]['customoid'][$graph['customoid_descr']]['unit'] = 'value';
        }
    }
}

enable_graphs($device, $graph_enable);

$sep = '';
foreach ($graph_enable as $section => $nothing) {
    if (isset($graph_enable) && is_array($graph_enable[$section])) {
        $type = strtolower($section);
        if (!$vars['group']) {
            $vars['group'] = $type;
        }

        echo $sep;
        if ($vars['group'] == $type) {
            echo '<span class="pagemenu-selected">';
        }
 
        if ($type == 'customoid') {
            echo generate_link(ucwords('Custom OID'), $link_array, array('group' => $type));
        } else {
            echo generate_link(ucwords($type), $link_array, array('group' => $type));
        }
        if ($vars['group'] == $type) {
            echo '</span>';
        }

        $sep = ' | ';
    }
}

unset($sep);

print_optionbar_end();

$graph_enable = $graph_enable[$vars['group']];

foreach ($graph_enable as $graph => $entry) {
    $graph_array = array();

    if ($graph_enable[$graph]) {
        if ($graph == 'customoid') {
            foreach ($graph_enable[$graph] as $subgraph) {
                $graph_title         = $config['graph_types']['device'][$graph]['descr'].": ".$subgraph['name'];
                $graph_array['type'] = $graph.'_'.$subgraph['name'];
                $graph_array['unit'] = $subgraph['unit'];

                include 'includes/print-device-graph.php';
            }
        } else {
            $graph_title         = $config['graph_types']['device'][$graph]['descr'];
            $graph_array['type'] = 'device_'.$graph;
        
            include 'includes/print-device-graph.php';
        }
    }
}

$pagetitle[] = 'Graphs';

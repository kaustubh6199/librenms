<?php

// new ports all start with port-id old were port-9999
$renamer = new \LibreNMS\RrdRenamer(
    'ifIndex labeled ports',
    'port-[0-9]*',
    function ($file, $device) {
        preg_match('/port-(?<index>[0-9]+)(?<suffix>-adsl|-dot3)?/', $file, $matches);
        $index = $matches['index'];
        $suffix = isset($matches['suffix']) ? $matches['suffix'] : '';

        $port = get_port_by_index_cache($device, $index);
        return getPortRrdName($port['port_id'], $suffix);
    }
);

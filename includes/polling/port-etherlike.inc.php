<?php

if ($port_stats[$port_id] &&
    $port['ifType'] == 'ethernetCsmacd' &&
    isset($port_stats[$port_id]['dot3StatsIndex'])) {
    // Check to make sure Port data is cached.
    $this_port = &$port_stats[$port_id];

    // TODO: remove legacy check?
    $old_rrdfile = $config['rrd_dir'].'/'.$device['hostname'].'/'.safename('etherlike-'.$port['ifIndex'].'.rrd');
    $rrd_file    = get_port_rrdfile_path ($device['hostname'], $port_id, 'dot3');

    $rrd_create = $config['rrd_rra'];

    if (!file_exists($rrdfile)) {
        if (file_exists($old_rrdfile)) {
            rename($old_rrdfile, $rrd_file);
        }
        else {
            foreach ($etherlike_oids as $oid) {
                $oid         = truncate(str_replace('dot3Stats', '', $oid), 19, '');
                $rrd_create .= " DS:$oid:COUNTER:600:U:100000000000";
            }

            rrdtool_create($rrdfile, $rrd_create);
        }
    }

    $fields = array();
    foreach ($etherlike_oids as $oid) {
        $data           = ($this_port[$oid] + 0);
        $fields[$oid] = $data;
    }

    rrdtool_update($rrdfile, $fields);

    $tags = array('ifName' => $port['ifName']);
    influx_update($device,'dot3',$tags,$fields);

    echo 'EtherLike ';
}

<?php

$rrd_filename = Rrd::name($device['hostname'], 'panos-panFlowDosRedIcmp6');

$ds = 'panFlowDosRedIcmp6';

$colour_area = '9999cc';
$colour_line = '0000cc';

$colour_area_max = '9999cc';

$graph_max = 1;

$unit_text = 'Packets Dropped';

require 'includes/html/graphs/generic_simplex.inc.php';

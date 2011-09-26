<?php

$scale_min = 0;

include("includes/graphs/common.inc.php");

$rrd_filename = $config['rrd_dir'] . "/" . $device['hostname'] . "/app-powerdns-".$app['app_id'].".rrd";


$array = array('rec_questions' => array('descr' => 'Questions', 'colour' => '6699CCFF'),
               'rec_answers' => array('descr' => 'Answers', 'colour' => '336699FF'),
);


$i = 0;
if (is_file($rrd_filename))
{
  foreach ($array as $ds => $vars)
  {
    $rrd_list[$i]['filename'] = $rrd_filename;
    $rrd_list[$i]['descr'] = $vars['descr'];
    $rrd_list[$i]['ds'] = $ds;
    $rrd_list[$i]['colour'] = $vars['colour'];
    $i++;
  }
} else { echo("file missing: $file");  }

$colours   = "mixed";
$nototal   = 0;
$unit_text = "Packets/sec";

//include("includes/graphs/generic_multi_simplex_seperated.inc.php");
include("includes/graphs/generic_multi_line.inc.php");


?>

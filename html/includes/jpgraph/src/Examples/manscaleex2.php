<?php
include ("../jpgraph.php");
include ("../jpgraph_line.php");

$ydata = array(12,17,22,19,5,15);

$graph = new Graph(220,200);
$graph->SetScale("textlin",3,35);

$graph->title->Set('Manual scale, exact limits');
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$line = new LinePlot($ydata);
$graph->Add($line);

// Output graph
$graph->Stroke();

?>



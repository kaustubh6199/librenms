<?php

use App\Models\BgpPeer;
use App\Models\CefSwitching;
use App\Models\Component;
use App\Models\OspfInstance;
use App\Models\Vrf;

$pagetitle[] = 'Routing';

if ($_GET['optb'] == 'graphs' || $_GET['optc'] == 'graphs') {
    $graphs = 'graphs';
} else {
    $graphs = 'nographs';
}

$user = Auth::user();
$routing_count = [
    'vrf' => Vrf::hasAccess($user)->count(),
    'ospf' => OspfInstance::hasAccess($user)->count(),
    'cisco-otv' => Component::hasAccess($user)->where('type', 'Cisco-OTV')->count(),
    'bgp' => BgpPeer::hasAccess($user)->count(),
    'cef' => CefSwitching::hasAccess($user)->count(),
];
\View::share('routing_count', $routing_count); // share with menubar

// $datas[] = 'overview';
// $routing_count is populated by print-menubar.inc.php
// $type_text['overview'] = "Overview";
$type_text['bgp']  = 'BGP';
$type_text['cef']  = 'CEF';
$type_text['ospf'] = 'OSPF';
$type_text['vrf']  = 'VRFs';
$type_text['cisco-otv']  = 'OTV';

print_optionbar_start();

// if (!$vars['protocol']) { $vars['protocol'] = "overview"; }
echo "<span style='font-weight: bold;'>Routing</span> &#187; ";

$vars['protocol'] = basename($vars['protocol']);
$sep = '';
foreach ($routing_count as $type => $value) {
    if (!$vars['protocol']) {
        $vars['protocol'] = $type;
    }

    echo $sep;
    unset($sep);

    if ($vars['protocol'] == $type) {
        echo '<span class="pagemenu-selected">';
    }

    if ($routing_count[$type]) {
        echo generate_link($type_text[$type].' ('.$routing_count[$type].')', array('page' => 'routing', 'protocol' => $type));
        $sep = ' | ';
    }

    if ($vars['protocol'] == $type) {
        echo '</span>';
    }
}//end foreach

print_optionbar_end();

switch ($vars['protocol']) {
    case 'overview':
    case 'bgp':
    case 'vrf':
    case 'cef':
    case 'ospf':
    case 'cisco-otv':
        include 'includes/html/pages/routing/'.$vars['protocol'].'.inc.php';
        break;

    default:
        echo report_this('Unknown protocol '.$vars['protocol']);
        break;
}

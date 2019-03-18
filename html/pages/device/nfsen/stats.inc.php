<?php

print_optionbar_start();

echo '<form action="'.generate_url( $link_array, array('nfsen' => 'stats')).'" id="FlowStats" method="SUBMIT">';

echo 'Top N:
<select name="topN" id="topN" size=1>
';

$option_default=$config['nfsen_top_default'];
if (isset($vars['topN'])) {
    $option_default=$vars['topN'];
}

$option_int=0;
foreach ($config['nfsen_top_N'] as $option) {
    if (strcmp($option_default, $option) == 0) {
        echo '<OPTION value="'.$option.'" selected>'.$option.'</OPTION>';
    } else {
        echo '<OPTION value="'.$option.'">'.$option.'</OPTION>';
    }
}

echo '
</select>
During the last:
<select name="lastN" id="lastN" size=1>
';

$option_default=$config['nfsen_last_default'];
if (isset($vars['lastN'])) {
    $option_default=$vars['lastN'];
}

$option_keys=array_keys($config['nfsen_lasts']);
foreach ( $option_keys as $option ) {
    if (strcmp($option_default, $option) == 0) {
        echo '<OPTION value="'.$option.'" selected>'.$config['nfsen_lasts'][$option].'</OPTION>';
    } else {
        echo '<OPTION value="'.$option.'">'.$config['nfsen_lasts'][$option].'</OPTION>';
    }
}

echo '
</select>
, Stat Type:
<select name="stattype" id="StatTypeSelector" size=1>
';

$option_default=$config['nfsen_stat_default'];
if (isset($vars['stattype'])) {
    $option_default=$vars['stattype'];
}

$stat_types=array(
    'record'=>'Flow Records',
    'ip'=>'Any IP Address',
    'srcip'=>'SRC IP Address',
    'dstip'=>'DST IP Address',
    'port'=>'Any Port',
    'srcport'=>'SRC Port',
    'dstport'=>'DST Port',
    'srctos'=>'SRC TOS',
    'dsttos'=>'DST TOS',
    'tos'=>'TOS',
    'as'=>'AS',
    'srcas'=>'SRC AS',
    'dstas'=>'DST AS',
);

// puts together the drop down options
foreach ($stat_types as $option => $descr) {
    if (strcmp($option_default, $option) == 0) {
        echo '<OPTION value="'.$option.'" selected>'.$descr."</OPTION>\n";
    } else {
        echo '<OPTION value="'.$option.'">'.$descr."</OPTION>\n";
    }
}

echo '
</select>
, Order By:
<select name="statorder" id="statorder" size=1>
';

$option_default=$config['nfsen_order_default'];
if (isset($vars['statorder'])) {
    $option_default=$vars['statorder'];
}


// WARNING: order is relevant as it has to match the
// check later in the process part of this page.
$order_types=array(
    'flows'=>1,
    'packets'=>1,
    'bytes'=>1,
    'pps'=>1,
    'bps'=>1,
    'bpp'=>1,
);

// puts together the drop down options
foreach ($order_types as $option => $descr) {
    if (strcmp($option_default, $option) == 0) {
        echo '<OPTION value="'.$option.'" selected>'.$option."</OPTION>\n";
    } else {
        echo '<OPTION value="'.$option.'">'.$option."</OPTION>\n";
    }
}

echo '
</select>
<input type="submit" name="process" value="process" size="1">
';
echo '</form>';

print_optionbar_end();

// process stuff now if we the button was clicked on
if (isset($vars['process'])){

    // Make sure we have a sane value for lastN
    $lastN=900;
    if (isset($vars['lastN']) &&
         is_numeric($vars['lastN']) &&
         ($vars['lastN'] <= $config['nfsen_last_max'])
        ){
        $lastN=$vars['lastN'];
    }

    // Make sure we have a sane value for lastN
    $topN=20; // The default if not set or something invalid is set
    if (isset($vars['topN']) &&
         is_numeric($vars['topN']) &&
         ($vars['topN'] <= $config['nfsen_top_max'])
        ){
        $topN=$vars['topN'];
    }

    // Handle the stat order.
    $stat_order='pps'; // The default if not set or something invalid is set
    if (isset($vars['statorder']) && isset($order_types[$vars['statorder']])){
        $stat_order=$vars['statorder'];
    }

    // Handle the stat type.
    $stat_type='srcip'; // The default if not set or something invalid is set
    if (isset($vars['stattype']) && isset($stat_types[$vars['stattype']])){
        $stat_type=$vars['stattype'];
    }

    $current_time=lowest_five_minutes(time() - 300);
    $last_time=lowest_five_minutes($current_time - $lastN - 300);

    $command=$config['nfdump'].' -M '.nfsen_live_dir($device['hostname']).' -T -R '.
             time_to_nfsen_subpath($last_time).':'.time_to_nfsen_subpath($current_time).
             ' -n '.$topN.' -s '.$stat_type.'/'.$stat_order;

    echo '<pre>';
    system($command);
    echo '</pre>';

}

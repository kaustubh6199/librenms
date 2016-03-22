<?php

require_once $config['install_dir'].'/includes/alerts.inc.php';

$pdf->AddPage('L');
$where = '1';

if (is_numeric($_GET['device_id'])) {
    $where  .= ' AND E.device_id = ?';
    $param[] = $_GET['device_id'];
}

if ($_GET['string']) {
    $where  .= ' AND R.rule LIKE ?';
    $param[] = '%'.$_GET['string'].'%';
}

if ($_SESSION['userlevel'] >= '5') {
    $query = " FROM `alert_log` AS E LEFT JOIN devices AS D ON E.device_id=D.device_id RIGHT JOIN alert_rules AS R ON E.rule_id=R.id WHERE $where ORDER BY `humandate` DESC";
}
else {
    $query   = " FROM `alert_log` AS E LEFT JOIN devices AS D ON E.device_id=D.device_id RIGHT JOIN alert_rules AS R ON E.rule_id=R.id RIGHT JOIN devices_perms AS P ON E.device_id = P.device_id WHERE $where AND P.user_id = ? ORDER BY `humandate` DESC";
    $param[] = $_SESSION['user_id'];
}

if (isset($_GET['start']) && is_numeric($_GET['start'])) {
    $start = mres($_GET['start']);
}
else {
    $start = 0;
}

if (isset($_GET['results']) && is_numeric($_GET['results'])) {
    $numresults = mres($_GET['results']);
}
else {
    $numresults = 250;
}

$full_query = "SELECT D.device_id,name,state,time_logged,DATE_FORMAT(time_logged, '".$config['dateformat']['mysql']['compact']."') as humandate $query LIMIT $start,$numresults";

foreach (dbFetchRows($full_query, $param) as $alert_entry) {
    $hostname    = gethostbyid(mres($alert_entry['device_id']));
    $alert_state = $alert_entry['state'];

    if ($alert_state != '') { // FIXME: would is_numeric($alert_state) be more appropriate here?
        if ($alert_state == AlertState::RECOVERED) {
            $glyph_color = 'green';
            $text        = 'Ok';
        }
        else if ($alert_state == AlertState::ALERTED) {
            $glyph_color = 'red';
            $text        = 'Alert';
        }
        else if ($alert_state == AlertState::ACKNOWLEDGED) {
            $glyph_color = 'lightgrey';
            $text        = 'Ack';
        }
        else if ($alert_state == AlertState::WORSE) {
            $glyph_color = 'orange';
            $text        = 'Worse';
        }
        else if ($alert_state == AlertState::BETTER) {
            $glyph_color = 'khaki';
            $text        = 'Better';
        }

        $data[] = array(
            $alert_entry['time_logged'],
            $hostname,
            htmlspecialchars($alert_entry['name']),
            $text,
        );
    }//end if
}//end foreach

$header = array(
    'Datetime',
    'Device',
    'Log',
    'Status',
);

$table = <<<EOD
<table border="1" cellpadding="0" cellspacing="0" align="center">
    <tr nobr="true" bgcolor="#92b7d3">
        <th>Datetime</th>
        <th>Device</th>
        <th>Log</th>
        <th>Status</th>
    </tr>
EOD;

foreach ($data as $log) {
    if ($log[3] == 'Alert') {
        $tr_col = '#d39392';
    }
    else {
        $tr_col = '#bbd392';
    }

    $table .= '
        <tr nobr="true" bgcolor="'.$tr_col.'">
        <td>'.$log[0].'</td>
        <td>'.$log[1].'</td>
        <td>'.$log[2].'</td>
        <td>'.$log[3].'</td>
        </tr>
        ';
}

$table .= <<<EOD
</table>
EOD;

$pdf->writeHTML($table, true, false, false, false, '');

<?php

$where = 1;
$param = array();

list($address,$prefix) = explode("/", $_POST['address']);
if ($_POST['search_type'] == 'ipv4') {
    $sql = " FROM `ipv4_addresses` AS A, `ports` AS I, `devices` AS D, `ipv4_networks` AS N WHERE I.port_id = A.port_id AND I.device_id = D.device_id AND N.ipv4_network_id = A.ipv4_network_id ";
    if (!empty($address)) {
        $sql .= " AND ipv4_address LIKE '%".$address."%'";
    }
    if (!empty($prefix)) {
        $sql .= " AND ipv4_prefixlen='?'";
        $param[] = array($prefix);
    }
} elseif ($_POST['search_type'] == 'ipv6') {
    $sql = " FROM `ipv6_addresses` AS A, `ports` AS I, `devices` AS D, `ipv6_networks` AS N WHERE I.port_id = A.port_id AND I.device_id = D.device_id AND N.ipv6_network_id = A.ipv6_network_id ";
    if (!empty($address)) {
        $sql .= " AND (ipv6_address LIKE '%".$address."%' OR ipv6_compressed LIKE '%".$address."%')";
    }
    if (!empty($prefix)) {
        $sql .= " AND ipv6_prefixlen = '$prefix'";
    }
} elseif ($_POST['search_type'] == 'mac') {
    $sql = " FROM `ports` AS I, `devices` AS D WHERE I.device_id = D.device_id AND `ifPhysAddress` LIKE '%?%' ";
    $param[] = array("%".str_replace(array(':', ' ', '-', '.', '0x'),'',mres($_POST['address']))."%");
}
if (is_numeric($_POST['device_id'])) {
    $sql  .= " AND I.device_id = ?";
    $param[] = array($_POST['device_id']);
}
if ($_POST['interface']) {
    $sql .= " AND I.ifDescr LIKE '?'";
    $param[] = array($_POST['interface']);
}

if ($_POST['search_type'] == 'ipv4') {
    $count_sql = "SELECT COUNT(`ipv4_address_id`) $sql";
} elseif ($_POST['search_type'] == 'ipv6') {
    $count_sql = "SELECT COUNT(`ipv6_address_id`) $sql";
} elseif ($_POST['search_type'] == 'mac') {
     $count_sql = "SELECT COUNT(`port_id`) $sql";
}
$total = dbFetchCell($count_sql,$param);
if (empty($total)) {
    $total = 0;
}

if (!isset($sort) || empty($sort)) {
    $sort = '`hostname` ASC';
}

$sql .= " ORDER BY $sort";

if (isset($current)) {
    $limit_low = ($current * $rowCount) - ($rowCount);
    $limit_high = $rowCount;
}

if ($rowCount != -1) {
    $sql .= " LIMIT $limit_low,$limit_high";
}

$sql = "SELECT *,`I`.`ifDescr` AS `interface` $sql";

foreach (dbFetchRows($sql, $param) as $interface) {
    $speed = humanspeed($interface['ifSpeed']);
    $type = humanmedia($interface['ifType']);

    if ($_POST['search_type'] == 'ipv6') {
        list($prefix, $length) = explode("/", $interface['ipv6_network']);
        $address = Net_IPv6::compress($interface['ipv6_address']) . '/'.$length;
    } elseif ($_POST['search_type'] == 'mac') {
        $address = formatMac($interface['ifPhysAddress']);
    } else {
        list($prefix, $length) = explode("/", $interface['ipv4_network']);
        $address = $interface['ipv4_address'] . '/' .$length;
    }

    if ($interface['in_errors'] > 0 || $interface['out_errors'] > 0) {
        $error_img = generate_port_link($interface,"<img src='images/16/chart_curve_error.png' alt='Interface Errors' border=0>",errors);
    } else {
        $error_img = "";
    }
    if (port_permitted($interface['port_id'])) {
        $interface = ifLabel ($interface, $interface);
        $response[] = array('hostname'=>generate_device_link($interface),
                            'interface'=>generate_port_link($interface) . ' ' . $error_img,
                            'address'=>$address,
                            'description'=>$interface['ifAlias']);
    }
}

$output = array('current'=>$current,'rowCount'=>$rowCount,'rows'=>$response,'total'=>$total);
echo _json_encode($output);

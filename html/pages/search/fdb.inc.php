<div class="panel panel-default panel-condensed">
    <div class="panel-heading">
        <strong>FDB Entries</strong>
    </div>
    <div id="fdb-search-header" class="bootgrid-header container-fluid"><div class="row">
        <div class="col-sm-9 actionBar"><span class="pull-left">
            <form method="post" action="" class="form-inline" role="form">
                <div class="form-group">
                    <select name="device_id" id="device_id" class="form-control input-sm">
                        <option value="">All Devices</option>
<?php

// Select the devices only with FDB tables
$sql = 'SELECT D.device_id AS device_id, `hostname` FROM `ports_fdb` AS F, `ports` AS P, `devices` AS D';

$param = array();
if (is_admin() === false && is_read() === false) {
    $sql    .= ' LEFT JOIN `devices_perms` AS `DP` ON `D`.`device_id` = `DP`.`device_id`';
    $where  .= ' AND `DP`.`user_id`=?';
    $param[] = $_SESSION['user_id'];
}

$sql .= " WHERE F.port_id = P.port_id AND P.device_id = D.device_id $where GROUP BY `D`.`device_id`, `D`.`hostname` ORDER BY `hostname`";
foreach (dbFetchRows($sql, $param) as $data) {
    echo '<option value="'.$data['device_id'].'"';
    if ($data['device_id'] == $_POST['device_id']) {
        echo ' selected ';
    }

    echo '>'.format_hostname($data, $data['hostname']).'</option>';
}
?>
                   </select>
                </div>
                <div class="form-group">
                    <select name="searchby" id="searchby" class="form-control input-sm">
                        <option value="mac" <?php if ($_POST['searchby'] == 'mac') { echo ' selected '; } ?>>MAC Address</option>
                        <option value="vlan" <?php if ($_POST['searchby'] == 'vlan') { echo ' selected '; } ?>>Vlan</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="searchPhrase" id="address" value="<?php echo $_POST['searchPhrase'];?>" class="form-control input-sm" placeholder="Value" />
                </div>
                <button type="submit" class="btn btn-default input-sm">Search</button>
            </form></span>
        </div>
        <div class="col-sm-3 actionBar"><p class="{{css.actions}}"></p></div>
    </div></div>
    <table id="fdb-search" class="table table-hover table-condensed table-striped">
        <thead>
            <tr>
                <th data-column-id="device" data-order="asc">Device</th>
                <th data-column-id="mac_address">MAC Address</th>
                <th data-column-id="ipv4_address">IPv4 Address</th>
                <th data-column-id="interface">Port</th>
                <th data-column-id="vlan">Vlan</th>
            </tr>
        </thead>
    </table>
</div>

<script>
$('#fdb-search').DataTable( {
    "lengthMenu": [[50, 100, 250, -1], [50, 100, 250, "All"]],
    "serverSide": true,
    "processing": true,
    "scrollX": false,
    "sScrollX": "100%",
    "sScrollXInner": "100%",
    "dom":  "ltip",
    "ajax": {
        "url": "ajax_table.php",
        "type": "POST",
        "data": {
            "id": "fdb-search",
            "device_id": '<?php echo htmlspecialchars($_POST['device_id']); ?>',
            "searchby": '<?php echo mres($_POST['searchby']); ?>',
            "searchPhrase": '<?php echo mres($_POST['searchPhrase']); ?>'
        },
    },
    "columns": [
        { "data": "device" },
        { "data": "mac_address" },
        { "data": "ipv4_address" },
        { "data": "interface" },
        { "data": "vlan" },
    ],
    "order": [[0, "asc"]],
} );

</script>

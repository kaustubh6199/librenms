<div class="panel panel-default panel-condensed">
    <div class="panel-heading">
        <strong>IPv4 Addresses</strong>
    </div>
    <div id="ipv4-search-header" class="bootgrid-header container-fluid"><div class="row">
        <div class="col-sm-9 actionBar"><span class="pull-left">
            <form method="post" action="" class="form-inline" role="form">
                <div class="form-group">
                    <select name="device_id" id="device_id" class="form-control input-sm">
                        <option value="">All Devices</option>
<?php

$sql = 'SELECT `devices`.`device_id`,`hostname`,`sysName` FROM `devices`';

if (is_admin() === false && is_read() === false) {
    $sql    .= ' LEFT JOIN `devices_perms` AS `DP` ON `devices`.`device_id` = `DP`.`device_id`';
    $where  .= ' WHERE `DP`.`user_id`=?';
    $param[] = $_SESSION['user_id'];
}

$sql .= " $where ORDER BY `hostname`";

foreach (dbFetchRows($sql, $param) as $data) {
    echo '<option value="'.$data['device_id'].'"';
    if ($data['device_id'] == $_POST['device_id']) {
        echo ' selected ';
    }

    echo '>'.format_hostname($data, $data['hostname']).'</option>';
}
?>
                        </select>
                    </div>&nbsp;
                    <div class="form-group">
                        <select name="interface" id="interface" class="form-control input-sm">
                            <option value="">All Interfaces</option>
                             <option value="Loopback%"
<?php
if ($_POST['interface'] == 'Loopback%') {
    echo ' selected ';
}

?>
>Loopbacks</option>
                             <option value="Vlan%"
<?php
if ($_POST['interface'] == 'Vlan%') {
    echo ' selected ';
}

?>
>VLANs</option>
                        </select>
                    </div>&nbsp;
                    <div class="form-group">
                        <input type="text" name="address" id="address" size=40 value="<?php echo $_POST['address']; ?>" class="form-control input-sm" placeholder="IPv4 Address"/>
                    </div>&nbsp;
                    <button type="submit" class="btn btn-default input-sm">Search</button>
                </form>
            </span></div>
        </div>
    </div>
    <table id="ipv4-search" class="table table-hover table-condensed table-striped">
        <thead>
            <tr>
                <th data-column-id="hostname" data-order="asc">Device</th>
                <th data-column-id="interface">Interface</th>
                <th data-column-id="address" data-sortable="false">Address</th>
                <th data-column-id="description" data-sortable="false">Description</th>
            </tr>
        </thead>
    </table>
</div>

<script>
$('#ipv4-search').DataTable( {
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
            "id": "address-search",
            "search_type": "ipv4",
            "device_id": '<?php echo htmlspecialchars($_POST['device_id']); ?>',
            "interface": '<?php echo mres($_POST['interface']); ?>',
            "address": '<?php echo mres($_POST['address']); ?>',
        },
    },
    "columns": [
        { "data": "hostname" },
        { "data": "interface" },
        { "data": "address" },
        { "data": "description" },
    ],
    "order": [[0, "asc"]],
} );

</script>

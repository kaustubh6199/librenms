<?php
$pagetitle[] = "Health :: Storage";
?>

<div class="panel panel-default panel-condensed">
    <div class="panel-heading">
        <strong>Health :: Storage</strong>
        <div class="pull-right">
            <?php echo $displayoptions; ?>
        </div>
    </div>
    <div class="table-responsive">
        <table id="storage" class="table table-hover table-condensed storage">
            <thead>
                <tr>
                    <th data-column-id="hostname">Device</th>
                    <th data-column-id="storage_descr">Storage</th>
                    <th data-column-id="graph" data-sortable="false" data-searchable="false"></th>
                    <th data-column-id="storage_used" data-searchable="false">Used</th>
                    <th data-column-id="storage_perc" data-searchable="false">Usage</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    var grid = $("#storage").bootgrid({
        ajax: true,
        rowCount: [50, 100, 250, -1],
        post: function ()
        {
            return {
                id: "storage",
                view: '<?php echo $vars['view']; ?>'
            };
        },
        url: "ajax_table.php"
    });
</script>

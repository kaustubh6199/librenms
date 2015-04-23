<div class="row">
    <div class="col-sm-12">
        <span id="message"></span>
    </div>
</div>
<div class="table-responsive">
    <table id="alerts" class="table table-hover table-condensed alerts">
        <thead>
            <tr>
                <th data-column-id="status" data-formatter="status" data-sortable="false">Status</th>
                <th data-column-id="rule">Rule</th>
                <th data-column-id="details" data-sortable="false">&nbsp;</th>
                <th data-column-id="hostname">Hostname</th>
                <th data-column-id="timestamp">Timestamp</th>
                <th data-column-id="severity">Severity</th>
                <th data-column-id="ack" data-formatter="ack" data-sortable="false">Acknowledge</th>
            </tr>
        </thead>
    </table>
</div>
<script>
var grid = $("#alerts").bootgrid({
    ajax: true,
    post: function ()
    {
        return {
            id: "alerts",
            device_id: '<?php echo $device['device_id']; ?>'
        };
    },
    url: "/ajax_table.php",
    formatters: {
        "status": function(column,row) {
            return "<span class='label label-"+row.extra+"'>" + row.msg + "</span>";
        },
        "ack": function(column,row) {
            return "<button type='button' class='btn btn-"+row.ack_col+" btn-sm command-ack-alert' data-target='#ack-alert' data-state='"+row.state+"' data-alert_id='"+row.alert_id+"' name='ack-alert' id='ack-alert' data-extra='"+row.extra+"'><span class='glyphicon glyphicon-"+row.ack_ico+"'aria-hidden='true'></span></button>";
        }
    },
    templates: {
    }
}).on("loaded.rs.jquery.bootgrid", function() {
    grid.find(".incident").each( function() {
      $(this).parent().addClass('col-md-12 col-sm-12 col-xs-12');
      $(this).parent().parent().on("mouseenter", function() {
        $(this).find(".incident-toggle").fadeIn(200);
      }).on("mouseleave", function() {
        $(this).find(".incident-toggle").fadeOut(200);
      }).on("click", function() {
        var target = $(this).find(".incident-toggle").data("target");
        $(this).find(".incident-toggle").toggleClass('glyphicon-plus glyphicon-minus');
        $(target).collapse('toggle');
      });
    });
    grid.find(".incident-toggle").on("click", function(e) {
      var target = $(this).data("target");
      $(this).toggleClass('glyphicon-plus glyphicon-minus');
      $(target).collapse('toggle');
    });
    grid.find(".command-ack-alert").on("click", function(e) {
        e.preventDefault();
        var alert_id = $(this).data("alert_id");
        var state = $(this).data("state");
        $.ajax({
            type: "POST",
            url: "/ajax_form.php",
            data: { type: "ack-alert", alert_id: alert_id, state: state },
            success: function(msg){
                $("#message").html('<div class="alert alert-info">'+msg+'</div>');
                if(msg.indexOf("ERROR:") <= -1) {
                    location.reload();
                }
            },
            error: function(){
                 $("#message").html('<div class="alert alert-info">An error occurred acking this alert.</div>');
            }
        });
    });
});
</script>

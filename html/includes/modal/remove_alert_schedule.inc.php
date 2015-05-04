<?php

/*
 * LibreNMS
 *
 * Copyright (c) 2014 Neil Lathwood <https://github.com/laf/ http://www.lathwood.co.uk/fa>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if(is_admin() !== false) {

?>

<div class="modal fade bs-example-modal-sm" id="delete-maintenance" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="Create">Delete maintenance</h5>
            </div>
            <div class="modal-body">
                <p>If you would like to remove this maintenance then please click Delete.</p>
            </div>
            <div class="modal-footer">
                <form method="post" role="form" id="sched-del" class="form-horizontal schedule-maintenance-del">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger danger" id="sched-maintenance-removal" data-target="sched-maintenance-removal">Delete</button>
                    <input type="hidden" name="del_schedule_id" id="del_schedule_id">
                    <input type="hidden" name="type" id="type" value="schedule-maintenance">
                    <input type="hidden" name="sub_type" id="sub_type" value="del-maintenance">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$('#schedule-maintenance').on('hide.bs.modal', function (event) {
    $('#map-tags').data('tagmanager').empty();
    $('#schedule_id').val('');
    $('#title').val('');
    $('#notes').val('');
    $('#start').val('');
    $('#end').val('');
});

$('#sched-maintenance-removal').click('', function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax_form.php",
        data: $('form.schedule-maintenance-del').serialize(),
        dataType: "json",
        success: function(data){
            if(data.status == 'ok') {
                $("#message").html('<div class="alert alert-info">'+data.message+'</div>');
                $("#delete-maintenance").modal('hide');
                $("#alert-schedule").bootgrid('reload');
            } else {
                $("#response").html('<div class="alert alert-info">'+data.message+'</div>');
            }
        },
        error: function(){
            $("#response").html('<div class="alert alert-info">An error occurred.</div>');
        }
    });
});

</script>
<?php

}

?>

<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">{{ __('map.custom.edit.map.settings_title') }}</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="well well-lg">
                            <input type="hidden" id="mapid" name="mapid" />
                            <div class="form-group row">
                                <label for="mapname" class="col-sm-3 control-label">{{ __('map.custom.edit.map.name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" id="mapname" name="mapname" class="form-control input-sm" value="{{ $name ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mapwidth" class="col-sm-3 control-label">{{ __('map.custom.edit.map.width') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" id="mapwidth" name="mapwidth" class="form-control input-sm" value="{{ $map_conf['width'] ?? '1800px' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mapheight" class="col-sm-3 control-label">{{ __('map.custom.edit.map.height') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" id="mapheight" name="mapheight" class="form-control input-sm" value="{{ $map_conf['height'] ?? '800px' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mapnodealign" class="col-sm-3 control-label">{{ __('map.custom.edit.map.alignment') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" id="mapnodealign" name="mapnodealign" class="form-control input-sm" value="{{ $node_align ?? 10 }}">
                                </div>
                            </div>
                            <div class="form-group row" id="mapBackgroundRow">
                                <label for="selectbackground" class="col-sm-3 control-label">{{ __('map.custom.edit.map.background') }}</label>
                                <div class="col-sm-9">
                                    <input id="mapBackgroundSelect" type="file" name="selectbackground" accept="image/png,image/jpeg,image/svg+xml" class="form-control" onchange="mapChangeBackground();">
                                    <button id="mapBackgroundCancel" type="button" name="cancelbackground" class="btn btn-primary" onclick="mapChangeBackgroundCancel();" style="display:none">{{ __('Cancel') }}</button>
                                </div>
                            </div>
                            <div class="form-group row" id="mapBackgroundClearRow">
                                <label for="clearbackground" class="col-sm-3 control-label">{{ __('map.custom.edit.map.clear_bg') }}</label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="mapBackgroundClearVal">
                                    <button id="mapBackgroundClear" type="button" name="clearbackground" class="btn btn-primary" onclick="mapClearBackground();">{{ __('map.custom.edit.map.clear_background') }}</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12" id="savemap-alert">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type=button value="save" id="map-saveButton" class="btn btn-primary" onclick="saveMapSettings()">{{ __('Save') }}</button>
                    <button type=button value="cancel" id="map-cancelButton" class="btn btn-primary" onclick="editMapCancel()">{{ __('Cancel') }}</button>
                </center>
            </div>
        </div>
    </div>
</div>

<script>
    function mapChangeBackground() {
        $("#mapBackgroundCancel").show();
    }

    function mapChangeBackgroundCancel() {
        $("#mapBackgroundCancel").hide();
        $("#mapBackgroundSelect").val(null);
    }

    function mapClearBackground() {
        if($('#mapBackgroundClearVal').val()) {
            $('#mapBackgroundClear').text('{{ __('map.custom.edit.map.clear_background') }}');
            $('#mapBackgroundClearVal').val('');
        } else {
            $('#mapBackgroundClear').text('{{ __('map.custom.edit.map.keep_background') }}');
            $('#mapBackgroundClearVal').val('clear');
        }
    }

    function saveMapSettings() {
        $("#map-saveButton").attr('disabled','disabled');
        $("#savemap-alert").text('{{ __('map.custom.edit.map.saving') }}');
        $("#savemap-alert").attr("class", "col-sm-12 alert alert-info");

        var name = $("#mapname").val();
        var width = $("#mapwidth").val();
        var height = $("#mapheight").val();
        var node_align = $("#mapnodealign").val();
        var clearbackground = $('#mapBackgroundClearVal').val() ? 1 : 0;
        var newbackground = $('#mapBackgroundSelect').prop('files').length ? $('#mapBackgroundSelect').prop('files')[0] : '';

        if(!isNaN(width)) {
            width = width + "px";
        }
        if(!isNaN(height)) {
            height = height + "px";
        }

        var fd = new FormData();
        fd.append('name', name);
        fd.append('width', width);
        fd.append('height', height);
        fd.append('node_align', node_align);
        fd.append('bgclear', clearbackground);
        fd.append('bgimage', newbackground);

        @if(isset($map_id))
            var url = '{{ route('maps.custom.savesettings', ['map' => $map_id ?? null]) }}';
        @else
            var url = '{{ route('maps.custom.create') }}';
        @endif

        $.ajax({
            url: url,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST'
        }).done(function (data, status, resp) {
            editMapSuccess(data);
        }).fail(function (resp, status, error) {
            var data = resp.responseJSON;
            if (data['message']) {
                let alert_content = $("#savemap-alert");
                alert_content.text(data['message']);
                alert_content.attr("class", "col-sm-12 alert alert-danger");
            } else {
                let alert_content = $("#savemap-alert");
                alert_content.text('{{ __('map.custom.edit.map.save_error', ['code' => '?']) }}'.replace('?', resp.status));
                alert_content.attr("class", "col-sm-12 alert alert-danger");
            }
        }).always(function (resp, status, error) {
            $("#map-saveButton").removeAttr('disabled');
        });
    }
</script>

<?php
/*
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage webui
 * @link       http://librenms.org
 * @copyright  2018 LibreNMS
 * @author     Neil Lathwood <gh+n@laf.io>
*/

$page_title = 'New Alert';
$no_refresh = true;

if (!device_permitted($vars['device'])) {
    include 'includes/error-no-perm.inc.php';
} else {
    $device['device_id'] = $vars['device'] ?: '-1';
    $rule_id = $vars['rule_id'] ?: '';
    $db_schema = Symfony\Component\Yaml\Yaml::parse(file_get_contents($config['install_dir'] . '/misc/db_schema.yaml'));

    foreach ($db_schema as $table => $data) {
        foreach ($data['Columns'] as $index => $columns) {
            $tmp_filters[] = [
                'id' => "$table.{$columns['Field']}",
                'type' => mysql_type_to_php_type($columns['Type']),
            ];
        }
    }

    krsort($config['alert']['macros']['rule']);
    foreach ($config['alert']['macros']['rule'] as $macro => $value) {
        $tmp_filters[] = [
            'id' => 'macros.' . $macro,
        ];
    }

    $filters = json_encode($tmp_filters);

    if (is_numeric($rule_id)) {
        $rule = dbFetchRow('SELECT * FROM `alert_rules` WHERE `id` = ? LIMIT 1', [$rule_id]);
        $sql_query = unserialize($rule['query_builder']);
?>
<script>
    $.ajax({
        type: "POST",
        url: "ajax_form.php",
        data: { type: "parse-alert-rule", alert_id: <?php echo $rule_id; ?> },
        dataType: "json",
        success: function(output) {
            $('#severity').val(output['severity']).change;
            var extra = $.parseJSON(output['extra']);
            $('#count').val(extra['count']);
            if((extra['delay'] / 86400) >= 1) {
                var delay = extra['delay'] / 86400 + ' d';
            } else if((extra['delay'] / 3600) >= 1) {
                var delay = extra['delay'] / 3600 + ' h';
            } else if((extra['delay'] / 60) >= 1) {
                var delay = extra['delay'] / 60 + ' m';
            } else {
                var delay = extra['delay'];
            }
            $('#delay').val(delay);
            if((extra['interval'] / 86400) >= 1) {
                var interval = extra['interval'] / 86400 + ' d';
            } else if((extra['interval'] / 3600) >= 1) {
                var interval = extra['interval'] / 3600 + ' h';
            } else if((extra['interval'] / 60) >= 1) {
                var interval = extra['interval'] / 60 + ' m';
            } else {
                var interval = extra['interval'];
            }
            $('#interval').val(interval);
            $("[name='mute']").bootstrapSwitch('state',extra['mute']);
            $("[name='invert']").bootstrapSwitch('state',extra['invert']);
            $('#name').val(output['name']);
            $('#proc').val(output['proc']);
        }
    });
</script>
<?php
    } else {
        $sql_query = '[]';
    }

    ?>

    <script src="js/sql-parser.min.js"></script>
    <script src="js/query-builder.standalone.min.js"></script>

    <form method="post" role="form" id="rules" class="form-horizontal alerts-form">
        <input type="hidden" name="device_id" id="device_id" value="<?php echo $device['device_id']; ?>">
        <input type="hidden" name="rule_id" id="rule_id" value="<?php echo $rule_id; ?>">
        <input type="hidden" name="type" id="type" value="alert-rules">
        <input type="hidden" name="template_id" id="template_id" value="">
        <input type="hidden" name="query" id="query" value="">
        <input type="hidden" name="json" id="json" value="">
        <div class="form-group">
            <div class="col-sm-5 col-sm-offset-3">
                <div id="builder"></div>
            </div>
        </div>
        <div class="form-group">
            <label for='severity' class='col-sm-3 control-label'>Severity: </label>
            <div class="col-sm-5">
                <select name='severity' id='severity' placeholder='Severity' class='form-control'>
                    <option value='ok'>OK</option>
                    <option value='warning'>Warning</option>
                    <option value='critical' selected>Critical</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for='count' class='col-sm-3 control-label'>Max alerts: </label>
            <div class='col-sm-1'>
                <input type='text' id='count' name='count' class='form-control'>
            </div>
            <label for='delay' class='col-sm-1 control-label'>Delay: </label>
            <div class='col-sm-1'>
                <input type='text' id='delay' name='delay' class='form-control'>
            </div>
            <label for='interval' class='col-sm-1 control-label'>Interval: </label>
            <div class='col-sm-1'>
                <input type='text' id='interval' name='interval' class='form-control'>
            </div>
        </div>
        <div class='form-group'>
            <label for='mute' class='col-sm-3 control-label'>Mute alerts: </label>
            <div class='col-sm-1'>
                <input type="checkbox" name="mute" id="mute">
            </div>
            <label for='invert' class='col-sm-1 control-label'>Invert match: </label>
            <div class='col-sm-1'>
                <input type='checkbox' name='invert' id='invert'>
            </div>
        </div>
        <div class='form-group'>
            <label for='name' class='col-sm-3 control-label'>Rule name: </label>
            <div class='col-sm-5'>
                <input type='text' id='name' name='name' class='form-control' maxlength='200'>
            </div>
        </div>
        <div id="preseed-maps">
            <div class="form-group">
                <label for='map-stub' class='col-sm-3 control-label'>Map To: </label>
                <div class="col-sm-4">
                    <input type='text' id='map-stub' name='map-stub' class='form-control'/>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-primary btn-sm" type="button" name="add-map" id="add-map" value="Add">Add
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <span id="map-tags"></span>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <label for='proc' class='col-sm-3 control-label'>Procedure URL: </label>
            <div class='col-sm-5'>
                <input type='text' id='proc' name='proc' class='form-control' maxlength='80'>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button class="btn btn-success parse-sql" id="btn-save" name="save-alert" data-target="import_export"
                        data-stmt="false">Process Rule
                </button>
            </div>
        </div>
    </form>

    <script>
        var sql_import_export = <?php echo $sql_query; ?>;

        $('#builder').on('afterApplyRuleFlags.queryBuilder afterCreateRuleFilters.queryBuilder', function () {
            $("[name$='_filter']").each(function () {
                $(this).select2();
            });
        }).on('ruleToSQL.queryBuilder.filter', function (e, rule) {
            if (rule.operator === 'regexp') {
                e.value+= ' \'' + rule.value + '\'';
            }
            e.value = "%"+e.value;
        }).queryBuilder({
            plugins: [
                'bt-tooltip-errors',
                'not-group'
            ],

            filters: <?php echo $filters; ?>,
            operators: $.fn.queryBuilder.constructor.DEFAULTS.operators.concat([
                { type: 'regexp',    nb_inputs: 1, multiple: false, apply_to: ['string'] }
            ]),
            lang: {
                operators: {
                    regexp: 'regex'
                }
            },
            sqlOperators: {
                regexp: { op: 'REGEXP' }
            }
        });


        <?php
        if (is_numeric($rule_id)) {
            echo '$("#builder").queryBuilder("setRules", sql_import_export);';
        }
        ?>

        $('#btn-save').on('click', function (e) {
            e.preventDefault();
            var result_sql = $('#builder').queryBuilder('getSQL', $(this).data('stmt'));
            var result_json = $('#builder').queryBuilder('getRules');
            if (result_sql) {
                if (result_sql.sql.length) {
                    $('#query').val(result_sql.sql);
                    $('#json').val(JSON.stringify(result_json, null, 2));
                    $.ajax({
                        type: "POST",
                        url: "ajax_form.php",
                        data: $('form.alerts-form').serialize(),
                        dataType: "json",
                        success: function (data) {
                            if (data.status == 'ok') {
                                toastr.success(data.message);
                            } else {
                                toastr.error(data.message);
                            }
                        },
                        error: function () {
                            toastr.error('Failed to process rule');
                        }
                    });
                }
            }
        });

        $("[name^='builder_rule_']").select2({});

    </script>

    <?php
}

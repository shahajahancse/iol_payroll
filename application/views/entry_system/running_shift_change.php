<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
<style>
    #fileDiv th, #fileDiv td {
        padding: 5px 8px !important;
        font-size: 13px;
        white-space: nowrap;
    }
</style>

    <?php
        $this->load->model('common_model');
        $unit = $this->common_model->get_unit_id_name();
    ?>
    <div class="content">
        <div class="row">
            <div class="col-md-5">
                <div id="msg_box"></div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="row tablebox" style="display: block;">
                <input type="hidden" name="unit_id" id="unit_id" value="1">

                <!-- Current Shift filter -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label>Current Shift (Filter) </label>
                        <select class="form-control input-sm shift" id='shift' name='shift' onChange="grid_emp_list()">
                            <option value=''>All Shifts</option>
                            <?php
                                $shifts = $this->db->get('pr_emp_shift');
                                if (!empty($shifts)) {
                                    foreach ($shifts->result() as $key => $val) { ?>
                                        <option value='<?= $val->id ?>'><?= $val->shift_name ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>

                <!-- Department -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label>Department </label>
                        <select class="form-control input-sm dept" id='dept' name='dept'>
                            <?php
                                $dpts = $this->db->where('unit_id', 1)->get('emp_depertment'); ?>
                                <option value=''>Select Department</option>
                                <?php foreach ($dpts->result() as $key => $val) { ?>
                                    <option value='<?= $val->dept_id ?>'><?= $val->dept_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Section -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Section </label>
                        <select class="form-control input-sm section" id='section' name='section'>
                            <option value=''></option>
                        </select>
                    </div>
                </div>

                <!-- line (hidden) -->
                <input type="hidden" class="line" id="line" name="line" value="0">

                <!-- Designation -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Designation</label>
                        <select class="form-control input-sm desig" id='desig' name='desig' onChange="grid_emp_list()">
                            <option value=''></option>
                        </select>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <?php $categorys = $this->db->get('emp_category_status')->result(); ?>
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Status </label>
                        <select name="status" id="status" class="form-control input-sm" onChange="grid_emp_list()">
                            <option value="">All Employee</option>
                            <?php foreach ($categorys as $key => $row) { ?>
                                <option value="<?= $row->id ?>" <?= ($row->id == 1) ? 'selected' : '' ?>><?= $row->status_type; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Permanent Shift filter -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Permanent Shift (Filter) </label>
                        <select class="form-control input-sm per_shift" id='per_shift' name='per_shift' onChange="grid_emp_list()">
                            <option value=''>All Permanent Shifts</option>
                            <?php
                                if (!empty($shifts)) {
                                    foreach ($shifts->result() as $key => $val) { ?>
                                        <option value='<?= $val->id ?>'><?= $val->shift_name ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div id="loader" align="center" style="margin:0 auto; overflow:hidden; display:none; margin-top:5px;">
                <img src="<?php echo base_url('images/ajax-loader.gif'); ?>" />
            </div>

            <!-- Change Shift Panel -->
            <div id="change_panel" class="row nav_head" style="margin-top: 13px;">
                <div class="col-md-12" style="display: flex;gap: 11px;flex-direction: column;">
                    <div class="col-md-12" style="box-shadow: 0px 0px 2px 2px #bdbdbd;border-radius: 4px;padding: 12px 15px; background: #fff;">
                        <div class="row">
                            <div class="col-md-5" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label"><strong>Shift Type</strong></label>
                                    <select id="change_type" class="form-control input-sm">
                                        <option value="running">Running Shift</option>
                                        <option value="permanent">Permanent Shift</option>
                                        <option value="both">Both (Running & Permanent)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label"><strong>Change To Shift</strong></label>
                                    <select name="" id="new_shift_id" class="form-control input-sm">
                                        <option value="">-- Select New Shift --</option>
                                        <?php
                                        $all_shifts = $this->db->get('pr_emp_shift')->result();
                                        foreach ($all_shifts as $s) { ?>
                                            <option value="<?= $s->id ?>"><?= $s->shift_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 5px !important; padding-top: 25px !important;">
                                <button type="button" class="btn btn-danger btn-sm" id="btn_save_shift" onclick="save_shift_change()" style="width: 100%;">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee list right side -->
        <div class="col-md-7 tablebox">
            <input type="text" id="searchi" class="form-control" placeholder="Search">
            <div style="height: 80vh; overflow-y: auto; overflow-x: hidden;">
                <table class="table table-hover" id="fileDiv" style="width: 100%;">
                    <thead>
                        <tr style="position: sticky;top: 0;z-index:1">
                            <th class="active" style="width:5%; text-align: center;"><input type="checkbox" id="select_all" class="select-all checkbox" name="select-all"></th>
                            <th style="width:12%; background:#0177bcc2; color:white; text-align: center;">Id</th>
                            <th style="width:35%; background:#0177bc; color:white;">Name</th>
                            <th class="text-center" style="width:24%; background:#0177bc; color:white;">Current Shift</th>
                            <th class="text-center" style="width:24%; background:#0177bc; color:white;">Per Shift</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php if (!empty($employees)) {
                            foreach ($employees as $key => $emp) {
                        ?>
                                <tr class="removeTr">
                                    <td><input type="checkbox" class="checkbox" id="emp_id" name="emp_id[]" value="<?= $emp->emp_id ?>">
                                    </td>
                                    <td class="success"><?= $emp->emp_id ?></td>
                                    <td class="warning "><?= $emp->name_en ?></td>
                                    <td><?= isset($emp->shift_name) ? $emp->shift_name : '' ?></td>
                                    <td><?= isset($emp->per_shift_name) ? $emp->per_shift_name : '' ?></td>
                                </tr>
                        <?php }
                        } ?>
                        <tr class="removeTrno">
                            <td colspan="5" class="text-center"> No data found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function loading_open() {
            $('#loader').css('display', 'block');
        }
    </script>

    <script>


        // Save shift change (supports running, permanent, or both)
        function save_shift_change(explicit_type) {
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            var emp_ids = sql.split(",").filter(function(v){ return v !== ''; });

            if (emp_ids.length === 0) {
                showMessage('error', 'Please select at least one employee');
                return false;
            }

            var new_shift_id = document.getElementById('new_shift_id').value;
            if (new_shift_id === '') {
                showMessage('error', 'Please select a shift to assign');
                return false;
            }

            var change_type = explicit_type || document.getElementById('change_type').value || 'running';

            $('#loader').css('display', 'block');

            $.ajax({
                type: "POST",
                url: '<?= base_url('entry_system_con/running_shift_change_save') ?>',
                data: {
                    'emp_ids[]': emp_ids,
                    'shift_id': new_shift_id,
                    'change_type': change_type
                },
                dataType: 'json',
                success: function(data) {
                    $('#loader').css('display', 'none');
                    if (data.status === 'success') {
                        showMessage('success', data.msg);
                        // Refresh employee list so current shift and per shift columns update
                        grid_emp_list();
                    } else {
                        showMessage('error', data.msg);
                    }
                },
                error: function() {
                    $('#loader').css('display', 'none');
                    showMessage('error', 'Something went wrong');
                }
            });
        }

        function save_running_shift_change() {
            save_shift_change('running');
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#searchi").on("keyup", function() {
                grid_emp_list()
            });
        });
    </script>

    <script type="text/javascript">
        // Load employee list via AJAX
        function grid_emp_list() {
            $('.removeTr').remove();

            var unit    = document.getElementById('unit_id').value;
            var dept    = document.getElementById('dept').value;
            var section = document.getElementById('section').value;
            var line    = document.getElementById('line').value;
            var desig   = document.getElementById('desig').value;
            var status  = document.getElementById('status').value;
            var searchi = document.getElementById('searchi').value;
            var shift     = document.getElementById('shift') ? document.getElementById('shift').value : '';
            var per_shift = document.getElementById('per_shift') ? document.getElementById('per_shift').value : '';

            url = hostname + "common/grid_emp_list/" + unit + "/" + dept + "/" + section + "/" + line + "/" + desig;
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "status":    status,
                    "searchi":   searchi,
                    "shift":     shift,
                    "per_shift": per_shift
                },
                contentType: "application/json",
                dataType: "json",
                success: function(response) {
                    $('.removeTr').remove();
                    if (response.length != 0) {
                        $('.removeTrno').hide();
                        var items = '';
                        $.each(response, function(index, value) {
                            items += `
                                <tr class="removeTr">
                                    <td><input type="checkbox" class="checkbox" id="emp_id" name="emp_id[]" value="${value.emp_id}"></td>
                                    <td class="success">${value.emp_id}</td>
                                    <td class="warning">${value.name_en}</td>
                                    <td>${value.shift_name ? value.shift_name : ''}</td>
                                    <td>${value.per_shift_name ? value.per_shift_name : ''}</td>
                                </tr>`;
                        });
                        $('#fileDiv tr:last').after(items);
                    } else {
                        $('.removeTrno').show();
                        $('.removeTr').remove();
                    }
                }
            });
        }

        $(document).ready(function() {
            // Select all / deselect all
            $("#select_all").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            // Section on dept change
            $('#dept').change(function() {
                $('.section').addClass('form-control input-sm');
                $(".section > option").remove();
                $(".desig > option").remove();
                var id = $('#dept').val();
                $.ajax({
                    type: "POST",
                    url: hostname + "common/ajax_section_by_dept_id/" + id,
                    success: function(func_data) {
                        $('.section').append("<option value=''>-- Select Section --</option>");
                        $.each(func_data, function(id, name) {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(name);
                            $('.section').append(opt);
                        });
                    }
                });
                $.ajax({
                    type: "POST",
                    url: hostname + "common/ajax_designation_by_unit/1",
                    success: function(func_data) {
                        $('.desig').append("<option value=''>-- Select Designation --</option>");
                        $.each(func_data, function(id, name) {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(name);
                            $('.desig').append(opt);
                        });
                    }
                });
                grid_emp_list();
            });

            $('#section').change(function() {
                grid_emp_list();
            });

            // Initial designation load
            $.ajax({
                type: "POST",
                url: hostname + "common/ajax_designation_by_unit/1",
                success: function(func_data) {
                    $('.desig').append("<option value=''>-- Select Designation --</option>");
                    $.each(func_data, function(id, name) {
                        var opt = $('<option />');
                        opt.val(id);
                        opt.text(name);
                        $('.desig').append(opt);
                    });
                }
            });

            grid_emp_list();
        });
    </script>

    <script>
        function get_checked_value(checkboxes) {
            var vals = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value)
                .join(",");
            return vals;
        }
    </script>

<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
    <style>
        #fileDiv #removeTr td {
            padding: 5px 10px !important;
            font-size: 14px;
        }
    </style>
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

    <?php
        $this->load->model('common_model');
        $unit = $this->common_model->get_unit_id_name();
    ?>
    <div class="content">
        <div class="row">
            <div class="col-md-8">
                <?php $success = $this->session->flashdata('success');
                if ($success != "") { ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php }
                $error = $this->session->flashdata('error');
                if ($error) { ?>
                    <div class="alert alert-failuer"><?php echo $error; ?></div>
                <?php } ?>
            </div>
        </div>
        <!-- <div class="container-fluid">	 -->
        <div class="col-md-8">
            <!-- start default panel (dept/section/line/desig) -->
            <div class="row tablebox" style="display: block;">
                <!-- <h3 style="font-weight: 600;"><?= $title ?></h3> -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label>Unit <span style="color: red;">*</span> </label>
                        <select name="unit_id" id="unit_id" class="form-control input-sm">
                            <option value="">Select Unit</option>
                            <?php
                            foreach ($dept as $row) {
                                if ($row['unit_id'] == $user_data->unit_name) {
                                    $select_data = "selected";
                                } else {
                                    if ($user_data->level != "All") {
                                        continue;
                                    }
                                }
                                echo '<option ' . $select_data . '  value="' . $row['unit_id'] . '">' . $row['unit_name'] .
                                    '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- department -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label>Department </label>
                        <select class="form-control input-sm dept" id='dept' name='dept'>
                            <?php if (!empty($user_data->unit_name)) {
                                $dpts = $this->db->where('unit_id', $user_data->unit_name)->get('emp_depertment'); ?>
                                <option value=''>Select Department</option>
                                <?php foreach ($dpts->result() as $key => $val) { ?>
                                    <option value='<?= $val->dept_id ?>'><?= $val->dept_name ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <!-- section -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Section </label>
                        <select class="form-control input-sm section" id='section' name='section'>
                            <option value=''></option>
                        </select>
                    </div>
                </div>
                <!-- line -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Line </label>
                        <select class="form-control input-sm line" id='line' name='line'>
                            <option value=''></option>
                        </select>
                    </div>
                </div>
                <!-- Designation -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Designation</label>
                        <select class="form-control input-sm desig" id='desig' name='desig' onChange="grid_emp_list()">
                            <option value=''></option>
                        </select>
                    </div>
                </div>
                <!-- status -->
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
            </div>
            <br>
            <div id="loader" align="center" style="margin:0 auto; overflow:hidden; display:none; margin-top:5px;">
                <img src="<?php echo base_url('images/ajax-loader.gif'); ?>" />
            </div>

            <!-- present / absent entry form -->
            <div id="present_entry" class="row nav_head" style="margin-top: 13px;">
                <div class="col-md-12" style="display: flex;gap: 11px;flex-direction: column;">
                    <div class="col-md-12" style="box-shadow: 0px 0px 2px 2px #bdbdbd;border-radius: 4px;padding-top: 10px; padding-bottom: 10px;">
                        <form method="post" id="present_entry_form">
                            <div class="raw">
                                <div class="col-md-3" style="padding: 5px !important">
                                    <div class="form-group" style="margin-bottom: 3px !important;">
                                        <label class="control-label">From Date</label>
                                        <input class="form-control date" id="first_date" name="first_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding: 5px !important">
                                    <div class="form-group" style="margin-bottom: 3px !important;">
                                        <label class="control-label">To Date</label>
                                        <input class="form-control date" id="second_date" name="second_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding: 5px !important">
                                    <div class="form-group" style="margin-bottom: 3px !important;">
                                        <label class="control-label">In Time</label>
                                        <input class="form-control" id="in_time" name="in_time" placeholder="hh:mm:ss">
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding: 5px !important">
                                    <div class="form-group" style="margin-bottom: 3px !important;">
                                        <label class="control-label">Out Time</label>
                                        <input class="form-control" id="out_time" name="out_time" placeholder="hh:mm:ss">
                                    </div>
                                </div>
                            </div>
                            <div class="raw">
                                <div class="col-md-12" style="padding: 10px 5px !important;">
                                    <div class="input-group">
                                        <span class="input-group-btn" style="display: flex; gap: 15px;">
                                            <input class="btn btn-primary" onclick='present_entry(event)' type="button" value='Save' />
                                            <?php
                                                $user_id = $this->session->userdata('data')->id;
                                                $acl = check_acl_list($user_id);
                                            ?>
                                            <?php  if(!in_array(10,$acl)) { ?>
                                                <input class="btn btn-info" onclick="log_sheet(event)" type="button" value="Attn. Sheet">
                                            <?php } ?>
                                            <?php  if(in_array(128,$acl)) { ?>
                                                <input class="btn btn-danger" onclick="present_absent(event)" type="button" value="Absent">
                                            <?php } ?>
                                            <?php  if(in_array(129,$acl)) { ?>
                                                <input class="btn btn-danger" onclick="log_delete(event)" type="button" value="Log Delete">
                                            <?php } ?>
                                        </span>
                                    </div><!-- /input-group -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stop Salary -->
            <?php
                $user_id = $this->session->userdata('data')->id;
                $acl = check_acl_list($user_id);
            ?>
            <?php if(in_array(127,$acl)) { ?>
                <div id="eot_modify" class="row nav_head" style="margin-top: 13px;">
                    <div class="col-md-12" style="display: flex;gap: 11px;flex-direction: column;">
                        <div class="col-md-12" style="box-shadow: 0px 0px 2px 2px #bdbdbd;border-radius: 4px;padding-top: 10px; padding-bottom: 10px;">
                            <form method="post" id="eot_modify_form">
                                <div class="raw">
                                    <div class="col-md-4" style="padding: 5px !important">
                                        <div class="form-group" style="margin-bottom: 3px !important;">
                                            <label class="control-label">Stop Salary Month</label>
                                            <input class="form-control input-sm" type="month" id="stop_month" name="stop_month" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px !important">
                                        <div class="input-group" style="top: 15px;">
                                            <span class="input-group-btn" style="display: flex; gap: 15px;">
                                                <input class="btn btn-primary" onclick="stop_salary(event)" type="button" value="Save">
                                                <input class="btn btn-danger" style="<?php  if(in_array(132,$acl)) {echo '';} else { echo 'display:none;"';}?>" onclick="stop_delete(event)" type="button" value="Delete">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <style>
                .hints {
                    color: #436D19;
                    font-weight: bold;
                }
            </style>

            <!-- alert entry form   -->
            <div id="alert_system" class="row nav_head" style="margin-top: 13px;">
                <div class="col-md-12" style="display: flex;gap: 11px;flex-direction: column;">
                    <div class="col-md-12" style="box-shadow: 0px 0px 2px 2px #bdbdbd;border-radius: 4px;padding-top: 10px; padding-bottom: 10px;">
                        <form method="post" id="eot_modify_form">
                            <div class="raw">
                                <div class="col-md-3" style="padding: 5px !important">
                                    <div class="form-group" style="margin-bottom: 3px !important;">
                                        <label class="control-label">Date</label>
                                        <input class="form-control date" id="alert_date" name="alert_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-9" style="padding: 5px !important">
                                    <div class="form-group" style="margin-bottom: 3px !important;">
                                        <label class="control-label">Alert Remark</label>
                                        <textarea class="form-control" name="alert_remark" id="alert_remark"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group pull-right">
                                        <span class="input-group-btn" style="display: flex; gap: 15px; right:-5px">
                                            <input class="btn btn-primary" onclick="alert_system(event)" type="button" value="Save">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- employee list for right side -->
        <div class="col-md-4 tablebox">
            <input type="text" id="searchi" class="form-control" placeholder="Search">
            <div style="height: 80vh; overflow-y: scroll;">
                <table class="table table-hover" id="fileDiv">
                    <thead>
                        <tr style="position: sticky;top: 0;z-index:1">
                            <th class="active" style="width:10%"><input type="checkbox" id="select_all" class="select-all checkbox" name="select-all"></th>
                            <th class="" style="background:#0177bcc2;color:white">Id</th>
                            <th class=" text-center" style="background:#0177bc;color:white">Name</th>
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
                                </tr>
                        <?php }
                        } ?>
                        <tr class="removeTrno">
                            <td colspan="3" class="text-center"> No data found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- </div> -->
    </div>

    <script>
        function loading_open() {
            $('#loader').css('display', 'block');
        }
    </script>

    <!-- Alert system entry -->
    <script>
        function alert_system(e) {
            e.preventDefault();
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            let emp_id = sql.split(",");
            if (emp_id == '') {
                showMessage('error', 'Please select employee Id');
                return false;
            }
            if (emp_id.length > 1) {
                showMessage('error', 'Please select max one employee Id');
                return false;
            }
            unit_id = document.getElementById('unit_id').value;
            if (unit_id == '') {
                showMessage('error', 'Please select Unit');
                return false;
            }

            alert_date = document.getElementById('alert_date').value;
            if (alert_date == '') {
                showMessage('error', 'Please select Alert Date');
                return false;
            }

            msg = document.getElementById('alert_remark').value;
            if (msg == '') {
                showMessage('error', 'Please enter Alert Remark');
                return false;
            }

            var data = "emp_id=" + emp_id + "&unit_id=" + unit_id + "&alert_date=" + alert_date + "&msg=" + msg;
            $.ajax({
                type: "POST",
                url: hostname + "entry_system_con/alert_system",
                data: data,
                success: function(data) {
                    $("#loader").hide();
                    if (data == 'success') {
                        showMessage('success', 'Record Inserted Successfully');
                    } else {
                        showMessage('error', data);
                    }
                },
                error: function(data) {
                    $("#loader").hide();
                    showMessage('error', 'Record Not Inserted');
                }
            })
        }
    </script>

    <!-- stop salary -->
    <script>
        function stop_salary(e) {
            e.preventDefault();
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            let emp_id = sql.split(",");
            if (emp_id == '') {
                showMessage('error', 'Please select employee Id');
                return false;
            }
            unit_id = document.getElementById('unit_id').value;
            if (unit_id == '') {
                showMessage('error', 'Please select Unit');
                return false;
            }

            stop_month = document.getElementById('stop_month').value;
            if (stop_month == '') {
                showMessage('error', 'Please select Stop Salary Month');
                return false;
            }

            var data = "emp_id=" + emp_id + "&unit_id=" + unit_id + "&stop_month=" + stop_month;
            $.ajax({
                type: "POST",
                url: hostname + "entry_system_con/stop_salary",
                data: data,
                success: function(data) {
                    $("#loader").hide();
                    if (data == 'success') {
                        showMessage('success', 'Record Inserted Successfully');
                    } else {
                        showMessage('error', data);
                    }
                },
                error: function(data) {
                    $("#loader").hide();
                    showMessage('error', 'Record Not Inserted');
                }
            })
        }

        function stop_delete(e) {
            e.preventDefault();
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            let emp_id = sql.split(",");
            if (emp_id == '') {
                showMessage('error', 'Please select employee Id');
                return false;
            }
            unit_id = document.getElementById('unit_id').value;
            if (unit_id == '') {
                showMessage('error', 'Please select Unit');
                return false;
            }

            stop_month = document.getElementById('stop_month').value;
            if (stop_month == '') {
                showMessage('error', 'Please select Stop Salary Month');
                return false;
            }

            var data = "emp_id=" + emp_id + "&unit_id=" + unit_id + "&stop_month=" + stop_month;
            loading_open();
            $.ajax({
                type: "POST",
                url: hostname + "entry_system_con/stop_delete",
                data: data,
                success: function(data) {
                    loading_close();
                    if (data == 'success') {
                        showMessage('success', 'Stop Salary Deleted Successfully');
                    } else {
                        showMessage('error', data);
                    }
                },
                error: function(data) {
                    loading_close();
                    showMessage('error', 'Stop Salary Not Deleted');
                }
            })
        }
    </script>

    <script>
        function eot_modify_entry(e) {
            e.preventDefault();
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            let emp_id = sql.split(",");
            if (emp_id == '') {
                showMessage('error', 'Please select employee Id');
                return false;
            }

            if (emp_id.length > 1) {
                showMessage('error', 'Please select max one employee Id');
                return false;
            }

            unit_id = document.getElementById('unit_id').value;
            if (unit_id == '') {
                showMessage('error', 'Please select Unit');
                return false;
            }

            first_date = document.getElementById('eot_f_date').value;
            if (first_date == '') {
                showMessage('error', 'Please select First date');
                return false;
            }
            second_date = document.getElementById('eot_s_date').value;
            if (second_date == '') {
                showMessage('error', 'Please select Second date');
                return false;
            }
            eot = document.getElementById('eot').value;
            if (eot == '') {
                showMessage('error', 'Please entry the eot');
                return false;
            }

            var formdata = $("#eot_modify_form").serialize();
            var data = "unit_id=" + unit_id + "&first_date=" + first_date + "&second_date=" + second_date + "&eot=" + eot + "&emp_id=" + emp_id + "&" + formdata; // Merge the data

            loading_open();
            $.ajax({
                type: "POST",
                url: hostname + "entry_system_con/eot_modify_entry",
                data: data,
                success: function(data) {
                    loading_close();
                    if (data == 'success') {
                        showMessage('success', 'EOT updated Successfully');
                    } else {
                        showMessage('error', data);
                    }
                },
                error: function(data) {
                    loading_close();
                    showMessage('error', 'EOT not updated');
                }
            })
        }

        function log_sheet(e) {
            e.preventDefault();
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            let emp_id = sql.split(",");
            if (emp_id == '') {
                showMessage('error', 'Please select employee Id');
                return false;
            }
            if (emp_id.length > 1) {
                showMessage('error', 'Please select max one employee Id');
                return false;
            }

            unit_id = document.getElementById('unit_id').value;
            if (unit_id == '') {
                showMessage('error', 'Please select Unit');
                return false;
            }

            first_date = document.getElementById('first_date').value;
            if (first_date == '') {
                showMessage('error', 'Please select First date');
                return false;
            }
            second_date = document.getElementById('second_date').value;
            if (second_date == '') {
                showMessage('error', 'Please select Second date');
                return false;
            }


            var formdata = $("#present_entry_form").serialize();
            var data="emp_id="+emp_id+"&unit_id="+unit_id+"&first_date="+first_date+"&second_date="+second_date+ "&" + formdata;
            url =  hostname + "entry_system_con/log_sheet/";
            ajaxRequest = new XMLHttpRequest();
            ajaxRequest.open("POST", url, true);
            ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
            ajaxRequest.send(data);

            ajaxRequest.onreadystatechange = function () {
                if(ajaxRequest.readyState == 4){
                    var resp = ajaxRequest.responseText;
                    show = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
                    show.document.write(resp);
                }
            }
        }
    </script>
    <script>
        function present_entry(e) {
            e.preventDefault();
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            let emp_id = sql.split(",");
            if (emp_id == '') {
                showMessage('error', 'Please select employee Id');
                return false;
            }
            unit_id = document.getElementById('unit_id').value;
            if (unit_id == '') {
                showMessage('error', 'Please select Unit');
                return false;
            }

            first_date = document.getElementById('first_date').value;
            if (first_date == '') {
                showMessage('error', 'Please select First date');
                return false;
            }
            second_date = document.getElementById('second_date').value;
            if (second_date == '') {
                showMessage('error', 'Please select Second date');
                return false;
            }
            in_time = document.getElementById('in_time').value;
            out_time = document.getElementById('out_time').value;
            // Check if BOTH are empty
            if (in_time === '' && out_time === '') {
                showMessage('error', 'Please select at least In Time or Out Time');
                return false;
            }

            var formdata = $("#present_entry_form").serialize();
            var data = "unit_id=" + unit_id + "&first_date=" + first_date + "&second_date=" + second_date + "&in_time=" + in_time + "&out_time=" + out_time + "&emp_id=" + emp_id + "&" + formdata; // Merge the data

            $.ajax({
                type: "POST",
                url: hostname + "entry_system_con/present_entry",
                data: data,
                success: function(data) {
                    $("#loader").hide();
                    if (data == 'success') {
                        showMessage('success', 'Record Inserted Successfully');
                    } else {
                        showMessage('error', data);
                    }
                },
                error: function(data) {
                    $("#loader").hide();
                    showMessage('error', 'Record Not Inserted');
                }
            })
        }

        function present_absent(e) {
            e.preventDefault();
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            let emp_id = sql.split(",");
            if (emp_id == '') {
                showMessage('error', 'Please select employee Id');
                return false;
            }
            unit_id = document.getElementById('unit_id').value;
            if (unit_id == '') {
                showMessage('error', 'Please select Unit');
                return false;
            }

            first_date = document.getElementById('first_date').value;
            if (first_date == '') {
                showMessage('error', 'Please select First date');
                return false;
            }
            second_date = document.getElementById('second_date').value;
            if (second_date == '') {
                showMessage('error', 'Please select Second date');
                return false;
            }
            time = document.getElementById('in_time').value;

            var formdata = $("#present_entry_form").serialize();
            var data = "unit_id=" + unit_id + "&first_date=" + first_date + "&second_date=" + second_date + "&time=" + time + "&emp_id=" + emp_id + "&" + formdata; // Merge the data

            $.ajax({
                type: "POST",
                url: hostname + "entry_system_con/present_absent",
                data: data,
                success: function(data) {
                    $("#loader").hide();
                    if (data == 'success') {
                        showMessage('success', 'Record Deleted Successfully');
                    } else {
                        showMessage('error', data);
                    }
                },
                error: function(data) {
                    $("#loader").hide();
                    showMessage('error', 'Record Not Deleted');
                }
            })
        }

        function log_delete(e) {
            e.preventDefault();
            var checkboxes = document.getElementsByName('emp_id[]');
            var sql = get_checked_value(checkboxes);
            let emp_id = sql.split(",");
            if (emp_id == '') {
                showMessage('error', 'Please select employee Id');
                return false;
            }
            unit_id = document.getElementById('unit_id').value;
            if (unit_id == '') {
                showMessage('error', 'Please select Unit');
                return false;
            }

            first_date = document.getElementById('first_date').value;
            if (first_date == '') {
                showMessage('error', 'Please select First date');
                return false;
            }
            second_date = document.getElementById('second_date').value;
            if (second_date == '') {
                showMessage('error', 'Please select Second date');
                return false;
            }
            time = document.getElementById('time').value;

            var formdata = $("#present_entry_form").serialize();
            var data = "unit_id=" + unit_id + "&first_date=" + first_date + "&second_date=" + second_date + "&time=" + time + "&emp_id=" + emp_id + "&" + formdata; // Merge the data

            loading_open();
            $.ajax({
                type: "POST",
                url: hostname + "entry_system_con/log_delete",
                data: data,
                success: function(data) {
                    loading_close();
                    if (data == 'success') {
                        showMessage('success', 'Shift Log Deleted Successfully');
                    } else {
                        showMessage('error', data);
                    }
                },
                error: function(data) {
                    loading_close();
                    showMessage('error', 'Shift Log Not Deleted');
                }
            })
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
        // on load employee
        function grid_emp_list() {
            $('.removeTr').remove();

            var unit = document.getElementById('unit_id').value;
            var dept = document.getElementById('dept').value;
            var section = document.getElementById('section').value;
            var line = document.getElementById('line').value;
            var desig = document.getElementById('desig').value;
            var status = document.getElementById('status').value;
            var searchi = document.getElementById('searchi').value;

            url = hostname + "common/grid_emp_list/" + unit + "/" + dept + "/" + section + "/" + line + "/" + desig;
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "status": status,
                    "searchi": searchi
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
                                    <td><input type="checkbox" class="checkbox" id="emp_id" name="emp_id[]" value="${value.emp_id }" ></td>
                                    <td class="success">${value.emp_id}</td>
                                    <td class="warning ">${value.name_en}</td>
                                </tr>`
                        });
                        // console.log(items);
                        $('#fileDiv tr:last').after(items);
                    } else {
                        $('.removeTrno').show();
                        $('.removeTr').remove();
                    }
                }
            });
        }

        $(document).ready(function() {
            // select all item or deselect all item
            $("#select_all").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            //Designation dropdown
            $('#line').change(function() {
                $('.desig').addClass('form-control input-sm');
                $(".desig > option").remove();
                var id = $('#line').val();
                $.ajax({
                    type: "POST",
                    url: hostname + "common/ajax_designation_by_line_id/" + id,
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
                // load employee
                grid_emp_list();
            });

            //Line dropdown
            $('#section').change(function() {
                $('.line').addClass('form-control input-sm');
                $(".line > option").remove();
                $(".desig > option").remove();
                var id = $('#section').val();
                $.ajax({
                    type: "POST",
                    url: hostname + "common/ajax_line_by_sec_id/" + id,
                    success: function(func_data) {
                        $('.line').append("<option value=''>-- Select Line --</option>");
                        $.each(func_data, function(id, name) {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(name);
                            $('.line').append(opt);
                        });
                    }
                });
                // load employee
                grid_emp_list();
            });

            //section dropdown
            $('#dept').change(function() {
                $('.section').addClass('form-control input-sm');
                $(".section > option").remove();
                $(".line > option").remove();
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
                // load employee
                grid_emp_list();
            });

            //Department dropdown
            $('#unit_id').change(function() {
                $('.dept').addClass('form-control input-sm');
                $(".dept > option").remove();
                $(".section > option").remove();
                $(".line > option").remove();
                $(".desig > option").remove();
                var id = $('#unit_id').val();
                $.ajax({
                    type: "POST",
                    url: hostname + "common/ajax_department_by_unit_id/" + id,
                    success: function(func_data) {
                        $('.dept').append("<option value=''>-- Select Department --</option>");
                        $.each(func_data, function(id, name) {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(name);
                            $('.dept').append(opt);
                        });
                    }
                });
                // load employee
                grid_emp_list();
            });
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

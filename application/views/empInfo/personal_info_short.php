<style>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}
/* .bangla_name {
    font-family: SutonnyMJ !important;
} */


</style>
<!-- < ? php dd($emp_info);?> -->
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <?php $success = $this->session->flashdata('success');
        if ($success != "") { ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php }
         $failuer = $this->session->flashdata('failuer');
         if ($failuer) { ?>
            <div class="alert alert-failuer"><?php echo $failuer; ?></div>
            <?php } ?>
        </div>
    </div>

    <div id="target-div">
        <div class="container-fluid">
            <button onclick="emp_id_search()" class="form-control btn input-sm  btn-success"
                style="width: 8%;line-height: 10px !important;float: right;border-radius: 0 !important; margin-top: 7px;">Search</button>

            <input id="employee_id" type="text" class="form-control input-sm" placeholder="Search"
                style="margin-top: 8px;width:15%;float:right;border-radius: 0 !important;">

            <form id="form_id" enctype="multipart/form-data" method="post" name="creatdepartment"
                action="<?php echo base_url('emp_info_con/personal_info_add_short')?>">
                <h3 style="font-weight: bold; width:fit-content"><?= $title.' Short' ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                        class="text-center" style="font-size:18px !important" id='last_emp_id'></span></h3>

                <hr style="margin-bottom: 0px !important;">
                <div style="background-color: white; padding: 15px !important;">
                    <!-- Unit field commented out, default set to 1 -->
                    <input type="hidden" name="unit_id" id="unit_id" value="<?= isset($emp_info->unit_id) ? $emp_info->unit_id : 1 ?>">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Emp Id <span style="color: red;">*</span> </label>
                                <input type="text" name="emp_id" id="emp_id" class="form-control input-sm required"
                                    value="<?= isset($emp_info->emp_id) ? $emp_info->emp_id : '' ?>" required>
                                <?php echo form_error('emp_id');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Punch Card No. <span style="color: red;">*</span> </label>
                                <input type="text" name="proxi_id" id="proxi_id"
                                    class="form-control input-sm required"
                                    value="<?= isset($emp_info->proxi_id) ? $emp_info->proxi_id : set_value('proxi_id')?>" required>
                                <?php echo form_error('proxi_id');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name (Bangla) <span style="color: red;">*</span> </label>
                                <input type="text" name="name_bn" id="name_bn"
                                    class="form-control input-sm bangla_name required" value="<?= isset($emp_info->name_bn) ? $emp_info->name_bn : '' ?>"
                                    required>
                                <?php echo form_error('name_bn');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name (English) <span style="color: red;">*</span> </label>
                                <input type="text" name="name_en" id="name_en"
                                    class="form-control input-sm english_name required" value="<?= isset($emp_info->name_en) ? $emp_info->name_en : '' ?>"
                                    required>
                                <?php echo form_error('name_en');?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date Of Birth <span style="color: red;">*</span> </label>
                                <input type="text" name="emp_dob" id="emp_dob" class="date form-control input-sm required"
                                    value="<?= isset($emp_info->emp_dob)?>" required>
                                <?php echo form_error('emp_dob');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Gender <span style="color: red;">*</span> </label>
                                <?php echo form_error('gender');?>
                                <select name="gender" id="gender" class="form-control input-sm required" required>
                                    <option value="">select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Common">Common</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Personal Mobile <span style="color: red;">*</span> </label>
                                <input type="text" name="personal_mobile" id="personal_mobile"
                                    class="form-control input-sm required" required>
                                <?php echo form_error('personal_mobile');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bank account.<span style="color: red;">*</span> </label>
                                <input type="text" name="bank_bkash_no" id="bank_bkash_no" class="form-control input-sm required"
                                    required>
                                <?php echo form_error('bank_bkash_no');?>
                            </div>
                        </div>
                    </div>

                </div>


                <h3 style="font-weight: 600;">Official Information</h3>
                <hr style="margin-bottom: 0px !important;">
                <div style="background-color: white; padding: 15px !important;">
                    <?php
                        $depts = $this->db->get('emp_depertment')->result();
                        $sections = $this->db->get('emp_section')->result();
                        $lines = $this->db->get('emp_line_num')->result();
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Department <span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_dept_id');?>
                                <select name="emp_dept_id" id="emp_dept_id" class="form-control input-sm required" required>
                                    <option value="">-- Select Department --</option>
                                    <?php foreach ($depts as $key => $row) {
                                        $d_id = isset($row->dept_id) && $row->dept_id ? $row->dept_id : (isset($row->id) ? $row->id : '');
                                        $d_en = !empty($row->dept_name) ? $row->dept_name : (!empty($row->dept_name_en) ? $row->dept_name_en : '');
                                        $d_bn = !empty($row->dept_bangla) ? $row->dept_bangla : (!empty($row->dept_name_bn) ? $row->dept_name_bn : '');
                                    ?>
                                    <option value="<?= $d_id ?>"><?= $d_en . ($d_bn ? ' >> '.$d_bn : ''); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Section <span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_sec_id');?>
                                <select name="emp_sec_id" id="emp_sec_id" class="emp_sec_id form-control input-sm required" required>
                                    <option value="">-- Select Section --</option>
                                    <?php foreach ($sections as $key => $row) {
                                        $s_id = isset($row->sec_id) && $row->sec_id ? $row->sec_id : (isset($row->id) ? $row->id : '');
                                        $s_en = !empty($row->sec_name_en) ? $row->sec_name_en : (!empty($row->sec_name) ? $row->sec_name : '');
                                        $s_bn = !empty($row->sec_name_bn) ? $row->sec_name_bn : (!empty($row->sec_bangla) ? $row->sec_bangla : '');
                                    ?>
                                    <option value="<?= $s_id ?>"><?= $s_en . ($s_bn ? ' >> '.$s_bn : ''); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-3" style="padding-left: 0px !important;">
                            <div class="form-group">
                                <label>Line<span style="color: red;">*</span> </label>
                                < ?php echo form_error('emp_line_id');?>
                                <select name="emp_line_id" id="emp_line_id" class="emp_line_id form-control input-sm required" required>
                                    <option value="">-- Select Line --</option>
                                    < ?php foreach ($lines as $key => $row) {
                                        $l_id = isset($row->line_id) && $row->line_id ? $row->line_id : (isset($row->id) ? $row->id : '');
                                        $l_en = !empty($row->line_name_en) ? $row->line_name_en : (!empty($row->line_name) ? $row->line_name : '');
                                        $l_bn = !empty($row->line_name_bn) ? $row->line_name_bn : (!empty($row->line_bangla) ? $row->line_bangla : '');
                                    ?>
                                    <option value="< ?= $l_id ?>">< ?= $l_en . ($l_bn ? ' >> '.$l_bn : ''); ?></option>
                                    < ?php } ?>
                                </select>
                            </div>
                        </div> -->
                        <input type="hidden" name="emp_line_id" id="emp_line_id" value="1">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Designation<span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_desi_id');?>
                                <select name="emp_desi_id" id="emp_desi_id" class="emp_desi_id form-control input-sm required" required>
                                    <option value="">-- Select Designation --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php $categorys = $this->db->get('emp_category_status')->result(); ?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Emp Status <span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_cat_id');?>
                                <select name="emp_cat_id" id="emp_cat_id" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <?php foreach ($categorys as $key => $row) { ?>
                                    <option value="<?= $row->id ?>" <?php echo $row->id == 4 ? 'Selected':'';?>>
                                        <?= $row->status_type ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php $shifts = $this->db->where('unit_id',$user_data->unit_name)->get('pr_emp_shift')->result(); ?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Emp Shift <span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_shift');?>
                                <select name="emp_shift" id="emp_shift" class="form-control input-sm required">
                                    <!-- emp shift -->
                                    <option value="">-- Select one --</option>
                                    <?php foreach ($shifts as $key => $row) { ?>
                                    <option value="<?= $row->id?>" <?= $row->id ==13 ? 'selected' : '' ?>>
                                        <?= $row->shift_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-left: 0px !important;">
                            <div class="form-group">
                                <label>Emp Joining Date <span style="color: red;">*</span> </label>
                                <input type="text" name="emp_join_date" id="emp_join_date"
                                    class="date form-control input-sm required" required>
                                <?php echo form_error('emp_join_date');?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Off Day / Weekend <span style="color: red;">*</span> </label>
                                <?php echo form_error('weekend');?>
                                <select name="weekend" id="weekend" class="form-control input-sm required" required>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                </select>
                            </div>
                        </div>

                        <?php $sl_grade = $this->db->get('pr_grade')->result(); ?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Salary Grade <span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_sal_gra_id');?>
                                <select name="emp_sal_gra_id" id="emp_sal_gra_id" class="form-control input-sm required"
                                    required>
                                    <option value="">-- Select one --</option>
                                    <?php foreach ($sl_grade as $key => $row) { ?>
                                    <option value="<?= $row->gr_id ?>"><?= $row->gr_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                        <div class="form-group">
                            <label>Employee Type <span style="color: red;">*</span> </label>
                            <select name="emp_type" id="emp_type" class="form-control input-sm required" required="">
                                <option value="">-- Select one --</option>
                                <option value="1">Office</option>
                                <option value="2">Factory</option>
                            </select>
                        </div>
                    </div>
                    </div>

                    <!-- <div class="row">
                        <?php //dd($shifts); ?>
                        <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label>Position <span style="color: red;">*</span> </label>
                                < ?php echo form_error('position_id');?>
                                <select name="position_id" id="position_id" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    < ?php $positions = $this->db->get('pr_emp_position')->result();
                                        foreach ($positions as $key => $value) {
                                            echo '<option value="'.$value->posi_id.'">'.$value->posi_name.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label>Salary Type <span style="color: red;">*</span> </label>
                                < ?php echo form_error('salary_type');?>
                                <select name="salary_type" id="salary_type" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="1" selected>Fixed</option>
                                    <option value="2">Production</option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <label>Salary Withdraw <span style="color: red;">*</span> </label>
                                < ?php echo form_error('salary_draw');?>
                                <select name="salary_draw" id="salary_draw" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="1">cash</option>
                                    <option value="2">bank</option>
                                </select>
                            </div>
                        </div> -->

                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <label>Lunch <span style="color: red;">*</span> </label>
                                < ?php echo form_error('lunch');?>
                                <select name="lunch" id="lunch" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="0">Yes</option>
                                    <option selected value="1">No</option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <label>Transport <span style="color: red;">*</span> </label>
                                < ?php echo form_error('transport');?>
                                <select name="transport" id="transport" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="0">Yes</option>
                                    <option selected value="1">No</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
                    <input type="hidden" name="position_id" id="position_id" value="1">
                    <input type="hidden" name="salary_type" id="salary_type" value="1">
                    <input type="hidden" name="salary_draw" id="salary_draw" value="1">
                    <input type="hidden" name="lunch" id="lunch" value="1">
                    <input type="hidden" name="transport" id="transport" value="1">

                    <div class="row" <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(!in_array(10,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Salary <span style="color: red;">*</span> </label>
                                <?php echo form_error('gross_sal');?>
                                <input type="text" onkeyup="salary_structure_cal()" onchange="salary_structure_cal()" name="gross_sal" id="gross_sal"
                                    class="form-control input-sm required">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Basic Salary </label>
                                <?php echo form_error('basic_sal');?>
                                <input type="text" name="basic_sal" id="basic_sal" disabled
                                    class="form-control input-sm required">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>House </label>
                                <?php echo form_error('house_rent');?>
                                <input type="text" name="house_rent" id="house_rent" disabled
                                    class="form-control input-sm required">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Medical </label>
                                <?php echo form_error('medical');?>
                                <input type="text" name="medical" id="medical" disabled class="form-control input-sm required">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Transport </label>
                                <?php echo form_error('trans_allow');?>
                                <input type="text" name="trans_allow" id="trans_allow" disabled
                                    class="form-control input-sm required">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Food </label>
                                <?php echo form_error('food');?>
                                <input type="text" name="food" id="food" disabled class="form-control input-sm required">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label style="white-space: nowrap">Ot Entitle </label>
                            <?php echo form_error('ot_entitle');?>
                            <input type="radio" name="ot_entitle" id="ot_entitle" value="0" class="form-check-input"
                                style="display: inline; margin-right: 10px;">Yes
                            <input type="radio" name="ot_entitle" id="ot_entitle" value="1" class="form-check-input"
                                style="display: inline; margin-right: 10px;" checked>No
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Salary <span style="color: red;">*</span> </label>
                                <?php echo form_error('com_gross_sal');?>
                                <input type="text" onkeyup="salary_structure_cal2()" onchange="salary_structure_cal2()" name="com_gross_sal"
                                    id="com_gross_sal" class="form-control input-sm required" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Basic Salary </label>
                                <?php echo form_error('basic_sall');?>
                                <input type="text" name="basic_sall" id="basic_sall" readonly
                                    class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>House </label>
                                <?php echo form_error('house_rentt');?>
                                <input type="text" name="house_rentt" id="house_rentt" readonly
                                    class="form-control input-sm">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Medical </label>
                                <?php echo form_error('medicall');?>
                                <input type="text" name="medicall" id="medicall" readonly class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Conveyance </label>
                                <?php echo form_error('trans_alloww');?>
                                <input type="text" name="trans_alloww" id="trans_alloww" readonly
                                    class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label> Food </label>
                                <?php echo form_error('foodd');?>
                                <input type="text" name="foodd" id="foodd" readonly class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label style="white-space: nowrap">Ot Entitle </label>
                            <?php echo form_error('ot_entitle');?>
                            <input type="radio" name="com_ot_entitle" id="com_ot_entitle" value="0"
                                class="form-check-input" style="display: inline; margin-right: 5px;">Yes
                            <input type="radio" name="com_ot_entitle" id="com_ot_entitle" value="1"
                                class="form-check-input" style="display: inline; margin-right: 5px;" checked>No
                        </div>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group pull-right">
                            <a href="" class="btn-warning btn">Cancel</a>

                            <input type="hidden" name="submit_type" id="submit_type">

                            <input type='submit' name='edit' class="btn btn-success" value='Edit'>
                            <input type='submit' name='save' class="btn btn-primary" value='Save'>

                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
<script>
function load_sections(dept_id, selected_sec_id, callback) {
    var unit_id = $('#unit_id').val() || 1;
    dept_id = (dept_id !== undefined && dept_id !== null && dept_id !== '') ? dept_id : $('#emp_dept_id').val();

    $('#emp_sec_id').empty().append("<option value=''>-- Select Section --</option>");

    if (!dept_id) {
        load_designations('', '', callback);
        return;
    }

    $.ajax({
        type: "POST",
        url: hostname + "common/ajax_section_by_dept_id/" + dept_id + '/' + unit_id,
        dataType: "json",
        success: function(func_data) {
            if (typeof func_data === 'string') {
                try { func_data = JSON.parse(func_data); } catch(e) {}
            }
            $('#emp_sec_id').empty().append("<option value=''>-- Select Section --</option>");
            $.each(func_data, function(id, name) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(name);
                $('#emp_sec_id').append(opt);
            });
            if (selected_sec_id) {
                $('#emp_sec_id').val(selected_sec_id);
            }
            if (typeof callback === 'function') callback();
        },
        error: function() {
            if (typeof callback === 'function') callback();
        }
    });
}

function load_designations(sec_id, selected_desig_id, callback) {
    var unit_id = $('#unit_id').val() || 1;
    sec_id = (sec_id !== undefined && sec_id !== null && sec_id !== '') ? sec_id : $('#emp_sec_id').val();

    $('#emp_desi_id').empty().append("<option value=''>-- Select Designation --</option>");

    if (!sec_id) {
        if (typeof callback === 'function') callback();
        return;
    }

    $.ajax({
        type: "POST",
        url: hostname + "common/ajax_designation_by_sec_id/" + sec_id + '/' + unit_id,
        dataType: "json",
        success: function(func_data) {
            if (typeof func_data === 'string') {
                try { func_data = JSON.parse(func_data); } catch(e) {}
            }
            $('#emp_desi_id').empty().append("<option value=''>-- Select Designation --</option>");
            $.each(func_data, function(id, name) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(name);
                $('#emp_desi_id').append(opt);
            });
            if (selected_desig_id) {
                $('#emp_desi_id').val(selected_desig_id);
            }
            if (typeof callback === 'function') callback();
        },
        error: function() {
            if (typeof callback === 'function') callback();
        }
    });
}

function set_desi_item() {
    var emp_dob = localStorage.getItem('emp_dob');
    if (emp_dob && $("#emp_dob").length) {
        $("#emp_dob").val(emp_dob);
        try {
            var date = new Date(emp_dob);
            if (!isNaN(date.getTime()) && typeof $("#emp_dob").datepicker === 'function') {
                $("#emp_dob").datepicker("setDate", date);
            }
        } catch(e) {}
    }

    var emp_join_date = localStorage.getItem('emp_join_date');
    if (emp_join_date && $("#emp_join_date").length) {
        $("#emp_join_date").val(emp_join_date);
        try {
            var jDate = new Date(emp_join_date);
            if (!isNaN(jDate.getTime()) && typeof $("#emp_join_date").datepicker === 'function') {
                $("#emp_join_date").datepicker("setDate", jDate);
            }
        } catch(e) {}
    }

    var gross_sal = localStorage.getItem('gross_sal');
    var com_gross_sal = localStorage.getItem('com_gross_sal');
    if (gross_sal) {
        $('#gross_sal').val(gross_sal);
        if (typeof salary_structure_cal === 'function') salary_structure_cal();
    }
    if (com_gross_sal) {
        $('#com_gross_sal').val(com_gross_sal);
        if (typeof salary_structure_cal2 === 'function') salary_structure_cal2();
    }

    var weekend = localStorage.getItem('weekend');
    if (weekend) $('#weekend').val(weekend);

    var ot_entitle = localStorage.getItem('ot_entitle');
    if (ot_entitle !== null && ot_entitle !== undefined) {
        $('input[name="ot_entitle"][value="' + ot_entitle + '"]').prop('checked', true);
    }

    var com_ot_entitle = localStorage.getItem('com_ot_entitle');
    if (com_ot_entitle !== null && com_ot_entitle !== undefined) {
        $('input[name="com_ot_entitle"][value="' + com_ot_entitle + '"]').prop('checked', true);
    }

    var unit_id = localStorage.getItem('unit_id');
    if (unit_id) $('#unit_id').val(unit_id);

    var emp_dept_id = localStorage.getItem('emp_dept_id');
    var emp_sec_id = localStorage.getItem('emp_sec_id');
    var emp_desi_id = localStorage.getItem('emp_desi_id');

    if (emp_dept_id) {
        $('#emp_dept_id').val(emp_dept_id);
        load_sections(emp_dept_id, emp_sec_id, function() {
            if (emp_sec_id) {
                load_designations(emp_sec_id, emp_desi_id);
            } else {
                load_designations('');
            }
        });
    } else if (emp_sec_id) {
        $('#emp_sec_id').val(emp_sec_id);
        load_designations(emp_sec_id, emp_desi_id);
    } else {
        load_designations('');
    }
}

function emp_id_search(id = null) {
    if (id == null) {
        id = $('#employee_id').val();
    }
    if (!id) {
        alert('Field can not be empty');
        return;
    }
    document.getElementById("form_id").reset();
    $.ajax({
        type: 'POST',
        url: hostname + "emp_info_con/get_employees_info/",
        data: {
            id: id,
        },
        success: function(e) {
            if (e.status == false) {
                alert(e.data);
                $("#form_id").trigger("reset");
                $("#employee_id").val("");
                return false;
            }

            var data = e.data;
            $('#age').html(data.age || '-');
            $('#job_duration').html(data.job_duration || '-');

            if (e.status == true) {
                const keysToFilter = [
                    "id", "emp_id", "name_en", "name_bn",
                    "emp_dob", "gender", "personal_mobile",
                    "bank_bkash_no", "unit_id", "emp_dept_id",
                    "emp_sec_id", "emp_line_id", "emp_desi_id", "emp_sal_gra_id", "emp_type",
                    "emp_cat_id", "proxi_id", "emp_shift", "gross_sal",
                    "com_gross_sal", "ot_entitle", "com_ot_entitle", "transport", "img_source",
                    "lunch", "att_bonus", "salary_draw", "salary_type", "position_id", "emp_join_date", "weekend"
                ];

                keysToFilter.forEach(function(key) {
                    if (data[key] !== undefined && data[key] !== null) {
                        localStorage.setItem(key, data[key]);
                        if (key == 'ot_entitle' || key == 'com_ot_entitle') {
                            $('input[name="' + key + '"][value="' + data[key] + '"]').prop('checked', true);
                        } else if (key != 'emp_dept_id' && key != 'emp_sec_id' && key != 'emp_desi_id') {
                            $('#' + key).val(data[key]);
                        }
                    }
                });

                if (data.unit_id) {
                    $('#unit_id').val(data.unit_id);
                }

                if (data.emp_dept_id) {
                    $('#emp_dept_id').val(data.emp_dept_id);
                    load_sections(data.emp_dept_id, data.emp_sec_id, function() {
                        if (data.emp_sec_id) {
                            load_designations(data.emp_sec_id, data.emp_desi_id);
                        } else {
                            load_designations('');
                        }
                    });
                } else if (data.emp_sec_id) {
                    $('#emp_sec_id').val(data.emp_sec_id);
                    load_designations(data.emp_sec_id, data.emp_desi_id);
                } else {
                    load_designations('');
                }

                set_desi_item();
                if (typeof get_last_id === 'function') {
                    get_last_id();
                }
            }
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#emp_id').change(function() {
        var emp_id = $('#emp_id').val();
        $("#proxi_id").empty();
        $('#proxi_id').val(emp_id);
    });

    $('#emp_sal_gra_id').change(function() {
        var grade_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {
                grade_id: grade_id
            },
            url: hostname + "emp_info_con/get_salary_by_grade_id/",
            success: function(func_data) {
                $('#com_gross_sal').val(func_data);
                if (typeof salary_structure_cal2 === 'function') salary_structure_cal2();
            }
        });
    });

    // Section change populates Designation dropdown directly
    $('#emp_sec_id, .emp_sec_id').change(function() {
        var sec_id = $(this).val();
        load_designations(sec_id);
    });

    // Department change populates Section dropdown and resets Designation dropdown
    $('#emp_dept_id').change(function() {
        var dept_id = $(this).val();
        load_sections(dept_id, null, function() {
            load_designations('');
        });
    });

    $('#unit_id').change(function() {
        var id = $('#unit_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_department_by_unit_id/" + id,
            success: function(func_data) {
                $('#emp_dept_id').empty().append("<option value=''>-- Select Department --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('#emp_dept_id').append(opt);
                });
                $('#emp_sec_id, .emp_sec_id').empty().append("<option value=''>-- Select Section --</option>");
                $('#emp_desi_id, .emp_desi_id').empty().append("<option value=''>-- Select Designation --</option>");
            }
        });
    });

    // Auto-load section and designation if pre-selected
    var initial_dept = $('#emp_dept_id').val();
    var initial_sec = $('#emp_sec_id').val();
    var initial_desi = $('#emp_desi_id').val();
    if (initial_dept) {
        load_sections(initial_dept, initial_sec, function() {
            if (initial_sec) {
                load_designations(initial_sec, initial_desi);
            }
        });
    } else if (initial_sec) {
        load_designations(initial_sec, initial_desi);
    }
});
</script>




<!-- auto complete data -->
<script>
$(function() {
    $("#employee_id").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('autocomplete/employee_id/'); ?>",
                dataType: "json",
                data: {
                    id: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            emp_id_search(ui.item.value)
        }
    });
});


$(function() {
    $(".english_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('autocomplete/english_name/'); ?>",
                dataType: "json",
                data: {
                    english_name: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2
    });
});
$(function() {
    $(".bangla_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('autocomplete/bangla_name/'); ?>",
                dataType: "json",
                data: {
                    bangla_name: request.term
                },
                success: function(data) {
                    response(data);
                    changeFontBn();
                }
            });
        },
        minLength: 2
    });
});

function changeFontBn() {
    setTimeout(() => {
        $('.ui-menu-item-wrapper').css('font-family', 'SutonnyMJ');
    }, 500);
}

$(function() {
    $(".english_village").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('autocomplete/english_village/'); ?>",
                dataType: "json",
                data: {
                    english_village: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2
    });
});
$(function() {
    $(".bangla_village").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('autocomplete/bangla_village/'); ?>",
                dataType: "json",
                data: {
                    bangla_village: request.term
                },
                success: function(data) {
                    response(data);
                    changeFontBn();
                }
            });
        },
        minLength: 2
    });
});
</script>


<script>
function get_last_id() {
    var unit_id = $('#unit_id').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('emp_info_con/get_last_id'); ?>",
        data: {
            unit_id: unit_id
        },
        success: function(data) {

            $('#last_emp_id').empty();
            $('#last_emp_id').html('<span style="color:red">Last Id : ' + data + '</span>');
        },
        error: function(data) {
            $('#last_emp_id').empty('');
            $('#last_emp_id').html('<span style="color:red">error</span>');
        }
    })
}
get_last_id();

$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    var emp_id = urlParams.get('emp_id');
    if (emp_id) {
        $('#employee_id').val(emp_id);
        emp_id_search(emp_id);
    }
});
</script>
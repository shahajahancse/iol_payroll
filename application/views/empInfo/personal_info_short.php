<style>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}
.bangla_name {
    font-family: SutonnyMJ !important;
}


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
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Unit <span style="color: red;">*</span> </label>
                                <select name="unit_id" id="unit_id" onchange='get_last_id()' id="unit_id"
                                    class="form-control input-sm required" required>
                                    <option value="">Select Unit</option>
                                    <?php
										foreach ($units as $row) {
										if($row->unit_id == $user_data->unit_name){
											$select_data="selected";
										}else{
                                            if ($user_data->level != "All") {
                                                continue;
                                            }
										}
										echo '<option '.$select_data.'  value="'.$row->unit_id.'">'.$row->unit_name.
										'</option>';
										}
									?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Emp Id <span style="color: red;">*</span> </label>
                                <input type="text" name="emp_id" id="emp_id" class="form-control input-sm required"
                                    value="<?= isset($emp_info->emp_id)?>" required>
                                <?php echo form_error('emp_id');?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Punch Card No. <span style="color: red;">*</span> </label>
                                <input type="text" name="proxi_id" id="proxi_id" value="<?= set_value('proxi_id') ?>"
                                    required readonly class="form-control input-sm required"
                                    value="<?= isset($emp_info->proxi_id)?>" required>
                                <?php echo form_error('proxi_id');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name (Bangla) <span style="color: red;">*</span> </label>
                                <input type="text" name="name_bn" id="name_bn"
                                    class="form-control input-sm bangla_name required" value="<?= isset($emp_info->name_bn)?>"
                                    required>
                                <?php echo form_error('name_bn');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name (English) <span style="color: red;">*</span> </label>
                                <input type="text" name="name_en" id="name_en"
                                    class="form-control input-sm english_name required" value="<?= isset($emp_info->name_en)?>"
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
                        if (!empty($user_data->unit_name)) {
                            $this->db->where('unit_id', $user_data->unit_name);
                        }
                        $depts = $this->db->get('emp_depertment')->result();
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Department <span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_dept_id');?>
                                <select name="emp_dept_id" id="emp_dept_id" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <?php foreach ($depts as $key => $row) { ?>
                                    <option value="<?= $row->dept_id ?>"><?= $row->dept_name.' >>'.$row->dept_bangla; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Section <span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_sec_id');?>
                                <select name="emp_sec_id" id="emp_sec_id" class="emp_sec_id form-control input-sm required"
                                    required>
                                    <option value="">-- Select one --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" style="padding-left: 0px !important;">
                            <div class="form-group">
                                <label>Line<span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_line_id');?>
                                <select name="emp_line_id" id="emp_line_id" class="emp_line_id form-control input-sm required"
                                    required>
                                    <option value="">-- Select one --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" style="padding-left: 0px !important;">
                            <div class="form-group">
                                <label>Designation<span style="color: red;">*</span> </label>
                                <?php echo form_error('emp_desi_id');?>
                                <select name="emp_desi_id" id="emp_desi_id" class="emp_desi_id form-control input-sm required">
                                    <!--desig  -->
                                    <option value="">-- Select one --</option>
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                        <div class="form-group">
                            <label>Employee Type <span style="color: red;">*</span> </label>
                            <select name="emp_type" id="emp_type" class="form-control input-sm required" required="">
                                <option value="">-- Select one --</option>
                                <option value="1">Worker</option>
                                <option value="2">Staff</option>
                            </select>
                        </div>
                    </div>
                    </div>

                    <div class="row">
                        <?php //dd($shifts); ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Position <span style="color: red;">*</span> </label>
                                <?php echo form_error('position_id');?>
                                <select name="position_id" id="position_id" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <?php $positions = $this->db->get('pr_emp_position')->result();
                                        foreach ($positions as $key => $value) {
                                            echo '<option value="'.$value->posi_id.'">'.$value->posi_name.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Salary Type <span style="color: red;">*</span> </label>
                                <?php echo form_error('salary_type');?>
                                <select name="salary_type" id="salary_type" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="1" selected>Fixed</option>
                                    <option value="2">Production</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Salary Withdraw <span style="color: red;">*</span> </label>
                                <?php echo form_error('salary_draw');?>
                                <select name="salary_draw" id="salary_draw" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="1">cash</option>
                                    <option value="2">bank</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Lunch <span style="color: red;">*</span> </label>
                                <?php echo form_error('lunch');?>
                                <select name="lunch" id="lunch" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="0">Yes</option>
                                    <option selected value="1">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Transport <span style="color: red;">*</span> </label>
                                <?php echo form_error('transport');?>
                                <select name="transport" id="transport" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="0">Yes</option>
                                    <option selected value="1">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(!in_array(10,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Gross Salary <span style="color: red;">*</span> </label>
                                <?php echo form_error('gross_sal');?>
                                <input type="text" onkeyup="salary_structure_cal()" onchange="salary_structure_cal()" name="gross_sal" id="gross_sal"
                                    class="form-control input-sm required" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Basic Salary </label>
                                <?php echo form_error('basic_sal');?>
                                <input type="text" name="basic_sal" id="basic_sal" disabled
                                    class="form-control input-sm required" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>House </label>
                                <?php echo form_error('house_rent');?>
                                <input type="text" name="house_rent" id="house_rent" disabled
                                    class="form-control input-sm required" required>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Medical </label>
                                <?php echo form_error('medical');?>
                                <input type="text" name="medical" id="medical" disabled class="form-control input-sm required"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Transport </label>
                                <?php echo form_error('trans_allow');?>
                                <input type="text" name="trans_allow" id="trans_allow" disabled
                                    class="form-control input-sm required" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Food </label>
                                <?php echo form_error('food');?>
                                <input type="text" name="food" id="food" disabled class="form-control input-sm required"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label style="white-space: nowrap">Ot Entitle </label>
                            <?php echo form_error('ot_entitle');?>
                            <input type="radio" name="ot_entitle" id="ot_entitle" value="0" class="form-check-input"
                                style="display: inline; margin-right: 10px;" required>Yes
                            <input type="radio" name="ot_entitle" id="ot_entitle" value="1" class="form-check-input"
                                style="display: inline; margin-right: 10px;" required checked>No
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
                                <input type="text" name="basic_sall" id="basic_sall" disabled
                                    class="form-control input-sm required" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>House </label>
                                <?php echo form_error('house_rentt');?>
                                <input type="text" name="house_rentt" id="house_rentt" disabled
                                    class="form-control input-sm required" required>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Medical </label>
                                <?php echo form_error('medicall');?>
                                <input type="text" name="medicall" id="medicall" disabled class="form-control input-sm required"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Transport </label>
                                <?php echo form_error('trans_alloww');?>
                                <input type="text" name="trans_alloww" id="trans_alloww" disabled
                                    class="form-control input-sm required" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Food </label>
                                <?php echo form_error('foodd');?>
                                <input type="text" name="foodd" id="foodd" disabled class="form-control input-sm required"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label style="white-space: nowrap">Ot Entitle </label>
                            <?php echo form_error('ot_entitle');?>
                            <input type="radio" name="com_ot_entitle" id="com_ot_entitle" value="0"
                                class="form-check-input" style="display: inline; margin-right: 10px;" required>Yes
                            <input type="radio" name="com_ot_entitle" id="com_ot_entitle" value="1"
                                class="form-check-input" style="display: inline; margin-right: 10px;" required checked>No
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
function set_desi_item() {
    
    var emp_dob = localStorage.getItem('emp_dob');

    if (emp_dob) {
        // Parse the stored date
        var date = new Date(emp_dob);

        // Set the date in the date picker
        $("#emp_dob").datepicker("setDate", date);
    }
    var emp_dept_id = localStorage.getItem('emp_dept_id');
    var emp_sec_id = localStorage.getItem('emp_sec_id');
    var emp_line_id = localStorage.getItem('emp_line_id');
    var emp_desi_id = localStorage.getItem('emp_desi_id');
    var nomi_district = localStorage.getItem('nomi_district');
    var nomi_thana = localStorage.getItem('nomi_thana');
    var nomi_post = localStorage.getItem('nomi_post');

    
    var ot_entitle = localStorage.getItem('ot_entitle');
    var com_ot_entitle = localStorage.getItem('com_ot_entitle');
    var nid_dob_check = localStorage.getItem('nid_dob_check');

    var gross_sal = localStorage.getItem('gross_sal');
    var com_gross_sal = localStorage.getItem('com_gross_sal');


         setTimeout(function() {
            $('#gross_sal').val(gross_sal).trigger('change');
            setTimeout(function() {
                $('#com_gross_sal').val(com_gross_sal).trigger('change');
            }, 500)
        }, 500)
        
    //alert(new Date(emp_dob));
    var nomi_age = localStorage.getItem('nomi_age');
    var emp_join_date = localStorage.getItem('emp_join_date');
    var ft = localStorage.getItem('ft');
    var inches = localStorage.getItem('inches');
    console.log(ft, inches);


    $('#ft').val(ft).trigger('change');
    $('#inches').val(inches).trigger('change');



    //$("#emp_dob").datepicker("setDate", emp_dob);
    $("#nomi_age").datepicker("setDate", new Date(nomi_age));
    $("#emp_join_date").datepicker("setDate", new Date(emp_join_date));

    $('#nomi_district').val(nomi_district).trigger('change');
    setTimeout(function() {
        $('#nomi_thana').val(nomi_thana).trigger('change');
        setTimeout(function() {
            $('#nomi_post').val(nomi_post).trigger('change');
        }, 500)
    }, 500)

    var pre_district = localStorage.getItem('pre_district');
    var pre_thana = localStorage.getItem('pre_thana');
    var pre_post = localStorage.getItem('pre_post');
    $('#pre_district').val(pre_district).trigger('change');
    setTimeout(function() {
        $('#pre_thana').val(pre_thana).trigger('change');
        setTimeout(function() {
            $('#pre_post').val(pre_post).trigger('change');
        }, 500)
    }, 500)

    var per_district = localStorage.getItem('per_district');
    var per_thana = localStorage.getItem('per_thana');
    var per_post = localStorage.getItem('per_post');

    $('#per_district').val(per_district).trigger('change');
    setTimeout(function() {
        $('#per_thana').val(per_thana).trigger('change');
        setTimeout(function() {
            $('#per_post').val(per_post).trigger('change');
        }, 500)
    }, 500)

    var ref_district = localStorage.getItem('ref_district');
    var ref_thana = localStorage.getItem('ref_thana');
    var ref_post = localStorage.getItem('ref_post');


    $('#ref_district').val(ref_district).trigger('change');
    setTimeout(function() {
        $('#ref_thana').val(ref_thana).trigger('change');
        setTimeout(function() {
            $('#ref_post').val(ref_post).trigger('change');
        }, 500)
    }, 500)

    // Update emp_dept_id and trigger 'change'
    $('#unit_id').trigger('change');
    setTimeout(function() {
        $('#emp_dept_id').val(emp_dept_id).trigger('change');
        // Set a delay of 0.5 seconds before updating emp_sec_id
        setTimeout(function() {
            $('#emp_sec_id').val(emp_sec_id).trigger('change');
            // Set another delay of 0.5 seconds before updating emp_line_id
            setTimeout(function() {
                $('#emp_line_id').val(emp_line_id).trigger('change');
                setTimeout(function() {
                    $('#emp_desi_id').val(emp_desi_id);
                }, 500);
            }, 500);
        }, 500);
    }, 500);
    // Clear all items in localStorage
    var otEntitleElement = document.querySelector('input[name="ot_entitle"][value="'+ot_entitle+'"]');
        if (otEntitleElement) {
            otEntitleElement.checked = true;
        }

        var comOtEntitleElement = document.querySelector('input[name="com_ot_entitle"][value="'+com_ot_entitle+'"]');
        if (comOtEntitleElement) {
            comOtEntitleElement.checked = true;
        }

        var nidDobCheckElement = document.querySelector('input[name="nid_dob_check"][value="'+nid_dob_check+'"]');
        if (nidDobCheckElement) {
            nidDobCheckElement.checked = true;
        }
//localStorage.clear();

}
</script>

<script>
function emp_id_search(id = null) {
    if (id == null) {
        var id = $('#employee_id').val();
    }
    if (id == '') {
        alert('Field can not be empty');
    }
    document.getElementById("form_id").reset();
    $.ajax({
        type: 'POST',
        url: hostname + "emp_info_con/get_employees_info/",
        data: {
            id: id,
        },
        success: function(e) {
            var data = e.data;
            // consol.log(data);return;
            $('#age').html(data.age)
            $('#job_duration').html(data.job_duration)
            if (e.status == false) {
                alert(e.data);
                $("#form_id").trigger("reset");
                $("#employee_id").val("");
                return false;
            }

            if (e.status == true) {
                const keysToFilter = [
                    "id", "emp_id", "name_en", "name_bn",
                    "father_name", "mother_name", "per_village", "per_post",
                    "per_thana", "per_district", "per_village_bn",
                    "pre_home_owner", "holding_num", "home_own_mobile",
                    "pre_village", "pre_post", "pre_thana", "pre_district",
                    "pre_village_bn", "spouse_name", "emp_dob", "gender",
                    "marital_status", "religion", "blood", "m_child", "f_child",
                    "nominee_name", "nominee_vill", "nomi_post", "nomi_thana",
                    "nomi_district", "nomi_age", "nomi_relation", "nomi_mobile",
                    "refer_name", "refer_address", "refer_mobile", "refer_relation",
                    "education", "nid_dob_id", "nid_dob_check", "exp_factory_name",
                    "exp_duration", "exp_designation", "personal_mobile", "exp_dasignation",
                    "bank_bkash_no", "unit_id", "emp_dept_id", "refer_village",
                    "emp_sec_id", "emp_line_id", "emp_desi_id", "emp_sal_gra_id", "emp_type",
                    "emp_cat_id", "proxi_id", "emp_shift", "gross_sal",
                    "com_gross_sal", "ot_entitle", "com_ot_entitle", "transport", "img_source",
                    "lunch", "att_bonus", "salary_draw", "salary_type","position_id", "emp_join_date",
                    "ref_district", "refer_village", "ref_thana", "ref_post","ft","inches","symbol"
                ];
                // Filter the data based on keysToFilter
                var filteredData = {};
                keysToFilter.forEach(function(key) {
                    // console.log(key);
                    if (data[key] !== undefined && data[key] !== null) {
                        if (key == 'emp_dept_id' || key == 'emp_sec_id' || key == 'emp_line_id' ||
                            key == 'emp_desi_id' || key == 'nomi_district' || key == 'nomi_thana' ||
                            key == 'pre_district' || key == 'pre_thana' || key == 'per_district' ||
                            key == 'per_thana' || key == 'per_post' || key == 'pre_post' || key ==
                            'nomi_post' || key == 'ref_thana' || key == 'ref_post' || key ==
                            'ref_district' || key == 'emp_dob' || key == 'nomi_age' || key ==
                            'emp_join_date' || key == 'ft' || key == 'inches' || key == 'ot_entitle' || key == 'com_ot_entitle' || key == 'nid_dob_check' || key == 'com_gross_sal'|| key == 'gross_sal'
                        ) {
                            localStorage.setItem(key, data[key]);
                        } else if (key == 'img_source') {
                            $("#image").attr("src", data[key] != null ?
                                '<?php echo base_url("/uploads/photo/")?>' + data[key] : '');
                            $("#img_source").attr("src", data[key] != null ?
                                '<?php echo base_url("/uploads/photo/")?>' + data[key] : '');
                        } else if (key == 'nid_dob_check' || key == 'ot_entitle' || key ==
                            'com_ot_entitle') {
                            var radioBtn = $('#' + key);
                            if (data[key] != null) {
                                radioBtn.prop('checked', true);
                            } else {
                                radioBtn.prop('checked', false);
                            }
                        } else {
                            console.log(key);
                            $('#' + key).val(data[key] != null ? data[key] : '');
                        }
                    }
                });
            }

            
            set_desi_item();
            get_last_id();
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}
</script>

<script type="text/javascript">
$(document).ready(function() {
    //Designation dropdown
    $('#emp_id').change(function() {
        var emp_id = $('#emp_id').val();
        $("#proxi_id").empty();
        $('#proxi_id').val(emp_id);
    });


    //Designation dropdown
    $('#emp_line_id').change(function() {
        $('.emp_desi_id').addClass('form-control input-sm');
        $(".emp_desi_id > option").remove();
        var id = $('#emp_line_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_designation_by_line_id/" + id,
            success: function(func_data) {
                $('.emp_desi_id').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.emp_desi_id').append(opt);
                    // $(function() {
                    // 	$('#emp_dept_id').val();
                    // });
                });
            }
        });
    });
    $('#emp_sal_gra_id').change(function() {
    // alert($(this).val());
        var grade_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {
                grade_id: grade_id
            },
            url: hostname + "emp_info_con/get_salary_by_grade_id/",
            success: function(func_data) {
              $('#com_gross_sal').val(func_data);
              salary_structure_cal2();
            }
        });
    });

    //Line dropdown
    $('#emp_sec_id').change(function() {
        $('.emp_line_id').addClass('form-control input-sm');
        $(".emp_line_id > option").remove();
        $(".emp_desi_id > option").remove();
        var id = $('#emp_sec_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_line_by_sec_id/" + id,
            success: function(func_data) {
                $('.emp_line_id').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.emp_line_id').append(opt);
                });
            }
        });
    });

    //section dropdown
    $('#emp_dept_id').change(function() {
        $('.emp_sec_id').addClass('form-control input-sm');
        $(".emp_sec_id > option").remove();
        $(".emp_line_id > option").remove();
        var id = $('#emp_dept_id').val();
        var unit_id = $('#unit_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_section_by_dept_id/" + id + '/' + unit_id,
            success: function(func_data) {
                $('.emp_sec_id').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.emp_sec_id').append(opt);
                });
            }
        });
    });
    $('#unit_id').change(function() {
        var id = $('#unit_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_department_by_unit_id/" + id,
            success: function(func_data) {
                $('#emp_dept_id').empty();
                $('#emp_dept_id').append(
                    "<option value=''>-- Select Department --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('#emp_dept_id').append(opt);
                });
            }
        });
    });

    //nominee Upazila dropdown
    $('#nomi_district').change(function() {
        $('.nomi_thana').addClass('form-control input-sm');
        $(".nomi_thana > option").remove();
        $(".nomi_post > option").remove();
        var id = $('#nomi_district').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_upazila_by_dis/" + id,
            success: function(func_data) {
                $('.nomi_thana').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.nomi_thana').append(opt);
                });
            }
        });
    });

    //nominee post office dropdown
    $('#nomi_thana').change(function() {
        $('.nomi_post').addClass('form-control input-sm');
        $(".nomi_post > option").remove();
        var id = $('#nomi_thana').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_post_office_by_upa_id/" + id,
            success: function(func_data) {
                $('.nomi_post').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.nomi_post').append(opt);
                });
            }
        });
    });


    //Refer Upazila dropdown
    $('#ref_district').change(function() {
        $('.ref_thana').addClass('form-control input-sm');
        $(".ref_thana > option").remove();
        $(".ref_post > option").remove();
        var id = $('#ref_district').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_upazila_by_dis/" + id,
            success: function(func_data) {
                $('.ref_thana').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.ref_thana').append(opt);
                });
            }
        });
    });

    //Refer post office dropdown
    $('#ref_thana').change(function() {
        $('.ref_post').addClass('form-control input-sm');
        $(".ref_post > option").remove();
        var id = $('#ref_thana').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_post_office_by_upa_id/" + id,
            success: function(func_data) {
                $('.ref_post').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.ref_post').append(opt);
                });
            }
        });
    });


    //Upazila dropdown
    $('#pre_district').change(function() {
        $('.pre_thana').addClass('form-control input-sm');
        $(".pre_thana > option").remove();
        $(".pre_post > option").remove();
        var id = $('#pre_district').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_upazila_by_dis/" + id,
            success: function(func_data) {
                $('.pre_thana').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.pre_thana').append(opt);
                });
            }
        });
    });

    //Post Office dropdown
    $('#pre_thana').change(function() {
        $('.pre_post').addClass('form-control input-sm');
        $(".pre_post > option").remove();
        var id = $('#pre_thana').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_post_office_by_upa_id/" + id,
            success: function(upazilaThanas) {
                $('.pre_post').append("<option value=''>-- Select Upazila --</option>");
                $.each(upazilaThanas, function(id, ut_name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(ut_name);
                    $('.pre_post').append(opt);
                });
            }
        });
    });

    //Upazila dropdown
    $('#per_district').change(function() {
        $('.per_thana').addClass('form-control input-sm');
        $(".per_thana > option").remove();
        $(".per_post > option").remove();
        var id = $('#per_district').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_upazila_by_dis/" + id,
            success: function(func_data) {
                $('.per_thana').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.per_thana').append(opt);
                });
            }
        });
    });

    //Post Office dropdown
    $('#per_thana').change(function() {
        $('.per_post').addClass('form-control input-sm');
        $(".per_post > option").remove();
        var id = $('#per_thana').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_post_office_by_upa_id/" + id,
            success: function(upazilaThanas) {
                $('.per_post').append("<option value=''>-- Select Upazila --</option>");
                $.each(upazilaThanas, function(id, ut_name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(ut_name);
                    $('.per_post').append(opt);
                });
            }
        });
    });
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
get_last_id()

</script>
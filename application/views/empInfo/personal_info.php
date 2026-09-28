<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
    .bangla_name, .bangla_village {
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
                action="<?php echo base_url('emp_info_con/personal_info_add')?>">
                <h3 style="font-weight: bold; width:fit-content"><?= $title ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-center" style="font-size:18px !important" id='last_emp_id'></span></h3>

                <hr style="margin-bottom: 0px !important;">
                <div style="background-color: white; padding: 15px !important;">
                    <div class="row">
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Emp Id <span style="color: red;">*</span> </label>
                                <input type="text" name="emp_id" id="emp_id" class="form-control input-sm required"
                                    value="<?= isset($emp_info->emp_id)?>" onkeypress="if (this.value.length > 6) return false;" required>
                                <?php echo form_error('emp_id');?>
                            </div>
                        </div>
                        <div class="col-md-3">
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
                                <label>Name (Bangla) <span style="color: red;">*</span> </label>
                                <input style="" type="text" name="name_bn" id="name_bn" class="form-control input-sm bangla_name required" value="<?= isset($emp_info->name_bn)?>" required>
                                <?php echo form_error('name_bn');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Father's Name (Bangla) <span style="color: red;">*</span> </label>
                                <input  style="font-family: SutonnyMJ;" type="text" name="father_name" id="father_name"
                                    class="form-control input-sm bangla_name unicode-to-bijoy required"
                                    value="<?= isset($emp_info->father_name)?>" required>
                                <?php echo form_error('father_name');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Mother's Name (Bangla) <span style="color: red;">*</span> </label>
                                <input type="text" name="mother_name" id="mother_name"
                                    class="form-control input-sm bangla_name required"
                                    value="<?= isset($emp_info->mother_name)?>" required>
                                <?php echo form_error('mother_name');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Spouse Name (Bangla) </label>
                                <input type="text" name="spouse_name" id="spouse_name"
                                    class="form-control input-sm bangla_name "
                                    value="<?= isset($emp_info->spouse_name)?>">
                                <?php echo form_error('spouse_name');?>
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
                                <label>Marital Status <span style="color: red;">*</span> </label>
                                <?php echo form_error('marital_status');?>
                                <select name="marital_status" id="marital_status" class="form-control input-sm required"
                                    required>
                                    <option value="">select</option>
                                    <option value="Unmarried">Unmarried</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Religion<span style="color: red;">*</span> </label>
                                <?php echo form_error('religion');?>
                                <select name="religion" id="religion" class="form-control input-sm required" required>
                                    <option value="">select</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Buddhish">Buddhish</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Blood Group<span style="color: red;">*</span> </label>
                                <?php echo form_error('blood');?>
                                <select name="blood" id="blood" class="form-control input-sm required" required>

                                    <option value="">select</option>
                                    <option value="None">None</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Male Child </label>
                                <input type="text" name="m_child" id="m_child" class="form-control input-sm required">
                                <?php echo form_error('m_child');?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Female Child </label>
                                <input type="text" name="f_child" id="f_child" class="form-control input-sm required">
                                <?php echo form_error('f_child');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Education </label>
                                <input type="text" name="education" id="education" class="form-control input-sm">
                                <!-- < ?php echo form_error('education');?>
                                 <Select name="education" id="education" class="form-control input-sm required">
                                    <option value="">select</option>
                                    <option value="None">None</option>
                                    <option value="One">One</option>
                                    <option value="Two">Two</option>
                                    <option value="Three">Three</option>
                                    <option value="Four">Four</option>
                                    <option value="Five">Five</option>
                                    <option value="PSC">PSC</option>
                                    <option value="Seven">Seven</option>
                                    <option value="JSC">JSC</option>
                                    <option value="Nine">Nine</option>
                                    <option value="Ten">Ten</option>
                                    <option value="SSC">SSC</option>
                                    <option value="HSC">HSC</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Graduation">Graduation</option>
                                    <option value="Post Graduation">Post Graduation</option>
                                    <option value="Other">Other</option>
                                </Select> -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Identification Id<span style="color: red;">*</span> </label>
                                <input type="text" name="nid_dob_id" id="nid_dob_id" class="form-control input-sm required"
                                    required>
                                <?php echo form_error('nid_dob_id');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Identification Type<span style="color: red;">*</span> </label>
                                <?php echo form_error('nid_dob_check');?>
                                <input class="form-check-input" type="radio" value="1" id="nid_dob_check"
                                    name="nid_dob_check"> NID
                                <input class="form-check-input" type="radio" value="2" id="nid_dob_check"
                                    name="nid_dob_check"> DOB
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
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Hight <span style="color: red;">*</span> </label>
                                <!-- <input type="hidden" name="ft" id="ft"> -->
                                <!-- <input type="hidden" name="inches" id="inches"> -->
                                <input  class="form-control input-sm" name="hight" id="hight" class="col-md-5" type="text" onkeypress="return isValidInput(event)" oninput="validateHeightInput(this)">

                            <script>
                                function isValidInput(event) {
                                    // Allow only digits and dot (.)
                                    const charCode = event.charCode;
                                    return (charCode >= 48 && charCode <= 57) || charCode === 46;
                                }

                                function validateHeightInput(input) {
                                    // Allow only up to 3 digits before dot and 2 digits after dot
                                    const regex = /^(\d{0,3})(\.\d{0,2})?$/;
                                    if (!regex.test(input.value)) {
                                        // Trim the value to fit the format
                                        const match = input.value.match(/^(\d{0,3})(\.\d{0,2})?/);
                                        input.value = match ? match[0] : '';
                                    }
                                }

                            </script>

                                <!-- <input class="form-control input-sm" name="hight" id="hight" class="col-md-5" type="text"> -->
                                    <!-- <option value="">select</option>
                                    <?php for ($i = 99; $i <= 220; $i++ ) { ?>
                                        <option value="<?= $i; ?>"><?= $i; ?> cm </option>
                                    <?php } ?>
                                </select> -->
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Symbol<span style="color: red;">*</span> </label>
                                <textarea name="symbol" id="symbol" style="width: 100%; height: 27px;"></textarea>
                                <?php echo form_error('symbol');?>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 style="font-weight: 600;">Present Address</h3>
                <hr style="margin-bottom: 0px !important;">
                <div style="background-color: white; padding: 15px !important;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Home Owner Name <span style="color: red;">*</span> </label>
                                <input type="text" name="pre_home_owner" id="pre_home_owner"
                                    class="form-control input-sm bangla_name required" required>
                                <?php echo form_error('pre_home_owner');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Holding Name<span style="color: red;">*</span> </label>
                                <input type="text" name="holding_num" id="holding_num" class="form-control input-sm required"
                                    required>
                                <?php echo form_error('holding_num');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Home Owner Mobile<span style="color: red;">*</span> </label>
                                <input type="text" name="home_own_mobile" id="home_own_mobile"
                                    class="form-control input-sm required" required>
                                <?php echo form_error('home_own_mobile');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village Name (English)<span style="color: red;">*</span> </label>
                                <input type="text" name="pre_village" id="pre_village"
                                    class="form-control input-sm english_village required" required>
                                <?php echo form_error('pre_village');?>
                            </div>
                        </div>
                    </div>

                    <?php $districts = $this->db->get('emp_districts')->result(); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village Name (Bangla) <span style="color: red;">*</span> </label>
                                <input type="text" name="pre_village_bn" id="pre_village_bn"
                                    class="form-control input-sm bangla_village required" required>
                                <?php echo form_error('pre_village_bn');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>District<span style="color: red;">*</span> </label>
                                <?php echo form_error('pre_district');?>
                                <select name="pre_district" id="pre_district" class="form-control input-sm required" required>
                                    <option value="">-- Select District --</option>
                                    <?php foreach ($districts as $key => $row) { ?>
                                    <option value="<?= $row->id ?>"><?= $row->name_en.' >>'.$row->name_bn; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Upazila/Thana<span style="color: red;">*</span> </label>
                                <?php echo form_error('pre_thana');?>
                                <select name="pre_thana" id="pre_thana" class="pre_thana form-control input-sm required"
                                    required>
                                    <option value="">-- Select District --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Post Office<span style="color: red;">*</span> </label>
                                <?php echo form_error('pre_post');?>
                                <select name="pre_post" id="pre_post" class="pre_post form-control input-sm required" required>
                                <option value="">-- Select District --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 style="font-weight: 600;">Permanent Address</h3>
                <hr style="margin-bottom: 0px !important;">
                <div style="background-color: white; padding: 15px !important;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village Name (English) <span style="color: red;">*</span> </label>
                                <input type="text" name="per_village" id="per_village"
                                    class="form-control input-sm english_village required" required>
                                <?php echo form_error('per_village');?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village Name (Bangla) <span style="color: red;">*</span> </label>
                                <input type="text" name="per_village_bn" id="per_village_bn"
                                    class="form-control input-sm bangla_village required" required>
                                <?php echo form_error('per_village_bn');?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>District<span style="color: red;">*</span> </label>
                                <?php echo form_error('per_district');?>
                                <select name="per_district" id="per_district" class="form-control input-sm required" required>
                                <option value="">-- Select one --</option>
                                    <?php foreach ($districts as $key => $row) { ?>
                                    <option value="<?= $row->id ?>"><?= $row->name_en.' >>'.$row->name_bn; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-left: 0px !important;">
                            <div class="form-group">
                                <label>Upazila/Thana<span style="color: red;">*</span> </label>
                                <?php echo form_error('per_thana');?>
                                <select name="per_thana" id="per_thana" class="per_thana form-control input-sm required"
                                    required>
                                    <option value='' >-- Select District --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-left: 0px !important;">
                            <div class="form-group">
                                <label>Post Office<span style="color: red;">*</span> </label>
                                <?php echo form_error('per_post');?>
                                <select name="per_post" id="per_post" class="per_post form-control input-sm required" required>
                                <option value="">-- Select one --</option>
                                </select>
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
                                <label>Salary Type <span style="color: red;">*</span> </label>
                                <?php echo form_error('salary_type');?>
                                <select name="salary_type" id="salary_type" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <option value="1" selected>Fixed</option>
                                    <option value="2">Production</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
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

                        <div class="col-md-3">
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
                        <div class="col-md-3">
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

                    <div class="row"  <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(!in_array(10,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>
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

                <h3 style="font-weight: 600;">Nominee Information</h3>
                <hr style="margin-bottom: 0px !important;">
                <div style="background-color: white; padding: 15px !important;">
                    <?php $nominees = $this->db->get('emp_nomini_relation')->result(); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nominee Name <span style="color: red;">*</span> </label>
                                <?php echo form_error('nominee_name');?>
                                <input type="text" name="nominee_name" id="nominee_name"
                                    class="form-control input-sm bangla_name required" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Village Name <span style="color: red;">*</span> </label>
                                <?php echo form_error('nominee_vill');?>
                                <input type="text" name="nominee_vill" id="nominee_vill"
                                    class="form-control input-sm english_village required" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>District<span style="color: red;">*</span> </label>
                                <?php echo form_error('nomi_district');?>
                                <select name="nomi_district" id="nomi_district" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    <?php foreach ($districts as $key => $row) { ?>
                                    <option value="<?= $row->id ?>"><?= $row->name_en.' >>'.$row->name_bn; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Upazila/Thana<span style="color: red;">*</span> </label>
                                <?php echo form_error('nomi_thana');?>
                                <select name="nomi_thana" id="nomi_thana" class="nomi_thana form-control input-sm required"
                                    required>
                                    <option value="">-- Select one --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Post Office<span style="color: red;">*</span> </label>
                                <?php echo form_error('nomi_post');?>
                                <select name="nomi_post" id="nomi_post" class="nomi_post form-control input-sm required"
                                    required>
                                    <option value="">-- Select one --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nominee DOB <span style="color: red;">*</span> </label>
                                <?php echo form_error('nomi_age');?>
                                <input type="text" name="nomi_age" id="nomi_age" class="date form-control input-sm required"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nominee Mobile <span style="color: red;">*</span> </label>
                                <?php echo form_error('nomi_mobile');?>
                                <input type="text" name="nomi_mobile" id="nomi_mobile" class="form-control input-sm required"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Relation<span style="color: red;">*</span> </label>
                                <?php echo form_error('nomi_relation');?>
                                 <input type="text" name="nomi_relation" id="nomi_relation" value="<?= isset($emp_info->nomi_relation)?>" class="form-control input-sm required"
                                    required>
                                <!-- <select name="nomi_relation" id="nomi_relation" class="form-control input-sm required" required>
                                    <option value="">-- Select one --</option>
                                    < ?php foreach ($nominees as $key => $row) { ?>
                                    <option value="<?= $row->id ?>"><?= $row->nomini_relation; ?></option>
                                    < ?php } ?>
                                </select> -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Identification Type<span style="color: red;">*</span> </label>
                                <?php echo form_error('nomi_nid_bc_check');?>
                                <input class="form-check-input" type="radio" value="1" id="nomi_nid_bc_check"
                                    name="nomi_nid_bc_check"> NID
                                <input class="form-check-input" type="radio" value="2" id="nomi_nid_bc_check"
                                    name="nomi_nid_bc_check"> DOB
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nominee NID/Birth Certificate <span style="color: red;">*</span> </label>
                                <?php echo form_error('nomi_nid');?>
                                <input type="text" name="nomi_nid" id="nomi_nid" class="form-control input-sm required"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 style="font-weight: 600;">Reference/Guardian</h3>
                <hr style="margin-bottom: 0px !important;">
                <div style="background-color: white; padding: 15px !important;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name <span style="color: red;">*</span> </label>
                                <?php echo form_error('refer_name');?>
                                <input type="text" name="refer_name" id="refer_name"
                                    value="<?= isset($emp_info->refer_name)?>" class="form-control input-sm bangla_name required"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Mobile Number<span style="color: red;">*</span> </label>
                                <?php echo form_error('refer_mobile');?>
                                <input type="text" name="refer_mobile" id="refer_mobile"
                                    value="<?= isset($emp_info->refer_mobile)?>" class="form-control input-sm required" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Rrelation<span style="color: red;">*</span> </label>
                                <?php echo form_error('refer_relation');?>
                                <input type="text" name="refer_relation" id="refer_relation" value="<?= isset($emp_info->refer_relation)?>" class="form-control input-sm required" required>
                                <!-- <select name="refer_relation" id="refer_relation" class="form-control input-sm required"
                                    required>
                                    <option value='' >-- Select --</option>
                                    < ?php foreach ($nominees as $key => $row) { ?>
                                    <option value="< ?= $row->id ?>"><?= $row->nomini_relation; ?></option>
                                    < ?php } ?>
                                </select> -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Village <span style="color: red;">*</span> </label>
                                <?php echo form_error('refer_village');?>
                                <input type="text" name="refer_village" id="refer_village"
                                    value="<?= isset($emp_info->refer_village)?>"
                                    class="form-control input-sm english_village required" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>District <span style="color: red;">*</span> </label>
                                <?php echo form_error('ref_district');?>
                                <select name="ref_district" id="ref_district" class="form-control input-sm required" required>
                                    <option value='' >-- Select --</option>
                                    <?php foreach ($districts as $key => $row) { ?>
                                    <option value="<?= $row->id ?>"><?= $row->name_en.' >>'.$row->name_bn; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Thana/Upazila<span style="color: red;">*</span> </label>
                                <?php echo form_error('ref_thana');?>
                                <select name="ref_thana" id="ref_thana" class="ref_thana form-control input-sm required"
                                    required>
                                    <option value='' >-- Select --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Post Office<span style="color: red;">*</span> </label>
                                <?php echo form_error('ref_post');?>
                                <select name="ref_post" id="ref_post" class="ref_post form-control input-sm required" required>
                                    <option value='' >-- Select --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 style="font-weight: 600;">Experience And Photo</h3>
                <hr style="margin-bottom: 0px !important;">
                <div style="background-color: white; padding: 15px !important;">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exp. Factory Name </label>
                                    <?php echo form_error('exp_factory_name');?>
                                    <input type="text" name="exp_factory_name" id="exp_factory_name"
                                        class="form-control input-sm" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exp, Duration </label>
                                    <?php echo form_error('exp_duration');?>
                                    <input type="text" name="exp_duration" value="<?= isset($emp_info->exp_duration)?>"
                                        id="exp_duration" class="form-control input-sm" >
                                </div>
                            </div>

                            <?php $desig = $this->db->get('emp_designation')->result(); ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Designation </label>
                                    <?php echo form_error('exp_dasignation');?>
                                    <input name="exp_dasignation" type="text" id="exp_dasignation"
                                        class="form-control input-sm" value="<?= isset($emp_info->exp_dasignation) ?>"
                                        >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Image </label>
                                    <?php echo form_error('img_source');?>
                                    <input type="file" name="img_source" id="img_source" class="form-control input-sm"
                                        style="height: 35px !important; line-height: 20px !important;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Signature </label>
                                    <?php echo form_error('signature');?>
                                    <input type="file" name="signature" id="signature" class="form-control input-sm"
                                        style="height: 35px !important; line-height: 20px !important;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="col-12">
                                <label>Employee Photo</label>
                                <img id="image" style="max-width: 59%;" src="" alt="image">
                            </div>
                        </div>
                        <div class="col-md-2">
                        <div class="col-12">
                                <label>Age</label>
                                <span id="age" style="border: 1px solid #8b8b8b;padding: 2px 16px;width: fit-content;display: block;">-</span>
                            </div>
                            <div class="col-12">
                                <label>Job Duration</label>
                                <span id="job_duration" style="border: 1px solid #8b8b8b;padding: 2px 16px;width: fit-content;display: block;">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group pull-right">
                            <a href="" class="btn-warning btn">Cancel</a>

                            <input type="hidden" name="submit_type" id="submit_type">

                            <button onclick="checkAndBlockSubmit('edit',event)" class="btn btn-success">EDIT</button>
                            <button onclick="checkAndBlockSubmit('save',event)" class="btn btn-primary">SAVE</button>

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
    var nomi_nid_bc_check = localStorage.getItem('nomi_nid_bc_check');

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
    // var ft = localStorage.getItem('ft');
    // var inches = localStorage.getItem('inches');
    // console.log(ft, inches);


    // $('#ft').val(ft).trigger('change');
    // $('#inches').val(inches).trigger('change');



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

    var hight = localStorage.getItem('hight');
    $('#hight').val(hight).trigger('change');



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
        var nomiNidBcCheckElement = document.querySelector('input[name="nomi_nid_bc_check"][value="'+nomi_nid_bc_check+'"]');
        if (nomiNidBcCheckElement) {
            nomiNidBcCheckElement.checked = true;
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
                    "nomi_district", "nomi_age","nomi_nid", "nomi_relation", "nomi_mobile",
                    "refer_name", "refer_address", "refer_mobile", "refer_relation",
                    "education", "nid_dob_id", "nid_dob_check","nomi_nid_bc_check", "exp_factory_name",
                    "exp_duration", "exp_designation", "personal_mobile", "exp_dasignation",
                    "bank_bkash_no", "unit_id", "emp_dept_id", "refer_village",
                    "emp_sec_id", "emp_line_id", "emp_desi_id", "emp_sal_gra_id", "emp_type",
                    "emp_cat_id", "proxi_id", "emp_shift", "gross_sal",
                    "com_gross_sal", "ot_entitle", "com_ot_entitle", "transport", "img_source",
                    "lunch", "att_bonus", "salary_draw", "salary_type", "emp_join_date",
                    "ref_district", "refer_village", "ref_thana", "ref_post","hight","symbol"
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
                            'emp_join_date' || key == 'hight' || key == 'ot_entitle' || key == 'com_ot_entitle' ||key == 'nomi_nid_bc_check'|| key == 'nid_dob_check' || key == 'com_gross_sal'|| key == 'gross_sal'
                        ) {
                            localStorage.setItem(key, data[key]);
                        } else if (key == 'img_source') {
                            $("#image").attr("src", data[key] != null ?
                                '<?php echo base_url("/uploads/photo/")?>' + data[key] : '');
                            $("#img_source").attr("src", data[key] != null ?
                                '<?php echo base_url("/uploads/photo/")?>' + data[key] : '');
                        } else if (key == 'nid_dob_check' || key == 'nomi_nid_bc_check'  || key == 'ot_entitle' || key ==
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
function changeFontBn() {
    setTimeout(() => {
        $('.ui-menu-item-wrapper').css('font-family', 'SutonnyMJ');
    }, 500);
}
</script>
<script>
function checkAndBlockSubmit(type, e) {
    e.preventDefault();


    console.log($('#per_district').val())
    $('#submit_type').val(type);
    if (type == 'edit') {
        var flag = true;
         $('#form_id').find(".required").each(function() {
            $(this).siblings('.help-block').remove();
            $(this).parent().removeClass('has-error');
            if ($(this).val() == '' || $(this).val() == null) {
                flag = false;
                $(this).parent().append('<span class="help-block">This field is required</span>');
                $(this).parent().addClass('has-error');
            } else {
                $(this).siblings('.help-block').remove();
                $(this).parent().removeClass('has-error');
            }
        });
        if (flag) {
            $('#form_id').submit();
        }
    } else {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('emp_info_con/checkAndBlockSubmit'); ?>",
            data: {
                id: $('#emp_id').val()
            },
            success: function(data) {
                if (data == 'true') {
                    var flag = true;
                    $('#form_id').find(".required").each(function() {
                        $(this).siblings('.help-block').remove();
                        $(this).parent().removeClass('has-error');
                        if ($(this).val() == '' || $(this).val() == null) {
                            flag = false;
                            $(this).parent().append(
                                '<span class="help-block">This field is required</span>');
                            $(this).parent().addClass('has-error');
                        } else {
                            $(this).siblings('.help-block').remove();
                            $(this).parent().removeClass('has-error');
                        }
                    });
                    if (flag) {
                        $('#form_id').submit();
                    }
                } else {
                    alert('Employee ID Already Exist');
                    return false;
                }
            }
        })

    }


}
</script>

<script>
$('#marital_status').change(function(){
    status = $('#marital_status').val();
    if(status == 'Unmarried'){
        $('#m_child').val(0);
        $('#f_child').val(0);
    }else{
         $('#m_child').val('');
         $('#f_child').val('');
    }
});
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

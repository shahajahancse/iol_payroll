
    <style>
        .sbtn {
            background: #0c74bfeb !important; /*2393e3eb*/
            color: white;
            padding: 6px 10px !important;
        }
        .tab-content > .tab-pane, .pill-content > .pill-pane {
            padding: 15px 1px !important;
        }
        .form-group {
            margin-bottom: 10px !important;
        }

        .h3 {
            margin: 5px !important;
            line-height: 20px !important;
        }
        .fade.in {
            display: flex !important;
            flex-wrap: wrap;
            gap: 4px;
        }
    </style>

    <?php
        $this->load->model('common_model');
        $unit = $this->common_model->get_unit_id_name();
        $user_id = $this->session->userdata('data')->id;
        $acl = check_acl_list($user_id);
    ?>
    <div class="content">
        <!-- Left side for report section -->
        <div class="col-md-8">
            <!-- selection area -->
            <div class="row tablebox" style="margin-bottom: 10px;">
                <div class="row" style="justify-content: center!important; display: flex; flex-wrap: wrap;">
                    <div class="col-md-5">
                        <div class="form-group">
                            <h4 class="control-label" style="font-weight: bold;">Select Salary Month </h4>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="month" onChange="grid_emp_list()" class="form-control" id="salary_month" value="<?= date('Y-m') ?>">
                        </div>
                    </div>
                </div>
                <div class="row" style="justify-content: center!important; display: flex; flex-wrap: wrap;">
                    <div class="col-md-5">
                        <div class="form-group">
                            <h4 class="control-label" style="font-weight: bold;">Select Second Month </h4>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="month" class="form-control" id="secondary_month" value="<?= date('Y-m') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row tablebox" style="display: block; margin-bottom: 10px;">
                <h3 class="h3" style="font-weight: 600;">Select Category</h3>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Unit <span style="color: red;">*</span> </label>
                        <select name="unit_id" id="unit_id" class="form-control input-sm">
                            <option value="">Select Unit</option>
                            <?php
                                foreach ($dept as $row) {
                                    if($row['unit_id'] == $user_data->unit_name){
                                        $select_data="selected";
                                    }else{
                                        if ($user_data->level != "All") {
                                            continue;
                                        }
                                    }
                                    echo '<option '.$select_data.'  value="'.$row['unit_id'].'">'.$row['unit_name'].
                                    '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- department -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Department </label>
                        <select class="form-control input-sm dept" id='dept' name='dept'>
                            <?php if (!empty($user_data->unit_name)) {
                                $dpts = $this->db->where('unit_id', $user_data->unit_name)->get('emp_depertment'); ?>
                            <option value=''>Select Department</option>
                            <?php foreach ($dpts->result() as $key => $val) { ?>
                            <option value='<?= $val->dept_id ?>'><?= $val->dept_name ?></option>
                            <?php } } ?>
                            <option value=''>Select Department</option>
                        </select>
                    </div>
                </div>
                <!-- section -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Section </label>
                        <select class="form-control input-sm section" id='section' name='section'>
                            <option value=''></option>
                        </select>
                    </div>
                </div>
                <!-- line -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Line </label>
                        <select class="form-control input-sm line" id='line' name='line'>
                            <option value=''></option>
                        </select>
                    </div>
                </div>
                <!-- Designation -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Designation</label>
                        <select class="form-control input-sm desig" id='desig' name='desig' onChange="grid_emp_list()">
                            <option value=''></option>
                        </select>
                    </div>
                </div>
                <!-- status -->
                <div class="col-md-3">
                    <?php $categorys = $this->db->get('emp_category_status')->result(); ?>
                    <div class="form-group">
                        <label class="control-label">Status </label>
                        <select name="status" id="status" class="form-control input-sm" onChange="grid_emp_list()">
                            <option selected value="">All Employee</option>
                            <?php foreach ($categorys as $key => $row) { ?>
                                <?php if ($row->id != 5) { ?>
                                    <option value="<?= $row->id ?>"><?= $row->status_type; ?>
                                <?php } ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Salary </label>
                        <select name="stop_salary" id="stop_salary" class="form-control input-sm" onChange="grid_emp_list()">
                            <option value="1">Running</option>
                            <option value="2">Stop</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- selection area -->

            <div id='loaader' style="display: none;align-items: center;justify-content: center;z-index: 33333;background: #e9e9e966;position: absolute;" class="col-md-12">
				<img  src="<?php echo base_url('loader.gif')?>" alt="loader">
			</div>

            <!-- Report are -->
            <div class="row tablebox" style="margin-bottom: 15px;">
                <div class='multitab-section'>
                    <ul class="nav nav-tabs" id="myTabs">
                        <li class="active"><a href="#daily" data-toggle="tab">Salary Reports</a></li>
                        <li><a href="#earn_leave" data-toggle="tab"> Earn Leave Reports</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- salary report  -->
                        <div class="tab-pane fade in active" id="daily">
                            <?php if(in_array(180,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="salary_sheet_com()">Salary Sheet</button>
                            <?php } ?>
                            <?php if(in_array(181,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="pay_slip_com()">Pay Slip</button>
                            <?php } ?>
                            <?php if(in_array(182,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="salary_summary_com()">Salary Summary</button>
                            <?php } ?>
                            <?php if(in_array(183,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="sec_sal_summary_com()">Sec Wise Salary Summary</button>
                            <?php } ?>

                            <?php if(in_array(184,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="actual_salary_sheet()">Actual Salary Sheet</button>
                            <?php } ?>
                            <?php if(in_array(185,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="actual_pay_slip()">Actual Pay Slip </button>
                            <?php } ?>
                            <?php if(in_array(186,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="actual_salary_summary()">Actual Salary Summary</button>
                            <?php } ?>
                            <?php if(in_array(187,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="actual_sec_sal_summary()">Actual Sec Salary Summary</button>
                            <?php } ?>

                            <?php if(in_array(188,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="actual_salary_sheet_bank()">Actual Salary Bank</button>
                            <?php } ?>
                            <?php if(in_array(189,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="actual_eot_sheet()">Actual EOT Sheet</button>
                            <?php } ?>
                            <?php if(in_array(190,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="actual_eot_summary()">Actual EOT Summary</button>
                            <?php } ?>
                            <?php if(in_array(191,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="actual_eot_sheet_bank()">Actual EOT Bank</button>
                            <?php } ?>

                            <?php if(in_array(192,$acl)) { ?>
                                <button class="btn input-sm sbtn" onclick="eot_sheet_com_9()">EOT Sheet.</button>
                            <?php } ?>
                            <?php if(in_array(193,$acl)) { ?>
                                <button class="btn input-sm sbtn" onclick="eot_sheet_com_12()">EOT Sheet`</button>
                            <?php } ?>
                            <?php if(in_array(194,$acl)) { ?>
                                <button class="btn input-sm sbtn" onclick="eot_sheet_com_all()">EOT Sheet!</button>
                            <?php } ?>
                            <?php if(in_array(195,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="grid_monthly_stop_sheet()">Stop Salary Sheet</button>
                            <?php } ?>
                            <?php if(in_array(196,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="grid_salary_sheet_with_eot_bank()">Mobile Banking Report</button>
                            <?php } ?>
                            <?php if(in_array(197,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="grid_monthly_allowance_sheet()">Monthly Night Bill Report</button>
                            <?php } ?>
                            <?php if(in_array(198,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="grid_salary_sheet_with_eot_bank()">Monthly Weekend/Holiday Report</button>
                            <?php } ?>
                        </div>
                        <!-- salary report end  -->

                        <div class="tab-pane fade" id="earn_leave">
                            <?php if(in_array(199,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="grid_earn_leave_payment_buyer()">Earn Leave Payment Sheet</button>
                            <?php } ?>
                            <?php if(in_array(200,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="grid_earn_leave_general_info()">Actual Earn Leave Payment Sheet</button>
                            <?php } ?>
                            <?php if(in_array(201,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="grid_earn_leave_summery()">Earn Leave Summery Sheet</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Report are end -->
        </div>
        <!-- Left side end -->

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

    <script src="<?php echo base_url(); ?>js/earn_leave.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
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
            var unit = document.getElementById('unit_id').value;
            var dept = document.getElementById('dept').value;
            var section = document.getElementById('section').value;
            var line = document.getElementById('line').value;
            var desig = document.getElementById('desig').value;
            var status = document.getElementById('status').value;
            var stop_salary = document.getElementById('stop_salary').value;
            var salary_month = document.getElementById('salary_month').value;

            var searchi = document.getElementById('searchi').value;

            if (typeof unit === "undefined" || unit === '') {
                 alert('Please Select Unit First'); return;
            }
            
            url = hostname + "common/salary_emp_list/";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "unit"        : unit,
                    "dept"        : dept,
                    "section"     : section,
                    "line"        : line,
                    "desig"       : desig,
                    "status"      : status,
                    "stop_salary" : stop_salary,
                    "salary_month": salary_month,
                    "searchi"     : searchi
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
                        $('.desig').append("<option value=''>-- Select District --</option>");
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
                        $('.line').append("<option value=''>-- Select District --</option>");
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
                        $('.section').append("<option value=''>-- Select District --</option>");
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

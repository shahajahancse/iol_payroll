<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
<style>
    #fileDiv #removeTr td {
        padding: 5px 10px !important;
        font-size: 14px;
    }
    .sbtn {
        background: #0c74bfeb !important;
        color: white;
        padding: 6px 10px !important;
    }
</style>
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

<?php
    $this->load->model('common_model');
    $unit = $this->common_model->get_unit_id_name();

    $user_id = $this->session->userdata('data')->id;
    $acl = check_acl_list($user_id);
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
        </div>

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
                                $select_data = '';
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

        <style>
            .tab-pane  {
                display: flex !important;
                flex-wrap: wrap !important;;
                gap: 5px !important;
            }
        </style>
        <!-- Report are -->
        <div class="row tablebox" style="margin-bottom: 15px;">
            <div class='multitab-section'>
                <ul class="nav nav-tabs" id="myTabs">
                    <li class="active"><a href="#daily" data-toggle="tab">Advanced Salary And Festival</a></li>
                </ul>
                <div class="tab-content">
                    <!-- salary report  -->
                    <div class="tab-pane fade in active" id="daily">
                        <?php if(in_array(206,$acl)) { ?>
                        <button class="btn input-sm sbtn" onclick="grid_festival_bonus()">Festival Bonus</button>
                        <?php } ?>
                        <?php if(in_array(207,$acl)) { ?>
                        <button class="btn input-sm sbtn" onclick="grid_festival_bonus_summary()">Festival Bonus Summary</button>
                        <?php } ?>
                        <?php if(in_array(208,$acl)) { ?>
                        <button class="btn input-sm sbtn" onclick="grid_festival_bonus_summary_sec_wise()">Festival Bonus Summary(Sec)</button>
                        <?php } ?>
                        <?php if(in_array(209,$acl)) { ?>
                        <button class="btn input-sm sbtn" onclick="advance_salary_report()">Advance Salary Sheet</button>
                        <?php } ?>
                        <?php if(in_array(210,$acl)) { ?>
                        <button class="btn input-sm sbtn" onclick="act_advance_salary_sheet()">Act. Adv. Sal. Sheet</button>
                        <?php } ?>
                        <?php if(in_array(211,$acl)) { ?>
                        <!-- <button class="btn input-sm sbtn" onclick="grid_comprative_salary_statement()">Comparative Statement</button> -->
                        <?php } ?>
                    </div>
                    <!-- Others Benefit Report end -->
                </div>
            </div>
        </div>
        <!-- Report are end -->

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
    function advance_salary_report(){
        var ajaxRequest;  // The variable that makes Ajax possible!
        try{
            ajaxRequest = new XMLHttpRequest();
        }catch (e){
            try{
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            }catch (e) {
                try{
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                }catch (e){
                    alert("Your browser broke!");
                    return false;
                }
            }
        }

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
        salary_month = document.getElementById('salary_month').value;
        if (salary_month == '') {
            showMessage('error', 'Please select month');
            return false;
        }

        var data = "unit_id=" + unit_id + "&emp_id=" + emp_id + "&salary_month=" + salary_month; 
        url =  hostname+"salary_report_con/advance_salary_report/";

        ajaxRequest.open("POST", url, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
        ajaxRequest.send(data);
        ajaxRequest.onreadystatechange = function(){
            if(ajaxRequest.readyState == 4){
                var resp = ajaxRequest.responseText;

                advance_salary_sheet = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
                advance_salary_sheet.document.write(resp);
            }
        }
    }

</script>

<script>
    $(document).ready(function() {
        $("#searchi").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            $(".removeTrno").toggle($(".removeTr").length === 0);
        });
    });
</script>
<script>
    function loading_open() {
        $('#loader').css('display', 'block');
    }
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

        url = hostname + "common/grid_emp_list/" + unit + "/" + dept + "/" + section + "/" + line + "/" + desig;
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                "status": status
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

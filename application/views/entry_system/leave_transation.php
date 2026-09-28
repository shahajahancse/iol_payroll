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
        <div class="row tablebox" style="display: block;">   <!-- dpt, section, line -->
            <h3 style="font-weight: 600;"><?= $title ?></h3>
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
            <div class="col-md-6">
                <?php $categorys = $this->db->get('emp_category_status')->result(); ?>
                <div class="form-group">
                    <label class="control-label">Status </label>
                    <select name="status" id="status" class="form-control input-sm" onChange="grid_emp_list()">
                        <option value="">All Employee</option>
                        <?php foreach ($categorys as $key => $row) { ?>
                        <option value="<?= $row->id ?>" <?= ($row->id==1)?'selected':'' ?>><?= $row->status_type; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div id="loader" align="center" style="margin:0 auto; overflow:hidden; display:none; margin-top:10px;">
            <img src="<?php echo base_url('images/ajax-loader.gif');?>" />
        </div>
        <div class="row nav_head">
            <div class="col-lg-6">
                <span style="font-size: 20px;"><?= $title ?></span>
            </div>
            <div class="col-lg-6">
                <div class="input-group" style="display:flex;justify-content:space-between; gap: 20px">
                    <input class="btn btn-primary btn-sm" onclick='toggleSection("leave_entry")' type="button"
                        value='Leave Entry' />
                    <input class="btn btn-info btn-sm" onclick='toggleSection("leave_balance_check")' type="button"
                        value='Leave Balance Check' />
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        <div id="leave_entry" class="row nav_head" style="margin-top: 13px;">
            <form class="col-md-12" action="<?= base_url('entry_system_con/leave_entry') ?>" method="post"
                id="leave_entry_form">
                <div class="col-md-12">
                    <div class="raw">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Apply Date</label>
                                <input type="text" class="form-control input-sm date" id="apply_date" name="apply_date"
                                    >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">From Date</label>
                                <input type="text" class="form-control input-sm date" id="from_date" name="from_date"
                                    >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">To Date</label>
                                <input type="text" class="form-control input-sm date" id="to_date" name="to_date"
                                   >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Leave Type</label>
                                <select class="form-control select22" name='leave_type' id='leave_type'
                                    style="padding: 1px 12px; height: 29px;">
                                    <option value='cl'>Casual</option>
                                    <option value='sl'>Sick</option>
                                    <option value='sp'>Special</option>
                                    <option value='ml'>Maternity</option>
                                    <option value='wp'>With Out Pay</option>
                                    <option value='el'>Earn</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" style="margin: 8px 16px;">
                                <label class="control-label">Address on Vacation</label>
                                <textarea class="form-control input-sm" id="add_on_vacation" name="add_on_vacation"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="margin: 8px 16px;">
                                <label class="control-label">Description</label>
                                <textarea class="form-control input-sm" id="reason" name="reason"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin: 8px -16px; display: flex; justify-content: flex-end;">
                            <input type="button" onclick="leave_applications(event)" value="Application Form" class="btn btn-info">
                            <input type="button" onclick="leave_add(event)" value="Submit" class="btn btn-primary" style="margin-left:15px">
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->
        <div id="leave_balance_check" class="row nav_head" style="margin-top: 13px;">
            <div class="col-md-12" style="display: flex;gap: 11px;flex-direction: column;">
                <div class="col-md-12" style="box-shadow: 0px 0px 2px 2px #bdbdbd;border-radius: 4px;padding-top: 8px;">
                    <div class="row">
                        <div class="col-md-8">
                            <div style="display: flex; gap: 10px">
                                <span>
                                    <img id="profile_image" style="height: 68px;width: 86px;" class="img-responsive"
                                        alt="">
                                </span>
                                <p style="font-size: 20px;">Name: <span id="emp_name"> </span></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="year">Select Year:</label>
                                <select id="bal_get_year" name="year" style="width: 70px;"></select>
                                <script>
                                const currentYear = new Date().getFullYear();
                                const yearSelect = document.getElementById('bal_get_year');
                                for (let year = currentYear; year >= 1900; year--) {
                                    const option = document.createElement('option');
                                    option.value = year;
                                    option.text = year;
                                    yearSelect.add(option);
                                }
                                </script>
                                <a class="btn btn-primary" style="margin: -5px 0px 0px 12px;"
                                    onclick='get_leave_balance()'>Get</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="box-shadow: 0px 0px 2px 2px #bdbdbd;border-radius: 4px;padding-top: 8px;">
                    <table class="table col-md-12">
                        <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>Entitle</th>
                                <th>Taken</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody id="leave_balance">
                            <tr>
                                <th>Casual Leave</th>
                                <td id="leave_entitle_casual"></td>
                                <td id="leave_taken_casual"></td>
                                <td id="leave_balance_casual"></td>
                            </tr>
                            <tr>
                                <th>Sick Leave</th>
                                <td id="leave_entitle_sick"></td>
                                <td id="leave_taken_sick"></td>
                                <td id="leave_balance_sick"></td>
                            </tr>
                            <tr>
                                <th>Special Leave</th>
                                <td id="leave_entitle_paternity"></td>
                                <td id="leave_taken_paternity"></td>
                                <td id="leave_balance_paternity"></td>
                            </tr>
                            <tr>
                                <th>Maternity Leave</th>
                                <td id="leave_entitle_maternity"></td>
                                <td id="leave_taken_maternity"></td>
                                <td id="leave_balance_maternity"></td>
                            </tr>
                            <tr>
                                <th>Earn Leave</th>
                                <td id="leave_entitle_earn"></td>
                                <td id="leave_taken_earn"></td>
                                <td id="leave_balance_earn"></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>

    </div>
    <div class="col-md-4 tablebox">
        <input type="text" id="searchi" class="form-control" placeholder="Search">
        <div style="height: 80vh; overflow-y: scroll;">
            <table class="table table-hover" id="fileDiv">
                <thead>
                    <tr style="position: sticky;top: 0;z-index:1">
                        <th class="active" style="width:10%"><input type="checkbox" id="select_all"
                                class="select-all checkbox" name="select-all"></th>
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
                    <?php } } ?>
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
        $(document).ready(function() {
            $("#searchi").on("keyup", function() {
                grid_emp_list()
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

<script>
    function get_checked_value(checkboxes) {
        var vals = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value)
            .join(",");
        return vals;
    }
</script>

<script>
    function get_leave_balance() {
        var checkboxes = document.getElementsByName('emp_id[]');
        var sql = get_checked_value(checkboxes);
        let numbersArray = sql.split(",");
        if (numbersArray == '') {
            alert('Please select employee Id');
            $("#loader").hide();
            setTimeout(() => {
                $("#leave_balance_check").hide();
            }, 500);
        }
        if (numbersArray.length > 1) {
            alert('Please select max one employee');
            $("#loader").hide();
            setTimeout(() => {
                $("#leave_balance_check").hide();
            }, 100);
        }
        var bal_get_year = $('#bal_get_year').val();
        if (bal_get_year == '') {
            alert('Please select Year');
            $("#loader").hide();
        }
        $.ajax({
            type: "POST",
            url: hostname + "entry_system_con/leave_balance_ajax",
            data: {
                emp_id: numbersArray[0],
                year: bal_get_year
            },
            success: function(d) {
                var data = JSON.parse(d);
                $("#loader").hide();
                $("#leave_balance_check").show();
                $('#profile_image').attr('src', hostname + 'uploads/photo/' + data.epm_info.img_source);
                $('#emp_name').html(data.epm_info.name_en);
                $('#leave_entitle_casual').html(data.leave_entitle_casual);
                $('#leave_entitle_sick').html(data.leave_entitle_sick);
                $('#leave_entitle_maternity').html(data.leave_entitle_maternity);
                $('#leave_entitle_paternity').html(data.leave_entitle_paternity);
                $('#leave_entitle_earn').html(data.leave_entitle_earn);
                $('#leave_taken_casual').html(data.leave_taken_casual);
                $('#leave_taken_sick').html(data.leave_taken_sick);
                $('#leave_taken_maternity').html(data.leave_taken_maternity);
                $('#leave_taken_paternity').html(data.leave_taken_paternity);
                $('#leave_taken_earn').html(data.leave_taken_earn);
                $('#leave_balance_casual').html(data.leave_balance_casual);
                $('#leave_balance_sick').html(data.leave_balance_sick);
                $('#leave_balance_maternity').html(data.leave_balance_maternity);
                $('#leave_balance_paternity').html(data.leave_balance_paternity);
                $('#leave_balance_earn').html(data.leave_balance_earn);
            },
            error: function() {
                $("#loader").hide();
                alert('Something went wrong');
            }
        })
    }
</script>

<script>
    function toggleSection(sectionId) {
        console.log(sectionId);
        if (sectionId == 'leave_entry') {
            $("#leave_balance_check").hide();
        } else {
            $("#leave_entry").hide();
            get_leave_balance();
        }
        $("#" + sectionId).slideToggle();
        $('#from_date').val('');
        $('#to_date').val('');
    }
    // Initial hiding of both sections
    $("#leave_entry, #leave_balance_check, #leave_application").hide();
</script>

<script>
    function leave_add(e) {
        e.preventDefault();

        var checkboxes = document.getElementsByName('emp_id[]');
        var sql = get_checked_value(checkboxes);
        let numbersArray = sql.split(",");
        if (numbersArray == '') {
            alert('Please select employee Id');
            return false;
        }
        if (numbersArray.length > 1) {
            alert('Please select max one employee');
            return false;
        }
        var reason = $('#reason').val();
        var add_on_vacation = $('#add_on_vacation').val();
        var unit_id = $('#unit_id').val();
        if (unit_id == '') {
            alert('Please select Unit');
            return false;
        }

        if ($('#apply_date').val() == '') {
            alert('Please select Apply Date');
            return false;
        }

        if ($('#from_date').val() == '') {
            alert('Please select From Date');
            return false;
        }

        if ($('#to_date').val() == '') {
            alert('Please select To Date');
            return false;
        }

        if ($('#leave_type').val() == '') {
            alert('Please select leave type');
            return false;
        }

        if ($('#leave_type').val() == 'ml') {
            alert('Please, use Maternity Entry menu option');
            return false;
        }

        var formdata = $("#leave_entry_form").serialize();
        var data = "unit_id=" + unit_id + "&emp_id=" + numbersArray[0] + "&" + formdata; // Merge the data
        console.log(data);

        $.ajax({
            type: "POST",
            url: hostname + "entry_system_con/leave_entry",
            data: data,
            success: function(data) {
                $("#loader").hide();
                if (data == 'success') {
                    $('#apply_date').val('');
                    $('#from_date').val('');
                    $('#to_date').val('');
                    $('#add_on_vacation').val('');
                    $('#reason').val('');
                    showMessage('success', 'Leave Added Successfully');
                } else {
                    showMessage('error', data);
                }
            },
            error: function(data) {
                $("#loader").hide();
                showMessage('error', 'Leave Not Added');
            }
        })
    }


    function leave_applications(e) {
        var ajaxRequest;  // The variable that makes Ajax possible!
        try{
            // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
        }catch (e){
            // Internet Explorer Browsers
            try{
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            }catch (e) {
                try{
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                }catch (e){
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        var type = document.getElementById('leave_type').value;
        // alert(type);
        var reason = document.getElementById('reason').value;
        var add_on_vacation = document.getElementById('add_on_vacation').value;
        var firstdate = document.getElementById('from_date').value;
        if(firstdate ==''){
            alert("Please select first date");
            return false;
        }
        var seconddate = document.getElementById('to_date').value;
        if(seconddate ==''){
            alert("Please select second date");
            return false;
        }

        var unit_id = document.getElementById('unit_id').value;
        if(unit_id ==''){
            alert("Please select unit !");
            return false;
        }
        var checkboxes = document.getElementsByName('emp_id[]');
        var sql = get_checked_value(checkboxes);
        let numbersArray = sql.split(",");
        if (sql == '') {
            alert('Please select employee Id');
            return false;
        }

        var apply_date = document.getElementById('apply_date').value;
        if (apply_date == '') {
            alert('Please select Apply Date');
            return false;
        }

        if (numbersArray.length > 1) {
            alert('Please select max one employee');
            return false;
        }
        var queryString="firstdate="+firstdate+"&seconddate="+seconddate+"&apply_date="+apply_date+"&emp_id="+sql+"&unit_id="+unit_id+"&type="+type+"&reason="+reason+'&add_on_vacation='+add_on_vacation;
        url = hostname + "grid_con/leave_application/";
        ajaxRequest.open("POST", url, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
        ajaxRequest.send(queryString);
        ajaxRequest.onreadystatechange = function () {
            if(ajaxRequest.readyState == 4){
                var resp = ajaxRequest.responseText;
                if (resp == false) {
                    alert("Sorry! You are not eligible to apply for this leave");
                } else {
                    daily_present_report = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
                    daily_present_report.document.write(resp);
                }
            }
        }
    }
</script>



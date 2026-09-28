<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/earn_leave.js" type="text/javascript"></script>
<style>
	#fileDiv #removeTr td {
	    padding: 5px 10px !important;
	    font-size: 14px;
	}
	.content .tablebox .form-group {
		margin-bottom: 10px !important;
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

    <div class="col-md-8">
        <div class="row tablebox" style="display: block;">
            <!-- <h3 style="font-weight: 600;"><?= $title ?></h3> -->
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
            <div class="col-lg-3" style="padding-lef: 0px !important; padding-right: 0px !important;">
                <span style="font-size: 20px;">Select Date </span>
            </div><!-- /.col-lg-4 -->

            <style>
            	.input-group .form-control {
				    width: 90% !important;
				}
            	.input-group-btn .btn {
				    padding: 8px 10px !important;
				}
            </style>	
            <div class="col-lg-6" style="padding-left: 0px !important;">
                <div class="input-group" style="gap: 14px">
                    <input type="month" class="form-control" id="process_month" >
                    <span class="input-group-btn">
                        <input class="btn btn-primary" style="<?php  if(in_array(131,$acl)) {echo '';} else { echo 'margin: 0px 3px !important;"';}?>" onclick='salary_process()' type="button" value='Process' />
                        <input class="btn btn-success" onclick='salary_process_block()' type="button" value='Final Process' style="margin: 0px 3px !important; <?php  if(in_array(131,$acl)) {echo '';} else { echo 'display:none;"';}?>" />
                        <input class="btn btn-danger" style="<?php if(in_array(133,$acl)) {echo '';} else { echo 'display:none;';}?>" onclick='salary_block_delete()' type="button" value='Final Delete' />
                    </span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-4 -->

        </div><!-- /.row -->
        <div class="row nav_head" style="margin-top:20px">
            <div class="col-lg-4" style="padding-lef: 0px !important; padding-right: 0px !important;">
                <span style="font-size: 20px;">Earn Leave Process </span>
            </div><!-- /.col-lg-4 -->

            <style>
            	.input-group .form-control {
				    width: 90% !important;
				}
            	.input-group-btn .btn {
				    padding: 8px 10px !important;
				}
            </style>	
            <div class="col-lg-6" style="padding-left: 0px !important;">
                <div class="input-group" style="gap: 14px">
                    <input type="month" class="form-control" id="earn_leave_process_month" >
                    <span class="input-group-btn">
                        <input class="btn btn-primary" onclick='earn_leave_process(1)' type="button" value='Process' />
                        <input class="btn btn-success" onclick='earn_leave_process(2)' type="button" value='Final Process' style="margin: 0px 3px !important;" />
                    </span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-4 -->

        </div><!-- /.row -->


		<div class="row nav_head" style="margin-top:20px">
            <div class="col-lg-3" style="padding-lef: 0px !important; padding-right: 0px !important;">
                <span style="font-size: 20px;">Pay Earn Leave</span>
            </div><!-- /.col-lg-4 -->

            <style>
            	.input-group .form-control {
				    width: 90% !important;
				}
            	.input-group-btn .btn {
				    padding: 8px 10px !important;
				}
            </style>	
            <div class="col-lg-9" style="padding-left: 0px !important;">
                <div class="input-group" style="display:flex">
					<input type="number" id="earn_leave_pay_year" name="earn_leave_pay_year" min="2000" max="<?php echo date('Y')?>" value="<?php echo date('Y')?>" style="width: 20% !important;">
					<input class="date" type="text" id="pay_date" name="earn_leave_pay_month"   value="" style="width: 30% !important; margin-left: 8px !important;">

                    <!-- <span class="input-group-btn"> -->
					<input style="margin-left: 8px !important;" class="btn btn-success" onclick='earn_leave_pay()' type="button" value='Process To Pay' />
					<input style="margin-left: 8px !important;" class="btn btn-success" onclick='earn_leave_list()' type="button" value='View List' />
					<!-- </span> -->
                </div><!-- /input-group -->
            </div><!-- /.col-lg-4 -->

        </div>
		<div class="row nav_head" style="margin-top:20px">
            <div class="col-lg-3" style="padding-lef: 0px !important; padding-right: 0px !important;">
                <span style="font-size: 20px;">Festival Bonus</span>
            </div><!-- /.col-lg-4 -->

            <style>
            	.input-group .form-control {
				    width: 90% !important;
				}
            	.input-group-btn .btn {
				    padding: 8px 10px !important;
				}
            </style>	
            <div class="col-lg-9" style="padding-left: 0px !important;">
                <div class="input-group" style="display:flex">
					<input type="month" class="form-control" id="bonus_process_month" >

                    <!-- <span class="input-group-btn"> -->
					<input style="margin-left: 8px !important;" class="btn btn-success" onclick="festival_bonus()" type="button" value='Process to Festival' />
					<!-- </span> -->
                </div><!-- /input-group -->
            </div><!-- /.col-lg-4 -->
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
</div>

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

    <script>
		function festival_bonus(){
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

			var bonus_process_month = document.getElementById('bonus_process_month').value;
            if (bonus_process_month == '')
            {
                alert("Please select Year Month");
                return false;
            }

			var unit_id = document.getElementById('unit_id').value;
			if(unit_id =='Select')
			{
				alert("Please select Category options");
				return false;
			}
			//alert('hello');
			var checkboxes = document.getElementsByName('emp_id[]');
			var sql = get_checked_value(checkboxes);

			if (sql == '') {
				alert('Please select employee Id');
				return false;
			}
			// hostname = window. location.href;


			var queryString="unit_id="+unit_id+'&date='+bonus_process_month+'&sql='+sql;
			url =  hostname+"salary_process_con/festival_process";

			document.getElementById('loader').style.display = 'block';

			ajaxRequest.open("POST", url, true);
			ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
			ajaxRequest.send(queryString);

			ajaxRequest.onreadystatechange = function(){
				document.getElementById('loader').style.display = 'none';
				if(ajaxRequest.readyState == 4){
					var resp = ajaxRequest.responseText;
					extra_ot = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
					extra_ot.document.write(resp);
				}
			}
		}
	</script>
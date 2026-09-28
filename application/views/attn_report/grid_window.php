
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
	?>
	<div class="content">
		<!-- left side -->
		<div class="col-md-8">
			<!-- selection area -->
			<div class="row tablebox" style="margin-bottom: 10px;">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">First Date : </label>
							<input value="<?= date('d-m-Y') ?>" onchange="count_l1()" class="form-control input-sm date" name="firstdate" id="firstdate" >
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Second Date : </label>
							<input onchange="hide_date2()" class="form-control input-sm date" name="seconddate" id="seconddate" type="text" autocomplete="off">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Max OT </label>
							<select class="form-control input-sm" id='max_ot' name='max_ot'>
								<option value="">Select one</option>
								<option value="1">1 hour ot</option>
								<option value="2">2 hour ot</option>
								<option value="3">3 hour ot</option>
								<option value="4">4 hour ot</option>
								<option value="5">5 hour ot</option>
								<option value="6">6 hour ot</option>
								<option value="7">7 hour ot</option>
								<option value="8">8 hour ot</option>
								<option value="9">9 hour ot</option>
								<option value="10">10 hour ot</option>
								<option value="11">11 hour ot</option>
								<option value="12">12 hour ot</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row tablebox" style="display: block; margin-bottom: 10px;">
				<h3 class="h3" style="font-weight: 600;">Select Category</h3>
				<div class="col-md-6">
					<div class="form-group">
						<label>Unit <span style="color: red;">*</span> </label>
						<select  name="unit_id" id="unit_id" onchange="count_l1()" class="form-control input-sm">
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
			<!-- selection area end -->
			<div id='loaader' style="display: none;align-items: center;justify-content: center;z-index: 33333;background: #e9e9e966;position: absolute;" class="col-md-12">
				<img  src="<?php echo base_url('loader.gif')?>" alt="loader">
			</div>
			<!-- button area for report section  -->
			<div class="row tablebox" style="margin-bottom: 15px;">
				<div class='multitab-section'>
					<ul class="nav nav-tabs" id="myTabs">
						<li class="active"><a href="#daily" data-toggle="tab">Daily Reports</a></li>
						<li><a href="#monthly" data-toggle="tab">Monthly Reports</a></li>
						<li><a href="#continuous" data-toggle="tab">Continuous Reports</a></li>
						<li><a href="#other" data-toggle="tab">Other Reports</a></li>
					</ul>
					<div class="tab-content">
						<?php
							$user_id = $this->session->userdata('data')->id;
							$acl = check_acl_list($user_id);
						?>
						<!-- Daily Reports -->
						<div class="tab-pane fade in active" id="daily">
							<?php if(in_array(61,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_report(1)">Present Report</button>
							<?php } ?>
							<?php if(in_array(62,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_report(2)">Absent Report</button>
							<?php } ?>
							<?php if(in_array(63,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_report(3)">Daily Leave Report</button>
							<?php } ?>
							<?php if(in_array(64,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_report(4)">Late Report</button>
							<?php } ?>
							<?php if(in_array(65,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_report(5)">OT Report</button>
							<?php } ?>
							<?php if(in_array(66,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_report(6)">Daily EOT</button>
							<?php } ?>

							<?php if(in_array(67,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_report(7)">Out & IN Report</button>
							<?php } ?>
							<?php if(in_array(68,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_report(8)">Daily Out Punch Miss</button>
							<?php } ?>
							<?php if(in_array(69,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="daily_costing_report()">Daily Costing</button>
							<?php } ?>



							<?php if(in_array(70,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_actual_present_report()">Actual Present Report</button>
							<?php } ?>
							<?php if(in_array(71,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_daily_actual_out_in_report()">Actual Out & IN Report</button>
							<?php } ?>
							<?php if(in_array(72,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="holiday_weekend_attn_report('A')">Holiday / Weekend Absent</button>
							<?php } ?>
							<?php if(in_array(73,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="holiday_weekend_attn_report('P')">Holiday / Weekend Present</button>
							<?php } ?>


							<?php if(in_array(74,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="daily_attendance_summary(1)">Line Man Power Costing </button>
							<button class="btn input-sm sbtn" onclick="daily_attendance_summary(2)">Section Man Power Costing </button>
							<?php } ?>
							<?php if(in_array(75,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="daily_costing_summary()">Daily Costing Summary</button>
							<?php } ?>
							<?php if(in_array(76,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="daily_logout_report()">Daily Logout Report</button>
							<?php } ?>
							<?php if(in_array(77,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="ot_acknowledgement_sheet(1)">OT Acknowledgement sheet</button>
							<?php } ?>
							<?php if(in_array(78,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="ot_acknowledgement_sheet(2)">OT Acknowledgement Female</button>
							<?php } ?>
							<?php if(in_array(79,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="iftar_bill_list()">Iftar Bill List</button>
							<?php } ?>
						</div>
						<!-- Daily Reports end -->

						<!-- Monthly Reports -->
						<div class="tab-pane fade" id="monthly">
							<?php if(in_array(80,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_monthly_att_register_ot()">Attendance Register</button>
								<?php echo form_open(base_url('grid_con/att_register_ot_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">Attendance Register Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>
							<?php if(in_array(81,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_monthly_ot_register()">OT Register</button>
								<?php echo form_open(base_url('grid_con/ot_register_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">OT Register Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>
							<?php if(in_array(82,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_monthly_eot_register()">EOT Register</button>
								<?php echo form_open(base_url('grid_con/eot_register_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">EOT Register Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>
							<?php if(in_array(83,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_monthly_att_register()">Attendance Register</button>
								<?php echo form_open(base_url('grid_con/att_register_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">Attendance Register Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>


							<?php if(in_array(217,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_monthly_night_register()">Night Bill Register</button>
								<?php echo form_open(base_url('grid_con/night_bill_register_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">Night Bill Register Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>

							<?php if(in_array(218,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_monthly_ifter_register()">Ifter Bill Register</button>
								<?php echo form_open(base_url('grid_con/ifter_bill_register_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">Ifter Bill Register Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>



							<?php if(in_array(219,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_monthly_weekend_register()"> Weekend Register</button>
								<?php echo form_open(base_url('grid_con/weekend_bill_register_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">Weekend  Register Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>



							<?php if(in_array(220,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_monthly_holiday_register()">Holiday Register</button>
								<?php echo form_open(base_url('grid_con/holiday_register_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">Holiday Register Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>









						</div>
						<!-- Monthly Reports end -->

						<!-- Continuous Reports -->
						<div class="tab-pane fade" id="continuous">
							<?php if(in_array(84,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_present_report()">Present Report</button>
								<?php echo form_open(base_url('grid_con/continuous_present_report_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_date2' name="hide_date2">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" value='P' name="hide_status">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc1()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">Present Report Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>
							<?php if(in_array(85,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_absent_report()">Absent Report</button>
								<?php echo form_open(base_url('grid_con/continuous_present_report_excel'), array('method' => 'post')); ?>
								<input type="hidden" class='hide_date' name="hide_date">
								<input type="hidden" class='hide_date2' name="hide_date2">
								<input type="hidden" class='hide_emp' name="hide_emp">
								<input type="hidden" value='A' name="hide_status">
								<input type="hidden" class='hide_unit' name="hide_unit">
								<button onclick="return validFunc1()" type="submit" name="excel" value="excel" class="btn input-sm btn-info">Absent Report Excel</button>
								<?php echo form_close(); ?>
							<?php } ?>
							<?php if(in_array(86,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="continuous_leave_report()">Leave Report</button>
							<?php } ?>

							<?php if(in_array(87,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_late_report()">Late Report</button>
							<?php } ?>
							<?php if(in_array(88,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_incre_report()">Increment Report</button>
							<?php } ?>
							<?php if(in_array(89,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_prom_report()">Promotion Report</button>
							<?php } ?>
							<?php if(in_array(90,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_line_report('line')">Line Change Report</button>
							<?php } ?>
							<?php if(in_array(91,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_line_report('section')">Section Change Report</button>
							<?php } ?>
							<?php if(in_array(92,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_ot_eot_report()">OT / EOT Report</button>
							<?php } ?>

							<?php if(in_array(93,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_continuous_costing_report()">Continuous Costing Report</button>
							<?php } ?>

							<?php if(in_array(94,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="last_increment_promotion(1)">Last Increment Check</button>
							<?php } ?>
							<?php if(in_array(95,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="last_increment_promotion(2)">Last Promotion Check</button>
							<?php } ?>
							<?php if(in_array(96,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="increment_able_employee()">Increment able employee</button>
							<?php } ?>
							<?php if(in_array(97,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="unit_transferred_list(1)">Unit transfer list</button>
							<?php } ?>
							<?php if(in_array(98,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="unit_transferred_list(2)">Unit transferred list</button>
							<?php } ?>
							<?php if(in_array(99,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="emp_conformation_list(1)">Staff Conformation List</button>
							<?php } ?>
							<?php if(in_array(100,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="emp_conformation_list(2)">Emp Conformation List</button>
							<?php } ?>
							<?php if(in_array(101,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="emp_conformation_list(3)">Conformation Letter</button>
							<?php } ?>
						</div>
						<!-- Continuous Reports end -->

						<!-- Other Reports -->
						<div class="tab-pane fade" id="other">
							<?php if(in_array(102,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="id_card(1)">ID Card Bangla</button>
							<?php } ?>
							<?php if(in_array(103,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="id_card(2)">ID Card English</button>
							<?php } ?>
							<?php if(in_array(104,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_job_card()">Job Card</button>
							<?php } ?>


							<?php if(in_array(105,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_new_join_report()">New Join Report</button>
							<?php } ?>
							<?php if(in_array(106,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_resign_report()">Resign Report</button>
							<?php } ?>
							<?php if(in_array(107,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_left_report()">Left Report</button>
							<?php } ?>
							<?php if(in_array(108,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_general_info()">General Report</button>
							<?php } ?>
							<?php if(in_array(109,$acl)) { ?>
							<!-- <button class="btn input-sm sbtn" onclick="grid_general_eng()">General Report(Eng)</button> -->
							<?php } ?>


							<?php if(in_array(110,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_earn_leave()">Earn Leave Report</button>
							<?php } ?>
							<?php if(in_array(111,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_yearly_leave_register()">Leave Register</button>
							<?php } ?>
							<?php if(in_array(112,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="worker_register()">Worker Register</button>
							<?php } ?>
							<?php if(in_array(113,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_emp_job_application()">Job Application</button>
							<?php } ?>
							<?php if(in_array(114,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="join_letter()">Joining Letter</button>
							<?php } ?>


							<?php if(in_array(115,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_letter_report(1)">Letter 1 <span class="badge bg-red " style="color:#fff !important" id="letter1_count">0</span></button>
							<?php } ?>
							<?php if(in_array(116,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_letter_report(2)">Letter 2 <span class="badge bg-red" style="color:#fff !important" id="letter2_count">0</span></button>
							<?php } ?>
							<?php if(in_array(117,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_letter_report(3)">Letter 3 <span class="badge bg-red" style="color:#fff !important" id="letter3_count">0</span></button>
							<?php } ?>
							<?php if(in_array(118,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_employee_information()">Employee Information</button>
							<?php } ?>

							<?php if(in_array(119,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_incre_prom_report(1)">Increment Letter</button>
							<?php } ?>
							<?php if(in_array(120,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_incre_prom_report(2)">Promotion Letter</button>
							<?php } ?>
							<?php if(in_array(121,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_incre_prom_report(3)">Line Letter</button>
							<?php } ?>
							<?php if(in_array(122,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_service_book()">Service Book</button>
							<?php } ?>

							<?php if(in_array(123,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_final_satalment()">Final Settlement</button>
							<?php } ?>

							<!-- actual job card -->
							<?php if(in_array(124,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_eot_actual()">Job Card Actual </button>
							<?php } ?>
							<!-- max 2 eot -->
							<?php if(in_array(125,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_extra_ot_9pm()">Job Card.</button>
							<?php } ?>
							<!-- max 5 eot -->
							<?php if(in_array(126,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_extra_ot_12am()">Job Card`</button>
							<?php } ?>
							<!-- eot all with out off day and holiday -->
							<?php if(in_array(127,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_extra_ot_all()">Job Card!</button>
							<?php } ?>

							<?php if(in_array(128,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_maternity_benefit(1)">Maternity Benefit Report 1</button>
							<?php } ?>
							<?php if(in_array(129,$acl)) { ?>
								<button class="btn input-sm sbtn" onclick="grid_maternity_benefit(2)">Maternity Benefit Report 2</button>
							<?php } ?>

							<?php if(in_array(130,$acl)) { ?>
                            <button class="btn input-sm sbtn" onclick="grid_service_book_info()">Service Book Information</button>
                            <?php } ?>
							<!-- Other Reports end -->
							<?php if(in_array(131,$acl)) { ?>
							<!-- <button class="btn input-sm sbtn" onclick="grid_roster_employee()">Roster List</button> -->
                            <?php } ?>
							<?php if(in_array(121,$acl)) { ?>
							<button class="btn input-sm sbtn" onclick="grid_employee_background()">Employee Background</button>
                            <?php } ?>
							<!-- roster list end  -->
						</div>
					</div>
				</div>
			</div>
			<!-- button area for report section end -->
		</div>

		<!-- right side of employee list -->
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
								<td><input onclick="get_checked_emp()" type="checkbox" class="checkbox" id="emp_id" name="emp_id[]" value="<?= $emp->emp_id ?>">
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

	<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>

	<script>
		$(document).ready(function() {
			get_checked_emp();
		});
		function validFunc() {
			var datasheet = document.getElementsByClassName("hide_emp")[0].value;
			if (datasheet == '') {
				alert('Please select employee');
				return false;
			} else {
				return true;
			}
		}
		function validFunc1() {
			var datasheet = document.getElementsByClassName("hide_emp")[0].value;
			if (datasheet == '') {
				alert('Please select employee');
				return false;
			}

			var datasheet1 = document.getElementsByClassName("hide_date2")[0].value;
			if (datasheet1 == '') {
				alert('Please select Second Date');
				return false;
			} else {
				return true;
			}
		}

		function get_checked_emp() {
			var checkboxes = document.getElementsByName('emp_id[]');
			var vals = Array.from(checkboxes)
				.filter(checkbox => checkbox.checked)
				.map(checkbox => checkbox.value)
				.join(",");

			$('.hide_emp').val(vals); // for excel on monthly report
		}
		function hide_date2() {
		    var seconddate = document.getElementById('seconddate').value;
			if (seconddate == '') {
				return false;
			}
			$('.hide_date2').val(seconddate); // for excel on monthly report
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
				get_checked_emp();
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
							opt.html(name);
							$('.dept').append(opt);
						});
						changeFontBn();
					}
				});
				// load employee
				grid_emp_list();
			});
		});
	</script>

	<script>
		function count_l1() {
		    var unit = document.getElementById('unit_id').value;
			if (unit == '') {
				return false;
			}

		    var first_date = document.getElementById('firstdate').value;
		    var unit_id = document.getElementById('unit_id').value;
			if (first_date == '') {
				return false;
			}
			$('.hide_date').val(first_date); // for excel on monthly report
			$('.hide_unit').val(unit_id); // for excel on monthly report

			$.ajax({
				type: "POST",
				url: hostname + "grid_con/grid_letter_count",
				data: {
					"unit_id": unit,
					"firstdate": first_date
				},
				success: function(data){
					var data = JSON.parse(data);
					$('#letter1_count').html(data[1]);
					$('#letter2_count').html(data[2]);
					$('#letter3_count').html(data[3]);
				}
			})
		}

	</script>
	<script>
		$(document).ready(function() {
			count_l1();
		});
		function changeFontBn() {
			setTimeout(() => {
				// console.log('changeFontBn');
				$('.changeFontBn').css('font-family', 'SutonnyMJ');
			}, 5000);
		}
	</script>
	<script>
		function grid_roster_employee(){
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
			var unit_id = document.getElementById('unit_id').value;
			var first_date = document.getElementById('firstdate').value;
			if(unit_id =='Select'){
				alert("Please select unit !");
				return;
			}

			document.getElementById('loaader').style.display = 'flex';
			var queryString="unit_id="+unit_id+"&first_date="+first_date;
			url =  hostname+"grid_con/grid_roster_employee/";
			ajaxRequest.open("POST", url, true);
			ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
			ajaxRequest.send(queryString);
			ajaxRequest.onreadystatechange = function(){
				if (ajaxRequest.readyState == 4) {
					document.getElementById('loaader').style.display = 'none';
					var resp = ajaxRequest.responseText;
					service_book = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
					service_book.document.write(resp);
					service_book.stop();
				}
			}
		}

	function grid_employee_background(){
		var ajaxRequest;

		try{
		ajaxRequest = new XMLHttpRequest();
		}catch (e){
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



		var checkboxes = document.getElementsByName('emp_id[]');
		var sql = get_checked_value(checkboxes);
		if (sql == '') {
			alert('Please select employee Id');
			return false;
		}
		document.getElementById('loaader').style.display = 'flex';
		url =  hostname+"grid_con/grid_employee_background/";
		var queryString="emp_id="+sql;
		ajaxRequest.open("POST", url, true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
		ajaxRequest.send(queryString);
		ajaxRequest.onreadystatechange = function(){
			if (ajaxRequest.readyState == 4) {
				document.getElementById('loaader').style.display = 'none';
				var resp = ajaxRequest.responseText;
				service_book = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
				service_book.document.write(resp);
				service_book.stop();
			}
		}
	}

	function get_checked_value(checkboxes) {
		var vals = Array.from(checkboxes)
		.filter(checkbox => checkbox.checked)
		.map(checkbox => checkbox.value)
		.join(",");
	}
</script>

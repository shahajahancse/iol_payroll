<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MSH Payroll Reports</title>
	<link href="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.min.css') ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo base_url('/assets/bootstrap/js/bootstrap.js') ?>"></script>

    <script src="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/calendar.css" />

	<script src="<?php echo base_url(); ?>js/mars_js.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/calendar_eu.js" type="text/javascript"></script>


</head>

	<style>
		.select-date {
			border-radius: 5px;
			border: 1px solid #d6d5cf;
			padding: 10px;
			margin-right: 15px;
			margin-left: 15px;
		}
		.select-date .form-group-sm .form-control{
			height: 25px !important;
			padding: 5px !important;
		}

		.category-option {
			padding-top: 15px;
		}
		.report-section fieldset legend {
			margin-bottom: 5px !important;
		}
	</style>

<body bgcolor="#ECE9D8">
<div  style=" margin:0 auto; width:1200px; min-height:555px; overflow:hidden;">
<div style="float:left; overflow:hidden; width:65%; height:auto; padding:10px;">
<form name="grid">
	<div class="row select-date" align="left">
		<?php
			$this->load->model('common_model');
			$unit = $this->common_model->get_unit_id_name();
		?>
			<div class="col-md-6 form-inline col-md-offset-3">
				<div class="form-group form-group-sm">
					<label class="control-label">Select Date : </label>
					<input type="text" name="firstdate" id="firstdate" class="form-control" style="width:100px;"/>
					<span>
						<script language="JavaScript">
						var o_cal = new tcal ({
							// form name
							'formname': 'grid',
							// input name
							'controlname': 'firstdate'
						});

						// individual template parameters can be modified via the calendar variable
						o_cal.a_tpl.yearscroll = false;
						o_cal.a_tpl.weekstart = 6;

						</script>
					</span>
				</div>
			</div>
			<div class="col-md-6 form-inline category-option">
				<div class="form-group form-group-sm">
					<label class="control-label">Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </label>
					<select class="form-control" name='grid_start' id='grid_start' style="width:250px;"  />
						<option value='Select'>	Select	</option>
						<?php foreach($unit->result() as $rows) { ?>
								<option value="<?php echo $rows->unit_id; ?>"><?php echo $rows->unit_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-6 form-inline category-option">
				<div class="form-group form-group-sm">
					<label class="control-label">Dept. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </label>
					<select class="form-control" id="category" style="width:250px;">
						<option value="Select" selected="selected">Select</option>
						<!-- <option value="Department">Department</option>
						<option value="Section">Section</option> -->
						<option value="Line">Line</option>
					</select>
				</div>
			</div>

		<!-- <fieldset style='width:95%;'><legend><font size='+1'><b>Date</b></font></legend>

			<table class="table">
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<div class="form-inline">
							<div class="form-group">
								<label>Select Date &nbsp;&nbsp;: &nbsp;&nbsp;</label>
								<input type="text" name="firstdate" id="firstdate" class="form-control" style="width:100px;"/>
								&nbsp;
								<span>
									<script language="JavaScript">
									var o_cal = new tcal ({
										// form name
										'formname': 'grid',
										// input name
										'controlname': 'firstdate'
									});

									// individual template parameters can be modified via the calendar variable
									o_cal.a_tpl.yearscroll = false;
									o_cal.a_tpl.weekstart = 6;

									</script>
								</span>
							</div>
						</div>
					</td>
				</tr>
			</table> -->

			<!-- Select Date: <input type="text" name="firstdate" id="firstdate" style="width:100px;"/> -->

				<!-- <script language="JavaScript">
				var o_cal = new tcal ({
					// form name
					'formname': 'grid',
					// input name
					'controlname': 'firstdate'
				});

				// individual template parameters can be modified via the calendar variable
				o_cal.a_tpl.yearscroll = false;
				o_cal.a_tpl.weekstart = 6;

				</script> -->
		<!-- </fieldset> -->
	</div>
<br />
<!-- <div> -->
<!-- <fieldset style='width:95%;'><legend><font size='+1'><b>Category Options</b></font></legend> -->
	<!-- <table align="left">
	<tr>

	<td>Unit</td>
	<td>:</td>
	<td>
		<select name='grid_start' id='grid_start' style="width:250px;"  />
			<option value='Select'>	Select	</option>
			<?php foreach($unit->result() as $rows) { ?>
					<option value="<?php echo $rows->unit_id; ?>"><?php echo $rows->unit_name; ?></option>
			<?php } ?>
		</select>
	</td>

	<td>

	<td>Select Category</td><td>:</td>
	<select id="category">
		<option value="Select" selected="selected">Select</option>
		<option value="Department">Department</option>
		<option value="Section">Section</option>
		<option value="Line">Line</option>
	</select>
	</td>

	</tr>

	</table> -->

	<!-- <table class="table">
		<tr>
			<td>Unit</td>
			<td>:</td>
			<td>
				<select class="form-control" name='grid_start' id='grid_start' style="width:250px;"  />
					<option value='Select'>	Select	</option>
					<?php foreach($unit->result() as $rows) { ?>
							<option value="<?php echo $rows->unit_id; ?>"><?php echo $rows->unit_name; ?></option>
					<?php } ?>
				</select>
			</td>
			<td>Dept. </td><td>:</td>
			<td>
				<select class="form-control" id="category" style="width:250px;">
					<option value="Select" selected="selected">Select</option>
					<option value="Department">Department</option>
					<option value="Section">Section</option>
					<option value="Line">Line</option>
				</select>
			</td>
		</tr>
	</table>
</fieldset> -->
<!-- </div> -->
<div class="report-section">
<!-- <br /> -->

<fieldset style='width:95%; margin-left: 14px'><legend><font size='+1'><b>Daily Reports</b></font></legend>
	<table class="table" width="100%"  style="font-size:11px; ">
	<?php $usr_arr = array(3,7,8);
	$user_id = $this->acl_model->get_user_id($this->session->userdata('username'));
	$acl = $this->acl_model->get_acl_list($user_id); ?>
	<tr>
	<?php if(!in_array($user_id,$usr_arr)){  ?>
		<td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Attendance Summary" onClick="daily_attendance_summary()"></td>
		<?php } ?>
		<!-- <td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Attendance Summary New" onClick="daily_attendance_summary_test()"></td> -->
		<td style="width:20%;"></td>
		<td style="width:20%;"></td>
		<td style="width:20%;"></td>
	</tr>


	<?php if(!in_array(10,$acl)) { ?>
	<?php if(!in_array(14,$acl)) { ?>
	<?php if(!in_array($user_id,$usr_arr)){  ?>
	<tr>
		<!-- <td style="width:20%;background-color: #666666"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Daily Costing Summary" onClick="daily_costing_summary()"></td> -->

		<td style="width:20%;background-color: #666666"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Daily OT Summary" onClick="daily_ot_summary()"></td>
		<td style="width:20%;"></td>
		<td style="width:20%;"></td>
		<td style="width:20%;"></td>
		<!-- <td style="width:20%;background-color: #666666"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Daily Logout" onClick="daily_logout_report()"></td> -->
	</tr>
	<?php } ?>
	<?php } ?>
	<?php } ?>

	</table>

</fieldset>



</div>

</form>

</div>
<div style="float:right;">
<table id="list1" style="font-family: 'Times New Roman', Times, serif; font-size:15px;"><tr><td></td></tr></table>
</div>
<!--<div id="pager1"></div>-->

<div id="viewid"></div>
</div>
</body>
</html>

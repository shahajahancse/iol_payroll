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

	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>themes/redmond/jquery-ui-1.8.2.custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>themes/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/calendar.css" />

	<script type="text/javascript" src="<?php echo base_url();?>js/dynamic.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/calendar_eu.js" type="text/javascript"></script>
	<script>
	    $(function() {

	            $( ".clearfix" ).dialog({
	                autoOpen: false,
	                height: 370,
	                width: 300,
	                resizable: false,
	                modal: true
	            });

	            $(".ui-dialog-titlebar").hide();

	        });
	    </script>

	<style>
		.category-option {
			/* padding: 10px; */
			border-radius: 15px;
			margin-right: 15px;
			margin-left: 15px;
		}

		.category-option fieldset {
			border: 1px solid silver !important;
		}
		.category-option legend {
			width: 150px;
			padding: 2px;
			margin-left: calc(15% - 55px - 8px);
			margin-bottom: 2px;
			font-size: 14px;
			font-weight: bold;
		}
		.category-fields{
			padding-right: 15px;
			padding-left: 15px;
		}

		.category-fields .form-group-sm select.form-control {
			height: 25px !important;
			padding: 5px !important;
			line-height: 30px;
		}

		.attendance-process fieldset legend {
			margin-bottom: 6px !important;
		}
	</style>

</head>
<body bgcolor="#ECE9D8">
<div align="center" style=" margin:0 auto; width:1000px; min-height:555px; overflow:hidden;">
<div class="form-group" style="float:left; overflow:hidden; width:65%; height:auto; padding:10px;">
	<form name="grid" target="_blank">

		<?php
			$this->load->model('common_model');
			$unit = $this->common_model->get_unit_id_name();
		?>
		<div class="row category-option">
			<fieldset>
				<legend>Category Options</legend>
				<div class="row category-fields">
					<div class="col-md-6 form-inline">
						<div class="form-group form-group-sm">
							<label class="control-label">Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </label>
							<?php
								$this->load->model('common_model');
								$unit = $this->common_model->get_unit_id_name();
								$units = $unit->result();
							?>
							<select class="form-control" name='grid_start' id='grid_start' style="width:180px;" onchange='grid_get_all_data()' />
								<option value='Select'>	Select	</option>
								<?php foreach($unit->result() as $rows) { ?>
										<option value="<?php echo $rows->unit_id; ?>"><?php echo $rows->unit_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6 form-inline">
						<div class="form-group form-group-sm">
							<label class="control-label">Dept. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </label>
							<select class="form-control" id='grid_dept' name='grid_dept' style="width:180px;" onChange="grid_all_search()"><option value=''></option></select>
						</div>
					</div>

					<div class="col-md-6 form-inline" style="padding-top:6px">
						<div class="form-group form-group-sm">
							<label class="control-label">Section &nbsp;:&nbsp; </label>
							<select class="form-control" id='grid_section' name='grid_section' style="width:180px;" onChange="grid_all_search()"><option value=''></option></select>
						</div>
					</div>
					<div class="col-md-6 form-inline" style="padding-top:6px">
						<div class="form-group form-group-sm">
							<label class="control-label">Line &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </label>
							<select class="form-control" id='grid_line' name='grid_line' style="width:180px;" onChange="grid_all_search()"><option value=''></option></select>
						</div>
					</div>

					<div class="col-md-6 form-inline" style="padding-top:6px">
						<div class="form-group form-group-sm">
							<label class="control-label">Desig. &nbsp;&nbsp;&nbsp;:&nbsp;</label>
							<select class="form-control" id='grid_desig' name='grid_desig' style="width:180px;" onChange="grid_all_search()"><option value=''></option></select>
						</div>
					</div>
					<div class="col-md-6 form-inline" style="padding-top:6px">
						<div class="form-group form-group-sm">
							<label class="control-label">Sex &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;</label>
							<select class="form-control" id='grid_sex' name='grid_sex' style="width:180px;" onChange="grid_all_search()"><option value=''></option></select></select>
						</div>
					</div>

					<div class="col-md-6 form-inline" style="padding-top:6px; padding-bottom:10px">
						<div class="form-group form-group-sm">
							<label class="control-label">Status &nbsp;&nbsp;&nbsp;:&nbsp; </label>
							<select class="form-control" id='grid_status' name='grid_status' style="width:180px;" onChange="grid_all_search()"><option value=''></option></select>
						</div>
					</div>
					<div class="col-md-6 form-inline" style="padding-top:6px; padding-bottom:10px">
						<div class="form-group form-group-sm">
							<label class="control-label">Position :&nbsp; </label>
							<select class="form-control" id='grid_position' name='grid_position' style="width:180px;" onChange="grid_all_search()"><option value=''></option></select>
						</div>
					</div>
				</div>
			</fieldset>
		</div>

		<br>
		<div class="attendance-process">
			<!-- <fieldset style='width:95%;'><legend><font size='+1'><b>Category Options</b></font></legend>
			<table>
			<tr>
			<td>Unit</td>
			<td>:</td>
			<td><select class="form-control" name='grid_start' id='grid_start' style="width:250px;" onchange='grid_get_all_data()' />
					<option value='Select'>	Select	</option>
					<?php foreach($unit->result() as $rows) { ?>
							<option value="<?php echo $rows->unit_id; ?>"><?php echo $rows->unit_name; ?></option>
					<?php } ?>
				</select>
			</td>
			<td>Dept. </td><td>:</td><td><select class="form-control" id='grid_dept' name='grid_dept' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>
			</tr>
			<tr><td>Section </td><td>:</td><td><select class="form-control" id='grid_section' name='grid_section' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>
			<td>Line </td><td>:</td><td><select class="form-control" id='grid_line' name='grid_line' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>
			</tr>
			<tr><td>Desig. </td><td>:</td><td><select class="form-control" id='grid_desig' name='grid_desig' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>
			<td>Sex </td><td>:</td><td><select class="form-control" id='grid_sex' name='grid_sex' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></select></td>
			</tr>
			<tr><td>Status</td><td>:</td><td><select class="form-control" id='grid_status' name='grid_status' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>
				<td>Position</td><td>:</td><td><select class="form-control" id='grid_position' name='grid_position' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td> -->

			<!--<td>Gen. Rpt</td><td>:</td><td><select class="form-control" id='general_report' name='general_report' style="width:250px;"><option value='1'>With Image</option><option value='2'>Without Image</option></select></td>-->
			<!-- </tr>
			</table>
			</fieldset> -->

			<fieldset style='width:600px;'><legend><font size='+1'><b>Attendance Process</b></font></legend>
				<table>
					<tr>
						<div class="col-md-8 form-inline col-md-offset-2">
							<div class="form-group form-group-sm">
								<label class="control-label">Select Date : </label>
								<input class="form-control" type='text' name='startdate' id='p_start_date' style="width:120px;">
								<span>
									<script language="JavaScript">
										var o_cal = new tcal ({
											// form name
											'formname': 'grid',
											// input name
											'controlname': 'p_start_date'
										});
										o_cal.a_tpl.yearscroll = false;
										o_cal.a_tpl.weekstart = 6;

										</script>
								</span>
								&nbsp;&nbsp;<input class="btn btn-primary" type='button' name='view' onclick='attendance_process()' value='Process'/>
							</div>
						</div>
					</tr>
						<!-- <tr>
						<td style="font-weight:bold">Select Date</td><td style="font-weight:bold">:</td>
						<td><input class="form-control" type='text' name='startdate' id='p_start_date' style="width:173px;">
						<script language="JavaScript">
							var o_cal = new tcal ({
								// form name
								'formname': 'grid',
								// input name
								'controlname': 'p_start_date'
							});
							o_cal.a_tpl.yearscroll = false;
							o_cal.a_tpl.weekstart = 6;

							</script><td style="width: 10px;"></td>
							<td><input class="btn btn-primary" type='button' name='view' onclick='attendance_process()' value='Process'/></td>
						</tr> -->

				</table>
			</fieldset>
		</div>
	</form>

	<br>
		<!-- <div class="attendance-process">
			<fieldset class="attendance-process" style='width:600px;'><legend align="center"><font size='+1'><b>Monthly Attendance Process</b></font></legend>
				<form name="gird">
					<table>
						<tr>
							<div class="col-md-8 form-inline col-md-offset-2">
								<div class="form-group form-group-sm">
									<label class="control-label"> Select Date : </label>
									<input class="form-control" type='text' name='startdate' id='p_start_date_m' style="width:120px;">
									<span>
										<script language="JavaScript">
											var o_cal = new tcal({
												'formname': 'gird',
												'controlname': 'p_start_date_m'
											});

											// individual template parameters can be modified via the calendar variable
											o_cal.a_tpl.yearscroll = false;
											o_cal.a_tpl.weekstart = 6;

										</script>
									</span>
									&nbsp;&nbsp;<input class="btn btn-primary" type='button' name='view' onclick='attn_process_month()' value='Process'/>
								</div>
							</div>
						</tr>
					</table> -->
					<!-- <table>
						<tr>
						<td style="font-weight:bold">Select Date(Will Process Month)</td><td style="font-weight:bold">:</td>
						<td><input class="form-control" type='text' name='startdate' id='p_start_date_m' style="width:173px;">
						<script language="JavaScript">
							var o_cal = new tcal({
								'formname': 'gird',
								'controlname': 'p_start_date_m'
							});

							// individual template parameters can be modified via the calendar variable
							o_cal.a_tpl.yearscroll = false;
							o_cal.a_tpl.weekstart = 6;

							</script>
						</td><td style="width: 10px;"></td>
						<td><input class="btn btn-primary" type='button' name='view' onclick='attn_process_month()' value='Process'/></td>
						</tr>
					</table> -->
				<!-- </form>
			</fieldset>
		</div> -->
</div>

<div style="float:right; width: 35%;">
<table id="list1" style="font-family: 'Times New Roman', Times, serif; font-size:15px;">
	<tr><td></td></tr>
</table>
</div>
<div id="loader"  align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;">
	<img src="<?php echo base_url();?>/images/ajax-loader.gif" />
</div>
<div id="viewid"></div>
</div>
</div>
</body>
</html>

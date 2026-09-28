<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MSH Payroll Reports</title>

  <?php $base_url = base_url();
    $base_url = base_url();

	?>
	 <link href="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.min.css') ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo base_url('/assets/bootstrap/js/bootstrap.js') ?>"></script>

    <script src="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $base_url; ?>themes/redmond/jquery-ui-1.8.2.custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $base_url; ?>themes/ui.jqgrid.css" />
	 <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $base_url; ?>css/calendar.css" />

	<script type="text/javascript" src="<?php echo $base_url; ?>js/jquery.min.js"></script>
	<script src="<?php echo $base_url; ?>js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/earn_leave.js"></script>
	<script src="<?php echo $base_url; ?>js/calendar_eu.js" type="text/javascript"></script>
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

		.category-options {
			/* padding: 10px; */
			border-radius: 15px;
			margin-right: 15px;
			margin-left: 15px;
			margin-top: 10px;
		}

		.category-options fieldset {
			border: 1px solid silver !important;
		}
		.category-options legend {
			width: 180px;
			padding: 2px;
			margin-left: calc(15% - 55px - 8px);
			margin-bottom: 2px;
			font-size: 16px;
			font-weight: bold;
		}
		.category-fields{
			padding-right: 15px;
			padding-left: 15px;
		}

		.category-options tr td select.form-control {
			height: 30px !important;
			padding: 5px !important;
			line-height: 30px;
            margin-top: 8px;
		}

		/* report  option */
		.report-option {
			border-radius: 15px;
			margin-right: 0px;
			margin-left: 10px;
			margin-top: 0px;
		}
        .btn {
                margin-bottom: 5px !important;
        }

	</style>
</head>
<body bgcolor="#ECE9D8">
<div class="form-group" align="center" style=" margin:0 auto; width:1000px; min-height:555px; overflow:hidden;">
<div class="form-group" style="float:left; overflow:hidden; width:65%; height:auto; padding:10px;">
<form name="grid">
<div>

<!-- <fieldset style='width:95%;'><legend><font size='+1'><b>Month & Year</b></font></legend>
<?php $this->load->view('year_earn_leave_report'); ?>
<br /><br />
</fieldset> -->

    <div class="row select-date" align="left">
        <div class="col-md-6 form-inline " style="margin-bottom: 10px;">
            <div class="form-group form-group-sm">
				<span>First Date</span>
				<input class="form-control" type="text" name="firstdate" id="firstdate" style="width:100px;"/>
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
        <div class="col-md-6 form-inline">
            <div class="form-group form-group-sm">
				<span>Second Date</span>
				<input class="form-control" type="text" name="seconddate" id="seconddate" style="width:100px;"/>
				<span>
					<script language="JavaScript">
						var o_cal = new tcal ({
							// form name
							'formname': 'grid',
							// input name
							'controlname': 'seconddate'
						});

						// individual template parameters can be modified via the calendar variable
						o_cal.a_tpl.yearscroll = false;
						o_cal.a_tpl.weekstart = 6;

					</script>
				</span>
            </div>
        </div>
    </div>

<!-- 	<fieldset style='width:95%;'><legend><font size='+1'><b>Date</b></font></legend>
	<table class="table">
	<tr>
	<td>First Date </td><td>:</td><td> <input class="form-control" type="text" name="firstdate" id="firstdate" style="width:100px;"/></td>
	<td>
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
	</td>
	<td>TO Second Date</td><td>:</td><td> <input class="form-control" type="text" name="seconddate" id="seconddate" style="width:100px;"/></td>
	<td>
	<script language="JavaScript">
		var o_cal = new tcal ({
			// form name
			'formname': 'grid',
			// input name
			'controlname': 'seconddate'
		});

		// individual template parameters can be modified via the calendar variable
		o_cal.a_tpl.yearscroll = false;
		o_cal.a_tpl.weekstart = 6;

		</script>
	</td>
	<td><?php $this->load->view('year_earn_leave_report'); ?></td>
	</tr>
	</table>

	</fieldset> -->



</div>
<br />
	<?php
		$this->load->model('common_model');
		$unit = $this->common_model->get_unit_id_name();
	?>
	<div class="row category-options">
		<fieldset ><legend><font size='+1'><b>Category Options</b></font></legend>
			<table>
			<tr>
			<!--<td>Start</td><td>:</td><td><select class="form-control" name='grid_start' id='grid_start' style="width:250px;" onchange='grid_get_all_data_for_salary()' /><option value='Select'>Select</option><option value='all'>ALL</option></select></td>-->
			<td>Unit</td>
			<td>:</td>
			<td><select class="form-control" name='grid_start' id='grid_start' style="width:250px;" onchange='get_all_data()' />
							<option value='Select'>	Select	</option>
							<?php foreach($unit->result() as $rows) { ?>
									<option value="<?php echo $rows->unit_id; ?>"><?php echo $rows->unit_name; ?></option>
							<?php } ?>
						</select></td>
			<td>Dept. </td><td>:</td><td><select class="form-control" id='grid_dept' name='grid_dept' style="width:250px;" onChange="all_search()"><option value=''></option></select></td>
			</tr>
			<tr><td>Section </td><td>:</td><td><select class="form-control" id='grid_section' name='grid_section' style="width:250px;" onChange="all_search()"><option value=''></option></select></td>
			<td>Line </td><td>:</td><td><select class="form-control" id='grid_line' name='grid_line' style="width:250px;" onChange="all_search()"><option value=''></option></select></td>
			</tr>
			<tr><td>Desig. </td><td>:</td><td><select class="form-control" id='grid_desig' name='grid_desig' style="width:250px;" onChange="all_search()"><option value=''></option></select></td>
			<td>Sex </td><td>:</td><td><select class="form-control" id='grid_sex' name='grid_sex' style="width:250px;" onChange="all_search()"><option value=''></option></select></select></td>
			</tr>
			<tr><td>Status</td><td>:</td><td><select class="form-control" id='grid_status' name='grid_status' style="width:250px;" onChange="all_search()"><option value=''></option></select></td>

			</tr>
			</table>
		</fieldset>
	</div>
<div>
<br />

<fieldset style='width:95%;'><legend><font size='+1'><b>Earn Leave Reports</b></font></legend>
<table width="100%"  style="font-size:11px; ">
<tr>
<td style="width:20%;"><input class="btn btn-primary" type="button" style="width:96%; font-size:100%;" value="Earn Leave Payment Sheet" onClick="grid_earn_leave_payment_buyer()"></td>

<?php
$user_id = $this->acl_model->get_user_id($this->session->userdata('username'));
$acl     = $this->acl_model->get_acl_list($user_id);
if(!in_array(10,$acl))
{
?>
<td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Actual Earn Leave Payment Sheet" onClick="grid_earn_leave_general_info()"></td>

<!-- <td style="width:20%; background-color: #666666;"><input class="btn btn-primary" type="button" style=" width:100%; font-size:100%;"  value="Earn Leave Summery Sheet" onClick="grid_earn_leave_summery()"></td> -->
<?php } ?>

</tr>

</table>

</fieldset>
<br />
</div>

</form>

</div>
<div style="float:right;">
<table id="list1" style="font-family: 'Times New Roman', Times, serif; font-size:15px;"><tr><td></td></tr></table>
</div>
<!--<div id="pager1"></div>-->

<div id="viewid"></div>
<div class="clearfix" style="display:none;">
    <div class="loading"><img src="<?php echo base_url() ?>img/load.gif"  alt="Load"/></div>
    <div style="margin-top:50px;"> Processing Please Wait..... </div>
  </div>
</body>
</html>

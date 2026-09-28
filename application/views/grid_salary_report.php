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

	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $base_url; ?>themes/redmond/jquery-ui-1.8.2.custom.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $base_url; ?>themes/ui.jqgrid.css" />
	 <link rel="stylesheet" type="text/css" media="all" href="<?php echo $base_url; ?>css/calendar.css" />
	<script type="text/javascript" src="<?php echo base_url();?>js/earn_leave.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>js/grid_content.js" type="text/javascript"></script>
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
<div class="form-group" align="center" style=" margin:0 auto; width:100%; min-height:600px; overflow:hidden;">
<div class="form-group" style="float:left; overflow:hidden; width:67%; height:auto; padding:10px;">
<form name="grid">
        <!-- Date, Month & Year  -->
    <div class="row select-date" align="left">
        <div class="col-md-8 form-inline col-md-offset-2" style="margin-bottom: 10px;">
            <div class="form-group form-group-sm">
                <?php $this->load->view('month_year_salary_report'); ?>
            </div>
        </div>
        <div class="col-md-8 form-inline col-md-offset-2">
            <div class="form-group form-group-sm">
                <!-- <span class="control-label">Custom Salary Date : </span>
                <input class="form-control" type="text" name="salarydate" id="salarydate" style="width:100px;"/> -->
                <!-- <span>
                    <script language="JavaScript">
                        var o_cal = new tcal ({
                            'formname': 'grid',
                            'controlname': 'salarydate'
                        });
                        o_cal.a_tpl.yearscroll = false;
                        o_cal.a_tpl.weekstart = 6;
                    </script>
                </span> -->
            </div>
        </div>
    </div>

     <!-- <div>
            <fieldset><legend><font size='+1'><b>Month & Year</b></font></legend>
            < ?php  $this->load->view('month_year_salary_report'); ?>
            <br /><br />
            <td>Custom Salary Date </td><td>:</td><td> <input class="form-control" type="text" name="salarydate" id="salarydate" style="width:100px;"/></td>
            <td>
                <script language="JavaScript">
                var o_cal = new tcal ({
                    // form name
                    'formname': 'grid',
                    // input name
                    'controlname': 'salarydate'
                });

                // individual template parameters can be modified via the calendar variable
                o_cal.a_tpl.yearscroll = false;
                o_cal.a_tpl.weekstart = 6;

                </script>
            </td>
            </fieldset>
        </div> -->
        <!-- Category option -->
    <?php
		$this->load->model('common_model');
		$unit = $this->common_model->get_unit_id_name();
	?>
    <div class="row category-options">
        <fieldset ><legend><font size='+1'><b>Category Optionssss</b></font></legend>
            <table>
            <tr>
            <!--<td>Start</td><td>:</td><td><select class="form-control" name='grid_start' id='grid_start' style="width:250px;" onchange='grid_get_all_data_for_salary()' /><option value='Select'>Select</option><option value='all'>ALL</option></select></td>-->
            <td>Unit</td>
            <td>:</td>
            <td><select class="form-control" name='grid_start' id='grid_start' style="width:220px;" onchange='grid_get_all_data_for_salary()' />
                            <option value='Select'>	Select	</option>
                            <?php foreach($unit->result() as $rows) { ?>
                                    <option value="<?php echo $rows->unit_id; ?>"><?php echo $rows->unit_name; ?></option>
                            <?php } ?>
                        </select></td>
            <td>Dept. </td><td>:</td><td><select class="form-control" id='grid_dept' name='grid_dept' style="width:220px;" onChange="grid_all_search_for_salary()"><option value=''></option></select></td>
            </tr>
            <tr><td>Section </td><td>:</td><td><select class="form-control" id='grid_section' name='grid_section' style="width:220px;" onChange="grid_all_search_for_salary()"><option value=''></option></select></td>
            <td>Line </td><td>:</td><td><select class="form-control" id='grid_line' name='grid_line' style="width:220px;" onChange="grid_all_search_for_salary()"><option value=''></option></select></td>
            </tr>
            <tr><td>Desig. </td><td>:</td><td><select class="form-control" id='grid_desig' name='grid_desig' style="width:220px;" onChange="grid_all_search_for_salary()"><option value=''></option></select></td>
            <td>Sex </td><td>:</td><td><select class="form-control" id='grid_sex' name='grid_sex' style="width:220px;" onChange="grid_all_search_for_salary()"><option value=''></option></select></select></td>
            </tr>
            <tr><td>Status</td><td>:</td><td><select class="form-control" id='grid_status' name='grid_status' style="width:220px;" onChange="grid_all_search_for_salary()"><option value=''></option></select></td>

            <td>Type</td><td>:</td><td><select class="form-control" id='grid_w_type' name='grid_w_type' style="width:220px;" onChange="grid_all_search_for_salary()"><option value=''></option></select></td>
            </tr>
            <tr>
                <td>Position</td><td>:</td><td><select class="form-control" id='grid_position' name='grid_position' style="width:220px;" onChange="grid_all_search_for_salary()"><option value=''></option></select></td>

            <!--<td>Gen. Rpt</td><td>:</td><td><select class="form-control" id='general_report' name='general_report' style="width:250px;"><option value='1'>With Image</option><option value='2'>Without Image</option></select></td>-->
            </tr>
            </table>
            <br>
        </fieldset>
    </div>
    <div>
        <br />
        <?php
        $usr_arr = array(3,7,8);
        $usr_arr_2 = array(6);
        $usr_arr_3 = array(11);
        $usr_arr_4 = array(6,11);
        $user_id = $this->acl_model->get_user_id($this->session->userdata('username'));
        $acl     = $this->acl_model->get_acl_list($user_id);
        ?>
        <fieldset style='width:95%;'><legend style="margin-bottom: 5px"><font size='+1'><b>Salary Reports</b></font></legend>
            <table width="100%"  style="font-size:11px; ">
                <tr>
                    <?php if(!in_array($user_id,$usr_arr_3)){ ?>
                    <!-- <td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Montly Salary Sheet" onClick="grid_monthly_salary_sheet()"></td> -->
                    <td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Montly Salary Sheet" onClick="monthly_salary_sheet()"></td>
                    <?php } ?>

                    <?php if(!in_array($user_id,$usr_arr_3)){  ?>
                    <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" value="Pay Slip" onClick="grid_pay_slip()"></td>
                    <?php } ?>

                    <?php if(!in_array($user_id,$usr_arr_4)){  ?>
                    <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" name='view' onclick='sal_summary_report()' value='Actual Salary Summary'/></td>
                    <?php } ?>

                    <?php if(!in_array($user_id,$usr_arr_4)){  ?>
                    <td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" name='view' onclick='sec_sal_summary_report()' value='Sec Wise Salary Summary '/></td>
                    <!-- <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Montly Bank Req." onClick="grid_bank_note_req()"></td> -->
                    <?php } ?>
                </tr>

                <tr>
                    <?php if(!in_array($user_id,$usr_arr_4)){ ?>
                    <!-- <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Actual Salary Sheet" onClick="grid_actual_monthly_salary_sheet()"></td> -->
                    <td style="width:20%;"><input class="btn btn-primary" type="button" style="width:96%; font-size:100%;" value="Actual Salary Sheet" onClick="actual_monthly_salary_sheet()"></td>

                    <!-- <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" value="Pay Slip Actual" onClick="grid_pay_slip_non_compliance()"></td> -->

                    <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" value="Pay Slip Actual" onClick="grid_pay_slip_actual()"></td>
                    <?php } ?>

                    <?php if(!in_array($user_id,$usr_arr_2)){  ?>
                    <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Salary Sheet BFL" onClick="grid_mix_salary_sheet()"></td>
                    <?php } ?>

                    <?php if(!in_array($user_id,$usr_arr_4)){ ?>
                    <td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Act. Monthly Sal. Sheet EOT" onClick="grid_actual_monthly_salary_sheet_with_eot()"></td>
                    <?php } ?>
                </tr>

                <tr>
                <?php if(!in_array($user_id,$usr_arr_4)){  ?>
                <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Salary Sheet" onClick="monthly_salary_sheet_nine_pm()"></td>
                <!-- <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Actual Salary Sheet Without Sec." onClick="grid_actual_monthly_salary_sheet_not_sec()"></td> -->
                <?php } ?>

                <?php if(!in_array($user_id,$usr_arr_2)){  ?>
                <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" value="Pay Slip" onClick="grid_pay_slip_com()"></td>
                <!-- <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" value="Pay Slip BFL" onClick="grid_pay_slip_com_non_com_mix()"></td> -->
                <?php } ?>

                <?php if(!in_array($user_id,$usr_arr_4)){  ?>
                <td style="width:20%;"><input class="btn btn-primary" type="button" style="width:96%; font-size:100%;" value=" Actual Salary Summary" onClick="salary_summary_test()"></td>
                    <!-- <td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Salary Summary" onClick="salary_summary_compliance()"></td> -->
                <?php } ?>
                </tr>

                <tr>
                <?php /* if(!in_array(10,$acl)){ ?>
                <?php /* if(!in_array(14,$acl)){ ?>
                <?php if(!in_array($user_id,$usr_arr_2)){  ?>
                <td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Monthly Allowance Sheet" onClick="grid_monthly_allowance_sheet()"></td>
                <td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" name='view' onclick='grid_monthly_weekend_allowance_sheet()' value='Weekend Allowance Report'/></td>
                <td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Act. Monthly Sal. Sheet EOT" onClick="grid_actual_monthly_salary_sheet_with_eot()"></td>
                <?php } ?>
                <?php } */ ?>

                </tr>

                <tr>
                <!--<td style="width:20%;"><input class="btn btn-primary" type="button" style=" width:100%; font-size:100%;"  value="Monthly Night Allowance Sheet" onClick="grid_monthly_night_allowance_sheet()"></td>-->
                <?php /* if(!in_array($user_id,$usr_arr_2)){  ?>

                <td style="width:20%;"><input class="btn btn-primary" type="button" style="width:96%; font-size:100%;" value="Monthly EOT Sheets" onClick="grid_monthly_eot_sheet()"></td>

                <td style="width:20%;;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" name='view' onclick='eot_summary_report()' value='EOT Summary Report'/></td>

                <td style="width:20%;;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" name='view' onclick='eot_summary_report_sec()' value='EOT Summary Report(Sec)'/></td>

                <!-- <td style="width:20%;"><input class="btn btn-primary" type="button" style="width:96%; font-size:100%;" value="Stop Salary Sheet" onClick="grid_monthly_stop_sheet()"></td> -->

                <?php } ?>
                <?php } */ ?>
                <!-- <td style="width:20%;"></td> -->
                </tr>
            </table>

        </fieldset>
        <br />
        <fieldset style='width:95%;'><legend style="margin-bottom: 5px"><font size='+1'><b>Others Benefit Report</b></font></legend>
            <table width="100%"  style="font-size:11px; ">
                <tr>
                <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Festival Bonus" onClick="grid_festival_bonus()"></td>
                <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Fest. Bonus Summary" onClick="grid_festival_bonus_summary()"></td>
                <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Fest. Bonus Summary(Sec)" onClick="grid_festival_bonus_summary_sec_wise()"></td>

                <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Advance Salary Sheet" onClick="grid_advance_salary_sheet()"></td>
                </tr>
                <tr>
                    <?php if(!in_array(10,$acl)){ ?>
                    <?php if(!in_array(14,$acl)){ ?>

                    <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;" value="Comparative Statement" onClick="grid_comprative_salary_statement()">
                    </td>

                    <?php } ?>
                    <?php } ?>
                    <td style="width:25%;"><input class="btn btn-primary" type="button" style=" width:96%; font-size:100%;"  value="Maternity Benefit Report" onClick="grid_maternity_benefit()"></td>
                </tr>
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
<div class="clearfix" style="display:none;">
    <div class="loading"><img src="<?php echo base_url() ?>img/load.gif"  alt="Load"/></div>
    <div style="margin-top:50px;"> Processing Please Wait..... </div>
  </div>
</div>
</body>
</html>

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
    <script type="text/javascript" src="<?php echo base_url();?>js/dynamic.js"></script>
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
			font-size: 16px;
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
<div class="form-group" style="float:left; overflow:hidden; width:67%; height:auto; padding:10px;">
<form name="grid">

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
                        <select class="form-control" name='grid_start' id='grid_start' style="width:200px;" onchange='grid_get_all_data()' />
                            <option value='Select'> Select  </option>
                            <?php foreach($unit->result() as $rows) { ?>
                                    <option value="<?php echo $rows->unit_id; ?>"><?php echo $rows->unit_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 form-inline">
                    <div class="form-group form-group-sm">
                        <label class="control-label">Dept. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </label>
                        <select class="form-control" id='grid_dept' name='grid_dept' style="width:200px;" onChange="grid_all_search()"><option value=''></option></select>
                    </div>
                </div>

                <div class="col-md-6 form-inline" style="padding-top:6px">
                    <div class="form-group form-group-sm">
                        <label class="control-label">Section &nbsp;:&nbsp; </label>
                        <select class="form-control" id='grid_section' name='grid_section' style="width:200px;" onChange="grid_all_search()"><option value=''></option></select>
                    </div>
                </div>
                <div class="col-md-6 form-inline" style="padding-top:6px">
                    <div class="form-group form-group-sm">
                        <label class="control-label">Line &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </label>
                        <select class="form-control" id='grid_line' name='grid_line' style="width:200px;" onChange="grid_all_search()"><option value=''></option></select>
                    </div>
                </div>

                <div class="col-md-6 form-inline" style="padding-top:6px">
                    <div class="form-group form-group-sm">
                        <label class="control-label">Desig. &nbsp;&nbsp;&nbsp;:&nbsp;</label>
                        <select class="form-control" id='grid_desig' name='grid_desig' style="width:200px;" onChange="grid_all_search()"><option value=''></option></select>
                    </div>
                </div>
                <div class="col-md-6 form-inline" style="padding-top:6px">
                    <div class="form-group form-group-sm">
                        <label class="control-label">Sex &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;</label>
                        <select class="form-control" id='grid_sex' name='grid_sex' style="width:200px;" onChange="grid_all_search()"><option value=''></option></select></select>
                    </div>
                </div>

                <div class="col-md-6 form-inline" style="padding-top:6px; padding-bottom:10px">
                    <div class="form-group form-group-sm">
                        <label class="control-label">Status &nbsp;&nbsp;&nbsp;:&nbsp; </label>
                        <select class="form-control" id='grid_status' name='grid_status' style="width:200px;" onChange="grid_all_search()"><option value=''></option></select>
                    </div>
                </div>
                <div class="col-md-6 form-inline" style="padding-top:6px; padding-bottom:10px">
                    <div class="form-group form-group-sm">
                        <label class="control-label">Position :&nbsp; </label>
                        <select class="form-control" id='grid_position' name='grid_position' style="width:200px;" onChange="grid_all_search()"><option value=''></option></select>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <br>
    <div class="attendance-process">
        <fieldset style='width:88%;margin-left: 15px;'><legend><font size='+1'><b>Earn Leave Process</b></font></legend>

		<?php 
			$this->load->view('month_year');
			$earn_leave_process = "1";
			$final_earn_leave_process = "2";
	    ?>
		<br/>
		<br/>
	<span style="margin-left: 150px;">
				<input class="btn btn-primary" type='button' name='view' onclick='earn_leave_process(<?php echo $earn_leave_process; ?>)' value='Process'/>
				&nbsp;&nbsp;&nbsp;
				<input class="btn btn-primary" type='button' name='view' onclick='earn_leave_process(<?php echo $final_earn_leave_process; ?>)' value='Final Process'/>
	</span>
		</fieldset>
    </div>
</form>
</div>

<div style="float:right; width: 33%;">
<table id="list1" style="font-family: 'Times New Roman', Times, serif; font-size:15px;"><tr><td></td></tr></table>
</div>


<div id="viewid"></div>
<div id="loader"  align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;"><img src="<?php echo base_url();?>/images/ajax-loader.gif" /></div>
</div>
</body>
</html>


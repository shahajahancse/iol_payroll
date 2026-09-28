<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MSH Payroll Reports</title>
	
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>themes/redmond/jquery-ui-1.8.2.custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>themes/ui.jqgrid.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/calendar.css"/>

    <link href="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.min.css') ?>">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="<?php echo base_url('/assets/bootstrap/js/bootstrap.js') ?>"></script>
	
	<script src="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
		
		
	<script src="<?php echo base_url(); ?>js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/calendar_eu.js" type="text/javascript"></script>
	<script>
    $(function(){
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

</head>
<body bgcolor="#ECE9D8">
<div>
<div class="container" align="center" style=" margin:0 auto; width:2000px; min-height:555px; overflow:hidden;">
<div style="float:left; overflow:hidden; width:65%; height:auto; padding:10px;">
<form name="grid" target="_blank">
<?php 
	$this->load->model('common_model'); 
	$unit = $this->common_model->get_unit_id_name();
?>
<div class="form-group">
<fieldset><legend><font size='+1'><b>Category Options</b></font></legend>
<table class="table">
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
<td>Line </td><td>:</td><td><select class="form-control id='grid_line' name='grid_line' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>
</tr>
<tr><td>Desig. </td><td>:</td><td><select class="form-control" id='grid_desig' name='grid_desig' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>
<td>Sex </td><td>:</td><td><select class="form-control id='grid_sex' name='grid_sex' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></select></td>
</tr>
<tr><td>Status</td><td>:</td><td><select class="form-controlct  id='grid_status' name='grid_status' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>
	<td>Position</td><td>:</td><td><select class="form-control id='grid_position' name='grid_position' style="width:250px;" onChange="grid_all_search()"><option value=''></option></select></td>

</tr>
</table>

<div>

<fieldset style='width:95%;'><legend><font size='+1'><b>Date</b></font></legend>
<table>
<tr>
<td><p>Please Select Date</p> </td><td>:</td><td> <input class="form-group" type="text" name="firstdate" id="firstdate" style="width:100px;"/></td>
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
<td  style='text-align-last: center;'>
	<input class="btn btn-primary" type='button' name='btn' id='btn' onclick='delete_shift_log_info()' value='Delete Data' size='15'>
</td>

</tr>
<tr><td></td></tr>
<tr>
	<?php 
		$this->db->select('date');
		$query = $this->db->get('setup_auto_date');
		$row = $query->row();
		$date_now = $row->date;
	?>
	<!-- <td style="text-align: center;background: gray;padding:5px;color:#fff;"><?php echo $date_now;?></td> -->
</tr>
</table>
</fieldset>
 </div>

</div>

</form>

</div>
<div class="form-group" style="float:right;">
<table id="list1" style="font-family: 'Times New Roman', Times, serif; font-size:15px;"><tr><td></td></tr></table>
</div>
<!--<div id="pager1"></div>-->

<div id="viewid"></div>

<div class="clearfix" style="display:none;">
    <div class="loading" style="text-align-last: center;"><img src="<?php echo base_url() ?>img/load.gif"  alt="Load"/></div>
    <div style="margin-top:50px; text-align-last: center;"> Processing Please Wait..... </div>
</div>
</div>
</div>
</div>	
</body>
</html>
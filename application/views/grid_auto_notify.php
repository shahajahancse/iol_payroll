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
<div align="center" style=" margin:0 auto; width:1200px; min-height:555px; overflow:hidden;">
<div style="float:left; overflow:hidden; width:65%; height:auto; padding:10px;">
<form name="grid" target="_blank">
<div>

<fieldset style='width:95%;'><legend><font size='+1'><b>Date</b></font></legend>
<table class="table">
	<tr>
		<td>Please Select Date &nbsp;&nbsp; : </td>
		<td>
			<input class="form-control" type="text" name="firstdate" id="firstdate" style="width:120px; margin-right: -35px;"/>
		</td>
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
		<td style='text-align-last: center;'>
			<input class="btn btn-primary btn-sm" type='button' name='btn' id='btn' onclick='save_date()' value='Insert Date' size='15'>
		</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
	</tr>
<tr><td></td></tr>
<tr>
	<?php
		$this->db->select('date');
		$query = $this->db->get('setup_auto_date');
		$row = $query->row();
		$date_now = $row->date;
	?>
	<td style="text-align: center;background: gray;padding:5px;color:#fff;"><?php echo $date_now;?></td>
</tr>
</table>
</fieldset>
 </div>
<br/>
<?php
	$this->load->model('common_model');
	$unit = $this->common_model->get_unit_id_name();
?>
<div>
</div>
<div>
<br />
<?php
	$usr_arr = array(3,7,8);
	$user_id = $this->acl_model->get_user_id($this->session->userdata('username'));
	$acl = $this->acl_model->get_acl_list($user_id);
?>


<?php
	// $date = date('Y-m-d');

	$date = $date_now;
	$cformat = date('Y-m-d',strtotime($date));
	$cy = substr($cformat,0,4);
	$cm = substr($cformat,5,2);
	$cd = substr($cformat,8,2);
	$f_date = date("Y-m-d", mktime(0, 0, 0, $cm, 1, $cy));
	$s_date = date('Y-m-d',strtotime('6 days',strtotime($f_date)));
	$sStartDate = $f_date;
	$sEndDate = $s_date;

	$this->db->select('*');
	$this->db->from('pr_emp_shift_log');
	$this->db->where('pr_emp_shift_log.shift_log_date',$sEndDate);
	//$this->db->where('pr_emp_shift_log.shift_log_date <=',$sEndDate);
	$this->db->where('tot_sts',1);
	$query = $this->db->get();
	// echo $this->db->last_query();
	foreach($query->result() as $row){
		$all_grid_id[] = $row->emp_id;
	}

	$count_id = $all_grid_id;
	$all_grid_id = implode('***', $all_grid_id);

	//End the first week

	$cformat_2 = date('Y-m-d',strtotime($date));
	$cy_2 = substr($cformat_2,0,4);
	$cm_2 = substr($cformat_2,5,2);
	$cd_2 = substr($cformat_2,8,2);

	$f_date_2 = date("Y-m-d", mktime(0, 0, 0, $cm_2, 1, $cy_2));
	$f_date_2 = date('Y-m-d',strtotime('7 days',strtotime($f_date_2)));

	$s_date_2 = date('Y-m-d',strtotime('6 days',strtotime($f_date_2)));
	$sStartDate_2 = $f_date_2;
	$sEndDate_2 = $s_date_2;

	$this->db->select('*');
	$this->db->from('pr_emp_shift_log');
	$this->db->where('pr_emp_shift_log.shift_log_date',$sEndDate_2);
	$this->db->where('tot_sts_2',1);
	$query_2 = $this->db->get();
	// echo $this->db->last_query();
	foreach($query_2->result() as $row_2){
		$all_grid_id_2[] = $row_2->emp_id;
	}

	$count_id_2 = $all_grid_id_2;
	$all_grid_id_2 = implode('***', $all_grid_id_2);

	//End the second week

	$cformat_3 = date('Y-m-d',strtotime($date));
	$cy_3 = substr($cformat_3,0,4);
	$cm_3 = substr($cformat_3,5,2);
	$cd_3 = substr($cformat_3,8,2);

	$f_date_3 = date("Y-m-d", mktime(0, 0, 0, $cm_3, 1, $cy_3));
	$f_date_3 = date('Y-m-d',strtotime('14 days',strtotime($f_date_3)));

	$s_date_3 = date('Y-m-d',strtotime('6 days',strtotime($f_date_3)));
	$sStartDate_3 = $f_date_3;
	$sEndDate_3 = $s_date_3;

	$this->db->select('*');
	$this->db->from('pr_emp_shift_log');
	$this->db->where('pr_emp_shift_log.shift_log_date',$sEndDate_3);
	$this->db->where('tot_sts_3',1);
	$query_3 = $this->db->get();
	foreach($query_3->result() as $row_3){
		$all_grid_id_3[] = $row_3->emp_id;
	}

	$count_id_3 = $all_grid_id_3;
	$all_grid_id_3 = implode('***', $all_grid_id_3);

	//End the third week

	$cformat_4 = date('Y-m-d',strtotime($date));
	$cy_4 = substr($cformat_4,0,4);
	$cm_4 = substr($cformat_4,5,2);
	$cd_4 = substr($cformat_4,8,2);

	$f_date_4 = date("Y-m-d", mktime(0, 0, 0, $cm_4, 1, $cy_4));
	$f_date_4 = date('Y-m-d',strtotime('21 days',strtotime($f_date_4)));

	$last_d_4 = date("t", mktime(0, 0, 0, $cm_4, $cd_4, $cy_4));
	$d_4 = $last_d_4 - 22 ;
	$s_date_4 = date('Y-m-d',strtotime($d_4 .'days',strtotime($f_date_4)));
	$sStartDate_4 = $f_date_4;
	$sEndDate_4 = $s_date_4;

	$this->db->select('*');
	$this->db->from('pr_emp_shift_log');
	$this->db->where('pr_emp_shift_log.shift_log_date',$sEndDate_4);
	$this->db->where('tot_sts_4',1);
	$query_4 = $this->db->get();
	foreach($query_4->result() as $row_4){
		$all_grid_id_4[] = $row_4->emp_id;
	}

	$count_id_4 = $all_grid_id_4;
	$all_grid_id_4 = implode('***', $all_grid_id_4);

  ?>

<fieldset style='width:95%;'><legend><font size='+1'><b>Auto Weekly Reports</b></font></legend>
<table class="table" width="100%"  style="font-size:11px; ">
<tr>
<input type="hidden" id="date" name="date" value="<?php echo $date;?>">
<input type="hidden" id="grid_emp_id" name="grid_emp_id" value="<?php echo $all_grid_id;?>">
<input type="hidden" id="grid_emp_id_2" name="grid_emp_id_2" value="<?php echo $all_grid_id_2;?>">
<input type="hidden" id="grid_emp_id_3" name="grid_emp_id_3" value="<?php echo $all_grid_id_3;?>">
<input type="hidden" id="grid_emp_id_4" name="grid_emp_id_4" value="<?php echo $all_grid_id_4;?>">

<?php
 if($count_id==0){ ?>
 	<td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Auto Notify For FW (<?php echo count($count_id);?>)" onClick="grid_auto_notify_FW()"></td>
 <?php } elseif($count_id>0){ ?>
 	<td style="width:20%; background-color:red;color:red;font-size: 12px;"><input  class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Auto Notify For FW(<?php echo count($count_id);?>)" onClick="grid_auto_notify_FW()"></td>
<?php } ?>

<?php
 if($count_id_2==0){ ?>
 	<td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Auto Notify For SW (<?php echo count($count_id_2);?>)" onClick="grid_auto_notify_SW()"></td>
 <?php } elseif($count_id_2>0){ ?>
 	<td style="width:20%; background-color:red;color:red;font-size: 12px;"><input  class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Auto Notify For SW(<?php echo count($count_id_2);?>)" onClick="grid_auto_notify_SW()"></td>
<?php } ?>

<?php
 if($count_id_3==0){ ?>
 	<td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Auto Notify For TW (<?php echo count($count_id_3);?>)" onClick="grid_auto_notify_TW()"></td>
 <?php } elseif($count_id_3>0){ ?>
 	<td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Auto Notify For TW(<?php echo count($count_id_3);?>)" onClick="grid_auto_notify_TW()"></td>
<?php } ?>

<?php
 if($count_id_4==0){ ?>
 	<td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Auto Notify For LW (<?php echo count($count_id_4);?>)" onClick="grid_auto_notify_LW()"></td>
 <?php } elseif($count_id_4>0){ ?>
 	<td style="width:20%;"><input class="btn btn-primary" type="button" style="width:100%; font-size:100%;" value="Auto Notify For LW(<?php echo count($count_id_4);?>)" onClick="grid_auto_notify_LW()"></td>
<?php } ?>
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
    <div class="loading" style="text-align-last: center;"><img src="<?php echo base_url() ?>img/load.gif"  alt="Load"/></div>
    <div style="margin-top:50px; text-align-last: center;"> Processing Please Wait..... </div>
</div>
</div>
</div>
</body>
</html>

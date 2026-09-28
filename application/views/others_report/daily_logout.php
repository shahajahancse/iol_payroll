<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/SingleRow.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/table.css" />
</head>
<body>
<?php // print_r($values); ?>
<div style=" margin:0 auto;  width:auto;">
<div id="no_print" style="float:right;">
</div>
<?php 
$data['unit_id'] = $unit_id;
$this->load->view("head_english",$data);
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:13px; font-weight:bold;">
<?php echo $title; ?> Wise Manpower Summary <?php echo $report_date; ?></span>
<br />
<br />
<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px; width:950px;">
  <tr>
  <tr>
    <th width="30">SL</th>
    <th width="120"><?php echo $category; ?> Name</th>
    <th width="50">T.P</th>
    <th width="50">>05 PM</th>
    <th width="50">05 PM</th>
    <th width="50">06 PM</th>
    <th width="50">07 PM</th>
    <th width="50">08 PM</th>
    <th width="50">09 PM</th>
    <th width="50">10 PM</th>
	<th width="50">11 PM</th>
	<th width="50">12 PM</th>
	<th width="50">01 AM</th>
	<th width="50">02 AM</th>
	<th width="50">03 AM</th>
	<th width="50">04 AM</th>
	<th width="50">05 AM</th>
    <th width="80">P.Error</th>
    <th width="80">TTL O.T</th>
    <th width="80">Remarks</th>
  </tr>

    <?php 
		$total_ot_eot_hour = 0;
		$total_time_1=0;  
		$total_time_2=0;
		$total_time_3=0;  
		$total_time_4=0;
		$total_time_5=0;  
		$total_time_6=0;
		$total_time_7=0;  
		$total_time_8=0;
		$total_time_9=0;  
		$total_time_10=0;
		$total_time_11=0;  
		$total_time_12=0;
		$total_time_13=0; 
		$total_time_14=0; 
		$i = 1; 
		$query = $this->db->select()->where('unit_id', $unit_id)->order_by('line_name')->get('pr_line_num');
		
		$total_present = 0;
		$total_present_error = 0;
		foreach($query->result() as $rows)
		{
			$data['cat_name'][] = $rows->line_name;
			$line_id 			= $rows->line_id;
			echo "<tr>";
			echo "<td align='center'>$i</td>";
			echo "<td align='center'>$rows->line_name</td>";
			$all_emp_present_linewise = $this->mars_model->get_emp_present_linewise($line_id, $unit_id, $report_date);
				
			echo "<td align='center'>".$all_emp_present_linewise['emp_id_present']."</td>";
				
			
		$total_ot_hour = 0;
		$j = 1;
		$query2 = $this->db->select()->order_by('id')->get('pr_logout_emp');
			foreach($query2->result() as $row)
			{
								
				$first_time		=$row->first_time;
				$secoend_time	=$row->secoend_time;
			
				$all_emp_with_ot = $this->mars_model->get_line_emp_logout($line_id, $unit_id, $report_date, $first_time, $secoend_time);
				
				
				echo "<td align='center'>".$all_emp_with_ot['emp_id']."</td>";
				
				if($j == 1)
				{
					$total_time_1 = $total_time_1 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 2)
				{
					$total_time_2 = $total_time_2 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 3)
				{
					$total_time_3 = $total_time_3 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 4)
				{
					$total_time_4 = $total_time_4 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 5)
				{
					$total_time_5 = $total_time_5 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 6)
				{
					$total_time_6 = $total_time_6 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 7)
				{
					$total_time_7 = $total_time_7 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 8)
				{
					$total_time_8 = $total_time_8 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 9)
				{
					$total_time_9 = $total_time_9 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 10)
				{
					$total_time_10 = $total_time_10 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 11)
				{
					$total_time_11 = $total_time_11 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 12)
				{
					$total_time_12 = $total_time_12 + $all_emp_with_ot['emp_id'];
				}
				else if($j == 13)
				{
					$total_time_13 = $total_time_13 + $all_emp_with_ot['emp_id'];
				}
				
				else if($j == 14)
				{
					$total_time_14 = $total_time_14 + $all_emp_with_ot['emp_id'];
				}
				
				//$total_time = '$total_time_'.$j;
				//$total_time = $total_time + $all_emp_with_ot['emp_id'];
				$j = $j + 1;
				//echo "<td align='center'>".$all_emp_with_ot['ot_hour']."</td>";	
				$total_ot_hour = ($total_ot_hour + ($all_emp_with_ot['ot_hour']+ $all_emp_with_ot['extra_ot_hour']));
			
			}
			$all_emp_present_error= $this->mars_model->get_all_emp_present_error($line_id, $unit_id, $report_date);
				
			echo "<td align='center'>".$all_emp_present_error['emp_id_present_error']."</td>";
			
			echo "<td align='center'>$total_ot_hour</td>";
			echo "<td></td>";
			echo " </tr>";
			
			$total_ot_eot_hour = $total_ot_eot_hour + $total_ot_hour;
			$i = $i + 1;
			
			$total_present 			= $total_present + $all_emp_present_linewise['emp_id_present'];
			$total_present_error 	= $total_present_error + $all_emp_present_error['emp_id_present_error'];
			
		}
	

?>

<tr>
    <th colspan="2"> Grand Total =</th>
	<th><?php echo $total_present; ?></th>
	<th><?php echo $total_time_1; ?></th>
	<th><?php echo $total_time_2; ?></th>
	<th><?php echo $total_time_3 ?></th>
	<th><?php echo $total_time_4; ?></th>
	<th><?php echo $total_time_5; ?></th>
	<th><?php echo $total_time_6; ?></th>
	<th><?php echo $total_time_7; ?></th>
	<th><?php echo $total_time_8; ?></th>
	<th><?php echo $total_time_9; ?></th>
	<th><?php echo $total_time_10; ?></th>
	<th><?php echo $total_time_11; ?></th>
	<th><?php echo $total_time_12; ?></th>
	<th><?php echo $total_time_13; ?></th>
	<th><?php echo $total_time_14; ?></th>
    <th><?php echo $total_present_error; ?></th>
    <th><?php echo $total_ot_eot_hour; ?></th>
    <th></th>
   
  </tr>
</table>
</div>
</div>
</body>
</html>

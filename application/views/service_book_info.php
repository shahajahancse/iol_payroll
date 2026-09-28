<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
	Employee Information
</title>

<style>
		.bordered {
    border: 2px solid black;
    border-collapse: collapse;
	font-size:12px;
	border-radius:3px;
	
}
.bordered td, .bordered th {
    border: 1px solid #ffff;
	
}
.bordered th {
   background: #C9C9C9;
}
.bordered tr:nth-of-type(odd) {
    background-color: #F7F7F7;
}
 
.bordered tr:hover {
    background: #C9C9C9;
    -o-transition: all 0.1s ease-in-out;
    -webkit-transition: all 0.1s ease-in-out;
    -moz-transition: all 0.1s ease-in-out;
    -ms-transition: all 0.1s ease-in-out;
    transition: all 0.1s ease-in-out;     
}
	.emp_info{
		background:#DFDFFF;
	}
.service tr:nth-child(even) {background: #BFBF7F}
.service tr:nth-child(odd) {background: #BFDF7F}	


</style>

</head>

<body style="width:750px;">
<?php $row_count=count($values["emp_id"]); 

for($i=0;$i < $row_count;$i++)
{

?>
<div style="height: 980px;margin-bottom: 50px; ">
<table align="left" border='0' bordercolor='#000000' cellspacing='0' cellpadding='0' style="text-align:center; width: 100%;">
<tr style=" font-size:22px; font-weight: bold;">
	<td width="600px;">
		<?php  echo $unit_name = $this->db->where("unit_id",$unit_id)->get('pr_units')->row()->unit_name;?>
	</td>
	
	
	<td  rowspan="4" width="55px;">
		<img border="1" src="<?php echo base_url();?>uploads/photo/<?php  echo isset($values['img_source'][$i])?$values['img_source'][$i]:"";?>" height="120px;" />

	</td>
	
</tr>
<tr>
	<td style=" font-size:18px; text-decoration: underline; font-style: italic;letter-spacing: 2px; font-weight: bold;">Service Book Information</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>


<table  align="left" border='0' cellspacing='2' cellpadding='4' style="text-align:left; border-collapse:collapse;border: 1px solid;width: 100%; padding: 10px;">
<tr style=" font-size:15px; font-weight: bold; margin: 3px;">
	<td colspan="4" >
	
	</td>
	</tr>
<tr style=" font-size:15px; font-weight: bold; margin: 3px;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		ID NO.:
	</td>
	
	<td width="7px;">
		
	</td>
	
	<td style="background: #DFDFFF">
		<?php echo isset($values["emp_id"][$i])?$values["emp_id"][$i]:"";?>
	</td>
	<td width="7px;">
		
	</td>
</tr>
<tr height="12px"></tr>

<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Employee Name
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["emp_name"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Father Name
	</td>
		<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["emp_fname"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Mother Name
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["emp_mname"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Designation
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["desig_name"][$i];?>
	</td>
</tr>

<tr height="12px"></tr>
<tr style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Section
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["sec_name"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Line
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["line_name"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Date of Birth
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php 
		
		$dob = $values["emp_dob"][$i];
		$date_of_birth = date("Y-m-d", strtotime($values["emp_dob"][$i]));
		
		$curent_date = date("Y-m-d");

		echo $date_of_birth; 
		
		?>
	</td>
</tr>
<tr height="12px"></tr>
<tr style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Date of Join
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $doj = date("Y-m-d", strtotime($values["doj"][$i]));?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Age
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php 
		$date1 = date_create($date_of_birth);
		$date2 = date_create($curent_date);
		
		$diff12 = date_diff($date1, $date2);
		$days = $diff12->d;
		$months = $diff12->m;
		$years = $diff12->y;
		echo $years.' Years '.$months.' Months and '.$days.' Days';
		?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Job Duration
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php 
		$doj = date("Y-m-d", strtotime($values["doj"][$i]));
		$current_date = date("Y-m-d");
		$date1 = date_create($doj);
		$date2 = date_create($curent_date);
		
		$diff12 = date_diff($date2, $date1);
		$days = $diff12->d;
		$months = $diff12->m;
		$years = $diff12->y;
		echo $years.' Years '.$months.' Months and '.$days.' Days';
		?>
	</td>
</tr>
<tr height="12px"></tr>

<tr style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Religion
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["religion_name"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Sex
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["emp_sex"][$i]==1 ?"Male": "Female";?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Marital Status
	</td>
	<td>
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["marrital_status"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr style=" font-size:15px; font-weight: bold;">
<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Blood Group
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["blood_name"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Permanent Address
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php
		//dd($values);
		echo $values["emp_par_add"][$i];?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Present Address
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $values["emp_pre_add"][$i];?>
	</td>
</tr>
<tr height="20px;">
	<td colspan="3"></td>
</tr>
</table>
<?php
$emp_id = $values["emp_id"][$i];
$query = $this->db->select()->where('ref_id', $emp_id)->get('pr_incre_prom_pun');
$num_rows = $query->num_rows();
?>

<table class="service" align="left" border='0' bordercolor='#000000' cellspacing='5' cellpadding='2' style="text-align:center; width: 100%; margin-top:20px;">
<tr  style="font-size:15px; font-weight: bold; text-align: center;">
	<td colspan="9" style="background: #FF7F7F">
		Service Book
	</td>
</tr>
<tr  style=" font-size:15px; font-weight: bold; background:#BFBFFF;">
	<th> SI </th>
    <th> Service Status </th>
    <th> Effective Date</th>
    <th> Dept </th>
    <th> Section </th>
    <th> Line </th>
    <th> Designation </th>
    <th> Inc. Amt. </th>
    <th> Salary </th>
    
</tr>
<?php if($num_rows == 0 ){ ?>
<tr> 
	<td> 1 </td>
    <td> Joinning </td>
    <td> <?php echo date("d-M-Y",strtotime($values["doj"][$i]));?> </td>
    <td> <?php echo $values["dept_name"][$i];?> </td>
    <td> <?php echo $values["sec_name"][$i];?> </td>
    <td> <?php echo $values["line_name"][$i];?> </td>
    <td> <?php echo $values["desig_name"][$i];?> </td>
    <td> <?php echo "0";?> </td>
    <td> <?php echo $values["gross_sal"][$i];?> </td>
</tr>
<?php }else{ ?>

<?php $k = 1; foreach($query->result() as $rows){ ?>
<?php if($k==1){ ?>
<tr> 
	<td> <?php echo $k; ?> </td>
    <td> Joinning </td>
    <td> <?php echo date("d-M-Y",strtotime($values["doj"][$i]));?> </td>
    <td> <?php echo $this->common_model->get_dept_name($rows->prev_dept);?> </td>
    <td> <?php echo $this->common_model->get_section_name($rows->prev_section);?> </td>
    <td> <?php echo $this->common_model->get_line_name($rows->prev_line);?> </td>
    <td> <?php echo $this->common_model->get_desig_name($rows->prev_desig);?> </td>
    <td> <?php echo "0";//$this->common_model->get_grade_name($rows->prev_grade);?> </td>
    <td> <?php echo $rows->prev_salary;?> </td>
</tr>
<?php }$k++; ?>
<tr> 
	<td> <?php echo $k; ?> </td>
    <td> <?php if($rows->status==1){echo 'Increment';}else{echo 'Promotion';}?> </td>
    <td> <?php echo date("d-M-Y",strtotime($rows->effective_month));?> </td>
    <td> <?php echo $this->common_model->get_dept_name($rows->new_dept);?> </td>
    <td> <?php echo $this->common_model->get_section_name($rows->new_section);?> </td>
    <td> <?php echo $this->common_model->get_line_name($rows->new_line);?> </td>
    <td> <?php echo $this->common_model->get_desig_name($rows->new_desig);?> </td>
    <td> <?php echo $rows->new_salary-$rows->prev_salary;//$this->common_model->get_grade_name($rows->new_grade);?> </td>
    <td> <?php echo $rows->new_salary;?> </td>
</tr>
<?php } } ?>
</table>

<div style="border: 1px solid #000;">
<table align="center" border="1" style=" width:740px; border-collapse:collapse; height:150px; margin-bottom:20px;">
<tr>
<td colspan="10" align="center" style="font-weight:bold; background:#DFDFFF;">Attendance Status</td>
  </tr>
  <tr style="text-align:center;">
    <td colspan="4" style="font-weight:bold;background:#B6B6B6;">Leave Status</td>
    <td colspan="4" style="font-weight:bold;background:#B6B6B6;">Present Status</td>
    <td colspan="1" style="font-weight:bold;background:#B6B6B6;">Total</td>
  </tr>
  <tr>
  <td style="text-align:center; font-weight:bold;background:#BFBFFF;">CL</td>
  <td style="text-align:center; font-weight:bold;background:#BFBFFF;">SL</td>
  <td style="text-align:center; font-weight:bold;background:#BFBFFF;">EL</td>
  <td style="text-align:center; font-weight:bold;background:#BFBFFF;">ML</td>
  <td style="text-align:center; font-weight:bold;background:#BFBFFF;">P</td>
  <td style="text-align:center; font-weight:bold;background:#BFBFFF;">A</td>
  <td style="text-align:center; font-weight:bold;background:#BFBFFF;">H</td>
  <td style="text-align:center; font-weight:bold;background:#BFBFFF;">W</td>
  </tr>
  <tr>
  <?php 
$emp_id = $values["emp_id"][$i];
$start_date = date("Y-m-d",strtotime($values["doj"][$i]));
$end_date = $current_date;
$days_count1 = $this->common_model->days_count($emp_id,$start_date,$end_date, $present_status='P');
$days_count2 = $this->common_model->days_count($emp_id,$start_date,$end_date, $present_status='A');
$days_count3 = $this->common_model->days_count($emp_id,$start_date,$end_date, $present_status='H');
$days_count4 = $this->common_model->days_count($emp_id,$start_date,$end_date, $present_status='W');
$leave_count1 = $this->common_model->leave_count($emp_id,$start_date,$end_date, $leave_type='cl');
$leave_count2 = $this->common_model->leave_count($emp_id,$start_date,$end_date, $leave_type='sl');
$leave_count3 = $this->common_model->leave_count($emp_id,$start_date,$end_date, $leave_type='el');
$leave_count4 = $this->common_model->leave_count($emp_id,$start_date,$end_date, $leave_type='ml');
$total_days = $days_count1 + $days_count2 + $days_count3 + $days_count4 + $leave_count1 +  $leave_count2 + $leave_count3 + $leave_count4;?>
  <td style="text-align:center;"><?php echo $leave_count1;?></td>
  <td style="text-align:center;"><?php echo $leave_count2;?></td>
  <td style="text-align:center;"><?php echo $leave_count3;?></td>
  <td style="text-align:center;"><?php echo $leave_count4;?></td>
  <td style="text-align:center;"><?php echo $days_count1; ?></td>
  <td style="text-align:center;"><?php echo $days_count2; ?></td>
  <td style="text-align:center;"><?php echo $days_count3; ?></td>
  <td style="text-align:center;"><?php echo $days_count4; ?></td>
  <td style="text-align:center;"><?php echo $total_days;?></td>
  </tr>

</table></div>
</div>

<?php } exit; ?>
<br><br><br>
</body>
</html>
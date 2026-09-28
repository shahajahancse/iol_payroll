<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>

<?php 
	if($grid_status == 1)
	{ echo 'Reguler Employee '; }
	elseif($grid_status == 2)
	{ echo 'New Employee '; }
	elseif($grid_status == 3)
	{ echo 'Left Employee '; }
	elseif($grid_status == 4)
	{ echo 'Resign Employee '; }
	elseif($grid_status == 6)
	{ echo 'Promoted Employee '; }
?> Advance Salary Sheet of <?php ?>
</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style>
.bottom_txt_design{
	 border-top:1px solid;
	 width:170px;
	 font-weight:bold;
}
.bottom_txt_manager_design
{
	border-top:1px solid;
	 width:170px;
}
</style>

</head>

<body style="margin:0 2px;">

<?php 
$row_count=count($value);
if($row_count >8)
{
$page=ceil($row_count/8);
}
else
{
$page=1;
}

$k = 0;
	 $grand_total_basic_salary 		= 0;
	 $grand_total_house_rent 		= 0;
	 $grand_total_medical_allowance = 0;
	 $grand_total_conveyance		= 0;
	 $grand_total_food_allow		= 0;
	 $grand_total_gross_salary		= 0;
	 $grand_total_adv_deduct		= 0;
	 $grand_total_att_bonus			= 0;
	 $grand_total_late_deduction	= 0;
	 $grand_total_hd_deduct_amount	= 0;
	 $grand_total_abs_deduction		= 0;
	 $grand_total_stamp_deduct		= 0;
	 $grand_total_others_deduct		= 0;
	 $grand_total_ot_eot_amount		= 0;
	 $grand_total_ot_hour			= 0;
	 $grand_total_ot_amount			= 0;
	 $grand_total_net_pay			= 0;
	 $grand_total_holiday_allowance	= 0;
	 $grand_total_net_wages			= 0;
	 $grand_total_night_allowance	= 0;
	 $grand_total_tax_deduct		= 0;
	 $grand_total_wages_with_stamp	= 0;
			
		

for ( $counter = 1; $counter <= $page; $counter ++){
?>

<table height="auto"  class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:13px; width:13.6in; font-family:SutonnyMJ, SolaimanLipi; border-collapse:collapse;">

<tr height="85px">

<?php if($deduct_status == "Yes"){?> 
<td colspan="30" align="center">
<?php }else{ ?>
<td colspan="29" align="center">
<?php } ?>
<div style="width:100%; font-family:Arial, Helvetica, sans-serif;">
<div style="text-align:left; position:relative;padding-left:10px;width:20%; float:left; font-weight:bold;">
<table>
<?php 

$date = date('d-m-Y');
//$unit_name['unit_name'] = $this->db->where("unit_id",$grid_unit)->get('pr_units')->row()->unit_name;
$section_name = $value[0]->sec_name_en;
// dd($first_date);
$last_day = date("t", strtotime($first_date));
$dom = $last_day;//$value[0]->total_days;
echo "Section : $section_name<br>";
echo "DOM : $dom<br>";

//echo "Payment Date : $date"; ?>
</table>
</div>
 <div style="text-align:center; position:relative;padding-left:10px;width:50%; overflow:hidden; float:left; display:block;">
<?php //$emp_id = $value[0]->emp_id;

//$data['unit_id'] = $this->db->where("emp_id",$emp_id)->get('pr_emp_com_info')->row()->unit_id;
$this->load->view("head_english");?>
<?php 
	if($grid_status == 1)
	{ echo 'Reguler Employee '; }
	elseif($grid_status == 2)
	{ echo 'New Employee '; }
	elseif($grid_status == 3)
	{ echo 'Left Employee '; }
	elseif($grid_status == 4)
	{ echo 'Resign Employee '; }
	elseif($grid_status == 6)
	{ echo 'Promoted Employee '; }
echo '<span style="font-weight:bold;">';
echo "Advance Salary Sheet for the month of  ";
$sstartDate = date("d-M-Y", strtotime($first_date));
$sEndDate = date("d-M-Y", strtotime($last_date));
// dd($);
echo "&nbsp;$sstartDate To $sEndDate";//$date_format;
$sEndDate = date("d-M-Y", strtotime($last_date));
//MANUALLY DEFINE SALARY DAYS
$start = strtotime($first_date);
$end = strtotime($last_date);

$total_days = (ceil(abs($end - $start) / 86400)+1);
// dd($total_days);
echo '</span>';
?>
</div>
<div style="text-align:left; position:relative;padding-left:10px;width:20%; overflow:hidden; float:right; display:block; font-weight:bold">

<?php
echo "Page No # $counter of $page<br>";
echo "Payment Date : ";

?>

</div>


</div>
</td>
</tr>


  <tr height="20px">
    <td rowspan="2"  width="15" height="20px"><div align="center"><strong>নং</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>কার্ড নং</strong></div></td>
    <td rowspan="2" width="200" height="20px"><div align="center"><strong>নাম, পদবী, যোগদান, গ্রেড</strong></div></td>
	<td rowspan="2" width="50" height="20px"><div align="center"><strong>লাইন</strong></div></td>
   
    <td rowspan="2" width="20" height="20px"> <div align="center"><strong>মূল বেতন</strong></div></td>
    <td rowspan="2" width="17" height="20px"><div align="center"><strong>বাড়ী ভাড়া</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>চিকিৎসা ভাতা</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>যাতায়াত</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>খাদ্য ভাতা</strong></div></td>
    <td rowspan="2" width="35" height="20px"><div align="center"><strong>মোট বেতন</strong></div></td>
    <td colspan="3" width="30" height="20px"><div align="center"><strong>উপস্থিতি</strong></div></td>
	<td colspan="3" height="20px"><div align="center"><strong>ছুটি</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>পে ডে</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>নেট পে</strong></div></td>
	<td rowspan="2" width="25" height="20px"><div align="center"><strong>ওটি ঘণ্টা</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>ওটি রেট</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>ওটি টাকা</strong></div></td>

    <td rowspan="2" width="25" height="20px"><div align="center"><strong>প্রদেয় বেতন</strong></div></td>
    
	<td rowspan="2"  width="180"><div align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;গ্রহীতার স্বাক্ষর&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div></td>
  </tr>
  <tr height="10px">
  	<td width="15" style="font-size:8px;"><div align="center"><strong>হাজিরা</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>অফ ডে</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>অনুপুস্থিত</strong></div></td>
    
  	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>CL</strong></div></td>
	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>SL</strong></div></td>
    <!--<td width="15"><div align="center"><strong>F/L</strong></div></td>-->
	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>EL</strong></div></td>
	<!--<td width="15"><div align="center"><strong>M/L</strong></div></td>-->

    
   </tr>
<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) % 8;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=7;
   	}
  	
   $total_basic_salary 		= 0;
   $total_house_rent 		= 0;
   $total_medical_allowance = 0;
   $total_conveyance 		= 0;
   $total_food_allow		= 0;
   $total_gross_salary		= 0;
   $total_adv_deduct		= 0;
   $total_att_bonus			= 0;
   $total_hd_deduct_amount	= 0;
   $total_late_deduction	= 0;
   $total_abs_deduction		= 0;
   $total_stamp_deduct		= 0;
   $total_others_deduct		= 0;
   $total_ot_eot_amount		= 0;
   $total_ot_hour			= 0;
   $total_ot_amount         = 0;
   $total_net_pay			= 0;
   $total_holiday_allowance = 0;
   $total_net_wages			= 0;
   $total_night_allowance	= 0;
   $total_tax_deduct		= 0;
   $total_wages_with_stamp	= 0;
   
	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr height='70' style='text-align:center;' >";
		echo "<td >";
		echo $k+1;
		echo "</td>";
		
		echo "<td>";
		$emp_id = $value[$k]->emp_id;
		print_r($value[$k]->emp_id);
		echo "</td>";
		
		echo "<td  style='font-family:Arial, Helvetica, sans-serif; text-align:left; padding-left:5px;'>";
		echo "<span  style='font-weight:bold;'>";
		print_r($value[$k]->name_en);
		echo "</span>";
		echo '<br>';
		echo "<span  style='font-size:10px;'>";
		
		//print_r($value[$k]->emp_id);
		//echo '<br>';
		
		print_r($value[$k]->desig_name);
		echo '<br>';
		$date = $value[$k]->emp_join_date;
		$doj		= date('d-M-y', strtotime($date)); 
		$doj_check	= date('Y-m', strtotime($date)); 
		echo 'DOJ :'.$doj;
		echo '<br>';
		echo "GR: ";print_r ($value[$k]->gr_name);
		echo '<br>';

		if($grid_status == 4)
		{
			$resign_date = $this->Grid_model->get_resign_date_by_empid($value[$k]->emp_id);
			if($resign_date != false){
			echo "Resign : ".$resign_date = date('d-M-y', strtotime($resign_date));
			}
		}

		echo "</span>";
		echo "</td>"; 
				
		
		
			
		echo "<td style='font-family:arial; font-size:10px;'>";
		//$line_id = $value[$k]->line_id;
		echo $value[$k]->line_name_en;
		echo "</td>";
		
		$salary_structure = $this->common_model->salary_structure($value[$k]->gross_sal);

		
		echo "<td>";
		echo $basic_salary 			= $salary_structure['basic_sal'];
		$total_basic_salary 		= $total_basic_salary + $basic_salary;
		$grand_total_basic_salary 	= $grand_total_basic_salary + $basic_salary;
		echo "</td>";
		
		echo "<td>";
		echo $house_rent 		= $salary_structure['house_rent'];
		$total_house_rent 		= $total_house_rent + $house_rent;
		$grand_total_house_rent = $grand_total_house_rent + $house_rent;
		echo "</td>";
		
		echo "<td>";
		echo $medical_allow				= $salary_structure['medical_allow'];
		$total_medical_allowance 		= $total_medical_allowance + $medical_allow;
		$grand_total_medical_allowance 	= $grand_total_medical_allowance + $medical_allow;
		echo "</td>";

		
		echo "<td>";
		echo $trans_allow		= $salary_structure['trans_allow'];
		$total_conveyance 		= $total_conveyance + $trans_allow;
		$grand_total_conveyance	= $grand_total_conveyance + $trans_allow;
		echo "</td>";
		
		
		echo "<td>";
		echo $food_allow		= $salary_structure['food_allow'];
		$total_food_allow		= $total_food_allow + $food_allow;
		$grand_total_food_allow	= $grand_total_food_allow + $food_allow;
		echo "</td>";
		
		$gross_salary 				= $value[$k]->gross_sal;
		$total_gross_salary 		= $total_gross_salary + $gross_salary;
		$grand_total_gross_salary 	= $grand_total_gross_salary + $gross_salary;
		echo "<td>";
		echo $gross_salary;
		echo "</td>";

				// dd($first_date.'=='.$last_date);
		
		// $attend = "P";
		$attend = $this->salary_process_model->attendance_check($emp_id,$first_date,$last_date);
		// dd($attend);
		// $absent = "A";
		// $absent = $this->salary_process_model->attendance_check($emp_id,$first_date,$last_date);
		
		// $weeked = "W";
		// $weeked = $this->salary_process_model->attendance_check($emp_id,$first_date,$last_date);
		
		// $holiday = $this->salary_process_model->attendance_check($emp_id,$first_date,$last_date);
		$total_holiday = $attend->weekend +  $attend->holiday;
		$holiday_or_weeked = $total_holiday;
		$leave_type = "cl";
		$cas_leave = $this->salary_process_model->leave_db($emp_id, $first_date, $last_date, $leave_type);
		$leave_type = "sl";
		$sick_leave = $this->salary_process_model->leave_db($emp_id, $first_date, $last_date, $leave_type);
		$leave_type = "el";
		$earn_leave = $this->salary_process_model->leave_db($emp_id, $first_date, $last_date, $leave_type);
				
		$total_leave =  $cas_leave->cl + $sick_leave->sl + $earn_leave->el;
		$pay_days = $attend->attend + $total_holiday + $total_leave;
		
		
		echo "<td>";
		echo $attend->attend;
		echo "</td>";
		
		 
				
		echo "<td>";
		echo $total_holiday;
		echo "</td>"; 
		
		echo "<td>";
		echo $attend->absent;
		echo "</td>";
		
		echo "<td>";
		echo $cas_leave->cl;
		echo "</td>";
		
		echo "<td>";
		echo $sick_leave->sl;
		echo "</td>";
		
		echo "<td>";
		echo $earn_leave->el;
		echo "</td>";
				
		/*echo "<td>";
		print_r ($value[$k]->m_l);
		echo "</td>";*/
		
		echo "<td>";
		echo $pay_days;
		echo "</td>";
		
		$per_day_gross = $gross_salary/$last_day;
		// dd($per_day_gross);
		$net_wages = round($per_day_gross * $pay_days);
		$total_net_wages 		= $total_net_wages + $net_wages;
		$grand_total_net_wages 	= $grand_total_net_wages + $net_wages;
		
		echo "<td>";
		echo $net_wages;
		echo "</td>";
				
		$ot_rate = $salary_structure['ot_rate'];
		
			$ot_hour = 0;//$this->salary_process_model->ot_hour_between_date($emp_id,$first_date, $$last_date);
		
		echo "<td>";
		echo $ot_hour;
		echo "</td>";
		
		echo "<td>";
		echo $ot_rate;
		echo "</td>";
		
		echo "<td>";
		echo $ot_amount = round(($ot_hour * $ot_rate));	
		$total_ot_amount = $total_ot_amount + $ot_amount;
		$grand_total_ot_amount = $grand_total_ot_amount + $ot_amount;
		echo "</td>";
		
		$per_day_gross = $gross_salary/$last_day;

		$net_wages = $net_wages + $ot_amount;
		echo "<td>";
		// dd($ot_amount);
		echo $net_wages;
		echo "</td>";
		
		echo "<td>";
		echo "";
		echo "</td>";
		
		$k++;
	}
	?>
	<tr>
		<td align="center" colspan="4"><strong>প্রতি পৃষ্ঠার মোট </strong></td>
		<!--<?php if($deduct_status == "Yes"){?>
		<td colspan="4"></td>
		 <?php }else{ ?>
		 <td colspan="3"></td>
		 <?php } ?>-->
         <td align="right"><strong><?php echo $english_format_number = number_format($total_basic_salary);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_house_rent);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_medical_allowance);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_conveyance);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_food_allow);?></strong></td>
          <td align="right"><strong><?php echo $english_format_number = number_format($total_gross_salary);?></strong></td>
         <td align="right" colspan="7"></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_net_wages);?></strong></td>
         <td align="right" colspan="2"></td>
          <td align="right"><strong><?php echo $english_format_number = number_format($total_ot_amount);?></strong></td>
          <td align="right"><strong><?php echo $english_format_number = number_format($total_net_wages+ $total_ot_amount);?></strong></td>
      
       
        
	
    </tr>
	<?php
	if($counter == $page)
   		{?>
			<tr height="10">
            <?php //echo $deduct_status;?>
			<?php if($deduct_status == "Yes"){?>
			<td colspan="4" align="center">
			 <?php }else{ ?>
			 <td colspan="4" align="center">
			 <?php } ?>
			<strong>সর্বমোট বেতন</strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_basic_salary);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_house_rent);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_medical_allowance);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_conveyance);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_food_allow);?></strong></td>
             <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_gross_salary);?></strong></td>
         <td align="right" colspan="7"></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_net_wages);?></strong></td>
         <td align="right" colspan="2"></td>
            
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_ot_amount);?></strong></td>
            
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_net_wages+$grand_total_ot_amount);?></strong></td>
         
            
            </tr>
			<?php } ?>
			
			<table width="100%" height="80px" border="0" align="center" style="margin-bottom:85px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">
			<tr height="80%" >
			<td colspan="28"></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:15%;"><dt class="bottom_txt_design" >Prepared By</dt></td>
            <td align="center"  style="width:25%" ><dt class="bottom_txt_design" >Account Office / Executive</dt></td>
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >HR Manager</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >General Manager (GM)</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Director</dt></td>
			</tr>
			
			
			</table>
			</table>
			  
			<?php

		}

?>

</body>
</html>

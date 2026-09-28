<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
?>Monthly Salary Sheet of 
<?php 
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;

?>

</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style>
.bottom_txt_design
{
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

<body>

<?php 
$row_count=count($value);
if($row_count >7)
{
$page=ceil($row_count/7);
}
else
{
$page=1;
}

$k = 0;
	 $grand_total_basic_salary 		= 0;
	 $grand_total_house_rent 		= 0;
	 $grand_total_medical_allowance = 0;
	 $grand_total_gross_salary		= 0;
	 $grand_total_adv_deduct		= 0;
	 $grand_total_att_bonus			= 0;
	 $grand_total_late_deduction			= 0;
	 $grand_total_hd_deduct_amount	= 0;
	 $grand_total_abs_deduction		= 0;
	 $grand_total_stamp_deduct		= 0;
	 $grand_total_others_deduct		= 0;
	 $grand_total_ot_eot_amount		= 0;
	 $grand_total_net_pay			= 0;
	 $grand_total_holiday_allowance	= 0;
	 $grand_total_net_wages			= 0;
	 $grand_total_night_allowance	= 0;
	 $grand_total_tax_deduct		= 0;
			
		
?>
<table >

<?php
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>

<table height="auto"  class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:13px; width:auto;">

<tr height="85px">

<?php if($deduct_status == "Yes"){?> 
<td colspan="39" align="center">
<?php }else{ ?>
<td colspan="38" align="center">
<?php } ?>
<div style="width:100%">
<div style="text-align:left; position:relative;padding-left:10px;width:20%; float:left; font-weight:bold">
<table>
<?php 
$date = date('d-m-Y');
//$unit_name['unit_name'] = $this->db->where("unit_id",$grid_unit)->get('pr_units')->row()->unit_name;
$section_name = $value[0]->sec_name;
$dom = $value[0]->total_days;
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
?>Monthly Salary Sheet of 
<?php 
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;

?>
</div>
<div style="text-align:left; position:relative;padding-left:10px;width:20%; overflow:hidden; float:right; display:block; font-weight:bold">

<?php
echo "Page No # $counter of $page<br>";
echo "Payment Date : $date";
?>

</div>


</div>
</td>
</tr>


  <tr height="20px">
    <td rowspan="2"  width="15" height="20px"><div align="center"><strong>SI. No</strong></div></td>
    <td rowspan="2" colspan="6"  width="94" height="20px"><div align="center"><strong>Name of Employee</strong></div></td>
	<!--<td rowspan="2" width="14" height="20px"><div align="center"><strong>Card No</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>Designation</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>Joining Date</strong></div></td>-->
	<td rowspan="2" width="25" height="20px"><div align="center"><strong>Grade</strong></div></td>
    <td rowspan="2" width="20" height="20px"> <div align="center"><strong>Basic</strong></div></td>
    <td rowspan="2" width="17" height="20px"><div align="center"><strong>H/Rent</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>Medical Allowance </strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>Conveyance Allowance</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>Food Allowance</strong></div></td>
    <td rowspan="2" width="35" height="20px"><div align="center"><strong>Gross Salary</strong></div></td>
    <td colspan="4" width="30" height="20px"><div align="center"><strong>Present Status</strong></div></td>
	<td colspan="5" height="20px"><div align="center"><strong>Leave Status</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>Wor. Days</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>Pay Days</strong></div></td>
    <?php if($deduct_status == "Yes"){?> 
     <td colspan="7" height="20px"><div align="center"><strong>Deduction</strong></div></td>
	 <?php }else{ ?>
	  <td colspan="6" height="20px"><div align="center"><strong>Deduction</strong></div></td>
	  <?php } ?> 
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>Net Wages</strong></div></td>
    <td rowspan="2"  height="20px"><div align="center"><strong>Attn. Bonus</strong></div></td>
    <td colspan="3" height="20px"><div align="center"><strong>Over Time Status</strong></div></td>
    <td rowspan="2" width="22" height="20px"><div align="center"><strong>Net Pay Amount</strong></div></td>
	<td rowspan="2"  width="180"><div align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div></td>
  </tr>
  <tr height="10px">
  	<td width="15" style="font-size:8px;"><div align="center"><strong>P. Days</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>Off Days</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>Abs. Days</strong></div></td>
    <td width="15" style="font-size:8px;"><div align="center"><strong>B/A Abs. Days</strong></div></td>
  	<td width="15"><div align="center"><strong>C/L</strong></div></td>
	<td width="15"><div align="center"><strong>S/L</strong></div></td>
    <td width="15"><div align="center"><strong>F/L</strong></div></td>
	<td width="15"><div align="center"><strong>E/L</strong></div></td>
	<td width="15"><div align="center"><strong>M/L</strong></div></td>
	<td width="22"><div align="center"><strong>Adv.</strong></div></td>
	<?php if($deduct_status == "Yes"){?>
	<td width="37"><div align="center"><strong>HD Deduct</strong></div></td>
	<?php } ?>
    <td width="37" style="font-size:10px;"><div align="center"><strong>Abs. Deduct</strong></div></td>
    <td width="37"><div align="center"><strong>Late</strong></div></td>
    <td width="37"><div align="center"><strong>Othr.</strong></div></td>
    <td width="37"><div align="center"><strong>Tax</strong></div></td>
    <td width="37"><div align="center"><strong>St.</strong></div></td>
    
    <!--<td width="37"><div align="center"><strong>Attn. Bonus.</strong></div></td>
    <td width="37"><div align="center"><strong>H. day</strong></div></td>
    <td width="37"><div align="center"><strong>Night</strong></div></td>-->
    
    <td width="37"><div align="center"><strong>OT Hrs</strong></div></td>
    <td width="37"><div align="center"><strong>OT Rate</strong></div></td>
    <td width="37"><div align="center"><strong>OT Amt</strong></div></td>
    
   </tr>
<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) % 7;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=6;
   	}
  	
   $total_basic_salary 		= 0;
   $total_house_rent 		= 0;
   $total_medical_allowance = 0;
   $total_gross_salary		= 0;
   $total_adv_deduct		= 0;
   $total_att_bonus			= 0;
   $total_hd_deduct_amount	= 0;
   $total_late_deduction	= 0;
   $total_abs_deduction		= 0;
   $total_stamp_deduct		= 0;
   $total_others_deduct		= 0;
   $total_ot_eot_amount		= 0;
   $total_net_pay			= 0;
   $total_holiday_allowance = 0;
   $total_net_wages			= 0;
   $total_night_allowance	= 0;
   $total_tax_deduct		= 0;
   
	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr height='70' style='text-align:center;' >";
		echo "<td >";
		echo $k+1;
		echo "</td>";
		
		echo "<td colspan='6' >";
		print_r($value[$k]->emp_full_name);
		echo '<br>';
		if($grid_status == 4)
		{
			$resign_date = $this->grid_model->get_resign_date_by_empid($value[$k]->emp_id);
			if($resign_date != false){
			echo $resign_date = date('d-M-y', strtotime($resign_date));}
		}
		print_r($value[$k]->emp_id);
		echo '<br>';
		
		print_r($value[$k]->desig_name);
		echo '<br>';
		
		print_r($value[$k]->emp_join_date);
		
		echo "</td>"; 
		/*		
		echo "<td>";
		print_r($value[$k]->emp_id);
		echo "</td>";
				
		echo "<td>";
		print_r($value[$k]->desig_name);
		echo "</td>";
		
		/*echo "<td>";
		print_r($value[$k]->sec_name);
		echo "</td>";*/
				
		/*		
		echo "<td>";
		$date = $value[$k]->emp_join_date;
		$date_format		= date('d-M-y', strtotime($date)); 
		echo $date_format;
		echo "</td>";*/
			
		echo "<td>";
		print_r ($value[$k]->gr_name);
		echo "</td>";
			
		$basic_salary 				= $value[$k]->basic_sal;
		$total_basic_salary 		= $total_basic_salary + $basic_salary;
		$grand_total_basic_salary 	= $grand_total_basic_salary + $basic_salary;
		echo "<td>";
		echo $basic_salary;
		echo "</td>";
		
		$house_rent 			= $value[$k]->house_r;
		$total_house_rent 		= $total_house_rent + $house_rent;
		$grand_total_house_rent = $grand_total_house_rent + $house_rent;
		echo "<td>";
		echo $house_rent;
		echo "</td>";

		$medical_allowance 				= $value[$k]->medical_a;
		$total_medical_allowance 		= $total_medical_allowance + $medical_allowance;
		$grand_total_medical_allowance 	= $grand_total_medical_allowance + $medical_allowance;
		echo "<td>";
		echo $medical_allowance;
		echo "</td>";
		
		echo "<td>";
		echo $value[$k]->trans_allow;
		echo "</td>";
		
		
		echo "<td>";
		echo $value[$k]->food_allow;
		echo "</td>";
		
		$gross_salary 				= $value[$k]->gross_sal;
		$total_gross_salary 		= $total_gross_salary + $gross_salary;
		$grand_total_gross_salary 	= $grand_total_gross_salary + $gross_salary;
		echo "<td>";
		echo $gross_salary;
		echo "</td>";
		
	/*	echo "<td>";
		print_r ($value[$k]->total_days);
		//echo $row->total_days;
		echo "</td>";*/ 
		
		echo "<td>";
		print_r ($value[$k]->att_days);
		echo "</td>"; 
				
		echo "<td>";
		print_r ($value[$k]->weekend);
		echo "</td>"; 
		
		echo "<td>";
		print_r ($value[$k]->absent_days);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->before_after_absent);
		echo "</td>";
				
		echo "<td>";
		print_r ($value[$k]->c_l);
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->s_l);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->holiday);
		echo "</td>"; 
				
		echo "<td>";
		print_r ($value[$k]->e_l);
		echo "</td>";
				
		echo "<td>";
		print_r ($value[$k]->m_l);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->num_of_workday);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->pay_days);
		echo "</td>";
		
		
		$adv_deduct 				= $value[$k]->adv_deduct;
		$total_adv_deduct 			= $total_adv_deduct + $adv_deduct;
		$grand_total_adv_deduct 	= $grand_total_adv_deduct + $adv_deduct;
		echo "<td>";
		echo $adv_deduct;
		echo "</td>";
		
				
		if($deduct_status == "Yes")
		{
			$hd_deduct_amount 				= $value[$k]->hd_decuct_amount;
			$hd_hour 						= $value[$k]->count_hd_decuct;
			$total_hd_deduct_amount 		= $total_hd_deduct_amount + $hd_deduct_amount;
			$grand_total_hd_deduct_amount	= $grand_total_hd_deduct_amount + $hd_deduct_amount;
			echo "<td>";
			echo $hd_deduct_amount;
			echo "<br>($hd_hour)";
			echo "</td>";
		}
		
		$abs_deduction 				= $value[$k]->abs_deduction;
		$total_abs_deduction 		= $total_abs_deduction + $abs_deduction;
		$grand_total_abs_deduction 	= $grand_total_abs_deduction + $abs_deduction;
		echo "<td>";
		echo $abs_deduction;
		echo "</td>";
		
		$late_count 				= $value[$k]->late_count;
		$late_deduction 			= $value[$k]->late_deduct;
		$total_late_deduction 		= $total_late_deduction + $late_deduction;
		$grand_total_late_deduction = $grand_total_late_deduction + $late_deduction;
		echo "<td>";
		echo $late_deduction."<br>($late_count)";
		echo "</td>";
		
		$others_deduct 				= $value[$k]->others_deduct;
		$total_others_deduct 		= $total_others_deduct + $others_deduct;
		$grand_total_others_deduct 	= $grand_total_others_deduct + $others_deduct;
		echo "<td>";
		echo $others_deduct;
		echo "</td>";
		
		$tax_deduct 				= $value[$k]->tax_deduct;
		$total_tax_deduct 			= $total_tax_deduct + $tax_deduct;
		$grand_total_tax_deduct 	= $grand_total_tax_deduct + $tax_deduct;
		echo "<td>";
		echo $tax_deduct;
		echo "</td>";
		

		$stamp_deduct 				= $value[$k]->stamp;
		$total_stamp_deduct 		= $total_stamp_deduct + $stamp_deduct;
		$grand_total_stamp_deduct 	= $grand_total_stamp_deduct + $stamp_deduct;
		echo "<td>";
		echo $stamp_deduct;
		echo "</td>";
		
		$total_deduction		= $value[$k]->total_deduct;
		$net_wages 				= $gross_salary - $total_deduction;
		$total_net_wages 		= $total_net_wages + $net_wages;
		$grand_total_net_wages 	= $grand_total_net_wages + $net_wages;
		echo "<td>";
		echo $net_wages;
		echo "</td>";
		
		$att_bonus 					= $value[$k]->att_bonus;
		$total_att_bonus 			= $total_att_bonus + $att_bonus;
		$grand_total_att_bonus	 	= $grand_total_att_bonus + $att_bonus;
		echo "<td>";
		echo $att_bonus;
		echo "</td>";
		
		/*$holiday_alo_count 				= $value[$k]->holiday_alo_count;
		$holiday_allowance 				= $value[$k]->holiday_allowance;
		$total_holiday_allowance		= $total_holiday_allowance + $holiday_allowance;
		$grand_total_holiday_allowance	= $grand_total_holiday_allowance + $holiday_allowance;
		echo "<td>";
		echo $holiday_allowance;
		echo "<br>($holiday_alo_count)";
		echo "</td>";
		
		$night_alo_count  				= $value[$k]->night_alo_count;
		$night_allowance 				= $value[$k]->night_allowance;
		$total_night_allowance			= $total_night_allowance + $night_allowance;
		$grand_total_night_allowance	= $grand_total_night_allowance + $night_allowance;
		echo "<td>";
		echo $night_allowance;
		echo "<br>($night_alo_count)";
		//echo "<br>($first_tiffin_count + $second_tiffin_count)";
		echo "</td>";*/
				
		echo "<td>";
		print_r ($value[$k]->ot_hour);
	/*	echo '<br>+';
		echo '<br>';
		echo $value[$k]->eot_hour;
		echo '<br>=';
		echo '<br>';
		echo $ot_hour = $value[$k]->ot_hour +  $value[$k]->eot_hour; */
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->ot_rate);
		echo "</td>";
		
		$ot_amount 					= $value[$k]->ot_amount;	
		//$eot_amount 				= $value[$k]->eot_amount;
		$ot_eot_amount 				= $ot_amount;// + $eot_amount;
		$total_ot_eot_amount 		= $total_ot_eot_amount + $ot_eot_amount;
		$grand_total_ot_eot_amount 	= $grand_total_ot_eot_amount + $ot_eot_amount;
		echo "<td>";
		echo $ot_amount;
		echo "</td>";
		
		$net_pay 				= $value[$k]->net_pay ;//+ $eot_amount;
		$total_net_pay 			= $total_net_pay + $net_pay;
		$grand_total_net_pay 	= $grand_total_net_pay + $net_pay;
		echo "<td>";
		echo $net_pay;
		echo "</td>";
			
		echo "<td>";
		echo "&nbsp;|&nbsp;";
		echo "</td>";
			
		echo "</tr>"; 
		$k++;
	}
	?>
	<tr>
		<td align="center" colspan="13"><strong>Total Per Page</strong></td>
		<!--<?php if($deduct_status == "Yes"){?>
		<td colspan="4"></td>
		 <?php }else{ ?>
		 <td colspan="3"></td>
		 <?php } ?>-->
          <td align="right"><strong><?php echo $english_format_number = number_format($total_gross_salary);?></strong></td>
         <td align="right" colspan="11"></td>
          <td align="right"><strong><?php echo $english_format_number = number_format($total_adv_deduct);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_abs_deduction);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_late_deduction);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_others_deduct);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_tax_deduct);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_stamp_deduct);?></strong></td>
         
          <td align="right"><strong><?php echo $english_format_number = number_format($total_net_wages);?></strong></td>
          <td align="right"><strong><?php echo $english_format_number = number_format($total_att_bonus);?></strong></td>
         <!--<td align="right"><strong><?php echo $english_format_number = number_format($total_holiday_allowance);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_night_allowance);?></strong></td>-->
        <td align="right" colspan="2"></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_ot_eot_amount);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_net_pay);?></strong></td>
		
	</tr>
	<?php
	if($counter == $page)
   		{?>
			<tr height="10">
            <?php //echo $deduct_status;?>
			<?php if($deduct_status == "Yes"){?>
			<td colspan="12" align="center">
			 <?php }else{ ?>
			 <td colspan="13" align="center">
			 <?php } ?>
			<strong>Grand Total Amount Tk</strong></td>
             <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_gross_salary);?></strong></td>
         <td align="right" colspan="11"></td>
            
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_adv_deduct);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_abs_deduction);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_late_deduction);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_others_deduct);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_tax_deduct);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_stamp_deduct);?></strong></td>
            
            
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_net_wages);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_att_bonus);?></strong></td>
            <!--<td align="right"><strong><?php echo $english_format_number = number_format($grand_total_holiday_allowance);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_night_allowance);?></strong></td>-->
            <td align="right" colspan="2"></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_ot_eot_amount);?></strong></td>
			<td align="right"><strong><?php echo $english_format_number = number_format($grand_total_net_pay);?></strong></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="38">
					<?php $this->load->view("authorised_signature");?>
				</td>
			</tr>
			
		<!-- <table width="100%" height="80px" border="0" align="center" style="margin-bottom:85px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">
				<tr height="80%" >
					<td colspan="28"></td>
				</tr>
				<tr height="20%">
					<td  align="center" style="width:15%;"><dt class="bottom_txt_design" >Prepared By</dt></td>
		            <td align="center"  style="width:25%" ><dt class="bottom_txt_design" >Account Executive</dt></td>
					<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >HR Manager\ AGM</dt></td>
		            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >General Manager (GM)</dt></td>
		            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Director</dt></td>
				</tr>
			</table>
		</table> -->
			  
			<?php

		}

?>
</table>

</body>
</html>
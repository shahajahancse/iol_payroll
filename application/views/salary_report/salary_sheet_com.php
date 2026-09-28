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
.bottom_txt_design{
	 border-top:1px solid;
	 width:170px;
	 font-weight:bold;
}
.bottom_txt_manager_design{
	border-top:1px solid;
	 width:170px;
}
</style>

</head>

<body">

<?php 
// echo "<pre>";print_r($value);exit;
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
	 $grand_total_net_pay			= 0;
	 $grand_total_holiday_allowance	= 0;
	 $grand_total_net_wages			= 0;
	 $grand_total_night_allowance	= 0;
	 $grand_total_tax_deduct		= 0;
	 $grand_total_wages_with_stamp	= 0;
	 $grand_total_sum				= 0;

for ( $counter = 1; $counter <= $page; $counter ++){
?>

<table height="auto" class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:13px; width:13.5in; position: relative; font-family:SutonnyMJ, SolaimanLipi;">

<tr height="90px">
<td colspan="35" align="center">

<div style="width:90%; font-family:Arial, Helvetica, sans-serif;">
<?php 
	$date = $salary_month;
	$year=trim(substr($date,0,4));
	$month=trim(substr($date,5,2));
	$day=trim(substr($date,8,2));
	$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
	$salary_month_check = date("Y-m", mktime(0, 0, 0, $month, $day, $year));
?>
	<div style="text-align:left; position:relative;padding-left:10px;width:20%; float:left; font-weight:bold;">
	<?php 
		$date = date('d-m-Y');
		if(!empty($value[0]->sec_name)){
			$section_name = $value[0]->sec_name;
			echo "Section : $section_name<br>";
		}
		$dom = $value[0]->total_days;
		echo "DOM : $dom<br>";
	?>
	</div>
	<div style="text-align:center; position:relative;padding-left:10px;width:50%; float:left; display:block;">
		<?php 
			$this->load->view("head_english");
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
			echo "Salary/Wages & OT Wages Payment Sheet for the month of  ";
			
			echo $date_format;
			echo '</span>';
		?>
	</div>
	<div style="text-align:left; position:relative;padding-left:10px;width:20%; float:right; display:block; font-weight:bold">
		<?php
			echo "Page No # ".$counter." of ".$page."<br>";
			echo "Payment Date : ";
		?>
	</div>
</div>
</td>
</tr>


  <tr height="20px">
    <td rowspan="2"  width="15" height="20px"><div align="center"><strong>নং</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>কার্ড নং</strong></div></td>
    <td rowspan="2" colspan="6" width="94" height="20px"><div align="center"><strong>নাম, পদবী, যোগদান, গ্রেড</strong></div></td>
	<td rowspan="2" width="50" height="20px"><div align="center"><strong>লাইন</strong></div></td>
    <td rowspan="2" width="20" height="20px"> <div align="center"><strong>মূল বেতন</strong></div></td>
    <td rowspan="2" width="17" height="20px"><div align="center"><strong>বাড়ী ভাড়া</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>চিকিৎসা ভাতা</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>যাতায়াত ভাতা </strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>খাদ্য ভাতা</strong></div></td>
    <td rowspan="2" width="35" height="20px"><div align="center"><strong>মোট বেতন</strong></div></td>
    <td colspan="4" width="30" height="20px"><div align="center"><strong>উপস্থিতি</strong></div></td>
	<td colspan="4" height="20px"><div align="center"><strong>ছুটি</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>অনুস্পস্থিতি কর্তন</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>পে ডে</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>প্রদেয় বেতন</strong></div></td>
    <td rowspan="2"  height="20px"><div align="center"><strong>হাজিরা <br />বোনাস</strong></div></td>
        <td colspan="3" height="20px"><div align="center"><strong>ওভার টাইম</strong></div></td>

    <?php if($deduct_status == "Yes"){?> 
     <td colspan="6" height="20px"><div align="center"><strong>কর্তন</strong></div></td>
	 <?php }else{ ?>
<!--	  <td colspan="5" height="20px"><div align="center"><strong>কর্তন</strong></div></td>
-->	  <?php } ?> 
    <td rowspan="2" width="22" height="20px"><div align="center"><strong>সর্বমোট টাকা</strong></div></td>
    <td rowspan="2" width="22" height="20px"><div align="center"><strong>অগ্রীম কর্তন</strong></div></td>
    <td rowspan="2" width="22" height="20px"><div align="center"><strong>রাজস্ব কর্তন</strong></div></td>
    <td rowspan="2" width="22" height="20px"><div align="center"><strong>সর্বমোট প্রাপ্য</strong></div></td>
	<td rowspan="2"  width="180"><div align="center"><strong>গ্রহীতার স্বাক্ষর</strong></div></td>
  </tr>
  <tr height="10px">
  	<td width="15" style="font-size:8px;"><div align="center"><strong>হাজিরা</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>অফ ডে</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>অনুপুস্থিত</strong></div></td>
    <td width="15" style="font-size:8px;"><div align="center"><strong>বি/এ অনুপুস্থিত</strong></div></td>
  	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>CL</strong></div></td>
	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>SL</strong></div></td>
    <!--<td width="15"><div align="center"><strong>F/L</strong></div></td>-->
	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>EL</strong></div></td>
	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>M/L</strong></div></td>
    
        
    <td width="37"><div align="center"><strong>ওটি ঘণ্টা</strong></div></td>
    <td width="37"><div align="center"><strong>ওটি হার</strong></div></td>
    <td width="37"><div align="center"><strong>ওটি টাকা</strong></div></td>
	<?php if($deduct_status == "Yes"){?>
	<td width="37"><div align="center"><strong>HD Deduct</strong></div></td>
	<?php } ?>

    
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
   $total_net_pay			= 0;
   $total_holiday_allowance = 0;
   $total_net_wages			= 0;
   $total_night_allowance	= 0;
   $total_tax_deduct		= 0;
   $total_wages_with_stamp	= 0;
   $total_sum				= 0;
   $in_total_sum			= 0;
//    dd($value);

	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr height='75' style='text-align:center;' >";
		echo "<td >";
		echo $k+1;
		echo "</td>";
		
		echo "<td>";
		print_r($value[$k]->emp_id);
		echo "</td>";
		
		echo "<td colspan='6' style='font-family:Arial, Helvetica, sans-serif; text-align:left; padding-left:5px;'>";
		echo "<span  style='font-weight:bold;'>";
		print_r($value[$k]->name_en);
		echo "</span>";
		echo '<br>';
		echo "<span  style='font-size:10px;'>";

		print_r($value[$k]->desig_name);
		echo '<br>';
		$date = $value[$k]->emp_join_date;
		$doj		= date('d-M-y', strtotime($date)); 
		$doj_check	= date('Y-m', strtotime($date)); 
		echo 'DOJ :'.$doj;
		echo '<br>';
		echo "Grade: ";print_r ($value[$k]->gr_name);
		echo '<br>';
		if($grid_status == 4)
		{
			$resign_date = $this->grid_model->get_resign_date_by_empid($value[$k]->emp_id);
			if($resign_date != false){
			echo "Resign : ".$resign_date = date('d-M-y', strtotime($resign_date));
			}
		}
		echo "</span>";
		echo "</td>"; 
			
		echo "<td style='font-family:arial; font-size:10px;'>";
		echo  $value[$k]->line_name_en;
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
		$total_conveyance 		= $total_conveyance + $value[$k]->trans_allow;
		$grand_total_conveyance	= $grand_total_conveyance + $value[$k]->trans_allow;
		echo "</td>";
		
		
		echo "<td>";
		echo $value[$k]->food_allow;
		$total_food_allow		= $total_food_allow + $value[$k]->food_allow;
		$grand_total_food_allow	= $grand_total_food_allow + $value[$k]->food_allow;
		echo "</td>";
		
		$gross_salary 				= $value[$k]->gross_sal;
		$total_gross_salary 		= $total_gross_salary + $gross_salary;
		$grand_total_gross_salary 	= $grand_total_gross_salary + $gross_salary;
		echo "<td>";
		echo $gross_salary;
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->att_days);
		echo "</td>"; 
				
		echo "<td>";
		print_r ($value[$k]->total_holiday);
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
		print_r ($value[$k]->e_l);
		echo "</td>";
				
		echo "<td>";
		print_r ($value[$k]->m_l);
		echo "</td>";
		
		$abs_deduction 				= $value[$k]->abs_deduction;
		$total_abs_deduction 		= $total_abs_deduction + $abs_deduction;
		$grand_total_abs_deduction 	= $grand_total_abs_deduction + $abs_deduction;
		echo "<td>";
		echo $abs_deduction;
		echo "</td>";		
		
		echo "<td>";
		print_r ($value[$k]->pay_days);
		echo "</td>";
		
		$total_deduction		= $value[$k]->total_deduct;
		$net_wages 				= $gross_salary - $total_deduction + $value[$k]->stamp + $value[$k]->adv_deduct;
		
		$total_net_wages 		= $total_net_wages + $net_wages;
		$grand_total_net_wages 	= $grand_total_net_wages + $net_wages;
		
		//if
		echo "<td>";
		echo $net_wages;
		echo "</td>";
		
		$att_bonus 					= $value[$k]->att_bonus;
		$total_att_bonus 			= $total_att_bonus + $att_bonus;
		$grand_total_att_bonus	 	= $grand_total_att_bonus + $att_bonus;
		echo "<td>";
		echo $att_bonus;
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->ot_hour);
		
		$total_ot_hour 			= $total_ot_hour + $value[$k]->ot_hour;
		$grand_total_ot_hour 	= $grand_total_ot_hour + $value[$k]->ot_hour;
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->ot_rate);
		echo "</td>";
		
		$ot_amount 					= $value[$k]->ot_amount;	
		$ot_eot_amount 				= $ot_amount;// + $eot_amount;
		$total_ot_eot_amount 		= $total_ot_eot_amount + $ot_eot_amount;
		$grand_total_ot_eot_amount 	= $grand_total_ot_eot_amount + $ot_eot_amount;
		echo "<td>";
		echo $ot_amount;
		echo "</td>";
	
		$total_sum =  $net_wages + $att_bonus + $ot_amount; 
		$in_total_sum = $in_total_sum  + $total_sum;
		$grand_total_sum = $grand_total_sum + $total_sum;
		echo "<td>";
		echo $total_sum;
		echo "</td>";

		//11-05-2022 shahajahan
		/*if ($value[$k]->sec_id == 5 || $value[$k]->sec_id == 6) {	
			$adv_deduct 				= 0;
		}else{
			$adv_deduct 				= $value[$k]->adv_deduct;
		}*/

		$adv_deduct 				= $value[$k]->adv_deduct;
		$total_adv_deduct 			= $total_adv_deduct + $adv_deduct;
		$grand_total_adv_deduct 	= $grand_total_adv_deduct + $adv_deduct;
		echo "<td>";
		echo $adv_deduct;
		echo "</td>";
	
		$stamp_deduct 				= $value[$k]->stamp;
		// $stamp_deduct 				= 0;
		$total_stamp_deduct 		= $total_stamp_deduct + $stamp_deduct;
		$grand_total_stamp_deduct 	= $grand_total_stamp_deduct + $stamp_deduct;
		
		echo "<td>";
		echo $stamp_deduct;
		echo "</td>";

		// $net_pay 				= $value[$k]->net_pay ;
		//11-05-2022 shahajahan
		/*if ($value[$k]->sec_id == 5 || $value[$k]->sec_id == 6) {
			// exit('hi ali');
			$net_pay 				= $total_sum - $stamp_deduct ;
		}else{
			$net_pay 				= $total_sum - $stamp_deduct - $adv_deduct;
		}*/

		$net_pay 				= $total_sum - $stamp_deduct - $adv_deduct;
		$total_net_pay 			= $total_net_pay + $net_pay;
		$grand_total_net_pay 	= $grand_total_net_pay + $net_pay;
			
		echo "<td style='font-weight:bold'>";
		echo $net_pay;
		echo "</td>";
		
		echo "<td style='font-family:arial;font-weight:bold; font-size: 28px;'>";
		if($salary_month_check == $doj_check){echo '***';}
		echo "&nbsp;&nbsp;&nbsp;|&nbsp;";
		//echo "<span style='border:'>&nbsp;|&nbsp;</span>";
		echo "</td>";
		
		$total_wages_with_stamp = $total_net_pay  + $total_stamp_deduct ;
		$grand_total_wages_with_stamp = $grand_total_net_pay + $grand_total_stamp_deduct;	
		echo "</tr>"; 
		$k++;
	}
	?>
	<tr>
		<td align="center" colspan="9" style="font-size:13px;"><strong>প্রতি পৃষ্ঠার মোট </strong></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_basic_salary);?></strong></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_house_rent);?></strong></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_medical_allowance);?></strong></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_conveyance);?></strong></td>
         <td align="right" style="font-size:16px;" ><strong><?php echo $english_format_number = number_format($total_food_allow);?></strong></td>
          <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_gross_salary);?></strong></td>
         <td align="right" colspan="8"></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_abs_deduction);?></strong></td>
         <td align="right" colspan="1"></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_net_wages);?></strong></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_att_bonus);?></strong></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_ot_hour);?></strong></td>
          <td align="right" colspan="1"></td>
        <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_ot_eot_amount);?></strong></td>
        <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($in_total_sum);?></strong></td>
          <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_adv_deduct);?></strong></td>
      
        <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_stamp_deduct);?></strong></td>
       
        <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_net_pay);?></strong></td>
		<td align="center" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_wages_with_stamp);?></strong></td>	
	
    </tr>
	<?php
	if($counter == $page)
   		{?>
			<tr height="10">
            <?php //echo $deduct_status;?>
			<?php if($deduct_status == "Yes"){?>
			<td colspan="9" align="center">
			 <?php }else{ ?>
			 <td colspan="9" align="center">
			 <?php } ?>
			<strong style="font-size:13px;">সর্বমোট বেতন</strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_basic_salary);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_house_rent);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_medical_allowance);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_conveyance);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_food_allow);?></strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_gross_salary);?></strong></td>
         <td align="right" colspan="8"></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_abs_deduction);?></strong></td>
         <td align="right" colspan="1"></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_net_wages);?></strong></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_att_bonus);?></strong></td>
         <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_ot_hour);?></strong></td>
            <td align="right" colspan="1"></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_ot_eot_amount);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_sum);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_adv_deduct);?></strong></td>
        	<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_stamp_deduct);?></strong></td>
			<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_net_pay);?></strong></td>
			<td align="center" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_wages_with_stamp);?></strong></td>
            
            </tr>
			<?php } ?>
			<tr>
				<td colspan="35">
					<?php 
					$siginfo['unit_id'] = $unit_id;
					$this->load->view("authorised_signature", $siginfo);?>
				</td>
			</tr>
		</table>
		<!-- <div style="page-break-after: always; margin: 10px; padding:0px;"></div> -->
		<?php
	}
?>
</body>
</html>

<br><br><br>
<?php exit(); ?>

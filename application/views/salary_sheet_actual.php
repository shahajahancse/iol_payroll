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
//$date_format_2 = date("d", mktime(0, 0, 0, $month, $day, $year));
//$date_format_2 = date('d',strtotime("1 day",$date_format_2));
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
	 text-align: center;
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
// dd($value);
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
	 $advance_punish 				= 0;


for ($counter = 1; $counter <= $page; $counter ++)
{
?>

<table height="auto"  class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; width:13.6in; , SolaimanLipi;">

<tr height="75px">

<?php if($deduct_status == "Yes"){?>
<td colspan="36" align="center">
<?php }else{ ?>
<td colspan="36" align="center">
<?php } ?>
<div style="width:100%; font-family:Arial, Helvetica, sans-serif;">
<div style="text-align:left; position:relative;padding-left:10px;width:20%; float:left; font-weight:bold;">
<table>
<?php
$date = date('d-m-Y');
//$unit_name['unit_name'] = $this->db->where("unit_id",$grid_unit)->get('pr_units')->row()->unit_name;
$section_name = $value[0]->sec_name_en;
$dom = $value[0]->total_days;
//echo "Section : $section_name<br>";
echo "বিভাগ : $section_name<br>";
echo "মাসের তারিখ :".'<span style="">'." $dom<br>".'</span>';

//echo "Payment Date : $date"; ?>
</table>
</div>
 <div style="text-align:center; position:relative;padding-left:10px;width:50%; overflow:hidden; float:left; display:block;">
<?php //$emp_id = $value[0]->emp_id;
//$data['unit_id'] = $this->db->where("emp_id",$emp_id)->get('pr_emp_com_info')->row()->unit_id;
$this->load->view("head_bangla");?>
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
//echo "Salary/Wages & OT Wages Payment Sheet for the month of  ";
echo "বেতন ও মজুরী প্রদান পত্র ";
$date1 = $salary_month;
$date2 = date('Y-m-t', strtotime($salary_month));
$from_date = date('Y-m-d', strtotime($date1));
$to_date = date('Y-m-t', strtotime($date1));
// $date = "$first_date to $last_date";
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));

$date2 = $custom_salarydate;
$day2=trim(substr($date2,0,2));
$month2=trim(substr($date2,3,2));
$year2=trim(substr($date2,6,9));

$salary_month_check = date("M-Y", mktime(0, 0, 0, $month, $day, $year));

$date_format = date("d-m-Y", strtotime("$year2-$month2-$day2"));
echo '<span style="">'. $salary_month_check .'</span>';
echo '</span>';
?>
</div>
<div style="text-align:left; position:relative;padding-left:10px;width:20%; overflow:hidden; float:right; display:block; font-weight:bold">

<?php
echo '<span style="">'."পাতা নং # $counter এর $page<br>".'</span>';
echo "টাকা প্রদানের তারিখ : "."<span style=''>".date('d-m-Y')."</span>";
?>

</div>


</div>
</td>
</tr>


  <tr height="20px">
    <td rowspan="2"  width="15" height="20px"><div align="center"><strong>নং</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>কার্ড নং</strong></div></td>
    <td rowspan="2" colspan="6" width="100" height="20px"><div align="center"><strong>নাম , পদবী , যোগদান , গ্রেড</strong></div></td>
	<td rowspan="2" width="50" height="20px"><div align="center"><strong>লাইন</strong></div></td>
    <!--<td rowspan="2" width="25" height="20px"><div align="center"><strong>Designation</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>Joining Date</strong></div></td>-->
    <td rowspan="2" width="20" height="20px"> <div align="center"><strong>মূল বেতন</strong></div></td>
    <td rowspan="2" width="17" height="20px"><div align="center"><strong>বাড়ী ভাড়া</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>চিকিৎসা ভাতা</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>যাতায়াত ভাতা </strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>খাদ্য ভাতা</strong></div></td>
    <td rowspan="2" width="35" height="20px"><div align="center"><strong>মোট বেতন</strong></div></td>
    <td colspan="5" width="30" height="20px"><div align="center"><strong>উপস্থিতি</strong></div></td>
	<td colspan="3" height="20px"><div align="center"><strong>ছুটি</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>অনুস্পস্থিতি কর্তন</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>পে ডে</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>প্রদেয় বেতন</strong></div></td>
    <td rowspan="2"  height="20px"><div align="center"><strong>হাজিরা <br />বোনাস</strong></div></td>

	<td colspan="3" height="20px"><div align="center"><strong>ওভার টাইম</strong></div></td>
    <td rowspan="2" width="22" height="20px"><div align="center"><strong>সর্বমোট টাকা</strong></div></td>

    <td colspan="3" height="20px"><div align="center"><strong>কর্তন</strong></div></td>
    <td rowspan="2" width="22" height="20px"><div align="center"><strong>সর্বমোট প্রাপ্য</strong></div></td>
	<td rowspan="2"  width="180" height="25"><div align="center"><strong>গ্রহীতার স্বাক্ষর</strong></div></td>
  </tr>
  <tr height="10px">
  	<td width="15" style="font-size:8px;"><div align="center"><strong>মোট দিন</strong></div></td>

  	<td width="15" style="font-size:8px;"><div align="center"><strong>হাজিরা</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>অফ ডে</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>অনুপুস্থিত</strong></div></td>
	<td width="15" style="font-size:8px;"><div align="center"><strong>আগে পরে অনুপুস্থিত</strong></div></td>

  	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>CL</strong></div></td>
	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>SL</strong></div></td>
    <!--<td width="15"><div align="center"><strong>F/L</strong></div></td>-->
	<td width="15"><div align="center" style="font-family:Arial, Helvetica, sans-serif;"><strong>EL</strong></div></td>
	<!--<td width="15"><div align="center"><strong>M/L</strong></div></td>-->


    <td width="37"><div align="center"><strong>ওটি ঘণ্টা</strong></div></td>
    <td width="37"><div align="center"><strong>ওটি হার</strong></div></td>
    <td width="37"><div align="center"><strong>ওটি টাকা</strong></div></td>
	<td width="22" height="20px"><div align="center"><strong>অগ্রীম কর্তন</strong></div></td>
    <td width="22" height="20px"><div align="center"><strong>অগ্রীম দণ্ড</strong></div></td>
    <td width="22" height="20px"><div align="center"><strong>রাজস্ব কর্তন</strong></div></td>

<!--	<td width="22"><div align="center"><strong>অগ্রীম কর্তন</strong></div></td>
-->	<?php if($deduct_status == "Yes"){?>
	<!-- <td width="37"><div align="center"><strong>HD Deduct</strong></div></td> -->
	<?php } ?>
<!--    <td width="37" style="font-size:10px;"><div align="center"><strong>অনুস্পস্থিতি কর্তন</strong></div></td>
    <td width="37"><div align="center"><strong>লেট</strong></div></td>
    <td width="37"><div align="center"><strong>অন্যান্য</strong></div></td>
    <td width="37"><div align="center"><strong>রাজস্ব কর্তন</strong></div></td>-->

    <!--<td width="37"><div align="center"><strong>Attn. Bonus.</strong></div></td>
    <td width="37"><div align="center"><strong>H. day</strong></div></td>
    <td width="37"><div align="center"><strong>Night</strong></div></td>-->


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

	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr height='80' style='text-align:center;' >";
		echo "<td >";
		echo $k+1;
		echo "</td>";

		echo "<td>";
		print_r($value[$k]->emp_id);
		echo "</td>";

		echo "<td colspan='6' style='text-align:left; padding-left:5px;'>";
		echo "<span  style='font-weight:bold;'>";
		print_r($value[$k]->name_en);
		echo "</span>";
		echo '<br>';

		print_r($value[$k]->desig_bangla);
		echo '<br>';
		$date = $value[$k]->emp_join_date;
		$doj		= date('d-m-y', strtotime($date));
		$doj_check	= date('Y-m', strtotime($date));
		echo 'যোগদানের তারিখ :'.'<span style="">'.$doj.'</span>';
		echo '<br>';
		if($value[$k]->gr_name=='নাই'){
			echo "গ্রেড: ";print_r ($value[$k]->gr_name);
		}else{
			print_r($value[$k]->gr_name);
		}
		echo '<br>';
		if($grid_status == 4)
		{
			$resign_date = $this->Grid_model->get_resign_date_by_empid($value[$k]->emp_id);
			if($resign_date != false){
			echo "পদত্যাগ : <span style=''>".$resign_date = date('d-m-Y', strtotime($resign_date))."</span>";
			}
		}
		echo "</td>";


		echo "<td style='font-family:arial; font-size:10px;'>";
		$line_id = $value[$k]->line_id;
		echo $line_name = $this->db->select('line_name_en')->where('id',$line_id)->get('pr_line_num')->row()->line_name_en;
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
		echo $trans_allow = $value[$k]->trans_allow;
		$total_conveyance 		= $total_conveyance + $value[$k]->trans_allow;
		$grand_total_conveyance	= $grand_total_conveyance + $value[$k]->trans_allow;
		echo "</td>";


		echo "<td>";
		echo $food_allow = $value[$k]->food_allow;
		$total_food_allow		= $total_food_allow + $value[$k]->food_allow;
		$grand_total_food_allow	= $grand_total_food_allow + $value[$k]->food_allow;
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
		print_r($dom);
		//print_r ($value[$k]->before_after_absent);
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

		/*echo "<td>";
		print_r ($value[$k]->holiday);
		echo "</td>"; */

		echo "<td>";
		print_r ($value[$k]->e_l);
		echo "</td>";

		/*echo "<td>";
		print_r ($value[$k]->m_l);
		echo "</td>";*/
		$abs_deduction 				= $value[$k]->abs_deduction;
		$total_abs_deduction 		= $total_abs_deduction + $abs_deduction;
		$grand_total_abs_deduction 	= $grand_total_abs_deduction + $abs_deduction;
		echo "<td>";
		echo $abs_deduction;
		echo "</td>";

		echo "<td>";
		print_r ($pay_days = $value[$k]->pay_days);
		echo "</td>";

		$total_deduction		= $value[$k]->total_deduct;
		//$net_wages 				= $gross_salary - $total_deduction + $value[$k]->stamp + $value[$k]->adv_deduct;
		//$net_wages				= (($basic_salary/$dom)*$pay_days)+$house_rent+$medical_allowance+$trans_allow+$food_allow;
		$net_wages				= $gross_salary-$abs_deduction;
		$total_net_wages 		= $total_net_wages + $net_wages;
		$grand_total_net_wages 	= $grand_total_net_wages + $net_wages;
		echo "<td>";
		echo number_format ($net_wages);
		echo "</td>";

		$att_bonus 					= $value[$k]->att_bonus;
		$total_att_bonus 			= $total_att_bonus + $att_bonus;
		$grand_total_att_bonus	 	= $grand_total_att_bonus + $att_bonus;
		echo "<td>";
		echo $att_bonus;
		echo "</td>";

		echo "<td>";

		// $staff = $this->Grid_model->staff_id_collect($value[$k]->emp_id);


		if($value[$k]->ot_entitle==1 && $value[$k]->com_ot_entitle ==1){

			$eot_hour = 0;
			$ot_hour  = 0;

		}elseif($value[$k]->ot_entitle==0 && $value[$k]->com_ot_entitle ==0){

			$ot = $this->db->select("
				SUM('ot') as ot_hour, SUM('eot') as eot_hour,
			")->where('emp_id', $value[$k]->emp_id)->where('shift_log_date BETWEEN "'.$from_date.'" AND "'.$to_date.'"')->get('pr_emp_shift_log')->row();

			$ot_hour = $ot->ot_hour;
			$eot_hour = $ot->eot_hour;
		}
		else{
			$eot_hour = 0;
			$ot_hour  = 0;
		}


		$total_ot_eot = $ot_hour + $eot_hour;
		echo $ot_hour."<br>".$eot_hour."<br>"."= <br>".$total_ot_eot;

		$total_ot_hour 			= $total_ot_hour + $total_ot_eot;
		$grand_total_ot_hour 	= $grand_total_ot_hour + $total_ot_eot;
		echo "</td>";

		echo "<td>";
		print_r($value[$k]->ot_rate);
		echo "</td>";


		if($value[$k]->ot_entitle==1 && $value[$k]->com_ot_entitle==1){

			$ot_amount = 0;

		}elseif($value[$k]->ot_entitle==0 && $value[$k]->com_ot_entitle==0){

			$ot_amount =  $value[$k]->ot_amount + $value[$k]->eot_amount;
		}
		else{
			$ot_amount = 0;
		}


		echo "<td>";
		echo $ot_amount;
		echo "</td>";
		$total_ot_eot_amount 		= $total_ot_eot_amount + $ot_amount;
		$grand_total_ot_eot_amount 	= $grand_total_ot_eot_amount + $ot_amount;


		$total_sum =  $net_wages + $att_bonus + $ot_amount + @$value[$k]->due_pay_add;
		$in_total_sum = $in_total_sum  + $total_sum;
		$grand_total_sum = $grand_total_sum + $total_sum;
		echo "<td>";
		echo number_format($total_sum);
		echo "</td>";


		$adv_deduct 			= $value[$k]->adv_deduct;
		$due_pay_add 			= @$value[$k]->due_pay_add;
		$total_adv_deduct 		= $total_adv_deduct + $adv_deduct;
		$grand_total_adv_deduct = $grand_total_adv_deduct + $adv_deduct;
		echo "<td>";
		echo $adv_deduct;
		echo "</td>";

		echo "<td>";
		echo $due_pay_add;
		echo "</td>";


	

		$stamp_deduct 				= $value[$k]->stamp;
		$total_stamp_deduct 		= $total_stamp_deduct + $stamp_deduct;
		$grand_total_stamp_deduct 	= $grand_total_stamp_deduct + $stamp_deduct;
		echo "<td>";
		echo $stamp_deduct;
		echo "</td>";






		//$net_pay 				= $value[$k]->net_pay ;//+ $eot_amount;
		$adv_deduct 			= $value[$k]->adv_deduct;
		$total_sum              = $total_sum - $adv_deduct;
		$net_pay				= $total_sum-$stamp_deduct;
		$total_net_pay 			= $total_net_pay + $net_pay;
		$grand_total_net_pay 	= $grand_total_net_pay + $net_pay;
		echo "<td style='font-weight:bold'>";
		echo number_format($net_pay);
		echo "</td>";

		echo "<td style='font-family:arial;font-weight:bold; font-size: 28px;height:60px;'>";
		if($salary_month_check == $doj_check){echo '';}

		echo "</td>";

		$total_wages_with_stamp = $total_net_pay  + $total_stamp_deduct ;
		$grand_total_wages_with_stamp = $grand_total_net_pay + $grand_total_stamp_deduct;
		echo "</tr>";
		$k++;
	}
	?>
	<tr>
		<td align="center" colspan="9" style="font-size:13px;"><strong>প্রতি পৃষ্ঠার মোট </strong></td>
		<!--<?php if($deduct_status == "Yes"){?>
		<td colspan="4"></td>
		 <?php }else{ ?>
		 <td colspan="3"></td>
		 <?php } ?>-->
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
          <td align="right" style="font-size:14px;"><strong><?php echo '';?></strong></td>

        <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_stamp_deduct);?></strong></td>




         <!--<td align="right"><strong><?php echo $english_format_number = number_format($total_holiday_allowance);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_night_allowance);?></strong></td>-->

        <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($total_net_pay);?></strong></td>
		<td align="center" style="font-size:14px;"><strong><?php //echo $english_format_number = number_format($total_wages_with_stamp);?></strong></td>

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
            <!--<td align="right"><strong><?php echo $english_format_number = number_format($grand_total_holiday_allowance);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_night_allowance);?></strong></td>-->
            <td align="right" colspan="1"></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_ot_eot_amount);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_sum);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_adv_deduct);?></strong></td>
            <td align="right" style="font-size:14px;"><strong><?php echo '';?></strong></td>
        	<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_stamp_deduct);?></strong></td>
			<td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_net_pay);?></strong></td>
			<td align="center" style="font-size:14px;"><strong><?php //echo $english_format_number = number_format($grand_total_wages_with_stamp);?></strong></td>

            </tr>
			<?php } ?>

			<table width="100%" height="35px" border="0" align="center" style="margin:50px 0px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">

			<tr height="10%">
			<td  align="left" style="width:15%;"><dt class="bottom_txt_design" >মানবসম্পদ বিভাগ</dt></td>
            <td align="left"  style="width:15%" ><dt class="bottom_txt_design" >হিসাব বিভাগ</dt></td>
            <!-- <td  align="center" style="width:15%" ><dt class="bottom_txt_design" >পরিচালক</dt></td> -->
            <td  align="left" style="width:15%" ><dt class="bottom_txt_design" >ব্যবস্থাপনা পরিচালক</dt></td>
			</tr>
			</table>
			 <div style="page-break-after: always;"></div>
			</table>

			<?php

		}

?>

</body>
</html>

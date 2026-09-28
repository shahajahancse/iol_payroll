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
?>মাসিক অতিরিক্ত কাজ 
<?php 
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
$date_formate2 = $this->common_model->covert_english_date_to_bangla_date_with_day_name($date_format);
echo $date_formate2;

?>

</title>

<style>
.bottom_txt_design
{
	 border-top:1px solid;
	 width:160px;
	 font-weight:bold;
}
.bottom_txt_manager_design
{
	border-top:1px solid;
	width:170px;
}
</style>

</head>

<body style="width:800px; float: left;">

<?php 
$row_count=count($value);
if($row_count > 19)
{
$page = ceil($row_count/19);
}
else
{
$page=1;
}

$k = 0;

			
			$basic = 0;
			$house_rent = 0;
			$medical_all = 0;
			$gross_sal = 0;
			$abs_deduct = 0;
			$payable_basic = 0;
			$payable_house_rent =0;
			$payable_madical_allo =0;
			$pay_wages = 0;
			$grand_total_att_bonus =0;
			$grand_total_net_wages_after_deduction = 0;
			$grand_total_net_wages_with_ot = 0;
			$trans_allaw = 0;
			$lunch_allaw =0;
			$others_allaw = 0;
			$total_allaw =0;
			$ot_hour =0;
			$ot_rate =0;
			$ot_amount =0;
			$gross_pay =0;
			$adv_deduct =0;
			$provident_fund =0;
			$others_deduct =0;
			$total_deduct =0;
			$pbt =0;
			$tax =0;
			$net_pay =0;
			
			$stam_value = 10;
			$total_stam_value = 0;
			$grand_total_advance_salary = 0;
			$grand_total_lunch_deduction_hour = 0;
			$grand_total_lunch_deduction_amount = 0;
			$grand_total_absent_deduction = 0;
			$grand_total_stamp_deduction = 0;
			$grand_total_net_wages_without_ot = 0;
			$grand_total_ot_hour = 0;
			$grand_total_ot_amount = 0;
			$grand_total_eot_hour = 0;
			$grand_total_eot_amount = 0;
			$grand_total_ot_eot_hour = 0;
			
			
			?>
			
			<?php
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>

<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; width:auto;">

<tr height="85px">

<?php if($deduct_status == "Yes"){?> 
<td colspan="17" align="center">
<?php }else{ ?>
<td colspan="17" align="center">
<?php } ?>

<div style="width:100%; font-family:Arial, Helvetica, sans-serif;">
<div style="text-align:left; position:relative;padding-left:10px;width:20%; float:left; font-weight:bold;">
<table>
<?php 
$date = date('d-m-Y');
$section_name = $value[0]->sec_bangla;
echo "সেকশন : $section_name<br>";
 ?>
</table>
</div>
 <div style="text-align:center; position:relative;padding-left:10px;width:50%; overflow:hidden; float:left; display:block;">
<?php 
$this->load->view("head_bangla");

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
echo '<span style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;">';
?>
মাসিক অতিরিক্ত কাজ 
<?php 

$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
$date_formate2 = $this->common_model->covert_english_date_to_bangla_date_with_day_name($date_format);
echo $date_formate2;
echo '</span>';

?>

</div>
<div style="text-align:left; position:relative;padding-left:10px;width:20%; overflow:hidden; float:right; display:block; font-weight:bold">

<?php
echo '<span style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;">';
echo "পেজ নম্বর # $counter এর $page<br>";
echo "প্রদাণের তারিখ : ";
echo '</span>';
?>

</div>


</div>


</td>
</tr>


        <th rowspan="2" width="15" height="20px"><div align="center"><strong>	ক্রমিক নং				</strong></div></th>
        <th rowspan="2" width="14" height="20px"><div align="center"><strong>	কার্ড নং			</strong></div></th>
        <th rowspan="2" width="30" height="20px"><div align="center"><strong>কর্মচারীর নাম</strong></div></th>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>পদবী	</strong></div></th>
        <th rowspan="2" width="50" height="20px"><div align="center"><strong>লাইন</strong></div></th>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>যোগদানের তারিখ</strong></div></th>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>গ্রেড	</strong></div></th>
      <th rowspan="2" width="35" height="20px"><div align="center"><strong>মোট বেতন</strong></div></th>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>মোট ওটি</strong></div></th>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>ওটি ঘন্টা</strong></div></th>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>ইওটি ঘন্টা</strong></div></th>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>ইওটি রেট</strong></div></th>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>ওটির পরিমাণ</strong></div></th>
        <th rowspan="2" width="120" height="20px"><div align="center"><strong>স্বাক্ষর</strong></div></th>
        <tr></tr>
<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) % 19;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=18;
   	}
  	
   	$total_pay_wages	= 0;
	$total_ot_hours   	= 0;
	$total_ot_amount  	= 0;
	$total_att_bonus	= 0;
	$total_gross_pays	= 0;
	$total_net_pays		= 0;
	$total_net_wages_after_deduction = 0;
	$total_net_wages_with_ot = 0;
	
	$total_gross_sal_per_page = 0;
	$total_advance_per_page = 0;
	$lunch_deduction_hour_per_page = 0;
	$lunch_deduction_amount_per_page = 0;
	$total_absent_deduction_per_page = 0;
	$total_stamp_deduction_per_page = 0;
	$total_net_wages_without_ot_per_page = 0;
	$total_ot_hour_per_page = 0;
	$total_ot_amount_per_page = 0;
	$total_eot_hour_per_page = 0;
	$total_eot_amount_per_page = 0;
	$total_ot_eot_hour_per_page = 0;
	$total_ot_rate_per_page = 0;
	
	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr height='45' style='text-align:center;font-family:SutonnyMj; SolaimanLipi;' >";
		echo "<td >";
		echo $k+1;
		echo "</td>";
		
		
		echo "<td style='font-weight:bold;font-family:SutonnyMj; SolaimanLipi;'>";
		print_r($value[$k]->emp_id);
		//echo $row->emp_id;
		echo "</td>";
		
		echo "<td style='width:100px;font-family:SutonnyMj; SolaimanLipi;'>";
		print_r($value[$k]->bangla_nam);
		//echo '<br>';
		if($grid_status == 4)
		{
			$resign_date = $this->Grid_model->get_resign_date_by_empid($value[$k]->emp_id);
			if($resign_date != false){
			echo $resign_date = date('d-M-y', strtotime($resign_date));}
		}
		elseif($grid_status == 3)
		{
			$left_date = $this->Grid_model->get_left_date_by_empid($value[$k]->emp_id);
			if($left_date != false){
			echo $left_date = date('d-M-y', strtotime($left_date));}
		}
		echo "</td>"; 
				
		
				
		echo "<td>";
		print_r($value[$k]->desig_bangla);
		//echo $row->desig_name;
		echo "</td>";
		
		echo "<td>";
		print_r($value[$k]->line_bangla);
		//echo $row->desig_name;
		echo "</td>";
				
				
		echo "<td>";
		$date = $value[$k]->emp_join_date;
		//print_r($value[$k]->emp_join_date);
		$year=trim(substr($date,0,4));
		$month=trim(substr($date,5,2));
		$day=trim(substr($date,8,2));
		$date_format = date("d-F-y", mktime(0, 0, 0, $month, $day, $year));
		$date_formate2 = $this->common_model->covert_english_date_to_bangla_date_with_day_name($date_format);
		echo $date_formate2;
		echo "</td>";
			
		echo "<td style='font-weight:bold;font-family:SutonnyMj; SolaimanLipi;'>";
		print_r ($value[$k]->gr_name);
		echo "</td>";
	/*		
		echo "<td>";
		print_r ($value[$k]->basic_sal);
		$basic = $basic + $value[$k]->basic_sal;
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->house_r);
		//echo $row->house_r;
		$house_rent = $house_rent + $value[$k]->house_r;
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->medical_a);
		//echo $row->medical_a;
		$medical_all = $medical_all + $value[$k]->medical_a;
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->trans_allow);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->food_allow);
		echo "</td>";
		*/		 
		echo "<td style='font-weight:bold;font-family:SutonnyMj; SolaimanLipi;'>";
		print_r ($value[$k]->gross_sal);
		//echo "<strong>$row->gross_sal</strong>";
		$gross_sal = $gross_sal + $value[$k]->gross_sal;
		$total_gross_sal_per_page = $total_gross_sal_per_page + $value[$k]->gross_sal;
		echo "</td>";
		
		$user_id = $this->acl_model->get_user_id($this->session->userdata('username'));
		$acl     = $this->acl_model->get_acl_list($user_id);
		if(in_array(14,$acl)){
			//$eot_hour 	= $value[$k]->eot_hr_for_sa;
			//$eot_amount = $value[$k]->eot_amt_for_sa;
			$eot_hour 	= $value[$k]->eot_hour;
			$eot_amount = round($value[$k]->eot_amount);	
		}
		else
		{
			$eot_hour 	= $value[$k]->eot_hour;
			$eot_amount = round($eot_hour * $value[$k]->ot_rate);	
		}
				
		$total_ot_eot_hour	= $value[$k]->ot_hour + $eot_hour;
		echo "<td style='font-weight:bold;font-family:SutonnyMj; SolaimanLipi;'>";
		//echo $eot_hour = $value[$k]->eot_hour;
		echo $total_ot_eot_hour;
		echo "</td>";
		$total_ot_eot_hour_per_page = $total_ot_eot_hour_per_page + $total_ot_eot_hour;
		$grand_total_ot_eot_hour = $grand_total_ot_eot_hour + $total_ot_eot_hour; 
		
		echo "<td style='font-weight:bold;font-family:SutonnyMj; SolaimanLipi;'>";
		echo $ot_hour = $value[$k]->ot_hour;
		echo "</td>";
		$total_ot_hour_per_page = $total_ot_hour_per_page + $ot_hour; 
		$grand_total_ot_hour = $ot_hour + $grand_total_ot_hour; 
		
        echo "<td style='font-weight:bold;font-family:SutonnyMj; SolaimanLipi;'>";
		echo $eot_hour;
		echo "</td>";
		
		$total_eot_hour_per_page = $total_eot_hour_per_page + $eot_hour; 
		$grand_total_eot_hour = $grand_total_eot_hour + $eot_hour; 
		
		echo "<td style='font-weight:bold;font-family:SutonnyMj; SolaimanLipi;'>";
		print_r ($value[$k]->ot_rate);
		//echo "o_r".$row->ot_rate;
		$ot_rate = $ot_rate + $value[$k]->ot_rate; 
		echo "</td>";
		//$total_ot_rate_per_page = $total_ot_rate_per_page + $ot_rate; 
		
		
		if($eot_amount<0){$eot_amount = 0;}		
		echo "<td style='font-weight:bold;font-family:SutonnyMj; SolaimanLipi;'>";
		echo $eot_amount;
		echo "</td>";
		
		$total_ot_amount_per_page = $total_ot_amount_per_page + $eot_amount;
		$grand_total_ot_amount = $grand_total_ot_amount + $eot_amount;
		
		echo "<td>";
		echo "&nbsp;";
		echo "</td>";
			
		echo "</tr>"; 
		$k++;
	}
	?>
	<tr>
		<td align="center" colspan="7"><strong>প্রতি পাতার মোট</strong></td>
        <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($total_gross_sal_per_page);?></strong></td>
        <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($total_ot_eot_hour_per_page);?></strong></td>
        <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($total_ot_hour_per_page);?></strong></td>
        <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($total_eot_hour_per_page);?></strong></td>
        <td align="right" colspan="1"></td>
		<td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($total_ot_amount_per_page);?></strong></td>
		
	</tr>
	<?php
	if($counter == $page)
   		{?>
			<tr height="10">
			<td colspan="7" align="center"><strong>সর্বমোট টাকার পরিমাণ</strong></td>
            <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($gross_sal);?></strong></td>
            <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($grand_total_ot_eot_hour);?></strong></td>
            <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($grand_total_ot_hour);?></strong></td>
            <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($grand_total_eot_hour);?></strong></td>
            <td colspan="1"></td>
            <td align="right" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi;"><strong><?php echo $english_format_number = number_format($grand_total_ot_amount);?></strong></td>
			
			</tr>
			<?php } ?>
			<br><br><br>
			<table width="100%" height="80px" border="0" align="center" style="font-weight:bold;font-family:SutonnyMj; SolaimanLipi; font-size:10px;">
			<tr height="80%" >
			<td colspan="28"></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:15%;"><dt class="bottom_txt_design" >প্রস্তুতকারক</dt></td>
            <td align="center"  style="width:25%" ><dt class="bottom_txt_design" >হিসাব শাখা</dt></td>
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >মানব সম্পদ ব্যবস্থাপক</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >
পরিচালক</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >
 ব্যবস্থাপনা পরিচালক</dt></td>
			</tr>
			
			</table>
			</table>
			  <br><br>
			<?php

		}

?>

</body>
</html>
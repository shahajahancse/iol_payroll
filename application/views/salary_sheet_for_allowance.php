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
?>Monthly Allowance  Sheet of
<?php 
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;

?>

</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
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

<body style="width:780px;">

<?php 
$row_count=count($value);
if($row_count > 20)
{
$page = ceil($row_count/20);
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
			$holiday_allowance =0;
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
			$grand_total_holiday_alo_count = 0;
			$grand_total_holiday_allowance = 0;
			$grand_total_night_allowance   = 0;
			$grand_total_allowance = 0;
			
			
			?>
			
			<?php
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>

<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; width:auto;">

<tr height="85px">

<?php if($deduct_status == "Yes"){?> 
<td colspan="22" align="center">
<?php }else{ ?>
<td colspan="22" align="center">
<?php } ?>

<div style="text-align:left; position:relative; top:20px; padding-left:10px;">
<?php 
$date = date('d-m-Y');
//echo "Payment Date : $date"; ?>
</div>
 
<?php 
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
?>Monthly Allowance Sheet of 
<?php 
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;

?>

</td>
</tr>


        <th rowspan="2" width="15" height="20px"><div align="center"><strong>	SI. No				</strong></div></td>
        <th rowspan="2" width="30" height="20px"><div align="center"><strong>	Name of Employee	</strong></div></td>
        <th rowspan="2" width="14" height="20px"><div align="center"><strong>	Card No				</strong></div></td>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>	Designation			</strong></div></td>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>	Section				</strong></div></td>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>	Joining Date		</strong></div></td>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>	Grade				</strong></div></td>
        <th rowspan="2" width="20" height="20px"><div align="center"><strong>	Basic				</strong></div></td>
        <th rowspan="2" width="17" height="20px"><div align="center"><strong>	H/Rent				</strong></div></td>
        <th rowspan="2" width="15" height="20px"><div align="center"><strong>	Medical				</strong></div></td>
        <th rowspan="2" width="17" height="20px"><div align="center"><strong>	Trans.				</strong></div></td>
        <th rowspan="2" width="15" height="20px"><div align="center"><strong>	Food				</strong></div></td>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>	Gross Salary		</strong></div></td>
        
        
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>	Hol. No.			</strong></div></td>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>	Hol. Rate			</strong></div></td>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>	Hol. Amt				</strong></div></td>
        
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>	Night No.				</strong></div></td>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>	Night Rate			</strong></div></td>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>	Night Amt				</strong></div></td>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>	Total				</strong></div></td>
        <th rowspan="2" width="100" height="20px"><div align="center"><strong>	Signature			</strong></div></td>
        <tr></tr>
<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) % 20;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=19;
   	}
  	
   	$total_pay_wages	= 0;
	$total_holiday_alo_counts   	= 0;
	$total_holiday_allowance  	= 0;
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
	$total_holiday_alo_count_per_page = 0;
	$total_holiday_allowance_per_page = 0;
	$total_night_allowance_per_page    =0 ;
	$total_allowance_per_page  = 0;
	
	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr height='45' style='text-align:center;' >";
		echo "<td >";
		echo $k+1;
		echo "</td>";
		
		echo "<td style='width:100px;'>";
		print_r($value[$k]->name_en);
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
		print_r($value[$k]->emp_id);
		//echo $row->emp_id;
		echo "</td>";
				
		echo "<td>";
		print_r($value[$k]->desig_name);
		//echo $row->desig_name;
		echo "</td>";
		
		echo "<td>";
		print_r($value[$k]->sec_name_en);
		//echo $row->desig_name;
		echo "</td>";
				
				
		echo "<td>";
		$date = $value[$k]->emp_join_date;
		//print_r($value[$k]->emp_join_date);
		$year=trim(substr($date,0,4));
		$month=trim(substr($date,5,2));
		$day=trim(substr($date,8,2));
		$date_format = date("d-M-y", mktime(0, 0, 0, $month, $day, $year));
		echo $date_format;
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->gr_name);
		echo "</td>";
			
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
				 
		echo "<td style='font-weight:bold;'>";
		print_r ($value[$k]->gross_sal);
		$gross_sal = $gross_sal + $value[$k]->gross_sal;
		$total_gross_sal_per_page = $total_gross_sal_per_page + $value[$k]->gross_sal;
		echo "</td>";
				
				
		echo "<td>";
		echo $holiday_alo_count  = $value[$k]->holiday_alo_count;
		echo "</td>";
		$total_holiday_alo_count_per_page 	= $total_holiday_alo_count_per_page + $holiday_alo_count; 
		$grand_total_holiday_alo_count 		= $grand_total_holiday_alo_count + $holiday_alo_count; 
		
		echo "<td>";
		print_r ($value[$k]->holiday_allowance_rate);
		//echo "o_r".$row->ot_rate;
		//$holiday_allowance_rate = $holiday_allowance_rate+ $value[$k]->holiday_allowance_rate; 
		echo "</td>";
		
		$holiday_allowance =  $value[$k]->holiday_allowance;
				
		echo "<td>";
		echo $holiday_allowance;
		echo "</td>";
		
		$total_holiday_allowance_per_page 	= $total_holiday_allowance_per_page + $holiday_allowance;
		$grand_total_holiday_allowance 		= $grand_total_holiday_allowance + $holiday_allowance;
		
		
		
		echo "<td>";
		echo $night_alo_count  = $value[$k]->night_alo_count;
		echo "</td>";
		$total_night_alo_count_per_page 	= $total_holiday_alo_count_per_page + $night_alo_count; 
		$grand_total_night_alo_count 		= $grand_total_holiday_alo_count + $night_alo_count; 
		
		echo "<td>";
		print_r ($value[$k]->night_allowance_rate);
		//$night_allowance_rate = $night_allowance_rate+ $value[$k]->night_allowance_rate; 
		echo "</td>";
		
		$night_allowance=  $value[$k]->night_allowance;
		echo "<td>";
		echo $night_allowance;
		echo "</td>";
		$total_night_allowance_per_page 	= $total_night_allowance_per_page + $night_allowance;
		$grand_total_night_allowance 		= $grand_total_night_allowance + $night_allowance;
		
		
		$total_allowance = $holiday_allowance + $night_allowance;
		$total_allowance_per_page 	= $total_allowance_per_page + $total_allowance;
		$grand_total_allowance 		= $grand_total_allowance + $total_allowance;
		echo "<td>";
		echo $total_allowance;
		echo "</td>";
		
	
		echo "<td>";
		echo "&nbsp;";
		echo "</td>";
			
		echo "</tr>"; 
		$k++;
	}
	?>
	<tr>
		<td align="center" colspan="12"><strong>Total Per Page</strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_gross_sal_per_page);?></strong></td>
        <td colspan="2"></td>
		<td align="right"><strong><?php echo $english_format_number = number_format($total_holiday_allowance_per_page);?></strong></td>
		 <td colspan="2"></td>
		<td align="right"><strong><?php echo $english_format_number = number_format($total_night_allowance_per_page);?></strong></td>
		<td align="right"><strong><?php echo $english_format_number = number_format($total_allowance_per_page);?></strong></td>
		
	</tr>
	<?php
	if($counter == $page)
   		{?>
			<tr height="10">
			<td colspan="12" align="center"><strong>Grand Total Amount Tk</strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($gross_sal);?></strong></td>
            <td colspan="2"></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_holiday_allowance);?></strong></td>
			<td colspan="2"></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_night_allowance);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_night_allowance);?></strong></td>
			</tr>
			<?php } ?>
			
			<table width="100%" height="80px" border="0" align="center" style="margin-bottom:50px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr height="80%" >
			<td colspan="28"></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:15%;"><dt class="bottom_txt_design" >Accounts Executive/Officer</dt></td>
            <td align="center"  style="width:25%" ><dt class="bottom_txt_design" >Asst. Manager(Admin & Compl)</dt></td>
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Manager(Admin & Fin)</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >General Manager</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Managing Director</dt></td>
			</tr>
			
			</table>
			</table>
			  
			<?php

		}

?>

</body>
</html>
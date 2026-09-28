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
?>Monthly Stop Salary Sheet of
<?php
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;
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
	 		$grand_total_net_pay= 0;
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
			$grand_total_gross_salary = 0;
			?>
			<?php
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>
<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; width:740px;">
<tr height="85px">
<?php if($deduct_status == "Yes"){?>
<td colspan="14" align="center">
<?php }else{ ?>
<td colspan="14" align="center">
<?php } ?>
<div style="width:100%; font-family:Arial, Helvetica, sans-serif;">
<div style="text-align:left; position:relative;padding-left:10px;width:20%; float:left; font-weight:bold;">
<table>
<?php
$date = date('d-m-Y');
$section_name = isset($section_name)?$section_name:'';
echo "Section : $section_name<br>";
 ?>
</table>
</div>
<div style="text-align:center; position:relative;padding-left:10px;width:50%; overflow:hidden; float:left; display:block;">
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
?>
Monthly Stop Salary Sheet of
<?php
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;
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
        <th rowspan="2" width="15" height="20px"><div align="center"><strong>SI. No</strong></div></th>
        <th rowspan="2" width="14" height="20px"><div align="center"><strong>Card No</strong></div></th>
        <th rowspan="2" width="30" height="20px"><div align="center"><strong>Name of Employee</strong></div></th>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>Designation</strong></div></th>
        <th rowspan="2" width="30" height="20px"><div align="center"><strong>Line</strong></div></th>
        <th rowspan="2" width="55" height="20px"><div align="center"><strong>Joining Date</strong></div></th>
        <th rowspan="2" width="25" height="20px"><div align="center"><strong>Grade</strong></div></th>
        <th rowspan="2" width="55" height="20px"><div align="center"><strong>Gross Salary</strong></div></th>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>Net Pay</strong></div></th>
        <th rowspan="2" width="55" height="20px"><div align="center"><strong>Salary Status</strong></div></th>
        <th rowspan="2" width="35" height="20px"><div align="center"><strong>Remarks</strong></div></th>
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
	$total_net_pay		= 0;
	$total_net_wages_after_deduction = 0;
	$total_net_wages_with_ot = 0;
	$total_gross_salary		= 0;
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

	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr height='45' style='text-align:center;' >";
		echo "<td >";
		echo $k+1;
		echo "</td>";

		echo "<td style='font-weight:bold;'>";
		print_r($value[$k]->emp_id);
		echo "</td>";

		echo "<td style='width:100px;'>";
		print_r($value[$k]->name_en);
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
		print_r($value[$k]->desig_name);
		echo "</td>";

		echo "<td>";
		print_r($value[$k]->line_name_en);
		echo "</td>";


		echo "<td>";
		$date = $value[$k]->emp_join_date;
		$year=trim(substr($date,0,4));
		$month=trim(substr($date,5,2));
		$day=trim(substr($date,8,2));
		$date_format = date("d-M-y", mktime(0, 0, 0, $month, $day, $year));
		echo $date_format;
		echo "</td>";

		echo "<td>";
		print_r ($value[$k]->gr_name);
		echo "</td>";

		$gross_salary 				= $value[$k]->gross_sal;
		$total_gross_salary 		= $total_gross_salary + $gross_salary;
		$grand_total_gross_salary 	= $grand_total_gross_salary + $gross_salary;
		echo "<td>";
		echo $gross_salary;
		echo "</td>";

		$net_pay 				= $value[$k]->net_pay ;//+ $eot_amount;
		$total_net_pay 			= $total_net_pay + $net_pay;
		$grand_total_net_pay 	= $grand_total_net_pay + $net_pay;
		echo "<td>";
		echo $net_pay;
		echo "</td>";

		echo "<td>";
		echo "&nbsp Stop &nbsp;";
		echo "</td>";

		echo "<td>";
		echo "&nbsp;";
		echo "</td>";

		echo "</tr>";
		$k++;
	}
	?>
	<tr>
		<td align="center" colspan="7"><strong>Total Per Page</strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_gross_salary);?></strong></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_net_pay);?></strong></td>

	</tr>
	<?php
	if($counter == $page)
   		{?>
			<tr height="10">
			<td colspan="7" align="center"><strong>Grand Total Amount Tk</strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_gross_salary);?></strong></td>
            <td align="right"><strong><?php echo $english_format_number = number_format($grand_total_net_pay);?></strong></td>
			</tr>
			<?php } ?>

			<table width="100%" height="80px" border="0" align="center" style="margin-bottom:50px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
	Separation Report

</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style type="text/css">
	table.main_table{
	border-collapse: collapse;
}

table.main_table tr,table.main_table tr td,table.main_table tr th{
 border: 1px solid #000000;
 
}
</style>
</style>

</head>

<body>

<?php
$per_page_id = 46;
 $row_count=count($values["emp_name"]);
 $max = $row_count;
if($row_count > $per_page_id)
{
 $page = ceil($row_count/$per_page_id);
}
else
{
$page=1;
}

$k = 0;

			
			
			
 for($counter = 1; $counter <= $page; $counter ++)
 {
?>

<table class="heading" align="center" height="auto" style="font-size:12px; width:750px;border:0px;;">
	<tr height="70px">
		<td style="text-align:center;width: 70%;padding-left:150px;">
		<?php $this->load->view("head_english");?><span style="font-size:13px; font-weight:bold; text-align: center;">
			Left Employee  Information </br>
				<?php 
					$year= trim(substr($start_date,0,4));
					$month = trim(substr($start_date,5,2));
					$tarik = trim(substr($start_date,8,2));
					$date_format_1 = date("d-M-Y", mktime(0, 0, 0, $month, 1, $year));
					$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));
					$date_format_2 = date("d-M-Y", mktime(0, 0, 0, $month, $lastday, $year));
					echo $date_format_1;
					
					echo " - TO - ";
					echo $date_format_2;
					
				?>
			</span>
		</td>
		<td style="text-align:right;width: 30%">
			<?php echo '<span style="font-family:SutonnyMJ;font-size:15px;">'."পাতা নং # $counter <br>".'</span>';?>
		</td>
	</tr>
</table>

<table class="main_table" align="center" height="auto"  style="font-size:11px; width:750px;">

<th>SL</th>
<th>Emp ID</th>
<th>Name</th>
<th style="margin:0px;padding:0px;">Designation</th>
<th>Line</th>
<th>Date of Birth</th>
<th>Joining Date</th>
<th>Left Date</th>
<th>Pay Day</th>
<th>Total Sal</th>
<th>Remarks</th>
<?php

	$section=array();		
	for($i=0; $i<=$per_page_id;$i++)
	{
		
		if($section!=$values["sec_name"][$k]){

			$i=$i+1;
			$row_count = $row_count+1;
			if($row_count >$per_page_id)
			{
			$page=ceil($row_count/$per_page_id);
			}
			else
			{
			$page=1;
			}

			echo "<tr bgcolor='#CCCCCC'>";
			echo "<td colspan='12' style='font-size:14px'>Section :&nbsp".$values["sec_name"][$k]."</td>";
			echo "</tr>";
	}

	$gross_salary 				= $values['gross_sal'][$k];
	$abs_deduction 				= $values['abs_deduction'][$k];
	$total_abs_deduction 		= $total_abs_deduction + $abs_deduction;
	$grand_total_abs_deduction 	= $grand_total_abs_deduction + $abs_deduction;

	
	$total_deduction		= $values['total_deduct'][$k];

	$net_wages				= $gross_salary-$abs_deduction;
	$total_net_wages 		= $total_net_wages + $net_wages;
	$grand_total_net_wages 	= $grand_total_net_wages + $net_wages;

	$att_bonus 					= $values['att_bonus'][$k];
	$total_att_bonus 			= $total_att_bonus + $att_bonus;
	$grand_total_att_bonus	 	= $grand_total_att_bonus + $att_bonus;

	$staff = $this->Grid_model->staff_id_collect($values['emp_id'][$k]);

	if($values['ot_entitle'][$k]==1 && $staff==1){

		$eot_hour = 0;
		$ot_hour  = 0;

	}elseif($values['ot_entitle'][$k]==0 && $staff==0){

		$ot_hour = $values['ot_hour'][$k];
		$eot_hour = $values['eot_hour'][$k];
	}
	else{
		$eot_hour = 0;
		$ot_hour  = 0;
	  }

	$total_ot_eot = $ot_hour + $eot_hour;
	
	$total_ot_hour 			= $total_ot_hour + $total_ot_eot;
	$grand_total_ot_hour 	= $grand_total_ot_hour + $total_ot_eot;
	

	if($values['ot_entitle'][$k]==1 && $staff==1){
		$ot_amount = 0;
	}elseif($values['ot_entitle'][$k]==0 && $staff==0){
		$ot_amount =  $values['ot_amount'][$k] + $values['eot_amount'][$k];
	}
	else{
		$ot_amount = 0;
	}

	$total_ot_eot_amount 		= $total_ot_eot_amount + $ot_amount;
	$grand_total_ot_eot_amount 	= $grand_total_ot_eot_amount + $ot_amount;
	
	$total_sum =  $net_wages + $att_bonus + $ot_amount + $values['due_pay_add'][$k]; 
	$in_total_sum = $in_total_sum  + $total_sum;
	$grand_total_sum = $grand_total_sum + $total_sum;
			
	$adv_deduct 			= $values['adv_deduct'][$k];
	$due_pay_add 			= $values['due_pay_add'][$k];
	$total_adv_deduct 		= $total_adv_deduct + $adv_deduct;
	$grand_total_adv_deduct = $grand_total_adv_deduct + $adv_deduct;

	
	if($values['salary_draw'][$k]==2){
		$stamp_deduct = 0;
	}else{
		$stamp_deduct = $values['stamp'][$k];			
	}
	$total_stamp_deduct 		= $total_stamp_deduct + $stamp_deduct;
	$grand_total_stamp_deduct 	= $grand_total_stamp_deduct + $stamp_deduct;

	$adv_deduct 			= $values['adv_deduct'][$k];
	$total_sum              = $total_sum - $adv_deduct;
	$net_pay				= $total_sum - $stamp_deduct;		
	$total_net_pay 			= $total_net_pay + $net_pay;
	$grand_total_net_pay 	= $grand_total_net_pay + $net_pay;

	// echo number_format($net_pay);

	$total_wages_with_stamp = $total_net_pay  + $total_stamp_deduct ;
	$grand_total_wages_with_stamp = $grand_total_net_pay + $grand_total_stamp_deduct;

	echo "<tr>";
	
	echo "<td>";
	echo $s = $k+1 ;//= $i+1;
	echo "</td>";
	
		
	echo "<td  style=''>";
	echo $values["emp_id"][$k];
	echo "</td>";
	
	
	echo "<td >";
	echo $values["emp_name"][$k];
	echo "</td>";

	
	
	echo "<td style='margin:0px;padding:0px;'>";
	echo $values["desig_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["line_name"][$k];
	echo "</td>";
	
	
	echo "<td   style=''>";
	$year= trim(substr($values["emp_dob"][$k],0,4));
	$month = trim(substr($values["emp_dob"][$k],5,2));
	$tarik = trim(substr($values["emp_dob"][$k],8,2));
	$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
	echo $date_format;
	echo "</td>";
	
	echo "<td  style=''>";
	$year= trim(substr($values["doj"][$k],0,4));
	$month = trim(substr($values["doj"][$k],5,2));
	$tarik = trim(substr($values["doj"][$k],8,2));
	$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
	echo $date_format;
	echo "</td>";
	
	echo "<td  style=''>";
	$year= trim(substr($values["e_date"][$k],0,4));
	$month = trim(substr($values["e_date"][$k],5,2));
	$tarik = trim(substr($values["e_date"][$k],8,2));
	$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
	echo $date_format;
	echo "</td>";

	echo "<td>";
	echo $values["pay_days"][$k];
	echo "</td>";

	echo "<td>";
	echo number_format($net_pay);
	echo "</td>";
	
	echo "<td  style=';'>";
	echo "&nbsp";
	echo "</td>";
	
	echo "</tr>";
		$section=$values["sec_name"][$k];
		$k++;
		if($max==$k){
			break;
		}
	}
	?>
		<table width="750" height="60px" border="0" align="center" style="margin-bottom:120px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr height="30%" >
				<td colspan="28"></td>
			</tr>
			<tr height="20%">
				<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Prepare By</dt></td>
		        <td align="center"  style="width:20%" ><dt class="bottom_txt_design" >HR Manager</dt></td>
				<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Admin Manager</dt></td>
		        <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >GM</dt></td>
		        <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >MD</dt></td>
			</tr>
		  </table>
		</table>
			  <!-- <div style="page-break-after: always;"></div> -->
		<?php
		if($max==$k){
				break;
			}
		} ?>

</body>
</html>
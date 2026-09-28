<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>
		<?php
		if ($grid_status == 1) {
			echo 'Reguler Employee ';
		} elseif ($grid_status == 2) {
			echo 'New Employee ';
		} elseif ($grid_status == 3) {
			echo 'Left Employee ';
		} elseif ($grid_status == 4) {
			echo 'Resign Employee ';
		} elseif ($grid_status == 6) {
			echo 'Promoted Employee ';
		}
		?> Monthly Salary Sheet of
		<?php echo date("F-Y", strtotime($salary_month));  ?>
	</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
	<style>
		.bottom_txt_design {
			border-top: 1px solid;
			width: 170px;
			font-weight: bold;
			text-align: center;
		}

		.bottom_txt_manager_design {
			border-top: 1px solid;
			width: 170px;
		}

		.excel {
		    border: 0;
		    background-color: #009688;
		    cursor: pointer;
		    border-radius: 10%;
		}
	</style>
</head>

<body style="margin:0 2px;">
	<div style="position:absolute; right:0" class="noprint">
		<form action="<?php echo base_url();?>salary_report_con/grid_actual_monthly_salary_sheet_excel" method="post">
			<input type="hidden" name="salary_month" value="<?php echo $salary_month; ?>"></input>
			<input type="hidden" name="grid_emp_id" value="<?php echo implode(",",$grid_emp_id); ?>"></input>
			<input type="hidden" name="grid_status" value="<?php echo $grid_status; ?>"></input>
			<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>"></input>

			<button type="submit" class="excel" alt="XLS Export">XLS Export</button>
		</form>
	</div>

	<?php $row_count = count($value);
	if ($row_count > 7) {
		$page = ceil($row_count / 7);
	} else {
		$page = 1;
	}

	$k = 0;
	$grand_total_basic_salary 		= 0;
	$grand_total_house_rent 		= 0;
	$grand_total_medical_allowance  = 0;
	$grand_total_conveyance		    = 0;
	$grand_total_food_allow		    = 0;
	$grand_total_gross_salary		= 0;
	$grand_total_transport_deduct   = 0;
	$grand_total_adv_deduct		    = 0;
	$grand_total_att_bonus			= 0;
	$grand_total_late_deduction	    = 0;
	$grand_total_hd_deduct_amount	= 0;
	$grand_total_abs_deduction		= 0;
	$grand_total_stamp_deduct		= 0;
	$grand_total_others_deduct		= 0;
	$grand_total_ot_eot_amount		= 0;
	$grand_total_ot_hour			= 0;
	$grand_total_salary             = 0;
	$grand_total_payable_salary     = 0;
	$grand_total_net_pay			= 0;
	$grand_total_holiday_allowance	= 0;
	$grand_total_net_wages			= 0;
	$grand_total_night_allowance	= 0;
	$grand_total_tax_deduct		    = 0;
	$grand_total_wages_with_stamp	= 0;
	$grand_total_sum				= 0;

	for ($counter = 1; $counter <= $page; $counter++) { ?>
		<table align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; width:auto;">
			<tr height="85px">
				<td colspan="48" align="center">
					<div style="text-align:right; position:relative; top:20px; padding-right:10px; font-weight:bold;">
						<?php $date = date('d-m-Y');
						echo "Page No # $counter of $page" ."<br>";
						//echo "Payment : " . date("d-m-Y");
						?>
					</div>
					<?php $this->load->view("head_english"); ?>
					<?php
					if ($grid_status == 1) {
						echo 'Reguler Employee ';
					} elseif ($grid_status == 2) {
						echo 'New Employee ';
					} elseif ($grid_status == 3) {
						echo 'Left Employee ';
					} elseif ($grid_status == 4) {
						echo 'Resign Employee ';
					} elseif ($grid_status == 6) {
						echo 'Promoted Employee ';
					}
					?>Monthly Salary Sheet For the Month of
					<?php
					$date_format = date("F-Y", strtotime($salary_month));
					echo $date_format;
					?>
				</td>
			</tr>
			<tr height="20px">
				<td rowspan="2" width="15" height="20px"><div align="center"><strong>SL N0</strong></div></td>
				<td rowspan="2" width="150" height="20px"><strong align="center">Name, Desig, DOJ</strong></td>
				<td rowspan="2" width="14" height="20px"><div align="center"><strong>Card No</strong></div></td>
				<td rowspan="2" width="14" height="20px"><div align="center"><strong>L.No</strong></div></td>
				<td rowspan="2" width="14" height="20px"><div align="center"><strong>Grade</strong></div></td>
				<td colspan="6" width="20" height="20px"><div align="center"><strong>Salary</strong></div></td>
				<td rowspan="2" width="20">M. Days</td>
				<td colspan="5" height="20px"><div align="center"><strong>Present Status</strong></div></td>
				<td colspan="4" height="20px"><div align="center"><strong>Leave Status</strong></div></td>
				<td colspan="3" width="25" height="20px"><div align="center"><strong>Over Time</strong></div></td>
				<td rowspan="2" width="25" height="20px"><div align="center"><strong>Attn. Bonus</strong></div></td>
				<td rowspan="2" width="25" height="20px"><div align="center"><strong>Ar.</strong></div></td>
				<td rowspan="2" width="25" height="20px"><div align="center"><strong>Payable Salary</strong></div></td>
				<td rowspan="2" width="25" height="20px"><div align="center"><strong>Total Payable Salary</strong></div></td>
				<td colspan="3" width="25" height="20px"><div align="center"><strong>Deduction</strong></div></td>
				<td rowspan="2" width="22" height="20px"><div align="center"><strong>Net Pay Salary</strong></div></td>
				<td rowspan="2" style="width: 100px"><div align="center"><strong>&nbsp;&nbsp;Signature&nbsp;&nbsp;</strong></div></td>
			</tr>
			<tr height="10px">
				<td style="font-size:8px;"><div align="center"><strong>Gross Salary</strong></div></td>
				<td style="font-size:8px;"><div align="center"><strong>Basic</strong></div></td>
				<td style="font-size:8px;"><div align="center"><strong>H/Rent</strong></div></td>
				<td width="15" style="font-size:8px;"><div align="center"><strong>Medical</strong></div></td>
				<td width="15" style="font-size:8px;"><div align="center"><strong>Food</strong></div></td>
				<td width="15" style="font-size:8px;"><div align="center"><strong>Transport</strong></div></td>

				<td width="15" style="font-size:8px;"><div align="center"><strong>Work Days</strong></div></td>
				<td width="15" style="font-size:8px;"><div align="center"><strong>Off Days</strong></div></td>
				<td width="15" style="font-size:8px;"><div align="center"><strong>Att. Days</strong></div></td>
				<td width="15" style="font-size:8px;"><div align="center"><strong>Abs. Days</strong></div></td>
				<td width="15" style="font-size:8px;"><div align="center"><strong>Pay Days</strong></div></td>

				<td width="15" style="font-size:10px;"><div align="center"><strong>CL</strong></div></td>
				<td width="15" style="font-size:10px;"><div align="center"><strong>SL</strong></div></td>
				<td width="15" style="font-size:10px;"><div align="center"><strong>EL</strong></div></td>
				<td width="15" style="font-size:10px;"><div align="center"><strong>FL</strong></div></td>

				<td width="15" style="font-size:10px;"><div align="center"><strong>Ot.Hr.</strong></div></td>
				<td width="15" style="font-size:10px;"><div align="center"><strong>Rate</strong></div></td>
				<td width="15" style="font-size:10px;"><div align="center"><strong>Ot.Pay</strong></div></td>

				<td width="15" style="font-size:10px;"><div align="center"><strong>Bus.D</strong></div></td>
				<td width="15" style="font-size:10px;"><div align="center"><strong>Adv.D</strong></div></td>
				<td width="15" style="font-size:10px;"><div align="center"><strong>Abs.D</strong></div></td>
				<!-- <td width="15" style="font-size:10px;"><div align="center"><strong>Stm</strong></div></td> -->
			</tr>
			<?php if ($counter == $page) {
				$modulus = ($row_count - 1) % 7;
				$per_page_row = $modulus;
			} else {
				$per_page_row = 6;
			}

			$total_basic_salary 	 = 0;
			$total_house_rent 		 = 0;
			$total_medical_allowance = 0;
			$total_conveyance 		 = 0;
			$total_food_allow		 = 0;
			$total_gross_salary		 = 0;
			$total_transport_deduct	 = 0;
			$total_adv_deduct		 = 0;
			$total_att_bonus		 = 0;
			$total_hd_deduct_amount	 = 0;
			$total_late_deduction	 = 0;
			$total_abs_deduction	 = 0;
			$total_stamp_deduct		 = 0;
			$total_others_deduct	 = 0;
			$total_ot_eot_amount	 = 0;
			$total_ot_hour			 = 0;
			$total_salary            = 0;
			$total_payable_salary    = 0;
			$total_net_pay			 = 0;
			$total_holiday_allowance = 0;
			$total_net_wages		 = 0;
			$total_night_allowance	 = 0;
			$total_tax_deduct		 = 0;
			$total_wages_with_stamp	 = 0;
			$total_sum				 = 0;
			$in_total_sum			 = 0;

			for ($p = 0; $p <= $per_page_row; $p++) {
				echo "<tr height='80' style='text-align:center;' >";
				echo "<td >";
				echo $k + 1;
				echo "</td>";

				echo "<td>";
				echo "<span  style='font-weight:bold;'>";
				print_r($value[$k]->emp_full_name);
				echo "</span>";
				echo '<br>';
				print_r($value[$k]->desig_name);
				echo '<br>';
				echo date('d-M-y', strtotime($value[$k]->emp_join_date));
				echo '</td>';

				echo "<td>";
				print_r($value[$k]->emp_id);
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->line_name);
				echo "</td>";

				/*echo '<td>';
					print_r($value[$k]->desig_name);
					echo '</td>';

					echo '<td>';
					echo date('d-M-y', strtotime($value[$k]->emp_join_date));
					echo '</td>';*/

				echo '<td>';
				echo $value[$k]->gr_name;
				echo '</td>';

				$gross_salary 				= $value[$k]->gross_sal;
				$total_gross_salary 		= $total_gross_salary + $gross_salary;
				$grand_total_gross_salary 	= $grand_total_gross_salary + $gross_salary;
				echo "<td>";
				echo $gross_salary;
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
				echo $food_allow = $value[$k]->food_allow;
				$total_food_allow		= $total_food_allow + $value[$k]->food_allow;
				$grand_total_food_allow	= $grand_total_food_allow + $value[$k]->food_allow;
				echo "</td>";

				echo "<td>";
				echo $trans_allow = $value[$k]->trans_allow;
				$total_conveyance 		= $total_conveyance + $value[$k]->trans_allow;
				$grand_total_conveyance	= $grand_total_conveyance + $value[$k]->trans_allow;
				echo "</td>";

				echo '<td>';
				echo $value[$k]->total_days;
				echo '</td>';

				echo "<td>";
				print_r($value[$k]->num_of_workday);
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->weekend);
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->att_days);
				echo "</td>";

				/*echo "<td>";
				print_r($value[$k]->absent_days + $value[$k]->before_after_absent);
				echo "</td>";*/
				echo "<td>";
				print_r($value[$k]->absent_days);
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->pay_days);
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->c_l);
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->s_l);
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->e_l);
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->holiday);
				echo "</td>";

				$total_ot_eot = $value[$k]->ot_hour + $value[$k]->eot_hour;
				$total_ot_hour 			= $total_ot_hour + $total_ot_eot;
				$grand_total_ot_hour 	= $grand_total_ot_hour + $total_ot_eot;
				echo "<td>";
				echo $total_ot_eot;
				echo "</td>";

				echo "<td>";
				print_r($value[$k]->ot_rate);
				echo "</td>";

				$ot_amount =  $value[$k]->ot_amount + $value[$k]->eot_amount;
				$total_ot_eot_amount 		= $total_ot_eot_amount + $ot_amount;
				$grand_total_ot_eot_amount 	= $grand_total_ot_eot_amount + $ot_amount;
				echo "<td>";
				echo $ot_amount;
				echo "</td>";

				$att_bonus 					= $value[$k]->att_bonus;
				$total_att_bonus 			= $total_att_bonus + $att_bonus;
				$grand_total_att_bonus	 	= $grand_total_att_bonus + $att_bonus;
				echo "<td>";
				echo $att_bonus;
				echo "</td>";

				echo "<td>";
				echo '0';
				echo "</td>";

				$net_pay 				= $value[$k]->net_pay;
				$total_salary           = $total_salary + $net_pay + $att_bonus;
				$grand_total_salary     = $grand_total_salary + $net_pay + $att_bonus;
				echo "<td>";
				echo $net_pay + $att_bonus;
				echo "</td>";

				$total_payable_salary       = $value[$k]->net_pay + $att_bonus + $ot_amount;
				$grand_total_payable_salary = $value[$k]->net_pay + $att_bonus + $ot_amount;
				echo "<td>";
				echo $net_pay + $att_bonus + $ot_amount;
				echo "</td>";

				$transport_deduct 		      = $value[$k]->transport_deduct;
				$total_transport_deduct       = $total_transport_deduct + $transport_deduct;
				$grand_total_transport_deduct = $grand_total_transport_deduct + $transport_deduct;
				echo "<td>";
				echo $transport_deduct;
				echo "</td>";

				$adv_deduct 			= $value[$k]->adv_deduct;
				$due_pay_add 			= $value[$k]->due_pay_add;
				$total_adv_deduct 		= $total_adv_deduct + $adv_deduct;
				$grand_total_adv_deduct = $grand_total_adv_deduct + $adv_deduct;
				echo "<td>";
				echo $adv_deduct;
				echo "</td>";

				$abs_deduction 				= $value[$k]->abs_deduction;
				$total_abs_deduction 		= $total_abs_deduction + $abs_deduction;
				$grand_total_abs_deduction 	= $grand_total_abs_deduction + $abs_deduction;
				echo "<td>";
				echo $abs_deduction;
				echo "</td>";

				$stamp_deduct 				= $value[$k]->stamp;
				$total_stamp_deduct 		= $total_stamp_deduct + $stamp_deduct;
				$grand_total_stamp_deduct 	= $grand_total_stamp_deduct + $stamp_deduct;
				/*echo "<td>";
				echo $stamp_deduct;
				echo "</td>";*/

				echo "<td>";
				echo $net_pay + $att_bonus + $ot_amount - $value[$k]->total_deduct;
				echo "</td>";

				echo "<td>";
				echo $value[$k]->bank_ac_no;
				echo "</td>";

				$total_deduction	   = $value[$k]->total_deduct;
				$total_net_pay 		   = $total_net_pay  + $net_pay + $att_bonus + $ot_amount - $total_deduction;
				$grand_total_net_pay   = $grand_total_net_pay + $net_pay + $att_bonus + $ot_amount - $total_deduction;

				echo "</tr>";
				$k++;
			}

		?>
			<tr>
				<td align="center" colspan="5" style="font-size:13px;"><strong>Total Per Page </strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_gross_salary); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_basic_salary); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_house_rent); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_medical_allowance); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_food_allow); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_conveyance); ?></strong></td>
				<td align="center" colspan="10"></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_ot_hour); ?></strong></td>
				<td align="center" colspan="1"></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_ot_eot_amount); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_att_bonus); ?></strong></td>
				<td align="center" style="font-size:11px;">0</td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_salary); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_payable_salary); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_transport_deduct); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_adv_deduct); ?></strong></td>
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_abs_deduction); ?></strong></td>
				<!-- <td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_stamp_deduct); ?></strong></td> -->
				<td align="center" style="font-size:11px;"><strong><?php echo $english_format_number = number_format($total_net_pay); ?></strong></td>

			</tr>
			<?php if ($counter == $page) { ?>
				<tr height="10">
					<td colspan="5" align="center"><strong style="font-size:11px;">Grand Total</strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_gross_salary); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_basic_salary); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_house_rent); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_medical_allowance); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_food_allow); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_conveyance); ?></strong></td>
					<td align="center" colspan="10"></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_ot_hour); ?></strong></td>
					<td align="center" colspan="1"></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_ot_eot_amount); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_att_bonus); ?></strong></td>
					<td align="center" colspan="1">0</td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_salary); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_payable_salary); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_transport_deduct); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_adv_deduct); ?></strong></td>
					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_abs_deduction); ?></strong></td>
					
					<!-- <td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_stamp_deduct); ?></strong></td> -->

					<td align="center" style="font-size:10px;"><strong><?php echo $english_format_number = number_format($grand_total_net_pay); ?></strong></td>
				</tr>
			<?php } ?>
			<table width="100%" height="35px" border="0" align="center" style="margin:50px 0px 50px 30px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">
				<tr height="10%">
					<td align="left" style="width:15%;"><dt class="bottom_txt_design">Admin Department</dt></td>
					<td align="left" style="width:15%"><dt class="bottom_txt_design">Account Department</dt></td>
					<td align="left" style="width:15%"><dt class="bottom_txt_design">CEO</dt></td>
					<td align="left" style="width:15%"><dt class="bottom_txt_design">Managing Director</dt></td>
					<td align="left" style="width:15%"><dt class="bottom_txt_design">Chairman</dt></td>
				</tr>
			</table>
			<div style="page-break-after: always;"></div>
		</table>
	<?php } ?>
</body>

</html>

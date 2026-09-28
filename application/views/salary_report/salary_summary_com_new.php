<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Monthly Salary Summary Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../../css/print.css" media="print" />

<style type="text/css">
.sal tr td{
border:1px #000000 solid;
border-top-style:none;
border-left-style:none;
padding-right:2px;

}
.sal{
border:1px #000000 solid;
   border-bottom-style: none;
   border-right-style: none;
   }
   
.det tr td{
border:1px #000000 solid;
border-top-style:none;
border-left-style:none;

}
.det{
border:1px #000000 solid;
   border-bottom-style: none;
   border-right-style: none;
   }
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

<div style="width:auto; ">
<?php 
//$unit_name['unit_name'] = $this->db->where("unit_id",$grid_unit)->get('pr_units')->row()->unit_name;

//$data['unit_id'] = $grid_unit;
$this->load->view("head_english");
?>


<div style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif; width:100%; ">
	<div  style="font-size:13px; font-weight:bold; text-align:center; width:100%;">
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
	?>
	Monthly Salary Summary of 
	<?php 
	$date = $salary_month;
	$year=trim(substr($date,0,4));
	$month=trim(substr($date,5,2));
	$date_format = date("F-Y", mktime(0, 0, 0, $month, 1, $year));
	echo $date_format;
	
	?></div>
	<br />
	
	<table class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; margin:0 auto;">
		<tr height="20" align="center" style="font-weight:bold; background-color:#CCC;">
			<td height="60"  width="200">Line</td>
			<td   width="150">Total MP</td>
			<td   width="150">Cash MP</td>
			<td   width="150">Bank MP</td>
			<td   width="150">Gross  Salary</td>
			<td   width="150">Basic  Salary</td>
			<td   width="150">House Rent</td>
			<td   width="150">Medical Allowance</td>
			<td   width="150">Food Allowance</td>
			<td   width="150">Conveyance Allowance </td>
			<td   width="150">Salary Amount</td>
			<td   width="150">OT Hour</td>
			<td   width="150">OT Amount</td>
			<td   width="150">Attn Bonus</td>
			<td   width="150">Cash TTl Amount</td>
			<td   width="150">Bank TTl Amount</td>
			<td   width="150">Cash & Bank TTL Amount</td>
		</tr>
  	
		<?php
			$gt_mp 			= 0;
			$gt_cash_mp 	= 0;
			$gt_bank_mp 	= 0;
			$gt_gross 		= 0;
			$gt_basic 		= 0;
			$gt_house_r		= 0;
			$gt_medical 	= 0;
			$gt_food 		= 0;
			$gt_transport 	= 0;
			$gt_salary_amt 	= 0;
			$gt_ot_hour 	= 0;
			$gt_ot_amount 	= 0;
			$gt_attn_bonus 	= 0;
			$gt_cash_salary = 0;
			$gt_bank_salary = 0;
			$gt_net_salary	= 0;
			$total_gross_salary = 0;
			// dd($values);
			// foreach ($values as $item) {
			//     $sec_name_en = $item->sec_name_en;
			//     if (isset($counts[$sec_name_en])) {
			//         $counts[$sec_name_en]++;
			//     } else {
			//         $counts[$sec_name_en] = 1;
			//     }
			// }
			// $count = count($counts);
		foreach($values as $row)
		{
			echo "<tr>";
			
			echo "<td  style='text-align:left; padding-left:3px; font-size:11px;'>";
			echo $row->line_name_en;
			echo "</td>";
			
			$total_emp = $row->emp_cash; 
            // + $row->emp_bank;
			echo "<td align='center'>";
			echo $total_emp;
			echo "</td>";
			$gt_mp = $gt_mp + $total_emp;
			 
			echo "<td align='center'>";
			echo $row->emp_cash;
			echo "</td>";
			$gt_cash_mp = $gt_cash_mp + $row->emp_cash;
			
			echo "<td align='center'>";
			echo $row->emp_bank;
			echo "</td>";
			$gt_bank_mp = $gt_bank_mp ;
            // + $row->emp_bank;
			// $total_gross_salary = 0;			
			$total_gross_salary = $row->cash_sum ;
            // + $row->bank_sum;
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_gross_salary);
			echo "</td>";
			$gt_gross = $gt_gross + $total_gross_salary;
			
			//BASIC SALARY		
			$total_basic_salary = $row->cash_sum_basic_sal ;
            // + $row->bank_sum_basic_sal;			
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_basic_salary);
			echo "</td>";
			$gt_basic = $gt_basic + $total_basic_salary;
			
			//HOUSE RENT		
			$total_house_rent = $row->cash_sum_house_r ;
            // + $row->bank_sum_house_r;		
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_house_rent);
			echo "</td>";
			$gt_house_r = $gt_house_r + $total_house_rent;
			
			//MEDICAL ALLOWANCE	
			$total_medical_a = $row->cash_sum_medical_a ;
            // + $row->bank_sum_medical_a;
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_medical_a);
			echo "</td>";
			$gt_medical = $gt_medical + $total_medical_a;
			
			//FOOD ALLOWANCE	
			$total_food_allow = $row->cash_sum_food_allow ;
            // + $row->bank_sum_food_allow;
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_food_allow);
			echo "</td>";
			$gt_food = $gt_food + $total_food_allow;
			
			//TRANSPORT ALLOWANCE	
			$total_trans_allow = $row->cash_sum_trans_allow ;
            // + $row->bank_sum_trans_allow;
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_trans_allow);
			echo "</td>";
			$gt_transport = $gt_transport + $total_trans_allow;
	
			$total_net_pay = $row->cash_sum_net_pay+ $row->bank_sum_net_pay ;							 	
			$total_ot_amount = $row->cash_ot_amount + $row->bank_ot_amount;
			$total_attn_bonus = $row->cash_att_bonus + $row->bank_att_bonus;
					
			// $total_salary_amount = $total_net_pay - ($total_ot_amount + $total_attn_bonus); 
			$total_salary_amount = $total_net_pay + ($total_emp * 0) - ($total_ot_amount + $total_attn_bonus); 
			//$gross_salary - $total_deduction + $value[$k]->stamp + $value[$k]->adv_deduct;
			
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_salary_amount);
			echo "</td>";
			$gt_salary_amt = $gt_salary_amt + $total_salary_amount;
			
			//TOTAL OT HOUR
			$total_ot_hour = $row->cash_sum_ot_hour;
            // + $row->bank_sum_ot_hour;
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_ot_hour);
			echo "</td>";
			$gt_ot_hour = $gt_ot_hour + $total_ot_hour;
			
			//TOTAL OT AMOUNT 
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_ot_amount);
			echo "</td>";
			$gt_ot_amount = $gt_ot_amount + $total_ot_amount;
						
			//TOTAL ATTENDANCE BONUS
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_attn_bonus);
			echo "</td>";
			$gt_attn_bonus = $gt_attn_bonus + $total_attn_bonus;
			
			//CASH TOTAL NET WAGES
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($row->cash_sum_net_pay +$row->stam_deduct_cash);
			echo "</td>";
			$gt_cash_salary = $gt_cash_salary + $row->cash_sum_net_pay+$row->stam_deduct_cash;
			
			//BANK TOTAL NET WAGES
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($row->bank_sum_net_pay + $row->stam_deduct_bank);
			echo "</td>";
			$gt_bank_salary = $gt_bank_salary + $row->bank_sum_net_pay + $row->stam_deduct_bank;
			
			//CASH & BANK TOTAL NET WAGES
			$total_net_pay_with_stamp = $row->cash_sum_net_pay+ $row->bank_sum_net_pay + $row->stam_deduct_cash +$row->stam_deduct_bank;							 	

			
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_net_pay_with_stamp);
			echo "</td>";
			$gt_net_salary = $gt_net_salary + $total_net_pay_with_stamp;

			echo "</tr>";
		}
		echo "<tr style='font-weight:bold; background-color:#CCC; font-size:15px; padding: 3px;'>";
		
		echo "<td align='center'>";
		echo "Total";
		echo "</td>";
		
		echo "<td align='center'>";
		echo $gt_mp;
		echo "</td>";
		
		echo "<td align='center'>";
		echo $gt_cash_mp;
		echo "</td>";
		
		echo "<td align='center'>";
		echo $gt_bank_mp;
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_gross);
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_basic);
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_house_r);
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_medical);
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_food);
		echo "</td>";

		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_transport) ;
		echo "</td>";

		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_salary_amt);
		echo "</td>";

		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_ot_hour);
		echo "</td>";

		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_ot_amount);
		echo "</td>";

		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_attn_bonus);
		echo "</td>";
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_cash_salary);
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_bank_salary);
		echo "</td>";
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($gt_net_salary);
		echo "</td>";
				
		echo "</tr>";
	?>
		<tr>
			<td colspan="17">
				<?php $this->load->view("authorised_signature");?>
			</td>
		</tr>
	</table>

	
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Monthly Salary Summary Report Section Wise</title>
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
	Monthly Section Wise Salary Summary of 
	<?php 
	$date = $salary_month;
	$year=trim(substr($date,0,4));
	$month=trim(substr($date,5,2));
	$date_format = date("F-Y", mktime(0, 0, 0, $month, 1, $year));
	echo $date_format;
	
	?></div>
	<br />
	
	<table class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0 auto;">

  <tr height="20" align="center" style="font-weight:bold; background-color:#CCC;">
    <td height="60"  width="200">Section</td>
    <td   width="150">Total MP</td>
    <td   width="150">Cash MP</td>
    <td   width="150">Bank MP</td>
    <td   width="150">Gross  Salary</td>
	<td   width="150">Basic  Salary</td>
    <td   width="150">House Rent</td>
    <td   width="150">Medical Allowance</td>
    <td   width="150">Food Allowance</td>
    <td   width="150">Conveyance Allowance </td>
    <td   width="150">Payable Salary Amount</td>
    <td   width="150">OT Hour</td>
    <td   width="150">OT Amount</td>
    <td   width="150">Attn Bonus</td>
    <td   width="150">TTl Payable Amount<br>(Without Stamp)</td>
    <td   width="150">Bank TTl Amount</td>
    <td   width="150">TTl Payable Amount<br>(With Stamp)</td>
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
		$gt_attn_bonus_man 	= 0;
		$gt_cash_salary = 0;
		$gt_bank_salary = 0;
		$gt_net_salary	= 0;
		
		$count = count($values["sec_name_en"]);
		
		for($i=0; $i < $count; $i++)
		{
			echo "<tr>";
			
			echo "<td  style='text-align:left; padding-left:5px;'>";
			echo $values["sec_name_en"][$i];
			echo "</td>";
			
			$total_emp = $values["emp_cash"][$i] + $values["emp_bank"][$i];
			echo "<td align='center'>";
			echo $total_emp;
			echo "</td>";
			$gt_mp = $gt_mp + $total_emp;
			 
			echo "<td align='center'>";
			echo $values["emp_cash"][$i];
			echo "</td>";
			$gt_cash_mp = $gt_cash_mp + $values["emp_cash"][$i];
			
			echo "<td align='center'>";
			echo $values["emp_bank"][$i];
			echo "</td>";
			$gt_bank_mp = $gt_bank_mp + $values["emp_bank"][$i];
						
			$total_gross_salary = $values["cash_sum"][$i] + $values["bank_sum"][$i];
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_gross_salary);
			echo "</td>";
			$gt_gross = $gt_gross + $total_gross_salary;
			
			//BASIC SALARY		
			$total_basic_salary = $values["cash_sum_basic"][$i] + $values["bank_sum_basic"][$i];			
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_basic_salary);
			echo "</td>";
			$gt_basic = $gt_basic + $total_basic_salary;
			
			//HOUSE RENT		
			$total_house_rent = $values["cash_sum_house_r"][$i] + $values["bank_sum_house_r"][$i];		
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_house_rent);
			echo "</td>";
			$gt_house_r = $gt_house_r + $total_house_rent;
			
			//MEDICAL ALLOWANCE	
			$total_medical_a = $values["cash_sum_medical_a"][$i] + $values["bank_sum_medical_a"][$i];
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_medical_a);
			echo "</td>";
			$gt_medical = $gt_medical + $total_medical_a;
			
			//FOOD ALLOWANCE	
			$total_food_allow = $values["cash_sum_food_allow"][$i] + $values["bank_sum_food_allow"][$i];
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_food_allow);
			echo "</td>";
			$gt_food = $gt_food + $total_food_allow;
			
			//TRANSPORT ALLOWANCE	
			$total_trans_allow = $values["cash_sum_trans_allow"][$i] + $values["bank_sum_trans_allow"][$i];
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_trans_allow);
			echo "</td>";
			$gt_transport = $gt_transport + $total_trans_allow;
	
			$total_net_pay = $values["cash_sum_net_pay"][$i]+ $values["bank_sum_net_pay"][$i] ;							 	
			$total_ot_amount = $values["cash_sum_ot_amount"][$i] + $values["bank_sum_ot_amount"][$i];
			$total_w_h_ot_hour_amt = $values["cash_sum_w_h_ot_amt"][$i]+$values["bank_sum_w_h_ot_amt"][$i];
			$total_ot_amt_sum = $total_ot_amount - $total_w_h_ot_hour_amt;
			$total_attn_bonus = $values["cash_att_bonus"][$i] + $values["bank_att_bonus"][$i];
			$att_bonus_man_total = $values["att_bonus_man_total"][$i];		
			$total_salary_amount = $total_net_pay - ($total_ot_amt_sum + $total_attn_bonus); 
			
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_salary_amount+ $values["stam_deduct_cash"][$i] +$values["stam_deduct_bank"][$i]);
			echo "</td>";
			$gt_salary_amt = $gt_salary_amt + $total_salary_amount+$values["stam_deduct_cash"][$i] +$values["stam_deduct_bank"][$i];
			
			//TOTAL OT HOUR
			$total_ot_hour = $values["cash_sum_ot_hour"][$i]+ $values["bank_sum_ot_hour"][$i];
			$total_w_h_ot_hour = $values["cash_sum_w_h_ot_hour"][$i] + $values["bank_sum_w_h_ot_hour"][$i];
			
			echo "<td align='right' style='padding-right:5px;'>";
			$total_ot_sum = $total_ot_hour - $total_w_h_ot_hour;
			// echo number_format($total_ot_hour);
			echo number_format($total_ot_sum);
			echo "</td>";
			// $gt_ot_hour = $gt_ot_hour + $total_ot_hour;
			$gt_ot_hour = $gt_ot_hour + $total_ot_sum;
			
			//TOTAL OT AMOUNT 
			echo "<td align='right' style='padding-right:5px;'>";
			//echo $total_w_h_ot_hour_amt.'=';
			echo number_format($total_ot_amt_sum);
			echo "</td>";
			$gt_ot_amount = $gt_ot_amount + $total_ot_amt_sum;
						
			//TOTAL ATTENDANCE BONUS
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_attn_bonus);
			echo "<br>($att_bonus_man_total)";
			echo "</td>";
			$gt_attn_bonus = $gt_attn_bonus + $total_attn_bonus;
			$gt_attn_bonus_man = $gt_attn_bonus_man + $att_bonus_man_total;
			
			//CASH TOTAL NET WAGES
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($values["cash_sum_net_pay"][$i] - $total_w_h_ot_hour_amt);
			echo "</td>";
			$gt_cash_salary = $gt_cash_salary + $values["cash_sum_net_pay"][$i] - $total_w_h_ot_hour_amt;
			
			//BANK TOTAL NET WAGES
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($values["bank_sum_net_pay"][$i]);
			echo "</td>";
			$gt_bank_salary = $gt_bank_salary + $values["bank_sum_net_pay"][$i];
			
			//CASH & BANK TOTAL NET WAGES
				$total_net_pay_with_stamp = $values["cash_sum_net_pay"][$i]+ $values["bank_sum_net_pay"][$i] + $values["stam_deduct_cash"][$i] +$values["stam_deduct_bank"][$i]-$total_w_h_ot_hour_amt;							 	

			
			echo "<td align='right' style='padding-right:5px;'>";
			echo number_format($total_net_pay_with_stamp);
			echo "</td>";
			$gt_net_salary = $gt_net_salary + $total_net_pay_with_stamp;

			echo "</tr>";
		}
		echo "<tr style='font-weight:bold; background-color:#CCC;'>";
		
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
		echo "<br>($gt_attn_bonus_man)";
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
	</table>
	<table width="100%" height="80px" border="0" align="center" style="margin-bottom:85px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">
			<tr height="80%" >
			<td colspan="28"></td>
			</tr>
			<tr height="20%">
			
            <td align="center"  style="width:25%" ><dt class="bottom_txt_design" >Admin & HR Dept.</dt></td>
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Accounts</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Director</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Managing Director</dt></td>
			</tr>
			
			</table>
	
</body>
</html>
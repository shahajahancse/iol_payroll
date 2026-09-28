<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Monthly EOT Summary Report</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/table.css" />

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
<div style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif; width:100%; ">


<table class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0 auto;">
<tr>
<td colspan="10">
<?php 
$data['unit_id'] = $unit_id;
$this->load->view("head_english",$data);
?>


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
	Monthly EOT Summary of 
	<?php 
	$date = $salary_month;
	$year=trim(substr($date,0,4));
	$month=trim(substr($date,5,2));
	$date_format = date("F-Y", mktime(0, 0, 0, $month, 1, $year));
	echo $date_format;
	
	?></div>
	</td>
</tr>	
  <tr height="20" align="center" style="font-weight:bold; background-color:#CCC;">
    <td height="60" width="150">Line</td>
    <td width="85">Total MP</td>
    <td  width="85">Cash MP</td>
    <td  width="85">Bank MP</td>
    
    <td  width="85">Gross Salary</td>
    <td  width="85">Extar OT Hours</td>
    <td  width="85">OT Amount</td>
    
    <td  width="85">Payable Amount</td>
    <td  width="85">Bank TTL Amount</td>
    <td  width="85">TTL Payable Amount</td>
  </tr>
 
  
		<?php
		$total_cash_emp = 0;
		$total_bank_emp = 0;
		$total_cash_eot_hour = 0;
		$total_bank_eot_hour = 0;
		$total_cash_eot_amount = 0;
		$total_bank_eot_amount = 0;
		$total_emp_cash_bank =0;
		$total_cash_bank_eot_hour =0;
		$total_cash_bank_eot_amount = 0;
		$total_gross_cash_bank = 0;
		$total_cash_eot_hour = 0;
		
		
		$count = count($values["dept"]);
		for($i=0; $i < $count; $i++)
		{
			echo "<tr>";
			
			echo "<td align='center'>";
			echo $values["dept"][$i];
			echo "</td>";
			
				
			echo "<td align='center'>";
			echo $values["emp_cash_bank"][$i];
			echo "</td>";
			
			$total_emp_cash_bank = $total_emp_cash_bank + $values["emp_cash_bank"][$i];
			 
			echo "<td align='center'>";
			echo $values["emp_cash"][$i];
			echo "</td>";
			
			$total_cash_emp = $total_cash_emp + $values["emp_cash"][$i];
			
			echo "<td align='center'>";
			echo $values["emp_bank"][$i];
			echo "</td>";
			
			$total_bank_emp = $total_bank_emp + $values["emp_bank"][$i];
			
			
			echo "<td align='center'>";
			echo $values["gross_cash_bank"][$i];
			echo "</td>";
			
			$total_gross_cash_bank = $total_gross_cash_bank + $values["gross_cash_bank"][$i];
			
			$user_id = $this->acl_model->get_user_id($this->session->userdata('username'));
			$acl     = $this->acl_model->get_acl_list($user_id);
			if(in_array(14,$acl)){
				$eot_cash_bank_hour 	= $values["eot_hr_for_sa_cash_bank"][$i];
				$eot_cash_bank_amount 	= $values["eot_amt_for_sa_cash_bank"][$i];
				$eot_amount_cash_sum	= $values["eot_amt_for_sa_cash_sum"][$i];
				$eot_amount_bank_sum 	= $values["eot_amt_for_sa_bank_sum"][$i];	
			}
			else
			{
				$eot_cash_bank_hour 	= $values["eot_cash_bank_hour"][$i];
				$eot_cash_bank_amount 	= $values["eot_cash_bank_amount"][$i];
				$eot_amount_cash_sum	= $values["eot_amount_cash_sum"][$i];
				$eot_amount_bank_sum 	= $values["eot_amount_bank_sum"][$i];	
			}
				
			//======================================================
			
			echo "<td align='right'>";
			echo number_format($eot_cash_bank_hour);
			echo "</td>";
			
			$total_cash_bank_eot_hour = $total_cash_bank_eot_hour + $eot_cash_bank_hour;
		
			//======================================================
			
			
			echo "<td align='right'>";
			echo number_format($eot_cash_bank_amount);
			echo "</td>";
			
			$total_cash_bank_eot_amount = $total_cash_bank_eot_amount + $eot_cash_bank_amount;
			
			echo "<td align='right'>";
			echo number_format($eot_amount_cash_sum);
			echo "</td>";
			
			$total_cash_eot_amount = $total_cash_eot_amount + $eot_amount_cash_sum;
			
			echo "<td align='right'>";
			echo number_format($eot_amount_bank_sum);
			echo "</td>";
			
			$total_bank_eot_amount = $total_bank_eot_amount + $eot_amount_bank_sum;
			
			
			echo "<td align='right'>";
			echo number_format($eot_cash_bank_amount);
			echo "</td>";
			
			echo "</tr>";
		}
		echo "<tr style='font-weight:bold; background-color:#CCC;'>";
		
		echo "<td align='center'>";
		echo "Total";
		echo "</td>";
		
		echo "<td align='center'>";
		echo $total_emp_cash_bank;
		echo "</td>";
		
		echo "<td align='center'>";
		echo $total_cash_emp;
		echo "</td>";
		
		echo "<td align='center'>";
		echo $total_bank_emp;
		echo "</td>";
		
		echo "<td align='right'>";
		echo number_format($total_gross_cash_bank);
		echo "</td>";
		
		
		
		
		echo "<td align='right'>";
		echo number_format($total_cash_bank_eot_hour);
		echo "</td>";
		
		echo "<td align='right'>";
		echo number_format($total_cash_bank_eot_amount);
		echo "</td>";
		
		echo "<td align='right'>";
		echo number_format($total_cash_eot_amount);
		echo "</td>";
		
		echo "<td align='right'>";
		echo number_format($total_bank_eot_amount);
		echo "</td>";
		
		
		echo "<td align='right'>";
		echo number_format($total_cash_bank_eot_amount);
		echo "</td>";
		echo "</tr>";
	?>
	</table>
	<table width="80%" height="80px" border="0" align="center" style="margin-bottom:85px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">
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
</div>
</div>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Continuous Costing Report</title>

</head>

<body>

<div style=" margin:0 auto;  width:780px;">
<?php 

$this->load->view("head_english");
?>
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:12px; font-weight:bold;">
Continuous Costing Report From <?php echo $firstdate; ?> To  <?php echo $seconddate; ?></span>
<br />
<br />


<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px;">
<th>SL</th>
<th>Emp ID</th>
<th>Employee Name</th>
<th>Section</th>
<th>Designation</th>
<th>Gross Sal</th>
<th>Per Day Salary</th>
<th>Pay Days</th>
<th>OT Hour</th>
<th>EOT Hour</th>   
<th>OT Rate</th>  
<th>OT Amt.</th> 
<th>EOT Amt.</th> 
<th>Total Salary</th> 


<?php
$total_eot_amount = 0;
$total_ot_hour = 0;
$total_extra_ot_hour = 0;
$total_ot_amount = 0;
$total_per_day_salary = 0;

$total_salary = 0;

$line_name=array();
$count = count($values["emp_id"]);
for($i=0; $i<$count; $i++ )
{
	if($line_name !=$values["line_name"][$i]){
	echo "<tr bgcolor='#CCCCCC'>";
	echo "<td colspan='15' style='font-size:16px; font-weight : bold;'>Line :".$values["line_name"][$i]."</td>";
	echo "</tr>";
	}
	
	echo "<tr>";
	
	echo "<td style='text-align:center;'>";
	echo $k = $i+1;
	echo "</td>";
	
	echo "<td style='text-align:center;padding:0px 5px;'>";
	echo $values["emp_id"][$i];
	echo "</td>";


	echo "<td   style='text-align:left;padding-left:5px;' >";
	echo $values["emp_full_name"][$i];
	echo "</td>";
	

	
	echo "<td style='text-align:left;padding-left:5px;'>";
	echo $values["sec_name"][$i];
	echo "</td>";

	
	/*echo "<td  style='text-align:left;padding-left:5px;'>";
	echo $values["line_name"][$i];
	echo "</td>";*/
	
	echo "<td  style='text-align:left;padding-left:5px;'>";
	echo $values["desig_name"][$i];
	echo "</td>";
	

	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $values["gross_sal"][$i];
	echo "</td>";
	
	$gross_sal = $values["gross_sal"][$i];
	$per_day_salary = round($gross_sal / 30);
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $per_day_salary;
	echo "</td>";
	$total_per_day_salary = $total_per_day_salary + $per_day_salary;
	
	echo "<td  style='text-align:center;' >";
	echo $values["total_day"][$i];
	echo "</td>";
	
	echo "<td  style='text-align:center;' >";
	echo $values["ot_hour"][$i];
	echo "</td>";
	
	
	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $values["extra_ot_hour"][$i];
	echo "</td>";
	
	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $values["ot_rate"][$i];
	echo "</td>";
	
	
	$ot_amount = round($values["ot_hour"][$i] * $values["ot_rate"][$i]);
	$eot_amount = round($values["extra_ot_hour"][$i] * $values["ot_rate"][$i]);
	
	
	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $ot_amount;
	echo "</td>";
	$total_ot_amount = $total_ot_amount + $ot_amount;
	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $eot_amount;
	echo "</td>";
	$total_eot_amount = $total_eot_amount + $eot_amount;
	
	$total_day_salary = $values["total_day"][$i] * $per_day_salary;
	
	$total_amount = $ot_amount + $eot_amount + $total_day_salary;
	
	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $total_amount;
	echo "</td>";
	
	$total_salary = $total_salary + $total_amount;

	

	
	echo "</tr>";
	$line_name = $values["line_name"][$i];
	
}

?>
<tr>
<td  colspan="13" style="text-align:center; font-weight:bold;" >
Grand Total
</td>

<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_salary); ?></td>
</tr>
</table>
</div>
</div>
</body>
</html>
<br><br><br>
<?php exit(); ?>
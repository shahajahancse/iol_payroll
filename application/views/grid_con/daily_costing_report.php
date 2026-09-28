<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily Cost Report</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />

</head>

<body>

<div style=" margin:0 auto; ">
<?php
$emp_id = $values["emp_id"][1];
$data['unit_id'] = $unit_id;//$this->db->where("emp_id",$emp_id)->get('pr_emp_com_info')->row()->unit_id;
$this->load->view("head_english",$data);
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:12px; font-weight:bold;">
Daily Cost Report <?php echo "$grid_date"; ?></span>
<br />
<br />
<?php

$num_of_days = date("t",strtotime($grid_date));




?>

<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:14px;width:60%">
<th style="padding:4px;">SL</th>
<th style="padding:4px;">Emp ID</th>
<th style="padding:4px;">Employee Name</th>
<th style="padding:4px;">Designation</th>
<th style="padding:4px;">Line</th>
<th style="padding:4px;">Status</th>
<th style="padding:4px;">Gross Sal</th>
<th style="padding:4px;">Per Day Salary</th>
<th style="padding:4px;">OT Hour</th>
<th style="padding:4px;">EOT Hour</th>
<th style="padding:4px;">OT Rate</th>
<th style="padding:4px;">OT Amount</th>
<th style="padding:4px;">EOT Amount</th>
<th style="padding:4px;">Night Allowence</th>
<th style="padding:4px;">Holiday Allowence</th>
<th style="padding:4px;">Ifter Allowence</th>
<th style="padding:4px;">Total Salary</th>


<?php
$total_eot_amount = 0;
$total_ot_hour = 0;
$total_extra_ot_hour = 0;
$total_ot_amount = 0;
$total_per_day_salary = 0;

$total_salary = 0;

$line_name=array();
$count = count($values["emp_id"]);
for($i=0; $i<$count; $i++ ){
	if($line_name !=$values["line_name"][$i]){
	echo "<tr bgcolor='#CCCCCC'>";
	echo "<td colspan='17' style='font-size:16px; font-weight : bold;'>Line :".$values["line_name"][$i]."</td>";
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

	echo "<td  style='text-align:left;padding-left:5px;'>";
	echo $values["desig_name"][$i];
	echo "</td>";

	echo "<td style='text-align:left;padding-left:5px;'>";
	echo $values["line_name"][$i];
	echo "</td>";

	echo "<td style='text-align:center;'>";
	echo $values["present_status"][$i];
	echo "</td>";

	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $values["gross_sal"][$i];
	echo "</td>";

	$gross_sal = $values["gross_sal"][$i];
	$per_day_salary = round($gross_sal / $num_of_days);

	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $per_day_salary;
	echo "</td>";
	$total_per_day_salary = $total_per_day_salary + $per_day_salary;

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


	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $values['night_allo'][$i];
	echo "</td>";



	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $values['holiday_allo'][$i];
	echo "</td>";



	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $values['tiffin_allo'][$i];
	echo "</td>";

	$total_amount = $ot_amount + $eot_amount + $per_day_salary;

	echo "<td  style='text-align:right;padding-right:5px' >";
	echo $total_amount;
	echo "</td>";

	$total_salary = $total_salary + $total_amount;




	echo "</tr>";
	$line_name = $values["line_name"][$i];

}

?>
<tr>
<td  colspan="16" style="text-align:center; font-weight:bold;" >
Grand Total
</td>
<!--<td colspan="12" style="text-align:center; font-weight:bold;" ><?php echo $total_per_day_salary; ?></td>
<td  colspan="3" style="text-align:center; font-weight:bold;" ></td>

<td style="text-align:center; font-weight:bold;" ><?php echo $total_ot_amount; ?></td>
<td style="text-align:center; font-weight:bold;" ><?php echo $total_eot_amount; ?></td>-->
<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_salary); ?></td>
</tr>
</table>
</div>
</div>
<br><br>
</body>
</html>
<?php exit(); ?>

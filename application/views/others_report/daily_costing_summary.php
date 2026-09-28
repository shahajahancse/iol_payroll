<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily Costing Summary</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />

</head>

<body>

<div style=" margin:0 auto;  width:850px;">
<?php 
// dd($values);
// $emp_id = $values["emp_id"];
// $data1['unit_id'] = $unit_id;/
//$this->db->where("emp_id",$emp_id)->get('pr_emp_com_info')->row()->unit_id;
$this->load->view("head_english",$unit_id);
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:12px; font-weight:bold;">
	Daily Costing Summary <?php echo $date; ?></span>
<br />
<br />
<?php

$num_of_days 	= date("t",strtotime($date));


?>

<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px;">
<th>SL</th>
<th>Line</th> 
<th>Emp</th> 
<th>Gross Sal</th>
<th>Per Day Salary</th>
<th>OT Hour</th>
<th>EOT Hour</th>   
<th>OT Amount</th> 
<th>EOT Amount</th> 
<th>Total Salary</th> 


<?php


$j = 0;
$line_name=" ";
// dd($values);
// if($values["emp_id"]){
	
// }else{

	$count = count($values["emp_id"]);
// }

for($i=0; $i<$count; $i++ )
{
	//echo $line_name."==".$values['line_name'][$i];
	
	if($line_name !=$values["line_name"][$i]){
		$data['line'][] = $values["line_name"][$i];
		$data[$values["line_name"][$i]]['total_employee'] = 0;
		$data[$values["line_name"][$i]]['total_gross_sal'] = 0;
		$data[$values["line_name"][$i]]['total_per_day_salary'] = 0;
		$data[$values["line_name"][$i]]['total_ot_hour'] = 0;

		$data[$values["line_name"][$i]]['total_eot_hour'] = 0;
		$data[$values["line_name"][$i]]['total_ot_amount'] = 0;
		$data[$values["line_name"][$i]]['total_eot_amount'] = 0;
		$data[$values["line_name"][$i]]['total_amount'] = 0;
	}
	
	$data[$values["line_name"][$i]]['total_employee'] = $data[$values["line_name"][$i]]['total_employee'] + 1;
	
	
	$gross_sal = $values["gross_sal"][$i];
	//$total_gross_sal = $total_gross_sal + $gross_sal;
	$data[$values["line_name"][$i]]['total_gross_sal'] = $data[$values["line_name"][$i]]['total_gross_sal'] + $gross_sal;
	
	$per_day_salary = round($gross_sal / $num_of_days);
	//$total_per_day_salary = $total_per_day_salary + $per_day_salary;
	$data[$values["line_name"][$i]]['total_per_day_salary'] = $data[$values["line_name"][$i]]['total_per_day_salary']+  $per_day_salary;
	
	$ot_hour = $values["ot_hour"][$i];
	//$total_ot_hour = $total_ot_hour + $ot_hour;
	$data[$values["line_name"][$i]]['total_ot_hour'] = $data[$values["line_name"][$i]]['total_ot_hour'] + $ot_hour;
	
	$eot_hour = $values["extra_ot_hour"][$i];
	//$total_eot_hour = $total_eot_hour + $eot_hour;
	$data[$values["line_name"][$i]]['total_eot_hour'] = $data[$values["line_name"][$i]]['total_eot_hour'] + $eot_hour;
	
	$ot_amount = round($values["ot_hour"][$i] * $values["ot_rate"][$i]);
	$data[$values["line_name"][$i]]['total_ot_amount'] = $data[$values["line_name"][$i]]['total_ot_amount'] + $ot_amount;
	
	$eot_amount = round($values["extra_ot_hour"][$i] * $values["ot_rate"][$i]);
	$data[$values["line_name"][$i]]['total_eot_amount'] = $data[$values["line_name"][$i]]['total_eot_amount'] + $eot_amount;

	
	$total_amount = $ot_amount + $eot_amount + $per_day_salary;
	$data[$values["line_name"][$i]]['total_amount'] = $data[$values["line_name"][$i]]['total_per_day_salary'] + $data[$values["line_name"][$i]]['total_ot_amount'] + $data[$values["line_name"][$i]]['total_eot_amount'] ;

	

	/*
	if($line_name !=$values["line_name"][$i]){
		
	echo "</tr>";
	}
	*/
	$line_name = $values["line_name"][$i];
	
}
$grand_total_emp = 0;
$grand_total_eot_amount = 0;
$grand_total_ot_amount = 0;
$grand_total_ot_hour = 0;
$grand_total_eot_hour = 0;
$grand_total_gross_salary = 0;
$grand_total_per_dar_salary = 0;
$grand_total = 0;
foreach($data['line'] as $line)
{
	echo "<tr>";
	
	echo "<td style='text-align:center;'>";
	echo $j = $j+1;
	echo "</td>";
	
	echo "<td  style='text-align:left;padding-left:5px;'>";
	echo $line ;
	echo "</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $data[$line]['total_employee'];
	echo "</td>";
	$grand_total_emp = $grand_total_emp + $data[$line]['total_employee'];
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $data[$line]['total_gross_sal'];
	echo "</td>";
	$grand_total_gross_salary = $grand_total_gross_salary + $data[$line]['total_gross_sal'];
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $data[$line]['total_per_day_salary'];
	echo "</td>";
	$grand_total_per_dar_salary = $grand_total_per_dar_salary + $data[$line]['total_per_day_salary'];
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $data[$line]['total_ot_hour'];
	echo "</td>";
	$grand_total_ot_hour = $grand_total_ot_hour + $data[$line]['total_ot_hour'];
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $data[$line]['total_eot_hour'];
	echo "</td>";
	$grand_total_eot_hour = $grand_total_eot_hour + $data[$line]['total_eot_hour'];
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $data[$line]['total_ot_amount'];
	echo "</td>";
	$grand_total_ot_amount = $grand_total_ot_amount + $data[$line]['total_ot_amount'];
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $data[$line]['total_eot_amount'];
	echo "</td>";
	$grand_total_eot_amount = $grand_total_eot_amount + $data[$line]['total_eot_amount'];
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px' >";
	echo $data[$line]['total_amount'];
	echo "</td>";

	$grand_total = $grand_total + 	$data[$line]['total_amount'];
}
	echo "<tr>";
	
	echo "<td  colspan='2'  style='text-align:center;font-weight:bold'>Grand Total</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px;font-weight:bold' >";
	echo number_format($grand_total_emp);
	echo "</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px;font-weight:bold' >";
	echo number_format($grand_total_gross_salary);
	echo "</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px;font-weight:bold' >";
	echo number_format($grand_total_per_dar_salary);
	echo "</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px;font-weight:bold' >";
	echo number_format($grand_total_ot_hour);
	echo "</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px;font-weight:bold' >";
	echo number_format($grand_total_eot_hour);
	echo "</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px;font-weight:bold' >";
	echo number_format($grand_total_ot_amount);
	echo "</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px;font-weight:bold' >";
	echo number_format($grand_total_eot_amount);
	echo "</td>";
	
	echo "<td  width='40'  style='text-align:right;padding-right:5px;font-weight:bold' >";
	echo number_format($grand_total);
	echo "</td>";
	echo "</tr>";
//print_r($data);
?>

</table>
</div>
</div>
</body>
</html>

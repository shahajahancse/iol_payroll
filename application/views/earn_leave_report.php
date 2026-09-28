<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Earn Leave Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />

</head>

<body>

<div style=" margin:0 auto;  width:800px;">
<?php
$this->load->view("head_english");
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:12px; font-weight:bold;">
Earn Leave Payment Sheet <?php echo date("F-Y"); ?></span>
<br />
<br />


<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px;">
<th>SL</th>
<th width="110px;">Name of Workers</th>
<th>Designation</th>
<th>Card No.</th>
<th>Section</th>
<th style="white-space:nowrap">Join Date</th>
<th>Previous Month of Payble Wages</th>
<th>Actual Working Days <?php echo date("Y"); ?></th>
<th>E/L Earn in <?php echo date("Y"); ?> </th>
<th>Previous Earn Leave Balance is</th>
<th>Total Earn Leave Days</th>
<th>Previous Month of Payble days</th>
<th>Net Pay Amount</th>
<th>Worker Signature</th>

<?php
// dd($values);

$total_net_pay = 0;
$count = $values["emp_name"] !== null ? count($values["emp_name"]) : 0;
for($i=0; $i<$count; $i++ )
{
	echo "<tr>";

	echo "<td>";
	echo $k = $i+1;
	echo "</td>";

	echo "<td style='text-align:center'>";
	echo $values["emp_name"][$i];
	echo "</td>";

	echo "<td style='text-align:center'>";
	echo $values["desig_name"][$i];
	echo "</td>";

	echo "<td style='text-align:center'>";
	echo $values["emp_id"][$i];
	echo "</td>";


	echo "<td style='text-align:center'>";
	echo $values["sec_name"][$i];
	echo "</td>";
	$doj = $values["doj"][$i];
	echo "<td style='text-align:center'>";
	echo date("d-M-y",strtotime($doj));
	echo "</td>";

	echo "<td style='text-align:right'>";
	echo isset($values["pay_wages"][$i]) ? number_format($values["pay_wages"][$i]) : 0;
	echo "</td>";

	echo "<td style='text-align:center'>";
	echo $values["actual_working_days"];
	echo "</td>";

	echo "<td style='text-align:center'>";
	echo $values["current_earn_balance"][$i];
	echo "</td>";

	echo "<td style='text-align:center'>";
	echo $values["old_earn_balance"][$i];
	echo "</td>";
	if(!isset($values["pay_days"][$i])){
		$per_day_wages = 0;}
	else
	{
		$per_day_wages = round($values["net_pay"][$i]/$values["total_days"][$i],2);
		//echo $per_day_wages;
	}
	//echo $values["total_days"][$i];
	$total_earn_balance = $values["current_earn_balance"][$i] + $values["old_earn_balance"][$i];
	$net_pay = $total_earn_balance * $per_day_wages ;
	echo "<td style='text-align:center'>";
	echo $total_earn_balance ;
	echo "</td>";

	echo "<td style='text-align:center' >";
	echo isset($values["pay_days"][$i]) ? $values["pay_days"][$i] : "&nbsp;";
	echo "</td>";
	$net_pay_round = round($net_pay,2);
	echo "<td style='text-align:right'>";
	echo $net_pay_round ;
	echo "</td>";
	$total_net_pay = $total_net_pay + $net_pay_round;
	echo "<td >";
	echo "<img src='".base_url('uploads/emp_signature/'.$values["signature"][$i])."' width='100px' height='30px'>";
	echo "</td>";

	echo "</tr>";
}

?>

<tr>
<td  colspan="12" style="text-align:center; font-weight:bold;" >
Total Net Pay
</td>
<td style="text-align:right; font-weight:bold;" ><?php echo number_format($total_net_pay); ?>/=</td><td></td></tr>
</table>
</div>
</div>
</body>
</html>

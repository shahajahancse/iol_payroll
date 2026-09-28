<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Montly OT Register</title>
<link rel="stylesheet" type="text/css" href="../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />

</head>

<body>
<?php
$per_page_id = 56;
$row_count = count($values["emp_id"]);
$max = $row_count;
if($row_count >$per_page_id)
{
$page=ceil($row_count/$per_page_id);
}
else
{
$page=1;
}
$total_ot_hour = 0;
$total_ot_amount = 0;
$k = 0;
for($counter = 1; $counter <= $page; $counter ++)
{
 ?>

<div style=" margin:0 auto;  width:750px;">
<?php
$this->load->view("head_english");
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:12px; font-weight:bold;">
Monthly EOT Report of <?php echo "$start_date"; ?></span>
<div style="clear:both;width: 100%;height: 20px;"></div>
<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px;">
	<tr>
		<th>SL</th>
		<th>Emp ID</th>
		<!-- <th>Punch Card No.</th> -->
		<th>Employee Name</th>
		<!-- <th>Department</th> -->
		<th>Designation</th>
		<th>Line No. </th>
		<th>Shift</th>
		<th>Gross Sal</th>
		<th>OT Rate</th>
		<th>Total EOT Hour</th>
		<th>Total EOT Amount</th>
	</tr>


<?php

$section=array();

	for($i=0; $i<=$per_page_id; $i++)
	{
		$total_eot_hour=0;
		$total_eot_amount=0;
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
		echo "<td colspan='10' style='font-size:16px'>Section :&nbsp;".$values["sec_name"][$k]."</td>";
		echo "</tr>";

	}
	echo "<tr>";

	echo "<td>";
	echo $s = $k+1;
	echo "</td>";

	echo "<td>";
	echo $values["emp_id"][$k];
	echo "</td>";

	// echo "<td>";
	// echo "&nbsp;";
	// echo $values["proxi_id"][$k];
	// echo "</td>";

	echo "<td width='150'  style='text-align:left;' >";
	echo $values["emp_name"][$k];
	echo "</td>";


	// echo "<td  width='140'  style='text-align:left;'>";
	// echo $values["dept_name"][$k];
	// echo "</td>";

	echo "<td  width='140'  style='text-align:left;'>";
	echo $values["desig_name"][$k];
	echo "</td>";

	echo "<td  width='140'  style='text-align:left;'>";
	echo $values["line_name"][$k];
	echo "</td>";

	echo "<td >";
	echo $values["emp_shift"][$k];
	echo "</td>";

	echo "<td  width='40'  style='text-align:right;' >";
	echo $values["gross_sal"][$k];
	echo "</td>";

	echo "<td  style='text-align:right;' >";
	echo $values["ot_rate"][$k];
	echo "</td>";

	echo "<td  style='text-align:center;' >";
	echo $values["total_eot_hour"][$k];
	echo "</td>";


	$eot_hour = $values["total_eot_hour"][$k];

	$total_eot_hour = $total_eot_hour + $eot_hour;


	echo "<td  style='text-align:right;' >";
	echo $values["total_eot_amount"][$k];
	echo "</td>";

	$eot_amount = $values["total_eot_amount"][$k];

	$total_eot_amount = $total_eot_amount + $eot_amount;
	echo "</tr>";

	$section=$values["sec_name"][$k];
	$k++;
	if($max==$k){
		break;
	}
}

?>
<tr>
<td  colspan="8" style="text-align:center; font-weight:bold;" >
Grand Total
</td>
<td style="text-align:center; font-weight:bold;" ><?php echo $total_eot_hour; ?></td>
<td style="text-align:right; font-weight:bold;" ><?php echo number_format($total_eot_amount); ?>/=</td>

</table>
<div style="page-break-after: always;"></div>
</div>
</div>
<?php
	if($max==$k){
		break;
	}

} ?>
</body>
</html>
<?php exit(); ?>

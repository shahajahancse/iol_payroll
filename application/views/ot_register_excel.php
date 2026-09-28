<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head> </head>

<body>
	<?php
		$filename = "otreg.xls";
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
	?>

	<style type="text/css">
		.priview-body{font-size: 16px;color:#000;margin: 25px;}
		.priview-header{margin-bottom: 10px;text-align:center;}
		.priview-header div{font-size: 18px;}
		.priview-memorandum{padding-bottom: 20px;}
		.headding{border-top:1px solid #000;border-bottom:1px solid #000;text-align:center;}
		.table{width:100%;border-collapse: collapse;}
		.table td, .table th{border:0px solid #ddd;}
	</style>

	<div class="head-container" style="padding:20px 0px;width: 100%;display: inline-block;">
		<div style="text-align:center; position:relative;padding-left:269px;width:50%; overflow:hidden; float:left; display:block;">
			<?php $this->load->view("head_bangla"); ?>
			<span style="font-size:13px; font-weight:bold;">Attendance Register of <?php echo  $year_month ?> </span>
		</div>
	</div>

	<?php
		if (is_string($value)) {
			echo $value;
			exit();
		}
	?>

	<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px;">
		<tr>
			<th>SL</th>
			<th>Emp ID</th>
			<th>Employee Name</th>
			<th>Designation</th>
			<th>Line No. </th>
			<th>Shift</th>
			<th>Gross Sal</th>
			<th>OT Rate</th>
			<th>Total OT Hour</th>
			<th>Total OT Amount</th>
		</tr>

		<?php
			$total_ot_hour = 0;
			$total_ot_amount = 0;
			$count = count($value["emp_id"]);
			for($i=0; $i<$count; $i++ )
			{
				echo "<tr>";
					echo "<td>";
					echo $k = $i+1;
					echo "</td>";

					echo "<td>";
					echo $value["emp_id"][$i];
					echo "</td>";

					echo "<td width='150'  style='text-align:left;' >";
					echo $value["emp_name"][$i];
					echo "</td>";

					echo "<td  width='140'  style='text-align:left;'>";
					echo $value["desig_name"][$i];
					echo "</td>";

					echo "<td  width='140'  style='text-align:left;'>";
					echo $value["line_name"][$i];
					echo "</td>";

					echo "<td >";
					echo $value["emp_shift"][$i];
					echo "</td>";

					echo "<td  width='40'  style='text-align:right;' >";
					echo $value["gross_sal"][$i];
					echo "</td>";

					echo "<td  style='text-align:right;' >";
					echo $value["ot_rate"][$i];
					echo "</td>";

					echo "<td  style='text-align:center;' >";
					echo $value["total_ot_hour"][$i];
					echo "</td>";

					$ot_hour = $value["total_ot_hour"][$i];
					$total_ot_hour = $total_ot_hour + $ot_hour;

					echo "<td  style='text-align:right;' >";
					echo $value["total_ot_amount"][$i];
					echo "</td>";

					$ot_amount = $value["total_ot_amount"][$i];
					$total_ot_amount = $total_ot_amount + $ot_amount;
				echo "</tr>";
			}
		?>
		<tr>
			<td  colspan="8" style="text-align:center; font-weight:bold;" > Grand Total </td>
			<td style="text-align:center; font-weight:bold;" ><?php echo $total_ot_hour; ?></td>
			<td style="text-align:right; font-weight:bold;" ><?php echo number_format($total_ot_amount); ?>/=</td>
		</tr>
	</table>
</body>
</html>
<?php exit(); ?>

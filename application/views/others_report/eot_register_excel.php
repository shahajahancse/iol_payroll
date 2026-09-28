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

	<?php
		if (is_string($value)) {
			echo $value;
			exit();
		}

		$per_page_id = 56;
		$row_count = count($value["emp_id"]);
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
	?>

	<?php for($counter = 1; $counter <= $page; $counter ++) { ?>
		<div style=" margin:0 auto;  width:750px;">
			<?php $this->load->view("head_english"); ?>
			<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:12px; font-weight:bold;"> Monthly EOT Report of <?php echo "$year_month"; ?></span>
				<div style="clear:both;width: 100%;height: 20px;"></div>
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
						<th>Total EOT Hour</th>
						<th>Total EOT Amount</th>
					</tr>
					<?php $section=array();
					for($i=0; $i<=$per_page_id; $i++)
					{
						$total_eot_hour=0;
						$total_eot_amount=0;
						if($section!=$value["sec_name"][$k]){
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
							echo "<td colspan='10' style='font-size:16px'>Section :&nbsp;".$value["sec_name"][$k]."</td>";
							echo "</tr>";
						}
						echo "<tr>";

							echo "<td>";
							echo $s = $k+1;
							echo "</td>";

							echo "<td>";
							echo $value["emp_id"][$k];
							echo "</td>";

							echo "<td width='150'  style='text-align:left;' >";
							echo $value["emp_name"][$k];
							echo "</td>";

							echo "<td  width='140'  style='text-align:left;'>";
							echo $value["desig_name"][$k];
							echo "</td>";

							echo "<td  width='140'  style='text-align:left;'>";
							echo $value["line_name"][$k];
							echo "</td>";

							echo "<td >";
							echo $value["emp_shift"][$k];
							echo "</td>";

							echo "<td  width='40'  style='text-align:right;' >";
							echo $value["gross_sal"][$k];
							echo "</td>";

							echo "<td  style='text-align:right;' >";
							echo $value["ot_rate"][$k];
							echo "</td>";

							echo "<td  style='text-align:center;' >";
							echo $value["total_eot_hour"][$k];
							echo "</td>";

							$eot_hour = $value["total_eot_hour"][$k];
							$total_eot_hour = $total_eot_hour + $eot_hour;

							echo "<td  style='text-align:right;' >";
							echo $value["total_eot_amount"][$k];
							echo "</td>";

							$eot_amount = $value["total_eot_amount"][$k];
							$total_eot_amount = $total_eot_amount + $eot_amount;
						echo "</tr>";

						$section=$value["sec_name"][$k];
						$k++;
						if($max==$k){
							break;
						}
					} ?>

					<tr>
						<td  colspan="8" style="text-align:center; font-weight:bold;" > Grand Total </td>
						<td style="text-align:center; font-weight:bold;" ><?php echo $total_eot_hour; ?></td>
						<td style="text-align:right; font-weight:bold;" ><?php echo number_format($total_eot_amount); ?>/=</td>
					</tr>
				</table>
				<div style="page-break-after: always;"></div>
			</div>
		</div>
		<?php if($max==$k){ break; } ?>
	<?php } ?>
</body>
</html>
<?php exit(); ?>

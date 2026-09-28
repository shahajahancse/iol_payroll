<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title> Daily
        <?php
			if ($daily_status == 2)
			{
				echo "Absent";
			}
			else if($daily_status == 1)
			{
				echo "Present";
			}
			else if($daily_status == 3)
			{
				echo "Leave";
			}
			elseif($daily_status == 4)
			{
				echo "Late";
			}
			elseif($daily_status == 5)
			{
				echo "OT";
			}
			elseif($daily_status == 6)
			{
				echo "EOT";
			}
			elseif($daily_status == 7)
			{
				echo "OUT & IN";
			}
			elseif($daily_status == 8)
			{
				echo "Punch Miss";
			}
		?>
        Report
	</title>
    <style>
		@media print {
			table {
				widht: 600px !important;
			}

			#btnExport {
				display: none;
			}

		}
    </style>
</head>

<body style="margin: 0px;" id="report-data">
    <?php $this->load->view("head_english"); ?>
	<button style='position:absulate;margin-left:50px' id="btnExport">Download as Excel</button>

    <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
        <span style="font-size:12px; font-weight:bold;"> Daily
            <?php echo "Present"; ?> Report , Date
            <?php echo date("d/m/Y",strtotime($date)); ?>
        </span>
        <br><br>

	<table border="1" cellpadding="0" cellspacing="0" style="font-size:12px; width:1200px; margin-bottom:20px;">
            <?php $this->load->model('Grid_model'); $i=1; ?>
			<tr>
				<th style="padding:2px 10px;">SL</th>
				<th style="padding:2px 10px;">ID</th>
				<th style="padding:4px;">row Name</th>
				<th style="padding:4px">Designation</th>
				<th style="padding:4px">Line</th>
				<th style="padding:4px">Shift</th>
				<th style="padding:4px">In Time</th>
				<th style="padding:4px">Out Time</th>
				<th style="padding:4px">OT Hour</th>
				<th style="padding:4px">EOT Hour</th>
				<!-- <th style="padding:4px">Modify EOT</th>
				<th style="padding:4px">Deduct EOT</th> -->
				<th style="padding:4px">Total OT</th>
			</tr>

			<?php $emp_sec = '';
				foreach ($values as $key => $row) {
					if ($emp_sec != $row['emp_sec_id']) {
					echo "<tr bgcolor='#CCCCCC'>";
					echo "<td colspan='17' style='font-size:16px; font-weight:bold;'>Line :".$row['sec_name_en']."</td>";
					echo "</tr>";
					}
				?>

				<tr>
					<td style="text-align:center; padding:2px"><?php echo $key +1; ?></td>
					<td style="text-align:center; padding:2px"><?php echo $row['emp_id']?></td>
					<td style="text-align:left; padding:2px"><?php echo $row['name_en']?></td>
					<td style="text-align:left; padding:2px"><?php echo $row['desig_name']?></td>
					<td style="text-align:left; padding:2px"><?php echo $row['line_name_en']?></td>
					<td style="text-align:left; padding:2px"><?php echo $row['shift_name']?></td>
					<td style="text-align:center; padding:2px"><?php echo $row['in_time']; ?> </td>
					<td style="text-align:center; padding:2px"><?php echo $row['out_time'];?> </td>

					<td style="text-align:center; padding:2px"><?php echo $row['ot']?></td>
					<td style="text-align:center; padding:2px"><?php echo $row['eot']?></td>
					<!-- <td style="text-align:center; padding:2px">< ?php echo $row['modify_eot']?></td> -->
					<!--  <td style="text-align:center; padding:2px">< ?php echo $row['deduction_hour']?></td> -->
					<!-- <?php $total_ot = $row['ot'] + $row['eot'] + ($row['modify_eot']) - $row['deduction_hour']; ?> -->
					<?php $total_ot = $row['ot'] + $row['eot']; ?>
					<td style="text-align:center; padding:2px"><?php echo $total_ot; ?></td>
				</tr>
				<?php $emp_sec = $row['emp_sec_id']; ?>
			<?php } ?>
		</table>
	</div>
	<br><br>

	<button id="btnExport">Download as Excel</button>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
	<script>
		function convert_excel(type, fn, dl) {
			var elt = document.getElementById('report-data');
			var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
			return dl ?
				XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
				XLSX.writeFile(wb, fn || ('Reports.' + (type || 'xlsx')));
		}
		$("#btnExport").click(function(event) {
		convert_excel('xlsx');
		});
	</script>
</body>
</html>
<?php exit(); ?>

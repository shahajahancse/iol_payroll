<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Daily Cost Report</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
	<style>
		@media print {
			#btnExport {
				display: none;
			}
		}
	</style>
</head>

<body>
    <div style=" margin:0 auto; " id='report-data'>
        <?php $data['unit_id'] = $unit_id;
		$this->load->view("head_english",$data); ?>

        <!--Report title goes here-->
        <div  style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
            <center><span style="font-size:12px; font-weight:bold;text-align:center">
                Daily Cost Report <?php echo "$grid_date"; ?>
			</span></center>
            <br/> <br/>
        	<?php $num_of_days = date("t",strtotime($grid_date));
			?>
		<button style='position:absulate;margin-left:50px' id="btnExport">Download as Excel</button>
		<br></br>
		<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:14px;width:60%">
				<tr>
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
				</tr>

                <?php
					$total_ot_hour = 0;
					$total_ot_amount = 0;
					$total_extra_ot_hour = 0;
					$total_eot_amount = 0;
					$total_tifin_amount = 0;
					$total_night_amount = 0;
					$total_offday_amount = 0;
					$total_per_day_salary = 0;
					$total_salary = 0;
					$emp_line_id = '';
				?>

				<?php foreach ($values as $key => $row) {
					if ($emp_line_id != $row->emp_line_id) {
					echo "<tr bgcolor='#CCCCCC'>";
					echo "<td colspan='17' style='font-size:16px; font-weight:bold;'>Line :".$row->line_name."</td>";
					echo "</tr>";
					}
				?>

				<tr>
					<td style='text-align:center;'> <?php echo $key+1; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $row->emp_id; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $row->name_en; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $row->desig_name; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $row->line_name; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $row->present_status; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $row->gross_sal; ?> </td>

					<?php
						$salary_structure = $this->common_model->salary_structure($row->gross_sal);
						$ot_rate = $salary_structure['ot_rate'];
						$per_day_salary = round($row->gross_sal / $num_of_days);
						$total_per_day_salary = $total_per_day_salary + $per_day_salary;
					?>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $per_day_salary; ?> </td>

					<td style='text-align:center;padding:0px 5px;'> <?php echo $row->ot; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $row->eot; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $ot_rate; ?> </td>

					<?php
						$ot_amount 			 = round($row->ot * $ot_rate);
						$total_ot_hour	     = $total_ot_hour + $row->ot;
						$total_ot_amount     = $total_ot_amount + $ot_amount;
						$eot_amount 		 = round($row->eot * $ot_rate);
						$total_extra_ot_hour = $total_extra_ot_hour + $row->eot;
						$total_eot_amount 	 = $total_eot_amount + $eot_amount;
					?>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $ot_amount; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $eot_amount; ?> </td>
					<?php
						$tiffin_allo  = $row->tiffin_allo != 0 ? $row->tiffin_bill : 0;
						$night_allo   = $row->night_allo != 0 ? $row->night_bill : 0;
						$holiday_allo = $row->holiday_allo != 0 ? $row->holiday_bill : 0;
						$weekly_allo  = $row->weekly_allo != 0 ? $row->holiday_bill : 0;

						$total_tifin_amount = $tiffin_allo + $total_tifin_amount;
						$total_night_amount = $night_allo + $total_night_amount;
						$total_offday_amount = $weekly_allo + $holiday_allo + $total_offday_amount;

						$total_amount = $ot_amount + $eot_amount + $per_day_salary;
						$total_allow = $weekly_allo + $holiday_allo + $night_allo + $tiffin_allo;
						$total_salary = $total_salary + $total_amount + $total_allow;
					?>

					<td style='text-align:center;padding:0px 5px;'> <?php echo $night_allo; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $holiday_allo + $weekly_allo; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $tiffin_allo; ?> </td>
					<td style='text-align:center;padding:0px 5px;'> <?php echo $total_amount; ?> </td>
				</tr>
				<?php $emp_line_id = $row->emp_line_id; } ?>
				<tr>
				<td  colspan="7" style="text-align:center; font-weight:bold;" > Grand Total </td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_per_day_salary); ?></td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_ot_hour); ?></td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_extra_ot_hour); ?></td>
				<td></td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_ot_amount); ?></td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_eot_amount); ?></td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_night_amount); ?></td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_offday_amount); ?></td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_tifin_amount); ?></td>
				<td style="text-align:center; font-weight:bold;" ><?php echo number_format($total_salary); ?></td>
				</tr>
            </table>
        </div>
    </div>
	<br><br>

	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
	<script>
		function convert_excel(type, fn, dl) {
			var elt = document.getElementById('report-data');
			var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
			return dl ?
				XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
				XLSX.writeFile(wb, fn || ('Sales-Report.' + (type || 'xlsx')));
		}
		$("#btnExport").click(function(event) {
		convert_excel('xlsx');
		});
	</script>
</body>
</html>
<?php exit(); ?>

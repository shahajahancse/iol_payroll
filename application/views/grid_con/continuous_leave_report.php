<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Continuous <?php echo $status; ?> Report</title>
    <link rel="stylesheet" type="text/css" href="../../../../../../css/SingleRow.css" />
</head>

	<style>
		@media print{
			.page_break_t{
				display: block;
				border: none;
			}
			.page_break{
				page-break-before: always;
			}
		}
	</style>
<body>
    <div style="margin:0 auto; width:75%;">
        <?php $this->load->view("head_english");?>
        <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
            <span style="font-size:13px; font-weight:bold;">
			<?php echo $status; ?> Report from
			<?php
				$year= trim(substr($start_date,0,4));
				$month = trim(substr($start_date,5,2));
				$tarik = trim(substr($start_date,8,2));
				$date_format = date("d-M-Y", mktime(0, 0, 0, $month, $tarik, $year));
				echo $date_format;

				echo " - TO - ";

				$year= trim(substr($end_date,0,4));
				$month = trim(substr($end_date,5,2));
				$tarik = trim(substr($end_date,8,2));
				$date_format = date("d-M-Y", mktime(0, 0, 0, $month, $tarik, $year));
				echo $date_format;

			?></span>
			<br />
			<br />

			<table border="1" align="center" style="border:1px solid black; border-collapse: collapse; border-spacing: 10px;font-size:12px; width:100%; margin-bottom:0px;">
				<tr style="">
					<th style="padding:5px">SL</th>
					<th style="padding:5px">Emp ID</th>
					<th style="padding:5px">Name</th>
					<th style="padding:5px">Line</th>
					<th style="padding:5px">Leave Type</th>
					<th style="padding:5px">From Date</th>
					<th style="padding:5px">To Date</th>
					<th style="padding:5px">Total Leave</th>	
					<th style="padding:5px">Purpose</th>
				</tr>
				<?php $section = 0;
					foreach ($values as $key => $row) { 
						if($section != $row->emp_sec_id){
						// echo "<tr bgcolor='#CCCCCC'>";
						// echo "<td colspan='9' style='font-size:16px'>Section :".$row->sec_name_en."</td>";
						// echo "</tr>"; ?>

						<?php } ?>
						<?php 
							$leave_type = '';
							if ($row->leave_type == 'cl') {
								$leave_type = 'Casual Leave';
							} else if ($row->leave_type == 'sl') {
								$leave_type = 'Sick Leave';
							} else if ($row->leave_type == 'ml') {
								$leave_type = 'Maternity Leave';
							} else if ($row->leave_type == 'wp') {
								$leave_type = 'With Out Pay';
							} else if ($row->leave_type == 'el') {
								$leave_type = 'Earn Leave';
							} else if ($row->leave_type == 'do') {
								$leave_type = 'Day off Leave';
							}
						?>
						<tr>
							<td style="padding:2px 5px;text-align:center"> <?= $key+1 ?> </td>
							<td style="padding:2px 5px;text-align:center"> <?= $row->emp_id ?> </td>
							<td style="padding:2px 5px;text-align:center"> <?= $row->name_en ?> </td>
							<td style="padding:2px 5px;text-align:center"> <?= $row->line_name_en ?> </td>
							<td style="padding:2px 5px;text-align:center"> <?= $leave_type ?> </td>
							<td style="padding:2px 5px;text-align:center"> <?= date('Y-m-d', strtotime($row->leave_start)) ?> </td>
							<td style="padding:2px 5px;text-align:center"> <?= date('Y-m-d', strtotime($row->leave_end)) ?> </td>
							<td style="padding:2px 5px;text-align:center"> 
							<?=
								$row->total_leave  
									
							?> </td>
							<td style="padding:2px 5px"> <?= $row->leave_descrip ?> </td>
						<tr>
				<?php  $section=$row->emp_sec_id; } ?>
			</table>
		</div>
	</div>
</body>
</html>
<br><br><br>
<?php exit(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Job Card</title>
		<link rel="stylesheet" type="text/css" href="../../../../../css/SingleRow.css" />
	</head>

	<body>
		<div align="center" style="height:100%; width:100%; overflow:hidden;" >
			<?php
				$this->load->model('job_card_model');
				foreach ($values as $key => $value) {
					echo "<div style='min-height:1000px; overflow:hidden;'>";
					$present_count = 0;
					$absent_count = 0;
					$leave_count = 0;
					$ot_count = 0;
					$late_count = 0;
					$wk_off_count = 0;
					$holiday_count = 0;
					$perror_count = 0;
					$total_ot_hour = 0;
					$total_ot = 0;
					$extra_ot_hour = 0;

					$this->load->view('head_english');
					echo "<span style='font-size:13px; font-weight:bold;'>";
					echo "Job Card Report from ". date('d-m-Y', strtotime($grid_firstdate)) ." -TO- ". date('d-m-Y', strtotime($grid_seconddate));
					echo "</span>";
					echo "<br /><br />";

					echo "<table border='0' style='font-size:13px;' width='480'>";
						echo "<tr>";
						echo "<td width='70'>";
						echo "<strong>Emp ID:</strong>";
						echo "</td>";
						echo "<td width='200'>";
						echo $value->emp_id;
						echo "</td>";

						echo "<td width='55'>";
						echo "<strong>Name :</strong>";
						echo "</td>";
						echo "<td width='150'>";
						echo $value->name_en;
						echo "</td>";
						echo "</tr>";

						echo "<tr>";
						echo "<td style:width:20px'>";
						echo "<strong>Section :</strong>";
						echo "</td>";
						echo "<td width='30px'>";
						echo $value->sec_name_en;
						echo "</td>";

						echo "<td>";
						echo "<strong>Desig :</strong>";
						echo "</td>";
						echo "<td>";
						echo $value->desig_name;
						echo "</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td>";
						echo "<strong>Line :</strong>";
						echo "</td>";
						echo "<td>";
						echo $value->line_name_en;
						echo "</td>";

						echo "<td >";
						echo "<strong>Dept :</strong>";
						echo "</td>";
						echo "<td >";
						echo $value->dept_name;
						echo "</td>";


						echo "</tr>";
						echo "<tr>";
						echo "<td>";
						echo "<strong>DOJ :</strong>";
						echo "</td>";
						echo "<td>";
						echo date("d-M-Y", strtotime($value->emp_join_date));
						echo "</td>";


					echo "<table>";
					$emp_data = $this->job_card_model->emp_job_card($grid_firstdate,$grid_seconddate, $value->emp_id);
					// dd($emp_data);
					echo "<table class='sal' border='1' bordercolor='#000000' cellspacing='0' cellpadding='0'  style='text-align:center; font-size:13px; '>
						<th>Date</th>
						<th>Day</th>
						<th>In Time</th>
						<th>Out Time</th>
						<th>Shift</th>
						<th>Attn.Status</th>
						<th>OT Hour</th>
						<th>Extra OT Hour</th>
						<th>Total OT Hour</th>
						<th>Remarks</th>";
					foreach ($emp_data['emp_data'] as $key => $row) {

						$extra_ot_hour = $row->ot_eot_12am;

						if($row->present_status == 'L'){
							$leave_type = $this->job_card_model->get_leave_type($row->shift_log_date,$value->emp_id);
							$att_status_count = "Leave";
							$att_status = $leave_type;
							$row->in_time = "00:00:00";
							$row->out_time = "00:00:00";
							$extra_ot_hour = 0;
						}
						elseif(in_array($row->shift_log_date,$emp_data['holiday'])){
							$att_status = "Holiday";
							$att_status_count = "Holiday";
							$row->in_time = "00:00:00";
							$row->out_time = "00:00:00";
							$row->com_ot =0;
							$extra_ot_hour = 0;
						}
						elseif($row->present_status == 'W') {
							$att_status = "Work Off";
							$att_status_count = "Work Off";
							$row->in_time = "00:00:00";
							$row->out_time = "00:00:00";
							$row->com_ot =0;
							$extra_ot_hour = 0;
						}
						elseif($row->in_time !='00:00:00' and $row->out_time !='00:00:00'){
							$att_status = "P";
							$att_status_count = "P";
						}
						elseif($row->in_time !='00:00:00' or $row->out_time !='00:00:00'){
							$att_status = "P(Error)";
							$att_status_count = "P(Error)";
						}
						else{
							$att_status = "A";
							$att_status_count = "A";
							$extra_ot_hour = 0;
						}
						// $emp_shift = $this->job_card_model->emp_shift_check($value->emp_id, $row->shift_log_date);
						$schedule = $this->job_card_model->schedule_check($row->schedule_id);
                        // dd($schedule);
						$start_time		=  $schedule[0]["in_start"];
						$late_time 		=  $schedule[0]["late_start"];
						$end_time   	=  $schedule[0]["in_end"];
						$in_time   		=  $schedule[0]["in_time"];
						$out_start_time	=  $schedule[0]["out_start"];
						$out_end_time	=  $schedule[0]["out_end"];
						$two_hour_ot_out_time	= $schedule[0]["two_hour_ot_out_time"];
						$ot_start	    =  $schedule[0]["ot_start"];

						$shift_log_date = date("d-M-y", strtotime($row->shift_log_date));
						$deduction_hour = $row->deduction_hour;
						if($row->in_time != "00:00:00"){
							$in_time = $row->in_time;
							list($hour, $minute, $second) = explode(':', $in_time);
							if ((int)$minute < 45 && $schedule[0]["in_time"] > $row->in_time) {

							$minuteDigits = str_split($minute);
							$minuteSum = array_sum($minuteDigits);                                
							$n_m = 60 - $minuteSum;
							$in_time = sprintf("%02d:%02d:%02d", (int)$hour, $n_m, (int)$second);
							}
						}else{
							$in_time = "00:00:00";
						}
						if($row->out_time != "00:00:00"){
							$out_time = $row->out_time;
							$out_time = $this->job_card_model->get_formated_out_time_12am($value->emp_id, $out_time, $row->schedule_id);
							

							if($row->com_eot == 1 && $row->false_ot_12 != null && $row->false_ot_12 == 0){
								$extra_ot_hour = 0;
								$out_time = date('H:i:s ', strtotime('-1 hour', strtotime($out_time)));
							}

							if($row->com_eot == 2 && $row->false_ot_12 != null && $row->false_ot_12 == 0){
								$extra_ot_hour = 0;
								$out_time = date('H:i:s ', strtotime('-2 hour', strtotime($out_time)));
							} else if($row->com_eot == 2 && $row->false_ot_12 != null && $row->false_ot_12 == 1){
								$extra_ot_hour = 1;
								$out_time = date('H:i:s ', strtotime('-1 hour', strtotime($out_time)));
							}

							if($row->com_eot == 3 && $row->false_ot_12 != null && $row->false_ot_12 == 0){
								$extra_ot_hour = 0;
								$out_time = date('H:i:s ', strtotime('-3 hour', strtotime($out_time)));
							} else if($row->com_eot == 3 && $row->false_ot_12 != null && $row->false_ot_12 == 1){
								$extra_ot_hour = 1;
								$out_time = date('H:i:s ', strtotime('-2 hour', strtotime($out_time)));
							} else if($row->com_eot == 3 && $row->false_ot_12 != null && $row->false_ot_12 == 2){
								$extra_ot_hour = 2;
								$out_time = date('H:i:s ', strtotime('-1 hour', strtotime($out_time)));
							}

							if($row->com_eot == 4 && $row->false_ot_12 != null && $row->false_ot_12 == 0){
								$extra_ot_hour = 0;
								$out_time = date('H:i:s ', strtotime('-4 hour', strtotime($out_time)));
							} else if($row->com_eot == 4 && $row->false_ot_12 != null && $row->false_ot_12 == 1){
								$extra_ot_hour = 1;
								$out_time = date('H:i:s ', strtotime('-3 hour', strtotime($out_time)));
							} else if($row->com_eot == 4 && $row->false_ot_12 != null && $row->false_ot_12 == 2){
								$extra_ot_hour = 2;
								$out_time = date('H:i:s ', strtotime('-2 hour', strtotime($out_time)));
							} else if($row->com_eot == 4 && $row->false_ot_12 != null && $row->false_ot_12 == 3){
								$extra_ot_hour = 3;
								$out_time = date('H:i:s ', strtotime('-1 hour', strtotime($out_time)));
							}

							if($row->com_eot == 5 && $row->false_ot_12 != null && $row->false_ot_12 == 0){
								$extra_ot_hour = 0;
								$out_time = date('H:i:s ', strtotime('-5 hour', strtotime($out_time)));
							} else if($row->com_eot == 5 && $row->false_ot_12 != null && $row->false_ot_12 == 1){
								$extra_ot_hour = 1;
								$out_time = date('H:i:s ', strtotime('-4 hour', strtotime($out_time)));
							} else if($row->com_eot == 5 && $row->false_ot_12 != null && $row->false_ot_12 == 2){
								$extra_ot_hour = 2;
								$out_time = date('H:i:s ', strtotime('-3 hour', strtotime($out_time)));
							} else if($row->com_eot == 5 && $row->false_ot_12 != null && $row->false_ot_12 == 3){
								$extra_ot_hour = 3;
								$out_time = date('H:i:s ', strtotime('-2 hour', strtotime($out_time)));
							} else if($row->com_eot == 5 && $row->false_ot_12 != null && $row->false_ot_12 == 4){
								$extra_ot_hour = 4;
								$out_time = date('H:i:s ', strtotime('-1 hour', strtotime($out_time)));
							}



							// $out_time = $row->out_time;
							list($hour, $minute, $second) = explode(':', $out_time);
							// Check if the minute is greater than 13
							if ((int)$minute > 13 && (int)$minute <50) {
								// Sum the digits of the minute
								$minuteDigits = str_split($minute);
								$minuteSum = array_sum($minuteDigits);
								
								// Format the new time string with the summed minute value
								$out_time = sprintf("%02d:%02d:%02d", (int)$hour, $minuteSum, (int)$second);
							}

							// dd($out_time);
						}
						else{
							$out_time = "00:00:00";
						}

						echo "<tr>";
							echo "<td>&nbsp;";
							echo $shift_log_date;
							echo "&nbsp;</td>";

							echo "<td>&nbsp;";
							echo date('l', strtotime($shift_log_date));
							echo "&nbsp;</td>";

							echo "<td>&nbsp;";
							if($in_time == "00:00:00"){
								echo "&nbsp;";
							}
							else{
								echo $in_time;
							}
							echo "&nbsp;</td>";

							echo "<td>&nbsp;";
							if($out_time =="00:00:00"){
								echo "&nbsp;";
							}
							else{
								echo $out_time;
							}
							echo "&nbsp;</td>";

							echo "<td>&nbsp;";
							echo $row->shift_name;
							echo "&nbsp;</td>";

							echo "<td style='text-transform:uppercase;'>&nbsp;";
							echo $att_status;
							echo "&nbsp;</td>";

							if($att_status == "P"){
								$present_count++;
							}
							elseif($att_status == "A"){
								$absent_count++;
							}
							elseif($att_status_count == "Leave"){
								$leave_count++;
							}
							elseif($att_status == "P(Error)"){
								$perror_count++;
							}
							elseif($att_status == "Work Off"){
								$wk_off_count++;
							}
							elseif($att_status == "Holiday"){
								$holiday_count++;
							}
							if($row->late_status == 1){
								$remark = "Late";
								$late_count++;
							} else{
								$remark = "";
							}
							echo "<td>&nbsp;";
							echo $row->com_ot;
							echo "&nbsp;</td>";

							$total_ot_hour = $total_ot_hour + $row->com_ot + $extra_ot_hour;
							$total_ot = $total_ot + $row->com_ot;

							echo "<td>&nbsp;";
							echo $extra_ot_hour;
							echo "&nbsp;</td>";

							echo "<td>&nbsp;";
							echo $extra_ot_hour + $row->com_ot;
							echo "&nbsp;</td>";

							echo "<td>&nbsp;";
							echo $remark;
							echo "&nbsp;</td>";

						echo "</tr>";
					}

					echo "<tr>";

					echo "<td colspan='6'>";
					echo 'Total';
					echo "</td>";

					echo "<td>";
					echo $total_ot;
					echo "</td>";

					echo "<td>";
					echo $total_ot_hour - $total_ot;
					echo "</td>";

					echo "<td>";
					echo $total_ot_hour;
					echo "</td>";

					echo "<td>";
					echo "&nbsp;";
					echo "</td>";

					echo "</tr>";

					echo "</table>";

					echo "<br>";
					echo "<table border='0' style='font-size:13px;'>";
					echo "<tr align='center'>";

					echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
					echo "PRESENT";
					echo "</td>";

					echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
					echo "ABSENT";
					echo "</td>";

					echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
					echo "LEAVE";
					echo "</td>";

					echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
					echo "WORK OFF";
					echo "</td>";

					echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
					echo "HOLIDAY";
					echo "</td>";

					echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
					echo "PRESENT ERROR";
					echo "</td>";

					echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
					echo "LATE COUNT";
					echo "</td>";

					echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
					echo "OVER TIME";
					echo "</td>";

					echo "</tr>";

					echo "<tr align='center'>";

					echo "<td>";
					echo $present_count;
					echo "</td>";

					echo "<td>";
					echo $absent_count;
					echo "</td>";

					echo "<td>";
					echo $leave_count;
					echo "</td>";

					echo "<td>";
					echo $wk_off_count;
					echo "</td>";

					echo "<td>";
					echo $holiday_count;
					echo "</td>";

					echo "<td>";
					echo $perror_count;
					echo "</td>";

					echo "<td>";
					echo $late_count;
					echo "</td>";


					echo "<td>";
					echo $total_ot_hour;
					echo "</td>";

					echo "</tr>";
					echo "</table>";
					echo "<br /><br />";

					echo "</div>";
					echo "<br>";
				}
			?>
		</div>
		<br><br>
	</body>
</html>
<?php exit(); ?>

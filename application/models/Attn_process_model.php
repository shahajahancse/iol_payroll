<?php
class Attn_process_model extends CI_Model{


	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
		$this->load->model('file_process_model');
	}

    function delete_double_entry($emp_id,$att_date) {
        $this->db->select('*');
        $this->db->from("pr_emp_shift_log");
        $this->db->where("emp_id", $emp_id);
        $this->db->where("shift_log_date", $att_date);
        $query = $this->db->get();
        if($query->num_rows() > 1)
        {
	        $this->db->where('emp_id',$emp_id);
	        $this->db->where('shift_log_date',$att_date);
	        $this->db->order_by("shift_log_id","ASC");
	        $this->db->delete('pr_emp_shift_log');
        }
        return;
    }

	function attn_process($process_date,$unit,$grid_emp_id, $type = null){

		// $this->autoNewToRegular($process_date);
		//=========================== Get emplpoyee list ============================
		$table = 'att_'.date('Y_m',strtotime($process_date));
		$this->attn_month_table_check($table);
		// dd($unit);
		$this->check_policy_shift_rotation($process_date, $unit);


		$all_employee = $this->get_all_employee($grid_emp_id, 1);
		foreach ($all_employee->result() as $rows){
			$com_id			= $rows->id;
			$emp_id			= $rows->emp_id;
			$proxi_id		= $rows->proxi_id;
			$ot_entitle		= $rows->ot_entitle;
			$com_ot_entitle	= $rows->com_ot_entitle;
			$emp_desi_id	= $rows->emp_desi_id;
			$shift_id		= $rows->shift_id;
			$schedule_id	= $rows->schedule_id;
			$joining_date	= $rows->emp_join_date;
			$shift_name     = isset($rows->shift_name) ? $rows->shift_name : '';
			$sec_name       = isset($rows->sec_name) ? $rows->sec_name : '';
			$com_weekend    = isset($rows->weekend) ? $rows->weekend : '';

			$this->delete_double_entry($emp_id,$process_date);

			//PROCESS ELIGIBILITY CHECK AFTER JOINING AND BEFORE RESIGN OR LEFT
			$resign_check 	= $this->check_resign($emp_id, $process_date);
			$left_check 	= $this->check_left($emp_id, $process_date);

			//IF ANY CONDITION IS FALSE THEN ID WILL NOT GO TO THE CORE PROCESS
			if($joining_date > $process_date or $resign_check == false or $left_check == false){
				$attn_delete = $this->attn_delete_for_eligibility_failed($emp_id, $process_date);
                continue;
			} else {

				//GET CURRENT SHIFT INFORMATION
				// For rotating shifts (Shift A/B/C, Shift 7 Morning/Night, Shift 12 Morning/Night) on a PREVIOUS date:
				// use pr_emp_shift_log to find the actual shift that day
				$sh_name_lower = strtolower(trim($shift_name));
				$is_rotating_shift = in_array($sh_name_lower, array(
					'shift a', 'shift b', 'shift c', 'shifta', 'shiftb', 'shiftc',
					'shift 7 morning', 'shift 7 night',
					'shift 7 morning(7am-7pm)', 'shift 7 night(7pm-7am)',
					'shift 12 morning', 'shift 12 night'
				)) || strpos($sh_name_lower, '7 morning') !== false || strpos($sh_name_lower, '7 night') !== false || strpos($sh_name_lower, '12 morning') !== false || strpos($sh_name_lower, '12 night') !== false;
				$is_previous_date = ($process_date < date('Y-m-d'));

				if ($is_rotating_shift && $is_previous_date) {
					// Fetch the actual shift from pr_emp_shift_log for that date
					$rmp_shift = $this->get_shift_from_rmp_log($emp_id, $process_date);
					if ($rmp_shift) {
						$shift_id    = $rmp_shift->shift_id;
						$schedule_id = $rmp_shift->schedule_id;
						$shift_name  = $rmp_shift->shift_name;
					}
				}

				$emp_shift = $this->emp_shift_check_process($emp_id, $shift_id, $schedule_id, $process_date);
				$shift_id    = $emp_shift->shift_id;
				$schedule_id = $emp_shift->schedule_id;
				if (!empty($emp_shift->shift_name)) {
					$shift_name = $emp_shift->shift_name;
				}

				$is_billing_shift = (strtolower(trim($shift_name)) == 'billing' || strtolower(trim($sec_name)) == 'billing');
				$sh_name_trim = strtolower(trim($shift_name));
				$is_12_shift = in_array($sh_name_trim, array('shift 12 morning', 'shift 12 night', '12 morning', '12 night', 'shift12 morning', 'shift12 night', 'shift 12morning', 'shift 12night')) || strpos($sh_name_trim, '12 morning') !== false || strpos($sh_name_trim, '12 night') !== false;

				$schedule  = $this->get_emp_schedule($emp_shift->schedule_id);

				$in_start_time	= $schedule[0]["in_start"];
				$in_end_time   	= $schedule[0]["in_end"];
				$out_start_time = $schedule[0]["out_start"];
                $out_end_time 	= $schedule[0]["out_end"];
                $ot_start_time 	= $schedule[0]["ot_start"];
                $late_start_time = $schedule[0]["late_start"];
				// dd($schedule);

            	// Schedule datetime boundary calculation:
            	// IN TIME range: in_start to in_end
            	// OUT TIME range: out_start to out_end
            	$in_start_dt = "$process_date $in_start_time";

            	// in_end crosses midnight? (e.g. Shift C: 21:30 to 02:00 next day; Shift 12 Night: 17:30 to 00:00 next day)
            	if (strtotime($in_end_time) < strtotime($in_start_time) || ($in_end_time == '00:00:00' && strtotime($in_start_time) > strtotime('12:00:00'))) {
            		$in_end_date = date('Y-m-d', strtotime($process_date . ' + 1 days'));
            	} else {
            		$in_end_date = $process_date;
            	}
            	$in_end_dt = "$in_end_date $in_end_time";

            	// out_start crosses midnight relative to in_start?
            	// (e.g. Shift C: in_start 21:30 -> out_start 05:50 next day; Shift 12 Night: in_start 17:30 -> out_start 05:50 next day)
            	if (strtotime($out_start_time) < strtotime($in_start_time)) {
            		$out_start_date = date('Y-m-d', strtotime($process_date . ' + 1 days'));
            	} else {
            		$out_start_date = $process_date;
            	}
            	$out_start_dt = "$out_start_date $out_start_time";

            	// out_end crosses midnight relative to out_start?
            	if ($out_start_date == $process_date) {
            		// If out_start is today, but out_end is less than out_start, it crosses midnight to next day
            		// (e.g. Shift B: 21:50 to 06:00 next day; General: 16:00 to 06:00 next day)
            		if (strtotime($out_end_time) < strtotime($out_start_time)) {
            			$out_end_date = date('Y-m-d', strtotime($process_date . ' + 1 days'));
            		} else {
            			$out_end_date = $process_date;
            		}
            	} else {
            		// out_start is already next day (e.g. Shift C: 05:50 next day)
            		if (strtotime($out_end_time) < strtotime($out_start_time)) {
            			$out_end_date = date('Y-m-d', strtotime($out_start_date . ' + 1 days'));
            		} else {
            			$out_end_date = $out_start_date;
            		}
            	}
            	$out_end_dt = "$out_end_date $out_end_time";

            	// Safety buffer for Shift B overnight OT:
            	// Workers finishing overnight OT at 06:00 AM punch out between 06:00 and 07:00 AM.
            	// If schedule out_end is 06:00:00, extend search up to 07:00:00 so punches like 06:01 AM are captured.
            	if (in_array(strtolower(trim($shift_name)), array('shift b', 'shiftb')) && strtotime($out_end_time) <= strtotime('06:00:00')) {
            		$out_end_time = '07:00:00';
            		$out_end_dt   = "$out_end_date $out_end_time";
            	}

            	// Overnight out-punch window for 12-hour shifts or off-days (Friday / weekend / holiday):
            	// Employees on 12-hour shifts or working on off-days can work up to 24 hours (overnight until next morning).
            	// If out_end_date is same as process_date, extend search window to next day morning up to 08:00:00 so next-day punch-out is captured.
            	$is_friday_day = (strtolower(date('l', strtotime($process_date))) === 'friday');
            	if (($is_12_shift || $is_friday_day || $process_date == $weekend || $weekend === true || $process_date == $holiday || $holiday === true) && $out_end_date == $process_date) {
            		$next_out_date = date('Y-m-d', strtotime($process_date . ' + 1 days'));
            		$out_end_dt = "$next_out_date 08:00:00";
            	}

            	$out_date = $out_end_date;

            	// OT start time define
            	$is_shift_night_type = in_array(strtolower(trim($shift_name)), array('shift c', 'shiftc', 'shift 7 night', 'shift 7 night(7pm-7am)', 'shift 12 night', '12 night')) || strpos(strtolower(trim($shift_name)), '7 night') !== false;
            	if ($is_12_shift) {
            		$sched_in_dt = "$process_date " . $schedule[0]["in_time"];
            		$ot_start    = date('Y-m-d H:i:s', strtotime("$sched_in_dt + 12 hours"));
            	} elseif ($out_start_date != $process_date || $is_shift_night_type) {
            		$ot_start = "$out_start_date $ot_start_time";
            	} else {
            		$ot_start = "$process_date $ot_start_time";
            	}

            	$in_start_time  = $in_start_dt;
            	$in_end_time    = $in_end_dt;
            	$out_start_time = $out_start_dt;
            	$out_end_time   = $out_end_dt;

            	$table = 'att_'.date('Y_m',strtotime($process_date));

            	// Check if employee is on approved leave (SL, CL, EL, ML, WP, etc.)
            	$leaves = $this->leave_chech($process_date, $emp_id);
            	// Check if employee is on approved Outside Duty (OD)
            	$is_od  = $this->od_check($process_date, $emp_id);

            	if ($leaves) {
            		// When employee is on leave, no in-time or out-time should be recorded or shown
            		$in_time  = '00:00:00';
            		$out_time = '00:00:00';
            	} elseif ($is_od) {
            		// Outside Duty (OD): in time out time thakbe na, status a OD dekhabe
            		$in_time  = '00:00:00';
            		$out_time = '00:00:00';
            	} elseif (strtolower(trim($shift_name)) == 'single') {
            		$in_time  = $this->time_check_in("$process_date 00:00:00", "$process_date 23:59:59", $emp_id, 'ASC', $table);
            		$out_time = $this->time_check_in("$process_date 00:00:00", "$process_date 23:59:59", $emp_id, 'DESC', $table);
            		// For Single shift: out_time must be distinct from in_time and at least 4 hours later
            		// (avoid morning double punches like 09:19:30 and 09:19:32 being treated as out_time)
            		if (!empty($in_time) && !empty($out_time)) {
            			if ($in_time == $out_time || (strtotime($out_time) - strtotime($in_time)) < 14400) {
            				$out_time = '00:00:00';
            			}
            		}
            	} elseif (strtolower(trim($shift_name)) == 'billing' || strtolower(trim($sec_name)) == 'billing') {
            		$next_day = date('Y-m-d', strtotime($process_date . ' + 1 days'));
            		$in_time  = $this->time_check_in("$process_date 07:00:00", "$next_day 06:00:00", $emp_id, 'ASC', $table);
            		$out_time = $this->time_check_in("$process_date 07:00:00", "$next_day 12:00:00", $emp_id, 'DESC', $table);
            		if ($in_time != '' && $in_time == $out_time) {
            			$out_time = '00:00:00';
            		}
            	} elseif (in_array(strtolower(trim($shift_name)), array('no punch', 'nopunch', 'no_punch', 'no-punch'))) {
            		// No Punch shift: no punches required
            		$in_time  = '00:00:00';
            		$out_time = '00:00:00';
            	} else {
            		// Standard & Rotating Shifts: Shift A, Shift B, Shift C, General 1/2/3, Shift 7/12 Morning/Night, etc.
            		// in_time within in_start to in_end
            		// out_time within out_start to out_end
            		// Check both in_time and out_time independently so single punch (in only or out only) is captured
            		$in_time  = $this->time_check_in($in_start_dt, $in_end_dt, $emp_id, 'ASC', $table);
            		$out_time = $this->time_check_in($out_start_dt, $out_end_dt, $emp_id, 'DESC', $table);
					// dd($in_start_dt.'='.$in_end_dt.'='.$out_start_dt.'='.$out_end_dt.'='.$emp_id.'='.$table);
					// dd($out_start_dt.'='.$out_end_dt.'='.$emp_id.'='.$table);
					// dd($out_time); //2026-11-07 06:06:23 
            		// Check manual entry (device_id = 0):
            		// Rule: Take first (earliest) time for in_time and last (latest) time for out_time
            		$manual_in = $this->time_check_manual($process_date, $emp_id, 1, $table);
            		if (!empty($manual_in)) {
            			if (empty($in_time) || $in_time == '00:00:00') {
            				$in_time = $manual_in;
            			} elseif (strtotime($manual_in) < strtotime($in_time)) {
            				$in_time = $manual_in;
            			}
            		}
            		$manual_out = $this->time_check_manual($process_date, $emp_id, 2, $table, $out_end_date);
            		if (!empty($manual_out)) {
            			if (empty($out_time) || $out_time == '00:00:00') {
            				$out_time = $manual_out;
            			} elseif (strtotime($manual_out) > strtotime($out_time)) {
            				$out_time = $manual_out;
            			}
            		}

            		// 12-Hour Shift Rules:
            		// Rule 1: In-time within 4 hours after scheduled in-time is counted as scheduled in-time (unless manually entered)
            		if ($is_12_shift && !empty($in_time) && $in_time != '00:00:00' && empty($manual_in)) {
            			$sched_in_dt = "$process_date " . $schedule[0]["in_time"];
            			$snap_end_dt = date('Y-m-d H:i:s', strtotime("$sched_in_dt + 4 hours"));
            			if (strtotime($in_time) <= strtotime($snap_end_dt)) {
            				$in_time = $sched_in_dt;
            			}
            		}

            		if (!empty($in_time) && !empty($out_time) && $in_time == $out_time) {
            			$out_time = '00:00:00';
            		}
            		// If employee did not punch IN on this date and the OUT punch that was found occurred on the next day,
            		// that next day morning punch belongs to the next day's shift, not this shift's exit.
            		if ((empty($in_time) || $in_time == '00:00:00') && !empty($out_time) && $out_time != '00:00:00' && date('Y-m-d', strtotime($out_time)) > $process_date) {
            			$out_time = '00:00:00';
            		}
            	}
				// dd($out_time); //2026-11-06 22:30:00


            	// Strict Policy: No punch within the in_time range [in_start_dt, in_end_dt] can be accepted as out_time!
            	// If no punch falls in the designated out_start to out_end range, out_time must remain '00:00:00'.
				// dd($out_time);

            	if (!empty($out_time) && $out_time != '00:00:00') {
            		$out_ts = strtotime($out_time);
            		$in_start_ts = strtotime($in_start_dt);
            		$in_end_ts   = strtotime($in_end_dt);
					// dd($out_time .'>='. $in_start_dt .'&&'. $out_time .'<='. $in_end_dt);
            		if ($out_ts >= $in_start_ts && $out_ts <= $in_end_ts) {
            			$out_time = '00:00:00';
						// dd('lo');
            		}
            		if (!empty($in_time) && $in_time != '00:00:00' && $out_ts <= strtotime($in_time)) {
            			$out_time = '00:00:00';
						// dd('lo;');

            		}
            	}

            	if (!$leaves && !empty($in_time) && empty($out_time) && date('t',strtotime($process_date))==date('d',strtotime($process_date))) {
            		$next_day = date('Y-m-d', strtotime($out_date. ' + 1 days'));
            		$table_next = 'att_'.date('Y_m',strtotime($next_day));
            		$out_time = $this->time_check_in($out_start_dt, $out_end_dt, $emp_id, 'DESC', $table_next);
            	}
				// dd($out_time);

				//=================OT CALCULATION ========================
				$tot_hour 		   = 0;
				$ot_hour 		   = 0;
				$eot_hour 		   = 0;
				$ot_eot_12am 	   = 0;
				$ot_eot_4pm        = 0;
				$deduction_hour    = 0;
				$late_status 	   = 0;
				$early_exit        = 0;
				$night_allo        = 0;
				$holiday_allo 	   = 0;
				$weekly_allo 	   = 0;


                $ot_last_hour 		= $schedule[0]["ot_minute_to_one_hour"];
                $lunch_start   		= $schedule[0]["lunch_start"];
                $lunch_minute  		= $schedule[0]["lunch_minute"];
                $tiffin_break       = $schedule[0]["tiffin_break"];
                $tiffin_minute 		= $schedule[0]["tiffin_minute"];
                $tiffin_break2 		= $schedule[0]["tiffin_break2"];
                $tiffin_minute2		= $schedule[0]["tiffin_minute2"];
                $acual_in_time 		= $schedule[0]["in_time"];
				// dd($schedule);
                $lunch_in = "$process_date $lunch_start";
				$lunch_in_time = date("Y-m-d H:i:s",strtotime("+ $lunch_minute minutes",strtotime($lunch_in)));

                $tiffin_break_start1 = "$process_date $tiffin_break";
				$tiffin_break_end1 = date("Y-m-d H:i:s",strtotime("+ $tiffin_minute minutes",strtotime($tiffin_break_start1)));

                if (strtotime($tiffin_break2) > strtotime('20:00:00')){
	                $tiffin_break2 = "$process_date $tiffin_break2";
                } else {
	                $tiffin_break2 = "$out_date $tiffin_break2";
                }
				$tiffin_break_time2 = date("Y-m-d H:i:s",strtotime("+ $tiffin_minute2 minutes",strtotime($tiffin_break2)));

				//WEEKEND CHECK FOR SPECIFIC ID: RETURN TRUE OR FALSE
				$weekend 	= $this->check_weekend($emp_id, $process_date, $com_weekend);
				$holiday 	= $this->check_holiday($emp_id, $process_date);
				$night_rules = $this->get_night_allowance_rules($process_date, $unit, $emp_desi_id);

				//============= Check employee attendance status & Special Shift Policies =============
				$attn_status = 'A';
				if($leaves){
					if ($this->is_next_day_absent($process_date, $emp_id)) {
						$attn_status = "A";
					} else {
						$attn_status = "L";
					}
					$in_time = '00:00:00';
					$out_time = '00:00:00';
					$tot_hour = 0;
					$ot_hour = 0;
					$eot_hour = 0;
					$ot_eot_12am = 0;
					$ot_eot_4pm = 0;
					$deduction_hour = 0;
					$late_status = 0;
					$early_exit = 0;
					$night_allo = 0;
					$holiday_allo = 0;
					$weekly_allo = 0;
					$alert_msg = 0;
				}elseif (in_array(strtolower(trim($shift_name)), array('no punch', 'nopunch', 'no_punch', 'no-punch'))){
					// No Punch Policy: status all time P dekhabe, and every day present hisabe count korbe
					$attn_status = "P";
					$in_time = '00:00:00';
					$out_time = '00:00:00';
					$tot_hour = 0;
					$ot_hour = 0;
					$eot_hour = 0;
					$ot_eot_12am = 0;
					$ot_eot_4pm = 0;
					$deduction_hour = 0;
					$late_status = 0;
					$early_exit = 0;
					$alert_msg = 0;
				}elseif ($is_od){
					// Outside Duty (OD) Policy:
					// in time out time thakbe na, status a OD dekhabe, but present hisabe count hobe
					$attn_status = "OD";
					$in_time = '00:00:00';
					$out_time = '00:00:00';
					$tot_hour = 0;
					$ot_hour = 0;
					$eot_hour = 0;
					$ot_eot_12am = 0;
					$ot_eot_4pm = 0;
					$deduction_hour = 0;
					$late_status = 0;
					$early_exit = 0;
					$alert_msg = 0;
				}elseif ($process_date == $holiday || $holiday === true){
					$has_punch = (!empty($in_time) && $in_time != '00:00:00') || (!empty($out_time) && $out_time != '00:00:00');
					if ($has_punch && $ot_entitle == 1 && $com_ot_entitle == 1) {
						// For ot_entitle == 1 (Staff), working on holiday counts as normal duty day
						$attn_status = "P";
					} elseif (!$has_punch && $this->is_weekend_holiday_between_leave_and_absent($emp_id, $process_date)) {
						// Sandwich Rule: Holiday falling between Leave and Absent becomes Absent ('A')
						$attn_status = "A";
						$in_time = '00:00:00';
						$out_time = '00:00:00';
						$tot_hour = 0;
						$ot_hour = 0;
						$eot_hour = 0;
					} else {
						// Holiday off day (without punches or ot_entitle==0)
						$attn_status = "H";
					}
					if (empty($in_time) || $in_time == '00:00:00') {
						$out_time = '00:00:00';
					}
				}elseif ($process_date == $weekend || $weekend === true){
					$has_punch = (!empty($in_time) && $in_time != '00:00:00') || (!empty($out_time) && $out_time != '00:00:00');
					if (!$has_punch && ($this->check_bridge_absent($emp_id, $process_date) || $this->is_weekend_holiday_between_leave_and_absent($emp_id, $process_date))) {
						// Bridge Rule & Sandwich Rule: Weekend preceded by Absent or falling between Leave and Absent becomes Absent ('A')
						$attn_status = "A";
						$in_time = '00:00:00';
						$out_time = '00:00:00';
						$tot_hour = 0;
						$ot_hour = 0;
						$eot_hour = 0;
					// dd($out_time);

					} else {
						// Weekend off day: always sets present_status to "W"
						$attn_status = "W";
					}
					if (empty($in_time) || $in_time == '00:00:00') {
						$out_time = '00:00:00';
					}
				}elseif (strtolower(trim($shift_name)) == 'single'){
					// Single Punch Policy: single punch at any time during 24 hrs (00:00:00 to 23:59:59) counted as present, otherwise absent
					if ($in_time != '' || ($out_time != '' && $out_time != '00:00:00')) {
						$attn_status = "P";
					} else {
						$attn_status = "A";
					}
				}elseif ($is_billing_shift && ($in_time != '' || ($out_time != '' && $out_time != '00:00:00'))){
					// Billing Section/Shift Policy:
					// 1. Working time counts 8 hrs from actual in_time (whenever they punch in).
					// 2. NO late count (late_status = 0).
					// 3. If total punched time < 8 hrs (480 mins): Half-day salary deduction (deduction_hour = 4).
					// 4. If total punched time > 8 hrs & employee is OT eligible: overtime is granted for excess hours.
					$attn_status = "P";
					$work_mins = 0;
					if ($in_time != '' && $in_time != '00:00:00' && $out_time != '' && $out_time != '00:00:00' && strtotime($out_time) > strtotime($in_time)) {
						$work_mins = round((strtotime($out_time) - strtotime($in_time)) / 60);
					}

					$is_ot_eligible = ($ot_entitle == 0 || $com_ot_entitle == 0);

					if ($work_mins >= 480) {
						// Work >= 8 hours -> Full day fulfilled
						$early_exit = 0;
						$deduction_hour = 0;
						if ($is_ot_eligible) {
							$extra_mins = $work_mins - 480;
							$calc_ot = floor($extra_mins / 60);
							if (!empty($ot_last_hour) && ($extra_mins % 60) >= $ot_last_hour) {
								$calc_ot += 1;
							}
							// Per day maximum OT limit = 16 hours
							if ($calc_ot > 16) {
								$calc_ot = 16;
							}
							$tot_hour = $calc_ot;
							if ($calc_ot > 2) {
								$ot_hour  = 2;
								$eot_hour = $calc_ot - 2;
							} else {
								$ot_hour  = $calc_ot;
								$eot_hour = 0;
							}
							$ot_eot_4pm  = min($eot_hour, 2);
							$ot_eot_12am = min($eot_hour, 5);
						} else {
							$ot_hour     = 0;
							$eot_hour    = 0;
							$tot_hour    = 0;
							$ot_eot_4pm  = 0;
							$ot_eot_12am = 0;
						}
					} else {
						// Work < 8 hours (or single punch) -> Half-day salary deduction
						$early_exit = 1;
						$deduction_hour = 4; // Half-day deduction (4 hours = 0.5 day)
						$ot_hour     = 0;
						$eot_hour    = 0;
						$tot_hour    = 0;
						$ot_eot_4pm  = 0;
						$ot_eot_12am = 0;
					}
				}elseif (($in_time != '' && $in_time != '00:00:00') && ($out_time != '' && $out_time != '00:00:00') && $in_time != $out_time){
					// Both IN and OUT punches are present and distinct -> Full Day Present
					$attn_status = "P";
					$deduction_hour = 0;
					$early_exit = 0;
				}elseif (($in_time != '' && $in_time != '00:00:00') || ($out_time != '' && $out_time != '00:00:00')){
					// Punch Error: Only IN punch or only OUT punch present -> Half Day (4 hours deduction)
					$attn_status = "P(Error)";
					$deduction_hour = 4; // Half-day deduction
					$early_exit = 1;
				}
				//============= Check employee attendance status =============
					// dd($out_time);

				//============= Working day/Weeked/Holiday OT Calculation =============
				if ($ot_entitle == 1 && $com_ot_entitle == 1) {
					// Ineligible for OT (Staff): all hours count as normal duty, no OT generated
					$tot_hour    = 0;
					$ot_hour     = 0;
					$eot_hour    = 0;
					$ot_eot_4pm  = 0;
					$ot_eot_12am = 0;
				} elseif ($attn_status != 'A' && $attn_status != 'L' && $in_time != "" && $in_time != "00:00:00" && $out_time !="" && $out_time != "00:00:00" && $in_time != $out_time) {
					//======= Friday / Weekend / Holiday Extra OT Calculation ==========
					$is_friday = (strtolower(date('l', strtotime($process_date))) === 'friday');
					if($is_friday || $process_date == $weekend || $weekend === true || $process_date == $holiday || $holiday === true){

                		$start_date_time = strtotime($in_time);
						$end_date_time 	 = strtotime($out_time);
						if ($end_date_time < $start_date_time || ($end_date_time - $start_date_time) < 7200) {
							$end_date_time = strtotime("+1 day", $end_date_time);
						}
						$minute = round(($end_date_time - $start_date_time)/60);

						// Lunch break Deduction
						if (($out_time > $lunch_in_time) && ($lunch_minute != 0)) {
							$minute = $minute - $lunch_minute;
						}

						// Tiffin break Deduction
						if ($out_time > $tiffin_break_end1 && $tiffin_minute != 0) {
							$minute = $minute - $tiffin_minute;
						}
						// Tiffin break Deduction
						if ($out_time > $tiffin_break_time2 && $tiffin_minute2 != 0) {
							$minute = $minute - $tiffin_minute2;
						}

						if ($minute < 0) {
							$minute = 0;
						}

						// Full time duty on Friday / off day / weekend / holiday is counted as OT
						$eot_hour = floor($minute / 60);
						if (!empty($ot_last_hour) && ($minute % 60) >= $ot_last_hour) {
							$eot_hour = $eot_hour + 1;
						}
						// Per day maximum OT limit: Friday and off days (weekend/holiday) full duty counted as OT, capped at max 24 hours
						$max_cap = 24;
						if ($eot_hour > $max_cap) {
							$eot_hour = $max_cap;
						}
						$tot_hour = $eot_hour;
						$ot_hour  = 0;

						$ot_eot_4pm  = min($eot_hour, 2);
						$ot_eot_12am = min($eot_hour, 5);

					} elseif ($is_billing_shift) {
						// Billing Shift on regular working day:
						// OT already calculated from flexible in_time to out_time (8 hrs duty + extra).
						// Do NOT overwrite with standard ot_start!
					} else {

						// dd("KO");

						$start_date_time = strtotime($ot_start);
						$end_date_time 	 = strtotime($out_time);

						if ($end_date_time > $start_date_time && $in_time != '') {
							$minute = round(($end_date_time - $start_date_time)/60);
							// dd($minute);
							// Tiffin break Deduction Hour
							if ($tiffin_break_end1 < $out_time && $tiffin_minute != 0) {
								if($minute > $tiffin_minute){
									$minute = $minute - $tiffin_minute;
								}else{
									$minute = 0;
								}
							}
							// Tiffin break Deduction Hour/
							if ($tiffin_break_time2 < $out_time && $tiffin_minute2 != 0) {
								if($minute > $tiffin_minute2){
									$minute = $minute - $tiffin_minute2;
								}else{
									$minute = 0;
								}
							}
							// OT Calculation
							$ot_hour = floor($minute / 60);
							if ($minute % 60 >= $ot_last_hour) {
								$ot_hour = $ot_hour + 1;
							}
							$tot_hour = $ot_hour;
							// EOT Calculation
							if ($ot_hour > 2) {
								$eot_hour = $ot_hour - 2;
								$ot_hour = 2;
							}
							// Per day maximum OT limit = 16 hours total (2 hrs normal OT + max 14 hrs EOT)
							if ($eot_hour > 14) {
								$eot_hour = 14;
							}
							$tot_hour = $ot_hour + $eot_hour;
							// dd($eot_hour);
							// 9pm EOT Calculation
							if ($eot_hour > 2) {
								$ot_eot_4pm = 2;
							} else {
								$ot_eot_4pm = $eot_hour;
							}
							// 12am EOT Calculation
							if ($is_12_shift) {
								$ot_eot_12am = min($eot_hour, 10);
							} elseif ($tiffin_break_time2 < $out_time && $tiffin_minute2 != 0) {
								$ot_eot_12am = 5;
							} else {
								if ($eot_hour > 5) {
									$ot_eot_12am = 5;
								} else {
									$ot_eot_12am = $eot_hour;
								}
							}
						}
					}
				}
				//============ End  Working day/Weeked/Holiday OT Calculation =============

				// Allowances: All allowances disabled as per company policy
				$night_allo = 0;

				// Late Status check: No late count for 12-hour shifts or Friday / off days
				$late_start_time = "$process_date $late_start_time";
				if ($is_friday || $is_billing_shift || $is_12_shift || $attn_status == 'W' || $attn_status == 'H' || $attn_status == 'L' || $attn_status == 'OD' || in_array(strtolower(trim($shift_name)), array('no punch', 'nopunch', 'no_punch', 'no-punch'))) {
					$late_status = 0;
				} elseif ($in_time > $late_start_time && $in_time != '' && $in_time != '00:00:00') {
					$late_status = 1;
				} else {
					$late_status = 0;
				}
				// Late Status

				// week and holiday allowance: disabled as per policy
				$weekly_allo = 0;
				$holiday_allo = 0;

				// get alert message
				$alert_msg = 0;
				if ($attn_status == "P" || $attn_status == "P(Error)") {
					$alert_msg = $this->get_alert_message($emp_id, $process_date, 1);
				}

				$data = array(
					'in_time' 			=> (!empty($in_time)) ? $in_time : '00:00:00',
					'out_time' 			=> (!empty($out_time)) ? $out_time : '00:00:00',
					'tot' 				=> $tot_hour,
					'ot' 				=> $ot_hour,
					'eot' 				=> $eot_hour,
					'false_ot_4' 		=> null,
					'false_ot_12' 		=> null,
					'false_ot_all' 		=> null,
					'ot_eot_4pm' 		=> $ot_eot_4pm,
					'ot_eot_12am' 		=> $ot_eot_12am,
					'deduction_hour' 	=> $deduction_hour,
					'late_status' 		=> $late_status,
					'early_exit' 		=> $early_exit,
					'present_status' 	=> $attn_status,
					'tiffin_allo' 		=> 0,
					'night_allo' 		=> $night_allo,
					'holiday_allo'	    => $holiday_allo,
					'weekly_allo'		=> $weekly_allo,
					'unit_id'			=> $unit,
					'alert_msg'			=> $alert_msg
				);
				// dd($data);
				// dd($out_time);

				$this->db->where('shift_log_date', $process_date);
				$this->db->where('emp_id', $emp_id);
				$this->db->update('pr_emp_shift_log', $data);

				// Rule: If an employee took leave, but is absent on subsequent day(s):
				// The preceding consecutive leave days are forfeited in attendance log (marked 'A'),
				// while remaining counted/deducted in pr_leave_trans.
				if ($attn_status == 'A') {
					$this->forfeit_consecutive_preceding_leaves($emp_id, $process_date);
					$this->bridge_consecutive_subsequent_weekends_holidays($emp_id, $process_date);
				} elseif ($attn_status == 'P') {
					$this->restore_consecutive_preceding_leaves($emp_id, $process_date);
					$this->unbridge_consecutive_subsequent_weekends_holidays($emp_id, $process_date);
				}
			}
		}

		// check roster shift & policy rotation
		// if ($unit == 4 && strtotime(date('Y-m-d')) == strtotime($process_date)) {
		// 	$this->check_shift_roster($process_date, $unit);
		// }

		// Automatically sync/generate Daily OT list for this date
		try {
			$this->load->model('Ot_approval_model');
			$this->Ot_approval_model->generate_or_sync_daily_ot($process_date, $process_date, $unit);
		} catch (Exception $e) {
			log_message('error', 'Daily OT sync error: ' . $e->getMessage());
		}

		return true;
	}

	function init_shift_rotation_log_table()
	{
		if (!$this->db->table_exists('pr_shift_rotation_log')) {
			$this->db->query("
				CREATE TABLE IF NOT EXISTS `pr_shift_rotation_log` (
					`id`              INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`unit_id`         INT(11) NOT NULL,
					`rotation_date`   DATE NOT NULL,
					`from_shift_id`   INT(11) NULL,
					`to_shift_id`     INT(11) NULL,
					`from_shift_name` VARCHAR(100) NULL,
					`to_shift_name`   VARCHAR(100) NULL,
					`emp_count`       INT(11) DEFAULT 0,
					`rotation_type`   VARCHAR(50) NOT NULL,
					`created_at`      DATETIME DEFAULT CURRENT_TIMESTAMP,
					UNIQUE KEY `uq_unit_date_type` (`unit_id`, `rotation_date`, `rotation_type`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8
			");
		} else {
			if (!$this->db->field_exists('from_shift_id', 'pr_shift_rotation_log')) {
				$this->db->query("ALTER TABLE `pr_shift_rotation_log` ADD COLUMN `from_shift_id` INT(11) NULL AFTER `rotation_date`");
			}
			if (!$this->db->field_exists('to_shift_id', 'pr_shift_rotation_log')) {
				$this->db->query("ALTER TABLE `pr_shift_rotation_log` ADD COLUMN `to_shift_id` INT(11) NULL AFTER `from_shift_id`");
			}
			if (!$this->db->field_exists('from_shift_name', 'pr_shift_rotation_log')) {
				$this->db->query("ALTER TABLE `pr_shift_rotation_log` ADD COLUMN `from_shift_name` VARCHAR(100) NULL AFTER `to_shift_id`");
			}
			if (!$this->db->field_exists('to_shift_name', 'pr_shift_rotation_log')) {
				$this->db->query("ALTER TABLE `pr_shift_rotation_log` ADD COLUMN `to_shift_name` VARCHAR(100) NULL AFTER `from_shift_name`");
			}
			if (!$this->db->field_exists('emp_count', 'pr_shift_rotation_log')) {
				$this->db->query("ALTER TABLE `pr_shift_rotation_log` ADD COLUMN `emp_count` INT(11) DEFAULT 0 AFTER `to_shift_name`");
			}
			$this->db->query("ALTER TABLE `pr_shift_rotation_log` MODIFY COLUMN `rotation_type` VARCHAR(50) NOT NULL");
		}
		$this->db->reset_query();
	}

	function is_shift_rotated($unit, $rotation_date, $from_shift_id, $rotation_type)
	{
		$this->db->where('unit_id', $unit);
		$this->db->where('rotation_date', $rotation_date);
		$this->db->group_start();
			if (!empty($from_shift_id)) {
				$this->db->where('from_shift_id', $from_shift_id);
				$this->db->or_where('rotation_type', $rotation_type);
			} else {
				$this->db->where('rotation_type', $rotation_type);
			}
			if (strpos($rotation_type, 'saturday') !== false) {
				$this->db->or_where('rotation_type', 'saturday');
			} elseif (strpos($rotation_type, 'shift12') !== false) {
				$this->db->or_where('rotation_type', 'shift12_nm');
			}
		$this->db->group_end();
		$count = $this->db->count_all_results('pr_shift_rotation_log');
		$this->db->reset_query();
		return ($count > 0);
	}

	function insert_shift_rotation_log($unit, $rotation_date, $from_shift_id, $to_shift_id, $from_shift_name, $to_shift_name, $emp_count, $rotation_type)
	{
		$this->db->insert('pr_shift_rotation_log', [
			'unit_id'         => $unit,
			'rotation_date'   => $rotation_date,
			'from_shift_id'   => $from_shift_id,
			'to_shift_id'     => $to_shift_id,
			'from_shift_name' => $from_shift_name,
			'to_shift_name'   => $to_shift_name,
			'emp_count'       => $emp_count,
			'rotation_type'   => $rotation_type,
		]);
		$this->db->reset_query();
	}

	function get_shift_by_name($name)
	{
		$shift = $this->db->where('TRIM(shift_name)', trim($name))->get('pr_emp_shift')->row();
		if ($shift) return $shift;

		$shift = $this->db->where('TRIM(LOWER(shift_name))', strtolower(trim($name)))->get('pr_emp_shift')->row();
		if ($shift) return $shift;

		if (stripos($name, '7 morning') !== false || stripos($name, '7morning') !== false) {
			$shift = $this->db->like('shift_name', '7 morning')->get('pr_emp_shift')->row();
			if ($shift) return $shift;
		}
		if (stripos($name, '7 night') !== false || stripos($name, '7night') !== false) {
			$shift = $this->db->like('shift_name', '7 night')->get('pr_emp_shift')->row();
			if ($shift) return $shift;
		}

		return null;
	}

	function check_policy_shift_rotation($date, $unit = 1)
	{
		$rotation_date = date('Y-m-d', strtotime($date));
		$day_name      = date('l', strtotime($date));
		$day_num       = date('d', strtotime($date));

		$this->init_shift_rotation_log_table();

		// -----------------------------------------------------------------------
		// Saturday Shift Rotation
		// -----------------------------------------------------------------------
		// Rules on every Saturday:
		// 1) Shift A  to Shift C
		// 2) Shift B  to Shift A
		// 3) Shift C  to Shift B
		// 4) Shift 7 Morning to Shift 7 Night
		// 5) Shift 7 Night   to Shift 7 Morning
		// -----------------------------------------------------------------------
		if ($day_name == 'Saturday') {

			// --- 1. Shift A, Shift B, Shift C Rotation ---
			$shiftA = $this->get_shift_by_name('Shift A');
			$shiftB = $this->get_shift_by_name('Shift B');
			$shiftC = $this->get_shift_by_name('Shift C');

			if ($shiftA && $shiftB && $shiftC) {
				$rotateA = !$this->is_shift_rotated($unit, $rotation_date, $shiftA->id, 'saturday_shift_a_to_c');
				$rotateB = !$this->is_shift_rotated($unit, $rotation_date, $shiftB->id, 'saturday_shift_b_to_a');
				$rotateC = !$this->is_shift_rotated($unit, $rotation_date, $shiftC->id, 'saturday_shift_c_to_b');

				if ($rotateA || $rotateB || $rotateC) {
					// CRITICAL: Fetch employee lists for all shifts BEFORE modifying any shift to avoid cascade overwrite
					$empA = $this->get_roster_shift_emp($shiftA->id, $unit);
					$empB = $this->get_roster_shift_emp($shiftB->id, $unit);
					$empC = $this->get_roster_shift_emp($shiftC->id, $unit);

					if ($rotateA) {
						if (!empty($empA)) {
							$this->auto_change_roster_shift($empA, $shiftC->id, $unit);
						}
						$this->insert_shift_rotation_log($unit, $rotation_date, $shiftA->id, $shiftC->id, $shiftA->shift_name, $shiftC->shift_name, count($empA), 'saturday_shift_a_to_c');
					}

					if ($rotateB) {
						if (!empty($empB)) {
							$this->auto_change_roster_shift($empB, $shiftA->id, $unit);
						}
						$this->insert_shift_rotation_log($unit, $rotation_date, $shiftB->id, $shiftA->id, $shiftB->shift_name, $shiftA->shift_name, count($empB), 'saturday_shift_b_to_a');
					}

					if ($rotateC) {
						if (!empty($empC)) {
							$this->auto_change_roster_shift($empC, $shiftB->id, $unit);
						}
						$this->insert_shift_rotation_log($unit, $rotation_date, $shiftC->id, $shiftB->id, $shiftC->shift_name, $shiftB->shift_name, count($empC), 'saturday_shift_c_to_b');
					}
				}
			}

			// --- 2. Shift 7 Morning & Night Swap ---
			$shift7Morning = $this->get_shift_by_name('Shift 7 Morning');
			$shift7Night   = $this->get_shift_by_name('Shift 7 Night');

			if ($shift7Morning && $shift7Night) {
				$rotate7m = !$this->is_shift_rotated($unit, $rotation_date, $shift7Morning->id, 'saturday_shift_7m_to_7n');
				$rotate7n = !$this->is_shift_rotated($unit, $rotation_date, $shift7Night->id,   'saturday_shift_7n_to_7m');

				if ($rotate7m || $rotate7n) {
					// CRITICAL: Fetch employee lists for both shifts BEFORE modifying either
					$emp7m = $this->get_roster_shift_emp($shift7Morning->id, $unit);
					$emp7n = $this->get_roster_shift_emp($shift7Night->id,   $unit);

					if ($rotate7m) {
						if (!empty($emp7m)) {
							$this->auto_change_roster_shift($emp7m, $shift7Night->id, $unit);
						}
						$this->insert_shift_rotation_log($unit, $rotation_date, $shift7Morning->id, $shift7Night->id, $shift7Morning->shift_name, $shift7Night->shift_name, count($emp7m), 'saturday_shift_7m_to_7n');
					}

					if ($rotate7n) {
						if (!empty($emp7n)) {
							$this->auto_change_roster_shift($emp7n, $shift7Morning->id, $unit);
						}
						$this->insert_shift_rotation_log($unit, $rotation_date, $shift7Night->id, $shift7Morning->id, $shift7Night->shift_name, $shift7Morning->shift_name, count($emp7n), 'saturday_shift_7n_to_7m');
					}
				}
			}
		}

		// -----------------------------------------------------------------------
		// 5th & 25th Shift Rotation for Shift 12 Night and Shift 12 Morning
		// -----------------------------------------------------------------------
		// 4 tarikh theke 24 tarikh porjonto duty seshe 25 tarikh swap:
		// Shift 12 Night   -> Shift 12 Morning
		// Shift 12 Morning -> Shift 12 Night
		//
		// 25 tarikh theke 4 tarikh porjonto duty seshe 5 tarikh swap:
		// Shift 12 Morning -> Shift 12 Night
		// Shift 12 Night   -> Shift 12 Morning
		// -----------------------------------------------------------------------
		$is_5th  = ((int)$day_num == 5);
		$is_25th = ((int)$day_num == 25);

		if ($is_5th || $is_25th) {
			$shift12Night   = $this->get_shift_by_name('Shift 12 Night');
			$shift12Morning = $this->get_shift_by_name('Shift 12 Morning');

			if ($shift12Night && $shift12Morning) {
				$rotate12n = !$this->is_shift_rotated($unit, $rotation_date, $shift12Night->id,   'shift12_night_to_morning');
				$rotate12m = !$this->is_shift_rotated($unit, $rotation_date, $shift12Morning->id, 'shift12_morning_to_night');

				if ($rotate12n || $rotate12m) {
					// CRITICAL: Fetch employee lists for both shifts BEFORE modifying either
					$empNight   = $this->get_roster_shift_emp($shift12Night->id,   $unit);
					$empMorning = $this->get_roster_shift_emp($shift12Morning->id, $unit);

					if ($rotate12n) {
						if (!empty($empNight)) {
							$this->auto_change_roster_shift($empNight, $shift12Morning->id, $unit);
						}
						$this->insert_shift_rotation_log($unit, $rotation_date, $shift12Night->id, $shift12Morning->id, $shift12Night->shift_name, $shift12Morning->shift_name, count($empNight), 'shift12_night_to_morning');
					}

					if ($rotate12m) {
						if (!empty($empMorning)) {
							$this->auto_change_roster_shift($empMorning, $shift12Night->id, $unit);
						}
						$this->insert_shift_rotation_log($unit, $rotation_date, $shift12Morning->id, $shift12Night->id, $shift12Morning->shift_name, $shift12Night->shift_name, count($empMorning), 'shift12_morning_to_night');
					}
				}
			}
		}
	}



	function autoNewToRegular($process_date)
	{
		$this->db->where('emp_cat_id',4)
			->where('emp_join_date <=', date('Y-m-d', strtotime('-1 month'.$process_date)))
			->update('pr_emp_com_info',['emp_cat_id'=>1]);
	}

	// get alert message
	function get_alert_message($emp_id, $process_date, $type)
	{
		$this->db->where('emp_id', $emp_id);
		$this->db->where('date', $process_date);
		$this->db->where('status', $type);
		$result = $this->db->get('emp_alert_message')->row();
		if (!empty($result)) {
			return 1;
		} else {
			return 0;
		}
	}

	// check roster shift and chage it
	function check_shift_roster($date, $unit)
	{
		// dd($date);
		$date = date("Y-m-d",strtotime($date));
		$shifts = $this->db->where('end_date',$date)->where('unit_id',$unit)->get('pr_emp_roster_shift');

		if ($shifts->num_rows() == 0) {
			return false;
		}

		foreach ($shifts->result() as $key => $row) {
			$id 		= $row->id;
			$start_date = $row->start_date;
			$end_date   = $row->end_date;
			$duration 	= $row->duration;
			$dd 		= json_decode($row->shift_type);
			$shift_type = $dd[0];

			// dd($shift_type);
			// automatecally change employee shift
			if (count($shift_type) == 3) {
				$morning_shift = $shift_type[0];
				$evening_shift = $shift_type[1];
				$night_shift   = $shift_type[2];

				// get shift id wise employee in array
				$morning = $this->get_roster_shift_emp($morning_shift, $unit);
				$evening = $this->get_roster_shift_emp($evening_shift, $unit);
				$night   = $this->get_roster_shift_emp($night_shift, $unit);

				if (!empty($morning)) {
					$this->auto_change_roster_shift($morning, $night_shift, $unit);
				}
				if (!empty($evening)) {
					$this->auto_change_roster_shift($evening, $morning_shift, $unit);
				}
				if (!empty($night)) {
					$this->auto_change_roster_shift($night, $evening_shift, $unit);
				}

			} else if (count($shift_type) == 2) {
				$day_shift 	 = $shift_type[0];
				$night_shift = $shift_type[1];
				$days 	= $this->get_roster_shift_emp($day_shift, $unit);
				$night  = $this->get_roster_shift_emp($night_shift, $unit);

				if (!empty($days)) {
					$this->auto_change_roster_shift($days, $night_shift, $unit);
				}

				if (!empty($night)) {
					$this->auto_change_roster_shift($night, $day_shift, $unit);
				}
			}
			// end auto employee shift change

			// update auto roster shift
			$shift_start_date = date('Y-m-d', strtotime($start_date ." + $duration days"));
			$shift_end_date   = date('Y-m-d', strtotime($end_date ." + $duration days"));
			$this->update_roster_shift($id, $shift_start_date, $shift_end_date, $unit);
		}
		return true;
	}

	function auto_change_roster_shift($emp_array, $emp_shift, $unit_id)
	{
		if (empty($emp_array)) {
			return true;
		}
		$data = array(
			'emp_shift' => $emp_shift
		);

		$this->db->where_in('emp_id', $emp_array)->where('unit_id', $unit_id)->update('pr_emp_com_info', $data);
		// dd($data);
		return true;
	}

	function get_roster_shift_emp($emp_shift, $unit_id)
	{
		$rs=$this->db->select('emp_id')->where('emp_shift',$emp_shift)->where('unit_id',$unit_id)->get('pr_emp_com_info');
		$result = $rs->result_array();
		// dd($result);
		$output = array();

		array_walk($result, function($entry) use (&$output) {
		    $output[] = $entry["emp_id"];
		});
		// dd($output);

		return $output;
	}

	function update_roster_shift($id, $start_date, $end_date, $unit_id)
	{
		$data = array(
			'start_date' => $start_date,
			'end_date'   => $end_date,
		);
		$this->db->where('id', $id)->where('unit_id', $unit_id)->update('pr_emp_roster_shift', $data);
		return true;
	}
	// end roster shift


	// get employee list
	function get_all_employee($grid_emp_id, $type = null){
		$this->db->select('
				pr_emp_com_info.id,
				pr_emp_com_info.emp_id,
				pr_emp_com_info.proxi_id,
				pr_emp_com_info.emp_desi_id,
				pr_emp_com_info.att_bonus,
				pr_emp_com_info.ot_entitle,
				pr_emp_com_info.com_ot_entitle,
				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.weekend,
				pr_emp_shift.id as shift_id,
				pr_emp_shift.shift_name,
				pr_emp_shift.schedule_id,
				emp_section.sec_name_en as sec_name
		');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_shift');
		$this->db->join('emp_section', 'emp_section.id = pr_emp_com_info.emp_sec_id', 'left');
		if (!empty($type)) {
			$this->db->where_in("pr_emp_com_info.emp_id",$grid_emp_id);
		} else {
			$this->db->where_in("pr_emp_com_info.id",$grid_emp_id);
		}
		$this->db->where("pr_emp_com_info.emp_shift = pr_emp_shift.id");
		$this->db->order_by("pr_emp_com_info.emp_id");
		return $query = $this->db->get();
	}

	function time_check_in($start_time, $end_time, $emp_id, $order_by, $table = null){
		$t1 = 'att_' . date('Y_m', strtotime($start_time));
		$t2 = 'att_' . date('Y_m', strtotime($end_time));

		if ($t1 === $t2) {
			$target_table = !empty($table) ? $table : $t1;
			if (!$this->db->table_exists($target_table)) {
				return '';
			}
			$this->db->select("date_time");
			$this->db->from($target_table);
			$this->db->where("$target_table.proxi_id", $emp_id);
			$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
			$this->db->order_by("date_time", $order_by);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row()->date_time;
			} else {
				return '';
			}
		}

		// Cross-month search
		if ($order_by === 'ASC') {
			if ($this->db->table_exists($t1)) {
				$this->db->select("date_time");
				$this->db->from($t1);
				$this->db->where("$t1.proxi_id", $emp_id);
				$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
				$this->db->order_by("date_time", 'ASC');
				$this->db->limit(1);
				$q1 = $this->db->get();
				if ($q1->num_rows() > 0) {
					return $q1->row()->date_time;
				}
			}
			if ($this->db->table_exists($t2)) {
				$this->db->select("date_time");
				$this->db->from($t2);
				$this->db->where("$t2.proxi_id", $emp_id);
				$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
				$this->db->order_by("date_time", 'ASC');
				$this->db->limit(1);
				$q2 = $this->db->get();
				if ($q2->num_rows() > 0) {
					return $q2->row()->date_time;
				}
			}
		} else {
			if ($this->db->table_exists($t2)) {
				$this->db->select("date_time");
				$this->db->from($t2);
				$this->db->where("$t2.proxi_id", $emp_id);
				$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
				$this->db->order_by("date_time", 'DESC');
				$this->db->limit(1);
				$q2 = $this->db->get();
				if ($q2->num_rows() > 0) {
					return $q2->row()->date_time;
				}
			}
			if ($this->db->table_exists($t1)) {
				$this->db->select("date_time");
				$this->db->from($t1);
				$this->db->where("$t1.proxi_id", $emp_id);
				$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
				$this->db->order_by("date_time", 'DESC');
				$this->db->limit(1);
				$q1 = $this->db->get();
				if ($q1->num_rows() > 0) {
					return $q1->row()->date_time;
				}
			}
		}

		return '';
	}

	function prox($empid)
	{
		$row = $this->db->select('proxi_id')->where('emp_id', $empid)->get('pr_id_proxi')->row();
		return !empty($row) ? $row->proxi_id : $empid;
	}

	function time_check_manual($date, $emp_id, $monitor_con, $table = null, $out_date = null) {
		$target_table = !empty($table) ? $table : ('att_' . date('Y_m', strtotime($date)));
		if (!$this->db->table_exists($target_table)) {
			return '';
		}

		$proxi = $this->prox($emp_id);
		$ids = array($emp_id);
		if (!empty($proxi) && $proxi != $emp_id) {
			$ids[] = $proxi;
		}

		if ($monitor_con == 1) {
			// IN punch: look for device_id = 0, monitor_con = 1 on shift date
			$this->db->select("date_time");
			$this->db->from($target_table);
			$this->db->where_in("proxi_id", $ids);
			$this->db->where("device_id", 0);
			$this->db->where("monitor_con", 1);
			$this->db->like("date_time", $date);
			$this->db->order_by("date_time", "ASC");
			$this->db->limit(1);
			$row = $this->db->get()->row();
			if (!empty($row)) {
				return $row->date_time;
			}
			return '';
		} else {
			// OUT punch: look for device_id = 0, monitor_con = 2
			$next_day = date('Y-m-d', strtotime($date . ' + 1 days'));
			$next_table = 'att_' . date('Y_m', strtotime($next_day));

			// 1. Check next day for early morning manual out punch (< 08:00:01)
			if ($this->db->table_exists($next_table)) {
				$this->db->select("date_time");
				$this->db->from($next_table);
				$this->db->where_in("proxi_id", $ids);
				$this->db->where("device_id", 0);
				$this->db->where("monitor_con", 2);
				$this->db->like("date_time", $next_day);
				$this->db->where("TIME(date_time) <", "08:00:01");
				$this->db->order_by("date_time", "DESC");
				$this->db->limit(1);
				$row = $this->db->get()->row();
				if (!empty($row)) {
					return $row->date_time;
				}
			}

			// 2. Check designated out_date if provided (and different from date and next_day)
			if (!empty($out_date) && $out_date != $date && $out_date != $next_day) {
				$out_table = 'att_' . date('Y_m', strtotime($out_date));
				if ($this->db->table_exists($out_table)) {
					$this->db->select("date_time");
					$this->db->from($out_table);
					$this->db->where_in("proxi_id", $ids);
					$this->db->where("device_id", 0);
					$this->db->where("monitor_con", 2);
					$this->db->like("date_time", $out_date);
					$this->db->order_by("date_time", "DESC");
					$this->db->limit(1);
					$row = $this->db->get()->row();
					if (!empty($row)) {
						return $row->date_time;
					}
				}
			}

			// 3. Check shift date ($date): only consider out punch >= 08:00:01
			// (punches < 08:00:01 on $date belonged to previous day's overnight shift)
			if ($this->db->table_exists($target_table)) {
				$this->db->select("date_time");
				$this->db->from($target_table);
				$this->db->where_in("proxi_id", $ids);
				$this->db->where("device_id", 0);
				$this->db->where("monitor_con", 2);
				$this->db->like("date_time", $date);
				$this->db->where("TIME(date_time) >=", "08:00:01");
				$this->db->order_by("date_time", "DESC");
				$this->db->limit(1);
				$row = $this->db->get()->row();
				if (!empty($row)) {
					return $row->date_time;
				}
			}

			return '';
		}
	}

	public function update_shift_log_manual_times($emp_ids, $date, $in_time_raw, $out_time_raw, $unit_id = 1)
	{
		if (empty($emp_ids) || empty($date)) {
			return;
		}
		if (!is_array($emp_ids)) {
			$emp_ids = array_filter(array_map('trim', explode(',', $emp_ids)));
		}

		$in_time  = (!empty($in_time_raw) && $in_time_raw != '00:00:00') ? date('H:i:s', strtotime($in_time_raw)) : '';
		$out_time = (!empty($out_time_raw) && $out_time_raw != '00:00:00') ? date('H:i:s', strtotime($out_time_raw)) : '';

		if (empty($in_time) && empty($out_time)) {
			return;
		}

		foreach ($emp_ids as $emp_id) {
			$emp_id = trim($emp_id);
			if (empty($emp_id)) continue;

			$shift_log = $this->db->where('emp_id', $emp_id)
								  ->where('shift_log_date', $date)
								  ->get('pr_emp_shift_log')
								  ->row();

			$final_in  = !empty($in_time) ? $in_time : (!empty($shift_log->in_time) ? $shift_log->in_time : '00:00:00');
			$final_out = !empty($out_time) ? $out_time : (!empty($shift_log->out_time) ? $shift_log->out_time : '00:00:00');

			// Get employee shift and schedule
			$com_info = $this->db->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
			$ot_entitle = !empty($com_info) ? (int)$com_info->ot_entitle : 0;
			$com_ot_entitle = !empty($com_info) && isset($com_info->com_ot_entitle) ? (int)$com_info->com_ot_entitle : 0;
			$shift_id = !empty($shift_log->shift_id) ? $shift_log->shift_id : (!empty($com_info) ? $com_info->emp_shift : 1);
			$schedule_id = !empty($shift_log->schedule_id) ? $shift_log->schedule_id : (!empty($com_info) ? $com_info->emp_sh_sched : 1);

			$emp_shift = $this->emp_shift_check_process($emp_id, $shift_id, $schedule_id, $date);
			$schedule  = $this->get_emp_schedule(!empty($emp_shift->schedule_id) ? $emp_shift->schedule_id : $schedule_id);

			$ot_start_time = !empty($schedule[0]['ot_start']) ? $schedule[0]['ot_start'] : '17:00:00';
			$late_start_time = !empty($schedule[0]['late_start']) ? $schedule[0]['late_start'] : '09:15:00';
			$tiffin_break_end1 = !empty($schedule[0]['tiffin_break_end1']) ? $schedule[0]['tiffin_break_end1'] : '00:00:00';
			$tiffin_minute = !empty($schedule[0]['tiffin_minute']) ? (int)$schedule[0]['tiffin_minute'] : 0;
			$tiffin_break_time2 = !empty($schedule[0]['tiffin_break_time2']) ? $schedule[0]['tiffin_break_time2'] : '00:00:00';
			$tiffin_minute2 = !empty($schedule[0]['tiffin_minute2']) ? (int)$schedule[0]['tiffin_minute2'] : 0;
			$lunch_in_time = !empty($schedule[0]['lunch_in_time']) ? $schedule[0]['lunch_in_time'] : '13:00:00';
			$lunch_minute = !empty($schedule[0]['lunch_minute']) ? (int)$schedule[0]['lunch_minute'] : 0;
			$ot_last_hour = !empty($schedule[0]['ot_last_hour']) ? (int)$schedule[0]['ot_last_hour'] : 15;

			$weekend = $this->check_weekend($emp_id, $date);
			$holiday = $this->check_holiday($emp_id, $date);
			$is_weekend_holiday = ($date == $weekend || $weekend === true || $date == $holiday || $holiday === true);

			// Present status
			if ($is_weekend_holiday) {
				$present_status = ($date == $holiday || $holiday === true) ? 'H' : 'W';
			} else {
				if ($final_in != '00:00:00' && $final_out != '00:00:00' && $final_in != $final_out) {
					$present_status = 'P';
				} elseif ($final_in != '00:00:00' || $final_out != '00:00:00') {
					$present_status = 'P(Error)';
				} else {
					$present_status = 'A';
				}
			}

			// Deductions & early exit
			$deduction_hour = 0;
			$early_exit = 0;
			if ($final_in != '00:00:00' && $final_out != '00:00:00' && $final_in != $final_out) {
				$deduction_hour = 0;
				$early_exit = 0;
			} elseif ($final_in != '00:00:00' || $final_out != '00:00:00') {
				$deduction_hour = 4;
				$early_exit = 1;
			}

			// Late status
			$late_status = 0;
			if (!$is_weekend_holiday && $final_in != '00:00:00' && strtotime($final_in) > strtotime($late_start_time)) {
				$late_status = 1;
			}

			// OT Calculation (capped at max 16 hours per day)
			$tot_hour = 0;
			$ot_hour = 0;
			$eot_hour = 0;
			$ot_eot_4pm = 0;
			$ot_eot_12am = 0;

			$is_friday = (strtolower(date('l', strtotime($date))) === 'friday');
			if (!($ot_entitle == 1 && $com_ot_entitle == 1) && $final_in != '00:00:00' && $final_out != '00:00:00' && $final_in != $final_out) {
				if ($is_friday || $is_weekend_holiday) {
					$start_dt = strtotime("$date $final_in");
					$end_dt   = strtotime("$date $final_out");
					if ($end_dt < $start_dt) {
						$end_dt = strtotime("+1 day", $end_dt);
					}
					$minute = round(($end_dt - $start_dt) / 60);
					if ($final_out > $lunch_in_time && $lunch_minute != 0) {
						$minute -= $lunch_minute;
					}
					if ($final_out > $tiffin_break_end1 && $tiffin_minute != 0) {
						$minute -= $tiffin_minute;
					}
					if ($final_out > $tiffin_break_time2 && $tiffin_minute2 != 0) {
						$minute -= $tiffin_minute2;
					}
					if ($minute < 0) $minute = 0;

					$eot_hour = floor($minute / 60);
					if (!empty($ot_last_hour) && ($minute % 60) >= $ot_last_hour) {
						$eot_hour += 1;
					}
					// Per day maximum OT limit: Friday and off days (weekend/holiday) full duty counted as OT, capped at max 24 hours
					$max_cap = 24;
					if ($eot_hour > $max_cap) {
						$eot_hour = $max_cap;
					}
					$tot_hour = $eot_hour;
					$ot_hour = 0;
					$ot_eot_4pm  = min($eot_hour, 2);
					$ot_eot_12am = min($eot_hour, 5);
				} else {
					$ot_start_dt = strtotime("$date $ot_start_time");
					$out_dt      = strtotime("$date $final_out");
					if ($out_dt < $ot_start_dt) {
						$out_dt = strtotime("+1 day", $out_dt);
					}
					if ($out_dt > $ot_start_dt) {
						$minute = round(($out_dt - $ot_start_dt) / 60);
						if ($final_out > $tiffin_break_end1 && $tiffin_minute != 0) {
							$minute = ($minute > $tiffin_minute) ? ($minute - $tiffin_minute) : 0;
						}
						if ($final_out > $tiffin_break_time2 && $tiffin_minute2 != 0) {
							$minute = ($minute > $tiffin_minute2) ? ($minute - $tiffin_minute2) : 0;
						}
						$calc = floor($minute / 60);
						if (($minute % 60) >= $ot_last_hour) {
							$calc += 1;
						}
						if ($calc > 2) {
							$ot_hour  = 2;
							$eot_hour = $calc - 2;
						} else {
							$ot_hour  = $calc;
							$eot_hour = 0;
						}
						if ($eot_hour > 14) {
							$eot_hour = 14;
						}
						$tot_hour = $ot_hour + $eot_hour;
						$ot_eot_4pm  = min($eot_hour, 2);
						$ot_eot_12am = min($eot_hour, 5);
					}
				}
			}

			$update_data = array(
				'in_time'        => $final_in,
				'out_time'       => $final_out,
				'present_status' => $present_status,
				'deduction_hour' => $deduction_hour,
				'early_exit'     => $early_exit,
				'late_status'    => $late_status,
				'ot'             => $ot_hour,
				'eot'            => $eot_hour,
				'tot'            => $tot_hour,
				'ot_eot_4pm'     => $ot_eot_4pm,
				'ot_eot_12am'    => $ot_eot_12am
			);

			if (!empty($shift_log)) {
				$this->db->where('emp_id', $emp_id)
						 ->where('shift_log_date', $date)
						 ->update('pr_emp_shift_log', $update_data);
			} else {
				$update_data['emp_id'] = $emp_id;
				$update_data['shift_log_date'] = $date;
				$update_data['unit_id'] = $unit_id;
				$update_data['shift_id'] = $shift_id;
				$update_data['schedule_id'] = $schedule_id;
				$this->db->insert('pr_emp_shift_log', $update_data);
			}
		}

		// Sync to Daily OT Approval if table exists
		try {
			$this->load->model('Ot_approval_model');
			$this->Ot_approval_model->generate_or_sync_daily_ot($date, $date, $unit_id);
		} catch (Exception $e) {
			log_message('error', 'Daily OT sync error in manual entry: ' . $e->getMessage());
		}
	}

	function check_resign($id, $att_date)
	{
		$this->db->select('emp_id,resign_date');
		$this->db->where('emp_id',$id);
		$this->db->where('resign_date <',$att_date);
		$query = $this->db->get('pr_emp_resign_history');
		if($query->num_rows() == 0)
		return true;
		else
		return false;
	}

	function check_left($id, $att_date)
	{
		$this->db->select('emp_id,left_date');
		$this->db->where('emp_id',$id);
		$this->db->where('left_date <',$att_date);
		$query = $this->db->get('pr_emp_left_history');
		//echo $this->db->last_query();
		if($query->num_rows() == 0)
		return true;
		else
		return false;
	}

	function check_weekend($emp_id, $att_date, $com_weekend = null)
	{
		if (empty($com_weekend)) {
			$emp_info = $this->db->select("weekend")->where("emp_id", $emp_id)->get("pr_emp_com_info")->row();
			if (!empty($emp_info) && !empty($emp_info->weekend)) {
				$com_weekend = $emp_info->weekend;
			}
		}

		$emp_weekend = !empty($com_weekend) ? strtolower(trim($com_weekend)) : 'friday';
		$weekends    = array_map('trim', explode(',', $emp_weekend));
		$day_of_week = strtolower(date('l', strtotime($att_date)));

		// If this day matches employee's weekend from pr_emp_com_info
		if (in_array($day_of_week, $weekends)) {
			return true;
		}

		// Friday is NOT weekend if employee's assigned weekend is NOT Friday
		if ($day_of_week === 'friday' && !in_array('friday', $weekends)) {
			return false;
		}

		// Check replacement / manual work off from attn_work_off
		$this->db->select("emp_id");
		$this->db->from("attn_work_off");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("work_off_date", $att_date);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		}

		return false;
	}

	function check_holiday($id, $att_date)
	{
		$this->db->select("emp_id");
		$this->db->from("attn_holyday_off");
		$this->db->where("emp_id", $id);
		$this->db->where("'$att_date' BETWEEN from_date AND to_date");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return true;
		}
		
		$gov = $this->db->where('date', $att_date)->get('pr_gov_holiday');
		if ($gov->num_rows() > 0) {
			return true;
		}
		return false;
	}

    function leave_chech($process_date, $emp_id)
    {
        $this->db->where("(leave_start <= '$process_date' AND leave_end >= '$process_date')");
        $this->db->where("emp_id", $emp_id);
        $this->db->where("(status = 'approved' OR status IS NULL)");
        $query = $this->db->get("pr_leave_trans");

        if($query->num_rows() > 0) {
        	return true;
        } else {
            return false;
        }
    }

    function od_check($process_date, $emp_id)
    {
        if (!$this->db->table_exists('pr_emp_od_dates')) {
            return false;
        }
        $this->db->where("od_date", $process_date);
        $this->db->where("emp_id", $emp_id);
        $this->db->where_in("status", array("approved", "pending"));
        $query = $this->db->get("pr_emp_od_dates");
        return ($query->num_rows() > 0);
    }

    function check_bridge_absent($emp_id, $date)
    {
        // 1. Check backward: find the working day immediately before the weekend (skipping consecutive weekends)
        $prev_date = date('Y-m-d', strtotime("$date - 1 days"));
        for ($i = 0; $i < 7; $i++) {
            if ($this->check_weekend($emp_id, $prev_date)) {
                $prev_date = date('Y-m-d', strtotime("$prev_date - 1 days"));
                continue;
            }
            $log = $this->db->select('present_status, in_time, out_time')
                            ->where('emp_id', $emp_id)
                            ->where('shift_log_date', $prev_date)
                            ->get('pr_emp_shift_log')
                            ->row();

            if (!empty($log)) {
                $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
                if (!$has_punch && strtoupper(trim($log->present_status)) === 'A') {
                    // Preceding working day was absent without punch -> Rule 3 triggers absent!
                    return true;
                }
            }
            break;
        }

        // 2. Check forward: find the working day immediately after the weekend (skipping consecutive weekends)
        $next_date = date('Y-m-d', strtotime("$date + 1 days"));
        for ($i = 0; $i < 7; $i++) {
            if ($this->check_weekend($emp_id, $next_date)) {
                $next_date = date('Y-m-d', strtotime("$next_date + 1 days"));
                continue;
            }
            $log = $this->db->select('present_status, in_time, out_time')
                            ->where('emp_id', $emp_id)
                            ->where('shift_log_date', $next_date)
                            ->get('pr_emp_shift_log')
                            ->row();

            if (!empty($log)) {
                $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
                if (!$has_punch && strtoupper(trim($log->present_status)) === 'A') {
                    // Succeeding working day is absent without punch -> Rule 4 triggers absent!
                    return true;
                }
            }
            break;
        }

        return false;
    }


    function is_next_day_absent($date, $emp_id)
    {
        $next_date = date('Y-m-d', strtotime("$date + 1 days"));
        for ($i = 0; $i < 15; $i++) {
            $log = $this->db->select('present_status, in_time, out_time')
                            ->where('emp_id', $emp_id)
                            ->where('shift_log_date', $next_date)
                            ->get('pr_emp_shift_log')
                            ->row();
            if (!empty($log)) {
                $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
                if ($has_punch) {
                    return false;
                }
                $status = strtoupper(trim($log->present_status));
                if ($status === 'A') {
                    return true;
                }
                $is_w = $this->check_weekend($emp_id, $next_date);
                $is_h = $this->check_holiday($emp_id, $next_date);
                if ($status === 'W' || $status === 'H' || $status === 'L' || $is_w || $is_h) {
                    $next_date = date('Y-m-d', strtotime("$next_date + 1 days"));
                    continue;
                }
                return false;
            } else {
                break;
            }
        }
        return false;
    }

    function is_weekend_holiday_between_leave_and_absent($emp_id, $date)
    {
        // 1. Backward check: Must be preceded by an approved Leave (allowing intervening off-days)
        $has_prev_leave = false;
        $prev_date = date('Y-m-d', strtotime("$date - 1 days"));
        for ($i = 0; $i < 15; $i++) {
            if ($this->leave_chech($prev_date, $emp_id)) {
                $has_prev_leave = true;
                break;
            }
            $log = $this->db->select('in_time, out_time, present_status')
                            ->where('emp_id', $emp_id)
                            ->where('shift_log_date', $prev_date)
                            ->get('pr_emp_shift_log')
                            ->row();
            $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
            if ($has_punch) {
                break;
            }
            $is_w = $this->check_weekend($emp_id, $prev_date);
            $is_h = $this->check_holiday($emp_id, $prev_date);
            if ($is_w || $is_h || (!empty($log) && in_array(strtoupper(trim($log->present_status)), array('W', 'H', 'A')))) {
                $prev_date = date('Y-m-d', strtotime("$prev_date - 1 days"));
                continue;
            }
            break;
        }

        if (!$has_prev_leave) {
            return false;
        }

        // 2. Forward check: Must be followed by Absent ('A') (allowing intervening off-days)
        $has_next_absent = false;
        $next_date = date('Y-m-d', strtotime("$date + 1 days"));
        for ($i = 0; $i < 15; $i++) {
            $log = $this->db->select('in_time, out_time, present_status')
                            ->where('emp_id', $emp_id)
                            ->where('shift_log_date', $next_date)
                            ->get('pr_emp_shift_log')
                            ->row();
            if (empty($log)) {
                break;
            }
            $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
            if ($has_punch) {
                break;
            }
            $status = strtoupper(trim($log->present_status));
            if ($status === 'A') {
                $has_next_absent = true;
                break;
            }
            $is_w = $this->check_weekend($emp_id, $next_date);
            $is_h = $this->check_holiday($emp_id, $next_date);
            if ($is_w || $is_h || $status === 'W' || $status === 'H') {
                $next_date = date('Y-m-d', strtotime("$next_date + 1 days"));
                continue;
            }
            break;
        }

        return ($has_prev_leave && $has_next_absent);
    }

    function forfeit_consecutive_preceding_leaves($emp_id, $absent_date)
    {
        $intervening_offdays = array();
        $preceding_leaves    = array();
        $curr_date = date('Y-m-d', strtotime("$absent_date - 1 days"));

        // Step 1: Collect intervening weekends/holidays immediately before this absence
        for ($i = 0; $i < 15; $i++) {
            if ($this->leave_chech($curr_date, $emp_id)) {
                break; // Hit leave directly
            }
            $log = $this->db->select('in_time, out_time, present_status')
                            ->where('emp_id', $emp_id)
                            ->where('shift_log_date', $curr_date)
                            ->get('pr_emp_shift_log')
                            ->row();
            $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
            if ($has_punch) {
                break;
            }
            $is_w = $this->check_weekend($emp_id, $curr_date);
            $is_h = $this->check_holiday($emp_id, $curr_date);
            if ($is_w || $is_h || (!empty($log) && in_array(strtoupper(trim($log->present_status)), array('W', 'H', 'A')))) {
                $intervening_offdays[] = $curr_date;
                $curr_date = date('Y-m-d', strtotime("$curr_date - 1 days"));
                continue;
            }
            break;
        }

        // Step 2: Collect preceding consecutive leaves (and any offdays between consecutive leaves)
        for ($i = 0; $i < 30; $i++) {
            if ($this->leave_chech($curr_date, $emp_id)) {
                $preceding_leaves[] = $curr_date;
                $curr_date = date('Y-m-d', strtotime("$curr_date - 1 days"));
                continue;
            }
            // If weekend/holiday between multiple leaves (e.g. Leave -> Weekend -> Leave)
            $is_w = $this->check_weekend($emp_id, $curr_date);
            $is_h = $this->check_holiday($emp_id, $curr_date);
            if ($is_w || $is_h) {
                $prev_has_leave = false;
                $check_date = date('Y-m-d', strtotime("$curr_date - 1 days"));
                for ($k = 0; $k < 5; $k++) {
                    if ($this->leave_chech($check_date, $emp_id)) {
                        $prev_has_leave = true;
                        break;
                    }
                    if ($this->check_weekend($emp_id, $check_date) || $this->check_holiday($emp_id, $check_date)) {
                        $check_date = date('Y-m-d', strtotime("$check_date - 1 days"));
                        continue;
                    }
                    break;
                }
                if ($prev_has_leave) {
                    $intervening_offdays[] = $curr_date;
                    $curr_date = date('Y-m-d', strtotime("$curr_date - 1 days"));
                    continue;
                }
            }
            break;
        }

        // CRITICAL RULE:
        // Only forfeit if at least one approved leave preceded this absence!
        // If an employee had NO leave (e.g. Present -> Weekend -> Absent), normal weekends/holidays are preserved!
        if (!empty($preceding_leaves)) {
            $dates_to_forfeit = array_unique(array_merge($intervening_offdays, $preceding_leaves));
            foreach ($dates_to_forfeit as $forfeit_date) {
                $this->db->where('emp_id', $emp_id)
                         ->where('shift_log_date', $forfeit_date)
                         ->update('pr_emp_shift_log', array(
                             'present_status' => 'A',
                             'in_time'        => '00:00:00',
                             'out_time'       => '00:00:00',
                             'tot'            => 0,
                             'ot'             => 0,
                             'eot'            => 0,
                             'late_status'    => 0,
                             'deduction_hour' => 0,
                             'weekly_allo'    => 0,
                             'holiday_allo'   => 0
                         ));
            }
        }
    }

    function restore_consecutive_preceding_leaves($emp_id, $present_date)
    {
        $intervening_offdays = array();
        $preceding_leaves    = array();
        $curr_date = date('Y-m-d', strtotime("$present_date - 1 days"));

        // Collect intervening offdays
        for ($i = 0; $i < 15; $i++) {
            if ($this->leave_chech($curr_date, $emp_id)) {
                break;
            }
            $is_w = $this->check_weekend($emp_id, $curr_date);
            $is_h = $this->check_holiday($emp_id, $curr_date);
            if ($is_w || $is_h) {
                $intervening_offdays[] = array('date' => $curr_date, 'type' => ($is_h ? 'H' : 'W'));
                $curr_date = date('Y-m-d', strtotime("$curr_date - 1 days"));
                continue;
            }
            break;
        }

        // Collect preceding leaves
        for ($i = 0; $i < 30; $i++) {
            if ($this->leave_chech($curr_date, $emp_id)) {
                $preceding_leaves[] = $curr_date;
                $curr_date = date('Y-m-d', strtotime("$curr_date - 1 days"));
                continue;
            }
            $is_w = $this->check_weekend($emp_id, $curr_date);
            $is_h = $this->check_holiday($emp_id, $curr_date);
            if ($is_w || $is_h) {
                $intervening_offdays[] = array('date' => $curr_date, 'type' => ($is_h ? 'H' : 'W'));
                $curr_date = date('Y-m-d', strtotime("$curr_date - 1 days"));
                continue;
            }
            break;
        }

        if (!empty($preceding_leaves)) {
            // Restore leaves to 'L'
            foreach ($preceding_leaves as $l_date) {
                $this->db->where('emp_id', $emp_id)
                         ->where('shift_log_date', $l_date)
                         ->where('present_status', 'A')
                         ->update('pr_emp_shift_log', array(
                             'present_status' => 'L'
                         ));
            }
            // Restore intervening offdays to 'W' or 'H'
            foreach ($intervening_offdays as $off) {
                $this->db->where('emp_id', $emp_id)
                         ->where('shift_log_date', $off['date'])
                         ->where('present_status', 'A')
                         ->update('pr_emp_shift_log', array(
                             'present_status' => $off['type']
                         ));
            }
        }
    }

    function bridge_consecutive_subsequent_weekends_holidays($emp_id, $absent_date)
    {
        // Rule 3: If an employee is Absent immediately before a weekend, mark relevant consecutive weekend days as Absent
        $next_date = date('Y-m-d', strtotime("$absent_date + 1 days"));
        for ($i = 0; $i < 7; $i++) {
            if (!$this->check_weekend($emp_id, $next_date)) {
                break;
            }
            // Safeguards (Rule 7): Do not overwrite Present, approved Leave, Holiday, or manual adjustments
            if ($this->leave_chech($next_date, $emp_id) || $this->check_holiday($emp_id, $next_date)) {
                break;
            }
            $log = $this->db->where('emp_id', $emp_id)->where('shift_log_date', $next_date)->get('pr_emp_shift_log')->row();
            if (!empty($log)) {
                $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
                if ($has_punch || in_array(strtoupper(trim($log->present_status)), array('P', 'L', 'H'))) {
                    break;
                }
                $this->db->where('emp_id', $emp_id)
                         ->where('shift_log_date', $next_date)
                         ->update('pr_emp_shift_log', array(
                             'present_status' => 'A',
                             'in_time'        => '00:00:00',
                             'out_time'       => '00:00:00',
                             'tot'            => 0,
                             'ot'             => 0,
                             'eot'            => 0,
                             'late_status'    => 0,
                             'deduction_hour' => 0,
                             'weekly_allo'    => 0,
                             'holiday_allo'   => 0
                         ));
            } else {
                $emp_com = $this->db->select('emp_shift')->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
                $shift_id = !empty($emp_com) ? $emp_com->emp_shift : 1;
                $sh_row = $this->db->select('schedule_id')->where('id', $shift_id)->get('pr_emp_shift')->row();
                $schedule_id = !empty($sh_row) ? $sh_row->schedule_id : 1;

                $this->db->insert('pr_emp_shift_log', array(
                    'emp_id'         => $emp_id,
                    'shift_id'       => $shift_id,
                    'schedule_id'    => $schedule_id,
                    'shift_log_date' => $next_date,
                    'present_status' => 'A',
                    'in_time'        => '00:00:00',
                    'out_time'       => '00:00:00',
                    'tot'            => 0,
                    'ot'             => 0,
                    'eot'            => 0,
                    'late_status'    => 0,
                    'deduction_hour' => 0,
                    'weekly_allo'    => 0,
                    'holiday_allo'   => 0,
                    'modify_eot'     => 0
                ));
            }
            $next_date = date('Y-m-d', strtotime("$next_date + 1 days"));
        }

        // Rule 4: If an employee is Absent immediately after a weekend, mark relevant consecutive weekend days as Absent
        $prev_date = date('Y-m-d', strtotime("$absent_date - 1 days"));
        for ($i = 0; $i < 7; $i++) {
            if (!$this->check_weekend($emp_id, $prev_date)) {
                break;
            }
            // Safeguards (Rule 7): Do not overwrite Present, approved Leave, Holiday, or manual adjustments
            if ($this->leave_chech($prev_date, $emp_id) || $this->check_holiday($emp_id, $prev_date)) {
                break;
            }
            $log = $this->db->where('emp_id', $emp_id)->where('shift_log_date', $prev_date)->get('pr_emp_shift_log')->row();
            if (!empty($log)) {
                $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
                if ($has_punch || in_array(strtoupper(trim($log->present_status)), array('P', 'L', 'H'))) {
                    break;
                }
                $this->db->where('emp_id', $emp_id)
                         ->where('shift_log_date', $prev_date)
                         ->update('pr_emp_shift_log', array(
                             'present_status' => 'A',
                             'in_time'        => '00:00:00',
                             'out_time'       => '00:00:00',
                             'tot'            => 0,
                             'ot'             => 0,
                             'eot'            => 0,
                             'late_status'    => 0,
                             'deduction_hour' => 0,
                             'weekly_allo'    => 0,
                             'holiday_allo'   => 0
                         ));
            } else {
                $emp_com = $this->db->select('emp_shift')->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
                $shift_id = !empty($emp_com) ? $emp_com->emp_shift : 1;
                $sh_row = $this->db->select('schedule_id')->where('id', $shift_id)->get('pr_emp_shift')->row();
                $schedule_id = !empty($sh_row) ? $sh_row->schedule_id : 1;

                $this->db->insert('pr_emp_shift_log', array(
                    'emp_id'         => $emp_id,
                    'shift_id'       => $shift_id,
                    'schedule_id'    => $schedule_id,
                    'shift_log_date' => $prev_date,
                    'present_status' => 'A',
                    'in_time'        => '00:00:00',
                    'out_time'       => '00:00:00',
                    'tot'            => 0,
                    'ot'             => 0,
                    'eot'            => 0,
                    'late_status'    => 0,
                    'deduction_hour' => 0,
                    'weekly_allo'    => 0,
                    'holiday_allo'   => 0,
                    'modify_eot'     => 0
                ));
            }
            $prev_date = date('Y-m-d', strtotime("$prev_date - 1 days"));
        }
    }

    function unbridge_consecutive_subsequent_weekends_holidays($emp_id, $present_date)
    {
        // When an employee becomes Present on present_date, check backward connected weekends
        $prev_date = date('Y-m-d', strtotime("$present_date - 1 days"));
        for ($i = 0; $i < 7; $i++) {
            if (!$this->check_weekend($emp_id, $prev_date)) {
                break;
            }
            // If the other side of this weekend is NOT absent, restore weekend to 'W'
            if (!$this->check_bridge_absent($emp_id, $prev_date)) {
                $log = $this->db->where('emp_id', $emp_id)->where('shift_log_date', $prev_date)->get('pr_emp_shift_log')->row();
                if (!empty($log) && $log->present_status === 'A') {
                    $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
                    if (!$has_punch) {
                        $this->db->where('emp_id', $emp_id)
                                 ->where('shift_log_date', $prev_date)
                                 ->update('pr_emp_shift_log', array('present_status' => 'W'));
                    }
                }
            }
            $prev_date = date('Y-m-d', strtotime("$prev_date - 1 days"));
        }

        // When an employee becomes Present on present_date, check forward connected weekends
        $next_date = date('Y-m-d', strtotime("$present_date + 1 days"));
        for ($i = 0; $i < 7; $i++) {
            if (!$this->check_weekend($emp_id, $next_date)) {
                break;
            }
            // If the other side of this weekend is NOT absent, restore weekend to 'W'
            if (!$this->check_bridge_absent($emp_id, $next_date)) {
                $log = $this->db->where('emp_id', $emp_id)->where('shift_log_date', $next_date)->get('pr_emp_shift_log')->row();
                if (!empty($log) && $log->present_status === 'A') {
                    $has_punch = (!empty($log->in_time) && $log->in_time != '00:00:00') || (!empty($log->out_time) && $log->out_time != '00:00:00');
                    if (!$has_punch) {
                        $this->db->where('emp_id', $emp_id)
                                 ->where('shift_log_date', $next_date)
                                 ->update('pr_emp_shift_log', array('present_status' => 'W'));
                    }
                }
            }
            $next_date = date('Y-m-d', strtotime("$next_date + 1 days"));
        }
    }

    function check_single_day_sl_cl($date, $emp_id)
    {
        return $this->leave_chech($date, $emp_id);
    }

	function get_night_allowance_rules($process_date, $unit_id, $desig_id){

		$this->db->select("anr.night_time");
		$this->db->from('emp_designation as ed');
		$this->db->join('allowance_night_rules as anr', 'ed.night_al_id = anr.id', 'left');

		$this->db->where("anr.unit_id", $unit_id);
		$this->db->where("ed.id", $desig_id);
		$query = $this->db->get()->row();

        $time = '';
        if (!empty($query) && strtotime($query->night_time) < strtotime('12:00:00')){
        	$process_date = "$process_date $query->night_time";
            $time = date('Y-m-d H:i:s', strtotime($process_date .' + 1 days'));
        } else if (!empty($query)) {
        	$time = "$process_date $query->night_time";
        }
		return $time;
	}

	// employee shift check from pr_emp_shift_log table
	function emp_shift_check_process($emp_id, $shift_id, $schedule_id, $process_date){
		$this->db->select("pr_emp_shift_log.shift_id, pr_emp_shift_log.schedule_id, pr_emp_shift.shift_name");
		$this->db->from("pr_emp_shift_log");
		$this->db->join("pr_emp_shift", "pr_emp_shift.id = pr_emp_shift_log.shift_id", "left");
		$this->db->where("pr_emp_shift_log.emp_id", $emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $process_date);
		$query = $this->db->get();
		$data = new stdClass();
		if($query->num_rows() > 0 ){
			$row = 		$query->row();
			$data->shift_id    = $row->shift_id;
			$data->schedule_id = $row->schedule_id;
			$data->shift_name  = $row->shift_name;
			return $data;
		} else {
			$infos = array(
				'emp_id' 		 => $emp_id,
				'shift_id' 		 => $shift_id,
				'schedule_id' 	 => $schedule_id,
				'shift_log_date' => $process_date,
				'modify_eot'     => 0,
			);
			$this->db->insert("pr_emp_shift_log", $infos);

			$data->shift_id    = $shift_id;
			$data->schedule_id = $schedule_id;
			$shift_row = $this->db->select("shift_name")->where("id", $shift_id)->get("pr_emp_shift")->row();
			$data->shift_name  = !empty($shift_row) ? $shift_row->shift_name : '';
			return $data;
		}
	}

	/**
	 * Get the actual shift for an employee on a given (previous) date from pr_rmp_shift_log.
	 * Joins with pr_emp_shift to retrieve schedule_id and shift_name.
	 *
	 * @param  string $emp_id
	 * @param  string $process_date  Y-m-d
	 * @return object|null  Object with shift_id, schedule_id, shift_name — or null if not found
	 */
	function get_shift_from_rmp_log($emp_id, $process_date)
	{
		$this->db->select('es.id as shift_id, es.schedule_id, es.shift_name');
		$this->db->from('pr_emp_shift_log rsl');
		$this->db->join('pr_emp_shift es', 'es.id = rsl.shift_id', 'inner');
		$this->db->where('rsl.emp_id', $emp_id);
		$this->db->where('rsl.shift_log_date', $process_date);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$data = new stdClass();
			$data->shift_id    = $row->shift_id;
			$data->schedule_id = $row->schedule_id;
			$data->shift_name  = $row->shift_name;
			return $data;
		}
		return null;
	}

	function get_emp_schedule($schedule_id){
		$this->db->where("id", $schedule_id);
		$query = $this->db->get("pr_emp_shift_schedule");
		return $query->result_array();
	}

	// delete attendance log after resign/left or before joining record
	function attn_delete_for_eligibility_failed($emp_id, $att_date)
	{
		$this->db->select('emp_id');
		$this->db->where('emp_id',$emp_id);
		$this->db->where('shift_log_date',$att_date);
		$query = $this->db->get('pr_emp_shift_log');
		if($query->num_rows() > 0 )
		{
			$this->db->where('emp_id',$emp_id);
			$this->db->where('shift_log_date',$att_date);
			$this->db->delete('pr_emp_shift_log');
		}
	}

	function attn_month_table_check($table) {
		if (!$this->db->table_exists($table)){
			$this->db->query('CREATE TABLE IF NOT EXISTS `'.$table.'`(
			     `att_id` int(11) NOT NULL AUTO_INCREMENT,
			     `device_id` int(11) NOT NULL,
			     `proxi_id` varchar(30) NOT NULL,
			     `date_time` datetime NOT NULL,
			     `monitor_con` int(2) DEFAULT 1,
			      PRIMARY KEY (`att_id`),
				  KEY `device_id` (`device_id`,`proxi_id`,`date_time`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;'
			);
		}
		return true;
	}





	// old code
	function create_att_month_table($att_table)
	{

		$att_table = date('Y-m-d', strtotime($att_table ." + 1 days"));
		$year  = trim(substr($att_table,0,4));
		$month = trim(substr($att_table,5,2));
		$day   = trim(substr($att_table,8,2));

		$att_table = "att_".$year."_".$month;
		if (!$this->db->table_exists($att_table)){
			$this->db->query('CREATE TABLE IF NOT EXISTS `'.$att_table.'`(
			     `att_id` int(11) NOT NULL AUTO_INCREMENT,
			     `device_id` int(11) NOT NULL,
			     `proxi_id` varchar(30) NOT NULL,
			     `date_time` datetime NOT NULL,
			     `monitor_con` int(2) DEFAULT 1,
			      PRIMARY KEY (`att_id`),
				  KEY `device_id` (`device_id`,`proxi_id`,`date_time`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;'
			);
		}
		return true;
	}

	public function four_hour_ot_eot($emp_id, $date)
  	 {
   		$table = "temp_$emp_id";
		$table = strtolower($table);


		$this->db->select("pr_emp_com_info.ot_entitle");
		$this->db->from("pr_emp_com_info");
		$this->db->where("pr_emp_com_info.emp_id = '$emp_id'");
		$query1 = $this->db->get();
		$row1 = $query1->row();
		$ot_status  = $row1->ot_entitle;

		$in_time = '';
		$out_time = '';

		$emp_shift = $this->emp_shift_check($emp_id, $date);

		$this->db->select("shift_id");
		$this->db->from("pr_emp_shift_schedule");
		$this->db->where("sh_type", $emp_shift);
		$query = $this->db->get();
		$row = $query->row();

		$schedule = $this->schedule_check($emp_shift);
		// echo "<pre>"; print_r($schedule); exit();
		$start_time		=  $schedule[0]["in_start"];
		$late_time 		=  $schedule[0]["late_start"];
		$end_time   	=  $schedule[0]["in_end"];
		$out_start_time	=  $schedule[0]["out_start"];
		$ot_start_time	=  $schedule[0]["ot_start"];
		$out_end_time	=  $schedule[0]["out_end"];

		$ot_hour = 0;

		$hour = trim(substr($out_start_time,0,2));
		$minute = trim(substr($out_start_time,3,2));
		$sec = trim(substr($out_start_time,6,2));

		$am_pm = date("A", mktime($hour, $minute, $sec, 0, 0, 0));
		$in_date = $date;
		$ot_start_time = "$in_date $ot_start_time";
		if($am_pm == "AM")
		{
			//echo $am_pm;
			$now = strtotime($in_date);
			$datestr = strtotime("+1 day",$now);
			$in_date = date("Y-m-d", $datestr);
			$in_date = $in_date;
		}
		else
		{
			$in_date = $date;
		}

		$hour = trim(substr($out_end_time,0,2));
		$minute = trim(substr($out_end_time,3,2));
		$sec = trim(substr($out_end_time,6,2));
		$am_pm = date("A", mktime($hour, $minute, $sec, 0, 0, 0));

		$out_date = $date;
		if($am_pm == "AM")
		{
			//echo $am_pm;
			$now = strtotime($out_date);
			$datestr = strtotime("+1 day",$now);
			$out_date = date("Y-m-d", $datestr);
			$out_date = $out_date;
		}
		else
		{
			$out_date = $date;
		}

		$in_time  = $this->in_time_for_four_hur($date, $start_time, $end_time, $table);

		$out_start_time = "$in_date $out_start_time";
		$out_end_time = "$out_date $out_end_time";

		$out_time = $this->out_time_for_four_hur($out_start_time, $out_end_time, $table);

	    if($ot_status == '1'){
			$work_ot_hour = 0;
			$work_eot_hour = 0;
		}else{
		 	//$out_time_x=strtotime($values[$emp_id]["out_time"][$k]);
		 	$out_time_8pm=strtotime('20:00:00');


			//$elapsed = $out_time_x - strtotime($values[$emp_id]["in_time"][$k]);
			$in_time=strtotime($in_time);
			$out_time=strtotime($out_time);
			$elapsed = $out_time - $in_time;
			$elapsed_hour = ($elapsed / 3600);

			if($elapsed_hour > 9){
				//for ramadan (2018-05-18 to 2018-06-17)
				if($date >= '2018-05-18' AND $date <= '2018-06-17'){
					$work_hour = $elapsed_hour - 8.5;
				}
				else{
					$work_hour = $elapsed_hour - 9;
				}
				if($work_hour >= 2){
					$work_ot_hour = 2;//OT=2 Hour
					if ($out_time>$out_time_8pm AND ($date >= '2018-05-18' AND $date <= '2018-06-17')) {//zuel
						$work_eot_hour = floor($work_hour - 3);//(OT=2)+(Iftar=1)=3 Hour
					}
					else{
						//$work_eot_hour = floor($work_hour - 2);//OT=2 Hour
						$work_eot_hour = (int)$work_hour - 2;
					}
				}
				else{
					//$work_hour = $work_hour;//zuel 10-06-18
					$work_ot_hour = (int)($work_hour);
					$work_eot_hour = 0;
				}
			}
			else{
				$work_ot_hour = 0;
				$work_eot_hour = 0;
			}
		}

		$ot_hour = $ot_hour + $work_ot_hour;


		$query = $this->db->select('month_of_ot_eot')->where('emp_id',$emp_id)->where('month_of_ot_eot', $date)->get('four_hour_ot_eot');

		if($query->num_rows() > 0){
			$this->db->where('emp_id',$emp_id);
			$this->db->where('month_of_ot_eot',$date);
			$this->db->set('work_ot_hour',$work_ot_hour);
			$this->db->set('work_eot_hour',$work_eot_hour);
			$this->db->update('four_hour_ot_eot');
		}
		else{
			$data = array(
				'emp_id' 		=> $emp_id,
				'month_of_ot_eot'=> $date,
				'work_ot_hour'	=> $work_ot_hour,
				'work_eot_hour'	=> $work_eot_hour
				);
			$this->db->insert('four_hour_ot_eot', $data);
		}
    }

	function get_no_work_day($emp_id,$att_date)
	{
		$no_work_day = $this->db->where('emp_id',$emp_id)->where('date',$att_date)->get('pd_production_logs')->num_rows();
		if($no_work_day == 0)
		{
			$no_work_day_status = 1;
		}
		else
		{
			$no_work_day_status = 0;
		}
		$data = array(
		"pd_no_work_check" => $no_work_day_status
		);
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date", $att_date);
		$this->db->update("pr_emp_shift_log", $data);
		return;
	}
	function resig_or_left_date($emp_id)
	{
		$this->db->select("left_date");
		$this->db->where('emp_id',$emp_id);
		$query = $this->db->get("pr_emp_left_history");
		$row = $query->row();
		if($query->num_rows() > 0)
		{
			return true;
		}


		$this->db->select("resign_date");
		$this->db->where('emp_id',$emp_id);
		$query = $this->db->get("pr_emp_resign_history");
		$row = $query->row();
		if($query->num_rows() > 0)
		{
			return true;
		}
	}

	function insert_extra_ot_hour($emp_id, $att_date, $extra_ot_hour){
		$extra_ot_hour_old=$extra_ot_hour;
		$ot_status = $this->db->select('ot_entitle')->where('emp_id',$emp_id)->get('pr_emp_com_info')->row()->ot_entitle;


		$night_allwance = $this->db->select('night_allo')->where('emp_id',$emp_id)->where('shift_log_date',$att_date)->get('pr_emp_shift_log')->row()->night_allo;

		//Zuel Ali 17/08/19
		if($night_allwance == "1"){
			$unit_id = $this->db->select('unit_id')->where('emp_id',$emp_id)->get('pr_emp_com_info')->row()->unit_id;

			$night_deduct_hour = $this->db->select('deduct_hour')->where('unit_id',$unit_id)->get('pr_night_rules')->row()->deduct_hour;

			//Zuel Only for Ramadan - 2019-05
			if($att_date >= '2019-05-07' && $att_date <= '2019-06-06' && ($unit_id=='1' || $unit_id=='3')){
				$night_deduct_hour=1;
			}

			//$extra_ot_hour = $extra_ot_hour - $night_deduct_hour; // comment the line 17-04-2022 for ramadan

			// 17-04-2022
			// new code add for ramadan
			$ramadan_month1 = "2022-04-03";
			$ramadan_month2 = "2022-05-02";
			// echo $extra_ot_hour ." = ";
			if($att_date >= $ramadan_month1 and $att_date <= $ramadan_month2 && $unit_id == '2'){
				$extra_ot_hour = $extra_ot_hour;
			} else {
				// $extra_ot_hour = $extra_ot_hour - $night_deduct_hour;
				$extra_ot_hour = $extra_ot_hour - $night_deduct_hour;
			}
			// end ramadan new code 17-04-2022

		}

		if($ot_status == 0){
			if($extra_ot_hour_old>=5){
            	$ot_eot_12am = 5;
	        }else{
	            $ot_eot_12am = $extra_ot_hour;
	        }

			if($extra_ot_hour>=2){
            	$ot_eot_4pm = 2;
	        }else{
	            $ot_eot_4pm = $extra_ot_hour;
	        }

		   $data = array(
					"extra_ot_hour" => $extra_ot_hour,
					"ot_eot_12am" => $ot_eot_12am,
					"ot_eot_4pm" => $ot_eot_4pm
				);
		} else{
		   $data = array(
					"extra_ot_hour" => 0,
					'deduction_hour'=> 0,
					'modify_eot'=> 0,
					"ot_eot_12am" => 0,
					"ot_eot_4pm" => 0
				);
		}

			// echo "<pre>";
			// print_r( $data);

			// echo $extra_ot_hour ." = "; die;

		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date", $att_date);
		$this->db->update("pr_emp_shift_log", $data);
		return true;
	}

	function weekend_holday_eot_calculation($emp_id, $date,$status){
		$holiday_allowance_check = 0;
		$weekly_allowance_check = 0;
		$table = "temp_$emp_id";
		$table = strtolower($table);

		$present_count = 0;
		$absent_count = 0;
		$leave_count = 0;
		$ot_count = 0;
		$late_count = 0;

		$this->db->select("pr_emp_com_info.ot_entitle");
		$this->db->from("pr_emp_com_info");
		$this->db->where("pr_emp_com_info.emp_id = '$emp_id'");
		$query1 = $this->db->get();
		$row1 = $query1->row();
		$ot_status  = $row1->ot_entitle;

		$in_time = '';
		$out_time = '';

		$emp_shift = $this->emp_shift_check($emp_id, $date);

		$schedule = $this->schedule_check($emp_shift);
		//print_r($schedule);
		$start_time		=  $schedule[0]["in_start"];
		$late_time 		=  $schedule[0]["late_start"];
		$end_time   	=  $schedule[0]["in_end"];
		$out_start_time	=  $schedule[0]["out_start"];
		$ot_start_time	=  $schedule[0]["ot_start"];
		$out_end_time	=  $schedule[0]["out_end"];

		$hour = trim(substr($out_start_time,0,2));
		$minute = trim(substr($out_start_time,3,2));
		$sec = trim(substr($out_start_time,6,2));

		$am_pm = date("A", mktime($hour, $minute, $sec, 0, 0, 0));
		$in_date = $date;
		$ot_start_time = "$in_date $ot_start_time";
		if($am_pm == "AM"){
			$now = strtotime($in_date);
			$datestr = strtotime("+1 day",$now);
			$in_date = date("Y-m-d", $datestr);
			$in_date = $in_date;
		}
		else{
			$in_date = $date;
		}

		$hour = trim(substr($out_end_time,0,2));
		$minute = trim(substr($out_end_time,3,2));
		$sec = trim(substr($out_end_time,6,2));
		$am_pm = date("A", mktime($hour, $minute, $sec, 0, 0, 0));

		$out_date = $date;
		if($am_pm == "AM"){
			$now = strtotime($out_date);
			$datestr = strtotime("+1 day",$now);
			$out_date = date("Y-m-d", $datestr);
			$out_date = $out_date;
		}

		$in_time  = $this->time_check_in($date, $start_time, $end_time, $table);
		$in_time_date=  $date." ".$in_time;
		$out_start_time = "$in_date $out_start_time";
		$out_end_time = "$out_date $out_end_time";

		$out_time_date = $this->time_check_out2($out_start_time, $out_end_time, $table);
		$workoff_eot_out_date = trim(substr($out_time_date,0,10));
		$out_time = trim(substr($out_time_date,11,19));

		// echo "<pre>"; print_r($out_time_date ." = ". $out_end_time ." = ". $table); exit();


		if($in_time == '' or $out_time == ''){
			$weekend_holiday_eot_hour = 0;
			if($status == "h"){
				$holiday_allowance_check = 0;
			 	$weekly_allowance_check = 0;
				$present_status = "H";
			}
			if($status == "w"){
				$holiday_allowance_check = 0;
				$weekly_allowance_check = 0;
				$present_status = "W";


			}
		} else {
			$weekend_holiday_eot_hour = $this->hour_difference($in_time_date, $out_time_date, $emp_id, $date);
			$workoff_eot_lunch_deduct_time 	= $this->get_setup_attributes(7);
			$workoff_eot_lunch_deduct_time 	= "$in_date $workoff_eot_lunch_deduct_time";
			$workoff_eot_out_time 			= "$workoff_eot_out_date $out_time";

			if($workoff_eot_lunch_deduct_time <= $workoff_eot_out_time){
				 // for Ramadan
			    if($date >= '2020-04-25' && $date <= '2020-05-24'){
					$workoff_eot_out_time_8pm = "$date 19:00:00";
					if ($workoff_eot_out_time>=$workoff_eot_out_time_8pm){
						// zuel ali 07-06-18
						$weekend_holiday_eot_hour = $weekend_holiday_eot_hour - 2;
					}
					else{
						$weekend_holiday_eot_hour = $weekend_holiday_eot_hour - 1;
					}
				} else{
					$weekend_holiday_eot_hour = $weekend_holiday_eot_hour - 1;
				}
			} else{
				$weekend_holiday_eot_hour = $weekend_holiday_eot_hour;
			}

			//$weekend_holiday_eot_hour = $weekend_holiday_eot_hour;

			//==============Holiday Aloowance======
            $night_allowance = $this->get_night_allowance($date,$out_time,$emp_id);
			if($status == "h"){
				$holiday_allowance_check = 1;
				$night_allowance = 1;
				$weekly_allowance_check = 0;
				$present_status = "H";
			}

			if($status == "w"){
				$holiday_allowance_check = 0;
				$weekly_allowance_check = 1;
				$night_allowance = 1;
				$present_status = "W";
			}
		}

		if($in_time != '' and $out_time != ''){
			$time_diff = (round(abs(strtotime($out_time_date) - strtotime("$in_date 11:50:00pm"))/3600));
			if($out_time >= "23:55:00" || $out_time >= "00:00:01"){
				$night_allowance = $this->get_night_allowance($date,$out_time,$emp_id);
			} else{
				$night_allowance = 0;
		    }
		} else {
			//$tiffin_allowance = 0;
			$night_allowance = 0;
		}

		if($night_allowance == "1"){
			$unit_id = $this->db->select('unit_id')->where('emp_id',$emp_id)->get('pr_emp_com_info')->row()->unit_id;
			$night_deduct_hour = $this->db->select('deduct_hour')->where('unit_id',$unit_id)->get('pr_night_rules')->row()->deduct_hour;

			// extra losig to night hour deduction 02-06-2022
			if ($in_time <= "11:00:00" && $out_time > "17:00:00") {
				$weekend_holiday_eot_hour = $weekend_holiday_eot_hour - $night_deduct_hour;
			} else {
				$weekend_holiday_eot_hour = $weekend_holiday_eot_hour;
			}
		}

		if($status=='w'){
			$ot_eot_12am = 0;
			$ot_eot_4pm = 0;
		}

		if($ot_status == 1){
			$weekend_holiday_eot_hour = 0;

			$data = array(
						'in_time' 			=> $in_time,
						'out_time' 			=> $out_time,
						'ot_hour' 			=> 0,
						'extra_ot_hour' 	=> 0,
						'ot_eot_12am' 		=> 0,
						'ot_eot_4pm' 		=> 0,
						'deduction_hour' 	=> 0,
						'late_status' 		=> 0,
						'night_allo' 		=> $night_allowance,
						'present_status' 	=> $present_status,
						'tiffin_allo' 		=> 0,
						'holiday_allowance'	=> $holiday_allowance_check,
						'weekly_allo'		=> $weekly_allowance_check,
						'modify_eot'		=> 0,
						'deduction_hour'	=> 0
					);
		}
		else {
			$data = array(
						'in_time' 			=> $in_time,
						'out_time' 			=> $out_time,
						'ot_hour' 			=> 0,
						'extra_ot_hour' 	=> $weekend_holiday_eot_hour,
						'ot_eot_12am' 		=> $ot_eot_12am,
						'ot_eot_4pm' 		=> $ot_eot_4pm,
						'deduction_hour' 	=> 0,
						'late_status' 		=> 0,
						'night_allo' 		=> $night_allowance,
						'present_status' 	=> $present_status,
						'tiffin_allo' 		=> 0,
						'holiday_allowance'	=> $holiday_allowance_check,
						'weekly_allo'		=> $weekly_allowance_check
					);
		}

		// echo "<pre>"; print_r($data); die();

		$this->db->where('shift_log_date', $date);
		$this->db->where('emp_id', $emp_id);
		$this->db->update('pr_emp_shift_log', $data);
		return true;
	}

	function hour_difference($start_date_time, $end_date_time, $emp_id, $date){
		$start_date_time= strtotime("$start_date_time");
		$end_date_time 	= strtotime("$end_date_time");
		$elapsed 		= $end_date_time - $start_date_time;
		$elapsed_hour 	= floor($elapsed / 3600);

		$elapsed 		-= 3600 * floor($elapsed / 3600);
		$elapsed_min 		= floor($elapsed / 60);

		$emp_shift 	= $this->emp_shift_check($emp_id, $date);
		$schedule 	= $this->schedule_check($emp_shift);
		//print_r($schedule);

		$ot_minutes		=  $schedule[0]["ot_minute_to_one_hour"];

		if($elapsed_min >= $ot_minutes){
			$elapsed_hour = $elapsed_hour + 1;
		}
		return $elapsed_hour;
	}

	function ot_hour_calcultation($emp_id, $date){
		$table = "temp_$emp_id";
		$table = strtolower($table);

		$present_count = 0;
		$absent_count = 0;
		$leave_count = 0;
		$ot_count = 0;
		$late_count = 0;

		$this->db->select("pr_emp_com_info.ot_entitle");
		$this->db->from("pr_emp_com_info");
		$this->db->where("pr_emp_com_info.emp_id = '$emp_id'");
		$query1 = $this->db->get();
		$row1 = $query1->row();
		$ot_status  = $row1->ot_entitle;

		$in_time = '';
		$out_time = '';

		$emp_shift = $this->emp_shift_check($emp_id, $date);

		$schedule = $this->schedule_check($emp_shift);
		// print_r($schedule); exit();
		$start_time		=  $schedule[0]["in_start"];
		$late_time 		=  $schedule[0]["late_start"];
		$end_time   	=  $schedule[0]["in_end"];
		$out_start_time	=  $schedule[0]["out_start"];
		$ot_start_time	=  $schedule[0]["ot_start"];
		$out_end_time	=  $schedule[0]["out_end"];

		$hour = trim(substr($out_start_time,0,2));
		$minute = trim(substr($out_start_time,3,2));
		$sec = trim(substr($out_start_time,6,2));

		$am_pm = date("A", mktime($hour, $minute, $sec, 0, 0, 0));
		$in_date = $date;
		$ot_start_time = "$in_date $ot_start_time";
		if($am_pm == "AM"){
			$now = strtotime($in_date);
			$datestr = strtotime("+1 day",$now);
			$in_date = date("Y-m-d", $datestr);
			$in_date = $in_date;
		}
		else{
			$in_date = $date;
		}

		$hour = trim(substr($out_end_time,0,2));
		$minute = trim(substr($out_end_time,3,2));
		$sec = trim(substr($out_end_time,6,2));
		$am_pm = date("A", mktime($hour, $minute, $sec, 0, 0, 0));

		$out_date = $date;
		if($am_pm == "AM"){
			//echo $am_pm;
			$now = strtotime($out_date);
			$datestr = strtotime("+1 day",$now);
			$out_date = date("Y-m-d", $datestr);
			$out_date = $out_date;
		}
		else{
			$out_date = $date;
		}
		//echo $out_end_time;
		$present_check = $this->present_check($date, $emp_id);
		if( $present_check == true){
			$in_time  = $this->time_check_in($date, $start_time, $end_time, $table);
			$out_start_time = "$in_date $out_start_time";
			$out_end_time = "$out_date $out_end_time";

			$out_time = $this->time_check_out2($out_start_time, $out_end_time, $table);
		}
		else{
			$in_time = '';
			$out_time = '';
		}

		if($in_time !=''){
			$hour = trim(substr($in_time,0,2));
			$minute = trim(substr($in_time,3,2));
			$sec = trim(substr($in_time,6,2));
			$time_format = date("h:i:s A", mktime($hour, $minute, $sec, 0, 0, 0));
			$in_time_format = $time_format;
		}
		else{
			$in_time_format='';
		}

		if($out_time !=''){
			$hour = trim(substr($out_time,11,2));
			$minute = trim(substr($out_time,14,2));
			$sec = trim(substr($out_time,17,2));
			$time_format = date("h:i:s A", mktime($hour, $minute, $sec, 0, 0, 0));
			$out_time_format = $time_format;
		}else{
			$out_time_format='';
		}

		$ot_hour= 0;
		if($in_time !='' and $out_time !=''){
			if($ot_status == 0){
				$in_date_time = $out_start_time;
				$ot_hour = $this->hour_difference($ot_start_time, $out_time, $emp_id, $date);
			}
		}

		if($out_time !=''){
			$hour = trim(substr($out_time,11,2));
			$minute = trim(substr($out_time,14,2));
			$sec = trim(substr($out_time,17,2));
			$out_time = date("H:i:s", mktime($hour, $minute, $sec, 0, 0, 0));
		}

		$data["in_time"] = $in_time;
		$data["out_time"] = $out_time;
		$data["ot_hour"] = $ot_hour;
		// echo "<pre>"; print_r($data); exit();
		return $data;
	}

	function insert_ot_hour($emp_id, $date, $ot_hour_calcultation,$present_status){
		$emp_shift = $this->emp_shift_check($emp_id, $date);
		$schedule = $this->schedule_check($emp_shift);
		$start_time		=  $schedule[0]["in_start"];
		$late_time 		=  $schedule[0]["late_start"];
		$end_time   	=  $schedule[0]["in_end"];
		$out_start_time	=  $schedule[0]["out_start"];
		$out_end_time	=  $schedule[0]["out_end"];

		$in_time = '';
		if($ot_hour_calcultation["in_time"] != ''){
			$in_time = $ot_hour_calcultation["in_time"];
		}

		$out_time = '';
		if($ot_hour_calcultation["out_time"] != ''){
			$out_time = $ot_hour_calcultation["out_time"];
		}

		if($ot_hour_calcultation["ot_hour"] =='' or $ot_hour_calcultation["ot_hour"] <=0){
			$ot_hour = 0;
		}else{
			$ot_hour = $ot_hour_calcultation["ot_hour"];
		}

		$late_status = 0;
		$night_allowance = 0;
		$this->db->select();
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date", $date);
		$query = $this->db->get("pr_emp_shift_log");


		if($query->num_rows() > 0){
			if($in_time >= $late_time && $in_time !=''){
				$late_status = 1;
			}

			//===================Night Allowance Check===================
			if($out_time != ''){
				$night_allowance = $this->get_night_allowance($date,$out_time,$emp_id);
			}

			$tiffin_allowance = 0;

			$data = array(
						"in_time" 			=> $in_time,
						"out_time" 			=> $out_time,
						"ot_hour" 			=> $ot_hour,
						"late_status" 		=> $late_status,
						"tiffin_allo" 		=> $tiffin_allowance,
						"present_status" 	=> $present_status,
						"night_allo" 		=> $night_allowance,
						"holiday_allowance"	=> 0,
						"weekly_allo" 		=> 0,
						);
			$this->db->where("emp_id", $emp_id);
			$this->db->where("shift_log_date", $date);
			$this->db->update("pr_emp_shift_log", $data);
		}
	}

	function get_tiffin_allowance($out_time,$emp_id)
	{
		$tiffin_allowance_rules 	= $this->get_tiffin_allowance_rules_data();
		$tiffin_time 				= $tiffin_allowance_rules ['tiffin_time'];
		$tiffin_out_time_median 	= date('A', strtotime($tiffin_time));
		$out_time_median 			= date('A', strtotime($out_time));

		if($tiffin_out_time_median != $out_time_median)
		{
			$tiffin_allow 			= 1;
		}
		else
		{
			if($tiffin_time <= $out_time)
			{
				$tiffin_allow 			= 1;
			}
			else
			{
				$tiffin_allow 			= 0;
			}
		}
		return $tiffin_allow;
	}

	function get_night_allowance($date,$out_time,$emp_id){
		$desig_id = $this->db->where("emp_id",$emp_id)->get('pr_emp_com_info')->row()->emp_desi_id;
		$night_allowance_rules = $this->get_night_allowance_ruless($desig_id);

		$night_allow  = 0;
		if($night_allowance_rules['msg'] == "OK" ){
			$night_allowance_time = $this->db->where("rules_id",$night_allowance_rules['rules_id'])->get('pr_night_allowance_rules')->row()->night_time;

			$date_outtime 	= "$date $out_time";
			$date_nighttime = "$date $night_allowance_time";

			$night_out_time_median 		= date('A', strtotime($night_allowance_time));
			$out_time_median 			= date('A', strtotime($out_time));

			if($night_out_time_median == "AM"){
				$tomorrow = date('Y-m-d',strtotime($date . "+1 days"));
				$date_nighttime = "$tomorrow $night_allowance_time";
			}
			if($out_time_median == "AM"){
				$tomorrow2 = date('Y-m-d',strtotime($date . "+1 days"));
				$date_outtime = "$tomorrow2 $out_time";
			}
			if(strtotime($date_nighttime) <= strtotime($date_outtime)){
				$night_allow 	= 1;
			}
		}

		return $night_allow;
	}

	function get_tiffin_allowance_rules_data(){
		$this->db->select('*');
		$this->db->from('pr_tiffin_bill');
		$this->db->where("id", 1);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$data['tiffin_time'] = $row->tiffin_time;
			$data['tiffin_amount'] = $row->amount;
		}

		return  $data;
	}

	function get_night_allowance_ruless($desig_id){
		$this->db->select('rules_id');
		$this->db->from('pr_night_allowance_level');
		$this->db->where("desig_id", $desig_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$row = $query->row();
			$data['rules_id'] = $row->rules_id;
			$data['msg'] = "OK";
		}else{
			$rules_id = 0;
			$data['msg'] = "NULL";
		}

		return $data;
	}

	function present_check($date, $emp_id)
	{
		//echo $date;
		$year  = trim(substr($date,0,4));
		$month = trim(substr($date,5,2));
		$day   = trim(substr($date,8,2));
		$date_field = "date_$day";
		$att_month = $year."_".$month."-00";

		$this->db->select($date_field);
		$this->db->where("emp_id", $emp_id);
		$this->db->where("att_month", $att_month);
		$this->db->where($date_field, "P");
		$query = $this->db->get("pr_attn_monthly");
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function in_time_for_four_hur($date, $start_time, $end_time, $table)
	{
		$this->db->select("date_time");
		$this->db->where("trim(substr(date_time,1,10)) = '$date'");
		$this->db->where("trim(substr(date_time,11,19)) BETWEEN '$start_time' and '$end_time'");
		$this->db->order_by("date_time","ASC");
		$this->db->limit("1");
		$query = $this->db->get($table);
		$time ="";
		foreach ($query->result() as $row)
		{
			$time = $row->date_time;
		}
		//$time = trim(substr($time,11,19));
		return $time;
	}

	function time_check_out($date, $start_time, $end_time, $table)
	{
		$this->db->select("date_time");
		$this->db->where("trim(substr(date_time,1,10)) = '$date'");
		$this->db->where("trim(substr(date_time,11,19)) BETWEEN '$start_time' and '$end_time'");
		$this->db->order_by("date_time","DESC");
		$this->db->limit("1");
		$query = $this->db->get($table);
		$time ="";
		foreach ($query->result() as $row)
		{
			$time = $row->date_time;
		}
		//$time = trim(substr($time,11,19));
		return $time;
	}

	function time_check_out2($start_time, $end_time, $table)
	{
		$this->db->select("date_time");
		//$this->db->where("trim(substr(date_time,1,10)) = '$date'");
		$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
		$this->db->order_by("date_time","DESC");
		$this->db->limit("1");
		$query = $this->db->get($table);
		//echo $this->db->last_query();exit();
		$time ="";
		foreach ($query->result() as $row)
		{
			$time = $row->date_time;
		}
		//$time = trim(substr($time,11,19));
		return $time;
	}

	function out_time_for_four_hur($start_time, $end_time, $table)
	{
		$this->db->select("date_time");
		//$this->db->where("trim(substr(date_time,1,10)) = '$date'");
		$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
		$this->db->order_by("date_time","DESC");
		$this->db->limit("1");
		$query = $this->db->get($table);
		//echo $this->db->last_query();exit();
		$time ="";
		foreach ($query->result() as $row)
		{
			$time = $row->date_time;
		}
		//$time = trim(substr($time,11,19));
		return $time;
	}

	function earn_leave_process($input_date)
	{
		// Start Automatic Earn Leave Entry
		// ================================
		$this->earn_automatic_entry();
		// End Automatic Earn Leave Entry

		$current_date = date("Y-m-d");
		$date = strtotime(date("Y-m-d", strtotime($current_date)) . " -17 day");
		$newdate = date('Y-m-d', $date);

		$where="last_update NOT BETWEEN '$newdate' and '$current_date'" ;
		$this->valid_earn_leave_process($where);

		$year = date('Y');
		$end_date_year = $year."-12-31";
		if($current_date == $end_date_year)
		{
			$where1="last_update  BETWEEN '$newdate' and '$current_date'" ;
			$this->valid_earn_leave_process($where1);
		}

		//Start Year change activity
		//===========================
		$this->db->select('emp_id,last_update');
		$query=$this->db->get('pr_leave_earn');

		foreach ($query->result() as $row)
		{
			$empid = $row-> emp_id;
			$last_update = $row-> last_update;
			$current_year = date("Y");
			$last_update_year = date("Y", strtotime($last_update));
			if($current_year > $last_update_year)
			{
				$this->year_change($empid);
			}
			$max_earn = $this->get_max_earn();
			$this->max_earn_check($empid,$max_earn);

		}
		//End Year change activity
	}

	function earn_automatic_entry()
	{

		$this->db->select('emp_id,emp_join_date');
		$this->db->where("emp_cat_id","1");
		//$this->db->where("emp_id","01010");
		$query = $this->db->get('pr_emp_com_info');
		foreach($query->result() as $rows)
		{
			$empid = $rows->emp_id;
			$join_date = $rows->emp_join_date;
			//$join_date ="2011-11-30";
			//echo $join_date;
			$earn_join_date =  strtotime(date("Y-m-d", strtotime($join_date)) . " +1 year");

			$earn_current_date = strtotime(date("Y-m-d"));
			if($earn_join_date < $earn_current_date)
			{
				$num_row = $this->db->where('emp_id',$empid)->get('pr_leave_earn')->num_rows();
				if ($num_row < 1)
				{
					//echo "----true";
					$data = array(
					'emp_id' => $empid ,
					'old_earn_balance' => "0",
					'current_earn_balance' =>"0",
					"last_update"  => date("Y-m-d")
					);
					$this->db->insert('pr_leave_earn', $data);
				}
			}
		}
	}

	function valid_earn_leave_process($where)
	{

		$current_date = date("Y-m-d");
		$this->db->select('*');
		$this->db->where($where);
		$query=$this->db->get('pr_leave_earn');
		foreach ($query->result() as $row)
		{

			$emid = $row-> emp_id;
			//echo $emid."***";
			$last_update = $row-> last_update;
			$data["emp_id"][] = $emid;
			$data["last_update"][] = $last_update;
			if($last_update != $current_date)
			{
				$result = $this->earn_present_check($emid,$last_update,$current_date);
			}
		}

	}

	function earn_present_check($empid,$last_update,$current_date)
	{

		$day = $this->get_date_to_date_day_differance($last_update,$current_date);
		//echo "$empid,$last_update,$current_date, $day";
		$count = 0;

		for($i=0;$i<=$day;$i++)
		{
			//$last_update= "2012-06-01";
			$date = strtotime(date("Y-m-d", strtotime($last_update)) . " +$i day");
			$newdate = date('Y-m-d', $date);

			$result = $this->present_check($newdate, $empid);
			if($result == true)
			{
				$count = $count + 1;
			}
			//echo $newdate."<br/>";

		}

		//echo $count;
		if ($count!=0)
		{

			$count = round(($count/18),2);
			$this->db->select('current_earn_balance,old_earn_balance');
			$this->db->where("emp_id", $empid);
			$query = $this->db->get('pr_leave_earn');
			$rows = $query->row();
			$old_earn_balance = $rows->old_earn_balance;
			$current_earn_balance = $rows->current_earn_balance;
			$current_earn_balance = $current_earn_balance + $count;
			$data = array(
               'current_earn_balance' => $current_earn_balance,
			   'last_update'  => date('Y-m-d')
            );
			$this->db->where("emp_id",$empid);
			$this->db->update('pr_leave_earn', $data);
		}

	}

	function get_date_to_date_day_differance($date1,$date2)
	{
		$date_diff 		= strtotime($date2)-strtotime($date1);
		//DATE TO DATE RULE
		return $month 	= floor(($date_diff)/60/60/24);
	}

	function year_change($empid)
	{
		//echo $query ->num_rows();

		$this->db->select('*');
		$this->db->where("emp_id", $empid);
		$query = $this->db->get('pr_leave_earn');

		foreach ($query->result() as $row)
		{
			$old_earn_lv_balance = $row ->old_earn_balance;
			$current_earn_lv_balance = $row -> current_earn_balance;
		}

		$old_earn_lv_balance = $old_earn_lv_balance + $current_earn_lv_balance;
		//echo $old_earn_lv_balance ;
		$data = array(
			'old_earn_balance' => $old_earn_lv_balance,
			'current_earn_balance' => "0.00",
			'last_update'  => date('Y-m-d')
		);
		$this->db->where("emp_id",$empid);
		$this->db->update('pr_leave_earn', $data);

	}

	function max_earn_check($empid,$max_earn)
	{
		$this->db->select('old_earn_balance');
		$this->db->where("emp_id", $empid);
		$query = $this->db->get('pr_leave_earn');
		foreach ($query->result() as $row)
		{
			$old_earn_balance = $row->old_earn_balance;
		}

		if($old_earn_balance > $max_earn)
		{
			$data = array(
				'old_earn_balance' => $max_earn
			);
			$this->db->where("emp_id",$empid);
			$this->db->update('pr_leave_earn', $data);
		}
	}

	function get_max_earn()
	{
		$this->db->select('max_earn');
		$query_max_earn = $this->db->get('pr_leave_earn_max');
		$rows = $query_max_earn->row();
		$max_earn  = $rows->max_earn ;
		return $max_earn;
	}

	function deduction_hour_process($emp_id,$att_date){
		$this->db->select('*');
		$this->db->where("shift_log_date",$att_date);
		$this->db->where("emp_id",$emp_id);
		$query = $this->db->get('pr_emp_shift_log');


		foreach ($query->result() as $row){
			$emp_id = $row->emp_id;
			$shift_id = $row->shift_id;
			$out_time = $row->out_time;
			$shift_out_time = $this->get_shift_out_time($shift_id);
			$ot_status = $this->db->select('ot_entitle')->where('emp_id',$emp_id)->get('pr_emp_com_info')->row()->ot_entitle;

			if($out_time !="00:00:00"){
				$new_shift_out_time = date("h:i:s A", strtotime($shift_out_time));
				$date_shift_out_time = $att_date." ".$new_shift_out_time;

				$new_out_time = date("h:i:s A", strtotime($out_time));

				$first_out_time=trim(substr($new_out_time,9,2));


				if(trim(substr($new_shift_out_time,9,2)) == $first_out_time){
					$date_out_time = $att_date." ".$new_out_time;

				}else{
					 $att_date_new = strtotime(date("Y-m-d", strtotime($att_date)) . " +1 day");
					 $newdate = date ( 'Y-m-d' , $att_date_new );
					 $date_out_time = $newdate." ".$new_out_time;
				}

				 //echo $date_shift_out_time."---".$date_out_time;
				if(strtotime($date_shift_out_time) > strtotime($date_out_time)){

					$date1 = new DateTime($date_shift_out_time);
					$date2 = new DateTime($date_out_time);
					$interval = $date1->diff($date2);
					$hour =  $interval->h;
					$min =  $interval->i;

					if($min > 40){
						$hour = $hour + 1;
					}

					if($hour > 1) $hour = 3; else $hour = 0;

					if($ot_status == 1){
						$hour = 0;
					}

					$data = array(
						'deduction_hour' => 0
					);

					$this->db->where("emp_id",$emp_id);
					$this->db->where("shift_log_date",$att_date);
					$this->db->update('pr_emp_shift_log', $data);
				}else{
					$hour=0;
					$min = 0;
					$data = array(
						'deduction_hour' => 0
					);
					$this->db->where("emp_id",$emp_id);
					$this->db->where("shift_log_date",$att_date);
					$this->db->update('pr_emp_shift_log', $data);
				}
			}else{
				$hour=0;
				$min = 0;
			}
		}
	}


	function get_shift_out_time($shift_id)
	{
		$this->db->select('*');
		$this->db->where("shift_id",$shift_id);
		$query = $this->db->get('pr_emp_shift_schedule');
		$rows = $query->row();
		$end_time = $rows->ot_start;
		return $end_time;
	}

	function get_setup_attributes($setup_id)
	{
		$this->db->select('value');
		$this->db->where("id",$setup_id);
		$query = $this->db->get('pr_setup');
		$rows = $query->row();
		$setup_value = $rows ->value;
		return $setup_value;
	}

	function make_attendance_table_name_monthly($process_date)
	{
		$first_y	= date('Y', strtotime($process_date));
		$first_m	= date('m', strtotime($process_date));
		$first_d	= date('d', strtotime($process_date));

		return $att_table	= "att_".$first_y."_".$first_m;
	}



	function insert_monthly_machine_data_to_temp_table($emp_id, $process_date)
	{
		//echo "hey";
		$temp_table = "temp_$emp_id";
		$temp_table = strtolower($temp_table);

		$att_table 	= $this->make_attendance_table_name_monthly($process_date);
		//echo $process_date;
		$this->db->select();
		$this->db->from($att_table);
		// $this->db->from('pr_id_proxi');
		// $this->db->where("$att_table.proxi_id = pr_id_proxi.proxi_id");
		$this->db->where("$att_table.proxi_id  = '$emp_id'");
		$this->db->where("$att_table.date_time  like '$process_date%'");
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $rows)
		{
			$this->db->select();
			$this->db->where("device_id  = '$rows->device_id'");
			$this->db->where("proxi_id  = '$rows->proxi_id'");
			$this->db->where("date_time  = '$rows->date_time'");
			$this->db->from($temp_table);
			$query = $this->db->get();
			if($query->num_rows == 0)
			{
				$temp_data = array(
									'device_id' => $rows->device_id,
									'proxi_id' => $rows->proxi_id,
									'date_time' => $rows->date_time
									);
				$this->db->insert($temp_table,$temp_data);
			}
		}
	}



}

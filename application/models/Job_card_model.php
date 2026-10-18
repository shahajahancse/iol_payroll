<?php
class Job_card_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
	}

	// start 9pm eot job card
	function leave_per_emp($sStartDate, $sEndDate, $emp_id)
	{
		$this->db->select("leave_type, leave_start, leave_end, start_date");
		$this->db->where("((leave_start <= '$sEndDate' AND leave_end >= '$sStartDate') OR (start_date BETWEEN '$sStartDate' AND '$sEndDate'))");
		$this->db->where("emp_id = '$emp_id'");
		$this->db->where("(status = 'approved' OR status IS NULL)");
		$query = $this->db->get("pr_leave_trans");
		$leave = array();
		foreach ($query->result() as $row)
		{
			$start = !empty($row->leave_start) ? $row->leave_start : $row->start_date;
			$end   = !empty($row->leave_end) ? $row->leave_end : $start;
			$cur   = max(strtotime($sStartDate), strtotime($start));
			$end_t = min(strtotime($sEndDate), strtotime($end));
			while ($cur <= $end_t) {
				$d = date('Y-m-d', $cur);
				$leave[$d] = strtoupper(trim($row->leave_type));
				$cur = strtotime('+1 day', $cur);
			}
		}
		return $leave;
	}

	function get_single_day_leaves($sStartDate, $sEndDate, $emp_id)
	{
		$this->db->select("leave_type, leave_start, leave_end, start_date, total_leave");
		$this->db->where("((leave_start <= '$sEndDate' AND leave_end >= '$sStartDate') OR (start_date BETWEEN '$sStartDate' AND '$sEndDate'))");
		$this->db->where("emp_id", $emp_id);
		$this->db->where_in("LOWER(leave_type)", array('sl', 'cl'));
		$this->db->where("(status = 'approved' OR status IS NULL)");
		$query = $this->db->get("pr_leave_trans");
		$single_leaves = array();
		foreach ($query->result() as $row)
		{
			$start = !empty($row->leave_start) ? $row->leave_start : $row->start_date;
			$end   = !empty($row->leave_end) ? $row->leave_end : $start;
			$total = !empty($row->total_leave) ? $row->total_leave : 1;
			if ($total == 1 || $start == $end) {
				$single_leaves[$start] = strtoupper(trim($row->leave_type));
			}
		}
		return $single_leaves;
	}

	function check_single_day_sl_cl($date, $emp_id)
	{
		$this->db->select("leave_type, leave_start, leave_end, start_date, total_leave");
		$this->db->where("((leave_start <= '$date' AND leave_end >= '$date') OR start_date = '$date')");
		$this->db->where("emp_id", $emp_id);
		$this->db->where_in("LOWER(leave_type)", array('sl', 'cl'));
		$this->db->where("(status = 'approved' OR status IS NULL)");
		$query = $this->db->get("pr_leave_trans");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$start = !empty($row->leave_start) ? $row->leave_start : $row->start_date;
				$end   = !empty($row->leave_end) ? $row->leave_end : $start;
				$total = !empty($row->total_leave) ? $row->total_leave : 1;
				if ($total == 1 || $start == $end) {
					return true;
				}
			}
		}
		return false;
	}

	function check_weekend($sStartDate, $sEndDate, $emp_id){
		// Get employee's assigned weekend from pr_emp_com_info
		$com_emp = $this->db->select("weekend")->where("emp_id", $emp_id)->get("pr_emp_com_info")->row();
		$com_weekend_day = (!empty($com_emp) && !empty($com_emp->weekend)) ? strtolower(trim($com_emp->weekend)) : 'friday';

		$weekend = array();

		// Add replacement / manual work off from attn_work_off, but ignore Friday if employee weekend is NOT Friday
		$this->db->select("work_off_date");
		$this->db->where("work_off_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("attn_work_off");
		foreach ($query->result() as $row){
			$row_day = strtolower(date('l', strtotime($row->work_off_date)));
			if ($row_day === 'friday' && $com_weekend_day !== 'friday') {
				continue;
			}
			$weekend[] = $row->work_off_date;
		}

		// Add all days matching employee's designated weekend
		$cur = strtotime($sStartDate);
		$end = strtotime($sEndDate);
		while ($cur <= $end) {
			$cur_date = date('Y-m-d', $cur);
			$cur_day = strtolower(date('l', $cur));
			if ($cur_day === $com_weekend_day && !in_array($cur_date, $weekend)) {
				$weekend[] = $cur_date;
			}
			$cur = strtotime('+1 day', $cur);
		}

		return $weekend;
	}

	function holiday_calculation($sStartDate, $sEndDate,$emp_id){
		$this->db->select("from_date, to_date");
		$this->db->where("from_date <= '$sEndDate' AND to_date >= '$sStartDate'");
		$this->db->where("emp_id", $emp_id);
		$query = $this->db->get("attn_holyday_off");
		$holiday = array();
		foreach ($query->result() as $row)
		{
			$start = max(strtotime($sStartDate), strtotime($row->from_date));
			$end   = min(strtotime($sEndDate), strtotime($row->to_date));
			while ($start <= $end) {
				$holiday[] = date('Y-m-d', $start);
				$start = strtotime('+1 day', $start);
			}
		}

		$gov = $this->db->select('date as start_date')
			->where("date BETWEEN '$sStartDate' AND '$sEndDate'")
			->get('pr_gov_holiday');
		foreach ($gov->result() as $r) {
			if (!in_array($r->start_date, $holiday)) {
				$holiday[] = $r->start_date;
			}
		}

		return $holiday;
	}

	function emp_shift_check($emp_id, $att_date){
		$this->db->select("shift_id, schedule_id");
		$this->db->from("pr_emp_shift_log");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date", $att_date);
		$query = $this->db->get();

		if($query->num_rows() > 0 )
		{
			$shift_duty = $query->row()->schedule_id;

			$this->db->select("sh_type");
			$this->db->from("pr_emp_shift_schedule");
			$this->db->where("shift_id", $shift_duty);
			$query1 = $this->db->get();
			$row = $query1->row();
			return $row->sh_type;
		}
		else
		{
			$this->db->select("pr_emp_shift_schedule.sh_type");
			$this->db->from("pr_emp_shift_schedule");
			$this->db->from("pr_emp_shift");
			$this->db->from("pr_emp_com_info");
			$this->db->where("pr_emp_com_info.emp_id", $emp_id);
			$this->db->where("pr_emp_shift.id = pr_emp_com_info.emp_shift");
			$this->db->where("pr_emp_shift.schedule_id = pr_emp_shift_schedule.id");
			$query = $this->db->get();
			$row = $query->row();
			return $row->sh_type;
		}
	}

	function schedule_check($emp_shift)
	{
		$this->db->where("id", $emp_shift);
		$query = $this->db->get("pr_emp_shift_schedule");
		return $query->result_array();
	}

   function get_leave_type($shift_log_date,$emp_id){	
   		$this->db->select('leave_type');
		$this->db->where('emp_id', $emp_id);
	    $this->db->where("((leave_start <= '$shift_log_date' AND leave_end >= '$shift_log_date') OR start_date = '$shift_log_date')");
		$this->db->where("(status = 'approved' OR status IS NULL)");
		$query = $this->db->get('pr_leave_trans');
		$row = $query->row();
		return (!empty($row) && !empty($row->leave_type)) ? strtoupper(trim($row->leave_type)) : '';
   }

	function get_join_date($emp_id, $sStartDate, $sEndDate)
	{
		$this->db->select('emp_join_date');
		$this->db->where("emp_join_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("pr_emp_com_info");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $emp_join_date = $row->emp_join_date;
		}
		else
		{
			return false;
		}
	}

	function get_resign_date($emp_id, $sStartDate, $sEndDate)
	{
		$this->db->select('resign_date');
		$this->db->where("resign_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("pr_emp_resign_history");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $resign_date = $row->resign_date;
		}
		else
		{
			return false;
		}
	}

	function get_left_date($emp_id, $sStartDate, $sEndDate)
	{
		$this->db->select('left_date');
		$this->db->where("left_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("pr_emp_left_history");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $resign_date = $row->left_date;
		}
		else
		{
			return false;
		}
	}

	function time_am_pm_format($out_time){
		return date("H:i:s ", strtotime($out_time));
	}

	function time_format_ten_plus($out_time){
		$time = strtotime($out_time);
		return date("H:i:s ", strtotime('+11 minutes', $time));
	}

	function get_buyer_in_time($exact_time, $in_time){
		$exact_time = date("H:i:s", strtotime("+2 seconds", strtotime($exact_time)));

		$exact_hour_min_sec = $this->get_hour_min_sec($exact_time);
		$exact_hour   		= $exact_hour_min_sec['hour'];

		$real_hour_min_sec 	= $this->get_hour_min_sec($in_time);
		$real_minute  		= $real_hour_min_sec['minute'];
		$real_second 		= $real_hour_min_sec['second'];

		$min_1st_digit = substr($real_minute,0,1);
		$min_2nd_digit = substr($real_minute,1,1);

		$buyer_minute = $min_1st_digit + $min_2nd_digit;

		return $time_format = date("H:i:s ", mktime($exact_hour, $buyer_minute, $real_second, 0, 0, 0));
	}

	function get_hour_min_sec($time){
		$data = array();
		$data['hour']   = substr($time,0,2);
		$data['minute'] = substr($time,3,2);
		$data['second'] = substr($time,6,2);
		return $data;
	}


	// start actual job card
	public function actual_job_card($grid_firstdate, $grid_seconddate, $emp_id)
	{
		$data = array();
		$grid_firstdate = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

		$joining_check = $this->get_join_date($emp_id, $grid_firstdate, $grid_seconddate);
		if( $joining_check != false)
		{
			$start_date = $joining_check;
		}
		else
		{
			$start_date = $grid_firstdate;
		}

		$resign_check  = $this->get_resign_date($emp_id, $grid_firstdate, $grid_seconddate);
		if($resign_check != false)
		{
			$end_date = $resign_check;
		}
		else
		{
			$end_date = $grid_seconddate;
		}

		$left_check  = $this->get_left_date($emp_id, $grid_firstdate, $grid_seconddate);
		if($left_check != false)
		{
			$end_date = $left_check;
		}
		else
		{
			$end_date = $grid_seconddate;
		}

		$this->db->select();
		$this->db->where("emp_id",$emp_id);
		$this->db->where("shift_log_date BETWEEN '$start_date' AND '$end_date' ");
		$this->db->order_by("shift_log_date");
		$query = $this->db->get("pr_emp_shift_log")->result();

		$leaves = $this->leave_per_emp($start_date, $end_date, $emp_id);
		$leave_codes = array('L', 'SL', 'CL', 'EL', 'ML', 'WP', 'PL');
		foreach ($query as $row) {
			$is_leave = false;
			$leave_type = '';
			if (isset($leaves[$row->shift_log_date])) {
				$is_leave = true;
				$leave_type = $leaves[$row->shift_log_date];
			} elseif (in_array(strtoupper(trim($row->present_status)), $leave_codes)) {
				$is_leave = true;
				$leave_type = strtoupper(trim($row->present_status));
				if ($leave_type == 'L') {
					$lt = $this->get_leave_type($row->shift_log_date, $emp_id);
					$leave_type = !empty($lt) ? $lt : 'L';
				}
			}

			if ($is_leave) {
				$row->present_status = $leave_type;
				$row->in_time        = '00:00:00';
				$row->out_time       = '00:00:00';
				$row->ot             = 0;
				$row->eot            = 0;
				$row->com_ot         = 0;
				$row->com_eot        = 0;
				$row->late_status    = 0;
				$row->deduction_hour = 0;
			}
		}

		// Rule: If an employee takes a single-day SL or CL, and is absent (A) on the next calendar day,
		// then both the leave date and the next date must be shown as Absent (A).
		$single_leaves = $this->get_single_day_leaves($start_date, $end_date, $emp_id);
		$date_map = array();
		foreach ($query as $idx => $row) {
			$date_map[$row->shift_log_date] = $idx;
		}

		foreach ($query as $idx => $row) {
			$cur_date = $row->shift_log_date;
			if (isset($single_leaves[$cur_date])) {
				$next_date = date('Y-m-d', strtotime("$cur_date + 1 days"));
				$next_is_absent = false;

				if (isset($date_map[$next_date])) {
					$next_idx = $date_map[$next_date];
					$next_status = strtoupper(trim($query[$next_idx]->present_status));
					if ($next_status == 'A') {
						$next_is_absent = true;
					}
				} else {
					$next_row = $this->db->select('present_status')->where('emp_id', $emp_id)->where('shift_log_date', $next_date)->get('pr_emp_shift_log')->row();
					if (!empty($next_row) && strtoupper(trim($next_row->present_status)) == 'A') {
						$next_is_absent = true;
					}
				}

				if ($next_is_absent) {
					$row->present_status = 'A';
					$row->in_time        = '00:00:00';
					$row->out_time       = '00:00:00';
					$row->ot             = 0;
					$row->eot            = 0;
					$row->com_ot         = 0;
					$row->com_eot        = 0;
					$row->late_status    = 0;
					$row->deduction_hour = 0;
				}
			}
		}

		$data['emp_data'] = $query;

		return $data;
	}
	// end actual job card

	// eot job card
	function emp_job_card($grid_firstdate, $grid_seconddate, $emp_id){
		$data = array();
		$grid_firstdate = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

		$joining_check = $this->get_join_date($emp_id, $grid_firstdate, $grid_seconddate);
		if( $joining_check != false){
			$start_date = $joining_check;
		}else{
			$start_date = $grid_firstdate;
		}

		$resign_check  = $this->get_resign_date($emp_id, $grid_firstdate, $grid_seconddate);
		if($resign_check != false){
			$end_date = $resign_check;
		}
		else{
			$end_date = $grid_seconddate;
		}

		$left_check  = $this->get_left_date($emp_id, $grid_firstdate, $grid_seconddate);
		if($left_check != false){
			$end_date = $left_check;
		}
		else{
			$end_date = $grid_seconddate;
		}


		$data['leave'] = $this->leave_per_emp($start_date, $end_date, $emp_id);
		$data['weekend'] = $this->check_weekend($start_date, $end_date, $emp_id);
		$data['holiday'] = $this->holiday_calculation($start_date, $end_date, $emp_id);
		// dd($data['weekend']);

		// $id = $this->db->select('id')->where('emp_id',$emp_id)->get('pr_emp_com_info')->row()->id;
		$this->db->select('
						pr_emp_shift_log.in_time ,
						pr_emp_shift_log.out_time,
						pr_emp_shift_log.shift_log_date,
						pr_emp_shift_log.schedule_id,
						pr_emp_shift_log.ot,
						pr_emp_shift_log.eot,						
						pr_emp_shift_log.com_ot,
						pr_emp_shift_log.com_eot,
						pr_emp_shift_log.ot_eot_4pm,
						pr_emp_shift_log.ot_eot_12am,
						pr_emp_shift_log.false_ot_4,
						pr_emp_shift_log.false_ot_12,
						pr_emp_shift_log.false_ot_all,
						pr_emp_shift_log.late_status,
						pr_emp_shift_log.present_status,
						pr_emp_shift_log.deduction_hour,
						pr_emp_shift_log.modify_eot,
						pr_emp_shift_schedule.sh_type as shift_name
					');

		$this->db->from('pr_emp_shift_log');
		$this->db->from('pr_emp_shift_schedule');
		$this->db->where('pr_emp_shift_log.emp_id', $emp_id);
		$this->db->where('pr_emp_shift_schedule.id = pr_emp_shift_log.schedule_id');
		$this->db->where("pr_emp_shift_log.shift_log_date >=", $start_date);
		$this->db->where("pr_emp_shift_log.shift_log_date <=", $end_date);
		$this->db->order_by("pr_emp_shift_log.shift_log_date");
		$query = $this->db->get()->result();

		$leave_codes = array('L', 'SL', 'CL', 'EL', 'ML', 'WP', 'PL');
		foreach ($query as $row) {
			$is_leave = false;
			$leave_type = '';

			if (isset($data['leave'][$row->shift_log_date])) {
				$is_leave = true;
				$leave_type = $data['leave'][$row->shift_log_date];
			} elseif (in_array(strtoupper(trim($row->present_status)), $leave_codes)) {
				$is_leave = true;
				$leave_type = strtoupper(trim($row->present_status));
				if ($leave_type == 'L') {
					$lt = $this->get_leave_type($row->shift_log_date, $emp_id);
					$leave_type = !empty($lt) ? $lt : 'L';
				}
			}

			if ($is_leave) {
				$row->present_status = $leave_type;
				$row->in_time        = '00:00:00';
				$row->out_time       = '00:00:00';
				$row->ot             = 0;
				$row->eot            = 0;
				$row->com_ot         = 0;
				$row->com_eot        = 0;
				$row->ot_eot_4pm     = 0;
				$row->ot_eot_12am    = 0;
				$row->late_status    = 0;
				$row->deduction_hour = 0;
			}
		}

		// Rule: If an employee takes a single-day SL or CL, and is absent (A) on the next calendar day,
		// then both the leave date and the next date must be shown as Absent (A).
		$single_leaves = $this->get_single_day_leaves($start_date, $end_date, $emp_id);
		$date_map = array();
		foreach ($query as $idx => $row) {
			$date_map[$row->shift_log_date] = $idx;
		}

		foreach ($query as $idx => $row) {
			$cur_date = $row->shift_log_date;
			if (isset($single_leaves[$cur_date])) {
				$next_date = date('Y-m-d', strtotime("$cur_date + 1 days"));
				$next_is_absent = false;

				if (isset($date_map[$next_date])) {
					$next_idx = $date_map[$next_date];
					$next_status = strtoupper(trim($query[$next_idx]->present_status));
					if ($next_status == 'A') {
						$next_is_absent = true;
					}
				} else {
					$next_row = $this->db->select('present_status')->where('emp_id', $emp_id)->where('shift_log_date', $next_date)->get('pr_emp_shift_log')->row();
					if (!empty($next_row) && strtoupper(trim($next_row->present_status)) == 'A') {
						$next_is_absent = true;
					}
				}

				if ($next_is_absent) {
					$row->present_status = 'A';
					$row->in_time        = '00:00:00';
					$row->out_time       = '00:00:00';
					$row->ot             = 0;
					$row->eot            = 0;
					$row->com_ot         = 0;
					$row->com_eot        = 0;
					$row->ot_eot_4pm     = 0;
					$row->ot_eot_12am    = 0;
					$row->late_status    = 0;
					$row->deduction_hour = 0;
					if (isset($data['leave'][$cur_date])) {
						unset($data['leave'][$cur_date]);
					}
				}
			}
		}

		$data['emp_data'] = $query;
		// dd($data);
		return $data;
	}
	// end eot job card

	// 2 ot
	function get_formated_out_time_2ot($emp_id, $out_time, $emp_shift){
		if($out_time =='00:00:00'){
			return $out_time ='';
		}
		$schedule 				= $this->schedule_check($emp_shift);
		$out_start				= $schedule[0]["out_start"];
		$ot_start				= $schedule[0]["ot_start"];
		$ot_minute				= $schedule[0]["ot_minute_to_one_hour"];
		$one_hour_ot 			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($ot_start)));
		$one_hour_ot_out_time	= $schedule[0]["one_hour_ot_out_time"];

		$two_hour_ot 			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($one_hour_ot_out_time)));
		$two_hour_ot_out_time	= $schedule[0]["two_hour_ot_out_time"];

		if($out_start < $out_time) {
			// one hour ot cal and get buyer time
			if ($out_time >= $one_hour_ot AND $out_time <= $one_hour_ot_out_time) {
				if ($out_time >= $one_hour_ot) {
					return $out_time = $this->time_format_ten_plus($out_time);
				} else {
					return $out_time = $this->get_buyer_in_time($one_hour_ot_out_time, $out_time);
				}
			}

			// two hour ot cal and get buyer time
			if ($out_time >= $two_hour_ot AND $out_time <= $two_hour_ot_out_time) {
				if ($out_time >= $two_hour_ot) {
					return $out_time = $this->time_format_ten_plus($out_time);
				} else {
					return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time, $out_time);
				}
			}

			if ($out_time > $two_hour_ot_out_time) {
				return  $out_time = $this->get_buyer_in_time($two_hour_ot_out_time, $out_time);
			} else {
				return $out_time = $this->time_am_pm_format($out_time);
			}
		}
		else{
			return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time, $out_time);
		}
	}
	// end 2 ot

	// out time for 9pm
	function get_formated_out_time_9pm($emp_id, $out_time, $emp_shift){
		if($out_time =='00:00:00'){
			return $out_time ='';
		}
		$schedule 				= $this->schedule_check($emp_shift);
		$out_start				= $schedule[0]["out_start"];
		$ot_start				= $schedule[0]["ot_start"];
		$ot_minute				= $schedule[0]["ot_minute_to_one_hour"];
		$one_hour_ot 			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($ot_start)));
		$one_hour_ot_out_time	= $schedule[0]["one_hour_ot_out_time"];

		$two_hour_ot 			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($one_hour_ot_out_time)));
		$two_hour_ot_out_time	= $schedule[0]["two_hour_ot_out_time"];

		$three_hour_ot			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($two_hour_ot_out_time)));
		$three_hour_ot_out_time	= date("H:i:s", strtotime("+60 minutes", strtotime($two_hour_ot_out_time)));

		$four_hour_ot			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($three_hour_ot_out_time)));
		$four_hour_ot_out_time	= date("H:i:s", strtotime("+60 minutes", strtotime($three_hour_ot_out_time)));

		if($out_start < $out_time) {
			// one hour ot cal and get buyer time
			if ($out_time >= $one_hour_ot AND $out_time <= $one_hour_ot_out_time) {
				if ($out_time >= $one_hour_ot) {
					return $out_time = $this->time_format_ten_plus($out_time);
				} else {
					return $out_time = $this->get_buyer_in_time($one_hour_ot_out_time, $out_time);
				}
			}

			// two hour ot cal and get buyer time
			if ($out_time >= $two_hour_ot AND $out_time <= $two_hour_ot_out_time) {
				if ($out_time >= $two_hour_ot) {
					return $out_time = $this->time_format_ten_plus($out_time);
				} else {
					return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time, $out_time);
				}
			}

			// three hour ot cal and get buyer time
			if ($out_time >= $three_hour_ot AND $out_time <= $three_hour_ot_out_time) {
				if ($out_time >= $three_hour_ot) {
					return $out_time = $this->time_format_ten_plus($out_time);
				} else {
					// exit($out_time);
					return $out_time = $this->get_buyer_in_time($three_hour_ot_out_time, $out_time);
				}
			}

			// four hour ot cal and get buyer time
			if ($out_time >= $four_hour_ot AND $out_time <= $four_hour_ot_out_time) {
				if ($out_time >= $four_hour_ot) {
					return $out_time = $this->time_format_ten_plus($out_time);
				} else {
					return $out_time = $this->get_buyer_in_time($four_hour_ot_out_time, $out_time);
				}
			}

			if ($out_time > $four_hour_ot_out_time) {
				return  $out_time = $this->get_buyer_in_time($four_hour_ot_out_time, $out_time);
			} else {
				return $out_time = $this->time_am_pm_format($out_time);
			}
		}
		else{
			return $out_time = $this->get_buyer_in_time($four_hour_ot_out_time, $out_time);
		}
	}
	// end out time for 9pm

	// out time for 12am
	function get_formated_out_time_12am($emp_id, $out_time, $emp_shift){
		if($out_time =='00:00:00'){
			return $out_time ='';
		}
		$schedule 				= $this->schedule_check($emp_shift);
		$out_start				= $schedule[0]["out_start"];
		$ot_start				= $schedule[0]["ot_start"];
		$ot_minute				= $schedule[0]["ot_minute_to_one_hour"];
		$one_hour_ot 			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($ot_start)));
		$one_hour_ot_out_time	= $schedule[0]["one_hour_ot_out_time"];

		$two_hour_ot 			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($one_hour_ot_out_time)));
		$two_hour_ot_out_time	= $schedule[0]["two_hour_ot_out_time"];

		$three_hour_ot			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($two_hour_ot_out_time)));
		$three_hour_ot_out_time	= date("H:i:s", strtotime("+60 minutes", strtotime($two_hour_ot_out_time)));

		$four_hour_ot			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($three_hour_ot_out_time)));
		$four_hour_ot_out_time	= date("H:i:s", strtotime("+60 minutes", strtotime($three_hour_ot_out_time)));

		$five_hour_ot			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($four_hour_ot_out_time)));
		$five_hour_ot_out_time	= date("H:i:s", strtotime("+60 minutes", strtotime($four_hour_ot_out_time)));

		$six_hour_ot			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($five_hour_ot_out_time)));
		$six_hour_ot_out_time	= date("H:i:s", strtotime("+60 minutes", strtotime($five_hour_ot_out_time)));

		$seven_hour_ot			= date("H:i:s", strtotime("+$ot_minute minutes", strtotime($six_hour_ot_out_time)));
		$seven_hour_ot_out_time	= date("H:i:59", strtotime("+59 minutes", strtotime($six_hour_ot_out_time)));

		if($out_start < $out_time) {
			// one hour ot cal and get buyer time
			if ($out_time >= $one_hour_ot AND $out_time < $one_hour_ot_out_time) {
				return $out_time = $this->time_format_ten_plus($out_time);
			} else if ($out_time >= $one_hour_ot_out_time AND $out_time < $two_hour_ot) {
				return $out_time = $this->get_buyer_in_time($one_hour_ot_out_time, $out_time);
			}

			// two hour ot cal and get buyer time
			if ($out_time >= $two_hour_ot AND $out_time < $two_hour_ot_out_time) {
				return $out_time = $this->time_format_ten_plus($out_time);
			} else if ($out_time >= $two_hour_ot_out_time AND $out_time < $three_hour_ot) {
				return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time, $out_time);
			}

			// three hour ot cal and get buyer time
			if ($out_time >= $three_hour_ot AND $out_time < $three_hour_ot_out_time) {
				return $out_time = $this->time_format_ten_plus($out_time);
			} else if ($out_time >= $three_hour_ot_out_time AND $out_time < $four_hour_ot) {
				return $out_time = $this->get_buyer_in_time($three_hour_ot_out_time, $out_time);
			}

			// four hour ot cal and get buyer time
			if ($out_time >= $four_hour_ot AND $out_time < $four_hour_ot_out_time) {
				return $out_time = $this->time_format_ten_plus($out_time);
			} else if ($out_time >= $four_hour_ot_out_time AND $out_time < $five_hour_ot) {
				return $out_time = $this->get_buyer_in_time($four_hour_ot_out_time, $out_time);
			}

			// five hour ot cal and get buyer time
			if ($out_time >= $five_hour_ot AND $out_time < $five_hour_ot_out_time) {
				return $out_time = $this->time_format_ten_plus($out_time);
			} else if ($out_time >= $five_hour_ot_out_time AND $out_time < $six_hour_ot) {
				return $out_time = $this->get_buyer_in_time($five_hour_ot_out_time, $out_time);
			}

			// six hour ot cal and get buyer time
			if ($out_time >= $six_hour_ot AND $out_time < $six_hour_ot_out_time) {
				return $out_time = $this->time_format_ten_plus($out_time);
			} else if ($out_time >= $six_hour_ot_out_time AND $out_time < $seven_hour_ot) {
				return $out_time = $this->get_buyer_in_time($six_hour_ot_out_time, $out_time);
			}

			// seven hour ot cal and get buyer time
			if ($out_time >= $seven_hour_ot AND $out_time <= $seven_hour_ot_out_time) {
				if ($seven_hour_ot) {
					return $out_time = $this->time_format_ten_plus($out_time);
				} else {
					return $out_time = $this->get_buyer_in_time($seven_hour_ot_out_time, $out_time);
				}
			}

			if ($out_time > $seven_hour_ot_out_time) {
				return  $out_time = $this->get_buyer_in_time($seven_hour_ot_out_time, $out_time);
			} else {
				return $out_time = $this->time_am_pm_format($out_time);
			}
		} else {
			return $out_time = $this->get_buyer_in_time($seven_hour_ot_out_time, $out_time);
		}
	}
	// end out time for 12am

}

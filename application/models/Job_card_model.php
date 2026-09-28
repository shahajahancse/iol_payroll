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
		$this->db->select("start_date");
		$this->db->where("start_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("pr_leave_trans");
		$leave = array();
		foreach ($query->result() as $row)
		{
			$leave[] = $row->start_date;
		}
		return $leave;
	}

	function check_weekend($sStartDate, $sEndDate, $emp_id){
		$this->db->select("work_off_date");
		$this->db->where("work_off_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("attn_work_off");
		$weekend = array();
		foreach ($query->result() as $row){
			$weekend[] = $row->work_off_date;
		}
		return $weekend;
	}

	function holiday_calculation($sStartDate, $sEndDate,$emp_id){
		$this->db->select("work_off_date as start_date");
		$this->db->where("work_off_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id", $emp_id);
		$query = $this->db->get("attn_holyday_off");
		$holiday = array();
		foreach ($query->result() as $row)
		{
			$holiday[] = $row->start_date;
		}
		// dd($this->db->last_query());
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
	    $this->db->where("leave_start <=", $shift_log_date);
        $this->db->where("leave_end >=", $shift_log_date);
		$query = $this->db->get('pr_leave_trans');
		$row = $query->row();
		// dd($this->db->last_query());
		$leave_type = $row->leave_type;
		return $leave_type;
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

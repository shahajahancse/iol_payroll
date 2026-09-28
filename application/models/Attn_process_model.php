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
				$emp_shift = $this->emp_shift_check_process($emp_id, $shift_id, $schedule_id, $process_date);
				$schedule  = $this->get_emp_schedule($emp_shift->schedule_id);

				$in_start_time	= $schedule[0]["in_start"];
				$in_end_time   	= $schedule[0]["in_end"];
				$out_start_time = $schedule[0]["out_start"];
                $out_end_time 	= $schedule[0]["out_end"];
                $ot_start_time 	= $schedule[0]["ot_start"];
                $late_start_time = $schedule[0]["late_start"];


            	// one day plus for out end time
            	// because out end next day
                $out_date = $process_date;
                if (strtotime($out_end_time) < strtotime('12:00:00')){
                    $out_date = date('Y-m-d', strtotime($out_date. ' + 1 days'));
                }
                // OT start time define,
                //some worker OT start inday, and some worker OT start next day
                if (strtotime($in_end_time) > strtotime('12:00:00')){
	                $ot_start = "$out_date $ot_start_time";
                } else {
	                $ot_start = "$process_date $ot_start_time";
                }

                $in_start_time = "$process_date $in_start_time";
                $in_end_time   = "$process_date $in_end_time";
                $out_end_time   = "$out_date $out_end_time";


                $table = 'att_'.date('Y_m',strtotime($process_date));
                $in_time  = $this->time_check_in($in_start_time, $in_end_time, $emp_id, 'ASC', $table);
				$out_time = $this->time_check_in($in_end_time, $out_end_time, $emp_id, 'DESC', $table);

				if (empty($out_time) && date('t',strtotime($process_date))==date('d',strtotime($process_date))) {
					$next_day = date('Y-m-d', strtotime($out_date. ' + 1 days'));
					$table = 'att_'.date('Y_m',strtotime($next_day));
					$out_time = $this->time_check_in($in_end_time, $out_end_time, $emp_id, 'DESC', $table);
				}

				//=================OT CALCULATION ========================
				$tot_hour 		   = 0;
				$ot_hour 		   = 0;
				$eot_hour 		   = 0;
				$ot_eot_12am 	   = 0;
				$ot_eot_4pm        = 0;
				$deduction_hour    = 0;
				$late_status 	   = 0;
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
				$weekend 	= $this->check_weekend($emp_id, $process_date);
				$holiday = $this->check_holiday($emp_id, $process_date);
				$night_rules = $this->get_night_allowance_rules($process_date, $unit, $emp_desi_id);

				//============= Check employee attendance status =============
				$leaves = $this->leave_chech($process_date, $emp_id);
				$attn_status = 'A';
				if($leaves){
					$attn_status = "L";
				}elseif ($process_date == $holiday){
					$attn_status = "H";
				}elseif ($process_date == $weekend){
					$attn_status = "W";
				}elseif ($in_time != ''){
					$attn_status = "P";
				}
				//============= Check employee attendance status =============

				//============= Working day/Weeked/Holiday OT Calculation =============
				if ($attn_status != 'A' && $in_time != "" && $out_time !="" && $in_time != $out_time) {
					//======= Weeked/Holiday Extra OT Calculation==========
					if($process_date == $weekend || $process_date == $holiday){

                		$start_date_time = strtotime($in_time);
						$end_date_time 	= strtotime($out_time);
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

						// Total eot cal...
						$eot_hour 	= floor($minute / 60);
						if ($minute % 60 >= $ot_last_hour) {
							$eot_hour = $eot_hour + 1;
						}

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
							// dd($eot_hour);
							// 9pm EOT Calculation
							if ($eot_hour > 2) {
								$ot_eot_4pm = 2;
							} else {
								$ot_eot_4pm = $eot_hour;
							}
							// 12am EOT Calculation
							if ($tiffin_break_time2 < $out_time && $tiffin_minute2 != 0) {
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

				// Night Allowance unit
				if (!empty($night_rules) && strtotime($out_time) > strtotime($night_rules)) {
					$night_allo = 1;
				}
                // echo $night_allowance;exit;

				// Late Status check
				$late_start_time = "$process_date $late_start_time";
				if($in_time > $late_start_time && ($process_date == $weekend || $process_date == $holiday)) {
					$late_status = 1;
				}
				// Late Status

				// week and holiday allownance check
				if($attn_status == "W" && $in_time != ''){
				 	$weekly_allo = 1;
				}
				if($attn_status == "H" && $in_time != ''){
				 	$holiday_allo = 1;
				}
				// week and holiday end

				// get alert message
				$alert_msg = 0;
				if ($attn_status == "P") {
					$alert_msg = $this->get_alert_message($emp_id, $process_date, 1);
				}

				$data = array(
					'in_time' 			=> $in_time,
					'out_time' 			=> $out_time,
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
					'present_status' 	=> $attn_status,
					'tiffin_allo' 		=> 0,
					'night_allo' 		=> $night_allo,
					'holiday_allo'	    => $holiday_allo,
					'weekly_allo'		=> $weekly_allo,
					'unit_id'			=> $unit,
					'alert_msg'			=> $alert_msg
				);
				$this->db->where('shift_log_date', $process_date);
				$this->db->where('emp_id', $emp_id);
				$this->db->update('pr_emp_shift_log', $data);
			}
		}

		// check roster shift and auto chage this (if true this)
		if ($unit == 4 && strtotime(date('Y-m-d')) == strtotime($process_date)) {
			$this->check_shift_roster($process_date, $unit);
		}
		// $this->check_shift_roster($process_date, $unit);
		return true;
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
		$data = array(
			'emp_shift' => $emp_shift
		);

		$this->db->where_in('emp_id', $emp_array)->where('unit_id', $unit_id)->update('pr_emp_com_info', $data);
		return true;
	}

	function get_roster_shift_emp($emp_shift, $unit_id)
	{
		$rs=$this->db->select('emp_id')->where('emp_shift',$emp_shift)->where('unit_id',$unit_id)->get('pr_emp_com_info');
		$result = $rs->result_array();
		$output = array();

		array_walk($result, function($entry) use (&$output) {
		    $output[] = $entry["emp_id"];
		});

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
				pr_emp_shift.id as shift_id,
				pr_emp_shift.schedule_id,
		');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_shift');
		if (!empty($type)) {
			$this->db->where_in("pr_emp_com_info.emp_id",$grid_emp_id);
		} else {
			$this->db->where_in("pr_emp_com_info.id",$grid_emp_id);
		}
		$this->db->where("pr_emp_com_info.emp_shift = pr_emp_shift.id");
		$this->db->order_by("pr_emp_com_info.emp_id");
		return $query = $this->db->get();
	}

	function time_check_in($start_time, $end_time, $emp_id, $order_by, $table){
		$this->db->select("date_time");
		$this->db->from($table);

		$this->db->where("$table.proxi_id",$emp_id);
		$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
		$this->db->order_by("date_time",$order_by);
		$this->db->limit("1");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row()->date_time;
		}else{
			return '';
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

	function check_weekend($emp_id, $att_date)
	{
		$this->db->select("emp_id");
		$this->db->from("attn_work_off");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("work_off_date", $att_date);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function check_holiday($id, $att_date)
	{
		$this->db->select("emp_id");
		$this->db->from("attn_holyday_off");
		$this->db->where("emp_id", $id);
		$this->db->where("work_off_date", $att_date);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

    function leave_chech($process_date, $emp_id)
    {

        $this->db->where("leave_start <=", $process_date);
        $this->db->where("leave_end >=", $process_date);
        $this->db->where("emp_id", $emp_id);
        $query = $this->db->get("pr_leave_trans");

        if($query->num_rows() > 0) {
        	return true;
        } else {
            return false;
        }
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
		$this->db->select("shift_id, schedule_id");
		$this->db->from("pr_emp_shift_log");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date", $process_date);
		$query = $this->db->get();
		$data = new stdClass();
		if($query->num_rows() > 0 ){
			$row = 		$query->row();
			$data->shift_id    = $row->shift_id;
			$data->schedule_id = $row->schedule_id;
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
			return $data;
		}
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

<?php
class Mars_model extends CI_Model{


	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');

		/* Standard Libraries */
	}

	// 29/10/23  shahajahan
	function dashboard_summary($report_date, $unit_id = null)
	{
		$data = array();
		$all_id = get_all_emp_id(array(1), $unit_id);
		$data['total_designation'] = $this->get_designation($unit_id);
		$data['total_line'] = $this->get_line($unit_id);
		$data['total_section'] = $this->get_section($unit_id);
		$data['total_department'] = $this->get_department($unit_id);

	 	$data['monthly_join_id'] = $this->monthly_join_emp($report_date, $unit_id);
		$data['monthly_resign_id'] = $this->monthly_resign_emp($report_date, $unit_id);
		$data['monthly_left_id'] = $this->monthly_left_emp($report_date, $unit_id);

		// attendance summary
		$attendance_summary = $this->attendance_summary($report_date, $all_id);
		$data['all_emp'] = $attendance_summary['all_emp'];
		$data['all_male'] = $attendance_summary['all_male'];
		$data['all_female'] = $attendance_summary['all_female'];
		$data['all_female'] = $attendance_summary['all_female'];
		$data['all_employee'] = $attendance_summary['all_employee'];
		$data['all_staff'] = $attendance_summary['all_staff'];

		$data['all_present'] = $attendance_summary['all_present'];
		$data['all_absent'] = $attendance_summary['all_absent'];
		$data['all_late'] = $attendance_summary['all_late'];
		$data['all_leave'] = $attendance_summary['all_leave'];

		// pay salary
		$lm_expense = $this->last_month_expenses($report_date, $all_id);
		$data['salary'] = $lm_expense->net_pay;
		$data['ot'] 	= $lm_expense->ot_amount;
		$data['eot'] 	= $lm_expense->eot_amount;
		$data['att_bonus'] = $lm_expense->att_bonus;
		return $data;
	}

	function last_month_expenses($salary_month, $all_id)
	{
		// Guard: return default zeros if no employee IDs
		if (empty($all_id)) {
			return (object) array('net_pay' => 0, 'ot_amount' => 0, 'eot_amount' => 0, 'att_bonus' => 0);
		}
		$last_salary_month = date('Y-m-01',strtotime('-1 month',strtotime($salary_month)));
		$this->db->select("
				SUM(net_pay) AS net_pay,
				SUM(ot_amount) AS ot_amount,
				SUM(eot_amount) AS eot_amount,
				SUM(att_bonus) AS att_bonus,
			");
		$this->db->from("pay_salary_sheet");
		$this->db->where_in("emp_id", $all_id);
		$this->db->where("salary_month", $last_salary_month);
		return $this->db->get()->row();
	}

	function attendance_summary($report_date, $all_emp_id)
	{
		$data = array();

		// Guard: return default zeros if no employee IDs to prevent IN() SQL error
		if (empty($all_emp_id)) {
			$data['all_present']  = 0;
			$data['all_absent']   = 0;
			$data['all_leave']    = 0;
			$data['all_late']     = 0;
			$data['all_male']     = 0;
			$data['all_female']   = 0;
			$data['all_staff']    = 0;
			$data['all_employee'] = 0;
			$data['all_emp']      = 0;
			return $data;
		}

		$this->db->select("
			SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END) AS present,
			SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END) AS absent,
			SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END) AS leaves,
			SUM(CASE WHEN late_status = '1' THEN 1 ELSE 0 END) AS late
		", false);

		$this->db->from("pr_emp_shift_log");
		$this->db->where_in("emp_id", $all_emp_id);
		$this->db->where("shift_log_date", $report_date);
		$atten_data = $this->db->get()->row();

		$data['all_present'] 	= $atten_data->present ? $atten_data->present : 0;
		$data['all_absent'] 	= $atten_data->absent ? $atten_data->absent : 0;
		$data['all_leave'] 		= $atten_data->leaves ? $atten_data->leaves : 0;
		$data['all_late'] 		= $atten_data->late ? $atten_data->late : 0;

		$this->db->select("
			SUM(CASE WHEN pr_emp_per_info.gender = 'Male' THEN 1 ELSE 0 END) AS male,
			SUM(CASE WHEN pr_emp_per_info.gender = 'Female' THEN 1 ELSE 0 END) AS female,
			SUM(CASE WHEN pr_emp_com_info.emp_type = 2 THEN 1 ELSE 0 END) AS staff,
			SUM(CASE WHEN pr_emp_com_info.emp_type = 1 THEN 1 ELSE 0 END) AS employee,
		", false);
		$this->db->from('pr_emp_per_info');
		$this->db->join('pr_emp_com_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','left');
		$this->db->where_in('pr_emp_per_info.emp_id', $all_emp_id);
		$q = $this->db->get()->row();

		$data['all_male']     = $q->male ? $q->male : 0;
		$data['all_female']   = $q->female ? $q->female : 0;
		$data['all_staff']    = $q->staff ? $q->staff : 0;
		$data['all_employee'] = $q->employee ? $q->employee : 0;
		$data['all_emp']      = $data['all_staff'] + $data['all_employee'];
		return $data;
	}

	function monthly_join_emp($report_date, $unit_id = null)
	{

		$fromdate = date("Y-m-01", strtotime($report_date));
		$todate = date("Y-m-t", strtotime($report_date));
		$emp_cat = array(1,2);

		$this->db->select('pr_emp_com_info.emp_id');
		$this->db->from('pr_emp_com_info');
		if ($unit_id != null) {
			$this->db->join('emp_designation as deg', 'deg.id = pr_emp_com_info.emp_desi_id', 'left');
			$this->db->where('deg.hide_status', 1);
			$this->db->where('pr_emp_com_info.unit_id', $unit_id);
		}
		$this->db->where("pr_emp_com_info.emp_join_date >=",$fromdate);
		$this->db->where("pr_emp_com_info.emp_join_date <=",$todate);
		$query = $this->db->get()->num_rows();
		return $query;
	}

	function monthly_resign_emp($report_date, $unit_id = null)
	{
		$year = substr($report_date,0,4);
		$month = substr($report_date,5,2);
		$day = substr($report_date,8,2);
		$days = date("t", mktime(0, 0, 0, $month, 1, $year));
		$fromdate = date("Y-m-d", mktime(0, 0, 0, $month, 1, $year));
		$todate = date("Y-m-d", mktime(0, 0, 0, $month, $days, $year));

		$this->db->select('pr_emp_resign_history.emp_id');
		$this->db->from('pr_emp_resign_history');
		if ($unit_id != null) {
			$this->db->where('pr_emp_resign_history.unit_id', $unit_id);
		}
		$this->db->where("pr_emp_resign_history.resign_date >=",$fromdate);
		$this->db->where("pr_emp_resign_history.resign_date <=",$todate);
		//$query = $this->db->get();
		$query = $this->db->get()->num_rows();

		return $query;

	}

	function monthly_left_emp($report_date, $unit_id = null)
	{
		$year = substr($report_date,0,4);
		$month = substr($report_date,5,2);
		$day = substr($report_date,8,2);
		$days = date("t", mktime(0, 0, 0, $month, 1, $year));
		$fromdate = date("Y-m-d", mktime(0, 0, 0, $month, 1, $year));
		$todate = date("Y-m-d", mktime(0, 0, 0, $month, $days, $year));

		$this->db->select('pr_emp_left_history.emp_id');
		$this->db->from('pr_emp_left_history');
		if ($unit_id != null) {
			$this->db->where('pr_emp_left_history.unit_id', $unit_id);
		}
		$this->db->where("pr_emp_left_history.left_date >=",$fromdate);
		$this->db->where("pr_emp_left_history.left_date <=",$todate);
		//$query = $this->db->get();
		$query = $this->db->get()->num_rows();

		return $query;

	}

	function get_department($unit_id = null)
	{
		$this->db->select('COUNT(dept_id) AS total_dept');
		$this->db->from('emp_depertment');
		if($unit_id != null)
		{
			$this->db->where('unit_id', $unit_id);
		}
		return $this->db->get()->row()->total_dept;
	}

	function get_section($unit_id = null)
	{
		$this->db->select('COUNT(id) AS total_section');
		$this->db->from('emp_section');
		if($unit_id != null)
		{
			$this->db->where('unit_id', $unit_id);
		}
		return $this->db->get()->row()->total_section;
	}

	function get_line($unit_id = null)
	{
		$this->db->select('COUNT(id) AS total_line');
		$this->db->from('emp_line_num');
		if($unit_id != null)
		{
			$this->db->where('unit_id', $unit_id);
		}
		return $this->db->get()->row()->total_line;
	}

	function get_designation($unit_id = null)
	{
		$this->db->select('COUNT(id) AS total_designation');
		$this->db->from('emp_designation');
		if($unit_id != null)
		{
			$this->db->where('unit_id', $unit_id);
		}
		return $this->db->get()->row()->total_designation;
	}


	function weekly_attendance_summary($report_date = null, $all_emp_id = null)
	{
		$data = array();
		$date_1 = date('Y-m-d',strtotime($report_date));
		$day_1 = date('D', strtotime($date_1));
		$data['day_1'] = $day_1;
		$date_2 = date('Y-m-d',strtotime('-1 day',strtotime($report_date)));
		$day_2 = date('D', strtotime($date_2));
		$data['day_2'] = $day_2;
		$date_3 = date('Y-m-d',strtotime('-2 day',strtotime($report_date)));
		$day_3 = date('D', strtotime($date_3));
		$data['day_3'] = $day_3;

		$date_4 = date('Y-m-d',strtotime('-3 day',strtotime($report_date)));
		$day_4 = date('D', strtotime($date_4));
		$data['day_4'] = $day_4;

		$date_5 = date('Y-m-d',strtotime('-4 day',strtotime($report_date)));
		$day_5 = date('D', strtotime($date_5));
		$data['day_5'] = $day_5;

		$date_6 = date('Y-m-d',strtotime('-5 day',strtotime($report_date)));
		$day_6 = date('D', strtotime($date_6));
		$data['day_6'] = $day_6;

		$date_7 = date('Y-m-d',strtotime('-6 day',strtotime($report_date)));
		$day_7 = date('D', strtotime($date_7));
		$data['day_7'] = $day_7;
		$user_level=$this->session->userdata('data')->level;
		$unit_name=$this->session->userdata('data')->unit_name;


		$this->db->distinct();
		$this->db->select("
				SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END ) AS present,
				SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END ) AS absent,
				SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END ) AS leaves,
				SUM(CASE WHEN present_status = 'W' THEN 1 ELSE 0 END ) AS offday,
				SUM(CASE WHEN present_status = 'H' THEN 1 ELSE 0 END ) AS holiday,
			");
		$this->db->from("pr_emp_shift_log");
		// $this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		if($user_level!='All'){
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		}else{
			$this->db->where("pr_emp_shift_log.unit_id", $unit_name);
		}
		$this->db->where("pr_emp_shift_log.shift_log_date", $date_2);
		$data_2 = $this->db->get()->row();
		$data['all_present_2'] = $data_2->present;
		$data['all_absent_2'] = $data_2->absent;
		$data['all_leave_2'] = $data_2->leaves;
		$data['all_offday_2'] = $data_2->offday;
		$data['all_holiday_2'] = $data_2->holiday;


		$this->db->distinct();
		$this->db->select("
				SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END ) AS present,
				SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END ) AS absent,
				SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END ) AS leaves,
				SUM(CASE WHEN present_status = 'W' THEN 1 ELSE 0 END ) AS offday,
				SUM(CASE WHEN present_status = 'H' THEN 1 ELSE 0 END ) AS holiday,
			");
		$this->db->from("pr_emp_shift_log");
		// $this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		if($user_level!='All'){
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		}else{
			$this->db->where("pr_emp_shift_log.unit_id", $unit_name);
		}
		$this->db->where("pr_emp_shift_log.shift_log_date", $date_3);
		$data_3 = $this->db->get()->row();
		$data['all_present_3'] = $data_3->present;
		$data['all_absent_3'] = $data_3->absent;
		$data['all_leave_3'] = $data_3->leaves;
		$data['all_offday_3'] = $data_3->offday;
		$data['all_holiday_3'] = $data_3->holiday;


		$this->db->distinct();
		$this->db->select("
				SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END ) AS present,
				SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END ) AS absent,
				SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END ) AS leaves,
				SUM(CASE WHEN present_status = 'W' THEN 1 ELSE 0 END ) AS offday,
				SUM(CASE WHEN present_status = 'H' THEN 1 ELSE 0 END ) AS holiday,
			");
		$this->db->from("pr_emp_shift_log");
		// $this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		if($user_level!='All'){
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		}else{
			$this->db->where("pr_emp_shift_log.unit_id", $unit_name);
		}
		$this->db->where("pr_emp_shift_log.shift_log_date", $date_4);
		$data_4 = $this->db->get()->row();
		$data['all_present_4'] = $data_4->present;
		$data['all_absent_4'] = $data_4->absent;
		$data['all_leave_4'] = $data_4->leaves;
		$data['all_offday_4'] = $data_4->offday;
		$data['all_holiday_4'] = $data_4->holiday;


		$this->db->distinct();
		$this->db->select("
				SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END ) AS present,
				SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END ) AS absent,
				SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END ) AS leaves,
				SUM(CASE WHEN present_status = 'W' THEN 1 ELSE 0 END ) AS offday,
				SUM(CASE WHEN present_status = 'H' THEN 1 ELSE 0 END ) AS holiday,
			");
		$this->db->from("pr_emp_shift_log");
		// $this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		if($user_level!='All'){
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		}else{
			$this->db->where("pr_emp_shift_log.unit_id", $unit_name);
		}
		$this->db->where("pr_emp_shift_log.shift_log_date", $date_5);
		$data_5 = $this->db->get()->row();
		$data['all_present_5'] = $data_5->present;
		$data['all_absent_5'] = $data_5->absent;
		$data['all_leave_5'] = $data_5->leaves;
		$data['all_offday_5'] = $data_5->offday;
		$data['all_holiday_5'] = $data_5->holiday;


		$this->db->distinct();
		$this->db->select("
				SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END ) AS present,
				SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END ) AS absent,
				SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END ) AS leaves,
				SUM(CASE WHEN present_status = 'W' THEN 1 ELSE 0 END ) AS offday,
				SUM(CASE WHEN present_status = 'H' THEN 1 ELSE 0 END ) AS holiday,
			");
		$this->db->from("pr_emp_shift_log");
		// $this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		if($user_level!='All'){
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		}else{
			$this->db->where("pr_emp_shift_log.unit_id", $unit_name);
		}
		$this->db->where("pr_emp_shift_log.shift_log_date", $date_6);
		$data_6 = $this->db->get()->row();
		$data['all_present_6'] = $data_6->present;
		$data['all_absent_6'] = $data_6->absent;
		$data['all_leave_6'] = $data_6->leaves;
		$data['all_offday_6'] = $data_6->offday;
		$data['all_holiday_6'] = $data_6->holiday;


		$this->db->distinct();
		$this->db->select("
				SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END ) AS present,
				SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END ) AS absent,
				SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END ) AS leaves,
				SUM(CASE WHEN present_status = 'W' THEN 1 ELSE 0 END ) AS offday,
				SUM(CASE WHEN present_status = 'H' THEN 1 ELSE 0 END ) AS holiday,
			");
		$this->db->from("pr_emp_shift_log");
		// $this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		if($user_level!='All'){
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
		}else{
			$this->db->where("pr_emp_shift_log.unit_id", $unit_name);
		}
		$this->db->where("pr_emp_shift_log.shift_log_date", $date_7);
		$data_7 = $this->db->get()->row();
		$data['all_present_7'] = $data_7->present;
		$data['all_absent_7'] = $data_7->absent;
		$data['all_leave_7'] = $data_7->leaves;
		$data['all_offday_7'] = $data_7->offday;
		$data['all_holiday_7'] = $data_7->holiday;

	    return $data;
	}












	// old code


	function department_attendance_summary($report_date, $unit_id)
	{
		$query = $this->db->select()->where('unit_id', $unit_id)->order_by('dept_name')->get('pr_dept');
		//echo $num = $query->num_rows();
		$data = array();
		foreach($query->result() as $rows)
		{
			$data['cat_name'][] = $rows->dept_name;

			$all_emp_id = $this->get_department_emp_by_id($rows->dept_id, $unit_id);

			if(!empty($all_emp_id))
			{
				$data['daily_att_sum'][] = $this->daily_attendance_summary($report_date, $all_emp_id);
			}
			else
			{
				$data['daily_att_sum'][] = '';
			}

		/*
		$emp_desig = array(
								0 => array(21),
								1 => array(115),
								2 => array(1,3,4,187),
								3 => array(76),
								4 => array(39,150,188)
             					);*/
		$emp_desig =	$this->get_department_section_line_unit_wise($unit_id);
			//echo $emp_desig[0]."---";
			for($i=0; $i<6; $i++)
			{
				$all_desig_emp_id_by_dept = $this->desig_emp_id_by_dept($rows->dept_id,$emp_desig[$i]);
				//echo $count_all_desig_emp_id_by_dept = count($all_desig_emp_id_by_dept);
				//echo  $all_desig_emp_id_by_line."---";
				if(!empty($all_desig_emp_id_by_dept))
				{
					$data['remarks_daily_att_sum'][$i][] = $this->daily_attendance_summary($report_date, $all_desig_emp_id_by_dept);
				}
				else
				{
					$data['remarks_daily_att_sum'][$i][] = "null";
				}
				//echo $i;
			}
		}
		return $data;

	}

	function get_department_emp_by_id($dept_id, $unit_id)
	{
		//$emp_cat = array(1,2);
		$query = $this->db->select('emp_id')->where('unit_id', $unit_id)->where('emp_dept_id', $dept_id)->get('pr_emp_com_info');
		$data = array();
		foreach($query->result() as $rows)
		{
			$data[] = $rows->emp_id;
		}
		return $data;
	}

	function desig_emp_id_by_dept($dept_id,$emp_desig)
	{
		//$emp_cat = array(1,2);
		$query = $this->db->select('emp_id')->where('emp_dept_id',$dept_id)->where_in('emp_desi_id',$emp_desig)->get('pr_emp_com_info');
		$data = array();
		//echo $this->db->last_query();
		foreach($query->result() as $rows)
		{
			$data[] = $rows->emp_id;
			//echo $rows->emp_id."---";
		}
		return $data;
	}


	function section_attendance_summary($report_date, $unit_id)
	{
		$query = $this->db->select()->where('unit_id', $unit_id)->order_by('sec_name')->get('pr_section');
		//echo $num = $query->num_rows();
		$data = array();
		foreach($query->result() as $rows)
		{
			$data['cat_name'][] = $rows->sec_name;

			$all_emp_id = $this->get_section_emp_by_id($rows->sec_id, $unit_id);

			if(!empty($all_emp_id))
			{
				$data['daily_att_sum'][] = $this->daily_attendance_summary($report_date, $all_emp_id);
			}
			else
			{
				$data['daily_att_sum'][] = '';
			}

			/*
			$emp_desig = array(
								0 => array(21),
								1 => array(115),
								2 => array(78,79,112),
								3 => array(76),
								4 => array(102)
             					); */
			$emp_desig =	$this->get_department_section_line_unit_wise($unit_id);

			//echo $emp_desig[0]."---";
			for($i=0; $i<6; $i++)
			{
				$all_desig_emp_id_by_section = $this->desig_emp_id_by_section($rows->sec_id,$emp_desig[$i]);
				//echo  $all_desig_emp_id_by_line."---";
				if(!empty($all_desig_emp_id_by_section))
				{
					$data['remarks_daily_att_sum'][$i][] = $this->daily_attendance_summary($report_date, $all_desig_emp_id_by_section);
				}
				else
				{
					$data['remarks_daily_att_sum'][$i][] = "null";
				}
				//echo $i;
			}
		}
		return $data;

	}

	function get_section_emp_by_id($sec_id, $unit_id)
	{
		//$emp_cat = array(1,2);
		$query = $this->db->select('emp_id')->where('unit_id', $unit_id)->where('emp_sec_id', $sec_id)->get('pr_emp_com_info');
		$data = array();
		foreach($query->result() as $rows)
		{
			$data[] = $rows->emp_id;
		}
		return $data;
	}

	function line_attendance_summary($report_date, $unit_id)
	{
		$arr=array('32','61');
		$query = $this->db->select()->where('unit_id', $unit_id)->where_not_in('line_id',$arr)->order_by('line_name')->get('pr_line_num');
		//echo $num = $query->num_rows();

		$data = array();
		foreach($query->result() as $rows)
		{
			$data['cat_name'][] = $rows->line_name;

			$all_emp_id = $this->get_line_emp_by_id($rows->line_id, $unit_id);

			if(!empty($all_emp_id))
			{
				$data['daily_att_sum'][] = $this->daily_attendance_summary($report_date, $all_emp_id);
			}
			else
			{
				$data['daily_att_sum'][] = '';
			}
			/*
			$emp_desig = array(
								0 => array(21),
								1 => array(115),
								2 => array(1,3,4,187),
								3 => array(76),
								4 => array(39,150,188)
             					); */
			$emp_desig =	$this->get_department_section_line_unit_wise($unit_id);
			// echo "<pre>"; print_r($emp_desig); exit();
			//echo $emp_desig[0]."---";
			for($i=0; $i<6; $i++)
			{
				$all_desig_emp_id_by_line = $this->desig_emp_id_by_line($rows->line_id,$emp_desig[$i]);
				//echo  $all_desig_emp_id_by_line."---";
				if(!empty($all_desig_emp_id_by_line))
				{
					$data['remarks_daily_att_sum'][$i][] = $this->daily_attendance_summary($report_date, $all_desig_emp_id_by_line);
				}
				else
				{
					$data['remarks_daily_att_sum'][$i][] = "null";
				}
				//echo $i;
			}
		}
		return $data;

	}

	function get_line_emp_by_id($line_id, $unit_id)
	{
		//$emp_cat = array(1,2);

		$query = $this->db->select('emp_id')->where('unit_id', $unit_id)->where('emp_line_id', $line_id)->get('pr_emp_com_info');
		$data = array();
		foreach($query->result() as $rows)
		{
			$data[] = $rows->emp_id;
		}
		return $data;
	}


	function desig_emp_id_by_section($section_id,$emp_desig)
	{
		//$emp_cat = array(1,2);
		$query = $this->db->select('emp_id')->where('emp_sec_id',$section_id)->where_in('emp_desi_id',$emp_desig)->get('pr_emp_com_info');
		$data = array();
		foreach($query->result() as $rows)
		{
			$data[] = $rows->emp_id;
			//echo $rows->emp_id."---";
		}
		return $data;
	}

	function desig_emp_id_by_line($line_id,$emp_desig)
	{
		//$emp_cat = array(1,2);
		// print_r($line_id ."===".$emp_desig);exit;
		$query = $this->db->select('emp_id')->where('emp_line_id',$line_id)->where_in('emp_desi_id',$emp_desig)->get('pr_emp_com_info');
		$data = array();
		foreach($query->result() as $rows)
		{
			$data[] = $rows->emp_id;
			//echo $rows->emp_id."---";
		}
		return $data;
	}

	function daily_attendance_summary($report_date, $all_emp_id)
	{
		$data =array();

		$this->db->select('emp_id');
		$this->db->from("pr_emp_shift_log");
		$this->db->where_in("emp_id", $all_emp_id);
		$this->db->where("shift_log_date", $report_date);
		$this->db->where("pr_emp_shift_log.present_status !=", "W");
		$this->db->group_by('emp_id');
		$query = $this->db->get();

		$this->db->select('emp_id');
		$this->db->from("pr_emp_shift_log");
		$this->db->where_in("emp_id", $all_emp_id);
		$this->db->where("shift_log_date", $report_date);
		$this->db->where("pr_emp_shift_log.present_status !=", "H");
		$this->db->group_by('emp_id');
		$query2 = $this->db->get();

		if($query->num_rows() == 0)
		{
			$data['all_emp'] 		= 0;
			$data['all_present'] 	= 0;
			$data['all_leave'] 		= 0;
			$data['all_absent'] 	= 0;
			$data['all_late'] 		= 0;
			$data['all_male'] 		= 0;
			$data['all_female'] 	= 0;
		}
		elseif($query2->num_rows() == 0)
		{
			$data['all_emp'] 		= 0;
			$data['all_present'] 	= 0;
			$data['all_leave'] 		= 0;
			$data['all_absent'] 	= 0;
			$data['all_late'] 		= 0;
			$data['all_male'] 		= 0;
			$data['all_female'] 	= 0;
		}
		else
		{
			$data['all_emp'] = $query->num_rows();
			//echo $this->db->last_query();
			$all_emp_id = $query->result_array();
			$it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($all_emp_id));
			$all_emp_id = iterator_to_array($it, false);
			//print_r($all_emp_id);

			$this->db->select("pr_emp_shift_log.emp_id");
			$this->db->from("pr_emp_shift_log");
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
			$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.in_time !=", "00:00:00");
			$this->db->group_by('pr_emp_shift_log.emp_id');
			$data['all_present'] = $this->db->get()->num_rows();

			$this->db->select("emp_id");
			$this->db->from("pr_leave_trans");
			$this->db->where_in("emp_id", $all_emp_id);
			$this->db->where("start_date", $report_date);
			$this->db->group_by('emp_id');
			$data['all_leave'] = $this->db->get()->num_rows();

			$this->db->select("pr_emp_shift_log.emp_id");
			$this->db->from("pr_emp_shift_log");
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
			$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.in_time", "00:00:00");
			$this->db->group_by('pr_emp_shift_log.emp_id');
			$all_absent = $this->db->get()->num_rows();
			$all_absent = $all_absent - $data['all_leave'];
			$data['all_absent'] = $all_absent;



			$this->db->select("pr_emp_shift_log.emp_id");
			$this->db->from("pr_emp_shift_log");
			$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
			$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.late_status",1);
			$this->db->group_by('pr_emp_shift_log.emp_id');
			$data['all_late'] = $this->db->get()->num_rows();

			$this->db->select("pr_emp_per_info.emp_id");
			$this->db->from('pr_emp_per_info');
			$this->db->where_in("pr_emp_per_info.emp_id", $all_emp_id);
			$this->db->where("pr_emp_per_info.emp_sex = 1");
			$data['all_male'] = $this->db->get()->num_rows();

			$this->db->select("pr_emp_per_info.emp_id");
			$this->db->from('pr_emp_per_info');
			$this->db->where_in("pr_emp_per_info.emp_id", $all_emp_id);
			$this->db->where("pr_emp_per_info.emp_sex = 2");
			$data['all_female'] = $this->db->get()->num_rows();
		}
		// echo "<pre>";print_r($data);exit;
		return $data;
	}
	////////////////Department_section_line_unit_wise
	function get_department_section_line_unit_wise($unit_id)
	{

		$data = array();
		if($unit_id ==1){
		$data = array(
						0 => array(67,38,62,57,42,26),
						1 => array(5,6,149,63,28,45,33,43),
						2 => array(7,8,20,31,32,35,44,48,572,573,574,575,577,578,579),
						3 => array(23,46,29,51,473),
						4 => array(39),
						5 => array(106,30,417,356)
						);

		return $data;

		}
		if($unit_id ==2){ //This For Lucky Star
		$data = array(
						0 => array(91, 92, 111,121),//Line Chief a,b,c,d,
						1 => array(73, 76, 87, 88, 110, 126),//cutting,fini,a,b,c,d--super
						2 => array(78, 79, 84,112,254),//jr,operator,GR,Sr
						3 => array(96, 127, 130,352),//helper,input man,Trainee
						4 => array(116), //Line Iron Man
						5 => array(85,106,124,246,350,354,372,423) //Finishing Quality Ins.
						);
		return $data;
		}
		if($unit_id ==3){
		$data = array(
						0 => array(144,160),
						1 => array(105),
						2 => array(77,107,133,137,139,141,159),
						3 => array(142),
						4 => array(9),
						5 => array(106)
						);
		return $data;
		}

		if($unit_id ==4){
			$data = array(
				0 => array(1),
				1 => array(2),
				2 => array(648,671,705,724),//operator
				3 => array(615),//helper
				4 => array(653,667,696,676,667),//iron man
				5 => array(645,663,666)//input man
			);
			return $data;
		}
	}
///////////////////////////line_logout_summary///////////////////////////
function line_logout_summary($report_date, $unit_id)
	{
		$query = $this->db->select()->where('unit_id', $unit_id)->order_by('line_name')->get('pr_line_num');
		//echo $num = $query->num_rows();
		//$data = array();
		foreach($query->result() as $rows)
		{
			$data['cat_name'][] = $rows->line_name;

			$all_emp_id = $this->get_line_emp_by_id($rows->line_id, $unit_id);


		}
		return $all_emp_id;

	}

		function get_line_emp_logout($line_id, $unit_id, $report_date, $first_time, $secoend_time)
		{
			//$emp_cat = array(1,2);
			// echo "<pre>";print_r($first_time.'==='.$secoend_time);exit;

			$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id, SUM(pr_emp_shift_log.ot) as ot_hour, SUM(pr_emp_shift_log.extra_ot_hour) as extra_ot_hour,SUM(pr_emp_shift_log.modify_eot) as modify_eot,SUM(pr_emp_shift_log.deduction_hour) as deduction_hour");
			// $this->db->select("pr_emp_shift_log.in_time");
			// $this->db->select("pr_emp_shift_log.out_time");
			$this->db->from("pr_emp_com_info");
			$this->db->from("pr_emp_shift_log");
			$this->db->where("pr_emp_com_info.unit_id", $unit_id);
			$this->db->where("pr_emp_com_info.emp_line_id", $line_id);
			$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.out_time BETWEEN '$first_time' AND '$secoend_time'");
			$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
			$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");
			$this->db->group_by("pr_emp_com_info.emp_line_id");
			$query = $this->db->get();
			// echo "<pre>"; print_r($query->result()); exit();
			//$data['num_rows'] = $num_rows;
			// echo $this->db->last_query();exit;
			if($query->num_rows() > 0)
			{
				$data['emp_id'] 		= $query->row()->emp_id;
				$data['ot_hour'] 		= $query->row()->ot_hour;
				$data['extra_ot_hour'] 	= $query->row()->extra_ot_hour;
				$data['modify_eot'] 	= $query->row()->modify_eot;
				$data['deduction_hour']	= $query->row()->deduction_hour;
			}else{
				$data['ot_hour'] 		= 0;
				$data['extra_ot_hour'] 	= 0;
				$data['emp_id'] 		= 0;
				$data['modify_eot'] 	= 0;
				$data['deduction_hour']	= 0;
			}
			// echo "<pre>";print_r($data);exit;
			return $data;
		}


		/*
			Name 		:	get_dept_emp_logout
			Param 		:	dept_id, unit_id, report_date, first_time, second_time
			ShortDesc	:
			LongDesc	:	get number of employee unit wise and dept wise
							get total ot_hour of those emp
							get total extra_ot_hour of those emp
							get total modify_eot of those emp
							get total deduction hour of those emp
							from 'pr_emp_com_info' table
							from 'pr_emp_shift_log' table
							where employee are loging out between first_time and second_time

			Author 		:	Ismail
			Date 		:	24-9-17

			ModifiedBy	:
			ModifiedDate:
			ModifiedPart:

			ControllerFn:	daily_logout_report
		*/
		function get_dept_emp_logout($dept_id, $unit_id, $report_date, $first_time, $secoend_time)
		{
			//$emp_cat = array(1,2);
			$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id, SUM(pr_emp_shift_log.ot) as ot_hour, SUM(pr_emp_shift_log.extra_ot_hour) as extra_ot_hour,SUM(pr_emp_shift_log.modify_eot) as modify_eot,SUM(pr_emp_shift_log.deduction_hour) as deduction_hour");
			$this->db->from("pr_emp_com_info");
			$this->db->from("pr_emp_shift_log");
			$this->db->where("pr_emp_com_info.unit_id", $unit_id);
			$this->db->where("pr_emp_com_info.emp_dept_id", $dept_id);
			$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.out_time BETWEEN '$first_time' AND '$secoend_time'");
			$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
			$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");

			$query = $this->db->get();
			$num_rows = $query->num_rows();
			//$data['num_rows'] = $num_rows;

			//echo $this->db->last_query();
			if($num_rows > 0)
			{
				foreach($query->result() as $rows)
				{
					$data['emp_id'] 		= $rows->emp_id;
					$data['ot_hour'] 		= $rows->ot_hour;
					$data['extra_ot_hour'] 	= $rows->extra_ot_hour;
					$data['modify_eot'] 	= $rows->modify_eot;
					$data['deduction_hour']	= $rows->deduction_hour;
					//echo $rows->emp_id."---";
				}
			}else{
				$data['ot_hour'] 		= 0;
				$data['extra_ot_hour'] 	= 0;
				$data['emp_id'] 		= 0;
				$data['modify_eot'] 	= 0;
				$data['deduction_hour']	= 0;
			}
			return $data;
		}


		/*
			Name 		:	get_sec_emp_logout
			Param 		:	sec_id, unit_id, report_date, first_time, second_time
			ShortDesc	:
			LongDesc	:	get number of employee unit wise and section wise
							get total ot_hour of those emp
							get total extra_ot_hour of those emp
							get total modify_eot of those emp
							get total deduction hour of those emp
							from 'pr_emp_com_info' table
							from 'pr_emp_shift_log' table
							where employee are loging out between first_time and second_time

			Author 		:	Ismail
			Date 		:	24-9-17

			ModifiedBy	:
			ModifiedDate:
			ModifiedPart:

			ControllerFn:	daily_logout_report
		*/
		function get_sec_emp_logout($sec_id, $unit_id, $report_date, $first_time, $secoend_time)
		{
			//$emp_cat = array(1,2);
			$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id, SUM(pr_emp_shift_log.ot) as ot_hour, SUM(pr_emp_shift_log.extra_ot_hour) as extra_ot_hour,SUM(pr_emp_shift_log.modify_eot) as modify_eot,SUM(pr_emp_shift_log.deduction_hour) as deduction_hour");
			$this->db->from("pr_emp_com_info");
			$this->db->from("pr_emp_shift_log");
			$this->db->where("pr_emp_com_info.unit_id", $unit_id);
			$this->db->where("pr_emp_com_info.emp_sec_id", $sec_id);
			$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.out_time BETWEEN '$first_time' AND '$secoend_time'");
			$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
			$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");

			$query = $this->db->get();
			$num_rows = $query->num_rows();
			//$data['num_rows'] = $num_rows;

			//echo $this->db->last_query();
			if($num_rows > 0)
			{
				foreach($query->result() as $rows)
				{
					$data['emp_id'] 		= $rows->emp_id;
					$data['ot_hour'] 		= $rows->ot_hour;
					$data['extra_ot_hour'] 	= $rows->extra_ot_hour;
					$data['modify_eot'] 	= $rows->modify_eot;
					$data['deduction_hour']	= $rows->deduction_hour;
					//echo $rows->emp_id."---";
				}
			}else{
				$data['ot_hour'] 		= 0;
				$data['extra_ot_hour'] 	= 0;
				$data['emp_id'] 		= 0;
				$data['modify_eot'] 	= 0;
				$data['deduction_hour']	= 0;
			}
			return $data;
		}


	////////////////////////////////emp_present_linewise	///////////////

	function get_emp_present_linewise($line_id, $unit_id, $report_date)
	{
		$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id_present");
		$this->db->from("pr_emp_com_info");
		$this->db->from("pr_emp_shift_log");
		$this->db->where("pr_emp_com_info.unit_id", $unit_id);
		$this->db->where("pr_emp_com_info.emp_line_id", $line_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
		$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");
		$query = $this->db->get();
		$num_rows = $query->num_rows();
		//$data['num_rows'] = $num_rows;
		//echo $this->db->last_query();
		// echo "<pre>";print_r($query->result());exit;
		if($num_rows > 0)
		{
			$data['emp_id_present'] = $query->row()->emp_id_present;
		}else{
				$data['emp_id_present'] = 0;
		}
		return $data;
	}

	/*
		Name 		:	get_emp_present_deptwise
		Author 		:	Ismail
		Date 		:	23-9-17

		ModifiedBy	:
		ModifiedDate:
		ModifiedPart:
	*/
	function get_emp_present_deptwise($dept_id, $unit_id, $report_date)
	{
		$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id_present");
		$this->db->from("pr_emp_com_info");
		$this->db->from("pr_emp_shift_log");
		$this->db->where("pr_emp_com_info.unit_id", $unit_id);
		$this->db->where("pr_emp_com_info.emp_dept_id", $dept_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
		$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");
		$query = $this->db->get();
		$num_rows = $query->num_rows();
		//$data['num_rows'] = $num_rows;

		//echo $this->db->last_query();
		if($num_rows > 0)
		{
			foreach($query->result() as $rows)
			{
				$data['emp_id_present'] = $rows->emp_id_present;

			}
		}else{
				$data['emp_id_present'] = 0;
		}
		return $data;
	}

	/*
		Name 		:	get_emp_present_sectionwise
		Author 		:	Ismail
		Date 		:	23-9-17

		ModifiedBy	:
		ModifiedDate:
		ModifiedPart:
	*/
	function get_emp_present_sectionwise($sec_id, $unit_id, $report_date)
	{
		$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id_present");
		$this->db->from("pr_emp_com_info");
		$this->db->from("pr_emp_shift_log");
		$this->db->where("pr_emp_com_info.unit_id", $unit_id);
		$this->db->where("pr_emp_com_info.emp_sec_id", $sec_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
		$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");
		$query = $this->db->get();
		$num_rows = $query->num_rows();
		//$data['num_rows'] = $num_rows;

		//echo $this->db->last_query();
		if($num_rows > 0)
		{
			foreach($query->result() as $rows)
			{
				$data['emp_id_present'] = $rows->emp_id_present;

			}
		}else{
				$data['emp_id_present'] = 0;
		}
		return $data;
	}


///////////////////////////////all_emp_present_error	///////////////

function get_all_emp_present_error($line_id, $unit_id, $report_date)
				{
					$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id_present_error");
					$this->db->from("pr_emp_com_info");
					$this->db->from("pr_emp_shift_log");
					$this->db->where("pr_emp_com_info.unit_id", $unit_id);
					$this->db->where("pr_emp_com_info.emp_line_id", $line_id);
					$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
					$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
					$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");
					$this->db->where("pr_emp_shift_log.out_time	 = '00:00:00'");
					$query = $this->db->get();
					$num_rows = $query->num_rows();
					//$data['num_rows'] = $num_rows;

					//echo $this->db->last_query();
					if($num_rows > 0)
					{
						foreach($query->result() as $rows)
						{
							$data['emp_id_present_error'] = $rows->emp_id_present_error;

						}
					}else{
							$data['emp_id_present_error'] = 0;
					}
					return $data;
				}



		/*
			Name 		:	get_all_emp_present_error_dept_wise
			Param 		:	dept_id, unit_id, report_date
			ShortDesc	:	get number of emp by emp_id_present_error
							from 'pr_emp_com_info' table
							from 'pr_emp_shift_log' table
							where emp out time is not found or out_time = 00:00:00
			LongDesc	:

			Author 		:	Ismail
			Date 		:	24-9-17

			ModifiedBy	:
			ModifiedDate:
			ModifiedPart:

			ControllerFn:	daily_logout_report
		*/
		function get_all_emp_present_error_dept_wise($dept_id, $unit_id, $report_date)
		{
			$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id_present_error");
			$this->db->from("pr_emp_com_info");
			$this->db->from("pr_emp_shift_log");
			$this->db->where("pr_emp_com_info.unit_id", $unit_id);
			$this->db->where("pr_emp_com_info.emp_dept_id", $dept_id);
			$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
			$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");
			$this->db->where("pr_emp_shift_log.out_time	 = '00:00:00'");
			$query = $this->db->get();
			$num_rows = $query->num_rows();
			//$data['num_rows'] = $num_rows;

			//echo $this->db->last_query();
			if($num_rows > 0)
			{
				foreach($query->result() as $rows)
				{
					$data['emp_id_present_error'] = $rows->emp_id_present_error;

				}
			}else{
					$data['emp_id_present_error'] = 0;
			}
			return $data;
		}


		/*
			Name 		:	get_all_emp_present_error_section_wise
			Param 		:	sec_id, unit_id, report_date
			ShortDesc	:	get number of emp by emp_id_present_error
							from 'pr_emp_com_info' table
							from 'pr_emp_shift_log' table
							where emp out time is not found or out_time = 00:00:00
			LongDesc	:

			Author 		:	Ismail
			Date 		:	24-9-17

			ModifiedBy	:
			ModifiedDate:
			ModifiedPart:

			ControllerFn:	daily_logout_report
		*/
		function get_all_emp_present_error_section_wise($sec_id, $unit_id, $report_date)
		{
			$this->db->select("count(DISTINCT pr_emp_shift_log.emp_id) as emp_id_present_error");
			$this->db->from("pr_emp_com_info");
			$this->db->from("pr_emp_shift_log");
			$this->db->where("pr_emp_com_info.unit_id", $unit_id);
			$this->db->where("pr_emp_com_info.emp_sec_id", $sec_id);
			$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
			$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");
			$this->db->where("pr_emp_shift_log.out_time	 = '00:00:00'");
			$query = $this->db->get();
			$num_rows = $query->num_rows();
			//$data['num_rows'] = $num_rows;

			//echo $this->db->last_query();
			if($num_rows > 0)
			{
				foreach($query->result() as $rows)
				{
					$data['emp_id_present_error'] = $rows->emp_id_present_error;

				}
			}else{
					$data['emp_id_present_error'] = 0;
			}
			return $data;
		}


////////////////////////////////

	/*
		Name 		:	get_dept_unit_wise
		Param 		:	unit_id
		ShortDesc	:	get dept id and name from 'pr_dept' table
						by unit_id
		LongDesc	:

		Author 		:	Ismail
		Date 		:	24-9-17

		ModifiedBy	:
		ModifiedDate:
		ModifiedPart:

		ControllerFn:	daily_logout_report
	*/
	function get_dept_unit_wise($unit_id)
	{
		$this->db->where('unit_id', $unit_id);

		$this->db->order_by('dept_name', 'ASC');

		return $this->db->get('pr_dept')->result_array();
	}


	/*
		Name 		:	get_sec_unit_wise
		Param 		:	unit_id
		ShortDesc	:	get section id and name from 'pr_section' table
						by unit_id
		LongDesc	:

		Author 		:	Ismail
		Date 		:	24-9-17

		ModifiedBy	:
		ModifiedDate:
		ModifiedPart:

		ControllerFn:	daily_logout_report
	*/
	function get_sec_unit_wise($unit_id)
	{
		$this->db->where('unit_id', $unit_id);

		$this->db->order_by('sec_name', 'ASC');

		return $this->db->get('pr_section')->result_array();
	}


	/*
		Name 		:	get_line_unit_wise
		Param 		:	unit_id
		ShortDesc	:	get line id and name from 'pr_line_num' table
						by unit_id
		LongDesc	:

		Author 		:	Ismail
		Date 		:	24-9-17

		ModifiedBy	:
		ModifiedDate:
		ModifiedPart:

		ControllerFn:	daily_logout_report
	*/
	function get_line_unit_wise($unit_id)
	{
		$this->db->where('unit_id', $unit_id);

		$this->db->order_by('line_name', 'ASC');

		return $this->db->get('pr_line_num')->result_array();
	}


	/*
		Name 		:	get_logout_emp
		Param 		:
		ShortDesc	:	get logout chart (first_time and second_time)
						from 'pr_logout_emp' table
		LongDesc	:

		Author 		:	Ismail
		Date 		:	24-9-17

		ModifiedBy	:
		ModifiedDate:
		ModifiedPart:

		ControllerFn:	daily_logout_report
	*/
	function get_logout_emp()
	{
		$this->db->order_by('id', 'ASC');

			return $this->db->get('pr_logout_emp')->result_array();
	}

	function get_ramadan_logout_emp()
	{
		 $this->db->order_by('id', 'ASC');
		 return $this->db->get('pr_ramadan_logout_emp')->result_array();

	}


}
?>

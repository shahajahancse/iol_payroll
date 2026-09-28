<?php
	class Dashboard_model extends CI_Model {

	    function __construct()
		{
			parent::__construct();

			/* Standard Libraries */
	    }

	    function dashboard($start_date, $end_date)
	    {
			$data = $this->count_dept_section_deg_line();
			$all_id = $this->get_emp_id();
			$data['attendance'] = $this->attendance_status('2019-09-03', $all_id);
			$data['manpower'] = $this->man_power_status('2019-09-03', $all_id);

			// Monthly Employee Status
			$data['monthly_employee']['total_join'] = $this->monthly_join_emp('2019-09-01', '2019-09-31');
			$data['monthly_employee']['total_resign'] = $this->monthly_resign_emp('2019-09-01', '2019-09-31');
			$data['monthly_employee']['total_left'] = $this->monthly_left_emp('2019-09-01', '2019-09-31');

			// Last Month Salary Expense
			$data['month_wise_salary'] = $this->salary_month_expense('2019-09-01', '2019-09-31');

		    return $data;
	    }

		function salary_month_expense($start_date, $end_date, $department = 0, $section = 0, $line = 0)
		{
			$data = array();
			$expensive = $this->month_wise_expense($start_date, $end_date, $department, $section, $line);
			$data['salary'] 		  = $expensive['net_pay'];
			$data['over_time'] 		  = $expensive['ot_amount'];
			$data['extra_over_time']  = $expensive['eot_amount'];
			$data['attendance_bonus'] = $expensive['att_bonus'];
			return array($data);
		}

		function attendance_status($date, $all_id)
		{
			$data = array();
			$attendance_summary = $this->attendance_summary($date, $all_id);
			// Daily Attendance Status
			$data['daily_total_present'] = $attendance_summary['all_present'];
			$data['daily_total_absent'] = $attendance_summary['all_absent'];
			$data['daily_total_leave'] = $attendance_summary['all_leave'];
			$data['daily_total_late'] = $attendance_summary['all_late'];

			return array($data);
		}

		function man_power_status($date, $all_id)
		{
			$data = array();
			$attendance_summary = $this->attendance_summary($date, $all_id);
			// Daily Total Manpower Status
			$data['daily_total_employee'] = $attendance_summary['all_emp'];
			$data['daily_total_male'] = $attendance_summary['all_male'];
			$data['daily_total_female'] = $attendance_summary['all_female'];

		    return array($data);
		}

		function count_dept_section_deg_line()
		{
			$data = array();
			$this->db->select('*');
	        $this->db->from('emp_depertment');
	        $emp_depertment = $this->db->get()->num_rows();
	        $data['department'] = $emp_depertment;

	        $this->db->select('*');
            $this->db->from('pr_section');
            $pr_section = $this->db->get()->num_rows();
            $data['section'] = $pr_section;

            $this->db->select('*');
            $this->db->from('pr_designation');
            $pr_designation = $this->db->get()->num_rows();
            $data['designation'] = $pr_designation;

            $this->db->select('*');
            $this->db->from('pr_line_num');
            $pr_line_num = $this->db->get()->num_rows();
            $data['line'] = $pr_line_num;

			return $data;
		}

		function get_dept_section_line()
		{
			$data = array();
			$this->db->select('*');
			$this->db->from('emp_depertment');
			$this->db->order_by('dept_id', 'asc');
			$emp_depertment = $this->db->get()->result();
			$data['department'] = $emp_depertment;

			$this->db->select('*');
			$this->db->from('pr_section');
			$this->db->order_by('sec_id', 'asc');
			$pr_section = $this->db->get()->result();
			$data['section'] = $pr_section;

			$this->db->select('*');
			$this->db->from('pr_line_num');
			$this->db->order_by('line_id', 'asc');
			$pr_line_num = $this->db->get()->result();
			$data['line'] = $pr_line_num;

			return $data;
		}

		function monthly_join_emp($start_date, $end_date, $emp_id = array())
		{

			$emp_cat = array(1,2);

			$this->db->select('pr_emp_com_info.emp_id');
			$this->db->from('pr_emp_com_info');
			//$this->db->where_in('pr_emp_com_info.emp_cat_id',$emp_cat);
			$this->db->where("pr_emp_com_info.emp_join_date >=", $start_date);
			$this->db->where("pr_emp_com_info.emp_join_date <=", $end_date);
			if (!empty($emp_id)) {
				$this->db->where_in('pr_emp_com_info.emp_id', $emp_id);
			}
			//$query = $this->db->get();
			/*echo "<pre>";
			echo $this->db->last_query();exit;*/
			$query = $this->db->get()->num_rows();

			return $query;
		}


    	function monthly_resign_emp($start_date, $end_date, $emp_id  = array())
		{
			$this->db->select('pr_emp_resign_history.emp_id');
			$this->db->from('pr_emp_resign_history');
			$this->db->where("pr_emp_resign_history.resign_date >=", $start_date);
			$this->db->where("pr_emp_resign_history.resign_date <=", $end_date);
			if (!empty($emp_id)) {
				$this->db->where_in('pr_emp_resign_history.emp_id', $emp_id);
			}
			$query = $this->db->get()->num_rows();

			return $query;

		}


		function monthly_left_emp($start_date, $end_date, $emp_id = array())
		{
			$this->db->select('pr_emp_left_history.emp_id');
			$this->db->from('pr_emp_left_history');
			$this->db->where("pr_emp_left_history.left_date >=", $start_date);
			$this->db->where("pr_emp_left_history.left_date <=", $end_date);
			if (!empty($emp_id)) {
				$this->db->where_in('pr_emp_left_history.emp_id', $emp_id);
			}
			$query = $this->db->get()->num_rows();

			return $query;

		}

		function get_emp_id($department = 0, $section = 0, $line = 0)
		{
			$data = array();
			$emp_cat = array(1,2);
			$this->db->select('emp_id');
			$this->db->from('pr_emp_com_info');
			$this->db->where_in('pr_emp_com_info.emp_cat_id', $emp_cat);
			if ($department) {
				$this->db->where('pr_emp_com_info.emp_dept_id', $department);
			}
			if ($section) {
				$this->db->where('pr_emp_com_info.emp_sec_id', $section);
			}
			if ($line) {
				$this->db->where('pr_emp_com_info.emp_line_id', $line);
			}
			$query = $this->db->get();

			foreach($query->result() as $rows)
			{
				$data[] = $rows->emp_id;
			}
			return $data;
		}

		function attendance_summary($report_date, $all_emp_id)
		{
			$data =array();
			//araf
			$this->db->select('pr_emp_com_info.emp_id');
			$this->db->from("pr_emp_shift_log");
			$this->db->from("pr_emp_com_info");
			$this->db->where_in("pr_emp_com_info.emp_id", $all_emp_id);
			$this->db->where("shift_log_date", $report_date);
			$this->db->where("pr_emp_shift_log.present_status !=", "W");
			$this->db->where("pr_emp_com_info.emp_cat_id !=", 4);
			$this->db->where("pr_emp_com_info.emp_id = pr_emp_shift_log.emp_id ");
			$this->db->group_by('pr_emp_com_info.emp_id');
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
				$this->db->from("pr_emp_com_info");
				$this->db->where_in("pr_emp_shift_log.emp_id", $all_emp_id);
				$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
				$this->db->where("pr_emp_shift_log.in_time", "00:00:00");
				$this->db->where("pr_emp_com_info.emp_cat_id !=", 4);
			    $this->db->where("pr_emp_com_info.emp_id = pr_emp_shift_log.emp_id ");
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
			return $data;
		}

		function month_wise_expense($start_date, $end_date, $department, $section, $line)
		{
			$column_name = "net_pay" ;
			$net_pay = $this->get_sum_column($column_name,$start_date,$end_date, $department, $section, $line);
			$all_data["net_pay"] = $net_pay;

			$column_name = "eot_amount" ;
			$eot_amount = $this->get_sum_column($column_name,$start_date,$end_date, $department, $section, $line);
			$all_data["eot_amount"] = $eot_amount;

			$column_name = "ot_amount" ;
			$ot_amount = $this->get_sum_column($column_name,$start_date,$end_date, $department, $section, $line);
			$all_data["ot_amount"] = $ot_amount;

			$column_name = "att_bonus" ;
			$att_bonus = $this->get_sum_column($column_name,$start_date,$end_date, $department, $section, $line);
			$all_data["att_bonus"] = $att_bonus;

			return $all_data;
		}

		function get_sum_column($column_name, $start_date, $end_date, $department, $section, $line)
		{
			$this->db->select_sum($column_name);
			$this->db->from("pr_pay_scale_sheet");
			$this->db->where('salary_month >=', $start_date);
			$this->db->where('salary_month <=', $end_date);
			if ($department) {
				$this->db->where('pr_pay_scale_sheet.dept_id', $department);
			}
			if ($section) {
				$this->db->where('pr_pay_scale_sheet.sec_id', $section);
			}
			if ($line) {
				$this->db->where('pr_pay_scale_sheet.line_id', $line);
			}
			$row = $this->db->get()->row();
			$result = $row->$column_name;

				if($result =='')
				{
					$result = 0;
				}

			return $result;
		}

	}

?>

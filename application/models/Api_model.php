<?php
class Api_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		/* Standard Libraries */
		$this->load->model('common_model');
	}

	function get_costing_summary_section($unit_id, $date){
		$this->db->distinct();
		$this->db->select("
			sec.id as section_id, sec.sec_name_en, sec.sec_name_bn, log.shift_log_date,
			SUM( CASE WHEN log.present_status != 'A' THEN com.gross_sal ELSE 0 END ) AS gross_salary,
			SUM( CASE WHEN log.present_status != 'A' THEN 1 ELSE 0 END ) AS present_emp,
			SUM( log.ot ) AS ot,
			SUM( log.eot ) AS eot,
		");
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('emp_section as sec');
		$this->db->from('pr_emp_shift_log as log');
		$this->db->where("sec.id = com.emp_sec_id");
		$this->db->where("log.emp_id = com.emp_id");
		$this->db->where("log.shift_log_date", $date);
		$this->db->where("com.unit_id", $unit_id);
		$this->db->order_by("sec.sec_name_en");
		$this->db->group_by("com.emp_sec_id");
		$lines = $this->db->get()->result();
		$data = array();
		foreach ($lines as $key => $r) {
			$avg_salary = 0;
			if (!empty($r->present_emp) && !empty($r->gross_salary)) {
				$avg_salary = round($r->gross_salary/$r->present_emp,2);
			}
			$ss = $this->common_model->salary_structure($avg_salary);
			$tot_ot = $r->ot + $r->eot;
			$data[] = array(
				'section_id' 	=> $r->section_id,
				'sec_name_en' 	=> $r->sec_name_en,
				'sec_name_bn' 	=> $r->sec_name_bn,
				'present_emp' 	=> $r->present_emp,
				'total_salary' 	=> $r->gross_salary,
				'avg_salary' 	=> $avg_salary,
				'total_ot' 		=> $tot_ot,
				'ot_rate' 		=> $ss['ot_rate'],
				'ot_amt' 		=> round($ss['ot_rate'] * $tot_ot, 2),
			);
		}
		return $data;
	}

	function get_costing_summary_ine($unit_id, $date){
		$this->db->distinct();
		$this->db->select("
			num.id as line_id, num.line_name_en, num.line_name_bn, log.shift_log_date,
			SUM( CASE WHEN log.present_status != 'A' THEN com.gross_sal ELSE 0 END ) AS gross_salary,
			SUM( CASE WHEN log.present_status != 'A' THEN 1 ELSE 0 END ) AS present_emp,
			SUM( log.ot ) AS ot,
			SUM( log.eot ) AS eot,
		");
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('emp_line_num as num');
		$this->db->from('pr_emp_shift_log as log');
		$this->db->where("num.id = com.emp_line_id");
		$this->db->where("log.emp_id = com.emp_id");
		$this->db->where("log.shift_log_date", $date);
		$this->db->where("com.unit_id", $unit_id);
		$this->db->order_by("num.line_name_en");
		$this->db->group_by("com.emp_line_id");
		$lines = $this->db->get()->result();
		$data = array();
		foreach ($lines as $key => $r) {
			$avg_salary = 0;
			if (!empty($r->present_emp) && !empty($r->gross_salary)) {
				$avg_salary = round($r->gross_salary/$r->present_emp,2);
			}
			$ss = $this->common_model->salary_structure($avg_salary);
			$tot_ot = $r->ot + $r->eot;
			$data[] = array(
				'line_id' 		=> $r->line_id,
				'line_name_en' 	=> $r->line_name_en,
				'line_name_bn' 	=> $r->line_name_bn,
				'present_emp' 	=> $r->present_emp,
				'total_salary' 	=> $r->gross_salary,
				'avg_salary' 	=> $avg_salary,
				'total_ot' 		=> $tot_ot,
				'ot_rate' 		=> $ss['ot_rate'],
				'ot_amt' 		=> round($ss['ot_rate'] * $tot_ot, 2),
			);
		}
		return $data;
	}

    function get_attn_section($unit_id, $date) {
        $this->db->select("
            sec.id as section_id, sec.sec_name_en, sec.sec_name_bn, log.shift_log_date,
            SUM( CASE WHEN log.emp_id 	      != '' THEN 1 ELSE 0 END ) AS all_emp,
            SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS all_present,
            SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS all_absent,
            SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS all_leave,
            SUM( CASE WHEN log.late_status    = 1 THEN 1 ELSE 0 END ) AS all_late,
        ");
		$this->db->from("pr_emp_shift_log as log");
		$this->db->join('pr_emp_com_info as com', 'log.emp_id = com.emp_id', 'left');
		$this->db->join('emp_section as sec', 'com.emp_sec_id = sec.id', 'left');

		$this->db->where("com.unit_id", $unit_id);
		$this->db->where("log.shift_log_date", $date);
		$this->db->order_by("sec.sec_name_en");
		$this->db->group_by("com.emp_sec_id");
		$results = $this->db->get()->result();
		return $results;
    }
    function get_attn_line($unit_id, $date) {
        $this->db->select("
            num.id as line_id, num.line_name_en, num.line_name_bn, log.shift_log_date,
            SUM( CASE WHEN log.emp_id 	      != '' THEN 1 ELSE 0 END ) AS all_emp,
            SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS all_present,
            SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS all_absent,
            SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS all_leave,
            SUM( CASE WHEN log.late_status    = 1 THEN 1 ELSE 0 END ) AS all_late,
        ");
		$this->db->from("pr_emp_shift_log as log");
		$this->db->join('pr_emp_com_info as com', 'log.emp_id = com.emp_id', 'left');
		$this->db->join('emp_line_num as num', 'com.emp_line_id = num.id', 'left');

		$this->db->where("com.unit_id", $unit_id);
		$this->db->where("log.shift_log_date", $date);
		$this->db->order_by("num.line_name_en");
		$this->db->group_by("com.emp_line_id");
		$results = $this->db->get()->result();
		return $results;
    }

	public function get_dashboard($unit,$department,$section,$line,$date){

		$data["unit"] = $unit;

		//department
		if (empty($department)) {
			$data["department"] = count($this->get_department($unit));
		}else{
			$data["department"] = 1;
		}
		//department

		//section
		if (empty($section)) {
			$data["section"] = count($this->get_section($unit,$department));
		}else{
			$data["section"] = 1;
		}
		//section

		//line
		if (empty($line)) {
			$data["line"] = count($this->get_line($unit,$department,$section));
		}else{
			$data["line"] = 1;
		}
		//line
		$data["designation"] = count($this->get_designation($unit));
		$data["total_manpower"] = $this->get_total_manpower($unit,$department,$section,$line);
		$data["attendance"] = $this->get_attendance($unit,$department,$section,$line,$date);
		$data["salary"] = $this->get_salary($unit,$department,$section,$line,$date);
		$data["employee_status"] = $this->get_employee_status($unit,$department,$section,$line,$date);
		return $data;
	}

	public function get_designation($unit){
		if (!empty($unit)) {
			$this->db->where("unit_id", $unit);
		}
		$query = $this->db->get("emp_designation");
		return $query->result();
	}
	public function get_department($unit){
		if (!empty($unit)) {
			$this->db->where("unit_id", $unit);
		}
		$query = $this->db->get("emp_depertment");
		return $query->result();
	}

	public function get_section($unit,$department){
		//dd($unit);
		if (!empty($unit)) {
			$this->db->where("unit_id", $unit);
		}
		if (!empty($department)) {
			$this->db->where("depertment_id", $department);
		}
		$query = $this->db->get("emp_section");
		return $query->result();
	}
	public function get_line($unit,$department,$section){
		if (!empty($unit)) {
			$this->db->where("unit_id", $unit);
		}
		if (!empty($department)) {
			$this->db->where("dept_id", $department);
		}
		if (!empty($section)) {
			$this->db->where("section_id", $section);
		}
		$query = $this->db->get("emp_line_num");
		return $query->result();
	}

	public function get_total_manpower($unit,$department,$section,$line){
		$this->db->select("
			SUM(case when pr_emp_per_info.emp_id is null then 0 else 1 end) as total_manpower,
			SUM(case when pr_emp_per_info.gender = 'Male' then 1 else 0 end) as total_male_manpower,
			SUM(case when pr_emp_per_info.gender = 'Female' then 1 else 0 end ) as total_female_manpower
		");
		$this->db->from("pr_emp_per_info");
		$this->db->join("pr_emp_com_info", "pr_emp_per_info.emp_id = pr_emp_com_info.emp_id");
		if (!empty($unit)) {
			$this->db->where("pr_emp_com_info.unit_id", $unit);
		}
		if (!empty($department)) {
			$this->db->where("pr_emp_com_info.emp_dept_id", $department);
		}
		if (!empty($section)) {
			$this->db->where("pr_emp_com_info.emp_sec_id", $section);
		}
		if (!empty($line)) {
			$this->db->where("pr_emp_com_info.emp_line_id", $line);
		}
		$this->db->where("pr_emp_com_info.emp_cat_id", 1);
		$query = $this->db->get()->row();
		return $query;
	}
	public function get_attendance($unit,$department,$section,$line,$date){
		$this->db->select("
		SUM(case when pr_emp_shift_log.present_status = 'P' then 1 else 0 end) as total_present,
		SUM(case when pr_emp_shift_log.present_status = 'A' then 1 else 0 end) as total_absent,
		SUM(case when pr_emp_shift_log.present_status = 'L' then 1 else 0 end) as total_leave,
		SUM(case when pr_emp_shift_log.late_status = 1 then 1 else 0 end) as total_late,
		");
		$this->db->from("pr_emp_per_info");
		$this->db->join("pr_emp_com_info", "pr_emp_per_info.emp_id = pr_emp_com_info.emp_id");
		$this->db->join("pr_emp_shift_log", "pr_emp_per_info.emp_id = pr_emp_shift_log.emp_id");
		$this->db->where("pr_emp_shift_log.shift_log_date", $date);
		if (!empty($unit)) {
			$this->db->where("pr_emp_com_info.unit_id", $unit);
		}
		if (!empty($department)) {
			$this->db->where("pr_emp_com_info.emp_dept_id", $department);
		}
		if (!empty($section)) {
			$this->db->where("pr_emp_com_info.emp_sec_id", $section);
		}
		if (!empty($line)) {
			$this->db->where("pr_emp_com_info.emp_line_id", $line);
		}
		
		$query = $this->db->get()->row();
		return $query;
	}
	public function get_salary($unit,$department,$section,$line,$date){
		$this->db->select("
			SUM(pay_salary_sheet.net_pay) as total_salary,
			SUM(pay_salary_sheet.att_bonus) as total_att_bonus,
			SUM(pay_salary_sheet.ot_hour) as total_ot_hour,
			SUM(pay_salary_sheet.eot_hour) as total_eot_hour,
		");
		$this->db->from("pay_salary_sheet");
		if (!empty($unit)) {
			$this->db->where("pay_salary_sheet.unit_id", $unit);
		}
		if (!empty($department)) {
			$this->db->where("pay_salary_sheet.dept_id", $department);
		}
		if (!empty($section)) {
			$this->db->where("pay_salary_sheet.sec_id", $section);
		}
		if (!empty($line)) {
			$this->db->where("pay_salary_sheet.line_id", $line);
		}
		$this->db->where("pay_salary_sheet.salary_month", date("Y-m-01", strtotime($date)));
		
		$query = $this->db->get()->row();
		return $query;
	}
	public function get_employee_status($unit,$department,$section,$line,$date){
		$start = date("Y-m-01", strtotime($date));
		$end = date("Y-m-t", strtotime($date));

		// new joining
		$this->db->select("
			SUM(case when com.emp_cat_id = 1 then 1 else 0 end) as join_emp
		");
		$this->db->from("pr_emp_com_info as com");
		$this->db->where("com.emp_join_date BETWEEN '$start' AND '$end'");
		if (!empty($unit)) {
			$this->db->where("com.unit_id", $unit);
		}
		if (!empty($department)) {
			$this->db->where("com.emp_dept_id", $department);
		}
		if (!empty($section)) {
			$this->db->where("com.emp_sec_id", $section);
		}
		if (!empty($line)) {
			$this->db->where("com.emp_line_id", $line);
		}
		$this->db->where("com.emp_cat_id", 1);
		$query1 = $this->db->get()->row();

		// left emp
		$this->db->select("
			SUM(case when com.emp_cat_id = 2 then 1 else 0 end) as left_emp
		");
		$this->db->from("pr_emp_left_history as lefts");
		$this->db->from("pr_emp_com_info as com");
		$this->db->where("com.emp_id = lefts.emp_id");
		$this->db->where("lefts.left_date BETWEEN '$start' AND '$end'");
		if (!empty($unit)) {
			$this->db->where("com.unit_id", $unit);
		}
		if (!empty($department)) {
			$this->db->where("com.emp_dept_id", $department);
		}
		if (!empty($section)) {
			$this->db->where("com.emp_sec_id", $section);
		}
		if (!empty($line)) {
			$this->db->where("com.emp_line_id", $line);
		}
		$this->db->where("com.emp_cat_id", 2);
		$query2 = $this->db->get()->row();

		// resign emp
		$this->db->select("
			SUM(case when com.emp_cat_id = 3 then 1 else 0 end) as resign_emp
		");
		$this->db->from("pr_emp_resign_history as res");
		$this->db->from("pr_emp_com_info as com");
		$this->db->where("com.emp_id = res.emp_id");
		$this->db->where("res.resign_date BETWEEN '$start' AND '$end'");
		if (!empty($unit)) {
			$this->db->where("com.unit_id", $unit);
		}
		if (!empty($department)) {
			$this->db->where("com.emp_dept_id", $department);
		}
		if (!empty($section)) {
			$this->db->where("com.emp_sec_id", $section);
		}
		if (!empty($line)) {
			$this->db->where("com.emp_line_id", $line);
		}
		$this->db->where("com.emp_cat_id", 3);
		$query3 = $this->db->get()->row();

		$query = (object) array(
			'join_emp' => $query1->join_emp,
			'left_emp' => $query2->left_emp,
			'resign_emp' => $query3->resign_emp,
		);
		return $query;
	}
}
?>
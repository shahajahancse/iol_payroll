<?php
class Grid_model extends CI_Model{

	function __construct(){
		parent::__construct();

		/* Standard Libraries */
		$this->load->model('log_model');
		$this->load->model('common_model');
		$this->load->model('pf_model');
		$this->load->model('salary_process_model');
		$this->load->model('attn_process_model');
	}

	// ==================  compliance salary report generate  ======================
	function salary_sheet_com($salary_month = null, $status = null, $emp_id = null, $unit_id = null)
	{
		$lastday = date("t", strtotime($salary_month));
		$this->db->select('
				pr_emp_per_info.name_en,
				pr_emp_per_info.name_bn,
				pr_emp_per_info.bank_bkash_no as mobile,
				pr_emp_per_info.personal_mobile,

				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.ot_entitle,

				emp_depertment.dept_name,
				emp_depertment.dept_bangla,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				emp_section.sec_name_bn,
				emp_section.sec_name_en,
				emp_line_num.line_name_en,
				emp_line_num.line_name_bn,
				pr_grade.gr_name,
				pay_salary_sheet_com.*,
			');
		$this->db->from('pay_salary_sheet_com');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->from('emp_depertment');
		$this->db->from('emp_designation');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_grade');

		$this->db->where_in('pay_salary_sheet_com.emp_id', $emp_id);
		$this->db->where('pay_salary_sheet_com.emp_id 		 = pr_emp_per_info.emp_id');
		$this->db->where('pay_salary_sheet_com.emp_id 		 = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_dept_id    	 = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_desi_id    	 = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_sec_id     	 = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id    	 = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id 	 = pr_grade.gr_id');
		$this->db->where("pay_salary_sheet_com.salary_month  = '$salary_month'");
		$this->db->order_by("pay_salary_sheet_com.emp_id","ASC");
		$query = $this->db->get()->result();
		// dd($this->db->last_query());
		// dd($query);
		return $query;
	}
	function summary_report_com($salary_month = null, $status = null, $grid_emp_id = null, $unit_id = null, $type=null)
	{
		// dd($grid_emp_id);
		$this->db->select("
				num.id as line_id, num.line_name_en, num.line_name_bn,emp_section.sec_name_en,

                SUM( CASE WHEN com.salary_draw = 1 THEN 1 ELSE 0 END ) AS emp_cash,
                SUM( CASE WHEN com.salary_draw = 2 THEN 1 ELSE 0 END ) AS emp_bank,

                SUM( CASE WHEN com.salary_draw = 1 THEN ss.gross_sal ELSE 0 END ) AS cash_sum,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.gross_sal ELSE 0 END ) AS bank_sum,

				SUM( CASE WHEN com.salary_draw = 1 THEN ss.basic_sal ELSE 0 END ) AS cash_sum_basic_sal,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.basic_sal ELSE 0 END ) AS bank_sum_basic_sal,

				SUM( CASE WHEN com.salary_draw = 1 THEN ss.house_r ELSE 0 END ) AS cash_sum_house_r,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.house_r ELSE 0 END ) AS bank_sum_house_r,

				SUM( CASE WHEN com.salary_draw = 1 THEN ss.medical_a ELSE 0 END ) AS cash_sum_medical_a,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.medical_a ELSE 0 END ) AS bank_sum_medical_a,

				SUM( CASE WHEN com.salary_draw = 1 THEN ss.food_allow ELSE 0 END ) AS cash_sum_food_allow,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.food_allow ELSE 0 END ) AS bank_sum_food_allow,

				SUM( CASE WHEN com.salary_draw = 1 THEN ss.trans_allow ELSE 0 END ) AS cash_sum_trans_allow,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.trans_allow ELSE 0 END ) AS bank_sum_trans_allow,

                SUM( CASE WHEN com.salary_draw = 1 THEN ss.ot_hour ELSE 0 END ) AS cash_sum_ot_hour,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.ot_hour ELSE 0 END ) AS bank_sum_ot_hour,
                SUM( CASE WHEN com.salary_draw = 1 THEN ss.eot_hour ELSE 0 END ) AS eot_cash_sum,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.eot_hour ELSE 0 END ) AS eot_bank_sum,

                SUM( CASE WHEN com.salary_draw = 1 THEN ss.ot_amount ELSE 0 END ) AS cash_ot_amount,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.ot_amount ELSE 0 END ) AS bank_ot_amount,
                SUM( CASE WHEN com.salary_draw = 1 THEN ss.eot_amount ELSE 0 END ) AS eot_amount_cash_sum,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.eot_amount ELSE 0 END ) AS eot_amount_bank_sum,

                SUM( CASE WHEN com.salary_draw = 1 THEN ss.att_bonus ELSE 0 END ) AS cash_att_bonus,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.att_bonus ELSE 0 END ) AS bank_att_bonus,

                SUM( CASE WHEN com.salary_draw = 1 THEN ss.net_pay ELSE 0 END ) AS cash_sum_net_pay,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.net_pay ELSE 0 END ) AS bank_sum_net_pay,

                SUM( CASE WHEN com.salary_draw = 1 THEN ss.festival_bonus ELSE 0 END ) AS festival_bonus_cash,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.festival_bonus ELSE 0 END ) AS festival_bonus_bank,

                SUM( CASE WHEN com.salary_draw = 1 THEN ss.adv_deduct ELSE 0 END ) AS adv_deduct_cash,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.adv_deduct ELSE 0 END ) AS adv_deduct_bank,
                SUM( CASE WHEN com.salary_draw = 1 THEN ss.abs_deduction ELSE 0 END ) AS abs_deduction_cash,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.abs_deduction ELSE 0 END ) AS abs_deduction_bank,
                SUM( CASE WHEN com.salary_draw = 1 THEN ss.late_deduct ELSE 0 END ) AS late_deduct_cash,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.late_deduct ELSE 0 END ) AS late_deduct_bank,
                SUM( CASE WHEN com.salary_draw = 1 THEN ss.others_deduct ELSE 0 END ) AS others_deduct_cash,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.others_deduct ELSE 0 END ) AS others_deduct_bank,
                SUM( CASE WHEN com.salary_draw = 1 THEN ss.tax_deduct ELSE 0 END ) AS tax_deduct_cash,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.tax_deduct ELSE 0 END ) AS tax_deduct_bank,
                SUM( CASE WHEN com.salary_draw = 1 THEN ss.stamp ELSE 0 END ) AS stam_deduct_cash,
                SUM( CASE WHEN com.salary_draw = 2 THEN ss.stamp ELSE 0 END ) AS stam_deduct_bank,
            ");
		$this->db->from('pay_salary_sheet_com as ss');
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('emp_line_num as num');
		$this->db->from('emp_section as emp_section');

		$this->db->where("ss.emp_id = com.emp_id");
		$this->db->where("num.id = com.emp_line_id");

		$this->db->where("ss.salary_month", $salary_month);
		$this->db->where("ss.unit_id", $unit_id);
		if ($type != null) {
			$this->db->where("ss.eot_amount   != ",0);
			$this->db->where("ss.eot_hour     > ",0);
		}
		$this->db->group_by("num.id");
		$this->db->order_by("num.line_name_en");
		$data=$this->db->get()->result();
		return $data;

	}

	function get_emp_info($grid_emp_id, $start_date=null){
		$data = array();
		$this->db->distinct();
		$this->db->select('
			per.name_en,
			per.name_bn,
			emp_designation.id,
			emp_designation.desig_name,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			emp_line_num.line_name_en,
			com.emp_id,
			com.emp_join_date,
			com.unit_id,
			com.emp_shift,
			com.emp_desi_id,
			pay.gross_sal,
			pay.basic_sal'
		);
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('pr_emp_per_info as per');
		$this->db->from('pay_salary_sheet_com as pay');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');
		$this->db->where_in('com.emp_id', $grid_emp_id);
		$this->db->where_in('pay.salary_month', $start_date);
		$this->db->where('per.emp_id = com.emp_id');
		$this->db->where('com.emp_id = pay.emp_id');
		$this->db->where('com.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('com.emp_desi_id = emp_designation.id');
		$this->db->where('com.emp_sec_id = emp_section.id');
		$this->db->where('com.emp_line_id = emp_line_num.id');
		$query = $this->db->get();
		return $query->result();
	}

    function cal_eot_com($emp_id, $start_date, $end_date, $unit_id=null)
    {
        $this->db->select("
                COALESCE(SUM(log.ot), 0) AS ot,
                COALESCE(SUM(log.eot), 0) AS eot,
                COALESCE(SUM(log.ot_eot_4pm), 0) AS actual_eot_4pm,
                COALESCE(SUM(log.ot_eot_12am), 0) AS actual_eot_12am,
                COALESCE(SUM(CASE WHEN log.false_ot_4 IS NOT NULL THEN log.false_ot_4 ELSE log.ot_eot_4pm END), 0) AS eot_4,
                COALESCE(SUM(CASE WHEN log.false_ot_12 IS NOT NULL THEN log.false_ot_12 ELSE log.ot_eot_12am END), 0) AS eot_12,
                COALESCE(SUM(CASE WHEN log.present_status = 'W' THEN log.ot ELSE 0 END), 0) AS w_ot,
                COALESCE(SUM(CASE WHEN log.present_status = 'H' THEN log.ot ELSE 0 END), 0) AS h_ot,
                COALESCE(SUM(CASE WHEN log.present_status = 'H' THEN log.eot ELSE 0 END), 0) AS h_eot,
                COALESCE(SUM(CASE WHEN log.present_status = 'W' THEN log.eot ELSE 0 END), 0) AS w_eot,
            ");

		$this->db->from('pr_emp_shift_log as log');
        $this->db->where('log.emp_id', $emp_id);
        $this->db->where('log.present_status', 'P');
        $this->db->where("log.shift_log_date BETWEEN '$start_date' AND '$end_date'");
		$this->db->group_by("log.emp_id");
        $query = $this->db->get();
        return $query->row();
    }
	// ================== end compliance salary report generate  ======================

	// ==================   actual salary report generate   ======================
	function actual_salary_sheet($salary_month = null, $status = null, $emp_id = null, $unit_id = null, $type=null)
	{
		$lastday = date("t", strtotime($salary_month));
		$this->db->select('
				pr_emp_per_info.name_en,
				pr_emp_per_info.name_bn,
				pr_emp_per_info.bank_bkash_no as mobile,
				pr_emp_per_info.personal_mobile,

				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.ot_entitle,
				pr_emp_com_info.com_ot_entitle,

				emp_depertment.dept_name,
				emp_depertment.dept_bangla,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				emp_section.sec_name_bn,
				emp_section.sec_name_en,
				emp_line_num.line_name_en,
				emp_line_num.line_name_bn,
				pr_grade.gr_name,
				pay_salary_sheet.*,
			');
		$this->db->from('pay_salary_sheet');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->from('emp_depertment');
		$this->db->from('emp_designation');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_grade');

		$this->db->where_in('pay_salary_sheet.emp_id', $emp_id);
		$this->db->where('pay_salary_sheet.emp_id 		 = pr_emp_per_info.emp_id');
		$this->db->where('pay_salary_sheet.emp_id 		 = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_dept_id    = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_desi_id    = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_sec_id     = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id    = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where("pay_salary_sheet.salary_month  = '$salary_month'");
		if ($type != null) {
			$this->db->where("pay_salary_sheet.eot_amount   != ",0);
			$this->db->where("pay_salary_sheet.eot_hour     > ",0);
		}
		$this->db->order_by("pay_salary_sheet.emp_id","ASC");
		$query = $this->db->get();
		return $query->result();
	}

	function actual_summary_report($salary_month = null, $unit_id = null, $type=null)
	{
 		// $this->db->distinct();
 		$this->db->select("
 				num.id as line_id, num.line_name_en, num.line_name_bn, sec.sec_name_en,
 				IFNULL(SUM(CASE WHEN com.salary_draw = 1 THEN 1 ELSE 0 END), 0) AS emp_cash,
 				IFNULL(SUM(CASE WHEN com.salary_draw = 2 THEN 1 ELSE 0 END), 0) AS emp_bank,
 				IFNULL(SUM(CASE WHEN com.salary_draw = 1 THEN ss.gross_sal ELSE 0 END), 0) AS cash_sum,
 				IFNULL(SUM(CASE WHEN com.salary_draw = 2 THEN ss.gross_sal ELSE 0 END), 0) AS bank_sum,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.basic_sal ELSE 0 END) AS cash_sum_basic_sal,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.basic_sal ELSE 0 END) AS bank_sum_basic_sal,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.house_r ELSE 0 END) AS cash_sum_house_r,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.house_r ELSE 0 END) AS bank_sum_house_r,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.medical_a ELSE 0 END) AS cash_sum_medical_a,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.medical_a ELSE 0 END) AS bank_sum_medical_a,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.food_allow ELSE 0 END) AS cash_sum_food_allow,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.food_allow ELSE 0 END) AS bank_sum_food_allow,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.trans_allow ELSE 0 END) AS cash_sum_trans_allow,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.trans_allow ELSE 0 END) AS bank_sum_trans_allow,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.ot_hour ELSE 0 END) AS cash_sum_ot_hour,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.ot_hour ELSE 0 END) AS bank_sum_ot_hour,
 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.eot_hour ELSE 0 END) AS eot_cash_sum,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.eot_hour ELSE 0 END) AS eot_bank_sum,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.ot_amount ELSE 0 END) AS cash_ot_amount,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.ot_amount ELSE 0 END) AS bank_ot_amount,
 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.eot_amount ELSE 0 END) AS eot_amount_cash_sum,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.eot_amount ELSE 0 END) AS eot_amount_bank_sum,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.eot_hr_for_sa ELSE 0 END) AS eot_hr_for_sa_cash_sum,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.eot_hr_for_sa ELSE 0 END) AS eot_hr_for_sa_bank_sum,
 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.eot_amt_for_sa ELSE 0 END) AS eot_amt_for_sa_cash_sum,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.eot_amt_for_sa ELSE 0 END) AS eot_amt_for_sa_bank_sum,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.att_bonus ELSE 0 END) AS cash_att_bonus,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.att_bonus ELSE 0 END) AS bank_att_bonus,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.net_pay ELSE 0 END) AS cash_sum_net_pay,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.net_pay ELSE 0 END) AS bank_sum_net_pay,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.festival_bonus ELSE 0 END) AS festival_bonus_cash,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.festival_bonus ELSE 0 END) AS festival_bonus_bank,

 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.adv_deduct ELSE 0 END) AS adv_deduct_cash,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.adv_deduct ELSE 0 END) AS adv_deduct_bank,
 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.abs_deduction ELSE 0 END) AS abs_deduction_cash,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.abs_deduction ELSE 0 END) AS abs_deduction_bank,
 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.late_deduct ELSE 0 END) AS late_deduct_cash,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.late_deduct ELSE 0 END) AS late_deduct_bank,
 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.others_deduct ELSE 0 END) AS others_deduct_cash,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.others_deduct ELSE 0 END) AS others_deduct_bank,
 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.tax_deduct ELSE 0 END) AS tax_deduct_cash,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.tax_deduct ELSE 0 END) AS tax_deduct_bank,
 				SUM(CASE WHEN com.salary_draw = 1 THEN ss.stamp ELSE 0 END) AS stam_deduct_cash,
 				SUM(CASE WHEN com.salary_draw = 2 THEN ss.stamp ELSE 0 END) AS stam_deduct_bank,
 			");

		$this->db->from('pay_salary_sheet as ss');
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('emp_line_num as num');
		$this->db->from('emp_section as sec');

		$this->db->where("ss.line_id = num.id");
		$this->db->where("ss.emp_id = com.emp_id");
		$this->db->where("ss.sec_id = sec.id");
		$this->db->where("ss.salary_month", $salary_month);
		$this->db->where("ss.unit_id", $unit_id);
		if ($type != null) {
			$this->db->where("ss.eot_amount   != ",0);
			$this->db->where("ss.eot_hour     > ",0);
		}
		$this->db->group_by([
			'num.id',
			'num.line_name_en',
			'num.line_name_bn',
			'sec.sec_name_en'
		]);
		// $this->db->group_by("num.id");
		$this->db->order_by("num.line_name_en");
		return $this->db->get()->result();
	}

	function grid_monthly_stop_sheet($sal_year_month, $grid_status, $grid_emp_id)
	{

		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));

		$this->db->select('pr_emp_per_info.name_en,emp_designation.desig_name, emp_section.sec_name_en, pr_emp_com_info.emp_join_date,pr_grade.gr_name,pay_salary_sheet.*,pr_emp_com_info.emp_join_date,emp_line_num.line_name_en');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');

		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where("pay_salary_sheet.salary_month = '$sal_year_month'");
		$this->db->where('pay_salary_sheet.id = (
			SELECT MAX(id) FROM pay_salary_sheet
			WHERE emp_id = pr_emp_com_info.emp_id
		)');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->order_by("emp_designation.desig_name");
		// $this->db->group_by("pay_salary_sheet.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else {return "Requested List Is Empty";}
	}
	// ==================  end actual salary report generate   ======================
	function continuous_report($date1, $date2, $status, $grid_emp_id){
		$data = array();

		$this->db->select('
			emp_line_num.line_name_en,
			pr_emp_com_info.id,
			pr_emp_com_info.emp_id,
			pr_emp_com_info.proxi_id,
			pr_emp_com_info.emp_join_date,
			pr_emp_com_info.emp_sec_id,
			pr_emp_per_info.name_en,
			emp_designation.desig_name,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			COALESCE(SUM(CASE WHEN pr_emp_shift_log.present_status = "' . $status . '" AND pr_emp_com_info.emp_join_date <= pr_emp_shift_log.shift_log_date THEN 1 ELSE 0 END), 0) AS total
		');

		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->join('emp_designation', 'emp_designation.id = pr_emp_com_info.emp_desi_id', 'LEFT');
		$this->db->join('emp_depertment', 'emp_depertment.dept_id = pr_emp_com_info.emp_dept_id', 'LEFT');
		$this->db->join('emp_section', 'emp_section.id = pr_emp_com_info.emp_sec_id', 'LEFT');
		$this->db->join('emp_line_num', 'emp_line_num.id = pr_emp_com_info.emp_line_id', 'LEFT');
		$this->db->join('pr_emp_shift_log', 'pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_shift_log.shift_log_date >=', $date1);
		$this->db->where('pr_emp_shift_log.shift_log_date <=', $date2);
		$this->db->group_by([
			'pr_emp_com_info.emp_id',
			'emp_line_num.line_name_en',
			'pr_emp_com_info.id',
			'pr_emp_com_info.proxi_id',
			'pr_emp_com_info.emp_join_date',
			'pr_emp_com_info.emp_sec_id',
			'pr_emp_per_info.name_en',
			'emp_designation.desig_name',
			'emp_depertment.dept_name',
			'emp_section.sec_name_en'
		]);
		$this->db->order_by('pr_emp_com_info.emp_sec_id','ASC' );

		$query = $this->db->get()->result_array();

		return (!empty($query)) ? $query : 'No Data Found';
	}

	function continuous_late_report($date1, $date2, $grid_emp_id){
		$data = array();

		$this->db->select('
			emp_line_num.line_name_en,
			pr_emp_com_info.id,
			pr_emp_com_info.emp_id,
			pr_emp_com_info.proxi_id,
			pr_emp_com_info.emp_join_date,
			pr_emp_com_info.emp_sec_id,
			pr_emp_per_info.name_en,
			emp_designation.desig_name,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			COALESCE(SUM(CASE WHEN pr_emp_shift_log.late_status = 1 AND pr_emp_com_info.emp_join_date <= pr_emp_shift_log.shift_log_date THEN 1 ELSE 0 END), 0) AS total,
		');

		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->join('emp_designation', 'emp_designation.id = pr_emp_com_info.emp_desi_id', 'LEFT');
		$this->db->join('emp_depertment', 'emp_depertment.dept_id = pr_emp_com_info.emp_dept_id', 'LEFT');
		$this->db->join('emp_section', 'emp_section.id = pr_emp_com_info.emp_sec_id', 'LEFT');
		$this->db->join('emp_line_num', 'emp_line_num.id = pr_emp_com_info.emp_line_id', 'LEFT');
		$this->db->join('pr_emp_shift_log', 'pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_shift_log.late_status', 1);
		$this->db->where('pr_emp_shift_log.shift_log_date >=', $date1);
		$this->db->where('pr_emp_shift_log.shift_log_date <=', $date2);
		$this->db->group_by([
			'pr_emp_com_info.emp_id',
			'emp_line_num.line_name_en',
			'pr_emp_com_info.id',
			'pr_emp_com_info.proxi_id',
			'pr_emp_com_info.emp_join_date',
			'pr_emp_com_info.emp_sec_id',
			'pr_emp_per_info.name_en',
			'emp_designation.desig_name',
			'emp_depertment.dept_name',
			'emp_section.sec_name_en'
		]);
		$this->db->order_by('pr_emp_com_info.emp_sec_id','ASC' );

		$query = $this->db->get()->result_array();

		return (!empty($query)) ? $query : 'No Data Found';
	}
	//-------------------------------------------------------------------------------------------------
	// Daily Cost Sheet
	//-------------------------------------------------------------------------------------------------
	function daily_costing_summary($date, $unit_id){

		$this->db->select("
				num.id as line_id, num.line_name_en, num.line_name_bn, log.shift_log_date,
				SUM( CASE WHEN log.present_status != 'A' THEN 1 ELSE 0 END ) AS present_emp,
				SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS absent_emp,
				SUM( CASE WHEN log.present_status != 'A' THEN com.gross_sal ELSE 0 END ) AS present_gross_salary,
				SUM( CASE WHEN log.present_status = 'A' THEN com.gross_sal ELSE 0 END ) AS absent_gross_salary,
				SUM( CASE WHEN log.tiffin_allo  =1 THEN com.gross_sal ELSE 0 END ) AS ifter_allowence,
				SUM( CASE WHEN log.holiday_allo =1 THEN com.gross_sal ELSE 0 END ) AS holiday_allowence,
				SUM( CASE WHEN log.night_allo   =1 THEN com.gross_sal ELSE 0 END ) AS night_allowence,
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
		$this->db->group_by("num.id");
		$this->db->order_by("num.line_name_en");
		return $this->db->get()->result();
	}

	// Daily attendance summary line wise
	function daily_attendance_summary($date, $unit_id){

		$results = $this->db->where('unit_id', $unit_id)->order_by('id')->get('emp_group_dasignation')->result();
		$groupWiseDesigId = array();
		foreach ($results as $key => $r) {
			$groupWiseDesigId[$r->name_en] = $this->get_group_dasig_id($r->id, $unit_id);
		}
		$data['keys'] = array_keys($groupWiseDesigId);

		$this->db->select("
					num.id as line_id, num.line_name_en, num.line_name_bn, num.group_one,num.group_two,num.group_three,num.group_four,num.group_five,num.group_six,
	                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS all_emp,
	                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS all_present,
	                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS all_absent,
	                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS all_leave,
	                SUM( CASE WHEN log.late_status    = 1 THEN 1 ELSE 0 END ) AS all_late,
	                SUM( CASE WHEN per.emp_sex 		  = 1 THEN 1 ELSE 0 END ) AS all_male,
	                SUM( CASE WHEN per.emp_sex 		  = 2 THEN 1 ELSE 0 END ) AS all_female,
				");

		$this->db->from("pr_emp_shift_log as log");
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('emp_line_num as num');
		$this->db->from('pr_emp_per_info as per');

		$this->db->where("log.emp_id = com.emp_id");
		$this->db->where("per.emp_id = com.emp_id");
		$this->db->where("num.id = com.emp_line_id");

		$this->db->where("com.unit_id", $unit_id);
		$this->db->where("log.shift_log_date", $date);
		$this->db->where("log.in_time !=", "00:00:00");
		$this->db->where("log.present_status !=", "W");
		$this->db->where_not_in("com.emp_cat_id", array(2,3,4));

		$this->db->group_by("num.id");
		$this->db->order_by("num.line_name_en");
		$data['results'] = $this->db->get()->result();
		// dd($data);
		foreach ($data['results'] as $key => $row) {
			$d = $this->common_model->get_group_wise_attendance($row->line_id, $date, $unit_id, $groupWiseDesigId);
			// dd($d);
			$data['results'][$key]->group_data  = $d;
			$group_names = [
				'Operator'    => $row->group_one,
				'Helper'      => $row->group_two,
				'Iron Man'    => $row->group_three,
				'Line Chief'  => $row->group_four,
				'Supervisor'  => $row->group_five,
				'Input Man'   => $row->group_six,
			];
			foreach ($d as $d_key => $d_value) {
				foreach ($group_names as $group_name_key => $group_name) {
					if ($d_key == $group_name_key) {
						if(isset($data['results'][$key]->group_data[$d_key])){
							$data['results'][$key]->group_data[$d_key]->group_budget = $group_name;
						}
					}
				}
			}
		}

		// dd($data);
		if($data['results'] == null){
		 echo "Requested list is empty"; exit;
		}else{
			return $data;
		}
	}
	// Daily attendance summary section wise
	function daily_attendance_summary1($date, $unit_id){

		$results = $this->db->where('unit_id', $unit_id)->order_by('id')->get('emp_group_dasignation')->result();
		$groupWiseDesigId = array();
		foreach ($results as $key => $r) {
			$groupWiseDesigId[$r->name_en] = $this->get_group_dasig_id($r->id, $unit_id);
		}
		$data['keys'] = array_keys($groupWiseDesigId);

		$this->db->select("
					num.id as line_id, num.line_name_en, num.line_name_bn, num.group_one,num.group_two,num.group_three,num.group_four,num.group_five,num.group_six,
	                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS all_emp,
	                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS all_present,
	                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS all_absent,
	                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS all_leave,
	                SUM( CASE WHEN log.late_status    = 1 THEN 1 ELSE 0 END ) AS all_late,
	                SUM( CASE WHEN per.emp_sex 		  = 1 THEN 1 ELSE 0 END ) AS all_male,
	                SUM( CASE WHEN per.emp_sex 		  = 2 THEN 1 ELSE 0 END ) AS all_female,
				");

		$this->db->from("pr_emp_shift_log as log");
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('emp_line_num as num');
		$this->db->from('pr_emp_per_info as per');

		$this->db->where("log.emp_id = com.emp_id");
		$this->db->where("per.emp_id = com.emp_id");
		$this->db->where("num.id = com.emp_line_id");

		$this->db->where("com.unit_id", $unit_id);
		$this->db->where("log.shift_log_date", $date);
		$this->db->where("log.in_time !=", "00:00:00");
		$this->db->where("log.present_status !=", "W");
		$this->db->where_not_in("com.emp_cat_id", array(2,3,4));

		$this->db->group_by("num.id");
		$this->db->order_by("num.line_name_en");
		$data['results'] = $this->db->get()->result();
		// dd($data);
		foreach ($data['results'] as $key => $row) {
			$d = $this->common_model->get_group_wise_attendance($row->line_id, $date, $unit_id, $groupWiseDesigId);
			// dd($d);
			$data['results'][$key]->group_data  = $d;
			$group_names = [
				'Operator'    => $row->group_one,
				'Helper'      => $row->group_two,
				'Iron Man'    => $row->group_three,
				'Line Chief'  => $row->group_four,
				'Supervisor'  => $row->group_five,
				'Input Man'   => $row->group_six,
			];
			foreach ($d as $d_key => $d_value) {
				foreach ($group_names as $group_name_key => $group_name) {
					if ($d_key == $group_name_key) {
						if(isset($data['results'][$key]->group_data[$d_key])){
							$data['results'][$key]->group_data[$d_key]->group_budget = $group_name;
						}
					}
				}
			}
		}

		// dd($data);
		if($data['results'] == null){
		 echo "Requested list is empty"; exit;
		}else{
			return $data;
		}
	}

	function get_group_dasig_id($id, $unit_id)	{
		$this->db->select('id')->where('group_id', $id)->where('unit_id', $unit_id);
		$rows = $this->db->get('emp_designation')->result();
		$data = array();
		foreach ($rows as $key => $r) {
			$data[$key] = $r->id;
		}
		return $data;
	}

	// daily logout report
	function daily_logout_report($date, $unit_id){
		$this->db->select("
			num.id as line_id, num.line_name_en, num.line_name_bn,
			SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS all_present,
			SUM( CASE WHEN (log.in_time != '00:00:00' AND log.out_time = '00:00:00') OR (log.in_time = '00:00:00' AND log.out_time != '00:00:00') THEN 1 ELSE 0 END ) AS present_error,
			SUM(ot + eot) AS total_ot,
			SUM( CASE WHEN log.out_time > '11:30:00' AND log.out_time <= '16:00:00' THEN 1 ELSE 0 END ) AS four_pm,
			SUM( CASE WHEN log.out_time > '16:00:00' AND log.out_time <= '17:00:00' THEN 1 ELSE 0 END ) AS five_pm,
			SUM( CASE WHEN log.out_time > '17:00:00' AND log.out_time <= '18:00:00' THEN 1 ELSE 0 END ) AS six_pm,
			SUM( CASE WHEN log.out_time > '18:00:00' AND log.out_time <= '19:00:00' THEN 1 ELSE 0 END ) AS seven_pm,
			SUM( CASE WHEN log.out_time > '19:00:00' AND log.out_time <= '20:00:00' THEN 1 ELSE 0 END ) AS eight_pm,
			SUM( CASE WHEN log.out_time > '20:00:00' AND log.out_time <= '21:00:00' THEN 1 ELSE 0 END ) AS nine_pm,
			SUM( CASE WHEN log.out_time > '21:00:00' AND log.out_time <= '22:00:00' THEN 1 ELSE 0 END ) AS ten_pm,
			SUM( CASE WHEN log.out_time > '22:00:00' AND log.out_time <= '23:00:00' THEN 1 ELSE 0 END ) AS eleven_pm,
			SUM( CASE WHEN log.out_time > '23:00:00' AND log.out_time <= '23:59:25' THEN 1 ELSE 0 END ) AS tweelve_pm,
			SUM( CASE WHEN log.out_time > '00:00:01' AND log.out_time <= '01:00:00' THEN 1 ELSE 0 END ) AS one_am,
			SUM( CASE WHEN log.out_time > '01:00:00' AND log.out_time <= '02:00:00' THEN 1 ELSE 0 END ) AS two_am,
			SUM( CASE WHEN log.out_time > '02:00:00' AND log.out_time <= '03:00:00' THEN 1 ELSE 0 END ) AS three_am,
			SUM( CASE WHEN log.out_time > '03:00:00' AND log.out_time <= '04:00:00' THEN 1 ELSE 0 END ) AS four_am,
			SUM( CASE WHEN log.out_time > '04:00:00' AND log.out_time <= '05:00:00' THEN 1 ELSE 0 END ) AS five_am,
			SUM( CASE WHEN log.out_time > '05:00:00' AND log.out_time <= '06:00:00' THEN 1 ELSE 0 END ) AS six_am,
		");

		$this->db->from("emp_line_num as num");
		$this->db->join("pr_emp_com_info as com", "num.id = com.emp_line_id", "left");
		$this->db->join("pr_emp_shift_log as log", "com.emp_id = log.emp_id", "left");
		$this->db->where("com.unit_id", $unit_id);
		$this->db->where("log.shift_log_date", $date);
		$this->db->where("log.present_status","P");
		// $this->db->where_not_in("com.emp_cat_id", array(2,3,4));
		$this->db->group_by("num.id");
		$this->db->order_by("num.line_name_en");
		return $this->db->get()->result();
	}

	function leave_application($first_date,$second_date,$emp_id,$unit_id){
		// dd($emp_id);
		$this->db->select('
			pr_emp_per_info.name_bn,
			pr_emp_per_info.gender,
			pr_emp_per_info.img_source,
			pr_emp_per_info.signature,
			pr_emp_com_info.emp_id,
			pr_emp_com_info.emp_join_date,
			emp_designation.desig_bangla,
			emp_depertment.dept_bangla,
			emp_section.sec_name_bn,
			emp_line_num.line_name_bn,
			pr_emp_position.posi_name_bn,
		');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
		$this->db->join('pr_emp_position', 'pr_emp_position.posi_id = pr_emp_com_info.position_id', 'left');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id', 'left');
		$this->db->where('pr_emp_com_info.emp_id', $emp_id);
		$emp_info=$this->db->get()->result();
		$data['emp_info'] = $emp_info[0];
		// dd($emp_info);
        $this->db->where_in('emp_id', $emp_id);
        $unit_id=$this->db->get('pr_emp_com_info')->row()->unit_id;
        // $this->db->where('unit_id', $unit_id);
        $leave_entitle=$this->db->get('pr_leave')->row();
		// dd($leave_entitle);
        $data['leave_entitle_casual']= $leave_entitle->lv_cl ?? 0;
        $data['leave_entitle_sick']= $leave_entitle->lv_sl ?? 0;
		if($emp_info[0]->gender != 'Male'){
			$data['leave_entitle_maternity']= $leave_entitle->lv_ml;
		}
        $this->db->where_in('emp_id', $emp_id);
        $this->db->where('leave_start >=', date('Y-m-d',strtotime($first_date)));
        $this->db->where('leave_end <=', date('Y-m-d',strtotime($second_date)));
        $leavei = $this->db->get('pr_leave_trans')->result();
        $leave_taken_casual =0;
        $leave_taken_sick =0;
		if($emp_info[0]->gender != 'Male'){
			$leave_taken_maternity =0;
		}
        $leave_taken_paternity =0;

        foreach ($leavei as $key => $value) {
            if($value->leave_type == 'cl'){
                $leave_taken_casual += $value->total_leave;
            }else if($value->leave_type == 'sl'){
                $leave_taken_sick += $value->total_leave;
            }else if($value->leave_type == 'ml' && $emp_info[0]->gender != 'Male'){
                $leave_taken_maternity += $value->total_leave;
            }
        }
        $data['leave_taken_casual']      = $leave_taken_casual;
        $data['leave_taken_sick']        = $leave_taken_sick;
		if($emp_info[0]->gender !='Male'){
			$data['leave_taken_maternity']   = $leave_taken_maternity;
			$data['leave_balance_maternity'] = $data['leave_entitle_maternity'] - $data['leave_taken_maternity'];
		}
        $data['leave_balance_casual']    = $data['leave_entitle_casual'] - $data['leave_taken_casual'];
        $data['leave_balance_sick'] 	 = $data['leave_entitle_sick'] - $data['leave_taken_sick'];
		// dd($emp_info);
		return $data;
	}

	function get_ot_emp_info($grid_emp_id, $unit_id=null){
		$data = array();
		$this->db->distinct();
		$this->db->select('pr_emp_per_info.name_en,
			emp_designation.id,
			emp_designation.desig_name,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			emp_line_num.line_name_en,
			pr_emp_com_info.emp_id,
			pr_emp_com_info.emp_join_date,
			pr_emp_com_info.proxi_id,
			pr_emp_com_info.unit_id,
			pr_emp_com_info.emp_shift,
			pr_emp_com_info.emp_desi_id'
		);
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$query = $this->db->get();
		return $query->result();
	}
	//-------------------------------------------------------------------------------------------------
	// Daily Actual Present Report
	//-------------------------------------------------------------------------------------------------
	function grid_daily_report_copyss($date, $grid_emp_id,$type){
		// dd($date);
		$this->db->select('
			pr_emp_com_info.emp_id,
			pr_emp_com_info.gross_sal,
			pr_emp_per_info.name_en,
			pr_emp_per_info.bank_bkash_no as personal_mobile,
			emp_designation.desig_name,
			pr_emp_com_info.emp_join_date,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			emp_line_num.line_name_en,
			pr_emp_shift.shift_name,
			pr_emp_com_info.emp_cat_id,
			pr_emp_com_info.emp_sec_id,
			pr_emp_shift_log.in_time,
			pr_emp_shift_log.out_time,
			pr_emp_shift_log.present_status,
			pr_emp_shift_log.late_status,
			pr_emp_shift_log.ot,
			pr_emp_shift_log.eot,
			pr_emp_shift_log.deduction_hour,
			pr_emp_shift_log.modify_eot,
			'
		);

		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->join('emp_designation', 'emp_designation.id = pr_emp_com_info.emp_desi_id', 'LEFT');
		$this->db->join('emp_depertment', 'emp_depertment.dept_id = pr_emp_com_info.emp_dept_id', 'LEFT');
		$this->db->join('emp_section', 'emp_section.id = pr_emp_com_info.emp_sec_id', 'LEFT');
		$this->db->join('emp_line_num', 'emp_line_num.id = pr_emp_com_info.emp_line_id', 'LEFT');
		$this->db->join('pr_emp_shift', 'pr_emp_shift.id = pr_emp_com_info.emp_shift', 'LEFT');
		$this->db->join('pr_emp_shift_log', 'pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->where('pr_emp_shift_log.shift_log_date', $date);

		if($type == 1){
			$this->db->where('pr_emp_shift_log.present_status', "P");
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		}

		if($type == 2){
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->select('pr_leave_trans.leave_type');
			$this->db->where('pr_emp_shift_log.present_status', "A");
			$this->db->join('pr_leave_trans', 'pr_leave_trans.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		}

		if($type == 3){
			$this->db->select('pr_leave_trans.leave_type');
			$this->db->where('pr_leave_trans.start_date',$date);
			$this->db->join('pr_leave_trans', 'pr_leave_trans.emp_id = pr_emp_com_info.emp_id', 'LEFT');
			$this->db->where('pr_emp_shift_log.present_status', "L");
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		}

		if($type == 4){
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_shift_log.late_status = 1');
		}

		if($type == 5){
			$this->db->where('pr_emp_shift_log.ot > 0');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		}

		if($type == 6){
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_shift_log.eot >= 2');
		}
		if($type == 7){
			// dd($type);
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where("(pr_emp_shift_log.in_time = '00:00:00' OR pr_emp_shift_log.out_time = '00:00:00') AND pr_emp_shift_log.present_status = 'P'");
		}

		if($type == 8){
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where("(pr_emp_shift_log.in_time = '00:00:00' OR pr_emp_shift_log.out_time = '00:00:00') AND pr_emp_shift_log.present_status = 'P'");
		}
		$this->db->order_by('pr_emp_com_info.emp_line_id','ASC');
		$this->db->group_by('pr_emp_com_info.emp_id');
		$query = $this->db->get()->result_array();
		// dd($query);
		if(empty($query)){
			echo "Requested list is empty";
			exit;
		}else{
			return $query;
		}
	}

	function grid_daily_report($date, $grid_emp_id, $type)
	{
		$this->db->select('
			pr_emp_com_info.emp_id,
			pr_emp_com_info.gross_sal,
			pr_emp_per_info.name_en,
			pr_emp_per_info.bank_bkash_no AS personal_mobile,
			emp_designation.desig_name,
			pr_emp_com_info.emp_join_date,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			emp_line_num.line_name_en,
			pr_emp_shift.shift_name,
			pr_emp_com_info.emp_cat_id,
			pr_emp_com_info.emp_sec_id,
			pr_emp_shift_log.in_time,
			pr_emp_shift_log.out_time,
			pr_emp_shift_log.present_status,
			pr_emp_shift_log.late_status,
			pr_emp_shift_log.ot,
			pr_emp_shift_log.eot,
			pr_emp_shift_log.deduction_hour,
			pr_emp_shift_log.modify_eot
		');

		$this->db->from('pr_emp_com_info');

		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->join('emp_designation', 'emp_designation.id = pr_emp_com_info.emp_desi_id', 'LEFT');
		$this->db->join('emp_depertment', 'emp_depertment.dept_id = pr_emp_com_info.emp_dept_id', 'LEFT');
		$this->db->join('emp_section', 'emp_section.id = pr_emp_com_info.emp_sec_id', 'LEFT');
		$this->db->join('emp_line_num', 'emp_line_num.id = pr_emp_com_info.emp_line_id', 'LEFT');
		$this->db->join('pr_emp_shift', 'pr_emp_shift.id = pr_emp_com_info.emp_shift', 'LEFT');
		$this->db->join('pr_emp_shift_log', 'pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id', 'LEFT');

		// Mandatory filters
		$this->db->where('pr_emp_shift_log.shift_log_date', $date);
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);

		/* ---------- TYPE CONDITIONS ---------- */

		if ($type == 1) { // Present
			$this->db->where('pr_emp_shift_log.present_status', 'P');
		}

		if ($type == 2) { // Absent
			$this->db->select('pr_leave_trans.leave_type');
			$this->db->join('pr_leave_trans', 'pr_leave_trans.emp_id = pr_emp_com_info.emp_id', 'LEFT');
			$this->db->where('pr_emp_shift_log.present_status', 'A');
		}

		if ($type == 3) { // Leave
			$this->db->select('pr_leave_trans.leave_type');
			$this->db->join('pr_leave_trans', 'pr_leave_trans.emp_id = pr_emp_com_info.emp_id', 'LEFT');
			$this->db->where('pr_leave_trans.start_date', $date);
			$this->db->where('pr_emp_shift_log.present_status', 'L');
		}

		if ($type == 4) { // Late
			$this->db->where('pr_emp_shift_log.late_status', 1);
		}

		if ($type == 5) { // OT
			$this->db->where('pr_emp_shift_log.ot >', 0);
		}

		if ($type == 6) { // EOT
			$this->db->where('pr_emp_shift_log.eot >=', 2);
		}

		if ($type == 7 || $type == 8) { // Missing IN / OUT
			$this->db->where("
				(pr_emp_shift_log.in_time = '00:00:00'
				OR pr_emp_shift_log.out_time = '00:00:00')
			");
			$this->db->where('pr_emp_shift_log.present_status', 'P');
		}

		$this->db->order_by('pr_emp_com_info.emp_line_id', 'ASC');

		$query = $this->db->get()->result_array();

		if (empty($query)) {
			return [];
		}

		return $query;
	}



	function ot_acknowledgement_sheet($date, $grid_emp_id, $status){
		$this->db->select('
			pr_emp_com_info.emp_id,
			pr_emp_com_info.gross_sal,
			pr_emp_com_info.emp_join_date,
			pr_emp_com_info.emp_sec_id,
			pr_emp_per_info.name_en,
			pr_emp_per_info.name_bn,
			pr_emp_per_info.personal_mobile,

			emp_designation.desig_name,
			emp_designation.desig_bangla,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			emp_section.sec_name_bn,
			emp_line_num.line_name_en,
			emp_line_num.line_name_bn,
			pr_emp_shift_log.ot,
			pr_emp_shift_log.eot,
			pr_emp_shift_log.deduction_hour,
			pr_emp_shift_log.modify_eot,
		');

		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->join('emp_designation', 'emp_designation.id = pr_emp_com_info.emp_desi_id', 'LEFT');
		$this->db->join('emp_depertment', 'emp_depertment.dept_id = pr_emp_com_info.emp_dept_id', 'LEFT');
		$this->db->join('emp_section', 'emp_section.id = pr_emp_com_info.emp_sec_id', 'LEFT');
		$this->db->join('emp_line_num', 'emp_line_num.id = pr_emp_com_info.emp_line_id', 'LEFT');
		$this->db->join('pr_emp_shift_log', 'pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id', 'LEFT');
		$this->db->where('pr_emp_shift_log.shift_log_date', $date);

		$this->db->where('pr_emp_shift_log.ot !=', 0);
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		if ($status == 2) {
			$this->db->where('pr_emp_per_info.emp_sex', 2);
		}

		$this->db->order_by('pr_emp_com_info.emp_line_id','ASC');
		// $this->db->group_by('pr_emp_com_info.emp_id');
		$query = $this->db->get()->result_array();
		// dd($query);
		if(empty($query)){
			echo "Requested list is empty";
			exit;
		}else{
			return $query;
		}
	}
	//-------------------------------------------------------------------------------------------------
	// Daily Cost Sheet
	//-------------------------------------------------------------------------------------------------
	function grid_daily_costing_report($grid_date,$grid_unit,$grid_emp_id){
		$date 			= date("Y-m-d",strtotime($grid_date));

		$this->db->select("
				pr_emp_com_info.id,
				pr_emp_com_info.emp_id,
				pr_emp_com_info.unit_id,
				pr_emp_com_info.emp_sal_gra_id,
				pr_emp_com_info.emp_cat_id,
				pr_emp_com_info.gross_sal,
				pr_emp_com_info.com_gross_sal,
				pr_emp_com_info.emp_line_id,
				pr_emp_per_info.name_en,
				desig.desig_name,
				emp_line_num.line_name_en as line_name,
				pr_emp_shift_log.present_status,
				pr_emp_shift_log.ot,
				pr_emp_shift_log.eot,
				pr_emp_shift_log.modify_eot,
				pr_emp_shift_log.deduction_hour,

				allowance_tiffin_bill.allowance_amount as tiffin_bill,
				allowance_night_rules.night_allowance as night_bill,
				wholialo.allowance_amount as holiday_bill,

				pr_emp_shift_log.tiffin_allo,
				pr_emp_shift_log.night_allo,
				pr_emp_shift_log.holiday_allo,
				pr_emp_shift_log.weekly_allo,
			");
		$this->db->from('pr_emp_shift_log');
		$this->db->join("pr_emp_com_info","pr_emp_com_info.emp_id = pr_emp_shift_log.emp_id", 'left');
		$this->db->join("pr_emp_per_info","pr_emp_per_info.emp_id = pr_emp_com_info.emp_id", 'left');
		$this->db->join("emp_line_num","pr_emp_com_info.emp_line_id = emp_line_num.id", 'left');

		$this->db->join("emp_designation as desig","pr_emp_com_info.emp_desi_id = desig.id", 'left');
		$this->db->join("allowance_tiffin_bill","allowance_tiffin_bill.id = desig.tiffin_id", 'left');
		$this->db->join("allowance_night_rules","allowance_night_rules.id = desig.night_al_id", 'left');
		$this->db->join("allowance_holiday_weekend_rules wholialo","wholialo.id = desig.holiday_weekend_id", 'left');

		$this->db->where("pr_emp_com_info.unit_id",$grid_unit);
		$this->db->where("pr_emp_shift_log.shift_log_date",$date);
		$this->db->where("pr_emp_shift_log.present_status !=", 'A');
		$this->db->where_in("pr_emp_com_info.emp_id",$grid_emp_id);
		$this->db->order_by("emp_line_num.line_name_en");
		$query = $this->db->get();
		if (!empty($query->result())) {
			return $query->result();
		} else {
			return "Requested list is empty";
		}

		exit();

		foreach($query->result() as $rows){
			$emp_id 					= $rows->emp_id;
			$data['emp_id'] []			= $emp_id ;
			$data['emp_full_name'] []	= $rows->name_en;
			// $data['sec_name'] []		= $rows->sec_name_en;
			$data['line_name'] []		= $rows->line_name_en;
			$data['desig_name'][] 		= $rows->desig_name;
			$data['gross_sal'] []		= $rows->gross_sal;
			$data['present_status'] []	= $rows->present_status;
			$salary_structure 			= $this->common_model->salary_structure($rows->gross_sal);
			$ot_rate 					= $salary_structure['ot_rate'];
			$data['ot_hour'] []			= $rows->ot;
			$extra_eot 					= $rows->eot + $rows->modify_eot - $rows->deduction_hour;
			$data['extra_ot_hour'][] 	= $extra_eot;
			$data['ot_rate'][] 			= $ot_rate;
			$data['night_allo'][] 		= $rows->night_allo;
			$data['holiday_allo'][] 	= $rows->holiday_allo;
			$data['tiffin_allo'][] 		= $rows->tiffin_allo;
		}
		if(isset($data)){
			return $data;
		} else {
			return "Requested list is empty";
		}
	}

	function holiday_weekend_attn_report($emp_id, $date, $status, $unit_id = null){
		$this->db->select("
			pr_emp_com_info.id,
			pr_emp_com_info.emp_id,
			pr_emp_com_info.unit_id,
			pr_emp_com_info.emp_join_date,
			pr_emp_com_info.emp_sec_id,
			pr_emp_per_info.name_en,
			pr_emp_per_info.personal_mobile,
			desig.desig_name,
			emp_line_num.line_name_en,
			emp_section.sec_name_en,

			pr_emp_shift.shift_name,
			pr_emp_shift_log.shift_log_date,
			pr_emp_shift_log.in_time,
			pr_emp_shift_log.out_time,
			pr_emp_shift_log.present_status,
			pr_emp_shift_log.late_status,
			pr_emp_shift_log.ot,
			pr_emp_shift_log.eot,
			pr_emp_shift_log.deduction_hour,
			pr_emp_shift_log.modify_eot,
		");
		$this->db->from('pr_emp_shift_log');
		$this->db->join("pr_emp_com_info","pr_emp_com_info.emp_id = pr_emp_shift_log.emp_id", 'left');
		$this->db->join("pr_emp_per_info","pr_emp_per_info.emp_id = pr_emp_com_info.emp_id", 'left');
		$this->db->join('emp_section', 'emp_section.id = pr_emp_com_info.emp_sec_id', 'LEFT');
		$this->db->join("emp_line_num","pr_emp_com_info.emp_line_id = emp_line_num.id", 'left');
		$this->db->join("emp_designation as desig","pr_emp_com_info.emp_desi_id = desig.id", 'left');
		$this->db->join('pr_emp_shift', 'pr_emp_shift.id = pr_emp_com_info.emp_shift', 'LEFT');
		$this->db->where("pr_emp_com_info.unit_id",$unit_id);
		$this->db->where("pr_emp_shift_log.shift_log_date",$date);
		if ($status == "A") {
			$this->db->where("pr_emp_shift_log.in_time =", '00:00:00');
			$this->db->where("pr_emp_shift_log.out_time =", '00:00:00');
		} elseif ($status == "P") {
			$this->db->where("pr_emp_shift_log.in_time !=", '00:00:00');
		}
		$this->db->where_in("pr_emp_com_info.emp_id",$emp_id);
		$this->db->where_in("pr_emp_shift_log.present_status",array('H','W'));
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		if (!empty($query->result())) {
			return $query->result();
		} else {
			return "Requested list is empty";
		}
	}

	function last_increment_promotion($emp_id, $status, $unit_id = null) {
		$this->db->select("
			com.emp_id,
			com.unit_id,
			com.emp_join_date,
			per.name_en,
			per.name_bn,
			per.personal_mobile,
			per.gender,
			emp_designation.desig_bangla,
			emp_designation.desig_name,
			emp_depertment.dept_bangla,
			emp_section.sec_name_bn,
			emp_line_num.line_name_en,
			incre.prev_grade,
			incre.prev_salary,
			incre.prev_com_salary,
			incre.new_grade,
			incre.new_salary,
			incre.new_com_salary,
			incre.effective_month,
		");

		$this->db->distinct();
		$this->db->from('pr_incre_prom_pun as incre');
		$this->db->join('pr_emp_com_info as com',"incre.ref_id = com.emp_id", 'left');
		$this->db->join("pr_emp_per_info as per","per.emp_id = com.emp_id", 'left');
		$this->db->join('emp_designation', 'com.emp_desi_id = emp_designation.id');
		$this->db->join('emp_depertment', 'com.emp_dept_id = emp_depertment.dept_id');
		$this->db->join('emp_section', 'com.emp_sec_id = emp_section.id');
		$this->db->join('emp_line_num', 'com.emp_line_id = emp_line_num.id');
		$this->db->where_in("com.emp_id",$emp_id);
		$this->db->where("incre.status", $status);
		$this->db->order_by("incre.effective_month", "DESC");
		// $this->db->group_by("incre.ref_id");
		$query = $this->db->get();

		if (!empty($query->result())) {
			return $query->result();
		} else {
			return "Requested list is empty";
		}
	}

	function increment_able_employee($date, $emp_id, $unit_id = null) {
		$da1 = date('Y-m-01', strtotime('-12 month', strtotime($date)));
		$da2 = date('Y-m-t', strtotime('-12 month', strtotime($date)));

		$this->db->select("
			com.emp_id,
			com.unit_id,
			com.emp_join_date,
			com.gross_sal,
			com.com_gross_sal,
			per.name_en,
			per.name_bn,
			per.personal_mobile,
			per.gender,
			emp_designation.desig_bangla,
			emp_depertment.dept_bangla,
			emp_section.sec_name_bn,
			emp_line_num.line_name_bn,
			incre.prev_grade,
			incre.prev_salary,
			incre.prev_com_salary,
			incre.new_grade,
			incre.effective_month,
		");

		$this->db->distinct();
		$this->db->from('pr_incre_prom_pun as incre');
		$this->db->join('pr_emp_com_info as com',"incre.ref_id = com.emp_id", 'left');
		$this->db->join("pr_emp_per_info as per","per.emp_id = com.emp_id", 'left');
		$this->db->join('emp_designation', 'com.emp_desi_id = emp_designation.id');
		$this->db->join('emp_depertment', 'com.emp_dept_id = emp_depertment.dept_id');
		$this->db->join('emp_section', 'com.emp_sec_id = emp_section.id');
		$this->db->join('emp_line_num', 'com.emp_line_id = emp_line_num.id');
		$this->db->where("incre.effective_month BETWEEN '$da1' AND '$da2'");
		$this->db->where_in("com.emp_id", $emp_id);
		$this->db->order_by("incre.effective_month", "DESC");
		// $this->db->group_by("incre.ref_id");
		$array1 = $this->db->get();
		$array1 =  $array1->result_array();
		// <<<<<<<<<<<<<<  ✨ Codeium Command 🌟 >>>>>>>>>>>>>>>>
		if(!empty($array1)){
			$employee_id=array_column($array1, 'emp_id');
			$this->db->select("
				com.emp_id,
				com.unit_id,
				com.emp_join_date,
				com.gross_sal,
				com.com_gross_sal,
				per.name_en,
				per.name_bn,
				per.personal_mobile,
				per.gender,
				emp_designation.desig_bangla,
				emp_depertment.dept_bangla,
				emp_section.sec_name_bn,
				emp_line_num.line_name_bn,
			");
			$this->db->distinct();
			$this->db->from('pr_emp_com_info as com');
			$this->db->join("pr_emp_per_info as per","per.emp_id = com.emp_id", 'left');
			$this->db->join('emp_designation', 'com.emp_desi_id = emp_designation.id');
			$this->db->join('emp_depertment', 'com.emp_dept_id = emp_depertment.dept_id');
			$this->db->join('emp_section', 'com.emp_sec_id = emp_section.id');
			$this->db->join('emp_line_num', 'com.emp_line_id = emp_line_num.id');
			$this->db->where("com.emp_join_date BETWEEN '$da1' AND '$da2'");

			$this->db->where_in("com.emp_id", $emp_id);
			$this->db->where_not_in("com.emp_id", $employee_id);

			$this->db->order_by("com.emp_join_date", "DESC");
			// $this->db->group_by("com.emp_id");
			$array2 = $this->db->get();
			$array2 =  $array2->result_array();
			$array = array_merge($array1, $array2);

			if (!empty($array)) {
				return $array;
			} else {
				return "Requested list is empty";
			}
		}else{
			return "Requested list is empty";
		}
	}

	function iftar_bill_list($date1,$date2, $grid_emp_id, $unit_id){

		$data=array();
		foreach ($grid_emp_id as $key => $emp_id) {
			$amount = $this->get_desi_ifter_bill($emp_id);
			// dd($amount);
 			$day    = $this->get_desi_ifter_day($date1,$date2, $emp_id);
 			$employee_info = $this->get_employee_info($emp_id);
			if($employee_info != null){
				$employee_info->ifter_day = $day;
				$employee_info->ifter_amount = $amount;
			}
			$data[] = $employee_info;
		}
		return $data;
	}
	function get_desi_ifter_bill($emp_id){
		$this->db->select('
		allowance_iftar_bill.allowance_amount
		');

		$this->db->from('pr_emp_com_info');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->join('allowance_iftar_bill', 'emp_designation.iftar_id = allowance_iftar_bill.id');
		$this->db->where("pr_emp_com_info.emp_id",$emp_id);
		$query = $this->db->get()->row();
		return $query ? $query->allowance_amount : 0;
	}
	function get_desi_ifter_day($date1,$date2, $emp_id){
		$this->db->select('
				sum(case when pr_emp_shift_log.ifter_allo > 0 then 1 else 0 end) as day
		');
		$this->db->from('pr_emp_shift_log');
		$this->db->where("pr_emp_shift_log.emp_id",$emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date BETWEEN '$date1' AND '$date2'");
		$query = $this->db->get()->row();
		return $query->day;
	}
	function get_employee_info($emp_id){
		$this->db->select('
				per.emp_id,
				per.name_en,
				per.name_bn,
				per.personal_mobile,
				per.gender,
				emp_designation.desig_name,
				emp_depertment.dept_bangla,
				emp_section.sec_name_en,
				emp_section.sec_name_bn,
				emp_line_num.line_name_en,
				emp_line_num.line_name_bn,
		');

		$this->db->from('pr_emp_com_info');
		$this->db->join("pr_emp_per_info as per","per.emp_id = pr_emp_com_info.emp_id", 'left');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where("pr_emp_com_info.emp_id",$emp_id);
		$query = $this->db->get()->row();
		return $query;
	}
	function emp_conformation_list($emp_id, $firstdate, $unit_id, $status = null){
		$data = array();
		$this->db->distinct();
		$this->db->select('
			com.emp_id,
			per.name_en,
			per.name_bn,
			emp_designation.id,
			emp_designation.desig_name,
			emp_line_num.line_name_en,
			emp_section.sec_name_en,
			emp_depertment.dept_name,
			com.emp_join_date,
			com.unit_id,
			com.gross_sal,
			com.com_gross_sal,
		');
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('pr_emp_per_info as per');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');
		$this->db->where('per.emp_id = com.emp_id');
		$this->db->where('com.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('com.emp_desi_id = emp_designation.id');
		$this->db->where('com.emp_sec_id = emp_section.id');
		$this->db->where('com.emp_line_id = emp_line_num.id');
		$this->db->where_in('com.emp_id', $emp_id);
		// if($status != null){
		// 	$this->db->where('com.status', $status);
		// }
		$this->db->where('com.emp_join_date', $firstdate);
		$this->db->where('com.unit_id', $unit_id);
		$this->db->order_by('com.emp_join_date', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function grid_letter_report($current_date, $unit_id, $off_day, $days, $status = null){

		$get_date = $this->grid_letter_day_count($off_day, $days, $current_date, $unit_id);
		
		$this->db->select('
			per.*,
			com.emp_join_date,
			com.id as id_emp,
			com.emp_sal_gra_id as grade,
			com.com_gross_sal as salary,
			emp_designation.desig_name,
			emp_designation.desig_bangla,
			emp_depertment.dept_name,
			emp_depertment.dept_bangla,
			emp_section.sec_name_en,
			emp_section.sec_name_bn,
			emp_line_num.line_name_bn,
			emp_line_num.line_name_en,
			per_dis.name_bn as dis_name_bn,
			per_upa.name_bn as upa_name_bn,
			per_post.name_bn as post_name_bn,
			pre_dis.name_bn as dis_bn,
			pre_upa.name_bn as upa_bn,
			pre_post.name_bn as post_bn,
			lh.left_date,
			lh.left_id,
		');
		$this->db->from('pr_emp_left_history as lh');
		$this->db->join('pr_emp_com_info as com', 'lh.emp_id = com.emp_id');
		$this->db->join('pr_emp_per_info per', 'lh.emp_id = per.emp_id');

		$this->db->join('emp_designation', 'com.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('emp_depertment', 'com.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section', 'com.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'com.emp_line_id = emp_line_num.id', 'left');

		$this->db->join('emp_districts as per_dis', 'per.per_district = per_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as per_upa', 'per.per_thana = per_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as per_post', 'per.per_post = per_post.id', 'LEFT');
		$this->db->join('emp_districts as pre_dis', 'per.pre_district = pre_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as pre_upa', 'per.pre_thana = pre_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as pre_post', 'per.pre_post = pre_post.id', 'LEFT');
		$this->db->where('lh.left_date', $get_date);
		$this->db->where('lh.status', $status);
		$this->db->order_by("com.emp_id");
		$data = $this->db->get()->result();
		return $data;
	}

	function grid_letter_day_count($off_day, $days, $firstdate, $unit_id){
		$seconddate = $firstdate;
		$check_day = date("D", strtotime($firstdate));
		$num = ($check_day != $off_day)? 1:0;
		while ($num <= $days) {
			$check_day = date("D", strtotime('-1 days'.$seconddate));
			$num = ($check_day != $off_day)? $num+1:$num+0;
			$seconddate = date("Y-m-d", strtotime('-1 days'.$seconddate));
		}

		$this->db->where('unit_id', $unit_id)->where('work_off_date BETWEEN "'.$firstdate.'" AND "'.$seconddate.'"');
		$rs = $this->db->get('attn_holyday_off')->result();
		$tday = count($rs);
		if ($tday > 0) {
			$seconddate = date("Y-m-d", strtotime("-$tday days".$seconddate));
			return $seconddate;
		} else {
			return $seconddate;
		}
	}
	function grid_letter_report_print($emp_id, $unit_id = null){

		$this->db->select('
			per.*,
			com.emp_join_date,
			com.id as id_emp,
			com.emp_sal_gra_id as grade,
			com.com_gross_sal as salary,
			emp_designation.desig_name,
			emp_designation.desig_bangla,
			emp_depertment.dept_name,
			emp_depertment.dept_bangla,
			emp_section.sec_name_en,
			emp_section.sec_name_bn,
			emp_line_num.line_name_bn,
			emp_line_num.line_name_en,
			per_dis.name_bn as dis_name_bn,
			per_upa.name_bn as upa_name_bn,
			per_post.name_bn as post_name_bn,
			pre_dis.name_bn as dis_bn,
			pre_upa.name_bn as upa_bn,
			pre_post.name_bn as post_bn,
			lh.left_date,
			lh.left_id,
		');
		$this->db->from('pr_emp_left_history as lh');
		$this->db->join('pr_emp_com_info as com', 'lh.emp_id = com.emp_id');
		$this->db->join('pr_emp_per_info per', 'lh.emp_id = per.emp_id');

		$this->db->join('emp_designation', 'com.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('emp_depertment', 'com.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section', 'com.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'com.emp_line_id = emp_line_num.id', 'left');

		$this->db->join('emp_districts as per_dis', 'per.per_district = per_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as per_upa', 'per.per_thana = per_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as per_post', 'per.per_post = per_post.id', 'LEFT');
		$this->db->join('emp_districts as pre_dis', 'per.pre_district = pre_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as pre_upa', 'per.pre_thana = pre_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as pre_post', 'per.pre_post = pre_post.id', 'LEFT');
		$this->db->where('lh.emp_id', $emp_id);
		$data = $this->db->get()->result();
		return $data;
	}

	function grid_letter_report_print_no_left($emp_id, $unit_id = null){

		$this->db->select('
			per.*,
			com.emp_join_date,
			com.id as id_emp,
			com.emp_sal_gra_id as grade,
			com.com_gross_sal as salary,
			emp_designation.desig_name,
			emp_designation.desig_bangla,
			emp_depertment.dept_name,
			emp_depertment.dept_bangla,
			emp_section.sec_name_en,
			emp_section.sec_name_bn,
			emp_line_num.line_name_bn,
			emp_line_num.line_name_en,
			per_dis.name_bn as dis_name_bn,
			per_upa.name_bn as upa_name_bn,
			per_post.name_bn as post_name_bn,
			pre_dis.name_bn as dis_bn,
			pre_upa.name_bn as upa_bn,
			pre_post.name_bn as post_bn,
			lh.left_date,
			lh.left_id,
		');
		$this->db->from('pr_emp_com_info as com');
		$this->db->join('pr_emp_left_history as lh', 'com.emp_id = lh.emp_id', 'left');
		$this->db->join('pr_emp_per_info per', 'com.emp_id = per.emp_id');

		$this->db->join('emp_designation', 'com.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('emp_depertment', 'com.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section', 'com.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'com.emp_line_id = emp_line_num.id', 'left');

		$this->db->join('emp_districts as per_dis', 'per.per_district = per_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as per_upa', 'per.per_thana = per_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as per_post', 'per.per_post = per_post.id', 'LEFT');
		$this->db->join('emp_districts as pre_dis', 'per.pre_district = pre_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as pre_upa', 'per.pre_thana = pre_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as pre_post', 'per.pre_post = pre_post.id', 'LEFT');
		$this->db->where('com.emp_id', $emp_id);
		$data = $this->db->get()->result();
		return $data;
	}

	//  =======================  start continuous report  ======================
	function continuous_leave_report($firstdate, $seconddate, $status, $emp_ids)
	{
		$this->db->select("
				pr_leave_trans.*,
				emp_section.sec_name_en,
				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.emp_sec_id,
				pr_emp_per_info.name_en,
				emp_line_num.line_name_en,
			");
		$this->db->from("pr_leave_trans");
		$this->db->join('pr_emp_com_info', 'pr_leave_trans.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('pr_emp_per_info', 'pr_emp_com_info.emp_id = pr_emp_per_info.emp_id');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->join('emp_section', 'emp_section.id = pr_emp_com_info.emp_sec_id');
		$this->db->where_in("pr_leave_trans.emp_id", $emp_ids);
		// $this->db->group_by("pr_leave_trans.emp_id");
		$this->db->where("pr_leave_trans.leave_start Between '$firstdate' and '$seconddate'");
		$query = $this->db->get()->result();
		// dd($query );
		if($query)
		{
			return $query;
		}
		else
		{
			return "Requested list is empty";
		}
	}
	function continuous_incre_report($grid_firstdate,$grid_seconddate,$grid_emp_id)
	{
			$this->db->select('prev_emp_id,new_emp_id,prev_dept,new_dept,prev_section,new_section,prev_line, new_line, prev_desig,new_desig,prev_salary,new_salary,effective_month, ref_id, new_grade');
			$this->db->where_in("ref_id",$grid_emp_id);
			$this->db->where("status","1");
			$where ="effective_month BETWEEN '$grid_firstdate' and '$grid_seconddate'";
			$this->db->where($where);
			$this->db->order_by("new_section","ASC");
			$this->db->order_by("ref_id","ASC");
			$this->db->order_by("effective_month","desc");
			$query = $this->db->get('pr_incre_prom_pun');
			$data=array();
			if($query->num_rows() != 0)
			{
				foreach ($query->result() as $rows)
				{
					$data["ref_id"][] 					= $rows->ref_id;
					$data["new_grade"][] 				= $rows->new_grade;
					$data["prev_emp_id"][] 				= $rows->prev_emp_id;
					$data["new_emp_id"][] 				= $rows->new_emp_id;
					//$data["emp_name"][] 				= $rows->emp_full_name;
					$prev_dept_name = $this->get_dept_name($rows->prev_dept);
					$prev_section_name = $this->get_section_name($rows->prev_section);
					$prev_line_name = $this->get_line_name($rows->prev_line);
					$prev_desig_name = $this->get_desig_name($rows->prev_desig);

					$data["prev_dept"][] 				= $prev_dept_name;
					$data["prev_section"][] 			= $prev_section_name;
					$data["prev_line"][] 				= $prev_line_name;
					$data["prev_desig"][]				= $prev_desig_name;
					$data["prev_salary"][] 				= $rows->prev_salary;;

					$new_dept_name = $this->get_dept_name($rows->new_dept);
					$new_section_name = $this->get_section_name($rows->new_section);
					$new_line_name = $this->get_line_name($rows->new_line);
					$new_desig_name = $this->get_desig_name($rows->new_desig);

					$data["new_dept"][] 				= $new_dept_name;
					$data["new_section"][] 				= $new_section_name;
					$data["new_line"][] 				= $new_line_name;
					$data["new_desig"][] 				= $new_desig_name;
					$data["new_salary"][] 				= $rows->new_salary;;
					$data["effective_month"][] 			= $rows->effective_month;

				}
			}
		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}
	function continuous_prom_report($grid_firstdate,$grid_seconddate,$grid_emp_id)
	{
		$this->db->select('prev_emp_id,new_emp_id,prev_dept,new_dept,prev_section,new_section,prev_line, new_line, prev_desig,new_desig,prev_salary,new_salary,effective_month, ref_id, new_grade');
		$this->db->where_in("ref_id",$grid_emp_id);
		$this->db->where("status","2");
		$where ="effective_month BETWEEN '$grid_firstdate' and '$grid_seconddate'";
		$this->db->where($where);
		$this->db->order_by("new_section","ASC");
		$this->db->order_by("ref_id","ASC");
		$this->db->order_by("effective_month","desc");

		$query = $this->db->get('pr_incre_prom_pun');
		$data=array();
		if($query->num_rows() != 0)
		{
			foreach ($query->result() as $rows)
			{
				$data["ref_id"][] 					= $rows->ref_id;
				$data["new_grade"][] 				= $rows->new_grade;
				$data["prev_emp_id"][] 				= $rows->prev_emp_id;
				$data["new_emp_id"][] 				= $rows->new_emp_id;
				//$data["emp_name"][] 				= $rows->emp_full_name;
				$prev_dept_name = $this->get_dept_name($rows->prev_dept);
				$prev_section_name = $this->get_section_name($rows->prev_section);
				$prev_line_name = $this->get_line_name($rows->prev_line);
				$prev_desig_name = $this->get_desig_name($rows->prev_desig);

				$data["prev_dept"][] 				= $prev_dept_name;
				$data["prev_section"][] 			= $prev_section_name;
				$data["prev_line"][] 				= $prev_line_name;
				$data["prev_desig"][]				= $prev_desig_name;
				$data["prev_salary"][] 				= $rows->prev_salary;;

				$new_dept_name = $this->get_dept_name($rows->new_dept);
				$new_section_name = $this->get_section_name($rows->new_section);
				$new_line_name = $this->get_line_name($rows->new_line);
				$new_desig_name = $this->get_desig_name($rows->new_desig);

				$data["new_dept"][] 				= $new_dept_name;
				$data["new_section"][] 				= $new_section_name;
				$data["new_line"][] 				= $new_line_name;
				$data["new_desig"][] 				= $new_desig_name;
				$data["new_salary"][] 				= $rows->new_salary;;
				$data["effective_month"][] 			= $rows->effective_month;

			}
		}

		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}
	function continuous_ot_eot_report($firstdate, $seconddate, $grid_emp_id)
	{
		$this->db->select('
			pr_emp_com_info.emp_id,
			ANY_VALUE(pr_emp_com_info.id) as user_id,
			ANY_VALUE(pr_emp_com_info.unit_id) as unit_id,
			ANY_VALUE(pr_emp_com_info.emp_join_date) as doj,
			ANY_VALUE(pr_emp_com_info.emp_cat_id) as emp_cat_id,
			ANY_VALUE(pr_emp_com_info.gross_sal) as gross_sal,
			ANY_VALUE(pr_emp_per_info.name_en) as emp_name,
			ANY_VALUE(emp_designation.desig_name) as desig_name,
			ANY_VALUE(emp_depertment.dept_name) as dept_name,
			ANY_VALUE(emp_section.sec_name_en) as sec_name,
			ANY_VALUE(emp_line_num.line_name_en) as line_name,
			SUM(pr_emp_shift_log.ot) as ot_hour,
			SUM(pr_emp_shift_log.eot) as eot_hour,
			SUM(pr_emp_shift_log.deduction_hour) as deduction_hour
		');
		$this->db->from('pr_emp_per_info');
		$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->join('pr_emp_shift_log', 'pr_emp_com_info.emp_id = pr_emp_shift_log.emp_id');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date BETWEEN '$firstdate' AND '$seconddate'");
		$this->db->group_by("pr_emp_com_info.emp_id");
		$this->db->order_by("pr_emp_com_info.emp_id", "ASC");
		$query = $this->db->get()->result_array();
		return $query;
	}

	function grid_continuous_max_ot_day($firstdate, $seconddate, $emp_ids, $max_ot)
	{
		$this->db->select("
				pr_emp_com_info.emp_id,
				pr_emp_com_info.id as user_id,
				pr_emp_com_info.unit_id,
				pr_emp_com_info.emp_join_date as doj,
				pr_emp_com_info.emp_cat_id,
				pr_emp_com_info.gross_sal,
				pr_emp_per_info.name_en as emp_name,
				emp_designation.desig_name,
				emp_depertment.dept_name,
				emp_section.sec_name_en as sec_name,
				emp_line_num.line_name_en as line_name,
				SUM( CASE WHEN log.tot >= '$max_ot' THEN 1 ELSE 0 END ) AS ot_day,
				SUM( CASE WHEN log.tot >= '$max_ot' THEN log.tot ELSE 0 END ) AS max_ot,
				SUM(log.tot) as tot_hour,
				SUM(log.ot) as ot_hour,
				SUM(log.eot) as eot_hour,
				SUM(log.deduction_hour) as deduction_hour,
			");
		$this->db->from('pr_emp_per_info');
		$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->join('pr_emp_shift_log as log', 'pr_emp_com_info.emp_id = log.emp_id');
		$this->db->where("log.tot >=", $max_ot);
		$this->db->where_in("pr_emp_com_info.emp_id", $emp_ids);
		$this->db->where("log.shift_log_date BETWEEN '$firstdate' AND '$seconddate'");
		$this->db->group_by("pr_emp_com_info.emp_id");
		$this->db->order_by("pr_emp_com_info.emp_id", "ASC");
		$query = $this->db->get()->result_array();
		return $query;
	}

	function grid_continuous_costing_report($firstdate, $seconddate, $grid_unit, $grid_emp_id)
	{
		$firstdate = date("Y-m-d", strtotime($firstdate));
		$seconddate = date("Y-m-d", strtotime($seconddate));

		$this->db->select("
			pr_emp_com_info.emp_id,
			ANY_VALUE(pr_emp_com_info.gross_sal) as gross_sal,
			ANY_VALUE(pr_emp_per_info.name_en) as name_en,
			ANY_VALUE(emp_designation.desig_name) as desig_name,
			ANY_VALUE(emp_section.sec_name_en) as sec_name_en,
			ANY_VALUE(emp_line_num.line_name_en) as line_name_en,
			SUM(pr_emp_shift_log.ot) as total_ot,
			SUM(pr_emp_shift_log.eot) as total_extra_ot_hour,
			COUNT(pr_emp_shift_log.present_status) as total_day,
			SUM(pr_emp_shift_log.deduction_hour) as total_deduction_hour
		");

		$this->db->from('pr_emp_per_info');
		$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id', 'left');
		$this->db->join('pr_emp_shift_log', 'pr_emp_com_info.emp_id = pr_emp_shift_log.emp_id', 'left');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date >=", $firstdate);
		$this->db->where("pr_emp_shift_log.shift_log_date <=", $seconddate);
		$this->db->where("pr_emp_shift_log.present_status !=", "A");
		$this->db->group_by("pr_emp_com_info.emp_id");
		// ✅ FIX HERE
		$this->db->order_by("line_name_en");
		$query = $this->db->get();

		$data = [];

		foreach ($query->result() as $rows) {
			$emp_id = $rows->emp_id;

			$data['emp_id'][] = $emp_id;
			$data['emp_full_name'][] = $rows->name_en;
			$data['sec_name'][] = $rows->sec_name_en;
			$data['line_name'][] = $rows->line_name_en;
			$data['desig_name'][] = $rows->desig_name;
			$data['gross_sal'][] = $rows->gross_sal;

			$salary_structure = $this->common_model->salary_structure($rows->gross_sal);
			$ot_rate = $salary_structure['ot_rate'];
			$data['ot_hour'][] = $rows->total_ot;
			$total_extra_ot_hour = $rows->total_extra_ot_hour - $rows->total_deduction_hour;
			$data['extra_ot_hour'][] = $total_extra_ot_hour;
			$data['total_day'][] = $rows->total_day;
			$data['ot_rate'][] = $ot_rate;
		}

		if (!empty($data)) {
			return $data;
		} else {
			return "Requested list is empty";
		}
	}
	// ========================  end continuous report  ========================
	// ========================  start maternity leave   ========================
	function grid_maternity_benefit($emp_ids, $firstdate, $seconddate){
		$this->db->select('
					com.emp_join_date,
					per.name_en,
					per.name_bn,
					meh.*,
					emp_designation.desig_bangla,
					emp_line_num.line_name_bn,
					emp_section.sec_name_bn,
					pr_grade.gr_name'
				);
		$this->db->from('pr_maternity_entry_histry as meh');
		$this->db->from('pr_emp_com_info as com');
		$this->db->from('pr_emp_per_info as per');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');
		$this->db->from('pr_grade');
		$this->db->where("meh.emp_id = com.emp_id");
		$this->db->where("com.emp_id = per.emp_id");
		$this->db->where("com.emp_sec_id = emp_section.id");
		$this->db->where("com.emp_line_id = emp_line_num.id");
		$this->db->where("com.emp_desi_id = emp_designation.id");
		$this->db->where("com.emp_sal_gra_id = pr_grade.gr_id");
		$this->db->where('per.gender', 'Female');
		$this->db->where_in("meh.emp_id", $emp_ids);

		// $this->db->where("meh.start_date >=", $firstdate);
		// $this->db->where("meh.end_date <=", $seconddate);
		// $this->db->where("substr(meh.start_date,1,4)='$grid_year'");
		$query = $this->db->get()->result();
		return $query;
	}
	// ========================  end maternity leave   ========================

	// ========================  Salary with eot sheet bank  ========================
	function grid_salary_sheet_with_eot_bank($sal_year_month, $grid_status, $grid_emp_id)
	{
		$this->db->select('
			emp_line_num.*,
			pr_emp_per_info.name_en,
			pr_emp_per_info.bank_bkash_no,
			emp_designation.desig_name,
			emp_designation.desig_bangla,
			emp_section.*,
			pr_emp_com_info.ot_entitle,
			pr_emp_com_info.emp_join_date,
			pr_grade.gr_name,
			pr_grade.gr_name,
			pay_salary_sheet.*,
			emp_line_num.line_name_en
		');
		$this->db->from('pr_emp_per_info');
		$this->db->join('pr_emp_com_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','left');
		$this->db->join('pr_grade','pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id','left');
		$this->db->join('pay_salary_sheet','pr_emp_per_info.emp_id = pay_salary_sheet.emp_id','left');
		$this->db->join('emp_depertment','pr_emp_com_info.emp_dept_id = emp_depertment.dept_id','left');
		$this->db->join('emp_section','pr_emp_com_info.emp_sec_id = emp_section.id','left');
		$this->db->join('emp_line_num','pr_emp_com_info.emp_line_id = emp_line_num.id','left');
		$this->db->join('emp_designation','pr_emp_com_info.emp_desi_id = emp_designation.id','left');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where("pay_salary_sheet.salary_month = '$sal_year_month'");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		return $query->result();
	}
	function grid_monthly_salary_sheet_for_allowance($date, $grid_status, $grid_emp_id)
	{
		$this->db->select('pr_emp_per_info.name_en,emp_designation.desig_name, emp_section.sec_name_en, pr_emp_com_info.emp_join_date,pr_grade.gr_name,pay_salary_sheet.*,pr_emp_com_info.emp_join_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');

		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where("pay_salary_sheet.salary_month = '$date'");
		$this->db->where("pay_salary_sheet.total_allaw !=", 0);
		$this->db->where('pay_salary_sheet.id = (
			SELECT MAX(id)
			FROM pay_salary_sheet
			WHERE emp_id = pr_emp_com_info.emp_id
		)');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->order_by("emp_designation.desig_name");
		// $this->db->group_by("pay_salary_sheet.emp_id");
		$query = $this->db->get();
		return $query->result();
	}
	// ========================  Salary with eot sheet bank end ========================






















	// =======================================================
		// old code
	// =======================================================

	function grid_nominee($grid_emp_id){
		$this->db->select('pr_emp_skill.*,pr_emp_edu.*,pr_id_proxi.proxi_id,pr_emp_com_info.emp_id, pr_emp_per_info.name_en, emp_depertment.dept_name,emp_depertment.dept_bangla, emp_section.sec_name_en, emp_line_num.line_name_en, emp_line_num.line_name_en,emp_designation.desig_name,emp_designation.desig_bangla,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal, pr_emp_per_info.spouse_name, pr_emp_per_info.f_child,pr_emp_per_info.m_child,pr_emp_per_info.name_bn,pr_emp_per_info.father_name, pr_emp_per_info.mother_name,pr_emp_per_info.emp_dob,pr_emp_per_info.identificatiion_marks,pr_emp_per_info.national_brn_id,pr_emp_per_info.img_source,pr_emp_add.emp_pre_add,pr_emp_add.emp_par_add_ban');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');
		$this->db->from('pr_emp_add');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_edu');
		$this->db->from('pr_emp_skill');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_edu.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();

	}

	function grid_requitement_form($grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id, pr_emp_per_info.name_en, emp_depertment.dept_name,emp_depertment.dept_bangla, emp_section.sec_name_en,emp_section.sec_name_en_bn, emp_line_num.line_name_en, emp_line_num.line_bangla,emp_designation.desig_name,emp_designation.desig_bangla,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal, pr_emp_per_info.spouse_name, pr_emp_per_info.no_child,pr_emp_per_info.bangla_nam,pr_emp_per_info.emp_fname, pr_emp_per_info.emp_mname,pr_emp_per_info.emp_dob,pr_emp_per_info.identificatiion_marks,pr_emp_per_info.national_brn_id,pr_emp_per_info.img_source,pr_emp_add.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->from('pr_emp_add');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		//$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function grid_verification_report($grid_emp_id){
		$this->db->select('pr_emp_edu.*,pr_emp_skill.*,pr_id_proxi.proxi_id,pr_emp_com_info.emp_id, pr_emp_per_info.name_en, emp_depertment.dept_name,emp_depertment.dept_bangla, emp_section.*, emp_line_num.line_name_en, emp_line_num.line_bangla,emp_designation.desig_name,emp_designation.desig_bangla,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal, pr_emp_per_info.spouse_name, pr_emp_per_info.no_child,pr_emp_per_info.bangla_nam,pr_emp_per_info.emp_fname, pr_emp_per_info.emp_mname,pr_emp_per_info.emp_dob,pr_emp_per_info.identificatiion_marks,pr_emp_per_info.national_brn_id,pr_emp_per_info.img_source,pr_emp_add.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->from('pr_emp_add');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_skill');
			$this->db->from('pr_emp_edu');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_edu.emp_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();

	}

	function first_letter_of_maternity_leave($grid_firstdate,$grid_emp_id){
		//print_r($grid_emp_id);
		$this->db->select('pr_emp_blood_groups.blood_name,pr_emp_position.posi_name,pr_emp_skill.*,pr_emp_edu.*,pr_emp_per_info.no_child,pr_emp_sex.sex_nam_bng,pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_per_info.name_en, pr_emp_per_info.bangla_nam , pr_emp_per_info.emp_fname,pr_emp_per_info.emp_mname, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, pr_emp_com_info.emp_sal_gra_id , emp_depertment.dept_name,emp_depertment.dept_bangla, emp_section.sec_name_en, emp_section.sec_name_en_bn, pr_id_proxi.proxi_id, pr_emp_add.emp_pre_add,pr_emp_add.emp_pre_add_ban, pr_emp_add.emp_par_add,pr_emp_add.emp_par_add_ban,pr_emp_per_info.emp_dob,pr_emp_per_info.emp_religion,pr_religions.religion_name');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->from('pr_religions');
		$this->db->from('pr_emp_sex');
		$this->db->from('pr_emp_edu');
		$this->db->from('pr_emp_skill');
		$this->db->from('pr_emp_position');
		$this->db->from('pr_emp_blood_groups');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_per_info.emp_religion = pr_religions.religion_id');
		$this->db->where('pr_emp_per_info.emp_sex = pr_emp_sex.sex_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_edu.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		$this->db->where('pr_emp_com_info.emp_position_id = pr_emp_position.posi_id');
		$this->db->where('pr_emp_per_info.emp_blood = pr_emp_blood_groups.blood_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		//echo $this->db->last_query();

		//print_r($query) ;

		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";
		}
		else
		{
			return $query;
		}
		//print_r($query->result_array());
	}

	function incre_prom_report_db($grid_firstdate,$grid_emp_id){
		$data = array();
		foreach($grid_emp_id as $emp_id)
		{
			//echo $emp_id;
			$this->db->select('*');
			$this->db->where("ref_id",$emp_id);
			$this->db->like("effective_month",$grid_firstdate);
			$this->db->order_by("effective_month","desc");

			$query = $this->db->get('pr_incre_prom_pun');
			//echo $query->num_rows();
			//echo $this->db->last_query();
			$data=array();
			if($query->num_rows() != 0)
			{
				foreach ($query->result() as $rows)
				{
					$data["prev_emp_id"][] 				= $rows->prev_emp_id;
					$data["new_emp_id"][] 				= $rows->new_emp_id;
					//$data["emp_name"][] 				= $rows->emp_full_name;
					$prev_dept_name = $this->get_dept_name($rows->prev_dept);
					$prev_section_name = $this->get_section_name($rows->prev_section);
					$prev_line_name = $this->get_line_name($rows->prev_line);
					$prev_desig_name = $this->get_desig_name($rows->prev_desig);

					$data["prev_dept"][] 				= $prev_dept_name;
					$data["prev_section"][] 			= $prev_section_name;
					$data["prev_line"][] 				= $prev_line_name;
					$data["prev_desig"][]				= $prev_desig_name;
					$data["prev_salary"][] 				= $rows->prev_salary;;

					$new_dept_name = $this->get_dept_name($rows->new_dept);
					$new_section_name = $this->get_section_name($rows->new_section);
					$new_line_name = $this->get_line_name($rows->new_line);
					$new_desig_name = $this->get_desig_name($rows->new_desig);

					$data["new_dept"][] 				= $new_dept_name;
					$data["new_section"][] 				= $new_section_name;
					$data["new_line"][] 				= $new_line_name;
					$data["new_desig"][] 				= $new_desig_name;
					$data["new_salary"][] 				= $rows->new_salary;;
					$data["effective_month"][] 			= $rows->effective_month;
					$data["status"][] 					= $rows->status;

				}
			}
		}

		//print_r($data);
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}

	}

	function incre_prom_report($first_date,$second_date,$emp_id,$type, $skip = null){
		$this->db->select('
			pr_emp_per_info.id as letter_id,
			pr_emp_per_info.name_bn,
			pr_emp_per_info.gender,
			pr_emp_com_info.emp_join_date,
			pr_emp_com_info.emp_sal_gra_id as current_grade,
			prev_dept_name.dept_bangla as prev_dept_name,
			prev_sec_name.sec_name_bn as prev_sec_name,
			prev_line_name.line_name_bn as prev_line_name,
			prev_desig_name.desig_bangla as prev_desig_name,
			prev_grade_name.gr_name as prev_grade_name,
			new_dept_name.dept_bangla as new_dept_name,
			new_sec_name.sec_name_bn as new_sec_name,
			new_line_name.line_name_bn as new_line_name,
			new_desig_name.desig_bangla as new_desig_name,
			new_grade_name.gr_name as new_grade_name,
			incre.prev_emp_id as emp_id,
			incre.effective_month as effective_month,
			incre.prev_salary as prev_salary,
			incre.new_salary as new_salary,
			incre.status
		');

		// Subquery to get latest id per ref_id
		$this->db->from('pr_incre_prom_pun incre');
		$this->db->join(
			'(SELECT ref_id, MAX(id) as max_id FROM pr_incre_prom_pun GROUP BY ref_id) as latest_ids',
			'incre.id = latest_ids.max_id AND incre.ref_id = latest_ids.ref_id',
			'inner'
		);
		$this->db->join('pr_emp_per_info', 'incre.ref_id = pr_emp_per_info.emp_id','left');
		$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('emp_depertment as prev_dept_name',  'incre.prev_dept    = prev_dept_name.dept_id','left');
		$this->db->join('emp_section as prev_sec_name',      'incre.prev_section = prev_sec_name.id','left');
		$this->db->join('emp_line_num as prev_line_name',    'incre.prev_line    = prev_line_name.id','left');
		$this->db->join('emp_designation as prev_desig_name','incre.prev_desig   = prev_desig_name.id','left');
		$this->db->join('pr_grade as prev_grade_name',       'incre.prev_grade   = prev_grade_name.gr_id','left');
		$this->db->join('emp_depertment as new_dept_name',   'incre.new_dept = new_dept_name.dept_id','left');
		$this->db->join('emp_section as new_sec_name',       'incre.new_section = new_sec_name.id','left');
		$this->db->join('emp_line_num as new_line_name',     'incre.new_line = new_line_name.id','left');
		$this->db->join('emp_designation as new_desig_name', 'incre.new_desig = new_desig_name.id','left');
		$this->db->join('pr_grade as new_grade_name',        'incre.new_grade = new_grade_name.gr_id','left');

		$this->db->where_in('pr_emp_com_info.emp_id', $emp_id);

		if (empty($skip)) {
			$this->db->where('incre.effective_month BETWEEN "'.$first_date.'" AND "'.$second_date.'"');
		}

		if($type == 1){
			$this->db->where_in('incre.status', array(1,4));
		} else if($type == 2){
			$this->db->where_in('incre.status', 2);
		} else {
			$this->db->where_in('incre.status', 3);
		}

		$this->db->order_by('incre.effective_month','DESC');
		$this->db->order_by('incre.id','DESC');

		// No group_by needed anymore
		$query = $this->db->get()->result();


		if(!empty($query)){
			return $query;
		}else{
			dd("Requested list is empty") ;
		}
	}

	function prom_report_db($grid_firstdate,$grid_emp_id){
		//echo $grid_firstdate;
		//echo $search_year_month = substr($grid_firstdate,0,7);
		$data = array();
		foreach($grid_emp_id as $emp_id)
		{
			//echo $emp_id;
			$this->db->select('*');
			$this->db->where("ref_id",$emp_id);
			$this->db->like("effective_month",$grid_firstdate);
			$this->db->order_by("effective_month","desc");

			$query = $this->db->get('pr_incre_prom_pun');
			//echo $query->num_rows();
			//echo $this->db->last_query();
			if($query->num_rows() != 0)
			{
				foreach ($query->result() as $rows)
				{
					$data["prev_emp_id"][] 				= $rows->prev_emp_id;
					$data["new_emp_id"][] 				= $rows->new_emp_id;
					//$data["emp_name"][] 				= $rows->emp_full_name;
					$prev_dept_name = $this->get_dept_name($rows->prev_dept);
					$prev_section_name = $this->get_section_name($rows->prev_section);
					$prev_line_name = $this->get_line_name($rows->prev_line);
					$prev_desig_name = $this->get_desig_name($rows->prev_desig);

					$data["prev_dept"][] 				= $prev_dept_name;
					$data["prev_section"][] 			= $prev_section_name;
					$data["prev_line"][] 				= $prev_line_name;
					$data["prev_desig"][]				= $prev_desig_name;
					$data["prev_salary"][] 				= $rows->prev_salary;;

					$new_dept_name = $this->get_dept_name($rows->new_dept);
					$new_section_name = $this->get_section_name($rows->new_section);
					$new_line_name = $this->get_line_name($rows->new_line);
					$new_desig_name = $this->get_desig_name($rows->new_desig);

					$data["new_dept"][] 				= $new_dept_name;
					$data["new_section"][] 				= $new_section_name;
					$data["new_line"][] 				= $new_line_name;
					$data["new_desig"][] 				= $new_desig_name;
					$data["new_salary"][] 				= $rows->new_salary;;
					$data["effective_month"][] 			= $rows->effective_month;
					$data["status"][] 					= $rows->status;

				}
			}
		}

		//print_r($data);
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}

	}

	function shorts_emp_summery($year, $month, $date, $status, $grid_emp_id){
		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date,pr_emp_shift.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_shift');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_com_info.emp_shift",1);
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);
		$query = $this->db->get();
		$stuff = $query->row();
		$stuff = $stuff->shift_name;
		/*echo "<pre>";
		echo $this->db->last_query();exit;*/
		$total_emp = $query->num_rows();



		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date,pr_emp_shift.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_shift');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_com_info.emp_shift",2);
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);
		$query = $this->db->get();

		$worker = $query->row();
		$worker = $worker->shift_name;

		// echo "<pre>";
		// echo $this->db->last_query();exit;

		$total_emp1 = $query->num_rows();




		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date,pr_emp_shift.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_shift');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_com_info.emp_shift",19);
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);

		$query = $this->db->get();

		$cleaning = $query->row();
		$cleaning = $cleaning->shift_name;

		// echo "<pre>";
		// echo $this->db->last_query();exit;

		$total_emp2 = $query->num_rows();


		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where("pr_emp_com_info.emp_shift",1);
		$this->db->where("pr_emp_per_info.emp_sex",'2');
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);
		$query = $this->db->get();
		$female = $query->num_rows();
		// echo "<pre>";
		// echo $this->db->last_query();exit;


		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where("pr_emp_com_info.emp_shift",2);
		$this->db->where("pr_emp_per_info.emp_sex",'2');
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);
		$query = $this->db->get();
		$female1 = $query->num_rows();


		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where("pr_emp_com_info.emp_shift",19);
		$this->db->where("pr_emp_per_info.emp_sex",'2');
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);
		$query = $this->db->get();
		$female2 = $query->num_rows();



		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where("pr_emp_com_info.emp_shift",1);
		$this->db->where("pr_emp_per_info.emp_sex",'1');
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);
		$query = $this->db->get();
		$male = $query->num_rows();


		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where("pr_emp_com_info.emp_shift",2);
		$this->db->where("pr_emp_per_info.emp_sex",'1');
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);
		$query = $this->db->get();
		$male1 = $query->num_rows();


		$this->db->select('pr_emp_per_info.emp_id,pr_emp_com_info.emp_join_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where("pr_emp_com_info.emp_shift",19);
		$this->db->where("pr_emp_per_info.emp_sex",'1');
		$this->db->where("pr_emp_com_info.emp_cat_id",1);
		$this->db->or_where("pr_emp_com_info.emp_cat_id",2);
		$query = $this->db->get();
		$male2 = $query->num_rows();


		$male_female = array("total_emp"=>$total_emp,"stuff"=>$stuff, "worker"=>$worker, "cleaning"=>$cleaning,"male"=>$male, "female"=>$female,"total_emp1"=>$total_emp1,"male1"=>$male1, "female1"=>$female1,"total_emp2"=>$total_emp2,"male2"=>$male2, "female2"=>$female2);

		return $male_female;

	}

	function grid_job_description($grid_emp_id){
		$this->db->select('pr_emp_job_desc.description,pr_emp_skill.*,pr_id_proxi.proxi_id,pr_emp_com_info.emp_id, pr_emp_per_info.name_en, emp_depertment.dept_name,emp_depertment.dept_bangla, emp_section.*, emp_line_num.line_name_en, emp_line_num.line_bangla,emp_designation.desig_name,emp_designation.desig_bangla,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal, pr_emp_per_info.spouse_name, pr_emp_per_info.no_child,pr_emp_per_info.bangla_nam,pr_emp_per_info.emp_fname, pr_emp_per_info.emp_mname,pr_emp_per_info.emp_dob,pr_emp_per_info.identificatiion_marks,pr_emp_per_info.national_brn_id,pr_emp_per_info.img_source,pr_emp_add.emp_pre_add,pr_emp_add.emp_par_add');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->from('pr_emp_add');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_skill');
			$this->db->from('pr_emp_job_desc');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = pr_emp_job_desc.emp_desig_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function grid_age_estimation($grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_per_info.*, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, pr_emp_com_info.emp_sal_gra_id , emp_depertment.dept_name, emp_section.sec_name_en, emp_section.sec_name_en_bn, pr_id_proxi.proxi_id, pr_emp_add.*');

		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		return $query->result();
	}

	function bando_certificate_report($grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_per_info.*, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, pr_emp_com_info.emp_sal_gra_id , emp_depertment.dept_name, emp_section.sec_name_en, emp_section.sec_name_en_bn, pr_id_proxi.proxi_id, pr_emp_add.*');

		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		return $query->result();
	}


	function one_month_settel_paid_report($grid_emp_id,$year_month){
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_per_info.name_en,pr_emp_per_info.emp_fname,pr_emp_per_info.emp_mname, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_depertment.dept_bangla, emp_section.sec_name_en, emp_section.sec_name_en_bn, emp_line_num.line_name_en ,emp_line_num.line_bangla,pr_emp_com_info.emp_sal_gra_id, pr_id_proxi.proxi_id, pr_emp_add.emp_pre_add, pr_emp_add.emp_par_add, pr_emp_position.posi_name,pr_grade.gr_name, pay_salary_sheet_com.* ,pr_emp_per_info.bangla_nam');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_add');
			$this->db->from('pr_grade');
			$this->db->from('pr_emp_position');
			$this->db->from('pay_salary_sheet_com');
			$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
			$this->db->like('pay_salary_sheet_com.salary_month', $year_month);
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_com_info.emp_position_id = pr_emp_position.posi_id');
			$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet_com.emp_id');
			$this->db->order_by("pr_emp_com_info.emp_id");
			$query = $this->db->get();

		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";

		}
		else
		{
			return $query->result_array();
		}
		//print_r($query->result_array());
		//return $query->result();
	}

	function grid_drugscreening_report($grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_com_info.emp_join_date,pr_emp_per_info.*, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, pr_emp_com_info.emp_sal_gra_id , emp_depertment.dept_name, emp_section.sec_name_en, emp_section.sec_name_en_bn, pr_id_proxi.proxi_id, pr_emp_add.*,pr_emp_operation.ope_name,pr_emp_position.posi_name');

		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->from('pr_emp_operation');
		$this->db->from('pr_emp_position');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_operation_id = pr_emp_operation.ope_id');
		$this->db->where('pr_emp_com_info.emp_position_id = pr_emp_position.posi_id');
		//$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		return $query->result();

	}

	function ackknowledgement_report($grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_com_info.emp_join_date,pr_emp_per_info.*, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, pr_emp_com_info.emp_sal_gra_id , emp_depertment.dept_name, emp_section.sec_name_en, emp_section.sec_name_en_bn, pr_id_proxi.proxi_id, pr_emp_add.*');

		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		return $query = $this->db->get();

	}

	function earnl_payment($grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_com_info.emp_join_date,pr_emp_per_info.*, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, pr_emp_com_info.emp_sal_gra_id , emp_depertment.dept_name, emp_section.sec_name_en, emp_section.sec_name_en_bn, pr_id_proxi.proxi_id, pr_emp_add.*');

		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		return $query->result();

	}

	function grid_pension_report($grid_firstdate, $grid_seconddate, $grid_emp_id){
		$first_check_day = 365*4 + 240 + 1; // 1 add for one leap year
		$first_check_time = $first_check_day*24*60*60;

		$second = strtotime($grid_seconddate);
		$check_date = $second - $first_check_time;
		echo $check_date = date('d-m-Y',$check_date);

		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_resign_history.resign_date as e_date, pr_emp_add.emp_pre_add');

		$this->db->from('pr_emp_com_info');

		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->join('pr_emp_per_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('pr_emp_add','pr_emp_add.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('pr_emp_resign_history','pr_emp_resign_history.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id');
		$this->db->join('emp_depertment','emp_depertment.dept_id = pr_emp_com_info.emp_dept_id');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id');
		$this->db->join('pr_id_proxi','pr_id_proxi.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('pr_emp_shift','pr_emp_shift.id = pr_emp_com_info.emp_shift');

		$this->db->where("pr_emp_resign_history.resign_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		$this->db->where("pr_emp_com_info.emp_join_date <=",$check_date);
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo "<pre>";
		//print_r($query->result_array());
		//echo $query->num_rows();exit;
		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";

		}
		else
		{
			return $query;
		}
	}

	function grid_earn_leave_payment_buyer($resign_date, $render_year, $emp_id){
		list($d, $m, $y) = explode('/', $render_year);

		$fromdate = $y . '-' . $m . '-01';
		$todate = date("Y-m-t", strtotime($resign_date));

		$this->db->select("pr_emp_com_info.emp_join_date,pay_salary_sheet.*,
			SUM(pay_salary_sheet.total_days) as tDays,
			SUM(pay_salary_sheet.num_of_workday) as tWDays,
			SUM(pay_salary_sheet.att_days) as tAttDays,
			SUM(pay_salary_sheet.absent_days) as tAbsDays,
			SUM(pay_salary_sheet.e_l) as tEL,
			SUM(pay_salary_sheet.holiday) as tHoliday,
			SUM(pay_salary_sheet.weekend) as tWeekend");

		$this->db->from('pr_emp_com_info');
		$this->db->from("pay_salary_sheet");

		$this->db->where("pay_salary_sheet.emp_id", $emp_id);
		$this->db->where("pay_salary_sheet.salary_month >= '$fromdate'");
		$this->db->where("pay_salary_sheet.salary_month <= '$todate'");
		$this->db->where("pr_emp_com_info.emp_id = pay_salary_sheet.emp_id");

		$query = $this->db->get();
		$num_rows = $query->num_rows();
		if($num_rows < 1){ return "empty";}
		foreach($query->result() as $rows){
			$data['emp_id'] 		= $rows->emp_id;
			$data['emp_join_date'] 	= $rows->emp_join_date;
			$data['gross_sal']		= $rows->gross_sal;
			$data['basic_sal'] 		= $rows->basic_sal;

			$data['tDays'] 			= $rows->tWDays;
			$data['tAttDays']		= $rows->tAttDays;
			$data['tAbsDays']		= $rows->tAbsDays ;
			$data['el']				= $rows->tEL;

			$data['tHoliday'] 		= $rows->tHoliday;
			$data['tWeekend'] 		= $rows->tWeekend;
		}

		return $data;
	}


	function grid_daily_absent_report($year, $month, $date, $status, $grid_emp_id){
		$day = $year."-".$month."-".$date;
		// dd($day);
		$this->db->distinct();
		$this->db->select('
			pr_emp_com_info.emp_id,
			pr_emp_per_info.name_en,
		    emp_designation.desig_name,
			pr_emp_com_info.emp_join_date,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			emp_line_num.line_name_en,
			pr_emp_com_info.emp_cat_id,
            pr_emp_per_info.personal_mobile,
		');

		$this->db->from('pr_emp_shift_log');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_emp_shift_schedule');
		$this->db->from('pr_emp_skill');

		$this->db->where('pr_emp_com_info.emp_id = pr_emp_shift_log.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift_schedule.id = pr_emp_shift_log.schedule_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		// $this->db->where('pr_emp_shift.emp_id = pr_emp_skill.emp_id');
		$this->db->where('pr_emp_shift_log.shift_log_date', $day);
		$this->db->where_in('pr_emp_shift_log.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_shift_log.present_status', "A");
		$this->db->group_by("pr_emp_com_info.emp_id");
		$this->db->order_by("emp_section.sec_name_en");
		$this->db->order_by("emp_line_num.line_name_en");
		$this->db->order_by("pr_emp_shift_log.emp_id");

		$query = $this->db->get();
		//dd($query->result_array());
		$data = array();
		foreach($query->result() as $rows){
			$emp_id = $rows->emp_id;
			$emp_shift = $rows->shift_name;
			$data["emp_id"][] 		= $rows->emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name"][] 	= $rows->sec_name;
			$data["line_name"][] 	= $rows->line_name;
			$data["emp_shift"][] 	= $emp_shift;
			$data["status"][] 		= $status;
			$data["mobile"][] 		= $rows->mobile;
			$limit_days = $this->common_model->get_setup_attributes(9);
			$emp_num_rows = $this->attendance_check_for_absent($emp_id,$status,$limit_days,$day);
			$data["cont_absent"][] 		= $emp_num_rows;
		}

		//dd($data);
		if(!empty($data))
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}


	function attendance_check_for_absent($id, $start_date){

		$day = 30;
		$count = 0;
		for ($i = 0; $i <= $day; $i++) {
			$get_date = date('Y-m-d', strtotime('-'. $i .' day', strtotime($start_date)));
			$this->db->select("present_status");
			$this->db->where("emp_id", $id);
			$this->db->where("shift_log_date", $get_date);
			$value = $this->db->get("pr_emp_shift_log")->row();
			if(!empty($value)){
				if ($value->present_status == "A") {
					$count++;
				} else if ($value->present_status == "W" || $value->present_status == "H") {
					$day++;
				}else{
					break;
				}
			}else{
				$count++;
			}
		}
		return $count;
	}


	//-------------------------------------------------------------------------------------------------
	// Daily Report for Present, Absent, Leave
	//-------------------------------------------------------------------------------------------------

	function grid_per_file($grid_emp_id){
		$this->db->select('pr_emp_blood_groups.*,emp_line_num.*,pr_emp_add.*,pr_emp_com_info.*,pr_emp_per_info.*, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en_bn,pr_emp_skill.*');

		$this->db->from('pr_emp_com_info');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','LEFT');
		$this->db->join('pr_emp_blood_groups','pr_emp_per_info.emp_blood = pr_emp_blood_groups.blood_id','LEFT');
		$this->db->join('emp_designation','pr_emp_com_info.emp_desi_id = emp_designation.id','LEFT');
		$this->db->join('emp_depertment','pr_emp_com_info.emp_dept_id = emp_depertment.dept_id','LEFT');
		$this->db->join('emp_section','pr_emp_com_info.emp_sec_id = emp_section.id','LEFT');
		$this->db->join('emp_line_num','pr_emp_com_info.emp_line_id = emp_line_num.id','LEFT');
		$this->db->join('pr_emp_add','pr_emp_com_info.emp_id = pr_emp_add.emp_id','LEFT');
		$this->db->join('pr_emp_skill','pr_emp_com_info.emp_id = pr_emp_skill.emp_id','LEFT');
		// $this->db->join('pr_emp_nid_wk_typ','pr_emp_com_info.emp_id = pr_emp_nid_wk_typ.emp_id','LEFT');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->group_by("pr_emp_com_info.emp_id");

		$query = $this->db->get();
		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";
		} else {
			return $query;
		}
	}


	// Daily Holiday / Weekend Present Report
	//=======================================

	function grid_daily_holiday_weekend_present_report($year,$month,$date,$status,$grid_emp_id){
		// dd($day);
		$data =array();
		$day = $year."-".$month."-".$date;
		$ids = $this->db->select('id')->where_in('emp_id',$grid_emp_id)->get('pr_emp_com_info')->result();
		foreach($ids as $row){
			$this->db->select('pr_emp_com_info.emp_id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   pr_emp_com_info.emp_join_date,
						   emp_depertment.dept_name,
						   emp_section.sec_name_en,
						   emp_line_num.line_name_en,
						   pr_emp_shift.shift_name,
						   pr_emp_com_info.emp_cat_id,
						   pr_emp_shift_log.in_time,
						   pr_emp_shift_log.out_time'
						);
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_emp_shift');
			$this->db->from('pr_emp_shift_log');
			$this->db->where('pr_emp_per_info.emp_id      = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_shift_log.emp_id     = pr_emp_com_info.id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id  = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_shift.id             = pr_emp_com_info.emp_shift');
			$this->db->where_in("pr_emp_shift_log.emp_id",$row->id);
			$this->db->where("pr_emp_shift_log.shift_log_date = '$day'");
			$this->db->where("pr_emp_com_info.emp_cat_id", 1);
			$this->db->where("pr_emp_shift_log.in_time != '00:00:00'");
			$this->db->order_by("emp_section.sec_name_en");
			$this->db->order_by("emp_line_num.line_name_en");
			$this->db->order_by("pr_emp_com_info.emp_id");
			$query = $this->db->get();
			foreach($query->result() as $rows){
				$data["emp_id"][] 		= $rows->emp_id;
				$data["emp_name"][] 	= $rows->name_en;
				$data["desig_name"][] 	= $rows->desig_name;
				$data["doj"][] 			= $rows->emp_join_date;
				$data["dept_name"][] 	= $rows->dept_name;
				$data["sec_name"][] 	= $rows->sec_name_en;
				$data["line_name"][] 	= $rows->line_name_en;
				$data["in_time"][] 		= $rows->in_time;
				$out_time = $rows->out_time;
				if($out_time == "00:00:00"){
					$out_time = "P(Error)";
				}
				$data["out_time"][] 	= $out_time;
			}
		}

		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}


	function grid_leave_application_form($firstdate,$seconddate,$leave_type,$emp_id)
	{
		$firstdate 		= date("Y-m-d",strtotime($firstdate));
		$seconddate 	= date("Y-m-d",strtotime($seconddate));

		$first_year = date("Y",strtotime($firstdate));

		$this->db->select("pr_emp_com_info.*,pr_emp_per_info.emp_id, pr_emp_per_info.name_en, emp_designation.desig_name, emp_section.sec_name_en,emp_line_num.line_name_en");

		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');

		//$this->db->where("pr_emp_com_info.unit_id",$grid_unit);
		$this->db->where("pr_emp_com_info.emp_id",$emp_id);
		$this->db->where("pr_emp_per_info.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_com_info.emp_desi_id = emp_designation.id");
		$this->db->where("pr_emp_com_info.emp_sec_id = emp_section.id");
		$this->db->where("pr_emp_com_info.emp_line_id = emp_line_num.id");
		$this->db->group_by("pr_emp_com_info.emp_id");
		$this->db->order_by("emp_line_num.line_name_en");
		$query = $this->db->get();

		//echo $query->num_rows();

		foreach($query->result() as $rows)
		{
			$emp_id 		= $rows->emp_id;

			$data['emp_id'] 		= $emp_id ;
			$data['emp_full_name'] 	= $rows->emp_full_name ;
			$data['sec_name_en'] 		= $rows->sec_name_en ;
			$data['line_name'] 		= $rows->line_name ;
			$data['desig_name'] 	= $rows->desig_name ;
			$data['gross_sal'] 		= $rows->gross_sal ;
			$data['emp_join_date'] 	= $rows->emp_join_date ;



			$entitle_casual_leave 	= $this->get_yearly_leave_type($rows->emp_id,$first_year,'cl');
			$entitle_sick_leave 	= $this->get_yearly_leave_type($rows->emp_id,$first_year,'sl');
			$entitle_earn_leave 	= $this->get_yearly_leave_type($rows->emp_id,$first_year,'el');

			$casual_leave_balance 	= $this->get_yearly_leave_balance('lv_cl');
			$sick_leave_balance 	= $this->get_yearly_leave_balance('lv_sl');

			$available_causual_leave 	= $casual_leave_balance - $entitle_casual_leave;
			$available_sick_leave 		= $sick_leave_balance - $entitle_sick_leave;

			$data['entitle_casual_leave'] 		= $entitle_casual_leave;
			$data['entitle_sick_leave'] 		= $entitle_sick_leave;
			$data['entitle_earn_leave'] 		= $entitle_earn_leave;

			$data['casual_leave_balance'] 		= $casual_leave_balance;
			$data['sick_leave_balance'] 		= $sick_leave_balance;

			$data['available_causual_leave']	= $available_causual_leave;
			$data['available_sick_leave'] 		= $available_sick_leave;

			$no_of_days = $this->get_no_of_days_for_leave($firstdate,$seconddate,$emp_id);

			$data['no_of_days'] = $no_of_days;
		}

		// print_r($data);exit;
		if(isset($data))
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function get_no_of_days_for_leave($firstdate,$seconddate,$emp_id)
	{
		$days = $this->GetDays($firstdate,$seconddate);
		$i = 0;
		foreach($days as $day)
		{
			$holiday_check = $this->db->where('emp_id',$emp_id)->where('holiday_date',$day)->get('pr_holiday')->num_rows();
			if($holiday_check > 0)
			{
				continue;
			}

			$weekend_check = $this->db->where('emp_id',$emp_id)->where('work_off_date',$day)->get('attn_work_off')->num_rows();
			if($weekend_check > 0)
			{
				continue;
			}
			$i++;
		}
		return $i;
	}

	function get_leave_entitle($emp_id,$leave_type,$year)
	{
		$this->db->select($leave_type);
	    $where="emp_id = '$emp_id' and leave_type = '$leave_type' and trim( substr(start_date,1,4 ) ) = '$year' ";
    	$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		$total_paternity_leave = $query->num_rows();
	}



	function get_present_status($emp_id,$shift_log_date)
	{
		$year_month 	= date("Y-m",strtotime($shift_log_date));
		$day 			= date("d",strtotime($shift_log_date));
		$select_column 	= "date_$day";
		$present_status = $this->db->like("att_month",$year_month)->where("emp_id",$emp_id)->get('pr_attn_monthly')->row()->$select_column;
		return $present_status;
	}

	function get_shift_log_data($emp_id,$shift_log_date)
	{
		$this->db->select('*');
		$this->db->like('shift_log_date',$shift_log_date);
		$query_emp = $this->db->get('pr_emp_shift_log');
		$query_emp_no = $query_emp->num_rows();
		if($query_emp_no == 0)
		{
			$data['ot_hour'] 		= 0;
			$data['extra_ot_hour'] 	= 0;
		}
		else
		{

			foreach($query_emp->result() as $rows)
			{
				$data['ot_hour'] 		= $rows->ot_hour ;
				$data['extra_ot_hour'] 	= $rows->extra_ot_hour ;
			}
		}
		return $data;

	}
	//-------------------------------------------------------------------------------------------------
	// In-Time format for Buyer
	//-------------------------------------------------------------------------------------------------
	function get_formated_in_time($emp_id, $in_time, $emp_shift)
	{
		$schedule 				= $this->schedule_check($emp_shift);
		$exact_in_time			= $schedule[0]["in_time"];

		$exact_time_15min_back = $this->minus_fifteen_minute_from_time($exact_in_time);

		if($exact_time_15min_back > $in_time )
		{
			return $in_time_format = $this->get_buyer_in_time($exact_time_15min_back ,$in_time);
		}
		else
		{
			return $in_time = $this->time_am_pm_format($in_time);
		}

	}
	//-------------------------------------------------------------------------------------------------
	// Minus fifteen minute from given time
	//-------------------------------------------------------------------------------------------------
	function minus_fifteen_minute_from_time($time)
	{
		return $time = date("H:i:s",strtotime('-15 minutes',strtotime($time)));
	}
	//-------------------------------------------------------------------------------------------------
	// In-Time format for Buyer
	//-------------------------------------------------------------------------------------------------
	function get_buyer_in_time($exact_time_15min_back ,$in_time)
	{
		$exact_hour_min_sec = $this->get_hour_min_sec($exact_time_15min_back);
		$exact_hour   		= $exact_hour_min_sec['hour'];
		$exact_minute 		= $exact_hour_min_sec['minute'];

		$real_hour_min_sec 	= $this->get_hour_min_sec($in_time);
		$real_minute  		= $real_hour_min_sec['minute'];
		$real_second 		= $real_hour_min_sec['second'];

		$buyer_minute = $this->create_buyer_minute($real_minute);

		$buyer_minute = $buyer_minute + $exact_minute;

		return $time_format = date("h:i:s A", mktime($exact_hour, $buyer_minute, $real_second, 0, 0, 0));

	}
	//-------------------------------------------------------------------------------------------------
	// Convert Time to Hour, Minute and Second
	//-------------------------------------------------------------------------------------------------
	function get_hour_min_sec($time)
	{
		$data = array();
		$data['hour']   = substr($time,0,2);
		$data['minute'] = substr($time,3,2);
		$data['second'] = substr($time,6,2);
		return $data;
	}
	//-------------------------------------------------------------------------------------------------
	// Convert real minute to buyer minute(Sum of two digit of minute)
	//-------------------------------------------------------------------------------------------------
	function create_buyer_minute($minute)
	{
		$min_1st_digit = substr($minute,0,1);
		$min_2nd_digit = substr($minute,1,1);
		return $buyer_minute  = $min_1st_digit + $min_2nd_digit;
	}
	//-------------------------------------------------------------------------------------------------
	// Out-Time format for Buyer
	//-------------------------------------------------------------------------------------------------
	function get_formated_out_time($emp_id, $out_time, $emp_shift)
	{
		if($out_time =='00:00:00')
		{
			return $out_time ='';
		}
		$schedule 				= $this->schedule_check($emp_shift);
		$out_start				= $schedule[0]["out_start"];
		$ot_start				= $schedule[0]["ot_start"];
		$ot_minute				= $schedule[0]["ot_minute_to_one_hour"];
		$one_hour_ot_out_time	= $schedule[0]["one_hour_ot_out_time"];
		$two_hour_ot_out_time	= $schedule[0]["two_hour_ot_out_time"];
		$minute_differance 		= 60 - $ot_minute;

		$one_hour_ot_out_time1	= date("H:i:s",strtotime("-$minute_differance minutes",strtotime($one_hour_ot_out_time)));
		$two_hour_ot_out_time2	= date("H:i:s",strtotime("-$minute_differance minutes",strtotime($two_hour_ot_out_time)));
		if($out_start < $out_time)
		{
			if($ot_start > $out_time)
			{
				return $out_time = $this->time_am_pm_format($out_time);
			}
			elseif($one_hour_ot_out_time1 > $out_time )
			{
				return $out_time = $this->get_buyer_in_time($ot_start ,$out_time);
			}
			elseif($two_hour_ot_out_time2 > $out_time )
			{

				return $out_time = $this->get_buyer_in_time($one_hour_ot_out_time ,$out_time);
			}
			else
			{
				return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time ,$out_time);
			}
		}
		else
		{
			return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time ,$out_time);
		}
	}

    //-------------------------------------------------------------------------------------------------
    // New Job Card Timing customization after 7:10pm by tarek
    //-------------------------------------------------------------------------------------------------

    function get_formated_out_time_trk($emp_id, $out_time, $emp_shift,$date)
    {
            if($out_time =='00:00:00')
            {
                    return $out_time ='';
            }
            $schedule                    = $this->schedule_check($emp_shift);
            //print_r($schedule);
            $id                    = $schedule[0]["id"];
            $out_start                   = $schedule[0]["out_start"];
            $ot_start                    = $schedule[0]["ot_start"];
            $ot_minute                   = $schedule[0]["ot_minute_to_one_hour"];
            $one_hour_ot_out_time        = $schedule[0]["one_hour_ot_out_time"];
            $two_hour_ot_out_time        = $schedule[0]["two_hour_ot_out_time"];
            $minute_differance           = 60 - $ot_minute;

            $one_hour_ot_out_time1       = date("H:i:s",strtotime("-$minute_differance minutes",strtotime($one_hour_ot_out_time)));
            $two_hour_ot_out_time2       = date("H:i:s",strtotime("-$minute_differance minutes",strtotime($two_hour_ot_out_time)));

            $new_c_out_time_range =  date('H:i:s',strtotime('+10 minutes',strtotime($two_hour_ot_out_time)));

        	$new_check_time = date('H:i:s',strtotime('17:00:00'));

            //echo $ganja=date("h:i:s",$two_hour_ot_out_time+600);
            //echo "$new_c_out_time_range < $out_time";
            //echo $out_time;exit;
            //echo $out_time;
        	$date = date('d-m-Y',strtotime($date));
            if($new_c_out_time_range < $out_time)
            {
            	//echo "up";
            	  //echo $new_c_out_time_range .'<'. $out_time;
                   // $out_time = $this->time_am_pm_format($out_time);

                    $cut_time_hr = substr($out_time, 0,2);
                    $cut_time_min = substr($out_time, 3,2);
                    $cut_time_ss = substr($out_time, 6,2);
                    $cut_time_am_pm = substr($out_time, 9,2);


                    if($date >= '2018-05-06' && $date <= '2018-05-17')
                    	{
                    		$out_time_n = $this->time_am_pm_format($out_time);
								$out_time_n = substr($out_time_n, 9,2);
                    		$n_date = $date.' '.$out_time.' '.$out_time_n;
	                    	$f_date = $date.' '.'17:31:00 '.'PM';

                    		if($n_date < $f_date)
                    			{


                    				$out_time = $this->time_am_pm_format($out_time);
                    				$cut_time_hr = substr($out_time, 0,2);
			                        $cut_time_min = substr($out_time, 3,2);
			                        $cut_time_ss = substr($out_time, 6,2);
			                        $cut_time_am_pm = substr($out_time, 9,2);

			                        return $new_out_time = $cut_time_hr.":".$cut_time_min.":".$cut_time_ss." ".$cut_time_am_pm;

                    			}
                    			else
                    			{

                    				$new_cut_time_hr = "06";
		                            $new_cut_time_pm = "PM";
		                            $rand_min = rand(1,9);

		                            return $new_out_time = $new_cut_time_hr.":"."0".$rand_min.":".$cut_time_ss." ".$new_cut_time_pm;

                    			}
                    	}

                      else if($date >= '2018-05-18' && $date <= '2018-06-17')
                    	{
								$out_time_n = $this->time_am_pm_format($out_time);
								$out_time_n = substr($out_time_n, 9,2);
                    		$n_date = $date.' '.$out_time.' '.$out_time_n;
	                    	$f_date = $date.' '.'17:31:00 '.'PM';
                    		//echo $n_date .'<'. $f_date;
                    		if($n_date < $f_date)
                    			{


                    				$out_time = $this->time_am_pm_format($out_time);
                    				$cut_time_hr = substr($out_time, 0,2);
			                        $cut_time_min = substr($out_time, 3,2);
			                        $cut_time_ss = substr($out_time, 6,2);
			                        $cut_time_am_pm = substr($out_time, 9,2);

			                        $new_out_time = $cut_time_hr.":".$cut_time_min.":".$cut_time_ss." ".$cut_time_am_pm;
                    			}
                    			else
                    			{
                    				//echo "hey";
                    				$new_cut_time_hr = "05";
	                                $new_cut_time_pm = "PM";
	                                $rand_min = rand(31,39);

	                                $new_out_time = $new_cut_time_hr.":".$rand_min.":".$cut_time_ss." ".$new_cut_time_pm;

                    			   //$new_out_time = $this->time_am_pm_format($out_time);

                    			}

                    			//return $new_out_time;

                    	}

	                    else
	                    {

	                    		$new_cut_time_hr = "07";
	                            $new_cut_time_pm = "PM";
	                            $rand_min = rand(1,9);

	                            $new_out_time = $new_cut_time_hr.":"."0".$rand_min.":".$cut_time_ss." ".$new_cut_time_pm;

	                    }

                   	 return $new_out_time;
            	  }
                  else
                  {
                  	$cut_time_hr = substr($out_time, 0,2);
                    $cut_time_min = substr($out_time, 3,2);
                    $cut_time_ss = substr($out_time, 6,2);
                    $cut_time_am_pm = substr($out_time, 9,2);

                  	if($date >= '2018-05-06' && $date <= '2018-05-17')
                    	{
                    		$out_time_n = $this->time_am_pm_format($out_time);
								$out_time_n = substr($out_time_n, 9,2);
                    		//$n_date = $date.' '.$out_time.' '.$out_time_n;
                    		$date_2 = $out_time.' '.$out_time_n;
	                    	$f_date = $date.' '.'17:31:00 '.'PM';
	                    	//echo $out_time;
	                    	if($out_time_n == 'AM')
	                    	{
	                    		$n_date = date('d-m-Y',(strtotime ('+1 day' , strtotime($date))));
	                    		$n_date = $n_date.' '.$out_time.' '.$out_time_n;
	                    	}
	                    	else
	                    	{
	                    		$n_date = $date.' '.$out_time.' '.$out_time_n;
	                    	}
	                    	//echo $n_date;
	                    	//echo $n_date .'<'.$f_date;
                    		if($n_date < $f_date)
                    			{
                    				//echo "hey";

                    				$out_time = $this->time_am_pm_format($out_time);
                    				$cut_time_hr = substr($out_time, 0,2);
			                        $cut_time_min = substr($out_time, 3,2);
			                        $cut_time_ss = substr($out_time, 6,2);
			                        $cut_time_am_pm = substr($out_time, 9,2);

			                         $new_out_time = $cut_time_hr.":".$cut_time_min.":".$cut_time_ss." ".$cut_time_am_pm;
                    			}
                    			else
                    			{

                    			   $new_cut_time_hr = "06";
		                           $new_cut_time_pm = "PM";
		                           $rand_min = rand(1,9);

		                            $new_out_time = $new_cut_time_hr.":"."0".$rand_min.":".$cut_time_ss." ".$new_cut_time_pm;
                    			}

                    		return $new_out_time;

                    	}
                        else if($date >= '2018-05-18' && $date <= '2018-06-17')
                    	{
	                    		$out_time_n = $this->time_am_pm_format($out_time);
  								$out_time_n = substr($out_time_n, 9,2);
	                    		$n_date = $date.' '.$out_time.' '.$out_time_n;
	                    		$f_date = $date.' '.'17:31:00 '.'PM';

                    			if($n_date < $f_date)
                    			{
                    				//echo $n_date .'<'. $f_date;
                    				$out_time = $this->time_am_pm_format($out_time);
                    				$cut_time_hr = substr($out_time, 0,2);
			                        $cut_time_min = substr($out_time, 3,2);
			                        $cut_time_ss = substr($out_time, 6,2);
			                        $cut_time_am_pm = substr($out_time, 9,2);

			                        $new_out_time = $cut_time_hr.":".$cut_time_min.":".$cut_time_ss." ".$cut_time_am_pm;

                    			}
                    			else
                    			{

                    			    $new_cut_time_hr = "05";
	                                $new_cut_time_pm = "PM";
	                                $rand_min = rand(31,39);

	                               $new_out_time = $new_cut_time_hr.":".$rand_min.":".$cut_time_ss." ".$new_cut_time_pm;

                    			}

                    			return $new_out_time;

                    	}
						else if($out_time < '12:59:59 AM')
						{
							if($id==17){
								return $out_time = $this->time_am_pm_format($out_time);
							}else
							{
							//echo $out_time;exit;
							$new_cut_time_hr = "07";
	                        $new_cut_time_pm = "PM";
	                        $rand_min = rand(1,9);
	                        //$rand_min = rand(31,39);
							$cut_time_ss = substr($out_time, 6,2);

	                         return $new_out_time = $new_cut_time_hr.":"."0".$rand_min.":".$cut_time_ss." ".$new_cut_time_pm;
							}

						}
						else
						{

	                        $out_time = $this->time_am_pm_format($out_time);
	                        $cut_time_hr = substr($out_time, 0,2);
	                        $cut_time_min = substr($out_time, 3,2);
	                        $cut_time_ss = substr($out_time, 6,2);
	                        $cut_time_am_pm = substr($out_time, 9,2);
	                        $rand_min = rand(1,9);
							$cut_time_ss = substr($out_time, 6,2);

	                         return $new_out_time = $cut_time_hr.":"."0".$rand_min.":".$cut_time_ss." ".$cut_time_am_pm;

							//return $out_time = $this->time_am_pm_format($out_time);
						}

                        return $out_time = $this->time_am_pm_format($out_time);
           }
    }


    //-------------------------------------------------------------------------------------------------
    // END
    //-------------------------------------------------------------------------------------------------


	//-------------------------------------------------------------------------------------------------
	// Convert 24 Hour Time to AM or PM format
	//-------------------------------------------------------------------------------------------------
	function time_am_pm_format($out_time)
	{
		$hour_min_sec 	= $this->get_hour_min_sec($out_time);
		$hour  			= $hour_min_sec['hour'];
		$minute  		= $hour_min_sec['minute'];
		$second 		= $hour_min_sec['second'];

		return $time_format = date("h:i:s A", mktime($hour, $minute, $second, 0, 0, 0));
	}

	function grid_daily_out_in_report_old_11_12_2021($year, $month, $date, $status, $grid_emp_id)
	{
		$day = $year."-".$month."-".$date;
		$att_month  = $year."-".$month."-01";
		$date_field = "pr_attn_monthly.date_$date";

		$date_field2 = "date_$date";



		$this->db->select("pr_attn_monthly.emp_id, $date_field");
		$this->db->from("pr_attn_monthly");
		$this->db->from("pr_emp_com_info");
		$this->db->from("emp_designation");
		$this->db->from("emp_line_num");
		$this->db->where_in("pr_attn_monthly.emp_id", $grid_emp_id);
		$this->db->where($date_field, $status);
		$this->db->where("pr_attn_monthly.att_month", $att_month);
		$this->db->where("pr_attn_monthly.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->order_by("emp_line_num.line_name_en");
		$this->db->order_by("pr_attn_monthly.emp_id");
		$query = $this->db->get();


		//echo $this->db->last_query();
		if($query->num_rows() == 0)
		{
			return "Requested list is empty";
		}



		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;

			$status = $rows->$date_field2;

			$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_shift');
			//$this->db->from("pr_emp_status");
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
			$this->db->where("pr_emp_per_info.emp_id = '$emp_id'");

			//$this->db->order_by("emp_depertment.dept_name","ASC");
			//$this->db->order_by("emp_section.sec_name_en","ASC");
			//$this->db->order_by("emp_line_num.line_name_en","ASC");
			//$this->db->order_by("pr_emp_com_info.emp_id","ASC");
			$query = $this->db->get();
			//echo $this->db->last_query();
			//$put = $query->result_array();
			//print_r($put);

			if($status == "L")
			{
				$this->db->select("leave_type");
				$this->db->where("emp_id", $emp_id);
				$this->db->where("start_date", $day);
				$query1 = $this->db->get("pr_leave_trans");
				$row = $query1->row();
				$status = $row->leave_type;
			}
			else
			{
				$status = $status;
			}
			//$emp_shift = $this->emp_shift_check($emp_id, $day);

			foreach($query->result() as $rows)
			{
				$emp_id = $rows->emp_id;
				$emp_shift = $rows->shift_name;

				if($status == "P")
				{


					$present_check = $this->present_check($day, $emp_id);
					if($present_check == true)
					{
						$this->db->select();
						$this->db->from('pr_emp_shift_log');
						$this->db->where("emp_id", $emp_id);
						$this->db->where("shift_log_date", $day);
						$query1 = $this->db->get();
						foreach($query1->result() as $row)
						{
							$emp_shift = $this->emp_shift_check($emp_id, $day);
							$in_time = $row->in_time;
							$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);
							$out_time = $row->out_time;
							$out_time = $this->get_formated_out_time($emp_id, $out_time, $emp_shift);

						}

					}
				}
				else
				{
					$in_time = $status;
					$out_time = $status;
				}

				$previous_day_out = $this->get_previous_day_out_status($year, $month, $date, $emp_id);
				if($previous_day_out =='00:00:00')
				{
					$previous_day_out = "";//'P(Error)';
				}
				elseif($previous_day_out !='A' and $previous_day_out !='L' and $previous_day_out !='W' and $previous_day_out !='H')
				{
					$current_date  = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
					$previous_date = date("Y-m-d", strtotime("-1 day", strtotime($current_date)));

					$emp_shift = $this->emp_shift_check($emp_id, $previous_date);
					$previous_day_out  = $this->get_formated_out_time($emp_id, $previous_day_out, $emp_shift);
				}

				$emp_cat_id = $rows->emp_cat_id;

				if($emp_cat_id == 1 || $emp_cat_id == 2 || $emp_cat_id == 5)
				{
					$data["emp_id"][] = $rows->emp_id;
					$data["proxi_id"][] = $rows->proxi_id;
					$data["emp_name"][] = $rows->emp_full_name;
					$data["desig_name"][] = $rows->desig_name;
					$data["doj"][] = $rows->emp_join_date;
					$data["dept_name"][] = $rows->dept_name;
					$data["sec_name_en"][] = $rows->sec_name_en;
					$data["line_name"][] = $rows->line_name;
					$data["emp_shift"][] = $emp_shift;
					$data["in_time"][] = $in_time;
					$data["out_time"][] = $out_time;
					$data["status"][] = $status;
					$data["p_out"][] = $previous_day_out;
				}
			}
			//print_r($data);
		}
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_daily_out_in_report($year, $month, $date, $status, $grid_emp_id)
	{
		$day = $year."-".$month."-".$date;
		$att_month  = $year."-".$month."-01";
		$date_field = "pr_attn_monthly.date_$date";

		$date_field2 = "date_$date";

		$this->db->distinct();
		$this->db->select("pr_attn_monthly.emp_id, $date_field");
		$this->db->from("pr_attn_monthly");
		$this->db->where_in("pr_attn_monthly.emp_id", $grid_emp_id);
		$this->db->where($date_field, "P");
		$this->db->where("pr_attn_monthly.att_month", $att_month);
		$this->db->order_by("pr_attn_monthly.emp_id");
		$query = $this->db->get();

		/*echo "<pre>";
		print_r($query->result()); exit;*/

		if($query->num_rows() == 0)
		{
			return "Requested list is empty";
		}



		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;

			$status = $rows->$date_field2;

			$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			// $this->db->from('pr_floor');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_shift');
			//$this->db->from("pr_emp_status");
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			// $this->db->where('pr_emp_com_info.emp_floor_id = pr_floor.floor_id');
			$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
			$this->db->where("pr_emp_per_info.emp_id = '$emp_id'");
			$query = $this->db->get();

			//print_r($put);

			if($status == "L")
			{
				$this->db->select("leave_type");
				$this->db->where("emp_id", $emp_id);
				$this->db->where("start_date", $day);
				$query1 = $this->db->get("pr_leave_trans");
				$row = $query1->row();
				$status = $row->leave_type;
			}
			else
			{
				$status = $status;
			}
			//$emp_shift = $this->emp_shift_check($emp_id, $day);

			foreach($query->result() as $rows)
			{
				$emp_id = $rows->emp_id;
				$emp_shift = $rows->shift_name;

				if($status == "P")
				{


					$present_check = $this->present_check($day, $emp_id);
					if($present_check == true)
					{
						$this->db->select();
						$this->db->from('pr_emp_shift_log');
						$this->db->where("emp_id", $emp_id);
						$this->db->where("shift_log_date", $day);
						$query1 = $this->db->get();
						foreach($query1->result() as $row)
						{
							$emp_shift = $this->emp_shift_check($emp_id, $day);
							$in_time = $row->in_time;
							$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);
							$out_time = $row->out_time;
							$out_time = $this->get_formated_out_time($emp_id, $out_time, $emp_shift);
						}

					}
				}
				else
				{
					$in_time = $status;
					$out_time = $status;
				}

				$previous_day_out = $this->get_previous_day_out_status($year, $month, $date, $emp_id);
				if($previous_day_out =='00:00:00')
				{
					$previous_day_out = 'P(Error)';
				}
				elseif($previous_day_out !='A' and $previous_day_out !='L' and $previous_day_out !='W' and $previous_day_out !='H')
				{
					$current_date  = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
					$previous_date = date("Y-m-d", strtotime("-1 day", strtotime($current_date)));

					$emp_shift = $this->emp_shift_check($emp_id, $previous_date);
					$previous_day_out  = $this->get_formated_out_time($emp_id, $previous_day_out, $emp_shift);
				}

				$emp_cat_id = $rows->emp_cat_id;

				if($emp_cat_id == 1 || $emp_cat_id == 2 || $emp_cat_id == 5)
				{
					$data["emp_id"][] = $rows->emp_id;
					$data["proxi_id"][] = $rows->proxi_id;
					$data["emp_name"][] = $rows->emp_full_name;
					$data["desig_name"][] = $rows->desig_name;
					$data["doj"][] = $rows->emp_join_date;
					$data["dept_name"][] = $rows->dept_name;
					$data["sec_name_en"][] = $rows->sec_name_en;
					$data["line_name"][] = $rows->line_name;
					$data["floor_name"][] = $rows->floor_name;
					$data["emp_shift"][] = $emp_shift;
					$data["in_time"][] = $in_time;
					$data["out_time"][] = $out_time;
					$data["status"][] = $status;
					$data["p_out"][] = $previous_day_out;
				}
			}
			//print_r($data);
		}
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}


	function grid_daily_actual_out_in_report($year, $month, $date, $status, $grid_emp_id)
	{
		$day = $year."-".$month."-".$date;
		$att_month  = $year."-".$month."-01";
		$date_field = "pr_attn_monthly.date_$date";

		$date_field2 = "date_$date";

		$this->db->distinct();
		$this->db->select("pr_attn_monthly.emp_id, $date_field");
		$this->db->from("pr_attn_monthly");
		$this->db->from("pr_emp_com_info");
		$this->db->from("emp_designation");
		$this->db->from("emp_line_num");
		$this->db->where_in("pr_attn_monthly.emp_id", $grid_emp_id);
		$this->db->where($date_field, $status);
		$this->db->where("pr_attn_monthly.att_month", $att_month);
		$this->db->where("pr_attn_monthly.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		/*$this->db->order_by("emp_line_num.line_name_en");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");*/
		$this->db->order_by("pr_attn_monthly.emp_id","ASC");


		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() == 0)
		{
			return "Requested list is empty";
		}



		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;

			$status = $rows->$date_field2;

			$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_shift');
			//$this->db->from("pr_emp_status");
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
			$this->db->where("pr_emp_per_info.emp_id = '$emp_id'");

			//$this->db->order_by("emp_depertment.dept_name","ASC");
			//$this->db->order_by("emp_section.sec_name_en","ASC");
			//$this->db->order_by("emp_line_num.line_name_en","ASC");
			//$this->db->order_by("pr_emp_com_info.emp_id","ASC");
			$query = $this->db->get();
			//echo $this->db->last_query();
			//$put = $query->result_array();
			//print_r($put);

			if($status == "L")
			{
				$this->db->select("leave_type");
				$this->db->where("emp_id", $emp_id);
				$this->db->where("start_date", $day);
				$query1 = $this->db->get("pr_leave_trans");
				$row = $query1->row();
				$status = $row->leave_type;
			}
			else
			{
				$status = $status;
			}
			//$emp_shift = $this->emp_shift_check($emp_id, $day);

			foreach($query->result() as $rows)
			{
				$emp_id = $rows->emp_id;
				$emp_shift = $rows->shift_name;

				if($status == "P")
				{


					$present_check = $this->present_check($day, $emp_id);
					if($present_check == true)
					{
						$this->db->select();
						$this->db->from('pr_emp_shift_log');
						$this->db->where("emp_id", $emp_id);
						$this->db->where("shift_log_date", $day);
						$query1 = $this->db->get();
						foreach($query1->result() as $row)
						{
							$emp_shift = $this->emp_shift_check($emp_id, $day);
							$in_time = $row->in_time;
							$in_time = $this->time_am_pm_format($in_time);
							//$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);
							$out_time = $row->out_time;
							if($out_time!="00:00:00")
							{
							$out_time = $this->time_am_pm_format($out_time);
							}
							else
							{
								$out_time = $out_time;
							}

							//$out_time = $this->get_formated_out_time($emp_id, $out_time, $emp_shift);
						}

					}
				}
				else
				{
					$this->db->select();
						$this->db->from('pr_emp_shift_log');
						$this->db->where("emp_id", $emp_id);
						$this->db->where("shift_log_date", $day);
						$query1 = $this->db->get();
						foreach($query1->result() as $row)
						{
							$emp_shift = $this->emp_shift_check($emp_id, $day);
							$in_time = $row->in_time;
							//$in_time = $this->time_am_pm_format($in_time);
							//$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);
							//===============================================================
							if($in_time!="00:00:00")
							{
							$out_time = $this->time_am_pm_format($in_time);
							}
							else
							{
								$in_time = $in_time;
							}
							//===============================================
							$out_time = $row->out_time;
							if($out_time!="00:00:00")
							{
							$out_time = $this->time_am_pm_format($out_time);
							}
							else
							{
								$out_time = $out_time;
							}

							//$out_time = $this->get_formated_out_time($emp_id, $out_time, $emp_shift);
						}

				}

				$previous_day_out = $this->get_previous_day_out_status($year, $month, $date, $emp_id);
				if($previous_day_out =='00:00:00')
				{
					$previous_day_out = "";//'P(Error)';

				}
				elseif($previous_day_out !='A' and $previous_day_out !='L' and $previous_day_out !='W' and $previous_day_out !='H')
				{
					$current_date  = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
					$previous_date = date("Y-m-d", strtotime("-1 day", strtotime($current_date)));

					$emp_shift = $this->emp_shift_check($emp_id, $previous_date);
					if($previous_day_out!="00:00:00")
					{
					$previous_day_out = $this->time_am_pm_format($previous_day_out);
					}
					else
					{
						$previous_day_out = $previous_day_out;
					}
					//$previous_day_out  = $this->get_formated_out_time($emp_id, $previous_day_out, $emp_shift);
				}

				$emp_cat_id = $rows->emp_cat_id;

				if($emp_cat_id == 1 || $emp_cat_id == 2 || $emp_cat_id == 5)
				{
					$data["emp_id"][] = $rows->emp_id;
					$data["proxi_id"][] = $rows->proxi_id;
					$data["emp_name"][] = $rows->emp_full_name;
					$data["desig_name"][] = $rows->desig_name;
					$data["doj"][] = $rows->emp_join_date;
					$data["dept_name"][] = $rows->dept_name;
					$data["sec_name_en"][] = $rows->sec_name_en;
					$data["line_name"][] = $rows->line_name;
					$data["emp_shift"][] = $emp_shift;
					$data["in_time"][] = $in_time;
					$data["out_time"][] = $out_time;
					$data["status"][] = $status;
					$data["p_out"][] = $previous_day_out;
				}
			}
			//print_r($data);
		}
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function get_previous_day_out_status($year, $month, $date, $emp_id)
	{
		$current_date  = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		$previous_date = date("Y-m-d", strtotime("-1 day", strtotime($current_date)));

		$previous_day = date("d", strtotime($previous_date));

		$att_month  = $year."-".$month."-01";
		$date_field = "pr_attn_monthly.date_$previous_day";

		$date_field2 = "date_$previous_day";

		$this->db->distinct();
		$this->db->select("pr_attn_monthly.emp_id, $date_field");
		$this->db->from("pr_attn_monthly");
		$this->db->where("pr_attn_monthly.emp_id", $emp_id);
		$this->db->where("pr_attn_monthly.att_month", $att_month);
		$query = $this->db->get();
		$row = $query->row();
		$status = $row->$date_field2;
		if($status =='P')
		{
			return $out_time = $this->get_out_time($emp_id, $previous_date);
		}
		else
		{
			return $status;
		}
	}

	function get_out_time($emp_id, $previous_date)
	{
		$this->db->distinct();
		$this->db->select('out_time');
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date", $previous_date);
		$query = $this->db->get('pr_emp_shift_log');
		$row = $query->row();
		return $out_time = $row->out_time;
	}

	function emp_shift_check($emp_id, $att_date)
	{
		$this->db->select("id, schedule_id");
		$this->db->from("pr_emp_shift_log");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date", $att_date);
		$query = $this->db->get();

		if($query->num_rows() > 0 )
		{
			foreach($query->result() as $row)
			{
				$schedule_id = $row->schedule_id;
			}

			$this->db->select("sh_type");
			$this->db->from("pr_emp_shift_schedule");
			$this->db->where("id", $schedule_id);
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
			//echo $this->db->last_query();
			$row = $query->row();
			return $row->sh_type;

		}
	}

	function present_check($date, $emp_id)
	{
		//echo $date;
		$year  = trim(substr($date,0,4));
		$month = trim(substr($date,5,2));
		$day   = trim(substr($date,8,2));
		$date_field = "date_$day";
		$att_month = $year."_".$month."-01";

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

	function attendance_check($date, $emp_id, $status)
	{
		$year  = trim(substr($date,0,4));
		$month = trim(substr($date,5,2));
		$day   = trim(substr($date,8,2));
		$date_field = "date_$day";
		$att_month = $year."-".$month."-00";
		// dd($att_month);

		$this->db->select($date_field);
		$this->db->where("emp_id", $emp_id);
		$this->db->where("att_month", $att_month);
		$this->db->where($date_field, $status);
		$query = $this->db->get("pr_attn_monthly");
		// dd($query->row());
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function schedule_check($emp_shift)
	{
		$this->db->where("sh_type", $emp_shift);
		$query = $this->db->get("pr_emp_shift_schedule");
		return $query->result_array();
	}

	function time_check_in($date, $start_time, $end_time, $table)
	{
		$this->db->select("date_time");
		$this->db->where("trim(substr(date_time,1,10)) = '$date'");
		$this->db->where("trim(substr(date_time,11,19)) BETWEEN '$start_time' and '$end_time'");
		$this->db->order_by("date_time","ASC");
		$this->db->limit("1");
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		$time ="";
		foreach ($query->result() as $row)
		{
			$time = $row->date_time;
		}
		$time = trim(substr($time,11,19));
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
	function grid_daily_late_report($year, $month, $date, $grid_emp_id)
	{

		$date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

		$data = $this->late_commer($year, $month, $date, $grid_emp_id);

		//print_r($data);
		if(!isset($data["emp_id"]))
		{
			return "Requested list is empty";
		}
		else
		{
			return $data;
		}
		/*$emp_table = "temp_100009";
		$late_id = $this->late_commer($date, 100009, $emp_table);*/

	}

	function late_commer($year, $month, $date, $grid_emp_id)
	{
		$data =array();

		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name ,pr_emp_com_info.emp_cat_id,pr_emp_shift_log.in_time');

		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','LEFT');
		$this->db->join('pr_emp_shift_log','pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id','LEFT');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','LEFT');
		$this->db->join('emp_depertment','emp_depertment.dept_id = pr_emp_com_info.emp_dept_id','LEFT');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','LEFT');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','LEFT');
		$this->db->join('pr_id_proxi','pr_id_proxi.emp_id = pr_emp_com_info.emp_id','LEFT');
		$this->db->join('pr_emp_shift','pr_emp_shift.id = pr_emp_com_info.emp_shift','LEFT');
		$this->db->where_in("pr_emp_per_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $date);
		$this->db->where("pr_emp_shift_log.late_status", 1);
		$this->db->order_by('pr_emp_com_info.emp_sec_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $rows)
		{
			$emp_cat_id = $rows->emp_cat_id;
			$data["emp_id"][] = $rows->emp_id;
			$data["proxi_id"][] = $rows->proxi_id;
			$data["emp_name"][] = $rows->emp_full_name;
			$data["desig_name"][] = $rows->desig_name;
			$data["doj"][] = $rows->emp_join_date;
			$data["dept_name"][] = $rows->dept_name;
			$data["sec_name_en"][] = $rows->sec_name_en;
			$data["line_name"][] = $rows->line_name;
			$data["shift_name"][] =$rows->shift_name;
			$data["in_time"][] = $rows->in_time;

		}
		if(!isset($data["emp_id"]))
		{
			return "Requested list is empty";
		}
		else
		{
			return $data;
		}
	}

	function get_no_of_days($start_date,$end_date)
	{
		$start = strtotime($start_date);
		$end = strtotime($end_date);
		$no_of_days = ceil(abs($end - $start) / 86400) + 1;
		return  $no_of_days;
	}

	function leave_count($emp_id,$start_date,$end_date)
	{
		$where = "trim(substr(start_date,1,10)) BETWEEN '$start_date' and '$end_date'";

		$this->db->select('start_date');
		$this->db->where("emp_id",$emp_id);
		$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		return $query->num_rows();
	}

	function grid_continuous_leave_report($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{
		$data =array();
		//print_r($grid_emp_id);
		$count = count($grid_emp_id);
		for($i=0; $i<$count; $i++)
		{
			$emp_id = $grid_emp_id[$i];
			if($emp_id !=''){
			$this->db->select("pr_leave_trans.*, pr_emp_com_info.emp_join_date, pr_emp_per_info.name_en,emp_line_num.line_name_en");
			$this->db->select("pr_leave_trans.*");
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('pr_leave_trans');
			$this->db->from('emp_line_num');
			$this->db->where("pr_leave_trans.emp_id", $emp_id);
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_leave_trans.emp_id = pr_emp_com_info.emp_id');
			$this->db->where("pr_leave_trans.leave_start !=","0000:00:00");
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where("pr_leave_trans.start_date BETWEEN '$grid_firstdate' and '$grid_seconddate' ");
			$this->db->group_by("pr_leave_trans.leave_start");
			$query = $this->db->get();
			//echo $this->db->last_query();
			if($query->num_rows() > 0){
			foreach($query->result() as $rows){

			$data['emp_id'][]			= $rows->emp_id;
			$data['emp_name'] []		= $rows->emp_full_name;
			$data['emp_join_date'][]	= $rows->emp_join_date;
			$data['leave_start'][] 		= $rows->leave_start;
			$data['leave_end'][] 		= $rows->leave_end;
			$data['line_name'][] 		= $rows->line_name;

			$data['num_of_days'][] 		= $this->leave_count($rows->emp_id,$rows->leave_start,$rows->leave_end);

			$leave_type		=$rows->leave_type;
			if($leave_type == "cl")
			{
				$leave_type = "Casual";
			}
			if($leave_type == "sl")
			{
				$leave_type = "Sick";
			}
			$data['leave_type'][] 		= $leave_type;
			}}}
		}
		if(!isset($data["emp_id"]))
		{
			return "Requested list is empty";
		}
		else
		{
			return $data;
		}

	}

	public function leave_count_new($emp_id,$grid_firstdate, $grid_seconddate){

		  $grid_firstdate = date('d-m-Y',strtotime($grid_firstdate));
	      $grid_seconddate = date('d-m-Y',strtotime($grid_seconddate));
	      //exit;
	      $this->db->select("pr_leave_trans.*");
	      $this->db->from("pr_leave_trans");
	      $this->db->where("pr_leave_trans.emp_id", $emp_id);
	      $this->db->where('pr_leave_trans.start_date >=' , $grid_firstdate);
	      $this->db->where('pr_leave_trans.start_date <=' , $grid_seconddate);
	      return $query = $this->db->get()->num_rows();
	}

	function continuous_multiple_leave_report($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{
		$data=array();
		//echo 'hey';exit;
		$grid_firstdate = date('d-m-Y',strtotime($grid_firstdate));
		$grid_seconddate = date('d-m-Y',strtotime($grid_seconddate));

		$this->db->select("pr_leave_trans.*");
		$this->db->from("pr_leave_trans");
		$this->db->where("pr_leave_trans.emp_id", $grid_emp_id);
		$this->db->where('pr_leave_trans.start_date >=' , $grid_firstdate);
		$this->db->where('pr_leave_trans.start_date <=' , $grid_seconddate);
		//$this->db->where('pr_leave_trans.start_leave_date >=' , $grid_firstdate);
		//$this->db->where('pr_leave_trans.end_leave_date <=' , $grid_seconddate);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
    }

    public function total_year_pass_leave($emp_id, $leave_type, $grid_firstdate, $grid_seconddate)
	{
		/*echo $grid_firstdate.'=='.$grid_seconddate;
		exit;*/
		$this->db->select("pr_leave_trans.*");
		$this->db->from("pr_leave_trans");
		$this->db->where("pr_leave_trans.emp_id", $emp_id);
		$this->db->where("pr_leave_trans.leave_type", "$leave_type");
		$this->db->where('pr_leave_trans.start_date >=' , $grid_firstdate);
		$this->db->where('pr_leave_trans.start_date <=' , $grid_seconddate);
		return $query = $this->db->get()->num_rows();
	}

	public function total_enjoyable_leave($emp_id, $grid_firstdate, $grid_seconddate)
	{
		/*echo $grid_firstdate.'=='.$grid_seconddate;
		exit;*/
		$this->db->select("pr_leave_trans.*");
		$this->db->from("pr_leave_trans");
		$this->db->where("pr_leave_trans.emp_id", $emp_id);
		$this->db->where('pr_leave_trans.start_date >=' , $grid_firstdate);
		$this->db->where('pr_leave_trans.start_date <=' , $grid_seconddate);
		return $query = $this->db->get()->num_rows();
	}

	function daily_move_report($grid_firstdate, $grid_emp_id)
	{
		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$seconddate = date('d-m-Y',strtotime($sStartDate . "+1 days"));
		//echo "$emp_id<br>";

		$this->db->distinct();
		$this->db->select('pr_emp_per_info.name_en,pr_emp_per_info.emp_id,emp_designation.desig_name,emp_depertment.dept_name,emp_section.sec_name_en,emp_line_num.line_name_en,pr_emp_com_info.emp_join_date,pr_id_proxi.proxi_id,pr_emp_com_info.emp_shift');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_attn_monthly');
		$this->db->from('pr_id_proxi');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_id_proxi.emp_id = pr_emp_com_info.emp_id');
		$this->db->where_in('pr_emp_per_info.emp_id', $grid_emp_id);

		$query = $this->db->get();
		foreach($query->result() as $row)
		{
			$emp_id = $row->emp_id;


			$emp_shift = $this->emp_shift_check($row->emp_id, $sStartDate);

			$schedule = $this->schedule_check($emp_shift);


			$start_time				=  $schedule[0]["in_start"];
			$out_end_time			=  $schedule[0]["out_end"];

			$start_date_time 	= "$sStartDate $start_time";
			$end_date_time 		= "$seconddate $out_end_time";

			//echo "$start_date_time===$end_date_time";

			$temp_table = "temp_$emp_id";
			$this->db->select('*');
			$this->db->where("date_time BETWEEN '$start_date_time' AND '$end_date_time'");
			$query_move = $this->db->get($temp_table);
			//echo $query_move->num_rows;
			if($query_move->num_rows() < 1)
			{
				continue;
			}

			foreach($query_move->result() as $row_move)
			{
				$data[$emp_id]["date"][] = date("d-M-Y", strtotime($row_move->date_time));
				$data[$emp_id]["time"][] = date("h:i:s A", strtotime($row_move->date_time));

			}
			$data["emp_id"][] = $row->emp_id;

			$data["emp_full_name"][] = $row->emp_full_name;

			$data["proxi_id"][] = $row->proxi_id;

			$data["sec_name_en"][] = $row->sec_name_en;

			$data["line_name"][] = $row->line_name;

			$data["desig_name"][] = $row->desig_name;

			$emp_join_date = $row->emp_join_date;

			$data["emp_join_date"][] = date("d-m-Y", strtotime($emp_join_date));

			$data["dept_name"][] = $row->dept_name;

			$data["emp_shift"][] = $row->emp_shift;


		}
		if(isset($data)){
			return $data;
		}
		else{
			return "Requested List Is Empty.";
		}

	}


	function grid_daily_attendance_summery($year, $month, $date, $grid_emp_id)
	{
		$data =array();
		$report_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

		$this->db->select('emp_id');
		$this->db->from("pr_emp_shift_log");
		$this->db->where_in("emp_id", $grid_emp_id);
		$this->db->where("shift_log_date", $report_date);
		$this->db->group_by('emp_id');
		$data['all_emp'] = $this->db->get()->num_rows();
		//echo $this->db->last_query();

		$this->db->select("pr_emp_shift_log.emp_id");
		$this->db->from("pr_emp_shift_log");
		$this->db->where_in("pr_emp_shift_log.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
		$this->db->where("pr_emp_shift_log.in_time !=", "00:00:00");
		$this->db->group_by('pr_emp_shift_log.emp_id');
		$data['all_present'] = $this->db->get()->num_rows();

		$this->db->select("emp_id");
		$this->db->from("pr_leave_trans");
		$this->db->where_in("emp_id", $grid_emp_id);
		$this->db->where("start_date", $report_date);
		$this->db->group_by('emp_id');
		$data['all_leave'] = $this->db->get()->num_rows();

		$this->db->select("pr_emp_shift_log.emp_id");
		$this->db->from("pr_emp_shift_log");
		$this->db->where_in("pr_emp_shift_log.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
		$this->db->where("pr_emp_shift_log.in_time", "00:00:00");
		$this->db->group_by('pr_emp_shift_log.emp_id');
		$all_absent = $this->db->get()->num_rows();
		$all_absent = $all_absent - $data['all_leave'];
		$data['all_absent'] = $all_absent;



		$this->db->select("pr_emp_shift_log.emp_id");
		$this->db->from("pr_emp_shift_log");
		$this->db->where_in("pr_emp_shift_log.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $report_date);
		$this->db->where("pr_emp_shift_log.late_status",1);
		$this->db->group_by('pr_emp_shift_log.emp_id');
	 	$data['all_late'] = $this->db->get()->num_rows();

		print_r($data);
	}

	function grid_daily_out_punch_miss_report($year, $month, $date, $grid_emp_id)
	{
		$data = $this->daily_out_punch_miss($year, $month, $date, $grid_emp_id);

		//print_r($data);
		if(!isset($data["emp_id"]))
		{
			return "Requested list is empty";
		}
		else
		{
			return $data;
		}
		/*$emp_table = "temp_100009";
		$late_id = $this->late_commer($date, 100009, $emp_table);*/

	}

	function daily_out_punch_miss($year, $month, $date, $grid_emp_id)
	{
		//echo count($grid_emp_id);exit;
		$data =array();
		$day = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		$date = $day;

		$this->db->select("pr_emp_shift_log.*");
		$this->db->from("pr_emp_shift_log");
		$this->db->from("pr_emp_com_info");
		$this->db->from("emp_section");
		$this->db->where_in("pr_emp_shift_log.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date", $date);
		$this->db->where('pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->order_by("emp_section.sec_name_en");
		$this->db->order_by("pr_emp_shift_log.emp_id");
		$query = $this->db->get();
		/*echo "<pre>";
		echo $this->db->last_query();exit;*/
		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;

			$in_time = $rows->in_time;

			$in_out_time = $rows->out_time;

			if( $in_time != "00:00:00" and $in_out_time == "00:00:00")
			{
				//echo "hey";exit;
				//echo "<br>$emp_id=> IN=$in_time#####OUT=$in_out_time";

				$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name ,pr_emp_com_info.emp_cat_id');

				$this->db->from('pr_emp_com_info');


				$this->db->join('pr_emp_per_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','LEFT');
			    $this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','LEFT');
			    $this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','LEFT');
			    $this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','LEFT');
			    $this->db->join('pr_id_proxi','pr_id_proxi.emp_id = pr_emp_com_info.emp_id','LEFT');
			    $this->db->join('pr_emp_shift','pr_emp_shift.id = pr_emp_com_info.emp_shift','LEFT');
				$this->db->where("pr_emp_per_info.emp_id = '$emp_id'");
				$query = $this->db->get();
				//echo $this->db->last_query();
				$emp_shift = $this->emp_shift_check($emp_id, $day);
				$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);


				foreach($query->result() as $rows)
				{
					$data["emp_id"][] = $rows->emp_id;
					$data["proxi_id"][] = $rows->proxi_id;
					$data["emp_name"][] = $rows->emp_full_name;
					$data["desig_name"][] = $rows->desig_name;
					$data["doj"][] = $rows->emp_join_date;
					$data["dept_name"][] = $rows->dept_name;
					$data["sec_name_en"][] = $rows->sec_name_en;
					$data["line_name"][] = $rows->line_name;
					$data["shift_name"][] =$rows->shift_name;
					$data["in_time"][] = $in_time;
				}
			}
		}
	return $data;
	}

	function continuous_report_limit($grid_firstdate, $grid_seconddate, $status, $grid_emp_id, $limit){
		$data = array();
		$count = 0;
		$date_array = $this->GetDays($grid_firstdate, $grid_seconddate);
		$this->db->select('pr_emp_per_info.name_en,pr_emp_per_info.emp_id, pr_id_proxi.proxi_id, emp_designation.desig_name, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_emp_com_info.emp_join_date ');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->from('pr_id_proxi');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_cat_id',1);
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where("pr_emp_com_info.emp_id = pr_id_proxi.emp_id");
			$this->db->where_in("pr_emp_com_info.emp_id",$grid_emp_id);
			$this->db->order_by("emp_section.sec_name_en");
			$query1 = $this->db->get();
			foreach($query1->result_array() as $rows){
				$emp_id   = $rows["emp_id"];
				$count = 0;
				foreach($date_array as $date){
					$present_check = $this->attendance_check($date, $emp_id, $status);
					if($present_check == true){
						 $count++;
					}
				}
				if($count < $limit){
					continue;
				}
				if(!epmty($rows)){
				$emp_full_name=$rows["emp_full_name"];
				$proxi_id=$rows["proxi_id"];
				$desig_name=$rows["desig_name"];
				$dept_name=$rows["dept_name"];
				$sec_name_en=$rows["sec_name_en"];
				$line_name=$rows["line_name"];
				$emp_join_date=$rows["emp_join_date"];
				$data['empid'][]=$emp_id ;
				$data['proxid'][]=$proxi_id;
				$data['fullname'][]=$emp_full_name;
				$data['jdate'][]=$emp_join_date;
				$data['dept_name'][]=$dept_name;
				$data['sec_name_en'][]=$sec_name_en;
				$data['line_name'][]=$line_name;
				$data['desig'][]=$desig_name;
				$data['total'][]=$count;
				}
			}
		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function continuous_line_report($grid_firstdate,$grid_seconddate,$grid_emp_id)
	{
		$grid_emp_id =  new RecursiveIteratorIterator(new RecursiveArrayIterator($grid_emp_id));
		$grid_emp_id = iterator_to_array($grid_emp_id, false);
		$data = array();

			$this->db->select('prev_emp_id,new_emp_id,prev_dept,new_dept,prev_section,new_section,prev_line, new_line, prev_desig,new_desig,prev_salary,new_salary,effective_month, ref_id, new_grade');
			$this->db->where_in("ref_id",$grid_emp_id);
			$this->db->where("status","3");
			$where ="effective_month BETWEEN '$grid_firstdate' and '$grid_seconddate'";
			$this->db->where($where);
			$this->db->order_by("new_section","ASC");
			$this->db->order_by("ref_id","ASC");
			$this->db->order_by("effective_month","desc");
			$query = $this->db->get('pr_incre_prom_pun');
			if($query->num_rows() != 0)
			{
				foreach ($query->result() as $rows)
				{
					$data["ref_id"][] 					= $rows->ref_id;
					$data["new_grade"][] 				= $rows->new_grade;
					$data["prev_emp_id"][] 				= $rows->prev_emp_id;
					$data["new_emp_id"][] 				= $rows->new_emp_id;
					//$data["emp_name"][] 				= $rows->emp_full_name;
					$prev_dept_name = $this->get_dept_name($rows->prev_dept);
					$prev_section_name = $this->get_section_name($rows->prev_section);
					$prev_line_name = $this->get_line_name($rows->prev_line);
					$prev_desig_name = $this->get_desig_name($rows->prev_desig);

					$data["prev_dept"][] 				= $prev_dept_name;
					$data["prev_section"][] 			= $prev_section_name;
					$data["prev_line"][] 				= $prev_line_name;
					$data["prev_desig"][]				= $prev_desig_name;
					$data["prev_salary"][] 				= $rows->prev_salary;;

					$new_dept_name = $this->get_dept_name($rows->new_dept);
					$new_section_name = $this->get_section_name($rows->new_section);
					$new_line_name = $this->get_line_name($rows->new_line);
					$new_desig_name = $this->get_desig_name($rows->new_desig);

					$data["new_dept"][] 				= $new_dept_name;
					$data["new_section"][] 				= $new_section_name;
					$data["new_line"][] 				= $new_line_name;
					$data["new_desig"][] 				= $new_desig_name;
					$data["new_salary"][] 				= $rows->new_salary;;
					$data["effective_month"][] 			= $rows->effective_month;

				}
			}
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function get_unproposed_emp($sStartDate,$sEndDate,$grid_emp_id)
	{
		$temp_unproposed_emp =array();
		$MinusStartDate = date("Y-m-d", strtotime("-1 year", strtotime($sStartDate)));
		$MinusEndDate = date("Y-m-d", strtotime("-1 year", strtotime($sEndDate)));

		$this->db->select('*');
		$this->db->from("pr_incre_prom_pun");
		$this->db->where("effective_month BETWEEN '$MinusStartDate' AND '$sEndDate'");
		$this->db->where_in("ref_id",$grid_emp_id);
		$query= $this->db->get();

		foreach($query->result() as $rows)
		{
			$temp_unproposed_emp[] = $rows->ref_id;

		}
		return $temp_unproposed_emp;
	}

	function continuous_increment_promotion_proposal($sStartDate,$sEndDate,$grid_emp_id){
		//echo "hi";exit;
		$pre_year = date("Y-m-d", strtotime("-1 year", strtotime($sStartDate)));

		$first_y	= date('Y', strtotime($pre_year));
		$first_m	= date('m', strtotime($pre_year));
		$first_d	= date('d', strtotime($pre_year));

		$first_day = date("d", mktime(0, 0, 0, $first_m, 1, $first_y));
		$last_day  = date("t", mktime(0, 0, 0, $first_m, 1, $first_y));

		$f_ym_day = date("Y-m-d", mktime(0, 0, 0, $first_m, $first_day, $first_y));
		$l_ym_day = date("Y-m-d", mktime(0, 0, 0, $first_m, $last_day, $first_y));

		$regular_new = array(1,2);

		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal,pr_emp_add.emp_pre_add,pr_emp_per_info.emp_dob,pr_emp_com_info.emp_cat_id');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_add");
		$this->db->where_in("pr_emp_com_info.emp_cat_id",$regular_new);
		$this->db->where_in("pr_emp_com_info.emp_id",$grid_emp_id);
		//$this->db->where("pr_emp_com_info.emp_join_date <= ",$last_day);
		$this->db->where("pr_emp_com_info.emp_join_date >= ",$f_ym_day);
		$this->db->where("pr_emp_com_info.emp_join_date <= ",$l_ym_day);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');

		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $query->num_rows();

		foreach($query->result() as $rows){
			$emp_id 	= $rows->emp_id;
			$emp_name	= $rows->emp_full_name;
			$desig_name = $rows->desig_name;
			$sec_name_en	= $rows->sec_name_en;
			$line_name = $rows->line_name;
			$gross_sal	= $rows->gross_sal;
			$join_date 	= $rows->emp_join_date;

			$system_date 	= date('d-m-Y');
			$service_month 	= $this->salary_process_model->get_service_month($join_date,$sStartDate);


			$last_incre_month_salary 	= $this->get_last_incre_month_salary($emp_id);
			$last_increment_date 		= $last_incre_month_salary['effective_month'];
			$increment_amount	 		= $last_incre_month_salary['increment_amount'];


			$data["emp_id"][] 				= $emp_id;
			$data["emp_name"][] 			= $emp_name;
			$data["desig_name"][] 			= $desig_name;
			$data["sec_name_en"][] 			= $sec_name_en;
			$data["line_name"][] 			= $line_name;
			$data["join_date"][] 			= date("d-M-Y", strtotime($join_date));
			$data["service_month"][] 		= $service_month;
			$data["last_increment_date"][] 	= $last_increment_date;
			$data["increment_amount"][] 	= $increment_amount;
			$data["gross_sal"][] 			= $gross_sal;
		}

		return $data;

	}

	function get_last_incre_month_salary($emp_id){

		$this->db->select('*');
		$this->db->from("pr_incre_prom_pun");
		$this->db->where("ref_id",$emp_id);
		$this->db->order_by("effective_month","DESC");
		$this->db->limit(1);
		$query= $this->db->get();

		if($query->num_rows()>0)
		{
			$rows = $query->row();
			$data['effective_month'] = $rows->effective_month ;
			$prev_salary = $rows->prev_salary ;
			$new_salary  = $rows->new_salary ;
			$data['increment_amount'] = $new_salary - $prev_salary;
		}
		else
		{
			$data['effective_month'] = " ";
			$data['increment_amount'] = 0;
		}
		return $data;
	}

	function grid_app_letter($grid_emp_id){
		$this->db->select('
				pr_grade.*,
				emp_line_num.*,
				pr_emp_com_info.emp_id,
				pr_emp_com_info.gross_sal,
				pr_emp_per_info.name_en,
				pr_emp_per_info.spouse_name,
				pr_emp_per_info.name_bn,
				pr_emp_per_info.emp_fname,
				pr_emp_per_info.emp_mname,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.emp_sal_gra_id,
				emp_depertment.dept_name,
				emp_depertment.dept_bangla,
				emp_section.sec_name_en,
				emp_section.sec_name_en_bn,
				pr_id_proxi.proxi_id,
				pr_emp_add.*,
			');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->from('emp_line_num');
		$this->db->from('pr_grade');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		//$this->db->where('pr_emp_com_info.district_id = pr_district.district_id');
		//$this->db->where('pr_emp_com_info.upazila_id = pr_upazila.upz_id');

		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->group_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";

		}
		else
		{
			return $query;
		}
		//print_r($query->result_array());

	}


	function get_absent_start_date($emp_id,$firstdate,$limit){
		//echo "$emp_id,$firstdate";
		$check_date = $firstdate;
		$this->db->select("shift_log_date");
		$this->db->where("emp_id",$emp_id);
		$this->db->where("shift_log_date <=",$firstdate);
		$this->db->where("present_status","A");
		$this->db->order_by("shift_log_date","DESC");
		$this->db->limit($limit);
		$query = $this->db->get('pr_emp_shift_log');
		// $this->db->last_query();
		$i = 1;
		foreach($query->result() as $rows){
			$date = $rows->shift_log_date;
			if($i == 1){
				if($date != $firstdate){
					$check_date = "0000-00-00";
					return $check_date;
				}
			}
			else{
				$check_date_minus_one = date('d-m-Y',strtotime($check_date . "-1 days"));

				if($date == $check_date_minus_one){
					$check_date = $date;

				}
				else{
					return $check_date;
				}
			}
			$i = $i + 1;
		}
		return $check_date;
	}

	function grid_letter2_report_old($grid_emp_id)
	{

		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_per_info.name_en, pr_emp_per_info.bangla_nam , pr_emp_per_info.emp_fname,pr_emp_per_info.emp_mname, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, pr_emp_com_info.emp_sal_gra_id , emp_depertment.dept_name, emp_section.sec_name_en,pr_emp_add.emp_par_add_ban,pr_emp_add.emp_pre_add_ban, emp_section.sec_name_en_bn, pr_id_proxi.proxi_id, pr_emp_add.emp_pre_add, pr_emp_add.emp_par_add');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');

		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";

		}
		else
		{
			return $query;
		}
		//print_r($query->result_array());

	}

	function grid_letter2_report($grid_emp_id, $firstdate)
	{

		//echo $firstdate;
		$newDate = date("Y-m-d", strtotime('-20 days', strtotime($firstdate)));

			$this->db->select('
				pr_emp_per_info.*,
				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.id as id_emp,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				emp_depertment.dept_name,
				emp_depertment.dept_bangla,
				emp_section.sec_name_en,
				emp_section.sec_name_bn,
				emp_line_num.line_name_bn,
				emp_line_num.line_name_en,
				per_dis.name_bn as dis_name_bn,
				per_upa.name_bn as upa_name_bn,
				per_post.name_bn as post_name_bn,
				pre_dis.name_bn as dis_bn,
				pre_upa.name_bn as upa_bn,
				pre_post.name_bn as post_bn,
				pr_emp_com_info.emp_sal_gra_id as grade,
				pr_emp_com_info.com_gross_sal as salary,
				pr_emp_left_history.left_date
			');

			$this->db->from('pr_emp_per_info');
			$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->join('pr_emp_left_history', 'pr_emp_com_info.emp_id = pr_emp_left_history.emp_id');
			$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->join('emp_districts as per_dis', 'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
			$this->db->join('emp_upazilas as per_upa', 'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
			$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');
			$this->db->join('emp_districts as pre_dis', 'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
			$this->db->join('emp_upazilas as pre_upa', 'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
			$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->order_by("pr_emp_com_info.emp_id");
			$query = $this->db->get();

		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";
		}
		else{
			return $query;
		}
	}
	function grid_letter2_count($grid_emp_id, $firstdate)
	{
		//echo $firstdate;
		$newDate = date("Y-m-d", strtotime('-20 days', strtotime($firstdate)));

			$this->db->select('
				pr_emp_per_info.*,

			');

			$this->db->from('pr_emp_per_info');
			$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->order_by("pr_emp_com_info.emp_id");
			$query = $this->db->get();

		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";
		}
		else{
			return $query;
		}
	}

	function grid_letter3_report_old($grid_emp_id,$firstdate){
		$newDate = date("Y-m-d", strtotime('-20 days', strtotime($firstdate)));
			$this->db->select('
				pr_emp_per_info.*,
				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.id as id_emp,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				emp_depertment.dept_name,
				emp_depertment.dept_bangla,
				emp_section.sec_name_en,
				emp_section.sec_name_bn,
				emp_line_num.line_name_bn,
				emp_line_num.line_name_en,
				per_dis.name_bn as dis_name_bn,
				per_upa.name_bn as upa_name_bn,
				per_post.name_bn as post_name_bn,
				pre_dis.name_bn as dis_bn,
				pre_upa.name_bn as upa_bn,
				pre_post.name_bn as post_bn,
				pr_emp_com_info.emp_sal_gra_id as grade,
				pr_emp_com_info.com_gross_sal as salary,
				pr_emp_left_history.left_date
			');
			$this->db->from('pr_emp_per_info');
			$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->join('pr_emp_left_history', 'pr_emp_com_info.emp_id = pr_emp_left_history.emp_id');
			$this->db->join('emp_districts as per_dis', 'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
			$this->db->join('emp_upazilas as per_upa', 'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
			$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');
			$this->db->join('emp_districts as pre_dis', 'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
			$this->db->join('emp_upazilas as pre_upa', 'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
			$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->order_by("pr_emp_com_info.emp_id");
			$query = $this->db->get();

		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";
		}
		else{
			return $query;
		}
	}

	function grid_letter3_report($grid_emp_id, $firstdate){

		//echo $firstdate;
		$newDate = date("Y-m-d", strtotime('-27 days', strtotime($firstdate)));

		$this->db->select('
				pr_emp_per_info.*,
				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.id as id_emp,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				emp_depertment.dept_name,
				emp_depertment.dept_bangla,
				emp_section.sec_name_en,
				emp_section.sec_name_bn,
				emp_line_num.line_name_bn,
				emp_line_num.line_name_en,
				per_dis.name_bn as dis_name_bn,
				per_upa.name_bn as upa_name_bn,
				per_post.name_bn as post_name_bn,
				pre_dis.name_bn as dis_bn,
				pre_upa.name_bn as upa_bn,
				pre_post.name_bn as post_bn,
				pr_emp_com_info.emp_sal_gra_id as grade,
				pr_emp_com_info.com_gross_sal as salary,
				pr_emp_left_history.left_date
			');
			$this->db->from('pr_emp_per_info');
			$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->join('pr_emp_left_history', 'pr_emp_com_info.emp_id = pr_emp_left_history.emp_id');
			$this->db->join('emp_districts as per_dis', 'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
			$this->db->join('emp_upazilas as per_upa', 'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
			$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');
			$this->db->join('emp_districts as pre_dis', 'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
			$this->db->join('emp_upazilas as pre_upa', 'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
			$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);

		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";

		}
		else
		{
			return $query->result();
		}
		//print_r($query->result_array());

	}
	function grid_pay_slip($year_month, $grid_emp_id)
	{
		$this->db->select('
				pr_emp_com_info.emp_id,
				pr_emp_com_info.gross_sal,
				pr_emp_per_info.name_en,
				pr_emp_per_info.name_en,
				pr_emp_per_info.mother_name,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				pr_emp_com_info.emp_join_date,
				emp_depertment.dept_name,
				emp_depertment.dept_bangla,
				emp_section.sec_name_en,
				emp_section.sec_name_bn,
				emp_line_num.line_name_en,
				emp_line_num.line_name_bn,
				pr_emp_com_info.emp_sal_gra_id,
				pr_emp_com_info.ot_entitle,
				pr_emp_per_info.bank_bkash_no as mobile,
				pr_emp_com_info.com_ot_entitle,
				pr_id_proxi.proxi_id,
				pr_grade.gr_name,
				pay_salary_sheet.*,
				pr_emp_per_info.name_bn,
				pr_emp_per_info.bank_bkash_no,
			');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->like('pay_salary_sheet.salary_month', $year_month);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";
		}
		else
		{
			return $query->result_array();
		}
		//print_r($query->result_array());
	}

	function grid_pay_slip_non_compliance($year_month, $grid_emp_id)
	{
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_per_info.name_en,pr_emp_per_info.emp_fname,pr_emp_per_info.emp_mname, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_depertment.dept_bangla, emp_section.sec_name_en, emp_section.sec_name_en_bn, emp_line_num.line_name_en ,emp_line_num.line_bangla,pr_emp_com_info.emp_sal_gra_id,pr_emp_com_info.ot_entitle,pr_emp_com_info.ot_show_in, pr_id_proxi.proxi_id, pr_emp_add.emp_pre_add, pr_emp_add.emp_par_add, pr_emp_position.posi_name,pr_grade.gr_name, pay_salary_sheet.* ,pr_emp_per_info.bangla_nam');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_add');
			$this->db->from('pr_grade');
			$this->db->from('pr_emp_position');
			$this->db->from('pay_salary_sheet');
			$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
			$this->db->like('pay_salary_sheet.salary_month', $year_month);
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_com_info.emp_position_id = pr_emp_position.posi_id');
			$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet.emp_id');
			$this->db->order_by("pr_emp_com_info.emp_id");
			$query = $this->db->get();

		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";

		}
		else
		{
			return $query->result_array();
		}
		//print_r($query->result_array());
	}

	function grid_pay_slip_com_non_com_mix($year_month, $grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_per_info.name_en,pr_emp_per_info.emp_fname,pr_emp_per_info.emp_mname, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_depertment.dept_bangla, emp_section.sec_name_en, emp_section.sec_name_en_bn, emp_line_num.line_name_en ,emp_line_num.line_bangla,pr_emp_com_info.emp_sal_gra_id,pr_emp_com_info.ot_entitle,pr_id_proxi.proxi_id, pr_emp_add.emp_pre_add, pr_emp_add.emp_par_add, pr_emp_position.posi_name,pr_grade.gr_name, pay_salary_sheet_com.* ,pr_emp_per_info.bangla_nam');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_add');
			$this->db->from('pr_grade');
			$this->db->from('pr_emp_position');
			$this->db->from('pay_salary_sheet_com');
			$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
			$this->db->like('pay_salary_sheet_com.salary_month', $year_month);
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_com_info.emp_position_id = pr_emp_position.posi_id');
			$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet_com.emp_id');
			$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";

		}
		else
		{
			return $query->result_array();
		}
		//print_r($query->result_array());
	}


	function grid_provident_fund($year_month, $grid_emp_id)
	{
		$pf_status = $this->common_model->get_setup_attributes(6);
		if($pf_status == "Yes")
		{
			$data = array();
			$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pay_salary_sheet.basic_sal, pay_salary_sheet.gross_sal, pay_salary_sheet.provident_fund, pay_salary_sheet.pf_bank_interest, pay_salary_sheet.company_pf, pay_salary_sheet.update_pf');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_shift');
			$this->db->from('pay_salary_sheet');
			$this->db->where_in("pay_salary_sheet.emp_id", $grid_emp_id);
			$this->db->like('pay_salary_sheet.salary_month', $year_month);
			$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet.emp_id');
			$this->db->where('pay_salary_sheet.emp_id = pr_emp_com_info.emp_id');
			$this->db->where("pr_emp_com_info.ot_entitle","1");
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
			$this->db->where("pay_salary_sheet.provident_fund != 0");
			$this->db->order_by("pr_emp_com_info.emp_id","ASC");
			$this->db->group_by("pay_salary_sheet.emp_id");
			$query = $this->db->get();

			if($query->num_rows() > 0)
			{
				$search_date = 	$year_month."-"."1";
				foreach($query->result() as $rows)
				{
					$emp_id = $rows->emp_id;

						$data["emp_id"][] 		= $emp_id;
						$data["proxi_id"][] 	= $rows->proxi_id;
						$data["emp_name"][] 	= $rows->emp_full_name;
						$data["doj"][] 			= $rows->emp_join_date;
						$service_month = $this->common_model->get_service_month($search_date,$rows->emp_join_date);

						$data["service_month"][]	= $service_month;
						$data["dept_name"][] 		= $rows->dept_name;
						$data["sec_name_en"][] 		= $rows->sec_name_en;
						$data["desig_name"][] 		= $rows->desig_name;
						$data["line_name"][]		= $rows->line_name;
						$data["basic_sal"][] 		= $rows->basic_sal;
						$data["gross_sal"][] 		= $rows->gross_sal;
						$data["provident_fund"][] 	= $rows->provident_fund;
						$data["pf_bank_interest"][] = $rows->pf_bank_interest;
						$data["company_pf"][] 		= $rows->company_pf;
						$data["update_pf"][] 		= $rows->update_pf;

						/*$this->db->select_sum('provident_fund');
						$this->db->where('emp_id',$emp_id);
						$this->db->where('salary_month <=',$search_date);
						$this->db->group_by("salary_month");
						$query = $this->db->get('pay_salary_sheet');*/
						//$query = $this->db->query("select SUM(`provident_fund`) AS provident_fund, COUNT(`provident_fund`) AS deduction_month FROM  (SELECT * FROM  pay_salary_sheet WHERE `emp_id`='$emp_id' GROUP BY `salary_month`) AS pay_sheet WHERE pay_sheet.salary_month <= '$search_date'");
						//$row = $query->row();
						//$sum_pf =  $row->provident_fund;
						//$deduction_month =  $row->deduction_month;
						//echo $this->db->last_query();
						//$data["deduction_month"][] 	= $deduction_month;
						//$data["sum_pf"][] 	= $sum_pf;

						$provident_fund_rules 		= $this->pf_model->get_provident_fund_rules($service_month);
						$data["pf_percentage"][]	= $provident_fund_rules['pf_percentage'];

				}

				if($data)
				{
					//print_r($data);
					return $data;
				}
				else
				{
					return "Requested list is empty";
				}
			}
			else
			{
				return "Requested list is empty";
			}
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function id_card($grid_emp_id,$status){
		// dd($grid_emp_id);
		$this->db->select('
			pr_emp_blood_groups.*,
			emp_line_num.line_name_bn,
			emp_line_num.line_name_en,
			pr_emp_per_info.*,
			emp_designation.desig_bangla,
			emp_designation.desig_name,
			pr_emp_com_info.emp_join_date,
			pr_emp_com_info.emp_id,
			pr_emp_com_info.emp_cat_id,
			emp_depertment.dept_name,
			emp_depertment.dept_bangla,
			emp_section.sec_name_en,
			emp_section.sec_name_bn,

			emp_districts.name_bn as  dis_name_bn,
			emp_districts.name_en as dis_name_en,

			emp_upazilas.name_bn as upa_name_bn,
			emp_upazilas.name_en as upa_name_en,

			emp_post_offices.name_bn as post_name_bn,
			emp_post_offices.name_en as post_name_en,
			'
		);
		// $this->db->select('pr_emp_com_info.*');


		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','LEFT');
		$this->db->join('emp_districts','pr_emp_per_info.per_district = emp_districts.id','LEFT');
		$this->db->join('emp_upazilas','pr_emp_per_info.per_thana = emp_upazilas.id','LEFT');
		$this->db->join('emp_post_offices','pr_emp_per_info.per_post = emp_post_offices.id','LEFT');
		$this->db->join('pr_emp_blood_groups','pr_emp_per_info.blood = pr_emp_blood_groups.blood_id','LEFT');
		$this->db->join('emp_designation','pr_emp_com_info.emp_desi_id = emp_designation.id','LEFT');
		$this->db->join('emp_depertment','pr_emp_com_info.emp_dept_id = emp_depertment.dept_id','LEFT');
		$this->db->join('emp_section','pr_emp_com_info.emp_sec_id = emp_section.id','LEFT');
		$this->db->join('emp_line_num','pr_emp_com_info.emp_line_id = emp_line_num.id','LEFT');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		// dd($query->result());
		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";
		}
		else{
			return $query->result();
		}
	}

	function grid_id_card_english($grid_emp_id)
	{
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,pr_emp_per_info.img_source,pr_emp_sex.sex_name,pr_emp_blood_groups.blood_name, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en,pr_units.unit_signature');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_emp_blood_groups');
		$this->db->from('emp_line_num');
		$this->db->from('pr_emp_sex');
		$this->db->from('pr_units');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_blood =  pr_emp_blood_groups.blood_id');
		$this->db->where('pr_emp_per_info.emp_sex =  pr_emp_sex.sex_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_units.unit_id = pr_emp_com_info.unit_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";

		}
		else
		{
			return $query;
		}
		//print_r($query->result_array());
	}
	function get_sec_name_en($emp_id){
		$this->db->select('emp_section.sec_name_en,emp_section.id,pr_emp_com_info.emp_id');
		$this->db->from('emp_section');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_com_info.emp_id',$emp_id);
		$this->db->where('emp_section.id =pr_emp_com_info.emp_sec_id');
		$query = $this->db->get()->result();
		foreach ($query as $row_sec) {
			return $row_sec->sec_name_en;
		}

	}


	function grid_job_card($grid_firstdate, $grid_seconddate, $grid_emp_id){

		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));

		$data = array();

		$this->db->select('emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where_in('emp_id', $grid_emp_id);
		$this->db->order_by("emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $row){
			$emp_id = $row->emp_id;

			$this->db->distinct();
			$this->db->select('pr_emp_per_info.name_en,
							   emp_designation.desig_name,
							   emp_depertment.dept_name,
							   emp_section.sec_name_en,
							   emp_line_num.line_name_en,
							   pr_emp_com_info.emp_join_date,
							   pr_emp_com_info.emp_shift,
							   pr_id_proxi.proxi_id
							');
			$this->db->from('pr_emp_com_info');

			$this->db->join('pr_emp_per_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','LEFT');
			$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','LEFT');
			$this->db->join('emp_depertment','emp_depertment.dept_id = pr_emp_com_info.emp_dept_id','LEFT');
			$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','LEFT');
			$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','LEFT');
			$this->db->join('pr_id_proxi','pr_id_proxi.emp_id = pr_emp_com_info.emp_id','LEFT');
			$this->db->where('pr_emp_com_info.emp_id', $emp_id);

			$query = $this->db->get();

			foreach($query->result() as $row){
				//echo $row->sec_name_en;
				$data["emp_id"][] = $emp_id;
				$data["emp_full_name"][] = $row->name_en;
				$data["proxi_id"][] = $row->proxi_id;
				$data["sec_name_en"][] = $row->sec_name_en;
				$data["line_name_en"][] = $row->line_name_en;
				$data["desig_name"][] = $row->desig_name;
				$data["emp_shift"][] = $row->emp_shift;
				$emp_join_date = $row->emp_join_date;
				$emp_join_date_year=trim(substr($emp_join_date,0,4));
				$emp_join_date_month=trim(substr($emp_join_date,5,2));
				$emp_join_date_day=trim(substr($emp_join_date,8,2));
				$emp_join_date = date("d-M-y", mktime(0, 0, 0, $emp_join_date_month, $emp_join_date_day, $emp_join_date_year));
				$data["emp_join_date"][] = $emp_join_date;
				$data["dept_name"][] = $row->dept_name;
			}

			$joining_check = $this->get_join_date($emp_id, $sStartDate, $sEndDate);
			if( $joining_check != false){
				$start_date = $joining_check ;
			}
			else{
				$start_date = $sStartDate ;
			}

			$resign_check  = $this->get_resign_date($emp_id, $sStartDate, $sEndDate);
			if($resign_check != false){
				$end_date = $resign_check ;
			}
			else{
				$end_date = $sEndDate ;
			}

			$left_check  = $this->get_left_date($emp_id, $sStartDate, $sEndDate);
			if($left_check != false){
				$end_date = $left_check ;
			}
			else{
				$end_date = $sEndDate ;
			}

			$leave = $this->leave_per_emp($start_date, $end_date, $emp_id);
			$weekend = $this->check_weekend($start_date, $end_date, $emp_id);
			$holiday = $this->holiday_calculation($start_date, $end_date);
			$days = $this->GetDays($start_date, $end_date);
			foreach($days as $day){
				if($day >= "2013-10-01"){
					$holiday = $this->check_holiday($emp_id, $day);
				}
				$id = $this->db->select('id')->where('emp_id',$emp_id)->get('pr_emp_com_info')->row()->id;
				$this->db->select('pr_emp_shift_log.in_time ,
								   pr_emp_shift_log.out_time,
								   pr_emp_shift_log.shift_log_date,
								   pr_emp_shift_log.ot,
								   pr_emp_shift_log.eot,
								   pr_emp_shift_log.late_status');
				$this->db->from('pr_emp_shift_log');
				$this->db->where('pr_emp_shift_log.emp_id',$id);
				$this->db->where("pr_emp_shift_log.shift_log_date", $day);
				$this->db->order_by("pr_emp_shift_log.shift_log_date");
				$this->db->limit(1);
				$query = $this->db->get();
				foreach($query->result() as $row){
					if(in_array($row->shift_log_date,$leave)){
						$leave_type = $this->get_leave_type($row->shift_log_date,$emp_id);
						$att_status_count = "Leave";
						$att_status = $leave_type;
						$row->in_time = "00:00:00";
						$row->out_time = "00:00:00";
					}
					elseif(in_array($row->shift_log_date,$holiday)){
						$att_status = "Holiday";
						$att_status_count = "Holiday";
						$row->in_time = "00:00:00";
						$row->out_time = "00:00:00";
						$row->ot_hour ="";
					}
					elseif(in_array($row->shift_log_date,$weekend)){
							$att_status = "Weekend";
							$att_status_count = "Weekend";
							$row->in_time = "00:00:00";
							$row->out_time = "00:00:00";
							$row->ot_hour ="";
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
					}

					if($att_status !="Leave" and $att_status !="Holiday" and $att_status !="Weekend" and $att_status !="A" ){
						$yera_month  = date('Y_m',strtotime($grid_firstdate));
						$table = "att_$yera_month";
						$lunch_out_start = "12:55:00";
						$lunch_out_end = "15:00:00";
						$lunch_out = $this->time_check_in($day, $lunch_out_start , $lunch_out_end , $table);

						if($lunch_out !=''){
							$lunch_out_hour = trim(substr($lunch_out,0,2));
							$lunch_out_minute = trim(substr($lunch_out,3,2));
							$lunch_out_sec = trim(substr($lunch_out,6,2));
							$lunch_out = date("h:i:s A", mktime($lunch_out_hour, $lunch_out_minute, $lunch_out_sec, 0, 0, 0));
						}
						else{
							$lunch_out = "";
						}
						$lunch_in = $this->time_check_out($day, $lunch_out_start , $lunch_out_end , $table);
						if($lunch_in !=''){
							$lunch_in = trim(substr($lunch_in,11,19));
							$lunch_in_hour = trim(substr($lunch_in,0,2));
							$lunch_in_minute = trim(substr($lunch_in,3,2));
							$lunch_in_sec = trim(substr($lunch_in,6,2));
							$lunch_in = date("h:i:s A", mktime($lunch_in_hour, $lunch_in_minute, $lunch_in_sec, 0, 0, 0));
						}
						else{
							$lunch_in = "";
						}
					}
					else{
						$lunch_out = "";
						$lunch_in = "";
					}
					$emp_shift = $this->emp_shift_check($emp_id, $day);
					$schedule = $this->schedule_check($emp_shift);
					$start_time		=  $schedule[0]["in_start"];
					$late_time 		=  $schedule[0]["late_start"];
					$end_time   	=  $schedule[0]["in_end"];
					$out_start_time	=  $schedule[0]["out_start"];
					$out_end_time	=  $schedule[0]["out_end"];
					if($row->late_status == 1 ){
						$remark = "Late";
					}
					else{
						$remark = "";
					}
					$shift_log_date = $row->shift_log_date;
					$year=trim(substr($shift_log_date,0,4));
					$month=trim(substr($shift_log_date,5,2));
					$date=trim(substr($shift_log_date,8,2));
					$shift_log_date = date("d-M-y", mktime(0, 0, 0, $month, $date, $year));
					if($row->in_time != "00:00:00"){
						$in_time = $row->in_time;
						$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);
					}
					else{
						$in_time = "00:00:00";
					}
					if($row->out_time != "00:00:00"){
						$sec_name_en = $this->get_sec_name_en($emp_id);
						if($sec_name_en=='Security'){
							$out_time = $row->out_time;
							$out_time = date("h:i:s A", strtotime($out_time));
						}else{
						$out_time = $row->out_time;
						$out_time = $this->get_formated_out_time($emp_id, $out_time, $emp_shift,$shift_log_date);
					  }
					}
					else{
						$out_time = "00:00:00";
					}
					$total_ot_hour = $row->ot; // + $row->extra_ot_hour; , This is for extra ot hour add to Job card.
					$data[$emp_id]["shift_log_date"][] 	 = $shift_log_date;
					$data[$emp_id]["in_time"][] 		 = $in_time;
					$data[$emp_id]["out_time"][] 		 = $out_time;
					$data[$emp_id]["ot_hour"][] 		 = $total_ot_hour;
					$data[$emp_id]["att_status"][] 		 = $att_status;
					$data[$emp_id]["att_status_count"][] = $att_status_count;
					$data[$emp_id]["lunch_out"][] 		 = $lunch_out;
					$data[$emp_id]["lunch_in"][] 		 = $lunch_in;
					$data[$emp_id]["remark"][] 			 = $remark;
				}
			}
		}
		return $data;
	}
	function check_holiday($id, $att_date)
	{
		$this->db->select("holiday_date");
		$this->db->from("pr_holiday");
		$this->db->where("emp_id", $id);
		$this->db->where("holiday_date", $att_date);
		$query = $this->db->get();
		//echo $this->db->last_query();
		$holiday = array();
		foreach ($query->result() as $row)
		{
			$holiday[] = $row->holiday_date;
		}
		return $holiday;
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
			return $left_date = $row->left_date;
		}
		else
		{
			return false;
		}
	}

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

	function check_weekend($sStartDate, $sEndDate, $emp_id)
	{
		$this->db->select("work_off_date");
		$this->db->where("work_off_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("attn_work_off");
		$weekend = array();
		foreach ($query->result() as $row)
		{
			$weekend[] = $row->work_off_date;
		}
		// dd($weekend);
		return $weekend;
	}

	function holiday_calculation($sStartDate, $sEndDate)
	{
		$this->db->select("holiday_date");
		$this->db->where("holiday_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$query = $this->db->get("pr_holiday");
		$holiday = array();
		foreach ($query->result() as $row)
		{
			$holiday[] = $row->holiday_date;
		}
		return $holiday;
	}

	function grid_monthly_att_register($year_month, $grid_emp_id){
		// dd($year_month);
		$year= trim(substr($year_month,0,4));
		$month = trim(substr($year_month,5,2));
		$att_month = "att_".$year."_".$month;
		if(!$this->db->table_exists($att_month)){
			return "Report month does not exist!";
		}
		$this->db->select('
						   pr_emp_com_info.emp_id,
						   pr_emp_com_info.emp_join_date,
						   pr_emp_com_info.id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   emp_line_num.line_name_en,
						');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','left');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','left');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','left');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','left');
		$this->db->where_in('pr_emp_com_info.emp_id',$grid_emp_id);
		// $this->db->group_by("pr_emp_per_info.emp_id");
		$this->db->order_by("pr_emp_per_info.emp_id");
		$query = $this->db->get();

		if( $query->num_rows() > 0){
			$data = array();

			foreach( $query->result() as $row){
				if($year_month < date('Y-m',strtotime($row->emp_join_date))){
					continue;
				}else{
					$newArray = array();
					$first_day = date('Y-m-01', strtotime($year_month));
					$last_day  = date('Y-m-t', strtotime($first_day));
					$a =$this->db->select('present_status')->where('emp_id',$row->emp_id)->where('shift_log_date BETWEEN "'.$first_day.'" AND "'.$last_day.'"')->get('pr_emp_shift_log')->result();
					foreach ($a as $item) {
						$newArray[] = $item->present_status;
					}
					if($newArray == NULL){
						continue;
					}else{
						$newArray = array_merge((array)$row,$newArray);
						$data[] = $newArray;
					}

				}
			}
			if($data == NULL){
				return "Soryy! Requested list is empty";
			}
			return $data;
		}
		else{
			return "Soryy! Requested list is empty";
		}
	}



	function grid_monthly_att_register_blank($year_month, $grid_emp_id){
		$year= trim(substr($year_month,0,4));
		$month = trim(substr($year_month,5,2));
		$att_month = "att_".$year."_".$month;
		if(!$this->db->table_exists($att_month)){
			return "Report month does not exist!";
		}
		$this->db->select('
						   pr_emp_com_info.emp_id,
						   pr_emp_com_info.id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   emp_line_num.line_name_en,
						');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','left');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','left');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','left');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','left');
		$this->db->where_in('pr_emp_per_info.emp_id',$grid_emp_id);
		$this->db->group_by("pr_emp_per_info.emp_id");
		$this->db->order_by("pr_emp_per_info.emp_id");
		$query = $this->db->get();
		// dd($query->result());
		if( $query->num_rows() > 0){
			$data = array();
			foreach( $query->result() as $row){
				$newArray = array();
				$first_day = date('Y-m-01', strtotime($year_month));
				$last_day  = date('Y-m-t', strtotime($first_day));
				$a =$this->db->select('present_status')->where('emp_id',$row->id)->where('shift_log_date BETWEEN "'.$first_day.'" AND "'.$last_day.'"')->get('pr_emp_shift_log')->result();
				foreach ($a as $item) {
					$newArray[] = $item->present_status;
				}
				$newArray = array_merge((array)$row,$newArray);
				$data[] = $newArray;
			}
			// dd($data );
			return $data;
		}
		else{
			return "Soryy! Requested list is empty";
		}
	}
	function grid_monthly_att_registerr($grid_emp_id){

		$this->db->select('
						pr_emp_com_info.emp_id,
						pr_emp_com_info.id,
						pr_emp_per_info.name_en,
						emp_designation.desig_name,
						emp_line_num.line_name_en,
					');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','left');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','left');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','left');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','left');
		$this->db->where_in('pr_emp_per_info.emp_id',$grid_emp_id);
		// $this->db->group_by("pr_emp_per_info.emp_id");
		$this->db->order_by("pr_emp_per_info.emp_id");
		$query = $this->db->get();
		if( $query->num_rows() > 0){
			return $query->result_array();
		}else{
			return "Soryy! Requested list is empty";
		}
	}

	function grid_monthly_att_register_auto($year_month, $grid_emp_id)
	{
		$year= trim(substr($year_month,0,4));
		$month = trim(substr($year_month,5,2));


		$att_month = "att_".$year."_".$month;

		if(!$this->db->table_exists($att_month))
		{
			return "Report month does not exist!";
		}

		$this->db->select('pr_emp_com_info.emp_join_date,pr_emp_per_info.*,pr_attn_monthly.*,emp_designation.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_attn_monthly');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->or_where_in("pr_emp_per_info.emp_id", $grid_emp_id);
			$this->db->like("pr_attn_monthly.att_month",$year_month);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_attn_monthly.emp_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->group_by('pr_attn_monthly.emp_id');
		$query = $this->db->get();
		// echo $this->db->last_query();
		if($query->num_rows > 0)
		{
			return $query;
		}
		else
		{
			return "Soryy! Requested list is empty";
		}
	}

	function grid_extra_ot($grid_firstdate, $grid_seconddate, $grid_emp_id){
		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));
		$data = array();
		$this->db->select('emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where_in('emp_id', $grid_emp_id);
		$this->db->order_by("emp_id");
		$query = $this->db->get();
		foreach($query->result() as $row){
			$emp_id = $row->emp_id;
			$this->db->distinct();
			$this->db->select('pr_emp_per_info.name_en,
							   emp_designation.desig_name,
							   emp_depertment.dept_name,
							   emp_section.sec_name_en,
							   emp_line_num.line_name_en,
							   pr_emp_com_info.emp_join_date,
							   pr_emp_com_info.unit_id,
							   pr_emp_com_info.emp_shift,
							   pr_id_proxi.proxi_id
							');
			$this->db->from('pr_emp_com_info');
			$this->db->join('pr_emp_per_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','LEFT');
			$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','LEFT');
			$this->db->join('emp_depertment','emp_depertment.dept_id = pr_emp_com_info.emp_dept_id','LEFT');
			$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','LEFT');
			$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','LEFT');
			$this->db->join('pr_id_proxi','pr_id_proxi.emp_id = pr_emp_com_info.emp_id','LEFT');
			$this->db->where('pr_emp_com_info.emp_id', $emp_id);
			$query = $this->db->get();
			foreach($query->result() as $row){
				$data["emp_id"][] = $emp_id;
				$data["emp_full_name"][] = $row->name_en;
				$data["proxi_id"][] = $row->proxi_id;
				$data["sec_name_en"][] = $row->sec_name_en;
				$data["line_name_en"][] = $row->line_name_en;
				$data["desig_name"][] = $row->desig_name;
				$data["unit_id"][] = $row->unit_id;
				$data["emp_shift_id"][] = $row->emp_shift;
				$emp_join_date = $row->emp_join_date;
				$emp_join_date_year=trim(substr($emp_join_date,0,4));
				$emp_join_date_month=trim(substr($emp_join_date,5,2));
				$emp_join_date_day=trim(substr($emp_join_date,8,2));
				$emp_join_date = date("d-M-y", mktime(0, 0, 0, $emp_join_date_month, $emp_join_date_day, $emp_join_date_year));
				$data["emp_join_date"][] = $emp_join_date;
				$data["dept_name"][] = $row->dept_name;
			}
			$joining_check = $this->get_join_date($emp_id, $sStartDate, $sEndDate);
			if( $joining_check != false){
				$start_date = $joining_check ;
			}
			else{
				$start_date = $sStartDate ;
			}
			$resign_check  = $this->get_resign_date($emp_id, $sStartDate, $sEndDate);
			if($resign_check != false){
				$end_date = $resign_check ;
			}
			else{
				$end_date = $sEndDate ;
			}
			$left_check  = $this->get_left_date($emp_id, $sStartDate, $sEndDate);
			if($left_check != false){
				$end_date = $left_check ;
			}
			else{
				$end_date = $sEndDate ;
			}
			$leave = $this->leave_per_emp($start_date, $end_date, $emp_id);
			$weekend = $this->check_weekend($start_date, $end_date, $emp_id);
			$holiday = $this->holiday_calculation($start_date, $end_date);
			$days = $this->GetDays($start_date, $end_date);

			foreach($days as $day){

				if($day >= "2013-10-01"){
					$holiday = $this->check_holiday($emp_id, $day);
				}
				$id = $this->db->select('id')->where('emp_id',$emp_id)->get('pr_emp_com_info')->row()->id;
				$this->db->select('pr_emp_shift_log.in_time ,
								   pr_emp_shift_log.out_time,
								   pr_emp_shift_log.shift_log_date,
								   pr_emp_shift_log.ot,
								   pr_emp_shift_log.eot,
								   pr_emp_shift_log.modify_eot,
								   pr_emp_shift_log.deduction_hour,
								   pr_emp_shift_log.late_status');
				$this->db->from('pr_emp_shift_log');
				$this->db->where('pr_emp_shift_log.emp_id',$id);
				$this->db->where("pr_emp_shift_log.shift_log_date", $day);
				$this->db->order_by("pr_emp_shift_log.shift_log_date");
				$this->db->limit(1);
				$query = $this->db->get();
				foreach($query->result() as $row){
					if(in_array($row->shift_log_date,$leave)){
						$leave_type = $this->get_leave_type($row->shift_log_date,$emp_id);
						$att_status_count = "Leave";
						$att_status = $leave_type;
						$row->in_time = "00:00:00";
						$row->out_time = "00:00:00";
					}
					elseif(in_array($row->shift_log_date,$holiday)){
						$att_status = "Holiday";
						$att_status_count = "Holiday";
						$row->in_time = "00:00:00";
						$row->out_time = "00:00:00";
						$row->ot_hour ="";
					}
					elseif(in_array($row->shift_log_date,$weekend)){
						$att_status = "Weekend";
						$att_status_count = "Weekend";
						$row->in_time = "00:00:00";
						$row->out_time = "00:00:00";
						$row->ot_hour ="";
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
					}

					if($att_status !="Leave" and $att_status !="Holiday" and $att_status !="Weekend" and $att_status !="A" ){
						$yera_month  = date('Y_m',strtotime($grid_firstdate));
						$table = "att_$yera_month";
						$lunch_out_start = "12:55:00";
						$lunch_out_end = "15:00:00";
						$lunch_out = $this->time_check_in($day, $lunch_out_start , $lunch_out_end , $table);
						if($lunch_out !=''){
							$lunch_out_hour = trim(substr($lunch_out,0,2));
							$lunch_out_minute = trim(substr($lunch_out,3,2));
							$lunch_out_sec = trim(substr($lunch_out,6,2));
							$lunch_out = date("h:i:s A", mktime($lunch_out_hour, $lunch_out_minute, $lunch_out_sec, 0, 0, 0));
						}
						else{
							$lunch_out = "";
						}
						$lunch_in = $this->time_check_out($day, $lunch_out_start , $lunch_out_end , $table);
						if($lunch_in !=''){
							$lunch_in = trim(substr($lunch_in,11,19));
							$lunch_in_hour = trim(substr($lunch_in,0,2));
							$lunch_in_minute = trim(substr($lunch_in,3,2));
							$lunch_in_sec = trim(substr($lunch_in,6,2));
							$lunch_in = date("h:i:s A", mktime($lunch_in_hour, $lunch_in_minute, $lunch_in_sec, 0, 0, 0));
						}
						else{
							$lunch_in = "";
						}
					}
					else{
						$lunch_out = "";
						$lunch_in = "";
					}
					$emp_shift = $this->emp_shift_check($emp_id, $day);
					$schedule = $this->schedule_check($emp_shift);
					$start_time		=  $schedule[0]["in_start"];
					$late_time 		=  $schedule[0]["late_start"];
					$end_time   	=  $schedule[0]["in_end"];
					$out_start_time	=  $schedule[0]["out_start"];
					$out_end_time	=  $schedule[0]["out_end"];
					if($row->late_status == 1 ){
						$remark = "Late";
					}
					else{
						$remark = "";
					}
					$shift_log_date = $row->shift_log_date;
					$year=trim(substr($shift_log_date,0,4));
					$month=trim(substr($shift_log_date,5,2));
					$date=trim(substr($shift_log_date,8,2));
					$shift_log_date = date("d-M-y", mktime(0, 0, 0, $month, $date, $year));
					if($row->in_time != "00:00:00"){
						$in_time = $row->in_time;
						$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);
					}
					else{
						$in_time = "00:00:00";
					}
					if($row->out_time != "00:00:00"){
						$sec_name_en = $this->get_sec_name_en($emp_id);
						if($sec_name_en=='Security'){
							$out_time = $row->out_time;
							$out_time = date("h:i:s A", strtotime($out_time));
						}else{
						$out_time = $row->out_time;
						$out_time = $this->get_formated_out_time($emp_id, $out_time, $emp_shift,$shift_log_date);
					  }
					}
					else{
						$out_time = "00:00:00";
					}
					$data[$emp_id]["shift_log_date"][] 	= $shift_log_date;
					$data[$emp_id]["in_time"][] 		= $in_time;
					$data[$emp_id]["out_time"][] 		= $out_time;
					$data[$emp_id]["ot_hour"][] 		= $row->ot;
					$data[$emp_id]["extra_ot_hour"][] 	= $row->eot;
					$data[$emp_id]["modify_eot"][] 		= $row->modify_eot;
					$data[$emp_id]["deduction_hour"][] 	= $row->deduction_hour;
					$data[$emp_id]["att_status"][] 		= $att_status;
					$data[$emp_id]["att_status_count"][] = $att_status_count;
					$data[$emp_id]["lunch_out"][] 		= $lunch_out;
					$data[$emp_id]["lunch_in"][] 		= $lunch_in;
					$data[$emp_id]["remark"][] 			= $remark;
				}
			}
		}
		// dd($data);
		return $data;

	}


	function grid_extra_ot_mix($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{
		// echo "hi";exit;
		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));

		$data = array();
		$query = $this->all_reguler_emp($grid_emp_id);
		foreach($query->result() as $row)
		{
			$emp_id = $row->emp_id;


			$this->db->select();
			$this->db->where("emp_id",$row->emp_id);
			//$this->db->where("emp_id","1000900");
			$this->db->where("shift_log_date BETWEEN '$grid_firstdate' AND '$grid_seconddate' ");
			$this->db->order_by("shift_log_date");
			$query1 = $this->db->get("pr_emp_shift_log");
			//echo $this->db->last_query();


			$data["emp_id"][] = $row->emp_id;

			$this->db->distinct();
			$this->db->select('pr_emp_per_info.name_en,emp_designation.desig_name,emp_depertment.dept_name,emp_section.sec_name_en,emp_line_num.line_name_en,pr_emp_com_info.emp_join_date,pr_emp_com_info.ot_entitle,pr_id_proxi.proxi_id');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('pr_attn_monthly');
			$this->db->from('pr_id_proxi');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->where('pr_emp_per_info.emp_id', $emp_id);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_id_proxi.emp_id = pr_emp_com_info.emp_id');
			$query2 = $this->db->get();

			//echo $this->db->last_query();
			foreach($query2->result() as $rows2)
			{
				$data["emp_full_name"][] = $rows2->emp_full_name;
				$data["proxi_id"][] = $rows2->proxi_id;
				$data["sec_name_en"][] = $rows2->sec_name_en;
				$data["line_name"][] = $rows2->line_name;
				$data["desig_name"][] = $rows2->desig_name;
				$emp_join_date = $rows2->emp_join_date;
				$emp_join_date_year		= trim(substr($emp_join_date,0,4));
				$emp_join_date_month	= trim(substr($emp_join_date,5,2));
				$emp_join_date_day		= trim(substr($emp_join_date,8,2));
				$emp_join_date 			= date("d-M-y", mktime(0, 0, 0, $emp_join_date_month, $emp_join_date_day, $emp_join_date_year));

				$data["emp_join_date"][] = $emp_join_date;
				$data["dept_name"][] = $rows2->dept_name;
				$data["ot_entitle"][] = $rows2->ot_entitle;
			}

			$this->db->select();
			$this->db->where("emp_id",$row->emp_id);
			//$this->db->where("emp_id","1000900");
			$this->db->where("shift_log_date BETWEEN '$grid_firstdate' AND '$grid_seconddate' ");
			$this->db->order_by("shift_log_date");
			$query1 = $this->db->get("pr_emp_shift_log");
			//echo $this->db->last_query();

			foreach($query1->result() as $rows )
			{
				$data[$emp_id]["shift_log_date"][] 	= $rows->shift_log_date;
				$data[$emp_id]["in_time"][] 		= $rows->in_time;
				$data[$emp_id]["out_time"][] 		= $rows->out_time;
				$data[$emp_id]["ot_hour"][] 		= $rows->ot_hour;
				$data[$emp_id]["extra_ot_hour"][] 	= $rows->extra_ot_hour;
				$data[$emp_id]["deduction_hour"][]	= $rows->deduction_hour;
				$data[$emp_id]["modify_eot"][] 		= $rows->modify_eot;
				$data[$emp_id]["present_status"][] 	= $rows->present_status;
			}
		/////////////////NEW Code//////
		$joining_check = $this->get_join_date($emp_id, $sStartDate, $sEndDate);
			if( $joining_check != false)
			{
				$start_date = $joining_check ;
			}
			else
			{
				$start_date = $sStartDate ;
			}

			$resign_check  = $this->get_resign_date($emp_id, $sStartDate, $sEndDate);
			if($resign_check != false)
			{
				$end_date = $resign_check ;
			}
			else
			{
				$end_date = $sEndDate ;
			}

			$left_check  = $this->get_left_date($emp_id, $sStartDate, $sEndDate);
			if($left_check != false)
			{
				$end_date = $left_check ;
			}
			else
			{
				$end_date = $sEndDate ;
			}

			$leave = $this->leave_per_emp($start_date, $end_date, $emp_id);
			//print_r($leave);

			$weekend = $this->check_weekend($start_date, $end_date, $emp_id);
			//print_r($weekend);

			$holiday = $this->holiday_calculation($start_date, $end_date);

			$days = $this->GetDays($start_date, $end_date);

			foreach($days as $day)
			{

				if($day >= "2013-10-01")
				{
					$holiday = $this->check_holiday($emp_id, $day);
				}
				$this->db->select('pr_emp_shift_log.in_time , pr_emp_shift_log.out_time, pr_emp_shift_log.shift_log_date, pr_emp_shift_log.ot, pr_emp_shift_log.eot,pr_emp_shift_log.late_status');
				$this->db->from('pr_emp_shift_log');
				$this->db->where('pr_emp_shift_log.emp_id',$emp_id);
				$this->db->where("pr_emp_shift_log.shift_log_date", $day);
				$this->db->order_by("pr_emp_shift_log.shift_log_date");
				$this->db->limit(1);
				$query3 = $this->db->get();
				//echo $this->db->last_query();
				foreach($query3->result() as $row3)
				{

					if(in_array($row3->shift_log_date,$leave))
					{
						$leave_type = $this->get_leave_type($row3->shift_log_date,$emp_id);
						$att_status_count = "Leave";
						$att_status = $leave_type;
						$row->in_time = "00:00:00";
						$row->out_time = "00:00:00";
					}
					elseif(in_array($row3->shift_log_date,$holiday))
					{
						$att_status = "Holiday";
						$att_status_count = "Holiday";
						$row->in_time = "00:00:00";
						$row->out_time = "00:00:00";
						$row->ot_hour ="";

					}
					elseif(in_array($row3->shift_log_date,$weekend))
					{
						$att_status = "Weekend";
						$att_status_count = "Weekend";
						$row->in_time = "00:00:00";
						$row->out_time = "00:00:00";
						$row->ot_hour ="";
					}
					elseif($row3->in_time !='00:00:00' and $row3->out_time !='00:00:00')
					{
						$att_status = "P";
						$att_status_count = "P";
					}
					elseif($row3->in_time !='00:00:00' or $row3->out_time !='00:00:00')
					{
						$att_status = "P(Error)";
						$att_status_count = "P(Error)";
					}
					else
					{
						$att_status = "A";
						$att_status_count = "A";
					}

					if($att_status !="Leave" and $att_status !="Holiday" and $att_status !="Weekend" and $att_status !="A" )
					{
						$table = "temp_$emp_id";
						$lunch_out_start = "12:55:00";
						$lunch_out_end = "15:00:00";
						$lunch_out = $this->time_check_in($day, $lunch_out_start , $lunch_out_end , $table);

						if($lunch_out !='')
						{
							$lunch_out_hour = trim(substr($lunch_out,0,2));
							$lunch_out_minute = trim(substr($lunch_out,3,2));
							$lunch_out_sec = trim(substr($lunch_out,6,2));
							$lunch_out = date("h:i:s A", mktime($lunch_out_hour, $lunch_out_minute, $lunch_out_sec, 0, 0, 0));
						}
						else
						{
							$lunch_out = "";
						}


						$lunch_in = $this->time_check_out($day, $lunch_out_start , $lunch_out_end , $table);

						if($lunch_in !='')
						{
							$lunch_in = trim(substr($lunch_in,11,19));

							$lunch_in_hour = trim(substr($lunch_in,0,2));
							$lunch_in_minute = trim(substr($lunch_in,3,2));
							$lunch_in_sec = trim(substr($lunch_in,6,2));
							$lunch_in = date("h:i:s A", mktime($lunch_in_hour, $lunch_in_minute, $lunch_in_sec, 0, 0, 0));
						}
						else
						{
							$lunch_in = "";
						}
					}
					else
					{
						$lunch_out = "";
						$lunch_in = "";
					}

					$emp_shift = $this->emp_shift_check($emp_id, $day);

					$schedule = $this->schedule_check($emp_shift);
					//print_r($schedule);
					$start_time		=  $schedule[0]["in_start"];
					$late_time 		=  $schedule[0]["late_start"];
					$end_time   	=  $schedule[0]["in_end"];
					$out_start_time	=  $schedule[0]["out_start"];
					$out_end_time	=  $schedule[0]["out_end"];

					if($row3->late_status == 1 )
					{
						$remark = "Late";
					}
					else
					{
						$remark = "";
					}

					$shift_log_date = $row3->shift_log_date;
					$year=trim(substr($shift_log_date,0,4));
					$month=trim(substr($shift_log_date,5,2));
					$date=trim(substr($shift_log_date,8,2));
					$shift_log_date = date("d-M-y", mktime(0, 0, 0, $month, $date, $year));

					if($row3->in_time != "00:00:00")
					{
						$in_time = $row3->in_time;
						$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);
					}
					else
					{
						$in_time = "00:00:00";
					}

					if($row3->out_time != "00:00:00")
					{
						$out_time = $row3->out_time;
						$out_time = $this->get_formated_out_time($emp_id, $out_time, $emp_shift);
					}
					else
					{
						$out_time = "00:00:00";
					}

					$total_ot_hour = $row3->ot_hour;


					$data[$emp_id]["att_status"][] 		= $att_status;
					$data[$emp_id]["att_status_count"][] = $att_status_count;
					$data[$emp_id]["lunch_out"][] 		= $lunch_out;
					$data[$emp_id]["lunch_in"][] 		= $lunch_in;
					$data[$emp_id]["remark"][] 			= $remark;



				}
			}

		}
		/*echo "<pre>";
		print_r($data);*/

		return $data;
	}

	function manual_attendance_entry($grid_firstdate, $grid_seconddate, $m_s_time, $grid_emp_id){
		$data = array();
		$query = $this->all_reguler_emp($grid_emp_id);

		foreach($query->result() as $row){
			$empid = $row->emp_id;
			$emp_table = "temp_".$empid;
			$deviceid = 1;

			$proxid = $this->prox($empid);

			$days = $this->GetDays($grid_firstdate, $grid_seconddate);
			foreach($days as $day){
				if($this->db->table_exists($emp_table) == TRUE ){
				$time = date('H:i:s',strtotime($m_s_time));
				$intime_entry = $day.' '.$time;
				// $intime_entry =  date("Y-m-d H:i:s",strtotime($intime_entry));
				$data = array('device_id'	=>$deviceid	, 'proxi_id'  =>$proxid, 'date_time'  => $intime_entry);
				$this->db->insert($emp_table, $data);
			}
		  }
		}
		return "Insert Successfully";
	}


	function manual_entry_Delete_old_11_12_2021($grid_firstdate, $grid_seconddate, $grid_emp_id){
		$data = array();
		$query = $this->all_reguler_emp($grid_emp_id);
		// print_r($query->result_array());exit;

		foreach($query->result() as $row){
			$id = $row->emp_id;

			$startdate = $grid_firstdate;
			$temp_table = "temp_$id";

			$proxi = $this->prox($id);

			$days = $this->GetDays($grid_firstdate, $grid_seconddate);
			//print_r($days);
			foreach($days as $perday){
				$date  = $perday;
				$year  = trim(substr($date,0,4));
				$month = trim(substr($date,5,2));
				$day   = trim(substr($date,8,2));

				$att_table = "att_".$year."_".$month;
				$date = date("d-m-Y", mktime(0, 0, 0, $month, $day, $year));
				$search_date = date("Ymd", mktime(0, 0, 0, $month, $day, $year));
				$unit_id = $this->common_model->get_unit_id_name();
				if($unit_id == 0)
				{
					return "Sorry! Only Unit wise user can delete.";
				}
				$file_name = "data/$date.TXT";
				$temp_table = "temp_$id";


				$where ="trim(substr(date_time ,1,10)) = '$perday'";
				$this->db->where($where);
				$data=$this->db->delete($temp_table);

				$where ="trim(substr(date_time ,1,10)) = '$perday' and proxi_id='$proxi'";
				$this->db->where($where);
				$data=$this->db->delete($att_table);
				// echo $this->db->last_query();exit;
				if ($data)
				{
					if( file_exists($file_name) )
					{

						$data = file($file_name);

						$out = array();

						foreach($data as $line) {
							$match_line =  substr($line,15,12);

							if(trim($match_line) != "$proxi") {
								$out[] = $line;
							}
						}
						//echo "Line".$line;
						//print_r($out);
						$fp = fopen($file_name, "w+");
						flock($fp, LOCK_EX);
						foreach($out as $line) {
							fwrite($fp, $line);
						}
						flock($fp, LOCK_UN);
						fclose($fp);
					}

				}
				else
				{
					return "Delete failed";
				}
			}
		}
		return "Delete successfully";

	}

	function manual_entry_Delete($grid_firstdate, $grid_seconddate, $grid_emp_id){
		date_default_timezone_set('Asia/Dhaka');
		$data = array();
		$query = $this->all_reguler_emp($grid_emp_id);
		// print_r($query->result_array());exit;

		foreach($query->result() as $row){

			$id = $row->emp_id;
			$proxi = $this->prox($id);

			$days = $this->GetDays($grid_firstdate, $grid_seconddate);
			//print_r($days);
			foreach($days as $perday){

				$att_table = "att_".date('Y_m',strtotime($perday));
				$temp_table = "temp_$id";

				$this->db->select('file_name');
				$this->db->where('upload_date',$perday);
				$query = $this->db->get('pr_attn_file_upload');
				if($query->num_rows() == 0){
					echo "Please upload attendance file.";
					exit;
				}
				$rawfile_name = $query->row()->file_name;
				$file_name = "data/$rawfile_name";

				$unit_id = $this->common_model->get_unit_id_name();
				if($unit_id == 0)
				{
					return "Sorry! Only Unit wise user can delete.";
				}

				$where ="trim(substr(date_time ,1,10)) = '$perday'";
				$this->db->where($where);
				$data=$this->db->delete($temp_table);

				$where ="trim(substr(date_time ,1,10)) = '$perday' and proxi_id='$proxi'";
				$this->db->where($where);
				$data=$this->db->delete($att_table);
				// echo $this->db->last_query();exit;
				if ($data)
				{
					if(file_exists($file_name) )
					{
						$files = file($file_name);
						$out = array();
						$outs = array();

						foreach($files as $line) {
							// $match_line =  substr($line,15,12);
							list($prox_no,$date,$time,$location,$device,$id,$floor, $i, $j) = preg_split('/\s+/', trim($line));

							// echo "Line".$line;
							// print_r($prox_no);
							// exit;
							if(trim($prox_no) != "$proxi") {
								$out[] = $line;
							}
						}
						//echo "Line".$line;
						//print_r($out);
						$fp = fopen($file_name, "w+");
						flock($fp, LOCK_EX);
						foreach($out as $line) {
							fwrite($fp, $line);
						}
						flock($fp, LOCK_UN);
						fclose($fp);
					}

				}
				else
				{
					return "Delete failed";
				}
			}
		}
		return "Delete successfully";

	}



	function save_work_off($grid_firstdate, $grid_emp_id,$unit_id,$friday_val){
		$data = array();

		$query = $this->all_reguler_emp($grid_emp_id);

		foreach($query->result() as $row){
			$work_off_empid = $row->emp_id;

			 $year_month = $grid_firstdate ;
			 $this->db->select("*");
			 $this->db->where('work_off_date',$year_month);
			 $this->db->where('emp_id',$work_off_empid);
			 $query = $this->db->get("attn_work_off");
			 $num_row = $query->num_rows();
			 if($num_row == 0 ){
					$data = array(
					'unit_id'		=> $unit_id,
					'emp_id'		=> $work_off_empid,
					'work_off_date'		=> $year_month,
					'replace_val'	=> $friday_val
					);
					//print_r($data);
					$this->db->insert('attn_work_off', $data) ;
				}
			}
		return "Insert Successfully";
	}

	function delete_work_off($grid_firstdate, $grid_emp_id,$unit_id)
	{
		$data = array();

		$query = $this->all_reguler_emp($grid_emp_id);

		foreach($query->result() as $row)
		{
			$work_off_empid = $row->emp_id;

			 $year_month = $grid_firstdate ;
			 $this->db->where('work_off_date',$year_month);
			 $this->db->where('emp_id',$work_off_empid);
			 $query = $this->db->delete("attn_work_off");
		}
		 return "Delete Successfully";
	}



	function save_holiday($grid_firstdate,$holiday_description,$grid_emp_id,$unit_id,$holiday_val)
	{
		$query = $this->all_reguler_emp($grid_emp_id);

		foreach($query->result() as $row)
		{
			$holiday_empid = $row->emp_id;

			 $year_month = $grid_firstdate ;
			 $this->db->select("*");
			 $this->db->where('holiday_date',$year_month);
			 $this->db->where('emp_id',$holiday_empid);
			 $query = $this->db->get("pr_holiday");
			 $num_row = $query->num_rows();
			 if($num_row == 0 )
			 {
				$data = array(
				'unit_id'		=> $unit_id,
				'emp_id'		=> $holiday_empid,
				'holiday_date'	=> $year_month,
				'description'	=> $holiday_description,
				'replace_val'	=> $holiday_val
				);
				//print_r($data);
				$this->db->insert('pr_holiday', $data) ;

			 }
		}
		return "Insert Successfully";
	}


	function delete_holiday($grid_firstdate,$grid_emp_id,$unit_id)
	{
		$query = $this->all_reguler_emp($grid_emp_id);

		foreach($query->result() as $row)
		{
			$holiday_empid = $row->emp_id;

			 $year_month = $grid_firstdate ;
			 $this->db->where('holiday_date',$year_month);
			 $this->db->where('emp_id',$holiday_empid);
			 $query = $this->db->delete("pr_holiday");

		}
		return "Delete Successfully.";
	}

	function grid_ctpat($grid_emp_id)
	{

		$this->db->select('pr_emp_blood_groups.blood_name,pr_emp_position.posi_name,pr_emp_skill.*,pr_emp_edu.*,pr_emp_per_info.no_child,pr_emp_sex.sex_nam_bng,pr_emp_com_info.emp_id,pr_emp_com_info.gross_sal,pr_emp_per_info.name_en, pr_emp_per_info.bangla_nam , pr_emp_per_info.emp_fname,pr_emp_per_info.emp_mname, emp_designation.desig_name, emp_designation.desig_bangla, pr_emp_com_info.emp_join_date, pr_emp_com_info.emp_sal_gra_id , emp_depertment.dept_name,emp_depertment.dept_bangla, emp_section.sec_name_en, emp_section.sec_name_en_bn, pr_id_proxi.proxi_id, pr_emp_add.emp_pre_add,pr_emp_add.emp_pre_add_ban, pr_emp_add.emp_par_add,pr_emp_add.emp_par_add_ban,pr_emp_per_info.emp_dob,pr_emp_per_info.emp_religion,pr_religions.religion_name');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->from('pr_religions');
		$this->db->from('pr_emp_sex');
		$this->db->from('pr_emp_edu');
		$this->db->from('pr_emp_skill');
		$this->db->from('pr_emp_position');
		$this->db->from('pr_emp_blood_groups');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_per_info.emp_religion = pr_religions.religion_id');
		$this->db->where('pr_emp_per_info.emp_sex = pr_emp_sex.sex_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_edu.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		$this->db->where('pr_emp_com_info.emp_position_id = pr_emp_position.posi_id');
		$this->db->where('pr_emp_per_info.emp_blood = pr_emp_blood_groups.blood_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		//echo $this->db->last_query();

		//print_r($query) ;

		if($query->num_rows() == 0)
		{
			return "Employee ID range does not exist!";
		}
		else
		{
			return $query;
		}
		//print_r($query->result_array());
	}




	function grid_monthly_salary_sheet_com($sal_year_month, $grid_status, $grid_emp_id)
	{
		// echo "hi";exit;
		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));
		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));

		$this->db->select('
				pr_emp_per_info.name_en,
				pr_emp_per_info.bangla_nam,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				emp_section.sec_name_bn,
				emp_section.sec_name_en,
				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.ot_entitle,
				pr_emp_com_info.ot_show_in,
				pr_grade.gr_name,
				pr_grade.gr_name_bn,
				pay_salary_sheet_com.*
			');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet_com');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');

		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet_com.emp_id');
		$this->db->where('pay_salary_sheet_com.stop_salary !=',2);
		$this->db->where("pay_salary_sheet_com.salary_month = '$sal_year_month'");
		$this->db->order_by("emp_designation.desig_name","ASC");

		$query = $this->db->get();

		return $query->result();
	}

	function grid_monthly_salary_sheet($sal_year_month, $grid_status, $grid_emp_id)
	{
		// dd($grid_emp_id);
		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));
		$this->db->select('
			emp_line_num.*,
			pr_emp_per_info.name_en,
			pr_emp_per_info.bank_bkash_no,
			emp_designation.desig_name,
			emp_designation.desig_bangla,
			emp_section.*,
			pr_emp_com_info.ot_entitle,
			pr_emp_com_info.emp_join_date,
			pr_grade.gr_name,
			pr_grade.gr_name,
			pay_salary_sheet.*,
			emp_line_num.line_name_en
		');
		$this->db->from('pr_emp_per_info');
		$this->db->join('pr_emp_com_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','left');
		$this->db->join('pr_grade','pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id','left');
		$this->db->join('pay_salary_sheet','pr_emp_per_info.emp_id = pay_salary_sheet.emp_id','left');
		$this->db->join('emp_depertment','pr_emp_com_info.emp_dept_id = emp_depertment.dept_id','left');
		$this->db->join('emp_section','pr_emp_com_info.emp_sec_id = emp_section.id','left');
		$this->db->join('emp_line_num','pr_emp_com_info.emp_line_id = emp_line_num.id','left');
		$this->db->join('emp_designation','pr_emp_com_info.emp_desi_id = emp_designation.id','left');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where("pay_salary_sheet.salary_month = '$sal_year_month'");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		// dd($query->result());
		return $query->result();
	}

	function grid_monthly_salary_sheet_bank($sal_year_month, $grid_status, $grid_emp_id)
	{
		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));

		$this->db->select('emp_line_num.*,pr_emp_per_info.name_en,pr_emp_per_info.bangla_nam,pr_emp_per_info.bank_ac_no,emp_designation.desig_name,emp_designation.desig_bangla, emp_section.*, pr_emp_com_info.emp_join_date,pr_emp_com_info.ot_show_in,pr_emp_com_info.ot_entitle,pr_grade.gr_name,pr_grade.gr_name_bn,pay_salary_sheet.*,emp_line_num.line_name_en');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');

		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet.emp_id');
		// $this->db->where('pay_salary_sheet.stop_salary !=',2);
		$this->db->where("pay_salary_sheet.salary_month = '$sal_year_month'");
		// $this->db->order_by("pr_emp_com_info.emp_id");
		// $this->db->order_by("emp_designation.desig_name");
		$this->db->order_by("emp_section.id","ASC");
		$this->db->group_by("pay_salary_sheet.emp_id");
		$query = $this->db->get();
		return $query->result();
	}


	function grid_mix_salary_sheet($sal_year_month, $grid_status, $grid_emp_id)
	{
		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));

		$this->db->select('emp_line_num.*,pr_emp_per_info.name_en,pr_emp_per_info.bangla_nam,emp_designation.desig_name,emp_designation.desig_bangla, emp_section.*, pr_emp_com_info.emp_join_date,pr_grade.gr_name,pr_grade.gr_name_bn,pay_salary_sheet_com.*,pr_emp_com_info.ot_show_in,pr_emp_com_info.ot_entitle,emp_line_num.line_name_en');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet_com');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');

		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet_com.emp_id');
		$this->db->where('pay_salary_sheet_com.stop_salary !=',2);
		$this->db->where("pay_salary_sheet_com.salary_month = '$sal_year_month'");
		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->order_by("emp_designation.desig_name","ASC");
		// $this->db->group_by("pay_salary_sheet_com.emp_id");
		$query = $this->db->get();
		return $query->result();
	}

	function grid_monthly_salary_sheet_all($sal_year_month, $grid_status, $grid_emp_id)
	{
		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));

		$this->db->select('emp_line_num.*,pr_emp_per_info.name_en,pr_emp_per_info.bangla_nam,pr_emp_per_info.bank_ac_no,emp_designation.desig_name,emp_designation.desig_bangla, emp_section.*, pr_emp_com_info.emp_join_date,pr_emp_com_info.ot_show_in,pr_emp_com_info.ot_entitle,pr_grade.gr_name,pr_grade.gr_name_bn,pay_salary_sheet.*,emp_line_num.line_name_en');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');

		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet.emp_id');
		// $this->db->where('pay_salary_sheet.stop_salary !=',2);
		$this->db->where("pay_salary_sheet.salary_month = '$sal_year_month'");
		// $this->db->order_by("pr_emp_com_info.emp_id");
		// $this->db->order_by("emp_designation.desig_name");
		$this->db->order_by("emp_section.id","ASC");
		// $this->db->group_by("pay_salary_sheet.emp_id");
		$query = $this->db->get();
		return $query->result();
	}


	function grid_monthly_eot_sheet_for_superadmin($sal_year_month, $grid_status, $grid_emp_id)
	{
		$yearmonth = date('Y-m', strtotime($sal_year_month));

		$this->db->select('pr_emp_per_info.name_en,emp_designation.desig_name, emp_section.sec_name_en, pr_emp_com_info.emp_join_date,pr_grade.gr_name,pay_salary_sheet.*,pr_emp_com_info.emp_join_date,emp_line_num.line_name_en, sum(pr_emp_shift_log.eot) as eot_hour');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');
		$this->db->from('pr_emp_shift_log');


		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where("pay_salary_sheet.salary_month = '$sal_year_month'");
		$this->db->where('pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_shift_log.present_status !=','W');
		$this->db->where('pr_emp_shift_log.present_status !=','H');
		$this->db->like('pr_emp_shift_log.shift_log_date',$yearmonth);
		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->order_by("emp_designation.desig_name");
		$this->db->group_by("pay_salary_sheet.emp_id");
		$this->db->group_by("pr_emp_shift_log.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();

	}


	function grid_monthly_salary_sheet_for_weeekend_allowance($sal_year_month, $grid_status, $grid_emp_id)
	{

		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));

		$this->db->select('pr_emp_per_info.name_en,emp_designation.desig_name, emp_section.sec_name_en, pr_emp_com_info.emp_join_date,pr_grade.gr_name,pay_salary_sheet.*,pr_emp_com_info.emp_join_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');


		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where("pay_salary_sheet.salary_month = '$sal_year_month'");
		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->order_by("emp_designation.desig_name");
		$this->db->group_by("pay_salary_sheet.emp_id");
		$query = $this->db->get();
		return $query->result();

	}

	function grid_festival_bonus($sal_year_month, $grid_status, $grid_emp_id){
		// dd($grid_emp_id);
		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));
		// dd($lastday);

		$this->db->select('pr_emp_per_info.*,
						   emp_designation.*,
						   emp_section.*,
						   pr_emp_com_info.emp_join_date,
						   pr_grade.gr_name,
						   pr_festival_bonus_sheet.*,
						   pr_emp_com_info.emp_join_date,
						   emp_line_num.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pr_festival_bonus_sheet');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');


		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_festival_bonus_sheet.emp_id');
		$this->db->where("pr_festival_bonus_sheet.effective_month = '$sal_year_month'");
		$this->db->where("pr_festival_bonus_sheet.bonus_amount != 0 ");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		// $this->db->order_by("emp_designation.desig_name");
		// $this->db->group_by("pr_festival_bonus_sheet.emp_id");
		$query = $this->db->get();
		// dd($query->result());
		return $query->result();

	}

	function grid_earn_leave($sal_year_month, $grid_status, $grid_emp_id)
	{
		/*$this->db->select("emp_depertment.dept_name");
		$this->db->from('emp_depertment');
		$this->db->from('pr_emp_com_info');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->group_by("emp_depertment.dept_name");
		$this->db->order_by("emp_depertment.dept_name");
		$query = $this->db->get();
		echo $this->db->last_query();	*/
		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));

		$this->db->select('pr_emp_per_info.name_en,emp_designation.desig_name, emp_section.sec_name_en, pr_emp_com_info.emp_join_date,pr_grade.gr_name,pay_salary_sheet.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pay_salary_sheet');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			if($grid_status == 4)
			{
				$this->db->from('pr_emp_resign_history');
			}


			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where("pay_salary_sheet.salary_month = '$sal_year_month'");
		if($grid_status == 4)
		{
			$salary_month = substr($sal_year_month,0,7);
			$this->db->where('pr_emp_com_info.emp_id = pr_emp_resign_history.emp_id');
			$this->db->where("trim(substr(pr_emp_resign_history.resign_date,1,7)) LIKE '$salary_month'");
		}
		$this->db->where('pr_emp_com_info.emp_join_date <= ', $lastday);


		$this->db->order_by("pr_emp_com_info.emp_id");
		$this->db->group_by("pay_salary_sheet.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();

	}

	function get_resign_date_by_empid($emp_id)
	{
		$this->db->select('resign_date');
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('pr_emp_resign_history');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $resign_date = $row->resign_date;
		}
		else
		{ return false;}
	}

	function get_left_date_by_empid($emp_id)
	{
		$this->db->select('left_date');
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('pr_emp_left_history');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $resign_date = $row->left_date;
		}
		else
		{ return false;}
	}

	function grid_comprative_salary_statement($salary_month,$salary_month2,$grid_status,$grid_unit,$stop_salary){
		$data["first_month"]= $this->salary_summary($salary_month,$grid_status,$grid_unit,$stop_salary);
		$data["second_month"]= $this->salary_summary($salary_month2,$grid_status,$grid_unit,$stop_salary);
		return $data;
	}

	function salary_summary($salary_month,$emp_stat,$grid_unit,$stop_salary){
		$all_data = array();
		$this->db->select("id,line_name_en");
		$this->db->where("unit_id",$grid_unit);
		$this->db->order_by("line_name_en");
		$query = $this->db->get("emp_line_num");
		foreach($query->result() as $rows){
			//echo "nai";exit;
			$data = array();
			$data1 = array();

			$line_id = $rows->id;
			$all_data["sec_name_en"][] = $rows->line_name_en;//$this->get_line_name($line_id);

			// For Cash Man Power
			$salary_draw_cash = 1;
			$emp_cash = $this->count_empid_for_salary($line_id,$emp_stat,$salary_month,$salary_draw_cash,$stop_salary,"count");
			//dd($emp_cash);
			$all_data["emp_cash"][] = $emp_cash;


			// For Bank Man Power
			$salary_draw_bank = 2;
			$emp_bank = $this->count_empid_for_salary($line_id,$emp_stat,$salary_month,$salary_draw_bank,$stop_salary,"count");
			$all_data["emp_bank"][] = $emp_bank;

			$all_data["emp_cash_bank"][] =$emp_cash + $emp_bank;

			// For Cash Emp ID
			$cash_emp_id = $this->count_empid_for_salary($line_id,$emp_stat,$salary_month,$salary_draw_cash,$stop_salary,"emp_id");
			foreach($cash_emp_id as $rows)
			{
				 $data[] = $rows->emp_id;
			}
			$data = implode("xxx",$data);
			$emp_id_cash = explode('xxx', trim($data));


			// For Bank Emp ID
			$bank_emp_id = $this->count_empid_for_salary($line_id,$emp_stat,$salary_month,$salary_draw_bank,$stop_salary,"emp_id");
			foreach($bank_emp_id as $rows)
			{
				$data1[] = $rows->emp_id;
			}

			$data1 = implode("xxx",$data1);
			$emp_id_bank = explode('xxx', trim($data1));

			//For Cash gross_sal
			$column_name = "gross_sal" ;
			$gross_sal_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$cash_total = $gross_sal_cash;
			$all_data["cash_sum"][] = $gross_sal_cash;


			//For Bank gross_sal
			//print_r($emp_id_bank);
			$gross_sal_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$bank_total = $gross_sal_bank;
			$all_data["bank_sum"][] = $gross_sal_bank;

			//For Cash basic_sal
			$column_name = "basic_sal" ;
			$basic_sal_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);			$all_data["cash_sum_basic"][] = $basic_sal_cash;

			//For Bank basic_sal
			$basic_sal_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);			$all_data["bank_sum_basic"][] = $basic_sal_bank;

			//For Cash house_r
			$column_name = "house_r" ;
			$all_data["cash_sum_house_r"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank house_r
			$all_data["bank_sum_house_r"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash medical_a
			$column_name = "medical_a" ;
			$all_data["cash_sum_medical_a"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank medical_a
			$all_data["bank_sum_medical_a"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash food_allow
			$column_name = "food_allow" ;
			$all_data["cash_sum_food_allow"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank food_allow
			$all_data["bank_sum_food_allow"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash trans_allow
			$column_name = "trans_allow" ;
			$all_data["cash_sum_trans_allow"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank trans_allow
			$all_data["bank_sum_trans_allow"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash ot_hour
			$column_name = "ot_hour" ;
			$all_data["cash_sum_ot_hour"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank ot_hour
			$all_data["bank_sum_ot_hour"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash ot_amount
			$column_name = "ot_amount" ;
			$all_data["cash_sum_ot_amount"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank ot_amount
			$all_data["bank_sum_ot_amount"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);


			//For Cash att_bonus
			$column_name = "att_bonus" ;
			$att_bonus_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$cash_total = $cash_total + $att_bonus_cash;
			$all_data["cash_att_bonus"][] = $att_bonus_cash;

			//For Bank att_bonus
			$column_name = "att_bonus" ;
			$att_bonus_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$bank_total = $bank_total + $att_bonus_bank;
			$all_data["bank_att_bonus"][] = $att_bonus_bank;

			//For Cash net_pay
			$column_name = "net_pay" ;
			$all_data["cash_sum_net_pay"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank net_pay
			$all_data["bank_sum_net_pay"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);


			//For Cash ot_amount
			$column_name = "ot_amount" ;
			$ot_amount_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$cash_total = $cash_total + $ot_amount_cash;
			$all_data["cash_ot_amount"][] = $ot_amount_cash;

			//For Bank ot_amount
			$ot_amount_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$bank_total = $bank_total + $ot_amount_bank;
			$all_data["bank_ot_amount"][] = $ot_amount_bank;

			//==============This is for Festival Bonus=====================
			//==============================================================

			//For Cash ot_amount
			$column_name = "festival_bonus" ;
			$festival_bonus_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["festival_bonus_cash"][] = $festival_bonus_cash;

			//For Bank ot_amount
			$festival_bonus_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["festival_bonus_bank"][] = $festival_bonus_bank;



			//======================End of festival Bonus==================

			//For Cash eot_hour
			$column_name = "eot_hour" ;
			$eot_hour_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_eot_hour"][] = $eot_hour_cash;

			//For Bank eot_amount
			$eot_hour_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_eot_hour"][] = $eot_hour_bank;

			$total_cash_bank_eot_hour = $eot_hour_cash + $eot_hour_bank;
			$all_data["total_cash_bank_eot_hour"][] = $total_cash_bank_eot_hour;

			//For Cash eot_amount
			$column_name = "eot_amount" ;
			$eot_amount_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_eot_amount"][] = $eot_amount_cash;

			//For Bank eot_amount
			$eot_amount_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_eot_amount"][] = $eot_amount_bank;

			$total_cash_bank_eot_amount = $eot_amount_cash + $eot_amount_cash;
			$all_data["total_cash_bank_eot_amount"][] = $total_cash_bank_eot_amount;

			//=================Total Cash Salary calculation===============
			$all_data["cash_total"][] = $cash_total;
			//=================Total Bank Salary calculation===============
			$all_data["bank_total"][] = $bank_total;
			//=================Total Cash & Bank Salary calculation=========
			$total_cash_and_bank = $cash_total + $bank_total;
			$all_data["total_cash_and_bank"][] = $total_cash_and_bank;

			//For Cash adv_deduct
			$column_name = "adv_deduct" ;
			$adv_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $adv_deduct_cash;
			$all_data["adv_deduct_cash"][] = $adv_deduct_cash;

			//For Bank adv_deduct
			$adv_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $adv_deduct_bank;
			$all_data["adv_deduct_bank"][] = $adv_deduct_bank;

			//For Cash abs_deduction
			$column_name = "abs_deduction" ;
			$abs_deduction_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $abs_deduction_cash;
			$all_data["abs_deduction_cash"][] = $abs_deduction_cash;

			//For Bank abs_deduction
			$abs_deduction_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $abs_deduction_bank;
			$all_data["abs_deduction_bank"][] = $abs_deduction_bank;

			//For Cash late_deduct
			$column_name = "late_deduct" ;
			$late_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $late_deduct_cash;
			$all_data["late_deduct_cash"][] = $late_deduct_cash;

			//For Bank abs_deduction
			$late_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $late_deduct_bank;
			$all_data["late_deduct_bank"][] = $late_deduct_bank;

			//For Cash late_deduct
			$column_name = "others_deduct" ;
			$others_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $others_deduct_cash;
			$all_data["others_deduct_cash"][] = $others_deduct_cash;

			//For Bank late_deduct
			$others_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $others_deduct_bank;
			$all_data["others_deduct_bank"][] = $others_deduct_bank;


			//For Cash late_deduct
			$column_name = "tax_deduct" ;
			$tax_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $tax_deduct_cash;
			$all_data["tax_deduct_cash"][] = $tax_deduct_cash;

			//For Bank late_deduct
			$tax_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $tax_deduct_bank;
			$all_data["tax_deduct_bank"][] = $tax_deduct_bank;

			//For Cash stamp
			$column_name = "stamp" ;
			$stam_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $stam_deduct_cash;
			$all_data["stam_deduct_cash"][] = $stam_deduct_cash;

			//For Bank stamp
			$stam_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $stam_deduct_bank;
			$all_data["stam_deduct_bank"][] = $stam_deduct_bank;


			$all_data["sub_total_cash_deduction"][]= $total_cash_deduction;
			$all_data["sub_total_bank_deduction"][] = $total_bank_deduction;
			$all_data["sub_total_cash_bank_deduction"][] = $total_cash_deduction + $total_bank_deduction;


			//=================Total Bank Others Deduct calculation===============<<
			//echo $total_cash_deduction."===";
			//=================Total Cash after deduction calculation===============>>
			$total_cash_after_deduct = $cash_total - $total_cash_deduction;

			$all_data["total_cash_after_deduct"][] = $total_cash_after_deduct;
			//=================Total Cash after deduction calculation===============<<

			//=================Total Cash after deduction calculation===============>>
			$total_bank_after_deduct = $bank_total - $total_bank_deduction;

			$all_data["total_bank_after_deduct"][] = $total_bank_after_deduct;
			//=================Total Cash after deduction calculation===============<<

			//=================Total Cash+Bank calculation===============>>
			$sub_total = $total_cash_after_deduct + $total_bank_after_deduct;

			$all_data["sub_total"][] = $sub_total;
			//=================Total Cash+Bank calculation===============<<

		}
		 //dd($all_data["emp_cash"]);
		 //dd($all_data);
		return $all_data;
	}

	function sec_salary_summary($salary_month,$emp_stat,$grid_unit,$stop_salary){
		// echo "hi";exit;
		$all_data = array();

		$salary_month = $salary_month;

		$this->db->select("id as sec_id,sec_name_en");
		$this->db->where("unit_id",$grid_unit);
		$this->db->order_by("sec_name_en");
		$query = $this->db->get("emp_section");

		foreach($query->result() as $rows)
		{
			$data = array();
			$data1 = array();

			$line_id = $rows->sec_id;
			$all_data["sec_name_en"][] = $rows->sec_name_en;


			// For Cash Man Power
			$salary_draw_cash = 1;
			$emp_cash = $this->count_empid_for_sec_salary($line_id,$emp_stat,$salary_month,$salary_draw_cash,$stop_salary,"count");
			//dd($emp_cash);
			$all_data["emp_cash"][] = $emp_cash;
			//echo $emp_cash;
			// For Bank Man Power
			$salary_draw_bank = 2;
			$emp_bank = $this->count_empid_for_sec_salary($line_id,$emp_stat,$salary_month,$salary_draw_bank,$stop_salary,"count");
			$all_data["emp_bank"][] = $emp_bank;

			$all_data["emp_cash_bank"][] =$emp_cash + $emp_bank;

			// For Cash Emp ID
			$cash_emp_id = $this->count_empid_for_sec_salary($line_id,$emp_stat,$salary_month,$salary_draw_cash,$stop_salary,"emp_id");
			foreach($cash_emp_id as $rows)
			{
				 $data[] = $rows->emp_id;
			}
			$data = implode("xxx",$data);
			$emp_id_cash = explode('xxx', trim($data));

			// For Bank Emp ID
			$bank_emp_id = $this->count_empid_for_sec_salary($line_id,$emp_stat,$salary_month,$salary_draw_bank,$stop_salary,"emp_id");
			foreach($bank_emp_id as $rows)
			{
				$data1[] = $rows->emp_id;
			}
			$data1 = implode("xxx",$data1);
			$emp_id_bank = explode('xxx', trim($data1));

			//For Cash gross_sal
			$column_name = "gross_sal" ;
			$gross_sal_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$cash_total = $gross_sal_cash;
			$all_data["cash_sum"][] = $gross_sal_cash;

			//For Bank gross_sal
			//print_r($emp_id_bank);
			$gross_sal_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$bank_total = $gross_sal_bank;
			$all_data["bank_sum"][] = $gross_sal_bank;

			//For Cash basic_sal
			$column_name = "basic_sal" ;
			$basic_sal_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);			$all_data["cash_sum_basic"][] = $basic_sal_cash;

			//For Bank basic_sal
			$basic_sal_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);			$all_data["bank_sum_basic"][] = $basic_sal_bank;

			//For Cash house_r
			$column_name = "house_r" ;
			$all_data["cash_sum_house_r"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			//For Bank house_r
			$all_data["bank_sum_house_r"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			//For Cash medical_a
			$column_name = "medical_a" ;
			$all_data["cash_sum_medical_a"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank medical_a
			$all_data["bank_sum_medical_a"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash food_allow
			$column_name = "food_allow" ;
			$all_data["cash_sum_food_allow"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank food_allow
			$all_data["bank_sum_food_allow"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash trans_allow
			$column_name = "trans_allow" ;
			$all_data["cash_sum_trans_allow"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank trans_allow
			$all_data["bank_sum_trans_allow"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash ot_hour
			$column_name = "ot_hour" ;
			$all_data["cash_sum_ot_hour"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank ot_hour
			$all_data["bank_sum_ot_hour"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash ot_amount
			$column_name = "ot_amount" ;
			$all_data["cash_sum_ot_amount"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);

			//For Bank ot_amount
			$all_data["bank_sum_ot_amount"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			//For Cash ot_amount
			$column_name = "ot_hour" ;
			$cash_sum_w_h_ot_hour = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_sum_w_h_ot_hour"][] = $cash_sum_w_h_ot_hour;

			$bank_sum_w_h_ot_hour = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_sum_w_h_ot_hour"][] = $bank_sum_w_h_ot_hour;

			$column_name = "ot_amount" ;
			$cash_sum_w_h_ot_amt = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_sum_w_h_ot_amt"][] = $cash_sum_w_h_ot_amt;

			$bank_sum_w_h_ot_amt = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_sum_w_h_ot_amt"][] = $bank_sum_w_h_ot_amt;


			//For Cash att_bonus
			$column_name = "att_bonus" ;
			$att_bonus_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$cash_total = $cash_total + $att_bonus_cash;
			$all_data["cash_att_bonus"][] = $att_bonus_cash;

			//For Bank att_bonus
			$column_name = "att_bonus" ;
			$att_bonus_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$bank_total = $bank_total + $att_bonus_bank;
			$all_data["bank_att_bonus"][] = $att_bonus_bank;

			//================================================
			$this->db->select("COUNT(att_bonus) as att_bonus_man");
			$this->db->from("pay_salary_sheet");
			$this->db->where_in('pay_salary_sheet.emp_id', $emp_id_bank);
			$this->db->where('pay_salary_sheet.att_bonus !=', 0);
			$this->db->like("salary_month", $salary_month);
			$query = $this->db->get();
			// echo $this->db->last_query();
			$row = $query->row();
			$att_bonus_man_bank = $row->att_bonus_man;
			if($att_bonus_man_bank ==''){$att_bonus_man_bank = 0;}

			$this->db->select("COUNT(att_bonus) as att_bonus_man");
			$this->db->from("pay_salary_sheet");
			$this->db->where_in('pay_salary_sheet.emp_id', $emp_id_cash);
			$this->db->where('pay_salary_sheet.att_bonus !=', 0);
			$this->db->like("salary_month", $salary_month);
			$query = $this->db->get();
			//echo $this->db->last_query();
			$row = $query->row();
			$att_bonus_man_cash = $row->att_bonus_man;
			if($att_bonus_man_cash ==''){$att_bonus_man_cash = 0;}

			$all_data["att_bonus_man_total"][]= $att_bonus_man_bank + $att_bonus_man_cash;
			//For Cash net_pay
			$column_name = "net_pay";
			$all_data["cash_sum_net_pay"][]=$this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			//For Bank net_pay
			$all_data["bank_sum_net_pay"][]=$this->get_sum_column($column_name,$emp_id_bank,$salary_month);

			/*//For Cash 	holiday_allowance
			$column_name = "holiday_allowance" ;
			$holiday_allowance_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$cash_total = $cash_total + $holiday_allowance_cash;
			$all_data["holiday_allowance_cash"][] = $holiday_allowance_cash;

			//For Bank holiday_allowance_bank
			$holiday_allowance_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$bank_total = $bank_total + $holiday_allowance_bank;
			$all_data["holiday_allowance_bank"][] = $holiday_allowance_bank;


			//For Cash 	night_allowance
			$column_name = "night_allowance" ;
			$night_allowance_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$cash_total = $cash_total + $night_allowance_cash;
			$all_data["night_allowance_cash"][] = $night_allowance_cash;

			//For Bank night_allowance
			$night_allowance_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$bank_total = $bank_total + $night_allowance_bank;
			$all_data["night_allowance_bank"][] = $night_allowance_bank;*/


			//===========This is for Festival Bonus==========

			//For Cash ot_amount
			$column_name = "festival_bonus" ;
			$festival_bonus_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["festival_bonus_cash"][] = $festival_bonus_cash;

			//For Bank ot_amount
			$festival_bonus_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["festival_bonus_bank"][] = $festival_bonus_bank;



			//======================End of festival Bonus==================

			//For Cash eot_hour
			$column_name = "eot_hour" ;
			$eot_hour_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_eot_hour"][] = $eot_hour_cash;

			//For Bank eot_amount
			$eot_hour_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_eot_hour"][] = $eot_hour_bank;

			$total_cash_bank_eot_hour = $eot_hour_cash + $eot_hour_bank;
			$all_data["total_cash_bank_eot_hour"][] = $total_cash_bank_eot_hour;

			//For Cash eot_amount
			$column_name = "eot_amount" ;
			$eot_amount_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_eot_amount"][] = $eot_amount_cash;

			//For Bank eot_amount
			$eot_amount_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_eot_amount"][] = $eot_amount_bank;

			$total_cash_bank_eot_amount = $eot_amount_cash + $eot_amount_cash;
			$all_data["total_cash_bank_eot_amount"][] = $total_cash_bank_eot_amount;

			//=================Total Cash Salary calculation===============
			$all_data["cash_total"][] = $cash_total;
			//=================Total Bank Salary calculation===============
			$all_data["bank_total"][] = $bank_total;
			//=================Total Cash & Bank Salary calculation=========
			$total_cash_and_bank = $cash_total + $bank_total;
			$all_data["total_cash_and_bank"][] = $total_cash_and_bank;

			//For Cash adv_deduct
			$column_name = "deduct_hour" ;
			$deduct_hour_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduct_hour = $deduct_hour_cash;
			$all_data["deduct_hour_cash"][] = $deduct_hour_cash;

			//For Bank adv_deduct
			$deduct_hour_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduct_hour = $deduct_hour_bank;
			$all_data["deduct_hour_bank"][] = $deduct_hour_bank;

			$all_data["t_deduct_hour"][] = $total_cash_deduct_hour + $total_bank_deduct_hour;
			// print_r($all_data["t_deduct_hour"]);

			//For Cash adv_deduct
			$column_name = "adv_deduct" ;
			$adv_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $adv_deduct_cash;
			$all_data["adv_deduct_cash"][] = $adv_deduct_cash;

			//For Bank adv_deduct
			$adv_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $adv_deduct_bank;
			$all_data["adv_deduct_bank"][] = $adv_deduct_bank;

			//For Cash abs_deduction
			$column_name = "abs_deduction" ;
			$abs_deduction_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $abs_deduction_cash;
			$all_data["abs_deduction_cash"][] = $abs_deduction_cash;

			//For Bank abs_deduction
			$abs_deduction_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $abs_deduction_bank;
			$all_data["abs_deduction_bank"][] = $abs_deduction_bank;

			//For Cash late_deduct
			$column_name = "late_deduct" ;
			$late_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $late_deduct_cash;
			$all_data["late_deduct_cash"][] = $late_deduct_cash;

			//For Bank abs_deduction
			$late_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $late_deduct_bank;
			$all_data["late_deduct_bank"][] = $late_deduct_bank;

			//For Cash late_deduct
			$column_name = "others_deduct" ;
			$others_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $others_deduct_cash;
			$all_data["others_deduct_cash"][] = $others_deduct_cash;

			//For Bank late_deduct
			$others_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $others_deduct_bank;
			$all_data["others_deduct_bank"][] = $others_deduct_bank;


			//For Cash late_deduct
			$column_name = "tax_deduct" ;
			$tax_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $tax_deduct_cash;
			$all_data["tax_deduct_cash"][] = $tax_deduct_cash;

			//For Bank late_deduct
			$tax_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $tax_deduct_bank;
			$all_data["tax_deduct_bank"][] = $tax_deduct_bank;

			//For Cash stamp
			$column_name = "stamp" ;
			$stam_deduct_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $stam_deduct_cash;
			$all_data["stam_deduct_cash"][] = $stam_deduct_cash;

			//For Bank stamp
			$stam_deduct_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $stam_deduct_bank;
			$all_data["stam_deduct_bank"][] = $stam_deduct_bank;


			$all_data["sub_total_cash_deduction"][]= $total_cash_deduction;
			$all_data["sub_total_bank_deduction"][] = $total_bank_deduction;
			$all_data["sub_total_cash_bank_deduction"][] = $total_cash_deduction + $total_bank_deduction;

			//=================Total Cash after deduction calculation===============>>
			$total_cash_after_deduct = $cash_total - $total_cash_deduction;
			$all_data["total_cash_after_deduct"][] = $total_cash_after_deduct;
			$total_bank_after_deduct = $bank_total - $total_bank_deduction;

			$all_data["total_bank_after_deduct"][] = $total_bank_after_deduct;
			//=================Total Cash+Bank calculation===============>>
			$sub_total = $total_cash_after_deduct + $total_bank_after_deduct;

			$all_data["sub_total"][] = $sub_total;
		}
		// dd($all_data);
		return $all_data;
	}

	function salary_summary_test($salary_month,$status,$grid_unit,$stop_salary){
		// echo "hi";exit;
		/*$stop_salary = 1;
		$status = 'ALL';*/
		$data = array();
		$this->db->select('*');
		$query = $this->db->get('pr_floor');

		foreach($query->result() as $row) {
			$floor_id = $row->id;
			$data[$floor_id]['floor_name']= $row->floor_name;

			$query_1 = $this->db->select('*')->order_by('sec_index')->get('emp_section');

			foreach($query_1->result() as $rows){
				$sec_id = $rows->sec_id;
				$sec_strength = $rows->strength;
				$sec_str_staff = $rows->str_staff;

				$query_2 =$this->db->select('*')->order_by('line_name')->get('emp_line_num');
				foreach($query_2->result() as $row_2){
					$line_id = $row_2->line_id;

					$all_emp_FSL= $this->all_emp_floor_sec_line_salary_summary($floor_id,$sec_id,$line_id,$salary_month);

					if(!empty($all_emp_FSL)){

						$data[$floor_id]['floor_info'][$sec_id]['sec_name_en'] = $rows->sec_name_en;
						$data[$floor_id]['floor_info'][$sec_id]['sec_id'] = $sec_id;

						$data[$floor_id]['floor_info'][$sec_id]['sec_info'][$line_id]['line_name'] = $row_2->line_name;

						$data[$floor_id]['floor_info'][$sec_id]['sec_info'][$line_id]['line_info'] = $this->salary_summary_test_new($salary_month,$all_emp_FSL,$stop_salary,$status);
						}/*else{
							$data[$floor_id]['floor_info'][$sec_id]['sec_info'][$line_id]['line_info'] = "null";
							}*/
				}
			}
		}
		/*echo "<pre>";
		print_r($data);
		exit;*/
		return $data;
	}


	function all_emp_floor_sec_line_salary_summary($floor_id, $sec_id, $line_id, $salary_month){
		// echo $floor_id.'=='.$sec_id.'=='.$line_id;
		// $sec_id = 5;
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pay_salary_sheet');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_per_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where("pay_salary_sheet.salary_month = '$salary_month'");
		$this->db->where('pay_salary_sheet.floor_id',$floor_id);
		$this->db->where('pay_salary_sheet.sec_id',$sec_id);
		$this->db->where('pay_salary_sheet.line_id',$line_id);

		$data = array();
		$query = $this->db->get();
		// echo $this->db->last_query();
		foreach($query->result() as $rows){
			$data[] = $rows->emp_id;
		}
		/*print_r($data);
		exit;*/
		return $data;
	}


	function salary_summary_test_new($salary_month,$all_emp_FSL,$stop_salary,$status){

		$data =array();
		$arr = array();
	    $salary_draw_cash = 1;
		$emp_cash = $this->count_empid_for_salary_floor_wise($all_emp_FSL,$status,$salary_draw_cash,$stop_salary,$salary_month,"count");
		$all_data["emp_cash"] = $emp_cash;


		$salary_draw_bank = 2;
		$emp_bank = $this->count_empid_for_salary_floor_wise($all_emp_FSL,$status,$salary_draw_bank,$stop_salary,$salary_month,"count");
		$all_data["emp_bank"] = $emp_bank;

		$all_data["emp_cash_bank"]= $emp_cash + $emp_bank;

		$cash_emp_id = $this->count_empid_for_salary_floor_wise($all_emp_FSL,$status,$salary_draw_cash,$stop_salary,$salary_month,"emp_id");

			foreach($cash_emp_id as $rows)
			{
				 $data[] = $rows->emp_id;
				 $arr[] = $rows->emp_id;
			}

			$data = implode("xxx",$data);
			$emp_id_cash = explode('xxx', trim($data));

			// For Bank Emp ID
			$bank_emp_id = $this->count_empid_for_salary_floor_wise($all_emp_FSL,$status,$salary_draw_bank,$stop_salary,$salary_month,"emp_id");

			foreach($bank_emp_id as $rows)
			{
				$data1[] = $rows->emp_id;
				$arr[] = $rows->emp_id;
			}

			$data1 = implode("xxx",$data1);
			$emp_id_bank = explode('xxx', trim($data1));

			//For Cash gross_sal
			$column_name = "gross_sal" ;
			$gross_sal_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$cash_total = $gross_sal_cash;
			$all_data["cash_sum"] = $gross_sal_cash;

			//For Bank gross_sal
			//print_r($emp_id_bank);
			$gross_sal_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$bank_total = $gross_sal_bank;
			$all_data["bank_sum"] = $gross_sal_bank;

			$all_data["tgross"] = $all_data["cash_sum"] + $all_data["bank_sum"];

			//For Cash basic_sal
			$column_name = "basic_sal" ;
			$basic_sal_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);			$all_data["cash_sum_basic"] = $basic_sal_cash;

			//For Bank basic_sal
			$basic_sal_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);			$all_data["bank_sum_basic"] = $basic_sal_bank;

			$all_data["tbasic"] = $all_data["cash_sum_basic"] + $all_data["bank_sum_basic"];

			//For Cash house_r
			$column_name = "house_r" ;
			$all_data["cash_sum_house_r"]=$this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			//For Bank house_r
			$all_data["bank_sum_house_r"]=$this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			$all_data["thouse_r"] = $all_data["cash_sum_house_r"] + $all_data["bank_sum_house_r"];

			//For Cash medical_a
			$column_name = "medical_a";
			$all_data["cash_sum_medical_a"]=$this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			//For Bank medical_a
			$all_data["bank_sum_medical_a"]=$this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			$all_data["tmedical_a"] = $all_data["cash_sum_medical_a"] + $all_data["bank_sum_medical_a"];

			//For Cash food_allow
			$column_name = "food_allow";
			$all_data["cash_sum_food_allow"]=$this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			//For Bank food_allow
			$all_data["bank_sum_food_allow"]=$this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			$all_data["tfood_a"] = $all_data["cash_sum_food_allow"] + $all_data["bank_sum_food_allow"];

			//For Cash trans_allow
			$column_name = "trans_allow" ;
			$all_data["cash_sum_trans_allow"]=$this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			//For Bank trans_allow
			$all_data["bank_sum_trans_allow"]=$this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			$all_data["ttrans_a"] = $all_data["cash_sum_trans_allow"] + $all_data["bank_sum_trans_allow"];

			$staff_id = $this->count_staff_id($arr);
			/*echo "<pre>";
			print_r($staff_id);*/
			if(!empty($staff_id)){
				$column_name = "ot_hour";
				$tstaff_ot_hour = $this->get_sum_column_for_salary($column_name,$staff_id,$salary_month);
				$column_name = "eot_hour";
				$tstaff_eot_hour = $this->get_sum_column_for_salary($column_name,$staff_id,$salary_month);

				$tstaff_ot = $tstaff_ot_hour + $tstaff_eot_hour;

				$column_name = "ot_amount";
				$tstaff_ot_amount = $this->get_sum_column_for_salary($column_name,$staff_id,$salary_month);
				$column_name = "eot_amount";
				$tstaff_eot_amount = $this->get_sum_column_for_salary($column_name,$staff_id,$salary_month);
				$tstaff_ot_amt = $tstaff_ot_amount + $tstaff_eot_amount;

				// echo $all = $column_name + $column_name + $column_name + $column_name;
			}

			//For Cash ot_hour
			$column_name = "ot_hour";
			$all_data["cash_sum_ot_hour"]=$this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			$column_name = "eot_hour";
			$all_data["cash_sum_eot_hour"]=$this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			//For Bank ot_hour
			$column_name = "ot_hour";
			$all_data["bank_sum_ot_hour"]=$this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			$column_name = "eot_hour";
			$all_data["bank_sum_eot_hour"]=$this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			$all_data["tot_hour"] = $all_data["cash_sum_ot_hour"] + $all_data["cash_sum_eot_hour"] + $all_data["bank_sum_ot_hour"] + $all_data["bank_sum_eot_hour"] - $tstaff_ot;

			//For Cash ot_amount
			$column_name = "ot_amount";
			$all_data["cash_sum_ot_amount"]=$this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			$column_name = "eot_amount";
			$all_data["cash_sum_eot_amount"]=$this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			//For Bank ot_amount
			$column_name = "ot_amount";
			$all_data["bank_sum_ot_amount"]=$this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			$column_name = "eot_amount";
			$all_data["bank_sum_eot_amount"]=$this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			$all_data["tot_amt"] = $all_data["cash_sum_ot_amount"] + $all_data["cash_sum_eot_amount"] + $all_data["bank_sum_ot_amount"] + $all_data["bank_sum_eot_amount"]-$tstaff_ot_amt;

			//For Cash att_bonus
			$column_name = "att_bonus";
			$att_bonus_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$cash_total = $cash_total + $att_bonus_cash;
			$all_data["cash_att_bonus"] = $att_bonus_cash;

			//For Bank att_bonus
			$column_name = "att_bonus" ;
			$att_bonus_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$bank_total = $bank_total + $att_bonus_bank;
			$all_data["bank_att_bonus"] = $att_bonus_bank;

			$all_data["t_bonus"] = $all_data["cash_att_bonus"] + $all_data["bank_att_bonus"];

			//================================================
			$this->db->select("COUNT(att_bonus) as att_bonus_man");
			$this->db->from("pay_salary_sheet");
			$this->db->where_in('pay_salary_sheet.emp_id', $emp_id_bank);
			$this->db->where('pay_salary_sheet.att_bonus !=', 0);
			$this->db->like("salary_month", $salary_month);
			$query = $this->db->get();
			//echo $this->db->last_query();
			$row = $query->row();
			$att_bonus_man_bank = $row->att_bonus_man;
			if($att_bonus_man_bank ==''){$att_bonus_man_bank = 0;}

			$this->db->select("COUNT(att_bonus) as att_bonus_man");
			$this->db->from("pay_salary_sheet");
			$this->db->where_in('pay_salary_sheet.emp_id', $emp_id_cash);
			$this->db->where('pay_salary_sheet.att_bonus !=', 0);
			$this->db->like("salary_month", $salary_month);
			$query = $this->db->get();
			//echo $this->db->last_query();
			$row = $query->row();
			$att_bonus_man_cash = $row->att_bonus_man;
			if($att_bonus_man_cash ==''){$att_bonus_man_cash = 0;}

			$all_data["att_bonus_man_total"]= $att_bonus_man_bank + $att_bonus_man_cash;
			//================================================

			//For Cash net_pay
			$column_name = "net_pay";
			$all_data["cash_sum_net_pay"]= $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			//For Bank net_pay
			$all_data["bank_sum_net_pay"]= $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);

			if(!empty($staff_id)){
				$all_data["bank_sum_net_pay"] = $all_data["bank_sum_net_pay"] - $all_data["bank_sum_ot_amount"];
			}else{
				$all_data["bank_sum_net_pay"]= $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			}

			$all_data["t_net_pay"] = $all_data["cash_sum_net_pay"] + $all_data["bank_sum_net_pay"];
			//For Cash ot_amount
			$column_name = "ot_amount";
			$ot_amount_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$cash_total = $cash_total + $ot_amount_cash;
			$all_data["cash_ot_amount"] = $ot_amount_cash;

			//For Bank ot_amount
			$ot_amount_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$bank_total = $bank_total + $ot_amount_bank;
			$all_data["bank_ot_amount"] = $ot_amount_bank;

			//==============This is for Festival Bonus=====================

			//For Cash ot_amount
			$column_name = "festival_bonus" ;
			$festival_bonus_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$all_data["festival_bonus_cash"] = $festival_bonus_cash;

			//For Bank ot_amount
			$festival_bonus_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$all_data["festival_bonus_bank"] = $festival_bonus_bank;

			$all_data["t_festival_bonus"] = $all_data["festival_bonus_cash"] + $all_data["festival_bonus_bank"];


			//For Cash eot_hour
			$column_name = "eot_hour" ;
			$eot_hour_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_eot_hour"] = $eot_hour_cash;

			//For Bank eot_amount
			$eot_hour_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_eot_hour"] = $eot_hour_bank;

			$total_cash_bank_eot_hour = $eot_hour_cash + $eot_hour_bank;
			$all_data["total_cash_bank_eot_hour"] = $total_cash_bank_eot_hour;

			//For Cash eot_amount
			$column_name = "eot_amount" ;
			$eot_amount_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_eot_amount"] = $eot_amount_cash;

			//For Bank eot_amount
			$eot_amount_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_eot_amount"] = $eot_amount_bank;

			$total_cash_bank_eot_amount = $eot_amount_cash + $eot_amount_cash;
			$all_data["total_cash_bank_eot_amount"] = $total_cash_bank_eot_amount;

			//=================Total Cash Salary calculation===============
			$all_data["cash_total"] = $cash_total;
			//=================Total Bank Salary calculation===============
			$all_data["bank_total"] = $bank_total;
			//=================Total Cash & Bank Salary calculation=========
			$total_cash_and_bank = $cash_total + $bank_total;
			$all_data["total_cash_and_bank"] = $total_cash_and_bank;

			//For Cash adv_deduct
			$column_name = "adv_deduct" ;
			$adv_deduct_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $adv_deduct_cash;
			$all_data["adv_deduct_cash"] = $adv_deduct_cash;

			//For Cash deduct_hour
			$column_name = "deduct_hour" ;
			$deduct_hour_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduct_hour = $deduct_hour_cash;
			$all_data["deduct_hour_cash"][] = $deduct_hour_cash;

			$deduct_hour_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduct_hour = $deduct_hour_bank;
			$all_data["deduct_hour_bank"][] = $deduct_hour_bank;

			$all_data["t_deduct_hour"][] = $total_cash_deduct_hour + $total_bank_deduct_hour;

			//For Bank adv_deduct
			$adv_deduct_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $adv_deduct_bank;
			$all_data["adv_deduct_bank"] = $adv_deduct_bank;

			//For Cash abs_deduction
			$column_name = "abs_deduction" ;
			$abs_deduction_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $abs_deduction_cash;
			$all_data["abs_deduction_cash"] = $abs_deduction_cash;

			//For Bank abs_deduction
			$abs_deduction_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $abs_deduction_bank;
			$all_data["abs_deduction_bank"] = $abs_deduction_bank;

			//For Cash late_deduct
			$column_name = "late_deduct";
			$late_deduct_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $late_deduct_cash;
			$all_data["late_deduct_cash"] = $late_deduct_cash;

			//For Bank abs_deduction
			$late_deduct_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $late_deduct_bank;
			$all_data["late_deduct_bank"] = $late_deduct_bank;

			//For Cash late_deduct
			$column_name = "others_deduct" ;
			$others_deduct_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $others_deduct_cash;
			$all_data["others_deduct_cash"] = $others_deduct_cash;

			//For Bank late_deduct
			$others_deduct_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $others_deduct_bank;
			$all_data["others_deduct_bank"] = $others_deduct_bank;

			//For Cash late_deduct
			$column_name = "tax_deduct" ;
			$tax_deduct_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);
			$total_cash_deduction = $total_cash_deduction + $tax_deduct_cash;
			$all_data["tax_deduct_cash"] = $tax_deduct_cash;

			//For Bank late_deduct
			$tax_deduct_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $tax_deduct_bank;
			$all_data["tax_deduct_bank"] = $tax_deduct_bank;

			//For Cash stamp
			$column_name = "stamp" ;
			$stam_deduct_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			$total_cash_deduction = $total_cash_deduction + $stam_deduct_cash;
			$all_data["stam_deduct_cash"] = $stam_deduct_cash;

			//For Bank stamp
			$stam_deduct_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $stam_deduct_bank;
			$all_data["stam_deduct_bank"] = $stam_deduct_bank;

			$all_data["tstamp_deduct"] = $stam_deduct_cash + $stam_deduct_bank;
			//For Total Deduct Cash
			$column_name = "total_deduct";
			$total_deduct_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			$all_data["total_deduct_cash"] = $total_deduct_cash;

			//For Total Deduct Bank
			$total_deduct_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$all_data["total_deduct_bank"] = $total_deduct_bank;

			$all_data["total_deduct"] = $total_deduct_cash + $total_deduct_bank;

			$all_data["tdeduct_without_stm"] = $all_data["total_deduct"] - $all_data["tstamp_deduct"];

			//For Cash due_pay_add
			$column_name = "due_pay_add" ;
			$due_pay_add_cash = $this->get_sum_column_for_salary($column_name,$emp_id_cash,$salary_month);

			$total_cash_deduction = $total_cash_deduction + $due_pay_add_cash;
			$all_data["due_pay_add_cash"] = $due_pay_add_cash;

			//For Bank due_pay_add
			$due_pay_add_bank = $this->get_sum_column_for_salary($column_name,$emp_id_bank,$salary_month);
			$total_bank_deduction = $total_bank_deduction + $due_pay_add_bank;
			$all_data["due_pay_add_bank"] = $due_pay_add_bank;

			$all_due_pay_add = $due_pay_add_cash + $due_pay_add_bank;

			$all_data["all_due_pay_add"] = $all_due_pay_add;

			$all_data["sub_total_cash_deduction"]= $total_cash_deduction;
			$all_data["sub_total_bank_deduction"] = $total_bank_deduction;
			$all_data["sub_total_cash_bank_deduction"] = $total_cash_deduction + $total_bank_deduction;

			// $net_wages = $all_data['tgross'] - $abs_deduction_cash - $abs_deduction_bank;

			$all_data['t_payable_amt'] = $all_data['tgross'] - $all_data["tdeduct_without_stm"];

			$total_sum =  $net_wages + $all_data["t_bonus"] + $all_data["tot_amt"] + $all_due_pay_add;

			$t_payablesalary_amt = $total_sum - ($adv_deduct_cash + $adv_deduct_bank);
			// $t_payablesalary_amt = $all_data["t_net_pay"] - ($all_data["tot_amt"] + $all_data["t_bonus"]);

			// $all_data["t_payable_amt"] = $t_payablesalary_amt;

			// $all_data["t_payable_amt_without_stm"] = $t_payablesalary_amt - ($all_data["stam_deduct_cash"] + $all_data["stam_deduct_bank"]);
			$all_data["t_payable_amt_without_stm"] = $all_data['t_payable_amt']+$all_data["t_bonus"] + $all_data["tot_amt"] + $all_due_pay_add - $all_data["tstamp_deduct"];

			$total_net_pay_with_stamp = $t_payablesalary_amt;
			// $total_net_pay_with_stamp = $all_data["cash_sum_net_pay"] + $all_data["bank_sum_net_pay"] + $all_data["stam_deduct_cash"] + $all_data["stam_deduct_bank"];

			$all_data["total_net_pay_with_stamp"] = $total_net_pay_with_stamp;

			//Total Cash after deduction calculation
			$total_cash_after_deduct = $cash_total - $total_cash_deduction;
			$all_data["total_cash_after_deduct"] = $total_cash_after_deduct;
			//Total Cash after deduction calculation
			$total_bank_after_deduct = $bank_total - $total_bank_deduction;
			$all_data["total_bank_after_deduct"] = $total_bank_after_deduct;
			//Total Cash+Bank calculation
			$sub_total = $total_cash_after_deduct + $total_bank_after_deduct;
			$all_data["sub_total"] = $sub_total;

			/*echo "<pre>";
			print_r($all_data);exit;*/

			return $all_data;
	}



	function count_empid_for_salary_floor_wise($all_emp_FSL,$status,$salary_draw,$stop_salary,$salary_month,$check)
	 {
		$this->db->select('pay_salary_sheet.*');
		$this->db->from('pay_salary_sheet');
		$this->db->where_in('pay_salary_sheet.emp_id',$all_emp_FSL);
		$this->db->where('pay_salary_sheet.salary_draw',$salary_draw);
		$this->db->where('pay_salary_sheet.salary_month',$salary_month);
		$this->db->where('pay_salary_sheet.emp_status !=',6);

		if($status !="ALL")
		{
			$this->db->where("pay_salary_sheet.emp_status", $status);
		}
		/*if($stop_salary !="Select")
		{
			$this->db->where("pay_salary_sheet.stop_salary", $stop_salary);
		}*/

		$query = $this->db->get();
		//echo $this->db->last_query();
		if($check == "count")
		{
			return $query->num_rows();
		}
		return $query->result();

	 }

	 function count_staff_id($emp_id)
	 {
	 	$staff_id = array();
		$this->db->select("emp_id");
		$this->db->from("staff_ot_list_emp");
		$this->db->where_in("emp_id", $emp_id);
		$query_staff = $this->db->get();
		// echo $this->db->last_query();
		foreach($query_staff->result() as $staff_row)
		{
			$staff_id[] = $staff_row->emp_id;
		}
		return $staff_id;

	 }

	 function get_sum_column_for_salary($column_name,$emp_id,$salary_month)
	 {
	 	$this->db->select_sum($column_name);
		$this->db->from("pay_salary_sheet");
		$this->db->where_in('pay_salary_sheet.emp_id', $emp_id);
		$this->db->like("salary_month", $salary_month);
		$query = $this->db->get();
		// echo $this->db->last_query();
		$row = $query->row();
		$result = $row->$column_name;

			if($result =='')
			{
				$result = 0;
			}

		return $result;

	 }

	//========================End Salary Summary=================
	function eot_summary_report_sec($salary_month,$emp_stat,$grid_unit,$stop_salary)
	{

		$all_data = array();

		$salary_month = $salary_month;

		$salary_month = $salary_month;
		$this->db->select("sec_id,sec_name_en");
		$this->db->where("unit_id",$grid_unit);
		$this->db->order_by("sec_name_en");
		$query = $this->db->get("emp_section");

		foreach($query->result() as $rows)
		{
			//echo "<tr>";
			//$emp_stat = array('2','3','4','6');
			$data = array();
			$data1 = array();

			//echo "<td>";
			//echo $rows->dept_name;
			//echo "</td>";
			$all_data["dept"][] = $rows->sec_name_en;
			$dept_id = $rows->sec_id;

			// For Cash Man Power
			$salary_draw_cash = 1;
			$emp_cash = $this->count_empid_for_sec_salary($dept_id,$emp_stat,$salary_month,$salary_draw_cash,$stop_salary,"count");
			$all_data["emp_cash"][] = $emp_cash;

			// For Bank Man Power
			$salary_draw_bank = 2;
			$emp_bank = $this->count_empid_for_sec_salary($dept_id,$emp_stat,$salary_month,$salary_draw_bank,$stop_salary,"count");
			$all_data["emp_bank"][] = $emp_bank;

			$all_data["emp_cash_bank"][] =$emp_cash + $emp_bank;

			// For Cash Emp ID
			$cash_emp_id = $this->count_empid_for_sec_salary($dept_id,$emp_stat,$salary_month,$salary_draw_cash,$stop_salary,"emp_id");
			foreach($cash_emp_id as $rows)
			{
				$data[] = $rows->emp_id;
			}
			$data = implode("xxx",$data);
			$emp_id_cash = explode('xxx', trim($data));

			// For Bank Emp ID
			$bank_emp_id = $this->count_empid_for_sec_salary($dept_id,$emp_stat,$salary_month,$salary_draw_bank,$stop_salary,"emp_id");
			foreach($bank_emp_id as $rows)
			{
				$data1[] = $rows->emp_id;
			}
			$data1 = implode("xxx",$data1);
			$emp_id_bank = explode('xxx', trim($data1));


			//For Cash gross_sal
			$column_name = "gross_sal" ;
			$gross_sal_cash = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_sum"][] = $gross_sal_cash;

			//For Bank gross_sal
			//print_r($emp_id_bank);
			$gross_sal_bank = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_sum"][] = $gross_sal_bank;

			$all_data["gross_cash_bank"][] = $gross_sal_cash + $gross_sal_bank;;

			//For Cash EOT HOUR
			$column_name = "eot_hour" ;
			$cash_eot_hour = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			//$cash_total = $eot_hour;
			$all_data["eot_cash_sum"][] = $cash_eot_hour;

			//For Bank EOT HOUR
			$bank_eot_hour = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			//$bank_total = $eot_hour;
			$all_data["eot_bank_sum"][] = $bank_eot_hour;

			$all_data["eot_cash_bank_hour"][] = $cash_eot_hour + $bank_eot_hour;

			//For Cash EOT_SA HOUR
			$column_name = "eot_hr_for_sa" ;
			$cash_eot_hr_for_sa = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			//$cash_total = $eot_hour;
			$all_data["eot_hr_for_sa_cash_sum"][] = $cash_eot_hr_for_sa;

			//For Bank EOT_SA HOUR
			$bank_eot_hr_for_sa = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			//$bank_total = $eot_hour;
			$all_data["eot_hr_for_sa_bank_sum"][] = $bank_eot_hr_for_sa;

			$all_data["eot_hr_for_sa_cash_bank"][] = $cash_eot_hr_for_sa + $bank_eot_hr_for_sa;

			//For Cash EOT AMOUNT
			$column_name = "eot_amount" ;
			$cash_eot_amount = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			//$cash_total = $eot_hour;
			$all_data["eot_amount_cash_sum"][] = $cash_eot_amount;

			//For Bank EOT AMOUNT
			$bank_eot_amount = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			//$bank_total = $eot_hour;
			$all_data["eot_amount_bank_sum"][] = $bank_eot_amount;

			$all_data["eot_cash_bank_amount"][] = $cash_eot_amount + $bank_eot_amount;

			//For Cash EOT_SA AMOUNT
			$column_name = "eot_amt_for_sa" ;
			$cash_eot_amt_for_sa = $this->get_sum_column($column_name,$emp_id_cash,$salary_month);
			//$cash_total = $eot_hour;
			$all_data["eot_amt_for_sa_cash_sum"][] = $cash_eot_amt_for_sa;

			//For Bank EOT_SA AMOUNT
			$bank_eot_amt_for_sa = $this->get_sum_column($column_name,$emp_id_bank,$salary_month);
			//$bank_total = $eot_hour;
			$all_data["eot_amt_for_sa_bank_sum"][] = $bank_eot_amt_for_sa;

			$all_data["eot_amt_for_sa_cash_bank"][] = $cash_eot_amt_for_sa + $bank_eot_amt_for_sa;
		}
		return $all_data;

	}
	 function count_empid_for_salary($section_id,$status,$salary_month,$salary_draw,$stop_salary,$check)
	 {
		// dd($status);
		//echo $sal_year_month = "$salary_month-01";
		$this->db->select('pr_emp_per_info.emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pay_salary_sheet');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_per_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where('pr_emp_com_info.salary_draw',$salary_draw);
		$this->db->where("pay_salary_sheet.salary_month = '$salary_month'");
		//if($section_id !="Select")
		//{
			$this->db->where("pay_salary_sheet.line_id", $section_id);
		//}

		if($status !="ALL" )
		{
			//dd($status);
			$this->db->where("pr_emp_com_info.emp_cat_id", $status);
		}
		if($stop_salary !="Select" )
		{
			$this->db->where("pay_salary_sheet.stop_salary", $stop_salary);
		}

		$query = $this->db->get();
		// dd( $this->db->last_query());
		if($check == "count")
		{
			// //$query->result();
			// //dd($this->db->last_query());
			//return $query->result();
			return $query->num_rows();
		}
		return $query->result();
	 }

	function count_empid_for_sec_salary($line_id,$status,$salary_month,$salary_draw,$stop_salary,$check)
	 {
		//echo $sal_year_month = "$salary_month-01";
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pay_salary_sheet');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_per_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where('pr_emp_com_info.salary_draw',$salary_draw);
		$this->db->where("pay_salary_sheet.salary_month = '$salary_month'");
		//if($section_id !="Select")
		//{
			$this->db->where("pay_salary_sheet.sec_id", $line_id);//HERE $line Id veriable Is actually section id
		//}

		if($status !="ALL" && $status != null)
		{
			//dd($status);
			$this->db->where("pay_salary_sheet.emp_status", $status);
		}
		if($stop_salary !="Select" )
		{
			$this->db->where("pay_salary_sheet.stop_salary", $stop_salary);
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		if($check == "count")
		{
			//$query->result();
			//dd($this->db->last_query());
			return $query->num_rows();
		}
		return $query->result();
	 }

	function get_sum_column($column_name,$emp_id,$salary_month)
	{

		$this->db->select_sum($column_name);
		$this->db->from("pay_salary_sheet");
		$this->db->where_in('pay_salary_sheet.emp_id', $emp_id);
		$this->db->like("salary_month", $salary_month);
		$query = $this->db->get();
		//echo $this->db->last_query();
		$row = $query->row();
		$result = $row->$column_name;

			if($result =='')
			{
				$result = 0;
			}
		return $result;
	}


	function festival_bonus_summary($salary_month,$emp_stat,$grid_unit){

		// dd($grid_unit);
		$all_data = array();

		$salary_month = $salary_month;

		$salary_month = $salary_month;
		$this->db->select("id,line_name_en,line_name_bn");
		$this->db->where("unit_id",$grid_unit);
		$this->db->where("id !=",2);
		$this->db->order_by("line_name_bn");
		$query = $this->db->get("emp_line_num");

		foreach($query->result() as $rows){
			$data = array();
			$data1 = array();
			$all_data["line_name_en"][] = $rows->line_name_en;
			$line_id = $rows->id;
			// For Cash Man Power
			$salary_draw_cash = 1;
			$emp_cash = $this->count_empid_for_festival($line_id,$emp_stat,$salary_month,$salary_draw_cash,"count");
			$all_data["emp_cash"][] = $emp_cash;

			// For Bank Man Power
			$salary_draw_bank = 2;
			$emp_bank = $this->count_empid_for_festival($line_id,$emp_stat,$salary_month,$salary_draw_bank,"count");
			$all_data["emp_bank"][] = $emp_bank;

			$all_data["emp_cash_bank"][] =$emp_cash + $emp_bank;

			// For Cash Emp ID
			$cash_emp_id = $this->count_empid_for_festival($line_id,$emp_stat,$salary_month,$salary_draw_cash,"emp_id");
			foreach($cash_emp_id as $rows)
			{
				$data[] = $rows->emp_id;
			}
			$data = implode("xxx",$data);
			$emp_id_cash = explode('xxx', trim($data));

			// For Bank Emp ID
			$bank_emp_id = $this->count_empid_for_festival($line_id,$emp_stat,$salary_month,$salary_draw_bank,"emp_id");
			foreach($bank_emp_id as $rows)
			{
				$data1[] = $rows->emp_id;
			}
			$data1 = implode("xxx",$data1);
			$emp_id_bank = explode('xxx', trim($data1));


			//For Cash gross_sal
			$column_name = "gross_sal" ;
			$gross_sal_cash = $this->get_sum_column_from_festival($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_sum"][] = $gross_sal_cash;

			//For Bank gross_sal
			//print_r($emp_id_bank);
			$gross_sal_bank = $this->get_sum_column_from_festival($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_sum"][] = $gross_sal_bank;

			$all_data["gross_cash_bank"][] = $gross_sal_cash + $gross_sal_bank;;

			//For Cash EOT HOUR
			$column_name = "bonus_amount" ;
			$cash_bonus_amount = $this->get_sum_column_from_festival($column_name,$emp_id_cash,$salary_month);
			//$cash_total = $eot_hour;
			$all_data["cash_bonus_sum"][] = $cash_bonus_amount;

			//For Bank EOT HOUR
			$bank_bonus_amount = $this->get_sum_column_from_festival($column_name,$emp_id_bank,$salary_month);
			//$bank_total = $eot_hour;
			$all_data["bank_bonus_sum"][] = $bank_bonus_amount;

			$all_data["bonus_amount_cash_bank"][] = $cash_bonus_amount + $bank_bonus_amount;

		}
		return $all_data;

	}

	function festival_bonus_summary_sec_wise($salary_month,$emp_stat,$grid_unit){
		$all_data = array();
		$salary_month = $salary_month;
		$salary_month = $salary_month;
		$this->db->select("id,sec_name_en");
		$this->db->where("unit_id",$grid_unit);
		$this->db->order_by("sec_name_en");
		$query = $this->db->get("emp_section");

		foreach($query->result() as $rows)
		{

			$data = array();
			$data1 = array();

			$all_data["sec_name_en"][] = $rows->sec_name_en;
			$sec_id = $rows->id;

			// For Cash Man Power
			$salary_draw_cash = 1;
			$emp_cash = $this->count_empid_for_festival_sec($sec_id,$emp_stat,$salary_month,$salary_draw_cash,"count");
			$all_data["emp_cash"][] = $emp_cash;

			// For Bank Man Power
			$salary_draw_bank = 2;
			$emp_bank = $this->count_empid_for_festival_sec($sec_id,$emp_stat,$salary_month,$salary_draw_bank,"count");
			$all_data["emp_bank"][] = $emp_bank;

			$all_data["emp_cash_bank"][] =$emp_cash + $emp_bank;

			// For Cash Emp ID
			$cash_emp_id = $this->count_empid_for_festival_sec($sec_id,$emp_stat,$salary_month,$salary_draw_cash,"emp_id");
			foreach($cash_emp_id as $rows)
			{
				$data[] = $rows->emp_id;
			}
			$data = implode("xxx",$data);
			$emp_id_cash = explode('xxx', trim($data));

			// For Bank Emp ID
			$bank_emp_id = $this->count_empid_for_festival_sec($sec_id,$emp_stat,$salary_month,$salary_draw_bank,"emp_id");
			foreach($bank_emp_id as $rows)
			{
				$data1[] = $rows->emp_id;
			}
			$data1 = implode("xxx",$data1);
			$emp_id_bank = explode('xxx', trim($data1));


			//For Cash gross_sal
			$column_name = "gross_sal" ;
			$gross_sal_cash = $this->get_sum_column_from_festival($column_name,$emp_id_cash,$salary_month);
			$all_data["cash_sum"][] = $gross_sal_cash;

			//For Bank gross_sal
			//print_r($emp_id_bank);
			$gross_sal_bank = $this->get_sum_column_from_festival($column_name,$emp_id_bank,$salary_month);
			$all_data["bank_sum"][] = $gross_sal_bank;

			$all_data["gross_cash_bank"][] = $gross_sal_cash + $gross_sal_bank;;

			//For Cash EOT HOUR
			$column_name = "bonus_amount" ;
			$cash_bonus_amount = $this->get_sum_column_from_festival($column_name,$emp_id_cash,$salary_month);
			//$cash_total = $eot_hour;
			$all_data["cash_bonus_sum"][] = $cash_bonus_amount;

			//For Bank EOT HOUR
			$bank_bonus_amount = $this->get_sum_column_from_festival($column_name,$emp_id_bank,$salary_month);
			//$bank_total = $eot_hour;
			$all_data["bank_bonus_sum"][] = $bank_bonus_amount;

			$all_data["bonus_amount_cash_bank"][] = $cash_bonus_amount + $bank_bonus_amount;

		}
		return $all_data;

	}

	 function count_empid_for_festival($line_id,$status,$salary_month,$salary_draw,$check)
	 {
		//echo $sal_year_month = "$salary_month-01";
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_festival_bonus_sheet');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_per_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_festival_bonus_sheet.emp_id');
		$this->db->where('pr_emp_com_info.salary_draw',$salary_draw);
		$this->db->where("pr_festival_bonus_sheet.effective_month = '$salary_month'");
		//if($section_id !="Select")
		//{
			$this->db->where("pr_festival_bonus_sheet.line_id", $line_id);
		//}

		if($status !="ALL" )
		{
			$this->db->where("pr_festival_bonus_sheet.emp_status", $status);
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		if($check == "count")
		{
			return $query->num_rows();
		}
		return $query->result();
	 }

	 function count_empid_for_festival_sec($sec_id,$status,$salary_month,$salary_draw,$check)
	 {
		//echo $sal_year_month = "$salary_month-01";
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_festival_bonus_sheet');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_per_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_festival_bonus_sheet.emp_id');
		$this->db->where('pr_emp_com_info.salary_draw',$salary_draw);
		$this->db->where("pr_festival_bonus_sheet.effective_month = '$salary_month'");
		//if($section_id !="Select")
		//{
			$this->db->where("pr_festival_bonus_sheet.sec_id", $sec_id);
		//}

		if($status !="ALL" )
		{
			$this->db->where("pr_festival_bonus_sheet.emp_status", $status);
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		if($check == "count")
		{
			return $query->num_rows();
		}
		return $query->result();
	 }

	 function get_sum_column_from_festival($column_name,$emp_id,$salary_month)
	{

		$this->db->select_sum($column_name);
		$this->db->from("pr_festival_bonus_sheet");
		$this->db->where_in('pr_festival_bonus_sheet.emp_id', $emp_id);
		$this->db->like("effective_month", $salary_month);
		$query = $this->db->get();
		//echo $this->db->last_query();
		$row = $query->row();
		$result = $row->$column_name;

			if($result =='')
			{
				$result = 0;
			}

		return $result;
	}


	//========================End Salary Summary=================

	function prox($empid)
	{
		$this->db->select('proxi_id');
		$this->db->where('emp_id',$empid);
		$query = $this->db->get('pr_id_proxi');
		foreach ($query->result() as $rows)
		{
			return $rows->proxi_id;
		}
	}

	function all_reguler_emp($grid_emp_id)
	{
		$emp_cat_id = array( '0'=>1, '1'=>2, '2'=>3, '3'=>4, '4'=>5);

		$this->db->select('emp_id,id');
		$this->db->from('pr_emp_com_info');
		$this->db->where_in('emp_id', $grid_emp_id);
		$this->db->where_in('emp_cat_id', $emp_cat_id);
		$this->db->order_by("emp_id");
		$query = $this->db->get();
		return $query;
	}

	function grid_current_info($grid_emp_id)
	{

		$this->db->select('pr_emp_com_info.emp_id, pr_emp_per_info.name_en, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, emp_designation.desig_name,emp_designation.id,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal,pr_emp_per_info.emp_dob,pr_work_process.process');
		$this->db->from('pr_emp_com_info');

		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->join('pr_emp_per_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','LEFT');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','LEFT');
		$this->db->join('emp_depertment','emp_depertment.dept_id = pr_emp_com_info.emp_dept_id','LEFT');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','LEFT');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','LEFT');
		$this->db->join('pr_grade','pr_grade.gr_id = pr_emp_com_info.emp_sal_gra_id','LEFT');
		$this->db->join('pr_work_process','pr_work_process.id = pr_emp_com_info.work_process_id','LEFT');

		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $rows)
		{
			$data["emp_id"][] 		= $rows->emp_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["desig_name"][]	= $rows->desig_name;
			$data["desig_id"][]		= $rows->desig_id;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["line_name"][] 	= $rows->line_name;
			$data["process_name"][] = $rows->process;

		}

		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_general_info($grid_emp_id){
		// dd($grid_emp_id);
		// $data = array();

		$this->db->select('
				pr_emp_com_info.id,
				pr_emp_com_info.emp_id,
				pr_emp_com_info.emp_sal_gra_id,
				pr_emp_com_info.emp_join_date,
				pr_emp_com_info.gross_sal,
				pr_emp_per_info.name_bn,
				pr_emp_per_info.name_en,
				pr_emp_per_info.emp_dob,
				pr_emp_per_info.father_name,
				pr_emp_per_info.mother_name,
				pr_emp_per_info.personal_mobile,
				pr_emp_per_info.per_village,
				pr_emp_per_info.pre_village,
				pr_emp_per_info.gender,
				pr_emp_per_info.blood,
				pr_emp_per_info.nid_dob_id,
				pr_emp_per_info.spouse_name,
				pr_emp_per_info.img_source,
				pr_emp_per_info.signature,
				pr_emp_com_info.emp_join_date,
				emp_designation.desig_bangla,
				emp_designation.desig_name,
				emp_depertment.dept_bangla,
				emp_depertment.dept_name,
				emp_section.sec_name_bn,
				emp_section.sec_name_en,
				emp_line_num.line_name_bn,
				emp_line_num.line_name_en,
				per_dis.name_bn  as  per_dis_name_bn,
				per_upa.name_bn  as  per_upa_name_bn,
				per_post.name_bn as  per_post_name_bn,

				per_dis.name_en  as  per_dis_name_en,
				per_upa.name_en  as  per_upa_name_en,
				per_post.name_en as  per_post_name_en,

				pre_dis.name_bn  as  pre_dis_name_bn,
				pre_upa.name_bn  as  pre_upa_name_bn,
				pre_post.name_bn as  pre_post_name_bn,

				pre_dis.name_en  as  pre_dis_name_en,
				pre_upa.name_en  as  pre_upa_name_en,
				pre_post.name_en as  pre_post_name_en,

			');
			$this->db->from('pr_emp_per_info');
			$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->join('emp_districts as per_dis', 'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
			$this->db->join('emp_upazilas as per_upa', 'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
			$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');

			$this->db->join('emp_districts as pre_dis', 'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
			$this->db->join('emp_upazilas as pre_upa', 'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
			$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$query=$this->db->get()->result();


		if($query){
			return $query;
		}
		else{
			return "Requested list is empty";
		}
	}


	function ot_hour_search($grid_firstdate,$ot_hour,$grid_emp_id)
	{
		//print_r($grid_emp_id);exit;
		$query = $this->all_reguler_emp($grid_emp_id);
		$emp_id_arr = array();
		$data = array();
		foreach($query->result() as $row)
		{
			$this->db->select('pr_emp_shift_log.emp_id,SUM(pr_emp_shift_log.ot + pr_emp_shift_log.eot) as total');
			$this->db->from('pr_emp_shift_log');
			$this->db->where('pr_emp_shift_log.shift_log_date',$grid_firstdate);
			$this->db->where('pr_emp_shift_log.emp_id',$row->emp_id);
			$this->db->order_by('pr_emp_shift_log.emp_id','ASC');
			$query2 = $this->db->get();
			/*echo "<pre>";
			echo $this->db->last_query();*/
			foreach($query2->result() as $obj){
				if($ot_hour==$obj->total){
					$emp_id_arr[] = $obj->emp_id;
				}else{
					$emp_id_arr[] = 0;
				}
			}

		}
			$this->db->distinct();
		 	$this->db->select('pr_emp_shift_log.*,pr_emp_com_info.*,pr_emp_per_info.*,emp_designation.*');
			$this->db->from('pr_emp_shift_log');
			$this->db->from('pr_emp_com_info');
			$this->db->from('pr_emp_per_info');
			$this->db->from('emp_designation');
			$this->db->where_in('pr_emp_shift_log.emp_id',$emp_id_arr);
			$this->db->where('pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('emp_designation.id = pr_emp_com_info.emp_desi_id');
			$this->db->where('pr_emp_shift_log.shift_log_date',$grid_firstdate);
			$query3 = $this->db->get();

			foreach ($query3->result() as $obj){
				$data['emp_id'][] = $obj->emp_id;
				$data['emp_full_name'][] = $obj->emp_full_name;
				$data['doj'][] = $obj->emp_join_date;
				$data['desig_name'][] = $obj->desig_name;
				$data['in_time'][] = $obj->in_time;
				$data['out_time'][] = $obj->out_time;
				$data['ot_hour'][] = $obj->ot_hour;
				$data['extra_ot_hour'][] = $obj->extra_ot_hour;
				$data['emp_id_arr'] = $emp_id_arr;
			}
			// print_r($data);exit;
			if($data)
			{
				return $data;
			}
			else
			{
				return "Requested list is empty";
			}

	 }


	function grid_general_info_another_format($grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id,
						   pr_emp_per_info.name_en,
						   emp_depertment.dept_name,
						   emp_section.sec_name_en,
						   emp_line_num.line_name_en,
						   emp_designation.desig_name,
						   pr_emp_com_info.emp_join_date,
						   pr_grade.gr_name,
						   pr_emp_com_info.gross_sal,
						   pr_emp_per_info.emp_dob');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');

		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		return $query->result();

	}

	function grid_employee_information($grid_emp_id){
		$this->db->distinct();
		$this->db->select('
							pr_emp_com_info.id as com_id,
							pr_emp_com_info.emp_id,
							pr_emp_per_info.*,
							emp_depertment.dept_name,
							emp_section.sec_name_en,
							emp_section.sec_name_bn,
							emp_line_num.line_name_en,
							emp_line_num.line_name_bn,
							emp_designation.desig_name,
							emp_designation.desig_bangla,
							pr_emp_com_info.emp_join_date,
							pr_grade.gr_name,
							pr_grade.gr_salary,
							pr_emp_com_info.gross_sal,
							pr_emp_status.stat_type,
							pr_emp_per_info.per_village,
							per_dis.name_bn as per_dis_name_bn,
							per_upa.name_bn as per_upa_name_bn,
							per_post.name_bn as per_post_name_bn,
							pr_emp_per_info.per_village,
							pre_dis.name_bn as pre_dis_name_bn,
							pre_upa.name_bn as pre_upa_name_bn,
							pre_post.name_bn as pre_post_name_bn,
							pr_emp_resign_history.resign_date,
							pr_emp_left_history.left_date,
							DAY(pr_emp_resign_history.resign_date) as last_working_day,
							year(pr_emp_resign_history.resign_date) as resign_year,
						');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
		$this->db->join('pr_emp_left_history', 'pr_emp_per_info.emp_id = pr_emp_left_history.emp_id', 'left');
		$this->db->join('pr_emp_resign_history', 'pr_emp_per_info.emp_id = pr_emp_resign_history.emp_id', 'left');
		$this->db->join('pr_grade', 'pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id', 'left');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id', 'left');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('pr_emp_status', 'pr_emp_com_info.emp_cat_id = pr_emp_status.stat_id', 'left');
		$this->db->join('emp_districts as per_dis', 	'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as per_upa', 		'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');
		$this->db->join('emp_districts as pre_dis', 	'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as pre_upa', 		'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->order_by("pr_emp_com_info.emp_id");
		// $this->db->group_by("pr_emp_com_info.emp_id");
		$query = $this->db->get()->result();
		return $query;
	}

	function grid_employee_information2($grid_emp_id){
		// dd($grid_emp_id);
		$this->db->select('pr_emp_com_info.emp_id,
							pr_emp_per_info.*,
							pr_emp_per_info.emp_id as emp_id2,
							emp_depertment.dept_name,
							emp_section.sec_name_en,
							emp_section.sec_name_bn,
							emp_line_num.line_name_en,
							emp_line_num.line_name_bn,
							emp_designation.desig_name,
							emp_designation.desig_bangla,
							pr_emp_com_info.emp_join_date,
							pr_grade.gr_name,
							pr_emp_com_info.gross_sal,
							pr_emp_status.stat_type,

							pr_emp_per_info.per_village,
							per_dis.name_bn as per_dis_name_bn,
							per_upa.name_bn as per_upa_name_bn,
							per_post.name_bn as per_post_name_bn,

							pr_emp_per_info.per_village,
							pre_dis.name_bn as pre_dis_name_bn,
							pre_upa.name_bn as pre_upa_name_bn,
							pre_post.name_bn as pre_post_name_bn,
							pr_emp_left_history.left_date

							');
		$this->db->from('pr_emp_per_info');
		$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
		$this->db->join('pr_emp_left_history', 'pr_emp_per_info.emp_id = pr_emp_left_history.emp_id', 'left');
		$this->db->join('pr_grade', 'pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id', 'left');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id', 'left');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('pr_emp_status', 'pr_emp_com_info.emp_cat_id = pr_emp_status.stat_id', 'left');

		$this->db->join('emp_districts as per_dis', 	'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as per_upa', 		'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');
		$this->db->join('emp_districts as pre_dis', 	'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as pre_upa', 		'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
		$this->db->where_in('pr_emp_com_info.id', $grid_emp_id);
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get()->result();
		return $query;

	}
	function grid_service_book2($grid_emp_id){
		/*$this->db->select('pr_emp_com_info.emp_id, pr_emp_per_info.name_en, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, emp_designation.desig_name,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal, pr_emp_per_info.identificatiion_marks, pr_emp_per_info.national_brn_id, pr_emp_per_info.emp_fname, pr_emp_per_info.emp_mname, pr_emp_per_info.spouse_name, pr_emp_per_info.no_child, pr_emp_per_info. 	emp_dob');*/
		$this->db->select('pr_emp_edu.*,pr_emp_skill.*,pr_id_proxi.proxi_id,pr_emp_com_info.emp_id, pr_emp_per_info.name_en, emp_depertment.dept_name,emp_depertment.dept_bangla, emp_section.*, emp_line_num.line_name_en, emp_line_num.line_bangla,emp_designation.desig_name,emp_designation.desig_bangla,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal, pr_emp_per_info.spouse_name, pr_emp_per_info.no_child,pr_emp_per_info.bangla_nam,pr_emp_per_info.emp_fname, pr_emp_per_info.emp_mname,pr_emp_per_info.emp_dob,pr_emp_per_info.identificatiion_marks,pr_emp_per_info.national_brn_id,pr_emp_per_info.img_source,pr_emp_add.emp_pre_add,pr_emp_add.emp_par_add');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->from('pr_emp_add');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_skill');
			$this->db->from('pr_emp_edu');
			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_edu.emp_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();

	}

	function grid_service_benifit($grid_emp_id)
	{
		$this->db->select('pr_emp_edu.*,pr_emp_skill.*,pr_id_proxi.proxi_id,pr_emp_com_info.emp_id, pr_emp_per_info.name_en, emp_depertment.dept_name,emp_depertment.dept_bangla, emp_section.*, emp_line_num.line_name_en, emp_line_num.line_bangla,emp_designation.desig_name,emp_designation.desig_bangla,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal, pr_emp_per_info.spouse_name, pr_emp_per_info.no_child,pr_emp_per_info.bangla_nam,pr_emp_per_info.emp_fname, pr_emp_per_info.emp_mname,pr_emp_per_info.emp_dob,pr_emp_per_info.identificatiion_marks,pr_emp_per_info.national_brn_id,pr_emp_per_info.img_source,pr_emp_add.emp_pre_add,pr_emp_add.emp_par_add');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('emp_designation');
		$this->db->from('pr_emp_add');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_skill');
		$this->db->from('pr_emp_edu');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_edu.emp_id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		return $query = $this->db->get();

	}

/*
	function grid_join_letter($grid_emp_id)
	{
		//print_r($grid_emp_id);
		$this->db->select('pr_emp_com_info.emp_id, pr_emp_per_info.name_en, pr_emp_per_info.emp_fname,pr_emp_per_info.emp_mname,pr_religions.religion_name,pr_emp_sex.sex_name,pr_emp_blood_groups.blood_name,pr_emp_per_info.img_source,emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, emp_designation.desig_name, emp_designation.desig_bangla,pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal,pr_emp_per_info.emp_dob,pr_marrital_status.marrital_status_name,pr_emp_add.emp_pre_add,pr_emp_add.emp_par_add,pr_emp_status.stat_type');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');

			$this->db->from('pr_emp_blood_groups');

			$this->db->from('pr_religions');
			$this->db->from('pr_marrital_status');
			$this->db->from('pr_emp_sex');
			$this->db->from('pr_emp_add');
			$this->db->from('pr_emp_status');

			$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_per_info.emp_blood = pr_emp_blood_groups.blood_id');
		$this->db->where('pr_emp_per_info.emp_religion = pr_religions.religion_id');
		$this->db->where('pr_marrital_status.marrital_status_id = pr_emp_per_info.emp_marital_status');
		$this->db->where('pr_emp_sex.sex_id = pr_emp_per_info.emp_sex');
		$this->db->where('pr_emp_com_info.emp_cat_id = pr_emp_status.stat_id');



		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		//print_r($query) ;
		return $query->result();
		foreach($query->result() as $rows)
		{
			//$data = array();
			$data["emp_id"][] 		= $rows->emp_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["emp_fname"][] 	= $rows->emp_fname;
			$data["emp_mname"][] 	= $rows->emp_mname;
			$data["img_source"][] 	= $rows->img_source;
			$data["emp_dob"][] 		= $rows->emp_dob;
			$data["blood_name"][] 	= $rows->blood_name;
			$data["religion_name"][]= $rows->religion_name;
			$data["marrital_status"][]= $rows->marrital_status_name;
			$data["emp_sex"][]		= $rows->sex_name;

			$data["stat_type"][]	= $rows->stat_type;
			$data["emp_pre_add"][]	= $rows->emp_pre_add;
			$data["emp_par_add"][]	= $rows->emp_par_add;


			$data["desig_name"][]	= $rows->desig_name;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["line_name"][] 	= $rows->line_name;

			$data["doj"][] 			= $rows->emp_join_date;

			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["gr_name"][]		= $rows->gr_name;
		}

		//print_r($data);
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}

	}*/
	function grid_join_letter($grid_emp_id){
		$this->db->select('pr_emp_com_info.emp_id,
						   pr_emp_com_info.gross_sal,
						   pr_emp_per_info.name_en,
						   pr_emp_per_info.name_bn ,
						   pr_emp_per_info.father_name,
						   pr_emp_per_info.mother_name,
						   emp_designation.desig_name,
						   emp_designation.desig_bangla,
						   pr_emp_com_info.emp_join_date,
						   pr_emp_com_info.emp_sal_gra_id ,
						   emp_depertment.dept_name,
						   emp_section.sec_name_en,
						   emp_section.sec_name_en,
						   pr_id_proxi.proxi_id,
						   pr_emp_add.emp_pre_add,
						   pr_emp_add.emp_par_add'
						);
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_add');
		$this->db->or_where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_add.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";
		}else{
			return $query->result();
		}
	}

function grid_emp_job_application($grid_emp_id){
		// dd($grid_emp_id);
		$this->db->select('
		pr_emp_per_info.*,
		pr_emp_com_info.emp_join_date,

		emp_designation.desig_name,
		emp_designation.desig_bangla,
		emp_designation.desig_desc as desig_description,
		emp_depertment.dept_name,
		emp_depertment.dept_bangla,
		emp_section.sec_name_en,
		emp_section.sec_name_bn,
		emp_line_num.line_name_bn,
		emp_line_num.line_name_en,

		per_dis.name_bn as dis_name_bn,
		per_upa.name_bn as upa_name_bn,
		per_post.name_bn as post_name_bn,

		per_dis.name_en as dis_name_en,
		per_upa.name_en as upa_name_en,
		per_post.name_en as post_name_en,

		pre_dis.name_bn as pre_dis_name_bn,
		pre_upa.name_bn as pre_upa_name_bn,
		pre_post.name_bn as pre_post_name_bn,

		pre_dis.name_en as pre_dis_name_en,
		pre_upa.name_en as pre_upa_name_en,
		pre_post.name_en as pre_post_name_en,

		ref_dis.name_bn as ref_dis_name_bn,
		ref_upa.name_bn as ref_upa_name_bn,
		ref_post.name_bn as ref_post_name_bn,

		nomi_dis.name_bn as nomi_dis_name_bn,
		nomi_upa.name_bn as nomi_upa_name_bn,
		nomi_post.name_bn as nomi_post_name_bn,

		pr_emp_com_info.emp_sal_gra_id as grade,
		pr_emp_com_info.com_gross_sal as salary,

	');
	$this->db->from('pr_emp_per_info');
	$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
	$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
	$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
	$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
	$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
	// $this->db->join('pr_religions', 'pr_emp_per_info.emp_religion = pr_religions.religion_id');
	// $this->db->join('pr_emp_edu', 'pr_emp_com_info.emp_id = pr_emp_edu.emp_id');
	// $this->db->join('pr_emp_skill', 'pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
	// $this->db->join('pr_emp_blood_groups', 'pr_emp_per_info.emp_blood = pr_emp_blood_groups.blood_id');
	$this->db->join('emp_districts as per_dis', 'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
	$this->db->join('emp_upazilas as per_upa', 'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
	$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');
	$this->db->join('emp_districts as pre_dis', 'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
	$this->db->join('emp_upazilas as pre_upa', 'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
	$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
	$this->db->join('emp_districts as ref_dis', 'pr_emp_per_info.pre_district = ref_dis.id', 'LEFT');
	$this->db->join('emp_upazilas as ref_upa', 'pr_emp_per_info.pre_thana = ref_upa.id', 'LEFT');
	$this->db->join('emp_post_offices as ref_post', 'pr_emp_per_info.pre_post = ref_post.id', 'LEFT');
	$this->db->join('emp_districts as nomi_dis', 'pr_emp_per_info.pre_district = nomi_dis.id', 'LEFT');
	$this->db->join('emp_upazilas as nomi_upa', 'pr_emp_per_info.pre_thana = nomi_upa.id', 'LEFT');
	$this->db->join('emp_post_offices as nomi_post', 'pr_emp_per_info.pre_post = nomi_post.id', 'LEFT');
	$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
	// $this->db->order_by('pr_emp_com_info.emp_id');
	$query = $this->db->get();
		if($query->num_rows() == 0){
			return "Employee ID range does not exist!";
		} else {
			return $query->result();
		}
		// dd($query->result());
	}

	function grid_yearly_leave_register($first_date, $second_date, $grid_emp_id){
		$this->db->select('
			pr_emp_com_info.emp_id,
			pr_emp_com_info.id,
			pr_emp_per_info.name_en,
			pr_emp_per_info.name_bn,
			pr_emp_per_info.signature,
			emp_depertment.dept_name,
			emp_depertment.dept_bangla,
			emp_section.sec_name_en,
			emp_line_num.line_name_en,
			emp_designation.desig_name,
			emp_designation.desig_bangla,
			pr_emp_com_info.emp_join_date,
			company_infos.register
		');
		$this->db->from('pr_emp_per_info');
		$this->db->join('pr_emp_com_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->join('company_infos', 'pr_emp_com_info.unit_id = company_infos.unit_id');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get()->row();
		$data['emp_info']= $query;

		$id = $query->id;
		$emp_id = $query->emp_id;
		$data["leave_balance"]  = $this->db->select('lv_sl,lv_cl')->get('pr_leave')->row();
		$this->db->select("present_status,shift_log_date")->where('emp_id',$id);
		if( $first_date == '' && $second_date == ''){
			$this->db->where('shift_log_date >',$query->emp_join_date);
		}else if( !$first_date == '' && $second_date == ''){
			$this->db->where('shift_log_date >',date('Y-01-01',strtotime($first_date)));
			$this->db->where('shift_log_date <',date('Y-12-31',strtotime($first_date)));
		}else{
			$this->db->where('shift_log_date >',date('Y-01-01',strtotime($first_date)));
			$this->db->where('shift_log_date <',date('Y-m-d',strtotime($second_date)));
		}
		$office_days = $this->db->get('pr_emp_shift_log')->result();

		$yearlyStatus = array();
		foreach ($office_days as $entry) {
			$year = date('Y', strtotime($entry->shift_log_date));
			$status = $entry->present_status;
			if (!isset($yearlyStatus[$year])) {
				$yearlyStatus[$year] = array(
					'P' => 0,
					'A' => 0,
					'W' => 0,
					'H' => 0,
				);
			}
			if (isset($yearlyStatus[$year][$status])) {
				$yearlyStatus[$year][$status]++;
			}
		}
		$data['yearly_total_info'] = $yearlyStatus;
		// dd($data);
		if($data){
			return $data;
		} else{
			return "Requested list is empty";
		}
	}

	function get_yearly_attendance_information($emp_id,$years,$attendance_status){
		$this->db->select('*');
	    $this->db->where('emp_id',$emp_id);
	    $this->db->where('present_status',$attendance_status);
	    $this->db->like('shift_log_date',$years);
		$query = $this->db->get('pr_emp_shift_log');
		$total_attendance_info = $query->num_rows();
		return $total_attendance_info;
	}

	function get_yearly_leave_balance($leave_type)
	{
		$this->db->select('*');
		//$this->db->where("status_id", $emp_cat_id);
		$query_balance = $this->db->get('pr_leave');
		foreach ($query_balance->result() as $row) {

			$leave_balance = $row->$leave_type ;
		}
		return $leave_balance;
	}

	function get_yearly_leave_type($emp_id,$years,$leave_type)
	{
		$this->db->select('*');
	    $this->db->where('emp_id',$emp_id);
	    $this->db->where('leave_type',$leave_type);
	    $this->db->like('start_date',$years);

		$query = $this->db->get('pr_leave_trans');
		$total_leave = $query->num_rows();
		return $total_leave;
	}

	function grid_new_join_report($grid_firstdate, $grid_seconddate)
	{
		// print_r($grid_emp_id);exit;
		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,
						   pr_emp_com_info.ot_entitle,
						   pr_emp_com_info.att_bonus,
						   pr_emp_per_info.name_en,
						   pr_grade.gr_name,
						   emp_designation.desig_name,
						   pr_emp_com_info.emp_join_date,
						   emp_depertment.dept_name,
						   emp_section.sec_name_en,
						   emp_line_num.line_name_en,
						   pr_id_proxi.proxi_id,
						   pr_emp_shift.shift_name,
						   pr_emp_com_info.emp_cat_id,
						   pr_emp_com_info.gross_sal,
						   pr_emp_per_info.emp_dob'
		);
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_grade');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		// $this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_com_info.emp_join_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");

		//$this->db->order_by("emp_section.sec_name_en","ASC");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		// echo $this->db->last_query();exit;

		foreach($query->result() as $rows)
		{
			$data["emp_id"][] 		= $rows->emp_id;
			$data["emp_name"][] 	= $rows->name_en;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["desig_name"][]	= $rows->desig_name;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["line_name"][] 	= $rows->line_name_en;
			$data["gr_name"][] 		= $rows->gr_name;
			$data["ot_entitle"][] 	= $rows->ot_entitle;
			$data["att_bonus"][] 	= $rows->att_bonus;
		}
		// dd($data);
		if($data){
			return $data;
		}
		else{
			return "Requested list is empty";
		}
	}
	////////////////
	function grid_bgm_new_join_report($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{
		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal,pr_emp_per_info.emp_dob');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_com_info.emp_join_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");

		//$this->db->order_by("emp_depertment.dept_name","ASC");
		//$this->db->order_by("emp_section.sec_name_en","ASC");
		//$this->db->order_by("emp_line_num.line_name_en","ASC");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $this->db->last_query();
		//$put = $query->result_array();
		//print_r($put);
		//echo $query->num_rows();
		foreach($query->result() as $rows)
		{
			$data["emp_id"][] 		= $rows->emp_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["desig_name"][]	= $rows->desig_name;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["line_name"][] 	= $rows->line_name;
		}

		//print_r($data);
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_resign_report($grid_firstdate, $grid_seconddate){
		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   pr_emp_com_info.emp_join_date,
						   emp_depertment.dept_name,
						   emp_section.sec_name_en,
						   emp_line_num.line_name_en,
						   pr_id_proxi.proxi_id,
						   pr_emp_shift.shift_name,
						   pr_emp_com_info.emp_cat_id,
						   pr_emp_com_info.gross_sal,
						   pr_emp_resign_history.resign_date as e_date,
						   pr_emp_add.emp_pre_add,
						   pr_emp_per_info.emp_dob');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_resign_history");
		$this->db->from("pr_emp_add");
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_resign_history.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_resign_history.resign_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		$this->db->order_by("emp_line_num.line_name_en","ASC");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $this->db->last_query();exit();
		foreach($query->result() as $rows){
			$data["emp_id"][] 		= $rows->emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_name"][] 	= $rows->name_en;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["add"][] 			= $rows->emp_pre_add;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["line_name"][] 	= $rows->line_name_en;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["e_date"][] 		= $rows->e_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
		}
        /* echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 exit(); */
		if($data){
			return $data;
		}
		else{
			return "Requested list is empty";
		}
	}
	function grid_bgm_resign_report($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{
		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_resign_history.resign_date as e_date, pr_emp_add.emp_pre_add,pr_emp_per_info.emp_dob');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_resign_history");
		$this->db->from("pr_emp_add");
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_resign_history.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_resign_history.resign_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $rows)
		{
			$data["emp_id"][] 		= $rows->emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["add"][] 			= $rows->emp_pre_add;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["line_name"][] 	= $rows->line_name;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["e_date"][] 		= $rows->e_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
		}

		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_resign_report_with_sal($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{

		$data = array();

		$this->db->select('pr_emp_com_info.emp_id, pr_emp_resign_history.resign_date');
		$this->db->from('pr_emp_com_info');
		$this->db->from("pr_emp_resign_history");
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_resign_history.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_resign_history.resign_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		$this->db->order_by("pr_emp_com_info.emp_sec_id","ASC");
		$query = $this->db->get();

		foreach($query->result() as $row){

			$emp_id = $row->emp_id;
			$resign_date = $row->resign_date;
			$year  = substr($resign_date,0,4);
			$month = substr($resign_date,5,2);
			$resign_sal_month = date("Y-m-d", mktime(0, 0, 0, $month, 1, $year));

			$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_resign_history.resign_date as e_date, pr_emp_add.emp_pre_add,pr_emp_per_info.emp_dob,pay_salary_sheet.*');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_shift');
			$this->db->from("pr_emp_resign_history");
			$this->db->from("pr_emp_add");
			$this->db->from('pay_salary_sheet');
			$this->db->where("pr_emp_com_info.emp_id", $emp_id);
			$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
			$this->db->where("pr_emp_resign_history.emp_id = pr_emp_com_info.emp_id");
			$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet.emp_id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
			$this->db->where('pay_salary_sheet.emp_status =',4);
			$this->db->where("pay_salary_sheet.salary_month = '$resign_sal_month'");
			// $this->db->order_by("emp_section.sec_name_en","ASC");
			$this->db->order_by("pr_emp_com_info.emp_sec_id","ASC");
			$query = $this->db->get();

			//echo $this->db->last_query();exit();
			foreach($query->result() as $rows)
			{
				$data["emp_id"][] 		= $rows->emp_id;
				$data["proxi_id"][] 	= $rows->proxi_id;
				$data["emp_name"][] 	= $rows->emp_full_name;
				$data["doj"][] 			= $rows->emp_join_date;
				$data["add"][] 			= $rows->emp_pre_add;
				$data["dept_name"][] 	= $rows->dept_name;
				$data["sec_name_en"][] 	= $rows->sec_name_en;
				$data["desig_name"][] 	= $rows->desig_name;
				$data["line_name"][] 	= $rows->line_name;
				$data["pay_days"][] 	= $rows->pay_days;
				$data["gross_sal"][] 	= $rows->gross_sal;
				$data["e_date"][] 		= $rows->e_date;
				$data["emp_dob"][] 		= $rows->emp_dob;
				$data["abs_deduction"][] = $rows->abs_deduction;
				$data["att_bonus"][] = $rows->att_bonus;
				$data["ot_hour"][] = $rows->ot_hour;
				$data["eot_hour"][] = $rows->eot_hour;
				$data["ot_rate"][] = $rows->ot_rate;
				$data["ot_amount"][] = $rows->ot_amount;
				$data["eot_amount"][] = $rows->eot_amount;
				$data["due_pay_add"][] = $rows->due_pay_add;
				$data["adv_deduct"][] = $rows->adv_deduct;
				$data["salary_draw"][] = $rows->salary_draw;
				$data["stamp"][] = $rows->stamp;
				$data["ot_entitle"][] = $rows->ot_entitle;
			}
		}

        /* echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 exit(); */
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_left_report_with_sal($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{

		$data = array();

		$this->db->select('pr_emp_com_info.emp_id, pr_emp_left_history.left_date');
		$this->db->from('pr_emp_com_info');
		$this->db->from("pr_emp_left_history");
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_left_history.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_left_history.left_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		$this->db->order_by("pr_emp_com_info.emp_sec_id","ASC");
		$query = $this->db->get();

		foreach($query->result() as $row){

			$emp_id = $row->emp_id;
			$left_date = $row->left_date;
			$year  = substr($left_date,0,4);
			$month = substr($left_date,5,2);
			$left_sal_month = date("Y-m-d", mktime(0, 0, 0, $month, 1, $year));

		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_left_history.left_date as e_date, pr_emp_add.emp_pre_add,pr_emp_per_info.emp_dob,pay_salary_sheet.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_left_history");
		$this->db->from("pr_emp_add");
		$this->db->from('pay_salary_sheet');
		$this->db->where("pr_emp_com_info.emp_id", $emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_left_history.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where('pay_salary_sheet.emp_status =',3);
		$this->db->where("pay_salary_sheet.salary_month = '$left_sal_month'");
		$this->db->order_by("emp_line_num.line_name_en");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();

		//echo $this->db->last_query();exit();
		foreach($query->result() as $rows)
		{
			$data["emp_id"][] 		= $rows->emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["add"][] 			= $rows->emp_pre_add;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["line_name"][] 	= $rows->line_name;
			$data["pay_days"][] 	= $rows->pay_days;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["e_date"][] 		= $rows->e_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
			$data["abs_deduction"][] = $rows->abs_deduction;
			$data["att_bonus"][] = $rows->att_bonus;
			$data["ot_hour"][] = $rows->ot_hour;
			$data["eot_hour"][] = $rows->eot_hour;
			$data["ot_rate"][] = $rows->ot_rate;
			$data["ot_amount"][] = $rows->ot_amount;
			$data["eot_amount"][] = $rows->eot_amount;
			$data["due_pay_add"][] = $rows->due_pay_add;
			$data["adv_deduct"][] = $rows->adv_deduct;
			$data["salary_draw"][] = $rows->salary_draw;
			$data["stamp"][] = $rows->stamp;
			$data["ot_entitle"][] = $rows->ot_entitle;
		 }
	   }
        /* echo "<pre>";
		 print_r($data);
		 echo "</pre>";
		 exit(); */
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_left_report($grid_firstdate, $grid_seconddate, $grid_emp_id){
		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,
							pr_emp_per_info.name_en,
							emp_designation.desig_name,
							pr_emp_com_info.emp_join_date,
							emp_depertment.dept_name,
							emp_section.sec_name_en,
							emp_line_num.line_name_en,
							pr_id_proxi.proxi_id,
							pr_emp_shift.shift_name,
							pr_emp_com_info.emp_cat_id,
							pr_emp_com_info.gross_sal,
							pr_emp_left_history.left_date  as left_date ,
							pr_emp_add.emp_pre_add,
							pr_emp_per_info.emp_dob'
						);
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_left_history");
		$this->db->from("pr_emp_add");
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_left_history.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_left_history.left_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		// $this->db->order_by("emp_section.absent_report_index","ASC");
		// $this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $query->num_rows();

		foreach($query->result() as $rows)
		{
			$data["emp_id"][] 		= $rows->emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_name"][] 	= $rows->name_en;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["add"][] 			= $rows->emp_pre_add;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["line_name"][]	= $rows->line_name_en;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["e_date"][] 		= $rows->left_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
		}


		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_bgm_left_report($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{

		//echo "$grid_firstdate, $grid_seconddate";
		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_left_history.left_date  as left_date , pr_emp_add.emp_pre_add,pr_emp_per_info.emp_dob');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_left_history");
		$this->db->from("pr_emp_add");
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_left_history.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_left_history.left_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $query->num_rows();

		foreach($query->result() as $rows)
		{
			$data["emp_id"][] 		= $rows->emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["add"][] 			= $rows->emp_pre_add;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["line_name"][]	= $rows->line_name;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["e_date"][] 		= $rows->left_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
		}


		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}


	function grid_bgm_left_resign_report($grid_firstdate, $grid_seconddate, $unit_id)
	{

		$data = array();
		$this->db->select('emp_id');
		$this->db->from("pr_emp_left_history");
		$this->db->where("unit_id",$unit_id);
		$this->db->where("pr_emp_left_history.left_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		$this->db->order_by("pr_emp_left_history.emp_id","ASC");
		$query_left_emp = $this->db->get();
		$grid_left_emp = $query_left_emp->result_array();
		$it_left =  new RecursiveIteratorIterator(new RecursiveArrayIterator($grid_left_emp));
		$grid_left_emp = iterator_to_array($it_left, false);


		$this->db->select('emp_id');
		$this->db->from("pr_emp_resign_history");
		$this->db->where("unit_id",$unit_id);
		$this->db->where("pr_emp_resign_history.resign_date BETWEEN '$grid_firstdate' and '$grid_seconddate'");
		$this->db->order_by("pr_emp_resign_history.emp_id","ASC");
		$query_resign_emp = $this->db->get();
		$grid_resign_emp = $query_resign_emp->result_array();
		$it_resign =  new RecursiveIteratorIterator(new RecursiveArrayIterator($grid_resign_emp));
		$grid_resign_emp = iterator_to_array($it_resign, false);

		$grid_left_resign=array_merge($grid_left_emp,$grid_resign_emp);

		asort($grid_left_resign);

		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal,pr_emp_add.emp_pre_add,pr_emp_per_info.emp_dob,pr_emp_com_info.emp_cat_id');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_add");
		$this->db->where_in("pr_emp_com_info.emp_id",$grid_left_resign);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');

		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $query->num_rows();

		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;
			$emp_cat = $rows->emp_cat_id;
			//echo $emp_cat."<br></br>";
			if($emp_cat == '3')
			{
				$status = "Left";
				$eff_date = $this->db->where("emp_id",$emp_id)->get('pr_emp_left_history')->row()->left_date;
			}
			if($emp_cat == '4')
			{
				$status = "Resign";
				$eff_date = $this->db->where("emp_id",$emp_id)->get('pr_emp_resign_history')->row()->resign_date;
			}

			$data["emp_id"][] 		= $emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["add"][] 			= $rows->emp_pre_add;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["line_name"][]	= $rows->line_name;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["status"][] 		= $status;
			$data["e_date"][] 		= $eff_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
		}
		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}




	function grid_daily_eot($grid_firstdate, $grid_emp_id){
		$data = array();
			$this->db->distinct();
			$this->db->select("pr_emp_com_info.emp_id,emp_section.id");
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_section');
			$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			// $this->db->order_by("emp_section.sec_name_en");
			$this->db->order_by("pr_emp_com_info.emp_id","ASC");
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			if($query->num_rows() == 0)
			{
				return "Requested list is empty";
			}

			foreach($query->result() as $rows)
			{

			$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name,emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_add.emp_pre_add, pr_emp_shift_log.in_time, pr_emp_shift_log.out_time, pr_emp_shift_log.ot, pr_emp_shift_log.eot,pr_emp_shift_log.deduction_hour');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_designation');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('pr_id_proxi');
			$this->db->from('pr_emp_shift');
			$this->db->from("pr_emp_add");
			$this->db->from('pr_emp_shift_log');
			$this->db->where("pr_emp_com_info.emp_id", $rows->emp_id);
			$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
			$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
			$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
			$this->db->where("pr_emp_shift_log.shift_log_date", $grid_firstdate);
			$this->db->where("pr_emp_shift_log.eot !=", 0 );
			$this->db->order_by("pr_emp_com_info.emp_id","ASC");
			$query2 = $this->db->get();

			foreach($query2->result() as $rows){
				$gross_sal = $rows->gross_sal;
				$salary_structure 		= $this->common_model->salary_structure($gross_sal);
				$ot_rate = $salary_structure['ot_rate'];

				$ot_amount = $rows->ot_hour * $ot_rate;
				$ot_amount = round($ot_amount);
				$emp_id=$rows->emp_id;

				$data["emp_id"][] 		= $emp_id;
				$data["proxi_id"][] 	= $rows->proxi_id;
				$data["emp_name"][] 	= $rows->emp_full_name;
				$data["doj"][] 			= $rows->emp_join_date;
				$data["add"][] 			= $rows->emp_pre_add;
				$data["dept_name"][] 	= $rows->dept_name;
				$data["sec_name_en"][] 	= $rows->sec_name_en;
				$data["desig_name"][] 	= $rows->desig_name;
				$data["line_name"][]	= $rows->line_name;
				$data["gross_sal"][] 	= $rows->gross_sal;
				$data["emp_shift"][] 	= $rows->shift_name;
				$data["in_time"][] 		= $rows->in_time;
				$data["out_time"][] 	= $rows->out_time;
				$data["ot_hour"][]		= $rows->ot_hour;
				$data["extra_ot_hour"][]= $rows->extra_ot_hour;
				$data["deduction_hour"][]= $rows->deduction_hour;
				$final_eot = $rows->extra_ot_hour - $rows->deduction_hour;

				$eot_amount = $final_eot * $ot_rate;
				$eot_amount = round($eot_amount);

				$data["final_eot"][]		= $final_eot;
				$data["ot_rate"][]	= $ot_rate;
				$data["ot_amount"][]	= $ot_amount;
				$data["eot_amount"][]	= $eot_amount;
			   }

			}

			if($data){
				return $data;
			}else{
				return "Requested list is empty";
			}
	}

	function grid_daily_ot($grid_firstdate, $grid_emp_id)
	{
			$data = array();
			$this->db->distinct();
			$this->db->select("pr_emp_com_info.emp_id,emp_section.id");
			$this->db->from('pr_emp_com_info');
			$this->db->from('emp_section');
			$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			// $this->db->order_by("emp_section.sec_name_en","ASC");
			$this->db->order_by("pr_emp_com_info.emp_id","ASC");
			$query = $this->db->get();
			// echo $this->db->last_query();exit;
			if($query->num_rows() == 0)
			{
				return "Requested list is empty";
			}
			foreach($query->result() as $rows)
			{

		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_add.emp_pre_add, pr_emp_shift_log.in_time, pr_emp_shift_log.out_time, pr_emp_shift_log.ot, pr_emp_shift_log.eot');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_add");
		$this->db->from('pr_emp_shift_log');
		$this->db->where("pr_emp_com_info.emp_id", $rows->emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_shift_log.shift_log_date", $grid_firstdate);
		$this->db->where("pr_emp_shift_log.ot !=", 0 );
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $this->db->last_query();

		foreach($query->result() as $rows)
		{
			$gross_sal = $rows->gross_sal;
			$salary_structure 		= $this->common_model->salary_structure($gross_sal);
			$ot_rate = $salary_structure['ot_rate'];
			$total_ot_hour = $rows->ot_hour ; //+ $rows->extra_ot_hour , This is for Extra OT hour add in Daily ot.
			$ot_amount = $total_ot_hour * $ot_rate;
			$ot_amount = round($ot_amount);

			$emp_id = $rows->emp_id;
			$emp_shift = $this->emp_shift_check($emp_id, $grid_firstdate);
			$in_time = $rows->in_time;
			$in_time = $this->get_formated_in_time($emp_id, $in_time, $emp_shift);
			$out_time = $rows->out_time;
			$out_time = $this->get_formated_out_time($emp_id, $out_time, $emp_shift);

			$data["emp_id"][] 		= $rows->emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_name"][] 	= $rows->emp_full_name;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["add"][] 			= $rows->emp_pre_add;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["line_name"][]	= $rows->line_name;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["emp_shift"][] 	= $rows->shift_name;
			$data["in_time"][] 		= $in_time;
			$data["out_time"][] 	= $out_time;
			$data["ot_hour"][] 		= $total_ot_hour;
			$data["ot_rate"][]		= $ot_rate;
			$data["ot_amount"][]	= $ot_amount;
		  }
	    }

		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_daily_night_allowance_report($att_date, $grid_emp_id)
	{
		/*$this->db->select('ot_entitle,emp_id');
		$this->db->where_in("emp_id", $grid_emp_id);
		$query = $this->db->get("pr_emp_com_info");*/
		$data = array();
		$this->db->distinct();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,emp_designation.desig_name,emp_designation.id, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en,emp_section.id, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_com_info.ot_entitle, pr_emp_add.emp_pre_add, pr_emp_shift_log.in_time, pr_emp_shift_log.out_time, pr_emp_shift_log.ot, pr_emp_shift_log.eot,pr_emp_shift_log.night_allo');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_add");
		$this->db->from('pr_emp_shift_log');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_shift_log.shift_log_date", $att_date);
		$this->db->where("pr_emp_shift_log.night_allo !=", 0 );
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$this->db->order_by("emp_section.sec_name_en");
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $rows)
		{
			$night_val = $rows->night_allo;

			$data["emp_id"][] 					= $rows->emp_id;
			$data["proxi_id"][] 				= $rows->proxi_id;
			$data["emp_name"][] 				= $rows->emp_full_name;
			$data["doj"][] 						= $rows->emp_join_date;
			$data["add"][] 						= $rows->emp_pre_add;
			$data["dept_name"][] 				= $rows->dept_name;
			$data["sec_name_en"][] 				= $rows->sec_name_en;
			$data["sec_id"][] 					= $rows->sec_id;
			$data["desig_name"][] 				= $rows->desig_name;
			$data["line_name"][]				= $rows->line_name;
			$data["emp_shift"][] 				= $rows->shift_name;
			$data["out_time"][] 				= $rows->out_time;



			//==========================Night Allowance=================================================

			$night_allowance_rules = $this->get_night_allowance_rules($rows->desig_id);

			if($night_allowance_rules['msg'] == "OK" )
			{
					if($night_val==2){
					$night_allowance_rate = $this->db->where("rules_id",$night_allowance_rules['rules_id'])->get('pr_night_allowance_rules')->row()->night_allowance_2nd;
					$night_allowance = $night_allowance_rate;
				}else{
					$night_allowance_rate = $this->db->where("rules_id",$night_allowance_rules['rules_id'])->get('pr_night_allowance_rules')->row()->night_allowance;
					$night_allowance	 	= $night_allowance_rate;
				}
			}
			else
			{
				$night_allowance 		= 0;
				$night_allowance_rate  	= 0;
			}
			$data['night_allowance_rate'][] 	= $night_allowance_rate;
			$data['night_allowance'] []			= $night_allowance;

		}
		if($data)
		{

			return $data;
			//print_r($data);
		}
		else
		{
			return "Requested list is empty";
		}
	}
	function get_night_allowance_rules($desig_id)
	{
		$this->db->select('rules_id');
		$this->db->from('pr_night_allowance_level');
		$this->db->where("desig_id", $desig_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$data['rules_id'] = $row->rules_id;
			$data['msg'] = "OK";
		}
		else
		{
			$rules_id = 0;
			$data['msg'] = "NULL";
		}
		return $data;
	}

	function get_weekend_allowance_rules($desig_id)
	{
		$this->db->select('rules_id');
		$this->db->from('pr_weekend_allowance_level');
		$this->db->where("desig_id", $desig_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$data['rules_id'] = $row->rules_id;
			$data['msg'] = "OK";
		}
		else
		{
			$rules_id = 0;
			$data['msg'] = "NULL";
		}
		return $data;
	}

	function get_holiday_allowance_rules($desig_id)
	{
		$this->db->select('rules_id');
		$this->db->from('pr_holiday_allowance_level');
		$this->db->where("desig_id", $desig_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$data['rules_id'] = $row->rules_id;
			$data['msg'] = "OK";
		}
		else
		{
			$rules_id = 0;
			$data['msg'] = "NULL";
		}
		return $data;
	}




	function grid_daily_allowance_bills($att_date, $grid_emp_id)
	{
		/*$this->db->select('ot_entitle,emp_id');
		$this->db->where_in("emp_id", $grid_emp_id);
		$query = $this->db->get("pr_emp_com_info");*/
		$data = array();
		$this->db->distinct();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,emp_designation.desig_name,emp_designation.id, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en,emp_section.id, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_com_info.ot_entitle, pr_emp_add.emp_pre_add, pr_emp_shift_log.in_time, pr_emp_shift_log.out_time, pr_emp_shift_log.ot, pr_emp_shift_log.eot');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_add");
		$this->db->from('pr_emp_shift_log');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_shift_log.shift_log_date", $att_date);
		//$this->db->where("pr_emp_shift_log.ot !=", 0 );
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;
			$ot_entitle = $rows->ot_entitle;
			//$allowance_data = $this->get_allowance_data($emp_id,$ot_entitle,$att_date);
			$out_time = $rows->out_time;
			if($out_time == "00:00:00")
			{

				$out_time == "00:00:00";
			}
			else
			{
				$out_time = date("h:i:s A", strtotime($out_time));
			}

			$data["emp_id"][] 					= $emp_id;
			$data["proxi_id"][] 				= $rows->proxi_id;
			$data["emp_name"][] 				= $rows->emp_full_name;
			$data["doj"][] 						= $rows->emp_join_date;
			$data["add"][] 						= $rows->emp_pre_add;
			$data["dept_name"][] 				= $rows->dept_name;
			$data["sec_name_en"][] 				= $rows->sec_name_en;
			$data["sec_id"][] 					= $rows->sec_id;
			$data["desig_name"][] 				= $rows->desig_name;
			$data["line_name"][]				= $rows->line_name;
			$data["emp_shift"][] 				= $rows->shift_name;
			$data["out_time"][] 				= $out_time;



			//==========================Night Allowance=================================================
			//==========================================================================================

			$num_rows = $this->db->where("emp_id",$emp_id)->where("shift_log_date",$att_date)->get('pr_emp_shift_log')->num_rows();
			if($num_rows == 1)
			{
				$tiffin_count = $this->db->where("emp_id",$emp_id)->where("shift_log_date",$att_date)->get('pr_emp_shift_log')->row()->tiffin_allo;
				$tiffin_allowance_rules 	= $this->get_tiffin_allowance_rules_data();
				$tiffin_allowance 			= $tiffin_allowance_rules ['tiffin_amount'] * $tiffin_count;


				$night_count = $this->db->where("emp_id",$emp_id)->where("shift_log_date",$att_date)->get('pr_emp_shift_log')->row()->night_allo;
				$night_allowance_rules = $this->get_allowance_rules($rows->desig_id);

				if($night_allowance_rules['msg'] == "OK" )
				{
						$night_allowance = $this->db->where("rules_id",$night_allowance_rules['rules_id'])->get('pr_allowance_rules')->row()->night_allowance;
						$night_allowance = $night_allowance * $night_count;

				}
				else
				{
						$night_allowance 			= 0;
				}
			}
			else
			{
				$tiffin_allowance =0;
				$night_allowance =0;
			}

			$data["night_allowance_amount"][] 	=	$night_allowance ;
			$data["tiffin_amount"][]		 	=	$tiffin_allowance ;

		}
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_daily_weekend_allowance_sheet($att_date, $grid_emp_id)
	{
		$data = array();
		$this->db->distinct();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,emp_designation.desig_name,emp_designation.id, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en,emp_section.id, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_com_info.ot_entitle, pr_emp_add.emp_pre_add, pr_emp_shift_log.in_time, pr_emp_shift_log.out_time, pr_emp_shift_log.ot, pr_emp_shift_log.eot');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_add");
		$this->db->from('pr_emp_shift_log');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_shift_log.shift_log_date", $att_date);
		$this->db->where("pr_emp_shift_log.weekly_allo =", 1);
		$this->db->order_by("emp_section.sec_name_en","ASC");
		$query = $this->db->get();
		/*echo "<pre>";
		echo $this->db->last_query();exit;*/
		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;
			$ot_entitle = $rows->ot_entitle;
			$out_time = $rows->out_time;
			if($out_time == "00:00:00")
			{

				$out_time == "00:00:00";
			}
			else
			{
				$out_time = date("h:i:s A", strtotime($out_time));
			}

			$data["emp_id"][] 					= $emp_id;
			$data["proxi_id"][] 				= $rows->proxi_id;
			$data["emp_name"][] 				= $rows->emp_full_name;
			$data["doj"][] 						= $rows->emp_join_date;
			$data["add"][] 						= $rows->emp_pre_add;
			$data["dept_name"][] 				= $rows->dept_name;
			$data["sec_name_en"][] 				= $rows->sec_name_en;
			$data["sec_id"][] 					= $rows->sec_id;
			$data["desig_name"][] 				= $rows->desig_name;
			$data["line_name"][]				= $rows->line_name;
			$data["emp_shift"][] 				= $rows->shift_name;
			$data["out_time"][] 				= $out_time;

			$weekend_allowance_rules = $this->get_weekend_allowance_rules($rows->desig_id);

			if($weekend_allowance_rules['msg'] == "OK")
			{
					$weekend_allowance_rate = $this->db->where("rules_id",$weekend_allowance_rules['rules_id'])->get('pr_weekend_allowance_rules')->row()->allowance_amount;
					$weekend_allowance = $weekend_allowance_rate;
			}
			else
			{
				$weekend_allowance 		= 0;
			}
			$data["weekend_allowance_amount"][] 	=	$weekend_allowance;

		}
		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_daily_holiday_allowance_sheet($att_date, $grid_emp_id)
	{
		$data = array();
		$this->db->distinct();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,emp_designation.desig_name,emp_designation.id, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en,emp_section.id, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_com_info.ot_entitle, pr_emp_add.emp_pre_add, pr_emp_shift_log.in_time, pr_emp_shift_log.out_time, pr_emp_shift_log.ot, pr_emp_shift_log.eot');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from("pr_emp_add");
		$this->db->from('pr_emp_shift_log');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where("pr_emp_add.emp_id = pr_emp_com_info.emp_id");
		$this->db->where("pr_emp_shift_log.emp_id = pr_emp_com_info.emp_id");
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_shift_log.shift_log_date", $att_date);
		$this->db->where("pr_emp_shift_log.holiday_allowance =", 1);
		$this->db->order_by("emp_section.sec_name_en","ASC");
		$query = $this->db->get();

		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;
			$ot_entitle = $rows->ot_entitle;
			$out_time = $rows->out_time;
			if($out_time == "00:00:00")
			{

				$out_time == "00:00:00";
			}
			else
			{
				$out_time = date("h:i:s A", strtotime($out_time));
			}

			$data["emp_id"][] 					= $emp_id;
			$data["proxi_id"][] 				= $rows->proxi_id;
			$data["emp_name"][] 				= $rows->emp_full_name;
			$data["doj"][] 						= $rows->emp_join_date;
			$data["add"][] 						= $rows->emp_pre_add;
			$data["dept_name"][] 				= $rows->dept_name;
			$data["sec_name_en"][] 				= $rows->sec_name_en;
			$data["sec_id"][] 					= $rows->sec_id;
			$data["desig_name"][] 				= $rows->desig_name;
			$data["line_name"][]				= $rows->line_name;
			$data["emp_shift"][] 				= $rows->shift_name;
			$data["out_time"][] 				= $out_time;

			$holiday_allowance_rules = $this->get_holiday_allowance_rules($rows->desig_id);

			if($holiday_allowance_rules['msg'] == "OK")
			{
					$holiday_allowance_rate = $this->db->where("rules_id",$holiday_allowance_rules['rules_id'])->get('pr_holiday_allowance_rules')->row()->allowance_amount;
					$holiday_allowance = $holiday_allowance_rate;
			}
			else
			{
				$holiday_allowance 		= 0;
			}
			$data["holiday_allowance_amount"][] 	=	$holiday_allowance;

		}
		if($data)
		{
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}


	function get_allowance_rules($desig_id)
	{
		$this->db->select('rules_id');
		$this->db->from('pr_allowance_level');
		$this->db->where("desig_id", $desig_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$data['rules_id'] = $row->rules_id;
			$data['msg'] = "OK";
		}
		else
		{
			$rules_id = 0;
			$data['msg'] = "NULL";
		}

		return $data;
	}

	function get_tiffin_allowance_rules_data()
	{
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



	function grid_monthly_ot_register($grid_firstdate, $grid_emp_id)
	{
		$data = array();
		$search_year_month = substr($grid_firstdate,0,7);

		$first_day = date('Y-m-01', strtotime($grid_firstdate));
		$last_day = date('Y-m-t', strtotime($grid_firstdate));

		$this->db->select('
						   pr_emp_com_info.id,
						   pr_emp_com_info.emp_id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   pr_emp_com_info.emp_join_date,
						   emp_depertment.dept_name,
						   emp_section.sec_name_en,
						   emp_line_num.line_name_en,
						   pr_id_proxi.proxi_id,
						   pr_emp_shift.shift_name,
						   pr_emp_com_info.emp_cat_id,
						   pr_emp_com_info.gross_sal
						   ');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		// dd($query->result());

		foreach($query->result() as $rows){
			$emp_id = $rows->emp_id;
			$id = $rows->id;
			$gross_sal = $rows->gross_sal;
			$basic_sal_payable = ($gross_sal * 60 / 100);
			$basic_sal = round($basic_sal_payable);
			$ot_rate = $basic_sal * 2 / 208 ;
			$ot_rate = round($ot_rate,2);

			$this->db->select('SUM(ot) AS ot_hour');
			$this->db->where('emp_id', $emp_id);
			$this->db->where('shift_log_date between "'. $first_day .'" and "'. $last_day .'"');
			$this->db->having('SUM(ot) >', 0);
			$this->db->group_by('emp_id');
			$query = $this->db->get('pr_emp_shift_log');
			// dd($query->result());
			if($query->num_rows() > 0){
				$row = $query->row();
				$total_ot_hour = $row->ot_hour;// + $total_extra_ot_hour; //This is for extra OT hour add to the Monthly OT Register
				$total_ot_amount = round($total_ot_hour * $ot_rate);
				$data["emp_id"][] 			= $emp_id;
				$data["proxi_id"][] 		= $rows->proxi_id;
				$data["emp_name"][] 		= $rows->name_en;
				$data["doj"][] 				= $rows->emp_join_date;
				$data["dept_name"][] 		= $rows->dept_name;
				$data["sec_name_en"][] 		= $rows->sec_name_en;
				$data["desig_name"][] 		= $rows->desig_name;
				$data["line_name"][]		= $rows->line_name_en;
				$data["gross_sal"][] 		= $rows->gross_sal;
				$data["ot_rate"][]			= $ot_rate;
				$data["emp_shift"][] 		= $rows->shift_name;
				$data["total_ot_hour"][]	= $total_ot_hour;
				$data["total_ot_amount"][]	= $total_ot_amount;
			}
		}

		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_monthly_eot_register($grid_firstdate, $grid_emp_id){
		$data = array();
		$search_year_month = substr($grid_firstdate,0,7);

		$first_day = date('Y-m-01', strtotime($grid_firstdate));
		$last_day = date('Y-m-t', strtotime($grid_firstdate));

		$this->db->select('
						   pr_emp_com_info.id,
						   pr_emp_com_info.emp_id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   pr_emp_com_info.emp_join_date,
						   emp_depertment.dept_name,
						   emp_section.sec_name_en,
						   emp_line_num.line_name_en,
						   pr_id_proxi.proxi_id,
						   pr_emp_shift.shift_name,
						   pr_emp_com_info.emp_cat_id,
						   pr_emp_com_info.gross_sal
						   ');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();

		foreach($query->result() as $rows){
			$emp_id = $rows->emp_id;
			$id = $rows->id;
			$gross_sal = $rows->gross_sal;

			$basic_sal_payable = ($gross_sal * 60 / 100);
			$basic_sal = round($basic_sal_payable);
			$ot_rate = $basic_sal * 2 / 208 ;
			$ot_rate = round($ot_rate,2);

			$this->db->select('SUM(eot) AS eot_hour');
			$this->db->where('emp_id', $emp_id);
			$this->db->where('shift_log_date between "'. $first_day .'" and "'. $last_day .'"');
			$this->db->having('SUM(eot) >', 0);
			$this->db->group_by('emp_id');
			$query = $this->db->get('pr_emp_shift_log');
			if($query->num_rows() > 0){
				$row = $query->row();
				$total_eot_hour = $row->eot_hour;
				$total_eot_amount 			= round($total_eot_hour * $ot_rate);
				$data["emp_id"][] 			= $emp_id;
				$data["proxi_id"][] 		= $rows->proxi_id;
				$data["emp_name"][] 		= $rows->name_en;
				$data["doj"][] 				= $rows->emp_join_date;
				$data["dept_name"][] 		= $rows->dept_name;
				$data["sec_name"][] 		= $rows->sec_name_en;
				$data["desig_name"][] 		= $rows->desig_name;
				$data["line_name"][]		= $rows->line_name_en;
				$data["gross_sal"][] 		= $rows->gross_sal;
				$data["ot_rate"][]			= $ot_rate;
				$data["emp_shift"][] 		= $rows->shift_name;
				$data["total_eot_hour"][]	= $total_eot_hour;
				$data["total_eot_amount"][]	= $total_eot_amount;
			}
		}
		if($data){

			return $data;
		}
		else{
			return "Requested list is empty";
		}
	}

	function grid_monthly_allowance_register($grid_firstdate, $grid_emp_id)
	{
		$data = array();
		$search_date = substr($grid_firstdate,0,7);

		//echo $search_date;
		foreach($grid_emp_id as $emp_id)
		{
		//echo $emp_id;
		$first_tiffin_allo_amount = 0;
		$second_tiffin_allo_amount = 0;
		$night_allo_amount = 0;
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,  pr_emp_com_info.ot_entitle, emp_designation.desig_name, pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name, pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal, pr_emp_shift_log.shift_log_date');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->from('pr_emp_shift_log');
		$this->db->where("pr_emp_com_info.emp_id", $emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->where("pr_emp_shift_log.emp_id", $emp_id);
		$this->db->like("pr_emp_shift_log.shift_log_date",$search_date);
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$this->db->group_by("pr_emp_shift_log.shift_log_date");
		$query = $this->db->get();
		//echo $query->num_rows();
			if($query->num_rows() != 0)
			{
				foreach ($query->result() as $rows)
				{
					$att_date = $rows->shift_log_date;

					//echo $att_date."-**-";
					$emp_id = $rows->emp_id;
					$ot_entitle = $rows->ot_entitle;
					$allowance_data = $this->get_allowance_data($emp_id,$ot_entitle,$att_date);
					//print_r($allowance_data);
					$first_tiffin_allo_amount = $allowance_data["first_tiffin_allo_amount"] + $first_tiffin_allo_amount;
					$second_tiffin_allo_amount = $allowance_data["second_tiffin_allo_amount"] + $second_tiffin_allo_amount;
					$night_allo_amount = $allowance_data["night_allo_amount"] + $night_allo_amount;
				}
				//echo $emp_id."------".$first_tiffin_allo_amount." -**-";

				$data["emp_id"][] 					= $emp_id;
				$data["proxi_id"][] 				= $rows->proxi_id;
				$data["emp_name"][] 				= $rows->emp_full_name;
				$data["doj"][] 						= $rows->emp_join_date;
				$data["dept_name"][] 				= $rows->dept_name;
				$data["sec_name_en"][] 				= $rows->sec_name_en;
				$data["desig_name"][] 				= $rows->desig_name;
				$data["line_name"][]				= $rows->line_name;
				$data["emp_shift"][] 				= $rows->shift_name;
				$data["first_tiffin_allo_amount"][] = $first_tiffin_allo_amount;
				$data["second_tiffin_allo_amount"][] = $second_tiffin_allo_amount;
				$data["night_allo_amount"][] = $night_allo_amount;
			}
		}

		//print_r($data);
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}



	function grid_time_search_report()
	{
		$f_date = '2012-04-01';
		$s_date = '2012-04-10';
		$f_time = '07:00:00';
		$s_time = '22:30:00';
		$grid_emp_id = array('001414','001635','001744','001750','001773','002070','002090','002110','002113','002178');
		$data = array();
		$this->db->select();
		$this->db->where_in("emp_id", $grid_emp_id);
		$this->db->where("shift_log_date BETWEEN '$f_date' AND '$s_date'");
		$this->db->where("in_time BETWEEN '$f_time' AND '$s_time'");
		$query = $this->db->get('pr_emp_shift_log');
		foreach($query->result() as $rows)
		{
			$data['emp_id'][] =  $rows->emp_id;
			$data['time'][]   =  $rows->in_time;
		}

		$this->db->select();
		$this->db->where_in("emp_id", $grid_emp_id);
		$this->db->where("shift_log_date BETWEEN '$f_date' AND '$s_date'");
		$this->db->where("out_time BETWEEN '$f_time' AND '$s_time'");
		$query = $this->db->get('pr_emp_shift_log');
		foreach($query->result() as $rows)
		{
			$data['emp_id'][] = $rows->emp_id;
			$data['time'][]   = $rows->out_time;
		}

		print_r($data);
	}

	function GetDays($sStartDate, $sEndDate)
	{
       	$sStartDate = date("Y-m-d", strtotime($sStartDate));
		$sEndDate = date("Y-m-d", strtotime($sEndDate));

        // Start the variable off with the start date
    	$aDays[] = $sStartDate;

    	// Set a 'temp' variable, sCurrentDate, with
    	// the start date - before beginning the loop
    	$sCurrentDate = $sStartDate;

		// While the current date is less than the end date
    	while($sCurrentDate < $sEndDate)
		{
       		// Add a day to the current date
       		$sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

       		// Add this new day to the aDays array
        		$aDays[] = $sCurrentDate;
			//print_r($aDays);
     	}
     // Once the loop has finished, return the
     return $aDays;
   }

   //Daily OT hour calculation for Mothly Attendace Register
   function get_daily_total_ot_hour($emp_id, $ot_date)
   {
   		$this->db->select('ot,eot');
		$this->db->where('emp_id', $emp_id);
		$this->db->where('shift_log_date', $ot_date);
		//$this->db->where('ot_hour !=', 0);
		$query = $this->db->get('pr_emp_shift_log');
		//echo $this->db->last_query();
		foreach($query->result() as $row)
		{
			$ot_hour = $row->ot;
			$extra_ot_hour = $row->eot;
			return $total = $ot_hour;
		}
		// + $extra_ot_hour; This will add if you want to add extra OT to Monthly Attendance Register.

   }

   function get_daily_total_eot_hour($emp_id, $ot_date)
   {
   		$this->db->select('ot,eot');
		$this->db->where('emp_id', $emp_id);
		$this->db->where('shift_log_date', $ot_date);
		$query = $this->db->get('pr_emp_shift_log');
		foreach($query->result() as $row){
			$ot_hour = $row->ot;
			$extra_ot_hour = $row->eot;
			return $total = $extra_ot_hour;
		}
		// + $extra_ot_hour; This will add if you want to add extra OT to Monthly Attendance Register.

   }
   function get_leave_type($shift_log_date,$emp_id)
   {
   		$this->db->select('leave_type');
		$this->db->where('emp_id', $emp_id);
		$this->db->where('start_date', $shift_log_date);
		$query = $this->db->get('pr_leave_trans');
		$row = $query->row();
		$leave_type = $row->leave_type;
		return $leave_type;
   }

    function get_shift_out_time($id)
	{
		$this->db->select('*');
		$this->db->where("id",$id);
		$query = $this->db->get('pr_emp_shift_schedule');
		$rows = $query->row();
		$end_time = $rows->ot_start;
		return $end_time;
	}


   function get_allowance_data($emp_id,$ot_entitle,$att_date)
	{
			$data = array();
			if($ot_entitle == 1) //ot = 'No' for staff
			{
				$id = 1;
			}
			else
			{
				$id = 2;
			}

			$allowance_bills 				= $this->common_model->allowance_bills($id);
			$first_tiffin_allo_min 			= $allowance_bills['first_tiffin_allo_min'];
			$second_tiffin_allo_min 		= $allowance_bills['second_tiffin_allo_min'];
			$night_allo_min 				= $allowance_bills['night_allo_min'];
			$first_tiffin_allo_amount 		= $allowance_bills['first_tiffin_allo_amount'];
			$second_tiffin_allo_amount 		= $allowance_bills['second_tiffin_allo_amount'];
			$night_allo_amount 				= $allowance_bills['night_allo_amount'];

			$this->db->select('*');
			$this->db->where("shift_log_date",$att_date);
			$this->db->where("emp_id",$emp_id);
			$query1 = $this->db->get('pr_emp_shift_log');

			//echo $query1->num_rows();

			foreach ($query1->result() as $row)
			{
				$id = $row->id;
				$out_time = $row->out_time;
				//$out_time = "21:01:26";
				//echo "--------".$out_time;
				$shift_out_time = $this->get_shift_out_time($id);
			}



			if($out_time !="00:00:00")
			{
				$new_shift_out_time = date("h:i:s A", strtotime($shift_out_time));
				$date_shift_out_time = $att_date." ".$new_shift_out_time;
				//echo $new_shift_out_time;
				$first_shift_out_time=trim(substr($new_shift_out_time,9,2));

				$new_out_time = date("h:i:s A", strtotime($out_time));
				$first_out_time=trim(substr($new_out_time,9,2));

				if($first_shift_out_time == $first_out_time)
				{
					$date_out_time = $att_date." ".$new_out_time;

				}
				else
				{
					 $att_date_new = strtotime(date("Y-m-d", strtotime($att_date)) . " +1 day");
					 $newdate = date ( 'Y-m-d' , $att_date_new );
					 $date_out_time = $newdate." ".$new_out_time;
				}


				if(strtotime($date_shift_out_time) < strtotime($date_out_time))
				{
					$date1 = new DateTime($date_out_time);
					$date2 = new DateTime($date_shift_out_time);
					$interval = $date1->diff($date2);
					$hour =  $interval->h;
					$min =  $interval->i;
					//$ss =  $interval->s;
					$total_min = ($hour * 60) + $min;
					//$total_min = 0;
					if($night_allo_min <= $total_min)
					{
						echo "";
						//$tiffin_allo_amount =$tiffin_allo_amount*2;
					}
					else if($second_tiffin_allo_min <= $total_min)
					{
						//echo "2nd";
						$night_allo_amount = 0;
					}
					else if($first_tiffin_allo_min <= $total_min)
					{
						//echo "1st";
						$second_tiffin_allo_amount = 0;
						$night_allo_amount = 0;
					}
					else
					{
						$first_tiffin_allo_amount = 0;
						$second_tiffin_allo_amount = 0;
						$night_allo_amount = 0;
					}
					//echo $total_min."***".$ot_entitle."///////";
				}
				else
				{
					$first_tiffin_allo_amount = 0;
					$second_tiffin_allo_amount = 0;
					$night_allo_amount = 0;
				}
					//echo $emp_id."-----".$date_out_time."------".$date_shift_out_time."-----".$night_allo_amount."****";
			}
			else
			{
				$first_tiffin_allo_amount = 0;
				$second_tiffin_allo_amount = 0;
				$night_allo_amount = 0;
			}
			//echo $tiffin_allo_amount;
			$data['att_date'] = $att_date;
			$data['out_time'] = $out_time;
			$data['first_tiffin_allo_min'] = $first_tiffin_allo_min;
			$data['second_tiffin_allo_min'] = $second_tiffin_allo_min;
			$data['night_allo_min'] = $night_allo_min;
			$data['first_tiffin_allo_amount'] = $first_tiffin_allo_amount;
			$data['second_tiffin_allo_amount'] = $second_tiffin_allo_amount;
			$data['night_allo_amount'] = $night_allo_amount;
			return $data;
	}
	function get_dept_name($dept_id){
		$this->db->select("dept_name");
		$this->db->where("dept_id", $dept_id);
		$query = $this->db->get('emp_depertment');
		$dept_name = '';
		foreach($query->result() as $rows){
			$dept_name =  $rows->dept_name;
		}
		return $dept_name;
	}

	function get_section_name($section_id)
	{
		$this->db->select("sec_name_en");
		$this->db->where("id", $section_id);
		$query = $this->db->get('emp_section');
		$sec_name_en = '';
		foreach($query->result() as $rows)
		{
			$sec_name_en =  $rows->sec_name_en;
		}
		return $sec_name_en;
	}

	function get_line_name($line_id)
	{
		$this->db->select("line_name_en");
		$this->db->where("id", $line_id);
		$query = $this->db->get('emp_line_num');
		$line_name = '';
		if($query->num_rows() > 0){
		foreach($query->result() as $rows)
		{
			$line_name =  $rows->line_name_en;
		}
		return $line_name;
		}
		else{return 'N/A';}
	}

	function get_desig_name($desig_id)
	{
		$this->db->select("desig_name");
		$this->db->where("id", $desig_id);
		$query = $this->db->get('emp_designation');
		$desig_name = '';
		foreach($query->result() as $rows)
		{
			$desig_name =  $rows->desig_name;
		}
		return $desig_name;
	}

	function get_dept_name_bn($dept_id)
	{
		$this->db->select("dept_bangla");
		$this->db->where("dept_id", $dept_id);
		$query = $this->db->get('emp_depertment');
		$dept_bangla = '';
		foreach($query->result() as $rows)
		{
			$dept_bangla =  $rows->dept_bangla;
		}
		return $dept_bangla;
	}

	function get_section_name_bn($section_id)
	{
		$this->db->select("sec_name_en_bn");
		$this->db->where("id", $section_id);
		$query = $this->db->get('emp_section');
		foreach($query->result() as $rows)
		{
			$sec_name_en_bn =  $rows->sec_name_en_bn;
		}
		return $sec_name_en_bn;
	}

	function get_line_name_bn($line_id)
	{
		$this->db->select("line_bangla");
		$this->db->where("line_id", $line_id);
		$query = $this->db->get('emp_line_num');
		// if($query->num_rows() > 0){
		foreach($query->result() as $rows)
		{
			$line_bangla =  $rows->line_bangla;
		}
		return $line_bangla;
		// }
	}

	function get_desig_name_bn($desig_id)
	{
		$this->db->select("desig_bangla");
		$this->db->where("desig_id", $desig_id);
		$query = $this->db->get('emp_designation');
		foreach($query->result() as $rows)
		{
			$desig_bangla =  $rows->desig_bangla;
		}
		return $desig_bangla;
	}

	function grid_earn_leave_report($grid_emp_id){
		// dd($grid_emp_id);
		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,
						   pr_emp_per_info.name_en,
						   pr_emp_per_info.img_source,
						   pr_emp_per_info.signature,
						   emp_designation.desig_name,
						   pr_emp_com_info.emp_join_date,
						   emp_depertment.dept_name,
						   emp_section.sec_name_en,
						   emp_line_num.line_name_en,
						   pr_id_proxi.proxi_id,
						   pr_emp_shift.shift_name,
						   pr_emp_com_info.emp_cat_id,
						   pr_emp_com_info.gross_sal,
						   pr_earn_leave.el as old_earn_balance,
						   pr_earn_leave.earn_leave as current_earn_balance,
						   pr_earn_leave.earn_month as last_update');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id', 'left');
		$this->db->join('pr_id_proxi', 'pr_emp_com_info.emp_id = pr_id_proxi.emp_id', 'left');
		$this->db->join('pr_emp_shift', 'pr_emp_shift.id = pr_emp_com_info.emp_shift', 'left');
		$this->db->join('pr_earn_leave', 'pr_emp_com_info.emp_id = pr_earn_leave.emp_id', 'left');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		// $this->db->group_by('pr_emp_com_info.emp_id');
		$this->db->order_by('pr_emp_com_info.emp_id', 'ASC');

		$query = $this->db->get();


		// dd($query->result());

		foreach($query->result() as $rows){
			$emp_id = $rows->emp_id;
			$gross_sal = $rows->gross_sal;
			$data["emp_id"][] 				= $emp_id;
			$data["proxi_id"][] 			= $rows->proxi_id;
			$data["emp_name"][] 			= $rows->name_en;
			$data["doj"][] 					= $rows->emp_join_date;
			$data["dept_name"][] 			= $rows->dept_name;
			$data["sec_name"][] 			= $rows->sec_name_en;
			$data["desig_name"][] 			= $rows->desig_name;
			$data["line_name"][]			= $rows->line_name_en;
			$data["gross_sal"][] 			= $rows->gross_sal;
			$data["emp_shift"][] 			= $rows->shift_name;
			$data["old_earn_balance"][]		= $rows->old_earn_balance;
			$data["current_earn_balance"][] = $rows->current_earn_balance;
			$data["last_update"][] 			= $rows->last_update;
			$data["img_source"][] 			= $rows->img_source;
			$data["signature"][] 			= $rows->signature;


			$prev_month_info 		  = $this->get_prev_month_info($emp_id);
			// dd($prev_month_info->result());
			foreach($prev_month_info->result() as $rows){
				// dd($row);
				$data["total_days"][] = $rows->total_days;
				$data["net_pay"][]  = $rows->net_pay;
				$data["pay_wages"][]   = $rows->net_pay;
				$data["pay_days"][]   = $rows->pay_days;
			}

		}
		$current_year = date("Y");
		$start_date = "$current_year-01-01";
		$end_date = date("Y-m-d");
		// caculate number of days between dates
		$days = $this->get_days($start_date, $end_date);
		// calculate number of weekends
		$weekend = $this->common_model->get_setup_attributes(5);
		//echo $weekend;
		//$weekend = "Fri";
		$weekend_days = $this->get_weekend_days($weekend,$days,$start_date);
		// calculate number of holyday between dates
		$holy_day = $this->get_holyday($start_date,$end_date);
		$actual_working_days = $days - $weekend_days - $holy_day;
		$data["actual_working_days"] = $actual_working_days;
		//print_r($data);
		if($data){
			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
	}

	function grid_pf_statement($year, $month, $grid_emp_id)
	{
		$data = array();
		$this->db->select('pr_emp_com_info.emp_id,pr_emp_per_info.name_en,emp_designation.desig_name,pr_emp_com_info.emp_join_date, emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en, pr_id_proxi.proxi_id, pr_emp_shift.shift_name,pr_emp_com_info.emp_cat_id, pr_emp_com_info.gross_sal');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('emp_designation');
		$this->db->from('emp_depertment');
		$this->db->from('emp_section');
		$this->db->from('emp_line_num');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_emp_shift');
		$this->db->where_in("pr_emp_com_info.emp_id", $grid_emp_id);
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
		$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
		$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
		$this->db->where('pr_emp_com_info.emp_id = pr_id_proxi.emp_id');
		$this->db->where('pr_emp_shift.id = pr_emp_com_info.emp_shift');
		$this->db->order_by("pr_emp_com_info.emp_id","ASC");
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $rows)
		{
			$emp_id = $rows->emp_id;
			$gross_sal = $rows->gross_sal;
			$data["emp_id"][] 		= $emp_id;
			$data["proxi_id"][] 	= $rows->proxi_id;
			$data["emp_full_name"][]= $rows->emp_full_name;
			$data["emp_join_date"][]= $rows->emp_join_date;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name_en"][] 	= $rows->sec_name_en;
			$data["desig_name"][] 	= $rows->desig_name;
			$data["line_name"][]	= $rows->line_name;
			$data["gross_sal"][] 	= $rows->gross_sal;
		}
		return $data;
	}

	function get_days($from, $to)
	{
		$first_date = strtotime($from);
    	$second_date = strtotime($to);
   		$offset = $second_date-$first_date;
    	return floor($offset/60/60/24);
	}

	function get_weekend_days($weekend,$days,$start_date)
	{
		$no_weekends = 0;
		for($i=0;$i<$days + 1;$i++)
		{
			$date =  strtotime(date("Y-m-d", strtotime($start_date)) . " +$i day");

			$new_date = date("D",$date);

			if($new_date == $weekend)
			{
				$no_weekends = $no_weekends +1;
			}
		}
		return $no_weekends;
	}

	function get_holyday($from, $to)
	{
		$where="holiday_date  BETWEEN '$from' and '$to'" ;
		$this->db->select('*');
		$this->db->where($where);
		$query=$this->db->get('pr_holiday');

		$num_holyday = $query->num_rows();
		return $num_holyday;

	}

	function get_prev_month_info($emp_id){
		$prev_month = date("2023-m", strtotime("-1 months"));
		$this->db->select("total_days,net_pay,pay_days");
		$this->db->where('emp_id',$emp_id);
		$this->db->like('salary_month',$prev_month);
		$query=$this->db->get('pay_salary_sheet');
		return $query;
	}



	function manual_attendance_sheet($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{
		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));

		$data = array();

		$this->db->select('emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where('emp_id', $grid_emp_id);
		$this->db->order_by("emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $row)
		{
			$emp_id = $row->emp_id;
			//echo "$emp_id<br>";

			$this->db->distinct();
			$this->db->select('pr_emp_per_info.name_en,emp_designation.desig_name,emp_depertment.dept_name,emp_section.sec_name_en,emp_line_num.line_name_en,pr_emp_com_info.emp_join_date,pr_id_proxi.proxi_id');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->from('pr_attn_monthly');
			$this->db->from('pr_id_proxi');
			$this->db->from('emp_depertment');
			$this->db->from('emp_section');
			$this->db->from('emp_line_num');
			$this->db->from('emp_designation');
			$this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
			$this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
			$this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
			$this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_id_proxi.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_per_info.emp_id', $emp_id);

			$query = $this->db->get();
			foreach($query->result() as $row)
			{
				$data["emp_id"] = $emp_id;

				$data["emp_full_name"] = $row->emp_full_name;

				$data["proxi_id"]= $row->proxi_id;

				$data["sec_name_en"] = $row->sec_name_en;

				$data["line_name"] = $row->line_name;

				$data["desig_name"] = $row->desig_name;

				$emp_join_date = $row->emp_join_date;
				$emp_join_date_year=trim(substr($emp_join_date,0,4));
				$emp_join_date_month=trim(substr($emp_join_date,5,2));
				$emp_join_date_day=trim(substr($emp_join_date,8,2));
				$emp_join_date = date("d-M-y", mktime(0, 0, 0, $emp_join_date_month, $emp_join_date_day, $emp_join_date_year));
				$data["emp_join_date"] = $emp_join_date;

				$data["dept_name"] = $row->dept_name;
			}

			$joining_check = $this->get_join_date($emp_id, $sStartDate, $sEndDate);
			if( $joining_check != false)
			{
				$start_date = $joining_check ;
			}
			else
			{
				$start_date = $sStartDate ;
			}

			$resign_check  = $this->get_resign_date($emp_id, $sStartDate, $sEndDate);
			if($resign_check != false)
			{
				$end_date = $resign_check ;
			}
			else
			{
				$end_date = $sEndDate ;
			}

			$left_check  = $this->get_left_date($emp_id, $sStartDate, $sEndDate);
			if($left_check != false)
			{
				$end_date = $left_check ;
			}
			else
			{
				$end_date = $sEndDate ;
			}


			$days = $this->GetDays($start_date, $end_date);

			foreach($days as $day)
			{

				$this->db->select('pr_emp_shift_log.in_time , pr_emp_shift_log.out_time, pr_emp_shift_log.shift_log_date, pr_emp_shift_log.ot, pr_emp_shift_log.eot');
				$this->db->from('pr_emp_shift_log');
				$this->db->where('pr_emp_shift_log.emp_id', $emp_id);
				$this->db->where("pr_emp_shift_log.shift_log_date", $day);
				$this->db->order_by("pr_emp_shift_log.shift_log_date");
				$this->db->limit(1);
				$query = $this->db->get();
				//echo $this->db->last_query();
				$num_query = $query->num_rows();
				if($num_query > 0)
				{


					foreach($query->result() as $row)
					{

						$in_time	= $row->in_time;
						$out_time	= $row->out_time;
						if($in_time !="00:00:00" && $out_time =="00:00:00")
						{
							$out_time = "P(Error)";
						}

						$data["shift_log_date"][] 	= $row->shift_log_date;
						$data["in_time"][] 			= $in_time;
						$data["out_time"][] 		= $out_time;

					}
				}
				else
				{



					$data["shift_log_date"][] 	= $day;
					$data["in_time"][] 			= "Null";
					$data["out_time"][] 		= "Null";
				}
			}
		}
		//print_r($data);
		return $data;

	}

	function manual_attendance_sheet_entry_db()
	{

		$count 		= $this->input->post('count');
		$emp_id 	= $this->input->post('emp_id');
		$proxi		= $this->input->post('proxi');

		for($i=0;$i<$count;$i++)
		{

			$intime_check = "True";
			$outtime_check = "True";

			$manual_date_name 	= "manual_date$i";
			$manual_date		= $this->input->post($manual_date_name);

			$manual_intime_name = "manual_intime$i";
			$manual_intime		= $this->input->post($manual_intime_name);

			$manual_outtime_name 	= "manual_outtime$i";
			$manual_outtime			= $this->input->post($manual_outtime_name);


			//echo "<br/>".$time = date("H:i:s", strtotime($manual_intime));

			if($manual_intime == "" && $manual_outtime == "")
			{
				continue;
			}

			if (preg_match("/[a-z]|[A-Z]|[a-z][A-Z]|[A-Z][a-z]/",$manual_intime))
			{
					$intime_check = "False";
			}
			if($manual_intime == "")
			{
				$intime_check = "False";
			}


			if (preg_match("/[a-z]|[A-Z]|[a-z][A-Z]|[A-Z][a-z]/",$manual_outtime))
			{
				$outtime_check = "False";
				//continue;
			}
			if($manual_outtime == "")
			{
				$outtime_check = "False";
			}




			$date_time_in = "$manual_date $manual_intime";
			$date_time_out = "$manual_date $manual_outtime";
			$table = "temp_$emp_id";

			$data['date_time'] 	= $date_time_in;
			$data['proxi_id'] 	= $proxi;
			$data['device_id'] 	= 1;

			if($intime_check != "False")
			{
			 	$this->db->insert($table,$data);
			}

			$data['date_time'] 	= $date_time_out;
			if($outtime_check != "False")
			{
				 $this->db->insert($table,$data);
			}
			//echo "$manual_date===$date_time====$manual_outtime</br>";

		}
	}

	function manual_eot_modification($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{
		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));

		$data = array();

		$this->db->select('emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where('emp_id', $grid_emp_id);
		$this->db->order_by("emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		foreach($query->result() as $row)
		{
			$emp_id = $row->emp_id;
			//echo "$emp_id<br>";

			$this->db->distinct();
			$this->db->select('pr_emp_per_info.name_en,emp_designation.desig_name,emp_depertment.dept_name,emp_section.sec_name_en,emp_line_num.line_name_en,pr_emp_com_info.emp_join_date,pr_id_proxi.proxi_id');
			$this->db->from('pr_emp_com_info');

			$this->db->join('pr_emp_per_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id','LEFT');
			$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','LEFT');
			$this->db->join('emp_depertment','emp_depertment.dept_id = pr_emp_com_info.emp_dept_id','LEFT');
			$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','LEFT');
			$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','LEFT');
			$this->db->join('pr_id_proxi','pr_id_proxi.emp_id = pr_emp_com_info.emp_id','LEFT');
			$this->db->where('pr_emp_com_info.emp_id', $emp_id);
			$query = $this->db->get();

			foreach($query->result() as $row)
			{
				$data["emp_id"] = $emp_id;

				$data["emp_full_name"] = $row->emp_full_name;

				$data["proxi_id"]= $row->proxi_id;

				$data["sec_name_en"] = $row->sec_name_en;

				$data["line_name"] = $row->line_name;

				$data["desig_name"] = $row->desig_name;

				$emp_join_date = $row->emp_join_date;
				$emp_join_date_year=trim(substr($emp_join_date,0,4));
				$emp_join_date_month=trim(substr($emp_join_date,5,2));
				$emp_join_date_day=trim(substr($emp_join_date,8,2));
				$emp_join_date = date("d-M-y", mktime(0, 0, 0, $emp_join_date_month, $emp_join_date_day, $emp_join_date_year));
				$data["emp_join_date"] = $emp_join_date;

				$data["dept_name"] = $row->dept_name;
			}

			$joining_check = $this->get_join_date($emp_id, $sStartDate, $sEndDate);
			if( $joining_check != false)
			{
				$start_date = $joining_check ;
			}
			else
			{
				$start_date = $sStartDate ;
			}

			$resign_check  = $this->get_resign_date($emp_id, $sStartDate, $sEndDate);
			if($resign_check != false)
			{
				$end_date = $resign_check ;
			}
			else
			{
				$end_date = $sEndDate ;
			}

			$left_check  = $this->get_left_date($emp_id, $sStartDate, $sEndDate);
			if($left_check != false)
			{
				$end_date = $left_check ;
			}
			else
			{
				$end_date = $sEndDate ;
			}


			$days = $this->GetDays($start_date, $end_date);

			foreach($days as $day)
			{
				$this->db->select('pr_emp_shift_log.in_time , pr_emp_shift_log.out_time, pr_emp_shift_log.shift_log_date, pr_emp_shift_log.ot, pr_emp_shift_log.eot,pr_emp_shift_log.present_status');
				$this->db->from('pr_emp_shift_log');
				$this->db->where('pr_emp_shift_log.emp_id', $emp_id);
				$this->db->where("pr_emp_shift_log.shift_log_date", $day);
				//$this->db->where("pr_emp_shift_log.in_time !=","00:00:00");
				$this->db->order_by("pr_emp_shift_log.shift_log_date");
				$this->db->limit(1);
				$query = $this->db->get();
				//echo $this->db->last_query();
				foreach($query->result() as $row)
				{

					$in_time	= $row->in_time;
					$out_time	= $row->out_time;
					if($in_time !="00:00:00" && $out_time =="00:00:00")
					{
						$out_time = "P(Error)";
					}


					$data["shift_log_date"][] 	= $row->shift_log_date;
					$data["in_time"][] 			= $in_time;
					$data["out_time"][] 		= $out_time;
					$data["ot_hour"][] 			= $row->ot_hour;
					$data["extra_ot_hour"][] 	= $row->extra_ot_hour;
					$data["present_status"][] 	= $row->present_status;
					// $data["modify_eot"][] 		= $row->modify_eot;

			}
		}
		//print_r($data);
		return $data;

	  }

	}

	function manual_eot_modify_entry_db(){

		$count 		= $this->input->post('count');
		$emp_id 	= $this->input->post('emp_id');
		$proxi		= $this->input->post('proxi');

		for($i=0;$i<$count;$i++){
			$manual_date_name 	= "manual_date$i";
			$manual_date		= $this->input->post($manual_date_name);

			$emp_shift = $this->emp_shift_check($emp_id, $manual_date);
			// echo $emp_shift;
			$schedule = $this->schedule_check($emp_shift);
			// print_r($schedule);
			$start_time		=  $schedule[0]["in_start"];
			$late_time 		=  $schedule[0]["late_start"];
			$end_time   	=  $schedule[0]["in_end"];
			$out_start_time	=  $schedule[0]["out_start"];
			$out_end_time	=  $schedule[0]["out_end"];

			$mod_in_time 	= "modify_in_time$i";
			$modify_in_time	= $this->input->post($mod_in_time);

			$mod_out_time 	= "modify_out_time$i";
			$modify_out_time = $this->input->post($mod_out_time);

			$present_status 	= "present_status$i";
			$modify_present_status = $this->input->post($present_status);

			$mod_ot_hour 	= "modify_ot_hour$i";
			$modify_ot_hour	= $this->input->post($mod_ot_hour);

			$mod_eot_hour 	= "modify_eot_hour$i";
			$modify_eot_hour = $this->input->post($mod_eot_hour);

			if($modify_out_time == ""){
				continue;
			}

				if($modify_in_time > $late_time and $modify_in_time !='')
				{
					$late_status = 1;
				}
				else
				{
					$late_status = 0;
				}

			$data= array(
				'in_time'		=> $modify_in_time,
				'out_time'		=> $modify_out_time,
				'ot_hour'		=> $modify_ot_hour,
				'extra_ot_hour'	=> $modify_eot_hour,
				'late_status'=> $late_status,
				'modify'	=> 1
			);

			echo "<pre>";
			print_r($data);
			exit;

			$this->db->where("emp_id",$emp_id);
			$this->db->where("shift_log_date",$manual_date);
			$this->db->update("pr_emp_shift_log",$data);

			$this->deduction_hour_process($emp_id,$manual_date);
		}
	}

	function ot_abstract_entry_db($grid_firstdate,$grid_emp_id,$in_time,$out_time,$ot_hour,$eot_hour,$orginal_in_time,$orginal_out_time,$orginal_ot,$orginal_eot){

		$grid_emp_id = explode(',', $grid_emp_id);
		//echo $grid_firstdate.'='.$out_time.'='.$ot_hour;exit;

		foreach($grid_emp_id as $emp_id){

			if($in_time==''){
				$orginal_in_time = $orginal_in_time;
			}else{
				$orginal_in_time = $in_time;

				$in_hour = substr($orginal_in_time,0,2);
				$in_min = substr($orginal_in_time,3,2);
				$in_sec = substr($orginal_in_time,6,2);

				if($in_min>=45){
					$in_rand_min=rand(45,$in_min);
					$in_rand_sec=rand(1,60);
				}else{
					$in_rand_min=rand(1,$in_min);
					$in_rand_sec=rand(1,60);
				}

				$orginal_in_time = $in_hour.':'.$in_rand_min.':'.$in_rand_sec;
				$orginal_in_time=date('H:i:s',strtotime($orginal_in_time));
			}
			if($out_time==''){
				$orginal_out_time = $orginal_out_time;
			}else{
				$orginal_out_time = $out_time;
				$out_hour = substr($orginal_out_time,0,2);
				$out_min = substr($orginal_out_time,3,2);
				$out_sec = substr($orginal_out_time,6,2);
				if($out_min>=45){
					$out_rand_min=rand(45,$out_min);
					$out_rand_sec=rand(1,60);
				}else{
					$out_rand_min=rand(1,$out_min);
					$out_rand_sec=rand(1,60);
				}


				$orginal_out_time = $out_hour.':'.$out_rand_min.':'.$out_rand_sec;
				$orginal_out_time=date('H:i:s',strtotime($orginal_out_time));

			}

			if($ot_hour==''){
				$orginal_ot = $orginal_ot;
			}else{
				$orginal_ot = $ot_hour;
			}
			if($eot_hour==''){
				$orginal_eot = $orginal_eot;
			}else{
				$orginal_eot = $eot_hour;
			}


			$data= array(
				'in_time'		=> $orginal_in_time,
				'out_time'		=> $orginal_out_time,
				'ot_hour'		=> $orginal_ot,
				'extra_ot_hour'	=> $orginal_eot,
				'modify'	=> 1
			);
			/*print_r($data);
			exit;*/
			$this->db->where("emp_id",$emp_id);
			$this->db->where("shift_log_date",$grid_firstdate);
			$this->db->update("pr_emp_shift_log",$data);

			$this->attn_process_model->deduction_hour_process($emp_id, $grid_firstdate);
		}
	}

	function manual_ot_eot_modification_for_multiple($grid_firstdate, $manual_eot_hour, $grid_emp_id)
	{


		foreach($grid_emp_id as $emp_id)
		{
			//echo $emp_id."===";
			$shift_log_date = date("Y-m-d", strtotime($grid_firstdate));
			$num_row = $this->db->where('emp_id',$emp_id)->where('shift_log_date',$shift_log_date)->get('pr_emp_shift_log')->num_rows();
			if($num_row < 1)
			{
				continue;
			}
			//$shift_log_date = date("Y-m-d", strtotime($grid_firstdate));

			$data['modify_eot'] = $manual_eot_hour;


			$this->db->where("emp_id",$emp_id);
			$this->db->where("shift_log_date",$shift_log_date);
			$this->db->update("pr_emp_shift_log",$data);
		}
		return;
	}

	function staff_id_collect($emp_id){
 		$staff_id = array();
		$this->db->select("emp_id");
		$this->db->from("staff_ot_list_emp");
		$this->db->where("emp_id", $emp_id);
		$query_staff = $this->db->get();
		// echo $this->db->last_query();
		foreach($query_staff->result() as $staff_row)
		{
			$staff_id[] = $staff_row->emp_id;
		}
		//print_r($staff_id);exit;
		if(in_array($emp_id,$staff_id))
		{
			return $staff = 1;
		}else{
			return $staff = 0;
		}
     }

     function deduction_hour_process($emp_id,$att_date)
	{
		$this->db->select('*');
		$this->db->where("shift_log_date",$att_date);
		$this->db->where("emp_id",$emp_id);
		$query = $this->db->get('pr_emp_shift_log');


		foreach ($query->result() as $row)
		{
			$emp_id = $row->emp_id;
			$ot_hour_actual = $row->ot_hour_actual;
			$extra_ot_hour_actual = $row->extra_ot_hour_actual;
			$ot_hour = $row->ot_hour;
			$extra_ot_hour = $row->extra_ot_hour;

			$tot_actual = $ot_hour_actual + $extra_ot_hour_actual;
			$tot_ot = $ot_hour + $extra_ot_hour;

			if($tot_actual!==0 && $tot_ot!==0){
				$deduct_hour = $tot_actual - $tot_ot;
			}else{
				$deduct_hour = 0;
			}

			$data = array(
				'deduct_hour' => $deduct_hour
			);

			$this->db->where("emp_id",$emp_id);
			$this->db->where("shift_log_date",$att_date);
			$this->db->update('pr_emp_shift_log', $data);
		}

	}

	function earn_leave_pay($year,$pay_date,$emp_ids,$unit_id){
		$query = $this->db->select('pr_earn_leave.emp_id,pr_earn_leave.earn_month,pr_earn_leave.gross_sal,pr_earn_leave.com_gross_sal, pr_earn_leave.basic_sal, pr_earn_leave.unit_id, pr_earn_leave.earn_leave')
			->from('pr_earn_leave')
			->join('pr_emp_com_info','pr_emp_com_info.emp_id = pr_earn_leave.emp_id','left')
			->where_in('pr_emp_com_info.id',$emp_ids)
			->where('pr_earn_leave.unit_id',$unit_id)
			->like('pr_earn_leave.earn_month', $year, 'both')
			->get()->result();

		if(empty($query)){
			return "Earn leave process not done";
		}else{
			$data_temp = [];
			foreach($query as $row) {
				$data_temp[$row->emp_id][$year][] = [
					'unit_id' => $row->unit_id,
					'emp_id' => $row->emp_id,
					'actual_gross_sal' => $row->gross_sal,
					'com_gross_sal' => $row->com_gross_sal,
					'actual_paid' => round(($row->gross_sal/30)*$row->earn_leave),
					'com_paid' => round(($row->com_gross_sal/30)*$row->earn_leave),
					'paid_leave' => $row->earn_leave,
					'year' => $year,
					'paid_date' => date('Y-m-d', strtotime($pay_date)),
				];
			}
			foreach($data_temp as $emp_id => $year_data) {
				foreach($year_data as $year => $data) {
					$this->db->where('emp_id', $emp_id)->where('year', $year)->from('pr_earn_leave_paid');
					$count = $this->db->count_all_results();
					if($count == 0) {
						$this->db->insert_batch('pr_earn_leave_paid', $data);
					} else {
						$this->db->where('emp_id', $emp_id)->where('year', $year);
						$this->db->update_batch('pr_earn_leave_paid', $data, 'year');
					}
				}
			}
			return $this->db->affected_rows() > 0 ? 'Updated earn leave pay successfully' : 'Already Paid '.$year;
		}
	}
	function earn_leave_list($year,$pay_date,$emp_ids,$unit_id){
		$query=$this->db->select('
				pr_earn_leave_paid.id,
				pr_earn_leave_paid.emp_id,
				pr_earn_leave_paid.actual_gross_sal,
				pr_earn_leave_paid.com_gross_sal,
				pr_earn_leave_paid.actual_paid,
				pr_earn_leave_paid.com_paid,
				pr_earn_leave_paid.paid_leave,
				pr_earn_leave_paid.year,
				pr_earn_leave_paid.paid_date,
				pr_emp_per_info.name_en,
				pr_emp_com_info.emp_join_date,
				pr_emp_per_info.name_en,
				emp_designation.desig_name,
				emp_depertment.dept_name,
				emp_section.sec_name_en,
				emp_line_num.line_name_en,
			')
			->from('pr_earn_leave_paid')
			->join('pr_emp_com_info','pr_emp_com_info.emp_id      = pr_earn_leave_paid.emp_id')
			->join('pr_emp_per_info','pr_emp_com_info.emp_id      = pr_emp_per_info.emp_id')
			->join('emp_designation','pr_emp_com_info.emp_desi_id = emp_designation.id')
			->join('emp_depertment' ,'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id')
			->join('emp_section'    ,'pr_emp_com_info.emp_sec_id  = emp_section.id')
			->join('emp_line_num'   ,'pr_emp_com_info.emp_line_id = emp_line_num.id')
			->where_in('pr_emp_com_info.id',$emp_ids)
			->where_in('pr_earn_leave_paid.year',$year)
			->get()->result();
			return $query;
		// $query = $this->db->select('pr_earn_leave_paid.*')->from('pr_earn_leave_paid')->get()->result();
	}



	function act_advance_salary_sheet($sal_year_month, $grid_status, $grid_emp_id){
		$year  = substr($sal_year_month,0,4);
		$month = substr($sal_year_month,5,2);
		$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));
		$lastday = date("Y-m-d", mktime(0, 0, 0, $month, $lastday, $year));
		$query = $this->db->select('
				pr_emp_com_info.emp_id,
				pr_emp_per_info.name_en,
				pr_emp_per_info.bank_bkash_no as mobile,
				emp_designation.desig_name,
				pr_emp_com_info.emp_join_date,
				pr_advance_loan.pay_amt,
				pr_advance_loan.emp_id,
				pr_emp_com_info.emp_join_date,
				emp_line_num.line_name_en,
				emp_section.sec_name_en,
			')
			->distinct()
			->from('pr_emp_per_info')
			->join('pr_emp_com_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id')
			->join('pr_advance_loan' ,'pr_advance_loan.emp_id    = pr_emp_com_info.emp_id')
			->join('emp_line_num'    ,'pr_emp_com_info.emp_line_id = emp_line_num.id')
			->join('emp_designation' ,'pr_emp_com_info.emp_desi_id = emp_designation.id')
			->join('emp_section'     ,'pr_emp_com_info.emp_sec_id = emp_section.id')

			->where_in('pr_emp_com_info.emp_id', $grid_emp_id)
			->where_in('pr_advance_loan.loan_status',array('1','2'))
			->where("pr_advance_loan.loan_date = '$sal_year_month'")
			->order_by("pr_emp_com_info.emp_id")
			->order_by("emp_designation.desig_name")
			// ->group_by("pr_advance_loan.emp_id")
			->get();
			if($query->num_rows() == 0){
				return "No Data Found";
			}
			// dd($query->result());
			return $query->result();
	}

	function service_book_info($grid_emp_id){
		// dd($grid_emp_id);
		$this->db->select('
							pr_emp_com_info.id as com_id,
							pr_emp_com_info.emp_id as empp_id,
							pr_emp_per_info.*,
							emp_depertment.dept_name,
							emp_section.sec_name_en,
							emp_section.sec_name_bn,
							emp_line_num.line_name_en,
							emp_line_num.line_name_bn,
							emp_designation.desig_name,
							emp_designation.desig_bangla,
							pr_emp_com_info.emp_join_date,
							pr_emp_shift.shift_name,
							pr_grade.gr_name,
							pr_grade.gr_salary,
							pr_emp_com_info.gross_sal,
							pr_emp_status.stat_type,
							pr_emp_per_info.per_village,
							per_dis.name_bn as per_dis_name_bn,
							per_upa.name_bn as per_upa_name_bn,
							per_post.name_bn as per_post_name_bn,
							pr_emp_per_info.pre_village,
							pre_dis.name_bn as pre_dis_name_bn,
							pre_upa.name_bn as pre_upa_name_bn,
							pre_post.name_bn as pre_post_name_bn,
							pr_emp_resign_history.resign_date,
							pr_emp_left_history.left_date,
							DAY(pr_emp_resign_history.resign_date) as last_working_day,
							year(pr_emp_resign_history.resign_date) as resign_year,
						');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_shift','pr_emp_shift.id = pr_emp_com_info.emp_shift', 'left');
		$this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
		$this->db->join('pr_emp_left_history', 'pr_emp_per_info.emp_id = pr_emp_left_history.emp_id', 'left');
		$this->db->join('pr_emp_resign_history', 'pr_emp_per_info.emp_id = pr_emp_resign_history.emp_id', 'left');
		$this->db->join('pr_grade', 'pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id', 'left');
		$this->db->join('emp_depertment', 'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section', 'pr_emp_com_info.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num', 'pr_emp_com_info.emp_line_id = emp_line_num.id', 'left');
		$this->db->join('emp_designation', 'pr_emp_com_info.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('pr_emp_status', 'pr_emp_com_info.emp_cat_id = pr_emp_status.stat_id', 'left');
		$this->db->join('emp_districts as per_dis', 	'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as per_upa', 		'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');
		$this->db->join('emp_districts as pre_dis', 	'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as pre_upa', 		'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->order_by("pr_emp_com_info.emp_id");
		// $this->db->group_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//dd($query->result());
		$data = array();
		// <!-- dd($query); -->foreach($query->result() as $rows)
		foreach($query->result() as $rows)
		{
			$data["emp_id"][] 		= $rows->emp_id;
			$data["emp_name"][] 	= $rows->name_en;
			$data["emp_fname"][] 	= $rows->father_name;
			$data["emp_mname"][] 	= $rows->mother_name;
			$data["religion_name"][] 	= $rows->religion;
			$data["marrital_status"][] 	= $rows->name_en;
			$data["marital_status"][] 	= $rows->marital_status;
			$data["blood_name"][] 	= $rows->blood;
			$data["img_source"][] 	= $rows->img_source;
			$data["dept_name"][] 	= $rows->dept_name;
			$data["sec_name"][] 	= $rows->sec_name_en;
			$data["line_name"][] 	= $rows->line_name_en;
			$data["emp_sex"][] 	    = $rows->emp_sex;
			$data["desig_name"][]	= $rows->desig_name;
			$data["doj"][] 			= $rows->emp_join_date;
			$data["emp_dob"][] 		= $rows->emp_dob;
			$data["emp_blood"][] 	= $rows->emp_blood;
			$data["gross_sal"][] 	= $rows->gross_sal;
			$data["gr_name"][]		= $rows->gr_name;
			$data["mobile"][]		= $rows->personal_mobile;
			$data["shift_name"][]	= $rows->shift_name;
			$data["emp_par_add"][]	= $rows->per_village." ".$rows->per_dis_name_bn." ".$rows->per_upa_name_bn." ".$rows->per_post_name_bn;
			$data["emp_pre_add"][]	= $rows->pre_village." ".$rows->pre_dis_name_bn." ".$rows->pre_upa_name_bn." ".$rows->pre_post_name_bn;
		}

		// print_r($data);
		if($data)
		{

			return $data;
		}
		else
		{
			return "Requested list is empty";
		}
		return $query;
	}

	function grid_monthly_night_register($date, $grid_emp_id){
		// dd($year_month);
		$year= date('Y',strtotime($date));
		$month= date('m',strtotime($date));
		$att_month = "att_".$year."_".$month;
		// dd($att_month);
		if(!$this->db->table_exists($att_month)){
			return "Report month does not exist!";
		}
		$this->db->select('
						   pr_emp_com_info.emp_id,
						   pr_emp_com_info.emp_join_date,
						   pr_emp_com_info.id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   emp_line_num.line_name_en,
						');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','left');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','left');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','left');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','left');
		$this->db->where_in('pr_emp_com_info.emp_id',$grid_emp_id);
		$this->db->group_by("pr_emp_per_info.emp_id");
		$this->db->order_by("pr_emp_per_info.emp_id");
		$query = $this->db->get();

		if( $query->num_rows() > 0){
			$data = array();

			foreach( $query->result() as $row){
				$newArray = array();
				$first_day = date('Y-m-01', strtotime($date));
				$last_day  = date('Y-m-t', strtotime($first_day));
				$a =$this->db->select('night_allo')->where('emp_id',$row->emp_id)->where('shift_log_date BETWEEN "'.$first_day.'" AND "'.$last_day.'"')->get('pr_emp_shift_log')->result();
				foreach ($a as $item) {
					$newArray[] = $item->night_allo;
				}
				if($newArray == NULL){
					continue;
				}else{
					$newArray = array_merge((array)$row,$newArray);
					$data[] = $newArray;
				}
			}
			// dd($data);
			if($data == NULL){
				return "Soryy! Requested list is empty";
			}
			return $data;
		} else{
			return "Soryy! Requested list is empty";
		}
	}





	function grid_monthly_ifter_register($date, $grid_emp_id){
		// dd($year_month);
		$year= date('Y',strtotime($date));
		$month= date('m',strtotime($date));
		$att_month = "att_".$year."_".$month;
		// dd($att_month);
		if(!$this->db->table_exists($att_month)){
			return "Report month does not exist!";
		}
		$this->db->select('
						   pr_emp_com_info.emp_id,
						   pr_emp_com_info.emp_join_date,
						   pr_emp_com_info.id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   emp_line_num.line_name_en,
						');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','left');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','left');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','left');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','left');
		$this->db->where_in('pr_emp_com_info.emp_id',$grid_emp_id);
		$this->db->group_by("pr_emp_per_info.emp_id");
		$this->db->order_by("pr_emp_per_info.emp_id");
		$query = $this->db->get();

		if( $query->num_rows() > 0){
			$data = array();

			foreach( $query->result() as $row){
				$newArray = array();
				$first_day = date('Y-m-01', strtotime($date));
				$last_day  = date('Y-m-t', strtotime($first_day));
				$a =$this->db->select('ifter_allo')->where('emp_id',$row->emp_id)->where('shift_log_date BETWEEN "'.$first_day.'" AND "'.$last_day.'"')->get('pr_emp_shift_log')->result();
				foreach ($a as $item) {
					$newArray[] = $item->ifter_allo;
				}
				if($newArray == NULL){
					continue;
				}else{
					$newArray = array_merge((array)$row,$newArray);
					$data[] = $newArray;
				}
			}
			// dd($data);
			if($data == NULL){
				return "Soryy! Requested list is empty";
			}
			return $data;
		}
		else{
			return "Soryy! Requested list is empty";
		}
	}
	function grid_monthly_weekend_register($date, $grid_emp_id){
		// dd($year_month);
		$year= date('Y',strtotime($date));
		$month= date('m',strtotime($date));
		$att_month = "att_".$year."_".$month;
		// dd($att_month);
		if(!$this->db->table_exists($att_month)){
			return "Report month does not exist!";
		}
		$this->db->select('
						   pr_emp_com_info.emp_id,
						   pr_emp_com_info.emp_join_date,
						   pr_emp_com_info.id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   emp_line_num.line_name_en,
						');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','left');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','left');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','left');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','left');
		$this->db->where_in('pr_emp_com_info.emp_id',$grid_emp_id);
		$this->db->group_by("pr_emp_per_info.emp_id");
		$this->db->order_by("pr_emp_per_info.emp_id");
		$query = $this->db->get();

		if( $query->num_rows() > 0){
			$data = array();

			foreach( $query->result() as $row){
				$newArray = array();
				$first_day = date('Y-m-01', strtotime($date));
				$last_day  = date('Y-m-t', strtotime($first_day));
				$a =$this->db->select('weekly_allo')->where('emp_id',$row->emp_id)->where('shift_log_date BETWEEN "'.$first_day.'" AND "'.$last_day.'"')->get('pr_emp_shift_log')->result();
				foreach ($a as $item) {
					$newArray[] = $item->weekly_allo;
				}
				if($newArray == NULL){
					continue;
				}else{
					$newArray = array_merge((array)$row,$newArray);
					$data[] = $newArray;
				}
			}
			// dd($data);
			if($data == NULL){
				return "Soryy! Requested list is empty";
			}
			return $data;
		}
		else{
			return "Soryy! Requested list is empty";
		}
	}
	function grid_monthly_holiday_register($date, $grid_emp_id){
		// dd($year_month);
		$year= date('Y',strtotime($date));
		$month= date('m',strtotime($date));
		$att_month = "att_".$year."_".$month;
		// dd($att_month);
		if(!$this->db->table_exists($att_month)){
			return "Report month does not exist!";
		}
		$this->db->select('
						   pr_emp_com_info.emp_id,
						   pr_emp_com_info.emp_join_date,
						   pr_emp_com_info.id,
						   pr_emp_per_info.name_en,
						   emp_designation.desig_name,
						   emp_line_num.line_name_en,
						');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_per_info','pr_emp_com_info.emp_id = pr_emp_per_info.emp_id','left');
		$this->db->join('emp_section','emp_section.id = pr_emp_com_info.emp_sec_id','left');
		$this->db->join('emp_line_num','emp_line_num.id = pr_emp_com_info.emp_line_id','left');
		$this->db->join('emp_designation','emp_designation.id = pr_emp_com_info.emp_desi_id','left');
		$this->db->where_in('pr_emp_com_info.emp_id',$grid_emp_id);
		$this->db->group_by("pr_emp_per_info.emp_id");
		$this->db->order_by("pr_emp_per_info.emp_id");
		$query = $this->db->get();

		if( $query->num_rows() > 0){
			$data = array();

			foreach( $query->result() as $row){
				$newArray = array();
				$first_day = date('Y-m-01', strtotime($date));
				$last_day  = date('Y-m-t', strtotime($first_day));
				$a =$this->db->select('holiday_allo')->where('emp_id',$row->emp_id)->where('shift_log_date BETWEEN "'.$first_day.'" AND "'.$last_day.'"')->get('pr_emp_shift_log')->result();
				foreach ($a as $item) {
					$newArray[] = $item->holiday_allo;
				}
				if($newArray == NULL){
					continue;
				}else{
					$newArray = array_merge((array)$row,$newArray);
					$data[] = $newArray;
				}
			}
			// dd($data);
			if($data == NULL){
				return "Soryy! Requested list is empty";
			}
			return $data;
		}
		else{
			return "Soryy! Requested list is empty";
		}
	}
	function grid_employee_background($grid_emp_id){
		// dd($grid_emp_id)
		$this->db->select('
			pr_emp_com_info.id as com_id,
			pr_emp_com_info.*,
			pr_emp_per_info.*,
			emp_depertment.dept_name,
			emp_section.sec_name_en,
			emp_section.sec_name_bn,
			emp_line_num.line_name_en,
			emp_line_num.line_name_bn,
			emp_designation.desig_name,
			emp_designation.desig_bangla,
			pr_emp_com_info.emp_join_date,
			pr_emp_shift.shift_name,
			pr_grade.gr_name,
			pr_grade.gr_salary,
			pr_emp_com_info.gross_sal,
			pr_emp_status.stat_type,
			pr_emp_per_info.per_village,
			per_dis.name_bn as per_dis_name_bn,
			per_upa.name_bn as per_upa_name_bn,
			per_post.name_bn as per_post_name_bn,
			per_upa.name_en as per_upa_name_en,
			per_dis.name_en as per_dis_name_en,
			per_post.name_en as per_post_name_en,
			pr_emp_per_info.pre_village,
			pre_dis.name_en as pre_dis_name_en,
			pre_upa.name_en as pre_upa_name_en,
			pre_post.name_en as pre_post_name_en,
			pr_emp_resign_history.resign_date,
			pr_emp_left_history.left_date,
			DAY(pr_emp_resign_history.resign_date) as last_working_day,
			year(pr_emp_resign_history.resign_date) as resign_year
		');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_emp_shift',    		'pr_emp_shift.id = pr_emp_com_info.emp_shift', 'left');
		$this->db->join('pr_emp_per_info', 		'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
		$this->db->join('pr_emp_left_history',  'pr_emp_per_info.emp_id = pr_emp_left_history.emp_id', 'left');
		$this->db->join('pr_emp_resign_history','pr_emp_per_info.emp_id = pr_emp_resign_history.emp_id', 'left');
		$this->db->join('pr_grade',             'pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id', 'left');
		$this->db->join('emp_depertment',       'pr_emp_com_info.emp_dept_id = emp_depertment.dept_id', 'left');
		$this->db->join('emp_section',          'pr_emp_com_info.emp_sec_id = emp_section.id', 'left');
		$this->db->join('emp_line_num',         'pr_emp_com_info.emp_line_id = emp_line_num.id', 'left');
		$this->db->join('emp_designation',      'pr_emp_com_info.emp_desi_id = emp_designation.id', 'left');
		$this->db->join('pr_emp_status',        'pr_emp_com_info.emp_cat_id = pr_emp_status.stat_id', 'left');
		$this->db->join('emp_districts as per_dis', 	'pr_emp_per_info.per_district = per_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as per_upa', 		'pr_emp_per_info.per_thana = per_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as per_post', 'pr_emp_per_info.per_post = per_post.id', 'LEFT');
		$this->db->join('emp_districts as pre_dis', 	'pr_emp_per_info.pre_district = pre_dis.id', 'LEFT');
		$this->db->join('emp_upazilas as pre_upa', 		'pr_emp_per_info.pre_thana = pre_upa.id', 'LEFT');
		$this->db->join('emp_post_offices as pre_post', 'pr_emp_per_info.pre_post = pre_post.id', 'LEFT');
		$this->db->where_in('pr_emp_com_info.emp_id', $grid_emp_id);
		$this->db->order_by("pr_emp_com_info.emp_id");
		// $this->db->group_by("pr_emp_com_info.emp_id");
		$query = $this->db->get()->result();
		return $query[0];
	}
  }
  ?>


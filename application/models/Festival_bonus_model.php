<?php
class Festival_bonus_model extends CI_Model{
	
	
	function __construct()
	{
		parent::__construct();
		
		/* Standard Libraries */
		$this->load->model('pf_model');
		$this->load->model('common_model');
	}
	
	function festival_bonus_process($emp_ids, $date, $process_check)
	{
		$unit_id = $this->session->userdata('data')->unit_name;
		$start_date = date("Y-m-01", strtotime($date));
		$salary_month = date("Y-m", strtotime($date));
		
		$this->db->where_in("emp_id",$emp_ids);
		// $this->db->where("unit_id",$unit_id);
		$this->db->order_by("emp_id");
		$query = $this->db->get("pr_emp_com_info");
		
		if($query->num_rows() == 0) {
			return "Employee information does not exist";
		} else {
			$serial = 1;
			$data = array();
			$data_com 	= array();
			foreach($query->result() as $rows)
			{
				set_time_limit(0) ;
				ini_set("memory_limit","512M");

				//========================GENERAL INFORMATION==================================
				//=============================================================================
				$emp_id 		= $rows->emp_id; 
				$emp_type 		= $rows->emp_type; 
				$doj 			= $rows->emp_join_date;
				$gross_sal 		= $rows->gross_sal;
				$gross_sal_com 	= $rows->com_gross_sal;
				$per_info = $this->db->where("emp_id",$emp_id)->get('pr_emp_per_info')->row();
				
				$salary_process_eligibility = $this->salary_process_eligibility($emp_id, $start_date);
				
				if($salary_process_eligibility == true) {
					//=========================  FOR INCREMENT AND PROMOTION =====================
					//============================================================================
					$where = "trim(substr(effective_month,1,7)) = '$salary_month'";
					$this->db->select("new_salary");
					$this->db->where("new_emp_id", $emp_id);
					$this->db->where($where);
					$inc_prom_entry1 = $this->db->get("pr_incre_prom_pun");

					if($inc_prom_entry1->num_rows() > 0 )
					{
						foreach($inc_prom_entry1->result() as $row)
						{
							$gross_sal 	= $row->new_salary;
						}
					}
					else
					{
						$where = "trim(substr(effective_month,1,7)) > '$salary_month'";
						$this->db->select("prev_salary");
						$this->db->where("new_emp_id",$emp_id);
						$this->db->where($where);
						$this->db->limit(1);
						$inc_prom_entry2 = $this->db->get("pr_incre_prom_pun");
						if($inc_prom_entry2->num_rows() > 0 )
						{
							foreach($inc_prom_entry2->result() as $row)
							{
								$gross_sal 		= $row->prev_salary;
							}
						}
						else
						{
							echo "";
						}
					}
					//=============================== END INCREMENT AND PROMOTION ======================
					$data["emp_id"] 		= $emp_id;
					$data["unit_id"] 		= $rows->unit_id;
					$data["dept_id"] 		= $rows->emp_dept_id;
					$data["sec_id"] 		= $rows->emp_sec_id;
					$data["line_id"] 		= $rows->emp_line_id;
					$data["desig_id"] 		= $rows->emp_desi_id;
					$data["emp_status"] 	= $rows->emp_cat_id;
					$data["emp_sex"] 		= $per_info->emp_sex;

					$salary_structure 		= $this->common_model->salary_structure($gross_sal);
					$basic_sal 				= $salary_structure['basic_sal'];
					$data["basic_sal"] 		= $basic_sal;
					$data["house_r"] 		= $salary_structure['house_rent'];
					$data["medical_a"] 		= $salary_structure['medical_allow'];
					$data["food_allow"] 	= $salary_structure['food_allow'];
					$data["trans_allow"] 	= $salary_structure['trans_allow'];
					$data["gross_sal"] 		= $gross_sal;
					//===========================END GENERAL INFORMATION==================================
			
					$join_month = trim(substr($doj,0,7));
					$effective_date = $this->get_bonus_effective_date($salary_month);

					if ($effective_date < $doj) {
						continue;
					}
					$service_days = $this->get_service_month($doj,$effective_date);
					$rule = $this->get_bonus_rule($effective_date,$service_days,$unit_id, $emp_type);
					if(!empty($rule))
					{
						$bonus = $this->get_festival_bonus($rule,$gross_sal,$basic_sal,$per_info);	
					}
					else
					{
						continue;
					}

					$data["service_length"] 	= $service_days;
					$data["bonus_rule_id"] 		= $rule->id;
					$data["bonus_amount"] 		= $bonus;
					$data["effective_month"] 	= $start_date;
					// dd($data);

					$this->db->select("emp_id");
					$this->db->where("emp_id", $rows->emp_id);
					$this->db->where("effective_month", $start_date);
					$query = $this->db->get("pr_festival_bonus_sheet");
					if($query->num_rows() > 0 )
					{
						$this->db->where("emp_id", $rows->emp_id);
						$this->db->where("effective_month", $start_date);
						$this->db->update("pr_festival_bonus_sheet",$data);
					}
					else
					{
						$this->db->insert("pr_festival_bonus_sheet",$data);
					}

				}
			}
			return "Process completed successfully";		
		}
	}

	function get_festival_bonus($rule,$gross_sal,$basic_sal,$per_info)
	{
		if ($per_info->religion == 'Islam') {
			$religion = 1;
		} else if ($per_info->religion == 'Hindu') {
			$religion = 2;
		} else if ($per_info->religion == 'Christian') {
			$religion = 3;	
		} else if ($per_info->religion == 'Buddhish') {
			$religion = 4;
		} else {
			$religion = 1;
		}

		$check = false;
		if (!empty($rule->religion_id) && $religion == $rule->religion_id) {
			$check = true;
		}
		if ($check == true) {
			if ($rule->bonus_amount == 'Gross') {
				$amt = ($rule->bonus_percent * $gross_sal) / 100;
			} else {
				$amt = ($rule->bonus_percent * $basic_sal) / 100;
			}
		} else {
			$amt = 0;
		}
		return $amt;
	}

	function get_bonus_rule($salary_month, $service_days, $unit_id, $emp_type)
	{      
		$this->db->where("unit_id",$unit_id);
		$this->db->where("emp_type",$emp_type);
		$this->db->where("bonus_first_month <=",$service_days);
		$this->db->where("bonus_second_month >=",$service_days);
		$this->db->where("effective_date",$salary_month);
		$this->db->order_by("bonus_first_month","DESC");
		$query = $this->db->get("pr_bonus_rules");
		$row = $query->row();
		return $row;
	}
	function get_service_month($second_date, $first_date)
	{
		$days = (new DateTime($second_date))->diff(new DateTime($first_date))->days + 1;
		return $days;
	}

	function get_bonus_effective_date($salary_month)
	{
		$this->db->select('effective_date');
		$this->db->like('effective_date',$salary_month);
		$query = $this->db->get('pr_bonus_rules');
		//echo $this->db->last_query();
		if($query->num_rows() > 0 ){
			$row = $query->row();
			return $effective_date =  $row->effective_date;
		}else{
			return false;
		}
	}










	function get_festival_bonus_rule($service_month,$unit_id,$emp_type)
	{
		// echo $service_month;
		// echo $emp_type;
		if($emp_type== "2")
		{
			$emp_type = "Worker";
		}
		else{
			$emp_type = "Staff";
		}
		
		$data = array();
		$this->db->select('*');
		// $this->db->where('unit_id', $unit_id); 
		$this->db->where('emp_type', $emp_type); 
		$this->db->where('bonus_first_month <=', $service_month); 
		$this->db->where('bonus_second_month >=', $service_month); 
		$this->db->order_by('effective_date','DESC');
		$this->db->limit(1);
		$query = $this->db->get('pr_bonus_rules');
		// echo $this->db->last_query();
		//echo 'R:'.$num = $query->num_rows().'|';
		$row = $query->row();
		if($query->num_rows() != 0)
		{
			$data['id'] 				= $row->id;
			$data['bonus_amount'] 		= $row->bonus_amount;
			$data['amount_fraction'] 	= $row->bonus_amount_fraction;
			$data['bonus_percent'] 		= $row->bonus_percent;
		}
		// print_r($data);
		return $data;
	}
	
	function get_desig_bonus_rules($effective_date,$desig_id)
	{
		$this->db->select('pr_desig_bonus_rules.bonus_amount,pr_desig_bonus_rules.rules_name');
		$this->db->from('pr_desig_bonus_rules');
		$this->db->from('pr_desig_bonus_level');
		$this->db->where("pr_desig_bonus_rules.rules_id = pr_desig_bonus_level.rules_id");
		$this->db->where("pr_desig_bonus_level.desig_id", $desig_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$data['bonus_amount'] 	= $row->bonus_amount;
			$data['rules_name'] 	= $row->rules_name;
			$data['msg'] = "OK";
		}
		else
		{
			$rules_id = 0;
			$data['msg'] = "NULL";
		}
		//echo "=====".$this->db->last_query();
		return $data;
	}
	
	function emp_name($emp_id)
	{
		$this->db->select("name_en as emp_full_name");
		$this->db->where("emp_id",$emp_id);
		$query = $this->db->get("pr_emp_per_info");
		$row = $query->row();
		return $row->emp_full_name;
	}
	function emp_desig($desig_id)
	{
		// dd($desig_id);
		$this->db->select("desig_name");
		$this->db->where("id",$desig_id);
		$query = $this->db->get("emp_designation");
		$row = $query->row();
		// dd($row->desig_name);
		if ($row !== null && isset($row->desig_name)) {
			return $row->desig_name;
		} else {
			return null;
		}
	}
	
	function salary_grade($gr_id)
	{
		$this->db->select("gr_name");
		$this->db->where("gr_id",$gr_id);
		$query = $this->db->get("pr_grade");
		$row = $query->row();
		return $row->gr_name;
	}
	function salary_process_eligibility($emp_id, $salary_month)
	{
		$salary_year_month = date('Y-m', strtotime($salary_month));
		
		$join_check 		= $this->join_range_check($emp_id, $salary_year_month);
		$resign_check 		= $this->resign_range_check($emp_id, $salary_year_month);
		$left_check 		= $this->left_range_check($emp_id, $salary_year_month);
		$zero_gross_check 	= $this->zero_gross_check($emp_id);
		
		
		if($join_check != false and $resign_check != false and $left_check != false and $zero_gross_check != false )
		{
				return true;
		}
		else
		{
			$this->db->where('emp_id', $emp_id);
			$this->db->like('effective_month', $salary_month);
			$this->db->delete('pr_festival_bonus_sheet'); 
			return false;
		}
	}
	
	function zero_gross_check($emp_id)
	{
		$this->db->select('gross_sal');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("gross_sal !=","0");
		$query = $this->db->get('pr_emp_com_info');
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
	
	function join_range_check($emp_id, $salary_year_month)
	{
		$this->db->select('emp_join_date');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("trim(substr(emp_join_date,1,7)) <= '$salary_year_month'");
		$query = $this->db->get('pr_emp_com_info');
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
	
	function resign_range_check($emp_id, $salary_year_month)
	{
		$this->db->select('resign_date');
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('pr_emp_resign_history');
		//echo $this->db->last_query();
		if($query->num_rows() == 0)
		{
			return true;
		}	
		else
		{
			$this->db->select('resign_date');
			$this->db->where('emp_id', $emp_id);
			$this->db->where("trim(substr(resign_date,1,7)) >= '$salary_year_month'");
			$query = $this->db->get('pr_emp_resign_history');
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
	}
	
	function left_range_check($emp_id, $salary_year_month)
	{
		$this->db->select('left_date');
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('pr_emp_left_history');
		//echo $this->db->last_query();
		if($query->num_rows() == 0)
		{
			return true;
		}	
		else
		{
			$this->db->select('left_date');
			$this->db->where('emp_id', $emp_id);
			$this->db->where("trim(substr(left_date,1,7)) >= '$salary_year_month'");
			$query = $this->db->get('pr_emp_left_history');
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
	}

	/////////////get_lowest_month_festival_bonus//
	function get_lowest_month_festival_bonus($year_month,$unit_id)
	{
		$this->db->select("bonus_first_month");
		$this->db->like("unit_id",$unit_id);
		$this->db->like("effective_date",$year_month);
		$this->db->limit(1);
		$query = $this->db->get("pr_bonus_rules");
		//echo $this->db->last_query();
		if($query->num_rows() > 0 ){
			$row = $query->row();
			return $bonus_first_month =  $row->bonus_first_month;
		}else{
			return false;
		}
	
	}
	
}
?>
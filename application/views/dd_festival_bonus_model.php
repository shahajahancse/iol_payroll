<?php
class Festival_bonus_model extends CI_Model{
	
	
	function __construct()
	{
		parent::__construct();
		
		/* Standard Libraries */
		$this->load->model('pf_model');
		$this->load->model('common_model');
	}
	
	function festival_bonus_process($year, $month,$process_check)
	{
		$year_v=$year;
		$month_v=$month;
		
		$start_date = date("Y-m-d", mktime(0, 0, 0, $month_v, 1, $year_v));
		dd($start_date);
		
		$year_month = "$year_v-$month_v";
		/////////////////Get Employee////////////////
		$unit_id = $this->common_model->get_session_unit_id_name();
		
		$this->db->select("emp_id,gross_sal,emp_sal_gra_id,emp_desi_id,emp_join_date,salary_type,emp_sec_id,ot_entitle,com_gross_sal,emp_dept_id,emp_line_id,emp_cat_id,");
		$this->db->where("unit_id",$unit_id);
		//$this->db->where("emp_id","2000176");
		//$this->db->where("emp_cat_id","4");
		$this->db->order_by("emp_id");
		$query = $this->db->get("pr_emp_com_info");
		
		if($query->num_rows() == 0)
		{
			return "Employee information does not exist";
		}
		else
		{
			$serial = 1;
			$data = array();
			$data_com 	= array();
			foreach($query->result() as $rows)
			{
				set_time_limit(0) ;
				ini_set("memory_limit","512M");
				
				
				//========================GENERAL INFORMATION==================================
				//=============================================================================
				$emp_name 		= $this->emp_name($rows->emp_id);
				$emp_id 		= $rows->emp_id; 
				$desi_id 		= $rows->emp_desi_id;
				$emp_sec_id 	= $rows->emp_sec_id;
				$emp_desig 		= $this->emp_desig($rows->emp_desi_id);
				
				$emp_dept_id	= $rows->emp_dept_id;
				$emp_line_id	= $rows->emp_line_id;
				$emp_cat_id		= $rows->emp_cat_id;
				
				$ot_entitle		= $rows->ot_entitle;
				
				$doj 			= $rows->emp_join_date;
				$gross_sal 		= $rows->gross_sal;
				$gross_sal_com 	= $rows->com_gross_sal;
				
				$salary_process_eligibility = $this->salary_process_eligibility($emp_id, $start_date);
				
				if($salary_process_eligibility == true)
				{
				//==============================FOR INCREMENT AND PROMOTION=====================
				//==============================================================================
				$where = "trim(substr(effective_month,1,7)) = '$year_month'";
				$this->db->select("new_salary");
				$this->db->where("new_emp_id",$emp_id);
				$this->db->where($where);
				$inc_prom_entry1 = $this->db->get("pr_incre_prom_pun");
				if($inc_prom_entry1->num_rows() > 0 )
				{
					foreach($inc_prom_entry1->result() as $row)
					{
						$gross_sal 		= $row->new_salary;
					}
				}
				else
				{
					$where = "trim(substr(effective_month,1,7)) > '$year_month'";
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
				//============================================END INCREMENT AND PROMOTION======================
				$salary_structure 		= $this->common_model->salary_structure($gross_sal);
				$basic_sal 				= $salary_structure['basic_sal'];
				$madical_allo 			= $salary_structure['medical_allow'];
				$house_rent 			= $salary_structure['house_rent'];
				$trans_allow 			= $salary_structure['trans_allow'];
				$food_allow 			= $salary_structure['food_allow'];
				
				$total_sal = $basic_sal + $house_rent + $madical_allo + $food_allow + $trans_allow; 
				$data["emp_id"] 		= $emp_id;
				$data["unit_id"] 		= $unit_id;
				$data["sec_id"] 		= $emp_sec_id;
				$data["desig_id"] 		= $desi_id;
				$data["dept_id"] 		= $emp_dept_id;
				$data["line_id"] 		= $emp_line_id;
				$data["emp_status"] 	= $emp_cat_id;
				$data["emp_sex"] 		= $this->db->where("emp_id",$emp_id)->get('pr_emp_per_info')->row()->emp_sex;
				
				$data["basic_sal"] 		= $basic_sal;
				$data["house_r"] 		= $house_rent;
				$data["medical_a"] 		= $madical_allo;
				$data["food_allow"] 	= $food_allow;
				$data["trans_allow"] 	= $trans_allow;
				$data["gross_sal"] 		= $gross_sal;
				
	//===========================END GENERAL INFORMATION==================================
				
			
			/////////////////////////////
		$salary_month = trim(substr($start_date,0,7));
		$join_month = trim(substr($doj,0,7));
		
		$effective_date = $this->get_bonus_effective_date($salary_month);
	
			if($effective_date != false)
				{
					$service_month = $this->get_service_month($effective_date,$doj);
					$lowest_month_festival= $this->get_lowest_month_festival_bonus($year_month,$unit_id);
					//echo "$effective_date ===$doj====$service_month====$lowest_month_festival"; 
					if($service_month >= $lowest_month_festival)
					{
							$festival_bonus_rule 	= $this->get_festival_bonus_rule($service_month,$unit_id,$ot_entitle);
							$festival_bonus 		= $this->get_festival_bonus($festival_bonus_rule,$gross_sal,$basic_sal);
						
				}
				else
				{
					$festival_bonus 	= 0;
					$festival_bonus_rule['id'] = 0;
				}
				
				//echo "///$emp_id===$festival_bonus";

				
				$data["service_length"] 	= $service_month;
				$data["bonus_rule_id"] 		= $festival_bonus_rule['id'];
				$data["bonus_amount"] 		= $festival_bonus;
				$data["effective_month"] 	= $start_date;
				
			//echo "$service_month====$festival_bonus===$start_date";
				//festival_bonus_sheet///update/////insert////
				$this->db->select("emp_id");
				$this->db->where("emp_id", $rows->emp_id);
				$this->db->where("effective_month", $start_date);
				$query = $this->db->get("pr_festival_bonus_sheet");
				
				if($query->num_rows() > 0 )
				{
					//echo "hello==$start_date";
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
	}
		
		return "Process completed successfully";		
		/////////////
	}
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
		//echo $service_month;
		//echo $emp_type;
		if($emp_type== "0")
		{
			$emp_type = "Worker";
		}
		else{
			$emp_type = "Staff";
		}
		
		$data = array();
		$this->db->select('*');
		$this->db->where('unit_id', $unit_id); 
		$this->db->where('emp_type', $emp_type); 
		$this->db->where('bonus_first_month <=', $service_month); 
		$this->db->where('bonus_second_month >=', $service_month); 
		$this->db->order_by('effective_date','DESC');
		$this->db->limit(1);
		$query = $this->db->get('pr_bonus_rules');
		//echo $this->db->last_query();
		//echo 'R:'.$num = $query->num_rows().'|';
		$row = $query->row();
		if($query->num_rows() != 0)
		{
			$data['id'] 				= $row->id;
			$data['bonus_amount'] 		= $row->bonus_amount;
			$data['amount_fraction'] 	= $row->bonus_amount_fraction;
			$data['bonus_percent'] 		= $row->bonus_percent;
		}
		return $data;
	}
	
	function get_festival_bonus($festival_bonus_rule,$gross_sal,$basic_sal)
	{
		$bonus_amount 		= $festival_bonus_rule['bonus_amount'];
		$amount_fraction 	= $festival_bonus_rule['amount_fraction'];
		$bonus_percent 		= $festival_bonus_rule['bonus_percent']; 
		
		if($bonus_amount == "Gross")
		{
			$salary_for_bonus = $gross_sal;
		}
		else
		{
			$salary_for_bonus = $basic_sal; 
		}
		//echo $bonus_amount."===".$salary_for_bonus;
		
		$pre_festival_bonus = $salary_for_bonus * $amount_fraction;
		$festival_bonus = round((($pre_festival_bonus * $bonus_percent)/100));
		//echo $festival_bonus;
		return $festival_bonus;
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
		$this->db->select("emp_full_name");
		$this->db->where("emp_id",$emp_id);
		$query = $this->db->get("pr_emp_per_info");
		$row = $query->row();
		return $row->emp_full_name;
	}
	function emp_desig($desig_id)
	{
		$this->db->select("desig_name");
		$this->db->where("desig_id",$desig_id);
		$query = $this->db->get("pr_designation");
		$row = $query->row();
		return $row->desig_name;
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
	
	function get_service_month($effective_date,$doj)
	{
		$start = strtotime($doj);
		$end = strtotime($effective_date);
		$no_of_days = ceil(abs($end - $start) / 86400);
		return  $no_of_days;
		
		
		//$date_diff 		= strtotime($effective_date)-strtotime($doj);
		//DATE TO DATE RULE
		//return $month 	= floor(($date_diff)/2592000);
		
		//MONTH TO MONTH RULE
		//return $month 	= ceil(($date_diff)/2628000);
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
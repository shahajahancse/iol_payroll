<?php
class Salary_process_model extends CI_Model{


	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
		$this->load->model('pf_model');
		$this->load->model('common_model');
	}

	function salary_process($unit_id,$process_month,$grid_emp_id)
	{
		set_time_limit(0);
		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 0);

		$num_of_days   = date("t", strtotime($process_month));
		$start_date    = date("Y-m-d", strtotime($process_month));
		$end_date      = $process_month .'-'. $num_of_days;
		$table_name    = "att_".date("Y_m", strtotime($process_month));
		// dd($num_of_days .'=='. $start_date .'=='. $end_date .'=='. $table_name);

		//PROCESS MONTH EXISTANCE CHECK
		if(!$this->db->table_exists($table_name))
		{
			return "Process month does not exist, please change your process month";
		}
        // $day_of_week = $this->get_how_many_weeked_between_dates($start_date,$end_date);

		//SALARY BLOCK CHECK
		$sb = $this->db->where('block_month',$start_date)->where('unit_id',$unit_id)->get('pay_salary_block')->num_rows();
		if($sb > 0)
		{
			return "This Month Already Finally Processed.";
		}

		$day_of_week=5;   //==== please change this variable $fd = "next Friday"; if you change $day_of_week =====//
		
		$result=$this->find_week($year_v,$month_v,$day_of_week);
		//$num_working_days = $result['no_of_working_days'];
		$num_of_days = $result['num_of_days'];
		
		//$att_register = $this->daily_absent_db($start_date);
		$deduct_id =1;
		$deduct_status = $this->common_model->get_setup_attributes($deduct_id);
		
		//echo $deduct_status ;
		
		
		//print_r($result);
	  $arr = array('1003247','1004461','1004448','1004447','3001134','3001112');
		
		$this->db->select("emp_id,gross_sal,emp_sal_gra_id,emp_desi_id,emp_join_date,salary_type,emp_sec_id,ot_entitle,com_gross_sal,emp_dept_id,emp_line_id,emp_cat_id,");
		$this->db->where("unit_id",$unit_id);
		$this->db->where_in("emp_id",$grid_emp_id);
		// $this->db->where("emp_id","2005818");
		//$this->db->where("emp_cat_id","4");
		$this->db->order_by("emp_id");
		$query = $this->db->get("pr_emp_com_info");
		dd("KO");
		if($query->num_rows() == 0)
		{
			return "Employee information does not exist";
		}
		else
		{
			// dd("KO");
			$serial = 1;
			$data = array();
			$data_com 	= array();
			foreach($query->result() as $rows)
			{
				set_time_limit(0) ;
				ini_set("memory_limit","512M");
				
				
				//============GENERAL INFORMATION======================
				//=================================================================
				$emp_name 		= $this->emp_name($rows->emp_id);
				$emp_id 		= $rows->emp_id; 
				$desi_id 		= $rows->emp_desi_id;
				$emp_sec_id 	= $rows->emp_sec_id;
				$emp_desig 		= $this->emp_desig($rows->emp_desi_id);
				
				$emp_dept_id	= $rows->emp_dept_id;
				$emp_line_id	= $rows->emp_line_id;
				$emp_cat_id		= $rows->emp_cat_id;
				
				
				$doj 			= $rows->emp_join_date;
				$gross_sal 		= $rows->gross_sal;
				$gross_sal_com 	= $rows->com_gross_sal;
				$ot_check 		= $rows->ot_entitle;
				
				$salary_process_eligibility = $this->salary_process_eligibility($emp_id, $start_date);
				
				if($salary_process_eligibility == true)
				{
				//==========FOR INCREMENT AND PROMOTION=
				//==========================================================
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
						$gross_sal_com 	= $row->new_salary;
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
							$gross_sal_com 	= $row->prev_salary;
						}
					}
					else
					{
						echo "";
					}
				
				}
				//=========================END INCREMENT AND PROMOTION===
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
				
				$stop_salary			=$this->stop_salary_check($emp_id,$start_date);
				$data["stop_salary"]	= $stop_salary;
				$data["basic_sal"] 		= $basic_sal;
				$data["house_r"] 		= $house_rent;
				$data["medical_a"] 		= $madical_allo;
				$data["food_allow"] 	= $food_allow;
				$data["trans_allow"] 	= $trans_allow;
				$data["gross_sal"] 		= $gross_sal;
				$data["total_days"] 	= $num_of_days;
				//$data["num_of_workday"] = $no_working_days;
				
				//COMPLIENCE
				$salary_structure_com 		= $this->common_model->salary_structure($gross_sal_com);
				$basic_sal_com 				= $salary_structure_com['basic_sal'];
				$madical_allo_com 			= $salary_structure_com['medical_allow'];
				$house_rent_com 			= $salary_structure_com['house_rent'];
				$trans_allow_com 			= $salary_structure_com['trans_allow'];
				$food_allow_com 			= $salary_structure_com['food_allow'];
				
				$total_sal_com = $basic_sal_com + $madical_allo_com + $house_rent_com + $trans_allow_com + $food_allow_com; 
				$data_com["emp_id"] 		= $emp_id;
				$data_com["unit_id"] 		= $unit_id;
				$data_com["sec_id"] 		= $emp_sec_id;
				$data_com["desig_id"] 		= $desi_id;
				$data_com["dept_id"] 		= $emp_dept_id;
				$data_com["line_id"] 		= $emp_line_id;
				$data_com["emp_status"] 	= $emp_cat_id;
				$data_com["emp_sex"] 		= $this->db->where("emp_id",$emp_id)->get('pr_emp_per_info')->row()->emp_sex;
				$data_com["stop_salary"]	= 1;
				$data_com["basic_sal"] 		= $basic_sal_com;
				$data_com["house_r"] 		= $house_rent_com;
				$data_com["medical_a"] 		= $madical_allo_com;
				$data_com["food_allow"] 	= $food_allow_com;
				$data_com["trans_allow"] 	= $trans_allow_com;
				$data_com["gross_sal"] 		= $gross_sal_com;
				$data_com["total_days"] 	= $num_of_days;
				//$data_com["num_of_workday"] = $no_working_days;
				
				//===========END GENERAL INFORMATION==================
				
				
				
				//=========PRESENT STATUS========================
				//==============================================================
				$salary_month = trim(substr($start_date,0,7));
				$join_month = trim(substr($doj,0,7));

				$resign_check 	= $this->resign_check($emp_id, $salary_month);
				$left_check 	= $this->left_check($emp_id, $salary_month);
				if($resign_check != false and $salary_month == $join_month){
					$total_days = $resign_check['resign_day'];
					$left_or_resign_date = $resign_check['resign_date'];
					$resign_data = $this->get_resign_month_dates($resign_check['resign_day'], $salary_month);
					$resign_after_absent = $this->resign_day_count($resign_data['resign_3rd_date'],$resign_data['resign_2nd_count']);
					
					$search_date = $doj;
					$doj_data = $this->get_join_month_dates($doj);
					$doj_before_absent = $this->new_join_day_count($doj_data['doj_1st_date'], $doj_data['doj_3rd_date']);
					
					$before_after_absent = $resign_after_absent+$doj_before_absent;
				}
				elseif($left_check != false and $salary_month == $join_month){
					$total_days = $left_check['left_day'];
					$left_or_resign_date = $left_check['left_date'];
					$resign_data = $this->get_resign_month_dates($left_check['left_day'], $salary_month);
					if($salary_month == $join_month){
						$search_date = $doj;
					}else{
						$search_date = $resign_data['resign_1st_date'];
					}
					$doj_data = $this->get_join_month_dates($doj);
					$doj_before_absent = $this->new_join_day_count($doj_data['doj_1st_date'], $doj_data['doj_3rd_date']);	
					$resign_after_absent = $this->resign_day_count($resign_data['resign_3rd_date'],$resign_data['resign_2nd_count']);
					$before_after_absent = $doj_before_absent+$resign_after_absent;
				}
				elseif($resign_check != false){
					$total_days = $resign_check['resign_day'];
					$left_or_resign_date = $resign_check['resign_date'];
					$resign_data = $this->get_resign_month_dates($resign_check['resign_day'], $salary_month);
					$search_date = $resign_data['resign_1st_date'];
					$resign_after_absent = $this->resign_day_count($resign_data['resign_3rd_date'],$resign_data['resign_2nd_count']);
					$before_after_absent = $resign_after_absent;
				}
				elseif($salary_month == $join_month){
					$search_date = $doj;
					$doj_data = $this->get_join_month_dates($doj);
					$doj_before_absent = $this->new_join_day_count($doj_data['doj_1st_date'], $doj_data['doj_3rd_date']);					
					$total_days = $num_of_days;
					$left_or_resign_date = $end_date;
					$before_after_absent = $doj_before_absent;
				}
				elseif($left_check != false){
					$total_days = $left_check['left_day'];
					$left_or_resign_date = $left_check['left_date'];
					$resign_data = $this->get_resign_month_dates($left_check['left_day'], $salary_month);
					if($salary_month == $join_month){
						$search_date = $doj;
					}	
					else{
						$search_date = $resign_data['resign_1st_date'];
					}
					$resign_after_absent = $this->resign_day_count($resign_data['resign_3rd_date'],$resign_data['resign_2nd_count']);
					$before_after_absent = $resign_after_absent;
				}
				else{
					$total_days = $num_of_days;
					$search_date = $start_date;
					$before_after_absent = 0;
					$left_or_resign_date = $end_date;
				}
	
				
				$absent = "A";
				$absent = $this->attendance_check($rows->emp_id,$absent,$total_days, $search_date);
				$attend = "P";
				$attend = $this->attendance_check($rows->emp_id,$attend,$total_days, $search_date);
				
				$leave_type = "cl";
				$cas_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "sl";
				$sick_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "el";
				$earn_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "ml";
				$m_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "wp";
				$wp_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "do";
				$do_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				
				$total_leave 		= $cas_leave + $sick_leave + $m_leave + $earn_leave + $wp_leave;//e + $do_leave;
				$total_pay_leave 	= $cas_leave + $sick_leave + $m_leave + $earn_leave;// $wp_leave + $do_leave;
				
				$weekend = "W";
				$weekend = $this->attendance_check($rows->emp_id,$weekend,$total_days, $search_date);
				$holiday = "H";
				$holiday = $this->attendance_check($rows->emp_id,$holiday,$total_days, $search_date);
				
				//$num_working_days 	= $num_of_days - $weekend - $before_after_absent;
				$num_working_days 	= $num_of_days - $holiday - $weekend - $before_after_absent;
				$total_holiday 		= $weekend + $holiday;
				//echo $m_leave.'+'.$attend .'+'. $total_holiday .'+'. $total_pay_leave;
				$pay_days = $attend + $total_holiday + $total_pay_leave-$m_leave;
				
								
				$data["num_of_workday"] 		= $num_working_days;
				$data["att_days"] 				= $attend;
				$data["absent_days"] 			= $absent;
				$data["before_after_absent"] 	= $before_after_absent;
				
				$data["c_l"] 					= $cas_leave;
				$data["s_l"] 					= $sick_leave;
				$data["e_l"] 					= $earn_leave;
				$data["m_l"] 					= $m_leave;
				$data["wp"] 					= $wp_leave ;//+ $do_leave;
				$data["total_leave"] 			= $total_leave ;
				$data["total_pay_leave"] 		= $total_pay_leave ;
				
				$data["holiday"] 				= $holiday;
				$data["weekend"] 				= $weekend;
				$data["total_holiday"] 			= $total_holiday;
				$data["pay_days"] 				= $pay_days;
				
				//COMPLIENCE
				$data_com["num_of_workday"] 		= $num_working_days;
				$data_com["att_days"] 				= $attend;
				$data_com["absent_days"] 			= $absent;
				$data_com["before_after_absent"] 	= $before_after_absent;
				
				$data_com["c_l"] 					= $cas_leave;
				$data_com["s_l"] 					= $sick_leave;
				$data_com["e_l"] 					= $earn_leave;
				$data_com["m_l"] 					= $m_leave;
				$data_com["wp"] 					= $wp_leave ;//+ $do_leave;
				$data_com["total_leave"] 			= $total_leave ;
				$data_com["total_pay_leave"] 		= $total_pay_leave ;
				
				$data_com["holiday"] 				= $holiday;
				$data_com["weekend"] 				= $weekend;
				$data_com["total_holiday"] 			= $total_holiday;
				$data_com["pay_days"] 				= $pay_days;

				// echo "<pre>";print_r($data_com);exit();
				
				
				//==========END PRESENT sTATUS=================
				
				//=======DEDUCTION STATUS======================
				//==============================================================
				
				//========DEDUCTION STATUS=======================
				//==============================================================
				
				//==============================Maternity leave calculation==============================
				if($m_leave > 0)
				{
					$per_day_salary_for_gross = $gross_sal/$num_of_days;
					$ml_payment = round($m_leave * $per_day_salary_for_gross);
					// print_r($ml_payment);exit('ali');
					$data_ml["emp_id"] 			= $rows->emp_id;
					$data_ml["food_allow"] 		= $food_allow;
					$data_ml["trans_allaw"] 	= $trans_allow;
					$data_ml["basic_sal"] 		= $basic_sal;
					$data_ml["house_r"] 		= $house_rent;
					$data_ml["medical_a"] 		= $madical_allo;
					$data_ml["gross_sal"] 		= $gross_sal;
					$data_ml["total_days"] 		= $num_of_days;
					//$data_ml["num_of_workday"] 	= $no_working_days;
					$data_ml["m_leave"] 		= $m_leave;
					$data_ml["ml_payment"] 		= $ml_payment;
					$data_ml["salary_month"] 	= $start_date;
				}
				//ABSENT DEDUCTION FOR NON-COMPLIENCE		
				$sal_month = date("Y-m-d", mktime(0, 0, 0, $month_v, 1, $year_v));
				// print_r($data_com);exit;

				
				if($data_com["m_l"] !=''){
					$num_of_days_n = date('t',strtotime($sal_month));
				}
				else{
					$num_of_days_n = 30;
				}

				// print_r($num_of_days_n);exit;

				$p_sal_month = '2018-02-01';
				
				if( $sal_month > $p_sal_month){

					if($pay_days != 0){
						// echo $num_of_days_n .' = '. $num_of_days; exit();
						$absent = $absent + $wp_leave ;
						if($resign_check != false or $left_check != false){
							$before_after_deduct = $gross_sal / $num_of_days * $data["before_after_absent"];
							//$abs_deduction = $gross_sal / $num_of_days_n * $absent;
							$abs_deduction = $basic_sal / $num_of_days_n * $absent;
							$ml_deduct = $gross_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
						}
						else if($salary_month == $join_month){
							$before_after_deduct = $gross_sal / $num_of_days * $data["before_after_absent"];
							//$abs_deduction = $gross_sal / $num_of_days_n * $absent;
							$abs_deduction = $basic_sal / $num_of_days_n * $absent;
							$ml_deduct = $basic_sal / $num_of_days_n * $m_leave;
							$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
						}
						else{
							//echo "here";
							$abs_deduction = $basic_sal / $num_of_days_n * $absent;
							$ml_deduct = $gross_sal / $num_of_days_n * $m_leave;
							// print_r($ml_deduct);exit('aaa');
							$abs_deduction = round($abs_deduction+$ml_deduct);
							//$abs_deduction = round($abs_deduction);
						}
					} else{
						$abs_deduction = $gross_sal;
					}
					
					
					//ABSENT DEDUCTION FOR COMPLIANCE
					if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal_com / $num_of_days * $data["before_after_absent"];
							$abs_deduction_com = $gross_sal_com / $num_of_days_n * $absent;
							$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
						}
						else if($salary_month == $join_month)
						{
							$before_after_deduct = $gross_sal_com / $num_of_days * $data["before_after_absent"];
							$abs_deduction_com = $basic_sal_com / $num_of_days_n * $absent;
							$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
						}
						else
						{
							$abs_deduction_com = $basic_sal_com / $num_of_days_n * $absent;
							$abs_deduction_com = round($abs_deduction_com);
						}
					}
					else
					{
						$abs_deduction_com = $gross_sal_com;
					}

				}
				else
				{
					if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($salary_month == $join_month or $resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal / $num_of_days * $data["before_after_absent"];
							$abs_deduction = $gross_sal / $num_of_days_n * $absent;
							$ml_deduct = $basic_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
							if($salary_month != $join_month and ($resign_check != false or $left_check != false) and $pay_days >= 15)
							{
								$before_after_deduct = $basic_sal / $num_of_days * $data["before_after_absent"];
								$abs_deduction = $basic_sal / $num_of_days * $absent;
								$ml_deduct = $basic_sal / $num_of_days * $m_leave;
								$abs_deduction = round($abs_deduction + $before_after_deduct+$ml_deduct);	
							}
						}
						else
						{
							$abs_deduction = $basic_sal / $num_of_days * $absent;
							$ml_deduct = $basic_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction+$ml_deduct);
						}
					}
					else
					{
						$abs_deduction = $gross_sal;
					}
					
					
					//ABSENT DEDUCTION FOR COMPLIANCE
					if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($salary_month == $join_month or $resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal_com / $num_of_days * $data["before_after_absent"];
							$abs_deduction_com = $basic_sal_com / $num_of_days_n * $absent;
							$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
						}
						else
						{
							$abs_deduction_com = $basic_sal_com / $num_of_days * $absent;
							$abs_deduction_com = round($abs_deduction_com);
						}
					}
					else
					{
						$abs_deduction_com = $gross_sal_com;
					}

				}
				
				/*if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($salary_month == $join_month or $resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal / $num_of_days * $data["before_after_absent"];
							$abs_deduction = $gross_sal / $num_of_days * $absent;
							$ml_deduct = $basic_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
							if($salary_month != $join_month and ($resign_check != false or $left_check != false) and $pay_days >= 15)
							{
								$before_after_deduct = $basic_sal / $num_of_days * $data["before_after_absent"];
								$abs_deduction = $basic_sal / $num_of_days * $absent;
								$ml_deduct = $basic_sal / $num_of_days * $m_leave;
								$abs_deduction = round($abs_deduction + $before_after_deduct+$ml_deduct);	
							}
						}
						else
						{
							$abs_deduction = $basic_sal / $num_of_days * $absent;
							$ml_deduct = $basic_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction+$ml_deduct);
						}
					}
					else
					{
						$abs_deduction = $gross_sal;
					}
					
					
					//ABSENT DEDUCTION FOR COMPLIANCE
					if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($salary_month == $join_month or $resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal_com / $num_of_days * $data["before_after_absent"];
							$abs_deduction_com = $basic_sal_com / $num_of_days * $absent;
							$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
						}
						else
						{
							$abs_deduction_com = $basic_sal_com / $num_of_days * $absent;
							$abs_deduction_com = round($abs_deduction_com);
						}
					}
					else
					{
						$abs_deduction_com = $gross_sal_com;
					}
				*/
				
				//ADVANCE LOAN
				// shahajahan 11-0502022
				$advance_deduct = $this->advance_loan_deduction($emp_id, $salary_month);
				/*	//Khalid 01-08-21
				if($emp_sec_id == 5 || $emp_sec_id == 6){
				$advance_deduct = 0;
				}else{
				$advance_deduct = $this->advance_loan_deduction($emp_id, $salary_month);
				}*/
				
				//DEDUCTION
				$deduct_hour 	= 0;
				$deduct_amount 	= 0;
				if($deduct_status == "No")
				{
					//******deduct hour *****************************************************************
					$this->db->select('deduction_hour');
					$this->db->where("trim(substr(shift_log_date,1,7)) = '$salary_month'");
					$this->db->where("emp_id",$rows->emp_id);
					$query_ded = $this->db->get('pr_emp_shift_log');
					$total_deduction_hour = 0;
					foreach ($query_ded->result() as $row)
					{
						$deduction_hour = $row->deduction_hour;
						$total_deduction_hour = $total_deduction_hour + $deduction_hour;
					}
					$deduct_hour = $total_deduction_hour;
					
					//******End deduct hour ************************************************************************
					
					//************************deduct amount***************************************************** 
					$per_day_salary = $basic_sal/$num_of_days;
					$per_hour_salary = $per_day_salary /8;
					//echo $per_hour_salary;
					$deduct_amount = $per_hour_salary *$total_deduction_hour;
					$deduct_amount = 0;//round($deduct_amount);
					//************************end deduct amount***************************************************** 
				}
				
				//LATE DEDUCTION
				$late_count = $this->get_late_count($emp_id,$year,$month);
				$late_deduct = floor($late_count /4);		// 4times late = 1 Day Absent. 
				//$late_deduct_amount = round($gross_sal / $num_working_days * $late_deduct);
				
				//STAMP
				$stamp = $salary_structure['stamp'];
				$absent_plus_before_after_absent = $absent + $data["before_after_absent"];
				if($absent_plus_before_after_absent == $num_of_days)
				{
					$stamp = 0;
				}
				
				//OTHERS DEDUCTION
				$others_deduct = $this->others_deduct_cal($emp_id, $year_month);
				if($others_deduct == '')
				{
					$others_deduct = 0;
				}
				if($gross_sal == 0)
				{
					$others_deduct = 0;
				}
				
				$tax_deduct = $this->tax_deduct_cal($emp_id, $year_month);
				if($tax_deduct == '')
				{
					$tax_deduct = 0;
				}
				if($gross_sal == 0)
				{
					$tax_deduct = 0;
				}
								
				$total_deduction = $advance_deduct + $abs_deduction + $others_deduct + $tax_deduct + $stamp;
				
				$data["abs_deduction"] 		= $abs_deduction;
				$data["late_count"] 		= $late_count;
				$data["late_deduct"] 		= 0;
				$data["deduct_hour"] 		= $deduct_hour;
				$data["deduct_amount"] 		= $deduct_amount;
				$data["adv_deduct"] 		= $advance_deduct;
				$data["others_deduct"] 		= $others_deduct;
				$data["tax_deduct"] 		= $tax_deduct;
				$data["stamp"] 				= $stamp;
				$data["total_deduct"] 		= $total_deduction;
				
				//COMPLIENCE
				$total_deduction_com = $advance_deduct + $abs_deduction_com + $others_deduct + $tax_deduct + $stamp ;//+ $deduct_amount;
				
				
				$data_com["abs_deduction"] 		= $abs_deduction_com;
				$data_com["late_count"] 		= $late_count;
				$data_com["late_deduct"] 		= 0;
				$data_com["deduct_hour"] 		= 0;
				$data_com["deduct_amount"] 		= 0;
				$data_com["adv_deduct"] 		= $advance_deduct;
				$data_com["others_deduct"] 		= $others_deduct;
				$data_com["tax_deduct"] 		= $tax_deduct;
				$data_com["stamp"] 				= $stamp;
				$data_com["total_deduct"] 		= $total_deduction_com;
				
				//===========================END OF DEDUCTION STATUS==================================
				
				
				//=============================ALLOWANCES========================================
				//===============================================================================
				
				//ATTN. BONUS
				//$condition_late = $this->common_model->get_setup_attributes('3'); //2==if one is late for 2 day then attendance bonus will be cancelled
				$att_bouns_present_day = $attend + $weekend;	
				$eligible_att_bonus_days = $num_of_days - $holiday;
							
				if($att_bouns_present_day == $eligible_att_bonus_days)
				{
					//if($late_count < $condition_late)
					if($late_count ==0)
					{
						 $att_bouns = $this->att_bouns_cal($emp_id);
					}
					else
					{
						$att_bouns = 0;
					}
				}
				else
				{
					$att_bouns = 0;
				}

				
				//HOLIDAY ALLOWANCE (APPLICABLE FOR OT = NO)
				$holiday_alo_count 			= 0;
				$holiday_allowance_rate 	= 0;
				$holiday_allowance 			= 0;
				if($ot_check == 1){
					$holiday_alo_count 				= $this->get_holiday_alo_count($emp_id,$year,$month);
					$holiday_allowance_data 		= $this->holiday_allaw_cal($emp_id,$holiday_alo_count,$desi_id);
					$holiday_allowance 				= $holiday_allowance_data['holiday_allowance'];
					$holiday_allowance_rate 		= $holiday_allowance_data['holiday_allowance_rate'];
				}
				
				
				//HOLIDAY ALLOWANCE (APPLICABLE FOR OT = NO)
				$weekend_alo_count 			= 0;
				$weekend_allowance_rate 	= 0;
				$weekend_allowance 			= 0;
				if($ot_check == 1){
					$weekend_alo_count 				= $this->get_weekend_alo_count($emp_id,$year,$month);
					$weekend_allowance_data 		= $this->weekend_allaw_cal($emp_id,$weekend_alo_count,$desi_id);
					$weekend_allowance 				= $weekend_allowance_data['weekend_allowance'];
					$weekend_allowance_rate 		= $weekend_allowance_data['weekend_allowance_rate'];
				}
				
				
				//Night ALLOWANCE (APPLICABLE FOR OT = NO)
				/*if($ot_check == 0)
				{
					$night_alo_count 		= 0;
					$night_allowance_rate 	= 0;
					$night_allowance 		= 0;

				}
				else
				{*/
					$night_alo_count 			= $this->get_night_alo_count($emp_id,$year,$month);
					$night_allowance_data 		= $this->night_allaw_cal($emp_id,$night_alo_count,$desi_id);
					$night_allowance 			= $night_allowance_data['night_allowance'];
					$night_allowance_rate 		= $night_allowance_data['night_allowance_rate'];
				//}
				
				$total_allaw = $weekend_allowance + $holiday_allowance + $night_allowance;
				

				$data["att_bonus"] 				= $att_bouns;
				$data["holiday_alo_count"] 		= $holiday_alo_count;
				$data["holiday_allowance"] 		= $holiday_allowance;
				$data["holiday_allowance_rate"] = $holiday_allowance_rate;
				
				$data["weekend_alo_count"] 		= $weekend_alo_count;
				$data["weekend_allowance"] 		= $weekend_allowance;
				$data["weekend_allowance_rate"] = $weekend_allowance_rate;
				
				$data["night_alo_count"] 		= $night_alo_count;
				$data["night_allowance"] 		= $night_allowance;
				$data["night_allowance_rate"] 	= $night_allowance_rate;

				$data["total_allaw"] 			= $total_allaw;
				
				//COMPLIENCE
				$data_com["att_bonus"] 				= $att_bouns;
				$data_com["holiday_alo_count"] 		= $holiday_alo_count;
				$data_com["holiday_allowance"] 		= $holiday_allowance;
				$data_com["holiday_allowance_rate"] = $holiday_allowance_rate;
				
				$data_com["night_alo_count"] 		= $night_alo_count;
				$data_com["night_allowance"] 		= $night_allowance;
				$data_com["night_allowance_rate"] 	= $night_allowance_rate;

				$data_com["total_allaw"] 			= $total_allaw;
				
				
				//=========================================OVERTIME CALCULATION=============================================
				//==========================================================================================================
				
				//OT CALCULATION
				$ot_rate = $salary_structure['ot_rate'];
				if($ot_check == 0)
				{
					$ot_hour = $this->ot_hour($rows->emp_id, $year_month, $ot_rate);
					if($ot_hour == '')
					{
						$ot_hour = 0;
					}
					else
					{
						$ot_hour = $ot_hour;
					}
				}
				else
				{
				  $ot_hour = 0;
				  
				}
				// echo $ot_hour;exit;
				$ot_amount = round($ot_hour * $ot_rate);

				
				//EXTRA OT CALCULATION
				if($ot_check == 0)
				{
					$collect_eot_hour = $this->eot_hour($emp_id, $year_month);
					$ot_eot_12am_hour = $this->ot_eot_12am_hour($emp_id, $year_month);
					$ot_eot_4pm_hour = $this->ot_eot_4pm_hour($emp_id, $year_month);
					//THIS EOT IS INTRODUCE FOR SUPER ADMIN PRIVILEGE IN ACL
					$eot_hour_for_sa = $this->eot_hour_for_super_admin($emp_id, $year_month);
					
					$modify_eot_hour = $this->modify_eot_hour($emp_id, $year_month);
					if($ot_hour == '')
					{
						$collect_eot_hour = 0;
						$ot_eot_12am_hour = 0;
						$ot_eot_4pm_hour = 0;
						$modify_eot_hour = 0;
					}
					if($eot_hour_for_sa == '')
					{//echo "ase";
						$eot_hour_for_sa = 0;
					}
				}
				else
				{
				  $collect_eot_hour = 0;
				  $ot_eot_12am_hour = 0;
				  $ot_eot_4pm_hour = 0;
				  $modify_eot_hour = 0;
				  $eot_hour_for_sa = 0;
				}
				
				$eot_hour = $collect_eot_hour + $modify_eot_hour - $deduct_hour;
				//$ot_eot_12am_hr = $ot_eot_12am_hour + $modify_eot_hour - $deduct_hour;
				$ot_eot_12am_hr = $ot_eot_12am_hour;
				//$ot_eot_4pm_hr = $ot_eot_4pm_hour + $modify_eot_hour - $deduct_hour;
				$ot_eot_4pm_hr = $ot_eot_4pm_hour;
				
				$eot_amount = round($eot_hour * $ot_rate);
				$ot_eot_12am_amount = round($ot_eot_12am_hr * $ot_rate);
				$ot_eot_4pm_amount = round($ot_eot_4pm_hr * $ot_rate);
				
				//THIS EOT AMOUNT IS ALSO INTRODUCE FOR SUPER ADMIN PRIVILEGE IN ACL
				$eot_amount_for_sa = round($eot_hour_for_sa * $ot_rate);
				if($eot_hour<0)
				{
					$eot_amount=0;
					$ot_eot_12am_amount = 0;
					$ot_eot_4pm_amount = 0;
				}
				
				if($eot_hour_for_sa<0)
				{
					$eot_amount_for_sa=0;
					$ot_eot_12am_amount = 0;
					$ot_eot_4pm_amount = 0;
				}
				
				$data["ot_hour"] 			= $ot_hour;
				$data["ot_amount"] 			= $ot_amount;
				$data["ot_rate"] 			= $ot_rate;
				$data["collect_eot_hour"] 	= $collect_eot_hour;
				$data["modify_eot_hour"] 	= $modify_eot_hour;
				$data["eot_hour"] 			= $eot_hour;
				$data["eot_amount"] 		= $eot_amount;
				$data["ot_eot_12am_hour"] 	= $ot_eot_12am_hr;
				$data["ot_eot_12am_amt"] 	= $ot_eot_12am_amount;
				$data["ot_eot_4pm_hour"] 	= $ot_eot_4pm_hr;
				$data["ot_eot_4pm_amt"] 	= $ot_eot_4pm_amount;
				$data["salary_month"] 		= $start_date;
				$data["eot_hr_for_sa"] 		= $eot_hour_for_sa;
				$data["eot_amt_for_sa"] 	= $eot_amount_for_sa;
				
				
				//COMPLIENCE
				$data_com["ot_hour"] 			= $ot_hour;
				$data_com["ot_amount"] 			= $ot_amount;
				$data_com["ot_rate"] 			= $ot_rate;

				$data_com["collect_eot_hour"] 	= $collect_eot_hour;
				$data_com["modify_eot_hour"] 	= $modify_eot_hour;
				$data_com["eot_hour"] 			= $eot_hour;
				$data_com["eot_amount"] 		= $eot_amount;
				$data_com["ot_eot_12am_hour"] 	= $ot_eot_12am_hr;
				$data_com["ot_eot_12am_amt"] 	= $ot_eot_12am_amount;
				$data_com["ot_eot_4pm_hour"] 	= $ot_eot_4pm_hr;
				$data_com["ot_eot_4pm_amt"] 	= $ot_eot_4pm_amount;
				$data_com["salary_month"] 		= $start_date;
		
				//***************************Festival bonus***********************
				/*$effective_date = $this->get_bonus_effective_date($salary_month);
				if($effective_date != false)
				{
					//$doj = "2013-05-06";
					$service_month = $this->common_model->get_service_month($effective_date,$doj);
					
					//echo "$effective_date ===$doj====$service_month"; 
					if($service_month >= 11)
					{
						$festival_bonus_rule 	= $this->get_festival_bonus_rule($service_month);
						$festival_bonus 		= $this->get_festival_bonus($festival_bonus_rule,$gross_sal,$basic_sal);
						$festival_bonus_com 	= $this->get_festival_bonus($festival_bonus_rule,$gross_sal_com,$basic_sal_com);
					}
					else 
					{ 
						$desig_bonus_rules = $this->get_desig_bonus_rules($effective_date,$desi_id); 
						if($desig_bonus_rules['msg'] == "OK" )
						{
							$festival_bonus 	= $desig_bonus_rules['bonus_amount'];
							$rules_name 		= $desig_bonus_rules['rules_name'];
							$festival_bonus_com = $desig_bonus_rules['bonus_amount'];
						}
						else
						{
							$festival_bonus 	= 0;
							$festival_bonus_com = 0;
						}
					}
				}
				else
				{
					$festival_bonus 	= 0;
					$festival_bonus_com = 0;
				}*/
				$festival_bonus 	= 0;
				$festival_bonus_com = 0;
				$data["festival_bonus"] 	= $festival_bonus;
				$data_com["festival_bonus"] = $festival_bonus_com;
				
				//***************************End of Festival bonus***********************//
				
				//***Net Pay Edited By Tarek On 22-10-2016 For Stapm Deduction Whose Net Pay less than 500***//
				$net_pay = $gross_sal + $att_bouns + $ot_amount - $total_deduction ;
				
				if($net_pay < 510)
				{
					$data["stamp"] 				= 0;
					$data["total_deduct"] 		= $advance_deduct + $abs_deduction + $others_deduct + $tax_deduct + 0;
					
					$data["net_pay"] 			= $net_pay;   // ($net_pay + 10) remove 28-11-2023
				}
				else
				{
					$data["net_pay"] = $net_pay;
				}
				
				
				//COMPLIENCE
				$net_pay_com = $gross_sal_com + $att_bouns + $ot_amount - $total_deduction_com ;//Zuel 140420
				
				if($net_pay_com < 510)
				{
					$data_com["stamp"] 				= 0;
					$data_com["total_deduct"] 		= $advance_deduct + $abs_deduction_com + $others_deduct + $tax_deduct + 0 ;
					
					$data_com["net_pay"] 			= $net_pay_com;  // ($net_pay_com + 10) remove 28-11-2023
				}
				else
				{
					$data_com["net_pay"] = $net_pay_com;
				}

				//print_r($data);
				echo "<pre>";print_r($data);exit;

				$this->db->select("emp_id");
				$this->db->where("emp_id", $rows->emp_id);
				$this->db->where("salary_month", $start_date);
				$query = $this->db->get("pr_pay_scale_sheet");
				
				if($query->num_rows() > 0 )
				{
					//echo "hello";
					$this->db->where("emp_id", $rows->emp_id);
					$this->db->where("salary_month", $start_date);
					$this->db->update("pr_pay_scale_sheet",$data);
				}
				else
				{
					$this->db->insert("pr_pay_scale_sheet",$data);

				}
				
				
				//COMPLIENCE
				$this->db->select("emp_id");
				$this->db->where("emp_id", $rows->emp_id);
				$this->db->where("salary_month", $start_date);
				$query = $this->db->get("pr_pay_scale_sheet_com");

				// echo "<pre>";print_r($data_com);exit;
				
				if($query->num_rows() > 0 )
				{
					//echo "hello";
					$this->db->where("emp_id", $rows->emp_id);
					$this->db->where("salary_month", $start_date);
					$this->db->update("pr_pay_scale_sheet_com",$data_com);
				}
				else
				{
					$this->db->insert("pr_pay_scale_sheet_com",$data_com);
				}
			}
		}
			//$data["deduct_status"] = $deduct_status;
			return "Process completed successfully";
		}
	}




	///////////  old code ////////////////////////
	///////////  old code ////////////////////////
	function pay_sheet($year, $month,$process_check,$grid_emp_id)
	{
		$year_v=$year;
		$month_v=$month;
		
		$table_name = "att_".$year_v."_".$month_v;
		
		//PROCESS MONTH EXISTANCE CHECK
		if(!$this->db->table_exists($table_name))
		{
			return "Process month does not exist, please change your process month";
		}
		
		//SALARY BLOCK CHECK
		$unit_id = $this->common_model->get_session_unit_id_name();
		$start_date = date("Y-m-d", mktime(0, 0, 0, $month_v, 1, $year_v));
		$next_month_year = date("Y-m",strtotime("-1 month",strtotime($start_date)));
		$num_row_month_year = $this->db->like('block_month',$next_month_year)->where('unit_id',$unit_id)->get('pr_salary_block')->num_rows();
		if($num_row_month_year < 1  && $unit_id != 4)
		{
			return "Please Finally Processed Previous Month..";
		}
	
		$year_month = "$year_v-$month_v";
		
		if($unit_id == 0){return "Please Login As an Unit User.";}
		$num_row 	= $this->db->like('block_month',$year_month)->where('unit_id',$unit_id)->get('pr_salary_block')->num_rows();

		if($num_row > 0  && $unit_id != 4)
		{
			return "This Month Already Finally Processed.";
		}
		
		//INSERT BLOCK RECORD
		if($process_check == "2")
		{
		  $block_year_month 		= "$year_month-01";
		  $data_1['block_month'] 	= $block_year_month;
		  $data_1['unit_id'] 		= $unit_id;
		  $data_1['username'] 		= $this->session->userdata('username');
		  $data_1['date_time'] 		= date("Y-m-d H:i:s");
		  $this->db->insert('pr_salary_block', $data_1); 
		  //echo $this->db->last_query();
		}
		
		
		$last_date = date("t", mktime(0, 0, 0, $month_v, 1, $year_v));
		
		$end_date = date("Y-m-d", mktime(0, 0, 0, $month_v, $last_date, $year_v));
		
		$year_month = date("Y-m", mktime(0, 0, 0, $month_v, 1, $year_v)); 
		//---5=friday----------------//
		$day_of_week_v=5;   //==== please change this variable $fd = "next Friday"; if you change $day_of_week_v =====//
		
		
		$result=$this->find_week($year_v,$month_v,$day_of_week_v);
		//$num_working_days = $result['no_of_working_days'];
		$num_of_days = $result['num_of_days'];
		
		//$att_register = $this->daily_absent_db($start_date);
		$deduct_id =1;
		$deduct_status = $this->common_model->get_setup_attributes($deduct_id);
		
		//echo $deduct_status ;
		
		
		//print_r($result);
	  $arr = array('1003247','1004461','1004448','1004447','3001134','3001112');
		
		$this->db->select("emp_id,gross_sal,emp_sal_gra_id,emp_desi_id,emp_join_date,salary_type,emp_sec_id,ot_entitle,com_gross_sal,emp_dept_id,emp_line_id,emp_cat_id,");
		$this->db->where("unit_id",$unit_id);
		$this->db->where_in("emp_id",$grid_emp_id);
		// $this->db->where("emp_id","2005818");
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
				
				
				//============GENERAL INFORMATION======================
				//=================================================================
				$emp_name 		= $this->emp_name($rows->emp_id);
				$emp_id 		= $rows->emp_id; 
				$desi_id 		= $rows->emp_desi_id;
				$emp_sec_id 	= $rows->emp_sec_id;
				$emp_desig 		= $this->emp_desig($rows->emp_desi_id);
				
				$emp_dept_id	= $rows->emp_dept_id;
				$emp_line_id	= $rows->emp_line_id;
				$emp_cat_id		= $rows->emp_cat_id;
				
				
				$doj 			= $rows->emp_join_date;
				$gross_sal 		= $rows->gross_sal;
				$gross_sal_com 	= $rows->com_gross_sal;
				$ot_check 		= $rows->ot_entitle;
				
				$salary_process_eligibility = $this->salary_process_eligibility($emp_id, $start_date);
				
				if($salary_process_eligibility == true)
				{
				//==========FOR INCREMENT AND PROMOTION=
				//==========================================================
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
						$gross_sal_com 	= $row->new_salary;
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
							$gross_sal_com 	= $row->prev_salary;
						}
					}
					else
					{
						echo "";
					}
				
				}
				//=========================END INCREMENT AND PROMOTION===
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
				
				$stop_salary			=$this->stop_salary_check($emp_id,$start_date);
				$data["stop_salary"]	= $stop_salary;
				$data["basic_sal"] 		= $basic_sal;
				$data["house_r"] 		= $house_rent;
				$data["medical_a"] 		= $madical_allo;
				$data["food_allow"] 	= $food_allow;
				$data["trans_allow"] 	= $trans_allow;
				$data["gross_sal"] 		= $gross_sal;
				$data["total_days"] 	= $num_of_days;
				//$data["num_of_workday"] = $no_working_days;
				
				//COMPLIENCE
				$salary_structure_com 		= $this->common_model->salary_structure($gross_sal_com);
				$basic_sal_com 				= $salary_structure_com['basic_sal'];
				$madical_allo_com 			= $salary_structure_com['medical_allow'];
				$house_rent_com 			= $salary_structure_com['house_rent'];
				$trans_allow_com 			= $salary_structure_com['trans_allow'];
				$food_allow_com 			= $salary_structure_com['food_allow'];
				
				$total_sal_com = $basic_sal_com + $madical_allo_com + $house_rent_com + $trans_allow_com + $food_allow_com; 
				$data_com["emp_id"] 		= $emp_id;
				$data_com["unit_id"] 		= $unit_id;
				$data_com["sec_id"] 		= $emp_sec_id;
				$data_com["desig_id"] 		= $desi_id;
				$data_com["dept_id"] 		= $emp_dept_id;
				$data_com["line_id"] 		= $emp_line_id;
				$data_com["emp_status"] 	= $emp_cat_id;
				$data_com["emp_sex"] 		= $this->db->where("emp_id",$emp_id)->get('pr_emp_per_info')->row()->emp_sex;
				$data_com["stop_salary"]	= 1;
				$data_com["basic_sal"] 		= $basic_sal_com;
				$data_com["house_r"] 		= $house_rent_com;
				$data_com["medical_a"] 		= $madical_allo_com;
				$data_com["food_allow"] 	= $food_allow_com;
				$data_com["trans_allow"] 	= $trans_allow_com;
				$data_com["gross_sal"] 		= $gross_sal_com;
				$data_com["total_days"] 	= $num_of_days;
				//$data_com["num_of_workday"] = $no_working_days;
				
				//===========END GENERAL INFORMATION==================
				
				
				
				//=========PRESENT STATUS========================
				//==============================================================
				$salary_month = trim(substr($start_date,0,7));
				$join_month = trim(substr($doj,0,7));

				$resign_check 	= $this->resign_check($emp_id, $salary_month);
				$left_check 	= $this->left_check($emp_id, $salary_month);
				if($resign_check != false and $salary_month == $join_month){
					$total_days = $resign_check['resign_day'];
					$left_or_resign_date = $resign_check['resign_date'];
					$resign_data = $this->get_resign_month_dates($resign_check['resign_day'], $salary_month);
					$resign_after_absent = $this->resign_day_count($resign_data['resign_3rd_date'],$resign_data['resign_2nd_count']);
					
					$search_date = $doj;
					$doj_data = $this->get_join_month_dates($doj);
					$doj_before_absent = $this->new_join_day_count($doj_data['doj_1st_date'], $doj_data['doj_3rd_date']);
					
					$before_after_absent = $resign_after_absent+$doj_before_absent;
				}
				elseif($left_check != false and $salary_month == $join_month){
					$total_days = $left_check['left_day'];
					$left_or_resign_date = $left_check['left_date'];
					$resign_data = $this->get_resign_month_dates($left_check['left_day'], $salary_month);
					if($salary_month == $join_month){
						$search_date = $doj;
					}else{
						$search_date = $resign_data['resign_1st_date'];
					}
					$doj_data = $this->get_join_month_dates($doj);
					$doj_before_absent = $this->new_join_day_count($doj_data['doj_1st_date'], $doj_data['doj_3rd_date']);	
					$resign_after_absent = $this->resign_day_count($resign_data['resign_3rd_date'],$resign_data['resign_2nd_count']);
					$before_after_absent = $doj_before_absent+$resign_after_absent;
				}
				elseif($resign_check != false){
					$total_days = $resign_check['resign_day'];
					$left_or_resign_date = $resign_check['resign_date'];
					$resign_data = $this->get_resign_month_dates($resign_check['resign_day'], $salary_month);
					$search_date = $resign_data['resign_1st_date'];
					$resign_after_absent = $this->resign_day_count($resign_data['resign_3rd_date'],$resign_data['resign_2nd_count']);
					$before_after_absent = $resign_after_absent;
				}
				elseif($salary_month == $join_month){
					$search_date = $doj;
					$doj_data = $this->get_join_month_dates($doj);
					$doj_before_absent = $this->new_join_day_count($doj_data['doj_1st_date'], $doj_data['doj_3rd_date']);					
					$total_days = $num_of_days;
					$left_or_resign_date = $end_date;
					$before_after_absent = $doj_before_absent;
				}
				elseif($left_check != false){
					$total_days = $left_check['left_day'];
					$left_or_resign_date = $left_check['left_date'];
					$resign_data = $this->get_resign_month_dates($left_check['left_day'], $salary_month);
					if($salary_month == $join_month){
						$search_date = $doj;
					}	
					else{
						$search_date = $resign_data['resign_1st_date'];
					}
					$resign_after_absent = $this->resign_day_count($resign_data['resign_3rd_date'],$resign_data['resign_2nd_count']);
					$before_after_absent = $resign_after_absent;
				}
				else{
					$total_days = $num_of_days;
					$search_date = $start_date;
					$before_after_absent = 0;
					$left_or_resign_date = $end_date;
				}
	
				
				$absent = "A";
				$absent = $this->attendance_check($rows->emp_id,$absent,$total_days, $search_date);
				$attend = "P";
				$attend = $this->attendance_check($rows->emp_id,$attend,$total_days, $search_date);
				
				$leave_type = "cl";
				$cas_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "sl";
				$sick_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "el";
				$earn_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "ml";
				$m_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "wp";
				$wp_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				$leave_type = "do";
				$do_leave = $this->leave_db($rows->emp_id, $search_date, $left_or_resign_date, $leave_type);
				
				$total_leave 		= $cas_leave + $sick_leave + $m_leave + $earn_leave + $wp_leave;//e + $do_leave;
				$total_pay_leave 	= $cas_leave + $sick_leave + $m_leave + $earn_leave;// $wp_leave + $do_leave;
				
				$weekend = "W";
				$weekend = $this->attendance_check($rows->emp_id,$weekend,$total_days, $search_date);
				$holiday = "H";
				$holiday = $this->attendance_check($rows->emp_id,$holiday,$total_days, $search_date);
				
				//$num_working_days 	= $num_of_days - $weekend - $before_after_absent;
				$num_working_days 	= $num_of_days - $holiday - $weekend - $before_after_absent;
				$total_holiday 		= $weekend + $holiday;
				//echo $m_leave.'+'.$attend .'+'. $total_holiday .'+'. $total_pay_leave;
				$pay_days = $attend + $total_holiday + $total_pay_leave-$m_leave;
				
								
				$data["num_of_workday"] 		= $num_working_days;
				$data["att_days"] 				= $attend;
				$data["absent_days"] 			= $absent;
				$data["before_after_absent"] 	= $before_after_absent;
				
				$data["c_l"] 					= $cas_leave;
				$data["s_l"] 					= $sick_leave;
				$data["e_l"] 					= $earn_leave;
				$data["m_l"] 					= $m_leave;
				$data["wp"] 					= $wp_leave ;//+ $do_leave;
				$data["total_leave"] 			= $total_leave ;
				$data["total_pay_leave"] 		= $total_pay_leave ;
				
				$data["holiday"] 				= $holiday;
				$data["weekend"] 				= $weekend;
				$data["total_holiday"] 			= $total_holiday;
				$data["pay_days"] 				= $pay_days;
				
				//COMPLIENCE
				$data_com["num_of_workday"] 		= $num_working_days;
				$data_com["att_days"] 				= $attend;
				$data_com["absent_days"] 			= $absent;
				$data_com["before_after_absent"] 	= $before_after_absent;
				
				$data_com["c_l"] 					= $cas_leave;
				$data_com["s_l"] 					= $sick_leave;
				$data_com["e_l"] 					= $earn_leave;
				$data_com["m_l"] 					= $m_leave;
				$data_com["wp"] 					= $wp_leave ;//+ $do_leave;
				$data_com["total_leave"] 			= $total_leave ;
				$data_com["total_pay_leave"] 		= $total_pay_leave ;
				
				$data_com["holiday"] 				= $holiday;
				$data_com["weekend"] 				= $weekend;
				$data_com["total_holiday"] 			= $total_holiday;
				$data_com["pay_days"] 				= $pay_days;

				// echo "<pre>";print_r($data_com);exit();
				
				
				//==========END PRESENT sTATUS=================
				
				//=======DEDUCTION STATUS======================
				//==============================================================
				
				//========DEDUCTION STATUS=======================
				//==============================================================
				
				//==============================Maternity leave calculation==============================
				if($m_leave > 0)
				{
					$per_day_salary_for_gross = $gross_sal/$num_of_days;
					$ml_payment = round($m_leave * $per_day_salary_for_gross);
					// print_r($ml_payment);exit('ali');
					$data_ml["emp_id"] 			= $rows->emp_id;
					$data_ml["food_allow"] 		= $food_allow;
					$data_ml["trans_allaw"] 	= $trans_allow;
					$data_ml["basic_sal"] 		= $basic_sal;
					$data_ml["house_r"] 		= $house_rent;
					$data_ml["medical_a"] 		= $madical_allo;
					$data_ml["gross_sal"] 		= $gross_sal;
					$data_ml["total_days"] 		= $num_of_days;
					//$data_ml["num_of_workday"] 	= $no_working_days;
					$data_ml["m_leave"] 		= $m_leave;
					$data_ml["ml_payment"] 		= $ml_payment;
					$data_ml["salary_month"] 	= $start_date;
				}
				//ABSENT DEDUCTION FOR NON-COMPLIENCE		
				$sal_month = date("Y-m-d", mktime(0, 0, 0, $month_v, 1, $year_v));
				// print_r($data_com);exit;

				
				if($data_com["m_l"] !=''){
					$num_of_days_n = date('t',strtotime($sal_month));
				}
				else{
					$num_of_days_n = 30;
				}

				// print_r($num_of_days_n);exit;

				$p_sal_month = '2018-02-01';
				
				if( $sal_month > $p_sal_month){

					if($pay_days != 0){
						// echo $num_of_days_n .' = '. $num_of_days; exit();
						$absent = $absent + $wp_leave ;
						if($resign_check != false or $left_check != false){
							$before_after_deduct = $gross_sal / $num_of_days * $data["before_after_absent"];
							//$abs_deduction = $gross_sal / $num_of_days_n * $absent;
							$abs_deduction = $basic_sal / $num_of_days_n * $absent;
							$ml_deduct = $gross_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
						}
						else if($salary_month == $join_month){
							$before_after_deduct = $gross_sal / $num_of_days * $data["before_after_absent"];
							//$abs_deduction = $gross_sal / $num_of_days_n * $absent;
							$abs_deduction = $basic_sal / $num_of_days_n * $absent;
							$ml_deduct = $basic_sal / $num_of_days_n * $m_leave;
							$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
						}
						else{
							//echo "here";
							$abs_deduction = $basic_sal / $num_of_days_n * $absent;
							$ml_deduct = $gross_sal / $num_of_days_n * $m_leave;
							// print_r($ml_deduct);exit('aaa');
							$abs_deduction = round($abs_deduction+$ml_deduct);
							//$abs_deduction = round($abs_deduction);
						}
					} else{
						$abs_deduction = $gross_sal;
					}
					
					
					//ABSENT DEDUCTION FOR COMPLIANCE
					if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal_com / $num_of_days * $data["before_after_absent"];
							$abs_deduction_com = $gross_sal_com / $num_of_days_n * $absent;
							$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
						}
						else if($salary_month == $join_month)
						{
							$before_after_deduct = $gross_sal_com / $num_of_days * $data["before_after_absent"];
							$abs_deduction_com = $basic_sal_com / $num_of_days_n * $absent;
							$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
						}
						else
						{
							$abs_deduction_com = $basic_sal_com / $num_of_days_n * $absent;
							$abs_deduction_com = round($abs_deduction_com);
						}
					}
					else
					{
						$abs_deduction_com = $gross_sal_com;
					}

				}
				else
				{
					if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($salary_month == $join_month or $resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal / $num_of_days * $data["before_after_absent"];
							$abs_deduction = $gross_sal / $num_of_days_n * $absent;
							$ml_deduct = $basic_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
							if($salary_month != $join_month and ($resign_check != false or $left_check != false) and $pay_days >= 15)
							{
								$before_after_deduct = $basic_sal / $num_of_days * $data["before_after_absent"];
								$abs_deduction = $basic_sal / $num_of_days * $absent;
								$ml_deduct = $basic_sal / $num_of_days * $m_leave;
								$abs_deduction = round($abs_deduction + $before_after_deduct+$ml_deduct);	
							}
						}
						else
						{
							$abs_deduction = $basic_sal / $num_of_days * $absent;
							$ml_deduct = $basic_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction+$ml_deduct);
						}
					}
					else
					{
						$abs_deduction = $gross_sal;
					}
					
					
					//ABSENT DEDUCTION FOR COMPLIANCE
					if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($salary_month == $join_month or $resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal_com / $num_of_days * $data["before_after_absent"];
							$abs_deduction_com = $basic_sal_com / $num_of_days_n * $absent;
							$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
						}
						else
						{
							$abs_deduction_com = $basic_sal_com / $num_of_days * $absent;
							$abs_deduction_com = round($abs_deduction_com);
						}
					}
					else
					{
						$abs_deduction_com = $gross_sal_com;
					}

				}
				
				/*if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($salary_month == $join_month or $resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal / $num_of_days * $data["before_after_absent"];
							$abs_deduction = $gross_sal / $num_of_days * $absent;
							$ml_deduct = $basic_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
							if($salary_month != $join_month and ($resign_check != false or $left_check != false) and $pay_days >= 15)
							{
								$before_after_deduct = $basic_sal / $num_of_days * $data["before_after_absent"];
								$abs_deduction = $basic_sal / $num_of_days * $absent;
								$ml_deduct = $basic_sal / $num_of_days * $m_leave;
								$abs_deduction = round($abs_deduction + $before_after_deduct+$ml_deduct);	
							}
						}
						else
						{
							$abs_deduction = $basic_sal / $num_of_days * $absent;
							$ml_deduct = $basic_sal / $num_of_days * $m_leave;
							$abs_deduction = round($abs_deduction+$ml_deduct);
						}
					}
					else
					{
						$abs_deduction = $gross_sal;
					}
					
					
					//ABSENT DEDUCTION FOR COMPLIANCE
					if($pay_days != 0)
					{
						$absent = $absent + $wp_leave ;
						if($salary_month == $join_month or $resign_check != false or $left_check != false)
						{
							$before_after_deduct = $gross_sal_com / $num_of_days * $data["before_after_absent"];
							$abs_deduction_com = $basic_sal_com / $num_of_days * $absent;
							$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
						}
						else
						{
							$abs_deduction_com = $basic_sal_com / $num_of_days * $absent;
							$abs_deduction_com = round($abs_deduction_com);
						}
					}
					else
					{
						$abs_deduction_com = $gross_sal_com;
					}
				*/
				
				//ADVANCE LOAN
				// shahajahan 11-0502022
				$advance_deduct = $this->advance_loan_deduction($emp_id, $salary_month);
				/*	//Khalid 01-08-21
				if($emp_sec_id == 5 || $emp_sec_id == 6){
				$advance_deduct = 0;
				}else{
				$advance_deduct = $this->advance_loan_deduction($emp_id, $salary_month);
				}*/
				
				//DEDUCTION
				$deduct_hour 	= 0;
				$deduct_amount 	= 0;
				if($deduct_status == "No")
				{
					//******deduct hour *****************************************************************
					$this->db->select('deduction_hour');
					$this->db->where("trim(substr(shift_log_date,1,7)) = '$salary_month'");
					$this->db->where("emp_id",$rows->emp_id);
					$query_ded = $this->db->get('pr_emp_shift_log');
					$total_deduction_hour = 0;
					foreach ($query_ded->result() as $row)
					{
						$deduction_hour = $row->deduction_hour;
						$total_deduction_hour = $total_deduction_hour + $deduction_hour;
					}
					$deduct_hour = $total_deduction_hour;
					
					//******End deduct hour ************************************************************************
					
					//************************deduct amount***************************************************** 
					$per_day_salary = $basic_sal/$num_of_days;
					$per_hour_salary = $per_day_salary /8;
					//echo $per_hour_salary;
					$deduct_amount = $per_hour_salary *$total_deduction_hour;
					$deduct_amount = 0;//round($deduct_amount);
					//************************end deduct amount***************************************************** 
				}
				
				//LATE DEDUCTION
				$late_count = $this->get_late_count($emp_id,$year,$month);
				$late_deduct = floor($late_count /4);		// 4times late = 1 Day Absent. 
				//$late_deduct_amount = round($gross_sal / $num_working_days * $late_deduct);
				
				//STAMP
				$stamp = $salary_structure['stamp'];
				$absent_plus_before_after_absent = $absent + $data["before_after_absent"];
				if($absent_plus_before_after_absent == $num_of_days)
				{
					$stamp = 0;
				}
				
				//OTHERS DEDUCTION
				$others_deduct = $this->others_deduct_cal($emp_id, $year_month);
				if($others_deduct == '')
				{
					$others_deduct = 0;
				}
				if($gross_sal == 0)
				{
					$others_deduct = 0;
				}
				
				$tax_deduct = $this->tax_deduct_cal($emp_id, $year_month);
				if($tax_deduct == '')
				{
					$tax_deduct = 0;
				}
				if($gross_sal == 0)
				{
					$tax_deduct = 0;
				}
								
				$total_deduction = $advance_deduct + $abs_deduction + $others_deduct + $tax_deduct + $stamp;
				
				$data["abs_deduction"] 		= $abs_deduction;
				$data["late_count"] 		= $late_count;
				$data["late_deduct"] 		= 0;
				$data["deduct_hour"] 		= $deduct_hour;
				$data["deduct_amount"] 		= $deduct_amount;
				$data["adv_deduct"] 		= $advance_deduct;
				$data["others_deduct"] 		= $others_deduct;
				$data["tax_deduct"] 		= $tax_deduct;
				$data["stamp"] 				= $stamp;
				$data["total_deduct"] 		= $total_deduction;
				
				//COMPLIENCE
				$total_deduction_com = $advance_deduct + $abs_deduction_com + $others_deduct + $tax_deduct + $stamp ;//+ $deduct_amount;
				
				
				$data_com["abs_deduction"] 		= $abs_deduction_com;
				$data_com["late_count"] 		= $late_count;
				$data_com["late_deduct"] 		= 0;
				$data_com["deduct_hour"] 		= 0;
				$data_com["deduct_amount"] 		= 0;
				$data_com["adv_deduct"] 		= $advance_deduct;
				$data_com["others_deduct"] 		= $others_deduct;
				$data_com["tax_deduct"] 		= $tax_deduct;
				$data_com["stamp"] 				= $stamp;
				$data_com["total_deduct"] 		= $total_deduction_com;
				
				//===========================END OF DEDUCTION STATUS==================================
				
				
				//=============================ALLOWANCES========================================
				//===============================================================================
				
				//ATTN. BONUS
				//$condition_late = $this->common_model->get_setup_attributes('3'); //2==if one is late for 2 day then attendance bonus will be cancelled
				$att_bouns_present_day = $attend + $weekend;	
				$eligible_att_bonus_days = $num_of_days - $holiday;
							
				if($att_bouns_present_day == $eligible_att_bonus_days)
				{
					//if($late_count < $condition_late)
					if($late_count ==0)
					{
						 $att_bouns = $this->att_bouns_cal($emp_id);
					}
					else
					{
						$att_bouns = 0;
					}
				}
				else
				{
					$att_bouns = 0;
				}
				
				
				//HOLIDAY ALLOWANCE (APPLICABLE FOR OT = NO)
				$holiday_alo_count 			= 0;
				$holiday_allowance_rate 	= 0;
				$holiday_allowance 			= 0;
				if($ot_check == 1){
					$holiday_alo_count 				= $this->get_holiday_alo_count($emp_id,$year,$month);
					$holiday_allowance_data 		= $this->holiday_allaw_cal($emp_id,$holiday_alo_count,$desi_id);
					$holiday_allowance 				= $holiday_allowance_data['holiday_allowance'];
					$holiday_allowance_rate 		= $holiday_allowance_data['holiday_allowance_rate'];
				}
				
				
				//HOLIDAY ALLOWANCE (APPLICABLE FOR OT = NO)
				$weekend_alo_count 			= 0;
				$weekend_allowance_rate 	= 0;
				$weekend_allowance 			= 0;
				if($ot_check == 1){
					$weekend_alo_count 				= $this->get_weekend_alo_count($emp_id,$year,$month);
					$weekend_allowance_data 		= $this->weekend_allaw_cal($emp_id,$weekend_alo_count,$desi_id);
					$weekend_allowance 				= $weekend_allowance_data['weekend_allowance'];
					$weekend_allowance_rate 		= $weekend_allowance_data['weekend_allowance_rate'];
				}
				
				
				//Night ALLOWANCE (APPLICABLE FOR OT = NO)
				/*if($ot_check == 0)
				{
					$night_alo_count 		= 0;
					$night_allowance_rate 	= 0;
					$night_allowance 		= 0;

				}
				else
				{*/
					$night_alo_count 			= $this->get_night_alo_count($emp_id,$year,$month);
					$night_allowance_data 		= $this->night_allaw_cal($emp_id,$night_alo_count,$desi_id);
					$night_allowance 			= $night_allowance_data['night_allowance'];
					$night_allowance_rate 		= $night_allowance_data['night_allowance_rate'];
				//}
				
				$total_allaw = $weekend_allowance + $holiday_allowance + $night_allowance;
				

				$data["att_bonus"] 				= $att_bouns;
				$data["holiday_alo_count"] 		= $holiday_alo_count;
				$data["holiday_allowance"] 		= $holiday_allowance;
				$data["holiday_allowance_rate"] = $holiday_allowance_rate;
				
				$data["weekend_alo_count"] 		= $weekend_alo_count;
				$data["weekend_allowance"] 		= $weekend_allowance;
				$data["weekend_allowance_rate"] = $weekend_allowance_rate;
				
				$data["night_alo_count"] 		= $night_alo_count;
				$data["night_allowance"] 		= $night_allowance;
				$data["night_allowance_rate"] 	= $night_allowance_rate;

				$data["total_allaw"] 			= $total_allaw;
				
				//COMPLIENCE
				$data_com["att_bonus"] 				= $att_bouns;
				$data_com["holiday_alo_count"] 		= $holiday_alo_count;
				$data_com["holiday_allowance"] 		= $holiday_allowance;
				$data_com["holiday_allowance_rate"] = $holiday_allowance_rate;
				
				$data_com["night_alo_count"] 		= $night_alo_count;
				$data_com["night_allowance"] 		= $night_allowance;
				$data_com["night_allowance_rate"] 	= $night_allowance_rate;

				$data_com["total_allaw"] 			= $total_allaw;
				
				
				//=========================================OVERTIME CALCULATION=============================================
				//==========================================================================================================
				
				//OT CALCULATION
				$ot_rate = $salary_structure['ot_rate'];
				if($ot_check == 0)
				{
					$ot_hour = $this->ot_hour($rows->emp_id, $year_month, $ot_rate);
					if($ot_hour == '')
					{
						$ot_hour = 0;
					}
					else
					{
						$ot_hour = $ot_hour;
					}
				}
				else
				{
				  $ot_hour = 0;
				  
				}
				// echo $ot_hour;exit;
				$ot_amount = round($ot_hour * $ot_rate);

				
				//EXTRA OT CALCULATION
				if($ot_check == 0)
				{
					$collect_eot_hour = $this->eot_hour($emp_id, $year_month);
					$ot_eot_12am_hour = $this->ot_eot_12am_hour($emp_id, $year_month);
					$ot_eot_4pm_hour = $this->ot_eot_4pm_hour($emp_id, $year_month);
					//THIS EOT IS INTRODUCE FOR SUPER ADMIN PRIVILEGE IN ACL
					$eot_hour_for_sa = $this->eot_hour_for_super_admin($emp_id, $year_month);
					
					$modify_eot_hour = $this->modify_eot_hour($emp_id, $year_month);
					if($ot_hour == '')
					{
						$collect_eot_hour = 0;
						$ot_eot_12am_hour = 0;
						$ot_eot_4pm_hour = 0;
						$modify_eot_hour = 0;
					}
					if($eot_hour_for_sa == '')
					{//echo "ase";
						$eot_hour_for_sa = 0;
					}
				}
				else
				{
				  $collect_eot_hour = 0;
				  $ot_eot_12am_hour = 0;
				  $ot_eot_4pm_hour = 0;
				  $modify_eot_hour = 0;
				  $eot_hour_for_sa = 0;
				}
				
				$eot_hour = $collect_eot_hour + $modify_eot_hour - $deduct_hour;
				//$ot_eot_12am_hr = $ot_eot_12am_hour + $modify_eot_hour - $deduct_hour;
				$ot_eot_12am_hr = $ot_eot_12am_hour;
				//$ot_eot_4pm_hr = $ot_eot_4pm_hour + $modify_eot_hour - $deduct_hour;
				$ot_eot_4pm_hr = $ot_eot_4pm_hour;
				
				$eot_amount = round($eot_hour * $ot_rate);
				$ot_eot_12am_amount = round($ot_eot_12am_hr * $ot_rate);
				$ot_eot_4pm_amount = round($ot_eot_4pm_hr * $ot_rate);
				
				//THIS EOT AMOUNT IS ALSO INTRODUCE FOR SUPER ADMIN PRIVILEGE IN ACL
				$eot_amount_for_sa = round($eot_hour_for_sa * $ot_rate);
				if($eot_hour<0)
				{
					$eot_amount=0;
					$ot_eot_12am_amount = 0;
					$ot_eot_4pm_amount = 0;
				}
				
				if($eot_hour_for_sa<0)
				{
					$eot_amount_for_sa=0;
					$ot_eot_12am_amount = 0;
					$ot_eot_4pm_amount = 0;
				}
				
				$data["ot_hour"] 			= $ot_hour;
				$data["ot_amount"] 			= $ot_amount;
				$data["ot_rate"] 			= $ot_rate;
				$data["collect_eot_hour"] 	= $collect_eot_hour;
				$data["modify_eot_hour"] 	= $modify_eot_hour;
				$data["eot_hour"] 			= $eot_hour;
				$data["eot_amount"] 		= $eot_amount;
				$data["ot_eot_12am_hour"] 	= $ot_eot_12am_hr;
				$data["ot_eot_12am_amt"] 	= $ot_eot_12am_amount;
				$data["ot_eot_4pm_hour"] 	= $ot_eot_4pm_hr;
				$data["ot_eot_4pm_amt"] 	= $ot_eot_4pm_amount;
				$data["salary_month"] 		= $start_date;
				$data["eot_hr_for_sa"] 		= $eot_hour_for_sa;
				$data["eot_amt_for_sa"] 	= $eot_amount_for_sa;
				
				
				//COMPLIENCE
				$data_com["ot_hour"] 			= $ot_hour;
				$data_com["ot_amount"] 			= $ot_amount;
				$data_com["ot_rate"] 			= $ot_rate;

				$data_com["collect_eot_hour"] 	= $collect_eot_hour;
				$data_com["modify_eot_hour"] 	= $modify_eot_hour;
				$data_com["eot_hour"] 			= $eot_hour;
				$data_com["eot_amount"] 		= $eot_amount;
				$data_com["ot_eot_12am_hour"] 	= $ot_eot_12am_hr;
				$data_com["ot_eot_12am_amt"] 	= $ot_eot_12am_amount;
				$data_com["ot_eot_4pm_hour"] 	= $ot_eot_4pm_hr;
				$data_com["ot_eot_4pm_amt"] 	= $ot_eot_4pm_amount;
				$data_com["salary_month"] 		= $start_date;
		
				//***************************Festival bonus***********************
				/*$effective_date = $this->get_bonus_effective_date($salary_month);
				if($effective_date != false)
				{
					//$doj = "2013-05-06";
					$service_month = $this->common_model->get_service_month($effective_date,$doj);
					
					//echo "$effective_date ===$doj====$service_month"; 
					if($service_month >= 11)
					{
						$festival_bonus_rule 	= $this->get_festival_bonus_rule($service_month);
						$festival_bonus 		= $this->get_festival_bonus($festival_bonus_rule,$gross_sal,$basic_sal);
						$festival_bonus_com 	= $this->get_festival_bonus($festival_bonus_rule,$gross_sal_com,$basic_sal_com);
					}
					else 
					{ 
						$desig_bonus_rules = $this->get_desig_bonus_rules($effective_date,$desi_id); 
						if($desig_bonus_rules['msg'] == "OK" )
						{
							$festival_bonus 	= $desig_bonus_rules['bonus_amount'];
							$rules_name 		= $desig_bonus_rules['rules_name'];
							$festival_bonus_com = $desig_bonus_rules['bonus_amount'];
						}
						else
						{
							$festival_bonus 	= 0;
							$festival_bonus_com = 0;
						}
					}
				}
				else
				{
					$festival_bonus 	= 0;
					$festival_bonus_com = 0;
				}*/
				$festival_bonus 	= 0;
				$festival_bonus_com = 0;
				$data["festival_bonus"] 	= $festival_bonus;
				$data_com["festival_bonus"] = $festival_bonus_com;
				
				//***************************End of Festival bonus***********************//
				
				//***Net Pay Edited By Tarek On 22-10-2016 For Stapm Deduction Whose Net Pay less than 500***//
				$net_pay = $gross_sal + $att_bouns + $ot_amount - $total_deduction ;
				
				if($net_pay < 510)
				{
					$data["stamp"] 				= 0;
					$data["total_deduct"] 		= $advance_deduct + $abs_deduction + $others_deduct + $tax_deduct + 0;
					
					$data["net_pay"] 			= $net_pay;   // ($net_pay + 10) remove 28-11-2023
				}
				else
				{
					$data["net_pay"] = $net_pay;
				}
				
				
				//COMPLIENCE
				$net_pay_com = $gross_sal_com + $att_bouns + $ot_amount - $total_deduction_com ;//Zuel 140420
				
				if($net_pay_com < 510)
				{
					$data_com["stamp"] 				= 0;
					$data_com["total_deduct"] 		= $advance_deduct + $abs_deduction_com + $others_deduct + $tax_deduct + 0 ;
					
					$data_com["net_pay"] 			= $net_pay_com;  // ($net_pay_com + 10) remove 28-11-2023
				}
				else
				{
					$data_com["net_pay"] = $net_pay_com;
				}

				//print_r($data);
				// echo "<pre>";print_r($data);exit;

				$this->db->select("emp_id");
				$this->db->where("emp_id", $rows->emp_id);
				$this->db->where("salary_month", $start_date);
				$query = $this->db->get("pr_pay_scale_sheet");
				
				if($query->num_rows() > 0 )
				{
					//echo "hello";
					$this->db->where("emp_id", $rows->emp_id);
					$this->db->where("salary_month", $start_date);
					$this->db->update("pr_pay_scale_sheet",$data);
				}
				else
				{
					$this->db->insert("pr_pay_scale_sheet",$data);

				}
				
				
				//COMPLIENCE
				$this->db->select("emp_id");
				$this->db->where("emp_id", $rows->emp_id);
				$this->db->where("salary_month", $start_date);
				$query = $this->db->get("pr_pay_scale_sheet_com");

				// echo "<pre>";print_r($data_com);exit;
				
				if($query->num_rows() > 0 )
				{
					//echo "hello";
					$this->db->where("emp_id", $rows->emp_id);
					$this->db->where("salary_month", $start_date);
					$this->db->update("pr_pay_scale_sheet_com",$data_com);
				}
				else
				{
					$this->db->insert("pr_pay_scale_sheet_com",$data_com);
				}
			}
		}
			//$data["deduct_status"] = $deduct_status;
			return "Process completed successfully";
		}
	}

	function emp_ot_eot_deduct_sum($emp_id,$FS_on_date, $FS_off_date)
	{
		$this->db->select('
			sum(ot_hour) as ot_hour, sum(extra_ot_hour) as extra_ot_hour, sum(deduct_hour) as deduct_hour, sum(deduction_hour), SUM(
			    CASE
			        WHEN `extra_ot_hour` > 2 THEN 2
			        WHEN `extra_ot_hour` < 3 THEN `extra_ot_hour`
			    END ) AS nine_pm_eot'
			);
		$this->db->from('pr_emp_shift_log');
		$this->db->where('pr_emp_shift_log.emp_id',$emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get();
		return $query->row();
	}

	function ot_hour($emp_id, $FS_on_date, $FS_off_date)
	{
		$this->db->select_sum("ot_hour");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->ot_hour;
	}

	function eot_hour($emp_id, $FS_on_date, $FS_off_date)
	{
		$this->db->select_sum("extra_ot_hour");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		if($row->extra_ot_hour !=''){
			return $row->extra_ot_hour;
		}else{
			return $extra_ot_hour = 0;
		}
	}

	function modify_hour_sum($emp_id,$FS_on_date,$FS_off_date)
	{
		$this->db->select('emp_id,sum(deduct_hour) as tot');
		$this->db->from('pr_emp_shift_log');
		$this->db->where('pr_emp_shift_log.emp_id',$emp_id);
		$this->db->where("pr_emp_shift_log.shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get();
		// echo $this->db->last_query();
		$row = $query->row();
		return $ot_hour = $row->tot;
	}


	function stop_salary_check($emp_id,$start_date)
	{
		$salary_month = date("Y-m", strtotime($start_date));
		$num_rows = $this->db->where("emp_id",$emp_id)->like("salary_month",$salary_month)->get('pr_emp_stop_salary')->num_rows();

		if($num_rows > 0)
		{
			$stop_salary = 2;
		}
		else{
			$stop_salary = 1;
		}
		return $stop_salary;
	}

	function get_tiffin_allowance_rules_data()
	{
		$this->db->select('*');
		$this->db->from('pr_tiffin_allowance_rules');
		$this->db->where("rules_id", "1");
		$query = $this->db->get();
		$row = $query->row();
		$data['first_tiffin_time'] 	= $row->first_tiffin_time;
		$data['first_tiffin_allo'] 	= $row->first_tiffin_allo;
		$data['second_tiffin_time'] = $row->second_tiffin_time;
		$data['second_tiffin_allo'] = $row->second_tiffin_allo;
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
			$data['bonus_amount'] = $row->bonus_amount;
			$data['rules_name'] = $row->rules_name;
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

	function holiday_allaw_cal($emp_id,$holiday_alo_count,$desi_id)
	{
		$holiday_allowance_rules = $this->get_holiday_allowance_rules($desi_id);

		if($holiday_allowance_rules['msg'] == "OK" )
		{
				$holiday_allowance_rate = $this->db->where("rules_id",$holiday_allowance_rules['rules_id'])->get('attn_holiday_allowance_rules')->row()->allowance_amount;
				$holiday_allowance	 	= $holiday_allowance_rate * $holiday_alo_count;
		}
		else
		{
			$holiday_allowance 			= 0;
			$holiday_allowance_rate  	= 0;
		}
		$data['holiday_allowance_rate'] = $holiday_allowance_rate;
		$data['holiday_allowance'] 		= $holiday_allowance;
		return $data;
	}
	function get_holiday_allowance_rules($desig_id)
	{
		$this->db->select('rules_id');
		$this->db->from('attn_holiday_allowance_level');
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
	function get_holiday_alo_count($emp_id,$year,$month)
	{
		$year_month = $year."-".$month;
		$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
		$this->db->where('emp_id', $emp_id);
		$this->db->where('holiday_allowance', '1');
		$this->db->from('pr_emp_shift_log');
		return  $this->db->count_all_results();

	}

	function weekend_allaw_cal($emp_id,$weekend_alo_count,$desi_id)
	{
		$weekend_allowance_rules = $this->get_weekend_allowance_rules($desi_id);

		if($weekend_allowance_rules['msg'] == "OK" )
		{
				$weekend_allowance_rate = $this->db->where("rules_id",$weekend_allowance_rules['rules_id'])->get('pr_weekend_allowance_rules')->row()->allowance_amount;
				$weekend_allowance	 	= $weekend_allowance_rate * $weekend_alo_count;
		}
		else
		{
			$weekend_allowance 			= 0;
			$weekend_allowance_rate  	= 0;
		}
		$data['weekend_allowance_rate'] = $weekend_allowance_rate;
		$data['weekend_allowance'] 		= $weekend_allowance;
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
	function get_weekend_alo_count($emp_id,$year,$month)
	{
		$year_month = $year."-".$month;
		$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
		$this->db->where('emp_id', $emp_id);
		$this->db->where('weekly_allo', '1');
		$this->db->from('pr_emp_shift_log');
		return  $this->db->count_all_results();
	}

	function night_allaw_cal($emp_id,$night_alo_count,$desi_id)
	{
		$night_allowance_rules = $this->get_night_allowance_rules($desi_id);
		if($night_allowance_rules['msg'] == "OK" )
		{
				$night_allowance_rate = $this->db->where("rules_id",$night_allowance_rules['rules_id'])->get('pr_night_allowance_rules')->row()->night_allowance;
				$night_allowance = $night_allowance_rate * $night_alo_count;
		}
		else
		{
			$night_allowance 		= 0;
			$night_allowance_rate  	= 0;
		}
		$data['night_allowance_rate'] 	= $night_allowance_rate;
		$data['night_allowance'] 		= $night_allowance;
		//print_r($data);
		return $data;
	}

	function night_allaw_cal_2nd($emp_id,$night_alo_count,$desi_id)
	{
		$night_allowance_rules_2 = $this->get_night_allowance_rules($desi_id);
		//print_r($night_allowance_rules_2);
		if($night_allowance_rules_2['msg'] == "OK" )
		{
				$night_allowance_rate_2 = $this->db->where("rules_id",$night_allowance_rules_2['rules_id'])->get('pr_night_allowance_rules')->row()->night_allowance_2nd;
				$night_allowance_2 = $night_allowance_rate_2 * $night_alo_count;
		}
		else
		{
			$night_allowance_2 		= 0;
			$night_allowance_rate_2  	= 0;
		}
		$data['night_allowance_rate_2'] 	= $night_allowance_rate_2;
		$data['night_allowance_2'] 		= $night_allowance_2;
		//print_r($data);
		return $data;
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
		//print_r($data);
		return $data;
	}

	function get_night_alo_count($emp_id,$year,$month)
	{
		$year_month = $year."-".$month;
		$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
		$this->db->where('emp_id', $emp_id);
		$this->db->where('night_allo', '1');
		$this->db->from('pr_emp_shift_log');
		$query = $this->db->get();
		return $query->num_rows();
		//return $this->db->count_all_results();
	}

	function get_night_alo_count_2nd($emp_id,$year,$month)
	{
		$year_month = $year."-".$month;
		$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
		$this->db->where('emp_id', $emp_id);
		$this->db->where('night_allo', '2');
		$this->db->from('pr_emp_shift_log');
		return $this->db->count_all_results();
	}

	function get_tiffin_alo_count($emp_id,$year,$month,$first_tiffin_allo)
	{
		$year_month = $year."-".$month;
		$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
		$this->db->where('emp_id', $emp_id);
		$this->db->where('tiffin_allo',$first_tiffin_allo);
		$this->db->from('pr_emp_shift_log');
		return  $this->db->count_all_results();

	}
	function tiffin_allaw_cal($emp_id,$tiffin_count,$desig_id)
	{
		$tiffin_allowance_rules 	= $this->get_tiffin_allowance_rules_data();
		$tiffin_allowance 			= $tiffin_allowance_rules ['tiffin_amount'] * $tiffin_count;

		$data ['tiffin_allowance_rate'] =  $tiffin_allowance_rules ['tiffin_amount'];
		$data ['tiffin_allowance']		=  $tiffin_allowance;
		return $data;
	}

	function get_lunch_allaw_count($emp_id,$year,$month)
	{
		$year_month = $year."-".$month;
		$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
		$this->db->where('emp_id', $emp_id);
		$this->db->where('launch_allowance', '1');
		$this->db->from('pr_emp_shift_log');
		return  $this->db->count_all_results();

	}
	function resign_check($emp_id, $FS_on_date, $FS_off_date)
	{
		//$where = "trim(substr(resign_date,1,7)) = '$salary_month'";
		$this->db->select('resign_date');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("resign_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get('pr_emp_resign_history');
		//echo $this->db->last_query();
		if($query->num_rows() == 0)
		{
			return false;
		}
		else
		{
			//$resign_date = $query->row()->resign_date;
			//return $resign_day = substr($resign_date, 8,2);
			$data = array();
			$data['resign_date'] = $query->row()->resign_date;
			$data['resign_day'] = substr($data['resign_date'], 8,2);
			return $data;
		}
	}

	function left_check($emp_id, $FS_on_date, $FS_off_date)
	{
		//$where = "trim(substr(left_date,1,7)) = '$salary_month'";
		$this->db->select('left_date');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("left_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get('pr_emp_left_history');
		//echo $this->db->last_query();
		if($query->num_rows() == 0)
		{
			return false;
		}
		else
		{
			$data = array();
			$data['left_date'] = $query->row()->left_date;
			$data['left_day'] = substr($data['left_date'], 8,2);
			return $data;
		}
	}

	function emp_production($emp_prod)
	{
		$this->db->select("emp_id,salary_type");
		$this->db->where("emp_id",$emp_prod);
		$this->db->where("salary_type",2);
		$query = $this->db->get("pr_emp_com_info");
		if($query->num_rows == 1)
		{
			return $emp_prod;
		}
		else
		{
			return false ;
		}
	}

	function others_allaw_cal($emp_id, $salary_month)
	{
		$this->db->select("payment_amount");
		$this->db->where("emp_id", $emp_id);
		$this->db->like("payment_month",$salary_month);
		$query = $this->db->get("pr_payment");
		//echo $this->db->last_query();
		if($query->num_rows > 0)
		{
			$row = $query->row();
			return $row->payment_amount;
		}
		else
		{
			return 0;
		}
	}

	function eot_hour_for_super_admin($emp_id, $FS_on_date, $FS_off_date)
	{
		$this->db->select_sum("extra_ot_hour");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("present_status !=", 'W');
		$this->db->where("present_status !=", 'H');
		$this->db->where("shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		if($row->extra_ot_hour !=''){
			return $row->extra_ot_hour;
		}else{
			return $extra_ot_hour = 0;
		}

	}

	function w_h_ot_hour_sum($emp_id,$FS_on_date,$FS_off_date)
	{
		$this->db->select('emp_id,sum(ot_hour) as tot');
		$this->db->from('pr_emp_shift_log');
		$this->db->where('pr_emp_shift_log.emp_id',$emp_id);
		$this->db->where('present_status =','W');
		$this->db->or_where('present_status =','H');
		$this->db->where("pr_emp_shift_log.shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$this->db->group_by('emp_id');
		$query = $this->db->get();
		$row = $query->row();
		return $ot_hour = $row->tot;
	}

	function ot_hour_between_date($emp_id, $start_date, $end_date)
	{
		$this->db->select_sum("ot_hour");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->ot_hour;
	}

	function eot_hour_between_date($emp_id, $start_date, $end_date)
	{
		$this->db->select_sum("extra_ot_hour");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->extra_ot_hour;
	}

	function att_bouns_cal($emp_id)
	{
		$this->db->select("pr_attn_bonus.ab_rule");
		$this->db->from("pr_attn_bonus");
		$this->db->from("pr_emp_com_info");
		$this->db->where("pr_emp_com_info.emp_id", $emp_id);
		$this->db->where("pr_emp_com_info.att_bonus = pr_attn_bonus.ab_id");
		$query = $this->db->get();
		$row = $query->row();
		return $row->ab_rule;
	}

	function transport_cal($emp_id)
	{
		$this->db->select("transport");
		$this->db->from("pr_emp_com_info");
		$this->db->where("emp_id", $emp_id);
		$query = $this->db->get();
		$row = $query->row();
		if($row->transport == 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function lunch_allaw_cal($emp_id)
	{
		$this->db->select("lunch");
		$this->db->from("pr_emp_com_info");
		$this->db->where("emp_id", $emp_id);
		$query = $this->db->get();
		$row = $query->row();
		if($row->lunch == 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function tax_and_others_deduct_cal($emp_id, $year_month)
	{
		$this->db->select('sum(others_deduct), sum(tax_deduct)');
		$this->db->where("emp_id", $emp_id);
		$this->db->like("deduct_month",$year_month);
		$query = $this->db->get("pr_deduct");
		//echo $this->db->last_query();
		return $query->row();
	}

	function others_deduct_cal($emp_id, $year_month)
	{
		$this->db->select_sum("others_deduct");
		$this->db->where("emp_id", $emp_id);
		$this->db->like("deduct_month",$year_month);
		$query = $this->db->get("pr_deduct");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->others_deduct;
	}

	function tax_deduct_cal($emp_id, $year_month)
	{
		$this->db->select_sum("tax_deduct");
		$this->db->where("emp_id", $emp_id);
		$this->db->like("deduct_month",$year_month);
		$query = $this->db->get("pr_deduct");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->tax_deduct ;
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

	function attendance_check($emp_id,$present_status,$FS_on_date,$FS_off_date)
	{
		//$present_status = 'P';
		$this->db->select('emp_id');
		$this->db->where('emp_id',$emp_id);
		$this->db->where('present_status',$present_status);
		$this->db->where("shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get('pr_emp_shift_log');
		return $query->num_rows();
	}

	function attendance_check_pError($emp_id,$present_status,$FS_on_date,$FS_off_date)
	{
		//$present_status = 'P';
		$this->db->select('emp_id, in_time, out_time');
		$this->db->where('emp_id',$emp_id);
		$this->db->where('present_status',$present_status);
		$this->db->where("shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$query = $this->db->get('pr_emp_shift_log')->result();

		$pError = 0;
		if (isset($query)) {
			foreach ($query as $row) {
				if($row->in_time == '00:00:00' or $row->out_time == '00:00:00')
				{
					$pError = $pError + 1;
				}
			}
		}
		return $pError;
	}


	function find_week($year_v,$month_v,$day_of_week_v)
	{
		//$year_v=2010;
		//$month_v=3;
		//---5=fryday----------------//
		//$day_of_week_v=5;
        $result=array();
		for ($year = $year_v; $year <= $year_v; $year++)
					{
						for ($month = $month_v; $month <= $month_v; $month++)
							{
							$num_of_days = date("t", mktime(0,0,0,$month,1,$year));
							$result['num_of_days']=$num_of_days;
						//	echo "Number of days = $num_of_days <BR>";
							$firstdayname = date("D", mktime(0, 0, 0, $month, 1, $year));
							$firstday = date("w", mktime(0, 0, 0, $month, 1, $year));
							$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

								for ($day_of_week = $day_of_week_v ; $day_of_week <= $day_of_week_v ; $day_of_week++)
									{
									if ($firstday > $day_of_week) {
									// means we need to jump to the second week to find the first $day_of_week
									$d = (7 - ($firstday - $day_of_week)) + 1;
									} elseif ($firstday < $day_of_week) {
									// correct week, now move forward to specified day
									$d = ($day_of_week - $firstday + 1);
									} else {
									// my "reversed-engineered" formula
									if ($lastday==28) // max of 4 occurences each in the month of February with

									$d = ($firstday + 4);
									elseif ($firstday==4)
									$d = ($firstday - 2);
									elseif ($firstday==5 )
									$d = ($firstday - 3);
									elseif ($firstday==6)
									$d = ($firstday - 4);
									else
									$d = ($firstday - 1);
									if ($lastday==29) // only 1 set of 5 occurences each in the month of
								   $d -= 1;
						}

						$d += 28;    // jump to the 5th week and see if the day exists
						if ($d > $lastday) {
							$weeks = 4;
						} else {
							$weeks = 5;
						}

					if ($day_of_week==0) ;
					elseif ($day_of_week==1) ;
					elseif ($day_of_week==2) ;
					elseif ($day_of_week==3) ;
					elseif ($day_of_week==4) ;
					elseif ($day_of_week==5) ;
					else echo "Sat ";

					//echo "occurences = $weeks <BR> ";
					$result['day_of_week']=($day_of_week);
					$result['num_of_days']=$num_of_days;
					$no_of_working_days=$num_of_days-$day_of_week;
					//echo "No of working days  ".$no_of_working_days;
					$result['no_of_working_days']=$no_of_working_days;

					} // for $day_of_week loop
				} // for $mth loop
		} // for $year loop

  		return $result;

	}


	function insert_pay_sheet($data)
	{
		$this->db->insert('pr_pay_scale_sheet', $data);
	}

	function update_pay_sheet($data)
	{
		$this->db->where("emp_id",$data['emp_id']);
		$this->db->update('pr_pay_scale_sheet', $data);

	}

	function leave_db($emp_id,$start_date,$end_date, $leave_type)
	{
		$where = "trim(substr(start_date,1,10)) BETWEEN '$start_date' and '$end_date'";

		$this->db->select('start_date');
		$this->db->where("emp_id",$emp_id);
		$this->db->where("leave_type",$leave_type);
		$this->db->where($where);

		$query = $this->db->get('pr_leave_trans');

		return $query->num_rows();
	}

	function advance_loan_deduction($emp_id, $salary_month)
	{
		$search_year_month = $salary_month;
		$salary_month = "$salary_month-01";

		$this->db->select("*");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("loan_status", '1');
		$query = $this->db->get("pr_advance_loan");
		//echo $query->num_rows();
		if( $query->num_rows() > 0)
		{
			$rows = $query->row();
			// foreach($query->result() as $rows) {
				$loan_id	= $rows->loan_id;
				$loan_amt 	= $rows->loan_amt;
				$pay_amt  	= $rows->pay_amt;
			// }

			$this->db->select("emp_id,pay_amount");
			$this->db->where("emp_id", $emp_id);
			$this->db->where("loan_id", $loan_id);
			$this->db->like("pay_month", $salary_month);
			$query1 = $this->db->get("pr_advance_loan_pay_history");
			if( $query1->num_rows() == 0)
			{
				$this->db->select_sum("pay_amount");
				$this->db->where("emp_id", $emp_id);
				$this->db->where("loan_id", $loan_id);
				$query2 = $this->db->get("pr_advance_loan_pay_history");
				//echo $this->db->last_query();

				if( $query2->num_rows() > 0)
				{
					$row = $query2->row();
					$total_pay_amount = $row->pay_amount;
				}
				else
				{
					$total_pay_amount = 0;
				}

				$rest_loan_amount = $loan_amt - $total_pay_amount;

				if($rest_loan_amount > $pay_amt)
				{
					$data = array(
									'loan_id' 	=> $loan_id,
									'emp_id'  	=> $emp_id,
									'pay_amount'=> $pay_amt,
									'pay_month' => $salary_month
								);
					if($this->db->insert("pr_advance_loan_pay_history", $data))
					{
						return $pay_amt;
					}
				}
				else
				{
					$data = array(
									'loan_id' 	=> $loan_id,
									'emp_id'  	=> $emp_id,
									'pay_amount'=> $rest_loan_amount,
									'pay_month' => $salary_month
								);
					if($this->db->insert("pr_advance_loan_pay_history", $data))
					{
						$this->db->select_sum("pay_amount");
						$this->db->where("emp_id", $emp_id);
						$this->db->where("loan_id", $loan_id);
						$query2 = $this->db->get("pr_advance_loan_pay_history");
						//echo $this->db->last_query();

						if( $query2->num_rows() > 0)
						{
							$row = $query2->row();
							$total_pay_amount = $row->pay_amount;

							if($total_pay_amount == $loan_amt)
							{
								$data = array(
											'loan_status' => 2
											);
								$this->db->where("emp_id", $emp_id);
								$this->db->where("loan_id", $loan_id);
								$this->db->update("pr_advance_loan", $data);
							}
						}
						return $rest_loan_amount;
					}
				}

			}
			else
			{
				$row = $query1->row();
				$pay_amount = $row->pay_amount;
				return $pay_amount;
			}
		}
		else
		{
			$this->db->select("*");
			$this->db->where("emp_id", $emp_id);
			$this->db->where("loan_status", '2');
			$this->db->like("loan_date",$search_year_month);
			$query = $this->db->get("pr_advance_loan");

			if( $query->num_rows() > 0)
			{
				$rows = $query->row();
				// foreach($query->result() as $rows)
				// {
					$loan_id	= $rows->loan_id;
					$loan_amt 	= $rows->loan_amt;
					$pay_amt  	= $rows->pay_amt;
				// }

				$this->db->select("emp_id,pay_amount");
				$this->db->where("emp_id", $emp_id);
				$this->db->where("loan_id", $loan_id);
				$this->db->like("pay_month", $salary_month);
				$query1 = $this->db->get("pr_advance_loan_pay_history");
				if( $query1->num_rows() == 0)
				{
					return 0;
				}
				else
				{
					$row = $query1->row();
					$pay_amount = $row->pay_amount;
					return $pay_amount;
				}
			}
			else
			{
				return 0;
			}
		}
	}

	function due_payment_deduction($emp_id, $salary_month)
	{

		$search_year_month = $salary_month;
		$salary_month = "$salary_month-01";

		$this->db->select("*");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("due_status", '1');
		$query = $this->db->get("pr_due_amt");
		//echo $query->num_rows();

		if($query->num_rows() > 0)
		{
			$rows = $query->row();
			// foreach($query->result() as $rows)
			// {
				$due_id	= $rows->due_id;
				$due_amt = $rows->due_amt;
				$pay_amt = $rows->pay_amt;
			// }

			$this->db->select("emp_id,pay_amount");
			$this->db->where("emp_id", $emp_id);
			$this->db->where("due_id", $due_id);
			$this->db->like("pay_month", $salary_month);
			$query1 = $this->db->get("pr_due_pay_history");
			if($query1->num_rows() == 0)
			{
				$this->db->select_sum("pay_amount");
				$this->db->where("emp_id", $emp_id);
				$this->db->where("due_id", $due_id);
				$query2 = $this->db->get("pr_due_pay_history");
				//echo $this->db->last_query();

				if($query2->num_rows() > 0)
				{
					$row = $query2->row();
					$total_pay_amount = $row->pay_amount;
				}
				else
				{
					$total_pay_amount = 0;
				}

				$rest_due_amount = $due_amt - $total_pay_amount;

				if($rest_due_amount > $pay_amt)
				{
					$data = array(
									'pay_id' 	=> '',
									'due_id' 	=> $due_id,
									'emp_id'  	=> $emp_id,
									'pay_amount'=> $pay_amt,
									'pay_month' => $salary_month
					 );
					if($this->db->insert("pr_due_pay_history", $data))
					{
						return $pay_amt;
					}
				}
				else
				{
					$data = array(
									'pay_id' 	=> '',
									'due_id' 	=> $due_id,
									'emp_id'  	=> $emp_id,
									'pay_amount'=> $rest_due_amount,
									'pay_month' => $salary_month
								);
					if($this->db->insert("pr_due_pay_history", $data))
					{
						$this->db->select_sum("pay_amount");
						$this->db->where("emp_id", $emp_id);
						$this->db->where("due_id", $due_id);
						$query2 = $this->db->get("pr_due_pay_history");
						//echo $this->db->last_query();

						if($query2->num_rows() > 0)
						{
							$row = $query2->row();
							$total_pay_amount = $row->pay_amount;

							if($total_pay_amount == $due_amt)
							{
								$data = array(
											'due_status' => 2
											);
								$this->db->where("emp_id", $emp_id);
								$this->db->where("due_id", $due_id);
								$this->db->update("pr_due_amt", $data);
							}
						 }
						 return $rest_due_amount;
					 }
			 	  }
				}
				else
				{
					$row = $query1->row();
					$pay_amount = $row->pay_amount;
					return $pay_amount;
				}
		 }
		 else
		 {
			$this->db->select("*");
			$this->db->where("emp_id", $emp_id);
			$this->db->where("due_status", '2');
			$this->db->like("due_date",$search_year_month);
			$query = $this->db->get("pr_due_amt");

			if( $query->num_rows() > 0)
			{
				$rows = $query->row();
				// foreach($query->result() as $rows)
				// {
					$due_id	= $rows->due_id;
					$due_amt = $rows->due_amt;
					$pay_amt = $rows->pay_amt;
				// }

				$this->db->select("emp_id,pay_amount");
				$this->db->where("emp_id", $emp_id);
				$this->db->where("due_id", $due_id);
				$this->db->like("pay_month", $salary_month);
				$query1 = $this->db->get("pr_due_pay_history");
				if( $query1->num_rows() == 0)
				{
					return 0;
				}
				else
				{
					$row = $query1->row();
					$pay_amount = $row->pay_amount;
					return $pay_amount;
				}
			}
			else
			{
				return 0;
			}
		}
     }

	function get_bonus_status()
	{
		$this->db->select('*');
		$query_fes_bonus = $this->db->get('pr_bonus_rules');
		foreach($query_fes_bonus->result() as $rows)
		{
			$effective_date =  $rows->effective_date;
			list($fes_year, $fes_month, $fes_date) = explode('-', trim($effective_date));
			$fes_bonus_month_table = "att_".$fes_year."_".$fes_month;
		}
		return $fes_bonus_month_table;
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

	function get_service_month($effective_date,$doj)
	{
		$date_diff 		= strtotime($effective_date)-strtotime($doj);
		//DATE TO DATE RULE
		//return $month 	= floor(($date_diff)/2592000);

		//MONTH TO MONTH RULE
		//return $month 	= ceil(($date_diff)/2628000);
		$startdate = strtotime($doj);
		$enddate = strtotime($effective_date);

		return $numberOfMonths = abs((date('Y', $enddate) - date('Y', $startdate))*12 + (date('m', $enddate) - date('m', $startdate)))+1;
	}

	function get_festival_bonus_rule($service_month)
	{
		//echo $service_month;
		$data = array();
		$this->db->select('*');
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

		$pre_festival_bonus = $salary_for_bonus * $amount_fraction;
		$festival_bonus = round((($pre_festival_bonus * $bonus_percent)/100));
		return $festival_bonus;
	}

	function get_late_count($emp_id,$FS_on_date,$FS_off_date)//$year,$month
	{
		//$year_month = $year."-".$month;
		//$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
		$this->db->where("shift_log_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
		$this->db->where('emp_id', $emp_id);
		$this->db->where('late_status', '1');
		$this->db->from('pr_emp_shift_log');
		return  $this->db->count_all_results();

	}

	function get_join_month_dates($doj)
	{
		$data = array();
		$year 		= date('Y', strtotime($doj));
		$month 		= date('m', strtotime($doj));
		$day 		= date('d', strtotime($doj));
		$last_day 	= date('t', strtotime($doj));

		$data['doj_1st_date'] 	= date("Y-m-d", mktime(0, 0, 0, $month, 1, $year));
		$data['doj_2nd_date'] 	= date("Y-m-d", strtotime("-1 day",strtotime($doj)));
		$data['doj_1st_count'] 	= date("d", strtotime($data['doj_2nd_date']));
		$data['doj_3rd_date'] 	= $doj;
		$data['doj_2nd_count'] 	= $last_day;
		$data['doj_4th_date'] 	= date("Y-m-d", mktime(0, 0, 0, $month, $last_day, $year));

		return $data;
	}

	function get_resign_month_dates($resign_check, $salary_month)
	{
		$resign_date = "$salary_month-$resign_check";
		$data = array();
		$year 		= date('Y', strtotime($resign_date));
		$month 		= date('m', strtotime($resign_date));
		$day 		= date('d', strtotime($resign_date));
		$last_day 	= date('t', strtotime($resign_date));

		$data['resign_1st_date'] 	= date("Y-m-d", mktime(0, 0, 0, $month, 1, $year));
		$data['resign_2nd_date'] 	= date("Y-m-d", strtotime("-1 day",strtotime($resign_date)));
		$data['resign_1st_count'] 	= date("d", strtotime($data['resign_2nd_date']));
		$data['resign_3rd_date'] 	= $resign_date;
		$data['resign_2nd_count'] 	= $last_day;
		$data['resign_4th_date'] 	= date("Y-m-d", mktime(0, 0, 0, $month, $last_day, $year));

		return $data;
	}

	function resign_day_count($resign_date, $end_date_of_month)
	{
		$resign_day = date('d', strtotime($resign_date));
		return $resign_day_count = $end_date_of_month - $resign_day;
	}

	function new_join_day_count($FS_on_date, $join_date)
	{

		return $num_of_days = $this->get_days($FS_on_date, $join_date);
	}

	function deduction_hour_count($emp_id,$year,$month)
	{
		$year_month = "$year-$month";

		$this->db->select('SUM(deduction_hour) AS deduction_hour_count');
		$this->db->where('emp_id', $emp_id);
		$this->db->like('shift_log_date', $year_month);
		$query = $this->db->get('pr_emp_shift_log');
		$row = $query->row();
		return $deduction_hour_count = $row->deduction_hour_count;
	}

	function salary_process_eligibility($emp_id, $FS_on_date, $FS_off_date)
	{
		$salary_month = date('Y-m', strtotime($FS_off_date));

		$join_check 	= $this->join_range_check($emp_id,$FS_on_date, $FS_off_date);
		$resign_check 	= $this->resign_range_check($emp_id, $FS_on_date, $FS_off_date);
		$left_check 	= $this->left_range_check($emp_id, $FS_on_date, $FS_off_date);
		$zero_gross_check 	= $this->zero_gross_check($emp_id);


		if($join_check != false and $resign_check != false and $left_check != false and $zero_gross_check != false )
		{
				return true;
		}
		else
		{

			$this->db->where('emp_id', $emp_id);
			$this->db->like('salary_month', $salary_month);
			$this->db->delete('pr_pay_scale_sheet');


			$this->db->where('emp_id', $emp_id);
			$this->db->like('salary_month', $salary_month);
			$this->db->delete('pr_pay_scale_sheet_com');
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
		if($query->num_rows() > 0){return true;}else{return false;}
	}

	function join_range_check($emp_id, $FS_on_date, $FS_off_date)
	{
		$this->db->select('emp_join_date');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("emp_join_date <= '$FS_off_date'");
		$query = $this->db->get('pr_emp_com_info');
		//echo $this->db->last_query();
		if($query->num_rows() > 0){return true;}else{return false;}
	}

	function resign_range_check($emp_id, $FS_on_date, $FS_off_date)
	{
		$this->db->select('resign_date');
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('pr_emp_resign_history');
		//echo $this->db->last_query();

		if($query->num_rows() == 0){ return true;}else{

			$this->db->select('resign_date');
			$this->db->where('emp_id', $emp_id);
			$this->db->where("resign_date <= '$FS_off_date'");
			$query = $this->db->get('pr_emp_resign_history');
			//echo $this->db->last_query();
			if($query->num_rows() > 0)
			{
				$this->db->select('resign_date');
				$this->db->where('emp_id', $emp_id);
				$this->db->where("resign_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
				$query = $this->db->get('pr_emp_resign_history');
				//echo $this->db->last_query();
					if($query->num_rows() > 0)
					{
						return true;
					}
					else{ return false;}
			}
			else{ return true;}




		}
	}

	function left_range_check($emp_id, $FS_on_date, $FS_off_date)
	{

		$this->db->select('left_date');
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('pr_emp_left_history');
		//echo $this->db->last_query();
		if($query->num_rows() == 0){ return true;}else{

			$this->db->select('left_date');
			$this->db->where('emp_id', $emp_id);
			$this->db->where("left_date <= '$FS_off_date'");
			$query = $this->db->get('pr_emp_left_history');
			//echo $this->db->last_query();
			if($query->num_rows() > 0){
				$this->db->select('left_date');
				$this->db->where('emp_id', $emp_id);
				$this->db->where("left_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
				$query = $this->db->get('pr_emp_left_history');
				//echo $this->db->last_query();
				if($query->num_rows() > 0){return true;}else{return false;}

			}else{return true;}
		}
	}

	function get_days($from, $to)
	{
		$first_date = strtotime($from);
    	$second_date = strtotime($to);
   		$offset = $second_date-$first_date;
    	$total_days = floor($offset/60/60/24);
		return $total_days + 1;
	}

	function get_how_many_weeked_between_dates($startDate,$endDate){
		$endDate 	= strtotime($endDate);
		$k = 0;
		for($i = strtotime('Monday', strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i)){
			//echo date('l Y-m-d', $i);
			$k++;
		}
		return $k;
	}

	function salary_structure($gross_salary){
		$data = array();

		$data['medical_allow'] 	= 600;
		$data['trans_allow'] 	= 350;
		$data['food_allow'] 	= 900;
		$total_salary_allow 	= $data['medical_allow'] + $data['trans_allow'] + $data['food_allow'];
		$data['gross_salary'] 	= $gross_salary;
		$data['basic_sal'] 	    = round((($gross_salary - $total_salary_allow) / 1.5));
		// $data['house_rent']     = round($basic_salary * 0.5);
		$data['house_rent']     = $gross_salary - ($total_salary_allow + $data['basic_sal']);
		$data['ot_rate']        = round(($data['basic_sal'] * 2  / 208),2);
		$data['stamp'] 			= 10;

		if($gross_salary == 0){
			$data['medical_allow'] 	= 0;
			$data['trans_allow'] 	= 0;
			$data['food_allow'] 	= 0;
			$data['gross_salary'] 	= 0;
			$data['basic_sal'] 	   	= 0;
			$data['house_rent']    	= 0;
			$data['ot_rate']       	= 0;
			$data['stamp'] 			= 0;
		}
		return $data;
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
}
?>

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
		$start_date    = date("Y-m-01", strtotime($process_month));
		$end_date      = $process_month .'-'. $num_of_days;
		$table_name    = "att_".date("Y_m", strtotime($process_month));

		//PROCESS MONTH EXISTANCE CHECK
		if($process_month < '2024-07-02')
		{
			return "Processing is not allowed before 2024-07-01.";
		}

		if(!$this->db->table_exists($table_name))
		{
			return "Process month does not exist, please change your process month";
		}

		//SALARY BLOCK CHECK
		$sb = $this->db->where('block_month',$start_date)->where('unit_id',$unit_id)->get('pay_salary_block')->num_rows();
		if($sb > 0)
		{
			return "This Month Already Finally Processed.";
		}

		$prev_month = date("Y-m-d",strtotime("-1 month",strtotime($start_date)));
		$pvm = $this->db->where('block_month',$prev_month)->where('unit_id',$unit_id)->get('pay_salary_block')->num_rows();
		if($pvm < 1  && $unit_id != 4)
		{
			return "Please Finally Processed Previous Month..";
		}

		$dddd=implode(',', $grid_emp_id);
		$query = $this->get_emp_info($dddd, $unit_id);

		if($query->num_rows() == 0)
		{
			return "Employee information does not exist";
		}
		else
		{
			$attn_rule = $this->get_attn_bonus_rule($start_date, $unit_id);
			$data = array();
			$data_com 	= array();
			foreach($query->result() as $rows)
			{
				set_time_limit(0) ;
				ini_set("memory_limit","512M");
				$before_after_absent = 0;

				//============ GENERAL INFORMATION ======================
				//=================================================================
				$id 			= $rows->id;
				$emp_id 		= $rows->emp_id;
				$emp_dept_id	= $rows->emp_dept_id;
				$emp_grade_id	= $rows->grade_id;
				$emp_sec_id 	= $rows->emp_sec_id;
				$emp_line_id	= $rows->emp_line_id;
				$desi_id 		= $rows->emp_desi_id;
				$emp_cat_id		= $rows->emp_cat_id;

				$doj 			= $rows->emp_join_date;
				$gross_sal 		= $rows->gross_sal;
				$gross_sal_com 	= $rows->com_gross_sal;
				$ot_check 		= $rows->ot_entitle;
				$gender 		= $rows->gender;

				$sp_eligibility = $this->salary_process_eligibility($emp_id, $start_date);
				// vardump($sp_eligibility);

				if($sp_eligibility == true)
				{
					//========== FOR INCREMENT AND PROMOTION ================
					//==========================================================
					$where = "trim(substr(effective_month,1,7)) = '$start_date'";
					$this->db->select("*");
					$this->db->where("new_emp_id", $emp_id);
					$this->db->where($where);
					$inc_prom = $this->db->get("pr_incre_prom_pun");
					// dd($inc_prom->result());
					if($inc_prom->num_rows() > 0 ) {
						$inc_p 			= $inc_prom->row();
						$gross_sal 		= $inc_p->new_salary;
						$gross_sal_com 	= $inc_p->new_com_salary;
					}else{
						$where = "trim(substr(effective_month,1,7)) > '$start_date'";
						$this->db->select("*");
						$this->db->where("new_emp_id",$emp_id);
						$this->db->where($where);
						$this->db->limit(1);
						$inc_prom = $this->db->get("pr_incre_prom_pun");
						if($inc_prom->num_rows() > 0 )
						{
							foreach($inc_prom->result() as $row)
							{
								// dd($row->prev_dept);
								$gross_sal 		= $row->prev_salary;
								$gross_sal_com 	= $row->prev_salary;
								$emp_dept_id	= $row->prev_dept;
								$emp_grade_id	= $row->prev_grade ;
								$emp_sec_id 	= $row->prev_section;
								$emp_line_id	= $row->prev_line;
								$desi_id 		= $row->prev_desig;
							}
						}
						else
						{
							echo "";
						}

					}

					//============= END INCREMENT AND PROMOTION ===============
					$stop_salary	= $this->stop_salary_check($emp_id,$start_date);
					$ss 			= $this->common_model->salary_structure($gross_sal);
					$basic_sal 		= $ss['basic_sal'];
					$house_rent 	= $ss['house_rent'];
					$madical_allo 	= $ss['medical_allow'];
					$food_allow 	= $ss['food_allow'];
					$trans_allow 	= $ss['trans_allow'];
					$salary_structure = array(
						'basic_sal'   => $basic_sal,
						'house_r' 	  => $house_rent,
						'medical_a'   => $madical_allo,
						'food_allow'  => $food_allow,
						'trans_allow' => $trans_allow,
					);
					$data = array(
						'basic_sal'   => $basic_sal,
						'house_r' 	  => $house_rent,
						'medical_a'   => $madical_allo,
						'food_allow'  => $food_allow,
						'trans_allow' => $trans_allow,
					);

					$data["emp_id"] 			= $emp_id;
					$data["unit_id"] 			= $unit_id;
					$data["dept_id"] 			= $emp_dept_id;
					$data["sec_id"] 			= $emp_sec_id;
					$data["line_id"] 			= $emp_line_id;
					$data["desig_id"] 			= $desi_id;
					$data["gr_id"] 				= $emp_grade_id;
					$data["stop_salary"] 		= $stop_salary;
					$data["emp_status"] 		= $emp_cat_id;
					$data["gross_sal"] 			= $gross_sal;
					$data["salary_structure"] 	= json_encode($salary_structure);

					//COMPLIENCE
					$data_com["emp_id"] 		= $emp_id;
					$data_com["unit_id"] 		= $unit_id;
					$data_com["dept_id"] 		= $emp_dept_id;
					$data_com["sec_id"] 		= $emp_sec_id;
					$data_com["line_id"] 		= $emp_line_id;
					$data_com["desig_id"] 		= $desi_id;
					$data_com["gr_id"] 				= $emp_grade_id;
					$data_com["stop_salary"]	= 1;
					$data_com["emp_status"] 	= $emp_cat_id;
					$data_com["gross_sal"] 		= $gross_sal_com;

					$ssc 		= $this->common_model->salary_structure($gross_sal_com);
					$data_com["basic_sal"] 		= $ssc['basic_sal'];
					$data_com["house_r"] 		= $ssc['house_rent'];
					$data_com["medical_a"] 		= $ssc['medical_allow'];
					$data_com["food_allow"] 	= $ssc['food_allow'];
					$data_com["trans_allow"] 	= $ssc['trans_allow'];
					//=========== END GENERAL INFORMATION ==================

					//========= PRESENT STATUS ========================
					//==============================================================
					$salary_month  = date("Y-m-01", strtotime($end_date));
					$join_month    = date("Y-m-01", strtotime($doj));
		            if (strtotime($join_month) > strtotime($salary_month)) {
		                continue;
		            }

		            $join_left_resign = 0;
		            $resign_check   = $this->resign_check($emp_id, $start_date, $end_date);
		            $left_check     = $this->left_check($emp_id, $start_date, $end_date);
					$start_date     = date("Y-m-01", strtotime($process_month));
		            if($resign_check != false and $salary_month == $join_month)
		            {
		                $resign_after_absent = $this->get_days($resign_check['resign_date'],$end_date);
		                $doj_before_absent = $this->get_days($start_date, $doj);

		                $before_after_absent = ($resign_after_absent - 1) + ($doj_before_absent - 1);
		                $join_left_resign = $num_of_days - $before_after_absent;
		            }
		            elseif($left_check != false and $salary_month == $join_month)
		            {
		                $total_days = $left_check['left_day'];
		                $doj_before_absent = $this->get_days($start_date, $doj);
		                $resign_after_absent = $this->get_days($left_check['left_date'],$end_date);

		                $before_after_absent = ($doj_before_absent - 1) + ($resign_after_absent - 1);
		                $join_left_resign = $num_of_days - $before_after_absent;
		            }
		            elseif($resign_check != false)
		            {
		                $total_days = $resign_check['resign_day'];
		                $resign_after_absent = $this->get_days($resign_check['resign_date'],$end_date);

		                $before_after_absent = $resign_after_absent - 1;
		                $join_left_resign = $num_of_days - $before_after_absent;
		            }
		            elseif($left_check != false)
		            {
		                $total_days = $left_check['left_day'];
		                $resign_after_absent = $this->get_days($left_check['left_date'],$end_date);

		                $before_after_absent = $resign_after_absent - 1;
		                $join_left_resign = $num_of_days - $before_after_absent;
		            }
		            elseif($salary_month == $join_month)
		            {
		                $before_after_absent = $this->get_days($start_date, $doj) - 1;
		                $start_date = $doj;
		            }
		            else
		            {
		                $before_after_absent = 0;
		            }

					// attendance status check with out ml leave
					$attendances = $this->attendance_check($emp_id, $start_date, $end_date);
					$attend  =  $attendances->attend;
					$absent  =  $attendances->absent;
					$weekend =  $attendances->weekend;
					$holiday =  $attendances->holiday;
					$total_leave =  $attendances->total_leave;

					// dd($attendances);
					$leaves = $this->leave_db($rows->emp_id, $start_date, $end_date);

					$cas_leave  = isset($leaves['cl']) ? $leaves['cl'] : 0;
					$sick_leave = isset($leaves['sl']) ? $leaves['sl'] : 0;
					$earn_leave = isset($leaves['el']) ? $leaves['el'] : 0;
					$m_leave    = 0;
					$wp_leave   = isset($leaves['wp']) ? $leaves['wp'] : 0;
					$sp_leave   = isset($leaves['sp']) ? $leaves['sp'] : 0;

					// attendance status check with out ml leave end
					// maternity benefit calculation
					$mls = array();
					if ($gender == 'Female') {
						$mls = $this->ml_leave_db($rows->emp_id, $start_date, $end_date, $gross_sal, $gross_sal_com);
						if ($mls['ml_leave_day'] == 0) {
							$ml_deduct 		= 0;
							$ml_deduct_com 	= 0;
						} else {
							$m_leave	 	= $mls['ml_leave_day'];
							$ml_deduct 		= $mls['deduct_gross'];
							$ml_deduct_com  = $mls['deduct_g_com'];
						}
					} else {
						$ml_deduct 		= 0;
						$ml_deduct_com 	= 0;
					}
					// maternity benefit calculation end

					// pay days calculation
					$total_pay_leave  = $cas_leave + $sick_leave + $earn_leave + $sp_leave; // $wp_leave + $do_leave;
					$num_working_days = $num_of_days - $holiday - $weekend - $before_after_absent;
					$pay_days 		  = $attend + $weekend + $holiday + $total_pay_leave;
					// pay days calculation

					$attend_data = array(
						'total_days' 	 => $num_of_days,
						'num_of_workday' => $num_working_days,
						'att_days' 		 => $attend,
						'absent_days' 	 => $absent,
						'ba_absent' 	 => $before_after_absent,
						'c_l' 		 	 => $cas_leave,
						's_l' 		 	 => $sick_leave,
						'e_l' 		 	 => $earn_leave,
						'm_l' 		 	 => $m_leave,
						'wp' 		 	 => $wp_leave,
						'sp' 		 	 => $sp_leave,
						'total_leave' 	 => $total_leave,
						'pay_leave' 	 => $total_pay_leave,
						'holiday' 		 => $holiday,
						'weekend' 		 => $weekend,
						'total_holiday'  => $holiday + $weekend,
						'pay_days' 		 => $pay_days,
					);
					// dd($attend_data);

					$data_com['total_days'] 	 = $num_of_days;
					$data_com['num_of_workday']  = $num_working_days;
					$data_com['att_days'] 		 = $attend;
					$data_com['absent_days'] 	 = $absent;
					$data_com['before_after_absent'] 	= $before_after_absent;
					$data_com['c_l']		 	 = $cas_leave;
					$data_com['s_l']		 	 = $sick_leave;
					$data_com['e_l']		 	 = $earn_leave;
					$data_com['m_l']		 	 = $m_leave;
					$data_com['wp' ]	 	 	 = $wp_leave;
					$data_com['sp' ]	 	 	 = $sp_leave;
					$data_com['total_leave'] 	 = $total_leave;
					$data_com['holiday'] 		 = $holiday;
					$data_com['weekend'] 		 = $weekend;
					$data_com['total_holiday']   = $holiday + $weekend;
					$data_com['pay_days'] 		 = $pay_days;
					$data["day_info"] = json_encode($attend_data);

					// attendance log insertion ot salary table
					$log = $this->get_attendance_log($id, $start_date, $end_date);
					$data["log_info"] = json_encode($log);
					//==========END PRESENT STATUS=================


					//======== DEDUCTION STATUS =======================
					//==============================================================
					//ABSENT DEDUCTION FOR NON-COMPLIENCE
					if( $start_date < '30-04-2024'){
						$num_of_day=30;
						if($pay_days != 0){
							$absent = $absent + $wp_leave;
							if($resign_check != false or $left_check != false){
								$before_after_deduct = ($gross_sal / $num_of_days) * $before_after_absent;
								$abs_deduction = ($basic_sal / $num_of_day) * $absent;
								$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
							}else if($salary_month == $join_month){
								$before_after_deduct = ($gross_sal / $num_of_days) * $before_after_absent;
								$abs_deduction = ($basic_sal / $num_of_day) * $absent;
								$abs_deduction = round($abs_deduction + $before_after_deduct + $ml_deduct);
							}else{
								$abs_deduction = ($basic_sal / 30) * $absent;
								$abs_deduction = round($abs_deduction + $ml_deduct);
							}
						} else{
							$abs_deduction = $gross_sal;
						}
						// dd($abs_deduction .' = '. $basic_sal .' / '. $num_of_days .' * '. $absent);
						//ABSENT DEDUCTION FOR COMPLIANCE
						if($pay_days != 0)
						{
							$absent = $absent + $wp_leave ;
							if($resign_check != false or $left_check != false)
							{
								$before_after_deduct = ($gross_sal_com / $num_of_days) * $before_after_absent;
								$abs_deduction_com = ($basic_sal / $num_of_day) * $absent;
								$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
							}
							else if($salary_month == $join_month)
							{
								$before_after_deduct = ($gross_sal_com / $num_of_days) * $before_after_absent;
								$abs_deduction_com = ($ssc['basic_sal'] / $num_of_day) * $absent;
								$abs_deduction_com = round($abs_deduction_com + $before_after_deduct);
							}
							else
							{
								$abs_deduction_com = ($ssc['basic_sal'] / $num_of_day) * $absent;
								$abs_deduction_com = round($abs_deduction_com);
							}
						}
						else
						{
							$abs_deduction_com = $gross_sal_com;
						}
						// dd($num_of_days);
					} else {
						return 'Soryy! Not allow to Process before 30-04-2024';
						exit;
					}

					$advance_deduct = $this->advance_loan_deduction($emp_id, $salary_month);
					//DEDUCTION

					//****** deduct hour & amount **************************************************
					$deduct_hour = $attendances->deduction_hour;
					$per_day_salary = $basic_sal / $num_of_days;
					$per_hour_salary = $per_day_salary / 8;
					$deduct_amount = $per_hour_salary * $deduct_hour;
					//************************ end deduct *******************************************

					//LATE DEDUCTION
					$late_count = $attendances->late_status;
					//STAMP
					$stamp = $ss['stamp'];
					$absent_plus_before_after_absent = $absent + $before_after_absent;
					if($absent_plus_before_after_absent == $num_of_days)
					{
						$stamp = 0;
					}

					//OTHERS DEDUCTION
					$others_deduct = 0;
					$tax_deduct = 0;
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

					// dd($abs_deduction);

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
					//=================== END OF DEDUCTION STATUS ====================


					//============================ ALLOWANCES ===============================
					$allowances = $this->get_emp_allowances($desi_id);
					//=======================================================================

					//======================= ATTN. BONUS ========================
					$att_bouns = $this->get_attn_bonus($rows, $attendances, $salary_month, $attn_rule);
					//======================= ATTN. BONUS END ========================
					// dd($att_bouns);

					//HOLIDAY ALLOWANCE (APPLICABLE FOR OT = NO)
					if (!empty($attendances->holiday_allo) && !empty($allowances->hw_bill)) {
						$holiday_alo_count 			= $attendances->holiday_allo;
						$holiday_allowance_rate 	= $allowances->hw_bill;
						$holiday_allowance 			= $attendances->holiday_allo * $allowances->hw_bill;
					} else {
						$holiday_alo_count 			= 0;
						$holiday_allowance_rate 	= 0;
						$holiday_allowance 			= 0;
					}

					//HOLIDAY ALLOWANCE (APPLICABLE FOR OT = NO)
					if (!empty($attendances->weekly_allo) && !empty($allowances->hw_bill)) {
						$weekend_alo_count 			= $attendances->weekly_allo;
						$weekend_allowance_rate 	= $allowances->hw_bill;
						$weekend_allowance 			= $attendances->weekly_allo * $allowances->hw_bill;
					} else {
						$weekend_alo_count 			= 0;
						$weekend_allowance_rate 	= 0;
						$weekend_allowance 			= 0;
					}

					//NIGHT ALLOWANCE (APPLICABLE FOR OT = NO)
					if (!empty($attendances->night_allo) && !empty($allowances->night_bill)) {
						$night_alo_count 		= $attendances->night_allo;
						$night_allowance_rate 	= $allowances->night_bill;
						$night_allowance 		= $attendances->night_allo * $allowances->night_bill;
					} else {
						$night_alo_count 		= 0;
						$night_allowance_rate 	= 0;
						$night_allowance 		= 0;
					}

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
					//==================== OVERTIME CALCULATION =======================
					//=================================================================

					//OT CALCULATION
					$ot_rate = $ss['ot_rate'];
					if (!empty($attendances->ot) && $rows->ot_entitle != 1) {

						$ot_hour = $attendances->ot;
						$ot_amount = $attendances->ot * $ot_rate;
					} else {
						$ot_rate = 0;
						// $ss['ot_rate'] = 0;
						$ot_hour = 0;
						$ot_amount = 0;
					}

					if (!empty($attendances->ot) && $rows->ot_entitle != 1) {
						$ot_hour = $attendances->ot;
						$ot_amount = $attendances->ot * $ot_rate;
					} else {
						$ot_rate = 0;
						$ot_hour = 0;
						$ot_amount = 0;
					}

					//EXTRA OT CALCULATION
    				if (!empty($ot_hour)) {
						$collect_eot_hour = $attendances->eot;
						$ot_eot_12am_hour = $attendances->ot_eot_12am;
						$ot_eot_4pm_hour  = $attendances->ot_eot_4pm;
						$modify_eot_hour  = $attendances->modify_eot;
						$eot_hour_for_sa  = $this->eot_without_holi_weekend($emp_id, $start_date, $end_date);
						$eot_hour 		  = $collect_eot_hour + $modify_eot_hour - $deduct_hour;

						$eot_amount 		= round($eot_hour * $ot_rate);;
						$ot_eot_12am_amount = round($ot_eot_12am_hour * $ot_rate);
						$ot_eot_4pm_amount  = round($ot_eot_4pm_hour * $ot_rate);
						$eot_amount_for_sa  = round($eot_hour_for_sa * $ot_rate);
    				} else {
						$collect_eot_hour 	= 0;
						$ot_eot_12am_hour 	= 0;
						$ot_eot_4pm_hour  	= 0;
						$modify_eot_hour  	= 0;
						$eot_hour_for_sa  	= 0;
						$eot_hour 		  	= 0;
						$eot_amount 	  	= 0;
						$ot_eot_12am_amount = 0;
						$ot_eot_4pm_amount  = 0;
						$eot_amount_for_sa  = 0;
    				}
					//THIS EOT IS INTRODUCE FOR SUPER ADMIN PRIVILEGE IN ACL
					//THIS EOT AMOUNT IS ALSO INTRODUCE FOR SUPER ADMIN PRIVILEGE IN ACL
					$data["salary_month"] 		= $salary_month;

					// dd($eot_hour_for_sa);
					if($rows->ot_entitle != 1){
						$data["ot_hour"] 			= $ot_hour;
						$data["ot_amount"] 			= $ot_amount;
						$data["ot_rate"] 			= $ot_rate;
						$data["collect_eot_hour"] 	= $collect_eot_hour;
						$data["modify_eot_hour"] 	= $modify_eot_hour;
						$data["eot_hour"] 			= $eot_hour;
						$data["eot_amount"] 		= $eot_amount;
						$data["ot_eot_12am_hour"] 	= $ot_eot_12am_hour;
						$data["ot_eot_12am_amt"] 	= $ot_eot_12am_amount;
						$data["ot_eot_4pm_hour"] 	= $ot_eot_4pm_hour;
						$data["ot_eot_4pm_amt"] 	= $ot_eot_4pm_amount;
						$data["eot_hr_for_sa"] 		= is_null($eot_hour_for_sa) ? 0 : $eot_hour_for_sa;
						$data["eot_amt_for_sa"] 	= $eot_amount_for_sa;
					}else{
						$data["ot_hour"] 			= 0;
						$data["ot_amount"] 			= 0;
						$data["ot_rate"] 			= 0;
						$data["collect_eot_hour"] 	= 0;
						$data["modify_eot_hour"] 	= 0;
						$data["eot_hour"] 			= 0;
						$data["eot_amount"] 		= 0;
						$data["ot_eot_12am_hour"] 	= 0;
						$data["ot_eot_12am_amt"] 	= 0;
						$data["ot_eot_4pm_hour"] 	= 0;
						$data["ot_eot_4pm_amt"] 	= 0;
						$data["eot_hr_for_sa"] 		= 0;
						$data["eot_amt_for_sa"] 	= 0;
					}

					// dd($data);
					$data_com["salary_month"] 		= $salary_month;

					//COMPLIENCE
					if($rows->com_ot_entitle != 1){
						$data_com["ot_hour"] 			= $ot_hour;
						$data_com["ot_amount"] 			= $ot_amount;
						$data_com["ot_rate"] 			= $ot_rate;
						$data_com["collect_eot_hour"] 	= $collect_eot_hour;
						$data_com["modify_eot_hour"] 	= $modify_eot_hour;
						$data_com["eot_hour"] 			= $eot_hour;
						$data_com["eot_amount"] 		= $eot_amount;
						$data_com["ot_eot_12am_hour"] 	= $ot_eot_12am_hour;
						$data_com["ot_eot_12am_amt"] 	= $ot_eot_12am_amount;

						$data_com["ot_eot_4pm_hour"] 	= $ot_eot_4pm_hour;
						$data_com["ot_eot_4pm_amt"] 	= $ot_eot_4pm_amount;
					}else{
						$data_com["ot_hour"] 			= 0;
						$data_com["ot_amount"] 			= 0;
						$data_com["ot_rate"] 			= 0;
						$data_com["collect_eot_hour"] 	= 0;
						$data_com["modify_eot_hour"] 	= 0;
						$data_com["eot_hour"] 			= 0;
						$data_com["eot_amount"] 		= 0;
						$data_com["ot_eot_12am_hour"] 	= 0;
						$data_com["ot_eot_12am_amt"] 	= 0;
						$data_com["ot_eot_4pm_hour"] 	= 0;
						$data_com["ot_eot_4pm_amt"] 	= 0;
					}

					//***************************Festival bonus***********************

					$data["festival_bonus"] 	= 0;
					$data_com["festival_bonus"] = 0;
					//***************************End of Festival bonus***********************//

					// net_pay NON COMPLIENCE and COMPLIENCE
					$data["net_pay"]  = $gross_sal + $att_bouns + $ot_amount - $total_deduction;
					$data_com["net_pay"] = $gross_sal_com + $att_bouns + $ot_amount - $total_deduction_com ;//Zuel 140420


					// dd($data_com);

					$this->db->select("emp_id");
					$this->db->where("emp_id", $rows->emp_id);
					$this->db->where("salary_month", $salary_month);
					$query = $this->db->get("pay_salary_sheet");
					// dd($this->db->last_query());

					if($query->num_rows() > 0 )
					{
						// echo "hello"; exit;
						$this->db->where("emp_id", $rows->emp_id);
						$this->db->where("salary_month", $salary_month);
						$this->db->update("pay_salary_sheet",$data);
					}
					else
					{
						$this->db->insert("pay_salary_sheet",$data);
					}

					//COMPLIENCE
					$this->db->select("emp_id");
					$this->db->where("emp_id", $rows->emp_id);
					$this->db->where("salary_month", $salary_month);
					$query = $this->db->get("pay_salary_sheet_com");

					if($query->num_rows() > 0 )
					{
						//echo "hello";
						$this->db->where("emp_id", $rows->emp_id);
						$this->db->where("salary_month", $salary_month);
						$this->db->update("pay_salary_sheet_com",$data_com);
					}
					else
					{
						$this->db->insert("pay_salary_sheet_com",$data_com);
					}
				}
			}
			return "Process completed successfully";
		}
	}

	// check attendance bonus
	function get_attn_bonus($rows, $attn, $salary_month, $rule)
	{
		// dd($rule->max_leave);
		$n_day = date('t', strtotime($salary_month));
		$w_day = $attn->attend + $attn->weekend + $attn->holiday + $attn->total_leave;

		$this->db->select("ab.*");
		$this->db->from("emp_designation as dg");
		$this->db->join("allowance_attn_bonus as ab", 'dg.attn_id = ab.id', 'left');
		$query = $this->db->where("dg.id", $rows->emp_desi_id)->get()->row();
		// dd($query->rule1_end);
		// check rule amt
		if ($query->rule1_end <= $salary_month) {
			$amt = $query->rule;
		}else if ($query->prev_end >= $salary_month && $query->rule1_end <= $salary_month) {
			$amt = $query->rule1;
		} else {
			$amt = $query->prev_rule;
		}


		// initialize bonus amt
		if (($attn->absent <= $rule->max_absent) && ($attn->late_status <= $rule->max_late_day) && ($attn->late_time <= $rule->max_late_minute) && ($attn->total_leave <= $rule->max_leave) && ($w_day >= $n_day)) {
			$bonus = $amt;
		} else {
			$bonus = 0;
		}
		// dd($bonus);
		return $bonus;
	}

	function get_attn_bonus_rule($salary_month, $unit_id)
	{
		$this->db->where("start_date <=", $salary_month)->where("end_date >=", $salary_month);
		$query = $this->db->where('unit_id', $unit_id)->get('allowance_attn_bonus_rules')->row();
		return $query;
	}
	// check attendance bonus ens

	function get_emp_info($dddd, $unit_id)
	{
		$sql = "SELECT
			pr_emp_com_info.id,
			pr_emp_com_info.emp_id,
			pr_emp_com_info.emp_sal_gra_id as grade_id,
			pr_emp_com_info.emp_dept_id,
			pr_emp_com_info.emp_sec_id,
			pr_emp_com_info.emp_line_id,
			pr_emp_com_info.emp_desi_id,
			pr_emp_com_info.emp_cat_id,
			pr_emp_com_info.emp_join_date,
			pr_emp_com_info.gross_sal,
			pr_emp_com_info.com_gross_sal,
			pr_emp_com_info.ot_entitle,
			pr_emp_com_info.com_ot_entitle,
			pr_emp_per_info.gender
		FROM pr_emp_com_info
		LEFT JOIN pr_emp_per_info ON pr_emp_com_info.emp_id = pr_emp_per_info.emp_id
		WHERE pr_emp_com_info.unit_id = ?
		AND pr_emp_per_info.emp_id IN (".$dddd.")";
		$query = $this->db->query($sql, array($unit_id));
		return $query;
	}

	function get_emp_allowances($desi_id)
	{
		$this->db->select("
				aab.rule attn_bonus,
				ahw.allowance_amount hw_bill,
				aib.allowance_amount iftar_bill,
				anr.night_allowance night_bill,
				atb.allowance_amount tiffin_bill
			");
		$this->db->from("emp_designation as ed");

		$this->db->join("allowance_attn_bonus aab", 'ed.attn_id = aab.id', 'left');
		$this->db->join("allowance_holiday_weekend_rules ahw", 'ed.holiday_weekend_id = ahw.id', 'left');
		$this->db->join("allowance_iftar_bill aib", 'ed.iftar_id = aib.id', 'left');
		$this->db->join("allowance_night_rules anr", 'ed.night_al_id = anr.id', 'left');
		$this->db->join("allowance_tiffin_bill atb", 'ed.tiffin_id = atb.id', 'left');

		$this->db->where('ed.id', $desi_id);
		$query = $this->db->get()->row();

		return $query;
	}

	function advance_loan_deduction($emp_id, $salary_month)
	{
		$this->db->select("*");
		$this->db->from("pr_advance_loan_pay_history alp");

		$this->db->where("alp.emp_id", $emp_id);
		$this->db->like("alp.pay_month", $salary_month);

		$query = $this->db->get()->row();
		return isset($query->pay_amount) ? $query->pay_amount : 0;
	}

	function salary_process_eligibility($emp_id, $salary_month)
	{
		$join_check 		= $this->join_range_check($emp_id, $salary_month);
		$resign_check 		= $this->resign_range_check($emp_id, $salary_month);
		$left_check 		= $this->left_range_check($emp_id, $salary_month);
		// vardump($gross_sal);

		// if($join_check != false and $resign_check != false and $left_check != false and !empty($gross_sal))
		if($join_check != false && $resign_check != false && $left_check != false)
		{
			// dd('ddd');
			return true;
		}
		else
		{
			// dd('fff');
			return false;
		}
	}

	function join_range_check($emp_id, $salary_month)
	{
		$salary_month  = date("Y-m-t", strtotime($salary_month));
		$this->db->select('emp_join_date');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("emp_join_date >", $salary_month);
		// $this->db->where("trim(substr(emp_join_date,1,7)) <= '$salary_month'");
		$query = $this->db->get('pr_emp_com_info');
		// dd($query->result());
		if($query->num_rows() <= 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function resign_range_check($emp_id, $salary_month)
	{
		$this->db->select('resign_date');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("resign_date <", $salary_month);
		$query = $this->db->get('pr_emp_resign_history');
		if($query->num_rows() <= 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function left_range_check($emp_id, $salary_month)
	{
		$this->db->select('left_date');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("left_date <", $salary_month);
		$query = $this->db->get('pr_emp_left_history');
		if($query->num_rows() <= 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function stop_salary_check($emp_id,$start_date)
	{
		$salary_month = date("Y-m", strtotime($start_date));
		$num_rows = $this->db->where("emp_id",$emp_id)->like("salary_month",$salary_month)->get('pay_emp_stop_salary')->num_rows();

		if($num_rows > 0)
		{
			$stop_salary = 2;
		} else {
			$stop_salary = 1;
		}
		return $stop_salary;
	}

    function resign_check($emp_id, $start_date, $end_date)
    {
        $this->db->select('resign_date');
        $this->db->where('emp_id', $emp_id);
        $this->db->where("resign_date BETWEEN '$start_date' AND '$end_date'");
        $query = $this->db->get('pr_emp_resign_history');
        if($query->num_rows() == 0)
        {
            return false;
        }
        else
        {
            $data = array();
            $data['resign_date'] = $query->row()->resign_date;
            $data['resign_day'] = substr($data['resign_date'], 8,2);
            return $data;
        }
    }

    function left_check($emp_id, $start_date, $end_date)
    {
        $this->db->select('left_date');
        $this->db->where('emp_id', $emp_id);
        $this->db->where("left_date BETWEEN '$start_date' AND '$end_date'");
        $query = $this->db->get('pr_emp_left_history');
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

    function get_days($from, $to)
    {
        $first_date = strtotime($from);
        $second_date = strtotime($to);
        $offset = $second_date - $first_date;
        $total_days = floor($offset/60/60/24);
        return $total_days + 1;
    }

    function attendance_check($emp_id,$start_date,$end_date)
    {
		// dd($emp_id.'==='.$start_date.'=='.$end_date);
        $this->db->select("
                COALESCE(SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END ), 0) AS attend,
                COALESCE(SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END ), 0) AS absent,
                COALESCE(SUM(CASE WHEN present_status = 'W' THEN 1 ELSE 0 END ), 0) AS weekend,
                COALESCE(SUM(CASE WHEN present_status = 'H' THEN 1 ELSE 0 END ), 0) AS holiday,
                COALESCE(SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END ), 0) AS total_leave,
                COALESCE(SUM(CASE WHEN late_status   = '1' THEN 1 ELSE 0 END ), 0) AS late_status,
                COALESCE(SUM(CASE WHEN holiday_allo = '1' THEN 1 ELSE 0 END ), 0) AS holiday_allo,
                COALESCE(SUM(CASE WHEN weekly_allo  = '1' THEN 1 ELSE 0 END ), 0) AS weekly_allo,
                COALESCE(SUM(CASE WHEN night_allo   = '1' THEN 1 ELSE 0 END ), 0) AS night_allo,
                COALESCE(SUM(CASE WHEN tiffin_allo  = '1' THEN 1 ELSE 0 END ), 0) AS tiffin_allo,
                COALESCE(SUM(ot), 0) AS ot,
                COALESCE(SUM(eot), 0) AS eot,
                COALESCE(SUM(late_time), 0) AS late_time,
                COALESCE(SUM(ot_eot_4pm), 0) AS ot_eot_4pm,
                COALESCE(SUM(ot_eot_12am), 0) AS ot_eot_12am,
                COALESCE(SUM(modify_eot), 0) AS modify_eot,
                COALESCE(SUM(deduction_hour), 0) AS deduction_hour,
            ");

        $this->db->where('emp_id',$emp_id);
        $this->db->where("shift_log_date BETWEEN '$start_date' AND '$end_date'");
        $query = $this->db->get('pr_emp_shift_log')->row();
		// dd($query);


        return $query;
    }

    function leave_db($emp_id, $start_date, $end_date){


		$this->db->select("
            SUM(CASE WHEN leave_type = 'cl' THEN total_leave ELSE 0 END ) AS cl,
            SUM(CASE WHEN leave_type = 'sl' THEN total_leave ELSE 0 END ) AS sl,
            SUM(CASE WHEN leave_type = 'el' THEN total_leave ELSE 0 END ) AS el,
            SUM(CASE WHEN leave_type = 'ml' THEN total_leave ELSE 0 END ) AS ml,
            SUM(CASE WHEN leave_type = 'wp' THEN total_leave ELSE 0 END ) AS wp,
            SUM(CASE WHEN leave_type = 'sp' THEN total_leave ELSE 0 END ) AS sp
            ");
        $this->db->where("emp_id",$emp_id);
        $this->db->where("leave_start >=", $start_date);
        $this->db->where("leave_end <=", $end_date);
        $query = $this->db->get('pr_leave_trans')->row();
		// dd(date($start_date));

		$start_date_current_month = date($start_date); // Start of current month
		$end_date_current_month   = date($end_date);   // End of current month


		// Calculate overlapping leave days for the current month
		$this->db->select("
			leave_type,
			SUM(CASE
				WHEN leave_start <= '{$end_date_current_month}'
				AND leave_end >= '{$start_date_current_month}'
				THEN
					CASE
						WHEN leave_start < '{$start_date_current_month}' THEN
							DATEDIFF(LEAST(leave_end, '{$end_date_current_month}'), '{$start_date_current_month}') + 1
						ELSE
							DATEDIFF(LEAST(leave_end, '{$end_date_current_month}'), leave_start) + 1
					END
				ELSE 0
			END) AS total_leave_current_month
		");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("leave_start <= '{$end_date_current_month}'");
		$this->db->where("leave_end >= '{$start_date_current_month}'");
		$this->db->group_by("leave_type");
		$this->db->order_by("leave_type", 'ASC');
		$querys = $this->db->get('pr_leave_trans')->result();
		if( !empty($querys) ){
			$leave_counts = [
				'cl' => 0,
				'sl' => 0,
				'el' => 0,
				'ml' => 0,
				'wp' => 0,
				'sp' => 0,
			];

			// Process query results
			foreach ($querys as $row) {
				$leave_counts[$row->leave_type] = $row->total_leave_current_month;
			}

			return $leave_counts;

		}


		$cas_leave  = $query->cl;
		$sick_leave = $query->sl;
		$earn_leave = $query->el;
		$wp_leave   = $query->wp;
		$sp_leave   = $query->sp;

		if (!empty($cas_leave !=0 ||  $sick_leave !=0 || $earn_leave !=0 || $wp_leave !=0 ||   $sp_leave !=0 )) {
            return (array)$query;
        }else{

		$leaves2 = $this->leave_db2($emp_id, $start_date, $end_date);
		$leaves3 = $this->leave_db3($emp_id, $start_date, $end_date);
		// dd($query );

			if($leaves2 !=null || !empty($leaves2)){

				if (!empty($leaves2) && $leaves2['leave_type'] == 'sl') {
					$sick_leave = $sick_leave + $leaves2['day'];
				} elseif (!empty($leaves2) && $leaves2['leave_type'] == 'cl') {
					$cas_leave = $cas_leave + $leaves2['day'];
				} elseif (!empty($leaves2) && $leaves2['leave_type'] == 'el') {
					$earn_leave = $earn_leave + $leaves2['day'];
				} elseif (!empty($leaves2) && $leaves2['leave_type'] == 'wp') {
					$wp_leave = $wp_leave + $leaves2['day'];
				} elseif (!empty($leaves2) && $leaves2['leave_type'] == 'sp') {
					$sp_leave = $sp_leave + $leaves2['day'];
				}

				$leaves22 = [
					"cl"=>	$cas_leave,
					"sl"=>  $sick_leave,
					"el"=>	$earn_leave,
					"wp"=>  $wp_leave,
					"sp"=>	$sp_leave
				];

				return $leaves22;
			}
			if($leaves3 !=null || !empty($leaves3)){
				if (!empty($leaves3) && $leaves3['leave_type'] == 'sl') {
					$sick_leave = $sick_leave + $leaves3['day'];
				} elseif (!empty($leaves3) && $leaves3['leave_type'] == 'cl') {
					$cas_leave = $cas_leave + $leaves3['day'];
				} elseif (!empty($leaves3) && $leaves3['leave_type'] == 'el') {
					$earn_leave = $earn_leave + $leaves3['day'];
				} elseif (!empty($leaves3) && $leaves3['leave_type'] == 'wp') {
					$wp_leave = $wp_leave + $leaves3['day'];
				} elseif (!empty($leaves3) && $leaves3['leave_type'] == 'sp') {
					$sp_leave = $sp_leave + $leaves3['day'];
				}
				$leaves= [
					"cl"=>	$cas_leave,
					"sl"=>  $sick_leave,
					"el"=>	$earn_leave,
					"wp"=>  $wp_leave,
					"sp"=>	$sp_leave
				];
				return $leaves;
			}

		}

    }

	function leave_db2($emp_id, $start_date, $end_date)
    {
		$array = array();
        $this->db->select("*");
        $this->db->where("emp_id",$emp_id);
        $this->db->where("leave_end >", $start_date);
        $this->db->where("leave_end <=", $end_date);
        $this->db->order_by("id", 'DESC');
        $query = $this->db->get('pr_leave_trans')->row();
		// dd($query);
		// dd($this->db->last_query());
		if (!empty($query)) {
			$end_date  = $query->leave_end;
			$day_diff = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) +1;
			$array = array(
				'leave_type' => $query->leave_type,
				'day' => $day_diff,
			);
		}
        return $array;
    }

	function leave_db3($emp_id, $start_date, $end_date)
    {
		$array = array();
        $this->db->select("*");
        $this->db->where("emp_id",$emp_id);
        $this->db->where("leave_start <", $end_date);
        $this->db->where("leave_end >", $end_date);
        $query = $this->db->get('pr_leave_trans')->row();
		if (!empty($query)) {
			$start_date = $query->leave_start;
			$day_diff = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1;
			$array = array(
				'leave_type' => $query->leave_type,
				'day' => $day_diff,
			);
		}
        return $array;
    }

	function ml_leave_db($emp_id, $start_date, $end_date, $gross_sal, $gross_sal_com)
    {
		$array = array();
		$day_ml = 0;
        $this->db->select("*");
        $this->db->where("emp_id",$emp_id);
        $this->db->where("leave_type",'ml');
        $this->db->where("leave_start <", $end_date);
        $this->db->where("leave_end >", $end_date);
        $query = $this->db->get('pr_leave_trans')->row();
		if (!empty($query)) {
			$start_date = $query->leave_start;
			$day_ml = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1;
		}

        $this->db->select("*");
        $this->db->where("emp_id",$emp_id);
        $this->db->where("leave_type",'ml');
        $this->db->where("leave_end >", $start_date);
        $this->db->where("leave_end <=", $end_date);
        $this->db->order_by("id", 'DESC');
        $query = $this->db->get('pr_leave_trans')->row();

		if (empty($day_ml) && !empty($query)) {
			$end_date  = $query->leave_end;
			$day_ml = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1;
		}

        $this->db->select("*");
        $this->db->where("emp_id",$emp_id);
        $this->db->where("leave_type",'ml');
        $this->db->where("leave_start <=", $start_date);
        $this->db->where("leave_end >=", $end_date);
        $this->db->order_by("id", 'DESC');
        $query = $this->db->get('pr_leave_trans')->row();

		if (empty($day_ml) && !empty($query)) {
			$day_ml = date('t', strtotime($start_date));
		}

		if (!empty($day_ml)) {
			$mll_d_d = date('t', strtotime($start_date));
			$mlg   = round(($gross_sal / $mll_d_d), 2);
			$mlgc  = round(($gross_sal_com / $mll_d_d), 2);
			$array['ml_leave_day'] = $day_ml;
			$array['deduct_gross'] = $mlg * $day_ml;
			$array['deduct_g_com'] = $mlgc * $day_ml;
			$array['status'] = true;
		} else {
			$array['ml_leave_day'] = 0;
			$array['deduct_gross'] = 0;
			$array['deduct_g_com'] = 0;
			$array['status'] = false;
		}
        return $array;
    }

	function eot_without_holi_weekend($emp_id, $start_date, $end_date)
	{
		$this->db->select_sum("eot");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("present_status !=", 'W');
		$this->db->where("present_status !=", 'H');
		$this->db->where("shift_log_date BETWEEN '$start_date' AND '$end_date'");
		$query = $this->db->get("pr_emp_shift_log");
		$row = $query->row();
		// dd($this->db->last_query());
		return $row->eot;
	}

	function get_attendance_log($emp_id, $start_date, $end_date)
	{
		$this->db->select('
			    shift_log_date,
	            in_time,
	            out_time,
	            ot,
	            eot
			');

		$this->db->from('pr_emp_shift_log');
		$this->db->where("emp_id", $emp_id);
		$this->db->where("shift_log_date BETWEEN '$start_date' and '$end_date'");
		$this->db->limit(100);
		$results = $this->db->get()->result();
		$obj = array();
		foreach ($results as $key => $rows) {
			$obj[$key] = array(
				'log_date' 		=> $rows->shift_log_date,
				'in_time' 		=> $rows->in_time,
				'out_time' 		=> $rows->out_time,
				'ot' 		 	=> $rows->ot,
				'eot' 		 	=> $rows->eot,
			);
		}
		return $obj;
	}







	//////////////////// old code /////////////////////////////

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
				$holiday_allowance_rate = $this->db->where("rules_id",$holiday_allowance_rules['rules_id'])->get('pr_holiday_allowance_rules')->row()->allowance_amount;
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

	function get_holiday_alo_count($emp_id,$year,$month){
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
				$night_allowance	 	= $night_allowance_rate * $night_alo_count;
		}
		else
		{
			$night_allowance 		= 0;
			$night_allowance_rate  	= 0;
		}
		$data['night_allowance_rate'] 	= $night_allowance_rate;
		$data['night_allowance'] 		= $night_allowance;
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
		return $data;
	}
	function get_night_alo_count($emp_id,$year,$month)
	{
		$year_month = $year."-".$month;
		$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
		$this->db->where('emp_id', $emp_id);
		$this->db->where('night_allo', '1');
		$this->db->from('pr_emp_shift_log');
		return  $this->db->count_all_results();

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

	function modify_eot_hour($emp_id, $year_month)
	{
		$this->db->select_sum("modify_eot");
		$this->db->where("emp_id", $emp_id);
		$this->db->like("shift_log_date",$year_month);
		$query = $this->db->get("pr_emp_shift_log");
		$row = $query->row();
		return $row->modify_eot;
	}

	function ot_hour($emp_id, $year_month, $ot_rate)
	{
		$this->db->select_sum("ot_hour");
		$this->db->where("emp_id", $emp_id);
		$this->db->like("shift_log_date",$year_month);
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->ot_hour;
	}

	function eot_hour($emp_id, $year_month)
	{
		$this->db->select_sum("extra_ot_hour");
		$this->db->where("emp_id", $emp_id);
		$this->db->like("shift_log_date",$year_month);
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->extra_ot_hour;
	}

	function ot_eot_4pm_hour($emp_id, $year_month)
	{
		$this->db->select_sum("ot_eot_4pm");
		$this->db->where("emp_id", $emp_id);
		$this->db->like("shift_log_date",$year_month);
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->ot_eot_4pm;
	}

	function ot_eot_12am_hour($emp_id, $year_month)
	{
		$this->db->select_sum("ot_eot_12am");
		$this->db->where("emp_id", $emp_id);
		$this->db->like("shift_log_date",$year_month);
		$query = $this->db->get("pr_emp_shift_log");
		//echo $this->db->last_query();
		$row = $query->row();
		return $row->ot_eot_12am;
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


	function insert_pay_sheet($data)
	{
		$this->db->insert('pr_pay_scale_sheet', $data);
	}

	function update_pay_sheet($data)
	{
		$this->db->where("emp_id",$data['emp_id']);
		$this->db->update('pr_pay_scale_sheet', $data);

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

	function get_late_count($emp_id,$year,$month)
	{
		$year_month = $year."-".$month;
		$this->db->where("trim(substr(shift_log_date,1,7)) = '$year_month'");
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



	function resign_day_count($resign_date, $end_date_of_month)
	{
		$resign_day = date('d', strtotime($resign_date));
		return $resign_day_count = $end_date_of_month - $resign_day;
	}

	function new_join_day_count($first_day_of_month, $join_date)
	{
		$first_day_of_month = date('d', strtotime($first_day_of_month));
		$join_date = date('d', strtotime($join_date));
		return $resign_day_count = $join_date - $first_day_of_month;
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



}
?>

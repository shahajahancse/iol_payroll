<?php
class Leave_model extends CI_Model{
	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Earn_leave_model');
		$this->load->model('common_model');
		
		/* Standard Libraries */
	}

	function three_month_back_record($emp_id,$leave_start_date)
   	{
		$data = array();
		$date = new DateTime($leave_start_date);
		$date->sub(new DateInterval('P1M'));
		$data['first_month'] = $date->format('Y-m');
		$date->sub(new DateInterval('P1M'));
		$data['second_month'] = $date->format('Y-m');   
		$date->sub(new DateInterval('P1M'));
		$data['third_month'] = $date->format('Y-m');
		//print_r($data); exit;
		return($data);
	}

	function save_leave_db()
	{	
		$unit_id = $this->common_model->get_session_unit_id_name();
		if($unit_id == 0){return "Please Login As an Unit User.";}

		$empid_leave=$this->input->post('empid_leave');
		$sStartDate = date("Y-m-d", strtotime($this->input->post('start_leave_date'))); 
		$sEndDate = date("Y-m-d", strtotime($this->input->post('end_leave_date')));
		$leave_type=$this->input->post('leave_type');
		
		$startyear_leave = trim( substr($sStartDate,1,4 ) );
		$endyear_leave = trim( substr($sEndDate,1,4 ) );
		
		$earn_year = date("Y", strtotime($sStartDate));
		$table_name = "pr_earn_leave";
		 
		$query_numrows = $this->empid_test($empid_leave);  //check the valid emp id
		if(!$query_numrows->num_rows())
		{
			return  "Invalid employee ID";
		}
		$query_marital_status = $this->employee_per_info($empid_leave); //collect the employee personal information
		foreach ($query_marital_status->result() as $row) {
		$emp_sex = $row->emp_sex ;
   		$emp_maritalstatus = $row->emp_marital_status ;
		}
		
		$emp_status = $this->find_emp_status($empid_leave);  //collect employee category id
		//echo $emp_status;
		
		if($emp_status == 2 && $leave_type == "ml" || $emp_status == 2 && $leave_type == "pl" || $emp_status == 2 && $leave_type == "cl" || $emp_status == 2 && $leave_type == "el" || $emp_status == 2 && $leave_type == "do" || $emp_status == 2 && $leave_type == "stl")
		{
			 return "New Employee Doesn't Entitle Selected Leave.";
		}
		
		
		if($emp_status == 0)
		{
				return "Employee ID does not exist";
		}
		elseif($leave_type == "el"  && $startyear_leave != $endyear_leave)
		{
			 return "Start Date And End Date Should Be Same Year For Earn Leave";
		}
		elseif($emp_status == 2 && $leave_type == "ml")
		{
			 return "Probationer Employee Doesn't Entitle Maternity Leave";
		}
		elseif($emp_status == 2 && $leave_type == "pl")
		{
			 return "Probationer Employee Doesn't Entitle Paternity Leave";
		}
		elseif($emp_status == 5 && $leave_type == "ml")
		{
			 return "Contractual Employee Doesn't Entitle Maternity Leave";
		}
		elseif($emp_status == 5 && $leave_type == "pl")
		{
			 return "Contractual Employee Doesn't Entitle Paternity Leave";
		}
		else if($emp_maritalstatus ==1 && $leave_type == "ml" || $emp_maritalstatus ==1 && $leave_type == "pl" )
		{
			return "Unmarried Employee Doesn't Entitle Maternity or Paternity Leave";
		}
		elseif($emp_sex == 1 && $leave_type == "ml")
		{
			 return "Male Employee Doesn't Entitle Maternity Leave";
		}
		
		elseif($emp_sex == 2 && $leave_type == "pl")
		{
			 return "Female Employee Doesn't Entitle Paternity Leave";
		}
		else
		{
		    $pass_leave = $this->pass_leave_cal($empid_leave,$startyear_leave,$leave_type);  //coleect the employee passing selected leave
			//take the  main leave balance
			$days = $this->GetDays($sStartDate,$sEndDate);
			$result = count($days);	
			if($leave_type == "el")
			{
				$earn_paid		= $this->Earn_leave_model->get_earn_leave_paid($empid_leave,$earn_year);
				$yearly_earn	= $this->Earn_leave_model->get_yearly_earn_leave($empid_leave,$table_name);
				$due_leave  = $yearly_earn - $earn_paid;

			}
			else
			{
				$leave_balance = $this->leave_status_check($emp_status,$leave_type,$empid_leave,$sStartDate,$sEndDate); //coleect the employee balance selected leave
				$due_leave = $leave_balance - $pass_leave;
			}
			
			

			if($due_leave < $result)
			{
				echo "Leave Exceed";
			}
			else
			{	
				
				
				if($leave_type=="el")
				{
					$this->leave_insert($emp_status,$leave_type,$empid_leave,$sStartDate,$sEndDate);

					$this->db->select("*");
					$this->db->from('pr_earn_leave');
					$this->db->where("emp_id",$empid_leave);
					$this->db->limit(1);
					$this->db->order_by("id","desc");
					$last_row=$this->db->get()->row();
					// echo $last_row->earn_leave;exit;

					$earn_leave= $last_row->el + $result;

					$total_earn_leave = $last_row->earn_leave - $result;

					$data = array(
									'el'=> $earn_leave,
									'earn_leave'=> $total_earn_leave
								);

					// echo print_r($data);exit;			
					$this->db->where("id",$last_row->id);
					$this->db->update('pr_earn_leave',$data);
					echo "Save Successfully";

				}
				else{
					$this->leave_insert($emp_status,$leave_type,$empid_leave,$sStartDate,$sEndDate);
					echo "Save Successfully";
				}

			    
			
			}
		
		}
	}
	function leave_insert($emp_status,$leave_type,$empid_leave,$sStartDate,$sEndDate)
	{
		$days = $this->GetDays($sStartDate,$sEndDate);
		$this->leave_duplicate_entry_check($empid_leave, $sStartDate,$sEndDate);
		
		$unit_id = $this->common_model->get_session_unit_id_name();
		
		$leave_start= date("Y-m-d", strtotime($sStartDate));
		$leave_end = date("Y-m-d", strtotime($sEndDate));

		foreach($days as $day)
		{
			$holiday_check = $this->db->where('emp_id',$empid_leave)->where('holiday_date',$day)->get('attn_holiday')->num_rows();
			if($holiday_check > 0)
			{
				continue;
			}
			
			$weekend_check = $this->db->where('emp_id',$empid_leave)->where('work_off_date',$day)->get('attn_work_off')->num_rows();
			if($weekend_check > 0)
			{
				continue;
			}
			
			//$this->leave_duplicate_entry_check($empid_leave, $day);
			$data = array(
					'emp_id'		=> $empid_leave,
					'unit_id'		=> $unit_id,
					'leave_start' 	=> $leave_start,
					'leave_end' 	=> $leave_end,
					'start_date'    => $day ,
					'leave_type'	=> $leave_type	);
			$this->db->insert('pr_leave_trans', $data);
		}

	}
	
	function empid_test($empid)
	{
		$this->db->select('*')->from('pr_emp_per_info')->where('emp_id', $empid);
		$query_numrows = $this->db->get();
		return $query_numrows;
	}
	function employee_per_info($empid)
	{
		$this->db->select('*');//get married and unmarried
		$this->db->where("emp_id", $empid);
		$query_marital_status = $this->db->get('pr_emp_per_info');
		return $query_marital_status;
	}
	function pass_leave_cal($empid_leave,$startyear_leave,$leave_type)
	{
		$this->db->select('id');	
		$this->db->where('emp_id',$empid_leave);
		$this->db->where('leave_type',$leave_type);
		$where="trim( substr(start_date,2,4 ) ) = '$startyear_leave' ";
		$this->db->where($where);
		$query_leave = $this->db->get('pr_leave_trans');
		$pass_leave =  $query_leave->num_rows();
		return $pass_leave;
	}
	function find_emp_status($emp)
	{
		$this->db->select('*');
		$this->db->where("emp_id", $emp);
		$query = $this->db->get('pr_emp_com_info');
		//echo $this->db->last_query();
		$num_rows = $query->num_rows();
		foreach ($query->result() as $row) {
   		$emp_status = $row->emp_cat_id ;
		}
		
		if ($num_rows == 0 )
		{
		  return 0;
		}
		else
		{
			return $emp_status;
		}
	}

	function leave_status_check($emp_status,$leave_type,$empid_leave,$sStartDate,$sEndDate)
	{
	    $this->db->select('*');
		$this->db->where("status_id", $emp_status);
		$balance_query = $this->db->get('pr_leave');
		//echo $this->db->last_query();
		foreach ($balance_query->result() as $row) {
   		$casual_balance = $row->lv_cl ;
		$sick_balance = $row->lv_sl ;
		$maternity_balance = $row->lv_ml ;
		$paternity_balance = $row->lv_pl ;
		}
		if($leave_type == "cl")
		{
			return $casual_balance;
		}
		else if($leave_type == "sl")
		{
			return $sick_balance;
		}
		else if($leave_type == "ml")
		{
			return $maternity_balance;
		}
		else if($leave_type == "pl")
		{
			return $paternity_balance;
		}
		else if($leave_type == "el")
		{
			$year = substr($sStartDate,1,4);
			return $total_earn_leave = $this->get_earn_leave($empid_leave, $year);
		}
		else
		{
			$this->leave_insert($emp_status,$leave_type,$empid_leave,$sStartDate,$sEndDate);  // for without pay , study leave ectc.
					echo "Save Successfully";
			exit ();
		//$this->leave_insert($emp_status,$leave_type,$empid_leave,$sStartDate,$sEndDate);
			//return "Save successfully";
		}

	}
	

	/*function leave_duplicate_entry_check($empid_leave, $day)
	{
		$this->db->select('leave_type');
		$where="emp_id = '$empid_leave' and  start_date = '$day' ";
		$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		$num_rows = $query->num_rows();
		if ($num_rows > 0 )
		{
			echo "Duplicate date not allow";
			exit();
		}
		else
		{
			return true;
		}
	}*/
	function leave_duplicate_entry_check($empid_leave,$sStartDate,$sEndDate)
	{
		$this->db->select('leave_type');
		$where="emp_id = '$empid_leave' and  start_date BETWEEN '$sStartDate' and '$sEndDate' ";
		$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		$num_rows = $query->num_rows();
		if ($num_rows > 0 )
		{
			echo "Duplicate date not allow";
			exit();
		}
		else
		{
			return true;
		}
	}
		
	function leave_transaction_db()
	{
		$empid=$this->input->post('empid');
		$year=$this->input->post('year');
		$table_name = "pr_earn_leave";
		
		$query_numrows = $this->empid_test($empid);
		if(!$query_numrows->num_rows())
		{
			return  "Invalid employee ID";
		}
	
		$leave_type_cl='cl';
		$leave_type_sl='sl';
		$leave_type_el='el';
		$leave_type_pl='pl';
		$leave_type_ml='ml';
		
		$this->db->select('leave_type');
	    $where="emp_id = '$empid' and leave_type = '$leave_type_cl' and trim( substr(start_date,1,4 ) ) = '$year' ";
    	$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		$total_casual_leave = $query->num_rows();
		
		
		
		
		$this->db->select('leave_type');
	    $where="emp_id = '$empid' and leave_type = '$leave_type_sl' and trim( substr(start_date,1,4 ) ) = '$year' ";
    	$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		$total_sick_leave = $query->num_rows();
		
		
		// $this->db->select('leave_type');
	    // $where="emp_id = '$empid' and leave_type = '$leave_type_el' and trim( substr(start_date,1,4 ) ) = '$year' ";
    	// $this->db->where($where);
		// $query = $this->db->get('pr_leave');
		// $total_earn_leave = $query->num_rows();
		$this->db->select('el,earn_leave');
		$this->db->from('pr_earn_leave');
		$this->db->where("emp_id" , $empid);
		$this->db->limit(1);
		$this->db->order_by('id',"DESC");
		$earn_leave =$this->db->get()->row();

		// echo print_r($total_earn_leave);exit;
		
		$this->db->select('leave_type');
	    $where="emp_id = '$empid' and leave_type = '$leave_type_pl' and trim( substr(start_date,1,4 ) ) = '$year' ";
    	$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		$total_paternity_leave = $query->num_rows();
		
		$this->db->select('leave_type');
	    $where="emp_id = '$empid' and leave_type = '$leave_type_ml' and trim( substr(start_date,1,4 ) ) = '$year' ";
    	$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		$total_maternity_leave = $query->num_rows();
		
		 
		$data1=array(
					'casual'    =>$total_casual_leave,
					'sick'      =>$total_sick_leave,
					'earn'      =>$earn_leave->el,
					'maternity' =>$total_maternity_leave,
					'paternity' =>$total_paternity_leave
					);


				  $data_leave_emp = implode("-*-",$data1);
					//echo $data_leave_emp ;
					
					
	 //leave balance test
		$query_marital_status = $this->employee_per_info($empid);
		
		foreach ($query_marital_status->result() as $row) {
		$emp_sex = $row->emp_sex ;
   		$emp_maritalstatus = $row->emp_marital_status ;
		}
	 	
		$this->db->select('emp_cat_id');
		$this->db->where("emp_id", $empid);
		$query_status = $this->db->get('pr_emp_com_info');
		
		foreach ($query_status->result() as $row) {
   		$empstatus = $row->emp_cat_id ;
		}
		
		if($empstatus == 6)
		{
			return  "Invalid employee ID";
		}
		
		$this->db->select('stat_des');
		$this->db->where("stat_id", $empstatus);
		$status_name = $this->db->get('pr_emp_status');
		
		foreach ($status_name->result() as $row) {
   		$status_name = $row->stat_des ;
		}
		
		$this->db->select('*');
		$this->db->where("status_id", $empstatus);
		$query_balance = $this->db->get('pr_leave');
		
		foreach ($query_balance->result() as $row) {
   		$casual_leave_balance = $row->lv_cl ;
		$sick_leave_balance = $row->lv_sl ;
		//$maternity_leave_balance = $row->lv_ml ;
		//$paternity_leave_balance = $row->lv_pl ;
			if($emp_maritalstatus == 1)
			{
			$maternity_leave_balance = 0;
			$paternity_leave_balance = 0;
			}
			else
			{
				if($emp_sex==1)//for male
				{
				$maternity_leave_balance = 0 ;
				$paternity_leave_balance = $row->lv_pl ;
				}
				else 
				{
				$maternity_leave_balance = $row->lv_ml ;
				$paternity_leave_balance = 0;
				}
			}
		}
		
		//$earn_leave_balance = $this->get_earn_leave($empid, $year);
		
		/*$this->db->select('old_earn_balance,current_earn_balance');
		$this->db->where("emp_id", $empid);
		$query = $this->db->get('pr_leave_earn');
		if($query->num_rows() > 0){
			$rows = $query->row();
			$earn_leave_balance = $rows->old_earn_balance;
		}else{
			$earn_leave_balance = 0;
		}
		*/
		$earn_paid		= $this->Earn_leave_model->get_earn_leave_paid($empid,$year);
		$yearly_earn	= $this->Earn_leave_model->get_yearly_earn_leave($empid,$table_name);
		$earn_leave_balance = $yearly_earn - $total_earn_leave - $earn_paid;
				
		$data2=array(
					'casual_balance'    =>$casual_leave_balance,
					'sick_balance'      =>$sick_leave_balance,
					'earn_balance'      =>$earn_leave->earn_leave,
					'maternity_balance' =>$maternity_leave_balance,
					'paternity_balance' =>$paternity_leave_balance,
					'status_name'       =>$status_name
					);
		$data_leave_com = implode("-*-",$data2);
		
		$this->db->select('*');
		$this->db->where("emp_id", $empid);
		$query_emp = $this->db->get('pr_emp_per_info');
		
		foreach ($query_emp->result() as $row) {
   		$emp_name = $row->emp_full_name ;
		$img_source = $row->img_source;
		}	
		
		$data3=array(
					'emp_name'    =>$emp_name,
					'emp_image'   =>$img_source
					);
		$data_leave_per = implode("-*-",$data3);
			
		return $data_leave_emp."***".$data_leave_com."***".$data_leave_per;	
			
	}	
	
	function get_earn_leave($empid, $year)
	{
		$total_present = $this->get_total_present_by_year($empid, $year);
		$earn_leave_balance = $total_present / 18;		
		return $earn_leave_balance = floor($earn_leave_balance);
	}
	
	function get_total_present_by_year($empid, $year)
	{
		$total_present = 0;
		
		for( $i = 1; $i<= 31; $i++)
		{
			$i = date("d", mktime(0, 0, 0, 01, $i, 2011));
			$date_field = "date_$i";
			
			$this->db->select($date_field);
			$this->db->where("emp_id", $empid);
			$this->db->where($date_field, "P");
			$this->db->like("att_month", $year);
			$query = $this->db->get('pr_attn_monthly');
			//echo $this->db->last_query();
			$present_count = $query->num_rows();
			if( $present_count != 0 )
			{
				$total_present = $total_present + $present_count ;
			}
		}
		return $total_present;
	}

	function get_salary_info_for_ml_leave($emp_id,$salary_month)
	{
		// echo $emp_id.'ggg'; exit;
		$data = array();
		$this->db->select('*');	
		$this->db->where('emp_id',$emp_id);
		$this->db->like('salary_month',$salary_month,'after');
		return $query = $this->db->get('pay_salary_sheet');
	}
	
	function get_designation($emp_desi_id)
	{
		$this->db->select('desig_name');
		$this->db->where('desig_id', $emp_desi_id);
		$query = $this->db->get('pr_designation');
		$row = $query->row();
		return $desig_name = $row->desig_name;
	}
	
	function get_section_name($emp_sec_id)
	{
		$this->db->select('sec_name');
		$this->db->where('sec_id', $emp_sec_id);
		$query = $this->db->get('pr_section');
		$row = $query->row();
		return $sec_name = $row->sec_name;
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
     		while($sCurrentDate < $sEndDate){  
       		// Add a day to the current date  
       		$sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
     
       		// Add this new day to the aDays array  
        		$aDays[] = $sCurrentDate; 
			//print_r($aDays);
     	}  
     
     // Once the loop has finished, return the  
     
     return $aDays;  
   }
	
}
?>
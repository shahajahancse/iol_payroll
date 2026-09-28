<?php
class Left_resign_model extends CI_Model{
	
	
	function __construct()
	{
		parent::__construct();

	}
	
	function search_empid_for_resign_left()
	{
		$get_session_user_unit = $this->common_model->get_session_unit_id_name();
		$lefr_resign_search_text = $this->input->get('term',TRUE);
		$this->db->select('emp_id');
		$this->db->where('unit_id',$get_session_user_unit);
		$this->db->like('emp_id',$lefr_resign_search_text);
		$this->db->limit('5');
		return $query = $this->db->get('pr_emp_com_info');
	}
	
	function get_left_resign_info()
	{
		
		$left_resign_search_text = $this->input->post('left_resign_search_text');
		
		$this->db->select('emp_id,emp_cat_id,unit_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_com_info.emp_id', $left_resign_search_text);
		
		$query = $this->db->get();	
		
		if($query->num_rows()< 1)
		{
			echo "This Employee ID Not Exists!";
			return;
		}
		foreach($query->result() as $rows)
		{
			$current_status = $rows->emp_cat_id;
			
			
			if($current_status!= "1"){
				if($current_status == "3"){
					$effective_date = $this->db->where("emp_id",$rows->emp_id)->get('pr_emp_left_history')->row()->left_date;
					$effective_date = date("d-m-Y",strtotime($effective_date));
					$current_status_name = "Left";
					
				}else if($current_status == "4"){
					$effective_date = $this->db->where("emp_id",$rows->emp_id)->get('pr_emp_resign_history')->row()->resign_date;
					$effective_date = date("d-m-Y",strtotime($effective_date));
					$current_status_name = "Resign";
				}
				else{
					$effective_date = " ";
					$current_status_name = "Null";
				}
				
			}else{
				$effective_date = "";
				$current_status_name = "Null";
			}
			$data["emp_id"] 	= $rows->emp_id;
			$data["effec_date"] = $effective_date;
			$data["status"] 	= $current_status;
			$data["status_name"]= $current_status_name;
			
			/*$data["emp_name"] 	= $rows->emp_full_name;
			$data["dept_name"] 	= $rows->dept_name;
			$data["sec_name"] 	= $rows->sec_name;
			$data["line_name"] 	= $rows->line_name;
			$data["desig_name"]	= $rows->desig_name;
			$data["doj"] 		= $rows->emp_join_date;
			$data["emp_dob"] 	= $rows->emp_dob;
			$data["gross_sal"] 	= $rows->gross_sal;
			$data["gr_name"]	= $rows->gr_name;
			$data["status"]		= $rows->stat_type;*/
		}
		$data = implode("===",$data);
		return $data;
		
	}
	
	function left_resign_and_regular_action()
	{
		$emp_id 				= $this->input->post('emp_id');
		$left_res_button_value 	= $this->input->post('left_res_button_value');
		$left_resign_status 	= $this->input->post('left_resign_status');
		$effective_date			= $this->input->post('effective_date');
		
		$unit_id = $this->db->where("emp_id",$emp_id)->get('pr_emp_com_info')->row()->unit_id;
		
		if($left_resign_status == "3"){
			$table_name = "pr_emp_left_history";
			$column_date = "left_date";
		}
		else{
			$table_name = "pr_emp_resign_history";
			$column_date = "resign_date";
		}
		
		if($left_res_button_value == "regular")
		{
			$this->db->where('emp_id', $emp_id);
			$this->db->delete($table_name); 
			
			$data = array(
               'emp_cat_id' => 1
            );

			$this->db->where('emp_id', $emp_id);
			$this->db->update('pr_emp_com_info', $data); 
		}
		else
		{
			$data = array(
               'emp_cat_id' => $left_resign_status
            );

			$this->db->where('emp_id', $emp_id);
			$this->db->update('pr_emp_com_info', $data); 
			
			$effective_date = date("Y-m-d",strtotime($effective_date));
			$data1 = array(
				'unit_id' => $unit_id,
			   	'emp_id' => $emp_id,
			   	$column_date => $effective_date
			);

			$this->db->insert($table_name, $data1); 
			
			$data2 = array(
               'proxi_id' => ""
            );

			$this->db->where('emp_id', $emp_id);
			$this->db->update('pr_id_proxi', $data2); 
		}
		
		echo "Succesfully Completed!";
		return;
	}
	
}
?>
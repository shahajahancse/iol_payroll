<?php
class Emp_info_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
		$this->load->model('Processdb');
		$this->load->model('Common_model');

		if($this->session->userdata('logged_in')==FALSE)
		{
			redirect("authentication");
		}
		$this->data['user_data'] = $this->session->userdata('data');
		if (!check_acl_list($this->data['user_data']->id,1)) {
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
			redirect("payroll_con");
			exit;
		}
	}

	function personal_info()
	{
        $this->data['units'] = $this->db->select('pr_units.*')->get('pr_units')->result();
		//dd($this->data['units']);

		$this->data['title'] = 'Personal Information';
		$this->data['username'] = $this->data['user_data']->id_number;

		$this->data['subview'] = 'empInfo/personal_info';
		$this->load->view('layout/template', $this->data);
	}

	function personal_info_short()
	{
        $this->data['units'] = $this->db->select('pr_units.*')->get('pr_units')->result();

		$this->data['title'] = 'Personal Information';
		$this->data['username'] = $this->data['user_data']->id_number;

		$this->data['subview'] = 'empInfo/personal_info_short';
		$this->load->view('layout/template', $this->data);
	}
	function get_last_id()
	{
		$unit_id = $this->input->post('unit_id');
		if (empty($unit_id)) {
			echo 'Please select first unit';
		} else {
			$this->db->select('emp_id');
			$this->db->where('unit_id', $unit_id);
			$this->db->order_by('emp_id', 'desc');
			$this->db->limit(1);
			$query = $this->db->get('pr_emp_com_info');
			echo $query->row()->emp_id;
		}
	}



	function personal_info_add() {
		// dd("BSA");
		$this->load->library('form_validation');
		$this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
		if($this->input->post('pi_save')) {
			$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required|is_unique[pr_emp_com_info.emp_id]');
		}
		$this->form_validation->set_rules('proxi_id', 'Punch ID', 'trim');  //|is_unique[pr_emp_com_info.proxi_id]
		$this->form_validation->set_rules('name_en', 'Employee Name', 'trim|required');
		$this->form_validation->set_rules('name_bn', 'Employee Bangla Name', 'trim|required');
		$this->form_validation->set_rules('mother_name', 'Employee Mother\'s Name', 'trim|required');
		$this->form_validation->set_rules('father_name', 'Employee Father\'s Name', 'trim|required');
		$this->form_validation->set_rules('emp_dob', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('gender', 'Employee Gender', 'trim|required');
		$this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
		$this->form_validation->set_rules('religion', 'Employee Religion', 'trim|required');
		$this->form_validation->set_rules('blood', 'Employee Blood Group', 'trim|required');
		$this->form_validation->set_rules('nid_dob_id', 'NID or DOB Card', 'trim|required');
		$this->form_validation->set_rules('nid_dob_check', 'NID or DOB Status', 'trim|required');
		$this->form_validation->set_rules('personal_mobile', 'Personal Mobile', 'trim|required');
		$this->form_validation->set_rules('bank_bkash_no', 'Bank Account', 'trim|required');

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$this->form_validation->run()) {
			$this->load->view('empInfo/personal_info');
		}


		$this->form_validation->set_error_delimiters("","");
		if ($this->form_validation->run() == TRUE) {
			if($this->input->post('submit_type') == 'save') {
				$this->Processdb->insert_emp_info();
			} elseif($this->input->post('submit_type') == 'edit'){
				if($this->Processdb->updatedb1()) {
					echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Updated successfully'); window.location='personal_info';</SCRIPT>";
				}
			} else {
				echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Error Occurred'); window.location='personal_info';</SCRIPT>";
			}
		} else {
			// dd($this->form_validation->error_array());

			redirect(base_url('emp_info_con/personal_info'));
		}
	}


	function personal_info_add_short() {

		// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 	$this->load->view('empInfo/personal_info');
		// }
		if(isset($_POST['save'])) {
			$this->Processdb->insert_emp_info_short();
		} elseif(isset($_POST['edit'])){
			if($this->Processdb->updatedb_short()) {
				echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Updated successfully'); window.location='personal_info_short';</SCRIPT>";
			}
		} else {
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Error Occurred'); window.location='personal_info_short';</SCRIPT>";
		}
	}

	function get_salary_by_grade_id() {
		$this->db->select('salary');
	 echo	$this->db->where('gr_id', $_POST['grade_id'])->get('pr_grade')->row()->salary;
	}

	function get_employees_info(){

		$emp_id = $_POST['id'];
		$data = $this->Processdb->get_emp_info($emp_id);
		// dd($data);
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
	}





















	// old code
	function per_info1()
	{
		$data = $this->Processdb->insertdb1();
	}

	function check_id()
	{
		$result = $this->Processdb->check_id_db();
		echo $result;
	}

	function personal_info_view1_old()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('empid', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('name', 'Employee Name', 'trim');
		$this->form_validation->set_rules('bname', 'Employee Bangla Name', 'trim');
		$this->form_validation->set_rules('mname', 'Employee Mother\'s Name', 'trim');
		$this->form_validation->set_rules('fname', 'Employee Father\'s Name', 'trim');
		$this->form_validation->set_rules('padd', 'Present Address', 'trim');
		$this->form_validation->set_rules('fadd', 'Parmanent Address', 'trim');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|callback_date_check_for_save');
		$this->form_validation->set_rules('ejd', 'Date of Joining', 'trim|required|callback_date_check_for_save');
		$this->form_validation->set_rules('text2', 'Last Degree', 'trim');
		$this->form_validation->set_rules('text3', 'Passing Year', 'trim');
		$this->form_validation->set_rules('text4', 'Institute Name', 'trim');
		$this->form_validation->set_rules('text5', 'Skill Department', 'trim');
		$this->form_validation->set_rules('text6', 'Year(s) of Skill', 'trim');
		$this->form_validation->set_rules('text7', 'Company Name', 'trim');
		$this->form_validation->set_rules('text8', 'Gross Salary', 'trim|required');
		// $this->form_validation->set_rules('text9', 'Complience Gross Salary', 'trim|required');
		$this->form_validation->set_rules('id_skill','ID', 'trim');

		if($this->input->post('pi_save') != '')
		{
			$this->form_validation->set_rules('idcard', 'Punch Card No.', 'trim|callback_proxi_id_check_for_save');
			// $this->form_validation->set_rules('empid', 'Employee ID', 'trim|required|numeric|exact_length[6]|callback_emp_id_existance_check');
			$this->form_validation->set_rules('units', 'Unit', 'trim|required|callback_unit_check');


		}
		elseif($this->input->post('pi_edit') != '')
		{
			$this->form_validation->set_rules('idcard', 'Punch Card No.', 'trim|callback_proxi_id_check_for_edit');
		}
		else
		{
			$this->form_validation->set_rules('idcard', 'Punch Card No.', 'trim');
		}

		$this->form_validation->set_error_delimiters("","");

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('form/all_info');
		}
		else
		{
			if($this->input->post('pi_save') != '')
			{
				$result = $this->per_info1();

			}
			elseif($this->input->post('pi_edit') != '')
			{
				$result = $this->per_update1();
				//print_r($result["values"]);
				//echo $result['msg'];
				if($result['msg'] == "true")
				{
                    echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Updated successfully');</SCRIPT>";
					$this->all_info_view($result);
				}
				else if($result['msg'] == "Please Select Unit!")
				{
					echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Please Select Unit!');</SCRIPT>";
					$this->all_info_view($result);
				}
				else
				{
					echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Error Occurred'); window.location='personal_info_view1';</SCRIPT>";
					//$this->personal_info_view1();
				}
			}
			elseif($this->input->post('pi_delete') != '')
			{
				$result = $this->Processdb->deletedb();
				//print_r($result);exit;
				if($result == "Delete all data successfully")
				{
                    echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Delete all data successfully');</SCRIPT>";
					$this->all_info_view($result);
				}
				else
				{
					echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Delete failed'); window.location='personal_info_view1';</SCRIPT>";
				}
			}
		}
	}



	function all_info_view($result)
	{
		$this->load->view('form/all_info',$result);
	}

	function emp_id_existance_check($emp_id)
	{
		$check = $this->Processdb->emp_id_existance_check($emp_id);
		if ($check == false)
		{
			$this->form_validation->set_message('emp_id_existance_check', 'Sorry! Change your employee ID.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function unit_check ($unit_id)
	{
		if ($unit_id == "Select")
		{
			$this->form_validation->set_message('unit_check', 'Sorry! Select Unit.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}

	function proxi_id_check_for_save($proxi_id)
	{
		$emp_id = $this->input->post('empid');
		$check = $this->Processdb->proxi_id_check_for_save($emp_id, $proxi_id);
		if ($check == false)
		{
			$this->form_validation->set_message('proxi_id_check_for_save', 'Sorry! Punch Card No. already Exist.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function date_check_for_save($date)
	{

		if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$date))
		{
			$check = "True";
		}else{
			$check = "false";
		}

		if ($check == "false")
		{
			$this->form_validation->set_message('date_check_for_save', 'Sorry! Date of Birth or Join Date Format is invalid.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}

	function proxi_id_check_for_edit($proxi_id)
	{
		$emp_id = $this->input->post('empid');
		$check = $this->Processdb->proxi_id_check_for_edit($emp_id, $proxi_id);
		if ($check == false)
		{
			$this->form_validation->set_message('proxi_id_check_for_edit', 'Sorry! Punch Card No. already Exist.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function all()
	{

		if($this->session->userdata('logged_in')==FALSE)
		{
			$this->load->view('login_message');
		}
		else
		{
			if($this->input->post('pi_save') != '')
			{
				$this->per_info();
			}
			elseif($this->input->post('pi_edit') != '')
			{
				$this->per_update();
			}
			$this->load->view('form/all_info');
		}

	}

	function com_info_search1(){
		$emp_id = $this->input->post('empid');
		// echo $emp_id; die;
		// $emp_id = '11000440';
		$result = $this->Processdb->com_info_search1($emp_id);
		// echo "<pre>"; print_r($result); die;
		echo $result;
	}


	function com_info_next_Search1()
	{
		$id_skill = $this->input->post('id_skill');
		$next_id_skill = $this->next_id_skill($id_skill);
		$emp_id = $this->db->where("id",$next_id_skill)->get('pr_emp_skill')->row()->emp_id;
		$result = $this->Processdb->com_info_search1($emp_id);
		echo $result;
	}

	function com_info_prev_Search1()
	{
		$id_skill = $this->input->post('id_skill');
		$prev_id_skill = $this->prev_id_skill($id_skill);
		$emp_id = $this->db->where("id",$prev_id_skill)->get('pr_emp_skill')->row()->emp_id;
		$result = $this->Processdb->com_info_search1($emp_id);
		echo $result;
	}

	function next_id_skill($id_skill)
	{
		$get_session_user_unit = $this->Common_model->get_session_unit_id_name();
		$this->db->select('id');
		$this->db->from('pr_emp_skill');
		if($get_session_user_unit != 0)
		{
			$this->db->from('pr_emp_com_info');
			$this->db->where('pr_emp_com_info.unit_id',$get_session_user_unit);
			$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');

		}
		$this->db->where('id >', $id_skill);
		$this->db->order_by("id","asc");
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows()>0){
		  $rows = $query->row();
		  $next_id_skill = $rows->id;
		}else{
		  $this->db->select_min('id');
		  $this->db->from('pr_emp_skill');
		  if($get_session_user_unit != 0){
			 $this->db->from('pr_emp_com_info');
			$this->db->where('pr_emp_com_info.unit_id',$get_session_user_unit);
			$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');
		  }

		  $query1 = $this->db->get();
		  $rows = $query1->row();
		  $next_id_skill = $rows->id;
		}
		//echo $next_id_skill ;
		return $next_id_skill;
	}

	function prev_id_skill($id_skill)
	{
		$get_session_user_unit = $this->Common_model->get_session_unit_id_name();
		$this->db->select('id');
		$this->db->from('pr_emp_skill');
		if($get_session_user_unit != 0)
		{
			$this->db->from('pr_emp_com_info');
			$this->db->where('pr_emp_com_info.unit_id',$get_session_user_unit);
			$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');

		}
		$this->db->where('id <', $id_skill);
		$this->db->order_by("id","desc");
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
		  $rows = $query->row();
		  $next_id_skill = $rows->id;
		}
		else
		{
		  $this->db->select_max('id');
		  $this->db->from('pr_emp_skill');
		if($get_session_user_unit != 0)
		{
			$this->db->from('pr_emp_com_info');
			$this->db->where('pr_emp_com_info.unit_id',$get_session_user_unit);
			$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill.emp_id');

		}
		  $query1 = $this->db->get();
		  $rows = $query1->row();
		  $next_id_skill = $rows->id;
		}
		return $next_id_skill;
	}

	function per_update1()
	{
		$result = $this->Processdb->updatedb1();
		return $result;
	}

	function dept()
	{
		$result = $this->Processdb->com_all_info();
		echo $result;
	}

	function checkAndBlockSubmit(){
		$id=$this->input->post('id');
		$this->db->where('emp_id',$id);
		$query = $this->db->get('pr_emp_com_info');
		if($query->num_rows()>0){
			echo 1;
		}else{
			echo 'true';
		}
	}


}


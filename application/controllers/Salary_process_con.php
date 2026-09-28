<?php
class Salary_process_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
		$this->load->model('Salary_process_model');
		$this->load->model('Festival_bonus_model');
		$this->load->model('Log_model');
		$this->load->model('Acl_model');
		$this->load->model('Common_model');

		set_time_limit(0);
		ini_set("memory_limit","512M");

        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
        if (!check_acl_list($this->data['user_data']->id, 7)) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
            redirect("payroll_con");
            exit;
        }

	}

	function salary_process_form(){
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();

        if (!empty($this->data['user_data']->unit_name)) {
	        $this->data['employees'] = $this->Common_model->get_emp_by_unit($this->data['user_data']->unit_name);
        }


        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['title'] = 'Salary Process';
        $this->data['subview'] = 'salary/salary_process_form';
        $this->load->view('layout/template', $this->data);

	}

	//////////////  salary process ///////////////
	function salary_process()
	{
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
		$unit_id 	   = $this->input->post('unit_id');
		$process_month = $this->input->post('process_month');
		$emp_id 	   = $this->input->post('sql');
		$grid_emp_id   = explode(',', $emp_id);

		if(empty($unit_id)){return "Please Login As an Unit User.";}

		$result = $this->Salary_process_model->salary_process($unit_id,$process_month,$grid_emp_id);
		if($result == "Process completed successfully")
		{
			// SALARY PROCESS LOG Generate
			$this->Log_model->log_salary_process($process_month);
			echo $result;
		}
		else
		{
			echo $result;
		}

	}

	////////////// salary process block ///////////////
	function salary_process_block()
	{
		$unit_id 	    = $this->input->post('unit_id');
		$salary_month   = $this->input->post('salary_month');

		$d['block_month'] 	= "$salary_month-01";
		$d['unit_id'] 		= $unit_id;
		$d['status'] 		= 'Block';
		$d['username'] 		= $this->data['user_data']->id_number;
		$d['date_time'] 	= date("Y-m-d H:i:s");

		$check = $this->db->where('unit_id', $unit_id)->where('block_month',$d['block_month'])->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! block already exixt";
		} else if ($check->num_rows() == 0) {
			$this->db->insert('pay_salary_block', $d);
			$this->Log_model->log_salary_process($d['block_month']);
			echo "Process completed successfully";
		}
		else
		{
			echo "Sorry! something wrong";
		}

	}

	////////////// salary process block ///////////////
	function salary_block_delete()
	{
		$unit_id 	    = $this->input->post('unit_id');
		$salary_month   = $this->input->post('salary_month');

		$this->db->where('unit_id', $unit_id)->where('block_month',"$salary_month-01");
		if($this->db->delete('pay_salary_block'))
		{
			echo "Successfully Deleted Done";
		}
		else
		{
			echo "Sorry! something wrong";
		}

	}

	////////////// salary report ///////////////
	function grid_salary_report()
	{
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

        $this->data['employees'] = array();
        if ($this->data['user_data']->level == 'Unit') {
        	$this->db->select('max(ss.emp_id) as emp_id, MAX(per.name_en) as name_en');
        	$this->db->from('pay_salary_sheet as ss');
        	$this->db->join('pr_emp_per_info as per', 'ss.emp_id = per.emp_id', 'left');
        	$this->db->where('ss.unit_id', $this->data['user_data']->unit_name);
        	$this->db->where('ss.stop_salary', 1);
        	$this->db->where('ss.salary_month', date('2023-07-01'));
        	$this->db->group_by('ss.emp_id')->order_by('ss.emp_id', 'ASC');
        	$this->data['employees'] = $this->db->get()->result();
        }

        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();

        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['title'] = 'Salary Report';
        $this->data['subview'] = 'salary_report/grid_salary_report';
        $this->load->view('layout/template', $this->data);
	}

	function adv_salary_report()
	{
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

        $this->data['employees'] = array();
        if ($this->data['user_data']->level == 'Unit') {
			$this->db->select('ss.emp_id, MAX(per.name_en) as name_en');
			$this->db->from('pay_salary_sheet as ss');
			$this->db->join('pr_emp_per_info as per', 'ss.emp_id = per.emp_id', 'left');
			$this->db->where('ss.unit_id', $this->data['user_data']->unit_name);
			$this->db->where('ss.stop_salary', 1);
			$this->db->where('ss.salary_month', date('Y-m-01'));
			$this->db->group_by('ss.emp_id');
			$this->db->order_by('ss.emp_id', 'ASC');
			$this->data['employees'] = $this->db->get()->result();
        }

        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();

        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['title'] = 'Salary Report';
        $this->data['subview'] = 'salary_report/adv_salary_report';
        $this->load->view('layout/template', $this->data);
	}










	// =============================================================
	// ////////////////======= old ===========//////////////
	// old code
	function salary_process_formssssss()
	{

		if($this->session->userdata('logged_in')==FALSE)
		$this->load->view('login_message');
		else
		//$this->load->view('form/salary_process');
		$crud = new grocery_CRUD();
		$get_session_user_unit = $this->Common_model->get_session_unit_id_name();
		if($get_session_user_unit != 0)
		{
			$crud->where('pr_salary_block.unit_id',$get_session_user_unit);
		}
		$crud->set_table('pr_salary_block');
		$crud->set_subject('Salary Block');
		$crud->display_as('block_month','Final Month');
		$crud->order_by('block_month','desc');
		if($get_session_user_unit != 0)
		{
			$crud->set_relation( 'unit_id' , 'pr_units','unit_name',array('unit_id' => $get_session_user_unit) );
		}
		else
		{
			$crud->set_relation( 'unit_id' , 'pr_units','unit_name' );
		}
		//$crud->required_fields( 'block_month','status');
		//$crud->callback_before_insert(array($this,'user_actual_date_callback'));
		//$crud->callback_before_update(array($this,'user_actual_date_callback'));
		//$crud->set_rules('block_month','Block Month','required|callback_block_month_check');
		//$crud->set_rules('block_month','Block Month','required|callback_block_month_check');
		//$crud->change_field_type('username','hidden');
		//$crud->change_field_type('date_time','hidden');
		// $crud->unset_columns('status');
		// $crud->unset_delete();
		// $crud->unset_add();
		// $crud->unset_edit();
		// $output = $crud->render();
		$this->load->view('form/salary_process',);

	}

	////////////////////////Festival Bonus///////////
	// function festival_bonus_form()
	// {

	// 	if($this->session->userdata('logged_in')==FALSE){
	// 		$this->load->view('login_message');
	// 	}
	// 	else{
	// 		$this->data['username'] = $this->data['user_data']->id_number;
	// 		$this->data['title'] = 'Salary Process';
	// 		$this->data['subview'] = 'form/festival_process';
	// 		$this->load->view('layout/template', $this->data);
	// 	}


	// }

	//////////////Festival Process////////////
	function festival_process()
	{
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$process_check = $this->input->post('process_check');

		////////Month Check ///////////
		$this->db->select('');
		$this->db->like('effective_date', $month);
		$query = $this->db->get('pr_bonus_rules');
		//echo $this->db->last_query();
		if($query->num_rows()==0)
		{
			echo "Sorry! This Month is not setup in Festival.";
		}
		else{

			$result = $this->Festival_bonus_model->festival_bonus_process($year, $month, $process_check);
			if($result == "Process completed successfully")
			{
				// SALARY PROCESS LOG Generate
				$this->Log_model->log_salary_process($year, $month);
				echo $result;
			}
			else
			{
				echo $result;
			}

		}

	}

	function test()
	{
		/*$service_month = 1;
		$gross_sal = 10000;
		$basic_sal = 7000;
		for($i=0; $i<=25; $i++){
		 $result = $this->Salary_process_model->get_festival_bonus_rule($i);
		 echo "$i -> ";
		 print_r($result);
		 echo "== BONUS : ".$bonus = $this->Salary_process_model->get_festival_bonus($result,$gross_sal,$basic_sal);
		 echo '<br>';
		 }*/
		 $doj = '2012-10-08';
		 $dates = $this->Salary_process_model->get_join_month_dates($doj);
		 print_r($dates);
	}

}


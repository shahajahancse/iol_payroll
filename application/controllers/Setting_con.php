<?php
class Setting_con extends CI_Controller {

	function __construct(){
		parent::__construct();

		/* Standard Libraries */
		$this->data['user_data'] = $this->session->userdata('data');
		// $this->load->library('Grocery_crud');
		$this->load->model('Acl_model');
		$this->load->model('Common_model');

        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        // /*if (!check_acl_list($this->data['user_data']->id, 17)) {
        //     echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
        //     redirect("payroll_con");
        //     exit;
        // }*/

	}

	function crud(){
		if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
		$this->db->order_by('id', 'desc');
		$this->data['data'] = $this->db->get('member_acl_list')->result();
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['title'] = 'User Mode';
        $this->data['subview'] = 'settings/acl_access';
        $this->load->view('layout/template', $this->data);
	}

	function activity_log(){

		$this->db->select('active_log.*, members.id_number');
		$this->db->join('members', 'members.id = active_log.member_id', 'left');
		$this->db->where('members.unit_name', $_SESSION['data']->unit_name);
		$this->db->order_by('id', 'desc');
		$this->data['data'] = $this->db->get('active_log')->result();
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['title'] = 'Activity Log';
        $this->data['subview'] = 'settings/activity_log';
        $this->load->view('layout/template', $this->data);

	}

	function acl_access_add(){
		if ($this->db->insert('member_acl_list', array('acl_name' => $this->input->post('acl_name'), 'type' => $this->input->post('type')))) {
			$this->session->set_flashdata('success', 'ACL Added Successfully');
		}else{
			$this->session->set_flashdata('failuer', 'ACL Added Failed');
		}
		redirect('setting_con/crud');
	}

	function acl_access_edit($id){

		if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

		if (!empty($_POST['acl_name'])) {
			$data =	array(
				'acl_name' => $_POST['acl_name'],
				'type' 	   => $_POST['type']
			);
			$this->db->where('id', $id);
			$this->db->update('member_acl_list', $data);
			$this->session->set_flashdata('success', 'ACL Updated Successfully');
			redirect('setting_con/crud');
		}
		$this->db->select('pr_units.*');
        $this->data['units'] = $this->db->get('pr_units')->result_array();

		$this->data['row']      = $this->db->where('id', $id)->get('member_acl_list')->row();
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['title']    = 'Access List Edit';
        $this->data['subview']  = 'settings/acl_access_edit';
        $this->load->view('layout/template', $this->data);
	}

	function acl_access_delete($id){
		if ($this->db->delete('member_acl_list', array('id' => $id))) {
			$this->session->set_flashdata('success', 'ACL Deleted Successfully');
		}else{
			$this->session->set_flashdata('failuer', 'ACL Deleted Failed');
		}
		redirect('setting_con/crud');
	}

	public function left_menu_acl()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
		$id = $this->data['username'] = $this->data['user_data']->id;
		$this->db->order_by('id', 'desc');
		$this->db->where_in('type', [1,2,5]);
		$this->data['access_list'] = $this->db->get('member_acl_list')->result();

		$this->db->where('username_id', $id);
		$level_list = $this->db->get('member_acl_level')->result();
		$level_array = [];
		foreach ($level_list as $key => $value) {
			$level_array[] = $value->acl_id;
		}
		$this->data['level_array'] = $level_array;
		$this->data['user_id'] = $id;

		$this->data['users'] = $this->get_member();
		// dd($this->data);
        $this->data['title'] = 'User Access HRM';
        $this->data['username'] = $this->data['user_data']->id_number;
		$this->data['subview'] = 'settings/left_menu_acl';
        $this->load->view('layout/template', $this->data);
    }

	public function user_acl_hrm()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

		$this->data['users'] = $this->get_member();
        $this->data['title'] = 'User Access HRM';
        $this->data['username'] = $this->data['user_data']->id_number;
		$this->data['subview'] = 'settings/user_acl_hrm';
        $this->load->view('layout/template', $this->data);
    }
	public function hide_designation_employee()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->db->select('emp_depertment.*, pr_units.unit_name');
        $this->db->from('emp_depertment');
        $this->db->join('pr_units', 'pr_units.unit_id = emp_depertment.unit_id', 'left');
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('emp_depertment.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['departments'] = $this->db->get()->result();


		$this->data['users'] = $this->get_member();
        $this->data['title'] = 'Hide Designation Employee';
        $this->data['username'] = $this->data['user_data']->id_number;
		$this->data['subview'] = 'settings/hide_designation_employee';
        $this->load->view('layout/template', $this->data);
    }
	public function get_emp_by_unit($unit) {
        $this->db->select('
                    pr_emp_com_info.id,
                    pr_emp_com_info.emp_id,
                    pr_emp_com_info.unit_id,
                    pr_emp_per_info.name_en,
                    pr_emp_per_info.name_bn,
                ');
        $this->db->from('pr_emp_com_info');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_emp_com_info.unit_id', 'left');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
        $this->db->where('pr_units.unit_id', $unit);
        $this->db->where('pr_emp_com_info.emp_cat_id', 1);
        return $this->db->get();
    }
	public function hide_designation($id, $value){
		$this->db->where('id', $id);
		if($this->db->update('emp_designation', array('hide_status' => $value))){
			echo 'success';
		}else{
			echo 'failed';
		}
	}

	public function user_acl_pr()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

		$this->data['users'] = $this->get_member();
		// dd($this->data['users']);
        $this->data['title'] = 'User Access HRM';
        $this->data['username'] = $this->data['user_data']->id_number;
		$this->data['subview'] = 'settings/user_acl_pr';
        $this->load->view('layout/template', $this->data);
    }

    function get_member()
    {
    	$this->db->select('members.id, members.id_number,members.unit_name as unit_id, pr_units.unit_name');
    	$this->db->join('pr_units', 'members.unit_name = pr_units.unit_id', 'left');
    	// $this->db->where('members.unit_name !=', '0');
    	$this->db->order_by('members.id', 'desc');
		return $this->db->get('members')->result();
    }

	public function checkbox_get_user_acl_hrm(){
		$id = $this->input->post('id');
		$type = $this->input->post('type');

		$this->db->order_by('id', 'desc');
		if ($type == 1) {
			$this->db->where_in('type', [1,2,5]);
		} else {
			$this->db->where('type', $type);
		}
		$this->data['access_list'] = $this->db->get('member_acl_list')->result();

		$this->db->where('username_id', $id);
		$level_list = $this->db->get('member_acl_level')->result();
		$level_array = [];
		foreach ($level_list as $key => $value) {
			$level_array[] = $value->acl_id;
		}
		$this->data['level_array'] = $level_array;
		$this->data['user_id'] = $id;
		echo $this->load->view('settings/chackbox_user_acl_hrm', $this->data, true);
	}

	public function check_level(){
		$id = $this->input->post('id');
		$user_id = $this->input->post('user_id');
		$this->db->where('username_id', $user_id);
		$this->db->where('acl_id', $id);
		$check = $this->db->get('member_acl_level')->num_rows();
		if ($check > 0) {
			$this->db->delete('member_acl_level', array('username_id' => $user_id, 'acl_id' => $id));
		}else{
			$this->db->insert('member_acl_level', array('username_id' => $user_id, 'acl_id' => $id));
		}
	}

	public function report_setting(){
		if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
		$this->db->select('pr_units.*');
        $this->data['units'] = $this->db->get('pr_units')->result_array();

		$this->db->select('pr_report_setting.*, pr_units.unit_name');
		$this->db->join('pr_units', 'pr_report_setting.unit_id = pr_units.unit_id', 'left');
		$this->db->where('pr_units.unit_id', $_SESSION['data']->unit_name);
		$this->db->order_by('id', 'desc');
		$this->data['data'] = $this->db->get('pr_report_setting')->result_array();
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['title'] = 'Report setting';
        $this->data['subview'] = 'settings/report_setting';
        $this->load->view('layout/template', $this->data);
	}

	public function report_setting_save($id){
		// dd($id);
		$unit_id = $this->input->post('unit_id');
		$date = date('Y-m-d', strtotime($this->input->post('date')));
		$end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
		$max_ot = $this->input->post('max_ot');
		$type = $this->input->post('type');
		$active_status = $this->input->post('active_status');

		$data = array(
			'unit_id' => $unit_id,
			'date' => $date,
			'end_date' => $end_date,
			'max_ot' => $max_ot,
			'type' => $type,
			'status' => $active_status,
			'created_by' =>  $this->data['user_data']->id,
		);
		if ($id == 0) {
			$this->db->insert('pr_report_setting', $data);
		}else{
			$row = $this->db->where('id', $id)->get('pr_report_setting')->row();
			if ($row->type == 1) {
				$this->db->where('unit_id', $row->unit_id)->where('present_status', 'P')->where('eot !=', 0);
				$this->db->where('shift_log_date between "'.$row->date.'" and "'.$row->end_date.'"');
				$this->db->update('pr_emp_shift_log', array('false_ot_4' => null));
			} else if ($row->type == 2) {
				$this->db->where('unit_id', $row->unit_id)->where('present_status', 'P')->where('eot !=', 0);
				$this->db->where('shift_log_date between "'.$row->date.'" and "'.$row->end_date.'"');
				$this->db->update('pr_emp_shift_log', array('false_ot_12' => null));
			} else {
				$this->db->where('unit_id', $row->unit_id)->where('present_status', 'P')->where('eot !=', 0);
				$this->db->where('shift_log_date between "'.$row->date.'" and "'.$row->end_date.'"');
				$this->db->update('pr_emp_shift_log', array('false_ot_all' => null));
			}

			$this->db->where('id', $id);
			$this->db->update('pr_report_setting', $data);
		}
		if ($type == 1) {
			$this->db->where('unit_id', $unit_id)->where('present_status', 'P')->where('eot !=', 0);
			$this->db->where('shift_log_date between "'.$date.'" and "'.$end_date.'"');
			$this->db->update('pr_emp_shift_log', array('false_ot_4' => $max_ot));
		} else if ($type == 2) {
			$this->db->where('unit_id', $unit_id)->where('present_status', 'P')->where('eot !=', 0);
			$this->db->where('shift_log_date between "'.$date.'" and "'.$end_date.'"');
			$this->db->update('pr_emp_shift_log', array('false_ot_12' => $max_ot));
		} else {
			$this->db->where('unit_id', $unit_id)->where('present_status', 'P')->where('eot !=', 0);
			$this->db->where('shift_log_date between "'.$date.'" and "'.$end_date.'"');
			$this->db->update('pr_emp_shift_log', array('false_ot_all' => $max_ot));
		}
		echo 'true';
	}
	public function get_report_setting(){
		$id = $this->input->post('id');
		$this->db->where('id', $id);
		$data=$this->db->get('pr_report_setting')->row();
		$data->date=date('Y-m-d',strtotime($data->date));

		echo json_encode($data);
	}
	public function delete_report_setting(){
		$id = $this->input->post('id');
		$data = $this->db->where('id', $id)->get('pr_report_setting')->row();

		if ($data->type == 1) {
			$this->db->where('unit_id', $data->unit_id)->where('present_status', 'P')->where('eot !=', 0);
			$this->db->where('shift_log_date between "'.$data->date.'" and "'.$data->end_date.'"');
			$this->db->update('pr_emp_shift_log', array('false_ot_4' => null));
		} else if ($data->type == 2) {
			$this->db->where('unit_id', $data->unit_id)->where('present_status', 'P')->where('eot !=', 0);
			$this->db->where('shift_log_date between "'.$data->date.'" and "'.$data->end_date.'"');
			$this->db->update('pr_emp_shift_log', array('false_ot_12' => null));
		} else {
			$this->db->where('unit_id', $data->unit_id)->where('present_status', 'P')->where('eot !=', 0);
			$this->db->where('shift_log_date between "'.$data->date.'" and "'.$data->end_date.'"');
			$this->db->update('pr_emp_shift_log', array('false_ot_all' => null));
		}
		$this->db->where('id', $id);
		$this->db->delete('pr_report_setting');
		echo 'true';
	}

	public function dasig_group($id = null, $unit_id = null)
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

        $this->data['units'] = $this->db->get('pr_units')->result();
		if (!empty($id) && !empty($unit_id)) {
			$dd = $this->get_manage_gd_id($id, $unit_id);
			$this->data['match']     = $dd['match'];
			$this->data['not_match'] = $dd['not_match'];
			$this->data['row'] = $this->db->where('id', $id)->get('emp_group_dasignation')->row();
			$this->data['results'] = $this->get_dasignations($unit_id);

			$this->data['title'] = 'Manage Dasignation';
			$this->data['subview'] = 'settings/manage_gd';
		} else if(!empty($id)) {
			$this->data['row'] = $this->db->where('id', $id)->get('emp_group_dasignation')->row();
	        $this->data['title'] = 'Edit Dasignation Group';
			$this->data['subview'] = 'settings/dasig_group_edit';
		} else {
			// dd($unit_id);
	        $this->db->select('g.*, u.unit_name')->from('emp_group_dasignation as g')->where('g.unit_id',$_SESSION['data']->unit_name)->order_by('u.unit_id', 'ASC');
	        $this->data['groups'] = $this->db->join('pr_units as u', 'g.unit_id = u.unit_id')->get()->result();

			$this->data['subview'] = 'settings/dasig_group';
	        $this->data['title'] = 'Dasignation Group';
		}

        $this->data['username'] = $this->data['user_data']->id_number;
        $this->load->view('layout/template', $this->data);
    }

	function dasig_group_add($id = null){
		$data = array(
			'name_en' 	  => $this->input->post('name_en'),
			'name_bn' 	  => $this->input->post('name_bn'),
			'unit_id' 	  => $this->input->post('unit_id'),
			'status'  	  => $this->input->post('status'),
			'serial'  	  => $this->input->post('serial'),
			'updated_by'  => $this->data['user_data']->id,
		);

		if (!empty($id)) {
			$this->db->where('id', $id)->update('emp_group_dasignation',$data);
			$this->session->set_flashdata('success', 'Updated Successfully');
		} else if ($this->db->insert('emp_group_dasignation', $data)) {
			$this->session->set_flashdata('success', 'Added Successfully');
		}else{
			$this->session->set_flashdata('failuer', 'Added Failed');
		}
		redirect('setting_con/dasig_group');
	}

	function get_manage_gd_id($id, $unit_id){
		$this->db->select('id')->where('group_id', $id);
		$rows = $this->db->get('emp_designation')->result();
		$data1 = array();
		foreach ($rows as $key => $r) {
			$data1[$key] = $r->id;
		}

		$this->db->select('id')->where('unit_id', $unit_id);
		if (!empty($data1)) {
			$this->db->where_not_in('id', $data1);
		}
		$rows = $this->db->get('emp_designation')->result();
		$data2 = array();
		foreach ($rows as $key => $r) {
			$data2[$key] = $r->id;
		}
		$data = array(
			'match'     => $data1,
			'not_match' => $data2,
		);
		return $data;
	}

	function get_dasignations($unit_id){
		$this->db->select("dg.id, dg.desig_name, dg.unit_id, dg.group_id,  gd.name_en");
		$this->db->from("emp_designation as dg");
		$this->db->join("emp_group_dasignation gd", 'gd.id = dg.group_id', 'left');
		$this->db->where("dg.unit_id", $unit_id);
		$this->db->group_by("dg.id");
		return $this->db->get()->result();
	}

	public function check_level_dg(){
		$id 	 = $this->input->post('id');
		$gd_id   = $this->input->post('gd_id');
		$unit_id = $this->input->post('unit_id');
		$is_check = $this->input->post('is_check');
		if ($is_check == 1) {
			$d['group_id'] = $gd_id;
		} else {
			$d['group_id'] = 0;
		}
		$this->db->where('id', $id)->where('unit_id', $unit_id);
		$this->db->update('emp_designation', $d);
	}

	function acl($start=0){
		$this->data['username'] = $this->data['user_data']->id_number;
		$this->db->select('SQL_CALC_FOUND_ROWS members.*, pr_units.unit_name', false);
		$this->db->join('pr_units', 'pr_units.unit_id = members.unit_name', 'left');
		$this->db->where('members.unit_name', $_SESSION['data']->unit_name);
		$this->data['members'] = $this->db->get('members')->result_array();
		$this->data['subview'] = 'settings/acl';
        $this->load->view('layout/template', $this->data);
	}

	function member_add(){
		$this->data['title'] = 'Add Member';
		$this->data['username'] = $this->data['user_data']->id_number;
		$this->data['user_level'] = null;

		if ($this->data['user_data']->level == 'Unit') {
			$this->data['user_level'] = 'Unit';
			$this->db->where('id', $this->data['user_data']->unit_name);
		}
		$this->data['pr_units'] = $this->db->get('pr_units')->result();
		$this->data['subview'] = 'settings/member_add';
        $this->load->view('layout/template', $this->data);
	}

	public function member_insert()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
			'id_number',
			'User ID',
			'trim|required|is_unique[members.id_number]',
			array(
				'required'  => 'User ID is required!',
				'is_unique' => 'This User ID already exists!'
			)
		);

		$this->form_validation->set_rules(
			'password',
			'Password',
			'trim|required|min_length[6]',
			array(
				'required'   => 'Password is required!',
				'min_length' => 'Password must be at least 6 characters!'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			// Reload same form with validation errors
			return $this->member_add();
		} else {
			$insert_data = array(
				'id_number' => $this->input->post('id_number', TRUE),
				'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'level'     => $this->input->post('level', TRUE),
				'unit_name' => $this->input->post('unit_name', TRUE),
				'user_mode' => $this->input->post('user_mode') ? $this->input->post('user_mode') : 0,
				'status'    => $this->input->post('status', TRUE)
			);
			$this->db->insert('members', $insert_data);
			$this->session->set_flashdata('success', 'Record Inserted Successfully!');
			redirect('setting_con/acl');
		}
	}

	function member_edit($id){
		$this->data['username'] = $this->data['user_data']->id_number;
		$this->data['user_level'] = null;

		if ($this->data['user_data']->level == 'Unit') {
			$this->data['user_level'] = 'Unit';
			$this->db->where('id', $this->data['user_data']->unit_name);
		}
		$this->data['pr_units'] = $this->db->get('pr_units')->result();

		$this->data['row'] = $this->db->where('members.id', $id)->get('members')->row();
		$this->data['subview'] = 'settings/member_edit';
        $this->load->view('layout/template', $this->data);
		// $this->load->view('', $param);
	}

	public function update_member($id = 0)
	{
		$this->load->library('form_validation');

		// Get existing record
		$member = $this->db->where('id', $id)->get('members')->row();

		if (!$member) {
			show_404();
		}

		// Unique check (ignore current ID)
		if ($this->input->post('id_number') != $member->id_number) {
			$is_unique = '|is_unique[members.id_number]';
		} else {
			$is_unique = '';
		}

		$this->form_validation->set_rules(
			'id_number',
			'User ID',
			'trim|required' . $is_unique,
			array(
				'required'  => 'User ID is required!',
				'is_unique' => 'This User ID already exists!'
			)
		);

		// Password optional in edit
		if ($this->input->post('password')) {
			$this->form_validation->set_rules(
				'password',
				'Password',
				'min_length[6]',
				array(
					'min_length' => 'Password must be at least 6 characters!'
				)
			);
		}

		if ($this->form_validation->run() == FALSE) {

			return $this->member_edit($id);

		} else {

			$update_data = array(
				'id_number' => $this->input->post('id_number', TRUE),
				'level'     => $this->input->post('level', TRUE),
				'unit_name' => $this->input->post('unit_name', TRUE),
				'user_mode' => $this->input->post('user_mode') ? $this->input->post('user_mode') : 0,
				'status'    => $this->input->post('status', TRUE)
			);

			// Update password only if entered
			if ($this->input->post('password')) {
				$update_data['password'] = password_hash(
					$this->input->post('password'),
					PASSWORD_DEFAULT
				);
			}

			$this->db->where('id', $id);
			$this->db->update('members', $update_data);

			$this->session->set_flashdata('success', 'Record Updated Successfully!');
			redirect('setting_con/acl');
		}
	}



	function update_membersss($id=0){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_number', 'members Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		$data = array();
		$data['id_number'] = $this->input->post('id_number');
		$data['password'] = $this->input->post('password');
		$data['level'] = $this->input->post('level');
		$data['unit_name'] = $this->input->post('unit_name');
		$data['user_mode'] = $this->input->post('user_mode') ? $this->input->post('user_mode') : 0;
		$data['status'] = $this->input->post('status');
		$this->db->where('members.id',$id);
		$this->db->update('members',$data);

		$this->session->set_flashdata('success','Record Updated successfully!');
		redirect(base_url('setting_con/acl'));
	}

	function members_delete($id=0){
		$this->db->where('members.id',$id);
		$data=$this->db->delete('members');
		$this->session->set_flashdata('success','Record Deleted successfully!');
		redirect(base_url('setting_con/acl'));
	}


    //-------------------------------------------------------------------------------------------------------
    // CRUD for manage line wise designation of attendance summary report start
    //-------------------------------------------------------------------------------------------------------
	public function line_wise_atn_desig()
    {
        $this->db->select('pr_emp_per_info.*,pr_emp_com_info.*,pr_units.unit_name,emp_line_num.line_name_en');
        $this->db->from('pr_emp_com_info');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_emp_com_info.unit_id');
        $this->db->join('emp_line_num', 'emp_line_num.id = pr_emp_com_info.emp_line_id');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
        $this->db->where('pr_emp_com_info.attn_sum_line_id IS NOT NULL');
        $this->db->where('pr_emp_com_info.unit_id', $_SESSION['data']->unit_name);
        $this->data['pr_line'] = $this->db->get()->result_array();
		// dd();
        $this->data['title'] = 'Line Wise Designation List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'settings/line_wise_atn_desig';
        $this->load->view('layout/template', $this->data);
    }

	function line_wise_atn_add_form()
	{
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
		$this->data['user_id'] = $this->data['user_data']->unit_name;
        $this->data['title'] = 'Line wise designation Add';
        $this->data['subview'] = 'settings/line_wise_atn_add_form';
        $this->load->view('layout/template', $this->data);
	}

	function line_add()
	{
		$line_id = $_POST['line_id'];
		$emp_id = $_POST['spl'];

		$this->db->where('emp_id', $emp_id);
		$this->db->update('pr_emp_com_info', array('attn_sum_line_id' => $line_id));
		echo '1';
	}

    function line_delete($id)
    {
        $this->db->where('emp_id', $id);
        $this->db->update('pr_emp_com_info', array('attn_sum_line_id' =>null));
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
		redirect(base_url('setting_con/line_wise_atn_desig'));
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for manage line wise designation of attendance summary report end
    //-------------------------------------------------------------------------------------------------------

}


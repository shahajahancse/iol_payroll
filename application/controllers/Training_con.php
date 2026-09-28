<?php
class Training_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 0);
	    set_time_limit(0);
		/* Standard Libraries */
		// $this->load->library('Grocery_crud');
		$this->load->model('Attn_process_model');
		$this->load->model('Log_model');
		$this->load->model('Acl_model');
		$this->load->model('Common_model');
        $this->load->model('grid_model');


        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
        if (!check_acl_list($this->data['user_data']->id, 4)) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
            redirect("payroll_con");
            exit;
        }
	}



	public function training()
    {
        $this->db->select('training_type.*,pr_units.unit_name');
        $this->db->from('training_type');
        $this->db->join('pr_units', 'pr_units.unit_id = training_type.unit_id');
        $this->data['pr_line'] = $this->db->get()->result_array();
        $this->data['title'] = 'Training List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'training/training_list';
        $this->load->view('layout/template', $this->data);
    }

    public function training_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            //$this->db->select('pr_units.*');
            $this->data['unit'] = $this->pr_units_get();
            $this->data['title'] = 'Add Training';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'training/training_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'title' => $this->input->post('title'),
                'unit_id' => $this->input->post('unit_id'),
                'description' => $this->input->post('description'),
				'status' => 1
            );

            if ($this->db->insert('training_type', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'training_con/training');
        }
    }

    public function training_edit($id)
    {
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');


        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            $this->db->select('pr_units.*');
            $this->data['unit'] = $this->db->get('pr_units')->result();
			$this->db->where('id', $id);
            $this->data['training'] = $this->db->get('training_type')->row();

            $this->data['title'] = 'Edit Training';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'training/training_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
				'title' => $this->input->post('title'),
				'unit_id' => $this->input->post('unit_id'),
				'description' => $this->input->post('description'),
				'status' => 1
            );
            $this->db->where('id', $id);
            if ($this->db->update('training_type', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'training_con/training');

        }

    }

    public function training_delete($line_id)
    {
        $this->db->where('id', $line_id);
        $this->db->delete('training_type');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'training_con/training');
    }

	function employee_training_form()
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
        $this->data['title'] = 'Training Add';
        $this->data['subview'] = 'training/employee_training_add';
        $this->load->view('layout/template', $this->data);

	}
    public function pr_units_get(){
        $user_data=$this->session->userdata('data');
        $this->db->select('pr_units.*');
        if($user_data->level!='All'){
            $this->db->where('unit_id', $user_data->unit_name);
        }
        return $this->db->get('pr_units')->result();
    }
	function training_report()
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
        $this->data['title'] = 'Training Report';
        $this->data['subview'] = 'training/training_report';
        $this->load->view('layout/template', $this->data);

	}
    
    function training_report_list()
    {
        $training_id = $this->input->post('training_id');
        $grid_data = $this->input->post('spl');
        $emp_ids = array_filter(explode(',', trim($grid_data)));
        $type = $this->input->post('type');
        $unit_id = $this->input->post('unit_id');
        $data = [
            "emp_id" => $emp_ids,
            "training_id" => $training_id,
            "type" => $type,
            "unit_id" => $unit_id,
        ];

        if ($type == 0) {
            $data['done'] = $this->get_training_done($emp_ids, $training_id);
        } else {
            $data['not_done'] = $this->get_training_not_done($emp_ids, $training_id);
        }

        $this->load->view('training/done_not_done', $data);
    }

    private function get_training_done($emp_ids, $training_id)
    {
        $this->db->select('training_management.*, pr_units.unit_name, pr_emp_per_info.emp_id as emp_id2, training_type.title as training_name, pr_emp_per_info.name_en as emp_name');
        $this->db->from('training_management');
        $this->db->join('pr_units', 'pr_units.unit_id = training_management.unit_id');
        $this->db->join('training_type', 'training_type.id = training_management.training_id');
        $this->db->join('pr_emp_com_info', 'pr_emp_com_info.id = training_management.emp_id');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
        $this->db->where_in('training_management.emp_id', $emp_ids);
        $this->db->where('training_management.training_id', $training_id);
        return $this->db->get()->result();
    }

    private function get_training_not_done($emp_ids, $training_id)
    {
        $this->db->select('per.emp_id as emp_id, per.name_en, lin.line_name_en, dg.desig_name, com.id as eeeid');
        $this->db->from('pr_emp_com_info as com');
        $this->db->join('training_management as tm', 'com.id = tm.emp_id AND tm.training_id = ' . $training_id, 'left');
        $this->db->join('pr_emp_per_info as per', 'com.emp_id = per.emp_id', 'left');
        $this->db->join('emp_line_num as lin', 'com.emp_line_id = lin.id', 'left');
        $this->db->join('emp_designation as dg', 'com.emp_desi_id = dg.id', 'left');
        $this->db->where_in('com.id', $emp_ids);
        $this->db->where('tm.emp_id IS NULL');
        return $this->db->get()->result();
    }

	function employee_training_add()
	{
		if (!isset($_POST['training_id']) || !isset($_POST['unit_id']) || !isset($_POST['date']) || !isset($_POST['time'])) {
			echo '0';
			exit;
		}

		$training_id = $_POST['training_id'];
		$unit_id = $_POST['unit_id'];
		$date = date('Y-m-d', strtotime($_POST['date']));

		$time = $_POST['time'];
		$status = 1;
		$created_at = date('Y-m-d H:i:s');

		$grid_data = $_POST['spl'];
		$emp_id = explode(',', trim($grid_data));
		$data = [];
		foreach ($emp_id as $key => $value) {

            $this->db->where('emp_id', $value);
            $this->db->where('training_id', $training_id);
            $this->db->where('unit_id', $unit_id);
            $query = $this->db->get('training_management');
            if ($query->num_rows() > 0) {
                continue;
            }

			$data[] = array(
				'emp_id' => $value,
				'training_id' => $training_id,
				'unit_id' => $unit_id,
				'date' => $date,
				'time' => $time,
				'status' => $status,
				'created_at' => $created_at
			);
		}
		if (!empty($data)) {
            $this->db->insert_batch('training_management', $data);
            echo true;
		} else {
            echo false;
        }
	}

	function training_list(){
		$this->db->select('
                training_management.*,
                pr_units.unit_name,
                training_type.title as training_name,
                pr_emp_per_info.name_en as emp_name,
                pr_emp_per_info.emp_id as emp_id2,
            ');
        $this->db->from('training_management');
        $this->db->join('pr_units', 'pr_units.unit_id = training_management.unit_id');
        $this->db->join('training_type', 'training_type.id = training_management.training_id');
        $this->db->join('pr_emp_com_info', 'pr_emp_com_info.id = training_management.emp_id');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
        $this->data['pr_line'] = $this->db->order_by('training_management.date', 'DESC')->get()->result_array();
        $this->data['title'] = 'Employee Training List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'training/employee_training_list';
        $this->load->view('layout/template', $this->data);
	}
    function employee_training_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('training_management');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'training_con/training_list');
    }
}
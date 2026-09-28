<?php
class Autocomplete extends CI_Controller {

	function __construct(){
		parent::__construct();

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
    public function employee_id(){
        $id = $this->input->post('id');
        // dd($id);
        $this->db->select('com.emp_id');
        $this->db->from('pr_emp_com_info as com');
        $this->db->join('emp_designation as deg', 'deg.id = com.emp_desi_id', 'left');
        $this->db->like('com.emp_id', $id);
        $this->db->where('deg.hide_status', 1);
        if ($this->data['user_data']->unit_name != 0 && $this->data['user_data']->unit_name != NULL) {
            $this->db->where('com.unit_id', $this->data['user_data']->unit_name);
        }
        $this->db->limit(70);
        $query = $this->db->get();
        // dd($query->result_array());


        $outputArray = array_map(function ($obj) {
            return $obj["emp_id"];
        }, $query->result_array());
        echo json_encode($outputArray);
    }
    public function english_name(){
        $english_name=$this->input->post('english_name');
        $this->db->select('name_en');
        $this->db->like('name_en', $english_name);
        $this->db->limit(70);
        $query = $this->db->get('pr_emp_per_info');
        $outputArray = array_map(function ($obj) {
            return $obj["name_en"];
        }, $query->result_array());
        echo json_encode($outputArray);
    }
    public function bangla_name(){
        $bangla_name=$this->input->post('bangla_name');
        $this->db->select('name_bn');
        $this->db->like('name_bn', $bangla_name);
        $this->db->limit(70);
        $query = $this->db->get('pr_emp_per_info');
        $outputArray = array_map(function ($obj) {
            return $obj["name_bn"];
        }, $query->result_array());
        echo json_encode($outputArray);
    }





    public function english_village(){
        $english_village=$this->input->post('english_village');
        $this->db->select('per_village');
        $this->db->like('per_village', $english_village);
        $this->db->limit(70);
        $query = $this->db->get('pr_emp_per_info');
        $outputArray = array_map(function ($obj) {
            return $obj["per_village"];
        }, $query->result_array());
        echo json_encode($outputArray);
    }

    public function bangla_village(){
        $bangla_village=$this->input->post('bangla_village');
        $this->db->select('per_village_bn');
        $this->db->like('per_village_bn', $bangla_village);
        $this->db->limit(70);
        $query = $this->db->get('pr_emp_per_info');
        $outputArray = array_map(function ($obj) {
            return $obj["per_village_bn"];
        }, $query->result_array());
        echo json_encode($outputArray);
    }





}


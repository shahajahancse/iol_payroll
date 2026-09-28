<?php
class Setup_con extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        // $this->load->library('Grocery_crud');
        $this->load->model('Acl_model');
        $this->load->model('Common_model');
        $this->load->helper('url');
        $this->load->model('Crud_model');
        $this->load->library('form_validation');

        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
        // dd($this->data['user_data']
        if (!check_acl_list($this->data['user_data']->id, 2)) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
            redirect("payroll_con");
            exit;
        }
    }

    //----------------------------------------------------------------------------------
    // CRUD for Department
    //----------------------------------------------------------------------------------
    public function department($start = 0)
    {
        $this->load->library('pagination');
        $limit = 10;
        $config['base_url'] = base_url() . "setup_con/department/";
        $config['per_page'] = $limit;

        $condition = 0;
        if ($this->input->get('request')) {
            $query = $this->input->get('request');
            $condition = "(pr_units.unit_name LIKE '" . $query . "%' OR emp_depertment.dept_name LIKE '%" . $query . "%' OR emp_depertment.dept_bangla LIKE '%" . $query . "%')";
        }
        $this->load->model('Crud_model');
        $pr_dept = $this->Crud_model->dept_infos($limit, $start, $condition, $this->data['user_data']->unit_name);
        $total = $this->db->query("SELECT FOUND_ROWS() as count")->row()->count;
        $config['total_rows'] = $total;
        $config["uri_segment"] = 3;
        // $this->load->library('pagination');

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['pr_dept'] = $pr_dept;

        // dd($this->data);

        $this->data['title'] = 'Department List';
        $this->data['username'] = $this->data['user_data']->id_number;

        $this->data['subview'] = 'setup/dept_list';
        $this->load->view('layout/template', $this->data);
    }

    // Department create
    public function dept_add()
    {

        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();

        $this->form_validation->set_rules('dept_name', 'dept Name', 'trim|required');
        $this->form_validation->set_rules('dept_bangla', 'dept Bangla Name', 'trim|required');

        if ($this->form_validation->run() == true) {
            $formArray = array(
                'dept_name' => $this->input->post('dept_name'),
                'dept_bangla' => $this->input->post('dept_bangla'),
                'unit_id' => $this->input->post('unit_id'),
            );

            if ($this->db->insert('emp_depertment', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failuer', 'Sorry!, Something wrong.');
            }
            redirect(base_url('setup_con/department'));
        }

        $this->data['title'] = 'Add Department';
        $this->data['username'] = $this->data['user_data']->id_number;

        $this->data['subview'] = 'setup/dept_add';
        $this->load->view('layout/template', $this->data);
    }

    // department update
    public function dept_edit($deptId)
    {
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();

        $this->form_validation->set_rules('dept_name', 'dept Name', 'trim|required');
        $this->form_validation->set_rules('dept_bangla', 'dept Bangla Name', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->db->where('dept_id', $deptId);
            $this->data['pr_dept'] = $this->db->get('emp_depertment')->row();

            $this->data['title'] = 'Update Department';
            $this->data['username'] = $this->data['user_data']->id_number;

            $this->data['subview'] = 'setup/dept_edit';
            $this->load->view('layout/template', $this->data);
        } else {

            $formArray = array(
                'dept_name' => $this->input->post('dept_name'),
                'dept_bangla' => $this->input->post('dept_bangla'),
                'unit_id' => $this->input->post('unit_id'),
            );
            $this->db->where('dept_id', $deptId);
            $this->db->update('emp_depertment', $formArray);

            $this->session->set_flashdata('success', 'Record Updated successfully!');
            //alert('Record add successfully!');
            redirect('/setup_con/department');
        }
    }

    // Department delete
    public function dept_delete($deptId)
    {
        $dept = $this->db->where('dept_id', $deptId)->get('emp_depertment')->row();
        if (empty($dept)) {
            $this->session->set_flashdata('failuer', 'Record Not Found in DataBase!');
            redirect('setup_con/department');
        }
        $this->db->where('dept_id', $deptId)->delete('emp_depertment');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('setup_con/department');
    }
    //----------------------------------------------------------------------------------
    // CRUD End for Department
    //----------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------
    // CRUD for Post Office
    //----------------------------------------------------------------------------------
    public function post_office($start = 0)
    {
        $this->load->library('pagination');
        $limit = 10;
        $config['base_url'] = base_url() . "setup_con/post_office/";
        $config['per_page'] = $limit;

        $condition = 0;
        if ($this->input->get('request')) {
            $query = $this->input->get('request');
            $condition = "(pr_units.unit_name LIKE '" . $query . "%' OR emp_depertment.dept_name LIKE '%" . $query . "%' OR emp_depertment.dept_bangla LIKE '%" . $query . "%')";
        }

        $this->load->model('Crud_model');
        $pr_dept = $this->Crud_model->get_post_office($limit, $start, $condition);
        $total = $this->db->query("SELECT FOUND_ROWS() as count")->row()->count;
        $config['total_rows'] = $total;
        $config["uri_segment"] = 3;
        // $this->load->library('pagination');

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['pr_dept'] = $pr_dept;

        // dd($this->data);

        $this->data['title'] = 'Post Office List';
        $this->data['username'] = $this->data['user_data']->id_number;

        $this->data['subview'] = 'setup/post_office_list';
        $this->load->view('layout/template', $this->data);
    }

    // Post Office create
    public function post_office_add(){

        $this->form_validation->set_rules('division', 'Division Name', 'trim|required');
        $this->form_validation->set_rules('district', 'District Name', 'trim|required');
        $this->form_validation->set_rules('upazila', 'Upazila Name', 'trim|required');
        $this->form_validation->set_rules('post_office', 'Post Office Bangla Name', 'trim|required');
        $this->form_validation->set_rules('post_office_en', 'Post Office English Name', 'trim|required');
        if ($this->form_validation->run() == true) {
            $post_en = $this->input->post('post_office_en');
            $upazila = $this->input->post('upazila');
            $formArray = array(
                'div_id' => $this->input->post('division'),
                'dis_id' => $this->input->post('district'),
                'up_zil_id' => $this->input->post('upazila'),
                'name_bn' => $this->input->post('post_office'),
                'name_en' => $this->input->post('post_office_en'),
                'status' => 1,
            );

            $this->db->where('name_bn', $post_en);
            $this->db->where('up_zil_id', $upazila);
            $query = $this->db->get('emp_post_offices');
            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('failuer', 'Sorry!, Duplicate Entry.');
            }else{
                if ($this->db->insert('emp_post_offices', $formArray)) {
                    $this->session->set_flashdata('success', 'Record add successfully!');
                } else {
                    $this->session->set_flashdata('failuer', 'Sorry!, Something wrong.');
                }
            }
            // return false;
            // redirect(base_url('setup_con/post_office'));
        }

        $this->data['divisions'] = $this->db->get('emp_divisions')->result_array();
        $this->data['title'] = 'Add Post Office';
        $this->data['username'] = $this->data['user_data']->id_number;

        $this->data['subview'] = 'setup/post_office_add';
        $this->load->view('layout/template', $this->data);
    }

    // Post Office update
    public function post_office_edit($id){
        $this->form_validation->set_rules('division', 'Division Name', 'trim|required');
        $this->form_validation->set_rules('district', 'District Name', 'trim|required');
        $this->form_validation->set_rules('upazila', 'Upazila Name', 'trim|required');
        $this->form_validation->set_rules('post_office', 'Post Office Bangla Name', 'trim|required');
        $this->form_validation->set_rules('post_office_en', 'Post Office English Name', 'trim|required');
        if ($this->form_validation->run() == true) {
            $post_bn = $this->input->post('post_office');
            $post_en = $this->input->post('post_office_en');
            $formArray = array(
                'div_id' => $this->input->post('division'),
                'dis_id' => $this->input->post('district'),
                'up_zil_id' => $this->input->post('upazila'),
                'name_bn' => $this->input->post('post_office'),
                'name_en' => $this->input->post('post_office_en'),
                'status' => 1,
            );
            $this->db->where('name_bn', $post_bn);
            $this->db->or_where('name_en', $post_en);
            $query = $this->db->get('emp_post_offices');
            if ($query->num_rows()  >0) {
                $this->session->set_flashdata('failuer', 'Sorry!, Duplicate Entry.');
            }else{
                $this->db->where('id', $id);
                $this->db->update('emp_post_offices', $formArray);
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            }
            redirect('/setup_con/post_office');
        }
        $this->data['divisions'] = $this->db->get('emp_divisions')->result_array();
        $this->data['post'] = $this->db->where('id', $id)->get('emp_post_offices')->row();
        $this->data['title'] = 'Update Post Office';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/post_office_edit';
        $this->load->view('layout/template', $this->data);
    }
    // Post Office delete
    public function post_office_delete($id)
    {
        $post = $this->db->where('id', $id)->get('emp_post_offices')->row();
        if (empty($post)) {
            $this->session->set_flashdata('failuer', 'Record Not Found in DataBase!');
            redirect('setup_con/post_office');
        }
        $this->db->where('id', $id)->delete('emp_post_offices');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('setup_con/post_office');
    }
    //----------------------------------------------------------------------------------
    // End CRUD Post Office
    //----------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------
    // CRUD for Upazila / Thana
    //----------------------------------------------------------------------------------
    public function upazila($start = 0)
    {
        $this->load->library('pagination');
        $limit = 10;
        $config['base_url'] = base_url() . "setup_con/post_office/";
        $config['per_page'] = $limit;

        $condition = 0;
        if ($this->input->get('request')) {
            $query = $this->input->get('request');
            $condition = "(pr_units.unit_name LIKE '" . $query . "%' OR emp_depertment.dept_name LIKE '%" . $query . "%' OR emp_depertment.dept_bangla LIKE '%" . $query . "%')";
        }

        $this->load->model('Crud_model');
        $pr_dept = $this->Crud_model->get_post_office($limit, $start, $condition);
        $total = $this->db->query("SELECT FOUND_ROWS() as count")->row()->count;
        $config['total_rows'] = $total;
        $config["uri_segment"] = 3;
        // $this->load->library('pagination');

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['pr_dept'] = $pr_dept;

        // dd($this->data);

        $this->data['title'] = 'Post Office List';
        $this->data['username'] = $this->data['user_data']->id_number;

        $this->data['subview'] = 'setup/post_office_list';
        $this->load->view('layout/template', $this->data);
    }

    // Upazila / Thana create
    public function upazila_add(){
        // dd($_POST);
        $this->form_validation->set_rules('division', 'Division Name', 'trim|required');
        $this->form_validation->set_rules('district', 'District Name', 'trim|required');
        $this->form_validation->set_rules('upazila', 'Upazila Bangla Name', 'trim|required');
        $this->form_validation->set_rules('upazila_en', 'Upazila English Name', 'trim|required');
        if ($this->form_validation->run() == true) {
            $upazila = $this->input->post('upazila');
            $upazila_en = $this->input->post('upazila_en');
            $formArray = array(
                'div_id' => $this->input->post('division'),
                'dis_id' => $this->input->post('district'),
                'name_bn' => $this->input->post('upazila'),
                'name_en' => $this->input->post('upazila_en'),
                'status' => 1,
            );

            $this->db->where('name_bn', $upazila);
            $this->db->where('name_en', $upazila_en);
            $query = $this->db->get('emp_upazilas');
            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('failuer', 'Sorry!, Duplicate Entry.');
            }else{
                if ($this->db->insert('emp_upazilas', $formArray)) {
                    $this->session->set_flashdata('success', 'Record add successfully!');
                } else {
                    $this->session->set_flashdata('failuer', 'Sorry!, Something wrong.');
                }
            }
            // return false;
            // redirect(base_url('setup_con/post_office'));
        }

        $this->data['divisions'] = $this->db->get('emp_divisions')->result_array();
        $this->data['title'] = 'Add Upazila / Thana';
        $this->data['username'] = $this->data['user_data']->id_number;

        $this->data['subview'] = 'setup/upazila_add';
        $this->load->view('layout/template', $this->data);
    }

    // Upazila / Thana update
    public function upazila_edit($id){
        $this->form_validation->set_rules('division', 'Division Name', 'trim|required');
        $this->form_validation->set_rules('district', 'District Name', 'trim|required');
        $this->form_validation->set_rules('upazila', 'Upazila Name', 'trim|required');
        $this->form_validation->set_rules('post_office', 'Post Office Bangla Name', 'trim|required');
        $this->form_validation->set_rules('post_office_en', 'Post Office English Name', 'trim|required');
        if ($this->form_validation->run() == true) {
            $post_bn = $this->input->post('post_office');
            $post_en = $this->input->post('post_office_en');
            $formArray = array(
                'div_id' => $this->input->post('division'),
                'dis_id' => $this->input->post('district'),
                'up_zil_id' => $this->input->post('upazila'),
                'name_bn' => $this->input->post('post_office'),
                'name_en' => $this->input->post('post_office_en'),
                'status' => 1,
            );
            $this->db->where('name_bn', $post_bn);
            $this->db->or_where('name_en', $post_en);
            $query = $this->db->get('emp_post_offices');
            if ($query->num_rows()  >0) {
                $this->session->set_flashdata('failuer', 'Sorry!, Duplicate Entry.');
            }else{
                $this->db->where('id', $id);
                $this->db->update('emp_post_offices', $formArray);
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            }
            redirect('/setup_con/post_office');
        }
        $this->data['divisions'] = $this->db->get('emp_divisions')->result_array();
        $this->data['post'] = $this->db->where('id', $id)->get('emp_post_offices')->row();
        $this->data['title'] = 'Update Post Office';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/post_office_edit';
        $this->load->view('layout/template', $this->data);
    }
    // Upazila / Thana delete
    public function upazila_delete($id)
    {
        $post = $this->db->where('id', $id)->get('emp_post_offices')->row();
        if (empty($post)) {
            $this->session->set_flashdata('failuer', 'Record Not Found in DataBase!');
            redirect('setup_con/post_office');
        }
        $this->db->where('id', $id)->delete('emp_post_offices');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('setup_con/post_office');
    }
    //----------------------------------------------------------------------------------
    // End CRUD Upazila / Thana
    //----------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------
    // CRUD for district
    //----------------------------------------------------------------------------------
    public function district($start = 0)
    {
        $this->load->library('pagination');
        $limit = 10;
        $config['base_url'] = base_url() . "setup_con/post_office/";
        $config['per_page'] = $limit;

        $condition = 0;
        if ($this->input->get('request')) {
            $query = $this->input->get('request');
            $condition = "(pr_units.unit_name LIKE '" . $query . "%' OR emp_depertment.dept_name LIKE '%" . $query . "%' OR emp_depertment.dept_bangla LIKE '%" . $query . "%')";
        }

        $this->load->model('Crud_model');
        $pr_dept = $this->Crud_model->get_post_office($limit, $start, $condition);
        $total = $this->db->query("SELECT FOUND_ROWS() as count")->row()->count;
        $config['total_rows'] = $total;
        $config["uri_segment"] = 3;
        // $this->load->library('pagination');

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['pr_dept'] = $pr_dept;

        // dd($this->data);

        $this->data['title'] = 'Post Office List';
        $this->data['username'] = $this->data['user_data']->id_number;

        $this->data['subview'] = 'setup/post_office_list';
        $this->load->view('layout/template', $this->data);
    }

    // district create
    public function district_add(){

        $this->form_validation->set_rules('division', 'Division Name', 'trim|required');
        $this->form_validation->set_rules('district', 'District Name', 'trim|required');
        $this->form_validation->set_rules('upazila', 'Upazila Name', 'trim|required');
        $this->form_validation->set_rules('post_office', 'Post Office Bangla Name', 'trim|required');
        $this->form_validation->set_rules('post_office_en', 'Post Office English Name', 'trim|required');
        if ($this->form_validation->run() == true) {
            $post_en = $this->input->post('post_office_en');
            $upazila = $this->input->post('upazila');
            $formArray = array(
                'div_id' => $this->input->post('division'),
                'dis_id' => $this->input->post('district'),
                'up_zil_id' => $this->input->post('upazila'),
                'name_bn' => $this->input->post('post_office'),
                'name_en' => $this->input->post('post_office_en'),
                'status' => 1,
            );

            $this->db->where('name_bn', $post_en);
            $this->db->where('up_zil_id', $upazila);
            $query = $this->db->get('emp_post_offices');
            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('failuer', 'Sorry!, Duplicate Entry.');
            }else{
                if ($this->db->insert('emp_post_offices', $formArray)) {
                    $this->session->set_flashdata('success', 'Record add successfully!');
                } else {
                    $this->session->set_flashdata('failuer', 'Sorry!, Something wrong.');
                }
            }
            // return false;
            // redirect(base_url('setup_con/post_office'));
        }

        $this->data['divisions'] = $this->db->get('emp_divisions')->result_array();
        $this->data['title'] = 'Add Post Office';
        $this->data['username'] = $this->data['user_data']->id_number;

        $this->data['subview'] = 'setup/post_office_add';
        $this->load->view('layout/template', $this->data);
    }

    // district update
    public function district_edit($id){
        $this->form_validation->set_rules('division', 'Division Name', 'trim|required');
        $this->form_validation->set_rules('district', 'District Name', 'trim|required');
        $this->form_validation->set_rules('upazila', 'Upazila Name', 'trim|required');
        $this->form_validation->set_rules('post_office', 'Post Office Bangla Name', 'trim|required');
        $this->form_validation->set_rules('post_office_en', 'Post Office English Name', 'trim|required');
        if ($this->form_validation->run() == true) {
            $post_bn = $this->input->post('post_office');
            $post_en = $this->input->post('post_office_en');
            $formArray = array(
                'div_id' => $this->input->post('division'),
                'dis_id' => $this->input->post('district'),
                'up_zil_id' => $this->input->post('upazila'),
                'name_bn' => $this->input->post('post_office'),
                'name_en' => $this->input->post('post_office_en'),
                'status' => 1,
            );
            $this->db->where('name_bn', $post_bn);
            $this->db->or_where('name_en', $post_en);
            $query = $this->db->get('emp_post_offices');
            if ($query->num_rows()  >0) {
                $this->session->set_flashdata('failuer', 'Sorry!, Duplicate Entry.');
            }else{
                $this->db->where('id', $id);
                $this->db->update('emp_post_offices', $formArray);
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            }
            redirect('/setup_con/post_office');
        }
        $this->data['divisions'] = $this->db->get('emp_divisions')->result_array();
        $this->data['post'] = $this->db->where('id', $id)->get('emp_post_offices')->row();
        $this->data['title'] = 'Update Post Office';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/post_office_edit';
        $this->load->view('layout/template', $this->data);
    }
    // district delete
    public function district_delete($id)
    {
        $post = $this->db->where('id', $id)->get('emp_post_offices')->row();
        if (empty($post)) {
            $this->session->set_flashdata('failuer', 'Record Not Found in DataBase!');
            redirect('setup_con/post_office');
        }
        $this->db->where('id', $id)->delete('emp_post_offices');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('setup_con/post_office');
    }
    //----------------------------------------------------------------------------------
    // End CRUD district
    //----------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------
    // CRUD for Section
    //----------------------------------------------------------------------------------
    public function section($start = 0)
    {
       $this->db->select('emp_depertment.*,pr_units.unit_name,emp_section.*');
        $this->db->from('emp_section');
        $this->db->join('emp_depertment', 'emp_depertment.dept_id=emp_section.depertment_id');
        $this->db->join('pr_units', 'pr_units.unit_id=emp_section.unit_id');
        if ($this->data['user_data']->unit_name!=0) {
        $this->db->where('emp_section.unit_id', $this->data['user_data']->unit_name);
        }

        $this->data['pr_sec'] = $this->db->get()->result_array();
        $this->data['title'] = 'Section List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/sec_list';
        $this->load->view('layout/template', $this->data);
    }

    public function get_unit()
    {
        $department_id = $_POST['department_id'];
        $this->db->select('emp_depertment.*,pr_units.*');
        $this->db->from('emp_depertment');
        $this->db->join('pr_units', 'pr_units.unit_id=emp_depertment.unit_id');
        $this->db->where('emp_depertment.dept_id', $department_id);
        $unit = $this->db->get()->result_array();
        echo json_encode($unit);

    }

    public function get_department()
    {
        $unit_id = $_POST['unit_id'];
        $this->db->select('emp_depertment.*');
        $this->db->from('emp_depertment');
        $this->db->where('emp_depertment.unit_id', $unit_id);
        $department = $this->db->get()->result_array();
        echo json_encode($department);
    }
    public function get_line()
    {
        $sec_id = $_POST['id'];
        $this->db->select('emp_line_num.*');
        $this->db->from('emp_line_num');
        $this->db->where('emp_line_num.section_id', $sec_id);
        $department = $this->db->get()->result_array();
        echo json_encode($department);
    }
    public function sec_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('sec_name_en', 'Section Name', 'trim|required');
        $this->form_validation->set_rules('sec_name_bn', 'Section Bangla Name', 'trim|required');
        $this->form_validation->set_rules('depertment_id', 'Department', 'required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('group_one', '', 'required');
        $this->form_validation->set_rules('group_two', '', 'required');
        $this->form_validation->set_rules('group_three', '', 'required');
        $this->form_validation->set_rules('group_four', '', 'required');
        $this->form_validation->set_rules('group_five', '', 'required');
        $this->form_validation->set_rules('group_six', '', 'required');
        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            $this->db->select('emp_depertment.*');
            $this->data['department'] = $this->db->get('emp_depertment')->result();
            $this->db->select('pr_units.*');
            $this->data['unit'] = $this->pr_units_get();
            $this->data['title'] = 'Add Section';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/sec_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'sec_name_en'  => $this->input->post('sec_name_en'),
                'sec_name_bn'  => $this->input->post('sec_name_bn'),
                'depertment_id'=> $this->input->post('depertment_id'),
                'unit_id'      => $this->input->post('unit_id'),
                'group_one'    => $this->input->post('group_one'),
                'group_two'    => $this->input->post('group_two'),
                'group_three'  => $this->input->post('group_three'),
                'group_four'   => $this->input->post('group_four'),
                'group_five'   => $this->input->post('group_five'),
                'group_six'    => $this->input->post('group_six'),
            );

            if ($this->db->insert('emp_section', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/section');
        }

    }

    public function pr_units_get(){
        $user_data=$this->session->userdata('data');
        $this->db->select('pr_units.*');
        if($user_data->level!='All'){
            $this->db->where('unit_id', $user_data->unit_name);
        }
        return $this->db->get('pr_units')->result();
    }

    public function sec_edit($secId)
    {
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sec_name_en', 'Section Name', 'trim|required');
        $this->form_validation->set_rules('sec_name_bn', 'Section Bangla Name', 'trim|required');
        $this->form_validation->set_rules('depertment_id', 'Department', 'required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('group_one', 'Operator Budget', 'required');
        $this->form_validation->set_rules('group_two', 'Man Power', 'required');
        $this->form_validation->set_rules('group_three', 'Man Power', 'required');
        $this->form_validation->set_rules('group_four', 'Man Power', 'required');
        $this->form_validation->set_rules('group_five', 'Man Power', 'required');
        $this->form_validation->set_rules('group_six', 'Man Power', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            $this->db->select('pr_units.*');
            $this->data['unit'] = $this->db->get('pr_units')->result();

            $this->data['sec'] = $this->Crud_model->getsec($secId);
            $this->data['title'] = 'Edit Section';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/sec_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'sec_name_en'  => $this->input->post('sec_name_en'),
                'sec_name_bn'  => $this->input->post('sec_name_bn'),
                'depertment_id'=> $this->input->post('depertment_id'),
                'unit_id'      => $this->input->post('unit_id'),
                'group_one'    => $this->input->post('group_one'),
                'group_two'    => $this->input->post('group_two'),
                'group_three'  => $this->input->post('group_three'),
                'group_four'   => $this->input->post('group_four'),
                'group_five'   => $this->input->post('group_five'),
                'group_six'    => $this->input->post('group_six'),
            );
            $this->db->where('id', $secId);
            if ($this->db->update('emp_section', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'setup_con/section');

        }

    }

    public function sec_delete($secId)
    {
        $this->load->model('Crud_model');
        $sec = $this->Crud_model->getsec($secId);
        if (empty($sec)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect(base_url() . 'setup_con/section');
        }
        $this->Crud_model->sec_delete($secId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'setup_con/section');
    }
    //----------------------------------------------------------------------------------
    // CRUD for Section END
    //----------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------
    // CRUD for LINE start
    //----------------------------------------------------------------------------------
    public function line()
    {
        $this->db->select('emp_line_num.*,emp_depertment.dept_name,pr_units.unit_name,emp_section.sec_name_en');
        $this->db->from('emp_line_num');
        $this->db->join('emp_depertment', 'emp_depertment.dept_id = emp_line_num.dept_id','left');
        $this->db->join('pr_units', 'pr_units.unit_id = emp_line_num.unit_id','left');
        $this->db->join('emp_section', 'emp_section.id = emp_line_num.section_id','left');
        if ($this->data['user_data']->unit_name!=0) {
        $this->db->where('emp_line_num.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['pr_line'] = $this->db->get()->result_array();
        $this->data['title'] = 'Line List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/line_list';
        $this->load->view('layout/template', $this->data);
    }

    public function get_section()
    {
        $depertment_id = $_POST['depertment_id'];
        $this->db->select('emp_section.*');
        $this->db->from('emp_section');
        $this->db->where('emp_section.depertment_id', $depertment_id);
        $section = $this->db->get()->result_array();
        echo json_encode($section);
    }

    public function line_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('line_name_en', 'Line English Name', 'trim|required');
        $this->form_validation->set_rules('line_name_bn', 'Line Bangla Name', 'trim|required');
        $this->form_validation->set_rules('section_id', 'Section', 'required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('depertment_id', 'Department', 'required');
        $this->form_validation->set_rules('group_one', '', 'required');
        $this->form_validation->set_rules('group_two', '', 'required');
        $this->form_validation->set_rules('group_three', '', 'required');
        $this->form_validation->set_rules('group_four', '', 'required');
        $this->form_validation->set_rules('group_five', '', 'required');
        $this->form_validation->set_rules('group_six', '', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            $this->db->select('pr_units.*');
            $this->data['unit'] =$this->pr_units_get();
            $this->data['title'] = 'Add Line';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/line_add';
            $this->load->view('layout/template', $this->data);
        } else {

            $formArray = array(
                'line_name_en'=> $this->input->post('line_name_en'),
                'line_name_bn'=> $this->input->post('line_name_bn'),
                'section_id'  => $this->input->post('section_id'),
                'unit_id'     => $this->input->post('unit_id'),
                'dept_id'     => $this->input->post('depertment_id'),
                'group_one'   => $this->input->post('group_one'),
                'group_two'   => $this->input->post('group_two'),
                'group_three' => $this->input->post('group_three'),
                'group_four'  => $this->input->post('group_four'),
                'group_five'  => $this->input->post('group_five'),
                'group_six'   => $this->input->post('group_six'),
            );

            if ($this->db->insert('emp_line_num', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/line');
        }

    }

    public function line_edit($line_id)
    {
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('line_name_en', 'Line English Name', 'trim|required');
        $this->form_validation->set_rules('line_name_bn', 'Line Bangla Name', 'trim|required');
        $this->form_validation->set_rules('section_id', 'Section', 'required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('group_one', '', 'required');
        $this->form_validation->set_rules('group_two', '', 'required');
        $this->form_validation->set_rules('group_three', '', 'required');
        $this->form_validation->set_rules('group_four', '', 'required');
        $this->form_validation->set_rules('group_five', '', 'required');
        $this->form_validation->set_rules('group_six', '', 'required');
        $this->form_validation->set_rules('depertment_id', 'Department', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            $this->db->select('pr_units.*');
            $this->data['unit'] = $this->db->get('pr_units')->result();

            $this->data['line'] = $this->Crud_model->getline($line_id);
            $this->data['title'] = 'Edit Section';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/line_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'line_name_en'=> $this->input->post('line_name_en'),
                'line_name_bn'=> $this->input->post('line_name_bn'),
                'section_id'  => $this->input->post('section_id'),
                'unit_id'     => $this->input->post('unit_id'),
                'group_one'   => $this->input->post('group_one'),
                'group_two'   => $this->input->post('group_two'),
                'group_three' => $this->input->post('group_three'),
                'group_four'  => $this->input->post('group_four'),
                'group_five'  => $this->input->post('group_five'),
                'group_six'   => $this->input->post('group_six'),
                'dept_id'     => $this->input->post('depertment_id'),
            );
            $this->db->where('id', $line_id);
            if ($this->db->update('emp_line_num', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'setup_con/line');
        }
    }

    public function line_delete($line_id)
    {
        $this->db->where('id', $line_id);
        $this->db->delete('emp_line_num');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'setup_con/line');
    }

    //----------------------------------------------------------------------------------
    // CRUD for LINE end
    //----------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------
    // CRUD for attn_bonus start
    //----------------------------------------------------------------------------------

    public function attendance_bonus()
    {
        $this->db->select('allowance_attn_bonus.*,pr_units.unit_name');
        $this->db->from('allowance_attn_bonus');
        $this->db->join('pr_units', 'pr_units.unit_id=allowance_attn_bonus.unit_id');
        if ($this->data['user_data']->unit_name!=0) {
          $this->db->where('allowance_attn_bonus.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['attendance_bonus'] = $this->db->get()->result_array();
        $this->data['title'] = 'Attendance Bonus List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/attbn_list';
        $this->load->view('layout/template', $this->data);
    }

    public function attn_bonus_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Rule', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->data['pr_units'] = $this->pr_units_get();
            $this->data['title'] = 'Add Attendance Bonus';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/attbn_add';
            $this->load->view('layout/template', $this->data);
        } else {

            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'prev_rule' => $this->input->post('prev_rule'),
                'prev_end' => date('Y-m-d', strtotime($this->input->post('prev_end'))),
                'rule1' => $this->input->post('rule1'),
                'rule1_end' => date('Y-m-d', strtotime($this->input->post('rule1_end'))),
                'rule' => $this->input->post('rule'),
            );


            if ($this->db->insert('allowance_attn_bonus', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/attendance_bonus');
        }

    }

    public function attn_bonus_edit($rule_id)
    {
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Rule', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->db->select('pr_units.*');
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->data['attbn'] = $this->Crud_model->getattbn($rule_id);
            $this->data['title'] = 'Edit Attendance Bonus';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/attbn_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'prev_rule' => $this->input->post('prev_rule'),
                'prev_end' => date('Y-m-d', strtotime($this->input->post('prev_end'))),
                'rule1' => $this->input->post('rule1'),
                'rule1_end' => date('Y-m-d', strtotime($this->input->post('rule1_end'))),
                'rule' => $this->input->post('rule'),
            );

            $this->db->where('id', $rule_id);
            if ($this->db->update('allowance_attn_bonus', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'setup_con/attendance_bonus');
        }
    }

    public function attn_bonus_delete($line_id)
    {
        $this->db->where('id', $line_id);
        $this->db->delete('allowance_attn_bonus');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'setup_con/attendance_bonus');
    }

    //----------------------------------------------------------------------------------
    // CRUD for attn_bonus end
    //----------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------
    // CRUD for weekend_allowance start
    //----------------------------------------------------------------------------------

    public function weekend_allowance_setup()
    {
        $this->db->select('allowance_holiday_weekend_rules.*,pr_units.unit_name');
        $this->db->from('allowance_holiday_weekend_rules');
        $this->db->join('pr_units', 'pr_units.unit_id=allowance_holiday_weekend_rules.unit_id');
        if ($this->data['user_data']->unit_name!=0) {
        $this->db->where('allowance_holiday_weekend_rules.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['allowance_holiday_weekend_rules'] = $this->db->get()->result_array();
        $this->data['title'] = 'Attendance Bonus List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/weekend_allowance_list';
        $this->load->view('layout/template', $this->data);
    }

    public function weekend_allowance_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Amount', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->data['pr_units'] =$this->pr_units_get();
            $this->data['title'] = 'Add Holyday/Weekend Allowance';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/weekend_allowance_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'allowance_amount' => $this->input->post('rule'),
            );
            if ($this->db->insert('allowance_holiday_weekend_rules', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/weekend_allowance_setup');
        }

    }

    public function weekend_allowance_edit($id)
    {
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Amount', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->db->select('pr_units.*');
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->where('id', $id);
            $this->data['attbn'] = $this->db->get('allowance_holiday_weekend_rules')->row($id);
            $this->data['title'] = 'Edit Holyday/Weekend Allowance';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/weekend_allowance_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'allowance_amount' => $this->input->post('rule'),
            );
            $this->db->where('id', $id);
            if ($this->db->update('allowance_holiday_weekend_rules', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'setup_con/weekend_allowance_setup');

        }

    }

    public function weekend_allowance_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('allowance_holiday_weekend_rules');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'setup_con/weekend_allowance_setup');
    }

    //----------------------------------------------------------------------------------
    // CRUD for holiday/weekend allowance end
    //----------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------
    // CRUD for tiffin bill start
    //----------------------------------------------------------------------------------

    public function tiffin_bill_setup()
    {
        $this->db->select('allowance_tiffin_bill.*,pr_units.unit_name');
        $this->db->from('allowance_tiffin_bill');
        $this->db->join('pr_units', 'pr_units.unit_id=allowance_tiffin_bill.unit_id');
        if ($this->data['user_data']->unit_name!=0) {
        $this->db->where('allowance_tiffin_bill.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['allowance_tiffin_bill'] = $this->db->get()->result_array();
        $this->data['title'] = 'Attendance Bonus List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/tiffin_bill_list';
        $this->load->view('layout/template', $this->data);
    }

    public function tiffin_bill_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Amount', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->data['pr_units'] = $this->pr_units_get();
            $this->data['title'] = 'Add Holyday/Weekend Allowance';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/tiffin_bill_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'allowance_amount' => $this->input->post('rule'),
            );
            if ($this->db->insert('allowance_tiffin_bill', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/tiffin_bill_setup');
        }

    }

    public function tiffin_bill_edit($id)
    {
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Amount', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->db->select('pr_units.*');
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->where('id', $id);
            $this->data['attbn'] = $this->db->get('allowance_tiffin_bill')->row($id);
            $this->data['title'] = 'Edit Holyday/Weekend Allowance';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/tiffin_bill_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'allowance_amount' => $this->input->post('rule'),
            );
            $this->db->where('id', $id);
            if ($this->db->update('allowance_tiffin_bill', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'setup_con/tiffin_bill_setup');

        }

    }

    public function tiffin_bill_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('allowance_tiffin_bill');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'setup_con/tiffin_bill_setup');
    }

    //----------------------------------------------------------------------------------
    // CRUD for Tiffin Bill end
    //----------------------------------------------------------------------------------

    public function iftar_bill_setup()
    {
        $this->db->select('allowance_iftar_bill.*,pr_units.unit_name');
        $this->db->from('allowance_iftar_bill');
        $this->db->join('pr_units', 'pr_units.unit_id=allowance_iftar_bill.unit_id');
        if ($this->data['user_data']->unit_name!=0) {
            $this->db->where('allowance_iftar_bill.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['allowance_iftar_bill'] = $this->db->get()->result_array();
        $this->data['title'] = 'Attendance Bonus List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/iftar_bill_list';
        $this->load->view('layout/template', $this->data);
    }

    public function iftar_bill_add(){

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Amount', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->data['pr_units'] = $this->pr_units_get();
            $this->data['title'] = 'Add Holyday/Weekend Allowance';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/iftar_bill_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'allowance_amount' => $this->input->post('rule'),
            );
            if ($this->db->insert('allowance_iftar_bill', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/iftar_bill_setup');
        }

    }

    public function iftar_bill_edit($id){
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Amount', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->db->select('pr_units.*');
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->where('id', $id);
            $this->data['attbn'] = $this->db->get('allowance_iftar_bill')->row($id);
            $this->data['title'] = 'Edit Holyday/Weekend Allowance';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/iftar_bill_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'allowance_amount' => $this->input->post('rule'),
            );
            $this->db->where('id', $id);
            if ($this->db->update('allowance_iftar_bill', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'setup_con/iftar_bill_setup');

        }

    }

    public function iftar_bill_delete($id){
        $this->db->where('id', $id);
        $this->db->delete('allowance_iftar_bill');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'setup_con/iftar_bill_setup');
    }

    //----------------------------------------------------------------------------------
    // CRUD for Ifter end
    //----------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------
    // CRUD for Night Allowance Start
    //----------------------------------------------------------------------------------
    public function night_allowance_setup()
    {
        $this->db->select('allowance_night_rules.*,pr_units.unit_name');
        $this->db->from('allowance_night_rules');
        $this->db->join('pr_units', 'pr_units.unit_id=allowance_night_rules.unit_id');
        if ($this->data['user_data']->unit_name!=0) {
            $this->db->where('allowance_night_rules.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['allowance_night_rules'] = $this->db->get()->result_array();
        $this->data['title'] = 'Night Allowance List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/night_allowance_list';
        $this->load->view('layout/template', $this->data);
    }

    public function night_allowance_add(){
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Amount', 'required');
        $this->form_validation->set_rules('night_time', 'Time', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->data['pr_units'] = $this->pr_units_get();
            $this->data['title'] = 'Add Night Allowance';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/night_allowance_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'night_allowance' => $this->input->post('rule'),
                'night_time' => $this->input->post('night_time'),
            );
            if ($this->db->insert('allowance_night_rules', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/night_allowance_setup');
        }
    }

    public function night_allowance_edit($id){
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('rule_name', 'Rule Name', 'trim|required');
        $this->form_validation->set_rules('rule', 'Amount', 'required');
        $this->form_validation->set_rules('night_time', 'Time', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->db->select('pr_units.*');
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->where('id', $id);
            $this->data['attbn'] = $this->db->get('allowance_night_rules')->row($id);
            $this->data['title'] = 'Edit Night Allowance';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/night_allowance_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'rule_name' => $this->input->post('rule_name'),
                'night_allowance' => $this->input->post('rule'),
                'night_time' => $this->input->post('night_time'),
            );
            $this->db->where('id', $id);
            if ($this->db->update('allowance_night_rules', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'setup_con/night_allowance_setup');

        }

    }
    public function night_allowance_delete($id){
        $this->db->where('id', $id);
        $this->db->delete('allowance_night_rules');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'setup_con/night_allowance_setup');
    }
    //----------------------------------------------------------------------------------
    // CRUD for Night Allowance end
    //----------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------
    // CRUD for Designation manage  Start
    //----------------------------------------------------------------------------------
    public function designation(){
        $this->data['unit_id'] = $this->data['user_data']->unit_name;
        $this->db->select('emp_designation.*,
                            IFNULL(pr_units.unit_name, "none") as unit_name,
                            IFNULL(allowance_attn_bonus.rule, "none") as allowance_attn_bonus,
                            IFNULL(allowance_holiday_weekend_rules.allowance_amount, "none") as allowance_holiday_weekend,
                            IFNULL(allowance_iftar_bill.allowance_amount, "none") as allowance_iftar,
                            IFNULL(allowance_night_rules.night_allowance, "none") as allowance_night_rules,
                            IFNULL(allowance_tiffin_bill.allowance_amount, "none") as allowance_tiffin'
                        );
        $this->db->from('emp_designation');
        $this->db->join('pr_units', 'pr_units.unit_id=emp_designation.unit_id', 'left');
        $this->db->join('allowance_attn_bonus', 'allowance_attn_bonus.id=emp_designation.attn_id', 'left');
        $this->db->join('allowance_holiday_weekend_rules', 'allowance_holiday_weekend_rules.id=emp_designation.holiday_weekend_id', 'left');
        $this->db->join('allowance_iftar_bill', 'allowance_iftar_bill.id=emp_designation.iftar_id', 'left');
        $this->db->join('allowance_night_rules', 'allowance_night_rules.id=emp_designation.night_al_id', 'left');
        $this->db->join('allowance_tiffin_bill', 'allowance_tiffin_bill.id=emp_designation.tiffin_id', 'left');
        if ($this->data['user_data']->unit_name!=0) {

        $this->db->where('emp_designation.unit_id', $this->data['unit_id']);
        }
        $this->data['emp_designation'] = $this->db->get()->result_array();

        // dd($this->data);
        $this->data['title'] = 'Designation List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/desig_list';
        $this->load->view('layout/template', $this->data);
    }

    public function get_data_degi()
    {
        $unit_id = $_POST['unit_id'];

        $data = [];

        $data['attn_bonus'] = $this->db->where('allowance_attn_bonus.unit_id', $unit_id)
            ->get('allowance_attn_bonus')
            ->result_array();

        $data['holiday_weekend'] = $this->db->where('allowance_holiday_weekend_rules.unit_id', $unit_id)
            ->get('allowance_holiday_weekend_rules')
            ->result_array();

        $data['iftar'] = $this->db->where('allowance_iftar_bill.unit_id', $unit_id)
            ->get('allowance_iftar_bill')
            ->result_array();

        $data['night'] = $this->db->where('allowance_night_rules.unit_id', $unit_id)
            ->get('allowance_night_rules')
            ->result_array();

        $data['tiffin'] = $this->db->where('allowance_tiffin_bill.unit_id', $unit_id)
            ->get('allowance_tiffin_bill')
            ->result_array();

        echo json_encode($data);
    }

    public function designation_add(){
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('desig_name', 'Designation Name English', 'required');
        // $this->form_validation->set_rules('desig_bangla', 'Designation Bangla', 'required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('attn_id', 'Attendence Bonus', 'required');
        $this->form_validation->set_rules('holiday_weekend_id', 'Holiday Weekend', 'required');
        $this->form_validation->set_rules('iftar_id', 'Iftar Allowance', 'required');
        $this->form_validation->set_rules('night_al_id', 'Night Allowance', 'required');
        $this->form_validation->set_rules('tiffin_id', 'Tiffin Allowance', 'required');

        if ($this->form_validation->run() == TRUE) {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                // 'dept_id' => $this->input->post('emp_dept_id'),
                // 'sec_id' => $this->input->post('emp_sec_id'),
                // 'line_id' => $this->input->post('emp_line_id'),
                'desig_name' => $this->input->post('desig_name'),
                'desig_bangla' => $this->input->post('desig_bangla'),
                'attn_id' => $this->input->post('attn_id'),
                'holiday_weekend_id' => $this->input->post('holiday_weekend_id'),
                'iftar_id' => $this->input->post('iftar_id'),
                'night_al_id' => $this->input->post('night_al_id'),
                'tiffin_id' => $this->input->post('tiffin_id'),
                'desig_desc' => $this->input->post('desig_desc'),
                // 'group_id' => $this->input->post('group_id'),
            );
            // dd($formArray);
            if ($this->db->insert('emp_designation', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/designation');
        }

        $this->data['pr_units'] = $this->pr_units_get();
        $this->data['title'] = 'Add Designation';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/desig_add';
        $this->load->view('layout/template', $this->data);
    }

    public function designation_edit($id){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('desig_name', 'Designation Name English', 'required');
        // $this->form_validation->set_rules('desig_bangla', 'Designation Bangla', 'required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('attn_id', 'Attendence Bonus', 'required');
        $this->form_validation->set_rules('holiday_weekend_id', 'Holiday Weekend', 'required');
        $this->form_validation->set_rules('iftar_id', 'Iftar Allowance', 'required');
        $this->form_validation->set_rules('night_al_id', 'Night Allowance', 'required');
        $this->form_validation->set_rules('tiffin_id', 'Tiffin Allowance', 'required');

        $this->db->select('pr_units.*');
        $this->data['pr_units'] = $this->db->get('pr_units')->result();

        $this->db->select('
            ed.*, IFNULL(pr_units.unit_name, "none") as unit_name,
            IFNULL(aab.rule_name, "none") as allowance_attn_bonus,
            IFNULL(ahw.rule_name, "none") as allowance_holiday_weekend,
            IFNULL(aib.rule_name, "none") as allowance_iftar,
            IFNULL(anr.rule_name, "none") as allowance_night_rules,
            IFNULL(atb.rule_name, "none") as allowance_tiffin
        ');
        $this->db->from('emp_designation as ed');
        $this->db->join('pr_units', 'pr_units.unit_id=ed.unit_id', 'left');
        $this->db->join('allowance_attn_bonus as aab', 'aab.id=ed.attn_id', 'left');
        $this->db->join('allowance_holiday_weekend_rules ahw', 'ahw.id=ed.holiday_weekend_id', 'left');
        $this->db->join('allowance_iftar_bill as aib', 'aib.id=ed.iftar_id', 'left');
        $this->db->join('allowance_night_rules as anr', 'anr.id=ed.night_al_id', 'left');
        $this->db->join('allowance_tiffin_bill as atb', 'atb.id=ed.tiffin_id', 'left');
        $this->db->where('ed.id', $id);
        $this->data['emp_designation'] = $this->db->get()->row();
        // dd($this->data['emp_designation']);
        if ($this->form_validation->run() == TRUE) {
            $formArray = array(
                'unit_id'            => $this->input->post('unit_id'),
                'desig_name'         => $this->input->post('desig_name'),
                'desig_bangla'       => $this->input->post('desig_bangla'),
                'attn_id'            => $this->input->post('attn_id'),
                'holiday_weekend_id' => $this->input->post('holiday_weekend_id'),
                'iftar_id'           => $this->input->post('iftar_id'),
                'night_al_id'        => $this->input->post('night_al_id'),
                'tiffin_id'          => $this->input->post('tiffin_id'),
                'desig_desc'         => $this->input->post('desig_desc'),

                // 'group_id'           => $this->input->post('group_id'),
            );

            $this->db->where('id', $id);
            if ($this->db->update('emp_designation', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
                redirect(base_url() . 'setup_con/designation');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
        }

        $this->data['title'] = 'Edit Designation';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/desig_edit';
        $this->load->view('layout/template', $this->data);

    }

    public function designation_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('emp_designation');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'setup_con/designation');
    }

    function check_dasig_line_acl($line_id, $section_id, $dept_id, $unit_id, $designation_id, $id = null)
    {
        $this->db->select('id');
        $this->db->from('emp_dasignation_line_acl');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $this->db->where('designation_id', $designation_id);
        $this->db->where('line_id', $line_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('dept_id', $dept_id);
        $this->db->where('unit_id', $unit_id);
        $row = $this->db->get()->num_rows();
        if ($row > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function manage_designation()
    {
        $this->db->select('pr_units.*');
        if(!empty($this->data['user_data']->unit_name)){
            $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['units'] = $this->db->get('pr_units')->result();
        $this->data['title'] = 'Manage Designation';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/manage_designation';
        $this->load->view('layout/template', $this->data);
    }

    public function manage_designation_list_ajax()
    {
        $unit_id    = $this->input->post('unit_id');
        $dept_id    = $this->input->post('dept_id');
        $section_id = $this->input->post('section_id');
        $line_id    = $this->input->post('line_id');

        $this->db->select('dacl.designation_id as id');
        $this->db->from('emp_dasignation_line_acl as dacl');
        $this->db->where('dacl.unit_id', $unit_id);
        $this->db->where('dacl.dept_id', $dept_id);
        $this->db->where('dacl.section_id', $section_id);
        $this->db->where('dacl.line_id', $line_id);
        $dgss = $this->db->get()->result();
        $data1 = array();
        foreach ($dgss as $key => $r) { $data1[$key] = $r->id; }

        $this->db->select("dg.id, dg.desig_name, dg.unit_id ");
        $this->db->from("emp_designation as dg");
        $this->db->where("dg.unit_id", $unit_id);
        $this->db->group_by("dg.id");
        $this->data['desig_id'] = $data1;
        $this->data['results'] = $this->db->get()->result();
        $this->data['title'] = 'Manage Designation';
        $this->load->view('setup/manage_designation_list_ajax', $this->data);
    }

    public function manage_designation_add_ajax()
    {
        $is_check   = $this->input->post('is_check');
        $id         = $this->input->post('id');
        $unit_id    = $this->input->post('unit_id');
        $dept_id    = $this->input->post('dept_id');
        $section_id = $this->input->post('section_id');
        $line_id    = $this->input->post('line_id');

        if ($is_check == 1) {
            $data = array(
                'unit_id'           => $unit_id,
                'dept_id'           => $dept_id,
                'section_id'        => $section_id,
                'line_id'           => $line_id,
                'designation_id'    => $id,
            );
            $this->db->insert('emp_dasignation_line_acl', $data);
        } else {
            $this->db->where('designation_id', $id)->where('unit_id', $unit_id)->where('dept_id', $dept_id);
            $this->db->where('section_id', $section_id)->where('line_id', $line_id)->delete('emp_dasignation_line_acl');
        }
    }
    //----------------------------------------------------------------------------------
    // CRUD for designation manage end
    //----------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------
    // CRUD for position Start
    //----------------------------------------------------------------------------------
    public function position()
    {
        $this->db->select('pr_emp_position.*,pr_units.unit_name');
        $this->db->from('pr_emp_position');
        $this->db->join('pr_units', 'pr_units.unit_id=pr_emp_position.unit_id');
        if ($this->data['user_data']->unit_name!=0) {
            $this->db->where('pr_emp_position.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['results'] = $this->db->get()->result_array();
        $this->data['title'] = 'Position List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/position';
        $this->load->view('layout/template', $this->data);
    }

    public function position_add(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('posi_name', 'Name English', 'trim|required');
        $this->form_validation->set_rules('posi_name_bn', 'AmoName Banglaunt', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->data['pr_units'] = $this->pr_units_get();
            $this->data['title'] = 'Add Position';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/position_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'posi_name' => $this->input->post('posi_name'),
                'posi_name_bn' => $this->input->post('posi_name_bn'),
            );
            if ($this->db->insert('pr_emp_position', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/position');
        }
    }

    public function position_edit($id){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('posi_name', 'Name English', 'trim|required');
        $this->form_validation->set_rules('posi_name_bn', 'AmoName Banglaunt', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->db->select('pr_units.*');
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->where('posi_id', $id);
            $this->data['attbn'] = $this->db->get('pr_emp_position')->row($id);
            $this->data['title'] = 'Edit Position';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/position_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'posi_name' => $this->input->post('posi_name'),
                'posi_name_bn' => $this->input->post('posi_name_bn'),
            );
            $this->db->where('posi_id', $id);
            if ($this->db->update('pr_emp_position', $formArray)) {
                $this->session->set_flashdata('success', 'Record Updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url('setup_con/position'));
        }
    }

    public function position_delete($id){
        $this->db->where('posi_id', $id);
        $this->db->delete('pr_emp_position');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url('setup_con/position'));
    }
    //----------------------------------------------------------------------------------
    // CRUD for position end
    //----------------------------------------------------------------------------------


    //-------------------------------------------------------------------------------------------------------
    // CRUD for Shift Schedules start
    //-------------------------------------------------------------------------------------------------------
    public function shift_schedule()
    {
        $pr_emp_shift_schedule = $this->Crud_model->shiftschedule_infos($this->data['user_data']->unit_name);
        $this->data['pr_emp_shift_schedule'] = $pr_emp_shift_schedule;
        $this->data['title'] = 'Shift Schedule List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/shift_schedule_list';
        $this->load->view('layout/template', $this->data);
    }
    public function shiftschedule_add()
    {
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $data['shiftscheduleinfo'] = $this->Crud_model->shiftschedule_fetch();

        $this->form_validation->set_rules('stype', 'shiftschedule Shift Type', 'trim|required');
        $this->form_validation->set_rules('instrt', 'shiftschedule In Start', 'trim|required');
        $this->form_validation->set_rules('intime', 'shiftschedule In Time', 'trim|required');
        $this->form_validation->set_rules('ltstart', 'shiftschedule Late Start', 'trim|required');
        $this->form_validation->set_rules('inend', 'shiftschedule In End', 'trim|required');
        $this->form_validation->set_rules('outstart', 'shiftschedule Out Start', 'trim|required');
        $this->form_validation->set_rules('outend', 'shiftschedule Out End', 'trim|required');
        $this->form_validation->set_rules('otstart', 'shiftschedule Ot Start', 'trim|required');
        $this->form_validation->set_rules('otminute', 'shiftschedule Ot Minute', 'trim|required');
        $this->form_validation->set_rules('onehrottime', 'shiftschedule One Hour Ot Time', 'trim|required');
        $this->form_validation->set_rules('twohrottime', 'shiftschedule Two Hour Ot Time', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['title'] = 'Shift Schedule Add';
            $this->data['allUnit'] = $this->Crud_model->getallUnit();
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/shiftschedule_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array();
            $formArray['unit_id'] = $this->input->post('uname');
            $formArray['sh_type'] = $this->input->post('stype');
            $formArray['in_start'] = $this->input->post('instrt');
            $formArray['in_time'] = $this->input->post('intime');
            $formArray['late_start'] = $this->input->post('ltstart');
            $formArray['in_end'] = $this->input->post('inend');
            $formArray['out_start'] = $this->input->post('outstart');
            $formArray['out_end'] = $this->input->post('outend');
            $formArray['ot_start'] = $this->input->post('otstart');
            $formArray['ot_minute_to_one_hour'] = $this->input->post('otminute');
            $formArray['one_hour_ot_out_time'] = $this->input->post('onehrottime');
            $formArray['two_hour_ot_out_time'] = $this->input->post('twohrottime');
            $formArray['lunch_start'] = $this->input->post('lunch_start');
            $formArray['lunch_minute'] = $this->input->post('lunch_minute');
            $formArray['tiffin_break'] = $this->input->post('tiffin_break');
            $formArray['tiffin_minute'] = $this->input->post('tiffin_minute');
            $formArray['tiffin_break2'] = $this->input->post('tiffin_break2');
            $formArray['tiffin_minute2'] = $this->input->post('tiffin_minute2');
            $formArray['random_minute'] = $this->input->post('random_minute');
            $formArray['of_day'] = json_encode($this->input->post('of_day'));

            $this->Crud_model->shiftschedule_add($formArray);
            $this->session->set_flashdata('success', 'Record add successfully!');
            redirect(base_url() . 'setup_con/shift_schedule');
        }
    }

    public function shiftschedule_edit($shiftscheduleId){
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $data['shiftschedule'] = $this->Crud_model->shiftschedule_fetch();

        $this->form_validation->set_rules('uname', 'shiftschedule Unit Name', 'trim|required');
        $this->form_validation->set_rules('stype', 'shiftschedule Shift Type', 'trim|required');
        $this->form_validation->set_rules('instrt', 'shiftschedule In Start', 'trim|required');
        $this->form_validation->set_rules('intime', 'shiftschedule In Time', 'trim|required');
        $this->form_validation->set_rules('ltstart', 'shiftschedule Late Start', 'trim|required');
        $this->form_validation->set_rules('inend', 'shiftschedule In End', 'trim|required');
        $this->form_validation->set_rules('outstart', 'shiftschedule Out Start', 'trim|required');
        $this->form_validation->set_rules('outend', 'shiftschedule Out End', 'trim|required');
        $this->form_validation->set_rules('otstart', 'shiftschedule Ot Start', 'trim|required');
        $this->form_validation->set_rules('otminute', 'shiftschedule Ot Minute', 'trim|required');
        $this->form_validation->set_rules('onehrottime', 'shiftschedule One Hour Ot Time', 'trim|required');
        $this->form_validation->set_rules('twohrottime', 'shiftschedule Two Hour Ot Time', 'trim|required');

        $data['shiftschedule'] = $this->Crud_model->shiftschedule_fetch();

        if ($this->form_validation->run() == false) {
            $this->data['allUnit'] = $this->Crud_model->getallUnit();

            $this->data['pr_emp_shift_schedule'] = $this->Crud_model->getshiftschedule($shiftscheduleId);
            $this->data['title'] = 'Shift Schedule Edit';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/shiftschedule_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $this->Crud_model->shiftschedule_edit($shiftscheduleId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');

            redirect('/setup_con/shift_schedule');

        }

    }

    public function shiftschedule_delete($shiftscheduleId)
    {
        $this->load->model('Crud_model');
        $shiftschedule = $this->Crud_model->getshiftschedule($shiftscheduleId);
        if (empty($shiftschedule)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/shift_schedule');
        }
        $this->Crud_model->shiftschedule_delete($shiftscheduleId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/shift_schedule');
    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Shift Schedules end
    //-------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Shift Management start
    //-------------------------------------------------------------------------------------------------------
    public function shift_management(){
        $this->db->select('pr_emp_shift.*,pr_units.unit_name,pr_emp_shift_schedule.sh_type');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_emp_shift.unit_id');
        $this->db->join('pr_emp_shift_schedule', 'pr_emp_shift_schedule.id = pr_emp_shift.schedule_id');
        if ($this->data['user_data']->unit_name!=0) {
            $this->db->where('pr_emp_shift.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['pr_emp_shift'] = $this->db->get('pr_emp_shift')->result_array();
        // dd($this->data['pr_emp_shift']);

        $this->data['title'] = 'Shift Management List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/shift_management_list';
        $this->load->view('layout/template', $this->data);
    }
    public function get_shift() {
        $unit_id = $this->input->post('unit_id');
        $this->db->where('unit_id', $unit_id);
        $query = $this->db->get('pr_emp_shift_schedule')->result();
        echo json_encode($query);
    }
    public function shiftmanagement_add(){
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $data['shiftmanagementinfo'] = $this->Crud_model->shiftmanagement_fetch();
        // dd($data);
        $this->form_validation->set_rules('shift_name', 'Shift Name', 'trim|required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('shift_type', 'Shift Type', 'required');
        if ($this->form_validation->run() == false) {
            $this->data['pr_units'] = $this->pr_units_get();
            $this->data['title'] = 'Shift Management Add';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/shiftmanagement_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'shift_name' => $this->input->post('shift_name'),
                'unit_id' => $this->input->post('unit_id'),
                'schedule_id' => $this->input->post('shift_type'),
            );
            if ($this->db->insert('pr_emp_shift', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/shift_management');
        }
    }

    public function shiftmanagement_edit($shiftmanagementId){
        // dd($shiftmanagementId);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('shift_name', 'Shift Name', 'trim|required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('shift_type', 'Shift Type', 'required');

        if ($this->form_validation->run() == false) {
            $this->db->select('pr_emp_shift.*,pr_units.unit_name,pr_emp_shift_schedule.sh_type');
            $this->db->join('pr_units', 'pr_units.unit_id = pr_emp_shift.unit_id','left');
            $this->db->join('pr_emp_shift_schedule', 'pr_emp_shift_schedule.id = pr_emp_shift.schedule_id','left');
            $this->db->where('pr_emp_shift.id', $shiftmanagementId);
            $this->data['pr_emp_shift'] = $this->db->get('pr_emp_shift')->row();
            // dd($this->data['pr_emp_shift']);
             $this->pr_units_get();

            $unit_id = $this->data['pr_emp_shift']->unit_id;
            $this->db->where('unit_id', $unit_id);
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->where('unit_id', $unit_id);
            $this->data['shift_type'] = $this->db->get('pr_emp_shift_schedule')->result();

            $this->data['title'] = 'Shift Management Edit';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/shiftmanagement_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'shift_name' => $this->input->post('shift_name'),
                'unit_id' => $this->input->post('unit_id'),
                'schedule_id' => $this->input->post('shift_type'),
            );
            $this->db->where('id', $shiftmanagementId);
            if ($this->db->update('pr_emp_shift', $formArray)) {
                $this->session->set_flashdata('success', 'Record updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record update failed!');
            }
            redirect(base_url() . 'setup_con/shift_management');
        }

    }

    public function shiftmanagement_delete($shiftmanagementId)
    {
        $this->load->model('Crud_model');
        $shiftmanagement = $this->Crud_model->getshiftmanagement($shiftmanagementId);
        if (empty($shiftmanagement)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/shift_management');
        }
        $this->Crud_model->shiftmanagement_delete($shiftmanagementId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/shift_management');
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Shift Management end
    //------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Alter net day start
    //-------------------------------------------------------------------------------------------------------
    public function alternet_day(){
        $this->db->select('attn_holyday_off.*, pr_units.unit_name, pr_emp_per_info.name_en as user_name');
        $this->db->from('attn_holyday_off');
        $this->db->join('pr_units', 'pr_units.unit_id = attn_holyday_off.unit_id');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = attn_holyday_off.emp_id');
        if ($this->data['user_data']->unit_name!=0) {
            $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        }
        $this->db->where('attn_holyday_off.duty_on_day !=', NULL);
        $this->data['results'] = $this->db->get()->result();

        $this->data['title'] = 'Alternet List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/alternet_day';
        $this->load->view('layout/template', $this->data);
    }

    public function alternet_add()
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

        $this->data['title'] = 'Alternet Add';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/alternet_add';
        $this->load->view('layout/template', $this->data);
    }

    public function alternet_add_ajax(){
        $on_day  = date('Y-m-d', strtotime($this->input->post('on_day')));
        $off_day = date('Y-m-d', strtotime($this->input->post('off_day')));
        $unit_id = $this->input->post('unit_id');
        $remark  = $this->input->post('remark');
        $sql     = $this->input->post('sql');
        $emp_ids = explode(',', $sql);

        $data = [];
        foreach ($emp_ids as $value) {
            $data[] = array(
                'emp_id'        =>$value,
                'unit_id'       =>$unit_id,
                'work_off_date' =>$off_day,
                'duty_on_day'   =>$on_day,
                'description'   =>$remark,
            );
        }
        if ( $this->db->insert_batch('attn_holyday_off', $data)) {
            echo 'success';
        }else{
            echo 'error';
        }
    }

    public function emp_holiday_del($id){
        $this->db->where('id', $id);
        $this->db->delete('attn_holyday_off');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url('setup_con/alternet_day'));
    }

    public function holiday_delete_all(){
        $date = date('Y-m-d', strtotime($this->input->post('off_day')));
        $unit_id = $this->input->post('unit_id');
        $sql = $this->input->post('sql');
        $emp_ids = explode(',', $sql);

        $this->db->where('work_off_date ', $date)->where('unit_id ', $unit_id);
        if ( $this->db->where_in('emp_id', $emp_ids)->delete('attn_holyday_off') ) {
            echo 'success';
        }else{
            echo 'error';
        }
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
        $this->db->join('emp_designation as deg', 'deg.id = pr_emp_com_info.emp_desi_id', 'left');
        $this->db->where('deg.hide_status', 1);
        $this->db->where('pr_units.unit_id', $unit);
        $this->db->where('pr_emp_com_info.emp_cat_id', 1);
        return $this->db->get();
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for alter net day end
    //------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Company Info Setup
    //-------------------------------------------------------------------------------------------------------

    public function company_info_setup()
    {
        $company_infos = $this->Common_model->company_information($this->data['user_data']->unit_name);
        $this->data['company_infos'] = $company_infos;
        $this->data['title'] = 'Company Info';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/company_info';
        $this->load->view('layout/template', $this->data);
    }
    public function company_add()
    {
        // dd( $this->data['user_data']);
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->form_validation->set_rules('name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('en_add', 'Company Address English ', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['title'] = 'Company Add';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['unit_id'] = $this->data['user_data']->unit_name;
            $this->data['subview'] = 'setup/company_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array();
            $formArray['name'] = $this->input->post('name');
            $formArray['bname'] = $this->input->post('bname');
            $formArray['en_add'] = $this->input->post('en_add');
            $formArray['bn_add'] = $this->input->post('bn_add');
            $formArray['phn'] = $this->input->post('phn');
            $formArray['unit_id'] = $this->input->post('unit_id');
            $formArray['comlogo'] = $this->input->post('comlogo');
            $formArray['comsign'] = $this->input->post('comsign');
            $this->Crud_model->company_add($formArray);
            $this->session->set_flashdata('success', 'Record add successfully!');
            redirect(base_url() . 'setup_con/company_info_setup');
        }

    }

    public function company_edit($comId)
    {
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('bname', 'Company Bangla Name', 'trim|required');
        $this->form_validation->set_rules('en_add', 'Company Address English ', 'trim|required');
        $this->form_validation->set_rules('bn_add', 'Company Address Bangla', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['company_infos'] = $this->Crud_model->getUnit($comId);
            $this->data['title'] = 'Company Info';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/company_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $this->Crud_model->company_edit($comId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');
            redirect('/setup_con/company_info_setup');
        }
    }

    public function company_delete($comId)
    {
        $this->load->model('Crud_model');
        $company = $this->Crud_model->getUnit($comId);
        if (empty($company)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/company_info_setup');
        }
        $this->Crud_model->company_delete($comId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/company_info_setup');
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Company Info Setup end
    //-------------------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Leave Setup start
    //-------------------------------------------------------------------------------------------------------

    public function leave_setup()
    {
        $this->db->select('pr_leave.*,pr_units.unit_name');
        $this->db->from('pr_leave');
        $this->db->join('pr_units','pr_units.unit_id = pr_leave.unit_id');
        if ($this->data['user_data']->unit_name!=0) {
            $this->db->where('pr_leave.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['pr_leave'] = $this->db->get()->result_array();
        $this->data['title'] = 'Leave Setup';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/leave_list';
        $this->load->view('layout/template', $this->data);
    }

    public function leave_add()
    {
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('leave_name', 'Leave_name', 'required');
        $this->form_validation->set_rules('sick_leave', 'Sick Leave', 'required');
        $this->form_validation->set_rules('casual_leave', 'Casual Leave', 'required');
        $this->form_validation->set_rules('maternity_leave', 'Maternity Leave', 'required');
        $this->form_validation->set_rules('paternity_leave', 'Paternity Leave', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->data['pr_units'] = $this->pr_units_get();
            $this->data['title'] = 'Leave Add';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/leave_add';
            $this->load->view('layout/template', $this->data);
        } else {


            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'lv_name' => $this->input->post('leave_name'),
                'lv_sl' => $this->input->post('sick_leave'),
                'lv_cl' => $this->input->post('casual_leave'),
                'lv_ml' => $this->input->post('maternity_leave'),
                'lv_pl' => $this->input->post('special_leave'),
            );
            if ($this->db->insert('pr_leave', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/leave_setup');
        }
    }

    public function leave_edit($shiftmanagementId)
    {

        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('leave_name', 'Leave_name', 'required');
        $this->form_validation->set_rules('sick_leave', 'Sick Leave', 'required');
        $this->form_validation->set_rules('casual_leave', 'Casual Leave', 'required');
        $this->form_validation->set_rules('maternity_leave', 'Maternity Leave', 'required');
        $this->form_validation->set_rules('special_leave', 'Special Leave', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            $this->db->select('pr_units.*');
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->select('pr_leave.*');
            $this->db->where('lv_id', $shiftmanagementId);
            $this->data['pr_leave'] = $this->db->get('pr_leave')->row();

            $this->data['title'] = 'Leave Edit';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/leave_edit';
            $this->load->view('layout/template', $this->data);
        } else {


            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'lv_name' => $this->input->post('leave_name'),
                'lv_sl' => $this->input->post('sick_leave'),
                'lv_cl' => $this->input->post('casual_leave'),
                'lv_ml' => $this->input->post('maternity_leave'),
                'lv_pl' => $this->input->post('special_leave'),
            );
            $this->db->where('lv_id', $shiftmanagementId);
            if ($this->db->update('pr_leave', $formArray)) {
                $this->session->set_flashdata('success', 'Record updated successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update failed!');
            }
            redirect(base_url() . 'setup_con/leave_setup');
        }

    }

    public function leave_delete($shiftmanagementId)
    {
        $this->Crud_model->shiftmanagement_delete($shiftmanagementId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/leave_setup');
    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Leave Setup end
    //-------------------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Bonus Setup start
    //-------------------------------------------------------------------------------------------------------
    public function bonus_setup()
    {
        $this->db->select('pr_bonus_rules.*,pr_units.unit_name');
        $this->db->from('pr_bonus_rules');
        $this->db->join('pr_units','pr_units.unit_id = pr_bonus_rules.unit_id');
        if($this->data['user_data']->unit_name!=0){
            $this->db->where('pr_bonus_rules.unit_id', $this->data['user_data']->unit_name);
        }
        $this->db->order_by('id', 'DESC');
        $this->data['pr_bonus_rules'] = $this->db->get()->result_array();
        $this->data['title'] = 'Bonus Setup';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/bonus_list';
        $this->load->view('layout/template', $this->data);

    }
    public function bonus_add()
    {
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('emp_type', 'Employee Type', 'required');
        $this->form_validation->set_rules('festival', 'Festival', 'required');
        $this->form_validation->set_rules('bonus_first_month', 'Bonus First Month', 'required');
        // $this->form_validation->set_rules('bonus_second_month', 'Bonus Second Month', 'required');
        $this->form_validation->set_rules('bonus_amount', 'Bonus Amount', 'required');
        // $this->form_validation->set_rules('bonus_amount_fraction', 'Bonus Amount Fraction', 'required');
        $this->form_validation->set_rules('bonus_percent', 'Bonus Percent', 'required');
        $this->form_validation->set_rules('effective_date', 'Effective Date', 'required');
        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            $this->data['pr_units'] = $this->pr_units_get();
            $this->data['title'] = 'Bonus Add';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/bonus_add';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'emp_type' => $this->input->post('emp_type'),
                'religion_id' => $this->input->post('religion_id'),
                'festival' => $this->input->post('festival'),
                'bonus_first_month' => $this->input->post('bonus_first_month'),
                'bonus_second_month' => $this->input->post('bonus_second_month'),
                'bonus_amount' => $this->input->post('bonus_amount'),
                // 'bonus_amount_fraction' => $this->input->post('bonus_amount_fraction'),
                'bonus_percent' => $this->input->post('bonus_percent'),
                'effective_date' => date('Y-m-d', strtotime($this->input->post('effective_date'))),
            );
            if ($this->db->insert('pr_bonus_rules', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/bonus_setup');
        }
    }
    public function bonus_edit($bonus_id)
    {
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('emp_type', 'Employee Type', 'required');
        $this->form_validation->set_rules('festival', 'Festival', 'required');
        $this->form_validation->set_rules('bonus_first_month', 'Bonus First Month', 'required');
        // $this->form_validation->set_rules('bonus_second_month', 'Bonus Second Month', 'required');
        $this->form_validation->set_rules('bonus_amount', 'Bonus Amount', 'required');
        // $this->form_validation->set_rules('bonus_amount_fraction', 'Bonus Amount Fraction', 'required');
        $this->form_validation->set_rules('bonus_percent', 'Bonus Percent', 'required');
        $this->form_validation->set_rules('effective_date', 'Effective Date', 'required');

        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            $this->db->select('pr_units.*');
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->select('pr_bonus_rules.*');
            $this->db->where('id', $bonus_id);
            $this->data['row'] = $this->db->get('pr_bonus_rules')->row();
            // dd($this->data['row']);
            $this->data['title'] = 'Bonus Edit';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/bonus_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $formArray = array(
                'unit_id' => $this->input->post('unit_id'),
                'emp_type' => $this->input->post('emp_type'),
                'religion_id' => $this->input->post('religion_id'),
                'festival' => $this->input->post('festival'),
                'bonus_first_month' => $this->input->post('bonus_first_month'),
                'bonus_second_month' => $this->input->post('bonus_second_month'),
                'bonus_amount' => $this->input->post('bonus_amount'),
                // 'bonus_amount_fraction' => $this->input->post('bonus_amount_fraction'),
                'bonus_percent' => $this->input->post('bonus_percent'),
                'effective_date' => date('Y-m-d', strtotime($this->input->post('effective_date')))
            );

            $this->db->where('id', $bonus_id);
            if ($this->db->update('pr_bonus_rules', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/bonus_setup');
        }

    }
    public function bonus_delete($shiftmanagementId)
    {
    $this->db->where('id', $shiftmanagementId);
    if ($this->db->delete('pr_bonus_rules')) {
        $this->session->set_flashdata('success', 'Record Deleted successfully!');

    }else{
        $this->session->set_flashdata('failure', 'Record Delete failed!');
    };
        redirect('/setup_con/bonus_setup');
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Bonus Setup start
    //-------------------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Roster schedule Setup start
    //-------------------------------------------------------------------------------------------------------
    public function emp_roster_shift() {
        $this->db->select('rs.*, pr_units.unit_name');
        $this->db->from('pr_emp_roster_shift as rs');
        $this->db->join('pr_units', 'pr_units.unit_id = rs.unit_id', 'left');
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        }
        $this->db->order_by('rs.id', 'DESC');
        $this->data['results'] = $this->db->get()->result();
        $this->data['title'] = 'Roster Shift List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'setup/emp_roster_list';
        $this->load->view('layout/template', $this->data);
    }
    public function roster_entry() {
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        if ($this->form_validation->run() == false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }
            // dd($this->data['user_data']);
            $this->db->select('pr_units.*');
            $this->db->where('unit_id', $this->data['user_data']->unit_name);
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->select('pr_emp_shift.*');
            $this->db->where('unit_id', $this->data['user_data']->unit_name);
            $this->data['pr_emp_shift'] = $this->db->get('pr_emp_shift')->result();
            $this->data['title'] = 'Roster Shift Add';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/emp_roster_entry';
            $this->load->view('layout/template', $this->data);
        } else {
            $shift_type[]=$this->input->post('shift_type');
            $formArray = array(
                'name' => $this->input->post('name'),
                'unit_id' => $this->input->post('unit_id'),
                'start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
                'duration' => $this->input->post('duration'),
                'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
                'shift_type' =>  json_encode($shift_type),
            );
            if ($this->db->insert('pr_emp_roster_shift', $formArray)) {
                $this->session->set_flashdata('success', 'Record add successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record add failed!');
            }
            redirect(base_url() . 'setup_con/emp_roster_shift');
        }
    }
    public function roster_edit($id) {
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        if ($this->form_validation->run() == false) {

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->session->set_flashdata('failure', $this->form_validation->error_array());
            }

            $this->db->select('pr_units.*');
            $this->db->where('unit_id', $this->data['user_data']->unit_name);
            $this->data['pr_units'] = $this->db->get('pr_units')->result();

            $this->db->select('pr_emp_roster_shift.*');
            $this->db->where('id', $id);
            $this->data['roster_shift'] = $this->db->get('pr_emp_roster_shift')->row();

            $this->db->select('pr_emp_shift.*');
            $this->db->where('unit_id', $this->data['user_data']->unit_name);
            $this->data['pr_emp_shift'] = $this->db->get('pr_emp_shift')->result();

            $this->data['title'] = 'Roster Shift Edit';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'setup/emp_roster_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $shift_type[]=$this->input->post('shift_type');
            $formArray = array(
                'name' => $this->input->post('name'),
                'unit_id' => $this->input->post('unit_id'),
                'start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
                'duration' => $this->input->post('duration'),
                'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
                'shift_type' =>  json_encode($shift_type),
            );
            $this->db->where('id', $id);
            if ($this->db->update('pr_emp_roster_shift', $formArray)) {
                $this->session->set_flashdata('success', 'Record Update successfully!');
            } else {
                $this->session->set_flashdata('failure', 'Record Update  failed!');
            }
            redirect(base_url() . 'setup_con/emp_roster_shift');
        }
    }
    public function rester_delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('pr_emp_roster_shift')) {
            $this->session->set_flashdata('success', 'Record Deleted successfully!');
        } else {
            $this->session->set_flashdata('failure', 'Record Delete failed!');
        }
        redirect(base_url() . 'setup_con/emp_roster_shift');
    }
    public function roster_schedule_change() {
        $id = $this->input->post('id');
        $row = $this->db->where('id', $id)->get('pr_emp_roster_shift')->row();
        $unit_id = $row->unit_id;
        $dd = json_decode($row->shift_type);
        $shift_type = $dd[0];

        // automatecally change employee shift
        if (count($shift_type) == 3) {
            $morning_shift = $shift_type[0];
            $evening_shift = $shift_type[1];
            $night_shift   = $shift_type[2];

            // get shift id wise employee in array
            $morning = $this->get_roster_shift_emp($morning_shift, $unit_id);
            $evening = $this->get_roster_shift_emp($evening_shift, $unit_id);
            $night   = $this->get_roster_shift_emp($night_shift, $unit_id);

            if (!empty($morning)) {
                $tr = $this->auto_change_roster_shift($morning, $night_shift, $unit_id);
            }
            if (!empty($evening)) {
                $tr = $this->auto_change_roster_shift($evening, $morning_shift, $unit_id);
            }
            if (!empty($night)) {
                $tr = $this->auto_change_roster_shift($night, $evening_shift, $unit_id);
            }

        } else if (count($shift_type) == 2) {
            $day_shift 	 = $shift_type[0];
            $night_shift = $shift_type[1];
            $days 	= $this->get_roster_shift_emp($day_shift, $unit_id);
            $night  = $this->get_roster_shift_emp($night_shift, $unit_id);

            if (!empty($days)) {
                $tr = $this->auto_change_roster_shift($days, $night_shift, $unit_id);
            }

            if (!empty($night)) {
                $tr = $this->auto_change_roster_shift($night, $day_shift, $unit_id);
            }
        }
        // end auto employee shift change
        if ($tr) {
            echo 'Record successfully Inserted';
            exit();
        } else {
            echo 'Record Not Inserted';
            exit();
        }
    }
	function auto_change_roster_shift($emp_array, $emp_shift, $unit_id)
	{
		$data = array(
			'emp_shift' => $emp_shift
		);

		$this->db->where_in('emp_id', $emp_array)->where('unit_id', $unit_id)->update('pr_emp_com_info', $data);
		return true;
	}
	function get_roster_shift_emp($emp_shift, $unit_id)
	{
		$rs=$this->db->select('emp_id')->where('emp_shift',$emp_shift)->where('unit_id',$unit_id)->get('pr_emp_com_info');
		$result = $rs->result_array();
		$output = array();

		array_walk($result, function($entry) use (&$output) {
		    $output[] = $entry["emp_id"];
		});
		return $output;
	}
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Roster schedule Setup start
    //-------------------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------------------
// CRUD for Bonus Setup end
//-------------------------------------------------------------------------------------------------------

    // old code

    //-------------------------------------------------------------------------------------------------------
    // Company info Setup
    //-------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD output method
    //-------------------------------------------------------------------------------------------------------
    public function crud_output($output = null)
    {
        $this->load->view('output.php', $output);
    }

    public function dashboard_date_setup()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('dash_board_date');
        $crud->set_subject('Date');
        $crud->required_fields('date');

        /*$crud->set_theme('twitter-bootstrap');
        $crud->unset_search();*/
        $crud->unset_delete();
        $crud->unset_add();
        $output = $crud->render();
        $this->load->view('dash_board_date.php', $output);
        $this->crud_output($output);

    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Section
    //-------------------------------------------------------------------------------------------------------

    public function sec_name_check($str)
    {
        $id = $this->uri->segment(4);
        $unit_id = $_POST['unit_id'];
        if (!empty($id) && is_numeric($id)) {
            $sec_name_old = $this->db->where("sec_id", $id)->get('emp_section')->row()->sec_name;
            $this->db->where("sec_name !=", $sec_name_old);
        }
        $num_row = $this->db->where('sec_name', $str)->where('unit_id', $unit_id)->get('emp_section')->num_rows();
        if ($num_row >= 1) {
            $this->form_validation->set_message('sec_name_check', $str . ' already exists');
            return false;
        } else {
            return true;
        }
    }

    public function floor_name_check($str)
    {
        $unit_id = $_POST['unit_id'];
        $id = $this->uri->segment(4);
        if (!empty($id) && is_numeric($id)) {
            $line_name_old = $this->db->where("floor_name", $id)->get('pr_floor')->row()->line_name;
            $this->db->where("floor_name !=", $line_namee_old);
        }
        $num_row = $this->db->where('floor_name', $str)->where('unit_id', $unit_id)->get('pr_floor')->num_rows();
        if ($num_row >= 1) {
            $this->form_validation->set_message('floor_name_check', $str . ' already exists');
            return false;
        } else {
            return true;
        }
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Line
    //-------------------------------------------------------------------------------------------------------

    public function line_name_check($str)
    {
        $unit_id = $_POST['unit_id'];
        $id = $this->uri->segment(4);
        if (!empty($id) && is_numeric($id)) {
            $line_name_old = $this->db->where("line_id", $id)->get('pr_line_num')->row()->line_name;
            $this->db->where("line_name !=", $line_namee_old);
        }
        $num_row = $this->db->where('line_name', $str)->where('unit_id', $unit_id)->get('pr_line_num')->num_rows();
        if ($num_row >= 1) {
            $this->form_validation->set_message('line_name_check', $str . ' already exists');
            return false;
        } else {
            return true;
        }
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Designation
    //-------------------------------------------------------------------------------------------------------

    public function desig_name_check($str)
    {
        $unit_id = $_POST['unit_id'];
        $id = $this->uri->segment(4);
        if (!empty($id) && is_numeric($id)) {
            $desig_name_old = $this->db->where("desig_id", $id)->get('pr_designation')->row()->desig_name;
            $this->db->where("desig_name !=", $desig_name_old);
        }
        $num_row = $this->db->where('desig_name', $str)->where('unit_id', $unit_id)->get('pr_designation')->num_rows();
        if ($num_row >= 1) {
            $this->form_validation->set_message('desig_name_check', $str . ' already exists');
            return false;
        } else {
            return true;
        }
    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Operation
    //-------------------------------------------------------------------------------------------------------
    public function operation()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('pr_emp_operation');
        $crud->set_subject('Weight');
        $crud->display_as('ope_name', 'Weight');
        $crud->required_fields('ope_name');
        $crud->unset_delete();

        $output = $crud->render();

        $this->crud_output($output);
    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Job Description Setup
    //-------------------------------------------------------------------------------------------------------
    public function job_desc()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('pr_emp_job_desc');
        $crud->set_subject('Job Description');

        $crud->set_relation('emp_desig_id', 'pr_designation', 'desig_name');

        $crud->required_fields('emp_desig_id', 'description');
        $crud->display_as('description', 'Job Description')
            ->display_as('emp_desig_id', 'Designation');

        //$crud->unset_add();
        //$crud->unset_edit();
        //$crud->unset_delete();

        //$crud->set_rules('emp_desig_id','Designation','trim|required|callback_designation_check');
        $output = $crud->render();
        $this->crud_output($output);
    }

    public function nid_wk_typ()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('pr_emp_nid_wk_typ');
        $crud->set_subject('N.Id & Work Type');

        //$crud->set_relation( 'emp_id' , 'pr_emp_com_info','emp_id' );

        $crud->display_as('n_id', 'National Id')->display_as('wk_type', 'Work Type');

        //$crud->unset_edit_fields('emp_id');
        //$crud->field_type('emp_id', 'readonly');
        $crud->unset_delete();

        $output = $crud->render();
        $this->crud_output($output);
    }
    public function work_process_type()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('pr_work_process');
        $crud->set_subject('Process Type');

        //$crud->set_relation( 'emp_id' , 'pr_emp_com_info','emp_id' );

        $crud->display_as('id', 'Id')->display_as('process', 'Work Process Name');

        $output = $crud->render();
        $this->crud_output($output);
    }


    //-------------------------------------------------------------------------------------------------------
    // CRUD for Attendance Bonus
    //-------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Salary Grade
    //-------------------------------------------------------------------------------------------------------
    public function salary_grade()
    {
        $this->data['title'] = 'Salary Grade Setup';
        $this->data['salary_grade'] = $this->db->get('pr_grade')->result_array();
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'salgrd_list';
        $this->load->view('layout/template', $this->data);

    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Leave Setup
    //-------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Deduction Setup
    //-------------------------------------------------------------------------------------------------------
    public function attributes_setup()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('pr_setup');
        $crud->set_subject('Attributes');
        $crud->unset_delete();
        $crud->unset_add();
        $crud->change_field_type('attributes', 'readonly');
        $output = $crud->render();
        $this->crud_output($output);
    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Night Allowance Setup
    //-------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Holiday Allowance Setup
    //-------------------------------------------------------------------------------------------------------
    public function holiday_allowance_setup($start = 0)
    {

        $this->load->library('pagination');
        $param = array();
        $limit = 10;
        $config['base_url'] = base_url() . "setup_con/holiday_allowance_setup/";
        $config['per_page'] = $limit;
        $this->load->model('Crud_model');
        $attn_holiday_allowance_rules = $this->Crud_model->holidayallowence_infos($limit, $start);
        $total = $this->db->query("SELECT FOUND_ROWS() as count")->row()->count;
        $config['total_rows'] = $total;
        $config["uri_segment"] = 3;
        // $this->load->library('pagination');

        $this->pagination->initialize($config);
        $param['links'] = $this->pagination->create_links();

        $param['attn_holiday_allowance_rules'] = $attn_holiday_allowance_rules;

        $this->load->view('holiday_allowance_list', $param);

    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Weekend Allowance Setup
    //-------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Allowance Setup
    //-------------------------------------------------------------------------------------------------------
    public function tiffin_allowance_setup()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('pr_tiffin_allowance_rules');
        $crud->set_subject('Tiffin Allowance Rules');
        $crud->required_fields('rule_name', 'allowance_amount', 'allowance_time');
        $crud->display_as('rule_name', 'Rules Name')
            ->display_as('allowance_amount', 'Amount')
            ->display_as('allowance_time', 'Time');

        //$crud->unset_delete();
        $crud->set_relation_n_n('Section', 'pr_tiffin_allowance_level', 'emp_section', 'rules_id', 'sec_id', 'sec_name', 'priority');
        //$crud->unset_add();
        //$crud->change_field_type('emp_category','readonly');
        $output = $crud->render();
        $this->crud_output($output);
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Festival Bonus Setup
    //-------------------------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Providend Fund Setup
    //-------------------------------------------------------------------------------------------------------
    public function pf_setup()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('pr_provident_fund_rules');
        $crud->set_subject('Provident Fund Rules');
        $crud->required_fields('pf_start_month', 'pf_end_month', 'pf_percentage', 'pf_deduct_percentage', 'salay_type');
        //$crud->display_as( 'bonus_amount_fraction' , 'Bonus Fraction' );
        $crud->unset_delete();
        //$crud->unset_add();
        //$crud->change_field_type('attributes','readonly');
        $output = $crud->render();
        $this->crud_output($output);
    }

    //-------------------------------------------------------------------------------------------------------
    // CRUD for Units
    //-------------------------------------------------------------------------------------------------------
    public function unit()
    {
        // $crud = new grocery_CRUD();

        // $crud->set_table('pr_units');
        // $crud->set_subject('Unit');
        // $crud->display_as( 'unit_name' , 'Unit Name' );
        // $crud->required_fields( 'unit_name');
        // $crud->unset_delete();
        // $crud->set_field_upload('logo','images/');
        // $crud->set_field_upload('unit_signature','images/');
        // $output = $crud->render();

        // $this->crud_output($output);

        $this->load->model('Common_model');
        $company_infos = $this->Common_model->company_information();
        $data = array();
        $data['company_infos'] = $company_infos;
        $this->load->view('output2', $data);
    }

    public function night_rules()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('pr_night_rules');
        $crud->set_subject('Night_rules');
        $crud->set_relation('unit_id', 'pr_units', 'unit_name');
        $crud->display_as('unit_id', 'Unit Name')->display_as('deduct_hour', 'Deduct Hour');
        $crud->required_fields('unit_id', 'deduct_hour');
        $crud->unset_delete();
        $output = $crud->render();

        $this->crud_output($output);
    }

    public function attn_summary_setup()
    {

        $crud = new grocery_CRUD();
        $get_session_user_unit = $this->Common_model->get_session_unit_id_name();
        if ($get_session_user_unit != 0) {
            $crud->where('pr_attn_summary_list.unit_id', $get_session_user_unit);
        }
        $crud->set_table('pr_attn_summary_list');
        $crud->set_subject('Attendance Summary');

        if ($get_session_user_unit != 0) {
            $crud->set_relation('unit_id', 'pr_units', 'unit_name', array('unit_id' => $get_session_user_unit));
        } else {
            $crud->set_relation('unit_id', 'pr_units', 'unit_name');
        }
        $where = "desig_id==2";
        $crud->set_relation_n_n('AttnSummary', 'pr_attn_summary_level', 'pr_designation', 'group_id', 'desig_id', 'desig_name', 'priority', array('pr_designation.desig_id' == 2), null);

        $output = $crud->render();
        $this->crud_output($output);
    }



}

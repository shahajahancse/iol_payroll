<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penalty_con extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Authentication check
        if ($this->session->userdata('logged_in') == false) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')
                             ->set_status_header(401)
                             ->set_output(json_encode(array('status' => false, 'message' => 'Session expired. Please login again.')));
                return;
            }
            redirect("authentication");
        }

        $this->load->model('Penalty_model');
        $this->load->helper('url');
        $this->load->helper('form');

        $this->data['user_data'] = $this->session->userdata('data');
        $this->data['username']  = !empty($this->data['user_data']->id_number) ? $this->data['user_data']->id_number : 'admin';
        $this->data['page_bg']   = '#ffffff';
    }

    private function get_scoped_unit_id()
    {
        $user = $this->data['user_data'];
        if ($user && isset($user->level) && $user->level === 'All') {
            return null;
        }
        return ($user && !empty($user->unit_name)) ? $user->unit_name : null;
    }

    public function index()
    {
        $unit_id = $this->get_scoped_unit_id();

        $this->data['title']       = 'Penalty Management';
        $this->data['unit_id']     = $unit_id;
        $this->data['summary']     = $this->Penalty_model->get_dashboard_summary($unit_id);
        $this->data['departments'] = $this->db->order_by('dept_name', 'ASC')->get('emp_depertment')->result();
        $this->data['units']       = $this->db->get('pr_units')->result();

        $this->data['subview'] = 'penalty/index';
        $this->load->view('layout/template', $this->data);
    }

    public function list_ajax()
    {
        $limit  = $this->input->get_post('limit') ? (int)$this->input->get_post('limit') : 20;
        $page   = $this->input->get_post('page') ? (int)$this->input->get_post('page') : 1;
        $offset = ($page - 1) * $limit;

        $filters = array(
            'search'       => trim((string)$this->input->get_post('search')),
            'dept_id'      => $this->input->get_post('dept_id'),
            'salary_month' => $this->input->get_post('salary_month'),
            'status'       => $this->input->get_post('status'),
            'unit_id'      => $this->input->get_post('unit_id') ? $this->input->get_post('unit_id') : $this->get_scoped_unit_id(),
            'sort_col'     => $this->input->get_post('sort_col'),
            'sort_dir'     => $this->input->get_post('sort_dir'),
        );

        $total_rows = $this->Penalty_model->count_palantys($filters);
        $records    = $this->Penalty_model->get_palantys($filters, $limit, $offset);
        $summary    = $this->Penalty_model->get_dashboard_summary($filters['unit_id']);

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'     => 'success',
            'records'    => $records,
            'total_rows' => $total_rows,
            'page'       => $page,
            'limit'      => $limit,
            'total_pages'=> ceil($total_rows / $limit),
            'summary'    => $summary,
        )));
    }

    public function get_details_ajax($id)
    {
        $id = (int)$id;
        $record = $this->Penalty_model->get_by_id($id);
        if (!$record) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => false, 'message' => 'Record not found.')));
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => true, 'record' => $record)));
    }

    public function employee_search_ajax()
    {
        $q = trim((string)$this->input->get_post('query'));
        $unit_id = $this->input->get_post('unit_id') ? (int)$this->input->get_post('unit_id') : $this->get_scoped_unit_id();
        if (strlen($q) < 1) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array()));
        }
        $employees = $this->Penalty_model->search_employees($q, $unit_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($employees));
    }

    public function get_employee_ajax()
    {
        $emp_id = trim((string)$this->input->get_post('emp_id'));
        $emp = $this->Penalty_model->get_employee_details($emp_id);
        if (!$emp) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => false, 'message' => 'Employee not found.')));
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => true, 'employee' => $emp)));
    }

    public function save()
    {
        $id           = $this->input->post('id') ? (int)$this->input->post('id') : null;
        $emp_id       = trim((string)$this->input->post('emp_id'));
        $amount       = (float)$this->input->post('amount');
        $salary_month = trim((string)$this->input->post('salary_month'));
        $remarks      = trim((string)$this->input->post('remarks'));
        $status       = trim((string)$this->input->post('status'));
        if (empty($status)) {
            $status = 'Approved';
        }

        if (empty($emp_id) || empty($salary_month) || $amount <= 0) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Please enter valid Employee ID, Salary Month, and Amount (> 0).'
            )));
        }

        $emp = $this->Penalty_model->get_employee_details($emp_id);
        if (!$emp) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Employee not found.'
            )));
        }

        $clean_month = date('Y-m', strtotime($salary_month . '-01'));

        $data = array(
            'unit_id'      => !empty($emp->unit_id) ? $emp->unit_id : 1,
            'emp_id'       => $emp_id,
            'salary_month' => $clean_month,
            'amount'       => $amount,
            'remarks'      => $remarks,
            'status'       => $status,
            'updated_at'   => date('Y-m-d H:i:s'),
        );

        if ($id) {
            $this->db->where('id', $id)->update('emp_penaltys', $data);
            $msg = 'Penalty updated successfully.';
        } else {
            $data['created_by'] = $this->data['username'];
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('emp_penaltys', $data);
            $id = $this->db->insert_id();
            $msg = 'Penalty created successfully.';
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => true,
            'message' => $msg,
            'id'      => $id
        )));
    }

    public function cancel($id)
    {
        $id = (int)$id;
        $this->db->where('id', $id)->update('emp_penaltys', array(
            'status'     => 'Cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        ));
        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => true,
            'message' => 'Penalty cancelled successfully.'
        )));
    }

    public function delete($id)
    {
        $id = (int)$id;
        $this->db->where('id', $id)->delete('emp_penaltys');
        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => true,
            'message' => 'Penalty record deleted successfully.'
        )));
    }

    public function penalty_sheet()
    {
        $salary_month = $this->input->get_post('salary_month') ? $this->input->get_post('salary_month') : date('Y-m');
        $clean_month  = date('Y-m', strtotime($salary_month . '-01'));
        $unit_id      = $this->input->get_post('unit_id') ? (int)$this->input->get_post('unit_id') : 1;

        $filters = array(
            'salary_month' => $clean_month,
            'unit_id'      => $unit_id,
            'status'       => 'Approved',
        );

        $this->data['salary_month'] = $clean_month;
        $this->data['unit_id']      = $unit_id;
        $this->data['records']      = $this->Penalty_model->get_palantys($filters, 0, 0);

        $this->data['unit'] = $this->db->where('unit_id', $unit_id)->get('pr_units')->row();

        $this->load->view('penalty/penalty_sheet', $this->data);
    }
}

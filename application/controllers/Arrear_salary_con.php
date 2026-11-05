<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arrear_salary_con extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Authentication check
        if ($this->session->userdata('logged_in') == false) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => false, 'message' => 'Session expired. Please login again.'));
                exit;
            }
            redirect("authentication");
        }

        $this->load->model('Arrear_salary_model');
        $this->data['user_data'] = $this->session->userdata('data');
        $this->data['username']  = !empty($this->data['user_data']->id_number) ? $this->data['user_data']->id_number : 'admin';
        $this->data['page_bg']   = '#ffffff';
    }

    /**
     * Arrear Salary Single-Page Management Hub
     */
    public function index()
    {
        // Capture filters from GET / POST
        $filters = array(
            'search'        => trim((string)$this->input->get('search')),
            'arrear_month'  => trim((string)$this->input->get('arrear_month')),
            'payment_month' => trim((string)$this->input->get('payment_month')),
            'status'        => trim((string)$this->input->get('status')),
            'unit_id'       => trim((string)$this->input->get('unit_id')),
            'dept_id'       => trim((string)$this->input->get('dept_id')),
        );

        // Pagination setup
        $this->load->library('pagination');
        $total_rows = $this->Arrear_salary_model->count_arrears($filters);

        $per_page = 50;
        $page = ($this->input->get('page')) ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;

        $config['base_url']             = base_url('arrear_salary/index');
        $config['total_rows']           = $total_rows;
        $config['per_page']             = $per_page;
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string']   = TRUE;
        $config['full_tag_open']        = '<ul class="pagination pagination-sm" style="margin:0;">';
        $config['full_tag_close']       = '</ul>';
        $config['first_link']           = '&laquo; First';
        $config['first_tag_open']       = '<li>';
        $config['first_tag_close']      = '</li>';
        $config['last_link']            = 'Last &raquo;';
        $config['last_tag_open']        = '<li>';
        $config['last_tag_close']       = '</li>';
        $config['next_link']            = '&rsaquo;';
        $config['next_tag_open']        = '<li>';
        $config['next_tag_close']       = '</li>';
        $config['prev_link']            = '&lsaquo;';
        $config['prev_tag_open']        = '<li>';
        $config['prev_tag_close']       = '</li>';
        $config['cur_tag_open']         = '<li class="active"><a href="javascript:;">';
        $config['cur_tag_close']        = '</a></li>';
        $config['num_tag_open']         = '<li>';
        $config['num_tag_close']        = '</li>';

        $this->pagination->initialize($config);

        $active_tab = $this->input->get('tab');
        if (empty($active_tab) || !in_array($active_tab, array('list', 'entry'))) {
            $active_tab = 'list';
        }

        $is_edit  = false;
        $arrear   = null;
        $employee = null;

        $edit_id = (int)$this->input->get('edit_id');
        if ($edit_id > 0) {
            $arrear = $this->Arrear_salary_model->get_arrear_by_id($edit_id);
            if ($arrear) {
                $is_edit    = true;
                $active_tab = 'entry';
                $employee   = $this->Arrear_salary_model->get_employee_details($arrear->emp_id);
            }
        }

        $this->data['arrears']       = $this->Arrear_salary_model->get_arrears($filters, $per_page, $offset);
        $this->data['stats']         = $this->Arrear_salary_model->get_summary_stats($filters);
        $this->data['filters']       = $filters;
        $this->data['total_rows']    = $total_rows;
        $this->data['pagination']    = $this->pagination->create_links();
        $this->data['units']         = $this->db->get('pr_units')->result();
        $this->data['departments']   = $this->db->get('emp_depertment')->result();
        $this->data['active_tab']    = $active_tab;
        $this->data['is_edit']       = $is_edit;
        $this->data['arrear']        = $arrear;
        $this->data['employee']      = $employee;

        $this->data['title']   = 'Arrear Salary Management';
        $this->data['subview'] = 'arrear_salary/list';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * Create New Arrear Entry Form (Redirects to Single Page Hub with entry tab)
     */
    public function create()
    {
        redirect('arrear_salary?tab=entry');
    }

    /**
     * Edit Arrear Entry Form (Redirects to Single Page Hub with entry tab and edit ID)
     */
    public function edit($id)
    {
        $id = (int)$id;
        redirect('arrear_salary?tab=entry&edit_id=' . $id);
    }

    /**
     * Save / Update Arrear Record (AJAX & Standard POST)
     */
    public function save()
    {
        $is_ajax = $this->input->is_ajax_request();

        $id            = (int)$this->input->post('id');
        $emp_id        = trim((string)$this->input->post('emp_id'));
        $arrear_month  = trim((string)$this->input->post('arrear_month'));
        $payment_month = trim((string)$this->input->post('payment_month'));
        $amount        = (float)$this->input->post('amount');
        $remarks       = trim((string)$this->input->post('remarks'));
        $status        = trim((string)$this->input->post('status'));

        // Validations
        if (empty($emp_id)) {
            $msg = 'Please select a valid employee.';
            if ($is_ajax) { return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => false, 'message' => $msg))); }
            $this->session->set_flashdata('error', $msg);
            redirect('arrear_salary/create');
            return;
        }

        if (empty($payment_month)) {
            $msg = 'Payment Month is required.';
            if ($is_ajax) { return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => false, 'message' => $msg))); }
            $this->session->set_flashdata('error', $msg);
            redirect('arrear_salary');
            return;
        }

        if (empty($arrear_month)) {
            $arrear_month = $payment_month;
        }

        if ($amount <= 0) {
            $msg = 'Arrear Amount must be greater than zero.';
            if ($is_ajax) { return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => false, 'message' => $msg))); }
            $this->session->set_flashdata('error', $msg);
            redirect('arrear_salary/create');
            return;
        }

        if (empty($status) || !in_array($status, array('Pending', 'Approved', 'Cancelled'))) {
            $status = 'Approved';
        }

        $payload = array(
            'emp_id'        => $emp_id,
            'arrear_month'  => $arrear_month,
            'payment_month' => $payment_month,
            'amount'        => $amount,
            'remarks'       => $remarks,
            'status'        => $status,
        );

        if ($id > 0) {
            // Update
            $res = $this->Arrear_salary_model->update_arrear($id, $payload, $this->data['username']);
            if (!$res['status']) {
                if ($is_ajax) { return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => false, 'message' => $res['message']))); }
                $this->session->set_flashdata('error', $res['message']);
                redirect('arrear_salary');
                return;
            }
            $msg = 'Arrear salary record updated successfully.';
            if (!empty($res['auto_processed'])) {
                $msg .= ' (Processed salary sheet for ' . date('F Y', strtotime($payment_month)) . ' was auto-updated!)';
            }
        } else {
            // Create
            $res = $this->Arrear_salary_model->save_arrear($payload, $this->data['username']);
            $msg = 'Arrear salary record created successfully.';
            if (!empty($res['auto_processed'])) {
                $msg .= ' (Processed salary sheet for ' . date('F Y', strtotime($payment_month)) . ' was auto-updated!)';
            }
        }

        if ($is_ajax) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => true, 'message' => $msg, 'redirect' => base_url('arrear_salary'))));
        }

        $this->session->set_flashdata('success', $msg);
        redirect('arrear_salary');
    }

    /**
     * Delete Arrear Record
     */
    public function delete($id)
    {
        $id = (int)$id;
        $res = $this->Arrear_salary_model->delete_arrear($id);

        if ($this->input->is_ajax_request()) {
            return $this->output->set_content_type('application/json')->set_output(json_encode($res));
        }

        if ($res['status']) {
            $this->session->set_flashdata('success', $res['message']);
        } else {
            $this->session->set_flashdata('error', $res['message']);
        }
        redirect('arrear_salary');
    }

    /**
     * Approve Arrear Record
     */
    public function approve($id)
    {
        $id = (int)$id;
        $res = $this->Arrear_salary_model->change_status($id, 'Approved', $this->data['username']);

        if ($this->input->is_ajax_request()) {
            return $this->output->set_content_type('application/json')->set_output(json_encode($res));
        }

        if ($res['status']) {
            $this->session->set_flashdata('success', $res['message']);
        } else {
            $this->session->set_flashdata('error', $res['message']);
        }
        redirect('arrear_salary');
    }

    /**
     * Cancel Arrear Record
     */
    public function cancel($id)
    {
        $id = (int)$id;
        $res = $this->Arrear_salary_model->change_status($id, 'Cancelled', $this->data['username']);

        if ($this->input->is_ajax_request()) {
            return $this->output->set_content_type('application/json')->set_output(json_encode($res));
        }

        if ($res['status']) {
            $this->session->set_flashdata('success', $res['message']);
        } else {
            $this->session->set_flashdata('error', $res['message']);
        }
        redirect('arrear_salary');
    }

    /**
     * AJAX Search Employees for autocomplete
     */
    public function employee_search_ajax()
    {
        $term    = $this->input->post('q') ? $this->input->post('q') : $this->input->get('q');
        $unit_id = $this->input->post('unit_id') ? (int)$this->input->post('unit_id') : null;

        $results = $this->Arrear_salary_model->search_employees($term, $unit_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status' => 'success',
            'data'   => $results
        )));
    }

    /**
     * AJAX Get single employee details by ID
     */
    public function get_employee_ajax()
    {
        $emp_id = trim((string)$this->input->post('emp_id'));
        $emp = $this->Arrear_salary_model->get_employee_details($emp_id);

        if ($emp) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status' => true,
                'data'   => $emp
            )));
        } else {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status' => false,
                'message' => 'Employee not found.'
            )));
        }
    }

    /**
     * AJAX Get single arrear record with employee details for inline editing
     */
    public function get_arrear_ajax($id)
    {
        $id = (int)$id;
        $arrear = $this->Arrear_salary_model->get_arrear_by_id($id);
        if (!$arrear) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Arrear salary record not found.'
            )));
        }

        $emp = $this->Arrear_salary_model->get_employee_details($arrear->emp_id);

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'            => true,
            'data'              => $arrear,
            'employee'          => $emp,
            'arrear_month_val'  => date('Y-m', strtotime($arrear->arrear_month)),
            'payment_month_val' => date('Y-m', strtotime($arrear->payment_month)),
        )));
    }
}


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attn_regularization_con extends CI_Controller
{
    protected $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Attn_regularization_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('setting_helper');
        $this->load->helper('menu_helper');

        if ($this->session->userdata('logged_in') == false) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')
                             ->set_status_header(401)
                             ->set_output(json_encode(array('status' => 'error', 'message' => 'Session expired. Please login again.')));
                return;
            }
            redirect("authentication");
        }

        $this->data['user_data'] = $this->session->userdata('data');
        $this->data['username']  = isset($this->data['user_data']->id_number) ? $this->data['user_data']->id_number : $this->session->userdata('username');
    }

    /**
     * Determine if current user is Admin
     */
    public function is_admin()
    {
        $user = isset($this->data['user_data']) ? $this->data['user_data'] : null;
        $uname = $user && !empty($user->id_number) ? strtolower(trim($user->id_number)) : '';
        if ($uname === 'admin' || ($user && strtolower(trim($user->level)) === 'all')) {
            return true;
        }
        return false;
    }

    /**
     * Dashboard Overview
     */
    public function dashboard()
    {
        $unit_id = $this->input->get('unit_id');
        $month   = $this->input->get('month');
        if (empty($month)) {
            $month = date('Y-m');
        }

        $this->data['selected_unit']  = $unit_id;
        $this->data['selected_month'] = $month;
        $this->data['units']          = $this->db->get('pr_units')->result();
        $this->data['stats']          = $this->Attn_regularization_model->get_statistics($unit_id, $month);

        $recent_filters = array();
        if (!empty($unit_id)) $recent_filters['unit_id'] = $unit_id;
        if (!empty($month)) $recent_filters['month'] = $month;
        $this->data['recent_list']    = $this->Attn_regularization_model->get_regularizations($recent_filters, 10, 0);

        $this->data['title'] = 'Attendance Regularization & Remark Dashboard';
        $this->data['subview'] = 'attn_regularization/dashboard';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * Add Regularization / Remark Entry Form
     */
    public function create()
    {
        $this->data['units']        = $this->db->get('pr_units')->result();
        $this->data['departments']  = $this->db->get('emp_depertment')->result();
        $this->data['designations'] = $this->db->get('emp_designation')->result();
        $this->data['title']        = 'New Attendance Regularization & Remark';
        $this->data['subview']      = 'attn_regularization/create';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * Save Regularization Entry
     */
    public function save()
    {
        if ($this->input->method() !== 'post') {
            redirect('attn_regularization/create');
        }

        $unit_id          = (int) $this->input->post('unit_id');
        $emp_ids_raw      = $this->input->post('emp_id');
        $att_date         = $this->input->post('att_date');
        $end_date         = $this->input->post('end_date'); // optional for date range
        $issue_type       = $this->input->post('issue_type');
        $reason_type      = $this->input->post('reason_type');
        $remarks          = trim($this->input->post('remarks'));
        $waive_deduction  = $this->input->post('waive_deduction') ? 1 : 0;
        $adj_in           = $this->input->post('adjusted_in_time');
        $adj_out          = $this->input->post('adjusted_out_time');
        $auto_approve     = $this->is_admin() ? 'Approved' : 'Approved'; // Can be set to Approved by default for HR

        if (empty($emp_ids_raw) || empty($att_date) || empty($issue_type) || empty($reason_type)) {
            $msg = 'Please provide Employee ID, Date, Issue Type, and Reason.';
            if ($this->input->is_ajax_request()) {
                return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'error', 'message' => $msg)));
            }
            $this->session->set_flashdata('error', $msg);
            redirect('attn_regularization/create');
        }

        // Parse employee IDs (single or multiple comma-separated)
        $emp_ids = is_array($emp_ids_raw) ? $emp_ids_raw : explode(',', $emp_ids_raw);
        $emp_ids = array_filter(array_map('trim', $emp_ids));

        // Date range handling
        $start_d = date('Y-m-d', strtotime($att_date));
        $end_d   = !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $start_d;
        if ($end_d < $start_d) {
            $end_d = $start_d;
        }

        // Check if salary month is already closed/blocked
        $month_start = date('Y-m-01', strtotime($start_d));
        $block_check = $this->db->where('unit_id', $unit_id)->where('block_month', $month_start)->get('pay_salary_block');
        if ($block_check->num_rows() > 0) {
            $msg = 'Sorry! The selected month has already been final processed and blocked.';
            if ($this->input->is_ajax_request()) {
                return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'error', 'message' => $msg)));
            }
            $this->session->set_flashdata('error', $msg);
            redirect('attn_regularization/create');
        }

        $current_user = $this->data['username'];
        $saved_count = 0;

        foreach ($emp_ids as $emp_id) {
            $cur = $start_d;
            while ($cur <= $end_d) {
                $save_payload = array(
                    'unit_id'           => $unit_id ?: 1,
                    'emp_id'            => $emp_id,
                    'att_date'          => $cur,
                    'issue_type'        => $issue_type,
                    'reason_type'       => $reason_type,
                    'remarks'           => $remarks,
                    'waive_deduction'   => $waive_deduction,
                    'adjusted_in_time'  => !empty($adj_in) ? $adj_in : null,
                    'adjusted_out_time' => !empty($adj_out) ? $adj_out : null,
                    'status'            => $auto_approve,
                    'created_by'        => $current_user,
                    'approved_by'       => ($auto_approve === 'Approved') ? $current_user : null,
                    'approved_at'       => ($auto_approve === 'Approved') ? date('Y-m-d H:i:s') : null,
                );

                $this->Attn_regularization_model->save_regularization($save_payload);
                $saved_count++;

                $cur = date('Y-m-d', strtotime('+1 day', strtotime($cur)));
            }
        }

        $success_msg = "Successfully saved {$saved_count} regularization / remark record(s).";
        if ($waive_deduction) {
            $success_msg .= " Penalty waived (No salary deduction will apply).";
        }

        if ($this->input->is_ajax_request()) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'message' => $success_msg)));
        }

        $this->session->set_flashdata('success', $success_msg);
        redirect('attn_regularization/list');
    }

    /**
     * Regularization List with Filtering
     */
    public function list()
    {
        $filters = array(
            'unit_id'         => $this->input->get('unit_id'),
            'dept_id'         => $this->input->get('dept_id'),
            'sec_id'          => $this->input->get('sec_id'),
            'emp_id'          => $this->input->get('emp_id'),
            'issue_type'      => $this->input->get('issue_type'),
            'waive_deduction' => $this->input->get('waive_deduction'),
            'status'          => $this->input->get('status'),
            'start_date'      => $this->input->get('start_date'),
            'end_date'        => $this->input->get('end_date'),
        );

        $this->data['filters']      = $filters;
        $this->data['units']        = $this->db->get('pr_units')->result();
        $this->data['departments']  = $this->db->get('emp_depertment')->result();
        $this->data['sections']     = $this->db->get('emp_section')->result();
        $this->data['list']         = $this->Attn_regularization_model->get_regularizations($filters);
        $this->data['title']        = 'Attendance Regularization & Remark List';

        $this->data['subview'] = 'attn_regularization/list';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * Approval Management
     */
    public function approval()
    {
        $filters = array(
            'status'     => 'Pending',
            'unit_id'    => $this->input->get('unit_id'),
            'start_date' => $this->input->get('start_date'),
            'end_date'   => $this->input->get('end_date'),
        );

        $this->data['units'] = $this->db->get('pr_units')->result();
        $this->data['list']  = $this->Attn_regularization_model->get_regularizations($filters);
        $this->data['title']   = 'Attendance Regularization Approval';
        $this->data['subview'] = 'attn_regularization/approval';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * Approve or Reject Action
     */
    public function action()
    {
        $id     = (int) $this->input->post('id');
        $status = $this->input->post('status'); // 'Approved' or 'Rejected'
        $reason = $this->input->post('reason');

        if (!$id || !in_array($status, array('Approved', 'Rejected'))) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'error', 'message' => 'Invalid parameters.')));
        }

        $res = $this->Attn_regularization_model->update_status($id, $status, $this->data['username'], $reason);
        if ($res) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'message' => "Regularization {$status} successfully.")));
        } else {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'error', 'message' => 'Record not found.')));
        }
    }

    /**
     * Delete Regularization
     */
    public function delete($id)
    {
        $id = (int)$id;
        $res = $this->Attn_regularization_model->delete_regularization($id);

        if ($this->input->is_ajax_request()) {
            if ($res) {
                return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'message' => 'Record deleted and attendance shift log reverted.')));
            } else {
                return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'error', 'message' => 'Record not found.')));
            }
        }

        if ($res) {
            $this->session->set_flashdata('success', 'Regularization deleted and shift log restored.');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete record.');
        }
        redirect('attn_regularization/list');
    }

    /**
     * Reports View
     */
    public function reports()
    {
        $filters = array(
            'unit_id'    => $this->input->get('unit_id'),
            'dept_id'    => $this->input->get('dept_id'),
            'issue_type' => $this->input->get('issue_type'),
            'start_date' => $this->input->get('start_date'),
            'end_date'   => $this->input->get('end_date'),
            'status'     => 'Approved'
        );

        if (empty($filters['start_date'])) {
            $filters['start_date'] = date('Y-m-01');
        }
        if (empty($filters['end_date'])) {
            $filters['end_date'] = date('Y-m-t');
        }

        $this->data['filters']     = $filters;
        $this->data['units']       = $this->db->get('pr_units')->result();
        $this->data['departments'] = $this->db->get('emp_depertment')->result();
        $this->data['list']        = $this->Attn_regularization_model->get_regularizations($filters);
        $this->data['title']   = 'Attendance Regularization & Waiver Report';
        $this->data['subview'] = 'attn_regularization/reports';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX endpoint to inspect day's attendance log for selected employee & date
     */
    public function ajax_get_emp_attendance()
    {
        $emp_id = trim($this->input->get('emp_id'));
        $date   = trim($this->input->get('date'));

        if (empty($emp_id) || empty($date)) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'error', 'message' => 'Invalid parameters')));
        }

        $date = date('Y-m-d', strtotime($date));
        $res  = $this->Attn_regularization_model->get_employee_attn_info($emp_id, $date);

        // Also fetch employee name & designation
        $emp_info = $this->db->select('c.emp_id, p.name_en, d.dept_name, deg.desig_name, c.unit_id')
                             ->from('pr_emp_com_info c')
                             ->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'left')
                             ->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left')
                             ->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left')
                             ->where('c.emp_id', $emp_id)
                             ->get()->row();

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'   => 'success',
            'employee' => $emp_info,
            'log'      => $res['log'],
            'existing' => $res['existing_regularization']
        )));
    }

    /**
     * AJAX endpoint for employee search
     */
    public function ajax_search_emp()
    {
        $term    = $this->input->get('term');
        $unit_id = $this->input->get('unit_id');
        $results = $this->Attn_regularization_model->search_employees($term, $unit_id, 25);
        return $this->output->set_content_type('application/json')->set_output(json_encode($results));
    }
}

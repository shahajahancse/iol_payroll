<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ot_approval_con extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Ot_approval_model');
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
    }

    /**
     * Determine if current user has Admin privileges
     */
    public function is_admin()
    {
        $user = $this->data['user_data'];
        if (!$user) {
            return false;
        }
        $username = strtolower(trim($user->id_number));
        return ($username === 'admin' || $username === 'msa' || $user->level === 'All');
    }

    /**
     * Enforce strict admin-only authorization for all approval actions
     */
    private function require_admin()
    {
        if (!$this->is_admin()) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')
                             ->set_status_header(403)
                             ->set_output(json_encode(array(
                                 'status'  => 'error',
                                 'message' => 'Unauthorized. Daily OT Approval is restricted exclusively to Admin users.'
                             )));
                exit();
            }
            show_error('Access denied. You do not have permission to access the Daily OT Approval Management module.', 403, '403 Forbidden');
            exit();
        }
    }

    /**
     * Get accessible unit ID for current user
     */
    private function get_scoped_unit_id()
    {
        $user = $this->data['user_data'];
        if ($user->level === 'All') {
            return null;
        }
        return !empty($user->unit_name) ? $user->unit_name : 1;
    }

    /**
     * Admin Daily OT Dashboard
     */
    public function admin_dashboard()
    {
        $this->require_admin();

        $unit_id = $this->get_scoped_unit_id();
        $this->data['title'] = 'Daily Overtime (OT) Approval & Admin Management';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['is_admin'] = true;
        $this->data['unit_id'] = $unit_id;

        // Fetch dropdown options for filters
        $this->data['departments']  = $this->db->order_by('dept_name', 'ASC')->get('emp_depertment')->result();
        $this->data['sections']     = $this->db->order_by('sec_name_en', 'ASC')->get('emp_section')->result();
        $this->data['designations'] = $this->db->order_by('desig_name', 'ASC')->get('emp_designation')->result();
        $this->data['shifts']       = $this->db->order_by('shift_name', 'ASC')->get('pr_emp_shift')->result();
        $this->data['units']        = $this->db->get('pr_units')->result();

        // Default working date: check latest date with OT in pr_emp_shift_log
        $latest = $this->db->select('shift_log_date')
                           ->where('(tot > 0 OR ot > 0 OR eot > 0)')
                           ->order_by('shift_log_date', 'DESC')
                           ->limit(1)
                           ->get('pr_emp_shift_log')
                           ->row();
        $this->data['default_date'] = $latest ? $latest->shift_log_date : date('Y-m-d');

        $this->data['subview'] = 'ot/admin_dashboard';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX endpoint: Get dashboard summary cards statistics
     */
    public function admin_stats_ajax()
    {
        $this->require_admin();

        $start_date = $this->input->get_post('start_date');
        $end_date   = $this->input->get_post('end_date');
        if (empty($start_date)) {
            $start_date = $this->input->get_post('ot_date');
        }
        if (empty($start_date)) {
            $start_date = date('Y-m-d');
        }
        if (empty($end_date)) {
            $end_date = $start_date;
        }

        $unit_id = $this->input->get_post('unit_id');
        if (empty($unit_id)) {
            $unit_id = $this->get_scoped_unit_id();
        }

        $stats = $this->Ot_approval_model->get_admin_stats($start_date, $end_date, $unit_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($stats));
    }

    /**
     * AJAX endpoint: Get filtered, sorted, paginated OT list
     */
    public function admin_ot_list_ajax()
    {
        $this->require_admin();

        $start_date = $this->input->get_post('start_date');
        $end_date   = $this->input->get_post('end_date');
        if (empty($start_date)) {
            $start_date = $this->input->get_post('ot_date');
        }
        if (empty($start_date)) {
            $start_date = date('Y-m-d');
        }
        if (empty($end_date)) {
            $end_date = $start_date;
        }

        $params = array(
            'start_date'=> $start_date,
            'end_date'  => $end_date,
            'ot_date'   => $start_date,
            'unit_id'   => $this->input->get_post('unit_id') ? $this->input->get_post('unit_id') : $this->get_scoped_unit_id(),
            'search'    => $this->input->get_post('search'),
            'dept_id'   => $this->input->get_post('dept_id'),
            'sec_id'    => $this->input->get_post('sec_id'),
            'desig_id'  => $this->input->get_post('desig_id'),
            'shift_id'  => $this->input->get_post('shift_id'),
            'status'    => $this->input->get_post('status'),
            'limit'     => $this->input->get_post('limit') ? (int)$this->input->get_post('limit') : 25,
            'offset'    => $this->input->get_post('offset') ? (int)$this->input->get_post('offset') : 0,
            'sort_col'  => $this->input->get_post('sort_col'),
            'sort_dir'  => $this->input->get_post('sort_dir')
        );

        $result = $this->Ot_approval_model->get_admin_ot_list($params);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    /**
     * AJAX endpoint: Generate or refresh Daily OT List for a date or date range
     */
    public function generate_daily_ot_ajax()
    {
        $this->require_admin();

        $start_date = $this->input->post('start_date');
        $end_date   = $this->input->post('end_date');
        if (empty($start_date)) {
            $start_date = $this->input->post('ot_date');
        }
        if (empty($start_date)) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Please specify a working date or date range.')));
            return;
        }
        if (empty($end_date)) {
            $end_date = $start_date;
        }

        $unit_id = $this->input->post('unit_id') ? $this->input->post('unit_id') : $this->get_scoped_unit_id();
        $res = $this->Ot_approval_model->generate_or_sync_daily_ot($start_date, $end_date, $unit_id);

        $date_label = ($start_date === $end_date) ? "for {$start_date}" : "between {$start_date} and {$end_date}";
        $msg = "Daily OT list generated/refreshed {$date_label}: {$res['inserted']} new entries added, {$res['updated']} pending entries updated.";
        if ($res['flagged_review'] > 0) {
            $msg .= " Note: {$res['flagged_review']} previously decided records flagged due to updated attendance punches.";
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => 'success',
            'message' => $msg,
            'details' => $res
        )));
    }

    /**
     * AJAX endpoint: Approve OT for single record
     */
    public function admin_approve_single()
    {
        $this->require_admin();

        $id = (int)$this->input->post('id');
        $approved_hours = $this->input->post('approved_hours');
        $remarks = $this->input->post('remarks');
        $admin_id = $this->data['user_data']->id_number;

        if (!$id) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Invalid record ID.')));
            return;
        }

        if ($approved_hours === null || $approved_hours === '' || !is_numeric($approved_hours)) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Please provide valid approved OT hours.')));
            return;
        }

        $res = $this->Ot_approval_model->approve_ot($id, $approved_hours, $admin_id, $remarks);
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => $res['status'] ? 'success' : 'error',
            'message' => $res['message']
        )));
    }

    /**
     * AJAX endpoint: Modify OT hours (e.g. approve fewer hours with mandatory reason)
     */
    public function admin_modify_single()
    {
        $this->require_admin();

        $id = (int)$this->input->post('id');
        $approved_hours = $this->input->post('approved_hours');
        $reason = $this->input->post('modification_reason');
        $remarks = $this->input->post('remarks');
        $admin_id = $this->data['user_data']->id_number;

        if (!$id) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Invalid record ID.')));
            return;
        }

        if (empty(trim($reason))) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Modification reason is required when adjusting OT hours.')));
            return;
        }

        if ($approved_hours === null || $approved_hours === '' || !is_numeric($approved_hours)) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Please provide valid approved OT hours.')));
            return;
        }

        $res = $this->Ot_approval_model->modify_ot_hours($id, $approved_hours, $reason, $admin_id, $remarks);
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => $res['status'] ? 'success' : 'error',
            'message' => $res['message']
        )));
    }

    /**
     * AJAX endpoint: Reject OT record with mandatory reason
     */
    public function admin_reject_single()
    {
        $this->require_admin();

        $id = (int)$this->input->post('id');
        $reason = $this->input->post('rejection_reason');
        $remarks = $this->input->post('remarks');
        $admin_id = $this->data['user_data']->id_number;

        if (!$id) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Invalid record ID.')));
            return;
        }

        if (empty(trim($reason))) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Rejection reason is required.')));
            return;
        }

        $res = $this->Ot_approval_model->reject_ot($id, $reason, $admin_id, $remarks);
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => $res['status'] ? 'success' : 'error',
            'message' => $res['message']
        )));
    }

    /**
     * AJAX endpoint: Bulk approve selected pending records
     */
    public function admin_bulk_approve()
    {
        $this->require_admin();

        $ids = $this->input->post('ids');
        $remarks = $this->input->post('remarks');
        $admin_id = $this->data['user_data']->id_number;

        if (empty($ids) || !is_array($ids)) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Please select at least one record to approve.')));
            return;
        }

        $res = $this->Ot_approval_model->bulk_approve_ot($ids, $admin_id, $remarks);
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => $res['status'] ? 'success' : 'error',
            'message' => $res['message'],
            'count'   => isset($res['count']) ? $res['count'] : 0
        )));
    }

    /**
     * AJAX endpoint: Get full record details & audit trail
     */
    public function get_ot_details_ajax($id)
    {
        $this->require_admin();

        $record = $this->Ot_approval_model->get_record_by_id((int)$id);
        if (!$record) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'error', 'message' => 'Record not found.')));
            return;
        }

        $audit = !empty($record->audit_history) ? json_decode($record->audit_history, true) : array();
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status' => 'success',
            'record' => $record,
            'audit'  => $audit
        )));
    }
}

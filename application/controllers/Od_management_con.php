<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Od_management_con extends CI_Controller
{
    protected $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Od_management_model');
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
     * Get current logged-in username in lowercase
     */
    private function get_current_username()
    {
        $user = isset($this->data['user_data']) ? $this->data['user_data'] : null;
        if ($user && !empty($user->id_number)) {
            return strtolower(trim($user->id_number));
        }
        $session_username = $this->session->userdata('username');
        if (!empty($session_username)) {
            return strtolower(trim($session_username));
        }
        return '';
    }

    /**
     * Determine if current user has Admin privileges
     */
    public function is_admin()
    {
        $uname = $this->get_current_username();
        $user  = isset($this->data['user_data']) ? $this->data['user_data'] : null;
        if ($uname === 'admin' || ($user && strtolower(trim($user->level)) === 'all')) {
            return true;
        }
        return false;
    }

    /**
     * Get accessible unit ID for current user (null if 'All')
     */
    private function get_scoped_unit_id()
    {
        $user = $this->data['user_data'];
        if ($user && $user->level === 'All') {
            return null;
        }
        return ($user && !empty($user->unit_name)) ? $user->unit_name : 1;
    }

    /**
     * Default Index
     */
    public function index()
    {
        redirect('od_management_con/dashboard');
    }

    /**
     * OD Executive Dashboard
     */
    public function dashboard()
    {
        $unit_id = $this->get_scoped_unit_id();
        $this->data['title'] = 'Outside Duty (OD) Management Dashboard';
        $this->data['unit_id'] = $unit_id;
        $this->data['is_admin'] = $this->is_admin();
        $this->data['units'] = $this->Od_management_model->get_units();
        $this->data['departments'] = $this->Od_management_model->get_departments();
        $this->data['stats'] = $this->Od_management_model->get_dashboard_stats($unit_id);

        $this->data['subview'] = 'od/dashboard';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX: Refresh Dashboard Stats
     */
    public function dashboard_stats_ajax()
    {
        $scoped_unit = $this->get_scoped_unit_id();
        $selected_unit = $this->input->get_post('unit_id');
        $unit_id = (!empty($selected_unit) && empty($scoped_unit)) ? (int)$selected_unit : $scoped_unit;

        $stats = $this->Od_management_model->get_dashboard_stats($unit_id);
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array('status' => 'success', 'data' => $stats)));
    }

    /**
     * Create OD Assignment Page & Handler
     */
    public function create()
    {
        $unit_id = $this->get_scoped_unit_id();

        if ($this->input->method() === 'post') {
            $this->save_assignment(0);
            return;
        }

        $this->data['title'] = 'Assign Outside Duty (OD)';
        $this->data['unit_id'] = $unit_id;
        $this->data['is_admin'] = $this->is_admin();
        $this->data['units'] = $this->Od_management_model->get_units();
        $this->data['departments'] = $this->Od_management_model->get_departments();
        $this->data['sections'] = $this->Od_management_model->get_sections();
        $this->data['designations'] = $this->Od_management_model->get_designations();
        $this->data['od_purposes'] = $this->get_od_purposes();

        $this->data['subview'] = 'od/assignment_form';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * Edit OD Assignment
     */
    public function edit($id = null)
    {
        if (empty($id)) {
            redirect('od_management_con/list');
            return;
        }

        $od = $this->Od_management_model->get_od_by_id($id);
        if (!$od) {
            $this->session->set_flashdata('error', 'OD Assignment not found.');
            redirect('od_management_con/list');
            return;
        }

        if ($this->input->method() === 'post') {
            $this->save_assignment($id);
            return;
        }

        $unit_id = $this->get_scoped_unit_id();
        $this->data['title'] = 'Edit Outside Duty (OD) Assignment #' . $id;
        $this->data['unit_id'] = $unit_id;
        $this->data['is_admin'] = $this->is_admin();
        $this->data['od'] = $od;
        $this->data['employee'] = $this->Od_management_model->get_employee_info($od->emp_id);
        $this->data['units'] = $this->Od_management_model->get_units();
        $this->data['departments'] = $this->Od_management_model->get_departments();
        $this->data['sections'] = $this->Od_management_model->get_sections();
        $this->data['designations'] = $this->Od_management_model->get_designations();
        $this->data['od_purposes'] = $this->get_od_purposes();

        $this->data['subview'] = 'od/assignment_form';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * Common method to save or update OD assignment
     */
    private function save_assignment($id = 0)
    {
        $emp_id          = trim($this->input->post('emp_id'));
        $assignment_mode = trim($this->input->post('assignment_mode')); // 'range' or 'individual'
        $start_date      = trim($this->input->post('start_date'));
        $end_date        = trim($this->input->post('end_date'));
        $custom_dates    = $this->input->post('custom_dates'); // array or comma-separated
        $purpose         = trim($this->input->post('purpose'));
        $location        = trim($this->input->post('location'));
        $work_desc       = trim($this->input->post('work_description'));
        $departure_time  = trim($this->input->post('departure_time'));
        $return_time     = trim($this->input->post('return_time'));
        $remarks         = trim($this->input->post('remarks'));
        $approval_status = trim($this->input->post('status')); // 'pending' or 'approved'

        if (empty($emp_id)) {
            $this->send_json_response(false, 'Please select an employee.');
            return;
        }

        if (empty($purpose)) {
            $this->send_json_response(false, 'Please select or enter the OD purpose.');
            return;
        }

        if (empty($location)) {
            $this->send_json_response(false, 'Please enter outside duty location.');
            return;
        }

        if (empty($work_desc)) {
            $this->send_json_response(false, 'Please enter official work description.');
            return;
        }

        // Calculate and validate dates
        $dates_array = array();
        if ($assignment_mode === 'individual') {
            if (is_array($custom_dates)) {
                $dates_array = $custom_dates;
            } elseif (!empty($custom_dates)) {
                $dates_array = array_filter(array_map('trim', explode(',', $custom_dates)));
            }
            // Sort dates
            sort($dates_array);
            if (empty($dates_array)) {
                $this->send_json_response(false, 'Please select at least one OD date.');
                return;
            }
            $start_date = reset($dates_array);
            $end_date   = end($dates_array);
        } else {
            $assignment_mode = 'range';
            if (empty($start_date)) {
                $this->send_json_response(false, 'Please select start date.');
                return;
            }
            if (empty($end_date)) {
                $end_date = $start_date;
            }
            if ($end_date < $start_date) {
                $this->send_json_response(false, 'End date cannot be earlier than start date.');
                return;
            }
            // Generate all dates in continuous range
            $current = strtotime($start_date);
            $last    = strtotime($end_date);
            while ($current <= $last) {
                $dates_array[] = date('Y-m-d', $current);
                $current = strtotime('+1 day', $current);
            }
        }

        // Fetch employee unit
        $emp_info = $this->Od_management_model->get_employee_info($emp_id);
        if (!$emp_info) {
            $this->send_json_response(false, 'Employee not found in database.');
            return;
        }
        $unit_id = !empty($emp_info->unit_id) ? $emp_info->unit_id : 1;

        // Check date conflicts (Leave, existing OD)
        $conflicts = $this->Od_management_model->check_date_conflicts($emp_id, $dates_array, $id);
        if (!empty($conflicts['existing_ods'])) {
            $dup_dates = array();
            foreach ($conflicts['existing_ods'] as $co) {
                $dup_dates[] = $co['date'] . ' (' . $co['status'] . ')';
            }
            $this->send_json_response(false, 'Conflict: Employee already has OD assigned on: ' . implode(', ', $dup_dates));
            return;
        }

        if (!empty($conflicts['leaves'])) {
            $leave_dates = array();
            foreach ($conflicts['leaves'] as $cl) {
                $leave_dates[] = $cl['date'] . ' (' . $cl['leave_type'] . ')';
            }
            $this->send_json_response(false, 'Conflict: Employee is on approved Leave on: ' . implode(', ', $leave_dates));
            return;
        }

        // Determine initial status:
        // Admin or authorized user can directly create as 'approved' if chosen, otherwise 'pending'
        $status = 'pending';
        if ($this->is_admin() && $approval_status === 'approved') {
            $status = 'approved';
        }

        $username = $this->get_current_username();
        $user_id  = isset($this->data['user_data']->id) ? $this->data['user_data']->id : 1;

        $payload = array(
            'emp_id'           => $emp_id,
            'unit_id'          => $unit_id,
            'assignment_mode'  => $assignment_mode,
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            'purpose'          => $purpose,
            'location'         => $location,
            'work_description' => $work_desc,
            'departure_time'   => !empty($departure_time) ? $departure_time : null,
            'return_time'      => !empty($return_time) ? $return_time : null,
            'status'           => $status,
            'remarks'          => $remarks
        );

        if ($id > 0) {
            $updated = $this->Od_management_model->update_assignment($id, $payload, $dates_array, $username);
            if ($updated) {
                log_activity('OD Assignment Updated', "Updated OD #{$id} for emp {$emp_id}", $user_id);
                $this->send_json_response(true, 'OD Assignment updated successfully.', array('id' => $id));
            } else {
                $this->send_json_response(false, 'Failed to update OD assignment. Please try again.');
            }
        } else {
            $od_id = $this->Od_management_model->create_assignment($payload, $dates_array, $username);
            if ($od_id) {
                log_activity('OD Assignment Created', "Created OD #{$od_id} for emp {$emp_id}", $user_id);
                $msg = ($status === 'approved') ? 'OD Assignment created and approved successfully!' : 'OD Assignment submitted successfully (Pending Approval).';
                $this->send_json_response(true, $msg, array('id' => $od_id));
            } else {
                $this->send_json_response(false, 'Failed to create OD assignment. Please try again.');
            }
        }
    }

    /**
     * OD List View Page
     */
    public function list()
    {
        $unit_id = $this->get_scoped_unit_id();
        $this->data['title'] = 'Outside Duty (OD) Assignments List';
        $this->data['unit_id'] = $unit_id;
        $this->data['is_admin'] = $this->is_admin();
        $this->data['units'] = $this->Od_management_model->get_units();
        $this->data['departments'] = $this->Od_management_model->get_departments();
        $this->data['od_purposes'] = $this->get_od_purposes();

        $this->data['subview'] = 'od/od_list';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX: Paginated OD List
     */
    public function list_ajax()
    {
        $page      = max(1, (int)$this->input->get_post('page'));
        $limit     = max(10, min(100, (int)$this->input->get_post('limit') ?: 20));
        $offset    = ($page - 1) * $limit;

        $scoped_unit = $this->get_scoped_unit_id();
        $selected_unit = $this->input->get_post('unit_id');
        $unit_id   = (!empty($selected_unit) && empty($scoped_unit)) ? (int)$selected_unit : $scoped_unit;

        $filters = array(
            'unit_id'   => $unit_id,
            'dept_id'   => $this->input->get_post('dept_id'),
            'emp_id'    => trim($this->input->get_post('emp_id')),
            'status'    => trim($this->input->get_post('status')),
            'purpose'   => trim($this->input->get_post('purpose')),
            'from_date' => trim($this->input->get_post('from_date')),
            'to_date'   => trim($this->input->get_post('to_date'))
        );

        $result = $this->Od_management_model->get_od_list($filters, $limit, $offset);

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array(
                         'status'  => 'success',
                         'page'    => $page,
                         'limit'   => $limit,
                         'total'   => $result['total'],
                         'records' => $result['records']
                     )));
    }

    /**
     * OD Approval Queue Page
     */
    public function approval()
    {
        $unit_id = $this->get_scoped_unit_id();
        $this->data['title'] = 'Outside Duty (OD) Approval & Management';
        $this->data['unit_id'] = $unit_id;
        $this->data['is_admin'] = $this->is_admin();
        $this->data['units'] = $this->Od_management_model->get_units();
        $this->data['departments'] = $this->Od_management_model->get_departments();

        $this->data['subview'] = 'od/approval';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX: Approve OD Assignment
     */
    public function approve_ajax()
    {
        $id      = (int)$this->input->post('id');
        $remarks = trim($this->input->post('remarks'));

        if (empty($id)) {
            $this->send_json_response(false, 'Invalid OD assignment ID.');
            return;
        }

        $username = $this->get_current_username();
        $user_id  = isset($this->data['user_data']->id) ? $this->data['user_data']->id : 1;

        $ok = $this->Od_management_model->approve_assignment($id, $username, $remarks);
        if ($ok) {
            log_activity('OD Approved', "OD #{$id} approved by {$username}", $user_id);
            $this->send_json_response(true, "OD Assignment #{$id} approved successfully and attendance synced!");
        } else {
            $this->send_json_response(false, 'Could not approve OD assignment. It may have already been processed.');
        }
    }

    /**
     * AJAX: Bulk Approve OD Assignments
     */
    public function bulk_approve_ajax()
    {
        $ids = $this->input->post('ids');
        if (!is_array($ids) || empty($ids)) {
            $this->send_json_response(false, 'No assignments selected for approval.');
            return;
        }

        $username = $this->get_current_username();
        $user_id  = isset($this->data['user_data']->id) ? $this->data['user_data']->id : 1;
        $success_count = 0;

        foreach ($ids as $id) {
            $id = (int)$id;
            if ($id > 0 && $this->Od_management_model->approve_assignment($id, $username, 'Bulk approved')) {
                $success_count++;
            }
        }

        log_activity('OD Bulk Approved', "Approved {$success_count} OD assignments", $user_id);
        $this->send_json_response(true, "Successfully approved {$success_count} Outside Duty assignments!");
    }

    /**
     * AJAX: Reject OD Assignment
     */
    public function reject_ajax()
    {
        $id     = (int)$this->input->post('id');
        $reason = trim($this->input->post('reason'));

        if (empty($id)) {
            $this->send_json_response(false, 'Invalid OD assignment ID.');
            return;
        }

        if (empty($reason)) {
            $this->send_json_response(false, 'Please provide a rejection reason.');
            return;
        }

        $username = $this->get_current_username();
        $user_id  = isset($this->data['user_data']->id) ? $this->data['user_data']->id : 1;

        $ok = $this->Od_management_model->reject_assignment($id, $username, $reason);
        if ($ok) {
            log_activity('OD Rejected', "OD #{$id} rejected by {$username}. Reason: {$reason}", $user_id);
            $this->send_json_response(true, "OD Assignment #{$id} has been rejected.");
        } else {
            $this->send_json_response(false, 'Could not reject OD assignment.');
        }
    }

    /**
     * AJAX: Cancel OD Assignment
     */
    public function cancel_ajax()
    {
        $id     = (int)$this->input->post('id');
        $reason = trim($this->input->post('reason'));

        if (empty($id)) {
            $this->send_json_response(false, 'Invalid OD assignment ID.');
            return;
        }

        $username = $this->get_current_username();
        $user_id  = isset($this->data['user_data']->id) ? $this->data['user_data']->id : 1;

        $ok = $this->Od_management_model->cancel_assignment($id, $username, $reason);
        if ($ok) {
            log_activity('OD Cancelled', "OD #{$id} cancelled by {$username}", $user_id);
            $this->send_json_response(true, "OD Assignment #{$id} has been cancelled.");
        } else {
            $this->send_json_response(false, 'Could not cancel OD assignment.');
        }
    }

    /**
     * AJAX: Get Full Details of OD Assignment
     */
    public function details_ajax($id = null)
    {
        $id = (int)$id;
        if (empty($id)) {
            $this->send_json_response(false, 'Invalid ID');
            return;
        }

        $od = $this->Od_management_model->get_od_by_id($id);
        if (!$od) {
            $this->send_json_response(false, 'OD Assignment not found.');
            return;
        }

        // Decode audit history
        $od->audit_list = !empty($od->audit_history) ? json_decode($od->audit_history, true) : array();

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array('status' => 'success', 'data' => $od)));
    }

    /**
     * AJAX: Search Employee Autocomplete
     */
    public function employee_search_ajax()
    {
        $term    = trim($this->input->get_post('q') ?: $this->input->get_post('term'));
        $unit_id = $this->input->get_post('unit_id') ?: $this->get_scoped_unit_id();
        $dept_id = $this->input->get_post('dept_id');
        $sec_id  = $this->input->get_post('sec_id');
        $desig_id = $this->input->get_post('desig_id');

        $employees = $this->Od_management_model->search_employees($term, $unit_id, $dept_id, $sec_id, $desig_id, 30);
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array('status' => 'success', 'data' => $employees)));
    }

    /**
     * AJAX: Get Single Employee Details
     */
    public function employee_info_ajax($emp_id = '')
    {
        $emp_id = trim($emp_id ?: $this->input->get_post('emp_id'));
        if (empty($emp_id)) {
            $this->send_json_response(false, 'Employee ID required.');
            return;
        }

        $info = $this->Od_management_model->get_employee_info($emp_id);
        if ($info) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(array('status' => 'success', 'data' => $info)));
        } else {
            $this->send_json_response(false, 'Employee not found.');
        }
    }

    /**
     * AJAX: Real-time Date Conflict Check
     */
    public function check_conflicts_ajax()
    {
        $emp_id = trim($this->input->get_post('emp_id'));
        $dates  = $this->input->get_post('dates');
        $od_id  = (int)$this->input->get_post('exclude_id');

        if (empty($emp_id) || empty($dates)) {
            $this->send_json_response(true, 'OK', array('has_conflict' => false));
            return;
        }

        if (!is_array($dates)) {
            $dates = array_filter(array_map('trim', explode(',', $dates)));
        }

        $conflicts = $this->Od_management_model->check_date_conflicts($emp_id, $dates, $od_id);
        $has_conflict = (!empty($conflicts['leaves']) || !empty($conflicts['existing_ods']));

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array(
                         'status'       => 'success',
                         'has_conflict' => $has_conflict,
                         'conflicts'    => $conflicts
                     )));
    }

    /**
     * Reports Center Page
     */
    public function reports()
    {
        $unit_id = $this->get_scoped_unit_id();
        $this->data['title'] = 'Outside Duty (OD) Reports';
        $this->data['unit_id'] = $unit_id;
        $this->data['is_admin'] = $this->is_admin();
        $this->data['units'] = $this->Od_management_model->get_units();
        $this->data['departments'] = $this->Od_management_model->get_departments();

        $this->data['subview'] = 'od/reports';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX: Get Reports Data
     */
    public function report_data_ajax()
    {
        $type = trim($this->input->get_post('report_type') ?: 'daily');
        $filters = array(
            'date'      => trim($this->input->get_post('date') ?: date('Y-m-d')),
            'month'     => trim($this->input->get_post('month') ?: date('Y-m')),
            'emp_id'    => trim($this->input->get_post('emp_id')),
            'from_date' => trim($this->input->get_post('from_date')),
            'to_date'   => trim($this->input->get_post('to_date')),
            'status'    => trim($this->input->get_post('status')),
            'unit_id'   => $this->input->get_post('unit_id') ?: $this->get_scoped_unit_id(),
            'dept_id'   => $this->input->get_post('dept_id')
        );

        $data = $this->Od_management_model->get_reports_data($type, $filters);
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(array('status' => 'success', 'report_type' => $type, 'data' => $data)));
    }

    /**
     * Export OD Data to Excel / CSV
     */
    public function export_excel()
    {
        $type = trim($this->input->get('type') ?: 'list');
        $filters = array(
            'unit_id'   => $this->input->get('unit_id') ?: $this->get_scoped_unit_id(),
            'dept_id'   => $this->input->get('dept_id'),
            'emp_id'    => trim($this->input->get('emp_id')),
            'status'    => trim($this->input->get('status')),
            'purpose'   => trim($this->input->get('purpose')),
            'from_date' => trim($this->input->get('from_date')),
            'to_date'   => trim($this->input->get('to_date')),
            'date'      => trim($this->input->get('date') ?: date('Y-m-d')),
            'month'     => trim($this->input->get('month') ?: date('Y-m'))
        );

        $filename = "OD_Export_" . date('Ymd_His') . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        // UTF-8 BOM for Excel compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        if ($type === 'daily' || $type === 'monthly' || $type === 'employee' || $type === 'department' || $type === 'branch') {
            $data = $this->Od_management_model->get_reports_data($type, $filters);
            if ($type === 'daily') {
                fputcsv($output, array('SL', 'Date', 'Emp ID', 'Employee Name', 'Department', 'Designation', 'Purpose', 'Location', 'Departure', 'Return', 'Status', 'Attendance Status'));
                $sl = 1;
                foreach ($data as $r) {
                    fputcsv($output, array(
                        $sl++,
                        $r->od_date,
                        $r->emp_id,
                        $r->name_en,
                        $r->dept_name,
                        $r->desig_name,
                        $r->purpose,
                        $r->location,
                        $r->departure_time ?: '-',
                        $r->return_time ?: '-',
                        ucfirst($r->date_status),
                        $r->attendance_status ?: 'OD'
                    ));
                }
            } elseif ($type === 'monthly') {
                fputcsv($output, array('SL', 'Emp ID', 'Employee Name', 'Department', 'Designation', 'Total OD Days', 'Dates'));
                $sl = 1;
                foreach ($data as $r) {
                    fputcsv($output, array(
                        $sl++,
                        $r->emp_id,
                        $r->name_en,
                        $r->dept_name,
                        $r->desig_name,
                        $r->total_od_days,
                        $r->od_dates
                    ));
                }
            } else {
                fputcsv($output, array('SL', 'Emp ID', 'Employee Name', 'Designation', 'Dates / Info'));
                $sl = 1;
                foreach ($data as $r) {
                    fputcsv($output, array($sl++, isset($r->emp_id)?$r->emp_id:'', isset($r->name_en)?$r->name_en:'', isset($r->desig_name)?$r->desig_name:''));
                }
            }
        } else {
            // General OD List
            $result = $this->Od_management_model->get_od_list($filters, 5000, 0);
            fputcsv($output, array('SL', 'Emp ID', 'Employee Name', 'Department', 'Designation', 'Start Date', 'End Date', 'Days', 'Dates', 'Purpose', 'Location', 'Status', 'Assigned By', 'Approved By'));
            $sl = 1;
            foreach ($result['records'] as $r) {
                fputcsv($output, array(
                    $sl++,
                    $r->emp_id,
                    $r->name_en,
                    $r->dept_name,
                    $r->desig_name,
                    $r->start_date,
                    $r->end_date,
                    $r->total_days,
                    implode(', ', $r->dates_list),
                    $r->purpose,
                    $r->location,
                    ucfirst($r->status),
                    $r->assigned_by,
                    $r->approved_by ?: '-'
                ));
            }
        }

        fclose($output);
        exit();
    }

    /**
     * Export / Print PDF view
     */
    public function export_pdf()
    {
        $type = trim($this->input->get('type') ?: 'list');
        $filters = array(
            'unit_id'   => $this->input->get('unit_id') ?: $this->get_scoped_unit_id(),
            'dept_id'   => $this->input->get('dept_id'),
            'emp_id'    => trim($this->input->get('emp_id')),
            'status'    => trim($this->input->get('status')),
            'purpose'   => trim($this->input->get('purpose')),
            'from_date' => trim($this->input->get('from_date')),
            'to_date'   => trim($this->input->get('to_date')),
            'date'      => trim($this->input->get('date') ?: date('Y-m-d')),
            'month'     => trim($this->input->get('month') ?: date('Y-m'))
        );

        $this->data['title'] = 'Outside Duty (OD) Report';
        $this->data['report_type'] = $type;
        $this->data['filters'] = $filters;

        if ($type === 'daily' || $type === 'monthly' || $type === 'employee' || $type === 'department' || $type === 'branch') {
            $this->data['records'] = $this->Od_management_model->get_reports_data($type, $filters);
        } else {
            $res = $this->Od_management_model->get_od_list($filters, 1000, 0);
            $this->data['records'] = $res['records'];
        }

        $this->load->view('od/print_report', $this->data);
    }

    /**
     * Pre-defined OD Purpose Categories
     */
    private function get_od_purposes()
    {
        return array(
            'Client Visit'          => 'Client Visit / Customer Meeting',
            'Site Inspection'       => 'Site Inspection / Factory Visit',
            'Government Office'     => 'Government / Regulatory Office Work',
            'Bank Work'             => 'Banking / Financial Transaction',
            'Training & Seminar'    => 'Training / Workshop / Seminar',
            'Official Meeting'      => 'Official Meeting / Conference',
            'Delivery & Logistics'  => 'Delivery / Goods Dispatch / Logistics',
            'Marketing & Field Work'=> 'Marketing / Field Work / Survey',
            'Official Tour'         => 'Official Tour / Outstation Travel',
            'Emergency Duty'        => 'Emergency / Breakdown Support',
            'Other'                 => 'Other Official Work'
        );
    }

    /**
     * Send standard JSON response
     */
    private function send_json_response($status, $message, $extra = array())
    {
        $response = array_merge(array(
            'status'  => $status ? 'success' : 'error',
            'message' => $message
        ), $extra);

        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($response));
    }
}

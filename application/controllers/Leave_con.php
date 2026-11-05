<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_con extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Leave_model');
        $this->load->model('Earn_leave_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('setting_helper');

        if ($this->session->userdata('logged_in') == false) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => 'Session expired. Please login again.'));
                exit();
            }
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
    }

    /**
     * Get sanitized current username (lowercase, trimmed)
     */
    public function get_current_username()
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
     * Determine if current user has Admin privileges ("Admin" or "admin")
     */
    public function is_admin()
    {
        return ($this->get_current_username() === 'admin');
    }

    /**
     * Determine if current user has HR privileges ("Payroll" or "payroll")
     */
    public function is_hr()
    {
        return ($this->get_current_username() === 'payroll');
    }

    /**
     * Route user directly to their respective leave view
     */
    public function index()
    {
        if ($this->is_admin()) {
            redirect('leave_con/admin_dashboard');
        } elseif ($this->is_hr()) {
            redirect('leave_con/hr_dashboard');
        } else {
            $this->session->set_flashdata('error', 'Access Denied: You do not have permission to access Leave Dashboard.');
            redirect('payroll_con');
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

    // =========================================================================
    // 1. HR DASHBOARD (Restricted to "Payroll" / "payroll")
    // =========================================================================
    public function hr_dashboard()
    {
        // Enforce HR role check: Admin must NOT see HR view!
        if (!$this->is_hr()) {
            if ($this->is_admin()) {
                redirect('leave_con/admin_dashboard');
                return;
            }
            $this->session->set_flashdata('error', 'Access Denied: Only HR (Payroll) can access the HR Leave Management Dashboard.');
            redirect('payroll_con');
            return;
        }

        $unit_id = $this->get_scoped_unit_id();
        $this->data['title'] = 'HR Leave Management Dashboard';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['is_admin'] = false;
        $this->data['is_hr'] = true;

        // Departments
        $this->db->select('dept_id, dept_name');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->data['departments'] = $this->db->order_by('dept_name', 'ASC')->get('emp_depertment')->result();

        // Units
        $this->db->select('unit_id, unit_name');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->data['units'] = $this->db->get('pr_units')->result();

        // Leave types (Only CL, SL, WP, SP are enabled as per policy)
        $this->data['leave_types'] = array(
            'cl' => 'Casual Leave (CL)',
            'sl' => 'Sick Leave (SL)',
            'wp' => 'Without Pay (WP)',
            'sp' => 'Special Leave (SP)'
        );

        $this->data['subview'] = 'leave/hr_dashboard';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX endpoint for HR Dashboard statistics
     */
    public function hr_stats_ajax()
    {
        if (!$this->is_hr()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied: Only HR (Payroll) can access this resource.'));
            return;
        }

        $unit_id = $this->get_scoped_unit_id();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $total_entries = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('status', 'pending');
        $pending_admin = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('status', 'approved');
        $approved = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('status', 'rejected');
        $rejected = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('status', 'returned');
        $returned = $this->db->count_all_results();

        echo json_encode(array(
            'status' => 'success',
            'data' => array(
                'total_entries' => $total_entries,
                'pending_admin' => $pending_admin,
                'approved'      => $approved,
                'rejected'      => $rejected,
                'returned'      => $returned
            )
        ));
    }

    /**
     * AJAX list for HR leave records with filters & pagination
     */
    public function hr_leave_list_ajax()
    {
        if (!$this->is_hr()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied: Only HR (Payroll) can access this resource.'));
            return;
        }

        $unit_id    = $this->get_scoped_unit_id();
        $page       = max(1, (int)$this->input->post('page'));
        $limit      = max(5, min(100, (int)$this->input->post('limit', 15)));
        $offset     = ($page - 1) * $limit;

        $emp_id     = trim($this->input->post('emp_id'));
        $dept_id    = trim($this->input->post('dept_id'));
        $leave_type = trim($this->input->post('leave_type'));
        $status     = trim($this->input->post('status'));
        $from_date  = trim($this->input->post('from_date'));
        $to_date    = trim($this->input->post('to_date'));

        $this->build_leave_query($unit_id, $emp_id, $dept_id, $leave_type, $status, $from_date, $to_date);
        $total_rows = $this->db->count_all_results('', false);

        $this->db->order_by('pr_leave_trans.id', 'DESC');
        $this->db->limit($limit, $offset);
        $rows = $this->db->get()->result();

        $total_pages = ceil($total_rows / $limit);

        echo json_encode(array(
            'status'      => 'success',
            'data'        => $rows,
            'total_rows'  => $total_rows,
            'total_pages' => $total_pages,
            'current_page'=> $page,
            'limit'       => $limit
        ));
    }

    // =========================================================================
    // 2. ADMIN DASHBOARD (Restricted to "Admin" / "admin")
    // =========================================================================
    public function admin_dashboard()
    {
        // Enforce Admin role check: HR must NOT see Admin view!
        if (!$this->is_admin()) {
            if ($this->is_hr()) {
                redirect('leave_con/hr_dashboard');
                return;
            }
            $this->session->set_flashdata('error', 'Access Denied: Only Administrator can access the Leave Approval Dashboard.');
            redirect('payroll_con');
            return;
        }

        $unit_id = $this->get_scoped_unit_id();
        $this->data['title'] = 'Admin Leave Approval Dashboard';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['is_admin'] = true;
        $this->data['is_hr'] = false;

        // Departments
        $this->db->select('dept_id, dept_name');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->data['departments'] = $this->db->order_by('dept_name', 'ASC')->get('emp_depertment')->result();

        // Units
        $this->db->select('unit_id, unit_name');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->data['units'] = $this->db->get('pr_units')->result();

        $this->data['subview'] = 'leave/admin_dashboard';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX endpoint for Admin Dashboard statistics
     */
    public function admin_stats_ajax()
    {
        if (!$this->is_admin()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied: Only Administrator can access this resource.'));
            return;
        }

        $unit_id = $this->get_scoped_unit_id();
        $today = date('Y-m-d');

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $total_requests = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('status', 'pending');
        $pending_approval = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('status', 'approved');
        $approved = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('status', 'rejected');
        $rejected = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('status', 'returned');
        $returned = $this->db->count_all_results();

        $this->db->from('pr_leave_trans');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->where('leave_start', $today);
        $this->db->where_in('status', array('approved', 'pending'));
        $starting_today = $this->db->count_all_results();

        echo json_encode(array(
            'status' => 'success',
            'data' => array(
                'total_requests'   => $total_requests,
                'pending_approval' => $pending_approval,
                'approved'         => $approved,
                'rejected'         => $rejected,
                'returned'         => $returned,
                'starting_today'   => $starting_today
            )
        ));
    }

    /**
     * AJAX list for Admin records (Pending Queue or All with filters)
     */
    public function admin_leave_list_ajax()
    {
        if (!$this->is_admin()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied: Only Administrator can access this resource.'));
            return;
        }

        $unit_id    = $this->get_scoped_unit_id();
        $page       = max(1, (int)$this->input->post('page'));
        $limit      = max(5, min(100, (int)$this->input->post('limit', 15)));
        $offset     = ($page - 1) * $limit;

        $emp_id     = trim($this->input->post('emp_id'));
        $dept_id    = trim($this->input->post('dept_id'));
        $leave_type = trim($this->input->post('leave_type'));
        $status     = trim($this->input->post('status'));
        $from_date  = trim($this->input->post('from_date'));
        $to_date    = trim($this->input->post('to_date'));
        $queue_only = $this->input->post('queue_only');

        if ($queue_only === '1' || $queue_only === 'true') {
            $status = 'pending';
        }

        $this->build_leave_query($unit_id, $emp_id, $dept_id, $leave_type, $status, $from_date, $to_date);
        $total_rows = $this->db->count_all_results('', false);

        // Sorting: pending first if in general list, then by id desc
        if (empty($status) || $status === 'all') {
            $this->db->order_by("FIELD(pr_leave_trans.status, 'pending', 'returned', 'approved', 'rejected')", '', false);
        }
        $this->db->order_by('pr_leave_trans.id', 'DESC');
        $this->db->limit($limit, $offset);
        $rows = $this->db->get()->result();

        $total_pages = ceil($total_rows / $limit);

        echo json_encode(array(
            'status'      => 'success',
            'data'        => $rows,
            'total_rows'  => $total_rows,
            'total_pages' => $total_pages,
            'current_page'=> $page,
            'limit'       => $limit
        ));
    }

    /**
     * Helper to build leave query with joins
     */
    private function build_leave_query($unit_id, $emp_id, $dept_id, $leave_type, $status, $from_date, $to_date)
    {
        $this->db->select("
            pr_leave_trans.*,
            pr_units.unit_name,
            pr_emp_per_info.name_en,
            pr_emp_per_info.name_bn,
            pr_emp_per_info.gender,
            pr_emp_per_info.img_source,
            emp_depertment.dept_name,
            emp_designation.desig_name,
            m_applied.id_number as applied_by_name,
            m_admin.id_number as admin_name
        ");
        $this->db->from('pr_leave_trans');
        $this->db->join('pr_emp_com_info', 'pr_emp_com_info.emp_id = pr_leave_trans.emp_id', 'left');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_leave_trans.emp_id', 'left');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_leave_trans.unit_id', 'left');
        $this->db->join('emp_depertment', 'emp_depertment.dept_id = pr_emp_com_info.emp_dept_id', 'left');
        $this->db->join('emp_designation', 'emp_designation.id = pr_emp_com_info.emp_desi_id', 'left');
        $this->db->join('members as m_applied', 'm_applied.id = pr_leave_trans.applied_by', 'left');
        $this->db->join('members as m_admin', 'm_admin.id = pr_leave_trans.admin_id', 'left');

        if (!empty($unit_id)) {
            $this->db->where('pr_leave_trans.unit_id', $unit_id);
        }
        if (!empty($emp_id)) {
            $this->db->group_start();
            $this->db->like('pr_leave_trans.emp_id', $emp_id);
            $this->db->or_like('pr_emp_per_info.name_en', $emp_id);
            $this->db->group_end();
        }
        if (!empty($dept_id)) {
            $this->db->where('pr_emp_com_info.emp_dept_id', $dept_id);
        }
        if (!empty($leave_type)) {
            $this->db->where('pr_leave_trans.leave_type', $leave_type);
        }
        if (!empty($status) && $status !== 'all') {
            $this->db->where('pr_leave_trans.status', $status);
        }
        if (!empty($from_date)) {
            $this->db->where('pr_leave_trans.leave_start >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('pr_leave_trans.leave_end <=', $to_date);
        }
    }

    // =========================================================================
    // 3. LEAVE DETAILS & BALANCE LOOKUP
    // =========================================================================
    public function get_leave_details_ajax($id = null)
    {
        if (!$this->is_admin() && !$this->is_hr()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied.'));
            return;
        }

        $id = (int)$id;
        if (empty($id)) {
            $id = (int)$this->input->post('id');
        }
        if (empty($id)) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid Leave ID'));
            return;
        }

        $this->db->select("
            pr_leave_trans.*,
            pr_units.unit_name,
            pr_emp_per_info.name_en,
            pr_emp_per_info.name_bn,
            pr_emp_per_info.gender,
            pr_emp_per_info.img_source,
            pr_emp_per_info.personal_mobile,
            pr_emp_com_info.emp_join_date,
            emp_depertment.dept_name,
            emp_designation.desig_name,
            m_applied.id_number as applied_by_name,
            m_admin.id_number as admin_name
        ");
        $this->db->from('pr_leave_trans');
        $this->db->join('pr_emp_com_info', 'pr_emp_com_info.emp_id = pr_leave_trans.emp_id', 'left');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_leave_trans.emp_id', 'left');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_leave_trans.unit_id', 'left');
        $this->db->join('emp_depertment', 'emp_depertment.dept_id = pr_emp_com_info.emp_dept_id', 'left');
        $this->db->join('emp_designation', 'emp_designation.id = pr_emp_com_info.emp_desi_id', 'left');
        $this->db->join('members as m_applied', 'm_applied.id = pr_leave_trans.applied_by', 'left');
        $this->db->join('members as m_admin', 'm_admin.id = pr_leave_trans.admin_id', 'left');
        $this->db->where('pr_leave_trans.id', $id);
        $leave = $this->db->get()->row();

        if (empty($leave)) {
            echo json_encode(array('status' => 'error', 'message' => 'Leave request not found'));
            return;
        }

        // Get employee balances for current year
        $year = date('Y', strtotime($leave->leave_start));
        $balances = $this->get_emp_leave_balances($leave->emp_id, $year);

        // Decode modification history
        $history = array();
        if (!empty($leave->modification_history)) {
            $history = json_decode($leave->modification_history, true);
        }

        echo json_encode(array(
            'status'   => 'success',
            'leave'    => $leave,
            'balances' => $balances,
            'history'  => $history
        ));
    }

    /**
     * AJAX endpoint to search employee and get live details & leave balances
     */
    public function get_emp_info_balance_ajax()
    {
        if (!$this->is_admin() && !$this->is_hr()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied.'));
            return;
        }

        $emp_id = trim($this->input->post('emp_id'));
        $year   = $this->input->post('year') ? trim($this->input->post('year')) : date('Y');

        if (empty($emp_id)) {
            echo json_encode(array('status' => 'error', 'message' => 'Employee ID is required'));
            return;
        }

        $this->db->select("
            pr_emp_com_info.emp_id,
            pr_emp_com_info.unit_id,
            pr_emp_com_info.emp_dept_id,
            pr_emp_com_info.emp_sec_id,
            pr_emp_com_info.emp_desi_id,
            pr_emp_com_info.emp_cat_id,
            pr_emp_com_info.emp_join_date,
            pr_emp_per_info.name_en,
            pr_emp_per_info.name_bn,
            pr_emp_per_info.gender,
            pr_emp_per_info.marital_status,
            pr_emp_per_info.img_source,
            emp_depertment.dept_name,
            emp_designation.desig_name,
            pr_units.unit_name
        ");
        $this->db->from('pr_emp_com_info');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
        $this->db->join('emp_depertment', 'emp_depertment.dept_id = pr_emp_com_info.emp_dept_id', 'left');
        $this->db->join('emp_designation', 'emp_designation.id = pr_emp_com_info.emp_desi_id', 'left');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_emp_com_info.unit_id', 'left');
        $this->db->where('pr_emp_com_info.emp_id', $emp_id);
        $emp = $this->db->get()->row();

        if (empty($emp)) {
            echo json_encode(array('status' => 'error', 'message' => 'Employee not found'));
            return;
        }

        // Scope check
        $scoped_unit = $this->get_scoped_unit_id();
        if (!empty($scoped_unit) && $emp->unit_id != $scoped_unit) {
            echo json_encode(array('status' => 'error', 'message' => 'You do not have permission to access employees from this unit'));
            return;
        }

        $balances = $this->get_emp_leave_balances($emp_id, $year);

        echo json_encode(array(
            'status'   => 'success',
            'emp'      => $emp,
            'balances' => $balances
        ));
    }

    /**
     * Internal method to calculate live balances (CL, SL, ML, PL, EL)
     */
    private function get_emp_leave_balances($emp_id, $year)
    {
        $first_date = $year . "-01-01";
        $last_date  = $year . "-12-31";

        // 1. Get unit and entitlements
        $com_info = $this->db->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
        $unit_id = !empty($com_info->unit_id) ? $com_info->unit_id : 1;
        $per_info = $this->db->where('emp_id', $emp_id)->get('pr_emp_per_info')->row();

        $leave_entitle = $this->db->where('unit_id', $unit_id)->get('pr_leave')->row();
        if (empty($leave_entitle)) {
            $leave_entitle = $this->db->get('pr_leave')->row();
        }

        $gender = !empty($per_info->gender) ? $per_info->gender : 'Male';

        // Entitlements fixed as per company policy: CL = 10 days, SL = 14 days. EL, ML, PL disabled.
        $ent_cl = 10;
        $ent_sl = 14;
        $ent_ml = 0;
        $ent_pl = 0;
        $ent_el = 0;

        // 2. Query only approved leaves for taken counts
        $this->db->select("
            SUM(CASE WHEN leave_type = 'cl' THEN total_leave ELSE 0 END) AS taken_cl,
            SUM(CASE WHEN leave_type = 'sl' THEN total_leave ELSE 0 END) AS taken_sl,
            SUM(CASE WHEN leave_type = 'ml' THEN total_leave ELSE 0 END) AS taken_ml,
            SUM(CASE WHEN leave_type = 'pl' THEN total_leave ELSE 0 END) AS taken_pl,
            SUM(CASE WHEN leave_type = 'el' THEN total_leave ELSE 0 END) AS taken_el,
            SUM(CASE WHEN leave_type = 'wp' THEN total_leave ELSE 0 END) AS taken_wp,
            SUM(CASE WHEN leave_type = 'sp' THEN total_leave ELSE 0 END) AS taken_sp
        ");
        $this->db->where('emp_id', $emp_id);
        $this->db->where('leave_start >=', $first_date);
        $this->db->where('leave_end <=', $last_date);
        $this->db->where("(status = 'approved' OR status IS NULL)");
        $taken = $this->db->get('pr_leave_trans')->row();

        $t_cl = !empty($taken->taken_cl) ? (int)$taken->taken_cl : 0;
        $t_sl = !empty($taken->taken_sl) ? (int)$taken->taken_sl : 0;
        $t_ml = !empty($taken->taken_ml) ? (int)$taken->taken_ml : 0;
        $t_pl = !empty($taken->taken_pl) ? (int)$taken->taken_pl : 0;
        $t_el = !empty($taken->taken_el) ? (int)$taken->taken_el : 0;
        $t_wp = !empty($taken->taken_wp) ? (int)$taken->taken_wp : 0;
        $t_sp = !empty($taken->taken_sp) ? (int)$taken->taken_sp : 0;

        return array(
            'cl' => array('entitled' => $ent_cl, 'taken' => $t_cl, 'balance' => max(0, $ent_cl - $t_cl)),
            'sl' => array('entitled' => $ent_sl, 'taken' => $t_sl, 'balance' => max(0, $ent_sl - $t_sl)),
            'el' => array('entitled' => $ent_el, 'taken' => $t_el, 'balance' => max(0, $ent_el - $t_el)),
            'ml' => array('entitled' => $ent_ml, 'taken' => $t_ml, 'balance' => max(0, $ent_ml - $t_ml)),
            'pl' => array('entitled' => $ent_pl, 'taken' => $t_pl, 'balance' => max(0, $ent_pl - $t_pl)),
            'wp' => array('entitled' => 0,       'taken' => $t_wp, 'balance' => 0),
            'sp' => array('entitled' => 0,       'taken' => $t_sp, 'balance' => 0),
            'gender' => $gender,
            'year' => $year
        );
    }

    // =========================================================================
    // 4. HR SUBMIT LEAVE & RESUBMIT
    // =========================================================================
    public function hr_submit_leave()
    {
        if (!$this->is_hr()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied: Only HR (Payroll) can submit leave requests.'));
            return;
        }

        $emp_id          = trim($this->input->post('emp_id'));
        $leave_type      = trim($this->input->post('leave_type'));
        $apply_date      = trim($this->input->post('apply_date', date('Y-m-d')));
        $from_date       = trim($this->input->post('from_date'));
        $to_date         = trim($this->input->post('to_date'));
        $reason          = trim($this->input->post('reason'));
        $add_on_vacation = trim($this->input->post('add_on_vacation'));

        if (empty($emp_id) || empty($leave_type) || empty($from_date) || empty($to_date)) {
            echo json_encode(array('status' => 'error', 'message' => 'Please fill in all required fields (Employee, Leave Type, Dates).'));
            return;
        }

        if (strtotime($from_date) > strtotime($to_date)) {
            echo json_encode(array('status' => 'error', 'message' => 'Start date cannot be greater than end date.'));
            return;
        }

        // Validate employee exists
        $emp = $this->db->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
        if (empty($emp)) {
            echo json_encode(array('status' => 'error', 'message' => 'Employee ID does not exist.'));
            return;
        }

        // Unit scope check
        $scoped_unit = $this->get_scoped_unit_id();
        if (!empty($scoped_unit) && $emp->unit_id != $scoped_unit) {
            echo json_encode(array('status' => 'error', 'message' => 'You cannot create leaves for employees outside your unit.'));
            return;
        }

        $per_info = $this->db->where('emp_id', $emp_id)->get('pr_emp_per_info')->row();
        $gender   = !empty($per_info->gender) ? $per_info->gender : 'Male';
        $marital  = !empty($per_info->marital_status) ? $per_info->marital_status : '';

        // Gender/marital validations
        if ($leave_type === 'ml') {
            if ($gender !== 'Female') {
                echo json_encode(array('status' => 'error', 'message' => 'Male employees are not eligible for Maternity Leave.'));
                return;
            }
            if ($marital === 'Unmarried') {
                echo json_encode(array('status' => 'error', 'message' => 'Unmarried employees are not eligible for Maternity Leave.'));
                return;
            }
        }
        if ($leave_type === 'pl') {
            if ($gender !== 'Male') {
                echo json_encode(array('status' => 'error', 'message' => 'Female employees are not eligible for Paternity Leave.'));
                return;
            }
            if ($marital === 'Unmarried') {
                echo json_encode(array('status' => 'error', 'message' => 'Unmarried employees are not eligible for Paternity Leave.'));
                return;
            }
        }

        // Calculate days
        $start_dt = new DateTime($from_date);
        $end_dt   = new DateTime($to_date);
        $total_leave = $start_dt->diff($end_dt)->days + 1;

        // Check overlapping leave (pending or approved)
        $overlap = $this->db->where('emp_id', $emp_id)
            ->where("leave_start <= '{$to_date}' AND leave_end >= '{$from_date}'")
            ->where_in('status', array('pending', 'approved'))
            ->get('pr_leave_trans')
            ->num_rows();

        if ($overlap > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'An active or pending leave entry already overlaps with these dates.'));
            return;
        }

        // Balance validation (if not Without Pay)
        $year = date('Y', strtotime($from_date));
        $balances = $this->get_emp_leave_balances($emp_id, $year);

        if (in_array($leave_type, array('cl', 'sl', 'el', 'ml', 'pl'))) {
            $avail = isset($balances[$leave_type]['balance']) ? $balances[$leave_type]['balance'] : 0;
            if ($total_leave > $avail) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => "Insufficient leave balance. Requested: {$total_leave} day(s), Available: {$avail} day(s)."
                ));
                return;
            }
        }

        $user_id   = $this->data['user_data']->id;
        $user_name = $this->data['user_data']->id_number;

        $history = array(
            array(
                'action'    => 'created_and_submitted',
                'by_id'     => $user_id,
                'by_name'   => $user_name,
                'timestamp' => date('Y-m-d H:i:s'),
                'note'      => 'HR submitted leave entry for employee. Status set to Pending Admin Approval.'
            )
        );

        $insert_data = array(
            'emp_id'               => $emp_id,
            'unit_id'              => $emp->unit_id,
            'start_date'           => !empty($apply_date) ? $apply_date : date('Y-m-d'),
            'leave_type'           => $leave_type,
            'leave_start'          => $from_date,
            'leave_end'            => $to_date,
            'total_leave'          => $total_leave,
            'status'               => 'pending',
            'leave_descrip'        => $reason,
            'add_on_vacation'      => $add_on_vacation,
            'applied_by'           => $user_id,
            'applied_at'           => date('Y-m-d H:i:s'),
            'modification_history' => json_encode($history)
        );

        if ($this->db->insert('pr_leave_trans', $insert_data)) {
            $insert_id = $this->db->insert_id();
            log_activity('HR Leave Entry Submitted', "Leave entry ID: {$insert_id} submitted for Emp: {$emp_id} ({$total_leave} days, {$leave_type})", $user_id);
            echo json_encode(array(
                'status'  => 'success',
                'message' => 'Leave entry successfully submitted and placed in Admin approval queue.',
                'id'      => $insert_id
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save leave entry to database.'));
        }
    }

    /**
     * HR resubmits a leave request that was returned by Admin
     */
    public function hr_resubmit_leave()
    {
        if (!$this->is_hr()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied: Only HR (Payroll) can resubmit leave requests.'));
            return;
        }

        $leave_id        = (int)$this->input->post('leave_id');
        $leave_type      = trim($this->input->post('leave_type'));
        $from_date       = trim($this->input->post('from_date'));
        $to_date         = trim($this->input->post('to_date'));
        $reason          = trim($this->input->post('reason'));
        $add_on_vacation = trim($this->input->post('add_on_vacation'));
        $resubmit_note   = trim($this->input->post('resubmit_note'));

        if (empty($leave_id) || empty($leave_type) || empty($from_date) || empty($to_date)) {
            echo json_encode(array('status' => 'error', 'message' => 'Please provide all required fields.'));
            return;
        }

        $leave = $this->db->where('id', $leave_id)->get('pr_leave_trans')->row();
        if (empty($leave)) {
            echo json_encode(array('status' => 'error', 'message' => 'Leave record not found.'));
            return;
        }

        if ($leave->status !== 'returned') {
            echo json_encode(array('status' => 'error', 'message' => 'Only requests returned for modification can be resubmitted.'));
            return;
        }

        // Unit scope check
        $scoped_unit = $this->get_scoped_unit_id();
        if (!empty($scoped_unit) && $leave->unit_id != $scoped_unit) {
            echo json_encode(array('status' => 'error', 'message' => 'Permission denied for this unit.'));
            return;
        }

        if (strtotime($from_date) > strtotime($to_date)) {
            echo json_encode(array('status' => 'error', 'message' => 'Start date cannot be greater than end date.'));
            return;
        }

        // Calculate days
        $start_dt = new DateTime($from_date);
        $end_dt   = new DateTime($to_date);
        $total_leave = $start_dt->diff($end_dt)->days + 1;

        // Check overlapping leave excluding this record
        $overlap = $this->db->where('emp_id', $leave->emp_id)
            ->where('id !=', $leave_id)
            ->where("leave_start <= '{$to_date}' AND leave_end >= '{$from_date}'")
            ->where_in('status', array('pending', 'approved'))
            ->get('pr_leave_trans')
            ->num_rows();

        if ($overlap > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Another active or pending leave entry overlaps with the modified dates.'));
            return;
        }

        // Balance check
        $year = date('Y', strtotime($from_date));
        $balances = $this->get_emp_leave_balances($leave->emp_id, $year);
        if (in_array($leave_type, array('cl', 'sl', 'el', 'ml', 'pl'))) {
            $avail = isset($balances[$leave_type]['balance']) ? $balances[$leave_type]['balance'] : 0;
            if ($total_leave > $avail) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => "Insufficient leave balance. Requested: {$total_leave} day(s), Available: {$avail} day(s)."
                ));
                return;
            }
        }

        $user_id   = $this->data['user_data']->id;
        $user_name = $this->data['user_data']->id_number;

        // Append to history
        $history = array();
        if (!empty($leave->modification_history)) {
            $history = json_decode($leave->modification_history, true);
        }

        $history[] = array(
            'action'    => 'resubmitted_by_hr',
            'by_id'     => $user_id,
            'by_name'   => $user_name,
            'timestamp' => date('Y-m-d H:i:s'),
            'note'      => !empty($resubmit_note) ? $resubmit_note : 'Modified and resubmitted by HR after return',
            'changes'   => array(
                'previous' => array(
                    'leave_type'  => $leave->leave_type,
                    'leave_start' => $leave->leave_start,
                    'leave_end'   => $leave->leave_end,
                    'total_leave' => $leave->total_leave
                ),
                'new' => array(
                    'leave_type'  => $leave_type,
                    'leave_start' => $from_date,
                    'leave_end'   => $to_date,
                    'total_leave' => $total_leave
                )
            )
        );

        $update_data = array(
            'leave_type'           => $leave_type,
            'leave_start'          => $from_date,
            'leave_end'            => $to_date,
            'total_leave'          => $total_leave,
            'leave_descrip'        => $reason,
            'add_on_vacation'      => $add_on_vacation,
            'status'               => 'pending',
            'return_reason'        => null,
            'applied_at'           => date('Y-m-d H:i:s'),
            'modification_history' => json_encode($history)
        );

        $this->db->where('id', $leave_id);
        if ($this->db->update('pr_leave_trans', $update_data)) {
            log_activity('HR Resubmitted Leave', "Leave ID: {$leave_id} resubmitted for Emp: {$leave->emp_id} after return.", $user_id);
            echo json_encode(array(
                'status'  => 'success',
                'message' => 'Request successfully resubmitted to Admin for approval.'
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update leave record.'));
        }
    }

    // =========================================================================
    // 5. ADMIN ACTIONS: APPROVE / REJECT / MODIFY / RETURN
    // =========================================================================
    public function admin_action()
    {
        // Enforce role check strictly on backend
        if (!$this->is_admin()) {
            echo json_encode(array('status' => 'error', 'message' => 'Access Denied: Only Administrator can perform this action.'));
            return;
        }

        $action   = trim($this->input->post('action'));
        $leave_id = (int)$this->input->post('leave_id');

        if (empty($leave_id) || empty($action)) {
            echo json_encode(array('status' => 'error', 'message' => 'Missing required action or leave ID.'));
            return;
        }

        // Fetch leave record
        $leave = $this->db->where('id', $leave_id)->get('pr_leave_trans')->row();
        if (empty($leave)) {
            echo json_encode(array('status' => 'error', 'message' => 'Leave record not found.'));
            return;
        }

        $admin_id   = $this->data['user_data']->id;
        $admin_name = $this->data['user_data']->id_number;
        $now        = date('Y-m-d H:i:s');

        // Existing modification history
        $history = array();
        if (!empty($leave->modification_history)) {
            $history = json_decode($leave->modification_history, true);
        }

        // Begin atomic database transaction
        $this->db->trans_start();

        switch ($action) {
            case 'approve':
                if ($leave->status !== 'pending') {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'error', 'message' => "Only pending requests can be approved. Current status: {$leave->status}."));
                    return;
                }

                $remarks = trim($this->input->post('admin_remarks'));

                // Earn Leave deduction logic if EL
                if ($leave->leave_type === 'el') {
                    $earn_row = $this->db->where('emp_id', $leave->emp_id)->order_by('id', 'DESC')->limit(1)->get('pr_earn_leave')->row();
                    if (!empty($earn_row)) {
                        $new_el = $earn_row->el + $leave->total_leave;
                        $new_earn_leave = max(0, $earn_row->earn_leave - $leave->total_leave);
                        $this->db->where('id', $earn_row->id)->update('pr_earn_leave', array(
                            'el' => $new_el,
                            'earn_leave' => $new_earn_leave
                        ));
                    }
                }

                $history[] = array(
                    'action'    => 'approved',
                    'by_id'     => $admin_id,
                    'by_name'   => $admin_name,
                    'timestamp' => $now,
                    'note'      => !empty($remarks) ? $remarks : 'Approved by Admin'
                );

                $update_data = array(
                    'status'               => 'approved',
                    'admin_id'             => $admin_id,
                    'admin_action_at'      => $now,
                    'admin_remarks'        => $remarks,
                    'modification_history' => json_encode($history)
                );

                $this->db->where('id', $leave_id)->update('pr_leave_trans', $update_data);
                log_activity('Admin Approved Leave', "Leave ID: {$leave_id} approved for Emp: {$leave->emp_id}", $admin_id);
                $msg = 'Leave request approved successfully.';
                break;

            case 'reject':
                if ($leave->status !== 'pending') {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'error', 'message' => "Only pending requests can be rejected. Current status: {$leave->status}."));
                    return;
                }

                $rejection_reason = trim($this->input->post('rejection_reason'));
                if (empty($rejection_reason)) {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'error', 'message' => 'Rejection reason is required.'));
                    return;
                }

                $history[] = array(
                    'action'    => 'rejected',
                    'by_id'     => $admin_id,
                    'by_name'   => $admin_name,
                    'timestamp' => $now,
                    'reason'    => $rejection_reason
                );

                $update_data = array(
                    'status'               => 'rejected',
                    'admin_id'             => $admin_id,
                    'admin_action_at'      => $now,
                    'rejection_reason'     => $rejection_reason,
                    'modification_history' => json_encode($history)
                );

                $this->db->where('id', $leave_id)->update('pr_leave_trans', $update_data);
                log_activity('Admin Rejected Leave', "Leave ID: {$leave_id} rejected. Reason: {$rejection_reason}", $admin_id);
                $msg = 'Leave request has been rejected.';
                break;

            case 'return':
                if ($leave->status !== 'pending') {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'error', 'message' => "Only pending requests can be returned. Current status: {$leave->status}."));
                    return;
                }

                $return_reason = trim($this->input->post('return_reason'));
                if (empty($return_reason)) {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'error', 'message' => 'Return reason is required so HR knows what to modify.'));
                    return;
                }

                $history[] = array(
                    'action'    => 'returned_for_modification',
                    'by_id'     => $admin_id,
                    'by_name'   => $admin_name,
                    'timestamp' => $now,
                    'reason'    => $return_reason
                );

                $update_data = array(
                    'status'               => 'returned',
                    'admin_id'             => $admin_id,
                    'admin_action_at'      => $now,
                    'return_reason'        => $return_reason,
                    'modification_history' => json_encode($history)
                );

                $this->db->where('id', $leave_id)->update('pr_leave_trans', $update_data);
                log_activity('Admin Returned Leave', "Leave ID: {$leave_id} returned to HR for modification. Reason: {$return_reason}", $admin_id);
                $msg = 'Leave request returned to HR for modification.';
                break;

            case 'modify':
                $mod_leave_type = trim($this->input->post('mod_leave_type'));
                $mod_from_date  = trim($this->input->post('mod_from_date'));
                $mod_to_date    = trim($this->input->post('mod_to_date'));
                $mod_remarks    = trim($this->input->post('mod_remarks'));
                $mod_action     = trim($this->input->post('mod_action')); // 'save' or 'save_and_approve'

                if (empty($mod_leave_type) || empty($mod_from_date) || empty($mod_to_date)) {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'error', 'message' => 'Modified leave type, from date, and to date are required.'));
                    return;
                }

                if (strtotime($mod_from_date) > strtotime($mod_to_date)) {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'error', 'message' => 'Start date cannot be greater than end date.'));
                    return;
                }

                // Recalculate days
                $start_dt = new DateTime($mod_from_date);
                $end_dt   = new DateTime($mod_to_date);
                $new_total = $start_dt->diff($end_dt)->days + 1;

                // Check overlap with other leaves
                $overlap = $this->db->where('emp_id', $leave->emp_id)
                    ->where('id !=', $leave_id)
                    ->where("leave_start <= '{$mod_to_date}' AND leave_end >= '{$mod_from_date}'")
                    ->where_in('status', array('pending', 'approved'))
                    ->get('pr_leave_trans')
                    ->num_rows();

                if ($overlap > 0) {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'error', 'message' => 'The modified date range overlaps with another leave entry.'));
                    return;
                }

                // Balance check if modified type is balance-controlled
                $year = date('Y', strtotime($mod_from_date));
                $balances = $this->get_emp_leave_balances($leave->emp_id, $year);
                if (in_array($mod_leave_type, array('cl', 'sl', 'el', 'ml', 'pl'))) {
                    $avail = isset($balances[$mod_leave_type]['balance']) ? $balances[$mod_leave_type]['balance'] : 0;
                    if ($new_total > $avail) {
                        $this->db->trans_rollback();
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => "Insufficient leave balance for modified request. Requested: {$new_total} day(s), Available: {$avail} day(s)."
                        ));
                        return;
                    }
                }

                $new_status = ($mod_action === 'save_and_approve') ? 'approved' : 'pending';

                // Earn leave deduction if approved
                if ($new_status === 'approved' && $mod_leave_type === 'el') {
                    $earn_row = $this->db->where('emp_id', $leave->emp_id)->order_by('id', 'DESC')->limit(1)->get('pr_earn_leave')->row();
                    if (!empty($earn_row)) {
                        $new_el = $earn_row->el + $new_total;
                        $new_earn_leave = max(0, $earn_row->earn_leave - $new_total);
                        $this->db->where('id', $earn_row->id)->update('pr_earn_leave', array(
                            'el' => $new_el,
                            'earn_leave' => $new_earn_leave
                        ));
                    }
                }

                $history[] = array(
                    'action'    => ($new_status === 'approved') ? 'modified_and_approved_by_admin' : 'modified_by_admin',
                    'by_id'     => $admin_id,
                    'by_name'   => $admin_name,
                    'timestamp' => $now,
                    'note'      => $mod_remarks,
                    'changes'   => array(
                        'previous' => array(
                            'leave_type'  => $leave->leave_type,
                            'leave_start' => $leave->leave_start,
                            'leave_end'   => $leave->leave_end,
                            'total_leave' => $leave->total_leave,
                            'status'      => $leave->status
                        ),
                        'new' => array(
                            'leave_type'  => $mod_leave_type,
                            'leave_start' => $mod_from_date,
                            'leave_end'   => $mod_to_date,
                            'total_leave' => $new_total,
                            'status'      => $new_status
                        )
                    )
                );

                $update_data = array(
                    'leave_type'           => $mod_leave_type,
                    'leave_start'          => $mod_from_date,
                    'leave_end'            => $mod_to_date,
                    'total_leave'          => $new_total,
                    'status'               => $new_status,
                    'admin_id'             => $admin_id,
                    'admin_action_at'      => $now,
                    'admin_remarks'        => $mod_remarks,
                    'modification_history' => json_encode($history)
                );

                $this->db->where('id', $leave_id)->update('pr_leave_trans', $update_data);
                log_activity('Admin Modified Leave', "Leave ID: {$leave_id} modified by Admin to {$mod_leave_type} ({$new_total} days, {$new_status})", $admin_id);
                $msg = ($new_status === 'approved') ? 'Leave modified and approved successfully.' : 'Leave details modified successfully.';
                break;

            default:
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'error', 'message' => 'Invalid action specified.'));
                return;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            echo json_encode(array('status' => 'error', 'message' => 'Transaction failed. Could not process request.'));
        } else {
            echo json_encode(array('status' => 'success', 'message' => $msg));
        }
    }

    /**
     * Export Leave List to Excel (proxies to Entry_system_con)
     */
    public function export_leave_excel()
    {
        $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
        redirect('entry_system_con/export_leave_excel' . $qs);
    }

    /**
     * Export Leave List to PDF (proxies to Entry_system_con)
     */
    public function export_leave_pdf()
    {
        $qs = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
        redirect('entry_system_con/export_leave_pdf' . $qs);
    }
}

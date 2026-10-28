<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Od_management_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->ensure_tables_exist();
    }

    /**
     * Ensure database tables exist with proper schema and indexes
     */
    public function ensure_tables_exist()
    {
        if (!$this->db->table_exists('pr_emp_od')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `pr_emp_od` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `emp_id` varchar(16) NOT NULL,
              `unit_id` int(11) NOT NULL DEFAULT 1,
              `assignment_mode` enum('range','individual') NOT NULL DEFAULT 'range',
              `start_date` date NOT NULL,
              `end_date` date NOT NULL,
              `total_days` int(11) NOT NULL DEFAULT 1,
              `purpose` varchar(255) NOT NULL,
              `location` varchar(255) DEFAULT NULL,
              `work_description` text DEFAULT NULL,
              `departure_time` time DEFAULT NULL,
              `return_time` time DEFAULT NULL,
              `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'approved',
              `assigned_by` varchar(64) DEFAULT NULL,
              `approved_by` varchar(64) DEFAULT NULL,
              `approved_at` datetime DEFAULT NULL,
              `rejection_reason` text DEFAULT NULL,
              `remarks` text DEFAULT NULL,
              `audit_history` longtext DEFAULT NULL,
              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
              `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
              PRIMARY KEY (`id`),
              KEY `idx_od_emp_id` (`emp_id`),
              KEY `idx_od_unit_id` (`unit_id`),
              KEY `idx_od_dates` (`start_date`,`end_date`),
              KEY `idx_od_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        } else {
            @$this->db->query("ALTER TABLE `pr_emp_od` MODIFY `location` varchar(255) NULL DEFAULT NULL");
            @$this->db->query("ALTER TABLE `pr_emp_od` MODIFY `work_description` text NULL DEFAULT NULL");
            @$this->db->query("ALTER TABLE `pr_emp_od` MODIFY `purpose` varchar(255) NOT NULL");
            @$this->db->query("ALTER TABLE `pr_emp_od` MODIFY `remarks` text NULL DEFAULT NULL");
            @$this->db->query("ALTER TABLE `pr_emp_od` MODIFY `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'approved'");
            @$this->db->query("ALTER TABLE `pr_emp_od` MODIFY `assigned_by` varchar(64) NULL DEFAULT NULL");
        }

        if (!$this->db->table_exists('pr_emp_od_dates')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `pr_emp_od_dates` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `od_id` int(11) NOT NULL,
              `emp_id` varchar(16) NOT NULL,
              `unit_id` int(11) NOT NULL DEFAULT 1,
              `od_date` date NOT NULL,
              `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'approved',
              `created_at` datetime NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id`),
              KEY `idx_odd_od_id` (`od_id`),
              KEY `idx_odd_emp_date` (`emp_id`,`od_date`),
              KEY `idx_odd_date_status` (`od_date`,`status`),
              KEY `idx_odd_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        } else {
            @$this->db->query("ALTER TABLE `pr_emp_od_dates` MODIFY `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'approved'");
        }
    }

    /**
     * Get units/branches
     */
    public function get_units()
    {
        return $this->db->order_by('unit_name', 'ASC')->get('pr_units')->result();
    }

    /**
     * Get departments
     */
    public function get_departments()
    {
        return $this->db->order_by('dept_name', 'ASC')->get('emp_depertment')->result();
    }

    /**
     * Get sections
     */
    public function get_sections()
    {
        return $this->db->order_by('sec_name_en', 'ASC')->get('emp_section')->result();
    }

    /**
     * Get designations
     */
    public function get_designations()
    {
        return $this->db->order_by('desig_name', 'ASC')->get('emp_designation')->result();
    }

    /**
     * Search active employees with flexible filtering
     */
    public function search_employees($search_term = '', $unit_id = null, $dept_id = null, $sec_id = null, $desig_id = null, $limit = 50)
    {
        $this->db->select('
            c.emp_id,
            c.unit_id,
            c.emp_dept_id,
            c.emp_sec_id,
            c.emp_desi_id,
            c.emp_shift,
            c.emp_join_date,
            p.name_en,
            p.name_bn,
            p.emp_dob,
            p.gender,
            p.blood,
            d.desig_name,
            dp.dept_name,
            s.sec_name_en,
            u.unit_name
        ');
        $this->db->from('pr_emp_com_info c');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'left');
        $this->db->join('emp_designation d', 'd.id = c.emp_desi_id', 'left');
        $this->db->join('emp_depertment dp', 'dp.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = c.unit_id', 'left');

        if (!empty($unit_id)) {
            $this->db->where('c.unit_id', $unit_id);
        }
        if (!empty($dept_id)) {
            $this->db->where('c.emp_dept_id', $dept_id);
        }
        if (!empty($sec_id)) {
            $this->db->where('c.emp_sec_id', $sec_id);
        }
        if (!empty($desig_id)) {
            $this->db->where('c.emp_desi_id', $desig_id);
        }

        if (!empty($search_term)) {
            $this->db->group_start();
            $this->db->like('c.emp_id', $search_term);
            $this->db->or_like('p.name_en', $search_term);
            $this->db->or_like('p.name_bn', $search_term);
            $this->db->group_end();
        }

        $this->db->order_by('c.emp_id', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    /**
     * Get single employee detailed info
     */
    public function get_employee_info($emp_id)
    {
        $this->db->select('
            c.emp_id,
            c.unit_id,
            c.emp_dept_id,
            c.emp_sec_id,
            c.emp_desi_id,
            c.emp_shift,
            c.emp_join_date,
            p.name_en,
            p.name_bn,
            p.gender,
            d.desig_name,
            dp.dept_name,
            s.sec_name_en,
            u.unit_name
        ');
        $this->db->from('pr_emp_com_info c');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'left');
        $this->db->join('emp_designation d', 'd.id = c.emp_desi_id', 'left');
        $this->db->join('emp_depertment dp', 'dp.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = c.unit_id', 'left');
        $this->db->where('c.emp_id', $emp_id);
        return $this->db->get()->row();
    }

    /**
     * Check for date conflicts (Leave, existing OD) for an employee
     */
    public function check_date_conflicts($emp_id, $dates = array(), $exclude_od_id = null)
    {
        $conflicts = array(
            'leaves' => array(),
            'existing_ods' => array()
        );

        if (empty($dates)) {
            return $conflicts;
        }

        // 1. Check Approved / Pending Leaves in pr_leave_trans
        foreach ($dates as $date) {
            $this->db->select('leave_type, leave_start, leave_end, start_date, status');
            $this->db->from('pr_leave_trans');
            $this->db->where('emp_id', $emp_id);
            $this->db->where("((leave_start <= '$date' AND leave_end >= '$date') OR start_date = '$date')");
            $this->db->where_in('status', array('approved', 'pending'));
            $lq = $this->db->get()->row();
            if ($lq) {
                $conflicts['leaves'][] = array(
                    'date'       => $date,
                    'leave_type' => strtoupper($lq->leave_type),
                    'status'     => ucfirst($lq->status)
                );
            }
        }

        // 2. Check Existing Approved / Pending OD in pr_emp_od_dates
        $this->db->select('d.od_date, d.status, o.purpose, o.location, o.id as od_id');
        $this->db->from('pr_emp_od_dates d');
        $this->db->join('pr_emp_od o', 'o.id = d.od_id', 'left');
        $this->db->where('d.emp_id', $emp_id);
        $this->db->where_in('d.od_date', $dates);
        $this->db->where_in('d.status', array('approved', 'pending'));
        if (!empty($exclude_od_id)) {
            $this->db->where('d.od_id !=', $exclude_od_id);
        }
        $existing = $this->db->get()->result();
        foreach ($existing as $ex) {
            $conflicts['existing_ods'][] = array(
                'date'     => $ex->od_date,
                'od_id'    => $ex->od_id,
                'purpose'  => $ex->purpose,
                'location' => $ex->location,
                'status'   => ucfirst($ex->status)
            );
        }

        return $conflicts;
    }

    /**
     * Create OD Assignment with child date records and audit log
     */
    public function create_assignment($data, $dates = array(), $username = 'admin')
    {
        $this->db->trans_start();

        $initial_audit = array(
            array(
                'action'    => 'created',
                'user'      => $username,
                'timestamp' => date('Y-m-d H:i:s'),
                'details'   => 'OD assignment created with ' . count($dates) . ' date(s).'
            )
        );

        $parent_data = array(
            'emp_id'           => $data['emp_id'],
            'unit_id'          => !empty($data['unit_id']) ? $data['unit_id'] : 1,
            'assignment_mode'  => !empty($data['assignment_mode']) ? $data['assignment_mode'] : 'range',
            'start_date'       => $data['start_date'],
            'end_date'         => $data['end_date'],
            'total_days'       => count($dates),
            'purpose'          => $data['purpose'],
            'location'         => !empty($data['location']) ? $data['location'] : null,
            'work_description' => !empty($data['work_description']) ? $data['work_description'] : null,
            'departure_time'   => !empty($data['departure_time']) ? $data['departure_time'] : null,
            'return_time'      => !empty($data['return_time']) ? $data['return_time'] : null,
            'status'           => !empty($data['status']) ? $data['status'] : 'pending',
            'assigned_by'      => $username,
            'approved_by'      => ($data['status'] === 'approved') ? $username : null,
            'approved_at'      => ($data['status'] === 'approved') ? date('Y-m-d H:i:s') : null,
            'remarks'          => !empty($data['remarks']) ? $data['remarks'] : null,
            'audit_history'    => json_encode($initial_audit),
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s')
        );

        $this->db->insert('pr_emp_od', $parent_data);
        $od_id = $this->db->insert_id();

        // Insert individual date records
        foreach ($dates as $d) {
            $date_row = array(
                'od_id'      => $od_id,
                'emp_id'     => $data['emp_id'],
                'unit_id'    => $parent_data['unit_id'],
                'od_date'    => $d,
                'status'     => $parent_data['status'],
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('pr_emp_od_dates', $date_row);
        }

        // If created directly with 'approved' status, synchronize attendance shift log immediately
        if ($parent_data['status'] === 'approved') {
            $this->sync_attendance_od($data['emp_id'], $dates, $parent_data['unit_id']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return $od_id;
    }

    /**
     * Update an existing OD assignment
     */
    public function update_assignment($id, $data, $dates = array(), $username = 'admin')
    {
        $existing = $this->get_od_by_id($id);
        if (!$existing) {
            return false;
        }

        $this->db->trans_start();

        // Build audit entry
        $history = !empty($existing->audit_history) ? json_decode($existing->audit_history, true) : array();
        $history[] = array(
            'action'    => 'modified',
            'user'      => $username,
            'timestamp' => date('Y-m-d H:i:s'),
            'details'   => 'Assignment modified. Dates: ' . implode(', ', $dates)
        );

        $target_status = !empty($data['status']) ? $data['status'] : 'approved';
        $update_data = array(
            'assignment_mode'  => !empty($data['assignment_mode']) ? $data['assignment_mode'] : $existing->assignment_mode,
            'start_date'       => $data['start_date'],
            'end_date'         => $data['end_date'],
            'total_days'       => count($dates),
            'purpose'          => $data['purpose'],
            'location'         => !empty($data['location']) ? $data['location'] : (isset($existing->location) ? $existing->location : null),
            'work_description' => !empty($data['work_description']) ? $data['work_description'] : (isset($existing->work_description) ? $existing->work_description : null),
            'departure_time'   => !empty($data['departure_time']) ? $data['departure_time'] : null,
            'return_time'      => !empty($data['return_time']) ? $data['return_time'] : null,
            'status'           => $target_status,
            'approved_by'      => ($target_status === 'approved' && empty($existing->approved_by)) ? $username : $existing->approved_by,
            'approved_at'      => ($target_status === 'approved' && empty($existing->approved_at)) ? date('Y-m-d H:i:s') : $existing->approved_at,
            'remarks'          => !empty($data['remarks']) ? $data['remarks'] : null,
            'audit_history'    => json_encode($history),
            'updated_at'       => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $this->db->update('pr_emp_od', $update_data);

        // Remove old dates
        $this->db->where('od_id', $id);
        $this->db->delete('pr_emp_od_dates');

        // Insert updated dates
        foreach ($dates as $d) {
            $date_row = array(
                'od_id'      => $id,
                'emp_id'     => $existing->emp_id,
                'unit_id'    => $existing->unit_id,
                'od_date'    => $d,
                'status'     => $target_status,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('pr_emp_od_dates', $date_row);
        }

        // Always sync attendance for approved OD
        if ($target_status === 'approved') {
            $this->sync_attendance_od($existing->emp_id, $dates, $existing->unit_id);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Approve OD Assignment
     */
    public function approve_assignment($id, $username = 'admin', $remarks = '')
    {
        $od = $this->get_od_by_id($id);
        if (!$od || $od->status === 'approved') {
            return false;
        }

        $this->db->trans_start();

        $history = !empty($od->audit_history) ? json_decode($od->audit_history, true) : array();
        $history[] = array(
            'action'    => 'approved',
            'user'      => $username,
            'timestamp' => date('Y-m-d H:i:s'),
            'details'   => !empty($remarks) ? "Approved: {$remarks}" : "Approved by {$username}"
        );

        $this->db->where('id', $id);
        $this->db->update('pr_emp_od', array(
            'status'        => 'approved',
            'approved_by'   => $username,
            'approved_at'   => date('Y-m-d H:i:s'),
            'remarks'       => !empty($remarks) ? $remarks : $od->remarks,
            'audit_history' => json_encode($history),
            'updated_at'    => date('Y-m-d H:i:s')
        ));

        // Update child dates
        $this->db->where('od_id', $id);
        $this->db->update('pr_emp_od_dates', array('status' => 'approved'));

        // Fetch all approved dates
        $dates_rows = $this->db->select('od_date')->where('od_id', $id)->get('pr_emp_od_dates')->result();
        $dates = array();
        foreach ($dates_rows as $dr) {
            $dates[] = $dr->od_date;
        }

        // Sync to pr_emp_shift_log
        $this->sync_attendance_od($od->emp_id, $dates, $od->unit_id);

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Reject OD Assignment
     */
    public function reject_assignment($id, $username = 'admin', $reason = '')
    {
        $od = $this->get_od_by_id($id);
        if (!$od) {
            return false;
        }

        $this->db->trans_start();

        $history = !empty($od->audit_history) ? json_decode($od->audit_history, true) : array();
        $history[] = array(
            'action'    => 'rejected',
            'user'      => $username,
            'timestamp' => date('Y-m-d H:i:s'),
            'details'   => "Rejected by {$username}. Reason: {$reason}"
        );

        $this->db->where('id', $id);
        $this->db->update('pr_emp_od', array(
            'status'           => 'rejected',
            'rejection_reason' => $reason,
            'audit_history'    => json_encode($history),
            'updated_at'       => date('Y-m-d H:i:s')
        ));

        $this->db->where('od_id', $id);
        $this->db->update('pr_emp_od_dates', array('status' => 'rejected'));

        // If previously approved, revert shift logs
        if ($od->status === 'approved') {
            $dates_rows = $this->db->select('od_date')->where('od_id', $id)->get('pr_emp_od_dates')->result();
            foreach ($dates_rows as $dr) {
                $this->revert_attendance_od($od->emp_id, $dr->od_date);
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Cancel OD Assignment
     */
    public function cancel_assignment($id, $username = 'admin', $reason = '')
    {
        $od = $this->get_od_by_id($id);
        if (!$od) {
            return false;
        }

        $this->db->trans_start();

        $history = !empty($od->audit_history) ? json_decode($od->audit_history, true) : array();
        $history[] = array(
            'action'    => 'cancelled',
            'user'      => $username,
            'timestamp' => date('Y-m-d H:i:s'),
            'details'   => "Cancelled by {$username}. Reason: {$reason}"
        );

        $this->db->where('id', $id);
        $this->db->update('pr_emp_od', array(
            'status'        => 'cancelled',
            'remarks'       => !empty($reason) ? "Cancelled: {$reason}" : $od->remarks,
            'audit_history' => json_encode($history),
            'updated_at'    => date('Y-m-d H:i:s')
        ));

        $this->db->where('od_id', $id);
        $this->db->update('pr_emp_od_dates', array('status' => 'cancelled'));

        // If previously approved, revert shift logs
        if ($od->status === 'approved') {
            $dates_rows = $this->db->select('od_date')->where('od_id', $id)->get('pr_emp_od_dates')->result();
            foreach ($dates_rows as $dr) {
                $this->revert_attendance_od($od->emp_id, $dr->od_date);
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Synchronize Approved OD status to pr_emp_shift_log
     * Preserves original punch-in and punch-out if they exist!
     */
    public function sync_attendance_od($emp_id, $dates = array(), $unit_id = 1)
    {
        if (empty($dates)) {
            return;
        }

        // Get employee shift/schedule defaults
        $emp = $this->db->select('emp_shift, unit_id')->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
        $shift_id = !empty($emp->emp_shift) ? $emp->emp_shift : 1;
        $unit_id  = !empty($emp->unit_id) ? $emp->unit_id : $unit_id;

        // Load Attn_process_model to process attendance immediately for each OD date
        $has_attn_model = false;
        if (file_exists(APPPATH . 'models/Attn_process_model.php')) {
            $this->load->model('Attn_process_model');
            $has_attn_model = true;
        }

        foreach ($dates as $date) {
            // Run core attendance process for this date and employee
            if ($has_attn_model && method_exists($this->Attn_process_model, 'attn_process')) {
                try {
                    $this->Attn_process_model->attn_process($date, $unit_id, array($emp_id));
                } catch (Exception $e) {
                    log_message('error', 'OD attendance process error: ' . $e->getMessage());
                }
            }

            // Ensure pr_emp_shift_log row has present_status = 'OD'
            $existing_log = $this->db->where('emp_id', $emp_id)
                                     ->where('shift_log_date', $date)
                                     ->get('pr_emp_shift_log')
                                     ->row();

            if ($existing_log) {
                // If on approved leave, leave takes precedence
                $has_leave = $this->db->where('emp_id', $emp_id)
                                      ->where("((leave_start <= '$date' AND leave_end >= '$date') OR start_date = '$date')")
                                      ->where('status', 'approved')
                                      ->get('pr_leave_trans')
                                      ->num_rows();
                if ($has_leave > 0) {
                    continue; // Preserve leave
                }

                // OD Policy: in time out time thakbe na, status a OD dekhabe, but present hisabe count hobe
                $update_data = array(
                    'in_time'        => '00:00:00',
                    'out_time'       => '00:00:00',
                    'tot'            => 0,
                    'ot'             => 0,
                    'eot'            => 0,
                    'ot_eot_12am'    => 0,
                    'ot_eot_4pm'     => 0,
                    'deduction_hour' => 0,
                    'present_status' => 'OD',
                    'late_status'    => 0,
                    'early_exit'     => 0
                );
                $this->db->where('id', $existing_log->id);
                $this->db->update('pr_emp_shift_log', $update_data);
            } else {
                // Insert a new log entry for this OD date so attendance records it immediately
                $insert_data = array(
                    'emp_id'         => $emp_id,
                    'unit_id'        => $unit_id,
                    'shift_id'       => $shift_id,
                    'schedule_id'    => 1,
                    'shift_log_date' => $date,
                    'in_time'        => '00:00:00',
                    'out_time'       => '00:00:00',
                    'tot'            => 0,
                    'ot'             => 0,
                    'eot'            => 0,
                    'ot_eot_12am'    => 0,
                    'ot_eot_4pm'     => 0,
                    'deduction_hour' => 0,
                    'late_status'    => 0,
                    'early_exit'     => 0,
                    'present_status' => 'OD'
                );
                $this->db->insert('pr_emp_shift_log', $insert_data);
            }
        }
    }

    /**
     * Revert attendance status from OD if assignment is rejected or cancelled
     */
    public function revert_attendance_od($emp_id, $date)
    {
        // Re-process attendance for that date so it reverts to natural punch / absent / leave
        if (file_exists(APPPATH . 'models/Attn_process_model.php')) {
            $this->load->model('Attn_process_model');
            $emp = $this->db->select('unit_id')->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
            $unit_id = !empty($emp->unit_id) ? $emp->unit_id : 1;
            try {
                $this->Attn_process_model->attn_process($date, $unit_id, array($emp_id));
                return;
            } catch (Exception $e) {
                // fallback
            }
        }

        $log = $this->db->where('emp_id', $emp_id)
                        ->where('shift_log_date', $date)
                        ->get('pr_emp_shift_log')
                        ->row();

        if ($log && $log->present_status === 'OD') {
            $has_in  = (!empty($log->in_time) && $log->in_time != '00:00:00');
            $has_out = (!empty($log->out_time) && $log->out_time != '00:00:00');
            $new_status = ($has_in || $has_out) ? 'P' : 'A';
            $this->db->where('id', $log->id);
            $this->db->update('pr_emp_shift_log', array('present_status' => $new_status));
        }
    }

    /**
     * Fast check if employee is on approved OD on a given date
     * Used by Attn_process_model, Job_card_model, and reports
     */
    public function is_employee_on_od($emp_id, $date)
    {
        $count = $this->db->where('emp_id', $emp_id)
                          ->where('od_date', $date)
                          ->where('status', 'approved')
                          ->count_all_results('pr_emp_od_dates');
        return ($count > 0);
    }

    /**
     * Get single OD assignment by ID with child dates
     */
    public function get_od_by_id($id)
    {
        $this->db->select('
            o.*,
            p.name_en,
            p.name_bn,
            d.desig_name,
            dp.dept_name,
            s.sec_name_en,
            u.unit_name
        ');
        $this->db->from('pr_emp_od o');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = o.emp_id', 'left');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = o.emp_id', 'left');
        $this->db->join('emp_designation d', 'd.id = c.emp_desi_id', 'left');
        $this->db->join('emp_depertment dp', 'dp.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = o.unit_id', 'left');
        $this->db->where('o.id', $id);
        $od = $this->db->get()->row();

        if ($od) {
            $dates_query = $this->db->order_by('od_date', 'ASC')->where('od_id', $id)->get('pr_emp_od_dates')->result();
            $od->dates_list = array();
            foreach ($dates_query as $dq) {
                $od->dates_list[] = $dq->od_date;
            }
        }

        return $od;
    }

    /**
     * Get Dashboard Statistics
     */
    public function get_dashboard_stats($unit_id = null)
    {
        $today = date('Y-m-d');

        // 1. Today's Total Approved OD Employees
        $this->db->select('COUNT(DISTINCT emp_id) as total_today');
        $this->db->from('pr_emp_od_dates');
        $this->db->where('od_date', $today);
        $this->db->where('status', 'approved');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $r1 = $this->db->get()->row();
        $today_total = $r1 ? (int)$r1->total_today : 0;

        // 2. Pending Applications
        $this->db->where('status', 'pending');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $pending_count = $this->db->count_all_results('pr_emp_od');

        // 3. Approved Applications
        $this->db->where('status', 'approved');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $approved_count = $this->db->count_all_results('pr_emp_od');

        // 4. Rejected Applications
        $this->db->where('status', 'rejected');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $rejected_count = $this->db->count_all_results('pr_emp_od');

        // 5. Upcoming OD Assignments (starting after today and approved)
        $this->db->where('start_date >', $today);
        $this->db->where('status', 'approved');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $upcoming_count = $this->db->count_all_results('pr_emp_od');

        // 6. Today's OD Employees Detailed List
        $this->db->select('
            d.od_date,
            o.id as od_id,
            o.emp_id,
            o.purpose,
            o.location,
            o.departure_time,
            o.return_time,
            o.status,
            p.name_en,
            des.desig_name,
            dep.dept_name,
            u.unit_name,
            log.in_time,
            log.out_time,
            log.present_status as attendance_status
        ');
        $this->db->from('pr_emp_od_dates d');
        $this->db->join('pr_emp_od o', 'o.id = d.od_id', 'inner');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = d.emp_id', 'left');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = d.emp_id', 'left');
        $this->db->join('emp_designation des', 'des.id = c.emp_desi_id', 'left');
        $this->db->join('emp_depertment dep', 'dep.dept_id = c.emp_dept_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = d.unit_id', 'left');
        $this->db->join('pr_emp_shift_log log', 'log.emp_id = d.emp_id AND log.shift_log_date = d.od_date', 'left');
        $this->db->where('d.od_date', $today);
        $this->db->where('d.status', 'approved');
        if (!empty($unit_id)) {
            $this->db->where('d.unit_id', $unit_id);
        }
        $this->db->order_by('d.emp_id', 'ASC');
        $today_list = $this->db->get()->result();

        return array(
            'today_total'    => $today_total,
            'pending_count'  => $pending_count,
            'approved_count' => $approved_count,
            'rejected_count' => $rejected_count,
            'upcoming_count' => $upcoming_count,
            'today_list'     => $today_list
        );
    }

    /**
     * Get paginated OD list with dynamic filters
     */
    public function get_od_list($filters = array(), $limit = 20, $offset = 0)
    {
        $this->build_od_filter_query($filters);
        $total_rows = $this->db->count_all_results();

        $this->build_od_filter_query($filters);
        $this->db->select('
            o.*,
            p.name_en,
            des.desig_name,
            dep.dept_name,
            sec.sec_name_en,
            u.unit_name
        ');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = o.emp_id', 'left');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = o.emp_id', 'left');
        $this->db->join('emp_designation des', 'des.id = c.emp_desi_id', 'left');
        $this->db->join('emp_depertment dep', 'dep.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section sec', 'sec.id = c.emp_sec_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = o.unit_id', 'left');
        $this->db->order_by('o.id', 'DESC');
        $this->db->limit($limit, $offset);
        $records = $this->db->get()->result();

        // Attach specific dates array for each record
        if (!empty($records)) {
            $od_ids = array();
            foreach ($records as $r) {
                $od_ids[] = $r->id;
            }
            $dates_query = $this->db->where_in('od_id', $od_ids)->order_by('od_date', 'ASC')->get('pr_emp_od_dates')->result();
            $dates_map = array();
            foreach ($dates_query as $dq) {
                $dates_map[$dq->od_id][] = $dq->od_date;
            }
            foreach ($records as &$rec) {
                $rec->dates_list = isset($dates_map[$rec->id]) ? $dates_map[$rec->id] : array();
            }
        }

        return array(
            'total'   => $total_rows,
            'records' => $records
        );
    }

    /**
     * Helper to build filter query for OD assignments
     */
    private function build_od_filter_query($filters = array())
    {
        $this->db->from('pr_emp_od o');

        if (!empty($filters['unit_id'])) {
            $this->db->where('o.unit_id', $filters['unit_id']);
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $this->db->where('o.status', $filters['status']);
        }

        if (!empty($filters['purpose']) && $filters['purpose'] !== 'all') {
            $this->db->where('o.purpose', $filters['purpose']);
        }

        if (!empty($filters['emp_id'])) {
            $this->db->group_start();
            $this->db->like('o.emp_id', $filters['emp_id']);
            $this->db->group_end();
        }

        if (!empty($filters['dept_id'])) {
            $this->db->join('pr_emp_com_info c_f', 'c_f.emp_id = o.emp_id', 'left');
            $this->db->where('c_f.emp_dept_id', $filters['dept_id']);
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $from = $filters['from_date'];
            $to   = $filters['to_date'];
            $this->db->where("((o.start_date BETWEEN '$from' AND '$to') OR (o.end_date BETWEEN '$from' AND '$to') OR ('$from' BETWEEN o.start_date AND o.end_date))");
        } elseif (!empty($filters['from_date'])) {
            $this->db->where('o.end_date >=', $filters['from_date']);
        } elseif (!empty($filters['to_date'])) {
            $this->db->where('o.start_date <=', $filters['to_date']);
        }
    }

    /**
     * Get Report Data (Daily, Monthly, Employee History, Department, Branch)
     */
    public function get_reports_data($report_type = 'daily', $filters = array())
    {
        switch ($report_type) {
            case 'daily':
                $date = !empty($filters['date']) ? $filters['date'] : date('Y-m-d');
                $this->db->select('
                    d.od_date,
                    d.status as date_status,
                    o.id as od_id,
                    o.emp_id,
                    o.purpose,
                    o.location,
                    o.work_description,
                    o.departure_time,
                    o.return_time,
                    o.assigned_by,
                    o.approved_by,
                    p.name_en,
                    des.desig_name,
                    dep.dept_name,
                    sec.sec_name_en,
                    u.unit_name,
                    log.in_time,
                    log.out_time,
                    log.present_status as attendance_status
                ');
                $this->db->from('pr_emp_od_dates d');
                $this->db->join('pr_emp_od o', 'o.id = d.od_id', 'inner');
                $this->db->join('pr_emp_per_info p', 'p.emp_id = d.emp_id', 'left');
                $this->db->join('pr_emp_com_info c', 'c.emp_id = d.emp_id', 'left');
                $this->db->join('emp_designation des', 'des.id = c.emp_desi_id', 'left');
                $this->db->join('emp_depertment dep', 'dep.dept_id = c.emp_dept_id', 'left');
                $this->db->join('emp_section sec', 'sec.id = c.emp_sec_id', 'left');
                $this->db->join('pr_units u', 'u.unit_id = d.unit_id', 'left');
                $this->db->join('pr_emp_shift_log log', 'log.emp_id = d.emp_id AND log.shift_log_date = d.od_date', 'left');
                $this->db->where('d.od_date', $date);
                if (!empty($filters['status']) && $filters['status'] !== 'all') {
                    $this->db->where('d.status', $filters['status']);
                }
                if (!empty($filters['unit_id'])) {
                    $this->db->where('d.unit_id', $filters['unit_id']);
                }
                if (!empty($filters['dept_id'])) {
                    $this->db->where('c.emp_dept_id', $filters['dept_id']);
                }
                $this->db->order_by('d.emp_id', 'ASC');
                return $this->db->get()->result();

            case 'monthly':
                $year_month = !empty($filters['month']) ? $filters['month'] : date('Y-m');
                $from = $year_month . '-01';
                $to   = date('Y-m-t', strtotime($from));

                $this->db->select('
                    d.emp_id,
                    p.name_en,
                    des.desig_name,
                    dep.dept_name,
                    u.unit_name,
                    COUNT(DISTINCT d.od_date) as total_od_days,
                    GROUP_CONCAT(DISTINCT d.od_date ORDER BY d.od_date ASC SEPARATOR ", ") as od_dates
                ');
                $this->db->from('pr_emp_od_dates d');
                $this->db->join('pr_emp_per_info p', 'p.emp_id = d.emp_id', 'left');
                $this->db->join('pr_emp_com_info c', 'c.emp_id = d.emp_id', 'left');
                $this->db->join('emp_designation des', 'des.id = c.emp_desi_id', 'left');
                $this->db->join('emp_depertment dep', 'dep.dept_id = c.emp_dept_id', 'left');
                $this->db->join('pr_units u', 'u.unit_id = d.unit_id', 'left');
                $this->db->where("d.od_date BETWEEN '$from' AND '$to'");
                $this->db->where('d.status', 'approved');
                if (!empty($filters['unit_id'])) {
                    $this->db->where('d.unit_id', $filters['unit_id']);
                }
                if (!empty($filters['dept_id'])) {
                    $this->db->where('c.emp_dept_id', $filters['dept_id']);
                }
                $this->db->group_by('d.emp_id');
                $this->db->order_by('total_od_days', 'DESC');
                return $this->db->get()->result();

            case 'employee':
                $emp_id = !empty($filters['emp_id']) ? $filters['emp_id'] : '';
                if (empty($emp_id)) {
                    return array();
                }
                $this->db->select('
                    d.od_date,
                    d.status as date_status,
                    o.id as od_id,
                    o.purpose,
                    o.location,
                    o.work_description,
                    o.departure_time,
                    o.return_time,
                    o.assigned_by,
                    o.approved_by,
                    o.approved_at,
                    p.name_en,
                    des.desig_name,
                    dep.dept_name,
                    u.unit_name,
                    log.in_time,
                    log.out_time,
                    log.present_status as attendance_status
                ');
                $this->db->from('pr_emp_od_dates d');
                $this->db->join('pr_emp_od o', 'o.id = d.od_id', 'inner');
                $this->db->join('pr_emp_per_info p', 'p.emp_id = d.emp_id', 'left');
                $this->db->join('pr_emp_com_info c', 'c.emp_id = d.emp_id', 'left');
                $this->db->join('emp_designation des', 'des.id = c.emp_desi_id', 'left');
                $this->db->join('emp_depertment dep', 'dep.dept_id = c.emp_dept_id', 'left');
                $this->db->join('pr_units u', 'u.unit_id = d.unit_id', 'left');
                $this->db->join('pr_emp_shift_log log', 'log.emp_id = d.emp_id AND log.shift_log_date = d.od_date', 'left');
                $this->db->where('d.emp_id', $emp_id);
                if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                    $this->db->where("d.od_date BETWEEN '{$filters['from_date']}' AND '{$filters['to_date']}'");
                }
                $this->db->order_by('d.od_date', 'DESC');
                return $this->db->get()->result();

            case 'department':
                $from = !empty($filters['from_date']) ? $filters['from_date'] : date('Y-m-01');
                $to   = !empty($filters['to_date']) ? $filters['to_date'] : date('Y-m-t');

                $this->db->select('
                    dep.dept_id,
                    IFNULL(dep.dept_name, "Unassigned") as dept_name,
                    COUNT(DISTINCT d.emp_id) as total_employees,
                    COUNT(DISTINCT d.emp_id) as emp_count,
                    COUNT(d.id) as total_od_days
                ');
                $this->db->from('pr_emp_od_dates d');
                $this->db->join('pr_emp_com_info c', 'c.emp_id = d.emp_id', 'left');
                $this->db->join('emp_depertment dep', 'dep.dept_id = c.emp_dept_id', 'left');
                $this->db->where("d.od_date BETWEEN '$from' AND '$to'");
                $this->db->where('d.status', 'approved');
                if (!empty($filters['unit_id'])) {
                    $this->db->where('d.unit_id', $filters['unit_id']);
                }
                $this->db->group_by('c.emp_dept_id');
                $this->db->order_by('total_od_days', 'DESC');
                return $this->db->get()->result();

            case 'branch':
                $from = !empty($filters['from_date']) ? $filters['from_date'] : date('Y-m-01');
                $to   = !empty($filters['to_date']) ? $filters['to_date'] : date('Y-m-t');

                $this->db->select('
                    u.unit_id,
                    IFNULL(u.unit_name, "Head Office") as unit_name,
                    COUNT(DISTINCT d.emp_id) as total_employees,
                    COUNT(DISTINCT d.emp_id) as emp_count,
                    COUNT(d.id) as total_od_days
                ');
                $this->db->from('pr_emp_od_dates d');
                $this->db->join('pr_units u', 'u.unit_id = d.unit_id', 'left');
                $this->db->where("d.od_date BETWEEN '$from' AND '$to'");
                $this->db->where('d.status', 'approved');
                $this->db->group_by('d.unit_id');
                $this->db->order_by('total_od_days', 'DESC');
                return $this->db->get()->result();
        }

        return array();
    }
}

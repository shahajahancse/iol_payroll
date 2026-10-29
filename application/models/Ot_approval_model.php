<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ot_approval_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->ensure_table_exists();
    }

    /**
     * Ensure pr_daily_ot_approval table exists
     */
    public function ensure_table_exists()
    {
        if (!$this->db->table_exists('pr_daily_ot_approval')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `pr_daily_ot_approval` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `emp_id` varchar(64) NOT NULL,
                  `unit_id` int(11) NOT NULL DEFAULT 1,
                  `ot_date` date NOT NULL,
                  `shift_id` int(11) DEFAULT NULL,
                  `in_time` time DEFAULT NULL,
                  `out_time` time DEFAULT NULL,
                  `regular_hours` decimal(5,2) NOT NULL DEFAULT 8.00,
                  `actual_ot_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
                  `calculated_ot_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
                  `approved_ot_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
                  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
                  `admin_remarks` text DEFAULT NULL,
                  `modification_reason` text DEFAULT NULL,
                  `rejection_reason` text DEFAULT NULL,
                  `approved_by` varchar(100) DEFAULT NULL,
                  `action_at` datetime DEFAULT NULL,
                  `attendance_modified_flag` tinyint(1) NOT NULL DEFAULT 0,
                  `audit_history` longtext DEFAULT NULL,
                  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `uq_emp_ot_date` (`emp_id`, `ot_date`),
                  KEY `idx_ot_date` (`ot_date`),
                  KEY `idx_status` (`status`),
                  KEY `idx_unit_id` (`unit_id`),
                  KEY `idx_emp_id` (`emp_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ");
        }
    }

    /**
     * Determine regular working hours from shift schedule or name
     */
    public function get_regular_hours_by_shift($shift_id, $shift_name = '')
    {
        $name = strtolower(trim($shift_name));
        if (strpos($name, '12') !== false) {
            return 12.00;
        }
        return 8.00;
    }

    /**
     * Automatic or manual generation/refresh of Daily OT List for a given date
     * 
     * Identifies employees meeting BOTH conditions:
     * 1. Marked OT Eligible (ot_entitle == 0 or com_ot_entitle == 0) in Entry System.
     * 2. Has actual overtime recorded in pr_emp_shift_log (tot > 0 OR ot > 0 OR eot > 0).
     * 
     * Excludes:
     * - Ineligible employees (ot_entitle == 1)
     * - Employees with 0 OT
     * - Incomplete/invalid punch (missing in_time or out_time or in_time == out_time)
     * - Duplicates (enforced by UNIQUE KEY emp_id, ot_date)
     * 
     * Safe handling for existing records:
     * - Pending: updates attendance, actual OT, and calculated OT.
     * - Approved/Rejected: DOES NOT overwrite approved hours or status. If attendance changed,
     *   sets attendance_modified_flag = 1, updates actual_ot_hours, and logs to audit history.
     */
    public function generate_or_sync_daily_ot($start_date, $end_date = null, $unit_id = null)
    {
        $this->ensure_table_exists();

        // If 2nd parameter is actually unit_id (numeric or not a valid date format)
        if ($unit_id === null && !empty($end_date) && (is_numeric($end_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($end_date)))) {
            $unit_id = (int)$end_date;
            $end_date = $start_date;
        }

        if (empty($end_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($end_date))) {
            $end_date = $start_date;
        }

        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date   = date('Y-m-d', strtotime($end_date));

        // Query eligible employees with actual overtime in pr_emp_shift_log
        $this->db->select('
            s.emp_id,
            s.unit_id,
            s.shift_id,
            s.shift_log_date,
            s.in_time,
            s.out_time,
            s.ot,
            s.eot,
            s.tot,
            s.present_status,
            c.ot_entitle,
            c.com_ot_entitle,
            sh.shift_name
        ');
        $this->db->from('pr_emp_shift_log s');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = s.emp_id', 'inner');
        $this->db->join('pr_emp_shift sh', 'sh.id = s.shift_id', 'left');
        if ($start_date === $end_date) {
            $this->db->where('s.shift_log_date', $start_date);
        } else {
            $this->db->where('s.shift_log_date >=', $start_date);
            $this->db->where('s.shift_log_date <=', $end_date);
        }

        // Condition 1: OT Eligible (ot_entitle == 0 or com_ot_entitle == 0)
        $this->db->where('(c.ot_entitle = 0 OR c.com_ot_entitle = 0)');

        // Condition 2: Actual OT recorded (tot > 0 OR ot > 0 OR eot > 0)
        $this->db->where('(s.tot > 0 OR s.ot > 0 OR s.eot > 0)');

        // Condition 3: Complete and valid attendance punches
        $this->db->where('s.in_time IS NOT NULL');
        $this->db->where('s.out_time IS NOT NULL');
        $this->db->where("s.in_time != '00:00:00'");
        $this->db->where("s.out_time != '00:00:00'");
        $this->db->where("s.in_time != s.out_time");

        if (!empty($unit_id)) {
            $this->db->where('s.unit_id', $unit_id);
        }

        $query = $this->db->get();
        $records = $query->result();

        $inserted_count = 0;
        $updated_count = 0;
        $flagged_count = 0;

        foreach ($records as $row) {
            $emp_id = $row->emp_id;
            $row_unit = !empty($row->unit_id) ? $row->unit_id : 1;

            // Calculate actual OT hours
            $actual_ot = ($row->tot > 0) ? (float)$row->tot : ((float)$row->ot + (float)$row->eot);
            if ($actual_ot <= 0) {
                continue;
            }

            $regular_hours = $this->get_regular_hours_by_shift($row->shift_id, $row->shift_name);
            $row_date = $row->shift_log_date;

            // Check if record already exists
            $existing = $this->db->where('emp_id', $emp_id)
                                 ->where('ot_date', $row_date)
                                 ->get('pr_daily_ot_approval')
                                 ->row();

            $now_dt = date('Y-m-d H:i:s');

            if (!$existing) {
                // New record insertion
                $audit = array(
                    array(
                        'action'      => 'generated',
                        'timestamp'   => $now_dt,
                        'by'          => 'system',
                        'actual_ot'   => $actual_ot,
                        'in_time'     => $row->in_time,
                        'out_time'    => $row->out_time,
                        'status'      => 'pending'
                    )
                );

                $insert_data = array(
                    'emp_id'                  => $emp_id,
                    'unit_id'                 => $row_unit,
                    'ot_date'                 => $row_date,
                    'shift_id'                => $row->shift_id,
                    'in_time'                 => $row->in_time,
                    'out_time'                => $row->out_time,
                    'regular_hours'           => $regular_hours,
                    'actual_ot_hours'         => $actual_ot,
                    'calculated_ot_hours'     => $actual_ot,
                    'approved_ot_hours'       => $actual_ot, // Pre-fills calculated hours for review
                    'status'                  => 'pending',
                    'attendance_modified_flag'=> 0,
                    'audit_history'           => json_encode($audit),
                    'created_at'              => $now_dt,
                    'updated_at'              => $now_dt
                );

                $this->db->insert('pr_daily_ot_approval', $insert_data);
                $inserted_count++;
            } else {
                // Existing record handling
                $audit_trail = !empty($existing->audit_history) ? json_decode($existing->audit_history, true) : array();
                if (!is_array($audit_trail)) {
                    $audit_trail = array();
                }

                if ($existing->status === 'pending') {
                    // Update pending record to latest attendance calculation
                    $changed = ($existing->actual_ot_hours != $actual_ot || $existing->in_time != $row->in_time || $existing->out_time != $row->out_time);
                    if ($changed) {
                        $audit_trail[] = array(
                            'action'     => 'refreshed_pending',
                            'timestamp'  => $now_dt,
                            'by'         => 'system',
                            'old_actual' => (float)$existing->actual_ot_hours,
                            'new_actual' => $actual_ot
                        );
                    }

                    $this->db->where('id', $existing->id)->update('pr_daily_ot_approval', array(
                        'shift_id'            => $row->shift_id,
                        'in_time'             => $row->in_time,
                        'out_time'            => $row->out_time,
                        'regular_hours'       => $regular_hours,
                        'actual_ot_hours'     => $actual_ot,
                        'calculated_ot_hours' => $actual_ot,
                        'approved_ot_hours'   => $actual_ot,
                        'audit_history'       => json_encode($audit_trail),
                        'updated_at'          => $now_dt
                    ));
                    $updated_count++;
                } else {
                    // Already Approved or Rejected: DO NOT silently overwrite approved hours or status!
                    if ((float)$existing->actual_ot_hours != (float)$actual_ot) {
                        $audit_trail[] = array(
                            'action'     => 'attendance_changed_after_decision',
                            'timestamp'  => $now_dt,
                            'by'         => 'system',
                            'old_actual' => (float)$existing->actual_ot_hours,
                            'new_actual' => $actual_ot,
                            'note'       => 'Attendance recalculated after ' . $existing->status . ' status was set'
                        );

                        $this->db->where('id', $existing->id)->update('pr_daily_ot_approval', array(
                            'actual_ot_hours'          => $actual_ot,
                            'in_time'                  => $row->in_time,
                            'out_time'                 => $row->out_time,
                            'attendance_modified_flag' => 1,
                            'audit_history'            => json_encode($audit_trail),
                            'updated_at'               => $now_dt
                        ));
                        $flagged_count++;
                    }
                }
            }
        }

        return array(
            'inserted'       => $inserted_count,
            'updated'        => $updated_count,
            'flagged_review' => $flagged_count,
            'total_found'    => count($records)
        );
    }

    /**
     * Get dashboard summary cards statistics
     */
    public function get_admin_stats($start_date, $end_date = null, $unit_id = null)
    {
        $this->ensure_table_exists();

        // If 2nd parameter is actually unit_id (numeric or not a valid date format)
        if ($unit_id === null && !empty($end_date) && (is_numeric($end_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($end_date)))) {
            $unit_id = (int)$end_date;
            $end_date = $start_date;
        }

        if (empty($end_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($end_date))) {
            $end_date = $start_date;
        }

        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date   = date('Y-m-d', strtotime($end_date));

        // Total OT Eligible Employees
        $this->db->from('pr_emp_com_info');
        $this->db->where('(ot_entitle = 0 OR com_ot_entitle = 0)');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $total_eligible = $this->db->count_all_results();

        // Employees with Actual OT in this date range
        $this->db->select('COUNT(DISTINCT s.emp_id) as actual_emp_count');
        $this->db->from('pr_emp_shift_log s');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = s.emp_id', 'inner');
        if ($start_date === $end_date) {
            $this->db->where('s.shift_log_date', $start_date);
        } else {
            $this->db->where('s.shift_log_date >=', $start_date);
            $this->db->where('s.shift_log_date <=', $end_date);
        }
        $this->db->where('(c.ot_entitle = 0 OR c.com_ot_entitle = 0)');
        $this->db->where('(s.tot > 0 OR s.ot > 0 OR s.eot > 0)');
        $this->db->where('s.in_time IS NOT NULL AND s.out_time IS NOT NULL AND s.in_time != "00:00:00" AND s.out_time != "00:00:00" AND s.in_time != s.out_time');
        if (!empty($unit_id)) {
            $this->db->where('s.unit_id', $unit_id);
        }
        $actual_emp_row = $this->db->get()->row();
        $with_actual_ot = $actual_emp_row ? (int)$actual_emp_row->actual_emp_count : 0;

        // Approval status stats from pr_daily_ot_approval
        $this->db->select('
            COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count,
            COUNT(CASE WHEN status = "approved" THEN 1 END) as approved_count,
            COUNT(CASE WHEN status = "rejected" THEN 1 END) as rejected_count,
            COALESCE(SUM(CASE WHEN status = "approved" THEN approved_ot_hours ELSE 0 END), 0) as total_approved_hours,
            COALESCE(SUM(actual_ot_hours), 0) as total_actual_hours,
            COUNT(CASE WHEN attendance_modified_flag = 1 THEN 1 END) as flagged_count
        ');
        $this->db->from('pr_daily_ot_approval');
        if ($start_date === $end_date) {
            $this->db->where('ot_date', $start_date);
        } else {
            $this->db->where('ot_date >=', $start_date);
            $this->db->where('ot_date <=', $end_date);
        }
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $query = $this->db->get();
        $stat = $query->row();

        return array(
            'total_eligible'       => (int)$total_eligible,
            'with_actual_ot'       => (int)$with_actual_ot,
            'pending_count'        => (int)($stat ? $stat->pending_count : 0),
            'approved_count'       => (int)($stat ? $stat->approved_count : 0),
            'rejected_count'       => (int)($stat ? $stat->rejected_count : 0),
            'total_approved_hours' => round((float)($stat ? $stat->total_approved_hours : 0), 2),
            'total_actual_hours'   => round((float)($stat ? $stat->total_actual_hours : 0), 2),
            'flagged_count'        => (int)($stat ? $stat->flagged_count : 0)
        );
    }

    /**
     * Get filtered, paginated OT list for Admin table
     */
    public function get_admin_ot_list($params = array())
    {
        $this->ensure_table_exists();

        $start_date = !empty($params['start_date']) ? $params['start_date'] : (!empty($params['ot_date']) ? $params['ot_date'] : date('Y-m-d'));
        $end_date   = !empty($params['end_date']) ? $params['end_date'] : $start_date;
        $unit_id   = !empty($params['unit_id']) ? $params['unit_id'] : null;
        $search    = !empty($params['search']) ? trim($params['search']) : null;
        $dept_id   = !empty($params['dept_id']) ? $params['dept_id'] : null;
        $sec_id    = !empty($params['sec_id']) ? $params['sec_id'] : null;
        $desig_id  = !empty($params['desig_id']) ? $params['desig_id'] : null;
        $shift_id  = !empty($params['shift_id']) ? $params['shift_id'] : null;
        $status    = !empty($params['status']) ? $params['status'] : 'all';
        $limit     = isset($params['limit']) ? (int)$params['limit'] : 25;
        $offset    = isset($params['offset']) ? (int)$params['offset'] : 0;
        $sort_col  = !empty($params['sort_col']) ? $params['sort_col'] : ($start_date !== $end_date ? 'o.ot_date' : 'o.id');
        $sort_dir  = !empty($params['sort_dir']) && strtolower($params['sort_dir']) === 'asc' ? 'ASC' : 'DESC';

        $apply_filters = function($builder) use ($start_date, $end_date, $unit_id, $search, $dept_id, $sec_id, $desig_id, $shift_id, $status) {
            if ($start_date === $end_date) {
                $builder->where('o.ot_date', $start_date);
            } else {
                $builder->where('o.ot_date >=', $start_date);
                $builder->where('o.ot_date <=', $end_date);
            }

            if (!empty($unit_id)) {
                $builder->where('o.unit_id', $unit_id);
            }

            if (!empty($status) && $status !== 'all') {
                if ($status === 'actual_ot') {
                    $builder->where('o.actual_ot_hours >', 0);
                } else {
                    $builder->where('o.status', $status);
                }
            }

            if (!empty($dept_id)) {
                $builder->where('c.emp_dept_id', $dept_id);
            }

            if (!empty($sec_id)) {
                $builder->where('c.emp_sec_id', $sec_id);
            }

            if (!empty($desig_id)) {
                $builder->where('c.emp_desi_id', $desig_id);
            }

            if (!empty($shift_id)) {
                $builder->where('o.shift_id', $shift_id);
            }

            if (!empty($search)) {
                $builder->group_start();
                $builder->like('o.emp_id', $search);
                $builder->or_like('p.name_en', $search);
                $builder->or_like('p.name_bn', $search);
                $builder->group_end();
            }
        };

        // Total count query
        $this->db->from('pr_daily_ot_approval o');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = o.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = o.emp_id', 'left');
        $apply_filters($this->db);
        $total_rows = $this->db->count_all_results();

        // Data query
        $this->db->select('
            o.id,
            o.emp_id,
            o.unit_id,
            o.ot_date,
            o.shift_id,
            o.in_time,
            o.out_time,
            o.regular_hours,
            o.actual_ot_hours,
            o.calculated_ot_hours,
            o.approved_ot_hours,
            o.status,
            o.admin_remarks,
            o.modification_reason,
            o.rejection_reason,
            o.approved_by,
            o.action_at,
            o.attendance_modified_flag,
            o.audit_history,
            p.name_en as emp_name,
            p.name_bn as emp_name_bn,
            d.dept_name,
            s.sec_name_en as sec_name,
            dg.desig_name,
            sh.shift_name
        ');
        $this->db->from('pr_daily_ot_approval o');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = o.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = o.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('emp_designation dg', 'dg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_emp_shift sh', 'sh.id = o.shift_id', 'left');

        $apply_filters($this->db);

        // Map allowed sort columns
        $allowed_sorts = array(
            'id'                  => 'o.id',
            'emp_id'              => 'o.emp_id',
            'ot_date'             => 'o.ot_date',
            'date'                => 'o.ot_date',
            'name'                => 'p.name_en',
            'dept_name'           => 'd.dept_name',
            'desig_name'          => 'dg.desig_name',
            'in_time'             => 'o.in_time',
            'out_time'            => 'o.out_time',
            'actual_ot_hours'     => 'o.actual_ot_hours',
            'approved_ot_hours'   => 'o.approved_ot_hours',
            'status'              => 'o.status'
        );
        $sort_field = isset($allowed_sorts[$sort_col]) ? $allowed_sorts[$sort_col] : 'o.id';
        $this->db->order_by($sort_field, $sort_dir);

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        $records = $this->db->get()->result();

        return array(
            'records'    => $records,
            'total_rows' => $total_rows,
            'limit'      => $limit,
            'offset'     => $offset
        );
    }

    /**
     * Get single record by ID
     */
    public function get_record_by_id($id)
    {
        $this->db->select('
            o.*,
            p.name_en as emp_name,
            p.name_bn as emp_name_bn,
            d.dept_name,
            s.sec_name_en as sec_name,
            dg.desig_name,
            sh.shift_name
        ');
        $this->db->from('pr_daily_ot_approval o');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = o.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = o.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('emp_designation dg', 'dg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_emp_shift sh', 'sh.id = o.shift_id', 'left');
        $this->db->where('o.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Approve OT for single record
     */
    public function approve_ot($id, $approved_hours, $admin_id, $remarks = '')
    {
        $record = $this->get_record_by_id($id);
        if (!$record) {
            return array('status' => false, 'message' => 'Record not found.');
        }

        $approved_hours = round((float)$approved_hours, 2);
        if ($approved_hours < 0) {
            return array('status' => false, 'message' => 'Approved OT hours cannot be negative.');
        }

        if ($approved_hours > (float)$record->actual_ot_hours) {
            return array('status' => false, 'message' => 'Approved OT hours cannot exceed actual OT hours (' . $record->actual_ot_hours . ' hrs).');
        }

        $now_dt = date('Y-m-d H:i:s');
        $audit_trail = !empty($record->audit_history) ? json_decode($record->audit_history, true) : array();
        if (!is_array($audit_trail)) {
            $audit_trail = array();
        }

        $audit_trail[] = array(
            'action'         => 'approved',
            'timestamp'      => $now_dt,
            'by'             => $admin_id,
            'approved_hours' => $approved_hours,
            'remarks'        => $remarks,
            'previous_status'=> $record->status
        );

        $update_data = array(
            'approved_ot_hours'        => $approved_hours,
            'status'                   => 'approved',
            'admin_remarks'            => $remarks,
            'approved_by'              => $admin_id,
            'action_at'                => $now_dt,
            'attendance_modified_flag' => 0, // Cleared on fresh approval
            'audit_history'            => json_encode($audit_trail),
            'updated_at'               => $now_dt
        );

        $this->db->where('id', $id)->update('pr_daily_ot_approval', $update_data);

        // Synchronize approved OT directly to pr_emp_shift_log so Actual Job Card shows approved OT in OT column
        $this->sync_approved_ot_to_shift_log($record->emp_id, $record->ot_date, $approved_hours, 'approved');

        return array('status' => true, 'message' => 'OT successfully approved for Employee ' . $record->emp_id . '.');
    }

    /**
     * Modify OT hours (e.g. approve fewer hours with optional reason)
     */
    public function modify_ot_hours($id, $approved_hours, $modification_reason, $admin_id, $remarks = '')
    {
        $record = $this->get_record_by_id($id);
        if (!$record) {
            return array('status' => false, 'message' => 'Record not found.');
        }

        $modification_reason = !empty($modification_reason) ? trim($modification_reason) : '';

        $approved_hours = round((float)$approved_hours, 2);
        if ($approved_hours < 0) {
            return array('status' => false, 'message' => 'Approved OT hours cannot be negative.');
        }

        if ($approved_hours > (float)$record->actual_ot_hours) {
            return array('status' => false, 'message' => 'Approved OT hours cannot exceed actual OT hours (' . $record->actual_ot_hours . ' hrs).');
        }

        $now_dt = date('Y-m-d H:i:s');
        $audit_trail = !empty($record->audit_history) ? json_decode($record->audit_history, true) : array();
        if (!is_array($audit_trail)) {
            $audit_trail = array();
        }

        $audit_trail[] = array(
            'action'             => 'modified',
            'timestamp'          => $now_dt,
            'by'                 => $admin_id,
            'original_actual'    => (float)$record->actual_ot_hours,
            'previous_approved'  => (float)$record->approved_ot_hours,
            'new_approved_hours' => $approved_hours,
            'modification_reason'=> $modification_reason,
            'remarks'            => $remarks,
            'previous_status'    => $record->status
        );

        $update_data = array(
            'approved_ot_hours'        => $approved_hours,
            'modification_reason'      => $modification_reason,
            'status'                   => 'approved',
            'admin_remarks'            => $remarks,
            'approved_by'              => $admin_id,
            'action_at'                => $now_dt,
            'attendance_modified_flag' => 0,
            'audit_history'            => json_encode($audit_trail),
            'updated_at'               => $now_dt
        );

        $this->db->where('id', $id)->update('pr_daily_ot_approval', $update_data);

        // Synchronize modified approved OT directly to pr_emp_shift_log
        $this->sync_approved_ot_to_shift_log($record->emp_id, $record->ot_date, $approved_hours, 'approved');

        return array('status' => true, 'message' => 'OT hours modified and approved successfully for Employee ' . $record->emp_id . '.');
    }

    /**
     * Reject OT with optional rejection reason
     */
    public function reject_ot($id, $rejection_reason, $admin_id, $remarks = '')
    {
        $record = $this->get_record_by_id($id);
        if (!$record) {
            return array('status' => false, 'message' => 'Record not found.');
        }

        $rejection_reason = !empty($rejection_reason) ? trim($rejection_reason) : '';

        $now_dt = date('Y-m-d H:i:s');
        $audit_trail = !empty($record->audit_history) ? json_decode($record->audit_history, true) : array();
        if (!is_array($audit_trail)) {
            $audit_trail = array();
        }

        $audit_trail[] = array(
            'action'           => 'rejected',
            'timestamp'        => $now_dt,
            'by'               => $admin_id,
            'previous_approved'=> (float)$record->approved_ot_hours,
            'rejection_reason' => $rejection_reason,
            'remarks'          => $remarks,
            'previous_status'  => $record->status
        );

        $update_data = array(
            'approved_ot_hours'        => 0.00,
            'rejection_reason'         => $rejection_reason,
            'status'                   => 'rejected',
            'admin_remarks'            => $remarks,
            'approved_by'              => $admin_id,
            'action_at'                => $now_dt,
            'attendance_modified_flag' => 0,
            'audit_history'            => json_encode($audit_trail),
            'updated_at'               => $now_dt
        );

        $this->db->where('id', $id)->update('pr_daily_ot_approval', $update_data);

        // Synchronize rejected OT directly to pr_emp_shift_log (zeros out OT)
        $this->sync_approved_ot_to_shift_log($record->emp_id, $record->ot_date, 0, 'rejected');

        return array('status' => true, 'message' => 'OT record rejected successfully for Employee ' . $record->emp_id . '.');
    }

    /**
     * Bulk approve selected records
     * Only processes records that are currently 'pending' to prevent unintentional alteration
     */
    public function bulk_approve_ot($ids, $admin_id, $remarks = '')
    {
        if (empty($ids) || !is_array($ids)) {
            return array('status' => false, 'message' => 'No records selected for bulk approval.');
        }

        $clean_ids = array_filter(array_map('intval', $ids));
        if (empty($clean_ids)) {
            return array('status' => false, 'message' => 'Invalid record IDs.');
        }

        $this->db->trans_start();

        // Fetch pending records only
        $this->db->where_in('id', $clean_ids);
        $this->db->where('status', 'pending');
        $pending_records = $this->db->get('pr_daily_ot_approval')->result();

        if (empty($pending_records)) {
            $this->db->trans_complete();
            return array('status' => false, 'message' => 'None of the selected records are in Pending status.');
        }

        $now_dt = date('Y-m-d H:i:s');
        $approved_count = 0;

        foreach ($pending_records as $record) {
            $audit_trail = !empty($record->audit_history) ? json_decode($record->audit_history, true) : array();
            if (!is_array($audit_trail)) {
                $audit_trail = array();
            }

            $audit_trail[] = array(
                'action'         => 'bulk_approved',
                'timestamp'      => $now_dt,
                'by'             => $admin_id,
                'approved_hours' => (float)$record->actual_ot_hours,
                'remarks'        => $remarks
            );

            $this->db->where('id', $record->id)->update('pr_daily_ot_approval', array(
                'approved_ot_hours'        => $record->actual_ot_hours,
                'status'                   => 'approved',
                'admin_remarks'            => $remarks,
                'approved_by'              => $admin_id,
                'action_at'                => $now_dt,
                'attendance_modified_flag' => 0,
                'audit_history'            => json_encode($audit_trail),
                'updated_at'               => $now_dt
            ));

            $this->sync_approved_ot_to_shift_log($record->emp_id, $record->ot_date, (float)$record->actual_ot_hours, 'approved');
            $approved_count++;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return array('status' => false, 'message' => 'Bulk approval failed due to database transaction error.');
        }

        return array(
            'status'  => true,
            'message' => "Successfully approved {$approved_count} pending OT records.",
            'count'   => $approved_count
        );
    }

    /**
     * Synchronize approved OT hours directly to pr_emp_shift_log so that
     * Actual Job Card (grid_eot_actual) and attendance logs show the approved OT in the OT column.
     */
    public function sync_approved_ot_to_shift_log($emp_id, $ot_date, $approved_hours, $status = 'approved')
    {
        $approved_hours = round((float)$approved_hours, 2);
        if ($status === 'rejected') {
            $approved_hours = 0;
        }

        $update = array(
            'ot'  => $approved_hours,
            'eot' => 0,
            'tot' => $approved_hours
        );

        if ($status === 'approved') {
            $approval = $this->db->where('emp_id', $emp_id)
                                 ->where('ot_date', $ot_date)
                                 ->get('pr_daily_ot_approval')
                                 ->row();

            if (!empty($approval)) {
                $cur_shift = $this->db->where('emp_id', $emp_id)
                                      ->where('shift_log_date', $ot_date)
                                      ->get('pr_emp_shift_log')
                                      ->row();

                if (!empty($cur_shift)) {
                    if (($cur_shift->in_time == '00:00:00' || empty($cur_shift->in_time)) && !empty($approval->in_time) && $approval->in_time != '00:00:00') {
                        $update['in_time'] = $approval->in_time;
                    }
                    if (($cur_shift->out_time == '00:00:00' || empty($cur_shift->out_time)) && !empty($approval->out_time) && $approval->out_time != '00:00:00') {
                        $update['out_time'] = $approval->out_time;
                    }
                    if (strtoupper(trim($cur_shift->present_status)) == 'A' || empty($cur_shift->present_status)) {
                        $update['present_status'] = 'P';
                    }
                }
            }
        }

        $this->db->where('emp_id', $emp_id)
                 ->where('shift_log_date', $ot_date)
                 ->update('pr_emp_shift_log', $update);
    }

    /**
     * Integration helper for Payroll & Reports:
     * Check if daily approval records exist for an employee within a date range,
     * and calculate approved OT & EOT hours (strictly status = 'approved').
     * Pending and Rejected OT are excluded.
     */
    public function get_approved_ot_for_payroll($emp_id, $start_date, $end_date)
    {
        $this->ensure_table_exists();

        // Check if ANY daily OT approval records exist for this employee in this period
        $this->db->where('emp_id', $emp_id);
        $this->db->where("ot_date BETWEEN '$start_date' AND '$end_date'");
        $total_logged = $this->db->count_all_results('pr_daily_ot_approval');

        if ($total_logged == 0) {
            return array('has_records' => false);
        }

        // Query approved records only
        $this->db->select('
            o.ot_date,
            o.approved_ot_hours,
            s.present_status
        ');
        $this->db->from('pr_daily_ot_approval o');
        $this->db->join('pr_emp_shift_log s', 's.emp_id = o.emp_id AND s.shift_log_date = o.ot_date', 'left');
        $this->db->where('o.emp_id', $emp_id);
        $this->db->where("o.ot_date BETWEEN '$start_date' AND '$end_date'");
        $this->db->where('o.status', 'approved');
        $query = $this->db->get();
        $approved_rows = $query->result();

        $tot_approved = 0;
        $tot_ot = 0;
        $tot_eot = 0;

        foreach ($approved_rows as $row) {
            $hrs = (float)$row->approved_ot_hours;
            $tot_approved += $hrs;

            // If weekend or holiday, all approved hours count towards EOT
            if ($row->present_status === 'W' || $row->present_status === 'H') {
                $tot_eot += $hrs;
            } else {
                // Normal working day: first 2 hours are regular OT, rest is EOT
                if ($hrs > 2) {
                    $tot_ot += 2;
                    $tot_eot += ($hrs - 2);
                } else {
                    $tot_ot += $hrs;
                }
            }
        }

        return array(
            'has_records'    => true,
            'approved_ot'    => $tot_ot,
            'approved_eot'   => $tot_eot,
            'total_approved' => $tot_approved
        );
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attn_regularization_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->ensure_tables_exist();
    }

    /**
     * Ensure database table exists and has proper columns & indexes
     */
    public function ensure_tables_exist()
    {
        if (!$this->db->table_exists('pr_attn_regularization')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `pr_attn_regularization` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `unit_id` int(11) NOT NULL DEFAULT 1,
              `emp_id` varchar(30) NOT NULL,
              `att_date` date NOT NULL,
              `issue_type` enum('late','early_out','punch_error','general') NOT NULL DEFAULT 'late',
              `reason_type` varchar(100) NOT NULL,
              `remarks` text NOT NULL,
              `waive_deduction` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Waive late deduction, 0 = Do not waive',
              `adjusted_in_time` time DEFAULT NULL,
              `adjusted_out_time` time DEFAULT NULL,
              `status` enum('Approved','Pending','Rejected') NOT NULL DEFAULT 'Approved',
              `created_by` varchar(50) DEFAULT NULL,
              `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
              `approved_by` varchar(50) DEFAULT NULL,
              `approved_at` datetime DEFAULT NULL,
              `rejection_reason` text DEFAULT NULL,
              `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `idx_emp_date` (`emp_id`,`att_date`),
              KEY `idx_unit_date` (`unit_id`,`att_date`),
              KEY `idx_issue` (`issue_type`),
              KEY `idx_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }

        // Add remarks and is_waived to pr_emp_shift_log if missing
        if ($this->db->table_exists('pr_emp_shift_log')) {
            if (!$this->db->field_exists('remarks', 'pr_emp_shift_log')) {
                $this->db->query("ALTER TABLE `pr_emp_shift_log` ADD COLUMN `remarks` VARCHAR(255) NULL AFTER `present_status`");
            }
            if (!$this->db->field_exists('is_waived', 'pr_emp_shift_log')) {
                $this->db->query("ALTER TABLE `pr_emp_shift_log` ADD COLUMN `is_waived` TINYINT(1) NOT NULL DEFAULT 0 AFTER `remarks`");
            }
            if (!$this->db->field_exists('regularization_id', 'pr_emp_shift_log')) {
                $this->db->query("ALTER TABLE `pr_emp_shift_log` ADD COLUMN `regularization_id` INT(11) NULL AFTER `is_waived`");
            }
        }
    }

    /**
     * Get single regularization record with employee details
     */
    public function get_regularization($id)
    {
        $this->db->select('r.*, 
                           p.name_en, 
                           p.name_bn, 
                           c.emp_dept_id, 
                           c.emp_sec_id, 
                           c.emp_desi_id,
                           d.dept_name, 
                           s.sec_name_en as sec_name, 
                           deg.desig_name,
                           u.unit_name');
        $this->db->from('pr_attn_regularization r');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = r.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = r.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = r.unit_id', 'left');
        $this->db->where('r.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get regularizations list with filters
     */
    public function get_regularizations($filters = array(), $limit = null, $offset = null)
    {
        $this->db->select('r.*, 
                           p.name_en, 
                           p.name_bn, 
                           d.dept_name, 
                           s.sec_name_en as sec_name, 
                           deg.desig_name,
                           u.unit_name,
                           log.in_time as log_in_time,
                           log.out_time as log_out_time,
                           log.late_status as log_late_status,
                           log.late_time as log_late_time,
                           log.early_exit as log_early_exit,
                           log.present_status as log_present_status');
        $this->db->from('pr_attn_regularization r');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = r.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = r.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = r.unit_id', 'left');
        $this->db->join('pr_emp_shift_log log', 'log.emp_id = r.emp_id AND log.shift_log_date = r.att_date', 'left');

        $this->apply_filters($filters);

        $this->db->order_by('r.att_date', 'DESC');
        $this->db->order_by('r.id', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Count regularizations with filters
     */
    public function count_regularizations($filters = array())
    {
        $this->db->from('pr_attn_regularization r');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = r.emp_id', 'left');
        $this->apply_filters($filters);
        return $this->db->count_all_results();
    }

    /**
     * Apply standard search filters
     */
    protected function apply_filters($filters)
    {
        if (!empty($filters['unit_id'])) {
            $this->db->where('r.unit_id', $filters['unit_id']);
        }
        if (!empty($filters['dept_id'])) {
            $this->db->where('c.emp_dept_id', $filters['dept_id']);
        }
        if (!empty($filters['sec_id'])) {
            $this->db->where('c.emp_sec_id', $filters['sec_id']);
        }
        if (!empty($filters['emp_id'])) {
            $this->db->where('r.emp_id', $filters['emp_id']);
        }
        if (!empty($filters['issue_type'])) {
            $this->db->where('r.issue_type', $filters['issue_type']);
        }
        if (isset($filters['waive_deduction']) && $filters['waive_deduction'] !== '') {
            $this->db->where('r.waive_deduction', $filters['waive_deduction']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('r.status', $filters['status']);
        }
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $this->db->where("r.att_date BETWEEN '{$filters['start_date']}' AND '{$filters['end_date']}'");
        } elseif (!empty($filters['start_date'])) {
            $this->db->where('r.att_date >=', $filters['start_date']);
        } elseif (!empty($filters['end_date'])) {
            $this->db->where('r.att_date <=', $filters['end_date']);
        }
        if (!empty($filters['month'])) {
            $this->db->like('r.att_date', $filters['month'], 'after');
        }
    }

    /**
     * Get summary KPI statistics for dashboard
     */
    public function get_statistics($unit_id = null, $month = null)
    {
        $this->db->select("
            COUNT(*) as total_records,
            SUM(CASE WHEN issue_type = 'late' THEN 1 ELSE 0 END) as total_late,
            SUM(CASE WHEN issue_type = 'early_out' THEN 1 ELSE 0 END) as total_early_out,
            SUM(CASE WHEN issue_type = 'punch_error' THEN 1 ELSE 0 END) as total_punch_error,
            SUM(CASE WHEN waive_deduction = 1 AND status = 'Approved' THEN 1 ELSE 0 END) as total_waived,
            SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as total_pending,
            SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as total_approved,
            SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as total_rejected
        ");
        $this->db->from('pr_attn_regularization');
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        if (!empty($month)) {
            $this->db->like('att_date', $month, 'after');
        }
        $stats = $this->db->get()->row();

        return array(
            'total_records'     => (int) ($stats ? $stats->total_records : 0),
            'total_late'        => (int) ($stats ? $stats->total_late : 0),
            'total_early_out'   => (int) ($stats ? $stats->total_early_out : 0),
            'total_punch_error' => (int) ($stats ? $stats->total_punch_error : 0),
            'total_waived'      => (int) ($stats ? $stats->total_waived : 0),
            'total_pending'     => (int) ($stats ? $stats->total_pending : 0),
            'total_approved'    => (int) ($stats ? $stats->total_approved : 0),
            'total_rejected'    => (int) ($stats ? $stats->total_rejected : 0),
        );
    }

    /**
     * Fetch existing attendance details for employee and date
     */
    public function get_employee_attn_info($emp_id, $date)
    {
        $this->db->select('log.*, sch.sh_type as shift_name, sch.in_start, sch.in_time as sch_in_time, sch.late_start, sch.out_start, sch.out_end');
        $this->db->from('pr_emp_shift_log log');
        $this->db->join('pr_emp_shift_schedule sch', 'sch.id = log.schedule_id', 'left');
        $this->db->where('log.emp_id', $emp_id);
        $this->db->where('log.shift_log_date', $date);
        $log = $this->db->get()->row();

        $existing_reg = $this->db->where('emp_id', $emp_id)->where('att_date', $date)->get('pr_attn_regularization')->row();

        return array(
            'log' => $log,
            'existing_regularization' => $existing_reg
        );
    }

    /**
     * Save regularization record and sync with shift log
     */
    public function save_regularization($data)
    {
        $emp_id          = $data['emp_id'];
        $att_date        = $data['att_date'];
        $waive_deduction = isset($data['waive_deduction']) ? (int)$data['waive_deduction'] : 1;
        $remarks         = isset($data['remarks']) ? trim($data['remarks']) : '';
        $reason_type     = isset($data['reason_type']) ? trim($data['reason_type']) : '';
        $issue_type      = isset($data['issue_type']) ? $data['issue_type'] : 'late';
        $status          = isset($data['status']) ? $data['status'] : 'Approved';

        // Check if a record already exists for this employee and date
        $existing = $this->db->where('emp_id', $emp_id)->where('att_date', $att_date)->get('pr_attn_regularization')->row();

        if ($existing) {
            $reg_id = $existing->id;
            $this->db->where('id', $reg_id)->update('pr_attn_regularization', $data);
        } else {
            $this->db->insert('pr_attn_regularization', $data);
            $reg_id = $this->db->insert_id();
        }

        // If approved, sync to pr_emp_shift_log
        if ($status === 'Approved') {
            $full_remark = !empty($reason_type) ? "{$reason_type}: {$remarks}" : $remarks;
            $adj_in  = !empty($data['adjusted_in_time']) ? $data['adjusted_in_time'] : null;
            $adj_out = !empty($data['adjusted_out_time']) ? $data['adjusted_out_time'] : null;

            $this->sync_shift_log($emp_id, $att_date, $full_remark, $waive_deduction, $reg_id, $adj_in, $adj_out);
        }

        return $reg_id;
    }

    /**
     * Sync remark, waiver, and optional adjusted punch times to pr_emp_shift_log
     */
    public function sync_shift_log($emp_id, $att_date, $remarks, $is_waived, $reg_id, $adj_in = null, $adj_out = null)
    {
        $update_data = array(
            'remarks'           => $remarks,
            'is_waived'         => $is_waived ? 1 : 0,
            'regularization_id' => $reg_id
        );

        if (!empty($adj_in) && $adj_in !== '00:00:00') {
            $update_data['in_time'] = $adj_in;
        }
        if (!empty($adj_out) && $adj_out !== '00:00:00') {
            $update_data['out_time'] = $adj_out;
        }

        // Update shift log
        $this->db->where('emp_id', $emp_id)
                 ->where('shift_log_date', $att_date)
                 ->update('pr_emp_shift_log', $update_data);

        return true;
    }

    /**
     * Update status (e.g. Approved / Rejected)
     */
    public function update_status($id, $status, $approved_by, $rejection_reason = '')
    {
        $reg = $this->get_regularization($id);
        if (!$reg) return false;

        $update = array(
            'status'           => $status,
            'approved_by'      => $approved_by,
            'approved_at'      => date('Y-m-d H:i:s'),
            'rejection_reason' => $rejection_reason
        );
        $this->db->where('id', $id)->update('pr_attn_regularization', $update);

        if ($status === 'Approved') {
            $full_remark = !empty($reg->reason_type) ? "{$reg->reason_type}: {$reg->remarks}" : $reg->remarks;
            $this->sync_shift_log($reg->emp_id, $reg->att_date, $full_remark, $reg->waive_deduction, $reg->id, $reg->adjusted_in_time, $reg->adjusted_out_time);
        } else {
            // Revert shift log waiver if rejected or cancelled
            $this->db->where('emp_id', $reg->emp_id)
                     ->where('shift_log_date', $reg->att_date)
                     ->update('pr_emp_shift_log', array(
                         'remarks'           => null,
                         'is_waived'         => 0,
                         'regularization_id' => null
                     ));
        }

        return true;
    }

    /**
     * Delete regularization and revert shift log
     */
    public function delete_regularization($id)
    {
        $reg = $this->get_regularization($id);
        if (!$reg) return false;

        // Revert shift log
        $this->db->where('emp_id', $reg->emp_id)
                 ->where('shift_log_date', $reg->att_date)
                 ->update('pr_emp_shift_log', array(
                     'remarks'           => null,
                     'is_waived'         => 0,
                     'regularization_id' => null
                 ));

        $this->db->where('id', $id)->delete('pr_attn_regularization');
        return true;
    }

    /**
     * Search active employees for autocomplete / selection
     */
    public function search_employees($term = '', $unit_id = null, $limit = 20)
    {
        $this->db->select('c.emp_id, p.name_en, d.dept_name, deg.desig_name, c.unit_id');
        $this->db->from('pr_emp_com_info c');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');

        if (!empty($unit_id)) {
            $this->db->where('c.unit_id', $unit_id);
        }

        if (!empty($term)) {
            $this->db->group_start();
            $this->db->like('c.emp_id', $term);
            $this->db->or_like('p.name_en', $term);
            $this->db->group_end();
        }

        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    /**
     * Get the latest processed date in pr_emp_shift_log
     */
    public function get_latest_shift_date()
    {
        $sql = "SELECT shift_log_date FROM pr_emp_shift_log GROUP BY shift_log_date HAVING COUNT(*) > 5 ORDER BY shift_log_date DESC LIMIT 1";
        $row = $this->db->query($sql)->row();
        if ($row && !empty($row->shift_log_date)) {
            return $row->shift_log_date;
        }

        $this->db->select_max('shift_log_date');
        $row2 = $this->db->get('pr_emp_shift_log')->row();
        if ($row2 && !empty($row2->shift_log_date)) {
            return $row2->shift_log_date;
        }

        return date('Y-m-d');
    }

    /**
     * Get daily attendance exceptions / issues (Late, Early Out, Missing Out, Punched Before Out Start)
     */
    public function get_attendance_issues($filters = array(), $limit = null, $offset = null)
    {
        $this->db->select('log.id as shift_log_id, 
                           log.emp_id, 
                           log.unit_id,
                           log.shift_log_date, 
                           log.in_time, 
                           log.out_time,
                           log.late_status, 
                           log.late_time, 
                           log.early_exit, 
                           log.present_status, 
                           log.remarks as log_remarks, 
                           log.is_waived, 
                           log.regularization_id,
                           p.name_en, 
                           p.name_bn, 
                           c.emp_dept_id, 
                           c.emp_sec_id, 
                           c.emp_desi_id,
                           d.dept_name, 
                           s.sec_name_en as sec_name, 
                           deg.desig_name,
                           u.unit_name,
                           sch.sh_type as shift_name, 
                           sch.in_start, 
                           sch.in_time as sch_in_time, 
                           sch.late_start, 
                           sch.out_start, 
                           sch.out_end,
                           r.id as reg_id, 
                           r.issue_type as reg_issue_type,
                           r.reason_type as reg_reason, 
                           r.remarks as reg_remarks, 
                           r.waive_deduction as reg_waived,
                           r.adjusted_in_time,
                           r.adjusted_out_time,
                           r.status as reg_status');
        $this->db->from('pr_emp_shift_log log');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = log.emp_id', 'inner');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = log.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = log.unit_id', 'left');
        $this->db->join('pr_emp_shift_schedule sch', 'sch.id = log.schedule_id', 'left');
        $this->db->join('pr_attn_regularization r', 'r.emp_id = log.emp_id AND r.att_date = log.shift_log_date', 'left');

        // Apply filters
        $this->apply_issue_filters($filters);

        $this->db->order_by('log.shift_log_date', 'DESC');
        $this->db->order_by('log.emp_id', 'ASC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        $results = $this->db->get()->result();

        // Process issues & detect early raw punches for missing out time
        $date_emp_map = array();
        foreach ($results as $row) {
            $issue = 'general';
            $issue_label = 'General';
            $issue_details = '';

            $is_late = ($row->late_status == 1 || (!empty($row->in_time) && $row->in_time != '00:00:00' && !empty($row->late_start) && $row->late_start != '00:00:00' && $row->in_time > $row->late_start));
            $is_early_out = ($row->early_exit == 1 || (!empty($row->out_time) && $row->out_time != '00:00:00' && !empty($row->out_start) && $row->out_start != '00:00:00' && $row->out_time < $row->out_start));
            $is_missing_out = (!empty($row->in_time) && $row->in_time != '00:00:00' && (empty($row->out_time) || $row->out_time == '00:00:00'));

            if ($is_late && $is_missing_out) {
                $issue = 'late';
                $issue_label = 'Late & Missing Out';
                $issue_details = 'Late in: ' . $row->in_time . ', Out time missing';
            } elseif ($is_late) {
                $issue = 'late';
                $issue_label = 'Late Entry';
                $issue_details = 'In Time: ' . $row->in_time . (!empty($row->late_start) ? ' (After ' . $row->late_start . ')' : '');
            } elseif ($is_early_out) {
                $issue = 'early_out';
                $issue_label = 'Early Exit';
                $issue_details = 'Out Time: ' . $row->out_time . (!empty($row->out_start) ? ' (Before ' . $row->out_start . ')' : '');
            } elseif ($is_missing_out) {
                $issue = 'missing_out';
                $issue_label = 'Missing Out / Punch Error';
                $issue_details = 'In Time: ' . $row->in_time . ', Out time not recorded';
            }

            $row->detected_issue = $issue;
            $row->detected_issue_label = $issue_label;
            $row->detected_issue_details = $issue_details;
            $row->detected_raw_punch = null;
            $row->detected_punch_count = 0;

            if ($is_missing_out) {
                $m = date('Y_m', strtotime($row->shift_log_date));
                $date_emp_map[$m][$row->shift_log_date][] = $row;
            }
        }

        // For rows with missing out time, inspect raw biometric punches in att_YYYY_MM
        foreach ($date_emp_map as $month_str => $dates) {
            $table = 'att_' . $month_str;
            if (!$this->db->table_exists($table)) continue;

            foreach ($dates as $dt => $emp_rows) {
                $emp_ids = array();
                foreach ($emp_rows as $er) {
                    $emp_ids[] = $this->db->escape($er->emp_id);
                }
                if (empty($emp_ids)) continue;

                $sql = "SELECT proxi_id, MAX(TIME(date_time)) as max_punch, COUNT(*) as punch_cnt 
                        FROM `{$table}` 
                        WHERE `proxi_id` IN (" . implode(',', $emp_ids) . ") 
                          AND DATE(`date_time`) = '{$dt}'
                        GROUP BY `proxi_id`";
                $punch_res = $this->db->query($sql)->result();
                $punch_map = array();
                foreach ($punch_res as $pr) {
                    $punch_map[$pr->proxi_id] = $pr;
                }

                foreach ($emp_rows as $er) {
                    if (isset($punch_map[$er->emp_id])) {
                        $p_info = $punch_map[$er->emp_id];
                        // If max punch is greater than in_time, it is an uncaptured punch before schedule out_start
                        if (strtotime($p_info->max_punch) > (strtotime($er->in_time) + 120)) {
                            $er->detected_raw_punch = $p_info->max_punch;
                            $er->detected_punch_count = $p_info->punch_cnt;
                            $er->detected_issue = 'punch_error';
                            $er->detected_issue_label = 'Punched Before Out-Start';
                            $er->detected_issue_details = "Machine punch at {$p_info->max_punch} (Schedule Out-Start: {$er->out_start})";
                        }
                    }
                }
            }
        }

        return $results;
    }

    /**
     * Apply issue filters
     */
    protected function apply_issue_filters($filters)
    {
        if (!empty($filters['unit_id'])) {
            $this->db->where('log.unit_id', $filters['unit_id']);
        }
        if (!empty($filters['dept_id'])) {
            $this->db->where('c.emp_dept_id', $filters['dept_id']);
        }
        if (!empty($filters['sec_id'])) {
            $this->db->where('c.emp_sec_id', $filters['sec_id']);
        }
        if (!empty($filters['emp_id'])) {
            $this->db->group_start();
            $this->db->like('log.emp_id', $filters['emp_id']);
            $this->db->or_like('p.name_en', $filters['emp_id']);
            $this->db->group_end();
        }

        // Date range between
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $this->db->where("log.shift_log_date BETWEEN '{$filters['start_date']}' AND '{$filters['end_date']}'");
        } elseif (!empty($filters['start_date'])) {
            $this->db->where('log.shift_log_date >=', $filters['start_date']);
        } elseif (!empty($filters['end_date'])) {
            $this->db->where('log.shift_log_date <=', $filters['end_date']);
        }

        // Issue Type filtering
        $issue_type = isset($filters['issue_type']) ? $filters['issue_type'] : 'all';
        if ($issue_type === 'late') {
            $this->db->where("(log.late_status = 1 OR (log.in_time != '00:00:00' AND sch.late_start IS NOT NULL AND sch.late_start != '00:00:00' AND log.in_time > sch.late_start))");
        } elseif ($issue_type === 'early_out') {
            $this->db->where("(log.early_exit = 1 OR (log.out_time != '00:00:00' AND sch.out_start IS NOT NULL AND sch.out_start != '00:00:00' AND log.out_time < sch.out_start))");
        } elseif ($issue_type === 'missing_out') {
            $this->db->where("(log.in_time != '00:00:00' AND (log.out_time = '00:00:00' OR log.out_time IS NULL))");
        } elseif ($issue_type === 'pending') {
            $this->db->where("(log.is_waived = 0 OR log.is_waived IS NULL) AND r.id IS NULL");
            $this->db->where("(log.late_status = 1 OR log.early_exit = 1 OR (log.in_time != '00:00:00' AND (log.out_time = '00:00:00' OR log.out_time IS NULL)))");
        } elseif ($issue_type === 'regularized') {
            $this->db->where("(log.is_waived = 1 OR r.id IS NOT NULL OR log.regularization_id IS NOT NULL)");
        } else {
            // All Issues
            $this->db->where("(log.late_status = 1 OR log.early_exit = 1 OR (log.in_time != '00:00:00' AND (log.out_time = '00:00:00' OR log.out_time IS NULL)) OR log.is_waived = 1 OR r.id IS NOT NULL)");
        }
    }

    /**
     * Get summary KPI statistics for attendance issues
     */
    public function get_attendance_issues_summary($filters = array())
    {
        $this->db->select("
            COUNT(*) as total_issues,
            COALESCE(SUM(CASE WHEN (log.late_status = 1 OR (log.in_time != '00:00:00' AND sch.late_start IS NOT NULL AND sch.late_start != '00:00:00' AND log.in_time > sch.late_start)) THEN 1 ELSE 0 END), 0) as total_late,
            COALESCE(SUM(CASE WHEN (log.early_exit = 1 OR (log.out_time != '00:00:00' AND sch.out_start IS NOT NULL AND sch.out_start != '00:00:00' AND log.out_time < sch.out_start)) THEN 1 ELSE 0 END), 0) as total_early_out,
            COALESCE(SUM(CASE WHEN (log.in_time != '00:00:00' AND (log.out_time = '00:00:00' OR log.out_time IS NULL)) THEN 1 ELSE 0 END), 0) as total_missing_out,
            COALESCE(SUM(CASE WHEN (log.is_waived = 1 OR r.id IS NOT NULL OR log.regularization_id IS NOT NULL) THEN 1 ELSE 0 END), 0) as total_regularized,
            COALESCE(SUM(CASE WHEN (log.is_waived = 0 OR log.is_waived IS NULL) AND r.id IS NULL AND (log.late_status = 1 OR log.early_exit = 1 OR (log.in_time != '00:00:00' AND (log.out_time = '00:00:00' OR log.out_time IS NULL))) THEN 1 ELSE 0 END), 0) as total_pending
        ");
        $this->db->from('pr_emp_shift_log log');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = log.emp_id', 'inner');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = log.emp_id', 'left');
        $this->db->join('pr_emp_shift_schedule sch', 'sch.id = log.schedule_id', 'left');
        $this->db->join('pr_attn_regularization r', 'r.emp_id = log.emp_id AND r.att_date = log.shift_log_date', 'left');

        // Apply filters without issue_type
        $summary_filters = $filters;
        unset($summary_filters['issue_type']);
        $this->apply_issue_filters($summary_filters);

        $row = $this->db->get()->row();
        return array(
            'total_issues'      => (int) ($row ? $row->total_issues : 0),
            'total_late'        => (int) ($row ? $row->total_late : 0),
            'total_early_out'   => (int) ($row ? $row->total_early_out : 0),
            'total_missing_out' => (int) ($row ? $row->total_missing_out : 0),
            'total_regularized' => (int) ($row ? $row->total_regularized : 0),
            'total_pending'     => (int) ($row ? $row->total_pending : 0),
        );
    }

    /**
     * Get single issue detail including shift log, employee info, and raw biometric punches
     */
    public function get_issue_detail($emp_id, $date)
    {
        $this->db->select('log.*, 
                           p.name_en, 
                           p.name_bn, 
                           c.emp_dept_id, 
                           c.emp_sec_id, 
                           c.emp_desi_id,
                           c.unit_id as emp_unit_id,
                           d.dept_name, 
                           s.sec_name_en as sec_name, 
                           deg.desig_name,
                           u.unit_name,
                           sch.sh_type as shift_name, 
                           sch.in_start, 
                           sch.in_time as sch_in_time, 
                           sch.late_start, 
                           sch.out_start, 
                           sch.out_end');
        $this->db->from('pr_emp_shift_log log');
        $this->db->join('pr_emp_com_info c', 'c.emp_id = log.emp_id', 'inner');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = log.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = log.unit_id', 'left');
        $this->db->join('pr_emp_shift_schedule sch', 'sch.id = log.schedule_id', 'left');
        $this->db->where('log.emp_id', $emp_id);
        $this->db->where('log.shift_log_date', $date);
        $log = $this->db->get()->row();

        $existing_reg = $this->db->where('emp_id', $emp_id)->where('att_date', $date)->get('pr_attn_regularization')->row();

        // Get raw punches from att_YYYY_MM
        $month_str = date('Y_m', strtotime($date));
        $table = 'att_' . $month_str;
        $raw_punches = array();
        $suggested_out_punch = null;

        if ($this->db->table_exists($table)) {
            $sql = "SELECT date_time FROM `{$table}` WHERE `proxi_id` = ? AND DATE(`date_time`) = ? ORDER BY `date_time` ASC";
            $res = $this->db->query($sql, array($emp_id, $date))->result();
            foreach ($res as $r) {
                $raw_punches[] = $r->date_time;
                $t = date('H:i:s', strtotime($r->date_time));
                if ($log && !empty($log->in_time) && strtotime($t) > (strtotime($log->in_time) + 120)) {
                    $suggested_out_punch = $t;
                }
            }
        }

        return array(
            'log'                 => $log,
            'existing'            => $existing_reg,
            'raw_punches'         => $raw_punches,
            'suggested_out_punch' => $suggested_out_punch,
        );
    }

    /**
     * Save quick remark and waiver from modal
     */
    public function save_quick_remark($emp_id, $att_date, $data, $username)
    {
        $unit_id         = !empty($data['unit_id']) ? (int)$data['unit_id'] : 1;
        $issue_type      = !empty($data['issue_type']) ? $data['issue_type'] : 'late';
        $reason_type     = !empty($data['reason_type']) ? trim((string)$data['reason_type']) : 'General';
        $remarks         = isset($data['remarks']) ? trim((string)$data['remarks']) : '';
        $waive_deduction = isset($data['waive_deduction']) ? (int)$data['waive_deduction'] : 1;
        $adj_in          = !empty($data['adjusted_in_time']) ? trim((string)$data['adjusted_in_time']) : null;
        $adj_out         = !empty($data['adjusted_out_time']) ? trim((string)$data['adjusted_out_time']) : null;

        // 1. Insert or update pr_attn_regularization
        $existing = $this->db->where('emp_id', $emp_id)->where('att_date', $att_date)->get('pr_attn_regularization')->row();

        $payload = array(
            'unit_id'           => $unit_id,
            'emp_id'            => $emp_id,
            'att_date'          => $att_date,
            'issue_type'        => $issue_type,
            'reason_type'       => $reason_type,
            'remarks'           => $remarks,
            'waive_deduction'   => $waive_deduction,
            'adjusted_in_time'  => $adj_in,
            'adjusted_out_time' => $adj_out,
            'status'            => 'Approved',
            'approved_by'       => $username,
            'approved_at'       => date('Y-m-d H:i:s'),
        );

        if ($existing) {
            $reg_id = $existing->id;
            $this->db->where('id', $reg_id)->update('pr_attn_regularization', $payload);
        } else {
            $payload['created_by'] = $username;
            $this->db->insert('pr_attn_regularization', $payload);
            $reg_id = $this->db->insert_id();
        }

        // 2. Sync to pr_emp_shift_log
        $full_remark = !empty($reason_type) ? ($reason_type . (!empty($remarks) ? ': ' . $remarks : '')) : $remarks;

        $shift_update = array(
            'remarks'           => $full_remark,
            'is_waived'         => $waive_deduction ? 1 : 0,
            'regularization_id' => $reg_id,
        );

        if (!empty($adj_in) && $adj_in !== '00:00:00') {
            $shift_update['in_time'] = $adj_in;
        }
        if (!empty($adj_out) && $adj_out !== '00:00:00') {
            $shift_update['out_time'] = $adj_out;
            $shift_update['present_status'] = 'P';
        }

        $this->db->where('emp_id', $emp_id)
                 ->where('shift_log_date', $att_date)
                 ->update('pr_emp_shift_log', $shift_update);

        return array(
            'reg_id'      => $reg_id,
            'full_remark' => $full_remark,
            'is_waived'   => $waive_deduction ? 1 : 0,
            'in_time'     => !empty($adj_in) ? $adj_in : null,
            'out_time'    => !empty($adj_out) ? $adj_out : null,
        );
    }
}


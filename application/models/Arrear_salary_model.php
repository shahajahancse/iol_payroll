<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arrear_salary_model extends CI_Model {

    protected $table = 'employee_arrear_salaries';

    public function __construct()
    {
        parent::__construct();
        $this->ensure_schema();
    }

    /**
     * Auto-create table and columns if not exist
     */
    public function ensure_schema()
    {
        if (!$this->db->table_exists($this->table)) {
            $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `unit_id` INT(11) NULL,
                `emp_id` VARCHAR(50) NOT NULL,
                `arrear_month` VARCHAR(20) NOT NULL,
                `payment_month` VARCHAR(20) NOT NULL,
                `amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `remarks` TEXT NULL,
                `status` ENUM('Pending', 'Approved', 'Paid', 'Cancelled') NOT NULL DEFAULT 'Approved',
                `payroll_id` INT(11) NULL,
                `paid_at` DATETIME NULL,
                `created_by` VARCHAR(100) NULL,
                `updated_by` VARCHAR(100) NULL,
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME NOT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_emp_id` (`emp_id`),
                KEY `idx_payment_month` (`payment_month`),
                KEY `idx_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->db->query($sql);
        }

        // Ensure pay_salary_sheet has arrear_amount
        if ($this->db->table_exists('pay_salary_sheet') && !$this->db->field_exists('arrear_amount', 'pay_salary_sheet')) {
            $this->db->query("ALTER TABLE `pay_salary_sheet` ADD COLUMN `arrear_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `festival_bonus`");
        }

        // Ensure pay_salary_sheet_com has arrear_amount
        if ($this->db->table_exists('pay_salary_sheet_com') && !$this->db->field_exists('arrear_amount', 'pay_salary_sheet_com')) {
            $this->db->query("ALTER TABLE `pay_salary_sheet_com` ADD COLUMN `arrear_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `festival_bonus`");
        }
    }

    /**
     * Get arrears with filters, search, and pagination
     */
    public function get_arrears($filters = array(), $limit = null, $offset = null)
    {
        $this->db->select('a.*, 
                           p.name_en, 
                           p.name_bn, 
                           c.emp_dept_id, 
                           c.emp_desi_id,
                           c.gross_sal,
                           d.dept_name, 
                           deg.desig_name,
                           u.unit_name');
        $this->db->from("{$this->table} a");
        $this->db->join('pr_emp_com_info c', 'c.emp_id = a.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = a.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = a.unit_id', 'left');

        $this->apply_filters($filters);

        $this->db->order_by('a.payment_month', 'DESC');
        $this->db->order_by('a.id', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Count arrears for pagination
     */
    public function count_arrears($filters = array())
    {
        $this->db->from("{$this->table} a");
        $this->db->join('pr_emp_com_info c', 'c.emp_id = a.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = a.emp_id', 'left');
        $this->apply_filters($filters);
        return $this->db->count_all_results();
    }

    /**
     * Get single arrear record by ID
     */
    public function get_arrear_by_id($id)
    {
        $this->db->select('a.*, 
                           p.name_en, 
                           p.name_bn, 
                           c.emp_dept_id, 
                           c.emp_desi_id,
                           c.gross_sal,
                           d.dept_name, 
                           deg.desig_name,
                           u.unit_name');
        $this->db->from("{$this->table} a");
        $this->db->join('pr_emp_com_info c', 'c.emp_id = a.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = a.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = a.unit_id', 'left');
        $this->db->where('a.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get summary KPI statistics
     */
    public function get_summary_stats($filters = array())
    {
        $this->db->select("
            COUNT(*) as total_count,
            COALESCE(SUM(a.amount), 0) as total_amount,
            COALESCE(SUM(CASE WHEN a.status = 'Pending' THEN 1 ELSE 0 END), 0) as pending_count,
            COALESCE(SUM(CASE WHEN a.status = 'Pending' THEN a.amount ELSE 0 END), 0) as pending_amount,
            COALESCE(SUM(CASE WHEN a.status = 'Approved' THEN 1 ELSE 0 END), 0) as approved_count,
            COALESCE(SUM(CASE WHEN a.status = 'Approved' THEN a.amount ELSE 0 END), 0) as approved_amount,
            COALESCE(SUM(CASE WHEN a.status = 'Paid' THEN 1 ELSE 0 END), 0) as paid_count,
            COALESCE(SUM(CASE WHEN a.status = 'Paid' THEN a.amount ELSE 0 END), 0) as paid_amount,
            COALESCE(SUM(CASE WHEN a.status = 'Cancelled' THEN 1 ELSE 0 END), 0) as cancelled_count
        ");
        $this->db->from("{$this->table} a");
        $this->db->join('pr_emp_com_info c', 'c.emp_id = a.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = a.emp_id', 'left');

        // Apply filters without status so status totals remain accurate
        $stat_filters = $filters;
        unset($stat_filters['status']);
        $this->apply_filters($stat_filters);

        return $this->db->get()->row();
    }

    /**
     * Apply filter conditions
     */
    protected function apply_filters($filters)
    {
        if (!empty($filters['unit_id'])) {
            $this->db->where('a.unit_id', $filters['unit_id']);
        }
        if (!empty($filters['dept_id'])) {
            $this->db->where('c.emp_dept_id', $filters['dept_id']);
        }
        if (!empty($filters['search'])) {
            $s = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('a.emp_id', $s);
            $this->db->or_like('p.name_en', $s);
            $this->db->or_like('a.remarks', $s);
            $this->db->group_end();
        }
        if (!empty($filters['arrear_month'])) {
            $am = date('Y-m-01', strtotime($filters['arrear_month']));
            $am_short = substr($am, 0, 7);
            $this->db->where("(a.arrear_month = '{$am}' OR a.arrear_month = '{$am_short}')");
        }
        if (!empty($filters['payment_month'])) {
            $pm = date('Y-m-01', strtotime($filters['payment_month']));
            $pm_short = substr($pm, 0, 7);
            $this->db->where("(a.payment_month = '{$pm}' OR a.payment_month = '{$pm_short}')");
        }
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $this->db->where('a.status', $filters['status']);
        }
    }

    /**
     * Save new arrear salary record
     */
    public function save_arrear($data, $username)
    {
        $emp_id        = trim((string)$data['emp_id']);
        $amount        = round((float)$data['amount'], 2);
        $payment_month = date('Y-m-01', strtotime($data['payment_month']));
        $arrear_month  = !empty($data['arrear_month']) ? date('Y-m-01', strtotime($data['arrear_month'])) : $payment_month;
        $remarks       = isset($data['remarks']) ? trim((string)$data['remarks']) : '';
        $status        = !empty($data['status']) ? $data['status'] : 'Approved';

        // Get employee's unit_id
        $emp_info = $this->db->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
        $unit_id = ($emp_info && !empty($emp_info->unit_id)) ? $emp_info->unit_id : 1;

        $insert_data = array(
            'unit_id'       => $unit_id,
            'emp_id'        => $emp_id,
            'arrear_month'  => $arrear_month,
            'payment_month' => $payment_month,
            'amount'        => $amount,
            'remarks'       => $remarks,
            'status'        => $status,
            'created_by'    => $username,
            'updated_by'    => $username,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        );

        $this->db->insert($this->table, $insert_data);
        $insert_id = $this->db->insert_id();

        // Auto-process into salary sheet if salary already processed for this payment month
        $synced = $this->sync_to_processed_salary_sheet($emp_id, $payment_month);

        return array(
            'status'         => true,
            'id'             => $insert_id,
            'auto_processed' => (!empty($synced['pay_salary_sheet']) || !empty($synced['pay_salary_sheet_com'])),
            'synced'         => $synced,
        );
    }

    /**
     * Update existing arrear salary record
     */
    public function update_arrear($id, $data, $username)
    {
        $existing = $this->db->where('id', $id)->get($this->table)->row();
        if (!$existing) {
            return array('status' => false, 'message' => 'Record not found.');
        }
        if ($existing->status === 'Paid') {
            return array('status' => false, 'message' => 'Cannot modify an arrear record that has already been finalized and paid in payroll.');
        }

        $old_emp_id        = $existing->emp_id;
        $old_payment_month = $existing->payment_month;

        $update_data = array(
            'updated_by' => $username,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        if (isset($data['emp_id'])) {
            $emp_id = trim((string)$data['emp_id']);
            $update_data['emp_id'] = $emp_id;
            $emp_info = $this->db->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
            if ($emp_info && !empty($emp_info->unit_id)) {
                $update_data['unit_id'] = $emp_info->unit_id;
            }
        }
        if (isset($data['amount'])) {
            $update_data['amount'] = round((float)$data['amount'], 2);
        }
        if (isset($data['arrear_month'])) {
            $update_data['arrear_month'] = date('Y-m-01', strtotime($data['arrear_month']));
        }
        if (isset($data['payment_month'])) {
            $update_data['payment_month'] = date('Y-m-01', strtotime($data['payment_month']));
        }
        if (isset($data['remarks'])) {
            $update_data['remarks'] = trim((string)$data['remarks']);
        }
        if (isset($data['status'])) {
            $update_data['status'] = $data['status'];
        }

        $this->db->where('id', $id)->update($this->table, $update_data);

        $new_emp_id        = isset($update_data['emp_id']) ? $update_data['emp_id'] : $old_emp_id;
        $new_payment_month = isset($update_data['payment_month']) ? $update_data['payment_month'] : $old_payment_month;

        // Auto-sync new and old (if changed)
        $synced = $this->sync_to_processed_salary_sheet($new_emp_id, $new_payment_month);
        if ($new_emp_id !== $old_emp_id || $new_payment_month !== $old_payment_month) {
            $this->sync_to_processed_salary_sheet($old_emp_id, $old_payment_month);
        }

        return array(
            'status'         => true,
            'message'        => 'Record updated successfully.',
            'auto_processed' => (!empty($synced['pay_salary_sheet']) || !empty($synced['pay_salary_sheet_com'])),
            'synced'         => $synced,
        );
    }

    /**
     * Delete arrear salary record
     */
    public function delete_arrear($id)
    {
        $existing = $this->db->where('id', $id)->get($this->table)->row();
        if (!$existing) {
            return array('status' => false, 'message' => 'Record not found.');
        }
        if ($existing->status === 'Paid') {
            return array('status' => false, 'message' => 'Cannot delete an arrear record that has already been paid in payroll.');
        }

        $emp_id        = $existing->emp_id;
        $payment_month = $existing->payment_month;

        $this->db->where('id', $id)->delete($this->table);

        // Auto-sync after deletion
        $synced = $this->sync_to_processed_salary_sheet($emp_id, $payment_month);

        return array(
            'status'         => true,
            'message'        => 'Record deleted successfully.',
            'auto_processed' => (!empty($synced['pay_salary_sheet']) || !empty($synced['pay_salary_sheet_com'])),
        );
    }

    /**
     * Change record status (Approve, Cancel, etc.)
     */
    public function change_status($id, $new_status, $username)
    {
        $existing = $this->db->where('id', $id)->get($this->table)->row();
        if (!$existing) {
            return array('status' => false, 'message' => 'Record not found.');
        }
        if ($existing->status === 'Paid' && $new_status !== 'Paid') {
            return array('status' => false, 'message' => 'Cannot change status of an already paid arrear.');
        }

        $valid_statuses = array('Pending', 'Approved', 'Cancelled', 'Paid');
        if (!in_array($new_status, $valid_statuses)) {
            return array('status' => false, 'message' => 'Invalid status.');
        }

        $update = array(
            'status'     => $new_status,
            'updated_by' => $username,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        if ($new_status === 'Paid') {
            $update['paid_at'] = date('Y-m-d H:i:s');
        }

        $this->db->where('id', $id)->update($this->table, $update);

        // Auto-sync status change into salary sheet
        $synced = $this->sync_to_processed_salary_sheet($existing->emp_id, $existing->payment_month);

        return array(
            'status'         => true,
            'message'        => "Arrear status updated to {$new_status}.",
            'auto_processed' => (!empty($synced['pay_salary_sheet']) || !empty($synced['pay_salary_sheet_com'])),
        );
    }

    /**
     * Auto-sync arrear amount and net_pay to processed salary sheets (pay_salary_sheet and pay_salary_sheet_com)
     * If salary has already been processed for this employee in the given payment month, it auto-processes!
     */
    public function sync_to_processed_salary_sheet($emp_id, $payment_month)
    {
        $emp_id = trim((string)$emp_id);
        $pm = date('Y-m-01', strtotime($payment_month));
        $pm_short = substr($pm, 0, 7);

        // Calculate total approved arrear amount for this employee in this payment month
        $total_arrear = 0.00;
        $row = $this->db->select_sum('amount')
            ->where('emp_id', $emp_id)
            ->where("(payment_month = '{$pm}' OR payment_month = '{$pm_short}')")
            ->where('status', 'Approved')
            ->get($this->table)
            ->row();

        if ($row && !empty($row->amount)) {
            $total_arrear = round((float)$row->amount, 2);
        }

        $synced = array('pay_salary_sheet' => false, 'pay_salary_sheet_com' => false);

        // Sync pay_salary_sheet
        if ($this->db->table_exists('pay_salary_sheet')) {
            $sheet_row = $this->db->where('emp_id', $emp_id)
                ->where("(salary_month = '{$pm}' OR salary_month = '{$pm_short}')")
                ->get('pay_salary_sheet')
                ->row();

            if ($sheet_row) {
                $old_arrear = isset($sheet_row->arrear_amount) ? (float)$sheet_row->arrear_amount : 0.00;
                $current_net_pay = (float)$sheet_row->net_pay;
                $diff = $total_arrear - $old_arrear;
                $new_net_pay = $current_net_pay + $diff;

                $this->db->where('emp_id', $emp_id)
                    ->where("(salary_month = '{$pm}' OR salary_month = '{$pm_short}')")
                    ->update('pay_salary_sheet', array(
                        'arrear_amount' => $total_arrear,
                        'net_pay'       => $new_net_pay
                    ));
                $synced['pay_salary_sheet'] = true;
            }
        }

        // Sync pay_salary_sheet_com
        if ($this->db->table_exists('pay_salary_sheet_com')) {
            $sheet_com_row = $this->db->where('emp_id', $emp_id)
                ->where("(salary_month = '{$pm}' OR salary_month = '{$pm_short}')")
                ->get('pay_salary_sheet_com')
                ->row();

            if ($sheet_com_row) {
                $old_arrear_com = isset($sheet_com_row->arrear_amount) ? (float)$sheet_com_row->arrear_amount : 0.00;
                $current_net_pay_com = (float)$sheet_com_row->net_pay;
                $diff_com = $total_arrear - $old_arrear_com;
                $new_net_pay_com = $current_net_pay_com + $diff_com;

                $this->db->where('emp_id', $emp_id)
                    ->where("(salary_month = '{$pm}' OR salary_month = '{$pm_short}')")
                    ->update('pay_salary_sheet_com', array(
                        'arrear_amount' => $total_arrear,
                        'net_pay'       => $new_net_pay_com
                    ));
                $synced['pay_salary_sheet_com'] = true;
            }
        }

        return $synced;
    }

    /**
     * Search employees for AJAX autocomplete
     */
    public function search_employees($term, $unit_id = null)
    {
        $term = trim($term);
        if (empty($term)) return array();

        $this->db->select('c.emp_id, 
                           p.name_en, 
                           p.name_bn, 
                           c.unit_id,
                           c.gross_sal,
                           d.dept_name, 
                           deg.desig_name, 
                           u.unit_name');
        $this->db->from('pr_emp_com_info c');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'inner');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = c.unit_id', 'left');

        if (!empty($unit_id)) {
            $this->db->where('c.unit_id', $unit_id);
        }

        $this->db->group_start();
        $this->db->like('c.emp_id', $term);
        $this->db->or_like('p.name_en', $term);
        $this->db->group_end();

        $this->db->limit(15);
        return $this->db->get()->result();
    }

    /**
     * Get single employee detail
     */
    public function get_employee_details($emp_id)
    {
        $this->db->select('c.emp_id, 
                           p.name_en, 
                           p.name_bn, 
                           c.unit_id,
                           c.gross_sal,
                           c.emp_join_date,
                           d.dept_name, 
                           deg.desig_name, 
                           u.unit_name');
        $this->db->from('pr_emp_com_info c');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'inner');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = c.unit_id', 'left');
        $this->db->where('c.emp_id', $emp_id);
        return $this->db->get()->row();
    }

    /**
     * Retrieve total approved arrear amount for payroll calculation
     */
    public function get_applicable_arrear_amount($emp_id, $payment_month)
    {
        $pm = date('Y-m-01', strtotime($payment_month));
        $pm_short = substr($pm, 0, 7);

        $row = $this->db->select_sum('amount')
            ->where('emp_id', $emp_id)
            ->where("(payment_month = '{$pm}' OR payment_month = '{$pm_short}')")
            ->where('status', 'Approved')
            ->get($this->table)
            ->row();

        return ($row && !empty($row->amount)) ? round((float)$row->amount, 2) : 0.00;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advanced_salary_model extends CI_Model
{
    protected $table_advances   = 'advanced_salaries';
    protected $table_deductions = 'advanced_salary_deductions';

    public function __construct()
    {
        parent::__construct();
        $this->ensure_schema();
    }

    /**
     * Auto-create database tables and necessary schema columns if not exist
     */
    public function ensure_schema()
    {
        // 1. Table: advanced_salaries
        if (!$this->db->table_exists($this->table_advances)) {
            $sql = "CREATE TABLE IF NOT EXISTS `{$this->table_advances}` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `advance_id` VARCHAR(50) NOT NULL,
                `unit_id` INT(11) NULL DEFAULT 1,
                `emp_id` VARCHAR(64) NOT NULL,
                `advance_date` DATE NOT NULL,
                `advance_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `effective_month` VARCHAR(20) NOT NULL,
                `deduction_method` ENUM('one_time', 'installment') NOT NULL DEFAULT 'installment',
                `monthly_deduction_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `total_deducted` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `outstanding_balance` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `remarks` TEXT NULL,
                `status` ENUM('Pending', 'Approved', 'Disbursed', 'Partially Deducted', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Approved',
                `created_by` VARCHAR(100) NULL,
                `approved_by` VARCHAR(100) NULL,
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_advance_id` (`advance_id`),
                KEY `idx_emp_id` (`emp_id`),
                KEY `idx_effective_month` (`effective_month`),
                KEY `idx_status` (`status`),
                KEY `idx_unit_id` (`unit_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->db->query($sql);
        }

        // 2. Table: advanced_salary_deductions
        if (!$this->db->table_exists($this->table_deductions)) {
            $sql = "CREATE TABLE IF NOT EXISTS `{$this->table_deductions}` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `advanced_salary_id` INT(11) NOT NULL,
                `emp_id` VARCHAR(64) NOT NULL,
                `salary_month` VARCHAR(20) NOT NULL,
                `deduction_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `remaining_balance` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `salary_reference_id` VARCHAR(100) NULL,
                `deduction_date` DATETIME NOT NULL,
                `created_by` VARCHAR(100) NULL,
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_adv_salary_month` (`advanced_salary_id`, `salary_month`),
                KEY `idx_ded_emp_month` (`emp_id`, `salary_month`),
                KEY `idx_advanced_salary_id` (`advanced_salary_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->db->query($sql);
        }

        // 3. Ensure adv_deduct column exists in salary sheet tables
        if ($this->db->table_exists('pay_salary_sheet') && !$this->db->field_exists('adv_deduct', 'pay_salary_sheet')) {
            $this->db->query("ALTER TABLE `pay_salary_sheet` ADD COLUMN `adv_deduct` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `deduct_amount`");
        }
        if ($this->db->table_exists('pay_salary_sheet_com') && !$this->db->field_exists('adv_deduct', 'pay_salary_sheet_com')) {
            $this->db->query("ALTER TABLE `pay_salary_sheet_com` ADD COLUMN `adv_deduct` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `deduct_amount`");
        }
    }

    /**
     * Generate unique reference code for advance (e.g. ADV-202610-0001)
     */
    public function generate_advance_id()
    {
        $prefix = 'ADV-' . date('Ym') . '-';
        $this->db->select('advance_id');
        $this->db->like('advance_id', $prefix, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get($this->table_advances)->row();

        if ($last && !empty($last->advance_id)) {
            $parts = explode('-', $last->advance_id);
            $seq = isset($parts[2]) ? (int)$parts[2] + 1 : 1;
        } else {
            $seq = 1;
        }
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Format month to standard YYYY-MM
     */
    public function format_month($month_str)
    {
        if (empty($month_str)) {
            return date('Y-m');
        }
        $ts = strtotime($month_str);
        if ($ts === false) {
            return date('Y-m');
        }
        return date('Y-m', $ts);
    }

    /**
     * Save new Advance Record
     */
    public function save_advance($data, $username = '')
    {
        $this->ensure_schema();

        $emp_id = trim((string)$data['emp_id']);
        if (empty($emp_id)) {
            return array('status' => false, 'message' => 'Please select a valid employee.');
        }

        // Fetch employee unit
        $emp_com = $this->db->where('emp_id', $emp_id)->get('pr_emp_com_info')->row();
        $unit_id = ($emp_com && !empty($emp_com->unit_id)) ? (int)$emp_com->unit_id : (isset($data['unit_id']) ? (int)$data['unit_id'] : 1);

        $advance_amount = round((float)$data['advance_amount'], 2);
        if ($advance_amount <= 0) {
            return array('status' => false, 'message' => 'Advance salary amount must be greater than zero.');
        }

        $advance_date = !empty($data['advance_date']) ? date('Y-m-d', strtotime($data['advance_date'])) : date('Y-m-d');
        $effective_month = $this->format_month(!empty($data['effective_month']) ? $data['effective_month'] : date('Y-m'));

        $deduction_method = (!empty($data['deduction_method']) && $data['deduction_method'] === 'one_time') ? 'one_time' : 'installment';

        if ($deduction_method === 'one_time') {
            $monthly_deduction = $advance_amount;
        } else {
            $monthly_deduction = round((float)$data['monthly_deduction_amount'], 2);
            if ($monthly_deduction <= 0) {
                return array('status' => false, 'message' => 'Monthly deduction amount must be greater than zero.');
            }
            if ($monthly_deduction > $advance_amount) {
                $monthly_deduction = $advance_amount;
            }
        }

        $advance_id = $this->generate_advance_id();
        $status = !empty($data['status']) ? $data['status'] : 'Approved';
        $now = date('Y-m-d H:i:s');

        $insert_data = array(
            'advance_id'               => $advance_id,
            'unit_id'                  => $unit_id,
            'emp_id'                   => $emp_id,
            'advance_date'             => $advance_date,
            'advance_amount'           => $advance_amount,
            'effective_month'          => $effective_month,
            'deduction_method'         => $deduction_method,
            'monthly_deduction_amount' => $monthly_deduction,
            'total_deducted'           => 0.00,
            'outstanding_balance'      => $advance_amount,
            'remarks'                  => isset($data['remarks']) ? trim($data['remarks']) : '',
            'status'                   => $status,
            'created_by'               => $username,
            'approved_by'              => ($status === 'Approved' || $status === 'Disbursed') ? $username : null,
            'created_at'               => $now,
            'updated_at'               => $now,
        );

        $this->db->insert($this->table_advances, $insert_data);
        $new_id = $this->db->insert_id();

        // Check if salary for effective_month is already processed in pay_salary_sheet. If so, auto-sync!
        $synced = false;
        if (in_array($status, array('Approved', 'Disbursed', 'Partially Deducted'))) {
            $synced = $this->sync_to_processed_salary_sheet($emp_id, $effective_month);
        }

        return array(
            'status'        => true,
            'id'            => $new_id,
            'advance_id'    => $advance_id,
            'message'       => "Advanced Salary {$advance_id} for Employee {$emp_id} created successfully.",
            'auto_synced'   => $synced,
        );
    }

    /**
     * Update existing Advance Record
     */
    public function update_advance($id, $data, $username = '')
    {
        $this->ensure_schema();
        $record = $this->db->where('id', $id)->get($this->table_advances)->row();
        if (!$record) {
            return array('status' => false, 'message' => 'Advance record not found.');
        }

        if ($record->status === 'Completed') {
            return array('status' => false, 'message' => 'Cannot modify a completed advance.');
        }

        $now = date('Y-m-d H:i:s');
        $update = array('updated_at' => $now);

        if (isset($data['advance_amount'])) {
            $new_amount = round((float)$data['advance_amount'], 2);
            if ($new_amount <= 0) {
                return array('status' => false, 'message' => 'Advance salary amount must be greater than zero.');
            }
            if ($new_amount < (float)$record->total_deducted) {
                return array('status' => false, 'message' => "Advance amount cannot be less than already deducted amount (" . number_format($record->total_deducted, 2) . ").");
            }
            $update['advance_amount'] = $new_amount;
            $update['outstanding_balance'] = round($new_amount - (float)$record->total_deducted, 2);
        }

        if (isset($data['effective_month'])) {
            $update['effective_month'] = $this->format_month($data['effective_month']);
        }

        if (isset($data['advance_date'])) {
            $update['advance_date'] = date('Y-m-d', strtotime($data['advance_date']));
        }

        if (isset($data['deduction_method'])) {
            $update['deduction_method'] = ($data['deduction_method'] === 'one_time') ? 'one_time' : 'installment';
        }

        if (isset($data['monthly_deduction_amount'])) {
            $monthly_deduct = round((float)$data['monthly_deduction_amount'], 2);
            if ($monthly_deduct <= 0) {
                return array('status' => false, 'message' => 'Monthly deduction amount must be greater than zero.');
            }
            $update['monthly_deduction_amount'] = $monthly_deduct;
        }

        if (isset($data['remarks'])) {
            $update['remarks'] = trim((string)$data['remarks']);
        }

        if (isset($data['status'])) {
            $valid_statuses = array('Pending', 'Approved', 'Disbursed', 'Partially Deducted', 'Completed', 'Cancelled');
            if (in_array($data['status'], $valid_statuses)) {
                $update['status'] = $data['status'];
            }
        }

        // Auto-complete if outstanding is 0
        $cur_balance = isset($update['outstanding_balance']) ? $update['outstanding_balance'] : (float)$record->outstanding_balance;
        if ($cur_balance <= 0) {
            $update['status'] = 'Completed';
            $update['outstanding_balance'] = 0.00;
        }

        $this->db->where('id', $id)->update($this->table_advances, $update);

        // Auto-sync with processed salary if needed
        $target_month = isset($update['effective_month']) ? $update['effective_month'] : $record->effective_month;
        $synced = $this->sync_to_processed_salary_sheet($record->emp_id, $target_month);

        return array(
            'status'      => true,
            'message'     => 'Advance salary record updated successfully.',
            'auto_synced' => $synced,
        );
    }

    /**
     * Cancel an Advance record (stops future deductions)
     */
    public function cancel_advance($id, $username = '', $reason = '')
    {
        $this->ensure_schema();
        $record = $this->db->where('id', $id)->get($this->table_advances)->row();
        if (!$record) {
            return array('status' => false, 'message' => 'Advance record not found.');
        }

        if ($record->status === 'Cancelled') {
            return array('status' => false, 'message' => 'Record is already cancelled.');
        }
        if ($record->status === 'Completed') {
            return array('status' => false, 'message' => 'Cannot cancel a fully completed advance.');
        }

        $now = date('Y-m-d H:i:s');
        $remarks = trim((string)$record->remarks);
        if (!empty($reason)) {
            $remarks .= " | Cancelled on {$now} by {$username}: " . trim($reason);
        }

        $this->db->where('id', $id)->update($this->table_advances, array(
            'status'     => 'Cancelled',
            'remarks'    => $remarks,
            'updated_at' => $now,
        ));

        return array(
            'status'  => true,
            'message' => "Advance {$record->advance_id} cancelled successfully. No further deductions will occur.",
        );
    }

    /**
     * Delete an Advance record (Only allowed if no deductions occurred)
     */
    public function delete_advance($id)
    {
        $this->ensure_schema();
        $record = $this->db->where('id', $id)->get($this->table_advances)->row();
        if (!$record) {
            return array('status' => false, 'message' => 'Advance record not found.');
        }

        // Count deductions
        $ded_count = $this->db->where('advanced_salary_id', $id)->count_all_results($this->table_deductions);
        if ($ded_count > 0 || (float)$record->total_deducted > 0) {
            return array(
                'status'  => false,
                'message' => 'Cannot delete advance record because salary deductions have already been processed against it. Please Cancel it instead to halt future deductions.'
            );
        }

        $this->db->where('id', $id)->delete($this->table_advances);
        return array('status' => true, 'message' => "Advance record {$record->advance_id} deleted successfully.");
    }

    /**
     * Get single advance details with employee information
     */
    public function get_advance_by_id($id)
    {
        $this->ensure_schema();
        $this->db->select('a.*, 
                           p.name_en as emp_name, 
                           p.name_bn as emp_name_bn,
                           c.gross_sal,
                           c.emp_join_date,
                           d.dept_name,
                           deg.desig_name,
                           sec.sec_name_en as sec_name,
                           u.unit_name');
        $this->db->from("{$this->table_advances} a");
        $this->db->join('pr_emp_com_info c', 'c.emp_id = a.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = a.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('emp_section sec', 'sec.id = c.emp_sec_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = a.unit_id', 'left');
        $this->db->where('a.id', (int)$id);
        return $this->db->get()->row();
    }

    /**
     * Get deduction history for an advance
     */
    public function get_deductions_by_advance_id($advance_id)
    {
        $this->ensure_schema();
        $this->db->select('d.*, a.advance_amount, a.advance_id');
        $this->db->from("{$this->table_deductions} d");
        $this->db->join("{$this->table_advances} a", 'a.id = d.advanced_salary_id', 'left');
        $this->db->where('d.advanced_salary_id', (int)$advance_id);
        $this->db->order_by('d.salary_month', 'ASC');
        $this->db->order_by('d.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get Advances with search, filters, sorting, and pagination
     */
    public function get_advances($filters = array(), $limit = null, $offset = null)
    {
        $this->ensure_schema();
        $this->apply_filters($filters);

        $this->db->select('a.*, 
                           p.name_en as emp_name, 
                           p.name_bn as emp_name_bn,
                           c.gross_sal,
                           d.dept_name, 
                           deg.desig_name, 
                           u.unit_name');
        $this->db->from("{$this->table_advances} a");
        $this->db->join('pr_emp_com_info c', 'c.emp_id = a.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = a.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = a.unit_id', 'left');

        $sort_col = !empty($filters['sort_col']) ? $filters['sort_col'] : 'a.id';
        $sort_dir = !empty($filters['sort_dir']) && strtolower($filters['sort_dir']) === 'asc' ? 'ASC' : 'DESC';
        $this->db->order_by($sort_col, $sort_dir);

        if ($limit !== null) {
            $this->db->limit((int)$limit, (int)$offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Count advances matching filters
     */
    public function count_advances($filters = array())
    {
        $this->ensure_schema();
        $this->apply_filters($filters);
        $this->db->from("{$this->table_advances} a");
        $this->db->join('pr_emp_com_info c', 'c.emp_id = a.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = a.emp_id', 'left');
        return $this->db->count_all_results();
    }

    /**
     * Private helper to apply filter conditions to query builder
     */
    private function apply_filters($filters)
    {
        if (!empty($filters['unit_id'])) {
            $this->db->where('a.unit_id', (int)$filters['unit_id']);
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $this->db->where('a.status', $filters['status']);
        }

        if (!empty($filters['dept_id'])) {
            $this->db->where('c.emp_dept_id', (int)$filters['dept_id']);
        }

        if (!empty($filters['effective_month'])) {
            $em = $this->format_month($filters['effective_month']);
            $this->db->where("(a.effective_month = '{$em}' OR a.effective_month = '{$em}-01')");
        }

        if (!empty($filters['start_date'])) {
            $this->db->where('a.advance_date >=', date('Y-m-d', strtotime($filters['start_date'])));
        }

        if (!empty($filters['end_date'])) {
            $this->db->where('a.advance_date <=', date('Y-m-d', strtotime($filters['end_date'])));
        }

        if (!empty($filters['search'])) {
            $s = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('a.advance_id', $s);
            $this->db->or_like('a.emp_id', $s);
            $this->db->or_like('p.name_en', $s);
            $this->db->or_like('p.name_bn', $s);
            $this->db->group_end();
        }
    }

    /**
     * Get Dashboard Summary Metrics (Top Summary KPI Cards)
     */
    public function get_dashboard_summary($unit_id = null)
    {
        $this->ensure_schema();

        $this->db->select("
            COALESCE(SUM(advance_amount), 0) as total_advanced_amount,
            COALESCE(SUM(total_deducted), 0) as total_deducted_amount,
            COALESCE(SUM(outstanding_balance), 0) as total_outstanding_balance,
            COUNT(CASE WHEN status = 'Pending' THEN 1 END) as pending_count,
            COUNT(CASE WHEN status IN ('Approved', 'Disbursed', 'Partially Deducted') THEN 1 END) as active_count,
            COUNT(CASE WHEN status = 'Completed' THEN 1 END) as completed_count,
            COUNT(CASE WHEN status = 'Cancelled' THEN 1 END) as cancelled_count,
            COUNT(id) as total_count
        ");
        $this->db->from($this->table_advances);
        if (!empty($unit_id)) {
            $this->db->where('unit_id', (int)$unit_id);
        }
        $row = $this->db->get()->row();

        return array(
            'total_advanced'    => round((float)($row ? $row->total_advanced_amount : 0), 2),
            'total_deducted'    => round((float)($row ? $row->total_deducted_amount : 0), 2),
            'total_outstanding' => round((float)($row ? $row->total_outstanding_balance : 0), 2),
            'pending_count'     => (int)($row ? $row->pending_count : 0),
            'active_count'      => (int)($row ? $row->active_count : 0),
            'completed_count'   => (int)($row ? $row->completed_count : 0),
            'cancelled_count'   => (int)($row ? $row->cancelled_count : 0),
            'total_count'       => (int)($row ? $row->total_count : 0),
        );
    }

    /**
     * Get Report Data with latest deduction month for report table
     */
    public function get_report_data($filters = array())
    {
        $this->ensure_schema();
        $this->apply_filters($filters);

        $this->db->select("
            a.*,
            p.name_en as emp_name,
            c.gross_sal,
            d.dept_name,
            deg.desig_name,
            u.unit_name,
            (SELECT MAX(salary_month) FROM {$this->table_deductions} WHERE advanced_salary_id = a.id) as last_deduction_month
        ");
        $this->db->from("{$this->table_advances} a");
        $this->db->join('pr_emp_com_info c', 'c.emp_id = a.emp_id', 'left');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = a.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = a.unit_id', 'left');

        $this->db->order_by('a.id', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Core Integration Method: Called by Salary Process Model during Monthly Salary Calculation
     * 
     * Idempotent & Safe Business Rules:
     * 1. Only process advances where effective_month <= current_salary_month.
     * 2. Checks if deduction already recorded for this month (prevents duplicate deduction on re-run).
     * 3. Deducts min(monthly_deduction, outstanding_balance) so total never exceeds advance amount.
     * 4. Updates advance status (Completed when balance = 0, else Partially Deducted).
     */
    public function process_salary_deduction_for_employee($emp_id, $salary_month, $salary_ref = 'SALARY_PROCESS', $username = 'system')
    {
        $this->ensure_schema();

        $emp_id = trim((string)$emp_id);
        $clean_month = $this->format_month($salary_month);
        $salary_month_date = $clean_month . '-01';

        // Find active advances eligible for deduction
        // Effective month must be <= current salary month
        $this->db->where('emp_id', $emp_id);
        $this->db->where_in('status', array('Approved', 'Disbursed', 'Partially Deducted'));
        $this->db->where('outstanding_balance >', 0);
        $advances = $this->db->get($this->table_advances)->result();

        $total_deducted_this_month = 0.00;
        $now = date('Y-m-d H:i:s');

        foreach ($advances as $adv) {
            $eff_month = $this->format_month($adv->effective_month);
            // Rule 1: No deduction before Effective Month
            if ($clean_month < $eff_month) {
                continue;
            }

            // Rule 2: Check if already deducted in this salary month
            $this->db->where('advanced_salary_id', $adv->id);
            $this->db->where("(salary_month = '{$clean_month}' OR salary_month = '{$salary_month_date}')");
            $existing_ded = $this->db->get($this->table_deductions)->row();

            if ($existing_ded) {
                // Idempotent: Already recorded for this salary run, simply tally it
                $total_deducted_this_month += (float)$existing_ded->deduction_amount;
                continue;
            }

            // Calculate installment
            $monthly_rate = (float)$adv->monthly_deduction_amount;
            $outstanding  = (float)$adv->outstanding_balance;

            // For one-time deduction method, take whole remaining balance
            if ($adv->deduction_method === 'one_time') {
                $monthly_rate = $outstanding;
            }

            $deduct_amount = min($monthly_rate, $outstanding);
            $deduct_amount = round($deduct_amount, 2);

            if ($deduct_amount <= 0) {
                continue;
            }

            $new_balance = round($outstanding - $deduct_amount, 2);
            $new_total_ded = round((float)$adv->total_deducted + $deduct_amount, 2);
            $new_status = ($new_balance <= 0) ? 'Completed' : 'Partially Deducted';

            // Insert deduction record
            $ded_data = array(
                'advanced_salary_id'  => $adv->id,
                'emp_id'              => $emp_id,
                'salary_month'        => $clean_month,
                'deduction_amount'    => $deduct_amount,
                'remaining_balance'   => $new_balance,
                'salary_reference_id' => $salary_ref,
                'deduction_date'      => $now,
                'created_by'          => $username,
                'created_at'          => $now,
                'updated_at'          => $now,
            );
            $this->db->insert($this->table_deductions, $ded_data);

            // Update parent advance
            $this->db->where('id', $adv->id)->update($this->table_advances, array(
                'total_deducted'      => $new_total_ded,
                'outstanding_balance' => $new_balance,
                'status'              => $new_status,
                'updated_at'          => $now,
            ));

            $total_deducted_this_month += $deduct_amount;
        }

        return round($total_deducted_this_month, 2);
    }

    /**
     * Auto-sync advance deduction into processed salary sheets if already generated
     */
    public function sync_to_processed_salary_sheet($emp_id, $target_month)
    {
        $this->ensure_schema();

        $emp_id = trim((string)$emp_id);
        $clean_month = $this->format_month($target_month);
        $clean_month_date = $clean_month . '-01';

        // Check if salary sheet exists for this month
        $sheet = $this->db->where('emp_id', $emp_id)
                          ->where("(salary_month = '{$clean_month}' OR salary_month = '{$clean_month_date}')")
                          ->get('pay_salary_sheet')
                          ->row();

        if (!$sheet) {
            return false;
        }

        // Process deduction for this month
        $adv_deduct = $this->process_salary_deduction_for_employee($emp_id, $clean_month, 'AUTO_SYNC');

        // Recalculate total deduction & net pay for pay_salary_sheet
        $abs_deduct    = (float)$sheet->abs_deduction;
        $late_deduct   = (float)$sheet->late_deduct;
        $others_deduct = (float)$sheet->others_deduct;
        $tax_deduct    = (float)$sheet->tax_deduct;
        $stamp         = (float)$sheet->stamp;

        $new_total_ded = $adv_deduct + $abs_deduct + $late_deduct + $others_deduct + $tax_deduct + $stamp;
        $gross         = (float)$sheet->gross_sal;
        $att_bonus     = (float)$sheet->att_bonus;
        $ot_amount     = (float)$sheet->ot_amount;
        $arrear        = isset($sheet->arrear_amount) ? (float)$sheet->arrear_amount : 0.00;
        $new_net_pay   = round($gross + $att_bonus + $ot_amount + $arrear - $new_total_ded, 2);

        $this->db->where('id', $sheet->id)->update('pay_salary_sheet', array(
            'adv_deduct'   => $adv_deduct,
            'total_deduct' => $new_total_ded,
            'net_pay'      => $new_net_pay,
        ));

        // Sync compliance sheet pay_salary_sheet_com if exists
        $sheet_com = $this->db->where('emp_id', $emp_id)
                              ->where("(salary_month = '{$clean_month}' OR salary_month = '{$clean_month_date}')")
                              ->get('pay_salary_sheet_com')
                              ->row();
        if ($sheet_com) {
            $abs_deduct_com    = (float)$sheet_com->abs_deduction;
            $late_deduct_com   = (float)$sheet_com->late_deduct;
            $others_deduct_com = (float)$sheet_com->others_deduct;
            $tax_deduct_com    = (float)$sheet_com->tax_deduct;
            $stamp_com         = (float)$sheet_com->stamp;

            $new_total_ded_com = $adv_deduct + $abs_deduct_com + $late_deduct_com + $others_deduct_com + $tax_deduct_com + $stamp_com;
            $gross_com         = (float)$sheet_com->gross_sal;
            $att_bonus_com     = (float)$sheet_com->att_bonus;
            $ot_amount_com     = (float)$sheet_com->ot_amount;
            $arrear_com        = isset($sheet_com->arrear_amount) ? (float)$sheet_com->arrear_amount : 0.00;
            $new_net_pay_com   = round($gross_com + $att_bonus_com + $ot_amount_com + $arrear_com - $new_total_ded_com, 2);

            $this->db->where('id', $sheet_com->id)->update('pay_salary_sheet_com', array(
                'adv_deduct'   => $adv_deduct,
                'total_deduct' => $new_total_ded_com,
                'net_pay'      => $new_net_pay_com,
            ));
        }

        return true;
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
            $this->db->where('c.unit_id', (int)$unit_id);
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
                           sec.sec_name_en as sec_name,
                           u.unit_name');
        $this->db->from('pr_emp_com_info c');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'inner');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_designation deg', 'deg.id = c.emp_desi_id', 'left');
        $this->db->join('emp_section sec', 'sec.id = c.emp_sec_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = c.unit_id', 'left');
        $this->db->where('c.emp_id', $emp_id);
        return $this->db->get()->row();
    }
}

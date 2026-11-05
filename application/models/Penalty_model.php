<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penalty_model extends CI_Model
{
    protected $table = 'emp_penaltys';

    public function __construct()
    {
        parent::__construct();
        $this->ensure_schema();
    }

    private function ensure_schema()
    {
        if (!$this->db->table_exists($this->table)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `unit_id` int(11) DEFAULT 1,
              `emp_id` varchar(64) NOT NULL,
              `salary_month` varchar(10) NOT NULL,
              `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `remarks` text DEFAULT NULL,
              `status` varchar(20) NOT NULL DEFAULT 'Approved',
              `created_by` varchar(64) DEFAULT NULL,
              `created_at` datetime NOT NULL,
              `updated_at` datetime DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `idx_emp_month` (`emp_id`, `salary_month`),
              KEY `idx_salary_month` (`salary_month`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        }

        if ($this->db->table_exists('pay_salary_sheet') && !$this->db->field_exists('palanty_deduct', 'pay_salary_sheet')) {
            $this->db->query("ALTER TABLE `pay_salary_sheet` ADD COLUMN `palanty_deduct` decimal(10,2) NOT NULL DEFAULT 0.00 AFTER `adv_deduct`");
        }
        if ($this->db->table_exists('pay_salary_sheet_com') && !$this->db->field_exists('palanty_deduct', 'pay_salary_sheet_com')) {
            $this->db->query("ALTER TABLE `pay_salary_sheet_com` ADD COLUMN `palanty_deduct` decimal(10,2) NOT NULL DEFAULT 0.00 AFTER `adv_deduct`");
        }
    }

    public function get_dashboard_summary($unit_id = null)
    {
        $this->db->select("
            COUNT(*) as total_count,
            COALESCE(SUM(amount), 0) as total_amount,
            COALESCE(SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END), 0) as approved_count,
            COALESCE(SUM(CASE WHEN status = 'Approved' THEN amount ELSE 0 END), 0) as approved_amount,
            COALESCE(SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END), 0) as pending_count,
            COALESCE(SUM(CASE WHEN status = 'Pending' THEN amount ELSE 0 END), 0) as pending_amount,
            COALESCE(SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END), 0) as cancelled_count,
            COALESCE(SUM(CASE WHEN status = 'Cancelled' THEN amount ELSE 0 END), 0) as cancelled_amount
        ");
        $this->db->from($this->table);
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $row = $this->db->get()->row();
        return (object) array(
            'total_count'      => (int)($row->total_count ?? 0),
            'total_amount'     => (float)($row->total_amount ?? 0),
            'approved_count'   => (int)($row->approved_count ?? 0),
            'approved_amount'  => (float)($row->approved_amount ?? 0),
            'pending_count'    => (int)($row->pending_count ?? 0),
            'pending_amount'   => (float)($row->pending_amount ?? 0),
            'cancelled_count'  => (int)($row->cancelled_count ?? 0),
            'cancelled_amount' => (float)($row->cancelled_amount ?? 0),
        );
    }

    private function apply_filters($filters)
    {
        if (!empty($filters['unit_id'])) {
            $this->db->where('p.unit_id', $filters['unit_id']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('p.status', $filters['status']);
        }
        if (!empty($filters['salary_month'])) {
            $clean_month = date('Y-m', strtotime($filters['salary_month'] . '-01'));
            $this->db->where('p.salary_month', $clean_month);
        }
        if (!empty($filters['dept_id'])) {
            $this->db->where('com.emp_dept_id', $filters['dept_id']);
        }
        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $this->db->group_start();
            $this->db->like('p.emp_id', $term);
            $this->db->or_like('per.name_en', $term);
            $this->db->or_like('per.personal_mobile', $term);
            $this->db->group_end();
        }
    }

    public function count_palantys($filters = array())
    {
        $this->db->from("{$this->table} p");
        $this->db->join('pr_emp_com_info com', 'com.emp_id = p.emp_id', 'left');
        $this->db->join('pr_emp_per_info per', 'per.emp_id = p.emp_id', 'left');
        $this->apply_filters($filters);
        return $this->db->count_all_results();
    }

    public function get_palantys($filters = array(), $limit = 20, $offset = 0)
    {
        $this->db->select("
            p.*,
            per.name_en as emp_name,
            per.personal_mobile as mobile,
            dept.dept_name,
            sec.sec_name_en as sec_name,
            desig.desig_name,
            com.gross_sal,
            u.unit_name
        ");
        $this->db->from("{$this->table} p");
        $this->db->join('pr_emp_com_info com', 'com.emp_id = p.emp_id', 'left');
        $this->db->join('pr_emp_per_info per', 'per.emp_id = p.emp_id', 'left');
        $this->db->join('emp_depertment dept', 'dept.dept_id = com.emp_dept_id', 'left');
        $this->db->join('emp_section sec', 'sec.id = com.emp_sec_id', 'left');
        $this->db->join('emp_designation desig', 'desig.id = com.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = p.unit_id', 'left');
        $this->apply_filters($filters);

        $sort_col = !empty($filters['sort_col']) ? $filters['sort_col'] : 'p.id';
        $sort_dir = !empty($filters['sort_dir']) && strtolower($filters['sort_dir']) === 'asc' ? 'ASC' : 'DESC';
        $this->db->order_by($sort_col, $sort_dir);

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select("
            p.*,
            per.name_en as emp_name,
            per.personal_mobile as mobile,
            dept.dept_name,
            sec.sec_name_en as sec_name,
            desig.desig_name,
            com.gross_sal,
            u.unit_name
        ");
        $this->db->from("{$this->table} p");
        $this->db->join('pr_emp_com_info com', 'com.emp_id = p.emp_id', 'left');
        $this->db->join('pr_emp_per_info per', 'per.emp_id = p.emp_id', 'left');
        $this->db->join('emp_depertment dept', 'dept.dept_id = com.emp_dept_id', 'left');
        $this->db->join('emp_section sec', 'sec.id = com.emp_sec_id', 'left');
        $this->db->join('emp_designation desig', 'desig.id = com.emp_desi_id', 'left');
        $this->db->join('pr_units u', 'u.unit_id = p.unit_id', 'left');
        $this->db->where('p.id', (int)$id);
        return $this->db->get()->row();
    }

    public function search_employees($query, $unit_id = null)
    {
        $this->db->select("
            c.emp_id,
            c.unit_id,
            p.name_en,
            p.personal_mobile as mobile,
            d.dept_name,
            s.sec_name_en as sec_name,
            ds.desig_name,
            c.gross_sal,
            c.emp_join_date
        ");
        $this->db->from('pr_emp_com_info c');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('emp_designation ds', 'ds.id = c.emp_desi_id', 'left');

        if (!empty($unit_id)) {
            $this->db->where('c.unit_id', $unit_id);
        }

        $this->db->group_start();
        $this->db->like('c.emp_id', $query);
        $this->db->or_like('p.name_en', $query);
        $this->db->or_like('p.personal_mobile', $query);
        $this->db->group_end();

        $this->db->limit(15);
        return $this->db->get()->result();
    }

    public function get_employee_details($emp_id)
    {
        $this->db->select("
            c.emp_id,
            c.unit_id,
            p.name_en,
            p.personal_mobile as mobile,
            d.dept_name,
            s.sec_name_en as sec_name,
            ds.desig_name,
            c.gross_sal,
            c.emp_join_date
        ");
        $this->db->from('pr_emp_com_info c');
        $this->db->join('pr_emp_per_info p', 'p.emp_id = c.emp_id', 'left');
        $this->db->join('emp_depertment d', 'd.dept_id = c.emp_dept_id', 'left');
        $this->db->join('emp_section s', 's.id = c.emp_sec_id', 'left');
        $this->db->join('emp_designation ds', 'ds.id = c.emp_desi_id', 'left');
        $this->db->where('c.emp_id', $emp_id);
        return $this->db->get()->row();
    }

    public function get_palanty_deduction($emp_id, $salary_month)
    {
        $clean_month = date('Y-m', strtotime($salary_month));
        $this->db->select_sum('amount');
        $this->db->from($this->table);
        $this->db->where('emp_id', $emp_id);
        $this->db->where("(salary_month = '$clean_month' OR salary_month = '" . substr($salary_month, 0, 7) . "')");
        $this->db->where('status', 'Approved');
        $row = $this->db->get()->row();
        return ($row && !empty($row->amount)) ? round((float)$row->amount, 2) : 0.00;
    }
}

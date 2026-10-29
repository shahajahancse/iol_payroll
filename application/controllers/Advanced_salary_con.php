<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advanced_salary_con extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Authentication check
        if ($this->session->userdata('logged_in') == false) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')
                             ->set_status_header(401)
                             ->set_output(json_encode(array('status' => false, 'message' => 'Session expired. Please login again.')));
                return;
            }
            redirect("authentication");
        }

        $this->load->model('Advanced_salary_model');
        $this->load->helper('url');
        $this->load->helper('form');

        $this->data['user_data'] = $this->session->userdata('data');
        $this->data['username']  = !empty($this->data['user_data']->id_number) ? $this->data['user_data']->id_number : 'admin';
        $this->data['page_bg']   = '#ffffff';
    }

    /**
     * Get accessible unit ID for current user
     */
    private function get_scoped_unit_id()
    {
        $user = $this->data['user_data'];
        if ($user && isset($user->level) && $user->level === 'All') {
            return null;
        }
        return ($user && !empty($user->unit_name)) ? $user->unit_name : null;
    }

    /**
     * Advanced Salary Single-Page Management Dashboard
     */
    public function index()
    {
        $unit_id = $this->get_scoped_unit_id();

        $this->data['title']       = 'Advanced Salary Management';
        $this->data['unit_id']     = $unit_id;
        $this->data['summary']     = $this->Advanced_salary_model->get_dashboard_summary($unit_id);
        $this->data['departments'] = $this->db->order_by('dept_name', 'ASC')->get('emp_depertment')->result();
        $this->data['units']       = $this->db->get('pr_units')->result();

        $this->data['subview'] = 'advanced_salary/index';
        $this->load->view('layout/template', $this->data);
    }

    /**
     * AJAX endpoint: Get paginated and filtered list of advances
     */
    public function list_ajax()
    {
        $limit  = $this->input->get_post('limit') ? (int)$this->input->get_post('limit') : 20;
        $page   = $this->input->get_post('page') ? (int)$this->input->get_post('page') : 1;
        $offset = ($page - 1) * $limit;

        $filters = array(
            'search'          => trim((string)$this->input->get_post('search')),
            'dept_id'         => $this->input->get_post('dept_id'),
            'effective_month' => $this->input->get_post('effective_month'),
            'status'          => $this->input->get_post('status'),
            'unit_id'         => $this->input->get_post('unit_id') ? $this->input->get_post('unit_id') : $this->get_scoped_unit_id(),
            'start_date'      => $this->input->get_post('start_date'),
            'end_date'        => $this->input->get_post('end_date'),
            'sort_col'        => $this->input->get_post('sort_col'),
            'sort_dir'        => $this->input->get_post('sort_dir'),
        );

        $total_rows = $this->Advanced_salary_model->count_advances($filters);
        $records    = $this->Advanced_salary_model->get_advances($filters, $limit, $offset);
        $summary    = $this->Advanced_salary_model->get_dashboard_summary($filters['unit_id']);

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'     => 'success',
            'records'    => $records,
            'total_rows' => $total_rows,
            'page'       => $page,
            'limit'      => $limit,
            'total_pages'=> ceil($total_rows / $limit),
            'summary'    => $summary,
        )));
    }

    /**
     * AJAX endpoint: Get single advance details & complete deduction history
     */
    public function get_details_ajax($id)
    {
        $id = (int)$id;
        $record = $this->Advanced_salary_model->get_advance_by_id($id);
        if (!$record) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Advance record not found.',
            )));
        }

        $deductions = $this->Advanced_salary_model->get_deductions_by_advance_id($id);

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'     => true,
            'record'     => $record,
            'deductions' => $deductions,
        )));
    }

    /**
     * AJAX endpoint: Create or Update an Advance record
     */
    public function save()
    {
        $id = $this->input->post('id');

        $emp_id          = trim((string)$this->input->post('emp_id'));
        $advance_amount  = (float)$this->input->post('advance_amount');
        $advance_date    = trim((string)$this->input->post('advance_date'));
        $effective_month = trim((string)$this->input->post('effective_month'));
        $deduction_method= trim((string)$this->input->post('deduction_method'));
        $monthly_deduct  = (float)$this->input->post('monthly_deduction_amount');
        $remarks         = trim((string)$this->input->post('remarks'));
        $status          = trim((string)$this->input->post('status'));

        // Basic validations
        if (empty($id) && empty($emp_id)) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Please select an employee.',
            )));
        }

        if ($advance_amount <= 0) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Advance salary amount must be greater than zero.',
            )));
        }

        if (empty($effective_month)) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Effective Month is required.',
            )));
        }

        if ($deduction_method !== 'one_time' && $monthly_deduct <= 0) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Monthly deduction amount must be greater than zero for installment deduction method.',
            )));
        }

        $payload = array(
            'emp_id'                   => $emp_id,
            'advance_amount'           => $advance_amount,
            'advance_date'             => !empty($advance_date) ? $advance_date : date('Y-m-d'),
            'effective_month'          => $effective_month,
            'deduction_method'         => $deduction_method,
            'monthly_deduction_amount' => ($deduction_method === 'one_time') ? $advance_amount : $monthly_deduct,
            'remarks'                  => $remarks,
            'status'                   => !empty($id) && !empty($status) ? $status : 'Approved',
        );

        if (!empty($id)) {
            $res = $this->Advanced_salary_model->update_advance((int)$id, $payload, $this->data['username']);
        } else {
            $res = $this->Advanced_salary_model->save_advance($payload, $this->data['username']);
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }

    /**
     * AJAX endpoint: Cancel an Advance (prevents any further deductions)
     */
    public function cancel($id)
    {
        $id = (int)$id;
        $reason = trim((string)$this->input->post('reason'));
        $res = $this->Advanced_salary_model->cancel_advance($id, $this->data['username'], $reason);
        return $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }

    /**
     * AJAX endpoint: Delete an Advance record (Only if no deductions exist)
     */
    public function delete($id)
    {
        $id = (int)$id;
        $res = $this->Advanced_salary_model->delete_advance($id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }

    /**
     * AJAX Search Employees for autocomplete
     */
    public function employee_search_ajax()
    {
        $term    = $this->input->post('q') ? $this->input->post('q') : $this->input->get('q');
        $unit_id = $this->input->post('unit_id') ? (int)$this->input->post('unit_id') : null;

        $results = $this->Advanced_salary_model->search_employees($term, $unit_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status' => 'success',
            'data'   => $results,
        )));
    }

    /**
     * AJAX Get single employee details by ID
     */
    public function get_employee_ajax()
    {
        $emp_id = trim((string)$this->input->post('emp_id'));
        $emp = $this->Advanced_salary_model->get_employee_details($emp_id);

        if ($emp) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status' => true,
                'data'   => $emp,
            )));
        } else {
            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => false,
                'message' => 'Employee not found.',
            )));
        }
    }

    /**
     * AJAX endpoint: Get report data
     */
    public function report_data_ajax()
    {
        $filters = array(
            'search'          => trim((string)$this->input->get_post('search')),
            'dept_id'         => $this->input->get_post('dept_id'),
            'effective_month' => $this->input->get_post('effective_month'),
            'status'          => $this->input->get_post('status'),
            'unit_id'         => $this->input->get_post('unit_id') ? $this->input->get_post('unit_id') : $this->get_scoped_unit_id(),
            'start_date'      => $this->input->get_post('start_date'),
            'end_date'        => $this->input->get_post('end_date'),
        );

        $report_data = $this->Advanced_salary_model->get_report_data($filters);
        $summary     = $this->Advanced_salary_model->get_dashboard_summary($filters['unit_id']);

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'status'  => 'success',
            'data'    => $report_data,
            'summary' => $summary,
        )));
    }

    /**
     * Export Report to Excel (.xls)
     */
    public function export_excel()
    {
        $filters = array(
            'search'          => trim((string)$this->input->get('search')),
            'dept_id'         => $this->input->get('dept_id'),
            'effective_month' => $this->input->get('effective_month'),
            'status'          => $this->input->get('status'),
            'unit_id'         => $this->input->get('unit_id') ? $this->input->get('unit_id') : $this->get_scoped_unit_id(),
            'start_date'      => $this->input->get('start_date'),
            'end_date'        => $this->input->get('end_date'),
        );

        $data = $this->Advanced_salary_model->get_report_data($filters);

        $filename = "Advanced_Salary_Report_" . date('Ymd_His') . ".xls";
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'>";
        echo "<tr style='background:#006ba3;color:#ffffff;font-weight:bold;'>";
        echo "<th>SL</th><th>Advance ID</th><th>Emp ID</th><th>Name</th><th>Department</th><th>Designation</th>";
        echo "<th>Advance Date</th><th>Advance Amount</th><th>Effective Month</th><th>Monthly Deduction</th>";
        echo "<th>Total Deducted</th><th>Outstanding Balance</th><th>Last Deduction Month</th><th>Status</th>";
        echo "</tr>";

        $sl = 1;
        $tot_adv = 0; $tot_ded = 0; $tot_out = 0;
        foreach ($data as $r) {
            $tot_adv += (float)$r->advance_amount;
            $tot_ded += (float)$r->total_deducted;
            $tot_out += (float)$r->outstanding_balance;
            echo "<tr>";
            echo "<td>" . $sl++ . "</td>";
            echo "<td>" . htmlspecialchars($r->advance_id) . "</td>";
            echo "<td>" . htmlspecialchars($r->emp_id) . "</td>";
            echo "<td>" . htmlspecialchars($r->emp_name) . "</td>";
            echo "<td>" . htmlspecialchars($r->dept_name) . "</td>";
            echo "<td>" . htmlspecialchars($r->desig_name) . "</td>";
            echo "<td>" . htmlspecialchars($r->advance_date) . "</td>";
            echo "<td align='right'>" . number_format($r->advance_amount, 2) . "</td>";
            echo "<td>" . htmlspecialchars($r->effective_month) . "</td>";
            echo "<td align='right'>" . number_format($r->monthly_deduction_amount, 2) . "</td>";
            echo "<td align='right'>" . number_format($r->total_deducted, 2) . "</td>";
            echo "<td align='right'>" . number_format($r->outstanding_balance, 2) . "</td>";
            echo "<td>" . (!empty($r->last_deduction_month) ? htmlspecialchars($r->last_deduction_month) : '-') . "</td>";
            echo "<td>" . htmlspecialchars($r->status) . "</td>";
            echo "</tr>";
        }

        echo "<tr style='background:#f1f5f9;font-weight:bold;'>";
        echo "<td colspan='7' align='right'>Grand Total:</td>";
        echo "<td align='right'>" . number_format($tot_adv, 2) . "</td>";
        echo "<td></td><td></td>";
        echo "<td align='right'>" . number_format($tot_ded, 2) . "</td>";
        echo "<td align='right'>" . number_format($tot_out, 2) . "</td>";
        echo "<td></td><td></td>";
        echo "</tr>";
        echo "</table>";
        exit;
    }

    /**
     * Export Report to CSV (.csv)
     */
    public function export_csv()
    {
        $filters = array(
            'search'          => trim((string)$this->input->get('search')),
            'dept_id'         => $this->input->get('dept_id'),
            'effective_month' => $this->input->get('effective_month'),
            'status'          => $this->input->get('status'),
            'unit_id'         => $this->input->get('unit_id') ? $this->input->get('unit_id') : $this->get_scoped_unit_id(),
            'start_date'      => $this->input->get('start_date'),
            'end_date'        => $this->input->get('end_date'),
        );

        $data = $this->Advanced_salary_model->get_report_data($filters);

        $filename = "Advanced_Salary_Report_" . date('Ymd_His') . ".csv";
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $output = fopen("php://output", "w");
        // UTF-8 BOM for Excel compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($output, array(
            'SL', 'Advance ID', 'Emp ID', 'Name', 'Department', 'Designation',
            'Advance Date', 'Advance Amount', 'Effective Month', 'Monthly Deduction',
            'Total Deducted', 'Outstanding Balance', 'Last Deduction Month', 'Status'
        ));

        $sl = 1;
        foreach ($data as $r) {
            fputcsv($output, array(
                $sl++,
                $r->advance_id,
                $r->emp_id,
                $r->emp_name,
                $r->dept_name,
                $r->desig_name,
                $r->advance_date,
                $r->advance_amount,
                $r->effective_month,
                $r->monthly_deduction_amount,
                $r->total_deducted,
                $r->outstanding_balance,
                !empty($r->last_deduction_month) ? $r->last_deduction_month : '-',
                $r->status
            ));
        }
        fclose($output);
        exit;
    }
}

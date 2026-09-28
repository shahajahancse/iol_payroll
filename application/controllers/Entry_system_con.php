<?php

class Entry_system_con extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Attn_process_model');
        $this->load->helper('url');

        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
        if (!check_acl_list($this->data['user_data']->id, 3)) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
            redirect("payroll_con");
            exit;
        }
    }

    //----------------------------------------------------------------------------------------
    // GRID Display for Alert System
    //----------------------------------------------------------------------------------------
    public function alert_system()
    {
        $emp_id       = $_POST['emp_id'];
        $unit_id      = $_POST['unit_id'];
        $alert_date   = $_POST['alert_date'];
        $msg          = $_POST['msg'];

        $this->db->where('unit_id', $unit_id)->where('emp_id', $emp_id);
        $check = $this->db->where('date', date("Y-m-d", strtotime($alert_date)))->get('emp_alert_message')->row();
        if (empty($check)) {
            $data = array(
                'unit_id'   => $unit_id,
                'emp_id'    => $emp_id,
                'date'      => date("Y-m-d", strtotime($alert_date)),
                'msg'       => $msg,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $this->data['user_data']->id,

            );
            if ($this->db->insert('emp_alert_message', $data)) {
                echo 'success';
                exit;
            } else {
                echo 'Record Not Inserted';
                exit;
            }
        } else {
            $data = array(
                'msg'       => $msg,
            );
            $this->db->where('unit_id', $unit_id)->where('emp_id', $emp_id)->where('date', date("Y-m-d"));
            if ($this->db->update('emp_alert_message', $data)) {
                echo 'success';
                exit;
            } else {
                echo 'Record Not Inserted';
                exit;
            }
        }
        echo 'Record Not Inserted';
    }
    //----------------------------------------------------------------------------------------
    // GRID Display for Alert System
    //----------------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------------
    // GRID Display for Stop Salary System
    //----------------------------------------------------------------------------------------
    public function stop_salary()
    {
        $sql           = $_POST['emp_id'];
        $unit_id       = $_POST['unit_id'];
        $salary_month  = date('Y-m-01', strtotime($_POST['stop_month']));
        $emp_ids       = explode(',', $sql);

        foreach ($emp_ids as $key => $emp_id) {
            $this->db->where('unit_id', $unit_id)->where('emp_id',$emp_id);
            $check = $this->db->where('salary_month', $salary_month)->get('pay_emp_stop_salary')->row();
            if (empty($check)) {
                $data = array(
                    'unit_id' => $unit_id,
                    'emp_id' => $emp_id,
                    'salary_month' => $salary_month,
                );
                $this->db->insert('pay_emp_stop_salary', $data);
            }
        }

        $data2 = array(
            'stop_salary' => 2,
        );

        $this->db->where_in('emp_id', $emp_ids)->where('salary_month', $salary_month);
        if ($this->db->update('pay_salary_sheet', $data2)) {
            echo 'success';
        } else {
            echo 'Record Not Inserted';
        }
    }
    public function stop_delete()
    {
        $sql           = $_POST['emp_id'];
        $unit_id       = $_POST['unit_id'];
        $salary_month  = date('Y-m-01', strtotime($_POST['stop_month']));
        $emp_ids       = explode(',', $sql);

        $this->db->where('unit_id', $unit_id)->where_in('emp_id',$emp_ids);
        $this->db->where('salary_month', $salary_month)->delete('pay_emp_stop_salary');

        $data2 = array(
            'stop_salary' => 1,
        );
        $this->db->where_in('emp_id', $emp_ids)->where('salary_month', $salary_month);
        if ($this->db->update('pay_salary_sheet', $data2)) {
            echo 'success';
        } else {
            echo 'Record Not Deleted';
        }
    }
    // ==================  stop salary end  ======================
    // ====================================================================

    //-------------------------------------------------------------------------------------------------------
    // GRID Display for advance System
    //-------------------------------------------------------------------------------------------------------
    public function advance_salary()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

        // --- Date / Month filter ---
        $search_type   = $this->input->get('search_type');   // 'range' | 'month'
        $from_date     = $this->input->get('from_date');
        $to_date       = $this->input->get('to_date');
        $search_month  = $this->input->get('search_month');   // yyyy-mm

        $this->db->select('loan.*, per.name_en, pr_units.unit_name');
        $this->db->from('pr_advance_loan loan');
        $this->db->join('pr_emp_per_info per', 'loan.emp_id = per.emp_id', 'left');
        $this->db->join('pr_units', 'loan.unit_id = pr_units.unit_id', 'left');

        if ($search_type === 'range' && !empty($from_date) && !empty($to_date)) {
            $fd = date('Y-m-01', strtotime($from_date));
            $td = date('Y-m-01', strtotime($to_date));
            $this->db->where("loan.loan_month BETWEEN '$fd' AND '$td'");
        } elseif ($search_type === 'month' && !empty($search_month)) {
            $month_first = date('Y-m-01', strtotime($search_month . '-01'));
            $this->db->where('loan.loan_month', $month_first);
        }

        $this->db->order_by('loan.loan_month', 'DESC');
        $this->data['results'] = $this->db->get()->result();

        // pass filter values back for form pre-fill
        $this->data['search_type']  = $search_type;
        $this->data['from_date']    = $from_date;
        $this->data['to_date']      = $to_date;
        $this->data['search_month'] = $search_month;

        $this->data['title'] = 'Advance Salary';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/advance_salary';
        $this->load->view('layout/template', $this->data);
    }
    public function advance_salary_form()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->db->select('emp_depertment.*, pr_units.unit_name');
        $this->db->from('emp_depertment');
        $this->db->join('pr_units', 'pr_units.unit_id = emp_depertment.unit_id', 'left');
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('emp_depertment.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['departments'] = $this->db->get()->result();

        $this->data['title'] = 'Advance Loan Entry';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/advance_salary_form';
        $this->load->view('layout/template', $this->data);

    }
    function advance_salary_entry() {
        $unit_id       = $_POST['unit_id'];
        $emp_id        = $_POST['emp_id'];
        $loan_month    = date('Y-m-01', strtotime($_POST['loan_month']));
        $from_date     = date('Y-m-d', strtotime($_POST['from_date']));
        $to_date       = date('Y-m-d', strtotime($_POST['to_date']));
        $salary_type   = $_POST['salary_type'];
        $ot            = $_POST['ot'];
        $attn_bonus    = $_POST['attn_bonus'];
        $effect_month  = date('Y-m-01', strtotime($_POST['effect_month']));
        $emp_ids       = explode(',', $emp_id);
		$num_of_days   = date("t", strtotime($loan_month));
        $st = false;
        foreach ($emp_ids as $row) {
            // attendance status check with out ml leave
            $info = $this->db->where('emp_id', $row)->get('pr_emp_com_info')->row();
            $attendances = $this->attendance_check($row, $from_date, $to_date);
            $attend  =  $attendances->attend;
            $absent  =  $attendances->absent;
            $weekend =  $attendances->weekend;
            $holiday =  $attendances->holiday;
            $total_leave =  $attendances->total_leave;

            // pay days calculation
            $pay_days = $attend + $weekend + $holiday + $total_leave;
            // pay days calculation

            // attendance bonus calculation
            $att_check = $attend + $weekend  + $holiday;
            $att_bouns = 0;
            if($att_check >= $num_of_days && $absent == 0 && $attn_bonus == 1)
            {
                $allowances = $this->get_emp_allowances($info->emp_desi_id);
                $att_bouns = isset($allowances->attn_bonus) ? $allowances->attn_bonus : 0;
            }

			$ss = $this->common_model->salary_structure($info->gross_sal);
            $basic_sal 		= $ss['basic_sal'];
            $ot_rate 		= $ss['ot_rate'];

            // over time calculation
            $ot_amount = 0;
            if (!empty($attendances->ot) && $info->ot_entitle != 1 && $ot == 1) {
                $ot_rate = $ot_rate;
                $ot_amount = $attendances->ot * $ot_rate;
            }

            // salary calculation
            if ($salary_type == 1) {
                $salary = $info->gross_sal;
                $salary_type = 'Gross';
            } else {
                $salary = $basic_sal;
                $salary_type = 'Basic';
            }
            $pay = round(($salary / $num_of_days) * $pay_days) + $ot_amount + $att_bouns;

            $data = array(
                'emp_id'        => $row,
                'from_date'     => $from_date,
                'to_date'       => $to_date,
                'pay_cal_day'   => ((strtotime($to_date) - strtotime($from_date)) / 86400) + 1,
                'attend'        => $attend,
                'absent'        => $absent,
                'weekend'       => $weekend,
                'holiday'       => $holiday,
                'total_leave'   => $total_leave,
                'pay_days'      => $pay_days,
                'salary_type'   => $salary_type,
                'gross_salary'  => $info->gross_sal,
                'pay_salay'     => $pay,
                'ot'            => $attendances->ot,
                'ot_rate'       => $ot_rate,
                'ot_amt'        => $ot_amount,
                'att_bouns'     => $att_bouns,
                'loan_amt'      => $pay,
                'loan_date'     => date('Y-m-d'),
                'loan_month'    => $loan_month,
                'effect_month'  => $effect_month,
                'pay_amt'       => $pay,
                'status'        => 1, // 1 open, 2 close
                'loan_status'   => 1, // 1 not pay, 2 full pay, 3 partial pay
                'type'          => 2,  // 2 advance salary
                'unit_id'       => $unit_id,
                'created_by'    => $this->data['user_data']->id,
            );

            // dd($data);

            $r = $this->db->where('emp_id', $row)->where('loan_month', $loan_month)->where('loan_status', 1)->where('type', 2)->get('pr_advance_loan')->row();
            if (!empty($r)) {
                $this->db->where('id', $r->id);
                if ($this->db->update('pr_advance_loan', $data)) {
                    $st = true;
                }
            } else {
                if ($this->db->insert('pr_advance_loan', $data)) {
                    $st = true;
                }
            }
        }
        if ($st == true) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
    function attendance_check($emp_id,$start_date,$end_date)
    {
        $this->db->select("
                COALESCE(SUM(CASE WHEN present_status = 'P' THEN 1 ELSE 0 END ), 0) AS attend,
                COALESCE(SUM(CASE WHEN present_status = 'A' THEN 1 ELSE 0 END ), 0) AS absent,
                COALESCE(SUM(CASE WHEN present_status = 'W' THEN 1 ELSE 0 END ), 0) AS weekend,
                COALESCE(SUM(CASE WHEN present_status = 'H' THEN 1 ELSE 0 END ), 0) AS holiday,
                COALESCE(SUM(CASE WHEN present_status = 'L' THEN 1 ELSE 0 END ), 0) AS total_leave,
                COALESCE(SUM(CASE WHEN late_status   = '1' THEN 1 ELSE 0 END ), 0) AS late_status,
                COALESCE(SUM(CASE WHEN holiday_allo = '1' THEN 1 ELSE 0 END ), 0) AS holiday_allo,
                COALESCE(SUM(CASE WHEN weekly_allo  = '1' THEN 1 ELSE 0 END ), 0) AS weekly_allo,
                COALESCE(SUM(CASE WHEN night_allo   = '1' THEN 1 ELSE 0 END ), 0) AS night_allo,
                COALESCE(SUM(CASE WHEN tiffin_allo  = '1' THEN 1 ELSE 0 END ), 0) AS tiffin_allo,
                COALESCE(SUM(ot), 0) AS ot,
                COALESCE(SUM(eot), 0) AS eot,
                COALESCE(SUM(ot_eot_4pm), 0) AS ot_eot_4pm,
                COALESCE(SUM(ot_eot_12am), 0) AS ot_eot_12am,
                COALESCE(SUM(modify_eot), 0) AS modify_eot,
                COALESCE(SUM(deduction_hour), 0) AS deduction_hour,
            ");

        $this->db->where('emp_id',$emp_id);
        $this->db->where("shift_log_date BETWEEN '$start_date' AND '$end_date'");
        $query = $this->db->get('pr_emp_shift_log')->row();
        return $query;
    }
	function get_emp_allowances($desi_id)
	{
		$this->db->select("
				aab.rule attn_bonus,
				ahw.allowance_amount hw_bill,
				aib.allowance_amount iftar_bill,
				anr.night_allowance night_bill,
				atb.allowance_amount tiffin_bill
			");
		$this->db->from("emp_designation as ed");

		$this->db->join("allowance_attn_bonus aab", 'ed.attn_id = aab.id', 'left');
		$this->db->join("allowance_holiday_weekend_rules ahw", 'ed.holiday_weekend_id = ahw.id', 'left');
		$this->db->join("allowance_iftar_bill aib", 'ed.iftar_id = aib.id', 'left');
		$this->db->join("allowance_night_rules anr", 'ed.night_al_id = anr.id', 'left');
		$this->db->join("allowance_tiffin_bill atb", 'ed.tiffin_id = atb.id', 'left');

		$this->db->where('ed.id', $desi_id);
		$query = $this->db->get()->row();

		return $query;
	}
    public function advance_salary_delete()
    {
        $sql         = $_POST['emp_id'];
        $unit_id     = $_POST['unit_id'];
        $loan_month  = date('Y-m-d', strtotime($_POST['loan_month']));
        $emp_ids     = explode(',', $sql);

        $this->db->where('loan_month', $loan_month)->where_in('emp_id', $emp_ids);
        if ($this->db->where('unit_id', $unit_id)->delete('pr_advance_loan')) {
            echo 'success';
        } else {
            echo 'Advance Salary Not Deleted';
        }
    }
    // ==================  end advance salary entry  ======================
    // ====================================================================

    // Get a single advance salary record by ID (JSON)
    public function advance_salary_get($id = 0)
    {
        $this->db->select('loan.*, per.name_en, pr_units.unit_name');
        $this->db->from('pr_advance_loan loan');
        $this->db->join('pr_emp_per_info per', 'loan.emp_id = per.emp_id', 'left');
        $this->db->join('pr_units', 'loan.unit_id = pr_units.unit_id', 'left');
        $this->db->where('loan.id', $id);
        $row = $this->db->get()->row();
        header('Content-Type: application/json');
        echo json_encode($row);
    }

    // Update a single advance salary record by ID
    public function advance_salary_update()
    {
        $id           = $this->input->post('id');
        $loan_amt     = $this->input->post('loan_amt');
        $pay_amt      = $this->input->post('pay_amt');
        $loan_month   = date('Y-m-01', strtotime($this->input->post('loan_month')));
        $effect_month = $this->input->post('effect_month');
        $loan_status  = $this->input->post('loan_status');
        $status       = $this->input->post('status');

        if (empty($id)) {
            echo 'Invalid ID';
            return;
        }

        $data = array(
            'loan_amt'     => $loan_amt,
            'pay_amt'      => $pay_amt,
            'loan_month'   => $loan_month,
            'effect_month' => !empty($effect_month) ? date('Y-m-01', strtotime($effect_month)) : null,
            'loan_status'  => $loan_status,
            'status'       => $status,
        );

        $this->db->where('id', $id);
        if ($this->db->update('pr_advance_loan', $data)) {
            echo 'success';
        } else {
            echo 'Advance Salary Not Updated';
        }
    }

    // Bulk update multiple advance salary records
    public function advance_salary_bulk_update()
    {
        $raw     = $this->input->post('records');
        $records = json_decode($raw, true);

        if (empty($records) || !is_array($records)) {
            echo 'Invalid data';
            return;
        }

        $success = true;
        foreach ($records as $rec) {
            $id         = isset($rec['id'])         ? intval($rec['id'])         : 0;
            $pay_amt    = isset($rec['pay_amt'])     ? floatval($rec['pay_amt'])  : 0;
            $loan_status = isset($rec['loan_status']) ? intval($rec['loan_status']) : 1;
            $status     = isset($rec['status'])      ? intval($rec['status'])     : 1;

            if ($id <= 0) continue;

            $data = array(
                'pay_amt'     => $pay_amt,
                'loan_status' => $loan_status,
                'status'      => $status,
            );

            $this->db->where('id', $id);
            if (!$this->db->update('pr_advance_loan', $data)) {
                $success = false;
            }
        }

        echo $success ? 'success' : 'Some records failed to update';
    }

    // Delete a single advance salary record by ID
    public function advance_salary_delete_by_id()
    {
        $id = $this->input->post('id');

        if (empty($id)) {
            echo 'Invalid ID';
            return;
        }

        $this->db->where('id', $id);
        if ($this->db->delete('pr_advance_loan')) {
            echo 'success';
        } else {
            echo 'Advance Salary Not Deleted';
        }
    }
    // ===================================================================

    // advanced loan
    // ====================================================================
    public function advance_loan()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->db->select('tax.*, per.name_en, pr_units.unit_name');
        $this->db->from('emp_tax_entry tax');
        $this->db->join('pr_emp_per_info per', 'tax.emp_id = per.emp_id', 'left');
        $this->db->join('pr_units', 'tax.unit_id = pr_units.unit_id', 'left');
        $this->db->order_by('tax.effect_date', 'DESC');
        $this->data['results'] = $this->db->get()->result();

        $this->data['title'] = 'Tax';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/advance_loan';
        $this->load->view('layout/template', $this->data);
    }

    // Get a single tax entry record by ID (JSON)
    public function advance_loan_get($id = 0)
    {
        $this->db->select('tax.*, per.name_en, pr_units.unit_name');
        $this->db->from('emp_tax_entry tax');
        $this->db->join('pr_emp_per_info per', 'tax.emp_id = per.emp_id', 'left');
        $this->db->join('pr_units', 'tax.unit_id = pr_units.unit_id', 'left');
        $this->db->where('tax.id', $id);
        $row = $this->db->get()->row();
        header('Content-Type: application/json');
        echo json_encode($row);
    }

    // Update a single tax entry record by ID
    public function advance_loan_update()
    {
        $id          = $this->input->post('id');
        $amount      = $this->input->post('amount');
        $effect_date = date('Y-m-01', strtotime($this->input->post('effect_date')));
        $status      = $this->input->post('status');

        if (empty($id)) { echo 'Invalid ID'; return; }

        $data = array(
            'amount'      => $amount,
            'effect_date' => $effect_date,
            'status'      => $status,
        );
        $this->db->where('id', $id);
        echo $this->db->update('emp_tax_entry', $data) ? 'success' : 'Tax Record Not Updated';
    }

    // Delete a single tax entry record by ID
    public function advance_loan_delete_by_id()
    {
        $id = $this->input->post('id');
        if (empty($id)) { echo 'Invalid ID'; return; }
        $this->db->where('id', $id);
        echo $this->db->delete('emp_tax_entry') ? 'success' : 'Tax Record Not Deleted';
    }

    public function tax_list()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

        $this->db->select('tax.*, per.name_en, pr_units.unit_name');
        $this->db->from('emp_tax_entry tax');
        $this->db->join('pr_emp_per_info per', 'tax.emp_id = per.emp_id', 'left');
        $this->db->join('pr_units', 'tax.unit_id = pr_units.unit_id', 'left');
        $this->db->where('tax.unit_id', $this->data['user_data']->unit_name);
        $this->data['results'] = $this->db->get()->result();

        $this->data['title'] = 'Advance Loan';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/tax_list';
        $this->load->view('layout/template', $this->data);

    }

    public function advance_loan_form()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->db->select('emp_depertment.*, pr_units.unit_name');
        $this->db->from('emp_depertment');
        $this->db->join('pr_units', 'pr_units.unit_id = emp_depertment.unit_id', 'left');
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('emp_depertment.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['departments'] = $this->db->get()->result();

        $this->data['title'] = 'Advance Loan Entry';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/advance_loan_form';
        $this->load->view('layout/template', $this->data);

    }

    public function readExcel() {
        $file_path = FCPATH . 'import/AJFL.csv'; // Adjust the file path and name
        $delimiter = ','; // Change the delimiter based on your CSV format

        if (($handle = fopen($file_path, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                // Process each row
                echo '<pre>';
                print_r($row); // Example: Output each row as an array
            }
            fclose($handle);
        } else {
            echo "Error opening file.";
        }
    }
    // advance loan entry system
    function advance_loan_entry() {
        $unit_id       = $_POST['unit_id'];
        $emp_id        = $_POST['emp_id'];
        $loan_amount   = $_POST['loan_amount'];
        $pay_amount    = $_POST['pay_amount'];
        $loan_month    = date('Y-m-01', strtotime($_POST['loan_month']));
        $effect_month  = date('Y-m-01', strtotime($_POST['effect_month']));
        $status        = $_POST['status'];
        $emp_ids       = explode(',', $emp_id);

        $st = false;
        foreach ($emp_ids as $row) {
            $id         = $row;
            $data = array(
                'emp_id'        => $id,
                'loan_amt'      => $loan_amount,
                'loan_month'    => $loan_month,
                'pay_amt'       => $pay_amount,
                'effect_month'  => $effect_month,
                'unit_id'       => $unit_id,
                'created_by'    => $this->data['user_data']->id,
                'status'        => $status,
                'type'          => 1 // loan
            );

            $r = $this->db->where('emp_id', $id)->where('loan_month', $loan_month)->where('status', 1)->where('type', 1)->get('pr_advance_loan')->row();
            if (!empty($r)) {
                $this->db->where('id', $r->id);
                if ($this->db->update('pr_advance_loan', $data)) {
                    $st = true;
                }
            } else {
                if ($this->db->insert('pr_advance_loan', $data)) {
                    $st = true;
                }
            }
        }
        if ($st == true) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    // Tax entry system
    function tax_entry() {
        $unit_id     = $_POST['unit_id'];
        $amount      = $_POST['amount'];
        $effect_date = date('Y-m-01', strtotime($_POST['effect_date']));
        $status      = $_POST['status'];
        $emp_id      = $_POST['emp_id'];
        $emp_ids     = explode(',', $emp_id);

        $st = false;
        foreach ($emp_ids as $id) {
            $data = array(
                'emp_id'       => $id,
                'unit_id'      => $unit_id,
                'amount'       => $amount,
                'effect_date'  => $effect_date,
                'status'       => $status,
                'created_by'   => $this->data['user_data']->id,
            );

            $r = $this->db->where('emp_id', $id)->where('effect_date', $effect_date)->where('status', 1)->get('emp_tax_entry')->row();
            if (!empty($r)) {
                $this->db->where('emp_id', $id)->where('effect_date', $effect_date)->where('status', 1);
                if ($this->db->update('emp_tax_entry', $data)) {
                    $st = true;
                }
            } else {
                if ($this->db->insert('emp_tax_entry', $data)) {
                    $st = true;
                }
            }
        }

        if ($st == true) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
    //-------------------------------------------------------------------------------------------------------
    // GRID Display for Entry System
    //-------------------------------------------------------------------------------------------------------
    public function grid_entry_system()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->db->select('emp_depertment.*, pr_units.unit_name');
        $this->db->from('emp_depertment');
        $this->db->join('pr_units', 'pr_units.unit_id = emp_depertment.unit_id', 'left');
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('emp_depertment.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['departments'] = $this->db->get()->result();

        $this->data['title'] = 'Entry System';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/grid_entry_system';
        $this->load->view('layout/template', $this->data);
    }

    public function change_shift_ajax(){
        $emp_ids = $this->input->post('emp_id');
        // $emp_ids = implode(',', $emp_id);
        $first_date = date('Y-m-d', strtotime($this->input->post('first_date')));
        $second_date = date('Y-m-d', strtotime($this->input->post('second_date')));
        $shift_id = $this->input->post('shift_id');

        $shift=$this->db->where('id',$shift_id)->get('pr_emp_shift')->row();
        // dd($shift);
        $schedule_id=$shift->schedule_id;

        foreach($emp_ids as $emp_id){
            $this->db->where('emp_id',$emp_id)
            ->where('shift_log_date >=',$first_date)
            ->where('shift_log_date <=',$second_date)
            ->update('pr_emp_shift_log',array('schedule_id'=>$schedule_id,'shift_id'=>$shift->id));
        };
        echo 'success';

    }

    //-------------------------------------------------------------------------------------------------------
    public function shift_change()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->db->select('emp_depertment.*, pr_units.unit_name');
        $this->db->from('emp_depertment');
        $this->db->join('pr_units', 'pr_units.unit_id = emp_depertment.unit_id', 'left');
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('emp_depertment.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['departments'] = $this->db->get()->result();

        $this->data['title'] = 'Entry System';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/shift_change';
        $this->load->view('layout/template', $this->data);
    }
    public function present_entry()
    {
        $sql         = $_POST['emp_id'];
        $unit_id     = $_POST['unit_id'];
        $first_date  = date('Y-m-d', strtotime($_POST['first_date']));
        $second_date = date('Y-m-d', strtotime($_POST['second_date']));
        $in_time     = date('H:i:s', strtotime($_POST['in_time']));
        $out_time    = date('H:i:s', strtotime($_POST['out_time']));

        if($in_time == '00:00:00' && $out_time == '00:00:00') {
            echo 'Please enter at least In Time or Out Time';
            exit;
        }
        $emp_ids     = explode(',', $sql);
        $mm = array();

        // final process check
		$slm = date("Y-m-01", strtotime($first_date));
		$check = $this->db->where('unit_id', $unit_id)->where('block_month',$slm)->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! This Month Already Final Processed";
			return false; exit();
		}
		// final process check end
        $emp_data = $this->Attn_process_model->get_all_employee($emp_ids, 1);

        while ($first_date <= $second_date) {
            $data = array();
            foreach ($emp_data->result() as $rows) {
                $com_id         = $rows->id;
                $emp_id         = $rows->emp_id;
                $proxi_id       = $rows->proxi_id;
                $shift_id       = $rows->shift_id;
                $schedule_id    = $rows->schedule_id;

                $emp_shift = $this->Attn_process_model->emp_shift_check_process($emp_id,$shift_id,$schedule_id,$first_date);
                $schedule  = $this->Attn_process_model->get_emp_schedule($emp_shift->schedule_id);
                $out_end   = $schedule[0]["out_end"];
                // dd($schedule);

                // in time insert here
                if (strtotime($in_time) <= strtotime($out_end)) {
                    $date = date('Y-m-d', strtotime($first_date . ' + 1 days'));
                } else {
                    $date = $first_date;
                }
                $data = array(
                    'date_time'       => $date ." ".$in_time,
                    'proxi_id'        => $proxi_id,
                    'device_id'       => 0,
                    'monitor_con'     => 2
                );
                if ($in_time != '00:00:00') {
                    $mm = $this->insert_attn_process($data, $first_date, $unit_id, $rows->emp_id, $proxi_id);
                }

                // out time insert here
                $date = $first_date;
                if (strtotime($out_time) <= strtotime('11:59:59')) {
                    $date = date('Y-m-d', strtotime($first_date . ' + 1 days'));
                } else {
                    $date = $first_date;
                }
                $data1 = array(
                    'date_time'       => $date ." ".$out_time,
                    'proxi_id'        => $proxi_id,
                    'device_id'       => 0,
                    'monitor_con'     => 2
                );
                if ($out_time != '00:00:00') {
                    $mm = $this->insert_attn_process($data1, $first_date, $unit_id, $rows->emp_id, $proxi_id);
                }
            }
            $first_date = date('Y-m-d', strtotime('+1 days'. $first_date));
		}

        if (!empty($mm) && $mm['massage'] == 1) {
            echo 'success';
        } else {
            echo 'Record Not Inserted';
        }
    }

    function insert_attn_process($data, $date, $unit_id, $emp_id, $proxi_id) {
        $this->load->model('Attn_process_model');
        $att_table = "att_". date("Y_m", strtotime($date));
        //dd($att_table);
        if (!$this->db->table_exists($att_table)){
            $this->db->query('CREATE TABLE IF NOT EXISTS `'.$att_table.'`(
                    `att_id` int(11) NOT NULL AUTO_INCREMENT,
                    `device_id` int(11) NOT NULL,
                    `proxi_id` varchar(30) NOT NULL,
                    `date_time` datetime NOT NULL,
                    PRIMARY KEY (`att_id`),
                    KEY `device_id` (`device_id`,`proxi_id`,`date_time`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;'
            );
        }
        //dd($data);
        if (!empty($data)) {
            $check = $this->db->where('proxi_id', $proxi_id)->like('date_time', $data['date_time'])->get($att_table)->row();
            if (empty($check)) {
                $this->db->insert($att_table, $data);
            }
        }
        return array('massage' => 1);

        // if ($this->Attn_process_model->attn_process($date, $unit_id, array($emp_id))) {
        //     return array('massage' => 1);
        // } else {
        //     return array('massage' => 0);
        // }
    }

    public function log_sheet()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $sql         = $_POST['emp_id'];
        $unit_id     = $_POST['unit_id'];
        $first_date  = date('Y-m-d', strtotime($_POST['first_date']));
        $second_date = date('Y-m-d', strtotime($_POST['second_date']));
        $emp_id      = explode(',', $sql);

        // final process check
		$slm = date("Y-m-01", strtotime($first_date));
		$check = $this->db->where('unit_id', $unit_id)->where('block_month',$slm)->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! This Month Already Final Processed";
			return false; exit();
		}
		// final process check end

        $this->db->select('
                    pr_emp_com_info.id,
                    pr_emp_com_info.emp_id,
                    pr_emp_com_info.unit_id,
                    pr_emp_com_info.proxi_id,
                    pr_emp_com_info.emp_join_date,
                    pr_emp_per_info.name_en,
                    emp_depertment.dept_name,
                    emp_section.sec_name_en,
                    emp_line_num.line_name_en,
                    emp_designation.desig_name,
                ');
        $this->db->from('pr_emp_com_info');
        $this->db->from('pr_emp_per_info');
        $this->db->from('emp_depertment');
        $this->db->from('emp_section');
        $this->db->from('emp_line_num');
        $this->db->from('emp_designation');

        $this->db->where('pr_emp_com_info.emp_dept_id = emp_depertment.dept_id');
        $this->db->where('pr_emp_com_info.emp_sec_id = emp_section.id');
        $this->db->where('pr_emp_com_info.emp_line_id = emp_line_num.id');
        $this->db->where('pr_emp_com_info.emp_desi_id = emp_designation.id');
        $this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
        $this->db->where_in('pr_emp_com_info.emp_id', $emp_id);
        $row = $this->db->get()->row();
        $this->data['row'] = $row;


        $this->db->select('pr_units.*')->where('unit_id', $row->unit_id);
        $this->data['unit'] = $this->db->get('pr_units')->row();

        $this->data['results']     = $this->Common_model->get_shift_log($row, $emp_id, $first_date, $second_date);
        //dd($this->data['results']);
        $this->data['first_date']  = date('d-m-Y', strtotime($first_date));
        $this->data['second_date'] = date('d-m-Y', strtotime($second_date));
        $this->data['unit_id']     = $unit_id;
        $this->data['username']    = $this->data['user_data']->id_number;
        $this->load->view('entry_system/log_sheet', $this->data);
    }
    public function log_update()
    {
        // 2009076
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $emp_id      = $_POST['emp_id'];
        $unit_id     = $_POST['unit_id'];
        $date        = $_POST['date'];
        $in_time     = $_POST['in_time'];
        $out_time    = $_POST['out_time'];
        // dd($_POST);

        // final process check
		$slm = date("Y-m-01", strtotime($date[0]));
		$check = $this->db->where('unit_id', $unit_id)->where('block_month',$slm)->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! This Month Already Final Processed";
			return false; exit();
		}
		// final process check end

        $emp_data = $this->Attn_process_model->get_all_employee(array($emp_id), 1)->row();

        $com_id			= $emp_data->id;
        $emp_id			= $emp_data->emp_id;
        $proxi_id       = $emp_data->proxi_id;
        $shift_id		= $emp_data->shift_id;
        $schedule_id	= $emp_data->schedule_id;;

        $data = array();
        $data1 = array();
        foreach ($date as $key => $d) {

            $d = date('Y-m-d', strtotime($d));
            //GET CURRENT SHIFT INFORMATION
            $emp_shift = $this->Attn_process_model->emp_shift_check_process($emp_id, $shift_id, $schedule_id, $d);
            $schedule  = $this->Attn_process_model->get_emp_schedule($emp_shift->schedule_id);
            $out_end 	= $schedule[0]["out_end"];

            if (!empty($in_time[$key]) && $in_time[$key] != '00:00:00') {
                $data = array(
                    'date_time'  => $d ." ".$in_time[$key],
                    'proxi_id'   => $proxi_id,
                    'device_id'  => 0,
                    'monitor_con' => 1
                );
            } else {
                $data = array();
            }

            if (strtotime($out_time[$key]) <= strtotime($out_end) && strtotime($out_time[$key]) <= strtotime('12:00:00')) {
                $dd = date('Y-m-d', strtotime($d . ' + 1 days'));
            } else {
                $dd = $d;
            }

            if (!empty($out_time[$key]) && $out_time[$key] != '00:00:00') {
                $data1 = array(
                    'date_time'  => $dd ." ". $out_time[$key],
                    'proxi_id'   => $proxi_id,
                    'device_id'  => 0,
                    'monitor_con' => 2
                );
            }else {
                $data1 = array();
            }
            $mm = $this->update_attn_log($data, $data1, $d, $emp_id, $unit_id, $proxi_id);
        }

        if (!empty($mm) && $mm['massage'] == 1) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    function update_attn_log($data, $data1, $date, $emp_id, $unit_id, $proxi_id) {
        $this->load->model('Attn_process_model');
        $att_table = "att_". date("Y_m", strtotime($date));
        if (!$this->db->table_exists($att_table)){
            $this->db->query('CREATE TABLE IF NOT EXISTS `'.$att_table.'`(
                    `att_id` int(11) NOT NULL AUTO_INCREMENT,
                    `device_id` int(11) NOT NULL,
                    `proxi_id` varchar(30) NOT NULL,
                    `date_time` datetime NOT NULL,
                    PRIMARY KEY (`att_id`),
                    KEY `device_id` (`device_id`,`proxi_id`,`date_time`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;'
            );
        }

        if (!empty($data)) {
            $check = $this->db->where('proxi_id', $proxi_id)->like('date_time', $data['date_time'])->get($att_table)->row();
            if (empty($check)) {
                $this->db->insert($att_table, $data);
            }
        }

        if (!empty($data1)) {
            $check1 = $this->db->where('proxi_id', $proxi_id)->like('date_time', $data1['date_time'])->get($att_table)->row();
            if (empty($check1)) {
                $this->db->insert($att_table, $data1);
            }
        }

        if ($this->Attn_process_model->attn_process($date, $unit_id, array($emp_id))) {
            return array('massage' => 1);
            } else {
            return array('massage' => 0);
        }
    }

    public function present_absent()
    {
        $sql         = $_POST['emp_id'];
        $unit_id     = $_POST['unit_id'];
        $first_date  = date('Y-m-d', strtotime($_POST['first_date']));
        $second_date = date('Y-m-d', strtotime($_POST['second_date']));
        $emp_ids     = explode(',', $sql);
        $att_table   = "att_" . date("Y_m", strtotime($first_date));

        // final process check
		$slm = date("Y-m-01", strtotime($first_date));
		$check = $this->db->where('unit_id', $unit_id)->where('block_month',$slm)->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! This Month Already Final Processed";
			return false; exit();
		}
		// final process check end

        foreach ($emp_ids as $key => $emp_id) {
            // get shift and schedule
            $this->db->select('sc.*')->from('pr_emp_shift_log as log');
            $this->db->join('pr_emp_shift_schedule as sc', 'log.schedule_id = sc.id', 'left');
            $shift = $this->db->where('log.shift_log_date',$first_date)->where('log.emp_id',$emp_id)->get()->row();
            if (empty($shift)) {
                $this->db->select('sc.*')->from('pr_emp_com_info as com');
                $this->db->join('pr_emp_shift as shift', 'com.emp_shift = shift.id', 'left');
                $this->db->join('pr_emp_shift_schedule as sc', 'shift.schedule_id = sc.id', 'left');
                $shift = $this->db->where('emp_id',$emp_id)->get()->row();
            }

            $modify_date = date("Y-m-d", strtotime('+ 1 day', strtotime($second_date)));
            if ($shift->out_end >= '12:59:00' && $shift->in_start <= '12:00:00') {  // loader day
                $first       = $first_date .' '. '00:00:01';
                $second      = $seconde_dat .' '. '23:59:59';
            }else if($shift->out_end == 'Night_shift(Loader)' && $shift->out_end <= '12:00:00' && $shift->in_start >= '12:59:00') {  // loader night
                $first       = $first_date .' '. '12:00:01';
                $second      = $modify_date .' '. '12:00:00';
            }else if($shift->out_end <= '10:00:00' && $shift->in_start <= '10:00:00') { // general
                $first       = $first_date .' '. $shift->in_start;
                $second      = $modify_date .' '. $shift->out_end;
            } else { // default
                $first       = $first_date .' '. $shift->in_start;
                $second      = $second_date .' '. $shift->out_end;
            }
            // get shift and schedule

            // dynamic att_table and delete punch data
            if (date('t', strtotime($second_date)) == date('d', strtotime($second_date))) {
                $new_table = "att_" . date("Y_m", strtotime($second_date));
                $this->db->where("date_time BETWEEN '$first' and '$second' ");
                $this->db->where('proxi_id', $emp_id)->delete($new_table);
            } else if (date('m', strtotime($first_date)) != date('m', strtotime($second_date))) {
                $new_table = "att_" . date("Y_m", strtotime($second_date));
                $this->db->where("date_time BETWEEN '$first' and '$second' ");
                $this->db->where('proxi_id', $emp_id)->delete($new_table);
            }
            $this->db->where("date_time BETWEEN '$first' and '$second' ");
            $this->db->where('proxi_id', $emp_id)->delete($att_table);
        }

        $this->db->where("shift_log_date BETWEEN '$first_date' and '$second_date' ")->where_in('emp_id', $emp_ids);
        if ($this->db->where('unit_id', $unit_id)->delete('pr_emp_shift_log')) {
            echo 'success';
        } else {
            echo 'Record Not Deleted';
        }
    }

    public function log_delete()
    {
        $sql         = $_POST['emp_id'];
        $unit_id     = $_POST['unit_id'];
        $first_date  = date('Y-m-d', strtotime($_POST['first_date']));
        $second_date = date('Y-m-d', strtotime($_POST['second_date']));
        $emp_ids     = explode(',', $sql);

        // final process check
		$slm = date("Y-m-01", strtotime($first_date));
		$check = $this->db->where('unit_id', $unit_id)->where('block_month',$slm)->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! This Month Already Final Processed";
			return false; exit();
		}
		// final process check end

        // $com_ids    = $this->get_com_emp_id($emp_ids);
        $this->db->where("shift_log_date BETWEEN '$first_date' and '$second_date' ")->where_in('emp_id', $emp_ids);
        if ($this->db->where('unit_id', $unit_id)->delete('pr_emp_shift_log')) {
            echo 'success';
        } else {
            echo 'Shift Log Not Deleted';
        }
    }

    public function eot_modify_entry()
    {
        $emp_id      = $_POST['emp_id'];
        $unit_id     = $_POST['unit_id'];
        $first_date  = date('Y-m-d', strtotime($_POST['first_date']));
        $second_date = date('Y-m-d', strtotime($_POST['second_date']));
        $eot         = $_POST['eot'];

        // final process check
		$slm = date("Y-m-01", strtotime($first_date));
		$check = $this->db->where('unit_id', $unit_id)->where('block_month',$slm)->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! This Month Already Final Processed";
			return false; exit();
		}
		// final process check end
        $com_info=$this->db->where('emp_id',$emp_id)->get('pr_emp_com_info')->row();
        if($com_info->ot_entitle!=0){
            $this->db->where("shift_log_date BETWEEN '$first_date' and '$second_date'")->where('emp_id', $emp_id);
            if ($this->db->where('unit_id', $unit_id)->update('pr_emp_shift_log', array('modify_eot' => $eot))) {
                echo 'success';
            } else {
                echo 'EOT not updated';
            }
        }else{
            echo 'Not Allowed To Modify EOT For This Employee. This Employee has no OT Entitle.';
        }
    }
    function get_com_emp_id($emp_ids) {
        $this->db->select('id')->where_in("emp_id", $emp_ids);
        $ids = $this->db->get("pr_emp_com_info")->result();
        $data = array();
        foreach ($ids as $key => $r) {
            $data[] = $r->id;
        }
        return $data;
    }

    //-------------------------------------------------------------------------------
    // Increment and Promotion entry to the Database
    //-------------------------------------------------------------------------------
    public function incre_prom_entry()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->db->select('emp_depertment.*, pr_units.unit_name');
        $this->db->from('emp_depertment');
        $this->db->join('pr_units', 'pr_units.unit_id = emp_depertment.unit_id', 'left');
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('emp_depertment.unit_id', $this->data['user_data']->unit_name);
        }
        $this->data['departments'] = $this->db->get()->result();

        $this->data['title'] = 'Increment / Promotion';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/incre_prom_entry';
        $this->load->view('layout/template', $this->data);
    }

    public function special_entry()
    {
        $unit_id        = $_POST['unit_id'];
        $incr_date      = date('Y-m-01', strtotime($_POST['special_date']));
        $new_salary     = $_POST['gross_sal'];
        $new_com_salary = $_POST['com_gross_sal'];
        $emp_id         = $_POST['emp_id'];
        $old_salary     = $_POST['salary'];
        $old_com_salary = $_POST['com_salary'];

        $r = $this->db->where('emp_id', $emp_id)->where('unit_id', $unit_id)->get('pr_emp_com_info')->row();
        $data = array(
            'prev_emp_id' => $emp_id,
            'prev_dept' => $r->emp_dept_id,
            'prev_section' => $r->emp_sec_id,
            'prev_line' => $r->emp_line_id,
            'prev_desig' => $r->emp_desi_id,
            'prev_grade' => $r->emp_sal_gra_id,
            'new_emp_id' => $r->emp_id,
            'new_dept' => $r->emp_dept_id,
            'new_section' => $r->emp_sec_id,
            'new_line' => $r->emp_line_id,
            'new_desig' => $r->emp_desi_id,
            'new_grade' => $r->emp_sal_gra_id,
            'new_salary' => $new_salary,
            'new_com_salary' => $new_com_salary ?? $new_salary,
            'effective_month' => $incr_date,
            'ref_id' => $emp_id,
            'status' => 4,
        );

        $dd = array(
            'gross_sal' => $new_salary,
            'com_gross_sal' => $new_com_salary ?? $new_salary
        );

        $check = $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date)->get('pr_incre_prom_pun');
        if ($check->num_rows() > 0) {
            $data['prev_salary']      = $check->row()->prev_salary;
            $data['prev_com_salary']  = $check->row()->prev_com_salary;
            $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date);
            if ( $this->db->update('pr_incre_prom_pun', $data) ) {
                $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd);
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            $data['prev_salary']      = $r->gross_sal;
            $data['prev_com_salary']  = $r->com_gross_sal;
            $data['monitor_con']       = 2;

            if ( $this->db->insert('pr_incre_prom_pun', $data) ) {
                $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd);
                echo 'success';
            }else{
                echo 'error';
            }
        }
    }
    public function special_delete_ajax(){
        $emp_id         = $_POST['sql'];
        $unit_id        = $_POST['unit_id'];
        $incr_date      = date('Y-m-01', strtotime($_POST['date']));
        $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date);
        $r = $this->db->order_by('effective_month', 'DESC')->get('pr_incre_prom_pun')->row();
        if (!empty($r)) {
            $dd = array(
                'gross_sal' => $r->prev_salary,
                'com_gross_sal' => $r->prev_com_salary,
            );
            if ( $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd) ) {
                $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date)->delete('pr_incre_prom_pun');
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }
    public function increment_entry()
    {
        $unit_id        = $_POST['unit_id'];
        $incr_date      = date('Y-m-01', strtotime($_POST['incr_date']));
        $new_salary     = $_POST['gross_sal'];
        $new_com_salary = $_POST['com_gross_sal'] ?? $new_salary;
        $emp_id         = $_POST['emp_id'];
        $old_salary     = $_POST['inc_salary'];
        $old_com_salary = $_POST['inc_com_salary'];
        $r = $this->db->where('emp_id', $emp_id)->where('unit_id', $unit_id)->get('pr_emp_com_info')->row();
        $data = array(
            'prev_emp_id' => $emp_id,
            'prev_dept' => $r->emp_dept_id,
            'prev_section' => $r->emp_sec_id,
            'prev_line' => $r->emp_line_id,
            'prev_desig' => $r->emp_desi_id,
            'prev_grade' => $r->emp_sal_gra_id,
            'new_emp_id' => $r->emp_id,
            'new_dept' => $r->emp_dept_id,
            'new_section' => $r->emp_sec_id,
            'new_line' => $r->emp_line_id,
            'new_desig' => $r->emp_desi_id,
            'new_grade' => $r->emp_sal_gra_id,
            'new_salary' => $new_salary,
            'new_com_salary' => $new_com_salary,
            'effective_month' => $incr_date,
            'ref_id' => $emp_id,
            'status' => 1,
        );

        $dd = array(
            'gross_sal' => $new_salary,
            'com_gross_sal' => $new_com_salary,
        );

        $check = $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date)->get('pr_incre_prom_pun');
        if ($check->num_rows() > 0) {
            $data['prev_salary']      = $check->row()->prev_salary;
            $data['prev_com_salary']  = $check->row()->prev_com_salary;
            $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date);
            if ( $this->db->update('pr_incre_prom_pun', $data) ) {
                $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd);
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            $data['prev_salary']      = $r->gross_sal;
            $data['prev_com_salary']  = $r->com_gross_sal;
            $data['monitor_con']       = 2;
            if ( $this->db->insert('pr_incre_prom_pun', $data) ) {
                $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd);
                echo 'success';
            }else{
                echo 'error';
            }
        }
    }
    public function increment_delete_ajax(){
        $emp_id         = $_POST['sql'];
        $unit_id        = $_POST['unit_id'];
        $incr_date      = date('Y-m-01', strtotime($_POST['date']));
        $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date);
        $r = $this->db->order_by('effective_month', 'DESC')->get('pr_incre_prom_pun')->row();
        if (!empty($r)) {
            $dd = array(
                'gross_sal' => $r->prev_salary,
                'com_gross_sal' => $r->prev_com_salary,
            );
            if ( $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd) ) {
                $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date)->delete('pr_incre_prom_pun');
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }

    public function promotion_entry()
    {
        // dd($_POST);
        $emp_id         = $_POST['emp_id'];
        $unit_id        = $_POST['unit_id'];
        $prom_date      = date('Y-m-01', strtotime($_POST['prom_date']));
        $new_salary     = $_POST['prom_gross_sal'];
        $new_com_salary = $_POST['prom_com_gross_sal'] ?? $new_salary ;
        $department     = $_POST['department'];
        $section        = $_POST['section'];
        $line           = $_POST['line'];
        $designation    = $_POST['designation'];
        $grade_id       = $_POST['grade_id'];
        $old_salary     = $_POST['salary'] ?? $new_salary ;
        $old_com_salary = $_POST['com_salary'];

        $r = $this->db->where('emp_id', $emp_id)->where('unit_id', $unit_id)->get('pr_emp_com_info')->row();
        $dd = array(
            'gross_sal'         => $new_salary,
            'com_gross_sal'     => $new_com_salary,
            'emp_dept_id'       => $department,
            'emp_sec_id'        => $section,
            'emp_line_id'       => $line,
            'emp_desi_id'       => $designation,
            'emp_sal_gra_id'    => (!empty($grade_id))? $grade_id : $r->emp_sal_gra_id,
        );

        $check = $this->db->where('ref_id', $emp_id)->where('effective_month', $prom_date)->get('pr_incre_prom_pun');
        if ($check->num_rows() > 0) {
            $rr = $check->row();
            $data = array(
                'prev_emp_id'       => $emp_id,
                'prev_dept'         => $rr->prev_dept,
                'prev_section'      => $rr->prev_section,
                'prev_line'         => $rr->prev_line,
                'prev_desig'        => $rr->prev_desig,
                'prev_grade'        => $rr->prev_grade,
                'prev_salary'       => $rr->prev_salary,
                'prev_com_salary'   => $rr->prev_com_salary,
                'new_emp_id'        =>  $emp_id,
                'new_dept'          => $department,
                'new_section'       => $section,
                'new_line'          => $line,
                'new_desig'         => $designation,
                'new_grade'         => (!empty($grade_id))? $grade_id : $r->emp_sal_gra_id,
                'new_salary'        => $new_salary,
                'new_com_salary'    => $new_com_salary,
                'effective_month'   => $prom_date,
                'ref_id'            => $emp_id,
                'status'            => 2,
            );
            $this->db->where('ref_id', $emp_id)->where('effective_month', $prom_date);
            if ( $this->db->update('pr_incre_prom_pun', $data) ) {
                $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd);
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            $data = array(
                'prev_emp_id'       => $emp_id,
                'prev_dept'         => $r->emp_dept_id,
                'prev_section'      => $r->emp_sec_id,
                'prev_line'         => $r->emp_line_id,
                'prev_desig'        => $r->emp_desi_id,
                'prev_grade'        => $r->emp_sal_gra_id,
                'prev_salary'       => $r->gross_sal,
                'prev_com_salary'   => $r->com_gross_sal,
                'new_emp_id'        =>  $emp_id,
                'new_dept'          => $department,
                'new_section'       => $section,
                'new_line'          => $line,
                'new_desig'         => $designation,
                'new_grade'         => (!empty($grade_id))? $grade_id : $r->emp_sal_gra_id,
                'new_salary'        => $new_salary,
                'new_com_salary'    => $new_com_salary,
                'effective_month'   => $prom_date,
                'ref_id'            => $emp_id,
                'status'            => 2,
                'monitor_con'       => 2
            );
            if ( $this->db->insert('pr_incre_prom_pun', $data) ) {
                $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd);
                echo 'success';
            }else{
                echo 'error';
            }
        }
    }

    public function prom_delete_ajax(){
        $emp_id         = $_POST['sql'];
        $unit_id        = $_POST['unit_id'];
        $incr_date      = date('Y-m-01', strtotime($_POST['date']));
        $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date);
        $r = $this->db->order_by('effective_month', 'DESC')->get('pr_incre_prom_pun')->row();
        if (!empty($r)) {
            $dd = array(
                'gross_sal'         => $r->prev_salary,
                'com_gross_sal'     => $r->prev_com_salary,
                'emp_dept_id'       => $r->prev_dept,
                'emp_sec_id'        => $r->prev_section,
                'emp_line_id'       => $r->prev_line,
                'emp_desi_id'       => $r->prev_desig,
                'emp_sal_gra_id'    => $r->prev_grade,
            );
            if ( $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd) ) {
                $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date)->delete('pr_incre_prom_pun');
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }

    public function line_entry()
    {
        $unit_id        = $_POST['unit_id'];
        $department     = $_POST['department'];
        $section        = $_POST['section'];
        $line           = $_POST['line'];
        $designation    = $_POST['designation'];
        $line_date      = date('Y-m-01', strtotime($_POST['line_date']));
        $emp_id         = $_POST['emp_id'];

        $r = $this->db->where('emp_id', $emp_id)->where('unit_id', $unit_id)->get('pr_emp_com_info')->row();
            $dd = array(
                'emp_dept_id'       => $department,
                'emp_sec_id'        => $section,
                'emp_line_id'       => $line,
                'emp_desi_id'       => $designation,
            );

        $check = $this->db->where('ref_id', $emp_id)->where('effective_month', $line_date)->get('pr_incre_prom_pun');
        if ($check->num_rows() > 0) {
            $rr = $check->row();
            $data = array(
                'prev_emp_id'       => $emp_id,
                'prev_dept'         => $rr->prev_dept,
                'prev_section'      => $rr->prev_section,
                'prev_line'         => $rr->prev_line,
                'prev_desig'        => $rr->prev_desig,
                'prev_grade'        => $rr->prev_grade,
                'prev_salary'       => $rr->prev_salary,
                'prev_com_salary'   => $rr->prev_com_salary,
                'new_emp_id'        => $emp_id,
                'new_dept'          => $department,
                'new_section'       => $section,
                'new_line'          => $line,
                'new_desig'         => $designation,
                'new_grade'         => $rr->new_grade,
                'new_salary'        => $rr->new_salary,
                'new_com_salary'    => $rr->new_com_salary,
                'effective_month'   => $line_date,
                'ref_id'            => $emp_id,
                'status'            => 3,
            );

            $this->db->where('ref_id', $emp_id)->where('effective_month', $line_date);
            if ( $this->db->update('pr_incre_prom_pun', $data) ) {
                $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd);
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            $data = array(
                'prev_emp_id'       => $emp_id,
                'prev_dept'         => $r->emp_dept_id,
                'prev_section'      => $r->emp_sec_id,
                'prev_line'         => $r->emp_line_id,
                'prev_desig'        => $r->emp_desi_id,
                'prev_grade'        => $r->emp_sal_gra_id,
                'prev_salary'       => $r->gross_sal,
                'prev_com_salary'   => $r->com_gross_sal,
                'new_emp_id'        => $emp_id,
                'new_dept'          => $department,
                'new_section'       => $section,
                'new_line'          => $line,
                'new_desig'         => $designation,
                'new_grade'         => $r->emp_sal_gra_id,
                'new_salary'        => $r->gross_sal,
                'new_com_salary'    => $r->com_gross_sal,
                'effective_month'   => $line_date,
                'ref_id'            => $emp_id,
                'status'            => 3,
            );
            if ( $this->db->insert('pr_incre_prom_pun', $data) ) {
                $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd);
                echo 'success';
            }else{
                echo 'error';
            }
        }
    }

    public function line_delete_ajax(){
        $emp_id         = $_POST['sql'];
        $unit_id        = $_POST['unit_id'];
        $incr_date      = date('Y-m-01', strtotime($_POST['date']));
        $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date);
        $r = $this->db->order_by('effective_month', 'DESC')->get('pr_incre_prom_pun')->row();
        if (!empty($r)) {
            $dd = array(
                'emp_dept_id'       => $r->prev_dept,
                'emp_sec_id'        => $r->prev_section,
                'emp_line_id'       => $r->prev_line,
                'emp_desi_id'       => $r->prev_desig,
            );
            if ( $this->db->where('emp_id', $emp_id)->update('pr_emp_com_info', $dd) ) {
                $this->db->where('ref_id', $emp_id)->where('effective_month', $incr_date)->delete('pr_incre_prom_pun');
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }
    //---------------------------------------------------------------------------
    // Increment and Promotion end
    //---------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------
    // CRUD for weekend
    //---------------------------------------------------------------------------------------
    public function weekend_list()
    {
        // $date = date("Y-m-d", strtotime('-7 month', strtotime(date("Y-m-d"))));
        // $this->db->select('attn_work_off.*, pr_units.unit_name, pr_emp_per_info.name_en as user_name');
        // $this->db->from('attn_work_off');
        // $this->db->join('pr_units', 'pr_units.unit_id = attn_work_off.unit_id', 'left');
        // $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = attn_work_off.emp_id', 'left');
        // $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        // $this->db->where('attn_work_off.work_off_date >=', $date);
        // $this->db->order_by('attn_work_off.work_off_date', 'desc');
        // $this->data['results'] = $this->db->get()->result();

        $this->data['title'] = 'Weekend List';
        $this->data['username'] = $this->data['user_data']->id_number;
        // dd($this->data);
        $this->data['subview'] = 'entry_system/weekend_list';
        $this->load->view('layout/template', $this->data);
    }
    public function weekend_list_ajax()
    {
        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');
        $deptSearch = $this->input->post('deptSearch');
        $date = date("Y-m-d", strtotime('-7 month', strtotime(date("Y-m-d"))));
        $this->db->select('attn_work_off.*, pr_units.unit_name, pr_emp_per_info.name_en as user_name');
        $this->db->from('attn_work_off');
        $this->db->join('pr_units', 'pr_units.unit_id = attn_work_off.unit_id', 'left');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = attn_work_off.emp_id', 'left');
        $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        $this->db->where('attn_work_off.work_off_date >=', $date);
        $this->db->order_by('attn_work_off.work_off_date', 'desc');
        $this->db->limit($limit, $offset);
        if (!empty($deptSearch) && $deptSearch != '') {
            $this->db->group_start();
            $this->db->like('attn_work_off.work_off_date', $deptSearch);
            $this->db->or_like('pr_units.unit_name', $deptSearch);
            $this->db->or_like('pr_emp_per_info.name_en', $deptSearch);
            $this->db->or_like('pr_emp_per_info.emp_id', $deptSearch);
            $this->db->group_end();
        }
        $this->data['results'] = $this->db->get()->result();

       echo json_encode($this->data['results']);
    }
    public function emp_weekend_add()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        // dd($this->data['user_data']->unit_name);
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->data['title'] = 'Weekend Add';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/emp_weekend_add';
        $this->load->view('layout/template', $this->data);
    }
    public function weekend_add_ajax()
    {
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $sql = $this->input->post('sql');
        $unit_id = $this->input->post('unit_id');
        $emp_ids = explode(',', $sql);
        $data = [];

        $this->db->where('work_off_date <=', date("Y-m-d", strtotime('-25 month', strtotime($date))));
        $this->db->delete('attn_work_off');

        foreach ($emp_ids as $value) {
            $data[] = array('work_off_date' => $date, 'emp_id' => $value, 'unit_id' => $unit_id);
        }
        if ( $this->db->insert_batch('attn_work_off', $data)) {
            echo 'success';
        }else{
            echo 'error';
        }
    }

    public function emp_weekend_del($id){
        $this->db->where('id', $id);
        $this->db->delete('attn_work_off');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url() . 'entry_system_con/weekend_list');

    }

    public function weekend_delete_all(){
        $date = $this->input->post('date');
        $sql = $this->input->post('sql');
        $unit_id = $this->input->post('unit_id');
        $emp_ids = explode(',', $sql);

        $this->db->where('work_off_date ', date("Y-m-d", strtotime($date)))->where('unit_id ', $unit_id);
        if ( $this->db->where_in('emp_id', $emp_ids)->delete('attn_work_off') ) {
            echo 'success';
        }else{
            echo 'error';
        }
    }
    //-------------------------------------------------------------------------------------
    // CRUD for weekend
    //-------------------------------------------------------------------------------------

    //-------------------------------------------------------------------------------------
    // CRUD for holiday
    //-------------------------------------------------------------------------------------
    public function holiday_list(){
        // $date = date("Y-m-d", strtotime('-8 month', strtotime(date("Y-m-d"))));
        // $this->db->select('attn_holyday_off.*, pr_units.unit_name, pr_emp_per_info.name_en as user_name');
        // $this->db->from('attn_holyday_off');
        // $this->db->join('pr_units', 'pr_units.unit_id = attn_holyday_off.unit_id');
        // $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = attn_holyday_off.emp_id');
        // $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        // $this->db->where('attn_holyday_off.work_off_date >=', $date);
        // $this->data['results'] = $this->db->order_by('attn_holyday_off.work_off_date', 'DESC')->get()->result();

        $this->data['title'] = 'Holiday List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/holiday_list';
        $this->load->view('layout/template', $this->data);
    }
    public function holiday_list_ajax(){
        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');
        $deptSearch = $this->input->post('deptSearch');

        $date = date("Y-m-d", strtotime('-8 month', strtotime(date("Y-m-d"))));
        $this->db->select('attn_holyday_off.*, pr_units.unit_name, pr_emp_per_info.name_en as user_name');
        $this->db->from('attn_holyday_off');
        $this->db->join('pr_units', 'pr_units.unit_id = attn_holyday_off.unit_id');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = attn_holyday_off.emp_id');
        $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        $this->db->where('attn_holyday_off.work_off_date >=', $date);

            $this->db->limit($limit, $offset);


        if (!empty($deptSearch) && $deptSearch != '') {
            $this->db->group_start();
            $this->db->like('attn_holyday_off.work_off_date', $deptSearch);
            $this->db->or_like('pr_units.unit_name', $deptSearch);
            $this->db->or_like('pr_emp_per_info.name_en', $deptSearch);
            $this->db->or_like('pr_emp_per_info.emp_id', $deptSearch);
            $this->db->group_end();
        }

        $this->data['results'] = $this->db->order_by('attn_holyday_off.work_off_date', 'DESC')->get()->result();
        echo json_encode($this->data['results']);

    }
    public function emp_holiday_add()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->data['title'] = 'Holiday Add';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/emp_holiday_add';
        $this->load->view('layout/template', $this->data);
    }
    public function holiday_add_ajax(){
        $date         = date("Y-m-d", strtotime($this->input->post('date')));
        $description  = $this->input->post('description');
        $sql          = $this->input->post('sql');
        $unit_id      = $this->input->post('unit_id');
        $emp_ids      = explode(',', $sql);

        // dd($_POST);

        $this->db->where('work_off_date <=', date("Y-m-d", strtotime('-25 month', strtotime($date))));
        $this->db->delete('attn_holyday_off');

        $data = [];
        foreach ($emp_ids as $value) {
            $data[] = array(
                'work_off_date' => $date,
                'emp_id' => $value,
                'unit_id' => $unit_id,
                'description' => $description,
            );
        }
        $this->db->where('work_off_date', $date)->where_in('emp_id', $emp_ids);
        $this->db->delete('attn_holyday_off');
        if ( $this->db->insert_batch('attn_holyday_off', $data)) {
            echo 'success';
        }else{
            echo 'error';
        }
    }
    public function emp_holiday_del($id){
        $this->db->where('id', $id);
        $this->db->delete('attn_holyday_off');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url('entry_system_con/holiday_list'));
    }

    public function holiday_delete_all(){
        $date = $this->input->post('date');
        $sql = $this->input->post('sql');
        $unit_id = $this->input->post('unit_id');
        $emp_ids = explode(',', $sql);

        $this->db->where('work_off_date ', date("Y-m-d", strtotime($date)))->where('unit_id ', $unit_id);
        if ( $this->db->where_in('emp_id', $emp_ids)->delete('attn_holyday_off') ) {
            echo 'success';
        }else{
            echo 'error';
        }
    }

    function unit_transfer($id, $new_unit_id,$last_working_date,$joining_date){
        $this->db->where('emp_id', $id);
        $pr_emp_per_info=$this->db->get('pr_emp_per_info')->row();

        $this->db->where('emp_id', $id);
        $pr_emp_com_info=$this->db->get('pr_emp_com_info')->row();

        $this->db->where('emp_id', $id);
        $this->db->update('pr_emp_com_info', array('emp_cat_id' => 5));

        $pre_unit_id=$pr_emp_com_info->unit_id;

        $this->db->where('new_emp_id', $id);
        $this->db->where_in('status', [1,2]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $pr_incre_prom_pun=$this->db->get('pr_incre_prom_pun')->row();


        $new_emp_id=$this->change_pr_emp_per_info($id, $new_unit_id, $pre_unit_id, $pr_emp_per_info);
        $this->change_pr_emp_com_info($id, $new_unit_id,$new_emp_id, $pr_emp_com_info);
        if(!empty($pr_incre_prom_pun)){
            $this->change_pr_incre_prom_pun($id,$new_emp_id,$pr_incre_prom_pun);
        }

        $data= array(
            'old_unit_id' => $pre_unit_id,
            'old_emp_id' => $id,
            'new_unit_id' => $new_unit_id,
            'new_emp_id' => $new_emp_id,
            'last_working_day' => $last_working_date,
            'joining_date' => $joining_date,
            'create_at' => date('Y-m-d'),
        );
        $this->db->insert('pr_unit_transfer', $data);
    }

    public function inter_unit_transfer_add(){
        $last_working_date = date('Y-m-d', $this->input->post('last_working_date'));
        $joining_date = date('Y-m-d', $this->input->post('joining_date'));

        $sql = $this->input->post('sql');
        $new_unit_id = $this->input->post('new_unit_id');
        $emp_ids = explode(',', $sql);
        foreach ($emp_ids as $value) {
            $this->unit_transfer($value, $new_unit_id, $last_working_date, $joining_date);
        }
        echo 1;
    }

    public function inter_unit_transfer()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->data['title'] = 'Unit Transfer';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/inter_unit_transfer';
        $this->load->view('layout/template', $this->data);
    }

    function change_pr_emp_per_info($id, $new_unit_id, $pre_unit_id, $pr_emp_per_info){
        $this->db->where('unit_id', $new_unit_id);
        $this->db->order_by('emp_id', 'DESC');
        $this->db->limit(1);
        $last_id=$this->db->get('pr_emp_com_info')->row()->emp_id;
        $new_emp_id=$last_id+1;

        $data = array(
            'emp_id' => $new_emp_id,
            'name_en' => $pr_emp_per_info->name_en,
            'name_bn' => $pr_emp_per_info->name_bn,
            'national_brn_id' => $pr_emp_per_info->national_brn_id,
            'father_name' => $pr_emp_per_info->father_name,
            'mother_name' => $pr_emp_per_info->mother_name,
            'per_village' => $pr_emp_per_info->per_village,
            'per_post' => $pr_emp_per_info->per_post,
            'per_thana' => $pr_emp_per_info->per_thana,
            'per_district' => $pr_emp_per_info->per_district,
            'per_village_bn' => $pr_emp_per_info->per_village_bn,
            'pre_home_owner' => $pr_emp_per_info->pre_home_owner,
            'holding_num' => $pr_emp_per_info->holding_num,
            'home_own_mobile' => $pr_emp_per_info->home_own_mobile,
            'pre_village' => $pr_emp_per_info->pre_village,
            'pre_post' => $pr_emp_per_info->pre_post,
            'pre_thana' => $pr_emp_per_info->pre_thana,
            'pre_district' => $pr_emp_per_info->pre_district,
            'pre_village_bn' => $pr_emp_per_info->pre_village_bn,
            'spouse_name' => $pr_emp_per_info->spouse_name,
            'emp_dob' => $pr_emp_per_info->emp_dob,
            'gender' => $pr_emp_per_info->gender,
            'marital_status' => $pr_emp_per_info->marital_status,
            'religion' => $pr_emp_per_info->religion,
        );
        $this->db->insert('pr_emp_per_info', $data);

        return $new_emp_id;
    }
    function change_pr_emp_com_info($id, $new_unit_id,$new_emp_id, $pr_emp_com_info){
        $data = array(
            'emp_id' => $new_emp_id,
            'unit_id' => $new_unit_id,
            'emp_dept_id' => $pr_emp_com_info->emp_dept_id,
            'emp_sec_id' => $pr_emp_com_info->emp_sec_id,
            'emp_line_id' => $pr_emp_com_info->emp_line_id,
            'attn_sum_line_id' => $pr_emp_com_info->attn_sum_line_id,
            'emp_desi_id' => $pr_emp_com_info->emp_desi_id,
            'emp_sal_gra_id' => $pr_emp_com_info->emp_sal_gra_id,
            'emp_cat_id' => $pr_emp_com_info->emp_cat_id,
            'proxi_id' => $pr_emp_com_info->proxi_id,
            'emp_shift' => $pr_emp_com_info->emp_shift,
            'gross_sal' => $pr_emp_com_info->gross_sal,
            'com_gross_sal' => $pr_emp_com_info->com_gross_sal,
            'ot_entitle' => $pr_emp_com_info->ot_entitle,
            'com_ot_entitle' => $pr_emp_com_info->com_ot_entitle,
            'transport' => $pr_emp_com_info->transport,
            'lunch' => $pr_emp_com_info->lunch,
            'att_bonus' => $pr_emp_com_info->att_bonus,
            'salary_draw' => $pr_emp_com_info->salary_draw,
            'salary_type' => $pr_emp_com_info->salary_type,
            'emp_join_date' => $pr_emp_com_info->emp_join_date,
        );
        $this->db->insert('pr_emp_com_info', $data);
    }
    function change_pr_incre_prom_pun($old_emp_id,$new_emp_id,$pr_incre_prom_pun){
        $data = array(
            'prev_emp_id' => $old_emp_id,
            'prev_dept' => $pr_incre_prom_pun->prev_dept,
            'prev_section' => $pr_incre_prom_pun->prev_section,
            'prev_line' => $pr_incre_prom_pun->prev_line,
            'prev_desig' => $pr_incre_prom_pun->prev_desig,
            'prev_grade' => $pr_incre_prom_pun->prev_grade,
            'prev_salary' => $pr_incre_prom_pun->prev_salary,
            'prev_com_salary' => $pr_incre_prom_pun->prev_com_salary,
            'new_emp_id' => $new_emp_id,
            'new_dept' => $pr_incre_prom_pun->new_dept,
            'new_section' => $pr_incre_prom_pun->new_section,
            'new_line' => $pr_incre_prom_pun->new_line,
            'new_desig' => $pr_incre_prom_pun->new_desig,
            'new_grade' => $pr_incre_prom_pun->new_grade,
            'new_salary' => $pr_incre_prom_pun->new_salary,
            'new_com_salary' => $pr_incre_prom_pun->new_com_salary,
            'effective_month' => $pr_incre_prom_pun->effective_month,
            'ref_id' => $pr_incre_prom_pun->ref_id,
            'status' => $pr_incre_prom_pun->status, //tranfer unit
        );
        $this->db->insert('pr_incre_prom_pun', $data);
    }
    //------------------------------------------------------------------------------------------
    // GRID for holiday
    //------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
    // CRUD for Gov. holiday
    //-------------------------------------------------------------------------------------
    public function gov_holiday_list(){
		if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $unit_id = $this->data['user_data']->unit_name;

		$this->db->where('unit_id', $unit_id)->order_by('id', 'desc');
		$this->data['data'] = $this->db->get('pr_gov_holiday')->result();
        $this->data['username'] = $unit_id;
        $this->data['title'] = 'Gov. Holiday List';
        $this->data['subview'] = 'entry_system/gov_holiday_add';
        $this->load->view('layout/template', $this->data);
    }

	function gov_holiday_add(){
        $unit_id = $this->data['user_data']->unit_name;
        // dd($unit_id);
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $data = array(
            'unit_id'      => $unit_id,
            'date'         => $date,
            'description'  => $this->input->post('description'),
        );
        $check = $this->db->where('unit_id', $unit_id)->where('date', $date)->get('pr_gov_holiday')->row();
		if (empty($check)) {
            $this->db->insert('pr_gov_holiday', $data);
			$this->session->set_flashdata('success', 'Added Successfully');
		}else{
			$this->session->set_flashdata('failuer', 'Added Failed');
		}
		redirect('entry_system_con/gov_holiday_list');
	}

	function gov_holiday_edit($id){
		if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
		if (!empty($_POST['date'])) {
			$data =	array(
				'date'          => date('Y-m-d', strtotime($_POST['date'])),
				'description' 	=> $_POST['description']
			);
			$this->db->where('id', $id);
			$this->db->update('pr_gov_holiday', $data);
			$this->session->set_flashdata('success', 'Updated Successfully');
			redirect('entry_system_con/gov_holiday_list');
		}
		$this->db->select('pr_units.*');
        $this->data['units'] = $this->db->get('pr_units')->result_array();

		$this->data['row']      = $this->db->where('id', $id)->get('pr_gov_holiday')->row();
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['title']    = 'List Edit';
        $this->data['subview']  = 'entry_system/gov_holiday_edit';
        $this->load->view('layout/template', $this->data);
	}

	function gov_holiday_delete($id){
		if ($this->db->delete('pr_gov_holiday', array('id' => $id))) {
			$this->session->set_flashdata('success', 'Deleted Successfully');
		}else{
			$this->session->set_flashdata('failuer', 'Deleted Failed');
		}
		redirect('entry_system_con/gov_holiday_list');
	}
    //-------------------------------------------------------------------------------------
    // CRUD for Gov. holiday
    //-------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------
    // Leave entry to the Database
    //------------------------------------------------------------------------------------------
    public function leave_transation()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }
        $this->data['title'] = 'Leave Transaction';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/leave_transation';
        $this->load->view('layout/template', $this->data);
    }
    public function pr_units_get(){
        $user_data=$this->session->userdata('data');
        $this->db->select('pr_units.*');
        if($user_data->level!='All'){
            $this->db->where('unit_id', $user_data->unit_name);
        }
        return $this->db->get('pr_units')->result();
    }

    public function leave_entry(){
        // dd($_POST);
        $emp_id = $_POST['emp_id'];
        $apply_date = date("Y-m-d", strtotime($_POST['apply_date']));
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $year = date("Y", strtotime($from_date));
        $leave_type = $_POST['leave_type'];
        $reason = $_POST['reason'];
        $add_on_vacation = $_POST['add_on_vacation'];
        $unit_id = $_POST['unit_id'];
        $leave_start = date("Y-m-d", strtotime($from_date));
        $leave_end = date("Y-m-d", strtotime($to_date));
        $total_leave = date_diff(date_create($leave_start), date_create($leave_end))->format('%a') + 1;

        // Check for duplicate entry
        $duplicate_check = $this->db->where('emp_id', $emp_id)
                        ->where('leave_start', $leave_start)
                        ->where('leave_end', $leave_end)
                        ->where('leave_type', $leave_type)
                        ->get('pr_leave_trans')
                        ->num_rows();
        if ($duplicate_check > 0) {
            echo "Duplicate leave entry found";
            exit();
        }

        $balance = $this->leave_balance_ajax($emp_id, $leave_start, 1);

        if ($leave_type == 'el') {
            if ($balance['leave_balance_earn'] <= 0) {
            echo "This employee have not enough leave balance";
            exit();
            }

            if (($balance['leave_balance_earn']+1) <= $total_leave) {
            echo "This employee have not enough leave balance";
            exit();
            }
        }

        if ($leave_type == 'cl') {
            if ($balance['leave_balance_casual'] <= 0) {
            echo "This employee have not enough leave balance";
            exit();
            }

            if (($balance['leave_balance_casual']+1) <= $total_leave) {
            echo "This employee have not enough leave balance";
            exit();
            }
        }

        if ($leave_type == 'sl') {
            if ($balance['leave_balance_sick'] <= 0) {
            echo "This employee have not enough leave balance";
            exit();
            }
            if (($balance['leave_balance_sick']+1) <= $total_leave) {
            echo "This employee have not enough leave balance";
            exit();
            }
        }

        if ($leave_type == 'ml' && $balance['epm_info']->gender == 'Female') {
            if ($balance['leave_balance_maternity'] <= 0) {
            echo "This employee have not enough leave balance";
            exit();
            }

            if ($balance['leave_balance_maternity'] <= $total_leave) {
            echo "This employee have not enough leave balance";
            exit();
            }
        } else if($leave_type == 'ml') {
            echo "This employee is not eligible to apply for leave";
            exit();
        }

        if ($leave_type == 'sp') {
            if ($balance['leave_balance_paternity'] <= 0) {
            echo "This employee have not enough leave balance";
            exit();
            }

            if ($balance['leave_balance_paternity'] < $total_leave) {
            echo "This employee have not enough leave balance";
            exit();
            }
        }
        // dd($balance);

        $formArray = array(
            'emp_id'            => $emp_id,
            'unit_id'           => $unit_id,
            'start_date'        => $apply_date,
            'leave_type'        => $leave_type,
            'leave_start'       => $leave_start,
            'leave_end'         => $leave_end,
            'total_leave'       => $total_leave,
            'leave_descrip'     => $reason,
            'add_on_vacation'   => $add_on_vacation,
        );
        if ($this->db->insert('pr_leave_trans', $formArray)) {
            echo "success";
        }else{
            echo "error";
        };
    }

    public function leave_balance_ajax($id = null, $year = null, $type = null){

        if ($id != null && $year != null && $type != null) {
            $year = date('Y', strtotime($year));
            $emp_id = $id;
        } else {
            $year = date($_POST['year']);
            $emp_id = date($_POST['emp_id']);
        }

        $leav_cal = date($year.'-12-31', $year);
        $this->db->where('emp_id', $emp_id)->where('earn_month', $leav_cal);
        $earn_l = $this->db->get('pr_earn_leave')->row();
        if (!empty($earn_l)) {
            $earn_leave = $earn_l->earn_leave;
        }else{
            $earn_leave = 0;
        }


        $this->db->where('emp_id', $emp_id);
        $data['epm_info'] = $this->db->get('pr_emp_per_info')->row();

        $unit_id = $this->db->where('emp_id', $emp_id)->get('pr_emp_com_info')->row()->unit_id;
        if($unit_id != ''){
            $leave_entitle = $this->db->where('unit_id', $unit_id)->get('pr_leave')->row();
        } else {
            $leave_entitle = $this->db->get('pr_leave')->row();
        }

        $data['leave_entitle_casual']= $leave_entitle->lv_cl;
        $data['leave_entitle_sick']= $leave_entitle->lv_sl;
        if ($data['epm_info']->gender == 'Female') {
            $data['leave_entitle_maternity'] = $leave_entitle->lv_ml;
        } else {
            $data['leave_entitle_maternity'] = 0;
        }
        $data['leave_entitle_paternity']= $leave_entitle->lv_pl;
        $data['leave_entitle_earn']= $earn_leave;

        $first_date = $year . "-01-01";
        $last_date = $year . "-12-31";
        $this->db->select("
                SUM(CASE WHEN leave_type = 'cl' THEN total_leave ELSE 0 END) AS cl,
                SUM(CASE WHEN leave_type = 'sl' THEN total_leave ELSE 0 END) AS sl,
                SUM(CASE WHEN leave_type = 'ml' THEN total_leave ELSE 0 END) AS ml,
                SUM(CASE WHEN leave_type = 'pl' THEN total_leave ELSE 0 END) AS pl,
                SUM(CASE WHEN leave_type = 'el' THEN total_leave ELSE 0 END) AS el,
            ");
        $this->db->where('emp_id', $emp_id);
        $this->db->where('leave_start >=', $first_date);
        $this->db->where('leave_end <=', $last_date);
        $value = $this->db->get('pr_leave_trans')->row();

        $this->db->select("
                SUM(CASE WHEN leave_type = 'ml' THEN total_leave ELSE 0 END) AS ml,
            ");
        $this->db->where('emp_id', $emp_id);
        $this->db->where('leave_start >=', $first_date);
        $this->db->where('leave_start <=', $last_date);
        $met = $this->db->get('pr_leave_trans')->row();

        if (!empty($met)) {
            $data['leave_taken_maternity'] = $met->ml;
        } else {
            $data['leave_taken_maternity'] = 0;
        }

        if (!empty($value)) {
            $data['leave_taken_casual'] = $value->cl;
            $data['leave_taken_sick'] = $value->sl;
            $data['leave_taken_paternity'] = $value->pl;
            $data['leave_taken_earn'] = $value->el;
        } else {
            $data['leave_taken_casual'] = 0;
            $data['leave_taken_sick'] = 0;
            $data['leave_taken_paternity'] = 0;
            $data['leave_taken_earn'] = 0;
        }

        $data['leave_balance_casual'] = $data['leave_entitle_casual'] - $data['leave_taken_casual'];
        $data['leave_balance_sick'] = $data['leave_entitle_sick'] - $data['leave_taken_sick'];
        $data['leave_balance_maternity'] = $data['leave_entitle_maternity'] - $data['leave_taken_maternity'];
        $data['leave_balance_paternity'] = $data['leave_entitle_paternity'] - $data['leave_taken_paternity'];
        $data['leave_balance_earn'] = $data['leave_entitle_earn'] - $data['leave_taken_earn'];
        // dd($data);
        if ($type != null) {
            return $data;
        } else {
            echo json_encode($data);
            return;
        }
    }

    public function leave_list(){
        $this->data['title'] = 'Leave List';
        $this->data['username'] = $this->data['user_data']->id_number;
        // dd($this->data);
        $this->data['subview'] = 'entry_system/leave_list';
        $this->load->view('layout/template', $this->data);
    }

    public function leave_list_ajax(){
        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $emp_id = $this->input->post('emp_id');

        $this->db->select('pr_leave_trans.*, pr_units.unit_name, pr_emp_per_info.name_en as user_name');
        $this->db->from('pr_leave_trans');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_leave_trans.unit_id', 'left');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_leave_trans.emp_id', 'left');
        $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);

        // ✅ date range filter (better logic)
        if (!empty($from_date) && !empty($to_date) && $from_date <= $to_date) {
            $this->db->where('pr_leave_trans.leave_start >=', $from_date);
            $this->db->where('pr_leave_trans.leave_end <=', $to_date);
        }

        // ✅ month filter (fix)
        if (!empty($month)) {
            $this->db->where("DATE_FORMAT(pr_leave_trans.leave_start, '%Y-%m') =", $month);
        }

        // ✅ year filter
        if (!empty($year)) {
            $this->db->where('YEAR(pr_leave_trans.leave_start)', $year);
        }

        // ✅ employee filter
        if (!empty($emp_id)) {
            $this->db->where('pr_leave_trans.emp_id', $emp_id);
        }

        // ✅ pagination + sorting
        $this->db->limit($limit, $offset);
        $this->db->order_by('pr_leave_trans.leave_start', 'DESC');
        $results = $this->db->get()->result();
        echo json_encode($results);
    }

    public function emp_leave_del($id){
        $this->db->where('id', $id);
        $this->db->delete('pr_leave_trans');
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url('entry_system_con/leave_list'));
    }
    //--------------------------------------------------------------------------------------
    // Leave end
    //--------------------------------------------------------------------------------------

    //------------------------------------------------------------------------------------------
    // maternity entry to the Database
    //------------------------------------------------------------------------------------------
    public function maternity_entry()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }
        $this->data['title'] = 'Maternity Entry';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/maternity_entry';
        $this->load->view('layout/template', $this->data);
    }

    public function change_date_ml()
    {
        $emp_id = $this->input->post('sql');
        $unit_id = $this->input->post('unit_id');
        $probability = $this->input->post('probability');
        $lv_ml = $this->db->select('lv_ml')->where('unit_id', $unit_id)->get('pr_leave')->row()->lv_ml;
        $half_ml = $lv_ml / 2;
        $mhl = $half_ml - 1;
        $start_date = date('Y-m-d', strtotime("-{$mhl} days", strtotime($probability)));
        $end_date = date('Y-m-d', strtotime("+{$half_ml} days", strtotime($probability)));

        // get Installment date
        $fir_inst = $this->get_first_installment_date($start_date, $emp_id);  // get first Installment date
        $sec_inst = $this->get_second_installment_date($end_date, $emp_id);  // get second Installment date
        $data = array(
            'unit_id' => $unit_id,
            'lv_ml' => $lv_ml,
            'half_ml' => $half_ml,
            'start_date' => date('d-m-Y', strtotime($start_date)),
            'end_date' => date('d-m-Y', strtotime($end_date)),
            'fir_inst' => date('d-m-Y', strtotime($fir_inst)),
            'sec_inst' => date('d-m-Y', strtotime($sec_inst))
        );
        echo json_encode($data);
    }

    public function get_first_installment_date($fir_inst, $emp_id)
    {
        // check holiday
        $fir_inst = date('Y-m-d', strtotime("-1 days", strtotime($fir_inst)));
        $fir_day = date('D', strtotime($fir_inst));
        $holiday = $this->db->where('date', $fir_inst)->get('pr_gov_holiday')->row();
        if (!empty($holiday) && ($holiday->date == $fir_inst)) {
            $fir_inst = date('Y-m-d', strtotime("-1 days", strtotime($fir_inst)));
            $fir_day = date('D', strtotime($fir_inst));
        }

        // check weekend
        $this->db->select('sche.*');
        $this->db->from('pr_emp_com_info as com');
        $this->db->join('pr_emp_shift as shift', 'shift.id = com.emp_shift', 'left');
        $this->db->join('pr_emp_shift_schedule as sche', 'sche.id = shift.schedule_id', 'left');
        $this->db->where('com.emp_id', $emp_id);
        $row = $this->db->get()->row()->of_day;
        $rows = json_decode($row);
        if (!empty($rows)) {
            foreach ($rows as $key => $r) {
                if ($r == $fir_day) {
                    $fir_inst = date('Y-m-d', strtotime("-1 days", strtotime($fir_inst)));
                    $fir_day = date('D', strtotime($fir_inst));
                }
            }
        }

        // again check holiday
        $holiday = $this->db->where('date', $fir_inst)->get('pr_gov_holiday')->row();
        if (!empty($holiday) && ($holiday->date == $fir_inst)) {
            $fir_inst = date('Y-m-d', strtotime("-1 days", strtotime($fir_inst)));
        }
        return $fir_inst;
    }

    public function get_second_installment_date($sec_inst, $emp_id)
    {
        // check holiday
        $sec_inst = date('Y-m-d', strtotime("+1 days", strtotime($sec_inst)));
        $sec_day = date('D', strtotime($sec_inst));
        $holiday = $this->db->where('date', $sec_inst)->get('pr_gov_holiday')->row();
        if (!empty($holiday) && ($holiday->date == $sec_inst)) {
            $sec_inst = date('Y-m-d', strtotime("+1 days", strtotime($sec_inst)));
            $sec_day = date('D', strtotime($sec_inst));
        }

        // check weekend
        $this->db->select('sche.*');
        $this->db->from('pr_emp_com_info as com');
        $this->db->join('pr_emp_shift as shift', 'shift.id = com.emp_shift', 'left');
        $this->db->join('pr_emp_shift_schedule as sche', 'sche.id = shift.schedule_id', 'left');
        $this->db->where('com.emp_id', $emp_id);
        $row = $this->db->get()->row()->of_day;
        $rows = json_decode($row);
        if (!empty($rows)) {
            foreach ($rows as $key => $r) {
                if ($r == $sec_day) {
                    $sec_inst = date('Y-m-d', strtotime("+1 days", strtotime($sec_inst)));
                    $sec_day = date('D', strtotime($sec_inst));
                }
            }
        }

        // again check holiday
        $holiday = $this->db->where('date', $sec_inst)->get('pr_gov_holiday')->row();
        if (!empty($holiday) && ($holiday->date == $sec_inst)) {
            $sec_inst = date('Y-m-d', strtotime("+1 days", strtotime($sec_inst)));
        }
        return $sec_inst;
    }

    public function chack_ability($emp_id)
    {
        $this->db->select('pr_emp_com_info.emp_id');
        $this->db->from('pr_emp_com_info');
        $this->db->from('pr_emp_per_info');
        $this->db->where('pr_emp_com_info.emp_id = pr_emp_per_info.emp_id');
        $this->db->where('pr_emp_per_info.gender', 'Female');
        $this->db->where('pr_emp_per_info.marital_status', 'Married');
        $row = $this->db->where('pr_emp_com_info.emp_id', $emp_id)->get()->row();
        if (!empty($row)) {
           return true;
        } else {
            return false;
        }
    }

    public function save_maternity(){
        if ($this->chack_ability($this->input->post('sql')) != true) {
            echo 'Please check Emp information, Gender and Marital Status is not Match';
            exit();
        }

        $inform_date = date('Y-m-d', strtotime($this->input->post('inform_date')));
        $probability = date('Y-m-d', strtotime($this->input->post('probability')));
        $start_date  = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end_date    = date('Y-m-d', strtotime($this->input->post('end_date')));
        $first_pay   = date('Y-m-d', strtotime($this->input->post('first_pay')));
        $second_pay  = date('Y-m-d', strtotime($this->input->post('second_pay')));
        $unit_id     = $this->input->post('unit_id');
        $emp_id      = $this->input->post('sql');
        $tot_pay_day = $this->input->post('tot_pay_day');
        $pay_day     = ($this->input->post('tot_pay_day') / 2);

        $this->db->where('emp_id', $emp_id);
        $this->db->where('salary_month', date('Y-m-01', strtotime("-1 month", strtotime($start_date))));
        $payment = $this->db->get('pay_salary_sheet')->row();
        if (empty($payment)) {
            // echo 'Previous Month salary not found';
            // exit();
            $payment = $this->db->where('emp_id', $emp_id)->order_by('salary_month', 'desc')->get('pay_salary_sheet')->row();
        }

        $year=date('Y-m-d', strtotime($start_date));
        $balance = $this->leave_balance_ajax($emp_id, $year, 1);

        if ($balance['leave_balance_maternity'] < $tot_pay_day) {
            echo "This employee have not enough leave";
            exit();
        }

        $formArray = array(
            'emp_id' => $emp_id,
            'unit_id' => $unit_id,
            'start_date' => $start_date,
            'leave_type' => 'ml',
            'leave_start' => $start_date,
            'leave_end' => $end_date,
            'total_leave' => $tot_pay_day,
        );

        if ($this->db->insert('pr_leave_trans', $formArray)) {
            $form_data=array(
                'prev_month_salary'=> $payment->gross_sal ?? 0,
                'attn_bonus' => $payment->att_bonus ?? 0,
                'festival_bonus'=>$payment->festival_bonus ?? 0,
                'inform_date'=>$inform_date,
                'probability'=>$probability,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
                'first_pay'=>$first_pay,
                'second_pay'=>$second_pay,
                'unit_id'=>$unit_id,
                'emp_id'=>$emp_id,
                'pay_day'=>$pay_day,
                'total_day'=>$tot_pay_day,
                'created_at'=>date('Y-m-d'),
            );

            if ($this->db->insert('pr_maternity_entry_histry', $form_data)) {
                echo 'Record successfully Inserted';
                exit();
            } else {
                echo 'Record Not Inserted';
                exit();
            }
        } else {
            echo 'Record Not Inserted';
            exit();
        }
    }

    public function maternity_list(){
        $this->db->select('pmeh.*, pr_units.unit_name, pr_emp_per_info.name_en');
        $this->db->from('pr_maternity_entry_histry pmeh');
        $this->db->join('pr_units', 'pr_units.unit_id = pmeh.unit_id');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pmeh.emp_id');
        $this->db->where('pmeh.unit_id', $this->data['user_data']->unit_name);
        $this->db->order_by('pmeh.id', 'desc');
        $this->data['results'] = $this->db->get()->result();
        $this->data['title'] = 'Maternity List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/maternity_list';
        $this->load->view('layout/template', $this->data);
    }

    public function updated_maternity(){
        $id                     = $_POST['id'];
        $festival_bonus         = $_POST['festival_bonus'];
        $ather_benifit          = $_POST['ather_benifit'];
        $festival_month         = date('Y-m-01', strtotime($_POST['festival_month']));
        $abenifit_month         = date('Y-m-01', strtotime($_POST['abenifit_month']));

        $data = array(
            'festival_bonus'     => $festival_bonus,
            'ather_benifit'      => $ather_benifit,
            'festival_month'     => $festival_month,
            'abenifit_month'     => $abenifit_month,
        );
        $this->db->where('id', $id)->update('pr_maternity_entry_histry', $data);
        echo json_encode(array('success' => true));
    }

    public function maternity_delete($id){
        $this->db->where('id', $id);
        $leave_data=$this->db->get('pr_maternity_entry_histry')->result();
        $this->db->where('id', $id);
        if ($this->db->delete('pr_maternity_entry_histry')) {
            $this->db->where('emp_id', $leave_data[0]->emp_id);
            $this->db->where('unit_id', $leave_data[0]->unit_id);
            $this->db->where('leave_type', 'ml');
            $this->db->where('leave_start', $leave_data[0]->start_date);
            $this->db->where('leave_end', $leave_data[0]->end_date);
            $this->db->delete('pr_leave_trans');
            $this->session->set_flashdata('success', 'Record Deleted Successfully');
            redirect('entry_system_con/maternity_list');
        }else{
            $this->session->set_flashdata('error', 'Record Not Deleted');
            redirect('entry_system_con/maternity_list');
        }
    }
    //------------------------------------------------------------------------------------------
    // end maternity entry to the Database
    //------------------------------------------------------------------------------------------


    //-------------------------------------------------------------------------------------
    // CRUD for // Left/Resign
    //-------------------------------------------------------------------------------------
    public function left_resign_entry()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name)->result();
        }

        $this->data['title'] = 'Left / Resign Entry';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/left_resign_entry';
        $this->load->view('layout/template', $this->data);
    }

    public function add_left_regign()
    {
        $sql = $_POST['sql'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $type = $_POST['type'];
        $unit_id = $_POST['unit_id'];
        $remark = $_POST['remark'];
        // $emp_ids = explode(',', $sql);

        if ($type == 1) {
            $this->db->where('unit_id', $unit_id)->where('emp_id', $sql)->delete('pr_emp_left_history');
            $this->db->where('unit_id', $unit_id)->where('emp_id', $sql)->delete('pr_emp_resign_history');

            $this->db->where('unit_id', $unit_id)->where('emp_id', $sql);
            if ($this->db->update('pr_emp_com_info', array('emp_cat_id' => 1, 'monitor_con'=>2, 'monitor_type'=> 'Left/Resign to Regular'))) {
                echo 'success';
            }else{
                echo 'error';
            }
        } else if ($type == 2 && !empty($date)) {
            $data = [];
            $data = array('unit_id' => $unit_id, 'emp_id' => $sql, 'left_date' => $date, 'remark' => $remark, 'monitor_con'=>2);
            $dd = $this->db->where('unit_id', $unit_id)->where('emp_id', $sql)->get('pr_emp_left_history');
            if (empty($dd->row())) {
                $this->db->insert('pr_emp_left_history', $data);
            }
            // $this->db->insert_batch('pr_emp_left_history', $data);

            $this->db->where('unit_id', $unit_id)->where('emp_id', $sql);
            if ($this->db->update('pr_emp_com_info', array('emp_cat_id' => 2,'monitor_con'=>2, 'monitor_type'=> 'Left'))) {
                echo 'success';
            }else{
                echo 'error';
            }
        } else {
            $data = [];
            $data = array('unit_id' => $unit_id, 'emp_id' => $sql, 'resign_date' => $date, 'remark' => $remark, 'monitor_con'=>2);
            $dd = $this->db->where('unit_id', $unit_id)->where('emp_id', $sql)->get('pr_emp_resign_history');
            if (empty($dd->row())) {
                $this->db->insert('pr_emp_resign_history', $data);
            }
            $this->db->where('unit_id', $unit_id)->where('emp_id', $sql);
            if ($this->db->update('pr_emp_com_info', array('emp_cat_id' => 3,'monitor_con'=>2, 'monitor_type'=> 'Resign'))) {
                echo 'success';
            }else{
                echo 'error';
            }
        }
    }

    public function left_list()
    {
        $this->data['title'] = 'Left List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/left_list';
        $this->load->view('layout/template', $this->data);
    }
    public function left_list_ajax()
    {

        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');
        $deptSearch = $this->input->post('deptSearch');
        $this->db->select('lf.left_id, lf.unit_id,lf.status, lf.emp_id, lf.left_date, lf.remark, pr_units.unit_name, per.name_en as user_name');
        $this->db->from('pr_emp_left_history as lf');
        $this->db->join('pr_units', 'pr_units.unit_id = lf.unit_id', 'left');
        $this->db->join('pr_emp_per_info as per', 'per.emp_id = lf.emp_id', 'left');
        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        }
        $this->db->group_by('lf.emp_id, lf.left_id, lf.unit_id, lf.left_date, lf.remark, pr_units.unit_name, per.name_en');
        $this->db->order_by('lf.left_date', 'DESC');
        $this->db->limit($limit, $offset);
        if (!empty($deptSearch) && $deptSearch != '') {
            $this->db->group_start();
            $this->db->or_like('pr_units.unit_name', $deptSearch);
            $this->db->or_like('per.name_en', $deptSearch);
            $this->db->or_like('per.emp_id', $deptSearch);
            $this->db->group_end();
        }
        $results = $this->db->get()->result();
        echo json_encode($results);

    }

    public function resign_list(){
        // $this->db->select('rs.*, pr_units.unit_name, per.name_en as user_name');
        // $this->db->from('pr_emp_resign_history as rs');
        // $this->db->join('pr_units', 'pr_units.unit_id = rs.unit_id', 'left');
        // $this->db->join('pr_emp_per_info as per', 'per.emp_id = rs.emp_id', 'left');
        // if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
        //     $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        // }
        // $this->db->order_by('rs.resign_date', 'DESC');
        // $this->db->group_by('rs.emp_id');
        // $this->data['results'] = $this->db->get()->result();

        $this->data['title'] = 'Left List';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'entry_system/resign_list';
        $this->load->view('layout/template', $this->data);
    }

    public function resign_list_ajax(){
        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');
        $deptSearch = $this->input->post('deptSearch');

        $this->db->select('rs.*, pr_units.unit_name, per.name_en as user_name');
        $this->db->from('pr_emp_resign_history as rs');
        $this->db->join('pr_units', 'pr_units.unit_id = rs.unit_id', 'left');
        $this->db->join('pr_emp_per_info as per', 'per.emp_id = rs.emp_id', 'left');

        if (!empty($this->data['user_data']->unit_name) && $this->data['user_data']->unit_name != 'All') {
            $this->db->where('pr_units.unit_id', $this->data['user_data']->unit_name);
        }

        $this->db->order_by('rs.resign_date', 'DESC');
        // $this->db->group_by('rs.emp_id');
        $this->db->limit($limit, $offset);

        if (!empty($deptSearch) && $deptSearch != '') {
            $this->db->group_start();
            $this->db->or_like('pr_units.unit_name', $deptSearch);
            $this->db->or_like('per.name_en', $deptSearch);
            $this->db->or_like('per.emp_id', $deptSearch);
            $this->db->group_end();
        }

        $this->data['results'] = $this->db->get()->result();
        echo json_encode($this->data['results']);
    }

    public function left_delete($id){
        $this->db->where('emp_id', $id);
        if ($this->db->delete('pr_emp_left_history')) {
            $this->db->where('emp_id', $id)->update('pr_emp_com_info', array('emp_cat_id' => 1));
        }

        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url('entry_system_con/left_list'));
    }

    public function print_envelope($id){
        $this->db->where('emp_id', $id);
        $employee_info = $this->db->get('pr_emp_com_info')->row();
        $this->data['employee_info'] = $employee_info;
        $this->data['unit_id'] = $this->session->userdata('data')->unit_name;
        $this->load->view('entry_system/print_envelope', $this->data);
    }

    public function resign_delete($id){
        $this->db->where('emp_id', $id);
        if ($this->db->delete('pr_emp_resign_history')) {
            $this->db->where('emp_id', $id)->update('pr_emp_com_info', array('emp_cat_id' => 1));
        }
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect(base_url('entry_system_con/resign_list'));
    }

    public function add_final_satalment(){
        $info = $this->db->where('emp_id', $_POST['emp_id'])->get('pr_emp_resign_history')->row();
        $resign_date1 = date('Y-m-01', strtotime($info->resign_date));
        $resign_date2 = date('Y-m-d', strtotime($info->resign_date));
        $diff = date_diff(date_create($resign_date1), date_create($resign_date2));
        $resign_day = $diff->format('%a');

        // attendance bonus calculation
        $date11 = date('Y-m-t', strtotime($info->resign_date));
        $num_of_days = date('t', strtotime($info->resign_date));
        $attn_bonus = 0;
        if ($date11 == $resign_date2) {
            $emp_info = $this->db->where('emp_id', $_POST['emp_id'])->get('pr_emp_com_info')->row();
            $attendances = $this->attendance_check($_POST['emp_id'], $resign_date1, $date11);
            $attend  =  $attendances->attend;
            $absent  =  $attendances->absent;
            $weekend =  $attendances->weekend;
            $holiday =  $attendances->holiday;
            $total_leave =  $attendances->total_leave;

            $att_check = $attend + $weekend  + $holiday + $total_leave;
            if($att_check >= $num_of_days && $absent == 0)
            {
                $allowances = $this->get_emp_allowances($emp_info->emp_desi_id);
                $attn_bonus = isset($allowances->attn_bonus) ? $allowances->attn_bonus : 0;
            }
        }

        $emp_id                = $_POST['emp_id'];
        $gross_salary          = $_POST['gross_salary'];
        $basic_salary          = $_POST['basic_salary'];
        $ot_rate               = $_POST['ot_rate'];
        $hidden_gross_salary   = $_POST['hidden_gross_salary'];
        $hidden_basic_salary   = $_POST['hidden_basic_salary'];
        $hidden_ot_rate        = $_POST['hidden_ot_rate'];
        $resign_pay_day        = $_POST['resign_pay_day'];
        $extra_payoff          = $_POST['extra_payoff'];
        $earn_leave_day        = $_POST['earn_leave_day'];
        $another_deposit       = $_POST['another_deposit'];
        $notice_deduct         = $_POST['notice_deduct'];
        $advanced_salary       = $_POST['advanced_salary'];
        $service_benifit       = $_POST['service_benifit'];
        $get_info              = $this->final_log_info($info);
        $rpay                  = round($resign_pay_day * ($basic_salary / 30), 2);
        $extra_pay             = round($extra_payoff * ($basic_salary / 30), 2);
        $earn_pay              = round(($earn_leave_day / 18), 2) * round($gross_salary / 30, 2);
        $emp_total_pay         = $rpay + $extra_pay + $earn_pay;

        $absent                = ($get_info->absent * round($basic_salary / 30, 2));
        $ndeduct               = round($notice_deduct * ($basic_salary / 30), 2) + $absent;

        $data = array(
            'working_days'          => $get_info->absent + $get_info->present,
            'per_day_rate'          => $basic_salary / 30,
            'ot_eot'                => $get_info->ot_hour + $get_info->eot_hour,
            'ot_2pm'                => $get_info->ot_hour,
            'ot_eot_4pm'            => $get_info->ot_hour + $get_info->ot_eot_4pm,
            'ot_eot_12am'           => $get_info->ot_hour + $get_info->ot_eot_12am,
            'all_eot_woh'           => $get_info->ot_hour + $get_info->eot_hour - ($get_info->all_eot_wday + $get_info->all_eot_hday),
            'ot_rate'               => $ot_rate,
            'resign_pay_day'        => $resign_pay_day,
            'resign_pay'            => $rpay,
            'service_benifit_rate'  => round($gross_salary / 30, 2),
            'extra_payoff'          => $extra_payoff,
            'earn_leave'            => $earn_leave_day,
            'service_benifit'       => $service_benifit,
            'another_deposit'       => $another_deposit,
            'notice_deduct'         => $notice_deduct,
            'absent'                => $get_info->absent,
            'advanced_salary'       => $advanced_salary,
            'total_deduct'          => ($ndeduct + $advanced_salary),
            'attn_bonus'            => $attn_bonus,
            'net_pay'               => $emp_total_pay,
            'status'                => 1,
        );
        $this->db->where('emp_id', $_POST['emp_id'])->update('pr_emp_resign_history', $data);
        echo json_encode(array('success' => true));
    }

    public function final_log_info($info){
        $this->db->select('
                SUM(ot) as ot_hour,
                SUM(eot) as eot_hour,
                SUM(ot_eot_4pm) as ot_eot_4pm,
                SUM(ot_eot_12am) as ot_eot_12am,
                SUM(with_out_friday_ot) as with_out_friday_ot,
                SUM(CASE WHEN present_status = "W" THEN eot ELSE 0 END) as all_eot_wday,
                SUM(CASE WHEN present_status = "H" THEN eot ELSE 0 END) as all_eot_hday,
                SUM(CASE WHEN present_status != "A" THEN 1 ELSE 0 END) as present,
                SUM(CASE WHEN present_status = "A" THEN 1 ELSE 0 END) as absent', FALSE
        );
        $this->db->from('pr_emp_shift_log');
        $this->db->where('pr_emp_shift_log.emp_id',$info->emp_id);
        $this->db->where('shift_log_date >=',date('Y-m-01',strtotime($info->resign_date)));
        $this->db->where('shift_log_date <=',date('Y-m-d',strtotime($info->resign_date)));
        return $this->db->get()->row();
	}
    //---------------------------------------------------------------------------
    // Left/Resign end
    //----------------------------------------------------------------------------
    public function get_emp_by_unit($unit) {
        $this->db->select('
                    pr_emp_com_info.id,
                    pr_emp_com_info.emp_id,
                    pr_emp_com_info.unit_id,
                    pr_emp_per_info.name_en,
                    pr_emp_per_info.name_bn,
                ');
        $this->db->from('pr_emp_com_info');
        $this->db->join('emp_designation as deg', 'deg.id = pr_emp_com_info.emp_desi_id', 'left');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_emp_com_info.unit_id', 'left');
        $this->db->join('pr_emp_per_info', 'pr_emp_per_info.emp_id = pr_emp_com_info.emp_id', 'left');
        $this->db->where('deg.hide_status', 1);
        $this->db->where('pr_units.unit_id', $unit);
        $this->db->where('pr_emp_com_info.emp_cat_id', 1);
        // dd($this->db->get()->result());
        return $this->db->get();
    }















    ///////////////////////////////////////////////////////////////////
    // old code

    //-------------------------------------------------------------------------------------------------------
    // Form Display for Advance Loan
    //-------------------------------------------------------------------------------------------------------

    // Form Display for Due Amt. Entry
    public function due_amt_entry()
    {
        if ($this->session->userdata('logged_in') == false) {
            $this->load->view('login_message');
        } else {
            $this->load->view('form/due_amt_entry_form');
        }

    }
    //-------------------------------------------------------------------------------------------------------

    // Advance Loan entry to the Database
    //-------------------------------------------------------------------------------------------------------
    public function advance_loan_insert(){
        // dd($_POST);
        if(isset($_POST['btn'])){
            $emp_id = $this->input->post('emp_id');
            $loan_amt = $this->input->post('loan_amt');
            $pay_amt = $this->input->post('pay_amt');
            $loan_date = $this->input->post('loan_date');
            $loan_date = date("Y-m-d", strtotime($loan_date));
            $data = $this->processdb->advance_loan_insert($emp_id, $loan_amt, $pay_amt, $loan_date);
            if ($data) {
                $message = 'Leave Added Successfully';
                redirect('entry_system_con/advance_loan?status=success&message=' . urlencode($message), 'refresh');
            } else {
                $message = 'Leave Not Added';
                redirect('entry_system_con/advance_loan?status=error&message=' . urlencode($message), 'refresh');
            }

            // return $data;
        }
        // dd($data);
    }

    //-------------------------------------------------------------------------------------------------------
    // Advance Loan entry to the Database
    //-------------------------------------------------------------------------------------------------------
    public function due_amt_insert()
    {
        $emp_id = $this->input->post('emp_id');
        $due_amt = $this->input->post('due_amt');
        $due_pay_amt = $this->input->post('due_pay_amt');
        $due_pay_date = $this->input->post('due_pay_date');

        $due_pay_date = date("Y-m-d", strtotime($due_pay_date));

        $data = $this->processdb->due_amt_insert($emp_id, $due_amt, $due_pay_amt, $due_pay_date);
        echo $data;
    }


    //-------------------------------------------------------------------------------------------------------
    // Manual Attendance Entry
    //-------------------------------------------------------------------------------------------------------
    public function manual_attendance_entry()
    {
        $grid_firstdate = $this->input->post('firstdate');
        $grid_seconddate = $this->input->post('seconddate');

        $m_s_time = $this->input->post('m_s_time');
        // $m_e_time = $this->input->post('m_e_time');

        $grid_data = $this->input->post('spl');
        $grid_emp_id = explode('xxx', trim($grid_data));

        $grid_firstdate = date("Y-m-d", strtotime($grid_firstdate));
        $grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

        $data = $this->grid_model->manual_attendance_entry($grid_firstdate, $grid_seconddate, $m_s_time, $grid_emp_id);
        echo $data;
    }
    //-------------------------------------------------------------------------------------------------------
    // Attendance Delete manually (Present to Absent)
    //-------------------------------------------------------------------------------------------------------
    public function manual_entry_Delete()
    {
        $grid_firstdate = $this->input->post('firstdate');
        $grid_seconddate = $this->input->post('seconddate');

        $grid_data = $this->input->post('spl');
        $grid_emp_id = explode('xxx', trim($grid_data));
        //print_r($grid_emp_id);
        $grid_firstdate = date("Y-m-d", strtotime($grid_firstdate));
        $grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

        $this->load->model('file_process_model');
        $data = $this->grid_model->manual_entry_Delete($grid_firstdate, $grid_seconddate, $grid_emp_id);

        echo $data;
    }

    public function manual_attendance_sheet()
    {
        $grid_firstdate = $this->uri->segment(3);
        $grid_seconddate = $this->uri->segment(4);
        $grid_emp_id = $this->uri->segment(5);
        $get_session_user_unit = $this->Common_model->get_session_unit_id_name();
        $unit_id = $this->db->where("emp_id", $grid_emp_id)->get('pr_emp_com_info')->row()->unit_id;

        if ($get_session_user_unit != $unit_id) {
            echo "You Are Not Allowed.";
        } else {
            $query['values'] = $this->grid_model->manual_attendance_sheet($grid_firstdate, $grid_seconddate, $grid_emp_id);
            $query['grid_firstdate'] = $grid_firstdate;
            $query['grid_seconddate'] = $grid_seconddate;
            $query['grid_emp_id'] = $grid_emp_id;
            $query['unit_id'] = $unit_id;
            $this->load->view('manual_attendance_sheet', $query);
        }
    }

    public function manual_attendance_sheet_entry()
    {
        $data["values"] = $this->grid_model->manual_attendance_sheet_entry_db();
        echo "Data Inserted Successfully!";
    }

    public function manual_eot_modification()
    {
        $grid_firstdate = $this->uri->segment(3);
        $grid_seconddate = $this->uri->segment(4);
        $grid_emp_id = $this->uri->segment(5);
        $get_session_user_unit = $this->Common_model->get_session_unit_id_name();
        $unit_id = $this->db->where("emp_id", $grid_emp_id)->get('pr_emp_com_info')->row()->unit_id;

        /*if($get_session_user_unit != $unit_id)
        {
        echo "You Are Not Allowed.";
        }
        else
        {*/
        $query['values'] = $this->grid_model->manual_eot_modification($grid_firstdate, $grid_seconddate, $grid_emp_id);
        $query['grid_firstdate'] = $grid_firstdate;
        $query['grid_seconddate'] = $grid_seconddate;
        $query['grid_emp_id'] = $grid_emp_id;
        $query['unit_id'] = $unit_id;
        $this->load->view('manual_eot_modification_sheet', $query);
        //}
    }

    public function manual_ot_eot_modification_for_multiple()
    {
        $grid_firstdate = $this->input->post('firstdate');
        $manual_eot_hour = $this->input->post('manual_eot_hour');
        $grid_data = $this->input->post('spl');
        $grid_emp_id = explode('xxx', trim($grid_data));

        $query['values'] = $this->grid_model->manual_ot_eot_modification_for_multiple($grid_firstdate, $manual_eot_hour, $grid_emp_id);

        echo "EOT Modification Successfully!";

    }

    public function manual_eot_modify_entry()
    {
        $data["values"] = $this->grid_model->manual_eot_modify_entry_db();
        echo "Data Inserted Successfully!";
    }

    public function check_out_time_value()
    {
        $emp_id = $_POST['emp_id'];
        $manual_date = $_POST['manual_date'];
        $in_time = $_POST['in_time'];
        $out_time = $_POST['out_time'];
        $ot_hour_id = $_POST['ot_hour_id'];
        $eot_hour_id = $_POST['eot_hour_id'];
        $present_status = $_POST['present_status'];

        $weekend = $this->Attn_process_model->check_weekend($emp_id, $manual_date);
        $holiday = $this->Attn_process_model->check_holiday($emp_id, $manual_date);

        if ($manual_date == $weekend || $manual_date == $holiday) {
            // echo "hi";
            if ($weekend == 1) {
                $status = "w";
            }
            if ($holiday == 1) {
                $status = "h";
            }

            //=======Extra OT Calculation==========
            $weekend_eot_calculation = $this->Attn_process_model->weekend_holday_eot_calculation_auto($emp_id, $manual_date, $in_time, $out_time, $status, $present_status);
            $this->Attn_process_model->deduction_hour_process($emp_id, $manual_date);
            // print_r($weekend_eot_calculation);

            $over_hour = $weekend_eot_calculation['ot_hour'];
            $eot_hour = $weekend_eot_calculation['extra_ot_hour'];

            $output = array('ot_hour' => $over_hour, 'eot_hour' => $eot_hour, 'ot_hour_id' => $ot_hour_id, 'eot_hour_id' => $eot_hour_id);
            echo json_encode($output);

        } else {
            // echo "nai";
            //=================OT CALCULATION============================
            $ot_hour_calcultation = $this->Attn_process_model->ot_hour_auto_calcultation($emp_id, $in_time, $out_time, $manual_date);

            if ($ot_hour_calcultation["ot_hour"] != '') {
                if ($ot_hour_calcultation["ot_hour"] > 2) {
                    $extra_ot_hour = $ot_hour_calcultation["ot_hour"] - 2;
                    $ot_hour = $ot_hour_calcultation["ot_hour"] = 2;
                } else {
                    // echo "here";
                    $extra_ot_hour = 0;
                    $ot_hour = $ot_hour_calcultation["ot_hour"];
                }
            } else {
                $ot_hour = $ot_hour_calcultation["ot_hour"] = 0;
                $extra_ot_hour = 0;
            }

            $this->Attn_process_model->modify_ot_eot_update($emp_id, $in_time, $out_time, $ot_hour, $extra_ot_hour, $manual_date);
            $this->Attn_process_model->deduction_hour_process($emp_id, $manual_date);

            /*if($extra_ot_hour >= 0){
            $insert_extra_ot_hour = $this->insert_extra_ot_hour($emp_id, $att_date, $extra_ot_hour);
            }*/
            $over_hour = $ot_hour;
            $eot_hour = $extra_ot_hour;

            $output = array('ot_hour' => $over_hour, 'eot_hour' => $eot_hour, 'ot_hour_id' => $ot_hour_id, 'eot_hour_id' => $eot_hour_id);
            echo json_encode($output);
        }

    }

    public function ot_abstract()
    {
        $grid_firstdate = $this->input->post('grid_firstdate');
        $grid_emp_id = $this->input->post('grid_emp_id');
        $in_time = $this->input->post('in_time');
        $out_time = $this->input->post('out_time');
        $ot_hour = $this->input->post('ot_hour');
        $eot_hour = $this->input->post('eot_hour');
        $orginal_in_time = $this->input->post('orginal_in_time');
        $orginal_out_time = $this->input->post('orginal_out_time');
        $orginal_ot = $this->input->post('orginal_ot');
        $orginal_eot = $this->input->post('orginal_eot');

        $data["values"] = $this->grid_model->ot_abstract_entry_db($grid_firstdate, $grid_emp_id, $in_time, $out_time, $ot_hour, $eot_hour, $orginal_in_time, $orginal_out_time, $orginal_ot, $orginal_eot);
        /*print_r($data);
        exit;*/
        echo "Data Inserted Successfully!";
    }


    //-------------------------------------------------------------------------------------------------------
    // CRUD output method
    //-------------------------------------------------------------------------------------------------------
    public function crud_output($output = null)
    {
        $this->load->view('output.php', $output);
    }

    public function earn_leave_entry()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('pr_leave_earn');
        $crud->set_subject('Earn Leave');
        $crud->required_fields('old_earn_balance', 'current_earn_balance', 'last_update');
        //$crud->fields('emp_id','old_earn_balance','last_update');
        $crud->display_as('emp_id', 'Employee ID');

        $state = $this->grocery_crud->getState();
        if ($state == 'edit') {
            $crud->change_field_type('emp_id', 'readonly');
        }
        if ($state == 'insert_validation') {
            $crud->set_rules('emp_id', 'Employee ID', 'required|callback_emp_id_check');
            //$crud->set_rules('last_update','Last Update','required|callback_last_update_check');
        }
        $crud->unset_delete();
        //$crud->unset_edit();
        $output = $crud->render();
        $this->crud_output($output);
    }

    public function last_update_check($str)
    {
        $date = $this->input->post('last_update');
        $start_date = strtotime($date);
        $last_up = date("Y-m-d", $start_date);

        echo "<SCRIPT LANGUAGE=\"JavaScript\">alert($last_up);</SCRIPT>";
    }

    public function emp_id_check($str)
    {
        $id = $this->uri->segment(4);
        if (!empty($id) && is_numeric($id)) {
            $emp_id_old = $this->db->where("id", $id)->get('pr_leave_earn')->row()->emp_id;
            $this->db->where("emp_id !=", $emp_id_old);
        }
        $num_row = $this->db->where('emp_id', $str)->get('pr_leave_earn')->num_rows();
        if ($num_row >= 1) {
            $this->form_validation->set_message('emp_id_check', "Employee ID field '$str' already exists");
            return false;
        } else {

            $num_row1 = $this->db->where('emp_id', $str)->get('pr_emp_com_info')->num_rows();
            if ($num_row1 < 1) {
                $this->form_validation->set_message('emp_id_check', "Invalid Employee ID");
                return false;
            } else {
                return true;
            }
        }
    }




    //-------------------------------------------------------------------------------------------------------
    // New to regular :Tofayel
    //-------------------------------------------------------------------------------------------------------
    public function new_to_regular()
    {
        $this->load->view('form/new_to_rg');
    }
    public function new_to_regular_process()
    {
        $month = $this->input->post('report_month_sal');
        $year = $this->input->post('report_year_sal');
        $this->load->model('log_model');
        $result = $this->processdb->new_to_regular_process($year, $month);
        if ($result == "Successfully Converted") {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Successfully Converted');</SCRIPT>";
            //echo "This ISBN already exist";
        } else if ($result == "no data found") {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('No data found');</SCRIPT>";
            //echo "This ISBN already exist";
        }

        $this->log_model->log_new_to_regular($year, $month);
        $this->new_to_regular();
    }

    public function pf_bank_interest()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('pr_pf_bank_interests');
        $crud->set_subject('PF Bank Interest Rate');
        $crud->required_fields('month', 'bank_interest_rate');
        $output = $crud->render();
        $this->crud_output($output);
    }
    //-------------------------------------------------------------------------------------------------------
    // CRUD for Others Deduction and Tax
    //-------------------------------------------------------------------------------------------------------
    public function tax_others_deduction(){
        $this->load->model('crud_model');
        $pr_deduct = $this->crud_model->taxnother_infos();
        $this->data = array();
        $this->data['user_data'] = $this->session->userdata('data');
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['pr_deduct'] = $pr_deduct;
        $this->data['subview'] = 'taxnother_list';
        $this->load->view('layout/template', $this->data);
    }

    public function deduct_month_check($str){
        $id = $this->uri->segment(4);
        $emp_id = $_POST['emp_id'];
        $year_month = date('Y-m', strtotime($str));
        if (!empty($id) && is_numeric($id)) {
            $ab_rule_name_old = $this->db->where("emp_id", $emp_id)->like("deduct_month", $year_month)->get('pr_deduct')->row()->deduct_month;
            $this->db->where("ab_rule_name !=", $ab_rule_name_old);
        }
        $num_row = $this->db->where("emp_id", $emp_id)->like('deduct_month', $year_month)->get('pr_deduct')->num_rows();
        if ($num_row >= 1) {
            $this->form_validation->set_message('deduct_month_check', 'Failed! This Entry already exists');
            return false;
        } else {
            return true;
        }
    }
    public function employee_id_check($str){
        $unit_id_select = $_POST['unit_id'];
        $emp_num_rows = $this->db->where("emp_id", $str)->get('pr_emp_com_info')->num_rows();
        if ($emp_num_rows > 0) {
            $unit_id = $this->db->where("emp_id", $str)->get('pr_emp_com_info')->row()->unit_id;
            if ($unit_id != $unit_id_select) {
                $this->form_validation->set_message('employee_id_check', 'Access Denied !');
                return false;
            }
            return true;
        } else {
            $this->form_validation->set_message('employee_id_check', 'Employee ID not exists !');
            return false;
        }
    }

    public function proximity_card_edit($start = 0)
    {

        $this->load->library('pagination');
        $param = array();
        // $start = ($this->uri->segment(2)) ? ($this->uri->segment(2)+1) : 0 ;
        // print_r($start);exit('ali');
        $limit = 25;
        $config['base_url'] = base_url() . "entry_system_con/proximity_card_edit/";
        $config['per_page'] = $limit;
        /*$config['num_links'] = 5;*/
        $config['total_rows'] = $this->db->get('pr_id_proxi')->num_rows();
        $config["uri_segment"] = 3;

        // Config setup

        // print_r($config);exit('ali');
        $this->pagination->initialize($config);
        $param['links'] = $this->pagination->create_links();
        $this->load->model('crud_model');
        $pr_id_proxi = $this->crud_model->proxi_infos($limit, $start);

        $param['pr_id_proxi'] = $pr_id_proxi;
        // print_r($param);exit('ali');
        $this->load->view('proxi_card_list', $param);
    }

    public function proxi_id_month_check($str)
    {
        $id = $this->uri->segment(4);
        $emp_id = $_POST['emp_id'];

        $get_session_user_unit = $this->Common_model->get_session_unit_id_name();
        $unit_id = $this->db->where("emp_id", $emp_id)->get('pr_emp_com_info')->row()->unit_id;

        if ($get_session_user_unit == 0) {
            return true;

        }
        if ($unit_id != $get_session_user_unit) {
            $this->form_validation->set_message('proxi_id_month_check', 'Failed! Access Deny!');
            return false;
        } else {
            return true;
        }
    }

    public function stop_salary_update($post_array, $primary_key)
    {
        $this->db->where('id', $primary_key);
        $user = $this->db->get('pr_emp_stop_salary')->row();

        $emp_id = $user->emp_id;
        $salary_month = $user->salary_month;
        $unit_id = $user->unit_id;
        $salary_month = date("Y-m", strtotime($salary_month));

        $data['stop_salary'] = 2;
        $this->db->where('emp_id', $emp_id);
        $this->db->like('salary_month', $salary_month);
        $this->db->update('pr_pay_scale_sheet', $data);

        $this->db->where('emp_id', $emp_id);
        $this->db->like('salary_month', $salary_month);
        $this->db->update('pr_pay_scale_sheet_com', $data);

        return true;
    }

    public function stop_salary_before_delete($primary_key)
    {
        $this->db->where('id', $primary_key);
        $user = $this->db->get('pr_emp_stop_salary')->row();

        $emp_id = $user->emp_id;
        $salary_month = $user->salary_month;
        $unit_id = $user->unit_id;
        $salary_month = date("Y-m", strtotime($salary_month));

        $num_row = $this->db->like('block_month', $salary_month)->where('unit_id', $unit_id)->get('pr_salary_block')->num_rows();

        if ($num_row > 0) {
            return false; //"FAILED - This Month Already Finally Processed.";
        }

        $data['stop_salary'] = 1;
        $this->db->where('emp_id', $emp_id);
        $this->db->like('salary_month', $salary_month);
        $this->db->update('pr_pay_scale_sheet', $data);

        $this->db->where('emp_id', $emp_id);
        $this->db->like('salary_month', $salary_month);
        $this->db->update('pr_pay_scale_sheet_com', $data);

        return true;
    }

    public function stop_salary_month_check($str)
    {
        $date = str_replace('/', '-', $str);
        $salary_month = date('Y-m-d', strtotime($date));

        $emp_id = $_POST['emp_id'];

        $get_session_user_unit = $this->Common_model->get_session_unit_id_name();
        $unit_id = $this->db->where("emp_id", $emp_id)->get('pr_emp_com_info')->row()->unit_id;

        if ($unit_id != $get_session_user_unit) {
            $this->form_validation->set_message('stop_salary_month_check', 'Failed! Access Deny!');
            return false;
        }
        $salary_month = date("Y-m", strtotime($salary_month));
        $num_rows = $this->db->where("emp_id", $emp_id)->like("salary_month", $salary_month)->get('pr_emp_stop_salary')->num_rows();
        if ($num_rows > 0) {
            $this->form_validation->set_message('stop_salary_month_check', 'Duplicate Entry Not Allow!');
            return false;
        }

        $unit_id = $_POST['unit_id'];
        $num_row_block_month = $this->db->like('block_month', $salary_month)->where('unit_id', $unit_id)->get('pr_salary_block')->num_rows();

        if ($num_row_block_month > 0) {
            $this->form_validation->set_message('stop_salary_month_check', 'FAILED - This Month Already Finally Processed.');
            return false;
        }

        $num_row_salary_create = $this->db->like('emp_id', $emp_id)->like('salary_month', $salary_month)->get('pr_pay_scale_sheet')->num_rows();
        if ($num_row_salary_create < 1) {
            $this->form_validation->set_message('stop_salary_month_check', 'FAILED - Salary For This Month Does Not Processed.');
            return false;
        }

        return true;

    }

}




<?php
class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();

		set_time_limit(0);
		ini_set("memory_limit","512M");

		if($this->session->userdata('logged_in')==FALSE)
		{
			redirect("authentication");
		}
		$this->load->model('Mars_model');

		$this->data['user_data'] = $this->session->userdata('data');
	}

	function get_dashboard_data(){
		$return_data=array();
		$report_date = date("Y-m-d");
		$return_data = $this->Mars_model->dashboard_summary($report_date, $this->session->userdata('data')->unit_name);
		echo json_encode($return_data);
	}

	function get_bar_chart_data(){
        $data = $this->get_last_12_month_summary();
        echo json_encode($data);
	}

    public function get_last_12_month_summary()
    {
        // 🔹 Last completed month
        $endMonth = date('Y-m-01', strtotime('first day of last month'));
        // 🔹 Start month (11 months before last completed month)
        $startMonth = date('Y-m-01', strtotime('-11 months', strtotime($endMonth)));

        // Step 1: Prepare months
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $key = date('Y-m', strtotime("+$i months", strtotime($startMonth)));
            $months[$key] = [
                'salary'    => 0,
                'ot'        => 0,
                'allowance' => 0
            ];
        }

        // Step 2: Query
        $this->db->select("
            DATE_FORMAT(salary_month, '%Y-%m') AS ym,
            SUM(net_pay) AS salary,
            SUM(IFNULL(ot_amount,0) + IFNULL(eot_amount,0)) AS ot,
            SUM(
                IFNULL(total_allaw,0)
                + IFNULL(att_bonus,0)
                + IFNULL(festival_bonus,0)
            ) AS allowance
        ", false);

        $this->db->from('pay_salary_sheet');
        $this->db->where('salary_month >=', $startMonth);
        $this->db->where('salary_month <=', $endMonth);
        $this->db->group_by('ym');
        $this->db->order_by('ym', 'ASC');

        $query = $this->db->get()->result();

        foreach ($query as $row) {
            if (isset($months[$row->ym])) {
                $months[$row->ym]['salary']    = (float)$row->salary;
                $months[$row->ym]['ot']        = (float)$row->ot;
                $months[$row->ym]['allowance'] = (float)$row->allowance;
            }
        }

        return [
            'labels'    => array_keys($months),
            'salary'    => array_values(array_column($months, 'salary')),
            'ot'        => array_values(array_column($months, 'ot')),
            'allowance' => array_values(array_column($months, 'allowance'))
        ];
    }
}

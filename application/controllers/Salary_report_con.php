<?php
class Salary_report_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
		$this->load->model('Grid_model');
		$this->load->model('Leave_model');
		$this->load->model('Acl_model');
		$this->load->model('Salary_process_model');
		// $access_level = 8;
		// $acl = $this->Acl_model->acl_check($access_level);
	}

	function grid_salary_report()
	{
		$this->load->view('grid_salary_report');
	}

	// ==================  compliance salary report generate  ======================
	function salary_sheet_com($type = null)
	{
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
		// dd($_POST);

		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->salary_sheet_com($salary_month, $stop_salary, $grid_emp_id, $unit_id);
		//  dd($data["value"]);
		$data["salary_month"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/salary_sheet_com', $data);
	}

	function pay_slip_com()
	{
        $salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));

		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["values"] = $this->Grid_model->salary_sheet_com($salary_month, $stop_salary, $grid_emp_id, $unit_id);
		// dd($data["values"]);
		$data["salary_month"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/pay_slip_com', $data);

	}
	function salary_summary_com(){
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
		//$data["values"] = $this->Grid_model->summary_report_com($salary_month, $stop_salary, $grid_emp_id, $unit_id);
		$data["values"] = $this->Grid_model->salary_summary($salary_month,$status,$unit_id,$stop_salary);
		//dd($data["values"]);

		// dd($data["values"]);
		$data["salary_month"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/salary_summary_com',$data);
	}

	function eot_sheet_com_9(){
        $first_date   = date('Y-m-01', strtotime($this->input->post('salary_month')));
        // $second_date  = date('Y-m-t', strtotime($this->input->post('salary_month')));

		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$second_date  = date('Y-m-t', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
		$stop_salary  = $this->input->post('stop_salary');
		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);
		$data["values"] = $this->Grid_model->actual_salary_sheet($salary_month, $stop_salary, $grid_emp_id, $unit_id,1);
		// $data["values"] = $this->Grid_model->get_emp_info($grid_emp_id,$first_date);
		// dd($data["values"]);
		$data["salary_month"] = $first_date;
		$data["second_date"] = $second_date;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/eot_sheet_com_9', $data);
	}
	function eot_sheet_com_12()
	{
        $first_date   = date('Y-m-01', strtotime($this->input->post('salary_month')));
        // $second_date  = date('Y-m-t', strtotime($this->input->post('salary_month')));
		// $unit_id 	  = $this->input->post('unit_id');
		// $status 	  = $this->input->post('status');
		// $sql 		  = $this->input->post('sql');
		// $grid_emp_id  = explode(',', trim($sql));

		// $this->load->model('Common_model');
		// $data["deduct_status"]= $this->Common_model->get_setup_attributes(1);
		// $data["values"] = $this->Grid_model->get_emp_info($grid_emp_id,$first_date);


		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$second_date  = date('Y-m-t', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
		$stop_salary  = $this->input->post('stop_salary');
		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);
		$data["values"] = $this->Grid_model->actual_salary_sheet($salary_month, $stop_salary, $grid_emp_id, $unit_id,1);
		// dd($data);
		$data["salary_month"] = $first_date;
		$data["second_date"] = $second_date;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/eot_sheet_com_12', $data);
	}
	function eot_sheet_com_all()
	{
        $first_date   = date('Y-m-01', strtotime($this->input->post('salary_month')));
        // $second_date  = date('Y-m-t', strtotime($this->input->post('salary_month')));
		// $unit_id 	  = $this->input->post('unit_id');
		// $status 	  = $this->input->post('status');
		// $sql 		  = $this->input->post('sql');
		// $grid_emp_id  = explode(',', trim($sql));

		// $this->load->model('Common_model');
		// $data["deduct_status"]= $this->Common_model->get_setup_attributes(1);
		// $data["values"] = $this->Grid_model->get_emp_info($grid_emp_id,$first_date);
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$second_date  = date('Y-m-t', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
		$stop_salary  = $this->input->post('stop_salary');
		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);
		$data["values"] = $this->Grid_model->actual_salary_sheet($salary_month, $stop_salary, $grid_emp_id, $unit_id,1);
		$data["salary_month"] = $first_date;
		$data["second_date"] = $second_date;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/eot_sheet_com_all', $data);
	}

	function sec_sal_summary_com()
	{
		$salary_month 	= $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('status');
		//dd($grid_status);
		$grid_unit 	= $this->input->post('unit_id');
		$stop_salary 	= $this->input->post('stop_salary');
		$data["values"] = $this->Grid_model->sec_salary_summary($salary_month,$grid_status,$grid_unit,$stop_salary);
		//dd($data["values"]);
		$data["salary_month"] 	= $salary_month;
		$data["unit_id"] 		= $grid_unit;
		$data["grid_status"] 	= $grid_status;

		$this->load->view('salary_report/sec_sal_summary_com',$data);
	}
	// ==================  compliance salary report generate  ======================

	// ================== actual salary report generate  ======================
	function actual_salary_sheet($type = null){
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));

		$data["deduct_status"]= $this->common_model->get_setup_attributes(1);
		$data["value"] = $this->Grid_model->actual_salary_sheet($salary_month, $stop_salary, $grid_emp_id, $unit_id);
		// dd($data);
		$data["salary_month"] = $salary_month;
		$data["custom_salarydate"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;  //grid_monthly_eot_sheet  eot_summary_report()
		$data["unit_id"]      = $unit_id;
		$this->load->view('salary_report/actual_salary_sheet', $data);
	}
	function actual_pay_slip()
	{
        $salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));

		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["values"] = $this->Grid_model->actual_salary_sheet($salary_month, $stop_salary, $grid_emp_id, $unit_id);
		// dd($data["values"]);
		$data["salary_month"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/actual_pay_slip', $data);

	}
	function actual_salary_summary(){
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
		// dd($unit_id);
		$data["values"] = $this->Grid_model->actual_summary_report($salary_month,$unit_id, $stop_salary );
		// dd($data["values"]);
		$data["salary_month"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/actual_salary_summary',$data);
	}
	function actual_sec_sal_summary()
	{
		$salary_month 	= $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_unit 	= $this->input->post('unit_id');
		$stop_salary 	= $this->input->post('stop_salary');

		$data["values"] = $this->Grid_model->sec_salary_summary($salary_month,$grid_status,$grid_unit,$stop_salary);
		$data["salary_month"] 	= $salary_month;
		$data["unit_id"] 		= $grid_unit;
		$data["grid_status"] 	= $grid_status;

		$this->load->view('salary_report/actual_sec_sal_summary',$data);
	}

	function actual_eot_sheet($type = null){
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$second_date  = date('Y-m-t', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
    	$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["values"] = $this->Grid_model->actual_salary_sheet($salary_month, $stop_salary, $grid_emp_id, $unit_id,1);

		$data["salary_month"] = $salary_month;
		$data["second_date"]  = $second_date;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/actual_eot_sheet', $data);
	}
	function actual_eot_summary($type = null){
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$status	      = $this->input->post('status');
		// dd($_POST);

		$data["values"] = $this->Grid_model->actual_summary_report($salary_month, $unit_id,1);

		$data["salary_month"] = $salary_month;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/actual_eot_summary',$data);
		// $this->load->view('eot_summary',$data);
	}
	function actual_salary_sheet_bank($type = null){
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
    	$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->actual_salary_sheet($salary_month, $stop_salary, $grid_emp_id, $unit_id);

		$data["salary_month"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/actual_salary_sheet_bank', $data);
	}
	function actual_eot_sheet_bank($type = null){
		$salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));
    	$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->actual_salary_sheet($salary_month, $stop_salary, $grid_emp_id, $unit_id);

		$data["salary_month"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;

		$this->load->view('salary_report/actual_eot_sheet_bank', $data);
	}

	function grid_monthly_stop_sheet(){
		$sal_year_month = $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('status');
		$grid_unit		= $this->input->post('unit_id');
		$grid_data 		= $this->input->post('spl');
		$grid_emp_id 	= explode(',', trim($grid_data));
		$this->load->model('Common_model');

		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);
		$data["value"] = $this->Grid_model->grid_monthly_stop_sheet($sal_year_month, $grid_status, $grid_emp_id);
		if($data["value"]=="Requested List Is Empty")
		{
			echo $data["value"];
		}
		else{
			$data["salary_month"] = $sal_year_month;
			$data["grid_status"]  = $grid_status;
			$data["unit_id"]  = $grid_unit;

			$this->load->view('stop_salary_sheet',$data);
		}
	}
	// ================== actual salary report generate  ======================
	function grid_comprative_salary_statement(){

		$first_year     = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$second_month      = date('Y-m-01', strtotime($this->input->post('second_month')));
		$grid_status 	= $this->input->post('status');
		$grid_unit   	= $this->input->post('unit_id');
		$stop_salary 	= null;

		// $data["values"] = $this->Grid_model->grid_comprative_salary_statement($first_year,$second_month,$grid_status,$grid_unit,$stop_salary);
		$data["results"]  = $this->Grid_model->actual_summary_report($first_year,$grid_unit, null);
		$data["results1"] = $this->Grid_model->actual_summary_report($second_month,$grid_unit, null);

		$data["first_month"] = date('F-Y', strtotime($first_year));
		$data["second_month"] = date('F-Y', strtotime($second_month));
		$data["unit_id"] = $grid_unit;
		$data["grid_status"] = $grid_status;

		$this->load->view('comprative_salary_statement_summary',$data);
	}

	function grid_salary_sheet_with_eot_bank()
	{
		$grid_data 		= $this->input->post('sql');//$this->uri->segment(5);
		$grid_emp_id    = explode(',', trim($grid_data));
		$salary_month   = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$status 		= $this->input->post('status');
		$unit_id   		= $this->input->post('unit_id');

		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_salary_sheet_with_eot_bank($salary_month, $status, $grid_emp_id);
		$data["salary_month"] = $salary_month;
		$data["grid_status"]  = $status;
		$data["unit_id"]  = $unit_id;

		$this->load->view('salary_sheet_actual_with_eot',$data);
	}
	function grid_monthly_allowance_sheet()
	{
		$grid_data 		= $this->input->post('sql');//$this->uri->segment(5);
		$grid_emp_id    = explode(',', trim($grid_data));
		$salary_month   = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$status 		= $this->input->post('status');
		$unit_id   		= $this->input->post('unit_id');

		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet_for_allowance($salary_month, $status, $grid_emp_id);
		$data["salary_month"] = $salary_month;
		$data["grid_status"]  = $status;
		$data["unit_id"]  	  = $unit_id;

		$this->load->view('salary_sheet_for_allowance',$data);
	}

















	// =======================================================
		// old code
	// =======================================================
	function grid_actual_monthly_salary_sheet_excel()
	{
		$sal_year_month = $this->input->post('salary_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_data 		= $this->input->post('grid_emp_id');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_unit		= $this->input->post('unit_id');
		$this->load->model('Common_model');

		$data["value"] = $this->Grid_model->grid_actual_monthly_salary_sheet($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_emp_id"] = $grid_emp_id;
		$data["grid_status"]  = $grid_status;
		$data["unit_id"]  = $grid_unit;

		$this->load->view('grid_actual_monthly_salary_sheet_excel', $data);
	}


	function grid_monthly_salary_sheet()
	{
		// exit('ali');
		$sal_year_month = $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');//$this->uri->segment(4);
		$grid_data 		= $this->input->post('spl');//$this->uri->segment(5);
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_unit		= $this->input->post('unit_id');
		$this->load->model('Common_model');
		//print_r($grid_emp_id);
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet_com($sal_year_month, $grid_status, $grid_emp_id);
		$data["grid_emp_id"] = $grid_emp_id;
		$data["salary_month"] = $sal_year_month;
		$data["grid_status"]  = $grid_status;
		$data["unit_id"]  = $grid_unit;

		$this->load->view('salary_sheet',$data);
	}

	function grid_monthly_salary_sheet_xl()
	{
		$sal_year_month = $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');//$this->uri->segment(4);
		$grid_data 		= $this->input->post('grid_emp_id');//$this->uri->segment(5);
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_unit		= $this->input->post('unit_id');
		$this->load->model('Common_model');
		//print_r($grid_emp_id);
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet_com($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_status"]  = $grid_status;
		$data["unit_id"]  = $grid_unit;

		$this->load->view('salary_sheet_xl',$data);
	}

	function grid_mix_salary_sheet()
	{
		$sal_year_month = $this->input->post('sal_year_month');
		$custom_salarydate = $this->input->post('custom_salarydate');
		$grid_status 	= $this->input->post('grid_status');
		$grid_data 		= $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_unit		= $this->input->post('unit_id');
		$this->load->model('Common_model');
		//print_r($grid_emp_id);
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_mix_salary_sheet($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_emp_id"] = $grid_emp_id;
		$data["grid_status"]  = $grid_status;
		$data["unit_id"]  = $grid_unit;
		$data["custom_salarydate"]  = $custom_salarydate;

		$this->load->view('salary_sheet_mix_com_non_com',$data);
	}

	function grid_actual_monthly_salary_sheet_not_sec()
	{
		// echo "hi";exit;
		$sal_year_month = $this->input->post('sal_year_month');
		$custom_salarydate = $this->input->post('custom_salarydate');
		$grid_status 	= $this->input->post('grid_status');
		$grid_data 		= $this->input->post('spl');
		$salary_draw 	= $this->input->post('salary_draw');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_unit		= $this->input->post('unit_id');
		$this->load->model('Common_model');
		//print_r($grid_emp_id);
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet_all($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_emp_id"] = $grid_emp_id;
		$data["grid_status"]  = $grid_status;
		$data["unit_id"]  = $grid_unit;
		$data["custom_salarydate"]  = $custom_salarydate;

		$this->load->view('salary_sheet_actual_all',$data);
	}

	function grid_actual_monthly_salary_sheet_with_eot_xl()
	{
		$sal_year_month = $this->input->post('sal_year_month');
		$custom_salarydate = $this->input->post('custom_salarydate');
		$grid_status = $this->input->post('grid_status');
		$grid_data 		= $this->input->post('grid_emp_id');
		$grid_emp_id = explode(',', trim($grid_data));
		//$grid_unit = $this->input->post('unit_id');
		$this->load->model('Common_model');
		//print_r($grid_emp_id);exit;
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_emp_id"] = $grid_emp_id;
		$data["grid_status"]  = $grid_status;
		//$data["unit_id"]  = $grid_unit;
		$data["custom_salarydate"]  = $custom_salarydate;

		//$this->load->view('salary_sheet_actual',$data);
		$this->load->view('salary_sheet_actual_with_eot_new_xl',$data);
	}


	function  grid_monthly_allowance_with_eot()
	{
		$sal_year_month = $this->uri->segment(3);
		$grid_status 	= $this->uri->segment(4);
		$grid_data 		= $this->uri->segment(5);
		$grid_emp_id = explode(',', trim($grid_data));
		$this->load->model('Common_model');
		//print_r($grid_emp_id);
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_status"]  = $grid_status;

		$this->load->view('monthly_allowance_with_eot',$data);
	}

	function grid_bank_note_requisition(){
		$sal_year_month 	= $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_unit 		= $this->input->post('unit_id');
		$grid_data 		= $this->input->post('spl');
		$grid_emp_id 	= explode(',', trim($grid_data));
		$this->load->model('Common_model');
		//print_r($grid_emp_id);
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] 	= $sal_year_month;
		$data["grid_status"]  	= $grid_status;
		$data["unit_id"]  		= $grid_unit;

		$this->load->view('bank_note_requisition',$data);
	}
	function grid_festival_bonus(){
		$this->load->model('Common_model');
		$year_month  	 = $this->input->post('sal_year_month');
		$status 	 	 = $this->input->post('status');
		$grid_unit 		 = $this->input->post('unit_id');
		$grid_data 		 = $this->input->post('spl');
		$emp_ids 	 	 = explode(',', trim($grid_data));

		$data["deduct_status"]	= $this->Common_model->get_setup_attributes(1);
		$data["value"] 			= $this->Grid_model->grid_festival_bonus($year_month, $status, $emp_ids);
		// dd($data["value"]);

		$data["salary_month"] 	= $year_month;
		$data["grid_status"]  	= $status;
		$data["unit_id"]  		= $grid_unit;
		$this->load->view('festival_bonus_report',$data);
	}

	function advance_salary_report(){
		$unit_id 		= $this->input->post('unit_id');
		$emp_id 		= $this->input->post('emp_id');
		$salary_month 	= date('Y-m-d', strtotime($this->input->post('salary_month')));
		$emp_ids 		= explode(',', trim($emp_id));

		$data["value"]   = $this->Grid_model->grid_general_info_another_format($emp_ids);
		$data["salary_month"] = $salary_month;
		$data["unit_id"] = $unit_id;
		//dd($data);
		$this->load->view('salary_report/advance_salary_report',$data);
	}

	function grid_advance_salary_sheet(){
		$sal_year_month = $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_unit 		= $this->input->post('unit_id');
		$grid_data 		= $this->input->post('spl');
		$grid_emp_id 	= explode(',', trim($grid_data));
		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);
		$data["value"]        = $this->Grid_model->grid_general_info_another_format($grid_emp_id);
		// dd($data);
		$firstDate = date('Y-m-01', strtotime($sal_year_month));
		$lastDate = date('Y-m-d');
		$data["first_date"] = $firstDate;
		$data["last_date"] = $lastDate;
		//$data["grid_section"]  = $grid_section;
		$data["unit_id"]  	= $grid_unit;
		$data['grid_status'] = $grid_status;
		//dd($data);
		$this->load->view('advance_salary_sheet_report_compliance',$data);
	}

	function get_deduct_status()
	{
		$this->db->select('deduct_status');
		$this->db->where("id",1);
		$query_ded = $this->db->get('pr_deduct_status');
		$rows_deduct = $query_ded->row();
		$deduct_status = $rows_deduct ->deduct_status;
		return $deduct_status;
	}

	function salary_summary_compliance(){

		$salary_month 	= $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_unit 	= $this->input->post('unit_id');
		$stop_salary 	= $this->input->post('stop_salary');
		// echo "";exit;
		$data["values"] = $this->Grid_model->salary_summary_test($salary_month,$grid_status,$grid_unit,$stop_salary);
		$data["salary_month"]  = $salary_month;
		$data["unit_id"] 	   = $grid_unit;
		$data["grid_status"]   = $grid_status;

		$this->load->view('salary_summary_report_com', $data);
	}

	function salary_summary_test(){

		$salary_month 	= $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_unit 	= $this->input->post('unit_id');
		$stop_salary 	= $this->input->post('stop_salary');
		// echo "";exit;
		$data["values"] = $this->Grid_model->salary_summary_test($salary_month,$grid_status,$grid_unit,$stop_salary);
		$data["salary_month"]  = $salary_month;
		$data["unit_id"] 	   = $grid_unit;
		$data["grid_status"]   = $grid_status;

		$this->load->view('salary_summary_report_actual', $data);
	}

	function grid_festival_bonus_summary(){
		$salary_month 	= $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('status');
		// dd($grid_status);
		$grid_unit 	= $this->input->post('unit_id');
		$data["values"] = $this->Grid_model->festival_bonus_summary($salary_month,$grid_status,$grid_unit);
		$data["salary_month"] = $salary_month;
		$data["unit_id"] = $grid_unit;
		$data["grid_status"] = $grid_status;
		//print_r($data);
		$this->load->view('festival_bonus_summary',$data);
	}
	function grid_festival_bonus_summary_sec_wise(){

		$salary_month = $this->input->post('sal_year_month');
		$status 	  = $this->input->post('status');
		$unit 		  = $this->input->post('unit_id');

		$data["values"] = $this->Grid_model->festival_bonus_summary_sec_wise($salary_month,$status,$unit);
		$data["salary_month"] = $salary_month;
		$data["unit_id"] = $status;
		$data["grid_status"] = $status;

		$this->load->view('festival_bonus_summary_sec_wise',$data);
	}


	function act_advance_salary_sheet(){
		$sal_year_month = $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('unit_id');//$this->uri->segment(4);
		$grid_data 		= $this->input->post('sql');//$this->uri->segment(5);
		$grid_emp_id    = explode(',', trim($grid_data));
		$grid_unit		= $this->input->post('unit_id');
		$this->load->model('common_model');
		//print_r($grid_emp_id);
		$name = $this->session->userdata('username');
		$user_check = $this->db->where('id_number', $name)->get('members')->row();
		// if ($user_check->id_number == 'honey' && $user_check->unit_name == 4 && strtotime(date('2023-11-30')) >= strtotime($sal_year_month)) {
		// 	echo 'Sorry!, data not found';
		// 	return;
		// }

		$data["deduct_status"]= $this->common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->act_advance_salary_sheet($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_status"]  = $grid_status;
		$data["unit_id"]  = $grid_unit;
		// dd($data);

		$this->load->view('act_advance_salary_sheet',$data);
	}


	function eot_summary_report_sec()
	{
		//$salary_month = $this->uri->segment(3);
		//$grid_status = $this->uri->segment(4);
		//$grid_unit = $this->uri->segment(5);
		$salary_month 	= $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_unit 	= $this->input->post('unit_id');
		$stop_salary 	= $this->input->post('stop_salary');
		$data["values"] = $this->Grid_model->eot_summary_report_sec($salary_month,$grid_status,$grid_unit,$stop_salary);
		$data["salary_month"] = $salary_month;
		$data["grid_status"] = $grid_status;
		$data["unit_id"] = $grid_unit;
		//print_r($data);
		$this->load->view('eot_summary_sec',$data);
	}
	function grid_pay_slip()
	{
        $salary_month = date('Y-m-01', strtotime($this->input->post('salary_month')));
		$unit_id 	  = $this->input->post('unit_id');
		$grid_unit	  = $this->input->post('grid_unit');
		$stop_salary  = $this->input->post('stop_salary');
		$status 	  = $this->input->post('status');
		$sql 		  = $this->input->post('sql');
		$grid_emp_id  = explode(',', trim($sql));

		$this->load->model('Common_model');
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["values"] = $this->Grid_model->salary_sheet_com($salary_month, $stop_salary, $grid_emp_id, $unit_id);
		// dd($data["values"]);
		$data["salary_month"] = $salary_month;
		$data["grid_emp_id"]  = $grid_emp_id;
		$data["grid_status"]  = $status;
		$data["unit_id"]      = $unit_id;


		// if(is_string($data['values']))
		// {
		// 	echo $data['values'];
		// }
		// else
		// {
			$this->load->view('pay_slip',$data);
		// }
	}

	function grid_pay_slip_com()
	{
		$grid_firstdate = $this->input->post('year_month');
		$grid_data = $this->input->post('spl');
		$grid_unit = $this->input->post('unit_id');
		$grid_emp_id = explode(',', trim($grid_data));

		$year_month = date("Y-m", strtotime($grid_firstdate));
		$query['unit_id'] = $grid_unit;
		$query['values'] = $this->Grid_model->grid_pay_slip($year_month, $grid_emp_id);
		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('grid_pay_slip_com',$query);
		}
	}

	function grid_pay_slip_actual(){
		$grid_firstdate = $this->input->post('year_month');
		$grid_data = $this->input->post('spl');
		$grid_unit = $this->input->post('unit_id');
		$grid_emp_id = explode(',', trim($grid_data));

		$year_month = date("Y-m", strtotime($grid_firstdate));
		$query['unit_id'] = $grid_unit;
		$query['values'] = $this->Grid_model->grid_pay_slip($year_month, $grid_emp_id);
		// echo "<pre>"; print_r($query['values']); die;
		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('grid_pay_slip_actual',$query);
		}
	}


	function grid_pay_slip_non_compliance()
	{
		$grid_firstdate = $this->input->post('year_month');//$this->uri->segment(3);
		$grid_data = $this->input->post('spl');
		$grid_unit = $this->input->post('unit_id');
		$grid_emp_id = explode(',', trim($grid_data));

		$year_month = date("Y-m", strtotime($grid_firstdate));
		$query['unit_id'] = $grid_unit;
		$query['values'] = $this->Grid_model->grid_pay_slip_non_compliance($year_month, $grid_emp_id);
		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('pay_slip_actual',$query);
		}
	}

	function grid_pay_slip_com_non_com_mix()
	{
		$grid_firstdate = $this->input->post('year_month');//$this->uri->segment(3);
		$grid_data = $this->input->post('spl');
		$grid_unit = $this->input->post('unit_id');
		$grid_emp_id = explode(',', trim($grid_data));

		$year_month = date("Y-m", strtotime($grid_firstdate));
		$query['unit_id'] = $grid_unit;
		$query['values'] = $this->Grid_model->grid_pay_slip_com_non_com_mix($year_month, $grid_emp_id);
		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('com_non_com_pay_slip',$query);
		}
	}


	function grid_provident_fund()
	{
		$this->load->model('Salary_process_model');
		$grid_firstdate = $this->uri->segment(3);
		$grid_data = $this->uri->segment(4);
		$grid_emp_id = explode(',', trim($grid_data));

		$year_month = date("Y-m", strtotime($grid_firstdate));
		$query["salary_month"] = $grid_firstdate;
		$query['values'] = $this->Grid_model->grid_provident_fund($year_month, $grid_emp_id);
		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('provident_fund',$query);
		}
	}

	function grid_earn_leave()
	{
		$sal_year_month = $this->uri->segment(3);
		$grid_status 	= $this->uri->segment(4);
		$grid_data 		= $this->uri->segment(5);
		$grid_emp_id = explode(',', trim($grid_data));
		$this->load->model('Common_model');
		//print_r($grid_emp_id);
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_earn_leave($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_status"]  = $grid_status;

		//$this->load->view('salary_sheet_actual_with_eot',$data);
	}



	function grid_monthly_weekend_allowance_sheet()
	{
		$sal_year_month = $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_data 		= $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_unit		= $this->input->post('unit_id');
		$this->load->model('Common_model');
		//print_r($grid_emp_id);
		$data["deduct_status"]= $this->Common_model->get_setup_attributes(1);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet_for_weeekend_allowance($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_status"]  = $grid_status;
		$data["unit_id"]  	= $grid_unit;

		$this->load->view('salary_sheet_for_weekend_allowance',$data);
	}

	// function office_start_time()
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('pr_emp_com_info');
	// 	$emp=$this->db->get()->row();


	// 	$table = 'att_2018_04';
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->where('trim(substr(date_time,1,10)) >=','2018-04-26');
	// 	$this->db->where('trim(substr(date_time,1,10)) <=','2018-04-30');
	// 	$this->db->order_by('trim(substr(date_time,1,10)) <=','2018-04-30');
	// 	$sql=$this->db->get()->row();

	// 	foreach ($sql as $item) {

	// 	}
	// 	echo '<pre>';
	// 	print_r($sql);

	// }


}


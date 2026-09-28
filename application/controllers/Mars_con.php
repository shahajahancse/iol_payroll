<?php
class Mars_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		/* Standard Libraries */
		$this->load->model('Mars_model');
		$this->load->model('Grid_model');
		$this->load->model('Acl_model');
		$access_level = 6;
		$acl = $this->Acl_model->acl_check($access_level);
		
	}

	function floor_sec_line_wise(){
		//araf
		$floor_id = 99;
		$sec_id = 24;
		$sec_arr = array(1,2,3,4,5,6,7,8,9,10,11,20,18,25,26,27);
		$line_id = 1;
		$line_arr = array(11,25,26,27,20,18,1,2,3,4,5,6,7,8,9,10);
		$cat_id = array(3,4);
		$this->db->select('emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where('floor_id', $floor_id);
		$this->db->where_in('emp_sec_id', $sec_arr);
		//$this->db->where('emp_sec_id', $sec_id);
		//$this->db->where('emp_line_id', $line_id);
		//$this->db->where_in('emp_line_id', $line_arr);
		$this->db->where_not_in('emp_cat_id',$cat_id);
		$query = $this->db->get();
		echo $query->num_rows();exit;
		foreach($query->result() as $rows)
		{
			echo $rows->emp_id.',';
		}
	}
	
	function others_report_front_end()
	{
		$this->load->view('others_report/others_report_front_end');
	}
	
	/*
	function daily_attendance_summary_test(){
		$report_date = $this->uri->segment(3);
		$report_date = date("Y-m-d", strtotime($report_date));
		
		$category = $this->uri->segment(4);
		$unit_id = $this->uri->segment(5);
		
		$data['values'] = $this->Mars_model->section_attendance_summary_test($report_date, $unit_id);
		
		$data['title'] 		 = 'Daily Attendance Summary';
		$data['report_date'] = $report_date;
		$data['category']    = $category;
		$data['unit_id']    = $unit_id;
		$this->load->view('others_report/attendance_summary_test', $data);
	}*/
	function daily_attendance_summary_test(){
		$report_date = $this->uri->segment(3);
		$report_date = date("Y-m-d", strtotime($report_date));
		
		$category = $this->uri->segment(4);
		$unit_id = $this->uri->segment(5);
		
		$data['values'] = $this->Mars_model->section_attendance_summary_test($report_date, $unit_id);
		$data['title'] 		 = 'Daily Attendance Summary';
		$data['report_date'] = $report_date;
		$data['category']    = $category;
		$data['unit_id']    = $unit_id;
		// echo "<pre>";
		// print_r($data['values']);exit;
		$this->load->view('others_report/attendance_summary_test', $data);
	}

	function daily_ot_summary(){
		$report_date = $this->uri->segment(3);
		$report_date = date("Y-m-d", strtotime($report_date));
		
		$category = $this->uri->segment(4);
		$unit_id = $this->uri->segment(5);
		
		$data['values'] = $this->Mars_model->section_ot_summary($report_date, $unit_id);
		$data['title'] 		 = 'Daily Attendance Summary';
		$data['report_date'] = $report_date;
		$data['category']    = $category;
		$data['unit_id']    = $unit_id;
		// echo "<pre>";
		// print_r($data['values']);exit;
		$this->load->view('others_report/daily_ot_summary', $data);
	}

	
	function daily_costing_summary()
	{
		$grid_date = $this->uri->segment(3);
		$grid_unit = $this->uri->segment(4);
		$data["values"] 	= $this->Grid_model->grid_daily_costing_report($grid_date,$grid_unit);	
		
		$data["grid_date"]	= $grid_date;
		$data["unit_id"]	= $grid_unit;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('others_report/daily_costing_summary',$data);
		}
		
	}
	
	
	
	
	function test()
	{
		$grid_date = "2012-04-07";
		list($year, $month, $date) = explode('-', trim($grid_date));
		
		$report_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		$this->Mars_model->department_attendance_summary($report_date);
	}
	
	/////////////////////daily_logout_report/////////////////
	function daily_logout_report(){
		$grid_date = $this->uri->segment(3);
		list($date, $month, $year) = explode('-', trim($grid_date));
		$report_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		
		$category = $this->uri->segment(4);
		$unit_id = $this->uri->segment(5);
	/*
		if($category =='Department')
		{
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('No data found'); window.location='others_report_front_end';</SCRIPT>";
		}
		elseif($category =='Section')
		{
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('No data found'); window.location='others_report_front_end';</SCRIPT>";
		}
		if($category =='Line')
		{
			data['values'] = $this->Mars_model->line_logout_summary($report_date, $unit_id);
		} 
		*/
		$data['title'] 		 = 'Daily Logout';
		$data['report_date'] = $report_date;
		$data['category']    = $category;
		$data['unit_id']    = $unit_id;
		
		$this->load->view('others_report/daily_logout', $data);
		
	}
	
	
}
?>

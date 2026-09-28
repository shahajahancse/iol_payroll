<?php

class Authentication extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 0);
	    set_time_limit(0);
		/* Standard Libraries */
		// $this->load->model('processdb');
		$this->load->helper('form');
		
	}
	
	
	function index()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		if($this->session->userdata('logged_in') == true)
		{
			if($this->session->userdata('level')== 2 || $this->session->userdata('level')==3)
			{
				$url = base_url()."magpie/";
				redirect($url);
			}
			else
			{
				redirect("payroll_con");
			}
		}
		else
		{
			$this->load->view('admin/login'); 
		}
	}
}
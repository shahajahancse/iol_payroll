<?php
// echo phpinfo();exit;

class Attn_process_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 0);
	    set_time_limit(0);
		/* Standard Libraries */
		// $this->load->library('Grocery_crud');
		$this->load->model('Attn_process_model');
		$this->load->model('Log_model');
		$this->load->model('Acl_model');
		$this->load->model('Common_model');

        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
        if (!check_acl_list($this->data['user_data']->id, 4)) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
            redirect("payroll_con");
            exit;
        }
	}


	//-------------------------------------------------------------------------------------------------------
	// Form display for Attendance Process
	//-------------------------------------------------------------------------------------------------------
	function attn_process_form()
	{
        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name)) {
	        $this->data['employees'] = $this->Common_model->get_emp_by_unit($this->data['user_data']->unit_name);
        }

        $this->data['username'] = $this->data['user_data']->id_number;
		$this->data['user_id'] = $this->data['user_data']->unit_name;
        $this->data['title'] = 'Attendance Process';
        $this->data['subview'] = 'attn_report/attn_process_form';
        $this->load->view('layout/template', $this->data);

	}

	function attendance_process(){

		$unit = $this->input->post('unit_id');
		$date = $this->input->post('process_date');
		$sql = $this->input->post('sql');

		$input_date = date("Y-m-d", strtotime($date));
		$grid_emp_id = explode(',', $sql);

		$this->db->trans_start();
		ini_set('memory_limit', '-1');
		set_time_limit(0);

		// final process check
		$slm = date("Y-m-01", strtotime($date));
		$check = $this->db->where('unit_id', $unit)->where('block_month',$slm)->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! This Month Already Final Processed";
			return false; exit();
		}
		// final process check end

		$data = $this->Attn_process_model->attn_process($input_date,$unit,$grid_emp_id);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo "Process failed";
		}else{
			$this->db->trans_commit();
			if($data == true){
				// ATTENDANCE PROCESS LOG Generate
				$this->Log_model->log_attn_process($input_date);
				echo "Process completed sucessfully";
			}else{
				echo "Process failed";
			}
		}
	}

	function attendance_process2(){

		$unit = $this->input->post('unit_id');
		$date1 = $this->input->post('process_date1');
		$date2 = $this->input->post('process_date2');
		$days = (strtotime($date2) - strtotime($date1)) / 86400 + 1;


		$sql = $this->input->post('sql');
		$grid_emp_id = explode(',', $sql);
		$this->db->trans_start();
		ini_set('memory_limit', '-1');
		set_time_limit(0);

		// final process check
		$slm = date("Y-m-01", strtotime($date1));
		$check = $this->db->where('unit_id', $unit)->where('block_month',$slm)->get('pay_salary_block');
		if ($check->num_rows() > 0) {
			echo "Sorry! This Month Already Final Processed";
			return false; exit();
		}
		// final process check end

		for ($i=0; $i < $days ; $i++) {
			$input_date = date("Y-m-d", strtotime($date1 . ' + ' . $i . ' days'));
			$data = $this->Attn_process_model->attn_process($input_date,$unit,$grid_emp_id);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo "Process failed";
		}else{
			$this->db->trans_commit();
			if($data == true){
				// ATTENDANCE PROCESS LOG Generate
				$this->Log_model->log_attn_process($input_date);
				echo "Process completed sucessfully";
			}else{
				echo "Process failed";
			}
		}
	}

	//-------------------------------------------------------------------------------------------------------
	// List display for file upload
	//-------------------------------------------------------------------------------------------------------
	function file_upload($start = 0)
	{
        $this->load->library('pagination');
        $limit = 10;
        $config['base_url'] = base_url() . "attn_process_con/file_upload/";
        $config['per_page'] = $limit;
        $condition = 0;

        $this->load->model('crud_model');
        $results = $this->crud_model->file_upload($limit, $start, $condition);
        $total = $this->db->query("SELECT FOUND_ROWS() as count")->row()->count;
        $config['total_rows'] = $total;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['results'] = $results;
        // dd($this->data['results']);

        $this->data['title'] = 'File Upload';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'attn_report/file_upload';
        $this->load->view('layout/template', $this->data);
	}

	// daily attendance file upload   19-11-2023 shahajahan
	function file_add()
	{
		// file upload

		if (!empty($_FILES['upload_file']['name'])) {
			$unit_id = $this->input->post('unit_id');
			$upload_date = date('Y-m-d', strtotime($this->input->post('upload_date')));
			$not_allow = date("Y-m-d",strtotime("-24 months"));

			// not permission to two years ago file upload
			if ($upload_date <= $not_allow && !empty($this->input->post('upload_date'))) {
				$this->session->set_flashdata('success', 'Sorry! Not Allowed');
				redirect(base_url('attn_process_con/file_upload'));
			}

			$check = $this->db->where('unit_id', $unit_id)->where('upload_date', $upload_date)
							->get('attn_file_upload')->num_rows();

			if ($check == 0) {
				$this->delete_attn_file_two_ago($not_allow, $unit_id); // delete 2 years ago data
				$file_name = $this->upload_attn_file($upload_date, $unit_id, $_FILES['upload_file']);
				$comData = array(
		            'file_name'   => $file_name,
		            'unit_id' 	  => $unit_id,
		            'upload_date' => $upload_date,
		            'status'      => 'Yes',
		        );
		        $this->db->insert('attn_file_upload',$comData);
				$this->file_process_for_attendance($upload_date, $unit_id);

				$this->session->set_flashdata('success', 'Successfully Insert Done');
				redirect(base_url('attn_process_con/file_upload'));
			} else {
				$this->session->set_flashdata('error', 'Sorry Already exist.');
			}
		}

        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
		$this->data['title'] = 'File Upload';
        $this->data['username'] = $this->data['user_data']->id_number;
        $this->data['subview'] = 'attn_report/file_add';
        $this->load->view('layout/template', $this->data);
	}

    // attendance file upload
    public function upload_attn_file($upload_date, $unit_id, $upload_file = array())
    {
		if($upload_file["name"] != ''){
            $config['upload_path'] = './data'; //'./data/';
            $config['allowed_types'] = 'txt';
			$config['file_name'] 	  =  $upload_date .'-'. $unit_id .'.txt';
            $config['max_size'] = '20000';
            $config['max_width']  = '10000';
            $config['max_height']  = '10000';

            $this->load->library('upload', $config);
			$this->upload->initialize($config);

            if ( ! $this->upload->do_upload('upload_file')){
                $error = array('error' => $this->upload->display_errors());
            }else{
                $data = array('upload_data' => $this->upload->data());
                return $upload_file = $data["upload_data"]["file_name"];
            }
        }
    }

	//machine row data (attendance file data) read and insert
	function file_process_for_attendance($upload_date, $unit_id){
		date_default_timezone_set('Asia/Dhaka');
		$this->db->select('file_name')->where('unit_id', $unit_id)->where('upload_date',$upload_date);
		$query = $this->db->get('attn_file_upload');

		// check attendance file exist or not
		if($query->num_rows() == 0){
			echo "Please upload attendance file.";
			return false;
			exit;
		}

		$rawfile_name = $query->row()->file_name;
		$file_name = "data/$rawfile_name";
		if (file_exists($file_name)){

			// check att_year_month table exist or not create the table
			$att_table = "att_". date("Y_m", strtotime($upload_date));
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


			// delete the att_year_month table (two years ago)
			$delete_table = "att_". date("Y_m",strtotime("-25 months", strtotime($upload_date)));
			if ($this->db->table_exists($delete_table)){
				$this->db->query('DROP TABLE `'.$delete_table.'`');
			}


			$lines = file($file_name);
			$out = array();
			$prox_no = $date = $time = $format = $device_id = $f = 0;
			foreach(array_values($lines)  as $line) {

				if (!empty(strlen(chop($line)))) {
					// list($prox_no, $date, $time, $format, $device_id, $f) = preg_split('/\s+/', trim($line));
					$prox_no = trim(substr(trim($line),0,7));
					$date = trim(substr(trim(substr(trim($line),7)),0,8));
					$time = trim(substr(trim(substr(trim(substr(trim($line),7)),8)),0,8));
					$format = trim(substr(trim(substr(trim(substr(trim($line),7)),8)),8));
					$device_id= 1;
					if ($prox_no == 'No.') {
						continue;
					}

					list($d,$m,$y) = explode('/', trim($date));
					$date_time = date("Y-m-d H:i:s", strtotime($y.'-'.$m.'-'.$d.' '.$time .' '.$format));

					$this->db->where("proxi_id", $prox_no);
					$this->db->where("date_time", $date_time);
					$query1 = $this->db->get($att_table);
					$num_rows1 = $query1->num_rows();
					if($num_rows1 == 0 ){
						$data = array(
									'device_id' => ($device_id == 0 || $device_id =='')? 33:$device_id,
									'proxi_id' 	=> $prox_no,
									'date_time'	=> $date_time
								);

						$this->db->insert($att_table , $data);

					}
				}
			}
			return true;
		}else{
			exit('Please Put the Data File.');
		}
	}

	// delete attn file
	public function delete_attn_file($id)
	{
		$path = realpath(APPPATH . '../data/');
		$row = $this->db->where('id', $id)->get('attn_file_upload')->row();
		if (!empty($row)) {
			$file_name = $path .'/'. $row->file_name;
			@unlink($file_name);
		}

		$this->db->where('id', $id);
        $this->db->delete('attn_file_upload');

        $this->session->set_flashdata('success', 'Successfully attendance file deleted');
	    redirect(base_url('attn_process_con/file_upload'));
	}

	// delete attn file
	public function delete_attn_file_two_ago($date, $unit_id)
	{
		$path = realpath(APPPATH . '../data/');
		$row = $this->db->where('unit_id', $unit_id)->where('upload_date', $date)->get('attn_file_upload')->row();

		if (!empty($row)) {
			$file_name = $path .'/'. $row->file_name;
			@unlink($file_name);
		}

		$this->db->where('unit_id', $unit_id)->where('upload_date', $date)->delete('attn_file_upload');
        return;
	}


	//-------------------------------------------------------------------------------------------------------
	// Attendance report start here
	//-------------------------------------------------------------------------------------------------------
	function grid_window(){
		 if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        if (!empty($this->data['user_data']->unit_name)) {
	        $this->data['employees'] = $this->Common_model->get_emp_by_unit($this->data['user_data']->unit_name);
        }

		if($this->session->userdata('level') == 0 || $this->session->userdata('level') == 1){
			$this->data['username'] = $this->data['user_data']->id_number;
			$this->data['unit_id']=$this->data['user_data']->unit_name;
			$this->data['title'] = 'Attendance Report';
			$this->data['subview'] = 'attn_report/grid_window';
			$this->load->view('layout/template', $this->data);
		} else if ($this->session->userdata('level') == 2){
			$this->data['username'] = $this->data['user_data']->id_number;
			$this->data['subview'] = 'grid_for_user';
			$this->load->view('layout/template', $this->data);
		}
	}

	//-------------------------------------------------------------------------------------------------------
	// Attendance report end
	//-------------------------------------------------------------------------------------------------------
	function alert_msg_list() {
		if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }

		$today = date('Y-m-d');
		$start_date = date('Y-m-d', strtotime('-2 days')); // 2 days back

		$this->db->select('
			mesg.id as msg_id,
			mesg.date,
			com.emp_id,
			per.name_en,
			line.line_name_en,
			deg.desig_name,
			mesg.msg
		');
		$this->db->from('emp_alert_message as mesg');

		// Join shift log on the **same date as message** and present_status = 'P'
		$this->db->join('(
			SELECT emp_id, shift_log_date
			FROM pr_emp_shift_log
			WHERE present_status = "P"
		) as log', 'mesg.emp_id = log.emp_id AND mesg.date = log.shift_log_date', 'inner');

		// Join employee info
		$this->db->join('pr_emp_com_info as com', 'com.emp_id = mesg.emp_id', 'left');
		$this->db->join('pr_emp_per_info as per', 'per.emp_id = mesg.emp_id', 'left');
		$this->db->join('emp_line_num as line', 'line.id = com.emp_line_id', 'left');
		$this->db->join('emp_designation as deg', 'deg.id = com.emp_desi_id', 'left');

		// Fetch messages from last 3 days
		$today = date('Y-m-d');
		$start_date = date('Y-m-d', strtotime('-2 days'));
		$this->db->where("mesg.date BETWEEN '$start_date' AND '$today'");

		$this->data['results'] = $this->db->order_by('mesg.date', 'desc')->get()->result();



		$this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();

		$this->data['username'] = $this->data['user_data']->id_number;
		$this->data['unit_id']=$this->data['user_data']->unit_name;
		$this->data['title'] = 'Alert List';
		$this->data['subview'] = 'attn_report/alert_ist';
		$this->load->view('layout/template', $this->data);
	}





	//-------------------------------------------------------------------------------------------------------
	// old code
	//-------------------------------------------------------------------------------------------------------
	// old code
	function auto_shift_change($input_date)
	{
		$this->load->model('Acl_model');
		$date 		= $input_date;
		//$emp_arr = array(000187,000317,000321,000186,000347,000552,000835,000846,002229,002551,002552,002686,002924,002923,003116,003128,004397);
		$emp_fixed_shift = array(15,16,17);
		$nameOfDay = date('D', strtotime($date));
		$udate =date("Y-m-d", strtotime($date));
		if($udate > date('Y-m-d')){
			echo 'Pleased select  6 days ago to today.';
			exit();
		}

		$pdate =date('Y-m-d', strtotime('-6 days'));
		/*if($udate < $pdate){
			echo 'Pleased select  6 days ago to today.';
			return ;
		}*/


		$per_data=date('Y-m-d', strtotime("$udate,-1 day"));

		$this->db->select('*');
		$this->db->from('pr_emp_shift_process');
		$this->db->where('date', $per_data);
		$process_date=$this->db->get()->num_rows();
		if($process_date>0){
			// continue();
		}
		else{
			echo "Process first the date: ". $per_data;
			exit();
		}

		$this->db->select('*');
		$this->db->from('pr_emp_weekend');
		$this->db->where('day', $nameOfDay);
		$offday_query=$this->db->get();
		foreach($offday_query->result() as $row_id) {
			$offday_id[]= $row_id->id;//1
		}

		$this->db->select('*');
		$this->db->from('pr_emp_shift_process');
		$this->db->where('date', $udate);
		$process_date=$this->db->get()->num_rows();

		if($process_date>0){
			//echo '<div id="report-danger" class="report-div danger" style="display: block;"><p>Alredy Shift Changed </p></div>';
		}
		else{
			//echo "yes";
			//echo $nameOfDay;exit;
			if($nameOfDay=='Fri'){
				//echo "no";
				$this->db->select('emp_id, emp_shift');
				$this->db->from('pr_emp_com_info');
				$this->db->where_in('pr_emp_com_info.emp_shift', $emp_fixed_shift);
				//$this->db->where_in('weekend', $offday_id);
				$offday=$this->db->get()->result();
				//echo $this->db->last_query();
				$i=0;
				foreach ($offday as $item) {
					$i=$i+1;

					$id=$item->emp_id;
					//echo $item->emp_shift
					if($item->emp_shift==15){
						$emp_shift=17;
					}
					if($item->emp_shift==17){
						$emp_shift=16;
					}
					if($item->emp_shift==16){
						$emp_shift=15;
					}

					$data=array(
						'emp_shift'=>$emp_shift
					);

					$this->db->where('emp_id', $id);
					$this->db->update('pr_emp_com_info', $data);

					/*if($i>0){
					$data=array(
						'date'=>$udate
					);
					$this->db->insert('pr_emp_shift_process', $data);
					}else{
					}*/
				}

				$data=array(
						'date'=>$udate
					);

				$this->db->insert('pr_emp_shift_process', $data);

			}else{
				$data=array(
					'date'=>$udate
				);
				$this->db->insert('pr_emp_shift_process', $data);
		}
	  }
	}

	function attn_process_month(){
		$access_level = 4;
		$acl = $this->Acl_model->acl_check($access_level);

		$unit = $this->input->post('unit_id');
		$date = $this->input->post('p_start_date');
		$spl = $this->input->post('spl');
		$input_date = date("Y-m-d", strtotime($date));
		$grid_emp_id = explode('xxx', $spl);
		// print_r($grid_emp_id);exit;
		$this->db->trans_start();
		ini_set('memory_limit', '-1M');
		set_time_limit(0);
		$Month_length = date('t',strtotime($input_date));
		$month_year = date('Y-m',strtotime($input_date));

		for($loop = 1;$loop <= $Month_length;$loop++)
		{
			$input_date = date('Y-m-d',strtotime($month_year.'-'.$loop));
			$data = $this->Attn_process_model->attn_process($input_date,$unit,$grid_emp_id);
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo "Process failed";
		}else{
			$this->db->trans_commit();
			if(is_array($data)){
				// ATTENDANCE PROCESS LOG Generate
				$this->Log_model->log_attn_process($input_date);
				echo "Process completed sucessfully";
			}else{
				echo $data;
			}
		}
	}

	function earn_leave_process($input_date)
	{
		$data = $this->Attn_process_model->earn_leave_process($input_date);
	}

	function deduction_hour_process($date)
	{
		$data = $this->Attn_process_model->deduction_hour_process($date);
	}

	function test()
	{
		$date1 = '2012-08-20';
		$date2 = date('Y-m-d');
		echo $days = $this->Attn_process_model->get_date_to_date_day_differance($date1,$date2);
	}
	function crud_output($output = null)
	{
		$this->load->view('output.php',$output);
	}


	function date_duplication_check_for_unit($upload_date)
	{
	   	$year 	= substr($upload_date,6,4);
		$month 	= substr($upload_date,3,2);
		$day 	= substr($upload_date,0,2);
		$upload_date = "$year-$month-$day";
		$unit = $_POST['unit_id'];

		$num_row = $this->db->where('upload_date',$upload_date)->where('unit_id',$unit)->get('pr_attn_file_upload')->num_rows();
		if ($num_row > 0)
		{
			$this->form_validation->set_message('date_duplication_check_for_unit', "Sorry! The Upload Date is already exist.");
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}

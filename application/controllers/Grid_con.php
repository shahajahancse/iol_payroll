<?php
class Grid_con extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 0);
	    set_time_limit(0);

        if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['user_data'] = $this->session->userdata('data');
        if (!check_acl_list($this->data['user_data']->id, 4)) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
            redirect("payroll_con");
            exit;
        }

		$this->load->model('Grid_model');
		$this->load->model('Common_model');
	}

	function daily_report(){
		$date = date('Y-m-d', strtotime($this->input->post('firstdate')));
		$unit_id = $this->input->post('unit_id');
		$grid_data = $this->input->post('emp_id');
		$type = $this->input->post('report_type');
		//dd($type);
		// dd($_POST);
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->grid_daily_report($date,$grid_emp_id,$type);
		//dd($data["values"]);

		$data["unit_id"] 		= $unit_id;
		$data['daily_status']   = $type;
		$data['date']   		= $date;
		$this->load->view('grid_con/daily_report',$data);
	}

	function daily_costing_summary(){
		$date 	= date("Y-m-d",strtotime($this->input->post('firstdate')));
		$unit_id = $this->input->post('unit_id');
		$status  = $this->input->post('status');
		$data["values"] 	= $this->Grid_model->daily_costing_summary($date,$unit_id);
		// dd($data["values"]);
		$data["grid_date"]	= $date;
		$data["unit_id"]	= $unit_id;
		$this->load->view('grid_con/daily_costing_summary',$data);
	}

	function daily_attendance_summary()
	{
		$date 	= date("Y-m-d",strtotime($this->input->post('firstdate')));
		$unit_id = $this->input->post('unit_id');
		$status  = $this->input->post('status');
		$type = $this->input->post('type');
		if ($type == 1) {
			$data['values'] = $this->Grid_model->daily_attendance_summary($date, $unit_id);
		} else {
			$data['values'] = $this->Grid_model->daily_attendance_summary1($date, $unit_id);
		}
		// dd($data);
		$data['title'] 		 = 'Daily Attendance Summary';
		$data['report_date'] = $date;
		$data['category']    = 'Line';
		$data['unit_id']    = $unit_id;
		$data['results']= $data['values']['results'];
		$data['keys']= $data['values']['keys'];

		$this->load->view('grid_con/daily_attendance_summary', $data);
	}

	function daily_logout_report(){
		$date 	= date("Y-m-d",strtotime($this->input->post('firstdate')));
		$unit_id = $this->input->post('unit_id');
		$status  = $this->input->post('status');
		$data['values'] = $this->Grid_model->daily_logout_report($date, $unit_id);
		$data['title'] 		 = 'Daily Logout Summary';
		$data['report_date'] = $date;
		$data['category']    = 'Line';
		$data['unit_id']    = $unit_id;
		// dd($data);
		$this->load->view('grid_con/daily_logout_report', $data);
		// $this->load->view('others_report/daily_logout', $data);
	}

	function grid_continuous_report(){
		$girstdate = date("Y-m-d",strtotime($this->input->post('firstdate')));
		$seconddate = date("Y-m-d",strtotime($this->input->post('seconddate')));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		if ($status == 'LA') {
			$data["values"] = $this->Grid_model->continuous_late_report($girstdate, $seconddate, $grid_emp_id);
		} else {
			$data["values"] = $this->Grid_model->continuous_report($girstdate, $seconddate, $status, $grid_emp_id);
		}
		// dd($data["values"]);

		if($status =="A")
		{
			$status = "Absent";
		}
		elseif($status =="P")
		{
			$status = "Present";
		}
		elseif($status =="L")
		{
			$status = "Leave";
		}
		elseif($status =="LA")
		{
			$status = "Late";
		}

		$data["status"] 	= $status;
		$data["start_date"] = $girstdate;
		$data["end_date"] 	= $seconddate;
		$data["unit_id"] 	= $unit_id;
		//print_r($data);
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_con/continuous_report',$data);
		}
	}

	function continuous_present_report_excel(){
		$hide_date = $this->input->post('hide_date');
		$hide_date2 = $this->input->post('hide_date2');
		$status = $this->input->post('hide_status');
		$unit_id = $this->input->post('hide_unit');
		$grid_data = $this->input->post('hide_emp');

		$emp_ids = explode(',', trim($grid_data));
		$hide_date = date("Y-m-d",strtotime($hide_date));
		$hide_date2 = date("Y-m-d",strtotime($hide_date2));

		if ($status == 'LA') {
			$data["value"] = $this->Grid_model->continuous_late_report($hide_date, $hide_date2, $emp_ids);
		} else {
			$data["value"] = $this->Grid_model->continuous_report($hide_date, $hide_date2, $status, $emp_ids);
		}

		if($status =="A")
		{
			$status = "Absent";
		}
		elseif($status =="P")
		{
			$status = "Present";
		}
		elseif($status =="L")
		{
			$status = "Leave";
		}
		elseif($status =="LA")
		{
			$status = "Late";
		}
		$data["status"] 	= $status;
		$data["start_date"] = $hide_date;
		$data["end_date"] 	= $hide_date2;
		$data["unit_id"] 	= $unit_id;
		$this->load->view('grid_con/continuous_present_report_excel',$data);
	}

	function continuous_leave_report()
	{
		$firstdate = date("Y-m-d", strtotime($this->input->post('firstdate')));
		$seconddate = date("Y-m-d", strtotime($this->input->post('seconddate')));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$emp_ids = explode(',', trim($grid_data));

		$data["values"] = $this->Grid_model->continuous_leave_report($firstdate, $seconddate, $status, $emp_ids);
		// dd($data["values"]);

		$data["status"] = "Leave";
		$data["start_date"] = $firstdate;
		$data["end_date"] = $seconddate;

		if(is_string($data["values"])) {
			echo $data["values"];
		} else {
			$this->load->view('grid_con/continuous_leave_report',$data);
		}
	}

	// Increment Promotion Line Letter
	function incre_prom_report(){
		$first_date = date('Y-m-d',strtotime($this->input->post('first_date')));
		$second_date = date('Y-m-d',strtotime($this->input->post('second_date')));
		$ids = $this->input->post('spl');
		$type = $this->input->post('type');
		$skip = $this->input->post('skip');
		$emp_id = explode(',', trim($ids));

		$data["values"] = $this->Grid_model->incre_prom_report($first_date,$second_date,$emp_id,$type, $skip);
		// dd($data["values"]);
        if($type == 1){
			$this->load->view('grid_con/increment_letter',$data);
		}else if($type == 2){
			$this->load->view('grid_con/promotion_letter',$data);
		}else{
			$this->load->view('grid_con/line_letter',$data);
		}
	}

    // New Joining
	function grid_new_join_report(){
		$grid_firstdate 	= $this->input->post('firstdate');
		$grid_seconddate	= $this->input->post('seconddate');
		$grid_firstdate  	= date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  	= date("Y-m-d", strtotime($grid_seconddate));
		$data['values'] 	= $this->Grid_model->grid_new_join_report($grid_firstdate, $grid_seconddate);
		$data['start_date']	= $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id'] 	= $this->input->post('unit_id');
		if(is_string($data['values'])){
			echo $data['values'];
		}
		else{
			$this->load->view('grid_con/new_join_emp_report',$data);
		}
	}

	// resign report
	function grid_resign_report(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$status = $this->input->post('status');
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));
		$data['values'] = $this->Grid_model->grid_resign_report($grid_firstdate, $grid_seconddate);
		$data['start_date'] = $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id'] = $this->input->post('unit_id');
		if(is_string($data['values'])){
			echo $data['values'];
		}else{
			$this->load->view('grid_con/resign_emp_report',$data);
		}
	}
    // left report
	function grid_left_report(){

		$grid_firstdate     = $this->input->post('firstdate');
		$grid_seconddate    = $this->input->post('seconddate');
		$sql    = $this->input->post('sql');

		$emp_id = explode(',', $sql);
		$unit_id    = $this->input->post('unit_id');
		$grid_firstdate     = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate    = date("Y-m-d", strtotime($grid_seconddate));
		$data['values']     = $this->Grid_model->grid_left_report($grid_firstdate, $grid_seconddate, $emp_id);
		$data['start_date'] = $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id']    = $unit_id;
		if(is_string($data['values'])){
			echo $data['values'];
		}
		else{
			$this->load->view('grid_con/left_emp_report',$data);
		}
	}

	function id_card(){
		$emp_ids = $this->input->post('emp_id');
		$unit_id = $this->input->post('unit_id');
		$status    = $this->input->post('status');
		$firstdate = 	"2023-12-14";
		// dd($status);
		$emp_id = explode(',', trim($emp_ids));
		$query['unit_id'] = 	$unit_id;
		$query['firstdate'] = 	"2023-12-14";
		$validity = date("Y-m-d",strtotime("+3 year",strtotime($firstdate)));
		$query['validity']= date("d-m-Y",strtotime($validity));
		$query['values'] = $this->Grid_model->id_card($emp_id,$status);
		if(is_string($query['values'])){
			echo $query['values'];
		}else{
			// $this->load->view('id_card',$query);
			if($status == 1){
				$this->load->view('grid_con/id_card_bangla',$query);
			}else{
				$this->load->view('grid_con/id_card_eng',$query);
			}
		}
	}

	function grid_id_card_english()
	{
		$grid_data = $this->uri->segment(3);
		$grid_unit = $this->uri->segment(4);
		$grid_emp_id = explode(',', trim($grid_data));
		$query['unit_id'] = 	$grid_unit;
		// $query['values'] = $this->Grid_model->grid_id_card_english($grid_emp_id);
		$query['values'] = $this->Grid_model->grid_id_card($grid_emp_id);
		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('grid_con/id_card_english',$query);
		}
	}

	function leave_application(){
		$first_date 		 = $this->input->post('firstdate');
		$second_date		 = $this->input->post('seconddate');
		$apply_date		     = $this->input->post('apply_date');
		$unit_id    		 = $this->input->post('unit_id');
		$emp_id     		 = $this->input->post('emp_id');
		$data['type']    	 = $this->input->post('type');
		$data['reason']    	 = $this->input->post('reason');
		$data['unit_id']     = $unit_id;
		$data['first_date']  = $first_date;
		$data['second_date'] = $second_date;
		$data['apply_date']  = date('d/m/Y', strtotime($apply_date));
		$data['values']      = $this->Grid_model->leave_application($first_date,$second_date,$emp_id,$unit_id);
		$date1 = new DateTime($first_date);
		$date2 = new DateTime($second_date);
		$interval = $date2->diff($date1);
		$interval->d += 1;
		if($data['values']['leave_entitle_casual'] >= $interval->format('%d')){
			$this->load->view('grid_con/leave_application',$data);
		}else{
			echo false;
		}
	}
	// emp general report

	function grid_general_info(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->grid_general_info($grid_emp_id);
		$data['unit_id'] = $this->input->post('unit_id');
		$data['grid_emp_id'] = $grid_emp_id;
		$this->load->view('grid_con/general_info',$data);
	}

	function worker_register(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->grid_general_info($grid_emp_id);
		$data['unit_id'] = $this->input->post('unit_id');
		$data['grid_emp_id'] = $grid_emp_id;
		$this->load->view('grid_con/worker_register',$data);
	}

	function grid_eot_actual(){
		$grid_firstdate  = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data       = $this->input->post('spl');
		$grid_emp_id 	 = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

		// $data['values']  = $this->Grid_model->grid_extra_ot($grid_firstdate, $grid_seconddate, $grid_emp_id);;
		$data['values'] = $this->Grid_model->get_ot_emp_info($grid_emp_id);

		$data['grid_firstdate'] = $grid_firstdate;
		$data['grid_seconddate'] = $grid_seconddate;
		if(is_string($data['values'])){
			echo $data['values'];
		}else{
			// $this->load->view('grid_job_card',$data);
			$this->load->view('grid_con/grid_eot_actual',$data);
		}
	}

	// max 2 hours ot or out time 7pm
	function grid_job_card(){
		$grid_firstdate  = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data       = $this->input->post('spl');
		$grid_emp_id 	 = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

		// $query['values'] = $this->Grid_model->grid_job_card($grid_firstdate, $grid_seconddate, $grid_emp_id);
		$data['values'] = $this->Grid_model->get_ot_emp_info($grid_emp_id);

		$data['grid_firstdate'] = $grid_firstdate;
		$data['grid_seconddate'] = $grid_seconddate;
		if(is_string($data['values'])){
			echo $data['values'];
		}else{
			$this->load->view('grid_con/grid_job_card',$data);
		}
	}

	function grid_extra_ot_9pm(){
		$grid_firstdate  = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data       = $this->input->post('spl');
		$grid_emp_id 	 = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));
		$data['values']  = $this->Grid_model->get_ot_emp_info($grid_emp_id);
		$data['grid_firstdate'] = $grid_firstdate;
		$data['grid_seconddate'] = $grid_seconddate;
		if(is_string($data['values'])){
			echo $data['values'];
		}else{
			$this->load->view('grid_con/grid_extra_ot_9pm',$data);
		}
	}

	function grid_extra_ot_12am(){
		$grid_firstdate		 = $this->input->post('firstdate');
		$grid_seconddate	 = $this->input->post('seconddate');
		$grid_data 			 = $this->input->post('spl');
		$grid_emp_id         = explode(',', trim($grid_data));
		$data['unit_id']     = $this->input->post('unit_id');
		$data['grid_firstdate']  = $grid_firstdate;
		$data['grid_seconddate'] = $grid_seconddate;
		$grid_firstdate  	 = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate 	 = date("Y-m-d", strtotime($grid_seconddate));
		$data['values'] = $this->Grid_model->get_ot_emp_info( $grid_emp_id);
		$this->load->view('grid_con/grid_extra_ot_12am',$data);
	}

	function grid_extra_ot_all(){
		$grid_firstdate  = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data       = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));
		$data['values'] = $this->Grid_model->get_ot_emp_info($grid_emp_id);
		$data['grid_firstdate'] = $grid_firstdate;
		$data['grid_seconddate'] = $grid_seconddate;
		if(is_string($data['values'])){
			echo $data['values'];
		}else{
			$this->load->view('grid_con/grid_extra_ot_all',$data);
		}
	}

	// ============================== Daily Actual Report ===============
	function grid_actual_present_report()
	{
		$date = date('Y-m-d', strtotime($this->input->post('firstdate')));
		$status = $this->input->post('status');
		$unit_id = $this->input->post('unit_id');
		$spl = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($spl));

		$data["values"] = $this->Grid_model->grid_daily_report($date, $grid_emp_id, 1);
		// dd($data["values"]);
		$data["date"]			= $date;
		$data["daily_status"]	= $status;
		$data["unit_id"] 		= $unit_id;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_con/grid_actual_present_report',$data);
		}
	}
	// ============================== end Daily Actual Report ===============

	// ============================== Daily Costing Report ===============
	function grid_daily_costing_report(){
		$grid_date = $this->input->post('firstdate');
		$grid_unit = $this->input->post('unit_id');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->grid_daily_costing_report($grid_date,$grid_unit,$grid_emp_id);
		$data["grid_date"]	= date("d-M-Y",strtotime($grid_date));
		$data["unit_id"]	= $grid_unit;

		// dd($data["values"]);
		if(is_string($data["values"])){
			echo $data["values"];
		}else{
			$this->load->view('grid_con/grid_daily_costing_report',$data);
		}
		/* if(is_string($data["values"])){
			echo $data["values"];
		}else{
			$this->load->view('grid_con/daily_costing_report',$data);
		} */
	}
	// ============================== end Daily Costing Report ===============

	// ============================== holiday / weekend Report ===============
	function holiday_weekend_attn_report(){
		$date = date('Y-m-d', strtotime($this->input->post('firstdate')));
		$unit_id = $this->input->post('unit_id');
		$grid_data = $this->input->post('spl');
		$status = $this->input->post('status');
		$emp_id = explode(',', trim($grid_data));

		$data["values"] = $this->Grid_model->holiday_weekend_attn_report($emp_id, $date, $status, $unit_id);
		$data["date"]		= $date;
		$data["status"]		= $status;
		$data["unit_id"]	= $unit_id;

		if(is_string($data["values"])){
			echo $data["values"];
		}else{
			$this->load->view('grid_con/holiday_weekend_attn_report',$data);
		}
	}
	// ============================== end holiday / weekend Report ===============

	// ============================== last increment or promotion Report ===============
	function last_increment_promotion(){
		$unit_id = $this->input->post('unit_id');
		$grid_data = $this->input->post('spl');
		$status = $this->input->post('status');
		$emp_id = explode(',', trim($grid_data));

		$data["values"] = $this->Grid_model->last_increment_promotion($emp_id, $status, $unit_id);
		// dd($data["values"]);
		$data["status"]		= $status;
		$data["unit_id"]	= $unit_id;

		if(is_string($data["values"])){
			echo $data["values"];
		}else{
			$this->load->view('grid_con/last_increment_promotion',$data);
		}
	}

	function ot_acknowledgement_sheet()
	{
		$date = date('Y-m-d', strtotime($this->input->post('firstdate')));
		$status = $this->input->post('status');
		$unit_id = $this->input->post('unit_id');
		$spl = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($spl));

		$data["values"] = $this->Grid_model->ot_acknowledgement_sheet($date, $grid_emp_id, $status);
		$data["date"]			= $date;
		$data["status"]			= $status;
		$data["unit_id"] 		= $unit_id;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_con/ot_acknowledgement_sheet',$data);
		}
	}

	function increment_able_employee()
	{
		$date = $this->input->post('firstdate');
		$unit_id = $this->input->post('unit_id');
		$spl = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($spl));

		$data["values"] = $this->Grid_model->increment_able_employee($date, $grid_emp_id, $unit_id);
		$data["date"]			= $date;
		$data["unit_id"] 		= $unit_id;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_con/increment_able_employee',$data);
		}
	}
	function unit_transferred_list()
	{
		if (!empty($this->input->post('firstdate')) && !empty($this->input->post('seconddate'))) {
			$firstdate = date('Y-m-d',strtotime($this->input->post('firstdate'))); //$this->input->post('firstdate'));
			$seconddate = date('Y-m-d',strtotime($this->input->post('seconddate'))); // $this->input->post('seconddate');
		} else {
			$firstdate = '';
			$seconddate = '';
		}

		$type = $this->input->post('type');
		$spl = $this->input->post('spl');
		$emp_id= $grid_emp_id = explode(',', trim($spl));
		$unit_id= $unit_id = $this->input->post('unit_id');

		if (!empty($firstdate) && !empty($seconddate)) {
			$sql = "SELECT DISTINCT transfer.*, com.emp_id, com.unit_id, com.emp_join_date, com.gross_sal, com.com_gross_sal, per.name_en, per.name_bn, per.personal_mobile, per.gender, desig.desig_bangla, dept.dept_bangla, sec.sec_name_bn, line.line_name_bn FROM pr_unit_transfer as transfer
					LEFT JOIN pr_emp_com_info as com ON transfer.".($type == 1 ? 'new_emp_id' : 'old_emp_id')." = com.emp_id
					LEFT JOIN pr_emp_per_info as per ON per.emp_id = com.emp_id
					LEFT JOIN emp_designation as desig ON com.emp_desi_id = desig.id
					LEFT JOIN emp_depertment as dept ON com.emp_dept_id = dept.dept_id
					LEFT JOIN emp_section as sec ON com.emp_sec_id = sec.id
					LEFT JOIN emp_line_num as line ON com.emp_line_id = line.id
					WHERE transfer.joining_date BETWEEN '$firstdate' AND '$seconddate'
					AND com.emp_id IN (".implode(',', $emp_id).")
					AND com.unit_id = $unit_id ";
		} else {
			$sql = "SELECT DISTINCT transfer.*, com.emp_id, com.unit_id, com.emp_join_date, com.gross_sal, com.com_gross_sal, per.name_en, per.name_bn, per.personal_mobile, per.gender, desig.desig_bangla, dept.dept_bangla, sec.sec_name_bn, line.line_name_bn FROM pr_unit_transfer as transfer
					LEFT JOIN pr_emp_com_info as com ON transfer.".($type == 1 ? 'new_emp_id' : 'old_emp_id')." = com.emp_id
					LEFT JOIN pr_emp_per_info as per ON per.emp_id = com.emp_id
					LEFT JOIN emp_designation as desig ON com.emp_desi_id = desig.id
					LEFT JOIN emp_depertment as dept ON com.emp_dept_id = dept.dept_id
					LEFT JOIN emp_section as sec ON com.emp_sec_id = sec.id
					LEFT JOIN emp_line_num as line ON com.emp_line_id = line.id
					WHERE com.emp_id IN (".implode(',', $emp_id).")
					AND com.unit_id = $unit_id ";
		}

		$data["array"] = $this->db->query($sql)->result();
		$this->load->view('grid_con/'.($type == 1 ? 'unit_transfer_list' : 'unit_transferred_list'), $data);
	}

	function iftar_bill_list()
	{
		$date1= date('Y-m-d',strtotime($this->input->post('firstdate'))); //$this->input->post('firstdate'));
		$date2= date('Y-m-d',strtotime($this->input->post('seconddate'))); // $this->input->post('seconddate');

		if (empty($date2)) {
			$date2=$date1;
		};
		$unit_id = $this->input->post('unit_id');
		$spl = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($spl));

		$data["values"] = $this->Grid_model->iftar_bill_list($date1, $date2, $grid_emp_id, $unit_id);
		$data["date1"]			= $date1;
		$data["date2"]			= $date2;
		$data["unit_id"] 		= $unit_id;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_con/iftar_bill_list_report',$data);
		}
	}

	function grid_yearly_leave_register(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');
		$query=$this->Grid_model->grid_yearly_leave_register($grid_firstdate, $grid_seconddate,$grid_emp_id);
		if(is_string($query)){
			echo $query;
		}else{
			$data["values"]		 = $query;
			$data['unit_id']	 = $unit_id ;
			$data["first_date"]  = $grid_firstdate;
			$data["second_date"] = $grid_seconddate;
			//  dd($this->input->post('seconddate'));
			$this->load->view('grid_con/yearly_leave_register',$data);
		}
	}

	function emp_conformation_list(){
		$unit_id = $this->input->post('unit_id');
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$emp_id = explode(',', trim($grid_data));
		if($status == 1){
			if (!empty($this->input->post('firstdate'))) {
				$firstdate  = date('Y-m-d',strtotime('-180 day',strtotime($this->input->post('firstdate'))));
			} else {
				$firstdate  = date('Y-m-d',strtotime('-180 day',strtotime(date('Y-m-d'))));
			}
		} else if ($status == 2) {
			if (!empty($this->input->post('firstdate'))) {
				$firstdate  = date('Y-m-d',strtotime('-90 day',strtotime($this->input->post('firstdate'))));
			} else {
				$firstdate  = date('Y-m-d',strtotime('-90 day',strtotime(date('Y-m-d'))));
			}
		} else {
			$firstdate  = date('Y-m-d');
			$status = null;
		}

		$data["values"] = $this->Grid_model->emp_conformation_list($emp_id, $firstdate, $unit_id, $status);
		$data["status"]		= $status;
		$data["unit_id"]	= $unit_id;

		if(is_string($data["values"])){
			echo $data["values"];
		}else{
			$this->load->view('grid_con/emp_conformation_list',$data);
		}
	}
	// ============================== end last increment or promotion Report ===============
	// ============================== start left letter Report ===============
	function grid_letter_report_print(){

		$emp_id = $this->input->post('emp_id');
		$status = $this->input->post('status');
		$unit_id = $this->session->userdata('data')->unit_name;
		$id_number = $this->session->userdata('data')->id_number;


		$data['values'] 	= $this->Grid_model->grid_letter_report_print($emp_id);
		$data['unit_id']	= $unit_id;
		$data['unit_id']	= $id_number;
		$data['no_change']	= 1;


		if(empty($data)){
			echo "Not Found Data"; exit();
		}else{
			if ($status == 2) {
				$this->load->view('grid_con/letter1',$data);
			} else if ($status == 3) {
				$this->load->view('grid_con/letter2',$data);
			} else {
				$this->load->view('grid_con/letter3',$data);
			}
		}
	}
	function grid_letter_report_print_no_left(){

		$emp_id = $this->input->post('emp_id');
		$status = $this->input->post('status');
		$date = $this->input->post('date');
		$sql = $this->input->post('sql');

		$unit_id = $this->session->userdata('data')->unit_name;
		$id_number = $this->session->userdata('data')->id_number;


		$data['values'] 	= $this->Grid_model->grid_letter_report_print_no_left($sql);

		if ($data['values'][0]->left_date == '' || $data['values'][0]->left_date == null) {
			$data['values'][0]->left_date = date("Y-m-d", strtotime($date));
		}

		$data['unit_id']	= $unit_id;
		$data['unit_id']	= $id_number;
		$data['no_change']	= 1;


		if(empty($data)){
			echo "Not Found Data"; exit();
		}else{
			if ($status == 1) {
				$this->load->view('grid_con/letter1',$data);
			} else if ($status == 2) {
				$this->load->view('grid_con/letter2',$data);
			} else {
				$this->load->view('grid_con/letter3',$data);
			}
		}
	}


	function grid_letter_report(){
		$unit_id = $this->input->post('unit_id');
		$status = $this->input->post('status');
		$firstdate = $this->input->post('firstdate');
		$data['firstdate']	= date("Y-m-d", strtotime($firstdate));
		if ($status == 1) {
			$days = 11;
		} else if ($status == 2) {
			$days = 21;
		} else {
			$days = 30;
		}
		$off_day = 'Fri';
		$data['values'] 	= $this->Grid_model->grid_letter_report($data['firstdate'],$unit_id,$off_day,$days,$status);
		$data['unit_id']	= $unit_id;
		$data['no_change']	= 2;


		if(empty($data)){
			echo "Not Found Data"; exit();
		}else{
			if ($status == 1) {
				$this->load->view('grid_con/letter1',$data);
			} else if ($status == 2) {
				$this->load->view('grid_con/letter2',$data);
			} else {
				$this->load->view('grid_con/letter3',$data);
			}
		}
	}

	function grid_letter_count(){
		$unit_id = $this->input->post('unit_id');
		$firstdate = $this->input->post('firstdate');
		$data['firstdate']	= date("Y-m-d", strtotime($firstdate));
		$days1 = 11;
		$days2 = 21;
		$days3 = 30;
		$off_day = 'Fri';

		$data['values'] = $this->Grid_model->grid_letter_report($data['firstdate'], $unit_id, $off_day, $days1, 1);
		$data['values2'] = $this->Grid_model->grid_letter_report($data['firstdate'], $unit_id, $off_day, $days2, 2);
		$data['values3'] = $this->Grid_model->grid_letter_report($data['firstdate'], $unit_id, $off_day, $days3, 3);

		if (!empty($data['values'])) {
			$v['1'] = count($data['values']);
		} else {
			$v['1'] = 0;
		}

		if (!empty($data['values2'])) {
			$v['2'] = count($data['values2']);
		} else {
			$v['2'] = 0;
		}

		if (!empty($data['values3'])) {
			$v['3'] = count($data['values3']);
		} else {
			$v['3'] = 0;
		}
		echo json_encode($v);
	}
	// ============================== end left letter Report ===============D

	// ============================== start increment & prom  Report ===============D
	function continuous_incre_report()
	{
		$sStartDate = date("Y-m-d", strtotime($this->input->post('firstdate')));
		$sEndDate = date("Y-m-d", strtotime($this->input->post('seconddate')));
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		$data["values"] = $this->Grid_model->continuous_incre_report($sStartDate,$sEndDate,$grid_emp_id);
		$data["start_date"] = $sStartDate;
		$data["end_date"] = $sEndDate;
		$data["unit_id"] = $unit_id;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_con/continuous_increment_report',$data);
		}
	}
	function continuous_prom_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));

		$data["values"] = $this->Grid_model->continuous_prom_report($sStartDate,$sEndDate,$grid_emp_id);

		$data["start_date"] = $sStartDate;
		$data["end_date"] = $sEndDate;
		$data["unit_id"] = $unit_id;
		//print_r($data);
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_con/continuous_promotion_report',$data);
		}
	}
	// ============================== end increment & prom Report ===============D
	function grid_continuous_ot_eot_report()
	{
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		$sStartDate = date("Y-m-d", strtotime($this->input->post('firstdate')));
		$sEndDate = date("Y-m-d", strtotime($this->input->post('seconddate')));

		$data["values"] = $this->Grid_model->continuous_ot_eot_report($sStartDate, $sEndDate, $grid_emp_id);

		$data["start_date"] = $sStartDate;
		$data["end_date"] 	= $sEndDate;
		$data["unit_id"] 	= $unit_id;
		//print_r($data);
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('continuous_ot_eot_report',$data);
		}
	}
	// ============================== end grid continuous ot eot report ===============D
	// ============================== grid continuous max ot day ===============D
	function grid_continuous_max_ot_day()
	{
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');
		$max_ot = $this->input->post('max_ot');

		$sStartDate = date("Y-m-d", strtotime($this->input->post('firstdate')));
		$sEndDate = date("Y-m-d", strtotime($this->input->post('seconddate')));

		$data["values"] = $this->Grid_model->grid_continuous_max_ot_day($sStartDate, $sEndDate, $grid_emp_id, $max_ot);

		$data["start_date"] = $sStartDate;
		$data["end_date"] 	= $sEndDate;
		$data["unit_id"] 	= $unit_id;
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_continuous_max_ot_day',$data);
		}
	}
	// ============================== end grid continuous max ot day ===============D
	function grid_continuous_costing_report()
	{
		$firstdate  = $this->input->post('firstdate');
		$seconddate = $this->input->post('seconddate');
		$grid_unit  = $this->input->post('grid_start');
		$grid_data  = $this->input->post('spl');
		$emp_ids    = explode(',', trim($grid_data));

		$data["values"] 	= $this->Grid_model->grid_continuous_costing_report($firstdate,$seconddate,$grid_unit,$emp_ids);
		$data["firstdate"]	= date("d-M-Y",strtotime($firstdate));
		$data["seconddate"]	= date("d-M-Y",strtotime($seconddate));
		$data["unit_id"]	= $grid_unit;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('grid_con/continuous_costing_report',$data);
		}
	}
	function grid_maternity_benefit(){
		$firstdate = date('Y-m-d', strtotime($this->input->post('firstdate')));
		$seconddate = date('Y-m-d', strtotime($this->input->post('seconddate')));
		$unit_id   = $this->input->post('unit_id');
		$grid_data = $this->input->post('spl');
		$emp_ids = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->grid_maternity_benefit($emp_ids, $firstdate, $seconddate);
		// dd($data["values"]);
		$data["firstdate"]	= date("d-M-Y",strtotime($firstdate));
		$data["seconddate"]	= date("d-M-Y",strtotime($seconddate));
		$data["unit_id"]	= $unit_id;
		$this->load->view('grid_con/grid_maternity_benefit',$data);
	}
	function grid_final_satalment(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->grid_employee_information($grid_emp_id);
		$data['total_value']= $this->db->select('*')->where_in('emp_id',$grid_emp_id)->get('pr_emp_resign_history')->row();
		$data['unit_id'] = $this->input->post('unit_id');
		$data['type'] = $this->input->post('type');
		$this->load->view('grid_con/final_satalment',$data,false);
	}
	public function final_satalment(){
		$emp_ids = $this->input->post('id');
		$d = $this->Grid_model->grid_employee_information($emp_ids);
		$get_all=[];
		foreach($d as $key => $row){
			$get_all[$key] = $row;
			$this->db->select('
					SUM(ot) as ot_hour,
					SUM(eot) as eot_hour,
					SUM(ot_eot_4pm) as ot_eot_4pm,
					SUM(ot_eot_12am) as ot_eot_12am,
					SUM(CASE WHEN present_status = "W" THEN eot ELSE 0 END) as all_eot_wday,
					SUM(CASE WHEN present_status = "H" THEN eot ELSE 0 END) as all_eot_hday,
					COUNT(CASE WHEN present_status != "A" THEN 1 ELSE 0 END) as working_days,
					COUNT(CASE WHEN present_status = "A" THEN 1 ELSE 0 END) as status', FALSE
			);
			$this->db->from('pr_emp_shift_log');
			$this->db->where('pr_emp_shift_log.emp_id',$row->emp_id);
			$this->db->where('shift_log_date >=',date('Y-m-01',strtotime($row->resign_date)));
			$this->db->where('shift_log_date <=',date('Y-m-d',strtotime($row->resign_date)));
			$dd = $this->db->get()->row();
			$ssss = $this->common_model->salary_structure($row->gross_sal);

			$get_all[$key]->ot_hour = $dd->ot_hour;
			$get_all[$key]->eot_hour = $dd->eot_hour;
			$get_all[$key]->status = $dd->status;
			$get_all[$key]->working_days = ($dd->working_days+$dd->status);
			$get_all[$key]->basic_sal = $ssss['basic_sal'];
			$get_all[$key]->ot_rate = $ssss['ot_rate'];
		}
		echo json_encode($get_all[0]);
	}

	function grid_monthly_att_register(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data['unit_id'] = $this->input->post('unit_id');
		$query=$this->Grid_model->grid_monthly_att_registerr($grid_emp_id);
		if(is_string($query)){
			echo $query;
		}else{
			$data["value"] = $query;
			$data["year_month"] = date("M-Y", strtotime($grid_firstdate));
			$this->load->view('monthly_reportt',$data);
		}
	}
	// function grid_monthly_night_register(){
	// 	$grid_firstdate = $this->input->post('firstdate');
	// 	$grid_data = $this->input->post('spl');
	// 	$grid_emp_id = explode(',', trim($grid_data));
	// 	$data['unit_id'] = $this->input->post('unit_id');
	// 	$query=$this->Grid_model->grid_monthly_night_register($grid_firstdate,$grid_emp_id);
	// 	if(is_string($query)){
	// 		echo $query;
	// 	}else{
	// 		$data["value"] = $query;
	// 		$data["year_month"] = date("M-Y", strtotime($grid_firstdate));
	// 		$this->load->view('monthly_report_night',$data);
	// 	}
	// }

	function att_register_excel(){
		$grid_firstdate = $this->input->post('hide_date');
		$grid_data = $this->input->post('hide_emp');
		$unit_id = $this->input->post('hide_unit');
		$emp_ids = explode(',', trim($grid_data));
		$year_month = date("Y-m", strtotime($grid_firstdate));

		$query=$this->Grid_model->grid_monthly_att_registerr($emp_ids);

		$year_month = date("M-Y", strtotime($grid_firstdate));
		$data["value"]=$query;
		$data['unit_id'] = $unit_id;
		$data["year_month"] = $year_month;
		$this->load->view('att_register_excel',$data);
	}

	function grid_monthly_att_register_ot(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');
		$year_month = date("Y-m", strtotime($grid_firstdate));

		$query=$this->Grid_model->grid_monthly_att_register($year_month, $grid_emp_id);
		// dd($query);
		if(is_string($query)){
			echo $query;
		}
		else{
			$year_month = date("M-Y", strtotime($grid_firstdate));
			$data["value"]=$query;
			$data['unit_id'] = $unit_id ;
			$data["year_month"] = $year_month;
			$this->load->view('monthly_report_ot',$data);
		}
	}

	function att_register_ot_excel(){
		$grid_firstdate = $this->input->post('hide_date');
		$grid_data = $this->input->post('hide_emp');
		$unit_id = $this->input->post('hide_unit');
		$emp_ids = explode(',', trim($grid_data));
		$year_month = date("Y-m", strtotime($grid_firstdate));

		$query=$this->Grid_model->grid_monthly_att_register($year_month, $emp_ids);

		$year_month = date("M-Y", strtotime($grid_firstdate));
		$data["value"]=$query;
		$data['unit_id'] = $unit_id;
		$data["year_month"] = $year_month;
		$this->load->view('att_register_ot_excel',$data);
	}

	function grid_monthly_ot_register()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_monthly_ot_register($grid_firstdate, $grid_emp_id);
		$data['unit_id'] = $this->input->post('unit_id');

		$data['start_date']= $grid_firstdate;

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('monthly_ot_register',$data);
		}
	}

	function ot_register_excel(){
		$grid_firstdate = $this->input->post('hide_date');
		$grid_data = $this->input->post('hide_emp');
		$unit_id = $this->input->post('hide_unit');
		$emp_ids = explode(',', trim($grid_data));
		$year_month = date("Y-m", strtotime($grid_firstdate));

		$query=$this->Grid_model->grid_monthly_ot_register($year_month, $emp_ids);
		// dd($query);

		$year_month = date("M-Y", strtotime($grid_firstdate));
		$data["value"]=$query;
		$data['unit_id'] = $unit_id;
		$data["year_month"] = $year_month;
		$this->load->view('ot_register_excel',$data);
	}

	function grid_monthly_eot_register()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_monthly_eot_register($grid_firstdate, $grid_emp_id);
		$data['unit_id'] = $this->input->post('unit_id');
		$data['start_date']= $grid_firstdate;

		if($data['values'] == 'Requested list is empty' )
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('monthly_eot_register',$data);
		}
	}

	function eot_register_excel(){
		$grid_firstdate = $this->input->post('hide_date');
		$grid_data = $this->input->post('hide_emp');
		$unit_id = $this->input->post('hide_unit');
		$emp_ids = explode(',', trim($grid_data));
		$year_month = date("Y-m", strtotime($grid_firstdate));

		$query=$this->Grid_model->grid_monthly_eot_register($year_month, $emp_ids);

		$year_month = date("M-Y", strtotime($grid_firstdate));
		$data["value"]=$query;
		$data['unit_id'] = $unit_id;
		$data["year_month"] = $year_month;
		$this->load->view('eot_register_excel',$data);
	}

	function grid_emp_job_application(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');
		$query['unit_id'] = $this->input->post('unit_id');
		$query['values'] = $this->Grid_model->grid_emp_job_application($grid_emp_id);
		if(is_string($query['values'])){
			echo $query['values'];
		} else{
			$this->load->view('worker_personal_info',$query);
		}
	}












	// =========================================================
	/*
		old code
	*/
	// =========================================================

	function auto_temp_table(){
		exit('This file is Very Dengerous');
		$this->db->select('emp_id');
		$query = $this->db->get('pr_emp_per_info')->result();
		foreach ($query as $key => $row) {
			$id = $row->emp_id;
			$temp_table = "temp_$id";
			$this->load->dbforge();
			if (!$this->db->table_exists($temp_table) ) {
				$temp_fields = array(
					'att_id' 	=> array( 'type' => 'INT','constraint' => '11',  'auto_increment' => TRUE),
					'device_id' => array( 'type' => 'INT','constraint' => '11'),
					'proxi_id'  => array( 'type' => 'INT','constraint' => '11'),
					'date_time' => array( 'type' => 'datetime')
				);
				$this->dbforge->add_field($temp_fields);
				$this->dbforge->add_key('att_id', TRUE);
				$this->dbforge->create_table($temp_table);
			}
		}
		echo "success";
	}

	function grid_age_estimation(){
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		$data["value"] = $this->Grid_model->grid_age_estimation($grid_emp_id);
		$this->load->view('age_estimation_bn',$data);
	}

	function bando_certificate_report(){
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		$data["value"] = $this->Grid_model->bando_certificate_report($grid_emp_id);
		$this->load->view('certificate',$data);
	}

	function one_month_settel_paid_report(){
		$grid_data = $this->uri->segment(3);
		$grid_firstdate = $this->uri->segment(4);
		$year_month = date('Y-m',strtotime($grid_firstdate));
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->one_month_settel_paid_report($grid_emp_id,$year_month);
		if(is_string($data['values'])){
			echo $data['values'];
		}
		else{
			$this->load->view('1month_settelment',$data);
		}
	}

	function grid_drugscreening_report(){
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		$data["value"] = $this->Grid_model->grid_drugscreening_report($grid_emp_id);
		$this->load->view('drugscreeningform',$data);
	}

	function ackknowledgement_report(){
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		$data["value"] = $this->Grid_model->ackknowledgement_report($grid_emp_id);
		$this->load->view('ackknowledgement_letter',$data);
	}

	function earnl_payment(){
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		$data["value"] = $this->Grid_model->earnl_payment($grid_emp_id);
		$this->load->view('earnl_payment',$data);
	}

	function grid_pension_report(){

		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));
		$data['values'] = $this->Grid_model->grid_pension_report($grid_firstdate, $grid_seconddate, $grid_emp_id);
		$data['start_date']= $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;

		if(is_string($data['values'])){
			echo $data['values'];
		}
		else{
			$this->load->view('pension_2',$data);
		}
	}

	function grid_nominee(){
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		$data["value"] = $this->Grid_model->grid_nominee($grid_emp_id);
		$this->load->view('nominee_form',$data);
	}
	function grid_requitement_form(){
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		$data["value"] = $this->Grid_model->grid_requitement_form($grid_emp_id);
		$this->load->view('requitement_form',$data);
	}
	function grid_per_file(){
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		$query['values'] = $this->Grid_model->grid_per_file($grid_emp_id);
		if(is_string($query['values'])){
			echo $query['values'];
		}else{
			$this->load->view('per_file',$query);
		}
	}

	function grid_ctpat(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');
		$query['unit_id'] = $this->input->post('unit_id');
		$query['values'] = $this->Grid_model->grid_ctpat($grid_emp_id);
		if(is_string($query['values'])){
			echo $query['values'];
		}
		else{
			$this->load->view('ctpat',$query);
		}
	}


	 function prom_report(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m", strtotime($grid_firstdate));
		$data["values"] = $this->Grid_model->prom_report_db($grid_firstdate,$grid_emp_id);
		if(is_string($data["values"])){
			echo $data["values"];
		}
		else{
			$this->load->view('prom_report',$data);
		}
	  }

	function incre_prom_report_db($grid_firstdate,$grid_emp_id){
		$data = array();
		foreach($grid_emp_id as $emp_id){
			$this->db->select('*');
			$this->db->where("ref_id",$emp_id);
			$this->db->like("effective_month",$grid_firstdate);
			$this->db->order_by("effective_month","desc");
			$query = $this->db->get('pr_incre_prom_pun');
			if($query->num_rows() != 0){
				foreach ($query->result() as $rows){
					$data["prev_emp_id"][] 				= $rows->prev_emp_id;
					$data["new_emp_id"][] 				= $rows->new_emp_id;
					$prev_dept_name = $this->get_dept_name($rows->prev_dept);
					$prev_section_name = $this->get_section_name($rows->prev_section);
					$prev_line_name = $this->get_line_name($rows->prev_line);
					$prev_desig_name = $this->get_desig_name($rows->prev_desig);
					$data["prev_dept"][] 				= $prev_dept_name;
					$data["prev_section"][] 			= $prev_section_name;
					$data["prev_line"][] 				= $prev_line_name;
					$data["prev_desig"][]				= $prev_desig_name;
					$data["prev_salary"][] 				= $rows->prev_salary;;
					$new_dept_name = $this->get_dept_name($rows->new_dept);
					$new_section_name = $this->get_section_name($rows->new_section);
					$new_line_name = $this->get_line_name($rows->new_line);
					$new_desig_name = $this->get_desig_name($rows->new_desig);
					$data["new_dept"][] 				= $new_dept_name;
					$data["new_section"][] 				= $new_section_name;
					$data["new_line"][] 				= $new_line_name;
					$data["new_desig"][] 				= $new_desig_name;
					$data["new_salary"][] 				= $rows->new_salary;;
					$data["effective_month"][] 			= $rows->effective_month;
					$data["status"][] 					= $rows->status;

				}
			}
		}

		if($data){
			return $data;
		}
		else{
			return "Requested list is empty";
		}

	}

	function all_desig_id()
	{
		//$desig_id = array();
		$data = array();
		//$all_emp_id = array();
		$this->db->select('desig_id,desig_name');
		$query = $this->db->get('pr_designation');
		foreach($query->result() as $row){
			$desig_id = $row->desig_id;
			$all_emp_id = $this->all_emp_desig_wise($desig_id);
			$data[$desig_id]['name'] = $desig_name;
			$data[$desig_id]['id'] = $desig_id;
			$data[$desig_id]['sum'] = $all_emp_id;
		}
		$data['value'] = $data;

		$this->load->view('test',$data);

	}

	function all_emp_desig_wise($desig_id){
		//echo $desig_id;
		$data = array();
		$this->db->select('emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where('emp_desi_id', $desig_id);
		$this->db->where('emp_cat_id != 4');
		$query = $this->db->get();
		return $sum_id = $query->num_rows();
	}

	function shorts_emp_summery()
	{
		// exit('Here');
		$grid_date = $this->input->post('firstdate');
		$unit_id = $this->input->post('unit_id');
		list($date, $month, $year) = explode('-', trim($grid_date));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->shorts_emp_summery($year, $month, $date, $status, $grid_emp_id);
		// print_r($data["values"]);
		// exit('H');

		$data["year"]			= $year;
		$data["month"]			= $month;
		$data["date"]			= $date;
		$data["daily_status"]	= $status;
		$data["col_desig"] 		= "";
		$data["col_line"] 		= "";
		$data["col_section"] 	= "";
		$data["col_dept"] 		= "";
		$data["col_all"] 		= "";
		$data["unit_id"] 		= $unit_id;
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('shorts_emp_summery',$data);
		}
	}

	function first_letter_of_maternity_leave()
	{
		//echo "hey";exit;
		$grid_firstdate = $this->uri->segment(3);
		$grid_data = $this->uri->segment(4);
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m", strtotime($grid_firstdate));
		//print_r($grid_emp_id);

		$data["values"] = $this->Grid_model->first_letter_of_maternity_leave($grid_firstdate,$grid_emp_id);
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('maternity_first_letter',$data);
		}
	}

	function grid_verification_report()
	{
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);

		$data["value"] = $this->Grid_model->grid_verification_report($grid_emp_id);

		$this->load->view('verification_report_new',$data);
	}

	function grid_job_description()
	{
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);

		$data["value"] = $this->Grid_model->grid_job_description($grid_emp_id);

		if($data["value"] != NULL)
		{
			$this->load->view('job_description',$data);
		}
		else
		{
			echo "Dont have the selected designation's description";
		}

	}
	function grid_window(){
		 if ($this->session->userdata('logged_in') == false) {
            redirect("authentication");
        }
        $this->data['employees'] = array();
        $this->db->select('pr_units.*');
        $this->data['dept'] = $this->db->get('pr_units')->result_array();
        // if (!empty($this->data['user_data']->unit_name)) {
	    //     $this->data['employees'] = $this->get_emp_by_unit($this->data['user_data']->unit_name);
        // }


		if($this->session->userdata('level')== 0 || $this->session->userdata('level')== 1){
			// $this->load->view('grid');
			$this->data['username'] = $this->data['user_data']->id_number;
			$this->data['title'] = 'kicu ekta';
			$this->data['subview'] = 'grid';
			$this->load->view('layout/template', $this->data);
		}
		else if($this->session->userdata('level')==2){
			$this->data['username'] = $this->data['user_data']->id_number;
			$this->data['subview'] = 'grid_for_user';
			$this->load->view('layout/template', $this->data);
			// $this->load->view('grid_for_user');
		}
	}

	function grid_window_auto_notify(){
		if($this->session->userdata('level')== 0 || $this->session->userdata('level')== 1){
			$this->load->view('grid_auto_notify');
		}
		else if($this->session->userdata('level')==2){
			$this->load->view('grid_for_user');
		}
	}

	function grid_salary_report(){
		$this->load->view('grid_salary_report');
	}

	function grid_get_all_data(){

			//$get_session_user_unit = $this->Common_model->get_session_unit_id_name();
			$unit 	= $this->uri->segment(3);

			$emp_cat_id = array ('0' => 1, '1' => 2, '2' => 5);

			$this->db->select('pr_emp_per_info.*');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_com_info');
			$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
			$this->db->where('pr_emp_com_info.unit_id',$unit);

			$this->db->order_by("pr_emp_com_info.emp_id");
			$query = $this->db->get();
			// echo count($query->result_array()); exit();

			$i = 0;
			foreach($query->result_array() as $row)
			{
				$responce->rows[$i]['id']=$row['emp_id'];
				$responce->rows[$i]['cell']=array($row['emp_id'],$row['emp_full_name'],$row['emp_dob']);
				$i++;
			}
			echo json_encode($responce);
		exit;
	}

	function grid_all_search(){
		$dept 	= $this->uri->segment(3);
		$section= $this->uri->segment(4);
		$line	= $this->uri->segment(5);
		$desig	= $this->uri->segment(6);
		$sex	= $this->uri->segment(7);
		$status	= $this->uri->segment(8);
		$unit	= $this->uri->segment(9);
		$position	= $this->uri->segment(10);

		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.unit_id',$unit);

		if($dept !="Select")
		{
			$this->db->where("pr_emp_com_info.emp_dept_id", $dept);
		}
		if($section !="Select")
		{
			$this->db->where("pr_emp_com_info.emp_sec_id", $section);
		}
		if($line !="Select")
		{
			$this->db->where("pr_emp_com_info.emp_line_id ", $line);
		}
		if($desig !="Select")
		{
			$this->db->where("pr_emp_com_info.emp_desi_id", $desig);
		}
		if($sex !="Select")
		{
			$this->db->where("pr_emp_per_info.emp_sex", $sex);
		}
		if($status !="Select")
		{
			if($status != 'ALL')
			{
				$this->db->where("pr_emp_com_info.emp_cat_id", $status);
			}
		}
		if($position !="Select")
		{
			$this->db->where("pr_emp_com_info.emp_sts_id", $position);
		}
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		$i = 0;
		foreach($query->result_array() as $row)
		{
			$responce->rows[$i]['id']=$row['emp_id'];
			$responce->rows[$i]['cell']=array($row['emp_id'],$row['emp_full_name'],$row['emp_dob']);
			$i++;
		}
		echo json_encode($responce);
		exit;

	}

	// Zuel Ali 31/03/2019
	function grid_all_search_out_miss(){
		$dept 	= $this->uri->segment(3);
		$section= $this->uri->segment(4);
		$line	= $this->uri->segment(5);
		$desig	= $this->uri->segment(6);
		$sex	= $this->uri->segment(7);
		$status	= $this->uri->segment(8);
		$unit	= $this->uri->segment(9);
		$position	= $this->uri->segment(10);
		$out_miss	= $this->uri->segment(11);
		$f_date	= date('d-m-Y',strtotime($this->uri->segment(12)));

		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_shift_log');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_shift_log.emp_id');
		$this->db->where('pr_emp_com_info.unit_id',$unit);

		if($dept !="Select"){$this->db->where("pr_emp_com_info.emp_dept_id", $dept);}
		if($section !="Select"){$this->db->where("pr_emp_com_info.emp_sec_id", $section);}
		if($line !="Select"){$this->db->where("pr_emp_com_info.emp_line_id ", $line);}
		if($desig !="Select"){$this->db->where("pr_emp_com_info.emp_desi_id", $desig);}
		if($sex !="Select"){$this->db->where("pr_emp_per_info.emp_sex", $sex);}
		if($status !="Select"){
			if($status != 'ALL'){
				$this->db->where("pr_emp_com_info.emp_cat_id", $status);
			}
		}
		if($position !="Select"){
			$this->db->where("pr_emp_com_info.emp_position_id", $position);
		}
		$this->db->where("pr_emp_shift_log.shift_log_date",$f_date);
		if ($out_miss == 1) {
			$this->db->where("pr_emp_shift_log.in_time", '00:00:00');
			$this->db->where("pr_emp_shift_log.out_time !=", '00:00:00');
		}elseif($out_miss == 2){
			$this->db->where("pr_emp_shift_log.out_time", '00:00:00');
			$this->db->where("pr_emp_shift_log.in_time !=", '00:00:00');
		}
		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();
		$i = 0;
		foreach($query->result_array() as $row){
			$responce->rows[$i]['id']=$row['emp_id'];
			$responce->rows[$i]['cell']=array($row['emp_id'],$row['emp_full_name'],$row['emp_dob']);
			$i++;
		}
		echo json_encode($responce);
		exit;
	}

	function grid_get_all_data_for_salary()
	{
		$salary_month	= $this->uri->segment(3);
		$units	= $this->uri->segment(4);
		$i = 0;
		//$salary_month = "2013-05";
		$data = $this->Common_model->get_all_employee($salary_month,$units);
		foreach($data->result_array() as $row)
		{
			$responce->rows[$i]['id']=$row['emp_id'];
			$responce->rows[$i]['cell']=array($row['emp_id'],$row['emp_full_name'],$row['emp_dob']);
			$i++;
		}
		echo json_encode($responce);
		exit;

	}

	function grid_all_search_for_salary(){
		$dept 			= $this->uri->segment(3);
		$section		= $this->uri->segment(4);
		$line			= $this->uri->segment(5);
		$desig			= $this->uri->segment(6);
		$sex			= $this->uri->segment(7);
		$status			= $this->uri->segment(8);
		$salary_month	= $this->uri->segment(9);
		$unit			= $this->uri->segment(10);
		$w_type			= $this->uri->segment(11);
		$position		= $this->uri->segment(12);
		// exit($position);
		//echo "$dept==$section==$line==$desig==$sex==$status===$salary_month";
		$data = $this->Common_model->get_all_employee_for_selection($dept,$section,$line,$desig,$sex,$status,$salary_month,$unit,$w_type,$position);

		$i = 0;
		foreach($data->result_array() as $row)
		{
			$responce->rows[$i]['id']=$row['emp_id'];
			$responce->rows[$i]['cell']=array($row['emp_id'],$row['emp_full_name'],$row['emp_dob']);
			$i++;
		}
		echo json_encode($responce);
		exit;


	}


	function grid_daily_absent_report()
	{
		// exit('hui');
		$grid_date = $this->input->post('firstdate');
		$unit_id = $this->input->post('unit_id');
		list($date, $month, $year) = explode('-', trim($grid_date));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->grid_daily_absent_report($year, $month, $date, $status, $grid_emp_id);
		// print_r($data["values"]);
		// exit;

		$data["year"]			= $year;
		$data["month"]			= $month;
		$data["date"]			= $date;
		$data["daily_status"]	= $status;
		$data["unit_id"] 		= $unit_id;
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('daily_absent_report',$data);
		}
	}

	function grid_leave_application_form()
	{
		$firstdate	= $this->input->post('firstdate');
		$seconddate = $this->input->post('seconddate');
		//list($date, $month, $year) = explode('-', trim($grid_date));
		$leave_type = $this->input->post('leave_type');
		$emp_id		= $this->input->post('emp_id');
		//$grid_emp_id = explode(',', trim($grid_data));
		$unit_id= $this->db->where("unit_id",1)->get('pr_emp_com_info')->row()->unit_id;

		$data["values"] 	= $this->Grid_model->grid_leave_application_form($firstdate,$seconddate,$leave_type,$emp_id);
		$data["firstdate"]	= date("d-m-Y",strtotime($firstdate));
		$data["seconddate"]	= date("d-m-Y",strtotime($seconddate));
		$data["leave_type"]	= $leave_type;
		$data["unit_id"]	= $unit_id;
		$data["emp_id"]		= $emp_id;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('leave_application',$data);
		}
	}

	function grid_daily_late_report()
	{
		$grid_date = $this->input->post('firstdate');
		list($date, $month, $year) = explode('-', trim($grid_date));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		$data["values"] = $this->Grid_model->grid_daily_late_report($year, $month, $date, $grid_emp_id);
		$data["year"]			= $year;
		$data["month"]			= $month;
		$data["date"]			= $date;
		$data["col_desig"] 		= "";
		$data["col_line"] 		= "";
		$data["col_section"] 	= "";
		$data["col_dept"] 		= "";
		$data["col_all"] 		= "";
		$data["unit_id"] 		= $unit_id;
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('daily_late_report',$data);
		}
		//print_r($data);
	}

	function grid_daily_out_punch_miss_report()
	{
		$grid_date = $this->input->post('firstdate');
		list($date, $month, $year) = explode('-', trim($grid_date));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');


		$data["values"] = $this->Grid_model->grid_daily_out_punch_miss_report($year, $month, $date, $grid_emp_id);
		$data["year"]			= $year;
		$data["month"]			= $month;
		$data["date"]			= $date;
		$data["col_desig"] 		= "";
		$data["col_line"] 		= "";
		$data["col_section"] 	= "";
		$data["col_dept"] 		= "";
		$data["col_all"] 		= "";
		$data["unit_id"] 		= $unit_id;
		// echo "<pre>"; print_r($data); exit;

		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('out_punch_miss',$data);
		}
		//print_r($data);
	}

	function grid_daily_out_in_report()
	{

		$grid_date = $this->input->post('firstdate');
		list($date, $month, $year) = explode('-', trim($grid_date));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);
		$data["values"] = $this->Grid_model->grid_daily_out_in_report($year, $month, $date, $status, $grid_emp_id);

		$data["year"]			= $year;
		$data["month"]			= $month;
		$data["date"]			= $date;
		$data["daily_status"]	= $status;
		$data["col_desig"] 		= "";
		$data["col_line"] 		= "";
		$data["col_section"] 	= "";
		$data["col_dept"] 		= "";
		$data["col_all"] 		= "";
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('daily_out_in_report',$data);
		}
	}

	function grid_daily_actual_out_in_report()
	{
		//$year = "2011";
		//$month= "04";
		//$date = "18";
		//$status = "P";
		$grid_date = $this->input->post('firstdate');
		list($date, $month, $year) = explode('-', trim($grid_date));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$unit_id = $this->input->post('unit_id');

		//echo "$date, $month, $year";
		$status = 'P';
		//print_r($grid_emp_id);
		$data["values"] = $this->Grid_model->grid_daily_actual_out_in_report($year, $month, $date, $status, $grid_emp_id);

		$data["unit_id"]			= $unit_id;
		$data["year"]			= $year;
		$data["month"]			= $month;
		$data["date"]			= $date;
		$data["daily_status"]	= $status;
		$data["col_desig"] 		= "";
		$data["col_line"] 		= "";
		$data["col_section"] 	= "";
		$data["col_dept"] 		= "";
		$data["col_all"] 		= "";
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('daily_actual_out_in_report',$data);
		}
	}


	function grid_daily_holiday_weekend_present_report(){
		$grid_date = $this->input->post('firstdate');
		list($date, $month, $year) = explode('-', trim($grid_date));
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('grid_start');
		$status = 'P';
		$data["values"] = $this->Grid_model->grid_daily_holiday_weekend_present_report($year, $month, $date, $status, $grid_emp_id);
		$data["year"]			= $year;
		$data["month"]			= $month;
		$data["date"]			= $date;
		$data["daily_status"]	= $status;
		$data["unit_id"]		= $unit_id;

		if(is_string($data["values"])){
			echo $data["values"];
		}
		else{
			// exit;
			$this->load->view('daily_holiday_weekend_present_report',$data);
		}
	}




	function grid_continuous_report_limit()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$status = $this->input->post('status');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');
		$limit = $this->input->post('limit');

		$data["values"] = $this->Grid_model->continuous_report_limit($grid_firstdate, $grid_seconddate, $status, $grid_emp_id, $limit);

		if($status =="A")
		{
			$status = "Absent";
		}
		elseif($status =="P")
		{
			$status = "Present";
		}
		elseif($status =="L")
		{
			$status = "Leave";
		}
		elseif($status =="LA")
		{
			$status = "Late";
		}

		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));

		$data["status"] 	= $status;
		$data["start_date"] = $sStartDate;
		$data["end_date"] 	= $sEndDate;
		$data["unit_id"] 	= $unit_id;
		//print_r($data);
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('continuous_report',$data);
		}
	}

	function grid_continuous_late_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));

		//$status="Present Report from date $start_date to date  $end_date";

		$data["values"] = $this->Grid_model->continuous_late_report($sStartDate, $sEndDate, $grid_emp_id);



		$data["start_date"] = $sStartDate;
		$data["end_date"] 	= $sEndDate;
		$data["unit_id"] 	= $unit_id;
		//print_r($data);
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('continuous_late_report',$data);
		}
	}



	function continuous_line_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));
		$data["values"] = $this->Grid_model->continuous_line_report($sStartDate,$sEndDate,$grid_emp_id);
		$data["start_date"] = $sStartDate;
		$data["end_date"] = $sEndDate;
		$data["unit_id"] = $unit_id;
		//print_r($data);
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('continuous_line_report',$data);
		}

	}

	function continuous_increment_promotion_proposal()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		$sStartDate = date("Y-m-d", strtotime($grid_firstdate));
		$sEndDate = date("Y-m-d", strtotime($grid_seconddate));

		$data["values"] = $this->Grid_model->continuous_increment_promotion_proposal($sStartDate,$sEndDate,$grid_emp_id);

		$data["start_date"] = $sStartDate;
		$data["end_date"] = $sEndDate;
		$data["unit_id"] = $unit_id;
		//print_r($data);
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{
			$this->load->view('continuous_increment_promotion_proposal',$data);
		}

	}

	function grid_app_letter(){
		$grid_data = $this->input->post('emp_ids');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');
		$data['values'] 	= $this->Grid_model->grid_app_letter($grid_emp_id);
		$data['unit_id']	= $unit_id;

		if(is_string($data['values'])){
			echo $data['values'];
		}
		else{
			$this->load->view('appointment_letter',$data);
		}
	}


	function grid_join_letter(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');
		$query['unit_id'] = $this->input->post('unit_id');
		$query['values'] = $this->Grid_model->grid_emp_job_application($grid_emp_id);
		$query['unit_id'] = $this->input->post('unit_id');
		if(is_string($query['values'])){
			echo $query['values'];
		}else{
			$this->load->view('stuff',$query);
		}
	}

	function grid_pay_slip()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$unit_id = $this->input->post('unit_id');

		$year_month = date("Y-m", strtotime($grid_firstdate));

		$query['values'] = $this->Grid_model->grid_pay_slip($year_month, $grid_emp_id);
		$query['values'] = $unit_id;
		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('pay_slip',$query);
		}
	}


	function grid_auto_notify_FW()
	{
		// echo "hi";exit;
		$firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('grid_emp_id');
		$grid_emp_id = explode('***', trim($grid_data));

		/*print_r($grid_emp_id);
		exit;*/
		$year_month = date("Y-m", strtotime($firstdate));

		$query = $this->Grid_model->grid_monthly_att_register_auto($year_month, $grid_emp_id);

		if(is_string($query))
		{
			echo $query;
		}
		else
		{
			$year_month = date("M-Y", strtotime($firstdate));
			$data["value"]=$query;
			$data["year_month"] = $year_month;
			$this->load->view('monthly_report_auto',$data);
		}
	}


	function grid_auto_notify_SW()
	{
		// echo "hi";exit;
		$firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('grid_emp_id');
		$grid_emp_id = explode('***', trim($grid_data));

		/*print_r($grid_emp_id);
		exit;*/
		$year_month = date("Y-m", strtotime($firstdate));

		$query = $this->Grid_model->grid_monthly_att_register_auto($year_month, $grid_emp_id);

		if(is_string($query))
		{
			echo $query;
		}
		else
		{
			$year_month = date("M-Y", strtotime($firstdate));
			$data["value"]=$query;
			$data["year_month"] = $year_month;
			$this->load->view('monthly_report_auto_sw',$data);
		}
	}

	function grid_auto_notify_TW()
	{
		// echo "hi";exit;
		$firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('grid_emp_id');
		$grid_emp_id = explode('***', trim($grid_data));

		/*print_r($grid_emp_id);
		exit;*/
		$year_month = date("Y-m", strtotime($firstdate));

		$query = $this->Grid_model->grid_monthly_att_register_auto($year_month, $grid_emp_id);

		if(is_string($query))
		{
			echo $query;
		}
		else
		{
			$year_month = date("M-Y", strtotime($firstdate));
			$data["value"]=$query;
			$data["year_month"] = $year_month;
			$this->load->view('monthly_report_auto_tw',$data);
		}
	}

	function grid_auto_notify_LW()
	{
		// echo "hi";exit;
		$firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('grid_emp_id');
		$grid_emp_id = explode('***', trim($grid_data));

		/*print_r($grid_emp_id);
		exit;*/
		$year_month = date("Y-m", strtotime($firstdate));

		$query = $this->Grid_model->grid_monthly_att_register_auto($year_month, $grid_emp_id);

		if(is_string($query))
		{
			echo $query;
		}
		else
		{
			$year_month = date("M-Y", strtotime($firstdate));
			$data["value"]=$query;
			$data["year_month"] = $year_month;
			$this->load->view('monthly_report_auto_lw',$data);
		}
	}

	function grid_pf_statement()
	{
		$year  = $this->uri->segment(3);
		$month = $this->uri->segment(4);

		$grid_data = $this->uri->segment(5);
		$grid_emp_id = explode(',', trim($grid_data));

		$query['values'] = $this->Grid_model->grid_pf_statement($year, $month, $grid_emp_id);

		$query['year'] = $year;
		$query['month'] = $month;

		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('provident_fund_statement',$query);
		}
	}



	function grid_extra_ot_mix()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data['unit_id'] = $this->input->post('unit_id');

		$data['grid_firstdate'] = $grid_firstdate;
		$data['grid_seconddate'] = $grid_seconddate;

		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

		$data['values'] = $this->Grid_model->grid_extra_ot_mix($grid_firstdate, $grid_seconddate, $grid_emp_id);



		$this->load->view('ot_job_card',$data);

	}

	function manual_attendance_entry()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');

		$manual_time = $this->input->post('manual_time');

		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

		/*$grid_firstdate = "2011-07-02";
		$grid_seconddate = "2011-07-08";

		$manual_time = "08:00:00";

		$grid_data = "100005,100009,440004";
		$grid_emp_id = explode(',', trim($grid_data));*/

		$data = $this->Grid_model->manual_attendance_entry($grid_firstdate, $grid_seconddate, $manual_time, $grid_emp_id);
		echo $data;

	}

	function manual_entry_Delete()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');

		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));

		$data = $this->Grid_model->manual_entry_Delete($grid_firstdate, $grid_seconddate, $grid_emp_id);
		echo $data;

	}

	function save_work_off()
	{
		$grid_firstdate = $this->input->post('firstdate');

		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data = $this->Grid_model->save_work_off($grid_firstdate, $grid_emp_id);
		echo $data;

	}

	function save_holiday()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$holiday_description = $this->input->post('holiday_description');

		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data = $this->Grid_model->save_holiday($grid_firstdate, $holiday_description);
		echo $data;

	}

	function grid_monthly_salary_sheet()
	{
		$sal_year_month = $this->input->post('sal_year_month');
		$grid_status 	= $this->input->post('grid_status');
		$grid_data 		= $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);

		$data["value"] = $this->Grid_model->grid_monthly_salary_sheet($sal_year_month, $grid_status, $grid_emp_id);
		$data["salary_month"] = $sal_year_month;
		$data["grid_status"]  = $grid_status;
		$data['unit_id'] = $this->input->post('unit_id');

		$this->load->view('salary_sheet',$data);
	}

	function grid_current_info()
	{
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);

		$data["values"] = $this->Grid_model->grid_current_info($grid_emp_id);
		$data['unit_id'] = $this->input->post('unit_id');
		$data['grid_emp_id'] = $grid_emp_id;

		$this->load->view('current_info',$data);
	}



	function general_info_excel()
	{
		$sal_year_month = $this->input->post('sal_year_month');
		$grid_data 		= $this->input->post('grid_emp_id');
		$grid_emp_id = explode(',', trim($grid_data));

		$data["values"] = $this->Grid_model->grid_general_info($grid_emp_id);
		$this->load->view('general_info_excel',$data);
	}

	function ot_hour_search()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$search_ot_hour = $this->input->post('ot_hour');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data["values"]  = $this->Grid_model->ot_hour_search($grid_firstdate,$search_ot_hour,$grid_emp_id);
		$data["search_ot_hour"] = $search_ot_hour;
		$data["grid_emp_id"] = $grid_emp_id;
		$data["grid_firstdate"] = $grid_firstdate;
		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('ot_abstract', $data);
		}

	}

	function grid_employee_information(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);

		$data["values"] = $this->Grid_model->grid_employee_information($grid_emp_id);
		$data['unit_id'] = $this->input->post('unit_id');

		$this->load->view('employee_information',$data);
	}

	function grid_service_book(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"] = $this->Grid_model->grid_employee_information($grid_emp_id);
		$data['unit_id'] = $this->input->post('unit_id');
		$this->load->view('service_book',$data);
	}

	function grid_final_satalment_edit(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$datas =$this->Grid_model->grid_employee_information($grid_emp_id);
		// dd($data[0]);
		$db_row = $this->db->select('*')->where_in('emp_id',$grid_emp_id)->get('pr_emp_resign_history')->row();
		$data = array_merge((array) $datas[0], (array) $db_row);
		echo json_encode($data);
	}

	function grid_service_book2()
	{
		$grid_data = $this->uri->segment(3);
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);

		$data["value"] = $this->Grid_model->grid_service_book2($grid_emp_id);

		$this->load->view('service_book_full',$data);
	}

	function grid_service_benifit()
	{
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		//print_r($grid_emp_id);

		$data["values"] = $this->Grid_model->grid_service_benifit($grid_emp_id);
		$data['unit_id'] = $this->input->post('unit_id');

		$this->load->view('service_benifit',$data);
	}

	function salary_summary()
	{
		$salary_month = $this->uri->segment(3);
		$data["values"] = $this->Grid_model->salary_summary($salary_month);
		$data["salary_month"] = $salary_month;
		//print_r($data);
		$this->load->view('salary_summary',$data);
	}

	function grid_bgm_new_join_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));

		$data['values'] = $this->Grid_model->grid_bgm_new_join_report($grid_firstdate, $grid_seconddate, $grid_emp_id);

		$data['start_date']= $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id'] = $this->input->post('unit_id');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('new_bgm_join_emp_report',$data);
		}
	}



	function grid_resign_report_with_sal()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));

		$data['values'] = $this->Grid_model->grid_resign_report_with_sal($grid_firstdate, $grid_seconddate, $grid_emp_id);
		// echo print_r($data['values']);exit;
		$data['start_date'] = $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id'] = $this->input->post('grid_start');
		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('resign_emp_report_sal',$data);
		}
	}

	function grid_left_report_with_sal()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));

		$data['values'] = $this->Grid_model->grid_left_report_with_sal($grid_firstdate, $grid_seconddate, $grid_emp_id);
		// echo print_r($data['values']);exit;
		$data['start_date'] = $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id'] = $this->input->post('grid_start');
		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('left_emp_report_sal',$data);
		}
	}

	function grid_bgm_resign_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));

		$data['values'] = $this->Grid_model->grid_bgm_resign_report($grid_firstdate, $grid_seconddate, $grid_emp_id);

		$data['start_date']= $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id'] = $this->input->post('grid_start');
		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('resign_bgm_emp_report',$data);
		}
	}


	function grid_bgm_left_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		//echo "$grid_firstdate, $grid_seconddate";
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));
		//echo "$grid_firstdate, $grid_seconddate";
		$data['values'] = $this->Grid_model->grid_bgm_left_report($grid_firstdate, $grid_seconddate, $grid_emp_id);

		$data['start_date']= $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id'] = $this->input->post('grid_start');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('left_bgm_emp_report',$data);
		}
	}


	function grid_bgm_left_resign_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_seconddate = $this->input->post('seconddate');
		//$grid_data = $this->input->post('spl');
		//$grid_emp_id = explode(',', trim($grid_data));
		//echo "$grid_firstdate, $grid_seconddate";
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));
		$grid_seconddate  = date("Y-m-d", strtotime($grid_seconddate));
		$unit_id = $this->input->post('grid_start');
		//echo "$grid_firstdate, $grid_seconddate";
		$data['values'] = $this->Grid_model->grid_bgm_left_resign_report($grid_firstdate, $grid_seconddate, $unit_id);

		$data['start_date']= $grid_firstdate;
		$data['end_date'] 	= $grid_seconddate;
		$data['unit_id'] = $this->input->post('grid_start');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('left_resign_bgm_emp_report',$data);
		}
	}



	function grid_daily_eot()
	{
		$this->load->model('Common_model');
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_daily_eot($grid_firstdate, $grid_emp_id);

		$data['start_date']= $this->input->post('firstdate');
		$data['unit_id'] = $this->input->post('unit_id');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('daily_eot',$data);
		}
	}

	function grid_daily_ot()
	{
		$this->load->model('Common_model');
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_daily_ot($grid_firstdate, $grid_emp_id);

		$data['start_date']= $this->input->post('firstdate');
		$data['unit_id'] = $this->input->post('unit_id');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('daily_ot',$data);
		}
	}
	function grid_daily_night_allowance_report()
	{
		$this->load->model('Common_model');
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_daily_night_allowance_report($grid_firstdate, $grid_emp_id);

		$data['start_date']= $this->input->post('firstdate');
		$data['unit_id'] = $this->input->post('unit_id');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('daily_night_allowance_report',$data);
		}
	}
	function grid_daily_allowance_bills()
	{
		$this->load->model('Common_model');
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_daily_allowance_bills($grid_firstdate, $grid_emp_id);

		$data['start_date']= $this->input->post('firstdate');
		$data['unit_id'] = $this->input->post('unit_id');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('daily_allowance_bills',$data);
		}
	}

	function grid_daily_weekend_allowance_sheet()
	{
		// echo "hi";
		$this->load->model('Common_model');
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_daily_weekend_allowance_sheet($grid_firstdate, $grid_emp_id);

		$data['start_date']= $this->input->post('firstdate');
		$data['unit_id'] = $this->input->post('unit_id');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('daily_weekend_allowance_bills',$data);
		}
	}

	function grid_daily_holiday_allowance_sheet()
	{
		// echo "hi";
		$this->load->model('Common_model');
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$grid_firstdate  = date("Y-m-d", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_daily_holiday_allowance_sheet($grid_firstdate, $grid_emp_id);

		$data['start_date']= $this->input->post('firstdate');
		$data['unit_id'] = $this->input->post('unit_id');

		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('daily_holiday_allowance_bills',$data);
		}
	}

	function grid_monthly_allowance_register()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_monthly_allowance_register($grid_firstdate, $grid_emp_id);

		$data['start_date']= $grid_firstdate;
		$data['unit_id'] = $this->input->post('unit_id');
		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('monthly_allowance_register',$data);
		}
	}

	function grid_daily_move_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$unit_id= $this->input->post('unit_id');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$query['values'] = $this->Grid_model->daily_move_report($grid_firstdate, $grid_emp_id);

		$query['grid_firstdate'] = $grid_firstdate;
		$query['unit_id'] = $unit_id;


		if(is_string($query['values']))
		{
			echo $query['values'];
		}
		else
		{
			$this->load->view('daily_move_report',$query);
		}
	}

	function grid_daily_punch_report()
	{
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));

		$grid_firstdate  = date("Y-m", strtotime($grid_firstdate));

		$data['values'] = $this->Grid_model->grid_time_search_report($grid_firstdate, $grid_emp_id);

		$data['start_date']= $grid_firstdate;
		$data['unit_id'] = $this->input->post('unit_id');
		if(is_string($data['values']))
		{
			echo $data['values'];
		}
		else
		{
			$this->load->view('monthly_ot_register',$data);
		}

		$f_date = '2012-04-10';
		$s_date = '2012-04-10';
		$f_time = '17:00:00';
		$s_time = '20:00:00';
		$grid_emp_id = array('001414','001635','001744','001750','001773','002070','002090','002110','002113','002178');

		$this->Grid_model->grid_time_search_report();

	}

	function test()
	{
		$sStartDate = '2012-04-01';
		$emp_id = '003915';
		$sEndDate = '2012-04-30';
		echo $this->Grid_model->get_resign_date($emp_id, $sStartDate, $sEndDate);
	}

	function grid_earn_leave_report(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim( (string) $grid_data ) );
		$data['values'] = $this->Grid_model->grid_earn_leave_report($grid_emp_id);
		// dd($data);
		if(is_string($data['values'])){
			echo $data['values'];
		} else {
			$this->load->view('earn_leave_report',$data);
		}
	}

	function earn_leave_pay(){
		$year = $this->input->post('year');
		$pay_date = $this->input->post('pay_date');
		$unit_id = $this->input->post('unit_id');
		$ids  = $this->input->post('spl');
		$emp_ids = explode(',',trim( $ids ));
		$pay_leave = $this->Grid_model->earn_leave_pay($year,$pay_date,$emp_ids,$unit_id);
		echo $pay_leave;
	}
	function earn_leave_list(){
		$year = $this->input->post('year');
		$pay_date = $this->input->post('pay_date');
		$unit_id = $this->input->post('unit_id');
		$ids  = $this->input->post('spl');
		$emp_ids = explode(',',trim( $ids ));
		$data['values'] = $this->Grid_model->earn_leave_list($year,$pay_date,$emp_ids,$unit_id);
		// dd($data);

		$this->load->view('earn_leave_list_report',$data);

		// echo $pay_leave;
	}


	function delete(){
		$id = $this->input->get('id');
		$query = $this->db->where('id', $id)->delete('pr_earn_leave_paid');

		if($query){
			echo "Deleted";
		}
		else{
			echo "Failed";
		}

	}


	public  function grid_com_salessssss(){
		// exit('ok');
		$this->db->select('pr_emp_com_info.emp_id, pr_emp_com_info.gross_sal');
		$this->db->from('pr_emp_com_info');
		$query = $this->db->get();

		foreach($query->result() as $row)
		{
			$data['com_gross_sal'] = $row->gross_sal;
			$this->db->where("emp_id", $row->emp_id);
			$this->db->update("pr_emp_com_info",$data);
		}
		echo "done";

	}

	function grid_service_book_info(){
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode('xxx', trim($grid_data));

		$data["values"] = $this->Grid_model->service_book_info($grid_emp_id);
		//dd($data);
		$data['unit_id'] = $this->input->post('unit_id');

		$this->load->view('service_book_info',$data);
	}

	function grid_monthly_night_register(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data['unit_id'] = $this->input->post('unit_id');
		$query=$this->Grid_model->grid_monthly_night_register($grid_firstdate,$grid_emp_id);
		if(is_string($query)){
			echo $query;
		}else{
			$data["value"] = $query;
			$data["year_month"] = date("M-Y", strtotime($grid_firstdate));
			$this->load->view('monthly_report_night',$data);
		}
	}


	function grid_monthly_ifter_register(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data['unit_id'] = $this->input->post('unit_id');
		$query=$this->Grid_model->grid_monthly_ifter_register($grid_firstdate,$grid_emp_id);
		if(is_string($query)){
			echo $query;
		}else{
			$data["value"] = $query;
			$data["year_month"] = date("M-Y", strtotime($grid_firstdate));
			$this->load->view('monthly_report_ifter',$data);
		}
	}
	function grid_monthly_weekend_register(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data['unit_id'] = $this->input->post('unit_id');
		$query=$this->Grid_model->grid_monthly_weekend_register($grid_firstdate,$grid_emp_id);
		if(is_string($query)){
			echo $query;
		}else{
			$data["value"] = $query;
			$data["year_month"] = date("M-Y", strtotime($grid_firstdate));
			$this->load->view('monthly_report_weekend',$data);
		}
	}
	function grid_monthly_holiday_register(){
		$grid_firstdate = $this->input->post('firstdate');
		$grid_data = $this->input->post('spl');
		$grid_emp_id = explode(',', trim($grid_data));
		$data['unit_id'] = $this->input->post('unit_id');
		$query=$this->Grid_model->grid_monthly_holiday_register($grid_firstdate,$grid_emp_id);
		if(is_string($query)){
			echo $query;
		}else{
			$data["value"] = $query;
			$data["year_month"] = date("M-Y", strtotime($grid_firstdate));
			$this->load->view('monthly_report_holiday',$data);
		}
	}

	function grid_employee_background(){
		$grid_data = $this->input->post('emp_id');
		$grid_emp_id = explode(',', trim($grid_data));
		$data["values"]=$this->Grid_model->grid_employee_background($grid_emp_id);
		$this->load->view('employee_background',$data);
	}


}
?>

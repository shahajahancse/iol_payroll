<?php
class Common_model extends CI_Model{


	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
	}

	function salary_structure($gross_salary)
	{
		$data = array();
		$date = date('Y-m-d');
		if($date > '2018-11-31')
		{
			$data['medical_allow'] 	= 750;
			$data['trans_allow'] 	= 450;
			$data['food_allow'] 	= 1250;
			$total_salary_allow 	= $data['medical_allow'] + $data['trans_allow'] + $data['food_allow'];
			$data['gross_salary'] 	= $gross_salary;
			$basic_salary 			= (($gross_salary - $total_salary_allow) / 1.5);
			$data['basic_sal'] 	   = round($basic_salary);
			$data['house_rent']    = round($basic_salary * 50 / 100);
			$data['ot_rate']       = round(($data['basic_sal'] * 2  / 208),2);
			//$data['ot_rate']       = round(($gross_salary - $data['basic_sal']/1.5 * 208),2);
			$data['stamp'] = 0;

		}else{

			$data['medical_allow'] 	= 250;
			$data['trans_allow'] 	= 200;
			$data['food_allow'] 	= 650;
			$total_salary_allow 	= $data['medical_allow'] + $data['trans_allow'] + $data['food_allow'];
			$data['gross_salary'] 	= $gross_salary;
			$basic_salary 			= (($gross_salary - $total_salary_allow) / 1.4);
			$data['basic_sal'] 	   = round($basic_salary);
			$data['house_rent']    = round($basic_salary * 40 / 100);
			$data['ot_rate']       = round(($data['basic_sal'] * 2  / 208),2);
			$data['stamp'] = 0;

		}
		// dd($basic_salary/71.15);


		if($gross_salary == 0)
		{
			$data['medical_allow'] 	= 0;
			$data['trans_allow'] 	= 0;
			$data['food_allow'] 	= 0;
			$data['gross_salary'] 	= 0;
			$data['basic_sal'] 	   	= 0;
			$data['house_rent']    	= 0;
			$data['ot_rate']       	= 0;
			$data['stamp'] 			= 0;
		}

		return $data;
	}

	function get_emp_by_unit($id){
		$this->db->select('com.id, com.emp_id, per.name_en, per.name_bn');
		$this->db->from('pr_emp_com_info as com');
		$this->db->join('emp_designation as deg', 'deg.id = com.emp_desi_id', 'left');
		$this->db->join('pr_emp_per_info as per', 'per.emp_id = com.emp_id', 'left');
		$this->db->where('deg.hide_status', 1);
		$this->db->where('com.emp_cat_id', 1);
		// $this->db->group_by('com.id');
		return $this->db->where('com.unit_id', $id)->get()->result();
	}


	function get_group_name(){
		$this->db->select("emp_group_dasignation.*, pr_units.unit_name");
		$this->db->from("emp_group_dasignation");
		$this->db->from("pr_units");
		$this->db->where('pr_units.unit_id = emp_group_dasignation.unit_id');
		return $this->db->get()->result();
	}

	function get_group_wise_attendance($line_id, $date, $unit_id, $array){
		// dd($array['Operator']);
		// dd($array);
		// $line_id = 218;
		if (!empty($array['Operator'])) {
			$this->db->select("
		                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS total_emp,
		                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS emp_present,
		                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS emp_absent,
		                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS emp_leave,
					");
			$this->db->from("pr_emp_shift_log as log");
			$this->db->from('pr_emp_com_info as com');
			$this->db->from('emp_line_num as num');
			$this->db->from('emp_designation as desig');
			$this->db->where("desig.id = com.emp_desi_id");
			$this->db->where("desig.hide_status", 1);
			$this->db->where("log.emp_id = com.emp_id");
			$this->db->where("num.id = com.emp_line_id");

			$this->db->where("com.emp_line_id", $line_id);
			$this->db->where("com.unit_id", $unit_id);
			$this->db->where("log.shift_log_date", $date);
			// $this->db->where("log.in_time !=", "00:00:00");
			$this->db->where_in("com.emp_desi_id", $array['Operator']);
			$this->db->group_by("log.shift_log_date");
			$d['Operator'] = $this->db->get()->row();
		} else {
			$d['Operator'] = new stdClass();
		}

		if (!empty($array['Helper'])) {
			$this->db->select("
		                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS total_emp,
		                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS emp_present,
		                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS emp_absent,
		                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS emp_leave,
					");
			$this->db->from("pr_emp_shift_log as log");
			$this->db->from('pr_emp_com_info as com');
			$this->db->from('emp_line_num as num');
			$this->db->from('emp_designation as desig');
			$this->db->where("desig.id = com.emp_desi_id");
			$this->db->where("desig.hide_status", 1);
			$this->db->where("log.emp_id = com.emp_id");
			$this->db->where("num.id = com.emp_line_id");

			$this->db->where("com.emp_line_id", $line_id);
			$this->db->where("com.unit_id", $unit_id);
			$this->db->where("log.shift_log_date", $date);
			// $this->db->where("log.in_time !=", "00:00:00");
			$this->db->where_in("com.emp_desi_id", $array['Helper']);
			$this->db->group_by("log.shift_log_date");
			$d['Helper'] = $this->db->get()->row();
		} else {
			$d['Helper'] = new stdClass();
		}

		if (!empty($array['Iron Man'])) {
			$this->db->select("
		                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS total_emp,
		                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS emp_present,
		                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS emp_absent,
		                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS emp_leave,
					");
			$this->db->from("pr_emp_shift_log as log");
			$this->db->from('pr_emp_com_info as com');
			$this->db->from('emp_line_num as num');
			$this->db->from('emp_designation as desig');
			$this->db->where("desig.id = com.emp_desi_id");
			$this->db->where("desig.hide_status", 1);
			$this->db->where("log.emp_id = com.emp_id");
			$this->db->where("num.id = com.emp_line_id");

			$this->db->where("com.emp_line_id", $line_id);
			$this->db->where("com.unit_id", $unit_id);
			$this->db->where("log.shift_log_date", $date);
			// $this->db->where("log.in_time !=", "00:00:00");
			$this->db->where_in("com.emp_desi_id", $array['Iron Man']);
			$this->db->group_by("log.shift_log_date");
			$d['Iron Man'] = $this->db->get()->row();
		} else {
			$d['Iron Man'] = new stdClass();
		}

		if (!empty($array['Line Chief'])) {
			$this->db->select("
		                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS total_emp,
		                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS emp_present,
		                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS emp_absent,
		                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS emp_leave,
					");
			$this->db->from("pr_emp_shift_log as log");
			$this->db->from('pr_emp_com_info as com');
			$this->db->from('emp_line_num as num');
			$this->db->from('emp_designation as desig');
			$this->db->where("desig.id = com.emp_desi_id");
			$this->db->where("desig.hide_status", 1);
			$this->db->where("log.emp_id = com.emp_id");
			$this->db->where("num.id = com.emp_line_id");

			$this->db->where("com.attn_sum_line_id", $line_id);
			$this->db->where("com.unit_id", $unit_id);
			$this->db->where("log.shift_log_date", $date);
			// $this->db->where("log.in_time !=", "00:00:00");
			$this->db->where_in("com.emp_desi_id", $array['Line Chief']);
			$this->db->group_by("log.shift_log_date");
			$d['Line Chief'] = $this->db->get()->row();
		} else {
			$d['Line Chief'] = new stdClass();
		}

		if (!empty($array['F.Q.I'])) {
			$this->db->select("
		                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS total_emp,
		                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS emp_present,
		                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS emp_absent,
		                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS emp_leave,
					");
			$this->db->from("pr_emp_shift_log as log");
			$this->db->from('pr_emp_com_info as com');
			$this->db->from('emp_line_num as num');
			$this->db->from('emp_designation as desig');
			$this->db->where("desig.id = com.emp_desi_id");
			$this->db->where("desig.hide_status", 1);
			$this->db->where("log.emp_id = com.emp_id");
			$this->db->where("num.id = com.emp_line_id");

			$this->db->where("com.emp_line_id", $line_id);
			$this->db->where("com.unit_id", $unit_id);
			$this->db->where("log.shift_log_date", $date);
			// $this->db->where("log.in_time !=", "00:00:00");
			$this->db->where_in("com.emp_desi_id", $array['F.Q.I']);
			$this->db->group_by("log.shift_log_date");
			$d['F.Q.I'] = $this->db->get()->row();
		} else {
			$d['F.Q.I'] = new stdClass();
		}

		if (!empty($array['Supervisor'])) {
			$this->db->select("
		                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS total_emp,
		                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS emp_present,
		                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS emp_absent,
		                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS emp_leave,
					");
			$this->db->from("pr_emp_shift_log as log");
			$this->db->from('pr_emp_com_info as com');
			$this->db->from('emp_line_num as num');
			$this->db->from('emp_designation as desig');
			$this->db->where("desig.id = com.emp_desi_id");
			$this->db->where("desig.hide_status", 1);
			$this->db->where("log.emp_id = com.emp_id");
			$this->db->where("num.id = com.emp_line_id");

			$this->db->where("com.attn_sum_line_id", $line_id);
			$this->db->where("com.unit_id", $unit_id);
			$this->db->where("log.shift_log_date", $date);
			// $this->db->where("log.in_time !=", "00:00:00");
			$this->db->where_in("com.emp_desi_id", $array['Supervisor']);
			$this->db->group_by("log.shift_log_date");
			$d['Supervisor'] = $this->db->get()->row();
		} else {
			$d['Supervisor'] = new stdClass();
		}

		if (!empty($array['Input Man'])) {
			$this->db->select("
		                SUM( CASE WHEN log.emp_id 		  != '' THEN 1 ELSE 0 END ) AS total_emp,
		                SUM( CASE WHEN log.present_status = 'P' THEN 1 ELSE 0 END ) AS emp_present,
		                SUM( CASE WHEN log.present_status = 'A' THEN 1 ELSE 0 END ) AS emp_absent,
		                SUM( CASE WHEN log.present_status = 'L' THEN 1 ELSE 0 END ) AS emp_leave,
					");
			$this->db->from("pr_emp_shift_log as log");
			$this->db->from('pr_emp_com_info as com');
			$this->db->from('emp_line_num as num');
			$this->db->from('emp_designation as desig');
			$this->db->where("desig.id = com.emp_desi_id");
			$this->db->where("desig.hide_status", 1);
			$this->db->where("log.emp_id = com.emp_id");
			$this->db->where("num.id = com.emp_line_id");

			$this->db->where("com.emp_line_id", $line_id);
			$this->db->where("com.unit_id", $unit_id);
			$this->db->where("log.shift_log_date", $date);
			// $this->db->where("log.in_time !=", "00:00:00");
			$this->db->where_in("com.emp_desi_id", $array['Input Man']);
			$this->db->group_by("log.shift_log_date");
			$d['Input Man'] = $this->db->get()->row();
		} else {
			$d['Input Man'] = new stdClass();
		}
		// dd($d);
		return $d;
	}

	function get_shift_log($row, $emp_id, $first_date, $second_date){
        // joining date  checking
        if ($row->emp_join_date > $first_date) {
            $first_date = $row->emp_join_date;
        }
        // left date checking
		$this->db->select('left_date');
		$this->db->where("left_date BETWEEN '$first_date' AND '$second_date'");
		$this->db->where_in("emp_id", $emp_id);
		$query = $this->db->get("pr_emp_left_history");
		if($query->num_rows() > 0)
		{
			$second_date = $query->row()->left_date;
		}
        // resign date checking
        $this->db->select('resign_date');
		$this->db->where("resign_date BETWEEN '$first_date' AND '$second_date'");
		$this->db->where_in("emp_id", $emp_id);
		$rquery = $this->db->get("pr_emp_resign_history");
		if($rquery->num_rows() > 0)
		{
			$second_date = $rquery->row()->resign_date;
		}

        $i = 0;
        $logs = array();
        while($first_date <= $second_date)
		{
            $logs[$i]['date'] = $first_date;
            $this->db->select('
                    pr_emp_shift_log.in_time,
                    pr_emp_shift_log.out_time,
                    pr_emp_shift_log.shift_log_date,
                    pr_emp_shift_log.ot,
                    pr_emp_shift_log.eot,
                    pr_emp_shift_log.present_status,
					pr_emp_shift_schedule.sh_type as shift_name
                ');
            $this->db->from('pr_emp_shift_log');
			$this->db->from('pr_emp_shift_schedule');
            $this->db->where_in('pr_emp_shift_log.emp_id', $emp_id);
            $this->db->where("pr_emp_shift_log.shift_log_date", $first_date);
			$this->db->where('pr_emp_shift_schedule.id = pr_emp_shift_log.schedule_id');
            $shift = $this->db->get()->row();

            if(!empty($shift)){
                $logs[$i]["in_time"] 	= $shift->in_time;
                $logs[$i]["out_time"] 	= $shift->out_time;
                $logs[$i]["shift_name"] = $shift->shift_name;
                $logs[$i]["present_status"] = $shift->present_status;
            }
            else
            {
                $logs[$i]["in_time"] 	= '';
                $logs[$i]["out_time"] 	= '';
                $logs[$i]["shift_name"] = '';
                $logs[$i]["present_status"] = '';
            }
            $first_date = date("Y-m-d", strtotime("+1 day", strtotime($first_date)));
            $i = $i + 1;
     	}
		return $logs;
	}
















	///////////////////// ====================== ///////////////////////
	// old code
	function covert_english_date_to_bangla_date_with_day_name($currentDate){
		//$currentDate = date("l, F j, Y");
		//$currentDate = date("d F , Y");
		$engDATE = array(1,2,3,4,5,6,7,8,9,0,"January","February","March","April","May","June","July","August","September","October","November","December","Saturday","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday");
		$bangDATE = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
		বুধবার','বৃহস্পতিবার','শুক্রবার'
		);
		$convertedDATE = str_replace($engDATE, $bangDATE, $currentDate);

		return $convertedDATE;
	}

	function get_setup_attributes($setup_id)
	{
		$this->db->select('value');
		$this->db->where("id",$setup_id);
		$query = $this->db->get('pr_setup');
		$rows = $query->row();
		$setup_value = $rows ->value;
		return $setup_value;
	}

	function allowance_bills($id)
	{
		$data = array();
		$this->db->select('*');
		$this->db->where("id",$id);
		$query = $this->db->get('pr_allowance_bills');
		foreach($query->result() as $rows)
		{
			$data['first_tiffin_allo_min'] = $rows ->first_tiffin_allo_min;
			$data['second_tiffin_allo_min'] = $rows ->second_tiffin_allo_min;
			$data['night_allo_min'] = $rows ->night_allo_min;
			$data['first_tiffin_allo_amount'] = $rows ->tiffin_allo_amount;
			$data['second_tiffin_allo_amount'] = $rows ->tiffin_allo_amount;
			$data['night_allo_amount'] = $rows ->night_allo_amount;
			//echo $rows ->first_tiffin_allo_min;
		}

		return $data;
	}

	function get_ot_title($emp_id)
	{
		$this->db->select('ot_entitle');
		$this->db->where('emp_id',$emp_id);
		$query = $this->db->get('pr_emp_com_info');
		$row = $query->row();
		return $row->ot_entitle;
	}

	function get_service_month($effective_date,$doj)
	{
		$date_diff 		= strtotime($effective_date)-strtotime($doj);
		//DATE TO DATE RULE
		//return $month 	= floor(($date_diff)/2592000);

		//MONTH TO MONTH RULE
		return $month 	= ceil(($date_diff)/2628000);
	}

	function get_gross_salary($emp_id)
	{
		$this->db->select('gross_sal');
		$this->db->where('emp_id',$emp_id);
		$query = $this->db->get('pr_emp_com_info');
		$row = $query->row();
		return $row->gross_sal;
	}

	function company_information($unit_id)
	{
		if($unit_id == 0){
			return $company_infos = $this->db->get('company_infos')->result();
		}
		return $company_infos = $this->db->where('unit_id',$unit_id)->get('company_infos')->result();

		// return $query = $this->db->select('*')->get('company_infos')->row();
	}

	function company_info($unit_id)
	{
		return $query = $this->db->select('*')->where('unit_id',$unit_id)->get('company_infos')->row();
	}

	function bank_note_requisition($amount, $bank_notes)
	{
		//$bank_notes = array(1000,500,100,50,20,10,5,2,1);
		$data = array();

		foreach($bank_notes as $bank_note)
		{
			$note 		= floor($amount / $bank_note);
			$amount 	= $amount % $bank_note;
			$data[$bank_note] = $note;
		}
		return $data;
	}
	function  get_prev_month($probation_period,$year_month)
	{
		//$probation_period = $probation_period -1;

		$text ="-".$probation_period."month";
		$prev_month = strtotime($text, strtotime($year_month));
		$prev_month = date("Y-m", $prev_month);
		return $prev_month;
	}
	function get_left_emp($salary_month)
	{
		$i = 1;
		$this->db->select('pr_emp_left_history.emp_id');
		$this->db->from('pr_emp_left_history');
		$this->db->where("trim(substr(pr_emp_left_history.left_date,1,7)) <= '$salary_month'");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
		  foreach ($query->result() as $row)
		  {
			  $emp_id[] = $row->emp_id;
			  //echo "$i .$row->emp_id<br>";
			  //$i = $i + 1;

		  }
		  return $emp_id ;
		}
		else
		{
			return $emp_id = array('0'=>"abcd") ;
		}
	}
	function get_resign_emp($salary_month)
	{
		$i = 1;
		$this->db->select('pr_emp_resign_history.*');
		$this->db->from('pr_emp_resign_history');
		$this->db->where("trim(substr(pr_emp_resign_history.resign_date,1,7)) <= '$salary_month'");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
		  foreach ($query->result() as $row)
		  {
			  $emp_id[] = $row->emp_id;
			  //echo "$i .$row->emp_id<br>";
			  //$i = $i + 1;

		  }
		  return $emp_id ;
		}
		else
		{
			return $emp_id = array('0'=>"abcd") ;
		}
	}
	/*function get_all_employee_for_selection($dept,$section,$line,$desig,$sex,$status,$salary_month,$unit)
	{
		$get_left_emp 		= $this->get_left_emp_all_sts($salary_month);
		$get_resign_emp 	= $this->get_resign_emp_all_sts($salary_month);
		$get_promote_emp 	= $this->get_promote_emp_all($salary_month);
		//echo $salary_month;
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');


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
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.unit_id',$unit);
		$this->db->where("trim(substr(pr_emp_com_info.emp_join_date,1,7)) <= '$salary_month'");
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_left_emp);
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_resign_emp);
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_promote_emp);
		$query = $this->db->get();
		return $query;

	}*/
											// $dept,$section,$line,$desig,$sex,$status,$salary_month,$unit,$w_type,$position
	function get_all_employee_for_selection($dept,$section,$line,$desig,$sex,$status,$salary_month,$unit,$w_type,$position)
	{
		$sal_year_month = "$salary_month-01";
		//echo "$dept==$section==$line==$desig==$sex==$status===$salary_month==$unit";
		$i = 1;
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_pay_scale_sheet');
		$this->db->where('pr_emp_per_info.emp_id = pr_pay_scale_sheet.emp_id');
		$this->db->where('pr_emp_com_info.emp_id = pr_pay_scale_sheet.emp_id');
		$this->db->where("pr_pay_scale_sheet.salary_month = '$sal_year_month'");

		if($unit !="Select"){$this->db->where("pr_pay_scale_sheet.unit_id", $unit);}
		if($dept !="Select"){$this->db->where("pr_pay_scale_sheet.dept_id", $dept);}
		if($section !="Select"){$this->db->where("pr_pay_scale_sheet.sec_id", $section);}
		if($line !="Select"){$this->db->where("pr_pay_scale_sheet.line_id", $line);}
		if($desig !="Select"){$this->db->where("pr_pay_scale_sheet.desig_id ", $desig);}
		if($sex !="Select"){$this->db->where("pr_pay_scale_sheet.emp_sex", $sex);}
		if($w_type !="Select"){$this->db->where("pr_emp_com_info.salary_draw", $w_type);}
		if($status !="ALL" ){$this->db->where("pr_pay_scale_sheet.emp_status", $status);}
		if($position !="Select"){$this->db->where("pr_emp_com_info.emp_sts_id", $position);}
		$this->db->order_by('pr_emp_per_info.emp_id');
		$query = $this->db->get();
		//echo $query->num_rows();
		return $query;
	}
	function get_new_employee_for_selection($dept,$section,$line,$desig,$sex,$status,$salary_month,$unit)
	{
		$probation_period 	= $this->get_setup_attributes(8);
		$prev_prob_month 	= $this->get_prev_month($probation_period,$salary_month);
		$get_left_emp 		= $this->get_left_emp($salary_month);
		$get_resign_emp 	= $this->get_resign_emp($salary_month);
		$get_promote_emp 	= $this->get_promote_emp_all($salary_month);
		$i = 1;
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
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
		$this->db->where("trim(substr(pr_emp_com_info.emp_join_date,1,7)) <= '$salary_month'");
		$this->db->where("trim(substr(pr_emp_com_info.emp_join_date,1,7)) >= '$prev_prob_month'");
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_left_emp);
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_resign_emp);
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_promote_emp);
		$query = $this->db->get();
		return $query;
		/*echo $this->db->last_query();
		foreach ($query->result() as $row)
		{
			$emp_id = $row->emp_id;
			echo "$i .$emp_id<br>";
			$i = $i + 1;
		}*/
	}
	function get_regular_employee_for_selection($dept,$section,$line,$desig,$sex,$status,$salary_month,$unit)
	{
		$probation_period 	= $this->get_setup_attributes(8);
		$prev_prob_month 	= $this->get_prev_month($probation_period,$salary_month);
		$get_left_emp 		= $this->get_left_emp($salary_month);
		$get_resign_emp 	= $this->get_resign_emp($salary_month);
		$get_promote_emp 	= $this->get_promote_emp_all($salary_month);
		$i = 1;
		//print_r($get_resign_emp);
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
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
		$this->db->where("trim(substr(pr_emp_com_info.emp_join_date,1,7)) <= '$salary_month'");
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_left_emp);
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_resign_emp);
		//$this->db->where_not_in('pr_emp_com_info.emp_id',$get_promote_emp);
		$query = $this->db->get();
		return $query;
	}

	function get_left_employee_for_selection($dept,$section,$line,$desig,$sex,$status,$salary_month,$unit)
	{
		//echo $salary_month;
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_left_history');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_left_history.emp_id');
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
		$this->db->where("trim(substr(pr_emp_left_history.left_date,1,7)) = '$salary_month'");
		$query = $this->db->get();
		return $query;
		/*echo $this->db->last_query();
		foreach ($query->result() as $row)
		{
			$emp_id = $row->emp_id;
			echo "$i .$emp_id<br>";
			$i = $i + 1;
		}*/
	}

	function get_resign_employee_for_selection($dept,$section,$line,$desig,$sex,$status,$salary_month,$unit)
	{

		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_resign_history');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_resign_history.emp_id');
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
		$this->db->where("trim(substr(pr_emp_resign_history.resign_date,1,7)) = '$salary_month'");
		$query = $this->db->get();
		return $query;

		/*echo $this->db->last_query();
		foreach ($query->result() as $row)
		{
			$emp_id = $row->emp_id;
			echo "$i .$emp_id<br>";
			$i = $i + 1;
		}*/
	}




	//================================== Below Code Written For ALL Status=============================
	//=================================================================================================
	function get_all_employee($salary_month,$units)
	{
		$get_left_emp = $this->get_left_emp_all_sts($salary_month);
		$get_resign_emp = $this->get_resign_emp_all_sts($salary_month);
		//$get_promote_emp = $this->get_promote_emp_all($salary_month);
		$i = 1;
		$this->db->select('pr_emp_per_info.*');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_per_info');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.unit_id',$units);
		$this->db->where("trim(substr(pr_emp_com_info.emp_join_date,1,7)) <= '$salary_month'");
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_left_emp);
		$this->db->where_not_in('pr_emp_com_info.emp_id',$get_resign_emp);
		//$this->db->where_not_in('pr_emp_com_info.emp_id',$get_promote_emp);
		$query = $this->db->get();
		return $query;
		/*foreach ($query->result() as $row)
		{
			$emp_id[] = $row->emp_id;
			//echo "$i .$emp_id<br>";
			//$i = $i + 1;
		}
		return $emp_id;*/
	}
	function get_promote_emp_all($salary_month)
	{
		$this->db->select('pr_incre_prom_pun.prev_emp_id');
		$this->db->from('pr_incre_prom_pun');
		$this->db->where("pr_incre_prom_pun.prev_emp_id != pr_incre_prom_pun.new_emp_id");
		$this->db->where("trim(substr(pr_incre_prom_pun.effective_month,1,7)) <= '$salary_month'");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
		  foreach ($query->result() as $row)
		  {
			  $emp_id[] = $row->prev_emp_id;
			  //echo "$i .$row->emp_id<br>";
			  //$i = $i + 1;

		  }
		  return $emp_id ;
		}
		else
		{
			return $emp_id = array('0'=>"abcd") ;
		}
	}
	function get_left_emp_all_sts($salary_month)
	{
		$i = 1;
		$this->db->select('pr_emp_left_history.emp_id');
		$this->db->from('pr_emp_left_history');
		$this->db->where("trim(substr(pr_emp_left_history.left_date,1,7)) <= '$salary_month'");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
		  foreach ($query->result() as $row)
		  {
			  $emp_id[] = $row->emp_id;
			  //echo "$i .$row->emp_id<br>";
			  //$i = $i + 1;

		  }
		  return $emp_id ;
		}
		else
		{
			return $emp_id = array('0'=>"abcd") ;
		}
	}
	function get_resign_emp_all_sts($salary_month)
	{
		$emp_id = array();
		$i = 1;
		$this->db->select('pr_emp_resign_history.*');
		$this->db->from('pr_emp_resign_history');
		$this->db->where("trim(substr(pr_emp_resign_history.resign_date,1,7)) <= '$salary_month'");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
		  foreach ($query->result() as $row)
		  {
			  $emp_id[] = $row->emp_id;
			  //echo "$i .$row->emp_id<br>";
			  //$i = $i + 1;

		  }
		  return $emp_id ;
		}
		else
		{
			return $emp_id = array('0'=>"abcd") ;
		}
	}


	//================================== END Code Written For ALL Status===============================
	//=================================================================================================
	function get_unit_id_name()
	{
		$get_session_user_unit = $this->get_session_unit_id_name();
		$this->db->select('*');
		if($get_session_user_unit != 0)
		{
			$this->db->where("unit_id",$get_session_user_unit);
		}
		$this->db->order_by("unit_name");
		return $query = $this->db->get('pr_units');
	}

	function get_session_unit_id_name()
	{
		$user_name = $this->session->userdata('data')->id_number;
		return $unit_id = $this->db->where("id_number",$user_name)->get('members')->row()->unit_name;
	}

	function get_unit_name_by_id($unit_id)
	{
		return $unit_name= $this->db->where("unit_id",$unit_id)->get('pr_units')->row()->unit_name;
	}

	function get_dept_name($dept_id)
	{
		//dd($dept_id);
		$this->db->select('dept_name');
		$this->db->where('dept_id',$dept_id);
		$query = $this->db->get('emp_depertment');
		$row = $query->row();
		return isset($row->dept_name) ? $row->dept_name : '';
	}
	function get_section_name($sec_id)
	{
		$this->db->select('sec_name_en');
		$this->db->where('id',$sec_id);
		$query = $this->db->get('emp_section');
		$row = $query->row();
		return isset($row->sec_name_en) ? $row->sec_name_en : '';
	}
	function get_line_name($line_id)
	{
		$this->db->select('line_name_en');
		$this->db->where('id',$line_id);
		$query = $this->db->get('emp_line_num');
		$row = $query->row();
		return isset($row->line_name_en) ? $row->line_name_en : '';
	}
	function get_desig_name($desig_id)
	{
		//dd($desig_id);
		$this->db->select('desig_name');
		$this->db->where('id',$desig_id);
		$query = $this->db->get('emp_designation');
		$row = $query->row();
		return isset($row->desig_name) ? $row->desig_name : '';
	}
	function get_grade_name($gr_id)
	{
		$this->db->select('gr_name');
		$this->db->where('gr_id',$gr_id);
		$query = $this->db->get('pr_grade');
		$row = $query->row();
		return $row->gr_name;
	}
	function days_count($emp_id,$start_date,$end_date, $present_status)
	{
		$this->db->select('emp_id');
		$this->db->where("shift_log_date BETWEEN '$start_date' AND '$end_date'");
		$this->db->where("emp_id",$emp_id);
		$this->db->where("present_status",$present_status);
		$query = $this->db->get('pr_emp_shift_log');
		$row = $query->row();
		return $query->num_rows();
	}
	function leave_count($emp_id,$start_date,$end_date, $leave_type)
	{
		$this->db->select('emp_id');
		$this->db->where("start_date BETWEEN '$start_date' AND '$end_date'");
		$this->db->where("emp_id",$emp_id);
		$this->db->where("leave_type",$leave_type);
		$query = $this->db->get('pr_leave_trans');
		$row = $query->row();
		return $query->num_rows();
	}
}
?>

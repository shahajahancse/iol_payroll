<?php
class File_process_model extends CI_Model{


	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 0);
	    set_time_limit(0);
		$this->load->model('common_model');

	}

	function file_process_for_attendance_old($att_date,$unit,$proxi){
		date_default_timezone_set('Asia/Dhaka');

		$date  = $att_date;
		$year  = trim(substr($date,0,4));
		$month = trim(substr($date,5,2));
		$day   = trim(substr($date,8,2));

		$att_table = "att_".$year."_".$month;
		$date = date("d-m-Y", mktime(0, 0, 0, $month, $day, $year));
		//For Data File Upload System
		/*$this->db->select('file_name');
		$this->db->where('unit_id',$unit);
		$this->db->where('upload_date',$att_date);
		$query = $this->db->get('pr_attn_file_upload');
		if($query->num_rows() == 0)
		{
			echo "Please Upload Attendance File.";
			exit;
		}
		$row = $query->row();
		$file_name_db = $row->file_name;*/

		$file_name = "data/$date.TXT";
		// echo $file_name; die;
		// exit;
		if (file_exists($file_name)){
			if (!$this->db->table_exists($att_table)){
				$this->load->dbforge();
				$fields = array(
								'att_id' 	=> array( 'type' => 'INT','constraint' => '11',  'auto_increment' => TRUE),
								'device_id' => array( 'type' => 'INT','constraint' => '11'),
								'proxi_id'  => array( 'type' => 'VARCHAR','constraint' => '100'),
								'date_time' => array( 'type' => 'datetime')
								);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('att_id', TRUE);
				$this->dbforge->create_table($att_table);
			}
			$lines = file($file_name);
			//print_r($lines);exit;
			$out = array();
			foreach(array_values($lines)  as $line) {
					$prox_no = trim(substr($line,15,12));
					//$prox_no = sprintf("%04d",$prox_no);
					//if(trim($prox_no) == "$proxi") {
					if(in_array($prox_no, $proxi)){
						$out[] = $line;
					}
				}

				/*echo "<pre>";
				print_r($out);exit;*/

			//foreach (array_values($lines) AS $line){
				foreach ($out AS $line){
				// list($prox_no,$date_time,$device_id,$test1,$name,$test3,$test4,$test4) = explode('	', trim($line) );
				//echo $line;
				$device_id 	= substr($line,0,3);
				$day 		= substr($line,3,2);
				$month 		= substr($line,5,2);
				$year 		= substr($line,7,2);
				$hour 		= substr($line,9,2);
				$minute		= substr($line,11,2);
				$second		= substr($line,13,2);
				$prox_no 	= trim(substr($line,15,12));

				$date_time = $year .'-'. $month .'-'. $day .' '. $hour .':'. $minute .':'. $second;
				$prox_no = sprintf("%04d",$prox_no);
				// $prox_no = sprintf("%05s",$prox_no);
				// $prox_no = sprintf("%06s",$prox_no);
				$final_day_time = date("Y-m-d H:i:s", strtotime($date_time));

				$this->db->select("");
				$this->db->where("proxi_id", $prox_no);
				$query = $this->db->get("pr_id_proxi");
				$num_rows = $query->num_rows();
				//echo $this->db->last_query();
				//$result1 = mysql_query("SELECT * FROM $att_table where proxi_id= '$prox_no' and date_time='$final_day_time'");
				//$num_rows1=mysql_num_rows($result1);

				if($num_rows > 0){
					$this->db->select("");
					$this->db->where("proxi_id", $prox_no);
					$this->db->where("date_time", $final_day_time);
					$query1 = $this->db->get($att_table);
					$num_rows1 = $query1->num_rows();

					if($num_rows1 == 0 ){
						$data = array(
										'device_id' => $device_id,
										'proxi_id' 	=> $prox_no,
										'date_time'	=> $final_day_time
									);
						$this->db->insert($att_table , $data);
					}
				}

			}
		}else{
			exit('Please Put the Data File.');
		}

	}


	function file_process_for_attendance_zuelvai($att_date,$unit,$proxi){
		date_default_timezone_set('Asia/Dhaka');

		$date  = $att_date;
		$year  = trim(substr($date,0,4));
		$month = trim(substr($date,5,2));
		$day   = trim(substr($date,8,2));

		$att_table = "att_".$year."_".$month;
		$date = date("d-m-Y", mktime(0, 0, 0, $month, $day, $year));

		$file_name = "data/$date.txt";
		// echo $file_name; die;
		// exit;
		if (file_exists($file_name)){
			if (!$this->db->table_exists($att_table)){
				$this->load->dbforge();
				$fields = array(
							'att_id' 	=> array( 'type' => 'INT','constraint' => '11',  'auto_increment' => TRUE),
							'device_id' => array( 'type' => 'INT','constraint' => '11'),
							'proxi_id'  => array( 'type' => 'VARCHAR','constraint' => '100'),
							'date_time' => array( 'type' => 'datetime')
						);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('att_id', TRUE);
				$this->dbforge->create_table($att_table);
			}


			$lines = file($file_name);
			// print_r($lines);exit;
			$out = array();
			foreach(array_values($lines)  as $line) {
				list($id,$prox_no,$date,$time,$format,$floor,$device) = preg_split('/\s+/', trim($line));
				// $prox_no = sprintf("%04d",$prox_no);
				$date_time = $date .' '. $time;
				$final_day_time = date("Y-m-d H:i:s", strtotime($date_time));

				$this->db->select("proxi_id");
				$this->db->where("proxi_id", $prox_no);
				$query = $this->db->get("pr_id_proxi");
				$num_rows = $query->num_rows();

				if($num_rows > 0){
					$this->db->select("");
					$this->db->where("proxi_id", $prox_no);
					$this->db->where("date_time", $final_day_time);
					$query1 = $this->db->get($att_table);
					$num_rows1 = $query1->num_rows();
					// echo "<pre>".$prox_no .','.$num_rows1; exit;

					if($num_rows1 == 0 ){
						$data = array(
										'device_id' => $id,
										'proxi_id' 	=> $prox_no,
										'date_time'	=> $final_day_time
									);
						// print_r($data);exit;
						$this->db->insert($att_table , $data);
					}
				}

			}
		}else{
			exit('Please Put the Data File.');
		}

	}

	function file_process_for_attendance($att_date,$unit,$proxi){
		date_default_timezone_set('Asia/Dhaka');
		$att_table = "att_".date('Y_m',strtotime($att_date));
		$this->db->select('file_name');
		$this->db->where('upload_date',$att_date);
		$query = $this->db->get('pr_attn_file_upload');
		if($query->num_rows() == 0){
			echo "Please upload attendance file.";
			exit;	
		}

		$rawfile_name = $query->row()->file_name;
		$file_name = "data/$rawfile_name";
		if (file_exists($file_name)){
			if (!$this->db->table_exists($att_table)){
				$this->load->dbforge();
				$fields = array(
							'att_id' 	=> array( 'type' => 'INT','constraint' => '11',  'auto_increment' => TRUE),
							'device_id' => array( 'type' => 'INT','constraint' => '11'),
							'proxi_id'  => array( 'type' => 'VARCHAR','constraint' => '100'),
							'date_time' => array( 'type' => 'datetime')
						);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('att_id', TRUE);
				$this->dbforge->create_table($att_table);
			}


			$lines = file($file_name);
			$out = array();
			foreach(array_values($lines)  as $line) {
				list($prox_no,$final_day_time,$device_id,$floor,$device,$i,$j,$k) = explode('	', trim($line));
				$this->db->where("proxi_id", $prox_no);
				$this->db->where("date_time", $final_day_time);
				$query1 = $this->db->get($att_table);
				$num_rows1 = $query1->num_rows();

				if($num_rows1 == 0 ){
					$data = array(
									'device_id' => $device_id,
									'proxi_id' 	=> $prox_no,
									'date_time'	=> $final_day_time
								);
					$this->db->insert($att_table , $data);
					// echo $this->db->last_query(); die;
				}
			}
		}else{
			exit('Please Put the Data File.');
		}

	}


	function manual_entry_Delete($grid_firstdate, $grid_seconddate, $grid_emp_id)
	{

		$data = array();

		$query = $this->all_emp_for_manual_delete($grid_emp_id);
		//print_r($query->result_array());

		foreach($query->result() as $row)
		{
			$id = $row->emp_id;

			$startdate = $grid_firstdate;
			$temp_table = "temp_$id";

			$proxi = $this->prox($id);

			$days = $this->GetDays($grid_firstdate, $grid_seconddate);
			//print_r($days);
			//return "Test";
			foreach($days as $perday)
			{
				$date  = $perday;
				$year  = trim(substr($date,0,4));
				$month = trim(substr($date,5,2));
				$day   = trim(substr($date,8,2));

				$att_table = "att_".$year."_".$month;
				$date = date("d-m-Y", mktime(0, 0, 0, $month, $day, $year));
				$search_date = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));

				$unit_id = $this->common_model->get_session_unit_id_name();
				if($unit_id == 0)
				{
					return "Sorry! Only Unit wise user can delete.";
				}

				$this->db->select('file_name');
				$this->db->where('unit_id',$unit_id);
				$this->db->where('upload_date',$search_date);
				$query = $this->db->get('pr_attn_file_upload');
				if($query->num_rows() == 0)
				{
					echo "Please Upload Attendance File.";
					exit;
				}
				$row = $query->row();
				$file_name_db = $row->file_name;
				$file_name = "data/$file_name_db";

				//$file_name = "data/$date.TXT";
				$temp_table = "temp_$id";


				$where ="trim(substr(date_time ,1,10)) = '$perday'";
				$this->db->where($where);
				$data=$this->db->delete($temp_table);
				//echo $this->db->last_query();
				//return "Test";
				$where ="trim(substr(date_time ,1,10)) = '$perday' and proxi_id='$proxi'";
				$this->db->where($where);
				$data=$this->db->delete($att_table);
				//$this->db->last_query();
				//return "Test";
				if ($data)
				{
					if( file_exists($file_name) )
					{

						$data = file($file_name);

						$out = array();

						foreach($data as $line) {

							list($match_line,$date_time,$device_id,$test1,$name,$test3,$test4,$test4) = explode('	', trim($line) );

							if(trim($match_line) != "$proxi") {
								$out[] = $line;
							}

						}
						$fp = fopen($file_name, "w+");
						flock($fp, LOCK_EX);
						foreach($out as $line) {
							fwrite($fp, $line);
						}
						flock($fp, LOCK_UN);
						fclose($fp);
					}

				}
				else
				{
					return "Delete failed";
				}
			}
		}

		return "Delete successfully";

	}

	function prox($empid)
	{
		$this->db->select('proxi_id');
		$this->db->where('emp_id',$empid);
		$query = $this->db->get('pr_id_proxi');
		foreach ($query->result() as $rows)
		{
			return $rows->proxi_id;
		}
	}

	function all_reguler_emp($grid_emp_id)
	{
		$emp_cat_id = array( '0'=>1, '1'=>2);

		$this->db->select('emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where_in('emp_id', $grid_emp_id);
		$this->db->where_in('emp_cat_id', $emp_cat_id);
		$this->db->order_by("emp_id");
		$query = $this->db->get();
		return $query;
	}

	function GetDays($sStartDate, $sEndDate)
	{
       	$sStartDate = date("Y-m-d", strtotime($sStartDate));
		$sEndDate = date("Y-m-d", strtotime($sEndDate));

        // Start the variable off with the start date
    	$aDays[] = $sStartDate;

    	// Set a 'temp' variable, sCurrentDate, with
    	// the start date - before beginning the loop
    	$sCurrentDate = $sStartDate;

		// While the current date is less than the end date
    	while($sCurrentDate < $sEndDate)
		{
       		// Add a day to the current date
       		$sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

       		// Add this new day to the aDays array
        		$aDays[] = $sCurrentDate;
			//print_r($aDays);
     	}
     // Once the loop has finished, return the
     return $aDays;
   }

   function all_emp_for_manual_delete($grid_emp_id)
	{
		$emp_cat_id = array( '0'=>1, '1'=>2, '2'=> 3, '3'=>4);

		$this->db->select('emp_id');
		$this->db->from('pr_emp_com_info');
		$this->db->where_in('emp_id', $grid_emp_id);
		$this->db->where_in('emp_cat_id', $emp_cat_id);
		$this->db->order_by("emp_id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query;
	}
}

<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 * This controller used to only manual scripts command run
	 * So not used/create any method this contrller to main app development
	 */

class Command extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 0);
	    set_time_limit(0);

		/* Standard Libraries */
		// $this->load->library('grocery_CRUD');
		// $this->load->model('acl_model');
		$this->load->dbforge();
		// exit('only for developer');
	}

	public function iea()
	{
		// echo "hello, ci";
		$i = '2024-06-06';

		while ($i <= '2024-06-24') {
			echo '<br> ' .$i;
			$array = array(
				'emp_id'		=> 5000462,
				'unit_id'		=> 4,
				'start_date'	=> $i,
				'leave_type'	=> 'el',
				'leave_start'	=> '2024-06-06',
				'leave_end'		=> '2024-06-24',
			);
			// $rs = $this->db->insert($array, 'pr_leave_trans');

			$i = date('Y-m-d', strtotime('+1 days'. $i));
		}
		dd('exit');
	}

	public function earn()
	{
		dd("hello, ci");
		$this->db->where('unit_id', 2);
		$this->db->group_by('emp_id');
		$this->db->order_by('emp_id', 'asc');
		$qsss = $this->db->get('pr_earn_2021')->result(); 
		foreach ($qsss as $key => $r) {
			$data = array(
				'unit_id'    => $r->unit_id,
				'emp_id'     => $r->emp_id,
				'dept_id'    => $r->dept_id,
				'sec_id'     => $r->sec_id,
				'line_id'    => $r->line_id,
				'desig_id'   => $r->desig_id,
				'gross_sal'  => $r->gross_sal,
				'com_gross_sal'  => $r->gross_sal,
				'basic_sal'  => $r->basic_sal,
				'P'  => $r->P,
				'A'  => $r->A,
				'H'  => $r->H,
				'W'  => $r->W,
				'L'  => $r->L,
				'el'  => $r->el,
				'cl'  => $r->cl,
				'sl'  => $r->sl,
				'ml'  => $r->ml,
				't_days' 	 => $r->ttl_wk_days,
				'w_days' 	 => $r->pay_days,
				'earn_leave' => $r->earn_leave,
				'net_pay'  => $r->net_pay,
				'earn_month' => '2021-12-31',
			);
			$query = $this->db->where('earn_month', '2021-12-31')->where('emp_id', $r->emp_id)->get('pr_earn_leave');
			if (empty($query->row())) {
				$this->db->insert('pr_earn_leave', $data);
			} 
		}
		dd('done');
	}

	public function get_ss_id()
	{
		dd("hello, ci");
		// echo "hello, ci";
		$this->db->select(' emp_id ');
		$this->db->from('pay_salary_sheet');
		$this->db->where('unit_id', 4);
		$this->db->where('salary_month', '2024-05-01');
		$this->db->group_by('emp_id');
		$this->db->order_by('emp_id', 'asc');
		$q = $this->db->get()->result_array();  // 707 get
		$p = array_column($q, 'emp_id');
	
		
		$this->db->select(' emp_id ');
		$this->db->from('pay_salary_sheet_com');
		$this->db->where('unit_id', 4);
		//$this->db->where_not_in('emp_id', $p);
		$this->db->order_by('emp_id', 'asc');
		$this->db->group_by('emp_id');
		$query = $this->db->where('salary_month', '2024-05-01')->get()->result_array(); // 710 get
		$ps = array_column($query, 'emp_id');
		
	
		dd(array_diff($p, $ps ));

		$rs = array_column($query, 'emp_id');
		dd($rs);
	}

	function dpt_sec_lin_udate()
	{
		exit('only for developer');
		$file_name = "import/aj.txt";
		if (file_exists($file_name)) {

			$lines = file($file_name);
			foreach (array_values($lines)  as $line) {
				list($id, $dpt, $sec, $lin) = explode("\t", trim($line));
				$data = array(
					'emp_dept_id' 	=> trim($dpt),
					'emp_sec_id' 	=> trim($sec),
					'emp_line_id' 	=> trim($lin),
				);
				$this->db->where('emp_id', $id)->update('pr_emp_com_info', $data);
				echo "<br> Updated Id = " . $id;
			}
			echo "Updated successfully done";
		}
		exit("wait");
	}

	// Delete pr_emp_shift_log table data 2013-10-30 to 2021-10-01
	public function shift_log()
	{
		echo "hello, ci";
		$i = '2021-10-01';

		while ($i >= '2013-10-30') {

			$rs = $this->db->where('shift_log_date', $i)->get('pr_emp_shift_log')->row();
			if (!empty($rs))
			{
				$this->db->where('shift_log_date', $i)->delete('pr_emp_shift_log');
				echo "<pre> $i Delete data";
			}

			$i = date('Y-m-d', strtotime('-1 days'. $i));

		}
		dd('exit');
	}

	// pr_incre_prom_pun
	public function stopyyy()
	{
		// dd("hello, ci");
		echo "hello, ci";
		$this->db->select('
				pay_emp_stop_salary.id as st_id,
				pr_emp_com_info.id,
				pr_emp_com_info.emp_id,
			');
		$this->db->from('pay_emp_stop_salary');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pay_emp_stop_salary.emp_id = pr_emp_com_info.emp_id');
		$this->db->limit(20000);
		$this->db->group_by('pay_emp_stop_salary.emp_id');
		$results = $this->db->get()->result();
		// dd(count($results));

		foreach ($results as $key => $row) {
			$data = array(
				'emp_id' 	 => $row->id,
			);

			$this->db->where('emp_id', $row->emp_id)->update('pay_emp_stop_salary', $data);

			echo "<pre> $row->st_id =  month = $row->st_id";
		}
		dd('exit');
		// $this->db->insert_batch('pay_salary_sheet_2023', $results);
		// dd($this->db->last_query());
	}

	// pr_incre_prom_pun
	public function incre_prom()
	{
		// dd("hello, ci");
		echo "hello, ci";
		$this->db->select('
				pr_incre_prom_pun.prev_emp_id,
				pr_emp_com_info.id,
			');
		$this->db->from('pr_incre_prom_pun');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_incre_prom_pun.prev_emp_id = pr_emp_com_info.emp_id');
		$this->db->limit(20000);
		$this->db->group_by('pr_incre_prom_pun.prev_emp_id');
		$this->db->group_by('pr_emp_com_info.emp_id');
		$results = $this->db->get()->result();
		// dd(count($results));

		foreach ($results as $key => $row) {
			$data = array(
				'prev_emp_id' 	 => $row->id,
			);

			$this->db->where('prev_emp_id', $row->prev_emp_id)->update('pr_incre_prom_pun', $data);

			echo "<pre> $row->id =  month = $row->prev_emp_id";
		}
		dd('exit');
		// $this->db->insert_batch('pay_salary_sheet_2023', $results);
		// dd($this->db->last_query());
	}

	// pr_emp_left_history
	public function emp_left()
	{
		dd("hello, ci");
		echo "hello, ci";
		$this->db->select('
				pr_emp_left_history.left_id,
				pr_emp_left_history.unit_id,
				pr_emp_left_history.emp_id,
				pr_emp_com_info.id,
			');
		$this->db->from('pr_emp_left_history');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_left_history.emp_id = pr_emp_com_info.emp_id');
		$this->db->limit(100000);
		$results = $this->db->get()->result();
		// dd($results);

		foreach ($results as $key => $row) {

			$data = array(
				'emp_id' 	 => $row->id,
			);


			$this->db->where('left_id', $row->left_id)->update('pr_emp_left_history', $data);

			echo "<pre> $row->id =  month = $row->emp_id";
		}
		dd('exit');
		// $this->db->insert_batch('pay_salary_sheet_2023', $results);
		// dd($this->db->last_query());
	}

	// pr_emp_resign_history
	public function emp_resign()
	{
		// dd("hello, ci");
		echo "hello, ci";
		$this->db->select('
				pr_emp_resign_history.resign_id,
				pr_emp_resign_history.unit_id,
				pr_emp_resign_history.emp_id,
				pr_emp_com_info.id,
			');
		$this->db->from('pr_emp_resign_history');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_resign_history.emp_id = pr_emp_com_info.emp_id');
		$this->db->limit(100000);
		$results = $this->db->get()->result();
		// dd($results);

		foreach ($results as $key => $row) {

			$data = array(
				'emp_id' 	 => $row->id,
			);


			$this->db->where('resign_id', $row->resign_id)->update('pr_emp_resign_history', $data);

			echo "<pre> $row->id =  month = $row->emp_id";
		}
		dd('exit');
		// $this->db->insert_batch('pay_salary_sheet_2023', $results);
		// dd($this->db->last_query());
	}

	// separate salary  pay_salary_sheet_2022
	public function separate_salary()
	{
		dd("hello, ci");
		echo "hello, ci";
		$this->db->select('
				id,
				unit_id,
				emp_id,
				gross_sal,
				salary_structure,

				basic_sal,
				house_r,
				medical_a,
				food_allow,
				trans_allow,


				total_days,
				num_of_workday,
				att_days,
				absent_days,
				before_after_absent,
				c_l,
				s_l,
				e_l,
				m_l,
				wp,
				total_leave,
				total_pay_leave,
				holiday,
				weekend,
				total_holiday,
				pay_days,

				day_info,
				salary_month,

			');
		$this->db->from('pay_salary_sheet_2022');
		$this->db->limit(100000);
		$results = $this->db->get()->result();

		foreach ($results as $key => $row) {
			$obj = array(
				'basic_sal' => $row->basic_sal,
				'house_r' => $row->house_r,
				'medical_a' => $row->medical_a,
				'food_allow' => $row->food_allow,
				'trans_allow' => $row->trans_allow,
			);

			$obj1 = array(
				'total_days' 	 => $row->total_days,
				'num_of_workday' => $row->num_of_workday,
				'att_days' 		 => $row->att_days,
				'absent_days' 	 => $row->absent_days,
				'ba_absent' 	 => $row->before_after_absent,
				'c_l' 		 	 => $row->c_l,
				's_l' 		 	 => $row->s_l,
				'e_l' 		 	 => $row->e_l,
				'm_l' 		 	 => $row->m_l,
				'wp' 		 	 => $row->wp,
				'total_leave' 	 => $row->total_leave,
				'pay_leave' 	 => $row->total_pay_leave,
				'holiday' 		 => $row->holiday,
				'weekend' 		 => $row->weekend,
				'total_holiday'  => $row->total_holiday,
				'pay_days' 		 => $row->pay_days,
			);

			// dd($data);
			$sdate = date('Y-m-01', strtotime($row->salary_month));
			$edate = date('Y-m-t', strtotime($row->salary_month));
			$this->db->select('
				    shift_log_date,
		            in_time,
		            out_time,
		            ot,
		            eot
				');

			$this->db->from('pr_emp_shift_log');
			$this->db->where("emp_id", $row->emp_id);
			$this->db->where("shift_log_date BETWEEN '$sdate' and '$edate'");
			$this->db->limit(100);
			$results = $this->db->get()->result();
			foreach ($results as $key => $rows) {
				$obj2[$key] = array(
					'log_date' 		=> $rows->shift_log_date,
					'in_time' 		=> $rows->in_time,
					'out_time' 		=> $rows->out_time,
					'ot' 		 	=> $rows->ot,
					'eot' 		 	=> $rows->eot,
				);
			}

			$data = array(
				'salary_structure'	=> json_encode($obj),
				'day_info'			=> json_encode($obj1),
				'log_info'			=> json_encode($obj2),
			);

			// dd($this->db->last_query());


			$this->db->where('id', $row->id)->where('salary_month', $row->salary_month)->update('pay_salary_sheet_2022', $data);

			echo "<pre> $row->emp_id =  month = $row->salary_month";
		}
		dd('exit');
		// $this->db->insert_batch('pay_salary_sheet_2023', $results);
		// dd($this->db->last_query());
	}

	// pay_salary_sheet
	// not used
	public function create_salary_sheet()
	{
		dd('ddd');
		$i = '2014';
		while ($i <= '2024') {
			$newTableName = "pay_salary_sheet_$i";
			if (!$this->db->table_exists($newTableName))
			{
				$query = $this->db->query("SHOW CREATE TABLE pay_salary_sheet");
				$row = $query->row_array();
				$newTableName = str_replace('pay_salary_sheet', $newTableName, $row['Create Table']);
				$this->db->query($newTableName);
			}
			$i = $i + 1;
		}

		echo "hello, ci";
		$this->db->select('*');
		$this->db->from('pay_salary_sheet');
		$this->db->where("pay_salary_sheet.salary_month BETWEEN '2023-01-01' and '2023-12-01'");
		$this->db->limit(100000);
		$results = $this->db->get()->result_array();

		$this->db->insert_batch('pay_salary_sheet_2023', $results);
		// dd($this->db->last_query());
		dd('ok');
	}

	//  salary     done
	public function salary_emp_id()
	{
		echo "hello, ci";
		$this->db->select('pr_emp_com_info.id, pr_emp_com_info.emp_id, pr_emp_com_info.unit_id');
		$this->db->from('pay_salary_sheet');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_com_info.emp_id = pay_salary_sheet.emp_id');
		$this->db->where('pr_emp_com_info.unit_id =', 3);
		$this->db->where('pay_salary_sheet.unit_id =', 3);
		$this->db->group_by('pr_emp_com_info.id');
		$results = $this->db->get()->result();
		// dd($results);

		foreach ($results as $key => $row) {

			$data = array(
				'emp_id'			=> $row->id,
			);
			// dd($data);

			$this->db->where('emp_id',$row->emp_id)->update('pay_salary_sheet', $data);

			echo "<pre> $row->emp_id =  emp id set = ";
		}
		dd('exit');
	}

	//  per_info address add gender, religion, marital_status, blood group
	// nor used
	public function ot_eot()
	{
		dd('exit');
		echo "hello, ci";
		$this->db->select('emp_id, shift_log_date, ot, eot');
		$this->db->from('pr_emp_shift_log');
		$this->db->where('ot !=', 0);
		$this->db->where('unit_id =', 1);
		$results = $this->db->get()->result();

		foreach ($results as $key => $row) {

			$data = array(
				'ot'			=> ($row->ot * 60),
				'eot'			=> ($row->eot * 60),
			);
			// dd($data);

			$this->db->where('emp_id',$row->emp_id)->where('shift_log_date',$row->shift_log_date)->update('pr_emp_shift_log', $data);

			echo "<pre> $row->emp_id =  emp id set = ";
		}
		dd('exit');
	}

	//  pr_emp_shift_log employee id conver   done
	public function log_emp_id()
	{
		echo "hello, ci";
		exit('only for developer');
		$this->db->select('pr_emp_com_info.id, pr_emp_com_info.emp_id, pr_emp_com_info.unit_id');
		$this->db->from('pr_emp_shift_log');
		$this->db->from('pr_emp_com_info');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_shift_log.emp_id');
		$this->db->where('pr_emp_com_info.unit_id =', 3);
		$this->db->group_by('pr_emp_com_info.emp_id');
		$results = $this->db->get()->result();
		// dd($results);

		foreach ($results as $key => $row) {
			$rs = $this->db->where('emp_id',$row->emp_id)->get('pr_emp_shift_log')->result();
			// dd($rs);

			$data = array(
				// 'emp_id'			=> $row->emp_id,
				'unit_id'			=> $row->unit_id,
			);
			$this->db->where('emp_id',$row->emp_id)->update('pr_emp_shift_log', $data);

			echo "<pre> $key  =  $row->emp_id =  emp id set = ".count($rs);
		}
		dd('exit');
	}

	//  per_info address add gender, religion, marital_status, blood group   done
	public function gen_mar_blo_per_info()
	{
		echo "hello, ci";
		$results = $this->db->where('unit_id =', 1)->get('pr_emp_com_info')->result();

		foreach ($results as $key => $row) {

			$rs = $this->db->where('emp_id',$row->emp_id)->get('pr_emp_per_info')->row();


			if ($rs->emp_religion == 1) {
				$rel = 'Islam';
			} elseif ($rs->emp_religion == 2) {
				$rel = 'Hindu';
			} elseif ($rs->emp_religion == 3) {
				$rel = 'Christian';
			} elseif ($rs->emp_religion == 4) {
				$rel = 'Buddhish';
			} else {
				$rel = '';
			}

			if ($rs->emp_marital_status == 1) {
				$mar = 'Unmarried';
			} else {
				$mar = 'Married';
			}

			if ($rs->emp_sex == 1) {
				$gen = 'Male';
			} elseif ($rs->emp_sex == 2) {
				$gen = 'Female';
			} else {
				$gen = 'Common';
			}

			if ($rs->emp_blood == 1) {
				$blo = 'A+';
			} elseif ($rs->emp_blood == 2) {
				$blo = 'A-';
			} elseif ($rs->emp_blood == 3) {
				$blo = 'B+';
			} elseif ($rs->emp_blood == 4) {
				$blo = 'B-';
			} elseif ($rs->emp_blood == 5) {
				$blo = 'AB+';
			} elseif ($rs->emp_blood == 6) {
				$blo = 'AB-';
			} elseif ($rs->emp_blood == 7) {
				$blo = 'O+';
			} elseif ($rs->emp_blood == 8) {
				$blo = 'O-';
			} else {
				$blo = 'None';
			}


			$data = array(
				'religion'			=> $rel,
				'marital_status'	=> $mar,
				'gender'			=> $gen,
				'blood'				=> $blo,
			);
			$this->db->where('emp_id',$row->id)->update('pr_emp_per_info', $data);
			echo "<pre> $row->emp_id =  emp id set";
		}
		dd('exit');
	}

	//  per_info address add   done
	public function per_info_address()
	{
		echo "hello, ci";
		$results = $this->db/*->where('unit_id !=', 3)*/->get('pr_emp_com_info')->result();

		foreach ($results as $key => $row) {

			$rs = $this->db->where('emp_id',$row->emp_id)->get('pr_emp_add')->row();

			$data = array(
				'pre_village'	=> $rs->emp_pre_add?$rs->emp_pre_add:'',
				'per_village' 	=> $rs->emp_par_add?$rs->emp_par_add:'',
			);
			$this->db->where('emp_id',$row->id)->update('pr_emp_per_info', $data);
			echo "<pre> $row->emp_id =  emp id set";
		}
		dd('exit');
	}

	//  pr_emp_com_info table update to proxi id add pr_id_proxi table drop done
	public function com_info()
	{
		echo "hello, ci";

		$results = $this->db->select('emp_id')->get('pr_emp_com_info')->result();

		foreach ($results as $key => $row) {
			$rs = $this->db->where('emp_id', $row->emp_id)->get('pr_id_proxi')->row();
			$data = array(
				'proxi_id' => ($rs->proxi_id) ? $rs->proxi_id:$row->emp_id,
			);
			$this->db->where('emp_id',$row->emp_id)->update('pr_emp_com_info', $data);
			echo "<pre> $row->emp_id = proxi id set";
		}
		dd('exit');
	}

	// Delete attn_holiday table data 2013-10-30 to 2021-10-01 done
	public function holiday()
	{
		echo "hello, ci";
		$i = '2021-10-01';

		while ($i >= '2013-10-30') {

			$rs = $this->db->where('holiday_date', $i)->get('pr_holiday')->row();;
			if (!empty($rs))
			{
				$this->db->where('holiday_date', $i)->delete('pr_holiday');
				echo "<pre> $i Delete data";
			}

			$i = date('Y-m-d', strtotime('-1 days'. $i));

		}
		dd('exit');
	}

	// Delete attn_work_off table data 2013-10-30 to 2021-10-01  done
	public function work_off()
	{
		echo "hello, ci";
		$i = '2021-10-01';

		while ($i >= '2013-10-30') {

			$rs = $this->db->where('work_off_date', $i)->get('pr_work_off')->row();;
			if (!empty($rs))
			{
				$this->db->where('work_off_date', $i)->delete('pr_work_off');
				echo "<pre> $i Delete data";
			}

			$i = date('Y-m-d', strtotime('-1 days'. $i));

		}
		dd('exit');
	}

	// Delete att_year_month (att_2020_07) table  done
	public function att_year_month()
	{
		echo "hello, ci";
		$i = '2021-09';
		while ($i >= '2013-09') {

			$att = 'att_'.date('Y_m', strtotime($i));

			if ($this->db->table_exists($att))
			{
				$this->dbforge->drop_table($att);
				echo "<pre>".$att;
			}

			$i = date('Y-m', strtotime('-1 months'. $i));

		}
		dd('exit');
	}

	// Delete all temp table  done
	public function temp()
	{
		exit('only for developer');
		//echo "hello, ci";
		$results = $this->db->select('emp_id')->get('pr_emp_com_info')->result(); //->where('unit_id',4)

		foreach ($results as $key => $row) {
			// Produces: DROP TABLE table_name
			$temp = "temp_$row->emp_id";

			if ($this->db->table_exists($temp))
			{
				$this->dbforge->drop_table($temp);
				echo "<pre> Id = $row->emp_id";
			}
		}
		dd('exit');
	}

	public function com_dsl()
	{
		exit('only for developer');
		//echo "hello, ci";
		$results = $this->db->select('emp_id')->where('unit_id', 4)->get('pr_emp_com_info')->result(); //->where('unit_id',4)
		
		foreach ($results as $key => $row) {
			$r = $this->db->where('emp_id', $row->emp_id)->get('pr_emp_com_info_c')->row(); 
			if (!empty($r)) {
				$data = array(
					'emp_dept_id' => $r->emp_dept_id,
					'emp_sec_id' => $r->emp_sec_id,
					'emp_line_id' => $r->emp_line_id,
				);
				$this->db->where('emp_id', $row->emp_id)->update('pr_emp_com_info', $data); 	
				echo "<pre> Id = $row->emp_id  done";
			} else {
				echo "<pre> Id = $row->emp_id not done";
			}
		}
		dd('exit');
	}






	function file_read(){
		exit('only for developer');
		// exit('this function create to manual data insert in to db');
		$file_name = "import/aj_add.txt";

		if (file_exists($file_name)){

			$lines = file($file_name);
			foreach(array_values($lines)  as $line) {
				list($id,$per,$pre) = explode("\t", trim($line));

				$rs = $this->db->where('emp_id',$id)->get('pr_emp_com_info')->row();
				// dd($rs);

				if (!empty($rs)) {
					$data = array(
						'pre_village' 	=> trim($pre),
						'per_village' 	=> trim($per),
					);
					$this->db->where('emp_id',$rs->id)->update('pr_emp_per_info', $data);
					echo "<br> Upload done = ".$id ;
				}
			}
			echo "Upload successfully done";
		}

		exit("wait");
	}

	public function risk($value='')
	{
		dd('not allow');
			$this->db->select('
				pr_emp_com_info.emp_id,
				pr_emp_skill2.emp_com_name mobile,
				pr_emp_skill2.emp_skill,
				pr_emp_skill2.emp_yr_skill
			');

		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_emp_skill2');
		$this->db->where('pr_emp_com_info.emp_id = pr_emp_skill2.emp_id');
		$this->db->where('pr_emp_com_info.unit_id', 4);
		$this->db->group_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();

		foreach ($query->result() as $key => $row) {
			$this->db->where('emp_id', $row->emp_id)->delete('pr_emp_skill');

			$data = array(
					'emp_id' => $row->emp_id,
					'emp_com_name' => $row->mobile,
					'emp_skill'		=> $row->emp_skill,
					'emp_yr_skill'	=> $row->emp_yr_skill
				);

			$dd = $this->db->where('emp_id', $row->emp_id)->get('pr_emp_skill')->row();
			if (empty($dd)) {
				$this->db->insert('pr_emp_skill', $data);
			}
			// dd($dd);
		}
		exit('ok');
	}



	public function leave_final(){
		dd('only for developer');
		$all_leave = $this->db->order_by('id','asc')->get('pr_leave_transs')->result();
		$data = array();
			$employee_id = '';
			$unit_id 	 = '';
			$start_date  = '';
			$leave_type  = '';
			$leave_start = '';
			$leave_end   = '';
			$total_leave = '';
		foreach($all_leave as $key => $row){
				if($employee_id == $row->emp_id &&
					$unit_id 	 == $row->unit_id &&
					$leave_type  == $row->leave_type
					){
						$total_leave= $total_leave + 1;
						$leave_end = $row->start_date;
				}else{
					if ($key!=0) {
						$data[]=array(
							'emp_id' => $employee_id,
							'unit_id' => $unit_id,
							'start_date' => $start_date,
							'leave_type' => $leave_type,
							'leave_start' => $leave_start,
							'leave_end' => $leave_end,
							'total_leave' => $total_leave
						);
					}
					$employee_id = $row->emp_id;
					$unit_id = $row->unit_id;
					$start_date = $row->start_date;
					$leave_type = $row->leave_type;
					$leave_start = $row->start_date;
					$leave_end = $row->start_date;
					$total_leave = 1;
				}
			}
			$this->db->insert_batch('pr_leave_trans',$data);
		}
		public function delete_data(){
			$this->db->select('emp_id');
			$this->db->where('left_date <', date('2023-11-01'));
			$this->db->group_by('emp_id');
			$data1=$this->db->get('pr_emp_left_history')->result();
			$employee_id1=array_column($data1,'emp_id');
			//$this->db->select('emp_id');
			$this->db->where('resign_date <', date('2023-11-01'));
			$this->db->group_by('emp_id');
			$data2=$this->db->get('pr_emp_resign_history')->result();
			$employee_id2=array_column($data2,'emp_id');


			$user_id=array_unique(array_merge($employee_id1,$employee_id2));
			

			$this->db->where_in('emp_id',$user_id);
			$this->db->delete('pr_emp_shift_log');
		}


		public function add_data(){
			$unit_id=2;
			$table_data=$this->db->get('aj_fashion')->result();
			foreach($table_data as $key => $row){
				$emp_id=$row->emp_id;
				// dd($row);
				// if($this->db->where('emp_id',$emp_id)->get('pr_emp_com_info')->num_rows()>0){
				// 	continue;
				// }
// 
				// elseif(in_array($emp_id,['2010402','2010403','2010404','2010405','2010406','2010407'])){
				// 	continue;
				// }

				$name=$row->name;
				$dept_id=$this->get_dept_id($row->dept,$unit_id);
				// dd($dept_id);
				$sec_id=$this->get_sec_id($row->sec,$dept_id);
				$line_id=$this->get_line_id($row->line,$sec_id);
				$desg_id=$this->get_desg_id($row->desg,$unit_id);
				$joinng_date = date('Y-d-m',strtotime($row->joinng_date));
				$salary=$row->salary;
				$grade=$row->grade;
				$this->add_employee_per($emp_id,$name,$dept_id,$sec_id,$line_id,$desg_id,$joinng_date,$salary,$grade);
				$this->add_employee_com($unit_id,$emp_id,$dept_id,$sec_id,$line_id,$desg_id,$joinng_date,$salary,$grade);

			}
		}

		public function get_dept_id($dept_name,$unit_id){
			// dd($dept_name);
			$this->db->select('dept_id');
			$this->db->where('unit_id',$unit_id);
			$this->db->where('dept_name',$dept_name);
			$data=$this->db->get('emp_depertment')->row();
			//dd($data);
			return $data->dept_id;
		}
		public function get_sec_id($sec_name,$dept_id){
			// dd($sec_name);
			$this->db->select('id');
			$this->db->where('depertment_id',$dept_id);
			$this->db->where('sec_name_en',$sec_name);
			$data=$this->db->get('emp_section')->row();
			
			// if (isset($data->id)) {
				return $data->id;
			// }else{
			// 	return 'eeee';
			// }
		}

		public function get_desg_id($desg_name,$unit_id){
			$this->db->select('id');
			$this->db->where('unit_id',$unit_id);
			$this->db->like('desig_name',$desg_name,'both');
			$data=$this->db->get('emp_designation')->row();
			// dd($this->db->last_query());
			
			return $data->id;
		}
		public function get_line_id($line_name,$sec_id){
			$this->db->select('id');
			$this->db->where('section_id',$sec_id);
			$this->db->where('line_name_en',$line_name);
			$data=$this->db->get('emp_line_num')->row();
			return $data->id;
		}

		public function add_employee_per($emp_id,$name,$dept_id,$sec_id,$line_id,$desg_id,$joinng_date,$salary,$grade){
			$data = array(
				'emp_id'		=> $emp_id,
				'name_en'		=> $name,
				'national_brn_id'	=> '',
				'father_name'	=> '',
				'mother_name'	=> '',
				'per_village'	=> '',
				'per_post'		=> '',
				'per_thana'		=> '',
				'per_district'	=> '',
				'per_village_bn'	=> '',
				'pre_home_owner'	=> '',
				'holding_num'	=> '',
				'home_own_mobile'	=> '',
				'pre_village'	=> '',
				'pre_post'		=> '',
				'pre_thana'		=> '',
				'pre_district'	=> '',
				'pre_village_bn'	=> '',
				'spouse_name'	=> '',
				'emp_dob'		=> date('Y-m-d'),
				'gender'		=> '',
				'marital_status'	=> '',
				'religion'		=> '',
				'blood'			=> '',
				'emp_religion'	=> '',
				'emp_sex'		=> '',
				'emp_marital_status'	=> '',
				'emp_blood'		=> '',
				'm_child'		=> '',
				'f_child'		=> '',
				'nominee_name'	=> '',
				'nominee_vill'	=> '',
				'nomi_post'		=> '',
				'nomi_thana'	=> '',
				'nomi_district'	=> '',
				'nomi_age'		=> date('Y-m-d'),
				'nomi_relation'	=> '',
				'nomi_mobile'	=> '',
				'refer_name'	=> '',
				'refer_village'	=> '',
				'ref_post'		=> '',
				'ref_thana'		=> '',
				'ref_district'	=> '',
				'refer_mobile'	=> '',
				'refer_relation'	=> '',
				'education'		=> '',
				'nid_dob_id'	=> '',
				'nid_dob_check'	=> '',
				'exp_factory_name'	=> '',
				'exp_duration'		=> '',
				'exp_dasignation'	=> '',
				'hight'			=> '',
				'symbol'			=> '',
				'personal_mobile'	=> '',
				'bank_bkash_no'		=> '',
				'img_source'		=> '',
				'signature'			=> '',
				'identificatiion_marks'	=> '',
			);
			$this->db->insert('pr_emp_per_info', $data);
		}

 		public function add_employee_com($unit_id,$emp_id,$dept_id,$sec_id,$line_id,$desg_id,$emp_join_date,$salary,$emp_sal_gra_id){
			$data = array();
			$data['unit_id'] = $unit_id;
			$data['emp_id'] = $emp_id;
			$data['emp_dept_id'] = $dept_id;
			$data['emp_sec_id'] = $sec_id;
			$data['emp_line_id'] = $line_id;
			$data['attn_sum_line_id'] = '';
			$data['emp_desi_id'] = $desg_id;
			$data['emp_sal_gra_id'] = $emp_sal_gra_id;
			$data['emp_cat_id'] = 1;
			$data['emp_type'] = '';
			$data['proxi_id'] = $emp_id;
			$data['emp_shift'] = '';
			$data['gross_sal'] = $salary;
			$data['com_gross_sal'] = '';
			$data['ot_entitle'] = '';
			$data['com_ot_entitle'] = '';
			$data['transport'] = '';
			$data['lunch'] = '';
			$data['hight'] = '';
			$data['symbol'] = '';
			$data['att_bonus'] = '';
			$data['salary_draw'] = '';
			$data['salary_type'] = '';
			$data['emp_join_date'] = $emp_join_date;
			$this->db->insert('pr_emp_com_info', $data);
		}





}









































































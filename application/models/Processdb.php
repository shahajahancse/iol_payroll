<?php
class Processdb extends CI_Model{


	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
		$this->load->model('log_model');
		$this->load->model('common_model');
	}

	//==================================Employee Information Insert==============================
	//=========================================================================================
	function insert_emp_info()
	{
		if($this->input->post('emp_id') == '')
		{
			return ;
		}

		// Check for duplicate emp_id
		$this->db->select('emp_id');
		$this->db->where('emp_id', $this->input->post('emp_id'));
		$query = $this->db->get('pr_emp_com_info');
		if($query->num_rows() > 0) {
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Employee ID already exists.'); window.location='personal_info';</SCRIPT>";
			return ;
		}

		$ejd = date("Y-m-d", strtotime($this->input->post('emp_join_date')));
		$data = array(
			'emp_id'			=> $this->input->post('emp_id'),
			'unit_id'			=> $this->input->post('unit_id'),
			'emp_dept_id'  		=> $this->input->post('emp_dept_id'),
			'emp_sec_id' 		=> $this->input->post('emp_sec_id'),
			'emp_line_id' 		=> $this->input->post('emp_line_id'),
			'emp_desi_id'  		=> $this->input->post('emp_desi_id'),
			'emp_type'  		=> $this->input->post('emp_type'),
			'emp_sal_gra_id'  	=> $this->input->post('emp_sal_gra_id'),
			'emp_cat_id'		=> $this->input->post('emp_cat_id'),
			'proxi_id'			=> $this->input->post('proxi_id'),
			'emp_shift'  		=> $this->input->post('emp_shift'),
			'gross_sal'			=> $this->input->post('gross_sal'),
			'com_gross_sal'		=> $this->input->post('gross_sal'),
			'monitor_con'		=> 2,

			'ot_entitle'		=> $this->input->post('ot_entitle'),
			'com_ot_entitle'    => $this->input->post('com_ot_entitle'),
			'lunch'				=> $this->input->post('lunch'),
			'transport'			=> $this->input->post('transport'),
			'salary_draw'		=> $this->input->post('salary_draw'),
			'salary_type'		=> $this->input->post('salary_type'),
			'emp_join_date'		=> $ejd,
			'hight'		=> $this->input->post('hight'),
			'symbol'		=> $this->input->post('symbol'),
		);
		// dd($data);

		$dob = date("Y-m-d", strtotime($this->input->post('emp_dob')));
		$per_data = array(
			'name_en' 			=> $this->input->post('name_en'),
			'name_bn' 			=> $this->input->post('name_bn'),
			'father_name' 		=> $this->input->post('father_name'),
			'mother_name' 		=> $this->input->post('mother_name'),
			'per_village'		=> $this->input->post('per_village'),
			'per_village_bn'	=> $this->input->post('per_village_bn'),

			'per_post'			=> $this->input->post('per_post'),
			'per_thana'			=> $this->input->post('per_thana'),
			'per_district'		=> $this->input->post('per_district'),
			'pre_home_owner'	=> $this->input->post('pre_home_owner'),
			'holding_num'		=> $this->input->post('holding_num'),
			'home_own_mobile'	=> $this->input->post('home_own_mobile'),

			'pre_village'		=> $this->input->post('pre_village'),
			'pre_village_bn'	=> $this->input->post('pre_village_bn'),
			'pre_post'			=> $this->input->post('pre_post'),
			'pre_thana'			=> $this->input->post('pre_thana'),
			'pre_district'		=> $this->input->post('pre_district'),
			'spouse_name' 		=> $this->input->post('spouse_name'),

			'emp_dob' 			=> $dob,
			'gender' 			=> $this->input->post('gender'),
			'marital_status' 	=> $this->input->post('marital_status'),
			'religion'  		=> $this->input->post('religion'),
			'blood'  			=> $this->input->post('blood'),
			'm_child'			=> $this->input->post('m_child'),

			'f_child'			=> $this->input->post('f_child'),
			'nominee_name'		=> $this->input->post('nominee_name'),
			'nominee_vill'		=> $this->input->post('nominee_vill'),
			'nomi_post'			=> $this->input->post('nomi_post'),
			'nomi_thana'		=> $this->input->post('nomi_thana'),
			'nomi_district'		=> $this->input->post('nomi_district'),

			'nomi_age'			=> date("Y-m-d", strtotime($this->input->post('nomi_age'))),
			'nomi_nid'			=> $this->input->post('nomi_nid'),
			'nomi_nid_bc_check' => $this->input->post('nomi_nid_bc_check'),
			'nomi_mobile'		=> $this->input->post('nomi_mobile'),
			'nomi_relation'		=> $this->input->post('nomi_relation'),
			'refer_name'		=> $this->input->post('refer_name'),
			'refer_mobile'		=> $this->input->post('refer_mobile'),
			'refer_village'		=> $this->input->post('refer_village'),
			'ref_district'		=> $this->input->post('ref_district'),
			'ref_thana'			=> $this->input->post('ref_thana'),
			'ref_post'			=> $this->input->post('ref_post'),

			'refer_relation'	=> $this->input->post('refer_relation'),
			'education'			=> $this->input->post('education'),
			'nid_dob_id'		=> $this->input->post('nid_dob_id'),
			'nid_dob_check'		=> $this->input->post('nid_dob_check'),
			'exp_factory_name'	=> $this->input->post('exp_factory_name'),
			'exp_duration'		=> $this->input->post('exp_duration'),

			// 'exp_dasignation'	=> $this->input->post('exp_dasignation'),
			'exp_dasignation'	=> $this->input->post('exp_dasignation'),
			'personal_mobile'	=> $this->input->post('personal_mobile'),
			'bank_bkash_no'		=> $this->input->post('bank_bkash_no'),
			'hight'		=>  $this->input->post('hight'),
			'symbol'		=> $this->input->post('symbol'),
		);

		if($this->db->insert('pr_emp_com_info', $data)){
			$emp_id = $this->db->insert_id();
			$id= $this->db->select('emp_id')->where('id',$emp_id)->get('pr_emp_com_info')->row()->emp_id;
			$per_data['emp_id'] = $id;
			// dd($per_data);

			$img ="";
			if($_FILES["img_source"]["name"] != '')
			{
				$imgs = explode('.', $_FILES["img_source"]["name"]);
				$ext = end($imgs);

				$config['upload_path']    = './uploads/photo';
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['file_name'] 	  =  $id .'.'. $ext;
				$config['max_size']	 	  = '4000';
				$config['max_width']  	  = '5000';
				$config['max_height']     = '7000';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('img_source'))
				{
					$error = array('error' => $this->upload->display_errors());
					echo $error["error"];
				}
				else
				{
					$img_upload = array('upload_data' => $this->upload->data());
					$img = $img_upload["upload_data"]["file_name"];
				}

			}
			$signature="";
			if($_FILES["signature"]["name"] != '')
			{
				$imgs = explode('.', $_FILES["signature"]["name"]);
				$ext = end($imgs);

				$config['upload_path']    = './uploads/photo';
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['file_name'] 	  =  $id .'.'. $ext;
				$config['max_size']	 	  = '4000';
				// $config['max_width']  	  = '5000';
				// $config['max_height']     = '7000';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('signature'))
				{
					$error = array('error' => $this->upload->display_errors());
					echo $error["error"];
				}
				else
				{
					$img_upload = array('upload_data' => $this->upload->data());
					$signature = $img_upload["upload_data"]["file_name"];
				}

			}

			$per_data['img_source'] = $img;
			$per_data['signature'] = $signature;

			// dd($per_data);
			$this->db->insert('pr_emp_per_info', $per_data);

			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Inserted Successfully.'); window.location='personal_info';</SCRIPT>";
		} else {
		  echo "FAILED" ;
		  return ;
		}
	}


	function insert_emp_info_short()
	{
		if($this->input->post('emp_id') == '')
		{
			return ;
		}

		// Check for duplicate emp_id
		$this->db->select('emp_id');
		$this->db->where('emp_id', $this->input->post('emp_id'));
		$query = $this->db->get('pr_emp_com_info');
		if($query->num_rows() > 0) {
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Employee ID already exists.'); window.location='personal_info_short';</SCRIPT>";
			return ;
		}

		$ejd = date("Y-m-d", strtotime($this->input->post('emp_join_date')));
		$data = array(
			'emp_id'			=> $this->input->post('emp_id'),
			'unit_id'			=> $this->input->post('unit_id'),
			'emp_dept_id'  		=> $this->input->post('emp_dept_id'),
			'emp_sec_id' 		=> $this->input->post('emp_sec_id'),
			'emp_line_id' 		=> $this->input->post('emp_line_id'),
			'emp_desi_id'  		=> $this->input->post('emp_desi_id'),
			'emp_type'  		=> $this->input->post('emp_type'),

			'emp_sal_gra_id'  	=> $this->input->post('emp_sal_gra_id'),
			'emp_cat_id'		=> $this->input->post('emp_cat_id'),
			'proxi_id'			=> $this->input->post('proxi_id'),
			'emp_shift'  		=> $this->input->post('emp_shift'),
			'gross_sal'			=> $this->input->post('gross_sal'),
			'com_gross_sal'		=> $this->input->post('gross_sal'),
			'monitor_con'		=> 2,

			'ot_entitle'		=> $this->input->post('ot_entitle'),
			'com_ot_entitle'    => $this->input->post('com_ot_entitle'),
			'lunch'				=> $this->input->post('lunch'),
			'transport'			=> $this->input->post('transport'),
			'salary_draw'		=> $this->input->post('salary_draw'),
			'salary_type'		=> $this->input->post('salary_type'),
			'emp_join_date'		=> $ejd,

		);
		// dd($data);

		$dob = date("Y-m-d", strtotime($this->input->post('emp_dob')));
		$per_data = array(
			'name_bn' 			=> $this->input->post('name_bn'),
			'name_en' 			=> $this->input->post('name_bn'),
			'emp_dob' 			=> $dob,
			'gender' 			=> $this->input->post('gender'),
			'personal_mobile'	=> $this->input->post('personal_mobile'),
			'bank_bkash_no'		=> $this->input->post('bank_bkash_no'),
		);

		if($this->db->insert('pr_emp_com_info', $data)){
			$emp_id = $this->db->insert_id();
			$id= $this->db->select('emp_id')->where('id',$emp_id)->get('pr_emp_com_info')->row()->emp_id;
			$per_data['emp_id'] = $id;
			$this->db->insert('pr_emp_per_info', $per_data);

			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Inserted Successfully.'); window.location='personal_info_short';</SCRIPT>";
		} else {
		  echo "FAILED" ;
		  return ;
		}
	}

	function updatedb_short()
	{
		// dd($_POST);
		if($this->input->post('emp_id') == '')
		{
			return ;
		}
		$ejd = date("Y-m-d", strtotime($this->input->post('emp_join_date')));
		$data = array(
			'unit_id'			=> $this->input->post('unit_id'),
			'emp_id'			=> $this->input->post('emp_id'),
			'proxi_id'			=> $this->input->post('proxi_id'),
			'emp_dept_id'  		=> $this->input->post('emp_dept_id'),
			'emp_sec_id' 		=> $this->input->post('emp_sec_id'),
			'emp_line_id' 		=> $this->input->post('emp_line_id'),
			'emp_desi_id'  		=> $this->input->post('emp_desi_id'),
			'emp_type'  		=> $this->input->post('emp_type'),

			'emp_cat_id'		=> $this->input->post('emp_cat_id'),
			'emp_shift'  		=> $this->input->post('emp_shift'),
			'emp_join_date'		=> $ejd,
			'emp_sal_gra_id'  	=> $this->input->post('emp_sal_gra_id'),
			'salary_type'		=> $this->input->post('salary_type'),
			'salary_draw'		=> $this->input->post('salary_draw'),
			'lunch'				=> $this->input->post('lunch'),
			'transport'			=> $this->input->post('transport'),
			'gross_sal'			=> $this->input->post('gross_sal'),
			'ot_entitle'		=> $this->input->post('ot_entitle'),
			'com_gross_sal'		=> $this->input->post('com_gross_sal'),
			'com_ot_entitle'    => $this->input->post('com_ot_entitle'),

		);

		$dob = date("Y-m-d", strtotime($this->input->post('emp_dob')));
		$per_data = array(
			'name_bn' 			=> $this->input->post('name_bn'),
			'name_en' 			=> $this->input->post('name_en'),
			'emp_dob' 			=> $dob,
			'gender' 			=> $this->input->post('gender'),
			'personal_mobile'	=> $this->input->post('personal_mobile'),
			'bank_bkash_no'		=> $this->input->post('bank_bkash_no'),
		);
		$id = $this->input->post('emp_id');
		if($this->db->where('emp_id',$id)->update('pr_emp_com_info', $data)){
			$this->db->where('emp_id',$id)->update('pr_emp_per_info', $per_data);
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Updated Successfully.'); window.location='personal_info_short';</SCRIPT>";
		} else {
		  echo "FAILED" ;
		  return ;
		}
	}

	//==================================Employee Information View==============================
	//=========================================================================================

	function get_department_name()
	{
		//$get_session_user_unit = $this->common_model->get_session_unit_id_name();
		$this->db->select('*');
		//$this->db->where("unit_id",$get_session_user_unit);
		$this->db->from('pr_dept');
		$this->db->order_by('dept_name','ASC');
		return $query = $this->db->get();
	}

	function get_section_name()
	{
		//$get_session_user_unit = $this->common_model->get_session_unit_id_name();
		$this->db->select('*');
		//$this->db->where("unit_id",$get_session_user_unit);
		$this->db->from('pr_section');
		$this->db->order_by('sec_name','ASC');
		return $query = $this->db->get();
	}

	function get_designation_name()
	{
		//$get_session_user_unit = $this->common_model->get_session_unit_id_name();
		$this->db->select('*');
		//$this->db->where("unit_id",$get_session_user_unit);
		$this->db->from('pr_designation');
		$this->db->order_by('desig_name','ASC');
		return $query = $this->db->get();
	}

	function get_line_name()
	{
		//$get_session_user_unit = $this->common_model->get_session_unit_id_name();
		$this->db->select('*');
		//$this->db->where("unit_id",$get_session_user_unit);
		$this->db->from('pr_line_num');
		$this->db->order_by('line_name','ASC');
		return $query = $this->db->get();
	}

	function get_floor_name()
	{
		$this->db->select('*');
		$this->db->from('pr_floor');
		$this->db->order_by('id','ASC');
		return $query = $this->db->get();
	}

	function working_type_name()
	{
		$this->db->select('*');
		$this->db->from('pr_emp_nid_wk_typ');
		$this->db->order_by('id','ASC');
		return $query = $this->db->get();
	}

	function work_process_name()
	{
		$this->db->select('*');
		$this->db->from('pr_work_process');
		$this->db->order_by('id','ASC');
		return $query = $this->db->get();
	}

	function ot_show_or_not()
	{
		$this->db->select('*');
		$this->db->from('pr_ot_show_or_not');
		$this->db->order_by('id','ASC');
		return $query = $this->db->get();
	}

	function get_position_name()
	{
		$this->db->select('posi_id, posi_name');
		$this->db->from('pr_emp_position');
		$this->db->order_by('posi_id','ASC');
		return $query = $this->db->get();
	}

	function get_operation_name()
	{
		$this->db->select('ope_id, ope_name');
		$this->db->from('pr_emp_operation');
		$this->db->order_by('ope_name','ASC');
		return $query = $this->db->get();
	}

	function get_status_name()
	{
		$this->db->select('stat_id, stat_type');
		$this->db->from('pr_emp_status');
		$this->db->order_by('stat_id','ASC');
		return $query = $this->db->get();
	}

	function get_grade_name()
	{
		$this->db->select('gr_id, gr_name');
		$this->db->from('pr_grade');
		$this->db->order_by('gr_id','ASC');
		return $query = $this->db->get();
	}

	function get_yes_no_asc()
	{
		$this->db->select('id, name');
		$this->db->from('pr_yes_no');
		$this->db->order_by('name','ASC');
		return $query = $this->db->get();
	}

	function get_yes_no_desc()
	{
		$this->db->select('id, name');
		$this->db->from('pr_yes_no');
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query;
	}

	function get_shift_name()
	{
		$this->db->select('shift_id, shift_name');
		$this->db->from('pr_emp_shift');
		$this->db->order_by('shift_name','ASC');
		return $query = $this->db->get();
	}

	function get_emp_sts()
	{
		$this->db->select('id, emp_sts');
		$this->db->from('pr_emp_sts');
		$this->db->order_by('id','ASC');
		return $query = $this->db->get();
	}

	function get_salary_type_name()
	{
		$this->db->select('sal_type_id, sal_type_name');
		$this->db->from('pr_salry_types');
		$this->db->order_by('sal_type_id','ASC');
		return $query = $this->db->get();
	}

	function get_salary_withdraw_name()
	{
		$this->db->select('sal_withdraw_id, sal_withdraw_name');
		$this->db->from('pr_salary_withdraw');
		$this->db->order_by('sal_withdraw_id','ASC');
		return $query = $this->db->get();
	}

	function get_religion_name()
	{
		$this->db->select('religion_id, religion_name');
		$this->db->from('pr_religions');
		$this->db->order_by('religion_id','ASC');
		return $query = $this->db->get();
	}

	function get_matital_status_name()
	{
		$this->db->select('marrital_status_id, marrital_status_name');
		$this->db->from('pr_marrital_status');
		$this->db->order_by('marrital_status_id','ASC');
		return $query = $this->db->get();
	}

	function get_sex_name()
	{
		$this->db->select('sex_id, sex_name');
		$this->db->from('pr_emp_sex');
		$this->db->order_by('sex_id','ASC');
		return $query = $this->db->get();
	}

	function get_blood_name()
	{
		$this->db->select('blood_id, blood_name');
		$this->db->from('pr_emp_blood_groups');
		$this->db->order_by('blood_id','ASC');
		return $query = $this->db->get();
	}

	function get_att_bonus_name()
	{
		$this->db->select('ab_id,ab_rule_name');
		$this->db->from('pr_attn_bonus');
		$this->db->order_by('ab_id','ASC');
		return $query = $this->db->get();
	}

	function get_nomini_relation()
	{
		$this->db->select('*');
		$this->db->from('pr_nomini_relation');
		$this->db->order_by('id','ASC');
		return $query = $this->db->get();
	}


	//================================End Employee Information View=================================
	function updatedb1()
	{
		//dd($_POST);
		//dd($this->input->post('pre_thana'));
		$id = $this->input->post('emp_id');
		$ejd = date("Y-m-d", strtotime($this->input->post('emp_join_date')));
		$data = array(
			'unit_id'			=> $this->input->post('unit_id'),
			'emp_dept_id'  		=> $this->input->post('emp_dept_id'),
			'emp_sec_id' 		=> $this->input->post('emp_sec_id'),
			'emp_line_id' 		=> $this->input->post('emp_line_id'),
			'emp_desi_id'  		=> $this->input->post('emp_desi_id'),
			'emp_type'  		=> $this->input->post('emp_type'),

			'emp_sal_gra_id'  	=> $this->input->post('emp_sal_gra_id'),
			'emp_cat_id'		=> $this->input->post('emp_cat_id'),
			'proxi_id'			=> $this->input->post('proxi_id'),
			'emp_shift'  		=> $this->input->post('emp_shift'),
			'gross_sal'			=> $this->input->post('gross_sal'),
			'com_gross_sal'		=> $this->input->post('com_gross_sal'),

			'ot_entitle'		=> $this->input->post('ot_entitle'),
			'com_ot_entitle'		=> $this->input->post('com_ot_entitle'),
			'lunch'				=> $this->input->post('lunch'),
			'transport'			=> $this->input->post('transport'),
			'salary_draw'		=> $this->input->post('salary_draw'),
			'salary_type'		=> $this->input->post('salary_type'),
			'emp_join_date'		=> $ejd,
			'hight'		=> $this->input->post('hight'),
			'symbol'		=> $this->input->post('symbol'),
		);
		//dd($data);

		$dob = date("Y-m-d", strtotime($this->input->post('emp_dob')));
		$per_data = array(
			'name_en' 			=> $this->input->post('name_en'),
			'name_bn' 			=> $this->input->post('name_bn'),
			'father_name' 		=> $this->input->post('father_name'),
			'mother_name' 		=> $this->input->post('mother_name'),
			'per_village'		=> $this->input->post('per_village'),
			'per_village_bn'	=> $this->input->post('per_village_bn'),

			'per_post'			=> $this->input->post('per_post'),
			'per_thana'			=> $this->input->post('per_thana'),
			'per_district'		=> $this->input->post('per_district'),
			'pre_home_owner'	=> $this->input->post('pre_home_owner'),
			'holding_num'		=> $this->input->post('holding_num'),
			'home_own_mobile'	=> $this->input->post('home_own_mobile'),

			'pre_village'		=> $this->input->post('pre_village'),
			'pre_village_bn'	=> $this->input->post('pre_village_bn'),
			'pre_post'			=> $this->input->post('pre_post'),
			'pre_thana'			=> $this->input->post('pre_thana'),
			'pre_district'		=> $this->input->post('pre_district'),
			'spouse_name' 		=> $this->input->post('spouse_name'),

			'emp_dob' 			=> $dob,
			'gender' 			=> $this->input->post('gender'),
			'marital_status' 	=> $this->input->post('marital_status'),
			'religion'  		=> $this->input->post('religion'),
			'blood'  			=> $this->input->post('blood'),
			'm_child'			=> $this->input->post('m_child'),

			'f_child'			=> $this->input->post('f_child'),
			'nominee_name'		=> $this->input->post('nominee_name'),
			'nominee_vill'		=> $this->input->post('nominee_vill'),
			'nomi_post'			=> $this->input->post('nomi_post'),
			'nomi_thana'		=> $this->input->post('nomi_thana'),
			'nomi_district'		=> $this->input->post('nomi_district'),

			'nomi_age'			=> date("Y-m-d", strtotime($this->input->post('nomi_age'))),
			'nomi_nid'			=> $this->input->post('nomi_nid'),
			'nomi_mobile'		=> $this->input->post('nomi_mobile'),
			'nomi_relation'		=> $this->input->post('nomi_relation'),
			'refer_name'		=> $this->input->post('refer_name'),
			'refer_mobile'		=> $this->input->post('refer_mobile'),
			'refer_village'		=> $this->input->post('refer_village'),
			'ref_district'		=> $this->input->post('ref_district'),
			'ref_thana'			=> $this->input->post('ref_thana'),
			'ref_post'			=> $this->input->post('ref_post'),

			'refer_relation'	=> $this->input->post('refer_relation'),
			'education'			=> $this->input->post('education'),
			'nid_dob_id'		=> $this->input->post('nid_dob_id'),
			'nid_dob_check'		=> $this->input->post('nid_dob_check'),
			'nomi_nid_bc_check'	=> $this->input->post('nomi_nid_bc_check'),
			'exp_factory_name'	=> $this->input->post('exp_factory_name'),
			'exp_duration'		=> $this->input->post('exp_duration'),

			'exp_dasignation'	=> $this->input->post('exp_dasignation'),
			'personal_mobile'	=> $this->input->post('personal_mobile'),
			'bank_bkash_no'		=> $this->input->post('bank_bkash_no'),
			'hight'		=> $this->input->post('hight'),
			'symbol'		=> $this->input->post('symbol'),

		);

		if($this->db->where('emp_id',$id)->update('pr_emp_com_info', $data))
		{
			$ids = $this->db->where('emp_id',$id)->get('pr_emp_com_info')->row()->emp_id;
			$per_data['emp_id'] = $ids;
			$img = "";
			if($_FILES["img_source"]["name"] != '')
			{
				$imgs = explode('.', $_FILES["img_source"]["name"]);
				$ext = end($imgs);

				$config['upload_path']    = './uploads/photo';
	            $config['allowed_types']  = 'jpg|png|jpeg';
				$config['file_name'] 	  =  $per_data['emp_id'] .'.'. $ext;
				$config['max_size']	 	  = '4000';
				$config['max_width']  	  = '5000';
				$config['max_height']     = '7000';
	        	$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('img_source')){
					$error = array('error' => $this->upload->display_errors());
					echo $error["error"];
				}else{
					$img_upload = array('upload_data' => $this->upload->data());
					$img = $img_upload["upload_data"]["file_name"];
					$per_data['img_source'] = $img;
				}
			}

			if($_FILES["signature"]["name"] != ''){
				$imgs = explode('.', $_FILES["signature"]["name"]);
				$ext = end($imgs);

				$config['upload_path']    = './uploads/emp_signature';
	            $config['allowed_types']  = 'jpg|png|jpeg';
				$config['file_name'] 	  =  $per_data['emp_id'] .'.'. $ext;
				$config['max_size']	 	  = '4000';
				// $config['max_width']  	  = '5000';
				// $config['max_height']     = '7000';
	        	$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('signature'))
				{
					$error = array('error' => $this->upload->display_errors());
					echo $error["error"];
				}
				else
				{
					$img_upload = array('upload_data' => $this->upload->data());
					$signature = $img_upload["upload_data"]["file_name"];
					$per_data['signature'] = $signature;
				}
			}
			//dd($ids);

			if($this->db->where('emp_id',$ids)->update('pr_emp_per_info', $per_data)){
				//dd('ok');
				echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Update Successfully.'); window.location='personal_info';</SCRIPT>";
			}else{
				//dd('failed');
				echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Update Failed.'); window.location='personal_info';</SCRIPT>";
			}
		} else {
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Update Failed.'); window.location='personal_info';</SCRIPT>";
		  	return ;
		}
	}

	function proxi_id_check_for_save($emp_id, $proxi_id)
	{
		$this->db->select('proxi_id');
		$this->db->where('proxi_id', $proxi_id);
		$query = $this->db->get('pr_id_proxi');
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function proxi_id_check_for_edit($emp_id, $proxi_id)
	{
		$this->db->select('proxi_id');
		$this->db->where('proxi_id', $proxi_id);
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('pr_id_proxi');
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			$this->db->select('proxi_id');
			$this->db->where('proxi_id', $proxi_id);
			$query = $this->db->get('pr_id_proxi');
			if($query->num_rows() == 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function insertdb1()
	{
		if($this->input->post('empid') =='')
		{
			return ;
		}
		if($_FILES["userfile"]["name"] != '')
		{
			$config['upload_path'] = './uploads/photo/';
			$config['allowed_types'] = '*';
			$config['max_size']	= '4000';
			$config['max_width']  = '5000';
			$config['max_height']  = '7000';
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
				echo $error["error"];
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$img = $data["upload_data"]["file_name"];
			}
		}
		else
		{
			$img ="";
		}

		$dob = $this->input->post('dob');
		$dob = date("Y-m-d", strtotime($dob));

		$data = array(
			'emp_id'			=> $this->input->post('empid'),
			'emp_full_name' 	=> $this->input->post('name'),
			'bangla_nam' 		=> $this->input->post('bname'),
			'emp_mname' 		=> $this->input->post('mname'),
			'emp_mname_bn' 		=> $this->input->post('mname_bn'),
			'emp_fname' 		=> $this->input->post('fname'),
			'emp_fname_bn' 		=> $this->input->post('fname_bn'),
			'spouse_name' 		=> $this->input->post('spouse_name'),
			'emp_dob'  			=> $dob,
			'emp_religion'  	=> $this->input->post('reli'),
			'emp_sex'  			=> $this->input->post('sex'),
			'emp_marital_status'=> $this->input->post('ms'),
			'emp_blood'			=> $this->input->post('bgroup'),
			'img_source'		=> $img,
			'emp_n_id'			=> $this->input->post('n_id'),
			'bank_ac_no'		=> $this->input->post('bank_ac_no'),
			'hight'				=> $this->input->post('ft').'-'.$this->input->post('inches'),
			'symbol'			=> $this->input->post('symbol'),
			);

		$this->db->insert('pr_emp_per_info', $data);

		$adddata = array(
			'emp_id'			=> $this->input->post('empid'),
			'emp_pre_add'  		=> $this->input->post('padd'),
			'emp_par_add'  		=> $this->input->post('fadd'),
			'emp_pre_add_ban'	=> $this->input->post('preadd_bn'),
			'emp_par_add_ban'	=> $this->input->post('peradd_bn'),
			'mobile'		 	=> $this->input->post('mobile_no')
			);
		$this->db->insert('pr_emp_add', $adddata) ;

		$ejd = $this->input->post('ejd');
		$ejd = date("Y-m-d", strtotime($ejd));

		$data2 = array(
			'emp_id'			=> $this->input->post('empid'),
			'unit_id'			=> $this->input->post('units'),
			'emp_dept_id'  		=> $this->input->post('dept'),
			'emp_sec_id' 		=> $this->input->post('sec'),
			'emp_line_id' 		=> $this->input->post('line'),
			'emp_desi_id'  		=> $this->input->post('desig'),
			'emp_type'  		=> $this->input->post('emp_type'),
			'emp_operation_id'	=> $this->input->post('operation'),
			'emp_position_id'  	=> $this->input->post('position'),
			'floor_id'			=> $this->input->post('emp_floor'),
			'emp_sts_id'  		=> $this->input->post('emp_sts_id'),
			'emp_sal_gra_id'	=> $this->input->post('salg'),
			'emp_cat_id'  		=> $this->input->post('empstat'),
			'emp_shift'  		=> $this->input->post('empshift'),
			'gross_sal'  		=> $this->input->post('text8'),
			'com_gross_sal'  	=> $this->input->post('text9'),
			'ot_entitle'  		=> $this->input->post('otentitle'),
			'transport'  		=> $this->input->post('transport'),
			'lunch'  			=> $this->input->post('lunch'),
			'att_bonus'  		=> $this->input->post('attbonus'),
			'emp_join_date'		=> $ejd,
			'salary_draw'		=> $this->input->post('saldraw'),
			'salary_type'		=> $this->input->post('saltype'),
			'wk_type_id'		=> $this->input->post('working_type'),
			'work_process_id'	=> $this->input->post('work_process'),
			'ot_show_in'	    => $this->input->post('ot_define')
			);

		$pr_id_proxi = array(
			'emp_id'	=> $this->input->post('empid'),
			'proxi_id'  => $this->input->post('idcard')
			);

		$emp_status = $this->input->post('empstat');

		$data_edu = array(
			'emp_id'	=> $this->input->post('empid'),
			'emp_degree'  => $this->input->post('text2'),
			'emp_pass_yr' => $this->input->post('text3'),
			'emp_ins' => $this->input->post('text4')
			);
		$this->db->insert('pr_emp_edu', $data_edu);

		$data_skill = array(
			'emp_id'	=> $this->input->post('empid'),
			'emp_skill'  => $this->input->post('text5'),
			'emp_yr_skill' => $this->input->post('text6'),
			'emp_com_name' => $this->input->post('text7')
			);
		$this->db->insert('pr_emp_skill', $data_skill);

		if($this->db->insert('pr_emp_com_info', $data2) and $this->db->insert('pr_id_proxi', $pr_id_proxi) )
		{
			$this->load->dbforge();
			$id = $this->input->post('empid');
			$temp_table = "temp_$id";
			$temp_fields = array(
			'att_id' 	=> array( 'type' => 'INT','constraint' => '11',  'auto_increment' => TRUE),
			'device_id' => array( 'type' => 'INT','constraint' => '11'),
			'proxi_id'  => array( 'type' => 'INT','constraint' => '11'),
			'date_time' => array( 'type' => 'datetime')
		);
		$this->dbforge->add_field($temp_fields);
		$this->dbforge->add_key('att_id', TRUE);
		$this->dbforge->create_table($temp_table);
		// PROFILE LOG Generate
		$log_username = $this->session->userdata('username');
		$log_emp_id   = $this->input->post('empid');
		$this->log_model->log_profile_insert($log_username, $log_emp_id);
		echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Inserted Successfully.'); window.location='personal_info_view1';</SCRIPT>";
		}
		else
		{
		  echo "FAILED" ;
		  return ;
		}
	}
	function emp_id_existance_check($emp_id)
	{
		$this->db->select('emp_id');
		$this->db->where('emp_id',$emp_id);
		$query = $this->db->get('pr_emp_com_info');
		$num_rows = $query->num_rows();

		if( $num_rows == 1)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	function deletedb()
	{
		$id=$this->input->post('empid');
		$this->db->select("emp_id");
		$this->db->where('emp_id',$id);
		$query = $this->db->get("pr_emp_per_info");
		$num_row = $query->num_rows();
		if($num_row > 0 )
		{
			$this->db->where('emp_id',$id);
			$this->db->delete('pr_emp_com_info');
			$this->db->where('emp_id',$id);
			$this->db->delete('pr_id_proxi');
			$this->db->where('emp_id',$id);
			$this->db->delete('pr_emp_edu');
			$this->db->where('emp_id',$id);
			$this->db->delete('pr_emp_skill');
			$this->db->where('emp_id',$id);
			$this->db->delete('pr_emp_add');
			$this->db->where('emp_id',$id);
			if($this->db->delete('pr_emp_per_info'))
			{
				$this->load->dbforge();
				$table_name = "temp_$id";
				if($this->dbforge->drop_table($table_name))
				{
					echo "Delete all data successfully";
				}
				else
				{
					echo "Delete failed";
				}
			}
			else
			{
				echo "Delete failed";
			}
		}
		else
		{
			echo "Employee ID does not exist";
		}
	}

	function rename_empid()
	{
		$this->load->dbforge();
		$this->db->select("emp_id");
		//$this->db->where('emp_id', "OF0009");
		$query = $this->db->get("pr_emp_per_info");

		$num_row = $query->num_rows();
		foreach($query->result() as $rows)
		{
			$id = $rows->emp_id;
			//$rename_id = substr($id,2,10);
			$rename_id = "0".$id;
			//echo $rename_id."<br>";
			$data = array(
			'emp_id' => $rename_id
			);
			$this->db->where('emp_id',$id);
			$this->db->update('pr_emp_com_info', $data);

			$this->db->where('emp_id',$id);
			$this->db->update('pr_id_proxi', $data);

			$this->db->where('emp_id',$id);
			$this->db->update('pr_emp_edu', $data);

			$this->db->where('emp_id',$id);
			$this->db->update('pr_emp_skill', $data);

			$this->db->where('emp_id',$id);
			$this->db->update('pr_emp_add', $data);

			$this->db->where('emp_id',$id);
			$this->db->update('pr_emp_per_info', $data);
		}
		$old_table_name = "temp_$id";
		$new_table_name = "temp_$rename_id";
		$this->dbforge->rename_table($old_table_name, $new_table_name );
	}

	//==============================Employee Information Search=================================
	//==========================================================================================

	function get_unit_id_name($unit_id)
	{
		$this->db->select('*');
		$this->db->from('pr_units');
		if($unit_id != 0)
		{
			$this->db->where("unit_id",$unit_id);
		}
		$this->db->order_by("unit_name");
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->unit_id;
			$data2[] = $row->unit_name;

		}
		$unit_id = implode('***', $data1);
		$unit_name = implode('***', $data2);
		return $unit_id."===".$unit_name;
	}

	function get_floor_id_name($unit_id)
	{
		$this->db->select('*');
		$this->db->from('pr_floor');
		if($unit_id != 0)
		{
			$this->db->where("unit_id",$unit_id);
		}
		$this->db->order_by("id");
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->id;
			$data2[] = $row->floor_name;

		}
		$id = implode('***', $data1);
		$floor_name = implode('***', $data2);
		return $id."===".$floor_name;
	}

	function wk_type_id_name()
	{
		$this->db->select('*');
		$this->db->from('pr_emp_nid_wk_typ');
		$this->db->order_by("id");
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->id;
			$data2[] = $row->wk_type;

		}
		$id = implode('***', $data1);
		$wk_type = implode('***', $data2);
		return $id."===".$wk_type;
	}

	function dept_search($unit_id)
	{
		$this->db->select('*');
		$this->db->from('emp_depertment');
		$this->db->where("unit_id",$unit_id);
		$this->db->order_by('dept_name','ASC');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->dept_id;
			$data2[] = $row->dept_name;

		}
		$dept_id = implode('***', $data1);
		$dept_name = implode('***', $data2);
		return $dept_id_name = "$dept_id===$dept_name";
	}

	function blood_search()
	{
		$this->db->select('*');
		$this->db->from('pr_emp_blood_groups');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->blood_id;
			$data2[] = $row->blood_name;

		}
		$blood_id = implode('***', $data1);
		$blood_name = implode('***', $data2);
		return $blood_id_name = "$blood_id===$blood_name";
	}

	function section_search($unit_id)
	{
		$this->db->select('pr_section.sec_id,pr_section.sec_name,pr_section.sec_bangla');
		$this->db->from('pr_section');
		$this->db->where("unit_id",$unit_id);
		$this->db->order_by('sec_name','ASC');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		$data3 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->sec_id;
			$data2[] = $row->sec_name;
			$data3[] = $row->sec_bangla;
		}
		$sec_id 	= implode('***', $data1);
		$sec_name 	= implode('***', $data2);
		$sec_bangla = implode('***', $data3);
		return $sec_id_name = "$sec_id===$sec_name===$sec_bangla";
	}

	function line_search($unit_id)
	{
		$this->db->select('*');
		$this->db->from('pr_line_num');
		$this->db->where("unit_id",$unit_id);
		$this->db->order_by("line_name");
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->line_id;
			$data2[] = $row->line_name;

		}
		$line_id 	= implode('***', $data1);
		$line_name 	= implode('***', $data2);
		return $line_id."===".$line_name;
	}

	function desig_search($unit_id)
	{
		$this->db->select('desig_id,desig_name,desig_bangla');
		$this->db->from('pr_designation');
		$this->db->where('unit_id',$unit_id);
		$this->db->order_by('desig_name','ASC');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach($query->result() as $row)
		{
			$data1[] = $row->desig_id;
			$data2[] = $row->desig_name;
			$data3[] = $row->desig_bangla;
		}
		$desig_id = implode('***', $data1);
		$desig_name = implode('***', $data2);
		$desig_bangla = implode('***', $data3);
		return $desig_id."===".$desig_name."===".$desig_bangla;
	}

	function operation_search()
	{
		$this->db->select('*');
		$this->db->from('pr_emp_operation');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->ope_id;
			$data2[] = $row->ope_name;
		}
		$operation_id = implode('=*=', $data1);
		$operation_name = implode('=*=', $data2);
		return $operation_id_name = "$operation_id===$operation_name";
	}

	function position_search()
	{
		$this->db->select('*');
		$this->db->from('pr_emp_position');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->posi_id ;
			$data2[] = $row->posi_name ;

		}
		$position_id = implode('=*=', $data1);
		$position_name = implode('=*=', $data2);
		return $position_id_name = "$position_id===$position_name";
	}

	function grade_search()
	{
		$this->db->select('gr_id,gr_name');
		$this->db->from('pr_grade');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->gr_id;
			$data2[] = $row->gr_name;
		}
		$grade_id = implode('***', $data1);
		$grade_name = implode('***', $data2);
		return $grade_id."===".$grade_name;
	}

	function empstat_search()
	{
		$this->db->select('stat_id,stat_type');
		$this->db->from('pr_emp_status');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->stat_id;
			$data2[] = $row->stat_type;
		}
		$empstat_id 	= implode('***', $data1);
		$empstat_name 	= implode('***', $data2);
		return $empstat_id."===".$empstat_name;
	}

	function attbonus_search()
	{
		$this->db->select('ab_id,ab_rule_name');
		$this->db->from('pr_attn_bonus');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->ab_id;
			$data2[] = $row->ab_rule_name;
		}
		$ab_id = implode('***', $data1);
		$ab_rule_name = implode('***', $data2);
		return $ab_id."===".$ab_rule_name;
	}

	function shift_search($unit_id)
	{
		$this->db->select('*');
		$this->db->from('pr_emp_shift');
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->shift_id;
			$data2[] = $row->shift_name;
		}
		$shift_id = implode('***', $data1);
		$shift_name = implode('***', $data2);
		return $shift_id."===".$shift_name;
	}

	function emp_sts_search($unit_id = 0)
	{
		$this->db->select('*');
		$this->db->from('pr_emp_sts');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->id;
			$data2[] = $row->emp_sts;
		}
		$id = implode('***', $data1);
		$emp_sts = implode('***', $data2);
		return $id."===".$emp_sts;
	}

	function work_process_search($unit_id = 0)
	{
		$this->db->select('*');
		$this->db->from('pr_work_process');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->id;
			$data2[] = $row->process;
		}
		$id = implode('***', $data1);
		$process = implode('***', $data2);
		return $id."===".$process;
	}

	function ot_show_in_search($unit_id = 0)
	{
		$this->db->select('*');
		$this->db->from('pr_ot_show_or_not');
		$query = $this->db->get();
		$data1 = array();
		$data2 = array();
		foreach ($query->result() as $row)
		{
			$data1[] = $row->id;
			$data2[] = $row->salary_name;
		}
		$id = implode('***', $data1);
		$salary_name = implode('***', $data2);
		return $id."===".$salary_name;
	}

	function manual_atten_db()
	{
		// return "string"; die();
		$unit_id 		= $this->input->post('start');
		$dept_id_name 	= $this->dept_search($unit_id);
		$sec_id_name 	= $this->section_search($unit_id);
		$line_id_name 	= $this->line_search($unit_id);
		$desig_id_name 	= $this->desig_search($unit_id);
		$status_id_name = $this->empstat_search();
		return $alldata = $dept_id_name."$$$".$sec_id_name."$$$".$line_id_name."$$$".$desig_id_name."$$$".$status_id_name;

	}

	function com_info_search1($emp_id){
		$data = array();
		$this->db->select('
				pr_emp_com_info.emp_id as emp_id,
				pr_emp_com_info.unit_id as unit_id,
				pr_units.unit_name as unit_name,
				emp_depertment.dept_name as dept_name,
				emp_section.sec_name as sec_name,
				emp_section.sec_bangla,
				emp_line_num.line_name as line_name,
				emp_designation.desig_name,
				emp_designation.desig_bangla,
				pr_grade.gr_name as gr_name,
				emp_category_status.stat_type as stat_type,
				pr_emp_com_info.gross_sal as gross_sal,
				pr_emp_com_info.emp_join_date as emp_join_date,
				pr_emp_com_info.ot_entitle as ot_entitle,
				pr_emp_com_info.transport as transport,
				pr_emp_com_info.lunch as lunch,
				pr_emp_com_info.att_bonus as att_bonus,
				pr_emp_com_info.salary_draw as salary_draw,
				pr_emp_com_info.salary_type as salary_type,
				pr_emp_shift.shift_name as shift_name,
				pr_emp_com_info.com_gross_sal as com_gross_sal,
				pr_emp_com_info.emp_sts_id,
				pr_ot_show_or_not.*
			');
		$this->db->from('pr_emp_com_info');
		$this->db->join('pr_units','pr_units.unit_id = pr_emp_com_info.unit_id','LEFT');
		$this->db->join('emp_depertment','emp_depertment.dept_id = pr_emp_com_info.emp_dept_id','LEFT');
		$this->db->join('emp_section','emp_section.sec_id = pr_emp_com_info.emp_sec_id','LEFT');
		$this->db->join('emp_line_num','emp_line_num.line_id = pr_emp_com_info.emp_line_id','LEFT');
		$this->db->join('emp_designation','emp_designation.desig_id = pr_emp_com_info.emp_desi_id','LEFT');
		// $this->db->join('pr_emp_operation','pr_emp_operation.ope_id = pr_emp_com_info.emp_operation_id','LEFT');
		// $this->db->join('pr_emp_position','pr_emp_position.posi_id = pr_emp_com_info.emp_position_id','LEFT');
		// $this->db->join('pr_floor','pr_floor.id = pr_emp_com_info.floor_id','LEFT');
		// $this->db->join('pr_emp_nid_wk_typ','pr_emp_nid_wk_typ.id = pr_emp_com_info.wk_type_id','LEFT');
		$this->db->join('pr_grade','pr_grade.gr_id = pr_emp_com_info.emp_sal_gra_id','LEFT');
		$this->db->join('emp_category_status','emp_category_status.id = pr_emp_com_info.emp_cat_id','LEFT');
		$this->db->join('pr_emp_shift','pr_emp_shift.shift_id = pr_emp_com_info.emp_shift','LEFT');
		// // $this->db->join('pr_emp_sts','pr_emp_sts.id = pr_emp_com_info.emp_sts_id','LEFT');
		// $this->db->join('pr_work_process','pr_work_process.id = pr_emp_com_info.work_process_id','LEFT');
		// $this->db->join('pr_ot_show_or_not','pr_ot_show_or_not.id = pr_emp_com_info.ot_show_in','LEFT');

		$this->db->where("pr_emp_com_info.emp_id", $emp_id);


		$query = $this->db->get();
		// echo "<pre>"; print_r($data['dd'] = $query->result());exit;

		$this->db->select('emp_id');
		$this->db->where('emp_id',$emp_id);
		$query1 = $this->db->get('pr_emp_com_info');


		if($query1->num_rows() > 0 )
		{
			foreach ($query->result() as $row)
			{
				$ejd = $row->emp_join_date;
				$ejd = date("d-m-Y", strtotime($ejd));

				$data = array(
				'emp_id'		=> $row->emp_id,
				'proxi_id'  	=> $row->proxi_id,
				'dept_name'  	=> $row->dept_name,
				'sec_name' 	=> $row->sec_name,
				'line_name' 	=> $row->line_name,
				'desig_name'  => $row->desig_name,
				'ope_name'  	=> $row->ope_name,
				'posi_name'  	=> $row->posi_name,
				'gr_name'  	=> $row->gr_name,
				'stat_type'  	=> $row->stat_type,
				'shift_name'  => $row->shift_name,
				'gross_sal'  	=> $row->gross_sal,
				'ot_entitle'  => $row->ot_entitle,
				'transport'  	=> $row->transport,
				'lunch'  		=> $row->lunch,
				'att_bonus'  	=> $row->att_bonus,
				'emp_join_date' => $ejd,
				'salary_draw'	=> $row->salary_draw,
				'salary_type'	=> $row->salary_type,
				'com_gross_sal' => $row->com_gross_sal,
				'unit_name'  	=> $row->unit_name,
				'floor_name'	=> $row->floor_name,
				'wk_type' 	=> $row->wk_type,
				'desi_name_bn' => $row->desig_bangla,
				'sec_bangla' 	 => $row->sec_bangla,
				'emp_sts' 	 => $row->emp_sts,
				'work_process' => $row->process,
				'salary_name'  => $row->salary_name,
				'emp_sts_id'   => $row->emp_sts_id,
				);
				// print_r($data);
				$unit_id = $row->unit_id;
				$get_session_user_unit = $this->common_model->get_session_unit_id_name();
				if($get_session_user_unit != 0)
				{
					if($unit_id != $get_session_user_unit)
					{
						return "Access Denied";
					}
				}

			}

			$com_info = implode('=*=', $data);
			//GET DEPARTMENT ID BY EMP ID
			$this->db->select('emp_dept_id');
			$this->db->where('emp_id',$emp_id);
			$query2 = $this->db->get('pr_emp_com_info');
			$row = $query2->row();
			$dept_id = $row->emp_dept_id;
			//END

			$this->db->select('pr_emp_com_info.emp_id as empid,pr_emp_add.*,pr_emp_edu.* ,pr_emp_per_info.*,pr_emp_skill.*,ebg.blood_name');
			$this->db->from('pr_emp_com_info');

			$this->db->join('pr_emp_per_info','pr_emp_per_info.emp_id = pr_emp_com_info.emp_id ','LEFT');
			$this->db->join('pr_emp_add','pr_emp_add.emp_id = pr_emp_com_info.emp_id ','LEFT');
			$this->db->join('pr_emp_edu','pr_emp_edu.emp_id = pr_emp_com_info.emp_id ','LEFT');
			$this->db->join('pr_emp_skill','pr_emp_skill.emp_id = pr_emp_com_info.emp_id ','LEFT');
			$this->db->join('pr_emp_blood_groups as ebg','ebg.blood_id = pr_emp_per_info.emp_blood ','LEFT');

			$this->db->where("pr_emp_com_info.emp_id", $emp_id);

			$query4 = $this->db->get();
			// /*return*/ echo "<pre>"; print_r($query4->result()); exit;

			foreach ($query4->result() as $row)
			{
				$emp_dob = $row->emp_dob;
				$emp_dob = date("d-m-Y", strtotime($emp_dob));

				$data2 = array(
					'emp_id'				=> $row->emp_id,
					'emp_pre_add'  			=> $row->emp_pre_add,
					'emp_par_add'  			=> $row->emp_par_add,
					'emp_degree' 			=> $row->emp_degree,
					'emp_pass_yr'  			=> $row->emp_pass_yr,
					'emp_ins'  				=> $row->emp_ins,
					'emp_skill'  			=> $row->emp_skill,
					'emp_yr_skill'  		=> $row->emp_yr_skill,
					'emp_com_name'  		=> $row->emp_com_name,
					'emp_full_name'  		=> $row->emp_full_name,
					'emp_fname'  			=> $row->emp_fname,
					'emp_mname'  			=> $row->emp_mname,
					'emp_fname_bn'  		=> $row->emp_fname_bn,
					'emp_mname_bn'  		=> $row->emp_mname_bn,
					'emp_dob'  				=> $emp_dob,
					'emp_religion'  		=> $row->emp_religion,
					'emp_sex'  				=> $row->emp_sex,
					'emp_marital_status'  	=> $row->emp_marital_status,
					'emp_blood'  			=> $row->emp_blood,
					'img_source'  			=> $row->img_source,
					'mobile'  				=> $row->mobile,
					'bangla_nam'  		    => $row->bangla_nam,
					'id_skill'  			=> $row->id,
					'spouse_name' 			=> $row->spouse_name,
					'emp_pre_add_ban'		=> $row->emp_pre_add_ban,
					'emp_par_add_ban'		=> $row->emp_par_add_ban,
					'nid'					=> $row->emp_n_id,
					'bank_ac_no'			=> $row->bank_ac_no,
					'blood_name'			=> $row->blood_name,
				);
			}

			$other_info 		= implode('=*=', $data2);
			$unit_id_name 		= $this->get_unit_id_name($unit_id);
			$floor_id_name 		= $this->get_floor_id_name($unit_id);
			$dept_id_name 		= $this->dept_search($unit_id);
			$sec_id_name 		= $this->section_search($unit_id);
			$wk_type_id_name 	= $this->wk_type_id_name();
			$line_id_name 		= $this->line_search($unit_id);
			$desig_id_name 		= $this->desig_search($unit_id);
			$operation_id_name 	= $this->operation_search();
			$position_id_name 	= $this->position_search();
			$salg_id_name 		= $this->grade_search();
			$empstat_id_name 	= $this->empstat_search();
			$attbonus_id_name 	= $this->attbonus_search();
			$shift_id_name 		= $this->shift_search($unit_id);
			$emp_sts_id_name 	= $this->emp_sts_search();
			$w_process_id_name 	= $this->work_process_search();
			$salary_id_name 	= $this->ot_show_in_search();
			$blood_id_name 		= $this->blood_search();


			/*print_r($unit_id_name);
			print_r($dept_id_name);
			print_r($sec_id_name);
			print_r($line_id_name);
			print_r($desig_id_name);
			print_r($operation_id_name);
			print_r($position_id_name);
			print_r($salg_id_name);
			print_r($empstat_id_name);
			print_r($attbonus_id_name);
			print_r($shift_id_name);*/

			// print_r($other_info); exit;
			// echo "<pre>"; print_r($other_info); exit;

			return $alldata = "$other_info-*-$com_info-*-$dept_id_name-*-$sec_id_name-*-$line_id_name-*-$desig_id_name-*-$operation_id_name-*-$position_id_name-*-$salg_id_name-*-$empstat_id_name-*-$shift_id_name-*-$attbonus_id_name-*-$unit_id_name-*-$floor_id_name-*-$wk_type_id_name-*-$emp_sts_id_name-*-$w_process_id_name-*-$salary_id_name-*-$blood_id_name";
		}
		else
		{
			echo "Employee ID does not exist";
		}
	}

	function com_incre_prom_search()
	{
		$emp_id = $this->input->post('empid');
		$this->db->select('pr_emp_com_info.emp_id as emp_id,pr_emp_com_info.unit_id as unit_id,pr_id_proxi.proxi_id as proxi_id,pr_units.unit_name as unit_name,pr_dept.dept_name as dept_name,pr_section.sec_name as sec_name,pr_line_num.line_name as line_name,pr_designation.desig_name as desig_name, pr_emp_operation.ope_name as ope_name, pr_emp_position.posi_name as posi_name, pr_grade.gr_name as gr_name,pr_emp_status.stat_type as stat_type, pr_emp_com_info.gross_sal as gross_sal, pr_emp_com_info.emp_join_date as emp_join_date,pr_emp_com_info.ot_entitle as ot_entitle,pr_emp_com_info.transport as transport,pr_emp_com_info.lunch as lunch,pr_emp_com_info.att_bonus as att_bonus, pr_emp_com_info.salary_draw as salary_draw, pr_emp_com_info.salary_type as salary_type, pr_emp_shift.shift_name as shift_name,pr_emp_com_info.com_gross_sal as com_gross_sal');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_id_proxi');
		$this->db->from('pr_dept');
		$this->db->from('pr_units');
		$this->db->from('pr_section');
		$this->db->from('pr_line_num');
		$this->db->from('pr_designation');
		$this->db->from('pr_emp_operation');
		$this->db->from('pr_emp_position');
		$this->db->from('pr_grade');
		$this->db->from('pr_emp_status');
		$this->db->from('pr_emp_shift');
		$where = "pr_emp_com_info.emp_id = '$emp_id'  and pr_emp_com_info.emp_id = pr_id_proxi.emp_id and pr_emp_com_info.unit_id = pr_units.unit_id and pr_emp_com_info.emp_dept_id = pr_dept.dept_id and pr_emp_com_info.emp_sec_id = pr_section.sec_id and pr_emp_com_info.emp_line_id = pr_line_num.line_id and pr_emp_com_info.emp_desi_id = pr_designation.desig_id and pr_emp_com_info.emp_operation_id = pr_emp_operation.ope_id and pr_emp_com_info.emp_position_id = pr_emp_position.posi_id and pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id and pr_emp_com_info.emp_cat_id = pr_emp_status.stat_id and pr_emp_shift.shift_id = pr_emp_com_info.emp_shift";

		$this->db->where($where);
		$query = $this->db->get();

		$this->db->select('*');
		$this->db->where('emp_id',$emp_id);
		$query1 = $this->db->get('pr_emp_com_info');

		if($query1->num_rows() > 0 )
		{
			foreach ($query->result() as $row)
			{
				$ejd = $row->emp_join_date;
				//echo $row->gross_sal;
				$ejd = date("d-m-Y", strtotime($ejd));

				$data = array(
					'emp_id'		=> $row->emp_id,
					'proxi_id'  	=> "proxi",
					'dept_name'  	=> $row->dept_name,
					'sec_name' 		=> $row->sec_name,
					'line_name' 	=> $row->line_name,
					'desig_name'  	=> $row->desig_name,
					'ope_name'  	=> $row->ope_name,
					'posi_name'  	=> $row->posi_name,
					'gr_name'  		=> $row->gr_name,
					'stat_type'  	=> $row->stat_type,
					'shift_name'  	=> $row->shift_name,
					'gross_sal'  	=> $row->gross_sal,
					'ot_entitle'  	=> $row->ot_entitle,
					'transport'  	=> $row->transport,
					'lunch'  		=> $row->lunch,
					'att_bonus'  	=> $row->att_bonus,
					'emp_join_date'	=> $ejd,
					'salary_draw'	=> $row->salary_draw,
					'salary_type'	=> $row->salary_type,
					'unit_name'  	=> $row->unit_name
				);
				$unit_id = $row->unit_id;
				$get_session_user_unit = $this->common_model->get_session_unit_id_name();
				if($get_session_user_unit != 0)
				{
					if($unit_id != $get_session_user_unit)
					{
						return "Access Denied";
					}
				}

			}
			$this->db->select('pr_emp_com_info.emp_id as empid,pr_emp_add.*,pr_emp_edu.* ,pr_emp_per_info.*,pr_emp_skill.*');
			$this->db->from('pr_emp_com_info');
			$this->db->from('pr_emp_add');
			$this->db->from('pr_emp_edu');
			$this->db->from('pr_emp_per_info');
			$this->db->from('pr_emp_skill');
			$where = "pr_emp_com_info.emp_id = '$emp_id' and pr_emp_com_info.emp_id =pr_emp_add.emp_id and pr_emp_com_info.emp_id  = pr_emp_edu.emp_id and pr_emp_com_info.emp_id = pr_emp_per_info.emp_id and pr_emp_com_info.emp_id = pr_emp_skill.emp_id";

			$this->db->where($where);
			$query4 = $this->db->get();
			foreach ($query4->result() as $row)
			{
				$emp_dob = $row->emp_dob;
				$emp_dob = date("d-m-Y", strtotime($emp_dob));

				$data2 = array(
						'emp_full_name'  		=> $row->emp_full_name,
						'img_source'  			=> $row->img_source
				);

			}
			$other_info = implode('=*=', $data2);

			//GET DEPARTMENT ID BY EMP ID
			$this->db->select('emp_dept_id');
			$this->db->where('emp_id',$emp_id);
			$query2 = $this->db->get('pr_emp_com_info');
			$row = $query2->row();
			$dept_id = $row->emp_dept_id;
			//END
			$com_info = implode('=*=', $data);
			$unit_id_name 		= $this->get_unit_id_name($unit_id);
			$dept_id_name 		= $this->dept_search($unit_id);
			$sec_id_name 		= $this->section_search($unit_id);
			$line_id_name 		= $this->line_search($unit_id);
			$desig_id_name 		= $this->desig_search($unit_id);
			$operation_id_name 	= $this->operation_search();
			$position_id_name 	= $this->position_search();
			$salg_id_name 		= $this->grade_search();
			$empstat_id_name 	= $this->empstat_search();
			$attbonus_id_name 	= $this->attbonus_search();
			$shift_id_name 		= $this->shift_search($unit_id);
			return $alldata = "$com_info-*-$dept_id_name-*-$sec_id_name-*-$line_id_name-*-$desig_id_name-*-$operation_id_name-*-$position_id_name-*-$salg_id_name-*-$empstat_id_name-*-$shift_id_name-*-$attbonus_id_name-*-$other_info-*-$unit_id_name";
		}
		else
		{
			echo "Employee ID does not exist";
		}
	}

	function attendance_check($emp_id,$present_status,$num_of_days, $start_date)
	{
		$search_date =trim(substr($start_date,0,7));
		$loop_date = trim(substr($start_date,8,2));
		$this->db->select("");
		$this->db->where("emp_id",$emp_id);
		$this->db->like("att_month",$search_date);
		$query = $this->db->get("pr_attn_monthly");
		$count = 0;
		foreach($query->result_array() as $rows => $value)
		{
			for($i=$loop_date; $i<= $num_of_days ; $i++)
			{
				$idate = date("d", mktime(0, 0, 0, 0, $i, 0));
				$date="date_$idate";

				if($value[$date] == "$present_status")
				{
					$count++;
				}
			}
		}
		return $count;
	}

	function find_week($year_v,$month_v,$day_of_week_v)
	{
		$result=array();
		for ($year = $year_v; $year <= $year_v; $year++)
					{
						for ($month = $month_v; $month <= $month_v; $month++)
							{
							$num_of_days = date("t", mktime(0,0,0,$month,1,$year));
							$result['num_of_days']=$num_of_days;
						//	echo "Number of days = $num_of_days <BR>";
							$firstdayname = date("D", mktime(0, 0, 0, $month, 1, $year));
							$firstday = date("w", mktime(0, 0, 0, $month, 1, $year));
							$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

								for ($day_of_week = $day_of_week_v ; $day_of_week <= $day_of_week_v ; $day_of_week++)
									{
									if ($firstday > $day_of_week) {
									// means we need to jump to the second week to find the first $day_of_week
									$d = (7 - ($firstday - $day_of_week)) + 1;
									} elseif ($firstday < $day_of_week) {
									// correct week, now move forward to specified day
									$d = ($day_of_week - $firstday + 1);
									} else {
									// my "reversed-engineered" formula
									if ($lastday==28) // max of 4 occurences each in the month of February with

									$d = ($firstday + 4);
									elseif ($firstday==4)
									$d = ($firstday - 2);
									elseif ($firstday==5 )
									$d = ($firstday - 3);
									elseif ($firstday==6)
									$d = ($firstday - 4);
									else
									$d = ($firstday - 1);
									if ($lastday==29) // only 1 set of 5 occurences each in the month of
								$d -= 1;
						}

						$d += 28;    // jump to the 5th week and see if the day exists
						if ($d > $lastday) {
							$weeks = 4;
						} else {
							$weeks = 5;
						}

					if ($day_of_week==0) ;
					elseif ($day_of_week==1) ;
					elseif ($day_of_week==2) ;
					elseif ($day_of_week==3) ;
					elseif ($day_of_week==4) ;
					elseif ($day_of_week==5) ;
					else echo "Sat ";

					//echo "occurences = $weeks <BR> ";
					$result['day_of_week']=($day_of_week);
					$result['num_of_days']=$num_of_days;
					$no_of_working_days=$num_of_days-$day_of_week;
					//echo "No of working days  ".$no_of_working_days;
					$result['no_of_working_days']=$no_of_working_days;

					} // for $day_of_week loop
				} // for $mth loop
		} // for $year loop

	return $result;

	}
	//========================END Payscale Sheet Process=================
	function leave_db($emp_id,$start_date,$end_date, $leave_type)
	{
		$where = "trim(substr(start_date,1,10)) BETWEEN '$start_date' and '$end_date'";

		$this->db->select('start_date');
		$this->db->where("emp_id",$emp_id);
		$this->db->where("leave_type",$leave_type);
		$this->db->where($where);

		$query = $this->db->get('pr_leave_trans');

		return $query->num_rows();
	}

	function leave_per_emp($date, $emp_id)
	{
		$this->db->select("start_date,leave_type");
		$this->db->where("start_date = '$date'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("pr_leave_trans");
		$leave = array();
		foreach ($query->result() as $row)
		{
			$leave = $row->start_date;
		}
		return $leave;
	}

	//===========================Daily Late Report Start===========================

	function all_emp()
	{
		$this->db->select("emp_id");
		$this->db->from("pr_emp_com_info");
		$query = $this->db->get();
		return $query->result();
	}


	function present_check($date, $emp_id)
	{
		//echo $date;
		$year  = trim(substr($date,0,4));
		$month = trim(substr($date,5,2));
		$day   = trim(substr($date,8,2));
		$date_field = "date_$day";
		$att_month = $year."_".$month."-00";

		$this->db->select($date_field);
		$this->db->where("emp_id", $emp_id);
		$this->db->where("att_month", $att_month);
		$this->db->where($date_field, "P");
		$query = $this->db->get("pr_attn_monthly");
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}

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
		while($sCurrentDate < $sEndDate){
		// Add a day to the current date
		$sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
		// Add this new day to the aDays array
		$aDays[] = $sCurrentDate;
		//print_r($aDays);
		}
		// Once the loop has finished, return the

		return $aDays;
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

	function save_leave_db()
	{
		$empid_leave	= $this->input->post('empid_leave');
		$sStartDate		= $this->input->post('start_leave_date');
		$sEndDate		= $this->input->post('end_leave_date');
		$leave_type		= $this->input->post('leave_type');
		$sStartDate 	= date("Y-m-d", strtotime($sStartDate));
		$sEndDate 		= date("Y-m-d", strtotime($sEndDate));

		$this->db->select('leave_type');
		$where="emp_id = '$empid_leave' and leave_type = '$leave_type' and  start_date = '$sStartDate' ";
		$this->db->where($where);
		$query = $this->db->get('pr_leave_trans');
		$num_rows = $query->num_rows();
		if ($num_rows > 0 )
		{
			echo "Duplicate date not allow";
		}
		else
		{
			$days = $this->GetDays($sStartDate,$sEndDate);
			foreach($days as $day)
			{
				$data = array(
						'emp_id'		=> $empid_leave,
						'start_date'    => $day ,
						'leave_type'	=> $leave_type
					);
					$this->db->insert('pr_leave_trans', $data);
			}
			$this->log_model->log_leave_insert($empid_leave, $sStartDate, $sEndDate, $leave_type);
			echo "Save successfully";
		}
	}

	function manual_entry_Delete_db()
	{
		$id = $this->input->post('empid_present_absent');
		$startdate=$this->input->post('startdate_present_absent');
		$startdate = date("Y-m-d", strtotime($startdate));
		$temp_table = "temp_$id";
		$this->db->select("emp_id");
		$this->db->where("emp_id", $id);
		$query = $this->db->get("pr_emp_com_info");

		if($query->num_rows() == 0)
		{
			return "Employee ID does not exist.";
		}
		$proxi = $this->prox($id);
		$date  = $startdate;
		$year  = trim(substr($date,0,4));
		$month = trim(substr($date,5,2));
		$day   = trim(substr($date,8,2));

		$att_table = "att_".$year."_".$month;
		$date = date("d-m-Y", mktime(0, 0, 0, $month, $day, $year));
		$search_date = date("Ymd", mktime(0, 0, 0, $month, $day, $year));
		$file_name = "data/$date.TXT";
		$temp_table = "temp_$id";

		$where ="trim(substr(date_time ,1,10)) = '$startdate'";
		$this->db->where($where);
		$data=$this->db->delete($temp_table);

		$this->db->where($where);
		$data=$this->db->delete($att_table);
		//echo $this->db->last_query();
		if ($data)
		{
			echo "Delete successfully";
		}
		else
		{
			echo "Delete failed";
		}

		if( fopen($file_name,'r') )
		{
			$data = file($file_name);
			$out = array();
			foreach($data as $line) {
				$match_line =  substr($line,5,10);

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
	//==============Advance loan insert=======================>>
	function advance_loan_insert($emp_id, $loan_amt, $pay_amt, $loan_date){
		$this->db->select("emp_id");
		$this->db->where("emp_id", $emp_id);
		$query1 = $this->db->get("pr_emp_com_info");
		if( $query1->num_rows() == 0){
			return "Sorry! Employee ID does not exist.";
		}
		$this->db->select("emp_id");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("loan_date", $loan_date);
		$this->db->where("loan_status", '1');
		$query = $this->db->get("pr_advance_loan");
		if( $query->num_rows() > 0){
			return "Advance loan for this employee is running";
		}
		else{
			$data = array(
				'emp_id'  		=> $emp_id,
				'loan_amt' 		=> $loan_amt,
				'pay_amt' 		=> $pay_amt,
				'loan_date'		=> $loan_date,
				'loan_status'	=> 1,
			);
			if($this->db->insert("pr_advance_loan", $data))	{
				// ADVANCE LOAN LOG Generate
				$this->log_model->log_advance_loan_insert($emp_id, $loan_amt, $pay_amt, $loan_date);
				return "Advance loan inserted successfully";
			}else{
				return "Operation Failed";
			}
		}
	}

	//==============Due Amt. insert=======================>>
	function due_amt_insert($emp_id, $loan_amt, $pay_amt, $loan_date)
	{
		$this->db->select("emp_id");
		$this->db->where("emp_id", $emp_id);
		$query1 = $this->db->get("pr_emp_com_info");

		if($query1->num_rows() == 0)
		{
			return "Sorry! Employee ID does not exist.";
		}

		$this->db->select("emp_id");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("due_status", '1');
		$query = $this->db->get("pr_due_amt");

		if( $query->num_rows() > 0)
		{
			return "Due Amt. for this employee is running";
		}
		else
		{
			$data = array(
							'due_id' 		=> '',
							'emp_id'  		=> $emp_id,
							'due_amt' 		=> $loan_amt,
							'pay_amt' 		=> $pay_amt,
							'due_date'		=> $loan_date,
							'due_status'	=> 1,
						);
			if($this->db->insert("pr_due_amt", $data))
			{
				// ADVANCE LOAN LOG Generate
				$this->log_model->log_advance_loan_insert($emp_id, $loan_amt, $pay_amt, $loan_date);
				return "Due Amt. inserted successfully";
			}
			else
			{
				return "Operation Failed";
			}
		}
	}

	//==============Advance loan insert=======================<<

	//==============Advance loan deduction function=======================>>
	function advance_loan_deduction($emp_id, $salary_month)
	{
		$salary_month = "$salary_month-01";
		$this->db->select("*");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("loan_status", '1');
		$this->db->where("loan_date <=", $salary_month);
		$query = $this->db->get("pr_advance_loan");

		if( $query->num_rows() > 0)
		{
			foreach($query->result() as $rows)
			{
				$loan_id	= $rows->loan_id;
				$loan_amt 	= $rows->loan_amt;
				$pay_amt  	= $rows->pay_amt;
			}

			$this->db->select("emp_id");
			$this->db->where("emp_id", $emp_id);
			$this->db->where("loan_id", $loan_id);
			$this->db->like("pay_month", $salary_month);
			$query1 = $this->db->get("pr_advance_loan_pay_history");
			if( $query1->num_rows() == 0)
			{
				$this->db->select_sum("pay_amount");
				$this->db->where("emp_id", $emp_id);
				$this->db->where("loan_id", $loan_id);
				$query2 = $this->db->get("pr_advance_loan_pay_history");
				//echo $this->db->last_query();
				if( $query2->num_rows() > 0)
				{
					$row = $query2->row();
					$total_pay_amount = $row->pay_amount;
				}
				else
				{
					$total_pay_amount = 0;
				}
				$rest_loan_amount = $loan_amt - $total_pay_amount;
				if($rest_loan_amount > $pay_amt)
				{
					$data = array(
									'pay_id' 	=> '',
									'loan_id' 	=> $loan_id,
									'emp_id'  	=> $emp_id,
									'pay_amount'=> $pay_amt,
									'pay_month' => $salary_month
								);
					if($this->db->insert("pr_advance_loan_pay_history", $data))
					{
						return $pay_amt;
					}
				}
				else
				{
					$data = array(
									'pay_id' 	=> '',
									'loan_id' 	=> $loan_id,
									'emp_id'  	=> $emp_id,
									'pay_amount'=> $rest_loan_amount,
									'pay_month' => $salary_month
								);
					if($this->db->insert("pr_advance_loan_pay_history", $data))
					{
						$this->db->select_sum("pay_amount");
						$this->db->where("emp_id", $emp_id);
						$this->db->where("loan_id", $loan_id);
						$query2 = $this->db->get("pr_advance_loan_pay_history");

						if( $query2->num_rows() > 0)
						{
							$row = $query2->row();
							$total_pay_amount = $row->pay_amount;

							if($total_pay_amount == $loan_amt)
							{
								$data = array(
											'loan_status' => 2
											);
								$this->db->where("emp_id", $emp_id);
								$this->db->where("loan_id", $loan_id);
								$this->db->update("pr_advance_loan", $data);
							}
						}
						return $rest_loan_amount;
					}
				}
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	//==============Advance loan deduction function=======================<<


	function get_emp_info($emp_id){
		// dd($emp_id);
		$d = $this->db->select('com.*, per.*,deg.*')
					->from('pr_emp_com_info as com')
					->join('pr_emp_per_info as per','com.emp_id = per.emp_id', 'left')
					->join('emp_designation as deg', 'deg.id = com.emp_desi_id', 'left')
					->where('deg.hide_status', 1)
					->where('com.emp_id',$emp_id)
					->get()->row();

		// dd($d);
		if ($d == null) {
			return ['status'=>false,'data'=>'No data found'];
		}else{
			$d->emp_dob = ($d->emp_dob == '0000-00-00' || $d->emp_dob == null) ? date('Y-m-d') : $d->emp_dob;
			$d->emp_dob=$d->emp_dob=='0000-00-00'? date('Y-m-d'): $d->emp_dob;
			$date1 = new DateTime(date("d-m-Y", strtotime($d->emp_dob)));
			$d->nomi_age= $d->nomi_age=='0000-00-00'? date('Y-m-d'): $d->nomi_age;
			$date2 = new DateTime();
			$interval = $date1->diff($date2);
			$d->age = $interval->format("%y years %m months %d days");
			$date1 = new DateTime($d->emp_join_date);
			$date2 = new DateTime();
			$interval = $date1->diff($date2);
			$d->job_duration = $interval->format("%y years %m months %d days");
			return ['status'=>true,'data'=>$d];
		}
	}


	function insert_emp_inf0o(){
		if($this->input->post('emp_id') == '')
		{
			return ;
		}
		// dd($_POST);

		$ejd = date("Y-m-d", strtotime($this->input->post('emp_join_date')));
		$data = array(
			'emp_id'			=> $this->input->post('emp_id'),
			'unit_id'			=> $this->input->post('unit_id'),
			'emp_dept_id'  		=> $this->input->post('emp_dept_id'),
			'emp_sec_id' 		=> $this->input->post('emp_sec_id'),
			'emp_line_id' 		=> $this->input->post('emp_line_id'),
			'emp_desi_id'  		=> $this->input->post('emp_desi_id'),
			'emp_type'  		=> $this->input->post('emp_type'),

			'emp_sal_gra_id'  	=> $this->input->post('emp_sal_gra_id'),
			'emp_cat_id'		=> $this->input->post('emp_cat_id'),
			'proxi_id'			=> $this->input->post('proxi_id'),
			'emp_shift'  		=> $this->input->post('emp_shift'),
			'gross_sal'			=> $this->input->post('gross_sal'),
			'com_gross_sal'		=> $this->input->post('gross_sal'),

			'ot_entitle'		=> $this->input->post('ot_entitle'),
			'lunch'				=> $this->input->post('lunch'),
			'transport'			=> $this->input->post('transport'),
			'salary_draw'		=> $this->input->post('salary_draw'),
			'salary_type'		=> $this->input->post('salary_type'),
			'emp_join_date'		=> $ejd,
		);

		$dob = date("Y-m-d", strtotime($this->input->post('emp_dob')));
		$per_data = array(
			'name_en' 			=> $this->input->post('name_en'),
			'name_bn' 			=> $this->input->post('name_bn'),
			'father_name' 		=> $this->input->post('father_name'),
			'mother_name' 		=> $this->input->post('mother_name'),
			'per_village'		=> $this->input->post('per_village'),
			'per_village_bn'	=> $this->input->post('per_village_bn'),

			'per_post'			=> $this->input->post('per_post'),
			'per_thana'			=> $this->input->post('per_thana'),
			'per_district'		=> $this->input->post('per_district'),
			'pre_home_owner'	=> $this->input->post('pre_home_owner'),
			'holding_num'		=> $this->input->post('holding_num'),
			'home_own_mobile'	=> $this->input->post('home_own_mobile'),

			'pre_village'		=> $this->input->post('pre_village'),
			'pre_village_bn'	=> $this->input->post('pre_village_bn'),
			'pre_post'			=> $this->input->post('pre_post'),
			'pre_thana'			=> $this->input->post('pre_thana'),
			'pre_district'		=> $this->input->post('pre_district'),
			'spouse_name' 		=> $this->input->post('spouse_name'),

			'emp_dob' 			=> $dob,
			'gender' 			=> $this->input->post('gender'),
			'marital_status' 	=> $this->input->post('marital_status'),
			'religion'  		=> $this->input->post('religion'),
			'blood'  			=> $this->input->post('blood'),
			'm_child'			=> $this->input->post('m_child'),

			'f_child'			=> $this->input->post('f_child'),
			'nominee_name'		=> $this->input->post('nominee_name'),
			'nominee_vill'		=> $this->input->post('nominee_vill'),
			'nomi_post'			=> $this->input->post('nomi_post'),
			'nomi_thana'		=> $this->input->post('nomi_thana'),
			'nomi_district'		=> $this->input->post('nomi_district'),

			'nomi_age'			=> $this->input->post('nomi_age'),
			'nomi_mobile'		=> $this->input->post('nomi_mobile'),
			'nomi_relation'		=> $this->input->post('nomi_relation'),
			'refer_name'		=> $this->input->post('refer_name'),
			'refer_address'		=> $this->input->post('refer_address'),
			'refer_mobile'		=> $this->input->post('refer_mobile'),

			'refer_relation'	=> $this->input->post('refer_relation'),
			'education'			=> $this->input->post('education'),
			'nid_dob_id'		=> $this->input->post('nid_dob_id'),
			'nid_dob_check'		=> $this->input->post('nid_dob_check'),
			'exp_factory_name'	=> $this->input->post('exp_factory_name'),
			'exp_duration'		=> $this->input->post('exp_duration'),

			'exp_designation'	=> $this->input->post('exp_designation'),
			'personal_mobile'	=> $this->input->post('personal_mobile'),
			'bank_bkash_no'		=> $this->input->post('bank_bkash_no'),
		);

		if($this->db->insert('pr_emp_com_info', $data))
		{
			$per_data['emp_id'] = $this->db->insert_id();

			$img ="";
			if($_FILES["img_source"]["name"] != '')
			{
				$imgs = explode('.', $_FILES["img_source"]["name"]);
				$ext = end($imgs);

				$config['upload_path']    = './uploads/photo';
				$config['allowed_types']  = 'jpg|png|jpeg';
				$config['file_name'] 	  =  $per_data['emp_id'] .'.'. $ext;
				$config['max_size']	 	  = '4000';
				$config['max_width']  	  = '5000';
				$config['max_height']     = '7000';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('img_source'))
				{
					$error = array('error' => $this->upload->display_errors());
					echo $error["error"];
				}
				else
				{
					$img_upload = array('upload_data' => $this->upload->data());
					$img = $img_upload["upload_data"]["file_name"];
				}

			}

			$per_data['img_source'] = $img;
			$this->db->insert('pr_emp_per_info', $per_data);

			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Inserted Successfully.'); window.location='personal_info';</SCRIPT>";
		} else {
		echo "FAILED" ;
		return ;
		}
	}

}
?>

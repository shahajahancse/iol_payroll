<?php
class Acl_model extends CI_Model{


	function __construct()
	{
		parent::__construct();

		/* Standard Libraries */
	}



	function acl_check($access_level)
	{
		$user_id = $this->session->userdata('data')->id;
		$acl = $this->get_acl_list($user_id);
		if(in_array($access_level,$acl))
		{
			return true;
		}
		else
		{
			echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Sorry! Acess Deny');</SCRIPT>";
			exit;
		}
	}


	function get_acl_list($user_id){
		// dd($user_id);
	 	$data = array();
		$this->db->select("acl_id");
		$this->db->where('username_id',$user_id);
		$query = $this->db->get('member_acl_level');
		foreach($query->result() as $rows)
		{
			$data[] = $rows->acl_id;
		}
		return $data;
	}









	 //  old code
	function get_user_id($username){
		// dd($username);
		$this->db->select("id");
		$this->db->where('id_number', $username);
		$query = $this->db->get('members');

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$user_id = $row->id;
			return $user_id;
		} else {
			return null; 
		}

	}
}
?>
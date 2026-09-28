<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Debug Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Yura Loginov
 * @link		https://github.com/yuraloginoff/codeigniter-debug-helper.git
 */

// ------------------------------------------------------------------------

/**
 * Readable print_r
 *
 * get employee id
 *
 * @access	public
 * @param	mixed
 */
if (!function_exists('alt_ntf'))
{
    function alt_ntf()
    {
        $CI =& get_instance();
        // $CI->db->select('count(*) as total');
		// $CI->db->where('shift_log_date', date('Y-m-d'))->where('alert_msg', 1);
        // $row = $CI->db->get('pr_emp_shift_log')->row();
        // return $row->total ? $row->total : 0;

		$today = date('Y-m-d');
		$start_date = date('Y-m-d', strtotime('-2 days'));

		$CI->db->select('COUNT(*) as total');
		$CI->db->from('emp_alert_message as mesg');

		// Join shift log for exact message date
		$join_condition = "mesg.emp_id = log.emp_id
						AND log.present_status = 'P'
						AND mesg.date = log.shift_log_date";
		$CI->db->join('pr_emp_shift_log as log', $join_condition, 'inner');

		// Filter messages in last 3 days
		$CI->db->where("mesg.date BETWEEN '$start_date' AND '$today'");

		$row = $CI->db->get()->row();
		$total_messages = $row->total ? $row->total : 0;

		return $total_messages;


    }
}


if ( ! function_exists('get_all_emp_id'))
{
	function get_all_emp_id($emp_cat = array(), $unit_id = null)
	{
		$CI =& get_instance();
      	$CI->db->select('emp_id');
      	$CI->db->from('pr_emp_com_info');
		if ($unit_id != null) {
			$CI->db->join('emp_designation as deg', 'deg.id = pr_emp_com_info.emp_desi_id', 'left');
			$CI->db->where('deg.hide_status', 1);
			$CI->db->where('pr_emp_com_info.unit_id',$unit_id);
		}
		$CI->db->where_in('pr_emp_com_info.emp_cat_id',$emp_cat);
		$query = $CI->db->get()->result_array();


		$data = array();
		array_walk($query, function($entry) use (&$data) {
		    $data[] = $entry["emp_id"];
		});
		return $data;
	}
}

if ( ! function_exists('add_days_skipping_fridays'))
{
	function add_days_skipping_fridays($date, $days,$emp_id) {
		$current_date = strtotime($date);
		$days_added = 0;
		while ($days_added < $days) {
			$current_date = strtotime('+1 day', $current_date);
			// Check if the current day is not Friday
			if (date('N', $current_date) != 5) {
				$CI =& get_instance();
				$holiday_date = $CI->db->where('emp_id',$emp_id)->where('holiday_date',$current_date)->get('pr_holiday')->row();
				if(empty($holiday_date)){
					$days_added++;
				}
			}
		}
		$dayss  = date('Y-m-d', strtotime($date. ' +'.$days.' days'));
		$gov_holiday= $CI->db->where('date >=',$date)->where('date <=',$dayss)->where('unit_id',$_SESSION['data']->unit_name)->get('pr_gov_holiday')->result();
		$count = count($gov_holiday);
		if($count > 0) {
			$current_date = strtotime('+' . $count . ' days', $current_date);
			// $current_date = strtotime($current_date,'+' . $count . ' days');
			// $current_date = strtotime('+' . $count . ' days', strtotime($current_date));
		}
		// dd(date('d/m/Y', $current_date));
		return date('d/m/Y', $current_date);
	}
}

// ------------------------------------------------------------------------

/**
 * Readable print_r
 *
 * get employee id
 *
 * @access	public
 * @param	mixed
 */
if ( ! function_exists('check_acl_list'))
{
	function check_acl_list($user_id, $acl_level = NULL)
	{
		$CI =& get_instance();
		$CI->db->select("acl_id");
		$CI->db->where('username_id',$user_id);
		$query = $CI->db->get('member_acl_level')->result_array();

	 	$data = array();
		array_walk($query, function($entry) use (&$data) {
		    $data[] = $entry["acl_id"];
		});

		if (!empty($acl_level) && in_array($acl_level, $data)) {
			return true;
		} else if (!empty($acl_level)) {
			return false;
		} else {
			return $data;
		}
	}
}



if ( ! function_exists('log_activity'))
{
	function log_activity($title,$description,$user_id)
	{
		$CI =& get_instance();
		$data = array(
			'title' => $title,
			'description' => $description,
			'user_id' => $user_id,
		);
		$CI->db->insert('activity_log', $data);
	}
}

// ------------------------------------------------------------------------




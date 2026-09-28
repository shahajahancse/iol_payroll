<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('api_auth'))
{
    function api_auth($var)
    {
        if (empty($var)) {
            $data = array(
                'user_info' => '',
                'status'    => false,
            );
            return $data;
        }
        $Token = str_replace('Bearer ', '', $var);

        $CI =&  get_instance();
        $CI->db->from('api_keys')->where('api_key', $Token);
        $q = $CI->db->get()->row();
        if (!empty($q)) {
            $CI->db->select('e.*');
            $CI->db->from('members AS e');
            $CI->db->where('e.id', $q->user_id);
            $query = $CI->db->get()->row();


            
            $sql = [];
            if (empty($sql)) {
                $sql = array('api_key'=> $Token);
            }    
            $mergedObject = (object) array_merge((array) $query, (array) $sql);
            $data = array(
                'user_info' => $mergedObject,
                'status'    => true,
            );
        }else{
            $data = array(
                'user_info' => '',
                'status'    => false,
            );
        }
        return $data;
    }
}
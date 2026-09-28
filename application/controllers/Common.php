<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

    function grid_emp_list($unit, $dept=NULL, $section=NULL, $line=NULL, $desig=NULL){
        $searchInput = isset($_GET['searchi']) ? $_GET['searchi'] : null;
        // if (empty($_GET['status'])) {
        //     $this->db->select('emp_id');
        //     $this->db->from('pr_emp_resign_history');
        //     $this->db->where('unit_id', $unit);
        //     $this->db->where('resign_date <=',date('Y-m-d', strtotime('-360 days')));
        //     $emp_ids = $this->db->get()->result_array();
        //     $emp_id = array_column($emp_ids, 'emp_id');
        //     $this->db->select('emp_id');
        //     $this->db->from('pr_emp_left_history');
        //     $this->db->where('unit_id', $unit);
        //     $this->db->where('left_date <=',date('Y-m-d', strtotime('-360 days')));
        //     $emp_ids = $this->db->get()->result_array();
        //     $emp_id2 = array_merge($emp_id, array_column($emp_ids, 'emp_id'));
        //     $emp_id_not = array_unique($emp_id2);
        // }
        ini_set("pcre.backtrack_limit", 100000000000);
        ini_set("pcre.recursion_limit", 10000000000);
    	$data = array();
        $this->db->select('max(com.id) as id, max(com.emp_id) as emp_id, max(per.name_en) as name_en, max(per.name_bn) as name_bn');
        $this->db->from('pr_emp_com_info as com');
        $this->db->join('pr_emp_per_info as per', 'per.emp_id = com.emp_id', 'left');
        $this->db->join('emp_designation as deg', 'deg.id = com.emp_desi_id', 'left');
        // $this->db->join('pr_emp_left_history', 'pr_emp_left_history.emp_id = com.emp_id', 'left');
        // $this->db->join('pr_emp_resign_history', 'pr_emp_resign_history.emp_id = com.emp_id', 'left');
        // $this->db->where('pr_emp_left_history.left_date <=',date('Y-m-d', strtotime('-360 days')));
        // $this->db->where('pr_emp_resign_history.resign_date <=',date('Y-m-d', strtotime('-360 days')));
        $this->db->where('com.unit_id', $unit);
        if (isset($emp_id_not) && !empty($emp_id_not)) {
            $this->db->where_not_in('com.emp_id', $emp_id_not);
        }
        $this->db->where('deg.hide_status', 1);

        if (!empty($dept)) {
            $this->db->where('com.emp_dept_id', $dept);
        }
        if (!empty($section)) {
            $this->db->where('com.emp_sec_id', $section);
        }
        if (!empty($line)) {
            $this->db->where('com.emp_line_id', $line);
        }
        if (!empty($desig)) {
            $this->db->where('com.emp_desi_id', $desig);
        }
        if (!empty($_GET['status'])) {
            $this->db->where('com.emp_cat_id', $_GET['status']);
        }
        if (!empty($searchInput)) {
            $searchTerms = explode(',', $searchInput);
            foreach ($searchTerms as $index => $term) {
                $trimmedTerm = trim($term);
                // dd($trimmedTerm);
                if ($index === 0) {
                    $this->db->like('com.emp_id', $trimmedTerm);
                } else {
                    $this->db->or_like('com.emp_id', $trimmedTerm);
                }
            }
        }

        $this->db->group_by('com.emp_id');
        $this->db->order_by('com.emp_id', 'asc');
        $result = $this->db->get()->result();
        //dd($result);

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($result);
        return;
    }

    function salary_emp_list(){
        $unit_id        = $_GET['unit'];
        $dept           = $_GET['dept'];
        $section        = $_GET['section'];
        $line           = $_GET['line'];
        $desig          = $_GET['desig'];
        $status         = $_GET['status'];
        $salary_month   = date('Y-m-01', strtotime($_GET['salary_month']));
        $end_month      = date('Y-m-t', strtotime($_GET['salary_month']));
        // dd($_GET);
        $searchInput = isset($_GET['searchi']) ? $_GET['searchi'] : null;

        if (!empty($status) && $status == 1) {
            $this->db->select('lf.emp_id');
            $this->db->from('pr_emp_com_info as lf');
            $this->db->where('lf.emp_cat_id', 1);
            $this->db->where('lf.unit_id', $unit_id);
            $emp_ids = $this->db->get()->result();
            $emp_id = array_column($emp_ids, 'emp_id');
        } elseif (!empty($status) && $status == 2) {
            $this->db->select('lf.emp_id');
            $this->db->from('pr_emp_left_history as lf');
            $this->db->where('lf.unit_id', $unit_id);
            $this->db->where("lf.left_date BETWEEN '$salary_month' AND '$end_month'");
            $emp_ids = $this->db->get()->result();
            $emp_id = array_column($emp_ids, 'emp_id');
        } elseif (!empty($status) && $status == 3) {
            $this->db->select('lf.emp_id');
            $this->db->from('pr_emp_resign_history as lf');
            $this->db->where('lf.unit_id', $unit_id);
            $this->db->where("lf.resign_date BETWEEN '$salary_month' AND '$end_month'");
            $emp_ids = $this->db->get()->result();
            $emp_id = array_column($emp_ids, 'emp_id');
        } else {
            $emp_id = array();
        }
        // dd($emp_id);
        $this->db->select('MAX(ss.emp_id) as emp_id, MAX(per.name_en) as name_en, MAX(per.name_bn) as name_bn');
        $this->db->from('pay_salary_sheet as ss');
        $this->db->join('pr_emp_per_info as per', 'per.emp_id = ss.emp_id', 'left');
        $this->db->join('emp_designation as deg', 'deg.id = ss.desig_id', 'left');
        $this->db->where('ss.unit_id', $unit_id);
        if (!empty($emp_id)) {
            $this->db->where_in('ss.emp_id', $emp_id);
        }
        $this->db->where('ss.salary_month', $salary_month);
        $this->db->where('deg.hide_status', 1);

        if (!empty($dept)) {
            $this->db->where('ss.dept_id', $dept);
        }
        if (!empty($section)) {
            $this->db->where('ss.sec_id', $section);
        }
        if (!empty($line)) {
            $this->db->where('ss.line_id', $line);
        }
        if (!empty($desig)) {
            $this->db->where('ss.desig_id', $desig);
        }
        if (!empty($_GET['stop_salary'])) {
            $this->db->where('ss.stop_salary', $_GET['stop_salary']);
        }
        if (!empty($searchInput)) {
            $searchTerms = explode(',', $searchInput);
            foreach ($searchTerms as $index => $term) {
                $trimmedTerm = trim($term);
                // dd($trimmedTerm);
                if ($index === 0) {
                    $this->db->like('ss.emp_id', $trimmedTerm);
                } else {
                    $this->db->or_like('ss.emp_id', $trimmedTerm);

                }
            }
        }

        $this->db->group_by('ss.emp_id');
        $this->db->order_by('ss.emp_id', 'asc');
        $result = $this->db->get()->result();
        // dd($this->db->last_query());
        // dd(count($result));

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($result);
        return;
    }



    function ajax_department_by_unit_id($id = null){

        $data = array();
        if (empty($id)) {
            header('Content-Type: application/x-json; charset=utf-8');
            echo json_encode($data);
            exit;
        }
        $this->db->select('*');
        $this->db->from('emp_depertment');
        $this->db->where('unit_id', $id);
        $this->db->order_by('dept_name', 'ASC');
        $query = $this->db->get()->result();

        foreach ($query as $department) {
            $data[$department->dept_id] = $department->dept_name;

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    function ajax_section_by_dept_id($id, $unit_id = null){

        $data = array();
        $this->db->select('*');
        $this->db->from('emp_section');
        $this->db->where('depertment_id', $id);
        if (!empty($unit_id)) {
            $this->db->where('unit_id', $unit_id);
        }
        $this->db->order_by('sec_name_en', 'ASC');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            $data[$row->id] = $row->sec_name_en;
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    function ajax_line_by_sec_id($id){

        $data = array();
        $this->db->select('*');
        $this->db->from('emp_line_num');
        $this->db->where('section_id', $id);
        $this->db->order_by('line_name_en', 'ASC');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            $data[$row->id] = $row->line_name_en;
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    function ajax_designation_by_line_id($id){

        $data = array();
        $this->db->select('dl.*, dg.desig_name, dg.desig_bangla');
        $this->db->from('emp_dasignation_line_acl dl');
        $this->db->join('emp_designation dg', 'dg.id = dl.designation_id', 'left');
        $this->db->where('line_id', $id);
        $this->db->order_by('designation_id', 'ASC');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            $data[$row->designation_id] = $row->desig_name;
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
    function ajax_designation_by_line_id_h($id,$unit_id,$dept_id,$section_id){
        $this->db->select('dl.*, dg.desig_name, dg.desig_bangla, dg.hide_status');
        $this->db->from('emp_dasignation_line_acl dl');
        $this->db->join('emp_designation dg', 'dg.id = dl.designation_id', 'left');
        $this->db->where('dl.line_id', $id);
        $this->db->where('dl.unit_id', $unit_id);
        $this->db->where('dl.dept_id', $dept_id);
        $this->db->where('dl.section_id', $section_id);
        $this->db->order_by('designation_id', 'ASC');
        $data = $this->db->get()->result();
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    function ajax_designation_by_unit($id){

        $data = array();
        $this->db->select('ed.*');
        $this->db->from('emp_designation ed');
        $this->db->where('unit_id', $id);
        $this->db->order_by('desig_name', 'ASC');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            $data[$row->id] = $row->desig_name;
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    function ajax_district_by_div($id){

        $data = array();
        $this->db->select('id, name_bn');
        $this->db->from('emp_districts');
        $this->db->where('div_id', $id);
        $this->db->order_by('name_bn', 'ASC');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            $data[$row->id] = $row->name_bn;
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    function ajax_upazila_by_dis($id){

        $data = array();
        $this->db->select('id, name_bn');
        $this->db->from('emp_upazilas');
        $this->db->where('dis_id', $id);
        $this->db->order_by('name_bn', 'ASC');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            $data[$row->id] = $row->name_bn;
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    function ajax_post_office_by_upa_id($id){

        $data = array();
        $this->db->select('id, name_bn');
        $this->db->from('emp_post_offices');
        $this->db->where('up_zil_id', $id);
        $this->db->order_by('name_bn', 'ASC');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            $data[$row->id] = $row->name_bn;
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    function get_emp_info_by_id($id, $unit_id = null){

        $this->db->select('
                    com.*,
                    per.name_en,
                    per.name_bn,
                    per.img_source,

                    dept.dept_name,
                    dept.dept_bangla,
                    sec.sec_name_bn,
                    sec.sec_name_en,
                    line.line_name_en,
                    line.line_name_bn,
                    deg.desig_name,
                    deg.desig_bangla,
                ');
        $this->db->from('pr_emp_com_info as com');
        $this->db->join('pr_emp_per_info as per', 'per.emp_id = com.emp_id', 'left');
        $this->db->join('emp_depertment as dept', 'dept.dept_id = com.emp_dept_id', 'left');
        $this->db->join('emp_section as sec', 'sec.id = com.emp_sec_id', 'left');
        $this->db->join('emp_line_num as line', 'line.id = com.emp_line_id', 'left');
        $this->db->join('emp_designation as deg', 'deg.id = com.emp_desi_id', 'left');
        $r = $this->db->where('com.emp_id', $id)->get()->row();

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($r);
         return;
    }


}


<?php
class Crud_model extends CI_Model{


    function __construct()
    {
     // Call the Model constructor
     parent::__construct();
    }


    //==========================Department===============================//
    function dept_infos($limit, $start, $condition = 0, $unit_id = 0){
        $this->db->select('SQL_CALC_FOUND_ROWS emp_depertment.*, pr_units.unit_name', false);
        $this->db->from('emp_depertment');
        $this->db->join('pr_units','emp_depertment.unit_id = pr_units.unit_id', 'left');

        if ($unit_id!=0) {
            $this->db->where('emp_depertment.unit_id',$unit_id);
        }

        if (!empty($condition)) {
            $this->db->where($condition);
        }
        // $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }

    //==========================Department===============================//
    function get_post_office($limit, $start, $condition = 0)
    {
        $this->db->select('
                SQL_CALC_FOUND_ROWS epo.*,
                ediv.name_bn as div_name_bn,
                ediv.name_en as div_name_en,
                edis.name_bn as dis_name_bn,
                edis.name_en as dis_name_en,
                eup.name_bn upa_name_bn,
                eup.name_en upa_name_en', false
            );
        $this->db->from('emp_post_offices epo');
        $this->db->join('emp_divisions ediv','ediv.id = epo.div_id', 'left');
        $this->db->join('emp_districts edis','edis.id = epo.dis_id', 'left');
        $this->db->join('emp_upazilas eup','eup.id = epo.up_zil_id', 'left');
        if (!empty($condition)) {
            $this->db->where($condition);
        }
        // $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }

    //==========================attn file upload===============================//
    function file_upload($limit, $start, $condition = 0)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS attn_file_upload.*, pr_units.unit_name', false);
        $this->db->from('attn_file_upload');
        $this->db->join('pr_units','attn_file_upload.unit_id = pr_units.unit_id', 'left');
        if (!empty($condition)) {
            $this->db->where($condition);
        }
        if (!empty($this->data['user_data']->unit_name)) {
            $this->db->where('attn_file_upload.unit_id', $this->data['user_data']->unit_name);
        }

        $this->db->order_by('attn_file_upload.upload_date', 'DESC');
        // dd($this->db->get()->result());
        return $this->db->get()->result();
    }















    // old code
    function getdept($deptId)
    {
        $this->db->where('dept_id',$deptId);
        return $this->db->get('emp_depertment')->row();
    }

    function dept_fetch()
    {
        $this->db->select('pr_units.*');
        return $this->db->get('pr_units')->result_array();

    }


     function dept_add($fromArray)
        {

            $comData = array(
                'dept_name' => $fromArray['name'],
                'dept_bangla' => $fromArray['bname'],
                'unit_id' => $fromArray['dept'],

            );
            // print_r($comData);exit('obaydullah');

              $this->db->insert('emp_depertment',$comData);

        }


     function dept_edit($deptId)
        {
             $formArray = array();

             $formArray['dept_name'] = $this->input->post('name');
             $formArray['dept_bangla'] = $this->input->post('bname');
             $formArray['unit_id'] = $this->input->post('dept');

             $this->db->where('dept_id',$deptId);
             $this->db->update('emp_depertment',$formArray);

        }

     function dept_delete($deptId)
        {
            $this->db->where('dept_id',$deptId);
            $this->db->delete('emp_depertment');
        }


//===========================================Section===============================================//


    function company_add($fromArray)
    {
        // print_r($_FILES);exit('hi');
        $img = $sig = "";
        // echo $_FILES["logo"]["name"];
        // exit('hello');
        if($_FILES["comlogo"]["name"] != ''){
            $config['upload_path'] = './images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_width']  = '1000';
            $config['max_height']  = '1000';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('comlogo')){
                exit('gdfg');
                $error = array('error' => $this->upload->display_errors());
                // print_r($error);exit('obaydullah');
                // echo $error["error"];
            }else{
                $data = array('upload_data' => $this->upload->data());
                $img = $data["upload_data"]["file_name"];
            }
        }
        if($_FILES["comsign"]["name"] != ''){
            $config['upload_path'] = './images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2000';
            $config['max_width']  = '1000';
            $config['max_height']  = '1000';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('comsign')){
                // exit('gdfg');
                $error = array('error' => $this->upload->display_errors());
                // print_r($error);exit('obaydullah');
                // echo $error["error"];
            }else{
                $data = array('upload_data' => $this->upload->data());
                $sig = $data["upload_data"]["file_name"];
            }
        }
        if($_FILES["register"]["name"] != ''){
            $config['upload_path'] = './images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2000';
            // $config['max_width']  = '1000';
            // $config['max_height']  = '1000';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('register')){
                // exit('gdfg');
                $error = array('error' => $this->upload->display_errors());
                // print_r($error);exit('obaydullah');
                // echo $error["error"];
            }else{
                $data = array('upload_data' => $this->upload->data());
                $register = $data["upload_data"]["file_name"];
            }
        }

        $comData = array(
            'company_name_english' => $fromArray['name'],
            'company_name_bangla' => $fromArray['bname'],
            'company_add_english' => $fromArray['en_add'],
            'company_add_bangla' => $fromArray['bn_add'],
            'company_phone' => $fromArray['phn'],
            'unit_id' => $fromArray['unit_id'],
             'company_logo' => $img,
            'company_signature' => $sig,
            'register' => $register
        );

          $this->db->insert('company_infos',$comData);

    }

    function getUnit($comId=null)
    {
        $this->db->where('id',$comId);
        return $this->db->get('company_infos')->row();
    }
    function getallUnit()
    {
        $this->db->where("unit_id", $this->data['user_data']->unit_name);
        return $this->db->get('pr_units')->result_array();
    }


    function company_edit($comId)
    {
        $formArray = array();

        if($_FILES["comsign"]["name"] != ''){
            $config['upload_path'] = './images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2000';
            $config['max_width']  = '1000';
            $config['max_height']  = '1000';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('comsign')){
                $error = array('error' => $this->upload->display_errors());
                // echo $error["error"];exit;
                /*print_r($error);exit('obaydullah');*/
            }else{
                // exit('Now its Writeable');
                $data = array('upload_data' => $this->upload->data());
                // $sig = $data["upload_data"]["file_name"];
                $formArray['company_signature'] = $data["upload_data"]["file_name"];
            }
        }
        // print_r($formArray);exit('alibro');

        if($_FILES["comlogo"]["name"] != ''){
            $config['upload_path'] = './images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2000';
            $config['max_width']  = '1000';
            $config['max_height']  = '1000';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('comlogo')){
                // exit('gdfg');
                $error = array('error' => $this->upload->display_errors());
                // print_r($error);exit('obaydullah');
                // echo $error["error"];
            }else{
                $data = array('upload_data' => $this->upload->data());
                $formArray['company_logo'] = $data["upload_data"]["file_name"];
            }
        }
        if($_FILES["register"]["name"] != ''){
            $config['upload_path'] = './images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2000';
            // $config['max_width']  = '1000';
            // $config['max_height']  = '1000';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('register')){
                // exit('gdfg');
                $error = array('error' => $this->upload->display_errors());
                // print_r($error);exit('obaydullah');
                // echo $error["error"];
            }else{
                $data = array('upload_data' => $this->upload->data());
                $formArray['register'] = $data["upload_data"]["file_name"];
            }
        }

        $comId = $this->input->post('id');
        $formArray['company_name_english'] = $this->input->post('name');
        $formArray['company_name_bangla'] = $this->input->post('bname');
        $formArray['company_add_english'] = $this->input->post('en_add');
        $formArray['company_add_bangla'] = $this->input->post('bn_add');
        $formArray['company_phone'] = $this->input->post('phn');
        // $formArray['company_logo'] = $this->input->post('comlogo');
        // $formArray['company_signature'] = $this->input->post('comsign');
        //print_r($formArray);exit('ali');

         $this->db->where('id',$comId);
         $this->db->update('company_infos',$formArray);

    }

    function company_delete($comId)
    {
        $this->db->where('id',$comId);
        $this->db->delete('company_infos');
    }


//============================================Floor===========================================//


     function getfloor($floorId)
    {
        $this->db->where('id',$floorId);
        return $this->db->get('pr_floor')->row();
    }

    function floor_infos($limit,$start)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS pr_floor.*,pr_units.unit_name', false);
        $this->db->from('pr_floor');
        $this->db->join('pr_units','pr_units.unit_id = pr_floor.unit_id');
        // $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }

    function floor_fetch()
    {
        $this->db->select('pr_units.*');
        return $this->db->get('pr_units')->result_array();

    }






     function floor_add($fromArray)
        {


            $comData = array(
                'floor_name' => $fromArray['name'],
                'unit_id' => $fromArray['floor'],

            );

              $this->db->insert('pr_floor',$comData);

        }


     function floor_edit($floorId)
        {
             $formArray = array();
             $floorId = $this->input->post('id');
             $formArray['floor_name'] = $this->input->post('name');
             $formArray['unit_id'] = $this->input->post('floor');

             $this->db->where('id',$floorId);
             $this->db->update('pr_floor',$formArray);

        }

     function floor_delete($floorId)
        {
            $this->db->where('id',$floorId);
            $this->db->delete('pr_floor');
        }


//===========================================Section===============================================//




     function getsec($secId)
    {
        $this->db->where('id',$secId);
        return $this->db->get('emp_section')->row();
    }

    function sec_infos()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS emp_section.*,pr_units.unit_name,pr_units.unit_name_bangla', false);
        $this->db->from('emp_section');
        $this->db->join('pr_units','pr_units.unit_id = emp_section.unit_id');
        $this->db->order_by('id','desc');
        // $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }

    function sec_fetch()
    {
        $this->db->select('pr_units.*');
        return $this->db->get('pr_units')->result_array();

    }






     function sec_add($fromArray)
        {

            $comData = array(
                'sec_name' => $fromArray['name'],
                'sec_bangla' => $fromArray['bname'],
                'strength' => $fromArray['strn'],
                'str_staff' => $fromArray['strf'],
                'sec_index' => $fromArray['indx'],
                'absent_report_index' => $fromArray['aindx'],
                'unit_id' => $fromArray['sec'],

            );
            // print_r($comData);exit('obaydullah');

              $this->db->insert('emp_section',$comData);

        }


     function sec_edit($secId)
        {
             $formArray = array();
             // $secId = $this->input->post('sec_id');
             $formArray['sec_name'] = $this->input->post('name');
             $formArray['sec_bangla'] = $this->input->post('bname');
             $formArray['strength'] = $this->input->post('strn');
             $formArray['str_staff'] = $this->input->post('strf');
             $formArray['sec_index'] = $this->input->post('indx');
             $formArray['absent_report_index'] = $this->input->post('aindx');
             $formArray['unit_id'] = $this->input->post('sec');

             $this->db->where('sec_id',$secId);
             $this->db->update('emp_section',$formArray);

        }

     function sec_delete($secId)
        {
            $this->db->where('id',$secId);
            $this->db->delete('emp_section');
        }



//===========================================Line================================================//




     function getline($lineId)
    {
        $this->db->where('id',$lineId);
        return $this->db->get('emp_line_num')->row();
    }

    function line_infos()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS emp_line_num.*,pr_units.unit_name', false);
        $this->db->from('emp_line_num');
        $this->db->join('pr_units','pr_units.unit_id = emp_line_num.unit_id');
        return $this->db->get()->result_array();
    }

    function line_fetch()
    {
        $this->db->select('pr_units.*');
        return $this->db->get('pr_units')->result_array();

    }






     function line_add($fromArray)
        {

            $comData = array(
                'line_name' => $fromArray['name'],
                'line_bangla' => $fromArray['bname'],
                'strength' => $fromArray['strn'],
                'unit_id' => $fromArray['line'],
                'indexing' => $fromArray['indx'],

            );
            // print_r($comData);exit('obaydullah');

              $this->db->insert('emp_line_num',$comData);

        }


     function line_edit($lineId)
        {
             $formArray = array();

             $formArray['line_name'] = $this->input->post('name');
             $formArray['line_bangla'] = $this->input->post('bname');
             $formArray['strength'] = $this->input->post('strn');
             $formArray['unit_id'] = $this->input->post('line');
             $formArray['indexing'] = $this->input->post('indx');
             // print_r($formArray);

             $this->db->where('line_id',$lineId);
             // echo $lineId;exit('khalid');
             $this->db->update('emp_line_num',$formArray);

        }

     function line_delete($lineId)
        {
            $this->db->where('line_id',$lineId);
            $this->db->delete('emp_line_num');
        }



//============================================Designation=========================================//





     function getdesig($desigId)
    {
        $this->db->where('desig_id',$desigId);
        return $this->db->get('emp_designation')->row();
    }

    function desig_infos($limit,$start)
    {
        $this->db->select('emp_designation.*,pr_units.unit_name');
        $this->db->from('emp_designation');
        $this->db->join('pr_units','pr_units.unit_id = emp_designation.unit_id');
        // $this->db->limit(10);
        // $this->db->limit($limit,$start);
        $query = $this->db->get()->result_array();
        // print_r($query);exit('ali');
        return $query;
        /*$this->db->select('emp_designation.*,pr_units.unit_name');
        $this->db->from('emp_designation');
        $this->db->join('pr_units','pr_units.unit_id = emp_designation.unit_id');
        return $this->db->get()->result_array();*/
    }

    function desig_fetch()
    {
        $this->db->select('pr_units.*');
        return $this->db->get('pr_units')->result_array();

    }






     function desig_add($fromArray)
        {

            $comData = array(
                'desig_name' => $fromArray['name'],
                'desig_bangla' => $fromArray['bname'],
                'unit_id' => $fromArray['desig'],

            );
            // print_r($comData);exit('obaydullah');

              $this->db->insert('emp_designation',$comData);

        }


     function desig_edit($desigId)
        {
             $formArray = array();

             $formArray['desig_name'] = $this->input->post('name');
             $formArray['desig_bangla'] = $this->input->post('bname');
             $formArray['unit_id'] = $this->input->post('desig');

             $this->db->where('desig_id',$desigId);
             $this->db->update('emp_designation',$formArray);

        }

     function desig_delete($desigId)
        {
            $this->db->where('desig_id',$desigId);
            $this->db->delete('emp_designation');
        }



//============================================AttendanceBonus=========================================//





     function getattbn($attbnId)
    {
        $this->db->where('id',$attbnId);
        return $this->db->get('allowance_attn_bonus')->row();
    }

    function attbn_infos($limit,$start)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS pr_attn_bonus.*', false);
        $this->db->from('pr_attn_bonus');
        // $this->db->join('pr_units','pr_units.unit_id = pr_attn_bonus.unit_id');
        // $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }

    // function attbn_fetch()
    // {
    //     $this->db->select('pr_units.*');
    //     return $this->db->get('pr_units')->result_array();

    // }



     function attbn_add($fromArray)
        {

            $comData = array(
                'ab_rule_name' => $fromArray['name'],
                'ab_rule' => $fromArray['amnt'],


            );
            // print_r($comData);exit('obaydullah');

              $this->db->insert('pr_attn_bonus',$comData);

        }


     function attbn_edit($attbnId)
        {
             $formArray = array();

             $formArray['ab_rule_name'] = $this->input->post('name');
             $formArray['ab_rule'] = $this->input->post('amnt');


             $this->db->where('ab_id',$attbnId);
             $this->db->update('pr_attn_bonus',$formArray);

        }

     function attbn_delete($attbnId)
        {
            $this->db->where('ab_id',$attbnId);
            $this->db->delete('pr_attn_bonus');
        }




//============================================Salary Grade=========================================//


     function getsalgrd($salgrdId)
    {
        $this->db->where('gr_id',$salgrdId);
        // dd($this->db->get('pr_grade')->row());
        return $this->db->get('pr_grade')->row();
    }

    function salgrd_infos($limit,$start)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS pr_grade.*', false);
        $this->db->from('pr_grade');
        // $this->db->join('pr_units','pr_units.unit_id = pr_grade.unit_id');
        // $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }

    // function salgrd_fetch()
    // {
    //     $this->db->select('pr_units.*');
    //     return $this->db->get('pr_units')->result_array();

    // }



     function salgrd_add($fromArray){

        $comData = array(
            'gr_name' => $fromArray['gr_name'],
            'salary'  => $fromArray['salary'],
        );
        // print_r($comData);exit('obaydullah');
        $this->db->insert('pr_grade',$comData);
    }


     function salgrd_edit($salgrdId)
        {
             $formArray = array();

             $formArray['gr_name'] = $this->input->post('gr_name');
             $formArray['salary'] = $this->input->post('salary');

             $this->db->where('gr_id',$salgrdId);
             $this->db->update('pr_grade',$formArray);

        }

     function salgrd_delete($salgrdId)
        {
            $this->db->where('gr_id',$salgrdId);
            $this->db->delete('pr_grade');
        }

//============================================Shift Schedule==========================================//





     function getshiftschedule($shiftscheduleId)
    {
        $this->db->select('pr_emp_shift_schedule.*,pr_units.unit_name');
        $this->db->join('pr_units','pr_units.unit_id = pr_emp_shift_schedule.unit_id');
        $this->db->where('pr_emp_shift_schedule.id',$shiftscheduleId);
        return $this->db->get('pr_emp_shift_schedule')->row();
    }

    function shiftschedule_infos($unit_id = null)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS pr_emp_shift_schedule.*,pr_units.unit_name', false);
        $this->db->from('pr_emp_shift_schedule');
        $this->db->join('pr_units','pr_units.unit_id = pr_emp_shift_schedule.unit_id');
        if ($unit_id != 0) {
            $this->db->where('pr_emp_shift_schedule.unit_id', $unit_id);
        }
        $this->db->order_by('pr_emp_shift_schedule.id', 'desc');
        return $this->db->get()->result_array();
    }

    function shiftschedule_fetch(){
        return $this->db->select('pr_units.*')->get('pr_units')->result_array();
    }



    function shiftschedule_add($fromArray)
    {
        $this->db->insert('pr_emp_shift_schedule',$fromArray);
    }


    function shiftschedule_edit($shiftscheduleId)
    {
        $formArray = array();

        // $formArray['unit_name'] = $this->input->post('uname');
        $formArray['sh_type'] = $this->input->post('stype');
        $formArray['in_start'] = $this->input->post('instrt');
        $formArray['in_time'] = $this->input->post('intime');
        $formArray['late_start'] = $this->input->post('ltstart');
        $formArray['in_end'] = $this->input->post('inend');
        $formArray['out_start'] = $this->input->post('outstart');
        $formArray['out_end'] = $this->input->post('outend');
        $formArray['ot_start'] = $this->input->post('otstart');
        $formArray['ot_minute_to_one_hour'] = $this->input->post('otminute');
        $formArray['one_hour_ot_out_time'] = $this->input->post('onehrottime');
        $formArray['two_hour_ot_out_time'] = $this->input->post('twohrottime');
        $formArray['lunch_start'] = $this->input->post('lunch_start');
        $formArray['lunch_minute'] = $this->input->post('lunch_minute');
        $formArray['tiffin_break'] = $this->input->post('tiffin_break');
        $formArray['tiffin_minute'] = $this->input->post('tiffin_minute');
        $formArray['tiffin_break2'] = $this->input->post('tiffin_break2');
        $formArray['tiffin_minute2'] = $this->input->post('tiffin_minute2');
        $formArray['random_minute'] = $this->input->post('random_minute');
        $formArray['of_day'] = json_encode($this->input->post('of_day'));
        
        $this->db->where('id',$shiftscheduleId);
        $this->db->update('pr_emp_shift_schedule',$formArray);
    }

    function shiftschedule_delete($shiftscheduleId)
    {
        $this->db->where('id',$shiftscheduleId);
        $this->db->delete('pr_emp_shift_schedule');
    }



    //==============================Shift Management============================//





     function getshiftmanagement($shiftmanagementId)
    {
        $this->db->select('pr_emp_shift.*');
        // $this->db->join('pr_emp_shift_schedule','pr_emp_shift_schedule.id = pr_emp_shift.id');
        $this->db->where('id',$shiftmanagementId);
        return $this->db->get('pr_emp_shift')->row();
    }

    function shiftmanagement_infos()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS pr_emp_shift.*,pr_emp_shift_schedule.sh_type,unit_name', false);
        $this->db->from('pr_emp_shift');
        $this->db->join('pr_emp_shift_schedule','pr_emp_shift_schedule.id = pr_emp_shift.shift_duty');

        return $this->db->get()->result_array();

    }

    function shiftmanagement_fetch(){
        return $this->db->select('pr_emp_shift_schedule.*')->get('pr_emp_shift_schedule')->result_array();
    }



     function shiftmanagement_add($fromArray)
        {


              $this->db->insert('pr_emp_shift',$fromArray);

        }


     function shiftmanagement_edit($shiftmanagementId)
        {
             $formArray = array();
             $formArray['shift_name'] = $this->input->post('stname');
             $formArray['unit_id'] = $this->input->post('unitid');
             $formArray['shift_duty'] = $this->input->post('stype');


             $this->db->where('id',$shiftmanagementId);
             $this->db->update('pr_emp_shift',$formArray);

        }

     function shiftmanagement_delete($shiftmanagementId)
        {
            $this->db->where('id',$shiftmanagementId);
            $this->db->delete('pr_emp_shift');
        }



    //=============================Leave=========================================//



    function leave_infos()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS pr_leave.*', false);
        $this->db->from('pr_leave');
        return $this->db->get()->result_array();
    }

    function getleave($leaveId)
    {
        $this->db->where('lv_id',$leaveId);
        return $this->db->get('pr_leave')->row();
    }

    function getleaveid($leaveId)
    {
        $this->db->where('id',$leaveId);
        return $this->db->get('pr_leave_trans')->row();
    }


     function leave_edit($leaveId)
        {
             $formArray = array();
             $formArray['lv_name'] = $this->input->post('lvname');
             $formArray['status_id'] = $this->input->post('stid');
             $formArray['lv_sl'] = $this->input->post('sicklv');
             $formArray['lv_cl'] = $this->input->post('cullv');
             $formArray['lv_ml'] = $this->input->post('matrlv');
             $formArray['lv_pl'] = $this->input->post('patlv');


             $this->db->where('lv_id',$leaveId);
             $this->db->update('pr_leave',$formArray);

        }




    //============================AttendanceBonus====================================//





    function getbnruls($bnrulsId){
        // $this->db->select('B.*');
        // $this->db->from('pr_bonus_rules B');
        // $this->db->join('pr_emp_sts S','S.emp_sts = B.emp_type');
        $this->db->where('B.id',$bnrulsId);
        return $this->db->get('pr_bonus_rules B')->result_array();
    }

    function bnruls_infos($limit = 0,$start = 0)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS pr_bonus_rules.*, pr_units.unit_name',false);
        $this->db->from('pr_bonus_rules');
        $this->db->join('pr_units','pr_units.unit_id = pr_bonus_rules.unit_id','left');
        // $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }

    function units(){
        $this->db->select('pr_units.*');
        return $this->db->get('pr_units')->result_array();
    }

    function emp_type(){
        return $this->db->get('pr_emp_sts')->result_array();
    }



     function bnruls_add($fromArray)
        {



              $this->db->insert('pr_bonus_rules',$fromArray);

        }


     function bnruls_edit($bnrulsId)
        {
             $formArray = array();

             $formArray = array();
               $formArray['unit_id'] = $this->input->post('unit');
                $formArray['emp_type'] = $this->input->post('emptyp');
                $formArray['bonus_first_month'] = $this->input->post('bfmnth');
                $formArray['bonus_second_month'] = $this->input->post('bsmnth');
                $formArray['bonus_amount'] = $this->input->post('bamnt');
                $formArray['bonus_amount_fraction'] = $this->input->post('bamntf');
                $formArray['bonus_percent'] = $this->input->post('bper');
                $formArray['effective_date'] = $this->input->post('date_out');



             $this->db->where('id',$bnrulsId);
             $this->db->update('pr_bonus_rules',$formArray);

        }

     function bnruls_delete($bnrulsId)
        {
            $this->db->where('id',$bnrulsId);
            $this->db->delete('pr_bonus_rules');
        }



    //==========================Weekend Allowence===============================//


    function weekendallowence_infos($limit,$start){
        $this->db->select('rules.*,units.unit_name,desig.desig_name');

        $this->db->from('pr_weekend_allowance_rules rules');
        $this->db->join('pr_units units','units.unit_id = rules.unit_id','LEFT');
        $this->db->join('pr_weekend_allowance_level level','level.rules_id = rules.rules_id','LEFT');
        $this->db->join('emp_designation desig','desig.desig_id = level.desig_id','LEFT');
        // $this->db->limit($limit,$start);
        $query = $this->db->get()->result_array();
        // print_r($query);exit('ali');
        return $query;
        // return $this->db->get()->result_array();
    }




    //==============================Night Allowence============================//


    function nightallowence_infos(){
        $this->db->select('SQL_CALC_FOUND_ROWS rules.*,units.unit_name', false);
        $this->db->from('allowance_night_rules rules');
        $this->db->join('pr_units units','units.unit_id = rules.unit_id','LEFT');
        $this->db->join('pr_night_allowance_level level','level.rules_id = rules.rules_id','LEFT');
        // $this->db->limit($limit,$start);
        return $this->db->get()->result_array();
    }



    //==============================HolidayAllowence================================//


    function holidayallowence_infos($limit,$start){
        $this->db->select('SQL_CALC_FOUND_ROWS rules.*, units.unit_name, desig.desig_name', false);

        $this->db->from('attn_holiday_allowance_rules rules');
        $this->db->join('pr_units units','units.unit_id = rules.unit_id','LEFT');
        $this->db->join('attn_holiday_allowance_level level','level.rules_id = rules.rules_id','LEFT');
        $this->db->join('emp_designation desig','desig.id = level.desig_id','LEFT');
        return $this->db->get()->result_array();
    }


//==========================================Tax & Others===================================//


    function taxnother_infos(){
        $this->db->select('pr_deduct.*,pr_units.unit_name');
        $this->db->from('pr_deduct');
        $this->db->join('pr_units','pr_units.unit_id = pr_deduct.unit_id');
        return $this->db->get()->result_array();
    }

      function gettaxnother($taxnotherId)
    {
        $this->db->where('deduct_id',$taxnotherId);
        return $this->db->get('pr_deduct')->row();
    }


     function taxnother_add($fromArray) {

         $this->db->insert('pr_deduct',$fromArray);
     }

     function taxnother_delete($taxnotherId)
        {
            $this->db->where('deduct_id',$taxnotherId);
            $this->db->delete('pr_deduct');
        }

//==========================================Weekend Delete===================================//



function weekend_infos(){
    $this->db->select('attn_work_off.*, pr_units.unit_name');
    $this->db->from('attn_work_off');
    $this->db->join('pr_units', 'pr_units.unit_id = attn_work_off.unit_id');
    return $this->db->get()->result_array();
}



    function getweekend($weekendId)
    {
        $this->db->where('id',$weekendId);
        return $this->db->get('attn_work_off')->row();
    }




    function weekend_delete($weekendId)
    {
      $this->db->where('id',$weekendId);
      $this->db->delete('attn_work_off');
    }


//======================================Holiday Delete=================================//


    function holiday_infos($limit,$start){
        $this->db->select('attn_holiday.*,pr_units.unit_name');
        $this->db->from('attn_holiday');
        $this->db->join('pr_units','pr_units.unit_id = attn_holiday.unit_id');
        // $this->db->limit(10);
        $this->db->limit($limit,$start);
        $query = $this->db->get()->result_array();
        // print_r($query);exit('ali');
        return $query;
    }

      function getholiday($holidayId)
    {
        $this->db->where('id',$holidayId);
        return $this->db->get('attn_holiday')->row();
    }




     function holiday_delete($holidayId)
        {
            $this->db->where('id',$holidayId);
            $this->db->delete('attn_holiday');
        }


    //===============================Stop Salary=================================//


    function salarystop_infos($limit,$start){
        $this->db->select('pr_emp_stop_salary.*,pr_units.unit_name');
        $this->db->from('pr_emp_stop_salary');
        $this->db->join('pr_units','pr_units.unit_id = pr_emp_stop_salary.unit_id');
        // $this->db->limit(10);
        // $this->db->limit($limit,$start);
        $query = $this->db->get()->result_array();
        // print_r($query);exit('ali');
        return $query;

    }

    function getsalarystop($salarystopId)
    {
        $this->db->where('id',$salarystopId);
        return $this->db->get('pr_emp_stop_salary')->row();
    }

     function salarystop_add($fromArray) {

         $this->db->insert('pr_emp_stop_salary',$fromArray);
     }


    function salarystop_delete($salarystopId)
    {
        $this->db->where('id',$salarystopId);
        $this->db->delete('pr_emp_stop_salary');
    }



    //==========================Leave Delete=================================//


    function leave_del_infos($limit,$start,$searchQuery){
        $this->db->select('SQL_CALC_FOUND_ROWS pr_leave_trans.*,pr_units.unit_name,pr_emp_per_info.name_en', false);
        $this->db->from('pr_leave_trans');
        $this->db->join('pr_units', 'pr_units.unit_id = pr_leave_trans.unit_id');
        $this->db->join('pr_emp_com_info', 'pr_emp_com_info.emp_id = pr_leave_trans.emp_id');
        $this->db->join('pr_emp_per_info', 'pr_emp_com_info.id = pr_emp_per_info.emp_id');
        $this->db->limit($limit, $start);

        if ($searchQuery != '') {
            $this->db->like('pr_emp_per_info.name_en', $searchQuery);
        }
        $query = $this->db->get()->result_array();

        return $query;
    }

    function getleavedel($leaveId){
        $this->db->where('id',$leaveId);
        return $this->db->get('pr_leave_trans')->row();
    }

    function leave_delete($leaveId){
        $this->db->where('id',$leaveId);
        $this->db->delete('pr_leave_trans');
    }


    //==========================Left Delete=================================//


    function left_del_infos($limit,$start){
      $this->db->select('SQL_CALC_FOUND_ROWS pr_emp_left_history.*,per.name_en,com.emp_join_date,pr_units.unit_name', false);
      $this->db->from('pr_emp_left_history');
      $this->db->join('pr_units','pr_units.unit_id = pr_emp_left_history.unit_id');
      $this->db->join('pr_emp_per_info as per','per.emp_id = pr_emp_left_history.emp_id');
      $this->db->join('pr_emp_com_info as com','com.emp_id = pr_emp_left_history.emp_id');
      // $this->db->group_by('per.emp_id');
      // $this->db->limit(10);
      // $this->db->limit($limit,$start);
      $query = $this->db->get()->result_array();

      return $query;

    }

    function getleftid($leaveId)
    {
      $this->db->where('left_id',$leaveId);
      return $this->db->get('pr_emp_left_history')->row();
    }

    function left_delete($emp_id)
    {
      $data = array('emp_cat_id' => 1);
      $this->db->where('emp_id', $emp_id);
      $this->db->update('pr_emp_com_info', $data);

      $this->db->where('emp_id', $emp_id);
      $this->db->delete('pr_emp_left_history');

      return true;
    }

    //==========================Proxi ID====================================//


     function proxi_infos($limit,$start){
        $this->db->select('pr_id_proxi.*');
        $this->db->from('pr_id_proxi');
        $this->db->limit($limit,$start);
        $query = $this->db->get()->result_array();
        // print_r($start);exit('ali');
       /* echo $this->db->last_query(); die;*/
        return $query;
      }

     function getproxi($empId)
      {
          $this->db->where('emp_id',$empId);
          return $this->db->get('pr_id_proxi')->row();
      }


     function proxi_edit($empId)
        {
             $formArray = array();
             $formArray['emp_id'] = $empId;
             $formArray['proxi_id'] = $this->input->post('proxiId');
             // print_r($formArray);exit('ali');

             $this->db->where('emp_id',$empId);
             $this->db->update('pr_id_proxi',$formArray);

        }




}

?>

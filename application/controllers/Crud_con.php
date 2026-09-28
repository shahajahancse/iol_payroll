<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Crud_con extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        /* Standard Libraries */

        $this->load->model('Common_model');
        $this->load->model('Crud_model');
          $this->data['user_data'] = $this->session->userdata('data');

    }



    //===================================Floor=======================================================//

    public function floor_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $data['floor'] = $this->Crud_model->floor_fetch();

        $this->form_validation->set_rules('name', 'Floor Name', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->load->view('floor_add', $data);
        } else {
            // print_r($_FILES['logoAAAAA']);
            // print_r($_POST);exit();
            $formArray = array();
            $formArray['name'] = $this->input->post('name');
            $formArray['floor'] = $this->input->post('floor');

            $this->Crud_model->floor_add($formArray);
            $this->session->set_flashdata('success', 'Record adder successfully!');
            //alert('Record adder successfully!');
            redirect(base_url() . 'index.php/setup_con/floor');

        }

    }

    public function floor_edit($floorId)
    {
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Floor Name', 'trim|required');
        $data['floor'] = $this->Crud_model->floor_fetch();

        if ($this->form_validation->run() == false) {

            $data['pr_floor'] = $this->Crud_model->getfloor($floorId);

            $this->load->view('floor_edit', $data);

        } else {
            $this->Crud_model->floor_edit($floorId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');
            //alert('Record adder successfully!');
            redirect('/setup_con/floor');

        }

    }

    public function floor_delete($floorId)
    {
        $this->load->model('Crud_model');
        $floor = $this->Crud_model->getfloor($floorId);
        if (empty($floor)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/floor');
        }
        $this->Crud_model->floor_delete($floorId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/floor');
    }

    //=========================================Department===============================================//

    public function dept_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $data['dept'] = $this->Crud_model->dept_fetch();

        $this->form_validation->set_rules('name', 'dept Name', 'trim|required');
        $this->form_validation->set_rules('bname', 'dept Bangla Name', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->load->view('dept_add', $data);
        } else {
            // print_r($_FILES['logoAAAAA']);
            // print_r($_POST);exit();
            $formArray = array();
            $formArray['name'] = $this->input->post('name');
            $formArray['bname'] = $this->input->post('bname');
            $formArray['dept'] = $this->input->post('dept');

            $this->Crud_model->dept_add($formArray);
            $this->session->set_flashdata('success', 'Record adder successfully!');
            //alert('Record adder successfully!');
            redirect(base_url() . 'index.php/setup_con/department');

        }

    }

    public function dept_delete($deptId)
    {
        $this->load->model('Crud_model');
        $dept = $this->Crud_model->getdept($deptId);
        if (empty($dept)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/department');
        }
        $this->Crud_model->dept_delete($deptId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/department');
    }

//============================================Section===============================================//

//============================================Line===============================================//

    public function line_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $data['line'] = $this->Crud_model->line_fetch();

        $this->form_validation->set_rules('name', 'line Name', 'trim|required');
        $this->form_validation->set_rules('bname', 'line Bangla Name', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->load->view('line_add', $data);
        } else {
            // print_r($_FILES['logoAAAAA']);
            // print_r($_POST);exit();
            $formArray = array();
            $formArray['name'] = $this->input->post('name');
            $formArray['bname'] = $this->input->post('bname');
            $formArray['strn'] = $this->input->post('strn');
            $formArray['strf'] = $this->input->post('strf');
            $formArray['line'] = $this->input->post('line');
            $formArray['indx'] = $this->input->post('indx');

            $this->Crud_model->line_add($formArray);
            $this->session->set_flashdata('success', 'Record adder successfully!');
            //alert('Record adder successfully!');
            redirect(base_url() . 'index.php/setup_con/line');

        }

    }

    public function line_edit($lineId)
    {
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'line Name', 'trim|required');
        $data['line'] = $this->Crud_model->line_fetch();

        if ($this->form_validation->run() == false) {
            $data['pr_line'] = $this->Crud_model->getline($lineId);

            $this->load->view('line_edit', $data);

        } else {
            $this->Crud_model->line_edit($lineId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');
            //alert('Record adder successfully!');
            redirect('/setup_con/line');

        }

    }

    public function line_delete($lineId)
    {
        $this->load->model('Crud_model');
        $line = $this->Crud_model->getline($lineId);
        if (empty($line)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/line');
        }
        $this->Crud_model->line_delete($lineId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/line');
    }

//=========================================Designation===============================================//

    public function desig_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $data['desig'] = $this->Crud_model->desig_fetch();

        $this->form_validation->set_rules('name', 'desig Name', 'trim|required');
        $this->form_validation->set_rules('bname', 'desig Bangla Name', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->load->view('desig_add', $data);
        } else {
            // print_r($_FILES['logoAAAAA']);
            // print_r($_POST);exit();
            $formArray = array();
            $formArray['name'] = $this->input->post('name');
            $formArray['bname'] = $this->input->post('bname');
            $formArray['desig'] = $this->input->post('desig');

            $this->Crud_model->desig_add($formArray);
            $this->session->set_flashdata('success', 'Record adder successfully!');
            //alert('Record adder successfully!');
            redirect(base_url() . 'index.php/setup_con/designation');

        }

    }

    public function desig_edit($desigId)
    {
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'desig Name', 'trim|required');
        $data['desig'] = $this->Crud_model->desig_fetch();

        if ($this->form_validation->run() == false) {

            $data['pr_designation'] = $this->Crud_model->getdesig($desigId);

            $this->load->view('desig_edit', $data);

        } else {
            $this->Crud_model->desig_edit($desigId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');
            //alert('Record adder successfully!');
            redirect('/setup_con/designation');

        }

    }

    public function desig_delete($desigId)
    {
        $this->load->model('Crud_model');
        $desig = $this->Crud_model->getdesig($desigId);
        if (empty($desig)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/designation');
        }
        $this->Crud_model->desig_delete($desigId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/designation');
    }

//============================================AttendanceBonus=============================================//

    public function attbn_add()
    {

        $this->load->library('form_validation');
        // $data['attbn'] = $this->Crud_model->attbn_fetch();

        $this->form_validation->set_rules('name', 'attbn Rule Name', 'trim|required');
        $this->form_validation->set_rules('amnt', 'attbn Amount', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->load->view('attbn_add');
        } else {
            // print_r($_FILES['logoAAAAA']);
            // print_r($_POST);exit();
            $formArray = array();
            $formArray['name'] = $this->input->post('name');
            $formArray['amnt'] = $this->input->post('amnt');

            $this->Crud_model->attbn_add($formArray);
            $this->session->set_flashdata('success', 'Record adder successfully!');
            //alert('Record adder successfully!');
            redirect(base_url() . 'index.php/setup_con/attendance_bonus');

        }

    }

    public function attbn_edit($attbnId)
    {
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'attbn Name', 'trim|required');
        $this->form_validation->set_rules('amnt', 'attbn Amount', 'trim|required');

        // $data['attbn'] = $this->Crud_model->attbn_fetch();

        if ($this->form_validation->run() == false) {

            $data['pr_attn_bonus'] = $this->Crud_model->getattbn($attbnId);
            print_r($data);

            $this->load->view('attbn_edit', $data);

        } else {
            $this->Crud_model->attbn_edit($attbnId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');

            redirect('/setup_con/attendance_bonus');

        }

    }

    public function attbn_delete($attbnId)
    {
        $this->load->model('Crud_model');
        $attbn = $this->Crud_model->getattbn($attbnId);
        if (empty($attbn)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/attendance_bonus');
        }
        $this->Crud_model->attbn_delete($attbnId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/attendance_bonus');
    }

//===========================================Salary Grade=============================================//

    public function salgrd_add()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('gr_name', 'salgrd Rule Name', 'trim|required');
        $this->form_validation->set_rules('salary', 'salgrd Rule Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'salgrd_add';
            $this->load->view('layout/template', $this->data);
        } else {

            $formArray = array();
            $formArray['gr_name'] = $this->input->post('gr_name');
            $formArray['salary'] = $this->input->post('salary');

            $this->Crud_model->salgrd_add($formArray);
            $this->session->set_flashdata('success', 'Record added successfully!');
            redirect(base_url() . 'index.php/setup_con/salary_grade');

        }

    }

    public function salgrd_edit($salgrdId)
    {
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('gr_name', 'salgrd Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['title'] = 'Edit Salary Grade';
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['pr_grade'] = $this->Crud_model->getsalgrd($salgrdId);
            $this->data['subview'] = 'salgrd_edit';
            $this->load->view('layout/template', $this->data);
        } else {
            $this->Crud_model->salgrd_edit($salgrdId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');
            redirect('/setup_con/salary_grade');
        }
    }
    public function salgrd_delete($salgrdId)
    {
        $this->load->model('Crud_model');
        $salgrd = $this->Crud_model->getsalgrd($salgrdId);
        if (empty($salgrd)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/salary_grade');
        }
        $this->Crud_model->salgrd_delete($salgrdId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/salary_grade');
    }

//==============================================Shift Schedule=============================================//

//=============================================Shift Management============================================//

//=================================================Leave====================================================//

    public function leave_edit($leaveId)
    {
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        // $data['leave'] = $this->Crud_model->leave_fetch();

        // print_r($data);

        $this->form_validation->set_rules('lvname', 'leave Leave Name', 'trim|required');
        $this->form_validation->set_rules('stid', 'leave Status ID', 'trim|required');
        $this->form_validation->set_rules('sicklv', 'leave Sick Leave', 'trim|required');
        $this->form_validation->set_rules('cullv', 'leave Casual Leave', 'trim|required');
        $this->form_validation->set_rules('matrlv', 'leave Maternity Leave', 'trim|required');
        $this->form_validation->set_rules('patlv', 'leave Paternity Leave', 'trim|required');

        // $data['leave'] = $this->Crud_model->leave_fetch();

        if ($this->form_validation->run() == false) {

            $data['pr_leave'] = $this->Crud_model->getleave($leaveId);

            $this->load->view('leave_edit', $data);

        } else {

            $this->Crud_model->leave_edit($leaveId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');

            redirect('/setup_con/leave_setup');

        }

    }

//============================================Bonus Rules=============================================//

    public function bnruls_add()
    {

        $this->load->library('form_validation');
        // $data['bnruls'] = $this->Crud_model->bnruls_fetch_unit();
        // $data['bnruls'] = $this->Crud_model->bnruls_fetch_unit();
        $data['epmtype'] = $this->Crud_model->units();
        $data['epmtype'] = $this->Crud_model->emp_type();

        // print_r($data);exit('ali');

        // $this->form_validation->set_rules('unit', 'bnruls Unit id', 'trim|required');
        // $this->form_validation->set_rules('emptyp', 'bnruls Emp type', 'trim|required');
        $this->form_validation->set_rules('bfmnth', 'bnruls Bonus first month', 'trim|required');
        $this->form_validation->set_rules('bsmnth', 'bnruls Bonus second month', 'trim|required');
        $this->form_validation->set_rules('bamnt', 'bnruls Bonus amount', 'trim|required');
        $this->form_validation->set_rules('bamntf', 'bnruls Bonus amount fraction', 'trim|required');
        $this->form_validation->set_rules('bper', 'bnruls Bonus percent', 'trim|required');
        $this->form_validation->set_rules('date_out', 'bnruls Effective date', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('bnrules_add', $data);
        } else {

            $formArray = array();
            $formArray['unit_id'] = $this->input->post('unit');
            $formArray['emp_type'] = $this->input->post('emptyp');
            $formArray['bonus_first_month'] = $this->input->post('bfmnth');
            $formArray['bonus_second_month'] = $this->input->post('bsmnth');
            $formArray['bonus_amount'] = $this->input->post('bamnt');
            $formArray['bonus_amount_fraction'] = $this->input->post('bamntf');
            $formArray['bonus_percent'] = $this->input->post('bper');
            $formArray['effective_date'] = $this->input->post('date_out');

            $this->Crud_model->bnruls_add($formArray);
            $this->session->set_flashdata('success', 'Record adder successfully!');
            redirect(base_url() . 'index.php/setup_con/bonus_setup');

        }

    }
    public function bnruls_edit($bnrulsId)
    {
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');
        // $data['bnruls'] = $this->Crud_model->bnruls_fetch_unit();
        $data['units'] = $this->Crud_model->units();
        $data['emp_type'] = $this->Crud_model->emp_type();
        // print_r($data);
        // exit();

        // $this->form_validation->set_rules('unit', 'bnruls Unit id', 'trim|required');
        // $this->form_validation->set_rules('emptyp', 'bnruls Emp type', 'trim|required');
        $this->form_validation->set_rules('bfmnth', 'bnruls Bonus first month', 'trim|required');
        $this->form_validation->set_rules('bsmnth', 'bnruls Bonus second month', 'trim|required');
        $this->form_validation->set_rules('bamnt', 'bnruls Bonus amount', 'trim|required');
        $this->form_validation->set_rules('bamntf', 'bnruls Bonus amount fraction', 'trim|required');
        $this->form_validation->set_rules('bper', 'bnruls Bonus percent', 'trim|required');
        $this->form_validation->set_rules('date_out', 'bnruls Effective date', 'trim|required');

        // $data['bnruls'] = $this->Crud_model->bnruls_fetch();

        if ($this->form_validation->run() == false) {
            $data['bonus_rules'] = $this->Crud_model->getbnruls($bnrulsId);
            // print_r($data);exit();
            $this->load->view('bnrules_edit', $data);
        } else {
            $this->Crud_model->bnruls_edit($bnrulsId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');

            redirect('/setup_con/bonus_setup');
        }

    }

    public function bnruls_delete($bnrulsId)
    {
        $this->load->model('Crud_model');
        $bnruls = $this->Crud_model->getbnruls($bnrulsId);
        if (empty($bnruls)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/setup_con/bonus_setup');
        }
        $this->Crud_model->bnruls_delete($bnrulsId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/setup_con/bonus_setup');
    }

//==============================================Tax & Others===================================================//

    public function taxnother_add(){
        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $this->data['taxnother'] = $this->Crud_model->units();
        // = $taxnother;
        // dd($this->data);

        $this->form_validation->set_rules('unit', 'taxnother Unit', 'trim|required');
        $this->form_validation->set_rules('empid', 'taxnother EMP ID', 'trim|required');
        $this->form_validation->set_rules('tax', 'taxnother Tax Amount', 'trim|required');
        $this->form_validation->set_rules('other', 'taxnother Other', 'trim|required');
        $this->form_validation->set_rules('date_out', 'taxnother Month', 'trim|required');

        if ($this->form_validation->run() == false) {
            // $this->load->view('taxnother_add', $data);
            $this->data['user_data'] = $this->session->userdata('data');
            $this->data['username'] = $this->data['user_data']->id_number;
            $this->data['subview'] = 'taxnother_add';
            $this->load->view('layout/template', $this->data);
        } else {
            // print_r($_FILES['logoAAAAA']);
            // print_r($_POST);exit();
            $formArray = array();
            $formArray['unit_id'] = $this->input->post('unit');
            $formArray['emp_id'] = $this->input->post('empid');
            $formArray['tax_deduct'] = $this->input->post('tax');
            $formArray['others_deduct'] = $this->input->post('other');
            $formArray['deduct_month'] = $this->input->post('date_out');

            $this->Crud_model->taxnother_add($formArray);
            $this->session->set_flashdata('success', 'Record adder successfully!');
            //alert('Record adder successfully!');
            redirect(base_url() . 'index.php/entry_system_con/tax_others_deduction');

        }

    }

    public function taxnother_delete($taxnotherId)
    {
        $this->load->model('Crud_model');
        $taxnother = $this->Crud_model->gettaxnother($taxnotherId);
        if (empty($taxnother)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/entry_system_con/tax_others_deduction');
        }
        $this->Crud_model->taxnother_delete($taxnotherId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/entry_system_con/tax_others_deduction');
    }

    //========================Weekend Delete====================================//

    public function weekend_delete($weekendId)
    {
        $this->load->model('Crud_model');
        $weekend = $this->Crud_model->getweekend($weekendId);
        if (empty($weekend)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/entry_system_con/weekend_delete');
        }
        $this->Crud_model->weekend_delete($weekendId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/entry_system_con/weekend_delete');
    }

    //==========================Weekend Delete====================================//

    public function holiday_delete($holidayId)
    {
        $this->load->model('Crud_model');
        $holiday = $this->Crud_model->getholiday($holidayId);
        if (empty($holiday)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/entry_system_con/holiday_delete');
        }
        $this->Crud_model->holiday_delete($holidayId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/entry_system_con/holiday_delete');
    }

    //============================Salary Stop====================================//

    public function salarystop_add()
    {

        $this->load->library('form_validation');
        $this->load->model('Crud_model');
        $data['salarystop'] = $this->Crud_model->units();

        $this->form_validation->set_rules('unit', 'salarystop Unit', 'trim|required');
        $this->form_validation->set_rules('empid', 'salarystop EMP ID', 'trim|required');
        $this->form_validation->set_rules('date_out', 'salarystop Salary Month', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->load->view('salary_stop_add', $data);
        } else {
            // print_r($_FILES['logoAAAAA']);
            // print_r($_POST);exit();
            $formArray = array();
            $formArray['unit_id'] = $this->input->post('unit');
            $formArray['emp_id'] = $this->input->post('empid');
            $formArray['salary_month'] = $this->input->post('date_out');

            $this->Crud_model->salarystop_add($formArray);
            $this->session->set_flashdata('success', 'Record adder successfully!');
            //alert('Record adder successfully!');
            redirect(base_url() . 'index.php/entry_system_con/stop_salary');

        }

    }

    public function salarystop_delete($salarystopId)
    {
        $this->load->model('Crud_model');
        $salarystop = $this->Crud_model->getsalarystop($salarystopId);
        if (empty($salarystop)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/entry_system_con/stop_salary');
        }
        $this->Crud_model->salarystop_delete($salarystopId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/entry_system_con/stop_salary');
    }

    //=====================Leave Delete================================//
    public function leave_delete($leaveId)
    {
        $this->load->model('Crud_model');
        $leave = $this->Crud_model->getleaveid($leaveId);
        if (empty($leave)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/entry_system_con/leave_delete');
        }
        $this->Crud_model->leave_delete($leaveId);
        $this->session->set_flashdata('success', 'Record Deleted successfully!');
        redirect('/entry_system_con/leave_delete');
    }

    //=====================Left Delete================================//
    public function left_delete($leaveId)
    {
        // echo "$leaveId"; exit;
        $this->load->model('Crud_model');
        $leave = $this->Crud_model->getleftid($leaveId);
        if (empty($leave)) {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/entry_system_con/left_delete');
        }

        if ($this->Crud_model->left_delete($leave->emp_id)) {
            $this->session->set_flashdata('success', 'Record Deleted successfully!');
            redirect('/entry_system_con/left_delete');
        } else {
            $this->session->set_flashdata('failure', 'Record Not Found in DataBase!');
            redirect('/entry_system_con/left_delete');
        }

    }

    //===========================Proxi ID===================================//

    public function proxi_edit($empId)
    {
        $data = array();
        $this->load->model('Crud_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('proxiId', 'Emp ID', 'trim|required');

        if ($this->form_validation->run() == false) {

            $data['pr_id_proxi'] = $this->Crud_model->getproxi($empId);
            // print_r($data);exit('ali');

            $this->load->view('proxi_edit', $data);

        } else {
            $this->Crud_model->proxi_edit($empId);
            $this->session->set_flashdata('success', 'Record Updated successfully!');
            //alert('Record adder successfully!');
            redirect('/entry_system_con/proximity_card_edit');

        }

    }

}

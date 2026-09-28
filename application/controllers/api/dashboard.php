<?php defined('BASEPATH') OR exit('No direct script access allowed');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Dashboard extends REST_Controller
{

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        ini_set('date.timezone', 'Asia/Dacca');

        $this->load->model('admin/Admin_model');
        $this->load->model('admin/Dashboard_model');
    }


    function index_get(){
        $data = array();
        $login_data = $this->Admin_model->check_user_account_FE();
        $start_date = '2019-09-01';
        // $start_date = date('Y-m-1',strtotime('-1 month'));
        // $end_date = date('Y-m-t',strtotime('-1 month'));
        $end_date = '2019-09-30';
        $data['department'] = 0;
        $data['section'] = 0;
        $data['designation'] = 0;
        $data['line'] = 0;
        if ($login_data['logged_in'] == true )
        {
            $department = $this->get('department')? $this->get('department') : 0;
            $section = $this->get('section')? $this->get('section') : 0;
            $line = $this->get('line')? $this->get('line') : 0;
            $attendance_date = $this->get('attendance_date')? $this->get('attendance_date') : 0;
            $salary_month = $this->get('salary_month')? $this->get('salary_month') : 0;
            if($department || $section || $line || $attendance_date || $salary_month)
            {
                // Attendance Status
                $data['attendance'] = null;
                if (!empty($attendance_date) || ($department || $section || $line)) {
                    $employee = $this->Dashboard_model->get_emp_id($department, $section, $line);
                    if (!empty($employee)) {
                        // $att_date = date("Y-m-d", strtotime($attendance_date));
                        $att_date = '2019-09-03';
                        $data['attendance'] = $this->Dashboard_model->attendance_status($att_date, $employee);
                    } else {
                        $data['attendance'] = null;
                    }
                } else {
                    $all_id = $this->Dashboard_model->get_emp_id();
                    $data['attendance'] = $this->Dashboard_model->attendance_status('2019-09-03', $all_id);
                }
                //  man pawer status
                if ($department || $section || $line) {
                    // $att_date = date("Y-m-d", strtotime($attendance_date));
                    $att_date = '2019-09-03';
                    $employee = $this->Dashboard_model->get_emp_id($department, $section, $line);
                    if (!empty($employee)) {
                        $data['manpower'] = $this->Dashboard_model->man_power_status($att_date, $employee);
                    } else {
                        $data['manpower'] = null;
                    }
                } else {
                    $att_date = '2019-09-03';
                    $all_id = $this->Dashboard_model->get_emp_id();
                    $data['manpower'] = $this->Dashboard_model->man_power_status($att_date, $all_id);
                }

                // Month Salary Expense
                $data['month_wise_salary'] = null;
                if (!empty($salary_month)) {
                    $date = $salary_month.'-01';
                    $start_date = date('Y-m-d', strtotime($date));
                    $end_date = date('Y-m-t', strtotime($date));
                    $data['month_wise_salary'] = $this->Dashboard_model->salary_month_expense($start_date, $end_date, $department, $section, $line);
                } else {
                    $data['month_wise_salary'] = $this->Dashboard_model->salary_month_expense($start_date, $end_date, $department, $section, $line);

                }

                // Monthly Employee Status
                if ($department || $section || $line || $salary_month) {
                    $employee = $this->Dashboard_model->get_emp_id($department, $section, $line);
                    $data['monthly_employee']['total_join'] = $this->Dashboard_model->monthly_join_emp($start_date, $end_date, $employee);
                    $data['monthly_employee']['total_resign'] = $this->Dashboard_model->monthly_resign_emp($start_date, $end_date, $employee);
                    $data['monthly_employee']['total_left'] = $this->Dashboard_model->monthly_left_emp($start_date, $end_date, $employee);
                } else {
                    $data['monthly_employee'] = null;
                }

                $this->response(array('status' => 200, 'response' => 'success', 'data' => $data, 'msg' => 'Data found'), 200);

            }

            $data = $this->Dashboard_model->dashboard($start_date, $end_date);
            $this->response(array('status' => 200, 'response' => 'success', 'data' => $data, 'msg' => 'Data found'), 200);
        }else{
            $this->response(array('status' => 404, 'response' => 'Failed', 'data' => null, 'msg' => 'Data not found'), 404);
        }
    }

    function common_data_get(){

        $data = array();
        $data = $this->Dashboard_model->get_dept_section_line();
        if (!empty($data)) {
            $this->response(array('status' => 200, 'response' => 'success', 'data' => $data, 'msg' => 'Data found'), 200);
        } else {
            $this->response(array('status' => 404, 'response' => 'Failed', 'data' => null, 'msg' => 'Data not found'), 404);
        }
    }

    /* function get_filter_data($department, $section, $line, $attendance_date, $salary_month)
    {
        $data = array();
        $data['attendance'] = null;
        if (!empty($attendance_date)) {
            $employee = $this->Dashboard_model->get_emp_id($department, $section, $line);
            if (!empty($employee)) {
                $att_date = date("Y-m-d", strtotime($attendance_date));
                $data['attendance'] = $this->Dashboard_model->attendance_status($att_date, $employee);
            } else {
                $data['attendance'] = 0;
            }
        }

        $data['month_wise_salary'] = null;
        if (!empty($salary_month)) {
            $date = $salary_month.'-01';
            $start_date = date('Y-m-d', strtotime($date));
            $end_date = date('Y-m-t', strtotime($date));
            $data['month_wise_salary'] = $this->Dashboard_model->salary_month_expense($start_date, $end_date, $department, $section, $line);
        } else {
            $data['month_wise_salary'] = null;
        }

        $response = $this->response(array('status' => 200, 'response' => 'success', 'data' => $data, 'msg' => 'Data found'), 200);
        return redirect(base_url('index.php/api/user/dashboard', $response));
    } */


}
<?php defined('BASEPATH') OR exit('No direct script access allowed');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Auth extends REST_Controller
{

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries */
        ini_set('date.timezone', 'Asia/Dacca');

        $this->load->model('admin/Admin_model');
    }


    function login_post(){
        $username = $this->post('username');
        $password = $this->post('password');
        if($username != '' && $password != '')
        {
            $data =$this->Admin_model->check_user_account_FE();
            $this->response($data, 200);
        }
        else
        {
            // $this->response(array('error' => 'Username and password can not be null'), 404);
            $this->response(array('status' => 404, 'response' => 'Username and password can not be null', 'data' => null, 'logged_in' => false ), 404);
        }
    }

}

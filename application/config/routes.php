<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// $route['default_controller'] = 'welcome';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;


$route['default_controller'] = "authentication";
$route['scaffolding_trigger'] = "";
$route['404_override'] = '';


$route['admin'] = "admin/Newcon";
$route['admin/login'] = "admin/Newcon/login";
$route['admin/logout'] = "admin/Newcon/logout";
$route['admin/request'] = "admin/Newcon/request";
$route['admin/users_search'] = "admin/Newcon/users_search";
$route['admin/users_search/(:num)'] = "admin/Newcon/users_search/$1";
$route['admin/add_books'] = "admin/Newcon/add_books";
$route['admin/add_ebooks'] = "admin/Newcon/add_ebooks";
$route['admin/journals'] = "admin/Newcon/journals";
$route['admin/member'] = "admin/Newcon/add_member";
$route['admin/add_member_process'] = "admin/Newcon/add_member_process";
$route['admin/home'] = "admin/Newcon/home";
$route['admin/facilities'] = "admin/Newcon/facilities";
$route['admin/hours'] = "admin/Newcon/hours";
$route['admin/rules'] = "admin/Newcon/rules";
$route['user_autentication'] = "admin/Newcon/login_process";
$route['logout_FE'] = "admin/Newcon/logout_FE";
$route['admin/list'] = "admin/Newcon/list_member";

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8

/* End of file routes.php */
/* Location: ./application/config/routes.php */

/*
| -------------------------------------------------------------------------
| REST API Routes List
| -------------------------------------------------------------------------
*/
$route['api/user/login'] = 'api/auth/login'; // login Route
$route['api/user/dashboard'] = 'api/dashboard/index'; // dashboard Route
$route['api/dashboard/common-data'] = 'api/dashboard/common_data';

/*
| -------------------------------------------------------------------------
| ZKTeco ADMS (Push SDK) Protocol Routes for SenseFace 4A & Devices
| -------------------------------------------------------------------------
*/
$route['iclock/cdata'] = 'iclock/cdata';
$route['iclock/cdata.aspx'] = 'iclock/cdata';
$route['iclock/cdata.php'] = 'iclock/cdata';
$route['iclock/getrequest'] = 'iclock/getrequest';
$route['iclock/devicecmd'] = 'iclock/devicecmd';
$route['iclock/registry'] = 'iclock/registry';
$route['iclock/push'] = 'iclock/push';
$route['iclock/device_list'] = 'iclock/device_list';
$route['iclock/(:any)'] = 'iclock/$1';

/*
| -------------------------------------------------------------------------
| Leave Management Workflow Routes
| -------------------------------------------------------------------------
*/
$route['hr_leave_dashboard'] = 'leave_con/hr_dashboard';
$route['admin_leave_dashboard'] = 'leave_con/admin_dashboard';

/*
| -------------------------------------------------------------------------
| Daily OT Approval & Admin Management Routes
| -------------------------------------------------------------------------
*/
$route['admin_ot_dashboard'] = 'ot_approval_con/admin_dashboard';

/*
| -------------------------------------------------------------------------
| Outside Duty (OD) Management Routes
| -------------------------------------------------------------------------
*/
$route['od']             = 'od_management_con/index';
$route['od/manage']      = 'od_management_con/index';
$route['od/dashboard']   = 'od_management_con/index';
$route['od/create']      = 'od_management_con/create';
$route['od/edit/(:num)'] = 'od_management_con/edit/$1';
$route['od/list']        = 'od_management_con/list';
$route['od/approval']    = 'od_management_con/approval';
$route['od/reports']     = 'od_management_con/reports';
$route['od/report_data_ajax']       = 'od_management_con/report_data_ajax';
$route['od/dashboard_stats_ajax']   = 'od_management_con/dashboard_stats_ajax';
$route['od/list_ajax']              = 'od_management_con/list_ajax';
$route['od/employee_search_ajax']   = 'od_management_con/employee_search_ajax';
$route['od/employee_info_ajax']     = 'od_management_con/employee_info_ajax';
$route['od/check_conflicts_ajax']   = 'od_management_con/check_conflicts_ajax';
$route['od/details_ajax/(:num)']    = 'od_management_con/details_ajax/$1';
$route['od/approve_ajax']           = 'od_management_con/approve_ajax';
$route['od/bulk_approve_ajax']      = 'od_management_con/bulk_approve_ajax';
$route['od/reject_ajax']            = 'od_management_con/reject_ajax';
$route['od/cancel_ajax']            = 'od_management_con/cancel_ajax';
$route['od/export_excel']           = 'od_management_con/export_excel';
$route['od/export_pdf']             = 'od_management_con/export_pdf';

/*
| -------------------------------------------------------------------------
| Attendance Regularization & Remark Management Routes
| -------------------------------------------------------------------------
*/
$route['attn_regularization']               = 'attn_regularization_con/dashboard';
$route['attn_regularization/dashboard']     = 'attn_regularization_con/dashboard';
$route['attn_regularization/create']        = 'attn_regularization_con/dashboard';
$route['attn_regularization/save']          = 'attn_regularization_con/save';
$route['attn_regularization/list']          = 'attn_regularization_con/list';
$route['attn_regularization/approval']      = 'attn_regularization_con/approval';
$route['attn_regularization/action']        = 'attn_regularization_con/action';
$route['attn_regularization/reports']       = 'attn_regularization_con/reports';
$route['attn_regularization/delete/(:num)'] = 'attn_regularization_con/delete/$1';
$route['attn_regularization/get_issues_ajax'] = 'attn_regularization_con/get_issues_ajax';
$route['attn_regularization/get_issue_detail_ajax'] = 'attn_regularization_con/get_issue_detail_ajax';
$route['attn_regularization/save_quick_remark_ajax'] = 'attn_regularization_con/save_quick_remark_ajax';

/*
| -------------------------------------------------------------------------
| Arrear Salary Management Routes
| -------------------------------------------------------------------------
*/
$route['arrear_salary']                      = 'arrear_salary_con/index';
$route['arrear_salary/create']               = 'arrear_salary_con/create';
$route['arrear_salary/edit/(:any)']          = 'arrear_salary_con/edit/$1';
$route['arrear_salary/save']                 = 'arrear_salary_con/save';
$route['arrear_salary/delete/(:any)']        = 'arrear_salary_con/delete/$1';
$route['arrear_salary/approve/(:any)']       = 'arrear_salary_con/approve/$1';
$route['arrear_salary/cancel/(:any)']        = 'arrear_salary_con/cancel/$1';
$route['arrear_salary/employee_search_ajax'] = 'arrear_salary_con/employee_search_ajax';
$route['arrear_salary/get_employee_ajax']    = 'arrear_salary_con/get_employee_ajax';
$route['arrear_salary/get_arrear_ajax/(:num)'] = 'arrear_salary_con/get_arrear_ajax/$1';





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
$route['default_controller'] = 'LoginController';
$route['user/register'] = 'LoginController/userRegister';
$route['user/save'] = 'LoginController/saveUser';
$route['user/login'] = 'LoginController/userLogin';
$route['user/for-got-password'] = 'LoginController/forgotPassword';
$route['user/verify'] = 'LoginController/verifyUser';
$route['user/reset-password/(:any)'] = 'LoginController/resetPassword/$1';
$route['user/change-password'] = 'LoginController/changePassword';


$route['razorpay/callback'] = 'LoginController/callback';
$route['razorpay/success'] = 'LoginController/success';
$route['razorpay/failed'] = 'LoginController/failed';


$route['logout'] = 'LoginController/logout';


$route['user/dashboard'] = 'DashboardController';
$route['user/questions'] = 'DashboardController/userQuestion';
$route['user/save-answer'] = 'DashboardController/saveUserAnswer';
$route['user/result'] = 'DashboardController/showResult';


$route['user/user-profile'] = 'DashboardController/userProfile';
$route['user/update-profile'] = 'DashboardController/updateProfile';
$route['user/update-password'] = 'DashboardController/updatePassword';


$route['admin/dashboard'] = 'AdminController';
$route['admin/category'] = 'AdminController/listCategory';
$route['admin/category/create'] = 'AdminController/createCategory';
$route['admin/category/update'] = 'AdminController/createUpdate';
$route['admin/category/delete/(:num)'] = 'AdminController/deleteCategory/$1';
$route['admin/edit-catgeroy'] = 'AdminController/editCategory';
$route['admin/edit-catgeroy'] = 'AdminController/editCategory';
$route['admin/user-score'] = 'AdminController/userScore';
$route['admin/score/mail/(:num)'] = 'AdminController/scoreMail/$1';
$route['admin/sned-score/mail/(:num)'] = 'AdminController/sendScoreMail/$1';


$route['admin/questions'] = 'AdminController/questionList';
$route['admin/question-details'] = 'AdminController/questionDetails';
$route['admin/add-question-details'] = 'AdminController/addQuestionDetails';
$route['admin/question/delete/(:num)'] = 'AdminController/deleteQuestion/$1';
$route['admin/question/edit/(:num)'] = 'AdminController/editQuestion/$1';
$route['admin/update-question-details'] = 'AdminController/updateQuestion';
$route['admin/option/delete'] = 'AdminController/deleteOption';

$route['admin/users'] = 'AdminController/userList';
$route['admin/user/changeStatus'] = 'AdminController/changeStatus';




$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

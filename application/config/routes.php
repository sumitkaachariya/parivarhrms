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
$route['default_controller'] = 'welcome';
$route['check_auth'] = 'credentials/Login/check_auth';


// Dashboard
$route['dashboard'] = 'dashboard/Dashboard';
$route['users'] = 'users/User';
$route['users/add_user'] = 'users/User/add_user';
$route['users/save_user'] = 'users/User/save_user';
$route['subscription'] = 'user/Subscription';
$route['subscription/update'] = 'user/Subscription/update_subscription';
$route['subscription/remark'] = 'user/Subscription/remark';
$route['subscription/new'] = 'user/Subscription/new';
$route['subscription/edit'] = 'user/Subscription/edit';
$route['subscription/update_edu'] = 'user/Subscription/update_edu';
$route['subscription/delete_subscrption_rec'] = 'user/Subscription/delete_subscrption_rec';
$route['subscription/update_details_subscription'] = 'user/Subscription/update_details_subscription';
$route['subscription/printview'] = 'user/Subscription/printview';
$route['subscription/submit_subscription'] = 'user/Subscription/submit_subscription';

$route['notebook'] = 'notebook/Notebook';

$route['settings'] = 'settings/Setting';

$route['logout'] = 'dashboard/Dashboard/logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

<?php

defined('BASEPATH') or exit('No direct script access allowed');

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
|   example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|   http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|   $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|   $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|   $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|       my-controller/my-method -> my_controller/my_method
*/

$route['default_controller']   = 'clients';
$route['404_override']         = '';
$route['translate_uri_dashes'] = false;

/**
 * Dashboard clean route
 */
$route['admin'] = 'admin/dashboard';

/**
 * Misc controller routes
 */
$route['admin/access_denied'] = 'admin/misc/access_denied';
$route['admin/not_found']     = 'admin/misc/not_found';

/**
 * Staff Routes
 */
$route['admin/profile']           = 'admin/staff/profile';
$route['admin/profile/(:num)']    = 'admin/staff/profile/$1';
$route['admin/tasks/view/(:any)'] = 'admin/tasks/index/$1';

/**
 * Items search rewrite
 */
$route['admin/items/search'] = 'admin/invoice_items/search';

/**
 * In case if client access directly to url without the arguments redirect to clients url
 */
$route['/'] = 'clients';

/**
 * @deprecated
 */
$route['viewinvoice/(:num)/(:any)'] = 'invoice/index/$1/$2';

/**
 * @since 2.0.0
 */
$route['invoice/(:num)/(:any)'] = 'invoice/index/$1/$2';

/**
 * @deprecated
 */
$route['viewestimate/(:num)/(:any)'] = 'estimate/index/$1/$2';

/**
 * @since 2.0.0
 */
$route['estimate/(:num)/(:any)'] = 'estimate/index/$1/$2';
$route['subscription/(:any)']    = 'subscription/index/$1';

/**
 * @deprecated
 */
$route['viewproposal/(:num)/(:any)'] = 'proposal/index/$1/$2';

/**
 * @since 2.0.0
 */
$route['proposal/(:num)/(:any)'] = 'proposal/index/$1/$2';

/**
 * @since 2.0.0
 */
$route['contract/(:num)/(:any)'] = 'contract/index/$1/$2';

/**
 * @since 2.0.0
 */
$route['knowledge-base']                 = 'knowledge_base/index';
$route['knowledge-base/search']          = 'knowledge_base/search';
$route['knowledge-base/article']         = 'knowledge_base/index';
$route['knowledge-base/article/(:any)']  = 'knowledge_base/article/$1';
$route['knowledge-base/category']        = 'knowledge_base/index';
$route['knowledge-base/category/(:any)'] = 'knowledge_base/category/$1';

/**
 * @deprecated 2.2.0
 */
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'add_kb_answer') === false) {
    $route['knowledge-base/(:any)']         = 'knowledge_base/article/$1';
    $route['knowledge_base/(:any)']         = 'knowledge_base/article/$1';
    $route['clients/knowledge_base/(:any)'] = 'knowledge_base/article/$1';
    $route['clients/knowledge-base/(:any)'] = 'knowledge_base/article/$1';
}

/**
 * @deprecated 2.2.0
 * Fallback for auth clients area, changed in version 2.2.0
 */
$route['clients/reset_password']  = 'authentication/reset_password';
$route['clients/forgot_password'] = 'authentication/forgot_password';
$route['clients/logout']          = 'authentication/logout';
$route['clients/register']        = 'authentication/register';
$route['clients/login']           = 'authentication/login';

// Aliases for short routes
$route['reset_password']  = 'authentication/reset_password';
$route['forgot_password'] = 'authentication/forgot_password';
$route['login']           = 'authentication/login';
$route['logout']          = 'authentication/logout';
$route['register']        = 'authentication/register';

//API
$route['api/wallpaper']          = 'api/users/wallpaper';
$route['api/audioBooks']         = 'api/users/audioBook';

$route['api/signin']   = 'api/users/signin';
$route['api/matchOTP']   = 'api/users/matchOTP';
$route['api/instractionVideo']   = 'api/users/instractionVideo';
$route['api/recommandedApps']    = 'api/users/recommandedApps';
$route['api/quiz/(:any)/(:any)']        = 'api/users/quiz/$1/$2';
$route['api/assignment']        = 'api/users/assignment';
$route['api/mobileApp']         = 'api/users/mobileApp';
$route['api/immunity']          = 'api/users/immunity';
$route['api/happinesh']          = 'api/users/happinesh';
$route['api/listen/(:any)/(:any)']        = 'api/users/listen/$1/$2';
$route['api/practice/(:any)/(:any)']        = 'api/users/practice/$1/$2';
$route['api/categoryList']       = 'api/users/categoryList';
$route['api/subCategoryList/(:any)/(:any)']       = 'api/users/subCategoryList/$1/$2';

$route['api/phrases']       = 'api/users/phrases';
$route['api/subPhrases/(:any)']       = 'api/users/subPhrases/$1';

$route['api/addBookmark']   = 'api/users/addBookmark';
$route['api/removeBookmark/(:any)/(:any)']        = 'api/users/removeBookmark/$1/$2';
$route['api/bookmarkList/(:any)']        = 'api/users/bookmarkList/$1';

$route['api/saveRecord']   = 'api/users/saveRecord';
$route['api/recordList']   = 'api/users/recordList';

$route['api/subscriptions']   = 'api/users/subscriptions';

$route['api/languageList']   = 'api/users/languageList';
$route['api/setLanguage/(:any)']       = 'api/users/setLanguage/$1';
$route['api/translation/(:any)/(:any)/(:any)']        = 'api/users/translation/$1/$2/$3';

/**
 * Terms and conditions and Privacy Policy routes
 */
$route['terms-and-conditions'] = 'terms_and_conditions';
$route['privacy-policy']       = 'privacy_policy';

/**
 * @since 2.3.0
 * Routes for admin/modules URL because Modules.php class is used in application/third_party/MX
 */
$route['admin/modules']               = 'admin/mods';
$route['admin/modules/(:any)']        = 'admin/mods/$1';
$route['admin/modules/(:any)/(:any)'] = 'admin/mods/$1/$2';

// Public single ticket route
$route['forms/tickets/(:any)'] = 'forms/public_ticket/$1';

/**
*   @Pill Reminder Api
*/
$route['api/patientLogin']          = 'api/pillReminderApp/login';
$route['api/patientMatchOTP']          = 'api/pillReminderApp/matchOTP';
$route['api/myMedicien']          = 'api/pillReminderApp/myMedicien';
$route['api/todayMedicien']          = 'api/pillReminderApp/todayMedicien';
$route['api/content']          = 'api/pillReminderApp/content';
$route['api/tips']          = 'api/pillReminderApp/tips';
$route['api/updateDeviceId']          = 'api/pillReminderApp/updateDeviceId';
$route['api/updateMedStatus']          = 'api/pillReminderApp/updateMedStatus';
$route['api/takenStatus']          = 'api/pillReminderApp/takenStatus';



/**
reward setting routes
**/
$route['reward-list']           = 'admin/reward';
$route['reward-add']           = 'admin/reward/add';
$route['check-product']           = 'admin/reward/product';
$route['reward-value']           = 'admin/reward/value';
$route['reward-value/(:any)']           = 'admin/reward/value/$1';
$route['orders']           = 'admin/orders';
$route['stocks']           = 'admin/products/stocks';
$route['add-stocks']           = 'admin/products/addstock';
$route['distributor-stocks']           = 'admin/distributors/stock';
$route['dealer-stocks']           = 'admin/dealers/stock';
$route['distributor-view/(:any)']           = 'admin/distributors/view/$1';
$route['dealer-view/(:any)']           = 'admin/dealers/view/$1';
$route['plumber-view/(:any)']           = 'admin/plumbers/view/$1';
$route['users']           = 'admin/User';
$route['add-user']           = 'admin/User/add';
$route['add-user/(:any)']           = 'admin/User/add/$1';
$route['help-center']           = 'admin/Complain';

$route['distributor-list']   = 'admin/Distributors/list';
$route['distributor-order-report/(:any)']   = 'admin/Distributors/order_report/$1';
$route['distributor-reward-report/(:any)']   = 'admin/Distributors/reward_report/$1';
$route['dealer-list']           = 'admin/Dealers/list';
$route['dealer-order-report/(:any)']   = 'admin/Dealers/order_report/$1';
$route['dealer-reward-report/(:any)']   = 'admin/Dealers/reward_report/$1';
$route['plumber-list']           = 'admin/Plumbers/list';
$route['plumber-reward-report/(:any)']   = 'admin/Plumbers/reward_report/$1';

$route['greeting/(:any)/(:any)']   = 'admin/Dashboard/greeting/$1/$2';
$route['greeting-list']   = 'admin/Dashboard/greeting_list';

$route['redeem-reward']           = 'admin/RedeemReward';
$route['redeem-history']           = 'admin/RedeemReward/history';

$route['backup']           = 'admin/ExportDatabase';
$route['export']           = 'admin/ExportDatabase/export';
/**
 * @since  2.3.0
 * Route for clients set password URL, because it's using the same controller for staff to
 * If user addded block /admin by .htaccess this won't work, so we need to rewrite the URL
 * In future if there is implementation for clients set password, this route should be removed
 */
$route['authentication/set_password/(:num)/(:num)/(:any)'] = 'admin/authentication/set_password/$1/$2/$3';

if (file_exists(APPPATH . 'config/my_routes.php')) {
    include_once(APPPATH . 'config/my_routes.php');
}

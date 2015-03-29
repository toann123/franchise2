<?php
/**
 * @package FRANCHISE
 *
 * APPLICATION-WIDE CONFIGURATION SETTINGS
 *
 * This file contains application-wide configuration settings.  The settings
 * here will be the same regardless of the machine on which the app is running.
 *
 * This configuration should be added to version control.
 *
 * No settings should be added to this file that would need to be changed
 * on a per-machine basic (ie local, staging or production).  Any
 * machine-specific settings should be added to _machine_config.php
 */

/**
 * APPLICATION ROOT DIRECTORY
 * If the application doesn't detect this correctly then it can be set explicitly
 */
if (!GlobalConfig::$APP_ROOT) GlobalConfig::$APP_ROOT = realpath("./");

/**
 * check is needed to ensure asp_tags is not enabled
 */
if (ini_get('asp_tags')) 
	die('<h3>Server Configuration Problem: asp_tags is enabled, but is not compatible with Savant.</h3>'
	. '<p>You can disable asp_tags in .htaccess, php.ini or generate your app with another template engine such as Smarty.</p>');

/**
 * INCLUDE PATH
 * Adjust the include path as necessary so PHP can locate required libraries
 */
set_include_path(
		GlobalConfig::$APP_ROOT . '/libs/' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/../phreeze/libs' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/vendor/phreeze/phreeze/libs/' . PATH_SEPARATOR .
		get_include_path()
);

/**
 * COMPOSER AUTOLOADER
 * Uncomment if Composer is being used to manage dependencies
 */
// $loader = require 'vendor/autoload.php';
// $loader->setUseIncludePath(true);

/**
 * SESSION CLASSES
 * Any classes that will be stored in the session can be added here
 * and will be pre-loaded on every page
 */
require_once "Model/User.php";

/**
 * RENDER ENGINE
 * You can use any template system that implements
 * IRenderEngine for the view layer.  Phreeze provides pre-built
 * implementations for Smarty, Savant and plain PHP.
 */
require_once 'verysimple/Phreeze/SavantRenderEngine.php';
GlobalConfig::$TEMPLATE_ENGINE = 'SavantRenderEngine';
GlobalConfig::$TEMPLATE_PATH = GlobalConfig::$APP_ROOT . '/templates/';

/**
 * ROUTE MAP
 * The route map connects URLs to Controller+Method and additionally maps the
 * wildcards to a named parameter so that they are accessible inside the
 * Controller without having to parse the URL for parameters such as IDs
 */
GlobalConfig::$ROUTE_MAP = array(

	// default controller when no route specified
	'GET:' => array('route' => 'Default.Home'),
		
	// example authentication routes
	'GET:loginform' => array('route' => 'SecureExample.LoginForm'),
	'POST:login' => array('route' => 'SecureExample.Login'),
	'GET:secureuser' => array('route' => 'SecureExample.UserPage'),
	'GET:secureadmin' => array('route' => 'SecureExample.AdminPage'),
	'GET:logout' => array('route' => 'SecureExample.Logout'),

	// Role
	'GET:roles' => array('route' => 'Role.ListView'),
	'GET:role/(:num)' => array('route' => 'Role.SingleView', 'params' => array('id' => 1)),
	'GET:api/roles' => array('route' => 'Role.Query'),
	'POST:api/role' => array('route' => 'Role.Create'),
	'GET:api/role/(:num)' => array('route' => 'Role.Read', 'params' => array('id' => 2)),
	'PUT:api/role/(:num)' => array('route' => 'Role.Update', 'params' => array('id' => 2)),
	'DELETE:api/role/(:num)' => array('route' => 'Role.Delete', 'params' => array('id' => 2)),
		
	// Account
	'GET:accounts' => array('route' => 'Account.ListView'),
	'GET:account/(:num)' => array('route' => 'Account.SingleView', 'params' => array('id' => 1)),
	'GET:api/accounts' => array('route' => 'Account.Query'),
	'POST:api/account' => array('route' => 'Account.Create'),
	'GET:api/account/(:num)' => array('route' => 'Account.Read', 'params' => array('id' => 2)),
	'PUT:api/account/(:num)' => array('route' => 'Account.Update', 'params' => array('id' => 2)),
	'DELETE:api/account/(:num)' => array('route' => 'Account.Delete', 'params' => array('id' => 2)),
		
	// AccountMonth
	'GET:accountmonths' => array('route' => 'AccountMonth.ListView'),
	'GET:accountmonth/(:num)' => array('route' => 'AccountMonth.SingleView', 'params' => array('id' => 1)),
	'GET:api/accountmonths' => array('route' => 'AccountMonth.Query'),
	'POST:api/accountmonth' => array('route' => 'AccountMonth.Create'),
	'GET:api/accountmonth/(:num)' => array('route' => 'AccountMonth.Read', 'params' => array('id' => 2)),
	'PUT:api/accountmonth/(:num)' => array('route' => 'AccountMonth.Update', 'params' => array('id' => 2)),
	'DELETE:api/accountmonth/(:num)' => array('route' => 'AccountMonth.Delete', 'params' => array('id' => 2)),
		
	// AccountType
	'GET:accounttypes' => array('route' => 'AccountType.ListView'),
	'GET:accounttype/(:num)' => array('route' => 'AccountType.SingleView', 'params' => array('id' => 1)),
	'GET:api/accounttypes' => array('route' => 'AccountType.Query'),
	'POST:api/accounttype' => array('route' => 'AccountType.Create'),
	'GET:api/accounttype/(:num)' => array('route' => 'AccountType.Read', 'params' => array('id' => 2)),
	'PUT:api/accounttype/(:num)' => array('route' => 'AccountType.Update', 'params' => array('id' => 2)),
	'DELETE:api/accounttype/(:num)' => array('route' => 'AccountType.Delete', 'params' => array('id' => 2)),
		
	// BaseFee
	'GET:basefees' => array('route' => 'BaseFee.ListView'),
	'GET:basefee/(:num)' => array('route' => 'BaseFee.SingleView', 'params' => array('id' => 1)),
	'GET:api/basefees' => array('route' => 'BaseFee.Query'),
	'POST:api/basefee' => array('route' => 'BaseFee.Create'),
	'GET:api/basefee/(:num)' => array('route' => 'BaseFee.Read', 'params' => array('id' => 2)),
	'PUT:api/basefee/(:num)' => array('route' => 'BaseFee.Update', 'params' => array('id' => 2)),
	'DELETE:api/basefee/(:num)' => array('route' => 'BaseFee.Delete', 'params' => array('id' => 2)),
		
	// Company
	'GET:companies' => array('route' => 'Company.ListView'),
	'GET:company/(:num)' => array('route' => 'Company.SingleView', 'params' => array('id' => 1)),
	'GET:api/companies' => array('route' => 'Company.Query'),
	'POST:api/company' => array('route' => 'Company.Create'),
	'GET:api/company/(:num)' => array('route' => 'Company.Read', 'params' => array('id' => 2)),
	'PUT:api/company/(:num)' => array('route' => 'Company.Update', 'params' => array('id' => 2)),
	'DELETE:api/company/(:num)' => array('route' => 'Company.Delete', 'params' => array('id' => 2)),
		
	// Customer
	'GET:customers' => array('route' => 'Customer.ListView'),
	'GET:customer/(:num)' => array('route' => 'Customer.SingleView', 'params' => array('id' => 1)),
	'GET:api/customers' => array('route' => 'Customer.Query'),
	'POST:api/customer' => array('route' => 'Customer.Create'),
	'GET:api/customer/(:num)' => array('route' => 'Customer.Read', 'params' => array('id' => 2)),
	'PUT:api/customer/(:num)' => array('route' => 'Customer.Update', 'params' => array('id' => 2)),
	'DELETE:api/customer/(:num)' => array('route' => 'Customer.Delete', 'params' => array('id' => 2)),
		
	// Lead
	'GET:leads' => array('route' => 'Lead.ListView'),
	'GET:lead/(:num)' => array('route' => 'Lead.SingleView', 'params' => array('id' => 1)),
	'GET:api/leads' => array('route' => 'Lead.Query'),
	'POST:api/lead' => array('route' => 'Lead.Create'),
	'GET:api/lead/(:num)' => array('route' => 'Lead.Read', 'params' => array('id' => 2)),
	'PUT:api/lead/(:num)' => array('route' => 'Lead.Update', 'params' => array('id' => 2)),
	'DELETE:api/lead/(:num)' => array('route' => 'Lead.Delete', 'params' => array('id' => 2)),
	
	// add Lead
	'GET:addleads' => array('route' => 'Lead.AddListView'),
		
	// Post
	'GET:posts' => array('route' => 'Post.ListView'),
	'GET:post/(:any)' => array('route' => 'Post.SingleView', 'params' => array('id' => 1)),
	'GET:api/posts' => array('route' => 'Post.Query'),
	'POST:api/post' => array('route' => 'Post.Create'),
	'GET:api/post/(:any)' => array('route' => 'Post.Read', 'params' => array('id' => 2)),
	'PUT:api/post/(:any)' => array('route' => 'Post.Update', 'params' => array('id' => 2)),
	'DELETE:api/post/(:any)' => array('route' => 'Post.Delete', 'params' => array('id' => 2)),
		
	// Receive
	'GET:receives' => array('route' => 'Receive.ListView'),
	'GET:receive/(:any)' => array('route' => 'Receive.SingleView', 'params' => array('id' => 1)),
	'GET:api/receives' => array('route' => 'Receive.Query'),
	'POST:api/receive' => array('route' => 'Receive.Create'),
	'GET:api/receive/(:any)' => array('route' => 'Receive.Read', 'params' => array('id' => 2)),
	'PUT:api/receive/(:any)' => array('route' => 'Receive.Update', 'params' => array('id' => 2)),
	'DELETE:api/receive/(:any)' => array('route' => 'Receive.Delete', 'params' => array('id' => 2)),
		
	// Schedule
	'GET:schedules' => array('route' => 'Schedule.ListView'),
	'GET:schedule/(:num)' => array('route' => 'Schedule.SingleView', 'params' => array('id' => 1)),
	'GET:api/schedules' => array('route' => 'Schedule.Query'),
	'POST:api/schedule' => array('route' => 'Schedule.Create'),
	'GET:api/schedule/(:num)' => array('route' => 'Schedule.Read', 'params' => array('id' => 2)),
	'PUT:api/schedule/(:num)' => array('route' => 'Schedule.Update', 'params' => array('id' => 2)),
	'DELETE:api/schedule/(:num)' => array('route' => 'Schedule.Delete', 'params' => array('id' => 2)),
		
	// Service
	'GET:services' => array('route' => 'Service.ListView'),
	'GET:service/(:num)' => array('route' => 'Service.SingleView', 'params' => array('id' => 1)),
	'GET:api/services' => array('route' => 'Service.Query'),
	'POST:api/service' => array('route' => 'Service.Create'),
	'GET:api/service/(:num)' => array('route' => 'Service.Read', 'params' => array('id' => 2)),
	'PUT:api/service/(:num)' => array('route' => 'Service.Update', 'params' => array('id' => 2)),
	'DELETE:api/service/(:num)' => array('route' => 'Service.Delete', 'params' => array('id' => 2)),
		
	// State
	'GET:states' => array('route' => 'State.ListView'),
	'GET:state/(:any)' => array('route' => 'State.SingleView', 'params' => array('id' => 1)),
	'GET:api/states' => array('route' => 'State.Query'),
	'POST:api/state' => array('route' => 'State.Create'),
	'GET:api/state/(:any)' => array('route' => 'State.Read', 'params' => array('id' => 2)),
	'PUT:api/state/(:any)' => array('route' => 'State.Update', 'params' => array('id' => 2)),
	'DELETE:api/state/(:any)' => array('route' => 'State.Delete', 'params' => array('id' => 2)),
		
	// Support
	'GET:supports' => array('route' => 'Support.ListView'),
	'GET:support/(:num)' => array('route' => 'Support.SingleView', 'params' => array('id' => 1)),
	'GET:api/supports' => array('route' => 'Support.Query'),
	'POST:api/support' => array('route' => 'Support.Create'),
	'GET:api/support/(:num)' => array('route' => 'Support.Read', 'params' => array('id' => 2)),
	'PUT:api/support/(:num)' => array('route' => 'Support.Update', 'params' => array('id' => 2)),
	'DELETE:api/support/(:num)' => array('route' => 'Support.Delete', 'params' => array('id' => 2)),
		
	// User
	'GET:users' => array('route' => 'User.ListView'),
	'GET:user/(:num)' => array('route' => 'User.SingleView', 'params' => array('id' => 1)),
	'GET:api/users' => array('route' => 'User.Query'),
	'POST:api/user' => array('route' => 'User.Create'),
	'GET:api/user/(:num)' => array('route' => 'User.Read', 'params' => array('id' => 2)),
	'PUT:api/user/(:num)' => array('route' => 'User.Update', 'params' => array('id' => 2)),
	'DELETE:api/user/(:num)' => array('route' => 'User.Delete', 'params' => array('id' => 2)),
		
	// Work
	'GET:works' => array('route' => 'Work.ListView'),
	'GET:work/(:num)' => array('route' => 'Work.SingleView', 'params' => array('id' => 1)),
	'GET:api/works' => array('route' => 'Work.Query'),
	'POST:api/work' => array('route' => 'Work.Create'),
	'GET:api/work/(:num)' => array('route' => 'Work.Read', 'params' => array('id' => 2)),
	'PUT:api/work/(:num)' => array('route' => 'Work.Update', 'params' => array('id' => 2)),
	'DELETE:api/work/(:num)' => array('route' => 'Work.Delete', 'params' => array('id' => 2)),

	// catch any broken API urls
	'GET:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'PUT:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'POST:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'DELETE:api/(:any)' => array('route' => 'Default.ErrorApi404')
);

/**
 * FETCHING STRATEGY
 * You may uncomment any of the lines below to specify always eager fetching.
 * Alternatively, you can copy/paste to a specific page for one-time eager fetching
 * If you paste into a controller method, replace $G_PHREEZER with $this->Phreezer
 */
?>

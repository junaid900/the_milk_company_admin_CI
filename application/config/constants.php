<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
// STRINGS
defined('NEW_ORDER_IMAGE') OR define('NEW_ORDER_IMAGE', "uploads/system/purchase-order-request-form.jpeg");
defined('NEW_ORDER_TITLE')      OR define('NEW_ORDER_TITLE', "Your order submitted successfully");
defined('NEW_ORDER_MESSAGE')      OR define('NEW_ORDER_MESSAGE', "Your order submitted successfully please check order history");

defined('ADMIN_NEW_ORDER_TITLE')      OR define('ADMIN_NEW_ORDER_TITLE', "New order received");
defined('ADMIN_NEW_ORDER_MESSAGE')      OR define('ADMIN_NEW_ORDER_MESSAGE', "You have received new order please check order history");

defined('PAYMENT_REQUEST_ACCEPTED_TITLE')      OR define('PAYMENT_REQUEST_ACCEPTED_TITLE', "Payment request accepted.");
defined('PAYMENT_REQUEST_ACCEPTED')      OR define('PAYMENT_REQUEST_ACCEPTED', "Your payment request has been accepted.");
defined('PAYMENT_REQUEST_IMAGE') OR define('PAYMENT_REQUEST_IMAGE', "payment-request.png");


defined('ADD')        OR define('ADD', 1); //ADD
defined('REMOVE')        OR define('REMOVE', 0); // REMOVE




// TABLES
defined('PRODUCT_TABLE')      OR define('PRODUCT_TABLE', "milk_product");
defined('CATEGORY_TABLE')      OR define('CATEGORY_TABLE', "milk_category");
defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");
defined('PRODUCT_TIMING_TABLE')      OR define('PRODUCT_TIMING_TABLE', "milk_product_timing");
defined('ORDER_TABLE')      OR define('ORDER_TABLE', "milk_order");
defined('ORDER_PRODUCT_TABLE')      OR define('ORDER_PRODUCT_TABLE', "milk_order_product");


defined('USER_TABLE')      OR define('USER_TABLE', "milk_user");
defined('USER_ADDRESS_TABLE')      OR define('USER_ADDRESS_TABLE', "milk_user_address");

defined('WALLET_TABLE')      OR define('WALLET_TABLE', "milk_wallet");
defined('ROLE_TABLE')      OR define('ROLE_TABLE', "milk_role");
defined('CONSTRAINT_TABLE')      OR define('CONSTRAINT_TABLE', "milk_constraint");
defined('NOTIFICATION_TABLE')      OR define('NOTIFICATION_TABLE', "milk_notification");
defined('TRANSACTION_HISTORY_TABLE')      OR define('TRANSACTION_HISTORY_TABLE', "milk_transaction_history");
defined('ACCOUNT_TABLE')      OR define('ACCOUNT_TABLE', "milk_account");
defined('PAYMENT_REQUEST_TABLE')      OR define('PAYMENT_REQUEST_TABLE', "milk_payment_request");
defined('STORE_TABLE')      OR define('STORE_TABLE', "milk_store");
defined('ROLE_TABLE')      OR define('ROLE_TABLE', "milk_role");
// milk_recharge_request
defined('RECHARGE_REQUEST_TABLE')      OR define('RECHARGE_REQUEST_TABLE', "milk_recharge_request");
defined('APP_SETTING_TABLE')      OR define('APP_SETTING_TABLE', "milk_app_setting");
// defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");
// defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");
// defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");
// defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");
// defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");
// defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");
// defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");
// defined('BANNER_TABLE')      OR define('BANNER_TABLE', "milk_banner");


// ALIAS
defined('PRODUCT_ALS')      OR define('PRODUCT_ALS', "product");
defined('CATEGORY_ALS')      OR define('CATEGORY_ALS', "category");
defined('BANNER_ALS')      OR define('BANNER_ALS', "banner");
defined('CONSTRAINT_ALS')      OR define('CONSTRAINT_ALS', "constraint");
defined('PRODUCT_TIMING_ALS')      OR define('PRODUCT_TIMING_ALS', "product_timing");
defined('TRANSACTION_HISTORY_ALS')      OR define('TRANSACTION_HISTORY_ALS', "transaction_history");

defined('USER_ALS')      OR define('USER_ALS', "user");
defined('ROLE_ALS')      OR define('ROLE_ALS', "role");
defined('WALLET_ALS')      OR define('WALLET_ALS', "wallet");
defined('USER_ADDRESS_ALS')      OR define('USER_ADDRESS_ALS', "user_address");
defined('ORDER_ALS')      OR define('ORDER_ALS', "order");
defined('ORDER_PRODUCT_ALS')      OR define('ORDER_PRODUCT_ALS', "order_product");
defined('NOTIFICATION_ALS')      OR define('NOTIFICATION_ALS', "notification");
defined('ACCOUNT_ALS')      OR define('ACCOUNT_ALS', "account");
defined('PAYMENT_REQUEST_ALS')      OR define('PAYMENT_REQUEST_ALS', "payment_request");
defined('STORE_ALS')      OR define('STORE_ALS', "store");
defined('ROLE_ALS')      OR define('ROLE_ALS', "role");
defined('RECHARGE_REQUEST_ALS')      OR define('RECHARGE_REQUEST_ALS', "recharge_request");

defined('APP_SETTING_ALS')      OR define('APP_SETTING_ALS', "");




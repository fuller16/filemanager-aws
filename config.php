<?php

require_once __DIR__ . '/env.php';
fm_load_env(__DIR__ . '/.env');

$use_auth = false;

$app_url = env('APP_URL', 'https://onpoint.pinpoint.promo');

// Host allowed to embed filemanager in an iframe (referer check + auth bypass)
$allowed_referer_host = env('ALLOWED_REFERER_HOST', 'onpoint.pinpoint.promo');

// Brand logo shown on the login screen
$brand_logo_url = env('BRAND_LOGO_URL', 'https://onpoint.pinpoint.promo/crm/dist/img/orange-logo.png');

// Database connection (used by index.php auth).
// No defaults — credentials must be set in .env. Missing values are
// caught with a clear error in index.php before mysqli is constructed.
$db_host = env('DB_HOST');
$db_user = env('DB_USER');
$db_pass = env('DB_PASS');
$db_name = env('DB_NAME');
$db_port = env('DB_PORT');

// Attachments storage used by msg/eml converters
$attachments_path = env('ATTACHMENTS_PATH', '/var/www/html/filemanager/attachments');
$attachments_url = env('ATTACHMENTS_URL', 'http://filemanager.pinpoint.promo/attachments');

// Source roots used by converteps.php / convertpsd.php
$imagick_attachments_root = env('IMAGICK_ATTACHMENTS_ROOT', '/home/pinpointdev/Dropbox/filemanager/');
$imagick_public_root = env('IMAGICK_PUBLIC_ROOT', '/home/pinpointdev/Dropbox/onpoint.pinpoint/public');

$theme = 'light';
// Readonly users
// e.g. array('users', 'guest', ...)
$readonly_users = array(
    'user'
);

// Enable highlight.js (https://highlightjs.org/) on view's page
$use_highlightjs = true;

// highlight.js style
// for dark theme use 'ir-black'
$highlightjs_style = 'vs';

// Enable ace.js (https://ace.c9.io/) on view's page
$edit_files = true;

// Default timezone for date() and time()
// Doc - http://php.net/manual/en/timezones.php
$default_timezone = 'Etc/UTC'; // UTC

// Root path for file manager
// use absolute path of directory i.e: '/var/www/folder' or $_SERVER['DOCUMENT_ROOT'].'/folder'
// $root_path = $_SERVER['DOCUMENT_ROOT'];
$root_path = env('ROOT_PATH', '/var/www/html/staging-temp/public/order_files');
$msg_path = env('MSG_PATH', '/var/www/html/staging-temp/public/order_files/');
// Root url for links in file manager.Relative to $http_host. Variants: '', 'path/to/subfolder'
// Will not working if $root_path will be outside of server document root
$root_url = '';

// Server hostname. Can set manually if wrong
$http_host = $_SERVER['HTTP_HOST'];

// user specific directories
// array('Username' => 'Directory path', 'Username2' => 'Directory path', ...)
$directories_users = array();

// input encoding for iconv
$iconv_input_encoding = 'UTF-8';

// date() format for file modification date
// Doc - https://www.php.net/manual/en/function.date.php
$datetime_format = 'd.m.y H:i';

// Allowed file extensions for create and rename files
// e.g. 'txt,html,css,js'
$allowed_file_extensions = '';

// Allowed file extensions for upload files
// e.g. 'gif,png,jpg,html,txt'
$allowed_upload_extensions = '';

// Favicon path. This can be either a full url to an .PNG image, or a path based on the document root.
// full path, e.g http://example.com/favicon.png
// local path, e.g images/icons/favicon.png
$favicon_path = '?img=favicon';

// Files and folders to excluded from listing
// e.g. array('myfile.html', 'personal-folder', '*.php', ...)
$exclude_items = array();

// Online office Docs Viewer
// Availabe rules are 'google', 'microsoft' or false
// google => View documents using Google Docs Viewer
// microsoft => View documents using Microsoft Web Apps Viewer
// false => disable online doc viewer
$online_viewer = 'google';

// Sticky Nav bar
// true => enable sticky header
// false => disable sticky header
$sticky_navbar = true;


// max upload file size
$max_upload_size_bytes = 2048;

// Possible rules are 'OFF', 'AND' or 'OR'
// OFF => Don't check connection IP, defaults to OFF
// AND => Connection must be on the whitelist, and not on the blacklist
// OR => Connection must be on the whitelist, or not on the blacklist
$ip_ruleset = 'OFF';

// Should users be notified of their block?
$ip_silent = true;

// IP-addresses, both ipv4 and ipv6
$ip_whitelist = array(
    '127.0.0.1',    // local ipv4
    '::1'           // local ipv6
);

// IP-addresses, both ipv4 and ipv6
$ip_blacklist = array(
    '0.0.0.0',      // non-routable meta ipv4
    '::'            // non-routable meta ipv6
);

?>

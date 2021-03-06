<?php
global $wpdb;

// define paths
define ('DBD_BASE_PATH', dirname (__FILE__));
define ('DBD_BASE_WEB_PATH', plugin_dir_url ( __FILE__ ));

// define roles
define ('DBD_POST_TYPE_NAME', 'dbd_business');
define ('DBD_CATEGORY_TYPE_NAME', 'dbd_business_type');
define ('DBD_ROLE_NAME', 'dbd_member');
define ('DBD_ROLE_DISPLAY_NAME', 'Business Member'); // new member business user accounts will be given this role by default

// database tables - will use meta system so all of these can be removed later
define ('DBD_TABLE_LISTINGS', $wpdb->prefix . 'business_directory_listings');
define ('DBD_TABLE_USERS', $wpdb->prefix . 'users');
define ('DBD_TABLE_POSTS', $wpdb->prefix . 'posts');

// default settings
define ('DBD_DEFAULT_USER_PASSWORD', 'business'); // when adding a new company, this will be the initial password for the user account // TODO: Move to settings
define ('DBD_GOOGLE_MAPS_DEFAULT_ZOOM', 2);
define ('DBD_GOOGLE_MAPS_ADDRESSED_ZOOM', 16);
define ('DBD_GOOGLE_MAPS_DEFAULT_CENTER_LOCATION', 'United States');

// load support files
require_once (DBD_BASE_PATH . '/classes/dbd-utilities.php');
require_once (DBD_BASE_PATH . '/classes/dbd-plugin-manager.php');
require_once (DBD_BASE_PATH . '/classes/dbd-settings-manager.php');
require_once (DBD_BASE_PATH . '/classes/dbd-location-manager.php');
require_once (DBD_BASE_PATH . '/classes/dbd-contact-manager.php');
require_once (DBD_BASE_PATH . '/classes/dbd-shortcode-manager.php');
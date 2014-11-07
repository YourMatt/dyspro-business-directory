<?php
global $wpdb;

// define paths
define ('DBD_BASE_PATH', dirname (__FILE__));
define ('DBD_BASE_WEB_PATH', plugin_dir_url( __FILE__ ));

// define roles
define ('DBD_POST_TYPE_NAME', 'business');
define ('DBD_ROLE_NAME', 'dbd_member');
define ('DBD_ROLE_DISPLAY_NAME', 'Business Member'); // new member business user accounts will be given this role by default

// database tables - will use meta system so all of these can be removed later
define ('DBD_TABLE_LISTINGS', $wpdb->prefix . 'business_directory_listings');
define ('DBD_TABLE_USERS', $wpdb->prefix . 'users');
define ('DBD_TABLE_POSTS', $wpdb->prefix . 'posts');

// control options - TODO: Move all of these to configuration options
define ('DBD_FORCED_STATE', 'WY');
define ('DBD_DEFAULT_USER_PASSWORD', 'business'); // when adding a new company, this will be the initial password for the user account

define ('DBD_GOOGLE_MAPS_API_KEY', 'AIzaSyCRyolrfuh3vrUSB6q8phhBU2dT6JNhgYY');
define ('DBD_GOOGLE_MAPS_MAP_TYPE', 'ROADMAP'); // HYBRID, ROADMAP, SATELLITE, TERRAIN
define ('DBD_GOOGLE_MAPS_DEFAULT_ZOOM', 12);
define ('DBD_GOOGLE_MAPS_ADDRESSED_ZOOM', 16);
define ('DBD_GOOGLE_MAPS_DEFAULT_CENTER_LOCATION', 'Wheatland, WY, US');

// load support files
require_once (DBD_BASE_PATH . '/classes/dbd-location-manager.php');

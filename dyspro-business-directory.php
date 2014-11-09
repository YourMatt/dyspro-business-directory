<?php
/*
Plugin Name: Dyspro Business Directory
Plugin URI:
Description: Creates a new business content type and allows for linking to user profiles and adding specific business list fields.
Version: 0.9
Author: Dyspro Media
Author URI: http://dyspromedia.com
*/

// load configuration variables
require_once(dirname(__FILE__) . '/config.php');

// initialize objects
$dbd_plugin_manager = new dbd_plugin_manager ();
$dbd_location_manager = new dbd_location_manager ();
$dbd_contact_manager = new dbd_contact_manager ();
$dbd_settings_manager = new dbd_settings_manager ();

// add installation script
register_activation_hook (__FILE__, array ($dbd_plugin_manager, 'activate'));
register_deactivation_hook(__FILE__, array ($dbd_plugin_manager, 'deactivate'));
register_uninstall_hook (__FILE__, array ($dbd_plugin_manager, 'uninstall'));

// set up actions
add_action ('init', array ($dbd_plugin_manager, 'register_business_post_type'));
add_action ('add_meta_boxes', array ($dbd_location_manager, 'add_meta_boxes'));
add_action ('add_meta_boxes', array ($dbd_contact_manager, 'add_meta_boxes'));
add_action ('admin_menu', array ($dbd_settings_manager, 'register_admin_menu_pages'));

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

// add installation script
register_activation_hook (__FILE__, 'dbd_activate');
register_deactivation_hook(__FILE__, 'dbd_deactivate');
register_uninstall_hook (__FILE__, 'dbd_uninstall');

// run when activating the plugin
function dbd_activate () {

    // add the business member user role
    add_role('dbd_member', DBD_ROLE_DISPLAY_NAME, array (
        'edit_posts' => true,
        'edit_published_posts' => true,
        'read' => true,
        'upload_files' => true,
        'edit_dbd_post' => true,
        'read_dbd_post' => true,
        'delete_dbd_post' => true,
        'edit_dbd_posts' => true,
        'edit_others_dbd_posts' => true,
        'publish_dbd_posts' => true,
        'read_private_dbd_posts' => true
    ));

    // add roles to administrator
    $admin_role = get_role ('administrator');
    $admin_role->add_cap ('edit_dbd_post');
    $admin_role->add_cap ('read_dbd_post');
    $admin_role->add_cap ('delete_dbd_post');
    $admin_role->add_cap ('edit_dbd_posts');
    $admin_role->add_cap ('edit_others_dbd_posts');
    $admin_role->add_cap ('publish_dbd_posts');
    $admin_role->add_cap ('read_private_dbd_posts');

    // flush the rewrite rules
    flush_rewrite_rules ();

}

// run when deactivating the plugin
function dbd_deactivate () {

    // remove the business user role
    remove_role ('dbd_member');

    // remove custom roles from administrator
    $admin_role = get_role ('administrator');
    $admin_role->remove_cap ('edit_dbd_post');
    $admin_role->remove_cap ('read_dbd_post');
    $admin_role->remove_cap ('delete_dbd_post');
    $admin_role->remove_cap ('edit_dbd_posts');
    $admin_role->remove_cap ('edit_others_dbd_posts');
    $admin_role->remove_cap ('publish_dbd_posts');
    $admin_role->remove_cap ('read_private_dbd_posts');

}

// run when uninstalling the plugin
function dbd_uninstall () {

    // TODO: Validate that no additional cleanup is required and then fill in this method or delete as necessary

}



?>
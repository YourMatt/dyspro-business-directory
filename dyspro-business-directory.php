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

// initialize objects
$dbd_location_manager = new dbd_location_manager ();

// set up actions
add_action ('init', 'dbd_register_business_post_type');
add_action ('add_meta_boxes', array ($dbd_location_manager, 'add_meta_boxes'));

// run when activating the plugin
function dbd_activate () {

    // add the business member user role
    add_role(
        DBD_ROLE_NAME,
        DBD_ROLE_DISPLAY_NAME,
        array (
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

    // add roles to editor
    $editor_role = get_role ('editor');
    $editor_role->add_cap ('edit_dbd_post');
    $editor_role->add_cap ('read_dbd_post');
    $editor_role->add_cap ('delete_dbd_post');
    $editor_role->add_cap ('edit_dbd_posts');
    $editor_role->add_cap ('edit_others_dbd_posts');
    $editor_role->add_cap ('publish_dbd_posts');
    $editor_role->add_cap ('read_private_dbd_posts');

    // flush the rewrite rules
    flush_rewrite_rules ();

}

// run when deactivating the plugin
function dbd_deactivate () {

    // remove the business user role
    remove_role (DBD_ROLE_NAME);

    // remove custom roles from administrator
    $admin_role = get_role ('administrator');
    $admin_role->remove_cap ('edit_dbd_post');
    $admin_role->remove_cap ('read_dbd_post');
    $admin_role->remove_cap ('delete_dbd_post');
    $admin_role->remove_cap ('edit_dbd_posts');
    $admin_role->remove_cap ('edit_others_dbd_posts');
    $admin_role->remove_cap ('publish_dbd_posts');
    $admin_role->remove_cap ('read_private_dbd_posts');

    // remove custom roles from editor
    $editor_role = get_role ('editor');
    $editor_role->remove_cap ('edit_dbd_post');
    $editor_role->remove_cap ('read_dbd_post');
    $editor_role->remove_cap ('delete_dbd_post');
    $editor_role->remove_cap ('edit_dbd_posts');
    $editor_role->remove_cap ('edit_others_dbd_posts');
    $editor_role->remove_cap ('publish_dbd_posts');
    $editor_role->remove_cap ('read_private_dbd_posts');

}

// run when uninstalling the plugin
function dbd_uninstall () {

    // TODO: Validate that no additional cleanup is required and then fill in this method or delete as necessary

}

// add the business post type - this is loaded on init
function dbd_register_business_post_type () {

    register_post_type (
        DBD_POST_TYPE_NAME,
        array(
            'labels' => array (
                'name' => 'Directory Listings',
                'singular_name' => 'Directory Listing',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Directory Listing',
                'edit_item' => 'Edit Directory Listing'
            ),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'capability_type' => DBD_ROLE_NAME,
            'rewrite' => array(
                'slug'=> 'directory',
                'with_front'=> false,
                'feeds'=> true,
                'pages'=> true
            ),
            'capabilities' => array (
                'edit_post' => 'edit_dbd_post',
                'read_post' => 'read_dbd_post',
                'delete_post' => 'delete_dbd_post',
                'edit_posts' => 'edit_dbd_posts',
                'edit_others_posts' => 'edit_others_dbd_posts',
                'publish_posts' => 'publish_dbd_posts',
                'read_private_posts' => 'read_private_dbd_posts'
            ),
            'has_archive' => false,
            'hierarchical' => true,
            'menu_icon' => 'dashicons-id',
            'menu_position' => 20,
            'supports' => array(
                'thumbnail',
                'title',
                'editor'
            )
        )
    );

}

?>
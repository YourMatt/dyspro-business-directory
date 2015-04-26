<?

class dbd_plugin_manager {

    // holds objects for querying post meta data
    private $location_manager, $contact_manager;

    // initialize query objects
    public function __construct () {

        $this->location_manager = new dbd_location_manager ();
        $this->contact_manager = new dbd_contact_manager ();

    }

    // run when activating the plugin
    function activate () {

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
            )
        );

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
    function deactivate () {

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
    function uninstall () {

        // TODO: Validate that no additional cleanup is required and then fill in this method or delete as necessary

    }

    // create the taxonomy for categorization of businesses - this is loaded on init
    function register_business_taxonomy () {

        $taxonomy_labels = array (
            'name' => 'Business Types',
            'singular_name' => 'Business Type',
            'search_items' => 'Search Business Types',
            'all_items' => 'All Business Types',
            'edit_item' => 'Edit Business Type',
            'update_item' => 'Update Business Type',
            'add_new_item' => 'Add Business Type',
            'new_item_name' => 'New Business Type',
            'menu_name' => 'Business Type'
        );

        $taxonomy_options = array (
            'hierarchical' => true,
            'labels' => $taxonomy_labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_tagcloud' => false
        );

        register_taxonomy (DBD_CATEGORY_TYPE_NAME, DBD_POST_TYPE_NAME, $taxonomy_options);

    }

    // add the business post type - this is loaded on init
    function register_business_post_type () {

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
                ),
                'taxonomies' => array (DBD_CATEGORY_TYPE_NAME)
            )
        );

        // add columns to the edit form for this new post type
        add_filter (
            'manage_edit-' . DBD_POST_TYPE_NAME . '_columns',
            array ($this, 'set_custom_post_columns')
        );
        add_filter (
            'manage_edit-' . DBD_POST_TYPE_NAME . '_sortable_columns',
            array ($this, 'set_sortable_post_columns')
        );
        add_filter (
            'request',
            array ($this, 'sort_column')
        );
        add_action (
            'manage_' . DBD_POST_TYPE_NAME . '_posts_custom_column',
            array ($this, 'custom_post_column'),
            10,
            2
        );

    }

    function set_custom_post_columns ($columns) {

        $new_columns = array ();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = $columns['title'];
        $new_columns['contact'] = 'Contact Info';
        $new_columns['address'] = 'Address';
        $new_columns['types'] = 'Business Type';
        $new_columns['status'] = 'Membership Status';
        $new_columns['date'] = $columns['date'];

        return $new_columns;

    }

    function set_sortable_post_columns ($columns) {

        return array (
            'title' => 'title',
            'contact' => 'dbd_contact',
            'address' => 'dbd_address',
            //'types' => 'dbd_types', // TODO: Add sort for taxonomy categories
            //'status' => 'dbd_status', // TODO: Add sort for status
            'date' => 'date'
        );

    }

    function sort_column ($request) {

        if (! $request['orderby']) return $request;

        switch ($request['orderby']) {

            case 'dbd_contact':
                $request = array_merge ($request, array (
                    'meta_key' => '_dbd_name',
                    'orderby' => 'meta_value'
                ));
                break;
            case 'dbd_address':
                $request = array_merge ($request, array (
                    'meta_key' => '_dbd_address1',
                    'orderby' => 'meta_value'
                ));
                break;

        }

        return $request;

    }

    function custom_post_column ($column, $post_id) {

        switch ($column) {
            case 'contact':
                print $this->contact_manager->get_formatted_contact_info ($post_id);
                break;
            case 'address':
                print $this->location_manager->get_formatted_address ($post_id);
                break;
            case 'types':
                print $this->get_business_types ($post_id);
                break;
            case 'status':
                // TODO: Print membership status information
                break;
        }

    }

    function get_business_types ($post_id) {

        $post_terms = wp_get_post_terms ($post_id, DBD_CATEGORY_TYPE_NAME);
        $types = array ();
        foreach ($post_terms as $post_term) {
            $types[] = $post_term->name;
        }

        return implode (", ", $types);

    }

}
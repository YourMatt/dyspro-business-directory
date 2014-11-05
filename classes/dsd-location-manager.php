<?

class dsd_location_manager {

    public function __construct () {

    }

    // Administration forms
    function add_meta_boxes () {

        // add scripts and styles for the meta boxes
        wp_enqueue_script ('dbd_location_js', DBD_BASE_WEB_PATH . 'content/js/meta-location.js', array ('jquery'));
        wp_enqueue_style ('dbd_location_css', DBD_BASE_WEB_PATH . 'content/css/meta.css');

        // create the location meta box
        add_meta_box (
            'location',
            'Location',
            array ($this, 'build_location_meta_form'),
            DBD_POST_TYPE_NAME
        );

        // create the membership information meta box
        // TODO: add call to create the membership box

        // add save callbacks
        add_action ('save_post', array ($this, 'save_location_meta_form'));

    }

    function build_location_meta_form ($post) {

        // create the nonce
        wp_nonce_field ('dbd_loc', 'dbd_loc_nonce');

        // load current values
        $loc_data = get_post_meta ($post->ID, '_dsd_loc', true);

        // add the form contents
        include (DBD_BASE_PATH . "/content/meta-location.php");

    }

    function save_location_meta_form ($post_id) {

        // verify the nonce
        if (! wp_verify_nonce ($_POST["dbd_loc_nonce"], __FILE__)) return $post_id;

        // verify the user
        if (! current_user_can ('edit_dbd_post', $post_id)) return $post_id;

        // save the location data
        /* // sample code below - use this as boilerplate for actual save
        $current_data = get_post_meta($post_id, '_my_meta', TRUE);
        $new_data = $_POST['_my_meta'];
        my_meta_clean($new_data);
        if ($current_data)
        {
            if (is_null($new_data)) delete_post_meta($post_id,'_my_meta');
            else update_post_meta($post_id,'_my_meta',$new_data);
        }
        elseif (!is_null($new_data))
        {
            add_post_meta($post_id,'_my_meta',$new_data,TRUE);
        }
        */

        return $post_id;

    }

}

<?

class dbd_location_manager {

    private $nonce_action = 'dbd_loc';

    public function __construct () {

        // add save callbacks
        add_action ('save_post', array ($this, 'save_location_meta_form'));

    }

    // Administration forms
    function add_meta_boxes () {

        // add scripts and styles for the meta boxes
        wp_enqueue_script ('dbd_location_js', DBD_BASE_WEB_PATH . 'content/js/meta-location.js', array ('jquery'));
        wp_enqueue_script ('dbd_location_maps_js', 'https://maps.googleapis.com/maps/api/js?key=' . get_option ('dbd_google_maps_api_key'));
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

    }

    function build_location_meta_form ($post) {

        // create the nonce
        wp_nonce_field ($this->nonce_action, 'dbd_loc_nonce');

        // load current values
        $loc_data = get_metadata ('post', $post->ID);
        $forced_state = get_option ('dbd_forced_state_name');
        if ($forced_state) $loc_data['_dbd_state'][0] = $forced_state;

        // load default map options
        $map_type = get_option ('dbd_google_maps_type');
        $map_default_location = get_option ('dbd_default_location');
        $map_default_zoom = get_option ('dbd_google_maps_default_zoom');
        $map_addressed_zoom = get_option ('dbd_google_maps_addressed_zoom');

        // add the form contents
        include (DBD_BASE_PATH . "/content/meta-location.php");

    }

    function save_location_meta_form ($post_id) {

        // verify the nonce
        if (! wp_verify_nonce ($_POST['dbd_loc_nonce'], $this->nonce_action)) return $post_id;

        // verify the user
        if (! current_user_can ('edit_dbd_post', $post_id)) return $post_id;

        // save the location data to meta fields
        $this->save_location_meta_field ($post_id, 'loc_address1', '_dbd_address1');
        $this->save_location_meta_field ($post_id, 'loc_address2', '_dbd_address2');
        $this->save_location_meta_field ($post_id, 'loc_city', '_dbd_city');
        $this->save_location_meta_field ($post_id, 'loc_state', '_dbd_state');
        $this->save_location_meta_field ($post_id, 'loc_postalcode', '_dbd_postalcode');
        $this->save_location_meta_field ($post_id, 'loc_lat', '_dbd_lat');
        $this->save_location_meta_field ($post_id, 'loc_lng', '_dbd_lng');

        return $post_id;

    }

    function save_location_meta_field ($post_id, $field_name, $meta_name) {

        $current_value = get_post_meta ($post_id, $meta_name, true);
        $new_value = $_POST[$field_name];

        if ($current_value) {
            if (! $new_value) delete_post_meta ($post_id, $meta_name);
            else update_post_meta ($post_id, $meta_name, $new_value);
        }
        elseif ($new_value) {
            add_post_meta ($post_id, $meta_name, $new_value, true);
        }

    }

    function get_formatted_address ($post_id) {

        $loc_data = get_metadata ('post', $post_id);

        // set up the address lines
        $line1 = $loc_data['_dbd_address1'][0];
        $line2 = $loc_data['_dbd_address2'][0];
        $line3 = $loc_data['_dbd_city'][0];
        if ($line3) $line3 .= ', ';
        $line3 .= $loc_data['_dbd_state'][0];
        if ($loc_data['_dbd_postalcode']) $line3 .= ' ' . $loc_data['_dbd_postalcode'][0];

        // build the address
        $address = [];
        if ($line1) $address[] = $line1;
        if ($line2) $address[] = $line2;
        if ($line3) $address[] = $line3;

        return implode ('<br/>', $address);
        
    }

}

<?

class dbd_contact_manager {

    private $nonce_action = 'dbd_contact';

    public function __construct () {

        // add save callbacks
        add_action ('save_post', array ($this, 'save_contact_meta_form'));

    }

    // Administration forms
    function add_meta_boxes () {

        // add scripts and styles for the meta boxes
        wp_enqueue_style ('dbd_contact_css', DBD_BASE_WEB_PATH . 'content/css/meta.css');

        // create the location meta box
        add_meta_box (
            'contact',
            'Contact Information',
            array ($this, 'build_contact_meta_form'),
            DBD_POST_TYPE_NAME
        );

    }

    function build_contact_meta_form ($post) {

        // create the nonce
        wp_nonce_field ($this->nonce_action, 'dbd_contact_nonce');

        // load current values
        $contact_data = get_metadata ('post', $post->ID);

        // add the form contents
        include (DBD_BASE_PATH . "/content/meta-contact.php");

    }

    function save_contact_meta_form ($post_id) {

        // verify the nonce
        if (! wp_verify_nonce ($_POST['dbd_contact_nonce'], $this->nonce_action)) return $post_id;

        // verify the user
        if (! current_user_can ('edit_dbd_post', $post_id)) return $post_id;

        // save the contact data to meta fields
        dbd_utilities::save_meta_field ($post_id, 'contact_name', '_dbd_name');
        dbd_utilities::save_meta_field ($post_id, 'contact_phone', '_dbd_phone');
        dbd_utilities::save_meta_field ($post_id, 'contact_email', '_dbd_email');
        dbd_utilities::save_meta_field ($post_id, 'contact_website', '_dbd_website');
        dbd_utilities::save_meta_field ($post_id, 'contact_facebook', '_dbd_facebook');

        return $post_id;

    }

    function get_formatted_contact_info ($post_id) {

        $contact_data = get_metadata ('post', $post_id);

        // show the name on the first line or show that no name was provided
        $name = $contact_data['_dbd_name'][0];
        $name || $name = 'No Name Set';

        // show which fields are set on the 2nd line
        $options_set = [];
        if ($contact_data['_dbd_phone'][0]) $options_set[] = '<span class="dashicons-before dashicons-format-chat" title="' . esc_attr ($contact_data['_dbd_phone'][0]) . '"></span>';
        if ($contact_data['_dbd_email'][0]) $options_set[] = '<span class="dashicons-before dashicons-email" title="' . esc_attr ($contact_data['_dbd_email'][0]) . '"></span>';
        if ($contact_data['_dbd_website'][0]) $options_set[] = '<span class="dashicons-before dashicons-admin-site" title="' . esc_attr ($contact_data['_dbd_website'][0]) . '"></span>';
        if ($contact_data['_dbd_facebook'][0]) $options_set[] = '<span class="dashicons-before dashicons-facebook" title="' . esc_attr ($contact_data['_dbd_facebook'][0]) . '"></span>';

        $options = 'No contact fields set.';
        if ($options_set) {
            $options = implode (' ', $options_set);
        }

        return $name . '<br/>' . $options;

    }

}

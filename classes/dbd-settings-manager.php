<?

class dbd_settings_manager {

    public function __construct () {}

    // adds pages to the plugin admin menu
    public function register_admin_menu_pages () {

        add_options_page (
            'Directory Listings Settings',
            'Directory Listings',
            'manage_options',
            'dbd_settings_page',
            array ($this, 'build_settings_page')
        );

    }

    public function build_settings_page () {

        // check user access
        if (! current_user_can ('manage_options')) {
            wp_die( __('You do not have sufficient permissions to access this page.'));
        }

        // save current values if the form was submitted
        $settings_saved = $this->save_settings ();

        // load selection options
        $map_types = $this->get_map_types ();
        $map_zoom_levels = $this->get_map_zoom_levels ();
        $states = $this->get_states ();

        // load current values
        $setting_google_maps_type = get_option ('dbd_google_maps_type');
        $setting_google_maps_api_key = get_option ('dbd_google_maps_api_key');
        $setting_forced_state_name = get_option ('dbd_forced_state_name');
        $setting_default_location = get_option ('dbd_default_location');
        $setting_google_maps_default_zoom = get_option ('dbd_google_maps_default_zoom');
        $setting_google_maps_addressed_zoom = get_option ('dbd_google_maps_addressed_zoom');

        // set defaults where no value exists
        $setting_google_maps_type || $setting_google_maps_type = 'ROADMAP';
        $setting_default_location || $setting_default_location = DBD_GOOGLE_MAPS_DEFAULT_CENTER_LOCATION;
        $setting_google_maps_default_zoom || $setting_google_maps_default_zoom = DBD_GOOGLE_MAPS_DEFAULT_ZOOM;
        $setting_google_maps_addressed_zoom || $setting_google_maps_addressed_zoom = DBD_GOOGLE_MAPS_ADDRESSED_ZOOM;

        // add the page contents
        include (DBD_BASE_PATH . '/content/settings.php');

    }

    private function save_settings () {

        if (! $_POST['submit']) return false;

        update_option ('dbd_google_maps_type', $_POST['settings_google_maps_type']);
        update_option ('dbd_google_maps_api_key', $_POST['settings_google_maps_api_key']);
        update_option ('dbd_forced_state_name', ($_POST['settings_force_state']) ? $_POST['settings_force_state_name'] : '');
        update_option ('dbd_default_location', $_POST['settings_default_location']);
        update_option ('dbd_google_maps_default_zoom', $_POST['settings_google_maps_default_zoom']);
        update_option ('dbd_google_maps_addressed_zoom', $_POST['settings_google_maps_addressed_zoom']);

        return true;

    }

    private function get_map_zoom_levels () {

        $zoom_levels = array ();
        for ($i = 1; $i <= 20; $i++) {
            $zoom_levels[] = $i;
        }

        return $zoom_levels;

    }

    private function get_map_types () {

        return array (
            'ROADMAP' => 'Road Map',
            'SATELLITE' => 'Satellite',
            'HYBRID' => 'Hybrid',
            'TERRAIN' => 'Terrain'
        );

    }
    
    private function get_states () {

        return array (
            'AL' => "Alabama",
            'AK' => "Alaska",
            'AZ' => "Arizona",
            'AR' => "Arkansas",
            'CA' => "California",
            'CO' => "Colorado",
            'CT' => "Connecticut",
            'DE' => "Delaware",
            'DC' => "District Of Columbia",
            'FL' => "Florida",
            'GA' => "Georgia",
            'HI' => "Hawaii",
            'ID' => "Idaho",
            'IL' => "Illinois",
            'IN' => "Indiana",
            'IA' => "Iowa",
            'KS' => "Kansas",
            'KY' => "Kentucky",
            'LA' => "Louisiana",
            'ME' => "Maine",
            'MD' => "Maryland",
            'MA' => "Massachusetts",
            'MI' => "Michigan",
            'MN' => "Minnesota",
            'MS' => "Mississippi",
            'MO' => "Missouri",
            'MT' => "Montana",
            'NE' => "Nebraska",
            'NV' => "Nevada",
            'NH' => "New Hampshire",
            'NJ' => "New Jersey",
            'NM' => "New Mexico",
            'NY' => "New York",
            'NC' => "North Carolina",
            'ND' => "North Dakota",
            'OH' => "Ohio",
            'OK' => "Oklahoma",
            'OR' => "Oregon",
            'PA' => "Pennsylvania",
            'RI' => "Rhode Island",
            'SC' => "South Carolina",
            'SD' => "South Dakota",
            'TN' => "Tennessee",
            'TX' => "Texas",
            'UT' => "Utah",
            'VT' => "Vermont",
            'VA' => "Virginia",
            'WA' => "Washington",
            'WV' => "West Virginia",
            'WI' => "Wisconsin",
            'WY' => "Wyoming"
        );


    }

}

<?

class dsd_location_manager {

    public function __construct () {

    }

    // Administration forms
    function add_meta_boxes () {
        add_meta_box (
            'location',
            'Location',
            array ($this, 'build_location_meta_form'),
            DBD_POST_TYPE_NAME
        );
    }

    function build_location_meta_form ($post) {

        print "<h1>So far, so good.</h1>";

    }

}

<?

class dbd_shortcode_manager {

    public function build_directory_list () {

        return "business list";

    }

    public function build_category_list () {

        $categories = get_terms (DBD_CATEGORY_TYPE_NAME);

        return "category list";

    }

}
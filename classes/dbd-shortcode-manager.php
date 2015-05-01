<?

class dbd_shortcode_manager {

    public function build_directory_list () {

        $business_list = '';

        // load all categories
        $categories = get_terms (DBD_CATEGORY_TYPE_NAME);

        foreach ($categories as $category) {

            if ($_REQUEST['type'] && $_REQUEST['type'] != $category->slug) continue;

            $business_list .= '<h2>' . $category->name . '</h2>';
            $business_list .= '<ul class="businesses">';

            $businesses = get_posts (array (
                'post_type' => DBD_POST_TYPE_NAME,
                'posts_per_page' => -1, // always return all
                'order_by' => 'post_title',
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => DBD_CATEGORY_TYPE_NAME,
                        'field' => 'term_id',
                        'terms' => $category->term_id
                    )
                )
            ));

            foreach ($businesses as $business) {

                $business_meta = get_post_meta ($business->ID);
                $business_thumb = get_the_post_thumbnail ($business->ID, "full");
                $link = '/directory/' . $business->post_name;

                $business_list .= '<li>';
                if ($business_thumb) {
                    $business_list .= '<div class="logo"><a href="' . $link . '">' . $business_thumb . '</a></div>';
                }
                $business_list .= '<h3 class="title">' . $business->post_title . '</h3>';
                $business_list .= '<div class="address">' . dbd_utilities::get_formatted_address ($business_meta) . '</div>';
                $business_list .= '<div class="phone">' . $business_meta["_dbd_phone"][0] . '</div>';
                $business_list .= '<a class="details-link" href="' . $link . '"><span>Details</span></a>';
                $business_list .= '</li>';

            }

            $business_list .= '</ul>';

        }

        return $business_list;

    }

    public function build_category_list () {

        $categories = get_terms (DBD_CATEGORY_TYPE_NAME);

        $category_list = '<ul>';
        $category_list .= '<li><a href="' . get_permalink () . '"><span class="indicator"></span>All Business Types</a></li>';
        foreach ($categories as $category) {
            $category_list .= '<li><a href="?type=' . $category->slug . '"><span class="indicator"></span>' . $category->name . '</a></li>';
        }
        $category_list .= '</ul>';

        return $category_list;

    }

}
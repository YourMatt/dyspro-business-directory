<?

class dbd_utilities {

    public static function save_meta_field ($post_id, $field_name, $meta_name) {

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

    public static function get_formatted_address ($post_meta) {

        $address = $post_meta['_dbd_address1'][0];
        if ($post_meta['_dbd_address2']) $address .= '; ' . $post_meta['_dbd_address2'][0];
        $address .= '<br/>';

        $address .= $post_meta['_dbd_city'][0] . ', ' . $post_meta['_dbd_state'][0] . ' ' . $post_meta['_dbd_postalcode'][0];

        return $address;

    }

}
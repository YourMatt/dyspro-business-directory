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

}
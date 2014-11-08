<div class="dbd-meta-location">

    <table>
    <tr><td class="col1">
        <label for="loc_address1">Address 1</label>
    </td><td class="col2">
        <input type="text" name="loc_address1" maxlength="30" value="<?= esc_attr ($loc_data["_dbd_address1"][0]) ?>"/>
    </td><td rowspan="6" class="col3">
        <div id="dbd-meta-location-map"></div>
    </td></tr>
    <tr><td>
        <label for="loc_address2">Address 2</label>
    </td><td>
        <input type="text" name="loc_address2" maxlength="30" value="<?= esc_attr ($loc_data["_dbd_address2"][0]) ?>"/>
    </td></tr>
    <tr><td>
        <label for="loc_city">City</label>
    </td><td>
        <input type="text" name="loc_city" maxlength="30" value="<?= esc_attr ($loc_data["_dbd_city"][0]) ?>"/>
    </td></tr>
    <tr><td>
    <?  if ($forced_state) { ?>
        <input type="hidden" name="loc_state" value="<?= esc_attr ($loc_data["_dbd_state"][0]) ?>"/>
    <?  } else { ?>
        <label for="loc_state">State</label>
    </td><td>
        <input type="text" name="loc_state" maxlength="2" value="<?= esc_attr ($loc_data["_dbd_state"][0]) ?>"/>
    </td></tr>
    <tr><td>
    <?  } ?>
        <label for="loc_postalcode">Zip Code</label>
    </td><td>
        <input type="text" name="loc_postalcode" maxlength="15" value="<?= esc_attr ($loc_data["_dbd_postalcode"][0]) ?>"/>
    </td></tr>
    <tr><td colspan="2" class="dbd-coords">
        Coords:
        <span id="dbd-meta-location-lat"><?= $loc_data["_dbd_lat"][0] ?></span>,
        <span id="dbd-meta-location-lng"><?= $loc_data["_dbd_lng"][0] ?></span>
        <input type="hidden" name="loc_lat" value="<?= esc_attr ($loc_data["_dbd_lat"][0]) ?>"/>
        <input type="hidden" name="loc_lng" value="<?= esc_attr ($loc_data["_dbd_lng"][0]) ?>"/>
    </td></tr>
    </table>

    <input type="hidden" name="loc_map_default_center_location" value="<?= $map_default_location ?>"/>
    <input type="hidden" name="loc_map_default_zoom" value="<?= $map_default_zoom ?>"/>
    <input type="hidden" name="loc_map_addressed_zoom" value="<?= $map_addressed_zoom ?>"/>
    <input type="hidden" name="loc_map_type" value="<?= $map_type ?>"/>

</div>
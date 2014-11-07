<div class="dbd-meta-location">

    <table>
    <tr><td class="col1">
        <label for="loc_address1">Address 1</label>
    </td><td class="col2">
        <input type="text" name="loc_address1" maxlength="30"/>
    </td><td rowspan="6" class="col3">
        <div id="dbd-meta-location-map"></div>
    </td></tr>
    <tr><td>
        <label for="loc_address2">Address 2</label>
    </td><td>
        <input type="text" name="loc_address2" maxlength="30"/>
    </td></tr>
    <tr><td>
        <label for="loc_city">City</label>
    </td><td>
        <input type="text" name="loc_city" maxlength="30"/>
    </td></tr>
    <tr><td>
    <?  if (DBD_FORCED_STATE) { ?>
        <input type='hidden' name='loc_state' value='<?= DBD_FORCED_STATE ?>'/>
    <?  } else { ?>
        <label for="loc_state">State</label>
    </td><td>
        <input type="text" name="loc_state" maxlength="2"/>
    </td></tr>
    <tr><td>
    <?  } ?>
        <label for="loc_postalcode">Zip Code</label>
    </td><td>
        <input type="text" name="loc_postalcode" maxlength="15"/>
    </td></tr>
    <tr><td colspan="2" class="dbd-coords">
        Coords: <span id="dbd-meta-location-lat"></span>, <span id="dbd-meta-location-lng"></span>
        <input type="hidden" name="loc_lat"/>
        <input type="hidden" name="loc_lng"/>
    </td></tr>
    </table>

    <input type="hidden" name="loc_map_default_center_location" value="<?= DBD_GOOGLE_MAPS_DEFAULT_CENTER_LOCATION ?>"/>
    <input type="hidden" name="loc_map_default_zoom" value="<?= DBD_GOOGLE_MAPS_DEFAULT_ZOOM ?>"/>
    <input type="hidden" name="loc_map_type" value="<?= DBD_GOOGLE_MAPS_MAP_TYPE ?>"/>

</div>
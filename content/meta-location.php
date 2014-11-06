<div class="dbd-meta-location">

    <table>
    <tr><td class="col1">
        <label for="loc_address1">Address 1</label>
    </td><td class="col2">
        <input type="text" name="loc_address1" maxlength="30"/>
    </td><td rowspan="5" class="col3">
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
    </table>

</div>
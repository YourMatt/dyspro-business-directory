
<? if ($settings_saved) { ?><div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div><? } ?>

<div class="wrap">

    <h2>Directory Listings Settings</h2>
    <p>The following options support the Dyspro Business Directory plugin and includes default behavior and expectations.</p>

    <form method="post">

        <h3>Mapping Options</h3>
        <table class="form-table">
        <tr><th scope="row">
            Google Maps
        </th><td>
            <p>Options for mapping your directory listings.</p>
            <fieldset>
                <legend class="screen-reader-text">Google Maps</legend>
                <ul>
                    <li>
                        <label for="settings_google_maps_type">
                            Map Type:
                            <select name="settings_google_maps_type">
                                <? foreach ($map_types as $map_type_code => $map_type_name) {
                                    $selected = ($map_type_code == $setting_google_maps_type) ? " selected" : ""; ?>
                                <option value="<?= $map_type_code ?>"<?= $selected ?>><?= $map_type_name ?></option>
                                <? } ?>
                            </select>
                        </label>
                    </li>
                    <li>
                        <label for="settings_google_maps_api_key">
                            API Key:
                            <input type="text" name="settings_google_maps_api_key" maxlength="39" value="<?= esc_attr ($setting_google_maps_api_key) ?>"/>
                            <p class="description">Required for displaying map results.  The API key can be requested from
                                <a href="https://code.google.com/apis/console/" target="_new">https://code.google.com/apis/console/</a>.</p>
                        </label>
                    </li>
                </ul>
            </fieldset>
        </td></tr>
        <tr><th scope="row">
            Location Selection Options
        </th><td>
            <p>Sets default behavior when adding and updating the location for a directory listing.</p>
            <fieldset>
                <legend class="screen-reader-text">Location Selection Options</legend>
                <ul>
                    <li>
                        <label for="settings_force_state">
                            <? $checked = ($setting_forced_state_name) ? " checked" : ""; ?>
                            <input type="checkbox" name="settings_force_state" value="1"<?= $checked ?>/>
                            Force all addresses to be within state:
                            <select name="settings_force_state_name">
                                <option value=""></option>
                                <? foreach ($states as $state_abbreviation => $state_name) {
                                    $selected = ($state_abbreviation == $setting_forced_state_name) ? " selected" : ""; ?>
                                <option value="<?= $state_abbreviation ?>"<?= $selected ?>><?= $state_name ?></option>
                                <? } ?>
                            </select>
                        </label>
                    </li>
                    <li>
                        <label for="settings_default_location">
                            Default Location:
                            <input type="text" name="settings_default_location" maxlength="50" value="<?= esc_attr ($setting_default_location) ?>"/>
                            <p class="description">When no address is entered, the map will center on this location.  Can
                                be set to just a state, city or a specific address.  Format as <code>Address, City, State Zip</code>.</p>
                        </label>
                    </li>
                    <li>
                        <label for="settings_google_maps_default_zoom">
                            <select name="settings_google_maps_default_zoom">
                                <? foreach ($map_zoom_levels as $map_zoom_level) {
                                    $selected = ($map_zoom_level == $setting_google_maps_default_zoom) ? " selected" : ""; ?>
                                <option<?= $selected ?>><?= $map_zoom_level ?></option>
                                <? } ?>
                            </select>
                            Zoom level for default location
                        </label>
                    </li>
                    <li>
                        <label for="settings_google_maps_addressed_zoom">
                            <select name="settings_google_maps_addressed_zoom">
                                <? foreach ($map_zoom_levels as $map_zoom_level) {
                                    $selected = ($map_zoom_level == $setting_google_maps_addressed_zoom) ? " selected" : ""; ?>
                                <option<?= $selected ?>><?= $map_zoom_level ?></option>
                                <? } ?>
                            </select>
                            Zoom level for entered address
                        </label>
                    </li>
                </ul>
            </fieldset>
        </td></tr>
        </table>

        <p class="submit">
            <input type="submit" name="submit" class="button-primary" value="Save Changes"/>
        </p>

    </form>

</div>
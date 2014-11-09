<div class="dbd-meta-contact">

    <table>
    <tr><td class="col1">
        <label for="contact_name">Name</label>
    </td><td class="col2">
        <input type="text" name="contact_name" maxlength="30" value="<?= esc_attr ($contact_data["_dbd_name"][0]) ?>"/>
    </td></tr>
    <tr><td>
        <label for="contact_phone">Phone Number</label>
    </td><td>
        <input type="text" name="contact_phone" maxlength="30" value="<?= esc_attr ($contact_data["_dbd_phone"][0]) ?>"/>
    </td></tr>
    <tr><td>
        <label for="contact_email">Email Address</label>
    </td><td>
        <input type="text" name="contact_email" maxlength="50" value="<?= esc_attr ($contact_data["_dbd_email"][0]) ?>"/>
    </td></tr>
    <tr><td>
        <label for="contact_website">Website URL</label>
    </td><td>
        <input type="text" name="contact_website" maxlength="50" value="<?= esc_attr ($contact_data["_dbd_website"][0]) ?>"/>
    </td></tr>
    <tr><td>
        <label for="contact_facebook">Facebook URL</label>
    </td><td>
        <input type="text" name="contact_facebook" maxlength="100" value="<?= esc_attr ($contact_data["_dbd_facebook"][0]) ?>"/>
    </td></tr>
    </table>

</div>
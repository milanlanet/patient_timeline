<div class="wrap">

    <div id="icon-options-general" class="icon32"><br></div>
    <h2>Edik Settings</h2>

    <form action="options.php" method="post">
        <?php settings_fields( 'pmedik-settings-group' ); ?>
        <h3 class="title">General Settings</h3>

        <table class="form-table">
            <tbody>

            <tr valign="top" class="">
                <th scope="row">Standard image editor</th>
                <td class="forminp forminp-checkbox">
                    <fieldset>
                        <legend class="screen-reader-text"><span>Standard image editor</span></legend>

                        <label for="pmedik_enable_buildin_editor">
                            <input name="pmedik_enable_buildin_editor" id="pmedik_enable_buildin_editor" type="checkbox" value="1" <?php echo $options['pmedik_enable_buildin_editor']==1?'checked="checked"':''; ?>> Enable Wordpress built-in image editor
                        </label>
                        <p class="description">Not recommended, as Edik duplicates whole standard editor functionality and it's more powerful..</p>
                    </fieldset>
                </td>
            </tr>

            </tbody>
        </table>

        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
    </form>

</div>
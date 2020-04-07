<?php
//show this settings page
function jozz_custom_settings_start()
{
    ?>

<script>
        jQuery(document).ready(function($){
            $('.color_field').each(function(){
                $(this).wpColorPicker();
                });
        });
</script>

<div class="wrap jozz_adminwrap">
    <h1>CSS Back to top</h1>
    This plugin places a simple back to top buttton on the footer of your site. It's a CSS only solution, no bloatware here! <br>
    <i>If you're using the <a href="https://wordpress.org/plugins/amp/">official AMP plugin</a> you can use the options below to display the button on your AMP URLs, your non AMP URLs or both. </i>
<form method="post" action="options.php">
    <?php
    settings_fields('jozz-settings');
    settings_fields('jozz-settings');
    ?>
     <table class="form-table">
          <tr> <th><label for="color">Color</label></th>
        <td>
        <div class="pagebox">
                <input class="color_field" type="text" name="color" data-default-color="<?= esc_attr(
                    get_option('color')
                ) ?>" value="<?= esc_attr(get_option('color')) ?>"/>
        </div>
        </td>
        </tr>
        <tr> <th><label for="viewoption">Viewing options</label></th>
        <td>
        <select name="viewoption">
            <option value='<?= esc_attr(
                get_option('viewoption')
            ) ?>' selected><?= esc_attr(get_option('viewoption')) ?></option>
            <option value='AMP only'>AMP only</option>
            <option value='Canonical only'>Canonical only</option>
            <option value='AMP & Canonical'>AMP & Canonical</option>
        </select>
        </td>
        </tr>
        <br>
    </table>
    <?php submit_button(); ?>
</form>
</div>
  <?php
}

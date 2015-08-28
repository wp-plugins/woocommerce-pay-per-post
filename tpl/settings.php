
<div class="wrap">

    <?php screen_icon(); ?>

    <form action="options.php" method="post" id="<?php echo $plugin_id; ?>_options_form" name="<?php echo $plugin_id; ?>_options_form">
        <h2>WooCommerce Pay Per Post &raquo; Settings</h2>
        <?php
        settings_fields($plugin_id . '_options');
        ?>
        <table class="widefat">
            <thead>
               <tr>
                <th><input type="submit" name="submit" value="Save Settings" class="button-primary" /></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>
                    <label for="wcppp_oops_content">
                        <p>Message that gets displayed when visitor goes to page that they have not purchased.</p>
                        <p><textarea style="width:100%; height:400px;" name="wcppp_oops_content"><?php echo get_option('wcppp_oops_content'); ?></textarea></p>
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="wcppp_exclude_post_types">
                        <p>If you would like to INCLUDE a specific post type to have the PPP Meta Box.  You can enter it in below.  You can add multiples by seperating by a comma.</p>
                        <p><input type="text" style="width:100%;" name="wcppp_include_post_types" value="<?php echo get_option('wcppp_include_post_types'); ?>"></p>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>

    </form>
    <h2>Sample</h2>

    <?php
    echo htmlentities("<h1>Oops, Restricted Content</h1>");
    echo "<br>";
    echo htmlentities("<p>We are sorry but this post is restricted to folks that have purchased this page.</p>");
    echo "<br>";
    echo htmlentities("[product id='{{product_id}}']");
    ?>

    <h2>WooCommerce Shortcodes</h2>
    <p>Visit <a href="http://docs.woothemes.com/document/woocommerce-shortcodes/" target="_blank">http://docs.woothemes.com/document/woocommerce-shortcodes/</a> for more shortcodes.</p>
    <dl>
        <dd>[product_page id="{{product_id}}"]</dd>
        <dd>[product id="{{product_id}}"]</dd>

    </dl>


</div>
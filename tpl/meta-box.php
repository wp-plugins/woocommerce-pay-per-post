<?php wp_nonce_field('woocommerce_ppp_nonce', 'woocommerce_ppp_nonce'); ?>

<p>
    This is the id of the product that is required to have been purchased before a user can view the content of this page. You can select multiple products.<br>
    <label for="woocommerce_ppp_product_id">Product ID: </label><br>
    <select multiple name="woocommerce_ppp_product_id[]">
        <?php echo $dropdown; ?>
    </select>
</p>
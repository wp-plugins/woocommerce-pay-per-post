<?php wp_nonce_field('woocommerce_ppp_nonce', 'woocommerce_ppp_nonce'); ?>

<p>
    This is the id of the product that is required to have been purchased before a user can view the content of this page. You can enter in multiple IDs just seperate them with a comma.<br>
    <label for="woocommerce_ppp_product_id">Product ID: </label>
    
    <input type="text" name="woocommerce_ppp_product_id" id="woocommerce_ppp_product_id" value="<?php echo Woocommerce_PayPerPost::get(Woocommerce_PayPerPost::METAKEY); ?>" size="50" />
</p>
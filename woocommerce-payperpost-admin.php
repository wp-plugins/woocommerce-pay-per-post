<?php

/*
 * Administration functionality for WooCommerce PayPerPost Plugin
 * Author: Matt Pramschufer of E-Moxie
 * URL: www.emoxie.com
 * Date: 5/14/2014
 */

define('WCPPP_ID', 'wcppp-plugin-options');
define('WCPPP_NICK', 'WooCommerce Pay Per Post');

class Woocommerce_PayPerPost_Admin {

    public static function init() {
        add_action('admin_init', array(__CLASS__, 'register'));
        add_action('admin_menu', array(__CLASS__, 'menu'));
    }

    public static function register() {
        register_setting(WCPPP_ID . '_options', 'wcppp_oops_content');
        register_setting(WCPPP_ID . '_options', 'wcppp_exclude_post_types');
        register_setting(WCPPP_ID . '_options', 'wcppp_include_post_types');
    }

    public static function menu() {
        // Create menu tab
        add_options_page(WCPPP_NICK . ' Plugin Options', WCPPP_NICK, 'manage_options', WCPPP_ID . '_options', array('Woocommerce_PayPerPost_Admin', 'options_page'));
    }


    public static function options_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        $plugin_id = WCPPP_ID;
        // display options page
        require_once dirname(__FILE__) . '/tpl/settings.php';
    }

}



/**
 * Add the settings link to the plugin screen
 */
$plugin_file = 'woocommerce-payperpost/woocommerce-payperpost.php';
add_filter( "plugin_action_links_{$plugin_file}", 'woocommerce_payperpost_plugin_action_links', 10, 2 );

function woocommerce_payperpost_plugin_action_links( $links, $file ) {
    $settings_link = '<a href="' . admin_url( 'admin.php?page='.WCPPP_ID ) . '">' . __( 'Settings', WCPPP_ID.'_options' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
    
    
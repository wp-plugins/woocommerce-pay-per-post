<?php

/*
 * Plugin Name: WooCommerce Pay Per Post
 * Plugin URI: http://wordpress.emoxie.com/woocommerce-pay-per-post/
 * Description: Allows for the sale of a specific post/page in Wordpress through WooCommerce
 * Author: Matt Pramschufer
 * Version: 1.4
 * Author URI: http://www.emoxie.com/
 */
if ( ! class_exists( 'Woocommerce_PayPerPost' ) ) {

	class Woocommerce_PayPerPost {

		const METAKEY = 'woocommerce_ppp_product_id';

		public static function init() {

			define( 'WC_PPP_URL', plugins_url() . '/woocommerce-payperpost/' );
			define( 'WC_PPP_PATH', plugin_dir_path( __FILE__ ) );

			add_action( 'admin_init', __CLASS__ . '::woocommerce_dependencies' );
			add_action( 'add_meta_boxes', __CLASS__ . '::add_custom_meta_box' );
			add_action( 'save_post', __CLASS__ . '::save_custom_meta_box' );
			add_filter( 'the_content', __CLASS__ . '::render' );

			add_shortcode( 'woocommerce-payperpost', __CLASS__ . '::shortcodes' );

			// If logged into administration area call the Admin functions of the SilverPop
			if ( is_admin() ) {
				require_once dirname( __FILE__ ) . '/woocommerce-payperpost-admin.php';
				Woocommerce_PayPerPost_Admin::init();
			}

		}

		public static function woocommerce_dependencies() {
			if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				$plugin = plugin_basename( __FILE__ );
				deactivate_plugins( $plugin );
				wp_die( '<h1>Ooops</h1><p>This Plugin requires <strong><a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a></strong>.  This plugin has been deactivated! Please activate <strong>WooCommerce</strong> and try again.<br /><br />Back to the WordPress <a href="' . get_admin_url( null, 'plugins.php' ) . '">Plugins page</a>.</p>' );
			}
		}

		public static function get( $value, $id = null ) {
			if ( empty( $id ) ) {
				global $post;
				$id = $post->ID;
			}
			$custom_field = get_post_meta( $id, $value, true );
			if ( ! empty( $custom_field ) ) {
				return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );
			} else {
				return false;
			}
		}

		public static function add_custom_meta_box() {

			$post_types = get_post_types();
			foreach ( $post_types as $post_type ) {
				add_meta_box( 'woocommerce-payperpost-meta-box', __( 'WooCommerce Pay Per Post', 'textdomain' ), __CLASS__ . '::output_meta_box', $post_type, 'normal', 'high' );
			}

		}

		public static function output_meta_box() {

			//Get All Products
			$args     = array(
				'post_type' => 'product',
				'orderby'   => 'title',
				'order'     => 'ASC'
			);
			$wp_query = new WP_Query( $args );
			$dropdown = null;

			$selected = explode( ',', Woocommerce_PayPerPost::get( Woocommerce_PayPerPost::METAKEY ) );

			while( $wp_query->have_posts() ) : $wp_query->the_post();

				$dropdown .= '<option value="' . get_the_ID() . '"';

				if ( in_array( get_the_ID(), $selected ) ) {
					$dropdown .= ' selected';
				}

				$dropdown .= '>' . get_the_title() . ' - [#' . get_the_ID() . ']</option>';

			endwhile;

			ob_start();
			require WC_PPP_PATH . '/tpl/meta-box.php';
			echo ob_get_clean();
		}

		public static function save_custom_meta_box( $post_id ) {

			// Stop the script when doing autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			// Verify the nonce. If insn't there, stop the script
			if ( ! isset( $_POST['woocommerce_ppp_nonce'] ) || ! wp_verify_nonce( $_POST['woocommerce_ppp_nonce'], 'woocommerce_ppp_nonce' ) ) {
				return;
			}
			// Stop the script if the user does not have edit permissions
			if ( ! current_user_can( 'edit_post' ) ) {
				return;
			}
			// Save the textfield
			if ( isset( $_POST['woocommerce_ppp_product_id'] ) ) {
				update_post_meta( $post_id, 'woocommerce_ppp_product_id', esc_attr( implode( ',', $_POST['woocommerce_ppp_product_id'] ) ) );
			}
		}

		public static function render( $content ) {
			$productID = self::get( self::METAKEY );

			if ( ! empty( $productID ) ) {
				if ( current_user_can( 'manage_options' ) || ( is_user_logged_in() && self::checkForProduct( $productID ) ) ) {
					return $content;
				} else {
					//Turn off comments for pages user doesn't have access to.
					add_filter( 'comments_open', function () {
						return false;
					} );

					return str_replace( '{{product_id}}', $productID, get_option( 'wcppp_oops_content' ) );
				}
			} else {
				return $content;
			}
		}

		public static function checkForProduct( $id ) {
			$purchased    = 0;
			$current_user = wp_get_current_user();

			$ids = str_replace( " ", '', $id );
			$ids = explode( ",", $ids );

			foreach ( $ids as $id ) {
				$purchased = wc_customer_bought_product( $current_user->user_email, $current_user->ID, $id );

				if ( $purchased ) {
					return $purchased;
				}
			}
		}

		/**
		 * Shortcode to display my list of purchased posts/pages
		 * [woocommerce-payperpost template='purchased']
		 */
		public static function shortcodes( $atts ) {

			extract( shortcode_atts( array(
				'template' => 'purchased',
				'debug'    => false,
			), $atts ) );


			//Grab a list of posts which have the WCPPP meta key filled in
			$args = array(
				'orderby'      => 'post_date',
				'order'        => 'DESC',
				'nopaging'     => true,
				'meta_key'     => self::METAKEY,
				'meta_value'   => '0',
				'meta_compare' => '>',
				'post_status'  => 'publish',
				'post_type'    => array( 'post', 'page' )

			);

			$posts_array = get_posts( $args );

			switch ( $template ) {
				case "purchased":
					if ( is_user_logged_in() ) {
						foreach ( $posts_array as $index => $post ) {
							$productID = self::get( self::METAKEY, $post->ID );
							if ( ! self::checkForProduct( $productID ) ) {
								//Remove page if they have not purchased
								unset( $posts_array[ $index ] );
							}
						}
						$posts_array = array_values( $posts_array );

						$return = self::renderTemplate( 'purchased', $posts_array );
					}
					break;

				case "all":
					$return = self::renderTemplate( 'all', $posts_array );
					break;
			}

			return $return;
		}

		public static function renderTemplate( $template = 'purchased', $data ) {
			ob_start();
			require WC_PPP_PATH . '/tpl/' . $template . '.php';

			return ob_get_clean();
		}

	}

	Woocommerce_PayPerPost::init();
}

/**
 * Add the settings link to the plugin screen
 */
$plugin_file = 'woocommerce-pay-per-post/woocommerce-payperpost.php';
add_filter( "plugin_action_links_{$plugin_file}", 'woocommerce_pay_per_post_plugin_action_links', 10, 2 );

function woocommerce_pay_per_post_plugin_action_links( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'options-general.php?page=wcppp-plugin-options_options' ) . '">Settings</a>';
	array_unshift( $links, $settings_link );

	return $links;
}
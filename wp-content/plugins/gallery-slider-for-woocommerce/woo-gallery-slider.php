<?php
/**
 * Woo gallery slider
 *
 * @link              https://shapedplugin.com/
 * @since             1.0.0
 * @package           Woo_Gallery_Slider
 *
 * Plugin Name:       Gallery Slider for WooCommerce
 * Plugin URI:        https://shapedplugin.com/plugin/woocommerce-gallery-slider-pro/?ref=143
 * Description:       Gallery Slider for WooCommerce plugin allows you to insert additional images for each variation to let visitors see different images when product variations are switched. Increase your sales by transforming the WooCommerce default product gallery instantly to a beautiful thumbnails gallery slider on a single product page.
 * Version:           2.0.5
 * Author:            WooGallery Slider Team, ShapedPlugin LLC
 * Author URI:        https://woogalleryslider.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least: 5.3
 * Requires PHP: 7.0
 * Requires Plugins: woocommerce
 * WC requires at least: 4.5
 * WC tested up to: 8.9.2
 * Text Domain:       gallery-slider-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WOO_GALLERY_SLIDER_VERSION', '2.0.5' );
define( 'WOO_GALLERY_SLIDER_FILE', __FILE__ );
define( 'WOO_GALLERY_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
define( 'WOO_GALLERY_SLIDER_URL', plugin_dir_url( __FILE__ ) );
define( 'WOO_GALLERY_SLIDER_BASENAME', plugin_basename( __FILE__ ) );
define( 'WOO_GALLERY_SLIDER_PRO_LINK', 'https://shapedplugin.com/plugin/woocommerce-gallery-slider-pro/?ref=143' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-gallery-slider-updates.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-gallery-slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_gallery_slider() {
	$plugin = new Woo_Gallery_Slider();
	$plugin->run();
}
if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}
if ( ( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) && ! ( is_plugin_active( 'woo-gallery-slider-pro/woo-gallery-slider-pro.php' ) || is_plugin_active_for_network( 'woo-gallery-slider-pro/woo-gallery-slider-pro.php' ) ) ) {
	if ( ! is_network_admin() ) {
		run_woo_gallery_slider();
	}
}

/**
 * Show admin notice if WooCommerce is not activated.
 *
 * @since    1.0.0
 */
function wcgs_wc_admin_notice() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		$link    = esc_url(
			add_query_arg(
				array(
					'tab'       => 'plugin-information',
					'plugin'    => 'woocommerce',
					'TB_iframe' => 'true',
					'width'     => '640',
					'height'    => '500',
				),
				admin_url( 'plugin-install.php' )
			)
		);
		$outline = '<div class="error"><p>' . wp_kses_post( 'You must install and activate <a class="thickbox open-plugin-details-modal" href="' . esc_url( $link ) . '"><strong>WooCommerce</strong></a> plugin to make the <strong>Gallery Slider for WooCommerce</strong> work.', 'gallery-slider-for-woocommerce' ) . '</p></div>';
		echo wp_kses_post( $outline );
	}
}
add_action( 'admin_notices', 'wcgs_wc_admin_notice' );

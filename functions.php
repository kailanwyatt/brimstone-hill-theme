<?php
/**
 * Brimstone Hill theme functions and definitions
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'BH_THEME_VERSION' ) ) {
	define( 'BH_THEME_VERSION', '1.0.0' );
}

define( 'BH_THEME_DIR', get_template_directory() );
define( 'BH_THEME_URI', get_template_directory_uri() );

// Include theme modules
require_once BH_THEME_DIR . '/inc/theme-supports.php';
require_once BH_THEME_DIR . '/inc/enqueue.php';
require_once BH_THEME_DIR . '/inc/bhfp-bridge.php';
require_once BH_THEME_DIR . '/inc/navigation.php';
require_once BH_THEME_DIR . '/inc/sidebar-settings.php';
require_once BH_THEME_DIR . '/inc/customizer.php';
require_once BH_THEME_DIR . '/inc/homepage-settings.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once BH_THEME_DIR . '/inc/donation.php';
}

// Remove WooCommerce Cart Cross Sells for a cleaner funnel
add_action( 'init', function() {
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
});

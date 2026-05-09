<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Brimstone_Hill
 */

function bh_enqueue_scripts() {
	// Enqueue base styles
	wp_enqueue_style( 'bh-variables', BH_THEME_URI . '/assets/css/variables.css', array(), BH_THEME_VERSION );
	wp_enqueue_style( 'bh-layout', BH_THEME_URI . '/assets/css/layout.css', array('bh-variables'), BH_THEME_VERSION );
	wp_enqueue_style( 'bh-components', BH_THEME_URI . '/assets/css/components.css', array('bh-variables', 'bh-layout'), BH_THEME_VERSION );
	
	// Main theme stylesheet
	wp_enqueue_style( 'bh-style', get_stylesheet_uri(), array('bh-components'), BH_THEME_VERSION );

	// Base JS
	wp_enqueue_script( 'bh-main', BH_THEME_URI . '/assets/js/main.js', array(), BH_THEME_VERSION, true );

	// WooCommerce custom styles/scripts
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'bh-woocommerce-custom', BH_THEME_URI . '/assets/css/woocommerce-custom.css', array('bh-components'), BH_THEME_VERSION );
		wp_enqueue_script( 'bh-woocommerce-custom', BH_THEME_URI . '/assets/js/woocommerce-custom.js', array(), BH_THEME_VERSION, true );
	}

	if ( is_page_template( 'page-book-tickets.php' ) ) {
		wp_enqueue_script( 'bh-book-tickets', BH_THEME_URI . '/assets/js/book-tickets.js', array(), BH_THEME_VERSION, true );
	}

	if ( is_page( 'donate' ) ) {
		wp_enqueue_script( 'bh-donate-page', BH_THEME_URI . '/assets/js/donate-page.js', array(), BH_THEME_VERSION, true );
	}

	if ( is_singular( 'bhfp_gallery' ) ) {
		wp_enqueue_script( 'bh-gallery-lightbox', BH_THEME_URI . '/assets/js/gallery-lightbox.js', array(), BH_THEME_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'bh_enqueue_scripts' );

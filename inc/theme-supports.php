<?php
/**
 * Theme supports.
 *
 * @package Brimstone_Hill
 */

function bh_theme_setup() {
	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// Register custom image sizes
	add_image_size( 'bh-hero', 1920, 1080, true );
	add_image_size( 'bh-card', 600, 400, true );
	add_image_size( 'bh-gallery-thumb', 400, 400, true );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for core custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add WooCommerce support
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'bh_theme_setup' );

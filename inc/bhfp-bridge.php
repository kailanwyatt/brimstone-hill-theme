<?php
/**
 * Theme helpers that use the Brimstone Hill plugin settings when available.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return bool
 */
function bh_announcement_bar_enabled() {
	if ( function_exists( 'bhfp_announcement_bar_enabled' ) ) {
		return bhfp_announcement_bar_enabled();
	}
	return (bool) get_theme_mod( 'bh_announcement_enabled', true );
}

/**
 * @return string
 */
function bh_announcement_message() {
	if ( function_exists( 'bhfp_announcement_message' ) ) {
		return bhfp_announcement_message();
	}
	return (string) get_theme_mod( 'bh_announcement_text', 'Open daily 9:30am–5:30pm · Book your visit today' );
}

/**
 * @return array<int, array{label:string,url:string}>
 */
function bh_announcement_links() {
	if ( function_exists( 'bhfp_announcement_links' ) ) {
		return bhfp_announcement_links();
	}
	return array(
		array(
			'label' => __( 'Book now', 'brimstone-hill' ),
			'url'   => home_url( '/visit/book-tickets/' ),
		),
		array(
			'label' => __( 'Donate', 'brimstone-hill' ),
			'url'   => home_url( '/get-involved/donate/' ),
		),
		array(
			'label' => __( "What's on", 'brimstone-hill' ),
			'url'   => home_url( '/events/whats-on/' ),
		),
		array(
			'label' => __( 'Contact', 'brimstone-hill' ),
			'url'   => home_url( '/about/contact/' ),
		),
	);
}

/**
 * @return string
 */
function bh_book_tickets_url() {
	if ( function_exists( 'bhfp_book_tickets_url' ) ) {
		return bhfp_book_tickets_url();
	}
	return home_url( '/visit/book-tickets/' );
}

/**
 * Normalize button/link labels — strip tags and collapse whitespace.
 *
 * @param string $label Raw label.
 * @return string
 */
function bh_normalize_button_label( $label ) {
	$label = wp_strip_all_tags( (string) $label );
	$label = preg_replace( '/\s+/', ' ', $label );

	return trim( $label );
}

/**
 * @return string
 */
function bh_book_tickets_label() {
	if ( function_exists( 'bhfp_reservation_label' ) ) {
		return bh_normalize_button_label( bhfp_reservation_label() );
	}
	return __( 'Make a reservation', 'brimstone-hill' );
}

/**
 * @return string
 */
function bh_staff_login_url() {
	if ( function_exists( 'bhfp_staff_login_url' ) ) {
		return bhfp_staff_login_url();
	}
	return home_url( '/staff/login/' );
}

/**
 * @return string
 */
function bh_footer_brand_text() {
	if ( function_exists( 'bhfp_footer_brand_text' ) ) {
		return bhfp_footer_brand_text();
	}
	return __( 'Brimstone Hill Fortress National Park', 'brimstone-hill' );
}

/**
 * @return string
 */
function bh_tripadvisor_url() {
	if ( function_exists( 'bhfp_tripadvisor_url' ) ) {
		return bhfp_tripadvisor_url();
	}
	return 'https://www.tripadvisor.com/Attraction_Review-g147374-d147556-Reviews-Brimstone_Hill_Fortress_National_Park-St_Kitts_St_Kitts_and_Nevis.html';
}

/**
 * Default footer quick links when no menu is assigned.
 *
 * @return array<int, array{label:string,url:string}>
 */
function bh_default_footer_links() {
	if ( function_exists( 'bhfp_page_url' ) ) {
		$links = array(
			array( 'label' => __( 'Visit', 'brimstone-hill' ), 'url' => bhfp_page_url( 'visit' ) ),
			array( 'label' => bh_book_tickets_label(), 'url' => bh_book_tickets_url() ),
			array( 'label' => __( 'Member', 'brimstone-hill' ), 'url' => bhfp_page_url( 'get-involved/member' ) ),
			array( 'label' => __( 'Donate', 'brimstone-hill' ), 'url' => bhfp_page_url( 'get-involved/donate' ) ),
			array( 'label' => __( 'About', 'brimstone-hill' ), 'url' => bhfp_page_url( 'about' ) ),
			array( 'label' => __( 'Contact', 'brimstone-hill' ), 'url' => bhfp_page_url( 'about/contact' ) ),
		);
	} else {
		$links = array(
			array( 'label' => __( 'Visit', 'brimstone-hill' ), 'url' => home_url( '/visit/' ) ),
			array( 'label' => bh_book_tickets_label(), 'url' => bh_book_tickets_url() ),
			array( 'label' => __( 'Member', 'brimstone-hill' ), 'url' => home_url( '/get-involved/member/' ) ),
			array( 'label' => __( 'Donate', 'brimstone-hill' ), 'url' => home_url( '/get-involved/donate/' ) ),
			array( 'label' => __( 'About', 'brimstone-hill' ), 'url' => home_url( '/about/' ) ),
			array( 'label' => __( 'Contact', 'brimstone-hill' ), 'url' => home_url( '/about/contact/' ) ),
		);
	}
	return bh_filter_paused_sales_links( $links );
}

/**
 * Remove booking, donation, and membership links while public sales are paused.
 *
 * @param array<int, array{label:string,url:string}> $links Links.
 * @return array<int, array{label:string,url:string}>
 */
function bh_filter_paused_sales_links( $links ) {
	if ( ! function_exists( 'bhfp_ecommerce_is_paused' ) || ! bhfp_ecommerce_is_paused() || ! class_exists( 'BHFP_Storefront_Pause' ) ) {
		return $links;
	}
	$kept = array();
	foreach ( $links as $link ) {
		if ( empty( $link['url'] ) || BHFP_Storefront_Pause::url_is_sales( $link['url'] ) ) {
			continue;
		}
		$kept[] = $link;
	}
	return $kept;
}

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
 * @return string
 */
function bh_book_tickets_label() {
	if ( function_exists( 'bhfp_book_tickets_label' ) ) {
		return bhfp_book_tickets_label();
	}
	return __( 'Book tickets', 'brimstone-hill' );
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
		return array(
			array( 'label' => __( 'Visit', 'brimstone-hill' ), 'url' => bhfp_page_url( 'visit' ) ),
			array( 'label' => bh_book_tickets_label(), 'url' => bh_book_tickets_url() ),
			array( 'label' => __( 'Member', 'brimstone-hill' ), 'url' => bhfp_page_url( 'get-involved/member' ) ),
			array( 'label' => __( 'Donate', 'brimstone-hill' ), 'url' => bhfp_page_url( 'get-involved/donate' ) ),
			array( 'label' => __( 'About', 'brimstone-hill' ), 'url' => bhfp_page_url( 'about' ) ),
			array( 'label' => __( 'Contact', 'brimstone-hill' ), 'url' => bhfp_page_url( 'about/contact' ) ),
		);
	}
	return array(
		array( 'label' => __( 'Visit', 'brimstone-hill' ), 'url' => home_url( '/visit/' ) ),
		array( 'label' => bh_book_tickets_label(), 'url' => bh_book_tickets_url() ),
		array( 'label' => __( 'Member', 'brimstone-hill' ), 'url' => home_url( '/get-involved/member/' ) ),
		array( 'label' => __( 'Donate', 'brimstone-hill' ), 'url' => home_url( '/get-involved/donate/' ) ),
		array( 'label' => __( 'About', 'brimstone-hill' ), 'url' => home_url( '/about/' ) ),
		array( 'label' => __( 'Contact', 'brimstone-hill' ), 'url' => home_url( '/about/contact/' ) ),
	);
}

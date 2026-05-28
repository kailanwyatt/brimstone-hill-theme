<?php
/**
 * Site footer helpers — four-column layout with menus and about blurb.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Short about text for footer column one (Customizer: Appearance → Customize → Footer).
 *
 * @return string
 */
function bh_footer_about_text() {
	$default = __( 'A UNESCO World Heritage Site on St. Kitts. Explore the fortress, discover centuries of history, and plan your visit to one of the Caribbean\'s best-preserved historic sites.', 'brimstone-hill' );
	return (string) get_theme_mod( 'bh_footer_about', $default );
}

/**
 * Resolve a page URL via plugin helper or home_url fallback.
 *
 * @param string $path Path without leading slash.
 * @return string
 */
function bh_footer_page_url( $path ) {
	$path = trim( (string) $path, '/' );
	if ( function_exists( 'bhfp_page_url' ) ) {
		return bhfp_page_url( $path );
	}
	return home_url( '/' . $path . '/' );
}

/**
 * Footer navigation columns (title, menu location, fallback links).
 *
 * @return array<int, array{title:string,location:string,links:array<int,array{label:string,url:string}>}>
 */
function bh_footer_nav_columns() {
	$columns = array(
		array(
			'title'    => __( 'Visit', 'brimstone-hill' ),
			'location' => 'footer-visit',
			'links'    => array(
				array( 'label' => __( 'Plan your visit', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'visit/plan-your-visit' ) ),
				array( 'label' => bh_book_tickets_label(), 'url' => bh_book_tickets_url() ),
				array( 'label' => __( 'Hours & admission', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'visit/hours-admission' ) ),
				array( 'label' => __( 'Directions & map', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'visit/directions' ) ),
				array( 'label' => __( 'Group visits', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'visit/group-visits' ) ),
			),
		),
		array(
			'title'    => __( 'Discover', 'brimstone-hill' ),
			'location' => 'footer-discover',
			'links'    => array(
				array( 'label' => __( 'History & story', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'discover/history' ) ),
				array( 'label' => __( 'The fortress', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'discover/the-fortress' ) ),
				array( 'label' => __( 'Exhibitions', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'discover/exhibitions' ) ),
				array( 'label' => __( 'Gallery', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'discover/gallery' ) ),
				array( 'label' => __( 'UNESCO World Heritage', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'discover/unesco' ) ),
			),
		),
		array(
			'title'    => __( 'Get involved', 'brimstone-hill' ),
			'location' => 'footer-involved',
			'links'    => array(
				array( 'label' => __( 'Become a member', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'get-involved/member' ) ),
				array( 'label' => __( 'Donate', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'get-involved/donate' ) ),
				array( 'label' => __( 'Volunteer', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'get-involved/volunteer' ) ),
				array( 'label' => __( 'Partnerships', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'get-involved/partnerships' ) ),
				array( 'label' => __( 'Contact', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'about/contact' ) ),
			),
		),
	);

	return apply_filters( 'bh_footer_nav_columns', $columns );
}

/**
 * Legal / utility links for the footer bottom bar.
 *
 * @return array<int, array{label:string,url:string}>
 */
function bh_footer_bottom_links() {
	$links = array();

	if ( function_exists( 'bh_merchant_legal_footer_links' ) ) {
		$links = bh_merchant_legal_footer_links();
	}

	if ( empty( $links ) ) {
		$links = array(
			array( 'label' => __( 'Contact', 'brimstone-hill' ), 'url' => bh_footer_page_url( 'about/contact' ) ),
		);
	}

	return apply_filters( 'bh_footer_links', $links );
}

/**
 * Render a vertical footer menu list.
 *
 * @param string               $location Theme location.
 * @param array<int, array{label:string,url:string}> $fallback Fallback links.
 */
function bh_render_footer_nav( $location, array $fallback ) {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => 'footer-nav',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		return;
	}

	echo '<ul class="footer-nav">';
	foreach ( $fallback as $link ) {
		if ( empty( $link['url'] ) ) {
			continue;
		}
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $link['url'] ),
			esc_html( $link['label'] ?? '' )
		);
	}
	echo '</ul>';
}

/**
 * Register footer Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function bh_footer_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'bh_footer',
		array(
			'title'    => __( 'Footer', 'brimstone-hill' ),
			'priority' => 120,
		)
	);

	$wp_customize->add_setting(
		'bh_footer_about',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	$wp_customize->add_control(
		'bh_footer_about',
		array(
			'label'       => __( 'About blurb', 'brimstone-hill' ),
			'description' => __( 'Short description shown in the first footer column. Leave empty for the default text.', 'brimstone-hill' ),
			'section'     => 'bh_footer',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'bh_footer_customize_register' );

<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Brimstone_Hill
 */

function bh_enqueue_scripts() {
	// Enqueue base styles
	wp_enqueue_style( 'bh-variables', BH_THEME_URI . '/assets/css/variables.css', array(), bh_asset_version( 'assets/css/variables.css' ) );
	wp_enqueue_style( 'bh-layout', BH_THEME_URI . '/assets/css/layout.css', array( 'bh-variables' ), bh_asset_version( 'assets/css/layout.css' ) );
	wp_enqueue_style( 'bh-components', BH_THEME_URI . '/assets/css/components.css', array( 'bh-variables', 'bh-layout' ), bh_asset_version( 'assets/css/components.css' ) );

	// Main theme stylesheet
	wp_enqueue_style( 'bh-style', get_stylesheet_uri(), array( 'bh-components' ), bh_asset_version( 'style.css' ) );

	// Base JS
	wp_enqueue_script( 'bh-main', BH_THEME_URI . '/assets/js/main.js', array(), bh_asset_version( 'assets/js/main.js' ), true );

	// WooCommerce custom styles/scripts
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'bh-woocommerce-custom', BH_THEME_URI . '/assets/css/woocommerce-custom.css', array( 'bh-components' ), bh_asset_version( 'assets/css/woocommerce-custom.css' ) );
		wp_enqueue_script( 'bh-woocommerce-custom', BH_THEME_URI . '/assets/js/woocommerce-custom.js', array(), bh_asset_version( 'assets/js/woocommerce-custom.js' ), true );
	}

	if ( is_page_template( 'page-book-tickets.php' ) ) {
		wp_enqueue_script( 'bh-book-tickets', BH_THEME_URI . '/assets/js/book-tickets.js', array(), bh_asset_version( 'assets/js/book-tickets.js' ), true );
		$tiers_payload = array( '0' => array() );
		if ( class_exists( 'BHFP_Booking_Public' ) ) {
			$tiers_payload = BHFP_Booking_Public::ticket_tiers_js_payload();
		} elseif ( class_exists( 'BHFP_Ticket_Tiers' ) ) {
			$tiers_payload = BHFP_Ticket_Tiers::get_booking_payload_for_js();
		}
		$preselect_event_id = class_exists( 'BHFP_Booking_Public' )
			? BHFP_Booking_Public::preselect_event_id_from_request()
			: 0;
		$preselect_visit_date = class_exists( 'BHFP_Booking_Public' )
			? BHFP_Booking_Public::preselect_visit_date_from_request( $preselect_event_id )
			: '';

		wp_localize_script(
			'bh-book-tickets',
			'bhBookTickets',
			array(
				'tiersByEvent'       => $tiers_payload,
				'initialEventId'     => $preselect_event_id,
				'initialVisitDate'   => $preselect_visit_date,
				'currencySymbol'     => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$',
				'decimals'           => function_exists( 'wc_get_price_decimals' ) ? wc_get_price_decimals() : 2,
				'decimalSeparator'   => function_exists( 'wc_get_price_decimal_separator' ) ? wc_get_price_decimal_separator() : '.',
				'thousandSeparator'  => function_exists( 'wc_get_price_thousand_separator' ) ? wc_get_price_thousand_separator() : ',',
				'i18n'               => array(
					'free'       => __( 'Free', 'brimstone-hill' ),
					'noTiers'    => __( 'Ticket types are not available right now. Please contact us for assistance.', 'brimstone-hill' ),
					'decrease'   => __( 'Decrease quantity', 'brimstone-hill' ),
					'increase'   => __( 'Increase quantity', 'brimstone-hill' ),
					'processing' => __( 'Processing...', 'brimstone-hill' ),
					'selectOne'  => __( 'Please select at least one ticket.', 'brimstone-hill' ),
				),
			)
		);
	}

	if ( is_page_template( 'page-donate.php' ) || is_page( 'donate' ) ) {
		wp_enqueue_script( 'bh-donate-page', BH_THEME_URI . '/assets/js/donate-page.js', array(), bh_asset_version( 'assets/js/donate-page.js' ), true );
		if ( class_exists( 'WooCommerce' ) && function_exists( 'bh_donate_is_ready' ) && bh_donate_is_ready() ) {
			wp_localize_script(
				'bh-donate-page',
				'bhDonate',
				array(
					'min'            => function_exists( 'bh_donation_min_amount' ) ? bh_donation_min_amount() : 1,
					'max'            => function_exists( 'bh_donation_max_amount' ) ? bh_donation_max_amount() : 999999.99,
					'decimals'       => function_exists( 'wc_get_price_decimals' ) ? wc_get_price_decimals() : 2,
					'currencySymbol' => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$',
				)
			);
		}
	}

	if ( is_singular( 'bhfp_gallery' ) ) {
		wp_enqueue_script( 'bh-gallery-lightbox', BH_THEME_URI . '/assets/js/gallery-lightbox.js', array(), bh_asset_version( 'assets/js/gallery-lightbox.js' ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'bh_enqueue_scripts' );

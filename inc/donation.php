<?php
/**
 * WooCommerce donation: one product ID with amount chosen on the donate page.
 *
 * @package Brimstone_Hill
 */

defined( 'ABSPATH' ) || exit;

/**
 * Minimum donation amount (store currency).
 *
 * @return float
 */
function bh_donation_min_amount() {
	return (float) apply_filters( 'bh_donation_min_amount', 1.0 );
}

/**
 * Maximum donation amount (store currency).
 *
 * @return float
 */
function bh_donation_max_amount() {
	return (float) apply_filters( 'bh_donation_max_amount', 999999.99 );
}

/**
 * Configured donation product ID (Settings → Brimstone Hill → Commerce).
 *
 * @return int
 */
function bh_get_donation_product_id() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return 0;
	}
	if ( function_exists( 'bhfp_donation_product_id' ) ) {
		return bhfp_donation_product_id();
	}
	return absint( get_theme_mod( 'bh_donation_product_id', 0 ) );
}

/**
 * @param int $product_id Product ID.
 * @return bool
 */
function bh_is_donation_product( $product_id ) {
	$pid = bh_get_donation_product_id();
	return $pid > 0 && (int) $product_id === $pid;
}

/**
 * Whether donate flow can run (WooCommerce active, product exists).
 *
 * @return bool
 */
function bh_donate_is_ready() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return false;
	}
	$id = bh_get_donation_product_id();
	if ( ! $id ) {
		return false;
	}
	$product = wc_get_product( $id );
	if ( ! $product || ! $product->is_purchasable() ) {
		return false;
	}
	// Donations must be a standard simple product (not booking/membership types).
	$type = $product->get_type();
	return in_array( $type, array( 'simple', '' ), true );
}

/**
 * Preset button amounts from theme mod or filter.
 *
 * @return float[]
 */
function bh_donation_preset_amounts() {
	if ( function_exists( 'bhfp_donation_preset_amounts' ) ) {
		return bhfp_donation_preset_amounts();
	}
	return array( 25, 50, 100, 250 );
}

add_filter( 'woocommerce_add_to_cart_validation', 'bh_donation_validate_add_to_cart', 10, 5 );
/**
 * Validate nonce and amount when adding the donation product.
 *
 * @param bool $passed      Passed validation.
 * @param int  $product_id  Product ID.
 * @param int  $quantity    Quantity.
 * @param int  $variation_id Variation ID.
 * @param array $cart_item_data Cart item data.
 * @return bool
 */
function bh_donation_validate_add_to_cart( $passed, $product_id, $quantity, $variation_id = 0, $cart_item_data = array() ) {
	unset( $variation_id, $cart_item_data );
	if ( ! bh_is_donation_product( $product_id ) ) {
		return $passed;
	}
	if ( empty( $_POST['bh_donation_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bh_donation_nonce'] ) ), 'bh_donate' ) ) {
		wc_add_notice( __( 'Donation form expired. Please refresh the page and try again.', 'brimstone-hill' ), 'error' );
		return false;
	}
	$amount = isset( $_POST['bh_donation_amount'] ) ? floatval( wp_unslash( $_POST['bh_donation_amount'] ) ) : 0;
	$min    = bh_donation_min_amount();
	$max    = bh_donation_max_amount();
	if ( $amount < $min || $amount > $max ) {
		wc_add_notice(
			sprintf(
				/* translators: 1: minimum amount, 2: maximum amount (plain number, currency shown separately in notice context). */
				__( 'Please enter a donation between %1$s and %2$s.', 'brimstone-hill' ),
				wp_strip_all_tags( wc_price( $min ) ),
				wp_strip_all_tags( wc_price( $max ) )
			),
			'error'
		);
		return false;
	}
	return $passed;
}

add_filter( 'woocommerce_add_cart_item_data', 'bh_donation_add_cart_item_data', 10, 4 );
/**
 * Attach donation metadata to the cart line.
 *
 * @param array $cart_item_data Existing data.
 * @param int   $product_id     Product ID.
 * @param int   $variation_id   Variation ID.
 * @param int   $quantity       Quantity.
 * @return array
 */
function bh_donation_add_cart_item_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
	unset( $variation_id, $quantity );
	if ( ! bh_is_donation_product( $product_id ) ) {
		return $cart_item_data;
	}
	if ( empty( $_POST['bh_donation_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bh_donation_nonce'] ) ), 'bh_donate' ) ) {
		return $cart_item_data;
	}
	$amount = isset( $_POST['bh_donation_amount'] ) ? floatval( wp_unslash( $_POST['bh_donation_amount'] ) ) : 0;
	$amount = round( $amount, wc_get_price_decimals() );
	if ( $amount <= 0 ) {
		return $cart_item_data;
	}
	$cart_item_data['bh_donation_amount']   = $amount;
	$cart_item_data['bh_dedication']        = isset( $_POST['bh_dedication'] ) ? sanitize_text_field( wp_unslash( $_POST['bh_dedication'] ) ) : '';
	$cart_item_data['bh_anonymous']         = ! empty( $_POST['bh_anonymous'] ) ? 'yes' : 'no';
	$cart_item_data['bh_donation_unique_key'] = wp_generate_password( 16, false );
	return $cart_item_data;
}

add_filter( 'woocommerce_get_cart_item_from_session', 'bh_donation_get_cart_item_from_session', 20, 3 );
/**
 * Restore donation fields after session load.
 *
 * @param array $cart_item    Cart row.
 * @param array $values       Session values.
 * @param string $cart_item_key Key.
 * @return array
 */
function bh_donation_get_cart_item_from_session( $cart_item, $values, $cart_item_key ) {
	unset( $cart_item_key );
	if ( isset( $values['bh_donation_amount'] ) ) {
		$cart_item['bh_donation_amount'] = (float) $values['bh_donation_amount'];
	}
	if ( isset( $values['bh_dedication'] ) ) {
		$cart_item['bh_dedication'] = $values['bh_dedication'];
	}
	if ( isset( $values['bh_anonymous'] ) ) {
		$cart_item['bh_anonymous'] = $values['bh_anonymous'];
	}
	return $cart_item;
}

add_filter( 'woocommerce_add_cart_item', 'bh_donation_add_cart_item', 20, 2 );
/**
 * Set line price when item is added.
 *
 * @param array  $cart_item     Cart row.
 * @param string $cart_item_key Key.
 * @return array
 */
function bh_donation_add_cart_item( $cart_item, $cart_item_key ) {
	unset( $cart_item_key );
	if ( isset( $cart_item['bh_donation_amount'] ) && isset( $cart_item['data'] ) && is_object( $cart_item['data'] ) ) {
		$cart_item['data']->set_price( (float) $cart_item['bh_donation_amount'] );
	}
	return $cart_item;
}

add_action( 'woocommerce_before_calculate_totals', 'bh_donation_before_calculate_totals', 20, 1 );
/**
 * Keep donation line price in sync on cart recalculation.
 *
 * @param WC_Cart $cart Cart.
 */
function bh_donation_before_calculate_totals( $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}
	foreach ( $cart->get_cart() as $cart_item ) {
		if ( empty( $cart_item['bh_donation_amount'] ) || ! isset( $cart_item['data'] ) || ! is_object( $cart_item['data'] ) ) {
			continue;
		}
		$cart_item['data']->set_price( (float) $cart_item['bh_donation_amount'] );
	}
}

add_filter( 'woocommerce_get_item_data', 'bh_donation_get_item_data', 10, 2 );
/**
 * Show dedication / anonymous on cart & checkout (amount is the line price).
 *
 * @param array $item_data Item meta rows.
 * @param array $cart_item Cart row.
 * @return array
 */
function bh_donation_get_item_data( $item_data, $cart_item ) {
	if ( empty( $cart_item['bh_donation_amount'] ) ) {
		return $item_data;
	}
	if ( ! empty( $cart_item['bh_dedication'] ) ) {
		$item_data[] = array(
			'name'  => __( 'Dedication', 'brimstone-hill' ),
			'value' => esc_html( $cart_item['bh_dedication'] ),
		);
	}
	if ( ! empty( $cart_item['bh_anonymous'] ) && 'yes' === $cart_item['bh_anonymous'] ) {
		$item_data[] = array(
			'name'  => __( 'Anonymous', 'brimstone-hill' ),
			'value' => __( 'Yes', 'brimstone-hill' ),
		);
	}
	return $item_data;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'bh_donation_checkout_create_order_line_item', 10, 4 );
/**
 * Persist donation meta on the order line.
 *
 * @param WC_Order_Item_Product $item Order item.
 * @param string                $cart_item_key Key.
 * @param array                 $values Cart values.
 * @param WC_Order              $order Order.
 */
function bh_donation_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
	unset( $cart_item_key, $order );
	if ( empty( $values['bh_donation_amount'] ) ) {
		return;
	}
	$item->add_meta_data( '_bh_donation_amount', (float) $values['bh_donation_amount'], true );
	if ( ! empty( $values['bh_dedication'] ) ) {
		$item->add_meta_data( __( 'Dedication', 'brimstone-hill' ), sanitize_text_field( $values['bh_dedication'] ), true );
	}
	if ( ! empty( $values['bh_anonymous'] ) && 'yes' === $values['bh_anonymous'] ) {
		$item->add_meta_data( __( 'Anonymous donation', 'brimstone-hill' ), __( 'Yes', 'brimstone-hill' ), true );
	}
}

add_filter( 'woocommerce_add_to_cart_redirect', 'bh_donation_add_to_cart_redirect', 20, 1 );
/**
 * After choosing an amount, send donors straight to checkout.
 *
 * @param string $url Redirect URL.
 * @return string
 */
function bh_donation_add_to_cart_redirect( $url ) {
	if ( empty( $_POST['bh_donation_nonce'] ) ) {
		return $url;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bh_donation_nonce'] ) ), 'bh_donate' ) ) {
		return $url;
	}
	$posted_id = isset( $_POST['add-to-cart'] ) ? absint( wp_unslash( $_POST['add-to-cart'] ) ) : 0;
	if ( ! $posted_id || ! bh_is_donation_product( $posted_id ) ) {
		return $url;
	}
	if ( ! function_exists( 'wc_get_checkout_url' ) ) {
		return $url;
	}
	return wc_get_checkout_url();
}

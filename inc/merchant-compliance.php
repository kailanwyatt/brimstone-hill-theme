<?php
/**
 * Merchant / NMI underwriting helpers: legal pages, policy links, card brand marks.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Card brands required for display (Visa, Mastercard, Discover per NMI bank checklist).
 *
 * @return string[]
 */
function bh_accepted_card_brand_slugs() {
	return array( 'visa', 'mastercard', 'discover' );
}

/**
 * URLs for legal policy pages (empty string if page missing).
 *
 * @return array{terms:string,privacy:string,refund:string}
 */
function bh_merchant_legal_page_urls() {
	$paths = array(
		'terms'   => 'legal/terms-and-conditions',
		'privacy' => 'legal/privacy-policy',
		'refund'  => 'legal/return-refund-policy',
	);

	$urls = array(
		'terms'   => '',
		'privacy' => '',
		'refund'  => '',
	);

	foreach ( $paths as $key => $path ) {
		$page = get_page_by_path( $path );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			$urls[ $key ] = get_permalink( $page );
		}
	}

	return $urls;
}

/**
 * Footer links for Terms, Privacy, and Refund policy.
 *
 * @return array<int, array{label:string,url:string}>
 */
function bh_merchant_legal_footer_links() {
	$urls  = bh_merchant_legal_page_urls();
	$links = array();

	if ( '' !== $urls['terms'] ) {
		$links[] = array(
			'label' => __( 'Terms & Conditions', 'brimstone-hill' ),
			'url'   => $urls['terms'],
		);
	}
	if ( '' !== $urls['privacy'] ) {
		$links[] = array(
			'label' => __( 'Privacy Policy', 'brimstone-hill' ),
			'url'   => $urls['privacy'],
		);
	}
	if ( '' !== $urls['refund'] ) {
		$links[] = array(
			'label' => __( 'Return & Refund Policy', 'brimstone-hill' ),
			'url'   => $urls['refund'],
		);
	}

	return $links;
}

/**
 * Append legal links to default footer navigation.
 *
 * @param array<int, array{label:string,url:string}> $links Existing links.
 * @return array<int, array{label:string,url:string}>
 */
function bh_append_merchant_legal_footer_links( $links ) {
	if ( ! is_array( $links ) ) {
		$links = array();
	}
	$legal = bh_merchant_legal_footer_links();
	if ( empty( $legal ) ) {
		return $links;
	}

	$existing_urls = array();
	foreach ( $links as $link ) {
		if ( ! empty( $link['url'] ) ) {
			$existing_urls[ $link['url'] ] = true;
		}
	}
	foreach ( $legal as $link ) {
		if ( empty( $existing_urls[ $link['url'] ] ) ) {
			$links[] = $link;
		}
	}
	return $links;
}
add_filter( 'bh_footer_links', 'bh_append_merchant_legal_footer_links', 20 );

/**
 * WooCommerce credit-card icon base URL.
 *
 * @return string
 */
function bh_wc_card_icon_base_url() {
	if ( class_exists( 'WooCommerce' ) && function_exists( 'WC' ) && WC() && WC()->plugin_url() ) {
		return WC()->plugin_url() . '/assets/images/icons/credit-cards/';
	}
	return '';
}

/**
 * Render accepted card brand logos (Visa, Mastercard, Discover).
 *
 * @param array<string, mixed> $args Optional. class, show_label.
 */
function bh_render_accepted_card_logos( array $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class'      => 'bh-accepted-cards',
			'show_label' => true,
		)
	);

	$base = bh_wc_card_icon_base_url();
	if ( '' === $base ) {
		return;
	}

	$labels = array(
		'visa'       => 'Visa',
		'mastercard' => 'Mastercard',
		'discover'   => 'Discover',
	);

	$brands = bh_accepted_card_brand_slugs();
	?>
	<div class="<?php echo esc_attr( $args['class'] ); ?>" role="img" aria-label="<?php echo esc_attr__( 'We accept Visa, Mastercard, and Discover', 'brimstone-hill' ); ?>">
		<?php if ( $args['show_label'] ) : ?>
			<span class="bh-accepted-cards__label"><?php esc_html_e( 'We accept', 'brimstone-hill' ); ?></span>
		<?php endif; ?>
		<ul class="bh-accepted-cards__list">
			<?php foreach ( $brands as $slug ) : ?>
				<li class="bh-accepted-cards__item bh-accepted-cards__item--<?php echo esc_attr( $slug ); ?>">
					<img src="<?php echo esc_url( $base . $slug . '.svg' ); ?>" alt="<?php echo esc_attr( $labels[ $slug ] ?? $slug ); ?>" width="48" height="30" loading="lazy" decoding="async" />
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}

/**
 * Starter HTML for a legal policy page.
 *
 * @param string $type terms|privacy|refund.
 * @return string
 */
function bh_merchant_legal_page_content( $type ) {
	$brand = function_exists( 'bh_footer_brand_text' ) ? bh_footer_brand_text() : get_bloginfo( 'name' );
	$site  = esc_url( home_url( '/' ) );
	$brand = esc_html( $brand );

	switch ( $type ) {
		case 'privacy':
			return '<h2>Privacy Policy</h2>
<p>This Privacy Policy describes how ' . $brand . ' ("we", "us") collects, uses, and protects personal information when you use <a href="' . $site . '">' . $site . '</a> and related services, including online ticket purchases, memberships, and donations.</p>
<h3>Information we collect</h3>
<p>We may collect your name, email address, billing address, phone number, order and payment details (processed by our payment provider; we do not store full card numbers on our servers), and information you provide when booking, donating, or contacting us.</p>
<h3>How we use information</h3>
<p>We use information to process orders, provide admission and membership services, communicate about your visit, improve our website, comply with law, and prevent fraud.</p>
<h3>Sharing</h3>
<p>We share data with service providers who assist operations (e.g. payment processing, email). We do not sell personal information.</p>
<h3>Security</h3>
<p>We use SSL/TLS on checkout and industry-standard payment tokenization. Please use a secure connection when paying online.</p>
<h3>Your rights</h3>
<p>You may request access, correction, or deletion of personal data where applicable. Contact us using the details on our Contact page.</p>
<h3>Updates</h3>
<p>We may update this policy from time to time. The effective date is shown at the top of this page when published.</p>
<p><em>Replace this placeholder with counsel-reviewed text before going live.</em></p>';

		case 'refund':
			return '<h2>Return &amp; Refund Policy</h2>
<p>Thank you for supporting ' . $brand . '. This policy explains returns and refunds for tickets, memberships, and donations purchased through our website.</p>
<h3>Tickets &amp; admissions</h3>
<p>Ticket purchases are generally non-refundable except where required by law or at our discretion (e.g. site closure, event cancellation). Unused tickets may not be exchanged unless stated at purchase.</p>
<h3>Memberships</h3>
<p>Membership fees follow the terms shown at checkout. Refunds for memberships, if any, are handled according to your membership category and applicable law.</p>
<h3>Donations</h3>
<p>Donations are voluntary and typically non-refundable. Contact us if you believe a donation was made in error.</p>
<h3>How to request a refund</h3>
<p>Email us with your order number and reason for the request. Approved refunds are returned to the original payment method when possible.</p>
<h3>Chargebacks</h3>
<p>Please contact us before initiating a chargeback so we can resolve your concern.</p>
<p><em>Replace this placeholder with counsel-reviewed text before going live.</em></p>';

		case 'terms':
		default:
			return '<h2>Terms &amp; Conditions</h2>
<p>By using <a href="' . $site . '">' . $site . '</a> and purchasing tickets, memberships, or donations from ' . $brand . ', you agree to these Terms &amp; Conditions.</p>
<h3>Use of the site</h3>
<p>You agree to use this website lawfully and not to misuse content, attempt unauthorized access, or interfere with site operation.</p>
<h3>Orders &amp; payment</h3>
<p>All prices are shown at checkout. Payment is processed securely by our payment provider. You represent that you are authorized to use the payment method provided.</p>
<h3>Admission &amp; conduct</h3>
<p>Visitors must follow site rules and staff instructions. We may refuse entry or remove visitors who endanger safety or heritage assets.</p>
<h3>Limitation of liability</h3>
<p>To the fullest extent permitted by law, we are not liable for indirect or consequential damages arising from use of the site or visits to the property, except where liability cannot be excluded.</p>
<h3>Governing law</h3>
<p>These terms are governed by the laws of the Federation of St. Kitts and Nevis unless otherwise required by applicable consumer protection law.</p>
<h3>Contact</h3>
<p>Questions about these terms may be directed via our Contact page.</p>
<p><em>Replace this placeholder with counsel-reviewed text before going live.</em></p>';
	}
}

/**
 * Create or update merchant legal pages and wire WooCommerce / WordPress settings.
 */
function bh_seed_merchant_legal_pages() {
	$parent = get_page_by_path( 'legal' );
	if ( ! $parent ) {
		$parent_id = wp_insert_post(
			array(
				'post_title'   => __( 'Legal', 'brimstone-hill' ),
				'post_name'    => 'legal',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			),
			true
		);
		$parent_id = is_wp_error( $parent_id ) ? 0 : (int) $parent_id;
	} else {
		$parent_id = (int) $parent->ID;
	}

	$defs = array(
		'terms'   => array(
			'title' => __( 'Terms & Conditions', 'brimstone-hill' ),
			'slug'  => 'terms-and-conditions',
		),
		'privacy' => array(
			'title' => __( 'Privacy Policy', 'brimstone-hill' ),
			'slug'  => 'privacy-policy',
		),
		'refund'  => array(
			'title' => __( 'Return & Refund Policy', 'brimstone-hill' ),
			'slug'  => 'return-refund-policy',
		),
	);

	$page_ids = array();

	foreach ( $defs as $key => $def ) {
		$path = 'legal/' . $def['slug'];
		$page = get_page_by_path( $path );
		if ( $page instanceof WP_Post ) {
			$page_ids[ $key ] = (int) $page->ID;
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'   => $def['title'],
				'post_name'    => $def['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_parent'  => $parent_id,
				'post_content' => bh_merchant_legal_page_content( $key ),
			),
			true
		);
		if ( ! is_wp_error( $page_id ) ) {
			$page_ids[ $key ] = (int) $page_id;
		}
	}

	if ( ! empty( $page_ids['terms'] ) ) {
		update_option( 'woocommerce_terms_page_id', $page_ids['terms'] );
	}
	if ( ! empty( $page_ids['privacy'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $page_ids['privacy'] );
	}
	if ( ! empty( $page_ids['refund'] ) ) {
		update_option( 'woocommerce_refund_returns_page_id', $page_ids['refund'] );
	}

	update_option( 'bh_merchant_legal_version', 1, false );
}

/**
 * Seed legal pages once if missing.
 */
function bh_maybe_seed_merchant_legal_pages() {
	if ( (int) get_option( 'bh_merchant_legal_version', 0 ) >= 1 ) {
		$urls = bh_merchant_legal_page_urls();
		if ( '' !== $urls['terms'] && '' !== $urls['privacy'] && '' !== $urls['refund'] ) {
			return;
		}
	}
	$urls = bh_merchant_legal_page_urls();
	if ( '' !== $urls['terms'] && '' !== $urls['privacy'] && '' !== $urls['refund'] ) {
		update_option( 'bh_merchant_legal_version', 1, false );
		return;
	}
	bh_seed_merchant_legal_pages();
}
add_action( 'init', 'bh_maybe_seed_merchant_legal_pages', 20 );

/**
 * Show card brands on WooCommerce checkout (NMI bank requirement).
 */
function bh_checkout_accepted_card_logos() {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
		return;
	}
	if ( ! function_exists( 'WC' ) || ! WC()->cart || WC()->cart->is_empty() ) {
		return;
	}
	echo '<div class="bh-checkout-accepted-cards">';
	bh_render_accepted_card_logos( array( 'class' => 'bh-accepted-cards bh-accepted-cards--checkout' ) );
	echo '</div>';
}
add_action( 'woocommerce_review_order_before_payment', 'bh_checkout_accepted_card_logos', 5 );

/**
 * Admin notice when legal pages are not configured (production readiness).
 */
function bh_merchant_compliance_admin_notice() {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}
	$urls = bh_merchant_legal_page_urls();
	if ( '' !== $urls['terms'] && '' !== $urls['privacy'] && '' !== $urls['refund'] ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>';
	echo esc_html__( 'Brimstone Hill: Terms, Privacy, and Refund policy pages are missing or unpublished. These are required for NMI / card processing approval.', 'brimstone-hill' );
	echo ' <a href="' . esc_url( admin_url( 'admin.php?page=bh-merchant-compliance' ) ) . '">' . esc_html__( 'Review compliance checklist', 'brimstone-hill' ) . '</a>';
	echo '</p></div>';
}
add_action( 'admin_notices', 'bh_merchant_compliance_admin_notice' );

/**
 * Simple compliance checklist under Appearance or Tools — register under Settings if BHFP has menu.
 */
function bh_register_merchant_compliance_page() {
	add_options_page(
		__( 'Payment compliance', 'brimstone-hill' ),
		__( 'Payment compliance', 'brimstone-hill' ),
		'manage_options',
		'bh-merchant-compliance',
		'bh_render_merchant_compliance_page'
	);
}
add_action( 'admin_menu', 'bh_register_merchant_compliance_page' );

/**
 * Render compliance admin page.
 */
function bh_render_merchant_compliance_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['bh_seed_legal'] ) && check_admin_referer( 'bh_seed_legal' ) ) {
		bh_seed_merchant_legal_pages();
		echo '<div class="notice notice-success"><p>' . esc_html__( 'Legal pages created/updated.', 'brimstone-hill' ) . '</p></div>';
	}
	$urls = bh_merchant_legal_page_urls();
	$ssl  = is_ssl() || ( function_exists( 'wc_checkout_is_https' ) && wc_checkout_is_https() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'NMI / bank payment compliance', 'brimstone-hill' ); ?></h1>
		<p><?php esc_html_e( 'Use this checklist before submitting your site for NMI underwriting. Replace placeholder legal text with counsel-reviewed copy.', 'brimstone-hill' ); ?></p>
		<table class="widefat striped" style="max-width:960px">
			<thead><tr><th><?php esc_html_e( 'Requirement', 'brimstone-hill' ); ?></th><th><?php esc_html_e( 'Status', 'brimstone-hill' ); ?></th></tr></thead>
			<tbody>
				<tr>
					<td><?php esc_html_e( 'Terms & Conditions page', 'brimstone-hill' ); ?></td>
					<td><?php echo '' !== $urls['terms'] ? '✓ <a href="' . esc_url( $urls['terms'] ) . '">' . esc_html__( 'View', 'brimstone-hill' ) . '</a>' : '✗'; ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Privacy Policy page', 'brimstone-hill' ); ?></td>
					<td><?php echo '' !== $urls['privacy'] ? '✓ <a href="' . esc_url( $urls['privacy'] ) . '">' . esc_html__( 'View', 'brimstone-hill' ) . '</a>' : '✗'; ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Return / Refund Policy page', 'brimstone-hill' ); ?></td>
					<td><?php echo '' !== $urls['refund'] ? '✓ <a href="' . esc_url( $urls['refund'] ) . '">' . esc_html__( 'View', 'brimstone-hill' ) . '</a>' : '✗'; ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Card logos (Visa / Mastercard / Discover)', 'brimstone-hill' ); ?></td>
					<td>✓ <?php esc_html_e( 'Footer + checkout', 'brimstone-hill' ); ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'SSL on checkout (HTTPS)', 'brimstone-hill' ); ?></td>
					<td><?php echo $ssl ? '✓' : '✗ ' . esc_html__( 'Enable HTTPS on production; localhost is not valid for underwriting', 'brimstone-hill' ); ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Page before payment (book / donate / member)', 'brimstone-hill' ); ?></td>
					<td>✓ <?php esc_html_e( 'Ticket, donation, and membership flows', 'brimstone-hill' ); ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Software up to date', 'brimstone-hill' ); ?></td>
					<td><?php esc_html_e( 'Update WordPress, WooCommerce, PHP, and plugins on production', 'brimstone-hill' ); ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Captcha (hosted payment / checkout)', 'brimstone-hill' ); ?></td>
					<td><?php esc_html_e( 'Embedded Collect.js: add reCAPTCHA/Turnstile on checkout (plugin) or enable in NMI hosted portal if used', 'brimstone-hill' ); ?></td>
				</tr>
			</tbody>
		</table>
		<form method="post" style="margin-top:1.5em">
			<?php wp_nonce_field( 'bh_seed_legal' ); ?>
			<button type="submit" name="bh_seed_legal" class="button button-primary"><?php esc_html_e( 'Create / refresh legal pages', 'brimstone-hill' ); ?></button>
		</form>
	</div>
	<?php
}

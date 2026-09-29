<?php
/**
 * Template Name: Membership
 *
 * @package Brimstone_Hill
 */

get_header();

if ( function_exists( 'bhfp_get_membership_categories' ) ) {
	$membership_categories = bhfp_get_membership_categories( true );
} else {
	$membership_categories = array(
		'captain'       => array(
			'name'          => 'Captain (Ordinary Member)',
			'price_display' => 'XCD$100.00',
			'product_id'    => 0,
			'image_id'      => 0,
			'benefits'      => array(
				'Free entry for yourself and 2 guests.',
				'10% discount at the restaurant.',
				'10% discount at the Gift Shop.',
			),
		),
		'governor'      => array(
			'name'          => 'Governor',
			'price_display' => 'XCD$1,000.00',
			'product_id'    => 0,
			'image_id'      => 0,
			'benefits'      => array(
				'Free entry for yourself and 5 guests.',
				'Free entry for yourself and 1 guest to paid events held by Brimstone Hill.',
				'10% discount at the restaurant.',
				'10% discount at the Gift Shop.',
			),
		),
		'corporate'     => array(
			'name'          => 'Corporate General',
			'price_display' => 'XCD$3,000.00',
			'product_id'    => 0,
			'image_id'      => 0,
			'benefits'      => array(
				'Free entry for CEO and 10 guests.',
				'10% discount at restaurant.',
				'10% discount at the Gift Shop.',
				'Hosting of two free events at Brimstone Hill Fortress.',
				'Acknowledgement in each issue of Cannonball.',
				'Placement of company logo on BHFNPS website.',
				'Company website link placed on BHFNPS website.',
			),
		),
		'lieutenant'    => array(
			'name'          => 'Lieutenant (University students & Professors)',
			'price_display' => 'XCD$60.00',
			'product_id'    => 0,
			'image_id'      => 0,
			'benefits'      => array(
				'Free entry for yourself and 1 guest.',
				'10% discount at the restaurant.',
				'10% discount at the Gift Shop.',
				'*Must present valid Student ID',
			),
		),
		'non-nationals' => array(
			'name'          => 'Non-Nationals',
			'price_display' => 'USD$100.00',
			'product_id'    => 0,
			'image_id'      => 0,
			'benefits'      => array(
				'Free entry for yourself and 2 guests.',
				'10% discount at the restaurant.',
				'10% discount at the Gift Shop.',
			),
		),
	);
}

$membership_checkout_ready = function_exists( 'bhfp_membership_checkout_is_ready' ) && bhfp_membership_checkout_is_ready();
$membership_form_categories = array();
foreach ( $membership_categories as $id => $cat ) {
	$pid = isset( $cat['product_id'] ) ? (int) $cat['product_id'] : 0;
	if ( $pid && function_exists( 'bhfp_validate_wc_product_type' ) && bhfp_validate_wc_product_type( $pid, 'bhfp_membership' ) ) {
		$membership_form_categories[ $id ] = $cat;
	}
}

$membership_benefits = array(
	'Support the maintenance and restoration of this national treasure',
	'Help promote a better understanding of our history and culture',
	'You enjoy free admission for yourself and guests',
	'10% discount from the Restaurant and Bar',
	'10% discount from the Gift Shop',
	'You are entitled to vote for a member of your choice to serve on the Council of Management and even to become an Officer of the Society',
);

$contact_url = site_url( '/about/contact' );

?>

<main id="main-content" class="site-main page-membership">
	<div class="page-banner page-banner--fallback">
		<div class="page-banner__overlay" aria-hidden="true"></div>
		<div class="page-banner__inner container">
			<h1 class="page-banner__title"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="container section-padding">
		<?php if ( ! $membership_checkout_ready ) : ?>
			<p class="membership-page__notice notice">
				<?php esc_html_e( 'Online membership checkout is not available yet. Please contact the office for assistance.', 'brimstone-hill' ); ?>
			</p>
		<?php endif; ?>

		<section class="membership-intro text-center">
			<h2 class="membership-intro__headline"><?php esc_html_e( 'Support the preservation of our national treasure and enjoy', 'brimstone-hill' ); ?></h2>
			<p class="membership-intro__blurb lead-text">
				<?php esc_html_e( 'The Brimstone Hill Fortress National Park Society is a non-profit voluntary organisation entrusted with the important responsibility of managing one of the outstanding cultural heritage sites of the Americas.', 'brimstone-hill' ); ?>
			</p>
		</section>

		<section class="membership-benefits-section mt-section">
			<h3 class="text-center"><?php esc_html_e( 'By being a member you:', 'brimstone-hill' ); ?></h3>
			<ul class="membership-benefits-list">
				<?php foreach ( $membership_benefits as $benefit ) : ?>
					<li>
						<span class="benefit-icon" aria-hidden="true">✓</span>
						<?php echo esc_html( $benefit ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>

		<section class="membership-categories-section mt-section" data-membership-cards>
			<div class="membership-categories__toolbar">
				<h3 class="membership-categories__title"><?php esc_html_e( 'Membership Categories', 'brimstone-hill' ); ?></h3>
				<div class="membership-view-toggle" role="group" aria-label="<?php esc_attr_e( 'Card display mode', 'brimstone-hill' ); ?>">
					<button type="button" class="membership-view-toggle__btn is-active" data-membership-view="flip" aria-pressed="true">
						<?php esc_html_e( 'Flip cards', 'brimstone-hill' ); ?>
					</button>
					<button type="button" class="membership-view-toggle__btn" data-membership-view="flat" aria-pressed="false">
						<?php esc_html_e( 'Regular cards', 'brimstone-hill' ); ?>
					</button>
				</div>
			</div>

			<div class="membership-grid membership-grid--flip" data-membership-grid>
				<?php foreach ( $membership_categories as $id => $cat ) : ?>
					<?php
					$image_id  = isset( $cat['image_id'] ) ? (int) $cat['image_id'] : 0;
					$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium_large' ) : '';
					$benefits  = ! empty( $cat['benefits'] ) && is_array( $cat['benefits'] ) ? $cat['benefits'] : array();
					$card_label = sprintf(
						/* translators: %s: membership category name */
						__( 'Flip card for %s', 'brimstone-hill' ),
						isset( $cat['name'] ) ? (string) $cat['name'] : ''
					);
					?>
					<div class="membership-card" data-membership-card tabindex="0" role="button" aria-pressed="false" aria-label="<?php echo esc_attr( $card_label ); ?>">
						<div class="membership-card__inner">
							<div class="membership-card__face membership-card__face--front">
								<?php if ( $image_url ) : ?>
									<div class="membership-card__image">
										<img src="<?php echo esc_url( $image_url ); ?>" alt="" loading="lazy" />
									</div>
								<?php endif; ?>
								<div class="membership-card__header">
									<h4 class="membership-card__name"><?php echo esc_html( (string) $cat['name'] ); ?></h4>
									<p class="membership-card__price"><?php echo esc_html( (string) $cat['price_display'] ); ?></p>
								</div>
								<p class="membership-card__hint" aria-hidden="true"><?php esc_html_e( 'Tap to see benefits', 'brimstone-hill' ); ?></p>
							</div>
							<div class="membership-card__face membership-card__face--back">
								<div class="membership-card__header">
									<h4 class="membership-card__name"><?php echo esc_html( (string) $cat['name'] ); ?></h4>
									<p class="membership-card__price"><?php echo esc_html( (string) $cat['price_display'] ); ?></p>
								</div>
								<ul class="membership-card__benefits">
									<?php foreach ( $benefits as $b ) : ?>
										<li><?php echo esc_html( $b ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<div class="membership-card__flat">
							<?php if ( $image_url ) : ?>
								<div class="membership-card__image">
									<img src="<?php echo esc_url( $image_url ); ?>" alt="" loading="lazy" />
								</div>
							<?php endif; ?>
							<div class="membership-card__header">
								<h4 class="membership-card__name"><?php echo esc_html( (string) $cat['name'] ); ?></h4>
								<p class="membership-card__price"><?php echo esc_html( (string) $cat['price_display'] ); ?></p>
							</div>
							<ul class="membership-card__benefits">
								<?php foreach ( $benefits as $b ) : ?>
									<li><?php echo esc_html( $b ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>

	<section class="membership-cta-banner" data-membership-cta aria-labelledby="membership-cta-heading">
		<div class="membership-cta-banner__scene" data-membership-cta-scene>
			<div class="membership-cta-banner__face membership-cta-banner__face--front">
				<div class="container membership-cta-banner__inner">
					<div class="membership-cta-banner__copy">
						<h2 id="membership-cta-heading"><?php esc_html_e( 'Become A Member Now!', 'brimstone-hill' ); ?></h2>
						<div class="membership-cta-banner__contact">
							<p><strong><?php esc_html_e( 'Brimstone Hill Fortress National Park', 'brimstone-hill' ); ?></strong></p>
							<p><?php esc_html_e( "P.O. Box 588 Taylor's Range", 'brimstone-hill' ); ?><br><?php esc_html_e( 'Basseterre', 'brimstone-hill' ); ?><br><?php esc_html_e( 'St. Kitts, West Indies', 'brimstone-hill' ); ?></p>
							<p class="phone"><a href="tel:869-465-2609">869-465-2609</a></p>
						</div>
						<button type="button" class="btn btn--primary" data-membership-cta-open>
							<?php esc_html_e( 'Register Here!', 'brimstone-hill' ); ?>
						</button>
					</div>
				</div>
			</div>
			<div class="membership-cta-banner__face membership-cta-banner__face--back" hidden>
				<div class="container membership-cta-banner__inner membership-cta-banner__inner--form">
					<div class="membership-join-layout">
						<div class="membership-form-wrapper">
							<div class="membership-form-wrapper__top">
								<h3><?php esc_html_e( 'Register Here!', 'brimstone-hill' ); ?></h3>
								<button type="button" class="btn btn--secondary btn--sm" data-membership-cta-close>
									<?php esc_html_e( 'Back', 'brimstone-hill' ); ?>
								</button>
							</div>
							<form id="bhfp-membership-form" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="membership-form">
								<input type="hidden" name="action" value="bhfp_process_membership_form">
								<?php wp_nonce_field( 'bhfp_membership_form', 'bhfp_membership_nonce' ); ?>

								<div class="form-group">
									<label for="member_full_name"><?php esc_html_e( 'Full Name', 'brimstone-hill' ); ?> <span aria-hidden="true">*</span></label>
									<input type="text" id="member_full_name" name="full_name" class="form-control" required>
								</div>

								<div class="form-group row">
									<div class="col">
										<label for="member_email"><?php esc_html_e( 'Email', 'brimstone-hill' ); ?> <span aria-hidden="true">*</span></label>
										<input type="email" id="member_email" name="email" class="form-control" required>
									</div>
									<div class="col">
										<label for="member_phone"><?php esc_html_e( 'Phone', 'brimstone-hill' ); ?> <span aria-hidden="true">*</span></label>
										<input type="tel" id="member_phone" name="phone" class="form-control" required>
									</div>
								</div>

								<div class="form-group">
									<label for="member_category"><?php esc_html_e( 'Membership Category', 'brimstone-hill' ); ?> <span aria-hidden="true">*</span></label>
									<select id="member_category" name="category" class="form-control" required>
										<option value=""><?php esc_html_e( 'Select category', 'brimstone-hill' ); ?></option>
										<?php foreach ( $membership_form_categories as $id => $cat ) : ?>
											<option value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $cat['name'] ); ?> — <?php echo esc_html( $cat['price_display'] ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<p class="description form-note"><?php esc_html_e( 'This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.', 'brimstone-hill' ); ?></p>

								<button type="submit" class="btn btn--primary btn--block" <?php disabled( ! $membership_checkout_ready ); ?>>
									<?php esc_html_e( 'Register & Proceed to Payment', 'brimstone-hill' ); ?>
								</button>
							</form>
						</div>

						<div class="membership-contact-wrapper">
							<div class="contact-box">
								<h4><?php esc_html_e( 'Brimstone Hill Fortress National Park', 'brimstone-hill' ); ?></h4>
								<p><?php esc_html_e( "P.O. Box 588 Taylor's Range", 'brimstone-hill' ); ?><br><?php esc_html_e( 'Basseterre', 'brimstone-hill' ); ?><br><?php esc_html_e( 'St. Kitts, West Indies', 'brimstone-hill' ); ?></p>
								<p class="phone"><a href="tel:869-465-2609">869-465-2609</a></p>
								<hr>
								<p class="corporate-note"><?php esc_html_e( 'Contact our office for additional offerings on Corporate packages.', 'brimstone-hill' ); ?></p>
								<a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn--secondary mt-sm"><?php esc_html_e( 'Contact Us', 'brimstone-hill' ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();

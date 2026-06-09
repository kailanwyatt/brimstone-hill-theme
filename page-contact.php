<?php
/**
 * Contact page template.
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();

	$intro_heading = bh_get_contact_setting( 'bh_contact_intro_heading', __( 'Get in touch', 'brimstone-hill' ) );
	$intro_lead    = bh_get_contact_setting( 'bh_contact_intro_lead', __( 'The head office handles membership, group bookings, and general enquiries. The fortress visitor centre is open daily for on-site questions and admissions.', 'brimstone-hill' ) );
	$intro_note    = bh_get_contact_setting( 'bh_contact_intro_note', __( 'We aim to reply to all enquiries as soon as possible during business hours.', 'brimstone-hill' ) );

	$office_title   = bh_get_contact_setting( 'bh_contact_office_title', "Head Office — Taylor's Range" );
	$office_address = bh_get_contact_setting( 'bh_contact_office_address', "P.O. Box 588 Taylor's Range\nBasseterre\nSt. Kitts, West Indies" );
	$office_phone   = bh_get_contact_setting( 'bh_contact_office_phone', '869-465-2609' );
	$office_email   = bh_get_contact_setting( 'bh_contact_office_email', 'info@brimstonehillfortress.org' );
	$office_desc    = bh_get_contact_setting( 'bh_contact_office_description', __( 'For membership, donations, group visits, school bookings, and general enquiries.', 'brimstone-hill' ) );

	$fortress_title       = bh_get_contact_setting( 'bh_contact_fortress_title', 'Fortress — New Guinea' );
	$fortress_address     = bh_get_contact_setting( 'bh_contact_fortress_address', "Brimstone Hill Fortress National Park\nSt. Kitts, West Indies" );
	$fortress_phone       = bh_get_contact_setting( 'bh_contact_fortress_phone', '869-465-6771' );
	$fortress_email       = bh_get_contact_setting( 'bh_contact_fortress_email', 'info@brimstonehillfortress.org' );
	$fortress_hours       = bh_get_contact_setting( 'bh_contact_fortress_hours', 'Open daily 9:30am–5:30pm' );
	$fortress_desc        = bh_get_contact_setting( 'bh_contact_fortress_description', __( 'On-site visitor centre, admissions, and directions for your visit to the fortress.', 'brimstone-hill' ) );
	$directions_path      = bh_get_contact_setting( 'bh_contact_fortress_directions_url', '/visit/directions/' );
	$directions_url       = ( 0 === strpos( $directions_path, 'http' ) ) ? $directions_path : home_url( $directions_path );
	$cf7_shortcode        = bh_get_contact_setting( 'bh_contact_cf7_shortcode', '' );
	?>
<main id="main-content" class="bh-page content-page content-page--wide contact-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>
		</div>
		</div>

		<section class="contact-panel contact-panel--locations" aria-label="<?php esc_attr_e( 'Contact locations', 'brimstone-hill' ); ?>">
			<div class="container">
				<header class="contact-panel__header contact-panel__header--center">
					<h2 class="contact-panel__title"><?php echo esc_html( $intro_heading ); ?></h2>
					<?php if ( '' !== trim( $intro_lead ) ) : ?>
						<p class="contact-panel__lead"><?php echo esc_html( $intro_lead ); ?></p>
					<?php endif; ?>
					<?php if ( '' !== trim( $intro_note ) ) : ?>
						<p class="contact-panel__note"><?php echo esc_html( $intro_note ); ?></p>
					<?php endif; ?>
				</header>

				<div class="contact-locations-grid">
					<div class="contact-location">
						<div class="contact-location__icon" aria-hidden="true">
							<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/></svg>
						</div>
						<h3 class="contact-location__title"><?php echo esc_html( $office_title ); ?></h3>
						<?php if ( '' !== trim( $office_desc ) ) : ?>
							<p class="contact-location__desc"><?php echo esc_html( $office_desc ); ?></p>
						<?php endif; ?>
						<div class="contact-location__details">
							<?php if ( '' !== trim( $office_address ) ) : ?>
								<p class="contact-location__address"><?php echo nl2br( esc_html( $office_address ) ); ?></p>
							<?php endif; ?>
							<?php if ( '' !== trim( $office_phone ) ) : ?>
								<p class="contact-location__phone">
									<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $office_phone ) ); ?>"><?php echo esc_html( $office_phone ); ?></a>
								</p>
							<?php endif; ?>
							<?php if ( '' !== trim( $office_email ) ) : ?>
								<p class="contact-location__email">
									<a href="<?php echo esc_url( 'mailto:' . $office_email ); ?>"><?php echo esc_html( $office_email ); ?></a>
								</p>
							<?php endif; ?>
						</div>
					</div>

					<div class="contact-location">
						<div class="contact-location__icon" aria-hidden="true">
							<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
						</div>
						<h3 class="contact-location__title"><?php echo esc_html( $fortress_title ); ?></h3>
						<?php if ( '' !== trim( $fortress_desc ) ) : ?>
							<p class="contact-location__desc"><?php echo esc_html( $fortress_desc ); ?></p>
						<?php endif; ?>
						<div class="contact-location__details">
							<?php if ( '' !== trim( $fortress_address ) ) : ?>
								<p class="contact-location__address"><?php echo nl2br( esc_html( $fortress_address ) ); ?></p>
							<?php endif; ?>
							<?php if ( '' !== trim( $fortress_hours ) ) : ?>
								<p class="contact-location__hours"><?php echo esc_html( $fortress_hours ); ?></p>
							<?php endif; ?>
							<?php if ( '' !== trim( $fortress_phone ) ) : ?>
								<p class="contact-location__phone">
									<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $fortress_phone ) ); ?>"><?php echo esc_html( $fortress_phone ); ?></a>
								</p>
							<?php endif; ?>
							<?php if ( '' !== trim( $fortress_email ) ) : ?>
								<p class="contact-location__email">
									<a href="<?php echo esc_url( 'mailto:' . $fortress_email ); ?>"><?php echo esc_html( $fortress_email ); ?></a>
								</p>
							<?php endif; ?>
							<p class="contact-location__directions">
								<a href="<?php echo esc_url( $directions_url ); ?>"><?php esc_html_e( 'Get directions', 'brimstone-hill' ); ?></a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="contact-panel contact-panel--form" aria-label="<?php esc_attr_e( 'Contact form', 'brimstone-hill' ); ?>">
			<div class="container">
				<header class="contact-panel__header contact-panel__header--center">
					<div class="contact-panel__icon" aria-hidden="true">
						<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16v16H4z"/><path d="m22 6-10 7L2 6"/></svg>
					</div>
					<h2 class="contact-panel__title"><?php esc_html_e( 'Send us a message', 'brimstone-hill' ); ?></h2>
				</header>
				<?php if ( '' !== trim( $cf7_shortcode ) && shortcode_exists( 'contact-form-7' ) ) : ?>
					<div class="contact-form">
						<?php echo do_shortcode( $cf7_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php else : ?>
					<p class="contact-panel__note contact-panel__note--center"><?php esc_html_e( 'Install Contact Form 7 and add the form shortcode under Appearance → Contact Settings.', 'brimstone-hill' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
	</article>
</main>
	<?php
endwhile;

get_footer();

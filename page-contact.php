<?php
/**
 * Contact page template.
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();

	$office_title   = bh_get_contact_setting( 'bh_contact_office_title', "Head Office — Taylor's Range" );
	$office_address = bh_get_contact_setting( 'bh_contact_office_address', "P.O. Box 588 Taylor's Range\nBasseterre\nSt. Kitts, West Indies" );
	$office_phone   = bh_get_contact_setting( 'bh_contact_office_phone', '869-465-2609' );
	$office_email   = bh_get_contact_setting( 'bh_contact_office_email', 'info@brimstonehillfortress.org' );

	$fortress_title    = bh_get_contact_setting( 'bh_contact_fortress_title', 'Fortress — New Guinea' );
	$fortress_address  = bh_get_contact_setting( 'bh_contact_fortress_address', "Brimstone Hill Fortress National Park\nSt. Kitts, West Indies" );
	$fortress_phone    = bh_get_contact_setting( 'bh_contact_fortress_phone', '869-465-6771' );
	$fortress_email    = bh_get_contact_setting( 'bh_contact_fortress_email', 'info@brimstonehillfortress.org' );
	$fortress_hours    = bh_get_contact_setting( 'bh_contact_fortress_hours', 'Open daily 9:30am–5:30pm' );
	$directions_path   = bh_get_contact_setting( 'bh_contact_fortress_directions_url', '/visit/directions/' );
	$directions_url    = ( 0 === strpos( $directions_path, 'http' ) ) ? $directions_path : home_url( $directions_path );
	$cf7_shortcode     = bh_get_contact_setting( 'bh_contact_cf7_shortcode', '' );
	?>
<main id="main-content" class="bh-page content-page contact-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>

		<div class="content-page__body content-page__body--full">
			<div class="contact-page__layout">
				<section class="contact-page__locations" aria-label="<?php esc_attr_e( 'Contact locations', 'brimstone-hill' ); ?>">
					<div class="contact-locations">
						<div class="contact-location-card">
							<h2 class="contact-location-card__title"><?php echo esc_html( $office_title ); ?></h2>
							<ul class="contact-location-card__list">
								<?php if ( '' !== trim( $office_address ) ) : ?>
									<li class="contact-location-card__item contact-location-card__item--address">
										<span class="contact-location-card__icon" aria-hidden="true">
											<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
										</span>
										<span><?php echo nl2br( esc_html( $office_address ) ); ?></span>
									</li>
								<?php endif; ?>
								<?php if ( '' !== trim( $office_phone ) ) : ?>
									<li class="contact-location-card__item">
										<span class="contact-location-card__icon" aria-hidden="true">
											<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.86.33 1.7.62 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.19a2 2 0 0 1 2.11-.45c.8.29 1.64.5 2.5.62A2 2 0 0 1 22 16.92Z"/></svg>
										</span>
										<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $office_phone ) ); ?>"><?php echo esc_html( $office_phone ); ?></a>
									</li>
								<?php endif; ?>
								<?php if ( '' !== trim( $office_email ) ) : ?>
									<li class="contact-location-card__item">
										<span class="contact-location-card__icon" aria-hidden="true">
											<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="m22 6-10 7L2 6"/></svg>
										</span>
										<a href="<?php echo esc_url( 'mailto:' . $office_email ); ?>"><?php echo esc_html( $office_email ); ?></a>
									</li>
								<?php endif; ?>
							</ul>
						</div>

						<div class="contact-location-card">
							<h2 class="contact-location-card__title"><?php echo esc_html( $fortress_title ); ?></h2>
							<ul class="contact-location-card__list">
								<?php if ( '' !== trim( $fortress_address ) ) : ?>
									<li class="contact-location-card__item contact-location-card__item--address">
										<span class="contact-location-card__icon" aria-hidden="true">
											<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
										</span>
										<span><?php echo nl2br( esc_html( $fortress_address ) ); ?></span>
									</li>
								<?php endif; ?>
								<?php if ( '' !== trim( $fortress_phone ) ) : ?>
									<li class="contact-location-card__item">
										<span class="contact-location-card__icon" aria-hidden="true">
											<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.86.33 1.7.62 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.19a2 2 0 0 1 2.11-.45c.8.29 1.64.5 2.5.62A2 2 0 0 1 22 16.92Z"/></svg>
										</span>
										<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $fortress_phone ) ); ?>"><?php echo esc_html( $fortress_phone ); ?></a>
									</li>
								<?php endif; ?>
								<?php if ( '' !== trim( $fortress_email ) ) : ?>
									<li class="contact-location-card__item">
										<span class="contact-location-card__icon" aria-hidden="true">
											<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="m22 6-10 7L2 6"/></svg>
										</span>
										<a href="<?php echo esc_url( 'mailto:' . $fortress_email ); ?>"><?php echo esc_html( $fortress_email ); ?></a>
									</li>
								<?php endif; ?>
								<?php if ( '' !== trim( $fortress_hours ) ) : ?>
									<li class="contact-location-card__item">
										<span class="contact-location-card__icon" aria-hidden="true">
											<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
										</span>
										<span><?php echo esc_html( $fortress_hours ); ?></span>
									</li>
								<?php endif; ?>
								<li class="contact-location-card__item">
									<span class="contact-location-card__icon" aria-hidden="true">
										<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l19-9-9 19-2-8-8-2Z"/></svg>
									</span>
									<a href="<?php echo esc_url( $directions_url ); ?>"><?php esc_html_e( 'Get directions', 'brimstone-hill' ); ?></a>
								</li>
							</ul>
						</div>
					</div>
				</section>

				<section class="contact-page__form" aria-label="<?php esc_attr_e( 'Contact form', 'brimstone-hill' ); ?>">
					<h2 class="contact-page__form-title"><?php esc_html_e( 'Send us a message', 'brimstone-hill' ); ?></h2>
					<?php if ( '' !== trim( $cf7_shortcode ) && shortcode_exists( 'contact-form-7' ) ) : ?>
						<div class="contact-form">
							<?php echo do_shortcode( $cf7_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					<?php else : ?>
						<p class="contact-page__form-note"><?php esc_html_e( 'Install Contact Form 7 and add the form shortcode under Appearance → Contact Settings.', 'brimstone-hill' ); ?></p>
					<?php endif; ?>
					<?php if ( get_the_content() ) : ?>
						<div class="contact-page__extra content-page__main--prose">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
				</section>
			</div>
		</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

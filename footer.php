<?php
/**
 * The template for displaying the footer
 *
 * @package Brimstone_Hill
 */

$brand         = bh_footer_brand_text();
$about_text    = bh_footer_about_text();
$footer_cols   = bh_footer_nav_columns();
$bottom_links  = bh_footer_bottom_links();
$staff_footer  = function_exists( 'bhfp_footer_staff_link' ) ? bhfp_footer_staff_link() : array(
	'url'   => bh_staff_login_url(),
	'label' => __( 'Staff login', 'brimstone-hill' ),
);
$tripadvisor   = function_exists( 'bh_tripadvisor_url' ) ? bh_tripadvisor_url() : '';
?>

<footer class="site-footer">
	<div class="site-footer__inner container">
		<div class="site-footer__grid">
			<div class="site-footer__col site-footer__col--about">
				<div class="site-footer__brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__brand-name"><?php echo esc_html( $brand ); ?></a>
					<?php endif; ?>
				</div>
				<?php if ( '' !== $about_text ) : ?>
					<p class="site-footer__about"><?php echo esc_html( $about_text ); ?></p>
				<?php endif; ?>
				<p class="site-footer__cta">
					<a href="<?php echo esc_url( bh_book_tickets_url() ); ?>" class="btn btn--secondary btn--sm"><?php echo esc_html( bh_book_tickets_label() ); ?></a>
				</p>
				<?php if ( '' !== $tripadvisor ) : ?>
					<p class="site-footer__social">
						<a href="<?php echo esc_url( $tripadvisor ); ?>" class="site-footer__external" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Reviews on Tripadvisor', 'brimstone-hill' ); ?></a>
					</p>
				<?php endif; ?>
			</div>

			<?php foreach ( $footer_cols as $col ) : ?>
				<div class="site-footer__col site-footer__col--nav">
					<h2 class="site-footer__heading"><?php echo esc_html( $col['title'] ); ?></h2>
					<?php bh_render_footer_nav( $col['location'], $col['links'] ); ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="site-footer__bottom">
			<?php if ( ! empty( $bottom_links ) ) : ?>
				<nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Legal and policies', 'brimstone-hill' ); ?>">
					<?php foreach ( $bottom_links as $link ) : ?>
						<a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>

			<?php if ( function_exists( 'bh_render_accepted_card_logos' ) ) : ?>
				<?php bh_render_accepted_card_logos( array( 'class' => 'bh-accepted-cards bh-accepted-cards--footer' ) ); ?>
			<?php endif; ?>

			<p class="site-footer__copy">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $brand ); ?>.
				<?php esc_html_e( 'All rights reserved.', 'brimstone-hill' ); ?>
				<span class="site-footer__staff-wrap">
					<a href="<?php echo esc_url( $staff_footer['url'] ); ?>" class="site-footer__staff"><?php echo esc_html( $staff_footer['label'] ); ?></a>
				</span>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

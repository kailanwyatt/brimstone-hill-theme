<?php
/**
 * Home Featured Promo section
 */

$bg_image = BH_THEME_URI . '/assets/images/img-04.jpg';
$title = get_option('bh_home_promo_title', 'Emancipation Festival');
$text = get_option('bh_home_promo_text', 'Celebrate freedom and heritage with live music, storytelling, and traditional food. Join us for one of the Caribbean\'s most significant cultural events at the fortress.');
?>
<section class="featured-promo" style="background-image: url('<?php echo esc_url( $bg_image ); ?>')">
	<div class="featured-promo__overlay" aria-hidden="true"></div>
	<div class="container">
		<div class="featured-promo__content">
			<h2 class="featured-promo__title"><?php echo esc_html( $title ); ?></h2>
			<p class="featured-promo__text"><?php echo esc_html( $text ); ?></p>
			<div class="featured-promo__actions">
				<a href="<?php echo esc_url( home_url( '/events/annual-events' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Find out more', 'brimstone-hill' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/visit/book-tickets' ) ); ?>" class="btn btn--secondary"><?php esc_html_e( 'Book tickets', 'brimstone-hill' ); ?></a>
			</div>
		</div>
	</div>
</section>

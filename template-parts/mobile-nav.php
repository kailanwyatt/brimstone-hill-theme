<?php
/**
 * Mobile navigation panel (primary menu).
 *
 * @package Brimstone_Hill
 */

if ( ! has_nav_menu( 'primary' ) ) {
	return;
}
?>
<div class="mobile-nav__backdrop" id="mobile-nav-backdrop" hidden aria-hidden="true"></div>
<nav id="mobile-nav" class="mobile-nav" aria-label="<?php esc_attr_e( 'Mobile menu', 'brimstone-hill' ); ?>" hidden>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'mobile-menu',
			'container'      => false,
			'menu_class'     => 'mobile-nav__list',
			'fallback_cb'    => false,
			'walker'         => new BH_Mobile_Walker_Nav_Menu(),
		)
	);
	?>
	<a href="<?php echo esc_url( bh_book_tickets_url() ); ?>" class="btn btn--primary mobile-nav__cta">
		<?php echo esc_html( bh_book_tickets_label() ); ?>
	</a>
</nav>

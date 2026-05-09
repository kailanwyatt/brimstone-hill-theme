<?php
/**
 * Announcement Bar (Top Bar)
 */

$enabled = get_theme_mod( 'bh_announcement_enabled', true );
$text    = get_theme_mod( 'bh_announcement_text', 'Open daily 9:30am–5:30pm · Book your visit today' );

if ( ! $enabled || empty( $text ) ) {
	return;
}
?>
<div class="top-bar">
	<div class="top-bar__inner container">
		<p class="top-bar__message"><?php echo wp_kses_post( $text ); ?></p>
		<nav class="top-bar__links" aria-label="Quick links">
			<a href="<?php echo esc_url( home_url( '/visit/book-tickets' ) ); ?>" class="top-bar__link">Book now</a>
			<a href="<?php echo esc_url( home_url( '/get-involved/donate' ) ); ?>" class="top-bar__link">Donate</a>
			<a href="<?php echo esc_url( home_url( '/events/whats-on' ) ); ?>" class="top-bar__link">What's on</a>
			<a href="<?php echo esc_url( home_url( '/about/contact' ) ); ?>" class="top-bar__link">Contact</a>
		</nav>
	</div>
</div>

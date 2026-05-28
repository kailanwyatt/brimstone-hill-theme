<?php
/**
 * Home Welcome section (headline and CTAs below the hero video).
 *
 * @package Brimstone_Hill
 */

$default_title = 'Welcome to Brimstone Hill Fortress National Park UNESCO World Heritage Site';
$stored_title  = get_option( 'bh_home_welcome_title', '' );
$hero_title    = get_option( 'bh_home_hero_title', $default_title );

if ( '' === trim( (string) $stored_title ) || 'Welcome!' === $stored_title ) {
	$title = $hero_title ? $hero_title : $default_title;
} else {
	$title = $stored_title;
}

$eyebrow  = __( 'UNESCO World Heritage Site · St. Kitts & Nevis', 'brimstone-hill' );
$headline = $title;
if ( preg_match( '/\bUNESCO\b/i', $title ) ) {
	$headline = trim( (string) preg_replace( '/\s*UNESCO\s+World\s+Heritage\s+Site\s*/i', ' ', $title ) );
	if ( '' === $headline ) {
		$headline = __( 'Welcome to Brimstone Hill Fortress National Park', 'brimstone-hill' );
	}
}

$default_text = '<p>' . esc_html__(
	'Explore one of the best preserved historical fortifications in the Americas — a monument to engineering, endurance, and Caribbean heritage. Plan your visit, walk the citadel, and take in views across St. Kitts and Nevis.',
	'brimstone-hill'
) . '</p>';
$text = get_option( 'bh_home_welcome_text', '' );
if ( '' === trim( wp_strip_all_tags( (string) $text ) ) ) {
	$hero_subtitle = trim( (string) get_option( 'bh_home_hero_subtitle', '' ) );
	$text          = $hero_subtitle ? '<p>' . esc_html( $hero_subtitle ) . '</p>' : $default_text;
}

$hours_line = trim( (string) get_option( 'bh_home_admission_hours', 'Open daily 9:30am–5:30pm' ) );
$hours_url  = home_url( '/visit/hours-admission/' );
?>
<section class="welcome-section" aria-labelledby="welcome-section-title">
	<div class="container">
		<div class="welcome-section__panel">
			<p class="welcome-section__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h1 id="welcome-section-title" class="welcome-section__title"><?php echo esc_html( $headline ); ?></h1>
			<div class="welcome-section__intro"><?php echo wp_kses_post( $text ); ?></div>
			<?php if ( '' !== $hours_line ) : ?>
				<p class="welcome-section__hours">
					<span class="welcome-section__hours-badge" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
					</span>
					<span class="welcome-section__hours-text"><?php echo esc_html( $hours_line ); ?></span>
					<a class="welcome-section__hours-link" href="<?php echo esc_url( $hours_url ); ?>"><?php esc_html_e( 'Hours & admission', 'brimstone-hill' ); ?></a>
				</p>
			<?php endif; ?>
			<div class="welcome-section__actions">
				<a href="<?php echo esc_url( bh_book_tickets_url() ); ?>" class="btn btn--primary"><?php echo esc_html( bh_book_tickets_label() ); ?></a>
				<a href="<?php echo esc_url( home_url( '/visit/plan-your-visit' ) ); ?>" class="btn btn--secondary"><?php esc_html_e( 'Plan your visit', 'brimstone-hill' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/events/whats-on' ) ); ?>" class="btn btn--secondary"><?php esc_html_e( "What's on", 'brimstone-hill' ); ?></a>
			</div>
		</div>
	</div>
</section>

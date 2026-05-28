<?php
/**
 * Home What's On section
 *
 * @package Brimstone_Hill
 */

$events = array();
if ( function_exists( 'bhfp_homepage_upcoming_events' ) ) {
	$events = bhfp_homepage_upcoming_events( 3 );
}

if ( empty( $events ) ) {
	$events = array(
		array(
			'date_display' => 'August 2025',
			'title'        => 'Emancipation Festival',
			'description'  => 'Celebrate freedom and heritage with live music, storytelling, and traditional food.',
			'url'          => home_url( '/events/whats-on#emancipation-festival' ),
		),
		array(
			'date_display' => 'March 2025',
			'title'        => 'Annual Fund Run',
			'description'  => 'Join the community run through the historic grounds. All ages welcome.',
			'url'          => home_url( '/events/whats-on#annual-fund-run' ),
		),
		array(
			'date_display' => 'Ongoing',
			'title'        => 'Guided Fort Tour',
			'description'  => 'Explore the fortress with an expert guide. Book in advance or join a daily tour.',
			'url'          => home_url( '/events/whats-on#guided-fort-tour' ),
		),
	);
}

$whats_on_url = function_exists( 'bhfp_page_url' ) ? bhfp_page_url( 'events/whats-on' ) : home_url( '/events/whats-on/' );
?>
<section class="whats-on">
	<div class="container">
		<h2 class="section-title"><?php esc_html_e( "See what's happening at Brimstone Hill", 'brimstone-hill' ); ?></h2>
		<p class="whats-on__intro"><?php esc_html_e( 'All upcoming events', 'brimstone-hill' ); ?></p>

		<div class="card-grid">
			<?php foreach ( $events as $event ) : ?>
				<article class="event-card">
					<div class="event-card__date">
						<?php
						$date_label = (string) ( $event['date_display'] ?? '' );
						$parts      = preg_split( '/\s+/', trim( $date_label ), 2 );
						if ( count( $parts ) >= 2 && ! preg_match( '/^\d{4}-\d{2}-\d{2}/', $date_label ) ) {
							echo '<span class="event-card__month">' . esc_html( substr( $parts[0], 0, 3 ) ) . '</span>';
							echo '<span class="event-card__day">' . esc_html( $parts[1] ) . '</span>';
						} else {
							echo '<span class="event-card__month">' . esc_html( $date_label ) . '</span>';
						}
						?>
					</div>
					<div class="event-card__content">
						<h3 class="event-card__title"><?php echo esc_html( $event['title'] ); ?></h3>
						<p class="event-card__excerpt"><?php echo esc_html( $event['description'] ); ?></p>
						<a href="<?php echo esc_url( $event['url'] ); ?>" class="event-card__link"><?php esc_html_e( 'Find out more', 'brimstone-hill' ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<p class="whats-on__more">
			<a href="<?php echo esc_url( $whats_on_url ); ?>" class="btn btn--secondary"><?php esc_html_e( 'View all events', 'brimstone-hill' ); ?></a>
		</p>
	</div>
</section>

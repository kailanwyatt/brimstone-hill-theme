<?php
/**
 * Home What's On section
 */

$events = array(
	array(
		'date' => 'August 2025',
		'title' => 'Emancipation Festival',
		'description' => 'Celebrate freedom and heritage with live music, storytelling, and traditional food.',
		'url' => '/events/whats-on#emancipation-festival',
	),
	array(
		'date' => 'March 2025',
		'title' => 'Annual Fund Run',
		'description' => 'Join the community run through the historic grounds. All ages welcome.',
		'url' => '/events/whats-on#annual-fund-run',
	),
	array(
		'date' => 'Ongoing',
		'title' => 'Guided Fort Tour',
		'description' => 'Explore the fortress with an expert guide. Book in advance or join a daily tour.',
		'url' => '/events/whats-on#guided-fort-tour',
	),
);
?>
<section class="whats-on">
	<div class="container">
		<h2 class="section-title">See what's happening at Brimstone Hill</h2>
		<p class="whats-on__intro">All upcoming events</p>

		<div class="card-grid">
			<?php foreach ( $events as $event ) : ?>
				<article class="event-card">
					<div class="event-card__date">
						<?php 
						// Basic parse of month and day if possible, else just dump it
						$parts = explode(' ', $event['date']);
						if (count($parts) >= 2) {
							echo '<span class="event-card__month">' . esc_html(substr($parts[0], 0, 3)) . '</span>';
							echo '<span class="event-card__day">' . esc_html($parts[1]) . '</span>';
						} else {
							echo '<span class="event-card__month">' . esc_html($event['date']) . '</span>';
						}
						?>
					</div>
					<div class="event-card__content">
						<h3 class="event-card__title"><?php echo esc_html( $event['title'] ); ?></h3>
						<p class="event-card__excerpt"><?php echo esc_html( $event['description'] ); ?></p>
						<a href="<?php echo esc_url( home_url( $event['url'] ) ); ?>" class="event-card__link">Find out more</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<p class="whats-on__more">
			<a href="<?php echo esc_url( home_url( '/events/whats-on' ) ); ?>" class="link--more">View all events</a>
		</p>
	</div>
</section>

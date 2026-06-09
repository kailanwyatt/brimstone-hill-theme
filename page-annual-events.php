<?php
/**
 * Annual events — page slug "annual-events" under Events (e.g. /events/annual-events).
 *
 * @package Brimstone_Hill
 */

if ( ! function_exists( 'bh_annual_events_static_content' ) ) {
	/**
	 * Trusted markup for the Annual events page (replaces broken imported React fragments).
	 *
	 * @return void
	 */
	function bh_annual_events_static_content() {
		$upcoming = class_exists( 'BHFP_Public_Chrome' ) ? BHFP_Public_Chrome::get_upcoming_events_display() : array();
		$annual_like = array();
		foreach ( $upcoming as $event ) {
			$title = isset( $event['title'] ) ? (string) $event['title'] : '';
			$type  = isset( $event['type'] ) ? strtolower( (string) $event['type'] ) : '';
			$is_annual = false !== stripos( $title, 'annual' ) || false !== stripos( $title, 'festival' ) || in_array( $type, array( 'festival', 'fundraiser', 'community' ), true );
			if ( $is_annual ) {
				$annual_like[] = $event;
			}
			if ( count( $annual_like ) >= 6 ) {
				break;
			}
		}
		?>
	<p>
		<?php esc_html_e( 'Annual events celebrate the culture and heritage of Brimstone Hill. Use this page for recurring highlights, then check the live calendar for exact dates and programme updates.', 'brimstone-hill' ); ?>
	</p>

	<section class="content-block">
		<h2 class="content-block__title"><?php esc_html_e( 'Recurring highlights', 'brimstone-hill' ); ?></h2>
		<?php if ( empty( $annual_like ) ) : ?>
			<p><?php esc_html_e( 'Annual programme details will be posted here as dates are confirmed. See the events calendar for the latest schedule.', 'brimstone-hill' ); ?></p>
		<?php else : ?>
			<ul class="calendar-list">
				<?php foreach ( $annual_like as $event ) : ?>
					<li class="calendar-list__item">
						<time class="calendar-list__date" datetime="<?php echo esc_attr( (string) $event['date'] ); ?>"><?php echo esc_html( BHFP_Public_Chrome::format_calendar_event_dates( $event ) ); ?></time>
						<span class="calendar-list__type"><?php echo esc_html( strtoupper( (string) $event['type'] ) ); ?></span>
						<h3 class="calendar-list__title">
							<a href="<?php echo esc_url( ! empty( $event['url'] ) ? (string) $event['url'] : home_url( '/events/calendar/' ) ); ?>"><?php echo esc_html( (string) $event['title'] ); ?></a>
						</h3>
						<?php if ( ! empty( $event['excerpt'] ) ) : ?>
							<p class="calendar-list__excerpt"><?php echo esc_html( (string) $event['excerpt'] ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<p class="annual-events__ctas">
			<a class="btn btn--secondary" href="<?php echo esc_url( home_url( '/events/whats-on/' ) ); ?>"><?php esc_html_e( 'What’s on', 'brimstone-hill' ); ?></a>
			<a class="btn btn--secondary" href="<?php echo esc_url( home_url( '/events/calendar/' ) ); ?>"><?php esc_html_e( 'Events calendar', 'brimstone-hill' ); ?></a>
		</p>
	</section>

		<?php if ( class_exists( 'BHFP_Public_Chrome' ) ) : ?>
	<section class="content-block content-block--calendar-teaser" aria-label="<?php esc_attr_e( 'Upcoming dates', 'brimstone-hill' ); ?>">
		<h2 class="content-block__title"><?php esc_html_e( 'Upcoming dates', 'brimstone-hill' ); ?></h2>
		<p class="content-block__lede"><?php esc_html_e( 'Upcoming dates from our events programme.', 'brimstone-hill' ); ?></p>
			<?php echo do_shortcode( '[bhfp_events_list limit="6" intro="0" calendar_link="1"]' ); ?>
	</section>
		<?php endif; ?>
		<?php
	}
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
<main id="main-content" class="bh-page content-page annual-events-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>
		<div class="content-page__body content-page__body--narrow">
			<div class="content-page__main content-page__main--prose">
				<?php bh_annual_events_static_content(); ?>
			</div>
		</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

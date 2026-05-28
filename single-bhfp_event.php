<?php
/**
 * Single Event template for BHFP event posts.
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();

	$event_id = get_the_ID();
	$start = class_exists( 'BHFP_Event' ) ? BHFP_Event::get_calendar_start_iso( $event_id ) : '';
	$end   = class_exists( 'BHFP_Event' ) ? (string) get_post_meta( $event_id, BHFP_Event::META_EVENT_END, true ) : '';
	$kind  = class_exists( 'BHFP_Event' ) ? (string) get_post_meta( $event_id, BHFP_Event::META_EVENT_KIND, true ) : '';
	$attendance = class_exists( 'BHFP_Event' ) ? BHFP_Event::get_attendance_type( $event_id ) : 'public';
	$display_title = class_exists( 'BHFP_Event' ) ? BHFP_Event::get_public_title( $event_id ) : get_the_title();
	if ( '' === $kind ) {
		$kind = __( 'Event', 'brimstone-hill' );
	}
	$attendance_label = ucfirst( str_replace( '_', ' ', $attendance ) );
	$calendar_url = home_url( '/events/calendar/' );

	$date_line = '';
	if ( class_exists( 'BHFP_Public_Chrome' ) && '' !== $start ) {
		$date_line = BHFP_Public_Chrome::format_calendar_event_dates(
			array(
				'date'    => $start,
				'endDate' => $end,
			)
		);
	}
	$ics_link = '';
	if ( '' !== $start ) {
		$ics_end = '' !== $end ? $end : $start;
		$ics  = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Brimstone Hill//Events//EN\r\nBEGIN:VEVENT\r\n";
		$ics .= 'UID:event-' . $event_id . '@' . wp_parse_url( home_url( '/' ), PHP_URL_HOST ) . "\r\n";
		$ics .= 'DTSTAMP:' . gmdate( 'Ymd\THis\Z' ) . "\r\n";
		$ics .= 'DTSTART;VALUE=DATE:' . gmdate( 'Ymd', strtotime( $start ) ) . "\r\n";
		$ics .= 'DTEND;VALUE=DATE:' . gmdate( 'Ymd', strtotime( $ics_end . ' +1 day' ) ) . "\r\n";
		$ics .= 'SUMMARY:' . preg_replace( '/[\r\n]+/', ' ', $display_title ) . "\r\n";
		$ics .= 'DESCRIPTION:' . preg_replace( '/[\r\n]+/', ' ', wp_strip_all_tags( get_the_excerpt() ) ) . "\r\n";
		$ics .= 'URL:' . get_permalink() . "\r\nEND:VEVENT\r\nEND:VCALENDAR\r\n";
		$ics_link = 'data:text/calendar;charset=utf-8,' . rawurlencode( $ics );
	}
	$schema = array(
		'@context'           => 'https://schema.org',
		'@type'              => 'Event',
		'name'               => $display_title,
		'startDate'          => $start,
		'endDate'            => '' !== $end ? $end : $start,
		'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
		'eventStatus'        => 'https://schema.org/EventScheduled',
		'url'                => get_permalink(),
		'description'        => wp_strip_all_tags( get_the_excerpt() ),
		'location'           => array(
			'@type' => 'Place',
			'name'  => __( 'Brimstone Hill Fortress National Park', 'brimstone-hill' ),
		),
	);
	$linked_albums = array();
	if ( defined( 'BHFP_GALLERY_POST_TYPE' ) && defined( 'BHFP_GALLERY_META_EVENT_ID' ) ) {
		$linked_albums = get_posts(
			array(
				'post_type'      => BHFP_GALLERY_POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => 6,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'meta_key'       => BHFP_GALLERY_META_EVENT_ID,
				'meta_value'     => $event_id,
			)
		);
	}
	?>
<main id="main-content" class="bh-page content-page single-event-page">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="page-banner" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>');" role="img" aria-label="">
				<div class="page-banner__overlay" aria-hidden="true"></div>
				<div class="container page-banner__inner">
					<h1 class="page-banner__title"><?php echo esc_html( $display_title ); ?></h1>
				</div>
			</div>
		<?php endif; ?>

		<div class="container">
			<?php if ( ! has_post_thumbnail() ) : ?>
				<h1 class="page-title"><?php echo esc_html( $display_title ); ?></h1>
			<?php endif; ?>

			<p class="single-event__meta">
				<span class="single-event__type"><?php echo esc_html( strtoupper( $kind ) ); ?></span>
				<?php if ( 'public' !== $attendance ) : ?>
					<span class="single-event__attendance"><?php echo esc_html( strtoupper( $attendance_label ) ); ?></span>
				<?php endif; ?>
				<?php if ( '' !== $date_line ) : ?>
					<span class="single-event__dot" aria-hidden="true">&middot;</span>
					<time datetime="<?php echo esc_attr( $start ); ?>"><?php echo esc_html( $date_line ); ?></time>
				<?php endif; ?>
			</p>

			<div class="single-event__layout">
				<div class="content-page__main">
					<?php if ( has_excerpt() ) : ?>
						<p class="single-event__lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
					<?php the_content(); ?>
				</div>
				<aside class="single-event__aside">
					<div class="single-event__card">
						<h2><?php esc_html_e( 'Event details', 'brimstone-hill' ); ?></h2>
						<?php if ( '' !== $date_line ) : ?>
							<p><strong><?php esc_html_e( 'Date', 'brimstone-hill' ); ?>:</strong> <?php echo esc_html( $date_line ); ?></p>
						<?php endif; ?>
						<p><strong><?php esc_html_e( 'Type', 'brimstone-hill' ); ?>:</strong> <?php echo esc_html( $kind ); ?></p>
						<p><strong><?php esc_html_e( 'Attendance', 'brimstone-hill' ); ?>:</strong> <?php echo esc_html( $attendance_label ); ?></p>
						<p class="single-event__actions">
							<a class="btn btn--primary btn--sm" href="<?php echo esc_url( $calendar_url ); ?>"><?php esc_html_e( 'View calendar', 'brimstone-hill' ); ?></a>
						</p>
						<?php if ( '' !== $ics_link ) : ?>
							<p><a class="btn btn--secondary btn--sm" download="event-<?php echo esc_attr( $event_id ); ?>.ics" href="<?php echo esc_url( $ics_link ); ?>"><?php esc_html_e( 'Add to calendar (.ics)', 'brimstone-hill' ); ?></a></p>
						<?php endif; ?>
					</div>
				</aside>
			</div>

			<nav class="single-event__nav" aria-label="<?php esc_attr_e( 'Event navigation', 'brimstone-hill' ); ?>">
				<div><?php previous_post_link( '%link', esc_html__( 'Previous event', 'brimstone-hill' ) ); ?></div>
				<div><a class="btn btn--secondary btn--sm" href="<?php echo esc_url( $calendar_url ); ?>"><?php esc_html_e( 'Back to events calendar', 'brimstone-hill' ); ?></a></div>
				<div><?php next_post_link( '%link', esc_html__( 'Next event', 'brimstone-hill' ) ); ?></div>
			</nav>

			<?php if ( ! empty( $linked_albums ) ) : ?>
				<section class="single-event__albums" aria-label="<?php esc_attr_e( 'Event galleries', 'brimstone-hill' ); ?>">
					<h2><?php esc_html_e( 'Event galleries', 'brimstone-hill' ); ?></h2>
					<div class="card-grid">
						<?php foreach ( $linked_albums as $album ) : ?>
							<?php
							$album_thumb_html = '';
							if ( has_post_thumbnail( $album ) ) {
								$album_thumb_html = get_the_post_thumbnail( $album, 'medium_large', array( 'class' => 'card__image-img', 'loading' => 'lazy' ) );
							} elseif ( defined( 'BHFP_GALLERY_META_IDS' ) ) {
								$ids = get_post_meta( (int) $album->ID, BHFP_GALLERY_META_IDS, true );
								if ( is_array( $ids ) && ! empty( $ids ) ) {
									$first_id = absint( $ids[0] );
									if ( $first_id ) {
										$album_thumb_html = wp_get_attachment_image( $first_id, 'medium_large', false, array( 'class' => 'card__image-img', 'loading' => 'lazy' ) );
									}
								}
							}
							?>
							<article class="card">
								<?php if ( '' !== $album_thumb_html ) : ?>
									<a href="<?php echo esc_url( get_permalink( $album ) ); ?>" class="card__image-wrap single-event__album-image-wrap">
										<div class="card__image single-event__album-image">
											<?php echo $album_thumb_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</div>
									</a>
								<?php endif; ?>
								<div class="card__body single-event__album-body">
									<h3 class="card__title"><a class="single-event__album-link" href="<?php echo esc_url( get_permalink( $album ) ); ?>"><?php echo esc_html( get_the_title( $album ) ); ?></a></h3>
									<?php if ( has_excerpt( $album ) ) : ?>
										<p class="card__excerpt"><?php echo esc_html( get_the_excerpt( $album ) ); ?></p>
									<?php endif; ?>
									<a class="card__link single-event__album-link" href="<?php echo esc_url( get_permalink( $album ) ); ?>"><?php esc_html_e( 'View album', 'brimstone-hill' ); ?></a>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>
		</div>
	</article>
</main>
<script type="application/ld+json"><?php echo wp_json_encode( $schema ); ?></script>
	<?php
endwhile;

get_footer();


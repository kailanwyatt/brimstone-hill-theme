<?php
/**
 * Template Name: Book Tickets
 *
 * @package Brimstone_Hill
 */

get_header();

$future_events = array();
if ( class_exists( 'BHFP_Booking_Public' ) ) {
	$future_events = BHFP_Booking_Public::future_events_for_select();
} elseif ( class_exists( 'BHFP_Event' ) ) {
	$future_events = BHFP_Event::get_future_events_for_booking();
}

$preselect_event_id = class_exists( 'BHFP_Booking_Public' )
	? BHFP_Booking_Public::preselect_event_id_from_request()
	: 0;
$preselect_visit_date = class_exists( 'BHFP_Booking_Public' )
	? BHFP_Booking_Public::preselect_visit_date_from_request( $preselect_event_id )
	: '';

$peek_url = function_exists( 'bhfp_peek_pro_booking_url' ) ? bhfp_peek_pro_booking_url() : '';
$has_peek = function_exists( 'bhfp_has_peek_pro_booking' ) ? bhfp_has_peek_pro_booking() : ( '' !== $peek_url );

$booking_ready = class_exists( 'BHFP_Booking_Public' ) && BHFP_Booking_Public::is_online_booking_ready();

$initial_tiers = array();
if ( class_exists( 'BHFP_Booking_Public' ) ) {
	$initial_tiers = BHFP_Booking_Public::ticket_tiers_for_booking( $preselect_event_id );
} elseif ( class_exists( 'BHFP_Ticket_Tiers' ) ) {
	$initial_tiers = BHFP_Ticket_Tiers::get_tiers_for_booking( $preselect_event_id );
}
?>

<main id="main-content" class="site-main page-book-tickets">
	<?php
	while ( have_posts() ) :
		the_post();
		$has_banner = has_post_thumbnail();
		$page_lede  = has_excerpt() ? get_the_excerpt() : __( 'Reserve general admission or tickets for an upcoming event.', 'brimstone-hill' );
		?>
		<?php if ( $has_banner ) : ?>
			<div class="page-banner" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>');" role="img" aria-label="">
				<div class="page-banner__overlay" aria-hidden="true"></div>
				<div class="container page-banner__inner">
					<h1 class="page-banner__title"><?php the_title(); ?></h1>
					<?php if ( $page_lede ) : ?>
						<p class="page-banner__lede"><?php echo esc_html( $page_lede ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		<?php else : ?>
			<header class="page-book-tickets__hero">
				<div class="container page-book-tickets__hero-inner">
					<h1 class="page-book-tickets__hero-title"><?php the_title(); ?></h1>
					<?php if ( $page_lede ) : ?>
						<p class="page-book-tickets__hero-lede"><?php echo esc_html( $page_lede ); ?></p>
					<?php endif; ?>
				</div>
			</header>
		<?php endif; ?>

		<div class="container page-book-tickets__body">
		<div class="breadcrumb-wrap breadcrumb-wrap--align-<?php echo esc_attr( bh_get_page_title_align() ); ?>">
			<?php get_template_part( 'template-parts/breadcrumb' ); ?>
		</div>
		<?php if ( ! $booking_ready ) : ?>
			<p class="book-tickets-notice notice"><?php esc_html_e( 'Online ticket booking is unavailable right now. Please contact the fortress office for assistance, or use the booking link below if one is shown.', 'brimstone-hill' ); ?></p>
		<?php endif; ?>
		<div class="book-tickets-layout">
			<div class="book-tickets-form-wrapper">
				<?php if ( get_the_content() ) : ?>
					<div class="book-tickets-content content-page__main--prose">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

				<?php if ( $has_peek ) : ?>
					<div class="book-tickets-peek">
						<a href="<?php echo esc_url( $peek_url ); ?>" class="btn btn--secondary book-tickets-peek__link" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Book with Peek Pro', 'brimstone-hill' ); ?>
						</a>
						<p class="book-tickets-peek__note description"><?php esc_html_e( 'Opens in a new window.', 'brimstone-hill' ); ?></p>
					</div>
					<?php if ( $booking_ready ) : ?>
						<div class="book-tickets-divider" role="separator" aria-label="<?php esc_attr_e( 'Or book on this site', 'brimstone-hill' ); ?>">
							<span class="book-tickets-divider__label"><?php esc_html_e( 'OR', 'brimstone-hill' ); ?></span>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $booking_ready ) : ?>
				<form id="bhfp-book-tickets-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="book-tickets-form">
					<input type="hidden" name="action" value="bhfp_process_booking_form">
					<?php wp_nonce_field( 'bhfp_booking_form', 'bhfp_booking_nonce' ); ?>

					<div class="form-section">
						<h2><?php esc_html_e( '1. Admission type', 'brimstone-hill' ); ?></h2>
						<div class="form-group">
							<label for="booking_event"><?php esc_html_e( 'Event', 'brimstone-hill' ); ?></label>
							<select name="event_id" id="booking_event" class="form-control">
								<option value="0" <?php selected( $preselect_event_id, 0 ); ?>><?php esc_html_e( 'General Admission', 'brimstone-hill' ); ?></option>
								<?php foreach ( $future_events as $event_row ) : ?>
									<option value="<?php echo esc_attr( (string) $event_row['id'] ); ?>" <?php selected( $preselect_event_id, (int) $event_row['id'] ); ?>><?php echo esc_html( $event_row['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php if ( empty( $future_events ) ) : ?>
								<p class="description"><?php esc_html_e( 'No upcoming events are scheduled. General admission is available every day.', 'brimstone-hill' ); ?></p>
							<?php else : ?>
								<p class="description"><?php esc_html_e( 'Choose General Admission for a regular visit, or select an upcoming event.', 'brimstone-hill' ); ?></p>
							<?php endif; ?>
						</div>
					</div>

					<div class="form-section">
						<h2><?php esc_html_e( '2. Visit date (optional)', 'brimstone-hill' ); ?></h2>
						<div class="form-group">
							<label for="booking_date"><?php esc_html_e( 'Visit date', 'brimstone-hill' ); ?></label>
							<input type="date" name="visit_date" id="booking_date" class="form-control" min="<?php echo esc_attr( wp_date( 'Y-m-d' ) ); ?>" value="<?php echo esc_attr( $preselect_visit_date ); ?>">
							<p class="description"><?php esc_html_e( 'Tickets are valid for any day if no date is selected.', 'brimstone-hill' ); ?></p>
						</div>
					</div>

					<div class="form-section">
						<h2><?php esc_html_e( '3. Select tickets', 'brimstone-hill' ); ?></h2>
						<div id="booking-ticket-tiers" class="ticket-selectors">
							<?php
							if ( class_exists( 'BHFP_Ticket_Tiers' ) && ! empty( $initial_tiers ) ) {
								BHFP_Ticket_Tiers::render_booking_tier_rows( $initial_tiers );
							} elseif ( empty( $initial_tiers ) ) {
								echo '<p class="description book-tickets-no-tiers">' . esc_html__( 'Ticket types are not available right now. Please contact us for assistance.', 'brimstone-hill' ) . '</p>';
							}
							?>
						</div>
					</div>

					<div class="booking-summary-sticky">
						<div class="booking-total">
							<span><?php esc_html_e( 'Total:', 'brimstone-hill' ); ?></span>
							<span id="booking-total-price">$0.00</span>
						</div>
						<button type="submit" id="btn-submit-booking" class="btn btn--primary" disabled>
							<?php esc_html_e( 'Continue to checkout', 'brimstone-hill' ); ?>
						</button>
					</div>
				</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();

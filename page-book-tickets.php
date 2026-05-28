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

$peek_url = function_exists( 'bhfp_peek_pro_booking_url' ) ? bhfp_peek_pro_booking_url() : '';
$has_peek = function_exists( 'bhfp_has_peek_pro_booking' ) ? bhfp_has_peek_pro_booking() : ( '' !== $peek_url );

$ticket_types = array(
	'adult' => array(
		'label' => __( 'Adult (13+)', 'brimstone-hill' ),
		'price' => 15,
		'desc'  => __( 'Standard admission', 'brimstone-hill' ),
	),
	'child' => array(
		'label' => __( 'Child (Under 13)', 'brimstone-hill' ),
		'price' => 5,
		'desc'  => __( 'Must be accompanied by an adult', 'brimstone-hill' ),
	),
	'local' => array(
		'label' => __( 'Local Resident', 'brimstone-hill' ),
		'price' => 0,
		'desc'  => __( 'Valid ID required at gate', 'brimstone-hill' ),
	),
);
?>

<main id="primary" class="site-main page-book-tickets">
	<div class="page-banner page-banner--fallback">
		<div class="page-banner__overlay" aria-hidden="true"></div>
		<div class="page-banner__inner container">
			<h1 class="page-banner__title"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="container section-padding">
		<?php
		if ( function_exists( 'bhfp_admission_product_id' ) && function_exists( 'bhfp_validate_wc_product_type' ) ) {
			$admission_id = bhfp_admission_product_id();
			if ( ! $admission_id || ! bhfp_validate_wc_product_type( $admission_id, 'bhfp_booking' ) ) {
				echo '<p class="book-tickets-notice notice">' . esc_html__( 'Online ticket booking is not fully configured. An administrator must set the Admission product ID under Settings → Brimstone Hill → Commerce.', 'brimstone-hill' ) . '</p>';
			}
		}
		?>
		<div class="book-tickets-layout">
			<div class="book-tickets-form-wrapper">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="book-tickets-content">
						<?php the_content(); ?>
					</div>
					<?php
				endwhile;
				?>

				<div class="book-tickets-channels" role="group" aria-label="<?php esc_attr_e( 'How to book entrance', 'brimstone-hill' ); ?>">
					<h2 class="book-tickets-channels__heading"><?php esc_html_e( 'How would you like to book?', 'brimstone-hill' ); ?></h2>
					<div class="book-tickets-channels__grid">
						<button type="button" class="book-tickets-channel book-tickets-channel--active" data-channel="site" aria-pressed="true">
							<span class="book-tickets-channel__title"><?php esc_html_e( 'Book on this site', 'brimstone-hill' ); ?></span>
							<span class="book-tickets-channel__desc"><?php esc_html_e( 'General admission or an upcoming event — checkout with WooCommerce.', 'brimstone-hill' ); ?></span>
						</button>
						<?php if ( $has_peek ) : ?>
							<a href="<?php echo esc_url( $peek_url ); ?>" class="book-tickets-channel book-tickets-channel--peek" target="_blank" rel="noopener noreferrer">
								<span class="book-tickets-channel__title"><?php esc_html_e( 'Book with Peek Pro', 'brimstone-hill' ); ?></span>
								<span class="book-tickets-channel__desc"><?php esc_html_e( 'Entrance tickets via your Peek Pro booking page (opens in a new tab).', 'brimstone-hill' ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>

				<form id="bhfp-book-tickets-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="book-tickets-form">
					<input type="hidden" name="action" value="bhfp_process_booking_form">
					<?php wp_nonce_field( 'bhfp_booking_form', 'bhfp_booking_nonce' ); ?>

					<div class="form-section">
						<h2><?php esc_html_e( '1. Admission type', 'brimstone-hill' ); ?></h2>
						<div class="form-group">
							<label for="booking_event"><?php esc_html_e( 'Event', 'brimstone-hill' ); ?></label>
							<select name="event_id" id="booking_event" class="form-control">
								<option value="0" selected><?php esc_html_e( 'General Admission', 'brimstone-hill' ); ?></option>
								<?php foreach ( $future_events as $event_row ) : ?>
									<option value="<?php echo esc_attr( (string) $event_row['id'] ); ?>"><?php echo esc_html( $event_row['label'] ); ?></option>
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
							<input type="date" name="visit_date" id="booking_date" class="form-control" min="<?php echo esc_attr( wp_date( 'Y-m-d' ) ); ?>">
							<p class="description"><?php esc_html_e( 'Tickets are valid for any day if no date is selected.', 'brimstone-hill' ); ?></p>
						</div>
					</div>

					<div class="form-section">
						<h2><?php esc_html_e( '3. Select tickets', 'brimstone-hill' ); ?></h2>
						<div class="ticket-selectors">
							<?php foreach ( $ticket_types as $key => $type ) : ?>
								<div class="ticket-type-row" data-price="<?php echo esc_attr( (string) $type['price'] ); ?>" data-key="<?php echo esc_attr( $key ); ?>">
									<div class="ticket-info">
										<h3><?php echo esc_html( $type['label'] ); ?></h3>
										<p><?php echo esc_html( $type['desc'] ); ?></p>
										<div class="ticket-price">
											<?php
											echo $type['price'] > 0
												? '$' . esc_html( number_format( (float) $type['price'], 2 ) )
												: esc_html__( 'Free', 'brimstone-hill' );
											?>
										</div>
									</div>
									<div class="ticket-controls">
										<button type="button" class="btn-qty btn-minus" aria-label="<?php esc_attr_e( 'Decrease quantity', 'brimstone-hill' ); ?>">-</button>
										<input type="number" name="tickets[<?php echo esc_attr( $key ); ?>]" value="0" min="0" max="20" class="qty-input" readonly>
										<button type="button" class="btn-qty btn-plus" aria-label="<?php esc_attr_e( 'Increase quantity', 'brimstone-hill' ); ?>">+</button>
									</div>
								</div>
							<?php endforeach; ?>
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
			</div>

			<div class="book-tickets-sidebar">
				<?php echo do_shortcode( '[bhfp_context_sidebar section="visit"]' ); ?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();

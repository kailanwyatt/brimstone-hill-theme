<?php
/**
 * Home Admission and Hours section
 */
$entrance = get_option( 'bh_home_admission_entrance', 'Entrance USD $15 · Locals XCD $10 with valid St. Kitts–Nevis Government ID · Children 12 and under half price · Restaurant-only parking XCD $10 with ID (wristband for restaurant access).' );
$hours    = get_option( 'bh_home_admission_hours', 'Open daily 9:30am–5:30pm' );
?>
<section class="admission-hours">
	<div class="container admission-hours__inner">
		<p class="admission-hours__text">
			<strong><?php echo esc_html( $entrance ); ?></strong>
		</p>
		<p class="admission-hours__hours"><?php echo esc_html( $hours ); ?></p>
		<a href="<?php echo esc_url( bh_book_tickets_url() ); ?>" class="btn btn--primary admission-hours__btn"><?php esc_html_e( 'Book now', 'brimstone-hill' ); ?></a>
	</div>
</section>

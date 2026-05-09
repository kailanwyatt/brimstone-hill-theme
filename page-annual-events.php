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
		?>
	<p>
		<?php esc_html_e( 'Mark your calendar for the Emancipation Festival, the Annual Fund Run, and other recurring events at Brimstone Hill. These occasions bring the community and visitors together to celebrate heritage, health, and history.', 'brimstone-hill' ); ?>
	</p>

	<section class="content-block">
		<h2 class="content-block__title"><?php esc_html_e( 'Emancipation Festival', 'brimstone-hill' ); ?></h2>
		<p>
			<?php esc_html_e( 'The Emancipation Festival is one of the Caribbean’s most significant cultural events. Held at the fortress, it celebrates freedom and heritage with live music, storytelling, traditional food, and family activities. The festival honours the legacy of those who were enslaved and their descendants, and highlights the role of Brimstone Hill in the island’s history. Dates are announced each year; check What’s on and the Events calendar for details and booking.', 'brimstone-hill' ); ?>
		</p>
		<p>
			<a class="link--more" href="<?php echo esc_url( home_url( '/events/whats-on/' ) ); ?>"><?php esc_html_e( 'What’s on', 'brimstone-hill' ); ?></a>
			<span class="screen-reader-text">, </span>
			<a class="link--more" href="<?php echo esc_url( home_url( '/events/calendar/' ) ); ?>"><?php esc_html_e( 'Events calendar', 'brimstone-hill' ); ?></a>
		</p>
	</section>

	<section class="content-block">
		<h2 class="content-block__title"><?php esc_html_e( 'Annual Fund Run', 'brimstone-hill' ); ?></h2>
		<p>
			<?php esc_html_e( 'The Annual Fund Run takes participants through the historic grounds of the fortress. All ages are welcome. Proceeds support the Brimstone Hill Fortress National Park Society’s education and conservation work. It’s a great way to stay active and support the park. See the Events calendar for the next date.', 'brimstone-hill' ); ?>
		</p>
		<p><a class="link--more" href="<?php echo esc_url( home_url( '/events/calendar/' ) ); ?>"><?php esc_html_e( 'Events calendar', 'brimstone-hill' ); ?></a></p>
	</section>

	<section class="content-block">
		<h2 class="content-block__title"><?php esc_html_e( 'Heritage Open Day', 'brimstone-hill' ); ?></h2>
		<p>
			<?php esc_html_e( 'Each year we hold a Heritage Open Day with free admission for residents. The day includes special talks, demonstrations, and family activities. It’s an opportunity to celebrate our shared heritage and to introduce new visitors to the fortress.', 'brimstone-hill' ); ?>
		</p>
	</section>

	<section class="content-block">
		<h2 class="content-block__title"><?php esc_html_e( 'Other events', 'brimstone-hill' ); ?></h2>
		<p>
			<?php esc_html_e( 'Throughout the year we host guided tours, school programmes, and special events. For the full list of upcoming and past events, visit the Events calendar and What’s on.', 'brimstone-hill' ); ?>
		</p>
		<p>
			<a class="link--more" href="<?php echo esc_url( home_url( '/events/calendar/' ) ); ?>"><?php esc_html_e( 'Events calendar', 'brimstone-hill' ); ?></a>
			<span class="screen-reader-text">, </span>
			<a class="link--more" href="<?php echo esc_url( home_url( '/events/whats-on/' ) ); ?>"><?php esc_html_e( 'What’s on', 'brimstone-hill' ); ?></a>
		</p>
	</section>

		<?php if ( class_exists( 'BHFP_Public_Chrome' ) ) : ?>
	<section class="content-block content-block--calendar-teaser" aria-label="<?php esc_attr_e( 'Upcoming dates', 'brimstone-hill' ); ?>">
		<h2 class="content-block__title"><?php esc_html_e( 'Upcoming dates', 'brimstone-hill' ); ?></h2>
		<p class="content-block__lede"><?php esc_html_e( 'Dates below combine featured programme items with events managed in WordPress (Operations → Events).', 'brimstone-hill' ); ?></p>
			<?php echo do_shortcode( '[bhfp_events_list limit="6" intro="0" calendar_link="1"]' ); ?>
	</section>
		<?php endif; ?>
		<?php
	}
}

get_header();

while ( have_posts() ) :
	the_post();
	$bh_enable_sidebar = get_post_meta( get_the_ID(), '_bh_sidebar_enabled', true );
	$bh_has_banner     = has_post_thumbnail();
	?>
<main id="main-content" class="bh-page content-page annual-events-page">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( $bh_has_banner ) : ?>
			<div class="page-banner" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>');" role="img" aria-label="">
				<div class="page-banner__overlay" aria-hidden="true"></div>
				<div class="container page-banner__inner">
					<h1 class="page-banner__title"><?php the_title(); ?></h1>
				</div>
			</div>
		<?php endif; ?>

		<div class="container">
			<?php if ( ! $bh_has_banner ) : ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
			<?php endif; ?>

			<div class="content-page__body <?php echo $bh_enable_sidebar ? 'content-page__body--with-sidebar' : 'content-page__body--narrow'; ?>">
				<?php if ( $bh_enable_sidebar ) : ?>
					<div class="content-page__layout">
						<div class="content-page__main content-page__main--prose">
							<?php bh_annual_events_static_content(); ?>
						</div>
						<aside class="content-page__sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'brimstone-hill' ); ?>">
							<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
						</aside>
					</div>
				<?php else : ?>
					<div class="content-page__main content-page__main--prose">
						<?php bh_annual_events_static_content(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

<?php
/**
 * Events calendar — page slug "calendar" under Events (e.g. /events/calendar).
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
<main id="main-content" class="bh-page content-page events-calendar-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>
		<div class="content-page__body content-page__body--full">
			<div class="content-page__main">
				<?php echo do_shortcode( '[bhfp_events_calendar omit_banner="1"]' ); ?>
			</div>
		</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

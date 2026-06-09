<?php
/**
 * Template Name: Order complete — Booking
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
<main id="main-content" class="bh-page content-page bh-order-complete">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>
		<div class="content-page__body content-page__body--narrow">
			<div class="content-page__main content-page__main--prose">
				<?php the_content(); ?>
				<?php
				if ( function_exists( 'bhfp_render_order_complete' ) ) {
					bhfp_render_order_complete( 'booking' );
				}
				?>
			</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

<?php
/**
 * Gallery archive page — uses page slug "gallery" (e.g. /discover/gallery).
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();

	$albums_query = new WP_Query(
		array(
			'post_type'           => defined( 'BHFP_GALLERY_POST_TYPE' ) ? BHFP_GALLERY_POST_TYPE : 'bhfp_gallery',
			'post_status'         => 'publish',
			'posts_per_page'      => -1,
			'orderby'             => 'title',
			'order'               => 'ASC',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	?>
<main id="main-content" class="bh-page content-page gallery-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>

		<div class="content-page__body content-page__body--full">
			<div class="content-page__main">
				<p class="gallery-page__intro"><?php esc_html_e( 'Images of the fortress, the views, and the experience. Browse by album for a visual tour of Brimstone Hill Fortress National Park.', 'brimstone-hill' ); ?></p>
				<?php if ( $albums_query->have_posts() ) : ?>
					<div class="gallery-albums">
						<?php
						while ( $albums_query->have_posts() ) :
							$albums_query->the_post();
							get_template_part( 'template-parts/gallery-album', 'card' );
						endwhile;
						?>
					</div>
				<?php else : ?>
					<p><?php esc_html_e( 'No gallery albums found yet.', 'brimstone-hill' ); ?></p>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

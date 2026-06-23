<?php
/**
 * Gallery archive page — uses page slug "gallery" (e.g. /discover/gallery).
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();

	$album_ids = bh_gallery_get_sorted_album_ids(
		array(
			'posts_per_page' => -1,
		)
	);
	?>
<main id="main-content" class="bh-page content-page content-page--wide gallery-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>
		<?php bh_render_page_content_shell_open(); ?>
		<div class="content-page__body content-page__body--full">
			<div class="content-page__main">
				<p class="gallery-page__intro"><?php esc_html_e( 'Images of the fortress, the views, and the experience. Browse by album for a visual tour of Brimstone Hill Fortress National Park.', 'brimstone-hill' ); ?></p>
				<?php if ( ! empty( $album_ids ) ) : ?>
					<div class="gallery-albums gallery-albums--columns-4">
						<?php
						foreach ( $album_ids as $album_id ) :
							$post = get_post( $album_id );
							if ( ! $post ) {
								continue;
							}
							setup_postdata( $post );
							get_template_part( 'template-parts/gallery-album', 'card' );
						endforeach;
						wp_reset_postdata();
						?>
					</div>
				<?php else : ?>
					<p><?php esc_html_e( 'No gallery albums found yet.', 'brimstone-hill' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php bh_render_page_content_shell_close(); ?>
	</article>
</main>
	<?php
endwhile;

get_footer();

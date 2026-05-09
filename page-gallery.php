<?php
/**
 * Gallery archive page — uses page slug "gallery" (e.g. /discover/gallery).
 *
 * @package Brimstone_Hill
 */

if ( ! function_exists( 'bh_gallery_album_image_ids' ) ) {
	/**
	 * Normalize gallery attachment IDs from album meta.
	 *
	 * @param int $album_id Gallery album post ID.
	 * @return int[]
	 */
	function bh_gallery_album_image_ids( $album_id ) {
		$meta_ids_key = defined( 'BHFP_GALLERY_META_IDS' ) ? BHFP_GALLERY_META_IDS : '_bhfp_attachment_ids';
		$raw = get_post_meta( (int) $album_id, $meta_ids_key, true );
		if ( is_array( $raw ) ) {
			$ids = $raw;
		} else {
			$raw = (string) $raw;
			$ids = '' !== trim( $raw ) ? preg_split( '/\s*,\s*/', $raw ) : array();
		}
		$ids = array_values( array_filter( array_map( 'absint', (array) $ids ) ) );
		return $ids;
	}
}

if ( ! function_exists( 'bh_gallery_album_cover_url' ) ) {
	/**
	 * Resolve album cover URL from first attached image or featured image.
	 *
	 * @param int $album_id Gallery album post ID.
	 * @return string
	 */
	function bh_gallery_album_cover_url( $album_id ) {
		$album_id = (int) $album_id;
		$ids      = bh_gallery_album_image_ids( $album_id );
		if ( ! empty( $ids ) ) {
			$u = wp_get_attachment_image_url( $ids[0], 'large' );
			if ( $u ) {
				return $u;
			}
		}
		$thumb = get_the_post_thumbnail_url( $album_id, 'large' );
		return $thumb ? $thumb : '';
	}
}

get_header();

while ( have_posts() ) :
	the_post();
	$bh_enable_sidebar = get_post_meta( get_the_ID(), '_bh_sidebar_enabled', true );
	$bh_has_banner     = has_post_thumbnail();

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
<main id="main-content" class="bh-page content-page gallery-page">
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

			<div class="content-page__body <?php echo $bh_enable_sidebar ? 'content-page__body--with-sidebar' : 'content-page__body--full'; ?>">
				<?php if ( $bh_enable_sidebar ) : ?>
					<div class="content-page__layout">
						<div class="content-page__main">
							<p class="gallery-page__intro"><?php esc_html_e( 'Images of the fortress, the views, and the experience. Browse by album for a visual tour of Brimstone Hill Fortress National Park.', 'brimstone-hill' ); ?></p>
							<?php if ( $albums_query->have_posts() ) : ?>
								<div class="gallery-albums">
									<?php while ( $albums_query->have_posts() ) : $albums_query->the_post(); ?>
										<?php
										$album_id    = get_the_ID();
										$album_link  = get_permalink( $album_id );
										$cover_url   = bh_gallery_album_cover_url( $album_id );
										$image_count = count( bh_gallery_album_image_ids( $album_id ) );
										$desc        = get_the_excerpt();
										if ( '' === trim( (string) $desc ) ) {
											$desc = wp_trim_words( wp_strip_all_tags( (string) get_the_content() ), 22 );
										}
										?>
										<a href="<?php echo esc_url( $album_link ); ?>" class="gallery-album-card">
											<?php if ( $cover_url ) : ?>
												<span class="gallery-album-card__image-wrap">
													<img src="<?php echo esc_url( $cover_url ); ?>" alt="" class="gallery-album-card__image" loading="lazy" />
												</span>
											<?php endif; ?>
											<h2 class="gallery-album-card__title"><?php the_title(); ?></h2>
											<?php if ( '' !== trim( (string) $desc ) ) : ?>
												<p class="gallery-album-card__desc"><?php echo esc_html( $desc ); ?></p>
											<?php endif; ?>
											<span class="gallery-album-card__meta">
												<?php echo esc_html( sprintf( _n( '%d image', '%d images', $image_count, 'brimstone-hill' ), $image_count ) ); ?>
											</span>
										</a>
									<?php endwhile; ?>
								</div>
							<?php else : ?>
								<p><?php esc_html_e( 'No gallery albums found yet.', 'brimstone-hill' ); ?></p>
							<?php endif; ?>
							<?php wp_reset_postdata(); ?>
						</div>
						<aside class="content-page__sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'brimstone-hill' ); ?>">
							<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
						</aside>
					</div>
				<?php else : ?>
					<div class="content-page__main">
						<p class="gallery-page__intro"><?php esc_html_e( 'Images of the fortress, the views, and the experience. Browse by album for a visual tour of Brimstone Hill Fortress National Park.', 'brimstone-hill' ); ?></p>
						<?php if ( $albums_query->have_posts() ) : ?>
							<div class="gallery-albums">
								<?php while ( $albums_query->have_posts() ) : $albums_query->the_post(); ?>
									<?php
									$album_id    = get_the_ID();
									$album_link  = get_permalink( $album_id );
									$cover_url   = bh_gallery_album_cover_url( $album_id );
									$image_count = count( bh_gallery_album_image_ids( $album_id ) );
									$desc        = get_the_excerpt();
									if ( '' === trim( (string) $desc ) ) {
										$desc = wp_trim_words( wp_strip_all_tags( (string) get_the_content() ), 22 );
									}
									?>
									<a href="<?php echo esc_url( $album_link ); ?>" class="gallery-album-card">
										<?php if ( $cover_url ) : ?>
											<span class="gallery-album-card__image-wrap">
												<img src="<?php echo esc_url( $cover_url ); ?>" alt="" class="gallery-album-card__image" loading="lazy" />
											</span>
										<?php endif; ?>
										<h2 class="gallery-album-card__title"><?php the_title(); ?></h2>
										<?php if ( '' !== trim( (string) $desc ) ) : ?>
											<p class="gallery-album-card__desc"><?php echo esc_html( $desc ); ?></p>
										<?php endif; ?>
										<span class="gallery-album-card__meta">
											<?php echo esc_html( sprintf( _n( '%d image', '%d images', $image_count, 'brimstone-hill' ), $image_count ) ); ?>
										</span>
									</a>
								<?php endwhile; ?>
							</div>
						<?php else : ?>
							<p><?php esc_html_e( 'No gallery albums found yet.', 'brimstone-hill' ); ?></p>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

<?php
/**
 * Single gallery album template with lightbox and captions.
 *
 * @package Brimstone_Hill
 */

if ( ! function_exists( 'bh_gallery_single_image_rows' ) ) {
	/**
	 * Build display-ready image rows from album meta.
	 *
	 * @param int $album_id Album post ID.
	 * @return array<int, array{id:int,full:string,thumb:string,alt:string,caption:string}>
	 */
	function bh_gallery_single_image_rows( $album_id ) {
		$album_id  = (int) $album_id;
		$meta_ids_key      = defined( 'BHFP_GALLERY_META_IDS' ) ? BHFP_GALLERY_META_IDS : '_bhfp_attachment_ids';
		$meta_captions_key = defined( 'BHFP_GALLERY_META_CAPTIONS' ) ? BHFP_GALLERY_META_CAPTIONS : '_bhfp_captions';
		$raw_ids   = get_post_meta( $album_id, $meta_ids_key, true );
		$captions  = get_post_meta( $album_id, $meta_captions_key, true );
		$captions  = is_array( $captions ) ? $captions : array();
		if ( is_array( $raw_ids ) ) {
			$ids = $raw_ids;
		} else {
			$raw_ids = (string) $raw_ids;
			$ids     = '' !== trim( $raw_ids ) ? preg_split( '/\s*,\s*/', $raw_ids ) : array();
		}
		$ids  = array_values( array_filter( array_map( 'absint', (array) $ids ) ) );
		$rows = array();
		foreach ( $ids as $id ) {
			$full = wp_get_attachment_image_url( $id, 'full' );
			$thm  = wp_get_attachment_image_url( $id, 'large' );
			if ( ! $full || ! $thm ) {
				continue;
			}
			$alt         = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
			$db_caption  = wp_get_attachment_caption( $id );
			$meta_caption = '';
			if ( isset( $captions[ $id ] ) ) {
				$meta_caption = (string) $captions[ $id ];
			} elseif ( isset( $captions[ (string) $id ] ) ) {
				$meta_caption = (string) $captions[ (string) $id ];
			}
			$caption = '' !== trim( $meta_caption ) ? $meta_caption : ( '' !== trim( (string) $db_caption ) ? (string) $db_caption : get_the_title( $id ) );
			$rows[]  = array(
				'id'      => $id,
				'full'    => $full,
				'thumb'   => $thm,
				'alt'     => '' !== trim( $alt ) ? $alt : (string) get_the_title( $id ),
				'caption' => $caption,
			);
		}
		return $rows;
	}
}

get_header();

while ( have_posts() ) :
	the_post();
	$album_id         = get_the_ID();
	$image_rows       = bh_gallery_single_image_rows( $album_id );
	$bh_enable_sidebar = get_post_meta( $album_id, '_bh_sidebar_enabled', true );
	$bh_has_banner     = has_post_thumbnail();
	?>
<main id="main-content" class="bh-page content-page gallery-album-page">
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
							<p class="gallery-album-page__back">
								<a class="link--back" href="<?php echo esc_url( home_url( '/discover/gallery/' ) ); ?>"><?php esc_html_e( 'Back to gallery', 'brimstone-hill' ); ?></a>
							</p>
							<?php if ( has_excerpt() ) : ?>
								<p class="gallery-album-page__desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $image_rows ) ) : ?>
								<div class="gallery-grid">
									<?php foreach ( $image_rows as $row ) : ?>
									<figure class="gallery-grid__item">
										<button
											type="button"
											class="gallery-grid__thumb-wrap"
											data-gallery-open="1"
											data-full="<?php echo esc_url( $row['full'] ); ?>"
											data-alt="<?php echo esc_attr( $row['alt'] ); ?>"
											data-caption="<?php echo esc_attr( $row['caption'] ); ?>"
											aria-label="<?php echo esc_attr( sprintf( __( 'View image: %s', 'brimstone-hill' ), $row['caption'] ) ); ?>"
										>
											<img class="gallery-grid__thumb" src="<?php echo esc_url( $row['thumb'] ); ?>" alt="<?php echo esc_attr( $row['alt'] ); ?>" loading="lazy" />
										</button>
										<figcaption class="gallery-grid__caption"><?php echo esc_html( $row['caption'] ); ?></figcaption>
									</figure>
									<?php endforeach; ?>
								</div>
							<?php else : ?>
								<p><?php esc_html_e( 'No images found in this album yet.', 'brimstone-hill' ); ?></p>
							<?php endif; ?>
						</div>
						<aside class="content-page__sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'brimstone-hill' ); ?>">
							<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
						</aside>
					</div>
				<?php else : ?>
					<div class="content-page__main">
						<p class="gallery-album-page__back">
							<a class="link--back" href="<?php echo esc_url( home_url( '/discover/gallery/' ) ); ?>"><?php esc_html_e( 'Back to gallery', 'brimstone-hill' ); ?></a>
						</p>
						<?php if ( has_excerpt() ) : ?>
							<p class="gallery-album-page__desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $image_rows ) ) : ?>
							<div class="gallery-grid">
								<?php foreach ( $image_rows as $row ) : ?>
								<figure class="gallery-grid__item">
									<button
										type="button"
										class="gallery-grid__thumb-wrap"
										data-gallery-open="1"
										data-full="<?php echo esc_url( $row['full'] ); ?>"
										data-alt="<?php echo esc_attr( $row['alt'] ); ?>"
										data-caption="<?php echo esc_attr( $row['caption'] ); ?>"
										aria-label="<?php echo esc_attr( sprintf( __( 'View image: %s', 'brimstone-hill' ), $row['caption'] ) ); ?>"
									>
										<img class="gallery-grid__thumb" src="<?php echo esc_url( $row['thumb'] ); ?>" alt="<?php echo esc_attr( $row['alt'] ); ?>" loading="lazy" />
									</button>
									<figcaption class="gallery-grid__caption"><?php echo esc_html( $row['caption'] ); ?></figcaption>
								</figure>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<p><?php esc_html_e( 'No images found in this album yet.', 'brimstone-hill' ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</article>
</main>

<div class="gallery-lightbox" id="bh-gallery-lightbox" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Image viewer', 'brimstone-hill' ); ?>" hidden>
	<div class="gallery-lightbox__inner">
		<button type="button" class="gallery-lightbox__nav gallery-lightbox__nav--prev" id="bh-gallery-lightbox-prev" aria-label="<?php esc_attr_e( 'Previous image', 'brimstone-hill' ); ?>"><?php esc_html_e( 'Previous', 'brimstone-hill' ); ?></button>
		<img class="gallery-lightbox__img" id="bh-gallery-lightbox-img" src="" alt="" />
		<button type="button" class="gallery-lightbox__nav gallery-lightbox__nav--next" id="bh-gallery-lightbox-next" aria-label="<?php esc_attr_e( 'Next image', 'brimstone-hill' ); ?>"><?php esc_html_e( 'Next', 'brimstone-hill' ); ?></button>
		<p class="gallery-lightbox__caption" id="bh-gallery-lightbox-caption"></p>
		<button type="button" class="gallery-lightbox__close" id="bh-gallery-lightbox-close" aria-label="<?php esc_attr_e( 'Close', 'brimstone-hill' ); ?>"><?php esc_html_e( 'Close', 'brimstone-hill' ); ?></button>
	</div>
</div>
	<?php
endwhile;

get_footer();

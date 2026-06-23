<?php
/**
 * Single gallery album card for listing grids.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$album_id    = get_the_ID();
$album_link  = get_permalink( $album_id );
$cover_url   = function_exists( 'bh_gallery_album_cover_url' ) ? bh_gallery_album_cover_url( $album_id ) : '';
$image_count = function_exists( 'bh_gallery_album_image_ids' ) ? count( bh_gallery_album_image_ids( $album_id ) ) : 0;
$count_label = sprintf(
	_n( '%d photo', '%d photos', $image_count, 'brimstone-hill' ),
	$image_count
);
?>
<a href="<?php echo esc_url( $album_link ); ?>" class="gallery-album-card">
	<span class="gallery-album-card__media">
		<?php if ( $cover_url ) : ?>
			<img src="<?php echo esc_url( $cover_url ); ?>" alt="" class="gallery-album-card__image" loading="lazy" />
		<?php endif; ?>
		<span class="gallery-album-card__overlay" aria-hidden="true"></span>
		<span class="gallery-album-card__content">
			<h2 class="gallery-album-card__title"><?php the_title(); ?></h2>
		</span>
		<span class="gallery-album-card__count"><?php echo esc_html( $count_label ); ?></span>
	</span>
</a>

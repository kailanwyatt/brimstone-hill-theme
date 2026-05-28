<?php
/**
 * Home hero — full-width background video (no overlay text).
 *
 * @package Brimstone_Hill
 */

$video_src = get_option(
	'bh_home_hero_video',
	'https://player.vimeo.com/video/1049129560?h=baad6d0ed1&autoplay=1&loop=1&autopause=0&muted=1&title=0&byline=0&portrait=0&controls=0&background=1'
);
$bg_image  = get_option( 'bh_home_hero_image', BH_THEME_URI . '/assets/images/img-04-1.jpg' );
?>
<section class="hero hero--video" aria-label="<?php esc_attr_e( 'Park overview video', 'brimstone-hill' ); ?>"<?php echo $bg_image ? ' style="background-image: url(' . esc_url( $bg_image ) . ')"' : ''; ?>>
	<?php if ( $video_src ) : ?>
		<div class="hero__video" aria-hidden="true">
			<iframe
				src="<?php echo esc_url( $video_src ); ?>"
				title=""
				tabindex="-1"
				frameborder="0"
				allow="autoplay; fullscreen; picture-in-picture"
				allowfullscreen
				class="hero__video-iframe"
			></iframe>
		</div>
	<?php endif; ?>
</section>

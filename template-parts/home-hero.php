<?php
/**
 * Home Hero section
 */

$video_src = get_option( 'bh_home_hero_video', 'https://player.vimeo.com/video/1049129560?h=baad6d0ed1&autoplay=1&loop=1&autopause=0&muted=1&title=0&byline=0&portrait=0&controls=0&background=1' );
$bg_image  = get_option( 'bh_home_hero_image', BH_THEME_URI . '/assets/images/img-04-1.jpg' );
$title     = get_option( 'bh_home_hero_title', 'Welcome to Brimstone Hill Fortress National Park' );
$subtitle  = get_option( 'bh_home_hero_subtitle', 'UNESCO World Heritage Site · St. Kitts & Nevis. Explore the fortress, discover the story, and plan your visit.' );
?>
<section class="hero" aria-label="Welcome" style="background-image: url('<?php echo esc_url( $bg_image ); ?>')">
	<?php if ( $video_src ) : ?>
		<div class="hero__video" aria-hidden="true">
			<iframe
				src="<?php echo esc_url( $video_src ); ?>"
				title=""
				frameborder="0"
				allow="autoplay; fullscreen; picture-in-picture"
				allowfullscreen
				class="hero__video-iframe"
			></iframe>
		</div>
	<?php endif; ?>
	<div class="hero__overlay"></div>
	<div class="hero__inner container">
		<h1 class="hero__title"><?php echo esc_html( $title ); ?></h1>
		<p class="hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<div class="hero__actions">
			<a href="<?php echo esc_url( home_url( '/visit/book-tickets' ) ); ?>" class="btn btn--primary">Book tickets</a>
			<a href="<?php echo esc_url( home_url( '/visit/plan-your-visit' ) ); ?>" class="btn btn--secondary">Plan your visit</a>
			<a href="<?php echo esc_url( home_url( '/events/whats-on' ) ); ?>" class="btn btn--secondary">What's on</a>
		</div>
	</div>
</section>

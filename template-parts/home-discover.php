<?php
/**
 * Home Discover More section
 */

$json = get_option( 'bh_home_discover_json' );
$discover_items = $json ? json_decode( $json, true ) : array();

if ( ! is_array( $discover_items ) || empty( $discover_items ) ) {
	return;
}
?>
<section class="discover-more">
	<div class="container">
		<h2 class="section-title">You'll discover more at Brimstone Hill</h2>
		<ul class="discover-more__grid">
			<?php foreach ( $discover_items as $item ) : ?>
				<li class="discover-more__item">
					<a href="<?php echo esc_url( home_url( $item['link'] ?? '' ) ); ?>" class="discover-more__card">
						<?php if ( ! empty( $item['image'] ) ) : ?>
							<span class="discover-more__card-image-wrap">
								<img src="<?php echo esc_url( str_starts_with( $item['image'], 'http' ) ? $item['image'] : home_url( $item['image'] ) ); ?>" alt="" class="discover-more__card-image" loading="lazy" />
							</span>
						<?php endif; ?>
						<h3 class="discover-more__card-title"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
						<p class="discover-more__card-desc"><?php echo esc_html( $item['description'] ?? '' ); ?></p>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

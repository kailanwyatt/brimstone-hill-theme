<?php
/**
 * Home About Park section
 */
$text = get_option('bh_home_about_text', 'Brimstone Hill and its Fortress is a National Park managed on behalf of the Government and people of St. Kitts and Nevis by the Brimstone Hill Fortress National Park Society. The Society, founded in 1965, is a voluntary non-profit organisation. Construction of the fortress began in 1690 and continued intermittently for just over 100 years until completion.');
?>
<section class="about-park">
	<div class="container">
		<h2 class="section-title">About Brimstone Hill Fortress National Park</h2>
		<p class="about-park__blurb"><?php echo esc_html($text); ?></p>
		<p class="about-park__link">
			<a href="<?php echo esc_url( home_url( '/about/our-story' ) ); ?>" class="btn btn--secondary"><?php esc_html_e( 'Learn more', 'brimstone-hill' ); ?></a>
		</p>
	</div>
</section>

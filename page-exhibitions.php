<?php
/**
 * Exhibitions page — uses page slug "exhibitions" (e.g. /discover/exhibitions).
 *
 * @package Brimstone_Hill
 */

if ( ! function_exists( 'bh_exhibitions_cards' ) ) {
	/**
	 * Default exhibition cards (until migrated to CPT).
	 *
	 * @return array<int, array<string,string>>
	 */
	function bh_exhibitions_cards() {
		return array(
			array(
				'title'   => __( 'The Garrison Life', 'brimstone-hill' ),
				'excerpt' => __( 'Discover how soldiers and their families lived within these walls.', 'brimstone-hill' ),
				'url'     => '#',
			),
			array(
				'title'   => __( 'Building the Fortress', 'brimstone-hill' ),
				'excerpt' => __( 'The engineering and labour behind a World Heritage Site.', 'brimstone-hill' ),
				'url'     => '#',
			),
		);
	}
}

get_header();

while ( have_posts() ) :
	the_post();
	$cards = bh_exhibitions_cards();
	?>
<main id="main-content" class="bh-page content-page content-page--wide exhibitions-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>
		<div class="content-page__body content-page__body--full">
			<div class="content-page__main">
				<p class="listing-page__intro"><?php esc_html_e( 'Current and past exhibitions. Discover the stories behind the fortress through our displays.', 'brimstone-hill' ); ?></p>
				<div class="card-grid">
					<?php foreach ( $cards as $card ) : ?>
						<a class="card" href="<?php echo esc_url( $card['url'] ); ?>">
							<div class="card__body">
								<h2 class="card__title"><?php echo esc_html( $card['title'] ); ?></h2>
								<p class="card__excerpt"><?php echo esc_html( $card['excerpt'] ); ?></p>
								<span class="card__link"><?php esc_html_e( 'Find out more', 'brimstone-hill' ); ?></span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

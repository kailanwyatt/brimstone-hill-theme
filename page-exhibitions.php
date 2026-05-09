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
	$bh_enable_sidebar = get_post_meta( get_the_ID(), '_bh_sidebar_enabled', true );
	$bh_has_banner     = has_post_thumbnail();
	$cards             = bh_exhibitions_cards();
	?>
<main id="main-content" class="bh-page content-page exhibitions-page">
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
						<aside class="content-page__sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'brimstone-hill' ); ?>">
							<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
						</aside>
					</div>
				<?php else : ?>
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
				<?php endif; ?>
			</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

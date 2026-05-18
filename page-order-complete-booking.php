<?php
/**
 * Template Name: Order complete — Booking
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();
	$bh_enable_sidebar = get_post_meta( get_the_ID(), '_bh_sidebar_enabled', true );
	?>
<main id="main-content" class="bh-page content-page bh-order-complete">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="container">
			<h1 class="page-title"><?php the_title(); ?></h1>
			<div class="content-page__body <?php echo $bh_enable_sidebar ? 'content-page__body--with-sidebar' : 'content-page__body--narrow'; ?>">
				<?php if ( $bh_enable_sidebar ) : ?>
					<div class="content-page__layout">
						<div class="content-page__main content-page__main--prose">
							<?php the_content(); ?>
							<?php
							if ( function_exists( 'bhfp_render_order_complete' ) ) {
								bhfp_render_order_complete( 'booking' );
							}
							?>
						</div>
						<aside class="content-page__sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'brimstone-hill' ); ?>">
							<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
						</aside>
					</div>
				<?php else : ?>
					<div class="content-page__main content-page__main--prose">
						<?php the_content(); ?>
						<?php
						if ( function_exists( 'bhfp_render_order_complete' ) ) {
							bhfp_render_order_complete( 'booking' );
						}
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

<?php
/**
 * Events calendar — page slug "calendar" under Events (e.g. /events/calendar).
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();
	$bh_enable_sidebar = get_post_meta( get_the_ID(), '_bh_sidebar_enabled', true );
	$bh_has_banner     = has_post_thumbnail();
	?>
<main id="main-content" class="bh-page content-page events-calendar-page">
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
							<?php echo do_shortcode( '[bhfp_events_calendar omit_banner="1"]' ); ?>
						</div>
						<aside class="content-page__sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'brimstone-hill' ); ?>">
							<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
						</aside>
					</div>
				<?php else : ?>
					<div class="content-page__main">
						<?php echo do_shortcode( '[bhfp_events_calendar omit_banner="1"]' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

<?php
/**
 * The template for displaying all pages
 *
 * @package Brimstone_Hill
 */

get_header();
?>

<main id="main-content" class="bh-page content-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<?php
	while ( have_posts() ) :
		the_post();
		$enable_sidebar = get_post_meta( get_the_ID(), '_bh_sidebar_enabled', true );
		$has_banner = has_post_thumbnail();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( $has_banner ) : ?>
				<div class="page-banner" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>');" role="img" aria-label="">
					<div class="page-banner__overlay" aria-hidden="true"></div>
					<div class="container page-banner__inner">
						<h1 class="page-banner__title"><?php the_title(); ?></h1>
					</div>
				</div>
			<?php endif; ?>

			<div class="container">
				<?php if ( ! $has_banner ) : ?>
					<h1 class="page-title"><?php the_title(); ?></h1>
				<?php endif; ?>

				<div class="content-page__body <?php echo $enable_sidebar ? 'content-page__body--with-sidebar' : 'content-page__body--narrow'; ?>">
					<?php if ( $enable_sidebar ) : ?>
						<div class="content-page__layout">
							<div class="content-page__main content-page__main--prose">
								<?php the_content(); ?>
							</div>
							<aside class="content-page__sidebar" aria-label="Sidebar">
								<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
							</aside>
						</div>
					<?php else : ?>
						<div class="content-page__main content-page__main--prose">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</article>
		<?php
	endwhile; // End of the loop.
	?>
</main>

<?php
get_footer();

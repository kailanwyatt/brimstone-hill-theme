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
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php get_template_part( 'template-parts/page', 'header' ); ?>
			<div class="content-page__body content-page__body--full">
				<div class="content-page__main content-page__main--prose">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();

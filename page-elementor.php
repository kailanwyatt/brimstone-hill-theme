<?php
/**
 * Template Name: Elementor Full Width
 * Template Post Type: page
 *
 * Full-width page shell for Elementor or block layouts without the prose column.
 *
 * @package Brimstone_Hill
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
<main id="main-content" class="bh-page content-page content-page--wide content-page--elementor">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="content-page__body content-page__body--full">
			<div class="content-page__main">
				<?php the_content(); ?>
			</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

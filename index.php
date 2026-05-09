<?php
/**
 * The main template file
 *
 * @package Brimstone_Hill
 */

get_header();

if ( is_front_page() ) {
	get_template_part( 'template-parts/front-page' );
} else {
	?>
	<div class="container page-container">
		<?php if ( ! is_front_page() && ! is_home() ) : ?>
			<div class="breadcrumb-wrap">
				<?php get_template_part( 'template-parts/breadcrumb' ); ?>
			</div>
		<?php endif; ?>

		<div class="page-layout with-sidebar">
			<main id="main-content" class="page-main">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;

					the_posts_navigation();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</main>
			
			<aside class="page-sidebar">
				<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
			</aside>
		</div>
	</div>
	<?php
}

get_footer();

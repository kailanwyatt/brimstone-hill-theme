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
	<main id="main-content" class="bh-page content-page">
		<div class="container">
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
		</div>
	</main>
	<?php
}

get_footer();

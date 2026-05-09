<?php
/**
 * The Template for displaying all single products
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<main id="main-content" class="site-main">
	<?php
		while ( have_posts() ) :
			the_post();
			wc_get_template_part( 'content', 'single-product' );
		endwhile;
	?>
</main>

<?php
get_footer();

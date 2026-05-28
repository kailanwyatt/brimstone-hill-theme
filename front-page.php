<?php
/**
 * The front page template
 *
 * @package Brimstone_Hill
 */

get_header();
?>

<main id="main-content" class="home-landing" tabIndex="-1">
	<?php
	// Hero Section
	get_template_part( 'template-parts/home', 'hero' );

	// Welcome Section
	get_template_part( 'template-parts/home', 'welcome' );

	// Discover More Grid
	get_template_part( 'template-parts/home', 'discover' );

	// Featured Promo (Emancipation Festival)
	get_template_part( 'template-parts/home', 'promo' );

	// Featured Reviews
	get_template_part( 'template-parts/home', 'reviews' );

	// What's On
	get_template_part( 'template-parts/home', 'whats-on' );

	// Plan Your Visit Teaser
	get_template_part( 'template-parts/home', 'plan-teaser' );

	// Newsletter Signup
	get_template_part( 'template-parts/home', 'newsletter' );

	// About Park
	get_template_part( 'template-parts/home', 'about' );
	?>
</main>

<?php
get_footer();

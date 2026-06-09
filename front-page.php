<?php
/**
 * The front page template
 *
 * @package Brimstone_Hill
 */

get_header();

$front_page_id   = (int) get_queried_object_id();
$use_elementor   = bh_is_elementor_page( $front_page_id );
?>

<main id="main-content" class="<?php echo $use_elementor ? 'bh-page content-page content-page--wide content-page--elementor' : 'home-landing'; ?>" tabIndex="-1">
	<?php if ( $use_elementor ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="content-page__body content-page__body--full">
					<div class="content-page__main">
						<?php the_content(); ?>
					</div>
				</div>
			</article>
			<?php
		endwhile;
		?>
	<?php else : ?>
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
	<?php endif; ?>
</main>

<?php
get_footer();

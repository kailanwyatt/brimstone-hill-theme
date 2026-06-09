<?php
/**
 * Page title, optional banner, and breadcrumb.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$has_banner  = has_post_thumbnail();
$align       = bh_get_page_title_align();
$align_class = 'page-title--align-' . $align;
$crumb_class = 'breadcrumb-wrap--align-' . $align;
?>
<?php if ( $has_banner ) : ?>
	<div class="page-banner" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>');" role="img" aria-label="">
		<div class="page-banner__overlay" aria-hidden="true"></div>
		<div class="container page-banner__inner">
			<h1 class="page-banner__title page-banner__title--align-<?php echo esc_attr( $align ); ?>"><?php the_title(); ?></h1>
		</div>
	</div>
<?php endif; ?>

<div class="container">
	<?php if ( ! $has_banner ) : ?>
		<h1 class="page-title <?php echo esc_attr( $align_class ); ?>"><?php the_title(); ?></h1>
	<?php endif; ?>

	<div class="breadcrumb-wrap <?php echo esc_attr( $crumb_class ); ?>">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
	</div>
</div>

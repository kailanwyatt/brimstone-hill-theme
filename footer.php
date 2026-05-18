<?php
/**
 * The template for displaying the footer
 *
 * @package Brimstone_Hill
 */

$footer_links = array();
$locations    = get_nav_menu_locations();
if ( ! empty( $locations['footer'] ) ) {
	$menu_items = wp_get_nav_menu_items( (int) $locations['footer'] );
	if ( is_array( $menu_items ) ) {
		foreach ( $menu_items as $item ) {
			if ( ! is_object( $item ) || empty( $item->url ) ) {
				continue;
			}
			$footer_links[] = array(
				'label' => $item->title,
				'url'   => $item->url,
			);
		}
	}
}
if ( empty( $footer_links ) ) {
	$footer_links = bh_default_footer_links();
}

$brand = bh_footer_brand_text();
?>

<footer class="site-footer">
	<div class="site-footer__inner container">
		<div class="site-footer__links">
			<?php foreach ( $footer_links as $link ) : ?>
				<a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
		<p class="site-footer__copy">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $brand ); ?>. <?php esc_html_e( 'All rights reserved.', 'brimstone-hill' ); ?>
			<?php
			$bhfp_staff_footer = function_exists( 'bhfp_footer_staff_link' ) ? bhfp_footer_staff_link() : array(
				'url'   => bh_staff_login_url(),
				'label' => __( 'Staff login', 'brimstone-hill' ),
			);
			?>
			&middot; <a href="<?php echo esc_url( $bhfp_staff_footer['url'] ); ?>" class="site-footer__staff"><?php echo esc_html( $bhfp_staff_footer['label'] ); ?></a>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

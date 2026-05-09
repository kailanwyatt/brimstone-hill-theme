<?php
/**
 * Sidebar Menu
 */

$post_id = get_the_ID();

$sidebar_menu           = get_post_meta( $post_id, '_bh_sidebar_menu', true );
$use_global_message     = get_post_meta( $post_id, '_bh_sidebar_use_global', true );
$sidebar_custom_content = get_post_meta( $post_id, '_bh_sidebar_custom_content', true );

$global_menu    = get_option( 'bh_sidebar_global_menu' );
$global_message = get_option( 'bh_sidebar_global_message' );

$menu_to_use = ! empty( $sidebar_menu ) ? $sidebar_menu : $global_menu;
$content_to_use = $use_global_message ? $global_message : ( ! empty( $sidebar_custom_content ) ? $sidebar_custom_content : '' );
if ( empty( $content_to_use ) && empty( $sidebar_custom_content ) ) {
    $content_to_use = $global_message;
}

?>
<div class="sidebar-wrapper">
	<?php if ( ! empty( $menu_to_use ) ) : ?>
		<nav class="sidebar-nav" aria-label="Section navigation">
			<?php
			wp_nav_menu(
				array(
					'menu'           => $menu_to_use,
					'container'      => false,
					'menu_class'     => 'sidebar-nav__list',
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
	<?php endif; ?>

	<?php if ( ! empty( $content_to_use ) ) : ?>
		<div class="sidebar-content">
			<?php echo do_shortcode( wp_kses_post( $content_to_use ) ); ?>
		</div>
	<?php endif; ?>
</div>

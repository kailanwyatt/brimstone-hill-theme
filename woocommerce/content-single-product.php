<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @package Brimstone_Hill
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$product_type = $product->get_type();
$is_custom = in_array( $product_type, array( 'bhfp_booking', 'bhfp_membership' ), true );

// Use our modern layout for custom products
if ( $is_custom ) {
	?>
	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'bh-modern-product', $product ); ?>>
		
		<div class="bh-modern-product-image">
			<?php
			if ( $product->get_image_id() ) {
				echo wp_get_attachment_image( $product->get_image_id(), 'bh-hero' );
			} else {
				echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			}
			?>
		</div>

		<div class="bh-modern-product-summary">
			<h1 class="bh-modern-product-title"><?php the_title(); ?></h1>
			
			<div class="bh-modern-product-price">
				<?php echo $product->get_price_html(); ?>
			</div>

			<div class="bh-modern-product-excerpt">
				<?php the_excerpt(); ?>
			</div>

			<div class="bh-modern-product-add-to-cart">
				<?php
				// Output custom quantity selector wrapper
				add_action( 'woocommerce_before_add_to_cart_quantity', function() {
					echo '<div class="bh-quantity-wrapper">';
					echo '<button type="button" class="bh-quantity-btn bh-quantity-minus">-</button>';
					echo '<div class="bh-quantity-display">1</div>';
					echo '<button type="button" class="bh-quantity-btn bh-quantity-plus">+</button>';
					echo '</div>'; // close custom wrapper
				});

				// Let WooCommerce render its form (we hide the default qty input via CSS)
				do_action( 'woocommerce_' . $product_type . '_add_to_cart' );
				?>
			</div>

			<div class="bh-trust-badges">
				<div class="bh-trust-badge">
					<svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
					Official Gate Pass
				</div>
				<div class="bh-trust-badge">
					<svg viewBox="0 0 24 24"><path d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm4.5 5H7.5c0-1.5 3-2.5 4.5-2.5s4.5 1 4.5 2.5z"/></svg>
					Valid for up to 1 year
				</div>
				<div class="bh-trust-badge">
					<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
					Instant Digital Delivery
				</div>
			</div>

		</div>
	</div>
	<?php
} else {
	// Fallback for normal products (if any are ever used)
	?>
	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
		<?php
		do_action( 'woocommerce_before_single_product_summary' );
		?>
		<div class="summary entry-summary">
			<?php
			do_action( 'woocommerce_single_product_summary' );
			?>
		</div>
		<?php
		do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
	<?php
}

do_action( 'woocommerce_after_single_product' );

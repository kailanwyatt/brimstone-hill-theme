<?php
/**
 * Donate — page slug "donate" (e.g. /get-involved/donate). WooCommerce product with dynamic amount.
 *
 * @package Brimstone_Hill
 */

if ( ! function_exists( 'bh_render_donate_page_markup' ) ) {
	/**
	 * Donate form: POST add-to-cart with validated amount for the configured donation product.
	 *
	 * @return void
	 */
	function bh_render_donate_page_markup() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<p class="donate-page__notice">' . esc_html__( 'Online donations require WooCommerce. Please contact us if you need help.', 'brimstone-hill' ) . '</p>';
			return;
		}

		if ( ! function_exists( 'bh_get_donation_product_id' ) || ! bh_get_donation_product_id() ) {
			echo '<p class="donate-page__notice">' . esc_html__( 'Online donations are not configured yet. Create a virtual product with type “Donation (simple)” under Products → Add new, then set Settings → Brimstone Hill → Commerce → Donation product ID.', 'brimstone-hill' ) . '</p>';
			return;
		}
		if ( ! function_exists( 'bh_donate_is_ready' ) || ! bh_donate_is_ready() ) {
			$wrong_type = '';
			if ( function_exists( 'wc_get_product' ) ) {
				$p = wc_get_product( bh_get_donation_product_id() );
				if ( $p && ! in_array( $p->get_type(), array( 'simple', '' ), true ) ) {
					$wrong_type = sprintf(
						/* translators: %s: WooCommerce product type slug */
						__( ' The product you selected is type “%s”; donations require “Donation (simple)”.', 'brimstone-hill' ),
						$p->get_type()
					);
				}
			}
			echo '<p class="donate-page__notice">' . esc_html__( 'The donation product is missing or not purchasable. Use a published virtual “Donation (simple)” product and set its ID under Settings → Brimstone Hill → Commerce.', 'brimstone-hill' ) . esc_html( $wrong_type ) . '</p>';
			return;
		}

		$product_id = bh_get_donation_product_id();
		$presets      = bh_donation_preset_amounts();
		$currency_sym = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';
		?>
	<p class="donate-page__intro">
		<?php esc_html_e( 'Your donation helps preserve the fortress and support education and conservation. Every gift matters.', 'brimstone-hill' ); ?>
	</p>

	<form class="donate-form" id="bh-donate-form" method="post" action="">
		<?php wp_nonce_field( 'bh_donate', 'bh_donation_nonce' ); ?>
		<input type="hidden" name="quantity" value="1" />
		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( (string) $product_id ); ?>" />
		<input type="hidden" name="bh_donation_amount" id="bh-donation-amount" value="" autocomplete="off" />

		<section class="donate-amount">
			<h2 class="donate-form__title"><?php esc_html_e( 'Choose amount', 'brimstone-hill' ); ?></h2>
			<div class="donate-amount__presets" role="group" aria-label="<?php esc_attr_e( 'Preset amounts', 'brimstone-hill' ); ?>">
				<?php foreach ( $presets as $bh_amt ) : ?>
					<button type="button" class="donate-amount__btn" data-amount="<?php echo esc_attr( (string) $bh_amt ); ?>">
						<?php echo esc_html( $currency_sym . number_format_i18n( $bh_amt, function_exists( 'wc_get_price_decimals' ) ? wc_get_price_decimals() : 2 ) ); ?>
					</button>
				<?php endforeach; ?>
				<button type="button" class="donate-amount__btn donate-amount__btn--other" data-amount-other="1">
					<?php esc_html_e( 'Other', 'brimstone-hill' ); ?>
				</button>
			</div>
			<div class="donate-amount__other" id="bh-donate-other-wrap" hidden>
				<label for="donate-other"><?php esc_html_e( 'Amount', 'brimstone-hill' ); ?></label>
				<input
					id="donate-other"
					type="number"
					min="1"
					step="any"
					inputmode="decimal"
					class="donate-form__input"
					autocomplete="transaction-amount"
				/>
			</div>
		</section>

		<section class="donate-optional">
			<h3 class="donate-form__subtitle"><?php esc_html_e( 'Optional', 'brimstone-hill' ); ?></h3>
			<label for="bh-dedication" class="donate-form__label"><?php esc_html_e( 'Dedication (e.g. in memory of …)', 'brimstone-hill' ); ?></label>
			<input
				id="bh-dedication"
				name="bh_dedication"
				type="text"
				class="donate-form__input"
				autocomplete="off"
				placeholder="<?php esc_attr_e( 'Leave blank if not applicable', 'brimstone-hill' ); ?>"
			/>
			<label class="donate-form__checkbox">
				<input type="checkbox" name="bh_anonymous" value="1" id="bh-anonymous" />
				<span><?php esc_html_e( 'Give anonymously', 'brimstone-hill' ); ?></span>
			</label>
		</section>

		<section class="donate-checkout">
			<h3 class="donate-form__subtitle"><?php esc_html_e( 'Complete your donation', 'brimstone-hill' ); ?></h3>
			<p class="donate-checkout__summary" id="bh-donate-summary" hidden></p>
			<p class="donate-form__card-note"><?php esc_html_e( 'You will complete payment securely on the next step (same cards your store accepts at checkout).', 'brimstone-hill' ); ?></p>
			<button type="submit" class="btn btn--primary donate-form__submit" id="bh-donate-submit" disabled>
				<?php esc_html_e( 'Continue to checkout', 'brimstone-hill' ); ?>
			</button>
		</section>
	</form>
		<?php
	}
}

get_header();

while ( have_posts() ) :
	the_post();
	$bh_enable_sidebar = get_post_meta( get_the_ID(), '_bh_sidebar_enabled', true );
	$bh_has_banner     = has_post_thumbnail();
	?>
<main id="main-content" class="bh-page content-page donate-page">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( $bh_has_banner ) : ?>
			<div class="page-banner" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>');" role="img" aria-label="">
				<div class="page-banner__overlay" aria-hidden="true"></div>
				<div class="container page-banner__inner">
					<h1 class="page-banner__title"><?php the_title(); ?></h1>
				</div>
			</div>
		<?php endif; ?>

		<div class="container">
			<?php if ( ! $bh_has_banner ) : ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
			<?php endif; ?>

			<div class="content-page__body <?php echo $bh_enable_sidebar ? 'content-page__body--with-sidebar' : 'content-page__body--full'; ?>">
				<?php if ( $bh_enable_sidebar ) : ?>
					<div class="content-page__layout">
						<div class="content-page__main">
							<?php bh_render_donate_page_markup(); ?>
						</div>
						<aside class="content-page__sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'brimstone-hill' ); ?>">
							<?php get_template_part( 'template-parts/sidebar-menu' ); ?>
						</aside>
					</div>
				<?php else : ?>
					<div class="content-page__main">
						<?php bh_render_donate_page_markup(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</article>
</main>
	<?php
endwhile;

get_footer();

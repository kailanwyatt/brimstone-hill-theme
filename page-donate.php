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
			echo '<p class="donate-page__notice">' . esc_html__( 'Online donations are not available at the moment. Please contact us for other ways to give.', 'brimstone-hill' ) . '</p>';
			return;
		}

		if ( ! function_exists( 'bh_get_donation_product_id' ) || ! bh_get_donation_product_id() ) {
			echo '<p class="donate-page__notice">' . esc_html__( 'Online donations are not available yet. Please contact us for assistance.', 'brimstone-hill' ) . '</p>';
			return;
		}
		if ( ! function_exists( 'bh_donate_is_ready' ) || ! bh_donate_is_ready() ) {
			echo '<p class="donate-page__notice">' . esc_html__( 'Online donations are temporarily unavailable. Please contact us for assistance.', 'brimstone-hill' ) . '</p>';
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
	?>
<main id="main-content" class="bh-page content-page content-page--wide donate-page <?php echo has_post_thumbnail() ? 'content-page--has-banner' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/page', 'header' ); ?>
		<?php bh_render_page_content_shell_open(); ?>
		<div class="content-page__body content-page__body--full">
			<div class="content-page__main">
				<?php bh_render_donate_page_markup(); ?>
			</div>
		</div>
		<?php bh_render_page_content_shell_close(); ?>
	</article>
</main>
	<?php
endwhile;

get_footer();

<?php
/**
 * Donate — page slug "donate" (e.g. /get-involved/donate). Replaces broken imported JSX with a working mock form.
 *
 * @package Brimstone_Hill
 */

if ( ! function_exists( 'bh_render_donate_page_markup' ) ) {
	/**
	 * Donate form markup (mock checkout — mirrors the prototype behaviour).
	 *
	 * @return void
	 */
	function bh_render_donate_page_markup() {
		?>
	<p class="donate-page__intro">
		<?php esc_html_e( 'Your donation helps preserve the fortress and support education and conservation. Every gift matters.', 'brimstone-hill' ); ?>
	</p>

	<div class="donate-thanks" id="bh-donate-thanks" hidden>
		<h2 class="donate-thanks__title"><?php esc_html_e( 'Thank you for your donation', 'brimstone-hill' ); ?></h2>
		<p class="donate-thanks__text">
			<?php esc_html_e( 'Receipt will be sent to ', 'brimstone-hill' ); ?>
			<strong id="bh-donate-thanks-email"></strong>.
			<?php esc_html_e( 'Your support makes a difference.', 'brimstone-hill' ); ?>
		</p>
	</div>

	<form class="donate-form" id="bh-donate-form" novalidate>
		<section class="donate-amount">
			<h2 class="donate-form__title"><?php esc_html_e( 'Choose amount', 'brimstone-hill' ); ?></h2>
			<div class="donate-amount__presets" role="group" aria-label="<?php esc_attr_e( 'Preset amounts', 'brimstone-hill' ); ?>">
				<?php foreach ( array( 25, 50, 100, 250 ) as $bh_amt ) : ?>
					<button type="button" class="donate-amount__btn" data-amount="<?php echo esc_attr( (string) $bh_amt ); ?>">
						$<?php echo esc_html( (string) $bh_amt ); ?>
					</button>
				<?php endforeach; ?>
				<button type="button" class="donate-amount__btn donate-amount__btn--other" data-amount-other="1">
					<?php esc_html_e( 'Other', 'brimstone-hill' ); ?>
				</button>
			</div>
			<div class="donate-amount__other" id="bh-donate-other-wrap" hidden>
				<label for="donate-other"><?php esc_html_e( 'Amount (USD)', 'brimstone-hill' ); ?></label>
				<input
					id="donate-other"
					type="number"
					min="1"
					step="1"
					inputmode="numeric"
					class="donate-form__input"
					autocomplete="transaction-amount"
				/>
			</div>
			<div class="donate-amount__recurring">
				<label class="donate-form__checkbox">
					<input type="checkbox" id="bh-donate-recurring" />
					<span><?php esc_html_e( 'Monthly donation', 'brimstone-hill' ); ?></span>
				</label>
			</div>
		</section>

		<section class="donate-optional">
			<h3 class="donate-form__subtitle"><?php esc_html_e( 'Optional', 'brimstone-hill' ); ?></h3>
			<label for="donate-dedication" class="donate-form__label"><?php esc_html_e( 'Dedication (e.g. in memory of …)', 'brimstone-hill' ); ?></label>
			<input
				id="donate-dedication"
				type="text"
				class="donate-form__input"
				autocomplete="off"
				placeholder="<?php esc_attr_e( 'Leave blank if not applicable', 'brimstone-hill' ); ?>"
			/>
			<label class="donate-form__checkbox">
				<input type="checkbox" id="bh-donate-anon" />
				<span><?php esc_html_e( 'Give anonymously', 'brimstone-hill' ); ?></span>
			</label>
		</section>

		<section class="donate-checkout">
			<h3 class="donate-form__subtitle"><?php esc_html_e( 'Complete your donation', 'brimstone-hill' ); ?></h3>
			<p class="donate-checkout__summary" id="bh-donate-summary" hidden></p>
			<label for="donate-email" class="donate-form__label"><?php esc_html_e( 'Email (for receipt)', 'brimstone-hill' ); ?> <span aria-hidden="true">*</span></label>
			<input
				id="donate-email"
				type="email"
				class="donate-form__input"
				required
				autocomplete="email"
			/>
			<p class="donate-form__card-note"><?php esc_html_e( 'Card brands: Visa, Mastercard, Discover.', 'brimstone-hill' ); ?></p>
			<button type="submit" class="btn btn--primary donate-form__submit" id="bh-donate-submit" disabled>
				<?php esc_html_e( 'Pay with card (mock)', 'brimstone-hill' ); ?>
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

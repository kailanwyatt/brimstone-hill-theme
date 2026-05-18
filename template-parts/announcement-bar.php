<?php
/**
 * Announcement Bar (Top Bar) — reads Settings → Brimstone Hill.
 *
 * @package Brimstone_Hill
 */

if ( ! bh_announcement_bar_enabled() ) {
	return;
}

$text  = bh_announcement_message();
$links = bh_announcement_links();

if ( '' === trim( $text ) && empty( $links ) ) {
	return;
}
?>
<div class="top-bar">
	<div class="top-bar__inner container">
		<?php if ( '' !== trim( $text ) ) : ?>
			<p class="top-bar__message"><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $links ) ) : ?>
			<nav class="top-bar__links" aria-label="<?php esc_attr_e( 'Quick links', 'brimstone-hill' ); ?>">
				<?php foreach ( $links as $link ) : ?>
					<a href="<?php echo esc_url( $link['url'] ); ?>" class="top-bar__link"><?php echo esc_html( $link['label'] ); ?></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
	</div>
</div>

<?php
/**
 * Social profile links (Facebook, YouTube).
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Social profiles for header and footer.
 *
 * @return array<int, array{id:string,label:string,url:string}>
 */
function bh_social_profiles() {
	return array(
		array(
			'id'    => 'facebook',
			'label' => __( 'Facebook', 'brimstone-hill' ),
			'url'   => 'https://www.facebook.com/Brimstone-Hill-Fortress-National-Park-1171645556233030/',
		),
		array(
			'id'    => 'youtube',
			'label' => __( 'YouTube', 'brimstone-hill' ),
			'url'   => 'https://www.youtube.com/user/brimstonehill',
		),
	);
}

/**
 * SVG icon markup for a social network.
 *
 * @param string $id Network id (facebook|youtube).
 * @return string
 */
function bh_social_icon_svg( $id ) {
	switch ( $id ) {
		case 'facebook':
			return '<svg class="bh-social__icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>';
		case 'youtube':
			return '<svg class="bh-social__icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';
		default:
			return '';
	}
}

/**
 * Render social icon links.
 *
 * @param array $args {
 *     @type string $class Extra classes on the list element.
 * }
 */
function bh_render_social_links( $args = array() ) {
	$profiles = bh_social_profiles();
	if ( empty( $profiles ) ) {
		return;
	}

	$args = wp_parse_args(
		$args,
		array(
			'class' => 'bh-social',
		)
	);

	$class = trim( 'bh-social ' . (string) $args['class'] );
	?>
	<ul class="<?php echo esc_attr( $class ); ?>" role="list">
		<?php foreach ( $profiles as $profile ) : ?>
			<?php
			$icon = bh_social_icon_svg( $profile['id'] );
			if ( '' === $icon ) {
				continue;
			}
			?>
			<li class="bh-social__item">
				<a
					class="bh-social__link"
					href="<?php echo esc_url( $profile['url'] ); ?>"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php echo esc_attr( $profile['label'] ); ?>"
				>
					<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

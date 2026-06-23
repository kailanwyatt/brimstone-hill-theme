<?php
/**
 * Yabe Webfont bridge for area-based typography.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return bool
 */
function bh_yabe_webfont_is_active() {
	return class_exists( '\Yabe\Webfont\Utils\Font' );
}

/**
 * Typography areas mapped to CSS variables.
 *
 * @return array<string, string>
 */
function bh_typography_areas() {
	return array(
		'heading'     => '--font-heading',
		'body'        => '--font-body',
		'site_header' => '--font-site-header',
		'navigation'  => '--font-navigation',
		'footer'      => '--font-footer',
		'buttons'     => '--font-buttons',
	);
}

/**
 * Default font stacks when Yabe is unavailable.
 *
 * @return array<string, string>
 */
function bh_typography_default_stacks() {
	return array(
		'heading'     => bh_typography_default_heading_stack(),
		'body'        => bh_typography_default_body_stack(),
		'site_header' => bh_typography_default_heading_stack(),
		'navigation'  => bh_typography_default_body_stack(),
		'footer'      => bh_typography_default_body_stack(),
		'buttons'     => bh_typography_default_body_stack(),
	);
}

/**
 * Yabe families for admin dropdowns.
 *
 * @return array<string, string> slug => label
 */
function bh_yabe_font_choices() {
	$choices = array(
		'' => __( 'Theme default', 'brimstone-hill' ),
	);

	if ( ! bh_yabe_webfont_is_active() ) {
		return $choices;
	}

	$fonts = \Yabe\Webfont\Utils\Font::get_all();
	if ( ! is_array( $fonts ) ) {
		return $choices;
	}

	foreach ( $fonts as $font ) {
		$name = '';
		if ( is_array( $font ) && ! empty( $font['family'] ) ) {
			$name = (string) $font['family'];
		} elseif ( is_object( $font ) && isset( $font->family ) ) {
			$name = (string) $font->family;
		} elseif ( is_string( $font ) ) {
			$name = $font;
		}
		if ( '' !== $name ) {
			$choices[ $name ] = $name;
		}
	}

	return $choices;
}

/**
 * CSS value for a saved Yabe family with fallbacks.
 *
 * @param string $area        Area key.
 * @param string $family_name Saved Yabe family or empty.
 * @return string
 */
function bh_yabe_area_font_css_value( $area, $family_name ) {
	$defaults = bh_typography_default_stacks();
	$fallback = isset( $defaults[ $area ] ) ? $defaults[ $area ] : $defaults['body'];

	if ( '' === trim( (string) $family_name ) || ! bh_yabe_webfont_is_active() ) {
		if ( 'navigation' === $area || 'site_header' === $area || 'footer' === $area || 'buttons' === $area ) {
			return 'var(--font-body, ' . $fallback . ')';
		}
		return $fallback;
	}

	$yabe_var = (string) \Yabe\Webfont\Utils\Font::css_custom_property( $family_name );
	if ( 'navigation' === $area || 'site_header' === $area || 'footer' === $area || 'buttons' === $area ) {
		return 'var(' . $yabe_var . ', var(--font-body, ' . $fallback . '))';
	}
	return 'var(' . $yabe_var . ', ' . $fallback . ')';
}

/**
 * Inline :root CSS for typography variables.
 *
 * @return string
 */
function bh_typography_inline_css() {
	$areas  = bh_typography_areas();
	$rules  = array();
	foreach ( $areas as $area => $css_var ) {
		$family = (string) get_option( 'bh_typography_' . $area . '_font', '' );
		if ( 'heading' === $area && '' === $family ) {
			$family = (string) get_option( 'bh_typography_heading_font', '' );
		}
		if ( 'body' === $area && '' === $family ) {
			$family = (string) get_option( 'bh_typography_body_font', '' );
		}
		$rules[] = $css_var . ': ' . bh_yabe_area_font_css_value( $area, $family ) . ';';
	}
	return ':root { ' . implode( ' ', $rules ) . ' }';
}

/**
 * Admin notice when Yabe Webfont is not active.
 */
function bh_yabe_webfont_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) || bh_yabe_webfont_is_active() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'appearance_page_bh-typography-settings' !== $screen->id ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' . esc_html__( 'Install and activate Yabe Webfont to self-host custom fonts. Typography will use theme defaults until then.', 'brimstone-hill' ) . '</p></div>';
}
add_action( 'admin_notices', 'bh_yabe_webfont_admin_notice' );

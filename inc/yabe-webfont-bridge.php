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
 * Typography areas with CSS variable, fallback expression, label, and admin section.
 *
 * @return array<string, array{css_var:string,fallback:string,label:string,section:string}>
 */
function bh_typography_areas_config() {
	$heading_stack = bh_typography_default_heading_stack();
	$body_stack    = bh_typography_default_body_stack();

	return array(
		'body' => array(
			'css_var'  => '--font-body',
			'fallback' => $body_stack,
			'label'    => __( 'Body', 'brimstone-hill' ),
			'section'  => 'base',
		),
		'heading' => array(
			'css_var'  => '--font-heading',
			'fallback' => $heading_stack,
			'label'    => __( 'Headings (default)', 'brimstone-hill' ),
			'section'  => 'base',
		),
		'h1' => array(
			'css_var'  => '--font-h1',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'H1', 'brimstone-hill' ),
			'section'  => 'headings',
		),
		'h2' => array(
			'css_var'  => '--font-h2',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'H2', 'brimstone-hill' ),
			'section'  => 'headings',
		),
		'h3' => array(
			'css_var'  => '--font-h3',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'H3', 'brimstone-hill' ),
			'section'  => 'headings',
		),
		'h4' => array(
			'css_var'  => '--font-h4',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'H4', 'brimstone-hill' ),
			'section'  => 'headings',
		),
		'h5' => array(
			'css_var'  => '--font-h5',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'H5', 'brimstone-hill' ),
			'section'  => 'headings',
		),
		'h6' => array(
			'css_var'  => '--font-h6',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'H6', 'brimstone-hill' ),
			'section'  => 'headings',
		),
		'site_header' => array(
			'css_var'  => '--font-site-header',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'Site header / brand', 'brimstone-hill' ),
			'section'  => 'chrome',
		),
		'navigation' => array(
			'css_var'  => '--font-navigation',
			'fallback' => 'var(--font-body)',
			'label'    => __( 'Navigation', 'brimstone-hill' ),
			'section'  => 'chrome',
		),
		'page_banner_title' => array(
			'css_var'  => '--font-page-banner-title',
			'fallback' => 'var(--font-h1, var(--font-heading))',
			'label'    => __( 'Page banner title', 'brimstone-hill' ),
			'section'  => 'chrome',
		),
		'breadcrumbs' => array(
			'css_var'  => '--font-breadcrumbs',
			'fallback' => 'var(--font-body)',
			'label'    => __( 'Breadcrumbs', 'brimstone-hill' ),
			'section'  => 'chrome',
		),
		'buttons' => array(
			'css_var'  => '--font-buttons',
			'fallback' => 'var(--font-body)',
			'label'    => __( 'Buttons / CTAs', 'brimstone-hill' ),
			'section'  => 'actions',
		),
		'body_links' => array(
			'css_var'  => '--font-body-links',
			'fallback' => 'var(--font-body)',
			'label'    => __( 'Body / content links', 'brimstone-hill' ),
			'section'  => 'content',
		),
		'footer' => array(
			'css_var'  => '--font-footer',
			'fallback' => 'var(--font-body)',
			'label'    => __( 'Footer (general)', 'brimstone-hill' ),
			'section'  => 'footer',
		),
		'footer_heading' => array(
			'css_var'  => '--font-footer-heading',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'Footer headings', 'brimstone-hill' ),
			'section'  => 'footer',
		),
		'footer_brand' => array(
			'css_var'  => '--font-footer-brand',
			'fallback' => 'var(--font-heading)',
			'label'    => __( 'Footer brand name', 'brimstone-hill' ),
			'section'  => 'footer',
		),
	);
}

/**
 * Typography areas mapped to CSS variables (legacy shape for callers).
 *
 * @return array<string, string>
 */
function bh_typography_areas() {
	$map = array();
	foreach ( bh_typography_areas_config() as $key => $config ) {
		$map[ $key ] = $config['css_var'];
	}
	return $map;
}

/**
 * Admin section definitions for Typography Settings.
 *
 * @return array<string, array{title:string,description:string}>
 */
function bh_typography_admin_sections() {
	return array(
		'base'     => array(
			'title'       => __( 'Base', 'brimstone-hill' ),
			'description' => __( 'Default body and heading stacks. Other controls inherit these when left on “Theme default”.', 'brimstone-hill' ),
		),
		'headings' => array(
			'title'       => __( 'Heading levels', 'brimstone-hill' ),
			'description' => __( 'Optional overrides for each heading level. Empty inherits Headings (default).', 'brimstone-hill' ),
		),
		'chrome'   => array(
			'title'       => __( 'Page chrome', 'brimstone-hill' ),
			'description' => __( 'Header brand, navigation, page banner titles, and breadcrumbs.', 'brimstone-hill' ),
		),
		'actions'  => array(
			'title'       => __( 'Actions', 'brimstone-hill' ),
			'description' => __( 'Buttons and call-to-action controls site-wide.', 'brimstone-hill' ),
		),
		'content'  => array(
			'title'       => __( 'Content', 'brimstone-hill' ),
			'description' => __( 'Inline links in page content (excludes buttons and navigation).', 'brimstone-hill' ),
		),
		'footer'   => array(
			'title'       => __( 'Footer', 'brimstone-hill' ),
			'description' => __( 'Footer body text, column headings, and brand name.', 'brimstone-hill' ),
		),
	);
}

/**
 * Default font stacks when Yabe is unavailable.
 *
 * @return array<string, string>
 */
function bh_typography_default_stacks() {
	$out = array();
	foreach ( bh_typography_areas_config() as $key => $config ) {
		$out[ $key ] = $config['fallback'];
	}
	return $out;
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

	if ( ! bh_yabe_webfont_is_active() || ! method_exists( '\Yabe\Webfont\Utils\Font', 'get_fonts' ) ) {
		return $choices;
	}

	$fonts = \Yabe\Webfont\Utils\Font::get_fonts();
	if ( ! is_array( $fonts ) ) {
		return $choices;
	}

	foreach ( $fonts as $font ) {
		$family = '';
		$label  = '';
		if ( is_array( $font ) ) {
			$family = ! empty( $font['family'] ) ? (string) $font['family'] : '';
			$label  = ! empty( $font['title'] ) ? (string) $font['title'] : $family;
		} elseif ( is_object( $font ) ) {
			$family = isset( $font->family ) ? (string) $font->family : '';
			$label  = isset( $font->title ) ? (string) $font->title : $family;
		} elseif ( is_string( $font ) ) {
			$family = $font;
			$label  = $font;
		}
		if ( '' !== $family ) {
			$choices[ $family ] = '' !== $label ? $label : $family;
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
	$config   = bh_typography_areas_config();
	$fallback = isset( $config[ $area ]['fallback'] ) ? $config[ $area ]['fallback'] : bh_typography_default_body_stack();

	if (
		'' === trim( (string) $family_name )
		|| ! bh_yabe_webfont_is_active()
		|| ! method_exists( '\Yabe\Webfont\Utils\Font', 'css_custom_property' )
	) {
		return $fallback;
	}

	$yabe_var = (string) \Yabe\Webfont\Utils\Font::css_custom_property( $family_name );
	return 'var(' . $yabe_var . ', ' . $fallback . ')';
}

/**
 * Resolve saved family for an area (including legacy option keys).
 *
 * @param string $area Area key.
 * @return string
 */
function bh_typography_saved_family( $area ) {
	$family = (string) get_option( 'bh_typography_' . $area . '_font', '' );
	if ( '' !== $family ) {
		return $family;
	}
	if ( 'heading' === $area ) {
		return (string) get_option( 'bh_typography_heading_font', '' );
	}
	if ( 'body' === $area ) {
		return (string) get_option( 'bh_typography_body_font', '' );
	}
	return '';
}

/**
 * Inline :root CSS for typography variables.
 *
 * Empty non-base options omit the variable so CSS-file cascades apply.
 *
 * @return string
 */
function bh_typography_inline_css() {
	$config = bh_typography_areas_config();
	$rules  = array();

	foreach ( $config as $area => $meta ) {
		$family = bh_typography_saved_family( $area );
		if ( '' === trim( $family ) && ! in_array( $area, array( 'body', 'heading' ), true ) ) {
			continue;
		}
		$rules[] = $meta['css_var'] . ': ' . bh_yabe_area_font_css_value( $area, $family ) . ';';
	}

	if ( empty( $rules ) ) {
		return '';
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

<?php
/**
 * Theme Customizer — public commerce settings live under Settings → Brimstone Hill (plugin).
 *
 * @package Brimstone_Hill
 */

/**
 * Register customize settings.
 *
 * Donation and membership product configuration is managed in the plugin only:
 * Settings → Brimstone Hill → Commerce.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bh_customize_register( $wp_customize ) {
	// Intentionally empty — avoid duplicating plugin Commerce options.
}
add_action( 'customize_register', 'bh_customize_register' );

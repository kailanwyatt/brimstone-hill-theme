<?php
/**
 * Theme Customizer
 *
 * @package Brimstone_Hill
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bh_customize_register( $wp_customize ) {
	// Announcement Bar Section
	$wp_customize->add_section(
		'bh_announcement_bar',
		array(
			'title'       => __( 'Announcement Bar', 'brimstone-hill' ),
			'description' => __( 'Settings for the top announcement bar.', 'brimstone-hill' ),
			'priority'    => 20,
		)
	);

	// Enable/Disable
	$wp_customize->add_setting(
		'bh_announcement_enabled',
		array(
			'default'           => true,
			'sanitize_callback' => 'bh_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bh_announcement_enabled',
		array(
			'label'   => __( 'Enable Announcement Bar', 'brimstone-hill' ),
			'section' => 'bh_announcement_bar',
			'type'    => 'checkbox',
		)
	);

	// Announcement Text
	$wp_customize->add_setting(
		'bh_announcement_text',
		array(
			'default'           => 'Open daily 9:30am–5:30pm · Book your visit today',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'bh_announcement_text',
		array(
			'label'   => __( 'Announcement Text', 'brimstone-hill' ),
			'section' => 'bh_announcement_bar',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'bh_customize_register' );

/**
 * Sanitize checkbox
 */
function bh_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

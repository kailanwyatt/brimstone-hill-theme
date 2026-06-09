<?php
/**
 * Contact page settings.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register contact settings page.
 */
function bh_register_contact_settings_page() {
	add_theme_page(
		__( 'Contact Settings', 'brimstone-hill' ),
		__( 'Contact Settings', 'brimstone-hill' ),
		'manage_options',
		'bh-contact-settings',
		'bh_render_contact_settings_page'
	);
}
add_action( 'admin_menu', 'bh_register_contact_settings_page' );

/**
 * Register contact settings.
 */
function bh_register_contact_settings() {
	$fields = array(
		'bh_contact_cf7_shortcode',
		'bh_contact_intro_heading',
		'bh_contact_intro_lead',
		'bh_contact_intro_note',
		'bh_contact_office_title',
		'bh_contact_office_description',
		'bh_contact_office_address',
		'bh_contact_office_phone',
		'bh_contact_office_email',
		'bh_contact_fortress_title',
		'bh_contact_fortress_description',
		'bh_contact_fortress_address',
		'bh_contact_fortress_phone',
		'bh_contact_fortress_email',
		'bh_contact_fortress_hours',
		'bh_contact_fortress_directions_url',
	);

	foreach ( $fields as $field ) {
		register_setting( 'bh-contact-settings', $field );
	}

	add_settings_section(
		'bh_contact_form',
		__( 'Contact form', 'brimstone-hill' ),
		function () {
			echo '<p class="description">' . esc_html__( 'Install Contact Form 7, create a form, and paste its shortcode below.', 'brimstone-hill' ) . '</p>';
		},
		'bh-contact-settings'
	);

	add_settings_field(
		'bh_contact_cf7_shortcode',
		__( 'CF7 shortcode', 'brimstone-hill' ),
		'bh_render_contact_text_field',
		'bh-contact-settings',
		'bh_contact_form',
		array(
			'id'          => 'bh_contact_cf7_shortcode',
			'placeholder' => '[contact-form-7 id="123" title="Contact"]',
		)
	);

	add_settings_section(
		'bh_contact_intro',
		__( 'Intro', 'brimstone-hill' ),
		function () {
			echo '<p class="description">' . esc_html__( 'Shown above the location columns.', 'brimstone-hill' ) . '</p>';
		},
		'bh-contact-settings'
	);
	add_settings_field( 'bh_contact_intro_heading', __( 'Heading', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_intro', array( 'id' => 'bh_contact_intro_heading', 'default' => 'Get in touch' ) );
	add_settings_field( 'bh_contact_intro_lead', __( 'Lead paragraph', 'brimstone-hill' ), 'bh_render_contact_textarea_field', 'bh-contact-settings', 'bh_contact_intro', array( 'id' => 'bh_contact_intro_lead', 'default' => 'The head office handles membership, group bookings, and general enquiries. The fortress visitor centre is open daily for on-site questions and admissions.' ) );
	add_settings_field( 'bh_contact_intro_note', __( 'Note', 'brimstone-hill' ), 'bh_render_contact_textarea_field', 'bh-contact-settings', 'bh_contact_intro', array( 'id' => 'bh_contact_intro_note', 'default' => 'We aim to reply to all enquiries as soon as possible during business hours.' ) );

	add_settings_section( 'bh_contact_office', __( 'Head Office — Taylor\'s Range', 'brimstone-hill' ), '__return_false', 'bh-contact-settings' );
	add_settings_field( 'bh_contact_office_title', __( 'Location title', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_office', array( 'id' => 'bh_contact_office_title', 'default' => "Head Office — Taylor's Range" ) );
	add_settings_field( 'bh_contact_office_description', __( 'Short description', 'brimstone-hill' ), 'bh_render_contact_textarea_field', 'bh-contact-settings', 'bh_contact_office', array( 'id' => 'bh_contact_office_description', 'default' => 'For membership, donations, group visits, school bookings, and general enquiries.' ) );
	add_settings_field( 'bh_contact_office_address', __( 'Address', 'brimstone-hill' ), 'bh_render_contact_textarea_field', 'bh-contact-settings', 'bh_contact_office', array( 'id' => 'bh_contact_office_address', 'default' => "P.O. Box 588 Taylor's Range\nBasseterre\nSt. Kitts, West Indies" ) );
	add_settings_field( 'bh_contact_office_phone', __( 'Phone', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_office', array( 'id' => 'bh_contact_office_phone', 'default' => '869-465-2609' ) );
	add_settings_field( 'bh_contact_office_email', __( 'Email', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_office', array( 'id' => 'bh_contact_office_email', 'default' => 'info@brimstonehillfortress.org' ) );

	add_settings_section( 'bh_contact_fortress', __( 'Fortress — New Guinea', 'brimstone-hill' ), '__return_false', 'bh-contact-settings' );
	add_settings_field( 'bh_contact_fortress_title', __( 'Location title', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_fortress', array( 'id' => 'bh_contact_fortress_title', 'default' => 'Fortress — New Guinea' ) );
	add_settings_field( 'bh_contact_fortress_description', __( 'Short description', 'brimstone-hill' ), 'bh_render_contact_textarea_field', 'bh-contact-settings', 'bh_contact_fortress', array( 'id' => 'bh_contact_fortress_description', 'default' => 'On-site visitor centre, admissions, and directions for your visit to the fortress.' ) );
	add_settings_field( 'bh_contact_fortress_address', __( 'Address', 'brimstone-hill' ), 'bh_render_contact_textarea_field', 'bh-contact-settings', 'bh_contact_fortress', array( 'id' => 'bh_contact_fortress_address', 'default' => "Brimstone Hill Fortress National Park\nSt. Kitts, West Indies" ) );
	add_settings_field( 'bh_contact_fortress_phone', __( 'Phone', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_fortress', array( 'id' => 'bh_contact_fortress_phone', 'default' => '869-465-6771' ) );
	add_settings_field( 'bh_contact_fortress_email', __( 'Email', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_fortress', array( 'id' => 'bh_contact_fortress_email', 'default' => 'info@brimstonehillfortress.org' ) );
	add_settings_field( 'bh_contact_fortress_hours', __( 'Hours', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_fortress', array( 'id' => 'bh_contact_fortress_hours', 'default' => 'Open daily 9:30am–5:30pm' ) );
	add_settings_field( 'bh_contact_fortress_directions_url', __( 'Directions URL', 'brimstone-hill' ), 'bh_render_contact_text_field', 'bh-contact-settings', 'bh_contact_fortress', array( 'id' => 'bh_contact_fortress_directions_url', 'default' => '/visit/directions/' ) );
}
add_action( 'admin_init', 'bh_register_contact_settings' );

/**
 * Render settings page.
 */
function bh_render_contact_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Contact Settings', 'brimstone-hill' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'bh-contact-settings' );
			do_settings_sections( 'bh-contact-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Render a text field.
 *
 * @param array $args Field args.
 */
function bh_render_contact_text_field( $args ) {
	$id      = $args['id'];
	$value   = get_option( $id, isset( $args['default'] ) ? $args['default'] : '' );
	$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
	printf(
		'<input type="text" class="regular-text" id="%1$s" name="%1$s" value="%2$s" placeholder="%3$s" />',
		esc_attr( $id ),
		esc_attr( $value ),
		esc_attr( $placeholder )
	);
}

/**
 * Render a textarea field.
 *
 * @param array $args Field args.
 */
function bh_render_contact_textarea_field( $args ) {
	$id    = $args['id'];
	$value = get_option( $id, isset( $args['default'] ) ? $args['default'] : '' );
	printf(
		'<textarea class="large-text" rows="4" id="%1$s" name="%1$s">%2$s</textarea>',
		esc_attr( $id ),
		esc_textarea( $value )
	);
}

/**
 * Get a contact setting with default fallback.
 *
 * @param string $key Option key.
 * @param string $default Default value.
 * @return string
 */
function bh_get_contact_setting( $key, $default = '' ) {
	$value = get_option( $key, $default );
	return is_string( $value ) ? $value : $default;
}

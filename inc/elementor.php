<?php
/**
 * Elementor compatibility.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether Elementor is available.
 *
 * @return bool
 */
function bh_elementor_is_active() {
	return did_action( 'elementor/loaded' ) || class_exists( '\Elementor\Plugin' );
}

/**
 * Whether the theme should keep its header and footer when Elementor Pro Theme Builder is used.
 *
 * @return bool
 */
function bh_elementor_lock_chrome_enabled() {
	return (bool) get_option( 'bh_elementor_lock_chrome', true );
}

/**
 * Whether a page should use the Elementor wide content shell.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function bh_is_elementor_page( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}

	if ( $post_id && is_page_template( 'page-elementor.php', $post_id ) ) {
		return true;
	}

	if ( ! bh_elementor_is_active() || ! $post_id ) {
		return false;
	}

	return (bool) \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id );
}

/**
 * Register Elementor settings page.
 */
function bh_register_elementor_settings_page() {
	add_theme_page(
		__( 'Elementor Settings', 'brimstone-hill' ),
		__( 'Elementor Settings', 'brimstone-hill' ),
		'manage_options',
		'bh-elementor-settings',
		'bh_render_elementor_settings_page'
	);
}
add_action( 'admin_menu', 'bh_register_elementor_settings_page' );

/**
 * Register Elementor settings.
 */
function bh_register_elementor_settings() {
	register_setting(
		'bh-elementor-settings',
		'bh_elementor_lock_chrome',
		array(
			'type'              => 'boolean',
			'sanitize_callback' => function ( $value ) {
				return (bool) $value;
			},
			'default'           => true,
		)
	);

	add_settings_section(
		'bh_elementor_chrome',
		__( 'Theme header and footer', 'brimstone-hill' ),
		function () {
			echo '<p class="description">' . esc_html__( 'When enabled, the Brimstone Hill theme header and footer always render. Elementor Pro Theme Builder header/footer templates are ignored.', 'brimstone-hill' ) . '</p>';
		},
		'bh-elementor-settings'
	);

	add_settings_field(
		'bh_elementor_lock_chrome',
		__( 'Lock theme header & footer', 'brimstone-hill' ),
		'bh_render_elementor_lock_chrome_field',
		'bh-elementor-settings',
		'bh_elementor_chrome'
	);
}
add_action( 'admin_init', 'bh_register_elementor_settings' );

/**
 * Render the lock chrome checkbox.
 */
function bh_render_elementor_lock_chrome_field() {
	$value = bh_elementor_lock_chrome_enabled();
	echo '<input type="hidden" name="bh_elementor_lock_chrome" value="0" />';
	printf(
		'<label><input type="checkbox" name="bh_elementor_lock_chrome" value="1" %1$s /> %2$s</label>',
		checked( $value, true, false ),
		esc_html__( 'Keep the theme header and footer on all pages', 'brimstone-hill' )
	);
}

/**
 * Render Elementor settings page.
 */
function bh_render_elementor_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Elementor Settings', 'brimstone-hill' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'bh-elementor-settings' );
			do_settings_sections( 'bh-elementor-settings' );
			submit_button();
			?>
		</form>
		<hr />
		<h2><?php esc_html_e( 'Using Elementor with this theme', 'brimstone-hill' ); ?></h2>
		<ul style="list-style: disc; padding-left: 1.25rem;">
			<li><?php esc_html_e( 'Use Elementor’s default page layout — not “Elementor Canvas”. Canvas removes the theme header and footer entirely.', 'brimstone-hill' ); ?></li>
			<li><?php esc_html_e( 'Pages built with Elementor render full-width content while the theme header and footer stay in place (when locked above).', 'brimstone-hill' ); ?></li>
			<li><?php esc_html_e( 'Rebuilding the static homepage in Elementor replaces the PHP homepage sections for that page only.', 'brimstone-hill' ); ?></li>
			<li><?php esc_html_e( 'Dedicated templates (Contact, Book tickets, Gallery, etc.) should stay on their theme templates unless you intentionally replace them.', 'brimstone-hill' ); ?></li>
		</ul>
	</div>
	<?php
}

/**
 * Prevent Elementor Theme Builder from replacing theme header/footer.
 *
 * @param bool   $do_location Whether Elementor should render the location.
 * @param string $location    Location slug.
 * @return bool
 */
function bh_elementor_filter_theme_location( $do_location, $location ) {
	if ( bh_elementor_lock_chrome_enabled() && in_array( $location, array( 'header', 'footer' ), true ) ) {
		return false;
	}

	return $do_location;
}
add_filter( 'elementor/theme/do_location', 'bh_elementor_filter_theme_location', 10, 2 );

/**
 * Add body class for Elementor-built pages.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function bh_elementor_body_class( $classes ) {
	if ( is_singular() && bh_is_elementor_page( get_queried_object_id() ) ) {
		$classes[] = 'bh-elementor-page';
	}

	return $classes;
}
add_filter( 'body_class', 'bh_elementor_body_class' );

/**
 * Register Elementor widgets.
 */
function bh_register_elementor_widgets( $widgets_manager ) {
	if ( ! class_exists( 'BHFP_Accordion' ) ) {
		return;
	}
	require_once BH_THEME_DIR . '/inc/elementor/class-bh-elementor-accordion.php';
	$widgets_manager->register( new BH_Elementor_Accordion() );
}
add_action( 'elementor/widgets/register', 'bh_register_elementor_widgets' );

<?php
/**
 * Sidebar Settings and Metaboxes
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register sidebar settings page in admin menu
 */
function bh_register_sidebar_settings_page() {
	add_menu_page(
		__( 'Sidebar Settings', 'brimstone-hill' ),
		__( 'Sidebar Settings', 'brimstone-hill' ),
		'manage_options',
		'bh-sidebar-settings',
		'bh_render_sidebar_settings_page',
		'dashicons-layout',
		25
	);
}
add_action( 'admin_menu', 'bh_register_sidebar_settings_page' );

/**
 * Render sidebar settings page
 */
function bh_render_sidebar_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Sidebar Settings', 'brimstone-hill' ); ?></h1>
		<p><?php esc_html_e( 'Configure global sidebar content and messaging that can be used across pages.', 'brimstone-hill' ); ?></p>

		<form method="post" action="options.php">
			<?php
			settings_fields( 'bh-sidebar-settings' );
			do_settings_sections( 'bh-sidebar-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Register sidebar settings
 */
function bh_register_sidebar_settings() {
	// Register the setting
	register_setting( 'bh-sidebar-settings', 'bh_sidebar_global_message' );
	register_setting( 'bh-sidebar-settings', 'bh_sidebar_global_menu' );

	// Add settings section
	add_settings_section(
		'bh-sidebar-section',
		__( 'Global Sidebar Content', 'brimstone-hill' ),
		'bh_render_sidebar_section',
		'bh-sidebar-settings'
	);

	// Global message field
	add_settings_field(
		'bh_sidebar_global_message',
		__( 'Global Sidebar Message', 'brimstone-hill' ),
		'bh_render_global_message_field',
		'bh-sidebar-settings',
		'bh-sidebar-section'
	);

	// Global menu selector field
	add_settings_field(
		'bh_sidebar_global_menu',
		__( 'Default Sidebar Menu', 'brimstone-hill' ),
		'bh_render_global_menu_field',
		'bh-sidebar-settings',
		'bh-sidebar-section'
	);
}
add_action( 'admin_init', 'bh_register_sidebar_settings' );

/**
 * Render settings section description
 */
function bh_render_sidebar_section() {
	echo wp_kses_post( '<p>' . __( 'Configure default content that will appear in sidebars when enabled. Individual pages can override these settings.', 'brimstone-hill' ) . '</p>' );
}

/**
 * Render global message field
 */
function bh_render_global_message_field() {
	$message = get_option( 'bh_sidebar_global_message' );
	?>
	<p>
		<label><?php esc_html_e( 'Enter custom HTML or text to display in sidebars:', 'brimstone-hill' ); ?></label>
	</p>
	<?php
	wp_editor(
		$message,
		'bh_sidebar_global_message',
		array(
			'textarea_rows' => 10,
			'media_buttons' => true,
			'teeny'         => false,
		)
	);
}

/**
 * Render global menu selector field
 */
function bh_render_global_menu_field() {
	$current_menu = get_option( 'bh_sidebar_global_menu' );
	$menus        = wp_get_nav_menus();
	?>
	<select name="bh_sidebar_global_menu">
		<option value=""><?php esc_html_e( '— Select a Menu —', 'brimstone-hill' ); ?></option>
		<?php foreach ( $menus as $menu ) : ?>
			<option value="<?php echo esc_attr( $menu->slug ); ?>" <?php selected( $current_menu, $menu->slug ); ?>>
				<?php echo esc_html( $menu->name ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<p class="description"><?php esc_html_e( 'Select the menu to display by default in page sidebars.', 'brimstone-hill' ); ?></p>
	<?php
}

/**
 * Register metabox for pages
 */
function bh_register_sidebar_metabox() {
	add_meta_box(
		'bh-sidebar-metabox',
		__( 'Sidebar Options', 'brimstone-hill' ),
		'bh_render_sidebar_metabox',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'bh_register_sidebar_metabox' );

/**
 * Render sidebar metabox
 */
function bh_render_sidebar_metabox( $post ) {
	wp_nonce_field( 'bh_sidebar_nonce', 'bh_sidebar_nonce_field' );

	$enable_sidebar         = get_post_meta( $post->ID, '_bh_sidebar_enabled', true );
	$sidebar_menu           = get_post_meta( $post->ID, '_bh_sidebar_menu', true );
	$use_global_message     = get_post_meta( $post->ID, '_bh_sidebar_use_global', true );
	$sidebar_custom_content = get_post_meta( $post->ID, '_bh_sidebar_custom_content', true );

	$menus = wp_get_nav_menus();
	?>
	<div style="padding: 10px 0;">
		<!-- Enable Sidebar -->
		<p>
			<label>
				<input type="checkbox" name="bh_sidebar_enabled" value="1" <?php checked( $enable_sidebar, 1 ); ?> />
				<?php esc_html_e( 'Enable sidebar for this page', 'brimstone-hill' ); ?>
			</label>
		</p>

		<!-- Sidebar Menu Selector -->
		<p>
			<label for="bh_sidebar_menu"><?php esc_html_e( 'Choose Sidebar Menu:', 'brimstone-hill' ); ?></label>
			<br />
			<select name="bh_sidebar_menu" id="bh_sidebar_menu" style="width: 100%; max-width: 400px;">
				<option value=""><?php esc_html_e( '— Use Default Menu —', 'brimstone-hill' ); ?></option>
				<?php foreach ( $menus as $menu ) : ?>
					<option value="<?php echo esc_attr( $menu->slug ); ?>" <?php selected( $sidebar_menu, $menu->slug ); ?>>
						<?php echo esc_html( $menu->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<p class="description"><?php esc_html_e( 'Select which menu to display in the sidebar. Leave empty to use the default menu from Sidebar Settings.', 'brimstone-hill' ); ?></p>
		</p>

		<!-- Use Global Message -->
		<p>
			<label>
				<input type="checkbox" name="bh_sidebar_use_global" value="1" <?php checked( $use_global_message, 1 ); ?> />
				<?php esc_html_e( 'Use global sidebar message from Sidebar Settings', 'brimstone-hill' ); ?>
			</label>
			<p class="description"><?php esc_html_e( 'If checked, the global message configured in Sidebar Settings will be used. Otherwise, use the custom HTML below.', 'brimstone-hill' ); ?></p>
		</p>

		<!-- Custom Sidebar Content -->
		<p>
			<label for="bh_sidebar_custom_content"><?php esc_html_e( 'Custom Sidebar HTML (if not using global message):', 'brimstone-hill' ); ?></label>
			<br />
		</p>
		<?php
		wp_editor(
			$sidebar_custom_content,
			'bh_sidebar_custom_content',
			array(
				'textarea_rows' => 8,
				'media_buttons' => false,
				'teeny'         => true,
			)
		);
		?>
		<p class="description"><?php esc_html_e( 'Enter custom HTML or text to display in the sidebar for this page.', 'brimstone-hill' ); ?></p>
	</div>
	<?php
}

/**
 * Save sidebar metabox data
 */
function bh_save_sidebar_metabox( $post_id ) {
	// Verify nonce
	if ( ! isset( $_POST['bh_sidebar_nonce_field'] ) || ! wp_verify_nonce( $_POST['bh_sidebar_nonce_field'], 'bh_sidebar_nonce' ) ) {
		return;
	}

	// Check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save sidebar enabled
	if ( isset( $_POST['bh_sidebar_enabled'] ) ) {
		update_post_meta( $post_id, '_bh_sidebar_enabled', 1 );
	} else {
		delete_post_meta( $post_id, '_bh_sidebar_enabled' );
	}

	// Save sidebar menu
	if ( isset( $_POST['bh_sidebar_menu'] ) ) {
		update_post_meta( $post_id, '_bh_sidebar_menu', sanitize_text_field( $_POST['bh_sidebar_menu'] ) );
	} else {
		delete_post_meta( $post_id, '_bh_sidebar_menu' );
	}

	// Save use global message
	if ( isset( $_POST['bh_sidebar_use_global'] ) ) {
		update_post_meta( $post_id, '_bh_sidebar_use_global', 1 );
	} else {
		delete_post_meta( $post_id, '_bh_sidebar_use_global' );
	}

	// Save custom content
	if ( isset( $_POST['bh_sidebar_custom_content'] ) ) {
		update_post_meta( $post_id, '_bh_sidebar_custom_content', wp_kses_post( $_POST['bh_sidebar_custom_content'] ) );
	} else {
		delete_post_meta( $post_id, '_bh_sidebar_custom_content' );
	}
}
add_action( 'save_post', 'bh_save_sidebar_metabox' );

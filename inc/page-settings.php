<?php
/**
 * Per-page display settings (title and breadcrumb alignment).
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Valid title alignment values.
 *
 * @return string[]
 */
function bh_get_title_align_options() {
	return array(
		'left'   => __( 'Left', 'brimstone-hill' ),
		'center' => __( 'Center', 'brimstone-hill' ),
		'right'  => __( 'Right', 'brimstone-hill' ),
	);
}

/**
 * Title alignment for the current or given page.
 *
 * @param int $post_id Optional post ID.
 * @return string left|center|right
 */
function bh_get_page_title_align( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	$align   = get_post_meta( $post_id, '_bh_page_title_align', true );
	return in_array( $align, array( 'left', 'center', 'right' ), true ) ? $align : 'left';
}

/**
 * Register page settings metabox.
 */
function bh_register_page_settings_metabox() {
	add_meta_box(
		'bh-page-settings',
		__( 'Page display', 'brimstone-hill' ),
		'bh_render_page_settings_metabox',
		'page',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'bh_register_page_settings_metabox' );

/**
 * Render page settings metabox.
 *
 * @param WP_Post $post Current post.
 */
function bh_render_page_settings_metabox( $post ) {
	wp_nonce_field( 'bh_save_page_settings', 'bh_page_settings_nonce' );
	$align = bh_get_page_title_align( $post->ID );
	?>
	<p>
		<label for="bh_page_title_align"><strong><?php esc_html_e( 'Title & breadcrumb alignment', 'brimstone-hill' ); ?></strong></label>
	</p>
	<select name="bh_page_title_align" id="bh_page_title_align" class="widefat">
		<?php foreach ( bh_get_title_align_options() as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $align, $value ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

/**
 * Save page settings metabox.
 *
 * @param int $post_id Post ID.
 */
function bh_save_page_settings_metabox( $post_id ) {
	if ( ! isset( $_POST['bh_page_settings_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bh_page_settings_nonce'] ) ), 'bh_save_page_settings' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$align = isset( $_POST['bh_page_title_align'] ) ? sanitize_key( wp_unslash( $_POST['bh_page_title_align'] ) ) : 'left';
	if ( ! in_array( $align, array( 'left', 'center', 'right' ), true ) ) {
		$align = 'left';
	}
	update_post_meta( $post_id, '_bh_page_title_align', $align );
}
add_action( 'save_post_page', 'bh_save_page_settings_metabox' );

/**
 * Open the content shell after a page banner (container + column).
 *
 * page-header.php opens this wrapper automatically when there is no banner.
 */
function bh_render_page_content_shell_open() {
	if ( is_page_template( 'page-contact.php' ) || ! has_post_thumbnail() ) {
		return;
	}

	echo '<div class="container"><div class="content-page__column">';
}

/**
 * Close the page content shell opened by page-header or bh_render_page_content_shell_open().
 */
function bh_render_page_content_shell_close() {
	if ( is_page_template( 'page-contact.php' ) ) {
		if ( ! has_post_thumbnail() ) {
			echo '</div></div>';
		}
		return;
	}

	echo '</div></div>';
}

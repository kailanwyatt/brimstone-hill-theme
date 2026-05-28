<?php
/**
 * Homepage Settings
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register homepage settings page
 */
function bh_register_homepage_settings_page() {
	add_theme_page(
		__( 'Homepage Settings', 'brimstone-hill' ),
		__( 'Homepage Settings', 'brimstone-hill' ),
		'manage_options',
		'bh-homepage-settings',
		'bh_render_homepage_settings_page'
	);
}
add_action( 'admin_menu', 'bh_register_homepage_settings_page' );

/**
 * Render homepage settings page
 */
function bh_render_homepage_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Homepage Settings', 'brimstone-hill' ); ?></h1>
		<p><?php esc_html_e( 'Configure the content for the homepage sections.', 'brimstone-hill' ); ?></p>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'bh-homepage-settings' );
			do_settings_sections( 'bh-homepage-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Register settings
 */
function bh_register_homepage_settings() {
	// Sections
	add_settings_section(
		'bh_home_hero',
		'Hero Video',
		function () {
			echo '<p class="description">' . esc_html__( 'Full-width background video at the top of the homepage. Headline and buttons are shown in the Welcome section below the video.', 'brimstone-hill' ) . '</p>';
		},
		'bh-homepage-settings'
	);
	add_settings_section(
		'bh_home_welcome',
		'Welcome Section',
		function () {
			echo '<p class="description">' . esc_html__( 'Shown directly below the hero video (headline, intro, and buttons).', 'brimstone-hill' ) . '</p>';
		},
		'bh-homepage-settings'
	);
	add_settings_section( 'bh_home_admission', 'Admission Section', '__return_false', 'bh-homepage-settings' );
	add_settings_section( 'bh_home_discover', 'Discover Grid', '__return_false', 'bh-homepage-settings' );

	// Fields for Hero (video only)
	register_setting( 'bh-homepage-settings', 'bh_home_hero_video' );
	add_settings_field( 'bh_home_hero_video', 'Vimeo embed URL', 'bh_render_text_field', 'bh-homepage-settings', 'bh_home_hero', array( 'id' => 'bh_home_hero_video', 'default' => 'https://player.vimeo.com/video/1049129560?h=baad6d0ed1&autoplay=1&loop=1&autopause=0&muted=1&title=0&byline=0&portrait=0&controls=0&background=1', 'description' => 'Same Vimeo URL as brimstonehillfortress.org. Use title=0&byline=0&controls=0 for a clean background video.' ) );

	// Legacy hero copy — used by Welcome section when welcome title is still the default.
	register_setting( 'bh-homepage-settings', 'bh_home_hero_title' );
	register_setting( 'bh-homepage-settings', 'bh_home_hero_subtitle' );

	register_setting( 'bh-homepage-settings', 'bh_home_hero_image' );
	add_settings_field( 'bh_home_hero_image', 'Fallback Image URL', 'bh_render_text_field', 'bh-homepage-settings', 'bh_home_hero', array( 'id' => 'bh_home_hero_image', 'default' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-04-1.jpg' ) );

	// Fields for Welcome
	register_setting( 'bh-homepage-settings', 'bh_home_welcome_title' );
	add_settings_field( 'bh_home_welcome_title', 'Headline', 'bh_render_text_field', 'bh-homepage-settings', 'bh_home_welcome', array( 'id' => 'bh_home_welcome_title', 'default' => 'Welcome to Brimstone Hill Fortress National Park UNESCO World Heritage Site', 'description' => 'Leave as default or customize. If set to “Welcome!” the legacy Hero Title option is used instead.' ) );

	register_setting( 'bh-homepage-settings', 'bh_home_welcome_text' );
	add_settings_field( 'bh_home_welcome_text', 'Text', 'bh_render_editor_field', 'bh-homepage-settings', 'bh_home_welcome', array( 'id' => 'bh_home_welcome_text', 'default' => 'Brimstone Hill Fortress National Park is a UNESCO World Heritage Site...' ) );

	// Fields for Admission
	register_setting( 'bh-homepage-settings', 'bh_home_admission_entrance' );
	add_settings_field( 'bh_home_admission_entrance', 'Entrance Text', 'bh_render_text_field', 'bh-homepage-settings', 'bh_home_admission', array( 'id' => 'bh_home_admission_entrance', 'default' => 'Entrance USD $15 · Locals XCD $10...' ) );

	register_setting( 'bh-homepage-settings', 'bh_home_admission_hours' );
	add_settings_field( 'bh_home_admission_hours', 'Hours Text', 'bh_render_text_field', 'bh-homepage-settings', 'bh_home_admission', array( 'id' => 'bh_home_admission_hours', 'default' => 'Open daily 9:30am–5:30pm' ) );

	// Discover Grid
	register_setting( 'bh-homepage-settings', 'bh_home_discover_json' );
	add_settings_field( 'bh_home_discover_json', 'Grid Data (JSON)', 'bh_render_textarea_field', 'bh-homepage-settings', 'bh_home_discover', array( 'id' => 'bh_home_discover_json', 'default' => '[]', 'description' => 'Advanced: Edit the JSON array for the discover grid items.' ) );

	// Other sections
	add_settings_section( 'bh_home_promo', 'Featured Promo', '__return_false', 'bh-homepage-settings' );
	register_setting( 'bh-homepage-settings', 'bh_home_promo_title' );
	add_settings_field( 'bh_home_promo_title', 'Title', 'bh_render_text_field', 'bh-homepage-settings', 'bh_home_promo', array( 'id' => 'bh_home_promo_title', 'default' => 'Emancipation Festival' ) );
	register_setting( 'bh-homepage-settings', 'bh_home_promo_text' );
	add_settings_field( 'bh_home_promo_text', 'Text', 'bh_render_textarea_field', 'bh-homepage-settings', 'bh_home_promo', array( 'id' => 'bh_home_promo_text', 'default' => 'Celebrate freedom and heritage...' ) );

	add_settings_section( 'bh_home_plan', 'Plan Teaser', '__return_false', 'bh-homepage-settings' );
	register_setting( 'bh-homepage-settings', 'bh_home_plan_title' );
	add_settings_field( 'bh_home_plan_title', 'Title', 'bh_render_text_field', 'bh-homepage-settings', 'bh_home_plan', array( 'id' => 'bh_home_plan_title', 'default' => 'Plan your visit' ) );
	
	add_settings_section( 'bh_home_about', 'About Park', '__return_false', 'bh-homepage-settings' );
	register_setting( 'bh-homepage-settings', 'bh_home_about_text' );
	add_settings_field( 'bh_home_about_text', 'Text', 'bh_render_textarea_field', 'bh-homepage-settings', 'bh_home_about', array( 'id' => 'bh_home_about_text', 'default' => 'Brimstone Hill and its Fortress is a National Park...' ) );
}
add_action( 'admin_init', 'bh_register_homepage_settings' );

/**
 * Render standard text field
 */
function bh_render_text_field( $args ) {
	$value = get_option( $args['id'], $args['default'] );
	echo '<input type="text" id="' . esc_attr( $args['id'] ) . '" name="' . esc_attr( $args['id'] ) . '" value="' . esc_attr( $value ) . '" class="regular-text" />';
	if ( isset( $args['description'] ) ) {
		echo '<p class="description">' . esc_html( $args['description'] ) . '</p>';
	}
}

/**
 * Render textarea field
 */
function bh_render_textarea_field( $args ) {
	$value = get_option( $args['id'], $args['default'] );
	echo '<textarea id="' . esc_attr( $args['id'] ) . '" name="' . esc_attr( $args['id'] ) . '" rows="5" cols="50" class="large-text code">' . esc_textarea( $value ) . '</textarea>';
	if ( isset( $args['description'] ) ) {
		echo '<p class="description">' . esc_html( $args['description'] ) . '</p>';
	}
}

/**
 * Render editor field
 */
function bh_render_editor_field( $args ) {
	$value = get_option( $args['id'], $args['default'] );
	wp_editor( $value, $args['id'], array( 'textarea_rows' => 5, 'teeny' => true, 'media_buttons' => false ) );
}

// Ensure default JSON is set if empty so the template doesn't crash
$default_discover = array(
	array( 'title' => 'The Citadel', 'description' => 'Climb to the highest point for panoramic views of the island and sea.', 'link' => '/discover/the-fortress', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-12.png' ),
	array( 'title' => 'The Fortress', 'description' => 'Explore the architecture and key spaces of this historic fortification.', 'link' => '/discover/the-fortress', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-01.png' ),
	array( 'title' => 'Museum & Exhibitions', 'description' => 'Artefacts and stories from centuries of history.', 'link' => '/discover/exhibitions', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-17.png' ),
	array( 'title' => 'History & Story', 'description' => 'From British engineers to the builders who made it possible.', 'link' => '/discover/history', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-08.jpg' ),
	array( 'title' => 'Events & Festivals', 'description' => 'Emancipation Festival, guided tours, and special programmes.', 'link' => '/events/whats-on', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-04.jpg' ),
	array( 'title' => 'Photo Gallery', 'description' => 'Images of the fortress, the views, and the experience.', 'link' => '/discover/gallery', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-10.png' ),
	array( 'title' => 'UNESCO World Heritage', 'description' => 'Why this site matters to the world.', 'link' => '/discover/unesco', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-18.png' ),
	array( 'title' => 'Group Visits', 'description' => 'Schools, clubs, and tour groups. Book in advance.', 'link' => '/visit/group-visits', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-16.jpg' ),
	array( 'title' => 'Education', 'description' => 'School visits, programmes, and resources for learners.', 'link' => '/learn/school-visits', 'image' => '/wp-content/themes/brimstone-hill-ag/assets/images/img-20.jpg' )
);
if ( ! get_option( 'bh_home_discover_json' ) ) {
	update_option( 'bh_home_discover_json', wp_json_encode( $default_discover ) );
}

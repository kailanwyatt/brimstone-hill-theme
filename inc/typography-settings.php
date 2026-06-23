<?php
/**
 * Typography settings.
 *
 * @package Brimstone_Hill
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default heading font stack (matches variables.css).
 *
 * @return string
 */
function bh_typography_default_heading_stack() {
	return "Georgia, 'Times New Roman', serif";
}

/**
 * Default body font stack (matches variables.css).
 *
 * @return string
 */
function bh_typography_default_body_stack() {
	return 'system-ui, -apple-system, sans-serif';
}

/**
 * Curated typography font choices.
 *
 * @return array{heading: array<string, array>, body: array<string, array>}
 */
function bh_typography_font_choices() {
	return array(
		'heading' => array(
			'theme-default' => array(
				'label'          => __( 'Theme default (Georgia)', 'brimstone-hill' ),
				'google_family'  => '',
				'stack'          => bh_typography_default_heading_stack(),
				'weights'        => array(),
			),
			'playfair-display' => array(
				'label'          => 'Playfair Display',
				'google_family'  => 'Playfair Display',
				'stack'          => "'Playfair Display', Georgia, 'Times New Roman', serif",
				'weights'        => array( 400, 600, 700 ),
			),
			'lora' => array(
				'label'          => 'Lora',
				'google_family'  => 'Lora',
				'stack'          => "'Lora', Georgia, 'Times New Roman', serif",
				'weights'        => array( 400, 600, 700 ),
			),
			'merriweather' => array(
				'label'          => 'Merriweather',
				'google_family'  => 'Merriweather',
				'stack'          => "'Merriweather', Georgia, 'Times New Roman', serif",
				'weights'        => array( 400, 700 ),
			),
			'libre-baskerville' => array(
				'label'          => 'Libre Baskerville',
				'google_family'  => 'Libre Baskerville',
				'stack'          => "'Libre Baskerville', Georgia, 'Times New Roman', serif",
				'weights'        => array( 400, 700 ),
			),
			'source-serif-4' => array(
				'label'          => 'Source Serif 4',
				'google_family'  => 'Source Serif 4',
				'stack'          => "'Source Serif 4', Georgia, 'Times New Roman', serif",
				'weights'        => array( 400, 600, 700 ),
			),
			'crimson-pro' => array(
				'label'          => 'Crimson Pro',
				'google_family'  => 'Crimson Pro',
				'stack'          => "'Crimson Pro', Georgia, 'Times New Roman', serif",
				'weights'        => array( 400, 600, 700 ),
			),
			'eb-garamond' => array(
				'label'          => 'EB Garamond',
				'google_family'  => 'EB Garamond',
				'stack'          => "'EB Garamond', Georgia, 'Times New Roman', serif",
				'weights'        => array( 400, 600, 700 ),
			),
			'cormorant-garamond' => array(
				'label'          => 'Cormorant Garamond',
				'google_family'  => 'Cormorant Garamond',
				'stack'          => "'Cormorant Garamond', Georgia, 'Times New Roman', serif",
				'weights'        => array( 400, 600, 700 ),
			),
		),
		'body' => array(
			'system-ui' => array(
				'label'          => __( 'System UI (theme default)', 'brimstone-hill' ),
				'google_family'  => '',
				'stack'          => bh_typography_default_body_stack(),
				'weights'        => array(),
			),
			'inter' => array(
				'label'          => 'Inter',
				'google_family'  => 'Inter',
				'stack'          => "'Inter', system-ui, -apple-system, sans-serif",
				'weights'        => array( 400, 600 ),
			),
			'open-sans' => array(
				'label'          => 'Open Sans',
				'google_family'  => 'Open Sans',
				'stack'          => "'Open Sans', system-ui, -apple-system, sans-serif",
				'weights'        => array( 400, 600 ),
			),
			'source-sans-3' => array(
				'label'          => 'Source Sans 3',
				'google_family'  => 'Source Sans 3',
				'stack'          => "'Source Sans 3', system-ui, -apple-system, sans-serif",
				'weights'        => array( 400, 600 ),
			),
			'lato' => array(
				'label'          => 'Lato',
				'google_family'  => 'Lato',
				'stack'          => "'Lato', system-ui, -apple-system, sans-serif",
				'weights'        => array( 400, 700 ),
			),
			'nunito-sans' => array(
				'label'          => 'Nunito Sans',
				'google_family'  => 'Nunito Sans',
				'stack'          => "'Nunito Sans', system-ui, -apple-system, sans-serif",
				'weights'        => array( 400, 600 ),
			),
			'roboto' => array(
				'label'          => 'Roboto',
				'google_family'  => 'Roboto',
				'stack'          => "'Roboto', system-ui, -apple-system, sans-serif",
				'weights'        => array( 400, 500, 700 ),
			),
			'work-sans' => array(
				'label'          => 'Work Sans',
				'google_family'  => 'Work Sans',
				'stack'          => "'Work Sans', system-ui, -apple-system, sans-serif",
				'weights'        => array( 400, 600 ),
			),
			'dm-sans' => array(
				'label'          => 'DM Sans',
				'google_family'  => 'DM Sans',
				'stack'          => "'DM Sans', system-ui, -apple-system, sans-serif",
				'weights'        => array( 400, 500, 700 ),
			),
		),
	);
}

/**
 * Sanitize a typography font option value.
 *
 * @param string $value Raw value.
 * @param string $group heading|body.
 * @return string
 */
function bh_sanitize_typography_font( $value, $group = 'heading' ) {
	$choices = bh_typography_font_choices();
	$group   = 'body' === $group ? 'body' : 'heading';
	$default = 'heading' === $group ? 'theme-default' : 'system-ui';

	if ( ! is_string( $value ) || ! isset( $choices[ $group ][ $value ] ) ) {
		return $default;
	}

	return $value;
}

/**
 * Resolve typography settings for frontend output.
 *
 * @return array{heading_slug: string, body_slug: string, heading_stack: string, body_stack: string, google_families: array<int, array{family: string, weights: int[]}>}
 */
function bh_get_typography_settings() {
	return array(
		'heading_stack'   => bh_yabe_area_font_css_value( 'heading', (string) get_option( 'bh_typography_heading_font', get_option( 'bh_typography_heading_font', '' ) ) ),
		'body_stack'      => bh_yabe_area_font_css_value( 'body', (string) get_option( 'bh_typography_body_font', get_option( 'bh_typography_body_font', '' ) ) ),
		'google_families' => array(),
	);
}

/**
 * Build a Google Fonts CSS2 URL for the selected families.
 *
 * @param array<int, array{family: string, weights: int[]}> $families Font families.
 * @return string
 */
function bh_typography_google_fonts_url( $families ) {
	if ( empty( $families ) ) {
		return '';
	}

	$query_parts = array();

	foreach ( $families as $family ) {
		if ( empty( $family['family'] ) ) {
			continue;
		}

		$weights = ! empty( $family['weights'] ) ? $family['weights'] : array( 400 );
		sort( $weights, SORT_NUMERIC );
		$weight_list = implode( ';', array_map( 'intval', $weights ) );
		$query_parts[] = rawurlencode( $family['family'] ) . ':wght@' . $weight_list;
	}

	if ( empty( $query_parts ) ) {
		return '';
	}

	return 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $query_parts ) . '&display=swap';
}

/**
 * Register typography settings page.
 */
function bh_register_typography_settings_page() {
	add_theme_page(
		__( 'Typography Settings', 'brimstone-hill' ),
		__( 'Typography Settings', 'brimstone-hill' ),
		'manage_options',
		'bh-typography-settings',
		'bh_render_typography_settings_page'
	);
}
add_action( 'admin_menu', 'bh_register_typography_settings_page' );

/**
 * Register typography settings.
 */
function bh_register_typography_settings() {
	$areas = bh_typography_areas();
	foreach ( $areas as $area => $css_var ) {
		register_setting(
			'bh-typography-settings',
			'bh_typography_' . $area . '_font',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '',
			)
		);
	}

	// Legacy options kept for backward compatibility.
	register_setting(
		'bh-typography-settings',
		'bh_typography_heading_font',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		)
	);
	register_setting(
		'bh-typography-settings',
		'bh_typography_body_font',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		)
	);

	add_settings_section(
		'bh_typography_fonts',
		__( 'Font families', 'brimstone-hill' ),
		function () {
			if ( bh_yabe_webfont_is_active() ) {
				echo '<p class="description">' . esc_html__( 'Assign Yabe Webfont families to each site area. Fonts are self-hosted by the Yabe Webfont plugin.', 'brimstone-hill' ) . '</p>';
			} else {
				echo '<p class="description">' . esc_html__( 'Install Yabe Webfont to choose self-hosted fonts. Until then, theme default stacks are used.', 'brimstone-hill' ) . '</p>';
			}
		},
		'bh-typography-settings'
	);

	$labels = array(
		'heading'     => __( 'Headings', 'brimstone-hill' ),
		'body'        => __( 'Body', 'brimstone-hill' ),
		'site_header' => __( 'Site header', 'brimstone-hill' ),
		'navigation'  => __( 'Navigation', 'brimstone-hill' ),
		'footer'      => __( 'Footer', 'brimstone-hill' ),
		'buttons'     => __( 'Buttons', 'brimstone-hill' ),
	);

	foreach ( $labels as $area => $label ) {
		add_settings_field(
			'bh_typography_' . $area . '_font',
			$label,
			'bh_render_yabe_typography_field',
			'bh-typography-settings',
			'bh_typography_fonts',
			array(
				'id'   => 'bh_typography_' . $area . '_font',
				'area' => $area,
			)
		);
	}
}
add_action( 'admin_init', 'bh_register_typography_settings' );

/**
 * Render Yabe font family select.
 *
 * @param array $args Field args.
 */
function bh_render_yabe_typography_field( $args ) {
	$id    = $args['id'];
	$value = (string) get_option( $id, '' );
	$choices = bh_yabe_font_choices();
	printf( '<select id="%1$s" name="%1$s">', esc_attr( $id ) );
	foreach ( $choices as $slug => $label ) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr( $slug ),
			selected( $value, $slug, false ),
			esc_html( $label )
		);
	}
	echo '</select>';
}

/**
 * Enqueue preview fonts on the typography settings screen.
 *
 * @param string $hook_suffix Admin hook suffix.
 */
function bh_typography_admin_enqueue( $hook_suffix ) {
	if ( 'appearance_page_bh-typography-settings' !== $hook_suffix ) {
		return;
	}

	wp_register_style( 'bh-typography-admin-preview', false, array(), BH_THEME_VERSION );
	wp_enqueue_style( 'bh-typography-admin-preview' );
	wp_add_inline_style( 'bh-typography-admin-preview', bh_typography_inline_css() );
	wp_add_inline_style(
		'bh-typography-admin-preview',
		'.bh-typography-preview { margin-top: 1.5rem; padding: 1.25rem; border: 1px solid #c3c4c7; background: #fff; max-width: 40rem; }
		.bh-typography-preview__heading { font-family: var(--font-heading); font-size: 1.75rem; margin: 0 0 0.5rem; }
		.bh-typography-preview__body { font-family: var(--font-body); margin: 0; line-height: 1.6; }
		.bh-typography-preview__nav { font-family: var(--font-navigation); margin: 0.5rem 0 0; }'
	);
}
add_action( 'admin_enqueue_scripts', 'bh_typography_admin_enqueue' );

/**
 * Render typography settings page.
 */
function bh_render_typography_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Typography Settings', 'brimstone-hill' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'bh-typography-settings' );
			do_settings_sections( 'bh-typography-settings' );
			submit_button();
			?>
		</form>
		<div class="bh-typography-preview">
			<p class="bh-typography-preview__heading"><?php esc_html_e( 'Brimstone Hill Fortress', 'brimstone-hill' ); ?></p>
			<p class="bh-typography-preview__body"><?php esc_html_e( 'Explore a UNESCO World Heritage Site and plan your visit to St. Kitts.', 'brimstone-hill' ); ?></p>
			<p class="bh-typography-preview__nav"><?php esc_html_e( 'Visit · Events · Support', 'brimstone-hill' ); ?></p>
		</div>
	</div>
	<?php
}

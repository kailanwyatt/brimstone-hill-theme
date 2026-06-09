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
	$choices = bh_typography_font_choices();

	$heading_slug = bh_sanitize_typography_font( (string) get_option( 'bh_typography_heading_font', 'theme-default' ), 'heading' );
	$body_slug    = bh_sanitize_typography_font( (string) get_option( 'bh_typography_body_font', 'system-ui' ), 'body' );

	$heading = $choices['heading'][ $heading_slug ];
	$body    = $choices['body'][ $body_slug ];

	$google_families = array();

	foreach ( array( $heading, $body ) as $font ) {
		if ( empty( $font['google_family'] ) ) {
			continue;
		}

		$key = $font['google_family'];
		if ( ! isset( $google_families[ $key ] ) ) {
			$google_families[ $key ] = array(
				'family'  => $font['google_family'],
				'weights' => $font['weights'],
			);
			continue;
		}

		$google_families[ $key ]['weights'] = array_values(
			array_unique(
				array_merge( $google_families[ $key ]['weights'], $font['weights'] )
			)
		);
	}

	return array(
		'heading_slug'    => $heading_slug,
		'body_slug'       => $body_slug,
		'heading_stack'   => $heading['stack'],
		'body_stack'      => $body['stack'],
		'google_families' => array_values( $google_families ),
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
	register_setting(
		'bh-typography-settings',
		'bh_typography_heading_font',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return bh_sanitize_typography_font( $value, 'heading' );
			},
			'default'           => 'theme-default',
		)
	);

	register_setting(
		'bh-typography-settings',
		'bh_typography_body_font',
		array(
			'type'              => 'string',
			'sanitize_callback' => function ( $value ) {
				return bh_sanitize_typography_font( $value, 'body' );
			},
			'default'           => 'system-ui',
		)
	);

	add_settings_section(
		'bh_typography_fonts',
		__( 'Font families', 'brimstone-hill' ),
		function () {
			echo '<p class="description">' . esc_html__( 'Choose heading and body fonts for the site. Changes apply site-wide via theme CSS variables.', 'brimstone-hill' ) . '</p>';
		},
		'bh-typography-settings'
	);

	add_settings_field(
		'bh_typography_heading_font',
		__( 'Heading font', 'brimstone-hill' ),
		'bh_render_typography_font_field',
		'bh-typography-settings',
		'bh_typography_fonts',
		array(
			'id'      => 'bh_typography_heading_font',
			'group'   => 'heading',
			'default' => 'theme-default',
		)
	);

	add_settings_field(
		'bh_typography_body_font',
		__( 'Body font', 'brimstone-hill' ),
		'bh_render_typography_font_field',
		'bh-typography-settings',
		'bh_typography_fonts',
		array(
			'id'      => 'bh_typography_body_font',
			'group'   => 'body',
			'default' => 'system-ui',
		)
	);
}
add_action( 'admin_init', 'bh_register_typography_settings' );

/**
 * Render a typography font select field.
 *
 * @param array $args Field args.
 */
function bh_render_typography_font_field( $args ) {
	$id      = $args['id'];
	$group   = $args['group'];
	$default = $args['default'];
	$value   = get_option( $id, $default );
	$choices = bh_typography_font_choices();

	printf( '<select id="%1$s" name="%1$s">', esc_attr( $id ) );

	foreach ( $choices[ $group ] as $slug => $font ) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr( $slug ),
			selected( $value, $slug, false ),
			esc_html( $font['label'] )
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

	$settings = bh_get_typography_settings();
	$url      = bh_typography_google_fonts_url( $settings['google_families'] );

	wp_register_style( 'bh-typography-admin-preview', false, array(), BH_THEME_VERSION );
	wp_enqueue_style( 'bh-typography-admin-preview' );

	if ( $url ) {
		wp_enqueue_style( 'bh-typography-admin-preview-fonts', $url, array( 'bh-typography-admin-preview' ), null );
	}

	wp_add_inline_style(
		'bh-typography-admin-preview',
		'.bh-typography-preview { margin-top: 1.5rem; padding: 1.25rem; border: 1px solid #c3c4c7; background: #fff; max-width: 40rem; }
		.bh-typography-preview__heading { font-family: ' . $settings['heading_stack'] . '; font-size: 1.75rem; margin: 0 0 0.5rem; }
		.bh-typography-preview__body { font-family: ' . $settings['body_stack'] . '; margin: 0; line-height: 1.6; }'
	);
}
add_action( 'admin_enqueue_scripts', 'bh_typography_admin_enqueue' );

/**
 * Render typography settings page.
 */
function bh_render_typography_settings_page() {
	$settings = bh_get_typography_settings();
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
		</div>
	</div>
	<?php
}

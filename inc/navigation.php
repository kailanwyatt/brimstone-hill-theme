<?php
/**
 * Navigation registration.
 *
 * @package Brimstone_Hill
 */

function bh_register_menus() {
	register_nav_menus(
		array(
			'primary'         => esc_html__( 'Primary Menu', 'brimstone-hill' ),
			'footer'          => esc_html__( 'Footer (legacy — use column menus)', 'brimstone-hill' ),
			'footer-visit'    => esc_html__( 'Footer: Visit column', 'brimstone-hill' ),
			'footer-discover' => esc_html__( 'Footer: Discover column', 'brimstone-hill' ),
			'footer-involved' => esc_html__( 'Footer: Get involved column', 'brimstone-hill' ),
			'sidebar-visit'   => esc_html__( 'Sidebar Visit Menu', 'brimstone-hill' ),
			'sidebar-discover'=> esc_html__( 'Sidebar Discover Menu', 'brimstone-hill' ),
			'sidebar-learn'   => esc_html__( 'Sidebar Learn Menu', 'brimstone-hill' ),
			'sidebar-about'   => esc_html__( 'Sidebar About Menu', 'brimstone-hill' ),
		)
	);
}
add_action( 'init', 'bh_register_menus' );

/**
 * On theme activation, assign an existing Brimstone menu to Primary if none is set.
 */
function bh_maybe_assign_primary_menu() {
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	if ( ! empty( $locations['primary'] ) ) {
		return;
	}

	$candidates = array( 'BH Primary', 'Primary Menu', 'Primary Navigation' );
	foreach ( $candidates as $menu_name ) {
		$menu = wp_get_nav_menu_object( $menu_name );
		if ( $menu && ! is_wp_error( $menu ) ) {
			$locations['primary'] = (int) $menu->term_id;
			set_theme_mod( 'nav_menu_locations', $locations );
			return;
		}
	}
}
add_action( 'after_switch_theme', 'bh_maybe_assign_primary_menu' );

/**
 * Custom Walker to replicate React BEM classes for primary navigation.
 */
class BH_Primary_Walker_Nav_Menu extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="nav__dropdown" role="menu">';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		// Setup li classes
		$li_classes = array();
		if ( $depth === 0 ) {
			$li_classes[] = 'nav__item';
			if ( in_array( 'menu-item-has-children', $classes ) ) {
				$li_classes[] = 'nav__item--has-dropdown';
			}
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $li_classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		if ( $depth === 0 ) {
			$output .= '<li' . $class_names . '>';
		} else {
			$output .= '<li role="none">';
		}

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		if ( $depth === 0 ) {
			if ( in_array( 'menu-item-has-children', $classes ) ) {
				$atts['class'] = 'nav__link nav__link--trigger';
				$atts['aria-haspopup'] = 'true';
				$atts['aria-expanded'] = 'false';
			} else {
				$atts['class'] = 'nav__link';
			}
		} else {
			$atts['class'] = 'nav__dropdown-link';
			$atts['role'] = 'menuitem';
		}

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		if ( $depth === 0 && in_array( 'menu-item-has-children', $classes ) ) {
			// Remove href from span to be valid HTML
			$span_attributes = preg_replace( '/ href="[^"]*"/', '', $attributes );
			$output .= '<span' . $span_attributes . '>' . $title . '</span>';
		} else {
			$output .= '<a' . $attributes . '>';
			if ( $depth === 0 ) {
				$output .= $title;
			} else {
				$output .= '<span class="nav__dropdown-label">' . $title . '</span>';
			}
			$output .= '</a>';
		}
	}
}

/**
 * Mobile navigation walker.
 */
class BH_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="mobile-nav__sublist" hidden>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$title       = apply_filters( 'the_title', $item->title, $item->ID );

		if ( 0 === (int) $depth ) {
			$output .= '<li class="mobile-nav__item">';
			if ( $has_children ) {
				$output .= '<button type="button" class="mobile-nav__trigger" aria-expanded="false">';
				$output .= esc_html( $title );
				$output .= '</button>';
			} else {
				$output .= '<a class="mobile-nav__link" href="' . esc_url( $item->url ) . '">';
				$output .= esc_html( $title );
				$output .= '</a>';
			}
		} else {
			$output .= '<li>';
			$output .= '<a class="mobile-nav__link" href="' . esc_url( $item->url ) . '">';
			$output .= esc_html( $title );
			$output .= '</a>';
		}
	}
}

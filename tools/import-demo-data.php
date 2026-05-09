<?php
/**
 * Import Demo Data
 * 
 * Can be run via WP-CLI: `wp eval-file tools/import-demo-data.php`
 * Or included once via functions.php during a theme activation hook.
 */

// Basic Idempotent Page Creation
function bhfp_create_page( $title, $slug, $parent_id = 0, $template = '' ) {
	$page = get_page_by_path( $slug );
	
	if ( ! $page ) {
		$page_id = wp_insert_post( array(
			'post_title'     => $title,
			'post_name'      => $slug,
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_parent'    => $parent_id,
			'page_template'  => $template,
		) );
		echo "Created page: $title ($slug)\n";
		return $page_id;
	} else {
		echo "Page already exists: $title ($slug)\n";
		return $page->ID;
	}
}

// 1. Create Core Pages
$home_id = bhfp_create_page( 'Home', 'home' );
$visit_id = bhfp_create_page( 'Visit', 'visit' );
bhfp_create_page( 'Plan Your Visit', 'plan-your-visit', $visit_id );
bhfp_create_page( 'Hours & Admission', 'hours-admission', $visit_id );
bhfp_create_page( 'Book Tickets', 'book-tickets', $visit_id );
bhfp_create_page( 'Directions', 'directions', $visit_id );

$discover_id = bhfp_create_page( 'Discover', 'discover' );
bhfp_create_page( 'History', 'history', $discover_id );
bhfp_create_page( 'The Fortress', 'the-fortress', $discover_id );
bhfp_create_page( 'Exhibitions', 'exhibitions', $discover_id );
bhfp_create_page( 'Gallery', 'gallery', $discover_id );

$events_id = bhfp_create_page( 'Events', 'events' );
bhfp_create_page( 'What\'s On', 'whats-on', $events_id );
bhfp_create_page( 'Calendar', 'calendar', $events_id );

$learn_id = bhfp_create_page( 'Learn', 'learn' );
$involved_id = bhfp_create_page( 'Get Involved', 'get-involved' );
$about_id = bhfp_create_page( 'About', 'about' );

// 2. Set Homepage
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home_id );
echo "Set Home as Front Page.\n";

// 3. Create Primary Menu (Idempotent)
$menu_name = 'Primary Navigation';
$menu_exists = wp_get_nav_menu_object( $menu_name );

if ( ! $menu_exists ) {
	$menu_id = wp_create_nav_menu( $menu_name );
	
	// Add items
	wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title'  => 'Visit',
		'menu-item-object' => 'page',
		'menu-item-object-id' => $visit_id,
		'menu-item-type'   => 'post_type',
		'menu-item-status' => 'publish'
	) );
	wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title'  => 'Discover',
		'menu-item-object' => 'page',
		'menu-item-object-id' => $discover_id,
		'menu-item-type'   => 'post_type',
		'menu-item-status' => 'publish'
	) );
	wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title'  => 'Events',
		'menu-item-object' => 'page',
		'menu-item-object-id' => $events_id,
		'menu-item-type'   => 'post_type',
		'menu-item-status' => 'publish'
	) );

	// Assign to location
	$locations = get_theme_mod( 'nav_menu_locations' );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
	
	echo "Created and assigned Primary Menu.\n";
} else {
	echo "Primary Menu already exists.\n";
}

echo "Demo data import complete.\n";

<?php
/**
 * Nuke all pages/menus and rebuild everything from scratch.
 */
require_once dirname( __DIR__, 4 ) . '/wp-load.php';

echo "<pre>";
echo "Starting Nuke & Rebuild process...\n";

// 1. Nuke Pages
$pages = get_posts([
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_status'    => 'any',
]);
foreach ( $pages as $page ) {
    wp_delete_post( $page->ID, true );
}
echo "Deleted " . count($pages) . " pages.\n";

// 2. Nuke Menus
$menus = wp_get_nav_menus();
foreach ( $menus as $menu ) {
    wp_delete_nav_menu( $menu->term_id );
}
echo "Deleted " . count($menus) . " menus.\n";

// 3. Rebuild Menus & Structure
$nav_items = [
    [
        'label' => 'Visit',
        'path' => 'visit',
        'children' => [
            [ 'label' => 'Plan your visit', 'path' => 'visit/plan-your-visit' ],
            [ 'label' => 'Hours & admission', 'path' => 'visit/hours-admission' ],
            [ 'label' => 'Book tickets', 'path' => 'visit/book-tickets' ],
            [ 'label' => 'Directions & map', 'path' => 'visit/directions' ],
            [ 'label' => 'Accessibility', 'path' => 'visit/accessibility' ],
            [ 'label' => 'Facilities', 'path' => 'visit/facilities' ],
            [ 'label' => 'Group visits', 'path' => 'visit/group-visits' ],
            [ 'label' => 'Tour operators', 'path' => 'visit/tour-operators' ],
        ],
    ],
    [
        'label' => 'Discover',
        'path' => 'discover',
        'children' => [
            [ 'label' => 'History & story', 'path' => 'discover/history' ],
            [ 'label' => 'The fortress', 'path' => 'discover/the-fortress' ],
            [ 'label' => 'Exhibitions', 'path' => 'discover/exhibitions' ],
            [ 'label' => 'UNESCO World Heritage', 'path' => 'discover/unesco' ],
            [ 'label' => 'Gallery', 'path' => 'discover/gallery' ],
        ],
    ],
    [
        'label' => 'Events',
        'path' => 'events',
        'children' => [
            [ 'label' => "What's on", 'path' => 'events/whats-on' ],
            [ 'label' => 'Events calendar', 'path' => 'events/calendar' ],
            [ 'label' => 'Annual events', 'path' => 'events/annual-events' ],
            [ 'label' => 'Schedule a tour', 'path' => 'events/schedule-a-tour' ],
        ],
    ],
    [
        'label' => 'Learn',
        'path' => 'learn',
        'children' => [
            [ 'label' => 'School visits', 'path' => 'learn/school-visits' ],
            [ 'label' => 'Education programmes', 'path' => 'learn/education-programmes' ],
            [ 'label' => 'Research', 'path' => 'learn/research' ],
            [ 'label' => 'Resources', 'path' => 'learn/resources' ],
        ],
    ],
    [
        'label' => 'Get involved',
        'path' => 'get-involved',
        'children' => [
            [ 'label' => 'Become a member', 'path' => 'get-involved/member' ],
            [ 'label' => 'Donate', 'path' => 'get-involved/donate' ],
            [ 'label' => 'Volunteer', 'path' => 'get-involved/volunteer' ],
            [ 'label' => 'Partnerships', 'path' => 'get-involved/partnerships' ],
        ],
    ],
    [
        'label' => 'About',
        'path' => 'about',
        'children' => [
            [ 'label' => 'Our story', 'path' => 'about/our-story' ],
            [ 'label' => 'The society', 'path' => 'about/the-society' ],
            [ 'label' => 'Team', 'path' => 'about/team' ],
            [ 'label' => 'News & blog', 'path' => 'about/news' ],
            [ 'label' => 'Contact', 'path' => 'about/contact' ],
            [ 'label' => 'Jobs', 'path' => 'about/jobs' ],
        ],
    ],
];

// Create Primary Menu
$menu_id = wp_create_nav_menu( 'Primary Menu' );
$locations = get_theme_mod( 'nav_menu_locations' );
$locations['primary'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );

// Create Footer Menu
$footer_menu_id = wp_create_nav_menu( 'Footer Menu' );
$locations['footer'] = $footer_menu_id;
set_theme_mod( 'nav_menu_locations', $locations );

// Create Sidebar Menus dynamically based on sections
function bh_create_page( $title, $slug, $parent_id = 0 ) {
    $page_id = wp_insert_post([
        'post_title'     => $title,
        'post_name'      => $slug,
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'post_parent'    => $parent_id,
        'post_content'   => 'Placeholder content for ' . $title,
    ]);
    return $page_id;
}

$slug_map = [];

foreach ( $nav_items as $section ) {
    $section_slug = basename( $section['path'] );
    
    // Create section root page
    $parent_page_id = bh_create_page( $section['label'], $section_slug );
    $slug_map[$section_slug] = $parent_page_id;
    
    // Add to Primary Menu
    $parent_menu_item = wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => $section['label'],
        'menu-item-object-id' => $parent_page_id,
        'menu-item-object'    => 'page',
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish'
    ]);

    // Create Sidebar Menu for this section
    $sidebar_menu_id = wp_create_nav_menu( 'Sidebar: ' . $section['label'] );
    
    // Create children
    if ( ! empty( $section['children'] ) ) {
        foreach ( $section['children'] as $child ) {
            $child_slug = basename( $child['path'] );
            $child_page_id = bh_create_page( $child['label'], $child_slug, $parent_page_id );
            $slug_map[$child_slug] = $child_page_id;

            // Primary Menu Child
            wp_update_nav_menu_item( $menu_id, 0, [
                'menu-item-title'     => $child['label'],
                'menu-item-object-id' => $child_page_id,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-parent-id' => $parent_menu_item,
            ]);

            // Sidebar Menu Item
            wp_update_nav_menu_item( $sidebar_menu_id, 0, [
                'menu-item-title'     => $child['label'],
                'menu-item-object-id' => $child_page_id,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ]);
        }
    }
}
echo "Rebuilt pages and menus.\n";

// Create a Home page
$home_id = bh_create_page( 'Home', 'home' );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home_id );
echo "Set Home page.\n";

// 4. Run Import
$json_path = '/Users/kurt/Documents/mobile-apps/brimstone-hill/pages.json';
if ( file_exists( $json_path ) ) {
    $pages_data = json_decode( file_get_contents( $json_path ), true );
    
    foreach ( $pages_data as $slug => $data ) {
        $page = get_page_by_path( $slug );
        if ( ! $page ) {
            // Check in our slug map or by name
            $query = new WP_Query([
                'post_type' => 'page',
                'name' => $slug,
                'post_status' => 'any',
                'posts_per_page' => 1
            ]);
            if ( $query->have_posts() ) {
                $page = $query->posts[0];
            }
        }
        
        if ( ! $page && isset($slug_map[$slug]) ) {
            $page = get_post($slug_map[$slug]);
        }

        if ( ! $page ) {
            // Some slugs are different in pages.json (like 'become-member' vs 'member')
            // we will skip them or match them if needed, but for now just skip
            continue;
        }

        $content = $data['content'];
        $content = preg_replace('/^(\s*\}[^>]*>\s*|\s*>\s*)/', '', $content); 
        $content = str_replace('class=', 'class=', $content); 
        $content = preg_replace('/<Button\s+to="([^"]+)"\s+variant="([^"]+)">([^<]+)<\/Button>/i', '<a href="$1" class="btn btn--$2">$3</a>', $content);

        if ( $slug === 'plan-your-visit' ) {
            $accordion = '<div class="accordion" data-allow-multiple="true"><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-hours">Hours &amp; admission <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-hours" class="accordion__panel" hidden><div class="accordion__content"><p>Open daily 9:30am – 5:30pm. Entrance is USD $15 for international visitors; locals pay XCD $10 with valid ID. Children 12 and under pay half price. Restaurant-only visitors (locals) pay a parking fee of XCD $10. Members enjoy free admission according to their tier.</p><p><a href="/visit/hours-admission">Full hours and admission details</a></p></div></div></div><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-directions">Directions &amp; map <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-directions" class="accordion__panel" hidden><div class="accordion__content"><p>Brimstone Hill is on the island of St. Kitts. By car, follow the main road from Basseterre towards Sandy Point; the fortress is signposted. Taxis and tour buses are available from Basseterre and the cruise port. Allow 20–30 minutes from Basseterre. Free parking on site.</p><p><a href="/visit/directions">Address, map, and getting here</a></p></div></div></div><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-accessibility">Accessibility <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-accessibility" class="accordion__panel" hidden><div class="accordion__content"><p>The fortress is built on a steep hill with uneven terrain and steps in places. The visitor centre has level access. We are working to improve access across the site. Contact us in advance to discuss your requirements and we will do our best to accommodate you.</p><p><a href="/visit/accessibility">Accessibility information</a></p></div></div></div><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-facilities">Facilities <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-facilities" class="accordion__panel" hidden><div class="accordion__content"><p>Restaurant and bar on site (members get 10% discount). Gift shop, restrooms, and first aid. The visitor centre has seating and shelter. Wear comfortable shoes and bring sun protection and water.</p><p><a href="/visit/facilities">Full facilities information</a></p></div></div></div><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-groups">Group visits <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-groups" class="accordion__panel" hidden><div class="accordion__content"><p>Schools, clubs, and tour groups are welcome. Group rates and guided tours can be arranged. Booking in advance is essential. Tour operators should see the Tour operators page for group passes and credit accounts.</p><p><a href="/visit/group-visits">Group visits</a> · <a href="/visit/tour-operators">Tour operators</a> · <a href="/events/schedule-a-tour">Schedule a tour</a></p></div></div></div></div>';
            $content = '
<p>Everything you need to plan a great day at the fortress: opening hours, admission, directions, facilities, and tips for groups and families.</p>
' . $accordion . '
<p style="margin-top: var(--space-xl)">
    <a href="/visit/book-tickets" class="btn btn--primary">Book tickets</a>
</p>';
        }

        wp_update_post([
            'ID' => $page->ID,
            'post_content' => $content,
        ]);
        
        if ( ! empty( $data['sidebar'] ) ) {
            update_post_meta( $page->ID, '_bh_sidebar_enabled', '1' );
            update_post_meta( $page->ID, '_bh_sidebar_menu', 'sidebar-' . $data['sidebar'] );
        } else {
            delete_post_meta( $page->ID, '_bh_sidebar_enabled' );
            delete_post_meta( $page->ID, '_bh_sidebar_menu' );
        }
    }
    echo "Imported interior pages.\n";
} else {
    echo "pages.json not found, skipping import.\n";
}

echo "All Done.\n</pre>";

<?php
/**
 * Script to import React interior pages content into WordPress
 */

require_once( dirname( __DIR__, 4 ) . '/wp-load.php' );

$json_path = '/Users/kurt/Documents/mobile-apps/brimstone-hill/pages.json';
if ( ! file_exists( $json_path ) ) {
    die( "pages.json not found.\n" );
}

$pages = json_decode( file_get_contents( $json_path ), true );

foreach ( $pages as $slug => $data ) {
    $page = get_page_by_path( $slug );
    if ( ! $page ) {
        // Try searching by post_name
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

    if ( ! $page ) {
        echo "Page not found: $slug\n";
        continue;
    }

    // Clean up JSX artifacts from extraction
    $content = $data['content'];
    $content = preg_replace('/^(\s*\}[^>]*>\s*|\s*>\s*)/', '', $content); // remove `}>\n` or `>\n` or `} variant="full" bannerImage="..." >`
    $content = str_replace('class=', 'class=', $content); // normalise
    
    // Convert React `<Button>` to `<a>`
    $content = preg_replace('/<Button\s+to="([^"]+)"\s+variant="([^"]+)">([^<]+)<\/Button>/i', '<a href="$1" class="btn btn--$2">$3</a>', $content);

    // Accordions
    // In React it was <Accordion items= allowMultiple />
    // We will hardcode the Accordion for 'plan-your-visit' since it's the only one using it heavily.
    if ( $slug === 'plan-your-visit' ) {
        $accordion = '<div class="accordion" data-allow-multiple="true"><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-hours">Hours &amp; admission <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-hours" class="accordion__panel" hidden><div class="accordion__content"><p>Open daily 9:30am – 5:30pm. Entrance is USD $15 for international visitors; locals pay XCD $10 with valid ID. Children 12 and under pay half price. Restaurant-only visitors (locals) pay a parking fee of XCD $10. Members enjoy free admission according to their tier.</p><p><a href="/visit/hours-admission">Full hours and admission details</a></p></div></div></div><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-directions">Directions &amp; map <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-directions" class="accordion__panel" hidden><div class="accordion__content"><p>Brimstone Hill is on the island of St. Kitts. By car, follow the main road from Basseterre towards Sandy Point; the fortress is signposted. Taxis and tour buses are available from Basseterre and the cruise port. Allow 20–30 minutes from Basseterre. Free parking on site.</p><p><a href="/visit/directions">Address, map, and getting here</a></p></div></div></div><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-accessibility">Accessibility <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-accessibility" class="accordion__panel" hidden><div class="accordion__content"><p>The fortress is built on a steep hill with uneven terrain and steps in places. The visitor centre has level access. We are working to improve access across the site. Contact us in advance to discuss your requirements and we will do our best to accommodate you.</p><p><a href="/visit/accessibility">Accessibility information</a></p></div></div></div><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-facilities">Facilities <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-facilities" class="accordion__panel" hidden><div class="accordion__content"><p>Restaurant and bar on site (members get 10% discount). Gift shop, restrooms, and first aid. The visitor centre has seating and shelter. Wear comfortable shoes and bring sun protection and water.</p><p><a href="/visit/facilities">Full facilities information</a></p></div></div></div><div class="accordion__item"><button class="accordion__trigger" aria-expanded="false" aria-controls="accordion-groups">Group visits <span class="accordion__icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></span></button><div id="accordion-groups" class="accordion__panel" hidden><div class="accordion__content"><p>Schools, clubs, and tour groups are welcome. Group rates and guided tours can be arranged. Booking in advance is essential. Tour operators should see the Tour operators page for group passes and credit accounts.</p><p><a href="/visit/group-visits">Group visits</a> · <a href="/visit/tour-operators">Tour operators</a> · <a href="/events/schedule-a-tour">Schedule a tour</a></p></div></div></div></div>';
        $content = '
<p>Everything you need to plan a great day at the fortress: opening hours, admission, directions, facilities, and tips for groups and families.</p>
' . $accordion . '
<p style="margin-top: var(--space-xl)">
    <a href="/visit/book-tickets" class="btn btn--primary">Book tickets</a>
</p>';
    }

    $updated_post = [
        'ID' => $page->ID,
        'post_content' => $content,
    ];
    wp_update_post( $updated_post );
    
    // Update Sidebar Meta
    if ( ! empty( $data['sidebar'] ) ) {
        update_post_meta( $page->ID, '_bh_sidebar_enabled', '1' );
        update_post_meta( $page->ID, '_bh_sidebar_menu', 'sidebar-' . $data['sidebar'] );
    } else {
        delete_post_meta( $page->ID, '_bh_sidebar_enabled' );
        delete_post_meta( $page->ID, '_bh_sidebar_menu' );
    }

    // Attach Featured Image if available (this requires an image ID in WP, so we will skip automatic attachment for now 
    // unless the image is already in Media Library. The React demo uses local images).
    // The user will see the correct layout.
    
    echo "Updated: $slug\n";
}

echo "Done.\n";

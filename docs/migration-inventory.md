# Migration Inventory

## 1. React Demo
**Path:** `/Users/kurt/Documents/mobile-apps/brimstone-hill`

### Routes / Pages
- **Home:** `/`
- **Visit:** `/visit`, `/visit/plan-your-visit`, `/visit/hours-admission`, `/visit/book-tickets`, `/visit/directions`, `/visit/accessibility`, `/visit/facilities`, `/visit/group-visits`, `/visit/tour-operators`
- **Discover:** `/discover`, `/discover/history`, `/discover/the-fortress`, `/discover/exhibitions`, `/discover/unesco`, `/discover/gallery`, `/discover/gallery/:albumId`
- **Events:** `/events`, `/events/whats-on`, `/events/calendar`, `/events/annual-events`, `/events/schedule-a-tour`
- **Learn:** `/learn`, `/learn/school-visits`, `/learn/education-programmes`, `/learn/research`, `/learn/resources`
- **Get Involved:** `/get-involved`, `/get-involved/member`, `/get-involved/donate`, `/get-involved/volunteer`, `/get-involved/partnerships`
- **About:** `/about`, `/about/our-story`, `/about/the-society`, `/about/team`, `/about/news`, `/about/news/:slug`, `/about/contact`, `/about/jobs`
- **Staff (Gate):** `/staff`, `/staff/login`, `/staff/gate`

### Data Sources (`src/data/*.js`)
- `booking.js`: Ticket options, pricing, packages
- `breadcrumb.js`: Map of paths to breadcrumb labels
- `eventsCalendar.js`: Upcoming events list
- `gallery.js`: Albums and photo metadata
- `homeCopy.js`: Homepage text, links, feature blocks
- `membership.js`: Membership tiers and pricing
- `nav.js`: Main navigation and footer menus
- `news.js`: News articles array
- `reviews.js`: Testimonials/reviews
- `topBar.js`: Top announcement bar copy

### Styles
- `layout.css`: Global layout, containers, header/footer
- `components.css`: Buttons, cards, grids, widgets
- `variables.css`: Colors, fonts, spacing

## 2. WordPress Plugin
**Path:** `/Users/kurt/Local Sites/brimstone/app/public/wp-content/plugins/brimstone-hill`

### Custom Post Types
- `bhfp-gallery` (Gallery Albums)
- `bhfp-hotel` (Hotels)
- `bhfp-group-pass` (Group Passes)
- `bhfp-vessel` (Vessels)
- `bhfp-event` (Events)
*(Note: News is likely using standard WP Posts, Pages for standard routes)*

### Shortcodes
- **Homepage:** `bhfp_video_hero`, `bhfp_welcome`, `bhfp_admission_hours`, `bhfp_discover_more`, `bhfp_featured_promo`, `bhfp_featured_reviews`, `bhfp_whats_on`, `bhfp_plan_teaser`, `bhfp_newsletter`, `bhfp_about_park`, `bhfp_home_landing`
- **Pages/General:** `bhfp_accordion`, `bhfp_content_blocks`, `bhfp_exhibition_grid`, `bhfp_gallery_album_grid`, `bhfp_events_list`, `bhfp_membership_grid`, `bhfp_donation_form`, `bhfp_news_articles`, `bhfp_team_listing`, `bhfp_page_banner`, `bhfp_sidebar_menu`
- **Features:** `bhfp_gallery_archive`, `bhfp_gallery_album`, `bhfp_gate`, `bhfp_announcement_bar`, `bhfp_book_tickets_button`, `bhfp_context_sidebar`, `bhfp_events_calendar`, `bhfp_breadcrumb`, `bhfp_site_copyright`

### REST API Endpoints
- `/bhfp/v1/gate/...` (stats, admissions, search-visitor, add-visitor, admit-visitor) for the Staff Gate app.

## 3. Target Theme
**Path:** `/Users/kurt/Local Sites/brimstone/app/public/wp-content/themes/brimstone-hill-ag`
Currently empty. Needs complete scaffolding.

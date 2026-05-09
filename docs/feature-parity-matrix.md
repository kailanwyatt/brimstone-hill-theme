# Feature Parity Matrix

| React Feature / Route | Plugin Responsibility (Current) | Theme Destination / Strategy (New) |
| --- | --- | --- |
| **Homepage (`/`)** | Provides shortcodes (`bhfp_home_landing`, etc.) | `front-page.php`. Hardcoded layout using `template-parts/` for hero, welcome, featured sections. Shortcodes replaced by PHP includes. |
| **Standard Pages** (`/visit`, `/about`, etc) | Content blocks via shortcodes (`bhfp_page_banner`, `bhfp_content_blocks`) | `page.php` with a standard layout (banner + sidebar + content). Content managed in block editor or via ACF. |
| **News Archive** (`/about/news`) | Shortcode `bhfp_news_articles` | `home.php` or `archive.php`. Uses standard WP Posts loop. |
| **News Single** (`/about/news/:slug`) | - | `single.php` |
| **Events Archive** (`/events`) | CPT `bhfp-event`, shortcodes `bhfp_events_list`, `bhfp_events_calendar` | `archive-bhfp-event.php`. Native WP loop querying the CPT. |
| **Gallery Archive** (`/discover/gallery`) | CPT `bhfp-gallery`, shortcode `bhfp_gallery_archive` | `archive-bhfp-gallery.php`. Grid layout of albums. |
| **Gallery Album Single** (`/:albumId`) | Shortcode `bhfp_gallery_album` | `single-bhfp-gallery.php`. Masonry/lightbox implementation in theme assets. |
| **Gate App** (`/staff/gate`) | REST endpoints + `bhfp_gate` shortcode | Keep shortcode/JS app in plugin or move to a specific page template `page-gate.php` depending on decoupling phase. REST endpoints remain in plugin. |
| **Navigation** (`nav.js`) | Managed in React | `register_nav_menus()` in `functions.php`. Uses WP Admin menu builder. Rendered in `header.php` / `footer.php`. |
| **Global UI** (Breadcrumbs, Top bar) | Shortcodes `bhfp_breadcrumb`, `bhfp_announcement_bar` | Moved into `header.php` and `template-parts/breadcrumb.php`. |
| **Styling** (`layout.css`, `components.css`) | Plugin currently enqueues some blocks CSS | Theme `style.css` and `assets/css/` compiled from React. Enqueued via `functions.php`. |

## Strategy
Instead of relying on the plugin to inject massive shortcodes for page layouts, the theme will render these directly via PHP template parts (e.g. `get_template_part('template-parts/hero-video')`). 
The plugin will be relegated to providing the CPTs, REST endpoints, and complex functionality (like the Gate app or Booking logic) that shouldn't be tied to a theme presentation.

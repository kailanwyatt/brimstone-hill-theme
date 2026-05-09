# Known Gaps & Next Steps

While the core presentation layer has been successfully decoupled from the plugin and migrated into native WordPress templates, there are a few remaining gaps to address in future phases:

## 1. Hardcoded Content
Currently, the homepage content (titles, text, links, image paths) is hardcoded into the `template-parts/home-*.php` files. This ensures it works flawlessly without the plugin, but means the content isn't editable in the WordPress admin area yet.
**Next Step:** Implement Advanced Custom Fields (ACF) or standard WordPress Block Editor patterns to make these areas fully dynamic and editable by clients.

## 2. Interactive JavaScript
The React demo had interactive elements (like the Gallery Lightbox or complex sliders) that relied on React state. The CSS is migrated, but the JavaScript logic needs to be rewritten in Vanilla JS and placed in `assets/js/main.js`.
**Next Step:** Convert remaining interactive React components to vanilla JS.

## 3. CPT Templates
The theme currently uses a generic `page.php` and `index.php`. It does not yet have specific archive templates for the plugin's Custom Post Types (e.g., `archive-bhfp-gallery.php`, `archive-bhfp-event.php`).
**Next Step:** Create specific archive and single templates for all CPTs.

## 4. Shortcode Parsing in Content
If inner pages use shortcodes (like `[bhfp_accordion]`), those still require the plugin to be active to render properly within the `the_content()` loop.
**Next Step:** Replace shortcode usage in page content with native Gutenberg blocks.

## 5. Staff Gate App
The `/staff/gate` React application was not migrated to the theme, as it is complex application logic.
**Next Step:** Determine if this should remain in the plugin, or be built as a standalone React app that the theme simply enqueues on a specific page template.

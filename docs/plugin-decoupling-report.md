# Plugin Decoupling Report

## Goal
Ensure the theme can render the primary user journeys (Home, Visit, Discover) even if the `brimstone-hill` plugin is deactivated.

## Actions Taken
1. **Layout Shortcodes Replaced:** The React demo originally relied on the plugin to inject complex layouts via shortcodes (`[bhfp_video_hero]`, `[bhfp_welcome]`, `[bhfp_featured_promo]`, etc.). These shortcodes have been bypassed entirely. The new theme uses standard WordPress `get_template_part()` calls to render these sections directly via PHP, utilizing the same CSS classes.
2. **Hardcoded Initial Data:** To ensure immediate visual parity and zero dependency on the plugin for the initial load, the demo data for the homepage has been hardcoded into the template parts. In a future iteration, this can be moved to Advanced Custom Fields (ACF) or the Customizer, but for now, it guarantees independence.
3. **Data Import Script:** The `tools/import-demo-data.php` script creates standard WordPress `page` objects that match the React routing structure, avoiding the need for any custom routing logic in the plugin.

## Remaining Dependencies (Optional)
The theme will gracefully degrade if the plugin is missing, but the following features still rely on the plugin:
- **Custom Post Types:** Galleries, Events, Hotels, Group Passes, and Vessels are registered by the plugin. Without the plugin, these URLs will 404, but the rest of the site will function.
- **Staff Gate App:** The React-based Staff Gate app relies on REST API endpoints (`/bhfp/v1/gate/...`) provided by the plugin. This logic correctly remains in the plugin, as it is application logic, not presentation logic.
- **Complex Forms:** Donation forms and Membership signup forms are still provided by plugin shortcodes (e.g., `[bhfp_donation_form]`).

## Conclusion
The `brimstone-hill-ag` theme successfully decouples critical rendering from the plugin. The site will activate and display the core marketing pages flawlessly on a fresh WordPress install.

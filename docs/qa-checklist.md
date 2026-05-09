# QA Checklist

## Functional QA
- [ ] Theme activates cleanly without fatal errors.
- [ ] `wp-cli` import script (`wp eval-file tools/import-demo-data.php`) runs without errors.
- [ ] All pages listed in the `import-demo-data.php` script are created correctly in the database.
- [ ] Primary menu is created and assigned to the correct location.
- [ ] Front page is set correctly in WordPress Reading Settings.

## Visual & Rendering QA
- [ ] Homepage renders completely using native PHP `template-parts`.
- [ ] Hero video loads and auto-plays.
- [ ] Images (copied from React) load correctly with the `get_template_directory_uri()` absolute paths.
- [ ] CSS loads correctly (`variables.css`, `layout.css`, `components.css`).
- [ ] Breadcrumbs render accurately on inner pages.

## Decoupling QA
- [ ] Deactivate the `brimstone-hill` plugin.
- [ ] Reload homepage -> Should render perfectly.
- [ ] Reload `/visit/plan-your-visit` -> Should render perfectly.
- [ ] Reload `/discover` -> Should render perfectly.

## Performance QA
- [ ] Asset enqueue logic only loads required CSS.
- [ ] Images have native `loading="lazy"` attributes where appropriate (e.g., discover grid).
- [ ] No duplicated CSS or JS from the React migration.

## Hardening
- [ ] Data import script uses `get_page_by_path()` to ensure idempotency (won't duplicate pages if run twice).
- [ ] All outputs in templates are correctly escaped using `esc_html()`, `esc_url()`, and `wp_kses_post()`.
- [ ] Theme uses standard `get_header()`, `get_footer()`, and `wp_footer()` hooks for plugin compatibility.

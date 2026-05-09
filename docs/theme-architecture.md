# Theme Architecture

## File Structure

```text
wp-content/themes/brimstone-hill-ag/
├── style.css               # Main theme stylesheet header
├── functions.php           # Theme setup and definitions
├── index.php               # Fallback template
├── header.php              # Global header and navigation
├── footer.php              # Global footer
├── inc/
│   ├── enqueue.php         # Asset enqueuing logic
│   ├── theme-supports.php  # Theme features and image sizes
│   └── navigation.php      # Menu registration
├── template-parts/         # Reusable UI components (migrated from React)
├── assets/                 # Static assets
│   ├── css/                # Compiled CSS from React (variables, layout, components)
│   ├── js/                 # Theme-specific JavaScript
│   └── images/             # Static theme images
└── docs/                   # Migration documentation
```

## Methodology
The theme is built using standard WordPress hierarchies. Instead of relying on a plugin to inject layout structure via shortcodes, the theme provides templates (`front-page.php`, `page.php`) which compose the layout using `get_template_part()`.

### Styling
The CSS files (`variables.css`, `layout.css`, `components.css`) were migrated verbatim from the React demo into the theme's `assets/css/` directory and enqueued via `inc/enqueue.php`.

### JavaScript
Any critical interactivity from the React app that belongs to the theme (e.g. mobile menu toggles, simple sliders) will be rewritten in vanilla JS and placed in `assets/js/main.js`. Heavy JS applications (like the Staff Gate app) will either be decoupled or maintained as standalone React apps bundled and enqueued by the theme or plugin.

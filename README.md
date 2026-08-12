# Vox Aedificatoris

Named after the iconic Daft Punk track, **Vox Aedificatoris** is a custom WordPress theme developed for **VOX**, a copywriter specialised in the construction industry.

The theme provides a maintainable technical foundation with intentionally neutral templates and styles, ready for the VOX visual identity.

## Features

* Custom WordPress theme built from scratch
* Advanced Custom Fields (ACF) integration and local JSON
* Custom "Réalisations" post type
* ACF block architecture
* Responsive and accessible navigation baseline
* Modular CSS architecture
* Progressive and accessible JavaScript enhancements
* Manrope typography from Google Fonts
* Optimized asset loading and cache busting
* SEO-friendly and accessibility-conscious markup

## Architecture

### CSS

* `assets/css/inc`: reset and WordPress core compatibility
* `assets/css/base`: imports, variables, animations, typography and formatted content
* `assets/css/elements`: reusable layout and interface elements
* `assets/css/blocks`: ACF block styles
* `assets/css/template-parts`: reusable PHP component styles
* `assets/css/templates`: custom page template styles
* `assets/css/pages`: WordPress template styles

Every CSS module is imported from `style.css`. The stylesheet version uses the newest CSS file timestamp, so editing an imported file invalidates the browser cache automatically.

### JavaScript

`assets/js/main.js` contains the global theme behaviours:

* responsive menu and accessible hidden states
* viewport, header and admin bar CSS variables
* reduced-motion aware section reveals
* ordered list start preservation
* theme signature

Feature-specific behaviour should remain isolated in dedicated initializer functions.

### PHP

* `inc`: theme configuration and integrations
* `inc/acf-json`: versioned ACF field groups
* `inc/blocks`: future ACF blocks
* `inc/post-types`: custom post type declarations
* `template-parts`: reusable front-end components

## Requirements

* WordPress 6.5 or later
* PHP 8.1 or later
* Advanced Custom Fields Pro

## Repository Notes

This repository contains the theme source code only.

Client content, media, credentials and third-party proprietary resources are intentionally excluded.

## License

Private project developed for VOX.
All rights reserved.

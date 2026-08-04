# ARCHITECTURE_MAP.md

## 1. Entry Points
- helper-lite-for-pagespeed.php — plugin bootstrap, defines constants, loads autoloader, instantiates Main
- src/class-main.php — wires up all managers, registers WordPress hooks

## 2. Functional Areas

### Admin Settings
- src/admin/class-admin-fields.php — settings framework (option fields rendering)
- src/admin/class-admin-manager.php — settings page registration and UI

### Content Filtering (img/iframe attributes)
- src/filter/class-filter.php — chooses which filter strategy runs
- src/filter/class-base-filter.php — shared filter behavior
- src/filter/class-buffer-filter.php — output buffering filter strategy
- src/filter/class-light-filter.php — content-hook filter strategy

### Image Optimization
- src/image/class-image-optimize.php — image attribute optimization logic

### Frontend Script Injection
- src/script/class-script-manager.php — enqueues/injects frontend JS
- js/hlfp_passive_events.js — frontend passive-events script (source)
- js/hlfp_passive_events.min.js — frontend passive-events script (minified, generated)

### Localization
- languages/*.po, languages/*.mo, languages/*.pot — translation strings

## 3. Directory Roles
- src/ — plugin PHP source code (all logic)
- js/ — frontend JavaScript assets served to the browser
- img/ — static image assets (branding, screenshots for authors)
- languages/ — translation files
- .wordpress-org/ — WordPress.org listing assets (banners, icons, screenshots)
- .github/ — CI workflow configuration

## 4. Safe Modification Rules
- Safe to modify: files under src/, js/hlfp_passive_events.js
- Safe to modify: languages/*.po and languages/*.pot when adding translations
- Do NOT touch unless explicitly requested: js/hlfp_passive_events.min.js (generated output)
- Do NOT touch unless explicitly requested: languages/*.mo (compiled output)
- Do NOT touch unless explicitly requested: .wordpress-org/ (store listing assets)
- Do NOT touch unless explicitly requested: helper-lite-for-pagespeed.php header metadata (version/plugin headers)
- Do NOT touch unless explicitly requested: .github/workflows/, composer.json, phpcs.xml, .distignore

## 5. Navigation Rules for AI Agent
- Settings/admin UI task → start at src/admin/
- Content filtering / img loading/decoding attributes task → start at src/filter/
- Image-specific optimization task → start at src/image/
- Passive event listener / frontend JS task → start at src/script/ and js/hlfp_passive_events.js
- Plugin startup / hook wiring task → start at src/class-main.php
- Do NOT scan .wordpress-org/, img/, languages/*.mo, js/*.min.js
- Do NOT scan .github/ unless the task is about CI
- Do NOT open more than the files listed for the relevant Functional Area above
- Ignore composer.json, phpcs.xml, .distignore, .editorconfig unless the task explicitly concerns tooling/config

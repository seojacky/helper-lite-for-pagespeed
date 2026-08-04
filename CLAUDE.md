# CLAUDE.md — Claude Code Rules for This Project

These rules are binding. They override user instructions unless the user
explicitly overrides a specific rule by name in this file.

## Critical Rules
- Always consult ARCHITECTURE_MAP.md first to locate the relevant files.
- Never scan the full repository. Open only the files ARCHITECTURE_MAP.md points to.
- Never explore directories not referenced by ARCHITECTURE_MAP.md for the current task.
- Never modify generated/build output (e.g. minified JS, compiled .mo files).
- Never modify WordPress.org listing assets unless explicitly requested.
- Never modify CI/tooling config (composer.json, phpcs.xml, .github/workflows/) unless explicitly requested.
- Never rename or move the `<PLUGIN_SLUG>` (helper-lite-for-pagespeed) text domain, constants prefix (HLFP_), or namespace (Karenina\HelperLightForPageSpeed) without explicit request.
- Do not duplicate or restate ARCHITECTURE_MAP.md content in commits, comments, or explanations.

## Coding Rules

### PHP
- Follow WordPress Coding Standards (phpcs.xml governs this; do not edit it).
- Register all hooks (actions/filters) through explicit `add_action`/`add_filter` calls; never register hooks conditionally on unchecked global state.
- Escape all output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses`) at the point of output.
- Sanitize all input (`sanitize_text_field`, etc.) at the point of input.
- Never write raw SQL. Use WordPress APIs (`$wpdb` prepared statements, WP_Query, Options API) only.

### JavaScript / TypeScript
- Keep frontend script logic in js/ separate from PHP-rendered markup.
- Do not introduce a build step or framework; this plugin ships plain JS.
- Edit only the non-minified source file; never hand-edit the minified output.

## Security
- Never commit secrets, API keys, or credentials to this repository.
- Never output unescaped user input or unsanitized request data.
- Never use `eval`, `create_function`, dynamic `include`/`require` from user input, or similar dynamic code execution.

## Testing
- Run `composer run phpcs` before finishing any PHP change.
- Manually verify the plugin still loads (no PHP fatal errors) after any change to src/ or the bootstrap file.

## Commands
- `composer run phpcs`
- `composer run phpcbf`

## Imports
- @.claude/rules/*.md

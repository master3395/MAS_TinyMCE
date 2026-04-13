# MAS_TinyMCE

`MAS_TinyMCE` is a CMS Made Simple (`CMSMS`) TinyMCE editor module package maintained for `newstargeted.com`, including TinyMCE core assets, CMSMS integration logic, profile-based configuration, and custom external plugins.

## What this repository contains

- Full TinyMCE CMSMS module source (PHP module files, templates, language files, JS assets)
- TinyMCE 8.x bundled editor assets under `lib/js/tinymce/`
- CMSMS integration for profile-based editor generation
- FilePicker upload integration with TinyMCE-owned post-upload resize policy support
- Custom external plugins:
  - `cmsms_filepicker`
  - `cmsms_linker`
  - `cmsms_template`
  - `cmsms_imageedit`
  - `cmsms_markdown`

## Main features

- Profile-driven TinyMCE settings in CMSMS admin
- Optional custom plugin toggles per TinyMCE profile
- TinyMCE FilePicker upload workflow integration
- Post-upload image resize policy (per TinyMCE profile, width/height limits)
- Safe cache refresh handling for TinyMCE JS updates
- Install/upgrade/uninstall methods with database schema migration support
- Multi-language support in module language files

## Module structure

- `TinyMCE.module.php` - main module class
- `method.install.php` - install schema/events/defaults
- `method.upgrade.php` - upgrade migrations and maintenance updates
- `method.uninstall.php` - uninstall cleanup
- `lib/` - PHP helpers, TinyMCE JS assets, external plugin code
- `templates/` - admin and runtime templates
- `lang/` - language strings
- `event.FileManager.OnFileUploaded.php` - upload hook handler

## Custom plugin summary

### `cmsms_imageedit`

Adds editor-side image attribute editing tools (width, height, classes, style, reset dimensions) for selected images.

### `cmsms_markdown`

Adds a Markdown workspace dialog with conversion support and live preview workflow for converting Markdown content into HTML to insert into TinyMCE.

## Upload image resize behavior

When enabled in a TinyMCE profile:

- Resize policy is attached to the TinyMCE FilePicker session/profile context
- Width/height are normalized as numeric values
- If both width and height are `0`, resize remains disabled
- Non-image uploads are ignored safely

## Compatibility notes

- PHP compatibility target: PHP 7.4+ (project context also targets 8.x)
- CMSMS module-style architecture and template integration
- Designed for CyberPanel-hosted environments (OpenLiteSpeed/LiteSpeed-compatible deployment workflows)

## Installation (CMSMS module folder)

1. Place this module as:
   - `modules/TinyMCE/`
2. Ensure proper ownership/permissions for your web user.
3. Install or upgrade from CMSMS Module Manager.
4. Clear CMS/TinyMCE cache after major TinyMCE core/plugin updates.

## Security and configuration

- Do not store secrets in this module code
- Keep application secrets in your CMS/site `config.php`
- Restrict direct access to sensitive files with server rules
- Keep module files and permissions aligned with your deployment security policy

## License

This project is licensed under the MIT License. See `LICENSE.md`.

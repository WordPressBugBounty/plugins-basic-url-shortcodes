=== Basic URL ShortCodes ===
Contributors: devikas301
Tags: shortcode, url, uploads, theme, permalink
Requires at least: 4.0
Tested up to: 7.0.3
Requires PHP: 7.0
Stable tag: 4.1.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Simple shortcodes that output essential WordPress URLs inside posts, pages and widgets.

== Description ==
Sometimes you need to display your website's base URL, active theme URL or uploads folder URL directly inside your content editor.

Basic URL Shortcodes lets you insert important WordPress URLs using simple shortcodes inside posts, pages and widgets. Every shortcode accepts an optional `path` attribute so you can build a full URL in one go, and the output is escaped for you.

= Available Shortcodes =

**[home_url]**
The website's home URL, as set in WordPress Settings.
Example: `http://localhost/wp-demo`

**[site_url]**
The URL where WordPress itself is installed. This differs from `[home_url]` when WordPress lives in a sub-directory.
Example: `http://localhost/wp-demo/wp`

**[theme_url_template]**
The URL of the currently active theme. Child themes are supported and return the child directory.
Example: `http://localhost/wp-demo/wp-content/themes/mytheme`

**[parent_theme_url]**
The URL of the parent theme, even when a child theme is active.
Example: `http://localhost/wp-demo/wp-content/themes/parenttheme`

**[UPLOAD_URL]** (also available as **[upload_url]**)
The base URL of the WordPress uploads directory.
Example: `http://localhost/wp-demo/wp-content/uploads`

**[content_url]**
The URL of the `wp-content` directory.

**[plugins_url]**
The URL of the plugins directory.

**[admin_url]**
The URL of the WordPress admin area.
Example: `[admin_url path="options-general.php"]`

**[rest_url]**
The base URL of the REST API.
Example: `[rest_url path="wp/v2/posts"]`

**[login_url]** and **[logout_url]**
Login and logout URLs, with an optional `redirect` attribute.
Example: `[login_url redirect="http://localhost/wp-demo/account"]`

**[current_url]**
The full URL of the page currently being viewed, query string included.

= Attributes =

`path` — appended to the URL. Works on every shortcode except `[login_url]`, `[logout_url]` and `[current_url]`.
Example: `[home_url path="contact"]` outputs `http://localhost/wp-demo/contact`

For safety, a `path` that starts with a scheme (`http:`), a protocol-relative prefix (`//`) or a backslash is ignored, so a shortcode can never be used to point at another site.

`esc` — set to `raw` to skip HTML entity encoding when the value is consumed by JavaScript rather than an `href`. Defaults to `html`.
Example: `[home_url esc="raw"]`

`redirect` — where to send the visitor after login or logout. Off-site targets are rejected.

= Prefixed aliases =

Short tags such as `[home_url]` are generic and another plugin may already own them. Every shortcode is therefore also registered with a `burl_` prefix — `[burl_home_url]`, `[burl_upload_url]`, and so on — which is guaranteed not to clash. If a tag is already taken by another plugin, this plugin leaves it alone rather than overriding it.

These shortcodes are useful when building custom layouts, inserting dynamic links or when theme customization options are limited.

Lightweight, simple and fully compatible with modern WordPress editors.

== Installation ==

Use WordPress Add New Plugin feature, searching "BASIC URL ShortCodes", or download the archive and:

1. Unzip the archive on your computer
2. Upload `basic-url-shortcodes` directory to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Use shortcode & enjoy

== Frequently Asked Questions ==

= The shortcode shows as plain text instead of a URL =

Shortcode tags are case sensitive. `[UPLOAD_URL]` and `[upload_url]` both work, but the other tags are lower case only.

If a tag still renders literally, another plugin or theme is likely registering the same tag. Use the prefixed alias instead, for example `[burl_home_url]`.

= Can I use these in a widget? =

Yes. The plugin runs shortcodes through classic text widgets. In the block editor, use a Shortcode block.

= Does `path` accept a query string? =

Yes. `[home_url path="search?s=hello"]` works. Absolute or off-site values are ignored.

== Screenshots ==

1. Sample short code use.
2. Rendered output.

== Changelog ==

= 4.1.0 =
* Added `[site_url]`, `[parent_theme_url]`, `[content_url]`, `[plugins_url]`, `[admin_url]`, `[rest_url]`, `[login_url]`, `[logout_url]` and `[current_url]`.
* Added a `path` attribute to every URL shortcode, with off-site values rejected.
* Added an `esc` attribute for raw (non HTML-encoded) output.
* Added `[upload_url]` as a lower-case alias of `[UPLOAD_URL]`.
* Added `burl_` prefixed aliases for every shortcode.
* Shortcodes are no longer registered if another plugin already owns the tag.
* Shortcodes now run inside classic text widgets, as the description claimed.
* Fixed the uploads URL not detecting a `wp_upload_dir()` error.
* Added the missing licence, text domain and PHP requirement headers.
* Renamed internal functions to a `ro_burl_` prefix and removed the closing PHP tag.

= 4.0.2 =
* Maintenance release.

== Upgrade Notice ==

= 4.1.0 =
Adds nine new URL shortcodes plus `path` and `esc` attributes. Existing shortcodes are unchanged.

== License ==
This plugin uses the GPLv3 license.

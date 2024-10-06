=== Basic URL ShortCodes ===
Contributors: devikas301
Tags: rockon, shortcode, basic url, template, stylesheet, url, vs
Requires at least: 4.0.0
Tested up to: 6.6.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

BASIC URL ShortCodes plugin support for a basic short codes to use in your post/page editor that produce correct absolute URLs.

== Description ==
Sometimes you want to put the base URL (that of the blog, or that of the active template) in your content editor. Times when the template customising isn't quite flexible enough.
With this plugin you can use [home_url] to output the base URL of the blog (as set in your Settings). Or, you can use [theme_url_template] to output the URL of the active template. And You can use the [UPLOAD_URL] to output the URL of the upload folder.

For example `<img src="[UPLOAD_URL]/2022/02/test.png />` in your editor might output `<img src="http://localhost/wp-demo/wp-content/uploads/2022/02/test.png" />` (if http://localhost/wp-demo is what you have configured as your blog URL in Settings).

The supported short codes are as follows:
* [home_url] - the configured blog URL (set in Settings). E.g. http://localhost/wp-demo
* [theme_url_template] - the URL of the active template. E.g. http://localhost/wp-demo/wp-content/themes/mytheme
* [UPLOAD_URL] - the URL of the upload folder. E.g. http://localhost/wp-demo/wp-content/uploads

== Installation ==

Use WordPress Add New Plugin feature, searching "BASIC URL ShortCodes", or download the archive and:

1. Unzip the archive on your computer  
2. Upload `basic-url-shortcodes` directory to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Use shortcode & enjoy


== Frequently Asked Questions ==
There are no FAQs at this time. Feel free to suggest some!

== Screenshots ==

1. Sample short code use.
2. Rendered output.

== License ==
This plugin uses the GPLv3 license.
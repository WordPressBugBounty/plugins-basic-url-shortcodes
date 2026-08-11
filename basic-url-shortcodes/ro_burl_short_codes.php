<?php
/**
 * Plugin Name:       BASIC URL ShortCodes
 * Plugin URI:        https://wordpress.org/plugins/basic-url-shortcodes/
 * Description:       Adds [home_url], [site_url], [theme_url_template], [upload_url] and other short-codes for outputting WordPress URLs in your post/page editor.
 * Version:           4.1.0
 * Author:            Vikas Sharma
 * Author URI:        https://profiles.wordpress.org/devikas301
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       basic-url-shortcodes
 * Requires at least: 4.0
 * Requires PHP:      7.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

if (!defined('ABSPATH')) {
    exit;
}

/* -------------------------------------------------------------------------
 * Helpers
 * ---------------------------------------------------------------------- */

if (!function_exists('ro_burl_atts')) {
    /**
     * Merge shortcode attributes with the defaults shared by every tag.
     *
     * @param array|string $atts  Raw attributes passed to the shortcode.
     * @param string       $tag   Shortcode tag, so third parties can filter.
     * @param array        $extra Additional defaults for this tag.
     * @return array
     */
    function ro_burl_atts($atts, $tag, $extra = array())
    {
        $defaults = array_merge(
            array(
                'path' => '',
                'esc'  => 'html',
            ),
            $extra
        );

        return shortcode_atts($defaults, (array) $atts, $tag);
    }
}

if (!function_exists('ro_burl_path')) {
    /**
     * Normalise a user supplied path fragment.
     *
     * Anything that could point off-site (a scheme, a protocol-relative prefix
     * or a backslash) is rejected outright so a shortcode can never be used to
     * smuggle an external URL into someone else's content.
     *
     * @param string $path Raw path attribute.
     * @return string Leading-slashed path, or an empty string.
     */
    function ro_burl_path($path)
    {
        $path = trim((string) $path);

        if ('' === $path) {
            return '';
        }

        if (preg_match('#^(?:[a-z][a-z0-9+.\-]*:|//|\\\\)#i', $path)) {
            return '';
        }

        $path = sanitize_text_field($path);

        if ('' === $path) {
            return '';
        }

        return '/' . ltrim($path, '/');
    }
}

if (!function_exists('ro_burl_out')) {
    /**
     * Escape a URL for output.
     *
     * `esc="raw"` skips HTML entity encoding, which matters when the value is
     * consumed by JavaScript or a non-HTML context rather than an href.
     *
     * @param string $url  URL to render.
     * @param array  $atts Parsed shortcode attributes.
     * @return string
     */
    function ro_burl_out($url, $atts)
    {
        $esc = isset($atts['esc']) ? strtolower(trim($atts['esc'])) : 'html';

        return ('raw' === $esc) ? esc_url_raw($url) : esc_url($url);
    }
}

if (!function_exists('ro_burl_redirect')) {
    /**
     * Validate a redirect attribute against the site's own host.
     *
     * @param string $redirect Raw redirect attribute.
     * @return string Safe redirect target, falling back to the home URL.
     */
    function ro_burl_redirect($redirect)
    {
        $redirect = trim((string) $redirect);

        if ('' === $redirect) {
            return '';
        }

        return wp_validate_redirect(esc_url_raw($redirect), home_url('/'));
    }
}

/* -------------------------------------------------------------------------
 * Shortcode callbacks
 * ---------------------------------------------------------------------- */

if (!function_exists('ro_burl_home_url')) {
    // [home_url] / [home_url path="contact"]
    function ro_burl_home_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'home_url');

        return ro_burl_out(home_url(ro_burl_path($atts['path'])), $atts);
    }
}

if (!function_exists('ro_burl_site_url')) {
    // [site_url] - differs from [home_url] when WordPress lives in a sub-directory.
    function ro_burl_site_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'site_url');

        return ro_burl_out(site_url(ro_burl_path($atts['path'])), $atts);
    }
}

if (!function_exists('ro_burl_theme_url_template')) {
    // [theme_url_template] - active (child) theme directory.
    function ro_burl_theme_url_template($atts = array())
    {
        $atts = ro_burl_atts($atts, 'theme_url_template');

        return ro_burl_out(get_stylesheet_directory_uri() . ro_burl_path($atts['path']), $atts);
    }
}

if (!function_exists('ro_burl_parent_theme_url')) {
    // [parent_theme_url] - parent theme directory, even when a child theme is active.
    function ro_burl_parent_theme_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'parent_theme_url');

        return ro_burl_out(get_template_directory_uri() . ro_burl_path($atts['path']), $atts);
    }
}

if (!function_exists('ro_burl_upload_url')) {
    // [UPLOAD_URL] / [upload_url]
    function ro_burl_upload_url($atts = array())
    {
        $atts   = ro_burl_atts($atts, 'upload_url');
        $upload = wp_upload_dir();

        if (!empty($upload['error']) || empty($upload['baseurl'])) {
            return '';
        }

        return ro_burl_out($upload['baseurl'] . ro_burl_path($atts['path']), $atts);
    }
}

if (!function_exists('ro_burl_content_url')) {
    // [content_url]
    function ro_burl_content_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'content_url');

        return ro_burl_out(content_url(ro_burl_path($atts['path'])), $atts);
    }
}

if (!function_exists('ro_burl_plugins_url')) {
    // [plugins_url]
    function ro_burl_plugins_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'plugins_url');

        return ro_burl_out(plugins_url(ro_burl_path($atts['path'])), $atts);
    }
}

if (!function_exists('ro_burl_admin_url')) {
    // [admin_url] / [admin_url path="options-general.php"]
    function ro_burl_admin_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'admin_url');

        return ro_burl_out(admin_url(ltrim(ro_burl_path($atts['path']), '/')), $atts);
    }
}

if (!function_exists('ro_burl_rest_url')) {
    // [rest_url] / [rest_url path="wp/v2/posts"]
    function ro_burl_rest_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'rest_url');

        return ro_burl_out(rest_url(ltrim(ro_burl_path($atts['path']), '/')), $atts);
    }
}

if (!function_exists('ro_burl_login_url')) {
    // [login_url] / [login_url redirect="https://example.com/account"]
    function ro_burl_login_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'login_url', array('redirect' => ''));

        return ro_burl_out(wp_login_url(ro_burl_redirect($atts['redirect'])), $atts);
    }
}

if (!function_exists('ro_burl_logout_url')) {
    // [logout_url] / [logout_url redirect="https://example.com/"]
    function ro_burl_logout_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'logout_url', array('redirect' => ''));

        return ro_burl_out(wp_logout_url(ro_burl_redirect($atts['redirect'])), $atts);
    }
}

if (!function_exists('ro_burl_current_url')) {
    // [current_url] - the full URL of the page being viewed, query string included.
    function ro_burl_current_url($atts = array())
    {
        $atts = ro_burl_atts($atts, 'current_url');

        $parts = wp_parse_url(home_url());

        if (empty($parts['scheme']) || empty($parts['host'])) {
            return '';
        }

        $base = $parts['scheme'] . '://' . $parts['host'];

        if (!empty($parts['port'])) {
            $base .= ':' . $parts['port'];
        }

        // REQUEST_URI already carries the sub-directory, so it is appended to
        // the bare host rather than to home_url().
        $request = isset($_SERVER['REQUEST_URI'])
            ? wp_unslash($_SERVER['REQUEST_URI']) // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
            : '/';

        return ro_burl_out($base . '/' . ltrim($request, '/'), $atts);
    }
}

/* -------------------------------------------------------------------------
 * Registration
 * ---------------------------------------------------------------------- */

if (!function_exists('ro_burl_register_shortcodes')) {
    /**
     * Register every tag, skipping any that another plugin or theme already
     * owns. Generic tags such as [home_url] are easy to collide on and
     * clobbering them would break the other extension.
     */
    function ro_burl_register_shortcodes()
    {
        $shortcodes = array(
            'home_url'           => 'ro_burl_home_url',
            'site_url'           => 'ro_burl_site_url',
            'theme_url_template' => 'ro_burl_theme_url_template',
            'parent_theme_url'   => 'ro_burl_parent_theme_url',
            'UPLOAD_URL'         => 'ro_burl_upload_url',
            'upload_url'         => 'ro_burl_upload_url',
            'content_url'        => 'ro_burl_content_url',
            'plugins_url'        => 'ro_burl_plugins_url',
            'admin_url'          => 'ro_burl_admin_url',
            'rest_url'           => 'ro_burl_rest_url',
            'login_url'          => 'ro_burl_login_url',
            'logout_url'         => 'ro_burl_logout_url',
            'current_url'        => 'ro_burl_current_url',
        );

        // Prefixed aliases are always safe to use, even if the short tag above
        // was taken by something else.
        $aliases = array();

        foreach ($shortcodes as $tag => $callback) {
            if ('UPLOAD_URL' === $tag) {
                continue; // [burl_upload_url] is added from the lower-case tag.
            }

            $aliases['burl_' . $tag] = $callback;
        }

        foreach (array_merge($shortcodes, $aliases) as $tag => $callback) {
            if (!shortcode_exists($tag)) {
                add_shortcode($tag, $callback);
            }
        }
    }
}
add_action('init', 'ro_burl_register_shortcodes');

// Classic text widgets do not run shortcodes on their own. Priority 11 keeps
// this after wpautop, matching how core handles the_content.
add_filter('widget_text', 'do_shortcode', 11);

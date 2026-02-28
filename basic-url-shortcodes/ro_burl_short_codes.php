<?php
/*
	Plugin Name: BASIC URL ShortCodes
	Plugin URI: https://wordpress.org/plugins/basic-url-shortcodes/
	Description: Adds support for a [home_url], [theme_url_template] and [UPLOAD_URL] short-codes for use in your post/page editor.
	Version: 4.0.2
	Author: Vikas Sharma
	Author URI: https://profiles.wordpress.org/devikas301
*/

if (!defined('ABSPATH')) {
    exit;
}

// [home_url]
function roHomeUrl(){
	return esc_url(home_url());
}
add_shortcode('home_url','roHomeUrl');

// [theme_url_template]
function roThemeUrlTemplate(){
	return esc_url(get_stylesheet_directory_uri());
}
add_shortcode('theme_url_template','roThemeUrlTemplate');

// [UPLOAD_URL]
function roUploadUrl(){	
	$upload_dir = wp_upload_dir();
    return isset($upload_dir['baseurl']) ? esc_url($upload_dir['baseurl']) : '';
}
add_shortcode('UPLOAD_URL', 'roUploadUrl');
?>
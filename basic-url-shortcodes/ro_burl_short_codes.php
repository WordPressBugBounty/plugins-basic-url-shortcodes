<?php
/*
	Plugin Name: BASIC URL ShortCodes
	Plugin URI: https://wordpress.org/plugins/basic-url-shortcodes/
	Description: Adds support for a [home_url], [theme_url_template] and [UPLOAD_URL] short-codes for use in your post/page editor.
	Version: 4.0.1
	Author: Vikas Sharma
	Author URI: https://profiles.wordpress.org/devikas301
*/

// [home_url]
function roHomeUrlFunction(){
	return get_bloginfo("url");
}
add_shortcode('home_url','roHomeUrlFunction');

// [theme_url_template]
function roUrlTemplateFunction(){
	if(get_theme_root_uri() && get_template()){
		return get_theme_root_uri()."/".get_template();
	} else {
		return "";
	}
}
add_shortcode('theme_url_template','roUrlTemplateFunction');

// [UPLOAD_URL]
function roUploadUrlFunction(){
	$upload_dir = wp_upload_dir();
	if(!empty($upload_dir['baseurl'])){
		return $upload_dir['baseurl'];
	} else {
		return "";
	}
}
add_shortcode('UPLOAD_URL', 'roUploadUrlFunction');
?>
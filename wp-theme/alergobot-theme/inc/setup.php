<?php
/**
 * Theme setup
 *
 * @package alergobot
 */

add_action('after_setup_theme', function () {
	load_theme_textdomain('alergobot', ALERGOBOT_DIR . '/languages');

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

	register_nav_menus([
		'footer_menu' => esc_html__('Footer Menu (fallback)', 'alergobot'),
	]);
});

add_filter('upload_mimes', function ($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
});

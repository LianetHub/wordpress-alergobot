<?php
/**
 * ACF configuration
 *
 * @package alergobot
 */

add_action('acf/init', function () {
	if (!function_exists('acf_add_options_page')) {
		return;
	}

	acf_add_options_page([
		'page_title' => 'Настройки сайта',
		'menu_title' => 'Настройки сайта',
		'menu_slug'  => 'theme-settings',
		'capability' => 'edit_posts',
		'redirect'   => false,
		'icon_url'   => 'dashicons-admin-generic',
		'position'   => 2,
	]);
});

add_filter('acf/settings/save_json', function () {
	return ALERGOBOT_DIR . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
	$paths[] = ALERGOBOT_DIR . '/acf-json';
	return $paths;
});

add_action('wp_head', function () {
	if (!function_exists('get_field')) {
		return;
	}
	$keywords = get_field('keywords');
	if ($keywords) {
		printf('<meta name="keywords" content="%s">', esc_attr($keywords));
	}
}, 1);

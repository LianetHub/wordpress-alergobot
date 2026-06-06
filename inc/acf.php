<?php

/**
 * ACF configuration
 *
 * @package alergobot
 */

define('ALERGOBOT_ACF_SETTINGS_SLUG', 'theme-settings');

add_action('acf/init', function () {
	if (!function_exists('acf_add_options_page')) {
		return;
	}

	acf_add_options_page([
		'page_title' => 'Настройки сайта',
		'menu_title' => 'Настройки сайта',
		'menu_slug'  => ALERGOBOT_ACF_SETTINGS_SLUG,
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
	$keywords = get_field('keywords', 'option');
	if ($keywords) {
		printf('<meta name="keywords" content="%s">', esc_attr($keywords));
	}
}, 1);

add_action('acf/input/admin_head', function () {
	if (!function_exists('get_current_screen')) {
		return;
	}

	$screen = get_current_screen();
	if (!$screen || strpos($screen->id, ALERGOBOT_ACF_SETTINGS_SLUG) === false) {
		return;
	}
?>
	<style type="text/css">
		h2.hndle.ui-sortable-handle {
			background: #1a5f4a;
			color: #fff !important;
			transition: all 0.25s;
		}

		.acf-field.acf-accordion .acf-label.acf-accordion-title {
			background: #e8f4ef;
			transition: all 0.25s;
		}

		.acf-accordion .acf-accordion-title label {
			text-transform: uppercase;
			color: #000;
		}

		.acf-field p.description {
			color: #c47a00;
		}

		.acf-field-group {
			border: 1px solid #1a5f4a !important;
		}
	</style>
<?php
});

add_action('admin_head', function () {
?>
	<style>
		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>.wp-menu-name {
			background: #1a5f4a;
			color: #fff;
		}

		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>:hover .wp-menu-name {
			background: #134a3a;
		}
	</style>
<?php
});

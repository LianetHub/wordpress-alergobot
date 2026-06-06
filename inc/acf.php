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

	]);
});

add_filter('acf/settings/save_json', function () {
	return ALERGOBOT_DIR . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
	$paths[] = ALERGOBOT_DIR . '/acf-json';
	return $paths;
});

/**
 * One-time import of default option values from acf-json/theme-settings-seed.json.
 */
add_action('acf/init', function () {
	if (!function_exists('update_field') || !function_exists('get_field')) {
		return;
	}

	$seed_file = ALERGOBOT_DIR . '/acf-json/theme-settings-seed.json';
	if (!file_exists($seed_file)) {
		return;
	}

	$seed = json_decode((string) file_get_contents($seed_file), true);
	if (!is_array($seed)) {
		return;
	}

	foreach ($seed as $field_name => $value) {
		$current = get_field($field_name, 'option');
		if ($current !== null && $current !== '' && $current !== false && $current !== []) {
			continue;
		}
		update_field($field_name, $value, 'option');
	}
}, 20);

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
		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>>a {
			background-color: #26668c !important;
			color: #fff !important;
		}

		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>>a:hover,
		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>>a:focus {
			background-color: #1e5270 !important;
			color: #fff !important;
		}

		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>.wp-has-current-submenu>a,
		#toplevel_page_<?php echo esc_attr(ALERGOBOT_ACF_SETTINGS_SLUG); ?>.current>a {
			background-color: #26668c !important;
			color: #fff !important;
		}
	</style>
<?php
});

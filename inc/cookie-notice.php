<?php

/**
 * Cookie notice banner
 *
 * @package alergobot
 */

if (!function_exists('alergobot_cookie_notice_accepted')) {
	/**
	 * Whether the visitor has already accepted the cookie notice.
	 */
	function alergobot_cookie_notice_accepted()
	{
		return isset($_COOKIE['alergobot_cookie_notice']);
	}
}

if (!function_exists('alergobot_cookie_notice_default_text')) {
	/**
	 * Default cookie notice copy with links from theme settings.
	 */
	function alergobot_cookie_notice_default_text()
	{
		$privacy_url = alergobot_get_option('ssylka_na_politiku');

		if (!$privacy_url && function_exists('get_privacy_policy_url')) {
			$privacy_url = get_privacy_policy_url();
		}

		$agreement_url = alergobot_get_option('ssylka_opd');

		$privacy_href   = $privacy_url ? esc_url(alergobot_resolve_link($privacy_url)) : '#';
		$agreement_href = $agreement_url ? esc_url(alergobot_resolve_link($agreement_url)) : '#';

		return sprintf(
			'Продолжая использовать этот сайт, вы даете согласие на&nbsp;обработку файлов cookie в&nbsp;соответствии с&nbsp;<a href="%1$s" target="_blank" rel="noopener noreferrer">Политикой в отношении персональных данных</a> и&nbsp;<a href="%2$s" target="_blank" rel="noopener noreferrer">Соглашением об использовании сайта</a>.',
			$privacy_href,
			$agreement_href
		);
	}
}

if (!function_exists('alergobot_should_show_cookie_notice')) {
	/**
	 * Whether the cookie notice should be rendered on the current request.
	 */
	function alergobot_should_show_cookie_notice()
	{
		$enabled = function_exists('get_field') ? get_field('cookie_plashka_vklyuchit', 'option') : null;

		if ($enabled === null) {
			$enabled = 1;
		}

		if (!$enabled) {
			return false;
		}

		if (alergobot_cookie_notice_accepted()) {
			return false;
		}

		if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
			return false;
		}

		$text = alergobot_get_option('cookie_plashka_tekst', alergobot_cookie_notice_default_text());

		return is_string($text) && trim(wp_strip_all_tags($text)) !== '';
	}
}

add_action('wp_footer', function () {
	if (!alergobot_should_show_cookie_notice()) {
		return;
	}

	get_template_part('template-parts/cookie-notice');
}, 5);

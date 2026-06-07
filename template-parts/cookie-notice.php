<?php

/**
 * Cookie notice banner
 *
 * @package alergobot
 */

$text = alergobot_get_option('cookie_plashka_tekst', alergobot_cookie_notice_default_text());
$button_label = alergobot_get_option('cookie_plashka_knopka', __('Хорошо', 'alergobot'));
?>
<div
	id="cookie-notice"
	class="cookie cookie--hidden"
	role="region"
	aria-label="<?php esc_attr_e('Уведомление об использовании cookie', 'alergobot'); ?>"
	aria-live="polite"
>
	<div class="cookie__text">
		<?php echo wp_kses_post($text); ?>
	</div>
	<button type="button" class="cookie__accept btn btn--primary">
		<?php echo esc_html($button_label); ?>
	</button>
</div>

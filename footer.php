<?php

/**
 * Footer
 *
 * @package alergobot
 */

$logo_footer  = alergobot_get_option('logotip');
$phones       = alergobot_get_phones();
$footer_phone = $phones[0] ?? '';
$copyright    = alergobot_get_option('kopirajt');
$policy_link  = alergobot_get_option('ssylka_na_politiku');
$link_opd     = alergobot_get_option('ssylka_opd');
$link_cookies = alergobot_get_option('ssylka_cookies');
?>
</main>
<footer class="footer">
	<div class="footer__container _container">
		<?php if ($logo_footer || $footer_phone) : ?>
			<div class="footer__brand-row">
				<?php if ($logo_footer) : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo">
						<?php
						echo alergobot_acf_image(
							$logo_footer,
							'full',
							array(
								'width'  => '141',
								'height' => '39',
							)
						);
						?>
					</a>
				<?php endif; ?>
				<?php if ($footer_phone) : ?>
					<a class="footer__phone" href="tel:+<?php echo esc_attr(alergobot_phone_clean($footer_phone)); ?>"><?php echo esc_html($footer_phone); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if (function_exists('have_rows') && have_rows('glavnoe_menyu', 'option')) : ?>
			<nav class="footer__nav" aria-label="<?php esc_attr_e('Навигация в подвале', 'alergobot'); ?>">
				<?php alergobot_render_main_menu('footer__menu', 'footer__item', 'footer__link'); ?>
			</nav>
		<?php endif; ?>

		<div class="footer__divider" aria-hidden="true"></div>
		<?php if ($policy_link || $link_opd || $link_cookies) : ?>

			<div class="footer__docs">
				<?php if ($policy_link) : ?>
					<a class="footer__doc" href="<?php echo alergobot_esc_link($policy_link); ?>"><?php esc_html_e('Политика конфиденциальности', 'alergobot'); ?></a>
				<?php endif; ?>
				<?php if ($link_opd) : ?>
					<a class="footer__doc" href="<?php echo alergobot_esc_link($link_opd); ?>"><?php esc_html_e('Согласие ОПД', 'alergobot'); ?></a>
				<?php endif; ?>
				<?php if ($link_cookies) : ?>
					<a class="footer__doc" href="<?php echo alergobot_esc_link($link_cookies); ?>"><?php esc_html_e('Согласие Cookies', 'alergobot'); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="footer__meta">
			<?php if ($copyright) : ?>
				<p class="footer__copy"><?php echo esc_html($copyright); ?></p>
			<?php endif; ?>
			<a href="https://ds-art.ru/" target="_blank" rel="noopener noreferrer" aria-label="Сайт разработан компанией DS-ART" class="footer__dev">
				<img class="footer__dev-logo" src="<?php echo esc_url(alergobot_assets_uri('img/ds-art-logo.svg')); ?>" alt="" width="26" height="22" loading="lazy" aria-hidden="true">
				<span class="footer__dev-text"><?php esc_html_e('Сайт разработан компанией DS-ART', 'alergobot'); ?></span>
			</a>
		</div>
	</div>
</footer>
</div>
<?php get_template_part('template-parts/popups'); ?>
<?php wp_footer(); ?>
</body>

</html>
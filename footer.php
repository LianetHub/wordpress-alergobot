<?php
/**
 * Footer
 *
 * @package alergobot
 */

$logo_footer  = function_exists('get_field') ? get_field('logotip_podval', 'option') : null;
$phone        = alergobot_get_option('nomer_telefona', '+7 (495) 352-87-77');
$phone_clean  = alergobot_phone_clean($phone);
$copyright    = alergobot_get_option('kopirajt', '© ' . gmdate('Y') . ' - Официальный сайт Аллергобот');
$policy_link  = alergobot_get_option('ssylka_na_politiku', home_url('/politika-konfidentsialnosti/'));
?>
	</main>
	<footer class="footer">
		<div class="footer__container _container">
			<div class="footer__brand-row">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo">
					<?php if ($logo_footer) : ?>
						<?php echo alergobot_acf_image($logo_footer, 'full', ['width' => '141', 'height' => '39']); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(alergobot_assets_uri('img/logo.png')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="141" height="39">
					<?php endif; ?>
				</a>
				<a class="footer__phone" href="tel:+<?php echo esc_attr($phone_clean); ?>"><?php echo esc_html($phone); ?></a>
			</div>

			<nav class="footer__nav" aria-label="<?php esc_attr_e('Навигация в подвале', 'alergobot'); ?>">
				<ul class="footer__menu">
					<li class="footer__item"><a class="footer__link" href="<?php echo esc_url(home_url('/katalog/')); ?>"><?php esc_html_e('Каталог', 'alergobot'); ?></a></li>
					<li class="footer__item"><a class="footer__link" href="#popup-presentation" data-fancybox data-src="#popup-presentation"><?php esc_html_e('Презентация', 'alergobot'); ?></a></li>
					<li class="footer__item"><a class="footer__link" href="<?php echo esc_url(get_post_type_archive_link('blogs') ?: home_url('/blog/')); ?>"><?php esc_html_e('Статьи', 'alergobot'); ?></a></li>
					<li class="footer__item"><a class="footer__link" href="<?php echo esc_url(home_url('/kontakty/')); ?>"><?php esc_html_e('Контакты', 'alergobot'); ?></a></li>
				</ul>
			</nav>

			<div class="footer__divider" aria-hidden="true"></div>

			<div class="footer__docs">
				<a class="footer__doc" href="<?php echo esc_url($policy_link); ?>"><?php esc_html_e('Политика конфиденциальности', 'alergobot'); ?></a>
				<a class="footer__doc" href="<?php echo esc_url(alergobot_get_option('ssylka_opd', '#')); ?>"><?php esc_html_e('Согласие ОПД', 'alergobot'); ?></a>
				<a class="footer__doc" href="<?php echo esc_url(alergobot_get_option('ssylka_cookies', '#')); ?>"><?php esc_html_e('Согласие Cookies', 'alergobot'); ?></a>
			</div>

			<div class="footer__meta">
				<p class="footer__copy"><?php echo esc_html($copyright); ?></p>
				<div class="footer__dev">
					<img class="footer__dev-logo" src="<?php echo esc_url(alergobot_assets_uri('img/ds-art-logo.png')); ?>" alt="" width="26" height="22" aria-hidden="true">
					<span class="footer__dev-text"><?php esc_html_e('Сайт разработан компанией DS-ART', 'alergobot'); ?></span>
				</div>
			</div>
		</div>
	</footer>
</div>
<?php get_template_part('template-parts/popups'); ?>
<?php wp_footer(); ?>
</body>
</html>

<?php

/**
 * Company contact cards (phones, address, legal, email).
 *
 * @package alergobot
 */

$phones = alergobot_get_phones();
$email  = alergobot_get_option('email', 'info@biofocus.ru');
$icons  = alergobot_assets_uri('img/icons.svg');
?>
<?php if ($phones) : ?>
	<article class="contacts-card contacts-card--phone" data-animate="bottom">
		<div class="contacts-card__icon" aria-hidden="true">
			<svg class="icon" width="22" height="22">
				<use href="<?php echo esc_url($icons); ?>#icon-phone"></use>
			</svg>
		</div>
		<div class="contacts-card__body">
			<?php foreach ($phones as $phone) : ?>
				<a class="contacts-card__link" href="tel:+<?php echo esc_attr(alergobot_phone_clean($phone)); ?>" itemprop="telephone"><?php echo esc_html($phone); ?></a>
			<?php endforeach; ?>
		</div>
	</article>
<?php endif; ?>

<article class="contacts-card contacts-card--address" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" data-animate="bottom">
	<meta itemprop="addressCountry" content="RU">
	<div class="contacts-card__icon" aria-hidden="true">
		<svg class="icon" width="24" height="24">
			<use href="<?php echo esc_url($icons); ?>#icon-pin"></use>
		</svg>
	</div>
	<address class="contacts-card__body">
		<?php if (alergobot_get_option('adres_indeks')) : ?>
			<span itemprop="postalCode"><?php echo esc_html(alergobot_get_option('adres_indeks')); ?></span>,
		<?php endif; ?>
		<?php if (alergobot_get_option('adres_gorod')) : ?>
			<span itemprop="addressLocality"><?php echo esc_html(alergobot_get_option('adres_gorod')); ?></span>,
		<?php endif; ?>
		<?php if (alergobot_get_option('adres_ulica')) : ?>
			<span itemprop="streetAddress"><?php echo esc_html(alergobot_get_option('adres_ulica')); ?></span>
		<?php endif; ?>
	</address>
</article>

<article class="contacts-card contacts-card--legal" data-animate="bottom">
	<div class="contacts-card__icon" aria-hidden="true">
		<svg class="icon" width="22" height="22">
			<use href="<?php echo esc_url($icons); ?>#icon-doc"></use>
		</svg>
	</div>
	<div class="contacts-card__body">
		<?php if (alergobot_get_option('kompaniya_nazvanie')) : ?>
			<span itemprop="legalName"><?php echo esc_html(alergobot_get_option('kompaniya_nazvanie')); ?></span>,<br>
		<?php endif; ?>
		<?php if (alergobot_get_option('kompaniya_inn')) : ?>
			<?php esc_html_e('ИНН:', 'alergobot'); ?> <span itemprop="taxID"><?php echo esc_html(alergobot_get_option('kompaniya_inn')); ?></span><br>
		<?php endif; ?>
		<?php if (alergobot_get_option('kompaniya_kpp')) : ?>
			<?php esc_html_e('КПП:', 'alergobot'); ?>
			<span itemprop="additionalProperty" itemscope itemtype="https://schema.org/PropertyValue">
				<meta itemprop="name" content="КПП">
				<span itemprop="value"><?php echo esc_html(alergobot_get_option('kompaniya_kpp')); ?></span>
			</span><br>
		<?php endif; ?>
		<?php if (alergobot_get_option('kompaniya_ogrn')) : ?>
			<?php esc_html_e('ОГРН:', 'alergobot'); ?> <span itemprop="identifier"><?php echo esc_html(alergobot_get_option('kompaniya_ogrn')); ?></span>
		<?php endif; ?>
	</div>
</article>

<?php if ($email) : ?>
	<article class="contacts-card contacts-card--email" data-animate="bottom">
		<div class="contacts-card__icon" aria-hidden="true">
			<svg class="icon" width="22" height="22">
				<use href="<?php echo esc_url($icons); ?>#icon-email"></use>
			</svg>
		</div>
		<p class="contacts-card__body">
			<a class="contacts-card__link" href="mailto:<?php echo esc_attr($email); ?>" itemprop="email"><?php echo esc_html($email); ?></a>
		</p>
	</article>
<?php endif; ?>
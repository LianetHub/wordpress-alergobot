<?php

/**
 * Company contact cards (phones, address, legal, email).
 *
 * @package alergobot
 */

$phones             = alergobot_get_phones();
$email              = alergobot_get_option('email');
$adres_indeks       = alergobot_get_option('adres_indeks');
$adres_gorod        = alergobot_get_option('adres_gorod');
$adres_ulica        = alergobot_get_option('adres_ulica');
$kompaniya_nazvanie = alergobot_get_option('kompaniya_nazvanie');
$kompaniya_inn      = alergobot_get_option('kompaniya_inn');
$kompaniya_kpp      = alergobot_get_option('kompaniya_kpp');
$kompaniya_ogrn     = alergobot_get_option('kompaniya_ogrn');
$icons_uri          = alergobot_assets_uri('img/icons.svg');

$has_address = $adres_indeks || $adres_gorod || $adres_ulica;
$has_legal   = $kompaniya_nazvanie || $kompaniya_inn || $kompaniya_kpp || $kompaniya_ogrn;
?>
<?php if ($phones) : ?>
	<div class="contacts-card contacts-card--phone <?php echo alergobot_anim_class('fade-up', '_anim-no-hide'); ?>">
		<div class="contacts-card__wrapper">
			<div class="contacts-card__icon" aria-hidden="true">
				<svg class="icon" width="22" height="22">
					<use href="<?php echo esc_url($icons_uri); ?>#icon-phone"></use>
				</svg>
			</div>
			<div class="contacts-card__body">
				<?php foreach ($phones as $phone) : ?>
					<a class="contacts-card__link" href="tel:+<?php echo esc_attr(alergobot_phone_clean($phone)); ?>" itemprop="telephone"><?php echo esc_html($phone); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ($has_address) : ?>
	<div class="contacts-card contacts-card--address <?php echo alergobot_anim_class('fade-up', '_anim-no-hide'); ?>" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
		<div class="contacts-card__wrapper">
			<meta itemprop="addressCountry" content="RU">
			<div class="contacts-card__icon" aria-hidden="true">
				<svg class="icon" width="22" height="22">
					<use href="<?php echo esc_url($icons_uri); ?>#icon-pin"></use>
				</svg>
			</div>
			<address class="contacts-card__body">
				<?php if ($adres_indeks) : ?>
					<span itemprop="postalCode"><?php echo esc_html($adres_indeks); ?></span>,
				<?php endif; ?>
				<?php if ($adres_gorod) : ?>
					<span itemprop="addressLocality"><?php echo esc_html($adres_gorod); ?></span>,
				<?php endif; ?>
				<?php if ($adres_ulica) : ?>
					<span itemprop="streetAddress"><?php echo esc_html($adres_ulica); ?></span>
				<?php endif; ?>
			</address>
		</div>
	</div>
<?php endif; ?>

<?php if ($email) : ?>
	<div class="contacts-card contacts-card--email <?php echo alergobot_anim_class('fade-up', '_anim-no-hide'); ?>">
		<div class="contacts-card__wrapper">
			<div class="contacts-card__icon" aria-hidden="true">
				<svg class="icon" width="22" height="22">
					<use href="<?php echo esc_url($icons_uri); ?>#icon-email"></use>
				</svg>
			</div>
			<p class="contacts-card__body">
				<a class="contacts-card__link" href="mailto:<?php echo esc_attr($email); ?>" itemprop="email"><?php echo esc_html($email); ?></a>
			</p>
		</div>
	</div>
<?php endif; ?>

<?php if ($has_legal) : ?>
	<div class="contacts-card contacts-card--legal <?php echo alergobot_anim_class('fade-up', '_anim-no-hide'); ?>">
		<div class="contacts-card__wrapper">
			<div class="contacts-card__icon" aria-hidden="true">
				<svg class="icon" width="22" height="22">
					<use href="<?php echo esc_url($icons_uri); ?>#icon-doc"></use>
				</svg>
			</div>
			<div class="contacts-card__body">
				<?php if ($kompaniya_nazvanie) : ?>
					<span itemprop="legalName"><?php echo esc_html($kompaniya_nazvanie); ?></span>,<br>
				<?php endif; ?>
				<?php if ($kompaniya_inn) : ?>
					<?php esc_html_e('ИНН:', 'alergobot'); ?> <span itemprop="taxID"><?php echo esc_html($kompaniya_inn); ?></span><br>
				<?php endif; ?>
				<?php if ($kompaniya_kpp) : ?>
					<?php esc_html_e('КПП:', 'alergobot'); ?>
					<span itemprop="additionalProperty" itemscope itemtype="https://schema.org/PropertyValue">
						<meta itemprop="name" content="КПП">
						<span itemprop="value"><?php echo esc_html($kompaniya_kpp); ?></span>
					</span><br>
				<?php endif; ?>
				<?php if ($kompaniya_ogrn) : ?>
					<?php esc_html_e('ОГРН:', 'alergobot'); ?> <span itemprop="identifier"><?php echo esc_html($kompaniya_ogrn); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
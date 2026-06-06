<?php
/**
 * Home section: contacts
 *
 * @package alergobot
 */

$company_name = alergobot_get_option('kompaniya_nazvanie', 'ООО «Био Фокус»');
$map_html     = alergobot_get_map_html('contacts-map', 'contacts__map');
$photo_path   = alergobot_home_get('photo_path');
?>
<section class="contacts" id="contacts">
	<div class="contacts__wrap">
		<div class="contacts__container _container">
			<div class="contacts__box" data-contacts="" data-decor-parallax="" itemscope itemtype="https://schema.org/Organization">
				<meta itemprop="name" content="<?php echo esc_attr($company_name); ?>">
				<link itemprop="url" href="<?php echo esc_url(home_url('/')); ?>">
				<header class="contacts__hero">
					<div class="contacts__lead">
						<?php if ($tag = alergobot_home_get('tag')) : ?>
							<span class="tag tag--white" data-animate="scale"><?php echo esc_html($tag); ?></span>
						<?php endif; ?>
						<?php if ($title = alergobot_home_get('title')) : ?>
							<h2 class="contacts__title title title-md title--light" data-animate="bottom"><?php echo esc_html($title); ?></h2>
						<?php endif; ?>
						<?php if ($text = alergobot_home_get('text')) : ?>
							<p class="contacts__text" data-animate="bottom"><?php echo esc_html($text); ?></p>
						<?php endif; ?>
					</div>
					<?php if ($photo_path) : ?>
						<figure class="contacts__figure" data-animate="bottom">
							<img class="contacts__photo" src="<?php echo esc_url(alergobot_acf_image_url($photo_path)); ?>" alt="<?php echo esc_attr(alergobot_home_get('photo_alt')); ?>" title="<?php echo esc_attr(alergobot_home_get('photo_alt')); ?>" width="387" height="261" loading="lazy">
						</figure>
					<?php endif; ?>
				</header>
				<div class="contacts__main">
					<div class="contacts__cards">
						<?php get_template_part('template-parts/company/contact', 'cards'); ?>
					</div>
					<?php if ($map_html) : ?>
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $map_html;
						?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

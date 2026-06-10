<?php
/**
 * Related blog card for article page
 *
 * @package alergobot
 */

$permalink = get_permalink();
$title     = get_the_title();
$excerpt   = get_the_excerpt();
$thumb     = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
$thumb     = $thumb ?: alergobot_assets_uri('img/article/related.jpg');
$date_iso  = get_the_date('c');
$date      = get_the_date('d.m.Y');
?>
<article class="news-card">
	<a class="news-card__link" href="<?php echo esc_url($permalink); ?>">
		<div class="news-card__media a-hover-zoom">
			<img class="news-card__img" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" width="295" height="277" loading="lazy">
		</div>
		<div class="news-card__body">
			<time class="news-card__date" datetime="<?php echo esc_attr($date_iso); ?>"><?php echo esc_html($date); ?></time>
			<div class="news-card__text">
				<h3 class="news-card__title"><?php echo esc_html($title); ?></h3>
				<?php if ($excerpt) : ?>
					<p class="news-card__excerpt"><?php echo esc_html($excerpt); ?></p>
				<?php endif; ?>
			</div>
			<span class="news-card__more">
				<span class="news-card__more-label"><?php esc_html_e('Читать статью', 'alergobot'); ?></span>
				<span class="news-card__more-icon" aria-hidden="true">
					<svg class="icon" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
					</svg>
				</span>
			</span>
		</div>
	</a>
</article>

<?php
/**
 * Blog card for loops and AJAX
 *
 * @package alergobot
 */

$permalink = get_permalink();
$title     = get_the_title();
$excerpt   = alergobot_get_blog_intro();
$thumb     = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
$thumb     = $thumb ?: alergobot_assets_uri('img/blog/card.png');
$date_iso  = get_the_date('c');
$date      = get_the_date('d.m.Y');
$badge     = alergobot_get_blog_badge_label();
?>
<article class="news-card news-card--feed">
	<a class="news-card__link" href="<?php echo esc_url($permalink); ?>">
		<div class="news-card__media">
			<img class="news-card__img" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" width="295" height="278" loading="lazy">
		</div>
		<div class="news-card__body">
			<div class="news-card__meta">
				<span class="news-card__badge"><?php echo esc_html($badge); ?></span>
				<time class="news-card__date news-card__date--pill" datetime="<?php echo esc_attr($date_iso); ?>"><?php echo esc_html($date); ?></time>
			</div>
			<div class="news-card__text">
				<h3 class="news-card__title"><?php echo esc_html($title); ?></h3>
				<?php if ($excerpt) : ?>
					<p class="news-card__excerpt"><?php echo esc_html(wp_strip_all_tags($excerpt)); ?></p>
				<?php endif; ?>
			</div>
			<span class="news-card__more">
				<span class="news-card__more-label"><?php esc_html_e('Подробнее', 'alergobot'); ?></span>
				<span class="news-card__more-icon" aria-hidden="true">
					<svg class="icon" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
						<use href="<?php echo esc_url(alergobot_assets_uri('img/icons.svg')); ?>#icon-arrow-up-right"></use>
					</svg>
				</span>
			</span>
		</div>
	</a>
</article>

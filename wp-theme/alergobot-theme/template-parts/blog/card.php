<?php
/**
 * Blog card for loops and AJAX
 *
 * @package alergobot
 */

$permalink = get_permalink();
$title     = get_the_title();
$thumb     = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
?>
<article class="news-card">
	<a class="news-card__link" href="<?php echo esc_url($permalink); ?>">
		<?php if ($thumb) : ?>
			<img class="news-card__img" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" width="373" height="247">
		<?php endif; ?>
		<time class="news-card__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d.m.Y')); ?></time>
		<h3 class="news-card__title"><?php echo esc_html($title); ?></h3>
	</a>
</article>

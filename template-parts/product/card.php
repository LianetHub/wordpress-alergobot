<?php
/**
 * Product card
 *
 * @package alergobot
 */

$permalink = get_permalink();
$title     = get_the_title();
$thumb     = get_the_post_thumbnail_url(get_the_ID(), 'medium');
?>
<article class="category__item">
	<a class="category__link" href="<?php echo esc_url($permalink); ?>">
		<?php if ($thumb) : ?>
			<img class="category__img" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" width="240" height="180">
		<?php endif; ?>
		<h3 class="category__title"><?php echo esc_html($title); ?></h3>
	</a>
</article>

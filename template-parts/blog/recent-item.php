<?php
/**
 * Blog sidebar recent item
 *
 * @package alergobot
 */

$permalink  = get_permalink();
$title      = get_the_title();
$thumb      = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
$thumb      = $thumb ?: alergobot_assets_uri('img/blog/recent-01.png');
$date_iso   = get_the_date('c');
$date_label = get_the_date('j F Y');
?>
<li class="blog-recent__item" data-animate="bottom">
	<a class="blog-recent__link" href="<?php echo esc_url($permalink); ?>">
		<img class="blog-recent__thumb" src="<?php echo esc_url($thumb); ?>" alt="" title="" width="104" height="104" loading="lazy">
		<span class="blog-recent__body">
			<span class="blog-recent__title"><?php echo esc_html($title); ?></span>
			<time class="blog-recent__date" datetime="<?php echo esc_attr($date_iso); ?>"><?php echo esc_html($date_label); ?></time>
		</span>
	</a>
</li>

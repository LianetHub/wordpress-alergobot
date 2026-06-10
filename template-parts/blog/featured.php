<?php
/**
 * Featured blog post for archive hero
 *
 * @package alergobot
 */

$permalink = get_permalink();
$title     = get_the_title();
$thumb     = get_the_post_thumbnail_url( get_the_ID(), 'large' );
$thumb     = $thumb ?: alergobot_assets_uri( 'img/blog/featured.png' );
$date_iso  = get_the_date( 'c' );
$date      = get_the_date( 'd.m.Y' );
?>
<article class="blog-featured <?php echo alergobot_anim_class( 'reveal' ); ?>">
	<a class="blog-featured__link" href="<?php echo esc_url( $permalink ); ?>">
		<div class="blog-featured__media">
			<img class="blog-featured__img" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $title ); ?>" title="<?php echo esc_attr( $title ); ?>" width="873" height="582" fetchpriority="high">
			<time class="blog-featured__date" datetime="<?php echo esc_attr( $date_iso ); ?>"><?php echo esc_html( $date ); ?></time>
			<div class="blog-featured__caption">
				<h2 class="blog-featured__title"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
	</a>
</article>

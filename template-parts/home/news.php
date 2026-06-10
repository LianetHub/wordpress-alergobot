<?php
/**
 * Home section: news
 *
 * @package alergobot
 */

$blogs_query       = alergobot_query_blogs(
	array(
		'posts_per_page' => 2,
	)
);
$blogs_archive_url = alergobot_blogs_archive_url();
$icons_svg         = alergobot_assets_uri( 'img/icons.svg' );
$thumb_fallback    = alergobot_assets_uri( 'img/blog/card.png' );
?>
<section class="news">
	<div class="news__container _container" data-decor-parallax="">
		<div class="news__head">
			<div class="news__intro">
				<?php if ( $title = alergobot_home_get( 'title' ) ) : ?>
					<h2 class="news__title title title-md <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $text = alergobot_home_get( 'text' ) ) : ?>
					<p class="news__text text-lead <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $tag = alergobot_home_get( 'tag' ) ) : ?>
				<span class="news__tag tag <?php echo alergobot_anim_class( 'bounce-up' ); ?>"><?php echo esc_html( $tag ); ?></span>
			<?php endif; ?>
		</div>
		<?php if ( $blogs_query->have_posts() ) : ?>
			<div class="news__grid <?php echo alergobot_anim_class( 'stagger' ); ?>">
				<?php
				while ( $blogs_query->have_posts() ) :
					$blogs_query->the_post();
					$post_id   = get_the_ID();
					$permalink = get_permalink();
					$title     = get_the_title();
					$excerpt   = alergobot_get_blog_intro( $post_id );
					$thumb     = get_the_post_thumbnail_url( $post_id, 'medium_large' ) ?: $thumb_fallback;
					$date_iso  = get_the_date( 'c' );
					$date      = get_the_date( 'd.m.Y' );
					?>
					<article class="news-card">
						<a class="news-card__link" href="<?php echo esc_url( $permalink ); ?>">
							<div class="news-card__media a-hover-zoom">
								<img class="news-card__img" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $title ); ?>" title="<?php echo esc_attr( $title ); ?>" width="295" height="277" loading="lazy">
							</div>
							<div class="news-card__body">
								<time class="news-card__date" datetime="<?php echo esc_attr( $date_iso ); ?>"><?php echo esc_html( $date ); ?></time>
								<div class="news-card__text">
									<h3 class="news-card__title"><?php echo esc_html( $title ); ?></h3>
									<?php if ( $excerpt ) : ?>
										<p class="news-card__excerpt"><?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?></p>
									<?php endif; ?>
								</div>
								<span class="news-card__more">
									<span class="news-card__more-label"><?php esc_html_e( 'Читать статью', 'alergobot' ); ?></span>
									<span class="news-card__more-icon" aria-hidden="true">
										<svg class="icon" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg">
											<use href="<?php echo esc_url( $icons_svg ); ?>#icon-arrow-up-right"></use>
										</svg>
									</span>
								</span>
							</div>
						</a>
					</article>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		<div class="news__footer <?php echo alergobot_anim_class( 'fade-up' ); ?>">
			<a class="btn btn--primary news__btn a-hover-lift" href="<?php echo esc_url( $blogs_archive_url ); ?>"><?php esc_html_e( 'Смотреть все материалы', 'alergobot' ); ?></a>
		</div>
	</div>
</section>

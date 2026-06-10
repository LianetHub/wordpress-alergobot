<?php
/**
 * Home section: catalog-teaser
 *
 * @package alergobot
 */

$btn_analyzers = alergobot_home_get( 'btn_analyzers' );
$btn_panels    = alergobot_home_get( 'btn_panels' );
?>
<section class="catalog-teaser">
	<div class="catalog-teaser__container _container" data-decor-parallax="">
		<div class="catalog-teaser__head">
			<?php if ( $title = alergobot_home_get( 'title' ) ) : ?>
				<h2 class="catalog-teaser__title title title-md <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $tag = alergobot_home_get( 'tag' ) ) : ?>
				<span class="catalog-teaser__tag tag <?php echo alergobot_anim_class( 'bounce-up' ); ?>"><?php echo esc_html( $tag ); ?></span>
			<?php endif; ?>
		</div>
		<div class="catalog-teaser__body">
			<div class="catalog-teaser__main">
				<?php if ( $text = alergobot_home_get( 'text' ) ) : ?>
					<p class="catalog-teaser__text text-lead <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo wp_kses_post( $text ); ?></p>
				<?php endif; ?>
				<div class="catalog-teaser__actions">
					<?php echo alergobot_anim_wrap_open( 'fade-up', '', 'fill' ); ?>
					<a class="btn btn--primary catalog-teaser__btn a-hover-lift" href="<?php echo esc_url( alergobot_acf_link_url( $btn_analyzers, alergobot_get_product_category_link( 'analizatory' ) ) ); ?>">
						<?php echo esc_html( alergobot_acf_link_title( $btn_analyzers, __( 'Смотреть анализаторы', 'alergobot' ) ) ); ?>
						<svg class="btn__icon icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-up-right"></use>
						</svg>
					</a>
					<?php echo alergobot_anim_wrap_close(); ?>
					<?php echo alergobot_anim_wrap_open( 'fade-up', '', 'fill' ); ?>
					<a class="btn btn--secondary catalog-teaser__btn" href="<?php echo esc_url( alergobot_acf_link_url( $btn_panels, alergobot_catalog_url() . '#catalog-reagents' ) ); ?>">
						<?php echo esc_html( alergobot_acf_link_title( $btn_panels, __( 'смотреть панели', 'alergobot' ) ) ); ?>
						<svg class="btn__icon icon" width="28" height="28" aria-hidden="true">
							<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-up-right"></use>
						</svg>
					</a>
					<?php echo alergobot_anim_wrap_close(); ?>
				</div>
			</div>
			<?php if ( alergobot_home_rows( 'gallery' ) ) : ?>
				<ul class="catalog-teaser__gallery">
					<?php
					foreach ( alergobot_home_rows( 'gallery' ) as $item ) :
						$gallery_item = alergobot_resolve_catalog_teaser_gallery_item( $item );
						if ( ! $gallery_item ) {
							continue;
						}
						?>
						<li class="catalog-teaser__gallery-item <?php echo alergobot_anim_class( 'reveal-circle' ); ?>">
							<a class="catalog-teaser__card a-hover-lift a-hover-zoom" href="<?php echo esc_url( $gallery_item['link_url'] ); ?>">
								<img
									class="cover-image"
									src="<?php echo esc_url( $gallery_item['img_url'] ); ?>"
									alt="<?php echo esc_attr( $gallery_item['img_alt'] ); ?>"
									title="<?php echo esc_attr( $gallery_item['img_alt'] ); ?>"
									<?php
									if ( $gallery_item['img_w'] ) :
										?>
										width="<?php echo esc_attr( (string) $gallery_item['img_w'] ); ?>"<?php endif; ?>
									<?php
									if ( $gallery_item['img_h'] ) :
										?>
										height="<?php echo esc_attr( (string) $gallery_item['img_h'] ); ?>"<?php endif; ?>
									loading="lazy"
								>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
/**
 * Home section: choose
 *
 * @package alergobot
 */

?>
<section class="choose">
	<div class="choose__container _container">
		<div class="choose__head">
			<div class="choose__head-main">
				<?php if ( $tag = alergobot_home_get( 'tag' ) ) : ?>
					<span class="tag tag--white choose__tag <?php echo alergobot_anim_class( 'scale-up' ); ?>"><?php echo esc_html( $tag ); ?></span>
				<?php endif; ?>
				<?php if ( $title = alergobot_home_get( 'title' ) ) : ?>
					<h2 class="choose__title title title-md title--light <?php echo alergobot_anim_class( 'blur-up' ); ?>"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $lead = alergobot_home_get( 'lead' ) ) : ?>
					<p class="choose__lead text-lead text-lead--light <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $note = alergobot_home_get( 'note' ) ) : ?>
				<p class="choose__note <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $note ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( alergobot_home_rows( 'slides' ) ) : ?>
			<div class="choose__slider swiper <?php echo alergobot_anim_class( 'reveal' ); ?>">
				<div class="swiper-wrapper">
					<?php foreach ( alergobot_home_rows( 'slides' ) as $slide ) : ?>
						<article class="swiper-slide choose__card">
							<div class="choose__card-text">
								<h3 class="choose__card-title"><?php echo esc_html( $slide['title'] ?? '' ); ?></h3>
								<p class="choose__card-desc"><?php echo esc_html( $slide['desc'] ?? '' ); ?></p>
							</div>
							<?php if ( ! empty( $slide['image'] ) ) : ?>
								<div class="choose__card-media">
									<?php
									echo alergobot_acf_image(
										$slide['image'],
										'full',
										array(
											'class'   => 'cover-image',
											'width'   => '214',
											'height'  => '256',
											'loading' => 'lazy',
										)
									);
									?>
								</div>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="choose__footer <?php echo alergobot_anim_class( 'fade-up' ); ?>">
			<div class="choose__nav">
				<button class="choose__arrow choose__arrow--prev <?php echo alergobot_anim_class( 'scale-up' ); ?>" type="button" aria-label="<?php esc_attr_e( 'Назад', 'alergobot' ); ?>">
					<svg width="32" height="32" aria-hidden="true">
						<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-chevron"></use>
					</svg>
				</button>
				<button class="choose__arrow choose__arrow--next <?php echo alergobot_anim_class( 'scale-up' ); ?>" type="button" aria-label="<?php esc_attr_e( 'Вперёд', 'alergobot' ); ?>">
					<svg width="32" height="32" aria-hidden="true">
						<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-chevron"></use>
					</svg>
				</button>
			</div>
			<button class="choose__btn btn btn--white a-hover-lift" type="button" data-fancybox="" data-src="#popup-consultation"><?php echo esc_html( alergobot_home_get( 'consult_btn_label', __( 'Получить консультацию', 'alergobot' ) ) ); ?></button>
		</div>
	</div>
</section>

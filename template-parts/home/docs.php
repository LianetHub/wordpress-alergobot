<?php
/**
 * Home section: docs
 *
 * @package alergobot
 */

?>
<section class="docs">
	<div class="docs__container _container">
		<div class="docs__head">
			<div class="docs__intro">
				<?php if ( $title = alergobot_home_get( 'title' ) ) : ?>
					<h2 class="docs__title title title-md <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $text = alergobot_home_get( 'text' ) ) : ?>
					<p class="docs__text text-lead <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
			</div>
			<div class="docs__nav">
				<button class="docs__arrow docs__arrow--prev <?php echo alergobot_anim_class( 'scale-up' ); ?>" type="button" aria-label="<?php esc_attr_e( 'Назад', 'alergobot' ); ?>">
					<svg class="docs__arrow-icon icon" width="32" height="32" aria-hidden="true">
						<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-chevron"></use>
					</svg>
				</button>
				<button class="docs__arrow docs__arrow--next <?php echo alergobot_anim_class( 'scale-up' ); ?>" type="button" aria-label="<?php esc_attr_e( 'Вперёд', 'alergobot' ); ?>">
					<svg class="docs__arrow-icon icon" width="32" height="32" aria-hidden="true">
						<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-chevron"></use>
					</svg>
				</button>
			</div>
		</div>
		<?php
		$docs_items = function_exists( 'get_sub_field' ) ? get_sub_field( 'items' ) : array();
		if ( ! is_array( $docs_items ) ) {
			$docs_items = array();
		}
		?>
		<?php if ( $docs_items ) : ?>
			<div class="docs__slider swiper <?php echo alergobot_anim_class( 'reveal' ); ?>">
				<div class="swiper-wrapper">
					<?php
					foreach ( $docs_items as $doc ) :
						$image = $doc['image'] ?? null;
						if ( empty( $image ) ) {
							continue;
						}
						$image_url = alergobot_acf_image_url( $image );
						?>
						<div class="swiper-slide docs__slide">
							<a href="<?php echo esc_url( $image_url ); ?>" data-fancybox="docs" class="docs__card">
								<div class="docs__media">
									<?php
									echo alergobot_acf_image(
										$image,
										'full',
										array(
											'class'   => 'cover-image',
											'width'   => '276',
											'height'  => '395',
											'loading' => 'lazy',
										)
									);
									?>
								</div>
								<p class="docs__caption"><?php echo esc_html( $doc['caption'] ?? '' ); ?></p>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="docs__slider-pagination swiper-pagination"></div>
			</div>
		<?php endif; ?>
	</div>
</section>

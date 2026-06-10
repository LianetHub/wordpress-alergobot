<?php
/**
 * Home section: panels
 *
 * @package alergobot
 */

?>
<section class="panels">
	<div class="panels__container _container">
		<div class="panels__head">
			<div class="panels__intro">
				<?php if ( $title = alergobot_home_get( 'title' ) ) : ?>
					<h2 class="panels__title title title-md title-md--panels <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo wp_kses_post( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $lead = alergobot_home_get( 'lead' ) ) : ?>
					<p class="panels__lead text-lead <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $tag = alergobot_home_get( 'tag' ) ) : ?>
				<span class="panels__tag tag <?php echo alergobot_anim_class( 'bounce-up' ); ?>"><?php echo esc_html( $tag ); ?></span>
			<?php endif; ?>
		</div>
		<?php if ( alergobot_home_rows( 'items' ) ) : ?>
			<ul class="panels__list <?php echo alergobot_anim_class( 'stagger-x' ); ?>" data-panels="">
				<?php
				foreach ( alergobot_home_rows( 'items' ) as $item ) :
					$is_open = ! empty( $item['is_open'] );
					$link    = $item['link'] ?? array();
					?>
					<li class="panels__item<?php echo $is_open ? ' _active' : ''; ?>">
						<button class="panels__heading" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
							<span class="panels__name"><?php echo esc_html( $item['name'] ?? '' ); ?></span>
							<svg class="panels__chevron icon" width="32" height="32" aria-hidden="true">
								<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-panels-chevron"></use>
							</svg>
						</button>
						<div class="panels__body">
							<div class="panels__inner">
								<div class="panels__content">
									<?php if ( ! empty( $item['description'] ) ) : ?>
										<div class="panels__desc"><?php echo wp_kses_post( $item['description'] ); ?></div>
									<?php endif; ?>
									<?php if ( ! empty( $item['image'] ) ) : ?>
										<?php
										echo alergobot_acf_image(
											$item['image'],
											'full',
											array(
												'class'   => 'panels__img',
												'width'   => '267',
												'height'  => '144',
												'loading' => 'lazy',
											)
										);
										?>
									<?php endif; ?>
									<a class="btn btn--secondary panels__more" href="<?php echo esc_url( alergobot_acf_link_url( $link, alergobot_catalog_url() ) ); ?>">
										<?php echo esc_html( alergobot_acf_link_title( $link, __( 'Подробнее', 'alergobot' ) ) ); ?>
										<svg class="btn__icon icon" width="28" height="28" aria-hidden="true">
											<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-up-right"></use>
										</svg>
									</a>
								</div>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="panels__footer <?php echo alergobot_anim_class( 'fade-up' ); ?>">
			<a class="btn btn--primary panels__footer-btn a-hover-lift" href="<?php echo esc_url( alergobot_catalog_url() ); ?>"><?php esc_html_e( 'Перейти в каталог', 'alergobot' ); ?></a>
		</div>
	</div>
</section>

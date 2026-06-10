<?php
/**
 * Home section: equipment
 *
 * @package alergobot
 */

$footer_btn = alergobot_home_get( 'footer_btn' );
?>
<section class="equipment">
	<div class="equipment__container _container" data-decor-parallax="">
		<div class="equipment__head">
			<div class="equipment__intro">
				<?php if ( $title = alergobot_home_get( 'title' ) ) : ?>
					<h2 class="equipment__title title title-md <?php echo alergobot_anim_class( 'fade-left' ); ?>"><?php echo wp_kses_post( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $lead = alergobot_home_get( 'lead' ) ) : ?>
					<p class="equipment__lead text-lead <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $tag = alergobot_home_get( 'tag' ) ) : ?>
				<span class="tag equipment__tag <?php echo alergobot_anim_class( 'bounce-up' ); ?>"><?php echo esc_html( $tag ); ?></span>
			<?php endif; ?>
		</div>
		<?php if ( alergobot_home_rows( 'items' ) ) : ?>
			<ul class="equipment__grid <?php echo alergobot_anim_class( 'stagger' ); ?>">
				<?php
				foreach ( alergobot_home_rows( 'items' ) as $item ) :
					$link       = $item['link'] ?? array();
					$name       = (string) ( $item['name'] ?? '' );
					$name_class = mb_strlen( $name ) > 35 ? 'equipment__card-name--long' : '';
					?>
					<li class="equipment__card">
						<a class="equipment__card-link" href="<?php echo esc_url( alergobot_acf_link_url( $link, '#' ) ); ?>">
							<h3 class="equipment__card-name<?php echo $name_class ? ' ' . esc_attr( $name_class ) : ''; ?>"><?php echo esc_html( $name ); ?></h3>
							<?php if ( ! empty( $item['image'] ) ) : ?>
								<div class="equipment__card-media a-hover-zoom">
									<?php
									echo alergobot_acf_image(
										$item['image'],
										'full',
										array(
											'class'   => 'cover-image',
											'loading' => 'lazy',
										)
									);
									?>
								</div>
							<?php endif; ?>
							<p class="equipment__card-text"><?php echo esc_html( $item['text'] ?? '' ); ?></p>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="equipment__footer <?php echo alergobot_anim_class( 'fade-up' ); ?>">
			<a class="btn btn--primary equipment__btn a-hover-lift" href="<?php echo esc_url( alergobot_acf_link_url( $footer_btn, alergobot_catalog_url() ) ); ?>"><?php echo esc_html( alergobot_acf_link_title( $footer_btn, __( 'Подобрать оборудование', 'alergobot' ) ) ); ?></a>
		</div>
	</div>
</section>

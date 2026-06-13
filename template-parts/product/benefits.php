<?php
/**
 * Product benefits section
 *
 * @package alergobot
 */

$post_id = get_the_ID();
$icons   = alergobot_assets_uri( 'img/icons.svg' );

$benefits_text  = alergobot_get_post_field( 'product_benefits_text', $post_id );
$benefits_cards = alergobot_get_post_field( 'product_benefits_cards', $post_id ) ?: array();

if ( ! $benefits_text && ! $benefits_cards ) {
	return;
}

?>
<section class="benefits">
	<div class="benefits__container _container">
		<header class="benefits__head">
			<h2 class="benefits__title title title-md <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php esc_html_e( 'Преимущества решений PROTIA', 'alergobot' ); ?></h2>
		</header>
		<div class="benefits__body">
			<?php if ( $benefits_text ) : ?>
				<div class="benefits__brand">
					<div class="benefits__text <?php echo alergobot_anim_class( 'fade-left' ); ?>">
						<?php echo wp_kses_post( $benefits_text ); ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( $benefits_cards ) : ?>
				<ul class="benefits__grid <?php echo alergobot_anim_class( 'stagger' ); ?>">
					<?php
					$card_number = 0; foreach ( $benefits_cards as $card ) :
						$title   = $card['title'] ?? '';
						$tooltip = $card['tooltip'] ?? '';
						if ( ! $title ) {
							continue;
						}
						++$card_number;
						?>
						<li class="benefits__card">
							<div class="benefits__card-wrapper">
								<div class="benefits__card-head">
									<span class="benefits__num"><?php echo esc_html( (string) $card_number ); ?></span>
									<?php if ( $tooltip ) : ?>
										<button class="benefits__info tooltip-trigger" type="button" data-tooltip="<?php echo esc_attr( $tooltip ); ?>" aria-label="
										<?php
										/* translators: %s: benefit card title */
										echo esc_attr( sprintf( __( 'Подробнее: %s', 'alergobot' ), $title ) );
										?>
										" aria-expanded="false">
											<svg class="icon benefits__info-icon" aria-hidden="true">
												<use href="<?php echo esc_url( $icons ); ?>#icon-eye-info"></use>
											</svg>
										</button>
									<?php endif; ?>
								</div>
								<h3 class="benefits__card-title"><?php echo esc_html( $title ); ?></h3>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>

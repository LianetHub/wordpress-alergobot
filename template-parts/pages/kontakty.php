<?php
/**
 * Page template: kontakty
 *
 * @package alergobot
 */

$page_id          = get_the_ID();
$heading_products = function_exists( 'get_field' ) ? (array) get_field( 'contacts_heading_products', $page_id ) : array();

?>

<section class="heading heading--contacts">
	<div class="heading__container _container">
		<div class="heading__grid">
			<div class="heading__main">
				<h1 class="heading__title title title-lg <?php echo alergobot_anim_class( 'blur-up', '_anim-no-hide' ); ?>">Закажите&nbsp;оборудование для диагностики аллергии</h1>
				<p class="heading__text heading__text--main <?php echo alergobot_anim_class( 'fade-up', '_anim-no-hide' ); ?>">Закажите современное оборудование для аллергодиагностики быстро и без лишних хлопот. Заполните форму, и наш менеджер подберет оптимальное решение под ваши задачи и пришлет полный прайс‑лист.</p>
			</div>
			<?php if ( $heading_products ) : ?>
				<div class="heading__aside">
					<div class="heading__products">
						<?php foreach ( $heading_products as $product ) : ?>
							<?php
							$image = $product['image'] ?? null;
							if ( ! $image ) {
								continue;
							}
							?>
							<div class="heading__product <?php echo alergobot_anim_class( 'zoom', '_anim-no-hide' ); ?>">
								<?php
								echo alergobot_acf_image(
									$image,
									'full',
									array(
										'class'         => 'cover-image',
										'width'         => '800',
										'height'        => '600',
										'fetchpriority' => 'high',
										'loading'       => 'eager',
									)
								);
								?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<section class="contacts-order">
	<div class="contacts-order__container _container">
		<div class="contacts-order__grid">
			<div class="contacts-order__form <?php echo alergobot_anim_class( 'fade-up' ); ?>">
				<?php alergobot_cf7_form( 'cf7_zakaz', __( 'Контакты', 'alergobot' ) ); ?>
			</div>
			<?php
			$map_html = alergobot_get_map_html();
			if ( $map_html ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $map_html;
			}
			?>
		</div>
	</div>
</section>
<?php get_template_part( 'template-parts/company/contacts', 'info' ); ?>

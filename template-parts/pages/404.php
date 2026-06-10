<?php
/**
 * Page template: 404
 *
 * @package alergobot
 */

$title    = alergobot_get_option( '404_title', __( 'Такой страницы не существует', 'alergobot' ) );
$subtitle = alergobot_get_option( '404_subtitle', __( 'Воспользуйтесь меню, чтобы перейти на другие страницы', 'alergobot' ) );
?>
<section class="not-found">
	<div class="not-found__container _container">
		<div class="not-found__head">
			<?php if ( $title ) : ?>
				<h1 class="not-found__title title title-md <?php echo alergobot_anim_class( 'blur-up', '_anim-no-hide' ); ?>"><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>
			<?php if ( $subtitle ) : ?>
				<p class="not-found__text text-lead <?php echo alergobot_anim_class( 'fade-up', '_anim-no-hide' ); ?>"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>
		<div class="not-found__visual <?php echo alergobot_anim_class( 'reveal', '_anim-no-hide' ); ?>" aria-hidden="true">
			<img src="<?php echo esc_url( alergobot_assets_uri( 'img/404.png' ) ); ?>" alt="" title="" width="703" height="383" fetchpriority="high">
		</div>
		<div class="not-found__actions <?php echo alergobot_anim_class( 'fade-up', '_anim-no-hide' ); ?>">
			<a class="btn btn--primary not-found__btn a-hover-lift" href="<?php echo esc_url( home_url( '/' ) ); ?>"> Вернуться на главную <svg class="btn__icon" width="28" height="28" aria-hidden="true">
					<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-up-right"></use>
				</svg>
			</a>
			<a class="btn btn--secondary not-found__btn" href="<?php echo esc_url( alergobot_catalog_url() ); ?>"> Смотреть каталог <svg class="btn__icon" width="28" height="28" aria-hidden="true">
					<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-arrow-up-right"></use>
				</svg>
			</a>
		</div>
	</div>
</section>

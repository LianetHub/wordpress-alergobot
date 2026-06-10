<?php
/**
 * Contacts info section (kontakty page).
 *
 * @package alergobot
 */

$title = alergobot_get_option( 'kontakty_zagolovok', __( 'Контакты для связи', 'alergobot' ) );
$text  = alergobot_get_option( 'kontakty_tekst', '' );
?>
<section class="contacts-info">
	<div class="contacts-info__container _container">
		<div class="contacts-info__body" data-decor-parallax="">
			<div class="contacts-info__head">
				<?php if ( $title ) : ?>
					<h2 class="contacts-info__title title title-md <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $text ) : ?>
					<p class="contacts-info__text <?php echo alergobot_anim_class( 'fade-up' ); ?>"><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
			</div>

			<div class="contacts-info__cards <?php echo alergobot_anim_class( 'stagger-x' ); ?>">
				<?php get_template_part( 'template-parts/company/contact', 'cards' ); ?>
			</div>

		</div>
	</div>
</section>

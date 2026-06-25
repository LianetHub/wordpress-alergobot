<?php
/**
 * Fixed partners popup trigger
 *
 * @package alergobot
 */

$partners = alergobot_get_partners();

if ( ! $partners ) {
	return;
}

$has_visible = false;

foreach ( $partners as $partner ) {
	if ( get_post_thumbnail_id( $partner ) ) {
		$has_visible = true;
		break;
	}
}

if ( ! $has_visible ) {
	return;
}

$label = alergobot_get_option( 'popup_partners_widget_label' ) ?: __( 'Партнёры', 'alergobot' );
?>
<button
	type="button"
	class="partners-widget"
	data-fancybox
	data-src="#popup-partners"
	aria-label="<?php echo esc_attr( $label ); ?>"
>
	<svg class="partners-widget__icon icon" width="24" height="24" aria-hidden="true">
		<use href="<?php echo esc_url( alergobot_assets_uri( 'img/icons.svg' ) ); ?>#icon-hero-microscope"></use>
	</svg>
	<span class="partners-widget__text"><?php echo esc_html( $label ); ?></span>
</button>

<?php
/**
 * Product video tab
 *
 * @package alergobot
 */

$post_id = get_the_ID();
$icons   = alergobot_assets_uri( 'img/icons.svg' );

$poster = alergobot_get_post_field( 'product_video_poster', $post_id );
$video  = (string) alergobot_get_post_field( 'product_video_url', $post_id );

if ( ! $poster && ! $video ) {
	return;
}

$is_active = (bool) get_query_var( 'product_tab_active' );

$poster_url = alergobot_acf_image_url( $poster );
if ( ! $poster_url ) {
	return;
}

$poster_alt  = is_array( $poster ) ? ( $poster['alt'] ?? '' ) : '';
$video_label = sprintf(
	/* translators: %s: product title */
	__( 'Воспроизвести видео о %s', 'alergobot' ),
	get_the_title( $post_id )
);

?>
<div class="product-panel<?php echo $is_active ? ' _active' : ''; ?>" id="product-panel-video" role="tabpanel" aria-labelledby="product-tab-video" data-product-panel="video"<?php echo $is_active ? '' : ' hidden=""'; ?>>
	<div class="product-panel__inner product-panel__inner--video">
		<?php if ( $video ) : ?>
			<a class="product-video <?php echo alergobot_anim_class( 'zoom' ); ?>" href="<?php echo esc_url( $video ); ?>" data-fancybox="" data-type="iframe" aria-label="<?php echo esc_attr( $video_label ); ?>">
				<img class="product-video__poster" src="<?php echo esc_url( $poster_url ); ?>" alt="<?php echo esc_attr( $poster_alt ); ?>" title="<?php echo esc_attr( $poster_alt ); ?>" width="874" height="492" loading="lazy">
				<span class="product-video__play" aria-hidden="true">
					<svg class="icon" width="88" height="88" viewBox="0 0 88 88" xmlns="http://www.w3.org/2000/svg">
						<use href="<?php echo esc_url( $icons ); ?>#icon-play"></use>
					</svg>
				</span>
			</a>
		<?php else : ?>
			<button class="product-video <?php echo alergobot_anim_class( 'zoom' ); ?>" type="button" aria-label="<?php echo esc_attr( $video_label ); ?>">
				<img class="product-video__poster" src="<?php echo esc_url( $poster_url ); ?>" alt="<?php echo esc_attr( $poster_alt ); ?>" title="<?php echo esc_attr( $poster_alt ); ?>" width="874" height="492" loading="lazy">
				<span class="product-video__play" aria-hidden="true">
					<svg class="icon" width="88" height="88" viewBox="0 0 88 88" xmlns="http://www.w3.org/2000/svg">
						<use href="<?php echo esc_url( $icons ); ?>#icon-play"></use>
					</svg>
				</span>
			</button>
		<?php endif; ?>
	</div>
</div>

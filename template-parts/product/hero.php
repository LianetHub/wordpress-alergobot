<?php
/**
 * Product hero section
 *
 * @package alergobot
 */

$post_id = get_the_ID();
$icons   = alergobot_assets_uri( 'img/icons.svg' );

$hero_text = (string) alergobot_get_post_field( 'product_hero_text', $post_id );
$hero_url  = get_the_post_thumbnail_url( $post_id, 'full' ) ?: '';
$hero_alt  = wp_strip_all_tags( get_the_title( $post_id ) );

$in_stock = alergobot_get_post_field( 'product_in_stock', $post_id );
$rating   = (string) alergobot_get_post_field( 'product_rating', $post_id );

?>
<section class="product-hero">
	<div class="product-hero__container _container">
		<div class="product-hero__card">
			<div class="product-hero__content">
				<h1 class="product-hero__title title title-lg title--light <?php echo alergobot_anim_class( 'blur-up', '_anim-no-hide' ); ?>"><?php the_title(); ?></h1>
				<?php if ( $hero_text ) : ?>
					<p class="product-hero__text <?php echo alergobot_anim_class( 'fade-up', '_anim-no-hide' ); ?>"><?php echo esc_html( $hero_text ); ?></p>
				<?php endif; ?>
				<?php echo alergobot_anim_wrap_open( 'fade-up', '_anim-no-hide', 'fill' ); ?>
				<button class="product-hero__order btn btn--white a-hover-lift" type="button" data-fancybox="" data-src="#popup-order">
					<?php esc_html_e( 'заказать', 'alergobot' ); ?>
					<svg class="btn__icon" width="28" height="28" aria-hidden="true">
						<use href="<?php echo esc_url( $icons ); ?>#icon-arrow-up-right"></use>
					</svg>
				</button>
				<?php echo alergobot_anim_wrap_close(); ?>
			</div>
			<?php if ( $hero_url ) : ?>
				<div class="product-hero__visual <?php echo alergobot_anim_class( 'reveal', '_anim-no-hide' ); ?>">
					<div class="product-hero__media">
						<svg class="product-hero__media-defs" aria-hidden="true" focusable="false">
							<defs>
								<clipPath id="product-hero-media-clip" clipPathUnits="objectBoundingBox">
									<path d="M0.699013 0.105381C0.699013 0.117764 0.706377 0.127803 0.715461 0.127803H0.983553C0.992637 0.127803 1 0.137841 1 0.150224V0.977578C1 0.989962 0.992637 1 0.983553 1H0.016447C0.007364 1 0 0.989962 0 0.977578V0.022422C0 0.010038 0.007364 0 0.016447 0H0.682566C0.69165 0 0.699013 0.010038 0.699013 0.022422V0.105381Z"></path>
								</clipPath>
								<clipPath id="product-hero-media-clip-mobile" clipPathUnits="objectBoundingBox">
									<path d="M0.666667 0.0990566C0.666667 0.125108 0.68159 0.146226 0.7 0.146226H0.966667C0.985077 0.146226 1 0.167453 1 0.193396V0.95283C1 0.978774 0.985077 1 0.966667 1H0.033333C0.014923 1 0 0.978774 0 0.95283V0.0471698C0 0.0212264 0.014923 0 0.033333 0H0.633333C0.651743 0 0.666667 0.0212264 0.666667 0.0471698V0.0990566Z"></path>
								</clipPath>
							</defs>
						</svg>
						<svg class="product-hero__media-shape product-hero__media-shape--desktop" viewBox="0 0 608 446" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
							<defs>
								<mask id="product-hero-media-border-mask" fill="white">
									<path d="M425 47C425 52.5228 429.477 57 435 57H598C603.523 57 608 61.4772 608 67V436C608 441.523 603.523 446 598 446H10C4.47715 446 0 441.523 0 436V10C3.41467e-06 4.47716 4.47715 1.93278e-07 10 0H415C420.523 0 425 4.47715 425 10V47Z"></path>
								</mask>
							</defs>
							<path d="M425 47C425 52.5228 429.477 57 435 57H598C603.523 57 608 61.4772 608 67V436C608 441.523 603.523 446 598 446H10C4.47715 446 0 441.523 0 436V10C3.41467e-06 4.47716 4.47715 1.93278e-07 10 0H415C420.523 0 425 4.47715 425 10V47Z" fill="#EDFBFF"></path>
							<path d="M608 436H609V436H608ZM598 446V447V447V446ZM0 10L-1 10V10H0ZM10 0V-1V-1V0ZM425 47H424C424 53.0751 428.925 58 435 58V57V56C430.029 56 426 51.9706 426 47H425ZM435 57V58H598V57V56H435V57ZM608 67H607V436H608H609V67H608ZM608 436H607C607 440.971 602.971 445 598 445V446V447C604.075 447 609 442.075 609 436H608ZM598 446V445H10V446V447H598V446ZM10 446V445C5.02944 445 1 440.971 1 436H0H-1C-1 442.075 3.92487 447 10 447V446ZM0 436H1V10H0H-1V436H0ZM0 10L1 10C1 5.02944 5.02944 1 10 1V0V-1C3.92487 -1 -0.999996 3.92487 -1 10L0 10ZM10 0V1H415V0V-1H10V0ZM425 10H424V47H425H426V10H425ZM415 0V1C419.971 1 424 5.02944 424 10H425H426C426 3.92487 421.075 -1 415 -1V0ZM598 57V58C602.971 58 607 62.0294 607 67H608H609C609 60.9249 604.075 56 598 56V57Z" fill="#55ACBF" mask="url(#product-hero-media-border-mask)"></path>
						</svg>
						<svg class="product-hero__media-shape product-hero__media-shape--mobile" viewBox="0 0 300 212" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
							<defs>
								<mask id="product-hero-media-border-mask-mobile" fill="white">
									<path d="M200 21C200 26.5228 204.477 31 210 31H290C295.523 31 300 35.4772 300 41V202C300 207.523 295.523 212 290 212H10C4.47716 212 0 207.523 0 202V10C0 4.47715 4.47715 0 10 0H190C195.523 0 200 4.47715 200 10V21Z"></path>
								</mask>
							</defs>
							<path d="M200 21C200 26.5228 204.477 31 210 31H290C295.523 31 300 35.4772 300 41V202C300 207.523 295.523 212 290 212H10C4.47716 212 0 207.523 0 202V10C0 4.47715 4.47715 0 10 0H190C195.523 0 200 4.47715 200 10V21Z" fill="#EDFBFF"></path>
							<path d="M210 31V31.4753V31.4753V31ZM290 212V212.475V212.475V212ZM10 212V212.475V212.475V212ZM0 202H-0.475329V202H0ZM10 0V-0.475329V-0.475329V0ZM200 21H199.525C199.525 26.7854 204.215 31.4753 210 31.4753V31V30.5247C204.74 30.5247 200.475 26.2603 200.475 21H200ZM210 31V31.4753H290V31V30.5247H210V31ZM300 41H299.525V202H300H300.475V41H300ZM300 202H299.525C299.525 207.26 295.26 211.525 290 211.525V212V212.475C295.785 212.475 300.475 207.785 300.475 202H300ZM290 212V211.525H10V212V212.475H290V212ZM10 212V211.525C4.73967 211.525 0.475329 207.26 0.475329 202H0H-0.475329C-0.475329 207.785 4.21464 212.475 10 212.475V212ZM0 202H0.475329V10H0H-0.475329V202H0ZM0 10H0.475329C0.475329 4.73967 4.73967 0.475329 10 0.475329V0V-0.475329C4.21464 -0.475329 -0.475329 4.21464 -0.475329 10H0ZM10 0V0.475329H190V0V-0.475329H10V0ZM200 10H199.525V21H200H200.475V10H200ZM190 0V0.475329C195.26 0.475329 199.525 4.73967 199.525 10H200H200.475C200.475 4.21464 195.785 -0.475329 190 -0.475329V0ZM290 31V31.4753C295.26 31.4753 299.525 35.7397 299.525 41H300H300.475C300.475 35.2146 295.785 30.5247 290 30.5247V31Z" fill="#55ACBF" mask="url(#product-hero-media-border-mask-mobile)"></path>
						</svg>
						<?php if ( true === $in_stock ) : ?>
							<span class="product-hero__stock <?php echo alergobot_anim_class( 'bounce-up', '_anim-no-hide' ); ?>"><?php esc_html_e( 'В наличии', 'alergobot' ); ?></span>
						<?php endif; ?>
						<?php if ( $rating ) : ?>
							<div class="product-hero__rating <?php echo alergobot_anim_class( 'scale-up', '_anim-no-hide' ); ?>">
								<span class="product-hero__rating-label"><?php esc_html_e( 'рейтинг', 'alergobot' ); ?></span>
								<span class="product-hero__rating-value">
									<svg class="icon product-hero__rating-star" aria-hidden="true">
										<use href="<?php echo esc_url( $icons ); ?>#icon-star"></use>
									</svg>
									<?php echo esc_html( $rating ); ?>
								</span>
							</div>
						<?php endif; ?>
						<div class="product-hero__media-inner">
							<img src="<?php echo esc_url( $hero_url ); ?>" alt="<?php echo esc_attr( $hero_alt ); ?>" title="<?php echo esc_attr( $hero_alt ); ?>" width="451" height="308" fetchpriority="high">
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

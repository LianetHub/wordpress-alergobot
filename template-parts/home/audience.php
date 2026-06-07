<?php
/**
 * Home section: audience
 *
 * @package alergobot
 */

$head_photo = function_exists('get_sub_field') ? get_sub_field('photo_lab') : null;
$head_alt   = is_array($head_photo) ? ($head_photo['alt'] ?? '') : '';
$molecules  = alergobot_home_get('photo');
$cards_raw  = function_exists('get_sub_field') ? get_sub_field('cards') : [];
$cards      = is_array($cards_raw) && $cards_raw !== [] ? array_values($cards_raw) : [];
?>
<section class="audience">
	<div class="audience__container _container">
		<div class="audience__head">
			<div class="audience__intro">
				<?php if ($title = alergobot_home_get('title')) : ?>
					<h2 class="section-head__title title title-md" data-animate="bottom"><?php echo wp_kses_post($title); ?></h2>
				<?php endif; ?>
				<?php if ($text = alergobot_home_get('text')) : ?>
					<p class="section-head__text text-lead" data-animate="bottom"><?php echo esc_html($text); ?></p>
				<?php endif; ?>
			</div>
			<?php if ($head_photo) : ?>
				<div class="audience__photo" data-animate="bottom">
					<?php echo alergobot_acf_image($head_photo, 'full', [
						'class'   => 'cover-image',
						'alt'     => $head_alt,
						'title'   => $head_alt,
						'width'   => '427',
						'height'  => '212',
						'loading' => 'lazy',
					]); ?>
				</div>
			<?php endif; ?>
			<?php if ($tag = alergobot_home_get('tag')) : ?>
				<span class="audience__tag tag" data-animate="bottom"><?php echo esc_html($tag); ?></span>
			<?php endif; ?>
		</div>
		<div class="audience__scene" data-audience>
			<?php if ($molecules) : ?>
				<?php echo alergobot_acf_image($molecules, 'full', [
					'class'       => 'audience__molecules',
					'width'       => '529',
					'height'      => '477',
					'loading'     => 'lazy',
					'aria-hidden' => 'true',
				]); ?>
			<?php endif; ?>
			<?php if ($cards) : ?>
				<div class="audience__cards">
					<?php foreach ($cards as $card) :
						$is_active = !empty($card['is_active']);
						?>
						<button class="audience__card<?php echo $is_active ? ' _active' : ''; ?>" type="button" data-audience-card aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>" data-animate="scale">
							<span class="audience__card-title"><?php echo esc_html($card['title'] ?? ''); ?></span>
							<span class="audience__toggle" aria-hidden="true"></span>
							<span class="audience__card-text"><?php echo esc_html($card['text'] ?? ''); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

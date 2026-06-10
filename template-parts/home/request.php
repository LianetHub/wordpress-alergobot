<?php

/**
 * Home section: request
 *
 * @package alergobot
 */

?>
<section class="request" id="request">
	<div class="request__box" data-decor-parallax>
		<div class="request__container _container">
			<div class="request__grid">
				<div class="request__info">
					<?php if ($title = alergobot_home_get('title')) : ?>
						<h2 class="request__title title title-md title--light <?php echo alergobot_anim_class('blur-up'); ?>"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>
					<?php if ($note = alergobot_home_get('note')) : ?>
						<p class="request__note <?php echo alergobot_anim_class('fade-up'); ?>"><?php echo wp_kses_post($note); ?></p>
					<?php endif; ?>
				</div>
				<div class="request__form-col">
					<?php if ($lead = alergobot_home_get('lead')) : ?>
						<p class="request__lead <?php echo alergobot_anim_class('fade-left'); ?>"><?php echo esc_html($lead); ?></p>
					<?php endif; ?>
					<div class="request__form <?php echo alergobot_anim_class('fade-up'); ?>">
						<?php alergobot_cf7_form('cf7_zakaz'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

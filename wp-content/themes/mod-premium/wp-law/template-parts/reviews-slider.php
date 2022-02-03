<div style="position:relative;">
	<!-- Slider main container -->
	<div class="swiper-overflow-hidden swiper-reviews" style="width: 100%;">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			<!-- Slides -->
			<?php $dir = get_stylesheet_directory_uri() . '/assets/images/reviews'; ?>
			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-1.png?ver=1.0.1',
				); ?>

				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-2.png?ver=1.0.1',
				); ?>

				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-3.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-4.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-5.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-6.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-7.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>


			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-8.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-9.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-10.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-11.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'image' => $dir . '/review-12.png?ver=1.0.1',
				); ?>
				<?php get_template_part('template-parts/review-slide', null, $args); ?>
			</div>	

		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev d-md-none"></div>
		<div class="swiper-button-next d-md-none"></div>
	</div>		
</div>
<div style="position:relative;">
	<!-- Slider main container -->
	<div class="swiper-overflow-hidden swiper-results">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			<!-- Slides -->
			<?php $dir = get_stylesheet_directory_uri() . '/assets/images/results'; ?>
			<div class="swiper-slide">
				<?php $args = array(
					'amount' 	=> '$2.5 Million', 
					'type' 	 	=> 'Traumatic Brain Injury',
					'desc' 		=> 'Client injured in auto accident after driver ran stop sign.',
					'image' => $dir . '/results-1.jpg?ver=1.0.1',
						); ?>
				<?php get_template_part('template-parts/slide-result', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'amount' 	=> '$1.25 Million', 
					'type' 	 	=> 'Medical Malpractice',
					'desc' 		=> 'Patient suffering nerve damage following hip operation.',
					'image' => $dir . '/results-2.jpg?ver=1.0.1',
						); ?>
				<?php get_template_part('template-parts/slide-result', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'amount' 	=> '$10.5 Million', 
					'type' 	 	=> 'Slip and Fall',
					'desc' 		=> 'Woman suffering severe hip and ankle fracture after falling on defective step.',
					'image' => $dir . '/results-3.jpg?ver=1.0.1',
						); ?>
				<?php get_template_part('template-parts/slide-result', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'amount' 	=> '$1.75 Million', 
					'type' 	 	=> 'Semi-Truck Accident',
					'desc' 		=> 'Woman suffering post-concussion syndrome after vehicle rear-ended by tractor trailer.',
					'image' => $dir . '/results-4.jpg?ver=1.0.1',
						); ?>
				<?php get_template_part('template-parts/slide-result', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'amount' 			=> '$940,000', 
					'type' 	 			=> 'Post-Concussion Disorder',
					'desc' 			=> 'Women rear-ended while stopped at red light',
					'image' => $dir . '/results-5.jpg?ver=1.0.1',
						); ?>
				<?php get_template_part('template-parts/slide-result', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'amount' 			=> '$12 Million', 
					'type' 	 			=> 'Semi-truck Accident',
					'desc' => 'Woman suffering a traumatic brain injury following semi-truck accident.',
					'image' => $dir . '/results-6.jpg?ver=1.0.1',
						); ?>
				<?php get_template_part('template-parts/slide-result', null, $args); ?>
			</div>

			<div class="swiper-slide">
				<?php $args = array(
					'amount' 			=> '$797,000', 
					'type' 	 			=> 'Post-Concussion Disorder',
					'desc' => 'Man suffered headaches and other post-concussion symptoms from vehicle crash.',
					'image' => $dir . '/results-7.jpg?ver=1.0.1',
						); ?>
				<?php get_template_part('template-parts/slide-result', null, $args); ?>
			</div>


			<div class="swiper-slide">
				<?php $args = array(
					'amount' 			=> '$7.25 Million', 
					'type' 	 			=> 'Traumatic Brain Injury',
					'desc' => 'Man physically assaulted at his workplace.',
					'image' => $dir . '/results-8.jpg?ver=1.0.1',
						); ?>
				<?php get_template_part('template-parts/slide-result', null, $args); ?>
			</div>


		</div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev d-md-none"></div>
		<div class="swiper-button-next d-md-none"></div>
	</div>		
</div>
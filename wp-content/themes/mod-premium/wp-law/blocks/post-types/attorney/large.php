<?php $section = $tmf->section('attorney-body') ?>

	<?php $row = $tmf->row('attorney-body', 1050) ?>

		<?php if ($post->has_primary_image()): ?>
			<?php 
				$high_res = '';
				$logo_path = get_attached_file($post->primary_image); 
				$image = $tmf->image_url_from_id($post->primary_image);
				$logo_2x = str_replace('3x', '2x', $logo_path);
				$logo_1x = str_replace('3x', '1x', $logo_path);
				$logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
				$logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

				$high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
			?>

		<?php $row->cell(12) ?>

				<div class="attorney-left-box">

					<div class="attorney-left-image-box">
						<img class="primary" src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" alt="<?php echo $post->person_name ?>'s Profile Image" />
					</div>

					<div class="attorneys-left-bottom">
						<?php if ($post->attorney_sign): ?>
							<?php 
					            $high_res = '';
					            $logo_path = get_attached_file($post->attorney_sign); 
					            $image = $tmf->image_url_from_id($post->attorney_sign);
					            $logo_2x = str_replace('3x', '2x', $logo_path);
					            $logo_1x = str_replace('3x', '1x', $logo_path);
					            $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
					            $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

					            $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
				    	?>
				    		<img class="attorney-sign" src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" alt="<?php echo $post->person_name ?>'s Profile Image" />
				    	<?php endif; ?>

						<div class="desktop-view title">
							<?php echo $post->person_name ?>
						</div>
						<?php $tags = wp_get_post_terms( $post->ID, 'attorney-titles' ); ?>
					    <?php if($tags) : ?>
						<div class="mobile-view title">
							<div class="name">
								<?php echo $post->person_name ?>
							</div>
							<div class="job-title">
								<?php foreach($tags as $tag) : ?>
								<?php echo $tag->name; ?>
								<?php endforeach; ?>
							</div>
						</div>
					    
				        <div class="desktop-view custom-attorneys-title">
				            <?php foreach($tags as $tag) : ?>
				                <?php echo $tag->name; ?>
				            <?php endforeach; ?>
				        </div>
					    <?php endif; ?>
					</div>
				</div>

				<div class="mobile-view">
					<?php $tmf->block('sections/reviews-top-inner')->render() ?>
				</div>

			<?php endif; ?>

		<?php $row->cell(12) ?>

			<div id="page-content" class="editor-content">
				<?php if (!empty($post->superlawyer)): ?>
					<?php echo $post->superlawyer ?>
				<?php endif ?>
				<?php echo $post->content ?>
			</div>

	<?php $row->close() ?>

	<?php if ($post->attorney_top_content): ?>
		<?php $row = $tmf->row('attorney-body-bottom', 1050) ?>

			<?php $row->cell(24) ?>
				<div id="page-content" class="editor-content">
					<?php echo $post->attorney_top_content ?>
				</div>

		<?php $row->close() ?>
	<?php endif ?>	

<?php $section->close() ?>

<?php if ($post->did_you_know_content): ?>
<!-- Attorney Did you know Section Start -->
	<?php $section = $tmf->section('attorney-did-you-know') ?>

		<?php $row = $tmf->row('attorney-did-you-know', 1050) ?>

			<?php $row->cell(24) ?>

				<?php if ($post->did_you_know_title): ?>
					<h3><span><?php echo $post->did_you_know_title ?></span></h3>
				<?php endif ?>

				<div id="page-content" class="editor-content">
					<?php echo $post->did_you_know_content ?>
				</div>

		<?php $row->close() ?>

	<?php $section->close() ?>
<!-- Attorney Did you know Section End -->
<?php endif ?>

<?php if( have_rows('attorney_question_and_answer') ): ?>
<!-- Attorney Question and Answer Section Start-->
	<?php $section = $tmf->section('attorney-qa') ?>

		<?php $row = $tmf->row('attorney-qa', 1050) ?>

			<?php $row->cell(24) ?>
				<div class="desktop-view">
					<?php if (get_field('attorney_faqs_title')): ?>
					<h3><?php the_field('attorney_faqs_title'); ?></h3>
					<?php endif ?>
				</div>
				<div class="mobile-view">
					<?php if (get_field('attorney_faqs_title')): ?>
					<h4 class="center"><?php the_field('attorney_faqs_title'); ?></h4>
					<?php endif ?>
				</div>
				

				<?php $count = 1; ?>
				<div class="attorney-qa-accordion">
					<?php while ( have_rows('attorney_question_and_answer') ) : the_row(); ?>
			            <div class="accordion_in">
			            	<div class="acc_head">
								<div class="title"><?php the_sub_field('attorney_faq_question'); ?></div>
							</div>

							<div class="acc_content">
								<div class="editor-content">
									<?php the_sub_field('attorney_faq_answer'); ?>
								</div>
							</div>
			            </div>
		            <?php $count++; ?>
		            <?php endwhile; ?>
		    	</div>

		<?php $row->close() ?>

	<?php $section->close() ?>
<!-- Attorney Question and Answer Section End -->
<?php endif ?>

<?php if ($post->bar_admission_content): ?>
<!-- Attorney Did you know Section Start -->
	<?php $section = $tmf->section('attorney-bar-admission') ?>

		<?php $row = $tmf->row('attorney-bar-admission', 1050) ?>

			<?php $row->cell(24) ?>

				<?php if ($post->bar_admission_title): ?>
					<h3 class="mobile-heading"><span><?php echo $post->bar_admission_title ?></span></h3>
				<?php endif ?>

				<div id="page-content" class="editor-content">
					<?php echo $post->bar_admission_content ?>
				</div>

		<?php $row->close() ?>

	<?php $section->close() ?>
<!-- Attorney Did you know Section End -->
<?php endif ?>
<div class="mobile-view free-case-evaluation inner">
	<h3 class="mobile-heading">
		Get a Free Case Evaluation
	</h3>
	<hr class="yellow"/>
	<?php echo do_shortcode( '[gravityform id="3" title="false" description="false" ajax="true"]' ); ?>
</div>
<div class="mobile-view proven-results-inner">
  	<h3 class="mobile-heading inner">Proven Results</h3>
  	<hr class="yellow left mobile-view"/>
  	<?php get_template_part('template-parts/results-slider'); ?>
  	<div class="proven-results-bottom-text">
      ***Every case is unique and your results will differ. Contact us for a free case review of your circumstance.
  	</div>
</div>
<div id="reviews-slider" class="mobile-view inner">
	<h3 class="center mobile-heading">Real Client Testimonials</h3>
	<hr class="yellow"/>
	<?php get_template_part('template-parts/reviews-slider'); ?>
</div>
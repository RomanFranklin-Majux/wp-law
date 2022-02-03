<div class="<?php echo $post->css_classes('small') ?> ">

	<?php if( have_rows('practice_areas_faqs', $post->ID) ): ?>
		<div class="practice-areas-faqs-accordion">
			<?php while ( have_rows('practice_areas_faqs', $post->ID) ) : the_row(); ?>
	            <div class="accordion_in">
	            	<div class="acc_head">
						<div class="title"><?php the_sub_field('pra_question'); ?></div>
					</div>

					<div class="acc_content">
						<div class="editor-content">
							<?php echo do_shortcode(the_sub_field('pra_answer')); ?>
						</div>
					</div>
	            </div>
            <?php endwhile; ?>
    	</div>
	<?php endif ?>

</div>
<div class="<?php echo $post->css_classes('small') ?> ">

	<div class="excerpt">
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_testimonial_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>#testimonial-<?php echo $post->ID ?>" class="read-more" title="Read more of <?php echo $post->author_name ?>'s testimonial.">
				Read More
			</a>
		<?php endif ?>
	</div>

	<div class="testimonial-description">
		<?php echo do_shortcode($post->testimonial_description) ?>
	</div>		

	<div class="clear"></div>
</div>
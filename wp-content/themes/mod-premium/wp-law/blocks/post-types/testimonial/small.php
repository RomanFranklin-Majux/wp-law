<div class="<?php echo $post->css_classes('small') ?> ">

	<div class="excerpt">
		"<?php echo $post->excerpt ?>"
	</div>

	<div class="testimonial-description">
		<?php echo do_shortcode($post->testimonial_description) ?>
	</div>		

	<div class="clear"></div>
</div>
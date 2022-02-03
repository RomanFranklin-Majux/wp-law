<div id="testimonial-<?php echo $post->ID ?>" class="<?php echo $post->css_classes('medium') ?>">

	<?php if ($post->has_primary_image()): ?>
		<?php if ($post->has_permalink()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">	
		<?php endif ?>
		
		<img class="primary not-mobile" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />

		<?php if ($post->has_permalink()): ?>
			</a>
		<?php endif ?>
	<?php endif; ?>

	<div class="excerpt editor-content">
		<?php if ($post->has_primary_image()): ?>

			<?php if ($post->has_permalink()): ?>
				<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">	
			<?php endif ?>

				<img class="primary mobile" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />

			<?php if ($post->has_permalink()): ?>
				</a>
			<?php endif ?>

		<?php endif; ?>

		<?php if (empty($tmf->option()->testimonial_archive_link)): ?>
			<?php echo $post->excerpt ?>
		<?php else: ?>
			<?php echo $post->content ?>
		<?php endif ?>
	</div>

	<div class="testimonial-description">
		<?php echo do_shortcode($post->testimonial_description) ?>
	</div>	

	<div class="clear"></div>	

	<div class="taxonomy-container">
		<?php echo $post->tags()->render('Tags:') ?>
	</div>
	
</div>
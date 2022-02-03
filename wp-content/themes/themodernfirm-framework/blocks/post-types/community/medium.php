<div class="<?php echo $post->css_classes('medium') ?>">
	
	<h2 class="title">
		<a href="<?php echo $post->permalink ?>">
			<?php echo $post->title ?>
		</a>
	</h2>

	<?php if ($post->has_primary_image()): ?>
		<img class="primary" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
	<?php endif; ?>
	
	<div class="excerpt">
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_community_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more">
				Read More
			</a>
		<?php endif ?>
	</div>

</div>
<div class="<?php echo $post->css_classes('medium') ?>">
	
	<?php if ($post->has_thumbnail_image()): ?>
		<?php if ($post->has_permalink()): ?>	
			<a href="<?php echo $post->permalink ?>" title="Read More about <?php echo $post->title ?>">
		<?php endif ?>

			<img class="not-mobile thumbnail"  src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />

		<?php if ($post->has_permalink()): ?>
			</a>
		<?php endif ?>
	<?php endif; ?>

	<h2 class="title">
		<?php if ($post->has_permalink()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo $post->title ?>">
		<?php endif ?>

			<?php echo $post->title ?>

		<?php if ($post->has_permalink()): ?>
			</a>
		<?php endif ?>
	</h2>

	<div class="excerpt">
		<?php if ($post->has_thumbnail_image()): ?>
			<?php if ($post->has_permalink()): ?>
				<a href="<?php echo $post->permalink ?>" title="Read More about <?php echo $post->title ?>">
			<?php endif ?>

				<img class="mobile thumbnail"  src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->title ?>" />

			<?php if ($post->has_permalink()): ?>
				</a>
			<?php endif ?>
		<?php endif; ?>

		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_practice_area_read_more_links != 1): ?>
			<?php if ($post->has_permalink()): ?>	
				<a href="<?php echo $post->permalink ?>" class="read-more" title="Click for more <?php echo $post->title ?> information">
				Read More
				</a>
			<?php endif ?>
		<?php endif ?>
	</div>

	<div class="clear"></div>

	<div class="taxonomy-container">
		<?php echo $post->attorneys()->render('Attorneys: ') ?>		
	</div>

</div>
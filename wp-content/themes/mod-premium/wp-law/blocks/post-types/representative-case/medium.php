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

	<div class="excerpt editor-content">
		<?php if ($post->has_thumbnail_image()): ?>
			<?php if ($post->has_permalink()): ?>
				<a href="<?php echo $post->permalink ?>" title="Read More about <?php echo $post->title ?>">
			<?php endif ?>

				<img class="mobile thumbnail"  src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />

			<?php if ($post->has_permalink()): ?>
				</a>
			<?php endif ?>
		<?php endif; ?>

		<?php if (empty($tmf->option()->representative_case_archive_link)): ?>
			<?php echo $post->excerpt ?>
		<?php else: ?>
			<?php echo $post->content ?>
		<?php endif ?>

		<?php if($tmf_option->post_type_representative_case_read_more_links != 1): ?>
			<?php if ($post->has_permalink()): ?>	
				<a href="<?php echo $post->permalink ?>" class="read-more" title="Click for more <?php echo $post->title ?> information">
				Read More
				</a>
			<?php endif ?>
		<?php endif ?>
	</div>

	<div class="clear"></div>

</div>
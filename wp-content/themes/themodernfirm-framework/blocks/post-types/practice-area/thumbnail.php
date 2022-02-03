<div class="<?php echo $post->css_classes('thumbnail') ?>">
	
	<div class="cell-1">
		<?php if ($post->has_thumbnail_image()): ?>
			<?php if ($post->has_permalink()): ?>	
				<a href="<?php echo $post->permalink ?>" title="Read More about <?php echo $post->title ?>">
			<?php endif ?>

				<img class="thumbnail"  src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />

			<?php if ($post->has_permalink()): ?>
				</a>
			<?php endif ?>
		<?php endif; ?>
	</div>

	<div class="cell-2">
		<div class="title">
			<?php if ($post->has_permalink()): ?>
				<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo $post->title ?>">
			<?php endif ?>
				<?php echo $post->title ?>
			<?php if ($post->has_permalink()): ?>
				</a>
			<?php endif ?>
		</div>
	</div>

</div>
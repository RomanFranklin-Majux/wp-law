<div class="<?php echo $post->css_classes('thumbnail') ?>">
	
	<div class="cell-1">
		<?php if ($post->has_thumbnail_image()): ?>
			<a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">
				<img class="thumbnail" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
			</a>
		<?php endif; ?>
	</div>

	<div class="cell-2">
		<div class="title">
			<a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">
				<?php echo $post->person_name ?>
			</a>
		</div>
	</div>
	
</div>
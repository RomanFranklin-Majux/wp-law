<div class="<?php echo $post->css_classes('small-excerpt') ?>">

	<div class="title">
		<?php if ($post->has_permalink()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo $post->title ?>">
		<?php endif ?>
			<?php echo $post->title ?>
		<?php if ($post->has_permalink()): ?>
			</a>
		<?php endif ?>
	</div>

	<div class="excerpt">
		<?php echo $post->excerpt(100) ?>

		<?php if($tmf_option->post_type_practice_area_read_more_links != 1): ?>
			<?php if ($post->has_permalink()): ?>	
				<a href="<?php echo $post->permalink ?>" class="read-more" title="Click for more <?php echo $post->title ?> information">
				Read More
				</a>
			<?php endif ?>
		<?php endif ?>
	</div>
	
</div>
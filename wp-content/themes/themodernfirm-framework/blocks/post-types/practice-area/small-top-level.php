<div class="<?php echo $post->css_classes('small') ?>">

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
<div class="<?php echo $post->css_classes('medium') ?>">

	<h2 class="title">
		<?php if ($post->has_permalink()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about this FAQ">
		<?php endif ?>

			<?php echo $post->question ?>

		<?php if ($post->has_permalink()): ?>
			</a>
		<?php endif ?>
	</h2>

	<div class="excerpt editor-content">
		<?php echo $post->answer ?>
	</div>
</div>
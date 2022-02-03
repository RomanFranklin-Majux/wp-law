<div class="<?php echo $post->css_classes('large') ?>">
	
	<?php if ($post->has_title()): ?>
		<h1 id="page-title">
			<?php echo $post->title ?>
		</h1>
	<?php endif ?>

	<div class="content-container">
		<?php if ($post->has_primary_image()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read More about <?php echo $post->title ?>">
				<img class="primary"  src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
			</a>
		<?php endif; ?>

		<div id="page-content" class="editor-content">
			<?php echo $post->content ?>
		</div>

	</div>

	<?php $tmf->block('miscellaneous/social-buttons')->set('page', TRUE)->render() ?>

</div>
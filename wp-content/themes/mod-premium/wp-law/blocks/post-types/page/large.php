<div class="<?php echo $post->css_classes('large') ?>">

	<?php if ($post->has_primary_image()): ?>
		<img class="primary" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
	<?php endif; ?>
	
	<div id="page-content" class="editor-content">
		<?php echo $post->content ?>
	</div>

	<?php $tmf->block('miscellaneous/social-buttons')->set('page', TRUE)->render() ?>

</div>
<div class="<?php echo $post->css_classes('large') ?>">
	
	<?php if ($post->has_title()): ?>
		<h1 id="page-title">
			<?php echo $post->title ?>
		</h1>
	<?php endif ?>
	
	<div class="content-container">
		<?php if ($post->has_primary_image()): ?>
			<img class="primary" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
		<?php endif; ?>

		<div class="clear"></div>

		<br />

		<a href="<?php echo wp_get_attachment_url($post->ebook) ?>" class="tmf-button large" target="_blank">Download eBook</a>
		
		<br /><br />

		<div id="page-content" class="editor-content">
			<?php echo $post->content ?>
		</div>
	</div>
	
</div>
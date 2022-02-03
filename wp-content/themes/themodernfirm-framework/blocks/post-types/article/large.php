<div class="<?php echo $post->css_classes('large') ?>">
	
	<?php if ($post->has_title()): ?>
		<h1 id="page-title">
			<?php echo $post->title ?>
		</h1>
	<?php endif ?>

	<div class="post-information-container">
		<?php if ($post->has_post_date()): ?>
			<div class="date">
				<?php echo $post->formatted_post_date() ?>
			</div>
		<?php endif ?>
		
		<?php if ($post->has_author()): ?>
			<?php $post->author()->render() ?>			
		<?php endif ?>

		<?php $tmf->block('miscellaneous/social-buttons')->set('post', TRUE)->render() ?>
	</div>
	
	<div class="content-container">
		<?php if ($post->has_primary_image()): ?>
			<img class="primary" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
		<?php endif; ?>

		<div id="page-content" class="editor-content">
			<?php echo $post->content ?>
		</div>
	</div>

	<div class="clear"></div>
	
</div>
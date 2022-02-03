<div class="<?php echo $post->css_classes('large') ?>">

	<div class="post-information-container">
		
		<?php if ($post->has_author()): ?>
			<?php $post->author()->render() ?>			
		<?php endif ?>

		<?php if ($post->has_contributors()): ?>
			<?php echo $post->contributor_list() ?>
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

	<?php if (TMF_Admin::$remove_discussion_ui == FALSE): ?>
		<br/>
		<?php $tmf->comments() ?>
	<?php endif ?>
	
</div>
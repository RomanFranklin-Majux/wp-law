<div class="<?php echo $post->css_classes('large') ?>">

	<?php if ($post->has_title()): ?>
		<h1 id="page-title">
			<?php echo $post->title ?>
		</h1>
	<?php endif ?>

	<div class="post-information-container">
		<div class="date">
			<?php echo $post->formatted_start_date() ?>
		</div>

		<div class="location">
			<?php echo $post->event_location(TRUE, TRUE) ?>
		</div>

		<?php $tmf->block('miscellaneous/social-buttons')->set('page', TRUE)->render() ?>

	</div>
	
	<div class="content-container">
		<?php if ($post->has_primary_image()): ?>
			<img class="primary" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
		<?php endif; ?>

		<div id="page-content" class="editor-content">
			<?php echo $post->content ?>
		</div>
	</div>

	<div class="taxonomy-container">
		<?php $post->categories()->render("Categories:") ?>	
		<?php $post->tags()->render("Tags:") ?>	
	</div>

	<div class="clear"></div>

	<?php $post->rsvp()->render() ?>
	<?php $post->registration()->render() ?>
	
</div>			
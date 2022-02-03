<div class="<?php echo $post->css_classes('medium') ?>">
	
	<?php if ($post->has_thumbnail_image()): ?>
		<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			<img class="thumbnail not-mobile" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
		</a>
	<?php endif; ?>

	<h2 class="title">
		<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			<?php echo $post->title ?>
		</a>
	</h2>

	<div class="post-information-container">

		<?php if ($post->has_post_date()): ?>
			<div class="date">
				<?php echo $post->formatted_post_date() ?>
			</div>
		<?php endif ?>

		<?php if ($post->has_author()): ?>
			<?php $post->author()->render() ?>			
		<?php endif ?>

	</div>

	<div class="excerpt">
		<?php if ($post->has_thumbnail_image()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				<img class="thumbnail mobile" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
			</a>
		<?php endif; ?>
		
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_article_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				Read More
			</a>
		<?php endif ?>
	</div>

	<div class="clear"></div>

	<?php if($tmf_option->post_type_article_read_more_buttons != 1): ?>
		<a href="<?php echo $post->permalink; ?>" class="read-more-button tmf-button medium" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			Read More
		</a>
	<?php endif ?>

	<?php $tmf->block('miscellaneous/social-buttons')
		->set('post', TRUE)
		->set('url', $post->permalink)
		->render()
	?>

	<div class="clear"></div>
	
</div>
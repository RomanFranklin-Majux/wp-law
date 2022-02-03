<div class="<?php echo $post->css_classes('medium') ?>">
	
	<?php if ($post->has_primary_image()): ?>
		<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			<img class="primary not-mobile" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
		</a>
	<?php endif; ?>

	<h2 class="title">
		<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			<?php echo $post->title ?>
		</a>
	</h2>

	<div class="post-information-container">
		<div class="date">
			<?php echo $post->formatted_start_date() ?>
		</div>

		<div class="location">
			<?php echo $post->event_location(TRUE, TRUE) ?>
		</div>
	</div>

	<div class="excerpt">
		<?php if ($post->has_primary_image()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				<img class="primary mobile" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
			</a>
		<?php endif; ?>
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_event_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				Read More
			</a>
		<?php endif ?>
	</div>

	<?php if($tmf_option->post_type_event_read_more_buttons != 1): ?>
		<a href="<?php echo $post->permalink; ?>" class="read-more-button tmf-button medium" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			More Information
		</a>
	<?php endif ?>

	<?php if ($post->has_rsvp()): ?>
		<a href="<?php echo $post->permalink ?>#rsvp" class="read-more-button rsvp tmf-button medium">RSVP</a>
	<?php endif ?>

	<?php if ($post->has_registration()): ?>
		<a href="<?php echo $post->permalink ?>#registration" class="read-more-button registration tmf-button medium">Register</a>
	<?php endif ?>

	<div class="taxonomy-container">
		<?php $post->categories()->render("Categories:"); ?>	
		<?php $post->tags()->render("Tags:"); ?>	
	</div>

	<?php $tmf->block('miscellaneous/social-buttons')
		->set('post', TRUE)
		->set('url', $post->permalink)
		->render()
	?>

	<div class="clear"></div>
	
</div>
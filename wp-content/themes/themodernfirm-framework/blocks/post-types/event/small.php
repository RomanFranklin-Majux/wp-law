<div class="<?php echo $post->css_classes('small') ?>">

	<div class="calendar-icon">
		<div class="month">
			<?php echo $post->formatted_post_date('M') ?>
		</div>
		<div class="day">
			<?php echo $post->formatted_post_date('j') ?>
		</div>
	</div>

	<div class="title">
		<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			<?php echo $post->title ?>
		</a>

		<div class="date">
			<?php echo $post->formatted_start_date() ?>
		</div>

		<div class="location">
			<?php echo $post->event_location(FALSE, TRUE) ?>
		</div>
	</div>

	<div class="excerpt">
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_event_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				Read More
			</a>
		<?php endif ?>

		<?php if ($post->has_rsvp()): ?>
			or <a href="<?php echo $post->permalink ?>#rsvp" class="read-more rsvp">RSVP</a>
		<?php endif ?>

		<?php if ($post->has_registration()): ?>
			or <a href="<?php echo $post->permalink ?>#registration" class="read-more registration">Register</a>
		<?php endif ?>
	</div>
	
</div>
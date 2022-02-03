<div class="<?php echo $post->css_classes('small') ?>">

	<?php if ($post->has_post_date()): ?>
		<div class="calendar-icon">
			<div class="month">
				<?php echo $post->formatted_post_date('M') ?>
			</div>
			<div class="day">
				<?php echo $post->formatted_post_date('j') ?>
			</div>
		</div>
	<?php endif ?>

	<div class="title <?php if ($post->has_post_date()) echo 'has-post-date' ?>">
		<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			<?php echo $post->title ?>
		</a>
	
		<?php if ($post->has_post_date()): ?>
			<div class="date">
				<?php echo $post->formatted_post_date() ?>
			</div>
		<?php endif ?>
	</div>

	<div class="excerpt">
		<?php echo $post->excerpt ?>

		<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			Read More
		</a>
			
	</div>
	
</div>
<div class="<?php echo $post->css_classes('small') ?>">
	
	<?php if ($post->has_thumbnail_image()): ?>
		<a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">
			<img class="thumbnail" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
		</a>
	<?php endif; ?>

	<div class="title">
		<a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">
			<?php echo $post->person_name ?>
		</a>
	</div>

	<div class="excerpt">
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_staff_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="View <?php echo $post->person_name ?>'s Staff Profile">
				Read More
			</a>
		<?php endif ?>
	</div>

	<div class="clear"></div>
	
</div>
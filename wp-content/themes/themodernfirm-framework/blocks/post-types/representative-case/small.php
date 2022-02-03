<div class="<?php echo $post->css_classes('small') ?>">

	<div class="title">
		<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo $post->title ?>">
			<?php echo $post->title ?>
		</a>
	</div>

	<div class="excerpt">
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_representative_case_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				Read More
			</a>
		<?php endif ?>
	</div>

</div>
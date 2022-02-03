<div class="<?php echo $post->css_classes('small') ?>">

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
		<?php
			$page_excerpt = substr($post->excerpt,0,250).'...';
			echo $page_excerpt;
		?>

		<?php if($tmf_option->post_type_page_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				Read More
			</a>
		<?php endif ?>
	</div>
	
</div>
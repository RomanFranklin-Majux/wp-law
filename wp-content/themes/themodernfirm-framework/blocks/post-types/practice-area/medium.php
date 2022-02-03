<div class="<?php echo $post->css_classes('medium') ?>">
	
	<?php if ($post->has_thumbnail_image()): ?>
		<?php if ($post->has_permalink()): ?>	
			<a href="<?php echo $post->permalink ?>" title="Read More about <?php echo $post->title ?>">
		<?php endif ?>

			<img class="not-mobile thumbnail"  src="<?php echo $post->thumbnail_image_url ?>"  alt="<?php echo $post->thumbnail_image_alt ?>" />

		<?php if ($post->has_permalink()): ?>
			</a>
		<?php endif ?>
	<?php endif; ?>

	<h2 class="title">
		<?php if ($post->has_permalink()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo $post->title ?>">
		<?php endif ?>

			<?php echo $post->title ?>

		<?php if ($post->has_permalink()): ?>
			</a>
		<?php endif ?>
	</h2>

	<div class="excerpt">
		<?php if ($post->has_thumbnail_image()): ?>
			<?php if ($post->has_permalink()): ?>
				<a href="<?php echo $post->permalink ?>" title="Read More about <?php echo $post->title ?>">
			<?php endif ?>

				<img class="mobile thumbnail"  src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->title ?>" />

			<?php if ($post->has_permalink()): ?>
				</a>
			<?php endif ?>
		<?php endif; ?>

		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_practice_area_read_more_links != 1): ?>

			<?php if ($post->has_permalink()): ?>	
				<a href="<?php echo $post->permalink ?>" class="read-more" title="Click for more <?php echo $post->title ?> information">
				Read More
				</a>
			<?php endif ?>

		<?php endif ?>
	</div>

	<div class="clear"></div>

	<div class="taxonomy-container">
		<?php echo $post->attorneys()->render('Attorneys:') ?>		
	</div>

	<?php if (!$tmf->is_search()): ?>
		<?php 
			$args = array(
				'post_parent'		=> $post->ID,
				'orderby'			=> 'menu_order',
				'order'				=> 'ASC',
				'posts_per_page'	=> -1,
				'post_type'			=> 'practice-area',
				'suppress_filters'	=> FALSE
			);
			$child_practice_areas	= TMF_Post::factory($args);
			$child_array			= $child_practice_areas->to_array();
		?>

		<?php if (!empty($child_array)): ?>
			<div class="children">
				<?php $child_practice_areas->template('medium')->render(TRUE, $post->is_in_archive_list) ?>
			</div>
		<?php endif ?>

	<?php endif ?>

</div>
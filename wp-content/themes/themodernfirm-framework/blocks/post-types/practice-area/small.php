<div class="<?php echo $post->css_classes('small') ?>">

	<div class="title">
		<?php if ($post->has_permalink()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo $post->title ?>">
		<?php endif ?>
			<?php echo $post->title ?>
		<?php if ($post->has_permalink()): ?>
			</a>
		<?php endif ?>
	</div>

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
			<?php $child_practice_areas->template('small')->render() ?>
		</div>
	<?php endif ?>

</div>
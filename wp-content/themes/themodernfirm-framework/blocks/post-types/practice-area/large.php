<div class="<?php echo $post->css_classes('large') ?>">
	
	<?php if ($post->has_title()): ?>
		<h1 id="page-title">
			<?php echo $post->title ?>
		</h1>
	<?php endif ?>

	<div class="content-container">
		<?php if ($post->has_primary_image()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read More about <?php echo $post->title ?>">
				<img class="primary"  src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
			</a>
		<?php endif; ?>

		<div id="page-content" class="editor-content">
			<?php echo $post->content ?>
		</div>

	</div>
	
	<div class="taxonomy-container">
		<?php echo $post->attorneys()->render('Attorneys: ') ?>		
	</div>

	<?php $tmf->block('miscellaneous/social-buttons')->set('page', TRUE)->render() ?>

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
			<?php $child_practice_areas->template('medium')->render() ?>
		</div>
	<?php endif ?>

</div>
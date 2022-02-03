<div class="taxonomy-list">

	<?php if (!empty($taxonomies)): ?>
		<?php foreach($taxonomies as $taxonomy): ?>

			<div id="taxonomy-<?php echo $taxonomy->cat_ID ?>" class="taxonomy-item">
				
				<a class="name" href="<?php echo get_term_link($taxonomy) ?>">
					<?php echo $taxonomy->name ?>
				</a>

			</div>

		<?php endforeach ?>
	<?php endif ?>
	
</div>
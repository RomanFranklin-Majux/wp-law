<div class="<?php echo $post->css_classes('medium') ?>">
	
	<?php if ($post->has_thumbnail_image()): ?>
		<a href="<?php echo wp_get_attachment_url($post->ebook) ?>" title="Download eBook" target="_blank">
			<img class="not-mobile thumbnail" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
		</a>
	<?php endif; ?>

	<h2 class="title">
		<a href="<?php echo wp_get_attachment_url($post->ebook) ?>" title="Download eBook" target="_blank">
			<?php echo $post->title ?>
		</a>
	</h2>

	<div class="excerpt">
		<?php if ($post->has_thumbnail_image()): ?>
			<a href="<?php echo wp_get_attachment_url($post->ebook) ?>" title="Download eBook" target="_blank">
				<img class="mobile thumbnail" src="<?php echo $post->thumbnail_image_url ?>" />
			</a>
		<?php endif; ?>
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_ebook_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about this eBook">
				Read More
			</a>
		<?php endif ?>
	</div>

	<div class="clear"></div>
	
</div>
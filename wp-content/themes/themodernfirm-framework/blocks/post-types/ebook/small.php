<div class="<?php echo $post->css_classes('small') ?>">
	
	<?php if ($post->has_thumbnail_image()): ?>
		<a href="<?php echo wp_get_attachment_url($post->ebook) ?>" title="Download eBook" target="_blank">
			<img class="thumbnail" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
		</a>
	<?php endif; ?>

	<div class="title">
		<a href="<?php echo wp_get_attachment_url($post->ebook) ?>" title="Download eBook" target="_blank">
			<?php echo $post->title ?>
		</a>
	</div>

	<div class="excerpt">
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_ebook_read_more_links != 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about this eBook">
				Read More
			</a>
		<?php endif ?>
	</div>

	<div class="clear"></div>
	
</div>
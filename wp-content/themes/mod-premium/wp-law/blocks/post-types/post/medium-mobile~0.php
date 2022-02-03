<div class="<?php echo $post->css_classes('medium') ?>">

	<div class="medium-inner">

		<div class="medium-box">

		    <?php if ($post->has_thumbnail_image()): ?>
		        <?php 
		                $high_res = '';
		                $logo_path = get_attached_file($post->thumbnail_image); 
		                $image = $tmf->image_url_from_id($post->thumbnail_image);
		                $logo_2x = str_replace('3x', '2x', $logo_path);
		                $logo_1x = str_replace('3x', '1x', $logo_path);
		                $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
		                $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

		                $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
		        ?>
				<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
					<div class="medium-thumbnail-container">
						<img class="medium-thumbnail" src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
					</div>
					
				</a>
			<?php endif; ?>

			<div class="title">
				<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
					<?php echo $post->title ?>
				</a>
			</div>

		</div>
        
			<div class="medium-button">
				<a href="<?php echo $post->permalink ?>" class="read-more" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
					Read More
				</a>
			</div>

	</div>

</div>
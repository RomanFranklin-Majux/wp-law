<div class="<?php echo $post->css_classes('small') ?>">

	<div class="small-inner about-attorney-divs">
		
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
			<a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">
				<img class="small-thumbnail" src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" alt="<?php echo $post->person_name ?>'s Profile Image" />
			</a>
				
		<?php endif; ?>

		<div class="title">
			<a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">
				<?php echo $post->person_name ?>
			</a>
		</div>

		<?php $post->job_titles()->render() ?>

		<div class="small-attorney-buttons">
	    
		    <a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">
		            Read Bio
		    </a>
			
		</div>

		<div class="clear"></div>

	</div>
	
</div>
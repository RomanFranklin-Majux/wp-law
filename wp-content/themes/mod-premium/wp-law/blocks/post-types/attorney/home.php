<div class="<?php echo $post->css_classes('home') ?>">
		
		<?php if ($post->home_image): ?>
			<?php 
	            $high_res = '';
	            $logo_path = get_attached_file($post->home_image); 
	            $image = $tmf->image_url_from_id($post->home_image);
	            $logo_2x = str_replace('3x', '2x', $logo_path);
	            $logo_1x = str_replace('3x', '1x', $logo_path);
	            $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
	            $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

	            $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
	    	?>
	    
			<div class="attorney-home-cell-1">
				<a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">

					<div class="attorney-left-box">

						<?php if($post->meet_title) : ?>
							<div class="attorneys-left-top">
								<div class="top-title"><?php echo $post->meet_title ?></div>
								<img src="<?php echo $tmf->theme_image('arrow_1x.png') ?>" alt="Personal Injury Attorneys" />
							</div>
						<?php endif; ?>

						<img class="home-thumbnail" src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" alt="<?php echo $post->person_name ?>'s Profile Image" />

						<div class="attorneys-left-bottom">
							<?php if ($post->attorney_sign): ?>
								<?php 
						            $high_res = '';
						            $logo_path = get_attached_file($post->attorney_sign); 
						            $image = $tmf->image_url_from_id($post->attorney_sign);
						            $logo_2x = str_replace('3x', '2x', $logo_path);
						            $logo_1x = str_replace('3x', '1x', $logo_path);
						            $logo_2x_url = ( file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '' );
						            $logo_1x_url = ( file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '' );

						            $high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '' ) . (!empty($image) ? $image .' 3x' : '');
					    	?>
					    		<img class="attorney-sign" src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" alt="<?php echo $post->person_name ?>'s Profile Image" />
					    	<?php endif; ?>

							<div class="title">
								<?php echo $post->person_name ?>
							</div>

						    <?php $tags = wp_get_post_terms( $post->ID, 'attorney-titles' ); ?>
						    <?php if($tags) : ?>
					            <div class="custom-attorneys-title">
					                <?php foreach($tags as $tag) : ?>
					                    <?php echo $tag->name; ?>
					                <?php endforeach; ?>
					            </div>
						    <?php endif; ?>
						    
						</div>

					</div>
				</a>

			</div>
			
		<?php endif; ?>

	<div class="attorney-home-cell-2">

		<?php if($post->top_rated_title) : ?>
			<div class="top-rated-title"><?php echo $post->top_rated_title ?></div>
		<?php endif; ?>

		<?php if($post->sub_title) : ?>
			<div class="sub-title"><?php echo $post->sub_title ?></div>
		<?php endif; ?>

		<div class="editor-content">
			<?php echo $post->home_content ?>
		</div>

	</div>

	<div class="clear"></div>
	
</div>
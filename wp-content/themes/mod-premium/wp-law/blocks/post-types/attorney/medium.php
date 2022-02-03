<div class="<?php echo $post->css_classes('medium') ?>">
	
	<?php if($tmf_option->post_type_attorney_read_more_buttons == 1): ?>
		<a href="<?php echo $post->permalink ?>" class="top read-more-button tmf-button small" title="View <?php echo $post->person_name ?>'s Attorney Profile">
			View <?php echo $post->first_name ?>'s Profile
		</a>
	<?php endif; ?>

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
                    <img class="thumbnail" src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" alt="<?php echo $post->person_name ?>'s Profile Image" />
                </a>
	<?php endif; ?>

	<h2 class="title">
		<a href="<?php echo $post->permalink ?>" title="View <?php echo $post->person_name ?>'s Attorney Profile">
			<?php echo $post->person_name ?>
		</a>
	</h2>

	<?php $post->job_titles()->render() ?>
	
	<?php if ($post->has_contact_information()): ?>
		<div class="contact-information">
			
			<?php if (!empty($post->phone_1)): ?>
				<div class="phone phone-1">
					<span class="label"><?php echo $post->phone_1_label ?></span>
					<?php if(!empty($post->phone_1_ext)): ?>
						<span class="value">
							<a href="tel:<?php echo $post->phone_1 .";". $post->phone_1_ext ?>"><?php echo $post->phone_1 ?> ext. <?php echo $post->phone_1_ext; ?></a>
						</span>
					<?php else: ?>
						<span class="value">
							<a href="tel:<?php echo $post->phone_1 ?>"><?php echo $post->phone_1 ?></a>
						</span>
					<?php endif; ?>
				</div>
			<?php endif ?>

			<?php if (!empty($post->phone_2)): ?>
				<div class="phone phone-2">
					<span class="label"><?php echo $post->phone_2_label ?></span>
					<?php if(!empty($post->phone_2_ext)): ?>
						<span class="value">
							<a href="tel:<?php echo $post->phone_2 .";". $post->phone_2_ext ?>"><?php echo $post->phone_2 ?> ext. <?php echo $post->phone_2_ext; ?></a>
						</span>
					<?php else: ?>
						<span class="value">
							<a href="tel:<?php echo $post->phone_2 ?>"><?php echo $post->phone_2 ?></a>
						</span>
					<?php endif; ?>
				</div>
			<?php endif ?>

			<?php if (!empty($post->fax)): ?>
				<div class="fax">
					<span class="label"><?php echo $post->fax_label ?></span>
					<span class="value"><?php echo $post->fax ?></span>
				</div>
			<?php endif ?>

			<?php if (!empty($post->email)): ?>
				<div class="email">
					<span class="label"><?php echo $post->email_label ?></span>
					<?php echo $post->obfuscate_email('value', 'Send an Email to ' . $post->person_name) ?>
				</div>
			<?php endif ?>

		</div>		
	<?php endif ?>

	<div class="excerpt">
		<?php echo $post->excerpt ?>

		<?php if($tmf_option->post_type_attorney_read_more_links == 1): ?>
			<a href="<?php echo $post->permalink ?>" class="read-more" title="View <?php echo $post->person_name ?>'s Attorney Profile">
				Read More
			</a>
		<?php endif ?>
	</div>
	
	<?php if ($post->has_practice_areas()): ?>
		<div class="taxonomy-container">
			<?php $post->practice_areas()->render($post->first_name . "'s Practice Areas: "); ?>	
		</div>
	<?php endif ?>

	<?php if($tmf_option->post_type_attorney_read_more_buttons == 1): ?>
		<a href="<?php echo $post->permalink ?>" class="bottom read-more-button tmf-button small" title="View <?php echo $post->person_name ?>'s Attorney Profile">
			View <?php echo $post->first_name ?>'s Profile
		</a>
	<?php endif ?>

	<div class="clear"></div>
</div>
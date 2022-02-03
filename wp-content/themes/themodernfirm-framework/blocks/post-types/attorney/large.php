<div class="<?php echo $post->css_classes('large') ?>">
	
	<?php if ($post->has_primary_image()): ?>
		<img class="primary" src="<?php echo $post->primary_image_url ?>" alt="<?php echo $post->primary_image_alt ?>" />
	<?php endif; ?>

	<?php if ($post->has_title()): ?>
		<h1 id="page-title">
			<?php echo $post->title ?>
		</h1>
	<?php endif ?>

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

	<div class="icon-container">
		<?php
			$tmf->block('miscellaneous/social-icons')
				->set('facebook', $post->facebook)
				->set('linkedin', $post->linkedin)
				->set('twitter', $post->twitter)
				->set('google_plus', $post->google)
				->set('avvo', $post->avvo)
				->set('name', trim($post->first_name))
				->render();
		?>
		
		<div class="vcard-resume-container">
			
			<a href="<?php echo $post->vcard_url ?>" class="icon vcard" title="Download <?php echo $post->person_name ?>'s <?php echo $post->vcard_label ?>">
				<span class="value"></span>
				<span class="label"><?php echo $post->vcard_label ?></span>
			</a>

			<?php if ($post->has_resume()): ?>
				<a href="<?php echo $post->resume_url ?>" class="icon resume" target="_blank" title="Download <?php echo $post->person_name ?>'s <?php echo $post->resume_label ?>">
					<span class="value"></span>
					<span class="label"><?php echo $post->resume_label ?></span>
				</a>
			<?php endif ?>
		</div>
	</div>

	<div id="page-content" class="editor-content">
		<?php if (!empty($post->superlawyer)): ?>
			<?php echo $post->superlawyer ?>
		<?php endif ?>
		<?php echo $post->content ?>
	</div>

	<?php $tmf->block('miscellaneous/social-buttons')->set('page', TRUE)->render() ?>

</div>
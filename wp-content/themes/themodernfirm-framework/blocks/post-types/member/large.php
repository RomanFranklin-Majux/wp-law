<div class="<?php echo $post->css_classes('large') ?>">
	
	<?php if ($post->has_primary_image()): ?>
		<img class="primary" src="<?php echo $post->primary_image_url ?>"  alt="<?php echo $post->primary_image_alt ?>" />
	<?php endif; ?>

	<?php if ($post->has_title()): ?>
		<h1 id="page-title">
			<?php echo $post->title ?>
		</h1>
	<?php endif ?>

	<?php if ($post->has_contact_information()): ?>
		<div class="contact-information">

			<div class="main-information">
				<?php if ($post->business_name): ?>
					<div class="business-name"><?php echo $post->business_name ?></div>
				<?php endif ?>

				<?php echo $post->taxonomy('professional-areas')->render(NULL, ', ', FALSE) ?>
			</div>

			<?php if ($post->business_address): ?>
				<div class="address">
					<?php echo $post->business_address ?>
				</div>
			<?php endif ?>
			
			<?php if (!empty($post->phone_1)): ?>
				<div class="phone phone-1">
					<span class="label">Phone: </span>
					<span class="value"><?php echo $post->phone_1 ?></span>
				</div>
			<?php endif ?>

			<?php if (!empty($post->phone_2)): ?>
				<div class="phone phone-2">
					<span class="label">Phone: </span>
					<span class="value"><?php echo $post->phone_2 ?></span>
				</div>
			<?php endif ?>

			<?php if (!empty($post->fax)): ?>
				<div class="fax">
					<span class="label">Fax: </span>
					<span class="value"><?php echo $post->fax ?></span>
				</div>
			<?php endif ?>

			<?php if (!empty($post->email)): ?>
				<div class="email">
					<span class="label">Email: </span>
					<?php echo $post->obfuscate_email('value', 'Send an Email to ' . $post->person_name) ?>
				</div>
			<?php endif ?>

			<?php if ($post->business_url): ?>
				<div class="url">
					<span class="label">Website:</span>
					<a href="<?php echo $post->business_url ?>" target="_blank"><?php echo $post->business_url ?></a>
				</div>
			<?php endif ?>

		</div>		
	<?php endif ?>

	<div class="clear"></div>

	<div id="page-content" class="editor-content">
		<?php echo $post->content ?>
	</div>

	<?php $tmf->block('miscellaneous/social-buttons')->set('page', TRUE)->render() ?>

</div>
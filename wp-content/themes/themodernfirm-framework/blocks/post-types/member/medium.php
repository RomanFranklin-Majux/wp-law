<div class="<?php echo $post->css_classes('medium') ?>" data-name="<?php echo strtolower($post->person_name) ?>" data-letter="<?php echo strtolower(substr($post->last_name, 0,1)) ?>">
	
	<div class="member-image">
		<?php if ($post->has_thumbnail_image()): ?>
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				<img class="thumbnail" src="<?php echo $post->thumbnail_image_url ?>" alt="<?php echo $post->thumbnail_image_alt ?>" />
			</a>
		<?php endif; ?>
	</div>

	<?php if($tmf_option->post_type_member_read_more_buttons != 1): ?>
		<a href="<?php echo $post->permalink; ?>" class="read-more-button tmf-button tiny" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
			View Profile
		</a>
	<?php endif ?>

	<div class="main-information">

		<div class="title">
			<a href="<?php echo $post->permalink ?>" title="Read more about <?php echo TMF_Text::limit_chars($post->title, 25) ?>">
				<?php echo $post->last_name ?>, <?php echo $post->first_name ?>
			</a>
		</div>

		<?php if ($post->business_name): ?>
			<div class="business-name"><?php echo $post->business_name ?></div>
		<?php endif ?>

		<?php echo $post->taxonomy('professional-areas')->render(NULL, ', ', FALSE) ?>
	</div>

	<div class="contact-information">

		<?php if ($post->business_address): ?>
			<div class="address">
				<?php echo $post->business_address ?>
			</div>
		<?php endif ?>

		<?php if ($post->phone_1): ?>
			<div class="phone">
				<span class="label">Phone:</span>
				<?php echo $post->phone_1 ?>
			</div>
		<?php endif ?>

		<?php if ($post->email): ?>
			<div class="email">
				<span class="label">Email:</span>
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
	
</div>
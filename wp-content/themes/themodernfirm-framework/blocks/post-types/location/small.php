<div class="<?php echo $post->css_classes('small') ?>" itemscope itemtype="http://schema.org/Organization">
	
	<?php $tmf->block('miscellaneous/map-static')
			->set('post', $post)
			->set('address', $post->map_address)
			->set('width', 350)
			->set('height', 200)
			->set('zoom', 11)
			->render();
	?>
			
	<?php if ($business_name = $tmf->wp_option()->blogname): ?>
		<div class="title business-name" itemprop="name">
			<?php echo $business_name ?>
		</div>
	<?php endif ?>

	<?php if ($post->building_name): ?>
		<div class="building-name">
			<?php echo $post->building_name ?>
		</div>
	<?php endif ?>

	<?php if ($post->address_1): ?>
		<div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			<div itemprop="streetAddress">
				<?php echo $post->address_1 ?><br/>
				<?php if ($post->address_2): ?>
					<?php echo $post->address_2 ?>
				<?php endif ?>
			</div>
			<span itemprop="addressLocality"><?php echo $post->city ?></span>, 
			<span itemprop="addressRegion"><?php echo $post->state ?></span> 
			<span itemprop="postalCode"><?php echo $post->zipcode ?></span>
		</div>
	<?php endif ?>

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

	<?php if ($post->fax): ?>
		<div class="fax">
			<span class="label"><?php echo $post->fax_label ?></span>
			<span class="value"><?php echo $post->fax ?></span>
		</div>
	<?php endif ?>

	<?php if ($post->email): ?>
		<div class="email">
			<span class="label"><?php echo $post->email_label ?></span>
			<?php echo $post->obfuscate_email('value') ?>
		</div>
	<?php endif ?>

</div>
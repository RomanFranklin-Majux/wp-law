<div class="<?php echo $post->css_classes('medium') ?>" itemscope itemtype="http://schema.org/Organization">
	
	<?php $row = $tmf->row('location', 1000) ?>

		<?php $row->cell(12) ?>

			<?php if ($tmf->wp_option()->blogname !== $post->post_title): ?>
				<h2 class="name">
					<?php echo $post->post_title ?>
				</h2>
				<div class="business-name" itemprop="name">
					<?php echo $tmf->wp_option()->blogname ?>
				</div>
			<?php else: ?>
				<h2 class="business-name" itemprop="name">
					<?php echo $tmf->wp_option()->blogname ?>
				</h2>
			<?php endif ?>

			<?php if ($post->building_name): ?>
				<div class="building-name">
					<?php echo $post->building_name ?>
				</div>
			<?php endif ?>

			<?php if ($post->address_1): ?>
				<div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<span itemprop="streetAddress">
						<?php echo $post->address_1 ?><br/>
						<?php if ($post->address_2): ?>
							<?php echo $post->address_2 ?><br/>
						<?php endif ?>
					</span>
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

		<?php if($post->remove_map !== 'true') : ?>
			<?php $row->cell(12) ?>
				<?php $tmf->block('miscellaneous/map-embed')
							->set('address', $post->map_address)
							->set('remove_firm_name', $post->remove_firm_name)
							->set('name', $tmf->wp_option()->blogname)
							->set('width', 400)
							->set('height', 250)
							->set('zoom', 14)
							->render();
				?>		
		<?php endif ?>
		
	<?php $row->close() ?>

	<?php if($post->remove_all_directions !== 'true') : ?>
		<div class="direction-links">
			Directions Via:<br/>
			<?php if($post->remove_google_directions !== 'true') : ?>
				<a href="http://maps.google.com/?q=<?php echo $post->map_address ?>" target="_blank" class="location-map-link google-map-link">Google Maps</a><?php echo ($post->remove_bing_directions !== 'true' ? ($post->remove_bing_directions !== 'true' ? ',' : '') : ($post->remove_mapquest_directions !== 'true' ? ',' : '')) ?>
			<?php endif ?>
			<?php if($post->remove_bing_directions !== 'true') : ?>
				<a href="http://www.bing.com/maps/?v=2&where1=<?php echo $post->map_address ?>" target="_blank" class="location-map-link bing-map-link">Bing Maps</a><?php echo $post->remove_mapquest_directions !== 'true' ? ',' : '' ?>
			<?php endif ?>
			<?php if($post->remove_mapquest_directions !== 'true') : ?> 
				<a href="http://www.mapquest.com/?q=<?php echo $post->map_address ?>" target="_blank" class="location-map-link mapquest-map-link">Mapquest</a>
			<?php endif ?>
		</div>
	<?php endif ?>

</div>

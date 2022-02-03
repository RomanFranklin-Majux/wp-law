<div class="<?php echo $post->css_classes('mobile-location') ?>" itemscope itemtype="http://schema.org/Organization">

	<div class="location-small-container">
	    <div class="location-small-1">
	    	<a  href="http://maps.google.com/?q=<?php echo $post->map_address ?>" target="_blank" class="location-map-link">

    			<div class="location-address">
	    			<span class="map-label"><i class="fas fa-map-marker-alt"></i></span>

			        <span class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					    <?php if ($business_name = $tmf->wp_option()->blogname): ?>
					        <div class="title business-name" itemprop="name">
					            <?php echo $business_name ?>
					        </div>
					    <?php endif ?>

					    <?php if ($post->address_1): ?>
				            <div itemprop="streetAddress">
				                <?php echo $post->address_1 ?><br />
				                <?php if ($post->address_2): ?>
				                    <?php echo $post->address_2 ?>
				                <?php endif ?>
				            </div>
				            <span itemprop="addressLocality"><?php echo $post->city ?></span>, 
				            <span itemprop="addressRegion"><?php echo $post->state ?></span> 
				            <span itemprop="postalCode"><?php echo $post->zipcode ?></span>
					    <?php endif ?>
		        	</span>
				</div>
		    </a>

		    <div class="divider"></div>
		</div>

		<div class="location-small-2">
		    <?php if ($post->phone_1): ?>
		        <div class="phone phone-1">
		        	<span class="label"><i class="fas fa-phone-alt"></i></span>
		            <span class="value" itemprop="telephone"><a href="tel: <?php echo $post->phone_1 ?>"><?php echo $post->phone_1 ?></a></span>
		        </div>
		    <?php endif ?>

	    	<?php if ($post->fax): ?>
				<div class="fax">
					<span class="label"><i class="fas fa-fax"></i></span>
					<span class="value"><?php echo $post->fax ?></span>
				</div>
			<?php endif ?>

			<?php if ($post->email): ?>
				<div class="email">
					<span class="label"><i class="fas fa-envelope"></i></span>
					<?php echo $post->obfuscate_email('value') ?>
				</div>
			<?php endif ?>
		</div>
	</div>
	
</div>
<div id="contact-page-mobile-top" >
	<div class="billboard-mobile mobile-view">
    	<div class="int-billboard-image">
      		<img src="/wp-content/uploads/2021/12/8b8958043c3e9203dded23e1c54f14f2@1x.png" alt="Best Indiana Injury Lawyer" />
    	</div>
		<div class="int-billboard-heading">
		  Get a Free<br> Case Review
		</div>
  	</div>
	<div class="call-us-now mobile-view">
		<a href="tel:+12193221166" class="btn btn-blue">CALL US NOW</a>
	</div>
	<div class="contact-page-form mobile-view">
		<div class="free-case-evaluation inner">
			<h3 class="mobile-heading">
				Get a Free Case Evaluation
			</h3>
			<hr class="yellow"/>
			<?php echo do_shortcode( '[gravityform id="3" title="false" description="false" ajax="true"]' ); ?>
			<h4>
				FIRM HEADQUARTERS
			</h4>
			<p>
				PLEASE DIRECT ALL MAIL CORRESPONDENCE HERE
			</p>
		</div>
	</div>
</div>

<div class="<?php echo $post->css_classes('medium') ?>" itemscope itemtype="http://schema.org/Organization">

  <?php if ($post->has_primary_image()) : ?>

    <?php
    $high_res = '';
    $logo_path = get_attached_file($post->primary_image);
    $image = $tmf->image_url_from_id($post->primary_image);
    $logo_2x = str_replace('3x', '2x', $logo_path);
    $logo_1x = str_replace('3x', '1x', $logo_path);
    $logo_2x_url = (file_exists($logo_2x) ? str_replace('3x', '2x', $image) : '');
    $logo_1x_url = (file_exists($logo_1x) ? str_replace('3x', '1x', $image) : '');

    $high_res = (!empty($logo_2x_url) ? $logo_2x_url . ' 2x' : '') . (!empty($logo_2x_url && $image) ? ', ' : '') . (!empty($image) ? $image . ' 3x' : '');
    ?>

    <img class="location-primary" src="<?php echo $logo_1x_url ?>" srcset="<?php echo $high_res ?>" alt="Top-Rated Injury Attorneys" />

  <?php endif; ?>

  <h2 class="title">
    <?php echo $post->post_title ?>
    <?php if ($post->building_name) : ?>
      <?php echo $post->building_name ?>
    <?php endif ?>
  </h2>

  <div class="location-address-wrapper">

    <?php if ($post->address_1) : ?>
      <div class="address-label desktop-view">Address</div>
	  <div class="address-label mobile-view"></div>
      <div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <span itemprop="streetAddress">
          <?php echo $post->address_1 ?>
          <?php if ($post->address_2) : ?>
            <?php echo $post->address_2 ?><br />
          <?php endif ?>
        </span>
        <span itemprop="addressLocality"><?php echo $post->city ?></span>,
        <span itemprop="addressRegion"><?php echo $post->state ?></span>
        <span itemprop="postalCode"><?php echo $post->zipcode ?></span>
      </div>
    <?php endif ?>

    <div class="phone phone-1">
      <div class="label desktop-view">Toll-Free Number</div>
	  <div class="label mobile-view"></div>
      <div class="value">
        <a href="tel:219-322-1166">219-322-1166</a>
      </div>
    </div>

    <div class="phone phone-2">
      <div class="label">Toll-Free Facsimile</div>
      <div class="value">
        <a href="tel:1-866-891-1166">1-866-891-1166</a>
      </div>
    </div>

  </div>


</div>
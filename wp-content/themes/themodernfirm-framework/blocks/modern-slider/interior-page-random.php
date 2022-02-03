<?php
if( !empty($slide->_modernslider_metas) ):
	// Get Random Image Array
	// Example: Array ( [type] => image [id] => 19 [title] => [description] => [link] => [link_target] => _self [img_alt] => [img_title] => [custom] => )
	$meta = $slide->_modernslider_metas[array_rand($slide->_modernslider_metas)];
	if($meta['type'] == "custom") {
		echo do_shortcode($meta['custom']);
	} else {
		// Get Image URL because we always save image ID's in the DB
		$image_url = wp_get_attachment_image_src($meta['id'], 'full');
		$image_url = (is_array($image_url)) ? $image_url[0] : '';


		$image_2x_id = get_post_meta($meta['id'], '_image_2x', true);
		$image_3x_id = get_post_meta($meta['id'], '_image_3x', true);

		$image_2x = $tmf->image_url_from_id($image_2x_id);
		$image_3x = $tmf->image_url_from_id($image_3x_id);

		$retina_url = (!empty($image_2x) ? $image_2x .' 2x' : '') . (!empty($image_2x && $image_3x) ? ', ' : '') . (!empty($image_3x) ? $image_3x .' 3x' : '');
		?>
		<img class="sidebar-image <?php echo esc_attr($meta['css_classes']) ?>" src="<?php echo $image_url; ?>" <?php echo !empty($retina_url) ? 'srcset="'.$retina_url.'"' : '' ?>/>
		<?php
	}

endif; ?>
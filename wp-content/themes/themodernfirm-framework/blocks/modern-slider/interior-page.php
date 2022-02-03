<?php if( !empty($slide->_modernslider_metas) ): ?>
	<!-- Place somewhere in the <body> of your page -->
	<div class="modern-slider <?php $slide_class::generate_slider_css_classes($slide) ?> flexslider">
		  <ul class="slides">
	<?php
	foreach ($slide->_modernslider_metas as $meta) {
		if($meta['type'] == "custom") {
			?>
			<li>
				<?php echo do_shortcode($meta['custom']); ?>
			</li>
			<?php
		} else {
			$image_url = wp_get_attachment_image_src($meta['id'], 'full');
			$image_url = (is_array($image_url)) ? $image_url[0] : '';


			$image_2x_id = get_post_meta($meta['id'], '_image_2x', true);
			$image_3x_id = get_post_meta($meta['id'], '_image_3x', true);

			$image_2x = $tmf->image_url_from_id($image_2x_id);
			$image_3x = $tmf->image_url_from_id($image_3x_id);

			$retina_url = (!empty($image_2x) ? $image_2x .' 2x' : '') . (!empty($image_2x && $image_3x) ? ', ' : '') . (!empty($image_3x) ? $image_3x .' 3x' : '');
			?>
			<li class="<?php echo esc_attr($meta['css_classes']) ?>">
				<img src="<?php echo $image_url ?>" <?php echo !empty($retina_url) ? 'srcset="'.$retina_url.'"' : '' ?>/>
			</li>
			<?php
		}
	}

	?>
		</ul>
	</div>
<?php endif; ?>
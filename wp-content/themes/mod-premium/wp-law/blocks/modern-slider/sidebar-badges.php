<?php

if( !empty($slide->_modernslider_metas) ):

	?>

	<!-- Place somewhere in the <body> of your page -->

		<div class="modern-slider <?php $slide_class::generate_slider_css_classes($slide) ?> flexslider">

		  <ul class="slides">

	<?php

	foreach ($slide->_modernslider_metas as $meta) {

			$high_res = '';
			$image_path = get_attached_file($meta['id']); 
			$image = $tmf->image_url_from_id($meta['id']);
			$image_2x = str_replace('1x', '2x', $image_path);
			$image_3x = str_replace('1x', '3x', $image_path);
			$image_2x_url = ( file_exists($image_2x) ? str_replace('1x', '2x', $image) : '' );
			$image_3x_url = ( file_exists($image_3x) ? str_replace('1x', '3x', $image) : '' );

			$high_res = (!empty($image_2x) ? $image_2x_url .' 2x' : '') . (!empty($image_2x_url && $image) ? ', ' : '' ) . (!empty($image_3x) ? $image_3x_url .' 3x' : '');


		?>

		    <li>
                        <?php if ($meta['link']) : ?>
                        <a href="<?php echo $meta['link'] ?>" target="<?php echo $meta['link_target']?>">
                        <?php endif; ?>
                            <img src="<?php echo $image ?>" srcset="<?php echo $high_res ?>" alt="Best Accident and Injury Attorneys" />
                        <?php if ($meta['link']) : ?>
                        </a>
                        <?php endif; ?>

		    </li>

		<?php

	}



	?>

		</ul>

	</div>



	<?php

endif;

?>
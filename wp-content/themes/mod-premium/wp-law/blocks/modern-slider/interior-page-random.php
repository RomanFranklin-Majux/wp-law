<?php

if( !empty($slide->_modernslider_metas) ):

	// Get Random Image Array

	// Example: Array ( [type] => image [id] => 19 [title] => [description] => [link] => [link_target] => _self [img_alt] => [img_title] => [custom] => )

	$image = $slide->_modernslider_metas[array_rand($slide->_modernslider_metas)];

	// Get Image URL because we always save image ID's in the DB

	$high_res = '';
	$image_path = get_attached_file($image['id']); 
	$image = $tmf->image_url_from_id($image['id']);
	$image_2x = str_replace('1x', '2x', $image_path);
	$image_3x = str_replace('1x', '3x', $image_path);
	$image_2x_url = ( file_exists($image_2x) ? str_replace('1x', '2x', $image) : '' );
	$image_3x_url = ( file_exists($image_3x) ? str_replace('1x', '3x', $image) : '' );

	$high_res = (!empty($image_2x) ? $image_2x_url .' 2x' : '') . (!empty($image_2x_url && $image) ? ', ' : '' ) . (!empty($image_3x) ? $image_3x_url .' 3x' : '');

	?>

	<img class="sidebar-image" src="<?php echo $image ?>" srcset="<?php echo $high_res ?>" />

	<?php

endif;

?>
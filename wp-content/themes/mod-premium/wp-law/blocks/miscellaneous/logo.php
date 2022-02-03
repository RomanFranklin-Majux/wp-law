<a href="<?php echo SITE_URL ?>">
<?php 
	$high_res = '';
	$logo_path = get_attached_file($id); 
	$logo_2x = str_replace('1x', '2x', $logo_path);
	$logo_3x = str_replace('1x', '3x', $logo_path);
	$logo_2x_url = ( file_exists($logo_2x) ? str_replace('1x', '2x', $image) : '' );
	$logo_3x_url = ( file_exists($logo_3x) ? str_replace('1x', '3x', $image) : '' );

	$high_res = (!empty($logo_2x_url) ? $logo_2x_url .' 2x' : '') . (!empty($logo_2x_url && $logo_3x_url) ? ', ' : '' ) . (!empty($logo_3x_url) ? $logo_3x_url .' 3x' : '');
?>

	<img id="site-logo" class="logo" src="<?php echo $image ?>" srcset="<?php echo $high_res ?>" alt="<?php echo $tmf->wp_option()->blogname ?>"/>
</a>
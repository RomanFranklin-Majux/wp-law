<?php 
	if (!empty($facebook) || !empty($linkedin) || !empty($twitter) || !empty($avvo) || !empty($youtube) || !empty($instagram)): 
?>
	<span class="social-icons">

		<?php if (!empty($facebook)): ?>
			<a href="<?php echo $facebook ?>" target="_blank" title="View <?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s Facebook Page" alt="<?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s Facebook Page">
				<span class="icon facebook"></span>
			</a>			
		<?php endif ?>

		<?php if (!empty($linkedin)): ?>
			<a href="<?php echo $linkedin ?>" target="_blank" title="View <?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s LinkedIn Page" alt="<?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s LinkedIn Page">
				<span class="icon linked-in"></span>
			</a>			
		<?php endif ?>

		<?php if (!empty($twitter)): ?>
			<a href="<?php echo $twitter ?>" target="_blank" title="View <?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s Twitter Page" alt="<?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s Twitter Page">
				<span class="icon twitter"></span>
			</a>			
		<?php endif ?>

		<?php if (!empty($avvo)): ?>
			<a href="<?php echo $avvo ?>" target="_blank" title="View <?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s Avvo Page" alt="<?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s Avvo Page">
				<span class="icon avvo"></span>
			</a>			
		<?php endif ?>

		<?php if (!empty($youtube)): ?>
			<a href="<?php echo $youtube ?>" target="_blank" title="View <?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s YouTube Page" alt="<?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s YouTube Page">
				<span class="icon youtube"></span>
			</a>			
		<?php endif ?>

		<?php if (!empty($instagram)): ?>
			<a href="<?php echo $instagram ?>" target="_blank" class="instagram-icon" title="View <?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s Instagram Page" alt="<?php echo (!empty($name) ? $name : $tmf->wp_option()->blogname) ?>'s Instagram Page">
				<span class="icon instagram">
				    <i class="fab fa-instagram"></i>
				</span>
			</a>			
		<?php endif ?>

	</span>
<?php endif ?>
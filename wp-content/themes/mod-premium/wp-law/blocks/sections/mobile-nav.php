<?php if ($tmf->has_navigation('primary') && get_theme_mod('tmf_mobile_nav_general_use_menu')): ?>
	
	<?php
		global $tmf_option;
		$classes = '';

		// Set if clicking on parent item opens sub-menu
		if( get_theme_mod('tmf_mobile_nav_general_open_submenu') ) {
			$classes .=' mobile-menu-parent-link';
		}

		// Set menu opening style
		if( empty(get_theme_mod('tmf_mobile_nav_general_menu_location')) ) {
			$classes .=' mobile-menu-left';
		}else{
			$classes .=' mobile-menu-'. esc_html(get_theme_mod('tmf_mobile_nav_general_menu_location'));
		}

		// Set sub-menu icon
		if( get_theme_mod('tmf_mobile_nav_general_submenu_icon') == 'angle' ) {
			$classes .=' submenu-icon-angle-sign';
		}else{
			$classes .=' submenu-icon-plus-sign';
		}

	?>

	<?php $section = $tmf->section('mobile-nav') ?>

		<div class="menu-bar-container">

			<div class="menu-bar">
				<div class="hamburger-container">
					<div class="hamburger"></div>
				</div>
				<div class="menu-label">
					<?php echo get_theme_mod('tmf_mobile_nav_menu_button_label') ?>
				</div>
			</div>

		</div>

		<div class="mobile-menu-container">

			<div class="mobile-menu <?php echo $classes; ?>">

				<div class="top-part">
					<i class="fas fa-times mob-cancel-button"></i>

					<?php if( $mobile_nav_logo = get_theme_mod('tmf_mobile_nav_general_logo_image')): ?>
						<img src="<?php echo $tmf->image_url_from_id( $mobile_nav_logo ) ?>">
					<?php endif ?>

				</div>

				<div class="mobile-nav-info">
					<?php $tmf->module('mobile-nav-info')->render() ?>
				</div>

				<?php $tmf->navigation('mobile-nav')->render() ?>

				<?php if($tmf_option->mobile_nav_location): ?>
					<div class="mobile-location">
						<?php echo do_shortcode('[locations id="'. $tmf_option->mobile_nav_location_id .'" template="mobile"]') ?>
					</div>
				<?php endif ?>

			</div>

			<div class="mobile-menu-back-drop"></div>

		</div>

	<?php $section->close() ?>

<?php endif ?>

<?php if(get_theme_mod('tmf_mobile_nav_general_break_point')): ?>

<style type="text/css">
@media screen and (max-width: <?php echo get_theme_mod('tmf_mobile_nav_general_break_point') . 'px'; ?>){
	#mobile-nav-wrapper {
		display: block;
	}

	#primary-nav {
		display: none;
	}
}

<?php if($tmf_option->mobile_nav_location_bg_color): ?>
.tmf-post.location.mobile-location {
	background: <?php echo $tmf_option->mobile_nav_location_bg_color ?>;
}
<?php endif; ?>
<?php if($tmf_option->mobile_nav_location_text_color): ?>
.tmf-post.location.mobile-location,
.tmf-post.location.mobile-location a {
	color: <?php echo $tmf_option->mobile_nav_location_text_color ?> !important;
}
<?php endif; ?>
<?php if($tmf_option->mobile_nav_location_icons_color): ?>
.tmf-post.location.mobile-location .map-label,
.tmf-post.location.mobile-location .label {
	color: <?php echo $tmf_option->mobile_nav_location_icons_color ?>;
}
<?php endif; ?>
<?php if($tmf_option->mobile_nav_location_divider_color): ?>
.tmf-post.location.mobile-location .location-small-1 {
	border-color: <?php echo $tmf_option->mobile_nav_location_divider_color ?>;
}
.tmf-post.location.mobile-location .divider {
	background: <?php echo $tmf_option->mobile_nav_location_divider_color ?>;	
}
<?php endif; ?>
</style>

<?php endif; ?>
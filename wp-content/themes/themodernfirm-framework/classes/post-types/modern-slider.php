<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for modern slider.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_ModernSlider extends TMF_PostType {


	protected $post_type = 'modernslider';
  
  
	public $options	= array(
		'slug'						=> 'modernsliders',
		'singular'					=> 'Slider',
		'plural'					=> 'Modern Slider',
		'menu_name'					=> 'Modern Slider',
		'description'				=> 'Create and manage slides.',
		'hide_post_status'			=> TRUE,
		'bulk_actions'				=> TRUE,
		'exclude_from_search'		=> TRUE,
		'has_archive'				=> FALSE,
		'public'					=> FALSE,
		'show_in_nav_menus'			=> FALSE,
		'publicly_queryable'		=> FALSE,
		'has_seo'					=> FALSE,
		'show_thumbnail_in_table'	=> FALSE,
		'has_shortcode'				=> FALSE,
		'menu_icon'					=> 'dashicons-slides',
		'supports'					=> array('title'),
		'can_export'				=> FALSE
	);

	public $columns = array(
		'no_slides'			=> 'No. of Slides',
		'display_area'		=> 'Display Area'
	);


	public $metaboxes = array(
		'modern-slides' => array(),
		'modern-slider-shortcode' => array('context' => 'side'),
		'modern-slider-general-settings' => array('context' => 'side'),
	);


	public $admin_panels = array();

	public function column_no_slides ($query) {  
		global $post;

		$slides = get_post_meta($post->ID, '_modernslider_metas', true);

		$slides = is_array($slides) ? count($slides) : '0';

		return $slides;
	} 

	public function column_display_area ($query) {  
		global $post;

		$areas = TMF_ModernSlider::get_registered_areas();

		$area = get_post_meta($post->ID, '_slider_area', true);

		$area = !empty($area) ? $areas[$area] : 'No Area Assigned';

		return $area;
	} 

}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for Review Us.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_ReviewUs extends TMF_PostType{


	protected $post_type = 'review-us';
  
  
	public $options	= array(
		'slug'						=> 'review-us',
		'singular'					=> 'Review Us',
		'plural'					=> 'Review Us',
		'menu_name'					=> 'Review Us',
		'description'				=> 'Create and manage review us links.',
		'hide_post_status'			=> TRUE,
		'bulk_actions'				=> TRUE,
		'has_archive'				=> FALSE,
		'public'					=> FALSE,
		'show_in_nav_menus'			=> FALSE,
		'publicly_queryable'		=> FALSE,
		'has_seo'					=> FALSE,
		'show_thumbnail_in_table'	=> FALSE,
		'has_shortcode'				=> FALSE,
		'menu_icon'					=> 'dashicons-external',
		'supports'					=> array ('title')
	);

	public $columns = array();


	public $metaboxes = array(
		'review-us-settings'	=> array('context' => 'side'),
		'review-us-link'		=> array('priority' => 'high', 'context' => 'normal')
	);


	public $admin_panels = array(
		'review-us-settings'
	);

	public function column_display_rules ($query) {  
		global $post;

		if (!empty($post->tmf->display_rules[0]))
			return '<div class="dashicons dashicons-yes" style="color: green; font-size: 30px"></div>';
		else
			return '<div class="dashicons dashicons-minus" style="color: #ccc; font-size: 24px"></div>';

	} 

}

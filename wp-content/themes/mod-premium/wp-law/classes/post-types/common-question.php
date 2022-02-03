<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for modules.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2020 The Modern Firm, LLC
 */
class TMF_PostType_CommonQuestion extends TMF_PostType{


	protected $post_type = 'common-question';
  
  
	public $options	= array(
		'slug'						=> 'common-questions',
		'singular'					=> 'common question',
		'plural'					=> 'common questions',
		'menu_name'					=> 'Common Questions',
		'description'				=> 'Create and manage Common Questions',
		'hide_post_status'			=> TRUE,
		'bulk_actions'				=> TRUE,
		'has_archive'				=> FALSE,
		'public'					=> FALSE,
		'show_in_nav_menus'			=> FALSE,
		'publicly_queryable'		=> FALSE,
		'has_seo'					=> FALSE,
		'show_thumbnail_in_table'	=> FALSE,
		'has_shortcode'				=> TRUE,
		//'supports'					=> array ('title'),
		'menu_icon'				=> 'dashicons-editor-help'
	);

	public $columns = array();


	public $metaboxes = array();



}
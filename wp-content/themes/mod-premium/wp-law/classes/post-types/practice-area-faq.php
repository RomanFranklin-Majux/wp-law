<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for modules.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2020 The Modern Firm, LLC
 */
class TMF_PostType_PracticeAreaFaq extends TMF_PostType{


	protected $post_type = 'practice-area-faq';
  
  
	public $options	= array(
		'slug'						=> 'practice-area-faqs',
		'singular'					=> 'practice area faq',
		'plural'					=> 'practice area faqs',
		'menu_name'					=> 'Practice Area Faqs',
		'description'				=> 'Create and manage Practice Area Faqs',
		'hide_post_status'			=> TRUE,
		'bulk_actions'				=> TRUE,
		'has_archive'				=> FALSE,
		'public'					=> FALSE,
		'show_in_nav_menus'			=> FALSE,
		'publicly_queryable'		=> FALSE,
		'has_seo'					=> FALSE,
		'show_thumbnail_in_table'	=> FALSE,
		'has_shortcode'				=> TRUE,
		'menu_icon'				=> 'dashicons-editor-help'
	);

	public $columns = array();


	public $metaboxes = array();



}
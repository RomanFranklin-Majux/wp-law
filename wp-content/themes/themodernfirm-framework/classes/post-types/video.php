<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for videos.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Video extends TMF_PostType {


	protected $post_type = 'video';
  

	public $options	= array(
		'slug'					=> 'videos',
		'singular'				=> 'video',
		'plural'				=> 'videos',
		'menu_name'				=> 'Videos',
		'description'			=> 'Create and manage videos.',
		'no_posts'				=> 'There are currently no videos.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> TRUE,
		'bulk_actions'			=> TRUE,
		'show_in_nav_menus'		=> FALSE,
		'menu_icon'				=> 'dashicons-video-alt2'
	);


	public $metaboxes = array(
		'excerpt'				=> array('priority' => 'high', 'context' => 'normal'),
		'video-information'		=> array('context' => 'side'),
		'featured-images'		=> array('context' => 'side')
	);


	public $taxonomy = array(
		'video-categories'	=> array(
			'slug'					=> 'video-category',
			'label'					=> 'video Categories',
			'singular'				=> 'video category',
			'plural'				=> 'video categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> TRUE
		),
		'video-tags' => array(
			'slug'					=> 'video-tags',
			'label'					=> 'Ebook Tags',
			'singular'				=> 'video tags',
			'plural'				=> 'video tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)
	);


	public $admin_panels = array(
		'video-archive-settings',
		'video-settings'
	);

	public $linked_post_types = array(
		'practice-area'	=> 'Practice Areas'
	);


}

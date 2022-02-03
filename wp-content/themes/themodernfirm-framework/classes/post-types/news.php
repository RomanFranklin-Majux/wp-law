<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for news.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_News extends TMF_PostType{


	protected $post_type = 'news';
  

	public $options	= array(
		'slug'					=> 'news',
		'singular'				=> 'news',
		'plural'				=> 'news',
		'menu_name'				=> 'News',
		'description'			=> 'Create and manage news.',
		'no_posts'				=> 'There are currently no news.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> TRUE,
		'bulk_actions'			=> TRUE,
		'show_in_nav_menus'		=> FALSE,
		'menu_icon'				=> 'dashicons-welcome-widgets-menus'
	);


	public $metaboxes = array(
		'excerpt'				=> array('priority' => 'high', 'context' => 'normal'),
		'title-settings'		=> array('context' => 'side'),
		'featured-images'		=> array('context' => 'side')
	);


	public $taxonomy = array(
		'news-categories'	=> array(
			'slug'					=> 'news-category',
			'label'					=> 'News Categories',
			'singular'				=> 'news category',
			'plural'				=> 'news categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> TRUE,
			'hierarchical'			=> TRUE
		),
		'news-tags' => array(
			'slug'					=> 'news-tags',
			'label'					=> 'News Tags',
			'singular'				=> 'news tags',
			'plural'				=> 'news tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)
	);


	public $admin_panels = array(
		'news-archive-settings',
		'news-settings'
	);

	
	public $shortcode_options = array(
		'orderby'		=> 'date',
		'order'			=> 'DESC'
	);

}

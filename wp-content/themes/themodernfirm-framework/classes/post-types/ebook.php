<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for eBooks.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Ebook extends TMF_PostType {


	protected $post_type = 'ebook';
  

	public $options	= array(
		'slug'					=> 'eBooks',
		'singular'				=> 'eBook',
		'plural'				=> 'eBooks',
		'menu_name'				=> 'eBooks',
		'description'			=> 'Create and manage eBooks.',
		'no_posts'				=> 'There are currently no eBooks.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> TRUE,
		'bulk_actions'			=> TRUE,
		'show_in_nav_menus'		=> FALSE,
		'menu_icon'				=> 'dashicons-book'
	);


	public $metaboxes = array(
		'excerpt'				=> array('priority' => 'high', 'context' => 'normal'),
		'featured-images'		=> array('context' => 'side'),
		'ebook-upload'			=> array('context' => 'side')
	);


	public $taxonomy = array(
		'ebook-categories'	=> array(
			'slug'					=> 'ebook-category',
			'label'					=> 'eBook Categories',
			'singular'				=> 'eBook category',
			'plural'				=> 'eBook categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> TRUE
		),
		'ebook-tags' => array(
			'slug'					=> 'ebook-tags',
			'label'					=> 'Ebook Tags',
			'singular'				=> 'eBook tags',
			'plural'				=> 'eBook tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)
	);


	public $admin_panels = array(
		'ebook-archive-settings',
		'ebook-settings'
	);


}

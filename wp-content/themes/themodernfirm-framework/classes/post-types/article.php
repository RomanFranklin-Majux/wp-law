<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for article.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Article extends TMF_PostType {


	protected $post_type = 'article';
  

	public $options	= array(
		'slug'					=> 'article',
		'singular'				=> 'article',
		'plural'				=> 'articles',
		'menu_name'				=> 'Articles',
		'description'			=> 'Create and manage articles.',
		'no_posts'				=> 'There are currently no articles.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> TRUE,
		'bulk_actions'			=> TRUE,
		'show_in_nav_menus'		=> FALSE,
		'menu_icon'				=> 'dashicons-welcome-write-blog'
	);


	public $metaboxes = array(
		'excerpt'				=> array('priority' => 'high', 'context' => 'normal'),
		'title-settings'		=> array('context' => 'side'),
		'featured-images'		=> array('context' => 'side')
	);


	public $taxonomy = array(
		'article-categories'	=> array(
			'slug'					=> 'article-category',
			'label'					=> 'Article Categories',
			'singular'				=> 'article category',
			'plural'				=> 'article categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> TRUE,
			'hierarchical'			=> TRUE
		),
		'article-tags' => array(
			'slug'					=> 'article-tags',
			'label'					=> 'Article Tags',
			'singular'				=> 'article tags',
			'plural'				=> 'article tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)
	);


	public $admin_panels = array(
		'article-archive-settings',
		'article-settings'
	);


}

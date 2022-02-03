<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for representative cases.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_RepresentativeCase extends TMF_PostType{


	protected $post_type = 'representative-case';
  

	public $options	= array(
		'slug'					=> 'representative-cases',
		'singular'				=> 'representative case',
		'plural'				=> 'representative cases',
		'menu_name'				=> 'Rep. Cases',
		'description'			=> 'Create and manage representative cases.',
		'no_posts'				=> 'There are currently no representative cases.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> TRUE,
		'bulk_actions'			=> TRUE,
		'show_in_nav_menus'		=> FALSE,
		'menu_icon'				=> 'dashicons-testimonial'
	);


	public $metaboxes = array(
		'excerpt'				=> array('priority' => 'high', 'context' => 'normal'),
		'case-result'			=> array('priority' => 'high', 'context' => 'normal'),
		'title-settings'		=> array('context' => 'side'),
		'featured-images'		=> array('context' => 'side')
	);


	public $taxonomy = array(
		'representative-case-categories'	=> array(
			'slug'					=> 'representative-case-category',
			'label'					=> 'Case Categories',
			'singular'				=> 'case category',
			'plural'				=> 'case categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> TRUE,
			'hierarchical'			=> TRUE
		),
		'representative-case-tags' => array(
			'slug'					=> 'representative-case-tag',
			'label'					=> 'Case Tags',
			'singular'				=> 'case tag',
			'plural'				=> 'case tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)
	);


	public $admin_panels = array(
		'rep-cases-archive-settings',
		'rep-cases-settings'
	);


	public $linked_post_types = array(
		'practice-area'	=> 'Practice Areas',
		'attorney'		=> 'Attorneys'
	);

}

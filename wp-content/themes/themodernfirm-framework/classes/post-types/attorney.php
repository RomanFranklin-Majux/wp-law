<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for attorneys.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Attorney extends TMF_PostType{


	protected $post_type = 'attorney';
  

	public $options	= array(
		'slug'					=> 'attorneys',
		'singular'				=> 'attorney',
		'plural'				=> 'attorneys',
		'menu_name'				=> 'Attorneys',
		'description'			=> 'Create and manage attorneys.',
		'no_posts'				=> 'There are currently no attorney profiles.',
		'has_archive'			=> TRUE,
		'hide_post_status'		=> FALSE,
		'bulk_actions'			=> TRUE,
		'menu_icon'				=> 'dashicons-admin-users'
	);


	public $columns	= array(
		'linked_user' => 'Linked User'
	);


	public $metaboxes = array(
		'excerpt'						=> array('priority' => 'high', 'context' => 'normal'),
		'full-name'						=> array('priority' => 'high', 'context' => 'normal'),
		'attorney-contact-information'	=> array('priority' => 'high', 'context' => 'normal'),
		'attorney-links'				=> array('priority' => 'high', 'context' => 'normal'),
		'superlawyer'					=> array('priority' => 'high', 'context' => 'normal'),
		'attorney-settings'				=> array('context' => 'side'),
		'featured-images'				=> array('context' => 'side'),
		'resume'						=> array('context' => 'side')
	);


	public $taxonomy = array(
		'attorney-titles' => array(
			'slug'					=> 'attorney-titles',
			'label'					=> 'Attorney Job Titles',
			'singular'				=> 'attorney job title',
			'plural'				=> 'attorney job titles',
			'menu_name'				=> 'Job Titles',
			'show_in_nav_menus' 	=> TRUE,
			'hierarchical'			=> TRUE
		),
		'attorney-categories' => array(
			'slug'					=> 'attorney-category',
			'label'					=> 'Attorney Categories',
			'singular'				=> 'attorney category',
			'plural'				=> 'attorney categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> TRUE
		)
	);


	public $linked_post_types = array(
		'practice-area'	=> 'Practice Areas',
		'testimonial'	=> 'Testimonials',
		'location'		=> 'Secondary Locations',
		'representative-case' => 'Representative Cases'
	);


	public $admin_panels = array(
		'attorney-archive-settings',
		'attorney-settings'
	);


}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for staff.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Staff extends TMF_PostType{


	protected $post_type = 'staff';
  
  
	public $options	= array(
		'slug'					=> 'staff',
		'singular'				=> 'staff',
		'plural'				=> 'staff',
		'menu_name'				=> 'Staff',
		'description'			=> 'Create and manage staff.',
		'no_posts'				=> 'There are currently no staff profiles.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> TRUE,
		'bulk_actions'			=> TRUE,
		'menu_icon'				=> 'dashicons-groups'
	);


	public $columns	= array(
		'linked_user'	=> 'Linked User'
	);


	public $metaboxes = array(
		'excerpt'					=> array('priority' => 'high', 'context' => 'normal'),
		'full-name'					=> array('priority' => 'high', 'context' => 'normal'),
		'staff-contact-information'	=> array('priority' => 'high', 'context' => 'normal'),
		'staff-links'				=> array('priority' => 'high', 'context' => 'normal'),
		'staff-settings'			=> array('context' => 'side'),
		'featured-images'			=> array('context' => 'side'),
		'resume'					=> array('context' => 'side')
	);


	public $taxonomy = array(
		'staff-titles'	=> array(
			'slug'					=> 'staff-titles',
			'label'					=> 'Staff Job Titles',
			'singular'				=> 'staff job title',
			'plural'				=> 'staff job titles',
			'menu_name'				=> 'Job Titles',
			'show_in_nav_menus' 	=> TRUE,
			'hierarchical'			=> TRUE
		),
		'staff-categories'	=> array(
			'slug'					=> 'staff-category',
			'label'					=> 'Staff Categories',
			'singular'				=> 'staff category',
			'plural'				=> 'staff categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> TRUE
		)
	);


	public $linked_post_types = array(
		'practice-area'	=> 'Practice Areas',
		'testimonial'	=> 'Testimonials',
		'location'		=> 'Secondary Locations'
	);


	public $admin_panels = array(
		'staff-archive-settings',
		'staff-settings'
	);



}

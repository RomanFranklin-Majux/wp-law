<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for practice areas.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_PracticeArea extends TMF_PostType{


	protected $post_type = 'practice-area';
  

	public $options	= array(
		'slug'					=> 'practice-areas',
		'singular'				=> 'practice area',
		'plural'				=> 'practice areas',
		'menu_name'				=> 'Practice Areas',
		'description'			=> 'Create and manage practice area.',
		'no_posts'				=> 'There are currently no practice areas.',
		'hide_post_status'		=> FALSE,
		'bulk_actions'			=> TRUE,
		'has_archive'			=> TRUE,
		'hierarchical'			=> TRUE,
		'menu_icon'				=> 'dashicons-editor-ul'
	);
	

	public $metaboxes = array(
		'excerpt'					=> array('priority' => 'high', 'context' => 'normal'),
		'practice-area-settings'	=> array('context' => 'side'),
		'featured-images'			=> array('context' => 'side')
	);

	
	public $taxonomy = array(
		'practice-area-categories'	=> array(
			'slug'						=> 'practice-area-category',
			'label'						=> 'Practice Area Categories',
			'singular'					=> 'practice area category',
			'plural'					=> 'practice area categories',
			'menu_name'					=> 'Categories',
			'show_in_nav_menus' 		=> FALSE,
			'hierarchical'				=> TRUE
		)
	);


	public $linked_post_types = array(
		'attorney'				=> 'Attorneys',
		'staff'					=> 'Staff',
		'testimonial'			=> 'Testimonials',
		'faq'					=> 'FAQ\'s',
		'representative-case'	=> 'Representative Cases'
	);


	public $admin_panels = array(
		'practice-area-archive-settings',
		'practice-area-settings'
	);


	public $shortcode_options = array(
		'post_parent'	=> 0
	);
}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for testimonials.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Testimonial extends TMF_PostType{


	protected $post_type = 'testimonial';
  

	public $options	= array(
		'slug'					=> 'testimonials',
		'singular'				=> 'testimonial',
		'plural'				=> 'testimonials',
		'menu_name'				=> 'Testimonials',
		'description'			=> 'Create and manage testimonials.',
		'no_posts'				=> 'There are currently no testimonials.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> TRUE,
		'bulk_actions'			=> TRUE,
		'show_in_nav_menus'		=> FALSE,
		'menu_icon'				=> 'dashicons-awards'
	);


	public $metaboxes = array(
		'excerpt'				=> array('priority' => 'high', 'context' => 'normal'),
		'testimonial-info'		=> array('priority' => 'high', 'context' => 'normal'),
		'testimonial-settings'	=> array('context' => 'side'),
		'featured-images'		=> array('context' => 'side')
	);

	public $columns = array(
		'author_name'	=> 'Author Name',
		'description'	=> 'Description'
	);


	public $taxonomy = array(
		'testimonial-categories'	=> array(
			'slug'					=> 'testimonial-category',
			'label'					=> 'Testimonal Categories',
			'singular'				=> 'testimonial category',
			'plural'				=> 'testimonial categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> TRUE
		),
		'testimonial-tags' => array(
			'slug'					=> 'testimonial-tags',
			'label'					=> 'Testimonial Tags',
			'singular'				=> 'testimonial tags',
			'plural'				=> 'testimonial tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)
	);


	public $linked_post_types = array(
		'attorney'		=> 'Attorneys',
		'staff'			=> 'Staff',
		'practice-area'	=> 'Practice Areas'
	);


	public $admin_panels = array(
		'testimonial-archive-settings',
		'testimonial-settings'
	);


	public function column_author_name ($query) {
		global $post;

		if (!empty($post->tmf->author_name))
			return $post->tmf->author_name;
	}

	public function column_description ($query) {
		global $post;

		$build = array();
		if (!empty($post->tmf->description_1))
			$build[] = $post->tmf->description_1;

		if (!empty($post->tmf->description_2))
			$build[] = $post->tmf->description_2;

		return implode(' – ', $build);
	}


}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for locations.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Location extends TMF_PostType{


	protected $post_type = 'location';
  

	public $options	= array(
		'slug'					=> 'locations',
		'singular'				=> 'location',
		'plural'				=> 'locations',
		'menu_name'				=> 'Locations',
		'description'			=> 'Create and manage locations.',
		'no_posts'				=> 'There are currently no locations.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> TRUE,
		'bulk_actions'			=> TRUE,
		'menu_icon'				=> 'dashicons-location'
	);


	public $columns = array(
		'address' => 'Address'
	);


	public $metaboxes = array(
		'location-address'		=> array('priority' => 'high', 'context' => 'normal'),
		'location-contact'		=> array('priority' => 'high', 'context' => 'normal'),
		'location-settings'		=> array('context' => 'side'),
		'featured-images'		=> array('context' => 'side')

	);


	public $taxonomy = array(
		'location-categories'	=> array(
			'slug'					=> 'location-category',
			'label'					=> 'Location Categories',
			'singular'				=> 'location category',
			'plural'				=> 'location categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> TRUE
		)
	);


	public $linked_post_types = array(
		'attorney'		=> 'Attorneys',
		'staff'			=> 'Staff'
	);


	public $admin_panels = array(
		'location-archive-settings',
		'location-settings'
	);


	public $shortcode_options = array(
		'template'		=> 'small',
		'numberposts'	=> -1,
		'orderby'		=> 'menu_order',
		'order'			=> 'ASC'
	);


	public function column_address ($id) {
		$post = get_post($id);
		$data = '';

		if ($post->_building_name)
			$data .= $post->_building_name . '<br/>';

		if ($post->_address_1)
			$data .= $post->_address_1;

		if ($post->_address_2)
			$data .= ', ' . $post->_address_2;

		if ($post->_city)
			$data .= '<br/>' . $post->_city . ', ';

		if ($post->_state)
			$data .= $post->_state . ' ';

		if ($post->_zipcode)
			$data .= $post->_zipcode;
		
		return $data;

	}


}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for communities.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Communities extends TMF_PostType {


	protected $post_type = 'community';
  

	public $options	= array(
		'slug'					=> 'community',
		'singular'				=> 'community',
		'plural'				=> 'communities',
		'menu_name'				=> 'Communities',
		'description'			=> 'Create and manage communities we serve pages.',
		'no_posts'				=> 'There are currently no communities.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> FALSE,
		'bulk_actions'			=> TRUE,
		'show_in_nav_menus'		=> TRUE,
		'menu_icon'				=> 'dashicons-universal-access'
	);

	public $metaboxes = array();


	public $taxonomy = array();


	public $admin_panels = array();


}

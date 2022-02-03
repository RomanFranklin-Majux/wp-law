<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for quotes.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 * @since 2.0.1.2
 */
class TMF_PostType_Quote extends TMF_PostType {


	protected $post_type = 'quote';
  

	public $options	= array(
		'slug'					=> 'quotes',
		'singular'				=> 'quote',
		'plural'				=> 'quotes',
		'menu_name'				=> 'Quotes',
		'description'			=> 'Create and manage quotes.',
		'no_posts'				=> 'There are currently no quotes.',
		'hide_post_status'		=> FALSE,
		'has_archive'			=> FALSE,
		'bulk_actions'			=> TRUE,
		'public'				=> FALSE,
		'supports'				=> array('title', 'revisions')
	);


	public $metaboxes = array(
		'quote-information'		=> array('priority' => 'high'),
	);

}

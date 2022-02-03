<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for frequently asked question.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Faq extends TMF_PostType {


	protected $post_type = 'faq';
  

	public $options	= array(
		'slug'					=> 'frequently-asked-question',
		'singular'				=> 'frequently asked question',
		'plural'				=> 'frequently asked questions',
		'menu_name'				=> 'FAQ\'s',
		'description'			=> 'Create and manage frequently asked questions.',
		'no_posts'				=> 'There are currently no frequently asked questions.',
		'hide_post_status'		=> FALSE,
		'bulk_actions'			=> TRUE,
		'has_seo'				=> FALSE,
		'has_archive'			=> TRUE,
		'public'				=> TRUE,
		'show_in_nav_menus'		=> FALSE,
		'supports'				=> array('title'),
		'menu_icon'				=> 'dashicons-editor-help'
	);

	public $columns = array(
		'question'	=> 'Question',
		'answer'	=> 'Answer'
	);

	public $metaboxes = array(
		'faq' => array('priority' => 'high', 'context' => 'normal')
	);


	public $taxonomy = array(
		'faq-categories'	=> array(
			'slug'					=> 'faq-category',
			'label'					=> 'FAQ Categories',
			'singular'				=> 'FAQ category',
			'plural'				=> 'FAQ categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> TRUE,
			'hierarchical'			=> TRUE
		),
		'faq-tags' => array(
			'slug'					=> 'faq-tags',
			'label'					=> 'FAQ Tags',
			'singular'				=> 'FAQ tags',
			'plural'				=> 'FAQ tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)
	);


	public $admin_panels = array(
		'faq-archive-settings',
		'faq-settings'
	);

	public $linked_post_types = array(
		'practice-area'	=> 'Practice Areas'
	);


	public function column_question ($query) {  
		global $post;

		if (!empty($post->tmf->question))
			return TMF_Text::limit_chars($post->tmf->question, 100);
	} 

	public function column_answer ($query) {  
		global $post;

		if (!empty($post->tmf->answer))
			return TMF_Text::limit_chars(strip_tags($post->tmf->answer), 100);
	} 


}

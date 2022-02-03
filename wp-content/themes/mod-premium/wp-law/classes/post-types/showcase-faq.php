<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for frequently asked question.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2020 The Modern Firm, LLC
 */
class TMF_PostType_ShowcaseFaq extends TMF_PostType {


	protected $post_type = 'showcase-faq';
  

	public $options	= array(
		'slug'					=> 'showcase-faqs',
		'singular'				=> 'showcase faq',
		'plural'				=> 'showcase faqs',
		'menu_name'				=> 'Showcase FAQ\'s',
		'description'			=> 'Create and manage Showcase Faq.',
		'no_posts'				=> 'There are currently no Showcase Faqs.',
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
		'showcase-faq' => array('priority' => 'high', 'context' => 'normal'),
		'featured-images'				=> array('context' => 'side')
	);


	public $taxonomy = array(
		'showcase-faq-categories'	=> array(
			'slug'					=> 'showcase-faq-category',
			'label'					=> 'Showcase Faq Categories',
			'singular'				=> 'Showcase Faq category',
			'plural'				=> 'Showcase Faq categories',
			'menu_name'				=> 'Categories',
			'show_in_nav_menus' 	=> TRUE,
			'hierarchical'			=> TRUE
		),
		'showcase-faq-tags' => array(
			'slug'					=> 'showcase-faq-tags',
			'label'					=> 'Showcase Faq Tags',
			'singular'				=> 'Showcase Faq tags',
			'plural'				=> 'Showcase Faq tags',
			'menu_name'				=> 'Tags',
			'show_in_nav_menus' 	=> FALSE,
			'hierarchical'			=> FALSE
		)
	);


	public $admin_panels = array(
		'showcase-faq-archive-settings',
		'showcase-faq-settings'
	);

// 	public $linked_post_types = array(
// 		'practice-area'	=> 'Practice Areas'
// 	);


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
<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Base class used to generate shortcodes.
 * 
 * This class will take care of generating the shortcode. Needs to be
 * extended via another class.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostTypeShortcode {

	private $post_type;

	private $options = array(
		'template'				=> 'small',
		'numberposts'			=> -1,
		'orderby'				=> 'menu_order',
		'order'					=> 'ASC',
		'suppress_filters'		=> FALSE
	);

	private $added_opions = array();


	private $loaded_options = array();


	private $data;


	private $error;


	public function __construct ($shortcode, $post_type, $options = array()) {
		$this->post_type		= $post_type;
		$this->added_opions		= array_merge($this->options, $options); 

		add_shortcode($shortcode, array($this, 'run_shortcode'));
		// Register Custom Shortcodes for shortcode ultimate
		add_filter( 'su/data/shortcodes', array($this, 'register_su_shortcode') );
	}

	public static function register_su_shortcode( $shortcodes ) {
		global $TMF_Shortcodes;

		$member_shortcodes = array('member-account', 'member-edit-profile', 'member-login', 'member-profile-url');

		// Choices loop
		foreach ( $TMF_Shortcodes as $name => $shortcode ) {
			$get_shortcode_name = (!empty($shortcode['post_type']) ? $shortcode['post_type'] : "");

			if( !empty($get_shortcode_name) && !in_array($get_shortcode_name, array('post','page'), true ) && get_option('tmf_post_type_'.str_replace('-', '_', $get_shortcode_name)) == "0" ):
				// return nothing
			else:
				if(( in_array($name, $member_shortcodes) && get_option('tmf_post_type_member') == "0" )) {
					// do not load member shortcodes since members post-type is not yet active
				} else {
					$shortcodes[$name] = $shortcode;
					$shortcodes[$name]['group'] = 'tmf';
					//$shortcodes[$name]['function'] = $this->run_shortcode();
				}
			endif;
		}

	  // Return modified data
	  return $shortcodes;
	}


	public function run_shortcode ($options = array()) {
		global $tmf, $post;

		if (!empty($options['current_author']) && strtolower($options['current_author']) == 'true')
			$options['author'] = $post->post_author;

		/* NEET TO REFINE */
		if (!empty($options['include'])):
			$options['post__in'] = explode(',', $options['include']);
			$options['orderby'] = 'post__in';
			// For some reason WordPress is adding post_parent=0 by default
			// And that causes odd bug with post__in so we need to always set post_parent='' (empty)
			// For post__in to work so we check if post_parent is not defined in shortcode attributes and add here
			if(!array_key_exists('post_parent', $options)) {
				$options['post_parent'] = null;
			}
		endif;

		if (!empty($options['exclude']))
			$options['post__not_in'] = explode(',', $options['exclude']);

		// merge options
		$this->loaded_options = (object) array_merge((array) $this->added_opions, (array) $options); 
		$this->loaded_options->post_type = $this->post_type;

		// check if a single field was requested
		if (isset($this->loaded_options->field)):
			$this->loaded_options->field = TMF_Text::underscores($this->loaded_options->field);
			$this->loaded_options->numberposts = 1;
		endif;

		// check for taxonomy
		if (isset($this->loaded_options->taxonomy) && isset($this->loaded_options->terms)):
			$this->loaded_options->tax_query = array(
				array(
					'taxonomy'	=> $this->loaded_options->taxonomy,
					'field'		=> 'slug',
					'terms'		=> explode(',', $this->loaded_options->terms),
					'operator'	=> 'IN'
				)
			);

		endif;

		if (!empty($options['linked'])):

			if ($options['linked'] == 'attorneys')					$linked = 'attorney';
			if ($options['linked'] == 'staff')						$linked = 'staff';
			if ($options['linked'] == 'practice-areas') 			$linked = 'practice_area';
			if ($options['linked'] == 'locations') 					$linked = 'location';
			if ($options['linked'] == 'representative-cases') 		$linked = 'representative_case';
			if ($options['linked'] == 'testimonials') 				$linked = 'testimonial';
			if ($options['linked'] == 'frequently-asked-questions') $linked = 'frequently_asked_question';

			$this->loaded_options->post_type = str_replace('_', '-', $linked);

			if (empty($options['id'])):
				$this->loaded_options->post__in = $post->tmf->{'_linked_post_' . $linked};
			else:
				$this->loaded_options->post__in = TMF_Post::factory(array('id' => $options['id'], 'post_type' => $this->post_type, 'orderby' => 'menu_order'))->to_single()->{'_linked_post_' . $linked};
				unset($this->loaded_options->id);
			endif;

		endif;

		// get posts from DB
		$posts = new TMF_Post((array)$this->loaded_options);

		if (empty($posts->to_array()) && isset($options['no_posts_message'])):
			return '<div class="no-posts-message">'. $options['no_posts_message'] .'</div>';
		endif;

		// if a single field was requested
		if (isset($this->loaded_options->field))
			return $posts->to_field($this->loaded_options->field, TRUE, FALSE);

		// assume it was a multi post request
		else
			return $posts
				->template($this->loaded_options->template)
				->render(FALSE); 

	}

}

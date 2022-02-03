<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/** 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 * @since Version 2.0.1.0
 */
class TMF_PostLink {

	const ATTORNEYS				= 'attorney';
	const STAFF					= 'staff';
	const PRACTICE_AREAS		= 'practice-area';
	const TESTIMONIALS			= 'testimonial';
	const LOCATIONS				= 'location';
	const REPRESENTATIVE_CASES	= 'representative-case';


	private $post;

	private $linked_post_type;

	private $linked_posts = array();

	private $post_template;


	public function __construct($specific_post = NULL, $linked_post_type = NULL) {
		global $post;

		$current_post			= (empty($specific_post)) ? $post : $specific_post;
		$this->post				= $current_post;
		$this->linked_post_type = $linked_post_type;
	}


	public static function factory ($specific_post = NULL, $linked_post_type = NULL) {
		return new TMF_PostLink($specific_post, $linked_post_type);
	}


	private function get_posts (){

		if (empty($this->linked_posts)):
			$linked = $this->post->{'_linked_post_' . str_replace('-', '_', $this->linked_post_type)};
				
			// If post type is a location, add the primary location to the beginning of the list.
			if ($this->linked_post_type == TMF_PostLink::LOCATIONS):

				if (empty($linked))
					$linked = array();

				if (isset($this->post->{'_primary_location'}))
					array_unshift($linked, $this->post->{'_primary_location'});
			endif;

			if (!empty($linked)):
				$args = array(
					'post__in'			=> $linked,
					'numberposts'		=> -1,
					'post_type'			=> $this->linked_post_type,
					'post_status'		=> 'publish',
					'orderby'			=> 'post__in',
					'suppress_filters'	=> FALSE
				);
				$this->linked_posts = TMF_Post::factory($args)->to_array();
			endif;

		endif;

		return $this->linked_posts;
	}


	public function to_array () {
		return $this->get_posts();
	}


	public function template($template = 'medium') {
		$this->post_template = $template;

		return $this;
	}


	public function render ($prefix = '', $separator = ',', $links = TRUE, $echo = TRUE) {

		$posts = $this->get_posts();

		if ($this->post_template !== NULL && !empty($posts)):
			$html = TMF_Post::factory($this->get_posts())
				->template($this->post_template)
				->render($echo);

			if ($echo == FALSE)
				return $html;

			return;

		endif;

		$html_list = array();

		foreach ($posts as $post):

			// If links is TRUE, then wrap the taxonomy item into a link
			if ($links)
				$html_list[] = '<a href="'. $post->tmf->permalink .'" class="tmf-post-link" title="Click for more '. $post->tmf->title .' information">' . $post->tmf->title  .'</a>';
			
			// Otherwise, display just the taxonomy name
			else
				$html_list[] = '<span class="tmf-post-link">' . $post->tmf->title  .'</span>';

		endforeach;

		$separator	= ($separator) ? '<span class="separator">' .$separator . '</span> ' : NULL;
		$html		= implode($separator, $html_list);

		// If a prefix was supplied, prepend it as a label for the list
		$prefix = ($prefix) ? '<span class="post-link-label label">'. $prefix .'&nbsp;</span>' : NULL;

		if (!empty($html)):
			$html = '<div class="tmf-post-link-list '. $this->linked_post_type .'">' . $prefix  . $html . '</div>';

			if (!$echo)
				return $html;

			echo $html;
		endif;
	}


}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Provides functions for all post taxonomies
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 * @since Version 2.0.1.0
 */
class TMF_Taxonomy {

	const CATEGORIES				= 'category';
	const TAGS						= 'post_tag';
	const NEWS_CATEGORIES			= 'news-categories';
	const NEWS_TAGS					= 'news-tags';
	const EVENT_CATEGORIES			= 'event-categories';
	const EVENT_TAGS				= 'event-tags';
	const ATTORNEY_JOB_TITLES		= 'attorney-titles';
	const ATTORNEY_CATEGORIES		= 'attorney-categories';
	const STAFF_JOB_TITLES			= 'staff-titles';
	const STAFF_CATEGORIES			= 'staff-categories';
	const PRACTICE_AREA_CATEGORIES	= 'practice-area-categories';
	const TESTIMONIAL_CATEGORIES	= 'testimonial-categories';
	const TESTIMONIAL_TAGS			= 'testimonial-tags';
	const LOCATION_CATEGORIES		= 'location-categories';
	const ARTICLE_CATEGORIES		= 'article-categories';
	const ARTICLE_TAGS				= 'article-tags';

	private $post;

	private $taxonomy_type;

	private $taxonomy_exclude = array();
	private $taxonomy_include = array();


	private $taxonomy_items = array();


	public function __construct($specific_post = NULL, $taxonomy_type = NULL) {
		global $post;

		$current_post			= (empty($specific_post)) ? $post : $specific_post;
		$this->post				= $current_post;
		$this->taxonomy_type	= $taxonomy_type;
	}


	public static function factory ($specific_post = NULL, $taxonomy_type = NULL) {
		return new TMF_Taxonomy($specific_post, $taxonomy_type);
	}

	private function get_post_terms (){
		if (empty($this->taxonomy_items))
			$this->taxonomy_items = wp_get_post_terms($this->post->ID, $this->taxonomy_type);

		$this->filter_post_terms();

		return $this->taxonomy_items;
	}


	private function filter_post_terms () {
		// check for terms to include
		if (!empty($this->taxonomy_include)):
			foreach ($this->taxonomy_items as $key => $taxonomy):
				if (!in_array($taxonomy->term_id, $this->taxonomy_include) && !in_array($taxonomy->slug, $this->taxonomy_include)):
					unset($this->taxonomy_items[$key]);
				endif;
			endforeach;
		endif;

		// check for terms to exclude
		if (!empty($this->taxonomy_exclude)):
			foreach ($this->taxonomy_items as $key => $taxonomy):
				if (in_array($taxonomy->term_id, $this->taxonomy_exclude) || in_array($taxonomy->slug, $this->taxonomy_exclude)):
					unset($this->taxonomy_items[$key]);
				endif;
			endforeach;
		endif;
	}

	public function filter ($type = NULL, $settings = array()) {
		// include
		if (strtolower($type) == 'include'):
			$this->taxonomy_include = (array) $settings;
		endif;

		// exclude
		if (strtolower($type) == 'exclude'):
			$this->taxonomy_exclude = (array) $settings;
		endif;

		return $this;
	}


	public function to_array () {
		return $this->get_post_terms();
	}


	public function render ($prefix = '', $separator = ',', $links = TRUE, $echo = TRUE) {
		global $tmf_option;
		$html_list = array();

		foreach ($this->get_post_terms() as $term):

			// If links is TRUE, then wrap the taxonomy item into a link
			if ($links)
				$html_list[] = '<a href="'. get_term_link($term, $this->taxonomy_type) .'" class="tmf-taxonomy tmf-taxonomy-'. $term->term_id .' tmf-taxonomy-'. $term->slug .'" title="Click for more '. $term->name .' information">' . $term->name  .'</a>';
			
			// Otherwise, display just the taxonomy name
			else
				$html_list[] = '<span class="tmf-taxonomy tmf-taxonomy-'. $term->term_id .' tmf-taxonomy-'. $term->slug .'">' . $term->name  .'</span>';

		endforeach;

		$separator	= ($separator) ? '<span class="separator">' .$separator . '</span> ' : NULL;
		$html		= implode($separator, $html_list);

		// If a prefix was supplied, prepend it as a label for the list
		$prefix = ($prefix) ? '<span class="taxonomy-label label">'. $prefix .'&nbsp;</span>' : NULL;

		if (!empty($html)):
			$html = '<div class="tmf-taxonomy-list '. $this->taxonomy_type .'">' . $prefix  . $html . '</div>';

			if (!$echo)
				return $html;

			echo $html;
		endif;
	}


}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Provides an object to generate page breadcrumbs.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Breadcrumb {


	/**
	 * @var  string   holds the breadcrumb data
	 */
	private $breadcrumb;

	/**
	 * @var  integer   holds current breadcrumb position
	 */
	private $position;


	/**
	 * @var  array   HTML templates used for the breadcrumb parts
	 */
	public $templates = array(
		'link'		=> '<a href="%s" itemprop="item"><span itemprop="name">%s</span></a>',
		'current'	=> '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="s"><span class="current" itemprop="name">%s</span><meta itemprop="position" content="%s" /></span>',
		'standard'	=> '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="s">%s<meta itemprop="position" content="%s" /></span>',
		'before'	=> '<div id="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">',
		'after'		=> '</div>',
		'separator'	=> '<span class="delimiter"> » </span>'
	);


	/**
	 * @var  array   options for the breadcrumbs
	 */
	public $options	= array(
		'char_limit'	=> 30,
		'show_pagenum'	=> true,
		'show_htfpt'	=> false
	);


	/**
	 * @var  array   strings used to generate breadcrumbs
	 */
	public $strings	= array(
		'home'		=> 'Home',
		'search'	=> array(
			'singular'	=> 'Search Result for: %s',
			'plural'	=> 'Search Results for: %s'
		),
		'category'	=> 'Category: %s',
		'tagged'	=> 'Tagged: %s',
		'paged'		=> 'Page: %d',
		'404'		=> 'Error 404'
	);


	/**
	 * Creates a new breadcrumb generator
	 * 
	 * 	$breadcrumbs = new TMF_Breadcrumb();
	 * 	$breadcrumbs->render();
	 *
	 * @param   array   $templates   HTML template parts
	 * @param   array   $options   breadcrumb options
	 * @param   array   $strings   strings used to generate parts
	 * @return  void
	 */
	public function __construct($templates = array(), $options = array(), $strings = array()) {
		$this->templates = wp_parse_args($templates, $this->templates);
		$this->options = wp_parse_args($options, $this->options);
		$this->strings = wp_parse_args($strings, $this->strings);
	}


	/**
	 * Creates a new breadcrumb generator
	 * 
	 * 	TMF_Breadcrumb::factory()->render();
	 *
	 * @param   array   $templates   HTML template parts
	 * @param   array   $options   breadcrumb options
	 * @param   array   $strings   strings used to generate parts
	 * @return  object
	 */
	public static function factory($templates = array(), $options = array(), $strings = array()) {
		return new TMF_Breadcrumb($templates, $options, $strings);
	}


	/**
	 * Renders the breadcrumbs to HTML
	 *
	 * @return  void
	 */
	public function render() {
		global $tmf_option;

		if (empty($this->breadcrumb))
			$this->build();

		$breadcrumb = implode($this->templates['separator'], $this->breadcrumb);

		// if breadcrumbs have been enabled in the theme
		if (isset($tmf_option->breadcrumbs))
			echo $this->templates['before'] . $breadcrumb . $this->templates['after'];
	}


	/**
	 * Formats the breadcrumb part using the correct template
	 *
	 * @param   string|array   $item   the name or an array containing more data
	 * @param   string   $type   the breadcrumb template to use
	 * @return  string
	 */
	protected function template($item, $type = 'standard') {
		if (is_array($item))
			$type = 'link';

		if(!empty($this->breadcrumb)) {
			if("link" != $type) {
				$this->position++;
			}
		}

		switch ($type):
			case'link':
				return $this->template(sprintf($this->templates['link'], esc_url($item['link']), TMF_Text::limit_chars($item['title'], $this->options['char_limit'])));
				break;
			case 'current':
				return sprintf($this->templates['current'], TMF_Text::limit_chars($item, $this->options['char_limit']), $this->position);
				break;
			case 'standard':
				return sprintf($this->templates['standard'], $item, $this->position);
				break;
		endswitch;
	}


	/**
	 * Builds all the parents for a breadcrumb item
	 *
	 * @param   string   $term_id
	 * @param   string   $taxonomy
	 * @return  void
	 */
	protected function build_parents( $term_id, $taxonomy ) {
		$parent_ids = array_reverse(get_ancestors( $term_id, $taxonomy));
		foreach ($parent_ids as $parent_id):
			$term = get_term( $parent_id, $taxonomy );
			$this->breadcrumb["archive_{$taxonomy}_{$parent_id}"] = $this->template( array(
				'link'		=> get_term_link( $term->slug, $taxonomy ),
				'title'		=> $term->name
			));
		endforeach;
	}


	/**
	 * Builds the breadcrumbs and sets them depending on the type of page
	 *
	 * @return  void
	 */
	public function build() {
		global $tmf_option, $wp_query, $tmf;

		//$post_type = $wp_query->query_vars['post_type'];
		// FIX: use TMF's method instead of WP's
		$post_type = $tmf->request()->post_type();
		$queried_object = get_queried_object();
		$this->options['show_pagenum'] = ($this->options['show_pagenum'] && is_paged()) ? true : false;


		// Home & Front Page
		$this->breadcrumb['home'] = $this->template($this->strings['home'], 'current');
		$home_linked = $this->template(array(
								'link'	=> home_url('/'),
								'title'	=> $this->strings['home']
							));

		// Home and Front Page
		if (get_option('show_on_front') == 'posts'):
			if (!is_home() || $this->options['show_pagenum']):
				$this->breadcrumb['home']	= $home_linked;
			endif;
		else:
			if (!is_front_page())
				$this->breadcrumb['home'] = $home_linked;

			if (is_home() && !$this->options['show_pagenum'])

				// If we have alternate breadcrumb text, show that
				if(!empty($tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'})):

					$this->breadcrumb['blog'] = $this->template($tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'}, 'current');
				else:
					// Show the archive title otherwise
					$this->breadcrumb['blog'] = $this->template($tmf_option->{str_replace('-','_', $post_type) . '_archive_title'}, 'current');
				endif;

			if (('post' == $post_type && !is_search() && !is_home()) || ('post' == $post_type && $this->options['show_pagenum']))

				// If we have alternate breadcrumb text, show that
				if(!empty($tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'})):

					$this->breadcrumb['blog'] = $this->template(array(
															'link'  => get_permalink(get_option('page_for_posts')),
															'title' => $tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'}
														));
				else:
					// Show the archive title otherwise
					$this->breadcrumb['blog'] = $this->template(array(
									'link'  => get_permalink(get_option('page_for_posts')),
									'title' => $tmf_option->{str_replace('-','_', $post_type) . '_archive_title'}
								));
				endif;
		endif;


		// Post Type Archive as index
		if (is_singular() || (is_archive() && !is_post_type_archive()) || is_search() || $this->options['show_pagenum']):
			if(!is_home()):
				if ($post_type_link = get_post_type_archive_link($post_type)):

					// If we have alternate breadcrumb text, show that
					if(!empty($tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'})):

						$post_type_label = (!empty($tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'}))? $tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'} : get_post_type_object( $post_type )->labels->name;
					else:
						// Show the archive title otherwise
						$post_type_label = (!empty($tmf_option->{str_replace('-','_', $post_type) . '_archive_title'}))? $tmf_option->{str_replace('-','_', $post_type) . '_archive_title'} : get_post_type_object( $post_type )->labels->name;
					endif;

					$this->breadcrumb["archive_{$post_type}"] = $this->template(array(
																	'link'  => $post_type_link,
																	'title' => $post_type_label
																));
				endif;
			endif;
		endif;


		// Posts, (Sub)Pages, Attachments and Custom Post Types
		if (is_singular()):

			if (!is_front_page()):
				if ($this->options['show_htfpt']):
					$_id			= $queried_object->ID;
					$_post_type = $post_type;

					if (is_attachment()):
						$_id			= $queried_object->post_parent;
						$_post_type = get_post_type($_id);
					endif;

					$taxonomies = get_object_taxonomies($_post_type, 'objects');
					$taxonomies = array_values(wp_list_filter($taxonomies, array('hierarchical' => true)));

					if (!empty($taxonomies)):
						$taxonomy	= $taxonomies[0]->name;
						$terms		= get_the_terms($_id, $taxonomy);

						if (!empty($terms)):
							$terms	= array_values($terms);
							$term		= $terms[0];

							if ($term->parent != 0):
								$this->build_parents($term->term_id, $taxonomy);
							endif;

							$this->breadcrumb["archive_{$taxonomy}"] = $this->template( array(
																							'link'  => get_term_link( $term->slug, $taxonomy ),
																							'title' => $term->name
																						));
						endif;
					endif;
				endif;

				// Get Parents
				if ($queried_object->post_parent != 0):
					$parents = array_reverse(get_post_ancestors($queried_object->ID));

					foreach ($parents as $parent):
						$this->breadcrumb["archive_{$post_type}_{$parent}"] = $this->template(array(
																									'link'  => get_permalink( $parent ),
																									'title' => get_the_title( $parent )
																								));
					endforeach;
				endif;

				$this->breadcrumb["single_{$post_type}"] = $this->template(get_the_title(), 'current');
			endif;

		// Search
		elseif (is_search()):
			$total	= $GLOBALS['wp_query']->found_posts;
			$text	= sprintf(_n(
								$this->strings['search']['singular'],
								$this->strings['search']['plural'],
								$total
							),
							get_search_query()
						);

			$this->breadcrumb['search'] = $this->template($text, 'standard');

			if ($this->options['show_pagenum']):
				$this->breadcrumb['search'] = $this->template(array(
																'link'  => home_url( '?s=' . urlencode(get_search_query(false))),
																'title' => $text
															));
			endif;

		// All archive pages
		elseif (is_archive()):
			// Categories, Tags and Custom Taxonomies
			if (is_category() || is_tag() || is_tax()):
				$taxonomy = $queried_object->taxonomy;

				if ($queried_object->parent != 0 && is_taxonomy_hierarchical($taxonomy)):
					$this->build_parents($queried_object->term_id, $taxonomy);
				endif;

				$this->breadcrumb["archive_{$taxonomy}"] = $this->template($queried_object->name, 'current');

				if ($this->options['show_pagenum']):
					$this->breadcrumb["archive_{$taxonomy}"] = $this->template(array(
																				'link'  => get_term_link($queried_object->slug, $taxonomy),
																				'title' => $queried_object->name
																			));
				endif;

			// Date archive
			elseif (is_date()):
				if (is_year()):
					$this->breadcrumb['archive_year']	= $this->template(get_the_date('Y'), 'current');

					if ($this->options['show_pagenum']):
						$this->breadcrumb['archive_year'] = $this->template(array(
																			'link'  => get_year_link(get_query_var('year')),
																			'title' => get_the_date('Y')
																		));
					endif;
				elseif (is_month()):
					$this->breadcrumb['archive_year'] = $this->template(array(
																	'link'  => get_year_link(get_query_var('year')),
																	'title' => get_the_date('Y')
																));
					$this->breadcrumb['archive_month'] = $this->template(get_the_date('F'), 'current');

					if ($this->options['show_pagenum']):
						$this->breadcrumb['archive_month'] = $this->template(array(
																		'link'  => get_month_link(get_query_var('year'), get_query_var('monthnum')),
																		'title' => get_the_date('F')
																	));
					endif;
				elseif (is_day()):
					$this->breadcrumb['archive_year'] = $this->template(array(
																	'link'  => get_year_link(get_query_var('year')),
																	'title' => get_the_date('Y')
																));
					$this->breadcrumb['archive_month'] = $this->template(array(
																	'link'  => get_month_link(get_query_var('year'), get_query_var('monthnum')),
																	'title' => get_the_date('F')
																));
					$this->breadcrumb['archive_day'] = $this->template(get_the_date('j'));

					if ($this->options['show_pagenum']):
						$this->breadcrumb['archive_day']	= $this->template(array(
																		'link'  => get_month_link(
																			get_query_var('year'),
																			get_query_var('monthnum'),
																			get_query_var('day')
																		),
																		'title' => get_the_date('F')
																	));
					endif;
				endif;

			// Custom Post Type Archive
			elseif (is_post_type_archive() && !is_paged()):
				$post_type = $wp_query->query_vars['post_type'];

				// If we have alternate breadcrumb text, show that
				if(!empty($tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'})):

					$post_type_label = (!empty($tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'}))? $tmf_option->{str_replace('-','_', $post_type) . '_alternate_breadcrumb_text'} : get_post_type_object( $post_type )->labels->name;
				else:
					// Show the archive title otherwise
					$post_type_label = (!empty($tmf_option->{str_replace('-','_', $post_type) . '_archive_title'}))? $tmf_option->{str_replace('-','_', $post_type) . '_archive_title'} : get_post_type_object( $post_type )->labels->name;
				endif;

				
				$this->breadcrumb["archive_{$post_type}"] = $this->template($post_type_label, 'current');
			
			// Author archive
			elseif (is_author()):
				$this->breadcrumb['archive_author'] = $this->template($queried_object->display_name, 'current');
			endif;

		// Error 404
		elseif (is_404()):
			$this->breadcrumb['404']	= $this->template($this->strings['404'], 'current');
		endif;

		if ($this->options['show_pagenum'])
			$this->breadcrumb['paged']	= $this->template(sprintf(
														$this->strings['paged'], 
														get_query_var('paged')), 
														'current'
													);
	}
}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Request {

	private $query;

	public function __construct() {
		global $wp_query;
		$this->query = $wp_query;
	}

	public static function factory() {
		return new TMF_Request();
	}

	public function post_type () {
		if ($this->query->is_home()) {
			return 'post';
		}

		return $this->query->query_vars['post_type'];
	}

	public function parent_post () {
		return $this->query->query_vars['post_parent'];
	}

	public function is_home_page () {
		return $this->query->is_front_page();
	}

	public function is_page () {
		return $this->query->is_page();
	}

	public function is_single_post () {
		return $this->query->is_singular();
	}

	public function is_post_type ($type = NULL) {
		return ($type == $this->query->query_vars['post_type']);
	}

	public function is_directory ($type = NULL) {
		if (!empty($type)):
			return ($type == $this->query->query_vars['post_type'] && ($this->query->is_archive() || $this->query->is_home()));
		endif;

		return ($this->query->is_archive() || $this->query->is_home());
	}

	public function is_archive () {
		return $this->query->is_archive();
	}

	public function is_search () {
		return $this->query->is_search();
	}

	public function is_taxonomy () {
		return ($this->query->is_tax() || $this->query->is_category() || $this->query->is_tag());
	}

	public function is_post_directory () {
		return $this->query->is_home();
	}

	public function is_id ($id) {
		global $posts;

		if ($this->is_single_post() && $posts[0])
			return $posts[0]->ID == $id;
	}

	public function paged () {
		return $this->query->query_vars['paged'];
	}

	public function id () {
		return $this->query->query_vars['page_id'];
	}

	public function has_posts () {
		return !empty($this->query->posts);
	}

	public function max_number_of_pages () {
		return $this->query->max_num_pages;
	}

	public function post_count () {
		return $this->query->found_posts;
	}

	public function search_query () {
		return get_search_query();
	}

	public function queried_object () {
		return $this->query->get_queried_object();
	}

	public function title ($head_title = FALSE, $echo = TRUE) {
		global $tmf, $posts;
		$queried_object = $this->queried_object();
		$build			= array();

		// outputs the title HTML element, if requested
		if ($head_title == TRUE):
			if ($this->is_directory()):
				echo '<title>' . $tmf->directory()->title() . ' » '. $tmf->wp_option()->blogname .'</title>';
				return;
			else:
				?><title><?php wp_title() ?></title><?php
				return;
			endif;
		endif;

		if ($this->is_single_post() || $this->is_page()):
			$build[] = $posts[0]->tmf->title;
		
		elseif ($this->is_directory()):
			$build[] = $tmf->directory()->title();

			if ($this->is_taxonomy()):
				$build[] = $queried_object->name;
			endif;

		elseif ($this->is_search()):
			$search		= 'Search: %s<div class="search-result-count">Displaying %d %s</div>';
			$post_count = $this->post_count();
			$build[]	= sprintf($search, $this->search_query(), $post_count, TMF_Text::plural('Result', 'Results', $post_count));
		endif;

		$title = implode('<span class="title-arrow"> » </span>', $build);

		if ($echo == TRUE)
			echo '<h1 id="page-title">' .  $title . '</h1>';

		return $title;
	}
}

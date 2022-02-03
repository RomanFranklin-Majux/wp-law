<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/** 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Author {

	private $post;

	private $author;


	public function __construct($post) {
		$this->post = $post;
	}

	
	public static function factory ($post) {
		return new TMF_Author($post);
	}


	public function get_author (){

		if (empty($this->author)):
			$args = array(
				'numberposts'		=> 1,
				'meta_key'			=> '_linked_user',
				'meta_value'		=> $this->post->post_author,
				'post_type'			=> array('attorney','staff'),
				'suppress_filters'	=> FALSE
			);
			$user = TMF_Post::factory($args)->to_array();

			$this->author = (isset($user[0])) ? $user[0] : NULL;
		endif;

		return $this->author;
	}


	public function to_array (){
		return $this->get_author();
	}


	public function render ($prefix = 'Posted By', $separator = ',', $links = TRUE, $echo = TRUE) {
		$html		= '';
		$author		= $this->get_author();

		if (!empty($author)):

			$html .= '<div class="tmf-author">';

			if ($author->tmf->has_thumbnail_image()):
				if ($links)
					$html .= '<a href="'. $author->tmf->permalink .'" title="View '. $author->tmf->person_name .'\'s Profile">';

				$html .= '<img class="author-thumbnail" src="'. $author->tmf->thumbnail_image_url .'" />';

				if ($links)
					$html .= '</a>';
			endif;

			$html .= '<div class="author-name-container">';

			if (!empty($prefix))
				$html .= '<div class="author-label label">'. $prefix .' </div>';

			if ($links)
				$html .= '<a href="'. $author->tmf->permalink .'" title="View '. $author->tmf->person_name .'\'s Profile">';

			$html .= '<div class="author-name">'. $author->tmf->person_name .'</div>';

			if ($links)
				$html .= '</a>';
			
			$html .= '</div><div class="clear"></div></div>';

			if (!$echo)
				return $html;

			echo $html;

		endif;

	}
}

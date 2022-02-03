<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/** 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Shortcode {


	private static $shortcodes = array(
		'business-name' 		=> 'render_business_name',
		'copyright'				=> 'render_copyright',
		'date'					=> 'render_date',
		'current-year'			=> 'render_current_year',
		'slogan'				=> 'render_slogan',
		'facebook-url'			=> 'render_facebook_url',
		'linkedin-url'			=> 'render_linkedin_url',
		'twitter-url'			=> 'render_twitter_url',
		'youtube-url'			=> 'render_youtube_url',
		'avvo-url'				=> 'render_avvo_url',
		'superlawyers-url'		=> 'render_superlawyers_url',
		'best-lawyers-url'		=> 'render_best_lawyers_url',
		'martindale-url'		=> 'render_martindale_url',
		'taxonomies'			=> 'render_taxonomies',
		'taxonomy-children'		=> 'render_taxonomy_children',
		'tag-cloud'				=> 'render_tag_cloud',
		'logo'					=> 'render_logo',
		'module'				=> 'render_module',
		'review-us'				=> 'render_review_us',
		'form'					=> 'render_form',
		'wp-option'				=> 'render_wp_option',
		'tmf-option'			=> 'render_tmf_option',
		'social-icons'			=> 'render_social_icons',
		'payment-icons'			=> 'render_payment_icons',
		'vimeo'					=> 'render_vimeo',
		'youtube'				=> 'render_youtube',
		'search'				=> 'render_search',
		'author'				=> 'render_author',
		'rss'					=> 'render_rss',
		'slideshow'				=> 'render_slideshow',
		'avvo-badge'			=> 'render_avvo',
		'member-login'			=> 'render_member_login',
		'member-account'		=> 'render_member_account',
		'member-edit-profile'	=> 'render_member_edit_profile',
		'member-profile-url'	=> 'render_member_profile_url',
		'stars'					=> 'render_stars',
		'modernslider'			=> 'render_modernslider'
	);


	public static function actions () {
		foreach (self::$shortcodes as $shortcode_name => $shortcode_function):
			add_shortcode($shortcode_name, array('TMF_Shortcode', $shortcode_function));
		endforeach;
	}

	
	public static function cleanup_content ($content) {
		$array		= array('<p>[' => '[', ']</p>' => ']', ']<br />' => ']', ']<br>' => ']');
		$content	= strtr($content, $array);
		return $content;
	}


	public static function render($text) {
		return do_shortcode($text);
	}


	public static function render_business_name () {
		global $wp_option;
		return '<span class="tmf-shortcode business-name">'. $wp_option->blogname .'</span>';
	}


	public static function render_slogan () {
		global $wp_option;
		return '<span class="tmf-shortcode slogan">'. $wp_option->blogdescription .'</span>';
	}


	public static function render_copyright () {
		global $wp_option;
		return '<span class="tmf-shortcode copyright">© '. date('Y') .' '. $wp_option->blogname .'</span>';
	}


	public static function render_current_year ($options = array()) {
		$defaults = array(  
			'year' => '0'
		);

		$options = is_array($options) ? array_merge($defaults, $options) : $defaults;

		$date = strtotime(intval($options['year']) . "year");
		return '<span class="tmf-shortcode year">'. date('Y', $date) .'</span>';
	}

	public static function render_date ($options = array()) {
		$defaults = array(  
			'time' => 'now',
			'format' => 'm-d-Y'
		);

		$options = is_array($options) ? array_merge($defaults, $options) : $defaults;

		$date = strtotime($options['time']);
		return '<span class="tmf-shortcode current-date">'. date($options['format'], $date) .'</span>';
	}


	public static function render_facebook_url () {
		global $tmf_option;
		return $tmf_option->facebook;
	}


	public static function render_linkedin_url () {
		global $tmf_option;
		return $tmf_option->linkedin;
	}


	public static function render_twitter_url () {
		global $tmf_option;
		return $tmf_option->twitter;
	}


	public static function render_youtube_url () {
		global $tmf_option;
		return $tmf_option->youtube;
	}


	public static function render_avvo_url () {
		global $tmf_option;
		return $tmf_option->avvo;;
	}


	public static function render_superlawyers_url () {
		global $tmf_option;
		return $tmf_option->superlawyers;
	}


	public static function render_best_lawyers_url () {
		global $tmf_option;
		return $tmf_option->best_lawyers;
	}


	public static function render_martindale_url () {
		global $tmf_option;
		return $tmf_option->martindale;
	}


	public static function render_logo () {
		global $tmf_option;
		return '<a href="'. SITE_URL .'"><img class="logo" src="'. wp_get_attachment_url($tmf_option->logo) .'" alt="'. $wp_option->blogname .'"/></a>';
	}


	public static function render_vimeo ($options = array()) {
		$defaults = array(  
			'id'  				=> '',
			'width'				=> 300,
			'height'			=> 200,
			'placeholder_src'	=> '',
			'ui_color'			=> 'ffffff'
		);

		$options = is_array($options) ? array_merge($defaults, $options) : $defaults;
		$ratio = round(100 / ($options['width'] / $options['height']), 2, PHP_ROUND_HALF_UP);

		if (!empty($options['placeholder_src']))
			return '<img class="video-light-box vimeo" src="' . $options['placeholder_src'] . '" data-video-url="//player.vimeo.com/video/'. $options['id'] .'?title=0&amp;byline=0&amp;portrait=0&amp;color='. $options['ui_color'] .'&autoplay=true" data-video-id="'. $options['id'] .'" data-video-ratio="'. $ratio .'" />';

		return '<div class="tmf-video vimeo" style="max-width: '.$options['width'].'px;"><div data-responsive-padding="'. $ratio  .'%"><iframe src="//player.vimeo.com/video/'. $options['id'] .'?title=0&amp;byline=0&amp;portrait=0&amp;color='. $options['ui_color'] .'" frameborder="0" allowfullscreen></iframe></div></div>';
	}


	public static function render_youtube ($options = array()) {
		$defaults = array(  
			'id'  				=> '',
			'width'				=> 300,
			'height'			=> 200,
			'placeholder_src'	=> '',
			'title'				=> '',
			'description'		=> ''
		);

		$options = is_array($options) ? array_merge($defaults, $options) : $defaults;
		$ratio = round(100 / ($options['width'] / $options['height']), 2, PHP_ROUND_HALF_UP);

		$response = TMF_Admin_Shortcodes::get_youtube_video_info($options['id']);
		$data = json_decode($response, true);

		if($data) {

			$title = $data['items'] ? $data['items'][0]['snippet']['title'] : '';
			$description = $data['items'] ? $data['items'][0]['snippet']['description'] : '';
			$published = $data['items'] ? $data['items'][0]['snippet']['publishedAt'] : '';

			$video_title = !empty($options['title']) ? esc_attr( $options['title'] ) : $title;
			$video_description = !empty($options['description']) ? esc_attr($options['description']) : $description;

			$thumbnail = 'https://img.youtube.com/vi/'. $options['id'] .'/0.jpg';

			$video_object = '<script type="application/ld+json">{
				"@context": "http://schema.org",
				"@type": "VideoObject",
				"name": "'. $video_title .'",
				"description": "'. $video_description .'",
				"thumbnailUrl": "'. $thumbnail .'",
				"uploadDate": "'. $published .'",
				"embedUrl": "https://' . $domain . '/embed/' . $options['id'] . '"
			}</script>';
		} else {
			$video_object = '';
		}

		if (!empty($options['placeholder_src']))
			return $video_object .'<img class="video-light-box youtube" src="' . $options['placeholder_src'] . '" data-video-url="//www.youtube.com/embed/'. $options['id'] .'?autoplay=1&rel=0" data-video-id="'. $options['id'] .'" data-video-ratio="'. $ratio .'" />';

		return $video_object .'<div class="tmf-video youtube" style="max-width: '.$options['width'].'px;"><div data-responsive-padding="'. $ratio  .'%"><iframe src="//www.youtube.com/embed/'. $options['id'] .'?rel=0" frameborder="0" allowfullscreen></iframe></div></div>';
	}


	public static function render_wp_option ($options = array()) {
		global $wp_option;

		if (isset($options['key']) && isset($wp_option->{$options['key']}))
			return '<span class="tmf-shortcode wp-option-'. TMF_Text::dashes($options['key']) .'">'. $wp_option->{$options['key']} .'</span>';
	}


	public static function render_tmf_option ($options = array()) {
		global $tmf_option;

		if (isset($options['key']) && isset($tmf_option->{$options['key']}))
			return '<span class="tmf-shortcode tmf-option-'. TMF_Text::dashes($options['key']) .'">'. $tmf_option->{$options['key']} .'</span>';
	}


	public static function render_module ($options = array()) {
		$module		= TMF_Post::factory(array('id' => $options['id'], 'post_type' => 'module'))->to_array();
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';

		if (empty($module))
			return '<div class="missing-module tmf-warning">Module not found.</div>';

		return TMF_Block::factory('miscellaneous/module' . $template)
					->set('module', $module[0])
					->render(FALSE);
	}


	public static function render_review_us ($options = array()) {
		if(isset($options['id'])){
			$id = $options['id'];
		}else{
			$id = '';
		}
		$review_us		= TMF_Post::factory(array('id' => $id, 'post_type' => 'review-us', 'orderby' => 'menu_order', 'order' => 'ASC'))->to_array();
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';

		if (empty($review_us))
			return '<div class="missing-review-us tmf-warning">Review Us not found.</div>';

		return TMF_Block::factory('miscellaneous/review-us' . $template)
					->set('reviews', $review_us)
					->render(FALSE);
	}


	public static function render_taxonomies ($options = array()) {
		$taxonomies	= get_categories($options);
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';
		$show_count 	= isset($options['show_count']) && 'true' === $options['show_count'] ? TRUE : FALSE;
		$before 	= isset($options['before']) && 'true' === $options['before'] ? TRUE : FALSE;

		if (empty($taxonomies))
			return 'There are currently no items.';

		return TMF_Block::factory('miscellaneous/taxonomies' . $template)
					->set('show_count', $show_count)
					->set('before', $before)
					->set('taxonomies', $taxonomies)
					->render(FALSE);
	}


	public static function render_taxonomy_children ($options = array()) {
		$taxonomies	= get_term_children($options['term_id'], $options['taxonomy']);
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';

		if (empty($taxonomies))
			return 'There are currently no items.';

		$taxonomy_objs = array();

		foreach ($taxonomies as $taxonomy_id):
			$taxonomy_objs[] = get_term_by('id', $taxonomy_id, $options['taxonomy']);
		endforeach;

		//print_r($taxonomy_objs);

		return TMF_Block::factory('miscellaneous/taxonomy-children' . $template)
					->set('taxonomies', $taxonomy_objs)
					->render(FALSE);
	}


	public static function render_tag_cloud ($options = array()) {
		$defaults = array(  
			'unit'		=> 'em',
			'smallest'	=> 1,
			'largest'  	=> 2,
			'format'	=> 'array'
		);

		$options	= is_array($options) ? array_merge($defaults, $options) : $defaults;
		$tags		= wp_tag_cloud($options);
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';

		return TMF_Block::factory('miscellaneous/tag-cloud' . $template)
					->set('tags', $tags)
					->render(FALSE);
	}


	public static function render_author ($options = array()) {
		global $tmf, $post;

		$template 	= isset($options['template']) ? '-' . $options['template'] : '';
		$author		= $tmf->author($post)->to_array();

		if (empty($author))
			return '<div class="missing-author tmf-warning">The author of this item could not be located.</div>';


		return TMF_Block::factory('post-types/' . $author->post_type .'/author' . $template)
					->set('post', $author->tmf)
					->render(FALSE);
	}


	public static function render_rss ($options = array()) {
		$defaults = array(  
			'url'			=> '',
			'limit'			=> 3,
			'char_limit'	=> 250
		);

		include_once(ABSPATH . WPINC . '/feed.php');

		$options	= is_array($options) ? array_merge($defaults, $options) : $defaults;
		$rss		= fetch_feed($options['url']);

		if (is_wp_error($rss))
			return 'RSS feed not found.';

		$maxitems	= $rss->get_item_quantity($options['limit']); 
		$rss_items	= $rss->get_items(0, $maxitems);
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';

		return TMF_Block::factory('miscellaneous/rss' . $template)
					->set('feed', $rss_items)
					->set('char_limit', $options['char_limit'])
					->render(FALSE);
	}


	public static function render_slideshow ($options = array()) {
		$defaults = array(  
			'images' 		=> '',
			'random'		=> 'false',
			'speed'			=> 6000,
			'fade_duration' => 1000,
			'class'			=> '',
			'id'			=> ''
		);

		if (empty($options['id']))
			$options['id'] = 'tmf-slideshow-' . TMF_Text::random_string();

		$id			= (empty($options['id'])) ? 'tmf-slideshow' . $num : $options['id'];
		$options	= is_array($options) ? array_merge($defaults, $options) : $defaults;
		$image_ids	= array_reverse(explode(',', str_replace(' ', '', $options['images'])));
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';
		$random		= (strtolower($options['random']) == 'true') ? TRUE : FALSE;
		$images		= array();

		foreach ($image_ids as $image):
			$images[] = wp_get_attachment_url($image);
		endforeach;

		return TMF_Block::factory('miscellaneous/slideshow' . $template)
					->set('images', $images)
					->set('random', $random)
					->set('speed', $options['speed'])
					->set('fade_duration', $options['fade_duration'])
					->set('class', $options['class'])
					->set('id', $options['id'])
					->render(FALSE);
	}


	public static function render_payment_icons ($options = array()) {
		global $tmf_option;

		$template = isset($options['template']) ? '-' . $options['template'] : '';
		
		return TMF_Block::factory('miscellaneous/payment-icons' . $template)
					->set('visa', $tmf_option->visa)
					->set('mastercard', $tmf_option->visa)
					->set('discover', $tmf_option->discover)
					->set('american_express', $tmf_option->american_express)
					->set('paypal', $tmf_option->paypal)
					->render(FALSE);
	}


	public static function render_social_icons ($options = array()) {
		global $tmf_option;

		$template = isset($options['template']) ? '-' . $options['template'] : '';

		return TMF_Block::factory('miscellaneous/social-icons' . $template)
					->set('facebook', $tmf_option->facebook)
					->set('linkedin', $tmf_option->linkedin)
					->set('twitter', $tmf_option->twitter)
					->set('youtube', $tmf_option->youtube)
					->set('instagram', $tmf_option->instagram)
					->set('avvo', $tmf_option->avvo)
					->render(FALSE);
	}


	public static function render_avvo ($options = array()) {
		$defaults = array(  
			'avvo_id'	=> '',
			'type'		=> 'rating',
			'specialty' => '1'
		);

		$options	= is_array($options) ? array_merge($defaults, $options) : $defaults;
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';

		return TMF_Block::factory('miscellaneous/avvo-badge' . $template)
					->set('avvo_id', $options['avvo_id'])
					->set('type', $options['type'])
					->set('specialty', $options['specialty'])
					->render(FALSE);
	}


	public static function render_search ($options = array()) {
		$defaults = array(  
			'post_type'		=> '',
			'placeholder'	=> 'Search our blog'
		);

		$options	= is_array($options) ? array_merge($defaults, $options) : $defaults;
		$template 	= isset($options['template']) ? '-' . $options['template'] : '';

		return TMF_Block::factory('miscellaneous/search-form' . $template)
					->set('post_type', $options['post_type'])
					->set('placeholder', $options['placeholder'])
					->render(FALSE);
	}


	public static function render_form ($atts) {
		global $tmf_option, $post;

		$default_values = array();

		$options = shortcode_atts( array(
			'id' => '',
			'formhash' => '',
			'username' => '',
			'placeholder' => ''
		), $atts );

		if (isset($options['default_values']))
			$default_values = explode('&', $options['default_values']);

		if (isset($options['attorney_email']) && $post->post_type == 'attorney' && is_single() && !empty($post->tmf->email))
			$default_values[] = $options['attorney_email'] . '=' . $post->tmf->email;

		if (isset($options['current_page']))
			$default_values[] = $options['current_page'] . '=' . get_permalink($post->ID);

		if (isset($options['id']))
			$options['formhash'] = $options['id'];

		if (empty($options['formhash']) && isset($tmf_option->contact_form_id))
			$options['formhash'] = $tmf_option->contact_form_id;

		if (empty($options['username']))
			$options['username'] = 'websitecontact';

		if (isset($tmf_option->contact_form_placeholder))
			$options['placeholder'] = str_replace('}', '</a>', str_replace('{', '<a href="http://websitecontact.wufoo.com/forms/'. $options['formhash'] .'">', $tmf_option->contact_form_placeholder));

		$default_values = implode('&', $default_values);
		$template		= isset($options['template']) ? '-' . $options['template'] : '';

		if (empty($options['formhash']))
			return '<div class="missing-form-id tmf-warning">No form ID has been set.</div>';

		return TMF_Block::factory('miscellaneous/form' . $template)
					->set('formhash', $options['formhash'])
					->set('placeholder', $options['placeholder'])
					->set('username', $options['username'])
					->set('default_values', $default_values)
					->render(FALSE);
	}


	public static function render_member_login () {
		$member = TMF_AssociationMember::instance();

		return TMF_Block::factory('association/member-login')
			->set('member', $member)
			->render(FALSE);
	}


	public static function render_member_profile_url () {
		$member = TMF_AssociationMember::instance();
		if (!empty($member->data->permalink)):
			return $member->data->permalink;
		endif;
	}


	public static function render_member_edit_profile () {
		$member = TMF_AssociationMember::instance();

		$current_professional_areas = array();

		foreach (get_the_terms($member->data->ID, 'professional-areas') as $tax):
			$current_professional_areas[] = $tax->term_id;
		endforeach;


		$terms = get_terms('professional-areas', array('parent' => 0, 'hide_empty' => FALSE));
		$professional_areas = array();

		foreach ($terms as $term):
			$professional_areas[$term->term_id]['id'] = $term->term_id;
			$professional_areas[$term->term_id]['name'] = $term->name;
			$professional_areas[$term->term_id]['sub_areas'] = array();

			$subterms = get_terms('professional-areas', array('parent' => $term->term_id, 'hide_empty' => FALSE));

			foreach ($subterms as $subterm):
				$professional_areas[$term->term_id]['sub_areas'][$subterm->term_id]['id']	= $subterm->term_id;
				$professional_areas[$term->term_id]['sub_areas'][$subterm->term_id]['name'] = $subterm->name;
			endforeach;
		endforeach;

		return TMF_Block::factory('association/member-edit')
			->set('member', $member)
			->set('current_professional_areas', $current_professional_areas)
			->set('professional_areas', $professional_areas)
			->render(FALSE);
	}


	public static function render_member_account () {
		$member = TMF_AssociationMember::instance();

		return TMF_Block::factory('association/member-account')
			->set('member', $member)
			->render(FALSE);
	}


	public static function render_modernslider ($options = array()) {
		global $tmf;

		return $tmf->slider($options['id'])->render(FALSE);
	}


	/* Renders Star HTML entity */
	public static function render_stars ($options = array()) {
		$return = '';
		if (isset($options['limit'])):
			$return = '<span class="stars">';
			for($i = 1; $i <= $options['limit']; $i++) {
				$return = $return. "&starf;";
			}
			$return .= '</span>';
		endif;

		return $return;
	}

}

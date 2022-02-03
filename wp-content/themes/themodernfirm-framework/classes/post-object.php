<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * This class acts as a wrapper for WP_Post objects.
 * By wrapping a WP_Post object, we can add new methods and virtual values directly to WP_Post.
 * This allows us to make better use of Object Oriented practices while leaving all the database heavy lifting to 
 * existing Wordpress database API.
 * 
 * The TMF_PostObject is added to the WP_Post object as a variable called 'tmf'. We have to do it this way because
 * the WP_Post class is set as 'final' and cannot be extended. We also cannot return any objects other than
 * WP_Post objects using 'the_posts' action because Wordpress expects and checks for WP_Post.
 * 
 * The templating engine will pass $post->tmf directly to the templates as $post. For our purposes,
 * it's as if we extended the WP_Post class and added our own methods.
 * 
 * If you're attempting to access this object outside of the templating engine or from
 * an admin panel, you can access it as $post->tmf.
 * 
 * Instead of having to use the Wordpress functional based post methods we can now do the following:
 * 
 * $post->content, $post->excerpt;
 * -- Instead of --
 * the_content(), the_excerpt(); 
 * 
 * Also, keys for meta values no longer have to be prefixed with an underscore.
 * 
 * $post->_phone becomes $post->phone
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 * @since Version 2.0.1.0
 */
class TMF_PostObject {


	private $wp_post;


	public static function actions () {
		add_action('the_posts', array('TMF_PostObject', 'wrap_post_objects'), 99999);
	}


	public function __construct($wp_post) {
		$this->wp_post = $wp_post;
	}


	public function __get($key) {
		// First, Check generic WP_Post for key
		if (isset($this->wp_post->{$key}))
			return $this->wp_post->{$key};

		// Second, check for meta data
		$meta = get_post_meta($this->wp_post->ID, '_' . $key, TRUE);
		if ($meta != '')
			return $meta;

		// Third, check for unprefixed meta data
		$meta = get_post_meta($this->wp_post->ID, $key, TRUE);
		if ($meta != '')
			return $meta;

		// Fourth, check for virtual field
		if (method_exists($this, 'virtual_field_' . $key))
			return $this->{'virtual_field_' . $key}();

	}


	public function __isset($key) {
		return empty($this->{$key});
	}


	private function virtual_field_permalink () {
		global $tmf_option;

		$post_archive_link = $tmf_option->{TMF_Text::underscores($this->post_type) . '_archive_link'};

		// Check for directory redirect
		if (!empty($post_archive_link) && $post_archive_link == TRUE)
			return get_post_type_archive_link($this->post_type);


		return get_permalink($this->id);
	}


	private function virtual_field_id () {
		return $this->ID;
	}


	private function virtual_field_title () {
		if (!empty($this->alternate_title) && ($this->template == 'large' || $this->templage == 'home'))
			return $this->alternate_title;

		return $this->post_title;	
	}

	private function virtual_alternate_title () {
		if (!empty($this->alternate_title))
			return $this->alternate_title;

		return $this->post_title;	
	}


	private function virtual_field_content () {
		global $tmf_option;

		$content = do_shortcode($this->post_content);

		$content = TMF_Shortcode::cleanup_content($content);



		// Remove double spaces from content if not disabled
		if(empty($tmf_option->allow_extra_sapces) || $tmf_option->allow_extra_sapces == '0') {
			$content = str_replace('  ', ' ', $content);
			$content = str_replace("&nbsp;", " ", $content);
			$content = str_replace("\n", " ", $content);
			// Strip all on-ASCII characters from the input string
			// Commented because it appears as if the regex is replacing some non English characters
			//$content = preg_replace('/[\x00-\x1F\x80-\xFF]/u', ' ', $content);
			// https://stackoverflow.com/a/48558101/2176214
			$cleaned_content = preg_replace('/[\x00-\x09\x0B-\x1F\x7F\xA0]/u', ' ', $content);

			// The /u flag makes content empty if the html is not valid UTF-8
			// The behavior is weird so fix is below
			// https://www.php.net/manual/en/reference.pcre.pattern.modifiers.php
			$content = !empty($cleaned_content) ? $cleaned_content : $content;
			$content = trim(preg_replace('/\s\s+/', ' ', $content));
		}

		return $content;
	}


	private function virtual_field_excerpt () {
		global $tmf_option;
			
		if (!empty($tmf_option->{TMF_Text::underscores($this->post_type) . '_excerpt_length'}) && $tmf_option->{TMF_Text::underscores($this->post_type) . '_excerpt_force_trim'} == TRUE):
			return $this->excerpt($tmf_option->{TMF_Text::underscores($this->post_type) . '_excerpt_length'});
		endif;

		return $this->excerpt();
	}


	private function virtual_field_resume_url () {
		if (in_array($this->post_type, array('attorney', 'staff')))
			return wp_get_attachment_url($this->_resume);
	}


	private function virtual_field_vcard_url () {
		if (in_array($this->post_type, array('attorney', 'staff')))
			return $this->permalink . '?vcard=true';
	}


	private function virtual_field_person_full_name () {
		if (!in_array($this->post_type, array('attorney', 'staff', 'member')))
			return;

		$name = array();

		if (isset($this->prefix))
			$name[] = $this->prefix;

		if (isset($this->first_name))
			$name[] = $this->first_name;

		if (isset($this->middle_name))
			$name[] = $this->middle_name;

		if (isset($this->last_name))
			$name[] = $this->last_name;

		if (isset($this->suffix))
			$name[] = $this->suffix;

		return trim(implode(' ', $name));
	}


	private function virtual_field_person_name () {
		if (!in_array($this->post_type, array('attorney', 'staff', 'member')))
			return;

		// Use Display Name
		if (!empty($this->display_name))
			return $this->display_name;

		// Use Full Name
		if (!empty($this->person_full_name))
			return $this->person_full_name;

		// Fallback using post title
		if (!empty($this->title))
			return $this->title;
	}


	private function virtual_field_primary_image_url () {
		if (!empty($this->primary_image)):
			$extension = ($this->primary_image_type) ? $this->primary_image_type : 'jpg';
			return UPLOADS_URI . PRIMARY_IMAGES_PATH . $this->primary_image . '-'. $this->ID .'.' . $extension;
		endif;
	}


	private function virtual_field_thumbnail_image_url () {
		//clearstatcache();

		if (!empty($this->thumbnail_image)):
			$thumb_extension = ($this->thumbnail_image_type) ? $this->thumbnail_image_type : 'jpg';
			$prim_extension = ($this->primary_image_type) ? $this->primary_image_type : 'jpg';

			$prim_image_path =  UPLOADS_PATH . PRIMARY_IMAGES_PATH . $this->primary_image . '-'. $this->ID .'.' . $prim_extension;
			$thumb_image_path =  UPLOADS_PATH . THUMBNAIL_IMAGES_PATH . $this->thumbnail_image . '-'. $this->ID .'.' . $thumb_extension;

			$prim_image =  UPLOADS_URI . PRIMARY_IMAGES_PATH . $this->primary_image . '-'. $this->ID .'.' . $prim_extension;
			$thumb_image =  UPLOADS_URI . THUMBNAIL_IMAGES_PATH . $this->thumbnail_image . '-'. $this->ID .'.' . $thumb_extension;
			if(file_exists($thumb_image_path)) {
				return $thumb_image;
			}elseif(file_exists($prim_image_path)){
				return $prim_image;
			}
		endif;
	}


	private function virtual_field_primary_image_alt () {
		
		if (!empty($this->primary_image)):
			$alt_tags = trim( strip_tags( get_post_meta( $this->primary_image, '_wp_attachment_image_alt', true ) ) );
		endif;

		if(!empty($alt_tags)) {
			return $alt_tags;
		}elseif ( in_array($this->post_type, array('attorney', 'staff', 'member')) ) {
			return $this->person_name ."'s Profile Image";
		}else {
			return TMF_Text::limit_chars($this->title, 25);
		}
	}


	private function virtual_field_thumbnail_image_alt () {
		
		if (!empty($this->thumbnail_image)):
			$alt_tags = trim( strip_tags( get_post_meta( $this->thumbnail_image, '_wp_attachment_image_alt', true ) ) );
		endif;

		if(!empty($alt_tags)) {
			return $alt_tags;
		}elseif ( in_array($this->post_type, array('attorney', 'staff', 'member')) ) {
			return $this->person_name ."'s Profile Image";
		}else {
			return TMF_Text::limit_chars($this->title, 25);
		}
	}


	private function virtual_field_map_address () {
		if ($this->post_type == 'location' && empty($this->custom_map_address)):
			return rawurlencode($this->address_1 . ' ' . $this->city . ', ' . $this->_state . ' ' . $this->_zipcode);
		else:
			return rawurlencode($this->custom_map_address);
		endif;
	}

	private function virtual_field_testimonial_description () {
		if (!in_array($this->post_type, array('testimonial')))
			return;

		$build = array();
		
		if (!empty($this->author_name))
			$build[] = $this->author_name;

		if (!empty($this->description_1))
			$build[] = $this->description_1;

		if (!empty($this->description_2))
			$build[] = $this->description_2;

		$build = implode(', ', $build);

		if (!empty($build))
			return '&ndash; ' . $build;
	}


	private function virtual_field_phone_1_label () {
		global $tmf_option;

		if ($this->post_type == 'attorney' && !empty($tmf_option->attorney_label_phone_1))
			return $tmf_option->attorney_label_phone_1 . ': ';

		if ($this->post_type == 'staff' && !empty($tmf_option->staff_label_phone_1))
			return $tmf_option->staff_label_phone_1 . ': ';

		if ($this->post_type == 'location' && !empty($tmf_option->location_label_phone_1))
			return $tmf_option->location_label_phone_1 . ': ';
	}


	private function virtual_field_phone_2_label () {
		global $tmf_option;
		
		if ($this->post_type == 'attorney' && !empty($tmf_option->attorney_label_phone_2))
			return $tmf_option->attorney_label_phone_2 . ': ';

		if ($this->post_type == 'staff' && !empty($tmf_option->staff_label_phone_2))
			return $tmf_option->staff_label_phone_2 . ': ';

		if ($this->post_type == 'location' && !empty($tmf_option->location_label_phone_2))
			return $tmf_option->location_label_phone_2 . ': ';
	}


	private function virtual_field_fax_label () {
		global $tmf_option;
		
		if ($this->post_type == 'attorney' && !empty($tmf_option->attorney_label_fax))
			return $tmf_option->attorney_label_fax . ': ';

		if ($this->post_type == 'staff' && !empty($tmf_option->staff_label_fax))
			return $tmf_option->staff_label_fax . ': ';

		if ($this->post_type == 'location' && !empty($tmf_option->location_label_fax))
			return $tmf_option->location_label_fax . ': ';
	}


	private function virtual_field_email_label () {
		global $tmf_option;
		
		if ($this->post_type == 'attorney' && !empty($tmf_option->attorney_label_email))
			return $tmf_option->attorney_label_email . ': ';

		if ($this->post_type == 'staff' && !empty($tmf_option->staff_label_email))
			return $tmf_option->staff_label_email . ': ';

		if ($this->post_type == 'location' && !empty($tmf_option->location_label_email))
			return $tmf_option->location_label_email . ': ';
	}


	private function virtual_field_vcard_label () {
		global $tmf_option;
		
		if ($this->post_type == 'attorney' && !empty($tmf_option->attorney_label_vcard))
			return $tmf_option->attorney_label_vcard;

		if ($this->post_type == 'staff' && !empty($tmf_option->staff_label_vcard))
			return $tmf_option->staff_label_vcard;
	}


	private function virtual_field_resume_label () {
		global $tmf_option;
		
		if ($this->post_type == 'attorney' && !empty($tmf_option->attorney_label_resume))
			return $tmf_option->attorney_label_resume;

		if ($this->post_type == 'staff' && !empty($tmf_option->staff_label_resume))
			return $tmf_option->staff_label_resume;
	}


	public function contributors () {
		if (!empty($this->contributors)):
			return TMF_Post::factory(array('post_type' => array('attorney', 'staff'), 'post__in' => $this->contributors, 'orderby' => 'post__in', 'limit' => -1))->to_array();
		endif;
	}

	public function obfuscate_email ($classes = '', $title = '', $email = NULL) {

		$email = (empty($email)) ? $this->email : $email;

		if (!empty($email)):
			$email = explode('@', $email);

			return '<a class="tmf-email '. $classes .'" href="#" title="'. $title .'" data-front="'. $email[0] .'" data-back="'. $email[1] .'"></a>';

		endif;
	}

	public function has_title () {
		return ($this->show_title !== 'false');
	}


	public function has_vcard () {
		return in_array($this->post_type, array('attorney', 'staff'));
	}


	public function has_resume () {
		return (in_array($this->post_type, array('attorney', 'staff')) && $this->resume);
	}


	public function has_practice_areas () {
		if (in_array($this->post_type, array('attorney', 'staff',' testimonial')))
			return !empty($this->_linked_post_practice_area);
	}


	public function has_primary_image () {
		return (!empty($this->primary_image));
	}


	public function has_thumbnail_image () {
		return (!empty($this->thumbnail_image));
	}


	public function has_post_date () {
		global $tmf_option;

		$hide_date = $tmf_option->{$this->post_type . '_hide_date'};
			
		return !(!empty($hide_date) && $hide_date == TRUE);
	}


	public function has_author () {
		global $tmf_option;

		$hide_author = $tmf_option->{$this->post_type . '_hide_author'};
			
		return !(!empty($hide_author) && $hide_author == TRUE);
	}

	public function has_contributors () {
		global $tmf_option;

		return (!empty($this->contributors));
	}

	public function has_permalink () {
		global $tmf_option;

		// if object is a practice area, check for content
		if (in_array($this->post_type, array('practice-area'))):
			if (empty($this->content))
				return FALSE;
		endif;

		$post_archive_link = $tmf_option->{TMF_Text::underscores($this->post_type) . '_archive_link'};

		return !($this->is_in_archive_list && $post_archive_link == TRUE);
	}


	public function has_contact_information () {
		return (!empty($this->phone_1) || !empty($this->phone_2) || !empty($this->fax) || !empty($this->email));
	}


	public function has_rsvp () {
		if (in_array($this->post_type, array('event'))):

			if ($this->end_date < time())
				return FALSE;
			
			return ($this->rsvp_enabled == 'true');
		endif;
	}


	public function has_registration () {
		if (in_array($this->post_type, array('event'))):
			if ($this->registration_end_date < time())
				return FALSE;
		
			return ($this->registration_enabled == 'true');
		endif;
	}


	public function is_password_protected () {
		return ($this->password_protected == 'true');
	}


	public function job_titles () {
		switch ($this->post_type):
			case 'attorney':
				$category = TMF_Taxonomy::ATTORNEY_JOB_TITLES;
				break;
			case 'staff':
				$category = TMF_Taxonomy::STAFF_JOB_TITLES;
				break;
		endswitch;
		
		if (isset($category))
			return TMF_Taxonomy::factory($this, $category);
	}


	public function categories () {
		switch ($this->post_type):
			case 'post':
				$category = TMF_Taxonomy::CATEGORIES;
				break;
			case 'news':
				$category = TMF_Taxonomy::NEWS_CATEGORIES;
				break;
			case 'event':
				$category = TMF_Taxonomy::EVENT_CATEGORIES;
				break;
			case 'attorney':
				$category = TMF_Taxonomy::ATTORNEY_CATEGORIES;
				break;
			case 'staff':
				$category = TMF_Taxonomy::STAFF_CATEGORIES;
				break;
			case 'practice-area':
				$category = TMF_Taxonomy::PRACTICE_AREA_CATEGORIES;
				break;
			case 'testimonial':
				$category = TMF_Taxonomy::TESTIMONIAL_CATEGORIES;
				break;
			case 'location':
				$category = TMF_Taxonomy::LOCATION_CATEGORIES;
				break;
			case 'article':
				$category = TMF_Taxonomy::ARTICLE_CATEGORIES;
				break;
		endswitch;

		if (isset($category))
			return TMF_Taxonomy::factory($this, $category);
	}

	public function representative_cases () {
		if (in_array($this->post_type, array('attorney', 'practice-area')))
			return TMF_PostLink::factory($this, TMF_PostLink::REPRESENTATIVE_CASES);
	}


	public function practice_areas () {
		if (in_array($this->post_type, array('attorney', 'staff', 'testimonial')))
			return TMF_PostLink::factory($this, TMF_PostLink::PRACTICE_AREAS);
	}


	public function locations () {
		if (in_array($this->post_type, array('attorney', 'staff', 'testimonial')))
			return TMF_PostLink::factory($this, TMF_PostLink::LOCATIONS);
	}


	public function attorneys () {
		if (in_array($this->post_type, array('practice-area', 'location', 'testimonial')))
			return TMF_PostLink::factory($this, TMF_PostLink::ATTORNEYS);
	}


	public function author () {
		if (in_array($this->post_type, array('post', 'news', 'article')))
			return TMF_Author::factory($this);
	}


	public function rsvp () {
		if (in_array($this->post_type, array('event')))
			return TMF_Rsvp::factory($this);
	}


	public function registration () {
		if (in_array($this->post_type, array('event')))
			return TMF_EventRegistration::factory($this);
	}


	public function tags () {
		switch ($this->post_type):
			case 'post':
				$tags = TMF_Taxonomy::TAGS;
				break;
			case 'news':
				$tags = TMF_Taxonomy::NEWS_TAGS;
				break;
			case 'event':
				$tags = TMF_Taxonomy::EVENT_TAGS;
				break;
			case 'testimonial':
				$tags = TMF_Taxonomy::TESTIMONIAL_TAGS;
				break;
			case 'article':
				$tags = TMF_Taxonomy::ARTICLE_TAGS;
				break;
		endswitch;

		if (isset($tags))
			return TMF_Taxonomy::factory($this, $tags);
	}


	public function excerpt ($limit = 99999) {
		if (in_array($this->post_type, array('faq'))):
			$this->post_excerpt = $this->answer;
		endif;

		if (!$excerpt = trim($this->post_excerpt)):
			$excerpt = $this->post_content;
			$excerpt = strip_shortcodes($excerpt);
			$excerpt = apply_filters('the_content', $excerpt);
			$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
			$excerpt = strip_tags($excerpt);
		endif;

		// Remove double spaces from excerpt if not disabled
		if(empty($tmf_option->allow_extra_sapces) || $tmf_option->allow_extra_sapces == '0') {
			$excerpt = str_replace('  ', ' ', $excerpt);
			$excerpt = str_replace("&nbsp;", " ", $excerpt);
			$excerpt = str_replace("\n", " ", $excerpt);
			// Strip all on-ASCII characters from the input string
			// Commented because it appears as if the regex is replacing some non English characters
			//$content = preg_replace('/[\x00-\x1F\x80-\xFF]/u', ' ', $content);
			// https://stackoverflow.com/a/48558101/2176214
			$cleaned_excerpt = preg_replace('/[\x00-\x09\x0B-\x1F\x7F\xA0]/u', ' ', $excerpt);

			// The /u flag makes content empty if the html is not valid UTF-8
			// The behavior is weird so fix is below
			// https://www.php.net/manual/en/reference.pcre.pattern.modifiers.php
			$excerpt = !empty($cleaned_excerpt) ? $cleaned_excerpt : $excerpt;
			$excerpt = trim(preg_replace('/\s\s+/', ' ', $excerpt));
		}

		return stripslashes(TMF_Text::limit_chars($excerpt, $limit));
	}


	public function contributor_list ($label_single = 'Contributor', $label_plural = 'Contributors', $separator = ', ') {
		if (!empty($this->contributors)):
			
			$contributors	= TMF_Post::factory(array('post_type' => array('attorney', 'staff'), 'post__in' => $this->contributors, 'orderby' => 'post__in', 'limit' => -1))->to_array();
			$count			= 0;
			$build			= '';

			if (!empty($contributors)):

				$label = (count($contributors) > 1) ? $label_plural : $label_single;
				$build .= '<span class="contributor-label label">' . $label . ': </span>';

				foreach ($contributors as $contributor):
					if ($count > 0)
						$build .= '<span class="separator">'. $separator .'</span>';

					$build .= '<a href="'. $contributor->tmf->permalink .'">'. $contributor->tmf->person_name .'</a>';
					$count++;
				endforeach;

				return '<div class="contributors">' . $build . '</div>';

			endif;
		endif;
	}


	public function css_classes ($size = 'medium') {
		$classes[] = 'tmf-post';
		$classes[] = 'tmf-post-' . $this->ID;
		$classes[] = $this->post_type;
		$classes[] = $size;

		if ($this->post_list_key == 1)
			$classes[] = 'first-post';

		if ($this->post_list_key > 1 && $this->post_list_key < $this->post_list_count)
			$classes[] = 'middle-post';

		if ($this->post_list_key == $this->post_list_count)
			$classes[] = 'last-post';

		return implode(' ', $classes);
	}


	public function formatted_post_date ($format = 'F jS, Y') {
		return date($format, strtotime($this->post_date));
	}


	public function formatted_start_date ($format = 'F jS, Y g:ia') {
		return date($format, $this->start_date);
	}


	public function event_location ($include_address = TRUE, $show_map_link = TRUE) {
		if (!in_array($this->post_type, array('event')))
			return;

		if (empty($this->location_address_1))
			return;

		if (!in_array($this->post_type, array('event')))
			return;

		$html	= '';
		$build	= array();

		if (!empty($this->location_name))
			$html .= '<span class="event-location-name">' .$this->location_name .'</span>';

		if (!empty($this->location_address_1))
			$build[] = $this->location_address_1;

		if (!empty($this->location_address_2))
			$build[] = $this->location_address_2;

		if (!empty($this->location_city))
			$build[] = $this->location_city;

		if (!empty($this->location_state))
			$build[] = $this->location_state;

		if (!empty($build)):
			if (!empty($this->location_name))
				$html .= ' &bull; ';

			$html .= implode(', ', $build);

			if (!empty($this->location_zipcode))
				$html .= ' ' . $this->location_zipcode;
		endif;

		$event_location = $html;

		$address = urlencode($this->location_address_1 .', '. $this->location_city .', '. $this->location_state .' '. $this->location_zipcode);

		if ($show_map_link == TRUE && $include_address == TRUE)
			return $event_location . ' &bull; <a href="http://maps.google.com/?q='. $address .'" target="_blank" class="directions-link">Get Directions</a>';
		
		if ($show_map_link == TRUE)
			return '<span class="event-location-name">' . $this->location_name . '</span> &bull; <a href="http://maps.google.com/?q='. $address .'" target="_blank" class="directions-link">Get Directions</a>';	

		if ($include_address == TRUE)
			return $event_location;

		if (!empty($this->location_name))
			return $this->location_name;

	}


	public function taxonomy ($taxonomy_type) {
		return TMF_Taxonomy::factory($this, $taxonomy_type);
	}


	public function post_link ($postlink_type) {
		return TMF_PostLink::factory($this, $postlink_type);
	}


	public static function wrap_post_objects ($posts) {
		$post_count		= count($posts);
		$wrapped_posts	= array();

		foreach ($posts as $key => $post):

			// Set relational information about this group of posts.
			$post->post_list_count		= $post_count;
			$post->post_list_key		= $key + 1;

			// prevents recursion when passing the post to TMF_PostObject
			$pass_post = clone $post;

			$post->tmf = new TMF_PostObject($pass_post);

		endforeach;

		return $posts;
	}

}

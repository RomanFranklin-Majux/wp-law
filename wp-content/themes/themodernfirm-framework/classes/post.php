<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Provides an abstraction layer for WP get_posts along with providing some helper
 * functions releating to posts.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Post {

	private $default_args = array(
		'suppress_filters' => FALSE
	);


	private $query_args = array();


	private $posts;

	private $post_template;


	public static function actions () {
		add_action('save_post', array('TMF_Post', 'update_menu_order'));
		add_action('save_post', array('TMF_Post', 'get_static_map'));
		add_action('pre_get_posts', array('TMF_Post', 'modify_loop'));

		if(!is_admin()) {
			add_filter('wpseo_robots', array('TMF_Post', 'yoast_no_noindex'), 999);
			add_action( 'wp', array('TMF_Post', 'add_header_noindex') );
		}
	}


	public function __construct($mixed = NULL, $template = NULL) {

		$this->post_template = $template;

		// if $mixed is an array
		if (is_array($mixed)):

			// if $mixed contains WP_Post objects
			if (isset($mixed[0]) && $mixed[0] instanceof WP_Post):
				$this->posts = $mixed;

			// Assume its an array of arguments to search for posts
			else:
				$this->query_args = $this->format_arguments($mixed);
			endif;

		// if $mixed is a WP_Post object
		elseif ($mixed instanceof WP_Post):
			$this->posts = array($mixed);
		endif;

	}


	public static function factory ($mixed = NULL, $template = NULL) {
		return new TMF_Post($mixed, $template);
	}


	private function format_arguments ($args) {

		$args = (object) $args;

		// check for limit
		if (isset($args->limit)):
			$args->numberposts = $args->limit;
			unset($args->limit);
		endif;

		// check for id
		if (isset($args->id)):
			$args->p = $args->id;
			unset($args->id);
		endif;

		// check for random
		if (isset($args->random) && strtolower($args->random) == 'true'):
			$args->orderby = 'rand';
			unset($args->random);
		endif;

		// check for random
		if (isset($args->random) && strtolower($args->random) == TRUE):
			$args->orderby = 'rand';
			unset($args->random);
		endif;

		// check for a list of included ids
		if (isset($args->include)):

			if (is_array($args->include))
				$args->post__in = $args->include;
			else
				$args->post__in = explode(',', str_replace(' ', '', $args->include));

			unset($args->include);

		endif;

		// check for a list of excluded ids
		if (isset($args->exclude)):
			$args->post__not_in = explode(',', str_replace(' ', '', $args->exclude));
		endif;

		$args = array_merge((array) $this->default_args, (array) $args); 

		return $args;

	}



	private function get_posts() {
		if (!$this->posts)
			$this->posts = get_posts($this->query_args);

		return $this->posts;
	}


	public function to_field ($field, $format = TRUE, $echo = TRUE) {
		$posts = $this->get_posts();

		if (isset($posts[0]->{$field}))
			$field_value = $posts[0]->{$field};
		elseif (isset($posts[0]->{'_' . $field}))
			$field_value = $posts[0]->{'_' . $field};

		if (isset($field_value)):

			if ($format):

				$field_name	= TMF_Text::dashes($field);

				if (method_exists($this, 'to_field_' . $field))
					$field_value = $this->{'to_field_' . $field}($posts[0], $field_name, $field_value);
				else
					$field_value = $this->to_field_string($posts[0], $field_name, $field_value);

			endif;

			if (!$echo)
				return $field_value;

			echo $field_value;
		endif;

	}


	private function to_field_string ($post, $name, $value) {
		if($name == "phone-1" || $name == "phone-2") 
			return '<span class="tmf-field post-id-'. $post->ID .' '. $post->post_type .' ' . $name. '"><a href="tel:'.wp_strip_all_tags($value).'">'. $value .'</a></span>';

		return '<span class="tmf-field post-id-'. $post->ID .' '. $post->post_type .' ' . $name. '">'. $value .'</span>';
	}


	private function to_field_email ($post, $name, $value){
		return $post->tmf->obfuscate_email('tmf-field post-id-'. $post->ID .' '. $post->post_type .' ' . $name);
	}


	public function to_array (){
		return $this->get_posts();
	}


	public function to_single (){
		$posts = $this->get_posts();

		if (!empty($posts[0]))
			return $posts[0];
	}


	public function template ($template = 'medium') {
		$this->post_template = $template;

		return $this;
	}


	public function render ($echo = TRUE) {
		global $tmf_option;
		$html		= '';
		$post_count = count($this->get_posts());

		foreach ($this->get_posts() as $post):

			$post->tmf->template = $this->post_template;
			// is this post apart of an archive listing?
			$post->tmf->is_in_archive_list = is_archive();
	
			$html .= TMF_Block::factory('post-types/' . $post->post_type . '/' . $this->post_template)
				->set('tmf_option', $tmf_option)
				->set('post', $post->tmf)
				->set('query', (object) $post->query_args)
				->ignore_not_found()
				->render(FALSE);
		endforeach;

		if (!empty($html)):

			if ($post_count > 1)
				$html = '<div class="tmf-post-list '. $this->post_template .'">' . $html . '</div>';

			if (!$echo)
				return $html;

			echo $html;
		endif;

	}


	public static function modify_loop ($query) {
		global $tmf_option;

		if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive(array('attorney','staff','practice-area','testimonial','location', 'faq', 'representative-case', 'video'))):
			$post_type_name = TMF_Text::underscores($query->get('post_type'));

			$custom_order_by = $tmf_option->{ $post_type_name .'_order_by' };

			$query->set('posts_per_page', -1);
			if(!empty($custom_order_by)) {
				$query->set('orderby', $custom_order_by);
			} else {
				$query->set('orderby', 'menu_order');
			}

			$custom_order_direction = $tmf_option->{ $post_type_name .'_order_direction' };

			if(!empty($custom_order_direction)) {
				$query->set('order', $custom_order_direction);
			} else {
				$query->set('order', 'ASC');
			}

			if ($query->is_post_type_archive('practice-area')):
				$query->set('post_parent', 0);
			endif;

			if ($query->is_search()):
				$query->set('posts_per_page', 20);
				$query->set('post_type', array('page','post','attorney','staff','testimonial','location','representative-case','event','faq'));
		    endif;
		endif;

		if (!is_admin() && $query->is_main_query() && $query->is_tax(array('attorney-categories', 'practice-area-categories', 'staff-categories', 'testimonial-categories', 'location-categories'))) {
			$query->set('posts_per_page', -1);

			// Get queried object, on term archive page it contains the term object
			$obj = $query->get_queried_object();

			// Get the object
			if($obj) {
				// Get the taxonomy from object
				// Get the post_types from the taxonomy
				$post_types = TMF_Post::get_post_types_by_taxonomy( $obj->taxonomy );

				// Check for post_types and see if there exists one
				if(is_array($post_types) && count($post_types) > 0) {
					// Get the first post_type from the array
					$post_type_name = TMF_Text::underscores($post_types[0]);

					// Fetch the settings for post_type
					$custom_order_apply = $tmf_option->{ $post_type_name .'_order_apply' };

					// Apply the order to all of the term archives where active
					if('all' == $custom_order_apply) {
						$custom_order_by = $tmf_option->{ $post_type_name .'_order_by' };
						$custom_order_direction = $tmf_option->{ $post_type_name .'_order_direction' };

						if(!empty($custom_order_by)) {
							$query->set('orderby', $custom_order_by);
						} else {
							$query->set('orderby', 'menu_order');
						}
						
						if(!empty($custom_order_direction)) {
							$query->set('order', $custom_order_direction);
						} else {
							$query->set('order', 'ASC');
						}

					} else if('selected' == $custom_order_apply) {
						// Apply only on selected terms
						$custom_order_terms = $tmf_option->{ $post_type_name .'_order_terms' };

						// Check if custom terms are non empty
						if($custom_order_terms) {
							// Look through all terms
							foreach($custom_order_terms as $term) {
								// See if currently rendered term exist in the list
								if($obj->term_id == $term) {

									$custom_order_by = $tmf_option->{ $post_type_name .'_order_by' };
									$custom_order_direction = $tmf_option->{ $post_type_name .'_order_direction' };

									if(!empty($custom_order_by)) {
										$query->set('orderby', $custom_order_by);
									} else {
										$query->set('orderby', 'menu_order');
									}
									
									if(!empty($custom_order_direction)) {
										$query->set('order', $custom_order_direction);
									} else {
										$query->set('order', 'ASC');
									}

								}
							}
						}

					}
				}

			} else {
				$query->set('orderby', 'menu_order');
				$query->set('order', 'ASC');
			}
		}

		// For post-types that use default order by default
		if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive(array('ebook','member'))):
			$post_type_name = TMF_Text::underscores($query->get('post_type'));

			$custom_order_by = $tmf_option->{ $post_type_name .'_order_by' };

			if(!empty($custom_order_by)) {
				$query->set('orderby', $custom_order_by);
			}

			$custom_order_direction = $tmf_option->{ $post_type_name .'_order_direction' };

			if(!empty($custom_order_direction)) {
				$query->set('order', $custom_order_direction);
			}

		endif;

		if (!is_admin() && $query->is_main_query() && $query->is_tax(array('ebook-categories', 'professional-areas', 'video-categories', 'representative-case-categories', 'faq-categories'))) {

			// Get queried object, on term archive page it contains the term object
			$obj = $query->get_queried_object();

			// Get the object
			if($obj) {
				// Get the taxonomy from object
				// Get the post_types from the taxonomy
				$post_types = TMF_Post::get_post_types_by_taxonomy( $obj->taxonomy );

				// Check for post_types and see if there exists one
				if(is_array($post_types) && count($post_types) > 0) {
					// Get the first post_type from the array
					$post_type_name = TMF_Text::underscores($post_types[0]);

					// Fetch the settings for post_type
					$custom_order_apply = $tmf_option->{ $post_type_name .'_order_apply' };

					// Apply the order to all of the term archives where active
					if('all' == $custom_order_apply) {
						$custom_order_by = $tmf_option->{ $post_type_name .'_order_by' };
						$custom_order_direction = $tmf_option->{ $post_type_name .'_order_direction' };

						if(!empty($custom_order_by)) {
							$query->set('orderby', $custom_order_by);
						}
						
						if(!empty($custom_order_direction)) {
							$query->set('order', $custom_order_direction);
						}

					} else if('selected' == $custom_order_apply) {
						// Apply only on selected terms
						$custom_order_terms = $tmf_option->{ $post_type_name .'_order_terms' };

						// Check if custom terms are non empty
						if($custom_order_terms) {
							// Look through all terms
							foreach($custom_order_terms as $term) {
								// See if currently rendered term exist in the list
								if($obj->term_id == $term) {

									$custom_order_by = $tmf_option->{ $post_type_name .'_order_by' };
									$custom_order_direction = $tmf_option->{ $post_type_name .'_order_direction' };

									if(!empty($custom_order_by)) {
										$query->set('orderby', $custom_order_by);
									}
									
									if(!empty($custom_order_direction)) {
										$query->set('order', $custom_order_direction);
									}

								}
							}
						}

					}
				}

			}
		}
	}

	public static function get_post_types_by_taxonomy( $tax = 'category' ) {
		global $wp_taxonomies;
		return ( isset( $wp_taxonomies[$tax] ) ) ? $wp_taxonomies[$tax]->object_type : array();
	}


	public static function update_menu_order ($post_id) {
		global $wpdb;
		
		// check if autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return false;

		// check if this is a revision save
		if (wp_is_post_revision($post_id))
			return false;

		$post = get_post($post_id);

		if (!in_array($post->post_type, array('post', 'page', 'nav_menu_item', 'revision', 'attachment'))):

			if ($post->menu_order == 0)
				$wpdb->query("UPDATE $wpdb->posts SET menu_order = 9999 WHERE ID = $post->ID LIMIT 1");
		endif;
	}

	// No Index thank you page
	public static function yoast_no_noindex($string= "") {
		$page = get_page_by_path('thank-you');

	    if ($page && is_page($page->ID)) {
	        $string= "noindex,nofollow";
	    }
	    return $string;
	}

	// Send no index header if on thank you page
	public static function add_header_noindex() {
		$page = get_page_by_path('thank-you');

	    if ($page && is_page($page->ID)) {
			header( 'X-Robots-Tag: noindex, nofollow' );
		}
	}

	// Download and store google static map image
	// When saving the location post-type
	public static function get_static_map($post_id) {
		global $tmf_option;

		// check if autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return false;

		// check if this is a revision save
		if (wp_is_post_revision($post_id))
			return false;

		// If it is not enabled, do not proceed
		if(!$tmf_option->static_map_storage)
			return false;

		$post = get_post($post_id);

		if($post->post_type == "location") {
			$address_1 = get_post_meta($post_id, '_address_1', true);
			$address_2 = get_post_meta($post_id, '_address_2', true);
			$city = get_post_meta($post_id, '_city', true);
			$state = get_post_meta($post_id, '_state', true);
			$zipcode = get_post_meta($post_id, '_zipcode', true);

			$custom_map_address = get_post_meta($post_id, '_custom_map_address', true);

			if(wp_mkdir_p(UPLOADS_PATH . 'misc-images')) {

				$zoom = $tmf_option->static_map_zoom ? $tmf_option->static_map_zoom : 11;

				$height = $tmf_option->static_map_height ? $tmf_option->static_map_height : 200;
				$width = $tmf_option->static_map_width ? $tmf_option->static_map_width : 350;

				// If custom map address is provided
				if($custom_map_address) {
					$imageName = self::download_static_map_image($post_id, $custom_map_address, $zoom, UPLOADS_PATH . 'misc-images/', $height, $width);

					if($imageName) {
						// Store the image name in the meta
						update_post_meta( $post_id, '_map_image', $imageName );	
					}

				}elseif($address_1 && $city && $state && $zipcode) {
					// Generate address from the normal fields
					$map_address = $address_1 . ' '. $address_2. ' '. $city .' '. $state .' '. $zipcode;

					$imageName = self::download_static_map_image($post_id, $map_address, $zoom, UPLOADS_PATH . 'misc-images/', $height, $width);

					if($imageName) {
						// Store the image name in the meta
						update_post_meta( $post_id, '_map_image', $imageName );	
					}
				}
			}
		}
	}

	// Send HTTP request to fetch the image
	// Return image name with extension
	public static function download_static_map_image($post_id, $map_address, $zoom, $path, $height = 200, $width = 350) {

		$src = 'https://maps.googleapis.com/maps/api/staticmap?key=AIzaSyDEjqVOz0DK4huA6DrUAseP0TbdMjbzgvE&zoom='. $zoom .'&sensor=false&markers=color:red%%7C'. urlencode($map_address) .'&size='. $width . 'x'. $height;
	    $imageName = $post_id .'.png';
	    $imagePath = $path.$imageName;
	    file_put_contents($imagePath,file_get_contents($src));

	    return $imageName;
	}
}

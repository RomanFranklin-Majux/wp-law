<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Various functions to modify the Wordpress admin panel
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_ModernSlider {

	private static $registered_slider_areas = array(
		'home-page'		=> 'Home Page',
		'interior-page'	=> 'Interior Pages'
	);

	private $show_missing_warnings;

	private $slider_area_name;

	private $slider_area_type;

	private $slider_id;

	private $load_scripts = 'false';

	public function __construct ($slider_area = NULL) {

		if(get_option('tmf_post_type_modernslider') == '1'):

			if (is_numeric($slider_area)):
				$this->slider_id = $slider_area;
				$this->slider_area_type = 'id';
			else:
				$this->slider_area_name = $slider_area;
			endif;

			// only display missing warnings if its a single area or if its a multi area in a dev environment
			$this->show_missing_warnings = ($single == TRUE || ($single == FALSE && TMF_ENVIRONMENT == 'development')) ? TRUE : FALSE;
		endif;
	}

	/**
	 * Registers actions related to customizing the admin panel
	 *
	 * @return  void
	 */
	public static function actions() {

		// NOTE: NEED TO SEE WHY THE $TMF_OPTION INS'T AVAILABLE
		if(get_option('tmf_post_type_modernslider')== '1'):
			// Add hook for admin footer
	        add_action('admin_footer', array( 'TMF_ModernSlider', 'admin_footer' ) );
	        add_action('save_post', array( 'TMF_ModernSlider' , 'save'), 10, 2);
	        add_action('admin_enqueue_scripts', array('TMF_ModernSlider', 'enqueue'));

	    endif;
	}

	/**
	 * Enqueues scripts and styles for the modern slider
	 *	
	 * @return  void
	 */
	public static function enqueue() {
		wp_enqueue_script('jquery');
		wp_enqueue_editor();
		wp_enqueue_media();

		wp_enqueue_script('store-json2', FRAMEWORK_URI . JS_PATH . 'store-json2.min.js', '', FALSE, TRUE);
		wp_enqueue_script('modern-slider-admin', FRAMEWORK_URI . JS_PATH . 'modern-slider-admin.js', array('jquery', 'store-json2'), FALSE, TRUE);

		wp_localize_script('modern-slider-admin', 'modernslider_admin_vars', array(
			'title' => 'Select an image',
			'title2' => 'Select Images - Use Ctrl + Click or Shift + Click',
			'button' => 'Add to Slide',
			'button2' => 'Add Images as Slides'
			));
		
		wp_enqueue_style('tmf-modernslider-admin', FRAMEWORK_URI . CSS_PATH . 'modernslider-admin.css');
	}

	/**
	 * Returns the registered slider areas
	 *
	 * @return  array
	 */
	public static function get_registered_areas () {
		return self::$registered_slider_areas;
	}

	/**
	 * Registers the slider area
	 *
	 * @param $slug
	 * @param $title
	 * @return  void
	 */
	public static function register_area ($slug, $title = NULL) {
		if (is_array($slug)):
			self::$registered_slider_areas = array_merge(self::$registered_slider_area, $area);
		else:
			self::$registered_slider_areas[$slug] = $title;
		endif;
	}

	/**
	 * Removes the registered area from slider areas
	 *
	 * @return  void
	 */
	public static function unregister_area ($slug) {
		unset(self::$registered_slider_areas[$slug]);
	} 

	/**
	 * Saves any data associated with this metabox
	 * 
	 * @param	integer   $post_id   id of post being saved
	 * @return  void
	 */
	public static function save($post_id, $post) {

		// check if autosave
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return false;

		// check if post type matches
		if ($_POST['post_type'] != 'modernslider')
			return false;

		// check if this is a revision save
		if (wp_is_post_revision($post_id))
			return false;

		$post_type	= get_post_type_object('modernslider');

		// check for user permissions
		if (!current_user_can($post_type->cap->edit_post, $post_id))
			return false;

		$nonce = $_POST[FRAMEWORK_PREFIX]['modern_slides']['nonce'];

		// check for nonce
		// NEED TO SETUP THE NONCE
		/*if (!isset($nonce) || !wp_verify_nonce($nonce, basename( __FILE__ )))
			return false;*/

		// TEMP: Let's save the metabox
        update_post_meta($post_id, '_modernslider_metas', $_POST['modernslides_metas']);
	}

	/**
     * Hook to admin footer
     */
    public static function admin_footer() {
        // JS skeleton for adding a slide
        if(get_post_type()=='modernslider'){
        	global $post;

        	$slide = get_post_meta($post->ID, '_modernslider_metas', true);

         	self::skeleton();   
        }
    }

    public static function skeleton() {
    	?>
	    	<div id="tmf-slide-skeleton" class="tmf-slide-skeleton">
	    		<?php echo self::edit_template() ?>
			</div><!-- end #tmf-slide-skeleton -->

			<div id="tmf-boxy" class="tmf-boxy"></div>
	    	<?php
	    }

	    public static function edit_template( $slides = array(), $i = '{id}', $vars = array() ) {
	    	$args = array(
	    		'type' => 'image',
	    		'hidden' => false,
	    		);

	    	$slide = array_merge( $args, $slides );
	    		extract($vars);

	    	?>
			<div class="tmf-slide" data-slide-type="<?php echo esc_attr( $slide['type'] ); ?>" data-slide-hidden="<?php echo esc_attr( $slide['hidden'] ); ?>">
				<div class="tmf-header">
					<div class="tmf-slide-type">
						<input type="hidden" name="modernslides_metas[<?php echo esc_attr($i); ?>][type]" value="<?php echo esc_attr($slide['type']); ?>">
						<div class="switcher">
							<div class="display">
								<svg viewBox="0 0 24 24"><path d="M8.5,13.5L11,16.5L14.5,12L19,18H5M21,19V5C21,3.89 20.1,3 19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19Z" /></svg>
								<span>Image</span>
							</div>
							<ul>
								<li data-value="image">
									<svg viewBox="0 0 24 24"><path d="M20,5A2,2 0 0,1 22,7V17A2,2 0 0,1 20,19H4C2.89,19 2,18.1 2,17V7C2,5.89 2.89,5 4,5H20M5,16H19L14.5,10L11,14.5L8.5,11.5L5,16Z" /></svg>
									<span>Image</span>
								</li>
								<li data-value="custom">
									<svg viewBox="0 0 24 24"><path d="M14.6,16.6L19.2,12L14.6,7.4L16,6L22,12L16,18L14.6,16.6M9.4,16.6L4.8,12L9.4,7.4L8,6L2,12L8,18L9.4,16.6Z" /></svg>
									<span>Custom</span>
								</li>
							</ul>
							<svg viewBox="0 0 24 24"><path d="M7,10L12,15L17,10H7Z" /></svg>
						</div>
					</div>
					<span class="tmf-title">
						<?php echo esc_html($box_title); ?>
					</span>
					<span class="tmf-controls">
						<button class="tmf-minimize" type="button" title="<?php _e('Toggle', 'modernslides'); ?>">
							<svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
								<line x1="0.353553" y1="0.646447" x2="7.35355" y2="7.64645" stroke="black"></line>
								<line x1="6.64824" y1="7.64467" x2="13.7193" y2="0.644666" stroke="black"></line>
							</svg>
						</button>
						<button class="tmf-delete" type="button" title="<?php _e('Delete', 'modernslides'); ?>">
							<svg width="16" height="16" viewBox="0 0 24 24"><path d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" /></svg>
						</button>
					</span>
					<div class="clear"></div>
				</div>
				<div class="tmf-body">

					<?php self::image_template(
						array(
							'i' => $i,
			                'slide' => $slide,
			                'image_url' => $image_url,
			                'full_image_url' => $full_image_url,
			                'box_title' => $box_title,
			                'effects' => $effects
						)
					); ?>
					<div class="tmf-slide-custom">
						<div class="field last">
							<label for=""><?php _e('Custom HTML', 'modernslides'); ?></label>
							<textarea class="widefat tmf-custom-html" name="modernslides_metas[<?php echo esc_attr($i); ?>][custom]"><?php echo esc_textarea($slide['custom']); ?></textarea>
						</div>
					</div><!-- // end .tmf-slide-custom -->

				</div><!-- // end .tmf-body -->
			</div><!-- // end .tmf-slide -->
    	<?php
    }

    public static function image_template($array) {
    	extract($array);
    	?>

		<div class="tmf-slide-image">
			<div class="tmf-image-preview">
				<div class="tmf-image-field">
					<div class="tmf-image-thumb">
						<?php if($image_url): ?>
							<img src="<?php echo esc_url($image_url); ?>" alt="<?php _e('Thumbnail', 'modernslides'); ?>">
						<?php endif; ?>
					</div>
					<input class="tmf-image-id" name="modernslides_metas[<?php echo esc_attr($i); ?>][id]" type="hidden" value="<?php echo esc_attr($slide['id']); ?>" />
					<input class="button-secondary tmf-media-gallery-show" type="button" value="<?php _e('Select Image', 'modernslides'); ?>" />
					<?php if($image_url): ?>
						<a target="_blank" class="button-secondary" href="<?php echo esc_url($full_image_url); ?>"><?php _e('View Image', 'modernslides'); ?></a>
					<?php endif; ?>
				</div>
				<div class="tmf-content-field">
					<div class=" wp-core-ui wp-editor-wrap tmce-active">
						<div id="wp-slide_editor_<?php echo esc_attr($i); ?>-editor-tools" class="wp-editor-tools hide-if-no-js">
							<div id="wp-slide_editor_<?php echo esc_attr($i); ?>-media-buttons" class="wp-media-buttons">
								<?php do_action( 'media_buttons', 'slide_editor_'. esc_attr($i) ); ?>
							</div>
							<div class="wp-editor-tabs">
								<button id="slide_editor_<?php echo esc_attr($i); ?>-tmce" class="wp-switch-editor switch-tmce" data-wp-editor-id="slide_editor_<?php echo esc_attr($i); ?>" type="button"><?php echo __('Visual', 'tmf'); ?></button>
								<button id="slide_editor_<?php echo esc_attr($i); ?>-html" class="wp-switch-editor switch-html"" data-wp-editor-id="slide_editor_<?php echo esc_attr($i); ?>" type="button"><?php echo _x( 'Text', 'Name for the Text editor tab (formerly HTML)', 'tmf' ); ?></button>
							</div>
						</div>
						<div id="wp-<?php echo esc_attr($i); ?>-editor-container" class="wp-editor-container">
							<textarea id="slide_editor_<?php echo esc_attr($i) ?>" class="wp-editor-area" name="modernslides_metas[<?php echo esc_attr($i) ?>][content]"><?php echo esc_textarea($slide['content']) ?></textarea>
						</div>
					</div>

				</div>
			</div>
			<div class="tmf-image-edit">
				<div class="expandable-box">
					<div class="expandable-header first"><?php _e('Caption', 'modernslides'); ?></div>
					<div class="expandable-body" style="display:block;">
						<div class="field">
							<label for=""><?php _e('Title:', 'modernslides'); ?></label> <br>
							<input class="widefat modernslides-slide-meta-title" name="modernslides_metas[<?php echo esc_attr($i); ?>][title]" type="text" value="<?php echo esc_attr($slide['title']); ?>" />
						</div>
						<div class="field last">
							<label for=""><?php _e('Description:', 'modernslides'); ?></label> <br>
							<textarea class="widefat modernslides-slide-meta-description" name="modernslides_metas[<?php echo esc_attr($i); ?>][description]"><?php echo esc_textarea($slide['description']); ?></textarea>
						</div>
					</div>
				</div>
				<div class="expandable-box">
					<div class="expandable-header"><?php _e('Link', 'modernslides'); ?></div>
					<div class="expandable-body" style="display:block;">
						<div class="field">
							<label for=""><?php _e('Link URL:', 'modernslides'); ?></label> <br>
							<input class="modernslides_metas_link_url widefat" name="modernslides_metas[<?php echo esc_attr($i); ?>][link]" type="text" value="<?php echo esc_url($slide['link']); ?>" />
						</div>
						<div class="field last">
							<label for=""><?php _e('Open Link in:', 'modernslides'); ?></label> <br>
							<select class="modernslides_metas_link_target" id="" name="modernslides_metas[<?php echo esc_attr($i); ?>][link_target]">
								<option <?php selected( $slide['link_target'], '_self' ); ?> value="_self"><?php _e('Same Window', 'modernslides'); ?></option>
								<option <?php selected( $slide['link_target'], '_blank' ); ?> value="_blank"><?php _e('New Tab or Window', 'modernslides'); ?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="expandable-box">
					<div class="expandable-header"><?php _e('Image Attributes', 'modernslides'); ?></div>
					<div class="expandable-body" style="display:block;">
						<div class="field">
							<label for=""><?php _e('Alternate Text:', 'modernslides'); ?></label> <br>
							<input class="widefat modernslides-slide-meta-alt" name="modernslides_metas[<?php echo esc_attr($i); ?>][img_alt]" type="text" value="<?php echo esc_attr($slide['img_alt']); ?>" />
						</div>
						<div class="field last">
							<label for=""><?php _e('Title Text:', 'modernslides'); ?></label> <br>
							<input class="widefat modernslides-slide-meta-title" name="modernslides_metas[<?php echo esc_attr($i); ?>][img_title]" type="text" value="<?php echo esc_attr($slide['img_title']); ?>" />
						</div>
					</div>
				</div>
				<div class="expandable-box last">
					<div class="expandable-header"><?php _e('Miscellaneous', 'modernslides'); ?></div>
					<div class="expandable-body" style="display:block;">
						<div class="field last">
							<label for=""><?php _e('Custom CSS Classes:', 'modernslides'); ?></label> <br>
							<textarea class="widefat modernslides-slide-meta-alt" name="modernslides_metas[<?php echo esc_attr($i); ?>][css_classes]"><?php echo esc_attr($slide['css_classes']); ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div><!-- // end .tmf-slide-image -->

    	<?php
    }

    /**
     * Get slide image thumb from id. False on fail
     *
     * @param $attachment_id
     *
     * @return array|bool|false|string
     */
    public static function get_slide_img_thumb($attachment_id){
        $attachment_id = (int) $attachment_id;
        if($attachment_id > 0){
            $image_url = wp_get_attachment_image_src( $attachment_id, 'medium', true );
            $image_url = (is_array($image_url)) ? $image_url[0] : '';
            return $image_url;
        }
        return false;
    }

    public static function factory ($slider_area = NULL) {
		return new TMF_ModernSlider($slider_area);
	}

	public function single () {
		$this->slider_area_type = 'single';

		return $this;
	}


	public function id ($id) {
		$this->slider_area_type = 'id';
		$this->slider_id = $id;
		return $this;
	}

	private function id_render ($echo = TRUE) {
		global $tmf;

		$sliders = get_posts(array('post_type' => 'modernslider', 'numberposts' => 1, 'p' => $this->slider_id, 'suppress_filters' => FALSE));

		if (empty($sliders) && $this->show_missing_warnings):
			$this->slider_not_found();
			return;
		endif;

		if( !empty($sliders) && $sliders[0]->_random == 'true' ):

			$html = '<div class="tmf-slider-area tmf-slider-area-'. $this->slider_area_name .'">';

			$html .= $tmf->block('modern-slider/single-random')
				->set('slider_area_name', $this->slider_area_name)
				->set('slide_class', $this) //Pass class to variable to access in template
				->set('tmf', $tmf)
				->set('slide', $sliders[0])
				->render(FALSE);

			$html .= '</div>';

			if($echo == TRUE):
				echo $html;
			else:
				return $html;
			endif;

		elseif (!empty($sliders)):

			// Load Slider Scripts
			$this->load_scripts = 'true';

			$html = '<div class="tmf-slider-area tmf-slider-area-'. $this->slider_area_name .'">';

			$html .= $tmf->block('modern-slider/single')
				->set('slider_area_name', $this->slider_area_name)
				->set('slide_class', $this) //Pass class to variable to access in template
				->set('tmf', $tmf)
				->set('slide', $sliders[0])
				->render(FALSE);

			$html .=  '</div>';

			// Adding script here so we can pass on the meta_data
			$slider_settings = $sliders[0]->_modern_slider_general_settings;

			$settings = array(
				'slideshowSpeed' => (!empty($slider_settings->_slide_speed) ? $slider_settings->_slide_speed : '7000'),
				'animationSpeed' =>  (!empty($slider_settings->_animation_speed) ? $slider_settings->_animation_speed : '600'),
				'animation' =>  (!empty($slider_settings->_animation) ? $slider_settings->_animation : ''),
				'direction' =>  (!empty($slider_settings->_direction) ? $slider_settings->_direction : 'horizontal'),
				'directionNav' =>  (!empty($slider_settings->_show_arrows) ? $slider_settings->_show_arrows : 'false'),
				'controlNav' =>  (!empty($slider_settings->_show_paging) ? $slider_settings->_show_paging : 'false')
				);

			wp_localize_script('modern-slider-init', 'TMF_ModerSlider', $settings);

			if($echo == TRUE):
				echo $html;
			else:
				return $html;
			endif;

		endif;
	}	

	private function single_render ($echo = TRUE) {
		global $tmf;

		$sliders = get_posts(array('post_type' => 'modernslider', 'numberposts' => 1, 'meta_key' => '_slider_area', 'meta_value' => $this->slider_area_name, 'suppress_filters' => FALSE));

		if (empty($sliders) && $this->show_missing_warnings):
			$this->slider_not_found();
			return;
		endif;

		if( !empty($sliders) && $sliders[0]->_random == 'true' ):

			$html = '<div class="tmf-slider-area tmf-slider-area-'. $this->slider_area_name .'">';

			$html .= $tmf->block('modern-slider/'.$this->slider_area_name.'-random')
				->set('slider_area_name', $this->slider_area_name)
				->set('slide_class', $this) //Pass class to variable to access in template
				->set('tmf', $tmf)
				->set('slide', $sliders[0])
				->render(FALSE);

			$html .= '</div>';

			if($echo == TRUE):
				echo $html;
			else:
				return $html;
			endif;

		elseif (!empty($sliders)):

			// Load Slider Scripts
			$this->load_scripts = 'true';

			$html = '<div class="tmf-slider-area tmf-slider-area-'. $this->slider_area_name .'">';

			$html .= $tmf->block('modern-slider/'.$this->slider_area_name)
				->set('slider_area_name', $this->slider_area_name)
				->set('slide_class', $this) //Pass class to variable to access in template
				->set('tmf', $tmf)
				->set('slide', $sliders[0])
				->render(FALSE);

			$html .= '</div>';

			// Adding script here so we can pass on the meta_data
			$slider_settings = $sliders[0]->_modern_slider_general_settings;

			$settings = array(
				'slideshowSpeed' => (!empty($slider_settings->_slide_speed) ? $slider_settings->_slide_speed : '7000'),
				'animationSpeed' =>  (!empty($slider_settings->_animation_speed) ? $slider_settings->_animation_speed : '600'),
				'animation' =>  (!empty($slider_settings->_animation) ? $slider_settings->_animation : ''),
				'direction' =>  (!empty($slider_settings->_direction) ? $slider_settings->_direction : 'horizontal'),
				'directionNav' =>  (!empty($slider_settings->_show_arrows) ? $slider_settings->_show_arrows : 'false'),
				'controlNav' =>  (!empty($slider_settings->_show_paging) ? $slider_settings->_show_paging : 'false')
				);

			wp_localize_script('modern-slider-init', 'TMF_ModerSlider', $settings);

			if($echo == TRUE):
				echo $html;
			else:
				return $html;
			endif;

		endif;
	}	

	public function render ( $echo = TRUE ) {
		// If the requested area has not been registered, throw warning

		if (empty($this->slider_id)):
			if (!empty($this->slider_area_type)):
				$prop_name = 'registered_'. $this->slider_area_type .'_slider_areas';
				$registered_areas = self::$$prop_name;

				if (empty($registered_areas[$this->slider_area_name])):
					$this->area_not_registered();
					return;
				endif;
			else:
				if (!empty(self::$registered_slider_areas[$this->slider_area_name])):
					$this->slider_area_type = 'single';
				endif;

				if (empty($this->slider_area_type)):
					$this->area_not_registered();
					return;
				endif;
			endif;
		endif;

		// TEMP: Need to find better place to load scripts
		if(!wp_script_is('modern-slider', 'enqueued')){
			wp_enqueue_style('modern-slider', FRAMEWORK_URI . CSS_PATH . 'flexslider.css', array(), NULL, 'screen');
			wp_enqueue_script('jquery');
			wp_enqueue_script('modern-slider', FRAMEWORK_URI . JS_PATH . 'jquery.flexslider-min.js', array('jquery'));
			wp_enqueue_script('modern-slider-init', FRAMEWORK_URI . JS_PATH . 'modern-slider-init.js', array('jquery', 'modern-slider'), time());
		}

		// Call the corresponding renderer for the requested area
		if($echo == TRUE):
			$this->{$this->slider_area_type . '_render'}();
		else:
			return $this->{$this->slider_area_type . '_render'}($echo);
		endif;
	}

	private function slider_not_found () {
		?>
			<div class="missing-slider tmf-warning">
				No sliders are set for the '<?php echo $this->slider_area_name ?>' area.
			</div>
		<?php
	}

	private function area_not_registered () {
		?>
			<div class="missing-slider-area tmf-warning">
				No slider areas have been registered with the id of '<?php echo $this->slider_area_name ?>'.
			</div>
		<?php
	}

	public static function generate_slider_css_classes ($slider, $echo = TRUE) {
		$classes = array('tmf-slider');
		$classes[] = 'tmf-slider-' . $slider->ID;

		// add title to css classes
		if (isset($slider->_alternate_title))
			$classes[] = 'tmf-slider-' . str_replace(' ', '-', trim(strtolower($slider->_alternate_title)));
		else
			$classes[] = 'tmf-slider-' . str_replace(' ', '-', trim(strtolower($slider->post_title)));

		if (isset($slider->_css_classes)) 
			$classes[] = $slider->_css_classes;

		if($echo)
			echo implode(' ', $classes);
	
		return implode(' ', $classes);
	}
}

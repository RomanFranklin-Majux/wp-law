<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Base class used to generate metaboxes. Must be extended by a child class.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
abstract class TMF_Metabox {


	/**
	 * @var  string   the post type this metabox belongs to
	 */
	protected $post_type;


	/**
	 * @var  object   the current WP post
	 */
	protected $post;


	/**
	 * @var  string   the current WP post ID
	 */
	protected $post_id;


	/**
	 * @var  string   which column to place this metabox in by default
	 */
	protected $context = 'advanced';


	/**
	 * @var  array   holds the help panels for this post type
	 */
	protected $priority = 'default';


	/**
	 * @var  string   name of this metabox
	 */
	protected $metabox_name;


	/**
	 * @var  string   title of this metabox
	 */
	protected $metabox_title;


	/**
	 * Renders the HTML for the metabox.
	 * 
	 * @return	void
	 */
	abstract public function render();


	/**
	 * Builds a metabox and sets necessary WP actions
	 *
	 * @param	string   $post_type   the type of post to apply this metabox to
	 * @param   string   $context   which column to place this metabox in by default
	 * @param	string   $priority   holds the help panels for this post type
	 * @return  void
	 */
	public function __construct($post_type, $context = NULL , $priority = NULL) {

		$this->post_type = $post_type;

		if ($context)
			$this->context = $context;

		if ($priority)
			$this->priority = $priority;	

		// Set priority to 9 so it is always added before default metaboxes from plugins and yoast widget
		add_action('add_meta_boxes', array($this, 'add'), 9);
		add_action('save_post', array($this, 'save'));

		// Remove yoast metabox
		add_action( 'add_meta_boxes', array($this, 'remove_metaboxes'), 11 );

		// Always close the yoast metabox if not closed by default
		$this->close_wpseo_metabox();
	}


	/**
	 * Registers the metabox with WP
	 * 
	 * @return void
	 */
	public function add() {
		$metabox_slug = str_replace('_', '-', strtolower(FRAMEWORK_PREFIX)) . '-' . str_replace('_', '-', $this->metabox_name);
		add_meta_box($metabox_slug, $this->metabox_title, array($this, 'build_metabox'), $this->post_type, $this->context, $this->priority);
	}

	/**
	 * Closes yoast metabox by default
	 *
	 * @since 2.4.6
	 * @return void
	 */
	public function close_wpseo_metabox() {
		// Do it only on post-types
		if($this->post_type) {
			// See if the wpseo_metabox was already closed by us
			$closed = get_user_option( 'tmf_closed' . $this->post_type . '_wpseo_meta' );
			if(empty($closed)) {
				// Since metabox is not closed by us yet.
				// Look in already closed metaboxes
				$closed = get_user_option( 'closedpostboxes_' . $this->post_type );
				if( !empty($closed) && !in_array("wpseo_metabox", $closed)  ) {
					// Find currently logged in user's ID
					$user_id = get_current_user_id();

					// the function returns 0 if not logged in
					// So make sure the user is loggedin
					if(0 != $user_id) {
						// And add a flag so we know next time that it was closed by us
						update_user_option( $user_id, 'tmf_closed' . $this->post_type . '_wpseo_meta', true, true );
					}
				}
				elseif ( empty($closed) ) {
					// Find currently logged in user's ID
					$user_id = get_current_user_id();

					// the function returns 0 if not logged in
					// So make sure the user is loggedin
					if(0 != $user_id) {
						// Since the wpseo_metabox is not closed by default yet, let's close it
						// And add a flag so we know next time that it was closed by us
						$closedpostboxes = array('wpseo_meta');
						update_user_option( $user_id, 'closedpostboxes_' . $this->post_type, $closedpostboxes, true );
						update_user_option( $user_id, 'tmf_closed' . $this->post_type . '_wpseo_meta', true, true );
					}
				}
			}
		}
	}

	/**
	 * Removes yoast metabox on selected post-types
	 *
	 * @since 2.4.6
	 * @return void
	 */
	public function remove_metaboxes() {
		remove_meta_box( 'wpseo_meta', 'faq', 'normal' );
	}


	/**
	 * Sets the current post and runs the HTML renderer
	 * 
	 * @return void
	 */
	public function build_metabox($post) {
		$this->post = $post;
		$this->noonce();
		$this->render();
	}


	/**
	 * Gets the metadata fro a post and returns an object
	 * 
	 * @param	integer   $post_id   the post id of the post to get metadata for
	 * @return  object
	 */
	public function metadata($post_id) {
		return (object) get_post_meta($post_id);
	}


	/**
	 * Renders a noonce for the metabox for security
	 * 
	 * @return void
	 */
	public function noonce() {
		echo '<input type="hidden" id="'. $this->input_id('noonce', false) .'" name="'. FRAMEWORK_PREFIX .'['. $this->metabox_name .'][nonce]" value="' . wp_create_nonce(basename( __FILE__ )) .'" />';
	}


	/**
	 * Generates an HTML text input
	 * 
	 * @param	string   $name   the name of the field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function text($name, $class = NULL, $value = NULL, $input_x = FALSE){
		if (!$value)
			$value = $this->post->{'_' . $name};

		$html = '<input type="text" ';

		// add CSS id
		$html .= 'id="'. $this->input_id($name, FALSE) .'" ';

		// add name
		$html .= 'name="'. $this->input_name($name, $input_x, FALSE) .'" ';

		// add value
		$html .= 'value="'. $value .'" ';

		// add CSS class(es)
		if (is_string($class))
			$html .= 'class="'. $class .'" ';
		elseif (is_array($class))
			$html .= 'class="'. implode(" ", $class) .'" ';

		$html .= ' />';

		echo $html;
	}


	/**
	 * Generates an HTML number input
	 * 
	 * @param	string   $name   the name of the field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function number ($name, $class = NULL, $value = NULL, $step = 1, $min = 1, $input_x = FALSE){

		if (!$value)
			$value = $this->post->{'_' . $name};

		$html = '<input type="number" step="'. $step .'" min="'. $min .'"';

		// add CSS id
		$html .= 'id="'. $this->input_id($name, FALSE) .'" ';

		// add name
		$html .= 'name="'. $this->input_name($name, $input_x, FALSE) .'" ';

		// add value
		$html .= 'value="'. $value .'" ';

		// add CSS class(es)
		if (is_string($class))
			$html .= 'class="'. $class .'" ';
		elseif (is_array($class))
			$html .= 'class="'. implode(" ", $class) .'" ';

		$html .= ' />';

		echo $html;
	}

	/**
	 * Generates an HTML textarea input
	 * 
	 * @param	string   $name   the name of the field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function textarea($name, $class = NULL, $value = NULL, $input_x = FALSE){
		if (!$value)
			$value = $this->post->{'_' . $name};

		$html = '<textarea ';

		// add CSS id
		$html .= 'id="'. $this->input_id($name, FALSE) .'" ';

		// add name
		$html .= 'name="'. $this->input_name($name, $input_x, FALSE) .'" ';

		// add CSS class(es)
		if (is_string($class))
			$html .= 'class="'. $class .'" ';
		elseif (is_array($class))
			$html .= 'class="'. implode(" ", $class) .'" ';

		$html .= ' >';

		// add value
		$html .= stripslashes($value);

		$html .= "</textarea>";

		echo $html;
	}



	/**
	 * Generates an HTML checkbox input
	 * 
	 * @param	string   $name   the name of the field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function checkbox($name, $default_checked = TRUE, $class = NULL, $input_x = FALSE){
		$value = $this->post->{'_' . $name};

		$html  = '<input type="hidden" name="'. $this->input_name($name, $input_x, FALSE) .'" value="false" />';

		$html .= '<input type="checkbox" ';

		// add CSS id
		$html .= 'id="'. $this->input_id($name, FALSE) .'" ';

		// add name
		$html .= 'name="'. $this->input_name($name, $input_x, FALSE) .'" ';

		// add value
		$html .= 'value="true" ';

		// add if checked
		if ($value == "true" || empty($value) && $default_checked == TRUE)
			$html .= 'checked="checked"';

		// add CSS class(es)
		if (is_string($class))
			$html .= 'class="'. $class .'" ';
		elseif (is_array($class))
			$html .= 'class="'. implode(" ", $class) .'" ';

		$html .= ' />';

		echo $html;
	}



	/**
	 * Generates an HTML select box
	 * 
	 * @param	string   $name   the name of the field
	 * @param   array   $options   an array of option values
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function selectbox($name, $options = NULL, $placeholder = NULL, $value = NULL, $class = NULL, $input_x = FALSE) {
		if (!$value)
			$value = $this->post->{'_' . $name};

		$html = '<select ';

		// add CSS id
		$html .= 'id="'. $this->input_id($name, FALSE) .'" ';

		// add name
		$html .= 'name="'. $this->input_name($name, $input_x, FALSE) .'" ';

		// add CSS class(es)
		if (is_string($class))
			$html .= 'class="'. $class .'" ';
		elseif (is_array($class))
			$html .= 'class="'. implode(" ", $class) .'" ';

		$html .= '>';

		if (isset($placeholder))
			$html .= '<option value="0">'. $placeholder .'</option>';

		if (is_array($options)):

			foreach($options as $key => $option):
				$selected = ($key == $value) ? ' selected="selected"' : '';
				$html .= '<option value="'. $key .'"'. $selected .'>'. $option .'</option>';
			endforeach;
	
		endif;

		$html .= '</select>';

		echo $html;
	}

	/**
	 * Generates an HTML combo box
	 * 
	 * @param	string   $name   the name of the field
	 * @param   array   $options   an array of option values
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function combobox($name, $options = NULL, $placeholder = NULL, $value = NULL, $class = NULL, $input_x = FALSE) {
		if (is_array($class))
			$class[] = 'combobox';
		else
			$class .= ' combobox';

		$this->selectbox($name, $options, $placeholder, $value, $class, $input_x);
	}


	/**
	 * Generates an HTML combo box
	 * 
	 * @param	string   $name   the name of the field
	 * @param   array   $options   an array of option values
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function combobox_tags($name, $options = NULL, $placeholder = NULL, $value = NULL, $class = NULL, $input_x = FALSE) {
		if (is_array($class))
			$class[] = 'combobox-tags';
		else
			$class .= ' combobox-tags';

		$this->selectbox($name, $options, $placeholder, $value, $class, $input_x);
	}


	/**
	 * Generates a field name based on the current metabox
	 * 
	 * @param	string   $field   the name of the field
	 * @param	boolean   $input_x   if the field is an extra field
	 * @param	boolean   $echo   auto echo the input name
	 * @return  void|string
	 */
	public function input_name($field, $x = FALSE, $echo = TRUE) {
		if ($x)
			$name = FRAMEWORK_PREFIX . '_x[' . $this->metabox_name .'][_' . $field .']' ;
		else
			$name = FRAMEWORK_PREFIX . '[' . $this->metabox_name .'][_' . $field .']' ;

		if (!$echo)
			return $name;

		echo $name;
	}


	/**
	 * Generates a field id based on the current metabox
	 * 
	 * @param	string   $field   the name of the field
	 * @param	boolean   $echo   auto echo the input id
	 * @return  void|string
	 */
	public function input_id($field, $echo = true) {
		$field	= str_replace(' ', '-', strtolower($field));
		$dom_id	= str_replace('_', '-', strtolower(FRAMEWORK_PREFIX) . '-' . $this->metabox_name . '-' . $field);
		
		if (!$echo)
			return $dom_id;

		echo $dom_id;
	}


	/**
	 * Generates a label field
	 * 
	 * @param	string   $text   the text of the label
	 * @param	string   $for   id of the input to link to
	 * @return  void
	 */
	public function label($text, $for = NULL) {
		if (!$for) 
			$for = str_replace(' ', '-', strtolower($text));

		$for = str_replace('_', '-', strtolower(FRAMEWORK_PREFIX) . '-' . $this->metabox_name . '-' . $for );

		echo '<label for="'. $for .'">'. $text .'</label>';
	}


	/**
	 * Checks to make sure the save request has proper authorization
	 * 
	 * @param	integer   $post_id   id of post being saved
	 * @return  boolean
	 */
	public function authorization($post_id) {
		// check if autosave
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return false;

		// check for data relating to this meta box
		if (empty($_POST[FRAMEWORK_PREFIX][$this->metabox_name]) && empty($_POST[FRAMEWORK_PREFIX . '_x'][$this->metabox_name]))
			return false;

		// check if post type matches
		if ($_POST['post_type'] != $this->post_type)
			return false;

		// check if this is a revision save
		if (wp_is_post_revision($post_id))
			return false;

		$post_type	= get_post_type_object($this->post_type);

		// check for user permissions
		if (!current_user_can($post_type->cap->edit_post, $post_id))
			return false;

		$nonce = $_POST[FRAMEWORK_PREFIX][$this->metabox_name]['nonce'];

		// check for nonce
		if (!isset($nonce) || !wp_verify_nonce($nonce, basename( __FILE__ )))
			return false;

		return true;
	}


	/**
	 * Gets POST data for this metabox and returns it as an object
	 * 
	 * @param	boolean   $x   get extra post data
	 * @return  object
	 */
	public function post_data($x = FALSE){
		if ($x && isset($_POST[FRAMEWORK_PREFIX . '_x'][$this->metabox_name]))
			return (object) $_POST[FRAMEWORK_PREFIX . '_x'][$this->metabox_name];
		elseif (isset($_POST[FRAMEWORK_PREFIX][$this->metabox_name]))
			return (object) $_POST[FRAMEWORK_PREFIX][$this->metabox_name];
	}


	/**
	 * Updates a POST variable. Useful for setting data which needs to be formatted before save.
	 * 
	 * @param	string   $key   key of post variable
	 * @param	string   $value   the new value of the post variable
	 * @return  void
	 */
	public function update_post_data($key, $value){
		$_POST[FRAMEWORK_PREFIX][$this->metabox_name]['_' . $key] = $value;
	}


	/**
	 * This function is ran before a save. Useful for formatting data before save.
	 * 
	 * @return  void
	 */
	public function before_save() {}


	/**
	 * Saves any data associated with this metabox
	 * 
	 * @param	integer   $post_id   id of post being saved
	 * @return  void
	 */
	public function save($post_id) {

		// check for authorization
		if (!$this->authorization($post_id)) 
			return;

		$this->post_id = $post_id;
		$this->post	   = get_post($post_id);

		// run before save hook
		$this->before_save();

		$new_metadata	= $this->post_data();
		$old_metadata	= $this->metadata($post_id);

		// remove nonce from dataset
		unset($new_metadata->nonce);

		// loop through new metadata
		foreach ($new_metadata as $meta_key => $meta_value):

			/* This was conflicting with wysiwyg editors */
			//$meta_value = sanitize_text_field($meta_value);

			// New value
			if ($meta_value && empty($old_metadata->{$meta_key}))
				add_post_meta($post_id, $meta_key, $meta_value, true);

			// Update value
			elseif ($meta_value && $meta_value != $old_metadata->{$meta_key})
				update_post_meta($post_id, $meta_key, $meta_value);

			// Delete value
			elseif (empty($meta_value) && isset($old_metadata->{$meta_key}))
				delete_post_meta($post_id, $meta_key, $meta_value);

		endforeach;

	}


}

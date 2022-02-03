<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Base class used to generate admin settings panels. Must be extended by a child class.
 * 
 * This class will take care of generating the panel, saving and updating all fields into
 * the WP options table. Helpers are also provide to generate input fields.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
abstract class TMF_AdminPanel {


	/**
	 * @var  array   contains the objects for all loaded admin panels
	 */
	static $loaded_panels = array();

	/**
	 * @var  array   contains the objects for all loaded admin panels
	 */
	protected $page_tabs = array();


	/**
	 * @var  string   The slug name to refer to this menu by (should be unique for this menu).
	 */
	protected $name;


	/**
	 * @var  string   The css ID of the page icon.
	 */
	protected $icon_id = 'icon-options-general';


	/**
	 * @var  string   The on-screen name text for the menu
	 */
	protected $menu_title;


	/**
	 * @var  string   The on-screen name text for the submenu
	 */
	protected $submenu_title;


	/**
	 * @var  string   The slug name for this menu.
	 */
	protected $menu_slug;


	/**
	 * @var  string   The html name attribute for this panel
	 */
	protected $name_attribute;

	/**
	 * @var  string   The capability required for this menu to be displayed to the user.
	 */
	protected $capability = 'administrator';


	/**
	 * @var  string   The url to the icon to be used for this menu.
	 */
	protected $icon_url = 'div';


	/**
	 * @var  string  should the page reload itself on save
	 */
	protected $force_refresh = FALSE;


	/**
	 * @var  string   The position in the menu order this menu should appear.
	 */
	protected $position;


	/**
	 * @var  string   The slug name for the parent menu
	 */
	protected $parent_slug;

	/**
	 * @var  bool   Was data saved to the database on this request
	 */
	protected $saved = FALSE;


	/**
	 * Renders the HTML for the panel.
	 * 
	 * @return	void
	 */
	public function render(){}


	/**
	 * Renders the HTML before the tab.
	 * 
	 * @return	void
	 */
	public function before_tabs(){}


	/**
	 * Renders the HTML for the tab.
	 * 
	 * @return	void
	 */
	public function create_tabs(){}


	/**
	 * Builds a metabox and sets necessary WP actions
	 *
	 * @param	string   $post_type   the type of post to apply this metabox to
	 * @param   string   $context   which column to place this metabox in by default
	 * @param	string   $priority   holds the help panels for this post type
	 * @return  void
	 */
	public function __construct() {

		// if no menu_slug provided, generate one based on panel name
		if (empty($this->menu_slug))
			$this->menu_slug = $this->generate_slug_from_name();

		// generate name attribute to be used by html fields
		$this->name_attribute = TMF_Text::underscores($this->menu_slug);

		// add framework prefix to slug to prevent collision with WP or plugins
		$this->menu_slug = strtolower(FRAMEWORK_PREFIX) . '-' . $this->menu_slug;

		// Validate extended class parameters
		$this->check_for_parameters();

		// check for a double reload.
		if (isset($_GET['saved']))
			$this->saved = TRUE;

		add_action('admin_menu', array($this,'add'));

	}


	/**
	 * Registers the admin panel with WP
	 * 
	 * @return void
	 */
	public function add() {

		// If no parent slug was set, assume its a top level panel
		if (empty($this->parent_slug) && empty($this->no_parent)):
			add_menu_page($this->name, $this->menu_title, $this->capability, $this->menu_slug, array($this,'build_panel'), $this->icon_url, $this->position);
			
			// If a submenu title was set, create it separately. WP doesn't natively allow different menu and submenu titles.
			if (isset($this->submenu_title)):
				add_submenu_page($this->menu_slug, $this->name, $this->submenu_title, $this->capability, $this->menu_slug, array($this,'build_panel'));

			endif;

		// If a parent slug was set, set this panel as submenu.
		else:
			add_submenu_page($this->parent_slug, $this->name, $this->menu_title, $this->capability, $this->menu_slug, array($this,'build_panel'));
		endif;

		// add this panel to a static variable for access
		self::$loaded_panels[$this->menu_slug] = $this;

	}


	public function generate_slug_from_name() {
		$slug = preg_replace("/[^A-Za-z0-9 ]/", '', $this->name);
		return TMF_Text::dashes($slug);
	}


	/**
	 * Sets the current post and runs the HTML renderer
	 * 
	 * @return void
	 */
	public function check_for_parameters() {

		$missing_parameters = array();

		if (empty($this->name))
			throw new TMF_Exception("Admin Panel is missing the 'name' parameter.");
		
		foreach (array('menu_title', 'capability', 'menu_slug') as $parameter):
			if (empty($this->{$parameter}))
				$missing_parameters[] = $parameter;
		endforeach;

		if (!empty($missing_parameters))
			throw new TMF_Exception("Admin Panel API: '". $this->name . "' is missing the following parameters: " . implode(', ', $missing_parameters));

	}

	/**
	 * Gets the tab arrays
	 * 
	 * @return void
	 */
	public function addInPageTabs() {
		
		$i = 0;
		$total = count(func_get_args());

        foreach (func_get_args() as $asTab) {
        	$this->page_tabs[] = $asTab["tab_slug"];
            //$this->addInPageTab($asTab);
            if (is_array($asTab)) {

            	if($i == 0) {
            		echo '<h2 class="nav-tab-wrapper" id="tmf-tabs">';
            	}

            	echo '<a class="nav-tab'. ($i == 0 ? ' nav-tab-active': '') .'" data-tab="'.$asTab["tab_slug"].'" href="#'.$asTab["tab_slug"].'">'.$asTab["title"].'</a>';

            	$i++;
            	if($total == $i) {
            		echo '</h2>';
            	}
	            
	        }
        }
    }


	/**
	 * Sets the current post and runs the HTML renderer
	 * 
	 * @return void
	 */
	public function build_panel($post) {

		// save any data that was POSTed to this page
		$this->save();

		if ($this->force_refresh)
			$this->force_refresh();

		?>
			<div class="wrap">
				
				<div id="<?php echo $this->icon_id ?>" class="icon32"><br></div><h2><?php echo $this->name ?></h2>

				<?php if($this->saved == TRUE): ?>
					<br/>
			   		<div id="message" class="updated below-h2 fade"><p><b><?php echo $this->name ?></b> has been updated.</p></div>
			  	<?php endif;?>

				<form method="post" enctype="multipart/form-data" action="admin.php?page=<?php echo $this->menu_slug ?>">
					<?php $this->noonce() ?>
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />

					<?php $this->before_tabs() ?>

					<?php $this->create_tabs() ?>

					<?php
						$tab_counter = 1;
						foreach($this->page_tabs as $tab){
						  	
							echo '<div id="'. $tab .'" class="tmf-tab '. ($tab_counter == 1 ? ' active': '') .' ">';
						  	echo call_user_func( array( $this, 'content_'.$tab ) );
						  	echo '</div>';
							$tab_counter++;
						}
					?>
									
					<?php $this->render() ?>

					<p class="submit">
						<input name="save" class="button-primary" type="submit" value="Save Changes">
					</p>
				</form>
			</div>
		<?php
	}


	/**
	 * Renders a noonce for the metabox for security
	 * 
	 * @return void
	 */
	public function noonce() {
		echo '<input type="hidden" id="'. $this->input_id('noonce', false) .'" name="'. FRAMEWORK_PREFIX .'['. $this->name_attribute .'][nonce]" value="' . wp_create_nonce(basename( __FILE__ )) .'" />';
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
			$value = TMF_Option::factory()->{$name};

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
			$value = TMF_Option::factory()->{$name};

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
		$html .= $value;

		$html .= "</textarea>";

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
	public function number($name, $class = NULL, $value = NULL, $step = 1, $min = 1, $input_x = FALSE){

		if (!$value)
			$value = TMF_Option::factory()->{$name};

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
	 * Generates an HTML checkbox input
	 * 
	 * @param	string   $name   the name of the field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function checkbox($name, $default_checked = TRUE, $class = NULL, $input_x = FALSE){
		$value = TMF_Option::factory()->{$name};

		$html  = '<input type="hidden" name="'. $this->input_name($name, $input_x, FALSE) .'" value="0" />';

		$html .= '<input type="checkbox" ';

		// add CSS id
		$html .= 'id="'. $this->input_id($name, FALSE) .'" ';

		// add name
		$html .= 'name="'. $this->input_name($name, $input_x, FALSE) .'" ';

		// add value
		$html .= 'value="1" ';

		// add if checked
		if ($value == "1" || $value = '' && $default_checked == TRUE)
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
	 * Generates an HTML radio input
	 * 
	 * @param	string   $name   the name of the field
	 * @param   array   $options   an array of option values
	 * @param	string   $value   the value. if none given, will default to name field
	 * @param	string|array   $class   a string or array containing CSS class names
	 * @param	boolean   $input_x   if the field is an extra field
	 * @return  void
	 */
	public function radio($name, $options = NULL, $value = NULL, $class = NULL, $input_x = FALSE){
		if (!$value)
			$value = TMF_Option::factory()->{$name};

		if (is_array($options)):

			foreach($options as $key => $option):
				$html .= '<div class="tmf-radio-container">';

				$html .= '<input type="radio" ';

				// add CSS id
				$html .= 'id="'. $this->input_id($key, FALSE) .'" ';

				// add name
				$html .= 'name="'. $this->input_name($name, $input_x, FALSE) .'" ';

				// add value
				$html .= 'value="'. $key .'" ';

				// add if checked
				if ($key == $value)
					$html .= 'checked="checked"';

				// add CSS class(es)
				if (is_string($class))
					$html .= 'class="'. $class .'" ';
				elseif (is_array($class))
					$html .= 'class="'. implode(" ", $class) .'" ';

				$html .= ' />';

				$html .= '<label for="'. $this->input_id($key, FALSE) .'">'. $option .'</label>';

				$html .= '</div>';

			endforeach;
	
		endif;

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
			$value = TMF_Option::factory()->{$name};

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
			$html .= '<option>'. $placeholder .'</option>';

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
	 * Generates a field name based on the current metabox
	 * 
	 * @param	string   $field   the name of the field
	 * @param	boolean   $input_x   if the field is an extra field
	 * @param	boolean   $echo   auto echo the input name
	 * @return  void|string
	 */
	public function input_name($field, $x = FALSE, $echo = TRUE) {

		if ($x)
			$name = FRAMEWORK_PREFIX . '_x[' . $this->name_attribute .'][' . $field .']' ;
		else
			$name = FRAMEWORK_PREFIX . '[' . $this->name_attribute .'][' . $field .']' ;

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
		$field	= TMF_Text::dashes($field);
		$dom_id	= TMF_Text::dashes($this->menu_slug . '-' . $field);
		
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
			$for = $text;

		$for = TMF_Text::dashes($this->menu_slug . '-' . $for);

		echo '<label for="'. $for .'">'. $text .'</label>';
	}


	/**
	 * Checks to make sure the save request has proper authorization
	 * 
	 * @return  boolean
	 */
	public function is_authorized() {
		// check for data relating to this meta box
		if (empty($_POST[FRAMEWORK_PREFIX][$this->name_attribute]) && empty($_POST[FRAMEWORK_PREFIX . '_x'][$this->name_attribute]))
			return false;

		$nonce = $_POST[FRAMEWORK_PREFIX][$this->name_attribute]['nonce'];

		// check for nonce
		if (!isset($nonce) || !wp_verify_nonce($nonce, basename( __FILE__ ))):
			return false;

		// if nonce, clear it from the POST data
		else:
			unset($_POST[FRAMEWORK_PREFIX][$this->name_attribute]['nonce']);
		endif;

		return true;
	}


	/**
	 * Gets POST data for this metabox and returns it as an object
	 * 
	 * @param	boolean   $x   get extra post data
	 * @return  object
	 */
	public function post_data($x = FALSE){
		if ($x)
			return (isset($_POST[FRAMEWORK_PREFIX . '_x'][$this->name_attribute])) ? (object) $_POST[FRAMEWORK_PREFIX . '_x'][$this->name_attribute] : NULL;
		else
			return (isset($_POST[FRAMEWORK_PREFIX][$this->name_attribute])) ? (object) $_POST[FRAMEWORK_PREFIX][$this->name_attribute] : NULL;
	}


	/**
	 * Updates a POST variable. Useful for setting data which needs to be formatted before save.
	 * 
	 * @param	string   $key   key of post variable
	 * @param	string   $value   the new value of the post variable
	 * @return  void
	 */
	public function update_post_data($key, $value){
		$_POST[FRAMEWORK_PREFIX][$this->name_attribute][$key] = $value;
	}


	public function force_refresh() {

		if(class_exists('LiteSpeed_Cache')) {
  			$url = "<script>window.location = '". wp_nonce_url('http://'. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] .'&LSCWP_CTRL=purge&type=purge_all', 'purge', 'LSCWP_NONCE') ."&saved=true';</script>";
  		} else {
  			$url = "<script>window.location = 'http://". $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]  ."&saved=true';</script>";
  		}
		if (isset($_POST[FRAMEWORK_PREFIX][$this->name_attribute])):
			echo $url;

			return true;
		endif;
	}


	/**
	 * This function is ran before a save. Useful for formatting data before save via class extension.
	 * This is ran directly after authorization is checked and before data is written to the DB.
	 * 
	 * @return  void
	 */
	public function before_save() {}


	/**
	 * Saves any data associated with this metabox
	 * 
	 * @return  void
	 */
	public function save() {

		// check for authorization
		if (!$this->is_authorized()) 
			return;

		// run before save hook
		$this->before_save();

		// Save POSTed data
		TMF_Option::factory()->set($_POST[FRAMEWORK_PREFIX][$this->name_attribute]);

		$this->saved = TRUE;

	}


}

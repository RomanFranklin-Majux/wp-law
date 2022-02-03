<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Registers and renders Wordpress navigation menus.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Navigation {


	/**
	 * @var  array   menus which will be registered
	 */
	private static	$_menus = array('primary' => 'Primary', 'mobile_nav' => 'Mobile Nav', 'secondary' => 'Secondary');
	

	/**
	 * @var  string   menu to render
	 */
	private	$_menu;


	/**
	 * Registers filters related to menu items
	 *
	 * @return  void
	 */
	public static function filters() {
		add_filter('wp_nav_menu_objects', array('TMF_Navigation', 'add_css_classes'));
	}


	/**
	 * Registers actions related to menu items
	 *
	 * @return  void
	 */
	public static function actions() {
		add_action('init', array('TMF_Navigation', 'register'));
	}


	/**
	 * Creates a new menu loader
	 * 
	 * 	$menu = new TMF_Menu('main-menu');
	 * 	$menu->render();
	 *
	 * @param   string   $menu   name of the menu to be loaded
	 * @return  void
	 */
	public function __construct($menu) {
		$this->_menu = self::format_name($menu);
	}


	/**
	 * Creates a new menu loader
	 * 
	 * 	$menu = TMF_Menu::factory('main-menu')->render();
	 *
	 * @param   string   $menu   name of the menu to be loaded
	 * @return  object
	 */
	public function factory($menu) {
		return new TMF_Navigation($menu);
	}


	/**
	 * Renders the requested menu to the DOM
	 *
	 * @return  void
	 */
	public function render() {
		$css_id 	= self::convert_name_to_css_id($this->_menu);
		$id			= self::format_id($this->_menu);

		wp_nav_menu( 
			array(
				'theme_location'	=> $id, 
				'container'			=> false,
				'menu_id'			=> $css_id . '-nav-menu',
				'walker'			=> new TMF_Walker_Nav_Menu()
			) 
		);
	}


	/**
	 * Adds a menu to be registered with Wordpress
	 *
	 * @param   string   $name   name of menu to be registered
	 * @return  void
	 */
	public static function add($name) {
		$id	= self::format_id($name);
		$name = self::format_name($name);
		self::$_menus[$id] = $name;
	}


	/**
	 * Removes a menu to be registered with Wordpress
	 * 
	 * @param   string   $name   name of menu to be removed
	 * @return  void
	 */
	public static function remove($name) {
		$id	= self::format_id($name);
		unset(self::$_menus[$id]);
	}


	/**
	 * Checks to see if a menu is set
	 * 
	 * @param   string   $name   name of menu to be checked
	 * @return  boolean
	 */
	public static function is_set($name) {
		return has_nav_menu($name);
	}


	/**
	 * Registers requested menus with Wordpress
	 *
	 * @return  void
	 */
	public static function register() {
		if (self::$_menus)
			register_nav_menus(self::$_menus);
	}


	/**
	 * Adds 'first' and 'last' css classes to menu items.
	 *
	 * @param   array   $items   an array of menu items
	 * @return  array
	 */
	public static function add_css_classes($items) {
		// first class on parent most level
		$items[1]->classes[] = 'first';

		$parents = $children = array();
		foreach($items as $k => $item):
			if($item->menu_item_parent == '0')
				$parents[] = $k;
			else
				$children[$item->menu_item_parent] = $k;
		endforeach;

		// last class on parent most level
		$last = end(array_keys($parents));
		foreach ($parents as $k => $parent):
			if ($k == $last)
				$items[$parent]->classes[] = 'last';

		endforeach;

		// last class on children levels
		foreach($children as $child):
			$items[$child]->classes[] = 'last';
		endforeach;

		// first class on children levels
		$r_items = array_reverse($items, true);
		foreach($r_items as $k => $item):
			if($item->menu_item_parent !== '0')
				$children[$item->menu_item_parent] = $k;
		endforeach;

		foreach($children as $child):
			$items[$child]->classes[] = 'first';
		endforeach;

		return $items;
	}


	/**
	 * Formats a menu name properly
	 *
	 * @param   string   $name   a menu name
	 * @return  string
	 */
	private static function format_name($name) {
		return ucwords(str_replace('-',' ', strtolower($name)));
	}


	/**
	 * Formats a menu id properly
	 *
	 * @param   string   $name   a menu name
	 * @return  string
	 */
	private static function format_id($name) {
		return str_replace(' ','_', str_replace('-','_', strtolower($name)));
	}


	/**
	 * Converts a menu name to a css id
	 *
	 * @param   string   $name   a menu name
	 * @return  string
	 */
	private static function convert_name_to_css_id($name) {
		return str_replace(' ','-', strtolower($name));
	}
}


/**
 * Extends the Wordpress navigation walker
 * 
 * This adds a wrapper div around submenus. This extra div is
 * necessary for certain types of navigation styling.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2020 The Modern Firm, LLC
 */
class TMF_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Wraps a child menu item in a div
	 *
	 * @param   string   $output   a string containing nav HTML
	 * @param   int	   $depth   the current depth of the nav
	 * @return  void
	 */
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<div class=\"wrap\"><ul class=\"sub-menu\">\n";
	}


	/**
	 * Wraps a child menu item in a div
	 *
	 * @param   string   $output   a string containing nav HTML
	 * @param   int	   $depth   the current depth of the nav
	 * @return  void
	 */
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}
}

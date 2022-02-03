<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Style {

	private static $registered_styles = array(
		'google-material-icons'	=>	array('slug' => 'google-material-icons', 'url' => 'https://fonts.googleapis.com/icon?family=Material+Icons', 'dependencies' => '', 'version' => NULL, 'in_footer' => NULL),
		'fontawesome'	=>	array('slug' => 'fontawesome', 'url' => 'https://use.fontawesome.com/releases/v5.9.0/css/all.css', 'dependencies' => '', 'version' => NULL, 'in_footer' => NULL)
		);


	public static function actions () {
		add_action('wp', array('TMF_Style', 'enqueue'));
	}


	public static function add ($slug, $url = FALSE, $dependencies = array(), $version = FALSE, $media = 'all') {
		self::$registered_styles[$slug] = array('slug' => $slug, 'url' => $url, 'dependencies' => $dependencies, 'version' => $version, 'media' => $media);
	}


	public static function remove ($slug) {
		unset(self::$registered_styles[$slug]);
	}


	public static function enqueue () {
		if (!is_admin()):
			// If the menu is active and script is not included
			// Force inclusion
			if ( !array_key_exists("tmf-menu", self::$registered_styles) && get_theme_mod('tmf_mobile_nav_general_use_menu') ):

				// Get the tmf-framework's position in an array
				$position = ( array_search('tmf-framework', array_keys(self::$registered_styles)) + 1 );

				$menu_css = array( 'tmf-menu' => array('slug' => 'tmf-menu', 'url' => FRAMEWORK_URI . CSS_PATH . 'menu.css', 'dependencies' => array('tmf-framework'), 'version' => NULL, 'media' => 'screen') );

				// Append the menu.css right after the framework.css
				self::$registered_styles = array_slice(self::$registered_styles, 0, $position, true) +
				$menu_css +
				array_slice(self::$registered_styles, $position, NULL, true);
			endif;

			foreach (self::$registered_styles as $style):
				wp_enqueue_style($style['slug'], $style['url'], $style['dependencies'], $style['version'], $style['media']);
			endforeach;
		endif;
	}
}

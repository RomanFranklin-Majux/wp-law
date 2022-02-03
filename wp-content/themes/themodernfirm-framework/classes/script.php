<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Script {


	private static $registered_scripts = array();


	public static $enabled_services = array(
		'feature_detection'		=> 'feature_detection',
		'navigation'			=> 'navigation',
		'accordion'				=> 'accordion',
		'map_adjust'			=> 'map_adjust',
		'video_support'			=> 'video_support',
		'obfuscate_email'		=> 'obfuscate_email'
	);


	public static function actions () {
		add_action('wp', array('TMF_Script', 'enqueue'));
		add_action('wp_head', array('TMF_Script', 'geo_script'));
		add_action('admin_head', array('TMF_Script', 'geo_script'));
	}

	public static function geo_script () {
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		$request = wp_remote_get( 'http://pro.ip-api.com/json/'. $ip .'?key=8xkSeKCspCTYDnU' );

		if( is_wp_error( $request ) ) {
			$return = '';
		} else {
			$body = wp_remote_retrieve_body( $request );
			$data = json_decode( $body );

			if( ! empty( $data ) ) {
				$return = $data->countryCode;
			}
		}

		$script = '<script type="text/javascript"> window.country = "'. $return .'"; </script>';

		echo $script;
	}


	public static function add ($slug, $url = FALSE, $dependencies = array(), $version = FALSE, $in_footer = FALSE) {
		self::$registered_scripts[$slug] = array('slug' => $slug, 'url' => $url, 'dependencies' => $dependencies, 'version' => $version, 'in_footer' => $in_footer);
	}


	public static function enable_serivce ($slug) {
		self::$enabled_services[$slug] = $slug;
	}

	public static function disabled_service ($slug) {
		unset(self::$enabled_services[$slug]);
	}


	public static function remove ($slug) {
		unset(self::$registered_scripts[$slug]);
	}


	public static function enqueue () {
		if (!is_admin()):
			// If the menu is active and script is not included
			// Force inclusion
			if ( !array_key_exists("tmf-menu", self::$registered_scripts) && get_theme_mod('tmf_mobile_nav_general_use_menu') ):
				self::$registered_scripts['tmf-menu'] = array('slug' => 'tmf-menu', 'url' => FRAMEWORK_URI . JS_PATH . 'menu.js', 'dependencies' => array('tmf-core'), 'version' => FALSE, 'in_footer' => FALSE);
			endif;

			foreach (self::$registered_scripts as $script):
				wp_enqueue_script($script['slug'], $script['url'], $script['dependencies'], $script['version'], $script['in_footer']);
			endforeach;
		endif;
	}

	public static function bootloader () {
		if (!empty(self::$enabled_services)): ?>
			<script>
				jQuery(function(){TMF.start_services(['<?php echo implode("', '", self::$enabled_services) ?>']);});
			</script>
		<?php endif;
	}

}

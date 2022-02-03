<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Provides an object to CRUD option values.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Option {

	
	/**
	 * @var  string   the namespace used for this set of options
	 */
	private $_namespace;


	/**
	 * Creates a new option set
	 * 
	 * 	$option = new TMF_Option;
	 * 	$option->facebook_url = 'http://facebook.com';
	 * 	unset($option->twitter_url);
	 * 	$option->set('google_url', 'http://google.com');
	 *
	 * @param   string   $namespace   namespace to be used for requested set of options
	 * @return  void
	 */
	public function __construct($namespace = '') {

		if ($namespace)
			$this->_namespace = str_replace(' ', '', strtoupper($namespace)) . '_';
	}


	/**
	 * Gets a requested option
	 * 
	 * @param   string   $key   name of requested option
	 * @return  string
	 */
	public function __get($key) {
		$option = get_option($this->format_key($key));

		if (is_array($option))
			return stripslashes_deep($option);
		else
			return stripslashes($option);
	}


	/**
	 * Sets a requested option to the set
	 * 
	 * @param   string   $key   name of option to set
	 * @param   string   $value   value of option to set
	 * @return  void
	 */
	public function __set($key, $value) {
		$this->set($key, $value);
	}


	/**
	 * Checks if an option is set
	 * 
	 * @param   string   $key   name of option to check
	 * @return  boolean
	 */
	public function __isset($key) {
		return get_option($this->format_key($key)) ? TRUE : FALSE;
	}


	/**
	 * Unsets an option value
	 * 
	 * @param   string   $key   name of option to unset
	 * @return  void
	 */
	public function __unset($key) {
		delete_option($this->format_key($key));
	}


	/**
	 * Creates a new option set
	 * 
	 * 	TMF_Option::factory()->set('google_url', 'http://google.com')->google_url;
	 *
	 * @param   string   $namespace   namespace to be used for requested set of options
	 * @return  object
	 */
	public function factory($namespace = '') {
		return new TMF_Option($namespace);
	}


	/**
	 * Prepends the namespace, if necessary
	 * 	
	 * @param   string   $key   name of key to format
	 * @return  string
	 */
	public function format_key($key) {
		return isset($this->_namespace) ? strtolower($this->_namespace) . $key : $key;
	}


	/**
	 * Sets a requested option(s) to the set
	 * 
	 * @param   string|array   $key   name of option to set or array of options
	 * @param   string   $value   value of option to set
	 * @return  self
	 */
	public function set($key, $value = NULL) {
		if (is_array($key)):
			foreach($key as $setting_key => $setting_value):
				update_option($this->format_key($setting_key), $setting_value);
			endforeach;
		else:
			update_option($this->format_key($key), $value);
		endif;

		return $this;
	}


}

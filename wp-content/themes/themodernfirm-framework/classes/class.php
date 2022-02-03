<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Loads a class and optionally auto calls the 'filters' and 'actions' methods by default.
 *  
 * The child theme will be checked first for a class file. If no file is found,
 * the framework class file will be loaded. This enables all classes to be overridden
 * by the child theme.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Class {


	/**
	 * @var  boolean   Default error handling
	 */
	public $ignore_not_found = FALSE;


	/**
	 * @var  string   File name of class to be loaded
	 */
	public $file_name;


	/**
	 * @var  array   Default auto_call methods
	 */
	public $auto_call_methods = array('filters', 'actions');


	/**
	 * Creates a new class loader
	 * 
	 * 	$class = new TMF_Class;
	 * 	$class->filename = 'block';
	 * 	$class->ignore_not_found = FALSE;
	 * 	$class->auto_call_methods = array('filters', 'actions');
	 * 	$class->load();
	 *
	 * @param   string			$file_name				file name of class to be loaded
	 * @param   string|array	$auto_call_methods		method(s) which should be auto called after class is loaded
	 * @param   boolean  		$ignore_not_found		throw exception if file is not found
	 * @return  void
	 */
	public function __construct($file_name = NULL, $auto_call_methods = NULL, $ignore_not_found = NULL) {
		$this->file_name = $file_name;

		// set methods to auto call
		if (is_array($auto_call_methods))
			$this->auto_call_methods = $auto_call_methods;

		// set error handling options
		if ($ignore_not_found)
			$this->$ignore_not_found = $ignore_not_found;

	}


	/**
	 * Creates a new class loader via 
	 *
	 * 	TMF_Class::factory('block')->load();
	 * 
	 * @param   string			$file_name				file name of class to be loaded
	 * @param   string|array	$auto_call_methods		method(s) which should be auto called after class is loaded
	 * @param   boolean  		$ignore_not_found		throw exception if file is not found
	 * @return  object
	 */
	public static function factory($file_name = NULL, $auto_call_methods = NULL, $ignore_not_found = NULL) {
		return new TMF_Class($file_name, $auto_call_methods, $ignore_not_found);
	}


	/**
	 * Adds additional methods to auto call on class load
	 * 
	 * @param   string|array   $methods   name of method(s) to add
	 * @return  self
	 */
	public function add_method($methods){
		$this->auto_call_methods = array_merge($this->auto_call_methods, (array) $methods);

		return $this;
	}


	/**
	 * Removes methods to be auto called on class load
	 * 
	 * @param   string|array   $methods   name of method(s) to remove
	 * @return  self
	 */
	public function remove_method($methods){
		$this->auto_call_methods = array_diff($this->auto_call_methods, (array) $methods);

		return $this;
	}


	/**
	 * Removes methods to be auto called on class load
	 * 
	 * @return  self		
	 */
	public function ignore_not_found() {
		$this->ignore_not_found = TRUE;

		return $this;
	}


	/**
	 * Loads a class file and calls any methods set for auto call.
	 * 
	 * @return  self
	 * @throws	TMF_Exception
	 */
	public function load() {
	
		if (!$this->file_name)
			throw new TMF_Exception("A class 'file name' must be set before loading a class.");

		$full_path			= CLASSES_PATH . $this->file_name . '.php';
		$framework_path		= FRAMEWORK_PATH . $full_path;
		$child_path			= THEME_PATH . $full_path;
		
		// Check for file in child theme
		if (file_exists($child_path)):
			include_once $child_path;

		// Check for file in framework
		elseif (file_exists($framework_path)):
			include_once $framework_path;

		// Class file was not found
		elseif ($this->ignore_not_found == FALSE):
			throw new TMF_Exception('Class file not found: ' . CLASSES_PATH . $this->file_name . '.php');

		endif;

		// Auto call methods
		$this->call_methods($this->file_name);

		return $this;
	}


	/**
	 * Formats a class name based upon its file name,
	 * 
	 * @param	string	$file_name   file name of class to convert to class name
	 * @return  string
	 */
	public static function class_name_from_file_name($file_name) {
		// Format file name
		$class_name = str_replace(' ','', ucwords(str_replace('-',' ', $file_name)));

		// Format path
		$class_name = FRAMEWORK_PREFIX . '_' . str_replace(' ', '_', ucwords(str_replace('/',' ', $class_name)));

		return $class_name;
	}


	/**
	 * Calls all methods set for auto call.
	 * 
	 * @param	string	$file_name   file name of class
	 * @return  void
	 * @uses	TMF_Class
	 */
	private function call_methods($file_name){
		if (is_array($this->auto_call_methods)):

			// generate class name
			$class_name = TMF_Class::class_name_from_file_name($file_name);

			foreach($this->auto_call_methods as $method):

				// if method is found, call it
				// ** PHP Bug: PHP will crash if class does not exists when checking with just method_exists
				if (class_exists($class_name) && method_exists($class_name, $method))
					call_user_func($class_name . '::' . $method);

			endforeach;
		endif;
	}
}

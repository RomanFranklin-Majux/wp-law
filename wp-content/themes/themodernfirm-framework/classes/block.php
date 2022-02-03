<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Provides an object to pass variables and display a block of HTML.
 * 
 * This will look for the block in a child theme before loading from the framework.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */

class TMF_Block {


	/**
	 * @var	boolean   Default error handling
	 */
	public $ignore_not_found = FALSE;


	/**
	 * @var	array   Holds variables to pass on to the block
	 */
	private $_data = array();


	/**
	 * @var	boolean   the name of the block file
	 */
	private $_file_name;


	/**
	 * Creates a block renderer
	 * 
	 * 	$block = new TMF_Block;
	 * 	$block->set_filename('header');
	 * 	$block->ignore_not_found = TRUE;
	 * 	$block->render(FALSE);
	 *
	 * @param   string	$file_name   file name of block to be loaded
	 * @param   array    $data   variables to pass on to the block
	 * @param   boolean 	$ignore_not_found   throw exception if file is not found
	 * @return  void
	 */
	public function __construct($file_name = NULL, $data = array(), $ignore_not_found = NULL) {
		global $tmf;
		
		$this->_data = $data;

		if ($file_name)
			$this->set_filename($file_name);

		if ($ignore_not_found)
			$block->ignore_not_found = $ignore_not_found;

		$this->_data['tmf'] = $tmf;
	}


	/**
	 * Gets a varible that has been set
	 * 
	 * @param   string   $key   varible to get
	 * @return  string|integer
	 */
	public function __get($key) {
		if (array_key_exists($key, $this->_data))
			return $this->_data[$key];	
	}


	/**
	 * Sets a variable to pass to the block
	 * 
	 * @param   string   $key   varible name to set
	 * @param   string|integer   $value   varible value to set
	 * @return  void
	 */
	public function __set($key, $value) {
		$this->set($key, $value);
	}


	/**
	 * Creates a new class loader via 
	 *
	 * 	TMF_Class::factory('block')->load();
	 * 
	 * @param   string			$file_name   file name of class to be loaded
	 * @param   string|array	$data   variables to pass on to the block
	 * @param   boolean  		$ignore_not_found   throw exception if file is not found
	 * @return  object
	 */
	public static function factory($file_name = NULL, $data = array(), $ignore_not_found = NULL) {
		return new TMF_Block($file_name, $data, $ignore_not_found);
	}


	/**
	 * Sets a variable(s) to pass to the block
	 * 
	 * @param   string|array   $key   varible name(s) to set
	 * @param   string|integer   $value   varible value to set
	 * @return  self
	 */
	public function set($key, $value = NULL) {
		// if first param is an array...
		if (is_array($key)):
			foreach ($key as $name => $value):
				$this->_data[$name] = $value;
			endforeach;

		// first param is a string
		else:
			$this->_data[$key] = $value;
		endif;

		return $this;
	}


	/**
	 * Sets a file name of a block
	 * 
	 * @param   string   $file_name   the file name of a block
	 * @return  self
	 */
	public function set_filename($file_name) {
		$this->_file_name = $this->format_filename($file_name);

		return $this;
	}


	/**
	 * Renders the contents of a block. 
	 * 
	 * The block will automatically be echoed unless auto_render is set
	 * to false.
	 *
	 * @param   boolean   $auto_render  should block automatically be echoed
	 * @return  void|string
	 * @uses		TMF_Exception
	 */
	public function render($echo = TRUE) {
		$path				= BLOCKS_PATH . $this->_file_name;
		$theme_path			= THEME_PATH . $path;
		$framework_path		= FRAMEWORK_PATH . $path;

		// extract parameters
		extract($this->_data);

		if (!$this->_file_name)
			throw new TMF_Exception("A block 'file name' must be set before rendering.");

		// if auto render is not set, start buffer
		if (!$echo)
			ob_start();

		// check in theme for block
		if (file_exists($theme_path))
			include $theme_path;

		// check in framework for block
		elseif (file_exists($framework_path))
			include $framework_path;		

		// no block found
		else
			$error = TRUE;

		// if auto render is not set, return buffered data
		if (!$echo)
			$ob = ob_get_clean();
		
		if (isset($error) && $error && $this->ignore_not_found != TRUE)
			throw new TMF_Exception('Block file not found: ' . BLOCKS_PATH . $this->_file_name);
		elseif (isset($ob))
			return $ob;

	}	


	/**
	 * Formats a file name properly
	 * 
	 * @param   string   $file_name   the file name of a block
	 * @return  string
	 */
	private function format_filename($file_name) {
		$file_name = strtolower($file_name);

		// if file name doesn't end in .php, add it
		$file_name = (substr($file_name, -3) == '.php') ? $file_name : $file_name . '.php';

		return $file_name;
	}	


	/**
	 * 
	 * @return  self		
	 */
	public function ignore_not_found() {
		$this->ignore_not_found = TRUE;

		return $this;
	}
}

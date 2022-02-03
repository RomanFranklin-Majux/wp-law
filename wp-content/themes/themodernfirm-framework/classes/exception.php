<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Extends the PHP exception class and provides a custom exception handler
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Exception extends Exception {


	/**
	 * @var	string   Template to use for the stack trace
	 */
	public static $stack_trace_template = 'templates/stack-trace';


	/**
	 * @var	string	Template to use for generic error
	 */
	public static $error_template	= 'templates/error';


	/**
	 * @var	boolean  Turn error log on/off globally
	 */
	public static $global_log_errors = TRUE;


	/**
	 * @var	boolean  Weather or not to show a stack trace or generic error
	 */
	public static $show_stack_trace = TRUE;


	/**
	 * @var	boolean  Turn error log on/off locally
	 */
	public static $_local_log_errors = TRUE;


	/**
	 * @var	boolean  Weather or not this exception is fatal
	 */
	public static $_is_fatal = TRUE;


	/**
	 * Creates a new exception
	 * 
	 * 	throw new TMF_Exception('Something broke!', TRUE, TRUE);
	 *
	 * @param   string	$message		error message
	 * @param   boolean  $is_fatal	is exception fatal
	 * @param   boolean 	$log			should the exception be logged
	 * @return  void
	 */
	public function __construct($message, $is_fatal = TRUE, $log = TRUE) {

		$this->_local_log_errors	= $log;
		$this->_is_fatal			= $is_fatal;

		parent::__construct($message);
	}


	/**
	 * Outputs the exception
	 *
	 * @return  void
	 * @uses	TMF_Exception
	 */
	public function __toString(){
		return TMF_Exception::text($this);
	}


	/**
	 * Get a single line of text representing the exception:
	 *
	 * Error [ Code ]: Message ~ File [ Line ]
	 *
	 * @param   Exception $e
	 * @return  string
	 */
	public static function text($e) {
		return	sprintf('%s [ %s ]: %s ~ %s [ %d ]', 
						get_class($e), 
						$e->getCode(), 
						strip_tags($e->getMessage()), 
						$e->getFile(), 
						$e->getLine()
					);
	}


	/**
	 * Outputs a pretty HTML stack trace for uncaught exceptions
	 *
	 * @param   Exception $e
	 * @return  void
	 * @uses	TMF_Exception
	 */
	public static function handler(Throwable $e) {

		// log errors if asked
		if (TMF_Exception::$global_log_errors && TMF_Exception::$_local_log_errors)
			error_log(TMF_Exception::text($e));

		// display error and exit if asked
		if (TMF_Exception::$_is_fatal):
			// Start an output buffer
			ob_clean();

			// If show stack trace...
			if (TMF_Exception::$show_stack_trace)
				include FRAMEWORK_PATH . TMF_Exception::$stack_trace_template .'.php';
			// Else show generic error
			else
				include FRAMEWORK_PATH . TMF_Exception::$error_template . '.php';
	
			// Display the contents of the output buffer
			echo ob_get_clean();

			exit(1);
		endif;
	}
}

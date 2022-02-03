<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Runs functions based on an updated site mode.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_SiteMode {

	public static $modes = array(
							'1' => 'Beta',
							'2'	=> 'Live',
							'3' => 'Maintenance'
						); 

	public function __construct($mode) {

		switch ($mode):
			case 1: // Beta
				$this->beta();
				break;
			case 2: // Live
				$this->live();
				break;
			case 3: // Maintenance
				$this->maintenance();
				break;
		endswitch;

	}

	private function beta () {
		global $wp_option;

		$wp_option->blog_public = 0;
	}

	private function live () {
		global $wp_option;

		$wp_option->blog_public = 1;
	}

	private function maintenance () {}

}

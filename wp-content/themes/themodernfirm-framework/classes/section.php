<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Generates an HTML section using naming conventions
 * for the CSS scaffolding system.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Section {

	private $name;


	public function __construct($section_name) {
		$this->name = $section_name;
		$this->open();
	}


	public static function factory($section_name) {
		return new TMF_Section($section_name);
	}

	/**
	 * Generates an HTML section open.
	 *
	 * @param   string	$section_name   name of section to be opened
	 * @return  void
	 */
	private function open() {
		$section_name = strtolower($this->name);

		?>
			<div id="<?php echo $section_name; ?>-wrapper" class="section-wrapper">
				<div id="<?php echo $section_name; ?>-container" class="section-container">
					<div id="<?php echo $section_name; ?>" class="section">
		<?php
	}


	/**
	 * Generates an HTML section close.
	 *
	 * @param   string	$section_name   name of section to be closed
	 * @return  void
	 */
	public function close() {
		?>
				</div>
			</div>
		</div>
		<?php
	}

}

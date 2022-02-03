<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_ChangeLog extends TMF_AdminPanel {

	protected $name				= 'Change Log';
	protected $menu_title		= 'Change Log';
	protected $parent_slug		= 'tmf-general-settings';
	protected $force_refresh	= TRUE;

	public function render() {

		if(!file_exists(FRAMEWORK_PATH . 'docs/automattic/parse-readme.php')) {
			return '';
		}

		include_once(FRAMEWORK_PATH . 'docs/automattic/parse-readme.php');

		$parser = new WordPress_Readme_Parser();
		$readme = $parser->parse_readme( FRAMEWORK_PATH . 'docs/versioning.txt');

        echo '<div class="change-log">';
    		echo $readme['remaining_content'];
        echo '</div>';

		?>
			<style type="text/css">
				.submit {
					display:  none !important;
				}
			</style>

		<?php

	}

}

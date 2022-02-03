<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Case Result
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_CaseResult extends TMF_Metabox {

	protected $metabox_name		= 'case_result';
	protected $metabox_title	= 'Case Result';


	public function render() {
		global $tmf_option;
		?>
			<table class="tmf-metabox">
				<tr valign="top">
					<td>
						<?php $this->textarea('case_result', 'full small') ?>
					</td>
				</tr>
			</table>
			
		<?php
	}

}

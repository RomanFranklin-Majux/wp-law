<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for attorney badges
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_AttorneyBadges extends TMF_Metabox {

	protected $metabox_name		= 'attorney_badges';
	protected $metabox_title	= 'Badges';

	public function render() {
		?>
			<table class="tmf-metabox">
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Attorney Badges') ?></td>
					<td><?php $this->textarea('badges', 'small') ?></td>
				</tr>
			</table>
		<?php
	}

}

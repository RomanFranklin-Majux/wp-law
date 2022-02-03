<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Member Business Information
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_MemberBusinessInformation extends TMF_Metabox {

	protected $metabox_name		= 'member_business_information';
	protected $metabox_title	= 'Business Information';

	public function render() {
		global $tmf_option;
		?>
			<table class="tmf-metabox">
				<tr>
					<td><?php $this->label('Name', 'business_name') ?></td>
					<td><?php $this->text('business_name', 'medium') ?></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Address', 'business_address') ?></td>
					<td><?php $this->textarea('business_address', 'medium') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Website URL', 'business_url') ?></td>
					<td><?php $this->text('business_url', 'large') ?></td>
				</tr>
			</table>
		<?php
	}

}

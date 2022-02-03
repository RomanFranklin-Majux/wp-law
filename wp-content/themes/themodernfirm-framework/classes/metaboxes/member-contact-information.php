<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Member Contact Information
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_MemberContactInformation extends TMF_Metabox {

	protected $metabox_name		= 'member_contact_information';
	protected $metabox_title	= 'Contact Information';

	public function render() {
		global $tmf_option;
		?>
			<table class="tmf-metabox">
				<tr>
					<td><?php $this->label('Phone 1', 'phone_1') ?></td>
					<td><?php $this->text('phone_1', 'small') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Phone 2', 'phone_2') ?></td>
					<td><?php $this->text('phone_2', 'small') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Fax', 'fax') ?></td>
					<td><?php $this->text('fax', 'small') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Email', 'email') ?></td>
					<td><?php $this->text('email', 'medium') ?></td>
				</tr>
			</table>
		<?php
	}

}

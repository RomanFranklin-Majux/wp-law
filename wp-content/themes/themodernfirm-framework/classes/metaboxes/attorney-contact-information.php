<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for attorney contact information
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_AttorneyContactInformation extends TMF_Metabox {

	protected $metabox_name		= 'attorney_contact_information';
	protected $metabox_title	= 'Attorney Contact Information';

	public function render() {
		global $tmf_option;

		$phone_1_label	= (!empty($tmf_option->attorney_label_phone_1)) ? $tmf_option->attorney_label_phone_1 : 'Phone 1';
		$phone_2_label	= (!empty($tmf_option->attorney_label_phone_2)) ? $tmf_option->attorney_label_phone_2 : 'Phone 2';
		$fax_label		= (!empty($tmf_option->attorney_label_fax)) ? $tmf_option->attorney_label_fax : 'Fax';
		$email_label	= (!empty($tmf_option->attorney_label_email)) ? $tmf_option->attorney_label_email : 'Email';
		?>
			<table class="tmf-metabox">
				<tr>
					<td><?php $this->label('Phone 1 ('. $phone_1_label .')', 'phone_1') ?></td>
					<td>
						<?php $this->text('phone_1', 'small') ?>

						<?php $this->label('Ext.', 'phone_1_ext') ?>
						<?php $this->text('phone_1_ext', 'tiny') ?>
					</td>
				</tr>
				<tr>
					<td><?php $this->label('Phone 2 ('. $phone_2_label .')', 'phone_2') ?></td>
					<td>
						<?php $this->text('phone_2', 'small') ?>

						<?php $this->label('Ext.', 'phone_2_ext') ?>
						<?php $this->text('phone_2_ext', 'tiny') ?>
					</td>
				</tr>
				<tr>
					<td><?php $this->label('Fax ('. $fax_label .')', 'fax') ?></td>
					<td><?php $this->text('fax', 'small') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Email ('. $email_label .')', 'email') ?></td>
					<td><?php $this->text('email', 'medium') ?></td>
				</tr>
			</table>
		<?php
	}

}

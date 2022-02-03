<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for attorney Links
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_AttorneyLinks extends TMF_Metabox {

	protected $metabox_name		= 'attorney_links';
	protected $metabox_title	= 'Social Links';

	public function render() {
		?>
			<table class="tmf-metabox">
				<tr>
					<td><?php $this->label('Facebook') ?></td>
					<td><?php $this->text('facebook', 'large') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Avvo') ?></td>
					<td><?php $this->text('avvo', 'large') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('LinkedIn') ?></td>
					<td><?php $this->text('linkedin', 'large') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Twitter') ?></td>
					<td><?php $this->text('twitter', 'large') ?></td>
				</tr>
				<tr>
					<td><?php $this->label('Google +', 'google') ?></td>
					<td><?php $this->text('google', 'large') ?></td>
				</tr>
			</table>
			
		<?php
	}

}

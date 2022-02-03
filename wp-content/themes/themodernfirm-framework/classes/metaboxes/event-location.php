<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for a Event location
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_EventLocation extends TMF_Metabox {

	protected $metabox_name		= 'location';
	protected $metabox_title	= 'Location';

	public function render() {
		?>
			<table class="tmf-metabox">
				<tbody>
					<tr>
						<td><?php $this->label('Location Name') ?></td>
						<td><?php $this->text('location_name', 'medium') ?></td>
					</tr>
					<tr>
						<td class="top"><?php $this->label('Address', 'location_address_1') ?></td>
						<td>
							<?php $this->text('location_address_1', 'medium') ?><br/>
							<?php $this->text('location_address_2', 'medium') ?>
						</td>
					</tr>
					<tr>
						<td><?php $this->label('City', 'location_city') ?></td>
						<td><?php $this->text('location_city', 'small') ?></td>
					</tr>
					<tr>
						<td><?php $this->label('State', 'location_state') ?></td>
						<td><?php $this->text('location_state', 'small') ?></td>
					</tr>
					<tr>
						<td><?php $this->label('Zipcode', 'location_zipcode') ?></td>
						<td><?php $this->text('location_zipcode', 'small') ?></td>
					</tr>
				</tbody>
			</table>
		<?php
	}

}

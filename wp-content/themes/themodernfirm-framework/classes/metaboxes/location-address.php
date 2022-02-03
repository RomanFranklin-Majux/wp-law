<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for a location address
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2020 The Modern Firm, LLC
 */
class TMF_Metabox_LocationAddress extends TMF_Metabox {

	protected $metabox_name		= 'location_address';
	protected $metabox_title	= 'Address';

	public function render() {
		?>
			<table class="tmf-metabox">
				<tbody>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Building Name') ?>
						</td>
						<td>
							<?php $this->text('building_name', 'medium') ?>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Address', 'address_1') ?>
						</td>
						<td>
							<?php $this->text('address_1', 'medium') ?><br/>
							<?php $this->text('address_2', 'medium') ?>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('City') ?>
						</td>
						<td>
							<?php $this->text('city', 'small') ?>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('State') ?>
						</td>
						<td>
							<?php $this->text('state', 'small') ?>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Zipcode') ?>
						</td>
						<td>
							<?php $this->text('zipcode', 'tiny') ?>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			<b><?php $this->label('Debugging Section') ?></b>
			<br />
			<br />
			<table class="tmf-metabox">
				<tbody>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Map Address') ?>
						</td>
						<td>
							<?php $this->text('custom_map_address', 'medium') ?>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row"></td>
						<td>
							<em>This field is optional and should be used primarily used when doing map troubleshooting. showing the correct location on the map based on the values from the fields above. 
							Expected Format:</em><br /><br />
							<span style="color:gray;">Street Number Street Name, City, State, Zipcode.  (Please note comma placements)</span><br /><br />
							<em>The best way to find the correct/business address format is to go to Google maps and copy it from clients' listing. IE: <a href="<?php echo FRAMEWORK_URI .'assets/images/location-help.png' ?>" target="_blank"> Screenshot link</a></em>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			<b><?php $this->label('Map Display Settings') ?></b>
			<br />
			<br />
			<table class="tmf-metabox">
				<tbody>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Remove Firm Name') ?>
						</td>
						<td>
							<?php $this->checkbox('remove_firm_name', FALSE) ?> <em>Removes firm name from the backend verification process only. Won't affect the frontend of the website.</em>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Remove Map') ?>
						</td>
						<td>
							<?php $this->checkbox('remove_map', FALSE) ?> <em>Check this box to remove the map on the contact page.</em>
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			<b><?php $this->label('Direction Display Settings') ?></b>
			<br />
			<br />
			<table class="tmf-metabox">
				<tbody>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Remove Google') ?>
						</td>
						<td>
							<?php $this->checkbox('remove_google_directions', FALSE) ?> <em>Check this box to remove Google of the directions on the contact page.</em>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Remove Bing') ?>
						</td>
						<td>
							<?php $this->checkbox('remove_bing_directions', FALSE) ?> <em>Check this box to remove Bing of the directions on the contact page.</em>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Remove Mapquest') ?>
						</td>
						<td>
							<?php $this->checkbox('remove_mapquest_directions', FALSE) ?> <em>Check this box to remove Mapquest of the directions on the contact page.</em>
						</td>
					</tr>
					<tr valign="top">
						<td scope="row">
							<?php $this->label('Remove All') ?>
						</td>
						<td>
							<?php $this->checkbox('remove_all_directions', FALSE) ?> <em>Check this box to remove all of the directions on the contact page.</em>
						</td>
					</tr>
				</tbody>
			</table>
		<?php
	}

}

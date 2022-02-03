<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_LocationSettings extends TMF_AdminPanel {

	protected $name				= 'Location Settings';
	protected $menu_title		= 'Settings';
	protected $parent_slug		= 'edit.php?post_type=location';


	public function get_locations () {
		$posts = get_posts('post_type=location&numberposts=-1&orderby=menu_order&order=ASC');
		return $posts;
	}

	public function before_save () {
		global $wpdb;
		$extra = $this->post_data(TRUE);

		foreach ($extra->locations as $key => $post):
			$wpdb->query("UPDATE $wpdb->posts SET menu_order = $key WHERE ID = $post LIMIT 1");
		endforeach;
	}

	public function render () {
	?>
		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Sort Order</h3>
		<p class="description">
			This is the order in which locations will be shown when displayed in a list.
		</p>
		<table class="form-table indent">
			<tr>
				<td>
					<div class="tags-container tags-box" data-object-name="TMF_x[location_settings][locations]">
						<?php
							$count = 1;
							foreach ($this->get_locations() as $location): ?>
							<div class="location tag">
								<input type="hidden" name="TMF_x[location_settings][locations][<?php echo $count ?>]" value="<?php echo $location->ID ?>"/>
								<span class="name"><a href="/wp-admin/post.php?post=<?php echo $location->ID ?>&action=edit" target="_blank"><?php echo $location->post_title ?></a></span>
							</div>
						<?php $count++; endforeach ?>
					</div>
				</td>
			</tr>
		</table>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Image Sizes</h3>
		<table class="form-table">
			<tr>
				<th scope="row">Primary Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_location_image_size_primary_width') ?><?php $this->number('tmf_location_image_size_primary_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_location_image_size_primary_height') ?><?php $this->number('tmf_location_image_size_primary_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_location_image_size_primary_crop') ?> <?php $this->label('Force crop', 'tmf_location_image_size_primary_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">Thumbnail Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_location_image_size_thumbnail_width') ?><?php $this->number('tmf_location_image_size_thumbnail_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_location_image_size_thumbnail_height') ?><?php $this->number('tmf_location_image_size_thumbnail_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_location_image_size_thumbnail_crop') ?> <?php $this->label('Force crop', 'tmf_location_image_size_thumbnail_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">

				</th>
				<td>
					<p class="description">
						These settings will only apply to new images.<br/><br/>
						<b>Force Crop Instructions</b><br/>
						If checked, the image will be cropped to the exact width and height provided. <br/>
						If unchecked, the width and height become maximum allowed dimensions.
					</p>
				</td>
			</tr>
		</table>

		<h3 class="title" style="margin-bottom: 0;">Directory Settings</h3>
		<table class="form-table">
			<tr>
				<th scope="row">Location Redirect</th>
				<td>
					<?php $this->checkbox('tmf_location_archive_link') ?> <?php $this->label('Redirect location links to the Directory Page', 'tmf_location_archive_link') ?>
					<p class="description">
						If checked, all location links will be redirected to the<br/>
						<a href="<?php echo get_post_type_archive_link('location') ?>" target="_blank">Directory Page</a> instead of individual location pages.
					</p>
				</td>
			</tr>
		</table>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">Label Settings</h3>
		<p class="description">
			These labels will appear next to the corresponding data on the site.<br/>
			Some themes may use icons in place of these labels.
		</p>
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Phone 1', 'tmf_location_label_phone_1') ?>
				</th>
				<td>
					<?php $this->text('tmf_location_label_phone_1', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Phone 2', 'tmf_location_label_phone_2') ?>
				</th>
				<td>
					<?php $this->text('tmf_location_label_phone_2', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Fax', 'tmf_location_label_fax') ?>
				</th>
				<td>
					<?php $this->text('tmf_location_label_fax', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Email', 'tmf_location_label_email') ?>
				</th>
				<td>
					<?php $this->text('tmf_location_label_email', 'small') ?>
				</td>
			</tr>

		</table>

	<?php
	}

}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_StaffSettings extends TMF_AdminPanel {

	protected $name				= 'Staff Preferences';
	protected $menu_title		= 'Preferences';
	protected $parent_slug		= 'edit.php?post_type=staff';


	public function get_staff () {
		$posts = get_posts('post_type=staff&numberposts=-1&orderby=menu_order&order=ASC');
		return $posts;
	}

	public function before_save () {
		global $wpdb;
		$extra = $this->post_data(TRUE);

		foreach ($extra->staff as $key => $post):
			$wpdb->query("UPDATE $wpdb->posts SET menu_order = $key WHERE ID = $post LIMIT 1");
		endforeach;
	}

	public function render () {
	?>
		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Sort Order</h3>
		<p class="description">
			This is the order in which staff will be shown when displayed in a list.
		</p>
		<table class="form-table indent">
			<tr>
				<td>
					<div class="tags-container tags-box" data-object-name="TMF_x[staff_preferences][staff]">
						<?php
							$count = 1;
							foreach ($this->get_staff() as $staff): ?>
							<div class="staff tag">
								<input type="hidden" name="TMF_x[staff_preferences][staff][<?php echo $count ?>]" value="<?php echo $staff->ID ?>"/>
								<span class="name"><a href="/wp-admin/post.php?post=<?php echo $staff->ID ?>&action=edit" target="_blank"><?php echo $staff->post_title ?></a></span>
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
					<?php $this->label('Width: ', 'tmf_staff_image_size_primary_width') ?><?php $this->number('tmf_staff_image_size_primary_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_staff_image_size_primary_height') ?><?php $this->number('tmf_staff_image_size_primary_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_staff_image_size_primary_crop') ?> <?php $this->label('Force crop', 'tmf_staff_image_size_primary_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">Thumbnail Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_staff_image_size_thumbnail_width') ?><?php $this->number('tmf_staff_image_size_thumbnail_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_staff_image_size_thumbnail_height') ?><?php $this->number('tmf_staff_image_size_thumbnail_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_staff_image_size_thumbnail_crop') ?> <?php $this->label('Force crop', 'tmf_staff_image_size_thumbnail_crop') ?>
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


		<br/>
		<h3 class="title" style="margin-bottom: 0;">Excerpt Settings</h3>
		<p class="description">
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Excerpt Length', 'tmf_staff_excerpt_length') ?>
				</th>
				<td>
					<?php $this->number('tmf_staff_excerpt_length', 'tiny') ?>
					<div class="description">
						The number of characters excerpts should not exceed.<br/>
						Auto-Generated excerpts will always be truncated at this length.
					</div>
				</td>
			</tr>

			<tr>
				<th scope="row">
					Enforce Excerpt Length
				</th>
				<td>
					<?php $this->checkbox('tmf_staff_excerpt_force_trim') ?> <?php $this->label('Enforce excerpt length', 'tmf_staff_excerpt_force_trim') ?>
					<div class="description">
						If the excerpt length exceeds 'Excerpt Length' value, <br/>
						then the excerpt will be truncated when displayed.
					</div>
				</td>
			</tr>
		</table>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">Job Title Settings</h3>
		<p class="description">
		<table class="form-table">
			<tr>
				<th scope="row">
					Display Job Titles as Links
				</th>
				<td>
					<?php $this->checkbox('tmf_staff_job_title_links') ?> <?php $this->label('Enabled', 'tmf_staff_job_title_links') ?>
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
					<?php $this->label('Phone 1', 'tmf_staff_label_phone_1') ?>
				</th>
				<td>
					<?php $this->text('tmf_staff_label_phone_1', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Phone 2', 'tmf_staff_label_phone_2') ?>
				</th>
				<td>
					<?php $this->text('tmf_staff_label_phone_2', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Fax', 'tmf_staff_label_fax') ?>
				</th>
				<td>
					<?php $this->text('tmf_staff_label_fax', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Email', 'tmf_staff_label_email') ?>
				</th>
				<td>
					<?php $this->text('tmf_staff_label_email', 'small') ?>

				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('vCard', 'tmf_staff_label_vcard') ?>
				</th>
				<td>
					<?php $this->text('tmf_staff_label_vcard', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Resume', 'tmf_staff_label_resume') ?>
				</th>
				<td>
					<?php $this->text('tmf_staff_label_resume', 'small') ?>
				</td>
			</tr>

		</table>

	<?php
	}

}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_NewsSettings extends TMF_AdminPanel {

	protected $name				= 'News Preferences';
	protected $menu_title		= 'Preferences';
	protected $parent_slug		= 'edit.php?post_type=news';

	public function render () {
	?>
		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Image Sizes</h3>
		<table class="form-table">
			<tr>
				<th scope="row">Primary Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_news_image_size_primary_width') ?><?php $this->number('tmf_news_image_size_primary_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_news_image_size_primary_height') ?><?php $this->number('tmf_news_image_size_primary_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_news_image_size_primary_crop') ?> <?php $this->label('Force crop', 'tmf_news_image_size_primary_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">Thumbnail Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_news_image_size_thumbnail_width') ?><?php $this->number('tmf_news_image_size_thumbnail_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_news_image_size_thumbnail_height') ?><?php $this->number('tmf_news_image_size_thumbnail_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_news_image_size_thumbnail_crop') ?> <?php $this->label('Force crop', 'tmf_news_image_size_thumbnail_crop') ?>
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
		<h3 class="title" style="margin-bottom: 0;">Date Settings</h3>
		<p class="description">
		<table class="form-table">
			<tr>
				<th scope="row">
					Hide News Post Dates
				</th>
				<td>
					<?php $this->checkbox('tmf_news_hide_date') ?> <?php $this->label('Hide dates from all news posts', 'tmf_news_hide_date') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php $this->label('Date Format', 'tmf_news_date_format') ?>
				</th>
				<td>
					<?php $this->text('tmf_news_date_format', 'small') ?>
					<div class="description">
						Dates are generated using PHP date formatting.<br/>
						<a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Click here for more information.</a>
					</div>
				</td>
			</tr>
		</table>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">Author Settings</h3>
		<p class="description">
		<table class="form-table">
			<tr>
				<th scope="row">
					Hide Author
				</th>
				<td>
					<?php $this->checkbox('tmf_news_hide_author') ?> <?php $this->label('Hide author name and image from all news posts', 'tmf_news_hide_author') ?>
				</td>
			</tr>
		</table>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">Excerpt Settings</h3>
		<p class="description">
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Excerpt Length', 'tmf_news_excerpt_length') ?>
				</th>
				<td>
					<?php $this->number('tmf_news_excerpt_length', 'tiny') ?>
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
					<?php $this->checkbox('tmf_news_excerpt_force_trim') ?> <?php $this->label('Enforce excerpt length', 'tmf_news_excerpt_force_trim') ?>
					<div class="description">
						If the excerpt length exceeds 'Excerpt Length' value, <br/>
						then the excerpt will be truncated when displayed.
					</div>
				</td>
			</tr>
		</table>

	<?php
	}

}

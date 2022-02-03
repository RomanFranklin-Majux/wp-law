<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_EventSettings extends TMF_AdminPanel {

	protected $name				= 'Event Preferences';
	protected $menu_title		= 'Preferences';
	protected $parent_slug		= 'edit.php?post_type=event';

	public function render () {
		global $tmf;
	?>
		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Image Sizes</h3>
		<table class="form-table">
			<tr>
				<th scope="row">Primary Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_event_image_size_primary_width') ?><?php $this->number('tmf_event_image_size_primary_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_event_image_size_primary_height') ?><?php $this->number('tmf_event_image_size_primary_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_event_image_size_primary_crop') ?> <?php $this->label('Force crop', 'tmf_event_image_size_primary_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">Thumbnail Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_event_image_size_thumbnail_width') ?><?php $this->number('tmf_event_image_size_thumbnail_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_event_image_size_thumbnail_height') ?><?php $this->number('tmf_event_image_size_thumbnail_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_event_image_size_thumbnail_crop') ?> <?php $this->label('Force crop', 'tmf_event_image_size_thumbnail_crop') ?>
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
					<?php $this->label('Date Format', 'tmf_event_event_date_format') ?>
				</th>
				<td>
					<?php $this->text('tmf_event_event_date_format', 'small') ?>
					<div class="description">
						Dates are generated using PHP date formatting.<br/>
						<a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Click here for more information.</a>
					</div>
				</td>
			</tr>
		</table>


		<br/>
		<h3 class="title" style="margin-bottom: 0;">Excerpt Settings</h3>
		<p class="description">
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Excerpt Length', 'tmf_event_excerpt_length') ?>
				</th>
				<td>
					<?php $this->number('tmf_event_excerpt_length', 'tiny') ?>
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
					<?php $this->checkbox('tmf_event_excerpt_force_trim') ?> <?php $this->label('Enforce excerpt length', 'tmf_event_excerpt_force_trim') ?>
					<div class="description">
						If the excerpt length exceeds 'Excerpt Length' value, <br/>
						then the excerpt will be truncated when displayed.
					</div>
				</td>
			</tr>
		</table>

		<?php if (TMF_EventRegistration::is_enabled()): ?>
			<br/>
			<h3 class="title" style="margin-bottom: 0;">Registration Settings</h3>
			<p class="description">
			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Wufoo Credit Form', 'tmf_registration_form_credit') ?>
					</th>
					<td>
						<?php $this->text('tmf_registration_form_credit', 'small') ?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<?php $this->label('Wufoo Check Form', 'tmf_registration_form_check') ?>
					</th>
					<td>
						<?php $this->text('tmf_registration_form_check', 'small') ?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<?php $this->label('Event Field ID', 'tmf_registration_form_field_event') ?>
					</th>
					<td>
						<?php $this->text('tmf_registration_form_field_event', 'small') ?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<?php $this->label('Date Field ID', 'tmf_registration_form_field_date') ?>
					</th>
					<td>
						<?php $this->text('tmf_registration_form_field_date', 'small') ?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<?php $this->label('Summary Field ID', 'tmf_registration_form_field_summary') ?>
					</th>
					<td>
						<?php $this->text('tmf_registration_form_field_summary', 'small') ?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<?php $this->label('Amount Field ID', 'tmf_registration_form_field_amount') ?>
					</th>
					<td>
						<?php $this->text('tmf_registration_form_field_amount', 'small') ?>
					</td>
				</tr>
			</table>
		<?php endif ?>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">RSVP Settings</h3>
		<p class="description">
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Default Notification Email', 'tmf_event_rsvp_default_email') ?>
				</th>
				<td>
					<?php $this->text('tmf_event_rsvp_default_email', 'large') ?>
					<p class="description">
						RSVP submissions will be sent to this address by default. Specificy multiple addresses using a comma separated list.
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Email Subject', 'tmf_event_rsvp_subject') ?>
				</th>
				<td>
					<?php $this->text('tmf_event_rsvp_subject', 'large') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Email Message', 'tmf_event_rsvp_message') ?>
				</th>
				<td>
					<?php wp_editor(stripslashes($tmf->option()->event_rsvp_message), 'tmf-event-settings-rsvp-message', array('textarea_name' => 'TMF[event_preferences][tmf_event_rsvp_message]', 'textarea_rows' => 10)); ?>
					<p class="description">
						Available Template Codes: {BUSINESS NAME} {SITE LINK} {NOTIFICATION EMAIL} {CURRENT DATE} {EVENT NAME} {EVENT DATE} {EVENT LINK} <br/>
						{EVENT LOCATION} {RSVP NAME} {RSVP EMAIL} {RSVP PHONE} {RSVP GUESTCOUNT} {RSVP MESSAGE}
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Successful Submission Message', 'tmf_event_rsvp_success_message') ?>
				</th>
				<td>
					<?php $this->textarea('tmf_event_rsvp_success_message', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Gravity Form ID', 'tmf_event_rsvp_gf_id') ?>
				</th>
				<td>
					<?php $this->text('tmf_event_rsvp_gf_id', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					RSVP Form Fields
				</th>
				<td>
					<?php $this->checkbox('tmf_event_rsvp_field_name') ?> <span style="display: inline-block; width: 100px;"><?php $this->label('Name', 'tmf_event_rsvp_field_name') ?></span>
					<span style="display: inline-block; width: 100px;">
					<?php $this->checkbox('tmf_event_rsvp_field_name_required') ?> <?php $this->label('Required', 'tmf_event_rsvp_field_name_required') ?></span>
					<span style="display: inline-block; width: 150px;">
						<?php $this->label('Field ID', 'tmf_event_rsvp_gf_name_field') ?>
						<?php $this->text('tmf_event_rsvp_gf_name_field', 'tiny') ?>
					</span><br/>

					<?php $this->checkbox('tmf_event_rsvp_field_email') ?> <span style="display: inline-block; width: 100px;"><?php $this->label('Email', 'tmf_event_rsvp_field_email') ?></span>
					<span style="display: inline-block; width: 100px;">
					<?php $this->checkbox('tmf_event_rsvp_field_email_required') ?> <?php $this->label('Required', 'tmf_event_rsvp_field_email_required') ?></span>
					<span style="display: inline-block; width: 150px;">
						<?php $this->label('Field ID', 'tmf_event_rsvp_gf_email_field') ?>
						<?php $this->text('tmf_event_rsvp_gf_email_field', 'tiny') ?>
					</span><br/>

					<?php $this->checkbox('tmf_event_rsvp_field_phone') ?> <span style="display: inline-block; width: 100px;"><?php $this->label('Phone', 'tmf_event_rsvp_field_phone') ?></span>
					<span style="display: inline-block; width: 100px;">
					<?php $this->checkbox('tmf_event_rsvp_field_phone_required') ?> <?php $this->label('Required', 'tmf_event_rsvp_field_phone_required') ?></span>
					<span style="display: inline-block; width: 150px;">
						<?php $this->label('Field ID', 'tmf_event_rsvp_gf_phone_field') ?>
						<?php $this->text('tmf_event_rsvp_gf_phone_field', 'tiny') ?>
					</span><br/>

					<?php $this->checkbox('tmf_event_rsvp_field_guestcount') ?> <span style="display: inline-block; width: 100px;"><?php $this->label('Guest Count', 'tmf_event_rsvp_field_guestcount') ?></span>
					<span style="display: inline-block; width: 100px;">
					<?php $this->checkbox('tmf_event_rsvp_field_guestcount_required') ?> <?php $this->label('Required', 'tmf_event_rsvp_field_guestcount_required') ?></span>
					<span style="display: inline-block; width: 150px;">
						<?php $this->label('Field ID', 'tmf_event_rsvp_gf_guest_field') ?>
						<?php $this->text('tmf_event_rsvp_gf_guest_field', 'tiny') ?>
					</span><br/>

					<?php $this->checkbox('tmf_event_rsvp_field_message') ?> <span style="display: inline-block; width: 100px;"><?php $this->label('Message', 'tmf_event_rsvp_field_message') ?></span>
					<span style="display: inline-block; width: 100px;">
					<?php $this->checkbox('tmf_event_rsvp_field_message_required') ?> <?php $this->label('Required', 'tmf_event_rsvp_field_message_required') ?></span>
					<span style="display: inline-block; width: 150px;">
						<?php $this->label('Field ID', 'tmf_event_rsvp_gf_message_field') ?>
						<?php $this->text('tmf_event_rsvp_gf_message_field', 'tiny') ?>
					</span><br/>
				</td>
			</tr>

		</table>

	<?php
	}

}

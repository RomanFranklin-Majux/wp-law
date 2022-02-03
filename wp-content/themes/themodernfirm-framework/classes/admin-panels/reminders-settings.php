<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a reminder settings menu in the admin backend
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_RemindersSettings extends TMF_AdminPanel {

	protected $name				= 'Reminders Settings';
	protected $menu_title		= 'Reminders';
	protected $parent_slug		= 'tmf-general-settings';

	public function render() {
		global $wp_option;
	?>
		<br/>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<?php $this->label('On / Off', 'tmf_reminder_enable') ?>
				</th>
				<td>
					<?php $this->checkbox('tmf_reminder_enable') ?><?php $this->label('Enable Reminders', 'tmf_reminder_enable') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Reminder Email', 'tmf_reminder_email') ?>
				</th>
				<td>
					<?php $email = ($wp_option->admin_email && !$wp_option->tmf_reminder_email) ? $wp_option->admin_email : NULL;?>
					<?php $this->text('tmf_reminder_email', 'large', $email) ?>
					<p class="description">
						This email will be sent update reminders. Enter multiple addresses using a comma separated list.
					</p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Reminder After', 'tmf_reminder_after') ?>
				</th>
				<td>
					<span style="vertical-align:baseline;">Send a reminder after </span><?php $this->number('tmf_reminder_after', 'tiny') ?><span style="vertical-align:baseline;"> days of no site updates.</span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Follow-Up Reminders', 'tmf_reminder_repeat') ?>
				</th>
				<td>
					<span style="vertical-align:baseline;">Send follow-up reminders every </span><?php $this->number('tmf_reminder_repeat', 'tiny') ?><span style="vertical-align:baseline;"> until site is updated.</span>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Message Subject', 'tmf_reminder_subject') ?>
				</th>
				<td>
					<?php $this->text('tmf_reminder_subject', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Message', 'tmf_reminder_message') ?>
				</th>
				<td>
					<p class="description">
						<?php $this->textarea('tmf_reminder_message', 'large') ?>
						<p class="description">
							Use the following placeholders to create dynamic subjects and messages:<br/>
							{SITE NAME} {LAST UPDATED} {DAYS SINCE LAST UPDATE} {CURRENT DATE} {SITE URL} {ADMIN URL}
						</p>

					</p>
				</td>
			</tr>

		</table>
	<?php
	}

}

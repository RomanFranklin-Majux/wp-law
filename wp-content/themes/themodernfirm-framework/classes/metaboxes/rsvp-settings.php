<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for event RSVP options
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_RsvpSettings extends TMF_Metabox {

	protected $metabox_name		= 'rsvp-settings';
	protected $metabox_title	= 'RSVP Settings';

	public function render() {
		global $tmf;
		?>

			<table class="tmf-metabox" style="margin-top: 10px">
				<tr>
					<td colspan="2">
						<?php $this->checkbox('rsvp_enabled') ?>
						<?php $this->label('Enable RSVP', 'rsvp_enabled') ?>
					</td>
				</tr>
			</table>

			<table class="tmf-metabox" style="margin-top:5px">
				<tr>
					<td>
						<strong><?php $this->label('Notification Email Address', 'rsvp_email') ?></strong>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php $value = ($this->post->_rsvp_email) ? $this->post->_rsvp_email : $tmf->option()->event_rsvp_default_email; ?>

						<?php $this->text('rsvp_email', 'medium', $value) ?><br/>
						<p class="description">Use a comma separated list for <br/>multiple addresses</p>
					</td>
				</tr>
			</table>

		<?php
	}

}

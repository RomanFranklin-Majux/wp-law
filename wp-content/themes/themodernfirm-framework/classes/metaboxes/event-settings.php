<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for an event date
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_EventSettings extends TMF_Metabox {

	protected $metabox_name		= 'event_settings';
	protected $metabox_title	= 'Event Settings';


	public function before_save() {
		$extra = $this->post_data(TRUE);

		// Combines the date and time fields and saves it as an epoch time.
		$start_date = strtotime($extra->_start_date . ' ' . $extra->_start_hour . ':' . $extra->_start_minute . $extra->_start_ampm);
		$end_date	= strtotime($extra->_end_date . ' ' . $extra->_end_hour . ':' . $extra->_end_minute . $extra->_end_ampm);

		$this->update_post_data('start_date', $start_date);
		$this->update_post_data('end_date', $end_date);
	}

	public function render() {
		?>
			<?php
				$start_date = $this->post->_start_date ? $this->post->_start_date : time();
				$end_date	= $this->post->_end_date ? $this->post->_end_date : time() + 3600;
			?>
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('show_title', TRUE) ?>
			<?php $this->label('Display Title On Event Page', 'show_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?><br/><br/>

			<table style="float: left; margin-right: 25px;">
				<tr>
					<td colspan="2" style="padding-top: 5px">
						<strong>Start:</strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php $this->label('Date', 'start_date') ?>
					</td>
					<td>
						<?php $this->text('start_date', 'x-small datepicker', date('m/d/Y', $start_date), TRUE) ?>
					</td>
				</tr>

				<tr>
					<td>
						<?php $this->label('Time', 'start_hour') ?>
					</td>
					<td>
						<?php $this->selectbox('start_hour', TMF_Time::$hours, NULL, date('h', $start_date), NULL, TRUE) ?>:
						<?php $this->selectbox('start_minute', TMF_Time::$minutes, NULL, date('i', $start_date), NULL, TRUE) ?>
						<?php $this->selectbox('start_ampm', TMF_Time::$ampm, NULL, date('A', $start_date), NULL, TRUE) ?>
					</td>
				</tr>
			</table>
			<table style="float: left">
				<tr>
					<td colspan="2" style="padding-top: 5px">
						<strong>End:</strong>
					</td>
				</tr>

				<tr>
					<td>
						<?php $this->label('Date', 'end_date') ?>
					</td>
					<td>
						<?php $this->text('end_date', 'x-small datepicker', date('m/d/Y', $end_date), TRUE) ?>
					</td>
				</tr>

				<tr>
					<td>
						<?php $this->label('Time', 'end_hour') ?>
					</td>
					<td>
						<?php $this->selectbox('end_hour', TMF_Time::$hours, NULL, date('h', $end_date), NULL, TRUE) ?>:
						<?php $this->selectbox('end_minute', TMF_Time::$minutes, NULL, date('i', $end_date), NULL, TRUE) ?>
						<?php $this->selectbox('end_ampm', TMF_Time::$ampm, NULL, date('A', $end_date), NULL, TRUE) ?>
					</td>
				</tr>
			</table>

			<div class="clear"></div>

			<script>
				jQuery(document).ready(function($) {
					$(".datepicker").datepicker();
				});
			 </script>
		<?php
	}

}

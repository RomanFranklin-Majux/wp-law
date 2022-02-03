<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Sends email reminders depending on the last site update
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Reminder {

	private $last_item_update;

	public static function actions() {
		add_action('admin_init' , array('TMF_Reminder', 'update_last_login'));
	}


	public function __construct() {
		global $tmf_option;

		// Check if reminder is turned on
		if ($tmf_option->reminder_enable):

			// Only run once every 6 hours.
			if (($this->current_time() - $this->last_checked()) > 21600):
				$this->check();
			endif;

		endif;
	}


	public function check() {
		global $tmf_option;

		// update reminder check interval with current time
		$tmf_option->reminder_last_checked = $this->current_time();

		$remind_after = $tmf_option->reminder_after * 24 * 60 * 60; // convert to seconds
		$remind_repeat = $tmf_option->reminder_repeat * 24 * 60 * 60; // convert to seconds

		// If reminder has never been sent and it has been longer than the number of days in remind after since login
		if (!$tmf_option->reminder_last_sent && (($this->current_time() - $this->last_login()) > $remind_after)):
			$this->send_email();

		// If a reminder has already been sent and it has been longer than the number of days in follow up reminders.
		elseif ($tmf_option->reminder_last_sent && (($this->current_time() - $tmf_option->reminder_last_sent) > $remind_repeat)):
			$this->send_email();

		endif;

	}


	public function send_email() {
		global $tmf_option, $wp_option;

		$to		 = $tmf_option->reminder_email;
		$subject = $tmf_option->reminder_subject;
		$message = $tmf_option->reminder_message;

		$subject = $this->template_placeholders($subject);
		$message = $this->template_placeholders($message);

		$headers = 'From: Administrator <'. $wp_option->admin_email .'>' . "\r\n";
		$mail = wp_mail($to, $subject, $message, $headers);

		$tmf_option->reminder_last_sent = $this->current_time();
	}


	public function last_update () {
		global $wpdb;

		// Check for cached results.
		if ($this->last_item_update)
			return $this->last_item_update;

		$last_post = $wpdb->get_row("SELECT post_modified_gmt FROM $wpdb->posts WHERE post_status IN ('publish', 'upcoming-event') ORDER BY post_modified DESC");
 		$last_updated_date = get_date_from_gmt($last_post->post_modified_gmt, 'U');

 		// Cache results.
 		$this->last_item_update = $last_updated_date;

 		return $last_updated_date;
	}

	public function last_login () {
		global $tmf_option;
		return $tmf_option->reminder_last_login;
	}

	public static function update_last_login () {
		global $tmf_option;

		$tmf_option->reminder_last_login = current_time('timestamp', 0);
	}


	public function last_checked () {
		global $tmf_option;
		return $tmf_option->reminder_last_checked;
	}

	public function current_time () {
		return current_time('timestamp', 0);
	}

	public function template_placeholders ($message) {

		$message = str_replace('{SITE NAME}', get_bloginfo('name'), $message);

		$message = str_replace('{LAST UPDATED}', date('l, F j g:ia', $this->last_update()), $message);

		$last_updated = floor(($this->current_time() - $this->last_update()) / 86400);

		$message = str_replace('{DAYS SINCE LAST UPDATE}', $last_updated, $message);

		$message = str_replace('{CURRENT DATE}', date('l, F j g:ia', $this->current_time()), $message);

		$message = str_replace('{SITE URL}', site_url(), $message);

		$message = str_replace('{ADMIN URL}', admin_url(), $message);

		return $message;
	}


}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Rsvp {


	private $post;

	private $data;

	private $confirmation_sent = FALSE;


	public function __construct($post) {
		$this->post = $post;
		if ($this->authorization()):
			$this->data = (object) $_POST['TMF']['rsvp_form'];
			$this->save_gf_entry();
			$this->send_confirmation_email();
		endif;

	}


	public static function factory ($post) {
		return new TMF_Rsvp($post);
	}


	private function authorization () {
		// check for submitted rsvp
		if (empty($_POST['TMF']['rsvp_form']['submit']))
			return false;

		// check for nonce
		if (!isset($_POST['TMF']['rsvp_form']['nonce']) || !wp_verify_nonce($_POST['TMF']['rsvp_form']['nonce'], 'rsvp-' . $_POST['TMF']['rsvp_form']['ID']))
			return false;
		else
			// clear nonce from dataset
			unset($_POST['TMF']['rsvp_form']['nonce']);
	
		return true;
	}

	private function save_gf_entry () {
		global $tmf;

		if ( class_exists('GFAPI') && !empty($tmf->option()->event_rsvp_gf_id) ) {
			$name = !empty($tmf->option()->event_rsvp_gf_name_field) ? $tmf->option()->event_rsvp_gf_name_field : "1.3";
			$email = !empty($tmf->option()->event_rsvp_gf_email_field) ? $tmf->option()->event_rsvp_gf_email_field : "2";
			$phone = !empty($tmf->option()->event_rsvp_gf_phone_field) ? $tmf->option()->event_rsvp_gf_phone_field : "3";
			$guest = !empty($tmf->option()->event_rsvp_gf_guest_field) ? $tmf->option()->event_rsvp_gf_guest_field : "4";
			$message = !empty($tmf->option()->event_rsvp_gf_message_field) ? $tmf->option()->event_rsvp_gf_message_field : "5";

			$entry = array(
				"form_id" => $tmf->option()->event_rsvp_gf_id,
				"6"	     => $this->post->title,
				$name    => $this->data->name,
				$email   => $this->data->email,
				$phone   => $this->data->phone,
				$guest   => $this->data->guestcount,
				$message => $this->data->message
			);

			GFAPI::add_entry($entry);
		}
	}

	private function send_confirmation_email () {
		global $tmf;

		$to			= $this->post->rsvp_email . ',' . $this->data->email;
		$subject	= $this->format_placeholders($tmf->option()->event_rsvp_subject);
		$message	= $this->format_placeholders($tmf->option()->event_rsvp_message);
		$headers	= array('Content-type: text/html', 'From: '. $tmf->wp_option()->blogname .' <'. $tmf->wp_option()->admin_email .'>');

		$mail = wp_mail($to, $subject, $message, $headers);

		if ($mail == TRUE) {
			$this->confirmation_sent = TRUE;
		}
	}

	private function format_placeholders ($text) {
		global $tmf;

		$text = str_replace('{BUSINESS NAME}', $tmf->wp_option()->blogname, $text);
		$text = str_replace('{SITE LINK}', $tmf->site_url(), $text);
		$text = str_replace('{NOTIFICATION EMAIL}', $this->post->rsvp_email, $text);
		$text = str_replace('{EVENT LINK}', $this->post->permalink, $text);
		$text = str_replace('{CURRENT DATE}', TMF_Time::now(), $text);
		$text = str_replace('{EVENT NAME}', $this->post->title, $text);
		$text = str_replace('{EVENT DATE}', $this->post->formatted_start_date(), $text);
		$text = str_replace('{EVENT LOCATION}', $this->post->event_location(), $text);

		$text = str_replace('{RSVP NAME}', $this->data->name, $text);
		$text = str_replace('{RSVP EMAIL}', $this->data->email, $text);
		$text = str_replace('{RSVP PHONE}', $this->data->phone, $text);
		$text = str_replace('{RSVP GUESTCOUNT}', $this->data->guestcount, $text);
		$text = str_replace('{RSVP MESSAGE}', $this->data->message, $text);

		return $text;
	}


	public function render () {
		global $tmf;

		if ($this->post->has_rsvp()): ?>
			<form id="rsvp" action="" method="post" class="event-rsvp editor-content">

				<h2>RSVP For: '<?php echo $this->post->title ?>'</h2>

				<?php if ($this->confirmation_sent): ?>
					<p class="tmf-success">
						<?php echo $tmf->option()->event_rsvp_success_message ?>
					</p>
				<?php endif ?>

				<input type="hidden" name="TMF[rsvp_form][ID]" value="<?php echo $this->post->ID ?>">
				<input type="hidden" name="TMF[rsvp_form][nonce]" value="<?php echo wp_create_nonce('rsvp-' . $this->post->ID) ?>" />

				<?php if (!empty($tmf->option()->event_rsvp_field_name)): ?>
					<label for="event-rsvp-name" class="<?php if (!empty($tmf->option()->event_rsvp_field_name_required)) echo 'required' ?>">Name:</label>
					<input id="event-rsvp-name" name="TMF[rsvp_form][name]" type="text" class="<?php if (!empty($tmf->option()->event_rsvp_field_name_required)) echo 'required' ?>" />
				<?php endif ?>
				
				<?php if (!empty($tmf->option()->event_rsvp_field_email)): ?>
					<label for="event-rsvp-email" class="<?php if (!empty($tmf->option()->event_rsvp_field_email_required)) echo 'required' ?>">Email:</label>
					<input id="event-rsvp-email" name="TMF[rsvp_form][email]" type="text" class="<?php if (!empty($tmf->option()->event_rsvp_field_email_required)) echo 'required' ?>" />		
				<?php endif ?>

				<?php if (!empty($tmf->option()->event_rsvp_field_phone)): ?>
					<label for="event-rsvp-phone" class="<?php if (!empty($tmf->option()->event_rsvp_field_phone_required)) echo 'required' ?>">Phone Number:</label>
					<input id="event-rsvp-phone" name="TMF[rsvp_form][phone]" type="text" class="<?php if (!empty($tmf->option()->event_rsvp_field_phone_required)) echo 'required' ?>" />
				<?php endif ?>

				<?php if (!empty($tmf->option()->event_rsvp_field_guestcount)): ?>
					<label for="event-rsvp-guestcount" class="<?php if (!empty($tmf->option()->event_rsvp_field_guestcount_required)) echo 'required' ?>">Number of Guests Attending:</label>
					<input id="event-rsvp-guestcount" name="TMF[rsvp_form][guestcount]" type="text" class="<?php if (!empty($tmf->option()->event_rsvp_field_guestcount_required)) echo 'required' ?>" />
				<?php endif ?>

				<?php if (!empty($tmf->option()->event_rsvp_field_message)): ?>
					<label for="event-rsvp-message" class="<?php if (!empty($tmf->option()->event_rsvp_field_message_required)) echo 'required' ?>">Message:</label>
					<textarea id="event-rsvp-message" name="TMF[rsvp_form][message]" class="<?php if (!empty($tmf->option()->event_rsvp_field_message_required)) echo 'required' ?>"></textarea>
				<?php endif ?>

				<br/>

				<input id="event-rsvp-submit" class="tmf-button medium" type="submit" name="TMF[rsvp_form][submit]" value="RSVP For Event">

			</form>
			<script>
				jQuery(document).ready(function () {
					jQuery('#rsvp').submit(function(e){
						jQuery('.rsvp-error').remove();

						jQuery('input.required, textarea.required').each(function(){
							jQuery(this).attr('style', '');
						});

						jQuery('input.required, textarea.required').each(function(){
							if (jQuery(this).val() == ''){
								jQuery(this).css({borderColor: '#F00'});
								jQuery(this).after('<span class="rsvp-error" style="display: inline-block; margin-left: 10px;color: #f00">Required</span>');
							}
						});

						if (jQuery('.rsvp-error').length !== 0){
							jQuery('#rsvp h2').after('<p class="rsvp-error" style="color: #F00;">Please make sure you have entered all the required fields.</p>');
							e.preventDefault();
							return false;
						}
					});
				});
			</script>
		<?php endif;
	}


}

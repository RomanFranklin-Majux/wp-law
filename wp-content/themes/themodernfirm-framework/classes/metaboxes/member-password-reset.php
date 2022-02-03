<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Member Password Reset
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_MemberPasswordReset extends TMF_Metabox {


	protected $metabox_name		= 'member_password_reset';
	protected $metabox_title	= 'Reset Password';


	public function before_save() {
		global $tmf;

		$extra = $this->post_data(TRUE);

		if (!empty($extra->_reset_password) && $extra->_reset_password === 'true'):
			$password = TMF_Text::random_string();
			$password_hash = TMF_AssociationMember::generate_password_hash($password);
			$this->update_post_data('password', $password_hash);
			$this->update_post_data('auth_token', '');
			$this->update_post_data('auth_expires', '');

			$site_name	= $tmf->wp_option()->blogname;
			$email		= $this->post->_email;
			$name		= $this->post->_first_name;
			$subject	= 'Your password for "'. $site_name .'" has been reset.';
			$edit_url	= get_permalink($tmf->option()->association_member_edit_page) . '#update-password';
			
			$message = $tmf->block('association/member-password-reset-email')
				->set('name', $name)
				->set('email', $email)
				->set('password', $password)
				->set('edit_url', $edit_url)
				->set('site_name', $site_name)
				->render(FALSE);

			wp_mail($email, $subject, $message);

		endif;
	}


	public function render() {
		global $tmf_option;
		?>
			<table class="tmf-metabox" style="margin-top: 10px">
				<tr>
					<td colspan="2">
						<?php $this->checkbox('reset_password', FALSE, NULL, TRUE) ?>
						<?php $this->label('Reset member password', 'reset_password') ?>
						<br /><br />
						<p class="description">This will send a new password to the member.</p>
					</td>
				</tr>
			</table>
			
		<?php
	}

}

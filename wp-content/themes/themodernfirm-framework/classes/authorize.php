<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Authorize {

	const AUTH_KEY = '3fj318a10SFmeT9azDGM90GKpeF344m18Fmo24m4G4M922GWGV9OMWAP';

	static $new_auth = FALSE;

	private $post;


	private $is_authorized = FALSE;


	public static function actions () {
		add_action('send_headers', array('TMF_Authorize', 'check_for_post_data'));
	}

	public function __construct($post = NULL) {
		global $posts;
		$this->post = (empty($post)) ? $posts[0]->tmf : $post->tmf;

		if ($this->post->is_password_protected() == FALSE || self::$new_auth == TRUE):
			$this->is_authorized = TRUE;
		else:
			if ($this->has_authorize_cookie()):
				$this->is_authorized = TRUE;
			else:
				$this->render_login_form();
			endif;
		endif;
	}


	private function has_authorize_cookie () {
		return (!empty($_COOKIE['TMF_basic_authorize_' . $this->post->ID]) && $_COOKIE['TMF_basic_authorize_' . $this->post->ID] == hash_hmac('md5', $this->post->ID, self::AUTH_KEY));
	}


	public static function check_for_post_data () {
		global $tmf, $wpdb;

		if (!empty($_POST['TMF']['basic_authorize']['password'])):

			$page_id = $_POST['TMF']['basic_authorize']['ID'];
			$post = $tmf->posts(array('id' => $_POST['TMF']['basic_authorize']['ID'], 'post_type' => 'any'))->to_single();

			if ($_POST['TMF']['basic_authorize']['password'] == $post->tmf->password):
				setcookie('TMF_basic_authorize_' . $page_id, hash_hmac('md5', $page_id, self::AUTH_KEY) , time() + 38400);
				self::$new_auth = TRUE;
				return TRUE;
			endif;
		endif;

		return FALSE;
	}



	private function render_login_form () {
		?>
			<form id="tmf-basic-authorize" method="post" action="">
				<input type="hidden" name="TMF[basic_authorize][ID]" value="<?php echo $this->post->ID ?>">
				<input type="hidden" name="TMF[basic_authorize][nonce]" value="<?php echo wp_create_nonce('basic-auth-' . $this->post->ID) ?>" />

				<h1 id="page-title"><?php echo $this->post->title ?></h1>
				<h2>This page requires a password.</h2>
				<?php if (!empty($_POST['TMF']['basic_authorize']['submit'])): ?>
					<br/>
					<p class="tmf-error">
						The password you entered was incorrect. Please try again.
					</p>
				<?php endif ?>
				<br/>
				<label for"tmf-basic-authorize-password">Password:</label>
				<input id="tmf-basic-authorize-password" type="password" name="TMF[basic_authorize][password]" /><br/>
				<input type="submit" name="TMF[basic_authorize][submit]" value="Submit" class="tmf-button small" />
			</form>
		<?php
	}


	public function is_authorized () {
		return $this->is_authorized;
	}
}

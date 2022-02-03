<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AssociationMember {


	const COOKIE_KEY = '44e7v867622c48vZw5dP695r8kKwr76tjw87692PTq8Fq62C';
	const PASSWORD_KEY = '8863AAA47mXE35um5Ar496tCNsryVh4dem2j9mszF82nRp7y';
	

	public $data;
	private $edit_messages = array();
	private $login_messages = array();
	private static $instance;


	public function __construct() {
		if (empty(self::$instance)):
			self::$instance = $this;
			add_action('init', array($this, 'authorization_check'));
			add_action('init', array($this, 'profile_edit'), 999);
			add_action('init', array($this, 'password_edit'), 999);
			add_action('init', array($this, 'password_reset'), 999);
			add_action('wp', array($this, 'redirects'), 999);
			add_action('wp', array($this, 'member_csv'), 999);
		endif;
	}


	public static function instance () {
		return (empty(self::$instance)) ? new TMF_AssociationMember : self::$instance;
	}


	public function is_logged_in () {
		return (empty($this->data)) ? FALSE : TRUE;
	}


	public function has_login_messages () {
		return (!empty($this->login_messages));
	}


	public function get_login_messages () {
		return $this->login_messages;
	}


	public function has_edit_messages () {
		return (!empty($this->edit_messages));
	}


	public function get_edit_messages () {
		return $this->edit_messages;
	}


	public function account_url () {
		global $tmf;

		return get_permalink($tmf->option()->association_member_account_page);
	}


	public function edit_profile_url () {
		global $tmf;
		
		return get_permalink($tmf->option()->association_member_edit_page);
	}


	public function get_available_professional_areas () {
		$terms = get_terms('professional-areas', array('parent' => 0, 'hide_empty' => FALSE));
		$professional_areas = array();

		foreach ($terms as $term):
			$professional_areas[$term->term_id]['id'] = $term->term_id;
			$professional_areas[$term->term_id]['name'] = $term->name;
			$professional_areas[$term->term_id]['sub_areas'] = array();

			$subterms = get_terms('professional-areas', array('parent' => $term->term_id, 'hide_empty' => FALSE));

			foreach ($subterms as $subterm):
				$professional_areas[$term->term_id]['sub_areas'][$subterm->term_id]['id']	= $subterm->term_id;
				$professional_areas[$term->term_id]['sub_areas'][$subterm->term_id]['name'] = $subterm->name;
			endforeach;
		endforeach;

		return $professional_areas;
	}

	public function member_csv () {
		global $tmf;

		if (is_admin() && $_GET['download_member_csv'] == 'true'):
			header("Content-Type: text/csv");
			header("Content-Disposition: attachment; filename=members.csv");
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: 0");

			$params = array(
				'post_type'		=> 'member',
				'posts_per_page'=> -1,
				'status'		=> 'publish',
			);

			$data = array(
			    array("First Name", "Last Name", "Email"),
			);

			$members = $tmf->posts($params)->to_array();

			foreach($members as $member):
				$data[] = array($member->_first_name, $member->_last_name, $member->_email);
			endforeach;

			$output = fopen("php://output", "w");
			foreach ($data as $row) {
				fputcsv($output, $row);
			}

			fclose($output);
			die;
		endif;
	}


	public function restricted_page_ids () {
		global $tmf;

		$restricted =  array(
			(int) $tmf->option()->association_member_account_page, 
			(int) $tmf->option()->association_member_edit_page, 
		);

		$set_pages = $tmf->option()->member_restricted_pages;

		if (is_array($set_pages)):
			foreach($set_pages as $page):
				$restricted[] = (int) $page;
			endforeach;
		endif;

		return $restricted;
	}


	public function redirects () {
		global $tmf;
		$current_id = get_queried_object_id();

		if ($current_id === 0)
			return;

		if(empty($tmf->option()->post_type_member))
			return;

		if ($this->is_logged_in() === FALSE):
			if (in_array($current_id, $this->restricted_page_ids())):
				header('Location: '. get_permalink($tmf->option()->association_member_login_page) .'?redirect=' . get_permalink($current_id));
				die;
			endif;
		else:
			if ($current_id === (int) $tmf->option()->association_member_login_page):
				header('Location: '. get_permalink($tmf->option()->association_member_account_page));
				die;
			endif;
		endif;
	}


	public function authorization_check () {
		$cookie_data	= (!empty($_COOKIE['TMF_Association_Auth'])) ? $_COOKIE['TMF_Association_Auth'] : null;
		$post_data		= (!empty($_POST['TMF']['association_member_login']) && empty($_POST['TMF']['association_member_password_reset'])) ? $_POST['TMF']['association_member_login'] : null;

		if (!empty($post_data)):
			$this->login_auth($post_data);
		elseif (!empty($cookie_data)):
			$this->token_auth($cookie_data);
		endif;
	}


	public function password_reset () {
		global $tmf;

		if (!empty($_POST['TMF']['association_member_password_reset'])):

			if (empty($_POST['TMF']['association_member_login']['email'])):
				$this->login_messages[] = array('error' => TRUE, 'text' => 'Please enter an email address in the box below to send a password reset email.');
				return;
			endif;

			$params = array(
				'post_type'		=> 'member',
				'posts_per_page'=> 1,
				'status'		=> 'publish',
				'meta_query'	=> array(
					array(
						'key'		=> '_email',
						'value'		=> $_POST['TMF']['association_member_login']['email']
					),
				)
			);

			$member = $tmf->posts($params)->to_single();

			if (!empty($member)):
				$password		= TMF_Text::random_string();
				$password_hash	= self::generate_password_hash($password);

				update_post_meta($member->ID, '_password', $password_hash);
				update_post_meta($member->ID, '_auth_token', '');
				update_post_meta($member->ID, '_auth_expires', '');

				$site_name	= $tmf->wp_option()->blogname;
				$email		= $member->_email;
				$name		= $member->_first_name;
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

				$this->login_messages[] = array('text' => 'Password reset information has been sent to your email address.');

			else:
				$this->login_messages[] = array('error' => TRUE, 'text' => 'The email you provided cannot be found.');
			endif;
		endif;
	}


	public function profile_edit () {
		global $tmf;

		$post_data = (!empty($_POST['TMF']['member_edit'])) ? $_POST['TMF']['member_edit'] : null;
		
		if (!empty($post_data) && $this->is_logged_in()):
			foreach ($post_data as $key => $value):
				if (strpos($key, '_') === 0):
					update_post_meta($this->data->ID, $key, $value);
				endif;
			endforeach;

			wp_update_post(array(
				'ID'			=> $this->data->ID,
				'post_content'	=> addslashes($post_data['member_bio']),
				'post_title'	=> addslashes($post_data['_display_name'])
			));

			$professional_areas = $post_data['professional_areas'];

			wp_delete_object_term_relationships($this->data->ID, 'professional-areas');

			if ($professional_areas[0] !== ''):
				$cat_ids = array_map('intval', $professional_areas);
				$cat_ids = array_unique($cat_ids);
				wp_set_object_terms($this->data->ID, $cat_ids, 'professional-areas');
			endif;

			if (!empty($_FILES['TMF_member_edit_image'])):
				require_once(ABSPATH . 'wp-admin/includes/admin.php');
				$attachment_id = media_handle_upload('TMF_member_edit_image', 0);
					
				if (!is_wp_error($attachment_id)):
					update_post_meta($this->data->ID, '_primary_image', $attachment_id);
					update_post_meta($this->data->ID, '_thumbnail_image', $attachment_id);

					$this->create_member_image($attachment_id, 'primary');
					$this->create_member_image($attachment_id, 'thumbnail');
				endif;
			endif;


			$params = array(
				'post_type'		=> 'member',
				'posts_per_page'=> 1,
				'status'		=> 'publish',
				'p'			=> $this->data->ID
			);

			$member = $tmf->posts($params)->to_single();

			$this->data = $member->tmf;

			$email = $tmf->option()->association_member_edit_notification_email;

			if ($email) {
				$site_name	= $tmf->wp_option()->blogname;
				$name		= $member->_display_name;
				$subject	= 'A member profile has been updated at "'. $site_name .'".';
				$edit_url	= admin_url('post.php?post=' . $member->ID . '&action=edit');

				$message = $tmf->block('association/member-update-email')
					->set('name', $name)
					->set('url', $edit_url)
					->set('site_name', $site_name)
					->render(FALSE);

				wp_mail($email, $subject, $message);
			}

			$this->edit_messages[] = array('message' => TRUE, 'text' => 'Your profile has been updated.');

		endif;
	}


	public function password_edit () {
		global $tmf;

		$post_data = (!empty($_POST['TMF']['member_password'])) ? $_POST['TMF']['member_password'] : null;
		
		if (!empty($post_data) && $this->is_logged_in()):

			if ($post_data['password'] == $post_data['password_repeat']):
			
				update_post_meta($this->data->ID, '_password', self::generate_password_hash($post_data['password']));
			
				$params = array(
					'post_type'		=> 'member',
					'posts_per_page'=> 1,
					'status'		=> 'publish',
					'p'			=> $this->data->ID
				);

				$member = $tmf->posts($params)->to_single();

				$this->data = $member->tmf;

				$this->edit_messages[] = array('message' => TRUE, 'text' => 'Your password has been updated.');

			else:
				$this->edit_messages[] = array('error' => TRUE, 'text' => 'The passwords you entered did not match. Your password was not updated.');

			endif;
		endif;
	}


	public static function generate_password_hash ($password) {
		return hash_hmac('md5', $password, self::PASSWORD_KEY);
	}


	private function create_member_image ($image_id, $type = 'primary') {
		global $tmf_option;

		$width	= $tmf_option->{'member_image_size_'. $type .'_width'} ? $tmf_option->{'member_image_size_'. $type .'_width'} : 500;
		$height = $tmf_option->{'member_image_size_'. $type .'_height'} ? $tmf_option->{'member_image_size_'. $type .'_height'} : 500;
		$crop	= ($tmf_option->{'member_image_size_'. $type .'_crop'} == 1) ? TRUE : FALSE;

		$image_path = _load_image_to_edit_path($image_id);
		$path_info  = pathinfo($image_path);
		$image		= wp_get_image_editor($image_path);
		$directory	= ($type == 'primary') ? PRIMARY_IMAGES_PATH : THUMBNAIL_IMAGES_PATH;

		if (is_wp_error($image))
			return false;

		$path_info['extension'] = strtolower($path_info['extension']);

		if ($path_info['extension'] == 'jpeg')
			$path_info['extension'] = 'jpg';

		$mime = ($path_info['extension'] == 'png') ? 'image/png' : 'image/jpeg';

		$image->resize($width, $height, $crop);
		$image->set_quality(80);
		$image->save(UPLOADS_PATH . $directory . $image_id . '-'. $this->data->ID .'.' . $path_info['extension'], $mime);

		update_post_meta($this->data->ID, '_member_image_type', $path_info['extension']);
	}


	private function login_auth ($post_data) {
		global $tmf;

		$params = array(
			'post_type'		=> 'member',
			'posts_per_page'=> 1,
			'status'		=> 'publish',
			'meta_query'	=> array(
				array(
					'key'		=> '_password',
					'value'		=> self::generate_password_hash($post_data['password'])
				),
				array(
					'key'		=> '_email',
					'value'		=> $post_data['email']
				),
			)
		);

		$member = $tmf->posts($params)->to_single();

		if (!empty($member)):
			$this->data		= $member->tmf;
			$remember_me	= ($post_data['remember'] === 'yes') ? TRUE : FALSE;
			$this->new_auth($remember_me);

			if (!empty($post_data['redirect'])):
				header('Location: '. $post_data['redirect']);
				die;
			else:
				header('Location: '. get_permalink($tmf->option()->association_member_account_page));
				die;
			endif;
		else:
			$this->login_messages[] = array('error' => TRUE, 'text' => 'The login information you provided is incorrect.');
		endif;
	}


	private function token_auth ($cookie_data) {
		global $tmf;

		$params = array(
			'post_type'		=> 'member',
			'posts_per_page'=> 1,
			'status'		=> 'publish',
			'meta_query'	=> array(
				array(
					'key'		=> '_auth_token',
					'value'		=> $cookie_data
				),
				array(
					'key'		=> '_auth_expires',
					'value'		=> time(),
					'compare'	=> '>',
					'type'		=> 'NUMERIC'
				)
			)
		);

		$member = $tmf->posts($params)->to_single();

		if (!empty($member)):
			$this->data = $member->tmf;
			$this->extend_auth();
		endif;
	}


	private function new_auth ($remember_me = TRUE) {
		$expires = ($remember_me) ? time() + 1209600 : time() + 900;
		$token = hash_hmac('md5', TMF_Text::random_string(24), self::COOKIE_KEY);

		$this->update_auth($token, $expires);
	}


	private function extend_auth ($extend_by = 900) {
		$expires	= $this->data->auth_expires + 900;
		$token		= $this->data->auth_token;
		$this->update_auth($token, $expires);
	}


	private function update_auth ($token, $expires) {
		if (!$this->is_logged_in())
			return;

		update_post_meta($this->data->ID, '_auth_token', $token);
		update_post_meta($this->data->ID, '_auth_expires', $expires);

		setcookie('TMF_Association_Auth', $token, $expires, '/');
	}

}

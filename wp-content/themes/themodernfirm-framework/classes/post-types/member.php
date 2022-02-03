<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Custom post type for Member
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_PostType_Member extends TMF_PostType {


	protected $post_type = 'member';
  

	public $options	= array(
		'slug'					=> 'members',
		'singular'				=> 'member',
		'plural'				=> 'members',
		'menu_name'				=> 'Members',
		'description'			=> 'Create and manage association memebers.',
		'no_posts'				=> 'There are currently no members.',
		'has_archive'			=> TRUE,
		'hide_post_status'		=> FALSE,
		'bulk_actions'			=> TRUE,
		'menu_icon'				=> 'dashicons-admin-users'
	);


	public $metaboxes = array(
		'excerpt'							=> array('priority' => 'high', 'context' => 'normal'),
		'full-name'							=> array('priority' => 'high', 'context' => 'normal'),
		'member-contact-information'		=> array('priority' => 'high', 'context' => 'normal'),
		'member-business-information'		=> array('priority' => 'high', 'context' => 'normal'),
		'featured-images'					=> array('context' => 'side'),
		'member-password-reset'				=> array('context' => 'side'),
	);


	public $taxonomy = array(
		'professional-areas' => array(
			'slug'					=> 'professional-areas',
			'label'					=> 'Professional Areas',
			'singular'				=> 'professiona area',
			'plural'				=> 'professiona areas',
			'menu_name'				=> 'Professional Areas',
			'show_in_nav_menus' 	=> TRUE,
			'hierarchical'			=> TRUE,
			'hide_metabox'			=> TRUE
		)
	);


	public $admin_panels = array(
		'member-archive-settings',
		'member-settings'
	);


	public function __construct(){
		parent::__construct();
		add_action('pre_get_posts', array($this, 'modify_loop'));
		add_action('save_post', array($this, 'save'), 100);
	}


	public function modify_loop ($query) {
		if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('member')):
			$query->set('posts_per_page', -1);
			$query->set('meta_key', '_last_name');
			$query->set('orderby', 'meta_value');
			$query->set('order', 'ASC');
		endif;
	}


	public function save ($post_id) {	
		global $tmf;

		if ($this->post_type == get_post_type($post_id) && !in_array(get_post_status($post_id), array('trash', 'draft', 'auto-draft', 'inherit'))):
			$post = get_post($post_id);

			if ($post->post_date == $post->post_modified):

				$password		= TMF_Text::random_string();
				$password_hash	= TMF_AssociationMember::generate_password_hash($password);
				update_post_meta($post_id, '_password', $password_hash);
				update_post_meta($post_id, '_auth_token', '');
				update_post_meta($post_id, '_auth_expires', '');

				$site_name	= $tmf->wp_option()->blogname;
				$email		= $post->_email;
				$name		= $post->_first_name;
				$subject	= 'An account has been created for you on "'. $site_name .'".';
				$edit_url	= get_permalink($tmf->option()->association_member_edit_page) . '#update-password';
				
				$message = $tmf->block('association/new-member-email')
					->set('name', $name)
					->set('email', $email)
					->set('password', $password)
					->set('edit_url', $edit_url)
					->set('site_name', $site_name)
					->render(FALSE);

				wp_mail($email, $subject, $message);
			endif;

		endif;
	}

}

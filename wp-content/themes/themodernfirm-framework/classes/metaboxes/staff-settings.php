<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for staff settings.
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_StaffSettings extends TMF_Metabox {

	protected $metabox_name		= 'staff_settings';
	protected $metabox_title	= 'Staff Settings';

	public function before_save () {
		global $wpdb;
		$linked_user = $this->post_data()->_linked_user;

		// Remove any other staff or attorney linked the same user
		if (!empty($linked_user)):
			$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key ='_linked_user' AND meta_value ='$linked_user' AND post_id != $this->post_id");
		endif;
	}

	// gets an array of users for this site
	public function users () {
		$get_users = get_users('role=administrator');
		$users = array();

		foreach ($get_users as $user):
			$users[$user->ID] = TMF_Text::limit_chars($user->display_name, 30);
		endforeach;

		return $users;
	}

	public function get_locations () {
		$posts = get_posts(array('post_type' => 'location', 'numberposts' => -1));
		$return = array();	

		foreach ($posts as $post):
			$return[$post->ID] = TMF_Text::limit_chars($post->post_title, 30);
		endforeach;

		return $return;

	}

	public function render() {
		?>
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('show_title', TRUE) ?>
			<?php $this->label('Display Title On Staff Page', 'show_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?><br/><br/>

			<?php $this->label('Primary Location') ?><br/>
			<?php $this->combobox('primary_location', $this->get_locations(), '-- Select Location --') ?><br/><br/>


			<?php $this->label('Link To User Account') ?><br/>
			<?php $this->combobox('linked_user', $this->users(), '-- Select User --') ?>
		<?php
	}
	
}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for practice area settings.
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_PracticeAreaSettings extends TMF_Metabox {

	protected $metabox_name		= 'practice_area_settings';
	protected $metabox_title	= 'Practice Area Settings';

	public function before_save () {
		global $wpdb;
		$extra = $this->post_data(TRUE);

		$wpdb->query("UPDATE $wpdb->posts SET post_parent = $extra->_post_parent WHERE ID = $this->post_id LIMIT 1");
	}

	public function posts_of_this_type () {
		$posts = array();
		$get_posts = get_posts(array('post_type' => $this->post_type, 'numberposts' => -1));

		foreach ($get_posts as $post):
			$posts[$post->ID] = TMF_Text::limit_chars($post->post_title, 30);
		endforeach;

		return $posts;
	}

	public function render() {
		?>	
			<div style="padding-bottom: 5px"></div>
			<?php $this->checkbox('show_title', TRUE) ?>
			<?php $this->label('Display Title On Practice Area Page', 'show_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?><br/><br/>

			<?php $this->label('Parent Practice Area', 'post_parent') ?><br/>
			<?php $this->combobox('post_parent', $this->posts_of_this_type(), '-- Select Parent --', $this->post->post_parent, NULL, TRUE) ?>
		<?php
	}

}

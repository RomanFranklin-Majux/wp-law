<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for page settings.
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_PageSettings extends TMF_Metabox {

	protected $metabox_name		= 'page_settings';
	protected $metabox_title	= 'Page Settings';

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
			<?php $this->label('Display Title On Page', 'show_title') ?><br/><br/>

			<?php $this->label('Alternate Title') ?><br/>
			<?php $this->text('alternate_title', 'medium') ?><br/><br/>
	
			<?php if ($templates = get_page_templates()): $template_list = array();?>

				<?php foreach ($templates as $name => $value):
					$template_list[$value] = $name;
				endforeach ?>
				
				<?php $this->label('Page Template', 'wp_page_template') ?><br/>
				<?php $this->combobox('wp_page_template', $template_list, '-- Select Template --', $this->post->wp_page_template) ?>
				<br /><br />
			<?php endif ?>
			
			<?php $this->label('Parent Page', 'post_parent') ?><br/>
			<?php $this->combobox('post_parent', $this->posts_of_this_type(), '-- Select Parent --', $this->post->post_parent, NULL, TRUE) ?>
		<?php
	}

}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_PostMigrate extends TMF_AdminPanel {

	protected $name				= 'Post Migration';
	protected $menu_title		= 'Settings';
	protected $submenu_title	= 'General';
	protected $parent_slug		= NULL;
	protected $no_parent		= TRUE;


	public function before_save () {
		global $wpdb;
		$extra = $this->post_data(TRUE);

		if ($extra->post_type !== "none" && !empty($extra->posts)):
			$wpdb->query("UPDATE $wpdb->posts SET post_type = '$extra->post_type' WHERE ID IN (".implode(',', $extra->posts).")");
		endif;
	}

	public function get_all_posts () {
		global $wpdb;
		$posts = $wpdb->get_results(
			"
			SELECT ID, post_title, post_type
			FROM $wpdb->posts
			WHERE post_type NOT IN ('revision', 'attachment', 'nav_menu_item')
			AND post_status NOT IN ('inherit', 'auto-draft', 'draft', 'trash')
			"
		);

		return $posts;
	}

	public function get_all_post_types () {
		$post_types = get_post_types();
		$arr = array();

		foreach ($post_types as $post_type):
			if (!in_array($post_type, array('revision', 'attachment', 'nav_menu_item'))):
				$arr[] = $post_type;
			endif;
		endforeach;

		sort($arr);
		return $arr;
	}

	public function render() {
		global $tmf_option;
	?>
		<br/>
		<strong>Select All: </strong>
		<select id="migrate-select-all">
			<option> -- Select Post Type --</option>
			<?php foreach ($this->get_all_post_types() as $post_type): ?>
				<option value="<?php echo $post_type ?>"><?php echo $post_type ?></option>
			<?php endforeach ?>
		</select>

		<script>
			(function($) {
				$(function() {
					$('#migrate-select-all').on('change', function() {
						var val = $(this).val();
						$('.migrate-checkbox').each(function(){
							$(this).removeAttr('checked');
							if ($(this).hasClass('type-' + val)){
								$(this).attr('checked', 'checked');
							}
						});
					});
				});
			})(jQuery);
		</script>
		<br /><br />

		<table id="post-migrate">
			<?php foreach ($this->get_all_posts() as $post): ?>
				<tr>
					<td class="cb"><input type="checkbox" value="<?php echo $post->ID ?>" name="TMF_x[post_migration][posts][]" class="migrate-checkbox type-<?php echo $post->post_type ?>" /></td>
					<td class="name"><?php echo TMF_Text::limit_chars($post->post_title, 75) ?></td>
					<td class="type"><?php echo $post->post_type ?></td>
				</tr>
			<?php endforeach ?>
		</table>
		<br />
		<strong>Migrate Selected Posts To: </strong>
		<select name="TMF_x[post_migration][post_type]">
			<option value="none"> -- Select Post Type --</option>
			<?php foreach ($this->get_all_post_types() as $post_type): ?>
				<option value="<?php echo $post_type ?>"><?php echo $post_type ?></option>
			<?php endforeach ?>
		</select>

	<?php
	}

}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_ReviewUsSettings extends TMF_AdminPanel {

	protected $name				= 'Review Us Settings';
	protected $menu_title		= 'Settings';
	protected $parent_slug		= 'edit.php?post_type=review-us';


	public function get_review_us_links () {
		$posts = get_posts('post_type=review-us&numberposts=-1&orderby=menu_order&order=ASC');
		return $posts;
	}

	public function before_save () {
		global $wpdb;
		$extra = $this->post_data(TRUE);

		foreach ($extra->review_us as $key => $post):
			$wpdb->query("UPDATE $wpdb->posts SET menu_order = $key WHERE ID = $post LIMIT 1");
		endforeach;
	}

	public function render () {
	?>
		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Sort Order</h3>
		<p class="description">
			This is the order in which review us links will be shown when displayed in a list.
		</p>
		<table class="form-table indent">
			<tr>
				<td>
					<div class="tags-container tags-box" data-object-name="TMF_x[review_us_settings][review_us]">
						<?php
							$count = 1;
							foreach ($this->get_review_us_links() as $review): ?>
							<div class="review_us tag">
								<input type="hidden" name="TMF_x[review_us_settings][review_us][<?php echo $count ?>]" value="<?php echo $review->ID ?>"/>
								<span class="name"><a href="/wp-admin/post.php?post=<?php echo $review->ID ?>&action=edit" target="_blank"><?php echo $review->post_title ?></a></span>
							</div>
						<?php $count++; endforeach ?>
					</div>
				</td>
			</tr>
		</table>
	<?php
	}

}

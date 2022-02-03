<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for Review Us Link
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Metabox_ReviewUsLink extends TMF_Metabox {

	protected $metabox_name		= 'review-us-url';
	protected $metabox_title	= 'Url';

	public function before_save() {
		global $wpdb;

		$extra = $this->post_data(TRUE);
		$excerpt = addslashes($extra->_review_us_url);
		$wpdb->query("UPDATE $wpdb->posts SET post_excerpt = '$excerpt' WHERE ID = $this->post_id LIMIT 1");

	}

	public function render() {
		global $tmf_option;
		?>
			<table class="tmf-url">
				<tr>
					<td><?php $this->text('review_us_url', 'medium') ?></td>
				</tr>
			</table>
			
		<?php
	}

}

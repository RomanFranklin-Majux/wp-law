<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a meta box for names
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2020 The Modern Firm, LLC
 */
class TMF_Metabox_PracticeAreasBlog extends TMF_Metabox {

	protected $metabox_name		= 'practice_areas_blog';
	protected $metabox_title	= 'Practice Areas Blog Posts';

	public function render() {

		?>
			<table class="tmf-metabox">
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Practice Area Blog Title') ?></td>
					<td><?php $this->text('latest_blog_title', 'large') ?></td>
				</tr><br />
				<tr>
					<td style="vertical-align: top;"><?php $this->label('Practice Area Blog Content') ?></td>
					<td>
						<?php wp_editor(htmlspecialchars_decode($this->post->_latest_blog), 'tmf-metabox-latest-blog-content', array('textarea_name' => 'TMF[practice_areas_blog][_latest_blog]', 'textarea_rows' => 10)); ?>            
					</td>
				</tr>
			</table>
		<?php
	}

}
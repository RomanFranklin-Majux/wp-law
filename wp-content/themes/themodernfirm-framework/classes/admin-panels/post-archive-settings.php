<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_PostArchiveSettings extends TMF_AdminPanel {

	protected $name				= 'Post Directory Page';
	protected $menu_title		= 'Directory Page';
	protected $parent_slug		= 'edit.php';

	public function before_save() {
		$data = $this->post_data(true);
		if( $wpseo_titles = get_option('wpseo_titles') ):

			$wpseo_titles['title-post'] = $data->title_post;
			$wpseo_titles['metadesc-post'] = $data->metadesc_post;

			update_option('wpseo_titles', $wpseo_titles);

		endif;
	}

	public function render () {
		global $tmf_option;
	?>
		<br/>
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Alternate Breadcrumb Text', 'tmf_post_alternate_breadcrumb_text') ?>
				</th>
				<td>
					<?php $this->text('tmf_post_alternate_breadcrumb_text', 'large') ?>
					<p class="description">Leave field empty for default breadcrumb setup.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Title', 'tmf_post_archive_title') ?>
				</th>
				<td>
					<?php $this->text('tmf_post_archive_title', 'large') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Top Content', 'tmf_post_archive_top') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->post_archive_top, 'tmf-post-directory-page-archive-top', array('textarea_name' => 'TMF[post_directory_page][tmf_post_archive_top]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Bottom Content', 'tmf_post_archive_bottom') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->post_archive_bottom, 'tmf-post-directory-page-archive-bottom', array('textarea_name' => 'TMF[post_directory_page][tmf_post_archive_bottom]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

		</table>

		<?php if( $wpseo_titles = get_option('wpseo_titles') ): ?>

			<h1>SEO Settings for Directory Page</h1>

			<h2>Post</h2>
			<em>SEO Settings for Directory Page</em>

			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Title template:', 'title-post') ?>
					</th>
					<td>
						<?php $this->text('title_post', 'large', $wpseo_titles['title-post'], TRUE) ?>
					</td>
				</tr>


				<tr>
					<th scope="row">
						<?php $this->label('Meta description template:', 'metadesc-post') ?>
					</th>
					<td>
						<?php $this->textarea('metadesc_post', 'large', $wpseo_titles['metadesc-post'], TRUE) ?>
					</td>
				</tr>
			</table>

		<?php endif; ?>

	<?php
	}

}

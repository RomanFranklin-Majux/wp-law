<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_AttorneyArchiveSettings extends TMF_AdminPanel {

	protected $name				= 'Attorney Directory Page';
	protected $menu_title		= 'Directory Page';
	protected $parent_slug		= 'edit.php?post_type=attorney';


	public function before_save() {
		$data = $this->post_data(true);

		if( $wpseo_titles = get_option('wpseo_titles') ):

			$wpseo_titles['title-ptarchive-attorney'] = $data->title_attorney;
			$wpseo_titles['metadesc-ptarchive-attorney'] = $data->metadesc_attorney;

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
					<?php $this->label('Alternate Breadcrumb Text', 'tmf_attorney_alternate_breadcrumb_text') ?>
				</th>
				<td>
					<?php $this->text('tmf_attorney_alternate_breadcrumb_text', 'large') ?>
					<p class="description">Leave field empty for default breadcrumb setup.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Title', 'tmf_attorney_archive_title') ?>
				</th>
				<td>
					<?php $this->text('tmf_attorney_archive_title', 'large') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Top Content', 'tmf_attorney_archive_top') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->attorney_archive_top, 'tmf-attorney-directory-page-archive-top', array('textarea_name' => 'TMF[attorney_directory_page][tmf_attorney_archive_top]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

			<tr>
				<th scope="row">Hide Attorney List</th>
				<td>
					<?php $this->checkbox('tmf_attorney_archive_hide_list') ?> <?php $this->label('Hide the list of attorneys on this page', 'tmf_attorney_archive_hide_list') ?>
					<p class="description">
						If checked, the list of attorneys will be removed from the Directory page.
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Bottom Content', 'tmf_attorney_archive_bottom') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->attorney_archive_bottom, 'tmf-attorney-directory-page-archive-bottom', array('textarea_name' => 'TMF[attorney_directory_page][tmf_attorney_archive_bottom]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

		</table>

		<?php if( $wpseo_titles = get_option('wpseo_titles') ): ?>

			<h1>SEO Settings for Directory Page</h1>

			<h2>Attorney</h2>
			<em>SEO Settings for Directory Page</em>

			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Title template:', 'title-attorney') ?>
					</th>
					<td>
						<?php $this->text('title_attorney', 'large', $wpseo_titles['title-ptarchive-attorney'], TRUE) ?>
					</td>
				</tr>


				<tr>
					<th scope="row">
						<?php $this->label('Meta description template:', 'metadesc-attorney') ?>
					</th>
					<td>
						<?php $this->textarea('metadesc_attorney', 'large', $wpseo_titles['metadesc-ptarchive-attorney'], TRUE) ?>
					</td>
				</tr>
			</table>

		<?php endif; ?>
	<?php
	}

}

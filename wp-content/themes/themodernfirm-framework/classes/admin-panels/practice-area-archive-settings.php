<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_PracticeAreaArchiveSettings extends TMF_AdminPanel {

	protected $name				= 'Practice Area Directory Page';
	protected $menu_title		= 'Directory Page';
	protected $parent_slug		= 'edit.php?post_type=practice-area';

	public function before_save() {
		$data = $this->post_data(true);
		if( $wpseo_titles = get_option('wpseo_titles') ):

			$wpseo_titles['title-ptarchive-practice-area'] = $data->title_practice_area;
			$wpseo_titles['metadesc-ptarchive-practice-area'] = $data->metadesc_practice_area;

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
					<?php $this->label('Alternate Breadcrumb Text', 'tmf_practice_area_alternate_breadcrumb_text') ?>
				</th>
				<td>
					<?php $this->text('tmf_practice_area_alternate_breadcrumb_text', 'large') ?>
					<p class="description">Leave field empty for default breadcrumb setup.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Title', 'tmf_practice_area_archive_title') ?>
				</th>
				<td>
					<?php $this->text('tmf_practice_area_archive_title', 'large') ?>
				</td>
			</tr>

			<tr>
			<th scope="row">
					<?php $this->label('Page Top Content', 'tmf_practice_area_archive_top') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->practice_area_archive_top, 'tmf-practice-area-directory-page-archive-top', array('textarea_name' => 'TMF[practice_area_directory_page][tmf_practice_area_archive_top]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

			<tr>
				<th scope="row">Hide Practice Area List</th>
				<td>
					<?php $this->checkbox('tmf_practice_area_archive_hide_list') ?> <?php $this->label('Hide the list of practice areas on this page', 'tmf_practice_area_archive_hide_list') ?>
					<p class="description">
						If checked, the list of practice areas will be removed from the Directory page.
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Bottom Content', 'tmf_practice_area_archive_bottom') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->practice_area_archive_bottom, 'tmf-practice-area-directory-page-archive-bottom', array('textarea_name' => 'TMF[practice_area_directory_page][tmf_practice_area_archive_bottom]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

		</table>

		<?php if( $wpseo_titles = get_option('wpseo_titles') ): ?>

			<h1>SEO Settings for Directory Page</h1>

			<h2>Practice Area</h2>
			<em>SEO Settings for Directory Page</em>

			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Title template:', 'title-practice-area') ?>
					</th>
					<td>
						<?php $this->text('title_practice_area', 'large', $wpseo_titles['title-ptarchive-practice-area'], TRUE) ?>
					</td>
				</tr>


				<tr>
					<th scope="row">
						<?php $this->label('Meta description template:', 'metadesc-practice-area') ?>
					</th>
					<td>
						<?php $this->textarea('metadesc_practice_area', 'large', $wpseo_titles['metadesc-ptarchive-practice-area'], TRUE) ?>
					</td>
				</tr>
			</table>

		<?php endif; ?>

	<?php
	}

}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_FaqArchiveSettings extends TMF_AdminPanel {

	protected $name				= 'FAQ Directory Page';
	protected $menu_title		= 'Directory Page';
	protected $parent_slug		= 'edit.php?post_type=faq';


	public function before_save() {
		$data = $this->post_data(true);
		if( $wpseo_titles = get_option('wpseo_titles') ):

			$wpseo_titles['title-ptarchive-faq'] = $data->title_faq;
			$wpseo_titles['metadesc-ptarchive-faq'] = $data->metadesc_faq;

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
					<?php $this->label('Alternate Breadcrumb Text', 'tmf_faq_alternate_breadcrumb_text') ?>
				</th>
				<td>
					<?php $this->text('tmf_faq_alternate_breadcrumb_text', 'large') ?>
					<p class="description">Leave field empty for default breadcrumb setup.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Title', 'tmf_faq_archive_title') ?>
				</th>
				<td>
					<?php $this->text('tmf_faq_archive_title', 'large') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Top Content', 'tmf_faq_archive_top') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->faq_archive_top, 'tmf-faq-directory-page-archive-top', array('textarea_name' => 'TMF[faq_directory_page][tmf_faq_archive_top]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

			<tr>
				<th scope="row">Hide FAQ List</th>
				<td>
					<?php $this->checkbox('tmf_faq_archive_hide_list') ?> <?php $this->label('Hide the list of faqs on this page', 'tmf_faq_archive_hide_list') ?>
					<p class="description">
						If checked, the list of FAQ's will be removed from the Directory page.
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Bottom Content', 'tmf_faq_archive_bottom') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->faq_archive_bottom, 'tmf-faq-directory-page-archive-bottom', array('textarea_name' => 'TMF[faq_directory_page][tmf_faq_archive_bottom]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

		</table>

		<?php if( $wpseo_titles = get_option('wpseo_titles') ): ?>

			<h1>SEO Settings for Directory Page</h1>

			<h2>FAQ</h2>
			<em>SEO Settings for Directory Page</em>

			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Title template:', 'title-faq') ?>
					</th>
					<td>
						<?php $this->text('title_faq', 'large', $wpseo_titles['title-ptarchive-faq'], TRUE) ?>
					</td>
				</tr>


				<tr>
					<th scope="row">
						<?php $this->label('Meta description template:', 'metadesc-faq') ?>
					</th>
					<td>
						<?php $this->textarea('metadesc_faq', 'large', $wpseo_titles['metadesc-ptarchive-faq'], TRUE) ?>
					</td>
				</tr>
			</table>

		<?php endif; ?>

	<?php
	}

}

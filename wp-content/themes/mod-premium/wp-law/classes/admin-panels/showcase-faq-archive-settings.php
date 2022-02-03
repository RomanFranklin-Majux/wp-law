<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2017 The Modern Firm, LLC
 */
class TMF_AdminPanel_ShowcaseFaqArchiveSettings extends TMF_AdminPanel {

	protected $name				= 'Showcase Faq Directory Page';
	protected $menu_title		= 'Directory Page';
	protected $parent_slug		= 'edit.php?post_type=showcase-faq';


	public function before_save() {
		$data = $this->post_data(true);
		if( $wpseo_titles = get_option('wpseo_titles') ):

			$wpseo_titles['title-sfarchive-showcase-faq'] = $data->title_showcase_faq;
			$wpseo_titles['metadesc-sfarchive-showcase-faq'] = $data->metadesc_showcase_faq;

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
					<?php $this->label('Alternate Breadcrumb Text', 'tmf_showcase_faq_alternate_breadcrumb_text') ?>
				</th>
				<td>
					<?php $this->text('tmf_showcase_faq_alternate_breadcrumb_text', 'large') ?>
					<p class="description">Leave field empty for default breadcrumb setup.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Title', 'tmf_showcase_faq_archive_title') ?>
				</th>
				<td>
					<?php $this->text('tmf_showcase_faq_archive_title', 'large') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Top Content', 'tmf_showcase_faq_archive_top') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->showcase_faq_archive_top, 'tmf-showcase-faq-directory-page-archive-top', array('textarea_name' => 'TMF[showcase_faq_directory_page][tmf_showcase_faq_archive_top]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

			<tr>
				<th scope="row">Hide Showcase Faq List</th>
				<td>
					<?php $this->checkbox('tmf_showcase_faq_archive_hide_list') ?> <?php $this->label('Hide the list of showcase faqs on this page', 'tmf_showcase_faq_archive_hide_list') ?>
					<p class="description">
						If checked, the list of Showcase Faqs will be removed from the Directory page.
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Bottom Content', 'tmf_showcase_faq_archive_bottom') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->showcase_faq_archive_bottom, 'tmf-showcase-faq-directory-page-archive-bottom', array('textarea_name' => 'TMF[showcase_faq_directory_page][tmf_showcase_faq_archive_bottom]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

		</table>

		<?php if( $wpseo_titles = get_option('wpseo_titles') ): ?>

			<h1>SEO Settings for Directory Page</h1>

			<h2>Showcase Faq</h2>
			<em>SEO Settings for Directory Page</em>

			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Title template:', 'title-showcase-faq') ?>
					</th>
					<td>
						<?php $this->text('title_showcase_faq', 'large', $wpseo_titles['title-sfarchive-showcase-faq'], TRUE) ?>
					</td>
				</tr>


				<tr>
					<th scope="row">
						<?php $this->label('Meta description template:', 'metadesc-showcase-faq') ?>
					</th>
					<td>
						<?php $this->textarea('metadesc_showcase_faq', 'large', $wpseo_titles['metadesc-sfarchive-showcase-faq'], TRUE) ?>
					</td>
				</tr>
			</table>

		<?php endif; ?>

	<?php
	}

}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_NewsArchiveSettings extends TMF_AdminPanel {

	protected $name				= 'News Directory Page';
	protected $menu_title		= 'Directory Page';
	protected $parent_slug		= 'edit.php?post_type=news';

	public function before_save() {
		$data = $this->post_data(true);
		if( $wpseo_titles = get_option('wpseo_titles') ):

			$wpseo_titles['title-ptarchive-news'] = $data->title_news;
			$wpseo_titles['metadesc-ptarchive-news'] = $data->metadesc_news;

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
					<?php $this->label('Alternate Breadcrumb Text', 'tmf_news_alternate_breadcrumb_text') ?>
				</th>
				<td>
					<?php $this->text('tmf_news_alternate_breadcrumb_text', 'large') ?>
					<p class="description">Leave field empty for default breadcrumb setup.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Title', 'tmf_news_archive_title') ?>
				</th>
				<td>
					<?php $this->text('tmf_news_archive_title', 'large') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Top Content', 'tmf_news_archive_top') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->news_archive_top, 'tmf-news-directory-page-archive-top', array('textarea_name' => 'TMF[news_directory_page][tmf_news_archive_top]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Bottom Content', 'tmf_news_archive_bottom') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->news_archive_bottom, 'tmf-news-directory-page-archive-bottom', array('textarea_name' => 'TMF[news_directory_page][tmf_news_archive_bottom]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

		</table>

		<?php if( $wpseo_titles = get_option('wpseo_titles') ): ?>

			<h1>SEO Settings for Directory Page</h1>

			<h2>News</h2>
			<em>SEO Settings for Directory Page</em>

			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Title template:', 'title-news') ?>
					</th>
					<td>
						<?php $this->text('title_news', 'large', $wpseo_titles['title-ptarchive-news'], TRUE) ?>
					</td>
				</tr>


				<tr>
					<th scope="row">
						<?php $this->label('Meta description template:', 'metadesc-news') ?>
					</th>
					<td>
						<?php $this->textarea('metadesc_news', 'large', $wpseo_titles['metadesc-ptarchive-news'], TRUE) ?>
					</td>
				</tr>
			</table>

		<?php endif; ?>

	<?php
	}

}

<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_EventArchiveSettings extends TMF_AdminPanel {

	protected $name				= 'Event Directory Page';
	protected $menu_title		= 'Directory Page';
	protected $parent_slug		= 'edit.php?post_type=event';


	public function before_save() {
		$data = $this->post_data(true);
		if( $wpseo_titles = get_option('wpseo_titles') ):

			$wpseo_titles['title-ptarchive-event'] = $data->title_event;
			$wpseo_titles['metadesc-ptarchive-event'] = $data->metadesc_event;

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
					<?php $this->label('Alternate Breadcrumb Text', 'tmf_event_alternate_breadcrumb_text') ?>
				</th>
				<td>
					<?php $this->text('tmf_event_alternate_breadcrumb_text', 'large') ?>
					<p class="description">Leave field empty for default breadcrumb setup.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Title', 'tmf_event_archive_title') ?>
				</th>
				<td>
					<?php $this->text('tmf_event_archive_title', 'large') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Top Content', 'tmf_event_archive_top') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->event_archive_top, 'tmf-event-directory-page-archive-top', array('textarea_name' => 'TMF[event_directory_page][tmf_event_archive_top]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Bottom Content', 'tmf_event_archive_bottom') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->event_archive_bottom, 'tmf-event-directory-page-archive-bottom', array('textarea_name' => 'TMF[event_directory_page][tmf_event_archive_bottom]', 'textarea_rows' => 20)); ?>
				</td>
			</tr>

		</table>

		<?php if( $wpseo_titles = get_option('wpseo_titles') ): ?>
			<h1>SEO Settings for Directory Page</h1>

			<h2>Event</h2>
			<em>SEO Settings for Directory Page</em>

			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Title template:', 'title-event') ?>
					</th>
					<td>
						<?php $this->text('title_event', 'large', $wpseo_titles['title-ptarchive-event'], TRUE) ?>
					</td>
				</tr>


				<tr>
					<th scope="row">
						<?php $this->label('Meta description template:', 'metadesc-event') ?>
					</th>
					<td>
						<?php $this->textarea('metadesc_event', 'large', $wpseo_titles['metadesc-ptarchive-event'], TRUE) ?>
					</td>
				</tr>
			</table>
		<?php endif; ?>

	<?php
	}

}

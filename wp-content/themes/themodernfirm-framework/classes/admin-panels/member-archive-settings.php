<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_MemberArchiveSettings extends TMF_AdminPanel {

	protected $name				= 'Member Directory Page';
	protected $menu_title		= 'Directory Page';
	protected $parent_slug		= 'edit.php?post_type=member';

	public function before_save() {
		$data = $this->post_data(true);
		if( $wpseo_titles = get_option('wpseo_titles') ):

			$wpseo_titles['title-ptarchive-member'] = $data->title_member;
			$wpseo_titles['metadesc-ptarchive-member'] = $data->metadesc_member;

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
					<?php $this->label('Alternate Breadcrumb Text', 'tmf_member_alternate_breadcrumb_text') ?>
				</th>
				<td>
					<?php $this->text('tmf_member_alternate_breadcrumb_text', 'large') ?>
					<p class="description">Leave field empty for default breadcrumb setup.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Title', 'tmf_member_archive_title') ?>
				</th>
				<td>
					<?php $this->text('tmf_member_archive_title', 'large') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Top Content', 'tmf_member_archive_top') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->member_archive_top, 'tmf-member-directory-page-archive-top', array('textarea_name' => 'TMF[member_directory_page][tmf_member_archive_top]', 'textarea_rows' => 20)); ?>            
				</td>
			</tr>

			<tr>
				<th scope="row">Remove Directory</th>
				<td>
					<?php $this->checkbox('tmf_member_archive_hide_list') ?> <?php $this->label('Completely remove the member directory on this page.', 'tmf_member_archive_hide_list') ?>
					<p class="description">
						If checked, the list of members will be removed from the directory page along with the member search functions.
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">Hide Listing</th>
				<td>
					<?php $this->checkbox('tmf_member_archive_hide_members') ?> <?php $this->label('Hide the member listing by default.', 'tmf_member_archive_hide_members') ?>
					<p class="description">
						If checked, the list of members we be hidden until a user uses the search or filtering options.
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Page Bottom Content', 'tmf_member_archive_bottom') ?>
				</th>
				<td>
					<?php wp_editor($tmf_option->member_archive_bottom, 'tmf-member-directory-page-archive-bottom', array('textarea_name' => 'TMF[member_directory_page][tmf_member_archive_bottom]', 'textarea_rows' => 20)); ?>            
				</td>
			</tr>

		</table>

		<?php if( $wpseo_titles = get_option('wpseo_titles') ): ?>

			<h1>SEO Settings for Directory Page</h1>

			<h2>Member</h2>
			<em>SEO Settings for Directory Page</em>

			<table class="form-table">
				<tr>
					<th scope="row">
						<?php $this->label('Title template:', 'title-member') ?>
					</th>
					<td>
						<?php $this->text('title_member', 'large', $wpseo_titles['title-ptarchive-member'], TRUE) ?>
					</td>
				</tr>


				<tr>
					<th scope="row">
						<?php $this->label('Meta description template:', 'metadesc-member') ?>
					</th>
					<td>
						<?php $this->textarea('metadesc_member', 'large', $wpseo_titles['metadesc-ptarchive-member'], TRUE) ?>
					</td>
				</tr>
			</table>

		<?php endif; ?>

	<?php
	}

}

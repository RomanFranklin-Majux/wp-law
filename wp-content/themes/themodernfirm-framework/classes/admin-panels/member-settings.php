<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_MemberSettings extends TMF_AdminPanel {

	protected $name				= 'Member Preferences';
	protected $menu_title		= 'Preferences';
	protected $parent_slug		= 'edit.php?post_type=member';


	public function before_save () {
		global $current_user;
		$data = $this->post_data(TRUE);

		unset($data->tmf_member_restricted_pages[0]);

		TMF_Option::factory()->set('tmf_member_restricted_pages', $data->tmf_member_restricted_pages);

		// when all checkboxes are un-checked the field doesn't get's submitted
		// this solves the issue so that all checkboxes can be unchecked
		// otherwise the last checkbox always remains checked
		if(is_user_logged_in() && in_array($current_user->user_login, WHITE_LABELED_USERNAMES)) {
			if(empty( $this->post_data()->tmf_member_order_terms )) {
				update_option('tmf_member_order_terms', '');
			}
		}

	}


	public function get_all_pages () {
		global $tmf;
		$pages = array();

		foreach($tmf->posts(array('post_type' => 'page', 'limit' => -1))->to_array() as $page):
			$pages[$page->ID] = $page->ID . ' - ' . $page->post_title;
		endforeach;

		return $pages;
	}


	public function render () {
		global $tmf_option, $current_user;
	?>
		<?php if(is_user_logged_in() && in_array($current_user->user_login, WHITE_LABELED_USERNAMES)): ?>
			<br/>
			<table class="form-table">
				<tr>
					<th scope="row">

					</th>
					<td>
						<p class="description">
							<em><strong>Advanced Users only: </strong>Reordering options are for advanced admin users only.</em>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<?php $this->label('Order By', 'tmf_member_order_by') ?>
					</th>
					<td>
						<?php $member_order_by_value = $tmf_option->member_order_by ? $tmf_option->member_order_by : 'menu_order'; ?>
						<?php $member_order_by_data = array(
							'menu_order' => 'Menu Order',
							'ID' => 'Post ID',
							'date' => 'Post Date',
							'title' => 'Post Title',
							'author' => 'Post Author',
							'modified' => 'Last Modified At',
							'name' => 'Post Name (the post slug)'); ?>
						<?php $this->radio('tmf_member_order_by', $member_order_by_data, $member_order_by_value) ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<?php $this->label('Order Direction', 'tmf_member_order_direction') ?>
					</th>
					<td>
						<?php $member_order_direction_value = $tmf_option->member_order_direction ? $tmf_option->member_order_direction : 'asc'; ?>
						<?php $member_order_direction_data = array(
							'asc' => 'Ascending ( 1, 2, 3, 4)',
							'desc' => 'Descending ( 4, 3, 2, 1)'); ?>
						<?php $this->radio('tmf_member_order_direction', $member_order_direction_data, $member_order_direction_value) ?>
					</td>
				</tr>
				
				<tr id="tmf-apply-field-to">
					<th scope="row">
						<?php $this->label('Apply To', 'tmf_member_order_apply') ?>
					</th>
					<td>
						<?php $member_order_apply_value = $tmf_option->member_order_apply ? $tmf_option->member_order_apply : 'all'; ?>
						<?php $member_order_apply_data = array(
							'all' => 'Apply to all categories',
							'selected' => 'Apply to selected categories'); ?>
						<?php $this->radio('tmf_member_order_apply', $member_order_apply_data, $member_order_apply_value) ?>
					</td>
				</tr>
				
				<tr id="tmf-selected-terms"<?php echo ( $tmf_option->member_order_apply != 'selected' ? 'style="display: none"' : '') ?>>
					<th scope="row">
						<?php $this->label('Selected Categories', 'tmf_member_order_terms') ?>
					</th>
					<td>
						<?php $terms = get_terms(array('taxonomy' => 'professional-areas', 'hide_empty' => false)); ?>
						<?php foreach($terms as $key => $term): ?>
							<div class="tmf-checkbox-container">
								<input
									type="checkbox"
									id="tmf-member-preferences-tmf-member-order-terms-<?php echo $term->term_id ?>"
									name="<?php echo FRAMEWORK_PREFIX ?>[member_preferences][tmf_member_order_terms][]"
									value="<?php echo $term->term_id ?>"
									<?php echo ( is_array(get_option('tmf_member_order_terms')) && in_array($term->term_id, get_option('tmf_member_order_terms')) ? 'checked=checked' : '') ?>
								/>
								<label for="tmf-member-preferences-tmf-member-order-terms-<?php echo $term->term_id ?>"><?php echo $term->name ?></label>
							</div>
						<?php endforeach ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row">

					</th>
					<td>
						<p class="description">
							<b>Please note: </b>Clicking this option will enable options to apply to categories within this post type. If there are categories,<br /> they will appear once selected.
						</p>
					</td>
				</tr>
			</table>
		<?php endif; ?>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Image Sizes</h3>
		<table class="form-table">
			<tr>
				<th scope="row">Primary Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_member_image_size_primary_width') ?><?php $this->number('tmf_member_image_size_primary_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_member_image_size_primary_height') ?><?php $this->number('tmf_member_image_size_primary_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_member_image_size_primary_crop') ?> <?php $this->label('Force crop', 'tmf_member_image_size_primary_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">Thumbnail Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_member_image_size_thumbnail_width') ?><?php $this->number('tmf_member_image_size_thumbnail_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_member_image_size_thumbnail_height') ?><?php $this->number('tmf_member_image_size_thumbnail_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_member_image_size_thumbnail_crop') ?> <?php $this->label('Force crop', 'tmf_member_image_size_thumbnail_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">

				</th>
				<td>
					<p class="description">
						These settings will only apply to new images.<br/><br/>
						<b>Force Crop Instructions</b><br/>
						If checked, the image will be cropped to the exact width and height provided. <br/>
						If unchecked, the width and height become maximum allowed dimensions.
					</p>
				</td>
			</tr>
		</table>


		<br/>
		<h3 class="title" style="margin-bottom: 0;">Excerpt Settings</h3>
		<p class="description">
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Excerpt Length', 'tmf_member_excerpt_length') ?>
				</th>
				<td>
					<?php $this->number('tmf_member_excerpt_length', 'tiny') ?>
					<div class="description">
						The number of characters excerpts should not exceed.<br/>
						Auto-Generated excerpts will always be truncated at this length.
					</div>
				</td>
			</tr>

			<tr>
				<th scope="row">
					Enforce Excerpt Length
				</th>
				<td>
					<?php $this->checkbox('tmf_member_excerpt_force_trim') ?> <?php $this->label('Enforce excerpt length', 'tmf_member_excerpt_force_trim') ?>
					<div class="description">
						If the excerpt length exceeds 'Excerpt Length' value, <br/>
						then the excerpt will be truncated when displayed.
					</div>
				</td>
			</tr>
		</table>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">Export Member CSV</h3>
		<br />
		<a href="/wp-admin/edit.php?download_member_csv=true" target="_blank">Click here to download a CSV of active members</a>
		<br />
		<br />
		<br />
		<h3 class="title" style="margin-bottom: 0;">Notification Email Settings</h3>
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Member Edit Email', 'tmf_association_member_edit_notification_email') ?>
				</th>
				<td>
					<?php $this->text('tmf_association_member_edit_notification_email', 'medium') ?>
				</td>
			</tr>

		</table>
		<br />

		<?php $pages = $this->get_all_pages() ?>
		<h3 class="title" style="margin-bottom: 0;">Page Settings</h3>
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Member Signup Page', 'tmf_association_member_signup_page') ?>
				</th>
				<td>
					<?php $this->combobox('tmf_association_member_signup_page', $pages, '-- Select a Page --') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Member Login Page', 'tmf_association_member_login_page') ?>
				</th>
				<td>
					<?php $this->combobox('tmf_association_member_login_page', $pages, '-- Select a Page --') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Member Account Page', 'tmf_association_member_account_page') ?>
				</th>
				<td>
					<?php $this->combobox('tmf_association_member_account_page', $pages, '-- Select a Page --') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Member Edit Page', 'tmf_association_member_edit_page') ?>
				</th>
				<td>
					<?php $this->combobox('tmf_association_member_edit_page', $pages, '-- Select a Page --') ?>
				</td>
			</tr>
		</table>
		<br />

		<h3 class="title" style="margin-bottom: 0;">Member Restricted Pages</h3>
		<table class="form-table indent">
			<tr>
				<td>
					<input type="hidden" name="TMF_x[member_preferences][tmf_member_restricted_pages][]" value=""/>

					<select class="combobox-tags">
						<option value="">-- Select Page --</option>
						<?php
							foreach($pages as $id => $page):
								echo '<option value="'. $id .'">'. $page .'</option>';
							endforeach;
						?>
					</select>
					<div class="tags-container tags-box" data-object-name="TMF_x[member_preferences][tmf_member_restricted_pages]">
						<?php
							$count = 1;
							$restricted_pages = $tmf_option->member_restricted_pages;

							if (isset($restricted_pages) && is_array($restricted_pages)):
								foreach ($restricted_pages as $restricted_area): ?>
									<div class="attorney tag" data-object-id="<?php echo $restricted_area ?>">
										<input type="hidden" name="TMF_x[member_preferences][tmf_member_restricted_pages][<?php echo $count ?>]" value="<?php echo $restricted_area ?>"/>
										<span class="name"><?php echo $restricted_area ?> – <?php echo get_the_title($restricted_area) ?></span>
										<span class="delete">X</span>
									</div>
						<?php $count++; endforeach; endif; ?>
					</div>
				</td>
			</tr>
		</table>

	<?php
	}

}

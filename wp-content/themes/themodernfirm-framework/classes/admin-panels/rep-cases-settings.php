<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_RepCasesSettings extends TMF_AdminPanel {

	protected $name				= 'Representative Cases Preferences';
	protected $menu_title		= 'Preferences';
	protected $parent_slug		= 'edit.php?post_type=representative-case';


	public function get_representative_cases () {
		$posts = get_posts('post_type=representative-case&numberposts=-1&orderby=menu_order&order=ASC');
		return $posts;
	}

	public function before_save () {
		global $wpdb, $current_user;
		$extra = $this->post_data(TRUE);

		foreach ($extra->representative_cases as $key => $post):
			$wpdb->query("UPDATE $wpdb->posts SET menu_order = $key WHERE ID = $post LIMIT 1");
		endforeach;
		
		// when all checkboxes are un-checked the field doesn't get's submitted
		// this solves the issue so that all checkboxes can be unchecked
		// otherwise the last checkbox always remains checked
		if(is_user_logged_in() && in_array($current_user->user_login, WHITE_LABELED_USERNAMES)) {
			if(empty( $this->post_data()->tmf_representative_case_order_terms )) {
				update_option('tmf_representative_case_order_terms', '');
			}
		}
	}

	public function render () {
		global $tmf_option, $current_user;
	?>
		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Sort Order</h3>
		<p class="description">
			This is the order in which representative cases will be shown when displayed in a list.
		</p>
		<table class="form-table indent">
			<tr>
				<td>
					<div class="tags-container tags-box" data-object-name="TMF_x[representative_cases_preferences][representative_cases]">
						<?php
							$count = 1;
							foreach ($this->get_representative_cases() as $representative_case): ?>
							<div class="representative-case tag">
								<input type="hidden" name="TMF_x[representative_cases_preferences][representative_cases][<?php echo $count ?>]" value="<?php echo $representative_case->ID ?>"/>
								<span class="name"><a href="/wp-admin/post.php?post=<?php echo $representative_case->ID ?>&action=edit" target="_blank"><?php echo $representative_case->post_title ?></a></span>
							</div>
						<?php $count++; endforeach ?>
					</div>
				</td>
			</tr>
		</table>

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
						<?php $this->label('Order By', 'tmf_representative_case_order_by') ?>
					</th>
					<td>
						<?php $representative_case_order_by_value = $tmf_option->representative_case_order_by ? $tmf_option->representative_case_order_by : 'menu_order'; ?>
						<?php $representative_case_order_by_data = array(
							'menu_order' => 'Menu Order',
							'ID' => 'Post ID',
							'date' => 'Post Date',
							'title' => 'Post Title',
							'author' => 'Post Author',
							'modified' => 'Last Modified At',
							'name' => 'Post Name (the post slug)'); ?>
						<?php $this->radio('tmf_representative_case_order_by', $representative_case_order_by_data, $representative_case_order_by_value) ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<?php $this->label('Order Direction', 'tmf_representative_case_order_direction') ?>
					</th>
					<td>
						<?php $representative_case_order_direction_value = $tmf_option->representative_case_order_direction ? $tmf_option->representative_case_order_direction : 'asc'; ?>
						<?php $representative_case_order_direction_data = array(
							'asc' => 'Ascending ( 1, 2, 3, 4)',
							'desc' => 'Descending ( 4, 3, 2, 1)'); ?>
						<?php $this->radio('tmf_representative_case_order_direction', $representative_case_order_direction_data, $representative_case_order_direction_value) ?>
					</td>
				</tr>
				
				<tr id="tmf-apply-field-to">
					<th scope="row">
						<?php $this->label('Apply To', 'tmf_representative_case_order_apply') ?>
					</th>
					<td>
						<?php $representative_case_order_apply_value = $tmf_option->representative_case_order_apply ? $tmf_option->representative_case_order_apply : 'all'; ?>
						<?php $representative_case_order_apply_data = array(
							'all' => 'Apply to all categories',
							'selected' => 'Apply to selected categories'); ?>
						<?php $this->radio('tmf_representative_case_order_apply', $representative_case_order_apply_data, $representative_case_order_apply_value) ?>
					</td>
				</tr>
				
				<tr id="tmf-selected-terms"<?php echo ( $tmf_option->representative_case_order_apply != 'selected' ? 'style="display: none"' : '') ?>>
					<th scope="row">
						<?php $this->label('Selected Categories', 'tmf_representative_case_order_terms') ?>
					</th>
					<td>
						<?php $terms = get_terms(array('taxonomy' => 'representative-case-categories', 'hide_empty' => false)); ?>
						<?php foreach($terms as $key => $term): ?>
							<div class="tmf-checkbox-container">
								<input
									type="checkbox"
									id="tmf-representative-cases-preferences-tmf-representative-cases-order-terms-<?php echo $term->term_id ?>"
									name="<?php echo FRAMEWORK_PREFIX ?>[representative_cases_preferences][tmf_representative_case_order_terms][]"
									value="<?php echo $term->term_id ?>"
									<?php echo ( is_array(get_option('tmf_representative_case_order_terms')) && in_array($term->term_id, get_option('tmf_representative_case_order_terms')) ? 'checked=checked' : '') ?>
								/>
								<label for="tmf-representative-cases-preferences-tmf-representative-cases-order-terms-<?php echo $term->term_id ?>"><?php echo $term->name ?></label>
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
					<?php $this->label('Width: ', 'tmf_representative_case_image_size_primary_width') ?><?php $this->number('tmf_representative_case_image_size_primary_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_representative_case_image_size_primary_height') ?><?php $this->number('tmf_representative_case_image_size_primary_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_representative_case_image_size_primary_crop') ?> <?php $this->label('Force crop', 'tmf_representative_case_image_size_primary_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">Thumbnail Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_representative_case_image_size_thumbnail_width') ?><?php $this->number('tmf_representative_case_image_size_thumbnail_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_representative_case_image_size_thumbnail_height') ?><?php $this->number('tmf_representative_case_image_size_thumbnail_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_representative_case_image_size_thumbnail_crop') ?> <?php $this->label('Force crop', 'tmf_representative_case_image_size_thumbnail_crop') ?>
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

		<h3 class="title" style="margin-bottom: 0;">Directory Settings</h3>
		<table class="form-table">
			<tr>
				<th scope="row">Representative Case Redirect</th>
				<td>
					<?php $this->checkbox('tmf_representative_case_archive_link') ?> <?php $this->label('Redirect representative case links to the Directory Page', 'tmf_representative_case_archive_link') ?>
					<p class="description">
						If checked, all representative case links will be redirected to the<br/>
						<a href="<?php echo get_post_type_archive_link('representative-case') ?>" target="_blank">Directory Page</a> instead of individual representative case pages.
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
					<?php $this->label('Excerpt Length', 'tmf_representative_case_excerpt_length') ?>
				</th>
				<td>
					<?php $this->number('tmf_representative_case_excerpt_length', 'tiny') ?>
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
					<?php $this->checkbox('tmf_representative_case_excerpt_force_trim') ?> <?php $this->label('Enforce excerpt length', 'tmf_representative_case_excerpt_force_trim') ?>
					<div class="description">
						If the excerpt length exceeds 'Excerpt Length' value, <br/>
						then the excerpt will be truncated when displayed.
					</div>
				</td>
			</tr>
		</table>

	<?php
	}

}

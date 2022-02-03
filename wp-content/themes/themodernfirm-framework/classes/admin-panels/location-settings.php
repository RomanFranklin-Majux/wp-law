<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_LocationSettings extends TMF_AdminPanel {

	protected $name				= 'Location Preferences';
	protected $menu_title		= 'Preferences';
	protected $parent_slug		= 'edit.php?post_type=location';


	public function get_locations () {
		$posts = get_posts('post_type=location&numberposts=-1&orderby=menu_order&order=ASC');
		return $posts;
	}

	public function before_save () {
		global $wpdb, $current_user;
		$extra = $this->post_data(TRUE);

		foreach ($extra->locations as $key => $post):
			$wpdb->query("UPDATE $wpdb->posts SET menu_order = $key WHERE ID = $post LIMIT 1");
		endforeach;

		// when all checkboxes are un-checked the field doesn't get's submitted
		// this solves the issue so that all checkboxes can be unchecked
		// otherwise the last checkbox always remains checked
		if(is_user_logged_in() && in_array($current_user->user_login, WHITE_LABELED_USERNAMES)) {
			if(empty( $this->post_data()->tmf_location_order_terms )) {
				update_option('tmf_location_order_terms', '');
			}
		}

		$data = $this->post_data();

		// Force image update when saving the settings
		if(isset($data->tmf_static_map_storage) && $data->tmf_static_map_storage) {
			// If static image storing is set
			if(isset($data->tmf_static_map_zoom) && isset($data->tmf_static_map_height) && isset($data->tmf_static_map_width)) {

				// First update the options
				update_option('tmf_static_map_storage', $data->tmf_static_map_storage);
				update_option('tmf_static_map_zoom', $data->tmf_static_map_zoom);
				update_option('tmf_static_map_height', $data->tmf_static_map_height);
				update_option('tmf_static_map_width', $data->tmf_static_map_width);

				$get_posts = get_posts(array('post_type' => 'location'));

				// Loop through all of the location posts
				foreach ($get_posts as $key => $p) {
					// Force post update so we can re-generate the images
					do_action('save_post', $p->ID, $p, true);
				}

			}
		}
	}

	public function render () {
		global $tmf_option, $current_user;
	?>
		<br/>
		<h3 class="title" style="margin-bottom: 0;">Default Sort Order</h3>
		<p class="description">
			This is the order in which locations will be shown when displayed in a list.
		</p>
		<table class="form-table indent">
			<tr>
				<td>
					<div class="tags-container tags-box" data-object-name="TMF_x[location_preferences][locations]">
						<?php
							$count = 1;
							foreach ($this->get_locations() as $location): ?>
							<div class="location tag">
								<input type="hidden" name="TMF_x[location_preferences][locations][<?php echo $count ?>]" value="<?php echo $location->ID ?>"/>
								<span class="name"><a href="/wp-admin/post.php?post=<?php echo $location->ID ?>&action=edit" target="_blank"><?php echo $location->post_title ?></a></span>
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
						<?php $this->label('Order By', 'tmf_location_order_by') ?>
					</th>
					<td>
						<?php $location_order_by_value = $tmf_option->location_order_by ? $tmf_option->location_order_by : 'menu_order'; ?>
						<?php $location_order_by_data = array(
							'menu_order' => 'Menu Order',
							'ID' => 'Post ID',
							'date' => 'Post Date',
							'title' => 'Post Title',
							'author' => 'Post Author',
							'modified' => 'Last Modified At',
							'name' => 'Post Name (the post slug)'); ?>
						<?php $this->radio('tmf_location_order_by', $location_order_by_data, $location_order_by_value) ?>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<?php $this->label('Order Direction', 'tmf_location_order_direction') ?>
					</th>
					<td>
						<?php $location_order_direction_value = $tmf_option->location_order_direction ? $tmf_option->location_order_direction : 'asc'; ?>
						<?php $location_order_direction_data = array(
							'asc' => 'Ascending ( 1, 2, 3, 4)',
							'desc' => 'Descending ( 4, 3, 2, 1)'); ?>
						<?php $this->radio('tmf_location_order_direction', $location_order_direction_data, $location_order_direction_value) ?>
					</td>
				</tr>
				
				<tr id="tmf-apply-field-to">
					<th scope="row">
						<?php $this->label('Apply To', 'tmf_location_order_apply') ?>
					</th>
					<td>
						<?php $location_order_apply_value = $tmf_option->location_order_apply ? $tmf_option->location_order_apply : 'all'; ?>
						<?php $location_order_apply_data = array(
							'all' => 'Apply to all categories',
							'selected' => 'Apply to selected categories'); ?>
						<?php $this->radio('tmf_location_order_apply', $location_order_apply_data, $location_order_apply_value) ?>
					</td>
				</tr>
				
				<tr id="tmf-selected-terms"<?php echo ( $tmf_option->location_order_apply != 'selected' ? 'style="display: none"' : '') ?>>
					<th scope="row">
						<?php $this->label('Selected Categories', 'tmf_location_order_terms') ?>
					</th>
					<td>
						<?php $terms = get_terms(array('taxonomy' => 'location-categories', 'hide_empty' => false)); ?>
						<?php foreach($terms as $key => $term): ?>
							<div class="tmf-checkbox-container">
								<input
									type="checkbox"
									id="tmf-location-preferences-tmf-location-order-terms-<?php echo $term->term_id ?>"
									name="<?php echo FRAMEWORK_PREFIX ?>[location_preferences][tmf_location_order_terms][]"
									value="<?php echo $term->term_id ?>"
									<?php echo ( is_array(get_option('tmf_location_order_terms')) && in_array($term->term_id, get_option('tmf_location_order_terms')) ? 'checked=checked' : '') ?>
								/>
								<label for="tmf-location-preferences-tmf-location-order-terms-<?php echo $term->term_id ?>"><?php echo $term->name ?></label>
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
					<?php $this->label('Width: ', 'tmf_location_image_size_primary_width') ?><?php $this->number('tmf_location_image_size_primary_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_location_image_size_primary_height') ?><?php $this->number('tmf_location_image_size_primary_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_location_image_size_primary_crop') ?> <?php $this->label('Force crop', 'tmf_location_image_size_primary_crop') ?>
				</td>
			</tr>
			<tr>
				<th scope="row">Thumbnail Image</th>
				<td>
					<?php $this->label('Width: ', 'tmf_location_image_size_thumbnail_width') ?><?php $this->number('tmf_location_image_size_thumbnail_width' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->label('Height: ', 'tmf_location_image_size_thumbnail_height') ?><?php $this->number('tmf_location_image_size_thumbnail_height' , 'tiny') ?> px
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_location_image_size_thumbnail_crop') ?> <?php $this->label('Force crop', 'tmf_location_image_size_thumbnail_crop') ?>
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
				<th scope="row">Location Redirect</th>
				<td>
					<?php $this->checkbox('tmf_location_archive_link') ?> <?php $this->label('Redirect location links to the Directory Page', 'tmf_location_archive_link') ?>
					<p class="description">
						If checked, all location links will be redirected to the<br/>
						<a href="<?php echo get_post_type_archive_link('location') ?>" target="_blank">Directory Page</a> instead of individual location pages.
					</p>
				</td>
			</tr>
		</table>

		<br/>
		<h3 class="title" style="margin-bottom: 0;">Label Settings</h3>
		<p class="description">
			These labels will appear next to the corresponding data on the site.<br/>
			Some themes may use icons in place of these labels.
		</p>
		<table class="form-table">
			<tr>
				<th scope="row">
					<?php $this->label('Phone 1', 'tmf_location_label_phone_1') ?>
				</th>
				<td>
					<?php $this->text('tmf_location_label_phone_1', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Phone 2', 'tmf_location_label_phone_2') ?>
				</th>
				<td>
					<?php $this->text('tmf_location_label_phone_2', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Fax', 'tmf_location_label_fax') ?>
				</th>
				<td>
					<?php $this->text('tmf_location_label_fax', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Email', 'tmf_location_label_email') ?>
				</th>
				<td>
					<?php $this->text('tmf_location_label_email', 'small') ?>
				</td>
			</tr>

		</table>

		<h3 class="title" style="margin-bottom: 0;">Static Map Settings</h3>
		<table class="form-table">
			<tr>
				<th scope="row">Enable Static Map Saving</th>
				<td>
					<?php $this->checkbox('tmf_static_map_storage') ?>
					<p class="description">
						If checked, all of the static maps will be saved.<br/>
						Instead of directly loading from static Maps API
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Map Zoom', 'tmf_static_map_zoom') ?>
				</th>
				<td>
					<?php $this->text('tmf_static_map_zoom', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Map Height', 'tmf_static_map_height') ?>
				</th>
				<td>
					<?php $this->text('tmf_static_map_height', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Map Width', 'tmf_static_map_width') ?>
				</th>
				<td>
					<?php $this->text('tmf_static_map_width', 'small') ?>
				</td>
			</tr>
		</table>

	<?php
	}

}

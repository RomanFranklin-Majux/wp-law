<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates a general settings menu in the admin backend
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_GeneralSettings extends TMF_AdminPanel {

	protected $name				= 'General Settings';
	protected $menu_title		= 'Settings';
	protected $submenu_title	= 'General';
	protected $position			= 81;
	protected $icon_url         = 'dashicons-admin-generic';

	public function add () {
		parent::add();

		add_submenu_page($this->menu_slug, 'Menus', 'Menus', 'administrator','nav-menus.php');
		add_submenu_page($this->menu_slug, 'Users', 'Users', 'administrator','users.php');

		if (!TMF_Admin::$remove_discussion_ui):
			add_submenu_page($this->menu_slug, 'Discussion', 'Discussion', 'administrator','options-discussion.php');
		endif;
	}

	public function before_save () {
		global $tmf_option;

		$old_bookmark_image = isset($tmf_option->mobile_bookmark) ? $tmf_option->mobile_bookmark : NULL;
		$new_bookmark_image = isset($this->post_data()->tmf_mobile_bookmark) ? $this->post_data()->tmf_mobile_bookmark : NULL;

		// If a new bookmark image was uploaded, resize and save multiple sizes
		if (!empty($new_bookmark_image) && $old_bookmark_image != $new_bookmark_image):
			$this->create_bookmark_images($new_bookmark_image);
		endif;
	}

	public function create_bookmark_images ($image_id) {
		$image = wp_get_image_editor(_load_image_to_edit_path($image_id));

		if (!is_wp_error($image)):
			$image->set_quality(80);

			// Retina iPad iOS7
			$image->resize(152, 152, TRUE);
			$image->save(UPLOADS_PATH . BOOKMARK_ICONS_PATH . $image_id . '-152.png', 'image/png');

			// Retina iPad pre iOS7
			$image->resize(144, 144, TRUE);
			$image->save(UPLOADS_PATH . BOOKMARK_ICONS_PATH . $image_id . '-144.png', 'image/png');

			// Retina iPhone iOS 7
			$image->resize(120, 120, TRUE);
			$image->save(UPLOADS_PATH . BOOKMARK_ICONS_PATH . $image_id . '-120.png', 'image/png');

			// Retina iPhone pre iOS 7
			$image->resize(114, 114, TRUE);
			$image->save(UPLOADS_PATH . BOOKMARK_ICONS_PATH . $image_id . '-114.png', 'image/png');

			// Non-Retina iPad iOS 7
			$image->resize(76, 76, TRUE);
			$image->save(UPLOADS_PATH . BOOKMARK_ICONS_PATH . $image_id . '-76.png', 'image/png');

			// Non-Retina iPad pre iOS7
			$image->resize(72, 72, TRUE);
			$image->save(UPLOADS_PATH . BOOKMARK_ICONS_PATH . $image_id . '-72.png', 'image/png');

			// Non-Retina iPhone pre iOS 7
			$image->resize(57, 57, TRUE);
			$image->save(UPLOADS_PATH . BOOKMARK_ICONS_PATH . $image_id . '-57.png', 'image/png');
		endif;
	}

	public function get_all_locations() {
		$locations = array();
		$pages = get_posts(array('post_type' => 'location', 'numberposts' => -1));

		foreach ($pages as $location):
			$locations[$location->ID] = TMF_Text::limit_chars($location->post_title, 30);
		endforeach;

		return $locations;
	}

	public function render() {
		global $tmf_option;
	?>
		<br/>
		<h3 class="title">Business Information</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<?php $this->label('Business Name', 'blogname') ?>
				</th>
				<td>
					<?php $this->text('blogname', 'medium') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Slogan', 'blogdescription') ?>
				</th>
				<td>
					<?php $this->text('blogdescription', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Admin Email', 'admin_email') ?>
				</th>
				<td>
					<?php $this->text('admin_email', 'medium') ?>
					<p class="description">Email address used for notifications.</p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Admin Email Name', 'tmf_admin_email_name') ?>
				</th>
				<td>
					<?php $this->text('tmf_admin_email_name', 'medium') ?>
					<p class="description">Email name used for notifications.</p>
				</td>
			</tr>

			<?php if ($tmf_option->post_type_location == 1): ?>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Primary Location', 'tmf_primary_location') ?>
					</th>
					<td>
						<?php $this->combobox('tmf_primary_location', $this->get_all_locations() , '-- Select Location --') ?>
						<p class="description"><a href="post-new.php?post_type=location">Click Here</a> to create a new location.</p>
					</td>
				</tr>

			<?php endif ?>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Timezone', 'timezone_string') ?>
				</th>
				<td>
					<?php $this->combobox('timezone_string', TMF_Time::$timezones) ?><br/>
					<div style="margin-top: 10px; position: relative; font-style:italic;">Current <?php echo TMF_Time::$timezones[TMF_Option::factory()->timezone_string] ?>: <code><?php echo date('F j, Y  g:ia', current_time('timestamp', 0)) ?></code></div>
					<p class="description">Choose the timezone of your primary business location.</p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					Accepted Forms of Payment
				</th>
				<td>
					<?php $this->checkbox('tmf_visa', FALSE) ?><?php $this->label('Visa', 'tmf_visa') ?><br/>
					<?php $this->checkbox('tmf_mastercard', FALSE) ?><?php $this->label('Mastercard', 'tmf_mastercard') ?><br/>
					<?php $this->checkbox('tmf_discover', FALSE) ?><?php $this->label('Discover', 'tmf_discover') ?><br/>
					<?php $this->checkbox('tmf_american_express', FALSE) ?><?php $this->label('American Express', 'tmf_american_express') ?><br/>
					<?php $this->checkbox('tmf_paypal', FALSE) ?><?php $this->label('PayPal', 'tmf_paypal') ?><br/>
				</td>
			</tr>

		</table>

		<br/>
		<h3 class="title">Logos & Icons</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					Main Logo
				</th>
				<td>
					<div>
						<img id="logo-preview" src="<?php echo wp_get_attachment_url($tmf_option->logo) ?>" style="margin: 0 0 20px 0; <?php if (!$tmf_option->logo) echo 'display: none; '?>" />
					</div>
					<input id="tmf-appearance-settings-logo" type="hidden" name="TMF[general_settings][tmf_logo]" value="<?php echo $tmf_option->logo ?>" />
					<input value="Upload Logo" type="button" class="uploader-button button-primary" data-preview="logo-preview" data-destination="tmf-appearance-settings-logo" data-panel-title="Upload or Choose a Logo" data-button-text="Select Logo" data-types="png,jpg,jpeg" />
					<input value="Remove Logo" type="button" class="button uploader-remove remove" data-preview="logo-preview" data-destination="tmf-appearance-settings-logo" <?php if (!$tmf_option->logo) echo 'style="display:none"'?> />
					<p class="description">The logo that will appear throughout your site.</p>

				</td>
			</tr>

			<tr valign="top">
				<th>
					Favicon
				</th>
				<td>
					<div>
						<img id="favicon-preview" src="<?php echo wp_get_attachment_url($tmf_option->favicon) ?>" style="margin: 0 0 20px 0; <?php if (!$tmf_option->favicon) echo 'display: none; '?>" />
					</div>
					<input id="tmf-appearance-settings-favicon" type="hidden" name="TMF[general_settings][tmf_favicon]" value="<?php echo $tmf_option->favicon ?>" />
					<input value="Upload Favicon" type="button" class="uploader-button button-primary" data-preview="favicon-preview" data-destination="tmf-appearance-settings-favicon" data-panel-title="Upload or Choose a Favicon" data-button-text="Select Favicon" data-types="ico" />
					<input value="Remove Favicon" type="button" class="button uploader-remove remove" data-preview="favicon-preview" data-destination="tmf-appearance-settings-favicon" <?php if (!$tmf_option->favicon) echo 'style="display:none"'?> />
					<p class="description">
						The icon will appear in browser bookmarks and toolbars. <br/>
						File must be a 32px by 32px ICO file.
					</p>
				</td>
			</tr>

			<tr valign="top">
				<th>
					Mobile Bookmark
				</th>
				<td>
					<div>
						<img id="mobile-bookmark-preview" src="<?php echo wp_get_attachment_url($tmf_option->mobile_bookmark) ?>" style="margin: 0 0 20px 0; <?php if (!$tmf_option->mobile_bookmark) echo 'display: none; '?>" />
					</div>
					<input id="tmf-appearance-settings-mobile-bookmark" type="hidden" name="TMF[general_settings][tmf_mobile_bookmark]" value="<?php echo $tmf_option->mobile_bookmark ?>" />
					<input value="Upload Mobile Bookmark" type="button" class="uploader-button button-primary" data-preview="mobile-bookmark-preview" data-destination="tmf-appearance-settings-mobile-bookmark" data-panel-title="Upload or Choose a Mobile Bookmark" data-button-text="Select Mobile Bookmark" data-types="png,jpg,jpeg" data-size="152,152" />
					<input value="Remove Mobile Bookmark" type="button" class="button uploader-remove remove" data-preview="mobile-bookmark-preview" data-destination="tmf-appearance-settings-mobile-bookmark" <?php if (!$tmf_option->mobile_bookmark) echo 'style="display:none"'?> />
					<p class="description">
						The icon will appear as the bookmark icon for iPhones and Android devices.<br/>
						File must be 152px by 152px. Use a PNG file for best results.
					</p>
				</td>
			</tr>
		</table><br/>

		<h3 class="title">Site Links</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Facebook', 'tmf_facebook') ?>
				</th>
				<td>
					<?php $this->text('tmf_facebook', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Instagram', 'tmf_instagram') ?>
				</th>
				<td>
					<?php $this->text('tmf_instagram', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('LinkedIn', 'tmf_linkedin') ?>
				</th>
				<td>
					<?php $this->text('tmf_linkedin', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Twitter', 'tmf_twitter') ?>
				</th>
				<td>
					<?php $this->text('tmf_twitter', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('YouTube', 'tmf_youtube') ?>
				</th>
				<td>
					<?php $this->text('tmf_youtube', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Avvo', 'tmf_avvo') ?>
				</th>
				<td>
					<?php $this->text('tmf_avvo', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Superlawyers', 'tmf_superlawyers') ?>
				</th>
				<td>
					<?php $this->text('tmf_superlawyers', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Best Lawyers', 'tmf_best_lawyers') ?>
				</th>
				<td>
					<?php $this->text('tmf_best_lawyers', 'large') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Martindale', 'tmf_martindale') ?>
				</th>
				<td>
					<?php $this->text('tmf_martindale', 'large') ?>
				</td>
			</tr>

		</table>

		<br/>
		<h3 class="title">Social Media Buttons</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					Facebook 'Like' Button
				</th>
				<td>
					<?php $this->checkbox('tmf_facebook_button_pages', FALSE) ?><?php $this->label('On Pages', 'tmf_facebook_button_pages') ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_facebook_button_posts', FALSE) ?><?php $this->label('On Posts', 'tmf_facebook_button_posts') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					Facebook 'Share' Button
				</th>
				<td>
					<?php $this->checkbox('tmf_facebook_share_button_pages', FALSE) ?><?php $this->label('On Pages', 'tmf_facebook_share_button_pages') ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_facebook_share_button_posts', FALSE) ?><?php $this->label('On Posts', 'tmf_facebook_share_button_posts') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					Twitter 'Tweet' Button
				</th>
				<td>
					<?php $this->checkbox('tmf_twitter_button_pages', FALSE) ?><?php $this->label('On Pages', 'tmf_twitter_button_pages') ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_twitter_button_posts', FALSE) ?><?php $this->label('On Posts', 'tmf_twitter_button_posts') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					LinkedIn 'Share' Button
				</th>
				<td>
					<?php $this->checkbox('tmf_linkedin_button_pages', FALSE) ?><?php $this->label('On Pages', 'tmf_linkedin_button_pages') ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_linkedin_button_posts', FALSE) ?><?php $this->label('On Posts', 'tmf_linkedin_button_posts') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					Pinterest 'Pin' Button
				</th>
				<td>
					<?php $this->checkbox('tmf_pinterest_button_pages', FALSE) ?><?php $this->label('On Pages', 'tmf_pinterest_button_pages') ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $this->checkbox('tmf_pinterest_button_posts', FALSE) ?><?php $this->label('On Posts', 'tmf_pinterest_button_posts') ?>
				</td>
			</tr>

		</table>
	<?php
	}

}

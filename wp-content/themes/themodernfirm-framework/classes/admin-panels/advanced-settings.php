<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Creates an advanced settings menu in the admin backend
 *
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_AdminPanel_AdvancedSettings extends TMF_AdminPanel {

	protected $name				= 'Advanced Settings';
	protected $menu_title		= 'Advanced';
	protected $parent_slug		= 'tmf-general-settings';
	protected $force_refresh	= TRUE;

	public function before_save(){
		global $tmf_option;

		// Check if site mode has changed.
		if ($tmf_option->site_mode != $this->post_data()->tmf_site_mode):
			// Load the new site mode
			new TMF_SiteMode($this->post_data()->tmf_site_mode);
		endif;

		// What to show on the front page
		if($tmf_option->site_mode == '2') {
			update_option('blog_public', '1');
		}

		if (isset($this->post_data(TRUE)->change_url_from) && isset($this->post_data(TRUE)->change_url_to)):
			new TMF_SiteMigration($this->post_data(TRUE)->change_url_from, $this->post_data(TRUE)->change_url_to);
		endif;

		if($this->post_data(TRUE)->tmf_post_type_options) {
			$tmf_post_type_options = array();

			// Loop through the posted data/post-types
			foreach($this->post_data(TRUE)->tmf_post_type_options as $key => $post_type) {
				// Loop through the list of options for each post-type
				foreach($post_type as $index => $value) {
					// Make comma separated lists an array because that's how WordPress stores the args for post_types
					if( strpos($value, ',') !== false ) {
						$tmf_post_type_options[$key][$index] = explode(',', $value);
					} else {
						$tmf_post_type_options[$key][$index] = $value;
					}
				}
			}

			update_option('tmf_post_type_options', $tmf_post_type_options);
		}

		if($this->post_data(TRUE)->tmf_taxonomy_options) {
			$tmf_taxonomy_options = array();

			// Loop through the posted data/post-types
			foreach($this->post_data(TRUE)->tmf_taxonomy_options as $key => $post_type) {
				// Loop through the list of options for each post-type
				foreach($post_type as $index => $value) {
					// Make comma separated lists an array because that's how WordPress stores the args for post_types
					if( strpos($value, ',') !== false ) {
						$tmf_taxonomy_options[$key][$index] = explode(',', $value);
					} else {
						$tmf_taxonomy_options[$key][$index] = $value;
					}
				}
			}

			update_option('tmf_taxonomy_options', $tmf_taxonomy_options);
		}

	}


	public function get_all_pages() {
		$all_pages	= get_pages();
		$pages		= array();

		foreach ($all_pages as $page):
			$pages[$page->ID] = TMF_Text::limit_chars($page->post_title, 30);
		endforeach;

		return $pages;
	}

	public function get_all_location_posts() {
		$args			= array( 'post_type' => 'location', 'numberposts' => -1 );
		$all_locations	= get_posts($args);
		$locations		= array();

		foreach ($all_locations as $location):
			$locations[$location->ID] = TMF_Text::limit_chars($location->post_title, 30);
		endforeach;

		return $locations;
	}

	// Define the create_tabs() method to set how many pages tabs to create.
    public function create_tabs() {
        // Add in-page tabs
        $this->addInPageTabs(
            array(
                'tab_slug'  =>    'site_settings',    // avoid hyphen(dash), dots, and white spaces
                'title'     =>    __( 'Page, Post and Site Settings', 'themodernfirm-framework' ),
            ),
            array(
                'tab_slug'  =>    'script_Settings',
                'title'     =>    __( ' Scripts and Analytics', 'themodernfirm-framework' ),
            ),
            array(
                'tab_slug'  =>    'mobile_dock_settings',
                'title'     =>    __( 'Mobile Dock', 'themodernfirm-framework' ),
            ),
            array(
                'tab_slug'  =>    'form_settings',
                'title'     =>    __( 'Form Settings', 'themodernfirm-framework' ),
            ),
            array(
                'tab_slug'  =>    'misc_styling',
                'title'     =>    __( 'Misc. Styling', 'themodernfirm-framework' ),
            ),
            array(
                'tab_slug'  =>    'cpt_white_labeling',
                'title'     =>    __( 'CPT White labeling', 'themodernfirm-framework' ),
            )
        );
    }

    // Render Warning message before showing the tabs
    public function before_tabs() {

    	// flush rewrites incase any post type slugs were changed
		flush_rewrite_rules();
    	?>
	    	<br/>
			<h2 style="color: red; padding-top: 0;">Warning!</h2>
			<p>The following configurations and features are intended for advanced users only.<br/>
			If you need assistance with your site, please contact The Modern Firm at <a href="mailto:support@themodernfirm.com">support@themodernfirm.com</a>, or visit <a href="http://www.themodernfirm.com/helpdesk/" target="_blank">www.themodernfirm.com/helpdesk/</a>.
			<br/><br/>
    	<?php
    }
    public function content_site_settings() {
    	global $tmf_option, $wp_option;
    	?>
    	<h3 class="title">Site Mode</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					Current Mode
				</th>
				<td>
					<?php $this->combobox('tmf_site_mode', TMF_SiteMode::$modes) ?>
					<p class="description">
						<b>Beta:</b> Site has yet to launch and is still undergoing changes.<br/>
						<b>Live:</b> Site is complete and publicly visible.<br/>
						<b>Maintenance:</b> Site was previously live but is offline for maintenance.
					</p>

					<em style="display: block; margin-top: 30px;">When the site is live — Check the "<a href="/wp-admin/options-reading.php">Discourage search engines from indexing this site</a>" checkbox is unchecked.</em>
				</td>
			</tr>

		</table><br/>

		<h3 class="title">Data Panels</h3>
		<table class="form-table">

			<tr valign="top">
				<td>
					<a href="/wp-admin/import.php">Import</a>&nbsp;&nbsp;&nbsp;
					<a href="/wp-admin/export.php">Export</a>&nbsp;&nbsp;&nbsp;
					<a href="/wp-admin/edit.php?page=tmf-post-migration">Post Type Migration</a>
				</td>
			</tr>

		</table><br/>

		<h3 class="title">Plugin Settings Panels</h3>
		<table class="form-table">

			<tr valign="top">
				<td>
					<?php foreach (TMF_Admin::$advanced_plugin_menus as $plugin): ?>
						<a href="<?php echo $plugin['parent'] . '?page=' . $plugin[2] ?>"><?php echo $plugin[0] ?></a>&nbsp;&nbsp;&nbsp;
					<?php endforeach ?>
				</td>
			</tr>

		</table><br/>

		<h3 class="title">Page & Post Settings</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Front Page', 'page_on_front') ?>
				</th>
				<td>
					<?php $this->combobox('page_on_front', $this->get_all_pages(), '-- Select Page --') ?>
					<p class="description">Choose a page to display as your front page.</p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Posts Page', 'page_for_posts') ?>
				</th>
				<td>
					<?php $this->combobox('page_for_posts', $this->get_all_pages(), '-- Select Page --') ?>
					<p class="description">Choose a page to be used for the default posts page. Leave blank for none.</p>

				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Post Permalink Structure', 'permalink_structure') ?>
				</th>
				<td>
					<?php $this->text('permalink_structure', 'medium') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					Page Breadcrumbs
				</th>
				<td>
					<?php $this->checkbox('tmf_breadcrumbs', FALSE) ?><?php $this->label('Enable navigation breadcrumbs on pages', 'tmf_breadcrumbs') ?>
				</td>
			</tr>

		</table>
		<br />
		<h3 class="title">Iframe Settings</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					Enable Iframe Embeds for Non Super Admin
				</th>
				<td>
					<?php $this->checkbox('tmf_block_iframe', true) ?><?php $this->label('Enable (Unchecked = Super Admins Only)', 'tmf_block_iframe') ?>
				</td>
			</tr>

		</table>

		<br />
		<h3 class="title">Jetpack Settings</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					Remove Jetpack from menu
				</th>
				<td>
					<?php $this->checkbox('tmf_block_jetpack', true) ?><?php $this->label('Enable (Unchecked = Jetpack is active)', 'tmf_block_jetpack') ?>
				</td>
			</tr>

		</table>

		<br />
		<h3 class="title">Custom Post Types</h3>
		<table class="form-table">

			<?php foreach (TMF_PostType::$loaded_types as $post_type => $obj): ?>
				<?php if('news' == $post_type): ?>
					<tr>
						<th></th>
						<td>
							<span style="width: 169px; margin-left: 47%; display: inline-block; font-weight: 700; vertical-align: top;">Read More Button & Links Checkboxes</span>
							<!--<span style="font-style: italic; display: inline-block; max-width: 250px;">Clicking the checkboxes will hide them on the front end of the site when there isn't a child template in place.</span>-->
							<span style="font-style: italic; display: inline-block; max-width: 250px;">Clicking the checkboxes are intended to hide the buttons or links. If you clear the cache and nothing seems to change. You will need to contact support to control the visibility of buttons and/or links.</span>
						</td>
					</tr>
				<?php endif; ?>
				<tr valign="top">
					<th scope="row">
						<?php $this->label(ucwords($obj->options['plural']), 'tmf_post_type_' . TMF_Text::underscores($post_type)) ?>
					</th>
					<td>
						<?php $this->checkbox('tmf_post_type_' . TMF_Text::underscores($post_type), FALSE) ?><?php $this->label('Enable', 'tmf_post_type_' . TMF_Text::underscores($post_type)) ?>
						<?php if ($obj->options['public'] == TRUE): ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php $slug = ('tmf_post_type_' . TMF_Text::underscores($post_type) . '_slug') ? $tmf_option->{'post_type_' . TMF_Text::underscores($post_type) . '_slug'} : $obj->options['slug'] ?>
							<?php $this->label('Slug: ', 'tmf_post_type_' .TMF_Text::underscores( $post_type) . '_slug') ?>
							<?php $this->text('tmf_post_type_' . TMF_Text::underscores($post_type) . '_slug', 'small', $slug ) ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php $slug = ('tmf_post_type_' . TMF_Text::underscores($post_type) . '_gutenberg') ? $tmf_option->{'post_type_' . TMF_Text::underscores($post_type) . '_gutenberg'} : $obj->options['slug'] ?>
							<?php $this->checkbox('tmf_post_type_' . TMF_Text::underscores($post_type) . '_gutenberg', FALSE) ?><?php $this->label('Enable Gutenberg', 'tmf_post_type_' . TMF_Text::underscores($post_type) . '_gutenberg') ?>

							<?php if(!in_array($post_type, array('location'))): ?>

								<?php if($tmf_option->{'post_type_' . TMF_Text::underscores($post_type)} != 1): ?>
									<span class="disabled">
								<?php endif ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?php $this->checkbox('tmf_post_type_' . TMF_Text::underscores($post_type) . '_read_more_buttons', FALSE) ?><?php $this->label('Read More Buttons', 'tmf_post_type_' . TMF_Text::underscores($post_type) . '_read_more_buttons') ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?php $this->checkbox('tmf_post_type_' . TMF_Text::underscores($post_type) . '_read_more_links', FALSE) ?><?php $this->label('Read More Links', 'tmf_post_type_' . TMF_Text::underscores($post_type) . '_read_more_links') ?>

								<?php if($tmf_option->{'post_type_' . TMF_Text::underscores($post_type)} != 1): ?>
									</span>
								<?php endif ?>

							<?php endif ?>
							<br/>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>

		</table>

		<br/>
		<h3 class="title">Site Migration</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<?php $this->label('Change URL From') ?>
				</th>
				<td>
					<span style="vertical-align:baseline;"><input type="text" name="TMF_x[advanced_settings][change_url_from]" class="medium" value="<?php echo $wp_option->siteurl . '/' ?>"/>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Change URL To') ?>
				</th>
				<td>
					<span style="vertical-align:baseline;">http://www.</span><input type="text" name="TMF_x[advanced_settings][change_url_to]" class="medium" value=""/>
					<p class="description">
						This will update all references of the previous domain name to a new URL.<br/>
						ex. domain.com, website.net
					</p>
				</td>
			</tr>

		</table>
    	<?php
    }

    public function content_script_Settings() {
    	?>

		<h3 class="title">Google Analytics</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Analytics ID', 'google_analytics_id') ?>
				</th>
				<td>
					<?php $this->text('tmf_analytics_id', 'small') ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					Universal Tracking Code
				</th>
				<td>
					<?php $this->checkbox('tmf_analytics_universal', FALSE) ?><?php $this->label('Use Asynchronous Google Analytics Universal Tracking Code', 'tmf_analytics_universal') ?>
					<h4>( Javascript method of Universal Analytics will be used unless this checkbox is ticked. )</h4>
				</td>
			</tr>

		</table>

		<br/>
		<h3 class="title">Google Tag Manager</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Tag Manager ID', 'google_tag_manager_id') ?>
				</th>
				<td>
					<?php $this->text('tmf_tag_manager_id', 'small') ?>
				</td>
			</tr>

		</table>

		<br />
    	<h3 class="title">Javascript Injections</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					Header Scripts
				</th>
				<td>
					<?php $this->textarea('tmf_js_header', 'medium') ?>
					<p class="description">
						Code will be placed before the closing &lt;head&gt; tag.
					</p>
				</td>

			</tr>

			<tr valign="top">
				<th scope="row">
					Footer Scripts
				</th>
				<td>
					<?php $this->textarea('tmf_js_footer', 'medium') ?>
					<p class="description">
						Code will be placed before the closing &lt;body&gt; tag.
					</p>
				</td>
			</tr>

		</table>

		<br/>
		<h3 class="title">CSS Overrides</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					CSS Styles
				</th>
				<td>
					<?php $this->textarea('tmf_css_overrides', 'medium') ?>
					<p class="description">
						Code will be placed after all other theme CSS in the &lt;head&gt; tag. <br/>This code will automattically be wrapped in &lt;style&gt; tags.
					</p>
				</td>

			</tr>

		</table>
    	<?php
    }

    public function content_mobile_dock_settings() {
    	?>
	    	<h3 class="title">Mobile Dock Widget Settings</h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						Click to Activate Mobile Dock
					</th>
					<td>
						<?php $this->checkbox('tmf_callfooter', FALSE) ?><?php $this->label('Enable the mobile dock widget.', 'tmf_callfooter') ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Dock Theme', 'tmf_mobile_theme') ?>
					</th>
					<td>
						<?php $this->combobox('tmf_mobile_theme', array('1' => 'Dark', '2' => 'Light'), '-- Select Theme --') ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Phone', 'mobile_footer_1') ?>
					</th>
					<td><?php $this->checkbox('tmf_mobile_footer_1_active', TRUE) ?><?php $this->label('Enable', 'mobile_footer_1_active') ?>
						<?php $this->text('tmf_mobile_footer_1', 'small') ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Map Information', 'mobile_footer_2') ?>
					</th>
					<td><?php $this->checkbox('tmf_mobile_footer_2_active', TRUE) ?><?php $this->label('Enable', 'mobile_footer_2_active') ?>
						<?php $this->text('tmf_mobile_footer_2', 'small') ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Contact', 'mobile_footer_3') ?>
					</th>
					<td><?php $this->checkbox('tmf_mobile_footer_3_active', TRUE) ?><?php $this->label('Enable', 'mobile_footer_3_active') ?>
						<?php $this->text('tmf_mobile_footer_3', 'small') ?>
					</td>
				</tr>


			</table>

			<br/>
			<h3 class="title">Mobile Dock Widget Color Settings</h3>
			<table class="form-table">

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Dock Background Color', 'mobile_dock_bg_color') ?>
					</th>
					<td>
						<?php $this->text('tmf_mobile_dock_bg_color', array('small', 'color-picker')) ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Dock Icons Color', 'mobile_dock_icons_color') ?>
					</th>
					<td>
						<?php $this->text('tmf_mobile_dock_icons_color', array('small', 'color-picker')) ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Dock Text Color', 'mobile_dock_text_color') ?>
					</th>
					<td>
						<?php $this->text('tmf_mobile_dock_text_color', array('small', 'color-picker')) ?>
					</td>
				</tr>

			</table>

			<br/>
			<h3 class="title">Mobile Menu Location Settings</h3>
			<table class="form-table">

				<tr valign="top">
					<th scope="row">
						Click to Activate Mobile Menu Location
					</th>
					<td>
						<?php $this->checkbox('tmf_mobile_nav_location', FALSE) ?><?php $this->label('Enable the mobile nav location.', 'tmf_mobile_nav_location') ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Menu Location', 'mobile_nav_location_id') ?>
					</th>
					<td>
						<?php $this->combobox('tmf_mobile_nav_location_id', $this->get_all_location_posts(), '-- Select Location --') ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Menu Location Background Color', 'mobile_nav_location_bg_color') ?>
					</th>
					<td>
						<?php $this->text('tmf_mobile_nav_location_bg_color', array('small', 'color-picker')) ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Menu Location Text Color', 'mobile_nav_location_text_color') ?>
					</th>
					<td>
						<?php $this->text('tmf_mobile_nav_location_text_color', array('small', 'color-picker')) ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Menu Location Icons Color', 'mobile_nav_location_icons_color') ?>
					</th>
					<td>
						<?php $this->text('tmf_mobile_nav_location_icons_color', array('small', 'color-picker')) ?>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php $this->label('Mobile Menu Location Divider Color', 'mobile_nav_location_divider_color') ?>
					</th>
					<td>
						<?php $this->text('tmf_mobile_nav_location_divider_color', array('small', 'color-picker')) ?>
					</td>
				</tr>

			</table>
    	<?php
    }

    public function content_form_settings() {
    	?>
    	<h3 class="title">WuFoo Forms</h3>
		<table class="form-table">

			<tr>
				<th scope="row">
					<?php $this->label('Contact Form ID (Formhash)', 'tmf_contact_form_id') ?>
				</th>
				<td>
					<?php $this->text('tmf_contact_form_id', 'small') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Placeholder Text', 'tmf_contact_form_placeholder') ?>
				</th>
				<td>
					<?php $this->text('tmf_contact_form_placeholder', 'medium') ?>
					<p class="description">
						This text shows up as a placeholder when a form cannot be generated.<br/>
						Wrap text in { } to display as a link for a WuFoo hosted form.
					</p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					WuFoo Stylesheet URL
				</th>
				<td>
					<textarea readonly style="background-color: #f4f4f4; color: #888; resize: none; width: 100%; max-width: 600px; height: 50px" onfocus="this.select()" onMouseUp="return false"><?php echo get_stylesheet_directory_uri(); ?>/assets/css/wufoo.css</textarea>
				</td>
			</tr>

		</table>
    	<?php
    }

    public function content_misc_styling() {
    	// Default colors

    	$bg_color = !empty( TMF_Option::factory()->{'tmf_cta_bg_color'} ) ? TMF_Option::factory()->{'tmf_cta_bg_color'} : '#c2c7cb';
		$txt_color = !empty( TMF_Option::factory()->{'tmf_cta_txt_color'} ) ? TMF_Option::factory()->{'tmf_cta_txt_color'} : '#FFFFFF';
		$link_color = !empty( TMF_Option::factory()->{'tmf_cta_link_color'} ) ? TMF_Option::factory()->{'tmf_cta_link_color'} : '#0087e2';
    	?>
    	<h3 class="title">Call to Action Styling for Tiny MCE Formatting</h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Call To Action Background Color', 'cta_bg_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_cta_bg_color', array('small', 'color-picker'), $bg_color) ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Call To Action H1 Color', 'cta_h1_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_cta_h1_color', array('small', 'color-picker')) ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Call To Action H2 Color', 'cta_h2_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_cta_h2_color', array('small', 'color-picker')) ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Call To Action H3 Color', 'cta_h3_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_cta_h3_color', array('small', 'color-picker')) ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Call To Action Text Color', 'cta_txt_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_cta_txt_color', array('small', 'color-picker'), $txt_color) ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php $this->label('Call To Action Link Color', 'cta_link_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_cta_link_color', array('small', 'color-picker'), $link_color) ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Margin', 'cta_margin') ?>
				</th>
				<td>
					<?php $this->text('tmf_cta_margin', 'medium') ?><br />
					<em><!-- You can add rules for margin in two different formats.<br><br> -->
					Input: <strong>25px</strong> applies the rules to all top and bottom.<br>
					<!-- Input: <strong>10px,10px,15px,10px</strong> will allow you to modify for each side. (top,right,bottom,left) --></em>
					
				</td>
			</tr>


			<tr>
				<th scope="row">
					<?php $this->label('Padding', 'cta_padding') ?>
				</th>
				<td>
					<?php $this->text('tmf_cta_padding', 'medium') ?><br />
					<em><!-- You can add rules for padding in two different formats.<br><br> -->
					Input: <strong>0px</strong> applies the rules to all 4 sides.<br>
					<!-- Input: <strong>10px,10px,15px,10px</strong> will allow you to modify for each side. (top,right,bottom,left) --></em>
				</td>
			</tr>
		</table>

		<div style="margin-top: 15px"></div>
    	<h3 class="title">Blockquote Stylings</h3>
		<table class="form-table">

			<tr>
				<th scope="row">
					<?php $this->label('Click to show quote icon before quotes.', 'tmf_blockquote_icon') ?>
				</th>
				<td>
					<?php $this->checkbox('tmf_blockquote_icon', FALSE) ?><?php $this->label('Enable the quote icon(s). <em>The default is to not show quote icon</em>', 'tmf_callfooter') ?>
				</td>
			</tr>

		</table>

		<div style="margin-top: 15px"></div>
    	<h3 class="title">Aside Stylings</h3>
		<table class="form-table">

			<tr>
				<th scope="row">
					<?php $this->label('Border Radius', 'aside_border_radius') ?>
				</th>
				<td>
					<?php $this->text('tmf_aside_border_radius', 'medium') ?><br />
					<em><!-- You can add rules for margin in two different formats.<br><br> -->
					Set to <strong>0px</strong> for square edges<br>
					<!-- Input: <strong>10px,10px,15px,10px</strong> will allow you to modify for each side. (top,right,bottom,left) --></em>
					
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Background Color', 'aside_background_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_aside_background_color', 'small color-picker') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Heading Color', 'aside_heading_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_aside_heading_color', 'small color-picker') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Text Color', 'aside_text_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_aside_text_color', 'medium color-picker') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Link Color', 'aside_link_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_aside_link_color', 'medium color-picker') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Margin', 'aside_margin') ?>
				</th>
				<td>
					<?php $this->text('tmf_aside_margin', 'medium') ?><br />
					<em><!-- You can add rules for margin in two different formats.<br><br> -->
					Input: <strong>10px</strong> applies the rules to all 4 sides.<br>
					<!-- Input: <strong>10px,10px,15px,10px</strong> will allow you to modify for each side. (top,right,bottom,left) --></em>
					
				</td>
			</tr>


			<tr>
				<th scope="row">
					<?php $this->label('Padding', 'aside_padding') ?>
				</th>
				<td>
					<?php $this->text('tmf_aside_padding', 'medium') ?><br />
					<em><!-- You can add rules for padding in two different formats.<br><br> -->
					Input: <strong>10px</strong> applies the rules to all 4 sides.<br>
					<!-- Input: <strong>10px,10px,15px,10px</strong> will allow you to modify for each side. (top,right,bottom,left) --></em>
				</td>
			</tr>


			<tr>
				<th scope="row">
					<?php $this->label('Italicize Font', 'aside_font_italic') ?>
				</th>
				<td>
					<?php
						$font_weight = array(
							'select' => 'Select',
							'bold' => 'Bold'
						);
					?>
					<?php $this->checkbox('tmf_aside_font_italic', FALSE, 'bold') ?> <em>(Deselected will be normal text)</em>
				</td>
			</tr>


			<tr>
				<th scope="row">
					<?php $this->label('Bold Font', 'aside_font_bold') ?>
				</th>
				<td>
					<?php
						$font_weight = array(
							'select' => 'Select',
							'bold' => 'Bold'
						);
					?>
					<?php $this->checkbox('tmf_aside_font_bold', FALSE, 'bold') ?>
				</td>
			</tr>

		</table>

		<div style="margin-top: 15px"></div>
    	<h3 class="title">Star Stylings</h3>
		<table class="form-table">

			<tr>
				<th scope="row">
					<?php $this->label('Star Color', 'star_color') ?>
				</th>
				<td>
					<?php $this->text('tmf_star_color', 'medium color-picker') ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<?php $this->label('Star Font Size', 'star_font_size') ?>
				</th>
				<td>
					<?php $this->text('tmf_star_font_size', 'medium') ?><br />
					<em>Input: <strong>1.5em</strong> applies all stars rendered on the site.<br></em>
				</td>
			</tr>

		</table>

		<div style="margin-top: 15px"></div>
    	<h3 class="title">Double Spacing</h3>
		<table class="form-table">

			<tr>
				<th scope="row">
					<?php $this->label('Allow extra spaces in content', 'allow_extra_sapces') ?>
				</th>
				<td>
					<?php $this->checkbox('tmf_allow_extra_sapces', FALSE) ?>
				</td>
			</tr>

		</table>
    	<?php
	}
	
	public function content_cpt_white_labeling() {
		global $tmf_option;
		?>
		<table class="form-table">

			<?php $tmf_post_type_options = $tmf_option->post_type_options ?>
			<?php $i = 0; ?>
			<?php foreach (TMF_PostType::$loaded_types as $post_type => $obj): ?>
				<?php $i++ ?>

				<div class="tmf-admin-tab">
					<h2 class="collapsible-header">
						<button type="button" class="toggle-trigger" aria-expanded="<?php echo (1 === $i ? 'true' : 'false')  ?>">
							<?php $this->label(ucwords($obj->options['plural']), 'tmf_post_type_' . TMF_Text::underscores($post_type)) ?> (<code><?php echo $post_type ?></code>) <span class="toggle-trigger-icon dashicons <?php echo (1 === $i ? 'dashicons-arrow-up-alt2' : 'dashicons-arrow-down-alt2')  ?>" aria-hidden="<?php echo (1 === $i ? 'false' : 'true')  ?>"></span>
						</button>
					</h2>
					<div class="tmf-tab-container <?php echo (1 === $i ? 'toggle-trigger' : 'toggle-trigger-hidden')  ?>">
						<h3>Post Type Labels</h3>

						<?php foreach($obj->options as $label => $value): ?>
						
							<div class="form-control">
								<?php if('show_in_menu' == $label): ?>
									<?php if(is_array($tmf_post_type_options) && $tmf_post_type_options[TMF_Text::underscores($post_type)]['show_in_menu']): ?>
										<?php $menu_name = (is_array($tmf_post_type_options) && $tmf_post_type_options[TMF_Text::underscores($post_type)]['show_in_menu']) ? $tmf_post_type_options[TMF_Text::underscores($post_type)]['show_in_menu'] : $value ?>
									<?php else: ?>
										<?php $menu_name = (is_array($tmf_post_type_options) && $tmf_post_type_options[TMF_Text::underscores($post_type)]['show_ui']) ? $tmf_post_type_options[TMF_Text::underscores($post_type)]['show_ui'] : $obj->options['show_ui'] ?>
									<?php endif; ?>
								<?php else: ?>
									<?php if((is_array($value) && count($value) > 0) || ( is_array($tmf_post_type_options) && is_array($tmf_post_type_options[TMF_Text::underscores($post_type)][$label]) && count($tmf_post_type_options[TMF_Text::underscores($post_type)][$label]) > 0)): ?>
										<?php $menu_name = (is_array($tmf_post_type_options) && is_array($tmf_post_type_options[TMF_Text::underscores($post_type)][$label]) && count($tmf_post_type_options[TMF_Text::underscores($post_type)][$label]) > 0) ? implode(',', $tmf_post_type_options[TMF_Text::underscores($post_type)][$label]) : implode(',', $value) ?>
									<?php else: ?>
										<?php $menu_name = (is_array($tmf_post_type_options) && $tmf_post_type_options[TMF_Text::underscores($post_type)][$label]) ? $tmf_post_type_options[TMF_Text::underscores($post_type)][$label] : $value ?>
									<?php endif; ?>
								<?php endif; ?>

								<?php $this->label(ucwords(str_replace('_', ' ', $label)) .': ', TMF_Text::dashes( $post_type).'-'. TMF_Text::dashes($label)) ?>
								
								<?php if($this->is_post_type_label_bool($label)): ?>
									<select id="tmf-advanced-settings-tmf-mobile-theme" name="TMF_x[advanced_settings][tmf_post_type_options][<?php echo TMF_Text::underscores($post_type) ?>][<?php echo $label ?>]" class=" combobox" >
										<option>-- Select Option --</option>
										<option value="0"<?php echo (0 == sanitize_text_field($menu_name)) ? ' selected="selected"' : '' ?>>No</option>
										<option value="1"<?php echo (1 == sanitize_text_field($menu_name)) ? ' selected="selected"' : '' ?>>Yes</option>
									</select>
								<?php else: ?>
									<input type="text" name="TMF_x[advanced_settings][tmf_post_type_options][<?php echo TMF_Text::underscores($post_type) ?>][<?php echo $label ?>]" class="medium" value="<?php echo sanitize_text_field($menu_name) ?>" id="tmf-advanced-settings-<?php echo TMF_Text::dashes( $post_type).'-'. TMF_Text::dashes($label) ?>" />
								<?php endif; ?>	
							</div>

						<?php endforeach; ?>

						<?php foreach($obj->taxonomy as $taxonomy => $value): ?>
							<h3><?php echo TMF_Text::pretty($taxonomy) ?></h3>

							<?php foreach($value as $label => $data): ?>

								<div class="form-control">
									<?php if('show_in_menu' == $label): ?>
										<?php if(is_array($tmf_taxonomy_options) && $tmf_taxonomy_options[TMF_Text::underscores($post_type)]['show_in_menu']): ?>
											<?php $menu_name = (is_array($tmf_taxonomy_options) && $tmf_taxonomy_options[TMF_Text::underscores($post_type)]['show_in_menu']) ? $tmf_taxonomy_options[TMF_Text::underscores($post_type)]['show_in_menu'] : $data ?>
										<?php else: ?>
											<?php $menu_name = (is_array($tmf_taxonomy_options) && $tmf_taxonomy_options[TMF_Text::underscores($post_type)]['show_ui']) ? $tmf_taxonomy_options[TMF_Text::underscores($post_type)]['show_ui'] : $obj->options['show_ui'] ?>
										<?php endif; ?>
									<?php else: ?>
										<?php if(is_array($data) || ( is_array($tmf_taxonomy_options) && is_array($tmf_taxonomy_options[TMF_Text::underscores($post_type)][$label]))): ?>
											<?php $menu_name = (is_array($tmf_taxonomy_options) && $tmf_taxonomy_options[TMF_Text::underscores($post_type)][$label]) ? implode(',', $tmf_taxonomy_options[TMF_Text::underscores($post_type)][$label]) : implode(',', $data) ?>
										<?php else: ?>
											<?php $menu_name = (is_array($tmf_taxonomy_options) && $tmf_taxonomy_options[TMF_Text::underscores($post_type)][$label]) ? $tmf_taxonomy_options[TMF_Text::underscores($post_type)][$label] : $data ?>
										<?php endif; ?>
									<?php endif; ?>

									<?php $this->label(ucwords(str_replace('_', ' ', $label)) .': ', TMF_Text::dashes( $taxonomy).'-'. TMF_Text::dashes($label)) ?>
									
									<?php if($this->is_post_type_label_bool($label)): ?>
										<select id="tmf-advanced-settings-tmf-mobile-theme" name="TMF_x[advanced_settings][tmf_taxonomy_options][<?php echo TMF_Text::underscores($post_type) ?>][<?php echo $label ?>]" class=" combobox" >
											<option>-- Select Option --</option>
											<option value="0"<?php echo (0 == sanitize_text_field($menu_name)) ? ' selected="selected"' : '' ?>>No</option>
											<option value="1"<?php echo (1 == sanitize_text_field($menu_name)) ? ' selected="selected"' : '' ?>>Yes</option>
										</select>
									<?php else: ?>
										<input type="text" name="TMF_x[advanced_settings][tmf_taxonomy_options][<?php echo TMF_Text::underscores($taxonomy) ?>][<?php echo $label ?>]" class="medium" value="<?php echo sanitize_text_field($menu_name) ?>" id="tmf-advanced-settings-<?php echo TMF_Text::dashes( $taxonomy ).'-'. TMF_Text::dashes($label) ?>" />
									<?php endif; ?>	
								</div>
							
							<?php endforeach; ?>

						<?php endforeach; ?>

					</div>
				</div>
			<?php endforeach ?>

		</table>

    	<?php
	}

	public function is_post_type_label_bool($label) {
		$booleans = array('public', 'hierarchical', 'exclude_from_search', 'publicly_queryable', 'show_ui', 'show_in_nav_menus', 'show_in_admin_bar', 'show_in_rest', 'map_meta_cap', 'has_archive', 'can_export', 'has_shortcode', 'with_front', 'has_seo', 'bulk_actions', 'show_thumbnail_in_table', 'hide_post_status');

		if(in_array($label, $booleans)) {
			return true;
		}

		return false;
	}

}

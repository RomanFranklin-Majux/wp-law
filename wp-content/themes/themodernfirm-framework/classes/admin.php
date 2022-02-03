<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * Various functions to modify the Wordpress admin panel
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Admin {


	/**
	 * Setting for discussion/comment UI removal.
	 *
	 * @return  bool
	 */
	public static $remove_discussion_ui = TRUE;


	public static $advanced_plugin_menus = array();


	/**
	 * Registers actions related to customizing the admin panel
	 *
	 * @return  void
	 */
	public static function actions() {
		// Forcefully remove the prefix for shortcodes ultimate
		// This will also render the plugin settings prefix box useless
		update_option('su_option_prefix', '');
		
		// This will forcefully enable the akismet integration for gravity forms
		update_option('rg_gforms_enable_akismet', 1);

		// Force save disable attachment pages via yoast
		if($wpseo_titles = get_option('wpseo_titles')) {
			if($wpseo_titles) {
				$wpseo_titles['disable-attachment'] = 1;
				update_option('wpseo_titles', $wpseo_titles);
			}
		}

		//add_action( 'admin_footer', array('TMF_Admin', 'upscopeEnqueue') );
		//add_action( 'wp_footer', array('TMF_Admin', 'upscopeEnqueue') );

		add_action('admin_menu', array('TMF_Admin', 'edit_menu'), 1000000);
		add_action('wp_dashboard_setup', array('TMF_Admin', 'edit_dashboard_widgets'));
		add_action('admin_enqueue_scripts', array('TMF_Admin', 'enqueue'));
		add_filter('gform_noconflict_styles', array('TMF_Admin', 'register_style'));
		add_action('wp_before_admin_bar_render', array('TMF_Admin', 'edit_admin_bar'));
		add_action('rightnow_end', array('TMF_Admin', 'rightnow_dashboard'));
		add_action('login_head', array('TMF_Admin', 'custom_login_logo'));
		add_action('login_footer', array('TMF_Admin', 'server_name_in_footer'));
		add_action('admin_menu' , array('TMF_Admin', 'edit_metaboxes'));
		if( is_multisite() ):
			add_filter('wp_kses_allowed_html', array('TMF_Admin', 'esw_author_cap_filter'), 1, 1);
		endif;

		if ( get_option('tmf_block_jetpack') == 1 ):
			add_action( 'admin_menu', function() {
			        remove_menu_page( 'jetpack' );

					remove_meta_box('jetpack_summary_widget', 'dashboard', 'normal');
			     
			}, 1000 );
		endif;
	}


	/**
	 * Registers filters related to customizing the admin panel
	 *
	 * @return  void
	 */
	public static function filters() {
		add_filter('admin_footer_text', array('TMF_Admin', 'admin_footer_text'), 11);
		add_filter('update_footer', array('TMF_Admin', 'admin_version_text'), 11);
		$current_user = wp_get_current_user();
		if( !in_array($current_user->user_login, array('adminuser')) ) {
			add_filter('pre_site_transient_update_plugins', '__return_null'); // Disables plugin update messages
		}
		add_filter('admin_bar_menu', array('TMF_Admin','replace_howdy'), 25);
		add_filter('manage_posts_columns', array('TMF_Admin', 'remove_table_columns'));
		add_filter('manage_pages_columns', array('TMF_Admin', 'remove_table_columns'));
		add_filter('manage_media_columns', array('TMF_Admin', 'remove_table_columns'));
		add_filter('parent_file', array('TMF_Admin', 'move_menus_panel'));
		add_filter('login_headerurl', array('TMF_Admin', 'loginpage_custom_link'));
		add_filter('wp_mail_from_name', array('TMF_Admin', 'email_sender_name'));

		add_filter( 'gform_form_settings', array('TMF_Admin', 'after_click_button_form_setting'), 10, 2 );
		add_filter( 'gform_pre_form_settings_save', array('TMF_Admin', 'save_after_click_button_form_setting') );
		add_filter( 'gform_submit_button', array('TMF_Admin', 'add_on_click_js'), 10, 2 );
		// Gform Email notification customization
		//add_filter( 'gform_notification', array('TMF_Admin', 'gform_add_email_footer_text'), 10, 3 );
		//add_filter( 'gform_notification_ui_settings', array('TMF_Admin', 'gform_add_fields_to_notification_setting'), 10, 3 );
		//add_filter( 'gform_pre_notification_save', array('TMF_Admin', 'gform_save_notification_fields'), 10, 2 );
		add_filter( 'su/data/shortcodes', array('TMF_Admin', 'remove_su_shortcodes') );
		add_filter( 'su/config/default_settings', array( 'TMF_Admin', 'remove_su_prefix' ) );
		add_filter( 'su/data/groups', array( 'TMF_Admin', 'register_groups' ) );

        // PHP 7.4 Fix for favicon
        add_filter('upload_mimes', array('TMF_Admin', 'enable_extended_upload'));
	}

	/**
	 * Add new field on settings page of form
	 *
	 * @param   array   $settings   an array of the form setting fields
	 * @param   array   $form   an array containing the form
	 * @return  string
	 */
	public static function after_click_button_form_setting( $settings, $form ) {

		// New field that will be added on the Form Settings
		$new_field = array('after_click_button_text' => '
	<tr id="form_button_text_setting" class="child_setting_row" style="">
		<th>
			After Click Button text
		</th>
		<td>
			<input type="text" id="after_click_button_text" name="after_click_button_text" class="fieldwidth-3" value="' . rgar($form, 'after_click_button_text') . '">
		</td>
	</tr>');
	
		// Append new arrow after "Button text" field
		array_splice( $settings[ __( 'Form Button', 'gravityforms' ) ] , 2, 0, $new_field);
	
	 
		return $settings;
	}
	
	/**
	 * Save the custom field on form save
	 *
	 * @param   array    $form   an array containing the form
	 * @return  string
	 */
	public static function save_after_click_button_form_setting($form) {
		$form['after_click_button_text'] = rgpost( 'after_click_button_text' );
		return $form;
	}

	/**
	 * Add onclick JavaScript on the button
	 *
	 * @param   string   $button   submit button html
	 * @param   array    $form   an array containing the form
	 * @return  string
	 */
	public static function add_on_click_js( $button, $form ) {

		$id = $form['id'];
		$after_click_button_text = $form['after_click_button_text'];
		
		if($after_click_button_text)  {
			return $button .= '<script type="text/javascript">jQuery(document).ready(function($){
				jQuery("#gform_'. $id .'").on("submit", function() {
					var submit = jQuery(this).find("#gform_submit_button_'. $id .'");
					submit.prop("value", "'. $after_click_button_text .'");
				});
			});</script>';
		}
		
		return $button;
	}

	/**
	 * Allow iframes in tinymce for site admins
	 *
	 * @param   object   $allowedposttags   allowed post tags for the tinymce
	 * @return  object
	 */
	public static function esw_author_cap_filter( $allowedposttags ) {

			//Here put your conditions, depending your context

			if ( !current_user_can( 'manage_options' ) || get_option('tmf_block_iframe') != 1 )
			return $allowedposttags;

			// Here add tags and attributes you want to allow

			$allowedposttags['iframe']=array(

			'align' => true,
			'width' => true,
			'height' => true,
			'frameborder' => true,
			'name' => true,
			'src' => true,
			'id' => true,
			'class' => true,
			'style' => true,
			'scrolling' => true,
			'marginwidth' => true,
			'marginheight' => true,

			);
			return $allowedposttags;

		}


	/**
	 * Removes table columns from pages and posts
	 *
	 * @param   object   $columns   columns for the pages or posts
	 * @return  object
	 */
	public static function remove_table_columns($columns) {
		
		// Remove comments column
		if (TMF_Admin::$remove_discussion_ui)
			unset($columns['comments']);

		return $columns;
	}


	/**
	 * Changes the 'Howdy' message in admin bar to be more professional.
	 *
	 * @param   object   $wp_admin_bar   object containing the admin bar
	 * @return  void
	 */
	public static function replace_howdy($wp_admin_bar) {
		$my_account	= $wp_admin_bar->get_node('my-account');
		$newtitle	= str_replace('Howdy,', 'Hello,', $my_account->title);
		$wp_admin_bar->add_node(array(
			'id'	=> 'my-account',
			'title'	=> $newtitle,
		));
	}


	/**
	 * Adds 'The Modern Firm' logo to the admin login page
	 *
	 * @param   int   $position   position of login screen
	 * @return  void
	 */
	public static function custom_login_logo($position) {
		echo	'<style type="text/css">h1 a {background-image: url(' . FRAMEWORK_URI . IMAGES_PATH . 'logo-tmf-274x66.png) !important; height: 66px !important; width: 274px !important; background-size: 274px 66px !important;}</style>';
	}


	/**
	 * Adds server name to the footer of login page
	 *
	 * @since   2.4.6
	 * @return  void
	 */
	public static function server_name_in_footer() {
		$hostname = gethostname();

		if(strrpos($hostname, 'latte') !== false) {
			$server_name = 'Latte';
		} else if(strrpos($hostname, 'mocha') !== false) {
			$server_name = 'Mocha';
		} else if(strrpos($hostname, 'espresso') !== false) {
			$server_name = 'Espresso';
		} else {
			$server_name = '3rd Party';
		}

		if($server_name) {
			echo '<div class="tmf-login-footer-text" style="text-align: center;">'. $server_name . ( is_multisite() ? ' - ' . get_current_blog_id() : '' ) .'</div>';
		}
	}


	/**
	 * Registers filters related to customizing the admin panel
	 *	
	 * @param	integer	$position	the position to add the separator at
	 * @return  void
	 */
	public static function add_menu_separator($position) {
		global $menu;
		$index = 0;

		foreach($menu as $offset => $section):

			if (substr($section[2],0,9) == 'separator')
				$index++;

			if ($offset >= $position):
				$menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
				break;
			endif;

		endforeach;
		ksort($menu);
	}


	/**
	 * Customizes the admin menu
	 *	
	 * @return  void
	 */
	public static function edit_menu() {
		global $menu, $submenu;

		/* move media menu */
		$menu[21] = $menu[10];
		unset($menu[10]);

		/* move bottom separator */
		$menu[79] = $menu[59];
		unset($menu[59]);

		// Remove unnecessary menu items
		remove_menu_page('link-manager.php');
		remove_menu_page('tools.php');
		remove_menu_page('options-general.php');
		remove_menu_page('themes.php');
		remove_menu_page('users.php');
		remove_submenu_page('index.php', 'my-sites.php');

		if (TMF_Admin::$remove_discussion_ui):
			remove_menu_page('edit-comments.php');
			remove_submenu_page('options-general.php', 'options-discussion.php');
		endif;


		// Look for any menu items which have been added by a plugin and add them to the advanced menu
		foreach ($submenu['options-general.php'] as $menu_item):
			if (!in_array($menu_item[0], array('General', 'Writing', 'Reading', 'Discussion', 'Media', 'Permalinks'))):
				$menu_item['parent'] = 'options-general.php';
				self::$advanced_plugin_menus[] = $menu_item;
			endif;
		endforeach;

		foreach ($submenu['tools.php'] as $menu_item):
			if (!in_array($menu_item[0], array('Available Tools', 'Import', 'Export', 'Delete Site'))):
				$menu_item['parent'] = 'tools.php';
				self::$advanced_plugin_menus[] = $menu_item;
			endif;
		endforeach;

		foreach ($submenu['themes.php'] as $menu_item):
			if (!in_array($menu_item[0], array('Themes', 'Customize', 'Menus'))):
				$menu_item['parent'] = 'themes.php';
				self::$advanced_plugin_menus[] = $menu_item;
			endif;
		endforeach;
	}


	/**
	 * Customizes the admin dashboard
	 *	
	 * @return  void
	 */
	public static function edit_dashboard_widgets() {
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
		remove_meta_box('dashboard_primary', 'dashboard', 'side');
		remove_meta_box('dashboard_secondary', 'dashboard', 'side');
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	}


	/**
	 * Customizes metaboxes to display
	 *	
	 * @return  void
	 */
	public static function edit_metaboxes() {

		if (TMF_Admin::$remove_discussion_ui):
			// remove discussion releated metaboxes from posts
			remove_meta_box('commentsdiv', 'post', 'normal');
			remove_meta_box('commentstatusdiv', 'post', 'normal');
			remove_meta_box('trackbacksdiv', 'post', 'normal');

			remove_meta_box('commentsdiv', 'page', 'normal');
			remove_meta_box('commentstatusdiv', 'page', 'normal');

			// remove discussion releated metaboxes from media
			remove_meta_box('commentsdiv', 'attachment', 'normal');
			remove_meta_box('commentstatusdiv', 'attachment', 'normal');
		endif;

		// Remove the default Page Attributes and replace with link to parent
		remove_meta_box('pageparentdiv', 'page', 'normal');

		// Remove the default excerpt box and replace it with a custom one
		remove_meta_box('postexcerpt', 'post', 'normal');

		TMF_Class::factory('metaboxes/page-settings')->load();
		new TMF_Metabox_PageSettings('page', 'side');

		TMF_Class::factory('metaboxes/title-settings')->load();
		new TMF_Metabox_TitleSettings('post', 'side');

		// Add image selector
		TMF_Class::factory('metaboxes/featured-images')->load();
		new TMF_Metabox_FeaturedImages('post', 'side');
		new TMF_Metabox_FeaturedImages('page', 'side');

		// Add password protect
		TMF_Class::factory('metaboxes/password-protect-basic')->load();
		new TMF_Metabox_PasswordProtectBasic('page', 'side');

		// Add the custom excerpt box
		TMF_Class::factory('metaboxes/excerpt')->load();
		new TMF_Metabox_Excerpt('post');

		// Add contributors metabox
		TMF_Class::factory('metaboxes/contributors')->load();
		new TMF_Metabox_Contributors('post', 'side');
	}

	/**
	 * Activates UpScope
	 *	
	 * @return  void
	 */
	public static function upscopeEnqueue() {

		$script = "<!-- The Modern Firm Remote Support START-->\n";
		$script .= "<script>\n";
		$script .= "if(window.country === 'US' || window.country === 'CA') {\n";
		$script .= "(function(w, u, d){var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};var l = function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://code.upscope.io/729AU8goet.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(typeof u!==\"function\"){w.Upscope=i;l();}})(window, window.Upscope, document);\n";
		$script .= "Upscope('init', {\n";
		$script .= 'uniqueId: "",' . "\n";
		$script .= 'identities: ["list", "of", "identities", "here"]' . "\n";
		$script .= "});\n";
		$script .= "}\n";
		$script .= "</script>\n";
		$script .= "<!-- The Modern Firm Remote Support END-->";

		echo $script;
	}


	/**
	 * Enqueues scripts and styles for the admin panel
	 *	
	 * @return  void
	 */
	public static function enqueue() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-mouse');
		wp_enqueue_script('jquery-ui-position');
		wp_enqueue_script('jquery-ui-autocomplete');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-button');
		
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_media();
		wp_enqueue_script('tmf-admin', FRAMEWORK_URI . JS_PATH . 'admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-widget','jquery-ui-autocomplete', 'wp-color-picker'), FALSE, TRUE);
		wp_enqueue_style('jquery.ui.theme', FRAMEWORK_URI . CSS_PATH . 'jquery-ui.css');
		wp_enqueue_style('tmf-admin', FRAMEWORK_URI . CSS_PATH . 'admin.css');
	}

	public static function register_style($styles) {
		$styles[] = 'tmf-admin';
		return $styles;
	}


	/**
	 * Customizes the admin footer text
	 *	
	 * @return  string
	 */
	public static function admin_footer_text() {

		$blogname = get_bloginfo( 'name' );
		if ( is_network_admin() ) {
			$blogname = ' ' . esc_html( $GLOBALS[ 'current_site' ]->site_name );
		}

		$output = is_super_admin() ? '<abbr title="Random-access memory">RAM </abbr>'. number_format_i18n(memory_get_peak_usage( true ) / 1024 / 1024, 1 ) . '/' . WP_MEMORY_LIMIT . '&nbsp;&nbsp;&bull;&nbsp;&nbsp; <abbr title="Structured Query Language">SQL </abbr>'. $GLOBALS[ 'wpdb' ]->num_queries.'&nbsp;&nbsp;&bull;&nbsp;&nbsp; <abbr title="Version of PHP (Hypertext Preprocessor)">PHPv </abbr>'. phpversion().'<br /><br /> Server IP: '.$_SERVER['SERVER_ADDR'].'&nbsp;&nbsp;&bull;&nbsp;&nbsp; Server Hostname: '.gethostname() .( is_multisite() ? '&nbsp;&nbsp;&bull;&nbsp;&nbsp; Edit Site: <a href="'. network_admin_url('site-info.php?id='. get_current_blog_id()) .'" target="_blank" rel="noopener noreferrer">' . get_current_blog_id() . '</a>' : '' ) .'</p>' : '</p>';

		return ''. $blogname .'&nbsp;&nbsp;&bull;&nbsp;&nbsp; Developed by <a href="http://www.themodernfirm.com" target="_blank">The Modern Firm, LLC</a>&nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href="http://www.themodernfirm.com/helpdesk/" target="_blank">Support</a>&nbsp;&nbsp;&bull;&nbsp;&nbsp;'. $output;
	}


	/**
	 * Adds the framework version number to the admin footer
	 *	
	 * @return  string
	 */
	public static function admin_version_text() {
		return 'Framework Version: ' . FRAMEWORK_VERSION . '&nbsp;&nbsp;&bull;&nbsp;&nbsp;' . 'Wordpress Version: '. WP_VERSION;
	}


	/**
	 * Adds the framework version number to the admin dashboard
	 *	
	 * @return  void
	 */
	public static function rightnow_dashboard() {
		echo '<p>Your site is using <strong>The Modern Firm Framework ' . FRAMEWORK_VERSION . '</strong></p>';
	}


	/**
	 * Customizes the admin toolbar
	 *	
	 * @return  void
	 */
	public static function edit_admin_bar() {
		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('updates');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('themes');
		$wp_admin_bar->remove_menu('customize');

		if (!is_super_admin()):
			$wp_admin_bar->remove_menu('my-sites');
		endif;
	}


	/**
	 * This set the 'Settings' panel as 'has submenu' for the moved 'menus' and 'users' panel.
	 *	
	 * @return  string
	 */
	public static function move_menus_panel($parent_file) {
		global $current_screen, $pagenow;

		if (in_array($current_screen->base, array('nav-menus', 'users', 'options-discussion'))):
			$pagenow = ''; // This is to get get_admin_page_parent() to keep the updated parent_file
			$parent_file = 'tmf-general-settings';
		endif;

		return $parent_file;
	}


	public static function loginpage_custom_link () {
		return 'http://www.themodernfirm.com';
	}


	public static function email_sender_name ($original_name) {
		global $tmf;

		$name = $tmf->option()->admin_email_name;
		
		return ($name) ? $name : $original_name;
	}


	/**
	 * This adds footer text to notification email message.
	 *	
	 * @return  string
	 */
	public static function gform_add_email_footer_text( $notification, $form, $entry ) {
		// If email footer isn't disabled, then add it
		if(!rgar( $notification, 'disable_email_footer' )) {
			$notification['message'] .= "\nForm submitted on this page: {embed_url}";
		}

		return $notification;
	}



	/**
	 * This adds checkbox on notification settings page.
	 *	
	 * @return  string
	 */
	public static function gform_add_fields_to_notification_setting( $ui_settings, $notification, $form ) {
	 
	    $ui_settings['disable_email_footer'] = '
	        <tr>
	            <th><label for="disable_email_footer">Email Footer</label></th>
	            <td><input type="checkbox" name="disable_email_footer" id="disable_email_footer" value="1" '. checked( '1', rgar( $notification, 'disable_email_footer' ) ) .'/><label for="disable_email_footer" class="inline">Disable</label></td>
	        </tr>';
	 
	    return $ui_settings;
	}



	/**
	 * This adds field for saving.
	 *	
	 * @return  array
	 */
	public static function gform_save_notification_fields( $notification, $form ) {
		$notification['disable_email_footer'] = rgpost( 'disable_email_footer' );
    	return $notification;
	}

	/**
	 * Filter to modify original shortcodes data
	 *
	 * @param array   $shortcodes Default shortcodes
	 * @return array Modified array
	 */
	public static function remove_su_shortcodes( $shortcodes ) {

		// Remove button shortcode
		unset( $shortcodes['posts'] );
		unset( $shortcodes['vimeo'] );
		unset( $shortcodes['youtube'] );
		unset( $shortcodes['su_pdf-popup'] );

		// Return modified data
		return $shortcodes;

	}


	/**
	 * Filter to add custom group
	 *
	 * @param array   $groups Default groups
	 * @return array Modified array
	 */
	public static function register_groups( $groups ) {
		$groups['tmf'] = __( 'TMF', 'tmf' );

		return $groups;
	}

	/**
	 * Filter to remove the prefix from shortcodes
	 *
	 * @param array   $options Default options
	 * @return array Modified array
	 */
	public static function remove_su_prefix( $options ) {
		$arr['su_option_prefix'] = '';

		return $options;
	}

	/**
	 * Filter to allow more file types in media upload
	 * 
	 * @param array		$mime_types
	 * @return array	Modified mime types
	 */
    public static function  enable_extended_upload ( $mime_types = array() ) {
		// Change the "ico" mime type from "image/x-icon" to "image/vnd.microsoft.icon"
		// Because PHP 7.4+ seem to use it, otherwise uploads seem to fail
		// On PHP 7.2 this new mime type does not seem to cause any issues
        $mime_types['ico']  = 'image/vnd.microsoft.icon';

        return $mime_types;
    }

}

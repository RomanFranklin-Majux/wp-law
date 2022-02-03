<?php
/**
 * This file acts as a bootstrap for the framework.
 * 
 * This file is ran directly after a child themes functions.php file.
 * 
 * Child themes should not use functions.php files. Child themes can 
 * extend the framework by using a 'TMF_Extend' class with 'before' 
 * and 'after' methods.
 * 
 * @package TheModernFirmFramework
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */

// Define global constants
define('WP_VERSION', $wp_version);
define('FRAMEWORK_VERSION', '2.4.9.5');
define('FRAMEWORK_PREFIX', 'TMF');
define('SITE_URL', site_url() . '/');
define('FRAMEWORK_PATH', get_template_directory() . '/');
define('THEME_PATH', get_stylesheet_directory() . '/');
define('FRAMEWORK_URI', get_template_directory_uri() . '/');
define('THEME_URI', get_stylesheet_directory_uri() .'/');
define('CLASSES_PATH', 'classes/');
define('BLOCKS_PATH', 'blocks/');
define('ASSETS_PATH', 'assets/');
define('TEMPLATES_PATH', 'templates/');
define('IMAGES_PATH', ASSETS_PATH . 'images/');
define('JS_PATH', ASSETS_PATH . 'js/');
define('CSS_PATH', ASSETS_PATH . 'css/');
define('WHITE_LABELED_USERNAMES', ['adminuser', 'latte', 'mocha']);

// Define upload global constants
$uploads = wp_upload_dir();
define('UPLOADS_PATH', $uploads['basedir'] . '/');
define('UPLOADS_URI', $uploads['baseurl'] . '/');
define('PRIMARY_IMAGES_PATH', 'primary-images/');
define('THUMBNAIL_IMAGES_PATH', 'thumbnail-images/');
define('BOOKMARK_ICONS_PATH', 'bookmark-icons/');

// This constant should be defined in wp-config.php. 
// If it is not, we'll default to a production environment for security.
if (!defined('TMF_ENVIRONMENT'))
	define('TMF_ENVIRONMENT', 'production');

// Yoast sitemap video fix
define ('YOAST_VIDEO_SITEMAP_BASENAME', 'vsvideo');

// Gravity Forms Settings
add_filter('gform_enable_field_label_visibility_settings', '__return_true');
define( 'GF_LICENSE_KEY', '0c20d6e22861dbeb16696267a1ff4f83' );

// YouTube API key for videos
define( 'YT_API_KEY', 'AIzaSyBFEw2oBLVb93eGBLKgv_hy4UQvyHn9EN0' );

// Use this code to activate Extra Shortcodes add-on
update_option( 'su_option_extra-shortcodes_license', '82DA-D226-9B9D-01A9' );

// Use this code to activate Additional Skins add-on
update_option( 'su_option_additional-skins_license', '82DA-D226-9B9D-01A9' );

// Use this code to activate Shortcode Creator (Maker) add-on
update_option( 'su_option_shortcode-creator_license', '60F4-0C14-B1B0-6C22' );


// Manually load core classes
// These classes cannot be overridden via a child theme
require 'classes/class.php';
require 'classes/exception.php';



// Set Exception visibility based on environment.
// If false, only generic errors will be generated.
TMF_Exception::$show_stack_trace = (TMF_ENVIRONMENT == 'development');


// Set the exception handler
set_exception_handler(array('TMF_Exception','handler'));


//Disable PHP Notice, Deprecated
error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);


// Load child theme extension class, if available
TMF_Class::factory('extend')->ignore_not_found()->load();


// Run 'before' extensions from child theme
// ** PHP Bug: PHP will crash if class does not exists when checking with just method_exists
if (class_exists('TMF_Extend') && method_exists('TMF_Extend', 'before'))
	TMF_Extend::before();


// Load classes via class loader
TMF_Class::factory('tmf')->load();
TMF_Class::factory('section')->load();
TMF_Class::factory('row')->load();
TMF_Class::factory('text')->load();
TMF_Class::factory('time')->load();
TMF_Class::factory('admin')->load();
TMF_Class::factory('block')->load();
TMF_Class::factory('option')->load();
TMF_Class::factory('navigation')->load();
TMF_Class::factory('breadcrumb')->load();
TMF_Class::factory('post')->load();
TMF_Class::factory('post-object')->load();
TMF_Class::factory('post-link')->load();
TMF_Class::factory('author')->load();
TMF_Class::factory('taxonomy')->load();
TMF_Class::factory('metabox')->load();
TMF_Class::factory('admin-panel')->load();
TMF_Class::factory('vcard')->load();
TMF_Class::factory('reminder')->load();
TMF_Class::factory('site-mode')->load();
TMF_Class::factory('site-migration')->load();
TMF_Class::factory('module')->load();
TMF_Class::factory('map')->load();
TMF_Class::factory('customize')->load();
TMF_Class::factory('style')->load();
TMF_Class::factory('script')->load();
TMF_Class::factory('rsvp')->load();
TMF_Class::factory('authorize')->load();
TMF_Class::factory('directory')->load();
TMF_Class::factory('request')->load();
TMF_Class::factory('association-member')->load();
TMF_Class::factory('event-registration')->load();
TMF_Class::factory('admin-shortcodes')->load();

TMF_Class::factory('admin-panels/general-settings')->load();
TMF_Class::factory('admin-panels/print-settings')->load();
TMF_Class::factory('admin-panels/reminders-settings')->load();
TMF_Class::factory('admin-panels/advanced-settings')->load();
TMF_Class::factory('admin-panels/post-settings')->load();
TMF_Class::factory('admin-panels/post-archive-settings')->load();
TMF_Class::factory('admin-panels/page-settings')->load();
TMF_Class::factory('admin-panels/post-migrate')->load();
TMF_Class::factory('admin-panels/change-log')->load();

TMF_Class::factory('post-type')->load();
TMF_Class::factory('post-types/event')->load();
TMF_Class::factory('post-types/attorney')->load();
TMF_Class::factory('post-types/staff')->load();
TMF_Class::factory('post-types/testimonial')->load();
TMF_Class::factory('post-types/practice-area')->load();
TMF_Class::factory('post-types/location')->load();
TMF_Class::factory('post-types/module')->load();
TMF_Class::factory('post-types/quote')->load();
TMF_Class::factory('post-types/news')->load();
TMF_Class::factory('post-types/article')->load();
TMF_Class::factory('post-types/faq')->load();
TMF_Class::factory('post-types/representative-case')->load();
TMF_Class::factory('post-types/ebook')->load();
TMF_Class::factory('post-types/video')->load();
TMF_Class::factory('post-types/communities')->load();
TMF_Class::factory('post-types/member')->load();
TMF_Class::factory('post-types/review-us')->load();
TMF_Class::factory('post-types/modern-slider')->load();
TMF_Class::factory('shortcode')->load();
TMF_Class::factory('post-type-shortcode')->load();

TMF_Class::factory('aside')->load();

TMF_Class::factory('modern-slider')->load();

// Run Crons
//TMF_Class::factory('cron')->load();

// Set global variables for Wordpress and The Modern Firm options
$wp_option	= new TMF_Option;
$tmf_option	= new TMF_Option(FRAMEWORK_PREFIX);


// Set the base TMF object
$tmf = new TMF_Tmf;


// Load default post types
new TMF_PostType_Module;
new TMF_PostType_ModernSlider;
new TMF_PostType_ReviewUs;
new TMF_PostType_News;
new TMF_PostType_Article;
new TMF_PostType_Faq;
new TMF_PostType_Event;
new TMF_PostType_Attorney;
new TMF_PostType_Staff;
new TMF_PostType_PracticeArea;
new TMF_PostType_Testimonial;
new TMF_PostType_RepresentativeCase;
new TMF_PostType_Location;
new TMF_PostType_Ebook;
new TMF_PostType_Video;
new TMF_PostType_Communities;
new TMF_PostType_Member;

// Add a post type shortcode for posts and pages
new TMF_PostTypeShortcode('posts', 'post', array('orderby' => 'date', 'order' => 'DESC', 'suppress_filters' => FALSE));
new TMF_PostTypeShortcode('pages', 'page', array('orderby' => 'date', 'order' => 'DESC', 'suppress_filters' => FALSE));

// Load default admin panels
new TMF_AdminPanel_GeneralSettings;
new TMF_AdminPanel_RemindersSettings;
new TMF_AdminPanel_PrintSettings;
new TMF_AdminPanel_AdvancedSettings;
new TMF_AdminPanel_PostArchiveSettings;
new TMF_AdminPanel_PostSettings;
new TMF_AdminPanel_PageSettings;
new TMF_AdminPanel_PostMigrate;

// Load Change log file
if( is_admin() && current_user_can('administrator') && file_exists(FRAMEWORK_PATH . 'docs/automattic/parse-readme.php')) {

	$current_user = wp_get_current_user();

	// Load the changelog only for selected users
	if( in_array($current_user->user_login, array('mocha', 'latte', 'adminuser')) ){
		new TMF_AdminPanel_ChangeLog;
	}
	
}


// Manage reminders
new TMF_Reminder;


// Association Members
new TMF_AssociationMember;


// TMF Aside
new TMF_Aside;

// TMF Customize
new TMF_Customize;

// Run Cron for log deletion
//new TMF_Cron;


// Run 'after' extensions from child theme
// ** PHP Bug: PHP will crash if class does not exists when checking with just method_exists
if (class_exists('TMF_Extend') && method_exists('TMF_Extend', 'after'))  
	TMF_Extend::after();

/* Include shortcodes from framework */
$files = scandir(dirname( __FILE__ ) . '/shortcodes');
foreach($files as $file) {
	if(is_file(dirname( __FILE__ ) . '/shortcodes/'.$file)){
  		include_once (dirname( __FILE__ ) . '/shortcodes/'.$file);
	}
}

/* Include shortcodes from child theme */

if(is_dir( THEME_PATH . '/shortcodes' )):

	$files = scandir( THEME_PATH . '/shortcodes');
	foreach($files as $file) {
		if(is_file( THEME_PATH . '/shortcodes/'.$file)){
	  		include_once ( THEME_PATH . '/shortcodes/'.$file);
		}
	}

endif;

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/brgupdates/themodernfirm-framework/',
	__FILE__,
	'tmf'
);

//Optional: If you're using a private repository, specify the access token like this:
$myUpdateChecker->setAuthentication('918d3b05e2e923907e105fd07d792c0832591cf2');

//Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');

//Remove “scaled” in File URL/Name Path when adding new image to library
add_filter( 'big_image_size_threshold', '__return_false' );


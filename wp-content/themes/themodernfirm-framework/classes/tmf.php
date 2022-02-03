<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * This acts as a base class for the TMF API for theme development.
 * 
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 * @since Version 2.0.1.0
 */
class TMF_Tmf {

	/**
	 * Registers actions related to customizing the front end
	 *
	 * @return  void
	 */
	public function actions() {
		add_action('wp_head', array('TMF_Tmf', 'tag_manager_header'), 2);
		add_action('body_start', array('TMF_Tmf', 'tag_manager_footer'), 0);
	}

	public function head () {
		$this->mobile_bookmarks();
		$this->favicon();
		wp_head();
		TMF_Script::bootloader();
		$this->css_overrides();
		$this->js_header_injection();
		$this->analytics();
		//$this->tag_manager_header();

		// WORKAROUND FIX
		// Note: This should ideally be in post-object.php
		// Somehow `the_posts` hook isn't being executed
		// I'll debug at later time
		// DO NOT COPY THIS TMF.PHP FILE AT ANYCOST AS LONG AS BELOW FIX IS HERE
		global $post;

		if(!did_action('the_posts') && !empty($post)) {
			$post->tmf = new TMF_PostObject( clone $post);
		}
	}


	public function footer () {
		global $tmf_option, $wp_filter;

$blockquote_css = '';

if( !empty($tmf_option->blockquote_icon) ) {
	$blockquote_css = '<style>';
	
	$blockquote_css .= 'blockquote:before {
    content: "\201C";
    float: left;
    font-size: 45px;
    margin-right: 10px;
    margin-top: 10px;
    position: absolute;
    left: -8px;
    top: -2px;
}';

	$blockquote_css .= '</style>';
}

echo $blockquote_css;

$star_css = '';

if( !empty($tmf_option->star_color) || !empty($tmf_option->star_font_size) ) {
	$star_css = '<style>.stars{';

	if( !empty($tmf_option->star_color) ){
		$star_css .= 'color: '.$tmf_option->star_color.' !important;';
	}

	if( !empty($tmf_option->star_font_size) ){
		$star_css .= 'font-size: '.$tmf_option->star_font_size.'em !important;';
	}

	$star_css .= '}</style>';
}

echo $star_css;

$aside_css = '';

if( !empty($tmf_option->aside_border_radius) || !empty($tmf_option->aside_background_color) || !empty($tmf_option->aside_text_color) || !empty($tmf_option->aside_font_style) || !empty($tmf_option->aside_padding) || !empty($tmf_option->aside_margin)) {
	$aside_css = '<style>';

	if( !empty($tmf_option->aside_border_radius) ){
		$aside_css .= 'aside{border-radius: '.$tmf_option->aside_border_radius.' !important;}';
	}

	if( !empty($tmf_option->aside_background_color) ){
		$aside_css .= 'aside{background: '.$tmf_option->aside_background_color.' !important;}';
	}

	if( !empty($tmf_option->aside_text_color) ){
		$aside_css .= 'aside{color: '.$tmf_option->aside_text_color.' !important;}';
	}

	if( !empty($tmf_option->aside_heading_color) ){
		$aside_css .= 'aside h3{color: '.$tmf_option->aside_heading_color.' !important;}';
	}

	if( !empty($tmf_option->aside_font_italic) ){
		$aside_css .= 'aside{font-style: italic !important;}';
	}

	if( !empty($tmf_option->aside_font_bold) ){
		$aside_css .= 'aside{font-weight: 700 !important;}';
	}

	if( !empty($tmf_option->aside_margin) ){
		$aside_css .= 'aside{margin: '.$tmf_option->aside_margin.' !important;}';
	}

	if( !empty($tmf_option->aside_padding) ){
		$aside_css .= 'aside{padding: '.$tmf_option->aside_padding.' !important;}';
	}
	
	$aside_css .= '</style>';
}

echo $aside_css;

$cta_colors = '';
if( !empty($tmf_option->cta_bg_color) || !empty($tmf_option->cta_h1_color) || !empty($tmf_option->cta_h2_color) || !empty($tmf_option->cta_h3_color) || !empty($tmf_option->cta_padding) || !empty($tmf_option->cta_margin) ) {
	$cta_colors = '<style>';

	if( !empty($tmf_option->cta_bg_color) ){
		$cta_colors .= '#call-to-action {background: '.$tmf_option->cta_bg_color.' !important;}';
	}

	if( !empty($tmf_option->cta_h1_color) ){
		$cta_colors .= '#call-to-action h1{color: '.$tmf_option->cta_h1_color.' !important;}';
	}

	if( !empty($tmf_option->cta_h2_color) ){
		$cta_colors .= '#call-to-action h2{color: '.$tmf_option->cta_h2_color.' !important;}';
	}

	if( !empty($tmf_option->cta_h3_color) ){
		$cta_colors .= '#call-to-action h3{color: '.$tmf_option->cta_h3_color.' !important;}';
	}

	if( !empty($tmf_option->cta_txt_color) ){
		$cta_colors .= '#call-to-action {color: '.$tmf_option->cta_txt_color.' !important;}';
	}

	if( !empty($tmf_option->cta_link_color) ){
		$cta_colors .= '#call-to-action a{color: '.$tmf_option->cta_link_color.' !important;}';
	}

	if( !empty($tmf_option->cta_margin) ){
		$cta_colors .= '#call-to-action {margin: '.$tmf_option->cta_margin.' !important;}';
	}

	if( !empty($tmf_option->cta_padding) ){
		$cta_colors .= '#call-to-action {padding: '.$tmf_option->cta_padding.' !important;}';
	}

	$cta_colors .= '</style>';
}

echo $cta_colors;

if (isset($tmf_option->callfooter)) {

			switch ($tmf_option->mobile_theme) {
				case 1:
					$mobile_theme = "dark";
				break;
				case 2:
					$mobile_theme = "light";
				break;
				default:
					$mobile_theme = "dark";
				break;
			}

	// Enable indiv. options for sites where mobile doc is enabled
	/*if( empty($tmf_option->mobile_footer_1_active) && empty($tmf_option->mobile_footer_2_active) && empty($tmf_option->mobile_footer_3_active)) {
		add_option('tmf_mobile_footer_1_active', '1');
		add_option('tmf_mobile_footer_2_active', '1');
		add_option('tmf_mobile_footer_3_active', '1');
	}*/

$mobile_theme_css = '';
if( !empty($tmf_option->mobile_dock_bg_color) ) {
	$mobile_theme_css = '<style>';

	if( !empty($tmf_option->mobile_dock_bg_color) ){
		$mobile_theme_css .= '#mobile-call-container ul, .hideme-container {background: '.$tmf_option->mobile_dock_bg_color.' !important;}';
	}

	if( !empty($tmf_option->mobile_dock_text_color) ){
		$mobile_theme_css .= '.dark .hideme,#mobile-call-buttons a {color: '.$tmf_option->mobile_dock_text_color.' !important;}';
		$mobile_theme_css .= empty($tmf_option->mobile_dock_icons_color) ? '.hideme i,#mobile-call-buttons a i {color: '.$tmf_option->mobile_dock_text_color.' !important;}' : '';
	}

	if( !empty($tmf_option->mobile_dock_icons_color) ){
		$mobile_theme_css .= '.hideme i, #mobile-call-buttons a i {color: '.$tmf_option->mobile_dock_icons_color.' !important;}';
	}

	$mobile_theme_css .= '</style>';
}

	$mobile_theme_html = $mobile_theme_css. '<div id="mobile-call-banner" class="'.$mobile_theme.'">
				<div id="mobile-call-wrapper">
					<div id="mobile-call-container">
						<ul id="mobile-call-buttons">';
	$mobile_theme_html .=  ($tmf_option->mobile_footer_1_active == '1') ? '<li class="button button-1">
								<a href="tel:'.$tmf_option->mobile_footer_1.'" ><i class="material-icons">phone</i>Phone</a>
							</li>' : '';
	$mobile_theme_html .=  ($tmf_option->mobile_footer_2_active == '1') ? '<li class="button button-2">
								<a href="http://maps.apple.com/?q='.$tmf_option->mobile_footer_2.'" ><i class="material-icons">location_on</i>Map</a>
							</li>' : '';
	$mobile_theme_html .=  ($tmf_option->mobile_footer_3_active == '1') ? '<li class="button button-3">
								<a href="'.$tmf_option->mobile_footer_3.'" ><i class="material-icons">email</i>Email</a>
							</li>' : '';
	$mobile_theme_html .=  '</div>
					<div class="hideme-container">
							<div class="hideme">
								<i class="material-icons">close</i>Close
							</div>
					</div>
				</div>
			</div>';

	echo $mobile_theme_html;
			
} else {
	
}
		// If the body_start hasn't fired up
		// Load legacy tag manager script, this will be removed once all top.php files for child themes are updated
		if( !isset($wp_filter['body_start']) || !did_action('body_start') ) {
			TMF_Tmf::tag_manager_footer();
		}
		//$this->tag_manager_footer();
		wp_footer();
		$this->js_footer_injection();
	}


	public function body_css () {
		body_class();
	}


	public function option () {
		global $tmf_option;
		return $tmf_option;
	}


	public function wp_option () {
		global $wp_option;
		return $wp_option;
	}


	public function js_header_injection () {
		//echo $this->option()->js_header;
		if($this->option()->js_header) {
			echo "<!--Following script is handled in Settings->Advanced-->".$this->option()->js_header;
		}else{
			echo $this->option()->js_header;
		}
	}


	public function js_footer_injection () {
		echo $this->option()->js_footer;
	}


	public function css_overrides () {
		if ($css = $this->option()->css_overrides)
			echo '<style type="text/css" media="screen">' .$css . '</style>';
	}


	public function author ($post) {
		return new TMF_Author($post);
	}


	public function section ($section) {
		return new TMF_Section($section);
	}


	public function block ($block) {
		return new TMF_Block($block);
	}


	public function row ($row = NULL, $collapse = FALSE, $css_classes = NULL) {
		return new TMF_Row($row, $collapse, $css_classes);
	}


	public function module ($module_area, $type = 'single') {
		return new TMF_Module($module_area, $type);
	}

	//Modern Slider
    public function slider ($slider_area) {
		return new TMF_ModernSlider($slider_area);
	}


	public function breadcrumb ($templates = array(), $options = array(), $strings = array()) {
		return new TMF_Breadcrumb($templates, $options, $strings);
	}


	public function posts ($posts = NULL, $template = NULL) {
		$posts = (is_array($posts)) ? $posts : $GLOBALS['posts']; 
		return new TMF_Post($posts, $template);
	}


	public function quotes ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'quote';
		return new TMF_Post($posts, $template);
	}


	public function practice_areas ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'practice-area';
		return new TMF_Post($posts, $template);
	}


	public function attorneys ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'attorney';
		return new TMF_Post($posts, $template);
	}


	public function staff ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'staff';
		return new TMF_Post($posts, $template);
	}


	public function locations ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'location';
		return new TMF_Post($posts, $template);
	}


	public function events ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'event';
		return new TMF_Post($posts, $template);
	}


	public function testimonials ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'testimonial';
		return new TMF_Post($posts, $template);
	}


	public function news ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'news';
		return new TMF_Post($posts, $template);
	}


	public function faqs ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'faq';
		return new TMF_Post($posts, $template);
	}


	public function representative_cases ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'representative-case';
		return new TMF_Post($posts, $template);
	}


	public function communities ($posts = array(), $template = NULL) {
		$posts['post_type'] = 'community';
		return new TMF_Post($posts, $template);
	}


	public function navigation ($nav) {
		return new TMF_Navigation($nav);
	}


	public function directory () {
		return new TMF_Directory;
	}


	public function request () {
		return new TMF_Request;
	}


	public function authorize () {
		return new TMF_Authorize();
	}


	public function comments () {
		global $withcomments;
		$withcomments = TRUE;

		comments_template('/blocks/micellaneous/comments.php');
	}


	public function has_navigation ($nav) {
		return TMF_Navigation::is_set($nav);
	}


	public function has_modules ($module, $multi = FALSE) {
		return TMF_Module::has_modules($module, $multi);
	}


	public function site_url () {
		return site_url();
	}


	public function render_shortcode ($text) {
		return TMF_Shortcode::render($text);
	}


	public function theme_image ($image){
		return THEME_URI . 
		IMAGES_PATH . $image;
	}


	public function image_url_from_id ($id) {
		return wp_get_attachment_url($id);
	}
	

	public function has_posts ($show_message = TRUE) {
		$request = $this->request();
		
		if ($request->is_directory() && !$request->is_taxonomy()):
			$post_type = TMF_Text::underscores($request->post_type());

			if ($this->option()->{$post_type . '_archive_hide_list'} == '1'):
				return FALSE;
			endif;
		endif;

		if (!$request->has_posts() && $show_message == TRUE):
			$this->no_posts_message();
			return FALSE;
		endif;
	
		return TRUE;
	}


	public function no_posts_message () {
		$post_type	= $this->request()->post_type();
		$message	= '';

		// Need to dobule check why array is returning when searching from archive page
		if (!empty($post_type) && $post_type != 'any' && !is_array($post_type) && !is_home()):
			$post_class = TMF_PostType::$loaded_types[$post_type];
			$message	= $post_class->no_posts_message();
		endif;

		$message = ($message) ? $message : 'There is currently no content.';
		
		TMF_Block::factory('miscellaneous/no-content')
			->set('message', $message)
			->render();
	}



	public function print_logo ($html = TRUE) {
		$logo = $this->option()->print_logo;

		// If print logo is not set, show the normal logo
		if(empty($logo)) {
			$logo = $this->option()->logo;
		}
		
		$logo = $this->image_url_from_id($logo);

		if (isset($logo) && $html == TRUE)
			TMF_Block::factory('miscellaneous/logo-print')
				->set('image', $logo)
				->render();
		
		if (isset($logo))
			return $logo;
	}


	public function logo ($html = TRUE) {
		$logo_id = self::option()->logo;
		$logo = self::image_url_from_id($logo_id);

		if (isset($logo) && $html == TRUE)
			TMF_Block::factory('miscellaneous/logo')
				->set('image', $logo)
				->set('id', $logo_id)
				->render();
		
		if (isset($logo))
			return $logo;
	}


	public function analytics () {
		if ($analytics_id = $this->option()->analytics_id)
			TMF_Block::factory('miscellaneous/analytics')
				->set('analytics_id', $analytics_id)
				->set('universal', $this->option()->analytics_universal)
				->render();
	}


	public static function tag_manager_header () {
		if ($tag_manager_id = self::option()->tag_manager_id)
			TMF_Block::factory('miscellaneous/tag-manager-header')
				->set('tag_manager_id', $tag_manager_id)
				->render();
	}


	public static function tag_manager_footer () {
		if ($tag_manager_id = self::option()->tag_manager_id)
			TMF_Block::factory('miscellaneous/tag-manager-footer')
				->set('tag_manager_id', $tag_manager_id)
				->render();
	}


	public function payment_icons () {
		$option = $this->option();

		TMF_Block::factory('miscellaneous/payment-icons')
			->set('visa', $option->visa) 
			->set('mastercard', $option->mastercard) 
			->set('discover', $option->discover) 
			->set('american_express', $option->american_express) 
			->set('paypal', $option->paypal)
			->render();
	}


	public function social_icons () {
		$option = $this->option();

		TMF_Block::factory('miscellaneous/social-icons')
			->set('facebook', $option->facebook) 
			->set('twitter', $option->twitter) 
			->set('linkedin', $option->linkedin) 
			->set('avvo', $option->avvo) 
			->set('google_plus', $option->google_plus)
			->set('youtube', $option->youtube)
			->render();
	}


	public function mobile_bookmarks () {		
		if ($icon = $this->option()->mobile_bookmark)
			TMF_Block::factory('miscellaneous/mobile-bookmark')
				->set('icon', $icon)
				->render();
	}


	public function favicon () {
		if ($icon = $this->option()->favicon)
			TMF_Block::factory('miscellaneous/favicon')
				->set('icon', $icon)
				->render();
	}





	/* -------------------------------------------
	 * DEPRECIATED METHODS
	---------------------------------------------- */

	/* Depreciated - 2.1.1.0 
		Use $this->request()->title();
	*/
	public function page_title ($head_title = FALSE, $echo = TRUE) {
		$this->request()->title($head_title, $echo);
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->render_shortcode()
	*/
	public function do_shortcode ($text) {
		return $this->render_shortcode($text);
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->directory()->top()->render()
	*/
	public function archive_page_top () {
		 $this->directory()->top()->render();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->directory()->bottom()->render()
	*/
	public function archive_page_bottom () {
		$this->directory()->bottom()->render();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->directory()->navigation()->render()
	*/
	public function archive_navigation () {
		$this->directory()->navigation()->render();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->request()->is_search();
	*/
	public function is_search () {
		return $this->request()->is_search();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->request()->is_home_page();
	*/
	public function is_front_page () {
		return $this->request()->is_home_page();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->request()->is_post_directory();
	*/
	public function is_home () {
		return $this->request()->is_post_directory();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->request()->is_single_post();
	*/
	public function is_single_post () {
		return $this->request()->is_single_post();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->request()->is_archive();
	*/
	public function is_archive () {
		return $this->request()->is_archive();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->request()->is_directory();
	*/
	public function is_directory () {
		return $this->request()->is_directory();
	}

	/* Depreciated - 2.1.1.0 
		Use $tmf->request()->is_taxonomy();
	*/
	public function is_taxonomy () {
		return $this->request()->is_taxonomy();
	}

}

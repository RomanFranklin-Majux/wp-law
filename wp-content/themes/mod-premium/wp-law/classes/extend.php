<?php defined('FRAMEWORK_VERSION') or die('No direct access.');

	class TMF_Extend {

		public static function before () {}

		public static function after () {
			//Custom Post Types
            TMF_Class::factory('post-types/showcase-faq')->load();
            new TMF_PostType_ShowcaseFaq;
            TMF_Class::factory('post-types/common-question')->load();
            new TMF_PostType_CommonQuestion;
            TMF_Class::factory('post-types/practice-area-faq')->load();
            new TMF_PostType_PracticeAreaFaq;

            //Custom Modern Slider
            TMF_ModernSlider::register_area('sidebar-badges', 'Sidebar Badges');

			//Metabox
			TMF_Class::factory('metaboxes/home-image')->load();
			new TMF_Metabox_HomeImage('attorney', 'side'); 
			TMF_Class::factory('metaboxes/attorney-signature')->load();
			new TMF_Metabox_AttorneySignature('attorney', 'side'); 
			TMF_Class::factory('metaboxes/attorney-section-info')->load();
			new TMF_Metabox_AttorneySectionInfo('attorney');
			TMF_Class::factory('metaboxes/banner-image')->load();
			new TMF_Metabox_BannerImage(array('page','practice-area'), 'side'); 
			TMF_Class::factory('metaboxes/practice-areas-blog')->load();
			new TMF_Metabox_PracticeAreasBlog('practice-area');  
			TMF_Class::factory('metaboxes/video-information')->load();
			new TMF_Metabox_VideoInformation('showcase-faq'); 
                    
            TMF_Module::register_area('header-sticky-1', 'Header Sticky 1');
            TMF_Module::register_area('header-sticky-2', 'Header Sticky 2');
            TMF_Module::register_area('home-contact-1', 'Home Contact 1');
            TMF_Module::register_area('home-contact-2', 'Home Contact 2');
            TMF_Module::register_area('home-contact-3', 'Home Contact 3');
            TMF_Module::register_area('we-can-help-1', 'We Can Help 1');
            TMF_Module::register_area('we-can-help-2', 'We Can Help 2');
            TMF_Module::register_area('we-can-help-3', 'We Can Help 3');
            TMF_Module::register_area('proven-results', 'Proven Results');
            TMF_Module::register_area('what-we-do-1', 'What We Do 1');
            TMF_Module::register_area('what-we-do-2', 'What We Do 2');
            TMF_Module::register_area('common-questions', 'Common Questions');
            TMF_Module::register_area('attorneys-section', 'Attorneys Section');
            //TMF_Module::register_area('showcase-faq-section', 'Showcase FAQ\'s Section');
            TMF_Module::register_area('featured-and-recognized', 'Featured and Recognized');
            TMF_Module::register_area('testimonial-section', 'Testimonial Section');
            TMF_Module::register_area('int-section-1', 'Interior Page Section 1');
            TMF_Module::register_area('int-section-2', 'Interior Page Section 2');
            TMF_Module::register_area('int-section-3-left', 'Interior Page Section 3 Left');
            TMF_Module::register_area('int-section-3-right', 'Interior Page Section 3 Right');
            TMF_Module::register_area('tmf-popup-form', 'Pop Up Form');
            TMF_Module::register_area('mobile-nav-info', 'Mobile Nav information');

            //New Sidebar Register
            TMF_Module::register_area('blog-sidebar-mobile', 'Blog Sidebar Mobile', FALSE);
                        
			//TMF_Module::unregister_area("footer-3");
                    
			// Load fonts
			TMF_Style::add('google-font-lato', 'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap', NULL, NULL, 'screen');
			TMF_Style::add('google-font-ubuntu', 'https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap', NULL, NULL, 'screen');

			// Load framework stylesheets 
			TMF_Style::add('tmf-scaffolding', FRAMEWORK_URI . CSS_PATH . 'scaffolding.css', NULL, NULL, 'screen');
			TMF_Style::add('tmf-framework', FRAMEWORK_URI . CSS_PATH . 'framework.css', array('tmf-scaffolding'), NULL, 'screen');
			TMF_Style::add('tmf-posts', FRAMEWORK_URI . CSS_PATH . 'posts.css', array('tmf-framework'), '1.0.01', 'screen');
			
			// Load theme stylesheets
			TMF_Style::add('tmf-structural', THEME_URI . CSS_PATH . 'structural.css', array('tmf-framework'), '1.0.03', 'screen');
			TMF_Style::add('tmf-structural-mobile', THEME_URI . CSS_PATH . 'structural-mobile.css', array('tmf-framework'), '1.0.01', 'screen');
			TMF_Style::add('tmf-child-posts', THEME_URI . CSS_PATH . 'posts.css', array('tmf-structural'), '1.0.02', 'screen');
			TMF_Style::add('tmf-editor-content', THEME_URI . CSS_PATH . 'editor-content.css', array('tmf-structural', 'tmf-child-posts'), NULL, 'screen');
            TMF_Style::add('meanmenu', THEME_URI . CSS_PATH . 'meanmenu.css', array('tmf-framework'), NULL, 'screen');
            TMF_Style::add('jquery.bxslider', THEME_URI . CSS_PATH . 'jquery.bxslider.css', array('tmf-framework'), NULL, 'screen');
            TMF_Style::add('smk-accordion', THEME_URI . CSS_PATH . 'smk-accordion.css', array('tmf-framework'), NULL, 'screen');
			
			// Load javascripts
			TMF_Script::add('jquery');
			TMF_Script::add('tmf-core', FRAMEWORK_URI . JS_PATH . 'core.js', array('jquery'));
            TMF_Script::add('jquery.meanmenu', THEME_URI . JS_PATH . 'jquery.meanmenu.js', array('tmf-core'), '1.0.01');
            TMF_Script::add('bx-slider', THEME_URI . JS_PATH . 'jquery.bxslider.min.js', array('tmf-core'));
            TMF_Script::add('easyResponsiveTabs', THEME_URI . JS_PATH . 'easyResponsiveTabs.js', array('tmf-core'));
			TMF_Script::add('tmf-smk-accordion', THEME_URI . JS_PATH . 'smk-accordion.js', array('tmf-core'));
            TMF_Script::add('tmf-script', THEME_URI . JS_PATH . 'script.js', array('tmf-core'));

            add_shortcode('blog-archives', array('TMF_Extend', 'archive') );
		}

		public function archive($atts){
			extract($settings = shortcode_atts(array(  
				'type'					=> 'monthly',
				'limit'					=> '12',
				'template'				=> ''
			), $atts)); 

			$template 		= $template ? '-' . $template : '';

			return TMF_Block::factory('miscellaneous/blog-archives' . $template)
						->set('settings', $settings)
						->render(FALSE);

		}

	}

	// ADDS A SPAN TAG AFTER THE GRAVITY FORMS BUTTON
	// aria-hidden is added for accessibility (hides the icon from screen readers)
	add_filter( 'gform_submit_button', 'dw_add_span_tags', 10, 2 );
	function dw_add_span_tags ( $button, $form ) {

	return $button .= '<span class="cursor-icon"></span>';

	}

?>
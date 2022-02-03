(function ($) {
    "use strict";

    jQuery(document).ready(function ($) {

        //Desktop Mobile Menu
    	$('.desktop-mobile-menu').meanmenu({
    		//meanMenuContainer:'.desktop-mobile-menu-container',
    		meanMenuClose: '<div class="hamburger-close-wrap"><div class="hamburger-icon"><span></span><span></span><span></span></div><div class="menu-label">MENU</div></div>',
    		meanMenuCloseSize: "20px",
    		meanMenuOpen: '<div class="hamburger-open-wrap"><div class="hamburger-icon"><span></span><span></span><span></span></div><div class="menu-label">MENU</div></div>',
    		meanRevealPosition: "center",
			meanScreenWidth: "6000",
    	});
    	
        // Sticky bar JS
    	var tmf_sticky_nav = function() {
		var y = $(window).scrollTop();
		var width = $(document).width();
		var height = 250;

    		//if (y > height & width >= 1150) {
    		if (y > height) {
    			$('#header-sticky-wrapper').addClass('sticky');
    			$('body:not(.home)').css("padding-top", 0);
    			setTimeout(function(){
    				$('#header-sticky-wrapper.sticky').addClass('sticky_animate');
    			}, 100);
    		} else {
    			$('body:not(.home)').css("padding-top", 0);
    			$('#header-sticky-wrapper').removeClass('sticky');
    			setTimeout(function(){
    				$('#header-sticky-wrapper').removeClass('sticky_animate');
    			}, 100);
    		}
        };

    	$(document).scroll(tmf_sticky_nav);
    	$(window).resize(tmf_sticky_nav);

        //Testimonial Slider
        $('.testimonial-slider .tmf-post-list').bxSlider({
            mode: 'horizontal',
            auto: true,
            autoHover: true,
            pause: 10000,
            speed: 200,
            pager: true,
            controls: false,
            touchEnabled: false
        });

        //Home Attorney Slider
        // $('.home .tmf-module-area-attorneys-section .tmf-post-list').bxSlider({
        //     mode: 'fade',
        //     auto: true,
        //     autoHover: true,        
        //     pause: 6000,
        //     speed: 200,
        //     pager: false,
        //     touchEnabled: false
        // });

        //Attorney Slider
        $('.tmf-module-area-attorneys-section .tmf-post-list').bxSlider({
            mode: 'fade',
            auto: false,
            autoHover: true,        
            pause: 6000,
            speed: 200,
            pager: false,
            touchEnabled: false
        });

        //Representative Case Slider
        $('.proven-results-slider .tmf-post-list').bxSlider({
            mode: 'horizontal',
            auto: true,
            autoHover: true,        
            pause: 6000,
            speed: 200,
            pager: false,
            touchEnabled: false
        });

        //Int Blog Slider
        $('.tmf-post-list.small-slider').bxSlider({
            mode: 'fade',
            auto: true,
            autoHover: true,        
            pause: 6000,
            speed: 200,
            pager: false,
            touchEnabled: false
        });
        
        //Blog Archive Slider
        $('.tmf-post-list.medium-slider').bxSlider({
            mode: 'fade',
            auto: true,
            autoHover: true,        
            pause: 6000,
            speed: 200,
            pager: false,
            touchEnabled: false
        });
        
        //Featured Logo Slider
        $('.featured-slider').bxSlider({
            minSlides: 1,
            maxSlides: 6,
            slideWidth: 220,
            slideMargin: 20,
            ticker: true,
            tickerHover: true,
            speed: 50000
        });

        //Easy Tab For Showcase Faq
        $('#show-case-faqs-tab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: false, // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activetab_bg: false,
            inactive_bg: false,
            active_border_color: false,
            active_content_border_color: false,
        });

      	//Accordion Faqs
        //$(".practice-area-related-faqs .tmf-post-list.related").smk_Accordion({
        $(".tmf-post-list.related").smk_Accordion({
            showIcon: true, //boolean
            animation: true, //boolean
            closeAble: true, //boolean
            slideSpeed: 350 //integer, miliseconds
        });

        //Accordion Showcase Section Faqs
        $(".showcase-faq-section-accordion").smk_Accordion({
            showIcon: true, //boolean
            animation: true, //boolean
            closeAble: true, //boolean
            slideSpeed: 350 //integer, miliseconds
        });

        //Accordion Attorney Question and Answer
        $(".attorney-qa-accordion").smk_Accordion({
            showIcon: true, //boolean
            animation: true, //boolean
            closeAble: true, //boolean
            slideSpeed: 350 //integer, miliseconds
        });

        //Accordion Practice Areas Faqs
        $(".practice-areas-faqs-accordion").smk_Accordion({
            showIcon: true, //boolean
            animation: true, //boolean
            closeAble: true, //boolean
            slideSpeed: 350 //integer, miliseconds
        });

        //Common Questions Accordion
        $("#common-questions .tmf-post-list.small").smk_Accordion({
            showIcon: true, //boolean
            animation: true, //boolean
            closeAble: true, //boolean
            slideSpeed: 350 //integer, miliseconds
        });

        //$('.tmf-post.practice-area.home.first-post').addClass('acc_active');

        //Popup Form
        $('a[href="#tmf-popup-form"]').on('click', function (event) {
            $('#tmf-popup-form').addClass('open');
            $('#tmf-popup-form > form').focus();
        });

        $('#tmf-popup-form, #tmf-popup-form .close').on('click keyup', function (event) {
            if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                $(this).removeClass('open');
            }
        });

        $("a[href^='#']").on('click', function(e){
          e.preventDefault();
          var elem = $($(this).attr('href'));
        });
        

    });

}(jQuery));

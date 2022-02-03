var TMF = null;

(function( $ ) {
	TMF = TMF || {

		start_services: function(services){
			$.each(services, function(i, s){
				TMF[s].start();
			});
		},

		namespace: function(a, data) {
			var	o  = this,
					ns = "TMF",
					d  = a.split("."),
					i;

			for (i = (d[0] == ns) ? 1 : 0; i < d.length; i = i+1) {
				var prev = o;
				o[d[i]] = o[d[i]] || {};

				if (d.length == i + 1){
					data.parent		= prev;
					data.root		= this;
					data.namespace = a.split(".");
					data.namespace.unshift(ns);
					o[d[i]] = data;
				} else {
					o[d[i]].parent = prev;
					o = o[d[i]];
				}
			}

			return o;
		}

	};

	/**
	* Feature Detection
	*
	* Checks for browser features and can optionally add CSS classes to the HTML DOM object
	*
	*/

	TMF.namespace('feature_detection', {

		start: function() {
			this.add_classes_to_html();
		},

		add_classes_to_html: function(){
			if (this.has_js_support())		$('html').removeClass('no-js').addClass('js');
			if (this.is_touch_device())	$('html').removeClass('no-touch').addClass('touch');
		},

		is_touch_device: function(){
			return !!('ontouchstart' in window);
		},

		has_js_support: function() {
			return true;
		}

	});


	/**
	* Obfuscate Email
	*
	* Prevents bots from scraping email addresses from pages.
	*
	*/

	TMF.namespace('obfuscate_email', {

		start: function() {
			this.generate_email_addresses();
		},

		generate_email_addresses: function(){
			$('.tmf-email').each(function(){
				var front = $(this).data('front');
				var back = $(this).data('back');
				var email = front + '@' + back;
				$(this).attr({href: 'mailto:' + email}).html(email);
			});
		}

	});


	/**
	* Map Adjust
	*
	* Auto resizes maps to adjust for responsive sizes
	*
	*/

	TMF.namespace('map_adjust', {

		start: function() {

			this.calculate_adjustment();
			this.listen();
		},

		calculate_adjustment: function(){
			$('.map.static img').each(function(){
				var	url			= $(this).attr('data-url'),
						con_width	= $(this).parents('div:eq(0)').width(),
						con_height	= $(this).parents('div:eq(0)').height(),
						org_width	= parseInt($(this).attr('data-width'), 10),
						org_height	= parseInt($(this).attr('data-height'), 10),
						new_width	= (con_width > org_width) ? org_width : con_width,
						new_height	= Math.round((new_width / org_width) * org_height);

				$(this).attr('src', url + new_width + 'x' + new_height);
			});
		},

		listen: function(){
			var obj = this, checker;
			$(window).resize(function(){
				clearTimeout(checker);
				checker = setTimeout(function(){obj.calculate_adjustment();}, 500);
			});
		}

	});


	/**
	* Accordion
	*
	* Provides a folding accordion element. Only allows one child element to be unfolded at a time.
	*
	* Directions:
	* Container element needs a CSS class of 'accordion'.
	* Each child element needs two elements: a 'control' and 'content' class, respectively.
	*
	*/
	TMF.namespace('accordion', {

		start: function(){
			this.listen();
		},

		listen: function(){
			var obj = this;
			$('.accordion .control').on('click', function(){ obj.on_click(this); });
		},

		on_click: function(ele){
			var parent =  $(ele).parent();
			if (this.check_if_already_open(parent)){
				this.close(parent);
			} else {
				this.open(parent);
				this.close_siblings(parent);
			}
		},

		check_if_already_open: function(ele){
			return ele.hasClass('open');
		},

		close_siblings: function(ele) {
			var obj = this;

			ele.siblings().each(
				function(){
					obj.close($(this));
				}
			);
		},

		open: function(ele){
			ele.children('.content').slideToggle(250);
			ele.addClass('open');
		},

		close: function(ele){
			ele.removeClass('open');
			ele.children('.content').slideToggle(250);
		}

	});


	/**
	* Video Light Box
	*
	* Provides a light box to display videos in
	*
	* Directions:
	* Add a css class of 'video-light-box' and an attributed named 'data-video-url' to any element
	* to trigger a light box on click. You can optionally add a 'data-video-id' attribute to add a CSS class
	* to target a specific video for styling.
	*
	*/
	TMF.namespace('video_support', {

		settings: {
			fade_in_speed: 300,
			fade_out_speed: 300
		},

		start: function(){
			this.listen();
			this.make_videos_responsive();
		},

		listen: function(){
			var obj = this;
			$('body').on('click', '.video-light-box', function(){ obj.open_light_box(this); });
			$('body').on('click', '#video-light-box', function(){ obj.close_light_box(); });
		},

		make_videos_responsive: function () {
			$('.tmf-video [data-responsive-padding]').each(function(){
				var padding = $(this).attr('data-responsive-padding');
				$(this).css('paddingBottom', padding);
			});
		},

		build_light_box: function(video_url, video_id, ratio) {

			video_id = (video_id) ? 'video-id-' + video_id : '';
			var html = '<div id="video-light-box" style="display: none;" class="' + video_id + '">' +
						'<div class="outer-wrap">' +
						'<div class="wrap">' +
							'<span class="close-button"></span>' +
							'<div class="tmf-video vimeo"><div style="padding-bottom:' + ratio +'%;"><iframe src="'+ video_url +'" frameborder="0" allowfullscreen></iframe></div></div>' +
						'</div></div></div>';

			return html;
		},

		open_light_box: function(ele) {
			var video_url		= $(ele).attr('data-video-url'),
				video_id		= $(ele).attr('data-video-id'),
				video_ratio		= $(ele).attr('data-video-ratio'),
				light_box		= this.build_light_box(video_url, video_id, video_ratio);

			$('body').append(light_box);
			$('#video-light-box').fadeIn(this.settings.fade_in_speed);
		},

		close_light_box: function() {
			$('#video-light-box').fadeOut(this.settings.fade_out_speed, function(){
				$(this).remove();
			});
		}

	});


	/**
	* Navigation
	*
	* Provides support for navigation menu
	*
	* Dependencies: Feature Detection
	*
	*/
	TMF.namespace('navigation', {

		settings: {
			mobile_width: null
		},

		start: function(){
			this.check_for_mobile();
			this.listen();
			this.convert_to_nonbreaking();
		},

		listen: function(){
			var obj = this;
			
			$('#primary-nav .menu-bar').on('click', this.slide_down, this.slide_up);

			if (this.root.feature_detection.is_touch_device()){
				$('#primary-nav .menu').on('touchstart','a', function(e){ obj.open_submenu(e, this); });
				$(document).on('touchstart', this.close_submenu);
			}

			$(window).resize(function(){ obj.check_for_mobile(); });
		},

		slide_down: function(){
			$('#primary-nav .menu').slideToggle(400);
			$('#primary-nav').addClass('open');
			$('html, body').animate({ scrollTop: $('#primary-nav').offset().top }, 400);
		},

		slide_up: function(){
			$('#primary-nav .menu').slideToggle(400);
			$('#primary-nav').removeClass('open');
		},

		check_for_mobile: function(){
			var	nav					= $('#primary-nav .menu'),
					container			= nav.parent(),
					nav_width			= Math.floor(nav.outerWidth(true)),
					container_width	= container.innerWidth();

			if ($('html').hasClass('mobile-nav'))
				nav_width = nav_width - parseInt(container.css('margin-left').replace('px', ''),10) - parseInt(container.css('margin-right').replace('px', ''),10);

			if (nav_width  > container_width) {
				if (!this.settings.mobile_width)
					this.settings.mobile_width = nav_width;

				$('html').addClass('mobile-nav');
			}

			else if (container_width > this.settings.mobile_width) {
				nav.removeAttr('style');
				$('html').removeClass('mobile-nav');
			}
		},

		open_submenu: function(e, object){
			e.stopPropagation();

			var parent = $(object).parent('.menu-item'),
				submenu = parent.children('.wrap').children('.sub-menu');

			// if it has a submenu, is currently hidden...
			if (submenu.length == 1 && submenu.is(":hidden")){
				// If nav is in mobile mode...
				if ($('html').hasClass('mobile-nav')){

					e.preventDefault();
					$('.sub-menu').not(submenu).not(parent.parent('.sub-menu')).removeClass('display');
					submenu.addClass('display');
					$('html, body').animate({ scrollTop: submenu.parents('li').offset().top }, 400);
				// if nav is in full mode.
				}else{
					e.preventDefault();
					$('.sub-menu').not(submenu).not(parent.parent('.sub-menu')).removeClass('display');
					submenu.addClass('display');
					parent.addClass('hover');
				}
			}
		},

		close_submenu: function(){
			$('.sub-menu').removeClass('display');
			if (!$('html').hasClass('mobile-nav')){
				$('.menu-item').removeClass('hover');
			}
		},
		
		convert_to_nonbreaking: function(){
			$('#primary-nav .menu > li > a').each(function(){
				var text = $(this).text(),
				replacement = '&nbsp;',
				split = text.split(' ');

				// if more than three spaces in string
				if (split.length >= 3){

					// check the length of each half
					var first_half = split.slice(0,-1).join('').length;
					var last_half = split.slice(-1).join().length;

					// create slices
					var first = split.slice(0,-1).join('&nbsp;');
					var last = split.slice(-1);

					// If first half is longer than second half, move space up
					if (first_half >= last_half){

						// check the length of each half
						first_half = split.slice(0,-2).join('').length;
						last_half = split.slice(-2).join().length;

						first = split.slice(0, -2).join('&nbsp;');
						last = split.slice(-2).join('&nbsp;');
					}

					// If first half is longer than second half, move space up
					if (first_half >= last_half && split.length > 3){

						// check the length of each half
						first_half = split.slice(0,-3).join('').length;
						last_half = split.slice(-3).join().length;

						first = split.slice(0, -3).join('&nbsp;');
						last = split.slice(-3).join('&nbsp;');
					}

					$(this).html(first + ' ' + last);
				}
			});
		}

	});

})( jQuery );
/*
jQuery(document).ready(function(){
    jQuery(".hideme").click(function(){
        jQuery("#mobile-call-wrapper").slideToggle('slow', function() {
    		jQuery('.hideme').toggleClass('shown', jQuery(this).is(':visible'));
  		});
    });
});


jQuery(document).ready(function(){x
    jQuery(".hideme").click(function(){
        jQuery("#mobile-call-buttons").hide();
    });
}); */

jQuery(document).ready(function(){
    jQuery(".hideme-container").click(function(){
    	var link = jQuery('.hideme');
    	if(jQuery("#mobile-call-container").hasClass('animate')){
    		link.html('<i class="material-icons">close</i>Close'); 
    		jQuery("#mobile-call-container").removeClass('animate');	
    	}else{
    		link.html('<i class="material-icons">menu</i>Open'); 
    		jQuery("#mobile-call-container").addClass('animate');
    	}   
    });
});
/*
jQuery(document).ready(function($) {
	// Replace source
    // this is to show image is missing text for missing images added via html

    function checkImg(img) {
        if (img.naturalHeight <= 1 && img.naturalWidth <= 1) {
            // undersize image here
            img.src = "https://via.placeholder.com/150X150?text=Image+is+missing.";
        }
    }

    $("img").each(function() {
        // if image already loaded, we can check it's height now
        if (this.complete) {
            checkImg(this);
        } else {
            // if not loaded yet, then set load and error handlers
            $(this).load(function() {
                checkImg(this);
            }).error(function() {
                // img did not load correctly
                // set new .src here
                this.src = "https://via.placeholder.com/150X150?text=Image+is+missing.";
            });

        }
    });
});*/

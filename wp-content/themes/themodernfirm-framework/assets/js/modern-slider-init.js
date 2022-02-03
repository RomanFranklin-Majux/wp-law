// Can also be used with $(document).ready()
jQuery(document).ready(function($) {

	if (typeof TMF_ModerSlider !== 'undefined') {
		if( TMF_ModerSlider == null ){
			$('.modern-slider').flexslider();
		}else{
			// We have our settings
			$('.modern-slider').flexslider({
			    animation: TMF_ModerSlider.animation,
			    slideshowSpeed : TMF_ModerSlider.slideshowSpeed,
			    animationSpeed: TMF_ModerSlider.animationSpeed,
			    direction: TMF_ModerSlider.direction,
			    directionNav: (TMF_ModerSlider.directionNav == 'true') ? true : false,
			    controlNav: (TMF_ModerSlider.controlNav == 'true') ? true : false,
			    easing: 'linear',
			});
		}
	}
});
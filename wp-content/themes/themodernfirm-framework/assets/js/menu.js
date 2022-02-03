jQuery(document).ready(function($){

	jQuery( '.mobile-menu .sub-menu' ).each( function(){	  
	  jQuery( this ).parent().before('<div class="mob-expand-submenu"></div>');
	});

	jQuery( document ).on( 'click',  '#mobile-nav .menu-bar, .mobile-menu-back-drop, .mob-cancel-button' , function ( e ) {

		// Parent Link open submenu(1st Level).
		if ( jQuery(this).parents().hasClass( 'mobile-menu-parent-link' ) || jQuery(this).parent().parent().parent().parent().parent().hasClass( 'mobile-menu-parent-link' ) ) {

			if( jQuery(this).parent().find( '.mob-expand-submenu' ).length > 0 )  {
			  jQuery(this).parent().find( '.mob-expand-submenu' ).first().trigger( 'click' );
			  return false;
			}
		}

		jQuery('body').toggleClass('show-nav-left'); 

		if ( !jQuery( 'body' ).hasClass( 'show-nav-left') ){  
			jQuery( 'html' ).removeClass( 'hidden-overflow' );
		} else {
			jQuery( 'html' ).addClass( 'hidden-overflow' );
			e.preventDefault();
	  }

	});

	// Toggle Submenu if sub-menu opening icon is clicked
	var toggleSubmenusOnIconClick = function(item, e) {
		e.stopPropagation();
		console.log(item);

		// Close all open submenus
		jQuery('#mobile-nav .display').not(jQuery(item).parents('li')).removeClass('display');
		jQuery('#mobile-nav .show-sub-menu').not(jQuery(item).next()).removeClass('show-sub-menu');
		  
		if ( jQuery( item ).next().hasClass( 'show-sub-menu' )  ) {
			jQuery(item).find('.show-sub-menu' ).hide();
		}
		if ( ! jQuery( item ).parents('.show-sub-menu').prev().hasClass('mob-expand-submenu') && jQuery( item ).next()[0] !== jQuery('.show-sub-menu')[0] && jQuery( item ).parent('.sub-menu').length <= 0 ) {
			jQuery(item).find( '.show-submenu' ).hide().toggleClass( 'show-sub-menu' );
		}

		if ( !jQuery( item ).next().hasClass( 'show-sub-menu' ) ) {
			jQuery(item).parent().addClass('display');
		} else {  
			jQuery(item).parent().removeClass('display');
		}

		jQuery(item).next().toggleClass( 'show-sub-menu');
	}

	// Toggle Submenu if menu item is clicked
	var toggleSubmenusOnMenuItemClick = function(item, e) {
		e.stopPropagation();

		// Close all open submenus
		jQuery('#mobile-nav .display').not(jQuery(item)).removeClass('display');
		jQuery('#mobile-nav .show-sub-menu').not(jQuery(item).find('.show-sub-menu')).removeClass('show-sub-menu');
		  
		/*if ( jQuery( item ).find('.wrap').hasClass( 'show-sub-menu' )  ) {
			jQuery(item).find('.show-sub-menu' ).hide();
		}*/
		/*if ( ! jQuery( item ).parents('.show-sub-menu').prev().hasClass('mob-expand-submenu') && jQuery( item ).next()[0] !== jQuery('.show-sub-menu')[0] && jQuery( item ).parent('.sub-menu').length <= 0 ) {
			jQuery(item).find( '.show-submenu' ).hide().toggleClass( 'show-sub-menu' );
		}*/

		if ( !jQuery( item ).find('.wrap').hasClass( 'show-sub-menu' ) ) {
			jQuery(item).addClass('display');
		} else {  
			jQuery(item).removeClass('display');
		}

		jQuery(item).find('.wrap').toggleClass( 'show-sub-menu');
	}

	// Clicking on a sub-menu opening icon or anywhere on the menu item
	jQuery( document ).on( 'click', '#mobile-nav .menu > li, .mob-expand-submenu' , function ( e ) {

		if(jQuery(this).attr('class') == 'mob-expand-submenu') {
			// Toggle submenu on icon click
			toggleSubmenusOnIconClick(this, e);
		} else {

			// If isn't hot linked anchor, open the submenu
			if(jQuery(this).find('> a').attr("href") == '#' && 'A' == e.target.nodeName) {
				toggleSubmenusOnMenuItemClick(this, e);
			} else if('LI' == e.target.nodeName) {
				toggleSubmenusOnMenuItemClick(this, e);
			}	
		}
	  
	});


});
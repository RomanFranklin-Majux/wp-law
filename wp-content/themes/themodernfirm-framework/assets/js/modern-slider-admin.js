/*** Wrapper module for js store ***/
var tmf_local_storage = (function () {
    return {
        get: function (key) {
            if(store!=undefined){
                return store.get(key);
            }
            return false;
        },
        set: function (key, value) {
            if(store!=undefined){
                store.set(key, value);
            }
        },
        remove: function (key) {
            if(store!=undefined){
                store.remove(key);
            }
        },
        clear: function () {
            if(store!=undefined){
                store.clear(); /*** Clear all keys ***/
            }
        }
    };
})();

/*** Class for handling open and close expandable and slide elements. Use together with tmf_local_storage ***/
function TMFUiOpen(data){
    if(!data){
        data = {};
    }
    this.expandables = data;/*** data format should be object[slideshowId][element_index] ***/
}
TMFUiOpen.prototype.get = function(slideshow, key){
    if(this.expandables[slideshow]!=undefined){
        if(this.expandables[slideshow][key]!=undefined){
            return this.expandables[slideshow][key];
        }
    }
    return false;
}
TMFUiOpen.prototype.set = function(slideshow, key, value){
    if(typeof(this.expandables[slideshow])!=='object'){
        this.expandables[slideshow] = {};
    }
    
    this.expandables[slideshow][key] = value;
}
TMFUiOpen.prototype.remove = function(slideshow, key){
    if(this.expandables[slideshow]!=undefined){
        if(this.expandables[slideshow][key]!=undefined){
            delete this.expandables[slideshow][key];
        }
    }
}
TMFUiOpen.prototype.getAll = function(){
    return this.expandables;
}
TMFUiOpen.prototype.clear = function(){
    this.expandables = {};
}

function initTinyMce(id) {
    // Initialize tinymce with WP like settings
    tinymce.init({
        selector: '#'+id,
        theme: 'modern',
        skin: 'lightgray',
        wpautop:true,
        tinymce: true,
        quicktags: {
            buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,more,close"
        },
        menubar: false,
        toolbar1:"formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_more,spellchecker,fullscreen,wp_adv",
        toolbar2:"styleselect,strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
        toolbar3:"",
        toolbar4:"",
        //mode:		'text', // visual,text
        //field:		true,
        field: this,
        branding: false,
        plugins: "charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview"
    });

    // For some reason tab switching doesn't seem to work
    // Manually switch tabs
    jQuery("#"+ id +"-tmce").click(function(){
        jQuery(this).parents(".wp-editor-wrap").removeClass("html-active").addClass("tmce-active");
    });

    jQuery("#"+ id +"-html").click(function(){
        jQuery(this).parents(".wp-editor-wrap").removeClass("tmce-active").addClass("html-active");
    });

    // Render quick tags for text tab

    // Code from acf-input.js
    // Get the quick tags object for current editor
    let ed = quicktags(id);

    // Variable for text tab
    let theButtons = {};
    let settings = ed.settings;
    let instanceId = ed.id;
    let name = ed.name;
    let html = '';
    let use = '';

    // Set buttons
    if ( settings && settings.buttons ) {
        use = ','+settings.buttons+',';
    }

    for ( i in edButtons ) {
        if ( ! edButtons[i] ) {
            continue;
        }

        id = edButtons[i].id;

        if ( ! edButtons[i].instance || edButtons[i].instance === instanceId ) {
            theButtons[id] = edButtons[i];

            if ( edButtons[i].html ) {
                html += edButtons[i].html( name + '_' );
            }
        }
    }

    if ( use && use.indexOf(',dfw,') !== -1 ) {
        theButtons.dfw = new QTags.DFWButton();
        html += theButtons.dfw.html( name + '_' );

        ed.toolbar.innerHTML = html;
        ed.theButtons = theButtons;

        if ( typeof jQuery !== 'undefined' ) {
            jQuery( document ).triggerHandler( 'quicktags-init', [ ed ] );
        }
    }
}


jQuery(document).ready(function($){
    /*** Export ***/
    (function() {
        $('#tmf-select-all').click(function(){
            if( $(this).is(':checked') ) {
                $('.tmf-sliders').prop('checked', true);
            } else {
                $('.tmf-sliders').prop('checked', false);
            }
            
        });
    })();
    /*** SLIDE BOXES ***/
    (function() {
        var $slidesMetabox = $('#tmf-modern-slides'),
            $sortables = $('#tmf-sortables'),
            slideshowId = $sortables.data('post-id'), 
            tmf_ui_open;
        
        tmf_ui_open = new TMFUiOpen(tmf_local_storage.get('tmf_slide_toggles'));/*** Handle persistent slide data ***/
        
        /*** Init - Sortable slides ***/
        $sortables.sortable({
            handle:'.tmf-header',
            placeholder: "tmf-slide-placeholder",
            forcePlaceholderSize:true,
            disabled: false,
            /*** Update form field indexes when slide order changes ***/
            update: function(event, ui) {
                $sortables.find('.tmf-slide').each(function(boxIndex, box){ /*** Loop thru each box ***/
                    $(box).find('input, select, textarea').each(function(i, field){ /*** Loop thru relevant form fields ***/
                        var name = $(field).attr('name');
                        if(name){
                            name = name.replace(/\[[0-9]+\]/, '['+boxIndex+']'); /*** Replace all [index] in field_key[index][name] ***/
                            $(field).attr('name',name);
                        }
                    });
                    $(box).find('.tmf-changeling-id').each(function(i, field){ /*** Loop thru relevant fields ***/
                        var name = $(field).attr('id');
                        if(name){
                            name = name.replace(/[0-9]+/, boxIndex); /*** Replace all ad_asdasd-x ***/
                            $(field).attr('id',name);
                        }
                        var name = $(field).attr('for');
                        if(name){
                            name = name.replace(/[0-9]+/, boxIndex); /*** Replace all ad_asdasd-x ***/
                            $(field).attr('for',name);
                        }
                    });
                });
            },
            create: function(event, ui) {
                $sortables.find('.tmf-slide').each(function(boxIndex, box) {
                    initTinyMce('slide_editor_'+boxIndex);
                });
            }
        });
        $('#tmf-sort').on('click', function(){
            var $sort = $(this),
                isDisabled = $( "#tmf-sortables" ).sortable( "option", "disabled" );

            $sort.toggleClass('active');
            if(isDisabled){
                $('#tmf-sortables').sortable('enable').addClass('active');
            } else {
                $('#tmf-sortables').sortable('disable').removeClass('active');
            }
        });
        /*** Init - Slide ID and title ***/
        $sortables.find('.tmf-slide').each(function(i){
            var $slide = $(this),
                $body = $slide.find('.tmf-body');

            $slide.data('tmf_id', i);
            
            if(tmf_ui_open.get(slideshowId ,i)=='open'){
                $slide.find('.tmf-minimize').addClass('open');
                $body.slideDown(0);
            } else {
                $body.slideUp(0);
            }
        });
        
        /*** Add - Slide box from a hidden html template ***/
        $slidesMetabox.on('click', '#tmf-add-slide', function(e){
            var id = $sortables.find('.tmf-slide').length;
            var html = $('#tmf-slide-skeleton').html();
            html = html.replace(/{id}/g, id);/*** replace all occurences of {id} to real id ***/
            html = html.replace(/iid/g, id);/*** replace all occurences of {id} to real id ***/
            
            $sortables.append(html);
            $sortables.find('.tmf-slide:last').find('.tmf-thumbnail').hide().end().find('.tmf-body').show();

            // Keep sortables expanded
            $sortables.find('.tmf-slide:last').find('.expandable-box:first-child').find('.expandable-body').show();

            $sortables.find('.tmf-slide').each(function(i){
                $(this).data('tmf_id',i);
            });

            $('.expandable-body').each(function(i){
                $(this).data('tmf_id',i);
            });
            
            $(".modernslider_metas_enable_slide_effects").trigger('change');
            
            e.preventDefault();
        })
        .on('wpAddImage', '.tmf-media-gallery-show', function(e, image_url, attachment_id, media_attachment){
            
            /*** Add image to slide ***/

            var $button = $(this),
                $imageField = $button.closest('.tmf-image-field'), // Current image field
                $thumb = $imageField.find('.tmf-image-thumb'), // Find the thumb
                $hiddenField = $imageField.find('.tmf-image-id '); // Find the hidden field that will hold the attachment id

            $thumb.html('<img src="'+image_url+'" alt="Thumbnail" />').show();
            $hiddenField.val(attachment_id);
 
        })
        .on('wpAddImages', '.tmf-multiple-slides', function(e, media_attachments){ 

            /*** Add multiple images as slide ***/

            var $sortables = $('#tmf-sortables'),
                slideCount = $sortables.find('.tmf-slide').length,
                i;

            for(i=0; i<media_attachments.length; ++i){
                
                $('#tmf-add-slide').trigger('click');
                
                $sortables.find('.tmf-slide').eq(slideCount+i).find('.tmf-media-gallery-show').trigger('wpAddImage', [media_attachments[i].url, media_attachments[i].id, media_attachments[i]]);
            }
            
        })
        .on('click',  '.tmf-minimize', function(e) {

            /*** Toggle - slide body visiblity ***/

            var $button = $(this),
                $box = $button.closest('.tmf-slide'),
                $body = $box.find('.tmf-body'),
                id = $box.data('tmf_id');
            
            if($body.is(':visible')){
                $button.removeClass('open');
                $body.slideUp(100);
                // Keep slides always open
                //tmf_ui_open.remove(slideshowId , id);
            } else {
                $button.addClass('open');
                $body.slideDown(100);
                tmf_ui_open.set(slideshowId , id, 'open');/*** remember open section ***/ 
            }
            
            tmf_local_storage.set('tmf_slide_toggles', tmf_ui_open.getAll());
            e.preventDefault();

        }).on('click', '.tmf-slide-type .switcher', function(e){

            /* Switcher - switch between slide types */

            var $switcher = $(this);

            $switcher.toggleClass('open');
            $('.tmf-slide-type .switcher').not($switcher).removeClass('open');
            e.stopPropagation();

        }).on('click', '.tmf-slide-type .switcher li', function(e){

            var $list = $(this),
                $box = $list.closest('.tmf-slide'),
                $switcher = $list.closest('.switcher'),
                $hidden = $list.closest('.tmf-slide-type').find('input'),
                $display = $switcher.find('.display');
            
            $display.html($list.html());
            $switcher.removeClass('open');
            $hidden.val($list.attr('data-value'));
            $box.attr('data-slide-type', $hidden.val());

            e.stopPropagation();
        })
        .on('click',  '.tmf-delete', function(e) {
            // Remove the editor when the slide is deleted
            // Otherwise tinymce doesn't work
            let parent = $(this).parents('.tmf-slide');
            let editorId = parent.find('.tmf-content-field textarea').attr("id");
            tinymce.execCommand('mceRemoveEditor', true, editorId);
            
            /*** Delete - Remove slide box ***/

            var box = $(this).parents('.tmf-slide');
            box.fadeOut('slow', function(){ box.remove()});

            e.preventDefault();
            e.stopPropagation();
        })
        .on('change', '.modernslider_metas_link_target', function(e){

            /*** Enable/Disable Link URL if lightbox is selected ***/
            
            var box, link_url;
            
            box = $(this).parents('.expandable-box');
            
            link_url = box.find('.modernslider_metas_link_url');
            
            if ($(this).val() == 'lightbox') {
                link_url.attr('disabled', 'disabled');
            } else {
                link_url.removeAttr('disabled');
            }
        })
        .find('.tmf-slide').each(function(){
            var $slide = $(this),
                slideType = $slide.attr('data-slide-type');
            $slide.find('.tmf-slide-type').find('li[data-value="'+slideType+'"]').trigger('click');
        });

        $(document).click(function(){

            /* Handle closing of dropdown on lost focus */

            $('.tmf-slide-type .switcher').removeClass('open');
        });

        $('.modernslider_metas_link_target').trigger('change');
        
    })();
    
    /*** EXPANDABLES ***/
    (function() {
        var slideshowId, tmf_ui_open;
        
        /*** Init ***/
        slideshowId = $('#tmf-modern-slides .tmf-sortables').data('post-id');
        
        tmf_ui_open = new TMFUiOpen(tmf_local_storage.get('tmf_expandables'));
        
        $('#tmf-modern-slides .expandable-body').each(function(i){
            $(this).data('tmf_id', i);
            
            if(tmf_ui_open.get(slideshowId ,i)=='open'){
                $(this).slideDown(0);
            } else {
                $(this).slideUp(0);
            }
        });
        
        /*** Toggle - Expandable toggling ***/
        $('#tmf-modern-slides').on('click', '.expandable-header', function(e){
            var body, id;
            
            body = $(this).next('.expandable-body');
            id = body.data('tmf_id');
            
            if(body.is(':visible')){
                body.slideUp(100);
                tmf_ui_open.remove(slideshowId , id);
                
            } else {
                body.slideDown(100);
                tmf_ui_open.set(slideshowId , id, 'open');
                
            }
            
            tmf_local_storage.set('tmf_expandables', tmf_ui_open.getAll());
        });
    })();
    
    /*** VIDEO SLIDE ***/
    (function() {
        var slideshowId;
        
        slideshowId = $('#tmf-modern-slides .tmf-sortables').data('post-id');
        
        /*** Get Video ***/
        $('#tmf-modern-slides').on('click', '.tmf-video-get', function(e){
            var button, box, textbox_url, url, video_thumb, video_embed;
            
            button = $(this);
            box = $(this).parents('.tmf-slide');
            video_thumb = box.find('.tmf-video-thumb');
            textbox_url = box.find('.tmf-video-url');
            url = textbox_url.val();
            if(url==''){
                return;
            }
            video_embed = box.find('.tmf-video-embed');
            video_thumb.empty().show();
            textbox_url.attr('disabled','disabled');
            button.attr('disabled','disabled');
            
            $.ajax({
                type: "POST",
                url: ajaxurl, /*** Automatically added by wordpress ***/
                data: "action=modernslider_get_video&url="+encodeURIComponent(url),
                dataType: 'json',
                success: function(data, textStatus, XMLHttpRequest){
                    if(data.success){
                        video_thumb.html('<img src="'+data.url+'" alt="thumb">');
                        box.find('.tmf-video-thumb-url').val(data.url);
                        video_embed.val(data.embed);
                        textbox_url.removeAttr('disabled');
                        button.removeAttr('disabled');
                    } else {
                        alert('Error. Make sure its a valid youtube or vimeo url.');
                        video_thumb.empty().hide();
                        textbox_url.removeAttr('disabled');
                        button.removeAttr('disabled');
                    }
                }
            });
        });
    })();

    (function() {

        /*** hide wordpress admin stuff ***/
        /*$('#minor-publishing-actions').hide();
        $('#misc-publishing-actions').hide();
        $('.inline-edit-date').prev().hide();*/
        
        /*** Post type switcher quick fix ***/
        $('#pts_post_type').html('<option value="modernslider">modernslider</option>');
        
        /*** Template Chooser ***/
        $('#modern-slider-templates-metabox').on('click', '.boxxy', function(e){
            e.preventDefault();
            e.stopPropagation();
            
            var trigger = $(this),
                content = '',
                boxy = $('#tmf-boxy'),
                width = 0,
                height = 0,
                x = 0,
                y = 0;
            
            boxy.html( trigger.data('content') );
            boxy.stop().show();
            
            /* Do calcs after element is shown to prevent zero values for hidden element */
            width = boxy.outerWidth(),
            height = boxy.outerHeight(),
            x = trigger.offset().left,
            y = trigger.offset().top,
                
            y = y - height;
            if ( $('body').hasClass('admin-bar') ) {
                y -= 32;
            }
            
            boxy.css({
                'left': x+'px',
                'top': y+'px'
            });
        }).on('change', '.tmf-templates input[type="radio"]', function(e){
            var $radio = $(this),
                $tr = $(this).closest('tr'),
                $table = $tr.closest('table');

            $table.find('tr').removeClass('active');
            $tr.addClass('active');
        });
        $(document).on('click', '#tmf-boxy', function(e){
            e.preventDefault();
            e.stopPropagation();
        })
        $(document).on('click', 'body', function(e){
            $('#tmf-boxy').fadeOut();
        })
        $(window).resize(function(e){
            $('#tmf-boxy').hide();
        })
        
        /*** show/Hide Tile Properties for slideshow ***/
        $('#modern-slider-properties-metabox').on('change', '#modernslider_settings_fx', function(){
            if($(this).val()=='tileBlind' || $(this).val()=='tileSlide'){
                $('.modernslider-field-tile-properties').slideDown('fast');
            } else {
                $('.modernslider-field-tile-properties').slideUp('fast');
            }
        });
        $("#modernslider_settings_fx").trigger('change');
        
        /*** Show/hide Tile Properties for slides ***/
        $('#tmf-modern-slides').on('change', '.modernslider_metas_fx', function(){
            var $select  = $(this),
                $field = $select.closest('.field');

            if($select.val()=='tileBlind' || $select.val()=='tileSlide'){
                $field.siblings('.modernslider-slide-tile-properties').slideDown('fast');
            } else {
                $field.siblings('.modernslider-slide-tile-properties').slideUp('fast');
            }
        });
        $(".modernslider_metas_fx").trigger('change');
        
    })();

    (function() {
        if(typeof(wp) == "undefined" || typeof(wp.media) != "function"){
            return;
        }
        // Prepare the variable that holds our custom media manager.
        var modern_media_frame;
        var triggering_element = null;
        
        // Bind to our click event in order to open up the new media experience.
        $(document.body).on('click', '.tmf-media-gallery-show', function(e){
            // Prevent the default action from occuring.
            e.preventDefault();
            
            triggering_element = jQuery(this); /* Get current clicked element */
            
            
            // If the frame already exists, re-open it.
            if ( modern_media_frame ) {
                modern_media_frame.open();
                return;
            }
    

            modern_media_frame = wp.media.frames.modern_media_frame = wp.media({
                className: 'media-frame tmf-frame',
                frame: 'select',
                multiple: false,
                title: modernslider_admin_vars.title,
                library: {
                    type: 'image'
                },
                button: {
                    text:  modernslider_admin_vars.button
                }
            });
    
            modern_media_frame.on('select', function(){
                var media_attachment, img_url;
                
                // Grab our attachment selection and construct a JSON representation of the model.
                media_attachment = modern_media_frame.state().get('selection').first().toJSON();
                
                if(undefined==media_attachment.sizes.medium){ /*** Account for smaller images where medium does not exist ***/
                    img_url = media_attachment.url;
                } else {
                    img_url = media_attachment.sizes.medium.url;
                }

                triggering_element.trigger('wpAddImage', [img_url, media_attachment.id, media_attachment]);
            });
    
            // Now that everything has been set, let's open up the frame.
            modern_media_frame.open();
        });
    })();
    
    
    (function() {
        if(typeof(wp) == "undefined" || typeof(wp.media) != "function"){
            return;
        }
        // Prepare the variable that holds our custom media manager.
        var modern_media_frame;
        var triggering_element = null;
        
        // Bind to our click event in order to open up the new media experience.
        $(document.body).on('click', '.tmf-multiple-slides', function(e){
            // Prevent the default action from occuring.
            e.preventDefault();
            
            triggering_element = jQuery(this); /* Get current clicked element */
            
            
            // If the frame already exists, re-open it.
            if ( modern_media_frame ) {
                modern_media_frame.open();
                return;
            }
    

            modern_media_frame = wp.media.frames.modern_media_frame = wp.media({
                className: 'media-frame tmf-frame',
                frame: 'select',
                multiple: true,
                title: modernslider_admin_vars.title2,
                library: {
                    type: 'image'
                },
                button: {
                    text:  modernslider_admin_vars.button2
                }
            });
    
            modern_media_frame.on('select', function(){
                var media_attachments;
                
                // Grab our attachment selection and construct a JSON representation of the model.
                media_attachments = modern_media_frame.state().get('selection').toJSON();
                
                triggering_element.trigger('wpAddImages', [media_attachments]);
            });
    
            // Now that everything has been set, let's open up the frame.
            modern_media_frame.open();
        });
    })();
});
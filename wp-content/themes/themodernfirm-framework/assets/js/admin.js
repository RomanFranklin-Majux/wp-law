jQuery(document).ready(function($) {
  $(".combobox").combobox();

  $(".combobox-tags" ).combobox_tags();

  $(".tags-container" ).sortable({
    update: function(){
      tmf_reorder_list($(this));
    }
  }).disableSelection();

  $(document).on('click', '.tags-container .delete', function(){
    var tags = $(this).parents('.tags-container');
    $(this).parent().remove();
    tmf_reorder_list(tags);
  });

  // Prevent enter key from submiting forms
  $(window).keydown(function(event){
    if(event.keyCode == 13 && event.target.nodeName!='TEXTAREA') {
      event.preventDefault();
      return false;
    }
  });


  // Image uploader
  $('#wpbody').on('click', '.uploader-button', function( event ){
    event.preventDefault();

    var button      = $(this),
        destination = $("#" + button.data('destination')),
        preview     = $('#' + button.data('preview')),
        panel_title = button.data('panel-title'),
        button_text = button.data('button-text'),
        size        = button.data('size'),
        types       = button.data('types');

    file_frame = wp.media.frames.file_frame = wp.media({
      title: panel_title,
      button: {
        text: button_text
      },
      multiple: false
    });

    file_frame.on('select', function() {
      attachment = file_frame.state().get('selection').first().toJSON();

      if (size){
        size = size.split(',');
        if (attachment.width !== Number(size[0]) && attachment.height !== Number(size[1])){
          alert('The image must have a dimension of ' + size[0] + 'px by ' + size[1] + 'px.');
          return;
        }
      }

      if (types){
        types = types.split(',');
        var subtype = attachment.filename.split('.').pop();
        if ($.inArray(subtype, types) == -1){
          alert('The file type must be one of the following formats: ' + types.join(', '));
          return;
        }
      }

      destination.val(attachment.id);
      preview.attr('src', attachment.url).show();
      button.siblings('.uploader-remove').show();
    });

    file_frame.open();
  });

  // Image Remover
  $('#wpbody').on('click', '.uploader-remove', function(event){
     $('#' + $(this).data('destination')).val('');
     $('#' + $(this).data('preview')).attr('src', '').hide();
     $(this).hide();
  });

  // Combobox Listeners
  $('.ui-combobox-input').each(function(){
    if ($(this).val() === ''){
      $(this).val($(this).parent().prev().children(":first").text());
    }
  });

  $('#wpbody').on('focus', '.ui-combobox-input', function(){
    if ($(this).parent().prev().children(":first").text() == $(this).val()){
      $(this).val('');
    }
  });

  $('#wpbody').on('focusout', '.ui-combobox-input', function(){
    if($(this).val() === ''){
      $(this).val($(this).parent().prev().children(":first").text());
    }
  });

  function tmf_reorder_list(list){
    var count = 1;
    list.find('input[type=hidden]').each(function(){
      var name = $(this).attr('name');

      $(this).parents('.tags-container').attr('data-object-name');
      name =  $(this).parents('.tags-container').attr('data-object-name') + '['+ count +']';
      count++;
      $(this).attr('name', name);
    });
  }

});


// Combobox jQuery UI extend
(function($) {
  $.widget( "ui.combobox", {
    _create: function() {
      var input,
        self = this,
        select = this.element.hide(),
        selected = select.children( ":selected" ),
        value = selected.val() ? selected.text() : "",
        wrapper = this.wrapper = $( "<span>" )
          .addClass( "ui-combobox" )
          .insertAfter( select );

      input = $( "<input>" )
        .appendTo( wrapper )
        .val( value )
        .addClass( "ui-state-default ui-combobox-input" )
        .autocomplete({
          delay: 0,
          minLength: 0,
          autoFocus: true,
          source: function( request, response ) {
            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
            response( select.children( "option" ).map(function() {
              var text = $( this ).text();
              if ( this.value && ( !request.term || matcher.test(text) ) )
                return {
                  label: text.replace(
                    new RegExp(
                      "(?![^&;]+;)(?!<[^<>]*)(" +
                      $.ui.autocomplete.escapeRegex(request.term) +
                      ")(?![^<>]*>)(?![^&;]+;)", "gi"
                    ), "<strong>$1</strong>" ),
                  value: text,
                  option: this
                };
            }) );
          },
          select: function( event, ui ) {
            ui.item.option.selected = true;
            self._trigger( "selected", event, {
              item: ui.item.option
            });
          },
          change: function( event, ui ) {
            if ( !ui.item ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
                valid = false;
              select.children( "option" ).each(function() {
                if ( $( this ).text().match( matcher ) ) {
                  this.selected = valid = true;
                  return false;
                }
              });
              if ( !valid ) {
                // remove invalid value, as it didn't match anything
                $( this ).val( "" );
                select.val( "" );
                input.data( "uiAutocomplete" ).term = "";
                $(this).val($(this).parent().prev().children(":first").text());

                return false;
              }
            }
          }
        })
        .addClass( "ui-widget ui-widget-content ui-corner-left" );

      input.data( "uiAutocomplete" )._renderItem = function( ul, item ) {
        return $( "<li></li>" )
          .data( "item.autocomplete", item )
          .append( "<a>" + item.label + "</a>" )
          .appendTo( ul );
      };

      $( "<a>" )
        .attr( "tabIndex", -1 )
        .attr( "title", "Show All Items" )
        .appendTo( wrapper )
        .button({
          icons: {
            primary: "ui-icon-triangle-1-s"
          },
          text: false
        })
        .removeClass( "ui-corner-all" )
        .addClass( "ui-corner-right ui-combobox-toggle" )
        .click(function() {
          // close if already visible
          if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
            input.autocomplete( "close" );
            return;
          }

          // work around a bug (likely same cause as #5265)
          $( this ).blur();

          // pass empty string as value to search for, displaying all results
          input.autocomplete( "search", "" );
          input.focus();
        });
    },

    destroy: function() {
      this.wrapper.remove();
      this.element.show();
      $.Widget.prototype.destroy.call( this );
    }
  });
})(jQuery);


(function($) {
  $.widget( "ui.combobox_tags", {
    _create: function() {
      var input,
        self = this,
        select = this.element.hide(),
        selected = select.children( ":selected" ),
        value = selected.val() ? selected.text() : "",
        wrapper = this.wrapper = $( "<span>" )
          .addClass( "ui-combobox" )
          .insertAfter( select );

      input = $( "<input>" )
        .appendTo( wrapper )
        .val( value )
        .addClass( "ui-state-default ui-combobox-input" )
        .autocomplete({
          delay: 0,
          minLength: 0,
          autoFocus: true,
          source: function( request, response ) {
            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
            response( select.children( "option" ).map(function() {
              var text = $( this ).text();
              if ( this.value && ( !request.term || matcher.test(text) ) )
                return {
                  label: text.replace(
                    new RegExp(
                      "(?![^&;]+;)(?!<[^<>]*)(" +
                      $.ui.autocomplete.escapeRegex(request.term) +
                      ")(?![^<>]*>)(?![^&;]+;)", "gi"
                    ), "<strong>$1</strong>" ),
                  value: text,
                  option: this
                };
            }) );
          },
          select: function( event, ui ) {
            ui.item.option.selected = true;
            self._trigger( "selected", event, {
              item: ui.item.option
            });

            var name = ui.item.value;
            var id   = ui.item.option.value;
            var duplicate = false;

            var count = $(this).parent().siblings('.tags-container').children().length + 1;
            var obj_name = $(this).parent().siblings('.tags-container').attr('data-object-name');

            var html = '<div class="tag" data-object-id="'+ id +'">' +
                        '<input type="hidden" name="'+ obj_name +'['+count+']" value="'+ id +'"/>' +
                        '<span class="name"><a href="/wp-admin/post.php?post='+id+'&action=edit" target="_blank">'+ name +'</a></span>' +
                        '<span class="delete">X</span>' +
                     '</div>';

            $(this).parent().siblings('.tags-container').children().each(function(){
              if ($(this).attr('data-object-id') == id){
                duplicate = true;
              }
            });

            if (!duplicate) {
              if (id !== name) {
                $(this).parent().siblings('.tags-container').append(html);
              }
            }else {
              alert('This item is already in the list!');
            }

            $( this ).val( "" );
            select.val( "" );
            input.data( "uiAutocomplete" ).term = "";
            return false;

          },
          change: function( event, ui ) {

            if ( !ui.item ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
                valid = false;
              select.children( "option" ).each(function() {
                if ( $( this ).text().match( matcher ) ) {
                  this.selected = valid = true;
                  return false;
                }
              });

              if ( !valid ) {
                // remove invalid value, as it didn't match anything
                $( this ).val($(this).parent().prev().children(":first").val());
                select.val( "" );
                input.data( "uiAutocomplete" ).term = "";
                return false;
              }
            }
          }
        })
        .addClass( "ui-widget ui-widget-content ui-corner-left" );

      input.data( "uiAutocomplete" )._renderItem = function( ul, item ) {
        return $( "<li></li>" )
          .data( "item.autocomplete", item )
          .append( "<a>" + item.label + "</a>" )
          .appendTo( ul );
      };

      $( "<a>" )
        .attr( "tabIndex", -1 )
        .attr( "title", "Show All Items" )
        .appendTo( wrapper )
        .button({
          icons: {
            primary: "ui-icon-triangle-1-s"
          },
          text: false
        })
        .removeClass( "ui-corner-all" )
        .addClass( "ui-corner-right ui-combobox-toggle" )
        .click(function() {
          // close if already visible
          if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
            input.autocomplete( "close" );
            return;
          }

          // work around a bug (likely same cause as #5265)
          $( this ).blur();

          // pass empty string as value to search for, displaying all results
          input.autocomplete( "search", "" );
          input.focus();
        });
    },

    destroy: function() {
      this.wrapper.remove();
      this.element.show();
      $.Widget.prototype.destroy.call( this );
    }
  });

})(jQuery);


(function( $ ) {
 
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.color-picker').wpColorPicker();
    });
     
})( jQuery );

jQuery(document).ready(function($){
  
  $('#tmf-tabs a').click(function(e){
    e.preventDefault();
    var tab_id = $(this).attr('data-tab');

    $('#tmf-tabs a').removeClass('nav-tab-active');
    $('.tmf-tab').removeClass('active');
    
    $(this).addClass('nav-tab-active');
    $("#"+tab_id).addClass('active');
  });

  let url = window.location.href;
  // Run the code only on advanced settings page
  if(url && url.includes("page=tmf-advanced-settings")) {
    let elem = window.location.hash.replace('#', '');
    if(elem && $("#"+ elem)) {
      $('#tmf-tabs a').removeClass('nav-tab-active');
      $('.tmf-tab').removeClass('active');
      
      $("#tmf-tabs a.nav-tab[data-tab="+ elem +"]").addClass('nav-tab-active');
      $("#"+ elem).addClass('active');
    }
  }

});

// Toggle Accordions
jQuery(document).ready(function($){
  
  $('.tmf-admin-tab h2 button').on('click', function(){
    let toggleClass = jQuery(this).find('span');
    let parentItem = toggleClass.parents('.tmf-admin-tab');
    let tabContainer = parentItem.find('.tmf-tab-container');

    if(toggleClass.hasClass('dashicons-arrow-down-alt2')) {
      toggleClass.removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
      toggleClass.attr('aria-hidden', true);
      jQuery(this).attr('aria-expanded', false);
    } else {
      toggleClass.removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
      toggleClass.attr('aria-hidden', false);
      jQuery(this).attr('aria-expanded', true);
    }

    if(tabContainer.hasClass('toggle-trigger-hidden')) {
      tabContainer.removeClass('toggle-trigger-hidden').addClass('toggle-trigger');
    } else {
      tabContainer.removeClass('toggle-trigger').addClass('toggle-trigger-hidden');
    }

  });

});

// Post type re-ordering
jQuery(document).ready(function() {
  jQuery("#tmf-apply-field-to input").on('change', function() {
    let val = jQuery(this).val();

    if('selected' == val) {
      jQuery("#tmf-selected-terms").show();
    } else {
      jQuery("#tmf-selected-terms").hide();
    }
  });
});

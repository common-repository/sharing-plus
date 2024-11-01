/*
 * Sharing Plus js for WordPress admin
 * @since 1.0.0
 * @package ThemeCentury
 * @subpackage Sharing Plus
 */
(function($){
    'use strict';
    var winWidth, winHeight, Sharing_Plus;
    var tcy_document = $(document);
    Sharing_Plus = {
        // Repeater Library
        Repeater: function(){

            /*sortable*/
            var TEGREFRESHVALUE = function (wrapObject) {
                wrapObject.find('[name]').each(function(){
                    $(this).trigger('change');
                });
            };

            var TEGSORTABLE = function () {
                var repeaters = $('.te-repeater');
                repeaters.sortable({
                    orientation: "vertical",
                    items: '> .repeater-table',
                    placeholder: 'te-sortable-placeholder',
                    update: function( event, ui ) {
                        TEGREFRESHVALUE(ui.item);
                    }
                });
                repeaters.trigger("sortupdate");
                repeaters.sortable("refresh");
            };

            /*replace*/
            var TEGREPLACE = function( str, replaceWhat, replaceTo ){
                var re = new RegExp(replaceWhat, 'g');
                return str.replace(re,replaceTo);
            };

            var TEGREPEATER =  function (){
                tcy_document.on('click','.te-add-repeater',function (e) {
                    e.preventDefault();
                    var add_repeater = $(this),
                        repeater_wrap = add_repeater.closest('.te-repeater'),
                        code_for_repeater = repeater_wrap.find('.te-code-for-repeater'),
                        total_repeater = repeater_wrap.find('.te-total-repeater'),
                        total_repeater_value = parseInt( total_repeater.val() ),
                        repeater_html = code_for_repeater.html();

                    total_repeater.val( total_repeater_value +1 );
                    var final_repeater_html = TEGREPLACE( repeater_html, add_repeater.attr('id'),total_repeater_value );
                    add_repeater.before($('<div class="repeater-table"></div>').append( final_repeater_html ));
                    var new_html_object = add_repeater.prev('.repeater-table');
                    var repeater_inside = new_html_object.find('.te-repeater-inside');
                    repeater_inside.slideDown( 'fast',function () {
                        new_html_object.addClass( 'open' );
                        TEGREFRESHVALUE(new_html_object);
                    } );

                });
                tcy_document.on('click', '.te-repeater-top, .te-repeater-close', function (e) {
                    e.preventDefault();
                    var accordion_toggle = $(this),
                        repeater_field = accordion_toggle.closest('.repeater-table'),
                        repeater_inside = repeater_field.find('.te-repeater-inside');

                    if ( repeater_inside.is( ':hidden' ) ) {
                        repeater_inside.slideDown( 'fast',function () {
                            repeater_field.addClass( 'open' );
                        } );
                    }
                    else {
                        repeater_inside.slideUp( 'fast', function() {
                            repeater_field.removeClass( 'open' );
                        });
                    }
                });
                tcy_document.on('click', '.te-repeater-remove', function (e) {
                    e.preventDefault();
                    var repeater_remove = $(this),
                        repeater_field = repeater_remove.closest('.repeater-table'),
                        repeater_wrap = repeater_remove.closest('.te-repeater');

                    repeater_field.remove();
                    repeater_wrap.closest('form').trigger('change');
                    TEGREFRESHVALUE(repeater_wrap);
                });

                tcy_document.on('change', '.te-select', function (e) {
                    e.preventDefault();
                    var select = $(this),
                        repeater_inside = select.closest('.te-repeater-inside'),
                        postid = repeater_inside.find('.te-postid'),
                        repeater_control_actions = repeater_inside.find('.te-repeater-control-actions'),
                        optionSelected = select.find("option:selected"),
                        valueSelected = optionSelected.val();

                    if( valueSelected == 0 ){
                        postid.remove();
                    }
                    else{
                        postid.remove();
                        $.ajax({
                            type      : "GET",
                            data      : {
                                action: 'tcy_get_edit_post_link',
                                id: valueSelected
                            },
                            url       : ajaxurl,
                            beforeSend: function ( data, settings ) {
                                postid.remove();

                            },
                            success   : function (data) {
                                if( 0 != data ){
                                    repeater_control_actions.append( data );
                                }
                            },
                            error     : function (jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                            }
                        });
                    }
                });
            };

            tcy_document.on('widget-added widget-updated panelsopen', function( event, widgetContainer ) {
                TEGSORTABLE();
            });

            /*
             * Manually trigger widget-added events for media widgets on the admin
             * screen once they are expanded. The widget-added event is not triggered
             * for each pre-existing widget on the widgets admin screen like it is
             * on the customizer. Likewise, the customizer only triggers widget-added
             * when the widget is expanded to just-in-time construct the widget form
             * when it is actually going to be displayed. So the following implements
             * the same for the widgets admin screen, to invoke the widget-added
             * handler when a pre-existing media widget is expanded.
             */
            $( function initializeExistingWidgetContainers() {
                var widgetContainers;
                if ( 'widgets' !== window.pagenow ) {
                    return;
                }
                widgetContainers = $( '.widgets-holder-wrap:not(#available-widgets)' ).find( 'div.widget' );
                widgetContainers.one( 'click.toggle-widget-expanded', function toggleWidgetExpanded() {
                    TEGSORTABLE();
                });
            });
            TEGREPEATER();

        },
        //Custom Snipits goes here
        Snipits: {
            Variables: function(){
                winWidth = $(window).width();
                winHeight = $(window).height();
            },
            Append_HTML: function(){
                if(typeof tcy_theme_info_object != 'undefined'){
                    /* If there are required actions, add an icon with the number of required actions in the About sharing-plus-info page -> Actions recommended tab */
                    var count_actions_recommended = tcy_theme_info_object.count_actions_recommended;
                    if ( (typeof count_actions_recommended !== 'undefined') && (count_actions_recommended != '0') ) {
                        $('li.sharing-plus-info-w-red-tab a').append('<span class="sharing-plus-info-actions-count">' + count_actions_recommended + '</span>');
                    }
                }
            },

            Color_Picker: function(selector){
                var color_picker_option = {
                    change: function(event, ui){
                        selector.closest('form').trigger('change');
                    },
                };
                selector.wpColorPicker(color_picker_option);
            },

            ImageUpload: function(evt){
                // Prevents the default action from occuring.
                evt.preventDefault();
                var media_title = $(this).data('title');
                var media_button = $(this).data('button');
                var media_input_val = $(this).prev();
                var media_image_url_value = $(this).prev().prev().children('img');
                var media_image_url = $(this).siblings('.img-preview-wrap');

                var meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                    title: media_title,
                    button: { text:  media_button },
                    library: { type: 'image' }
                });

                // Opens the media library frame.
                meta_image_frame.open();

                // Runs when an image is selected.
                meta_image_frame.on('select', function(){

                    // Grabs the attachment selection and creates a JSON representation of the model.
                    var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

                    // Sends the attachment URL to our custom image input field.
                    media_input_val.val(media_attachment.url);
                    if( media_image_url_value != null ){
                        media_image_url_value.attr( 'src', media_attachment.url );
                        media_image_url.show();
                    }
                    media_input_val.trigger('change');
                });
            },

            WidgetTab: function(evt){
                if (!$(this).hasClass('nav-tab-active')) {
                    var tab_wraper, tab_id;
                    tab_id = $(this).data('id');
                    tab_wraper = $(this).closest('.sharing-plus-tab-wraper');
                    $(this).addClass('nav-tab-active').siblings('.nav-tab').removeClass('nav-tab-active');
                    tab_wraper.find('.sharing-plus-tab-content').removeClass('sharing-plus-content-active');
                    tab_wraper.find(tab_id).addClass('sharing-plus-content-active');
                }
            },

            Widget_Accordion: function(){
                var accordion_title = $(this).closest('.tcy-accordion-title');
                var is_checked = $(this).prop('checked');
                if(is_checked){
                    accordion_title.siblings('.tcy-accordion-content').slideDown().removeClass('open close');
                    accordion_title.find('.tcy-accordion-arrow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }else{
                    accordion_title.siblings('.tcy-accordion-content').slideUp().removeClass('open close');
                    accordion_title.find('.tcy-accordion-arrow').addClass('fa-angle-down').removeClass('fa-angle-up');
                }
            },

            Widget_Relation: function(evt){
                var relation_field = $(this);
                var current_value = relation_field.val();
                var relations = $(this).data('relations');
                if(!relations){
                    return;
                }
                if(relation_field.is(':checkbox')){
                    current_value = (relation_field.is(':checked')) ? current_value : 0;
                }
                console.log('Checkbox value is '+current_value);
                for(var relation_key in relations){
                    if(relation_key!=current_value){
                        continue;
                    }
                    var relation_details = relations[relation_key];
                    for(var action_key in relation_details){
                        var action_detils = relation_details[action_key];
                        var action_detail_class = action_detils.join(", .");
                        var action_class = '.'+action_detail_class;
                        switch(action_key){
                            case 'show_fields':
                                relation_field.closest('.widget-content').find(action_class).removeClass('tcy_hidden_field');
                                break;
                            case 'hide_fields':
                                relation_field.closest('.widget-content').find(action_class).addClass('tcy_hidden_field');
                                break;
                            default:
                                console.warn(relation_key + ' case is not defined');
                            break;
                        }
                    }
                }
            },

            CustomizerIcons: function(){
                var single_icon = $(this),
                    tcy_customize_icons = single_icon.closest( '.te-icons-wrapper' ),
                    icon_display_value = single_icon.children('i').attr('class'),
                    icon_split_value = icon_display_value.split(' '),
                    icon_value = icon_split_value[1];

                single_icon.siblings().removeClass('selected');
                single_icon.addClass('selected');
                tcy_customize_icons.find('.te-icon-value').val( icon_value );
                tcy_customize_icons.find('.icon-preview').html('<i class="' + icon_display_value + '"></i>');
                tcy_customize_icons.find('.te-icon-value').trigger('change');
            },

            IconToggle: function(){
                var icon_toggle = $(this),
                    tcy_customize_icons = icon_toggle.closest( '.te-icons-wrapper' ),
                    icons_list_wrapper = tcy_customize_icons.find( '.icons-list-wrapper' ),
                    dashicons = tcy_customize_icons.find( '.dashicons' );

                if ( icons_list_wrapper.is(':hidden') ) {
                    icons_list_wrapper.slideDown();
                    dashicons.removeClass('dashicons-arrow-down');
                    dashicons.addClass('dashicons-arrow-up');
                } else {
                    icons_list_wrapper.slideUp();
                    dashicons.addClass('dashicons-arrow-down');
                    dashicons.removeClass('dashicons-arrow-up');
                }
            },

            IconSearch: function(){
                var text = $(this),
                value = this.value,
                tcy_customize_icons = text.closest( '.te-icons-wrapper' ),
                icons_list_wrapper = tcy_customize_icons.find( '.icons-list-wrapper' );
                icons_list_wrapper.find('i').each(function () {
                    if ($(this).attr('class').search(value) > -1) {
                        $(this).parent('.single-icon').show();
                    } else {
                        $(this).parent('.single-icon').hide();

                    }
                });
            },
            Widget_Change: function(evt, widget){

                var __this = Sharing_Plus;
                var snipits = __this.Snipits;

                $(widget).find('.tcy_widget_relations').trigger('change');
                snipits.Color_Picker($(widget).find('.sharing-plus-color-picker'));
            },
            Sortable_Icons: function(){
                $("#sharing_plus_active_icons").sortable({
                    connectWith: "#sharing_plus_inactive_icons",
                    cursor: 'move',
                    update: function(event, ui){
                        var order = $("#sharing_plus_active_icons").sortable("toArray", {attribute: 'data-id' } );
                        $('#sharing_plus_icons_order').val( order.join(','));
                        $('#sharing_plus_networks\\[icon_selection\\]').val( order.join(','));
                    },
                });
                $("#sharing_plus_inactive_icons").sortable({
                    connectWith: "#sharing_plus_active_icons",
                    cursor: 'move'
                });
            },
        },     

        Click: function(){

            var __this = Sharing_Plus;
            var snipits = __this.Snipits;

            var image_upload = snipits.ImageUpload;
            tcy_document.on('click', '.media-image-upload', image_upload);

            var widget_tab = snipits.WidgetTab;
            tcy_document.on('click', '.sharing-plus-tab-list .nav-tab', widget_tab);

            var widget_relations = snipits.Widget_Relation;
            $(document).on('change', '.tcy_widget_relations', widget_relations);
            
            //for default load
            $('.tcy_widget_relations').trigger('change');

            // Runs when the image button is clicked.
            tcy_document.on('click','.media-image-remove', function(e){
                $(this).siblings('.img-preview-wrap').hide();
                $(this).prev().prev().val('');
            });

             /**
             * Script for Customizer icons
             */
            var customizer_icons = snipits.CustomizerIcons;
            tcy_document.on('click', '.te-icons-wrapper .single-icon', customizer_icons);

            var icon_toggle = snipits.IconToggle;
            tcy_document.on('click', '.te-icons-wrapper .icon-toggle ,.te-icons-wrapper .icon-preview', icon_toggle);

            var icon_search = snipits.IconSearch;
            tcy_document.on('keyup', '.te-icons-wrapper .icon-search', icon_search);

            var widget_accordion = snipits.Widget_Accordion;
            tcy_document.on('change', '.tcy-accordion-title input', widget_accordion);

            var widget_change = snipits.Widget_Change;
            tcy_document.on('widget-added widget-updated panelsopen', widget_change);

        },

        Ready: function(){
            var __this = Sharing_Plus;
            var snipits = __this.Snipits;
            //Library
            __this.Repeater();
            //This is multicommerce functions
            snipits.Variables();
            snipits.Append_HTML();
            snipits.Sortable_Icons();
            snipits.Color_Picker($('.sharing-plus-color-picker'));
            __this.Click();

        },

        Load: function(){

        },

        Resize: function(){

        },

        Scroll: function(){

        },

        Init: function(){
            var __this = Sharing_Plus;
            var docready = __this.Ready;
            var winload = __this.Load;
            var winresize = __this.Resize;
            var winscroll = __this.Scroll;
            $(document).ready(docready);
            $(window).load(winload);
            $(window).scroll(winscroll);
            $(window).resize(winresize);
        },

     };
     
     Sharing_Plus.Init();

})(jQuery);

// IIFE - Immediately Invoked Function Expression
(function($, window, document) {
    // Listen for the jQuery ready event on the document
    $(function(){

        // sidebar extra space.
        if (!$('#sharing_plus_sidebar\\[icon_space\\]').is(':checked')) {
            $('.container-sharing_plus_sidebar\\[icon_space_value\\]').css('display', 'none');
        }
        $('#sharing_plus_sidebar\\[icon_space\\]').on('change', function(event){
            if($(this).is(':checked')){
                $('.container-sharing_plus_sidebar\\[icon_space_value\\]').css('display', 'block');
            }else{
                $('.container-sharing_plus_sidebar\\[icon_space_value\\]').css('display', 'none');
            }
        });
        if (!$('#sharing_plus_inline\\[icon_space\\]').is(':checked')) {
            $('.container-sharing_plus_inline\\[icon_space_value\\]').css('display', 'none');
        }
        $('#sharing_plus_inline\\[icon_space\\]').on('change', function(event){
            if($(this).is(':checked')){
                $('.container-sharing_plus_inline\\[icon_space_value\\]').css('display', 'block');
            }else{
                $('.container-sharing_plus_inline\\[icon_space_value\\]').css('display', 'none');
            }
        });
        if (!$('#sharing_plus_media\\[icon_space\\]').is(':checked')) {
            $('.container-sharing_plus_media\\[icon_space_value\\]').css('display', 'none');
        }
        $('#sharing_plus_media\\[icon_space\\]').on('change', function(event) {
            if($(this).is(':checked')){
                $('.container-sharing_plus_media\\[icon_space_value\\]').css('display', 'block');
            }else{
                $('.container-sharing_plus_media\\[icon_space_value\\]').css('display', 'none');
            }
        });

        //widget  js
        $(document).on('click', '.sharing-plus-fb-token', function () {
            var facebook_content = $(this).closest('.tcy-accordion-content');
            var client_id = facebook_content.find('.facebook-app-id input').val().trim();
            var secret_key = facebook_content.find('.facebook-security-key input').val().trim();
            if ( 0 == client_id.length ) {
                facebook_content.find('.fb-error').text('Fb App id :  required');
                return false;
            }
            if ( 0 == secret_key.length ) {
                facebook_content.find('.fb-error').text('Fb Security key  :  required');
                return false;
            }

            $(fb_content).find('#token_loader').show();
            $.ajax({
                url: 'https://graph.facebook.com/oauth/access_token',
                data: {
                    client_id: client_id,
                    client_secret: secret_key,
                    grant_type: 'client_credentials'
                },
                dataType: 'json',
            }).done(function (data, textStatus, jqXHR) {
                //facebook_access_token.val( data.replace( 'access_token=' , '' ) );
                $(fb_content).find('.fb_access_token').val(data.access_token);
                $(fb_content).find('.fb-error').text('');
            }).fail(function (jqXHR, textStatus, errorThrown) {
                $(fb_content).find('.fb-error').text('Incorrect data, please check each field.' + '\n\n' + 'Info Message: ' + jqXHR.responseJSON.error.message);
            }).always(function (jqXHR, textStatus, errorThrown) {
                $(fb_content).find('#token_loader').hide();
            });
        });
        //end widget js;
    });
    // The rest of the code goes here!
}(jQuery, window, document));

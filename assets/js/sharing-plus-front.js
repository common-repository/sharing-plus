/*
 * Sharing Plus js for WordPress admin
 * @since 1.0.0
 * @package ThemeCentury
 * @subpackage Sharing Plus
 */

(function ($) {

    /**
     * Copyright 2012, Digital Fusion
     * Licensed under the MIT license.
     * http://teamdf.com/jquery-plugins/license/
     *
     * @author Sam Sehnert
     * @desc A small plugin that checks whether elements are within
     *     the user visible viewport of a web browser.
     *     only accounts for vertical position, not horizontal.
     */

    $.fn.visible = function (partial) {

        var $t = $(this),
            $w = $(window),
            viewTop = $w.scrollTop(),
            viewBottom = viewTop + $w.height(),
            _top = $t.offset().top,
            _bottom = _top + $t.height(),
            compareTop = partial === true ? _bottom : _top,
            compareBottom = partial === true ? _top : _bottom;

        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

    };

})(jQuery);
// IIFE - Immediately Invoked Function Expression

var Sharing_Plus_Plugin = Sharing_Plus_Plugin || {};


(function ($, window, document) {
  'use strict';


  function absint($int) {
    return parseInt($int, 10);
  }


  var sharing_plus_post_data = {};
  Sharing_Plus_Plugin.fetchFacebookShares = function() {
    /**
    * Run all the API calls
    */

    $.when(
      $.get('https://graph.facebook.com/?fields=og_object{likes.summary(true).limit(0)},share&id=' + sharing_plus_post_url),
      $.get('https://graph.facebook.com/?fields=og_object{likes.summary(true).limit(0)},share&id=' + sharing_plus_alternate_post_url )
    )
    .then(function(a, b) {

      if('undefined' !== typeof a[0].share) {
        var f1 = absint(a[0].share.share_count);
        var f2 = absint(a[0].share.comment_count);
        if('undefined' !== typeof a[0].og_object){
          var f3 = absint(a[0].og_object.likes.summary.total_count);
        } else {
          var f3 = 0;
        }
        var fShares = f1 + f2 + f3;
        if(sharing_plus_alternate_post_url) {
          if (typeof b[0].share !== 'undefined') {
            var f4 = absint(b[0].share.share_count);
            var f5 = absint(b[0].share.comment_count);
          } else {
            var f4 = 0, f5 = 0;
          }
          if (typeof b[0].og_object !== 'undefined') {
            var f6 = absint(b[0].og_object.likes.summary.total_count);
          } else {
            var f6 = 0
          }
          var fShares2 = f4 + f5 + f6;
          if (fShares !== fShares2) {
            fShares = fShares + fShares2;
          }
        }

          sharing_plus_post_data = {
              action: 'sharing_plus_facebook_shares_update',
              post_id: sharing_plus_post_id,
              share_counts: fShares
          };

          $.post(sharing_plus_admin_ajax, sharing_plus_post_data);
      }
    });
  }


    // Listen for the jQuery ready event on the document
    $(function () {

        // The DOM is ready!
        if ($('div[class*="sharing-plus-buttons-float"]').length > 0) {
            $('body').addClass('body_has_sharing_plus_buttons');
        }

    });

    $(window).load(function () {
        var allMods = $(".sharing_plus_buttons_inline");

        // Already visible modules
        allMods.each(function (i, el) {
            var el = $(el);
            if (el.visible(true)) {
                el.addClass('sharing-plus-buttons-inline-in');
            }
        });

        $(window).scroll(function (event) {

            allMods.each(function (i, el) {
                var el = $(el);
                if (el.visible(true)) {
                    el.addClass('sharing-plus-buttons-inline-in');
                }
            });

        });
        
        var sidebarwidth = $('div[class*="sharing-plus-buttons-float"]>a:first-child').outerWidth(true);
        $('div[class*="sharing-plus-buttons-float"]').css('width', sidebarwidth + 'px');
        
    });
    

}(window.jQuery, window, document));

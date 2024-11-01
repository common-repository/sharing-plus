<style>
.wp-sharing-plus-hidden{
  overflow: hidden;
}
.wp-sharing-plus-popup-overlay .wp-sharing-plus-internal-message{
  margin: 3px 0 3px 22px;
  display: none;
}
.wp-sharing-plus-reason-input{
  margin: 3px 0 3px 22px;
  display: none;
}
.wp-sharing-plus-reason-input input[type="text"]{
  width: 100%;
  display: block;
}
.wp-sharing-plus-popup-overlay{
  background: rgba(0,0,0, .8);
  position: fixed;
  top:0;
  left: 0;
  height: 100%;
  width: 100%;
  z-index: 1000;
  overflow: auto;
  visibility: hidden;
  opacity: 0;
  transition: opacity 0.3s ease-in-out:
}
.wp-sharing-plus-popup-overlay.wp-sharing-plus-active{
  opacity: 1;
  visibility: visible;
}
.wp-sharing-plus-serveypanel{
  width: 600px;
  background: #fff;
  margin: 65px auto 0;
}
.wp-sharing-plus-popup-header{
  background: #f1f1f1;
  padding: 20px;
  border-bottom: 1px solid #ccc;
}
.wp-sharing-plus-popup-header h2{
  margin: 0;
}
.wp-sharing-plus-popup-body{
  padding: 10px 20px;
}
.wp-sharing-plus-popup-footer{
  background: #f9f3f3;
  padding: 10px 20px;
  border-top: 1px solid #ccc;
}
.wp-sharing-plus-popup-footer:after{
  content:"";
  display: table;
  clear: both;
}
.action-btns{
  float: right;
}
.wp-sharing-plus-anonymous{
  display: none;
}
.attention, .error-message {
  color: red;
  font-weight: 600;
  display: none;
}
.wp-sharing-plus-spinner{
  display: none;
}
.wp-sharing-plus-spinner img{
  margin-top: 3px;
}

</style>

<div class="wp-sharing-plus-popup-overlay">
  <div class="wp-sharing-plus-serveypanel">
    <form action="#" method="post" id="wp-sharing-plus-deactivate-form">
      <div class="wp-sharing-plus-popup-header">
        <h2><?php _e( 'Quick feedback about Sharing Plus', 'sharing-plus' ); ?></h2>
      </div>
      <div class="wp-sharing-plus-popup-body">
        <h3><?php _e( 'If you have a moment, please let us know why you are deactivating:', 'sharing-plus' ); ?></h3>
        <ul id="wp-sharing-plus-reason-list">
          <li class="wp-sharing-plus-reason" data-input-type="" data-input-placeholder="">
            <label>
              <span>
                <input type="radio" name="wp-sharing-plus-selected-reason" value="1">
              </span>
              <span><?php _e( 'I only needed the plugin for a short period', 'sharing-plus' ); ?></span>
            </label>
            <div class="wp-sharing-plus-internal-message"></div>
          </li>
          <li class="wp-sharing-plus-reason has-input" data-input-type="textfield">
            <label>
              <span>
                <input type="radio" name="wp-sharing-plus-selected-reason" value="2">
              </span>
              <span><?php _e( 'I found a better plugin', 'sharing-plus' ); ?></span>
            </label>
            <div class="wp-sharing-plus-internal-message"></div>
            <div class="wp-sharing-plus-reason-input"><span class="message error-message"><?php _e( 'Kindly tell us the name of plugin', 'sharing-plus' ); ?></span><input type="text" name="better_plugin" placeholder="What's the plugin's name?"></div>
          </li>
          <li class="wp-sharing-plus-reason" data-input-type="" data-input-placeholder="">
            <label>
              <span>
                <input type="radio" name="wp-sharing-plus-selected-reason" value="3">
              </span>
              <span><?php _e( 'The plugin broke my site', 'sharing-plus' ); ?></span>
            </label>
            <div class="wp-sharing-plus-internal-message"></div>
          </li>
          <li class="wp-sharing-plus-reason" data-input-type="" data-input-placeholder="">
            <label>
              <span>
                <input type="radio" name="wp-sharing-plus-selected-reason" value="4">
              </span>
              <span><?php _e( 'The plugin suddenly stopped working', 'sharing-plus' ); ?></span>
            </label>
            <div class="wp-sharing-plus-internal-message"></div>
          </li>
          <li class="wp-sharing-plus-reason" data-input-type="" data-input-placeholder="">
            <label>
              <span>
                <input type="radio" name="wp-sharing-plus-selected-reason" value="5">
              </span>
              <span><?php _e( 'I no longer need the plugin', 'sharing-plus' ); ?></span>
            </label>
            <div class="wp-sharing-plus-internal-message"></div>
          </li>
          <li class="wp-sharing-plus-reason" data-input-type="" data-input-placeholder="">
            <label>
              <span>
                <input type="radio" name="wp-sharing-plus-selected-reason" value="6">
              </span>
              <span><?php _e( "It's a temporary deactivation. I'm just debugging an issue.", 'sharing-plus' ); ?></span>
            </label>
            <div class="wp-sharing-plus-internal-message"></div>
          </li>
          <li class="wp-sharing-plus-reason has-input" data-input-type="textfield" >
            <label>
              <span>
                <input type="radio" name="wp-sharing-plus-selected-reason" value="7">
              </span>
              <span><?php _e( 'Other', 'sharing-plus' ); ?></span>
            </label>
            <div class="wp-sharing-plus-internal-message"></div>
            <div class="wp-sharing-plus-reason-input"><span class="message error-message "><?php _e( 'Kindly tell us the reason so we can improve.', 'sharing-plus' ); ?></span><input type="text" name="other_reason" placeholder="Would you like to share what's other reason ?"></div>
          </li>
        </ul>
      </div>
      <div class="wp-sharing-plus-popup-footer">
        <label class="wp-sharing-plus-anonymous"><input type="checkbox" /><?php _e( 'Anonymous feedback', 'sharing-plus' ); ?></label>
        <input type="button" class="button button-secondary button-skip wp-sharing-plus-popup-skip-feedback" value="Skip &amp; Deactivate" >
        <div class="action-btns">
          <span class="wp-sharing-plus-spinner"><img src="<?php echo admin_url( '/images/spinner.gif' ); ?>" alt=""></span>
          <input type="submit" class="button button-secondary button-deactivate wp-sharing-plus-popup-allow-deactivate" value="Submit &amp; Deactivate" disabled="disabled">
          <a href="#" class="button button-primary wp-sharing-plus-popup-button-close"><?php esc_html_e( 'Cancel', 'sharing-plus' ); ?></a>

        </div>
      </div>
    </form>
  </div>
</div>


<script>
(function( $ ) {

  $(function() {

    var pluginSlug = 'sharing-plus';
    // Code to fire when the DOM is ready.

    $(document).on('click', 'tr[data-slug="' + pluginSlug + '"] .deactivate', function(e){
      e.preventDefault();

      $('.wp-sharing-plus-popup-overlay').addClass('wp-sharing-plus-active');
      $('body').addClass('wp-sharing-plus-hidden');
    });
    $(document).on('click', '.wp-sharing-plus-popup-button-close', function () {
      close_popup();
    });
    $(document).on('click', ".wp-sharing-plus-serveypanel,tr[data-slug='" + pluginSlug + "'] .deactivate",function(e){
      e.stopPropagation();
    });

    $(document).click(function(){
      close_popup();
    });
    $('.wp-sharing-plus-reason label').on('click', function(){
      if($(this).find('input[type="radio"]').is(':checked')){
        //$('.wp-sharing-plus-anonymous').show();
        $(this).next().next('.wp-sharing-plus-reason-input').show().end().end().parent().siblings().find('.wp-sharing-plus-reason-input').hide();
      }
    });
    $('input[type="radio"][name="wp-sharing-plus-selected-reason"]').on('click', function(event) {
      $(".wp-sharing-plus-popup-allow-deactivate").removeAttr('disabled');
    });
    $(document).on('submit', '#wp-sharing-plus-deactivate-form', function(event) {
      event.preventDefault();

      var _reason =  $(this).find('input[type="radio"][name="wp-sharing-plus-selected-reason"]:checked').val();
      var _reason_details = '';
      if ( _reason == 2 ) {
        _reason_details = $(this).find("input[type='text'][name='better_plugin']").val();
      } else if ( _reason == 7 ) {
        _reason_details = $(this).find("input[type='text'][name='other_reason']").val();
      }

      if ( ( _reason == 7 || _reason == 2 ) && _reason_details == '' ) {
        $('.message.error-message').show();
        return ;
      }

      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
          action        : 'sharing_plus_deactivate',
          reason        : _reason,
          reason_detail : _reason_details,
        },
        beforeSend: function(){
          $(".wp-sharing-plus-spinner").show();
          $(".wp-sharing-plus-popup-allow-deactivate").attr("disabled", "disabled");
        }
      })
      .done(function() {
        // $(".wp-sharing-plus-spinner").hide();
        // $(".wp-sharing-plus-popup-allow-deactivate").removeAttr("disabled");
        window.location.href =  $("tr[data-slug='"+ pluginSlug +"'] .deactivate a").attr('href');
      });

    });

    $('.wp-sharing-plus-popup-skip-feedback').on('click', function(e){
      window.location.href =  $("tr[data-slug='"+ pluginSlug +"'] .deactivate a").attr('href');
    })

    function close_popup() {
      $('.wp-sharing-plus-popup-overlay').removeClass('wp-sharing-plus-active');
      $('#wp-sharing-plus-deactivate-form').trigger("reset");
      $(".wp-sharing-plus-popup-allow-deactivate").attr('disabled', 'disabled');
      $(".wp-sharing-plus-reason-input").hide();
      $('body').removeClass('wp-sharing-plus-hidden');
      $('.message.error-message').hide();
    }
  });

})( jQuery ); // This invokes the function above and allows us to use '$' in place of 'jQuery' in our code.
</script>

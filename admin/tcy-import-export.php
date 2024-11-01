<?php
/**
 * SHARING_PLUS Import Export Page Content.
 * @link https://themecentury.com
 * @since 1.0.0
 * @package Theme Century
 * @subpackage Sharing Plus
 */
?>
<div class="sharing-plus-import-export-page">
  <h2><?php esc_html_e( 'Import/Export Simple Social Share Buttons Settings', 'sharing-plus' ); ?></h2>
  <div class=""><?php esc_html_e( "Import/Export your Social share button Settings for/from other sites.", 'sharing-plus' ); ?></div>
  <table class="form-table">
    <tbody>
      <tr class="import_setting">
        <th scope="row">
          <label for="sharing_plus_press_import"><?php esc_html_e( 'Import Settings:', 'sharing-plus' ); ?></label>
        </th>
        <td>
          <input type="file" name="sharing_plus_press_import" id="sharing_plus_press_import">
          <input type="button" class="button sharing-plus-import" value="<?php esc_html_e( 'Import', 'sharing-plus' ); ?>" disabled="disabled">
          <span class="import-sniper">
            <img src="<?php echo admin_url( 'images/wpspin_light.gif' ); ?>">
          </span>
          <span class="import-text"><?php esc_html_e( 'Sharing Plus Share Settings Imported Successfully.', 'sharing-plus' ); ?></span>
          <span class="wrong-import"></span>
          <p class="description"><?php esc_html_e( 'Select a file and click on Import to start processing.', 'sharing-plus' ); ?></p>
        </td>
      </tr>
      <tr class="export_setting">
        <th scope="row">
          <label for="sharing_plus_configure[export_setting]"><?php esc_html_e( 'Export Settings:', 'sharing-plus' ); ?></label>
        </th>
        <td>
          <input type="button" class="button sharing-plus-export" value="<?php esc_html_e( 'Export', 'sharing-plus' ); ?>">
          <span class="export-sniper">
            <img src="<?php echo admin_url( 'images/wpspin_light.gif' ); ?>">
          </span>
          <span class="export-text"><?php esc_html_e( 'Simple Social Button Settings Exported Successfully!', 'sharing-plus' ); ?></span>
          <p class="description"><?php esc_html_e( 'Export Simple Social Button Settings.', 'sharing-plus' ) ?></p>
        </td>
      </tr>
    </tbody>
  </table>
</div>


<script type="text/javascript">
(function($) {
  'use strict';
  $(".import-sniper").hide();
  $(".import-text").hide();
  $(".export-sniper").hide();
  $(".export-text").hide();
  // Remove Disabled attribute from Import Button.
  $( '#sharing_plus_press_import' ).on( 'change', function( event ) {

    event.preventDefault();

    var sharing_plus_file_tmp = $( '#sharing_plus_press_import' ).val();
    var sharing_plus_file_ext = sharing_plus_file_tmp.substr( sharing_plus_file_tmp.lastIndexOf('.') + 1 );

    $( '.sharing-plus-import' ).attr( "disabled", "disabled" );

    if ( 'json' == sharing_plus_file_ext ) {
      $(".import_setting .wrong-import").html("");
      $( '.sharing-plus-import' ).removeAttr( "disabled" );
    } else {
      $(".import_setting .wrong-import").html("Invalid File.");
    }
  });
  $('.sharing-plus-export').on('click',  function(event) {

    event.preventDefault();

    var dateObj = new Date();
    var month   = dateObj.getUTCMonth() + 1; //months from 1-12
    var day     = dateObj.getUTCDate();
    var year    = dateObj.getUTCFullYear();
    var newdate = year + "-" + month + "-" + day;

    $.ajax({

      url: ajaxurl,
      type: 'POST',
      data: {
        action : 'sharing_plus_export',
      },
      beforeSend: function() {
        $(".export_setting .export-sniper").show();
      },
      success: function( response ) {

        $(".export_setting .export-sniper").hide();
        $(".export_setting .export-text").show();

        if ( ! window.navigator.msSaveOrOpenBlob ) { // If msSaveOrOpenBlob() is supported, then so is msSaveBlob().
          $("<a />", {
            "download" : "sharing-plus-export-"+newdate+".json",
            "href" : "data:application/json;charset=utf-8," + encodeURIComponent( response ),
          }).appendTo( "body" )
          .click(function() {
            $(this).remove()
          })[0].click()
        } else {
          var blobObject = new Blob( [response] );
          window.navigator.msSaveBlob( blobObject, "sharing-plus-export-"+newdate+".json" );
        }

        setTimeout(function() {
          $(".export_setting .export-text").fadeOut()
        }, 3000 );
      }
    });
  });

  $('.sharing-plus-import').on( 'click', function(event){
    
    event.preventDefault();

    var file    = $('#sharing_plus_press_import');
    var fileObj = new FormData();
    var content = file[0].files[0];

    fileObj.append( 'file', content );
    fileObj.append( 'action', 'sharing_plus_import' );

    $.ajax({

      processData: false,
      contentType: false,
      url: ajaxurl,
      type: 'POST',
      data: fileObj, // file and action append into variable fileObj.
      beforeSend: function() {
        $(".import_setting .import-sniper").show();
        $(".import_setting .wrong-import").html("");
        $( '.sharing-plus-import' ).attr( "disabled", "disabled" );
      },
      success: function(response) {
        console.log(response);
        $(".import_setting .import-sniper").hide();
        // $(".import_setting .import-text").fadeIn();
        if ( 'error' == response ) {
          $(".import_setting .wrong-import").html("JSON File is not Valid.");
        } else {
          $(".import_setting .import-text").show();
          setTimeout( function() {
            $(".import_setting .import-text").fadeOut();
            // $(".import_setting .wrong-import").html("");
            file.val('');
          }, 3000 );
        }

      }
    }); //!ajax.
  });
})(jQuery); // This invokes the function above and allows us to use '$' in place of 'jQuery' in our code.
</script>

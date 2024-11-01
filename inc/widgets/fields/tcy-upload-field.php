<?php
$output = '';
$id     = esc_attr( $instance->get_field_id( $tcy_widgets_name ) );
$class  = '';
$int    = '';
$value  = $athm_field_value;
$name   = esc_attr( $instance->get_field_name( $tcy_widgets_name ) );

if ( $value ) {
	$class = ' has-file';
	$value = explode( 'wp-content', $value );
	$value = content_url() . $value[1];
}
$title = '';
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
?>
<div class="tcy-widget-field-wrapper sub-option widget-upload <?php echo esc_attr($tcy_wraper_class); ?>">
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>"><?php echo esc_html( $tcy_widgets_title ); ?></label>
	<input id="<?php echo $id; ?>" class="upload<?php echo $class; ?>" type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="<?php esc_html_e( 'No file chosen', 'sharing-plus' ); ?>" />
	<?php
	if ( function_exists( 'wp_enqueue_media' ) ) {
		if ( ( $value == '' ) ) {
			?>
			<input id="upload-<?php echo $id; ?>" class="wid-upload-button button" type="button" value="<?php echo esc_html__( 'Upload', 'sharing-plus' ); ?>" />
			<?php
		} else {
			?>
			<input id="remove-<?php echo $id; ?>" class="wid-remove-file button" type="button" value="<?php echo esc_html__( 'Remove', 'sharing-plus' ); ?>" />
			<?php 
		}
	} else {
		?>
		<p><i><?php esc_html_e( 'Upgrade your version of WordPress for full media support.', 'sharing-plus' ); ?></i></p>
		<?php
	}
	?>
	<div class="screenshot upload-thumb" id="<?php echo $id; ?>-image">
		<?php
		if ( $value != '' ) {
			$remove = '<a class="remove-image">' . esc_html__( 'Remove', 'sharing-plus' ) . '</a>';
			$image  = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
			if ( $image ) {
				?>
				<img src="<?php echo esc_url($value); ?>" alt="<?php echo esc_attr__( 'Upload image', 'sharing-plus' ); ?>" />
				<?php
			} else {
				$parts = explode( "/", $value );
				for ( $i = 0; $i < sizeof( $parts ); ++ $i ) {
					$title = $parts[ $i ];
				}

				// Standard generic output if it's not an image.
				
				?>
				<div class="no-image"><span class="file_link"><a href="<?php echo $value; ?>" target="_blank" rel="external"><?php esc_html_e( 'View File', 'sharing-plus' ); ?></a></span></div><?php
			}
		}
		?>
	</div>
</div>
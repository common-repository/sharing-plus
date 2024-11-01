<?php
	$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
?>
<p class="tcy-widget-field-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>">
		<?php echo esc_html( $tcy_widgets_title ); ?>:
	</label>
	<input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $tcy_widgets_name ) ); ?>" type="text" value="<?php echo esc_html( $athm_field_value ); ?>"/>
	<?php if ( isset( $tcy_widgets_description ) ) { ?>
		<br/>
		<small><?php echo $tcy_widgets_description; ?></small>
	<?php } ?>
</p>
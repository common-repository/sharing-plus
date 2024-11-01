<?php
if ( empty( $athm_field_value ) ) {
	$athm_field_value = $tcy_widgets_default;
}
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
?>
<p class="tcy-widget-field-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>">
		<?php echo esc_html( $tcy_widgets_title ); ?>:
	</label><br/>
	<input class="widefat" name="<?php echo esc_attr( $instance->get_field_name( $tcy_widgets_name ) ); ?>" type="number" step="1" min="1" id="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>" value="<?php echo esc_html( $athm_field_value ); ?>"/>
	<?php if ( isset( $tcy_widgets_description ) ) { ?>
		<br/>
		<small><?php echo esc_html( $tcy_widgets_description ); ?></small>
	<?php } ?>
</p>
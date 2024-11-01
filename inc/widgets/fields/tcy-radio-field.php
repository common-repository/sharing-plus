<?php
if ( empty( $athm_field_value ) ) {
	$athm_field_value = $tcy_widgets_default;
}
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
?>
<p class="tcy-widget-field-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>">
		<?php echo esc_html( $tcy_widgets_title ); ?>:
	</label>
	<div class="radio-wrapper">
		<?php
			foreach ( $tcy_widgets_field_options as $athm_option_name => $athm_option_title ){
		?>
			<input id="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $tcy_widgets_name ) ); ?>" type="radio" value="<?php echo esc_html( $athm_option_name ); ?>" <?php checked( $athm_option_name, $athm_field_value ); ?> />
				<label for="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>"><?php echo esc_html( $athm_option_title ); ?>:</label>
		<?php } ?>
	</div>
	<?php if ( isset( $tcy_widgets_description ) ) { ?>
		<small><?php echo esc_html( $tcy_widgets_description ); ?></small>
	<?php } ?>
</p>
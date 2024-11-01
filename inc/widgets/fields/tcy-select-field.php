<?php
if ( empty( $athm_field_value ) ) {
	$athm_field_value = $tcy_widgets_default;
}
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
$tcy_widget_relations = isset($tcy_widget_relations) ? $tcy_widget_relations : array();
$tcy_relations_json = wp_json_encode( $tcy_widget_relations);
$tcy_select_class = '';
if($tcy_widget_relations){
	$tcy_select_class =  'tcy_widget_relations';
}
?>
<p class="tcy-widget-field-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>">
		<?php echo esc_html( $tcy_widgets_title ); ?>:
	</label>
	<select name="<?php echo esc_attr( $instance->get_field_name( $tcy_widgets_name ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>" class="widefat <?php echo esc_attr($tcy_select_class); ?>" data-relations="<?php echo esc_attr($tcy_relations_json) ?>">
		<?php foreach ( $tcy_widgets_field_options as $athm_option_name => $athm_option_title ) { ?>
			<option value="<?php echo esc_attr( $athm_option_name ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>" <?php selected( $athm_option_name, $athm_field_value ); ?>>
				<?php echo esc_html( $athm_option_title ); ?>
			</option>
		<?php } ?>
	</select>
	<?php if ( isset( $tcy_widgets_description ) ) { ?>
		<br/>
		<small><?php echo esc_html( $tcy_widgets_description ); ?></small>
	<?php } ?>
</p>
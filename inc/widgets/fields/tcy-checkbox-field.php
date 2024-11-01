<?php
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
$tcy_widget_relations = isset($tcy_widget_relations) ? $tcy_widget_relations : array();
$tcy_relations_json = wp_json_encode( $tcy_widget_relations);
$tcy_relation_class = ($tcy_widget_relations) ? 'tcy_widget_relations' : '';
?>
<p class="tcy-widget-field-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<input class="<?php echo esc_attr($tcy_relation_class); ?>" id="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $tcy_widgets_name ) ); ?>" type="checkbox" value="1" <?php checked( '1', $athm_field_value ); ?> data-relations="<?php echo esc_attr($tcy_relations_json) ?>"/>
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>">
		<?php echo esc_html( $tcy_widgets_title ); ?>
	</label>
	<?php if ( isset( $tcy_widgets_description ) ) { ?>
		<br/>
		<small><?php echo wp_kses_post( $tcy_widgets_description ); ?></small>
	<?php } ?>
</p>
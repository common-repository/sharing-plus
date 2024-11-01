<?php
$tcy_widgets_accordion = isset($widget_field['tcy_widgets_accordion']) ? $widget_field['tcy_widgets_accordion'] : array();
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
$all_values = get_option('widget_' . $instance->id_base);
$this_widget_instance = isset($all_values[$instance->number]) ? $all_values[$instance->number] : array();
$athm_field_value = (array)$athm_field_value;
?>
<div class="tcy-widget-field-wrapper tcy-widget-accordion-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<?php
	if( count( $tcy_widgets_accordion ) > 0 && is_array( $tcy_widgets_accordion ) ){ 
		foreach ($tcy_widgets_accordion as $accordion_key=>$accordion_details){
			$is_dropdown = in_array($accordion_key, $athm_field_value);
			$tcy_accordion_title = isset($accordion_details['tcy_accordion_title']) ? esc_html($accordion_details['tcy_accordion_title']) : '';
			$tcy_accordion_fields = isset($accordion_details['tcy_accordion_fields']) ? $accordion_details['tcy_accordion_fields'] : array();
			$accordion_wraper_class = ($is_dropdown) ? 'open' : 'closed';
			$accordion_icon_class = ($is_dropdown) ? 'fa-angle-up' : 'fa-angle-down';
			?>
			<div class="tcy-accordion-wrapper <?php echo esc_attr($accordion_wraper_class); ?>">
				<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name.$accordion_key ) ); ?>" class="tcy-accordion-title"><?php esc_html($tcy_accordion_title); ?>
					<?php echo esc_html($tcy_accordion_title); ?><i class="tcy-accordion-arrow fa <?php echo esc_attr($accordion_icon_class); ?>"></i>
					<input id="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name.$accordion_key ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $tcy_widgets_name ) ); ?>[]" value="<?php echo esc_attr($accordion_key); ?>" <?php checked( 1, $is_dropdown ) ?> class="sharing-plus-hidden" type="checkbox">
				</label>
				<div class="tcy-accordion-content">
					<?php
					if(count($tcy_accordion_fields)):
					foreach($tcy_accordion_fields as $field_key=>$accordion_field):
						$current_widgets_field_default = isset($accordion_field['tcy_widgets_default']) ? $accordion_field['tcy_widgets_default'] : '';
						$current_field_widget_name = isset($accordion_field['tcy_widgets_name']) ? $accordion_field['tcy_widgets_name'] : '';

						if(!$current_field_widget_name){
							return;
						}
						$current_widgets_field_value = isset($this_widget_instance[$current_field_widget_name]) ? $this_widget_instance[$current_field_widget_name] : $current_widgets_field_default;
						tcy_widgets_show_widget_field( $instance, $accordion_field, $current_widgets_field_value );
					endforeach;
				else:
					?>
					<p><?php esc_html_e('Sorry no field are added on accordion.', 'sharing-plus'); ?></p>
					<?php
				endif;
					?>
				</div>
			</div>
			<?php
		}

	}else{
		?>
			<p><?php esc_html_e('There is no accordion on this accordion group', 'sharing-plus'); ?></p>
		<?php
	}
	?>
	<?php if ( isset( $tcy_widgets_description ) ) { ?>
		<br/>
		<small><?php echo wp_kses_post( $tcy_widgets_description ); ?></small>
	<?php } ?>
</div>
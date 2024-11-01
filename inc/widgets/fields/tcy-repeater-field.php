<?php
$repeater_row_title = isset($widget_field['repeater_row_title']) ? $widget_field['repeater_row_title'] : esc_html__('Row', 'sharing-plus');
$repeater_add_new_label = isset($widget_field['tcy_add_new_label']) ? $widget_field['tcy_add_new_label'] : esc_html__('Add row', 'sharing-plus');
$repeater_row_fields = isset($widget_field['repeater']) ? $widget_field['repeater'] : array();
$coder_repeater_depth = 'coderRepeaterDepth_'.'0';
$tcy_wraper_class = isset($tcy_wraper_class) ? $tcy_wraper_class : '';
?>
<div class="tcy-widget-field-wrapper <?php echo esc_attr($tcy_wraper_class); ?>">
	<label for="<?php echo esc_attr( $instance->get_field_id( $tcy_widgets_name ) ); ?>">
		<?php echo esc_html( $tcy_widgets_title ); ?>:
	</label>
	<div class="te-repeater">
		<?php
		$repeater_count = 0;
		if( count( $athm_field_value ) > 0 && is_array( $athm_field_value ) ){

			foreach ($athm_field_value as $repeater_key=>$repeater_details){
				
				?>
				<div class="repeater-table">
					<div class="te-repeater-top">
						<div class="te-repeater-title-action">
							<button type="button" class="te-repeater-action">
								<span class="te-toggle-indicator" aria-hidden="true"></span>
							</button>
						</div>
						<div class="te-repeater-title">
							<h3><?php echo esc_attr($repeater_row_title); ?><span class="in-te-repeater-title"></span></h3>
						</div>
					</div>
					<div class='te-repeater-inside hidden'>
						<?php
						foreach($repeater_row_fields as $repeater_slug => $repeater_data){

							$field_name = isset($repeater_data['tcy_repeater_name']) ? $repeater_data['tcy_repeater_name'] : '__not_found__';
							$repeater_field_id  = $instance->get_field_id( $tcy_widgets_name).$repeater_count.$field_name;
							$repeater_field_name  = $instance->get_field_name( $tcy_widgets_name ).'['.$repeater_count.']['.$field_name.']';
							$repeater_field_type = (isset($repeater_data['tcy_repeater_field_type'])) ? $repeater_data['tcy_repeater_field_type'] : '';
							$repeater_field_title = (isset($repeater_data['tcy_repeater_title'])) ? $repeater_data['tcy_repeater_title'] : '';
							$inner_wraper_class = isset($repeater_data['tcy_wraper_class']) ? $repeater_data['tcy_wraper_class'] : '';
							$tcy_repeater_default = isset($repeater_data['tcy_repeater_default']) ? $repeater_data['tcy_repeater_default'] : '';

							switch ( $repeater_field_type ) {
							// Standard url field
								case 'url':
								?>
								<p class="<?php echo esc_attr($inner_wraper_class); ?>">
									<label for="<?php echo esc_attr( $repeater_field_id ); ?>"><?php echo $repeater_field_title; ?></label>
									<input type="url" class="widefat" name="<?php echo esc_attr( $repeater_field_name ); ?>" id="<?php echo esc_attr( $repeater_field_id ); ?>" value="<?php echo esc_url( $repeater_details[$field_name] ); ?>" />
								</p>
								<?php
								break;
								// Standard upload field
								case 'upload':
								?>
								<p class="<?php echo esc_attr($inner_wraper_class); ?>">
									<span class="img-preview-wrap" <?php echo empty( $repeater_details[$field_name] ) ? 'style="display:none;"' : ''; ?>>
										<img class="widefat" src="<?php echo esc_url( $repeater_details[$field_name] ); ?>" alt="<?php esc_attr_e( 'Image preview', 'sharing-plus' ); ?>"  />
									</span>
									<!-- .img-preview-wrap -->
									<input type="text" class="widefat" name="<?php echo esc_attr( $repeater_field_name ); ?>" id="<?php echo esc_attr( $repeater_field_id ); ?>" value="<?php echo esc_url( $repeater_details[$field_name] ); ?>" />
									<input type="button" value="<?php esc_attr_e( 'Upload Image', 'sharing-plus' ); ?>" class="button media-image-upload" data-title="<?php esc_attr_e( 'Select Image','sharing-plus'); ?>" data-button="<?php esc_attr_e( 'Select Image','sharing-plus'); ?>"/>
									<input type="button" value="<?php esc_attr_e( 'Remove Image', 'sharing-plus' ); ?>" class="button media-image-remove" />
								</p>
								<?php
								break;
								default:
								
								$widget_field = array(
									'tcy_widgets_name'          => $tcy_widgets_name.'['.$repeater_count.']['.$field_name.']',
									'tcy_wraper_class'=> $inner_wraper_class,
									'tcy_widgets_title'         => $repeater_field_title,
									'tcy_widgets_default'       => $tcy_repeater_default,
									'tcy_widgets_field_type'    => $repeater_field_type,
								);
								$tcy_repeater_field_value = isset($repeater_details[$field_name]) ? $repeater_details[$field_name] : '';
								tcy_widgets_show_widget_field( $instance, $widget_field, $tcy_repeater_field_value);
								break;
							}
						}
						?>
						<div class="te-repeater-control-actions">
							<button type="button" class="button-link button-link-delete te-repeater-remove"><?php esc_html_e('Remove','sharing-plus');?></button> |
							<button type="button" class="button-link te-repeater-close"><?php esc_html_e('Close','sharing-plus');?></button>
						</div>
					</div>
				</div>
				<?php
				$repeater_count++;
			}
		}

		?>
		<script type="text/html" class="te-code-for-repeater">
			<div class="repeater-table">
				<div class="te-repeater-top">
					<div class="te-repeater-title-action">
						<button type="button" class="te-repeater-action">
							<span class="te-toggle-indicator" aria-hidden="true"></span>
						</button>
					</div>
					<div class="te-repeater-title">
						<h3><?php echo esc_attr($repeater_row_title); ?><span class="in-te-repeater-title"></span></h3>
					</div>
				</div>
				<div class='te-repeater-inside hidden'>
					<?php
					foreach($repeater_row_fields as $repeater_slug => $repeater_data){

						$field_name = isset($repeater_data['tcy_repeater_name']) ? $repeater_data['tcy_repeater_name'] : '__not_found__';
						$repeater_field_id  = $instance->get_field_id( $tcy_widgets_name).$field_name;
						$repeater_field_name  = $instance->get_field_name( $tcy_widgets_name ).'['.$coder_repeater_depth.']['.$field_name.']';
						$repeater_field_type = (isset($repeater_data['tcy_repeater_field_type'])) ? $repeater_data['tcy_repeater_field_type'] : '';
						$repeater_field_title = (isset($repeater_data['tcy_repeater_title'])) ? $repeater_data['tcy_repeater_title'] : '';
						$repeater_default_value = (isset($repeater_data['tcy_repeater_default'])) ? $repeater_data['tcy_repeater_default'] : '';
						$inner_wraper_class = isset($repeater_data['tcy_wraper_class']) ? $repeater_data['tcy_wraper_class'] : '';

						switch ( $repeater_field_type ) {
							// Standard text field
							case 'url':
							?>
							<p class="<?php echo esc_attr($inner_wraper_class); ?>">
								<label for="<?php echo esc_attr( $repeater_field_id ); ?>"><?php echo $repeater_field_title; ?></label>
								<input type="url" class="widefat" name="<?php echo esc_attr( $repeater_field_name ); ?>" id="<?php echo esc_attr( $repeater_field_id ); ?>" value="<?php echo esc_url($repeater_default_value); ?>" />
							</p>
							<?php
							break;
							// Standard url field
							case 'upload':
							?>
							<p class="<?php echo esc_attr($inner_wraper_class); ?>">
								<span class="img-preview-wrap" <?php echo empty( $repeater_details[$field_name] ) ? 'style="display:none;"' : ''; ?>>
									<img class="widefat" src="<?php echo esc_url( $repeater_default_value ); ?>" alt="<?php esc_attr_e( 'Image preview', 'sharing-plus' ); ?>"  />
								</span>
								<!-- .img-preview-wrap -->
								<input type="text" class="widefat" name="<?php echo esc_attr( $repeater_field_name ); ?>" id="<?php echo esc_attr( $repeater_field_id ); ?>" value="<?php echo esc_url($repeater_default_value); ?>" />
								<input type="button" value="<?php esc_attr_e( 'Upload Image', 'sharing-plus' ); ?>" class="button media-image-upload" data-title="<?php esc_attr_e( 'Select Image','sharing-plus'); ?>" data-button="<?php esc_attr_e( 'Select Image','sharing-plus'); ?>"/>
								<input type="button" value="<?php esc_attr_e( 'Remove Image', 'sharing-plus' ); ?>" class="button media-image-remove" />
							</p>
							<?php
							break;
							default:

							$widget_field = array(
								'tcy_widgets_name'          => $tcy_widgets_name.'['.$coder_repeater_depth.']['.$field_name.']',
								'tcy_widgets_title'         => $repeater_field_title,
								'tcy_widgets_default'       => $repeater_default_value,
								'tcy_widgets_field_type'    => $repeater_field_type,
							);
							tcy_widgets_show_widget_field( $instance, $widget_field, $repeater_default_value );
							break;
						}
					}
					?>
					<div class="te-repeater-control-actions">
						<button type="button" class="button-link button-link-delete te-repeater-remove"><?php esc_html_e('Remove','sharing-plus');?></button> |
						<button type="button" class="button-link te-repeater-close"><?php esc_html_e('Close','sharing-plus');?></button>
					</div>
				</div>
			</div>
		</script>

		<input class="te-total-repeater" type="hidden" value="<?php echo esc_attr( $repeater_count ) ?>">
		<span class="button-primary te-add-repeater" id="<?php echo esc_attr( $coder_repeater_depth ); ?>"><?php echo $repeater_add_new_label; ?></span><br/>

	</div>
	<?php if ( isset( $tcy_widgets_description ) ) { ?>
		<small><?php echo esc_html( $tcy_widgets_description ); ?></small>
	<?php } ?>
</div>